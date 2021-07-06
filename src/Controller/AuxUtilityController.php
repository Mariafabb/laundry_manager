<?php

namespace App\Controller;

use App\Entity\Chiusure;
use App\Entity\Conti;
use App\Entity\Gruppi;
use App\Entity\Mastri;
use App\Entity\Registrazioni;
use App\Entity\Sottoconti;
use App\EntityInterface\Fgp\FgpDatabaseInterface;
use App\Repository\ContiRepository;
use App\Repository\RegistrazioniRepository;
use App\Repository\SottocontiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use http\Exception\InvalidArgumentException;
use PhpParser\Builder\Class_;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Class AuxUtilityController
 * @package App\Controller
 * @IsGranted("ROLE_ADMIN")
 */

class AuxUtilityController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;
    /**
     * @var Request
     */
    private $request;

    public function __construct(Security $security, RequestStack $request)
    {
        $this->security = $security;
        $this->request = $request->getCurrentRequest();
    }

    /**
     * @Route("/auxiliary/utility", name="aux_utility", options={"expose"=true})
     */
    public function index(Security $security)
    {

        $entityManager = $this->getDoctrine()->getManager($this->security->getUser()->getEnte());

        if (!empty($_GET['filter'])) {
            $filter = $_GET['filter'] OR NULL;
        }
        $action = $_GET['action'];
        if (empty($action)) {
            return;
        }

        switch ($action) {
            case "searchUtenti":
                /** @var array $t */
                $t = new FgpDatabaseInterface($this->security->getUser()->getEnte());
                $t1 = $t->searchDatiUtente($filter);
                $response = array();

                foreach ($t1 as $row) {
                    // se prestito personale ha valore, quindi metto in descrizione, altrimenti resta vuota
                    $nomeCognome = (!empty($row['nome']) && !empty($row['cognome'])) ? $row['nome']." ".$row['cognome'] : "";

                    $response[] = array(
                        "value" =>trim($row['sottoconto_id']),
                        "label" => $row['finanziamento_id']. " ". $row['pratica_id']. " " .$row['nome']." ".$row['cognome'] . " ".$row['sottoconto_id'] . " " . $row['importo_deliberato'],
                        "descrizione" => $nomeCognome,
                    );
                }
                echo json_encode($response);
                break;

            case "searchGruppi":
                $this->printEntityTOJSON($filter, $entityManager, Gruppi::class);
                break;

            case "searchConti":
                $this->printEntityTOJSON($filter, $entityManager, Conti::class);
                break;

            case "searchMastri":
                $this->printEntityTOJSON($filter, $entityManager, Mastri::class);
                break;

            case "searchConto":
                /** @var array $t */
                $t = new FgpDatabaseInterface($this->security->getUser()->getEnte());
                $t->searchConto($filter, $entityManager->getRepository(Mastri::class)->setEntityManager($entityManager));
                break;

            case "fillPraticheUtenti":
                $t = new FgpDatabaseInterface($this->security->getUser()->getEnte());
                $t->fillSottocontiUtenti();
                break;

            case "getFinanziamentiPratica":
                $t = new FgpDatabaseInterface($this->security->getUser()->getEnte());
                $t1 = $t->getFinanziamentiPratica($this->request->query->get("filter"));
                $response = array();
                foreach ($t1 as $row) {
                    $response[] = array("descrizione" => $row['nome1']." ".$row['cognome1'], "value"=>trim($row['idErogazione']), "label"=> $row['idErogazione']. " ". $row['idPratica']. " " .$row['nome1']." ".$row['cognome1'] . " ".$row['ente'] . " " . $row['importoDeliberato'] . " " . $row['rientro']);
                }
                echo json_encode($response);
                break;

            case "getUltimoNumeroSottoconto":
                $em = $this->getDoctrine()->getManager($this->security->getUser()->getEnte());
                $sottocontiRepository = $em->getRepository(Sottoconti::class)->setEntityManager($em);
                $ultimoNumero = $sottocontiRepository->getUltimoNumeroSottocontoPerMastro($filter);
                $progressivo = intval($ultimoNumero) + 1;
                $progressivo = sprintf( "%03d", $progressivo);
                echo $progressivo;
                break;

            case "aggiornaImportiResiduiGestionale":
                $t = new FgpDatabaseInterface($this->security->getUser()->getEnte());
                $em = $this->getDoctrine()->getManager($this->security->getUser()->getEnte());
                /**
                 * @var RegistrazioniRepository $registrazioniRepository
                 */
                $registrazioniRepository = $em->getRepository(Registrazioni::class)->setEntityManager($em);
                /**
                 * @var SottocontiRepository $sottocontiRepository
                 */
                $sottocontiRepository = $em->getRepository(Sottoconti::class)->setEntityManager($em);
                $sottoconti = $sottocontiRepository->getSottocontiConFinanziamento();
                $data = new \DateTime("tomorrow");
                foreach ($sottoconti as $sottoconto) {
                    $saldo = $registrazioniRepository->getSaldoMovimentiPrecedenti($data, $sottoconto->getSottocontoId());
                    $t->aggiornaImportiResiduiGestionale($sottoconto, $saldo);
                }
                break;

            default:
        }

        return new Response();
        return $this->render('empty.html.twig', [
            'controller_name' => 'AuxUtilityController',
        ]);
    }

    private function printEntityTOJSON(String $filter, EntityManagerInterface $entityManager, String $class){
        $idField = "";
        switch ($class){
            case Mastri::class: $idField = "mastro_id"; break;
            case Conti::class: $idField = "conto_id"; break;
            case Gruppi::class: $idField = "gruppo_id"; break;
        }

        $entities = $entityManager->getRepository($class)->setEntityManager($entityManager)->findByLikeFilter($filter);
        $response = array();
        foreach ($entities as $temp) {
            $descrizione = $temp["descrizione"];
            $value = $temp[$idField];
            $response[] = array("value"=> $value, "label"=> $descrizione);
        }
        echo json_encode($response);
    }

    /**
     * @Route("/auxiliary/chiusure/listTrimestri", name="lista_trimestri", options={"expose"=true})
     */
    public function listTrimestri(){
        $em = $this->getDoctrine()->getManager($this->security->getUser()->getEnte());
        $results = $em->getRepository(Chiusure::class)->getTrimestri();

        return $this->render('operazioni/list.html.twig',[
            "dati" => $results
        ]);
        return new Response();
    }

    /**
     * @Route("/auxiliary/chiusure/setChiusura", name="set_chiusura", options={"expose"=true})
     */
    public function setChiusura(){

        if(!empty($_GET["anno"]) && is_numeric($_GET['anno'])){
            $anno = $_GET["anno"];
        } else {
            echo ("parametro anno non presente o non intero");
            return new Response();;
        }
        if(!empty($_GET["trimestre"]) && is_numeric($_GET["trimestre"])){
            $trimestre = $_GET["trimestre"];
        } else{
            echo ("parametro trimestre non presente o non intero");
            return new Response();
        }

        $em = $this->getDoctrine()->getManager($this->security->getUser()->getEnte());
        $results = $em->getRepository(Chiusure::class)->findBy(["trimestre" => $trimestre, "anno" => $anno]);
        /** @var chiusure $row */
        foreach ($results as $row){
            $row->setChiuso(1);
            $em->persist($row);
        }
        $em->flush();

        echo json_encode(array());
//        header("Location: listTrimestri");

        return new Response();
    }

    /**
     * @Route("/auxiliary/chiusure/populateChiusura", name="populate_chiusura", options={"expose"=true})
     */
    public function populateTableChiusure(){

        $anno = 2020;
        $em = $this->getDoctrine()->getManager($this->security->getUser()->getEnte());

        while ($anno < 2025){
            for($i = 1, $trimestre = 1; $i<=12; $i++){
                $mese = $i;
                if($mese == 4 || $mese == 7 || $mese == 10){
                    $trimestre++;
                }
//                echo "$mese/$anno - trimestre: $trimestre\n<br>";
                $c = new Chiusure();
                $c->setAnno($anno);
                $c->setMese($mese);
                $c->setTrimestre($trimestre);
                $c->setTipo("mese");
                $c->setChiuso(0);
                $em->persist($c);

            }
            $anno++;
        }
        $em->flush();
        return new Response();

    }

}
