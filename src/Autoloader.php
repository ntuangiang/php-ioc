<?php

namespace IoC;

use RecursiveDirectoryIterator;
use \IoC\RecursiveFilterIterator;
use RecursiveIteratorIterator;

class Autoloader
{
    /**
     * @var array|null
     */
    private $classLoader = null;

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

        foreach ($iterator as $splFileInfo) {
            if ($splFileInfo->isDir()) {
                continue;
            }

            $absolutePath = "";
            $resource = $splFileInfo->getFilename();

            for ($depth = 0; $depth < $iterator->getDepth(); $depth++) {
                $absolutePath .= "{$iterator->getSubIterator($depth)->current()->getFilename()}/";
            }

            $this->classLoader->loadClassMap("{$path}/{$absolutePath}{$resource}");
        }
    }

}