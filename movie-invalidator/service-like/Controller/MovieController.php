<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Movie;
use AppBundle\Service\Disabling;

class MovieController
{
    public function removeMovieAction($id)
    {
        $movie = $this->get('app.movie_repository')->find($id);
        if ($movie instanceof Movie) {
            $this->get('app.disabling')
                ->disable($movie, Disabling::USER_CONTEXT);
        }

        // return view
    }

}