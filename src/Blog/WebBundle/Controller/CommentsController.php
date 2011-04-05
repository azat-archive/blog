<?php

/**
 * Class: CommentsController
 * Date begin: Mar 16, 2011
 * 
 * Comments controller
 * 
 * @package blog
 * @author Azat Khuzhin
 */

namespace Blog\WebBundle\Controller;

use	Blog\WebBundle\Form\CommentsAdd as CommentsAddForm,
	Blog\WebBundle\Entity\Comments;

class CommentsController extends Controller {
      /**
	 * @extra:Route("/post/{pid}/show-comments", name="_comments_show")
	 * @extra:Template()
	 */
	public function showAction($pid) {
		$em = $this->getEm();
		$comments = $em->getRepository('Blog\\WebBundle\Entity\Comments')->findByPid($pid);
		return array('comments' => $comments);
	}
	
      /**
	 * @extra:Route("/post/{pid}/add-comment", name="_comments_add")
	 * @extra:Template()
	 */
	public function addAction($pid) {
		$em = $this->getEm();
		$post = $em->find('Blog\\WebBundle\\Entity\\Posts', $pid);
		// not found
		if (!$post) {
			throw ExceptionController::notFound('The post does not exist.');
		}
		
		$comment = new Comments;
		$form = CommentsAddForm::create($this->get('form.context'), 'comments_add');
		
		$form->bind($this->get('request'), $comment);
		if ($form->isValid()) {
			$comment->setUser($this->getUser());
			$comment->setPost($post);
			
			$em = $this->getEm();
			$em->persist($comment);
			$em->flush();
			
			return $this->redirectGenerate('_posts_show', array('pid' => $pid));
		}
		
		return array('form' => $form, 'pid' => $pid);
	}
	
	/**
	 * @extra:Route("/post/{pid}/comment/{cid}/edit-post", name="_comments_edit")
	 * @extra:Template()
	 */
	public function editAction($pid, $cid) {
		$em = $this->getEm();
		$commentEdit = $em->find('Blog\\WebBundle\\Entity\\Comments', $cid);
		// not found
		if (!$commentEdit) {
			throw ExceptionController::notFound('The comment does not exist.');
		}
		$form = CommentsAddForm::create($this->get('form.context'), 'comments_edit');
		
		$form->bind($this->get('request'), $commentEdit);
		if ($form->isValid()) {
			$em->persist($commentEdit);
			$em->flush();
			
			return $this->redirectGenerate('_posts_show', array('pid' => $pid));
		}
		
		return array('form' => $form, 'pid' => $pid, 'commentEdit' => $commentEdit);
	}
	
	/**
	 * @extra:Route("/post/{pid}/comment/{cid}/delete", name="_comments_delete")
	 */
	public function deleteAction($pid, $cid) {
		$em = $this->getEm();
		$comment = $em->find('Blog\\WebBundle\\Entity\\Comments', $cid);
		// not found
		if (!$comment) {
			throw ExceptionController::notFound('The comment does not exist.');
		}
		$em->remove($comment);
		$em->flush();
		
		return $this->redirectGenerate('_posts_show', array('pid' => $pid));
	}
}
