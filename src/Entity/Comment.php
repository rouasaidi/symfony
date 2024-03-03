<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
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

  
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'comments')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDateCmt(): ?\DateTimeInterface
    {
        return $this->date_cmt;
    }

    public function setDateCmt(?\DateTimeInterface $date_cmt): self
    {
        $this->date_cmt = $date_cmt;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
  

    
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

   
}
