<?php

namespace Blog\WebBundle\Entity;

use	Blog\WebBundle\ACL\SimpleACL,
	Blog\WebBundle\Exception;

/**
 * Blog\WebBundle\Entity\Posts
 * 
 * @orm:Table(name="posts")
 * @orm:Entity
 */
class Posts implements Entity, SimpleACL {
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
	 * @var string $title
	 *
	 * @orm:Column(name="title", type="string", length=255, nullable=false)
	 * @assert:NotBlank()
	 */
	private $title;
	/**
	 * @var text $content
	 *
	 * @orm:Column(name="content", type="text", nullable=false)
	 * @assert:NotBlank()
	 */
	private $content;
	/**
	 * @var integer $uid
	 *
	 * @orm:Column(name="uid", type="integer", nullable=false)
	 * @assert:Int()
	 */
	private $uid;
	/**
	 * @var string $createTime
	 *
	 * @orm:Column(name="create_time", type="integer", length=10, nullable=false)
	 */
	private $createTime;
	/**
	 * @var string $createTime
	 *
	 * @orm:Column(name="edit_time", type="integer", length=10, nullable=false)
	 */
	private $editTime;
	/**
	 * @orm:InheritanceType("JOINED")
	 * @orm:OneToOne(targetEntity="Users")
	 * @orm:JoinColumn(name="uid", referencedColumnName="id", onDelete="CASCADE", nullable=false)
	 */
	private $user;
	
	
	public function __construct() {
		$this->createTime = time();
		$this->editTime = 0;
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
	 * Set title
	 *
	 * @param string $title
	 * @return Posts
	 */
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}

	/**
	 * Get title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Set content
	 *
	 * @param text $content
	 * @return Posts
	 */
	public function setContent($content) {
		$this->content = $content;
		return $this;
	}

	/**
	 * Get content
	 *
	 * @return text $content
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * Set uid
	 *
	 * @param integer $uid
	 * @return Posts
	 */
	public function setUid($uid) {
		$this->uid = $uid;
		return $this;
	}

	/**
	 * Get uid
	 *
	 * @return integer $uid
	 */
	public function getUid() {
		return $this->uid;
	}
	
	/**
	 * Set createTime
	 * 
	 * @param integer $createTime
	 * @return Posts
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
	 * Set editTime
	 * 
	 * @param integer $editTime
	 * @return Posts
	 */
	public function setEditTime($editTime) {
		$this->editTime = $editTime;
		return $this;
	}
	
	/**
	 * Get editTime
	 * 
	 * @return integer $editTime
	 */
	public function getEditTime() {
		return $this->editTime;
	}

	/**
	 * Set user
	 *
	 * @param Users $user
	 * @return Posts
	 */
	public function setUser(Users $user) {
		$this->user = $user;
		return $this;
	}

	/**
	 * Get user
	 *
	 * @return Users $user
	 */
	public function getUser() {
		return $this->user;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function canEdit($user) {
		if (is_numeric($user)) {
			return ($user == $this->getId());
		}
		if ($user instanceof Users) {
			return ($user->getId() == $this->getUid());
		}
		
		throw new Exception('$user must be instance of Users or numberic');
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function canDelete($user) {
		if (is_numeric($user)) {
			return ($user == $this->getUid());
		}
		if ($user instanceof Users) {
			return ($user->getId() == $this->getUid());
		}
		
		throw new Exception('$user must be instance of Users or numberic');
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function __toString() {
		return $this->getTitle();
	}
}
