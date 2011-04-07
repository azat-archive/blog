<?php

/**
 * Class: PostsController
 * Date begin: Mar 16, 2011
 * 
 * Posts controller
 * 
 * @package blog
 * @author Azat Khuzhin
 */

namespace Blog\WebBundle\Controller;

use	Blog\WebBundle\Form\PostsAdd as PostsAddForm,
	Blog\WebBundle\Entity\Posts;

class PostsController extends Controller {
      /**
	 * @extra:Route("/posts/{pageLabel}/{page}/", name="_posts", requirements={"page" = "\d+", "pageLabel" = "page"}, defaults={"page" = 1, "pageLabel" = "page"})
	 * @extra:Template()
	 * 
	 * @todo SQL_CALC_FOUND_ROWS
	 */
	public function indexAction($pageLabel, $page) {
		$em = $this->getEm();
		
		// fetch posts
		$qb = $em->createQueryBuilder()
			   ->select('p', 'u')
			   ->from('Blog\\WebBundle\\Entity\\Posts', 'p')
			   ->join('p.user', 'u');
		$q = $qb->getQuery();
		
		// get posts num (without join tables)
		$num = $em->createQueryBuilder()
			    ->select('COUNT(p)')
			    ->from('Blog\\WebBundle\\Entity\\Posts', 'p')
			    ->setMaxResults(1)
			    ->getQuery()
			    ->getSingleScalarResult();
		
		// paginator
		$paginatorAdapter = $this->getPaginatorAdapter()
						 ->setQuery($q, $num)
						 ->setDistinct(true);
		$paginator = $this->createPaginator($paginatorAdapter);

		$this->addTitle('Posts');
		return array('paginator' => $paginator);
	}
	
      /**
	 * @extra:Routes({
	 *	@extra:Route("/post/{pid}/", requirements={"pid" = "\d+"}, name="_posts_show"),
	 *	@extra:Route("/post/{pid}/#comments", name="_posts_show_comments"),
	 *	@extra:Route("/post/{pid}/edit-comment/{cid}", requirements={"pid" = "\d+", "cid" = "\d+"}, name="_posts_show_comments_edit")
	 * })
	 * @extra:Template()
	 */
	public function showAction($pid, $cid = null) {
		$em = $this->getEm();
		$post = $em->find('Blog\\WebBundle\\Entity\\Posts', $pid);
		// not found
		if (!$post) {
			throw ExceptionController::notFound('The post does not exist.');
		}
		
		$this->addTitle('Posts', $post);
		return array('post' => $post, 'commentEdit' => $cid);
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
			
			return $this->redirectGenerate('_posts_show', array('pid' => $post->getId()));
		}

		$this->addTitle('Posts', 'Add post');
		return array('form' => $form);
	}
	
	/**
	 * @extra:Route("/post/{pid}/edit", requirements={"pid" = "\d+"}, name="_posts_edit")
	 * @extra:Template()
	 */
	public function editAction($pid) {
		$em = $this->getEm();
		$post = $em->find('Blog\\WebBundle\\Entity\\Posts', $pid);
		// not found
		if (!$post) {
			throw ExceptionController::notFound('The post does not exist.');
		}
		$form = PostsAddForm::create($this->get('form.context'), 'posts_edit');
		
		$form->bind($this->get('request'), $post);
		if ($form->isValid()) {
			$post->setEditTime(time());
			$em->persist($post);
			$em->flush();
			
			return $this->redirectGenerate('_posts_show', array('pid' => $pid));
		}

		$this->addTitle('Posts', 'Edit post', $post);
		return array('form' => $form);
	}
	
	/**
	 * @extra:Route("/post/{pid}/delete", name="_posts_delete")
	 */
	public function deleteAction($pid) {
		$em = $this->getEm();
		$post = $em->find('Blog\\WebBundle\\Entity\\Posts', $pid);
		// not found
		if (!$post) {
			throw ExceptionController::notFound('The post does not exist.');
		}
		$em->remove($post);
		$em->flush();
		
		return $this->redirectGenerate('_posts');
	}
}
