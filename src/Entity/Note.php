<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 */
class Note
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $devoir;

    /**
     * @ORM\Column(type="float")
     */
    private $valeur;

    /**
     * @ORM\ManyToOne(targetEntity=Personne::class, inversedBy="notes")
     */
    private $eleve;

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="notes")
     */
    private $classe;

    /**
     * @ORM\ManyToOne(targetEntity=Matiere::class, inversedBy="notes")
     */
    private $matiere;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDevoir(): ?string
    {
        return $this->devoir;
    }

    public function setDevoir(string $devoir): self
    {
        $this->devoir = $devoir;

        return $this;
    }

    public function getValeur(): ?float
    {
        return $this->valeur;
    }

    public function setValeur(float $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getEleve(): ?Personne
    {
        return $this->eleve;
    }

    public function setEleve(?Personne $eleve): self
    {
        $this->eleve = $eleve;

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

    /**
     * @var datetime $created
     *
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var datetime $updated
     *
     * @ORM\Column(type="datetime", nullable = true)
     */
    protected $updated;


    /**
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update

     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated = new \DateTime("now");
    }
}
