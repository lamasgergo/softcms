<?
/* [GLOBALS] */
define("__PATH__",$_SERVER['DOCUMENT_ROOT']);
define("__LIBS__",__PATH__."/kernel");

/* ADMINISTRATION */
define("A_TEMPLATES", __PATH__."/admin/source/templates");
define("A_TRUSTED_DIR", __PATH__."/admin/source/trusted_dir");
define("__ADMIN__",__PATH__."/admin");

define('ROOT_REDIRECT', '');
define('SITE_URL', '');

/* [SMARTY] */
define("TEMPLATES", __PATH__."/source/templates");
define("TEMPLATES_C", __PATH__."/source/templates_c");
define("PLUGINS_DIR", __PATH__."/source/plugins");
define("TRUSTED_DIR", __PATH__."/source/trusted_dir");
define("IMAGES_DIR", SITE_URL."/source/images");
define("DESIGN_IMAGES_DIR", SITE_URL."/source/templates/design");
define("CSS_DIR", SITE_URL."/source/css");
define("JS_DIR", SITE_URL."/source/js");

/* [DB] */
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "hypermarket.org.ua");
define("DB_PREFIX","bs_");
define("SDB_PREFIX","bs_sh_");
define("DB_CHARSET","utf8");
define("DB_COLLATION","utf8_general_ci");
/* mod_rewrite */
define("MOD_REWRITE", false);


/* lang */
if (!defined('DEFAULT_LANG')){
	define("DEFAULT_LANG" , "ru");
}
include_once($_SERVER['DOCUMENT_ROOT'].'/config/lang/languages.php');

/* session */
define("SES_PREFIX","BS_");

/* URL */
define("MODULE","mod");
define("HOST",$_SERVER["HTTP_HOST"]);

/* Upload */
define("uploadDirectory",__PATH__."/files/");
define("uploadDirectoryURL", SITE_URL."/files/");
define("tmpuploadDirectory",__PATH__."/files/tmp/");
define("tmpuploadDirectoryURL", SITE_URL."/files/tmp/");

define("menuUploadDirectory", __PATH__."/files/menu/");
define("menuUploadDirectoryURL", SITE_URL."/files/menu/");

/* Modules */
define("MODULES_DIR",__PATH__."/modules");


/* email */
define('infoFromEmail', 'a.diesel@gmail.com');
define('infoFromEmailName', 'Contact form');
define('adminEmail', 'a.diesel@gmail.com');


/* navifation items per page*/
define("navigatorMaxPages",10);
define("navigationLimit",4);

/* autoload modules configs*/
$config_dir = dir(__PATH__.'/config/modules_cfg/');
while (false !== ($config_file = $config_dir->read())) {
  if ($config_file != '.' && $config_file !='..' && preg_match("/.*\.php/",$config_file)){
    include_once($config_dir->path.$config_file);
  }
}
$config_dir->close();
?>
