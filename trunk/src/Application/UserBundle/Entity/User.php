<?php
namespace Application\UserBundle\Entity;


/**
 * @orm:Entity(repositoryClass="Application\UserBundle\Entity\UserRepository")
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
     * @orm:OneToOne(targetEntity="UserData", mappedBy="user")
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
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
    }

    public function getPantronymic() {
        return $this->pantronymic;
    }

    public function setPantronymic($pantronymic) {
        $this->pantronymic = $pantronymic;
    }

    public function getTypes() {
        return $this->types;
    }

    public function setTypes($types) {
        $this->types = $types;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getPublished() {
        return $this->published;
    }

    public function setPublished(boolean $published) {
        $this->published = $published;
    }


}

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository{

    public function findAll(){
        return $this->_em->createQuery("SELECT u FROM UserBundle:User u ORDER BY u.cratedAt DESC")->getResult();
    }
}

