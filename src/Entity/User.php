<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ApiResource
 */
class User extends BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user_question_choice"})
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthdate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateEntry;

    /**
    * @ORM\OneToMany(targetEntity="UserQuestionChoice", mappedBy="user")
    */
    private $userQuestionchoices;

    public function __construct()
    {
        parent::__construct();
        $this->userQuestionchoices = new ArrayCollection();
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
    public function getUserQuestionchoices(): Collection
    {
        return $this->userQuestionchoices;
    }

    public function addUserQuestionchoice(UserQuestionChoice $userQuestionchoice): self
    {
        if (!$this->userQuestionchoices->contains($userQuestionchoice)) {
            $this->userQuestionchoices[] = $userQuestionchoice;
            $userQuestionchoice->setUser($this);
        }

        return $this;
    }

    public function removeUserQuestionchoice(UserQuestionChoice $userQuestionchoice): self
    {
        if ($this->userQuestionchoices->contains($userQuestionchoice)) {
            $this->userQuestionchoices->removeElement($userQuestionchoice);
            // set the owning side to null (unless already changed)
            if ($userQuestionchoice->getUser() === $this) {
                $userQuestionchoice->setUser(null);
            }
        }

        return $this;
    }
}
