<?php
namespace Common\ContentBundle\Entity;

use Common\ContentBundle\Entity\Content;

/**
 * @orm:Entity
 */
class News extends Content{

    protected $type = 'news';

}