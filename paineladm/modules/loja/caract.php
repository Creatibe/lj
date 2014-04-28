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
			if (!isset($_REQUEST['titulo']))     $titulo     = "";     else $titulo     = $_REQUEST['titulo'];			
			if (!isset($_REQUEST['filtro']))     $filtro     = "";     else $filtro     = $_REQUEST['filtro'];
			if (!isset($_REQUEST['menu']))  	 $menu       = "";     else $menu       = $_REQUEST['menu'];			
			if (!isset($_REQUEST['status']))     $status     = "";     else $status     = $_REQUEST['status'];
			if (!isset($_REQUEST['relevancia'])) $relevancia = "";     else $relevancia = $_REQUEST['relevancia'];
			$user_resp   = $userid;	
			date_default_timezone_set('America/Sao_Paulo');
			$datacad   = date('Y-m-d H:i:s');		
			if (isset($_POST['cadastrar'])):
				$gravadb_caract = new caract(array(
					'nome'      =>$nome,
					'titulo'    =>$titulo,
					'status'    =>$status,
					'relevancia'=>$relevancia,
					'filtro'    =>$filtro,
					'menu'      =>$menu,
					'data_cad'  =>$datacad,
					'user_id'   =>$userid,
				));
				$gravadb_caract ->insertDB($gravadb_caract );
				if(isset($id ))                $reg_id         = "<p>Reg no DB: ".$id."</p>";                  else $reg_id         ="";
				if(isset($user_id ))           $reg_user       = "<p>User Resp: ".$user_id."</p>";             else $reg_user       ="";
				if(isset($datacad ))           $reg_data       = "<p>Cadastro: ".$datacad."</p>";              else $reg_data       ="";
				if(isset($status ))            $reg_status     = "<p>Status: ".$status."</p>";                 else $reg_status     ="";
				if(isset($relevancia ))        $reg_relevancia = "<p>Relevancia: ".$relevancia."</p>";         else $reg_relevancia ="";
				if(isset($titulo ))            $reg_titulo     = "<p>Caract - Nome Interno: ".$titulo."</p>";           else $reg_titulo     ="";
				if(isset($nome ))              $reg_nome       = "<p>Caract - Nome Site: ".$nome."</p>";                else $reg_nome       ="";
				if(isset($filtro ))            $reg_filtro     = "<p>Filtro: ".$filtro."</p>";                 else $reg_filtro     ="";
				if(isset($menu ))              $reg_menu       = "<p>Menu: ".$menu."</p>";                     else $reg_menu       ="";
				$registro  = $reg_id.$reg_nome.$reg_titulo.$reg_status.$reg_relevancia.$reg_filtro.$reg_menu.$reg_data.$reg_user;
				if ($gravadb_caract ->countline==1):
					// Início  - Rotina de gravar logs
					grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 	
					// Final  - Rotina de gravar logs	
					echo '<script> location.href="?p=loja&m=opcoes&s=incluir&caract='.$nome.'&datacad='.$datacad.'" </script>';
				else:
					$extra_msg = $reg_nome;
					getMSG('cb-803','alerta',$extra_msg);							
				endif;
			endif;
?>
			<form  name=pagform method="post" action="">
				<fieldset>
					<legend>Cadastro de Caracteristicas</legend>
					<p><h2>Cadastro de Caracteristicas</h2></p>
					<ul>
 						<div >	
							<li><label for="nome">Nome para o site:</label>
								<input type="text" class="area_editavel_pagina" name="nome" id="nome" size="30" maxlength="30" autofocus
								 placeholder="Nome da Caracteristica - Será apresentado no Site como filtro de pesquisa - Tamanho max 30 caracteres" 
								size="30" title="Nome da Caracteristica - Será apresentado no Site como filtro de pesquisa - Tamanho max 30 caracteres" required >
							</li>
							<li><label for="titulo">Nome interno para Cadastramento:</label>
								<input type="text" class="area_editavel_pagina" name="titulo" id="titulo" size="30" maxlength="30"
								 placeholder="Nome da Caracteristica - Utilizado no cadastramento de Produtos - Tamanho max 30 caracteres" 
								size="30" title="Nome da Caracteristica - Utilizado no cadastramento de Produtos - Tamanho max 30 caracteres" required >
							</li>							
		            	</div>
						<br>
						<div >
						<li><label for="filtro">Filtro (Ativar ou não como campo de pesquisa na Loja):</label>
							<select name="filtro">
								<option value=0>Inativo</option>
								<option selected="selected" value=1>Ativo</option>
							</select>
						<li><label for="menu">Esta Caracteristica fará parte do Menu do Site?:</label>
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
							<li class="center"><input type="submit" name="cadastrar" value="Salvar e Inserir Opções" />
							    <input type="button" onclick="location.href='?p=loja&m=caract&s=listar'" value="Cancelar" />
							</li>
						</div> 
					</ul>
				</fieldset>	
			</form>	
			<?php
		else:
			printMSG('Você não tem permissão para utilizar esta rotina. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "p=loja&m=caractegorias&s=listar";
			$extra_msg = '<a href="?p=loja&m=caractegorias&s=listar" onclick="history.back()">Voltar</a>';
			getMSG('cb-909','alerta',$extra_msg);
		endif;		
	break;
	case 'listar':
		echo '<h2>Caracteristicas Cadastradas</h2>';
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
					<th>Nome Site</th><th>Nome Interno</th><th>Filtro</th><th>Menu</th><th>Sts</th><th>Relev</th><th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$lerdb_caract = new caract();
				$lerdb_caract->extra_select="where status = 1";	
				$lerdb_caract->selectAll($lerdb_caract);
				while ($resdb_caract = $lerdb_caract->returnData()):
					// ver se tem  o id na tabela opcoes campo caract_id
					$lerdb_opc = new opcoes();
					$lerdb_opc->extra_select="where caract_id ='".$resdb_caract->id."' LIMIT 1";	
					$lerdb_opc->selectAll($lerdb_opc);
					$reg_opcoes = $lerdb_opc->countline;
					$lerdb_scat = new sub_cat();
					$lerdb_scat->extra_select="SELECT subcat.*, 
						caract.`id` AS caract_id
						 FROM `sub_cat` AS subcat 
						INNER JOIN `caract` AS caract 
						ON subcat.`sub_cat_1`  = subcat.`id` or subcat.`sub_cat_2`  = subcat.`id` or subcat.`sub_cat_3`  = subcat.`id` or subcat.`sub_cat_4`  = subcat.`id` or 
						   subcat.`sub_cat_5`  = subcat.`id` or subcat.`sub_cat_6`  = subcat.`id` or subcat.`sub_cat_7`  = subcat.`id` or subcat.`sub_cat_8`  = subcat.`id` or 
						   subcat.`sub_cat_9`  = subcat.`id` or subcat.`sub_cat_10` = subcat.`id` or subcat.`sub_cat_11` = subcat.`id` or subcat.`sub_cat_12` = subcat.`id` or 
						   subcat.`sub_cat_13` = subcat.`id` or subcat.`sub_cat_14` = subcat.`id` or subcat.`sub_cat_15` = subcat.`id` or subcat.`sub_cat_16` = subcat.`id` or 
						   subcat.`sub_cat_17` = subcat.`id` or subcat.`sub_cat_18` = subcat.`id` or subcat.`sub_cat_19` = subcat.`id` or subcat.`sub_cat_20` = subcat.`id` 
						WHERE ( subcat.`id` =".$resdb_caract->id." );";	
					$lerdb_scat->selectManual($lerdb_scat);					
					$reg_scat = $lerdb_scat->countline;
					if     ($resdb_caract->filtro == 0) $filtro = "Inativo"; 
					elseif ($resdb_caract->filtro == 1) $filtro = "Ativo";		
					if     ($resdb_caract->menu   == 0) $menu   = "Inativo"; 
					elseif ($resdb_caract->menu   == 1) $menu   = "Ativo";		
					if     ($resdb_caract->status == 0) $status = "Inativo"; 
					elseif ($resdb_caract->status == 1) $status = "Ativo";
					elseif ($resdb_caract->status == 2) $status = "Aprovar";
					elseif ($resdb_caract->status == 3) $status = "Pendente";
					if     ($resdb_caract->relevancia == 0) $relevancia = "Baixa"; 
					elseif ($resdb_caract->relevancia == 1) $relevancia = "Normal";
					elseif ($resdb_caract->relevancia == 2) $relevancia = "Média";
					elseif ($resdb_caract->relevancia == 3) $relevancia = "Alta";
					echo '<tr>';
					printf('<td>%s</td>',$resdb_caract->nome);
					printf('<td>%s</td>',$resdb_caract->titulo);
					printf('<td>%s</td>',$filtro);
					printf('<td>%s</td>',$menu);
					printf('<td>%s</td>',$status);
					printf('<td>%s</td>',$relevancia) ;
					if ($resdb_caract->id != 0 and $reg_opcoes == 0 and $reg_scat == 0):
						printf('<td class="center"><a href="?p=loja&m=caract&s=editar&id=%s" title="Editar"><img src="'.BASEURL.'images/edit.png") 
							alt="Editar" /></a></a> <a href="?p=loja&m=caract&s=excluir&id=%s" title="Excluir"><img src="'.BASEURL.'images/delete.png") 
							alt="Excluir" /></a> </td>',$resdb_caract->id,$resdb_caract->id,$resdb_caract->id);
					else:
						printf('<td class="center"><a href="?p=loja&m=caract&s=editar&id=%s" title="Editar"><img src="'.BASEURL.'images/edit.png") 
							alt="Editar" /></a>
							<a title="Não pode ser excluída - Exite Sub-Categorias ou opções associadas.">
							<img src="'.BASEURL.'images/nao_delete.png") 	alt=" Não Deletar este item" /></a>
							</a>  </td>',$resdb_caract->id,$resdb_caract->id,$resdb_caract->id);
						
					endif;
					echo "</tr>";
				endwhile;
				?>
			</tbody>
		</table>
	<?php
	break;	
	case 'editar':
		echo "<h2>Alteração de Caracteristicas</h2>";
		if (isAdmin()== TRUE ):
			if (!isset($_REQUEST['id']))	     $id         = "";     else $id         = $_REQUEST['id'];
			if (!isset($_REQUEST['nome']))  	 $nome       = "";     else $nome       = $_REQUEST['nome'];
			if (!isset($_REQUEST['titulo']))     $titulo     = "";     else $titulo     = $_REQUEST['titulo'];			
			if (!isset($_REQUEST['filtro']))     $filtro     = "";     else $filtro     = $_REQUEST['filtro'];
			if (!isset($_REQUEST['menu']))   	 $menu       = "";     else $menu       = $_REQUEST['menu'];			
			if (!isset($_REQUEST['status']))     $status     = "";     else $status     = $_REQUEST['status'];
			if (!isset($_REQUEST['relevancia'])) $relevancia = "";     else $relevancia = $_REQUEST['relevancia'];
			$user_resp   = $userid;	
			date_default_timezone_set('America/Sao_Paulo');
			$datacad   = date('Y-m-d H:i:s');	
			$lerdb_caract = new caract();
			$lerdb_caract->extra_select = "WHERE id=$id";
			$lerdb_caract->selectAll($lerdb_caract);
			$resdb_caract = $lerdb_caract->returnData();		
			if (isset($_POST['editar'])):
				$updtdb_caract = new caract(array(
					'nome'       =>$nome,
					'titulo'     =>$titulo,
					'status'     =>$status,
					'relevancia' =>$relevancia,
					'filtro'     =>$filtro,
					'menu'       =>$menu,
					'data_cad'   =>$datacad,
					'user_id'    =>$userid,
				));
				$updtdb_caract ->pk_value = $id;
				$updtdb_caract ->updateDB($updtdb_caract );
				if(isset($resdb_caract->id ))         $reg_id         = "<p>Reg no DB: ".$resdb_caract->id."</p>";           else $reg_id         ="";
				if(isset($resdb_caract->user_id ))    $reg_user       = "<p>User Resp: ".$resdb_caract->user_id."</p>";      else $reg_user       ="";
				if(isset($resdb_caract->data_cad ))   $reg_data       = "<p>Ult. Alteração: ".$resdb_caract->data_cad."</p>";else $reg_data       ="";
				if(isset($resdb_caract->status ))     $reg_status     = "<p>Status: ".$resdb_caract->status."</p>";          else $reg_status     ="";
				if(isset($resdb_caract->relevancia )) $reg_relevancia = "<p>Relevancia: ".$resdb_caract->relevancia."</p>";  else $reg_relevancia ="";
				if(isset($resdb_caract->titulo ))     $reg_titulo     = "<p>Caract - Nome Interno: ".$resdb_caract->titulo."</p>";    else $reg_titulo     ="";
				if(isset($resdb_caract->nome ))       $reg_nome       = "<p>Caract - Nome Site: ".$resdb_caract->nome."</p>";         else $reg_nome       ="";
				if(isset($resdb_caract->filtro ))     $reg_filtro     = "<p>Filtro: ".$resdb_caract->filtro."</p>";          else $reg_filtro     ="";
				if(isset($resdb_caract->menu ))       $reg_menu       = "<p>Menu: ".$resdb_caract->menu."</p>";              else $reg_menu     ="";
				$registro  = $reg_id.$reg_nome.$reg_titulo.$reg_status.$reg_relevancia.$reg_filtro.$reg_menu.$reg_data.$reg_user;				
				if ($updtdb_caract ->countline==1):
					// Início  - Rotina de gravar logs
					grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 		
					echo '<script> location.href="?p=loja&m=caractegorias&s=listar" </script>';
					// Final  - Rotina de gravar logs						
				else:
					$extra_msg = $reg_nome;
					getMSG('cb-803','alerta',$extra_msg);
				endif;
				//echo '<script> location.href="?m=paginas&s=listar" </script>';
			endif;
			?>
			<form class="pagform" method="post" action="">
				<fieldset>
					<legend>Alteração - Personalização</legend>
					<ul>
						<div >
							<li><label for="nome">Nome para o site:</label>
								<input type="text" name="nome" id="nome" size="30" maxlength="30" autofocus required
								placeholder="Nome da Caracteristica - Será apresentado no Site como filtro de pesquisa - Tamanho max 30 caracteres" 
							          title="Nome da Caracteristica - Será apresentado no Site como filtro de pesquisa - Tamanho max 30 caracteres" 
							 		  value="<?php echo $resdb_caract->nome;?>">   
						</div> 
						<div >
							<li><label for="titulo">Nome interno para Cadastramento:</label>
								<input type="text" name="titulo" id="titulo" size="30" required
								placeholder="Nome da Caracteristica - Utilizado no cadastramento de Produtos - Tamanho max 30 caracteres" 
									  title="Nome da Caracteristica - Utilizado no cadastramento de Produtos - Tamanho max 30 caracteres" 
							 		  value="<?php echo $resdb_caract->titulo;?>">   
						</div> 
	            		<div >
							<li>
								<label for="filtro">Filtro (Ativar ou não como campo de pesquisa na Loja):</label>
								<select name="filtro">
									<option <?php if($resdb_caract->filtro == 0) echo 'selected="selected"';?> value=0>Inativo</option>
									<option <?php if($resdb_caract->filtro == 1) echo 'selected="selected"';?> value=1>Ativo</option>
								</select>
								<label for="Menu>Esta Personalização fará para do Menu do Site?</label>
								<select name="menu">
									<option <?php if($resdb_caract->menu == 0) echo 'selected="selected"';?> value=0>Inativo</option>
									<option <?php if($resdb_caract->menu == 1) echo 'selected="selected"';?> value=1>Ativo</option>
								</select>								
								<label for="status">Status:</label>
								<select name="status">
									<option <?php if($resdb_caract->status == 0) echo 'selected="selected"';?> value=0>Inativo</option>
									<option <?php if($resdb_caract->status == 1) echo 'selected="selected"';?> value=1>Ativo</option>
									<option <?php if($resdb_caract->status == 2) echo 'selected="selected"';?> value=2>Aprovar</option>
									<option <?php if($resdb_caract->status == 3) echo 'selected="selected"';?> value=3>Pendente</option>
								</select>
							 	<label for="relevancia">Relevancia:</label>
								<select name="relevancia">
									<option <?php if($resdb_caract->relevancia == 0) echo 'selected="selected"';?> value=0>Baixa</option>
									<option <?php if($resdb_caract->relevancia == 1) echo 'selected="selected"';?> value=1>Normal</option>
									<option <?php if($resdb_caract->relevancia == 2) echo 'selected="selected"';?> value=2>Média</option>
									<option <?php if($resdb_caract->relevancia == 3) echo 'selected="selected"';?> value=3>Alta</option>
								</select>
							</li>	
						</div>
						</br>		
						<div >
							<li class="center">
							    <input type="submit" name="editar" value="Alterar Dados" />
				                <input type="button" onclick="location.href='?p=loja&m=caract&s=listar'" value="Cancelar" />
							</li>	
						</div>
					</ul>
				</fieldset>
			</form>		
			</br>
			<div>
				<ul><label for="Itens">Sub-Categorias associadas a esta Caracteristica:</label>
				<?php
					$lerdb_scat  = new sub_cat();
					$lerdb_scat->extra_select="SELECT subcat.*, 
						caract.`id` AS caract_id
						 FROM `sub_cat` AS subcat 
						INNER JOIN `caract` AS caract 
						ON subcat.`sub_cat_1`  = subcat.`id` or subcat.`sub_cat_2`  = subcat.`id` or subcat.`sub_cat_3`  = subcat.`id` or subcat.`sub_cat_4`  = subcat.`id` or 
						   subcat.`sub_cat_5`  = subcat.`id` or subcat.`sub_cat_6`  = subcat.`id` or subcat.`sub_cat_7`  = subcat.`id` or subcat.`sub_cat_8`  = subcat.`id` or 
						   subcat.`sub_cat_9`  = subcat.`id` or subcat.`sub_cat_10` = subcat.`id` or subcat.`sub_cat_11` = subcat.`id` or subcat.`sub_cat_12` = subcat.`id` or 
						   subcat.`sub_cat_13` = subcat.`id` or subcat.`sub_cat_14` = subcat.`id` or subcat.`sub_cat_15` = subcat.`id` or subcat.`sub_cat_16` = subcat.`id` or 
						   subcat.`sub_cat_17` = subcat.`id` or subcat.`sub_cat_18` = subcat.`id` or subcat.`sub_cat_19` = subcat.`id` or subcat.`sub_cat_20` = subcat.`id` 
						WHERE ( subcat.`id` =".$resdb_caract->id." );";	
					$lerdb_scat->selectManual($lerdb_scat);
					while ($resdb_scat= $lerdb_scat->returnData()):	
						echo '<input type="text" name="titulo" id="titulo" size="30" disabled="disabled"
						 value="'.$resdb_scat->nome.'">';   
				 	endwhile;
				?>
				</ul>	
			</div>
			</br
			<div >
				<ul><label for="Itens">Opções associadas a esta Caracteristica:</label>
				<?php
					$lerdb_opc = new opcoes();
					$lerdb_opc->extra_select="where caract_id =".$resdb_caract->id;	// ver se tem  o id na tabela opcoes campo caract_id
					$lerdb_opc->selectAll($lerdb_opc);
					while ($resdb_opc= $lerdb_opc->returnData()):	
				
						echo '<input type="text" name="titulo" id="titulo" size="30" disabled="disabled"
						 value="'.$resdb_opc->nome.'">';   
				 	endwhile;
				?>	  
				</ul>	
			</div> 
		<?php
		else:
			printMSG('Você não tem permissão para efetuar alterações. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "p=loja&m=caractegorias&s=listar";
			$extra_msg = '<a href="?p=loja&m=caractegorias&s=listar" onclick="history.back()">Voltar</a>';
			getMSG('cb-909','alerta',$extra_msg);
		endif;
	break;
	case 'excluir':
		echo "<h2>Exclusão de Caracteristicas</h2>";
		//$session = new session();
		if (isAdmin()== TRUE ):
			date_default_timezone_set('America/Sao_Paulo');
			$datacad   = date('Y-m-d H:i:s');
			if (isset($_GET['id'])):
				//faz edição do Páginas
				$id = $_GET['id'];
				$lerdb_caract = new caract();
				$lerdb_caract->pk_value = $id;
				$lerdb_caract->extra_select = "WHERE id=$id";
				$lerdb_caract->selectAll($lerdb_caract);
				$resdb_caract = $lerdb_caract->returnData();	
				if (isset($_POST['exclusao'])):
					$deldb_caract = new caract();
					$deldb_caract->pk_value = $id;
					$deldb_caract->deleteDB($deldb_caract);
					if(isset($resdb->id ))         $reg_id         = "<p>Reg no DB: ".$resdb->id."</p>";           else $reg_id         ="";
					if(isset($resdb->user_id ))    $reg_user       = "<p>User Resp: ".$resdb->user_id."</p>";      else $reg_user       ="";
					if(isset($resdb->data_cad ))   $reg_data       = "<p>Ult. Alteração: ".$resdb->data_cad."</p>";else $reg_data       ="";
					if(isset($resdb->status ))     $reg_status     = "<p>Status: ".$resdb->status."</p>";          else $reg_status     ="";
					if(isset($resdb->relevancia )) $reg_relevancia = "<p>Relevancia: ".$resdb->relevancia."</p>";  else $reg_relevancia ="";
					if(isset($resdb->titulo ))     $reg_titulo     = "<p>Nome Interno: ".$resdb->titulo."</p>";    else $reg_titulo     ="";
					if(isset($resdb->nome ))       $reg_nome       = "<p>Nome Site: ".$resdb->nome."</p>";         else $reg_nome       ="";
					if(isset($resdb->filtro ))     $reg_filtro     = "<p>Filtro: ".$resdb->filtro."</p>";          else $reg_filtro     ="";
					if(isset($resdb->menu ))       $reg_menu       = "<p>Menu: ".$resdb->Menu."</p>";              else $reg_menu       ="";
					$registro  = $reg_id.$reg_nome.$reg_titulo.$reg_status.$reg_relevancia.$reg_filtro.$reg_menu.$reg_data.$reg_user;					
					if ($deldb_caract->countline==1):
						// Início  - Rotina de gravar logs
						grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 		
						echo '<script> location.href="?p=loja&m=caract&s=listar" </script>';
						// Final  - Rotina de gravar logs	
					else:				
						$extra_msg = $reg_nome;
						getMSG('cb-804','alerta',$extra_msg);			
					endif;
				endif;
			else:
				getMSG('cb-906','alerta',NULL);
			endif;
			?>
			<form class="userform" method="post" action="">
				<fieldset>
					<legend>Exclusão - Caracteristicas</legend>
					<ul>
						<li><label for="nome">Nome da Caracteristica no site:</label>
						<?php echo $resdb_caract->nome;?>  			

						<li><label for="titulo">Nome interno da Caracteristica:</label>
						<?php echo $resdb_caract->titulo;?>  			

						<li class="center">
						   	<input type="submit" name="exclusao" value="Confirma Exclusão" />
							<input type="button" onclick="location.href='?p=loja&m=caract&s=listar'" value="Cancelar" />
		               </li>	
					</ul>
				</fieldset>
			</form>	
			</br>
			<div >
				<ul><label for="Itens">Opções associadas a esta Caracteristica:</label>
				<?php
					$lerdb_opc = new opcoes();
					$lerdb_opc->extra_select="where caract_id =".$resdb->id;	// ver se tem  o id na tabela opcoes campo caract_id
					$lerdb_opc->selectAll($lerdb_opc);
					while ($resdb_opc= $lerdb_opc->returnData()):	
				
						echo '<input type="text" name="titulo" id="titulo" size="30" disabled="disabled"
						 value="'.$resdb_opc->nome.'">';   
				 	endwhile;
				?>	  
				</ul>	
			</div> 			
		<?php
		else:
			printMSG('Você não tem permissão para efetuar exclusões. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "p=loja&m=caract&s=listar";
			$extra_msg = '<a href="?p=loja&m=caract&s=listar" onclick="history.back()">Voltar</a>';
			getMSG('cb-909','alerta',$extra_msg);
			unset($_POST);
		endif;
	break;
	default:
		getMSG("cb-005",$screen,NULL);
		break;
endswitch;
?>