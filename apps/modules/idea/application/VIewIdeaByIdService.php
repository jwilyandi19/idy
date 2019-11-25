<?php
namespace Idy\Idea\Application;
use Idy\Idea\Domain\Model\IdeaId;
use Idy\Idea\Domain\Model\IdeaRepository;
use Idy\Idea\Domain\Model\RatingRepository;

class ViewIdeaByIdService
{
    private $ideaRepository;
    private $ratingRepository;

    public function __construct(
        IdeaRepository $ideaRepository,
        RatingRepository $ratingRepository)
    {
        $this->ideaRepository = $ideaRepository;
        $this->ratingRepository = $ratingRepository;
    }

    public function execute(ViewIdeaByIdRequest $request)
    {
        $ideaId = new IdeaId($request->id);
        $idea = $this->ideaRepository->byId($ideaId);
        $ideaRatings = $this->ratingRepository->byIdeaId($ideaId);
        $idea->loadRatings($ideaRatings);
        
        $response = new ViewIdeaByIdResponse($idea);
        return $response;
    }
}