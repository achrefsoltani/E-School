<?php

namespace App\Entity;

use App\Repository\SeanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass=SeanceRepository::class)
 */
class Seance
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $debut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fin;

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="seances")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classe;

    /**
     * @ORM\OneToMany(targetEntity=Absence::class, mappedBy="seance", orphanRemoval=true)
     * @ORM\JoinColumn(nullable=True)
     */
    private $absences;

    /**
     * @ORM\ManyToOne(targetEntity=Salle::class, inversedBy="seances")
     */
    private $salle;

    /**
     * @ORM\ManyToOne(targetEntity=Personne::class, inversedBy="seances", cascade={"persist"})
     */
    private $enseignant;

    /**
     * @ORM\ManyToOne(targetEntity=Personne::class, inversedBy="seances", cascade={"persist"})
     */
    private $profs;

    public function __construct()
    {
        $this->absences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    public function setDebut(\DateTimeInterface $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(\DateTimeInterface $fin): self
    {
        $this->fin = $fin;

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

    /**
     * @return Collection|Absence[]
     */
    public function getAbsences(): Collection
    {
        return $this->absences;
    }

    public function addAbsence(Absence $absence): self
    {
        if (!$this->absences->contains($absence)) {
            $this->absences[] = $absence;
            $absence->setSeance($this);
        }

        return $this;
    }

    public function removeAbsence(Absence $absence): self
    {
        if ($this->absences->removeElement($absence)) {
            // set the owning side to null (unless already changed)
            if ($absence->getSeance() === $this) {
                $absence->setSeance(null);
            }
        }

        return $this;
    }

    public function getSalle(): ?Salle
    {
        return $this->salle;
    }

    public function setSalle(?Salle $salle): self
    {
        $this->salle = $salle;

        return $this;
    }

    public function getEnseignant(): ?Personne
    {
        return $this->enseignant;
    }

    public function setEnseignant(?Personne $enseignant): self
    {
        $this->enseignant = $enseignant;

        return $this;
    }

    public function getProfs(): ?Personne
    {
        return $this->profs;
    }

    public function setProfs(?Personne $profs): self
    {
        $this->profs = $profs;

        return $this;
    }



}
