<?php

namespace Idy\Idea\Application;

class VoteIdeaResponse
{
    public $idea;
    
    public function __construct($idea)
    {
        $this->idea = $idea;
    }
}