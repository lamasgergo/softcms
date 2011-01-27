<?php

namespace Application\UserBundle\Entity;

use Symfony\Component\Security\User\UserProviderInterface;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository implements UserProviderInterface {
    /**
     * @param string $username
     * @return \Application\UserBundle\Entity\User
     */
    function loadUserByUsername($username) {
        return $this->findOneBy(array('username' => $username));
    }

    /**
     * Loads the user for the account interface.
     *
     * It is up to the implementation if it decides to reload the user data
     * from the database, or if it simply merges the passed User into the
     * identity map of an entity manager.
     *
     * @throws UnsupportedAccountException if the account is not supported
     * @param AccountInterface $user
     *
     * @return AccountInterface
     */
    function loadUserByAccount(AccountInterface $user) {
        return $this->loadUserByUsername($user->getEmail());
    }
}
