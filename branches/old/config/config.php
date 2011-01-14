<?php

class Config{

    var $DB_HOST = "localhost";
    var $DB_USER = "root";
    var $DB_PASS = "";
    var $DB_NAME = "tour";
    var $DB_PREFIX = "bs_";
    var $DB_CHARSET = "utf8";
    var $DB_COLLATION = "utf8_general_ci";


    var $MOD_REWRITE = true;

    var $DEFAULT_LANG = "ru";
    var $SUPPORTED_LANGUAGES = array(
        'ru',
        'ua',
        'en'
    );

    var $SUPPORTED_LANGUAGES_LIST = array(
				'ru' => 'Russian',
				'ua' => 'Ukrainian',
				'en' => 'English'
	);

    /* session */
    var $SES_PREFIX = "BS_";

    /* URL */
    var $MODULE = "mod";

    /* Upload */
    var $uploadDirectory = "/shared/files/";
    var $uploadDirectoryURL = "/shared/files/";
    var $tmpuploadDirectory = "/shared/files/tmp/";
    var $tmpuploadDirectoryURL = "/shared/files/tmp/";


    /* email */
    var $infoFromEmail = "a.diesel@gmail.com";
    var $infoFromEmailName = "Contact form";
    var $adminEmail = "a.diesel@gmail.com";


    /* navifation items per page*/
    var $navigatorMaxPages = 10;
    var $navigationLimit = 4;

}

$config = new Config();
?>
