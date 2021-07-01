<?php

namespace App\Controller;

use App\Entity\Impostazioni;
use App\Form\AnagraficaAziendaleType;
use App\Form\ImpostazioniType;
use App\Repository\ImpostazioniRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImpostazioniController extends AbstractController
{
    private EntityManagerInterface $em;
    private ImpostazioniRepository $impostazioniRepository;

    /**
     * ImpostazioniController constructor.
     */
    public function __construct(EntityManagerInterface $em, ImpostazioniRepository $impostazioniRepository)
    {
        $this->em = $em;
        $this->impostazioniRepository = $impostazioniRepository;
    }

    /**
     * @Route("/impostazioni", name="impostazioni")
     */
    public function setImpostazioni(){

        $impostazioni = $this->impostazioniRepository->findAll();

        $form = $this->createForm(ImpostazioniType::class, $impostazioni);

        if($form->isSubmitted() && $form->isValid()){
            $impostazioni = $form->getData();
            $this->em->persist($impostazioni);
            $this->em->flush();
        }

        return $this->render("Impostazioni/impostazioni.html.twig", [
            "dati" => $impostazioni,
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/impostazioni/anagrafica", name="anagrafica_aziendale")
     */
    public function setAnagraficaAziendale(Request $request){

        $impostazioni = $this->impostazioniRepository->findBy(["tipo" => "anagrafica_aziendale"]);

        $form = $this->createForm(AnagraficaAziendaleType::class, $impostazioni);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $impostazioni = $form->getData();
            $this->em->persist($impostazioni);
            $this->em->flush();
        }

        return $this->render("Impostazioni/impostazioniAnagrafica.html.twig", [
            "dati" => $impostazioni,
            "form" => $form->createView(),
        ]);
    }
}
