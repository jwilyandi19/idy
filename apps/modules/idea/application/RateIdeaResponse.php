<?php
namespace Idy\Idea\Application;
use Idy\Idea\Domain\Model\Idea;
use Idy\Idea\Domain\Model\Rating;

class RateIdeaResponse
{
    public $idea;
    public $rating;
    public function __construct($idea, $rating)
    {
        $this->idea = $idea;
        $this->rating = $rating;
    }


}
