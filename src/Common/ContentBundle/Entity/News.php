<?php
namespace Application\ContentBundle\Entity;

use Application\ContentBundle\Entity\Content;

/**
 * @orm:Entity
 */
class News extends Content{

    protected $type = 'news';

}