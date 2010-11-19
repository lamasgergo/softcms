<?php
class LocaleDB {
    private static $lang;
    private static $table = 'vocabulary';

    function __construct(){
        $lang = Settings::get('default_lang');
        $user = User::getInstance();
        if ($user){
            $lang = $user->get('EditLang');
        }
        self::$lang = $lang;
    }

    public static function get($key, $context='DEFAULT'){
        global $db;
        $value = $key;
        $lang = self::$lang;
        $query = $db->Prepare("SELECT `Value` FROM ".DB_PREFIX.self::$table." WHERE `Key`='{$key}' AND `Context`='{$context}' AND `Lang`='{$lang}'");
        $res = $db->Execute($query);
        if ($res && $res->RecordCount() > 0){
            $value  = $res->fields['Value'];
        } else {
            if (Settings::get('locale_auto_fill')){
                $query = $db->Prepare("INSERT INTO ".DB_PREFIX.self::$table."(`Key`, `Context`, `Value`, `Lang`) VALUES('{$key}', '{$context}', '{$value}', '{$lang}')");
                $db->Execute($query);
            }
        }
        return $value;
    }

}
?>