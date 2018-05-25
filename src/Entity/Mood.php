<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MoodRepository")
 */
class Mood
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Cat", mappedBy="mood", cascade={"persist", "remove"})
     */
    private $cat;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCat(): ?Cat
    {
        return $this->cat;
    }

    public function setCat(Cat $cat): self
    {
        $this->cat = $cat;

        // set the owning side of the relation if necessary
        if ($this !== $cat->getMood()) {
            $cat->setMood($this);
        }

        return $this;
    }

    /**
     * Get Mood exportable attributes
     * @param array $attributes
     * @param array $except
     * @param bool $withDetails
     * @return array
     */
    public function getExportableAttributes(array $attributes = [], array $except = [],bool $withDetails = false): array
    {
        $att = [
            'mood_id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription()
        ];

        if ($withDetails) {
            $att['cats'] = $this->getCat();
        }

        return $att;
    }
}
