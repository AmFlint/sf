<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ColorRepository")
 */
class Color
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cat", mappedBy="color")
     */
    private $cats;

    public function __construct()
    {
        $this->cats = new ArrayCollection();
    }

    public function __toString()
    {
        return !empty($this->name) ? $this->name : 'hello';
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Cat[]
     */
    public function getCats(): Collection
    {
        return $this->cats;
    }

    public function addCat(Cat $cat): self
    {
        if (!$this->cats->contains($cat)) {
            $this->cats[] = $cat;
            $cat->setColor($this);
        }

        return $this;
    }

    public function removeCat(Cat $cat): self
    {
        if ($this->cats->contains($cat)) {
            $this->cats->removeElement($cat);
            // set the owning side to null (unless already changed)
            if ($cat->getColor() === $this) {
                $cat->setColor(null);
            }
        }

        return $this;
    }

    public function getExportableAttributes($attributes = null, $except = [], $withDetails = false)
    {
        $att = [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];

        if ($withDetails) {
            $att['cats'] = $this->getCats();
        }

        return $att;

    }
}
