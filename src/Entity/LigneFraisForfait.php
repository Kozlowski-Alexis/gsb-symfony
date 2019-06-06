<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LigneFraisForfaitRepository")
 */
class LigneFraisForfait
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FraisForfait", inversedBy="ligneFraisForfaits")
     */
    private $fraisForfait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FicheFrais", inversedBy="ligneFraisForfaits")
     */
    private $ficheFrais;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getFraisForfait(): ?FraisForfait
    {
        return $this->fraisForfait;
    }

    public function setFraisForfait(?FraisForfait $fraisForfait): self
    {
        $this->fraisForfait = $fraisForfait;

        return $this;
    }

    public function getFicheFrais(): ?FicheFrais
    {
        return $this->ficheFrais;
    }

    public function setFicheFrais(?FicheFrais $ficheFrais): self
    {
        $this->ficheFrais = $ficheFrais;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate() :?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }
}
