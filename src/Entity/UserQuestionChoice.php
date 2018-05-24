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
 *    "normalization_context"={"groups"={"user_question_choiceRead"}},
 *    "denormalization_context"={"groups"={"user_question_choiceWrite"}},
 *    "access_control"="is_granted('ROLE_ADMIN')",
 *    "order"={"user.username": "ASC", "creationDate": "ASC"}
 *  },
 *  collectionOperations={
 *    "get"={
 *      "method"="GET",
 *      "normalization_context"={"groups"={"user_question_choiceRead"}},
 *      "access_control_message"="Only collab can see all user question choices."
 *    },
 *    "post"={
 *      "method"="POST",
 *      "access_control"="object.getUser() == user",
 *      "access_control_message"="Only collab can post an user question choice."
 *    }
 *  },
 *  itemOperations={
 *    "get"={
 *      "method"="GET",
 *      "normalization_context"={"groups"={"user_question_choiceRead"}},
 *    },
 *    "put"={
 *      "method"="PUT",
 *      "access_control_message"="Only collab can modify an user question choice."
 *    },
 *    "delete"={
 *      "method"="DELETE",
 *      "access_control_message"="Only collab can delete an user question choice."
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
     * @Groups({"questionRead", "user_question_choiceRead", "user_question_choiceWrite"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"user_question_choiceRead", "user_question_choiceWrite"})
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userQuestionChoices")
     * @Groups({"user_question_choiceRead"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="QuestionChoice", inversedBy="userQuestionChoices")
     * @Groups({"user_question_choiceRead"})
     */
    private $questionChoice;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="userQuestionChoices")
     * @Groups({"user_question_choiceRead"})
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
