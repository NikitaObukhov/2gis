<?php

namespace DoubleGis\TestBundle\Entity;

/**
 * Category
 */
class Category
{
    /**
     * Category name
     *
     * @var string
     */
    private $name;

    /**
     * Unique category ID
     *
     * @var integer
     */
    private $id;

    /**
     * @var \DoubleGis\TestBundle\Entity\Category
     */
    private $parent;

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
     * Set name
     *
     * @param string $name
     *
     * @return Category
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
     * Set parent
     *
     * @param \DoubleGis\TestBundle\Entity\Category $parent
     *
     * @return Category
     */
    public function setParent(\DoubleGis\TestBundle\Entity\Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \DoubleGis\TestBundle\Entity\Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add organizations
     *
     * @param \DoubleGis\TestBundle\Entity\Organization $organizations
     *
     * @return Category
     */
    public function addOrganization(\DoubleGis\TestBundle\Entity\Organization $organizations)
    {
        $this->organizations[] = $organizations;

        return $this;
    }

    /**
     * Remove organizations
     *
     * @param \DoubleGis\TestBundle\Entity\Organization $organizations
     */
    public function removeOrganization(\DoubleGis\TestBundle\Entity\Organization $organizations)
    {
        $this->organizations->removeElement($organizations);
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
    /**
     * @var integer
     */
    private $left;

    /**
     * @var integer
     */
    private $right;

    /**
     * @var integer
     */
    private $level;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $children;

    /**
     * @var \DoubleGis\TestBundle\Entity\Category
     */
    private $root;


    /**
     * Set left
     *
     * @param integer $left
     *
     * @return Category
     */
    public function setLeft($left)
    {
        $this->left = $left;

        return $this;
    }

    /**
     * Get left
     *
     * @return integer
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * Set right
     *
     * @param integer $right
     *
     * @return Category
     */
    public function setRight($right)
    {
        $this->right = $right;

        return $this;
    }

    /**
     * Get right
     *
     * @return integer
     */
    public function getRight()
    {
        return $this->right;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Category
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Add child
     *
     * @param \DoubleGis\TestBundle\Entity\Category $child
     *
     * @return Category
     */
    public function addChild(\DoubleGis\TestBundle\Entity\Category $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \DoubleGis\TestBundle\Entity\Category $child
     */
    public function removeChild(\DoubleGis\TestBundle\Entity\Category $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set root
     *
     * @param \DoubleGis\TestBundle\Entity\Category $root
     *
     * @return Category
     */
    public function setRoot(\DoubleGis\TestBundle\Entity\Category $root = null)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root
     *
     * @return \DoubleGis\TestBundle\Entity\Category
     */
    public function getRoot()
    {
        return $this->root;
    }
}
