<?php
namespace Application\SecurityBundle\Entity;

use Application\UserBundle\Entity\User as UserBase;
use Symfony\Component\Security\User\AccountInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\User\UserProviderInterface;
/**
 * @Entity(repositoryClass="SecurityBundle:UserRepository")
 */
class User extends UserBase implements AccountInterface {


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
        return $this->id;
    }

    function getUsername() {
        return $this->email;
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
 
