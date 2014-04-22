<?php
require_once(dirname(__FILE__)."/autoload.php");
protectFile(basename(__FILE__));
class users extends base{
	public function __construct($fields=array()){
		parent::__construct();
		$this->table="users";
		if(sizeof($fields)<=0):
			$this->field_value = array(
				"id"      => NULL,
				"nome"    => NULL,
				"email"   => NULL,
				"login"   => NULL,
				"senha"   => NULL,
				"status"  => NULL,
				"nivel"   => NULL,
				"datacad" => NULL,
				"imagem"  => NULL,
				"uuk"     => NULL,
				"horario" => NULL,
				"limite"  => NULL,				
			);
		else:
			$this->field_value = $fields;
		endif;
		$this->pk_field = 'id';
	} //Final Construct
//inicio da função login
	public function doLogin($object){
		//echo "<br> UUK : ".$object->getValue('uuk');
		if ($object->getValue('uuk') == "")
			$senha = modifyPassw($object->getValue('senha'));
		else {
			$senha = $object->getValue('senha');
		}
		$object->extra_select = "WHERE login='".$object->getValue('login')."' 
										AND senha='".$senha."' 
										AND status='1'";
		//echo "<br> extra_select : ".$object->extra_select;
		//exit;
		$this->selectAll($object);
		$session = new session();
		if ($this->countline==1):
			$userlogin = $object->returnData();
			$session->setVars('userid',$userlogin->id);
			$session->setVars('username',$userlogin->nome);
			$session->setVars('userlogin',$userlogin->login);
			$session->setVars('userstatus',$userlogin->status);
			$session->setVars('usernivel',$userlogin->nivel);
			$session->setVars('useruuk',$userlogin->uuk);
			$session->setVars('userip', $_SERVER['REMOTE_ADDR']);
		//echo "<pre>";
		// print_r($_SESSION);
		//echo "</pre>";
			return TRUE;
		else:
			//$session->destroy(TRUE);
			return FALSE;
		endif; 

	}//final da função login
//inicio da função logout
	public function doLogout(){
		$session = new session();
			$session->setVars('uid',"");
			$session->setVars('userid',"");
			$session->setVars('username',"");
			$session->setVars('userlogin',"");
			$session->setVars('userstatus',"");
			$session->setVars('usernivel',"");
			$session->setVars('useruuk',"");
			$session->setVars('usersession', TRUE);
			$session->setVars('userip', $_SERVER['REMOTE_ADDR']);
			redirectTo('index.php?error=cb-902&msgtype=sucesso');
}//final da função logout	
//inicio da função verifyReg - verifica se já existe reg no db
	public function verifyReg($field=NULL,$value=NULL){
		if ($field !=NULL && $value !=NULL):
			is_numeric($value) ? $value = $value : $value = "'".$value."'";
			$this->extra_select = "WHERE $field = $value";
			$this->selectAll($this);
			if ($this->countline > 0):
				return TRUE;
			else:
				return FALSE;
			endif;
		else:
			$this->getMSG('cb-950','alerta',__FUCTION__);	
		    //redirectTo('?error=cb-xxx');
		endif;		
	}//final da função verifyReg		
} //Final da Classe Usuario
?>