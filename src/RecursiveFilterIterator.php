<?php

namespace IoC;

class RecursiveFilterIterator extends \RecursiveFilterIterator
{
    public function accept()
    {
        $resource = $this->current()->getFilename();
        // Skip hidden files and directories.

        if ($this->isDir())
        {
            // Only recurse into intended subdirectories.
            return !preg_match("/^(\.)+(\w)*/", $resource);
        }
        else
        {
            // Only consume files of interest.
            return preg_match("/^.+\.php$/i", $resource);
        }
    }
}