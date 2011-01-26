<?php
namespace Application\UserBundle\Entity;

use Symfony\Component\Security\User\AccountInterface;
use Symfony\Component\Security\User\UserProviderInterface;
/**
 * @orm:Entity(repositoryClass="Application\UserBundle\Entity\UserRepository")
 * @orm:table(name="Users")
 */
class User implements AccountInterface{

    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue
     */
    private $id;

    /**
     * @orm:Column(type="string", length="255", unique="true")
     * @validation:NotBlank()
     * @validation:Email
     */
    private $email;

    /**
     * @orm:Column
     * @validation:NotBlank()
     * @validation:MinLength(5)
     */
    private $password;

    /**
     * @orm:Column(length=16)
     */
    private $salt;

    /**
     * @orm:Column(type="string", length="255")
     * @validation:NotBlank()
     * @validation:MinLength(3)
     */
    private $name;

    /**
     * @orm:Column(type="string", length="255")
     * @validation:NotBlank()
     * @validation:MinLength(3)
     */
    private $surname;

    /**
     * @orm:Column(type="string", length="255", nullable=true)
     */
    private $pantronymic;

    /**
     * @orm:ManyToOne(targetEntity="UserType", inversedBy="users")
     * @orm:JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $types;

    /**
     * @orm:OneToOne(targetEntity="UserData", mappedBy="user")
     */
    private $address;

    /**
     * @var bool
     * $orm:Column(type="tinyint(1)")
     */
    private $published = false;
    
    /**
     * @orm:Column(type="datetime")
     */
    private $createdAt;

    /**
     * @validation:AssertTrue(message="Please accept the terms and conditions")
     */
    public $termsAccepted = false;

    public function __construct() {
        $this->createdAt = new \DateTime();
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
    }

    public function getPantronymic() {
        return $this->pantronymic;
    }

    public function setPantronymic($pantronymic) {
        $this->pantronymic = $pantronymic;
    }

    public function getTypes() {
        return $this->types;
    }

    public function setTypes($types) {
        $this->types = $types;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getPublished() {
        return $this->published;
    }

    public function setPublished(boolean $published) {
        $this->published = $published;
    }

    /**
     * Returns a string representation of the User.
     *
     * @return string A string return of the User
     */
    function __toString() {
        // TODO: Implement __toString() method.
    }

    /**
     * Removes sensitive data from the user.
     */
    function eraseCredentials() {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * Returns the roles granted to the user.
     *
     * @return Role[] The user roles
     */
    function getRoles() {
        // TODO: Implement getRoles() method.
    }

    /**
     * Returns the salt.
     *
     * @return string The salt
     */
    function getSalt() {
        return $this->salt;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    function getUsername() {
        return $this->getEmail();
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
        return ($this->getEmail() === $account->getEmail());
    }
}

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository implements UserProviderInterface{

    public function findAll(){
        return $this->_em->createQuery("SELECT u FROM UserBundle:User u ORDER BY u.cratedAt DESC")->getResult();
    }

    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param  string $username The username
     *
     * @return AccountInterface A user instance
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    function loadUserByUsername($username) {
        return $this->findOneBy(array('email' => $username));
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

