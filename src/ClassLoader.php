<?php

namespace IoC;

class ClassLoader implements  ClassLoaderInterface
{
    private $classMap = null;

    private $missingClasses = null;

    protected $parser = null;

    public function __construct(ClassParserInterface $parser = null)
    {
        if ($parser) {
            $this->parser = $parser;
        } else {
            $this->parser = new ClassParser();
        }

        $this->missingClasses = array();
        $this->classMap = array();
    }

    /**
     * @inheritDoc
     */
    public function addClassMap(array $classMap): void
    {
        if ($this->classMap) {
            $this->classMap = array_merge($this->classMap, $classMap);
        } else {
            $this->classMap = $classMap;
        }
    }

    /**
     * @inheritDoc
     */
    public function loadClassMap(string $filePath): void
    {
        $classMap = array();

        $classNames = $this->parser->getAllClassFullNameFromFile($filePath);

        foreach ($classNames as $className) {
            array_push($classMap, array("{$className}" => $filePath));
        }

        self::addClassMap($classMap);
    }

    /**
     * @inheritDoc
     */
    public function register(bool $prepend = false): void
    {
        spl_autoload_register(array($this, 'loadClass'), true, $prepend);
    }

    /**
     * @inheritDoc
     */
    public function unregister(): void
    {
        spl_autoload_unregister(array($this, 'loadClass'));
    }

    /**
     * Loads the given class or interface.
     *
     * @param  string    $class The name of the class
     * @return bool True if loaded, null otherwise
     */
    public function loadClass(string $class): bool
    {
        if ($file = $this->findFile($class)) {
            include_once "{$file}";

            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function findFile(string $class): string
    {
        // class map lookup
        if (isset($this->classMap[$class])) {
            return $this->classMap[$class];
        }

        if (isset($this->missingClasses[$class])) {
            return false;
        }

        $file = $this->findFileWithExtension($class, '.php');

        // Search for Hack files if we are running on HHVM
        if (false === $file && defined('HHVM_VERSION')) {
            $file = $this->findFileWithExtension($class, '.hh');
        }

        if (false === $file) {
            // Remember that this class does not exist.
            $this->missingClasses[$class] = true;
        }

        return $file;
    }

    /**
     * @param string $class
     * @param string $ext
     * @return bool
     * TODO
     */
    private function findFileWithExtension(string $class, string $ext)
    {
        return false;
    }

}