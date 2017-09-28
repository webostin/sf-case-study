<?php

namespace AppBundle\Entity;


use AppBundle\Mailing\EmailAddressInterface;

class Admin implements EmailAddressInterface
{

    public $email;

    public function getEmail()
    {
        return $this->email;
    }

}