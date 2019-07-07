<?php

namespace lib\Annotation;

/**
 * Annotation class for @Route().
 *
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 *
 */
class Route {
    private $path;
    private $name;
    private $options = [];
    private $methods = [];

    /**
     * @param array $data An array of key/value parameters
     *
     * @throws \BadMethodCallException
     */
    public function __construct(array $data) {
        if (isset($data['value'])) {
            $data[\is_array($data['value']) ? 'localized_paths' : 'path'] = $data['value'];
            unset($data['value']);
        }

        if (isset($data['path']) && \is_array($data['path'])) {
            $data['localized_paths'] = $data['path'];
            unset($data['path']);
        }

        foreach ($data as $key => $value) {
            $method = 'set'.str_replace('_', '', $key);
            if (!method_exists($this, $method)) {
                throw new \BadMethodCallException(sprintf('Unknown property "%s" on annotation "%s".', $key, \get_class($this)));
            }
            $this->$method($value);
        }
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setOptions($options)
    {
        $this->options = $options;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setMethods($methods)
    {
        $this->methods = \is_array($methods) ? $methods : [$methods];
    }

    public function getMethods()
    {
        return $this->methods;
    }
}