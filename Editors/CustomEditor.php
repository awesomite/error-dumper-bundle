<?php

namespace Awesomite\ErrorDumperBundle\Editors;

use Awesomite\ErrorDumper\Editors\EditorInterface;

/**
 * @internal
 */
class CustomEditor implements EditorInterface
{
    private $pattern;

    private $mapping = array();

    /**
     * @param string $pattern
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    public function getLinkToFile($filename, $line = null)
    {
        return str_replace(
            array('%f', '%l'),
            array($this->convertPath($filename), is_null($line) ? '' : $line),
            $this->pattern
        );
    }

    public function registerPathMapping($serverPath, $projectPath)
    {
        $this->mapping[$serverPath] = $projectPath;

        return $this;
    }

    private function convertPath($path)
    {
        $result = $path;
        foreach ($this->mapping as $from => $to) {
            $pattern = '#^' . preg_quote($from, '#') . '#';
            $result = preg_replace($pattern, $to, $result);
        }

        return $result;
    }
}
