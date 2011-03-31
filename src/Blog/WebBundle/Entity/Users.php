<?php

namespace Blog\WebBundle\Entity;

use	Symfony\Component\Security\Core\User\UserInterface,
	Symfony\Component\Security\Core\Role\Role,
	Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

use	Blog\WebBundle\ACL\SimpleACL,
	Blog\WebBundle\Exception;

/**
 * Blog\WebBundle\Entity\Users
 * 
 * @todo add create/edit/delete time
 * 
 * @orm:Table(name="users")
 * @orm:Entity
 */
class Users implements UserInterface, SimpleACL {
	/**
	 * @var integer $id
	 *
	 * @orm:Column(name="id", type="integer", nullable=false)
	 * @orm:Id
	 * @orm:GeneratedValue(strategy="IDENTITY")
	 * @validation:Int()
	 */
	private $id;
	/**
	 * @var string $login
	 *
	 * @orm:Column(name="login", type="string", length=255, nullable=false)
	 * @validation:NotBlank()
	 */
	private $login;
	/**
	 * @var string $email
	 *
	 * @orm:Column(name="email", type="string", length=255, nullable=false)
	 * @validation:Email()
	 */
	private $email;
	/**
	 * @var string $password
	 *
	 * @orm:Column(name="password", type="string", length=32, nullable=false)
	 * @validation:NotBlank()
	 */
	private $password;
	/**
	 * @var string $firstName
	 *
	 * @orm:Column(name="first_name", type="string", length=255, nullable=false)
	 * @validation:NotBlank()
	 */
	private $firstName;
	/**
	 * @var string $secondName
	 *
	 * @orm:Column(name="second_name", type="string", length=255, nullable=false)
	 * @validation:NotBlank()
	 */
	private $secondName;

	
	/**
	 * Get id
	 *
	 * @return integer $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set login
	 *
	 * @param string $login
	 * @return Blog\WebBundle\Entity\Posts
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
	 * Set email
	 *
	 * @param string $email
	 * @return Blog\WebBundle\Entity\Posts
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
	 * @return Blog\WebBundle\Entity\Posts
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

	/**
	 * Set firstName
	 *
	 * @param string $firstName
	 * @return Blog\WebBundle\Entity\Posts
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
	 * @return Blog\WebBundle\Entity\Posts
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
	
	/**
	 * {@inheritdoc}
	 */
	public function getRoles() {
		return array(new Role('ROLE_USER'));
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getSalt() {
		$email = $this->getEmail();
		if (!$email) {
			throw new \Exception('"email" can`t be empty');
		}
		return mb_substr(md5($email), 3, 3);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getUsername() {
		return $this->email;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function eraseCredentials() {
		return true;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function equals(UserInterface $user) {
		if (!$user instanceof Users) {
			return false;
		}
		
		return (trim(mb_strtolower($user->email)) == trim(mb_strtolower($this->email)));
	}
	
	/**
	 * Tranform password
	 * @todo dynamic algoritm from settings
	 *
	 * @param string $password
	 * @return Blog\WebBundle\Entity\Posts
	 */
	public function transformPassword() {
		$password = $this->getPassword();
		if (!$password) {
			throw new \Exception('"password" can`t be empty');
		}
		$encoder = new MessageDigestPasswordEncoder('sha1');
		$this->setPassword($encoder->encodePassword($password, $this->getSalt()));
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function canEdit($user) {
		if (is_numeric($user)) {
			return ($user == $this->id);
		}
		if ($user instanceof Users) {
			return ($user->id == $this->id);
		}
		
		throw new Exception('$user must be instance of Users or numberic');
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function canDelete($user) {
		if (is_numeric($user)) {
			return ($user == $this->getId());
		}
		if ($user instanceof Users) {
			return ($user->getId() == $this->getId());
		}
		
		throw new Exception('$user must be instance of Users or numberic');
	}
}
