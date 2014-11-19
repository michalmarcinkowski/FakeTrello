<?php

namespace AppBundle\Entity;

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
}
