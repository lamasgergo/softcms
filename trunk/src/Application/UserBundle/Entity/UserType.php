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
     * @orm:OneToMany(targetEntity="User")
     * @JoinColumn(name="id", referencedColumnName="type_id",insertable=false,updatable=false)
     * @validation:NotBlank()
     */
    public $name;
}
