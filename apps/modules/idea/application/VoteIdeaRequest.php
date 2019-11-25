<?php

namespace Idy\Idea\Application;

class VoteIdeaRequest
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

}