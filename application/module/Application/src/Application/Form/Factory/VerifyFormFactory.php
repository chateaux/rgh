<?php
namespace Application\Form\Factory;

use Application\Form\VerifyForm;
use Application\InputFilter\VerifyFilter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class VerifyFormFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new VerifyForm(
            $serviceLocator->getServiceLocator()->get('InputFilterManager')->get(VerifyFilter::class)
        );
    }
}
