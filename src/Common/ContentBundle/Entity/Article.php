<?php
namespace Application\ContentBundle\Entity;

use Application\ContentBundle\Entity\Content;

/**
 * @orm:Entity
 */
class Article extends Content{

    protected $type = 'article';

}