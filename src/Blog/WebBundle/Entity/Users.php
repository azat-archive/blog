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
 * @orm:Table(name="users")
 * @orm:Entity
 */
class Users implements Entity, UserInterface, SimpleACL {
	/**
	 * @var integer $id
	 *
	 * @orm:Column(name="id", type="integer", nullable=false)
	 * @orm:Id
	 * @orm:GeneratedValue(strategy="IDENTITY")
	 * @assert:Int()
	 */
	private $id;
	/**
	 * @var string $login
	 *
	 * @orm:Column(name="login", type="string", length=255, nullable=false)
	 * @assert:NotBlank()
	 */
	private $login;
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
	 * @validation:NotBlank()
	 */
	private $secondName;
	/**
	 * @var string $createTime
	 *
	 * @orm:Column(name="create_time", type="integer", length=10, nullable=false)
	 */
	private $createTime;
	/**
	 * @var string $createTime
	 *
	 * @orm:Column(name="last_login_time", type="integer", length=10, nullable=false)
	 */
	private $lastLoginTime;

	
	public function __construct() {
		$this->createTime = time();
		$this->lastLoginTime = 0;
	}
	
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
	 * @return Users
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
	 * @return Users
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
	 * @return Users
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
	 * @return Users
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
	 * @return Users
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
	 * Set createTime
	 * 
	 * @param integer $createTime
	 * @return Users
	 */
	public function setCreateTime($createTime) {
		$this->createTime = $createTime;
		return $this;
	}
	
	/**
	 * Get createTime
	 * 
	 * @return integer $createTime
	 */
	public function getCreateTime() {
		return $this->createTime;
	}
	
	/**
	 * Set lastLoginTime
	 * 
	 * @param integer $lastLoginTime
	 * @return Users
	 */
	public function setLastLoginTime($lastLoginTime) {
		$this->lastLoginTime = $lastLoginTime;
		return $this;
	}
	
	/**
	 * Get lastLoginTime
	 * 
	 * @return integer $lastLoginTime
	 */
	public function getLastLoginTime() {
		return $this->lastLoginTime;
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
	
	/**
	 * {@inheritdoc}
	 */
	public function __toString() {
		return sprintf('%s %s %s', $this->getFirstName(), $this->getLogin(), $this->getSecondName());
	}
}
