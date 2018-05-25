<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserEnergyChoiceRepository")
 * @ApiResource(
 *  attributes={
 *    "force_eager"=false,
 *    "normalization_context"={"groups"={"user_energy_choiceRead"}},
 *    "denormalization_context"={"groups"={"user_energy_choiceWrite"}},
 *    "access_control"="is_granted('ROLE_ADMIN')"
 *  },
 *  collectionOperations={
 *    "get"={
 *      "method"="GET",
 *      "normalization_context"={"groups"={"user_energy_choiceRead"}},
 *      "access_control_message"="Only collab can see all user energy choices."
 *    },
 *    "post"={
 *      "method"="POST",
 *      "access_control"="object.getUser() == user"
 *    }
 *  },
 *  itemOperations={
 *    "get"={
 *      "method"="GET",
 *      "normalization_context"={"groups"={"user_energy_choiceRead"}},
 *    },
 *    "put"={
 *      "method"="PUT",
 *      "access_control_message"="Only collab can modify an user energy choice."
 *    },
 *    "delete"={
 *      "method"="DELETE",
 *      "access_control_message"="Only collab can delete an user energy choice."
 *    }
 *  }
 *)
 */
class UserEnergyChoice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user_energy_choiceRead", "user_energy_choiceWrite"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"user_energy_choiceRead", "user_energy_choiceWrite"})
     */
    private $note;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"user_energy_choiceRead", "user_energy_choiceWrite"})
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userEnergyChoices")
     * @Groups({"user_energy_choiceRead", "user_energy_choiceWrite"})
     */
    private $user;

    public function getId()
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

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
}
