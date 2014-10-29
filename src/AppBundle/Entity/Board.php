<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="board")
 */
class Board
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="boards")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="BoardList", mappedBy="board")
     * @var Collection/BoardList[]
     **/
    private $lists;

    public function __construct()
    {
        $this->lists = new ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param User $user
     * @return User
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $name
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
     * @param BoardList $list
     * @return $this
     */
    public function addList(BoardList $list)
    {
        if ($this->hasList($list)) {
            return $this;
        }
        $this->lists->add($list);

        return $this;
    }

    /**
     * @param BoardList $list
     * @return $this
     */
    public function removeList(BoardList $list)
    {
        if ($this->hasList($list)) {
            $this->lists->removeElement($list);
        }

        return $this;
    }

    /**
     * @param BoardList $list
     * @return bool
     */
    public function hasList(BoardList $list)
    {
        return $this->lists->contains($list);
    }

    /**
     * @return Collection/BoardList[]
     */
    public function getLists()
    {
        return $this->lists;
    }

    public function __toString() {
        return $this->name;
    }
}