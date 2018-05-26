<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class EntityBase
 * @package App\Entity
 */
abstract class EntityBase
{

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Groups({"user_energy_choiceRead", "user_energy_choiceWrite",
     *          "user_question_choiceRead", "user_question_choiceWrite",
     *          "user_suggestionRead", "user_suggestionWrite",
     *          "user_suggestion_likeRead", "user_suggestion_likeWrite",
     *          "user_suggestion_mega_likeRead", "user_suggestion_mega_likeWrite"
     *          })
     */
    protected $creationDate;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Groups({"user_energy_choiceRead", "user_energy_choiceWrite",
     *          "user_question_choiceRead", "user_question_choiceWrite",
     *          "user_suggestionRead", "user_suggestionWrite",
     *          "user_suggestion_likeRead", "user_suggestion_likeWrite",
     *          "user_suggestion_mega_likeRead", "user_suggestion_mega_likeWrite"
     *          })
     */
    protected $updateDate;

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->updateDate;
    }

    /**
     * Triggered on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->creationDate = new \DateTime("now");
        $this->updateDate = new \DateTime("now");
    }

    /**
     * Triggered on update
     * @ORM\PreUpdate
     */
    public function onUpdate()
    {
        $this->updateDate = new \DateTime("now");
    }
}