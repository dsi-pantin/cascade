<?php

namespace App\Controller\Site;

use App\Entity\Site\Cascade;
use App\Form\Site\CascadeType;
use App\Repository\Site\CascadeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/site/cascade")
 */
class CascadeController extends AbstractController
{
    /**
     * @Route("/", name="site_cascade_index", methods="GET")
     */
    public function index(CascadeRepository $cascadeRepository): Response
    {
        return $this->render('site/cascade/index.html.twig', ['cascades' => $cascadeRepository->findAll()]);
    }

    /**
     * @Route("/new", name="site_cascade_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $cascade = new Cascade();
        $form = $this->createForm(CascadeType::class, $cascade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cascade);
            $em->flush();

            return $this->redirectToRoute('site_cascade_index');
        }

        return $this->render('site/cascade/new.html.twig', [
            'cascade' => $cascade,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="site_cascade_show", methods="GET")
     */
    public function show(Cascade $cascade): Response
    {
        return $this->render('site/cascade/show.html.twig', ['cascade' => $cascade]);
    }

    /**
     * @Route("/{id}/edit", name="site_cascade_edit", methods="GET|POST")
     */
    public function edit(Request $request, Cascade $cascade): Response
    {
        $form = $this->createForm(CascadeType::class, $cascade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('site_cascade_index', ['id' => $cascade->getId()]);
        }

        return $this->render('site/cascade/edit.html.twig', [
            'cascade' => $cascade,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="site_cascade_delete", methods="DELETE")
     */
    public function delete(Request $request, Cascade $cascade): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cascade->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cascade);
            $em->flush();
        }

        return $this->redirectToRoute('site_cascade_index');
    }
}
