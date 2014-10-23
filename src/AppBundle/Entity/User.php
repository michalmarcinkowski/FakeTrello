<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Board", mappedBy="user")
     **/
    private $boards;


    public function __construct()
    {
        parent::__construct();
        $this->boards = new ArrayCollection();
    }

    /**
     * @return Collection/Board[]
     */
    public function getBoards()
    {
        return $this->boards;
    }

    /**
     * @param Board $board
     * @return $this
     */
    public function addBoard(Board $board)
    {
        if ($this->hasBoard($board)) {
            return $this;
        }
        $this->boards->add($board);

        return $this;
    }

    /**
     * @param Board $board
     * @return $this
     */
    public function removeBoard(Board $board)
    {
        if ($this->hasBoard($board)) {
            $this->boards->removeElement($board);
        }
        return $this;
    }

    /**
     * @param Board $board
     * @return bool
     */
    public function hasBoard(Board $board)
    {
        return $this->boards->contains($board);
    }
}