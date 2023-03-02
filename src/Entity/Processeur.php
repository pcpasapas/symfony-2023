<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProcesseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProcesseurRepository::class)]
class Processeur
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

    #[ORM\ManyToOne(inversedBy: 'processeurs')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'processeur', targetEntity: Panier::class)]
    private Collection $paniers;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $socket = null;

    #[ORM\Column(nullable: true)]
    private ?float $puissance_min = null;

    #[ORM\Column(nullable: true)]
    private ?float $puissance_boost = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $modele_min = null;

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
            $panier->setProcesseur($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): self
    {
        if ($this->paniers->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getProcesseur() === $this) {
                $panier->setProcesseur(null);
            }
        }

        return $this;
    }

    public function getSocket(): ?string
    {
        return $this->socket;
    }

    public function setSocket(?string $socket): self
    {
        $this->socket = $socket;

        return $this;
    }

    public function getPuissanceMin(): ?float
    {
        return $this->puissance_min;
    }

    public function setPuissanceMin(?float $puissance_min): self
    {
        $this->puissance_min = $puissance_min;

        return $this;
    }

    public function getPuissanceBoost(): ?float
    {
        return $this->puissance_boost;
    }

    public function setPuissanceBoost(?float $puissance_boost): self
    {
        $this->puissance_boost = $puissance_boost;

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
