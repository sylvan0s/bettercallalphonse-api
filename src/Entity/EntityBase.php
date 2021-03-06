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
    const PERIODICITY_0_DAY = 'P0D';
    const PERIODICITY_7_DAY = 'P7D';
    const PERIODICITY_10_DAY = 'P10D';
    const PERIODICITY_3_MONTH = 'P3M';
    const PERIODICITY_6_MONTH = 'P6M';
    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Groups({"user_energy_choiceRead",
     *          "user_question_choiceRead",
     *          "user_suggestionRead",
     *          "user_suggestion_likeRead",
     *          "user_suggestion_mega_likeRead",
     *          "my_user_question_choiceRead",
     *          "collabs_user_question_choiceRead"
     *          })
     */
    protected $creationDate;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Groups({"user_energy_choiceRead",
     *          "user_question_choiceRead",
     *          "user_suggestionRead",
     *          "user_suggestion_likeRead",
     *          "user_suggestion_mega_likeRead",
     *          "my_user_question_choiceRead",
     *          "collabs_user_question_choiceRead"
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
