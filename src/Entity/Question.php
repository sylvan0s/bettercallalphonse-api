<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 * @ApiResource(
 *  attributes={
 *    "normalization_context"={"groups"={"question"}},
 *    "denormalization_context"={"groups"={"question"}},
 *    "access_control"="is_granted('ROLE_COLLAB')"
 *  }
 *)
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"question", "user_question_choice"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"question", "user_question_choice"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"question", "user_question_choice"})
     */
    private $noteMax;

    /**
    * @ORM\OneToMany(targetEntity="QuestionChoice", mappedBy="question")
    * @Groups({"question"})
    */
    private $questionChoices;

    public function __construct()
    {
        $this->questionChoices = new ArrayCollection();
    }

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

    public function getNoteMax(): ?int
    {
        return $this->noteMax;
    }

    public function setNoteMax(?int $noteMax): self
    {
        $this->noteMax = $noteMax;

        return $this;
    }

    /**
     * @return Collection|QuestionChoice[]
     */
    public function getQuestionChoices(): Collection
    {
        return $this->questionChoices;
    }

    public function addQuestionChoice(QuestionChoice $questionChoice): self
    {
        if (!$this->questionChoices->contains($questionChoice)) {
            $this->questionChoices[] = $questionChoice;
            $questionChoice->setQuestion($this);
        }

        return $this;
    }

    public function removeQuestionChoice(QuestionChoice $questionChoice): self
    {
        if ($this->questionChoices->contains($questionChoice)) {
            $this->questionChoices->removeElement($questionChoice);
            // set the owning side to null (unless already changed)
            if ($questionChoice->getQuestion() === $this) {
                $questionChoice->setQuestion(null);
            }
        }

        return $this;
    }
}
