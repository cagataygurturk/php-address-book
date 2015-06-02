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
     * Init the application, inject the configuration array and return the instance
     * 
     *
     * @return self
     */
    public static function init(array $config = array()) {
        $application = new Application();
        $application->setConfig($config);
        $application->serviceManager = new ServiceManager($application->configurationService);
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
        return $this->serviceManager;
    }

    /**
     * Get Response
     *
     * @return \Framework\MVC\Response\Response
     */
    public function getResponse() {
        /*
         * If not set, initiate a new Response object, never returns null
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

    /**
     * Set Request for the application lifecycle
     *
     * @param  Request $request Request
     * @return void
     */
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
            /*
             * Router matches a controller
             */
            try {
                $controllerName = $match->getController();
                $actionName = $match->getAction();
                $params = $match->getParams();

                $controller = $this->getControllerManager()->get($controllerName);
                $controller->setParams($params);
                $callableActionName = $actionName . 'Action';
                if (is_callable(array($controller, $callableActionName))) {
                    /*
                     * Matched action exists in the matched controller class
                     */


                    /* We inject the request and response to the controller
                     * By this way the controller has access to these two important stuff
                     */
                    $controller->setRequest($this->getRequest());
                    $controller->setResponse($this->getResponse());

                    /*
                     * Call the action and get the result
                     */
                    $viewModel = call_user_func(array($controller, $callableActionName));

                    if (!$viewModel instanceof Response) {
                        if (!$viewModel instanceof ViewModel\ViewModelInterface && !is_array($viewModel)) {
                            throw new \Framework\Exception\ControllerException('Controller should return Response, ViewModelInterface or array.');
                        }
                        if (!$viewModel instanceof ViewModel\ViewModelInterface && is_array($viewModel)) {
                            /* When controller returns array we must interpret the Accept-type header of the request
                             * and decide which type of ViewModel we need
                             * Here ViewModel\ViewModelFactory implements Factory Pattern
                             * to accomplish this
                             */
                            $vm = ViewModel\ViewModelFactory::getViewModel($this->getRequest());
                            $vm->setData($viewModel);
                            $viewModel = $vm;
                        }
                        $this->getResponse()->setContent($viewModel->render());
                    }
                    if (!$this->getResponse()->getStatusCode()) {
                        $this->getResponse()->setStatusCode(200); //Default status code
                    }
                    /*
                     * Print the response to the client 
                     */
                    $this->printResponse();
                } else {
                    throw new \Framework\Exception\ControllerException('Action ' . $actionName . ' could not be executed on the controller');
                }
            } catch (\Exception $e) {
                $this->catchError($e);
            }
        } else {
            /*
             * Router could not match to any controller
             * We should return 404 status code and "Not found" text
             */
            $this->setResponse(new Response());
            $this->getResponse()->setContent('Not found');
            $this->getResponse()->setStatusCode(404);
            $this->printResponse();
        }

        return $this;
    }

    protected function catchError(\Exception $e) {

        $viewModel = ViewModel\ViewModelFactory::getViewModel($this->getRequest());
        $viewModel->setData(array(
            'code' => $e->getCode(),
            'message' => $e->getMessage()
        ));

        $this->setResponse($this->getResponseByViewModel($viewModel));
        $this->getResponse()->setStatusCode($e->getCode());
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
