<?php

namespace IoC;

include_once "RecursiveFilterIterator.php";
include_once "Directory.php";

use \RecursiveDirectoryIterator;

class Bootstrap
{
    public static function autoload($path)
    {
        $directory = new RecursiveDirectoryIterator($path);
        $filter = new RecursiveFilterIterator($directory);

        $iterator = Directory::getRecursiveIterator($filter);

        $r = array();


        foreach ($iterator as $splFileInfo) {
            $resource = $splFileInfo->getFilename();

            if (!$splFileInfo->isDir()) {
                $absolutePath = "";
                for ($depth = 0; $depth < $iterator->getDepth(); $depth++) {
                    $absolutePath .= "{$iterator->getSubIterator($depth)->current()->getFilename()}/";
                }

                $realPath = "{$path}/{$absolutePath}{$resource}";
                include_once "{$realPath}";
            }
        }

    }
}