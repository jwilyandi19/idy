<?php

namespace Idy\Idea\Application;

use Idy\Idea\Domain\Model\IdeaRepository;

class ViewAllIdeasService 
{
    private $ideaRepository;

    public function __construct(
        IdeaRepository $ideaRepository)
    {
        $this->ideaRepository = $ideaRepository;
    }

    public function execute()
    {
        //$idea = new Idea();
        $ideas = $this->ideaRepository->allIdeas();

        $response = new ViewAllIdeasResponse($ideas);
        return $response;
    }
}
