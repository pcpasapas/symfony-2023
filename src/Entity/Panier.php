<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'panier')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'paniers', fetch: 'EAGER')]
    private ?Boitier $boitier = null;

    #[ORM\ManyToOne(inversedBy: 'paniers', fetch: 'EAGER')]
    private ?Alimentation $alimentation = null;

    #[ORM\ManyToOne(inversedBy: 'paniers', fetch: 'EAGER')]
    private ?Processeur $processeur = null;

    #[ORM\ManyToOne(inversedBy: 'paniers', fetch: 'EAGER')]
    private ?CarteMere $carteMere = null;

    #[ORM\ManyToOne(inversedBy: 'paniers', fetch: 'EAGER')]
    private ?CarteGraphique $carteGraphique = null;

    #[ORM\ManyToOne(inversedBy: 'paniers', fetch: 'EAGER')]
    private ?Ram $ram = null;

    #[ORM\ManyToOne(inversedBy: 'paniers', fetch: 'EAGER')]
    private ?Hdd $hdd = null;

    #[ORM\ManyToOne(inversedBy: 'paniers', fetch: 'EAGER')]
    private ?Ssd $ssd = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'panier', targetEntity: Game::class)]
    private Collection $games;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable('now'));
        $this->games = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBoitier(): ?Boitier
    {
        return $this->boitier;
    }

    public function setBoitier(?Boitier $boitier): self
    {
        $this->boitier = $boitier;

        return $this;
    }

    public function getAlimentation(): ?Alimentation
    {
        return $this->alimentation;
    }

    public function setAlimentation(?Alimentation $alimentation): self
    {
        $this->alimentation = $alimentation;

        return $this;
    }

    public function getProcesseur(): ?Processeur
    {
        return $this->processeur;
    }

    public function setProcesseur(?Processeur $processeur): self
    {
        $this->processeur = $processeur;

        return $this;
    }

    public function getCarteMere(): ?CarteMere
    {
        return $this->carteMere;
    }

    public function setCarteMere(?CarteMere $carteMere): self
    {
        $this->carteMere = $carteMere;

        return $this;
    }

    public function getCarteGraphique(): ?CarteGraphique
    {
        return $this->carteGraphique;
    }

    public function setCarteGraphique(?CarteGraphique $carteGraphique): self
    {
        $this->carteGraphique = $carteGraphique;

        return $this;
    }

    public function getRam(): ?Ram
    {
        return $this->ram;
    }

    public function setRam(?Ram $ram): self
    {
        $this->ram = $ram;

        return $this;
    }

    public function getHdd(): ?Hdd
    {
        return $this->hdd;
    }

    public function setHdd(?Hdd $hdd): self
    {
        $this->hdd = $hdd;

        return $this;
    }

    public function getSsd(): ?Ssd
    {
        return $this->ssd;
    }

    public function setSsd(?Ssd $ssd): self
    {
        $this->ssd = $ssd;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games->add($game);
            $game->setPanier($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getPanier() === $this) {
                $game->setPanier(null);
            }
        }

        return $this;
    }
}