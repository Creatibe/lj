<?php
//Início da Rotina de gravar Logs
$registro = "<p>Rotina : $pagina</p>";
$registro .= "<p>Status: $status</p>";
$registro .= "<p>Relevancia: $relevancia</p>";
$registro .= "<p>Descrição: $descricao</p>";
$registro .= "<p>Imagem: $imagem</p>";
$registro .= "<p>Data Cad: $data_cad</p>";
$registro .= "<p>User Resp: $user_resp</p>";
grava_log($user_id,$user_ip,$rotina,$screen,$registro); 		
//Final da Rotina de gravar Logs
//echo "----------------------> Passou pela rotina de logs <-----------------------"
?>		