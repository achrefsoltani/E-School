<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=PersonneRepository::class)
 */
class Personne
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
     * @ORM\Column(type="string", length=20)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $sexe;

    /**
     * @ORM\Column(type="date")
     */
    private $date_naissance;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $lieu_naissance;

    /**
     * @ORM\Column(type="integer")
     */
    private $cin;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $num_tel;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $role;

    /**
     * @ORM\ManyToMany(targetEntity=Classe::class, mappedBy="membres")
     */
    private $classe;

    /**
     * @ORM\OneToMany(targetEntity=Absence::class, mappedBy="personne", orphanRemoval=true)
     */
    private $absences;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="eleve")
     */
    private $notes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $niveau;

    /**
     * @ORM\ManyToMany(targetEntity=Matiere::class, inversedBy="enseignants",cascade={"persist"})
     */
    private $matieres;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $listMatieres = [];

    /**
     * @ORM\OneToMany(targetEntity=Demande::class, mappedBy="personne")
     */
    private $demandes;
    /**
     * @ORM\OneToMany(targetEntity=Contacte::class, mappedBy="personne")
     */
    private $contactes;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="personne", cascade={"persist", "remove"})
     */
    private $user;

    public function __construct()
    {
        $this->classe = new ArrayCollection();
        $this->absences = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->matieres = new ArrayCollection();
        $this->demandes = new ArrayCollection();
        $this->contactes = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieu_naissance;
    }

    public function setLieuNaissance(string $lieu_naissance): self
    {
        $this->lieu_naissance = $lieu_naissance;

        return $this;
    }

    public function getCin(): ?int
    {
        return $this->cin;
    }

    public function setCin(int $cin): self
    {
        $this->cin = $cin;

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

    public function getNumTel(): ?int
    {
        return $this->num_tel;
    }

    public function setNumTel(?int $num_tel): self
    {
        $this->num_tel = $num_tel;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection|Classe[]
     */
    public function getClasse(): Collection
    {
        return $this->classe;
    }

    public function addClasse(Classe $classe): self
    {
        if (!$this->classe->contains($classe)) {
            $this->classe[] = $classe;
            $classe->addMembre($this);
        }

        return $this;
    }

    public function removeClasse(Classe $classe): self
    {
        if ($this->classe->removeElement($classe)) {
            $classe->removeMembre($this);
        }

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
            $absence->setPersonne($this);
        }

        return $this;
    }

    public function removeAbsence(Absence $absence): self
    {
        if ($this->absences->removeElement($absence)) {
            // set the owning side to null (unless already changed)
            if ($absence->getPersonne() === $this) {
                $absence->setPersonne(null);
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
            $note->setEleve($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getEleve() === $this) {
                $note->setEleve(null);
            }
        }

        return $this;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(?int $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function __toString()
    {
        $str = $this->getNom() . " " . $this->getPrenom();
        if ($this->getRole() == 'enseignant'){
            $str = $str . " [ ";
            foreach ($this->getMatieres() as $mat){
                $str = $str . $mat->getNom() . " ";
            }
            $str = $str . "]";
        }
        return  $str;
    }

    public function fullName()
    {
        $str = $this->getNom() . " " . $this->getPrenom();

        return  $str;
    }

    /**
     * @return Collection|Matiere[]
     */
    public function getMatieres(): Collection
    {
        return $this->matieres;
    }

    public function addMatiere(Matiere $matiere): self
    {
        if (!$this->matieres->contains($matiere)) {
            $this->matieres[] = $matiere;
        }

        return $this;
    }

    public function removeMatiere(Matiere $matiere): self
    {
        $this->matieres->removeElement($matiere);

        return $this;
    }

    public function getListMatieres(): ?array
    {
        return $this->listMatieres;
    }

    public function setListMatieres(?array $listMatieres): self
    {
        $this->listMatieres = $listMatieres;

        return $this;
    }

    /**
     * @return Collection|Demande[]
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    public function addDemande(Demande $demande): self
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes[] = $demande;
            $demande->setPersonne($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getPersonne() === $this) {
                $demande->setPersonne(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|Contacte[]
     */
    public function getContacte(): Collection
    {
        return $this->contactes;
    }

    public function addContacte(Contacte $contacte): self
    {
        if (!$this->contactes->contains($contacte)) {
            $this->contactes[] = $contacte;
            $contacte->setPersonne($this);
        }

        return $this;
    }

    public function removeContacte(Contacte $contacte): self
    {
        if ($this->contactes->removeElement($contacte)) {
            // set the owning side to null (unless already changed)
            if ($contacte->getPersonne() === $this) {
                $contacte->setPersonne(null);
            }
        }

        return $this;
    }


    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        // set (or unset) the owning side of the relation if necessary
        $newPersonne = null === $user ? null : $this;
        if ($user->getPersonne() !== $newPersonne) {
            $user->setPersonne($newPersonne);
        }

        return $this;
    }


}
