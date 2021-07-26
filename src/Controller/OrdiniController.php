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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class OrdiniController
 * @package App\Controller
 * @IsGranted("ROLE_ADMIN")
 */
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
    private \DateTime $curDateTime;
    private \DateTime $dataConsegna;

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
        $this->curDateTime = new \DateTime();

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
        $giornoSettimana = $ordine->getDataConsegna()->format("l");
        switch ($giornoSettimana){
            case "Saturday": $ordine->setDataConsegna($ordine->getDataConsegna()->add(new \DateInterval(('P2D')))); break;
            case "Sunday": $ordine->setDataConsegna($ordine->getDataConsegna()->add(new \DateInterval(('P1D')))); break;
            default:
        }

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
        $this->dataConsegna = !$this->lavorazioneDinamica ?
            $this->curDateTime->add(new \DateInterval(('P'.$this->numeroGiorniLavorazione.'D'))) : null;

        $form->handleRequest($request);
        if($form->isSubmitted()){
            /** @var Ordini $ordine */
            $ordine = $form->getData();
            $ordine->setUser($this->security->getUser());
            $ordine->setCliente($this->clientiRepository->findOneBy(["id" => $form["cliente_id"]->getData()]));
            $ordine->setDataOrdine(new \DateTime());
            $listaCapi = $_POST["form_ordini_row"];
            $totale = $this->salvaOrdiniRowInOrdine($listaCapi, $ordine);
            $ordine->setDataConsegna($this->dataConsegna);
            $ordine->setTotale($totale);
            return $this->salvaOrdine($ordine);
        }

        return $this->render("Ordini/nuovoOrdine.html.twig", [
            "ordini" => $ordine,
            "form" => $form->createView(),
        ]);
    }

    /**
     * @param Capi[] $listaCapi
     * @param Ordini $ordine
     * @throws \Exception
     */
    public function salvaOrdiniRowInOrdine($listaCapi, &$ordine){
        $totale = 0;
        foreach ($listaCapi as $capoId){
            $capo = $this->capiRepository->findOneBy(["id" => $capoId]);
            $ordiniRow = new OrdiniRow();
            $ordiniRow->setNumeroCapi($capoId["numeroCapi"]);
            $importoRiga = $capo->getPrezzo() * $capoId["numeroCapi"];
            $totale += $importoRiga;

            if(is_null($this->numeroGiorniLavorazione) && $this->lavorazioneDinamica){
                $this->numeroGiorniLavorazione = $capo->getGiorniLavorazione();
                $this->dataConsegna = $this->curDateTime->add(new \DateInterval(('P'.$this->numeroGiorniLavorazione.'D')));
            } else if($this->lavorazioneDinamica && $this->numeroGiorniLavorazione < $capo->getGiorniLavorazione()) {
                $this->numeroGiorniLavorazione = $capo->getGiorniLavorazione();
                $this->dataConsegna = $this->curDateTime->add(new \DateInterval(('P'.$this->numeroGiorniLavorazione.'D')));
            }

            $ordiniRow->setCapo($capo)
                ->setimporto($importoRiga)
                ->setDataConsegna($this->dataConsegna);
            $ordine->addOrdiniRow($ordiniRow);
        }
        return $totale;
    }

    /**
     * @Route("/ordini/modifica/{slug}", name="modifica_ordine", options={"expose"=true})
     */
    public function modificaOrdine($slug, Request $request)
    {

        $ordine = $this->ordiniRepository->find($slug);
        $ordiniRows = $ordine->getOrdiniRows();
        $form = $this->createForm(NuovoOrdineType::class, $ordine, ['edit' => true]);
        $this->dataConsegna = $ordine->getDataConsegna();

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            /** @var Ordini $ordineEdited */
            $ordineEdited = $form->getData();
            $ordineEdited->setCliente($ordine->getCliente());
            $ordiniRowForDeletion = $ordine->getOrdiniRows();
            /** @var OrdiniRow $temp */
            foreach ($ordiniRowForDeletion as $temp){
                $this->em->remove($temp);
            }
            $this->em->flush();
            $this->salvaOrdiniRowInOrdine($_POST["form_ordini_row"], $ordineEdited);
            return $this->salvaOrdine($ordineEdited);
        }

        return $this->render("Ordini/nuovoOrdine.html.twig", [
            "ordine" => $ordine,
            "ordiniRows" => $ordiniRows,
            "form" => $form->createView()
        ]);
    }

        /**
         * @Route("/ordini/elimina/{slug}", name="elimina_ordine", options={"expose"=true})
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
            $connector = new WindowsPrintConnector("smb://scontrini:scontrini@10.8.0.2/scontrini");

            $printer = new Printer($connector);

            //check data in weekend

        /**
         * @var Impostazioni $anagraficaAzienda
         */
            $anagraficaAzienda = $this->impostazioniRepository->findBy(["tipo" => "anagraficaAziendale"]);
            $cliente = $ordine->getCliente();

            $text = " Lavanderia Lavostiro di Arcangeloni\nPiazza Solari 1 R 16143 Genova. PI 02367870991\n\n";
//            foreach ($anagraficaAzienda as $item) {
//                $text .= $item->getValore() ."\n";
//            }
            $text.= "Spettabile: " .$cliente->getCognome()." ".$cliente->getNome()."\n";
            $text.= "Ordine numero" .$ordine->getId() ." del ".$ordine->getDataOrdine()->format("d-m-Y")."\n";
            $text.= "Descrizione       Q.ta    Euro\n";

            $dataRiconsegnaText = $ordine->getDataConsegna()->format("d-m-Y");

            $bigliettiCapi = array();
            $i = 0;
            foreach ($ordine->getOrdiniRows() as $ordineRow){
                $text.= $ordineRow->getCapo()->getTipo() ."             ";
                $text.= $ordineRow->getNumeroCapi() ."       ";
                $text.= $ordineRow->getImporto() ."\n";
                $bigliettiCapi[i] = "\n".$ordineRow->getCapo()->getTipo(). " -- ". $cliente->getCognome(). " ".$cliente->getNome() ." -- $dataRiconsegnaText\n";
                ++$i;
            }
            $text.= "\n\n";
            $text.= "Totale                      " .$ordine->getTotale() ."€, PAGATO\n";
            $text.= "Riconsegna: $dataRiconsegnaText";
            $text.="\n \n";

            $printer -> text($text);
            $printer -> cut();
            $printer -> text($text);
            $printer -> cut();

            foreach ($bigliettiCapi as $text){
                $printer->text($text);
                $printer->cut();
            }

            $printer -> close();
        }

}