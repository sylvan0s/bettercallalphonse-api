<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserQuestionChoiceRepository")
 * @ApiResource(
 *  attributes={
 *    "force_eager"=false,
 *    "normalization_context"={"groups"={"user_question_choice"}},
 *    "denormalization_context"={"groups"={"user_question_choice"}},
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
class UserQuestionChoice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"question", "user_question_choice"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"user_question_choice"})
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userQuestionChoices")
     * @Groups({"user_question_choice"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="QuestionChoice", inversedBy="userQuestionChoices")
     * @Groups({"user_question_choice"})
     */
    private $questionChoice;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="userQuestionChoices")
     * @Groups({"user_question_choice"})
     */
    private $question;

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

    public function getQuestionChoice(): ?QuestionChoice
    {
        return $this->questionChoice;
    }

    public function setQuestionChoice(?QuestionChoice $questionChoice): self
    {
        $this->questionChoice = $questionChoice;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }
}
