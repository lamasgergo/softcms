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
     */
    public $name;
}
