<?php

namespace AppBundle\Entity;

interface ArchivableInterface {
    /**
     * @param bool $archived
     * @return $this
     */
    public function setArchived($archived);

    /**
     * @return bool
     */
    public function isArchived();
} 