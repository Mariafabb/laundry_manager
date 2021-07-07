<?php

namespace App\Entity;

use App\Repository\CapiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CapiRepository::class)
 */
class Capi
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tipo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sottotipo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descrizione;

    /**
     * @ORM\Column(type="float")
     */
    private $prezzo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $giorni_lavorazione;

    /**
     * @ORM\OneToMany(targetEntity=OrdiniRow::class, mappedBy="capo")
     */
    private $ordiniRowCapo;

    public function __construct()
    {
        $this->ordiniRowCapo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getSottotipo(): ?string
    {
        return $this->sottotipo;
    }

    public function setSottotipo(?string $sottotipo): self
    {
        $this->sottotipo = $sottotipo;

        return $this;
    }

    public function getDescrizione(): ?string
    {
        return $this->descrizione;
    }

    public function setDescrizione(?string $descrizione): self
    {
        $this->descrizione = $descrizione;

        return $this;
    }

    public function getPrezzo(): ?float
    {
        return $this->prezzo;
    }

    public function setPrezzo(float $prezzo): self
    {
        $this->prezzo = $prezzo;

        return $this;
    }

    public function getGiorniLavorazione(): ?int
    {
        return $this->giorni_lavorazione;
    }

    public function setGiorniLavorazione(?int $giorni_lavorazione): self
    {
        $this->giorni_lavorazione = $giorni_lavorazione;

        return $this;
    }

    /**
     * @return Collection|OrdiniRow[]
     */
    public function getOrdiniRowCapo(): Collection
    {
        return $this->getOrdiniRowCapo();
    }

    public function addOrdiniRowCapo(OrdiniRow $ordiniRowCapo): self
    {
        if (!$this->ordiniRowCapo->contains($ordiniRowCapo)) {
            $this->ordiniRowCapo[] = $ordiniRowCapo;
            $ordiniRowCapo->setCapo($this);
        }

        return $this;
    }

    public function removeOrdiniRowCapo(OrdiniRow $ordiniRowCapo): self
    {
        if ($this->ordiniRowCapo->removeElement($ordiniRowCapo)) {
            // set the owning side to null (unless already changed)
            if ($ordiniRowCapo->getCapo() === $this) {
                $ordiniRowCapo->setCapo(null);
            }
        }

        return $this;
    }
}
