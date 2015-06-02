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

namespace Framework\MVC\Request;

/**
 * Description of HttpRequest
 *
 * @author cagatay
 */
class Request implements RequestInterface {
    /*
     * @const string METHOD constant names
     */

    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_GET = 'GET';
    const METHOD_HEAD = 'HEAD';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';
    const METHOD_TRACE = 'TRACE';
    const METHOD_CONNECT = 'CONNECT';
    const METHOD_PATCH = 'PATCH';
    const METHOD_PROPFIND = 'PROPFIND';
    const ACCEPT_JSON = 'json';
    const ACCEPT_HTML = 'html';
    const ACCEPT_XML = 'xml';

    /**
     * @var string
     */
    protected $acceptType;

    /**
     * @var string
     */
    protected $method = self::METHOD_GET;

    /**
     * @var string
     */
    protected $uri = null;

    /**
     * @var array
     */
    protected $queryParams = null;

    /**
     * @var array
     */
    protected $postParams = null;

    /*
     * This class always should be created by its factory
     */

    private function __construct() {
        
    }

    /**
     * Create a Request object from the current request
     *
     * @param array post, get, uri and method parameters can be given for testing purposes
     * @return Request
     */
    public static function factory(array $config = null) {
        $request = new Request();
        $request->setPost((isset($config['post']) ? $config['post'] : $_POST));
        $request->setQuery((isset($config['get']) ? $config['get'] : $_GET));
        $request->setUri((isset($config['uri']) ? $config['uri'] : (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null)));
        $method = (isset($config['method']) ? $config['method'] : (isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null));
        if ($method) {
            $request->setMethod($method);
        }

        $acceptType = (isset($config['accept']) ? $config['accept'] : (isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : null));
        if ($acceptType) {
            $request->setAcceptType($acceptType);
        }

        return $request;
    }

    /**
     * Is this an HTTP request? (Or console session
     *
     * @return bool
     */
    public function isHttpRequest() {
        return isset($_SERVER['HTTP_ACCEPT']);
    }

    /**
     * Is this an OPTIONS method request?
     *
     * @return bool
     */
    public function isOptions() {
        return ($this->method === self::METHOD_OPTIONS);
    }

    /**
     * Is this a PROPFIND method request?
     *
     * @return bool
     */
    public function isPropFind() {
        return ($this->method === self::METHOD_PROPFIND);
    }

    /**
     * Is this a GET method request?
     *
     * @return bool
     */
    public function isGet() {
        return ($this->method === self::METHOD_GET);
    }

    /**
     * Is this a HEAD method request?
     *
     * @return bool
     */
    public function isHead() {
        return ($this->method === self::METHOD_HEAD);
    }

    /**
     * Is this a POST method request?
     *
     * @return bool
     */
    public function isPost() {
        return ($this->method === self::METHOD_POST);
    }

    /**
     * Is this a PUT method request?
     *
     * @return bool
     */
    public function isPut() {
        return ($this->method === self::METHOD_PUT);
    }

    /**
     * Is this a DELETE method request?
     *
     * @return bool
     */
    public function isDelete() {
        return ($this->method === self::METHOD_DELETE);
    }

    /**
     * Is this a TRACE method request?
     *
     * @return bool
     */
    public function isTrace() {
        return ($this->method === self::METHOD_TRACE);
    }

    /**
     * Is this a CONNECT method request?
     *
     * @return bool
     */
    public function isConnect() {
        return ($this->method === self::METHOD_CONNECT);
    }

    /**
     * Is this a PATCH method request?
     *
     * @return bool
     */
    public function isPatch() {
        return ($this->method === self::METHOD_PATCH);
    }

    /**
     * Get request method
     *
     * @return string
     */
    public function getMethod() {
        return $this->method;
    }

    public function setMethod($method) {
        $this->method = $method;
    }

    /**
     * Get request Accept header
     *
     * @return string
     */
    public function getAcceptType() {
        return $this->acceptType;
    }

    public function setAcceptType($acceptType) {
        $this->acceptType = $acceptType;
    }

    public function getAcceptedFormat() {

        if ($this->getAcceptType() == 'application/xml') {
            return self::ACCEPT_XML;
        }

        return self::ACCEPT_JSON; //Default
    }

    /**
     * Get request URI
     *
     * @return string
     */
    public function getUri() {
        return $this->uri;
    }

    public function setUri($uri) {
        $this->uri = $uri;
    }

    public function setPost(array $params) {
        $this->postParams = $params;
    }

    public function getPost($key, $default = null) {
        return (isset($this->postParams[$key]) ? $this->postParams[$key] : $default);
    }

    public function getPostParams() {
        return $this->postParams;
    }

    public function setQuery(array $params) {
        $this->queryParams = $params;
    }

    public function getQuery($key, $default = null) {
        return (isset($this->queryParams[$key]) ? $this->queryParams[$key] : $default);
    }

}
