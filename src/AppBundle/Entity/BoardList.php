<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="list")
 */
class BoardList
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
     * @ORM\ManyToOne(targetEntity="Board", inversedBy="lists")
     * @ORM\JoinColumn(name="board_id", referencedColumnName="id")
     **/
    private $board;

    /**
     * @ORM\OneToMany(targetEntity="Card", mappedBy="boardList", cascade="remove")
     * @var Collection/Card[]
     **/
    private $cards;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
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
     * @param  Board $board
     * @return $this
     */
    public function setBoard($board)
    {
        $this->board = $board;

        return $this;
    }

    /**
     * @return Board
     */
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * @param  Card  $card
     * @return $this
     */
    public function addCard(Card $card)
    {
        if ($this->hasCard($card)) {
            return $this;
        }
        $this->cards->add($card);

        return $this;
    }

    /**
     * @param  Card  $card
     * @return $this
     */
    public function removeCard(Card $card)
    {
        if ($this->hasCard($card)) {
            $this->cards->removeElement($card);
        }

        return $this;
    }

    /**
     * @param  Card $card
     * @return bool
     */
    public function hasCard(Card $card)
    {
        return $this->cards->contains($card);
    }

    /**
     * @return Collection/Card[]
     */
    public function getCards()
    {
        return $this->cards;
    }
}
