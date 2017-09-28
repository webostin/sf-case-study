<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Movie;
use AppBundle\Service\Disabling;

class AdminMovieController
{
    public function removeMovieAction($id)
    {
        $movie = $this->get('app.movie_repository')->find($id);
        if ($movie instanceof Movie) {
            $this->get('app.disabling')
                ->disable($movie, Disabling::ADMIN_CONTEXT);
        }

        // return view
    }
}