<?php

/**
 * Class: UsersSignup
 * Date begin: Mar 16, 2011
 * 
 * Signup form
 * 
 * @package blog
 * @author Azat Khuzhin
 */

namespace Blog\WebBundle\Form;

use	Symfony\Component\Form\Form,
	Symfony\Component\Form\TextField,
	Symfony\Component\Form\PasswordField,
	Symfony\Component\Form\RepeatedField,
	Symfony\Component\Form\BirthdayField;

use	Symfony\Component\Validator\Constraints\EmailValidator;

class UsersSignup extends Form {
	public $email;
	public $login;
	// public $birthday;
	public $firstName;
	public $secondName;
	public $password;
	
	
	/**
	 * {@inheritdoc}
	 */
	public function configure() {
		$this->setDataClass('Blog\\WebBundle\\Entity\\Users');
		
		$this->add('email');
		$this->add('login');
		// $this->add(new BirthdayField('birthday');
		$this->add('firstName');
		$this->add('secondName');
		$this->add(new RepeatedField(new PasswordField('password'), array('second_key' => 'Again')));
	}
}
