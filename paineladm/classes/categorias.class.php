<?php
require_once(dirname(__FILE__)."/autoload.php");
protectFile(basename(__FILE__));
class categorias extends base{
	public function __construct($fields=array()){
		parent::__construct();
		$this->table="categorias";
		if(sizeof($fields)<=0):
			$this->field_value = array(
				"id"               => NULL,
				"nome"             => NULL,
				"status"           => NULL,
				"relevancia"       => NULL,		
				"filtro"           => NULL,
				"menu"             => NULL,
				"data_cad"         => NULL,				
				"user_id"          => NULL,
				"depto_id"         => NULL,
			);
		else:
			$this->field_value = $fields;
		endif;
		$this->pk_field = 'id';
	} //Final Construct
} //Final da Classe Blog
?>