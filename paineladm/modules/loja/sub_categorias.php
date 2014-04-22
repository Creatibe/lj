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
				$gravadb = new sub_cat(array(
					'nome'      =>$nome,
					'titulo'    =>$titulo,
					'status'    =>$status,
					'relevancia'=>$relevancia,
					'filtro'    =>$filtro,
					'menu'      =>$menu,
					'data_cad'  =>$datacad,
					'user_id'   =>$userid,
				));
				$gravadb ->insertDB($gravadb );
				if ($gravadb ->countline==1):
					// Início  - Rotina de gravar logs
					if(isset($id ))                $reg_id         = "<p>Reg no DB: ".$id."</p>";                  else $reg_id         ="";
					if(isset($user_id ))           $reg_user       = "<p>User Resp: ".$user_id."</p>";             else $reg_user       ="";
					if(isset($datacad ))           $reg_data       = "<p>Cadastro: ".$datacad."</p>";              else $reg_data       ="";
					if(isset($status ))            $reg_status     = "<p>Status: ".$status."</p>";                 else $reg_status     ="";
					if(isset($relevancia ))        $reg_relevancia = "<p>Relevancia: ".$relevancia."</p>";         else $reg_relevancia ="";
					if(isset($titulo ))            $reg_titulo     = "<p>Nome Interno: ".$titulo."</p>";           else $reg_titulo     ="";
					if(isset($nome ))              $reg_nome       = "<p>Nome Site: ".$nome."</p>";                else $reg_nome       ="";
					if(isset($filtro ))            $reg_filtro     = "<p>Filtro: ".$filtro."</p>";                 else $reg_filtro     ="";
					if(isset($menu ))              $reg_menu       = "<p>Menu: ".$menu."</p>";                     else $reg_menu       ="";
					$registro  = $reg_id.$reg_nome.$reg_titulo.$reg_status.$reg_relevancia.$reg_filtro.$reg_menu.$reg_data.$reg_user;
					grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 	
					// Final  - Rotina de gravar logs	
					echo '<script> location.href="?p=loja&m=item_sub_cat&s=incluir&sc='.$nome.'&datacad='.$datacad.'" </script>';
					$extra_msg = '<a href="'.ADMURL.'?p=loja&m=item_sub_cats&s=incluir&sc='.$nome.'&datacad='.$datacad.'">Cadastrar Opções</a>';
					getMSG('cb-911','sucesso',$extra_msg);
					unset ($_POST['nome']);
					unset ($_POST['titulo']);
					unset ($_POST['cadastrar']);
				endif;
			endif;
?>
			<form  name=pagform method="post" action="">
				<fieldset>
					<legend>Cadastro de Personalização das Categorias</legend>
					<p><h2>Cadastro de Personalização das Categorias</h2></p>
					<ul>
 						<div >	
							<li><label for="nome">Nome para o site:</label>
								<input type="text" class="area_editavel_pagina" name="nome" id="nome" size="30" maxlength="30" autofocus
								 placeholder="Nome da personalização - Será apresentado no Site como filtro de pesquisa - Tamanho max 30 caracteres" 
								size="30" title="Nome da personalização - Será apresentado no Site como filtro de pesquisa - Tamanho max 30 caracteres" required >
							</li>
							<li><label for="titulo">Nome interno para Cadastramento:</label>
								<input type="text" class="area_editavel_pagina" name="titulo" id="titulo" size="30" maxlength="30"
								 placeholder="Nome da personalização - Utilizado no cadastramento de Produtos - Tamanho max 30 caracteres" 
								size="30" title="Nome da personalização - Utilizado no cadastramento de Produtos - Tamanho max 30 caracteres" required >
							</li>							
		            	</div>
						<br>
						<div >
						<li><label for="filtro">Filtro (Ativar ou não como campo de pesquisa na Loja):</label>
							<select name="filtro">
								<option value=0>Inativo</option>
								<option selected="selected" value=1>Ativo</option>
							</select>
						<li><label for="menu">Esta Personalização fará parte do Menu do Site?:</label>
							<select name="menu">
								<option selected="selected" value=0>Inativo</option>
								<option  value=1>Ativo</option>
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
							    <input type="button" onclick="location.href='?p=loja&m=sub_categorias&s=listar'" value="Cancelar" />
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
		echo '<h2>Personalizações Cadastradas</h2>';
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
				
				
				$lerdb = new sub_cat();
				$lerdb->extra_select="where status = 1";	
				$lerdb->selectAll($lerdb);
				while ($resdb = $lerdb->returnData()):
					// ver se tem  o id na tabela item_sub_cat campo sub_cat_id
					$lerdb_item = new item_sub_cat();
					$lerdb_item->extra_select="where sub_cat_id =".$resdb->id." LIMIT 1";	
					$lerdb_item->selectAll($lerdb_item);
					$reg_item_sub_cat = $lerdb_item->countline;
					// ver se tem  o id na tabela categorias os campo sub_cat_xx = id
					//$lerdb_cat_scat  = new cat_scat_iscat();
					//$lerdb_cat_scat->extra_select="where 'i_sc_id' = ".$resdb->id;	
					//$lerdb_cat_scat->selectAll($lerdb_cat_scat);
					//$reg_cat_sub_cat = $lerdb_cat_scat->countline;
					$reg_cat_sub_cat = 0;
					//echo "<br>-----".$reg_item_sub_cat;
					if     ($resdb->filtro == 0) $filtro = "Inativo"; 
					elseif ($resdb->filtro == 1) $filtro = "Ativo";		
					if     ($resdb->menu   == 0) $menu   = "Inativo"; 
					elseif ($resdb->menu   == 1) $menu   = "Ativo";		
					if     ($resdb->status == 0) $status = "Inativo"; 
					elseif ($resdb->status == 1) $status = "Ativo";
					elseif ($resdb->status == 2) $status = "Aprovar";
					elseif ($resdb->status == 3) $status = "Pendente";
					if     ($resdb->relevancia == 0) $relevancia = "Baixa"; 
					elseif ($resdb->relevancia == 1) $relevancia = "Normal";
					elseif ($resdb->relevancia == 2) $relevancia = "Média";
					elseif ($resdb->relevancia == 3) $relevancia = "Alta";
					echo '<tr>';
					printf('<td>%s</td>',$resdb->nome);
					printf('<td>%s</td>',$resdb->titulo);
					printf('<td>%s</td>',$filtro);
					printf('<td>%s</td>',$menu);
					printf('<td>%s</td>',$status);
					printf('<td>%s</td>',$relevancia) ;
					if ($resdb->id != 0 and $reg_item_sub_cat == 0 and $reg_cat_sub_cat == 0):
						printf('<td class="center"><a href="?p=loja&m=sub_categorias&s=editar&id=%s" title="Editar"><img src="'.BASEURL.'images/edit.png") 
							alt="Editar" /></a></a> <a href="?p=loja&m=sub_categorias&s=excluir&id=%s" title="Excluir"><img src="'.BASEURL.'images/delete.png") 
							alt="Excluir" /></a> </td>',$resdb->id,$resdb->id,$resdb->id);
					else:
						printf('<td class="center"><a href="?p=loja&m=sub_categorias&s=editar&id=%s" title="Editar"><img src="'.BASEURL.'images/edit.png") 
							alt="Editar" /></a>
							<a title="Este item não pode ser excluído - Produtos, Categorias ou Opções de Personalização associados.">
							<img src="'.BASEURL.'images/nao_delete.png") 	alt=" Não Deletar este item" /></a>
							</a>  </td>',$resdb->id,$resdb->id,$resdb->id);
						
					endif;
					echo "</tr>";
				endwhile;
				?>
			</tbody>
		</table>
	<?php
	break;	
	case 'editar':
		echo "<h2>Alteração de Personalização</h2>";
		//$session = new session();
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
			$lerdb = new sub_cat();
			$lerdb->extra_select = "WHERE id=$id";
			$lerdb->selectAll($lerdb);
			$resdb = $lerdb->returnData();		
			if (isset($_POST['editar'])):
				//echo "<br> Descrição dos Páginas : ".$texto1."<br>";
				$updtdb = new sub_cat(array(
					'nome'       =>$nome,
					'titulo'     =>$titulo,
					'status'     =>$status,
					'relevancia' =>$relevancia,
					'filtro'     =>$filtro,
					'menu'       =>$menu,
					'data_cad'   =>$datacad,
					'user_id'    =>$userid,
				));
				$updtdb ->pk_value = $id;
				$updtdb ->updateDB($updtdb );
				if ($updtdb ->countline==1):
					// Início  - Rotina de gravar logs
					if(isset($resdb->id ))         $reg_id         = "<p>Reg no DB: ".$resdb->id."</p>";           else $reg_id         ="";
					if(isset($resdb->user_id ))    $reg_user       = "<p>User Resp: ".$resdb->user_id."</p>";      else $reg_user       ="";
					if(isset($resdb->data_cad ))   $reg_data       = "<p>Ult. Alteração: ".$resdb->data_cad."</p>";else $reg_data       ="";
					if(isset($resdb->status ))     $reg_status     = "<p>Status: ".$resdb->status."</p>";          else $reg_status     ="";
					if(isset($resdb->relevancia )) $reg_relevancia = "<p>Relevancia: ".$resdb->relevancia."</p>";  else $reg_relevancia ="";
					if(isset($resdb->titulo ))     $reg_titulo     = "<p>Nome Interno: ".$resdb->titulo."</p>";    else $reg_titulo     ="";
					if(isset($resdb->nome ))       $reg_nome       = "<p>Nome Site: ".$resdb->nome."</p>";         else $reg_nome       ="";
					if(isset($resdb->filtro ))     $reg_filtro     = "<p>Filtro: ".$resdb->filtro."</p>";          else $reg_filtro     ="";
					if(isset($resdb->menu ))       $reg_menu       = "<p>Menu: ".$resdb->menu."</p>";              else $reg_menu     ="";
					$registro  = $reg_id.$reg_nome.$reg_titulo.$reg_status.$reg_relevancia.$reg_filtro.$reg_menu.$reg_data.$reg_user;
					grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 		
					echo '<script> location.href="?p=loja&m=sub_categorias&s=listar" </script>';
					// Final  - Rotina de gravar logs						
					$extra_msg = '<a href="'.ADMURL.'?p=loja&m=sub_categorias&s=listar">Exibir Cadastros</a>';
					getMSG('cb-911','sucesso',$extra_msg);
					unset ($_POST['nome']);
				endif;
				//echo '<script> location.href="?m=paginas&s=listar" </script>';
			endif;

			$imagem_atual = $resdb->imagem;
			?>
			<form class="pagform" method="post" action="">
				<fieldset>
					<legend>Alteração - Personalização</legend>
					<ul>
						<div >
							<li><label for="nome">Nome para o site:</label>
								<input type="text" name="nome" id="nome" size="30" maxlength="30" autofocus required
								placeholder="Nome da personalização - Será apresentado no Site como filtro de pesquisa - Tamanho max 30 caracteres" 
							          title="Nome da personalização - Será apresentado no Site como filtro de pesquisa - Tamanho max 30 caracteres" 
							 		  value="<?php echo $resdb->nome;?>">   
						</div> 
						<div >
							<li><label for="titulo">Nome interno para Cadastramento:</label>
								<input type="text" name="titulo" id="titulo" size="30" required
								placeholder="Nome da personalização - Utilizado no cadastramento de Produtos - Tamanho max 30 caracteres" 
									  title="Nome da personalização - Utilizado no cadastramento de Produtos - Tamanho max 30 caracteres" 
							 		  value="<?php echo $resdb->titulo;?>">   
						</div> 
	            		<div >
							<li>
								<label for="filtro">Filtro (Ativar ou não como campo de pesquisa na Loja):</label>
								<select name="filtro">
									<option <?php if($resdb->filtro == 0) echo 'selected="selected"';?> value=0>Inativo</option>
									<option <?php if($resdb->filtro == 1) echo 'selected="selected"';?> value=1>Ativo</option>
								</select>
								<label for="Menu>Esta Personalização fará para do Menu do Site?</label>
								<select name="menu">
									<option <?php if($resdb->menu == 0) echo 'selected="selected"';?> value=0>Inativo</option>
									<option <?php if($resdb->menu == 1) echo 'selected="selected"';?> value=1>Ativo</option>
								</select>								
								<label for="status">Status:</label>
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
				                <input type="button" onclick="location.href='?p=loja&m=sub_categorias&s=listar'" value="Cancelar" />
							</li>	
						</div>
					</ul>
				</fieldset>
			</form>		
			</br>
			<div>
				<ul><label for="Itens">Categorias associadas a esta Personalização:</label>
				<?php
					$lerdb_cat  = new categorias();
					$lerdb_cat->extra_select="SELECT cat.*, 
						subcat.`id` AS sc_id
						 FROM `categorias` AS cat 
						INNER JOIN `sub_cat` AS subcat 
						ON cat.`sub_cat_1`  = subcat.`id` or cat.`sub_cat_2`  = subcat.`id` or cat.`sub_cat_3`  = subcat.`id` or cat.`sub_cat_4`  = subcat.`id` or 
						   cat.`sub_cat_5`  = subcat.`id` or cat.`sub_cat_6`  = subcat.`id` or cat.`sub_cat_7`  = subcat.`id` or cat.`sub_cat_8`  = subcat.`id` or 
						   cat.`sub_cat_9`  = subcat.`id` or cat.`sub_cat_10` = subcat.`id` or cat.`sub_cat_11` = subcat.`id` or cat.`sub_cat_12` = subcat.`id` or 
						   cat.`sub_cat_13` = subcat.`id` or cat.`sub_cat_14` = subcat.`id` or cat.`sub_cat_15` = subcat.`id` or cat.`sub_cat_16` = subcat.`id` or 
						   cat.`sub_cat_17` = subcat.`id` or cat.`sub_cat_18` = subcat.`id` or cat.`sub_cat_19` = subcat.`id` or cat.`sub_cat_20` = subcat.`id` 
						WHERE ( subcat.`id` =".$resdb->id." );";	
					$lerdb_cat->selectManual($lerdb_cat);
					while ($resdb_cat= $lerdb_cat->returnData()):	
						echo '<input type="text" name="titulo" id="titulo" size="30" disabled="disabled"
						 value="'.$resdb_cat->nome.'">';   
				 	endwhile;
				?>
				</ul>	
			</div>
			</br
			<div >
				<ul><label for="Itens">Opções de Personalização associadas a esta personalização:</label>
				<?php
					$lerdb_item = new item_sub_cat();
					$lerdb_item->extra_select="where sub_cat_id =".$resdb->id;	// ver se tem  o id na tabela item_sub_cat campo sub_cat_id
					$lerdb_item->selectAll($lerdb_item);
					while ($resdb_item= $lerdb_item->returnData()):	
				
						echo '<input type="text" name="titulo" id="titulo" size="30" disabled="disabled"
						 value="'.$resdb_item->nome.'">';   
				 	endwhile;
				?>	  
				</ul>	
			</div> 
		<?php
		else:
			printMSG('Você não tem permissão para efetuar alterações. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "p=loja&m=sub_categorias&s=listar";
			$extra_msg = '<a href="?p=loja&m=sub_categorias&s=listar" onclick="history.back()">Voltar</a>';
			getMSG('cb-909','alerta',$extra_msg);
		endif;
	break;
	case 'excluir':
		echo "<h2>Exclusão de Personalização</h2>";
		//$session = new session();
		if (isAdmin()== TRUE ):
			date_default_timezone_set('America/Sao_Paulo');
			$datacad   = date('Y-m-d H:i:s');
			if (isset($_GET['id'])):
				//faz edição do Páginas
				$id = $_GET['id'];
				$lerdb = new sub_cat();
				$lerdb->pk_value = $id;
				$lerdb->extra_select = "WHERE id=$id";
				$lerdb->selectAll($lerdb);
				$resdb = $lerdb->returnData();	
				if (isset($_POST['exclusao'])):
					$deldb = new sub_cat();
					$deldb->pk_value = $id;
					$deldb->deleteDB($deldb);
					if ($deldb->countline==1):
						// Início  - Rotina de gravar logs
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
						grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 		
						echo '<script> location.href="?p=loja&m=sub_categorias&s=listar" </script>';
						// Final  - Rotina de gravar logs	
						//echo '<script> location.href="?m=paginas&s=listar" </script>';
						$extra_msg = '<a href="'.ADMURL.'?p=loja&m=paginas&s=listar">Exibir Cadastros</a>';
						getMSG('cb-913','sucesso',$extra_msg);
						unset($_POST);
				 	else:
						$extra_msg = '<a href="'.ADMURL.'?p=loja&m=paginas&s=listar">Exibir Cadastros</a>';
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
					<legend>Exclusão - Personalização</legend>
					<ul>
						<li><label for="nome">Nome da Personalização no site:</label>
						<?php echo $resdb->nome;?>  			

						<li><label for="titulo">Nome interno da Personalização:</label>
						<?php echo $resdb->titulo;?>  			

						<li class="center">
						   	<input type="submit" name="exclusao" value="Confirma Exclusão" />
							<input type="button" onclick="location.href='?p=loja&m=sub_categorias&s=listar'" value="Cancelar" />
		               </li>	
					</ul>
				</fieldset>
			</form>	
			</br>
			<div >
				<ul><label for="Itens">Opções de Personalização associadas a esta personalização:</label>
				<?php
					$lerdb_item = new item_sub_cat();
					$lerdb_item->extra_select="where sub_cat_id =".$resdb->id;	// ver se tem  o id na tabela item_sub_cat campo sub_cat_id
					$lerdb_item->selectAll($lerdb_item);
					while ($resdb_item= $lerdb_item->returnData()):	
				
						echo '<input type="text" name="titulo" id="titulo" size="30" disabled="disabled"
						 value="'.$resdb_item->nome.'">';   
				 	endwhile;
				?>	  
				</ul>	
			</div> 			
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