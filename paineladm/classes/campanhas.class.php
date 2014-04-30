<?php
require_once(dirname(__FILE__)."/autoload.php");
protectFile(basename(__FILE__));
class campanhas extends base{
	public function __construct($fields=array()){
		parent::__construct();
		$this->table="campanhas";
		if(sizeof($fields)<=0):
			$this->field_value = array(
				"id"               => NULL,
				"nome"             => NULL,
				"titulo"           => NULL,
				"selo_id"          => NULL,				
				"borda_id"         => NULL,
				"desconto"         => NULL,
				"data_ini"         => NULL,
				"data_fim"         => NULL,
				"menu"             => NULL,	
				"status"           => NULL,
				"relevancia"       => NULL,	
				"data_cad"         => NULL,				
				"user_id"          => NULL,
			);
		else:
			$this->field_value = $fields;
		endif;
		$this->pk_field = 'id';
	} //Final Construct
} //Final da Classe Blog
?>