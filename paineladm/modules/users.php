<?php
//echo (dirname(dirname(__FILE__))."/util/functions.php");
require_once(dirname(dirname(__FILE__))."/util/functions.php");
protectFile(basename(__FILE__));
loadJS('jquery-validate');  
loadJS('jquery-validate-messages');
loadCSS("data-table","screen",FALSE);
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
		require_once('util/config.php');
		//Rotina para verificar se o usuário pediu para ser lembrado
		$login = "";
		$senha = "";
		$uuk = "";	
		
		if (!isset($_POST["rme"])):
					// Deleta o cookie definido anteriormente
					//echo "<br>---------------PASSOU AQUI------------------------------";
					//delete_remember_me('uuk');
		endif;
		if (isset($_COOKIE['uuk'])):
			//echo "<br> o valor de uuk é : ".$_COOKIE['uuk']."---";
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
switch ($screen):
	case 'incluir':
		echo '<h2>Cadastro de Usuários</h2>';
		if (!isset($_POST['nome']))	$nome = ""; else $nome = $_POST['nome'];
		if (!isset($_POST['email']))$email = ""; else $email = $_POST['email'];
		if (!isset($_POST['login']))$login = ""; else $login = $_POST['login'];
		if (!isset($_POST['senha']))$senha = ""; else $senha = $_POST['senha'];
		if (!isset($_POST['adm']))  $adm   = ""; else $adm   = $_POST['adm'];		
		if (!isset($_POST['confsenha']))$confsenha = ""; else $confsenha = $_POST['confsenha'];
		if (isset($_POST['cadastrar'])):
			$user = new users(array(
				'nome'=>$nome,
				'email'=>$email,
				'login'=>$login,
				'senha'=>modifyPassw($senha),
				'admin'=>($adm == 'on') ? 's' : 'n',
			));
			$duplicado = FALSE;
			if ($user->verifyReg('login',$_POST['login'])):
				getMSG("cb-910","alerta",$login,null);
				$duplicado = TRUE;
			endif;
			if ($user->verifyReg('email',$_POST['email'])):
				getMSG("cb-905","alerta",$login,null);
				$duplicado = TRUE;
			endif;			
			if ($duplicado != TRUE):
				$user->insertDB($user);
				if ($user->countline==1):
					$extra_msg = '<a href="'.ADMURL.'?m=users&s=listar">Exibir Cadastros</a>';
					getMSG('cb-911','sucesso',$extra_msg);
					unset ($_POST['nome']);
				endif;
			endif;
		endif;
		?>
        <script type="text/javascript">
			$(document).ready(function(){
				$(".userform").validate({
					rules:{
						nome:{required:true, minlength:5},
						email:{required:true, email:true},
						login:{required:true, minlength:5},
						senha:{required:true, rangelength:[4,10]},
						confsenha:{required:true, equalTo:"#senha"},
						}
					});
				});
		</script>	
	
		<form class="userform" method="post" action="">
			<fieldset>
				<legend>Formulário de Cadastro - Usuários</legend>
				<ul>
					<li><label for="nome">Nome:</label>
					<input class="userform-register" type="text" size="50" name="nome" value="<?php echo $nome;?>" /></li>
					<li><label for="email">Email:</label>
					<input class="userform-register" type="text" size="50" name="email" value="<?php echo $email;?>" /></li>			
					<li><label for="login">Login:</label>
					<input class="userform-register" type="text" size="35" name="login" value="<?php echo $login;?>" /></li>	
					<li><label for="senha">Senha:</label>
					<input class="userform-register" type="password" size="25" name="senha" id="senha" value="<?php echo $senha;?>" /></li>	
					<li><label for="confsenha">Repita a Senha:</label>
					<input class="userform-register" type="password" size="25" name="confsenha" value="<?php echo $confsenha;?>" /></li>	
					<li><label for="adm">Administrador:</label>
					<input type="checkbox" name="adm" <?php if(!isAdmin()): echo ' disabled="disabled" '; endif;
															if($adm) echo ' checked="checked"';
															?> /> dar controle total ao usuário</li>	
					<li class="center"><input type="submit" name="cadastrar" value="Salvar Dados" />
						               <input type="button" onclick="location.href='?m=users&s=listar'" value="Cancelar" />
						               </li>	
				</ul>
			</fieldset>
		</form>	
		<?php
	
	break;
	case 'listar':
		echo '<h2>Usuários Cadastrados</h2>';
		loadCSS("data-table","screen",TRUE);
		loadJS("jquery-datatable");
		?>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#listausers").dataTable({
					"oLanguage": {
						"sLengthMenu": " _MENU_ registros por página",
		          		"sZeroRecords": "Nenhum registro encontrado",
		            	"sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
		            	"sInfoEmpty": "Nenhum registro encontrado",
		            	"sInfoFiltered": "(filtrado de um total de _MAX_ registros)",
		            	"sSearch": "Pesquisar",
		            	"oPaginate":{
		            		"sPrevious": "Anterior",
		            		"sNext": "Próxima",
		            		"sFirst": "Primeira",
		            		"sLast": "Última",
		            	},
					},
					"sScrollY": "300px",
					"bPaginate": true,
					"aaSorting": [[ 0, "asc" ]]
				});
			});
		</script>
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="listausers">
			<thead>
				<tr>
					<th>Nome</th><th>E-mail</th><th>Login</th><th>Status</th><th>Nível</th><th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$user = new users();
				$user->selectAll($user);
				
				while ($res = $user->returnData()):
					if ($res->status == 0) $status = "Inativo"; 
					elseif ($res->status == 1) $status = "Ativo";
					elseif ($res->status == 2) $status = "Aprovar";
					elseif ($res->status == 3) $status = "Pendente";
					/*if ($res->relevancia == 0) $relevancia = "Baixa"; 
					elseif ($res->relevancia == 1) $relevancia = "Normal";
					elseif ($res->relevancia == 2) $relevancia = "Média";
					elseif ($res->relevancia == 3) $relevancia = "Alta";		*/		
					echo '<tr>';
					printf('<td>%s</td>',$res->nome);
					printf('<td>%s</td>',$res->email);
					printf('<td>%s</td>',$res->login);
					printf('<td>%s</td>',$status);
					printf('<td>%s</td>',$res->nivel);
					printf('<td class="center"><a href="?m=users&s=editar&id=%s" title="Editar"><img src="images/edit.png") 
					alt="Editar" /></a> </a> <a href="?m=users&s=senha&id=%s" title="Mudar Senha"><img src="images/passw.png") 
					alt="Mudar Senha" /></a></a> <a href="?m=users&s=excluir&id=%s" title="Excluir"><img src="images/delete.png") 
					alt="Excluir" /></a> </td>',$res->id,$res->id,$res->id);
					echo "</tr>";
				endwhile;
				?>
			</tbody>
		</table>
	<?php
	break;	
	case 'senha':
		echo "<h2>Alteração de Usuários - Senhas</h2>";
		$session = new session();
		if (isAdmin()== TRUE || $session->getVars("userid") == $_GET['id']):
			if (isset($_GET['id'])):
				//faz edição do usuário
				$id = $_GET['id'];
				if (isset($_POST['mudasenha'])):
					$user = new users(array(
						"senha" =>modifyPassw($_POST['senha']),
					));
					$user->pk_value = $id;
					$user->updateDB($user);
					if ($user->countline==1):
						getMSG('cb-908','sucesso',NULL);
						unset($_POST);
				 	else:
						getMSG('cb-907','alerta',NULL);
					endif;
				endif;
				$userdb = new users();
				$userdb->extra_select = "WHERE id=$id";
				$userdb->selectAll($userdb);
				$resdb = $userdb->returnData();
			else:
				getMSG('cb-906','alerta',NULL);
			endif;
			?>
	        <script type="text/javascript">
				$(document).ready(function(){
					$(".userform").validate({
						rules:{
							nome:{required:true, minlength:5},
							email:{required:true, email:true},
							login:{required:true, minlength:5},
							senha:{required:true, rangelength:[4,10]},
							confsenha:{required:true, equalTo:"#senha"}
							}
						});
					});
			</script>	
			<form class="userform" method="post" action="">
				<fieldset>
					<legend>Formulário de Alteração - Senha</legend>
					<ul>
						<li><label for="nome">Nome:</label>
						<input type="text" disabled="disabled" size="50" name="nome" value="<?php if (($resdb)) echo $resdb->nome; ?>" /></li>
						<li><label for="email">Email:</label>
						<input type="text" disabled="disabled" size="50" name="email" value="<?php if (($resdb)) echo $resdb->email;?>" /></li>			
						<li><label for="login">Login:</label>
						<input type="text" disabled="disabled" size="35" name="login" value="<?php if (($resdb)) echo $resdb->login;?>" /></li>	
						<li><label for="senha">Senha:</label>
						<input type="password" size="25" name="senha" id="senha" value="<?php echo $_POST['senha'];?>" /></li>	
						<li><label for="confsenha">Repita a Senha:</label>
						<input type="password" size="25" name="confsenha" value="<?php echo $_POST['confsenha'];?>" /></li>							
						<li><label for="ativo">Ativo:</label>
						<input type="checkbox" disabled="disabled" name="ativo" <?php if($resdb->ativo =="s"): echo ' checked="checked"'; endif;
																                ?> /> Habilita/Desabilta usuário</li>
						<li><label for="adm">Administrador:</label>								
						<input type="checkbox" disabled="disabled" name="adm" <?php if($resdb->admin =="s") echo ' checked="checked"';
																              ?> /> Dar controle total ao usuário</li>	
						<li class="center"><input type="submit" name="mudasenha" value="Alterar Senha" />
							               <input type="button" onclick="location.href='?m=users&s=listar'" value="Cancelar" />
							               </li>	
					</ul>
				</fieldset>
			</form>	
		<?php
		else:
			//printMSG('Você não tem permissão para efetuar alterações neste usuário. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "m=users&s=listar";
			getMSG('cb-909','alerta',NULL);
		endif;
	break;
	case 'editar':
		echo "<h2>Alteração de Senha</h2>";
		$session = new session();
		if (isAdmin()== TRUE || $session->getVars("userid") == $_GET['id']):
			if (isset($_GET['id'])):
				//faz edição do usuário
				$id = $_GET['id'];
				if (isset($_POST['editar'])):
					$user = new users(array(
						"nome" => $_POST['nome'],
						"email" => $_POST['email'],
						"status" => (isset($_POST['status']) == 'on') ? '1' : 'n',
						"nivel" => (isset($_POST['adm']) == 'on') ? '999' : 'n',
					));
					$user->pk_value = $id;
					$user->extra_select = "WHERE id=$id";
					$user->selectAll($user);
					$res = $user->returnData();
					if ($res->email != $_POST['email']):
						if ($user->verifyReg('email',$_POST['email'])):
							getMSG('cb-905','alerta',NULL);
							$duplicado = TRUE;
						endif;
					endif;
					if (isset($duplicado) != TRUE):
						$user->updateDB($user);
						if ($user->countline==1):
							getMSG('cb-908','sucesso',NULL);
							unset($_POST);
					 	else:
							getMSG('cb-907','alerta',NULL);
						endif;
					endif;
				endif;
				
				$userdb = new users();
				$userdb->extra_select = "WHERE id=$id";
				$userdb->selectAll($userdb);
				$resdb = $userdb->returnData();
			else:
				getMSG('cb-906','alerta',NULL);
			endif;
			?>
	        <script type="text/javascript">
				$(document).ready(function(){
					$(".userform").validate({
						rules:{
							nome:{required:true, minlength:5},
							email:{required:true, email:true}
							}
						});
					});
			</script>	
			<form class="userform" method="post" action="">
				<fieldset>
					<legend>Formulário de Alteração - Usuários</legend>
					<ul>
						<li><label for="nome">Nome:</label>
						<input type="text" size="50" name="nome" value="<?php if (($resdb)) echo $resdb->nome; ?>" /></li>
						<li><label for="email">Email:</label>
						<input type="text" size="50" name="email" value="<?php if (($resdb)) echo $resdb->email;?>" /></li>			
						<li><label for="login">Login:</label>
						<input type="text" size="35" disabled="disabled" name="login" value="<?php if (($resdb)) echo $resdb->login;?>" /></li>	
						<li><label for="status">Status:</label>
						<input type="checkbox" name="status" <?php if(!isAdmin()): echo ' disabled="disabled" '; endif;
																if($resdb->status =="999"): echo ' checked="checked"'; endif;
																?> /> Habilita/Desabilta usuário</li>
						<li><label for="adm">Administrador:</label>								
						
						<li class="center"><input type="submit" name="editar" value="Alterar Dados" />
							               <input type="button" onclick="location.href='?m=users&s=listar'" value="Cancelar" />
							               </li>	
					</ul>
				</fieldset>
			</form>	
		<?php
		else:
			//printMSG('Você não tem permissão para efetuar alterações neste usuário. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "m=users&s=listar";
			getMSG('cb-909','alerta',NULL);
		endif;
	break;
	case 'excluir':
		echo "<h2>Eclusão de Usuários</h2>";
		$session = new session();
		if (isAdmin()== TRUE ):
			if (isset($_GET['id'])):
				//faz edição do usuário
				$id = $_GET['id'];
				if (isset($_POST['exclusao'])):
					$user = new users();
					$user->pk_value = $id;
					$user->deleteDB($user);
					if ($user->countline==1):
						getMSG('cb-913','sucesso',NULL);
						unset($_POST);
				 	else:
						getMSG('cb-912','alerta',NULL);
					endif;
				endif;
				
				$userdb = new users();
				$userdb->extra_select = "WHERE id=$id";
				$userdb->selectAll($userdb);
				$resdb = $userdb->returnData();
			else:
				getMSG('cb-906','alerta',NULL);
			endif;
			?>
	        <script type="text/javascript">
				$(document).ready(function(){
					$(".userform").validate({
						rules:{
							nome:{required:true, minlength:5},
							email:{required:true, email:true},
							login:{required:true, minlength:5},
							senha:{required:true, rangelength:[4,10]},
							confsenha:{required:true, equalTo:"#senha"}
							}
						});
					});
			</script>	
			<form class="userform" method="post" action="">
				<fieldset>
					<legend>Formulário de Exclusão - Usuários</legend>
					<ul>
						<li><label for="nome">Nome:</label>
						<input type="text" disabled="disabled" size="50" name="nome" value="<?php if (($resdb)) echo $resdb->nome; ?>" /></li>
						<li><label for="email">Email:</label>
						<input type="text" disabled="disabled" size="50" name="email" value="<?php if (($resdb)) echo $resdb->email;?>" /></li>			
						<li><label for="login">Login:</label>
						<input type="text" disabled="disabled" size="35" name="login" value="<?php if (($resdb)) echo $resdb->login;?>" /></li>	
						<li><label for="senha">Senha:</label>
						<input type="password" disabled="disabled" size="25" name="senha" id="senha" value="<?php echo $_POST['senha'];?>" /></li>	
						<li><label for="confsenha">Repita a Senha:</label>
						<input type="password" disabled="disabled" size="25" name="confsenha" value="<?php echo $_POST['confsenha'];?>" /></li>							
						<li><label for="ativo">Ativo:</label>
						<input type="checkbox" disabled="disabled" name="ativo" <?php if(isset($resdb->ativo) =="s"): echo ' checked="checked"'; endif;
																                ?> /> Habilita/Desabilta usuário</li>
						<li><label for="adm">Administrador:</label>								
						<input type="checkbox" disabled="disabled" name="adm" <?php if(isset($resdb->admin) =="s") echo ' checked="checked"';
																              ?> /> Dar controle total ao usuário</li>	
						<li class="center"><input type="submit" name="exclusao" value="Confirma Exclusão" />
							               <input type="button" onclick="location.href='?m=users&s=listar'" value="Cancelar" />
							               </li>	
					</ul>
				</fieldset>
			</form>	
		<?php
		else:
			//printMSG('Você não tem permissão para efetuar alterações neste usuário. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "m=users&s=listar";
			getMSG('cb-909','alerta',NULL);
		endif;
	break;
	
	default:
		getMSG("cb-005",$screen,NULL);
		break;
endswitch;
?>