<?php
namespace User\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Authentication\AuthenticationServiceInterface;


class UserHelper extends AbstractHelper {

    protected $auth;

    public function __construct(
        AuthenticationServiceInterface $authenticationService
    )
    {
        $this->auth =  $authenticationService;
    }

    public function __invoke()
    {
        return $this->auth;
    }
}