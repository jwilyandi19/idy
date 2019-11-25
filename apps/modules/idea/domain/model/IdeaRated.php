<?php

namespace Idy\Idea\Domain\Model;

use Idy\Common\Events\DomainEvent;
use DateTimeImmutable;

class IdeaRated implements DomainEvent 
{
    private $name;
    private $email;
    private $title;
    private $rating;

    private $occuredOn;

    public function name()
    {
        return $this->name;
    }

    public function email()
    {
        return $this->email;
    }

    public function title()
    {
        return $this->title;
    }

    public function rating()
    {
        return $this->rating;
    }

    public function __construct(
        $name, $email, $title, $rating)
    {
        $this->name = $name;
        $this->email = $email;
        $this->title = $title;
        $this->rating = $rating;
        $this->occuredOn = new DateTimeImmutable();
    }

    /**
    * @return DateTimeImmutable
    */
    public function occurredOn()
    {
        return $this->occuredOn;
    }
}