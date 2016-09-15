<?php
namespace User\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use User\Entity\HierarchicalRole;
use User\Entity\UserInterface;
use Zend\Form\Fieldset;

class UserFieldset extends Fieldset
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     * @access protected
     */
    protected $objectManager;

    /**
     * @param ObjectManager $objectManager
     * @param UserInterface $userPrototype
     * @param null $name
     * @param array $options
     */
    public function __construct(
        ObjectManager $objectManager,
        UserInterface $userPrototype,
        $name = null,
        $options = []
    ) {
        parent::__construct($name, $options);

        $this->objectManager = $objectManager;

        $this->setHydrator(new DoctrineObject($objectManager));
        $this->setObject($userPrototype);
    }

    public function init()
    {
        $this->add(
            [
                'name'       => 'id',
                'type'       => 'hidden',
            ]
        );

        $this->add(
            [
                'name'       => 'uuid',
                'type'       => 'hidden',
            ]
        );

        $this->add(
            [
                'name'       => 'title',
                'type'       => 'select',
                'options'    => [
                    'label' => 'Title',
                    'instructions' => 'Select a title',
                ],
                'attributes' => [
                    'options'  => [
                        'MR'   => 'Mr',
                        'MRS'  => 'Mrs',
                        'MISS' => 'Miss',
                        'PROF' => 'Prof',
                        'DR'   => 'Dr',
                        'SIR'  => 'Sir',
                        'FM'   => 'FM'
                    ],
                    'class' => 'form-control',
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'firstname',
                'type'       => 'text',
                'options'    => [
                    'label' => 'Firstname',
                    'instructions' => 'Alphanumeric characters (A,b,c,d,e..)',
                ],
                'attributes' => [
                    'class' => 'form-control',
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'surname',
                'type'       => 'text',
                'options'    => [
                    'label' => 'Surname',
                    'instructions' => 'Alphanumeric characters, optional ( \' )',
                ],
                'attributes' => [
                    'class' => 'form-control',
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'email',
                'type'       => 'email',
                'options'    => [
                    'label' => 'E-Mail',
                    'instructions' => 'Your email address',
                ],
                'attributes' => [
                    'class' => 'form-control',
                    'required' => 'required',
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'username',
                'type'       => 'text',
                'options'    => [
                    'label' => 'Username',
                    'instructions' => '5 - 20 Alpha numeric characters (no spaces)',
                ],
                'attributes' => [
                    'class' => 'form-control',
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'address1',
                'type'       => 'text',
                'options'    => [
                    'label' => 'Address 1',
                    'instructions' => 'Address line 1',
                ],
                'attributes' => [
                    'class' => 'form-control',
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'address2',
                'type'       => 'text',
                'options'    => [
                    'label' => 'Address 2',
                    'instructions' => 'Address line 2',
                ],
                'attributes' => [
                    'class' => 'form-control'
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'city',
                'type'       => 'text',
                'options'    => [
                    'label' => 'City',
                    'instructions' => 'City where you live',
                ],
                'attributes' => [
                    'class' => 'form-control',
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'region',
                'type'       => 'text',
                'options'    => [
                    'label' => 'Region',
                    'instructions' => 'Region where you live',
                ],
                'attributes' => [
                    'class' => 'form-control',
                ]
            ]
        );

        $this->add(
            [
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'name' => 'country',
                'options' => [
                    'object_manager' => $this->objectManager,
                    'target_class'   => 'User\Entity\Country',
                    'property'       => 'name',
                    'label' => 'Land',
                    'instructions' => 'The unincorporated land mass of your birth',
                    'display_empty_item' => true,
                    'empty_item_label'   => 'Select your land',
                ],
                'attributes' => [
                    'multiple' => false,
                    'class' => 'form-control input-medium select2me',
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'postCode',
                'type'       => 'text',
                'options'    => [
                    'label' => 'Post code',
                    'instructions' => 'Your post code',
                ],
                'attributes' => [
                    'class' => 'form-control'
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'tell',
                'type'       => 'text',
                'options'    => [
                    'label' => 'Tel.',
                    'instructions' => 'Your telephone number, available symbols: [+- ()]',
                ],
                'attributes' => [
                    'class' => 'form-control',
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'cell',
                'type'       => 'text',
                'options'    => [
                    'label' => 'Cell',
                    'instructions' => 'Your mobile number, available symbols: [+- ()]',
                ],
                'attributes' => [
                    'class'     => 'form-control',
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'password',
                'type'       => 'password',
                'options'    => [
                    'label' => 'Password',
                    'instructions' => 'Minimum of 5 characters',
                ],
                'attributes' => [
                    'class' => 'form-control'
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'passwordRepeat',
                'type'       => 'password',
                'options'    => [
                    'label' => 'Repeat Password'
                ],
                'attributes' => [
                    'class' => 'form-control',
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'signature',
                'type'       => 'hidden'
            ]
        );

        $this->add(
            [
                'name'       => 'gender',
                'type'       => 'select',
                'options'    => [
                    'label'         => 'Gender',
                    'value_options' => [
                        1 => 'Male',
                        2 => 'Female'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control',
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'state',
                'type'       => 'select',
                'options'    => [
                    'label' => 'User State',
                    'value_options' => [
                        0 => 'Active',
                        1 => 'Locked',
                        2 => 'Deleted'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control'
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'dob',
                'type'       => '\Zend\Form\Element\DateTime',
                'attributes' => [
                    'pattern' => '^[0-9]{4}-[0-9]{2}-[0-9]{2}$',
                    'placeholder' => 'ex. 1903-06-25',
                ],
                'options'    => [
                    'label' => 'Date of Birth',
                    'instructions' => 'YYYY-mm-dd',
                    'class' => 'form-control',
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'isSubscribed',
                'type'       => 'select',
                'options'    => [
                    'label' => 'Mailing List',
                    'value_options' => [
                        1 => 'Yes',
                        0 => 'No'
                    ],
                    'instructions' => 'Join our mailing list',
                ],
                'attributes' => [
                    'class' => 'form-control',
                ]
            ]
        );



        $this->add(
            [
                'name'       => 'isAgent',
                'type'       => 'select',
                'options'    => [
                    'label' => 'Is an agent',
                    'value_options' => [
                        0 => 'No',
                        1 => 'Yes'
                    ],
                    'instructions' => 'Is this user an agent',
                ],
                'attributes' => [
                    'class' => 'form-control',
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'isMerchant',
                'type'       => 'select',
                'options'    => [
                    'label' => 'Is a merchant',
                    'value_options' => [
                        0 => 'No',
                        1 => 'Yes'
                    ],
                    'instructions' => 'Is this user a merchant',
                ],
                'attributes' => [
                    'class' => 'form-control',
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'isPublisher',
                'type'       => 'select',
                'options'    => [
                    'label' => 'Games publisher',
                    'value_options' => [
                        0 => 'No',
                        1 => 'Yes'
                    ],
                    'instructions' => 'Is this user a games publisher',
                ],
                'attributes' => [
                    'class' => 'form-control',
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'isLicenseHolder',
                'type'       => 'select',
                'options'    => [
                    'label' => 'Is a license holder',
                    'value_options' => [
                        0 => 'No',
                        1 => 'Yes'
                    ],
                    'instructions' => 'Is this user a license holder',
                ],
                'attributes' => [
                    'class' => 'form-control',
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'agreeTermsConditions',
                'type'       => 'select',
                'options'    => [
                    'label' => 'Agree to terms and conditions',
                    'value_options' => [
                        '' => 'No',
                        1 => 'Yes',
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control',
                ]
            ]
        );

        $this->add(
            [
                'name'    => 'roles',
                'type'    => 'DoctrineModule\Form\Element\ObjectSelect',
                'options' => [
                    'object_manager' => $this->objectManager,
                    'target_class'   => HierarchicalRole::class,
                    'property'       => 'name',
                    'find_method'    => [
                        'name' => 'getAccessibleRoles'
                    ],
                    'label' => 'Role'
                ],
                'attributes' => [
                    'class'     => 'form-control input-medium select2me',
                    'multiple' => true,
                ]
            ]
        );
    }
}
