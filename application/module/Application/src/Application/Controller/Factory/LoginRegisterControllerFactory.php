<?php
namespace Application\Controller\Factory;

use Application\Controller\LoginRegisterController;
use Application\Form\LoginForm;
use Application\Form\RegisterForm;
use Application\Library\Session\CookieService;
use User\Service\AuthenticationService;
use User\Service\UserService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LoginRegisterControllerFactory implements FactoryInterface
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

        return new LoginRegisterController(
            $realSL->get('FormElementManager')->get(LoginForm::class),
            $realSL->get('FormElementManager')->get(RegisterForm::class),
            $realSL->get(UserService::class),
            $realSL->get(AuthenticationService::class),
            $realSL->get(CookieService::class),
            $realSL->get('application')->getEventManager()
        );
    }
}
