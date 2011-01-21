<?php
namespace Application\SecurityBundle\Entity;

use Application\UserBundle\Entity\User as Users;
use Symfony\Component\Security\User\AccountInterface;
/**
 * @orm:Entity
 */
class User extends Users implements AccountInterface {


    function __toString(){
        
    }

    function getRoles(){
        return array();
    }

    function getPassword(){
        return '';
    }

    function getSalt(){
        return '';
    }

    function getUsername(){
        return $this->user;
    }

    function eraseCredentials(){}
}

?>
 
