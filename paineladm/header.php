<?php
//error_reporting(0);
//error_reporting(E_ALL & E_NOTICE & E_STRICT & E_DEPRECATED);
//echo "<br> Header - ".(dirname(__FILE__)."/util/functions.php");
require_once(dirname(__FILE__)."/util/functions.php");
protectFile(basename(__FILE__)); //Protege arquivo de funções
verifyLogin();
$session = new session();
if (isset($_GET['m'])) $module = $_REQUEST['m'];
if (isset($_GET['s'])) $screen = $_REQUEST['s'];
if (isset($_GET['p'])) $panel  = $_REQUEST['p'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="description" content="">
<meta name="keywords" content="">
<title>Libertar:: Adm Panel</title>
<link rel="shortcut icon" href="/images/favicon.ico">
<?php
loadCSS('style'); 
loadJS('jquery');  
loadJS('generic'); 
?>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div class="principal">
<?php
//loadModules('verificar_msgs',TRUE);
include (dirname(__FILE__)."/modules/verificar_msgs.php");
//echo "<br> ...onde estou ? : ".(dirname(__FILE__)."/modules/verificar_msgs.php");


?>	
	
	<div id="wrapper">
    		<div id="fast-nav">
    			<ul>
    				<li><a href="#"> <?php echo $msgs;?> </a></li>
    				<li><a href="#"> Atualizações </a></li>
    				<li><a href="#"> Suporte </a></li>
    			</ul>
    		</div>
    	<div id="wrap-content">