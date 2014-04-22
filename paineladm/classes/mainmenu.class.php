<?php
require_once(dirname(__FILE__)."/autoload.php");
protectFile(basename(__FILE__));
class mainmenu extends base{
	public function __construct($fields=array()){
		parent::__construct();
		$this->table="mainmenu";
		if(sizeof($fields)<=0):
			$this->field_value = array(
				"id"         => NULL,
				"status"     => NULL,
				"relevancia" => NULL,
				"menunome"   => NULL,
				"menulink"   => NULL,
				"menulabel"  => NULL,
				"datacad"    => NULL,
				"user_resp"  => NULL,
			);
		else:
			$this->field_value = $fields;
		endif;
		$this->pk_field = 'id';
	} //Final Construct
} //Final da Classe Blog
?>