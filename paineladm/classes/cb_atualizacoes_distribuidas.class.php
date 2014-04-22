<?php
require_once(dirname(__FILE__)."/autoload.php");
protectFile(basename(__FILE__));
class cb_atualizacoes_distribuidas extends base{
	public function __construct($fields=array()){
		parent::__construct();
		$this->table="cb_atualizacoes_distribuidas";
		if(sizeof($fields)<=0):
			$this->field_value = array(
				"id"               => NULL,
				"nome"             => NULL,
				"data"             => NULL,
				"user_id"          => NULL,
				"cliente"          => NULL,
				"status"           => NULL,	
				"data_status"      => NULL,				
				"user_id_status"   => NULL
			);
		else:
			$this->field_value = $fields;
		endif;
		$this->pk_field = 'id';
	} //Final Construct
} //Final da Classe Blog
?>

