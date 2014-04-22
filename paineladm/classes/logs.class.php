<?php
require_once(dirname(__FILE__)."/autoload.php");
protectFile(basename(__FILE__));
class logs extends base{
	public function __construct($fields=array()){
		parent::__construct();
		$this->table="cb_logs";
		if(sizeof($fields)<=0):
			$this->field_value = array(
				"id"               => NULL,
				"data"             => NULL,
				"user_id"          => NULL,	
				"user_ip"          => NULL,				
				"modulo"           => NULL,
				"acao"             => NULL,
				"registro"         => NULL,
			);
		else:
			$this->field_value = $fields;
		endif;
		$this->pk_field = 'id';
	} //Final Construct
} //Final da Classe Blog
?>