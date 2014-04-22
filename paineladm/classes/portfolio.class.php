<?php
require_once(dirname(__FILE__)."/autoload.php");
protectFile(basename(__FILE__));
class portfolio extends base{
	public function __construct($fields=array()){
		parent::__construct();
		$this->table="portfolio";
		if(sizeof($fields)<=0):
			$this->field_value = array(
				"id"               => NULL,
				"status"           => NULL,
				"relevancia"       => NULL,
				"categoria"        => NULL,
				"users_id"         => NULL,				
				"titulo"           => NULL,
				"descr_portfolio"  => NULL,
				"imagem"           => NULL,
				"datacad"          => NULL,
				"pg_titulo_0"      => NULL,
				"pg_titulo_1"      => NULL,
				"pg_descr_1"       => NULL,
				"pg_titulo_2"      => NULL,
				"pg_descr_2"       => NULL,
				"pg_titulo_3"      => NULL,
				"pg_descr_3"       => NULL,
				"pg_imagem_1"      => NULL,
				"pg_video_1"       => NULL,
				"pg_nome"          => NULL,
				"pg_modelo"        => NULL,
			);
		else:
			$this->field_value = $fields;
		endif;
		$this->pk_field = 'id';
	}
} //Final Construct
?>