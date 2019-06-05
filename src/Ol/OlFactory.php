<?php

namespace IoC\Ol;

class OlFactory
{
    /**
     * @var array
     */
    private $objects;

    /**
     * ObjectLocatorFactory constructor.
     */
    public function __construct()
    {
        $this->objects = [];
    }

    /**
     * @param string $objectName
     */
    public function addObject($objectName)
    {
        if (!array_key_exists(get_class($objectName), $this->objects)) {
            $this->objects[get_class($objectName)] = $objectName;
        }

    }

    /**
     * @param string $objectName
     * @return mixed
     */
    public function getObject(string $objectName)
    {
        return $this->objects[$objectName];
    }


}