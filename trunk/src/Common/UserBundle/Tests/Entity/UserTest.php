<?php
namespace Application\UserBundle\Tests\Entity;

use Application\UserBundle\Entity\User;

class UserTest extends \PHPUnit_Framework_TestCase {
    public function testConstructorSetsTimestamps() {
        $user = new User();

        $dateTime = new \DateTime('now');
        $this->assertEquals($dateTime, $user->getCreated());
        $this->assertEquals($dateTime, $user->getUpdated());
    }

    public function testLifecycleCallbacks() {
        $user = new User();
        $dateTime = new \DateTime('now');

        sleep(1);
        $user->update();
        $this->assertGreaterThan($dateTime, $user->getUpdated());
    }

    public function testToString() {
        $user = new User();

        $user->setUsername('example');
        $this->assertEquals('example', (string) $user);
    }

    public function testUsername() {
        $user = new User();

        $user->setUsername('example');
        $this->assertEquals('example', $user->getUsername());
    }

    public function testEmail() {
        $user = new User();

        $user->setEmail('mail@example.org');
        $this->assertEquals('mail@example.org', $user->getEmail());
    }

    public function testPassword() {
        $user = new User();
        $this->assertNull($user->getPassword());

        $encoder = new \Symfony\Component\Security\Encoder\MessageDigestPasswordEncoder('sha1');
        $password = $encoder->encodePassword('example', $user->getSalt());

        $user->setPassword('example');
        $this->assertEquals($password, $user->getPassword());
    }

    public function testActivation() {
        $user = new User();
        $this->assertFalse($user->isActivated());

        $dateTime = new \DateTime('now');
        $user->setActivation($dateTime);
        $this->assertEquals($dateTime, $user->getActivation());
        $this->assertTrue($user->isActivated());
    }

    public function testActivationKeyIsOnlyGeneratedOnce() {
        $user = new User();

        $key = $user->getActivationKey();
        $this->assertEquals($key, $user->getActivationKey());
    }

    public function testLastLogin() {
        $user = new User();
        $this->assertNull($user->getLastLogin());

        $dateTime = new \DateTime('now');
        $user->setLastLogin($dateTime);
        $this->assertEquals($dateTime, $user->getLastLogin());
    }

    public function testSaltIsOnlyGeneratedOnce() {
        $user = new User();

        $salt = $user->getSalt();
        $this->assertEquals($salt, $user->getSalt());
    }
}

?>
 
