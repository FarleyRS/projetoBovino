<?php

namespace App\Entity;

use App\Repository\VeterinarianRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=VeterinarianRepository::class)
 * @UniqueEntity(fields = {"CRMV"},message ="Esse CRMV já esta cadastrado!")
 */
class Veterinarian
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nome;

    /**
     * @ORM\Column(type="string", length=20, unique = true)
     */
    private $CRMV;

    /**
     * @ORM\ManyToMany(targetEntity=Farm::class)
     * @ORM\JoinTable(name="farm_veterinarian",
     *      joinColumns={@ORM\JoinColumn(name="veterinarian_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="farm_id", referencedColumnName="id")}
     *      )
     */
    private $farms;

    public function __construct() 
    {
        $this->farms = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCRMV(): ?string
    {
        return $this->CRMV;
    }

    public function setCRMV(string $CRMV): self
    {
        $this->CRMV = $CRMV;

        return $this;
    }

    /**
     * @return Collection<int, Farm>
     */
    public function getFarms(): Collection
    {
        return $this->farms;
    }

    public function addFarm(Farm $farm) {
        $this->farms[] = $farm;

        return $this;
    }

    public function removeFarm(Farm $farm): self
    {
       $this->farms->removeElement($farm);
        return $this;
    }

    public function __toString()
    {
        return $this->getNome();
    }
}
