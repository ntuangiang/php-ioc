<?php

namespace IoC;

/**
 * Return the class name from a file.
 *
 * Taken from http://stackoverflow.com/questions/7153000/get-class-name-from-file
 */
interface ClassParserInterface
{
    /**
     * get the full name (name \ namespace) of a class from its file path
     * result example: (string) "I\Am\The\Namespace\Of\This\Class"
     *
     * @param string $filePathName
     *
     * @return  array
     */
    public function getAllClassFullNameFromFile(string $filePathName): array;

    /**
     * get the full name (name \ namespace) of a class from its file path
     * result example: (string) "I\Am\The\Namespace\Of\This\Class"
     *
     * @param $filePathName
     *
     * @return  string
     */
    public function getClassFullNameFromFile(string $filePathName);

    /**
     * Get all the class name form file path using token
     *
     * @param $filePathName
     *
     * @return  array
     */
    public function getAllClassNameFromFile(string $filePathName): array;

    /**
     * build and return an object of a class from its file path
     *
     * @param $filePathName
     *
     * @return  mixed
     */
    public function getClassObjectFromFile(string $filePathName);


    /**
     * get the class namespace form file path using token
     *
     * @param $filePathName
     *
     * @return  null|string
     */
    public function getNamespaceFromFile(string $filePathName);

    /**
     * get the class name form file path using token
     *
     * @param $filePathName
     *
     * @return  mixed
     */
    public function getClassNameFromFile(string $filePathName): string;
}