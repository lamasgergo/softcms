<?php
namespace Application\ContentBundle\Entity;

/**
 * @orm:Entity
 * @orm:Table(name="content")
 */
class Content {
    /**
     * @orm:Column(name="id", type="integer")
     * @orm:Id
     * @orm:GeneratedValue(strategy="AUTO")
     * @var integer
     */
    private $Id;

    /**
     * @orm:Column(name="dataType", type="string", length="255")
     * @var string
     */
    private $type;

    /**
     * @orm:OneToOne(targetEntity="Application\UserBundle\Entity\User", inversedBy="content")
     * @orm:JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @orm:Column
     * @var string
     */
    private $title;

    /**
     * @orm:Column(type="text")
     * @var string
     */
    private $teaser;

    /**
     * @orm:Column(type="text")
     * @var string
     */
    private $content;

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

    public function getId() {
        return $this->Id;
    }

    public function setId($Id) {
        $this->Id = $Id;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getTeaser() {
        return $this->teaser;
    }

    public function setTeaser($teaser) {
        $this->teaser = $teaser;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

}