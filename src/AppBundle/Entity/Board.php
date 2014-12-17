<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\ArchivableTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="board")
 */
class Board implements ArchivableInterface
{
    use ArchivableTrait;
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
     * @ORM\ManyToOne(targetEntity="Organization", inversedBy="boards")
     * @ORM\JoinColumn(name="organization_id", referencedColumnName="id")
     **/
    private $organization;

    /**
     * @ORM\OneToMany(targetEntity="BoardList", mappedBy="board", cascade="remove")
     * @var Collection/BoardList[]
     **/
    private $lists;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $color;

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
     * @param  User $user
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
     * @param Organization $organization
     * @return $this
     */
    public function setOrganization(Organization $organization)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * @return Organization
     */
    public function getOrganization()
    {
        return $this->organization;
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
     * @param  BoardList $list
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
     * @param  BoardList $list
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
     * @param  BoardList $list
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

    /**
     * @return Collection/BoardList[]
     */
    public function getAvailableLists()
    {
        $availableLists = array();
        foreach ($this->lists as $list) {
            if ($list->isArchived()) {
                continue;
            }
            $availableLists[] = $list;
        }
        return $availableLists;
    }

    /**
     * @param string $color
     * @return $this
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    public function __toString()
    {
        return $this->name;
    }
}
