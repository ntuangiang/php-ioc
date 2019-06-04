<?php

namespace IoC\Ol;

class ObjectLocator
{
    /**
     * @var ObjectLocatorFactory
     */
    private static $factory = null;

    /**
     * @var ObjectLocatorInitialContext
     */
    private static $initialContext = null;

    /**
     * @param string $objectName
     * @return mixed|null
     */
    public static function getObject(string $objectName) {

        if (!ObjectLocator::$factory) {
            ObjectLocator::$factory = new ObjectLocatorFactory();
        }

        if (!ObjectLocator::$initialContext) {
            ObjectLocator::$initialContext = new ObjectLocatorInitialContext();
        }

        $object = ObjectLocator::$factory->getObject($objectName);

        if (!$object) {
            $object = ObjectLocator::$initialContext->createObject($objectName);
            ObjectLocator::$factory->addObject($object);
        }

        return $object;
    }

}