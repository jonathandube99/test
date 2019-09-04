<?php
	session_cache_limiter('nocache');
	session_cache_expire(1);
	session_start();
	
	$offset = 60 * 60 * 6;
	header("Cache-Control: max-age=$offset, must-revalidate");
	header("Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT");
	
	
	if($_REQUEST["JO"] == "debug") {
		error_reporting(E_ALL);
		ini_set("display_errors", 1);
	}
	
	
	ini_set("default_charset", 'utf-8');
	$ajax = false;
	$analytics = true;
	$realpath = realpath(dirname(__FILE__));
	
	// Inclure les librairies
		require_once "../www.cegepjonquiere.ca/cms/config.php";
		$config_main = $config;
		
		require_once "cms/config.php";
		if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
			require_once "cms/lib/php/class.mysqli.php";
		}
		require_once "lib/php/class.bd.php";
		require_once "lib/php/class.language.php";
		require_once "lib/php/class.utils.php";
		require_once "modules/mod_menu/class.mod_menu.php";
	// Fin inclure les librairies
	
	
	
	// Connection à la BD
		$bd 		= new BD;
		$connection = $bd->openConnection();
		
		$bd_main 	= new BD($config_main["bd_host"], $config_main["bd_user"], $config_main["bd_password"], $config_main["bd_name"]);
		$connection = $bd_main->openConnection();
	// FIN Connection à la BD
	
	
	
	// Instancier les class
		$language	= new Language;
		$utils 		= new Utils;
		$menu 		= new Menu;
	// FIN Instancier les class
	
	
	// PHP Mailer
		require '../www.cegepjonquiere.ca/lib/php/phpMailer.php';
	// FIN PPHP Mailer
	
	
	// Load le module
		$moduleView = $utils->getModule();
	// FIN Load le module
	
	
	
	// Load le template
		$suffix_media = trim($_POST["suffix_media"]);
		
		if($_REQUEST["tmpl"] == "raw") {
			echo $moduleView;
		} else {
			include("templates/default/index.php");
		}
	// FIN Load le template
	
	
	// Fermer la connection à la BD
		$connection = $bd->closeConnection();
	// FIN Fermer la connection à la BD
?>