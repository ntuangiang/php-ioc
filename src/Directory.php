<?php


namespace IoC;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Directory
{
    /**
     * @param $filter
     * @param int $mode
     * @return RecursiveIteratorIterator
     */
    public static function getRecursiveIterator($filter, $mode = RecursiveIteratorIterator::CHILD_FIRST): RecursiveIteratorIterator
    {
        $resource = $filter;

        if (!($resource instanceof RecursiveFilterIterator)) {
            $resource = new RecursiveDirectoryIterator($filter);
        }

        $iterator = new RecursiveIteratorIterator($resource, $mode);

        return $iterator;
    }

    /**
     * @param $filter
     * @return array
     */
    public static function getRecursiveArray($filter): array
    {
        $iterator = Directory::getRecursiveIterator($filter);

        $resource = array();

        foreach ($iterator as $splFileInfo) {
            $path = $splFileInfo->isDir()
                ? array($splFileInfo->getFilename() => array())
                : array($splFileInfo->getFilename());

            for ($depth = $iterator->getDepth() - 1; $depth >= 0; $depth--) {
                $path = array($iterator->getSubIterator($depth)->current()->getFilename() => $path);
            }
            $resource = array_merge_recursive($resource, $path);
        }

        return $resource;
    }

    /**
     * @param $filter
     * @return array
     * TODO
     */
    public static function getFlatArray($filter): array
    {
       return array();
    }

}