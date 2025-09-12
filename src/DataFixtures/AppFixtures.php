<?php

namespace App\DataFixtures;

use App\Entity\Conference;
use App\Entity\Organization;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly PasswordHasherFactoryInterface $passwordHasherFactory,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $creator = (new User())
            ->setUsername('creator')
            ->setPassword($this->passwordHasherFactory->getPasswordHasher(User::class)->hash('creator'))
            ->setRoles(['ROLE_USER'])
        ;

        $manager->persist($creator);

        $sensiolabs = new Organization();
        $sensiolabs->setName('SensioLabs');
        $sensiolabs->setPresentation('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
        $sensiolabs->setCreatedAt(new \DateTimeImmutable('2010-05-12'));

        $symfonySas = new Organization();
        $symfonySas->setName('Symfony SAS');
        $symfonySas->setPresentation('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
        $symfonySas->setCreatedAt(new \DateTimeImmutable('2010-05-12'));

        for ($i = 15; $i <= 25; $i++) {
            $year = "20{$i}";

            $start = new DateTimeImmutable("{$year}-12-05");

            $conference = new Conference();
            $conference->setName("SymfonyCon {$i}");
            $conference->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
            $conference->setStartAt($start);
            $conference->setEndAt($start->modify('+2 days'));
            $conference->setAccessible(true);
            $conference->setCreatedBy($creator);

            $sensiolabs->addConference($conference);
            $symfonySas->addConference($conference);

            $manager->persist($conference);
        }

        $manager->persist($sensiolabs);
        $manager->persist($symfonySas);

        $conferenceWithoutOrganization = new Conference();
        $conferenceWithoutOrganization->setName("SymfonyCon without organization");
        $conferenceWithoutOrganization->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
        $conferenceWithoutOrganization->setStartAt(new DateTimeImmutable('2010-05-12'));
        $conferenceWithoutOrganization->setEndAt(new DateTimeImmutable('2010-05-14'));
        $conferenceWithoutOrganization->setAccessible(false);
        $conferenceWithoutOrganization->setPrerequisites('Some prerequisites.');

        $manager->persist($conferenceWithoutOrganization);

        $manager->flush();
    }
}
