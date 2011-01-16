<?php
namespace Application\UserBundle\Entity;

/**
 * @orm:Entity
 */
class User {

    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @orm:Column(type="string", length="255")
     */
    public $email;

    /**
     * @orm:Column
     */
    public $password;

    /**
     * @orm:Column(type="string", length="255")
     */
    public $name;

    /**
     * @orm:Column(type="string", length="255", nullable=true)
     */
    public $surname;

    /**
     * @orm:Column(type="string", length="255", nullable=true)
     */
    public $pantronymic;

    /**
     * @orm:OneToOne(targetEntity="UserType")
     * @JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    /**
     * @orm:Column(type="datetime")
     */
    protected $createdAt;

    public function __construct() {
        $this->createdAt = new \DateTime();
    }

    public function getId(){
        return $this->id;
    }

    public function getType(){
        return $this->id;
    }
}
