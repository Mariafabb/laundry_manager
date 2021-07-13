<?php

namespace App\Controller;

use App\Entity\Capi;
use App\Form\NuovoCapoType;
use App\Repository\CapiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CapiController extends AbstractController
{
    private EntityManagerInterface $em;
    private CapiRepository $capiRepository;

    /**
     * CapiController constructor.
     */
    public function __construct(EntityManagerInterface $em, CapiRepository $capiRepository)
    {
        $this->em = $em;
        $this->capiRepository = $capiRepository;
    }

    /**
     * @Route("/capi", name="lista_capi")
     */
    public function listaCapi() :Response {
        $capi = $this->capiRepository->findAllWithLimit();
        return $this->render("Capi/listaCapi.html.twig", [
            'dati' => $capi
        ]);
    }

    /**
     * @param Capi $capo
     * @return Response
     */
    public function salvaCapo($capo): Response
    {
        $this->em->persist($capo);
        $this->em->flush();

        $this->addFlash("success", "Salvataggio effettuato con successo");

        return $this->redirectToRoute("lista_capi");
    }

    /**
     * @Route("/capi/nuovo", name="nuovo_capo")
     */
    public function nuovoCapo(Request $request){

        $capo = new Capi();
        $form = $this->createForm(NuovoCapoType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $capo = $form->getData();
            return $this->salvaCapo($capo);
        }

        return $this->render("Capi/nuovoCapo.html.twig", [
            "capi" => $capo,
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/capi/modifica/{slug}", name="modifica_capo")
     */
    public function modificaCapo($slug, Request $request){

        $capo = $this->capiRepository->find($slug);

        $form = $this->createForm(NuovoCapoType::class, $capo);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $capo = $form->getData();
            return $this->salvaCapo($capo);

        }

        return $this->render("Capi/nuovoCapo.html.twig", [
            "capi" => $capo,
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/capi/{slug}", name="elimina_capo")
     */
    public function eliminaCapo($slug, CapiRepository $cr){
        $capo = $cr->find($slug);

        $this->em->remove($capo);
        $this->em->flush();

        $this->addFlash("success","cancellazione eseguita con successo!!!");
        return $this->redirectToRoute("lista_capi");
    }
}

