<?php
namespace User\Service;

use Zend\Crypt\Password\Bcrypt;

class PasswordService extends Bcrypt
{
    protected $cost = 10;
}
