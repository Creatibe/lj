<?php
require_once(dirname(__FILE__)."/autoload.php");
protectFile(basename(__FILE__));
abstract class base extends database{
	//Propriedades
	public $table        = "";
	public $field_value  = array();	
	public $pk_field     = NULL;
	public $pk_value     = NULL;
	public $extra_select = "";	
	//Métodos
	//Adiciona Campo - addfield
	public function addField($field=NULL,$value=NULL){
		if ($field != NULL):
			$this->field_value[$field] = $value;
		endif;
} //Final - Deleta Campo - addfield
	public function delField($field=NULL){
		if (array_key_exists($field,$this->field_value)):
			unset ($this->field_value[$field]);
		endif;
} //Final - Deleta Campo - delfield	
	//Carrega valor ao Campo - setfield
	public function setValue($field=NULL,$value=NULL){
		if ($field != NULL && $value != NULL):
			$this->field_value[$field] = $value;
		endif;
} //Final - Carrega valor ao Campo - setfield
	//Pega valor do Campo - getfield
	public function getValue($field=NULL){
		if ($field != NULL && array_key_exists($field,$this->field_value)):
			return $this->field_value[$field];
		else:
			return FALSE;
		endif;
} //Final - Pega valor do Campo - getfield	
	
} //Final da Classe Base
?>