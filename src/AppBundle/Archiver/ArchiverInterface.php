<?php

namespace AppBundle\Archiver;

use AppBundle\Entity\ArchivableInterface;

interface ArchiverInterface {
    public function archive(ArchivableInterface $archivable);
    public function unarchive(ArchivableInterface $archivable);
}