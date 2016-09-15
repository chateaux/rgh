<?php
namespace Application\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct('login-form', $options);
    }

    public function init()
    {
        $this->add(
            [
                'name' => 'csrfcheck',
                'type' => 'csrf',
                'options' => [
                    'csrf_options' => [
                        'message' => 'The form verification credentials have expired, please re-submit the form.',
                        'timeout' => 1200
                    ]
                ]
            ]
        );

        $this->add(
            [
                'name' => 'username',
                'attributes' => [
                    'required'    => 'required',
                    'class'       => 'form-control',
                    'placeholder' => 'Username or E-Mail'
                ],
                'type' => 'text',
                'options' => [
                    'label' => 'E-Mail'
                ]
            ]
        );

        $this->add(
            [
                'name' => 'password',
                'attributes' => [
                    'required'    => 'required',
                    'class'       => 'form-control',
                    'placeholder' => 'Password'
                ],
                'type' => 'password',
                'options' => [
                    'label' => 'Password'
                ]
            ]
        );

        $this->add(
            [
                'name' => 'submit',
                'type' => 'submit',
                'attributes' => [
                    'value' => 'Login'
                ]
            ]
        );
    }
}
