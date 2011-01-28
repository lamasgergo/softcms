<?php

namespace Application\UserBundle\Entity;

use Symfony\Component\Security\User\UserProviderInterface;

use Symfony\Bundle\DoctrineBundle\Security\EntityUserProvider;

class UserRepository extends EntityUserProvider implements UserProviderInterface {
    
}
