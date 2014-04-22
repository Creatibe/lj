<?php
$pathlocal = dirname(dirname(__FILE__));

require_once $pathlocal."/util/functions.php";
function __autoload($class){
	$pathlocal = dirname(__FILE__);
	$class = str_replace('..','',$class);
	require_once($pathlocal."/$class.class.php");
	} 
?>