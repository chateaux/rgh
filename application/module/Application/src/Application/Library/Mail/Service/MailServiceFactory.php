<?php
namespace Application\Library\Mail\Service;

use Application\Library\Mail\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MailServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config')['settings'];
        $transport = \Zend\Mail\Transport\Factory::create($config['transport']);

        return new MailService(
            $serviceLocator->get('viewrenderer'),
            $serviceLocator->get(ModuleOptions::class),
            $transport
        );
    }
}
