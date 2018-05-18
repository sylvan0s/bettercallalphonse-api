<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionChoiceRepository")
 * @ApiResource(
 *  attributes={
 *    "normalization_context"={"groups"={"question_choice"}},
 *    "denormalization_context"={"groups"={"question_choice"}},
 *    "access_control"="is_granted('ROLE_ADMIN')"
 *  }
 *)
 */
class QuestionChoice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"question", "question_choice", "user_question_choice"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"question", "question_choice", "user_question_choice"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"question", "question_choice", "user_question_choice"})
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="questionChoices")
     * @Groups({"question_choice"})
     */
    private $question;

    public function getId()
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
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
