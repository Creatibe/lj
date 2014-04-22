<?php
require_once(dirname(__FILE__)."/autoload.php");
protectFile(basename(__FILE__));
class contatos extends base{
	public function __construct($fields=array()){
		parent::__construct();
		$this->table="contatos";
		if(sizeof($fields)<=0):
			$this->field_value = array(
				"id"               => NULL,
				"user_ip"          => NULL,				
				"nome"             => NULL,
				"email"            => NULL,
				"telefone"         => NULL,
				"mensagem"         => NULL,
				"data"             => NULL,
				"lido"             => NULL,
				"data_lido"        => NULL,
				"respondido"       => NULL,
				"data_resp"        => NULL,
			);
		else:
			$this->field_value = $fields;
		endif;
		$this->pk_field = 'id';
	}
} //Final Construct
?>