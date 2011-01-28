<?php 
// Application/UserBundle/Entity/User.php
namespace Application\UserBundle\Entity;

use Symfony\Component\Security\User\AccountInterface;
use Symfony\Component\Security\Encoder\MessageDigestPasswordEncoder;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @orm:Entity(repositoryClass="Application\UserBundle\Entity\UserRepository")
 * @orm:Table(name="user",
 *     uniqueConstraints={
 * @orm:UniqueConstraint(name="username_idx", columns={"username"}),
 * @orm:UniqueConstraint(name="email_idx", columns={"email"})
 *     }
 * )
 * @orm:HasLifecycleCallbacks
 */
class User implements AccountInterface {
    /**
     * @orm:Column(name="id", type="integer")
     * @orm:Id
     * @orm:GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @orm:Column(name="username", type="string", length="32")
     * @validation:MinLenght(3)
     * @validation:MinLenght(32)
     * @validation:NotBlank
     * @var string
     */
    protected $username;

    /**
     * @orm:Column(name="email", type="string", length="125")
     * @validation:Email
     * @validation:NotBlank
     * @var string
     */
    protected $email;

    /**
     * @orm:Column(name="salt", type="string", length="32")
     * @var string
     */
    protected $salt;

    /**
     * @orm:Column(name="password", type="string", length="40")
     * @validation:NotBlank
     * @var string
     */
    protected $password;

    /**
     * @orm:Column(name="activation_key", type="string", length="32", nullable="true")
     * @var \DateTime
     */
    protected $activationKey;

    /**
     * @orm:Column(name="activation", type="datetime", nullable="true")
     * @var \DateTime
     */
    protected $activation;

    /**
     * @orm:Column(name="last_login", type="datetime", nullable="true")
     * @var \DateTime
     */
    protected $lastLogin;

    /**
     * @orm:Column(name="created", type="datetime")
     * @validation:NotBlank
     * @var \DateTime
     */
    protected $created;

    /**
     * @orm:Column(name="updated", type="datetime")
     * @validation:NotBlank
     * @var \DateTime
     */
    protected $updated;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->created = $this->updated = new \DateTime('now');
    }

    /**
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->getUsername();
    }

    /**
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password) {
        $encoder = new MessageDigestPasswordEncoder('sha1');
        $password = $encoder->encodePassword($password, $this->getSalt());

        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getActivationKey() {
        if (null === $this->activationKey) {
            $this->activationKey = md5(sprintf(
                '%s_%d_%s_%f_%s_%d',
                uniqid(),
                rand(0, 99999),
                $this->getUsername(),
                microtime(true),
                $this->getEmail(),
                rand(99999, 999999)
            ));
        }

        return $this->activationKey;
    }

    /**
     * @return \DateTime
     */
    public function getActivation() {
        return $this->activation;
    }

    /**
     * @param \DateTime $activation
     */
    public function setActivation(\DateTime $activation) {
        $this->activation = $activation;
    }

    /**
     * @return \DateTime
     */
    public function isActivated() {
        return (boolean) $this->activation;
    }

    /**
     * @return \DateTime
     */
    public function getLastLogin() {
        return $this->lastLogin;
    }

    /**
     * @param \DateTime $lastLogin
     */
    public function setLastLogin(\DateTime $lastLogin) {
        $this->lastLogin = $lastLogin;
    }

    /**
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated() {
        return $this->updated;
    }

    /**
     * @orm:PreUpdate
     */
    public function update() {
        $this->updated = new \DateTime('now');
    }

    // AccountInterface

    /**
     * @return string
     */
    public function getSalt() {
        if (null === $this->salt) {
            $this->salt = md5(sprintf(
                '%s_%d_%f',
                uniqid(),
                rand(0, 99999),
                microtime(true)
            ));
        }

        return $this->salt;
    }

    /**
     * @return array
     */
    public function getRoles() {
        return array('ROLE_USER', 'ROLE_OWNER', 'ROLE_ADMIN');
    }

    /**
     * @return void
     */
    public function eraseCredentials() {
        $this->roles = null;
    }

    /**
     * The equality comparison should neither be done by referential equality
     * nor by comparing identities (i.e. getId() === getId()).
     *
     * However, you do not need to compare every attribute, but only those that
     * are relevant for assessing whether re-authentication is required.
     *
     * @param AccountInterface $account
     * @return Boolean
     */
    function equals(AccountInterface $account) {
        if (!$account instanceof User) {
            return false;
        }

        if ($this->password !== $account->getPassword()) {
            return false;
        }

        if ($this->getSalt() !== $account->getSalt()) {
            return false;
        }

        if ($this->username !== $account->getUsername()) {
            return false;
        }

        return true;
    }
}