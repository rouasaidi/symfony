<?php

namespace App\Entity;

use App\Repository\DislikeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DislikeRepository::class)]
class Dislike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'dislikes')]
    private ?User $userr = null;

    #[ORM\ManyToOne(inversedBy: 'dislikes')]
    private ?Comment $commentaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserr(): ?User
    {
        return $this->userr;
    }

    public function setUserr(?User $userr): self
    {
        $this->userr = $userr;

        return $this;
    }

    public function getCommentaire(): ?Comment
    {
        return $this->commentaire;
    }

    public function setCommentaire(?Comment $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }
}
