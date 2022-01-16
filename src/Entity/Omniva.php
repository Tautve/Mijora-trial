<?php

namespace App\Entity;

use App\Repository\OmnivaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OmnivaRepository::class)]
class Omniva
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $zipCode;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $type;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $a0Name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $a1Name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $a2Name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $a3Name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $a4Name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $a5Name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $a6Name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $a7Name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $a8Name;

    #[ORM\Column(type: 'string', length: 15)]
    private $xCoordinate;

    #[ORM\Column(type: 'string', length: 15)]
    private $yCoordinate;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $serviceHours;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $tempServiceHours;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $tempServiceHoursUntil;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $tempServiceHours2;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $tempServiceHours2Until;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $commentEst;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $commentEng;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $commentRus;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $commentLav;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $commentLit;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $modified;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getA0Name(): ?string
    {
        return $this->a0Name;
    }

    public function setA0Name(?string $a0Name): self
    {
        $this->a0Name = $a0Name;

        return $this;
    }

    public function getA1Name(): ?string
    {
        return $this->a1Name;
    }

    public function setA1Name(?string $a1Name): self
    {
        $this->a1Name = $a1Name;

        return $this;
    }

    public function getA2Name(): ?string
    {
        return $this->a2Name;
    }

    public function setA2Name(?string $a2Name): self
    {
        $this->a2Name = $a2Name;

        return $this;
    }

    public function getA3Name(): ?string
    {
        return $this->a3Name;
    }

    public function setA3Name(?string $a3Name): self
    {
        $this->a3Name = $a3Name;

        return $this;
    }

    public function getA4Name(): ?string
    {
        return $this->a4Name;
    }

    public function setA4Name(?string $a4Name): self
    {
        $this->a4Name = $a4Name;

        return $this;
    }

    public function getA5Name(): ?string
    {
        return $this->a5Name;
    }

    public function setA5Name(?string $a5Name): self
    {
        $this->a5Name = $a5Name;

        return $this;
    }

    public function getA6Name(): ?string
    {
        return $this->a6Name;
    }

    public function setA6Name(?string $a6Name): self
    {
        $this->a6Name = $a6Name;

        return $this;
    }

    public function getA7Name(): ?string
    {
        return $this->a7Name;
    }

    public function setA7Name(?string $a7Name): self
    {
        $this->a7Name = $a7Name;

        return $this;
    }

    public function getA8Name(): ?string
    {
        return $this->a8Name;
    }

    public function setA8Name(string $a8Name): self
    {
        $this->a8Name = $a8Name;

        return $this;
    }

    public function getXCoordinate(): ?string
    {
        return $this->xCoordinate;
    }

    public function setXCoordinate(string $xCoordinate): self
    {
        $this->xCoordinate = $xCoordinate;

        return $this;
    }

    public function getYCoordinate(): ?string
    {
        return $this->yCoordinate;
    }

    public function setYCoordinate(string $yCoordinate): self
    {
        $this->yCoordinate = $yCoordinate;

        return $this;
    }

    public function getServiceHours(): ?string
    {
        return $this->serviceHours;
    }

    public function setServiceHours(?string $serviceHours): self
    {
        $this->serviceHours = $serviceHours;

        return $this;
    }

    public function getTempServiceHours(): ?string
    {
        return $this->tempServiceHours;
    }

    public function setTempServiceHours(?string $tempServiceHours): self
    {
        $this->tempServiceHours = $tempServiceHours;

        return $this;
    }

    public function getTempServiceHoursUntil(): ?string
    {
        return $this->tempServiceHoursUntil;
    }

    public function setTempServiceHoursUntil(?string $tempServiceHoursUntil): self
    {
        $this->tempServiceHoursUntil = $tempServiceHoursUntil;

        return $this;
    }

    public function getTempServiceHours2(): ?string
    {
        return $this->tempServiceHours2;
    }

    public function setTempServiceHours2(?string $tempServiceHours2): self
    {
        $this->tempServiceHours2 = $tempServiceHours2;

        return $this;
    }

    public function getTempServiceHours2Until(): ?string
    {
        return $this->tempServiceHours2Until;
    }

    public function setTempServiceHours2Until(?string $tempServiceHours2Until): self
    {
        $this->tempServiceHours2Until = $tempServiceHours2Until;

        return $this;
    }

    public function getCommentEst(): ?string
    {
        return $this->commentEst;
    }

    public function setCommentEst(?string $commentEst): self
    {
        $this->commentEst = $commentEst;

        return $this;
    }

    public function getCommentEng(): ?string
    {
        return $this->commentEng;
    }

    public function setCommentEng(?string $commentEng): self
    {
        $this->commentEng = $commentEng;

        return $this;
    }

    public function getCommentRus(): ?string
    {
        return $this->commentRus;
    }

    public function setCommentRus(?string $commentRus): self
    {
        $this->commentRus = $commentRus;

        return $this;
    }

    public function getCommentLav(): ?string
    {
        return $this->commentLav;
    }

    public function setCommentLav(?string $commentLav): self
    {
        $this->commentLav = $commentLav;

        return $this;
    }

    public function getCommentLit(): ?string
    {
        return $this->commentLit;
    }

    public function setCommentLit(?string $commentLit): self
    {
        $this->commentLit = $commentLit;

        return $this;
    }

    public function getModified(): ?\DateTimeInterface
    {
        return $this->modified;
    }

    public function setModified(?\DateTimeInterface $modified): self
    {
        $this->modified = $modified;

        return $this;
    }
}
