<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
    #nome_1:invalid {background:#ff0; }
    #nome_1:valid {background:#fff; }    
</style>		
<?php
//echo (dirname(dirname(__FILE__))."/functions.php");
require_once(dirname(dirname(dirname(__FILE__)))."/util/functions.php");
protectFile(basename(__FILE__));
loadJS('jquery-validate');  
loadJS('jquery-validate-messages');
loadCSS("data-table","screen",FALSE);
// pegar o usuário corrente
$session = new session();
$userid = $session->getVars('userid');
$user_id = $session->getVars('userid');
$user_ip = $_SERVER['REMOTE_ADDR'];
$acao    = $_REQUEST['s'];
$rotina  = $_REQUEST['m'];
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
	case 'incluir':
		if (isAdmin()== TRUE ):
			if (!isset($_REQUEST['sub_cat_id']) and (!isset($_REQUEST['sc']))):
				getMSG('cb-801','alerta',$extra_msg);
			elseif (isset($_REQUEST['sub_cat_id'])):
					$lerdb = new sub_cat();
					$lerdb->extra_select="where id = '".$_REQUEST['sub_cat_id']."' order by data_cad DESC LIMIT 1";	
					$lerdb->selectAll($lerdb);
					$resdb= $lerdb->returnData();
					$sub_cat_id = $resdb->id;
					$sub_cat_nome = $resdb->nome;
			else:
					if (isset($_REQUEST['sc'])) $sub_cat_id = $_REQUEST['sc'];
					else $sub_cat_id = "";
					//echo "passou aqui 2 ">$sub_cat_id;
					$lerdb = new sub_cat();
					$lerdb->extra_select="where nome = '".$sub_cat_id."' and data_cad ='".$_REQUEST['datacad']."' order by data_cad DESC LIMIT 1";	
					$lerdb->selectAll($lerdb);
					$resdb= $lerdb->returnData();
					$sub_cat_id   = $resdb->id;
					$sub_cat_nome   = $resdb->nome;
			endif;			
			if (!isset($_REQUEST['id']))	       $id           = ""; else $id           = $_REQUEST['id'];
			if (!isset($_REQUEST['nome_1']))	   $nome_1       = ""; else $nome_1       = $_REQUEST['nome_1'];
			if (!isset($_REQUEST['nome_2']))	   $nome_2       = ""; else $nome_2       = $_REQUEST['nome_2'];
			if (!isset($_REQUEST['nome_3']))	   $nome_3       = ""; else $nome_3       = $_REQUEST['nome_3'];
			if (!isset($_REQUEST['nome_4']))	   $nome_4       = ""; else $nome_4       = $_REQUEST['nome_4'];
			if (!isset($_REQUEST['status_1']))     $status_1     = ""; else $status_1     = $_REQUEST['status_1'];
			if (!isset($_REQUEST['status_2']))     $status_2     = ""; else $status_2     = $_REQUEST['status_2'];
			if (!isset($_REQUEST['status_3']))     $status_3     = ""; else $status_3     = $_REQUEST['status_3'];
			if (!isset($_REQUEST['status_4']))     $status_4     = ""; else $status_4     = $_REQUEST['status_4'];
			if (!isset($_REQUEST['relevancia_1'])) $relevancia_1 = ""; else $relevancia_1 = $_REQUEST['relevancia_1'];
			if (!isset($_REQUEST['relevancia_2'])) $relevancia_2 = ""; else $relevancia_2 = $_REQUEST['relevancia_2'];
			if (!isset($_REQUEST['relevancia_3'])) $relevancia_3 = ""; else $relevancia_3 = $_REQUEST['relevancia_3'];
			if (!isset($_REQUEST['relevancia_4'])) $relevancia_4 = ""; else $relevancia_4 = $_REQUEST['relevancia_4'];
			$user_resp   = $userid;	
			date_default_timezone_set('America/Sao_Paulo');
			$datacad   = date('Y-m-d H:i:s');		
				
			if (isset($_POST['cadastrar'])):
				for ($i=1; $i <=4 ; $i++) :
					switch ($i): 
						case 1 : $nome = $nome_1; $status = $status_1; $relevancia = $relevancia_1; break;
						case 2 : $nome = $nome_2; $status = $status_2; $relevancia = $relevancia_2; break;
						case 3 : $nome = $nome_3; $status = $status_3; $relevancia = $relevancia_3; break;
						case 4 : $nome = $nome_4; $status = $status_4; $relevancia = $relevancia_4; break;
					endswitch;
					if($nome != ''):
						$gravadb = new item_sub_cat(array(
							'nome'      =>$nome,
							'status'    =>$status,
							'relevancia'=>$relevancia,
							'data_cad'  =>$datacad,
							'user_id'   =>$userid,
							'sub_cat_id'=>$sub_cat_id,
						));
						$xx = $gravadb ->insertDB($gravadb );
						if ($gravadb ->countline==1):
							// Início  - Rotina de gravar logs
							if(isset($id ))                $reg_id         = "<p>Reg no DB: ".$id."</p>";                  else $reg_id         ="";
							if(isset($user_id ))           $reg_user       = "<p>User Resp: ".$user_id."</p>";             else $reg_user       ="";
							if(isset($datacad ))           $reg_data       = "<p>Cadastro: ".$datacad."</p>";              else $reg_data       ="";
							if(isset($status ))            $reg_status     = "<p>Status: ".$status."</p>";                 else $reg_status     ="";
							if(isset($relevancia ))        $reg_relevancia = "<p>Relevancia: ".$relevancia."</p>";         else $reg_relevancia ="";
							if(isset($nome ))              $reg_nome       = "<p>Opção de Personalização: ".$nome."</p>";  else $reg_nome       ="";
							if(isset($sub_cat_id ))        $reg_sub_cat_id = "<p>Personalização: ".$sub_cat_id."</p>";     else $reg_sub_cat_id ="";
							$registro  = $reg_id.$reg_nome.$reg_status.$reg_relevancia.$reg_sub_cat_id.$reg_data.$reg_user;
							grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 	
							// Final  - Rotina de gravar logs	
						else:
							/*
							$lerdb = new item_sub_cat();
							$lerdb->extra_select="SELECT item.*, 
									subcat.`nome` AS sc_nome,
									subcat.`titulo` AS sc_titulo,
									subcat.`status` AS sc_status,
									subcat.`relevancia` AS sc_relevancia
									 FROM `item_sub_cat` AS item 
									INNER JOIN `sub_cat` AS subcat 
									ON item.`sub_cat_id` = subcat.`id`
									where item.`nome` = '".$nome."';";	
							$lerdb->selectManual($lerdb);
							$resdb= $lerdb->returnData();
							echo "<br>nome: ".$nome;
							$extra_msg = $resdb->sc_titulo;
							getMSG('cb-802','alerta',$extra_msg);
							 * 
							 */
						endif;
					endif;
				endfor;
				//echo '<script> location.href="?p=loja&m=item_sub_cat&s=listar" </script>';
				if ($xx == 0):
					$extra_msg = '<a href="'.ADMURL.'?p=loha&m=item_sub_cat&s=listar">Exibir Cadastros</a>';
					getMSG('cb-911','sucesso',$extra_msg);
				endif;
				//unset ($_POST['nome']);
				//unset ($_POST['titulo']);
				//unset ($_POST['cadastrar']);
				
			endif;
			?>
			<form class="pagform" name=pagform method="post" action="">
				<fieldset>
					<legend>Cadastro de Personalização de Categorias</legend>
					<p><h2>Cadastro de Opções das Personalizações Cadastradas</h2></p></legend>
					<ul>
					<?php
						if(!isset($sub_cat_id)):
							$lerdb = new sub_cat();
							//$lerdb->extra_select="GROUP by titulo";	
							$lerdb->selectAll($lerdb);
							echo 'Selecione a Personalização que deseja incluir opções:</br>';
							echo '<select name="sub_cat_id" autofocus>';
							while ($resdb= $lerdb->returnData()):
								echo '	<option value='.$resdb->id.'>'.$resdb->titulo.'</option>';
							endwhile;
							echo '</select>';
						else:
							echo "<p><h2>Personalização: ".$sub_cat_nome ."</h2></p>";
							echo '<input type="hidden" name="sub_cat_id" id="sub_cat_id" value="'.$sub_cat_id.'" />';
						endif;
					?>
						</br>
						<div >
							<li><label for="nome_1">Opção 1:</label>
								<input type="text" class="area_editavel_pagina" name="nome_1" id="nome_1" size="30" autofocus
								min="1" maxlength="30"  placeholder="1ª Opção de escolha do tópico de personalização - Tamanho max 30 caracteres *** OBRIGATÓRIO ***" 
							    size="30" title="1ª Opção de escolha do tópico de personalização - Tamanho max 30 caracteres" required >
							</li>
							<li>Status:
								<select name="status_1">
									<option value=0>Inativo</option>
									<option selected="selected" value=1>Ativo</option>
									<option value=2>Aguardando Aprovação</option>
									<option value=3>Pendente</option>
								</select>
							 	Relevancia:
								<select name="relevancia_1">
									<option value=0>Baixa</option>
									<option selected="selected" value=1>Normal</option>
									<option value=2>Média</option>
									<option value=3>Alta</option>
								</select>
							</li>
						</div>
						<div>
							<li><label for="nome_2">Opção 2:</label>
								<input type="text" class="area_editavel_pagina" name="nome_2" id="nome_2" size="30" 
								min="1" maxlength="30"  placeholder="2ª Opção de escolha do tópico de personalização - Tamanho max 30 caracteres" 
							    size="30" title="2ª Opção de escolha do tópico de personalização - Tamanho max 30 caracteres">
							</li>
							<li>Status:
								<select name="status_2">
									<option value=0>Inativo</option>
									<option selected="selected" value=1>Ativo</option>
									<option value=2>Aguardando Aprovação</option>
									<option value=3>Pendente</option>
								</select>
							 	Relevancia:
								<select name="relevancia_2">
									<option value=0>Baixa</option>
									<option selected="selected" value=1>Normal</option>
									<option value=2>Média</option>
									<option value=3>Alta</option>
								</select>
							</li>							
						</div>
						<div>						
							<li><label for="nome_3">Opção 3:</label>
								<input type="text" class="area_editavel_pagina" name="nome_3" id="nome_3" size="30" 
								min="1" maxlength="30"   placeholder="3ª Opção de escolha do tópico de personalização - Tamanho max 30 caracteres" 
							    size="30" title="3ª Opção de escolha do tópico de personalização - Tamanho max 30 caracteres"> 
							</li>
							<li>Status:
								<select name="status_3">
									<option value=0>Inativo</option>
									<option selected="selected" value=1>Ativo</option>
									<option value=2>Aguardando Aprovação</option>
									<option value=3>Pendente</option>
								</select>
								
							 	Relevancia:
								<select name="relevancia_3">
									<option value=0>Baixa</option>
									<option selected="selected" value=1>Normal</option>
									<option value=2>Média</option>
									<option value=3>Alta</option>
								</select>
							</li>							
							
						</div>
						<div>						
							<li><label for="nome_4">Opção 4:</label>
								<input type="text" class="area_editavel_pagina" name="nome_4" id="nome_4" size="30" 
								min="1" maxlength="30"  placeholder="4ª Opção de escolha do tópico de personalização - Tamanho max 30 caracteres" 
							    size="30" title="4ª Opção de escolha do tópico de personalização - Tamanho max 30 caracteres"> 
							</li>
							<li>Status:
								<select name="status_4">
									<option value=0>Inativo</option>
									<option selected="selected" value=1>Ativo</option>
									<option value=2>Aguardando Aprovação</option>
									<option value=3>Pendente</option>
								</select>
								
							 	Relevancia:
								<select name="relevancia_4">
									<option value=0>Baixa</option>
									<option selected="selected" value=1>Normal</option>
									<option value=2>Média</option>
									<option value=3>Alta</option>
								</select>
							</li>							
						</div>
						
						</br>						
						<div >
							<li class="center"><input type="submit" name="cadastrar" value="Salvar Dados" />
							    <input type="button" onclick="location.href='?p=loja&m=item_sub_cat&s=listar'" value="Cancelar" />
							</li>
						</div> 
					</ul>
				</fieldset>	
			</form>	
			<?php
		else:
			printMSG('Você não tem permissão para efetuar alterações neste usuário. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "p=loja&m=item_sub_cat&s=listar";
			$extra_msg = '<a href="?p=loja&m=item_sub_cat&s=listar" onclick="history.back()">Voltar</a>';
			getMSG('cb-909','alerta',$extra_msg);
		endif;		
	break;
	case 'listar':
		echo '<h2>Opções das Personalizações Cadastradas</h2>';
		loadCSS("data-table","screen",TRUE);
		loadJS("jquery-datatable");
		?>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#listapaginas").dataTable({
					"aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
					"iDisplayLength": 25,
					"bStateSave": true,
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
					"sScrollY": "630px",
					"bPaginate": true,
					"aaSorting": [[ 0, "asc" ]]
				});
			});
		</script>
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="listapaginas">
			<thead>
				<tr>
					<th>Personalização</th><th>Opções</th><th>Sts</th><th>Relev</th><th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$lerdb = new item_sub_cat();
				$lerdb->extra_select="SELECT item.*, 
											subcat.`nome` AS sc_nome,
											subcat.`titulo` AS sc_titulo,
											subcat.`status` AS sc_status,
											subcat.`relevancia` AS sc_relevancia
											 FROM `item_sub_cat` AS item 
											INNER JOIN `sub_cat` AS subcat 
											ON item.`sub_cat_id` = subcat.`id` 
											ORDER BY subcat.`nome` ASC;";	
				$lerdb->selectManual($lerdb);
				$reg_cat_sub_cat == 0;
				while ($resdb= $lerdb->returnData()):
					// ver se tem  Produtos, Categorias ou Sub-Categorias associadas a este item_sub_cat
					$lerdb_cat_scat  = new cat_scat_iscat();
					$lerdb_cat_scat->extra_select="SELECT item.*, 
											subcat.`nome` AS sc_nome,
											subcat.`titulo` AS sc_titulo,
											subcat.`status` AS sc_status,
											subcat.`relevancia` AS sc_relevancia
											 FROM `item_sub_cat` AS item 
											INNER JOIN `sub_cat` AS subcat 
											ON item.`sub_cat_id` = subcat.`id` 
											ORDER BY subcat.`nome` ASC;";	
					
					
					/*$lerdb_cat_scat  = new cat_scat_iscat();
					$lerdb_cat_scat->extra_select="where `i_sc_id` = ".$resdb->id." LIMIT 1";	
					$lerdb_cat_scat->selectAll($lerdb_cat_scat);
					$reg_cat_sub_cat = $lerdb_cat_scat->countline;
					$resdb_cat_scat= $lerdb_cat_scat->returnData();
					echo "<br>cont ".$reg_cat_sub_cat."  id ".$resdb->id. "  iscid ".$resdb_cat_scat->i_sc_id ;*/
					if     ($resdb->status == 0) $status = "Inativo"; 
					elseif ($resdb->status == 1) $status = "Ativo";
					elseif ($resdb->status == 2) $status = "Aprovar";
					elseif ($resdb->status == 3) $status = "Pendente";
					if     ($resdb->relevancia == 0) $relevancia = "Baixa"; 
					elseif ($resdb->relevancia == 1) $relevancia = "Normal";
					elseif ($resdb->relevancia == 2) $relevancia = "Média";
					elseif ($resdb->relevancia == 3) $relevancia = "Alta";
					echo '<tr>';
					printf('<td>%s</td>',$resdb->sc_titulo);
					printf('<td>%s</td>',$resdb->nome);
					printf('<td>%s</td>',$status);
					printf('<td>%s</td>',$relevancia) ;
					if ($resdb->id != 0 and $reg_cat_sub_cat == 0):
						printf('<td class="center"><a href="?p=loja&m=item_sub_cat&s=editar&id=%s&sc=%s" title="Editar"><img src="'.BASEURL.'images/edit.png") 
							alt="Editar" /></a></a> <a href="?p=loja&m=item_sub_cat&s=excluir&id=%s" title="Excluir"><img src="'.BASEURL.'images/delete.png") 
							alt="Excluir" /></a> </td>',$resdb->id,$resdb->sub_cat_id,$resdb->id,$resdb->sub_cat_id);
					else:
						printf('<td class="center"><a href="?p=loja&m=item_sub_cat&s=editar&id=%s" title="Editar"><img src="'.BASEURL.'images/edit.png") 
							alt="Editar" /></a>
							<a title="Este item não pode ser excluído"><img src="'.BASEURL.'images/nao_delete.png") 	alt=" Não Deletar este item" /></a>
							</a>  </td>',$resdb->id,$resdb->sub_cat_id,$resdb->id,$resdb->sub_cat_id);
					endif;
					echo "</tr>";
				endwhile;
				?>
			</tbody>
		</table>
	<?php
	break;	
	case 'editar':
		echo "<h2>Alteração de Opções da Personalização</h2>";
		//$session = new session();
		if (isAdmin()== TRUE ):
			if (!isset($_REQUEST['id']))         $id         = ""; else $id         = $_REQUEST['id'];
			if (!isset($_REQUEST['nome']))	     $nome       = ""; else $nome       = $_REQUEST['nome'];
			if (!isset($_REQUEST['status']))     $status     = ""; else $status     = $_REQUEST['status'];
			if (!isset($_REQUEST['relevancia'])) $relevancia = ""; else $relevancia = $_REQUEST['relevancia'];
			if (!isset($_REQUEST['sc']))         $sub_cat_id = ""; else $sub_cat_id = $_REQUEST['sc'];

			$user_resp   = $userid;	
			date_default_timezone_set('America/Sao_Paulo');
			$datacad   = date('Y-m-d H:i:s');	
			$lerdb = new item_sub_cat();
			$lerdb->pk_value = $id;
			$lerdb->extra_select = "WHERE id=$id";
			$lerdb->selectAll($lerdb);
			$resdb = $lerdb->returnData();		
			if (isset($_POST['editar'])):
				//echo "<br> Descrição dos Páginas : ".$texto1."<br>";
				$updtdb = new item_sub_cat(array(
					'nome'       =>$nome,
					'status'     =>$status,
					'relevancia' =>$relevancia,
					'data_cad'   =>$datacad,
					'user_id'    =>$userid,
					'sub_cat_id' =>$sub_cat_id,
				));
				$updtdb ->pk_value = $id;
				$updtdb ->updateDB($updtdb );
				if ($updtdb ->countline==1):
					// Início  - Rotina de gravar logs
					if(isset($resdb->id ))         $reg_id         = "<p>Reg no DB: ".$resdb->id."</p>";                  else $reg_id         ="";
					if(isset($resdb->user_id ))    $reg_user       = "<p>User Resp: ".$resdb->user_id."</p>";             else $reg_user       ="";
					if(isset($resdb->data_cad ))   $reg_data       = "<p>Ult. Alteração: ".$resdb->data_cad."</p>";       else $reg_data       ="";
					if(isset($resdb->status ))     $reg_status     = "<p>Status: ".$resdb->status."</p>";                 else $reg_status     ="";
					if(isset($resdb->relevancia )) $reg_relevancia = "<p>Relevancia: ".$resdb->relevancia."</p>";         else $reg_relevancia ="";
					if(isset($resdb->nome ))       $reg_nome       = "<p>Opção de Personalização: ".$resdb->nome."</p>";  else $reg_nome       ="";
					if(isset($sub_cat_id ))        $reg_sub_cat_id = "<p>Personalização: ".$sub_cat_id."</p>";            else $reg_sub_cat_id ="";
					$registro  = $reg_id.$reg_nome.$reg_status.$reg_relevancia.$reg_sub_cat_id.$reg_data.$reg_user;
					grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 
					echo '<script> location.href="?p=loja&m=item_sub_cat&s=listar" </script>';
					// Final  - Rotina de gravar logs						
					$extra_msg = '<a href="'.ADMURL.'?p=loja&m=item_sub_cat&s=listar">Exibir Cadastros</a>';
					getMSG('cb-911','sucesso',$extra_msg);
					unset ($_POST['nome']);

				endif;
				//echo '<script> location.href="?p=loja&m=item_sub_cat&s=listar" </script>';
			endif;
			?>
			<form class="pagform" method="post" action="">
				<fieldset>
					<legend>Alteração - Páginas</legend>
					<ul>
						<div >
							<li><label for="nome">Opção de Personalização:</label>
								<input type="text" name="nome" id="nome" size="50" 
								pattern="[a-zA-Z|0-9|-]{4,20}"  placeholder="Nome da Página (sem espaços ou caracteres especiais)" 
							size="50" title="Este campo só aceita o híifen (-) como caracter especial letras e números - Tamanho: mínimo 4 e máximo 20 caracteres ***não utilizar espaços***" 
							required value="<?php echo $resdb->nome;?>">   
						</div> 
						<?php
						$lerdb_cat = new sub_cat();
						$lerdb_cat->extra_select="where status = 1";	
						$lerdb_cat->selectAll($lerdb_cat);
						echo 'Selecione a Personalização desta opções:</br>';
						echo '<select name="sub_cat_id" >';
						while ($resdb_cat= $lerdb_cat->returnData()):
							if ($sub_cat_id == $resdb_cat->id) $select_cat = ' selected="selected"';
							else $select_cat = "";
							echo '	<option value='.$resdb_cat->id . $select_cat.'>'.$resdb_cat->titulo.'</option>';
						endwhile;
						echo '</select>';
						?>	            		
	            		<div >
							<li><label for="status">Status:</label>
								<select name="status">
									<option <?php if($resdb->status == 0) echo 'selected="selected"';?> value=0>Inativo</option>
									<option <?php if($resdb->status == 1) echo 'selected="selected"';?> value=1>Ativo</option>
									<option <?php if($resdb->status == 2) echo 'selected="selected"';?> value=2>Aprovar</option>
									<option <?php if($resdb->status == 3) echo 'selected="selected"';?> value=3>Pendente</option>
								</select>
							 	<label for="relevancia">Relevancia:</label>
								<select name="relevancia">
									<option <?php if($resdb->relevancia == 0) echo 'selected="selected"';?> value=0>Baixa</option>
									<option <?php if($resdb->relevancia == 1) echo 'selected="selected"';?> value=1>Normal</option>
									<option <?php if($resdb->relevancia == 2) echo 'selected="selected"';?> value=2>Média</option>
									<option <?php if($resdb->relevancia == 3) echo 'selected="selected"';?> value=3>Alta</option>
								</select>
							</li>	
						</div>
						</br>							
						<div >
							<li class="center">
							    <input type="submit" name="editar" value="Alterar Dados" />
				                <input type="button" onclick="location.href='?p=loja&m=item_sub_cat&s=listar'" value="Cancelar" />
							</li>	
						</div>
					</ul>
				</fieldset>
			</form>		
			</br>
			<div >
				<ul><label for="sub_cat">Esta opção de Personalização está associada a Personalização:</label>
				<?php
					$lerdb_s_cat = new sub_cat();
					$lerdb_s_cat->extra_select="where id =".$resdb->sub_cat_id;	// ver se tem  o id na tabela item_sub_cat campo sub_cat_id
					$lerdb_s_cat->selectAll($lerdb_s_cat);
					while ($resdb_s_cat= $lerdb_s_cat->returnData()):	
						echo '<input type="text" size="30" disabled="disabled"
						 value="'.$resdb_s_cat->titulo.'">';   
				 	endwhile;
				?>	  
				</ul>	
			</div> 						
		<?php
		else:
			printMSG('Você não tem permissão para efetuar alterações neste usuário. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "p=loja&m=item_sub_cat&s=listar";
			$extra_msg = '<a href="?p=loja&m=item_sub_cat&s=listar" onclick="history.back()">Voltar</a>';
			getMSG('cb-909','alerta',$extra_msg);
		endif;
	break;
	case 'excluir':
		echo "<h2>Eclusão de Opções de Personalização</h2>";
		//$session = new session();
		if (isAdmin()== TRUE ):
			date_default_timezone_set('America/Sao_Paulo');
			$datacad   = date('Y-m-d H:i:s');
			if (isset($_GET['id'])):
				//faz edição do Páginas
				$id = $_GET['id'];
				$lerdb = new item_sub_cat();
				$lerdb->pk_value = $id;
				$lerdb->extra_select = "WHERE id=$id";
				$lerdb->selectAll($lerdb);
				$resdb = $lerdb->returnData();	
				if (isset($_POST['exclusao'])):
					$deldb = new item_sub_cat();
					$deldb->pk_value = $id;
					$deldb->deleteDB($deldb);
					if ($deldb->countline==1):
						// Início  - Rotina de gravar logs
						// Início  - Rotina de gravar logs
						if(isset($resdb->id ))         $reg_id         = "<p>Reg no DB: ".$resdb->id."</p>";                  else $reg_id         ="";
						if(isset($resdb->user_id ))    $reg_user       = "<p>User Resp: ".$resdb->user_id."</p>";             else $reg_user       ="";
						if(isset($resdb->data_cad ))   $reg_data       = "<p>Ult. Alteração: ".$resdb->data_cad."</p>";       else $reg_data       ="";
						if(isset($resdb->status ))     $reg_status     = "<p>Status: ".$resdb->status."</p>";                 else $reg_status     ="";
						if(isset($resdb->relevancia )) $reg_relevancia = "<p>Relevancia: ".$resdb->relevancia."</p>";         else $reg_relevancia ="";
						if(isset($resdb->nome ))       $reg_nome       = "<p>Opção de Personalização: ".$resdb->nome."</p>";  else $reg_nome       ="";
						if(isset($sub_cat_id ))        $reg_sub_cat_id = "<p>Personalização: ".$sub_cat_id."</p>";            else $reg_sub_cat_id ="";
						$registro  = $reg_id.$reg_nome.$reg_status.$reg_relevancia.$reg_sub_cat_id.$reg_data.$reg_user;
						grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 
						echo '<script> location.href="?p=loja&m=item_sub_cat&s=listar" </script>';
						// Final  - Rotina de gravar logs						
						$extra_msg = '<a href="'.ADMURL.'?p=loja&m=item_sub_cat&s=listar">Exibir Cadastros</a>';
						getMSG('cb-911','sucesso',$extra_msg);						
						// Final  - Rotina de gravar logs	
						//echo '<script> location.href="?p=loja&m=item_sub_cat&s=listar" </script>';
						$extra_msg = '<a href="'.ADMURL.'?p=loja&m=item_sub_cat&s=listar">Exibir Cadastros</a>';
						getMSG('cb-913','sucesso',$extra_msg);
						unset($_POST);
				 	else:
						$extra_msg = '<a href="'.ADMURL.'?p=loja&m=item_sub_cat&s=listar">Exibir Cadastros</a>';
						getMSG('cb-912','alerta',$extra_msg);
						unset($_POST);
					endif;
				endif;
			else:
				getMSG('cb-906','alerta',NULL);
			endif;
			?>
			<form class="userform" method="post" action="">
				<fieldset>
					<legend>Exclusão - Opções de Personalização</legend>
					<ul>
						<li><label for="nome">Opção de Personalização:</label>
						<?php echo $resdb->nome;?>  			

						<li class="center">
						   	<input type="submit" name="exclusao" value="Confirma Exclusão" />
							<input type="button" onclick="location.href='?p=loja&m=item_sub_cat&s=listar'" value="Cancelar" />
		               </li>	
					</ul>
				</fieldset>
			</form>	
			</br>
			<div >
				<ul><label for="sub_cat">Esta opção de Personalização está associada a Personalização:</label>
				<?php
					$lerdb_s_cat = new sub_cat();
					$lerdb_s_cat->extra_select="where id =".$resdb->sub_cat_id;	// ver se tem  o id na tabela item_sub_cat campo sub_cat_id
					$lerdb_s_cat->selectAll($lerdb_s_cat);
					while ($resdb_s_cat= $lerdb_s_cat->returnData()):	
						echo '<input type="text" size="30" disabled="disabled"
						 value="'.$resdb_s_cat->titulo.'">';   
				 	endwhile;
				?>	  
				</ul>	
			</div> 			
		<?php
		else:
			printMSG('Você não tem permissão para efetuar alterações neste usuário. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "p=loja&m=item_sub_cat&s=listar";
			$extra_msg = '<a href="?p=loja&m=item_sub_cat&s=listar" onclick="history.back()">Voltar</a>';
			getMSG('cb-909','alerta',$extra_msg);
			unset($_POST);
		endif;
	break;
	default:
		getMSG("cb-005",$screen,NULL);
		break;
endswitch;
?>