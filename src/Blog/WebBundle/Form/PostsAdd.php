<?php

/**
 * Class: PostsAdd
 * Date begin: Mar 16, 2011
 * 
 * Add post form
 * 
 * @package blog
 * @author Azat Khuzhin
 */

namespace Blog\WebBundle\Form;

use	Symfony\Component\Form\Form,
	Symfony\Component\Form\TextareaField;

class PostsAdd extends Form {
	public $title;
	public $content;
	
	
	/**
	 * {@inheritdoc}
	 */
	public function configure() {
		$this->setDataClass('Blog\\WebBundle\\Entity\\Posts');
		
		$this->add(new TextareaField('title'));
		$this->add(new TextareaField('content'));
	}
}
