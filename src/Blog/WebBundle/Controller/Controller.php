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

use	Blog\WebBundle\Templating\Helper\Title as TitleHelper;

abstract class Controller extends BaseController {
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
		// add default title
		$this->addTitle('Blog');
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
	 * {@inheritdoc}
	 */
	public function setContainer(ContainerInterface $container = null) {
		parent::setContainer($container);
		
		$this->_init();
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
	 * Add title
	 * 
	 * {@inheritdoc}
	 */
	protected function addTitle() {
		$args = func_get_args();
		return call_user_func_array(array(TitleHelper::getInstance(), 'add'), $args);
	}
}
