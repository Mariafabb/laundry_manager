<?php

namespace App\Tests;

use App\Controller\OrdiniController;
use App\Entity\Capi;
use App\Entity\Clienti;
use App\Entity\Ordini;
use App\Entity\OrdiniRow;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class StampaTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $kernel = self::bootKernel();
        $container = self::$kernel->getContainer();
        $ordiniController = $container->get(OrdiniController::class);

        $ordine = new Ordini();
        $cliente = new Clienti();
        $ordineRow = new OrdiniRow();
        $capo = new Capi();

        $cliente->setCognome("Rossi");

        $capo->setTipo("gonna");

        $ordine->setCliente($cliente);
        $ordine->setTotale(100);
        $ordine->setDataOrdine(new \Datetime());
        $ordine->setDataConsegna(new \Datetime());

        $ordineRow->setCapo($capo);
        $ordineRow->setOrdine($ordine);
        $ordineRow->setNumeroCapi(50);
        $ordineRow->setimporto(100);

        $ordiniController->stampaOrdine($ordine);

        $this->assertSame('test', $kernel->getEnvironment());
        //$routerService = self::$container->get('router');
        //$myCustomService = self::$container->get(CustomService::class);
    }
}
