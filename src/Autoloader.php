<?php

namespace IoC;

use RecursiveDirectoryIterator;
use \IoC\RecursiveFilterIterator;
use RecursiveIteratorIterator;

class Autoloader
{
    /**
     * @var Autoloader
     */
    private static $instance = null;

    /**
     * @var array|null
     */
    private $classLoader = null;

    /**
     * @return Autoloader
     */
    public static function getInstance() {
        if (!Autoloader::$instance) {
            Autoloader::$instance = new Autoloader();
        }

        return Autoloader::$instance;
    }

    /**
     * ClassLoader constructor.
     */
    public function __construct()
    {
        $this->classLoader = new ClassLoader();
    }

    /**
     * @param string $path
     */
    public function load(string $path)
    {
        $directory = new RecursiveDirectoryIterator($path);
        $filter = new RecursiveFilterIterator($directory);

        $iterator = new RecursiveIteratorIterator($filter, RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($iterator as $splFileInfo)
        {
            if ($splFileInfo->isDir())
            {
                continue;
            }

            $absolutePath = "";
            $resource = $splFileInfo->getFilename();

            for ($depth = 0; $depth < $iterator->getDepth(); $depth++)
            {
                $absolutePath .= "{$iterator->getSubIterator($depth)->current()->getFilename()}/";
            }

            $this->classLoader->loadClassMap("{$path}/{$absolutePath}{$resource}");
        }


        $this->classLoader->register(true);
    }

}