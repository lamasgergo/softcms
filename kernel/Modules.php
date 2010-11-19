<?php
class Modules {
    public static function check($module=''){
        global $db;
        if (empty($module)) return false;
        $module = mysql_real_escape_string($module);
        $query = $db->Prepare("SELECT Name FROM ".DB_PREFIX."modules WHERE Active='1' AND Name='{$module}'");
        $rs = $db->Execute($query);
        if ($rs && $rs->RecordCount() > 0){
            return true;
        }
        return false;
    }
}
?>