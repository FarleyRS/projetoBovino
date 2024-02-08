<?php

namespace App\Entity;

use App\Repository\FarmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=FarmRepository::class)
 * @UniqueEntity(fields = {"nome"},message ="Já existe uma fazenda com esse nome")
 */
class Farm
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, unique = true)
     */
    private $nome;

    /**
     * @ORM\Column(type="float")
     */
    private $tamanho;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $responsavel;

    /**
     * @ORM\ManyToMany(targetEntity=Veterinarian::class, inversedBy="farms")
     */
    private $veterinarios;

    /**
     * @ORM\OneToMany(targetEntity=Cow::class, mappedBy="fazenda")
     */
    private $cows;

    public function __construct()
    {
        $this->veterinarios = new ArrayCollection();
        $this->cows = new ArrayCollection();
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

    public function getTamanho(): ?float
    {
        return $this->tamanho;
    }

    public function setTamanho(float $tamanho): self
    {
        $this->tamanho = $tamanho;

        return $this;
    }

    public function getResponsavel(): ?string
    {
        return $this->responsavel;
    }

    public function setResponsavel(string $responsavel): self
    {
        $this->responsavel = $responsavel;

        return $this;
    }

    /**
     * @return Collection<int, Veterinarian>
     */
    public function getVeterinarios(): Collection
    {
        return $this->veterinarios;
    }

    public function addVeterinario(Veterinarian $veterinario): self
    {
        if (!$this->veterinarios->contains($veterinario)) {
            $this->veterinarios[] = $veterinario;
        }

        return $this;
    }

    public function removeVeterinario(Veterinarian $veterinario): self
    {
        $this->veterinarios->removeElement($veterinario);

        return $this;
    }

    /**
     * @return Collection<int, Cow>
     */
    public function getCows(): Collection
    {
        return $this->cows;
    }

    public function addCow(Cow $cow): self
    {
        if (!$this->cows->contains($cow)) {
            $this->cows[] = $cow;
            $cow->setFazenda($this);
        }

        return $this;
    }

    public function removeCow(Cow $cow): self
    {
        if ($this->cows->removeElement($cow)) {
            // set the owning side to null (unless already changed)
            if ($cow->getFazenda() === $this) {
                $cow->setFazenda(null);
            }
        }

        return $this;
    }
}
