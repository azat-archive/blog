<?php

/**
 * File: UsersLogin
 * Date begin: Mar 25, 2011
 * 
 * @package blog
 * @author Azat Khuzhin
 */

namespace Blog\WebBundle\Request;

class UsersLogin {
	/**
	 * @var string $email
	 *
	 * @orm:Column(name="email", type="string", length=255, nullable=false)
	 * @assert:Email()
	 */
	private $email;
	/**
	 * @var string $password
	 *
	 * @orm:Column(name="password", type="string", length=32, nullable=false)
	 * @assert:NotBlank()
	 */
	private $password;

	
	/**
	 * Set email
	 *
	 * @param string $email
	 * @return UsersLogin
	 */
	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}

	/**
	 * Get email
	 *
	 * @return string $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Set password
	 *
	 * @param string $password
	 * @return UsersLogin
	 */
	public function setPassword($password) {
		$this->password = $password;
		return $this;
	}

	/**
	 * Get password
	 *
	 * {@inheritdoc}
	 * 
	 * @return string $password
	 */
	public function getPassword() {
		return $this->password;
	}
}
