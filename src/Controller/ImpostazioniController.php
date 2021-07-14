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

        $ragioneSociale = $this->impostazioniRepository->findOneBy(["nome" => "ragioneSociale"]);
        $indirizzo = $this->impostazioniRepository->findOneBy(["nome" => "indirizzo"]);

        $form = $this->createForm(AnagraficaAziendaleType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $ragioneSociale->setValore($form["ragione_sociale"]->getData());
            $indirizzo->setValore($form["indirizzo"]->getData());

            $this->em->persist($ragioneSociale);
            $this->em->persist($indirizzo);
            $this->em->flush();
        } else {
            if(!is_null($ragioneSociale))
                $form->get('ragione_sociale')->setData($ragioneSociale->getValore());
            if(!is_null($indirizzo))
                $form->get('indirizzo')->setData($indirizzo->getValore());
        }

        return $this->render("Impostazioni/impostazioniAnagrafica.html.twig", [
            "dati" => [
                $ragioneSociale, $indirizzo],
            "form" => $form->createView(),
        ]);
    }
}
