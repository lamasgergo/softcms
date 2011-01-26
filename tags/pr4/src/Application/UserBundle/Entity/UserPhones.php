<?php
namespace Application\UserBundle\Entity;

/**
 * @orm:Entity
 */
class UserPhones {

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
     * @orm:ManyToOne(targetEntity="User")
     * @orm:JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user_id;

    /**
     * @var number
     * @orm:Column(length=20)
     */
    private $number;

    /**
     * @var type
     * @orm:Column(type="array")
     */
    private $type=array('phone', 'fax', 'cellphone');

    /**
     * @var description
     * #orm:Column(nullable=true)
     */
    private $description;

    public function __construct(){
        $this->types = array('phone', 'fax', 'cellphone');
    }

    public function getNumber(){
        return $this->number;
    }

    public function setNumber($number){
        $this->number = $number;
    }

    public function getType(){
        return $this->type;
    }

    public function setType($type=''){
        if ($type )
        $this->type = $type;
    }
}
