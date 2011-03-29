<?php

/**
 * Class: CommentsAdd
 * Date begin: Mar 16, 2011
 * 
 * Add comment form
 * 
 * @package blog
 * @author Azat Khuzhin
 */

namespace Blog\WebBundle\Form;

use	Symfony\Component\Form\Form,
	Symfony\Component\Form\TextareaField;

class CommentsAdd extends Form {
	public $content;
	
	
	/**
	 * {@inheritdoc}
	 */
	public function configure() {
		$this->setDataClass('Blog\\WebBundle\\Entity\\Comments');
		
		$this->add(new TextareaField('content'));
	}
}
