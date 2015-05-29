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

namespace Framework\MVC\Router;

/**
 * Description of Router
 *
 * @author cagatay
 */
use \Traversable;
use Framework\MVC\Request\Request;

interface RouterInterface {

    /**
     * Map a route to a target
     *
     * @param string $method One of 5 HTTP Methods, or a pipe-separated list of multiple HTTP Methods (GET|POST|PATCH|PUT|DELETE)
     * @param string $route The route regex, custom regex must start with an @. You can use multiple pre-set regex filters, like [i:id]
     * @param mixed $target The target where this route should point to. Can be anything.
     * @param string $name Optional name of this route. Supply if you want to reverse route this url in your application.
     */
    public function map($method, $route, $target, $name = null);

    /**
     * Add multiple routes
     *
     * @param array|Traversable Routes to add
     */
    public function addRoutes($config);

    /**
     * Match a given Request object against stored routes
     * @param Request Request
     * @return array|boolean Array with route information on success, false on failure (no match).
     */
    public function match(Request $request);
}
