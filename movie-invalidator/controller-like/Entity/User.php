<?php

namespace AppBundle\Entity;


use AppBundle\Mailing\EmailAddressInterface;

class User implements EmailAddressInterface
{

    public $id;
    public $email;

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

}