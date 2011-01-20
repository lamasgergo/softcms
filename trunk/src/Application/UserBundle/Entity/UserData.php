<?php
namespace Application\UserBundle\Entity;

/**
 * @orm:Entity
 */
class UserData {

    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue
     */
    private $id;

    /**
     * @orm:Column(nullable=true)
     */
    public $country;

    /**
     * @orm:Column(nullable=true)
     */
    public $city;

    /**
     * @orm:Column(nullable=true)
     */
    public $address;

    /**
     * @orm:Column(nullable=true)
     */
    public $address2;


    public function getUser_id(){
        return $this->user_id;
    }

    public function setUser_id(User $user){
        $id = $user->getId();
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }
}
