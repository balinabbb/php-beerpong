<?php

namespace AppBundle\Entity;

class BaseEntity {

    function fill(array $vars) {
        $ref = new \ReflectionClass($this);
        $has = $ref->getProperties();
        foreach ($has as $property) {
            $name = $property->name;
            $methodName = 'set'.ucfirst($property->name);
            if(isset($vars[$name])) {
                $this->{$methodName}($vars[$name]);
            }
        }
    }

}
