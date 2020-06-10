<?php

namespace Custom\Mvc\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

use Zend\Session\Container;
use Zend\Session\SessionManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;


class MessageGetter extends AbstractPlugin implements ServiceManagerAwareInterface
{

    /**
     * @var ServiceManager
     */
    protected $serviceManager;
    
    protected $messages = array();


    public function __invoke()
    {
        $manager = new SessionManager();
        $container = new Container('FlashMessenger', $manager);
        $namespaces = array();

        foreach ($container as $namespace => $messages) {
            $this->messages[$namespace] = $messages->toArray();
            $namespaces[] = $namespace;
        }
        foreach ($namespaces as $namespace) {
            unset($container->{$namespace});
        }

        return $this->messages;
    }

    /**
     * Retrieve service manager instance
     *
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager->getServiceLocator();
    }

    /**
     * Set service manager instance
     *
     * @param ServiceManager $locator
     * @return void
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

}

