<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
    #nome:invalid {background:#ff0; }
    #nome:valid {background:#fff; }    
    #titulo:invalid {background:#ff0; }
    #titulo:valid {background:#fff; }    
    #valor:invalid {background:#ff0; }
    #valor:valid {background:#fff; } 
    #estoque:invalid {background:#ff0; }
    #estoque:valid {background:#fff; }     
    #promocao:invalid {background:#ff0; }
    #promocao:valid {background:#fff; }      
    #desconto:invalid {background:#ff0; }
    #desconto:valid {background:#fff; }     
</style>		
<script language="javascript">
//-----------------------------------------------------
//Funcao: MascaraMoeda
//Sinopse: Mascara de preenchimento de moeda
//Parametro:
//   objTextBox : Objeto (TextBox)
//   SeparadorMilesimo : Caracter separador de milésimos
//   SeparadorDecimal : Caracter separador de decimais
//   e : Evento
//Retorno: Booleano
//Autor: Gabriel Fróes - www.codigofonte.com.br
//-----------------------------------------------------
function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){
    var sep = 0;
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    var whichCode = (window.Event) ? e.which : e.keyCode;
    if (whichCode == 13) return true;
    key = String.fromCharCode(whichCode); // Valor para o código da Chave
    if (strCheck.indexOf(key) == -1) return false; // Chave inválida
    len = objTextBox.value.length;
    for(i = 0; i < len; i++)
        if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;
    aux = '';
    for(; i < len; i++)
        if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1) aux += objTextBox.value.charAt(i);
    aux += key;
    len = aux.length;
    if (len == 0) objTextBox.value = '';
    if (len == 1) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;
    if (len == 2) objTextBox.value = '0'+ SeparadorDecimal + aux;
    if (len > 2) {
        aux2 = '';
        for (j = 0, i = len - 3; i >= 0; i--) {
            if (j == 3) {
                aux2 += SeparadorMilesimo;
                j = 0;
            }
            aux2 += aux.charAt(i);
            j++;
        }
        objTextBox.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
        objTextBox.value += aux2.charAt(i);
        objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);
    }
    return false;
}
</script>
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
			if (!isset($_REQUEST['id']))	        $id            = "";     else $id            = $_REQUEST['id'];
			if (!isset($_REQUEST['sku']))  	        $sku           = "";     else $sku           = $_REQUEST['sku'];
			if (!isset($_REQUEST['nome']))  	    $nome          = "";     else $nome          = $_REQUEST['nome'];
			if (!isset($_REQUEST['titulo']))  	    $titulo        = "";     else $titulo        = $_REQUEST['titulo'];
			if (!isset($_REQUEST['valor']))         $valor         = "";     else $valor         = $_REQUEST['valor'];
			if (!isset($_REQUEST['desconto']))      $desconto      = "";     else $desconto      = $_REQUEST['desconto'];
			if (!isset($_REQUEST['promocao'])) 	    $promocao      = "";     else $promocao      = $_REQUEST['promocao'];
			if (!isset($_REQUEST['estoque']))  	    $estoque       = "";     else $estoque       = $_REQUEST['estoque'];
			if (!isset($_REQUEST['encomenda']))	    $encomenda     = "";     else $encomenda     = $_REQUEST['encomenda'];
			if (!isset($_REQUEST['fixar_home']))    $fixar_home    = "";     else $fixar_home    = $_REQUEST['fixar_home'];
			if (!isset($_REQUEST['categorias']))    $categorias    = "";     else $categorias    = $_REQUEST['categorias'];
			if (!isset($_REQUEST['qtde_vendida']))  $qtde_vendida  = "";     else $qtde_vendida  = $_REQUEST['qtde_vendida'];
			if (!isset($_REQUEST['valor_vendido'])) $valor_vendido = "";     else $valor_vendido = $_REQUEST['valor_vendido'];
			if (!isset($_REQUEST['status']))        $status        = "";     else $status        = $_REQUEST['status'];
			if (!isset($_REQUEST['relevancia']))    $relevancia    = "";     else $relevancia    = $_REQUEST['relevancia'];
			$user_resp   = $userid;	
			date_default_timezone_set('America/Sao_Paulo');
			$datacad   = date('Y-m-d H:i:s');		
			
			$valor = str_replace(".", "", $valor);
			$valor = str_replace(",", ".", $valor);
			$promocao = str_replace(".", "", $promocao);
			$promocao = str_replace(",", ".", $promocao);
			if (isset($_POST['cadastrar'])):
				$gravadb = new produtos(array(
					'sku'           =>$sku,
					'nome'          =>$nome,
					'titulo'        =>$titulo,
					'valor'         =>$valor,
					'desconto'      =>$desconto,
					'promocao'      =>$promocao,
					'estoque'       =>$estoque,
					'encomenda'     =>$encomenda,
					'fixar_home'    =>$fixar_home,
					'qtde_vendida'  =>$qtde_vendida,
					'valor_vendido' =>$valor_vendido,
					'status'        =>$status,
					'relevancia'    =>$relevancia,
					'data_cad'      =>$datacad,
					'user_id'       =>$userid,
					'categorias_id' =>$categorias,
				));
				$gravadb ->insertDB($gravadb );
				
				// Início  - Rotina de gravar logs
				if(isset($id ))                 $reg_id            = "<p>Reg no DB: ".$id."</p>";                  else $reg_id            ="";
				if(isset($user_id ))            $reg_user          = "<p>User Resp: ".$user_id."</p>";             else $reg_user          ="";
				if(isset($datacad ))            $reg_data          = "<p>Cadastro: ".$datacad."</p>";              else $reg_data          ="";
				if(isset($status ))             $reg_status        = "<p>Status: ".$status."</p>";                 else $reg_status        ="";
				if(isset($relevancia ))         $reg_relevancia    = "<p>Relevancia: ".$relevancia."</p>";         else $reg_relevancia    ="";
				if(isset($nome ))               $reg_nome          = "<p>Nome Produto: ".$nome."</p>";             else $reg_nome          ="";
				if(isset($titulo ))             $reg_titulo        = "<p>Descrição: ".$titulo."</p>";              else $reg_titulo        ="";
				if(isset($valor ))              $reg_valor         = "<p>Valor: ".$valor."</p>";                   else $reg_valor         ="";
				if(isset($desconto ))           $reg_desconto      = "<p>Desconto:  ".$desconto."</p>";            else $reg_desconto      ="";
				if(isset($promocao ))           $reg_promocao      = "<p>Promocão:  ".$promocao."</p>";            else $reg_promocao      ="";
				if(isset($estoque ))            $reg_estoque       = "<p>Estoque:  ".$estoque."</p>";              else $reg_estoque       ="";
				if(isset($encomenda ))          $reg_encomenda     = "<p>Encomenda:  ".$encomenda."</p>";          else $reg_encomenda     ="";
				if(isset($fixar_home ))         $reg_fixar_home    = "<p>Fixo na Home:  ".$fixar_home."</p>";      else $reg_fixar_home    ="";
				if(isset($qtde_vendida ))       $reg_qtde_vendida  = "<p>Qtde Vendida:  ".$qtde_vendida."</p>";    else $reg_qtde_vendida  ="";
				if(isset($valor_vendido ))      $reg_valor_vendido = "<p>Valor Vendido:  ".$valor_vendido."</p>";  else $reg_valor_vendido ="";
				if(isset($categorias ))         $reg_categorias    = "<p>Categoria:  ".$categorias."</p>";         else $reg_categorias    ="";
				$registro  =$reg_id.$reg_nome.$reg_titulo.$reg_valor.$reg_desconto.$reg_promocao.$reg_estoque.$reg_encomenda;
				$registro .=$reg_fixar_home.$reg_qtde_vendida.$reg_valor_vendido.$reg_status.$reg_relevancia.$reg_categorias.$reg_data.$reg_user;
				if ($gravadb ->countline==1):
					grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 	
					// Final  - Rotina de gravar logs	
					//echo '<script> location.href="?p=loja&m=produtos&s=editar&sc='.$nome.'&datacad='.$datacad.'" </script>';
					//$extra_msg = '<a href="'.ADMURL.'?p=loja&m=produtos&s=editar&sc='.$nome.'&datacad='.$datacad.'">Cadastrar Opções</a>';
					//getMSG('cb-911','sucesso',$extra_msg);
					//unset ($_POST['nome']);
					//unset ($_POST['titulo']);
					//unset ($_POST['cadastrar']);
					ins_prod_detalhes("",'personaliza&id=',$userid,$user_ip,$acao,$rotina."-Ins Detalhes",$titulo,$nome);

				else:
					echo "Erro ao gravar o registro<br>";
					echo $registro;
				endif;
			endif;
?>
			<form  name=pagform method="post" action="">
				<fieldset>
					<legend>Cadastro de Produtos</legend>
					<p><h2>Cadastro de Produtos</h2></p>
					<ul>
 						<div >	
							<li><label for="nome">Produto:</label>
								<input type="text" class="area_editavel_pagina" name="nome" id="nome"  maxlength="30" autofocus
								 placeholder="Nome do Produto - Tamanho max 30 caracteres" 
								 title="Nome do Produto - Tamanho max 30 caracteres"  required />
							</li>
							
							<?php
								$lerdb = new categorias();
								$lerdb->extra_select="where status = 1";	
								$lerdb->selectAll($lerdb);
								echo '<li><label for="categorias">Selecione a Categoria do Produto:</label>';
								echo '<select name="categorias">';
								while ($resdb= $lerdb->returnData()):
									echo '	<option value='.$resdb->id.'>'.$resdb->nome.'</option>';
								endwhile;
								echo '</select>';
								echo '</li>';
							?>
							
							<li><label for="titulo">Descrição do Produto:</label>
								<input type="text" class="area_editavel_pagina" name="titulo" id="titulo"  maxlength="255" autofocus
								 placeholder="Descrição do Produto - Tamanho max 255 caracteres" 
								 title="Descrição do Produto - Tamanho max 255 caracteres"  required />
							</li>
							
		            	</div>
 						<div >	
							<li><label for="valor">Valor do Produto(R$):</label>
								<input type="text"  name="valor" id="valor" pattern="[0-9|.|,]{1,13}" onKeyPress="return(MascaraMoeda(this,'.',',',event))" 
								placeholder="Valor do Produto em R$ - Valor máximo 99.999.999,99" 
								title="Valor do Produto em R$ - Valor máximo 99.999.999,99" required/>
							</li>
		            	</div>
 						<div >	
							<li><label for="desconto">Porcentagem de Desconto a ser aplicado no Valor do Produto(%):</label>
								<input type="text"  name="desconto" id="desconto" pattern="[0-9]{1,2}"
								placeholder="Desconto a ser aplicado no Valor do Produto em % - Máximo 99" 
								title="Desconto a ser aplicado no Valor do Produto em % - Máximo 99" />
							</li>
		            	</div>
						<div >	
							<li><label for="promocao">Valor Promocional do Produto(R$):</label>
								<input type="text"  name="promocao" id="promocao" pattern="[0-9|.|,]{1,13}"  onKeyPress="return(MascaraMoeda(this,'.',',',event))" 
								placeholder="Valor Promocional do Produto em R$ - Valor máximo 99.999.999,99" 
								title="Valor Promocional do Produto em R$ - Valor máximo 99.999.999,99" />
							</li>
		            	</div>
						<div >	
							<li><label for="estoque">Estoque do Produto:</label>
								<input type="text"  name="estoque" id="estoque" pattern="[0-9]{1,5}" 
								placeholder="Quantidade de Estoque do Produto - Máximo 99999" 
								title="Quantidade de Estoque do Produto - Máximo 99999" required/>
							</li>
		            	</div>
						<div >
						<li><label for="encomenda">Este produto aceitará encomendas quando o estoque for zero(0)?</label>
							<select name="encomenda">
								<option selected="selected" value=0>Não</option>
								<option value=1>Sim</option>
							</select>
						<li><label for="fixar_home">Este Produto deverá aparecer sempre na Página Home(Principal) do Site?</label>
							<select name="menu">
								<option selected="selected" value=0>Não</option>
								<option value=1>Sim</option>
							</select>							
						<li><label for="status">Status:</label>
							<select name="status" disabled>
								<option value=0>Inativo</option>
								<option value=1>Ativo</option>
								<option value=2>Aguardando Aprovação</option>
								<option selected="selected" value=3>Pendente</option>
							</select> O Status ficará pendente até personalizar o produto
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
							<li class="center"><input type="submit" name="cadastrar" value="Salvar e Personalizar" />
							    <input type="button" onclick="location.href='?p=loja&m=produtos&s=listar'" value="Cancelar" />
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
		echo '<h2>Produtos Cadastrados</h2>';
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
					<th>Produto</th><th>Categoria</th><th>Sts</th><th>Relev</th><th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$lerdb = new produtos();
				//$lerdb->extra_select="GROUP by titulo";	
				$lerdb->selectAll($lerdb);
				
				while ($resdb= $lerdb->returnData()):
					$lerdb_cat = new categorias();
					$lerdb_cat->extra_select="where id =".$resdb->categorias_id." LIMIT 1";	// ver se tem  o id na tabela item_sub_cat campo sub_cat_id
					$lerdb_cat->selectAll($lerdb_cat);
					$resdb_cat= $lerdb_cat->returnData();
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
					printf('<td>%s</td>',$resdb_cat->nome);
					printf('<td>%s</td>',$status);
					printf('<td>%s</td>',$relevancia) ;
					if ($resdb->id != 0 ):
						printf('<td class="center"><a href="?p=loja&m=produtos&s=editar&id=%s" title="Editar"><img src="'.BASEURL.'images/edit.png") 
							alt="Editar" /></a></a> <a href="?p=loja&m=produtos&s=excluir&id=%s" title="Excluir"><img src="'.BASEURL.'images/delete.png") 
							alt="Excluir" /></a> </td>',$resdb->id,$resdb->id,$resdb->id);
					else:
						printf('<td class="center"><a href="?p=loja&m=produtos&s=editar&id=%s" title="Editar"><img src="'.BASEURL.'images/edit.png") 
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
		echo "<h2>Alteração de Produtos</h2>";
		if (isAdmin()== TRUE ):
			if (!isset($_REQUEST['id']))	        $id            = "";     else $id            = $_REQUEST['id'];
			if (!isset($_REQUEST['sku']))  	        $sku           = "";     else $sku           = $_REQUEST['sku'];
			if (!isset($_REQUEST['nome']))  	    $nome          = "";     else $nome          = $_REQUEST['nome'];
			if (!isset($_REQUEST['titulo']))  	    $titulo        = "";     else $titulo        = $_REQUEST['titulo'];
			if (!isset($_REQUEST['valor']))         $valor         = "";     else $valor         = $_REQUEST['valor'];
			if (!isset($_REQUEST['desconto']))      $desconto      = "";     else $desconto      = $_REQUEST['desconto'];
			if (!isset($_REQUEST['promocao'])) 	    $promocao      = "";     else $promocao      = $_REQUEST['promocao'];
			if (!isset($_REQUEST['estoque']))  	    $estoque       = "";     else $estoque       = $_REQUEST['estoque'];
			if (!isset($_REQUEST['encomenda']))	    $encomenda     = "";     else $encomenda     = $_REQUEST['encomenda'];
			if (!isset($_REQUEST['fixar_home']))    $fixar_home    = "";     else $fixar_home    = $_REQUEST['fixar_home'];
			if (!isset($_REQUEST['categorias']))    $categorias    = "";     else $categorias    = $_REQUEST['categorias'];
			if (!isset($_REQUEST['qtde_vendida']))  $qtde_vendida  = "";     else $qtde_vendida  = $_REQUEST['qtde_vendida'];
			if (!isset($_REQUEST['valor_vendido'])) $valor_vendido = "";     else $valor_vendido = $_REQUEST['valor_vendido'];
			if (!isset($_REQUEST['status']))        $status        = "";     else $status        = $_REQUEST['status'];
			if (!isset($_REQUEST['relevancia']))    $relevancia    = "";     else $relevancia    = $_REQUEST['relevancia'];
			
			
			//Verifica as categoirias e sub-categorias
			$n_sc = 20;
			$n_xx_ok = 0;
			for ($i = 0; $i <= $n_sc; $i++):
					$n_xx_ok ++;
					$x_sc = "sub_cat_";
					$x_sc =$x_sc . $n_xx_ok ; 
					$$x_sc  = 0;
					if (! empty($_REQUEST[$x_sc])):
					  $$x_sc  = $_REQUEST[$x_sc];
					endif; 
					$x_nm = "nome_";
					$x_nm =$x_nm . $n_xx_ok ; 
					$$x_nm  = 0;
					if (! empty($_REQUEST[$x_nm])):
					  $$x_nm  = $_REQUEST[$x_nm];
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
					'sku'           =>$sku,
					'nome'          =>$nome,
					'titulo'        =>$titulo,
					'valor'         =>$valor,
					'desconto'      =>$desconto,
					'promocao'      =>$promocao,
					'estoque'       =>$estoque,
					'encomenda'     =>$encomenda,
					'fixar_home'    =>$fixar_home,
					'qtde_vendida'  =>$qtde_vendida,
					'valor_vendido' =>$valor_vendido,
					'status'        =>$status,
					'relevancia'    =>$relevancia,
					'data_cad'      =>$datacad,
					'user_id'       =>$userid,
					'categorias_id' =>$categorias,
					
				));
				$updtdb ->pk_value = $id;
				$updtdb ->updateDB($updtdb );
				if ($updtdb ->countline==1):
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
				if ($updtdb ->countline==1):
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
					
					grava_log($userid,$user_ip,$rotina.'-Det',$acao,$registro,$datacad); 
					if ($categorias != $resdb->prod_categorias_id): 
						echo "<script>alert('A Categoria do Produto foi alterada. O Produto será movido para a nova Categoria e será necessário personalizá-lo novamente.');</script>";
						del_prod_detalhes($id,'voltar',$userid,$user_ip,$acao,$rotina.'- Troca de Categoria');		//chama rotina para deletar detalhes do produto		
						ins_prod_detalhes($id,'personaliza&id=',$userid,$user_ip,$userid,$user_ip,$acao,$rotina."-Ins Detalhes",$titulo,$nome);//chama rotina para incluir detalhes do produto			
					endif;							
					echo '<script> location.href="?p=loja&m=produtos&s=listar" </script>';
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
					<legend>Alteração de Produtos</legend>
					<ul>
 						<div >	
							<li><label for="nome">Produto:</label>
								<input type="text" class="area_editavel_pagina" name="nome" id="nome"  maxlength="30" autofocus
								 placeholder="Nome do Produto - Tamanho max 30 caracteres" 
								 title="Nome do Produto - Tamanho max 30 caracteres" value="<?php echo $resdb->prod_nome;?>" required />
							</li>
							<?php
								$lerdb_cat = new categorias();
								$lerdb_cat->extra_select="where status = 1 ";	
								$lerdb_cat->selectAll($lerdb_cat);
								echo '<li><label for="categorias">Categoria do Produto:</label>';
								echo '<select name="categorias">';
								while ($resdb_cat= $lerdb_cat->returnData()):
									if($resdb->prod_categorias_id == $resdb_cat->id) $select_item = 'selected="selected"'; else $select_item = "";
									echo '	<option '.$select_item.' value="'.$resdb_cat->id.'">'.$resdb_cat->nome.'</option>';
								endwhile;
								echo '</select>';
								echo '</li>';
							?>
							<li><label for="titulo">Descrição do Produto:</label>
								<input type="text" class="area_editavel_pagina" name="titulo" id="titulo"  maxlength="255" autofocus
								 placeholder="Descrição do Produto - Tamanho max 255 caracteres" 
								 title="Descrição do Produto - Tamanho max 255 caracteres" value="<?php echo $resdb->prod_titulo;?>" required />
							</li>
		            	</div>
 						<div >	
							<li><label for="valor">Valor do Produto(R$):</label>
								<input type="text"  name="valor" id="valor" pattern="[0-9|.|,]{1,13}" onKeyPress="return(MascaraMoeda(this,'.',',',event))" 
								placeholder="Valor do Produto em R$ - Valor máximo 99.999.999,99" 
								title="Valor do Produto em R$ - Valor máximo 99.999.999,99" value="<?php echo $resdb->prod_valor;?>" required/>
							</li>
		            	</div>
 						<div >	
							<li><label for="desconto">Porcentagem de Desconto a ser aplicado no Valor do Produto(%):</label>
								<input type="text"  name="desconto" id="desconto" pattern="[0-9]{1,2}"
								placeholder="Desconto a ser aplicado no Valor do Produto em % - Máximo 99" 
								title="Desconto a ser aplicado no Valor do Produto em % - Máximo 99" value="<?php echo $resdb->prod_desconto;?>" />
							</li>
		            	</div>
						<div >	
							<li><label for="promocao">Valor Promocional do Produto(R$):</label>
								<input type="text"  name="promocao" id="promocao" pattern="[0-9|.|,]{1,13}"  onKeyPress="return(MascaraMoeda(this,'.',',',event))" 
								placeholder="Valor Promocional do Produto em R$ - Valor máximo 99.999.999,99" 
								title="Valor Promocional do Produto em R$ - Valor máximo 99.999.999,99"  value="<?php echo $resdb->prod_promocao;?>"/>
							</li>
		            	</div>
						<div >	
							<li><label for="estoque">Estoque do Produto:</label>
								<input type="text"  name="estoque" id="estoque" pattern="[0-9]{1,5}" 
								placeholder="Quantidade de Estoque do Produto - Máximo 99999" 
								title="Quantidade de Estoque do Produto - Máximo 99999" value="<?php echo $resdb->prod_estoque;?>" required/>
							</li>
		            	</div>
		            	<?php
							$n_nm = 21;
							$n_cats = 0;		
							echo '<li><label for="'.$resdb_scat->nome.'">Personalize : </label>';		
							//if (isset($_POST['editar'])):
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
												if($$x_nm == $resdb_iscat->nome) $select_item = 'selected=""'; else $select_item = "";
												echo '	<option '.$select_item.' value="'.$resdb_iscat->nome.'">'.$resdb_iscat->nome.'</option>';
											endwhile;
											echo '</select>';
										endif; 
										//echo '<br> monta form --'.$x_sc.' : '.$$x_sc.' --- '.$x_nm. ': '.$$x_nm;
								endfor;		            	
		            		echo '</li>';
		            	?>
						<div >
						<li><label for="encomenda">Este produto aceitará encomendas quando o estoque for zero(0)?</label>
							<select name="encomenda">
								<option <?php if($resdb->prod_encomenda == 0) echo 'selected="selected"';?> value=0>Não</option>
								<option <?php if($resdb->prod_encomenda == 1) echo 'selected="selected"';?> value=1>Sim</option>
							</select>
						<li><label for="fixar_home">Este Produto deverá aparecer sempre na Página Home(Principal) do Site?</label>
							<select name="fixar_home">
								<option <?php if($resdb->prod_fixar_home == 0) echo 'selected="selected"';?> value=0>Não</option>
								<option <?php if($resdb->prod_fixar_home == 1) echo 'selected="selected"';?> value=1>Sim</option>
							</select>							
						<li><label for="status">Status:</label>
							<select name="status">
								<option <?php if($resdb->prod_status == 0) echo 'selected="selected"';?>  value=0>Inativo</option>
								<option <?php if($resdb->prod_status == 1) echo 'selected="selected"';?>  value=1>Ativo</option>
								<option <?php if($resdb->prod_status == 2) echo 'selected="selected"';?>  value=2>Aguardando Aprovação</option>
								<option <?php if($resdb->prod_status == 3) echo 'selected="selected"';?>  value=3>Pendente</option>
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
	break;
	case 'personaliza':
		echo "<h2>Personalização de Produtos</h2>";
		if (isAdmin()== TRUE ):
			if (!isset($_REQUEST['id']))	        $id            = "";     else $id            = $_REQUEST['id'];
			if (!isset($_REQUEST['sku']))  	        $sku           = "";     else $sku           = $_REQUEST['sku'];
			if (!isset($_REQUEST['nome']))  	    $nome          = "";     else $nome          = $_REQUEST['nome'];
			if (!isset($_REQUEST['titulo']))  	    $titulo        = "";     else $titulo        = $_REQUEST['titulo'];
			if (!isset($_REQUEST['valor']))         $valor         = "";     else $valor         = $_REQUEST['valor'];
			if (!isset($_REQUEST['desconto']))      $desconto      = "";     else $desconto      = $_REQUEST['desconto'];
			if (!isset($_REQUEST['promocao'])) 	    $promocao      = "";     else $promocao      = $_REQUEST['promocao'];
			if (!isset($_REQUEST['estoque']))  	    $estoque       = "";     else $estoque       = $_REQUEST['estoque'];
			if (!isset($_REQUEST['encomenda']))	    $encomenda     = "";     else $encomenda     = $_REQUEST['encomenda'];
			if (!isset($_REQUEST['fixar_home']))    $fixar_home    = "";     else $fixar_home    = $_REQUEST['fixar_home'];
			if (!isset($_REQUEST['categorias']))    $categorias    = "";     else $categorias    = $_REQUEST['categorias'];
			if (!isset($_REQUEST['qtde_vendida']))  $qtde_vendida  = "";     else $qtde_vendida  = $_REQUEST['qtde_vendida'];
			if (!isset($_REQUEST['valor_vendido'])) $valor_vendido = "";     else $valor_vendido = $_REQUEST['valor_vendido'];
			if (!isset($_REQUEST['status']))        $status        = "";     else $status        = $_REQUEST['status'];
			if (!isset($_REQUEST['relevancia']))    $relevancia    = "";     else $relevancia    = $_REQUEST['relevancia'];
			//Verifica as categoirias e sub-categorias
			$n_sc = 20;
			$n_xx_ok = 0;
			for ($i = 0; $i <= $n_sc; $i++):
					$n_xx_ok ++;
					$x_sc = "sub_cat_";
					$x_sc =$x_sc . $n_xx_ok ; 
					$$x_sc  = 0;
					if (! empty($_REQUEST[$x_sc])):
					  $$x_sc  = $_REQUEST[$x_sc];
					endif; 
					$x_nm = "nome_";
					$x_nm =$x_nm . $n_xx_ok ; 
					$$x_nm  = 0;
					if (! empty($_REQUEST[$x_nm])):
					  $$x_nm  = $_REQUEST[$x_nm];
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
					grava_log($userid,$user_ip,$rotina.'-Det',$acao,$registro,$datacad); 						
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
	break;
	case 'excluir':
		echo "<h2>Exclusão de Pordutos</h2>";
		//$session = new session();
		if (isAdmin()== TRUE ):
			date_default_timezone_set('America/Sao_Paulo');
			$datacad   = date('Y-m-d H:i:s');
			if (isset($_REQUEST['id'])):
				//faz edição do Produto
				$id = $_REQUEST['id'];
				$lerdb = new produtos();
				//$lerdb->pk_value = $id;
				$lerdb->extra_select = "WHERE id=".$id;
				$lerdb->selectAll($lerdb);
				$resdb = $lerdb->returnData();	

				if (isset($_POST['exclusao'])):
					$deldb = new produtos();
					$deldb->pk_value = $id;
					$deldb->deleteDB($deldb);
					if ($deldb->countline==1):
					// Início  - Rotina de gravar logs
						if(isset($resdb->id ))             $reg_id            = "<p>Reg no DB: ".$resdb->id."</p>";                  else $reg_id            ="";
						if(isset($resdb->sku ))            $reg_sku           = "<p>Sku do Produto: ".$resdb->sku."</p>";            else $reg_sku           ="";
						if(isset($resdb->user_id ))        $reg_user          = "<p>User Resp: ".$resdb->user_id."</p>";             else $reg_user          ="";
						if(isset($resdb->datacad ))        $reg_data          = "<p>Cadastro: ".$resdb->datacad."</p>";              else $reg_data          ="";
						if(isset($resdb->status ))         $reg_status        = "<p>Status: ".$resdb->status."</p>";                 else $reg_status        ="";
						if(isset($resdb->relevancia ))     $reg_relevancia    = "<p>Relevancia: ".$resdb->relevancia."</p>";         else $reg_relevancia    ="";
						if(isset($resdb->nome ))           $reg_nome          = "<p>Nome Produto: ".$resdb->nome."</p>";             else $reg_nome          ="";
						if(isset($resdb->titulo ))         $reg_titulo        = "<p>Descrição: ".$resdb->titulo."</p>";              else $reg_titulo        ="";
						if(isset($resdb->valor ))          $reg_valor         = "<p>Valor: ".$resdb->valor."</p>";                   else $reg_valor         ="";
						if(isset($resdb->desconto ))       $reg_desconto      = "<p>Desconto:  ".$resdb->desconto."</p>";            else $reg_desconto      ="";
						if(isset($resdb->promocao ))       $reg_promocao      = "<p>Promocão:  ".$resdb->promocao."</p>";            else $reg_promocao      ="";
						if(isset($resdb->estoque ))        $reg_estoque       = "<p>Estoque:  ".$resdb->estoque."</p>";              else $reg_estoque       ="";
						if(isset($resdb->encomenda ))      $reg_encomenda     = "<p>Encomenda:  ".$resdb->encomenda."</p>";          else $reg_encomenda     ="";
						if(isset($resdb->fixar_home ))     $reg_fixar_home    = "<p>Fixo na Home:  ".$resdb->fixar_home."</p>";      else $reg_fixar_home    ="";
						if(isset($resdb->qtde_vendida ))   $reg_qtde_vendida  = "<p>Qtde Vendida:  ".$resdb->qtde_vendida."</p>";    else $reg_qtde_vendida  ="";
						if(isset($resdb->valor_vendido ))  $reg_valor_vendido = "<p>Valor Vendido:  ".$resdb->valor_vendido."</p>";  else $reg_valor_vendido ="";
						if(isset($resdb->categorias ))     $reg_categorias    = "<p>Categoria:  ".$resdb->categorias."</p>";         else $reg_categorias    ="";
						$registro  =$reg_id.$reg_sku.$reg_nome.$reg_titulo.$reg_valor.$reg_desconto.$reg_promocao.$reg_estoque.$reg_encomenda;
						$registro .=$reg_fixar_home.$reg_qtde_vendida.$reg_valor_vendido.$reg_status.$reg_relevancia.$reg_categorias.$reg_data.$reg_user;
						grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 	
						del_prod_detalhes($id,'listar',$userid,$user_ip,$acao,$rotina);		//chama rotina para deletar detalhes do produto		
				 	else:
						echo 'Erro ao excluir Produto:';
						echo $registro;
					endif;
					
				endif;
			else:
				getMSG('cb-906','alerta',NULL);
			endif;
			?>
			<form class="userform" method="post" action="">
				<fieldset>
					<legend>Exclusão - Produtos</legend>
					<ul>
						<li>
							<label for="nome">Produto:
								<?php echo $resdb->nome;?>
 							</label>
 							<?php
								echo "<br>Descrição : ".$resdb->titulo;
								echo "<br>valor : ".$resdb->valor;
								echo "<br>Desconto : ".$resdb->desconto;
								echo "<br>Promoção : ".$resdb->promocao;
								echo "<br>Estoque : ".$resdb->estoque;
								echo "<br>Encomenda: ".$resdb->encomenda;
								echo "<br>Fixo na Home : ".$resdb->fixar_home;
								echo "<br>Qtde Vendida : ".$resdb->qtde_vendida;
								echo "<br>Valor Vendido : ".$resdb->valor_vendido;
								echo "<br>Categoria : ".$resdb->categoria;
								echo "<br>sku : ".$resdb->sku;
								echo "<br>status : ".$resdb->status;
								echo "<br>relevancia : ".$resdb->relevancia;
								echo '<hr>';
								echo '<label for="detalhes">Personalizações:</label>';
								$lerdb = new detalhes_produtos();
								$lerdb->extra_select = "WHERE produtos_id=$id";
								$lerdb->selectAll($lerdb);
								$resdb_prod_det = $lerdb->returnData();	
								$n_nm = 21;
								$n_cats = 0;
									for ($i = 1; $i < $n_nm; $i++):
											$x_sc = "sub_cat_";
											$x_nm = "nome_";
											$x_nm =$x_nm . $i; 
											$x_sc =$x_sc . $i; 
											$$x_nm  = 0;
											if (! empty($resdb_prod_det->$x_nm)):
											  $$x_nm  = $resdb_prod_det->$x_nm;
											endif; 
											$$x_sc  = 0;
											if (! empty($resdb_prod_det->$x_sc) != 0):
											  	$$x_sc  = $resdb_prod_det->$x_sc;
												$lerdb_scat = new sub_cat();
												$lerdb_scat->extra_select="where status = 1 and id =".$$x_sc." LIMIT 1";	
												$lerdb_scat->selectAll($lerdb_scat);
												$resdb_scat= $lerdb_scat->returnData();
												echo '<br>'.$resdb_scat->nome.' / '.$resdb_scat->titulo;
												$lerdb_iscat = new item_sub_cat();
												$lerdb_iscat->extra_select="where status = 1 and sub_cat_id =".$$x_sc;	
												$lerdb_iscat->selectAll($lerdb_iscat);
												
												while ($resdb_iscat= $lerdb_iscat->returnData()):
													if($$x_nm == $resdb_iscat->nome) echo ' / '.$resdb_iscat->nome;
												endwhile;
											endif; 
											//echo '<br> monta form --'.$x_sc.' : '.$$x_sc.' --- '.$x_nm. ': '.$$x_nm;
									endfor;		
							?>  	
 						</li>
						<br><br>
						<li class="center">
						   	<input type="submit" name="exclusao" value="Confirma Exclusão" />
							<input type="button" onclick="location.href='?p=loja&m=produtos&s=listar'" value="Cancelar" />
		               </li>	
					</ul>
				</fieldset>
			</form>	
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
//Excluir Detalhes do Produtos
function del_prod_detalhes($id=null,$retorno=null,$userid=null,$user_ip=null,$acao=null,$rotina=null)
{
				if (isset($id) != null):
					date_default_timezone_set('America/Sao_Paulo');
					$datacad   = date('Y-m-d H:i:s');					
					$lerdb = new detalhes_produtos();
					$lerdb->extra_select = "WHERE produtos_id=$id";
					$lerdb->selectAll($lerdb);
					$resdb = $lerdb->returnData();	
					$deldb = new detalhes_produtos();
					$deldb->pk_value = $resdb->id;
					$deldb->deleteDB($deldb);
					if ($deldb->countline==1):
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
						grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 	
						if ($retorno == 'voltar'):
							return;
						else:
							echo '<script> location.href="?p=loja&m=produtos&s='.$retorno.'" </script>';
						endif;
					else:
						echo 'Erro ao excluir  Detalhes Produto:';
						echo $registro;
					endif;
				endif;
} // fecha função de deletar detalhes do produto
function ins_prod_detalhes($id=null,$retorno=null,$userid=null,$user_ip=null,$acao=null,$rotina=null,$titulo=null,$nome=null)
{
					//Rotina para atualizar Detalhes do Produto
					$lerdb_prod = new produtos();
					if ($id == null ):
						$lerdb_prod->extra_select="where user_id =".$userid." and titulo ='".$titulo."' and nome='".$nome."' LIMIT 1";
					else:
						$lerdb_prod->extra_select="where id =".$id." LIMIT 1";
					endif;	
					$lerdb_prod->selectAll($lerdb_prod);
					$resdb_prod= $lerdb_prod->returnData();					
					
					
					$lerdb_scat = new cat_subcat();
					$lerdb_scat->extra_select="where id =".$resdb_prod->categorias_id;	
					$lerdb_scat->selectAll($lerdb_scat);
					$n_sc_ok = 0;
					while ($resdb_scat= $lerdb_scat->returnData()):
						$n_sc_ok ++;
						$x_sc = "sub_cat_";
						$x_sc =$x_sc . $n_sc_ok; 
						$$x_sc  = $resdb_scat->sc_id;
						//echo '<br>Criando detalhes do produto :'.$x_sc. ': '.$$x_sc;
					endwhile;


					//echo"<br>-----------------------id---->".$resdb_prod->id;
					$gravadb = new detalhes_produtos(array(
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
					'produtos_id'=>$resdb_prod->id,
					'data_cad'   =>$datacad,
					'user_id'    =>$userid,
					));
					//$gravadb ->pk_value = $id;
					$gravadb ->insertDB($gravadb );
					// Início  - Rotina de gravar logs
					if(isset($resdb_prod->id )) $reg_id         = "<p>Reg no DB: ".$resdb_prod->id."</p>";else $reg_id         		="";
					if(isset($user_id ))        $reg_user       = "<p>User Resp: " .$user_id."</p>";      else $reg_user       		="";
					if(isset($datacad ))        $reg_data       = "<p>Ult. Alteração: ".$datacad."</p>";  else $reg_data       		="";
					if(isset($resdb_prod->id )) $reg_id         = "<p>Detalhes do Produto: ".$resdb_prod->id."</p>";  else $reg_id  ="";
					if(isset($sub_cat_1 ))      $reg_sub_cat_1  = "<p>Sub Cat 1:  ".$sub_cat_1."</p>";    else $reg_sub_cat_1  		="";
					if(isset($sub_cat_2 ))      $reg_sub_cat_2  = "<p>Sub Cat 2:  ".$sub_cat_2."</p>";    else $reg_sub_cat_2  		="";
					if(isset($sub_cat_3 ))      $reg_sub_cat_3  = "<p>Sub Cat 3:  ".$sub_cat_3."</p>";    else $reg_sub_cat_3  		="";
					if(isset($sub_cat_4 ))      $reg_sub_cat_4  = "<p>Sub Cat 4:  ".$sub_cat_4."</p>";    else $reg_sub_cat_4  		="";
					if(isset($sub_cat_5 ))      $reg_sub_cat_5  = "<p>Sub Cat 5:  ".$sub_cat_5."</p>";    else $reg_sub_cat_5  		="";
					if(isset($sub_cat_6 ))      $reg_sub_cat_6  = "<p>Sub Cat 6:  ".$sub_cat_6."</p>";    else $reg_sub_cat_6  		="";
					if(isset($sub_cat_7 ))      $reg_sub_cat_7  = "<p>Sub Cat 7:  ".$sub_cat_7."</p>";    else $reg_sub_cat_7  		="";
					if(isset($sub_cat_8 ))      $reg_sub_cat_8  = "<p>Sub Cat 8:  ".$sub_cat_8."</p>";    else $reg_sub_cat_8  		="";
					if(isset($sub_cat_9 ))      $reg_sub_cat_9  = "<p>Sub Cat 9:  ".$sub_cat_9."</p>";    else $reg_sub_cat_9  		="";
					if(isset($sub_cat_10))      $reg_sub_cat_10 = "<p>Sub Cat 10: ".$sub_cat_10."</p>";   else $reg_sub_cat_10 		="";
					if(isset($sub_cat_11))      $reg_sub_cat_11 = "<p>Sub Cat 11: ".$sub_cat_11."</p>";   else $reg_sub_cat_11 		="";
					if(isset($sub_cat_12))      $reg_sub_cat_12 = "<p>Sub Cat 12: ".$sub_cat_12."</p>";   else $reg_sub_cat_12 		="";
					if(isset($sub_cat_13))      $reg_sub_cat_13 = "<p>Sub Cat 13: ".$sub_cat_13."</p>";   else $reg_sub_cat_13 		="";
					if(isset($sub_cat_14))      $reg_sub_cat_14 = "<p>Sub Cat 14: ".$sub_cat_14."</p>";   else $reg_sub_cat_14 		="";
					if(isset($sub_cat_15))      $reg_sub_cat_15 = "<p>Sub Cat 15: ".$sub_cat_15."</p>";   else $reg_sub_cat_15 		="";
					if(isset($sub_cat_16))      $reg_sub_cat_16 = "<p>Sub Cat 16: ".$sub_cat_16."</p>";   else $reg_sub_cat_16 		="";
					if(isset($sub_cat_17))      $reg_sub_cat_17 = "<p>Sub Cat 17: ".$sub_cat_17."</p>";   else $reg_sub_cat_17 		="";
					if(isset($sub_cat_18))      $reg_sub_cat_18 = "<p>Sub Cat 18: ".$sub_cat_18."</p>";   else $reg_sub_cat_18 		="";
					if(isset($sub_cat_19))      $reg_sub_cat_19 = "<p>Sub Cat 19: ".$sub_cat_19."</p>";   else $reg_sub_cat_19 		="";
					if(isset($sub_cat_20))      $reg_sub_cat_20 = "<p>Sub Cat 20: ".$sub_cat_20."</p>";   else $reg_sub_cat_20 		="";
					if(isset($nome_1 ))         $reg_nome_1     = "<p>Detalhe 1:  ".$nome_1."</p>";       else $reg_nome_1     		="";
					if(isset($nome_2 ))         $reg_nome_2     = "<p>Detalhe 2:  ".$nome_2."</p>";       else $reg_nome_2     		="";	
					if(isset($nome_3 ))         $reg_nome_3     = "<p>Detalhe 3:  ".$nome_3."</p>";       else $reg_nome_3     		="";	
					if(isset($nome_4 ))         $reg_nome_4     = "<p>Detalhe 4:  ".$nome_4."</p>";       else $reg_nome_4     		="";	
					if(isset($nome_5 ))         $reg_nome_5     = "<p>Detalhe 5:  ".$nome_5."</p>";       else $reg_nome_5     		="";	
					if(isset($nome_6 ))         $reg_nome_6     = "<p>Detalhe 6:  ".$nome_6."</p>";       else $reg_nome_6     		="";	
					if(isset($nome_7 ))         $reg_nome_7     = "<p>Detalhe 7:  ".$nome_7."</p>";       else $reg_nome_7     		="";	
					if(isset($nome_8 ))         $reg_nome_8     = "<p>Detalhe 8:  ".$nome_8."</p>";       else $reg_nome_8     		="";	
					if(isset($nome_9 ))         $reg_nome_9     = "<p>Detalhe 9:  ".$nome_9."</p>";       else $reg_nome_9     		="";	
					if(isset($nome_10 ))        $reg_nome_10    = "<p>Detalhe 10: ".$nome_10."</p>";      else $reg_nome_10    		="";	
					if(isset($nome_11 ))        $reg_nome_11    = "<p>Detalhe 11: ".$nome_11."</p>";      else $reg_nome_11    		="";	
					if(isset($nome_12 ))        $reg_nome_12    = "<p>Detalhe 12: ".$nome_12."</p>";      else $reg_nome_12    		="";	
					if(isset($nome_13 ))        $reg_nome_13    = "<p>Detalhe 13: ".$nome_13."</p>";      else $reg_nome_13    		="";	
					if(isset($nome_14 ))        $reg_nome_14    = "<p>Detalhe 14: ".$nome_14."</p>";      else $reg_nome_14    		="";	
					if(isset($nome_15 ))        $reg_nome_15    = "<p>Detalhe 15: ".$nome_15."</p>";      else $reg_nome_15    		="";	
					if(isset($nome_16 ))        $reg_nome_16    = "<p>Detalhe 16: ".$nome_16."</p>";      else $reg_nome_16    		="";	
					if(isset($nome_17 ))        $reg_nome_17    = "<p>Detalhe 17: ".$nome_17."</p>";      else $reg_nome_17    		="";	
					if(isset($nome_18 ))        $reg_nome_18    = "<p>Detalhe 18: ".$nome_18."</p>";      else $reg_nome_18    		="";	
					if(isset($nome_19 ))        $reg_nome_19    = "<p>Detalhe 19: ".$nome_19."</p>";      else $reg_nome_19    		="";	
					if(isset($nome_20 ))        $reg_nome_20    = "<p>Detalhe 20: ".$nome_20."</p>";      else $reg_nome_20    		="";						
					$registro  =$reg_id.$reg_sub_cat_1.$reg_sub_cat_2.$reg_sub_cat_3.$reg_sub_cat_4.$reg_sub_cat_5.$reg_sub_cat_6;
					$registro .=$reg_sub_cat_7.$reg_sub_cat_8.$reg_sub_cat_9.$reg_sub_cat_10.$reg_sub_cat_11.$reg_sub_cat_12.$reg_sub_cat_13;
					$registro .=$reg_sub_cat_14.$reg_sub_cat_15.$reg_sub_cat_16.$reg_sub_cat_17.$reg_sub_cat_18.$reg_sub_cat_19.$reg_sub_cat_20;
					$registro .=$reg_nome_1.$reg_nome_2.$reg_nome_3.$reg_nome_4.$reg_nome_5.$reg_nome_6.$reg_nome_7.$reg_nome_8.$reg_nome_9.$reg_nome_10;
					$registro .=$reg_nome_11.$reg_nome_12.$reg_nome_13.$reg_nome_14.$reg_nome_15.$reg_nome_16.$reg_nome_17.$reg_nome_18.$reg_nome_19.$reg_nome_20;
					$registro .=$reg_produto_id.$reg_data.$reg_user;
					if ($gravadb ->countline==1):
						grava_log($userid,$user_ip,$rotina,$acao,$registro,$datacad); 						
						if ($retorno == 'voltar'):
							return;
						else:
							echo '<script> location.href="?p=loja&m=produtos&s='.$retorno.$resdb_prod->id.'" </script>';
						endif;

					else:
					echo "Erro ao gravar o registro<br>";
					echo $registro;
					endif;
					//echo '<script> location.href="?m=paginas&s=listar" </script>';
					// Final  - Rotina de gravar logs	
}					
	function alt_prod_detalhes($id=null,$retorno=null,$userid=null,$user_ip=null,$acao=null,$rotina=null)
{
				if (isset($id) != null):
					date_default_timezone_set('America/Sao_Paulo');
					$datacad   = date('Y-m-d H:i:s');					
					$lerdb = new detalhes_produtos();
					$lerdb->extra_select = "WHERE produtos_id=$id";
					$lerdb->selectAll($lerdb);
					$resdb_prod_det = $lerdb->returnData();	
					$n_nm = 21;
					$n_cats = 0;
					for ($i = 1; $i < $n_nm; $i++):
							$x_sc = "sub_cat_";
							$x_nm = "nome_";
							$x_nm =$x_nm . $i; 
							$x_sc =$x_sc . $i; 
							$$x_nm  = 0;
							$$x_sc  = 0;
							if (! empty($resdb_prod_det->$x_sc) != 0):
								$$x_nm  = $resdb_prod_det->$x_nm;
							  	$$x_sc  = $resdb_prod_det->$x_sc;
							  	
								$lerdb_scat = new sub_cat();
								$lerdb_scat->extra_select="where status = 1 and id =".$$x_sc."  LIMIT 1";	
								$lerdb_scat->selectAll($lerdb_scat);
								$resdb_scat= $lerdb_scat->returnData();
								//echo '<br>'.$resdb_scat->nome.' / '.$resdb_scat->titulo;
								
								
								$lerdb_iscat = new item_sub_cat();
								$lerdb_iscat->extra_select="where status = 1 and sub_cat_id =".$$x_sc;	
								$lerdb_iscat->selectAll($lerdb_iscat);
								$alt_prod_det = 0;
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
							endif; 
							//echo '<br> monta form --'.$x_sc.' : '.$$x_sc.' --- '.$x_nm. ': '.$$x_nm;
					endfor;		
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

					if ($deldb->countline==1):
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
						if ($retorno == 'voltar'):
							return;
						else:
							echo '<script> location.href="?p=loja&m=produtos&s='.$retorno.'" </script>';
						endif;
					else:
						echo 'Erro ao excluir  Detalhes Produto:';
						echo $registro;
					endif;
				endif;
} // fecha função de alterar detalhes do produto					
?>