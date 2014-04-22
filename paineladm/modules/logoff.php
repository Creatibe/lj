<?php
//echo (dirname(dirname(__FILE__))."/functions.php");
require_once(dirname(dirname(__FILE__))."/util/functions.php");
protectFile(basename(__FILE__));
doLogout();
exit;
loadJS('jquery-validate');  
loadJS('jquery-validate-messages');
if (isset($_REQUEST['error'])):
	$error = $_REQUEST['error'];
else:
	$error = 0;	 
endif;
if (isset($_REQUEST['msgtype'])):
	$msgtype = $_REQUEST['msgtype'];
else:
	$msgtype = "pergunta";	 
endif;
		//require_once('config.php');
		//Rotina para verificar se o usuário pediu para ser lembrado
		$login = "";
		$senha = "";
		$uuk = "";	
		
		if (!isset($_POST["rme"])):
					// Deleta o cookie definido anteriormente
					//echo "<br>---------------PASSOU AQUI------------------------------";
					delete_remember_me('uuk');
		endif;
		if (isset($_COOKIE['uuk'])):
			echo "<br> o valor de uuk é : ".$_COOKIE['uuk']."---";
  			if (isset($_COOKIE['uuk'])) $rme	= 1;
			else $rme = 0;
    		$userdb = new users();
			$userdb->extra_select = "WHERE uuk = '".$_COOKIE['uuk']."' LIMIT 1";
			$userdb->selectAll($userdb);
			if ($resdb = $userdb->returnData()):
				$login = $resdb->login;
				$senha = $resdb->senha;
				$uuk   = $resdb->uuk;
			endif;
		endif;
		if (!(isset($_POST['usuario']))):
			$usuario = $login;
		else:
		 	$usuario = $_POST['usuario'];
		endif;
		if (!(isset($_POST['senha']))):
			$senha = $senha;
		else:
		 	$senha = $_POST['senha'];
		endif;		

		?>
		
		<script type="text/javascript">
			$(document).ready(function(){
				$(".userform").validate({
					rules:{
						usuario:{required:true, minlength:3},
						senha:{required:true, rangelength:[4,32]},
						}
					});
				});
		</script>

        <div id="loginform">
	         <!-- <div id="loginform-logo"><!-- background img via CSS -->

		<div>
          <form class="userform" method="post" action="./modules/valida_login.php?uuk=<?php echo $uuk;?>">
              <fieldset>
              	<ul class="loginform-title">
              		<li>
                  		<p>Bem vindo ao be.web!</p>
                  		<p>Insira seu usuário e senha para fazer login.</p>
                  	</li>
                </ul>

                <ul class="loginform-form">
                    <li>
                        <label class="loginform-user" for="usuario">Login</label>
                        <input class="loginform-user" type="text" size="35" name="usuario" value="<?php echo $usuario;?>"/>
                    </li>
                    <li>
                        <label class="loginform-user" for="senha">Senha</label>
                        <input class="loginform-password" type="password" size="35" name="senha" value="<?php echo $senha;?>"/>
                    </li>
                    <li>
                        <label class="loginform-user" for="rme">Manter Conectado</label>
                        <input type="checkbox" name="rme" <?php if (isset($rme) == 1) echo 'checked="checked"'?>/>KEEP ME LOGGED IN (DO NOT CHECK THIS ON A PUBLIC COMPUTER)
                    </li>
                    <li class="loginform-submit">
                        <input type="submit" name="acessar" value="ENTRAR"/>
                    </li>
                </ul>
                <?php  getMSG($error,$msgtype,NULL);?>
              </fieldset>
          </form>
        </div>
        </div> 
