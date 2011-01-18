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
     * @validation:NotBlank()
     * @validation:Email
     */
    public $email;

    /**
     * @orm:Column
     * @validation:NotBlank()
     * @validation:MinLength(5)
     */
    public $password;

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
