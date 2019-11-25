<?php

namespace Idy\Idea\Application;

use Idy\Idea\Domain\Model\IdeaDoesNotExistException;
use Idy\Idea\Domain\Model\IdeaId;
use Idy\Idea\Domain\Model\IdeaRepository;
use Idy\Idea\Domain\Model\Rating;
use Idy\Idea\Domain\Model\RatingRepository;
use Idy\Idea\Domain\Model\UserAlreadyRatedException;

class RateIdeaService
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

    public function execute(RateIdeaRequest $request)
    {
        $rating = new Rating($request->ratingUser, $request->ratingValue);
        $ideaId = new IdeaId($request->ideaId);
        try {
            $idea = $this->ideaRepository->byId($ideaId);
            $ratings = $this->ratingRepository->byIdeaId($ideaId);
            $idea->loadRatings($ratings);
            $idea->addRating($rating);
            $this->ratingRepository->save($rating, $idea->id());
        } catch (IdeaDoesNotExistException $error) {
            return "Idea does not exist";
        } catch (UserAlreadyRatedException $error) {
            return "User already rated";
        }
        
        $response = new RateIdeaResponse($idea, $rating);
        return $response;
    }

}