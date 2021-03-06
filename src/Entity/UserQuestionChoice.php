<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserQuestionChoiceRepository")
 * @ORM\HasLifecycleCallbacks
 * @ApiResource(
 *  attributes={
 *    "force_eager"=false,
 *    "normalization_context"={"groups"={"user_question_choiceRead", "my_user_question_choiceRead", "collabs_user_question_choiceRead"}},
 *    "denormalization_context"={"groups"={"user_question_choiceWrite"}},
 *    "order"={"user.username": "ASC", "creationDate": "ASC"}
 *  },
 *  collectionOperations={
 *    "get"={
 *      "method"="GET",
 *      "access_control"="is_granted('ROLE_ADMIN')",
 *      "normalization_context"={"groups"={"user_question_choiceRead"}},
 *      "access_control_message"="Only admns can see all user question choices."
 *    },
 *    "my"={
 *      "method"="GET",
 *      "path"="my/user_question_choices.{_format}",
 *      "normalization_context"={"groups"={"my_user_question_choiceRead"}},
 *      "access_control_message"="Only admins can see all user question choices."
 *    },
 *    "collabs"={
 *      "method"="GET",
 *      "path"="collabs/user_question_choices.{_format}",
 *      "normalization_context"={"groups"={"collabs_user_question_choiceRead"}},
 *      "access_control_message"="Only admins can see all user question choices."
 *    },
 *    "post"={
 *      "method"="POST",
 *      "access_control"="object.getUser() == user",
 *      "access_control_message"="Only owner can post an user question choice."
 *    },
 *    "api_choices_grouped_by_id_question"={
 *      "route_name"="api_choices_grouped_by_id_question"
 *    }
 *  },
 *  itemOperations={
 *    "get"={
 *      "method"="GET",
 *      "access_control"="object.getUser() == user",
 *      "normalization_context"={"groups"={"user_question_choiceRead"}},
 *      "access_control_message"="Only owner can see an user question choice.",
 *    },
 *    "put"={
 *      "method"="PUT",
 *      "access_control"="object.getUser() == user",
 *      "access_control_message"="Only owners can modify an user question choice."
 *    },
 *    "delete"={
 *      "method"="DELETE",
 *      "access_control"="is_granted('ROLE_ADMIN')",
 *      "access_control_message"="Only admins can delete an user question choice."
 *    }
 *  }
 *)
 */
class UserQuestionChoice extends EntityBase
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"questionRead", "user_question_choiceRead",
     *     "user_question_choiceWrite", "userRead", "my_user_question_choiceRead"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userQuestionChoices")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @Groups({"user_question_choiceRead", "user_question_choiceWrite", "collabs_user_question_choiceRead"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="QuestionChoice", inversedBy="userQuestionChoices")
     * @ORM\JoinColumn(name="question_choice_id", referencedColumnName="id", nullable=false)
     * @Groups({"my_user_question_choiceRead", "collabs_user_question_choiceRead", "user_question_choiceRead",
     *     "user_question_choiceWrite"})
     */
    private $questionChoice;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="userQuestionChoices")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id", nullable=false)
     * @Groups({"user_question_choiceRead", "user_question_choiceWrite", "my_user_question_choiceRead", "collabs_user_question_choiceRead"})
     */
    private $question;

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
