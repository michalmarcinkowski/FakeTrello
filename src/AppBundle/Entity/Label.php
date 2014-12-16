<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="label")
 */
class Label
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
     * @ORM\Column(type="string", nullable=true)
     */
    private $color;

    /**
     * @ORM\ManyToMany(targetEntity="Card", mappedBy="labels")
     * @var Collection
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

    /**
     * @return Collection
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * @param  Card $card
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
     * @param  Card $card
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

    public function __toString()
    {
        return $this->name;
    }
}
