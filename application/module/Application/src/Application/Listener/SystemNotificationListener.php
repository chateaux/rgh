<?php

/**
 * This listener handles notificaitons through out the cloud
 *
 */

namespace Application\Listener;

use Application\Controller\LoginRegisterController;
use Application\Library\Mail\Service\MailService;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\RendererInterface;

class SystemNotificationListener implements ListenerAggregateInterface
{
    private $mailService;
    private $settings;
    private $viewRenderer;

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
        $this->listeners[] = $events->attach(LoginRegisterController::CONFIRM_EMAIL, [$this, 'confirmEmail']);
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

    public function sendEmail($params)
    {
        $noreply_email = $this->settings['no_reply_email'];
        $username = '';

        if (isset($params['to_email'])) {
            $to_email = $params['to_email'];
        }

        if (isset($params['no_reply_email'])) {
            $noreply_email  = $params['no-reply-email'];
        }

        if (! isset($params['subject'])) {
            return ['status' => false , 'message' => 'Missing text layout'];
        }

        if (! isset($params['view_content_variables'])) {
            return ['status' => false , 'message' => 'Missing view content variables'];
        }

        if (! isset($params['html_template'])) {
            return ['status' => false , 'message' => 'Missing html template'];
        }

        if (! isset($params['text_template'])) {
            return ['status' => false , 'message' => 'Missing text template'];
        }

        if (! isset($params['email_layout'])) {
            return ['status' => false , 'message' => 'Missing layout template'];
        }

        if (! isset($params['email_layout_text'])) {
            return ['status' => false , 'message' => 'Missing layout template text'];
        }

        if (isset($params['view_content_variables']['username'])) {
            $username = $params['view_content_variables']['username'];
        }

        /**
         * Send content to email template
         */
        $viewContent = new ViewModel($params['view_content_variables']);

        /**
         * Setup the HTML View Model
         */
        $viewContent->setTemplate($params['html_template']);
        $content = $this->viewRenderer->render($viewContent);
        $viewLayoutHtml = new ViewModel(['content' => $content, 'username' => $username]);
        $viewLayoutHtml->setTemplate($params['email_layout']);

        /**
         * Setup the TEXT View Model
         */
        $viewContent->setTemplate($params['text_template']);
        $content = $this->viewRenderer->render($viewContent);
        $viewLayoutText = new ViewModel(['content' => $content, 'username' => $username]);
        $viewLayoutText->setTemplate($params['email_layout_text']);

        /**
         * Setup SendMail()
         */
        $this->mailService->setMailTo($to_email);
        $this->mailService->setMailFrom($noreply_email);
        $this->mailService->setMailBodyHtml($viewLayoutHtml);
        $this->mailService->setMailBodyText($viewLayoutText);
        $this->mailService->setMailSubject($params['subject']);

        /**
         * Send it!
         */
        $result = $this->mailService->sendMail();

        /**
         * Log response...
         */
        if (! $result) {
            return ['status' => false , 'message' => 'Send mail failed...'];
        }

        return ['status' => true , 'message' => 'Send mail success!'];
    }

    /**
     * @param EventInterface $event
     * @throws \InvalidArgumentException
     */
    public function confirmEmail(EventInterface $event)
    {
        $userObject = $event->getTarget();
        $activation_code = md5($userObject->getUuid().$userObject->getActivationCode().$userObject->getPassword()).'*'.md5($userObject->getEmail()).'*'.$userObject->getUuid();
        $redirectTo = $event->getParam('redirectTo');
        $TO_EMAIL = $userObject->getEmail();
        $ACTIVATION_URL = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/confirm-email/'.$activation_code;

        /**
         * html,text template - this is the code inserted into the layout
         * the view content are the params that is inserted into the template :)
         */
        $params = [
            'to_email' => $TO_EMAIL,
            'view_content_variables' =>
                [   'email' => $TO_EMAIL ,
                    'activation_url' => $ACTIVATION_URL
                ],
            'subject' => 'Confirm your email address',
            'html_template' => 'email/confirm',
            'text_template' => 'email/confirm/text',
            'email_layout' => 'email/layout',
            'email_layout_text' => 'email/layout/text',
            'use_pmta' => false
        ];

        $this->sendEmail($params);

    }

}