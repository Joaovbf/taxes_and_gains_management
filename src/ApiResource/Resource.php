<?php
/**
 * Created by PhpStorm.
 * User: jvito
 * Date: 29/04/2022
 * Time: 11:59
 */

namespace App\ApiResource;


abstract class Resource
{
    abstract public function make($entity);

    public function collection(array $entities) {
        $collection = [];
        foreach ($entities as $entity) {
            $collection[] = $this->make($entity);
        }

        return $collection;
    }
}