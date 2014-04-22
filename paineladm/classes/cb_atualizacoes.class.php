<?php
require_once(dirname(__FILE__)."/autoload.php");
protectFile(basename(__FILE__));
class cb_atualizacoes extends base{
	public function __construct($fields=array()){
		parent::__construct();
		$this->table="cb_atualizacoes";
		if(sizeof($fields)<=0):
			$this->field_value = array(
				"id"               => NULL,
				"data"             => NULL,
				"nome"             => NULL,	
				"texto"            => NULL,				
				"sistema"          => NULL,
				"user_id"          => NULL,
				"status"           => NULL,
			);
		else:
			$this->field_value = $fields;
		endif;
		$this->pk_field = 'id';
	} //Final Construct
} //Final da Classe Blog
?>

