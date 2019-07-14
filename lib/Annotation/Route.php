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
	/**
	 * @var String
	 */
    private $path;
    
	/**
	 * @var String
	 */
    private $name;
    
	/**
	 * @var Array
	 */
    private $options = [];
    
	/**
	 * @var String|Array
	 */
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

    /**
     * @param String $path
     */
    public function setPath(string $path) {
        $this->path = $path;
    }

    /**
     * @return String
     */
    public function getPath():string {
        return $this->path;
    }

    /**
     * @param String $name
     */
    public function setName($name){
        $this->name = $name;
    }

    /**
     * @return String
     */
    public function getName():string {
        return $this->name;
    }

    /**
     * @param Array $options
     */
    public function setOptions(array $options) {
        $this->options = $options;
    }

    /**
     * @return Array
     */
    public function getOptions():array {
        return $this->options;
    }

    /**
     * @param String|Array $methods
     */
    public function setMethods($methods) {
        $this->methods = \is_array($methods) ? $methods : [$methods];
    }

    /**
     * @return String|Array
     */
    public function getMethods() {
        return $this->methods;
    }
}