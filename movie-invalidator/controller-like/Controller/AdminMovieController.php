<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Message;
use AppBundle\Entity\Movie;

class AdminMovieController
{
    public function removeMovieAction($id)
    {
        $movie = $this->get('app.movie_repository')->find($id);
        if ($movie instanceof Movie) {

            $em = $this->getDoctrine()->getEntityManager();
            $em->remove($movie);

            $this->get('app.caching')->reset();

            $mailing = $this->get('app.mailing');
            $message = $this->get('app.message_repository')->findByReference(Message::userMovieDisable);
            $mailing->setMessage($message);
            $user = $movie->getUser();
            $mailing->setToAddress($user);
            $mailing->send();

        }
    }
}