<?php
require_once(dirname(__FILE__)."/autoload.php");
protectFile(basename(__FILE__));
class produtos extends base{
	public function __construct($fields=array()){
		parent::__construct();
		$this->table="produtos";
		if(sizeof($fields)<=0):
			$this->field_value = array(
				"id"               => NULL,
				"sku"              => NULL,
				"nome"             => NULL,
				"titulo"           => NULL,
				"valor"            => NULL,
				"desconto"         => NULL,
				"promocao"         => NULL,
				"estoque"          => NULL,
				"encomenda"        => NULL,
				"fixar_home"       => NULL,
				"qtde_vendida"     => NULL,
				"valor_vendido"    => NULL,
				"status"           => NULL,
				"relevancia"       => NULL,		
				"data_cad"         => NULL,				
				"user_id"          => NULL,
				"sub_cat_id"       => NULL,
			);
		else:
			$this->field_value = $fields;
		endif;
		$this->pk_field = 'id';
	} //Final Construct
} //Final da Classe Blog
?>