<?php
require_once(dirname(__FILE__)."/autoload.php");
protectFile(basename(__FILE__));
class visitantes extends base{
	public function __construct($fields=array()){
		parent::__construct();
		$this->table="visitantes";
		if(sizeof($fields)<=0):
			$this->field_value = array(
				"id"               => NULL,
				"nome"             => NULL,
				"data"             => NULL,
				"user_ip"          => NULL,				
				"horario"          => NULL,
				"limite"           => NULL,
				"grupo"            => NULL,
				"email"            => NULL,
			);
		else:
			$this->field_value = $fields;
		endif;
		$this->pk_field = 'id';
	} //Final Construct
} //Final da Classe Blog
?>