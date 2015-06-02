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

namespace Framework\MVC\ViewModel;

/**
 * Description of ViewModel
 *
 * @author cagatay
 */
use Framework\MVC\Request\Request;

class ViewModelFactory {

    /**
     * 
     * This class implements Factory Pattern to decide which implementation of ViewModel should create
     * according to the Accept header of the request
     * 
     *
     * @param Request $request Request type
     * @return ViewModelInterface
     */
    public static function getViewModel(Request $request) {
        switch ($request->getAcceptedFormat()) {
            case Request::ACCEPT_XML:
                $vm = new XMLViewModel();
                break;
            case Request::ACCEPT_JSON:
                $vm = new JSONViewModel();
                break;
        }

        return $vm;
    }

}
