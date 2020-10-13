<?php

namespace App\Entity;

use App\Repository\SportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SportRepository::class)
 */
class Sport
{
    const imageDir = 'sport';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=127)
     */
    private $name;

    /**
     * @ORM\Column (type="text")
     */
    private $description;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\League", mappedBy="sport")
     */
    private $leagues;

    /**
     * @ORM\Column (type="string",length=127, nullable=true)
     */
    private $thumbnailImage;

    /**
     * @ORM\Column (type="string",length=127, nullable=true)
     */
    private $thumbnailGreenImage;


    public function __construct()
    {
        $this->leagues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
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
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return ArrayCollection
     */
    public function getLeagues(): ArrayCollection
    {
        return $this->leagues;
    }

    public function addLeague(League $league)
    {
        if($this->leagues->contains($league)) return;
        $this->leagues->add($league);
    }

    /**
     * @return mixed
     */
    public function getThumbnailImage()
    {
        return $this->thumbnailImage;
    }

    /**
     * @param mixed $thumbnailImage
     */
    public function setThumbnailImage($thumbnailImage): void
    {
        $this->thumbnailImage = $thumbnailImage;
    }

    /**
     * @return mixed
     */
    public function getThumbnailGreenImage()
    {
        return $this->thumbnailGreenImage;
    }

    /**
     * @param mixed $thumbnailGreenImage
     */
    public function setThumbnailGreenImage($thumbnailGreenImage): void
    {
        $this->thumbnailGreenImage = $thumbnailGreenImage;
    }
}
