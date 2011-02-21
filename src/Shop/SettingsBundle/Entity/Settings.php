<?php
/**
 * @orm:Entity
 */
class Settings {

    /**
     * @orm:Id
     * @orm:Column(name="id", type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     * @var integer
     */
    private $id;

    /**
     * @orm:OneToOne(targetEntity="/Common/UserBundle/Entity/User")
     * @orm:JoinColumn(name="user_id", referencedColumnName="id")
     * @var /Common/UserBundle/Entity/User
     */
    private $user;

    /**
     * @orm:Column(nullable="true")
     * @var string
     */
    private $domain;

    /**
     * @orm:Column(nullable="true")
     * @var string
     */
    private $subDomain;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }
}