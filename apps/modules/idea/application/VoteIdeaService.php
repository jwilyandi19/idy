<?php
namespace Idy\Idea\Application;

use Idy\Idea\Domain\Model\IdeaId;
use Idy\Idea\Domain\Model\IdeaRepository;

class VoteIdeaService
{
    private $ideaRepository;

    public function __construct(IdeaRepository $ideaRepository)
    {
        $this->ideaRepository = $ideaRepository;
    }

    public function execute(VoteIdeaRequest $request)
    {
        $ideaId = new IdeaId($request->id);
        $idea = $this->ideaRepository->byId($ideaId);
        $idea->vote();
        $this->ideaRepository->save($idea);
        
        $response = new VoteIdeaResponse($idea);
        return $response;
    }
    
}