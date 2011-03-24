<?php

namespace Blog\WebBundle\Entity;

/**
 * Blog\WebBundle\Entity\Users
 *
 * @orm:Table(name="users")
 * @orm:Entity
 */
class Users
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set login
     *
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * Get login
     *
     * @return string $login
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Get firstName
     *
     * @return string $firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set secondName
     *
     * @param string $secondName
     */
    public function setSecondName($secondName)
    {
        $this->secondName = $secondName;
    }

    /**
     * Get secondName
     *
     * @return string $secondName
     */
    public function getSecondName()
    {
        return $this->secondName;
    }
}