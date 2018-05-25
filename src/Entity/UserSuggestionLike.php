<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserSuggestionLikeRepository")
 * @ORM\HasLifecycleCallbacks
 * @ApiResource(
 *  attributes={
 *    "force_eager"=false,
 *    "normalization_context"={"groups"={"user_suggestion_likeRead"}},
 *    "denormalization_context"={"groups"={"user_suggestion_likeWrite"}},
 *    "access_control"="object.getUser() == user",
 *  },
 *  collectionOperations={
 *    "get"={
 *      "method"="GET",
 *      "normalization_context"={"groups"={"user_suggestion_likeRead"}},
 *      "access_control"="is_granted('ROLE_ADMIN')",
 *      "access_control_message"="Only admins can see all likes."
 *    },
 *    "post"={
 *      "method"="POST",
 *      "access_control_message"="Only owner can add a like."
 *    }
 *  },
 *  itemOperations={
 *    "get"={
 *      "method"="GET",
 *      "normalization_context"={"groups"={"user_suggestion_likeRead"}},
 *      "access_control_message"="Only owner can see a like.",
 *    },
 *    "put"={
 *      "method"="PUT",
 *      "access_control_message"="Only owner can modify a like."
 *    },
 *    "delete"={
 *      "method"="DELETE",
 *      "access_control_message"="Only owner can delete a like."
 *    }
 *  }
 *)
 */
class UserSuggestionLike extends EntityBase
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user_suggestionRead", "user_suggestion_likeRead", "user_suggestion_likeWrite"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userSuggestionsLike")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     *
     * @Groups({"user_suggestion_likeRead", "user_suggestion_likeWrite"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="UserSuggestion", inversedBy="userSuggestionsLike")
     * @ORM\JoinColumn(name="suggestion_id", referencedColumnName="id", nullable=false)
     *
     * @Groups({"user_suggestion_likeRead", "user_suggestion_likeWrite"})
     */
    private $suggestion;

    public function getId()
    {
        return $this->id;
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
