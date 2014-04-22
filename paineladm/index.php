<?php error_reporting(0);

session_start();

if (file_exists(dirname(__FILE__) . "/util/functions.php")) :
	//echo "<br> - index - functions - "."passou aqui";
	if (
	require_once (dirname(__FILE__) . "/util/functions.php")) :
	//echo  "<br> - index - ".BASEURL."/util/functions.php";
	else :
	//echo  "<br> - index - erro ao carregar functions";
	endif;
else :
	echo "cb-000 - Erro fatal de diretórios - Contate o Administrador";
	exit ;
endif;
$_SESSION = array();
//if ($_REQUEST['logoff'] == "true") doLogout();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<title>Loja Virtual :: Adm Panel</title>
		<link rel="shortcut icon" href="/images/favicon.ico">
		<script src="paineladm/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="paineladm/ckeditor/ckeditor.js" charset="utf-8"></script>
		<?php //echo "passou aqui";
			loadCSS('style');
			loadJS('jquery');
			loadJS('generic');
		?>
	</head>

	<body>
		<?php
		loadModules("login", "login");
		?>
	</body>
</html>