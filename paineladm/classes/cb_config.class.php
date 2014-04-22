<?php
require_once(dirname(__FILE__)."/autoload.php");
protectFile(basename(__FILE__));
class cb_config  extends base{
	public function __construct($fields=array()){
		parent::__construct();
		$this->table="cb_config";
		if(sizeof($fields)<=0):
			$this->field_value = array(
				"id"               => NULL,
				"status"           => NULL,
				"users_id"         => NULL,				
				"titulo"           => NULL,
				"descr_config"   => NULL,
				"datacad"          => NULL,
			);
		else:
			$this->field_value = $fields;
		endif;
		$this->pk_field = 'id';
	} //Final Construct
} //Final da Classe cb_config
?>