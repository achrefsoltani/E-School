<?php

namespace App\Entity;

use App\Repository\AbsenceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass=AbsenceRepository::class)
 */
class Absence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Justifie;

    /**
     * @ORM\ManyToOne(targetEntity=Personne::class, inversedBy="absences")
     * @ORM\JoinColumn(nullable=True)
     */
    private $personne;

    /**
     * @ORM\ManyToOne(targetEntity=Seance::class, inversedBy="absences")
     * @ORM\JoinColumn(nullable=True)
     */
    private $seance;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJustifie(): ?bool
    {
        return $this->Justifie;
    }

    public function setJustifie(?bool $Justifie): self
    {
        $this->Justifie = $Justifie;

        return $this;
    }

    public function getPersonne(): ?Personne
    {
        return $this->personne;
    }

    public function setPersonne(?Personne $personne): self
    {
        $this->personne = $personne;

        return $this;
    }

    public function getSeance(): ?Seance
    {
        return $this->seance;
    }

    public function setSeance(?Seance $seance): self
    {
        $this->seance = $seance;

        return $this;
    }


}
