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
     * @orm:Column(type="string", length="255", nullable=true)
     * @validation:NotBlank()
     */
    public $surname;

    /**
     * @orm:Column(type="string", length="255", nullable=true)
     */
    public $pantronymic;

    /**
     * @orm:Column(type="integer")
     * @validation:NotBlank()
     */
    public $type;

    /**
     * @orm:OneToOne(targetEntity="UserData", cascade={"persist", "remove", "merge"}, mappedBy="personal")
     * @orm:JoinColumn(name="id", referencedColumnName="id")
     */
    public $data;
    
    /**
     * @orm:Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @validation:AssertTrue(message="Please accept the terms and conditions")
     */
    public $termsAccepted = false;

    /** @validation:Valid */
    public $groupdata;

    public function __construct() {
        $this->createdAt = new \DateTime();
    }

    public function getId(){
        return $this->id;
    }

    public function getEmail(){
        return $this->email;
    }


}

