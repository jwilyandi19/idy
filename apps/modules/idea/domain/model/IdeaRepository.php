<?php

namespace Idy\Idea\Domain\Model;

interface IdeaRepository
{
    public function byId(IdeaId $id) : ?Idea;
    public function save(Idea $idea): int;
    public function exist(IdeaId $id): int;
    public function allIdeas() : array;
}