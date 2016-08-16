<?php

namespace DoubleGis\TestBundle\Entity;

/**
 * Building
 */
class Building
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DoubleGis\TestBundle\Entity\Address
     */
    private $address;


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
     * Set address
     *
     * @param \DoubleGis\TestBundle\Entity\Address $address
     *
     * @return Building
     */
    public function setAddress(\DoubleGis\TestBundle\Entity\Address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \DoubleGis\TestBundle\Entity\Address
     */
    public function getAddress()
    {
        return $this->address;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $organizations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->organizations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add organization
     *
     * @param \DoubleGis\TestBundle\Entity\Organization $organization
     *
     * @return Building
     */
    public function addOrganization(\DoubleGis\TestBundle\Entity\Organization $organization)
    {
        $this->organizations[] = $organization;

        return $this;
    }

    /**
     * Remove organization
     *
     * @param \DoubleGis\TestBundle\Entity\Organization $organization
     */
    public function removeOrganization(\DoubleGis\TestBundle\Entity\Organization $organization)
    {
        $this->organizations->removeElement($organization);
    }

    /**
     * Get organizations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrganizations()
    {
        return $this->organizations;
    }
}
