<?php
require_once(dirname(__FILE__)."/autoload.php");
protectFile(basename(__FILE__));
class blog extends base{
	public function __construct($fields=array()){
		parent::__construct();
		$this->table="blog_posts";
		if(sizeof($fields)<=0):
			$this->field_value = array(
				"id"         => NULL,
				"status"     => NULL,
				"relevancia" => NULL,
				"nome"       => NULL,
				"datacad"    => NULL,
				"titulo"     => NULL,
				"descr_blog" => NULL,
				"images"     => NULL,
				"acessos "   => NULL,
				"categoria"  => NULL,
				"user_resp"  => NULL,
			);
		else:
			$this->field_value = $fields;
		endif;
		$this->pk_field = 'id';
	} //Final Construct
} //Final da Classe Blog
?>