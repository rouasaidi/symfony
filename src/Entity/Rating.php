<?php

namespace App\Entity;

use App\Repository\RatingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RatingRepository::class)]
class Rating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $Stars = null;

    #[ORM\ManyToOne(inversedBy: 'ratings')]
    private ?Product $Product = null;



    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $RatingDate = null;

    #[ORM\ManyToOne(inversedBy: 'ratings')]
    private ?User $user = null;





    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStars(): ?int
    {
        return $this->Stars;
    }

    public function setStars(?int $Stars): self
    {
        $this->Stars = $Stars;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->Product;
    }

    public function setProduct(?Product $product): self
    {
        $this->Product = $product;

        return $this;
    }



    public function getRatingDate(): ?\DateTimeInterface
    {
        return $this->RatingDate;
    }

    public function setRatingDate(?\DateTimeInterface $RatingDate): self
    {
        $this->RatingDate = $RatingDate;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $User): self
    {
        $this->user = $User;

        return $this;
    }
}
