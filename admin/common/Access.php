<?php

class Access {

    function isPrivileged(){
        global $user;
        if (isset($user->data['Group']) && $user->data['Group']=='admin') return true;
        return false;
    }

    function check($module, $action='view'){
        global $db, $user;

        if (Access::isPrivileged()) return true;

        $sql = $db->prepare("SELECT IsShow as `view`, IsAdd as `create`, IsChange as `modify`, IsDelete as `delete`, IsPublish as publish FROM ".DB_PREFIX."modules_rights as r LEFT JOIN ".DB_PREFIX."modules as m ON (m.ID=r.ModuleID AND m.Active='1') WHERE (r.UserID='".$user->data['ID']."' OR r.GroupID='".$user->data['GroupID']."')  AND m.Link='".$module."' GROUP BY r.ModuleID");
        $res = $db->Execute($sql);
        if ($res && $res->RecordCount() > 0){
            if ($res->fields[$action]==1) return true;
        }
        return false;
    }
}
