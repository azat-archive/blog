<?php

/**
 * File: UsersEdit
 * Date begin: Mar 25, 2011
 * 
 * @package blog
 * @author Azat Khuzhin
 */

namespace Blog\WebBundle\Request;

class UsersEdit {
	/**
	 * @var string $login
	 *
	 * @orm:Column(name="login", type="string", length=255, nullable=false)
	 * @assert:NotBlank()
	 */
	private $login;
	/**
	 * @var string $firstName
	 *
	 * @orm:Column(name="first_name", type="string", length=255, nullable=false)
	 * @assert:NotBlank()
	 */
	private $firstName;
	/**
	 * @var string $secondName
	 *
	 * @orm:Column(name="second_name", type="string", length=255, nullable=false)
	 * @assert:NotBlank()
	 */
	private $secondName;


	/**
	 * Set login
	 *
	 * @param string $login
	 * @return UsersEdit
	 */
	public function setLogin($login) {
		$this->login = $login;
		return $this;
	}

	/**
	 * Get login
	 *
	 * @return string $login
	 */
	public function getLogin() {
		return $this->login;
	}

	/**
	 * Set firstName
	 *
	 * @param string $firstName
	 * @return UsersEdit
	 */
	public function setFirstName($firstName) {
		$this->firstName = $firstName;
		return $this;
	}

	/**
	 * Get firstName
	 *
	 * @return string $firstName
	 */
	public function getFirstName() {
		return $this->firstName;
	}

	/**
	 * Set secondName
	 *
	 * @param string $secondName
	 * @return UsersEdit
	 */
	public function setSecondName($secondName) {
		$this->secondName = $secondName;
		return $this;
	}

	/**
	 * Get secondName
	 *
	 * @return string $secondName
	 */
	public function getSecondName() {
		return $this->secondName;
	}
}
