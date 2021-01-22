<?php

namespace App\Entity;

use App\Repository\ContacteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContacteRepository::class)
 */
class Contacte
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $objet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity=Personne::class, inversedBy="contactes")
     */
    private $personne;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $distinataire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reponse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $etat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $emetteur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(?string $objet): self
    {
        $this->objet = $objet;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getPersonne(): ?personne
    {
        return $this->personne;
    }

    public function setPersonne(?personne $personne): self
    {
        $this->personne = $personne;

        return $this;
    }

    public function getDistinataire(): ?string
    {
        return $this->distinataire;
    }

    public function setDistinataire(string $distinataire): self
    {
        $this->distinataire = $distinataire;

        return $this;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(?string $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getEmetteur(): ?string
    {
        return $this->emetteur;
    }

    public function setEmetteur(?string $emetteur): self
    {
        $this->emetteur = $emetteur;

        return $this;
    }
}
