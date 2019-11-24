<?php

namespace Idy\Idea\Application;

use Idy\Idea\Domain\Model\IdeaRepository;
use Idy\Idea\Domain\Model\Author;
use Idy\Idea\Domain\Model\Idea;

class CreateNewIdeaService
{
    private $ideaRepository;

    public function __construct(
        IdeaRepository $ideaRepository)
    {
        $this->ideaRepository = $ideaRepository;
    }

    public function execute(CreateNewIdeaRequest $request)
    {
        //$idea = new Idea();
        $author = new Author($request->authorName, $request->authorEmail);
        $idea = Idea::makeIdea($request->ideaTitle,$request->ideaDescription,$author);

        $this->ideaRepository->save($idea);

        $response = new CreateNewIdeaResponse($idea);
        return $response;
    }

}