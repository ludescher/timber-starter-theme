<?php

namespace lib\Manager;

use Doctrine\Common\Annotations\FileCacheReader;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class AnnotationManager {
    /**
     * @var String
     */
	private $cache_path;

    /**
     * @var String
     */
	private $route_path;

    /**
     * @var String
     */
	private $annotation_namespace;

    /**
     * @var String
     */
	private $annotation_path;
	
    public function __construct(string $cache_path, string $route_path, string $annotation_namespace, string $annotation_path) {
		$this->cache_path = $cache_path;
		$this->route_path = $route_path;
		$this->annotation_namespace = $annotation_namespace;
		$this->annotation_path = $annotation_path;

		AnnotationRegistry::registerFile($this->route_path);
		AnnotationRegistry::registerAutoloadNamespace($this->annotation_namespace, $this->annotation_path);
	}

    public function initAnnotationReader():FileCacheReader {
		return new FileCacheReader(
			new AnnotationReader(),
			$this->cache_path,
			$debug = WP_DEBUG
		);
    }
}