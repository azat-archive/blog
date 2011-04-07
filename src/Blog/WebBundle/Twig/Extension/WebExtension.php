<?php

/**
 * Class: WebExtension
 * Date begin: Apr 6, 2011
 * 
 * Twig extension
 * 
 * @package blog
 * @author Azat Khuzhin
 */

namespace Blog\WebBundle\Twig\Extension;

use	Symfony\Component\HttpKernel\KernelInterface,
	Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;

use	Blog\WebBundle\Templating\Helper\Title as TitleHelper;

class WebExtension extends \Twig_Extension {
	/**
	 * Loader
	 *
	 * @var FilesystemLoader
	 */
	protected $loader;
	/**
	 * Controller
	 *
	 * @var array
	 */
	protected $controller;

	/**
	 * Loader
	 *
	 * @param FilesystemLoader $loader 
	 */
	public function __construct(FilesystemLoader $loader) {
		$this->loader = $loader;
	}

	/**
	 * Controller
	 *
	 * @param array $controller 
	 */
	public function setController(array $controller) {
		$this->controller = $controller;
	}

	/**
	 * Returns a list of filters
	 *
	 * @return array
	 */
	public function getFilters() {
		return array(
			'truncate' => new \Twig_Filter_Method($this, 'twig_truncate_filter', array('needs_environment' => true)),
			'wordwrap' => new \Twig_Filter_Method($this, 'twig_wordwrap_filter', array('needs_environment' => true)),
			'nl2br' => new \Twig_Filter_Method($this, 'twig_nl2br_filter', array('pre_escape' => 'html', 'is_safe' => array('html'))),
			'date' => new \Twig_Filter_Method($this, 'twig_date_filter'),
		);
	}

	/**
	 * Returns a list of functions
	 *
	 * @return array
	 */
	public function getFunctions() {
		return array(
			'title' => new \Twig_Function_Method($this, 'twig_title_function'),
		);
	}

	/**
	 * Name of this extension
	 *
	 * @return string
	 */
	public function getName() {
		return 'web';
	}

	/**
	 * nl2br alias
	 *
	 * @param mixed $value
	 * @param string $sep
	 * @return string
	 */
	public function twig_nl2br_filter($value, $sep = '<br />') {
		return str_replace("\n", $sep . "\n", $value);
	}

	/**
	 * Truncate filter
	 *
	 * @param \Twig_Environment $env
	 * @param mixed $value
	 * @param int $length
	 * @param bool $preserve
	 * @param string $separator
	 * @return string
	 */
	public function twig_truncate_filter(\Twig_Environment $env, $value, $length = 30, $preserve = false, $separator = '...') {
		if (mb_strlen($value, $env->getCharset()) > $length) {
			if ($preserve) {
				if (false !== ($breakpoint = mb_strpos($value, ' ', $length, $env->getCharset()))) {
					$length = $breakpoint;
				}
			}

			return mb_substr($value, 0, $length, $env->getCharset()) . $separator;
		}

		return $value;
	}

	/**
	 * Wordwrap filter
	 *
	 * @param \Twig_Environment $env
	 * @param mixed $value
	 * @param int $length
	 * @param string $separator
	 * @param bool $preserve
	 * @return string
	 */
	public function twig_wordwrap_filter(\Twig_Environment $env, $value, $length = 80, $separator = "\n", $preserve = false) {
		$sentences = array();

		$previous = mb_regex_encoding();
		mb_regex_encoding($env->getCharset());

		$pieces = mb_split($separator, $value);
		mb_regex_encoding($previous);

		foreach ($pieces as $piece) {
			while (!$preserve && mb_strlen($piece, $env->getCharset()) > $length) {
				$sentences[] = mb_substr($piece, 0, $length, $env->getCharset());
				$piece = mb_substr($piece, $length, 2048, $env->getCharset());
			}

			$sentences[] = $piece;
		}

		return implode($separator, $sentences);
	}
	
	/**
	 * Title function
	 *
	 * @see Blog\WebBundle\Templating\Helper\Title
	 * @return string
	 */
	public function twig_title_function() {
		return (string)TitleHelper::getInstance();
	}
	
	/**
	 * Date filter
	 *
	 * @param int $unixtimeStamp
	 * @return string
	 */
	public function twig_date_filter($unixtimeStamp) {
		if (!$unixtimeStamp) {
			// return null; // ?
			return 'no';
		}
		
		if ($unixtimeStamp <= time()) {
			if ($unixtimeStamp >= strtotime('-1 hour')) return 'now';
			if ($unixtimeStamp >= strtotime('-1 day')) return 'today';
			if ($unixtimeStamp >= strtotime('-2 day')) return 'yesterday';
		}
		if ($unixtimeStamp >= time() && $unixtimeStamp <= strtotime('+1 day')) {
			return 'tomorrow';
		}
		// current year
		if (date('Y', $unixtimeStamp) == date('Y')) {
			return date('j F', $unixtimeStamp);
		}
		return date('j F Y', $unixtimeStamp);
	}
}
