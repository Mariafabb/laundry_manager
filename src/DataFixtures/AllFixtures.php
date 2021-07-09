<?php

namespace App\DataFixtures;

use App\Entity\Capi;
use App\Entity\Clienti;
use App\Entity\Ordini;
use App\Entity\OrdiniRow;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AllFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    /**
     * AllFixtures constructor.
     */
    public function __construct(UserPasswordHasherInterface $hasher)
    {

        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {

        for($i = 0 ; $i < 11; ++$i){
            $cliente = new Clienti();
            $cliente->setNome("nome$i");
            $cliente->setCognome("cognome$i");
            $cliente->setIndirizzo("viaCavolicchi$i");
            $cliente->setCap("1614$i");
            $cliente->setComune("Genova");
            $cliente->setProvincia("GE");
            $cliente->setStato("Italia");
            $cliente->setTelefono("01012345$i");
            $cliente->setCellulare("329108354$i");
            $cliente->setEmail("pincopallo$i@gmail.com");
            $cliente->setCodiceFiscale("RSSMRA85T10A56S$i");
            $cliente->setPIva("BGTJLPK$i");
            $cliente->setCodiceUnivoco("BNJG&UHJ$i");
            $cliente->setPec("mariorossi$i@aruba.pec.it");




            $utente = new User();
            $utente->setUsername("username$i");
            $utente->setPassword($this->hasher->hashPassword($utente, "password"));

            for($n=0; $n<11; ++$n){
            $capo = new Capi();
            $capo->setTipo("tipo$n");
            $capo->setPrezzo($n);
            }

                    for($j = 0; $j < 2; ++$j){
                        $ordine = new Ordini();
                        $ordine->setCliente($cliente);
                        $ordine->setTotale(100);
                        $ordine->setDataOrdine(new \Datetime('2021-01-01'));
                        $ordine->setUser($utente);
                        $manager->persist($ordine);
                    }

                        for($p = 0; $p < 2; ++$p){
                        $ordineRow = new OrdiniRow();
                        $ordineRow->setCapo($capo);
                        $ordineRow->setOrdine($ordine);
                        $ordineRow->setimporto(100);
                        $ordineRow->setNumeroCapi(rand(1,7));
                        $manager->persist($ordineRow);
                        }


            $manager->persist($cliente);
            $manager->persist($utente);
            $manager->persist($capo);
        };

        $manager->flush();
    }
}
