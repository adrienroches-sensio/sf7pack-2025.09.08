<?php

declare(strict_types=1);

namespace App\Volunteering;

use App\Entity\Volunteering;
use Symfony\Contracts\EventDispatcher\Event;

final class VolunteerSubscribedToConferenceEvent extends Event
{
    public function __construct(
        public readonly Volunteering $volunteering,
    ) {
    }
}
