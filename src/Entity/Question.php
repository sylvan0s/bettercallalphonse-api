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
 *     attributes={
 *      "normalization_context"={"groups"={"questionRead"}},
 *      "denormalization_context"={"groups"={"questionWrite"}},
 *      "access_control"="is_granted('ROLE_ADMIN')"
 *     },
 *     collectionOperations={
 *      "get"={
 *          "method"="GET",
 *          "normalization_context"={"groups"={"questionChoiceRead"}},
 *          "access_control_message"="Only admins can see All Question."
 *      },
 *      "post"={
 *          "method"="POST",
 *          "access_control_message"="Only admins can add Question."
 *      },
 *     "special2"={
 *          "route_name"="question_special2"
 *      }
 *     },
 *     itemOperations={
 *      "get"={
 *          "method"="GET",
 *          "normalization_context"={"groups"={"questionChoiceRead"}},
 *          "access_control"="is_granted('ROLE_USER')"
 *      },
 *      "put"={
 *          "method"="PUT",
 *          "access_control_message"="Only admins can modify Question."
 *      },
 *      "delete"={
 *          "method"="delete",
 *          "access_control_message"="Only admins can delete Question."
 *      },
 *      "special1"={
 *          "route_name"="question_special1",
 *          "normalization_context"={"groups"={"questionRead", "questionChoiceRead"}}
 *      }
 *     })
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"questionRead", "questionWrite"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"questionRead", "questionWrite"})
     */
    private $noteMax;

    /**
    * @ORM\OneToMany(targetEntity="QuestionChoice", mappedBy="question")
    * @Groups({"questionRead", "questionChoiceRead"})
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
