<?php

namespace DoubleGis\TestBundle\Entity;

/**
 * PhoneNumber
 */
class PhoneNumber
{
    /**
     * @var string
     */
    private $number;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $organization;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->organization = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set number
     *
     * @param string $number
     *
     * @return PhoneNumber
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add organization
     *
     * @param \DoubleGis\TestBundle\Entity\Organization $organization
     *
     * @return PhoneNumber
     */
    public function addOrganization(\DoubleGis\TestBundle\Entity\Organization $organization)
    {
        $this->organization[] = $organization;

        return $this;
    }

    /**
     * Remove organization
     *
     * @param \DoubleGis\TestBundle\Entity\Organization $organization
     */
    public function removeOrganization(\DoubleGis\TestBundle\Entity\Organization $organization)
    {
        $this->organization->removeElement($organization);
    }

    /**
     * Get organization
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrganization()
    {
        return $this->organization;
    }
}
