<?php
//error_reporting(0);
//define diretório do sistema
define("BASEPATH", dirname(__FILE__)."/");
define("BASEURL", "http://www.portalc.com.br/lojavirtual/paineladm/");
define("BASESITE", "http://localhost/lojavirtual/");
define("ADMURL", BASEURL."painel.php/");
define("CLASSPATH", "classes/");
define("MODULESPATH", "modules/");
define("CSSPATH", "css/");
define("JSPATH", "js/");
define("IMAGESPATH", "/lojavirtual/upload/images/");
define("IMAGESPATHSERVICOS", "/upload/images/servicos/");
define("IMAGESPATHPORTFOLIO", "/upload/images/portfolio/");

//define data base
define("DBHOST", "localhost");
define("DBUSER", "portalcc_admin");
define("DBPASS", "@logportalc2013");
define("DBNAME", "portalcc_lojavirtual");


//echo BASEURL.CSSPATH."  Base URL";
//echo "<br>". dirname(BASEPATH.CLASSPATH)."  Base PATH URL";

// REQUIRED FOR PHP 5.1+
date_default_timezone_set('America/Sao_Paulo');

// THE LIFE OF THE "REMEMBER ME" COOKIE
define('REMEMBER', 60*60*24*7); // ONE WEEK IN SECONDS


?>