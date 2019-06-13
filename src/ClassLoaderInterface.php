<?php

namespace IoC;

interface ClassLoaderInterface
{
    /**
     * @param array $classMap
     */
    public function addClassMap(array $classMap): void;

    /**
     * Load class map from a file
     *
     * @param string $filePath
     * @return mixed
     */
    public function loadClassMap(string $filePath): void;

    /**
     * Registers this instance as an autoloader.
     *
     * @param bool $prepend Whether to prepend the autoloader or not
     */
    public function register(bool $prepend = false): void;

    /**
     * Unregisters this instance as an autoloader.
     */
    public function unregister(): void;

    /**
     * Loads the given class or interface.
     *
     * @param  string    $class The name of the class
     * @return bool True if loaded, null otherwise
     */
    public function loadClass(string $class): bool;

    /**
     * Finds the path to the file where the class is defined.
     *
     * @param string $class The name of the class
     *
     * @return string|false The path if found, false otherwise
     */
    public function findFile(string $class): string;

}