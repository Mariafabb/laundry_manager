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
use App\Repository\ClientiRepository;
use App\Repository\ImpostazioniRepository;
use App\Repository\OrdiniRepository;
use App\Repository\OrdiniRowRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class OrdiniController extends AbstractController
{
    private EntityManagerInterface $em;
    private OrdiniRepository $ordiniRepository;
    private OrdiniRowRepository $ordinirowRepository;
    private CapiRepository $capiRepository;
    private int $numeroGiorniLavorazione;
    private ImpostazioniRepository $impostazioniRepository;
    private ClientiRepository $clientiRepository;
    private Security $security;
    private bool $lavorazioneDinamica;

    /**
     * OrdiniController constructor.
     */
    public function __construct(Security $security, EntityManagerInterface $em, OrdiniRepository $ordiniRepository, OrdiniRowRepository $ordinirowRepository, CapiRepository $capiRepository, ImpostazioniRepository $impostazioniRepository, ClientiRepository $clientiRepository)
    {
        $this->em = $em;
        $this->ordiniRepository = $ordiniRepository;
        $this->ordinirowRepository = $ordinirowRepository;
        $this->capiRepository = $capiRepository;
        $this->lavorazioneDinamica = false;

        $impostazioni = $impostazioniRepository->findOneBy(["nome" => 'metodoCalcoloConsegna']);
        switch ($impostazioni->getValore()){
            case "statico": $this->numeroGiorniLavorazione = intval($impostazioniRepository->findOneBy(["nome" => 'numeroGiorniLavorazione'])->getValore()); break;
        }

    $this->impostazioniRepository = $impostazioniRepository;
        $this->clientiRepository = $clientiRepository;
        $this->security = $security;
    }

    /**
     * @Route("/ordini", name="lista_ordini")
     */
    public function listaOrdini(): Response
    {
        $ordini = $this->ordiniRepository->findBy(['data_ordine' => new \DateTime()]);
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
     * @Route("/ordini/nuovo", name="nuovo_ordine")
     */
    public function nuovoOrdine(Request $request, UserRepository $userRepository){
        $ordine = new Ordini();

        $form = $this->createForm(NuovoOrdineType::class);
        $curDateTime = new \DateTime();
        $dataConsegna = !$this->lavorazioneDinamica ?
            $curDateTime->add(new \DateInterval(('P'.$this->numeroGiorniLavorazione.'D'))) : null;

        $form->handleRequest($request);
        if($form->isSubmitted()){
            /** @var Ordini $ordine */
            $ordine = $form->getData();
            $ordine->setUser($this->security->getUser());
            //$ordine->setUser($userRepository->find(1));
            $ordine->setCliente($this->clientiRepository->findOneBy(["id" => $form["cliente_id"]->getData()]));
            $ordine->setDataOrdine(new \DateTime());
            $listaCapi = $_POST["form_ordini_row"];
            $totale = 0;
            foreach ($listaCapi as $capoId){
                $capo = $this->capiRepository->findOneBy(["id" => $capoId]);
                $ordiniRow = new OrdiniRow();
                $ordiniRow->setNumeroCapi($capoId["numeroCapi"]);
                $importoRiga = $capo->getPrezzo() * $capoId["numeroCapi"];
                $totale += $importoRiga;

                if(is_null($this->numeroGiorniLavorazione) && $this->lavorazioneDinamica){
                    $this->numeroGiorniLavorazione = $capo->getGiorniLavorazione();
                    $dataConsegna = $curDateTime->add(new \DateInterval(('P'.$this->numeroGiorniLavorazione.'D')));
                } else if($this->lavorazioneDinamica && $this->numeroGiorniLavorazione < $capo->getGiorniLavorazione()) {
                    $this->numeroGiorniLavorazione = $capo->getGiorniLavorazione();
                    $dataConsegna = $curDateTime->add(new \DateInterval(('P'.$this->numeroGiorniLavorazione.'D')));
                }

                $ordiniRow->setCapo($capo)
                    ->setimporto($importoRiga)
                     ->setDataConsegna($dataConsegna);
                    $ordine->addOrdiniRow($ordiniRow);
            }
            $ordine->setDataConsegna($dataConsegna);
            $ordine->setTotale($totale);
            return $this->salvaOrdine($ordine);
        }

        return $this->render("Ordini/nuovoOrdine.html.twig", [
            "ordini" => $ordine,
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/ordini/modifica/{slug}", name="modifica_ordine", options={"expose"=true})
     */
    public function modificaOrdine($slug, Request $request)
    {

        $ordine = $this->ordiniRepository->find($slug);
        $ordiniRows = $ordine->getOrdiniRows();
        $form = $this->createForm(NuovoOrdineType::class, $ordine);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ordine = $form->getData();
            return $this->salvaOrdine($ordine);
        }

        return $this->render("Ordini/nuovoOrdine.html.twig", [
            "ordine" => $ordine,
            "ordiniRows" => $ordiniRows,
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
            //$connector = new FilePrintConnector("scontrini");
            $connector = new WindowsPrintConnector("localhost/scontrini");

            $printer = new Printer($connector);

            //TODO: implementare testo e provare

        /**
         * @var Impostazioni $anagraficaAzienda
         */
            $anagraficaAzienda = $this->impostazioniRepository->findBy(["tipo" => "anagraficaAziendale"]);
            $cliente = $ordine->getCliente();

            $text = "";
            foreach ($anagraficaAzienda as $item) {
                $text .= $item->getValore() ."\n";
            }
            $text.= "\nSpettabile: " .$cliente->getCognome()."\n";
            $text.= "Ordine numero" .$ordine->getId() ." del ".$ordine->getDataOrdine()->format("d-m-Y H:i")."\n";
            $text.= "Descrizione       Q.ta    Euro\n";
            foreach ($ordine->getOrdiniRows() as $ordineRow){
                $text.= $ordineRow->getCapo()->getTipo() ."                    ";
                $text.= $ordineRow->getNumeroCapi() ."   ";
                $text.= $ordineRow->getImporto() ."\n";
            }
            $text.= "\n\n";
            $text.= "Totale                      " .$ordine->getTotale() ."\nPAGATO\n";
            $text.= "Riconsegna: " .$ordine->getDataConsegna()->format("d-m-Y");
            $text.="\n \n \n \n";

            $printer -> text($text);
            $printer -> cut();
            $printer -> text($text);
            $printer -> cut();
            $printer -> close();

        }

}