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
    public $name;

    /**
     * @orm:Column(type="string", length="255")
     * @validation:NotBlank()
     * @validation:MinLength(3)
     */
    public $surname;

    /**
     * @orm:Column(type="string", length="255", nullable=true)
     */
    public $pantronymic;

    /**
     * @orm:OnoToOne(targetEntity="UserType", mappedBy="name")
     */
    public $type;

    /**
     * @orm:ManyToMany(targetEntity="UserType")
     * @orm:JoinTable(name="UserType")
     */
    public $types;

    /**
     * @orm:OneToOne(targetEntity="UserData", cascade={"persist", "remove", "merge"}, mappedBy="address")
     * @orm:JoinColumn(name="id", referencedColumnName="id")
     */
    public $address;

    /**
     * @var bool
     * $orm:Column(type="tinyint(1)")
     */
    public $published = false;
    
    /**
     * @orm:Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @validation:AssertTrue(message="Please accept the terms and conditions")
     */
    public $termsAccepted = false;

    /** @validation:Valid */
    public $data;

    public function __construct() {
        $this->createdAt = new \DateTime();
        $this->types = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(){
        return $this->id;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function register(){
        
    }

    public function getTypes(){
        return $this->types;
    }
}

