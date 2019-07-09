<?php

namespace App\Controller;

use App\Entity\GNEvent;
use App\Form\GNEventType;
use App\Repository\TrameRepository;
use App\Repository\GNEventRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Trame;
use App\Form\TrameType;

class OrgaController extends AbstractController
{

    /**
     * @Route("/orga/event/new", name="new_event")
     */
    public function createEvent(Request $request, ObjectManager $manager)
    {
        $event = new GNEvent();
        $form = $this->createForm(GNEventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($event);
            $manager->flush();
            return $this->redirectToRoute('view_event', ["id" => $event->getId()]);
        }

        return $this->render('orga/editEvent.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
            'new' => true
        ]);
    }
    
    /**
     * @Route("/orga/trame/new/{eventId}", name="new_trame")
     */
    public function createTrame($eventId ,Request $request, ObjectManager $manager, GNEventRepository $repo)
    {
        $trame = new Trame();
        $event = $repo->find($eventId);
        $trame->setGnevent($event);
        $form = $this->createForm(TrameType::class, $trame);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($trame);
            $manager->flush();
            return $this->redirectToRoute('view_event', ["id" => $trame->getGnevent()->getId()]);
        }

        return $this->render('orga/editTrame.html.twig', [
            'trame' => $trame,
            'form' => $form->createView(),
            'new' => true
        ]);
    }

    /**
     * @Route("/orga", name="orga")
     */
    public function index(GNEventRepository $repo)
    {

        $events = $repo->findAll();
        return $this->render('orga/index.html.twig', [
            'events' => $events,
        ]);
    }


    /**
     * @Route("orga/event/{id}/edit", name="edit_event")
     */

    public function editEvent(GNEvent $event = null, Request $request, ObjectManager $manager)
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $form = $this->createForm(GNEventType::class, $event);

        if ($event->getLocked() == null) {
            $event->setLocked($user->getUsername());
            $manager->persist($event);
            $manager->flush();



            return $this->render('orga/editEvent.html.twig', [
                'event' => $event,
                'form' => $form->createView()
            ]);
        } elseif ($event->getLocked() == $user->getUsername()) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $event->setLocked(null);
                $manager->persist($event);
                $manager->flush();
                return $this->redirectToRoute('orga');
            }

            return $this->render('orga/editEvent.html.twig', [
                'event' => $event,
                'form' => $form->createView()
            ]);
        } else {
            return $this->redirectToRoute('orga');
        }
    }

    /**
     * @Route("orga/trame/{id}/edit", name="edit_trame")
     */

    public function editTrame(Request $request, Trame $trame, ObjectManager $manager)
    {


        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $form = $this->createForm(TrameType::class, $trame);

        if ($trame->getLocked() == null) {
            $trame->setLocked($user->getUsername());
            $manager->persist($trame);
            $manager->flush();



            return $this->render('orga/editTrame.html.twig', [
                'trame' => $trame,
                'form' => $form->createView()
            ]);
        } elseif ($trame->getLocked() == $user->getUsername()) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $trame->setLocked(null);
                $manager->persist($trame);
                $manager->flush();
                return $this->redirectToRoute('view_event', ['id' => $trame->getGnevent()->getId()]);
            }

            return $this->render('orga/editTrame.html.twig', [
                'trame' => $trame,
                'form' => $form->createView()
            ]);
        } else {
            return $this->redirectToRoute('orga');
        }
    }

    /**
     * @Route("orga/event/{id}", name="view_event")
     */

    public function viewEvent(GNEvent $event)
    {

        return $this->render('orga/viewEvent.html.twig', [
            'event'  => $event
        ]);
    }

    /**
     * @Route("orga/trame/{id}", name="view_trame")
     */

    public function viewTrame(TrameRepository $trame)
    {

        return $this->render('orga/viewTrame.html.twig', [
            'trame' => $trame
        ]);
    }
}
