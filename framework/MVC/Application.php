<?php

/*
 * Copyright (C) 2015 cagatay
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Framework\MVC;

/**
 * Description of Application
 *
 * @author cagatay
 */
use Framework\Services\ConfigurationService;
use Framework\ServiceManager\ServiceManager;
use Framework\MVC\Response\Response;
use Framework\MVC\Request\Request;
use Framework\MVC\Router\RouterInterface;

class Application implements ApplicationInterface {

    protected $configurationService;
    protected $serviceManager;
    protected $request;
    protected $response;

    /**
     * Init the application
     *
     * @return self
     */
    public static function init(array $config = array()) {
        $application = new Application();
        $application->setConfig($config);
        return $application;
    }

    protected function setConfig($config) {
        $this->configurationService = new ConfigurationService();
        $this->configurationService->setConfig($config);
    }

    protected function getConfig() {
        return $this->configurationService->getConfig();
    }

    /**
     * Get the Controller manager object
     *
     * @return \Framework\MVC\Controller\ControllerManagerInterface
     */
    public function getControllerManager() {
        return $this->getServiceManager()->get('ControllerManager');
    }

    /**
     * Get the locator object
     *
     * @return \Framework\ServiceManager\ServiceManagerInterface
     */
    public function getServiceManager() {
        if (!$this->serviceManager) {
            $this->serviceManager = new ServiceManager($this->configurationService);
        }
        return $this->serviceManager;
    }

    /**
     * Get Response
     *
     * @return \Framework\MVC\Response\Response
     */
    public function getResponse() {
        /*
         * If not set initiate a new Response object
         */
        if (!$this->response) {
            $this->response = new Response();
        }
        return $this->response;
    }

    public function setResponse(Response $response) {
        $this->response = $response;
    }

    /**
     * Get Request
     *
     * @return Request
     */
    public function getRequest() {
        return $this->request;
    }

    public function setRequest(Request $request) {
        $this->request = $request;
    }

    /**
     * Run the application
     *
     * @return self
     */
    public function run(Request $request = null) {

        $this->setRequest((!$request ? Request::factory() : $request));
        $config = $this->getConfig();

        /**
         * @var RouterInterface
         */
        $router = $this->getServiceManager()->get('Router');
        $router->addRoutes($config['routes']);

        if (($match = $router->match($this->getRequest())) !== false) {
            try {
                $controllerName = $match->getController();
                $actionName = $match->getAction();
                $params = $match->getParams();

                $controller = $this->getControllerManager()->get($controllerName);
                $controller->setParams($params);
                $callableActionName = $actionName . 'Action';
                if (is_callable(array($controller, $callableActionName))) {

                    $controller->setRequest($this->getRequest());
                    $controller->setResponse($this->getResponse());

                    $viewModel = call_user_func(array($controller, $callableActionName));
                    $this->setResponse(new Response());
                    if (!$viewModel instanceof ViewModel\ViewModelInterface && !is_array($viewModel)) {
                        throw new \Framework\Exception\ControllerException('Controller should return ViewModelInterface or array.');
                    }
                    if (!$viewModel instanceof ViewModel\ViewModelInterface && is_array($viewModel)) {
                        $viewModel = $this->viewModelFactory($viewModel);
                    }
                    $this->getResponse()->setContent($viewModel->render());
                    if (!$this->getResponse()->getStatusCode()) {
                        $this->getResponse()->setStatusCode(200); //default
                    }
                    $this->printResponse();
                } else {
                    throw new \Framework\Exception\ControllerException('Action ' . $actionName . ' could not be executed on the controller');
                }
            } catch (\Exception $e) {
                $this->catchError($e);
            }
        } else {
            $this->setResponse(new Response());
            $this->getResponse()->setContent('Not found');
            $this->getResponse()->setStatusCode(404);
        }

        return $this;
    }

    protected function catchError(\Exception $e) {
        $viewModel = $this->viewModelFactory(array(
            'code' => $e->getCode(),
            'message' => $e->getMessage()
        ));

        $this->setResponse($this->getResponseByViewModel($viewModel));
        $this->getResponse()->setStatusCode($e->getCode());
    }

    protected function viewModelFactory(array $data) {
        switch ($this->getRequest()->getAcceptedFormat()) {
            case Request::ACCEPT_XML:
                $vm = new ViewModel\XMLViewModel();
                break;
            case Request::ACCEPT_JSON:
                $vm = new ViewModel\JSONViewModel();
                break;
        }
        $vm->setData($data);
        return $vm;
    }

    protected function getResponseByViewModel(ViewModel\ViewModelInterface $viewModel) {
        $response = new Response();
        $response->setContent($viewModel->render());
        return $response;
    }

    protected function printResponse() {
        if (!$this->getRequest()->isHttpRequest()) {
            return false;
        }
        
        http_response_code($this->getResponse()->getStatusCode());
        echo $this->getResponse()->getContent();
        return true;
    }

}
