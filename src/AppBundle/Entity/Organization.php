<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="organization")
 */
class Organization
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="organizations")
     * @ORM\JoinTable(name="organization_members")
     * @var Collection
     **/
    private $members;

    /**
     * @ORM\OneToMany(targetEntity="Board", mappedBy="organization", cascade="remove")
     **/
    private $boards;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->boards = new ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param  string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Collection
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * @param  User $member
     * @return $this
     */
    public function addMember(User $member)
    {
        if ($this->hasMember($member)) {
            return $this;
        }
        $this->members->add($member);

        return $this;
    }

    /**
     * @param  User $member
     * @return $this
     */
    public function removeMember(User $member)
    {
        if ($this->hasMember($member)) {
            $this->members->removeElement($member);
        }

        return $this;
    }

    /**
     * @param  User $member
     * @return bool
     */
    public function hasMember(User $member)
    {
        return $this->members->contains($member);
    }

    /**
     * @return Collection/Board[]
     */
    public function getBoards()
    {
        return $this->boards;
    }

    /**
     * @return Collection/Board[]
     */
    public function getAvailableBoards()
    {
        $availableBoards = array();
        foreach ($this->boards as $board) {
            if ($board->isArchived()) {
                continue;
            }
            $availableBoards[] = $board;
        }
        return $availableBoards;
    }

    /**
     * @return Collection/Board[]
     */
    public function getArchivedBoards()
    {
        $archivedBoards = array();
        foreach ($this->boards as $board) {
            if ($board->isArchived()) {
                $archivedBoards[] = $board;
            }
        }
        return $archivedBoards;
    }

    /**
     * @param  Board $board
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
     * @param  Board $board
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
     * @param  Board $board
     * @return bool
     */
    public function hasBoard(Board $board)
    {
        return $this->boards->contains($board);
    }

    public function __toString()
    {
        return $this->name;
    }
}
