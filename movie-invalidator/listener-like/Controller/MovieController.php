<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Movie;
use AppBundle\Event\MovieDisableEvent;

class MovieController
{
    public function removeMovieAction($id)
    {
        $movie = $this->get('app.movie_repository')->find($id);
        if ($movie instanceof Movie) {
            $eventDispatcher = $this->get('event_dispatcher');
            $event = new MovieDisableEvent($movie, MovieDisableEvent::USER_CONTEXT);
            $eventDispatcher->dispatch('app.movie_disable_event', $event);
        }

        // return view or flash
    }

}