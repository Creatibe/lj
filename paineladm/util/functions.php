<?php
initialize(); //inicializa o sistema
//echo "<br> - functions - basename - ".(basename(__FILE__))."<br>";	
protectFile(basename(__FILE__)); //Protege arquivo de funções
//inicio da função de inicialização do sistema
function initialize(){
	//echo "<br> - valida functions - config - ".(dirname(__FILE__)."/config.php")."<br>";	
	if(file_exists(dirname(__FILE__)."/config.php")):
		//echo "<br> - valida functions - config - Passou aqui - ".(dirname(__FILE__)."/config.php")."<br>";	
		require_once (dirname(__FILE__)."/config.php");
	else:
		//die(utf8_decode("*** Erro-cb-001 - Arquivo de configuração - Configurações do sistema - Contate o Administrador ***"));
		getMSG('cb-001','erro');
		die(utf8_decode("*** Contate o Administrador ***"));
	endif;
//Cria array com as constantes do arquivo config.php 	
	$constants = array('BASEPATH','BASEURL','ADMURL','CLASSPATH','MODULESPATH','CSSPATH','JSPATH','DBHOST','DBUSER','DBPASS','DBNAME');
//Verificar se todas as constantes foram criadas no arquivo config.php	
	foreach($constants as $value):
		if(!defined($value)):
			//die(utf8_decode("*** Erro-cb-002 - Definições do Arquivo - Configurações do sistema - Contate o Administrador ***"));
			getMSG('cb-002','erro');
			die(utf8_decode("*** Contate o Administrador ***"));
		endif;
	endforeach;
	//echo "<br>".(dirname(dirname(__FILE__))."/".CLASSPATH."autoload.php");
	require_once(dirname(dirname(__FILE__))."/".CLASSPATH."autoload.php");
	/*if(isset($_GET['logoff'])):
		if($_GET['logoff']== TRUE):
			$user = new users();
			$user->doLogout();
			exit;
		endif;
	endif;
	 */
}






// DEFINE THE ACCESS CONTROL FUNCTION
function access_control($test=FALSE)
{
    // REMEMBER HOW WE GOT HERE
    $_SESSION["entry_uri"] = $_SERVER["REQUEST_URI"];

    // IF THE UID IS SET, WE ARE LOGGED IN
    if (isset($_SESSION["uid"])) return $_SESSION["uid"];

    // IF WE ARE NOT LOGGED IN - RESPOND TO THE TEST REQUEST
    if ($test) return FALSE;

    // IF THIS IS NOT A TEST, REDIRECT TO CALL FOR A LOGIN
    header("Location: painel.php");
    exit;
}

// DEFINE THE "REMEMBER ME" COOKIE FUNCTION
function remember_me($uuk)
{
   if (!isset($_COOKIE['uuk'])):
	    // CONSTRUCT A "REMEMBER ME" COOKIE WITH THE UNIQUE USER KEY
	    $cookie_name    = 'uuk';
	    $cookie_value   = $uuk;
	    $cookie_expires = time() + date('Z') + REMEMBER; 
	    $cookie_path    = '/';
	    $cookie_domain  = NULL;
	    $cookie_secure  = FALSE;
	    $cookie_http    = TRUE; // HIDE COOKIE FROM JAVASCRIPT (PHP 5.2+)
	
	    // SEE http://php.net/manual/en/function.setcookie.php
	    setcookie
	    ( $cookie_name
	    , $cookie_value
	    , $cookie_expires
	    , $cookie_path
	    , $cookie_domain
	    , $cookie_secure
	    , $cookie_http
	    )
	    ;
   endif;
}
function delete_remember_me($uuk)
{

	    // set the expiration date to one hour ago
	   // echo "<br>ROTINA PARA APAGAR O COOKIE";
	//	setcookie("uuk", "", time()-3600);
}



//final da função de inicialização do sistema
//inicio da função de gravalog
function grava_log($user_id=NULL,$user_ip=NULL,$modulo=NULL,$acao=NULL,$registro=NULL,$data=null){
	//date_default_timezone_set('America/Sao_Paulo');
	//$data   = date('Y-m-d H:i:s');	
	$logs = new logs(array(
		'user_id'=>$user_id,
		'user_ip'=>$user_ip,
		'data'=>$data,
		'modulo'=>$modulo,
		'acao'=>$acao,
		'registro'=>$registro,
	));
	$logs->insertDB($logs);
} //final da função de gravalog
//inicio da função de autoload do css
function loadCSS($file=NULL,$media="screen",$import=FALSE){
	if($file != NULL):
		if ($import == TRUE):
			echo '<style type="text/css"> @import url("'.BASEURL.CSSPATH.$file.'.css" media="'.$media.'";</style>'."\n";
		else:
			echo '<link rel="stylesheet" type="text/css" href="'.BASEURL.CSSPATH.$file.'.css" media="'.$media.'" />'."\n";
		endif;
	endif;
} //final da função de autoload do css
//inicio da função de autoload do js
function loadJS($file=NULL,$remote=FALSE){
	if($file != NULL):
		if ($remote == FALSE) $file = BASEURL.JSPATH.$file.".js" ;
			echo '<script type="text/javascript" src="'.$file.'"></script>'."\n";
	endif;
} //final da função de autoload do js
//inicio da função de carregamento dos modules
function loadModules($module=NULL,$screen=NULL){
	if($module == NULL || $screen == NULL ):
		getMSG("cb-003",'alerta',__FUNCTION__);	
	else:
		
		if($screen !=  "module_painel"):
			if(file_exists(MODULESPATH."$module.php")):
				include_once(MODULESPATH."$module.php");
			else:
				//echo "<br>Modules -->".(MODULESPATH."$module.php")."<br>";		
				getMSG("cb-004",'alerta',$module);
			endif;
		else:
			if(file_exists("../$module.php")):
				include_once("../$module.php");
			else:
				//echo "<br>Modules --> ../".(MODULESPATH."$module.php")."<br>";		
				getMSG("cb-004",'alerta',$module);
			endif;
		endif;
	endif;
} //final da função de carregamento dos modules
//inicio da função que protege as páginas
function protectFile($filename=NULL,$redirecturl="../index.php?error=cb-950&msgtype=erro"){
	if($filename == NULL):
		getMSG("cb-003",'alerta',__FUNCTION__);	
	endif;
	$url = $_SERVER["PHP_SELF"];
	if (preg_match("/$filename/i", $url )):
		redirectTo($redirecturl);
	endif;
} //final da função que protege as páginas
//inicio da função que redireciona as páginas
function redirectTo($url=""){

	//header("location: ".$url); 
 //now the headers are sent
	//header("Location: ".$url);
	//BASEURL;
} //final da função que redireciona as páginas
//inicio da função que modifica a senha
function modifyPassw($passw){
	return md5($passw);
} //final da função que modifica a senha
//inicio da função que verifica se o usuário é autenticado
function verifyLogin(){
	$session = new session();
	if ($session->getNvars()<=0 || $session->getVars('usersession')!=TRUE || $session->getVars('ip' != $_SERVER['REMOTE_ADDR'])):
		redirectTo('index.php?error=cb-904&msgtype=erro');
		//echo "<pre>";
		// print_r($_SESSION);
		//echo "</pre>";
		//exit;	
	endif;
} //final da função que verifica se o usuário é autenticado
//Início da função que deletar um diretório e seus arquivos
function deleteDirectory ( $dir )  { 
    if  (! file_exists ( $dir ))  return  true ; 
    if  (! is_dir ( $dir ))  return unlink ( $dir ); 
    foreach  ( scandir ( $dir )  as $item )  { 
        if  ( $item ==  '.'  || $item ==  '..' )  continue ; 
		echo "<br>Deletando o arqUivo : " . $item;
        if  (! deleteDirectory ( $dir . DIRECTORY_SEPARATOR . $item ))  return  false ; 
    } 
    return rmdir ( $dir ); 
}
//final da função que deletar um diretório e seus arquivos




//inicio da função printMSG - Envia mensagens internas do sistema
function printMSG($msg=NULL,$type=NULL){
	if($msg != NULL ):
		switch ($type):
			case "error":
			    echo '<div class="erro">'.$msg.'</div>';			
				break;
			case "alerta":
			    echo '<div class="alerta">'.$msg.'</div>';			
				break;				
			case "pergunta":
			    echo '<div class="pergunta">'.$msg.'</div>';			
				break;				
			case "sucesso":
			    echo '<div class="sucesso">'.$msg.'</div>';			
				break;				
			default:
			    echo '<div class="sucesso">'.$msg.'</div>';			
				break;
		endswitch;
	endif; 
}//final da função PrinMSG
//inicio da função isAdmin - Verifica se é administrador
function isAdmin(){
	//verifyLogin();
	$session = new session();
	$user    = new users(array(	'nivel'=>NULL,)); 
	$iduser = $session->getVars('userid');
	$user->extra_select = "WHERE id=$iduser";
	$user->selectField($user);
	$res = $user->returnData();
	if(strtolower($res->nivel) == 999):
		return TRUE;
	else:
		return FALSE;
	endif; 
}//final da função isAdmin
//inicio da função que cria as páginas atualizadas pelo paineladm
function createPage($pg_id=NULL,$pg_paginas=NULL, $pg_modelo=NULL){
if ($pg_paginas == "servicos"):
	$paginas = new servicos();
	$paginas->extra_select="where id = $pg_id LIMIT 1 ";	
	$paginas->selectAll($paginas);
endif;
if ($pg_paginas == "portfolio"):
	$paginas = new portfolio();
	$paginas->extra_select="where id = $pg_id LIMIT 1 ";	
	$paginas->selectAll($paginas);
endif;
$mostrar = 0;
while ($res = $paginas->returnData()):
	if ($mostrar != $res->id):
		$pg_file_new = trim($res->pg_nome).".php";
		$pg_file_mod = trim($res->pg_modelo).".php";
		$pg_titulo_0 = trim($res->pg_titulo_0);
		$pg_titulo_1 = trim($res->pg_titulo_1);
		$pg_descr_1  = trim($res->pg_descr_1);
		$pg_titulo_2 = trim($res->pg_titulo_2);
		$pg_descr_2  = trim($res->pg_descr_2);
		$pg_titulo_3 = trim($res->pg_titulo_3);
		$pg_descr_3  = trim($res->pg_descr_3);
		$pg_imagem_1 = trim($res->pg_imagem_1);
		$pg_video_1  = trim($res->pg_video_1);
	endif;
	$mostrar = $res->id;
endwhile;
if ($pg_modelo != NULL) $pg_file_mod = $pg_modelo;
$pg_file_path=((dirname(dirname(__FILE__)))."/paginas/$pg_paginas/");
$pg_file_mod =$pg_file_path.$pg_file_mod;
$pg_file_new =$pg_file_path.$pg_file_new;
if (file_exists($pg_file_new)) unlink($pg_file_new);
if($file = fopen($pg_file_mod, "r"))
{
    while(!feof($file))
    {
		$row_pg = fgets($file);
		$row_pg = str_replace("monta_titulo_0", $pg_titulo_0, $row_pg);
		$row_pg = str_replace("monta_titulo_1", $pg_titulo_1, $row_pg);
		$row_pg = str_replace("monta_descr_1", $pg_descr_1, $row_pg);
		$row_pg = str_replace("monta_titulo_2", $pg_titulo_2, $row_pg);
		$row_pg = str_replace("monta_descr_2", $pg_descr_2, $row_pg);
		$row_pg = str_replace("monta_titulo_3", $pg_titulo_3, $row_pg);
		$row_pg = str_replace("monta_descr_3", $pg_descr_3, $row_pg);
		$row_pg = str_replace("monta_imagem_1", $pg_imagem_1, $row_pg);
		$row_pg = str_replace("monta_video_1", $pg_video_1, $row_pg);
		file_put_contents($pg_file_new, $row_pg . PHP_EOL, FILE_APPEND);		
    }
}
else {
    die('Erro: O arquivo '.$pg_file_mod.' não existe!');
}
}//final da função que cria as páginas atualizadas pelo paineladm
//inicio da função de tratamento de erros internos do sistema
function getMSG($cb_msg=NULL,$type_msg=NULL,$extras_msg=NULL){
	//$msg_return = "Bem Vindo ao Painel Administrativo!";
	if($cb_msg != NULL ):
		switch ($cb_msg):
			case "cb-000":
				$msg_return= $cb_msg.' - Erro fatal de diretórios - Contate o Administrado.';
				break;
			case "cb-001":
				$msg_return= $cb_msg.' - Erro no config do sistema - Arquivo inexistente.';
				break;				
			case "cb-002":
				$msg_return= $cb_msg.' - Erro nas configurações do sistema - Faltam parametros.';
				break;				
			case "cb-003":
				$msg_return= $cb_msg.' - Função <strong>'.$extras_msg.'</strong> : Faltam parametros.';
				break;				
			case "cb-004":
				$msg_return= $cb_msg.' - Modulo <strong>'.$extras_msg.'</strong> inexistente';
				break;				
			case "cb-005":
				$msg_return= $cb_msg.' - Tela <strong>'.$extras_msg.' </strong>inexistente';
				break;	
			case "cb-801":
			    $msg_return= $cb_msg.' - Personalização náo foi fornecida - Favor informar.';
				break;				
			case "cb-802":
			    $msg_return= $cb_msg.' - ERRO AO GRAVAR - Registro duplicado - <strong>'.$extras_msg.'</strong>';
				break;		
			case "cb-901":
			    $msg_return= $cb_msg.' - Acesso ao Sistema com Sucesso';
				break;	
			case "cb-902":
			    $msg_return= $cb_msg.' - Logoff ao Sistema com Sucesso';
				break;		
			case "cb-903":
			    $msg_return= $cb_msg.' - Usuário/senha inválidos ou usuário inativo';
				break;		
			case "cb-904":
			    $msg_return= $cb_msg.' - Acesso Não Permitido - Faça Login no Sistema';
				break;		
			case "cb-905":
			    $msg_return= $cb_msg.' - E-mail '.$extras_msg.' indisponível - Informe outro endereço válido';
				break;
			case "cb-906":
			    $msg_return= $cb_msg.' - Usuário não informado. <a href="?m=users&s=listar">Escolha um usuário';
				break;
			case "cb-907":
			    $msg_return= $cb_msg.' - Nenhum dado foi alterado. <a href="?m=users&s=listar">Exibir Cadastro</a>';
				break;								
			case "cb-908":
			    $msg_return= $cb_msg.' - Dados Alterados com Sucesso. <a href="?m=users&s=listar">Exibir Cadastro</a>';
				break;														
			case "cb-909":
			    $msg_return= $cb_msg.' - Você não tem permissão para acessar esta página. '.$extras_msg;
				break;		
			case "cb-910":
			    $msg_return= $cb_msg.' - Usuário '.$extras_msg.' idisponível - Informe outro login';
				break;		
			case "cb-911":
			    $msg_return= $cb_msg.' - Registro gravado com sucesso. '.$extras_msg;
				break;	
			case "cb-912":
			    $msg_return= $cb_msg.' - Nenhum registro foi excluído. '.$extras_msg;
				break;								
			case "cb-913":
			    $msg_return= $cb_msg.' - Registro Excluído com Sucesso. '.$extras_msg;
				break;															
			case "cb-950":
			    $msg_return= $cb_msg.' - Faltam parametros para executar a função '.$extras_msg.'.';			
				break;									
			default:
			    $msg_return= $cb_msg.' - Erro inesperado no sistema - Contate o Administrador';			
				break;
		endswitch;
	endif;
	if (isset($msg_return) != "") echo '<div class="'.$type_msg.'">'.$msg_return.'</div>';
} //final da função getError - Mensagens de erros internos do Sistema
?>