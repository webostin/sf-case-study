<?php

namespace AppBundle\Event;


use AppBundle\Entity\Movie;

class MovieDisableEvent
{

    const USER_CONTEXT = 'user_ctx';
    const ADMIN_CONTEXT = 'admin_ctx';
    const CMD_CONTEXT = 'cmd_ctx';

    private $movie;
    private $context;

    public function __construct(Movie $movie, $context = MovieDisableEvent::USER_CONTEXT)
    {
        $this->movie = $movie;
        $this->context = $context;
    }

    public function getMovie()
    {
        return $this->movie;
    }

    public function getContext()
    {
        return $this->context;
    }

}