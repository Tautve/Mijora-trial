<?php

namespace App\Entity;

use App\Repository\DatabaseSynchronisationRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DatabaseSynchronisationRepository::class)]
class DatabaseSynchronisation
{
    public const STATUS_SUCCESS = 'status-success';
    public const STATUS_ERROR = 'status-error';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\Column(type: 'string', length: 255)]
    private $status;

    #[ORM\Column(type: 'string', length: 511, nullable: true)]
    private $errorMessage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?DateTimeInterface $date = null): self
    {
        $this->date = $date ?: new DateTime();

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    public function setErrorMessage(?string $errorMessage): self
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }
}
