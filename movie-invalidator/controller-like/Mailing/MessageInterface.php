<?php


namespace AppBundle\Mailing;


interface MessageInterface
{
    public function getTitle();

    public function getContent();
}