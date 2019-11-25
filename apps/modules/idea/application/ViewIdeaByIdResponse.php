<?php
namespace Idy\Idea\Application;

use Idy\Idea\Domain\Model\Idea;

class ViewIdeaByIdResponse
{
    public $idea;
    
    public function __construct(Idea $idea)
    {
        $this->idea = $idea;
    }
}
    
