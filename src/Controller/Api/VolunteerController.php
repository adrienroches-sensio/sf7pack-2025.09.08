<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\VolunteeringRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
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
                'groups' => ['volunteering/show'],
            ]),
            json: true,
        );
    }
}
