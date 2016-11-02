<?php
namespace Application\Form;
use Zend\Form\Form;

class VerifyForm extends Form
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct('verify-form', $options);
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
                'name' => 'recordNumber',
                'attributes' => [
                    'required'    => 'required',
                    'class'       => 'form-control',
                    'placeholder' => 'The record you wish to verify'
                ],
                'type' => 'text',
                'options' => [
                    'label' => 'Record number'
                ]
            ]
        );
        $this->add(
            [
                'name' => 'verificationCode',
                'attributes' => [
                    'required'    => 'required',
                    'class'       => 'form-control',
                    'placeholder' => 'Verification code provided'
                ],
                'type' => 'text',
                'options' => [
                    'label' => 'Verification code'
                ]
            ]
        );
        $this->add(
            [
                'name' => 'submit',
                'type' => 'submit',
                'attributes' => [
                    'value' => 'Verify'
                ]
            ]
        );
    }
}
