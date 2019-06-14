<?php

namespace App\Controller\Site;

use App\Entity\Site\Event;
use App\Form\Site\EventType;
use App\Repository\Site\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/event")
 */
class EventController extends AbstractController {
	/**
	 * @Route("/", name="site_event_index", methods="GET")
	 */
	public function index(EventRepository $eventRepository): Response {
		return $this->render('site/event/index.html.twig', [
			'events' => $eventRepository->findAll(),
			'pageStyle' => 'left-sidebar',
		]);
	}

	/**
	 * @Route("/new", name="site_event_new", methods="GET|POST")
	 */
	public function new (Request $request): Response{
		$event = new Event();
		$form = $this->createForm(EventType::class, $event);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($event);
			$em->flush();

			return $this->redirectToRoute('site_event_index');
		}

		return $this->render('site/event/new.html.twig', [
			'event' => $event,
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/{id}", name="site_event_show", methods="GET")
	 */
	public function show(Event $event): Response {
		return $this->render('site/event/show.html.twig', [
			'event' => $event,
			'pageStyle' => 'no-sidebar',
		]);
	}

	/**
	 * @Route("/bloc", name="site_event_bloc", methods="GET")
	 */
	public function bloc(EventRepository $eventRepository): Response {
		return $this->render('site/event/index.html.twig', [
			'events' => $eventRepository->findAll(),
			'pageStyle' => 'left-sidebar',
		]);
	}

	/**
	 * @Route("/{id}/edit", name="site_event_edit", methods="GET|POST")
	 */
	public function edit(Request $request, Event $event): Response{
		$form = $this->createForm(EventType::class, $event);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('site_event_index', ['id' => $event->getId()]);
		}

		return $this->render('site/event/edit.html.twig', [
			'event' => $event,
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/{id}", name="site_event_delete", methods="DELETE")
	 */
	public function delete(Request $request, Event $event): Response {
		if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->request->get('_token'))) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($event);
			$em->flush();
		}

		return $this->redirectToRoute('site_event_index');
	}
}
