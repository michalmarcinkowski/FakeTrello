<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 17.12.2014
 * Time: 08:47
 */

namespace AppBundle\Archiver;


use AppBundle\Entity\ArchivableInterface;

class CardArchiver implements ArchiverInterface {

    public function archive(ArchivableInterface $archivable)
    {
        $archivable->setArchived(true);
    }

    public function unarchive(ArchivableInterface $archivable)
    {
        $archivable->setArchived(false);
    }
} 