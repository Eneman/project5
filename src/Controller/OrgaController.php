<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Trame;
use App\Entity\GNEvent;
use App\Form\TrameType;
use App\Form\GNEventType;
use App\Repository\TrameRepository;
use App\Repository\GNEventRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
                'form' => $form->createView(),
                'new' => false
            ]);
        } elseif ($event->getLocked() == $user->getUsername()) {
            $form->handleRequest($request);

            if ($form->isSubmitted()) {
                $event->setLocked(null);
                $manager->persist($event);
                $manager->flush();
                return $this->redirectToRoute('orga');
            }

            return $this->render('orga/editEvent.html.twig', [
                'event' => $event,
                'form' => $form->createView(),
                'new' => false
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
     * @Route("orga/trame/delete/{id}", name="delete_trame")
     */

    public function deleteTrame(Trame $trame, ObjectManager $manager)
    {
        $id = $trame->getGnevent()->getId();

        $manager->remove($trame);
        $manager->flush();
        
        return $this->redirectToRoute('view_event', ['id' => $id]);
    }

    /**
     * @Route("orga/event/delete/{id}", name="delete_event")
     */

    public function deleteEvent(GNEvent $event, ObjectManager $manager)
    {
        $manager->remove($event);
        $manager->flush();
        
        return $this->redirectToRoute('orga');
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
    
    /**
     * @Route("orga/gen/scenario/{id}", name="generate_scenario")
     */

    public function generateScenario(GNEvent $event)
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('orga/scenario.pdf.html.twig', [
            'event' => $event
        ]);

        $dompdf->loadHtml($html);
        $dompdf->render();

        $dompdf->stream("Scenar.pdf", [
            'Attachment' => true
        ]);
    }
    /**
     * @Route("orga/gen/stb/{id}", name="generate_stb")
     */

    public function generateStb(GNEvent $event)
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('orga/stb.pdf.html.twig', [
            'event' => $event
        ]);

        $dompdf->loadHtml($html);
        $dompdf->render();

        $dompdf->stream("Scenar.pdf", [
            'Attachment' => true
        ]);
    }
    /**
     * @Route("orga/gen/matos/{id}", name="generate_matos")
     */

    public function generateMatos(GNEvent $event)
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('orga/matos.pdf.html.twig', [
            'event' => $event
        ]);

        $dompdf->loadHtml($html);
        $dompdf->render();

        $dompdf->stream("Scenar.pdf", [
            'Attachment' => true
        ]);
    }
}
