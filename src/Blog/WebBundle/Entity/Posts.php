<?php

namespace Blog\WebBundle\Entity;

/**
 * Blog\WebBundle\Entity\Posts
 *
 * @orm:Table(name="posts")
 * @orm:Entity
 */
class Posts
{
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
     * @var string $title
     *
     * @orm:Column(name="title", type="string", length=255, nullable=false)
     * @validation:NotBlank()
     */
    private $title;

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
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param text $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return text $content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set uid
     *
     * @param integer $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * Get uid
     *
     * @return integer $uid
     */
    public function getUid()
    {
        return $this->uid;
    }
}