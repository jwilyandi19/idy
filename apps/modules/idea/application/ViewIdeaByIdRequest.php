<?php

namespace Idy\Idea\Application;

class ViewIdeaByIdRequest
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}