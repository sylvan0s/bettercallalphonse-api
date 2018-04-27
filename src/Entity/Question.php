<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 * @ApiResource(iri="http://schema.org/Question",
 *              attributes={"order"={"id": "ASC"},
 *                          "normalization_context"={"groups"={"questionRead"}},
 *                          "denormalization_context"={"groups"={"questionWrite"}}
 *                      },
 *              collectionOperations={"get"={"method"="GET"}, "post"={"method"="POST"}},
 *              itemOperations={"get"={"method"="GET"}, "delete"={"method"="DELETE"}, "put"={"method"="PUT"}}
 *     )
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
     * @ApiProperty(iri="http://schema.org/name")
     * @Groups({"questionRead", "questionWrite"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @ApiProperty(iri="http://schema.org/value")
     * @Groups({"questionRead", "questionWrite"})
     */
    private $noteMax;

    /**
    * @ORM\OneToMany(targetEntity="QuestionChoice", mappedBy="question")
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
