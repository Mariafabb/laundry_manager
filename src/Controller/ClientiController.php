<?php

namespace App\Controller;

use App\Entity\Clienti;
use App\Form\NuovoClienteType;
use App\Repository\ClientiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientiController extends AbstractController
{

    private EntityManagerInterface $em;
    private ClientiRepository $clientiRepository;

    /**
     * ClientiController constructor.
     */
    public function __construct(EntityManagerInterface $em, ClientiRepository $clientiRepository)
    {
        $this->em = $em;
        $this->clientiRepository = $clientiRepository;

    }

    /**
     * @Route("/clienti", name="lista_clienti")
     */
    public function listaClienti() : Response {
        $clienti = $this->clientiRepository->findAll();
        return $this->render("Clienti/listaClienti.html.twig", [
            'dati' => $clienti
        ]);
    }

    /**
     * @param Clienti $cliente
     * @return Response
     */
    public function salvaCliente($cliente): Response
    {
        $this->em->persist($cliente);
        $this->em->flush();

        $this->addFlash("success", "Salvataggio effettuato con successo");

        return $this->redirectToRoute("lista_clienti");
    }

    /**
     * @Route("/clienti/nuovo", name="nuovo_cliente")
     */
    public function nuovoCliente(Request $request){

        $cliente = new Clienti();
        $form = $this->createForm(NuovoClienteType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $cliente = $form->getData();
            return $this->salvaCliente($cliente);
        }

        return $this->render("Clienti/nuovoCliente.html.twig", [
            "clienti" => $cliente,
            "form" => $form->createView(),
        ]);

    }

    /**
     * @Route("/clienti/modifica/{slug}", name="modifica_cliente")
     */
    public function modificaCliente($slug, Request $request)
    {

        $cliente = $this->clientiRepository->find($slug);

        $form = $this->createForm(NuovoClienteType::class, $cliente);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cliente = $form->getData();
            return $this->salvaCliente($cliente);
        }

        return $this->render("Clienti/nuovoCliente.html.twig", [
            "clienti" => $cliente,
            "form" => $form->createView()
        ]);
    }

    /**
    * @Route("/clienti/{slug}", name="elimina_cliente")
    */
    public function eliminaCliente($slug, ClientiRepository $cr){
        $cliente = $cr->find($slug);

        $this->em->remove($cliente);
        $this->em->flush();

        $this->addFlash("success","cancellazione eseguita con successo!!!");
        return $this->redirectToRoute("lista_clienti");
        }
}
