<?php

/**
 * Class: SecurityInteractiveLogin
 * Date begin: Apr 4, 2011
 * 
 * Security Inreactive Login Listener
 * Update last login time of user
 * 
 * @package blog
 * @author Azat Khuzhin
 */

namespace Blog\WebBundle\Listener;

use	Symfony\Component\Security\Http\Event\InteractiveLoginEvent,
	Symfony\Component\Config\Definition\Exception\InvalidTypeException,
	Doctrine\ORM\EntityManager,
	Blog\WebBundle\Entity\Users;

class SecurityInteractiveLogin {
	/**
	 * EntityManager
	 *
	 * @var EntityManager
	 */
	private $em;
	
	/**
	 * Init
	 *
	 * @param EntityManager $em 
	 */
	public function __construct(EntityManager $em) {
		$this->em = $em;
	}
	
	/**
	 * Handle event
	 *
	 * @param InteractiveLoginEvent $event 
	 */
	public function onSecurityInteractiveLogin(InteractiveLoginEvent $event) {
		$user = $event->getAuthenticationToken()->getUser();

		if (!$user instanceof Users) {
			throw new InvalidTypeException('User must be instance of Users');
		}
		
		$user->setLastLoginTime(time());
		$this->em->flush($user);
	}
}
