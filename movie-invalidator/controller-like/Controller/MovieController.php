<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Entity\Movie;

class MovieController
{
    public function removeMovieAction($id)
    {
        $movie = $this->get('app.movie_repository')->find($id);
        if ($movie instanceof Movie) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->remove($movie);

            $this->get('app.cache')->reset();
            $message = $this->get('app.message_repository')->findByReference(Message::userMovieDisable);
            $mailing = $this->get('app.mailing');
            $mailing->setMessage($message);

            $admins = $this->get('app.admin_repository')->findAll();

            if (!empty($admins)) {
                foreach ($admins as $admin) {
                    $mailing->addToAddress($admin);
                }

                $mailing->send();
            }

        }
    }

}