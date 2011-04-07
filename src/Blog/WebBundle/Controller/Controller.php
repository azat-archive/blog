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
	/**
	 * Entity manager
	 *
	 * @var Doctrine\ORM\EntityManager
	 */
	private $em;
	/**
	 * User
	 *
	 * @var Blog\WebBundle\Entity\Users
	 */
	private $user;
	/**
	 * Template
	 *
	 * @var Twig_Environment
	 */
	private $template;
	/**
	 * Doctrine paginator adapter
	 *
	 * @var \Knplabs\Bundle\PaginatorBundle\Paginator\Adapter\Doctrine
	 */
	private $paginatorAdapter;
	
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
		$this->template->addGlobal('currentUser', $this->user);
		// add default title
		$this->addTitle('Blog');
		
		$this->paginatorAdapter = $this->container->get('knplabs_paginator.adapter');
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
	
	/**
	 * Get paginator adapter
	 *
	 * @return \Knplabs\Bundle\PaginatorBundle\Paginator\Adapter\Doctrine
	 */
	protected function getPaginatorAdapter() {
		return $this->paginatorAdapter;
	}
	
	/**
	 * Create paginator
	 *
	 * @param \Knplabs\Bundle\PaginatorBundle\Paginator\Adapter\Doctrine $adapter 
	 * @return \Zend\Paginator\Paginator
	 */
	protected function createPaginator(\Knplabs\Bundle\PaginatorBundle\Paginator\Adapter\Doctrine $adapter) {
		$paginator = new \Zend\Paginator\Paginator($adapter);
		$paginator->setItemCountPerPage(20);
		$paginator->setPageRange(5);
		$paginator->setCurrentPageNumber($this->container->get('request')->get('page'));
		
		return $paginator;
	}
}
