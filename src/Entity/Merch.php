<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass="App\Repository\MerchRepository")
 * @Vich\Uploadable
 */
class Merch implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", unique=true)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region", inversedBy="merches")
     * @ORM\JoinColumn(nullable=true)
     */
    private $region;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Notification", inversedBy="merch")
     * @author youssef
     */
    private $notifications;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $passwordEncrypted;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $pathImage;

    /**
     * @return mixed
     */
    public function getPathImage()
    {
        return $this->pathImage;
    }

    /**
     * @param mixed $pathImage
     * @return Merch
     */
    public function setPathImage($pathImage)
    {
        $this->pathImage = $pathImage;
        return $this;
    }
    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    public function __construct()
    {
        $this->updatedAt = new \DateTime();
        $this->notifications = new ArrayCollection();
    }
    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     * @var string|null
     */
    private $imageName;

    /**
     * @return string|null
     */
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @param string|null $imageName
     * @return Merch
     */
    public function setImageName(?string $imageName): Merch
    {
        $this->imageName = $imageName;
        return $this;
    }



    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="merchs_image", fileNameProperty="imageName")
     *
     * @var File|null
     */
    private $imageFileMerch;

    /**
     * @return File
     */
    public function getImageFileMerch(): ?File
    {
        return $this->imageFileMerch;
    }

    /**
     * @param File|null $imageFileMerch
     * @return Merch
     * @throws \Exception
     */
    public function setImageFileMerch(?File $imageFileMerch): Merch
    {
        $this->imageFileMerch = $imageFileMerch;
        if ($this->imageFileMerch instanceof UploadedFile) {
            $this->updatedAt = new \DateTime('NOW');
        }
        return $this;
    }


    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return Merch
     */
    public function setUpdatedAt(\DateTime $updatedAt): Merch
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }





    /**
     * @return mixed
     */
    public function getPasswordEncrypted()
    {
        return $this->passwordEncrypted;
    }

    /**
     * @param mixed $passwordEncrypted
     * @return Merch
     */
    public function setPasswordEncrypted($passwordEncrypted)
    {
        $this->passwordEncrypted = $passwordEncrypted;
        return $this;
    }


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OnePlanning", mappedBy="Merch", cascade={"persist", "remove"})
     */
    private $onePlannings;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $roles = [];


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }



    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->code;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
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
     * @return Collection|OnePlanning[]
     */
    public function getOnePlannings(): Collection
    {
        return $this->onePlannings;
    }

    public function addOnePlanning(OnePlanning $onePlanning): self
    {
        if (!$this->onePlannings->contains($onePlanning)) {
            $this->onePlannings[] = $onePlanning;
            $onePlanning->setMerch($this);
        }

        return $this;
    }

    public function removeOnePlanning(OnePlanning $onePlanning): self
    {
        if ($this->onePlannings->contains($onePlanning)) {
            $this->onePlannings->removeElement($onePlanning);
            // set the owning side to null (unless already changed)
            if ($onePlanning->getMerch() === $this) {
                $onePlanning->setMerch(null);
            }
        }

        return $this;
    }




}
