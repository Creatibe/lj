<?php
//error_reporting(0);
//error_reporting(E_ALL & E_NOTICE & E_STRICT & E_DEPRECATED);
//echo "<br> Header - ".dirname(dirname(__FILE__)."/util/functions.php");
require_once(dirname(dirname(__FILE__))."/util/functions.php");
//protectFile(basename(__FILE__)); //Protege arquivo de funções


//verifica msgs não lidas em contatos
$msgs_lido_contatos = new contatos();
$msgs_lido_contatos->extra_select="where lido = 0  ";	
$msgs_lido_contatos->selectAll($msgs_lido_contatos);
$msgs_lido_contatos = $msgs_lido_contatos->countline;
//verifica msgs não respondidas em contatos
$msgs_resp_contatos = new contatos();
$msgs_resp_contatos->extra_select="where respondido = 0  ";	
$msgs_resp_contatos->selectAll($msgs_resp_contatos);
$msgs_resp_contatos = $msgs_resp_contatos->countline;
// final das verificações
// Somatória de msgs não lidas e não respondidas
$msgs_lido_total = 0 + $msgs_lido_contatos; // somar msg de contatos + blog + etc...
$msgs_resp_total = 0 + $msgs_resp_contatos; // somar msg de contatos + blog + etc...
// Monta campo informativo das msgs
if ($msgs_lido_total <=0 and $msgs_resp_total <=0):
	$msgs = "Mensagens";
else:
	$msgs = "Mensagens (".$msgs_lido_total."/".$msgs_resp_total.")";
endif;
// final da verificação e montagem de msgs
echo $msgs;
?>	