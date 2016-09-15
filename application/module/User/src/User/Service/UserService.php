<?php
namespace User\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineModule\Paginator\Adapter\Selectable as SelectableAdapter;
use Ramsey\Uuid\Uuid;
use User\Entity\UserInterface;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Math\Rand;
use Zend\Paginator\Paginator;

class UserService
{
    const USER_REGISTRATION_SUCCESS = 'role-based-user.service.user.registration.success';
    const USER_REGISTRATION_FAILURE = 'role-based-user.service.user.registration.failure';
    const USER_PASSWORD_UPDATED     = 'role-based-user.service.user.password.updated';
    const USER_PASSWORD_RESET       = 'role-based-user.service.user.password.reset';

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     * @access protected
     */
    protected $objectManager;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $userRepository;

    /**
     * @var \Zend\EventManager\EventManagerInterface
     * @access protected
     */
    protected $eventManager;

    /**
     * @param ObjectManager $objectManager
     * @param ObjectRepository $userRepository
     * @param EventManagerInterface $eventManager
     * @param AuthenticationServiceInterface $authenticationService
     */
    public function __construct(
        ObjectManager $objectManager,
        ObjectRepository $userRepository,
        EventManagerInterface $eventManager,
        AuthenticationServiceInterface $authenticationService
    ) {
        $this->objectManager   = $objectManager;
        $this->userRepository  = $userRepository;
        $this->eventManager    = $eventManager;
        $this->authService     = $authenticationService;
        $this->passwordService = new PasswordService();
    }

    /**
     * @param UserInterface $userObject
     * @return UserInterface
     * @throws \Exception
     */
    public function customerRegister(UserInterface $userObject)
    {
        $passwordHash = $this->passwordService->create($userObject->getPassword());
        $userObject->setPassword($passwordHash);

        $this->update($userObject);

        try {
            $this->eventManager->trigger(
                self::USER_REGISTRATION_SUCCESS,
                $userObject,
                [
                    'password' => $passwordHash
                ]
            );
        } catch (\Exception $e) {
            //NOTE: Errors are sent to the notification listener and published to the notification pages under errors
        }

        return $userObject;
    }

    /**
     * Update to a new password by confirming you know the old password.
     *
     * @param UserInterface $userObject
     * @param string $oldPass
     * @param string $newPass
     * @return bool
     */
    public function updatePassword(UserInterface $userObject, $oldPass, $newPass)
    {
        $tempOldUserDbPassword = $userObject->getPassword();

        if (false === ($this->passwordService->verify($oldPass, $tempOldUserDbPassword))) {
            return false;
        }

        $userObject->setPassword($this->passwordService->create($newPass));

        try {
            $this->objectManager->persist($userObject);
            $this->objectManager->flush();
            return true;
        } catch (\Exception $e) {
            $userObject->setPassword($tempOldUserDbPassword);

            return false;
        }
    }

    /**
     * Using the signature mdg($email.$old_pass_hash) create a new password
     * @param UserInterface $userObject
     * @param $signature
     * @param $password
     * @return bool
     */
    public function setPassword(UserInterface $userObject, $signature, $password)
    {
        $tempOldUserDbPassword = $userObject->getPassword();

        if (md5($tempOldUserDbPassword.$userObject->getEmail()) != $signature) {
            return false;
        }

        $userObject->setPassword($this->passwordService->create($password));

        try {
            $this->objectManager->persist($userObject);
            $this->objectManager->flush();
            return true;
        } catch (\Exception $e) {
            $userObject->setPassword($tempOldUserDbPassword);

            return false;
        }
    }

    /**
     * Create a random password and send it to the user
     * @param $email
     * @return bool
     */
    public function resetPassword($email)
    {
        $userObject = $this->findByEmail($email);

        if (! $userObject instanceof UserInterface) {
            return false;
        }

        $randomPassword     = Rand::getString(16);
        $randomPasswordHash = $this->passwordService->create($randomPassword);

        $userObject->setPassword($randomPasswordHash);

        $this->update($userObject);

        $this->eventManager->trigger(
            self::USER_PASSWORD_UPDATED,
            $userObject,
            [
                'password' => $randomPassword
            ]
        );

        return $userObject;
    }

    /**
     * Send a password update link to the user
     * @param $email
     * @return bool
     */
    public function forgotPassword($email)
    {
        $userObject = $this->findByEmail($email);

        if (! $userObject instanceof UserInterface) {
            return false;
        }

        $this->eventManager->trigger(
            self::USER_PASSWORD_RESET,
            '',
            [
                'email' => $email,
                'signature' => md5($userObject->getPassword().$email)
            ]
        );

        return true;
    }

    /**
     * @param UserInterface $userObject
     * @param $x
     * @return bool|mixed
     */
    public function updateSubscription(UserInterface $userObject, $x)
    {
        $userObject->setIsSubscribed($x);

        try {
            $this->objectManager->persist($userObject);
            $this->objectManager->flush();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Will return a single user object
     *
     * @param int|string $id
     * @return UserInterface
     */
    public function find($id)
    {
        return $this->userRepository->find($id);
    }

    /**
     * @param $email
     * @return mixed
     */
    public function findByEmail($email)
    {
        return $this->userRepository->findOneByEmail($email);
    }

    /**
     * @param Uuid $uuid
     * @return mixed
     */
    public function findByUuid(Uuid $uuid)
    {
        return $this->userRepository->findOneByUuid($uuid);
    }

    /**
     * @param $username
     * @return mixed
     */
    public function findByUsername($username)
    {
        return $this->userRepository->findOneByUsername($username);
    }

    /**
     * @param $id
     * @param $state
     */
    public function toggleState($id, $state)
    {
        $userObject = $this->find($id);

        $userObject->setState($state);

        $this->update($userObject);
    }

    /**
     * @param UserInterface $userObject
     * @return bool|UserInterface
     * @throws \Exception
     */
    public function update(UserInterface $userObject)
    {
        try {
            $this->objectManager->persist($userObject);
            $this->objectManager->flush();
        } catch (\Exception $e) {
            throw new \Exception($e);
        }

        return $userObject;
    }

    /**
     * @param $page
     * @param $count
     * @return Paginator
     */
    public function getPaged($page, $count)
    {
        $adapter = new SelectableAdapter($this->userRepository);
        $paginator = new Paginator($adapter);
        return $paginator->setCurrentPageNumber((int) $page)->setItemCountPerPage((int) $count);
    }
}
