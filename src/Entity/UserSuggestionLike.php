<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserSuggestionLikeRepository")
 * @ApiResource(
 *  attributes={
 *    "force_eager"=false,
 *    "normalization_context"={"groups"={"user_suggestion_likeRead"}},
 *    "denormalization_context"={"groups"={"user_suggestion_likeWrite"}},
 *    "access_control"="is_granted('ROLE_ADMIN')"
 *  },
 *  collectionOperations={
 *    "get"={
 *      "method"="GET",
 *      "normalization_context"={"groups"={"user_suggestion_likeRead"}},
 *      "access_control_message"="Only collab can see all likes."
 *    },
 *    "post"={
 *      "method"="POST",
 *      "access_control"="object.getUser() == user",
 *      "access_control_message"="Only collab can add a like."
 *    }
 *  },
 *  itemOperations={
 *    "get"={
 *      "method"="GET",
 *      "normalization_context"={"groups"={"user_suggestion_likeRead"}},
 *    },
 *    "put"={
 *      "method"="PUT",
 *      "access_control_message"="Only collab can modify a like."
 *    },
 *    "delete"={
 *      "method"="DELETE",
 *      "access_control_message"="Only collab can delete a like."
 *    }
 *  }
 *)
 */
class UserSuggestionLike
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user_suggestion_likeRead", "user_suggestion_likeWrite"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"user_suggestion_likeRead", "user_suggestion_likeWrite"})
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userSuggestionsLike")
     * @Groups({"user_suggestion_likeRead"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="UserSuggestion", inversedBy="userSuggestionsLike")
     * @Groups({"user_suggestion_likeRead"})
     */
    private $suggestion;

    public function getId()
    {
        return $this->id;
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

    public function getSuggestion(): ?UserSuggestion
    {
        return $this->suggestion;
    }

    public function setSuggestion(?UserSuggestion $suggestion): self
    {
        $this->suggestion = $suggestion;

        return $this;
    }
}
