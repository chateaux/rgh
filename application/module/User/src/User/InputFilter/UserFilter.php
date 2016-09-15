<?php
namespace User\InputFilter;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Zend\InputFilter\InputFilter;

class UserFilter extends InputFilter
{
    public function __construct(
        ObjectManager $objectManager,
        ObjectRepository $objectRepository
    ) {
        $this->add(
            [
                'name'     => 'id',
                'required' => false,
                'filters'  => [
                    ['name' => 'Int']
                ]
            ]
        );

        $this->add(
            [
                'name'     => 'isAgent',
                'required' => true,
                'filters'  => [
                    ['name' => 'Int']
                ]
            ]
        );

        $this->add(
            [
                'name'     => 'isMerchant',
                'required' => true,
                'filters'  => [
                    ['name' => 'Int']
                ]
            ]
        );

        $this->add(
            [
                'name'     => 'isLicenseHolder',
                'required' => true,
                'filters'  => [
                    ['name' => 'Int']
                ]
            ]
        );

        $this->add(
            [
                'name'     => 'isPublisher',
                'required' => true,
                'filters'  => [
                    ['name' => 'Int']
                ]
            ]
        );

        $this->add(
            [
                'name'     => 'uuid',
                'required' => false
            ]
        );

        $this->add(
            [
                'name'       => 'title',
                'required'   => false,
                'filters'    => [
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 5
                        ]
                    ]
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'firstname',
                'required'   => false,
                'filters'    => [
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 128
                        ]
                    ]
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'surname',
                'required'   => false,
                'filters'    => [
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 128
                        ]
                    ]
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'email',
                'required'   => false,
                'filters'    => [
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 3,
                            'max' => 255
                        ]
                    ],
                    [
                        'name' => 'EmailAddress',
                        'options' => [
                            'useDomainCheck' => true,  //Set to false in order to validate local developer test mails: myemail.dev
                            'message' => "This is not a valid email address"
                        ],

                    ]
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'username',
                'required'   => false,
                'filters'    => [
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 2
                        ]
                    ]
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'displayName',
                'required'   => false,
                'filters'    => [
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 5,
                            'max' => 30
                        ]
                    ]
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'cell',
                'required'   => false,
                'filters'    => [
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 5,
                            'max' => 64
                        ]
                    ]
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'tell',
                'required'   => false,
                'filters'    => [
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 5,
                            'max' => 64
                        ]
                    ]
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'password',
                'required'   => false,
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 5,
                            'max' => 128
                        ]
                    ]
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'passwordRepeat',
                'required'   => false,
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 5,
                            'max' => 128
                        ]
                    ],
                    [
                        'name'    => 'Identical',
                        'options' => [
                            'token' => 'password',
                        ],
                    ],
                ]
            ]
        );

        $this->add(
            [
                'name'     => 'gender',
                'required' => false,
                'filters'  => [
                    ['name' => 'Boolean']
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'dob',
                'required'   => false,
                'filters'    => [
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    ['name' => 'Date']
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'roles',
                'required'   => true,
                'validators' => [

                ]
            ]
        );

        $this->add([
                'name'      => 'address1',
                'required'  => false,
                'filters'   => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 2,
                            'max'      => 128,
                        ],
                    ],
                ],
            ]);

        $this->add([
                'name'      => 'address2',
                'required'  => false,
                'filters'   => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 2,
                            'max'      => 128,
                        ],
                    ],
                ],
            ]);

        $this->add([
                'name'      => 'city',
                'required'  => false,
                'filters'   => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 2,
                            'max'      => 128,
                        ],
                    ],
                ],
            ]);

        $this->add([
                'name'      => 'region',
                'required'  => false,
                'filters'   => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 2,
                            'max'      => 128,
                        ],
                    ],
                ],
            ]);

        $this->add([
                'name'      => 'country',
                'required'  => true,
                'validators' => [
                    [
                        'name' => 'DoctrineModule\Validator\ObjectExists',
                        'options' => [
                            'object_repository' => $objectManager->getRepository('User\Entity\Country'),
                            'object_manager'    => $objectManager,
                            'fields'            => 'id',
                        ],
                    ],
                ],
            ]);

        $this->add([
                'name'      => 'postCode',
                'required'  => false,
                'filters'   => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 2,
                            'max'      => 30,
                        ],
                    ],
                ],
            ]);
        $this->add([
                'name'      => 'state',
                'required'  => true
            ]);
        $this->add(
            [
                'name'     => 'agreeTermsConditions',
                'required' => true,
            ]
        );
        $this->add(
            [
                'name'     => 'isSubscribed',
                'required' => true,
                'filters'  => [
                    ['name' => 'Int']
                ]
            ]
        );
    }
}
