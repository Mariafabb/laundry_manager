<?php

namespace App\Entity;

use App\Repository\OrdiniRowRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrdiniRowRepository::class)
 */
class OrdiniRow
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Capi::class, inversedBy="ordiniCapo")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $capo;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private $importo;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dataConsegna;

    /**
     * @ORM\ManyToOne(targetEntity=Ordini::class, inversedBy="ordiniRows")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $ordine;

    /**
     * @ORM\Column(type="integer")
     */
    private $numeroCapi;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCapo(): ?capi
    {
        return $this->capo;
    }

    public function setCapo(?capi $capo): self
    {
        $this->capo = $capo;

        return $this;
    }

    public function getImporto(): ?float
    {
        return $this->importo;
    }

    public function setimporto(float $importo): self
    {
        $this->importo = $importo;

        return $this;
    }

    public function getOrdine(): ?Ordini
    {
        return $this->ordine;
    }

    public function setOrdine(?Ordini $ordine): self
    {
        $this->ordine = $ordine;

        return $this;
    }

    public function getDataConsegna(): ?\DateTimeInterface
    {
        return $this->dataConsegna;
    }

    public function setDataConsegna(?\DateTimeInterface $dataConsegna): self
    {
        $this->dataConsegna = $dataConsegna;

        return $this;
    }

    public function getNumeroCapi(): ?int
    {
        return $this->numeroCapi;
    }

    public function setNumeroCapi(int $numeroCapi): self
    {
        $this->numeroCapi = $numeroCapi;

        return $this;
    }
}
