<?php

/**
 * Class: ExceptionController
 * Date begin: Mar 16, 2011
 * 
 * Base exception controller
 * 
 * @package blog
 * @author Azat Khuzhin
 */

namespace Blog\WebBundle\Controller;

use	Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionController {
	/**
	 * Not found error
	 *
	 * @return NotFoundHttpException 
	 */
	static function notFound() {
		$args = func_get_args();
		$formatedString = array_shift($args);
		
		return new NotFoundHttpException(sprintf($formatedString, $args));
	}
}
