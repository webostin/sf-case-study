<?php


namespace AppBundle\Entity;


use AppBundle\Mailing\MessageInterface;

class Message implements MessageInterface
{
    const adminMovieDisable = 'admin_movie_disable';
    const userMovieDisable = 'user_movie_disable';
    const cmdMovieDisable = 'cmd_movie_disable';

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }


}