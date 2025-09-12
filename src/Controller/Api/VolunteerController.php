<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Conference;
use App\Entity\User;
use App\Repository\VolunteeringRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class VolunteerController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly VolunteeringRepository $volunteeringRepository,
    ) {
    }

    #[Route('/api/volunteers', name: 'api_volunteers', methods: ['GET'])]
    public function list(): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize($this->volunteeringRepository->list(), 'json', [
                AbstractNormalizer::CALLBACKS => [
                    'conference' => function (object $attributeValue, object $object, string $attributeName, ?string $format = null, array $context = []) {
                        return $attributeValue instanceof Conference ? $attributeValue->getName() : null;
                    },
                    'forUser' => function (object $attributeValue, object $object, string $attributeName, ?string $format = null, array $context = []) {
                        return $attributeValue instanceof User ? $attributeValue->getUserIdentifier() : null;
                    },
                ],
            ]),
            json: true,
        );
    }
}
