<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
class Entreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $designation;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: Pfe::class)]
    private $listePfe;

    public function __construct()
    {
        $this->listePfe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * @return Collection<int, Pfe>
     */
    public function getListePfe(): Collection
    {
        return $this->listePfe;
    }

    public function addListePfe(Pfe $listePfe): self
    {
        if (!$this->listePfe->contains($listePfe)) {
            $this->listePfe[] = $listePfe;
            $listePfe->setEntreprise($this);
        }

        return $this;
    }

    public function removeListePfe(Pfe $listePfe): self
    {
        if ($this->listePfe->removeElement($listePfe)) {
            // set the owning side to null (unless already changed)
            if ($listePfe->getEntreprise() === $this) {
                $listePfe->setEntreprise(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->getDesignation();
    }
}
