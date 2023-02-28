<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CarteGraphiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarteGraphiqueRepository::class)]
class CarteGraphique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $modele = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'carteGraphiques')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'carteGraphique', targetEntity: Panier::class)]
    private Collection $paniers;

    #[ORM\Column(nullable: true)]
    private ?int $capacite = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $modele_min = null;

    #[ORM\Column(nullable: true)]
    private ?int $puissance_min = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lien = null;

    public function __construct()
    {
        $this->paniers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function getFormattedPrice(): ?string
    {
        return number_format($this->price / 100, 2, ',', ' ') .  '€';
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Panier>
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $panier): self
    {
        if (! $this->paniers->contains($panier)) {
            $this->paniers->add($panier);
            $panier->setCarteGraphique($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): self
    {
        if ($this->paniers->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getCarteGraphique() === $this) {
                $panier->setCarteGraphique(null);
            }
        }

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(?int $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getModeleMin(): ?string
    {
        return $this->modele_min;
    }

    public function setModeleMin(?string $modele_min): self
    {
        $this->modele_min = $modele_min;

        return $this;
    }

    public function getPuissanceMin(): ?int
    {
        return $this->puissance_min;
    }

    public function setPuissanceMin(?int $puissance_min): self
    {
        $this->puissance_min = $puissance_min;

        return $this;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(?string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }
}
