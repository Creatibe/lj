<?php
error_reporting(0);
require_once(dirname(__FILE__)."/autoload.php");
protectFile(basename(__FILE__));
class session{
	protected $id;
	protected $nvars;
	//função construct - chama a função para dar start na sessão
	public function __construct($init=TRUE){
		if ($init==TRUE):
			$this->start();
		endif;
	}//final da função construct
	//função start - inicia a sessão
	public function start(){
		if(!isset($_SESSION)):
			session_start();
			$this->id = session_id();
			$this->setNvars();
			//echo "<pre>";
			// print_r($_SESSION);
			//echo "</pre>";			
		endif;
	}//final da função start
	//função setNvars - coloca os valores da sessão em nvars
	public function setNvars(){
		$this->nvars = sizeof($_SESSION);
	}//final da função setNvars	
	//função getNvars - retorna os valores da sessão em nvars
	public function getNvars(){
		return $this->nvars;
	}//final da função getNvars		
	//função setVars - atualiza os valores das variaveis da sessão
	public function setVars($vars, $var_value){
		$_SESSION[$vars] = $var_value;
		$this->setNvars();
	}//final da função setNvars			
	//função unsetVars - deleta os campos/valores das variaveis da sessão
	public function unsetVars($vars, $var_value){
		unset($_SESSION[$vars]);
		$this->setNvars();
	}//final da função unsetNvars			
	//função getVars - Retorna os valores das variaveis da sessão
	public function getVars($vars){
		if (isset($_SESSION[$vars])):
			return $_SESSION[$vars];
		else:
			return NULL;
		endif;
		$this->setNvars();
	}//final da função getNvars			
	//função destroy - Deleta e destroi a sessão
	public function destroy($vars){
		//session_unset();
		//session_destroy();
		$this->setNvars();
		if (isset($init)==TRUE):
			$this->start();
		endif;				
	}//final da função destroy			
	//função printSession - Imprimi valores da sessão
	public function printSession(){
		foreach($_SESSION as $k => $v):
			printf("%s = %s<br />",$k, $v);
		endforeach;
	}//final da função printSession		
}
?>