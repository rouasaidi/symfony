<?php

namespace App\Entity;

use App\Repository\CommentRepository;
<<<<<<< HEAD
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
=======
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
>>>>>>> Dev_masters-3A57/malek

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
<<<<<<< HEAD
    private ?int $useid = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Champ obligatoire")]
    #[Assert\Length(
    min:5,
    max: 300,
    minMessage: 'Le titre doit comporter au moins {{ limit }} caractères',
    maxMessage: 'Le titre ne peut pas dépasser {{ limit }} caractères',)]
    #[Assert\Regex(pattern: '/[a-zA-Z]/')]
    private ?string $content = null;

    
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_cmt = null;
   

    #[ORM\ManyToOne(targetEntity: Article::class, inversedBy: 'comments')]
    private ?Article $article = null;

   

    #[ORM\Column]
    private ?int $nblike = null;

    #[ORM\Column]
    private ?int $nbdislike = null;

    
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'comments')]
=======

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_cmt = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?Article $article = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
>>>>>>> Dev_masters-3A57/malek
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

<<<<<<< HEAD
    public function setContent(?string $content): self
=======
    public function setContent(string $content): static
>>>>>>> Dev_masters-3A57/malek
    {
        $this->content = $content;

        return $this;
    }

    public function getDateCmt(): ?\DateTimeInterface
    {
        return $this->date_cmt;
    }

<<<<<<< HEAD
    public function setDateCmt(?\DateTimeInterface $date_cmt): self
=======
    public function setDateCmt(\DateTimeInterface $date_cmt): static
>>>>>>> Dev_masters-3A57/malek
    {
        $this->date_cmt = $date_cmt;

        return $this;
    }
<<<<<<< HEAD
    public function getNblike(): ?int
    {
        return $this->nblike;
    }

    public function setNblike(int $nblike): self
    {
        $this->nblike = $nblike;

        return $this;
    }

    public function getNbdislike(): ?int
    {
        return $this->nbdislike;
    }

    public function setNbdislike(int $nbdislike): self
    {
        $this->nbdislike = $nbdislike;

        return $this;
    }
=======
>>>>>>> Dev_masters-3A57/malek

    public function getArticle(): ?Article
    {
        return $this->article;
    }

<<<<<<< HEAD
    public function setArticle(?Article $article): self
=======
    public function setArticle(?Article $article): static
>>>>>>> Dev_masters-3A57/malek
    {
        $this->article = $article;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
<<<<<<< HEAD
  

    
    public function setUser(?User $user): self
=======

    public function setUser(?User $user): static
>>>>>>> Dev_masters-3A57/malek
    {
        $this->user = $user;

        return $this;
    }
<<<<<<< HEAD

   
=======
>>>>>>> Dev_masters-3A57/malek
}
