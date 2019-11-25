<?php

namespace Idy\Idea\Controllers\Web;

use Phalcon\Mvc\Controller;
use Idy\Idea\Application\CreateNewIdeaRequest;
use Idy\Idea\Application\CreateNewIdeaService;
use Idy\Idea\Application\ViewAllIdeasService;
use Idy\Idea\Application\RateIdeaRequest;
use Idy\Idea\Application\RateIdeaService;
use Idy\Idea\Application\VoteIdeaRequest;
use Idy\Idea\Application\VoteIdeaService;
use Idy\Idea\Application\ViewIdeaByIdRequest;
use Idy\Idea\Application\ViewIdeaByIdService;

class IdeaController extends Controller
{
    private $createNewIdeaService;
    private $rateIdeaService;
    private $viewAllIdeasService;
    private $viewIdeaByIdService;
    private $voteIdeaService;
    private $session;

    public function onConstruct()
    {
        $ideaRepository = $this->di->getShared('sql_idea_repository');
        $ratingRepository = $this->di->getShared('sql_rating_repository');
        $this->createNewIdeaService = new CreateNewIdeaService($ideaRepository);
        $this->rateIdeaService = new RateIdeaService($ideaRepository, $ratingRepository);
        $this->viewAllIdeasService = new ViewAllIdeasService($ideaRepository, $ratingRepository);
        $this->viewIdeaByIdService = new ViewIdeaByIdService($ideaRepository, $ratingRepository);
        $this->session = $this->di->getShared('session');
        $this->voteIdeaService = new VoteIdeaService($ideaRepository);
    }

    public function indexAction()
    {
        $response = $this->viewAllIdeasService->execute();
        $ideas = $response->ideas;
        $this->view->setVars([
            'ideas' => $ideas
        ]);
        return $this->view->pick('home');
    }

    public function addAction()
    {
        if($this->request->isPost()) {
            $title = $this->request->getPost('title');
            $description = $this->request->getPost('description');
            $authorName = $this->request->getPost('author_name');
            $authorEmail = $this->request->getPost('author_email');

            $request = new CreateNewIdeaRequest($title,$description,$authorName,$authorEmail);
            $result = $this->createNewIdeaService->execute($request); 
            $this->response->redirect('idea');
            return $this->view->disable();


        }
        return $this->view->pick('add');
    }

    public function voteAction($id)
    {
        $voteRequest = new VoteIdeaRequest($id);
        $response = $this->voteIdeaService->execute($voteRequest);
        $idea = $response->idea; 
        $this->response->redirect('idea');
    }

    public function rateAction($id)
    {
        if(!isset($id)) 
        {
            $this->response->redirect('idea');
            return;
        }

        if($this->request->isPost())
        {
            $ratingUser = $this->request->getPost('name');
            $ratingValue = $this->request->getPost('rating');
            $rateIdeaRequest = new RateIdeaRequest($id, $ratingUser, $ratingValue);
            $response = $this->rateIdeaService->execute($rateIdeaRequest); 
        }
        $viewIdeaByIdRequest = new ViewIdeaByIdRequest($id);
        $response = $this->viewIdeaByIdService->execute($viewIdeaByIdRequest);
        $idea = $response->idea;
        $this->view->setVars
        ([
            'idea' => $idea
        ]);
        return $this->view->pick('rate');
    }

}