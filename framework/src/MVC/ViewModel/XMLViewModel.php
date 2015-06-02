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

    protected $contentType = 'text/xml, application/xml';

    private function get_real_class($obj) {
        $classname = get_class($obj);

        if (preg_match('@\\\\([\w]+)$@', $classname, $matches)) {
            $classname = $matches[1];
        }

        return $classname;
    }

    protected function objectToXMLString($object) {
        if (!method_exists($object, 'xmlSerialize')) {
            return null;
        }
        $data = $object->xmlSerialize();
        $name = $this->get_real_class($object);
        $string = '<' . $name . '>';
        foreach ($data as $attr => $value) {
            $string.='<' . $attr . '>' . $value . '</' . $attr . '>';
        }
        $string .= '</' . $name . '>';

        return $string;
    }

    public function getNode($data, $nodeName) {
        $string = '<?xml version="1.0" encoding="UTF-8"?><' . $nodeName . '>';
        foreach ($data as $key => $object) {
            if (is_array($object)) {
                $string.=$this->getNode($object, $key);
            } else {
                $string.=$this->objectToXMLString($object);
            }
        }
        $string.= '</' . $nodeName . '>';
        return $string;
    }

    public function render() {
        return $this->getNode($this->data, 'root');
    }

}
