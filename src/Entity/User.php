<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use FOS\UserBundle\Model\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ApiResource(
 *  attributes={
 *    "force_eager"=false,
 *    "normalization_context"={"groups"={"userRead"}},
 *    "denormalization_context"={"groups"={"userWrite"}},
 *    "access_control"="is_granted('ROLE_ADMIN')"
 *  },
 *  collectionOperations={
 *    "get"={
 *      "method"="GET",
 *      "normalization_context"={"groups"={"userRead"}},
 *      "access_control_message"="Only admins can see all users."
 *    },
 *    "post"={
 *      "method"="POST",
 *      "access_control_message"="Only admins can create users."
 *    }
 *  },
 *  itemOperations={
 *    "get"={
 *      "method"="GET",
 *      "normalization_context"={"groups"={"userRead"}},
 *      "access_control_message"="Only admins can see user."
 *    },
 *    "put"={
 *      "method"="PUT",
 *      "access_control_message"="Only admins can modify an user."
 *    },
 *    "delete"={
 *      "method"="DELETE",
 *      "access_control_message"="Only admins can delete an user."
 *    }
 *  }
 *)
 */
class User extends BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"userRead", "user_question_choiceRead", "user_energy_choiceRead", "user_suggestionRead", "user_suggestion_likeRead", "user_suggestion_mega_likeRead"})
     */
    protected $id;

    /**
     * @Groups({"userRead", "user_suggestionRead", "user_question_choiceRead"})
     */
    protected $username;

    /**
     * @Groups({"userRead"})
     */
    protected $email;

    /**
     * @Groups({"userRead"})
     */
    protected $roles;

    /**
     * @Groups({"userRead"})
     */
    protected $lastLogin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"userRead", "userWrite"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"userRead", "userWrite"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"userRead", "userWrite"})
     */
    private $birthdate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"userRead", "userWrite"})
     */
    private $dateEntry;

    /**
    * @ORM\OneToMany(targetEntity="UserQuestionChoice", mappedBy="user")
    * @Groups({"userRead"})
    */
    private $userQuestionChoices;

    /**
    * @ORM\OneToMany(targetEntity="UserEnergyChoice", mappedBy="user")
    * @Groups({"userRead"})
    */
    private $userEnergyChoices;

    /**
    * @ORM\OneToMany(targetEntity="UserSuggestion", mappedBy="user")
    * @Groups({"userRead"})
    */
    private $userSuggestions;

    /**
    * @ORM\OneToMany(targetEntity="UserSuggestionLike", mappedBy="user")
    * @Groups({"userRead"})
    */
    private $userSuggestionsLike;

    /**
     * @ORM\OneToMany(targetEntity="UserSuggestionMegaLike", mappedBy="user")
     * @Groups({"userRead"})
     */
    private $userSuggestionsMegaLike;

    public function __construct()
    {
        parent::__construct();
        $this->userQuestionchoices = new ArrayCollection();
        $this->userQuestionChoices = new ArrayCollection();
        $this->userEnergyChoices = new ArrayCollection();
        $this->userSuggestions = new ArrayCollection();
        $this->userSuggestionsLike = new ArrayCollection();
        $this->userSuggestionsMegaLike = new ArrayCollection();
        // your own logic
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getDateEntry(): ?\DateTimeInterface
    {
        return $this->dateEntry;
    }

    public function setDateEntry(?\DateTimeInterface $dateEntry): self
    {
        $this->dateEntry = $dateEntry;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|UserQuestionChoice[]
     */
    public function getUserQuestionChoices(): Collection
    {
        return $this->userQuestionChoices;
    }

    public function addUserQuestionChoice(UserQuestionChoice $userQuestionChoice): self
    {
        if (!$this->userQuestionChoices->contains($userQuestionChoice)) {
            $this->userQuestionChoices[] = $userQuestionChoice;
            $userQuestionChoice->setUser($this);
        }

        return $this;
    }

    public function removeUserQuestionChoice(UserQuestionChoice $userQuestionChoice): self
    {
        if ($this->userQuestionChoices->contains($userQuestionChoice)) {
            $this->userQuestionChoices->removeElement($userQuestionChoice);
            // set the owning side to null (unless already changed)
            if ($userQuestionChoice->getUser() === $this) {
                $userQuestionChoice->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserEnergyChoice[]
     */
    public function getUserEnergyChoices(): Collection
    {
        return $this->userEnergyChoices;
    }

    public function addUserEnergyChoice(UserEnergyChoice $userEnergyChoice): self
    {
        if (!$this->userEnergyChoices->contains($userEnergyChoice)) {
            $this->userEnergyChoices[] = $userEnergyChoice;
            $userEnergyChoice->setUser($this);
        }

        return $this;
    }

    public function removeUserEnergyChoice(UserEnergyChoice $userEnergyChoice): self
    {
        if ($this->userEnergyChoices->contains($userEnergyChoice)) {
            $this->userEnergyChoices->removeElement($userEnergyChoice);
            // set the owning side to null (unless already changed)
            if ($userEnergyChoice->getUser() === $this) {
                $userEnergyChoice->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserSuggestion[]
     */
    public function getUserSuggestions(): Collection
    {
        return $this->userSuggestions;
    }

    public function addUserSuggestion(UserSuggestion $userSuggestion): self
    {
        if (!$this->userSuggestions->contains($userSuggestion)) {
            $this->userSuggestions[] = $userSuggestion;
            $userSuggestion->setUser($this);
        }

        return $this;
    }

    public function removeUserSuggestion(UserSuggestion $userSuggestion): self
    {
        if ($this->userSuggestions->contains($userSuggestion)) {
            $this->userSuggestions->removeElement($userSuggestion);
            // set the owning side to null (unless already changed)
            if ($userSuggestion->getUser() === $this) {
                $userSuggestion->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserSuggestionLike[]
     */
    public function getUserSuggestionsLike(): Collection
    {
        return $this->userSuggestionsLike;
    }

    public function addUserSuggestionsLike(UserSuggestionLike $userSuggestionsLike): self
    {
        if (!$this->userSuggestionsLike->contains($userSuggestionsLike)) {
            $this->userSuggestionsLike[] = $userSuggestionsLike;
            $userSuggestionsLike->setUser($this);
        }

        return $this;
    }

    public function removeUserSuggestionsLike(UserSuggestionLike $userSuggestionsLike): self
    {
        if ($this->userSuggestionsLike->contains($userSuggestionsLike)) {
            $this->userSuggestionsLike->removeElement($userSuggestionsLike);
            // set the owning side to null (unless already changed)
            if ($userSuggestionsLike->getUser() === $this) {
                $userSuggestionsLike->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserSuggestionMegaLike[]
     */
    public function getUserSuggestionsMegaLike(): Collection
    {
        return $this->userSuggestionsMegaLike;
    }

    public function addUserSuggestionsMegaLike(UserSuggestionMegaLike $userSuggestionsMegaLike): self
    {
        if (!$this->userSuggestionsMegaLike->contains($userSuggestionsMegaLike)) {
            $this->userSuggestionsMegaLike[] = $userSuggestionsMegaLike;
            $userSuggestionsMegaLike->setUser($this);
        }

        return $this;
    }

    public function removeUserSuggestionsMegaLike(UserSuggestionMegaLike $userSuggestionsMegaLike): self
    {
        if ($this->userSuggestionsMegaLike->contains($userSuggestionsMegaLike)) {
            $this->userSuggestionsMegaLike->removeElement($userSuggestionsMegaLike);
            // set the owning side to null (unless already changed)
            if ($userSuggestionsMegaLike->getUser() === $this) {
                $userSuggestionsMegaLike->setUser(null);
            }
        }

        return $this;
    }
}
