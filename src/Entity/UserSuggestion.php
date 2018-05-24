<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserSuggestionRepository")
 * @ApiResource(
 *  attributes={
 *    "force_eager"=false,
 *    "normalization_context"={"groups"={"user_suggestion"}},
 *    "denormalization_context"={"groups"={"user_suggestion"}},
 *    "access_control"="is_granted('ROLE_COLLAB')"
 *  },
 *  collectionOperations={
 *    "get"={
 *      "method"="GET",
 *      "normalization_context"={"groups"={"user_suggestion"}},
 *      "access_control_message"="Only collab can see all ideas."
 *    },
 *    "post"={
 *      "method"="POST",
 *      "access_control"="object.getUser() == user",
 *      "access_control_message"="Only collab can send an idea."
 *    }
 *  },
 *  itemOperations={
 *    "get"={
 *      "method"="GET",
 *      "normalization_context"={"groups"={"user_suggestion"}},
 *    },
 *    "put"={
 *      "method"="PUT",
 *      "access_control_message"="Only collab can modify an idea."
 *    },
 *    "delete"={
 *      "method"="DELETE",
 *      "access_control_message"="Only collab can delete an idea."
 *    }
 *  }
 *)
 */
class UserSuggestion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user_suggestion", "user_suggestion_like", "user_suggestion_mega_like"})
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"user_suggestion"})
     */
    private $suggestion;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"user_suggestion"})
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userSuggestions")
     * @Groups({"user_suggestion", "user_suggestion_like", "user_suggestion_mega_like"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="UserSuggestionLike", inversedBy="suggestion")
     * @Groups({"user_suggestion"})
     */
    private $userSuggestionsLike;

    /**
     * @ORM\ManyToOne(targetEntity="UserSuggestionMegaLike", inversedBy="suggestion")
     * @Groups({"user_suggestion"})
     */
    private $userSuggestionsMegaLike;

    public function getId()
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

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(?\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

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

    public function getUserSuggestionsLike(): ?UserSuggestionLike
    {
        return $this->userSuggestionsLike;
    }

    public function setUserSuggestionsLike(?UserSuggestionLike $userSuggestionsLike): self
    {
        $this->userSuggestionsLike = $userSuggestionsLike;

        return $this;
    }

    public function getUserSuggestionsMegaLike(): ?UserSuggestionMegaLike
    {
        return $this->userSuggestionsMegaLike;
    }

    public function setUserSuggestionsMegaLike(?UserSuggestionMegaLike $userSuggestionsMegaLike): self
    {
        $this->userSuggestionsMegaLike = $userSuggestionsMegaLike;

        return $this;
    }
}
