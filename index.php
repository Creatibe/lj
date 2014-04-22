<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>Libertar - Casa de Recuperação - TEXTO EDITADO</title>
<link rel="stylesheet" type="text/css" href="css/libertar.css">
<script type="text/javascript" src="js/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="js/libertar.js"></script>
<link href="css/style_blog.css" rel="stylesheet" type="text/css" />

</head>

<body>
<?php 

if (isset($_REQUEST['m'])):
	$chama_pagina = $_REQUEST['m'];
else:
	$chama_pagina = "home";
endif;
if ($chama_pagina != "home")
	echo '<div id=page'.$chama_pagina.' class="page"> <!-- abre page'.$chama_pagina.' -->';
?>

<div id="traco"></div>

	<?php
		include ('paginas/header.php');
		if ($chama_pagina == "artigos"):
			$limite_artigos = ""; 
		else: 
			$limite_artigos = "LIMIT 4";
		endif;
		if($chama_pagina == 'single')
			include ("modules//blog/".$chama_pagina.".php");
		else 
			include ("paginas/".$chama_pagina.".php");
		if ($chama_pagina != "home")
			echo '</div> <!-- fecha page'.$chama_pagina.' -->';
		if ($monta_artigos == 'sim' and $chama_pagina != 'artigos' and $chama_pagina != 'contato' and $chama_pagina != 'single')
			include ('paginas/artigos.php');
		//elseif ($monta_artigos == 'sim' and $chama_pagina == 'artigos')
		//	require ('modules/blog/single.php');
		include ('paginas/footer.php');
	?>




		
<?php
//echo (dirname(__FILE__))."/modules <br>";
if (file_exists(dirname(__FILE__) . "/util/functions.php")) :
	require_once (dirname(__FILE__) . "/util/functions.php");
else :
	echo "cb-000 - Erro fatal de diretórios - Contate o Administrador";
	exit ;
endif;
/* // Grava log de visitas
if (isset($_REQUEST['msg'])):
	$pagina = "contatos";
	require_once (dirname(__FILE__) . "/modules/visitas.php");
else:
	$pagina = "home";
	require_once (dirname(__FILE__) . "/modules/visitas.php");
endif; 
 
 */
$config = new cb_config();
$config->extra_select="where status = 1 and titulo = 'chat'";	
$config->selectAll($config);
$res = $config->returnData();
if ($config->countline >0):
	$relev = trim(substr($res->descr_config,0,1));
	$resp  = trim(substr($res->descr_config,2,1));
	
?>
		<div id="cont-chat">
			<object class="embed-chat" data="modules/chat/index.php?rl=<?php echo $relev?>&rp=<?php echo $resp?>"></object>
		</div>
<?php endif;?>
		
		


</body>

</html>