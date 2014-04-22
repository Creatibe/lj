<?php
//define diretório do sistema
define("BASEPATH", dirname(__FILE__)."/");
define("BASEURL", "http://www.portalc.com.br/lojavirtual/");
define("BLOGURL", BASEURL."blog/blog.php/");
define("CLASSPATH", "/classes/");
define("MODULESPATH", dirname(dirname(__FILE__))."/modules/");
define("CSSPATH", "css/");
define("JSPATH", "js/");
define("IMAGESPATH", "upload/images/");
//define("UTILPATH", BASEPATH."util/");

//echo UTILPATH." - UtilPath<br>";
//echo MODULESPATH." - ModulesPath<br>";
//echo CLASSPATH." - ClassPath<br>";

//define data base
define("DBHOST", "localhost");
define("DBUSER", "portalcc_admin");
define("DBPASS", "@logportalc2013");
define("DBNAME", "portalcc_lojavirtual");

//echo dirname(BASEPATH)."  - Base Path<br>";
//echo  BASEPATH."  - Base Path<br>";
?>