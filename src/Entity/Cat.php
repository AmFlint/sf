<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CatRepository")
 */
class Cat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Color", inversedBy="cats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $color;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Food", inversedBy="cats")
     */
    private $food;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Mood", inversedBy="cat", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $mood;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dob;

    public function __construct()
    {
        $this->food = new ArrayCollection();
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

    public function getColor(): ?Color
    {
        return $this->color;
    }

    public function setColor(?Color $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection|Food[]
     */
    public function getFood(): Collection
    {
        return $this->food;
    }

    public function addFood(Food $food): self
    {
        if (!$this->food->contains($food)) {
            $this->food[] = $food;
        }

        return $this;
    }

    public function removeFood(Food $food): self
    {
        if ($this->food->contains($food)) {
            $this->food->removeElement($food);
        }

        return $this;
    }

    public function getMood(): ?Mood
    {
        return $this->mood;
    }

    public function setMood(Mood $mood): self
    {
        $this->mood = $mood;

        return $this;
    }

    public function getDob(): ?\DateTimeInterface
    {
        return $this->dob;
    }

    public function setDob(?\DateTimeInterface $dob): self
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     *
     * @param null $attributes
     * @param array $except
     * @param bool $withDetails
     * @return array
     */
    public function getExportableAttributes($attributes = null, $except = [], $withDetails = false)
    {
        $att = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'color' => $this->getColor()->getExportableAttributes(),
            'mood' => $this->getMood()->getExportableAttributes()
        ];
        return $att;
    }
}
