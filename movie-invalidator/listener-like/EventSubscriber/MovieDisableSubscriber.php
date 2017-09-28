<?php

namespace AppBundle\EventSubscriber;

use AppBundle\Entity\Message;
use AppBundle\Entity\Movie;
use AppBundle\Event\MovieDisableEvent;
use AppBundle\Service\Mailing;

class MovieDisableSubscriber
{

    // impl ContainerAware

    public function onDisableMovie(MovieDisableEvent $event)
    {
        $movie = $event->getMovie();

        $em = $this->getContainer()->getDoctrine()->getEntityManager();
        $em->remove($movie);

        $this->getContainer()->get('app.caching')->reset();

        $mailing = $this->getContainer()->get('app.mailing');
        $context = $event->getContext();

        switch ($context) {
            case MovieDisableEvent::USER_CONTEXT:
                $this->informAdmin($movie, $mailing, Message::userMovieDisable);
                break;
            case MovieDisableEvent::ADMIN_CONTEXT:
                $this->informUser($movie, $mailing);
                break;
            case MovieDisableEvent::CMD_CONTEXT:
                $this->informUser($movie, $mailing);
                $this->informAdmin($movie, $mailing, Message::cmdMovieDisable);
                break;
        }
    }

    private function informUser(Movie $movie, Mailing $mailing)
    {
        $message = $this->getContainer()->get('app.message_repository')->findByReference(Message::adminMovieDisable);
        $mailing->setMessage($message);
        $user = $movie->getUser();
        $mailing->setToAddress($user);
        $mailing->send();
    }

    private function informAdmin(Movie $movie, Mailing $mailing, $messageId)
    {
        // Movie is to set up title - I know it is not used but in normal case
        // user has to be onformed about movie title

        $message = $this->getContainer()->get('app.message_repository')->findByReference($messageId);
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