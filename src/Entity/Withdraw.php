<?php

namespace App\Entity;

use App\Repository\WithdrawRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=WithdrawRepository::class)
 */
class Withdraw
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $gross_amount;

    /**
     * @ORM\Column(type="float")
     */
    private $taxes;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Assert\LessThanOrEqual("today")
     */
    private $created_at;

    /**
     * @ORM\OneToOne(targetEntity=Investment::class, inversedBy="withdraw", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $investment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGrossAmount(): ?float
    {
        return $this->gross_amount;
    }

    public function setGrossAmount(float $gross_amount): self
    {
        $this->gross_amount = $gross_amount;

        return $this;
    }

    public function getTaxes(): ?float
    {
        return $this->taxes;
    }

    public function setTaxes(float $taxes): self
    {
        $this->taxes = $taxes;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getInvestment(): ?Investment
    {
        return $this->investment;
    }

    public function setInvestment(Investment $investment): self
    {
        $this->investment = $investment;

        return $this;
    }
}
