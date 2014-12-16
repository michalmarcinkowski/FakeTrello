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
     * @ORM\ManyToMany(targetEntity="Organization", mappedBy="members")
     * @var Collection
     **/
    private $organizations;

    /**
     * @ORM\OneToMany(targetEntity="Board", mappedBy="user")
     **/
    private $boards;

    /**
     * @ORM\ManyToMany(targetEntity="Board", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="users_starredboards",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="starredboard_id", referencedColumnName="id", unique=true, onDelete="CASCADE")})
     **/
    private $starredBoards;

    public function __construct()
    {
        parent::__construct();
        $this->boards = new ArrayCollection();
        $this->starredBoards = new ArrayCollection();
    }

    /**
     * @return Collection
     */
    public function getOrganizations()
    {
        return $this->organizations;
    }

    /**
     * @param  Organization $organization
     * @return $this
     */
    public function addOrganization(Organization $organization)
    {
        if ($this->hasOrganization($organization)) {
            return $this;
        }
        $this->organizations->add($organization);

        return $this;
    }

    /**
     * @param  Organization $organization
     * @return $this
     */
    public function removeOrganization(Organization $organization)
    {
        if ($this->hasOrganization($organization)) {
            $this->organizations->removeElement($organization);
        }

        return $this;
    }

    /**
     * @param  Organization $organization
     * @return bool
     */
    public function hasOrganization(Organization $organization)
    {
        return $this->organizations->contains($organization);
    }

    /**
     * @return Collection/Board[]
     */
    public function getBoards()
    {
        return $this->boards;
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

    /**
     * @return Collection/Board[]
     */
    public function getStarredBoards()
    {
        return $this->starredBoards;
    }

    /**
     * @param  Board $board
     * @return $this
     */
    public function addStarredBoard(Board $board)
    {
        if ($this->hasStarredBoard($board)) {
            return $this;
        }
        $this->starredBoards->add($board);

        return $this;
    }

    /**
     * @param  Board $board
     * @return $this
     */
    public function removeStarredBoard(Board $board)
    {
        if ($this->hasStarredBoard($board)) {
            $this->starredBoards->removeElement($board);
        }

        return $this;
    }

    /**
     * @param  Board $board
     * @return bool
     */
    public function hasStarredBoard(Board $board)
    {
        return $this->starredBoards->contains($board);
    }
}
