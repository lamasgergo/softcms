<?php
class Meta{

    private static $id;

    public static $title;
    public static $keywords;
    public static $description;
    public static $alt;

    public static function setMetaByID($id){
        self::setID($id);
        self::getDataByID();
    }

    public static function setID($id){
        $id = (int)$id;
        if ($id) self::$id = $id;
    }

    private static function getDataByID($id=''){
        global $db;
        if (empty($id)) $id = self::$id;

        if (empty($id)) return false;

        $query = $db->Prepare("SELECT MetaTitle, MetaDescription, MetaKeywords, MetaAlt FROM ".DB_PREFIX."data WHERE ID='{$id}'");
        $rs = $db->Execute($query);
        if ($rs && $rs->RecordCount() > 0){
            self::$alt = $rs->fields['MetaAlt'];
            self::$description = $rs->fields['MetaDescription'];
            self::$keywords = $rs->fields['MetaKeywords'];
            self::$title = $rs->fields['MetaTitle'];
        }
    }

    public function getTitle(){
        $title = Settings::get("meta_title");
        if (self::$title){
            $title = self::$title .' - '.$title;
        }
        return $title;
    }

    public function getDescription(){
        $description = Settings::get("meta_description");
        if (self::$title){
            $description = self::$description .' - '.$description;
        }
        return $description;
    }

    public function getKeywords(){
        $keywords = Settings::get("meta_keywords");
        if (self::$title){
            $keywords = self::$keywords .' - '.$keywords;
        }
        return $keywords;
    }
}
?>
 
