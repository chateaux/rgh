<?php
namespace Application\InputFilter;

use Zend\InputFilter\InputFilter;

class VerifyFilter extends InputFilter
{
    public function __construct(
    ) {
        $this->add(
            [
                'name'     => 'recordNumber',
                'required' => true,
                'filters'    => [
                    ['name' => 'StringTrim'],
                    ['name' => 'StringToUpper']
                ],
            ]
        );

        $this->add(
            [
                'name'     => 'verificationCode',
                'required' => true,
                'filters'    => [
                    ['name' => 'StringTrim'],
                    ['name' => 'StringToUpper']
                ],
            ]
        );
    }
}
