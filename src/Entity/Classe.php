<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass=ClasseRepository::class)
 */
class Classe
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
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_eleve;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacite;

    /**
     * @ORM\Column(type="integer")
     */
    private $niveau;

    /**
     * @ORM\ManyToMany(targetEntity=Personne::class, inversedBy="classe")
     */
    private $membres;

    /**
     * @ORM\ManyToMany(targetEntity=Matiere::class, mappedBy="classes")
     */
    private $matieres;

    /**
     * @ORM\OneToMany(targetEntity=Seance::class, mappedBy="classe", orphanRemoval=true)
     */
    private $seances;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="classe")
     */
    private $notes;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $eleves = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $enseignants = [];



    public function __construct()
    {
        $this->membres = new ArrayCollection();
        $this->matieres = new ArrayCollection();
        $this->seances = new ArrayCollection();
        $this->notes = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNbEleve(): ?int
    {
        return $this->nb_eleve;
    }

    public function setNbEleve(int $nb_eleve): self
    {
        $this->nb_eleve = $nb_eleve;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(int $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * @return Collection|Personne[]
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Personne $membre): self
    {
        if (!$this->membres->contains($membre)) {
            $this->membres[] = $membre;
        }

        return $this;
    }

    public function removeMembre(Personne $eleve): self
    {
        $this->membres->removeElement($eleve);

        return $this;
    }

    /**
     * @return Collection|Matiere[]
     */
    public function getMatieres(): Collection
    {
        return $this->matieres;
    }

    public function addClass(Matiere $class): self
    {
        if (!$this->matieres->contains($class)) {
            $this->matieres[] = $class;
            $class->addClass($this);
        }

        return $this;
    }

    public function removeClass(Matiere $class): self
    {
        if ($this->matieres->removeElement($class)) {
            $class->removeClass($this);
        }

        return $this;
    }

    /**
     * @return Collection|Seance[]
     */
    public function getSeances(): Collection
    {
        return $this->seances;
    }

    public function addSeance(Seance $seance): self
    {
        if (!$this->seances->contains($seance)) {
            $this->seances[] = $seance;
            $seance->setClasse($this);
        }

        return $this;
    }

    public function removeSeance(Seance $seance): self
    {
        if ($this->seances->removeElement($seance)) {
            // set the owning side to null (unless already changed)
            if ($seance->getClasse() === $this) {
                $seance->setClasse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setClasse($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getClasse() === $this) {
                $note->setClasse(null);
            }
        }

        return $this;
    }

    public function getEleves(): ?array
    {
        return $this->eleves;
    }

    public function setEleves(?array $eleves): self
    {
        $this->eleves = $eleves;

        return $this;
    }

    public function getEnseignants(): ?array
    {
        return $this->enseignants;
    }

    public function setEnseignants(?array $enseignants): self
    {
        $this->enseignants = $enseignants;

        return $this;
    }





}
