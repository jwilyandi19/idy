<?php

namespace Idy\Idea\Application;

use Idy\Idea\Domain\Model\IdeaRepository;
use Idy\Idea\Domain\Model\RatingRepository;

class ViewAllIdeasService 
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

    public function execute()
    {
        //$idea = new Idea();
        $ideasWithoutRatings = $this->ideaRepository->allIdeas();
        $ideas = array();


        foreach($ideasWithoutRatings as $ideaWithoutRatings) 
        {
            $ratings = $this->ratingRepository->byIdeaId($ideaWithoutRatings->id());
            $ideaWithoutRatings->loadRatings($ratings);
            $idea = $ideaWithoutRatings;
            array_push($ideas, $idea);
        }
        $response = new ViewAllIdeasResponse($ideas);
        return $response;
    }
}
