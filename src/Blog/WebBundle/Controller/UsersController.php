<?php

/**
 * Class: UsersController
 * Date begin: Mar 16, 2011
 * 
 * Users controller
 * 
 * @package blog
 * @author Azat Khuzhin
 */

namespace Blog\WebBundle\Controller;

use	Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\RedirectResponse;

use	Blog\WebBundle\Form\UsersSignupForm,
	Blog\WebBundle\Form\UsersLoginForm,
	Blog\WebBundle\Entity\Users;

class UsersController extends Controller {
      /**
	 * @extra:Route("/users/", name="_users_index")
	 */
	public function indexAction() {}
	
	/**
	 * @extra:Route("/users/signup", name="_users_signup")
	 */
	public function signupAction() {
		$user = new Users;
		// $form = new UsersSignupForm('user', $user, $this->get('validator'));
		$form = UsersSignupForm::create($this->get('form.context'), 'signup');

		$form->bind($this->container->get('request'), $user);
		if ($form->isValid()) {
			$em = $this->get('doctrine.orm.entity_manager');
			$em->persist($user);
			$em->flush();
			
			$this->get('session')->setFlash('notice', 'Valid!');
			return new RedirectResponse($this->generateUrl('_index'));
		}

		return $this->render('BlogWebBundle:Users:signup.html.twig', array('form' => $form));
	}
	
	/**
	 * @extra:Route("/users/login", name="_users_login")
	 */
	public function loginAction() {
		$user = new Users;
		// $form = new UsersLoginForm('user', $user, $this->get('validator'));
		$form = UsersLoginForm::create($this->get('form.context'), 'login');

		$form->bind($this->container->get('request'), $user);
		if ($form->isValid()) {
			// @TODO add authorization
			$this->get('session')->setFlash('notice', 'Valid!');
			return new RedirectResponse($this->generateUrl('_index'));
		}
		
		return $this->render('BlogWebBundle:Users:login.html.twig', array('form' => $form));
	}
}
