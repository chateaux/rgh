<?php
namespace Application\InputFilter;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineModule\Validator\NoObjectExists;
use User\InputFilter\UserFilter;

class RegisterFilter extends UserFilter
{
    public function __construct(
        ObjectManager $objectManager,
        ObjectRepository $objectRepository
    ) {
        parent::__construct($objectManager, $objectRepository);

        $this->get('email')->getValidatorChain()->attachByName(
            NoObjectExists::class,
            [
                'object_repository' => $objectRepository,
                'fields'            => 'email'
            ]
        );
    }
}
