<?php //error_reporting(0);
error_reporting(E_ALL & E_NOTICE & E_STRICT & E_DEPRECATED);
include ('header.php');
?>

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="js/chat.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="modules/chat_adm/js/functions.js"></script>
<script type="text/javascript" src="modules/chat_adm/js/chat.js"></script>
<link href="modules/chat_adm/css/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
	function chamarChat() {
		divchat = document.getElementById('contatos');
		$(divchat).load('modules/chat_adm/chamachat.php');
	}

	cChat = setInterval(chamarChat, 25000); 
</script>

<?php
if (isset($_SESSION['userid'])):
//echo "---> existe sessão";
else:
//echo "---> não existe sessão";
?>
<div id="content">
	<p>
		Usuário não autênticado, favor autenticar-se
	</p>
	<li>
		<a href="index.php?error=cb-904&msgtype=erro">Fazer Login
	</li></a>
</div>
<?php exit ;  // finaliza a rotina - usuário não autentica acima
endif;
$mod_loja = "";
if ($panel == 'loja'):
	include ('sidebar_loja.php');
else:
	include ('sidebar.php');
endif;
?>
<div id="content">
	<?php

	if (isset($module) && isset($screen)) :
		if ($panel == "loja") :
			$mod_loja = "loja/";
			loadModules($mod_loja.$module, $screen);
		else :
			loadModules($module, $screen);
		endif;
	else :
		$em = "admin@hotmail.com";
		// Monta campo informativo das noticias
		echo '<div id="noticias">';
		//echo '<script src="http://g1.globo.com/Portal/G1V2/js/addNewsHorizontal.js" type="text/javascript"></script>';
		//echo '<script src="//www.gmodules.com/ig/ifr?url=http://hosting.gmodules.com/ig/gadgets/file/109279996171245420817/google-news.xml&amp;up_ned=pt-BR_br&amp;up_items=8&amp;up_show_image=1&amp;up_font_size=12pt&amp;up_selectedTab=0&amp;up_tabs=&amp;up_last_url=&amp;up_onebox=&amp;synd=open&amp;w=600&amp;h=300&amp;title=Not%C3%ADcias+-+Fonte%3A+Google&amp;lang=pt-BR&amp;country=ALL&amp;border=%23ffffff%7C0px%2C1px+solid+%23993333%7C0px%2C1px+solid+%23bb5555%7C0px%2C1px+solid+%23DD7777%7C0px%2C2px+solid+%23EE8888&amp;output=js"></script>';
		//echo '<script src="//www.gmodules.com/ig/ifr?url=http://hosting.gmodules.com/ig/gadgets/file/104147346123221544674/skype2.xml&up_myname=yourjovi&up_bg_img=http%3A%2F%2F&synd=open&w=245&h=220&title=SkypeMe2.0+%3A+__UP_myname__+!!&border=%23ffffff%7C3px%2C1px+solid+%23999999&output=js"></script>';
		echo '</div>';

		echo '<div id="incluir_chat" >';
		//echo "---------------------------------->".((dirname(__FILE__)));
		include_once (dirname(__FILE__) . '/modules/chat_adm/chat.php');
		echo '</div>';
	//echo '<p>Escolha uma opção ao lado</p>';
	//echo dirname(dirname(__FILE__));
	//loadModules(chat_adm,chat);

	endif;
	?>
	<!--<div id="cont-chat">
	<object width="880px" height="650px" data="modules/chat_adm/index.php?em=admin@hotmail.com>"></object>
	</div>-->
</div>
<!--Final DIV id=content -->