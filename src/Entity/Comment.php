<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'text')]
    private ?string $content = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private User $author;

    #[ORM\ManyToOne(targetEntity: Recipe::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private Recipe $recipe; 

    #[ORM\Column(type: 'boolean')]
    private ?bool $isApproved = false;


    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    public function __construct(){
        $this->createdAt = new \DateTimeImmutable();
    }
        


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of author
     */ 
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set the value of author
     *
     * @return  self
     */ 
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get the value of recipe
     */ 
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Set the value of recipe
     *
     * @return  self
     */ 
    public function setRecipe($recipe)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get the value of isApproved
     */ 
    public function getisApproved()
    {
        return $this->isApproved;
    }

    /**
     * Set the value of isApproved
     *
     * @return  self
     */ 
    public function setisApproved($isApproved)
    {
        $this->isApproved = $isApproved;

        return $this;
    }
    

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
