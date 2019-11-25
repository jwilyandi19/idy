<?php 

namespace Idy\Idea\Infrastructure;

use Idy\Idea\Domain\Model\IdeaId;
use Idy\Idea\Domain\Model\Rating;
use Idy\Idea\Domain\Model\RatingRepository;
use Phalcon\Db\Column;

class SqlRatingRepository implements RatingRepository
{
    private $db;

    public function __construct($di)
    {
        $this->db = $di->get('db');
    }

    public function byIdeaId(IdeaId $id) : array
    {
        $statement = $this->db->prepare(
            "SELECT user, value FROM `ratings` WHERE idea_id = :id"
        );
        $placeholders = [
            "id" => $id->id()
        ];
        $dataTypes = [
            "id" => Column::BIND_PARAM_STR
        ];

        $ratingResult = $this->db->executePrepared($statement,$placeholders,$dataTypes);
        $ratingRows = $ratingResult->fetchAll();
        $ratings = array();
        foreach($ratingRows as $row)
        {
            $rating = $this->convertRating($row);
            array_push($ratings,$rating);
        }
        return $ratings;

    }

    public function save(Rating $rating,IdeaId $id) : int
    {
        $statement = "INSERT INTO `ratings` (idea_id, user, value)
        VALUE (:ideaId, :user, :value)";
        $placeholders = [
            "ideaId" => $id->id(),
            "user" => $rating->user(),
            "value" => $rating->value()
        ];
        $dataTypes = [
            "ideaId" => Column::BIND_PARAM_STR,
            "user" => Column::BIND_PARAM_STR,
            "value" => Column::BIND_PARAM_INT,
        ];
        $isExecuted = $this->db->execute($statement,$placeholders,$dataTypes);
        return $isExecuted;
    }

    private function convertRating(array $row) : Rating
    {
        $rating = new Rating($row["user"],$row["value"]);
        return $rating;
    }
}