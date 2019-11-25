<?php

namespace Idy\Idea\Domain\Model;

use Idy\Common\Events\DomainEventPublisher;

class Idea
{
    private $id;
    private $title;
    private $description;
    private $author;
    private $ratings;
    private $votes;
    
    public function __construct(IdeaId $id, $title, $description, Author $author)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->author = $author;
        $this->ratings = array();
        $this->votes = 0;
    }

    public function id() 
    {
        return $this->id;
    }

    public function title()
    {
        return $this->title;
    }

    public function description()
    {
        return $this->description;
    }

    public function author()
    {
        return $this->author;
    }

    public function ratings()
    {
        return $this->ratings;
    }

    public function votes()
    {
        return $this->votes;
    }

    public function loadRatings(array $ratings){
        $this->ratings = $ratings;
    }

    public function addRating($newRating)
    {

        if ($newRating->isValid()) {
            $exist = false;
            foreach ($this->ratings as $existingRating) {
                if ($existingRating->equals($newRating)) {
                    $exist = true;
                }
            }

            if (!$exist) {
                array_push($this->ratings, $newRating);
            } else {
                throw new UserAlreadyRatedException('User ' . $newRating->user() . ' has given a rating.');
            }

            DomainEventPublisher::instance()->publish(
                new IdeaRated($this->author->name(), $this->author->email(), $this->title, $newRating->value())
            );

        }
    }

    public function vote()
    {   
        $this->votes = $this->votes + 1;
    }

    public function averageRating()
    {
        $numberOfRatings = count($this->ratings);
        $totalRatings = 0;

        foreach ($this->ratings as $rating) {
            $totalRatings += $rating->value();
        }

        if($numberOfRatings==0) {
            return 0;
        }
        return $totalRatings / $numberOfRatings;
    }

    public static function makeIdea($title, $description, $author)
    {
        $newIdea = new Idea(new IdeaId(), $title, $description, $author);
        
        return $newIdea;
    }

}