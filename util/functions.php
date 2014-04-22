<?php
initialize(); //inicializa o sistema
//chama rotina para enviar e-mails

if(isset($_REQUEST['function']) == "enviar_email"){
enviar_email();
	return;
}
//fecha rotina para enviar e-mails
protectFile(basename(__FILE__)); //Protege arquivo de funções
//inicio da função de inicialização do sistema
function initialize(){
//	echo (dirname(__FILE__)."/config.php")."<br>";	
	if(file_exists(dirname(__FILE__)."/config.php")):
		require_once (dirname(__FILE__)."/config.php");
	else:
		//die(utf8_decode("*** Erro-cb-001 - Arquivo de configuração - Configurações do sistema - Contate o Administrador ***"));
		getMSG('cb-001','erro');
		die(utf8_decode("*** Contate o Administrador ***"));
	endif;
//Cria array com as constantes do arquivo config.php 	
	$constants = array('BASEPATH','BASEURL','BLOGURL','CLASSPATH','MODULESPATH','CSSPATH','JSPATH','DBHOST','DBUSER','DBPASS','DBNAME');
//Verificar se todas as constantes foram criadas no arquivo config.php	
	foreach($constants as $value):
		if(!defined($value)):
			//die(utf8_decode("*** Erro-cb-002 - Definições do Arquivo - Configurações do sistema - Contate o Administrador ***"));
			getMSG('cb-002','erro');
			die(utf8_decode("*** Contate o Administrador ***"));
		endif;
	endforeach;
	//echo BASEPATH.CLASSPATH."<br>";
	require_once(dirname(BASEPATH).CLASSPATH."autoload.php");
	if(isset($_GET['logoff'])):
		if($_GET['logoff']== TRUE):
			$user = new users();
			$user->doLogout();
			exit;
		endif;
	endif;
}//final da função de inicialização do sistema
//inicio da função de gravalog
function grava_log($user_id=NULL,$user_ip=NULL,$modulo=NULL,$acao=NULL,$registro=NULL){
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
//inicio da função de enviar e-mails
function enviar_email(){
	date_default_timezone_set('America/Sao_Paulo');
	$data   = date('Y-m-d H:i:s');	
	 // ----- Envio de e-mail
	 $user_ip = $_SERVER['REMOTE_ADDR'];
	// Inicia a classe PHPMailer
	// chamando o arquivo que contém a classe
	include("../modules/PHPMailer/class.phpmailer.php");
	// Instanciando a classe PHPMailer
	$mail = new PHPMailer();
	// Define os dados do servidor e tipo de conexão
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	//$mail->IsSMTP(); // Define que a mensagem será SMTP
	$mail->Host = "mail.casalibertar.com.br"; // Endereço do servidor SMTP
	$mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
	$mail->Port     = 26;                  // set the SMTP port
	$mail->Username = 'contato@casalibertar.com.br'; // Usuário do servidor SMTP
	$mail->Password = 'casa2014'; // Senha do servidor SMTP
	// atribuição de valores
	$nome	= 'Libertar - Casa de Recuperação';
	$from	= 'contato@casalibertar.com.br';
	$para	= 'ricardo@agenciacreatibe.com.br'; //destinatário
	$copia  = "felipe@agenciacreatibe.com.br"; ///cópia para
	$assunto = 'Contatos do Site' ; //assunto
	$mensagem = '<br> Contatos do Site';
	$mensagem .= '<br> Nome       : '.$_POST['Nome'];
	$mensagem .= '<br> E-mail     : '.$_POST['E-mail'];
	$mensagem .= '<br> IP         : '.$user_ip;
	$mensagem .= '<br> Telefone   : '.$_POST['Telefone'];
	$mensagem .= '<br> Adicionais : '.$_POST['Mensagem'];
	//echo $mensagem;
	// definido para usar a função mail()
	$mail->IsMail();
	// define o remetente
	$mail->SetFrom($from, $nome);
	// define os destinatario(s)
	$mail->AddAddress($para);
	// define os destinatario(s) em cópia 
	$mail->AddCC ($copia);
	// define o assunto do email
	$mail->Subject = $assunto;
	// define a mensagem (HTML)
	$mail->MsgHTML($mensagem);
	// envia o e-mail
	$enviado = $mail->Send();
	// status do envio
	if(!$enviado){
		$msg_retorno = "Olá ".$_POST['Nome'].", Ocorreu um erro ao enviar sua mensagem, por favor trente mais tarde.";
		//0echo '<script>alert("'.$msg_retorno.'");</script>'; 
	}else{
		$msg_retorno = "Olá ".$_POST['Nome'].", Sua mensagem foi enviada com sucesso!";
		//echo '<script>alert("'.$msg_retorno.'");</script>'; 
		//Grava dados na tabela de contatos
			$contatos = new contatos(array(
				'user_ip'=>$user_ip,
				'data'=>$data,
				'nome'=>$_POST['Nome'],
				'email'=>$_POST['Email'],
				'telefone'=>$_POST['Telefone'],
				'mensagem'=>$_POST['Mensagem'],
			));
			$contatos->insertDB($contatos);
		//final da função de Grava dados na tabela de contatos	
	}
	//echo "	<script>$.post('index.php', 'msg=texto', function(data){alert(data);});</script>";	
 	//header("Location: ../?msg=".$msg_retorno);
 	//echo "<script>  window.history.back()</script>";
	echo '<script>location.href="../index.php?m=contato&msg='.$msg_retorno.'"</script>';
	//echo '<script>location.href="../index.php?m=contato"</script>';

}
//final da função de enviar e-mails
//inicio da função de autoload do css
function loadCSS($file=NULL,$media="screen",$import=FALSE){
	if($file != NULL):
		if ($import == TRUE):
			echo '<style type="text/css"> @import url("'.CSSPATH.$file.'.css)" media="'.$media.';"</style>'."\n";
		else:
			echo '<link rel="stylesheet" type="text/css" href="'.CSSPATH.$file.'.css" media="'.$media.'" />'."\n";
		endif;
	endif;
} //final da função de autoload do css
//inicio da função de autoload do js
function loadJS($file=NULL,$remote=FALSE){
	if($file != NULL):
		if ($remote == FALSE) $file = JSPATH.$file.".js" ;
			echo '<script type="text/javascript" src="'.$file.'"></script>'."\n";
	endif;
} //final da função de autoload do js
//inicio da função de carregamento dos modules
function loadModules($module=NULL,$screen=NULL){
	if($module == NULL || $screen == NULL ):
		getMSG("cb-003",'alerta',__FUNCTION__);	
	else:
		if(file_exists(MODULESPATH."$module.php")):
			include_once(MODULESPATH."$module.php");
		else:
			//echo "<br>Modules -->".(MODULESPATH."$module.php")."<br>";		
			getMSG("cb-004",'alerta',$module);
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
	echo '<script>location.href="'.$url.'"</script>';
	//header("Location: ".$url);

} //final da função que redireciona as páginas
//inicio da função que modifica a senha
function modifyPassw($passw){
	return md5($passw);
} //final da função que modifica a senha
//inicio da função que verifica se o usuário é autenticado
function verifyLogin(){
	$session = new session();
	if ($session->getNvars()<=0 || $session->getVars('usersession')!=TRUE || $session->getVars('ip' != $_SERVER['REMOTE_ADDR'])):
		redirectTo('?error=cb-904&msgtype=erro');
	endif;
} //final da função que verifica se o usuário é autenticado

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
	$user    = new users(array(
		'admin'=>NULL,
	)); 
	$iduser = $session->getVars('userid');
	$user->extra_select = "WHERE id=$iduser";
	$user->selectField($user);
	$res = $user->returnData();
	if(strtolower($res->admin) == "s"):
		return TRUE;
	else:
		return FALSE;
	endif; 
}//final da função isAdmin
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
			    $msg_return= $cb_msg.' - Você não tem permissão acessar esta página. <a href="?m=users&s=listar" onclick="history.back()">Voltar</a>';
				break;		
			case "cb-910":
			    $msg_return= $cb_msg.' - Usuário '.$extras_msg.' idisponível - Informe outro login';
				break;		
			case "cb-911":
			    $msg_return= $cb_msg.' - Usuário cadastrado com sucesso. <a href="'.ADMURL.'?m=users&s=listar">Exibir Cadastros</a>';
				break;	
			case "cb-912":
			    $msg_return= $cb_msg.' - Nenhum registro foi excluído. <a href="?m=users&s=listar">Exibir Cadastro</a>';
				break;								
			case "cb-913":
			    $msg_return= $cb_msg.' - Registro Excluído com Sucesso. <a href="?m=users&s=listar">Exibir Cadastro</a>';
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