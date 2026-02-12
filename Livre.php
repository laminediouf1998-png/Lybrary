<?php
//length ->String seulement
//Range->int,integer,...
//count ->collection
namespace App\Entity;//length ->String seulement

use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Stmt\TraitUse;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\IsFalse;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable:false,unique:True,length:13)]
    #[Assert\Length(min:13,
    max:13,
    exactMessage:'ISBN doit contenir  au moins {{ limit }} caractères ')]
  
    private string $isbn;

    #[ORM\Column(length: 50,nullable:false)]
    #[Assert\Length(min:3,
    max:30,
    minMessage: "le titre doit contenir au moins {{limit}} caracteres",
    maxMessage:"le titre doit contenir au max {{limit}} caracteres"

    )]

    private string $titre;

    #[ORM\Column]
    #[Assert\Range(min:1,
    minMessage:'Le nombre doit être positif'
    )]
    private int $nbpages;

    #[ORM\Column(type: Types::DATE_MUTABLE,nullable:false)]
    private \DateTime $dateDeParition;

    #[ORM\Column(nullable:false)]
    #[Assert\Range(
        min:0,
        max:20,
        notInRangeMessage:'la note doit être comprise entre 0 et 20'
    )]
    private int $note;

    /**
     * @var Collection<int, Auteur>
     */
    #[ORM\ManyToMany(targetEntity: Auteur::class, inversedBy: 'livres')]
    #[Assert\Count(
        min:1,
        minMessage:"Le livre doit avoir au moins un auteur !")]
    private Collection $auteurs;

    /**
     * @var Collection<int, Genre>
     */
    #[ORM\ManyToMany(targetEntity: Genre::class, inversedBy: 'livres')]
    #[Assert\Count(
        min:1,
        minMessage:"Le livre doit avoir au moins un genre  !"
    )]
    private Collection $genres;

    public function __construct()
    {
        $this->auteurs = new ArrayCollection();
        $this->genres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getNbpages(): ?int
    {
        return $this->nbpages;
    }

    public function setNbpages(int $nbpages): static
    {
        $this->nbpages = $nbpages;

        return $this;
    }

    public function getDateDeParition(): ?\DateTime
    {
        return $this->dateDeParition;
    }

    public function setDateDeParition(\DateTime $DateDeParition): static
    {
        $this->dateDeParition = $DateDeParition;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): static
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return Collection<int, Auteur>
     */
    public function getAuteurs(): Collection
    {
        return $this->auteurs;
    }

    public function addAuteur(Auteur $Auteur): static
    {
        if (!$this->auteurs->contains($Auteur)) {
            $this->auteurs->add($Auteur);
        }

        return $this;
    }

    public function removeAuteur(Auteur $Auteur): static
    {
        $this->auteurs->removeElement($Auteur);

        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): static
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): static
    {
        $this->genres->removeElement($genre);

        return $this;
    }



}
