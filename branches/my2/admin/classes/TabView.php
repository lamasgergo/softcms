<?php

class TabView{

	private static $tabs = array();
	private static $tabCounter = 0;
	
	public static function add($obj){
		self::$tabs[self::$tabCounter] = array(
						"name"		=> $obj->getName(),
						"value"		=> $obj->getTabContent(),
						);
        self::$tabCounter++;
	}
	
	public static function parseTabNames($module){
        global $locale;
		$names = array();
		foreach (self::$tabs as $tab){
            $tabName = Locale::get($tab["name"], $module);
			array_push($names,"'".$tabName."'");
		}
		return implode(",",$names);
	}
	
	public static function show(){
        global $smarty,$language;

        $module = $_GET[Settings::get('modules_varname')];

		$smarty->assign("module", $module);
		$smarty->assign("tabs", self::$tabs);
		$smarty->assign("tabs_names", self::parseTabNames($module));
		$smarty->assign("tabs_count",count(self::$tabs));

        $main_tpl = $module.'/main.tpl';

        if (!file_exists($smarty->templateExists($main_tpl))){
            $main_tpl = 'admin/modules/main.tpl';
        }

		return $smarty->fetch($main_tpl, null, $language);
	}
	
}
?>