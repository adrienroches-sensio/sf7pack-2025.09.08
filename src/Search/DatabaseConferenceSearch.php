<?php

declare(strict_types=1);

namespace App\Search;

use App\Entity\Conference;
use App\Repository\ConferenceRepository;

final class DatabaseConferenceSearch
{
    public function __construct(
        private readonly ConferenceRepository $conferenceRepository,
    ) {
    }

    /**
     * @return list<Conference>
     */
    public function searchByName(string|null $name = null): array
    {
        $name = trim($name ?? '');

        if ('' === $name) {
            return $this->conferenceRepository->list();
        }

        return $this->conferenceRepository->searchByName($name);
    }
}
