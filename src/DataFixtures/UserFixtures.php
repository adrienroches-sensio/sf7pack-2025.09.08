<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

final class UserFixtures extends Fixture
{
    private const USERS = [
        [
            'username' => 'nobody',
            'password' => 'nobody',
            'roles' => [],
        ],
        [
            'username' => 'user',
            'password' => 'user',
            'roles' => ['ROLE_USER'],
        ],
        [
            'username' => 'website',
            'password' => 'website',
            'roles' => ['ROLE_WEBSITE'],
        ],
        [
            'username' => 'organizer',
            'password' => 'organizer',
            'roles' => ['ROLE_ORGANIZER'],
        ],
        [
            'username' => 'admin',
            'password' => 'admin',
            'roles' => ['ROLE_ADMIN'],
        ],
    ];

    public function __construct(
        private readonly PasswordHasherFactoryInterface $passwordHasherFactory,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $passwordHasher = $this->passwordHasherFactory->getPasswordHasher(User::class);

        foreach (self::USERS as $userData) {
            $user = (new User())
                ->setUsername($userData['username'])
                ->setPassword($passwordHasher->hash($userData['password']))
                ->setRoles($userData['roles'])
            ;

            $manager->persist($user);
        }

        $manager->flush();
    }
}
