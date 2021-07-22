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
    public function setImpostazioni(Request $request)
    {

        $logo = $this->impostazioniRepository->findOneBy(["nome" => "logo"]);
        $metodoCC = $this->impostazioniRepository->findOneBy(["nome" => "metodoCalcoloConsegna"]);
        $giorniLav = $this->impostazioniRepository->findOneBy(["nome" => "numeroGiorniLavorazione"]);

        $form = $this->createForm(ImpostazioniType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $logo->setValore($form["logo"]->getData());
            $metodoCC->setValore($form["metodo_calcolo_consegna"]->getData());
            $giorniLav->setValore($form["numero_giorni_lavorazione"]->getData());

            $this->em->persist($logo);
            $this->em->persist($metodoCC);
            $this->em->persist($giorniLav);
            $this->em->flush();
        } else {
            if (!is_null($logo))
                $form->get('logo')->setData($logo->getValore());
            if (!is_null($metodoCC))
                $form->get('metodo_calcolo_consegna')->setData($metodoCC->getValore());
            if (!is_null($giorniLav))
                $form->get('numero_giorni_lavorazione')->setData($giorniLav->getValore());

            return $this->render("Impostazioni/Impostazioni.html.twig", [
                "dati" => [$logo, $metodoCC, $giorniLav],
                "form" => $form->createView(),
            ]);
        }
    }

    /**
     * @Route("/impostazioni/anagrafica", name="anagrafica_aziendale")
     */
    public function setAnagraficaAziendale(Request $request){

        $ragioneSociale = $this->impostazioniRepository->findOneBy(["nome" => "ragioneSociale"]);
        $indirizzo = $this->impostazioniRepository->findOneBy(["nome" => "indirizzo"]);
        $cap = $this->impostazioniRepository->findOneBy(["nome" => "cap"]);
        $comune = $this->impostazioniRepository->findOneBy(["nome" => "comune"]);
        $provincia = $this->impostazioniRepository->findOneBy(["nome" => "provincia"]);
        $telefono = $this->impostazioniRepository->findOneBy(["nome" => "telefono"]);
        $pIva = $this->impostazioniRepository->findOneBy(["nome" => "p_iva"]);


        $form = $this->createForm(AnagraficaAziendaleType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $ragioneSociale->setValore($form["ragione_sociale"]->getData());
            $indirizzo->setValore($form["indirizzo"]->getData());
            $cap->setValore($form["cap"]->getData());
            $comune->setValore($form["comune"]->getData());
            $provincia->setValore($form["provincia"]->getData());
            $telefono->setValore($form["telefono"]->getData());
            $pIva->setValore($form["p_iva"]->getData());

            $this->em->persist($ragioneSociale);
            $this->em->persist($indirizzo);
            $this->em->persist($cap);
            $this->em->persist($comune);
            $this->em->persist($provincia);
            $this->em->persist($telefono);
            $this->em->persist($pIva);
            $this->em->flush();
        } else {
            if(!is_null($ragioneSociale))
                $form->get('ragione_sociale')->setData($ragioneSociale->getValore());
            if(!is_null($indirizzo))
                $form->get('indirizzo')->setData($indirizzo->getValore());
            if(!is_null($cap))
                $form->get('cap')->setData($cap->getValore());
            if(!is_null($comune))
                $form->get('comune')->setData($comune->getValore());
            if(!is_null($provincia))
                $form->get('provincia')->setData($provincia->getValore());
            if(!is_null($telefono))
                $form->get('telefono')->setData($telefono->getValore());
            if(!is_null($pIva))
                $form->get('p_iva')->setData($pIva->getValore());

        }

        return $this->render("Impostazioni/impostazioniAnagrafica.html.twig", [
            "dati" => [
                $ragioneSociale, $indirizzo, $cap, $comune, $provincia, $telefono, $pIva ],
            "form" => $form->createView(),
        ]);
    }
}
