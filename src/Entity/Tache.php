<?php

namespace App\Entity;

use App\Repository\TacheRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: TacheRepository::class)]
class Tache
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("tache:read")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups("tache:read")]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups("tache:read")]
    private ?string $priority = null;

    #[ORM\Column(length: 255)]
    #[Groups("tache:read")]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups("tache:read")]
    private ?string $status = null;

    #[ORM\Column(length: 255)]
    #[Groups("tache:read")]
    private ?string $createdBy = null;

    #[ORM\Column(length: 255)]
    #[Groups("tache:read")]
    private ?string $createdDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups("tache:read")]
    private ?string $updatedBy = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups("tache:read")]
    private ?string $updatedDate = null;

    #[ORM\ManyToOne(inversedBy: 'taches')]
    #[ORM\JoinColumn(name: 'id', referencedColumnName: 'id')]
    #[Groups("tache:read")]
    private ?Categorie $category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(string $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(string $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getCreatedDate(): ?string
    {
        return $this->createdDate;
    }

    public function setCreatedDate(string $createdDate): static
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?string $updatedBy): static
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getUpdatedDate(): ?string
    {
        return $this->updatedDate;
    }

    public function setUpdatedDate(?string $updatedDate): static
    {
        $this->updatedDate = $updatedDate;

        return $this;
    }

    public function getCategory(): ?Categorie
    {
        return $this->category;
    }

    public function setCategory(?Categorie $category): static
    {
        $this->category = $category;

        return $this;
    }
}
