<?php

namespace Application\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\User\AccountInterface;

class UserRepository extends EntityRepository implements UserProviderInterface {

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
    public function loadUserByAccount(AccountInterface $account) {
        return $this->loadUserByUsername($account);
    }

    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @throws UsernameNotFoundException if the user is not found
     * @param string $username The username
     *
     * @return AccountInterface
     */
    public function loadUserByUsername($username) {
        return $this->loadUserByEmail($username);
    }

    public function loadUserByEmail($email){
        $user = $this->loadUserByUsername($email);

        if (null === $user) {
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $email));
        }

        return $user;
    }

    /**
     * Whether this provider supports the given user class
     *
     * @param string $class
     *
     * @return Boolean
     */
    function supportsClass($class) {
        return $class === $this->class;
    }
}
