<?php
namespace Application\Controller\Factory;

use Application\Controller\IndexController;
use Application\Form\VerifyForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Renderer\RendererInterface;

class IndexControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realSL = $serviceLocator->getServiceLocator();

        return new IndexController(
            $realSL->get(RendererInterface::class),
            $realSL->get('FormElementManager')->get(VerifyForm::class)
        );
    }
}
