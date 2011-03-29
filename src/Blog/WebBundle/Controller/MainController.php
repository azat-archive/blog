<?php

/**
 * Class: MainController
 * Date begin: Mar 16, 2011
 * 
 * Main controller
 * 
 * @package blog
 * @author Azat Khuzhin
 */

namespace Blog\WebBundle\Controller;

class MainController extends Controller {
	/**
	 * @extra:Route("/", name="_index")
	 * @extra:Template()
	 */
	public function indexAction() {
		return array();
	}
}
