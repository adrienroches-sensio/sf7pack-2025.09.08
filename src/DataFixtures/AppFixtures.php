<?php

namespace App\DataFixtures;

use App\Entity\Conference;
use App\Entity\Organization;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $organization = new Organization();
        $organization->setName('SensioLabs');
        $organization->setPresentation('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
        $organization->setCreatedAt(new \DateTimeImmutable('2010-05-12'));

        for ($i = 15; $i <= 25; $i++) {
            $year = "20{$i}";

            $start = new DateTimeImmutable("{$year}-12-05");

            $conference = new Conference();
            $conference->setName("SymfonyCon {$i}");
            $conference->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
            $conference->setStartAt($start);
            $conference->setEndAt($start->modify('+2 days'));
            $conference->setAccessible(true);

            $organization->addConference($conference);

            $manager->persist($conference);
        }

        $manager->persist($organization);

        $manager->flush();
    }
}
