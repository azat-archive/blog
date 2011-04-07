<?php

/**
 * Class: ControllerListener
 * Date begin: Mar 16, 2011
 * 
 * Controller listener
 * 
 * @package blog
 * @author Azat Khuzhin
 */

namespace Blog\WebBundle\Listener;

use Symfony\Component\EventDispatcher\Event,
    Symfony\Component\HttpKernel\HttpKernelInterface,
    Symfony\Component\HttpKernel\Event\FilterControllerEvent,
    Blog\WebBundle\Twig\Extension\WebExtension;

class Controller {
	/**
	 * WebExtension
	 *
	 * @var WebExtension 
	 */
	protected $extension;

	/**
	 * Init
	 *
	 * @param WebExtension $extension 
	 */
	public function __construct(WebExtension $extension) {
		$this->extension = $extension;
	}

	/**
	 * Handle event
	 *
	 * @param FilterControllerEvent $event 
	 */
	public function onCoreController(FilterControllerEvent $event) {
		if (HttpKernelInterface::MASTER_REQUEST === $event->getRequestType()) {
			$this->extension->setController($event->getController());
		}
	}
}
