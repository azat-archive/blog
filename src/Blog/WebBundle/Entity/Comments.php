<?php

namespace Blog\WebBundle\Entity;

use	Blog\WebBundle\ACL\SimpleACL,
	Blog\WebBundle\Exception;

/**
 * Blog\WebBundle\Entity\Comments
 * 
 * @todo add create/edit/delete time
 * 
 * @orm:Table(name="comments")
 * @orm:Entity
 */
class Comments implements SimpleACL {
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
	 * @var text $content
	 *
	 * @orm:Column(name="content", type="text", nullable=false)
	 * @validation:NotBlank()
	 */
	private $content;
	/**
	 * @var integer $uid
	 *
	 * @orm:Column(name="uid", type="integer", nullable=false)
	 * @validation:Int()
	 */
	private $uid;
	/**
	 * @OneToOne(targetEntity="Users", inversedBy="Comments")
	 * @JoinColumn(name="uid", referencedColumnName="id", onDelete="CASCADE", nullable=false)
	 */
	private $user;
	/**
	 * @var integer $pid
	 *
	 * @orm:Column(name="pid", type="integer", nullable=false)
	 * @validation:Int()
	 */
	private $pid;
	/**
	 * @ManyToOne(targetEntity="Posts", inversedBy="Comments")
	 * @JoinColumn(name="pid", referencedColumnName="id", onDelete="CASCADE", nullable=false)
	 */
	private $post;
	
	/**
	 * Get id
	 *
	 * @return integer $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set content
	 *
	 * @param text $content
	 * @return Blog\WebBundle\Entity\Posts
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
	 * @return Blog\WebBundle\Entity\Posts
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
	 * Set pid
	 *
	 * @param integer $pid
	 * @return Blog\WebBundle\Entity\Posts
	 */
	public function setPid($pid) {
		$this->pid = $pid;
		return $this;
	}

	/**
	 * Get pid
	 *
	 * @return integer $pid
	 */
	public function getPid() {
		return $this->pid;
	}

	/**
	 * Set user
	 *
	 * @param Users $user
	 * @return Blog\WebBundle\Entity\Posts
	 */
	public function setUser(Users $user) {
		$this->user = $user;
		return $this;
	}

	/**
	 * Get user
	 *
	 * @return integer $uid
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * Set post
	 *
	 * @param Posts $post
	 * @return Blog\WebBundle\Entity\Posts
	 */
	public function setPost(Posts $post) {
		$this->post = $post;
		return $this;
	}

	/**
	 * Get post
	 *
	 * @return object $uid
	 */
	public function getPost() {
		return $this->post;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function canEdit($user) {
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
	public function canDelete($user) {
		if (is_numeric($user)) {
			return ($user == $this->getUid());
		}
		if ($user instanceof Users) {
			return ($user->getId() == $this->getUid());
		}
		
		throw new Exception('$user must be instance of Users or numberic');
	}
}
