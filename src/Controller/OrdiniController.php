<?php

namespace App\Controller;

use App\Entity\Capi;
use App\Entity\Clienti;
use App\Entity\Impostazioni;
use App\Entity\Ordini;
use App\Entity\OrdiniRow;
use App\Form\NuovoOrdineType;
use App\Form\NuovoOrdineRowType;
use App\Repository\CapiRepository;
use App\Repository\ImpostazioniRepository;
use App\Repository\OrdiniRepository;
use App\Repository\OrdiniRowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrdiniController extends AbstractController
{
    private EntityManagerInterface $em;
    private OrdiniRepository $ordiniRepository;
    private OrdiniRowRepository $ordinirowRepository;
    private CapiRepository $capiRepository;
    private int $numeroGiorniLavorazione;
    private ImpostazioniRepository $impostazioniRepository;

    /**
     * OrdiniController constructor.
     */
    public function __construct(EntityManagerInterface $em, OrdiniRepository $ordiniRepository, OrdiniRowRepository $ordinirowRepository, CapiRepository $capiRepository, ImpostazioniRepository $impostazioniRepository)
    {
        $this->em = $em;
        $this->ordiniRepository = $ordiniRepository;
        $this->ordinirowRepository = $ordinirowRepository;
        $this->capiRepository = $capiRepository;

        $impostazioni = $impostazioniRepository->findOneBy(["nome" => 'metodoCalcoloGiorniLavorazione']);
        switch ($impostazioni->getValore()){
            case "statico": $this->numeroGiorniLavorazione = intval($impostazioniRepository->findOneBy(["nome" => 'numeroGiorniLavorazione'])->getValore()); break;
        }

    $this->impostazioniRepository = $impostazioniRepository;}

    /**
     * @Route("/ordini", name="lista_ordini")
     */
    public function listaOrdini(): Response
    {
        $ordini = $this->ordiniRepository->findAll();
        return $this->render("Ordini/listaOrdini.html.twig", [
            'dati' => $ordini
        ]);
    }

    /**
     * @Route("/ordini/ordinirow", name="ordini_row")
     */
    public function listaOrdiniRow(): Response
    {
        $ordiniRow = $this->ordinirowRepository->findAll();
        return $this->render("Ordini/listaOrdiniRow.html.twig", [
            'dati' => $ordiniRow
        ]);
    }

    /**
     * @param ordini $ordine
     * @return Response
     */
    public function salvaOrdine($ordine): Response
    {
        $this->em->persist($ordine);
        $this->em->flush();

        $this->stampaOrdine($ordine);

        $this->addFlash("success", "Salvataggio effettuato con successo");

        return $this->redirectToRoute("lista_ordini");
    }

    /**
     * @param ordini $ordinerow
     * @return Response
     */
    public function salvaOrdineRow($ordineRow): Response
    {
        $this->em->persist($ordineRow);
        $this->em->flush();

        $this->addFlash("success", "Salvataggio effettuato con successo");

        return $this->redirectToRoute("lista_ordiniRow");
    }

    /**
     * @Route("/ordini/nuovo", name="nuovo_ordine")
     */
    public function nuovoOrdine(Request $request){
        $ordine = new Ordini();

        $form = $this->createForm(NuovoOrdineType::class);
        $curDateTime = new \DateTime();

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $ordine = $form->getData();
            $ordiniRow = $_POST["form_ordini_row"];
            foreach ($ordiniRow as $capoId){
                $capo = $this->capiRepository->findOneBy(["id" => $capoId]);
                $ordiniRow = new OrdiniRow();
                $ordiniRow->setCapo($capo)
                    ->setimporto($capo->getPrezzo() * $capoId["numeroCapi"])
                     ->setDataConsegna($curDateTime->add(new \DateInterval(('P7D'))));
                    $ordine->addOrdiniRow($ordiniRow);
            }
            return $this->salvaOrdine($ordine);
        }

        return $this->render("Ordini/nuovoOrdine.html.twig", [
            "ordini" => $ordine,
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/ordini/ordinirow/nuovo", name="nuovo_ordinerow")
     */
    public function nuovoOrdineRow(Request $request){

        $ordineRow = new OrdiniRow();
        $form = $this->createForm(NuovoOrdineRowType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $ordineRow = $form->getData();

        return $this->salvaOrdineRow($ordineRow);
        }

        return $this->render("Ordini/nuovoOrdineRow.html.twig", [
            "ordiniRow" => $ordineRow,
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/ordini/modifica/{slug}", name="modifica_ordine")
     */
    public function modificaOrdine($slug, Request $request)
    {

        $ordine = $this->ordiniRepository->find($slug);

        $form = $this->createForm(NuovoOrdineType::class, $ordine);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ordine = $form->getData();
            return $this->salvaOrdine($ordine);
        }

        return $this->render("Ordini/nuovoOrdine.html.twig", [
            "ordini" => $ordine,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/ordini/ordiniRow/modifica/{slug}", name="modifica_ordineRow")
     */
    public function modificaOrdineRow($slug, Request $request)
    {

        $ordineRow = $this->ordinirowRepository->find($slug);

        $form = $this->createForm(NuovoOrdineRowType::class, $ordineRow);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ordineRow = $form->getData();
            return $this->salvaOrdineRow($ordineRow);
        }

        return $this->render("Ordini/nuovoOrdineRow.html.twig", [
            "ordiniRow" => $ordineRow,
            "form" => $form->createView()
        ]);
    }

        /**
         * @Route("/ordini/elimina/{slug}", name="elimina_ordine")
         */
        public function eliminaOrdine($slug, OrdiniRepository $or){
            $ordine = $or->find($slug);

            $this->em->remove($ordine);
            $this->em->flush();

            $this->addFlash("success","cancellazione eseguita con successo!!!");
            return $this->redirectToRoute("lista_ordini");
        }

        /**
         * @Route("/ordini/ordiniRow/elimina/{slug}", name="elimina_ordineRow")
         */
        public function eliminaOrdineRow($slug, OrdiniRowRepository $or){
            $ordineRow = $or->find($slug);

            $this->em->remove($ordineRow);
            $this->em->flush();

            $this->addFlash("success","cancellazione eseguita con successo!!!");
            return $this->redirectToRoute("lista_ordiniRow");
        }

        public function stampaOrdine(Ordini $ordine){
            $connector = new FilePrintConnector("scontrini");
            //$connector = new WindowsPrintConnector("Receipt Printer");

            $printer = new Printer($connector);

            //TODO: implementare testo e provare

            $text = "";

            $printer -> text($text);
            $printer -> cut();
            $printer -> close();

        }

}