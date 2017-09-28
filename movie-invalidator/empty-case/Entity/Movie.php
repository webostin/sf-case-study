<?php

namespace AppBundle\Entity;


class Movie
{
    public $user;

    public function getUser():User
    {
        return $this->user;
    }
}