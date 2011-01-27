<?php
namespace Application\UserBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRepositoryTest extends WebTestCase {
    /**
     * @var \Application\UserBundle\Entity\UserRepository
     */
    protected $repository;

    protected function setUp() {
        $kernel = $this->createKernel();
        $kernel->boot();

        $this->repository = $kernel
                ->getContainer()
                ->get('doctrine.orm.entity_manager')
                ->getRepository('UserBundle:User');
    }

    public function testLoadUserByUsername() {
        $user = $this->repository->loadUserByUsername('pminnieur');
        $this->assertEquals('example', $user->getUsername());
    }
}

?>
 
