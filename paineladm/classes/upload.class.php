<?php
require_once(dirname(__FILE__)."/autoload.php");
protectFile(basename(__FILE__));
class upload {
		private $arquivo;
		private $arqvsize;
		private $nometemp;
		private $error;
		private $altura;
		private $largura;
		private $pasta;

		function __construct($arquivo, $arqvsize, $nometemp, $error, $altura, $largura, $pasta){
			$this->arquivo   = $arquivo;
			$this->arqvsize  = $arqvsize;
			$this->nometemp  = $nometemp;
			$this->error     = $error;
			$this->altura    = $altura;
			$this->largura   = $largura;
			$this->pasta     = $pasta;
		}
		
		private function getExtensao(){
			//retorna a extensao da imagem	
			return $extensao = strtolower(end(explode('.', $this->arquivo)));
		}
		
		private function ehImagem($extensao){
			$extensoes = array('gif', 'jpeg', 'jpg', 'png');	 // extensoes permitidas
			if (in_array($extensao, $extensoes))
				return true;	
		}
		
		//largura, altura, tipo, localizacao da imagem original
		private function redimensionar($imgLarg, $imgAlt, $tipo, $img_localizacao){
			//descobrir novo tamanho sem perder a proporcao
			if ( $imgLarg > $imgAlt ){
				$novaLarg = $this->largura;
				$novaAlt = round( ($novaLarg / $imgLarg) * $imgAlt );
			}
			elseif ( $imgAlt > $imgLarg ){
				$novaAlt = $this->altura;
				$novaLarg = round( ($novaAlt / $imgAlt) * $imgLarg );
			}
			else // altura == largura
				$novaAltura = $novaLargura = max($this->largura, $this->altura);
			
			//redimencionar a imagem
			
			//cria uma nova imagem com o novo tamanho	
			$novaimagem = imagecreatetruecolor($novaLarg, $novaAlt);
			
			switch ($tipo){
				case 1:	// gif
					$origem = imagecreatefromgif($img_localizacao);
					imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0,
					$novaLarg, $novaAlt, $imgLarg, $imgAlt);
					imagegif($novaimagem, $img_localizacao);
					break;
				case 2:	// jpg
					$origem = imagecreatefromjpeg($img_localizacao);
					imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0,
					$novaLarg, $novaAlt, $imgLarg, $imgAlt);
					imagejpeg($novaimagem, $img_localizacao);
					break;
				case 3:	// png
					$origem = imagecreatefrompng($img_localizacao);
					imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0,
					$novaLarg, $novaAlt, $imgLarg, $imgAlt);
					imagepng($novaimagem, $img_localizacao);
					break;
			}
			
			//destroi as imagens criadas
			//imagedestroy($novaimagem);
			//imagedestroy($origem);
		}
		
		public function salvar(){									
			$extensao = $this->getExtensao();
			//echo "<pre>";
			// printf($this->arquivo);
			//echo "</pre>";
			//echo "<br> arquivo  : ".$this->arquivo;
			//echo "<br> tamanho  : ".$this->arqvsize;
			//echo "<br> temp     : ".$this->nometemp;
			//echo "<br> extensão : ".$extensao;
			//gera um nome unico para a imagem em funcao do tempo
			//$novo_nome = time() . '.' . $extensao;
			$fn_min  = "min_".$this->arquivo ;
			$fn_orig = $this->arquivo;
			//localizacao do arquivo 
			$destino = $this->pasta . $fn_orig;
			$destino = dirname(dirname(dirname(__FILE__))).$destino;
			//$destinom= IMAGESPATH."miniaturas/" . $fn_min;
			$destinom= $this->pasta . $fn_min;
			$destinom= dirname(dirname(dirname(__FILE__))).$destinom;
			echo "<br> destino : ".$destino;
			echo "<br> destinom : ".$destinom;
			echo "<br> Arqv temp : ".$this->nometemp;
			//move o arquivo
			if (!  copy($this->nometemp, $destino)){
				if ($this->arquivo['error'] == 1)
					return "Tamanho excede o permitido - Arquivo Original";
				else
					return "Erro " . $this->arquivo['error']." - Arquivo Original";
			}
			if (! move_uploaded_file($this->nometemp, $destinom)){
				if ($this->arquivo['error'] == 1)
					return "Tamanho excede o permitido - Arquivo miniatura";
				else
					return "Erro " . $this->arquivo['error']." - Arquivo miniatura";
			}				
				
			if ($this->ehImagem($extensao)){												
				//pega a largura, altura, tipo e atributo da imagem
				list($largura, $altura, $tipo, $atributo) = getimagesize($destinom);

				// testa se é preciso redimensionar a imagem
				if(($largura > $this->largura) || ($altura > $this->altura))
					$this->redimensionar($largura, $altura, $tipo, $destinom);
			}
			
			return "<br>O aqruivo ".$this->arquivo." foi transferido com Sucesso!";
		}						
	}