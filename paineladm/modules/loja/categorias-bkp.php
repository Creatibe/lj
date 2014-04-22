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
			//if (!isset($_REQUEST['sub_cats']))   $sub_cats   = "";     else $sub_cats    = $_REQUEST['sub_cats'];			
			$n_sc = 20;
			$n_sc_ok = 0;
			for ($i = 0; $i <= $n_sc; $i++):
				if ((isset($_POST["cadastrar"])) ):
					if (! empty($_REQUEST["sub_cats"][$i])):
					  $n_sc_ok ++;
					  $x_sc = "sub_cat_";
					  $x_sc =$x_sc . $n_sc_ok; 
					  $$x_sc  = $_REQUEST["sub_cats"][$i];
					endif; 
				endif;
			endfor;

			
			$user_resp   = $userid;	
			date_default_timezone_set('America/Sao_Paulo');
			$datacad   = date('Y-m-d H:i:s');		
			if (isset($_POST['cadastrar'])):
				$gravadb = new categorias(array(
					'nome'       =>$nome,
					'sub_cat_1'  =>$sub_cat_1,
					'sub_cat_2'  =>$sub_cat_2,
					'sub_cat_3'  =>$sub_cat_3,
					'sub_cat_4'  =>$sub_cat_4,
					'sub_cat_5'  =>$sub_cat_5,
					'sub_cat_6'  =>$sub_cat_6,
					'sub_cat_7'  =>$sub_cat_7,
					'sub_cat_8'  =>$sub_cat_8,
					'sub_cat_9'  =>$sub_cat_9,
					'sub_cat_10' =>$sub_cat_10,
					'sub_cat_11' =>$sub_cat_11,
					'sub_cat_12' =>$sub_cat_12,
					'sub_cat_13' =>$sub_cat_13,
					'sub_cat_14' =>$sub_cat_14,
					'sub_cat_15' =>$sub_cat_15,
					'sub_cat_16' =>$sub_cat_16,
					'sub_cat_17' =>$sub_cat_17,
					'sub_cat_18' =>$sub_cat_18,
					'sub_cat_19' =>$sub_cat_19,
					'sub_cat_20' =>$sub_cat_20,
					'status'     =>$status,
					'relevancia' =>$relevancia,
					'filtro'     =>$filtro,
					'menu'       =>$menu,
					'data_cad'   =>$datacad,
					'user_id'    =>$userid,
				));
				$gravadb ->insertDB($gravadb );
				if ($gravadb ->countline==1):
					// Início  - Rotina de gravar logs
					if(isset($id ))                $reg_id         = "<p>Reg no DB: ".$id."</p>";                  else $reg_id         ="";
					if(isset($user_id ))           $reg_user       = "<p>User Resp: ".$user_id."</p>";             else $reg_user       ="";
					if(isset($datacad ))           $reg_data       = "<p>Cadastro: ".$datacad."</p>";              else $reg_data       ="";
					if(isset($status ))            $reg_status     = "<p>Status: ".$status."</p>";                 else $reg_status     ="";
					if(isset($relevancia ))        $reg_relevancia = "<p>Relevancia: ".$relevancia."</p>";         else $reg_relevancia ="";
					if(isset($nome ))              $reg_nome       = "<p>Nome Site: ".$nome."</p>";                else $reg_nome       ="";
					if(isset($filtro ))            $reg_filtro     = "<p>Filtro: ".$filtro."</p>";                 else $reg_filtro     ="";
					if(isset($menu ))              $reg_menu       = "<p>Menu: ".$menu."</p>";                     else $reg_menu       ="";
					if(isset($sub_cat_1 ))         $reg_sub_cat_1  = "<p>Sub Cat 1:  ".$sub_cat_1."</p>";          else $reg_sub_cat_1  ="";
					if(isset($sub_cat_2 ))         $reg_sub_cat_2  = "<p>Sub Cat 2:  ".$sub_cat_2."</p>";          else $reg_sub_cat_2  ="";
					if(isset($sub_cat_3 ))         $reg_sub_cat_3  = "<p>Sub Cat 3:  ".$sub_cat_3."</p>";          else $reg_sub_cat_3  ="";
					if(isset($sub_cat_4 ))         $reg_sub_cat_4  = "<p>Sub Cat 4:  ".$sub_cat_4."</p>";          else $reg_sub_cat_4  ="";
					if(isset($sub_cat_5 ))         $reg_sub_cat_5  = "<p>Sub Cat 5:  ".$sub_cat_5."</p>";          else $reg_sub_cat_5  ="";
					if(isset($sub_cat_6 ))         $reg_sub_cat_6  = "<p>Sub Cat 6:  ".$sub_cat_6."</p>";          else $reg_sub_cat_6  ="";
					if(isset($sub_cat_7 ))         $reg_sub_cat_7  = "<p>Sub Cat 7:  ".$sub_cat_7."</p>";          else $reg_sub_cat_7  ="";
					if(isset($sub_cat_8 ))         $reg_sub_cat_8  = "<p>Sub Cat 8:  ".$sub_cat_8."</p>";          else $reg_sub_cat_8  ="";
					if(isset($sub_cat_9 ))         $reg_sub_cat_9  = "<p>Sub Cat 9:  ".$sub_cat_9."</p>";          else $reg_sub_cat_9  ="";
					if(isset($sub_cat_10))         $reg_sub_cat_10 = "<p>Sub Cat 10: ".$sub_cat_10."</p>";         else $reg_sub_cat_10 ="";
					if(isset($sub_cat_11))         $reg_sub_cat_11 = "<p>Sub Cat 11: ".$sub_cat_11."</p>";         else $reg_sub_cat_11 ="";
					if(isset($sub_cat_12))         $reg_sub_cat_12 = "<p>Sub Cat 12: ".$sub_cat_12."</p>";         else $reg_sub_cat_12 ="";
					if(isset($sub_cat_13))         $reg_sub_cat_13 = "<p>Sub Cat 13: ".$sub_cat_13."</p>";         else $reg_sub_cat_13 ="";
					if(isset($sub_cat_14))         $reg_sub_cat_14 = "<p>Sub Cat 14: ".$sub_cat_14."</p>";         else $reg_sub_cat_14 ="";
					if(isset($sub_cat_15))         $reg_sub_cat_15 = "<p>Sub Cat 15: ".$sub_cat_15."</p>";         else $reg_sub_cat_15 ="";
					if(isset($sub_cat_16))         $reg_sub_cat_16 = "<p>Sub Cat 16: ".$sub_cat_16."</p>";         else $reg_sub_cat_16 ="";
					if(isset($sub_cat_17))         $reg_sub_cat_17 = "<p>Sub Cat 17: ".$sub_cat_17."</p>";         else $reg_sub_cat_17 ="";
					if(isset($sub_cat_18))         $reg_sub_cat_18 = "<p>Sub Cat 18: ".$sub_cat_18."</p>";         else $reg_sub_cat_18 ="";
					if(isset($sub_cat_19))         $reg_sub_cat_19 = "<p>Sub Cat 19: ".$sub_cat_19."</p>";         else $reg_sub_cat_19 ="";
					if(isset($sub_cat_20))         $reg_sub_cat_20 = "<p>Sub Cat 20: ".$sub_cat_20."</p>";         else $reg_sub_cat_20 ="";					
					$registro  =$reg_id.$reg_nome.$reg_sub_cat_1.$reg_sub_cat_2.$reg_sub_cat_3.$reg_sub_cat_4.$reg_sub_cat_5.$reg_sub_cat_6;
					$registro .=$reg_sub_cat_7.$reg_sub_cat_8.$reg_sub_cat_9.$reg_sub_cat_10.$reg_sub_cat_11.$reg_sub_cat_12.$reg_sub_cat_13;
					$registro .=$reg_sub_cat_14.$reg_sub_cat_15.$reg_sub_cat_16.$reg_sub_cat_17.$reg_sub_cat_18.$reg_sub_cat_19.$reg_sub_cat_20;
					$registro .=$reg_status.$reg_relevancia.$reg_filtro.$reg_menu.$reg_data.$reg_user;
					grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 	
					// Final  - Rotina de gravar logs	
					echo '<script> location.href="?p=loja&m=categorias&s=listar&sc='.$nome.'&datacad='.$datacad.'" </script>';
					$extra_msg = '<a href="'.ADMURL.'?p=loja&m=categorias&s=incluir&sc='.$nome.'&datacad='.$datacad.'">Cadastrar Opções</a>';
					getMSG('cb-911','sucesso',$extra_msg);
					unset ($_POST['nome']);
					unset ($_POST['titulo']);
					unset ($_POST['cadastrar']);
				endif;
			endif;
?>
			<form  name=pagform method="post" action="">
				<fieldset>
					<legend>Cadastro de Categorias</legend>
					<p><h2>Cadastro de Categorias</h2></p>
					<ul>
 						<div >	
							<li><label for="nome">Categoria:</label>
								<input type="text" class="area_editavel_pagina" name="nome" id="nome" size="30" maxlength="30" autofocus
								 placeholder="Nome da Categoria - Tamanho max 30 caracteres" 
								size="30" title="Nome da Categoria - Tamanho max 30 caracteres"  required >
							</li>
		            	</div>
						<br>
						
 						<div >	
							<li><label for="sub_cats">Selecione de 1 a 20 Personalizações para esta Categoria:</label>
								<?php
								$lerdb = new sub_cat();
								$lerdb->extra_select="where status = 1 order by relevancia DESC, titulo ASC";	
								$lerdb->selectAll($lerdb);
								while ($resdb= $lerdb->returnData()):
									echo '<input type="checkbox" name="sub_cats[]" value="'.$resdb->id.'" />'.$resdb->titulo.'&nbsp&nbsp';
								endwhile;
								?>
								
							</li>
		            	</div>
						<br>						
						
						<div >
						<li><label for="filtro">Filtro (Ativar ou não como campo de pesquisa na Loja):</label>
							<select name="filtro">
								<option value=0>Inativo</option>
								<option selected="selected" value=1>Ativo</option>
							</select>
						<li><label for="menu">Esta Categoria fará parte do Menu do Site?</label>
							<select name="menu">
								<option selected="selected" value=0>Inativo</option>
								<option value=1>Ativo</option>
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
							<li class="center"><input type="submit" name="cadastrar" value="Salvar Dados" />
							    <input type="button" onclick="location.href='?p=loja&m=categorias&s=listar'" value="Cancelar" />
							</li>
						</div> 
					</ul>
				</fieldset>	
			</form>	
			<?php
		else:
			printMSG('Você não tem permissão para utilizar esta rotina. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "p=loja&m=categorias&s=listar";
			$extra_msg = '<a href="?p=loja&m=categorias&s=listar" onclick="history.back()">Voltar</a>';
			getMSG('cb-909','alerta',$extra_msg);
		endif;		
	break;
	case 'listar':
		echo '<h2>Categorias Cadastradas</h2>';
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
					<th>Categoria</th><th>Filtro</th><th>Menu</th><th>Sts</th><th>Relev</th><th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$lerdb = new categorias();
				//$lerdb->extra_select="GROUP by titulo";	
				$lerdb->selectAll($lerdb);
				$lerdb_item = new item_sub_cat();
				while ($resdb= $lerdb->returnData()):
					$lerdb_item->extra_select="where sub_cat_id =".$resdb->id." LIMIT 1";	// ver se tem  o id na tabela item_sub_cat campo sub_cat_id
					$lerdb_item->selectAll($lerdb_item);
					//$reg_item_sub_cat = $lerdb_item->countline;
					$reg_item_sub_cat = 0;
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
					printf('<td>%s</td>',$filtro);
					printf('<td>%s</td>',$menu);
					printf('<td>%s</td>',$status);
					printf('<td>%s</td>',$relevancia) ;
					if ($resdb->id != 0 and $reg_item_sub_cat == 0):
						printf('<td class="center"><a href="?p=loja&m=categorias&s=editar&id=%s" title="Editar"><img src="'.BASEURL.'images/edit.png") 
							alt="Editar" /></a></a> <a href="?p=loja&m=categorias&s=excluir&id=%s" title="Excluir"><img src="'.BASEURL.'images/delete.png") 
							alt="Excluir" /></a> </td>',$resdb->id,$resdb->id,$resdb->id);
					else:
						printf('<td class="center"><a href="?p=loja&m=categorias&s=editar&id=%s" title="Editar"><img src="'.BASEURL.'images/edit.png") 
							alt="Editar" /></a>
							<a title="Este item não pode ser excluído - Produtos, Personalizações ou Opções de Personalização associados.">
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
		echo "<h2>Alteração de Categorias</h2>";
		//$session = new session();
		if (isAdmin()== TRUE ):

			if (!isset($_REQUEST['id']))	     $id         = "";     else $id         = $_REQUEST['id'];
			if (!isset($_REQUEST['nome']))  	 $nome       = "";     else $nome       = $_REQUEST['nome'];
			if (!isset($_REQUEST['menu']))  	 $menu       = "";     else $menu       = $_REQUEST['menu'];
			if (!isset($_REQUEST['filtro']))     $filtro     = "";     else $filtro     = $_REQUEST['filtro'];
			if (!isset($_REQUEST['status']))     $status     = "";     else $status     = $_REQUEST['status'];
			if (!isset($_REQUEST['relevancia'])) $relevancia = "";     else $relevancia = $_REQUEST['relevancia'];
			//if (!isset($_REQUEST['sub_cats']))   $sub_cats   = "";     else $sub_cats    = $_REQUEST['sub_cats'];			
			$n_sc = 20;
			$n_sc_ok = 0;
			if (isset($_POST['editar'])):
				for ($i = "0"; $i < $n_sc; $i++):
						$n_sc_ok ++;
						$x_sc = "sub_cat_";
						$x_sc =$x_sc . $n_sc_ok; 
						$$x_sc  = "0";
						if (! empty($_REQUEST["sub_cats"][$i])):
						  $$x_sc  = $_REQUEST["sub_cats"][$i];
						endif; 
						//echo '<br>'.$x_sc. ': '.$$x_sc;
				endfor;
			endif;
			$lerdb = new categorias();
			$lerdb->extra_select = "WHERE id=$id Limit 1";
			$lerdb->selectAll($lerdb);
			$resdb = $lerdb->returnData();				
			$user_resp   = $userid;	
			date_default_timezone_set('America/Sao_Paulo');
			$datacad   = date('Y-m-d H:i:s');		
			if (isset($_POST['editar'])):
				$updtdb = new categorias(array(
					'nome'       =>$nome,
					'sub_cat_1'  =>$sub_cat_1,
					'sub_cat_2'  =>$sub_cat_2,
					'sub_cat_3'  =>$sub_cat_3,
					'sub_cat_4'  =>$sub_cat_4,
					'sub_cat_5'  =>$sub_cat_5,
					'sub_cat_6'  =>$sub_cat_6,
					'sub_cat_7'  =>$sub_cat_7,
					'sub_cat_8'  =>$sub_cat_8,
					'sub_cat_9'  =>$sub_cat_9,
					'sub_cat_10' =>$sub_cat_10,
					'sub_cat_11' =>$sub_cat_11,
					'sub_cat_12' =>$sub_cat_12,
					'sub_cat_13' =>$sub_cat_13,
					'sub_cat_14' =>$sub_cat_14,
					'sub_cat_15' =>$sub_cat_15,
					'sub_cat_16' =>$sub_cat_16,
					'sub_cat_17' =>$sub_cat_17,
					'sub_cat_18' =>$sub_cat_18,
					'sub_cat_19' =>$sub_cat_19,
					'sub_cat_20' =>$sub_cat_20,
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
					if(isset($resdb->id ))         $reg_id         = "<p>Reg no DB: ".$resdb->id."</p>";            else $reg_id         ="";
					if(isset($resdb->user_id ))    $reg_user       = "<p>User Resp: " .$resdb->user_id."</p>";      else $reg_user       ="";
					if(isset($resdb->data_cad ))   $reg_data       = "<p>Ult. Alteração: ".$resdb->data_cad."</p>"; else $reg_data       ="";
					if(isset($resdb->status ))     $reg_status     = "<p>Status: "    .$resdb->status."</p>";       else $reg_status     ="";
					if(isset($resdb->relevancia )) $reg_relevancia = "<p>Relevancia: ".$resdb->relevancia."</p>";   else $reg_relevancia ="";
					if(isset($resdb->nome ))       $reg_nome       = "<p>Nome Site: " .$resdb->nome."</p>";         else $reg_nome       ="";
					if(isset($resdb->filtro ))     $reg_filtro     = "<p>Filtro: "    .$resdb->filtro."</p>";       else $reg_filtro     ="";
					if(isset($resdb->menu ))       $reg_menu       = "<p>Menu: "      .$resdb->menu."</p>";         else $reg_menu       ="";
					if(isset($resdb->sub_cat_1 ))  $reg_sub_cat_1  = "<p>Sub Cat 1:  ".$resdb->sub_cat_1."</p>";    else $reg_sub_cat_1  ="";
					if(isset($resdb->sub_cat_2 ))  $reg_sub_cat_2  = "<p>Sub Cat 2:  ".$resdb->sub_cat_2."</p>";    else $reg_sub_cat_2  ="";
					if(isset($resdb->sub_cat_3 ))  $reg_sub_cat_3  = "<p>Sub Cat 3:  ".$resdb->sub_cat_3."</p>";    else $reg_sub_cat_3  ="";
					if(isset($resdb->sub_cat_4 ))  $reg_sub_cat_4  = "<p>Sub Cat 4:  ".$resdb->sub_cat_4."</p>";    else $reg_sub_cat_4  ="";
					if(isset($resdb->sub_cat_5 ))  $reg_sub_cat_5  = "<p>Sub Cat 5:  ".$resdb->sub_cat_5."</p>";    else $reg_sub_cat_5  ="";
					if(isset($resdb->sub_cat_6 ))  $reg_sub_cat_6  = "<p>Sub Cat 6:  ".$resdb->sub_cat_6."</p>";    else $reg_sub_cat_6  ="";
					if(isset($resdb->sub_cat_7 ))  $reg_sub_cat_7  = "<p>Sub Cat 7:  ".$resdb->sub_cat_7."</p>";    else $reg_sub_cat_7  ="";
					if(isset($resdb->sub_cat_8 ))  $reg_sub_cat_8  = "<p>Sub Cat 8:  ".$resdb->sub_cat_8."</p>";    else $reg_sub_cat_8  ="";
					if(isset($resdb->sub_cat_9 ))  $reg_sub_cat_9  = "<p>Sub Cat 9:  ".$resdb->sub_cat_9."</p>";    else $reg_sub_cat_9  ="";
					if(isset($resdb->sub_cat_10))  $reg_sub_cat_10 = "<p>Sub Cat 10: ".$resdb->sub_cat_10."</p>";   else $reg_sub_cat_10 ="";
					if(isset($resdb->sub_cat_11))  $reg_sub_cat_11 = "<p>Sub Cat 11: ".$resdb->sub_cat_11."</p>";   else $reg_sub_cat_11 ="";
					if(isset($resdb->sub_cat_12))  $reg_sub_cat_12 = "<p>Sub Cat 12: ".$resdb->sub_cat_12."</p>";   else $reg_sub_cat_12 ="";
					if(isset($resdb->sub_cat_13))  $reg_sub_cat_13 = "<p>Sub Cat 13: ".$resdb->sub_cat_13."</p>";   else $reg_sub_cat_13 ="";
					if(isset($resdb->sub_cat_14))  $reg_sub_cat_14 = "<p>Sub Cat 14: ".$resdb->sub_cat_14."</p>";   else $reg_sub_cat_14 ="";
					if(isset($resdb->sub_cat_15))  $reg_sub_cat_15 = "<p>Sub Cat 15: ".$resdb->sub_cat_15."</p>";   else $reg_sub_cat_15 ="";
					if(isset($resdb->sub_cat_16))  $reg_sub_cat_16 = "<p>Sub Cat 16: ".$resdb->sub_cat_16."</p>";   else $reg_sub_cat_16 ="";
					if(isset($resdb->sub_cat_17))  $reg_sub_cat_17 = "<p>Sub Cat 17: ".$resdb->sub_cat_17."</p>";   else $reg_sub_cat_17 ="";
					if(isset($resdb->sub_cat_18))  $reg_sub_cat_18 = "<p>Sub Cat 18: ".$resdb->sub_cat_18."</p>";   else $reg_sub_cat_18 ="";
					if(isset($resdb->sub_cat_19))  $reg_sub_cat_19 = "<p>Sub Cat 19: ".$resdb->sub_cat_19."</p>";   else $reg_sub_cat_19 ="";
					if(isset($resdb->sub_cat_20))  $reg_sub_cat_20 = "<p>Sub Cat 20: ".$resdb->sub_cat_20."</p>";   else $reg_sub_cat_20 ="";					
					$registro  =$reg_id.$reg_nome.$reg_sub_cat_1.$reg_sub_cat_2.$reg_sub_cat_3.$reg_sub_cat_4.$reg_sub_cat_5.$reg_sub_cat_6;
					$registro .=$reg_sub_cat_7.$reg_sub_cat_8.$reg_sub_cat_9.$reg_sub_cat_10.$reg_sub_cat_11.$reg_sub_cat_12.$reg_sub_cat_13;
					$registro .=$reg_sub_cat_14.$reg_sub_cat_15.$reg_sub_cat_16.$reg_sub_cat_17.$reg_sub_cat_18.$reg_sub_cat_19.$reg_sub_cat_20;
					$registro .=$reg_status.$reg_relevancia.$reg_filtro.$reg_menu.$reg_data.$reg_user;
					grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 						
					// Final  - Rotina de gravar logs		
					alt_prod_detalhes($id,'listar',$userid,$user_ip,$userid,$user_ip,$acao,$rotina."-Alt_Cat+Prod_Detalhes");//chama rotina para alterar detalhes do produto			
				else:
					echo "<br>erro ao gravar alteração";
					echo $registro;
				endif;
			endif;
			?>
			<form class="pagform" method="post" action="">
				<fieldset>
					<legend>Alteração - Personalização</legend>
					<ul>
						<div >
							<li><label for="nome">Categoria:</label>
								<input type="text" name="nome" id="nome" size="30" maxlength="30" autofocus required
								placeholder="Nome da personalização - Será apresentado no Site como filtro de pesquisa - Tamanho max 30 caracteres" 
							          title="Nome da personalização - Será apresentado no Site como filtro de pesquisa - Tamanho max 30 caracteres" 
							 		  value="<?php echo $resdb->nome;?>">   
						</div> 
						</br>
						<div >
							<li><label for="nome">Personalizações Disponíveis:</label>
							</br>
						<?php
						
							$n_sc = 20;
							$n_sc_ok = 0;
							for ($i = 0; $i < $n_sc; $i++):
								
								$x_sc = "sub_cat_";
								$x_sc =$x_sc . $i;
								$$x_sc  = $resdb->$x_sc;
								if ($$x_sc != 0):
									$n_sc_ok ++;
									//echo '<input type="checkbox" name="sub_cats[]" value="'.$resdb->id.'" />'.str_pad($resdb->titulo,30," . ",1).'&nbsp';
									//echo '<br>'.$x_sc. ': '.$$x_sc;
									//echo '<br>'.$sub_cat_1;
									//echo '<br>'.$sub_cat_2;
								endif;
							endfor;
							$lerdb_scat = new sub_cat();
							$lerdb_scat->extra_select="where status = 1 order by relevancia DESC, titulo ASC";
							$lerdb_scat->selectAll($lerdb_scat);
							$i = 0;
							while ($resdb_scat= $lerdb_scat->returnData()):	
								$i ++;
								$ix ++;
								switch ($resdb_scat->id) {
									case $sub_cat_1 : echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_scat->id.'" />'.$resdb_scat->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_2 : echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_scat->id.'" />'.$resdb_scat->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_3 : echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_scat->id.'" />'.$resdb_scat->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_4 : echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_scat->id.'" />'.$resdb_scat->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_5 : echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_scat->id.'" />'.$resdb_scat->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_6 : echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_scat->id.'" />'.$resdb_scat->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_7 : echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_scat->id.'" />'.$resdb_scat->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_8 : echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_scat->id.'" />'.$resdb_scat->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_9 : echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_scat->id.'" />'.$resdb_scat->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_10: echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_scat->id.'" />'.$resdb_scat->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_11: echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_scat->id.'" />'.$resdb_scat->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_12: echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_scat->id.'" />'.$resdb_scat->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_13: echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_scat->id.'" />'.$resdb_scat->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_14: echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_scat->id.'" />'.$resdb_scat->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_15: echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_scat->id.'" />'.$resdb_scat->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_16: echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_scat->id.'" />'.$resdb_scat->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_17: echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_scat->id.'" />'.$resdb_scat->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_18: echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_scat->id.'" />'.$resdb_scat->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_19: echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_scat->id.'" />'.$resdb_scat->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_20: echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_scat->id.'" />'.$resdb_scat->titulo.'&nbsp&nbsp'; break;
									default:          echo '<input type="checkbox" name="sub_cats[]"                   value="'.$resdb_scat->id.'" />'.$resdb_scat->titulo.'&nbsp&nbsp'; break;
								}
								if ($ix == 8): $ix= 0; echo "<br>"; endif;
							endwhile;
							
						?>
						</div>

						</br>
	            		<div >
							<li>
								<label for="filtro">Filtro (Ativar ou não como campo de pesquisa na Loja):</label>
								<select name="filtro">
									<option <?php if($resdb->filtro == 0) echo 'selected="selected"';?> value=0>Inativo</option>
									<option <?php if($resdb->filtro == 1) echo 'selected="selected"';?> value=1>Ativo</option>
								</select>
								<label for="menu">Esta Categoria fará parte do Menu do Site:</label>
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
				                <input type="button" onclick="location.href='?p=loja&m=categorias&s=listar'" value="Cancelar" />
							</li>	
						</div>
					</ul>
				</fieldset>
			</form>		
			</br>
			<div >
				<ul><label for="prod">Produtos Associados a esta Categoria:</label>
				<?php
					$lerdb_item = new produtos();
					$lerdb_item->extra_select="where categorias_id =".$resdb->id;	// ver se tem  o id na tabela item_sub_cat campo sub_cat_id
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
				$lerdb = new categorias();
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
					if(isset($resdb->id ))         $reg_id         = "<p>Reg no DB: ".$resdb->id."</p>";            else $reg_id         ="";
					if(isset($resdb->user_id ))    $reg_user       = "<p>User Resp: " .$resdb->user_id."</p>";      else $reg_user       ="";
					if(isset($resdb->data_cad ))   $reg_data       = "<p>Ult. Alteração: ".$resdb->data_cad."</p>"; else $reg_data       ="";
					if(isset($resdb->status ))     $reg_status     = "<p>Status: "    .$resdb->status."</p>";       else $reg_status     ="";
					if(isset($resdb->relevancia )) $reg_relevancia = "<p>Relevancia: ".$resdb->relevancia."</p>";   else $reg_relevancia ="";
					if(isset($resdb->nome ))       $reg_nome       = "<p>Nome Site: " .$resdb->nome."</p>";         else $reg_nome       ="";
					if(isset($resdb->filtro ))     $reg_filtro     = "<p>Filtro: "    .$resdb->filtro."</p>";       else $reg_filtro     ="";
					if(isset($resdb->menu ))       $reg_menu       = "<p>Menu: "      .$resdb->menu."</p>";         else $reg_menu       ="";
					if(isset($resdb->sub_cat_1 ))  $reg_sub_cat_1  = "<p>Sub Cat 1:  ".$resdb->sub_cat_1."</p>";    else $reg_sub_cat_1  ="";
					if(isset($resdb->sub_cat_2 ))  $reg_sub_cat_2  = "<p>Sub Cat 2:  ".$resdb->sub_cat_2."</p>";    else $reg_sub_cat_2  ="";
					if(isset($resdb->sub_cat_3 ))  $reg_sub_cat_3  = "<p>Sub Cat 3:  ".$resdb->sub_cat_3."</p>";    else $reg_sub_cat_3  ="";
					if(isset($resdb->sub_cat_4 ))  $reg_sub_cat_4  = "<p>Sub Cat 4:  ".$resdb->sub_cat_4."</p>";    else $reg_sub_cat_4  ="";
					if(isset($resdb->sub_cat_5 ))  $reg_sub_cat_5  = "<p>Sub Cat 5:  ".$resdb->sub_cat_5."</p>";    else $reg_sub_cat_5  ="";
					if(isset($resdb->sub_cat_6 ))  $reg_sub_cat_6  = "<p>Sub Cat 6:  ".$resdb->sub_cat_6."</p>";    else $reg_sub_cat_6  ="";
					if(isset($resdb->sub_cat_7 ))  $reg_sub_cat_7  = "<p>Sub Cat 7:  ".$resdb->sub_cat_7."</p>";    else $reg_sub_cat_7  ="";
					if(isset($resdb->sub_cat_8 ))  $reg_sub_cat_8  = "<p>Sub Cat 8:  ".$resdb->sub_cat_8."</p>";    else $reg_sub_cat_8  ="";
					if(isset($resdb->sub_cat_9 ))  $reg_sub_cat_9  = "<p>Sub Cat 9:  ".$resdb->sub_cat_9."</p>";    else $reg_sub_cat_9  ="";
					if(isset($resdb->sub_cat_10))  $reg_sub_cat_10 = "<p>Sub Cat 10: ".$resdb->sub_cat_10."</p>";   else $reg_sub_cat_10 ="";
					if(isset($resdb->sub_cat_11))  $reg_sub_cat_11 = "<p>Sub Cat 11: ".$resdb->sub_cat_11."</p>";   else $reg_sub_cat_11 ="";
					if(isset($resdb->sub_cat_12))  $reg_sub_cat_12 = "<p>Sub Cat 12: ".$resdb->sub_cat_12."</p>";   else $reg_sub_cat_12 ="";
					if(isset($resdb->sub_cat_13))  $reg_sub_cat_13 = "<p>Sub Cat 13: ".$resdb->sub_cat_13."</p>";   else $reg_sub_cat_13 ="";
					if(isset($resdb->sub_cat_14))  $reg_sub_cat_14 = "<p>Sub Cat 14: ".$resdb->sub_cat_14."</p>";   else $reg_sub_cat_14 ="";
					if(isset($resdb->sub_cat_15))  $reg_sub_cat_15 = "<p>Sub Cat 15: ".$resdb->sub_cat_15."</p>";   else $reg_sub_cat_15 ="";
					if(isset($resdb->sub_cat_16))  $reg_sub_cat_16 = "<p>Sub Cat 16: ".$resdb->sub_cat_16."</p>";   else $reg_sub_cat_16 ="";
					if(isset($resdb->sub_cat_17))  $reg_sub_cat_17 = "<p>Sub Cat 17: ".$resdb->sub_cat_17."</p>";   else $reg_sub_cat_17 ="";
					if(isset($resdb->sub_cat_18))  $reg_sub_cat_18 = "<p>Sub Cat 18: ".$resdb->sub_cat_18."</p>";   else $reg_sub_cat_18 ="";
					if(isset($resdb->sub_cat_19))  $reg_sub_cat_19 = "<p>Sub Cat 19: ".$resdb->sub_cat_19."</p>";   else $reg_sub_cat_19 ="";
					if(isset($resdb->sub_cat_20))  $reg_sub_cat_20 = "<p>Sub Cat 20: ".$resdb->sub_cat_20."</p>";   else $reg_sub_cat_20 ="";					
					$registro  =$reg_id.$reg_nome.$reg_sub_cat_1.$reg_sub_cat_2.$reg_sub_cat_3.$reg_sub_cat_4.$reg_sub_cat_5.$reg_sub_cat_6;
					$registro .=$reg_sub_cat_7.$reg_sub_cat_8.$reg_sub_cat_9.$reg_sub_cat_10.$reg_sub_cat_11.$reg_sub_cat_12.$reg_sub_cat_13;
					$registro .=$reg_sub_cat_14.$reg_sub_cat_15.$reg_sub_cat_16.$reg_sub_cat_17.$reg_sub_cat_18.$reg_sub_cat_19.$reg_sub_cat_20;
					$registro .=$reg_status.$reg_relevancia.$reg_filtro.$reg_menu.$reg_data.$reg_user;
					grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 						
						echo '<script> location.href="?p=loja&m=categorias&s=listar" </script>';
						// Final  - Rotina de gravar logs	
						//echo '<script> location.href="?m=paginas&s=listar" </script>';
						$extra_msg = '<a href="'.ADMURL.'?p=loja&m=categorias&s=listar">Exibir Cadastros</a>';
						getMSG('cb-913','sucesso',$extra_msg);
						unset($_POST);
				 	else:
						$extra_msg = '<a href="'.ADMURL.'?p=loja&m=categorias&s=listar">Exibir Cadastros</a>';
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
					<legend>Exclusão - Categorias</legend>
					<ul>
						<li><label for="nome">Categoria:</label>
						<?php echo $resdb->nome;?>  			

						<li class="center">
						   	<input type="submit" name="exclusao" value="Confirma Exclusão" />
							<input type="button" onclick="location.href='?p=loja&m=sub_categorias&s=listar'" value="Cancelar" />
		               </li>	
					</ul>
				</fieldset>
			</form>	
			</br>
			<div >
				<ul><label for="Itens">Personalizações associadas a esta Categoria:</label>
				<?php
					$lerdb_item = new cat_subcat();
					$lerdb_item->extra_select="where id =".$resdb->id;	// ver se tem  o id na tabela cat_subcat campo cat_id
					$lerdb_item->selectAll($lerdb_item);
					while ($resdb_item= $lerdb_item->returnData()):	
				
						echo '<input type="text" name="titulo" id="titulo" size="30" disabled="disabled"
						 value="'.$resdb_item->sc_nome.'">';   
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
	function alt_prod_detalhes($id=null,$retorno=null,$userid=null,$user_ip=null,$acao=null,$rotina=null)
{
					
				if (isset($id) != null):
					echo "passou aqui - id :".$id;
					echo "<script>alert('As definições Categoria do Produto foram alteradas. Os Produtos afetados nesta Alteração ficarão com o Status PENDENTE e Será necessário personalizar os Produtos novamente.');</script>";
					date_default_timezone_set('America/Sao_Paulo');
					$datacad   = date('Y-m-d H:i:s');
					$lerdb = new categorias();
					$lerdb->extra_select = "WHERE id=".$id;
					$lerdb->selectAll($lerdb);
					$resdb_cat = $lerdb->returnData();
					$n_cat = 21;
					$n_cats = 0;
					for ($i = 1; $i < $n_cat; $i++):
							$n_cats = "subcat_";
							$n_cats =$n_cats . $i; 
							$cat = "sub_cat_";
							$cat =$cat . $i; 
							$$cat  = $resdb_cat->$cat;
							$$n_cats = $$cat; 
							echo "<br>".$cat." = ".$$cat;
							echo "<br>".$n_cats." = ".$$n_cats;
					endfor;
					
					
					
								
					$lerdb = new produtos_detalhes();
					$lerdb->extra_select = "WHERE prod_categorias_id=".$id;
					$lerdb->selectAll($lerdb);
					while ($resdb = $lerdb->returnData()):
						$n_nm = 21;
						$n_cats = 0;
						for ($i = 1; $i < $n_nm; $i++):
								$x_sc = "sub_cat_";
								$x_nm = "nome_";
								$x_nm =$x_nm . $i; 
								$x_sc =$x_sc . $i; 
								$$x_nm  = 0;
								$$x_sc  = 0;
								$alt_prod_det = 0;
								if (! empty($resdb->$x_sc) != 0):
									$$x_nm  = $resdb->$x_nm;
								  	$$x_sc  = $resdb->$x_sc;
									echo '<br> monta form --'.$x_sc.' : '.$$x_sc.' --- '.$x_nm. ': '.$$x_nm;
									$lerdb_cat = new categorias();
									$lerdb_cat->extra_select="where status = 1 and id = ".$id." and ".$x_sc." =".$$x_sc."  LIMIT 1";	
									$lerdb_cat->selectAll($lerdb_cat);
									$resdb_cat= $lerdb_cat->returnData();
									if ($resdb_cat->countline === 0):
										echo "<br>passou aqui - ".$resdb_cat->countline;
										$$x_sc = 0;
										$$x_nm = 0;
										$alt_prod_det ++;
										echo '<br>'.$resdb_cat->nome.' / '.$resdb_cat->id;
									else:
										$$x_sc = $resdb_cat->id;   
										//$$x_nm = $resdb_cat->nome;
										/*	
										$lerdb_iscat = new item_sub_cat();
										$lerdb_iscat->extra_select="where status = 1 and sub_cat_id =".$resdb_cat->id;	
										$lerdb_iscat->selectAll($lerdb_iscat);
										
										while ($resdb_iscat= $lerdb_iscat->returnData()):
											if($$x_sc == $resdb_iscat->id   and $resdb_iscat->id    != 0 ):
												 $$x_sc = $resdb_iscat->id;   
												 $$x_nm = $resdb_iscat->nome;
												 $alt_prod_det ++;
											else: 
												$$x_sc = 0;
												$$x_nm = 0;
											endif;
										endwhile;
										 */ 
									endif;
								endif; 
								echo '<br> monta form --'.$x_sc.' : '.$$x_sc.' --- '.$x_nm. ': '.$$x_nm;
						endfor;	
						
						if ($alt_prod_det >0):
							$n_nm = 21;
							$n_cats = 1;	
							for ($i = 1; $i < $n_nm; $i++):
								$n_cats ++;
								$x_sc = "sub_cat_";
								$x_nm = "nome_";
								$x_nm2 =$x_nm . $n_cats; 
								$x_sc2 =$x_sc . $n_cats; 
								$x_nm =$x_nm . $i; 
								$x_sc =$x_sc . $i; 
								
								if ($$x_sc  == 0):
									$$x_nm  = $$x_nm2;
									$$x_sc  = $$x_sc2;
									$$x_nm2  = 0;
									$$x_sc2  = 0;
								endif;
							endfor;
							$updtdb = new produtos_detalhes(array(
							'sub_cat_1'  =>$sub_cat_1,
							'sub_cat_2'  =>$sub_cat_2,
							'sub_cat_3'  =>$sub_cat_3,
							'sub_cat_4'  =>$sub_cat_4,
							'sub_cat_5'  =>$sub_cat_5,
							'sub_cat_6'  =>$sub_cat_6,
							'sub_cat_7'  =>$sub_cat_7,
							'sub_cat_8'  =>$sub_cat_8,
							'sub_cat_9'  =>$sub_cat_9,
							'sub_cat_10' =>$sub_cat_10,
							'sub_cat_11' =>$sub_cat_11,
							'sub_cat_12' =>$sub_cat_12,
							'sub_cat_13' =>$sub_cat_13,
							'sub_cat_14' =>$sub_cat_14,
							'sub_cat_15' =>$sub_cat_15,
							'sub_cat_16' =>$sub_cat_16,
							'sub_cat_17' =>$sub_cat_17,
							'sub_cat_18' =>$sub_cat_18,
							'sub_cat_19' =>$sub_cat_19,
							'sub_cat_20' =>$sub_cat_20,
							'nome_1'     =>$nome_1,
							'nome_2'     =>$nome_2,
							'nome_3'     =>$nome_3,
							'nome_4'     =>$nome_4,
							'nome_5'     =>$nome_5,
							'nome_6'     =>$nome_6,
							'nome_7'     =>$nome_7,
							'nome_8'     =>$nome_8,
							'nome_9'     =>$nome_9,
							'nome_10'    =>$nome_10,
							'nome_11'    =>$nome_11,
							'nome_12'    =>$nome_12,
							'nome_13'    =>$nome_13,
							'nome_14'    =>$nome_14,
							'nome_15'    =>$nome_15,
							'nome_16'    =>$nome_16,
							'nome_17'    =>$nome_17,
							'nome_18'    =>$nome_18,
							'nome_19'    =>$nome_19,
							'nome_20'    =>$nome_20,
							'produtos_id'=>$resdb->produtos_id,
							'prod_status'=>2,
							'data_cad'   =>$datacad,
							'user_id'    =>$userid,
							));
		
							$updtdb ->pk_value = $resdb->id;
							$updtdb ->updateDB($updtdb );
		
							if ($updtdb->countline==1):
							// Início  - Rotina de gravar logs
								if(isset($resdb->id ))         $reg_id         = "<p>Reg no DB: ".$resdb->id."</p>";            else $reg_id         ="";
								if(isset($resdb->user_id ))    $reg_user       = "<p>User Resp: " .$resdb->user_id."</p>";      else $reg_user       ="";
								if(isset($resdb->data_cad ))   $reg_data       = "<p>Ult. Alteração: ".$resdb->data_cad."</p>"; else $reg_data       ="";
								if(isset($resdb->produtos_id)) $reg_produtos_id= "<p>Produto: ".$resdb->produtos_id."</p>";     else $reg_produtos_id ="";
								if(isset($resdb->sub_cat_1 ))  $reg_sub_cat_1  = "<p>Sub Cat 1:  ".$resdb->sub_cat_1."</p>";    else $reg_sub_cat_1  ="";
								if(isset($resdb->sub_cat_2 ))  $reg_sub_cat_2  = "<p>Sub Cat 2:  ".$resdb->sub_cat_2."</p>";    else $reg_sub_cat_2  ="";
								if(isset($resdb->sub_cat_3 ))  $reg_sub_cat_3  = "<p>Sub Cat 3:  ".$resdb->sub_cat_3."</p>";    else $reg_sub_cat_3  ="";
								if(isset($resdb->sub_cat_4 ))  $reg_sub_cat_4  = "<p>Sub Cat 4:  ".$resdb->sub_cat_4."</p>";    else $reg_sub_cat_4  ="";
								if(isset($resdb->sub_cat_5 ))  $reg_sub_cat_5  = "<p>Sub Cat 5:  ".$resdb->sub_cat_5."</p>";    else $reg_sub_cat_5  ="";
								if(isset($resdb->sub_cat_6 ))  $reg_sub_cat_6  = "<p>Sub Cat 6:  ".$resdb->sub_cat_6."</p>";    else $reg_sub_cat_6  ="";
								if(isset($resdb->sub_cat_7 ))  $reg_sub_cat_7  = "<p>Sub Cat 7:  ".$resdb->sub_cat_7."</p>";    else $reg_sub_cat_7  ="";
								if(isset($resdb->sub_cat_8 ))  $reg_sub_cat_8  = "<p>Sub Cat 8:  ".$resdb->sub_cat_8."</p>";    else $reg_sub_cat_8  ="";
								if(isset($resdb->sub_cat_9 ))  $reg_sub_cat_9  = "<p>Sub Cat 9:  ".$resdb->sub_cat_9."</p>";    else $reg_sub_cat_9  ="";
								if(isset($resdb->sub_cat_10))  $reg_sub_cat_10 = "<p>Sub Cat 10: ".$resdb->sub_cat_10."</p>";   else $reg_sub_cat_10 ="";
								if(isset($resdb->sub_cat_11))  $reg_sub_cat_11 = "<p>Sub Cat 11: ".$resdb->sub_cat_11."</p>";   else $reg_sub_cat_11 ="";
								if(isset($resdb->sub_cat_12))  $reg_sub_cat_12 = "<p>Sub Cat 12: ".$resdb->sub_cat_12."</p>";   else $reg_sub_cat_12 ="";
								if(isset($resdb->sub_cat_13))  $reg_sub_cat_13 = "<p>Sub Cat 13: ".$resdb->sub_cat_13."</p>";   else $reg_sub_cat_13 ="";
								if(isset($resdb->sub_cat_14))  $reg_sub_cat_14 = "<p>Sub Cat 14: ".$resdb->sub_cat_14."</p>";   else $reg_sub_cat_14 ="";
								if(isset($resdb->sub_cat_15))  $reg_sub_cat_15 = "<p>Sub Cat 15: ".$resdb->sub_cat_15."</p>";   else $reg_sub_cat_15 ="";
								if(isset($resdb->sub_cat_16))  $reg_sub_cat_16 = "<p>Sub Cat 16: ".$resdb->sub_cat_16."</p>";   else $reg_sub_cat_16 ="";
								if(isset($resdb->sub_cat_17))  $reg_sub_cat_17 = "<p>Sub Cat 17: ".$resdb->sub_cat_17."</p>";   else $reg_sub_cat_17 ="";
								if(isset($resdb->sub_cat_18))  $reg_sub_cat_18 = "<p>Sub Cat 18: ".$resdb->sub_cat_18."</p>";   else $reg_sub_cat_18 ="";
								if(isset($resdb->sub_cat_19))  $reg_sub_cat_19 = "<p>Sub Cat 19: ".$resdb->sub_cat_19."</p>";   else $reg_sub_cat_19 ="";
								if(isset($resdb->sub_cat_20))  $reg_sub_cat_20 = "<p>Sub Cat 20: ".$resdb->sub_cat_20."</p>";   else $reg_sub_cat_20 ="";
								if(isset($resdb->nome_1 ))     $reg_nome_1     = "<p>Detalhe 1:  ".$resdb->nome_1."</p>";       else $reg_nome_1     ="";
								if(isset($resdb->nome_2 ))     $reg_nome_2     = "<p>Detalhe 2:  ".$resdb->nome_2."</p>";       else $reg_nome_2     ="";	
								if(isset($resdb->nome_3 ))     $reg_nome_3     = "<p>Detalhe 3:  ".$resdb->nome_3."</p>";       else $reg_nome_3     ="";	
								if(isset($resdb->nome_4 ))     $reg_nome_4     = "<p>Detalhe 4:  ".$resdb->nome_4."</p>";       else $reg_nome_4     ="";	
								if(isset($resdb->nome_5 ))     $reg_nome_5     = "<p>Detalhe 5:  ".$resdb->nome_5."</p>";       else $reg_nome_5     ="";	
								if(isset($resdb->nome_6 ))     $reg_nome_6     = "<p>Detalhe 6:  ".$resdb->nome_6."</p>";       else $reg_nome_6     ="";	
								if(isset($resdb->nome_7 ))     $reg_nome_7     = "<p>Detalhe 7:  ".$resdb->nome_7."</p>";       else $reg_nome_7     ="";	
								if(isset($resdb->nome_8 ))     $reg_nome_8     = "<p>Detalhe 8:  ".$resdb->nome_8."</p>";       else $reg_nome_8     ="";	
								if(isset($resdb->nome_9 ))     $reg_nome_9     = "<p>Detalhe 9:  ".$resdb->nome_9."</p>";       else $reg_nome_9     ="";	
								if(isset($resdb->nome_10 ))    $reg_nome_10    = "<p>Detalhe 10: ".$resdb->nome_10."</p>";      else $reg_nome_10    ="";	
								if(isset($resdb->nome_11 ))    $reg_nome_11    = "<p>Detalhe 11: ".$resdb->nome_11."</p>";      else $reg_nome_11    ="";	
								if(isset($resdb->nome_12 ))    $reg_nome_12    = "<p>Detalhe 12: ".$resdb->nome_12."</p>";      else $reg_nome_12    ="";	
								if(isset($resdb->nome_13 ))    $reg_nome_13    = "<p>Detalhe 13: ".$resdb->nome_13."</p>";      else $reg_nome_13    ="";	
								if(isset($resdb->nome_14 ))    $reg_nome_14    = "<p>Detalhe 14: ".$resdb->nome_14."</p>";      else $reg_nome_14    ="";	
								if(isset($resdb->nome_15 ))    $reg_nome_15    = "<p>Detalhe 15: ".$resdb->nome_15."</p>";      else $reg_nome_15    ="";	
								if(isset($resdb->nome_16 ))    $reg_nome_16    = "<p>Detalhe 16: ".$resdb->nome_16."</p>";      else $reg_nome_16    ="";	
								if(isset($resdb->nome_17 ))    $reg_nome_17    = "<p>Detalhe 17: ".$resdb->nome_17."</p>";      else $reg_nome_17    ="";	
								if(isset($resdb->nome_18 ))    $reg_nome_18    = "<p>Detalhe 18: ".$resdb->nome_18."</p>";      else $reg_nome_18    ="";	
								if(isset($resdb->nome_19 ))    $reg_nome_19    = "<p>Detalhe 19: ".$resdb->nome_19."</p>";      else $reg_nome_19    ="";	
								if(isset($resdb->nome_20 ))    $reg_nome_20    = "<p>Detalhe 20: ".$resdb->nome_20."</p>";      else $reg_nome_20    ="";						
								$registro  =$reg_id.$reg_sub_cat_1.$reg_sub_cat_2.$reg_sub_cat_3.$reg_sub_cat_4.$reg_sub_cat_5.$reg_sub_cat_6;
								$registro .=$reg_sub_cat_7.$reg_sub_cat_8.$reg_sub_cat_9.$reg_sub_cat_10.$reg_sub_cat_11.$reg_sub_cat_12.$reg_sub_cat_13;
								$registro .=$reg_sub_cat_14.$reg_sub_cat_15.$reg_sub_cat_16.$reg_sub_cat_17.$reg_sub_cat_18.$reg_sub_cat_19.$reg_sub_cat_20;
								$registro .=$reg_nome_1.$reg_nome_2.$reg_nome_3.$reg_nome_4.$reg_nome_5.$reg_nome_6.$reg_nome_7.$reg_nome_8.$reg_nome_9.$reg_nome_10;
								$registro .=$reg_nome_11.$reg_nome_12.$reg_nome_13.$reg_nome_14.$reg_nome_15.$reg_nome_16.$reg_nome_17.$reg_nome_18.$reg_nome_19.$reg_nome_20;
								$registro .=$reg_status.$reg_produto_id.$reg_data.$reg_user;
								grava_log($userid,$user_ip,$rotina.'alt-detalhes-cat',$acao,$registro,$datacad); 
							else:
								echo 'Erro ao excluir  Detalhes Produto:';
								echo $registro;
							endif;
						endif;
					endwhile;
					if ($retorno == 'voltar'):
						return;
					else:
						echo '<script> location.href="?p=loja&m=categorias&s='.$retorno.'" </script>';
					endif;
				endif;
} // fecha função de alterar detalhes do produto	
/*
	function alt_prod_detalhes($id=null,$retorno=null,$userid=null,$user_ip=null,$acao=null,$rotina=null)
{
		echo "<h2>Personalização de Produtos</h2>";
		$lerdb = new detalhes_produtos();
		$lerdb->extra_select = "WHERE produtos_id=$id";
		$lerdb->selectAll($lerdb);
		$resdb_prod_det = $lerdb->returnData();			
		
		if (isAdmin()== TRUE ):
			if (!isset($resdb_prod_det->id))	        $id            = "";     else $id            = $resdb_prod_det->id;
			if (!isset($resdb_prod_det->sku))  	        $sku           = "";     else $sku           = $resdb_prod_det->sku;
			if (!isset($resdb_prod_det->nome))  	    $nome          = "";     else $nome          = $resdb_prod_det->nome;
			if (!isset($resdb_prod_det->titulo))  	    $titulo        = "";     else $titulo        = $resdb_prod_det->titulo;
			if (!isset($resdb_prod_det->valor))         $valor         = "";     else $valor         = $resdb_prod_det->valor;
			if (!isset($resdb_prod_det->desconto))      $desconto      = "";     else $desconto      = $resdb_prod_det->desconto;
			if (!isset($resdb_prod_det->promocao)) 	    $promocao      = "";     else $promocao      = $resdb_prod_det->promocao;
			if (!isset($resdb_prod_det->estoque))  	    $estoque       = "";     else $estoque       = $resdb_prod_det->estoque;
			if (!isset($resdb_prod_det->encomenda))	    $encomenda     = "";     else $encomenda     = $resdb_prod_det->encomenda;
			if (!isset($resdb_prod_det->fixar_home))    $fixar_home    = "";     else $fixar_home    = $resdb_prod_det->fixar_home;
			if (!isset($resdb_prod_det->categorias))    $categorias    = "";     else $categorias    = $resdb_prod_det->categorias;
			if (!isset($resdb_prod_det->qtde_vendida))  $qtde_vendida  = "";     else $qtde_vendida  = $resdb_prod_det->qtde_vendida;
			if (!isset($resdb_prod_det->valor_vendido)) $valor_vendido = "";     else $valor_vendido = $resdb_prod_det->valor_vendido;
			if (!isset($resdb_prod_det->status))        $status        = "";     else $status        = $resdb_prod_det->status;
			if (!isset($resdb_prod_det->relevancia))    $relevancia    = "";     else $relevancia    = $resdb_prod_det->relevancia;
			//Verifica as categoirias e sub-categorias
			$n_sc = 20;
			$n_xx_ok = 0;
			for ($i = 0; $i <= $n_sc; $i++):
					$n_xx_ok ++;
					$x_sc = "sub_cat_";
					$x_sc =$x_sc . $n_xx_ok ; 
					$$x_sc  = 0;
					if (! empty($resdb_prod_det->$x_sc)):
					  $$x_sc  = $resdb_prod_det->$x_sc;
					endif; 
					$x_nm = "nome_";
					$x_nm =$x_nm . $n_xx_ok ; 
					$$x_nm  = 0;
					if (! empty($resdb_prod_det->$x_nm)):
					  $$x_nm  = $resdb_prod_det->$x_nm;
					endif; 
					//echo '<br>'.$x_sc. ': '.$$x_sc.' --- '.$x_nm. ': '.$$x_nm;
			endfor;
			$user_resp   = $userid;	
			date_default_timezone_set('America/Sao_Paulo');
			$datacad   = date('Y-m-d H:i:s');		
			$X_vlaor = strstr($valor, ',', true);
			if ($x_valor == 1 ) $valor = str_replace(".", "", $valor);
			$valor = str_replace(",", ".", $valor);
			$X_vlaor = strstr($promocao, ',', true);
			if ($X_vlaor ==1) $promocao = str_replace(".", "", $promocao);
			$promocao = str_replace(",", ".", $promocao);
			$lerdb = new produtos_detalhes();
			$lerdb->extra_select = "WHERE prod_id =".$id." Limit 1";
			$lerdb->selectAll($lerdb);
			$resdb = $lerdb->returnData();				
			
			if (isset($_POST['editar'])):
				$updtdb = new produtos(array(
					'status'        =>$status,
					'relevancia'    =>$relevancia,
					'data_cad'      =>$datacad,
					'user_id'       =>$userid,
				));
				$updtdb ->pk_value = $id;
				$updtdb ->updateDB($updtdb );
				// Início  - Rotina de gravar logs
				if(isset($id ))                        $reg_id            = "<p>Reg no DB: ".$id."</p>";                  else $reg_id            ="";
				if(isset($sku ))                       $reg_sku           = "<p>Sku do Produto: ".$sku."</p>";            else $reg_sku           ="";
				if(isset($user_id ))                   $reg_user          = "<p>User Resp: ".$user_id."</p>";             else $reg_user          ="";
				if(isset($datacad ))                   $reg_data          = "<p>Cadastro: ".$datacad."</p>";              else $reg_data          ="";
				if(isset($status ))                    $reg_status        = "<p>Status: ".$status."</p>";                 else $reg_status        ="";
				if(isset($relevancia ))                $reg_relevancia    = "<p>Relevancia: ".$relevancia."</p>";         else $reg_relevancia    ="";
				if(isset($nome ))                      $reg_nome          = "<p>Nome Produto: ".$nome."</p>";             else $reg_nome          ="";
				if(isset($titulo ))                    $reg_titulo        = "<p>Descrição: ".$titulo."</p>";              else $reg_titulo        ="";
				if(isset($valor ))                     $reg_valor         = "<p>Valor: ".$valor."</p>";                   else $reg_valor         ="";
				if(isset($desconto ))                  $reg_desconto      = "<p>Desconto:  ".$desconto."</p>";            else $reg_desconto      ="";
				if(isset($promocao ))                  $reg_promocao      = "<p>Promocão:  ".$promocao."</p>";            else $reg_promocao      ="";
				if(isset($estoque ))                   $reg_estoque       = "<p>Estoque:  ".$estoque."</p>";              else $reg_estoque       ="";
				if(isset($encomenda ))                 $reg_encomenda     = "<p>Encomenda:  ".$encomenda."</p>";          else $reg_encomenda     ="";
				if(isset($fixar_home ))                $reg_fixar_home    = "<p>Fixo na Home:  ".$fixar_home."</p>";      else $reg_fixar_home    ="";
				if(isset($qtde_vendida ))              $reg_qtde_vendida  = "<p>Qtde Vendida:  ".$qtde_vendida."</p>";    else $reg_qtde_vendida  ="";
				if(isset($valor_vendido ))             $reg_valor_vendido = "<p>Valor Vendido:  ".$valor_vendido."</p>";  else $reg_valor_vendido ="";
				if(isset($categorias ))                $reg_categorias    = "<p>Categoria:  ".$categorias."</p>";         else $reg_categorias    ="";
				$registro  =$reg_id.$reg_sku.$reg_nome.$reg_titulo.$reg_valor.$reg_desconto.$reg_promocao.$reg_estoque.$reg_encomenda;
				$registro .=$reg_fixar_home.$reg_qtde_vendida.$reg_valor_vendido.$reg_status.$reg_relevancia.$reg_categorias.$reg_data.$reg_user;
				if ($updtdb ->countline==1):
					grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 	
				else:
					echo "<br>Erro ao gravar o registro de Produtos<br>";
					echo $registro;
				endif;
				// Final  - Rotina de gravar logs	
				//Rotina para atualizar Detalhes do Produto
				$updtdb = new detalhes_produtos(array(
					'sub_cat_1'  =>$sub_cat_1,
					'sub_cat_2'  =>$sub_cat_2,
					'sub_cat_3'  =>$sub_cat_3,
					'sub_cat_4'  =>$sub_cat_4,
					'sub_cat_5'  =>$sub_cat_5,
					'sub_cat_6'  =>$sub_cat_6,
					'sub_cat_7'  =>$sub_cat_7,
					'sub_cat_8'  =>$sub_cat_8,
					'sub_cat_9'  =>$sub_cat_9,
					'sub_cat_10' =>$sub_cat_10,
					'sub_cat_11' =>$sub_cat_11,
					'sub_cat_12' =>$sub_cat_12,
					'sub_cat_13' =>$sub_cat_13,
					'sub_cat_14' =>$sub_cat_14,
					'sub_cat_15' =>$sub_cat_15,
					'sub_cat_16' =>$sub_cat_16,
					'sub_cat_17' =>$sub_cat_17,
					'sub_cat_18' =>$sub_cat_18,
					'sub_cat_19' =>$sub_cat_19,
					'sub_cat_20' =>$sub_cat_20,
					'nome_1'     =>$nome_1,
					'nome_2'     =>$nome_2,
					'nome_3'     =>$nome_3,
					'nome_4'     =>$nome_4,
					'nome_5'     =>$nome_5,
					'nome_6'     =>$nome_6,
					'nome_7'     =>$nome_7,
					'nome_8'     =>$nome_8,
					'nome_9'     =>$nome_9,
					'nome_10'    =>$nome_10,
					'nome_11'    =>$nome_11,
					'nome_12'    =>$nome_12,
					'nome_13'    =>$nome_13,
					'nome_14'    =>$nome_14,
					'nome_15'    =>$nome_15,
					'nome_16'    =>$nome_16,
					'nome_17'    =>$nome_17,
					'nome_18'    =>$nome_18,
					'nome_19'    =>$nome_19,
					'nome_20'    =>$nome_20,
					'produtos_id'=>$resdb->prod_id,
					'data_cad'   =>$datacad,
					'user_id'    =>$userid,
				));

				$updtdb ->pk_value = $resdb->id;
				$updtdb ->updateDB($updtdb );
				
				// Início  - Rotina de gravar logs
				if(isset($resdb->id ))         $reg_id         = "<p>Reg no DB: ".$resdb->id."</p>";            else $reg_id         ="";
				if(isset($resdb->user_id ))    $reg_user       = "<p>User Resp: " .$resdb->user_id."</p>";      else $reg_user       ="";
				if(isset($resdb->data_cad ))   $reg_data       = "<p>Ult. Alteração: ".$resdb->data_cad."</p>"; else $reg_data       ="";
				if(isset($resdb->produtos_id)) $reg_produtos_id= "<p>Produto: ".$resdb->produtos_id."</p>";     else $reg_produtos_id ="";
				if(isset($resdb->sub_cat_1 ))  $reg_sub_cat_1  = "<p>Sub Cat 1:  ".$resdb->sub_cat_1."</p>";    else $reg_sub_cat_1  ="";
				if(isset($resdb->sub_cat_2 ))  $reg_sub_cat_2  = "<p>Sub Cat 2:  ".$resdb->sub_cat_2."</p>";    else $reg_sub_cat_2  ="";
				if(isset($resdb->sub_cat_3 ))  $reg_sub_cat_3  = "<p>Sub Cat 3:  ".$resdb->sub_cat_3."</p>";    else $reg_sub_cat_3  ="";
				if(isset($resdb->sub_cat_4 ))  $reg_sub_cat_4  = "<p>Sub Cat 4:  ".$resdb->sub_cat_4."</p>";    else $reg_sub_cat_4  ="";
				if(isset($resdb->sub_cat_5 ))  $reg_sub_cat_5  = "<p>Sub Cat 5:  ".$resdb->sub_cat_5."</p>";    else $reg_sub_cat_5  ="";
				if(isset($resdb->sub_cat_6 ))  $reg_sub_cat_6  = "<p>Sub Cat 6:  ".$resdb->sub_cat_6."</p>";    else $reg_sub_cat_6  ="";
				if(isset($resdb->sub_cat_7 ))  $reg_sub_cat_7  = "<p>Sub Cat 7:  ".$resdb->sub_cat_7."</p>";    else $reg_sub_cat_7  ="";
				if(isset($resdb->sub_cat_8 ))  $reg_sub_cat_8  = "<p>Sub Cat 8:  ".$resdb->sub_cat_8."</p>";    else $reg_sub_cat_8  ="";
				if(isset($resdb->sub_cat_9 ))  $reg_sub_cat_9  = "<p>Sub Cat 9:  ".$resdb->sub_cat_9."</p>";    else $reg_sub_cat_9  ="";
				if(isset($resdb->sub_cat_10))  $reg_sub_cat_10 = "<p>Sub Cat 10: ".$resdb->sub_cat_10."</p>";   else $reg_sub_cat_10 ="";
				if(isset($resdb->sub_cat_11))  $reg_sub_cat_11 = "<p>Sub Cat 11: ".$resdb->sub_cat_11."</p>";   else $reg_sub_cat_11 ="";
				if(isset($resdb->sub_cat_12))  $reg_sub_cat_12 = "<p>Sub Cat 12: ".$resdb->sub_cat_12."</p>";   else $reg_sub_cat_12 ="";
				if(isset($resdb->sub_cat_13))  $reg_sub_cat_13 = "<p>Sub Cat 13: ".$resdb->sub_cat_13."</p>";   else $reg_sub_cat_13 ="";
				if(isset($resdb->sub_cat_14))  $reg_sub_cat_14 = "<p>Sub Cat 14: ".$resdb->sub_cat_14."</p>";   else $reg_sub_cat_14 ="";
				if(isset($resdb->sub_cat_15))  $reg_sub_cat_15 = "<p>Sub Cat 15: ".$resdb->sub_cat_15."</p>";   else $reg_sub_cat_15 ="";
				if(isset($resdb->sub_cat_16))  $reg_sub_cat_16 = "<p>Sub Cat 16: ".$resdb->sub_cat_16."</p>";   else $reg_sub_cat_16 ="";
				if(isset($resdb->sub_cat_17))  $reg_sub_cat_17 = "<p>Sub Cat 17: ".$resdb->sub_cat_17."</p>";   else $reg_sub_cat_17 ="";
				if(isset($resdb->sub_cat_18))  $reg_sub_cat_18 = "<p>Sub Cat 18: ".$resdb->sub_cat_18."</p>";   else $reg_sub_cat_18 ="";
				if(isset($resdb->sub_cat_19))  $reg_sub_cat_19 = "<p>Sub Cat 19: ".$resdb->sub_cat_19."</p>";   else $reg_sub_cat_19 ="";
				if(isset($resdb->sub_cat_20))  $reg_sub_cat_20 = "<p>Sub Cat 20: ".$resdb->sub_cat_20."</p>";   else $reg_sub_cat_20 ="";
				if(isset($resdb->nome_1 ))     $reg_nome_1     = "<p>Detalhe 1:  ".$resdb->nome_1."</p>";       else $reg_nome_1     ="";
				if(isset($resdb->nome_2 ))     $reg_nome_2     = "<p>Detalhe 2:  ".$resdb->nome_2."</p>";       else $reg_nome_2     ="";	
				if(isset($resdb->nome_3 ))     $reg_nome_3     = "<p>Detalhe 3:  ".$resdb->nome_3."</p>";       else $reg_nome_3     ="";	
				if(isset($resdb->nome_4 ))     $reg_nome_4     = "<p>Detalhe 4:  ".$resdb->nome_4."</p>";       else $reg_nome_4     ="";	
				if(isset($resdb->nome_5 ))     $reg_nome_5     = "<p>Detalhe 5:  ".$resdb->nome_5."</p>";       else $reg_nome_5     ="";	
				if(isset($resdb->nome_6 ))     $reg_nome_6     = "<p>Detalhe 6:  ".$resdb->nome_6."</p>";       else $reg_nome_6     ="";	
				if(isset($resdb->nome_7 ))     $reg_nome_7     = "<p>Detalhe 7:  ".$resdb->nome_7."</p>";       else $reg_nome_7     ="";	
				if(isset($resdb->nome_8 ))     $reg_nome_8     = "<p>Detalhe 8:  ".$resdb->nome_8."</p>";       else $reg_nome_8     ="";	
				if(isset($resdb->nome_9 ))     $reg_nome_9     = "<p>Detalhe 9:  ".$resdb->nome_9."</p>";       else $reg_nome_9     ="";	
				if(isset($resdb->nome_10 ))    $reg_nome_10    = "<p>Detalhe 10: ".$resdb->nome_10."</p>";      else $reg_nome_10    ="";	
				if(isset($resdb->nome_11 ))    $reg_nome_11    = "<p>Detalhe 11: ".$resdb->nome_11."</p>";      else $reg_nome_11    ="";	
				if(isset($resdb->nome_12 ))    $reg_nome_12    = "<p>Detalhe 12: ".$resdb->nome_12."</p>";      else $reg_nome_12    ="";	
				if(isset($resdb->nome_13 ))    $reg_nome_13    = "<p>Detalhe 13: ".$resdb->nome_13."</p>";      else $reg_nome_13    ="";	
				if(isset($resdb->nome_14 ))    $reg_nome_14    = "<p>Detalhe 14: ".$resdb->nome_14."</p>";      else $reg_nome_14    ="";	
				if(isset($resdb->nome_15 ))    $reg_nome_15    = "<p>Detalhe 15: ".$resdb->nome_15."</p>";      else $reg_nome_15    ="";	
				if(isset($resdb->nome_16 ))    $reg_nome_16    = "<p>Detalhe 16: ".$resdb->nome_16."</p>";      else $reg_nome_16    ="";	
				if(isset($resdb->nome_17 ))    $reg_nome_17    = "<p>Detalhe 17: ".$resdb->nome_17."</p>";      else $reg_nome_17    ="";	
				if(isset($resdb->nome_18 ))    $reg_nome_18    = "<p>Detalhe 18: ".$resdb->nome_18."</p>";      else $reg_nome_18    ="";	
				if(isset($resdb->nome_19 ))    $reg_nome_19    = "<p>Detalhe 19: ".$resdb->nome_19."</p>";      else $reg_nome_19    ="";	
				if(isset($resdb->nome_20 ))    $reg_nome_20    = "<p>Detalhe 20: ".$resdb->nome_20."</p>";      else $reg_nome_20    ="";						
				$registro  =$reg_id.$reg_sub_cat_1.$reg_sub_cat_2.$reg_sub_cat_3.$reg_sub_cat_4.$reg_sub_cat_5.$reg_sub_cat_6;
				$registro .=$reg_sub_cat_7.$reg_sub_cat_8.$reg_sub_cat_9.$reg_sub_cat_10.$reg_sub_cat_11.$reg_sub_cat_12.$reg_sub_cat_13;
				$registro .=$reg_sub_cat_14.$reg_sub_cat_15.$reg_sub_cat_16.$reg_sub_cat_17.$reg_sub_cat_18.$reg_sub_cat_19.$reg_sub_cat_20;
				$registro .=$reg_nome_1.$reg_nome_2.$reg_nome_3.$reg_nome_4.$reg_nome_5.$reg_nome_6.$reg_nome_7.$reg_nome_8.$reg_nome_9.$reg_nome_10;
				$registro .=$reg_nome_11.$reg_nome_12.$reg_nome_13.$reg_nome_14.$reg_nome_15.$reg_nome_16.$reg_nome_17.$reg_nome_18.$reg_nome_19.$reg_nome_20;
				$registro .=$reg_status.$reg_produto_id.$reg_data.$reg_user;
				if ($updtdb ->countline==1):
					grava_log($userid,$user_ip,$rotina.'Alt-Det-Cat+Det-Prod',$acao,$registro,$datacad); 						
					echo '<script> location.href="?p=loja&m=produtos&s=listar" </script>';
										
					//$extra_msg = '<a href="'.ADMURL.'?p=loja&m=produtos&s=listar">Exibir Cadastros</a>';
					//getMSG('cb-911','sucesso',$extra_msg);
					//unset ($_POST['nome']);
				else:
					echo "<br>Erro ao gravar o registro de detalhes do Produto<br>";
					echo $registro;
					endif;
				//echo '<script> location.href="?m=paginas&s=listar" </script>';
				// Final  - Rotina de gravar logs	
			
			endif;
			?>
			<form  name=pagform method="post" action="">
				<fieldset>
					<legend>Personalização de Produtos</legend>
					<ul>
 						<div >	
							<li><label for="nome">Produto:
								<strong><?php echo $resdb->prod_nome;?></strong>
							</label></li>
							<?php
								$lerdb_cat = new categorias();
								$lerdb_cat->extra_select="where status = 1 ";	
								$lerdb_cat->selectAll($lerdb_cat);
								echo '<li><label for="categorias">Categoria do Produto: <strong>';
								while ($resdb_cat= $lerdb_cat->returnData()):
									if($resdb->prod_categorias_id == $resdb_cat->id) echo $resdb_cat->nome;
								endwhile;
								echo '</strong></label></li>';
							?>
							<li><label for="titulo">Descrição do Produto:
								<strong><?php echo $resdb->prod_titulo;?></strong>
							</label></li>
		            	</div>
 						<div >	
							<li><label for="valor">Valor do Produto(R$):
								<strong><?php echo $resdb->prod_valor;?></strong>
							</label></li>
		            	</div>
 						<div >	
							<li><label for="desconto">Porcentagem de Desconto a ser aplicado no Valor do Produto(%):
								<strong><?php echo $resdb->prod_desconto;?></strong>
							</label></li>
		            	</div>
						<div >	
							<li><label for="promocao">Valor Promocional do Produto(R$):
								<strong><?php echo $resdb->prod_promocao;?></strong>
							</label></li>
		            	</div>
						<div >	
							<li><label for="estoque">Estoque do Produto:
								<strong><?php echo $resdb->prod_estoque;?></strong>
							</label></li>
		            	</div>
						<div >
						<li>
							<label for="encomenda">Este produto aceitará encomendas quando o estoque for zero(0)?
								<?php if($resdb->prod_encomenda == 0) echo '<strong>Não';?> </strong>
								<?php if($resdb->prod_encomenda == 1) echo '<strong>Sim';?> </strong></label>
								<option <?php if($resdb->prod_encomenda == 1) echo 'selected="selected"';?> value=1>Sim</option>
							</br>
						    <label for="fixar_home">Este Produto deverá aparecer sempre na Página Home(Principal) do Site?
								<?php if($resdb->prod_fixar_home == 0) echo '<strong>Não';?> </strong>
								<?php if($resdb->prod_fixar_home == 1) echo '<strong>Sim';?> </strong></label>
						</li>
						</div>		            	
		            	<hr>
		            	</br>
		            	<?php
							echo '<label for="'.$resdb_scat->nome.'"><strong>Personalize as Opções abaixo : </strong></label>';		
						?>	
						</br>
						<div >
						<li>
						    <label for="status">Status:</label>
							<select name="status">
								<option value=0>Inativo</option>
								<option selected="selected" value=1>Ativo</option>
								<option value=2>Aguardando Aprovação</option>
								<option value=3>Pendente</option>
							</select> 
						 	<label for="relevancia">Relevancia:</label>
							<select name="relevancia">
								<option <?php if($resdb->prod_relevancia == 0) echo 'selected="selected"';?>  value=0>Baixa</option>
								<option <?php if($resdb->prod_relevancia == 1) echo 'selected="selected"';?> selected="selected" value=1>Normal</option>
								<option <?php if($resdb->prod_relevancia == 2) echo 'selected="selected"';?> value=2>Média</option>
								<option <?php if($resdb->prod_relevancia == 3) echo 'selected="selected"';?> value=3>Alta</option>
							</select>
						</li>
						</div>		
						<div>		
							<li>					
						<?php	
							//if (isset($_POST['editar'])):
							$n_nm = 21;
							$n_cats = 0;
								for ($i = 1; $i < $n_nm; $i++):
										$x_sc = "sub_cat_";
										$x_nm = "nome_";
										$x_nm =$x_nm . $i; 
										$x_sc =$x_sc . $i; 
										$$x_nm  = 0;
										if (! empty($resdb->$x_nm)):
										  $$x_nm  = $resdb->$x_nm;
										endif; 
										$$x_sc  = 0;
										if (! empty($resdb->$x_sc) != 0):
										  	$$x_sc  = $resdb->$x_sc;
											$lerdb_scat = new sub_cat();
											$lerdb_scat->extra_select="where status = 1 and id =".$$x_sc." LIMIT 1";	
											$lerdb_scat->selectAll($lerdb_scat);
											$resdb_scat= $lerdb_scat->returnData();
											echo '<input type="hidden" name="'.$x_sc.'" value="'.$resdb_scat->id.'" />';
											
											$lerdb_iscat = new item_sub_cat();
											$lerdb_iscat->extra_select="where status = 1 and sub_cat_id =".$$x_sc;	
											$lerdb_iscat->selectAll($lerdb_iscat);
											echo ' '.$resdb_scat->titulo.' ';
											echo '<select name="'.$x_nm.'">';
											while ($resdb_iscat= $lerdb_iscat->returnData()):
												if($$x_nm == $resdb_iscat->nome) $select_item = 'selected="selected"'; else $select_item = "";
												echo '	<option '.$select_item.' value="'.$resdb_iscat->nome.'">'.$resdb_iscat->nome.'</option>';
											endwhile;
											echo '</select>';
											

										endif; 
										//echo '<br> monta form --'.$x_sc.' : '.$$x_sc.' --- '.$x_nm. ': '.$$x_nm;
								endfor;		            	
		            		echo '</li>';
		            	?>
						
						</br>						
						<div >
							<li class="center"><input type="submit" name="editar" value="Salvar Dados" />
							    <input type="button" onclick="location.href='?p=loja&m=produtos&s=listar'" value="Cancelar" />
							</li>
						</div> 
					</ul>
				</fieldset>	
			</form>	

			</br>
		<?php
		else:
			printMSG('Você não tem permissão para efetuar alterações. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "p=loja&m=sub_categorias&s=listar";
			$extra_msg = '<a href="?p=loja&m=sub_categorias&s=listar" onclick="history.back()">Voltar</a>';
			getMSG('cb-909','alerta',$extra_msg);
		endif;
} // fecha função de personalizar produto
 * 
 */
?>