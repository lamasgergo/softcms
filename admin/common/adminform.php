<?php

class AdminForm{

	private static $tabs = array();
	private static $tabCounter = 0;
	
	public static function addTab($obj){
		self::$tabs[self::$tabCounter] = array(
						"name"		=> $obj->getName(),
						"value"		=> $obj->getTabContent(),
						"menu"		=> $obj->getMenu(),
						"filter"	=> $obj->getFilter()
						);
        self::$tabCounter++;
	}
	
	public static function parseTabNames($module){
        global $locale;
		$names = array();
		foreach (self::$tabs as $tab){
            $tabName = Locale::get($module."_".strtolower($tab["name"]));
			array_push($names,"'".$tabName."'");
		}
		return implode(",",$names);
	}
	
	public static function showTabs($module){
        global $smarty,$language;

		$smarty->assign("module", $module);
		$smarty->assign("tabs", self::$tabs);
		$smarty->assign("tabs_names", self::parseTabNames($module));
		$smarty->assign("tabs_count",count(self::$tabs));

        $main_tpl = $module.'/main.tpl';

        if (!file_exists($smarty->template_exists($main_tpl))){
            $main_tpl = 'admin/modules/main.tpl';
        }

		return $smarty->fetch($main_tpl, null, $language);
	}
	
}
?>