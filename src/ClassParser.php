<?php

namespace IoC;

class ClassParser implements ClassParserInterface
{
    /**
     * @inheritDoc
     */
    public function getAllClassFullNameFromFile(string $filePathName): array
    {
        $allClassName = array();

        $classes = $this->getAllClassNameFromFile($filePathName);
        $nameSpace = $this->getNamespaceFromFile($filePathName);

        foreach ($classes as $class)
        {
            $allClassName[] = $nameSpace . "\\" . $class;
        }

        return $allClassName;
    }

    /**
     * @inheritDoc
     */
    public function getClassFullNameFromFile(string $filePathName): string
    {
        return $this->getNamespaceFromFile($filePathName) . "\\" . $this->getClassNameFromFile($filePathName);
    }

    /**
     * @inheritDoc
     */
    public function getAllClassNameFromFile(string $filePathName): array
    {
        $php_code = file_get_contents($filePathName);
        $tokens = token_get_all($php_code);

        $classes = array();
        $count = count($tokens);

        for ($i = 2; $i < $count; $i++)
        {
            if ($tokens[$i - 2][0] == T_CLASS && $tokens[$i - 1][0] == T_WHITESPACE && $tokens[$i][0] == T_STRING)
            {
                $class_name = $tokens[$i][1];
                $classes[] = $class_name;
            }
        }

        return $classes;
    }

    /**
     * @inheritDoc
     */
    public function getClassNameFromFile(string $filePathName): string
    {
        $classes = self::getAllClassNameFromFile($filePathName);
        return $classes[0];
    }

    /**
     * @inheritDoc
     */
    public function getClassObjectFromFile(string $filePathName)
    {
        $classString = $this->getClassFullNameFromFile($filePathName);

        $object = new $classString;

        return $object;
    }

    /**
     * @inheritDoc
     */
    public function getNamespaceFromFile($filePathName)
    {
        $src = file_get_contents($filePathName);

        $i = 0;
        $namespace = "";
        $namespace_ok = false;
        $tokens = token_get_all($src);
        $count = count($tokens);

        while ($i < $count)
        {
            $token = $tokens[$i];
            if (is_array($token) && $token[0] === T_NAMESPACE)
            {
                // Found namespace declaration
                while (++$i < $count)
                {
                    if ($tokens[$i] === ";")
                    {
                        $namespace_ok = true;
                        $namespace = trim($namespace);
                        break;
                    }
                    $namespace .= is_array($tokens[$i]) ? $tokens[$i][1] : $tokens[$i];
                }
                break;
            }
            $i++;
        }

        if (!$namespace_ok)
        {
            return null;
        }

        return $namespace;
    }

}