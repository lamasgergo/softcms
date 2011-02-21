<?php
namespace Common\ContentBundle\Entity;

/**
 * @orm:Entity
 * @orm:Table(name="categories")
 */
class Category {

    /**
     * @orm:Column(name="id", type="integer")
     * @orm:Id
     * @orm:GeneratedValue(strategy="AUTO")
     * @var integer
     */
    private $id;

    /**
     * @OneToMany(targetEntity="Category", mappedBy="parent")
     */
    private $children;

     /**
     * @ManyToOne(targetEntity="Category", inversedBy="children")
     * @JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * @orm:Column
     * @var string
     */
    private $name;

    /**
     * @orm:Column(type="text")
     * @var string
     */
    private $description;


    public function __construct() {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }
}