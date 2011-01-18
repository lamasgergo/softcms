<?php
namespace Application\TestBundle\Entity;

/**
 * @orm:Entity
 */
class Test{
    /**
     * @orm:id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var name
     * @orm:name
     * @orm:Column
     */
    public $name;
}
?>
 
