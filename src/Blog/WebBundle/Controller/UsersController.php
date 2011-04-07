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
	Blog\WebBundle\Form\UsersEdit as UsersEditForm,
	Blog\WebBundle\Request\UsersEdit as UsersEditRequest,
	Blog\WebBundle\Entity\Users;

class UsersController extends Controller {
      /**
	 * @extra:Route("/user/{uid}", requirements={"uid" = "\d+"}, name="_users_show")
	 * @extra:Template()
	 */
	public function showAction($uid) {
		$em = $this->getEm();
		$user = $em->find('Blog\\WebBundle\\Entity\\Users', $uid);
		// not found
		if (!$user) {
			throw ExceptionController::notFound('The user does not exist.');
		}
		
		$this->addTitle('Posts', $user);
		return array('user' => $user);
	}
	
	/**
	 * @extra:Route("/user/{uid}/edit", name="_users_edit")
	 * @extra:Template()
	 */
	public function editAction($uid) {
		$user = $this->getUser();
		$form = UsersEditForm::create($this->get('form.context'), 'users_edit');
		
		$userRequest = new UsersEditRequest();
		$userRequest->setFirstName($user->getFirstName())
				->setLogin($user->getLogin())
				->setSecondName($user->getSecondName());
		
		$form->bind($this->get('request'), $userRequest);
		if ($form->isValid()) {
			$user->setFirstName($userRequest->getFirstName())
			     ->setLogin($userRequest->getLogin())
			     ->setSecondName($userRequest->getSecondName());
			
			$em = $this->getEm();
			$em->persist($user);
			$em->flush();
			
			return $this->redirectGenerate('_users_show', array('uid' => $user->getId()));
		}
		
		return array('form' => $form);
	}
	
	/**
	 * @extra:Route("/users/{uid}/delete", name="_users_delete")
	 */
	public function deleteAction($uid) {
		$em = $this->getEm();
		$em->remove($user);
		$em->flush();
		
		return $this->redirectGenerate('_security_logout');
	}
	
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
			// check is user with such emails exists
			$alreadyExistedUser = $em->getRepository('Blog\\WebBundle\\Entity\\Users')->findOneByEmail($user->getEmail());
			if (!$alreadyExistedUser) {
				$em->persist($user);
				$em->flush();

				$this->get('session')->setFlash('notice', 'Signup success!');
				return $this->redirectGenerate('_index');
			}
			
			$this->get('session')->setFlash('notice', 'Such user already exists!');
		}

		$this->addTitle('Users', 'Signup');
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
		
		$this->addTitle('Users', 'Login');
		return array('form' => $form, 'error' => $error);
	}
	
	/**
	 * @extra:Route("/login_check", name="_security_check")
	 */
	public function securityCheckAction() {
		// The security layer will intercept this request
	}

	/**
	 * @extra:Route("/logout", name="_security_logout")
	 */
	public function securityLogoutAction() {
		// The security layer will intercept this request
	}
}
