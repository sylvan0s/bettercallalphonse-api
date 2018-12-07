<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserSuggestionRepository")
 * @ORM\HasLifecycleCallbacks
 * @ApiResource(
 *  attributes={
 *    "force_eager"=false,
 *    "normalization_context"={"groups"={"user_suggestionRead"}},
 *    "denormalization_context"={"groups"={"user_suggestionWrite"}}
 *  },
 *  collectionOperations={
 *    "get"={
 *      "method"="GET",
 *      "normalization_context"={"groups"={"user_suggestionRead"}},
 *      "access_control_message"="Only owner can see all ideas."
 *    },
 *    "post"={
 *      "method"="POST",
 *      "access_control"="object.getUser() == user",
 *      "access_control_message"="Only owner can send an idea."
 *    }
 *  },
 *  itemOperations={
 *    "get"={
 *      "method"="GET",
 *      "normalization_context"={"groups"={"user_suggestionRead"}},
 *      "access_control_message"="Only owner can see an idea.",
 *    },
 *    "delete"={
 *      "method"="DELETE",
 *      "access_control"="is_granted('ROLE_ADMIN')",
 *      "access_control_message"="Only admins can delete an idea."
 *    }
 *  }
 *)
 */
class UserSuggestion extends EntityBase
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user_suggestionRead", "user_suggestionWrite", "userRead", "user_suggestion_likeRead", "user_suggestion_mega_likeRead"})
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=false)
     * @Groups({"user_suggestionRead", "user_suggestionWrite"})
     */
    private $suggestion;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userSuggestions")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @Groups({"user_suggestionRead", "user_suggestionWrite", "user_suggestion_likeRead", "user_suggestion_mega_likeRead"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="UserSuggestionLike", mappedBy="suggestion")
     * @Groups({"user_suggestionRead"})
     */
    private $userSuggestionsLike;

    /**
     * @ORM\OneToMany(targetEntity="UserSuggestionMegaLike", mappedBy="suggestion")
     * @Groups({"user_suggestionRead"})
     */
    private $userSuggestionsMegaLike;

    public function __construct()
    {
        $this->userSuggestionsLike = new ArrayCollection();
        $this->userSuggestionsMegaLike = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSuggestion(): ?string
    {
        return $this->suggestion;
    }

    public function setSuggestion(?string $suggestion): self
    {
        $this->suggestion = $suggestion;

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
            $userSuggestionsLike->setSuggestion($this);
        }

        return $this;
    }

    public function removeUserSuggestionsLike(UserSuggestionLike $userSuggestionsLike): self
    {
        if ($this->userSuggestionsLike->contains($userSuggestionsLike)) {
            $this->userSuggestionsLike->removeElement($userSuggestionsLike);
            // set the owning side to null (unless already changed)
            if ($userSuggestionsLike->getSuggestion() === $this) {
                $userSuggestionsLike->setSuggestion(null);
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
            $userSuggestionsMegaLike->setSuggestion($this);
        }

        return $this;
    }

    public function removeUserSuggestionsMegaLike(UserSuggestionMegaLike $userSuggestionsMegaLike): self
    {
        if ($this->userSuggestionsMegaLike->contains($userSuggestionsMegaLike)) {
            $this->userSuggestionsMegaLike->removeElement($userSuggestionsMegaLike);
            // set the owning side to null (unless already changed)
            if ($userSuggestionsMegaLike->getSuggestion() === $this) {
                $userSuggestionsMegaLike->setSuggestion(null);
            }
        }

        return $this;
    }

}
