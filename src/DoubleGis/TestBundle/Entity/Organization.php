<?php

namespace DoubleGis\TestBundle\Entity;

/**
 * Organization
 */
class Organization
{
    /**
     * Organization name
     *
     * @var string
     */
    private $name;

    /**
     * Unique organization ID
     *
     * @var integer
     */
    private $id;

    /**
     * Building where organization is
     *
     * @var \DoubleGis\TestBundle\Entity\Building
     */
    private $building;

    /**
     * List of organization phone numbers
     *
     * @var \Doctrine\Common\Collections\Collection
     */
    private $phones;

    /**
     * List of organization categories
     *
     * @var \Doctrine\Common\Collections\Collection
     */
    private $categories;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->phones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Organization
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * Set building
     *
     * @param \DoubleGis\TestBundle\Entity\Building $building
     *
     * @return Organization
     */
    public function setBuilding(\DoubleGis\TestBundle\Entity\Building $building = null)
    {
        $this->building = $building;

        return $this;
    }

    /**
     * Get building
     *
     * @return \DoubleGis\TestBundle\Entity\Building
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * Add phones
     *
     * @param \DoubleGis\TestBundle\Entity\PhoneNumber $phone
     *
     * @return Organization
     */
    public function addPhone(\DoubleGis\TestBundle\Entity\PhoneNumber $phone)
    {
        $this->phones[] = $phone;

        return $this;
    }

    /**
     * Remove phones
     *
     * @param \DoubleGis\TestBundle\Entity\PhoneNumber $phone
     */
    public function removePhone(\DoubleGis\TestBundle\Entity\PhoneNumber $phone)
    {
        $this->phones->removeElement($phone);
    }

    /**
     * Get phones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * Add categories
     *
     * @param \DoubleGis\TestBundle\Entity\Category $category
     *
     * @return Organization
     */
    public function addCategory(\DoubleGis\TestBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \DoubleGis\TestBundle\Entity\Category $category
     */
    public function removeCategory(\DoubleGis\TestBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
