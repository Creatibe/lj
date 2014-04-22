<?php
require_once(dirname(__FILE__)."/autoload.php");
protectFile(basename(__FILE__));
class imagens extends base{
	public function __construct($fields=array()){
		parent::__construct();
		$this->table="imagens";
		if(sizeof($fields)<=0):
			$this->field_value = array(
				"id"               => NULL,
				"status"           => NULL,
				"relevancia"       => NULL,
				"nome"             => NULL,
				"titulo"           => NULL,
				"texto1"           => NULL,
				"datacad"          => NULL,
				"users_id"         => NULL,	
				

			);
		else:
			$this->field_value = $fields;
		endif;
		$this->pk_field = 'id';
	}

}
?>
	