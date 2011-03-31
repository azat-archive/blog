<?php

/**
 * Class: Controller
 * Date begin: Mar 16, 2011
 * 
 * Base controller
 * 
 * @package blog
 * @author Azat Khuzhin
 */

namespace Blog\WebBundle\Controller;

use	Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController,
	Symfony\Component\DependencyInjection\ContainerInterface,
	Symfony\Component\Security\Core\SecurityContext,
	Symfony\Component\HttpFoundation\RedirectResponse;

class Controller extends BaseController {
	private $em;
	private $user;
	private $template;
	
	/**
	 * Init vars
	 */
	private function _init() {
		$this->em = $this->get('doctrine.orm.entity_manager');
		
		$securityContext = $this->container->get('security.context');
		if ($securityContext->getToken()) {
			$this->user = $securityContext->getToken()->getUser();
		}
		
		$this->template = $this->get('twig');
		// append user variable
		$this->template->addGlobal('user', $this->user);
	}
	
	/**
	 * Redirect
	 *
	 * @return RedirectResponse
	 */
	public function redirectGenerate() {
		$args = func_get_args();
		if (empty($args)) {
			return new RedirectResponse('/');
		} else {
			return new RedirectResponse(call_user_func_array(array(&$this, 'generateUrl'), $args));
		}
	}
	
	/**
	 * Get Entity Manager
	 *
	 * @return object
	 */
	protected function getEm() {
		return $this->em;
	}
	
	/**
	 * Get current user
	 *
	 * @return object
	 */
	protected function getUser() {
		return $this->user;
	}
	
	/**
	 * Get template engine
	 *
	 * @return object
	 */
	protected function getTemplate() {
		return $this->template;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setContainer(ContainerInterface $container = null) {
		parent::setContainer($container);
		
		$this->_init();
	}
}