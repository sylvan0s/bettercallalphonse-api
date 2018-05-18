<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserSuggestionMegaLikeRepository")
 * @ApiResource(
 *  attributes={
 *    "force_eager"=false,
 *    "normalization_context"={"groups"={"user_suggestion_mega_like"}},
 *    "denormalization_context"={"groups"={"user_suggestion_mega_like"}},
 *    "access_control"="is_granted('ROLE_ADMIN')"
 *  },
 *  collectionOperations={
 *    "get",
 *    "post"={
 *      "method"="POST",
 *      "access_control"="object.getUser() == user"
 *    }
 *  }
 *)
 */
class UserSuggestionMegaLike
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user_suggestion_mega_like"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"user_suggestion_mega_like"})
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userSuggestionsMegaLike")
     * @Groups({"user_suggestion_mega_like"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="UserSuggestion", inversedBy="userSuggestionsMegaLike")
     * @Groups({"user_suggestion_mega_like"})
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
