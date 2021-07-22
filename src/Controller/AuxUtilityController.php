<?php

namespace App\Controller;

use App\Entity\Capi;
use App\Entity\Clienti;
use App\Entity\Ordini;
use Doctrine\Common\Annotations\Annotation\Required;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
    private EntityManagerInterface $em;

    public function __construct(Security $security, RequestStack $request, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->request = $request->getCurrentRequest();
        $this->em = $em;
    }

    /**
     * @Route("/auxiliary/utility", name="aux_utility", options={"expose"=true})
     */
    public function index(Security $security)
    {

        if (!empty($_GET['filter'])) {
            $filter = $_GET['filter'] OR NULL;
        }
        $action = $_GET['action'];
        if (empty($action)) {
            return;
        }

        switch ($action) {
            case "searchCapi":
                $this->printEntityTOJSON($filter, Capi::class, "tipo"); break;
            case "searchListaCapi":
                $this->printEntityTOJSON($filter, Capi::class); break;
            case "searchClienti":
                $this->printEntityTOJSON($filter, Clienti::class, "nome_cognome"); break;
            case "searchListaClienti":
                $this->printEntityTOJSON($filter, Clienti::class); break;
            case "searchListaOrdini":
                $this->printEntityTOJSON($filter, Ordini::class); break;


            default:
        }

        return new Response();
        return $this->render('empty.html.twig', [
            'controller_name' => 'AuxUtilityController',
        ]);
    }

    private function printEntityTOJSON(String $filter, String $class, String $nomeCampoDescrittivo = null){
        $idField = "";
        switch ($class){
            default: $idField = "id";
        }

        $entities = $this->em->getRepository($class)->findByLikeFilter($filter);
        $response = array();
        if($nomeCampoDescrittivo != null) {
            foreach ($entities as $temp) {
                $descrizione = $temp[$nomeCampoDescrittivo];
                $value = $temp[$idField];
                $responseTemp = array("value" => $value, "label" => $descrizione);
                if($nomeCampoDescrittivo == "tipo") {
                    $responseTemp["prezzo"] = $temp["prezzo"];
                }

                $response[] = $responseTemp;
            }
        } else {
            $response = $entities;
        }
        echo json_encode($response);
    }


}
