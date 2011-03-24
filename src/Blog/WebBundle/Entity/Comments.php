<?php

namespace Blog\WebBundle\Entity;

/**
 * Blog\WebBundle\Entity\Comments
 *
 * @orm:Table(name="comments")
 * @orm:Entity
 */
class Comments
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
     * @var integer $pid
     *
     * @orm:Column(name="pid", type="integer", nullable=false)
     * @validation:Int()
     */
    private $pid;


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

    /**
     * Set pid
     *
     * @param integer $pid
     */
    public function setPid($pid)
    {
        $this->pid = $pid;
    }

    /**
     * Get pid
     *
     * @return integer $pid
     */
    public function getPid()
    {
        return $this->pid;
    }
}