<?php

namespace App\Filters;

use App\Entity\Category;
use Symfony\Component\Validator\Constraints as Assert;

final class FilterExpense
{
    private ?\DateTimeInterface $start = null;
    private ?\DateTimeInterface $end = null;
    #[Assert\PositiveOrZero]
    private ?float $minAmount = 0;
    #[Assert\Positive]
    private ?float $maxAmount = null;
    private ?Category $category = null;
    private ?string $isGain = null;
    private ?bool $isCash = null;

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(?\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(?\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getMinAmount(): ?float
    {
        return $this->minAmount;
    }

    public function setMinAmount(?float $minAmount): self
    {
        $this->minAmount = $minAmount;

        return $this;
    }

    public function getMaxAmount(): ?float
    {
        return $this->maxAmount;
    }

    public function setMaxAmount(?float $maxAmount): self
    {
        $this->maxAmount = $maxAmount;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getIsGain(): ?bool
    {
        return $this->isGain;
    }

    public function setIsGain(?bool $isGain): self
    {
        $this->isGain = $isGain;

        return $this;
    }

    public function getIsCash(): ?bool
    {
        return $this->isCash;
    }

    public function setIsCash(?bool $isCash): self
    {
        $this->isCash = $isCash;

        return $this;
    }
}