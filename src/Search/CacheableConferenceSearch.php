<?php

declare(strict_types=1);

namespace App\Search;

use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator(ConferenceSearchInterface::class)]
final class CacheableConferenceSearch implements ConferenceSearchInterface
{
    private array $cache = [];

    public function __construct(
        private readonly ConferenceSearchInterface $inner,
    ) {
    }

    public function searchByName(?string $name = null): array
    {
        $name = $name ?? '__default__';
        $key = md5($name);

        return $this->cache[$key] ??= $this->inner->searchByName($name);
    }
}
