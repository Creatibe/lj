<?php
require_once(dirname(__FILE__)."/autoload.php");
protectFile(basename(__FILE__));
abstract class database {
	// Propriedades
	public $server    = DBHOST;
	public $user      = DBUSER;	
	public $passw     = DBPASS;
	public $dbname    = DBNAME;
	public $condb     = NULL;
	public $dataset   = NULL;
	public $countline = -1;	
	
	//Métodos - Connect
	public function __construct(){
		$this->connect();
	} //final construct
	public function __destruct(){
		if ($this->condb != NULL):
			mysql_close( $this->condb);
		endif;
	} //final destruct
	public function connect() { 
		$this->condb = mysql_connect($this->server,$this->user,$this->passw,TRUE) 
		  or die($this->geterror(__FILE__,__FUNCTION__,mysql_errno(),mysql_error(),true));
		mysql_select_db($this->dbname) 
		  or die($this->geterror(__FILE__,__FUNCTION__,mysql_errno(),mysql_error(),true));
		mysql_query("SET NAMES 'utf8'");
		mysql_query("character_set_connection=utf8");		
		mysql_query("character_set_client=utf8");		
		mysql_query("character_set_results=utf8");		
		//echo "metodo connect foi acionado";
	} //Finaliza métodos - connect
	// Início da Rotina de Insert no DB
	public function insertDB($object){
		// insert into nome_tabela (campo1, campo2) values(valor1,valor2)
		$sql = "INSERT INTO ".$object->table." (";
		$ins_table = $object->table;
		for ($i=0; $i < count($object->field_value); $i++):
			$sql .= key($object->field_value);
			if ($i < (count($object->field_value)-1)):
				$sql .= ", ";
			else:
				$sql .= ") VALUES (";
			endif;
				next ($object->field_value);
		endfor;
		reset($object->field_value);
		for ($i=0; $i < count($object->field_value); $i++):
			$sql .= is_numeric($object->field_value[key($object->field_value)]) ?
				$object->field_value[key($object->field_value)]:
				"'".$object->field_value[key($object->field_value)]."'";
			if ($i < (count($object->field_value)-1)):
				$sql .= ", ";
			else:
				$sql .= ") ";
			endif;
				next ($object->field_value);
		endfor;			
		//echo '<br>'.$sql.'<br>';
		//exit;
		return $this->execSQL($sql);
	} // Final da Rotina de insert no db
	// Início da Rotina de UPDATE no DB
	public function updateDB($object){
		// UPDATE into nome_tabela SET campo1=valor1, campo2,valor2 WHERE cpochave=valorchave
		$sql = "UPDATE ".$object->table." SET ";
		for ($i=0; $i < count($object->field_value); $i++):
			$sql .= key($object->field_value)."=";
			$sql .= is_numeric($object->field_value[key($object->field_value)]) ?
				$object->field_value[key($object->field_value)]:
				"'".$object->field_value[key($object->field_value)]."'";
			if ($i < (count($object->field_value)-1)):
				$sql .= ", ";
			else:
				$sql .= " ";
			endif;
				next ($object->field_value);
		endfor;
		$sql .= "WHERE ".$object->pk_field."=";
		$sql .= is_numeric($object->pk_value) ?
				$object->pk_value :
				"'".$object->pk_value."'";		
		//echo '<br>'.$sql.'<br>';
		return $this->execSQL($sql);
	} // Final da Rotina de delete no db	
	public function deleteDB($object){
		// DELETE FROM nome_tabela WHERE cpochave=valorchave
		$sql = "DELETE FROM ".$object->table;
		$sql .= " WHERE ".$object->pk_field."=";
		$sql .= is_numeric($object->pk_value) ?
				$object->pk_value :
				"'".$object->pk_value."'";		
		//echo $sql;
		return $this->execSQL($sql);
	} // Final da Rotina de delete no db
	//Início da Rotina para selecionar todos os registros da tabela	(manual)
	public function selectManual($object){
		//$sql = $object->table;
		if ($object->extra_select != NULL):
			$sql =$object->extra_select;
			//echo "------> SQL : ".$sql;
		endif;
		return $this->execSQL($sql);
	}//final da Rotina para selecionar todos os registros da tabela	(manual) 	
	//Início da Rotina para selecionar todos os registros da tabela	
	public function selectAll($object){
		$sql = "SELECT * FROM ".$object->table;
		if ($object->extra_select != NULL):
			$sql .= " ".$object->extra_select;
			//echo "<br>------> SQL : ".$sql."<br>";
		endif;
		return $this->execSQL($sql);
	}//final da Rotina para selecionar todos os registros da tabela	 	
	//Início da Rotina para selecionar os registros da tabela por campo	
	public function selectField($object){
		$sql = "SELECT ";
		for ($i=0; $i < count($object->field_value); $i++):
		$sql .= key($object->field_value);
		if ($i < (count($object->field_value)-1)):
			$sql .= ", ";
		else:
			$sql .= " ";
		endif;
			next ($object->field_value);
		endfor;
		$sql .= " FROM ".$object->table;
		if ($object->extra_select != NULL):
			$sql .= " ".$object->extra_select;
		endif;
		return $this->execSQL($sql);
	}//final da Rotina para selecionar os registros da tabela por campo		
	//Início da Rotina que executa os comandos SQL
	public function execSQL($sql=NULL){
		IF ($sql != NULL):
			$query = mysql_query($sql) or $this->geterror(__FILE__,__FUNCTION__);
			$this->countline=mysql_affected_rows($this->condb);
			if (substr(trim(strtolower($sql)),0,6)=="select"):
				$this->dataset = $query;
				return $query;
			else:
				return $this->countline;
			endif;
			//echo $this->countline."<br>";
		else:
			$this->geterror(__FILE__,__FUNCTION__,NULL,'*** Comando SQL não enviado para a Rotina ***',FALSE);		
		endif;
	} //Final da Rotina que executa os comandos SQL
	//Inicio da Rotina para devolver dados da Pesquisa
	public function returnData($type=NULL){
		switch (strtolower($type)) :
			case "array" :
				return mysql_fetch_array($this->dataset);
				break;
			case "assoc" :
				return mysql_fetch_assoc($this->dataset);
				break;
			case "object" :
				return mysql_fetch_object($this->dataset);
				break;
			default:
				return mysql_fetch_object($this->dataset);
				break;								
		endswitch;
	}//Final da Rotina para devolver dados da Pesquisa
	//Inicio da Rotina de Tratar erros
	public function geterror($file=NULL,$rotina=NULL,$numerror=NULL,$msgerror=NULL,$excepterror=FALSE){
		if ($file     == NULL) $file = "Arquivo não informado";
		if ($rotina   == NULL) $file = "Rotina não informada";
		if ($numerror == NULL) $numerror = mysql_errno($this->condb);
		if ($msgerror == NULL) $msgerror = mysql_error($this->condb);
		if ($numerror == 1062):
			$haystack = $msgerror;
			$needle   = "'";
			$pos_ini = strpos($haystack, $needle);
			//echo "<br> ini ".$pos_ini;
			$offset = $pos_ini+1;
			$pos_fim = strpos($haystack, $needle,$offset);
			//echo "<br> fim ".$pos_fim;			
			$pos_size = $pos_fim - $pos_ini;
			//echo "<br> size ".$pos_size;			
			if ($pos_size > 0):
				$campo_error = substr($msgerror, $pos_ini+1,$pos_size-1);
				$msgerror = "Registro Duplicado - ".$campo_error;
				$resulterror = ' Erros ocorridos: <br>
				<strong>Mensagem do Erro</strong> : '.$msgerror.'<br>';
				$resulterror = "";
				$extra_msg = $campo_error;
				getMSG('cb-802','alerta',$extra_msg);
			endif;
		else:
			$resulterror = ' Erros ocorridos: <br>
			<strong>Arquivo</strong>          : '.$file.'<br>
			<strong>Rotina</strong>           : '.$rotina.'<br>		
			<strong>Número do Erro</strong>   : '.$numerror.'<br>		
			<strong>Mensagem do Erro</strong> : '.$msgerror.'<br>';			
		endif;

		if ($excepterror == FALSE):
			echo $resulterror;
		else:
			die($resulterror);
		endif;
	} //final da Rotina de Tratar erros
} //final da classe database
?>