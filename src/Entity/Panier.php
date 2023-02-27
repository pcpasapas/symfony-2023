<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable('now'));
    }
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'panier', cascade: ['persist', 'remove'])]
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

}