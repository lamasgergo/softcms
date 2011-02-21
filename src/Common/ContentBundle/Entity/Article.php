<?php
namespace Common\ContentBundle\Entity;

use Common\ContentBundle\Entity\Content;

/**
 * @orm:Entity
 */
class Article extends Content{

    protected $type = 'article';

}