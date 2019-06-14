<?php

namespace App\Controller\Objet;

use App\Entity\Objet\Notification;
use App\Form\Objet\NotificationType;
use App\Repository\Objet\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/objet/notification")
 */
class NotificationController extends AbstractController
{
    /**
     * @Route("/", name="objet_notification_index", methods="GET")
     */
    public function index(NotificationRepository $notificationRepository): Response
    {
        return $this->render('objet/notification/index.html.twig', ['notifications' => $notificationRepository->findAll()]);
    }

    /**
     * @Route("/new", name="objet_notification_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $notification = new Notification();
        $form = $this->createForm(NotificationType::class, $notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($notification);
            $em->flush();

            return $this->redirectToRoute('objet_notification_index');
        }

        return $this->render('objet/notification/new.html.twig', [
            'notification' => $notification,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="objet_notification_show", methods="GET")
     */
    public function show(Notification $notification): Response
    {
        return $this->render('objet/notification/show.html.twig', ['notification' => $notification]);
    }

    /**
     * @Route("/{id}/edit", name="objet_notification_edit", methods="GET|POST")
     */
    public function edit(Request $request, Notification $notification): Response
    {
        $form = $this->createForm(NotificationType::class, $notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('objet_notification_index', ['id' => $notification->getId()]);
        }

        return $this->render('objet/notification/edit.html.twig', [
            'notification' => $notification,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="objet_notification_delete", methods="DELETE")
     */
    public function delete(Request $request, Notification $notification): Response
    {
        if ($this->isCsrfTokenValid('delete'.$notification->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($notification);
            $em->flush();
        }

        return $this->redirectToRoute('objet_notification_index');
    }
}
