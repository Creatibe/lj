<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
    #nome:invalid {background:#ff0; }
    #nome:valid {background:#fff; }    
    #titulo:invalid {background:#ff0; }
    #titulo:valid {background:#fff; }    
    
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
			if (!isset($_REQUEST['id']))	     $id         = "";     else $id         = $_REQUEST['id'];
			if (!isset($_REQUEST['nome']))  	 $nome       = "";     else $nome       = $_REQUEST['nome'];
			if (!isset($_REQUEST['filtro']))     $filtro     = "";     else $filtro     = $_REQUEST['filtro'];
			if (!isset($_REQUEST['menu']))  	 $menu       = "";     else $menu       = $_REQUEST['menu'];			
			if (!isset($_REQUEST['status']))     $status     = "";     else $status     = $_REQUEST['status'];
			if (!isset($_REQUEST['relevancia'])) $relevancia = "";     else $relevancia = $_REQUEST['relevancia'];
			$user_resp   = $userid;	
			date_default_timezone_set('America/Sao_Paulo');
			$datacad   = date('Y-m-d H:i:s');		
			if (isset($_POST['cadastrar'])):
				$gravadb_depto = new depto(array(
					'nome'      =>$nome,
					'status'    =>$status,
					'relevancia'=>$relevancia,
					'filtro'    =>$filtro,
					'menu'      =>$menu,
					'data_cad'  =>$datacad,
					'user_id'   =>$userid,
				));
				$gravadb_depto ->insertDB($gravadb_depto );
				if(isset($id ))                $reg_id         = "<p>Reg no DB: ".$id."</p>";                  else $reg_id         ="";
				if(isset($user_id ))           $reg_user       = "<p>User Resp: ".$user_id."</p>";             else $reg_user       ="";
				if(isset($datacad ))           $reg_data       = "<p>Cadastro: ".$datacad."</p>";              else $reg_data       ="";
				if(isset($status ))            $reg_status     = "<p>Status: ".$status."</p>";                 else $reg_status     ="";
				if(isset($relevancia ))        $reg_relevancia = "<p>Relevancia: ".$relevancia."</p>";         else $reg_relevancia ="";
				if(isset($nome ))              $reg_nome       = "<p>Categoria: ".$nome."</p>";                else $reg_nome       ="";
				if(isset($filtro ))            $reg_filtro     = "<p>Filtro: ".$filtro."</p>";                 else $reg_filtro     ="";
				if(isset($menu ))              $reg_menu       = "<p>Menu: ".$menu."</p>";                     else $reg_menu       ="";				
				if ($gravadb_depto ->countline==1):
					// Início  - Rotina de gravar logs
					$registro  = $reg_id.$reg_nome.$reg_titulo.$reg_status.$reg_relevancia.$reg_filtro.$reg_menu.$reg_data.$reg_user;
					grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 	
					// Final  - Rotina de gravar logs	
					echo '<script> location.href="?p=loja&m=categoriaso&s=listar&sc='.$nome.'&datacad='.$datacad.'" </script>';
				else:
					$extra_msg = $reg_nome;
					getMSG('cb-803','alerta',$extra_msg);		
				endif;
			endif;
?>
			<form  name=pagform method="post" action="">
				<fieldset>
					<legend>Cadastro de Departamentos</legend>
					<p><h2>Cadastro de Departamentos</h2></p>
					<ul>
 						<div >	
							<li><label for="nome">Nome do Departamento:</label>
								<input type="text" class="area_editavel_pagina" name="nome" id="nome" size="30" maxlength="30" autofocus
								 placeholder="Nome do Departamento - Será apresentado no Site como filtro de pesquisa - Tamanho max 30 caracteres" 
								size="30" title="Nome do Departamento - Será apresentado no Site como filtro de pesquisa - Tamanho max 30 caracteres" required >
							</li>
		            	</div>
						<br>
						<div >
						<li><label for="filtro">Filtro (Ativar ou não como campo de pesquisa na Loja):</label>
							<select name="filtro">
								<option value=0>InativoN</option>
								<option selected="selected" value=1>Ativo</option>
							</select>
						<li><label for="menu">Esta Categoria fará parte do Menu do Site?:</label>
							<select name="menu">
								<option selected="selected" value=0>Não</option>
								<option  value=1>Sim</option>
							</select>							
						<li><label for="status">Status:</label>
							<select name="status">
								<option value=0>Inativo</option>
								<option selected="selected" value=1>Ativo</option>
								<option value=2>Aguardando Aprovação</option>
								<option value=3>Pendente</option>
							</select>
						 	<label for="relevancia">Relevancia:</label>
							<select name="relevancia">
								<option value=0>Baixa</option>
								<option selected="selected" value=1>Normal</option>
								<option value=2>Média</option>
								<option value=3>Alta</option>
							</select>
						</li>
						</div>
						
						</br>						
						<div >
							<li class="center"><input type="submit" name="cadastrar" value="Salvar Dados Opções" />
							    <input type="button" onclick="location.href='?p=loja&m=depto&s=listar'" value="Cancelar" />
							</li>
						</div> 
					</ul>
				</fieldset>	
			</form>	
			<?php
		else:
			printMSG('Você não tem permissão para utilizar esta rotina. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "p=loja&m=sub_categorias&s=listar";
			$extra_msg = '<a href="?p=loja&m=sub_categorias&s=listar" onclick="history.back()">Voltar</a>';
			getMSG('cb-909','alerta',$extra_msg);
		endif;		
	break;
	case 'listar':
		echo '<h2>Departamentos Cadastrados</h2>';
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
					<th>Departamento</th><th>Categoria</th><th>Filtro</th><th>Menu</th><th>Sts</th><th>Relev</th><th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php

				$lerdb_depto = new depto();
				$lerdb_depto->extra_select="where status = 1";	
				$lerdb_depto->selectAll($lerdb_depto);
				while ($resdb_depto = $lerdb_depto->returnData()):
					$reg_cat = 0;
					$lerdb_cat = new categorias();
					$lerdb_cat->extra_select="where depto_id = ".$resdb_depto->id;	
					$lerdb_cat->selectAll($lerdb_cat);
					$lerdb_cat = $lerdb_cat->returnData();
					$reg_cat = $resdb_cat->id;	
					$lerdb_scat = new sub_cat();
					$lerdb_scat->extra_select="where depto_id = '".$resdb_depto->id."'";	
					$lerdb_scat->selectAll($lerdb_scat);
					$reg_scat = $lerdb_scat->countline;
					if     ($resdb_depto->filtro == 0) $filtro = "Não"; 
					elseif ($resdb_depto->filtro == 1) $filtro = "Sim";		
					if     ($resdb_depto->menu   == 0) $menu   = "Inativo"; 
					elseif ($resdb_depto->menu   == 1) $menu   = "Ativo";		
					if     ($resdb_depto->status == 0) $status = "Inativo"; 
					elseif ($resdb_depto->status == 1) $status = "Ativo";
					elseif ($resdb_depto->status == 2) $status = "Aprovar";
					elseif ($resdb_depto->status == 3) $status = "Pendente";
					if     ($resdb_depto->relevancia == 0) $relevancia = "Baixa"; 
					elseif ($resdb_depto->relevancia == 1) $relevancia = "Normal";
					elseif ($resdb_depto->relevancia == 2) $relevancia = "Média";
					elseif ($resdb_depto->relevancia == 3) $relevancia = "Alta";
					echo '<tr>';
					printf('<td>%s</td>',$resdb_depto->nome);
					printf('<td>%s</td>',$resdb_cat->nome);
					printf('<td>%s</td>',$filtro);
					printf('<td>%s</td>',$menu);
					printf('<td>%s</td>',$status);
					printf('<td>%s</td>',$relevancia) ;
					if ($resdb_depto->id != 0 and $reg_scat == 0 and $reg_cat == 0):
						printf('<td class="center"><a href="?p=loja&m=depto&s=editar&id=%s" title="Editar"><img src="'.BASEURL.'images/edit.png") 
							alt="Editar" /></a></a> <a href="?p=loja&m=depto&s=excluir&id=%s" title="Excluir"><img src="'.BASEURL.'images/delete.png") 
							alt="Excluir" /></a> </td>',$resdb_depto->id,$resdb_depto->id,$resdb_depto->id);
					else:
						printf('<td class="center"><a href="?p=loja&m=depto&s=editar&id=%s" title="Editar"><img src="'.BASEURL.'images/edit.png") 
							alt="Editar" /></a>
							<a title="Não pode ser excluído - Produtos, Categorias ou Sub-Categorias associados.">
							<img src="'.BASEURL.'images/nao_delete.png") 	alt=" Não Deletar este item" /></a>
							</a>  </td>',$resdb_depto->id,$resdb_depto->id,$resdb_depto->id);
						
					endif;
					echo "</tr>";
				endwhile;
				?>
			</tbody>
		</table>
	<?php
	break;	
	case 'editar':
		echo "<h2>Alteração de Departamentos</h2>";
		if (isAdmin()== TRUE ):
			if (!isset($_REQUEST['id']))	     $id         = "";     else $id         = $_REQUEST['id'];
			if (!isset($_REQUEST['nome']))  	 $nome       = "";     else $nome       = $_REQUEST['nome'];
			if (!isset($_REQUEST['filtro']))     $filtro     = "";     else $filtro     = $_REQUEST['filtro'];
			if (!isset($_REQUEST['menu']))   	 $menu       = "";     else $menu       = $_REQUEST['menu'];			
			if (!isset($_REQUEST['status']))     $status     = "";     else $status     = $_REQUEST['status'];
			if (!isset($_REQUEST['relevancia'])) $relevancia = "";     else $relevancia = $_REQUEST['relevancia'];
			$user_resp   = $userid;	
			date_default_timezone_set('America/Sao_Paulo');
			$datacad   = date('Y-m-d H:i:s');	
			$lerdb_depto = new depto();
			$lerdb_depto->extra_select = "WHERE id='".$id."'";
			$lerdb_depto->selectAll($lerdb_depto);
			$resdb_depto = $lerdb_depto->returnData();		
			if (isset($_POST['editar'])):
				$updtdb_depto = new depto(array(
					'nome'       =>$nome,
					'status'     =>$status,
					'relevancia' =>$relevancia,
					'filtro'     =>$filtro,
					'menu'       =>$menu,
					'data_cad'   =>$datacad,
					'user_id'    =>$userid,
				));
				$updtdb_depto ->pk_value = $id;
				$updtdb_depto ->updateDB($updtdb_depto );
				if(isset($resdb_depto->id ))         $reg_id         = "<p>Reg no DB: ".$resdb_depto->id."</p>";           else $reg_id         ="";
				if(isset($resdb_depto->user_id ))    $reg_user       = "<p>User Resp: ".$resdb_depto->user_id."</p>";      else $reg_user       ="";
				if(isset($resdb_depto->data_cad ))   $reg_data       = "<p>Ult. Alteração: ".$resdb_depto->data_cad."</p>";else $reg_data       ="";
				if(isset($resdb_depto->status ))     $reg_status     = "<p>Status: ".$resdb_depto->status."</p>";          else $reg_status     ="";
				if(isset($resdb_depto->relevancia )) $reg_relevancia = "<p>Relevancia: ".$resdb_depto->relevancia."</p>";  else $reg_relevancia ="";
				if(isset($resdb_depto->nome ))       $reg_nome       = "<p>Categoria: ".$resdb_depto->nome."</p>";         else $reg_nome       ="";
				if(isset($resdb_depto->filtro ))     $reg_filtro     = "<p>Filtro: ".$resdb_depto->filtro."</p>";          else $reg_filtro     ="";
				if(isset($resdb_depto->menu ))       $reg_menu       = "<p>Menu: ".$resdb_depto->menu."</p>";              else $reg_menu       ="";
				$registro  = $reg_id.$reg_nome.$reg_titulo.$reg_status.$reg_relevancia.$reg_filtro.$reg_menu.$reg_data.$reg_user;				
				if ($updtdb_depto ->countline==1):
					// Início  - Rotina de gravar logs
					grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 		
					echo '<script> location.href="?p=loja&m=categorias&s=listar" </script>';
					// Final  - Rotina de gravar logs						
				else:
					$extra_msg = $reg_nome;
					getMSG('cb-803','alerta',$extra_msg);				
				endif;
			endif;

			?>
			<form class="pagform" method="post" action="">
				<fieldset>
					<legend>Alteração - Categorias</legend>
					<ul>
						<div >
							<li><label for="nome">Nome do Departamento:</label>
								<input type="text" name="nome" id="nome" size="30" maxlength="30" autofocus required
								placeholder="Nome do Departamento - Será apresentado no Site como filtro de pesquisa - Tamanho max 30 caracteres" 
							          title="Nome do Departamento - Será apresentado no Site como filtro de pesquisa - Tamanho max 30 caracteres" 
							 		  value="<?php echo $resdb_depto->nome;?>">   
						</div> 
						<br>
				
	            		<div >
							<li>
								<label for="filtro">Filtro (Ativar ou não como campo de pesquisa na Loja):</label>
								<select name="filtro">
									<option <?php if($resdb_depto->filtro == 0) echo 'selected="selected"';?> value=0>Inativo</option>
									<option <?php if($resdb_depto->filtro == 1) echo 'selected="selected"';?> value=1>Ativo</option>
								</select>
								<label for="Menu>Este Departamento fará para do Menu do Site?</label>
								<select name="menu">
									<option <?php if($resdb_depto->menu == 0) echo 'selected="selected"';?> value=0>Não</option>
									<option <?php if($resdb_depto->menu == 1) echo 'selected="selected"';?> value=1>Sim</option>
								</select>								
								<label for="status">Status:</label>
								<select name="status">
									<option <?php if($resdb_depto->status == 0) echo 'selected="selected"';?> value=0>Inativo</option>
									<option <?php if($resdb_depto->status == 1) echo 'selected="selected"';?> value=1>Ativo</option>
									<option <?php if($resdb_depto->status == 2) echo 'selected="selected"';?> value=2>Aprovar</option>
									<option <?php if($resdb_depto->status == 3) echo 'selected="selected"';?> value=3>Pendente</option>
								</select>
							 	<label for="relevancia">Relevancia:</label>
								<select name="relevancia">
									<option <?php if($resdb_depto->relevancia == 0) echo 'selected="selected"';?> value=0>Baixa</option>
									<option <?php if($resdb_depto->relevancia == 1) echo 'selected="selected"';?> value=1>Normal</option>
									<option <?php if($resdb_depto->relevancia == 2) echo 'selected="selected"';?> value=2>Média</option>
									<option <?php if($resdb_depto->relevancia == 3) echo 'selected="selected"';?> value=3>Alta</option>
								</select>
							</li>	
						</div>
						</br>		
						<div >
							<li class="center">
							    <input type="submit" name="editar" value="Alterar Dados" />
				                <input type="button" onclick="location.href='?p=loja&m=depto&s=listar'" value="Cancelar" />
							</li>	
						</div>
					</ul>
				</fieldset>
			</form>		
			</br>
			<div>
				<ul><label for="Itens">Produtos associados a este Departamento:</label>
				<?php
					$lerdb_prod = new produtos();
					$lerdb_prod->extra_select="where depto_id =".$resdb_depto->id;	
					$lerdb_prod->selectAll($lerdb_prod);
					while ($resdb_prod= $lerdb_prod->returnData()):	
				
						echo '<input type="text" name="titulo" id="titulo" size="30" disabled="disabled"
						 value="'.$resdb_prod->nome.'">';   
				 	endwhile;
				?>	  
				</ul>	
			</div>
			</br>
			<div>
				<ul><label for="Itens">Categorias associadas a este Departamento:</label>
				<?php
					$lerdb_cat = new categorias();
					$lerdb_cat->extra_select="where depto_id =".$resdb_depto->id;	
					$lerdb_cat->selectAll($lerdb_cat);
					while ($resdb_cat= $lerdb_cat->returnData()):	
				
						echo '<input type="text" name="titulo" id="titulo" size="30" disabled="disabled"
						 value="'.$resdb_cat->nome.'">';   
				 	endwhile;
				?>	  
				</ul>	
			</div>
			</br>	
			<div>
				<ul><label for="Itensx">Sub-Categorias associadas a este Departamento:</label>
				<?php
				
					$lerdb_scat = new sub_cat();
					$lerdb_scat->extra_select="where depto_id =".$resdb_depto->id;	
					$lerdb_scat->selectAll($lerdb_scat);
					while ($resdb_scat= $lerdb_scat->returnData()):	
				
						echo '<input type="text" name="titulo" id="titulo" size="30" disabled="disabled"
						 value="'.$resdb_scat->nome.'">';   
				 	endwhile;
				?>	  
				</ul>	
			</div>
			</br>	
		<?php
		else:
			printMSG('Você não tem permissão para efetuar alterações. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "p=loja&m=sub_categorias&s=listar";
			$extra_msg = '<a href="?p=loja&m=sub_categorias&s=listar" onclick="history.back()">Voltar</a>';
			getMSG('cb-909','alerta',$extra_msg);
		endif;
	break;
	case 'excluir':
		echo "<h2>Exclusão de Departamentos</h2>";
		//$session = new session();
		if (isAdmin()== TRUE ):
			date_default_timezone_set('America/Sao_Paulo');
			$datacad   = date('Y-m-d H:i:s');
			if (isset($_GET['id'])):
				//faz edição do Páginas
				$id = $_GET['id'];
				$lerdb_depto = new depto();
				$lerdb_depto->pk_value = $id;
				$lerdb_depto->extra_select = "WHERE id=$id";
				$lerdb_depto->selectAll($lerdb_depto);
				$resdb_depto = $lerdb_depto->returnData();	
				if (isset($_POST['exclusao'])):
					$deldb_depto = new depto();
					$deldb_depto->pk_value = $id;
					$deldb_depto->deleteDB($deldb_depto);
					if(isset($resdb_depto->id ))         $reg_id         = "<p>Reg no DB: ".$resdb_depto->id."</p>";           else $reg_id         ="";
					if(isset($resdb_depto->user_id ))    $reg_user       = "<p>User Resp: ".$resdb_depto->user_id."</p>";      else $reg_user       ="";
					if(isset($resdb_depto->data_cad ))   $reg_data       = "<p>Ult. Alteração: ".$resdb_depto->data_cad."</p>";else $reg_data       ="";
					if(isset($resdb_depto->status ))     $reg_status     = "<p>Status: ".$resdb_depto->status."</p>";          else $reg_status     ="";
					if(isset($resdb_depto->relevancia )) $reg_relevancia = "<p>Relevancia: ".$resdb_depto->relevancia."</p>";  else $reg_relevancia ="";
					if(isset($resdb_depto->nome ))       $reg_nome       = "<p>Categoria: ".$resdb_depto->nome."</p>";         else $reg_nome       ="";
					if(isset($resdb_depto->filtro ))     $reg_filtro     = "<p>Filtro: ".$resdb_depto->filtro."</p>";          else $reg_filtro     ="";
					if(isset($resdb_depto->menu ))       $reg_menu       = "<p>Menu: ".$resdb_depto->Menu."</p>";              else $reg_menu       ="";
					$registro  = $reg_id.$reg_nome.$reg_titulo.$reg_status.$reg_relevancia.$reg_filtro.$reg_menu.$reg_data.$reg_user;					
					if ($deldb_depto->countline==1):
						// Início  - Rotina de gravar logs
						grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 		
						echo '<script> location.href="?p=loja&m=categorias&s=listar" </script>';
						// Final  - Rotina de gravar logs	
				 	else:
						$extra_msg = $reg_nome;
						getMSG('cb-804','alerta',$extra_msg);			
					endif;
				endif;
			endif;
			?>
			<form class="userform" method="post" action="">
				<fieldset>
					<legend>Exclusão - Departamento</legend>
					<ul>
						<li><label for="nome">Nome do Departamento:</label>
						<?php echo $resdb_depto->nome;?>  			
						<li class="center">
						   	<input type="submit" name="exclusao" value="Confirma Exclusão" />
							<input type="button" onclick="location.href='?p=loja&m=depto&s=listar'" value="Cancelar" />
		               </li>	
					</ul>
				</fieldset>
			</form>	
			</br>
			<div>
				<ul><label for="Itens">Produtos associados a este Departamento:</label>
				<?php
					$lerdb_prod = new produtos();
					$lerdb_prod->extra_select="where depto_id =".$resdb_depto->id;	
					$lerdb_prod->selectAll($lerdb_prod);
					while ($resdb_prod= $lerdb_prod->returnData()):	
				
						echo '<input type="text" name="titulo" id="titulo" size="30" disabled="disabled"
						 value="'.$resdb_prod->nome.'">';   
				 	endwhile;
				?>	  
				</ul>	
			</div>
			</br>
			<div>
				<ul><label for="Itens">Categorias associadas a este Departamento:</label>
				<?php
					$lerdb_cat = new categorias();
					$lerdb_cat->extra_select="where depto_id =".$resdb_depto->id;	
					$lerdb_cat->selectAll($lerdb_cat);
					while ($resdb_cat= $lerdb_cat->returnData()):	
				
						echo '<input type="text" name="titulo" id="titulo" size="30" disabled="disabled"
						 value="'.$resdb_cat->nome.'">';   
				 	endwhile;
				?>	  
				</ul>	
			</div>
			</br>
			<div>
				<ul><label for="Itens">Sub-Categorias associadas a este Departamento:</label>
				<?php
					$lerdb_scat = new sub_cat();
					$lerdb_scat->extra_select="where depto_id =".$resdb_depto->id;	
					$lerdb_scat->selectAll($lerdb_scat);
					while ($resdb_scat= $lerdb_scat->returnData()):	
				
						echo '<input type="text" name="titulo" id="titulo" size="30" disabled="disabled"
						 value="'.$resdb_scat->nome.'">';   
				 	endwhile;
				?>	  
				</ul>	
			</div>
			</br>	 			
		<?php
		else:
			printMSG('Você não tem permissão para efetuar exclusões. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "p=loja&m=sub_categorias&s=listar";
			$extra_msg = '<a href="?p=loja&m=sub_categoriass&s=listar" onclick="history.back()">Voltar</a>';
			getMSG('cb-909','alerta',$extra_msg);
			unset($_POST);
		endif;
	break;
	default:
		getMSG("cb-005",$screen,NULL);
		break;
endswitch;
?>