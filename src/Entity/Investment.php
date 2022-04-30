<?php

namespace App\Entity;

use App\Repository\InvestmentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=InvestmentRepository::class)
 */
class Investment
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
    private $initial_amount;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="investments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=Withdraw::class, mappedBy="investment", cascade={"persist", "remove"})
     */
    private $withdraw;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInitialAmount(): ?float
    {
        return $this->initial_amount;
    }

    public function setInitialAmount(float $initial_amount): self
    {
        $this->initial_amount = $initial_amount;

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

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getWithdraw(): ?Withdraw
    {
        return $this->withdraw;
    }

    public function setWithdraw(Withdraw $withdraw): self
    {
        // set the owning side of the relation if necessary
        if ($withdraw->getInvestment() !== $this) {
            $withdraw->setInvestment($this);
        }

        $this->withdraw = $withdraw;

        return $this;
    }
}
