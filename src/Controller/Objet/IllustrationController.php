<?php

namespace App\Controller\Objet;

use App\Entity\Objet\Illustration;
use App\Form\Objet\IllustrationType;
use App\Repository\Objet\IllustrationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/objet/illustration")
 */
class IllustrationController extends AbstractController
{
    /**
     * @Route("/", name="objet_illustration_index", methods="GET")
     */
    public function index(IllustrationRepository $illustrationRepository): Response
    {
        return $this->render('objet/illustration/index.html.twig', ['illustrations' => $illustrationRepository->findAll()]);
    }

    /**
     * @Route("/new", name="objet_illustration_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $illustration = new Illustration();
        $form = $this->createForm(IllustrationType::class, $illustration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($illustration);
            $em->flush();

            return $this->redirectToRoute('objet_illustration_index');
        }

        return $this->render('objet/illustration/new.html.twig', [
            'illustration' => $illustration,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="objet_illustration_show", methods="GET")
     */
    public function show(Illustration $illustration): Response
    {
        return $this->render('objet/illustration/show.html.twig', ['illustration' => $illustration]);
    }

    /**
     * @Route("/{id}/edit", name="objet_illustration_edit", methods="GET|POST")
     */
    public function edit(Request $request, Illustration $illustration): Response
    {
        $form = $this->createForm(IllustrationType::class, $illustration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('objet_illustration_index', ['id' => $illustration->getId()]);
        }

        return $this->render('objet/illustration/edit.html.twig', [
            'illustration' => $illustration,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="objet_illustration_delete", methods="DELETE")
     */
    public function delete(Request $request, Illustration $illustration): Response
    {
        if ($this->isCsrfTokenValid('delete'.$illustration->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($illustration);
            $em->flush();
        }

        return $this->redirectToRoute('objet_illustration_index');
    }
}
