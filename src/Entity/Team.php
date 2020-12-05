<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
{
    const imageDir = 'teams';

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
     * @ORM\Column(type="string", length=127, nullable=true)
     */
    private $otherNames;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $formedYear;

    /**
     * @ORM\Column(type="string", length=127, nullable=true)
     */
    private $stadium;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $stadiumDescription;

    /**
     * @ORM\Column(type="string", length=127, nullable=true)
     */
    private $stadiumLocation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $stadiumCapacity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", length=1255, nullable=true)
     */
    private $instagram;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $youtube;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $badgeImage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $jerseyImage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logoImage;

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\League", inversedBy="teams")
     */
    private $league;

    public function getId(): ?int
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

    public function getOtherNames(): ?string
    {
        return $this->otherNames;
    }

    public function setOtherNames(?string $otherNames): self
    {
        $this->otherNames = $otherNames;

        return $this;
    }

    public function getFormedYear(): ?int
    {
        return $this->formedYear;
    }

    public function setFormedYear(?int $formedYear): self
    {
        $this->formedYear = $formedYear;

        return $this;
    }

    public function getStadium(): ?string
    {
        return $this->stadium;
    }

    public function setStadium(?string $stadium): self
    {
        $this->stadium = $stadium;

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

    public function getStadiumDescription(): ?string
    {
        return $this->stadiumDescription;
    }

    public function setStadiumDescription(?string $stadiumDescription): self
    {
        $this->stadiumDescription = $stadiumDescription;

        return $this;
    }

    public function getStadiumLocation(): ?string
    {
        return $this->stadiumLocation;
    }

    public function setStadiumLocation(?string $stadiumLocation): self
    {
        $this->stadiumLocation = $stadiumLocation;

        return $this;
    }

    public function getStadiumCapacity(): ?int
    {
        return $this->stadiumCapacity;
    }

    public function setStadiumCapacity(?int $stadiumCapacity): self
    {
        $this->stadiumCapacity = $stadiumCapacity;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): self
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getYoutube(): ?string
    {
        return $this->youtube;
    }

    public function setYoutube(?string $youtube): self
    {
        $this->youtube = $youtube;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLeague()
    {
        return $this->league;
    }

    /**
     * @param mixed $league
     */
    public function setLeague($league): void
    {
        $this->league = $league;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getBadgeImage()
    {
        return $this->badgeImage;
    }

    /**
     * @param mixed $badgeImage
     */
    public function setBadgeImage($badgeImage): void
    {
        $this->badgeImage = $badgeImage;
    }

    /**
     * @return mixed
     */
    public function getJerseyImage()
    {
        return $this->jerseyImage;
    }

    /**
     * @param mixed $jerseyImage
     */
    public function setJerseyImage($jerseyImage): void
    {
        $this->jerseyImage = $jerseyImage;
    }

    /**
     * @return mixed
     */
    public function getLogoImage()
    {
        return $this->logoImage;
    }

    /**
     * @param mixed $logoImage
     */
    public function setLogoImage($logoImage): void
    {
        $this->logoImage = $logoImage;
    }
}
