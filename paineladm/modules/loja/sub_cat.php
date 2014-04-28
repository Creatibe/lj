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
			if (!isset($_REQUEST['id']))	     $id              = "";     else $id             = $_REQUEST['id'];
			if (!isset($_REQUEST['nome']))  	 $nome            = "";     else $nome           = $_REQUEST['nome'];
			if (!isset($_REQUEST['depto']))      $depto_id        = "";     else $depto_id       = $_REQUEST['depto'];
			if (!isset($_REQUEST['categoria']))  $categorias_id   = "";     else $categorias_id  = $_REQUEST['categoria'];
			if (!isset($_REQUEST['filtro']))     $filtro          = "";     else $filtro         = $_REQUEST['filtro'];
			if (!isset($_REQUEST['menu']))  	 $menu            = "";     else $menu           = $_REQUEST['menu'];
			if (!isset($_REQUEST['status']))     $status          = "";     else $status         = $_REQUEST['status'];
			if (!isset($_REQUEST['relevancia'])) $relevancia      = "";     else $relevancia     = $_REQUEST['relevancia'];
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
				$gravadb_scat = new sub_cat(array(
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
					'depto_id'   =>$depto_id,
					'categorias_id' =>$categorias_id,
				));
				$gravadb_scat ->insertDB($gravadb_scat );
				if(isset($id ))            $reg_id            = "<p>Reg no DB: ".$id."</p>";                  else $reg_id            ="";
				if(isset($user_id ))       $reg_user          = "<p>User Resp: ".$user_id."</p>";             else $reg_user          ="";
				if(isset($datacad ))       $reg_data          = "<p>Cadastro: ".$datacad."</p>";              else $reg_data          ="";
				if(isset($status ))        $reg_status        = "<p>Status: ".$status."</p>";                 else $reg_status        ="";
				if(isset($relevancia ))    $reg_relevancia    = "<p>Relevancia: ".$relevancia."</p>";         else $reg_relevancia    ="";
				if(isset($nome ))          $reg_nome          = "<p>Sub-Categoria: ".$nome."</p>";            else $reg_nome          ="";
				if(isset($depto_id))       $reg_depto_id      = "<p>Depatramento: ".$depto_id."</p>";         else $reg_depto_id      ="";
				if(isset($categorias_id))  $reg_categorias_id = "<p>Categoria: ".$categorias_id."</p>";       else $reg_categorias_id ="";
				if(isset($filtro ))        $reg_filtro        = "<p>Filtro: ".$filtro."</p>";                 else $reg_filtro        ="";
				if(isset($menu ))          $reg_menu          = "<p>Menu: ".$menu."</p>";                     else $reg_menu          ="";
				if(isset($sub_cat_1 ))     $reg_sub_cat_1     = "<p>Sub Cat 1:  ".$sub_cat_1."</p>";          else $reg_sub_cat_1     ="";
				if(isset($sub_cat_2 ))     $reg_sub_cat_2     = "<p>Sub Cat 2:  ".$sub_cat_2."</p>";          else $reg_sub_cat_2     ="";
				if(isset($sub_cat_3 ))     $reg_sub_cat_3     = "<p>Sub Cat 3:  ".$sub_cat_3."</p>";          else $reg_sub_cat_3     ="";
				if(isset($sub_cat_4 ))     $reg_sub_cat_4     = "<p>Sub Cat 4:  ".$sub_cat_4."</p>";          else $reg_sub_cat_4     ="";
				if(isset($sub_cat_5 ))     $reg_sub_cat_5     = "<p>Sub Cat 5:  ".$sub_cat_5."</p>";          else $reg_sub_cat_5     ="";
				if(isset($sub_cat_6 ))     $reg_sub_cat_6     = "<p>Sub Cat 6:  ".$sub_cat_6."</p>";          else $reg_sub_cat_6     ="";
				if(isset($sub_cat_7 ))     $reg_sub_cat_7     = "<p>Sub Cat 7:  ".$sub_cat_7."</p>";          else $reg_sub_cat_7     ="";
				if(isset($sub_cat_8 ))     $reg_sub_cat_8     = "<p>Sub Cat 8:  ".$sub_cat_8."</p>";          else $reg_sub_cat_8     ="";
				if(isset($sub_cat_9 ))     $reg_sub_cat_9     = "<p>Sub Cat 9:  ".$sub_cat_9."</p>";          else $reg_sub_cat_9     ="";
				if(isset($sub_cat_10))     $reg_sub_cat_10    = "<p>Sub Cat 10: ".$sub_cat_10."</p>";         else $reg_sub_cat_10    ="";
				if(isset($sub_cat_11))     $reg_sub_cat_11    = "<p>Sub Cat 11: ".$sub_cat_11."</p>";         else $reg_sub_cat_11    ="";
				if(isset($sub_cat_12))     $reg_sub_cat_12    = "<p>Sub Cat 12: ".$sub_cat_12."</p>";         else $reg_sub_cat_12    ="";
				if(isset($sub_cat_13))     $reg_sub_cat_13    = "<p>Sub Cat 13: ".$sub_cat_13."</p>";         else $reg_sub_cat_13    ="";
				if(isset($sub_cat_14))     $reg_sub_cat_14    = "<p>Sub Cat 14: ".$sub_cat_14."</p>";         else $reg_sub_cat_14    ="";
				if(isset($sub_cat_15))     $reg_sub_cat_15    = "<p>Sub Cat 15: ".$sub_cat_15."</p>";         else $reg_sub_cat_15    ="";
				if(isset($sub_cat_16))     $reg_sub_cat_16    = "<p>Sub Cat 16: ".$sub_cat_16."</p>";         else $reg_sub_cat_16    ="";
				if(isset($sub_cat_17))     $reg_sub_cat_17    = "<p>Sub Cat 17: ".$sub_cat_17."</p>";         else $reg_sub_cat_17    ="";
				if(isset($sub_cat_18))     $reg_sub_cat_18    = "<p>Sub Cat 18: ".$sub_cat_18."</p>";         else $reg_sub_cat_18    ="";
				if(isset($sub_cat_19))     $reg_sub_cat_19    = "<p>Sub Cat 19: ".$sub_cat_19."</p>";         else $reg_sub_cat_19    ="";
				if(isset($sub_cat_20))     $reg_sub_cat_20    = "<p>Sub Cat 20: ".$sub_cat_20."</p>";         else $reg_sub_cat_20    ="";					
				$registro  =$reg_id.$reg_nome.$reg_depto_id.$reg_categorias_id.$reg_sub_cat_1.$reg_sub_cat_2.$reg_sub_cat_3.$reg_sub_cat_4.$reg_sub_cat_5.$reg_sub_cat_6;
				$registro .=$reg_sub_cat_7.$reg_sub_cat_8.$reg_sub_cat_9.$reg_sub_cat_10.$reg_sub_cat_11.$reg_sub_cat_12.$reg_sub_cat_13;
				$registro .=$reg_sub_cat_14.$reg_sub_cat_15.$reg_sub_cat_16.$reg_sub_cat_17.$reg_sub_cat_18.$reg_sub_cat_19.$reg_sub_cat_20;
				$registro .=$reg_status.$reg_relevancia.$reg_filtro.$reg_menu.$reg_data.$reg_user;				
				if ($gravadb_scat ->countline==1):
					// Início  - Rotina de gravar logs
					grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 	
					// Final  - Rotina de gravar logs	
					//DOM - início
					$cat = $nome;
					$dom 	= new DOMDocument('1.0','utf-8');
					$dom->formatOutput = true;
	
					$root 	= $dom->createElement($cat);
					$txt 	= $dom->createTextNode(' '); //necessário vazio para abrir e fechar o elemento criado corretamente
					$root->appendChild($txt);
					$dom->appendChild($root);
	
	
					$lerdb_caract = new caract();
					$lerdb_caract->extra_select="where status = 1 and categorias_id order by relevancia DESC, titulo ASC";	
					$lerdb_caract->selectAll($lerdb_caract);
					while ($resdb_caract= $lerdb_caract->returnData()):
						echo '<input type="checkbox" name="sub_cats[]" value="'.$resdb_caract->nome.'" />'.$resdb_caract->titulo.'&nbsp&nbsp';
						//echo '<input  type="hidden" name="sub_catsName[]" value="'.$resdb->nome.'" />';
					endwhile;	
	
	
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
	
	
	
					$subcat = $_POST['sub_catsName'];
	
					$rootSub 	= $dom->createElement('subcats');
	
					$i = 0;
					while ($i <= sizeof($subcat)-1) {
						$subcatItem 	= $dom->createElement('subcat');
						$subcatItemTxt 	= $dom->createTextNode($subcat[$i]);
		
						$subcatItem->appendChild($subcatItemTxt);
		
						$rootSub->appendChild($subcatItem);
						$i++;
						if ($i == sizeof($subcat)-1) {
							$root->appendChild($rootSub);
						}
					}
	
					$rootProduto 	= $dom->createElement('produtos');
					$txtProduto		= $dom->createTextNode(' ');
					$rootProduto->appendChild($txtProduto);
					$root->appendChild($rootProduto);
	
					$dom->save($cat.'.xml');
					//DOM - final
					echo '<script> location.href="?p=loja&m=sub_cat&s=listar&sc='.$nome.'&datacad='.$datacad.'" </script>';
				else:
					$extra_msg = $reg_nome;
					getMSG('cb-803','alerta',$extra_msg);					
				endif;
			endif;
?>
			<form  name=pagform method="post" action="">
				<fieldset>
					<legend>Cadastro de Sub-Categorias</legend>
					<p><h2>Cadastro de Sub-Categorias</h2></p>
					<ul>
 						<div >	
							<li><label for="nome">Sub-Categoria:</label>
								<input type="text" class="area_editavel_pagina" name="nome" id="nome" size="30" maxlength="30" autofocus
								 placeholder="Nome da Sub-Categoria - Tamanho max 30 caracteres" 
								size="30" title="Nome da Sub-Categoria - Tamanho max 30 caracteres"  required >
							</li>
		            	</div>
						<br>
							<?php
								$lerdb_depto = new depto();
								$lerdb_depto->extra_select="where status = 1";	
								$lerdb_depto->selectAll($lerdb_depto);
								echo '<li><label for="depto">Selecione o Departamento desta Sub-Categoria:</label>';
								echo '<select name="depto">';
								while ($resdb_depto= $lerdb_depto->returnData()):
									echo '	<option value='.$resdb_depto->id.'>'.$resdb_depto->nome.'</option>';
								endwhile;
								echo '</select>';
								echo '</li>';
							?>
						<br>
							<?php
								$lerdb_cat = new categorias();
								$lerdb_cat->extra_select="where status = 1";	
								$lerdb_cat->selectAll($lerdb_cat);
								echo '<li><label for="categoria">Selecione a Categoria desta Sub-Categoria:</label>';
								echo '<select name="categoria">';
								while ($resdb_cat= $lerdb_cat->returnData()):
									echo '	<option value='.$resdb_cat->id.'>'.$resdb_cat->nome.'</option>';
								endwhile;
								echo '</select>';
								echo '</li>';
							?>
						<br>						
 						<div >	
							<li><label for="sub_cats">Selecione de 1 a 20 Caracteristicas para esta Sub-Categoria:</label>
								<?php
								$lerdb_caract = new caract();
								$lerdb_caract->extra_select="where status = 1 order by relevancia DESC, titulo ASC";	
								$lerdb_caract->selectAll($lerdb_caract);
								while ($resdb_caract= $lerdb_caract->returnData()):
									echo '<input type="checkbox" name="sub_cats[]" value="'.$resdb_caract->nome.'" />'.$resdb_caract->titulo.'&nbsp&nbsp';
									//echo '<input  type="hidden" name="sub_catsName[]" value="'.$resdb->nome.'" />';
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
						<li><label for="menu">Esta Sub-Categoria fará parte do Menu do Site?</label>
							<select name="menu">
								<option selected="selected" value=0>Não</option>
								<option value=1>Sim</option>
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
							    <input type="button" onclick="location.href='?p=loja&m=sub_cat&s=listar'" value="Cancelar" />
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
		echo '<h2>Sub-Categorias Cadastradas</h2>';
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
					<th>Sub-Categoria</th><th>Depto</th><th>Categoria</th><th>Filtro</th><th>Menu</th><th>Sts</th><th>Relev</th><th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$lerdb_scat = new sub_cat();
				//$lerdb->extra_select="GROUP by titulo";	
				$lerdb_scat->selectAll($lerdb_scat);
				$nn=0;
				while ($resdb_scat= $lerdb_scat->returnData()):
					
					$lerdb_prod = new produtos();
					$lerdb_prod->extra_select="where sub_cat_id =".$resdb_scat->id." LIMIT 1";	// ver se tem  o id na tabela item_sub_cat campo sub_cat_id
					//$resdb_opc->selectAll($lerdb_opc);
					
					$reg_prod_scat = $lerdb_opc->countline;
					//$reg_opc_scat = 0;
					$nn++;echo "passou aqui - ".$nn;
					$lerdb_depto = new depto();
					$lerdb_depto->extra_select="where id ='".$resdb_scat->depto_id."' LIMIT 1";	// ver o departamento
					$lerdb_depto->selectAll($lerdb_depto);
					$resdb_depto = $lerdb_depto->returnData();
					$lerdb_cat = new categorias();
					$lerdb_cat->extra_select="where id ='".$resdb_scat->categorias_id."' LIMIT 1";	// ver o departamento
					$lerdb_cat->selectAll($lerdb_cat);
					$resdb_cat = $lerdb_cat->returnData();					
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
					printf('<td>%s</td>',$resdb_scat->nome);
					printf('<td>%s</td>',$resdb_depto->nome);
					printf('<td>%s</td>',$resdb_cat->nome);
					printf('<td>%s</td>',$filtro);
					printf('<td>%s</td>',$menu);
					printf('<td>%s</td>',$status);
					printf('<td>%s</td>',$relevancia) ;
					if ($resdb_scat->id != 0 and $reg_prod_sub_cat == 0):
						printf('<td class="center"><a href="?p=loja&m=sub_cat&s=editar&id=%s" title="Editar"><img src="'.BASEURL.'images/edit.png") 
							alt="Editar" /></a></a> <a href="?p=loja&m=sub_cat&s=excluir&id=%s" title="Excluir"><img src="'.BASEURL.'images/delete.png") 
							alt="Excluir" /></a> </td>',$resdb_scat->id,$resdb_scat->id,$resdb_scat->id);
					else:
						printf('<td class="center"><a href="?p=loja&m=sub_cat&s=editar&id=%s" title="Editar"><img src="'.BASEURL.'images/edit.png") 
							alt="Editar" /></a>
							<a title="Este item não pode ser excluído - Produtos, Personalizações ou Opções de Personalização associados.">
							<img src="'.BASEURL.'images/nao_delete.png") 	alt=" Não Deletar este item" /></a>
							</a>  </td>',$resdb_scat->id,$resdb_scat->id,$resdb_scat->id);
					endif;
					echo "</tr>";
				endwhile;
				?>
			</tbody>
		</table>
	<?php
	break;	
	case 'editar':
		echo "<h2>Alteração de Sub-Categorias</h2>";
		//$session = new session();
		if (isAdmin()== TRUE ):

			if (!isset($_REQUEST['id']))	     $id           = "";     else $id           = $_REQUEST['id'];
			if (!isset($_REQUEST['nome']))  	 $nome         = "";     else $nome         = $_REQUEST['nome'];
			if (!isset($_REQUEST['depto']))  	 $depto_id     = "";     else $depto_id     = $_REQUEST['depto'];
			if (!isset($_REQUEST['categoria']))  $categoria_id = "";     else $categoria_id = $_REQUEST['categoria'];	
			if (!isset($_REQUEST['menu']))  	 $menu         = "";     else $menu         = $_REQUEST['menu'];
			if (!isset($_REQUEST['filtro']))     $filtro       = "";     else $filtro       = $_REQUEST['filtro'];
			if (!isset($_REQUEST['status']))     $status       = "";     else $status       = $_REQUEST['status'];
			if (!isset($_REQUEST['relevancia'])) $relevancia   = "";     else $relevancia   = $_REQUEST['relevancia'];
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
			
			$lerdb_scat = new sub_cat();
			$lerdb_scat->extra_select = "WHERE id=$id Limit 1";
			$lerdb_scat->selectAll($lerdb_scat);
			$resdb_scat = $lerdb_scat->returnData();				
			$user_resp   = $userid;	
			date_default_timezone_set('America/Sao_Paulo');
			$datacad   = date('Y-m-d H:i:s');		
			if (isset($_POST['editar'])):
				$updtdb_scat = new sub_cat(array(
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
					'depto_id'   =>$depto_id,
					'categorias_id' =>$categoria_id,
				));
				$updtdb_scat ->pk_value = $id;
				$updtdb_scat ->updateDB($updtdb_scat );
				if(isset($resdb_scat->id ))         $reg_id           = "<p>Reg no DB: ".$resdb_scat->id."</p>";            else $reg_id           ="";
				if(isset($resdb_scat->user_id ))    $reg_user         = "<p>User Resp: " .$resdb_scat->user_id."</p>";      else $reg_user         ="";
				if(isset($resdb_scat->data_cad ))   $reg_data         = "<p>Ult. Alteração: ".$resdb_scat->data_cad."</p>"; else $reg_data         ="";
				if(isset($resdb_scat->status ))     $reg_status       = "<p>Status: "    .$resdb_scat->status."</p>";       else $reg_status       ="";
				if(isset($resdb_scat->relevancia )) $reg_relevancia   = "<p>Relevancia: ".$resdb_scat->relevancia."</p>";   else $reg_relevancia   ="";
				if(isset($resdb_scat->nome ))       $reg_nome         = "<p>Sub-Categoria: " .$resdb_scat->nome."</p>";     else $reg_nome         ="";
				if(isset($resdb_scat->depto_id ))   $reg_depto_id     = "<p>Departamento: " .$resdb_scat->depto_id."</p>";  else $reg_depto_id     ="";
				if(isset($resdb_scat->categoria_id))$reg_categoria_id = "<p>Categoria: " .$resdb_scat->categoria_id."</p>"; else $reg_categoria_id ="";
				if(isset($resdb_scat->filtro ))     $reg_filtro       = "<p>Filtro: "    .$resdb_scat->filtro."</p>";       else $reg_filtro       ="";
				if(isset($resdb_scat->menu ))       $reg_menu         = "<p>Menu: "      .$resdb_scat->menu."</p>";         else $reg_menu         ="";
				if(isset($resdb_scat->sub_cat_1 ))  $reg_sub_cat_1    = "<p>Sub Cat 1:  ".$resdb_scat->sub_cat_1."</p>";    else $reg_sub_cat_1    ="";
				if(isset($resdb_scat->sub_cat_2 ))  $reg_sub_cat_2    = "<p>Sub Cat 2:  ".$resdb_scat->sub_cat_2."</p>";    else $reg_sub_cat_2    ="";
				if(isset($resdb_scat->sub_cat_3 ))  $reg_sub_cat_3    = "<p>Sub Cat 3:  ".$resdb_scat->sub_cat_3."</p>";    else $reg_sub_cat_3    ="";
				if(isset($resdb_scat->sub_cat_4 ))  $reg_sub_cat_4    = "<p>Sub Cat 4:  ".$resdb_scat->sub_cat_4."</p>";    else $reg_sub_cat_4    ="";
				if(isset($resdb_scat->sub_cat_5 ))  $reg_sub_cat_5    = "<p>Sub Cat 5:  ".$resdb_scat->sub_cat_5."</p>";    else $reg_sub_cat_5    ="";
				if(isset($resdb_scat->sub_cat_6 ))  $reg_sub_cat_6    = "<p>Sub Cat 6:  ".$resdb_scat->sub_cat_6."</p>";    else $reg_sub_cat_6    ="";
				if(isset($resdb_scat->sub_cat_7 ))  $reg_sub_cat_7    = "<p>Sub Cat 7:  ".$resdb_scat->sub_cat_7."</p>";    else $reg_sub_cat_7    ="";
				if(isset($resdb_scat->sub_cat_8 ))  $reg_sub_cat_8    = "<p>Sub Cat 8:  ".$resdb_scat->sub_cat_8."</p>";    else $reg_sub_cat_8    ="";
				if(isset($resdb_scat->sub_cat_9 ))  $reg_sub_cat_9    = "<p>Sub Cat 9:  ".$resdb_scat->sub_cat_9."</p>";    else $reg_sub_cat_9    ="";
				if(isset($resdb_scat->sub_cat_10))  $reg_sub_cat_10   = "<p>Sub Cat 10: ".$resdb_scat->sub_cat_10."</p>";   else $reg_sub_cat_10   ="";
				if(isset($resdb_scat->sub_cat_11))  $reg_sub_cat_11   = "<p>Sub Cat 11: ".$resdb_scat->sub_cat_11."</p>";   else $reg_sub_cat_11   ="";
				if(isset($resdb_scat->sub_cat_12))  $reg_sub_cat_12   = "<p>Sub Cat 12: ".$resdb_scat->sub_cat_12."</p>";   else $reg_sub_cat_12   ="";
				if(isset($resdb_scat->sub_cat_13))  $reg_sub_cat_13   = "<p>Sub Cat 13: ".$resdb_scat->sub_cat_13."</p>";   else $reg_sub_cat_13   ="";
				if(isset($resdb_scat->sub_cat_14))  $reg_sub_cat_14   = "<p>Sub Cat 14: ".$resdb_scat->sub_cat_14."</p>";   else $reg_sub_cat_14   ="";
				if(isset($resdb_scat->sub_cat_15))  $reg_sub_cat_15   = "<p>Sub Cat 15: ".$resdb_scat->sub_cat_15."</p>";   else $reg_sub_cat_15   ="";
				if(isset($resdb_scat->sub_cat_16))  $reg_sub_cat_16   = "<p>Sub Cat 16: ".$resdb_scat->sub_cat_16."</p>";   else $reg_sub_cat_16   ="";
				if(isset($resdb_scat->sub_cat_17))  $reg_sub_cat_17   = "<p>Sub Cat 17: ".$resdb_scat->sub_cat_17."</p>";   else $reg_sub_cat_17   ="";
				if(isset($resdb_scat->sub_cat_18))  $reg_sub_cat_18   = "<p>Sub Cat 18: ".$resdb_scat->sub_cat_18."</p>";   else $reg_sub_cat_18   ="";
				if(isset($resdb_scat->sub_cat_19))  $reg_sub_cat_19   = "<p>Sub Cat 19: ".$resdb_scat->sub_cat_19."</p>";   else $reg_sub_cat_19   ="";
				if(isset($resdb_scat->sub_cat_20))  $reg_sub_cat_20   = "<p>Sub Cat 20: ".$resdb_scat->sub_cat_20."</p>";   else $reg_sub_cat_20   ="";					
				$registro  =$reg_id.$reg_nome.$reg_depto_id.$reg_categoria_id.$reg_sub_cat_1.$reg_sub_cat_2.$reg_sub_cat_3.$reg_sub_cat_4.$reg_sub_cat_5.$reg_sub_cat_6;
				$registro .=$reg_sub_cat_7.$reg_sub_cat_8.$reg_sub_cat_9.$reg_sub_cat_10.$reg_sub_cat_11.$reg_sub_cat_12.$reg_sub_cat_13;
				$registro .=$reg_sub_cat_14.$reg_sub_cat_15.$reg_sub_cat_16.$reg_sub_cat_17.$reg_sub_cat_18.$reg_sub_cat_19.$reg_sub_cat_20;
				$registro .=$reg_status.$reg_relevancia.$reg_filtro.$reg_menu.$reg_data.$reg_user;				
				if ($updtdb_scat ->countline==1):
					// Início  - Rotina de gravar logs

					grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 						
					// Final  - Rotina de gravar logs		
					alt_prod_detalhes($id,'listar',$userid,$user_ip,$userid,$user_ip,$acao,$rotina."-Alt_Cat+Prod_Detalhes");//chama rotina para alterar detalhes do produto			
				else:
					$extra_msg = $reg_nome;
					getMSG('cb-803','alerta',$extra_msg);
				endif;
			endif;
			?>
			<form class="pagform" method="post" action="">
				<fieldset>
					<legend>Alteração - Sub-Categorias</legend>
					<ul>
						<div >
							<li><label for="nome">Sub-Categoria:</label>
								<input type="text" name="nome" id="nome" size="30" maxlength="30" autofocus required
								placeholder="Nome da Sub-Categoria - Será apresentado no Site como filtro de pesquisa - Tamanho max 30 caracteres" 
							          title="Nome da Sub-Categoria - Será apresentado no Site como filtro de pesquisa - Tamanho max 30 caracteres" 
							 		  value="<?php echo $resdb_scat->nome;?>">   
						</div> 
						</br>
							<?php
								$lerdb_depto = new depto();
								$lerdb_depto->extra_select="where status = 1";	
								$lerdb_depto->selectAll($lerdb_depto);
								echo '<li><label for="depto">Departamento desta Sub-Categoria:</label>';
								echo '<select name="depto">';
								echo '	<option '.$select.' value=0> **Sem Departamento**</option>';
								while ($resdb_depto= $lerdb_depto->returnData()):
									if ($resdb_scat->depto_id == $resdb_depto->id) $select = 'selected="selected"'; else $select = '';
									echo '	<option '.$select.' value='.$resdb_depto->id.'>'.$resdb_depto->nome.'</option>';
								endwhile;
								echo '</select>';
								echo '</li>';
							?>
						<br>	
							<?php
								$lerdb_cat = new categorias();
								$lerdb_cat->extra_select="where status = 1";	
								$lerdb_cat->selectAll($lerdb_cat);
								echo '<li><label for="categoria">Categoria desta Sub-Categoria:</label>';
								echo '<select name="categoria">';
								echo '	<option '.$select.' value=0> **Sem Categoria**</option>';
								while ($resdb_cat= $lerdb_cat->returnData()):
									if ($resdb_scat->categorias_id == $resdb_cat->id) $select = 'selected="selected"'; else $select = '';
									echo '	<option '.$select.' value='.$resdb_cat->id.'>'.$resdb_cat->nome.'</option>';
								endwhile;
								echo '</select>';
								echo '</li>';
							?>
						<br>	
						<div >
							<li><label for="nome">Caracteristicas Disponíveis:</label>
							</br>
						<?php
							$n_sc = 20;
							$n_sc_ok = 0;
							for ($i = 0; $i < $n_sc; $i++):
								
								$x_sc = "sub_cat_";
								$x_sc =$x_sc . $i;
								$$x_sc  = $resdb_scat->$x_sc;
								if ($$x_sc != 0):
									$n_sc_ok ++;
								endif;
							endfor;
							$lerdb_caract = new caract();
							$lerdb_caract->extra_select="where status = 1 order by relevancia DESC, titulo ASC";
							$lerdb_caract->selectAll($lerdb_caract);
							$i = 0;
							while ($resdb_caract= $lerdb_caract->returnData()):	
								$i ++;
								$ix ++;
								switch ($resdb_scat->id) {
									case $sub_cat_1 : echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_caract->id.'" />'.$resdb_caract->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_2 : echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_caract->id.'" />'.$resdb_caract->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_3 : echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_caract->id.'" />'.$resdb_caract->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_4 : echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_caract->id.'" />'.$resdb_caract->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_5 : echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_caract->id.'" />'.$resdb_caract->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_6 : echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_caract->id.'" />'.$resdb_caract->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_7 : echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_caract->id.'" />'.$resdb_caract->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_8 : echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_caract->id.'" />'.$resdb_caract->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_9 : echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_caract->id.'" />'.$resdb_caract->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_10: echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_caract->id.'" />'.$resdb_caract->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_11: echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_caract->id.'" />'.$resdb_caract->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_12: echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_caract->id.'" />'.$resdb_caract->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_13: echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_caract->id.'" />'.$resdb_caract->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_14: echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_caract->id.'" />'.$resdb_caract->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_15: echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_caract->id.'" />'.$resdb_caract->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_16: echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_caract->id.'" />'.$resdb_caract->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_17: echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_caract->id.'" />'.$resdb_caract->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_18: echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_caract->id.'" />'.$resdb_caract->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_19: echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_caract->id.'" />'.$resdb_caract->titulo.'&nbsp&nbsp'; break;
									case $sub_cat_20: echo '<input type="checkbox" name="sub_cats[]" checked="checked" value="'.$resdb_caract->id.'" />'.$resdb_caract->titulo.'&nbsp&nbsp'; break;
									default:          echo '<input type="checkbox" name="sub_cats[]"                   value="'.$resdb_caract->id.'" />'.$resdb_caract->titulo.'&nbsp&nbsp'; break;
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
									<option <?php if($resdb_scat->filtro == 0) echo 'selected="selected"';?> value=0>Inativo</option>
									<option <?php if($resdb_scat->filtro == 1) echo 'selected="selected"';?> value=1>Ativo</option>
								</select>
								<label for="menu">Esta Categoria fará parte do Menu do Site:</label>
								<select name="menu">
									<option <?php if($resdb_scat->menu == 0) echo 'selected="selected"';?> value=0>Inativo</option>
									<option <?php if($resdb_scat->menu == 1) echo 'selected="selected"';?> value=1>Ativo</option>
								</select>								
								<label for="status">Status:</label>
								<select name="status">
									<option <?php if($resdb_scat->status == 0) echo 'selected="selected"';?> value=0>Inativo</option>
									<option <?php if($resdb_scat->status == 1) echo 'selected="selected"';?> value=1>Ativo</option>
									<option <?php if($resdb_scat->status == 2) echo 'selected="selected"';?> value=2>Aprovar</option>
									<option <?php if($resdb_scat->status == 3) echo 'selected="selected"';?> value=3>Pendente</option>
								</select>
							 	<label for="relevancia">Relevancia:</label>
								<select name="relevancia">
									<option <?php if($resdb_scat->relevancia == 0) echo 'selected="selected"';?> value=0>Baixa</option>
									<option <?php if($resdb_scat->relevancia == 1) echo 'selected="selected"';?> value=1>Normal</option>
									<option <?php if($resdb_scat->relevancia == 2) echo 'selected="selected"';?> value=2>Média</option>
									<option <?php if($resdb_scat->relevancia == 3) echo 'selected="selected"';?> value=3>Alta</option>
								</select>
							</li>	
						</div>
						</br>		
						<div >
							<li class="center">
							    <input type="submit" name="editar" value="Alterar Dados" />
				                <input type="button" onclick="location.href='?p=loja&m=sub_cat&s=listar'" value="Cancelar" />
							</li>	
						</div>
					</ul>
				</fieldset>
			</form>		
			</br>
			<div >
				<ul><label for="prod">Produtos Associados a esta Sub-Categoria:</label>
				<?php
					$lerdb_prod = new produtos();
					$lerdb_prod->extra_select="where sub_cat_id ='".$resdb->id."'";	// ver se tem  o id na tabela item_sub_cat campo sub_cat_id
					$lerdb_prod->selectAll($lerdb_prod);
					while ($resdb_prod= $lerdb_prod->returnData()):	
				
						echo '<input type="text" name="titulo" id="titulo" size="30" disabled="disabled"
						 value="'.$resdb_prod->nome.'">';   
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
		echo "<h2>Exclusão de Sub-Categorias</h2>";
		//$session = new session();
		if (isAdmin()== TRUE ):
			date_default_timezone_set('America/Sao_Paulo');
			$datacad   = date('Y-m-d H:i:s');
			if (isset($_GET['id'])):
				//faz edição do Páginas
				$id = $_GET['id'];
				$lerdb_scat = new sub_cat();
				$lerdb_scat->pk_value = $id;
				$lerdb_scat->extra_select = "WHERE id=$id";
				$lerdb_scat->selectAll($lerdb_scat);
				$resdb_scat = $lerdb_scat->returnData();	
				if (isset($_POST['exclusao'])):
					$deldb_scat = new sub_cat();
					$deldb_scat->pk_value = $id;
					$deldb_scat->deleteDB($deldb_scat);
					if(isset($resdb_scat->id ))            $reg_id            = "<p>Reg no DB: ".$resdb_scat->id."</p>";             else $reg_id           ="";
					if(isset($resdb_scat->user_id ))       $reg_user          = "<p>User Resp: " .$resdb_scat->user_id."</p>";       else $reg_user         ="";
					if(isset($resdb_scat->data_cad ))      $reg_data          = "<p>Ult. Alteração: ".$resdb_scat->data_cad."</p>";  else $reg_data         ="";
					if(isset($resdb_scat->status ))        $reg_status        = "<p>Status: "    .$resdb_scat->status."</p>";        else $reg_status       ="";
					if(isset($resdb_scat->relevancia ))    $reg_relevancia    = "<p>Relevancia: ".$resdb_scat->relevancia."</p>";    else $reg_relevancia   ="";
					if(isset($resdb_scat->nome ))          $reg_nome          = "<p>Nome Site: " .$resdb_scat->nome."</p>";          else $reg_nome         ="";
					if(isset($resdb_scat->depto_id ))      $reg_depto_id      = "<p>Departamento: " .$resdb_scat->depto_id."</p>";   else $reg_depto_id     ="";
					if(isset($resdb_scat->categorias_id )) $reg_categoria_id  = "<p>Categoria: " .$resdb_scat->categorias_id."</p>"; else $reg_categoria_id ="";
					if(isset($resdb_scat->filtro ))        $reg_filtro        = "<p>Filtro: "    .$resdb_scat->filtro."</p>";        else $reg_filtro       ="";
					if(isset($resdb_scat->menu ))          $reg_menu          = "<p>Menu: "      .$resdb_scat->menu."</p>";          else $reg_menu         ="";
					if(isset($resdb_scat->sub_cat_1 ))     $reg_sub_cat_1     = "<p>Sub Cat 1:  ".$resdb_scat->sub_cat_1."</p>";     else $reg_sub_cat_1    ="";
					if(isset($resdb_scat->sub_cat_2 ))     $reg_sub_cat_2     = "<p>Sub Cat 2:  ".$resdb_scat->sub_cat_2."</p>";     else $reg_sub_cat_2    ="";
					if(isset($resdb_scat->sub_cat_3 ))     $reg_sub_cat_3     = "<p>Sub Cat 3:  ".$resdb_scat->sub_cat_3."</p>";     else $reg_sub_cat_3    ="";
					if(isset($resdb_scat->sub_cat_4 ))     $reg_sub_cat_4     = "<p>Sub Cat 4:  ".$resdb_scat->sub_cat_4."</p>";     else $reg_sub_cat_4    ="";
					if(isset($resdb_scat->sub_cat_5 ))     $reg_sub_cat_5     = "<p>Sub Cat 5:  ".$resdb_scat->sub_cat_5."</p>";     else $reg_sub_cat_5    ="";
					if(isset($resdb_scat->sub_cat_6 ))     $reg_sub_cat_6     = "<p>Sub Cat 6:  ".$resdb_scat->sub_cat_6."</p>";     else $reg_sub_cat_6    ="";
					if(isset($resdb_scat->sub_cat_7 ))     $reg_sub_cat_7     = "<p>Sub Cat 7:  ".$resdb_scat->sub_cat_7."</p>";     else $reg_sub_cat_7    ="";
					if(isset($resdb_scat->sub_cat_8 ))     $reg_sub_cat_8     = "<p>Sub Cat 8:  ".$resdb_scat->sub_cat_8."</p>";     else $reg_sub_cat_8    ="";
					if(isset($resdb_scat->sub_cat_9 ))     $reg_sub_cat_9     = "<p>Sub Cat 9:  ".$resdb_scat->sub_cat_9."</p>";     else $reg_sub_cat_9    ="";
					if(isset($resdb_scat->sub_cat_10))     $reg_sub_cat_10    = "<p>Sub Cat 10: ".$resdb_scat->sub_cat_10."</p>";    else $reg_sub_cat_10   ="";
					if(isset($resdb_scat->sub_cat_11))     $reg_sub_cat_11    = "<p>Sub Cat 11: ".$resdb_scat->sub_cat_11."</p>";    else $reg_sub_cat_11   ="";
					if(isset($resdb_scat->sub_cat_12))     $reg_sub_cat_12    = "<p>Sub Cat 12: ".$resdb_scat->sub_cat_12."</p>";    else $reg_sub_cat_12   ="";
					if(isset($resdb_scat->sub_cat_13))     $reg_sub_cat_13    = "<p>Sub Cat 13: ".$resdb_scat->sub_cat_13."</p>";    else $reg_sub_cat_13   ="";
					if(isset($resdb_scat->sub_cat_14))     $reg_sub_cat_14    = "<p>Sub Cat 14: ".$resdb_scat->sub_cat_14."</p>";    else $reg_sub_cat_14   ="";
					if(isset($resdb_scat->sub_cat_15))     $reg_sub_cat_15    = "<p>Sub Cat 15: ".$resdb_scat->sub_cat_15."</p>";    else $reg_sub_cat_15   ="";
					if(isset($resdb_scat->sub_cat_16))     $reg_sub_cat_16    = "<p>Sub Cat 16: ".$resdb_scat->sub_cat_16."</p>";    else $reg_sub_cat_16   ="";
					if(isset($resdb_scat->sub_cat_17))     $reg_sub_cat_17    = "<p>Sub Cat 17: ".$resdb_scat->sub_cat_17."</p>";    else $reg_sub_cat_17   ="";
					if(isset($resdb_scat->sub_cat_18))     $reg_sub_cat_18    = "<p>Sub Cat 18: ".$resdb_scat->sub_cat_18."</p>";    else $reg_sub_cat_18   ="";
					if(isset($resdb_scat->sub_cat_19))     $reg_sub_cat_19    = "<p>Sub Cat 19: ".$resdb_scat->sub_cat_19."</p>";    else $reg_sub_cat_19   ="";
					if(isset($resdb_scat->sub_cat_20))     $reg_sub_cat_20    = "<p>Sub Cat 20: ".$resdb_scat->sub_cat_20."</p>";    else $reg_sub_cat_20   ="";					
					$registro  =$reg_id.$reg_nome.$reg_depto_id.$reg_categoria_id.$reg_sub_cat_1.$reg_sub_cat_2.$reg_sub_cat_3.$reg_sub_cat_4.$reg_sub_cat_5.$reg_sub_cat_6;
					$registro .=$reg_sub_cat_7.$reg_sub_cat_8.$reg_sub_cat_9.$reg_sub_cat_10.$reg_sub_cat_11.$reg_sub_cat_12.$reg_sub_cat_13;
					$registro .=$reg_sub_cat_14.$reg_sub_cat_15.$reg_sub_cat_16.$reg_sub_cat_17.$reg_sub_cat_18.$reg_sub_cat_19.$reg_sub_cat_20;
					$registro .=$reg_status.$reg_relevancia.$reg_filtro.$reg_menu.$reg_data.$reg_user;					
					if ($deldb_scat->countline==1):
					// Início  - Rotina de gravar logs
						grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 						
						echo '<script> location.href="?p=loja&m=sub_cat&s=listar" </script>';
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
					<legend>Exclusão - Sub-Categorias</legend>
					<ul>
						<li><label for="nome">Sub-Categoria:</label>
						<?php echo $resdb_scat->nome;?>  			

						<li class="center">
						   	<input type="submit" name="exclusao" value="Confirma Exclusão" />
							<input type="button" onclick="location.href='?p=loja&m=sub_categorias&s=listar'" value="Cancelar" />
		               </li>	
					</ul>
				</fieldset>
			</form>	
			</br>
			<div >
				<ul><label for="Itens">Caracteristicas associadas a esta Sub-Categoria:</label>
				<?php
					$lerdb_scat = new caract();
					$lerdb_scat->extra_select="where id =".$resdb_scat->id;	// ver se tem  o id na tabela cat_subcat campo cat_id
					$lerdb_scat->selectAll($lerdb_scat);
					while ($resdb_scat= $lerdb_scat->returnData()):	
				
						echo '<input type="text" name="titulo" id="titulo" size="30" disabled="disabled"
						 value="'.$resdb_scat->nome.'">';   
				 	endwhile;
				?>	  
				</ul>	
			</div> 	
			<div >
				<ul><label for="Itens">Produtos associados a esta Sub-Categoria:</label>
				<?php
					$lerdb_prod = new produtos();
					$lerdb_prod->extra_select="where id =".$resdb_scat->id;	// ver se tem  o id na tabela cat_subcat campo cat_id
					$lerdb_prod->selectAll($lerdb_prod);
					while ($resdb_prod= $lerdb_prod->returnData()):	
				
						echo '<input type="text" name="titulo" id="titulo" size="30" disabled="disabled"
						 value="'.$resdb_prod->nome.'">';   
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
// Função para atualizar todos os produtos da Categoria que foi modificada
	function alt_prod_detalhes($id=null,$retorno=null,$userid=null,$user_ip=null,$acao=null,$rotina=null)
{
					return;
				if (isset($id) != null):
					echo "<script>alert('As definições Categoria do Produto foram alteradas. Os Produtos afetados nesta Alteração ficarão com o Status PENDENTE e Será necessário personalizar os Produtos novamente.');</script>";
					date_default_timezone_set('America/Sao_Paulo');
					$datacad   = date('Y-m-d H:i:s');
					$lerdb_scat = new sub_cat();
					$lerdb_scat->extra_select = "WHERE id=".$id." order by relevancia DESC, nome ASC LIMIT 1";
					$lerdb_scat->selectAll($lerdb_scat);
					$resdb_scat = $lerdb_scat->returnData();
					$n_cat = 21;
					$n_cats = 0;
					$a_cats = array();
					for ($i = 1; $i < $n_cat; $i++):
							$cat = "sub_cat_";
							$cat =$cat . $i;
							$nome = "nome_";
							$nome =$nome . $i;
							$$cat  = $resdb_scat->$cat; 
							if ($$cat > 0):
								$n_cats ++;
								$cats = "sub_cat";
								$cats =$cats . $n_cats; 
								$$cats = $$cat ;
							endif; 
					endfor;
					$lerdb_prod = new produtos_detalhes();
					$lerdb_prod->extra_select = "WHERE prod_sub_cat_id=".$id;
					$lerdb_prod->selectAll($lerdb_prod);
					$a_prod_det = array();
					while ($resdb_prod = $lerdb_prod->returnData()):
						$n_cat = 21;
						for ($i = 1; $i < $n_cat; $i++):
							$x_sc = "sub_cat_";
							$x_sc =$x_sc . $i;
							$x_nm = "nome_";
							$x_nm =$x_nm . $i; 
							$t_sc = "subcat";
							$t_sc =$t_sc . $i;
							$t_nm = "nome";
							$t_nm =$t_nm . $i;
							$$t_nm  = $resdb_prod->$x_nm;
							$$t_sc  = $resdb_prod->$x_sc;
							switch ($$t_sc) {
								case $sub_cat_1  : break;
								case $sub_cat_2  : break;
								case $sub_cat_3  : break;
								case $sub_cat_4  : break;
								case $sub_cat_5  : break;
								case $sub_cat_6  : break;
								case $sub_cat_7  : break;
								case $sub_cat_8  : break;
								case $sub_cat_9  : break;
								case $sub_cat_10 : break;
								case $sub_cat_11 : break;
								case $sub_cat_12 : break;
								case $sub_cat_13 : break;
								case $sub_cat_14 : break;
								case $sub_cat_15 : break;
								case $sub_cat_16 : break;
								case $sub_cat_17 : break;
								case $sub_cat_18 : break;
								case $sub_cat_19 : break;
								case $sub_cat_20 : break;
								default: 
									if ($$t_sc != 0): $$t_sc = 0; $$t_nm = ""; endif;	
									break;
							}
							$a_prod_det[] = $$t_sc;
							$a_prod_det[] = $$t_nm;	
						endfor;
						for ($i = 1; $i <= $n_cat; $i++):
								$cats = "sub_cat_";
								$cats =$cats . $i; 
								$nome = "nome_";
								$nome =$nome . $i; 
								$key = array_search($$cats, $a_prod_det); 
								if ($key !== false):
									$$cats = $a_prod_det[$key];
									$$nome = $a_prod_det[$key+1];
								else:
									$$cats = $$cats;
									$$nome = "";
								endif;
						endfor;
						$updtdb_prod_det = new produtos_detalhes(array(
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
	
						$updtdb_prod_det ->pk_value = $updtdb_prod_det->id;
						$updtdb_prod_det ->updateDB($updtdb_prod_det );
						$lerdb_prod = new produtos_detalhes();
						$lerdb_prod->extra_select = "WHERE prod_sub_cat_id=".$id. "LIMIT 1";
						$lerdb_prod->selectAll($lerdb_prod);
						$resdb_prod = $lerdb_prod->returnData();
						if(isset($resdb_prod->id ))         $reg_id         = "<p>Reg no DB: ".$resdb_prod->id."</p>";            else $reg_id         ="";
						if(isset($resdb_prod->user_id ))    $reg_user       = "<p>User Resp: " .$resdb_prod->user_id."</p>";      else $reg_user       ="";
						if(isset($resdb_prod->data_cad ))   $reg_data       = "<p>Ult. Alteração: ".$resdb_prod->data_cad."</p>"; else $reg_data       ="";
						if(isset($resdb_prod->produtos_id)) $reg_produtos_id= "<p>Produto: ".$resdb_prod->produtos_id."</p>";     else $reg_produtos_id ="";
						if(isset($resdb_prod->sub_cat_1 ))  $reg_sub_cat_1  = "<p>Sub Cat 1:  ".$resdb_prod->sub_cat_1."</p>";    else $reg_sub_cat_1  ="";
						if(isset($resdb_prod->sub_cat_2 ))  $reg_sub_cat_2  = "<p>Sub Cat 2:  ".$resdb_prod->sub_cat_2."</p>";    else $reg_sub_cat_2  ="";
						if(isset($resdb_prod->sub_cat_3 ))  $reg_sub_cat_3  = "<p>Sub Cat 3:  ".$resdb_prod->sub_cat_3."</p>";    else $reg_sub_cat_3  ="";
						if(isset($resdb_prod->sub_cat_4 ))  $reg_sub_cat_4  = "<p>Sub Cat 4:  ".$resdb_prod->sub_cat_4."</p>";    else $reg_sub_cat_4  ="";
						if(isset($resdb_prod->sub_cat_5 ))  $reg_sub_cat_5  = "<p>Sub Cat 5:  ".$resdb_prod->sub_cat_5."</p>";    else $reg_sub_cat_5  ="";
						if(isset($resdb_prod->sub_cat_6 ))  $reg_sub_cat_6  = "<p>Sub Cat 6:  ".$resdb_prod->sub_cat_6."</p>";    else $reg_sub_cat_6  ="";
						if(isset($resdb_prod->sub_cat_7 ))  $reg_sub_cat_7  = "<p>Sub Cat 7:  ".$resdb_prod->sub_cat_7."</p>";    else $reg_sub_cat_7  ="";
						if(isset($resdb_prod->sub_cat_8 ))  $reg_sub_cat_8  = "<p>Sub Cat 8:  ".$resdb_prod->sub_cat_8."</p>";    else $reg_sub_cat_8  ="";
						if(isset($resdb_prod->sub_cat_9 ))  $reg_sub_cat_9  = "<p>Sub Cat 9:  ".$resdb_prod->sub_cat_9."</p>";    else $reg_sub_cat_9  ="";
						if(isset($resdb_prod->sub_cat_10))  $reg_sub_cat_10 = "<p>Sub Cat 10: ".$resdb_prod->sub_cat_10."</p>";   else $reg_sub_cat_10 ="";
						if(isset($resdb_prod->sub_cat_11))  $reg_sub_cat_11 = "<p>Sub Cat 11: ".$resdb_prod->sub_cat_11."</p>";   else $reg_sub_cat_11 ="";
						if(isset($resdb_prod->sub_cat_12))  $reg_sub_cat_12 = "<p>Sub Cat 12: ".$resdb_prod->sub_cat_12."</p>";   else $reg_sub_cat_12 ="";
						if(isset($resdb_prod->sub_cat_13))  $reg_sub_cat_13 = "<p>Sub Cat 13: ".$resdb_prod->sub_cat_13."</p>";   else $reg_sub_cat_13 ="";
						if(isset($resdb_prod->sub_cat_14))  $reg_sub_cat_14 = "<p>Sub Cat 14: ".$resdb_prod->sub_cat_14."</p>";   else $reg_sub_cat_14 ="";
						if(isset($resdb_prod->sub_cat_15))  $reg_sub_cat_15 = "<p>Sub Cat 15: ".$resdb_prod->sub_cat_15."</p>";   else $reg_sub_cat_15 ="";
						if(isset($resdb_prod->sub_cat_16))  $reg_sub_cat_16 = "<p>Sub Cat 16: ".$resdb_prod->sub_cat_16."</p>";   else $reg_sub_cat_16 ="";
						if(isset($resdb_prod->sub_cat_17))  $reg_sub_cat_17 = "<p>Sub Cat 17: ".$resdb_prod->sub_cat_17."</p>";   else $reg_sub_cat_17 ="";
						if(isset($resdb_prod->sub_cat_18))  $reg_sub_cat_18 = "<p>Sub Cat 18: ".$resdb_prod->sub_cat_18."</p>";   else $reg_sub_cat_18 ="";
						if(isset($resdb_prod->sub_cat_19))  $reg_sub_cat_19 = "<p>Sub Cat 19: ".$resdb_prod->sub_cat_19."</p>";   else $reg_sub_cat_19 ="";
						if(isset($resdb_prod->sub_cat_20))  $reg_sub_cat_20 = "<p>Sub Cat 20: ".$resdb_prod->sub_cat_20."</p>";   else $reg_sub_cat_20 ="";
						if(isset($resdb_prod->nome_1 ))     $reg_nome_1     = "<p>Detalhe 1:  ".$resdb_prod->nome_1."</p>";       else $reg_nome_1     ="";
						if(isset($resdb_prod->nome_2 ))     $reg_nome_2     = "<p>Detalhe 2:  ".$resdb_prod->nome_2."</p>";       else $reg_nome_2     ="";	
						if(isset($resdb_prod->nome_3 ))     $reg_nome_3     = "<p>Detalhe 3:  ".$resdb_prod->nome_3."</p>";       else $reg_nome_3     ="";	
						if(isset($resdb_prod->nome_4 ))     $reg_nome_4     = "<p>Detalhe 4:  ".$resdb_prod->nome_4."</p>";       else $reg_nome_4     ="";	
						if(isset($resdb_prod->nome_5 ))     $reg_nome_5     = "<p>Detalhe 5:  ".$resdb_prod->nome_5."</p>";       else $reg_nome_5     ="";	
						if(isset($resdb_prod->nome_6 ))     $reg_nome_6     = "<p>Detalhe 6:  ".$resdb_prod->nome_6."</p>";       else $reg_nome_6     ="";	
						if(isset($resdb_prod->nome_7 ))     $reg_nome_7     = "<p>Detalhe 7:  ".$resdb_prod->nome_7."</p>";       else $reg_nome_7     ="";	
						if(isset($resdb_prod->nome_8 ))     $reg_nome_8     = "<p>Detalhe 8:  ".$resdb_prod->nome_8."</p>";       else $reg_nome_8     ="";	
						if(isset($resdb_prod->nome_9 ))     $reg_nome_9     = "<p>Detalhe 9:  ".$resdb_prod->nome_9."</p>";       else $reg_nome_9     ="";	
						if(isset($resdb_prod->nome_10 ))    $reg_nome_10    = "<p>Detalhe 10: ".$resdb_prod->nome_10."</p>";      else $reg_nome_10    ="";	
						if(isset($resdb_prod->nome_11 ))    $reg_nome_11    = "<p>Detalhe 11: ".$resdb_prod->nome_11."</p>";      else $reg_nome_11    ="";	
						if(isset($resdb_prod->nome_12 ))    $reg_nome_12    = "<p>Detalhe 12: ".$resdb_prod->nome_12."</p>";      else $reg_nome_12    ="";	
						if(isset($resdb_prod->nome_13 ))    $reg_nome_13    = "<p>Detalhe 13: ".$resdb_prod->nome_13."</p>";      else $reg_nome_13    ="";	
						if(isset($resdb_prod->nome_14 ))    $reg_nome_14    = "<p>Detalhe 14: ".$resdb_prod->nome_14."</p>";      else $reg_nome_14    ="";	
						if(isset($resdb_prod->nome_15 ))    $reg_nome_15    = "<p>Detalhe 15: ".$resdb_prod->nome_15."</p>";      else $reg_nome_15    ="";	
						if(isset($resdb_prod->nome_16 ))    $reg_nome_16    = "<p>Detalhe 16: ".$resdb_prod->nome_16."</p>";      else $reg_nome_16    ="";	
						if(isset($resdb_prod->nome_17 ))    $reg_nome_17    = "<p>Detalhe 17: ".$resdb_prod->nome_17."</p>";      else $reg_nome_17    ="";	
						if(isset($resdb_prod->nome_18 ))    $reg_nome_18    = "<p>Detalhe 18: ".$resdb_prod->nome_18."</p>";      else $reg_nome_18    ="";	
						if(isset($resdb_prod->nome_19 ))    $reg_nome_19    = "<p>Detalhe 19: ".$resdb_prod->nome_19."</p>";      else $reg_nome_19    ="";	
						if(isset($resdb_prod->nome_20 ))    $reg_nome_20    = "<p>Detalhe 20: ".$resdb_prod->nome_20."</p>";      else $reg_nome_20    ="";						
						$registro  =$reg_id.$reg_sub_cat_1.$reg_sub_cat_2.$reg_sub_cat_3.$reg_sub_cat_4.$reg_sub_cat_5.$reg_sub_cat_6;
						$registro .=$reg_sub_cat_7.$reg_sub_cat_8.$reg_sub_cat_9.$reg_sub_cat_10.$reg_sub_cat_11.$reg_sub_cat_12.$reg_sub_cat_13;
						$registro .=$reg_sub_cat_14.$reg_sub_cat_15.$reg_sub_cat_16.$reg_sub_cat_17.$reg_sub_cat_18.$reg_sub_cat_19.$reg_sub_cat_20;
						$registro .=$reg_nome_1.$reg_nome_2.$reg_nome_3.$reg_nome_4.$reg_nome_5.$reg_nome_6.$reg_nome_7.$reg_nome_8.$reg_nome_9.$reg_nome_10;
						$registro .=$reg_nome_11.$reg_nome_12.$reg_nome_13.$reg_nome_14.$reg_nome_15.$reg_nome_16.$reg_nome_17.$reg_nome_18.$reg_nome_19.$reg_nome_20;
						$registro .=$reg_status.$reg_produto_id.$reg_data.$reg_user;
						if ($updtdb_prod_det->countline==1):
						// Início  - Rotina de gravar logs
								grava_log($userid,$user_ip,$rotina.'alt-detalhes-cat',$acao,$registro,$datacad); 
						else:
							$extra_msg = 'alt-detalhes-cat - '.$reg_id;
							getMSG('cb-803','alerta',$extra_msg);
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