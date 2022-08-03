<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 3)]
    private ?string $code = null;

    #[ORM\Column]
    private ?bool $isInShengenArea = null;

    #[ORM\Column]
    private ?bool $hasVisaWaiverAgreement = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function isIsInShengenArea(): ?bool
    {
        return $this->isInShengenArea;
    }

    public function setIsInShengenArea(bool $isInShengenArea): self
    {
        $this->isInShengenArea = $isInShengenArea;

        return $this;
    }

    public function isHasVisaWaiverAgreement(): ?bool
    {
        return $this->hasVisaWaiverAgreement;
    }

    public function setHasVisaWaiverAgreement(bool $hasVisaWaiverAgreement): self
    {
        $this->hasVisaWaiverAgreement = $hasVisaWaiverAgreement;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
