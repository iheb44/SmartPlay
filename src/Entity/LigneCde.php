<?php

namespace App\Entity;

use App\Repository\LigneCdeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LigneCdeRepository::class)
 */
class LigneCde
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class, inversedBy="ligneCdes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $num_cde_ligne;

    /**
     * @ORM\ManyToOne(targetEntity=Jouet::class, inversedBy="ligneCdes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $code_joue_ligne;

    /**
     * @ORM\Column(type="integer")
     */
    private $qte_ligne;

    /**
     * @ORM\Column(type="float")
     */
    private $remise_ligne;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCdeLigne(): ?Commande
    {
        return $this->num_cde_ligne;
    }

    public function setNumCdeLigne(?Commande $num_cde_ligne): self
    {
        $this->num_cde_ligne = $num_cde_ligne;

        return $this;
    }

    public function getCodeJoueLigne(): ?Jouet
    {
        return $this->code_joue_ligne;
    }

    public function setCodeJoueLigne(?Jouet $code_joue_ligne): self
    {
        $this->code_joue_ligne = $code_joue_ligne;

        return $this;
    }

    public function getQteLigne(): ?int
    {
        return $this->qte_ligne;
    }

    public function setQteLigne(int $qte_ligne): self
    {
        $this->qte_ligne = $qte_ligne;

        return $this;
    }

    public function getRemiseLigne(): ?float
    {
        return $this->remise_ligne;
    }

    public function setRemiseLigne(float $remise_ligne): self
    {
        $this->remise_ligne = $remise_ligne;

        return $this;
    }
}
