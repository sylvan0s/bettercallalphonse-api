<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserEnergyChoiceRepository")
 * @ORM\HasLifecycleCallbacks
 * @ApiResource(
 *  attributes={
 *     "force_eager"=false,
 *     "normalization_context"={"groups"={"user_energy_choiceRead"}},
 *     "denormalization_context"={"groups"={"user_energy_choiceWrite"}},
 *     "access_control"="object.getUser() == user",
 *  },
 *  collectionOperations={
 *    "get"={
 *      "method"="GET",
 *      "normalization_context"={"groups"={"user_energy_choiceRead"}},
 *      "access_control"="is_granted('ROLE_ADMIN')",
 *      "access_control_message"="Only admins can see all user energy choices."
 *    },
 *    "post"={
 *      "method"="POST",
 *      "access_control_message"="Only owner can add an user energy choice.",
 *    }
 *  },
 *  itemOperations={
 *    "get"={
 *      "method"="GET",
 *      "normalization_context"={"groups"={"user_energy_choiceRead"}},
 *      "access_control_message"="Only owner can see an user energy choice.",
 *    },
 *    "put"={
 *      "method"="PUT",
 *      "access_control_message"="Only owner can modify an user energy choice.",
 *    }
 *  }
 *)
 */
class UserEnergyChoice extends EntityBase
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user_energy_choiceRead", "user_energy_choiceWrite"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\Range(
     *     min = 0,
     *     max = 10,
     *     minMessage = "You must enter at least {{ limit }}",
     *     maxMessage = "You can not have a higher value {{ limit }}"
     * )
     * @Groups({"user_energy_choiceRead", "user_energy_choiceWrite"})
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userEnergyChoices")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
<<<<<<< HEAD
     * 
=======
>>>>>>> Corrections and Optimisations
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
