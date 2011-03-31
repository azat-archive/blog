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

use 	Symfony\Component\Security\Core\SecurityContext;

use	Blog\WebBundle\Form\UsersSignup as UsersSignupForm,
	Blog\WebBundle\Form\UsersLogin as UsersLoginForm,
	Blog\WebBundle\Request\UsersLogin as UsersLoginRequest,
	Blog\WebBundle\Entity\Users;

class UsersController extends Controller {
      /**
	 * @extra:Route("/users/", name="_users_index")
	 */
	public function indexAction() {}
	
	/**
	 * @extra:Route("/users/signup", name="_users_signup")
	 * @extra:Template()
	 */
	public function signupAction() {
		$user = new Users;
		$form = UsersSignupForm::create($this->get('form.context'), 'users_signup');

		$form->bind($this->get('request'), $user);
		if ($form->isValid()) {
			$user->transformPassword();
			
			$em = $this->getEm();
			$em->persist($user);
			$em->flush();
			
			$this->get('session')->setFlash('notice', 'Signup success!');
			return $this->redirectGenerate('_index');
		}

		return array('form' => $form);
	}
	
	/**
	 * @extra:Route("/users/login", name="_users_login")
	 * @extra:Template()
	 */
	public function loginAction() {
		$userRequest = new UsersLoginRequest;
		$form = UsersLoginForm::create($this->get('form.context'), 'users_login');
		
		$form->bind($this->get('request'), $userRequest);
		
		// get the error if any (works with forward and redirect -- see below)
		if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
			$error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
		} else {
			$error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
		}
		if (method_exists($error, 'getMessage')) {
			$error = $error->getMessage();
		}
		
		return array('form' => $form, 'error' => $error);
	}
}
