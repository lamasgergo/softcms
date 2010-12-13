<?php
class Access {

    public static function check($module, $action) {
        global $db;
        $user = User::getInstance();
        
        $module = strtolower($module);
        $action = strtolower($action);

        if (!$module || !$action) return false;
        
        if ($user->isAdmin()) return true;

        $query = $db->prepare("SELECT Approved FROM " . DB_PREFIX . "modules_rights WHERE Module='".$module."' AND `Action`='".$action."' AND (`Group`='".$user->get('Group')."' OR UserID='".$user->get('ID')."') ORDER BY Approved DESC LIMIT 1");
        $res = $db->Execute($query);
        if ($res && $res->RecordCount() > 0) {
            if ($res->fields["Approved"] == "1") return true;
        }
        return false;
    }

    public static function getAllowedLanguages($module, $action){
        global $db;
        $user = User::getInstance();
        $languages = array_keys(LanguageService::getInstance()->getAll());

        if ($user->isAdmin()) return $languages;

        $query = $db->prepare("SELECT Lang FROM " . DB_PREFIX . "modules_rights WHERE Module='".$module."' AND `Action`='".$action."' AND (`Group`='".$user->get('Group')."' OR UserID='".$user->get('ID')."') AND Approved='1' ORDER BY Lang ASC");
        $res = $db->Execute($query);
        $result = array();
        if ($res && $res->RecordCount() > 0) {
            while (!$res->EOF){
                if (empty($res->fields["Lang"])) return $languages;
                $result[] = $res->fields["Lang"];
                $res->MoveNext();
            }
        }
        return $result;
    }
}

?>