<?php

namespace AppBundle\Entity\Traits;

trait ArchivableTrait {
    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $archived = false;

    /**
     * @param bool $archived
     * @return $this
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * @return bool
     */
    public function isArchived()
    {
        return $this->archived;
    }
} 