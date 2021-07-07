<?php

namespace App\Controller;

use App\Entity\Capi;
use App\EntityInterface\Fgp\FgpDatabaseInterface;
use App\Repository\ContiRepository;
use App\Repository\RegistrazioniRepository;
use App\Repository\SottocontiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class AuxUtilityController
 * @package App\Controller
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
                $this->printEntityTOJSON($filter, Capi::class, "tipo");
                break;

            default:
        }

        return new Response();
        return $this->render('empty.html.twig', [
            'controller_name' => 'AuxUtilityController',
        ]);
    }

    private function printEntityTOJSON(String $filter, String $class, String $nomeCampoDescrittivo){
        $idField = "";
        switch ($class){
            default: $idField = "id";
        }

        $entities = $this->em->getRepository($class)->findByLikeFilter($filter);
        $response = array();
        foreach ($entities as $temp) {
            $descrizione = $temp[$nomeCampoDescrittivo];
            $value = $temp[$idField];
            $response[] = array("value"=> $value, "label"=> $descrizione);
        }
        echo json_encode($response);
    }


}
