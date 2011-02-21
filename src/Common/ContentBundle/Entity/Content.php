<?php
namespace Common\ContentBundle\Entity;

/**
 * @orm:Entity
 * @orm:table(name="content")
 * @orm:InheritanceType("SINGLE_TABLE")
 * @orm:DiscriminatorColumn(name="dataType", type="string")
 * @orm:DiscriminatorMap({"article" = "Article", "news" = "News"})
 * @orm:HasLifecycleCallbacks
 */
abstract class Content {
    /**
     * @orm:Column(name="id", type="integer")
     * @orm:Id
     * @orm:GeneratedValue(strategy="AUTO")
     * @var integer
     */
    private $Id;

    /**
     * @orm:ManyToOne(targetEntity="Common\UserBundle\Entity\User", inversedBy="content")
     * @orm:JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @orm:Column
     * @var string
     * @validation:NotBlank
     */
    private $title;

    /**
     * @orm:Column(type="text", nullable="true")
     * @var string
     */
    private $teaser;

    /**
     * @orm:Column(type="text")
     * @var string
     * @validation:NotBlank
     */
    private $content;

    /**
     * @orm:Column(nullable="true")
     * @var string
     */
    private $url;

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
     * @orm:PrePersist
     */
    public function doPrePersist() {
        $this->setTeaser();
        $this->setUrl();
    }

    /**
     * @orm:PreUpdate
     */
    public function doPreUpdate() {
        $this->setTeaser();
        $this->setUrl();
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

    public function setTeaser($teaser='') {
        if (empty($teaser)){
            $teaser = \Utils\HTMLCutter::cut($this->content);
        }
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

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url='') {
        if (empty($url)){
            $url = \Utils\Translit::encode($this->title);
        }
        $this->url = $url;
    }

    public function setCreated($created) {
        $this->created = $created;
    }

    public function getCreated() {
        return $this->created;
    }

    public function setUpdated($updated) {
        $this->updated = $updated;
    }

    public function getUpdated() {
        return $this->updated;
    }

}