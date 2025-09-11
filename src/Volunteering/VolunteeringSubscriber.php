<?php

declare(strict_types=1);

namespace App\Volunteering;

use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

final class VolunteeringSubscriber
{
    #[AsEventListener]
    public function sendThankYouEmail(VolunteerSubscribedToConferenceEvent $event): void
    {
        dump(sendThankYouEmail: $event);

        // ...
    }

    #[AsEventListener]
    public function incrementVolunteeringAct(VolunteerSubscribedToConferenceEvent $event, string $name, EventDispatcherInterface $eventDispatcher): void
    {
        dump(incrementVolunteeringAct: $event);

        // ...

        $eventDispatcher->dispatch(new VolunteeringActIncrementedEvent($event->volunteering->getForUser()));
    }

    #[AsEventListener]
    public function addBadgeIfEnoughVolunteeringAct(VolunteeringActIncrementedEvent $event): void
    {
        dump(addBadgeIfEnoughVolunteeringAct: $event);

        // ...
    }
}
