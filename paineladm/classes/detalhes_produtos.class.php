<?php
require_once(dirname(__FILE__)."/autoload.php");
protectFile(basename(__FILE__));
class detalhes_produtos extends base{
	public function __construct($fields=array()){
		parent::__construct();
		$this->table="detalhes_produtos";
		if(sizeof($fields)<=0):
			$this->field_value = array(
				"id"               => NULL,
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
				"nome_1"           => NULL,
				"nome_2"           => NULL,
				"nome_3"           => NULL,
				"nome_4"           => NULL,
				"nome_5"           => NULL,
				"nome_6"           => NULL,
				"nome_7"           => NULL,
				"nome_8"           => NULL,
				"nome_9"           => NULL,
				"nome_10"          => NULL,
				"nome_11"          => NULL,
				"nome_12"          => NULL,
				"nome_13"          => NULL,
				"nome_14"          => NULL,
				"nome_15"          => NULL,
				"nome_16"          => NULL,
				"nome_17"          => NULL,
				"nome_18"          => NULL,
				"nome_19"          => NULL,
				"nome_20"          => NULL,
				"produtos_id"      => NULL,
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