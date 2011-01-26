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
     * @orm:OneToOne(targetEntity="User", inversedBy="address")
     * @orm:JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @orm:Column(nullable=true)
     */
    private $country;

    /**
     * @orm:Column(nullable=true)
     */
    private $city;

    /**
     * @orm:Column(nullable=true)
     */
    private $address;



    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCountry() {
        return $this->country;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }
}
