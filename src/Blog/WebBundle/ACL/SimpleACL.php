<?php

/**
 * Class: SimpleACL
 * Date begin: Mar 16, 2011
 * 
 * Simple ACL interface
 * 
 * @package blog
 * @author Azat Khuzhin
 */

namespace Blog\WebBundle\ACL;

interface SimpleACL {
	/**
	 * Check can $user edit $this user object
	 * 
	 * @param mixed $user
	 * @return bool
	 */
	public function canEdit($user);
	
	/**
	 * Check can $user delete $this user object
	 * 
	 * @param mixed $user
	 * @return bool
	 */
	public function canDelete($user);
}
