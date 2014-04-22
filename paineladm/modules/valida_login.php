<?php
//echo "<br> - valida login -".(dirname(dirname(__FILE__))."/util/functions.php");
//require_once(dirname(dirname(__FILE__))."/functions.php");
//protectFile(basename(__FILE__));
		$usuario = $_REQUEST['usuario'];
		$senha   = $_REQUEST['senha'];
		//$rme     = $_REQUEST['rme'];
		$uuk     = $_REQUEST['uuk'];

		require_once(dirname(dirname(__FILE__))."/util/functions.php");
		//echo (dirname(dirname(__FILE__))."/functions.php");
		//echo "<br>".(basename(__FILE__));
		//exit;
		protectFile(basename(__FILE__));
		// Rotina comum - Entrar com usuario e senha no form
		$userdb = new users();
		$userdb->setValue('login',$usuario);
		$userdb->setValue('senha',$senha);
		$userdb->setValue('uuk',$uuk);
		//echo "<br>passou aqui --------------------";
		//exit;
		if ($userdb->doLogin($userdb)):
		   // IS THE "REMEMBER ME" CHECKBOX SET?
	        /*if (isset($rme)):
				$userdb->extra_select = "WHERE login='".$usuario."' and senha='".modifyPassw($senha)."'";
				$userdb->selectAll($userdb);
				$resdb = $userdb->returnData();		            
	            //echo "<br> Chave UUK :".$resdb->uuk;
	            remember_me('$resdb->uuk');
			else:
				// Deleta o cookie definido anteriormente
				//echo "---------------PASSOU AQUI------------------------------";
				delete_remember_me('uuk');
				
			endif;*/
			//$monta_raiz = "../";
			echo '<script>location.href="../painel.php"</script>';
			//loadModules("painel","module_painel");
			//echo "passou aqui ";
			//header('location: painel.php');
			//echo "<br>passou aqui ";
			exit;
		else:
			/*
			//redirectTo('painel.php'); */
			//redirectTo('index.php');
			header('location: ../index.php?error=cb-903&msgtype=erro');
			 echo "erro no login";
		endif;
		?>