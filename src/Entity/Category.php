<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CategoryRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?DateTimeImmutable $created_at = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Boitier::class, fetch: 'EAGER')]
    private Collection $boitiers;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Alimentation::class, fetch: 'EAGER')]
    private Collection $alimentations;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Processeur::class, fetch: 'EAGER')]
    private Collection $processeurs;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: CarteMere::class, fetch: 'EAGER')]
    private Collection $carteMeres;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: CarteGraphique::class)]
    private Collection $carteGraphiques;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Ram::class)]
    private Collection $rams;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Hdd::class)]
    private Collection $hdds;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Ssd::class)]
    private Collection $ssds;
    public function __construct()
    {
        $this->setCreatedAt(new DateTimeImmutable());
        $this->boitiers = new ArrayCollection();
        $this->alimentations = new ArrayCollection();
        $this->processeurs = new ArrayCollection();
        $this->carteMeres = new ArrayCollection();
        $this->carteGraphiques = new ArrayCollection();
        $this->rams = new ArrayCollection();
        $this->hdds = new ArrayCollection();
        $this->ssds = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->getName();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, Boitier>
     */
    public function getBoitiers(): Collection
    {
        return $this->boitiers;
    }

    public function addBoitier(Boitier $boitier): self
    {
        if (! $this->boitiers->contains($boitier)) {
            $this->boitiers->add($boitier);
            $boitier->setCategory($this);
        }

        return $this;
    }

    public function removeBoitier(Boitier $boitier): self
    {
        if ($this->boitiers->removeElement($boitier)) {
            // set the owning side to null (unless already changed)
            if ($boitier->getCategory() === $this) {
                $boitier->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Alimentation>
     */
    public function getAlimentations(): Collection
    {
        return $this->alimentations;
    }

    public function addAlimentation(Alimentation $alimentation): self
    {
        if (! $this->alimentations->contains($alimentation)) {
            $this->alimentations->add($alimentation);
            $alimentation->setCategory($this);
        }

        return $this;
    }

    public function removeAlimentation(Alimentation $alimentation): self
    {
        if ($this->alimentations->removeElement($alimentation)) {
            // set the owning side to null (unless already changed)
            if ($alimentation->getCategory() === $this) {
                $alimentation->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Processeur>
     */
    public function getProcesseurs(): Collection
    {
        return $this->processeurs;
    }

    public function addProcesseur(Processeur $processeur): self
    {
        if (! $this->processeurs->contains($processeur)) {
            $this->processeurs->add($processeur);
            $processeur->setCategory($this);
        }

        return $this;
    }

    public function removeProcesseur(Processeur $processeur): self
    {
        if ($this->processeurs->removeElement($processeur)) {
            // set the owning side to null (unless already changed)
            if ($processeur->getCategory() === $this) {
                $processeur->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CarteMere>
     */
    public function getCarteMeres(): Collection
    {
        return $this->carteMeres;
    }

    public function addCarteMere(CarteMere $carteMere): self
    {
        if (! $this->carteMeres->contains($carteMere)) {
            $this->carteMeres->add($carteMere);
            $carteMere->setCategory($this);
        }

        return $this;
    }

    public function removeCarteMere(CarteMere $carteMere): self
    {
        if ($this->carteMeres->removeElement($carteMere)) {
            // set the owning side to null (unless already changed)
            if ($carteMere->getCategory() === $this) {
                $carteMere->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CarteGraphique>
     */
    public function getCarteGraphiques(): Collection
    {
        return $this->carteGraphiques;
    }

    public function addCarteGraphique(CarteGraphique $carteGraphique): self
    {
        if (! $this->carteGraphiques->contains($carteGraphique)) {
            $this->carteGraphiques->add($carteGraphique);
            $carteGraphique->setCategory($this);
        }

        return $this;
    }

    public function removeCarteGraphique(CarteGraphique $carteGraphique): self
    {
        if ($this->carteGraphiques->removeElement($carteGraphique)) {
            // set the owning side to null (unless already changed)
            if ($carteGraphique->getCategory() === $this) {
                $carteGraphique->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ram>
     */
    public function getRams(): Collection
    {
        return $this->rams;
    }

    public function addRam(Ram $ram): self
    {
        if (! $this->rams->contains($ram)) {
            $this->rams->add($ram);
            $ram->setCategory($this);
        }

        return $this;
    }

    public function removeRam(Ram $ram): self
    {
        if ($this->rams->removeElement($ram)) {
            // set the owning side to null (unless already changed)
            if ($ram->getCategory() === $this) {
                $ram->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Hdd>
     */
    public function getHdds(): Collection
    {
        return $this->hdds;
    }

    public function addHdd(Hdd $hdd): self
    {
        if (! $this->hdds->contains($hdd)) {
            $this->hdds->add($hdd);
            $hdd->setCategory($this);
        }

        return $this;
    }

    public function removeHdd(Hdd $hdd): self
    {
        if ($this->hdds->removeElement($hdd)) {
            // set the owning side to null (unless already changed)
            if ($hdd->getCategory() === $this) {
                $hdd->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ssd>
     */
    public function getSsds(): Collection
    {
        return $this->ssds;
    }

    public function addSsd(Ssd $ssd): self
    {
        if (! $this->ssds->contains($ssd)) {
            $this->ssds->add($ssd);
            $ssd->setCategory($this);
        }

        return $this;
    }

    public function removeSsd(Ssd $ssd): self
    {
        if ($this->ssds->removeElement($ssd)) {
            // set the owning side to null (unless already changed)
            if ($ssd->getCategory() === $this) {
                $ssd->setCategory(null);
            }
        }

        return $this;
    }
}
