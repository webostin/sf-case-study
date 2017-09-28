<?php

namespace AppBundle\Command;


use AppBundle\Entity\Movie;
use AppBundle\Service\Disabling;

class MovieCommand
{
    // all implementations to fire up disableMovie

    private function disableMovie(Movie $movie)
    {
        $this->getContainer()
            ->get('app.disabling')
            ->disable($movie, Disabling::CMD_CONTEXT);
    }
}