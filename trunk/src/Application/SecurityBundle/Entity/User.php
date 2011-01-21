<?php
namespace Application\SecurityBundle\Entity;

use Symfony\Component\Security\User\AccountInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\User\UserProviderInterface;
/**
 * @Entity(repositoryClass="SecurityBundle:UserRepository")
 */
class User implements AccountInterface {


    function __toString() {

    }

    function getRoles() {
        die('123');
        return array();
    }

    function getPassword() {
        die('123');
        return '';
    }

    function getSalt() {
        die('123');
        return '';
    }

    function getUsername() {
        die('123');
        return $this->user;
    }

    function eraseCredentials() {
    }
}


class UserRepository extends EntityRepository implements UserProviderInterface {
    public function loadUserByUsername($email) {
        $em = $this->get('doctrine.orm.entity_manager');
        $em->find('UserBundle:user', array('email', $email));
    }
}

?>
 
