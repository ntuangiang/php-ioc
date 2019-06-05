<?php

namespace IoC\Ol;

class Ol
{
    /**
     * @var OlFactory
     */
    private static $factory = null;

    /**
     * @var OlInitialContext
     */
    private static $initialContext = null;

    /**
     * @param string $objectName
     * @return mixed|null
     */
    public static function getObject(string $objectName) {

        if (!Ol::$factory) {
            Ol::$factory = new OlFactory();
        }

        if (!Ol::$initialContext) {
            Ol::$initialContext = new OlInitialContext();
        }

        $object = Ol::$factory->getObject($objectName);

        if (!$object) {
            $object = Ol::$initialContext->createObject($objectName);
            Ol::$factory->addObject($object);
        }

        return $object;
    }

}