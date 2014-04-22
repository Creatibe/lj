<?php
require_once(dirname(__FILE__)."/autoload.php");
protectFile(basename(__FILE__));
class chat_mensagens extends base{
	public function __construct($fields=array()){
		parent::__construct();
		$this->table="chat_mensagens";
		if(sizeof($fields)<=0):
			$this->field_value = array(
				"id"               => NULL,
				"id_de"             => NULL,
				"id_para"             => NULL,
				"data"          => NULL,				
				"mensagem"          => NULL,
				"lido"           => NULL,
			);
		else:
			$this->field_value = $fields;
		endif;
		$this->pk_field = 'id';
	} //Final Construct
} //Final da Classe Blog
?>