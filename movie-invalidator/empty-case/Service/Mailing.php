<?php

namespace AppBundle\Service;


use AppBundle\Mailing\EmailAddressInterface;
use AppBundle\Mailing\MessageInterface;

class Mailing
{

    private $toAddresses;
    private $message;

    public function addToAddress(EmailAddressInterface $email)
    {
        if (!in_array($email->getEmail(), $this->toAddresses)) {
            $this->toAddresses[] = $email->getEmail();
        }
    }

    public function setMessage(MessageInterface $message)
    {
        $this->message = $message;
        return $this;
    }

    public function send()
    {
        // send with mailer etc
    }


}