<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserSuggestionMegaLikeRepository")
 * @ORM\Table(
 *     uniqueConstraints= {
 *      @ORM\UniqueConstraint(name="user_suggestion_unique", columns={"user_id", "suggestion_id"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks
 * @ApiResource(
 *  attributes={
 *    "force_eager"=false,
 *    "normalization_context"={"groups"={"user_suggestion_mega_likeRead"}},
 *    "denormalization_context"={"groups"={"user_suggestion_mega_likeWrite"}}
 *  },
 *  collectionOperations={
 *    "get"={
 *      "method"="GET",
 *      "normalization_context"={"groups"={"user_suggestion_mega_likeRead"}},
 *      "access_control_message"="Only owner can see all megalikes."
 *    },
 *    "post"={
 *      "method"="POST",
 *      "access_control"="object.getUser() == user",
 *      "access_control_message"="Only owner can add a megalike."
 *    }
 *  },
 *  itemOperations={
 *    "get"={
 *      "method"="GET",
 *      "access_control"="object.getUser() == user",
 *      "normalization_context"={"groups"={"user_suggestion_mega_likeRead"}},
 *      "access_control_message"="Only owner can see a mega like.",
 *    },
 *    "put"={
 *      "method"="PUT",
 *      "access_control"="object.getUser() == user",
 *      "access_control_message"="Only owner can modify a mega like."
 *    },
 *    "delete"={
 *      "method"="DELETE",
 *      "access_control"="object.getUser() == user",
 *      "access_control_message"="Only owner can delete a mega like."
 *    }
 *  }
 *)
 */
class UserSuggestionMegaLike extends EntityBase
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user_suggestionRead", "user_suggestion_mega_likeRead", "user_suggestion_mega_likeWrite", "userRead"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userSuggestionsMegaLike")
     * @Groups({"user_suggestion_mega_likeRead", "user_suggestion_mega_likeWrite"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="UserSuggestion", inversedBy="userSuggestionsMegaLike")
     * @ORM\JoinColumn(name="suggestion_id", referencedColumnName="id", nullable=false)
     * @Groups({"user_suggestion_mega_likeRead", "user_suggestion_mega_likeWrite"})
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
