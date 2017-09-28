<?php

namespace AppBundle\Command;


use AppBundle\Entity\Movie;
use AppBundle\Event\MovieDisableEvent;

class MovieCommand
{
    // all implementations to fire up disableMovie

    private function disableMovie(Movie $movie)
    {
        $eventDispatcher = $this->getContainer()->get('event_dispatcher');
        $event = new MovieDisableEvent($movie, MovieDisableEvent::CMD_CONTEXT);
        $eventDispatcher->dispatch('app.movie_disable_event', $event);
    }
}