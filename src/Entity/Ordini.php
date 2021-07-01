<?php

namespace App\Entity;

use App\Repository\OrdiniRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrdiniRepository::class)
 */
class Ordini{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Clienti::class, inversedBy="ordiniCliente")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cliente;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ordiniUser")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="date")
     */
    private $data_ordine;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $data_consegna;

    /**
     * @ORM\Column(type="float")
     */
    private $totale;

    /**
     * @ORM\OneToMany(targetEntity=OrdiniRow::class, mappedBy="ordine")
     */
    private $ordiniRows;

    public function __construct()
    {
        $this->ordiniRows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCliente(): ?clienti
    {
        return $this->cliente;
    }

    public function setCliente(?clienti $cliente): self
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getDataOrdine(): ?\DateTimeInterface
    {
        return $this->data_ordine;
    }

    public function setDataOrdine(\DateTimeInterface $data_ordine): self
    {
        $this->data_ordine = $data_ordine;

        return $this;
    }

    public function getDataConsegna(): ?\DateTimeInterface
    {
        return $this->data_consegna;
    }

    public function setDataConsegna(?\DateTimeInterface $data_consegna): self
    {
        $this->data_consegna = $data_consegna;

        return $this;
    }

    public function getTotale(): ?float
    {
        return $this->totale;
    }

    public function setTotale(float $totale): self
    {
        $this->totale = $totale;

        return $this;
    }

    /**
     * @return Collection|OrdiniRow[]
     */
    public function getOrdiniRows(): Collection
    {
        return $this->ordiniRows;
    }

    public function addOrdiniRow(OrdiniRow $ordiniRow): self
    {
        if (!$this->ordiniRows->contains($ordiniRow)) {
            $this->ordiniRows[] = $ordiniRow;
            $ordiniRow->setOrdine($this);
        }

        return $this;
    }

    public function removeOrdiniRow(OrdiniRow $ordiniRow): self
    {
        if ($this->ordiniRows->removeElement($ordiniRow)) {
            // set the owning side to null (unless already changed)
            if ($ordiniRow->getOrdine() === $this) {
                $ordiniRow->setOrdine(null);
            }
        }

        return $this;
    }
}
