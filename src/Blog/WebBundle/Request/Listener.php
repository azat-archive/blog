<?

/**
 * Class: Listener
 * Date begin: Mar 16, 2011
 * 
 * Event listener for Request
 * Add using of ACL
 * 
 * @package blog
 * @author Azat Khuzhin
 */

namespace Blog\WebBundle\Request;

use	Symfony\Component\HttpKernel\Log\LoggerInterface,
	Symfony\Component\HttpKernel\HttpKernelInterface,
	Symfony\Component\HttpFoundation\Request,
	Symfony\Component\EventDispatcher\EventInterface,
	Symfony\Component\Routing\RouterInterface,
	Symfony\Component\DependencyInjection\ContainerInterface;

// for ACL
use	Symfony\Component\Security\Acl\Domain\ObjectIdentity,
	Blog\WebBundle\Domain;

class Listener {
	protected $router;
	protected $logger;
	protected $container;

	public function __construct(ContainerInterface $container, RouterInterface $router, LoggerInterface $logger = null) {
		$this->container = $container;
		$this->router = $router;
		$this->logger = $logger;
	}

	public function handle(EventInterface $event) {
		$request = $event->get('request');
		$master = HttpKernelInterface::MASTER_REQUEST === $event->get('request_type');
		
		// @TODO what do this this?
		if (!$master) {
			return;
		}
		return;
		
		// creating the ACL
		$domain = new Domain;
		$aclProvider = $this->container->get('security.acl.provider');
		$objectIdentity = ObjectIdentity::fromDomainObject($domain);
		$acl = $aclProvider->createAcl($objectIdentity);
		
		var_dump($aclProvider, $objectIdentity, $acl);
		die;
	}
}
