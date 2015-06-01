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
 * Description of JSONViewModel
 *
 * @author cagatay
 */
class XMLViewModel extends ViewModel implements ViewModelInterface {

    private function array2XML($data, $rootNodeName = 'results', $xml = NULL) {
        if ($xml == null) {
            $xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
        }

        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                $key = "nodeId_" . (string) $key;
            }

            if (is_array($value)) {
                $node = $xml->addChild($key);
                $this->array2XML($value, $rootNodeName, $node);
            } else {
                $value = htmlentities($value);
                $xml->addChild($key, $value);
            }
        }

        return html_entity_decode($xml->asXML());
    }

    public function render() {

        return $this->array2XML($this->data);
    }

}
