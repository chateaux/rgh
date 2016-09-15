<?php
namespace Application\Form\Factory;

use Application\Form\RegisterForm;
use Application\InputFilter\RegisterFilter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RegisterFormFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new RegisterForm(
            $serviceLocator->getServiceLocator()->get('InputFilterManager')->get(RegisterFilter::class)
        );
    }
}
