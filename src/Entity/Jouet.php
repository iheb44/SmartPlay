<?php

namespace App\Entity;

use App\Repository\JouetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JouetRepository::class)
 */
class Jouet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     */
    private $code_jouet;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $des_jouet;

    /**
     * @ORM\Column(type="integer")
     */
    private $qte_stock_jouet;

    /**
     * @ORM\Column(type="float")
     */
    private $PU_jouet;

    /**
     * @ORM\ManyToOne(targetEntity=Fournisseur::class, inversedBy="jouets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $code_four_jouet;

    /**
     * @ORM\OneToMany(targetEntity=LigneCde::class, mappedBy="code_joue_ligne")
     */
    private $ligneCdes;

    public function __construct()
    {
        $this->ligneCdes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeJouet(): ?string
    {
        return $this->code_jouet;
    }

    public function setCodeJouet(string $code_jouet): self
    {
        $this->code_jouet = $code_jouet;

        return $this;
    }

    public function getDesJouet(): ?string
    {
        return $this->des_jouet;
    }

    public function setDesJouet(?string $des_jouet): self
    {
        $this->des_jouet = $des_jouet;

        return $this;
    }

    public function getQteStockJouet(): ?int
    {
        return $this->qte_stock_jouet;
    }

    public function setQteStockJouet(int $qte_stock_jouet): self
    {
        $this->qte_stock_jouet = $qte_stock_jouet;

        return $this;
    }

    public function getPUJouet(): ?float
    {
        return $this->PU_jouet;
    }

    public function setPUJouet(float $PU_jouet): self
    {
        $this->PU_jouet = $PU_jouet;

        return $this;
    }

    public function getCodeFourJouet(): ?Fournisseur
    {
        return $this->code_four_jouet;
    }

    public function setCodeFourJouet(?Fournisseur $code_four_jouet): self
    {
        $this->code_four_jouet = $code_four_jouet;

        return $this;
    }

    /**
     * @return Collection|LigneCde[]
     */
    public function getLigneCdes(): Collection
    {
        return $this->ligneCdes;
    }

    public function addLigneCde(LigneCde $ligneCde): self
    {
        if (!$this->ligneCdes->contains($ligneCde)) {
            $this->ligneCdes[] = $ligneCde;
            $ligneCde->setCodeJoueLigne($this);
        }

        return $this;
    }

    public function removeLigneCde(LigneCde $ligneCde): self
    {
        if ($this->ligneCdes->removeElement($ligneCde)) {
            // set the owning side to null (unless already changed)
            if ($ligneCde->getCodeJoueLigne() === $this) {
                $ligneCde->setCodeJoueLigne(null);
            }
        }

        return $this;
    }

    public function __toString():string
    {
        return $this->getDesJouet();
    }
}
