<?php

namespace App\Entity;

use App\Repository\CowRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;


/**
 * @ORM\Entity(repositoryClass=CowRepository::class)
 */
class Cow
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $codigo;

    /**
     * @ORM\Column(type="float")
     */
    private $qt_leite;

    /**
     * @ORM\Column(type="float")
     */
    private $qt_racao;

    /**
     * @ORM\Column(type="float")
     */
    private $peso;

    /**
     * @ORM\Column(type="date")
     * @Assert\LessThanOrEqual("today", message = "A data de nascimento não pode ser futura.")
     */
    private $nascimento;

    /**
     * @ORM\ManyToOne(targetEntity=Farm::class, inversedBy="cows")
     */
    private $fazenda;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigo(): ?int
    {
        return $this->codigo;
    }

    public function setCodigo(int $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getQtLeite(): ?float
    {
        return $this->qt_leite;
    }

    public function setQtLeite(float $qt_leite): self
    {
        $this->qt_leite = $qt_leite;

        return $this;
    }

    public function getQtRacao(): ?float
    {
        return $this->qt_racao;
    }

    public function setQtRacao(float $qt_racao): self
    {
        $this->qt_racao = $qt_racao;

        return $this;
    }

    public function getPeso(): ?float
    {
        return $this->peso;
    }

    public function setPeso(float $peso): self
    {
        $this->peso = $peso;

        return $this;
    }

    public function getNascimento(): ?\DateTimeInterface
    {
        return $this->nascimento;
    }

    public function setNascimento(\DateTimeInterface $nascimento): self
    {
        $this->nascimento = $nascimento;

        return $this;
    }

    public function getFazenda(): ?Farm
    {
        return $this->fazenda;
    }

    public function setFazenda(?Farm $fazenda): self
    {
        $this->fazenda = $fazenda;

        return $this;
    }
}
