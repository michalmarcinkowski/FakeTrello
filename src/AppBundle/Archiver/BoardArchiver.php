<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 17.12.2014
 * Time: 08:47
 */

namespace AppBundle\Archiver;


use AppBundle\Entity\ArchivableInterface;
use AppBundle\Entity\Board;
use AppBundle\Entity\BoardList;

class BoardArchiver implements ArchiverInterface
{
    private $boardListArchiver;

    public function __construct(ArchiverInterface $boardListArchiver)
    {
        $this->boardListArchiver = $boardListArchiver;
    }

    public function archive(ArchivableInterface $archivable)
    {
        if (!($archivable instanceof Board)) {
            throw new \InvalidArgumentException();
        }
        /** @var Board $board */
        $board = $archivable;
        $board->setArchived(true);
//        foreach ($board->getLists() as $list) {
//            $this->boardListArchiver->archive($list);
//        }
    }

    public function unarchive(ArchivableInterface $archivable)
    {
        if (!($archivable instanceof Board)) {
            throw new \InvalidArgumentException();
        }
        /** @var Board $board */
        $board = $archivable;
        $board->setArchived(false);
//        foreach ($board->getLists() as $list) {
//            $this->boardListArchiver->unarchive($list);
//        }
    }
} 