<?php

namespace IoC\Ol;

class OlInitialContext
{
    /**
     * @param string $objectName
     * @return null
     */
    public function createObject(string $objectName) {
        if (!$objectName) {
            return null;
        }

        return new $objectName();
    }
}