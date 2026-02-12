<?php
namespace App\Entity;


use App\Repository\AuteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: AuteurRepository::class)]
class Auteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, unique: true,nullable:false)]
    #[Assert\NotBlank(message:"le nom et le prénon sont obligatoires")]
    #[Assert\Length(min:3,
    max:50,
    minMessage: "Le nom doit contenir au moins {{ limit }} caractères",
    maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères")]
    private string $nomPrenom;

    #[ORM\Column(length: 1,nullable:false)]
    #[Assert\Regex(pattern:'/^(M|F)$/')]    
    private string $sexe;

    #[ORM\Column(type: Types::DATE_MUTABLE,nullable:false)]
    private \DateTime $DatedeNaissance;

    #[ORM\Column(length: 50,nullable:false)]
    #[Assert\Country(message:'Veuiller entrer un pays valide ex Fr')]
    private string $nationalite;

    /**
     * @var Collection<int, Livre>
     */
    #[ORM\ManyToMany(targetEntity: Livre::class, mappedBy: 'auteurs')]
    private Collection $livres;

    public function __construct()
    {
        $this->livres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getnomPrenom(): ?string
    {
        return $this->nomPrenom;
    }

    public function setnomPrenom(string $nomPrenom): static
    {
        $this->nomPrenom = $nomPrenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDatedeNaissance(): ?\DateTime
    {
        return $this->DatedeNaissance;
    }

    public function setDatedeNaissance(\DateTime $DatedeNaissance): static
    {
        $this->DatedeNaissance = $DatedeNaissance;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): static
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * @return Collection<int, Livre>
     */
    public function getLivres(): Collection
    {
        return $this->livres;
    }

    public function addLivre(Livre $livre): static
    {
        if (!$this->livres->contains($livre)) {
            $this->livres->add($livre);
            $livre->addAuteur($this);
        }

        return $this;
    }

    public function removeLivre(Livre $livre): static
    {
        if ($this->livres->removeElement($livre)) {
            $livre->removeAuteur($this);
        }

        return $this;
    }
}
