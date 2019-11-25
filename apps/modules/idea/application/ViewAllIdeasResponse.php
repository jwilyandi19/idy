<?php

namespace Idy\Idea\Application;

use Idy\Idea\Domain\Model\Idea;

class ViewAllIdeasResponse 
{
    public $ideas;

    public function __construct(array $ideas)
    {
        $this->ideas = $ideas;
    }
}