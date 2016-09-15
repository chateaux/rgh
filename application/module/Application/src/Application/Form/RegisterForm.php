<?php
namespace Application\Form;

use User\Form\UserFieldset;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterInterface;

class RegisterForm extends Form
{
    /**
     * @var \Zend\InputFilter\InputFilterInterface
     */
    protected $userFilter;

    /**
     * @param InputFilterInterface $inputFilter
     * @param null $name
     * @param array $options
     */
    public function __construct(
        InputFilterInterface $inputFilter,
        $name = null,
        $options = []
    ) {
        parent::__construct('user-registration', $options);

        $this->userFilter = $inputFilter;
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
                'name' => 'user',
                'type' => UserFieldset::class,
                'options' => [
                    'use_as_base_fieldset' => true
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'submit',
                'type'       => 'submit',
                'attributes' => [
                    'value' => 'Register User',
                    'class' => 'form-element'
                ]
            ]
        );

        $this->getInputFilter()->add($this->userFilter, 'user');
        $this->getInputFilter()->get('user')->get('password')->setRequired(true);
        $this->getInputFilter()->get('user')->get('passwordRepeat')->setRequired(true);

        $this->setValidationGroup(
            [
                'csrfcheck',
                'user' => [
                    'id',
                    'email',
                    'password',
                    'passwordRepeat',
                    'isSubscribed',
                    'country',
                    'agreeTermsConditions',
                ]
            ]
        );
    }
}
