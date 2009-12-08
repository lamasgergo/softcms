<?php


class Content extends UI{

    function Content(){
        parent::UI();
        $this->setName(strtolower(__CLASS__));

    }

    function prepareOutput(){
        if ($this->vars['type']=='article'){
            $this->obj = new ContentItem();
        } else {
            $this->obj = new ContentCategory();
        }
        if ($this->vars['id']) $this->obj->setID($this->vars['id']);

        $this->data = $this->obj->getData();
    }


}


class ContentItem extends base{

    var $_table = '#content';
    var $_tableKey = 'ID';

    function ContentItem(){
        parent::base();
    }
}

class ContentCategory extends base{

    var $_table = '#content_categories';
    var $_tableKey = 'ID';

    function ContentItem(){
        parent::base();
    }
}

?>