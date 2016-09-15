<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Service\AuthenticationService;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{

    private $authService;

    public function __construct(
        AuthenticationService $authService
    ) {
        $this->authService = $authService;
    }

    public function accountAction()
    {
        if ( ! $this->authService->hasIdentity() ) {
            return $this->redirect()->toRoute('user/login');
        }

        return new ViewModel(
            [
            ]
        );

    }


}