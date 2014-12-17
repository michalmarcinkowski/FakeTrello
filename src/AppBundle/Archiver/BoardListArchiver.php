<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 17.12.2014
 * Time: 08:47
 */

namespace AppBundle\Archiver;


use AppBundle\Entity\ArchivableInterface;
use AppBundle\Entity\BoardList;

class BoardListArchiver implements ArchiverInterface
{
    private $cardArchiver;

    public function __construct(ArchiverInterface $cardArchiver)
    {
        $this->cardArchiver = $cardArchiver;
    }

    public function archive(ArchivableInterface $archivable)
    {
        if (!($archivable instanceof BoardList)) {
            throw new \InvalidArgumentException();
        }
        /** @var BoardList $boardList */
        $boardList = $archivable;
        $boardList->setArchived(true);
        foreach ($boardList->getCards() as $card) {
            $this->cardArchiver->archive($card);
        }
    }

    public function unarchive(ArchivableInterface $archivable)
    {
        if (!($archivable instanceof BoardList)) {
            throw new \InvalidArgumentException();
        }
        /** @var BoardList $boardList */
        $boardList = $archivable;
        $boardList->setArchived(false);
        foreach ($boardList->getCards() as $card) {
            $this->cardArchiver->unarchive($card);
        }
    }
} 