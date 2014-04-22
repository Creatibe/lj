<?php
require_once(dirname(__FILE__)."/autoload.php");
protectFile(basename(__FILE__));
class galerias extends base{
	public function __construct($fields=array()){
		parent::__construct();
		$this->table="galerias";
		//$this->extra_select="WHERE blog_category_id=1";		
		if(sizeof($fields)<=0):
			$this->field_value = array(
				"id"               => NULL,
				"status"           => NULL,
				"relevancia"       => NULL,
				"nome"             => NULL,
				"titulo"           => NULL,
				"texto1"           => NULL,
				"imagem"           => NULL,
				"datacad"          => NULL,
				"users_id"         => NULL,	
			);
		else:
			$this->field_value = $fields;
		endif;
		$this->pk_field = 'id';
	} //Final Construct*/

}
?>

