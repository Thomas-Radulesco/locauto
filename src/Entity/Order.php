<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\JoinColumn(nullable=false)
     */
    private $memberId;

    /**
     * @ORM\ManyToOne(targetEntity=Vehicle::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicleId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datetimeFrom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datetimeTo;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalPrice;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
