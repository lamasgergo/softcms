<?php
namespace Application\UserBundle\Entity;


/**
 * @orm:Entity
 * @orm:table(name="Users")
 */
class User{

    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue
     */
    private $id;

    /**
     * @orm:Column(type="string", length="255", unique="true")
     * @validation:NotBlank()
     * @validation:Email
     */
    private $email;

    /**
     * @orm:Column
     * @validation:NotBlank()
     * @validation:MinLength(5)
     */
    private $password;

    /**
     * @orm:Column(type="string", length="255")
     * @validation:NotBlank()
     * @validation:MinLength(3)
     */
    private $name;

    /**
     * @orm:Column(type="string", length="255")
     * @validation:NotBlank()
     * @validation:MinLength(3)
     */
    private $surname;

    /**
     * @orm:Column(type="string", length="255", nullable=true)
     */
    private $pantronymic;

    /**
     * @orm:ManyToOne(targetEntity="UserType", inversedBy="users")
     * @orm:JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $types;

    /**
     * @orm:OneToOne(targetEntity="UserData", cascade={"persist", "remove", "merge"}, mappedBy="address")
     * @orm:JoinColumn(name="id", referencedColumnName="id")
     */
    private $address;

    /**
     * @var bool
     * $orm:Column(type="tinyint(1)")
     */
    private $published = false;
    
    /**
     * @orm:Column(type="datetime")
     */
    private $createdAt;

    /**
     * @validation:AssertTrue(message="Please accept the terms and conditions")
     */
    public $termsAccepted = false;

    public function __construct() {
        $this->createdAt = new \DateTime();
        $this->types = new \Doctrine\Common\Collections\ArrayCollection();
    }

    
}

