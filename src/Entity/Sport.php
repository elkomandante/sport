<?php

namespace App\Entity;

use App\Repository\SportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SportRepository::class)
 */
class Sport
{
    const imageDir = 'sport';


    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @Groups({"sport:list", "sport:single"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=127)
     * @Groups({"sport:list","sport:single"})
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column (type="text")
     * @Groups({"sport:list","sport:single"})
     * @Assert\NotBlank()
     */
    private $description;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\League", mappedBy="sport")
     * @Groups({"sport:list","sport:single"})
     */
    private $leagues;

    /**
     * @ORM\Column (type="string",length=127, nullable=true)
     * @Groups({"sport:list","sport:single"})
     */
    private $thumbnailImage;

    private $thumbnailImageData;

    /**
     * @ORM\Column (type="string",length=127, nullable=true)
     * @Groups({"sport:list","sport:single"})
     */
    private $thumbnailGreenImage;


    private $thumbnailImageGreenData;


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
    public function getLeagues()
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

    /**
     * @return mixed
     */
    public function getThumbnailImageData()
    {
        return $this->thumbnailImageData;
    }

    /**
     * @param mixed $thumbnailImageData
     */
    public function setThumbnailImageData($thumbnailImageData): void
    {
        $this->thumbnailImageData = $thumbnailImageData;
    }

    /**
     * @return mixed
     */
    public function getThumbnailImageGreenData()
    {
        return $this->thumbnailImageGreenData;
    }

    /**
     * @param mixed $thumbnailImageGreenData
     */
    public function setThumbnailImageGreenData($thumbnailImageGreenData): void
    {
        $this->thumbnailImageGreenData = $thumbnailImageGreenData;
    }

}
