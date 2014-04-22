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
					echo "<script>alert('As definições Categoria do Produto foram alteradas. Os Produtos afetados nesta Alteração ficarão com o Status PENDENTE e Será necessário personalizar os Produtos novamente.');</script>";
					date_default_timezone_set('America/Sao_Paulo');
					$datacad   = date('Y-m-d H:i:s');
					$lerdb_cat = new categorias();
					$lerdb_cat->extra_select = "WHERE id=".$id." order by relevancia DESC, nome ASC LIMIT 1";
					$lerdb_cat->selectAll($lerdb_cat);
					$resdb_cat = $lerdb_cat->returnData();
					$n_cat = 21;
					$n_cats = 0;
					$a_cats = array();
					for ($i = 1; $i < $n_cat; $i++):
							$cat = "sub_cat_";
							$cat =$cat . $i;
							$nome = "nome_";
							$nome =$nome . $i;
							$$cat  = $resdb_cat->$cat; 
							if ($$cat > 0):
								$n_cats ++;
								$cats = "sub_cat_";
								$cats =$cats . $n_cats; 
								$$cats = $$cat ;
								$a_cats[] = $$cats;
								$nome = "nome_";
								$nome =$nome . $n_cats; 
								$$nome = "Selecionar";
								$a_cats[][] = $$nome;
								//echo "<br> ".$n_cats." - ". $cats." = ".$$cats;
							endif; 
							//echo "<br> ".$i." - ". $cat." = ".$$cat;
					endfor;
					echo "<pre>";
						print_r($a_cats);
					echo "</pre>";
					//exit;
					$lerdb_prod = new produtos_detalhes();
					$lerdb_prod->extra_select = "WHERE prod_categorias_id=".$id;
					$lerdb_prod->selectAll($lerdb_prod);
					$a_prod_det = array();
					$alt_prod_det= 0;
					while ($resdb_prod = $lerdb_prod->returnData()):
						$n_cat = 21;
						for ($i = 1; $i < $n_cat; $i++):
							$x_sc = "sub_cat_";
							$x_sc =$x_sc . $i;
							$x_sct= "sub_cat_temp_";
							$x_sct=$x_sct. $i;
							$x_nm = "nome_";
							$x_nm =$x_nm . $i; 
							$x_nmt = "nome_temp_";
							$x_nmt=$x_nmt . $i; 
							$$x_nm  = $resdb_prod->$x_nm;
							$$x_sc  = $resdb_prod->$x_sc;

							//echo '<br> ler Prod_det --'.$x_sc.' : '.$$x_sc.' --- '.$x_nm. ': '.$$x_nm;
							
							switch ($$x_sct) {
								case $subcat_1 : break;
								case $subcat_2 : break;
								case $subcat_3 : break;
								case $subcat_4 : break;
								case $subcat_5 : break;
								case $subcat_6 : break;
								case $subcat_7 : break;
								case $subcat_8 : break;
								case $subcat_9 : break;
								case $subcat_10 : break;
								case $subcat_11 : break;
								case $subcat_12 : break;
								case $subcat_13 : break;
								case $subcat_14 : break;
								case $subcat_15 : break;
								case $subcat_16 : break;
								case $subcat_17 : break;
								case $subcat_18 : break;
								case $subcat_19 : break;
								case $subcat_20 : break;
								default: 
									//echo "<br> valor da sub_cat: ".$$x_sc;
									if ($$x_sct != 0): $$x_sct = 0; $$x_nmt = $$x_nmt; $alt_prod_det ++; endif;	
									break;
							}
							$a_prod_det[] = $$x_sc;
							$a_prod_det[][] = $$x_nm;							
						//	echo '<br> Monta Prod_det --'.$x_sct.' : '.$$x_sct.' --- '.$x_nmt. ': '.$$x_nmt;
						endfor;
					echo "<pre>";
						print_r($a_prod_det);
					echo "</pre>";
					
					
					$key = array_search('green', $array); // $key = 2;
					
					
					exit;						
						
						for ($i = 1; $i <= $n_cats; $i++):
							$cats = "subcat_";
							$cats =$cats . $i; 
							$scatok = "sub_cat_";
							$scatok =$scatok. $i;
							//$$scatok= $$cats;
							$nomeok = "nome_";
							$nomeok =$nomeok. $i;
							
								$x_sc = "sub_cat_temp_"; 
								$x_sc =$x_sc . $i;
								$x_nm = "nome_temp_";
								$x_nm =$x_nm . $i;
								//echo "<br>".$x_sc;							
							
							$ok = 0;
							for ($n=1; $n <=20 ; $n++) {

								if ($ok  == 0 ){
									switch ($$cats) {
										case 1  : $$scatok = $$cats; $$nomeok = $$x_nm; $ok=1; 	break;
										case 2  : $$scatok = $$cats; $$nomeok = $$x_nm; $ok=1; 	break;
										case 3  : $$scatok = $$cats; $$nomeok = $$x_nm; $ok=1; 	break;
										case 4  : $$scatok = $$cats; $$nomeok = $$x_nm; $ok=1; 	break;
										case 5  : $$scatok = $$cats; $$nomeok = $$x_nm; $ok=1; 	break;
										case 6  : $$scatok = $$cats; $$nomeok = $$x_nm; $ok=1; 	break;
										case 7  : $$scatok = $$cats; $$nomeok = $$x_nm; $ok=1; 	break;
										case 8  : $$scatok = $$cats; $$nomeok = $$x_nm; $ok=1; 	break;
										case 9  : $$scatok = $$cats; $$nomeok = $$x_nm; $ok=1; 	break;
										case 10 : $$scatok = $$cats; $$nomeok = $$x_nm; $ok=1; 	break;
										case 11 : $$scatok = $$cats; $$nomeok = $$x_nm; $ok=1; 	break;
										case 12 : $$scatok = $$cats; $$nomeok = $$x_nm; $ok=1; 	break;
										case 13 : $$scatok = $$cats; $$nomeok = $$x_nm; $ok=1; 	break;
										case 14 : $$scatok = $$cats; $$nomeok = $$x_nm; $ok=1; 	break;
										case 15 : $$scatok = $$cats; $$nomeok = $$x_nm; $ok=1; 	break;
										case 16 : $$scatok = $$cats; $$nomeok = $$x_nm; $ok=1; 	break;
										case 17 : $$scatok = $$cats; $$nomeok = $$x_nm; $ok=1; 	break;
										case 18 : $$scatok = $$cats; $$nomeok = $$x_nm; $ok=1; 	break;
										case 19 : $$scatok = $$cats; $$nomeok = $$x_nm; $ok=1; 	break;
										case 20 : $$scatok = $$cats; $$nomeok = $$x_nm; $ok=1; 	break;
										
										default:  $$scatok = $$cats; $$nomeok = "Alterar";$ok=1;break;
									}
				//echo '<br> Prod_det ok  --'.$x_sc.' : '.$$x_sc.' --- '.$cats. ': '.$$cats. ' --- '. $nomeok.' : '.$$nomeok . " --- ". $x_nm. " --- ". $$x_nm;
								}
							}
						endfor;	
//exit;


											
						//echo "<br>Sub cats alteradas : ".$alt_prod_det;
						//if ($alt_prod_det >0):
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
								//echo '<br> Verifica Prod_det 1 --'.$x_sc.' : '.$$x_sc.' --- '.$x_nm. ': '.$$x_nm;
								if ($$x_sc  == 0):
									$$x_nm  = $$x_nm2;
									$$x_sc  = $$x_sc2;
									$$x_nm2  = 0;
									$$x_sc2  = 0;
									
								endif;
								//echo '<br> Verifica Prod_det 1 --'.$x_sc.' : '.$$x_sc.' --- '.$x_nm. ': '.$$x_nm;
								//echo '<br> Verifica Prod_det 2 --'.$x_sc2.' : '.$$x_sc2.' --- '.$x_nm2. ': '.$$x_nm2;
								
							endfor;
						//endif;
	//exit;							
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
						'produtos_id'=>$resdb_prod->produtos_id,
						'data_cad'   =>$datacad,
						'user_id'    =>$userid,
						));
	
						$updtdb ->pk_value = $resdb_prod->id;
						$updtdb ->updateDB($updtdb );
						
						$updtdb = new produtos(array(

						'status'     =>3,
						'data_cad'   =>$datacad,
						'user_id'    =>$userid,
						));
						$updtdb ->pk_value = $resdb_prod->produtos_id;
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
							echo 'Erro ao Alterar  Detalhes Produto:';
							echo $registro;
						endif;
					endwhile;
					if ($retorno == 'voltar'):
						return;
					else:
						echo '<script> location.href="?p=loja&m=categorias&s='.$retorno.'" </script>';
					endif;
				endif;
} // fecha função de alterar detalhes do produto	
?>