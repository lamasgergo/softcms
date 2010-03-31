<?php
class Access {

    public static function check($module, $action) {
        $obReg = ObjectRegistry::getInstance();
        $db = $obReg->get('db');
        $user = $obReg->get('user');

        $module = strtolower($module);
        $action = strtolower($action);

        if (!$module || !$action) return false;
        
        if ($user->isAdmin()) return true;

        $query = $db->prepare("SELECT Approved FROM " . DB_PREFIX . "modules_rights WHERE Module='".$module."' AND `Action`='".$action."' AND (`Group`='".$user->get('Group')."' OR UserID='".$user->get('ID')."') ORDER BY Approved DESC");
        $res = $db->Execute($query);
        if ($res && $res->RecordCount() > 0) {
            if ($res->fields["Approved"] == "1") return true;
        }
        return false;
    }
}

?>