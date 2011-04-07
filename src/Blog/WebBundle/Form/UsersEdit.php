<?php

/**
 * Class: UsersEdit
 * Date begin: Mar 16, 2011
 * 
 * Edit form
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

class UsersEdit extends Form {
	public $login;
	public $firstName;
	public $secondName;
	
	
	/**
	 * {@inheritdoc}
	 */
	public function configure() {
		$this->setDataClass('Blog\\WebBundle\\Request\\UsersEdit');
		
		$this->add('login');
		$this->add('firstName');
		$this->add('secondName');
	}
}
