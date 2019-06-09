<?php

namespace IoC\Ol;

class Ol
{
    /**
     * @var Factory
     */
    private static $factory = null;

    /**
     * @var InitialContext
     */
    private static $initialContext = null;

    /**
     * @param string $objectName
     * @return mixed|null
     */
    public static function getObject(string $objectName) {

        if (!Ol::$factory) {
            Ol::$factory = new Factory();
        }

        if (!Ol::$initialContext) {
            Ol::$initialContext = new InitialContext();
        }

        $object = Ol::$factory->getObject($objectName);

        if (!$object) {
            $object = Ol::$initialContext->createObject($objectName);
            Ol::$factory->addObject($object);
        }

        return $object;
    }

}