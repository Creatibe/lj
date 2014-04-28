<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<style>
    #titulo:invalid {background:#ff0; }
    #titulos:valid {background:#fff; }
    #nome:invalid {background:#ff0; }
    #nome:valid {background:#fff; }
    #texto1:invalid {background:#ff0; }
    #texto1:valid {background:#fff; }    
    #texto2:invalid {background:#ff0; }
    #texto2:valid {background:#fff; }        
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
$dir = "../upload/images/loja/galerias";
switch ($screen):
	case 'incluir':
		//$session = new session();
		if (isAdmin()== TRUE ):
			if (!isset($_REQUEST['id']))	     $id = "";         else $id         = $_REQUEST['id'];
			if (!isset($_REQUEST['nome']))	     $nome = "";       else $nome       = $_REQUEST['nome'];
			if (!isset($_REQUEST['titulo']))     $titulo = "";     else $titulo     = $_REQUEST['titulo'];			
			if (!isset($_REQUEST['status']))     $status = "";     else $status     = $_REQUEST['status'];
			if (!isset($_REQUEST['relevancia'])) $relevancia = ""; else $relevancia = $_REQUEST['relevancia'];
		
			$user_resp   = $userid;	
			date_default_timezone_set('America/Sao_Paulo');
			$datacad   = date('Y-m-d H:i:s');			
			if (isset($_POST['cadastrar'])):
				$gravadb = new galerias(array(
					'nome'      =>$nome,
					'status'    =>$status,
					'relevancia'=>$relevancia,
					'titulo'    =>$titulo,
					'datacad'   => $datacad,
					'user_id'   =>$userid,
				));
				$gravadb ->insertDB($gravadb );
				//Inicio - Cria a Pasta da Galeria
				$caminho = dirname(dirname(dirname(__FILE__)))."/upload/images/loja/".$nome;
				if(is_dir($caminho)):
					//echo 'existe - '.$caminho;
				else:
					mkdir ($caminho);
					//echo 'Diretorio foi criado - '.$caminho;
				endif;
				
				//final  - Cria a Pasta da Galeria
				if ($gravadb ->countline==1):
					// Início  - Rotina de gravar logs
					if(isset($user_id ))    $reg_user       = "<p>User Resp: ".$user_id."</p>";      else $reg_user       ="";
					if(isset($datacad ))    $reg_data       = "<p>Cadastro: ".$datacad."</p>"; else $reg_data       ="";
					if(isset($status ))     $reg_status     = "<p>Status: ".$status."</p>";          else $reg_status     ="";
					if(isset($relevancia )) $reg_relevancia = "<p>Relevancia: ".$relevancia."</p>";  else $reg_relevancia ="";
					if(isset($titulo ))     $reg_titulo     = "<p>Título: ".$titulo."</p>";          else $reg_titulo     ="";
					if(isset($texto1 ))     $reg_texto1     = "<p>Texto 1: ".$texto1."</p>";         else $reg_texto1     ="";
					if(isset($texto2 ))     $reg_texto2     = "<p>Texto 2: ".$texto2."</p>";         else $reg_texto2     ="";
					if(isset($texto3 ))     $reg_texto3     = "<p>Texto 3: ".$texto3."</p>";         else $reg_texto3     ="";
					if(isset($texto4 ))     $reg_texto4     = "<p>Texto 4: ".$texto4."</p>";         else $reg_texto4     ="";
					if(isset($texto5 ))     $reg_texto5     = "<p>Texto 5: ".$texto5."</p>";         else $reg_texto5     ="";
					if(isset($imagem1 ))    $reg_imagem1    = "<p>Imagem 1: ".$imagem1."</p>";       else $reg_imagem1    ="";
					if(isset($imagem2 ))    $reg_imagem2    = "<p>Imagem 2: ".$imagem2."</p>";       else $reg_imagem2    ="";
					if(isset($imagem3 ))    $reg_imagem3    = "<p>Imagem 3: ".$imagem3."</p>";       else $reg_imagem3    ="";
					if(isset($imagem4 ))    $reg_imagem4    = "<p>Imagem 4: ".$imagem4."</p>";       else $reg_imagem4    ="";
					if(isset($imagem5 ))    $reg_imagem5    = "<p>Imagem 5: ".$imagem5."</p>";       else $reg_imagem5    ="";
					$registro  = "<p>Rotina : $nome</p>".$reg_status.$reg_relevancia.$titulo.$reg_texto1.$reg_texto2.$reg_texto3.$reg_texto4.$reg_texto5;
					$registro .= $reg_imagem1.$reg_imagem2.$reg_imagem3.$reg_imagem4.$reg_imagem5.$reg_data.$reg_user;
					grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 		
					echo '<script> location.href="?m=galerias&s=listar" </script>';
					// Final  - Rotina de gravar logs						
					//$extra_msg = '<a href="'.ADMURL.'?m=galerias&s=listar">Exibir Cadastros</a>';
					//getMSG('cb-911','sucesso',$extra_msg);
					unset ($_POST['nome']);
					unset ($_POST['status']);
					unset ($_POST['relevancia']);
					unset ($_POST['titulo']);
					unset ($_POST['datacad']);
					unset ($_POST['user_resp']);
					unset ($_POST['cadastrar']);
				endif;
			endif;
			?>

			<form class="form" name=form method="post" action="">
				<fieldset>
					<legend>Cadastro - Galerias</legend>
					<ul>
 					
						<div >
							<li><label for="nome">Galeria:</label>
								<input type="text" name="nome" id="nome" size="50" 
								pattern="[a-z|0-9|-]{4,20}"  placeholder="Nome da galeria (Letras minúsculas, sem espaços ou caracteres especiais)" 
							size="50" title="Este campo só aceita o híifen (-) como caracter especial letras minúscuças e números - Tamanho: mínimo 4 e máximo 20 caracteres ***não utilizar espaços***" 
							required ><?php echo $nome;?> 
							</li>
						</div>

	            		<div >	
							<li><label for="titulo">Título:</label>
								<input type="text"  name="titulo" id="titulo" size="50" 
								 placeholder="Título da galeria que aparecerá no site - Tamanho max 50 caracteres" 
							size="50" title="Título da galeria que aparecerá no site - Tamanho max 50 caracteres" 
							required ><?php echo $titulo;?> 
							</li>
		            	</div>
				

						<br>
						<div >
						<li><label for="status">Status:</label>
							<select name="status">
								<option selected="selected" value=0>Inativo</option>
								<option value=1>Ativo</option>
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

						<div >
							<li class="center"><input type="submit" name="cadastrar" value="Salvar Dados" />
							    <input type="button" onclick="location.href='?m=galerias&s=listar'" value="Cancelar" />
							</li>
						</div> 
					</ul>
				</fieldset>	
			</form>	
			<?php
		else:
			printMSG('Você não tem permissão para efetuar alterações neste usuário. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "m=galerias&s=listar";
			$extra_msg = '<a href="?m=galerias&s=listar" onclick="history.back()">Voltar</a>';
			getMSG('cb-909','alerta',$extra_msg);
		endif;		
	break;
	case 'listar':
		echo '<h2>Galerias Cadastradas</h2>';
		loadCSS("data-table","screen",TRUE);
		loadJS("jquery-datatable");
		?>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#listagalerias").dataTable({
					"oLanguage": {
						"sLengthMenu": " _MENU_ registros por Galeria",
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
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="listagalerias">
			<thead>
				<tr>
					<th>Galeria</th><th>Título</th><th>Sts</th><th>Relev</th><th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$lerdb = new galerias();
				//$galerias->extra_select="where status = 1  ";	
				//$galerias->extra_select="order by relevancia DESC";	
				$lerdb->selectAll($lerdb);
				while ($resdb= $lerdb->returnData()):
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
					printf('<td>%s</td>',$status);
					printf('<td>%s</td>',$relevancia) ;
					if ($resdb->id != 0):
						printf('<td class="center"><a href="?m=galerias&s=editar&id=%s" title="Editar"><img src="'.BASEURL.'images/edit.png") 
							alt="Editar galeria" /></a></a> <a href="?m=galerias&s=excluir&id=%s" title="Excluir"><img src="'.BASEURL.'images/delete.png") 
							alt="Excluir galeria" /></a> </td>',$resdb->id,$resdb->id,$resdb->id);
					else:
						printf('<td class="center"><a href="?m=galerias&s=editar&id=%s" title="Editar"><img src="'.BASEURL.'images/edit.png") 
							alt="Editar galeria" /></a>
							<a title="Esta galeria não pode ser excluída"><img src="'.BASEURL.'images/nao_delete.png") 	alt=" Não Deletar galeria" /></a>
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
		echo "<h2>Alteração de Galerias</h2>";
		//$session = new session();
		if (isAdmin()== TRUE ):
			if (!isset($_REQUEST['id']))         $id         = ""; else $id         = $_REQUEST['id'];
			if (!isset($_REQUEST['nome']))	     $nome       = ""; else $nome       = $_REQUEST['nome'];
			if (!isset($_REQUEST['titulo']))     $titulo     = ""; else $titulo     = $_REQUEST['titulo'];
			if (!isset($_REQUEST['status']))     $status     = ""; else $status     = $_REQUEST['status'];
			if (!isset($_REQUEST['relevancia'])) $relevancia = ""; else $relevancia = $_REQUEST['relevancia'];

			//echo "<br> o Valor de imagem é : ".$imagem;
			$user_resp   = $userid;	
			date_default_timezone_set('America/Sao_Paulo');
			$datacad   = date('Y-m-d H:i:s');	
			$lerdb = new galerias();
			$lerdb->pk_value = $id;
			$lerdb->extra_select = "WHERE id=$id";
			$lerdb->selectAll($lerdb);
			$resdb = $lerdb->returnData();		
			if (isset($_POST['editar'])):
				//echo "<br> Descrição dos galerias : ".$texto1."<br>";
				$updtdb = new galerias(array(
					'nome'       =>$nome,
					'status'     =>$status,
					'relevancia' =>$relevancia,
					'titulo'     =>$titulo,
					'datacad'    => $datacad,
					'user_id'    =>$userid,
				));
				$updtdb ->pk_value = $id;
				$updtdb ->updateDB($updtdb );
				// Início verificar se precisa trocar o nome da pasta
				$caminho_novo = dirname(dirname(dirname(__FILE__)))."/upload/images/loja/".$nome;
				$caminho_velho = dirname(dirname(dirname(__FILE__)))."/upload/images/loja/".$resdb->nome;
				if(is_dir($caminho_novo)):
					//echo 'existe - '.$caminho;
				else:
					rename ($caminho_velho,$caminho_novo);
					//echo 'Diretorio foi criado - '.$caminho;
				endif;
				// Início verificar se precisa trocar o nome da pasta

				if ($updtdb ->countline==1):
					// Início  - Rotina de gravar logs
					if(isset($resdb->user_id ))    $reg_user       = "<p>User Resp: ".$resdb->user_id."</p>";      else $reg_user       ="";
					if(isset($resdb->datacad ))    $reg_data       = "<p>Ult. Alteração: ".$resdb->datacad."</p>"; else $reg_data       ="";
					if(isset($resdb->status ))     $reg_status     = "<p>Status: ".$resdb->status."</p>";          else $reg_status     ="";
					if(isset($resdb->relevancia )) $reg_relevancia = "<p>Relevancia: ".$resdb->relevancia."</p>";  else $reg_relevancia ="";
					if(isset($resdb->titulo ))     $reg_titulo     = "<p>Título: ".$resdb->titulo."</p>";          else $reg_titulo     ="";
					if(isset($resdb->texto1 ))     $reg_texto1     = "<p>Texto 1: ".$resdb->texto1."</p>";         else $reg_texto1     ="";
					if(isset($resdb->texto2 ))     $reg_texto2     = "<p>Texto 2: ".$resdb->texto2."</p>";         else $reg_texto2     ="";
					if(isset($resdb->texto3 ))     $reg_texto3     = "<p>Texto 3: ".$resdb->texto3."</p>";         else $reg_texto3     ="";
					if(isset($resdb->texto4 ))     $reg_texto4     = "<p>Texto 4: ".$resdb->texto4."</p>";         else $reg_texto4     ="";
					if(isset($resdb->texto5 ))     $reg_texto5     = "<p>Texto 5: ".$resdb->texto5."</p>";         else $reg_texto5     ="";
					if(isset($resdb->imagem1 ))    $reg_imagem1    = "<p>Imagem 1: ".$resdb->imagem1."</p>";       else $reg_imagem1    ="";
					if(isset($resdb->imagem2 ))    $reg_imagem2    = "<p>Imagem 2: ".$resdb->imagem2."</p>";       else $reg_imagem2    ="";
					if(isset($resdb->imagem3 ))    $reg_imagem3    = "<p>Imagem 3: ".$resdb->imagem3."</p>";       else $reg_imagem3    ="";
					if(isset($resdb->imagem4 ))    $reg_imagem4    = "<p>Imagem 4: ".$resdb->imagem4."</p>";       else $reg_imagem4    ="";
					if(isset($resdb->imagem5 ))    $reg_imagem5    = "<p>Imagem 5: ".$resdb->imagem5."</p>";       else $reg_imagem5    ="";
					$registro  = "<p>Rotina : $nome</p>".$reg_status.$reg_relevancia.$titulo.$reg_texto1.$reg_texto2.$reg_texto3.$reg_texto4.$reg_texto5;
					$registro .= $reg_imagem1.$reg_imagem2.$reg_imagem3.$reg_imagem4.$reg_imagem5.$reg_data.$reg_user;
					grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 		
					echo '<script> location.href="?m=galerias&s=listar" </script>';
					// Final  - Rotina de gravar logs						
					//$extra_msg = '<a href="'.ADMURL.'?m=galerias&s=listar">Exibir Cadastros</a>';
					//getMSG('cb-911','sucesso',$extra_msg);
					unset ($_POST['nome']);

				endif;
				//echo '<script> location.href="?m=galerias&s=listar" </script>';
			endif;

			$imagem_atual = $resdb->imagem;
			?>

			<form class="form" method="post" action="">
				<fieldset>
					<legend>Alteração - Galerias</legend>
					<ul>
						<div >
							<li><label for="nome">Galeria:</label>
								<input type="text" name="nome" id="nome" size="50" 
								pattern="[a-z|0-9|-]{4,20}"  placeholder="Nome da galeria (Letras minúsculas, sem espaços ou caracteres especiais)" 
							size="50" title="Este campo só aceita o híifen (-) como caracter especial letras minúsculas e números - Tamanho: mínimo 4 e máximo 20 caracteres ***não utilizar espaços***" 
							required value="<?php echo $resdb->nome;?>">   
						</div> 
						
						<div >
							<li><label for="titulo">Título:</label>
								<input type="text" name="titulo" id="titulo" size="50" 
								placeholder="Título da galeria que aparecerá no site - Tamanho max de 50 caracteres" 
								size="50" title="Título da galeria que aparecerá no site - Tamanho max de 50 caracteres" 
								required value="<?php echo $resdb->titulo;?>">   
							</li>
						</div> 

				
	            		
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
	
						<div >
							<li class="center">
							    							   
							    <input type="submit" name="editar" value="Alterar Dados" />
				                <input type="button" onclick="location.href='?m=galerias&s=listar'" value="Cancelar" />
				                

							</li>	
						</div>
					</ul>
				</fieldset>
			</form>		
			<?php
		else:
			//printMSG('Você não tem permissão para efetuar alterações neste usuário. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "m=galerias&s=listar";
			//$extra_msg = '<a href="?m=galerias&s=listar" onclick="history.back()">Voltar</a>';
			//getMSG('cb-909','alerta',$extra_msg);
		endif;
	break;
	case 'excluir':
		echo "<h2>Eclusão de Galerias</h2>";
		//$session = new session();
		if (isAdmin()== TRUE ):
			date_default_timezone_set('America/Sao_Paulo');
			$datacad   = date('Y-m-d H:i:s');
			if (isset($_GET['id'])):
				//faz edição do galerias
				$id = $_GET['id'];
				$lerdb = new galerias();
				$lerdb->pk_value = $id;
				$lerdb->extra_select = "WHERE id=$id";
				$lerdb->selectAll($lerdb);
				$resdb = $lerdb->returnData();	
				if (isset($_POST['exclusao'])):
					$deldb = new galerias();
					$deldb->pk_value = $id;
					$deldb->deleteDB($deldb);
					if ($deldb->countline==1):
						// Início - excluir past e arquivos da Galeria
						$caminho = dirname(dirname(dirname(__FILE__)))."/upload/images/loja/".$resdb->nome;
						deleteDirectory ( $caminho );
						// final - excluir past e arquivos da Galeria						
						// Início  - Rotina de gravar logs
						if(isset($resdb->user_id ))    $reg_user       = "<p>User Resp: ".$resdb->user_id."</p>";      else $reg_user       ="";
						if(isset($resdb->datacad ))    $reg_data       = "<p>Ult. Alteração: ".$resdb->datacad."</p>"; else $reg_data       ="";
						if(isset($resdb->status ))     $reg_status     = "<p>Status: ".$resdb->status."</p>";          else $reg_status     ="";
						if(isset($resdb->relevancia )) $reg_relevancia = "<p>Relevancia: ".$resdb->relevancia."</p>";  else $reg_relevancia ="";
						if(isset($resdb->titulo ))     $reg_titulo     = "<p>Título: ".$resdb->titulo."</p>";          else $reg_titulo     ="";
						if(isset($resdb->texto1 ))     $reg_texto1     = "<p>Texto 1: ".$resdb->texto1."</p>";         else $reg_texto1     ="";
						if(isset($resdb->texto2 ))     $reg_texto2     = "<p>Texto 2: ".$resdb->texto2."</p>";         else $reg_texto2     ="";
						if(isset($resdb->texto3 ))     $reg_texto3     = "<p>Texto 3: ".$resdb->texto3."</p>";         else $reg_texto3     ="";
						if(isset($resdb->texto4 ))     $reg_texto4     = "<p>Texto 4: ".$resdb->texto4."</p>";         else $reg_texto4     ="";
						if(isset($resdb->texto5 ))     $reg_texto5     = "<p>Texto 5: ".$resdb->texto5."</p>";         else $reg_texto5     ="";
						if(isset($resdb->imagem1 ))    $reg_imagem1    = "<p>Imagem 1: ".$resdb->imagem1."</p>";       else $reg_imagem1    ="";
						if(isset($resdb->imagem2 ))    $reg_imagem2    = "<p>Imagem 2: ".$resdb->imagem2."</p>";       else $reg_imagem2    ="";
						if(isset($resdb->imagem3 ))    $reg_imagem3    = "<p>Imagem 3: ".$resdb->imagem3."</p>";       else $reg_imagem3    ="";
						if(isset($resdb->imagem4 ))    $reg_imagem4    = "<p>Imagem 4: ".$resdb->imagem4."</p>";       else $reg_imagem4    ="";
						if(isset($resdb->imagem5 ))    $reg_imagem5    = "<p>Imagem 5: ".$resdb->imagem5."</p>";       else $reg_imagem5    ="";
						$registro  = "<p>Rotina : $resdb->nome</p>".$reg_status.$reg_relevancia.$titulo.$reg_texto1.$reg_texto2.$reg_texto3.$reg_texto4.$reg_texto5;
						$registro .= $reg_imagem1.$reg_imagem2.$reg_imagem3.$reg_imagem4.$reg_imagem5.$reg_data.$reg_user;
						grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 		
						echo '<script> location.href="?m=galerias&s=listar" </script>';
						// Final  - Rotina de gravar logs	
						//echo '<script> location.href="?m=galerias&s=listar" </script>';
						$extra_msg = '<a href="'.ADMURL.'?m=galerias&s=listar">Exibir Cadastros</a>';
						getMSG('cb-913','sucesso',$extra_msg);
						unset($_POST);
				 	else:
						$extra_msg = '<a href="'.ADMURL.'?m=galerias&s=listar">Exibir Cadastros</a>';
						getMSG('cb-912','alerta',$extra_msg);
						unset($_POST);
					endif;
				endif;
			else:
				getMSG('cb-906','alerta',NULL);
			endif;
			// Início - Mostra os registro da pasta a ser exculída
			$caminho = dirname(dirname(dirname(__FILE__)))."/upload/images/loja/".$resdb->nome;
			if(is_dir($caminho)):
			   //echo 'existe - '.$caminho;
			   $diretorio = dir($caminho);
			   echo "<br>Serão excluídos os Arquivos da Galeria '<strong>".$resdb->nome."</strong>':<br />";    
			   while($arquivo = $diretorio -> read()){
			      if($arquivo != "." and $arquivo != ".." ) echo $arquivo."<br />";
			   }
			   $diretorio -> close();
			else:
				//echo 'Diretorio foi criado - '.$caminho;
			endif;
			// final - Mostra os registro da pasta a ser exculída
			?>
			
			<form class="userform" method="post" action="">
				<fieldset>
					<legend>Exclusão - Galerias</legend>
					<ul>
						<li><label for="nome">Galeria:</label>
						<?php echo $resdb->nome;?>  			

						<li><label for="titulo">Título:</label>
						<?php echo $resdb->titulo;?>  			

						<li class="center">
						   	<input type="submit" name="exclusao" value="Confirma Exclusão" />
							<input type="button" onclick="location.href='?m=galerias&s=listar'" value="Cancelar" />
		               </li>	
					</ul>
				</fieldset>
			</form>	
		<?php
		else:
			//printMSG('Você não tem permissão para efetuar alterações neste usuário. <a href="#" onclick="history.back()">Voltar</a>','error');
			$pg = "m=galerias&s=listar";
			//$extra_msg = '<a href="?m=galerias&s=listar" onclick="history.back()">Voltar</a>';
			//getMSG('cb-909','alerta',$extra_msg);
			unset($_POST);
		endif;
	break;
	default:
		getMSG("cb-005",$screen,NULL);
		
		break;
endswitch;
?>
