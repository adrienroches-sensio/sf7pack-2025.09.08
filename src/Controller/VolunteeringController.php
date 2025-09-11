<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Entity\Volunteering;
use App\Form\VolunteeringType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VolunteeringController extends AbstractController
{
    #[Route('/volunteering/{id}', name: 'app_volunteering_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showVolunteer(Volunteering $volunteering): Response
    {
        return $this->render('volunteer/show.html.twig', [
            'volunteering' => $volunteering,
        ]);
    }

    #[Route('/volunteer/new', name: 'app_volunteering_new', methods: ['GET', 'POST'])]
    public function newVolunteer(Request $request, EntityManagerInterface $manager): Response
    {
        $volunteering = (new Volunteering())->setForUser($this->getUser());
        $options = [];

        if ($request->query->has('conference')) {
            $conference = $manager->find(Conference::class, $request->query->get('conference'));
            $volunteering->setConference($conference);
            $options['conference'] = $conference;
        }

        $form = $this->createForm(VolunteeringType::class, $volunteering, $options);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($volunteering);
            $manager->flush();

            return $this->redirectToRoute('app_volunteering_show', ['id' => $volunteering->getId()]);
        }

        return $this->render('volunteer/new.html.twig', [
            'form' => $form,
        ]);
    }
}
