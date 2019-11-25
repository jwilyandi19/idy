<?php

namespace Idy\Idea\Controllers\Web;

use Phalcon\Mvc\Controller;
use Idy\Idea\Application\CreateNewIdeaRequest;
use Idy\Idea\Application\CreateNewIdeaService;
use Idy\Idea\Application\ViewAllIdeasService;

class IdeaController extends Controller
{
    private $createNewIdeaService;
    private $viewAllIdeasService;
    private $session;

    public function onConstruct()
    {
        $ideaRepository = $this->di->getShared('sql_idea_repository');
        $this->createNewIdeaService = new CreateNewIdeaService($ideaRepository);
        $this->viewAllIdeasService = new ViewAllIdeasService($ideaRepository);
        $this->session = $this->di->getShared('session');
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

    public function voteAction()
    {

    }

    public function rateAction()
    {
        
    }

}