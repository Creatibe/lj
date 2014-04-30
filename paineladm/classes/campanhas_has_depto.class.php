<?php
require_once(dirname(__FILE__)."/autoload.php");
protectFile(basename(__FILE__));
class campanhas_has_depto extends base{
	public function __construct($fields=array()){
		parent::__construct();
		$this->table="campanhas_has_depto";
		if(sizeof($fields)<=0):
			$this->field_value = array(
				"campanhas_id"     => NULL,
				"campanhas_nome"   => NULL,
				"depto_id"         => NULL,
				"depto_nome"       => NULL,
			);
		else:
			$this->field_value = $fields;
		endif;
		$this->pk_field = 'id';
	} //Final Construct
} //Final da Classe Blog
?>