<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrderRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Member::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=true)
     */
    private $memberId;

    /**
     * @ORM\ManyToOne(targetEntity=Vehicle::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=true)
     */
    private $vehicleId;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThanOrEqual("today", message="La date de début de location ne doit pas être antérieure à la date d'aujourd'hui")
     */
    private $datetimeFrom;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThanOrEqual(propertyPath="datetimeFrom", message="La date de fin de location doit être postérieure à la date de début")
     */
    private $datetimeTo;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalPrice;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMemberId(): ?Member
    {
        return $this->memberId;
    }

    public function setMemberId(?Member $memberId): self
    {
        $this->memberId = $memberId;

        return $this;
    }

    public function getVehicleId(): ?Vehicle
    {
        return $this->vehicleId;
    }

    public function setVehicleId(?Vehicle $vehicleId): self
    {
        $this->vehicleId = $vehicleId;

        return $this;
    }

    public function getDatetimeFrom(): ?\DateTimeInterface
    {
        return $this->datetimeFrom;
    }

    public function setDatetimeFrom(\DateTimeInterface $datetimeFrom): self
    {
        $this->datetimeFrom = $datetimeFrom;

        return $this;
    }

    public function getDatetimeTo(): ?\DateTimeInterface
    {
        return $this->datetimeTo;
    }

    public function setDatetimeTo(\DateTimeInterface $datetimeTo): self
    {
        $this->datetimeTo = $datetimeTo;

        return $this;
    }

    public function getTotalPrice(): ?int
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(int $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
