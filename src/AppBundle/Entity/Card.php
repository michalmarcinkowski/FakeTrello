<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\ArchivableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="card")
 */
class Card implements ArchivableInterface
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=true)
     */
    private $deadline;

    /**
     * @ORM\ManyToOne(targetEntity="BoardList", inversedBy="cards")
     * @ORM\JoinColumn(name="board_list_id", referencedColumnName="id")
     **/
    private $boardList;

    /**
     * @ORM\ManyToMany(targetEntity="Label", inversedBy="cards")
     * @ORM\JoinTable(name="card_labels")
     * @var Collection
     **/
    private $labels;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="card", cascade="remove")
     * @var Collection
     **/
    private $comments;

    public function __construct()
    {
        $this->labels = new ArrayCollection();
        $this->comments = new ArrayCollection();
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
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param \DateTime $deadline
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    }

    /**
     * @return \DateTime
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * @param  BoardList $boardList
     * @return $this
     */
    public function setBoardList(BoardList $boardList)
    {
        $this->boardList = $boardList;

        return $this;
    }

    /**
     * @return BoardList
     */
    public function getBoardList()
    {
        return $this->boardList;
    }

    /**
     * @return Collection
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * @param  Label $label
     * @return $this
     */
    public function addLabel(Label $label)
    {
        if ($this->hasLabel($label)) {
            return $this;
        }
        $this->labels->add($label);

        return $this;
    }

    /**
     * @param  Label $label
     * @return $this
     */
    public function removeLabel(Label $label)
    {
        if ($this->hasLabel($label)) {
            $this->labels->removeElement($label);
        }

        return $this;
    }

    /**
     * @param  Label $label
     * @return bool
     */
    public function hasLabel(Label $label)
    {
        return $this->labels->contains($label);
    }

    /**
     * @return Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param  Comment $comment
     * @return $this
     */
    public function addComment(Comment $comment)
    {
        if ($this->hasComment($comment)) {
            return $this;
        }
        $this->comments->add($comment);

        return $this;
    }

    /**
     * @param  Comment $comment
     * @return $this
     */
    public function removeComment(Comment $comment)
    {
        if ($this->hasComment($comment)) {
            $this->comments->removeElement($comment);
        }

        return $this;
    }

    /**
     * @param  Comment $comment
     * @return bool
     */
    public function hasComment(Comment $comment)
    {
        return $this->comments->contains($comment);
    }
}
