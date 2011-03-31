<?

/**
 * Class: Listener
 * Date begin: Mar 16, 2011
 * 
 * Event listener for Request
 * 
 * @package blog
 * @author Azat Khuzhin
 */

namespace Blog\WebBundle\Request;

use	Symfony\Component\HttpKernel\Log\LoggerInterface,
	Symfony\Component\HttpKernel\HttpKernelInterface,
	Symfony\Component\HttpFoundation\Request,
	Symfony\Component\HttpKernel\Event\GetResponseEvent,
	Symfony\Component\Routing\RouterInterface,
	Symfony\Component\DependencyInjection\ContainerInterface;

class Listener {
	protected $router;
	protected $logger;
	protected $container;

	public function __construct(ContainerInterface $container, RouterInterface $router, LoggerInterface $logger = null) {
		$this->container = $container;
		$this->router = $router;
		$this->logger = $logger;
	}

	public function onCoreRequest(GetResponseEvent $event) {
		return;
	}
}
