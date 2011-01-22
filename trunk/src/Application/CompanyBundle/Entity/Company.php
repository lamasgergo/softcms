<?php

namespace Application\CompanyBundle\Entity;

/**
 * @orm:Entity
 */
class Company{
    /**
     * @var id
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue
     */
    private $id;

    /**
     * @var user_id
     * @orm:Column(type="integer")
     * @orm:ManyToOne(targetEntity="UserBundle/User")
     * @orm:JoinColumn(name="user_id", referencedColumnName="id")
     * @validation:Valid
     */
    private $user_id;

    /**
     * @var name
     * @orm:Column
     */
    public $name;

    /**
     * @var description
     * @orm:Column(type="text")
     */
    public $description;

    public function getUser_Id(){
        return $this->user_id;
    }
}
 
