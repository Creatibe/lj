<script type="text/javascript" src="http://localhost/creatibe/paineladm/ckeditor/ckeditor.js"></script>
		<style>
		/* Style the CKEditor element to look like a textfield */
		.cke_textarea_inline
		{
			padding: 10px;
			height: 50px;
			max-width: 300px;
			overflow: auto;
			border: 1px solid gray;
			-webkit-appearance: textfield;
		}
		</style>
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
	case 'incluir':
		if (isAdmin()== TRUE ):
			if (!isset($_REQUEST['id']))	$id = ""; else $id = $_REQUEST['id'];
			if (!isset($_POST['status']))$status = ""; else $status = $_POST['status'];
			if (!isset($_POST['relevancia']))$relevancia = ""; else $relevancia = $_POST['relevancia'];
			if (!isset($_POST['menunome']))	$menunome = ""; else $menunome = $_POST['menunome'];
			if (!isset($_POST['menulabel']))	$menulabel = ""; else $menulabel = $_POST['menulabel'];
			if (!isset($_POST['menulink']))$menulink = "#"; else $menulink = $_POST['menulink'];
			if (!isset($_POST['menuimagem'])):
				$menuimagem = ""; 
			else: 
				$menuimagem = '<img alt="Creatibe - Main Menu" src="'.$_POST["menuimagem"].'"/>';
			endif;
			//echo "<br> o Valor de imagem é : ".$imagem;
			$user_resp   = $userid;	
			date_default_timezone_set('America/Sao_Paulo');
			$datacad   = date('Y-m-d H:i:s');			
			if (isset($_POST['cadastrar'])):
				$mainmenu = new mainmenu(array(
					'status'    =>$status,
					'relevancia'=>$relevancia,
					'menunome'  =>$menunome,
					'menulabel' =>$menulabel,
					'menulink'  => $menulink,
					'datacad'   =>$datacad,
					'user_resp' =>$userid,
				));
				//$mainmenu->pk_value = $id;
				$mainmenu->insertDB($mainmenu);
				//final rotina para criar a pagina do Main Menu incluso
				if ($mainmenu->countline==1):
					$extra_msg = '<a href="'.ADMURL.'?m=mainmenu&s=listar">Exibir Cadastros</a>';
					getMSG('cb-911','sucesso',$extra_msg);
					unset ($_POST['status']);
					unset ($_POST['relevancia']);
					unset ($_POST['menunome']);
					unset ($_POST['menulabel']);
					unset ($_POST['menulink']);
					unset ($_POST['menuimagem']);
				endif;
			endif;
			?>
	        <script type="text/javascript">
				$(document).ready(function(){
					$(".mmenuform").validate({
						rules:{
							menunome:{required:true, minlength:3},
							menulabel:{required:true, minlength:3},
							status:{required:true, minlength:1},
							relevancia:{required:true, minlength:1},
							}
						});
					});
			</script>	
			<form class="mmenuform" name=mmenuform method="post" action="">
				<fieldset>
					<legend>Cadastro - Main Menu</legend>
					<ul>
<!-- abre  - menulabel -->						
						<div >
							<li><label for="menunome">Rotina:</label>
								<input type="text" class="area_editavel_titulo" name="menunome" size="50" ><?php echo $menunome;?> 
							</li>
						</div>
<!-- fecha  - menulabel -->
<!-- abre  - menulabel -->						
						<div >
							<li><label for="menulabel">Título:</label>
								<input type="text" class="area_editavel_titulo" name="menulabel" size="50" ><?php echo $menulabel;?> 
							</li>
						</div>
<!-- fecha  - menulabel -->
<!-- abre   - menulink -->
						<div >
							<li><label for="menulink">Link:</label>
								<input type="text" class="area_editavel_titulo" name="menulink" size="50" value="<?php echo $menulink;?>">
							</li>
						</div> 
<!-- fecha  - menulink -->
<!-- abre   - status -->	
						<br>
						<div >
						<li><label for="status">Status:</label>
							<select name="status">
								<option selected="selected" value=0>Inativo</option>
								<option value=1>Ativo</option>
								<option value=2>Aguardando Aprovação</option>
								<option value=3>Pendente</option>
							</select>

						</li>
						</div>
<!-- fecha  - status -->
<!-- abre   - relevancia / ordem -->
						<div >
							<li><label for="relevancia">Ordem:</label>
								<input type="text" class="area_editavel_titulo" name="relevancia" size="50" ><?php echo $relevancia;?> 
							</li>
						</div> 
<!-- fecha  - relevancia / ordem -->
<!-- 
<!-- abre   - end -->							
						<br>	
							
						
						<div >
						<li class="center"><input type="submit" name="cadastrar" value="Salvar Dados" />
						    <input type="button" onclick="location.href='?m=mainmenu&s=listar'" value="Cancelar" />
						</li>
						</div> 
					</ul>
				</fieldset>	
			</form>	
			<?php
		else:
			//printMSG('Você não tem permissão para efetuar alterações neste usuário. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "m=mainmenu&s=listar";
			$extra_msg = '<a href="?m=mainmenu&s=listar" onclick="history.back()">Voltar</a>';
			getMSG('cb-909','alerta',$extra_msg);
		endif;		
	break;
	case 'listar':
		echo '<h2>Main Menu - Cadastrados</h2>';
		loadCSS("data-table","screen",TRUE);
		loadJS("jquery-datatable");
		?>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#listamainmenu").dataTable({
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
					"aaSorting": [[ 3, "asc" ]]
				});
			});
		</script>
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="listamainmenu">
			<thead>
				<tr>
					<th>Rotina</th><th>Título</th><th>Link</th><th>Status</th><th>Ordem</th><th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$mainmenu = new mainmenu();
				//$mainmenu->extra_select="where status = 1  ";	
				//$mainmenu->extra_select=" order by relevancia DESC";	
				$mainmenu->selectAll($mainmenu);
				while ($res = $mainmenu->returnData()):
					if     ($res->status == 0) $status = "Inativo"; 
					elseif ($res->status == 1) $status = "Ativo";
					elseif ($res->status == 2) $status = "Aprovar";
					elseif ($res->status == 3) $status = "Pendente";
					echo '<tr>';
					printf('<td>%s</td>',$res->menunome);
					printf('<td>%s</td>',$res->menulabel);
					printf('<td>%s</td>',$res->menulink);
					printf('<td>%s</td>',$status);
					printf('<td>%s</td>',$res->relevancia) ;
					printf('<td class="center"><a href="?m=mainmenu&s=editar&id=%s" title="Editar"><img src="'.BASEURL.'images/edit.png") 
					alt="Editar Menu" /></a>  </a> <a href="?m=mainmenu&s=excluir&id=%s" title="Excluir"><img src="'.BASEURL.'images/delete.png") 
					alt="Excluir" /></a> </td>',$res->id,$res->id,$res->id);
					echo "</tr>";
				endwhile;
				?>
			</tbody>
		</table>
	<?php
	break;	
	case 'editar':
		echo "<h2>Alteração de Main Menu</h2>";
		if (isAdmin()== TRUE ):
		echo "<br>Passou aqui";
			if (!isset($_REQUEST['id']))	$id = ""; else $id = $_REQUEST['id'];
			if (!isset($_POST['status']))$status = ""; else $status = $_POST['status'];
			if (!isset($_POST['relevancia']))$relevancia = ""; else $relevancia = $_POST['relevancia'];
			if (!isset($_POST['menunome']))	$menunome = ""; else $menunome = $_POST['menunome'];
			if (!isset($_POST['menulabel']))	$menulabel = ""; else $menulabel = $_POST['menulabel'];
			if (!isset($_POST['menulink']))$menulink = "#"; else $menulink = $_POST['menulink'];
			$user_resp   = $userid;	
			date_default_timezone_set('America/Sao_Paulo');
			$datacad   = date('Y-m-d H:i:s');			
			if (isset($_POST['editar'])):
				echo "<br> Descrição dos Main Menu : ".$menulink."<br>";
				$mainmenu = new mainmenu(array(
					'status'    =>$status,
					'relevancia'=>$relevancia,
					'menunome'  =>$menunome,
					'menulabel' =>$menulabel,
					'menulink'  =>$menulink,
					'datacad'   =>$datacad,
					'user_resp' =>$userid,
				));
				$mainmenu->pk_value = $id;
				$mainmenu->updateDB($mainmenu);
				if ($mainmenu->countline==1):
					$extra_msg = '<a href="'.ADMURL.'?m=mainmenu&s=listar">Exibir Cadastros</a>';
					getMSG('cb-911','sucesso',$extra_msg);
					unset ($_POST['mainmenu']);
				endif;
			endif;
			$mmenudb = new mainmenu();
			$mmenudb->pk_value = $id;
			$mmenudb->extra_select = "WHERE id=$id";
			$mmenudb->selectAll($mmenudb);
			$resdb = $mmenudb->returnData();
			?>
	        <script type="text/javascript">
				$(document).ready(function(){
					$(".mmenuform").validate({
						rules:{
							menunome:{required:true, minlength:3},
							menulabel:{required:true, minlength:3},
							status:{required:true, minlength:1},
							relevancia:{required:true, minlength:1}
							}
						});
					});
			</script>	
			<form class="mmenuform" method="post" action="">
				<fieldset>
					<legend>Alteração - Main Menu</legend>
					<ul>
						<div >
							<li><label for="menunome">Rotina:</label>
								<input type="text" name="menunome" size="50" value="<?php echo $resdb->menunome;?>">   
						</div> 

						<div >
							<li><label for="menulabel">Título:</label>
								<input type="text" name="menulabel" size="50" value="<?php echo $resdb->menulabel;?>">   
						</div> 

<!-- Abre   - menulink -->						
						<div >
							<li><label for="menulink">Link:</label>
								<input type="text" name="menulink" size="50" value="<?php echo $resdb->menulink;?>">   
						</div> 
<!-- fecha  - menulink -->	
<!-- Abre   - status -->	
	            		<div >
							<li><label for="status">Status:</label>
								<select name="status">
									<option <?php if($resdb->status == 0) echo 'selected="selected"';?> value=0>Inativo</option>
									<option <?php if($resdb->status == 1) echo 'selected="selected"';?> value=1>Ativo</option>
									<option <?php if($resdb->status == 2) echo 'selected="selected"';?> value=2>Aprovar</option>
									<option <?php if($resdb->status == 3) echo 'selected="selected"';?> value=3>Pendente</option>
								</select>
							</li>	
						</div>
<!-- fecha  - status -->	
<!-- Abre   - relevancia / ordem -->						
						<div >
							<li><label for="relevancia">Ordem:</label>
								<input type="text" name="relevancia" size="50" value="<?php echo $resdb->relevancia;?>">   
						</div> 
<!-- fecha  - relevancia / ordem -->	

<!-- Abre   - end -->	
						<div >
							<li class="center"><input type="submit" name="editar" value="Alterar Main Menu" />
								               <input type="button" onclick="location.href='?m=mainmenu&s=listar'" value="Cancelar" />
								               </li>	
						</div>
					</ul>
				</fieldset>
			</form>		
			<?php
		else:
			//printMSG('Você não tem permissão para efetuar alterações neste usuário. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "m=mainmenu&s=listar";
			$extra_msg = '<a href="?m=mainmenu&s=listar" onclick="history.back()">Voltar</a>';
			getMSG('cb-909','alerta',$extra_msg);
		endif;
	break;
	case 'excluir':
		echo "<h2>Eclusão de Main Menu</h2>";
		$session = new session();
		if (isAdmin()== TRUE ):
			if (isset($_GET['id'])):
				//faz edição do Main Menu
				$id = $_GET['id'];
				if (isset($_POST['exclusao'])):
					$mainmenu = new mainmenu();
					$mainmenu->pk_value = $id;
					$mainmenu->deleteDB($mainmenu);
					if ($mainmenu->countline==1):
						$extra_msg = '<a href="'.ADMURL.'?m=mainmenu&s=listar">Exibir Cadastros</a>';
						getMSG('cb-913','sucesso',$extra_msg);
						unset($_POST);
				 	else:
						$extra_msg = '<a href="'.ADMURL.'?m=mainmenu&s=listar">Exibir Cadastros</a>';
						getMSG('cb-912','alerta',$extra_msg);
						unset($_POST);
					endif;
				endif;
				$mmenudb = new mainmenu();
				$mmenudb->extra_select = "WHERE id=$id";
				$mmenudb->selectAll($mmenudb);
				$resdb = $mmenudb->returnData();
			else:
				getMSG('cb-906','alerta',NULL);
			endif;
			?>
			<form class="userform" method="post" action="">
				<fieldset>
					<legend>Exclusão - Main Menu</legend>
					<ul>
						<li><label for="titulo">Label:</label>
						<?php echo $resdb->menulabel;?>  			
						<li><label for="descr_mainmenu">Link:</label>
						<?php echo $resdb->menulink;?>
	            		<li><label for="imagem">Status:</label>
	            		<?php echo $resdb->status;?>			
						<li class="center"><input type="submit" name="exclusao" value="Confirma Exclusão" />
							               <input type="button" onclick="location.href='?m=mainmenu&s=listar'" value="Cancelar" />
							               </li>	
					</ul>
				</fieldset>
			</form>	
		<?php
		else:
			//printMSG('Você não tem permissão para efetuar alterações neste usuário. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "m=mainmenu&s=listar";
			$extra_msg = '<a href="?m=mainmenu&s=listar" onclick="history.back()">Voltar</a>';
			getMSG('cb-909','alerta',$extra_msg);
			unset($_POST);
		endif;
	break;
	default:
		getMSG("cb-005",$screen,NULL);
		break;
endswitch;
?>