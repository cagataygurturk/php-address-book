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

namespace Backend\Infrastructure\Persistence\Repository;

use Backend\Model\Entity;

/**
 * Description of EntityRepository
 *
 * @author cagatay
 */
abstract class EntityRepository implements EntityRepositoryInterface {

    protected $config;

    /**
     * Default constructor for factory
     *
     * @param array $config Repository configuration
     * @return void
     */
    public function __construct(array $config) {
        $this->config = $config;
    }

    /**
     * Get an entity
     *
     * @return \Backend\Model\Entity
     */
    private function getObjectByRow($row) {
        $object = new $this->config['hydrate_to_object']();
        foreach ($row as $k => $v) {
            $methodToCall = 'set' . ucfirst($k);
            if (method_exists($object, $methodToCall)) {
                call_user_func(array($object, $methodToCall), $v);
            }
        }
        return $object;
    }

    /**
     * Get an array by read line
     *
     * @return array
     */
    private function getRowByRawLine($line) {
        if (count($line) !== count($this->config['fields'])) {
            throw new \Backend\Exception\InvalidInputException('Field count does not match with the fields specification.');
        }
        $output = array();
        foreach ($line as $k => $v) {
            $output[$this->config['fields'][$k]] = $v;
        }
        return $output;
    }

    protected function getFileHandle() {
        return fopen($this->config['file'], "r");
    }

    /**
     * Get all rows
     *
     * @return array
     */
    public function getAllRows() {
        if ($handle = $this->getFileHandle()) {
            $output = array();
            while (($line = fgetcsv($handle)) !== FALSE) {
                try {
                    $output[] = $this->getObjectByRow($this->getRowByRawLine($line));
                } catch (\Exception $e) {
                    //Invalid row, skip, there is no need to do nothing
                }
            }

            fclose($handle);
            return $output;
        }
        throw new \Backend\Exception\IOException('CSV File could not read');
    }

    /**
     * Get all the rows matching with specific criteria
     * 
     * THIS IMPLEMENTS ONE OF WORST SEARCH ALGORITHMS BUT IT SEEMS THERE IS NO BETTER WAY
     * AS WE TRY TO GET ALL MATCHING RESULTS. WE MAY HAVE MORE THAN ONE MATCHING RESULTS SO 
     * IN ANY CASE WE MUST SCAN THE TABLE
     * FOR BETTER PERFORMANCE DO NOT USE CSV :)
     *
     * @return array
     */
    public function findByCriteria(array $criterias, $limit = null) {
        if ($limit == 1) {
            return $this->findByCriteriaOne($criterias);
        }
        return $this->findByCriteriaAll($criterias, $limit);
    }

    /**
     * Get just one row matching with specific criteria
     * 
     * This implementation just gets a result matching with criteria
     * 
     * 
     * 
     *
     * @return array
     */
    protected function findByCriteriaOne(array $criterias) {
        return array_slice($this->findByCriteriaAll($criterias, null), 0, 1);
    }

    /**
     * Get all the rows matching with specific criteria
     * 
     * THIS IMPLEMENTS ONE OF WORST SEARCH ALGORITHMS BUT IT SEEMS THERE IS NO BETTER WAY
     * AS WE TRY TO GET ALL MATCHING RESULTS. WE MAY HAVE MORE THAN ONE MATCHING RESULTS SO 
     * IN ANY CASE WE MUST SCAN THE TABLE
     * FOR BETTER PERFORMANCE DO NOT USE CSV AND DO NOT BLAME ME FOR SUCH A BAD ALGORITHM :)
     *
     * @return array
     */
    protected function findByCriteriaAll(array $criterias, $limit) {

        $methodsToCall = array();
        foreach ($criterias as $field => $value) {
            $methodsToCall[$field] = 'get' . ucfirst($field);
        }
        $allrows = $this->getAllRows();
        $results = array();
        foreach ($allrows as $object) {
            if ($limit && count($results) >= $limit) {
                return $results;
            }

            $matches = true;
            foreach ($criterias as $field => $value) {
                if (method_exists($object, $methodsToCall[$field])) {
                    if ($value != call_user_func(array($object, $methodsToCall[$field]))) {
                        $matches = false;
                    }
                }
            }

            if ($matches) {
                $results[] = $object;
            }
        }
        return $results;
    }

    public function insert(Entity $object) {
        $line = "\n";
        foreach ($this->config['fields'] as $field) {
            $methodToCall = 'get' . ucfirst($field);
            $value = call_user_func(array($object, $methodToCall));
            $line.=$value . ",";
        }
        return (file_put_contents($this->config['file'], rtrim($line, ','), FILE_APPEND) != false);
    }

    public function delete(array $criterias) {
        $deleted = false;
        $tmpfile = $this->config['file'] . '.tmp';
        $tmphandle = fopen($tmpfile, 'w');

        if ($handle = $this->getFileHandle()) {

            while (($line = fgetcsv($handle)) !== FALSE) {
                $matches = true;
                foreach ($this->config['fields'] as $k => $field) {
                    if (isset($criterias[$field]) && isset($line[$k]) && $criterias[$field] !== $line[$k] && $matches) {
                        //does not match
                        $matches = false;
                    }
                }

                if (!$matches) {
                    fputcsv($tmphandle, $line);
                } else {
                    $deleted = true; //Just a return flag
                }
            }
            fclose($handle);
        }

        fclose($tmphandle);

        if ($deleted) {
            rename($tmpfile, $this->config['file']);
        }

        return $deleted;
    }

}
