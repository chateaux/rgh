<?php
namespace Application\Controller;

use Application\Library\Session\CookieService;
use Ramsey\Uuid\Uuid;
use User\Entity\User;
use User\Service\AuthenticationService;
use User\Service\UserService;
use Zend\Authentication\Result;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LoginRegisterController extends AbstractActionController
{
    const CONFIRM_EMAIL = 'confirm-email';

    private $registerForm;
    private $userService;
    private $loginForm;
    private $authService;
    private $cookieService;
    private $eventManager;

    public function __construct(
        FormInterface $loginForm,
        FormInterface $registerForm,
        UserService $userService,
        AuthenticationService $authService,
        CookieService $cookieService,
        EventManagerInterface $eventManager
    ) {
        $this->loginForm = $loginForm;
        $this->registerForm = $registerForm;
        $this->userService = $userService;
        $this->authService = $authService;
        $this->cookieService = $cookieService;
        $this->eventManager = $eventManager;
    }

    /**
     * @return array|\Zend\Http\Response|ViewModel
     */
    public function loginAction()
    {
        $redirect_url = $this->params()->fromQuery('redirectTo', null);

        if ($this->authService->hasIdentity()) {
            if (is_null($redirect_url)) {
                return $this->redirect()->toRoute('user/my-account');
            }

            return $this->redirect()->toUrl($redirect_url);
        }

        $prg = $this->prg();

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return new ViewModel(
                [
                    'form' => $this->loginForm,
                    'redirect_url' => $redirect_url,
                ]
            );
        }

        $this->loginForm->setData($prg);

        if (! $this->loginForm->isValid()) {
            return new ViewModel(
                [
                    'form' => $this->loginForm,
                    'redirect_url' => $redirect_url,
                ]
            );
        }

        $userData = $this->loginForm->getData();
        $this->authService->setCredentials($userData['username'], $userData['password']);
        $authResult = $this->authService->authenticate();

        if (false === ($authResult === Result::SUCCESS)) {
            $this->flashMessenger()->addErrorMessage(
                'Your credentials failed. please try again'
            );

            return $this->redirect()->toRoute('login', [], $this->RedirectPlugin()->redirectParams());
        }

        $userObject = $this->authService->getIdentity();

        if ($userObject->getIsEmailConfirmed()) {
            if (null ===  $redirect_url) {
                return $this->redirect()->toRoute('user/account');
            }

            return $this->redirect()->toUrl($redirect_url);
        }


        return $this->redirect()->toRoute('register-landing', [], ['query' => [ 'redirectTo'=> $redirect_url]]);
    }

    /**
     * @return Response
     */
    public function logoutAction()
    {
        $this->authService->clearIdentity();

        return $this->redirect()->toRoute('login');
    }

    public function registerAction()
    {
        if ($this->authService->hasIdentity()) {
            return $this->redirect()->toRoute('user/account');
        }

        $roleObject = $this->userPlugin()->getRoleObject('user');

        /**
         * Check and set affiliate uuid
         */
        $referrerObject = null;
        $data = [];

        if ($this->cookieService->exists('referrer')) {
            $cookie = $this->cookieService->decodeCookie();
            $aff_id = $cookie['referrer'];

            $referrerObject = $this->userService->findByUuid(Uuid::fromString($aff_id));

            if (!$referrerObject instanceof User) {
                $referrerObject = null;
            } else {
                $data = $cookie['data'];
            }
        }

        $userObject = new User();
        $userObject->setParent($referrerObject);

        $this->registerForm->bind($userObject);

        $prg = $this->prg('register');

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return new ViewModel([
                'form' => $this->registerForm
            ]);
        }

        $this->registerForm->setData($prg);

        if (! $this->registerForm->isValid()) {
            return new ViewModel([
                'form' => $this->registerForm
            ]);
        }

        /**
         * Users require a UUID, lets generate it
         */
        $uuid = Uuid::uuid4();
        $userObject->setUuid($uuid);
        $userObject->addRole($roleObject);
        $userObject->setIsEmailConfirmed(0);
        $this->userService->customerRegister($userObject);

        $this->authService->setCredentials($userObject->getEmail(), $prg['user']['password']);

        $authResult = $this->authService->authenticate();

        if (false === ($authResult === Result::SUCCESS)) {
            throw new \Exception("Unable to log user in - please contact support");
        }

        return $this->redirect()->toRoute('user/account');
    }

    public function registerLandingAction()
    {
        $userObject = $this->authService->getIdentity();
        $activation_code = $userObject->getActivationCode();
        $redirectTo = $this->params()->fromQuery('redirectTo');

        if (!$activation_code) {
            $activation_code = Uuid::uuid4();
            $userObject->setActivationCode($activation_code->getHex());
            $this->userService->update($userObject);
        }

        $this->eventManager->trigger(
            self::CONFIRM_EMAIL,
            $userObject,
            [
                'activation_code' => $activation_code,
                'redirectTo' => urlencode($redirectTo)
            ]
        );

        return new ViewModel(
            [
                'email' => $userObject->getEmail()
            ]
        );
    }

    public function confirmEmailAction()
    {
        $activation_code = $this->params()->fromRoute('activation_code', false);

        $params = explode('*', $activation_code);

        $signature = $params[0];
        $email = $params[1];
        $uuid = $params[2];

        $uuid = Uuid::fromString($uuid);
        $userObject = $this->userService->findByUuid($uuid);

        if (!$userObject instanceof User) {
            die("User check failed");
        }

        if (md5($userObject->getEmail()) != $email) {
            die("Email check failed");
        }

        if ($signature != md5($userObject->getUuid().$userObject->getActivationCode().$userObject->getPassword())) {
            die("Signature check failed");
        }

        $userObject->setIsEmailConfirmed(true);
        $this->userService->update($userObject);

        return $this->redirect()->toRoute('user/account');
    }
}
