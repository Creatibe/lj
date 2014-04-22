<?php
require_once(dirname(__FILE__)."/autoload.php");
protectFile(basename(__FILE__));
class blog_comments extends base{
	public function __construct($fields=array()){
		parent::__construct();
		$this->table="blog_comments";
		if(sizeof($fields)<=0):
			$this->field_value = array(
				"id"          => NULL,
				"status"      => NULL,
				"data"        => NULL,
				"id_post"     => NULL,
				"qtde"        => NULL,
				"id_com"      => NULL,
				"nome"        => NULL,
				"email"       => NULL,
				"site"        => NULL,
				"comentario"  => NULL,
			);
		else:
			$this->field_value = $fields;
		endif;
		$this->pk_field = 'id';
	} //Final Construct
} //Final da Classe Blog
?>