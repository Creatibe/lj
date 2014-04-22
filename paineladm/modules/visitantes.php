<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
//echo (dirname(dirname(__FILE__))."/functions.php");
require_once(dirname(dirname(__FILE__))."/util/functions.php");
protectFile(basename(__FILE__));
loadJS('jquery-validate');  
loadJS('jquery-validate-messages');
loadCSS("data-table","screen",FALSE);
// pegar o usuário corrente
$session = new session();
$userid = $session->getVars('userid');
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
switch ($screen):

	case 'listar':
		echo '<h2>Relação de Visitantes</h2>';
		loadCSS("data-table","screen",TRUE);
		loadJS("jquery-datatable");
		?>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#listavisitantes").dataTable({
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
					"bPaginate": true
					//"aaSorting": [[ 3, "desc" ]]
				});
			});
		</script>
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="listavisitantes">
			<thead>
				<tr>
					<th>Nome</th><th>E-mail</th><th>Grupo</th><th>IP</th><th>1° Acesso</th><th>Ult. Acesso</th><th>Tempo</th><th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$visitantes = new visitantes();
				$visitantes->extra_select="order by limite DESC  ";	
				//$visitantes->extra_select="order by relevancia DESC";	
				$visitantes->selectAll($visitantes);
				while ($res = $visitantes->returnData()):
					echo '<tr>';
					printf('<td>%s</td>',$res->nome);
					printf('<td>%s</td>',$res->email);
					printf('<td>%s</td>',$res->grupo);
					printf('<td>%s</td>',$res->user_ip);
					printf('<td>%s</td>',$res->data);
					printf('<td>%s</td>',$res->horario);
					// Verifica o tempo que o usuario ficou online
					$inicio = $res->horario;
					$fim = $res->limite;
					$inicio = DateTime::createFromFormat('Y-m-d H:i:s', $inicio);
					$fim    = DateTime::createFromFormat('Y-m-d H:i:s', $fim);
					$intervalo = $inicio->diff($fim);
					//var_dump($intervalo); //verifica o conteudo (array) em intervalo %Y %M %D %H %M %S
					printf ('<td>%s</td>',$intervalo->format('%H:%I:%S'));
					printf('<td class="center"><a href="?m=visitantes&s=editar&id=%s" title="Editar"><img src="'.BASEURL.'images/edit.png") 
					alt="Alterar" /></a> <a href="?m=visitantes&s=mensagens&id=%s" title="Mensagens"><img src="'.BASEURL.'images/list.png") 
					alt="Mensagens" /></a> <a href="?m=visitantes&s=excluir&id=%s" title="Excluir"><img src="'.BASEURL.'images/delete.png") 
					alt="Excluir" /></a> </td>',$res->id,$res->id,$res->id);
					echo "</tr>";
				endwhile;
				?>
			</tbody>
		</table>
	<?php
	break;	
	case 'editar':
		echo "<h2>Visitantes - Alteração</h2>";
		$session = new session();
		if (isAdmin()== TRUE ):
			if (!isset($_REQUEST['id']))	$id = ""; else $id = $_REQUEST['id'];
			if (!isset($_POST['nome']))	$nome = ""; else $nome = $_POST['nome'];
			if (!isset($_POST['email']))$email = ""; else $email = $_POST['email'];
			if (!isset($_POST['grupo']))$grupo = ""; else $grupo = $_POST['grupo'];
			if (!isset($_POST['user_ip']))$user_ip = ""; else $user_ip = $_POST['user_ip'];
			if (!isset($_POST['data']))$data = ""; else $data = $_POST['data'];
			if (!isset($_POST['horario']))$horario = ""; else $horario = $_POST['horario'];
			if (!isset($_POST['limite']))$limite = ""; else $limite = $_POST['limite'];
			$user_resp   = $userid;	
			date_default_timezone_set('America/Sao_Paulo');
			$data_alt   = date('Y-m-d H:i:s');			
			if (isset($_POST['editar'])):
				//echo "<br> Descrição dos visitantes : ".$descr_visitantes."<br>";
				$visitantes = new visitantes(array(
					'nome'=>$nome,
					'email'=>$email,
					'grupo'=>$grupo,
				));
				$visitantes->pk_value = $id;
				$visitantes->updateDB($visitantes);
				if ($visitantes->countline==1):
					$extra_msg = '<a href="'.ADMURL.'?m=visitantes&s=listar">Exibir Cadastros</a>';
					getMSG('cb-911','sucesso',$extra_msg);
					unset ($_POST['visitantes']);
				endif;

			endif;
			$visitdb = new visitantes();
			$visitdb->pk_value = $id;
			$visitdb->extra_select = "WHERE id=$id";
			$visitdb->selectAll($visitdb);
			$resdb = $visitdb->returnData();
			?>
	        <script type="text/javascript">
				$(document).ready(function(){
					$(".visitform").validate({
						rules:{
							nome:{required:true, minlength:5},
							grupo:{required:true, minlength:1},
							email:{required:true, email:true}
							}
						});
					});
			</script>	
			<form class="visitform" method="post" action="">
				<fieldset>
					<legend>Visitantes - Alteração</legend>
					<ul>
						<div >
							<li><label for="nome">Nome:</label>
								<input type="text" name="nome" size="50"  value="<?php echo $resdb->nome;?>">   
						</div> 
						<div >
							<li><label for="email">E-mail:</label>
								<input type="text" name="email" size="50"  value="<?php echo $resdb->email;?>">   
						</div> 
						<div >
							<li><label for="grupo">Grupo:</label>
								<input type="text" name="grupo" size="50"  value="<?php echo $resdb->grupo;?>">   
						</div> 
						<div >
							<li><label for="user_ip">IP:</label>
								<input type="text" name="user_ip" size="50" disabled="disabled" value="<?php echo $resdb->user_ip;?>">   
						</div> 

				<div class="form_paineladm_part7">
							<li class="center"><input type="submit" name="editar" value="Alterar visitantes" />
								               <input type="button" onclick="location.href='?m=visitantes&s=listar'" value="Cancelar" />
								               </li>	
						</div>
					</ul>
				</fieldset>
			</form>		
			<?php
		else:
			//printMSG('Você não tem permissão para efetuar alterações neste usuário. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "m=visitantes&s=listar";
			$extra_msg = '<a href="?m=visitantes&s=listar" onclick="history.back()">Voltar</a>';
			getMSG('cb-909','alerta',$extra_msg);
		endif;
	break;
	case 'mensagens':
		echo "<h2>Visitantes - Mensagens</h2>";
		$session = new session();
		if (isAdmin()== TRUE ):
			if (!isset($_REQUEST['id']))	$id = ""; else $id = $_REQUEST['id'];
			$visitdb = new visitantes();
			$visitdb->pk_value = $id;
			$visitdb->extra_select = "WHERE id=$id";
			$visitdb->selectAll($visitdb);
			$resdb = $visitdb->returnData();
			// Verifica o tempo que o usuario ficou online
			$inicio = $resdb->horario;
			$fim = $resdb->limite;
			$inicio = DateTime::createFromFormat('Y-m-d H:i:s', $inicio);
			$fim    = DateTime::createFromFormat('Y-m-d H:i:s', $fim);
			$intervalo = $inicio->diff($fim);
			//var_dump($intervalo); //verifica o conteudo (array) em intervalo %Y %M %D %H %M %S
			?>
			<form class="visitform" method="post" action="">
				<fieldset>
					<legend>Visitantes - Alteração</legend>
					<ul>
						<div >
							<li><label for="nome">Nome: <?php echo $resdb->nome;?></label>
							<li><label for="email">E-mail: <?php echo $resdb->email;?></label>
							<li><label for="grupo">Grupo: <?php echo $resdb->grupo;?></label>
							<li><label for="user_ip">IP: <?php echo $resdb->user_ip;?></label>
							<li><label for="user_ip">Primeiro Acesso: <?php echo $resdb->data;?></label>
							<li><label for="user_ip">Ultimo Acesso: <?php echo $resdb->horario;?></label>
							<li><label for="user_ip">Tempo no Último Acesso: <?php printf ($intervalo->format('%H:%I:%S'));?></label>
						</div> 
					</ul>
				</fieldset>
			</form>		
			<?php
			echo "<hr>";
			$mensagens = new chat_mensagens();
			$user_msg  = new visitantes();
			$mensagens->extra_select="where id_de =".$id." or id_para =".$id.".order by data DESC  ";	
			//$visitantes->extra_select="order by relevancia DESC";	
			$mensagens->selectAll($mensagens);
			echo '<table cellspacing="5" border="1" >';
			while ($res = $mensagens->returnData()):
				If ($res->id_de != $id):
					$user_msg->extra_select="where id =".$res->id_de." LIMIT 1";	
					$user_msg->selectAll($user_msg);
					$res_nome = $user_msg->returnData();
					$nome_de = $res_nome->nome;
				else:
					$nome_de = $resdb->nome;
				endif;
				If ($res->id_para != $id):
					$user_msg->extra_select="where id =".$res->id_para." LIMIT 1";	
					$user_msg->selectAll($user_msg);
					$res_nome = $user_msg->returnData();
					$nome_para = $res_nome->nome;
				else:
					$nome_para = $resdb->nome;
				endif;				
				echo '<tr>';
				//echo $resdb->nome;
				printf('<td>%s</td>',$res->data);
				printf('<td>%s</td>',$nome_de);
				printf('<td>%s</td>',$nome_para);
				printf('<td>%s</td>',utf8_decode($res->mensagem));	
				if($res->lido == 1) $msg_lido = "Lida";
				else $msg_lido = "Não Lida";
				printf('<td>%s</td>',$msg_lido);	
				echo '</tr>';
					
			endwhile;
			echo "</table>";
			
		else:
			//printMSG('Você não tem permissão para efetuar alterações neste usuário. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "m=visitantes&s=listar";
			$extra_msg = '<a href="?m=visitantes&s=listar" onclick="history.back()">Voltar</a>';
			getMSG('cb-909','alerta',$extra_msg);
		endif;
	break;	
	case 'excluir':
		echo "<h2>Eclusão de Mensagens de Visitantes</h2>";
		$session = new session();
		if (isAdmin()== TRUE ):
			if (isset($_GET['id'])):
				//faz edição do visitantes
				$id = $_GET['id'];
				if (isset($_POST['exclusao'])):
					$visitantes = new visitantes();
					$visitantes->pk_value = $id;
					$visitantes->deleteDB($visitantes);
					if ($visitantes->countline==1):
						$extra_msg = '<a href="'.ADMURL.'?m=visitantes&s=listar">Exibir Cadastros</a>';
						getMSG('cb-913','sucesso',$extra_msg);
						unset($_POST);
				 	else:
						$extra_msg = '<a href="'.ADMURL.'?m=visitantes&s=listar">Exibir Cadastros</a>';
						getMSG('cb-912','alerta',$extra_msg);
						unset($_POST);
					endif;
				endif;
				$visitdb = new visitantes();
				$visitdb->extra_select = "WHERE id=$id";
				$visitdb->selectAll($visitdb);
				$resdb = $visitdb->returnData();
			else:
				getMSG('cb-906','alerta',NULL);
			endif;
			?>
			<form class="userform" method="post" action="">
				<fieldset>
					<legend>Exclusão - Visitantes</legend>
					<ul>
						<li><label for="titulo">Nome: <?php echo $resdb->nome;?> </label>
						 			
			
						<li><label for="email">E-mail: <?php echo $resdb->email;?></label>
						
	            		
	            		<li><label for="´grupo">Grupo: <?php echo $resdb->grupo;?>	</label>
	            				

	            		<li><label for="user_ip">IP: <?php echo $resdb->user_ip;?></label>
	            					


						<li class="center"><input type="submit" name="exclusao" value="Confirma Exclusão" />
							               <input type="button" onclick="location.href='?m=visitantes&s=listar'" value="Cancelar" />
							               </li>	
					</ul>
				</fieldset>
			</form>	
		<?php
		else:
			//printMSG('Você não tem permissão para efetuar alterações neste usuário. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "m=visitantes&s=listar";
			$extra_msg = '<a href="?m=visitantes&s=listar" onclick="history.back()">Voltar</a>';
			getMSG('cb-909','alerta',$extra_msg);
			unset($_POST);
		endif;
	break;
	default:
		getMSG("cb-005",$screen,NULL);
		break;
endswitch;
?>