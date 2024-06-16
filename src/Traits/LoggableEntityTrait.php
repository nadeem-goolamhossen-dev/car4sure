<?php

namespace App\Traits;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait LoggableEntityTrait
{
    #[Gedmo\Blameable(on: "create")]
    #[ORM\ManyToOne(targetEntity: "App\Entity\User")]
    #[ORM\JoinColumn(name: "created_by", referencedColumnName: "id")]
    private User $createdBy;

    #[Gedmo\Blameable(on: "update")]
    #[ORM\ManyToOne(targetEntity: "App\Entity\User")]
    #[ORM\JoinColumn(name: "updated_by", referencedColumnName: "id")]
    private User $updatedBy;

    /**
     * Return created by.
     *
     * @return User
     */
    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    /**
     * Set created by.
     *
     * @param User $user
     *
     * @return LoggableEntityTrait
     */
    public function setCreatedBy(User $user): static
    {
        $this->createdBy = $user;

        return $this;
    }

    /**
     * Return updated by.
     *
     * @return User
     */
    public function getUpdatedBy(): User
    {
        return $this->updatedBy;
    }

    /**
     * Set updated by.
     *
     * @param User $user
     *
     * @return LoggableEntityTrait
     */
    public function setUpdatedBy(User $user): static
    {
        $this->updatedBy = $user;

        return $this;
    }
}