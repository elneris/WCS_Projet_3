<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="Cet email est déjà utilisé !")
 */
class User implements UserInterface
{

    public function __construct()
    {
        $this->activities = new ArrayCollection();
        $this->links = new ArrayCollection();
        $this->medias = new ArrayCollection();
    }


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(
     *      max = 25,
     *      maxMessage = "le champ prénom ne peut pas contenir plus de {{ limit }} caractères"
     * )
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(
     *      max = 30,
     *      maxMessage = "le champ nom ne peut pas contenir plus de {{ limit }} caractères"
     * )
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(
     *      max = 30,
     *      maxMessage = "le champ nom d'artiste ne peut pas contenir plus de {{ limit }} caractères"
     * )
     */
    private $artistName;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     *  @Assert\Length(
     *      max = 50,
     *      maxMessage = "le champ email ne peut pas contenir plus de {{ limit }} caractères"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Assert\Regex(
     *     pattern="/^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$/",
     *     message="N° invalide (ex :0610101010 où +33610101010)")
     *
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Length(
     *      max = 5,
     *      min = 5,
     *      maxMessage = "le code postal doit contenir 5 chiffres",
     *      minMessage = "le code postal doit contenir 5 chiffres"
     * )
     */
    private $posteCode;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthdate;

    /**
     * @ORM\Column(type="text", nullable=true)
     *  @Assert\Length(
     *      max = 40,
     *      maxMessage = "le champ adresse ne peut pas contenir plus de {{ limit }} caractères"
     * )
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $geoArea;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(
     *      max = 1000,
     *      maxMessage = "La description ne peut pas contenir plus de {{ limit }} caractères"
     * )
     */

    private $about;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    //private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Activity", mappedBy="user")
     */
    private $activities;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Link", mappedBy="user")
     */
    private $links;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Media", mappedBy="user")
     */
    private $medias;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enable = false;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resetToken;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $sentToken;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $personsNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $billingType;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $technicalNeeds;

    /**
     * @ORM\Column(type="boolean")
     */
    private $admin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getArtistName(): ?string
    {
        return $this->artistName;
    }

    public function setArtistName(?string $artistName): self
    {
        $this->artistName = $artistName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPosteCode(): ?int
    {
        return $this->posteCode;
    }

    public function setPosteCode(?int $posteCode): self
    {
        $this->posteCode = $posteCode;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getGeoArea(): ?string
    {
        return $this->geoArea;
    }

    public function setGeoArea(?string $geoArea): self
    {
        $this->geoArea = $geoArea;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(?string $about): self
    {
        $this->about = $about;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername():string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Activity[]
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity): self
    {
        if (!$this->activities->contains($activity)) {
            $this->activities[] = $activity;
            $activity->setUser($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): self
    {
        if ($this->activities->contains($activity)) {
            $this->activities->removeElement($activity);
            // set the owning side to null (unless already changed)
            if ($activity->getUser() === $this) {
                $activity->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Link[]
     */
    public function getLinks(): Collection
    {
        return $this->links;
    }

    public function addLink(Link $link): self
    {
        if (!$this->links->contains($link)) {
            $this->links[] = $link;
            $link->setUser($this);
        }

        return $this;
    }

    public function removeLink(Link $link): self
    {
        if ($this->links->contains($link)) {
            $this->links->removeElement($link);
            // set the owning side to null (unless already changed)
            if ($link->getUser() === $this) {
                $link->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Media[]
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(Media $media): self
    {
        if (!$this->medias->contains($media)) {
            $this->medias[] = $media;
            $media->setUser($this);
        }

        return $this;
    }

    public function removeMedia(Media $media): self
    {
        if ($this->medias->contains($media)) {
            $this->medias->removeElement($media);
            // set the owning side to null (unless already changed)
            if ($media->getUser() === $this) {
                $media->setUser(null);
            }
        }

        return $this;
    }

    public function getEnable(): ?bool
    {
        return $this->enable;
    }

    public function setEnable(bool $enable): self
    {
        $this->enable = $enable;

        return $this;
    }
  
    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(string $resetToken): self
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    public function getSentToken(): ?\DateTimeInterface
    {
        return $this->sentToken;
    }

    public function setSentToken(\DateTimeInterface $sentToken): self
    {
        $this->sentToken = $sentToken;
        return $this;
    }

    public function expiredReset()
    {
        $interval = new \DateInterval('PT24H');
        return $this->sentToken->add($interval) >= new \DateTime();
    }

    public function getPersonsNumber(): ?string
    {
        return $this->personsNumber;
    }

    public function setPersonsNumber(?string $personsNumber): self
    {
        $this->personsNumber = $personsNumber;

        return $this;
    }

    public function getBillingType(): ?string
    {
        return $this->billingType;
    }

    public function setBillingType(?string $billingType): self
    {
        $this->billingType = $billingType;

        return $this;
    }

    public function getTechnicalNeeds(): ?string
    {
        return $this->technicalNeeds;
    }

    public function setTechnicalNeeds(?string $technicalNeeds): self
    {
        $this->technicalNeeds = $technicalNeeds;

        return $this;
    }

    public function getAge()
    {
        if ($this->birthdate) {
            $dateInterval = $this->birthdate->diff(new \DateTime());
            return $dateInterval->y;
        }
    }

    public function isAdmin(): bool
    {
        return $this->getRoles()[0] == 'ROLE_ADMIN';
    }

    public function getAdmin(): ?bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): self
    {
        $this->admin = $admin;

        return $this;
    }
}
