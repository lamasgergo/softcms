<?php
namespace Application\UserBundle\Entity;

/**
 * @orm:Entity
 */
class UserType {

    /**
     * @orm:id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="IDENTITY")
     */
    public $id;

    /**
     * @orm:Column
     * @orm:OneToOne(targetEntity="User", inversedBy="type")
     * @JoinColumn(name="id", referencedColumnName="type_id")
     * @validation:NotBlank()
     */
    public $name;

    /**
     * @var users
     * @orm:OneToMany(targetEntity="User", mappedBy="types")
     */
    private $users;


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getUsers() {
        return $this->users;
    }

    public function setUsers($users) {
        $this->users = $users;
    }
}
