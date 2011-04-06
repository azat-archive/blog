<?php

/**
 * Class: Title
 * Date begin: Apr 6, 2011
 * 
 * Helper for title generation
 * 
 * @package blog
 * @author Azat Khuzhin
 */

namespace Blog\WebBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;

class Title extends Helper {
	static protected $instance;
	protected $parts = array();
	protected $delimiter = ' | ';
	
	/**
	 * {@inheritdoc}
	 */
	public function getName() {
		return 'title';
	}
	
	/**
	 * Get instance
	 *
	 * @param string $delimiter
	 * @return Title
	 */
	public static function getInstance($delimiter = null) {
		if (!self::$instance) {
			self::$instance = new self($delimiter);
		}
		return self::$instance;
	}
	
	/**
	 * Flush parts
	 *
	 * @return Title 
	 */
	public function flush() {
		$this->parts = array();
		return $this;
	}
	
	/**
	 * Add parts
	 *
	 * @return Title 
	 */
	public function add() {
		$args = func_get_args();
		$this->parts = array_merge($this->parts, $args);
		return $this;
	}
	
	/**
	 * Get parts as array
	 *
	 * @return array
	 */
	public function getArray() {
		return $this->parts;
	}
	
	/**
	 * Get parts as string joined with $this->delimiter
	 *
	 * @return string
	 */
	public function get() {
		return join($this->delimiter, $this->parts);
	}
	
	/**
	 * @alias for this->get()
	 */
	public function __toString() {
		return $this->get();
	}
	
	/**
	 * Constructor
	 *
	 * @param string $delimiter 
	 */
	private function __construct($delimiter = null) {
		if (!is_null($delimiter)) {
			$this->delimiter = $delimiter;
		}
	}
}
