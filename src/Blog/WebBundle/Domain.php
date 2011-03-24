<?php


/**
 * Class: Domain
 * Date begin: Mar 16, 2011
 * 
 * @package blog
 * @author Azat Khuzhin
 */

namespace Blog\WebBundle;

use Symfony\Component\Security\Acl\Model\DomainObjectInterface;

class Domain implements DomainObjectInterface {
	function getObjectIdentifier() {
		return __NAMESPACE__;
	}
}
