<?php


class Gallery extends UI{

    function Gallery(){
        parent::UI();
        $this->setName(strtolower(__CLASS__));

    }

    function prepareOutput(){
        if ($this->vars['type']=='image'){
            $this->obj = new GalleryItem();
        } else {
            $this->obj = new GalleryCategory();
        }
        if ($this->vars['id']) $this->obj->setID($this->vars['id']);

        $this->data = $this->obj->getData();
    }


}


class GalleryItem extends base{

    var $_table = '#gallery';
    var $_tableKey = 'ID';

    function GalleryItem(){
        parent::base();
    }
}

class GalleryCategory extends base{

    var $_table = '#gallery_categories';
    var $_tableKey = 'ID';

    function GalleryItem(){
        parent::base();
    }
}

?>