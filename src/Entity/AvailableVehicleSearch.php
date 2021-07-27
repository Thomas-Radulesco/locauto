<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class AvailableVehicleSearch

{

    /**
     * Beginning of rental period
     * @Assert\GreaterThanOrEqual("today", message="La date de début de location ne doit pas être antérieure à la date d'aujourd'hui")
     *
     * @var \DateTime
     */
    private $fromDate;
    
    /**
     * End of rental period
     * @Assert\GreaterThanOrEqual(propertyPath="fromDate", message="La date de fin de location doit être postérieure à la date de début")
     *
     * @var \DateTime
     */
    private $toDate;

    /**
     * Get end of rental period
     *
     * @return  \DateTime
     */ 
    public function getToDate()
    {
        return $this->toDate;
    }

    /**
     * Set end of rental period
     *
     * @param  \DateTime  $toDate  End of rental period
     *
     * @return  self
     */ 
    public function setToDate(\DateTime $toDate)
    {
        $this->toDate = $toDate;

        return $this;
    }

    /**
     * Get beginning of rental period
     *
     * @return  \DateTime
     */ 
    public function getFromDate()
    {
        return $this->fromDate;
    }

    /**
     * Set beginning of rental period
     *
     * @param  \DateTime  $fromDate  Beginning of rental period
     *
     * @return  self
     */ 
    public function setFromDate(\DateTime $fromDate)
    {
        $this->fromDate = $fromDate;

        return $this;
    }
}