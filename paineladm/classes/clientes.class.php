<?php
require_once ('base.class.php');
class clientes extends base{
	public function __construct($fields=array()){
		parent::__construct();
		$this->table="clientes";
		if(sizeof($fields)<=0):
			$this->field_value = array(
				"id" => NULL,
				"nome" => NULL,
				"data_cad" => NULL,
				"status" => NULL,
				"user_id" => NULL,
				"ftp_host" => NULL,
				"ftp_user" => NULL,
				"ftp_senha" => NULL
			);
		else:
			$this->field_value = $fields;
		endif;
		$this->pk_field = 'id';
	} //Final Construct
} //Final da Classe Clientes
?>