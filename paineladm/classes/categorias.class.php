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
				"sub_cat_1"        => NULL,
				"sub_cat_2"        => NULL,
				"sub_cat_3"        => NULL,
				"sub_cat_4"        => NULL,
				"sub_cat_5"        => NULL,
				"sub_cat_6"        => NULL,
				"sub_cat_7"        => NULL,
				"sub_cat_8"        => NULL,
				"sub_cat_9"        => NULL,
				"sub_cat_10"       => NULL,
				"sub_cat_11"       => NULL,
				"sub_cat_12"       => NULL,
				"sub_cat_13"       => NULL,
				"sub_cat_14"       => NULL,
				"sub_cat_15"       => NULL,
				"sub_cat_16"       => NULL,
				"sub_cat_17"       => NULL,
				"sub_cat_18"       => NULL,
				"sub_cat_19"       => NULL,
				"sub_cat_20"       => NULL,
				"status"           => NULL,
				"relevancia"       => NULL,		
				"filtro"           => NULL,
				"menu"             => NULL,
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