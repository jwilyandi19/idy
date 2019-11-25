<?php 

namespace Idy\Idea\Infrastructure;

use Phalcon\Db\Column;
use Idy\Idea\Domain\Model\Author;
use Idy\Idea\Domain\Model\Idea;
use Idy\Idea\Domain\Model\IdeaId;
use Idy\Idea\Domain\Model\IdeaRepository;



class SqlIdeaRepository implements IdeaRepository
{
    private $ideas;
    private $db;
    

    public function __construct($di)
    {
        $this->db = $di->get('db');
        $this->ideas = array();
    }

    public function byId(IdeaId $id): ?Idea
    {
        $statement = $this->db->prepare
        (
            "SELECT id,title,description,author_name,author_email,votes FROM `ideas` WHERE id = :id"
        );
        $placeholders = 
        [
            "id" => $id->id()
        ];
        $dataTypes = 
        [
            "id" => Column::BIND_PARAM_STR
        ];

        $ideaResult = $this->db->executePrepared($statement,$placeholders,$dataTypes);
        $ideaRow = $ideaResult->fetch();
        if(!$ideaRow) 
        {
            return null;
        }

        $idea = $this->convertIdea($ideaRow);
        return $idea;

    }

    public function save(Idea $idea): int
    {
        $isExist = $this->exist($idea->id());
        $placeholders = 
        [
            "id" => $idea->id()->id(),
            "title" => $idea->title(),
            "description" => $idea->description(),
            "authorName" => $idea->author()->name(),
            "authorEmail" => $idea->author()->email(),
            "votes" => $idea->votes()
        ];
        $dataTypes = 
        [
            "id" => Column::BIND_PARAM_STR,
            "title" => Column::BIND_PARAM_STR,
            "description" => Column::BIND_PARAM_STR,
            "authorName" => Column::BIND_PARAM_STR,
            "authorEmail" => Column::BIND_PARAM_STR,
            "votes" => Column::BIND_PARAM_INT
        ];
        $statementList = [
            "isNotExist" => "INSERT INTO `ideas` (id, title, description, author_name, author_email, votes) 
            VALUE (:id, :title, :description, :authorName, :authorEmail, :votes)",
            "isExist" => " UPDATE `ideas` SET title=:title, description=:description, author_name=:authorName, 
            author_email=:authorEmail, votes=:votes WHERE id = :id"
        ];
        $statement = "";
        if(!$isExist)
        {
            $statement = $statementList["isNotExist"];
        }
        else
        {
            $statement = $statementList["isExist"];
        }

        $isExecuted = $this->db->execute($statement,$placeholders,$dataTypes);
        return $isExecuted;
    }
    

    public function exist(IdeaId $id): int
    {
        $statement = $this->db->prepare
        (
            "SELECT 1 from `ideas` WHERE id = :id"
        );
        $placeholders =
        [
            "id" => $id->id()
        ];
        $dataTypes = 
        [
            "id" => Column::BIND_PARAM_STR
        ];
        $ideaResult =  $this->db->executePrepared($statement,$placeholders,$dataTypes);
        $ideaRow = $ideaResult->fetch();
        return $ideaRow ? 1 : 0;
    }

    public function allIdeas() : array
    {
        $ideaResult = $this->db->query
        (
            "SELECT id, title, description, author_name, author_email, votes FROM `ideas`"
        );
        $ideaRows = $ideaResult->fetchAll();
        $ideas = array();
        foreach($ideaRows as $row) 
        {
            $idea = $this->convertIdea($row);
            array_push($ideas,$idea);
        }
        return $ideas;

    }

    private function convertIdea(array $row) 
    {
        $ideaId = new IdeaId($row["id"]);
        $author = new Author($row["author_name"],$row["author_email"]);
        $idea = new Idea(
            $ideaId,
            $row["title"],
            $row["description"],
            $author
        );
        return $idea;
    }
    
}