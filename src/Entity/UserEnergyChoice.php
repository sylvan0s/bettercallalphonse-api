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
 *    "normalization_context"={"groups"={"user_energy_choice"}},
 *    "denormalization_context"={"groups"={"user_energy_choice"}},
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
class UserEnergyChoice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user_energy_choice"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"user_energy_choice"})
     */
    private $note;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"user_energy_choice"})
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userEnergyChoices")
     * @Groups({"user_energy_choice"})
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
