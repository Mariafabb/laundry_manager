<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\NuovoUtenteType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private EntityManagerInterface $em;
    private UserRepository $userRepository;

    /**
     * UserController constructor.
     */
    public function __construct(EntityManagerInterface $em, UserRepository $userRepository)
    {
        $this->em = $em;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/utenti", name="lista_utenti")
     */
    public function listaUtenti() :Response {
        $utenti = $this->userRepository->findAll();
        return $this->render("Utenti/listaUtenti.html.twig", [
            'dati' => $utenti
        ]);

    }

    /**
     * @param User $utente
     * @return Response
     */
    public function salvaUtente($utente): Response
    {
        $this->em->persist($utente);
        $this->em->flush();

        $this->addFlash("success", "Salvataggio effettuato con successo");

        return $this->redirectToRoute("lista_utenti");
    }

    /**
     * @Route("/utenti/nuovo", name="nuovo_utente")
     */
    public function nuovoUtente(Request $request){
        $utente = new User();

        $form = $this->createForm(NuovoUtenteType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $utente = $form->getData();
            return $this->salvaUtente($utente);
        }

        return $this->render("Utenti/nuovoUtente.html.twig", [
            "utenti" => $utente,
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/utenti/modifica/{slug}", name="modifica_utente")
     */
    public function modificaUtente($slug, Request $request){

        $utente = $this->userRepository->find($slug);

        $form = $this->createForm(NuovoUtenteType::class, $utente);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $utente = $form->getData();
            return $this->salvaUtente($utente);
        }

        return $this->render("Utenti/nuovoUtente.html.twig", [
            "utenti" => $utente,
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/utenti/{slug}", name="elimina_utente")
     */
    public function eliminaUtente($slug, UserRepository $ur){
        $utente = $ur->find($slug);

        $this->em->remove($utente);
        $this->em->flush();

        $this->addFlash("success","cancellazione eseguita con successo!!!");
        return $this->redirectToRoute("lista_utenti");
    }
}
