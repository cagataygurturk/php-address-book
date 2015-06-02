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

namespace Application\Exception;

/**
 * 9.7 DELETE
 * A successful response SHOULD be 200 (OK) if the response includes an entity describing the status, 
 * 202 (Accepted) if the action has not yet been enacted,
 * or 204 (No Content) if the action has been enacted but the response does not include an entity.
 *
 * @author cagatay
 */
class NotFoundException extends \Framework\Exception\Exception {

    protected $code = 204;
    protected $message = 'No content';

}
