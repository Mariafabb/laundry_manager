<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class HomepageController
 * @package App\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="base")
     */
    public function index(): Response{
        return $this->redirectToRoute("homepage");
    }

    /**
     * @Route("/homepage", name="homepage")
     */
    public function homepage(): Response
    {
        return $this->render('Homepage/homepage.html.twig');
    }
}
