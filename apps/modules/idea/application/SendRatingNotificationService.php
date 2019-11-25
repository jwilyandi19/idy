<?php

namespace Idy\Idea\Application;

use Idy\Common\Events\DomainEventPublisher;
use Idy\Idea\Domain\Event\MailDomainEventSubscriber;
use Idy\Idea\Domain\Model\RatingReposiotry;

class SendRatingNotificationService
{
    private $ratingRepository;

    public function __construct(
        RatingReposiotry $ratingRepository)
    {
        $this->ratingRepository = $ratingRepository;
    }

    public function registerSubscriber()
    {
        $subscriber = new MailDomainEventSubscriber();
        
        DomainEventPublisher::instance()->subscribe($subscriber);
    }

    public function execute()
    {
        
    }

}