<?php
namespace Idy\Idea\Domain\Event;

use Idy\Common\Events\DomainEventSubscriber;
use Idy\Idea\Domain\Model\IdeaRated;

class MailDomainEventSubscriber implements DomainEventSubscriber{
    
    private $acceptedEvents;

    public function __construct()
    {
        $this->acceptedEvents = [
            'Idy\Idea\Domain\Model\IdeaRated'
        ];    
    }
    
    public function handle($aDomainEvent)
    {
        $domainEventClass = get_class($aDomainEvent);
        switch ($domainEventClass) {
            case 'Idy\Idea\Domain\Model\IdeaRated':
                $this->sendIdeaRatedMail($aDomainEvent);
        }
    }

    public function isSubscribedTo($aDomainEvent){
        $domainEventClass = get_class($aDomainEvent);
        var_dump($domainEventClass);
        if(in_array($domainEventClass, $this->acceptedEvents)){
            return true;
        }
        return false;
    }

    private function sendIdeaRatedMail($ideaRated)
    {
        var_dump($ideaRated);
    }
}