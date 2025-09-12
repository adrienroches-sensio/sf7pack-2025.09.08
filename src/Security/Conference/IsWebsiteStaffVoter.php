<?php

declare(strict_types=1);

namespace App\Security\Conference;

use App\Entity\Conference;
use App\Security\ConferencePermissions;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

final class IsWebsiteStaffVoter implements VoterInterface
{
    public function __construct(
        private readonly AuthorizationCheckerInterface $authorizationChecker,
    ) {
    }

    public function vote(TokenInterface $token, mixed $subject, array $attributes, ?Vote $vote = null): int
    {
        [$attribute] = $attributes;

        if ($attribute !== ConferencePermissions::EDIT) {
            return self::ACCESS_ABSTAIN;
        }

        if (! $subject instanceof Conference) {
            return self::ACCESS_ABSTAIN;
        }

        $isRoleWebsite = $this->authorizationChecker->isGranted('ROLE_WEBSITE');

        if ($isRoleWebsite === false) {
            return self::ACCESS_ABSTAIN;
        }

        $vote?->addReason('User is granted ROLE_WEBSITE');

        return self::ACCESS_GRANTED;
    }
}
