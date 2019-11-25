<?php
namespace Idy\Idea\Application;
class RateIdeaRequest
{
    public $ratingUser;
    public $ratingValue;
    public $ideaId;

    public function __construct($ideaId,$ratingUser,$ratingValue)
    {
        $this->ideaId = $ideaId;
        $this->ratingUser = $ratingUser;
        $this->ratingValue = $ratingValue;
    }

    

}