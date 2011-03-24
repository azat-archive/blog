<?php

/**
 * Class: MainMenu
 * Date begin: Mar 16, 2011
 * 
 * Main menu
 * 
 * @package blog
 * @author Azat Khuzhin
 */

namespace Blog\WebBundle\Menu;

use	Knplabs\MenuBundle\Menu,
	Symfony\Component\HttpFoundation\Request,
	Symfony\Component\Routing\Router;

class MainMenu extends Menu {
	/**
	 * @param Request $request
	 * @param Router $router
	 */
	public function __construct(Request $request, Router $router) {
		parent::__construct();

		$this->setCurrentUri($request->getRequestUri());
		
		$this->addChild('Home', $router->generate('_index'));
	}
}
