<?php

namespace App\Entity;

use App\Repository\LeagueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=LeagueRepository::class)
 */
class League
{
    const imageDir = 'leagues';

    /**
     * @Groups({"league:list"})
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"sport:single","sport:list","league:list"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Groups({"sport:single","league:list"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $youtube;

    /**
     * @Groups({"sport:single","league:list"})
     * @ORM\Column(type="integer", nullable=true)
     */
    private $formedYear;


    /**
     * @Groups({"sport:single","league:list"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebook;


    /**
     * @Groups({"sport:single","league:list"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twitter;

    /**
     * @Groups({"sport:single","league:list"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bannerImage;


    /**
     * @Groups({"sport:single","league:list"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $badgeImage;


    /**
     * @Groups({"sport:single","league:list"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logoImage;

    /**
     * @Groups({"sport:single","league:list"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $trophyImage;


    /**
     * @Groups({"sport:single","league:list"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Sport", inversedBy="leagues")
     */
    private $sport;


    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\Country", inversedBy="leagues")
     */
    private $country;


    /**
     * @ORM\OneToMany (targetEntity="App\Entity\Team", mappedBy="league")
     */
    private $teams;


    public function __construct()
    {
        $this->teams = new ArrayCollection();
    }


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

    /**
     * @return mixed
     */
    public function getSport()
    {
        return $this->sport;
    }

    /**
     * @param mixed $sport
     */
    public function setSport($sport): void
    {
        $this->sport = $sport;
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
     * @return mixed
     */
    public function getYoutube()
    {
        return $this->youtube;
    }

    /**
     * @return mixed
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @param mixed $facebook
     */
    public function setFacebook($facebook): void
    {
        $this->facebook = $facebook;
    }

    /**
     * @return mixed
     */
    public function getFormedYear()
    {
        return $this->formedYear;
    }

    /**
     * @param mixed $formedYear
     */
    public function setFormedYear($formedYear): void
    {
        $this->formedYear = $formedYear;
    }

    /**
     * @return mixed
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * @param mixed $twitter
     */
    public function setTwitter($twitter): void
    {
        $this->twitter = $twitter;
    }

    /**
     * @param mixed $youtube
     */
    public function setYoutube($youtube): void
    {
        $this->youtube = $youtube;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    /**
     * @return ArrayCollection
     */
    public function getTeams()
    {
        return $this->teams;
    }


    public function addTeam(Team $team): void
    {
        if($this->teams->contains($team)) return;

        $this->teams->add($team);
    }

    /**
     * @return mixed
     */
    public function getTrophyImage()
    {
        return $this->trophyImage;
    }

    /**
     * @param mixed $trophyImage
     */
    public function setTrophyImage($trophyImage): void
    {
        $this->trophyImage = $trophyImage;
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
    public function getBannerImage()
    {
        return $this->bannerImage;
    }

    /**
     * @param mixed $bannerImage
     */
    public function setBannerImage($bannerImage): void
    {
        $this->bannerImage = $bannerImage;
    }
}
