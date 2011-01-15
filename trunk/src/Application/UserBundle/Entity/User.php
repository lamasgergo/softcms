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
     */
    protected $email;

    /**
     * @orm:Column(type="string", length="255")
     */
    protected $name;

    /**
     * @orm:Column(type="datetime")
     */
    protected $createdAt;

    public function __construct() {
        $this->createdAt = new \DateTime();
    }
}
