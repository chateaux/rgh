<?php

/**
 * This listener handles notificaitons through out the cloud
 *
 */

namespace Application\Listener;

use Application\Controller\ApplicationController;
use Toolbox\Library\Mail\Service\MailService;
use Toolbox\Library\Notifications\NotificationsLogger;
use User\Entity\User;
use User\Service\UserService;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\RendererInterface;

class SystemNotificationListener implements ListenerAggregateInterface
{
    /**
     * @var array
     */
    protected $listeners;

    public function __construct(
        MailService $mailService,
        array $settings,
        RendererInterface $viewRenderer
    ) {
        $this->mailService = $mailService;
        $this->settings = $settings;
        $this->viewRenderer = $viewRenderer;
    }

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     *
     * @return void
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(UserService::USER_REGISTRATION_SUCCESS, [$this, 'sendRegistrationEmailToUser']);
        $this->listeners[] = $events->attach(UserService::USER_REGISTRATION_FAILURE, [$this, 'sendFailureEmailToAdmin']);
        $this->listeners[] = $events->attach(UserService::USER_PASSWORD_UPDATED, [$this, 'sendPasswordEmailToUser']);
        $this->listeners[] = $events->attach(UserService::USER_PASSWORD_RESET, [$this, 'sendPasswordResetEmailToUser']);
        $this->listeners[] = $events->attach(NotificationsLogger::SYSTEM_MESSAGE, [$this, 'sendNotification']);
        $this->listeners[] = $events->attach(ApplicationController::TEST_EMAIL, [$this, 'sendNotification']);
    }

    /**
     * Detach all previously attached listeners
     *
     * @param EventManagerInterface $events
     *
     * @return void
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }


    /**
     * This is a simple way to add general errors to the notifications section
     * @param EventInterface $event
     */
    public function generalError(EventInterface $event)
    {
        $message = $event->getParam('message');
        $message_type = $event->getParam('message_type');

        $this->notifications->addNotification($message_type, $message);
    }

    /**
     * @param EventInterface $event
     */
    public function sendNotification(EventInterface $event)
    {
        $message  = $event->getParam('message');
        $to_email = $event->getParam('email');

        if (is_null($to_email)) {
            $this->appSettings->getSettings('support_email');
        }

        $from_email = $this->appSettings->getSettings('from_email');
        $this->mailService->setMailFrom($from_email);
        $this->mailService->setMailTo($to_email);
        $this->mailService->setMailSubject('System Notification');
        $CLOUD_DOMAIN =  $this->appSettings->getSettings('app_url');

        // Email content
        $viewContent = new ViewModel(
            [
                'cloud_domain'  => $CLOUD_DOMAIN,
                'message'       => $message
            ]
        );

        $viewContent->setTemplate('system/response');

        $content = $this->viewRenderer->render($viewContent);

        // Email Template or Layout
        $viewLayout = new ViewModel(
            [
                'content' => $content,
                'cloud_domain'  => $CLOUD_DOMAIN
            ]
        );
        $viewLayout->setTemplate('email/layout');

        $this->mailService->setMailBodyHtml($viewLayout);

        if (false === $this->mailService->sendMail()) {
            $message = "Unable to send Skrill response message";
            $this->notifications->addNotification(6, $message);
            return;
        }
    }

    /**
     * Will send an E-Mail to a newly registered User
     *
     * @param EventInterface $event
     * @throws \InvalidArgumentException
     */
    public function sendRegistrationEmailToUser(EventInterface $event)
    {

        /**
         * @var $userObject User
         */
        $userObject  = $event->getTarget();
        $userService = $event->getName();

        if (false === ($userObject instanceof User)) {
            $this->notifications->addNotification(6, 'SendRegistrationEmail in Notification Listener: Event Target expected to be instanceof User\Entity\UserInterface');
            throw new \InvalidArgumentException('Event Target expected to be instanceof User\Entity\UserInterface, got ' . gettype(
                    $userObject
                ));
        }

        $password = $event->getParam('password');

        if (! $password) {
            $this->notifications->addNotification(6, 'SendRegistrationEmail in Notification Listener: No Password provided on Event UserService:: '.$userService.' for listener SystemNotificationListener');
            throw new \InvalidArgumentException('No Password provided on Event UserService:: '.$userService.' for listener SystemNotificationListener');
        }

        $FROM_EMAIL      = $this->appSettings->getSettings('no_reply_email');
        $TO_EMAIL        = $userObject->getEmail();
        $SUPPORT_EMAIL   = $this->appSettings->getSettings('support_email');
        $SUPPORT_DESK    = $this->appSettings->getSettings('support_desk');
        $CLOUD_DOMAIN    =  $this->appSettings->getSettings('app_url');

        $this->mailService->setMailFrom($FROM_EMAIL);
        $this->mailService->setMailTo($TO_EMAIL);
        $this->mailService->setMailSubject('New account created by GamblingTec');

        // Email content
        $viewContent = new ViewModel(
            [
                'cloud_domain'  => $CLOUD_DOMAIN,
                'user'          => $userObject,
                'password'      => $password,
                'support_email' => $SUPPORT_EMAIL,
                'support_desk'  => $SUPPORT_DESK,
            ]
        );

        $viewContent->setTemplate('registration/success');

        $content = $this->viewRenderer->render($viewContent);

        // Email Template or Layout
        $viewLayout = new ViewModel(
            [
                'content' => $content,
                'cloud_domain'  => $CLOUD_DOMAIN
            ]
        );
        $viewLayout->setTemplate('email/layout');

        $this->mailService->setMailBodyHtml($viewLayout);

        if (false === $this->mailService->sendMail()) {
            $message = "Unable to send Skrill response message";
            $this->notifications->addNotification(6, $message);
            return;
        }
    }

    /**
     * If there is a failure when registering a user in the admin, a notification is sent to the default
     * @param EventInterface $event
     * @throws \InvalidArgumentException
     */
    public function sendFailureEmailToAdmin(EventInterface $event)
    {
        /**
         * @TODO This must be looked at and removed or re-thought
         * @var $userObject User
         */
        $userObject  = $event->getTarget();

        if (false === ($userObject instanceof User)) {
            throw new \InvalidArgumentException('Event Target expected to be instanceof User\Entity\UserInterface, got ' . gettype(
                    $userObject
                ));
        }

        $FROM_EMAIL      = $this->appSettings->getSettings('from_email');
        $TO_EMAIL        = $this->appSettings->getSettings('support_email');
        $CLOUD_DOMAIN    = $this->appSettings->getSettings('app_url');
        $REG_URL         = $this->appSettings->getSettings('app_url');

        $EXCEPTION       = $event->getParam('exception');

        //Get the users registered domains
        $REGISTERED_DOMAINS = '';
        $this->mailService->setMailFrom($FROM_EMAIL);
        $this->mailService->setMailTo($TO_EMAIL);
        $this->mailService->setMailSubject('GamblingTec Admin - Registration failure');

        $mailModel = new ViewModel();
        $mailModel->setTemplate('registration/failure');
        $mailModel->setVariables(
            [
                'user' => $userObject,
                'registered_domains' => $REGISTERED_DOMAINS,
                'current_url' => $REG_URL,
                'cloud_domain'  => $CLOUD_DOMAIN,
                'exception' => $EXCEPTION
            ]
        );

        $this->mailService->setMailBodyHtml($mailModel);

        if (false === $this->mailService->sendMail()) {
            //@todo custom error reporting / loging / rescheduling
            return;
        }
    }

    /**
     * This is for the Public Password Reset Option
     * @param EventInterface $event
     * @throws \InvalidArgumentException
     */
    public function sendPasswordEmailToUser(EventInterface $event)
    {
        /**
         * @var $userObject User
         */
        $userObject   = $event->getTarget();

        if (false === ($userObject instanceof User)) {
            throw new \InvalidArgumentException('Event Target expected to be instanceof User\Entity\UserInterface, got ' . gettype(
                    $userObject
                ));
        }

        $FROM_EMAIL      = $this->appSettings->getSettings('no_reply_email');
        $TO_EMAIL        = $userObject->getEmail();
        $CLOUD_DOMAIN    = $this->appSettings->getSettings('app_url');
        $SUPPORT_EMAIL   = $this->appSettings->getSettings('support_email');
        $SUPPORT_DESK    = $this->appSettings->getSettings('support_desk');
        $PASSWORD        = $event->getParam('password');

        $this->mailService->setMailFrom($FROM_EMAIL);
        $this->mailService->setMailTo($TO_EMAIL);
        $this->mailService->setMailSubject('GamblingTec - Password reset');

        // Email content
        $viewContent = new ViewModel(
            [
                'userObject'    => $userObject,
                'cloud_domain'  => $CLOUD_DOMAIN,
                'password'      => $PASSWORD,
                'support_email' => $SUPPORT_EMAIL,
                'support_desk'  => $SUPPORT_DESK,
            ]
        );

        $viewContent->setTemplate('password/reset');
        $content = $this->viewRenderer->render($viewContent);

        // Email Template or Layout
        $viewLayout = new ViewModel(
            [
                'content' => $content,
                'cloud_domain'  => $CLOUD_DOMAIN
            ]
        );
        $viewLayout->setTemplate('email/layout');

        $this->mailService->setMailBodyHtml($viewLayout);

        if (false === $this->mailService->sendMail()) {
            $message = "Unable to send mail regarding user: ".$userObject->getEmail()." with role(s): ";
            $this->notifications->addNotification(2, $message);
            return;
        }
    }

    /**
     * Send a link to the user so that they can update their password
     * @param EventInterface $event
     * @throws \InvalidArgumentException
     */
    public function sendPasswordResetEmailToUser(EventInterface $event)
    {
        $FROM_EMAIL      = $this->appSettings->getSettings('no_reply_email');
        $TO_EMAIL        = $event->getParam('email');
        $CLOUD_DOMAIN    = $this->appSettings->getSettings('app_url');
        $SUPPORT_EMAIL   = $this->appSettings->getSettings('support_email');
        $SUPPORT_DESK    = $this->appSettings->getSettings('support_desk');
        $SIGNATURE       = $event->getParam('signature');

        $LINK = $this->appSettings->getSettings('app_url').'/customer/update-password?email='.$TO_EMAIL.'&signature='.$SIGNATURE;

        $this->mailService->setMailFrom($FROM_EMAIL);
        $this->mailService->setMailTo($TO_EMAIL);
        $this->mailService->setMailSubject('GamblingTec - Password reset');

        // Email content
        $viewContent = new ViewModel(
            [
                'support_email' => $SUPPORT_EMAIL,
                'support_desk'  => $SUPPORT_DESK,
                'link'          => $LINK
            ]
        );

        $viewContent->setTemplate('password/link');
        $content = $this->viewRenderer->render($viewContent);

        // Email Template or Layout
        $viewLayout = new ViewModel(
            [
                'content' => $content,
                'cloud_domain'  => $CLOUD_DOMAIN
            ]
        );
        $viewLayout->setTemplate('email/layout');

        $this->mailService->setMailBodyHtml($viewLayout);

        if (false === $this->mailService->sendMail()) {
            $message = "Unable to send password re-set email to: ".$TO_EMAIL;
            $this->notifications->addNotification(2, $message);
            return;
        }
    }
}
