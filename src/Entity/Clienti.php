<?php

namespace App\Entity;

use App\Form\NuovoClienteType;
use App\Repository\ClientiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientiRepository::class)
 */
class Clienti{


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nome;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cognome;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $indirizzo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comune;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $provincia;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $stato;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cap;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cellulare;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codice_fiscale;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $p_iva;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codice_univoco;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pec;

    /**
     * @ORM\OneToMany(targetEntity=Ordini::class, mappedBy="cliente")
     */
    private $ordiniCliente;

    public function __construct()
    {
        $this->ordiniCliente = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCognome(): ?string
    {
        return $this->cognome;
    }

    public function setCognome(string $cognome): self
    {
        $this->cognome = $cognome;

        return $this;
    }

    public function getIndirizzo(): ?string
    {
        return $this->indirizzo;
    }

    public function setIndirizzo(?string $indirizzo): self
    {
        $this->indirizzo = $indirizzo;

        return $this;
    }

    public function getComune(): ?string
    {
        return $this->comune;
    }

    public function setComune(?string $comune): self
    {
        $this->comune = $comune;

        return $this;
    }

    public function getProvincia(): ?string
    {
        return $this->provincia;
    }

    public function setProvincia(?string $provincia): self
    {
        $this->provincia = $provincia;

        return $this;
    }

    public function getStato(): ?string
    {
        return $this->stato;
    }

    public function setStato(?string $stato): self
    {
        $this->stato = $stato;

        return $this;
    }

    public function getCap(): ?int
    {
        return $this->cap;
    }

    public function setCap(?int $cap): self
    {
        $this->cap = $cap;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getCellulare(): ?string
    {
        return $this->cellulare;
    }

    public function setCellulare(?string $cellulare): self
    {
        $this->cellulare = $cellulare;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCodiceFiscale(): ?string
    {
        return $this->codice_fiscale;
    }

    public function setCodiceFiscale(?string $codice_fiscale): self
    {
        $this->codice_fiscale = $codice_fiscale;

        return $this;
    }

    public function getPIva(): ?string
    {
        return $this->p_iva;
    }

    public function setPIva(?string $p_iva): self
    {
        $this->p_iva = $p_iva;

        return $this;
    }

    public function getCodiceUnivoco(): ?string
    {
        return $this->codice_univoco;
    }

    public function setCodiceUnivoco(?string $codice_univoco): self
    {
        $this->codice_univoco = $codice_univoco;

        return $this;
    }

    public function getPec(): ?string
    {
        return $this->pec;
    }

    public function setPec(?string $pec): self
    {
        $this->pec = $pec;

        return $this;
    }

    /**
     * @return Collection|Ordini[]
     */
    public function getOrdiniCliente(): Collection
    {
        return $this->ordiniCliente;
    }

    public function addOrdiniCliente(Ordini $ordiniCliente): self
    {
        if (!$this->ordiniCliente->contains($ordiniCliente)) {
            $this->ordiniCliente[] = $ordiniCliente;
            $ordiniCliente->setCliente($this);
        }

        return $this;
    }

    public function removeOrdiniCliente(Ordini $ordiniCliente): self
    {
        if ($this->ordiniCliente->removeElement($ordiniCliente)) {
            // set the owning side to null (unless already changed)
            if ($ordiniCliente->getCliente() === $this) {
                $ordiniCliente->setCliente(null);
            }
        }

        return $this;
    }
}
