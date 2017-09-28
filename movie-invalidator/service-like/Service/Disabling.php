<?php


namespace AppBundle\Service;


use AppBundle\Entity\Message;
use AppBundle\Entity\Movie;

class Disabling
{
    // imp container aware

    const USER_CONTEXT = 'user_ctx';
    const ADMIN_CONTEXT = 'admin_ctx';
    const CMD_CONTEXT = 'cmd_ctx';


    public function disable($entity, $context = Disabling::USER_CONTEXT)
    {
        if ($entity instanceof Movie) {
            $this->removeMovie($entity, $context);
        }
    }

    public function disableMovie(Movie $movie, $context = Disabling::USER_CONTEXT)
    {

        $em = $this->getContainer()->getDoctrine()->getEntityManager();
        $em->remove($movie);

        $this->getContainer()->get('app.caching')->reset();

        $mailing = $this->getContainer()->get('app.mailing');

        switch ($context) {
            case Disabling::USER_CONTEXT:
                $this->informMovieAdmin($movie, $mailing, Message::userMovieDisable);
                break;
            case Disabling::ADMIN_CONTEXT:
                $this->informMovieUser($movie, $mailing);
                break;
            case MovieDisableEvent::CMD_CONTEXT:
                $this->informMovieUser($movie, $mailing);
                $this->informMovieAdmin($movie, $mailing, Message::cmdMovieDisable);
                break;
        }
    }

    private function informMovieUser(Movie $movie, Mailing $mailing)
    {
        $message = $this->getContainer()->get('app.message_repository')->findByReference(Message::adminMovieDisable);
        $mailing->setMessage($message);
        $user = $movie->getUser();
        $mailing->setToAddress($user);
        $mailing->send();
    }

    private function informMovieAdmin(Movie $movie, Mailing $mailing, $messageId)
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