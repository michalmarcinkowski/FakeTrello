<?php

namespace AppBundle\Controller;

use AppBundle\Archiver\ArchiverInterface;
use AppBundle\Entity\ArchivableInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArchiveController extends Controller
{
    private $boardArchiver;
    private $boardListArchiver;
    private $cardArchiver;

    public function __construct(ArchiverInterface $boardArchiver, ArchiverInterface $boardListArchiver, ArchiverInterface $cardArchiver)
    {
        $this->boardArchiver = $boardArchiver;
        $this->boardListArchiver = $boardListArchiver;
        $this->cardArchiver = $cardArchiver;
    }

    public function archiveBoardAction(Request $request)
    {
        return $this->archiveEntity($request, $this->get('app.repository.board'), $this->get('app.manager.board'), $this->boardArchiver);
    }

    public function archiveBoardListAction(Request $request)
    {
        return $this->archiveEntity($request, $this->get('app.repository.boardList'), $this->get('app.manager.board_list'), $this->boardListArchiver);
    }

    public function archiveCardAction(Request $request)
    {
        return $this->archiveEntity($request, $this->get('app.repository.card'), $this->get('app.manager.card'), $this->cardArchiver);
    }

    public function unarchiveBoardAction(Request $request)
    {
        return $this->unarchiveEntity($request, $this->get('app.repository.board'), $this->get('app.manager.board'), $this->boardArchiver);
    }

    public function unarchiveBoardListAction(Request $request)
    {
        return $this->unarchiveEntity($request, $this->get('app.repository.boardList'), $this->get('app.manager.board_list'), $this->boardListArchiver);
    }

    public function unarchiveCardAction(Request $request)
    {
        return $this->unarchiveEntity($request, $this->get('app.repository.card'), $this->get('app.manager.card'), $this->cardArchiver);
    }

    private function archiveEntity(Request $request, RepositoryInterface $repository, EntityManagerInterface $entityManager, ArchiverInterface $archiver)
    {
        $entity = $this->getOr404($repository, $request->get('id'));
        if (!($entity instanceof ArchivableInterface)) {
            throw new \InvalidArgumentException();
        }
        $archiver->archive($entity);
        $entityManager->persist($entity);
        $entityManager->flush();
        return (new RedirectResponse($request->headers->get('referer')));
    }

    private function unarchiveEntity(Request $request, RepositoryInterface $repository, EntityManagerInterface $entityManager, ArchiverInterface $archiver)
    {
        $entity = $this->getOr404($repository, $request->get('id'));
        if (!($entity instanceof ArchivableInterface)) {
            throw new \InvalidArgumentException();
        }
        $archiver->unarchive($entity);
        $entityManager->persist($entity);
        $entityManager->flush();
        return (new RedirectResponse($request->headers->get('referer')));
    }

    private function getOr404(RepositoryInterface $repository, $id)
    {
        $object = $repository->find($id);
        if (!empty($object)) {
            return $object;
        }
        $position = strrpos($repository->getClassName(), '\\');
        if (!$position) {
            $position = -1;
        }
        throw new NotFoundHttpException(
            sprintf(
                "Requested %s with id '%d' does not exist.",
                substr($repository->getClassName(), $position + 1),
                $id)
        );
    }
}
