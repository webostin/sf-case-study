<?php

namespace AppBundle\Command;


use AppBundle\Entity\Message;
use AppBundle\Entity\Movie;
use AppBundle\Service\Mailing;

class MovieCommand
{
    // all implementations to fire up disableMovie

    private function disableMovie(Movie $movie)
    {
        $em = $this->getContainer()->getDoctrine()->getEntityManager();
        $em->remove($movie);

        $this->getContainer()->get('app.caching')->reset();

        $mailing = $this->getContainer()->get('app.mailing');
        $this->informUser($movie, $mailing);
        $this->informAdmin($movie, $mailing);
    }

    private function informUser($movie, Mailing $mailing)
    {
        $message = $this->getContainer()->get('app.message_repository')->findByReference(Message::adminMovieDisable);
        $mailing->setMessage($message);
        $user = $movie->getUser();
        $mailing->setToAddress($user);
        $mailing->send();
    }

    private function informAdmin($movie, Mailing $mailing)
    {
        $message = $this->getContainer()->get('app.message_repository')->findByReference(Message::cmdMovieDisable);
        $mailing->setMessage($message);
        $admins = $this->getContainer()->get('app.admin_repository')->findAll();

        if (!empty($admins)) {
            foreach ($admins as $admin) {
                $mailing->addToAddress($admin);
            }

            $mailing->send();
        }
    }
}