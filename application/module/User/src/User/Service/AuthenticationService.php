<?php
namespace User\Service;

use Doctrine\Common\Persistence\ObjectRepository;
use User\Entity\User;
use User\Entity\UserInterface;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\AuthenticationService as BaseAuthService;
use Zend\Authentication\Result;
use Zend\Authentication\Storage\Session;
use Zend\Authentication\Storage\StorageInterface;
use Zend\Crypt\Password\PasswordInterface;
use Zend\EventManager\EventManagerInterface;
use ZfcRbac\Identity\IdentityProviderInterface;

class AuthenticationService extends BaseAuthService implements AdapterInterface, IdentityProviderInterface
{
    const AUTH_WRONG_CREDENTIALS = 'role-based-user.service.authentication-service.authenticate.wrong-credentials';
    const AUTH_SUCCESS           = 'role-based-user.service.authentication-service.authenticate.success';

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var \Zend\Authentication\Storage\Session
     */
    protected $storage;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $userRepository;

    /**
     * @var \Zend\Crypt\Password\PasswordInterface
     */
    protected $passwordService;

    /**
     * @var \Zend\EventManager\EventManagerInterface
     */
    protected $eventManager;

    /**
     * @param ObjectRepository $userRepository
     * @param EventManagerInterface $eventManager
     * @param BaseAuthService $authenticationService
     * @param StorageInterface $storage
     */
    public function __construct(
        ObjectRepository $userRepository,
        EventManagerInterface $eventManager,
        BaseAuthService $authenticationService,
        StorageInterface $storage = null
    ) {
        $this->userRepository  = $userRepository;
        $this->passwordService = new PasswordService();
        $this->eventManager    = $eventManager;
        $this->authService     = $authenticationService;
        $this->storage         = $storage ? : new Session('GamblingTecUser');
    }

    /**
     * @param $username
     * @param $password
     */
    public function setCredentials($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Performs an authentication attempt
     *
     * In case of a matching username but wrong password the event self::AUTH_WRONG_CREDENTIALS is fired with the
     * UserObject attached as $e->getTarget() for further processing abilities
     *
     * In case of a successful login, the event self::AUTH_SUCCESS will be fired with the
     * UserObject attached as $e->getTarget() for further processing abilities
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface If authentication cannot be performed
     */
    public function authenticate()
    {
        //Using Doctrine Adapter as per config/autload/doctrine.local

        $adapter = $this->authService->getAdapter();
        $adapter->setIdentity($this->username);
        $adapter->setCredential($this->password);

        //This fires off the credential_callable in the Doctrine Auth service
        $authResult = $this->authService->authenticate();

        if (! $authResult->getIdentity() instanceof User) {
            $this->eventManager->trigger(self::AUTH_WRONG_CREDENTIALS, $authResult);

            return Result::FAILURE;
        }

        $identity = $authResult->getIdentity();

        $this->updateSessionData($identity);

        $this->eventManager->trigger(self::AUTH_SUCCESS, $authResult);

        return Result::SUCCESS;
    }

    /**
     * Returns true if and only if an identity is available
     *
     * @return bool
     */
    public function hasIdentity()
    {
        return ! $this->authService->getStorage()->isEmpty();
    }

    /**
     * Returns the authenticated identity or null if no identity is available
     *
     * @return mixed|null
     */
    public function getIdentity()
    {
        if (! $this->hasIdentity()) {
            return;
        }

        $identity = $this->authService->getIdentity();

        return $identity;
    }

    /**
     * Clears the identity
     *
     * @return void
     */
    public function clearIdentity()
    {
        $this->authService->getStorage()->clear();
    }


    /**
     * Updates the identity
     *
     */
    public function updateSessionData(UserInterface $identity)
    {
        if ($this->hasIdentity()) {
            $this->clearIdentity();
        }

        $this->authService->getStorage()->write($identity);
    }
}
