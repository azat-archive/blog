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
	Symfony\Component\Routing\Router,
	Symfony\Component\DependencyInjection\ContainerInterface;

class MainMenu extends Menu {
	protected $request;
	protected $router;
	protected $container;
	protected $user;
	
	/**
	 * @param Request $request
	 * @param Router $router
	 * @param ContainerInterface $container A ContainerInterface instance
	 */
	public function __construct(Request $request, Router $router, ContainerInterface $container) {
		parent::__construct();
		
		$this->request = $request;
		$this->router = $router;
		$this->container = $container;

		$this->setCurrentUri($request->getRequestUri());
		
		$this->checkUser();
		$this->addMenu();
	}
	
	/**
	 * Check is user logged-in
	 */
	protected function checkUser() {
		// retrieving the security identity of the currently logged-in user
		$securityContext = $this->container->get('security.context');
		if ($securityContext->getToken()) {
			$this->user = $securityContext->getToken()->getUser();
		}
	}
	
	/**
	 * Add menu items
	 */
	protected function addMenu() {
		if (!$this->user) {
			$this->addChild('Signup', $this->router->generate('_users_signup'));
			$this->addChild('Login / Signin', $this->router->generate('_users_login'));
		} else {
			$this->addChild('Index', $this->router->generate('_index'));
			$this->addChild('Posts', $this->router->generate('_posts'));
			$this->addChild('Add posts', $this->router->generate('_posts_add'));
			$this->addChild('Logout', '/logout'); // @TODO generate url dynamicly
		}
	}
}
