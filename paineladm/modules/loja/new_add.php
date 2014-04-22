<?php
#	
#	//Ler arquivos
#	//$arq = 'all.xml';
#	//$xml = simplexml_load_file($arq);
#	//echo "<h2>" . $xml->id->categoria . "</h2>";
#
#	//Editar arquivos
#	$arq = 'all.xml';
#	$xml = file_get_contents($arq);
#	$dom = new DOMDocument('1.0','utf-8');
#	$dom->loadXML($xml);
#
#	$id = $dom->getElementsByTagName('categoria');
#
#	$all = $dom->getElementsByTagName('produtosall');
#
#	$cat 	= $dom->createElement('categoria');
#	$catTxt = $dom->createTextNode('Categoria de Teste');
#	$cat->appendChild($catTxt);
#
#	$dom->appendChild($cat);
#
#	//echo $cat->nodeValue;
#	//foreach ($id as $categoria) {
#	//	echo $categoria->nodeValue;
#	//}
#
#	echo asXML('insert.xml');
#	

	echo '<meta charset=utf-8>';

	$arq 	= 'criado.xml';

	//$xml 	= new SimpleXMLElement($arq,NULL,true);

	$file 	= file_get_contents($arq);
	$dom 	= new DOMDocument;
	$dom->loadXML($file);

	$root 	= $dom->getElementsByTagName('produtosall');

	$id 	= $dom->createElement('id');
	$id->setAttribute('n','101112');
	
	//criar elementos
	$e[0] 	= $dom->createElement('categoria');
	$e[1] 	= $dom->createElement('produto');
	$e[2] 	= $dom->createElement('cor');
	$e[3] 	= $dom->createElement('tamanho');
	$e[4] 	= $dom->createElement('genero');
	$e[5] 	= $dom->createElement('qtde');
	$e[6]	= $dom->createElement('estacao');

	//criar conteudo dos elementos
	$c[0] 	= $dom->createTextNode('Blusas');
	$c[1] 	= $dom->createTextNode('Blusa Impermevável drift');
	$c[2] 	= $dom->createTextNode('Azul e Branca');
	$c[3] 	= $dom->createTextNode('M');
	$c[4] 	= $dom->createTextNode('M');
	$c[5] 	= $dom->createTextNode('10');
	$c[6] 	= $dom->createTextNode('Inverno');

	echo sizeof($c); //7

	$i = 0;
	while ($i<=sizeof($c)-1) {
		$e[$i]->appendChild($c[$i]);
		$id->appendChild($e[$i]);
		$i++;
		if ($i == sizeof($c)-1) {
			$root->item(0)->appendChild($id);
		}
	}

	//echo $dom->$t;
	//$t->appendChild($tx);
	//$id->appendChild($t);
	//$root->item(0)->appendChild($id);

	//$y = $dom->getElementsByTagName('id');
	//print_r ($y); // array = length

	//echo $xml->id->categoria; // Categoria

	//$xml->addChild();

	$dom->save($arq);

#?>