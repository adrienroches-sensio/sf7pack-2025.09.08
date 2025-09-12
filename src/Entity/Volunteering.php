<?php

namespace App\Entity;

use App\Repository\VolunteeringRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: VolunteeringRepository::class)]
class Volunteering
{
    #[Groups(['volunteering/show'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['volunteering/show'])]
    #[ORM\Column(type: Types::DATETIMETZ_IMMUTABLE)]
    private ?\DateTimeImmutable $startAt = null;

    #[Groups(['volunteering/show'])]
    #[Assert\GreaterThanOrEqual(propertyPath: 'startAt')]
    #[ORM\Column(type: Types::DATETIMETZ_IMMUTABLE)]
    private ?\DateTimeImmutable $endAt = null;

    #[Groups(['volunteering/show'])]
    #[ORM\ManyToOne(inversedBy: 'volunteerings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Conference $conference = null;

    #[Groups(['volunteering/show'])]
    #[ORM\ManyToOne(inversedBy: 'volunteerings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $forUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeImmutable $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getConference(): ?Conference
    {
        return $this->conference;
    }

    public function setConference(?Conference $conference): static
    {
        $this->conference = $conference;

        return $this;
    }

    public function getForUser(): ?User
    {
        return $this->forUser;
    }

    public function setForUser(?User $forUser): static
    {
        $this->forUser = $forUser;

        return $this;
    }

    #[Assert\Callback()]
    public function validate(ExecutionContextInterface $context, mixed $payload): void
    {
        $conference = $this->getConference();

        if ($conference instanceof Conference) {
            if ($this->getStartAt()->format('d/m/Y') < $conference->getStartAt()->format('d/m/Y')
                || $this->getStartAt()->format('d/m/Y') > $conference->getEndAt()->format('d/m/Y')
            ) {
                $context->buildViolation("The volunteering start date should be comprised in the event's dates")
                    ->atPath('startAt')
                    ->addViolation();
            }

            if (
                $this->getEndAt()->format('d/m/Y') < $conference->getStartAt()->format('d/m/Y')
                || $this->getEndAt()->format('d/m/Y') > $conference->getEndAt()->format('d/m/Y')
            ) {
                $context->buildViolation("The volunteering end date should be comprised in the event's dates")
                    ->atPath('endAt')
                    ->addViolation();
            }
        }
    }
}
