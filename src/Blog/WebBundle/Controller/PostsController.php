<?php

/**
 * Class: PostsController
 * Date begin: Mar 16, 2011
 * 
 * Posts controller
 * 
 * @todo add create/edit/delete time
 * 
 * @package blog
 * @author Azat Khuzhin
 */

namespace Blog\WebBundle\Controller;

use	Blog\WebBundle\Form\PostsAdd as PostsAddForm,
	Blog\WebBundle\Entity\Posts;

class PostsController extends Controller {
      /**
	 * @extra:Route("/posts/", name="_posts")
	 * @extra:Template()
	 */
	public function indexAction() {
		$em = $this->getEm();
		$posts = $em->getRepository('Blog\\WebBundle\\Entity\\Posts')->findAll();
		return array('posts' => $posts);
	}
	
      /**
	 * @extra:Route("/post/{pid}", name="_posts_show")
	 * @extra:Template()
	 */
	public function showAction($pid) {
		$em = $this->getEm();
		$post = $em->find('Blog\\WebBundle\\Entity\\Posts', $pid);
		// not found
		if (!$post) {
			throw new NotFoundHttpException('The post does not exist.');
		}
		
		return array('post' => $post);
	}
	
      /**
	 * @extra:Route("/add-post", name="_posts_add")
	 * @extra:Template()
	 */
	public function addAction() {
		$post = new Posts;
		$form = PostsAddForm::create($this->get('form.context'), 'posts_add');
		
		$form->bind($this->get('request'), $post);
		if ($form->isValid()) {
			$post->setUser($this->getUser());
			
			$em = $this->getEm();
			$em->persist($post);
			$em->flush();
			
			return $this->redirect('_posts');
		}

		return array('form' => $form);
	}
	
	/**
	 * @extra:Route("/post/{pid}/edit", name="_posts_edit")
	 * @extra:Template()
	 */
	public function editAction($pid) {
		$em = $this->getEm();
		$post = $em->find('Blog\\WebBundle\\Entity\\Posts', $pid);
		// not found
		if (!$post) {
			throw new NotFoundHttpException('The post does not exist.');
		}
		$form = PostsAddForm::create($this->get('form.context'), 'posts_edit');
		
		$form->bind($this->get('request'), $post);
		if ($form->isValid()) {
			$em->persist($post);
			$em->flush();
			
			return $this->redirect('_posts');
		}

		return array('form' => $form);
	}
	
	/**
	 * @extra:Route("/post/{pid}/delete", name="_comments_delete")
	 */
	public function deleteAction($pid) {
		$em = $this->getEm();
		$post = $em->find('Blog\\WebBundle\\Entity\\Posts', $pid);
		// not found
		if (!$post) {
			throw new NotFoundHttpException('The post does not exist.');
		}
		$em->remove($post);
		$em->flush();
		
		return $this->redirect('_posts');
	}
}
