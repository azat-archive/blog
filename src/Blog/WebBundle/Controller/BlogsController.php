<?php

/**
 * Class: BlogsController
 * Date begin: Mar 16, 2011
 * 
 * Blogs controller
 * 
 * @package blog
 * @author Azat Khuzhin
 */

namespace Blog\WebBundle\Controller;

use	Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\Security\Core\SecurityContext,
	Symfony\Component\HttpFoundation\RedirectResponse;

class BlogsController extends Controller {
      /**
	 * @extra:Route("/blogs/", name="_blogs")
	 * @extra:Template()
	 */
	public function indexAction() {
		return array();
	}
	
      /**
	 * @extra:Route("/blog/add", name="_blogs_add")
	 * @extra:Template()
	 */
	public function addAction() {
		return array();
	}
	
	/**
	 * @extra:Route("/blog/edit/{id}", name="_blogs_edit")
	 * @extra:Template()
	 */
	public function editAction() {
		return array();
	}
}
