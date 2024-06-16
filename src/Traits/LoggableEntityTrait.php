<?php

namespace App\Traits;

use App\Entity\User;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\UserInterface;

trait LoggableEntityTrait
{
    #[Gedmo\Blameable(on: "create")]
    #[ORM\ManyToOne(targetEntity: "App\Entity\User")]
    #[ORM\JoinColumn(name: "created_by", referencedColumnName: "id")]
    private User|UserInterface $createdBy;

    #[Gedmo\Blameable(on: "update")]
    #[ORM\ManyToOne(targetEntity: "App\Entity\User")]
    #[ORM\JoinColumn(name: "updated_by", referencedColumnName: "id")]
    private User|UserInterface $updatedBy;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $createdAt;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $updatedAt;

    /**
     * Return created by.
     *
     * @return User|UserInterface
     */
    public function getCreatedBy(): User|UserInterface
    {
        return $this->createdBy;
    }

    /**
     * Set created by.
     *
     * @param User|UserInterface $user
     *
     * @return LoggableEntityTrait
     */
    public function setCreatedBy(User|UserInterface $user): static
    {
        $this->createdBy = $user;

        return $this;
    }

    /**
     * Return updated by.
     *
     * @return User|UserInterface
     */
    public function getUpdatedBy(): User|UserInterface
    {
        return $this->updatedBy;
    }

    /**
     * Set updated by.
     *
     * @param User|UserInterface $user
     *
     * @return LoggableEntityTrait
     */
    public function setUpdatedBy(User|UserInterface $user): static
    {
        $this->updatedBy = $user;

        return $this;
    }


    /**
     * Returns createdAt.
     *
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * Sets createdAt.
     *
     * @return $this
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Returns updatedAt.
     *
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt.
     *
     * @return $this
     */
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}