<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity('email')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\EntityListeners(['App\EntityListener\UserListener'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $fullName = null;

    #[ORM\Column(length: 50)]
    private ?string $email = null;

    #[ORM\Column(type: Types::JSON)]
    private array $roles = [];

    private ?string $plainPassword = null;

/**
* @var string The hashed password
*/
#[ORM\Column]
#[Assert\NotBlank()]
private ?string $password = 'password';


    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Allergen::class)]
    private Collection $allergens;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Diet::class)]
    private Collection $diets;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Recipe::class)]
    private Collection $recipes;

    #[ORM\Column]
    private ?\DateTime $dateOfBirth = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Mark::class, orphanRemoval: true)]
    private Collection $marks;

    public function __construct()
    {
        $this->allergens = new ArrayCollection();
        $this->diets = new ArrayCollection();
        $this->recipes = new ArrayCollection();
        $this->dateOfBirth = new \DateTime();
        $this->createdAt = new \DateTimeImmutable();
        $this->marks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
/**
* A visual identifier that represents this user.
*
* @see UserInterface
*/
public function getUserIdentifier(): string
{
return (string) $this->email;
}

/**
* @see UserInterface
*/
public function getRoles(): array
{
$roles = $this->roles;
// guarantee every user at least has ROLE_USER
$roles[] = 'ROLE_USER';

return array_unique($roles);
}

public function setRoles(array $roles): self
{
$this->roles = $roles;

return $this;
}

/**
* Get the value of plainPassword
*/
public function getPlainPassword()
{
return $this->plainPassword;
}

/**
* Set the value of plainPassword
*
* @return self
*/
public function setPlainPassword($plainPassword)
{
$this->plainPassword = $plainPassword;

return $this;
}

/**
* @see PasswordAuthenticatedUserInterface
*/
public function getPassword(): string
{
return $this->password;
}

public function setPassword(string $password): self
{
$this->password = $password;

return $this;
}

/**
* @see UserInterface
*/
public function eraseCredentials()
{
// If you store any temporary, sensitive data on the user, clear it here
// $this->plainPassword = null;
}

    /**
     *  @return Collection<int, Allergen>
     */
     
    public function getAllergens(): Collection
    {
        return $this->allergens;
    }

    public function addAllergen(Allergen $allergen): self
    {
        if (!$this->allergens->contains($allergen)) {
            $this->allergens->add($allergen);
            $allergen->setUser($this);
        }

        return $this;
    }

    public function removeAllergen(Allergen $allergen): self
    {
        if ($this->allergens->removeElement($allergen)) {
            // set the owning side to null (unless already changed)
            if ($allergen->getUser() === $this) {
                $allergen->setUser(null);
            }
        }

        return $this;
    }

    /**
     *   @return Collection<int, Diet>
     */
   
     
    public function getDiets(): Collection
    {
        return $this->diets;
    }

    public function addDiet(Diet $diet): self
    {
        if (!$this->diets->contains($diet)) {
            $this->diets->add($diet);
            $diet->setUser($this);
        }

        return $this;
    }

    public function removeDiet(Diet $diet): self
    {
        if ($this->diets->removeElement($diet)) {
            // set the owning side to null (unless already changed)
            if ($diet->getUser() === $this) {
                $diet->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Recipe>
     */
    public function getRecipes(): Collection
    {
        return $this->recipes;
    }

    public function addRecipe(Recipe $recipe): self
    {
        if (!$this->recipes->contains($recipe)) {
            $this->recipes->add($recipe);
            $recipe->setUser($this);
        }

        return $this;
    }

    public function removeRecipe(Recipe $recipe): self
    {
        if ($this->recipes->removeElement($recipe)) {
            // set the owning side to null (unless already changed)
            if ($recipe->getUser() === $this) {
                $recipe->setUser(null);
            }
        }

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getcreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setcreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
   

    /**
     * @return Collection<int, Mark>
     */
    public function getMarks(): Collection
    {
        return $this->marks;
    }

    public function addMark(Mark $mark): self
    {
        if (!$this->marks->contains($mark)) {
            $this->marks->add($mark);
            $mark->setUser($this);
        }

        return $this;
    }

    public function removeMark(Mark $mark): self
    {
        if ($this->marks->removeElement($mark)) {
            // set the owning side to null (unless already changed)
            if ($mark->getUser() === $this) {
                $mark->setUser(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
    return (string) $this->fullName;
    }
}
