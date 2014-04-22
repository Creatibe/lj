document.ready=function() {
	//alert('oi');

	signDate();
	lerMais();
	marginImgPost();
	intervalos();
	sliders();
};

function signDate(){
	var ano = new Date();
	span = document.getElementById('year');

	span.innerHTML=ano.getFullYear();
}

function lerMais(){
	/*
	Pega todos os paragrafos dos posts da página e limita a quantidade de caracteres em 180, adicionando o Leia mais com o Mesmo link do titulo...
	*/
	post = document.getElementsByClassName('post');

	x=post.length-1;
	while(x>=0)
	{
		paragrafo = post[x].getElementsByTagName('p');
		href = post[x].getElementsByTagName('a');

		//txtLink = link[x].getAttribute('href');
		y=limitParagrafo(paragrafo, href);

		x--;
	};

	function limitParagrafo(para, link){
		txtLink = link[0].getAttribute('href');
		txt = para[0].innerHTML.substr(0,170); //esse '0' se mantem pois cada article tem apenas um <P>.
		para[0].innerHTML=txt+'...'+'<br><br>'+'<a class="continueLendo" href="'+txtLink+'">'+'Continue Lendo...'+'</a>';
	};

}; //fecha lerMais

function marginImgPost(){
	/*
	Esta função determina a marginTop negativa conforme a altura da imagem real para se ajustar ao centro da FIGURE, pois esto com position top:50%;
	*/
		img = document.getElementsByClassName('imgPost');
		
		i=img.length-1;
		while (i>=0)
			{
			altura = img[i].clientHeight;
			img[i].style.marginTop=altura/2*-1+'px';
			i--;
			}
	};

function intervalos(){
	setaEsqHome		= document.getElementById('navSliderEsq');
	setaDirHome		= document.getElementById('navSliderDir');

	x0=pause(setaEsqHome);
	x1=pause(setaDirHome);
	
	rodaSlider = setInterval(autoSlider, 6500);
	
	function pause(botao){
	$(botao).click(function(){
		clearInterval(rodaSlider);
		rodaSlider = setTimeout(intervalos, 9000); //isso significa a soma deste tempo + do setInterval
		});
		}; //pause
	}//fecha intervalo

function autoSlider(){
		/*
		Apenas uma cópia da função Sliders(); sem os eventos .Click e com setInterval logo abaixo. Serve para rodar automaticamente o slider
		*/
		ulHome			= document.getElementById('sliderItens');
		itensHome		= document.getElementsByClassName('sliderItem');
		ti 				= 2000;
		tv 				= 2300;
		
		x=roda(ulHome, itensHome, ti, tv);

			function roda(ul, itens, tempoIda, tempoVolta){
				totalItens		= itens.length;
				widthLi 		= itens[0].clientWidth; // pega largura da LI em número inteiro
				
				// define largura da UL conforme quantidade de LIs
				ul.style.width 	= widthLi*totalItens+'px';
				widthUlPx		= ul.style.width;
				widthUl 		= parseInt(widthUlPx); //Pegar largura da UL definida acima em pixels e converte em int

				widthLi = wli = itens[0].clientWidth;// essa merda quase me deixou louco! Precisa redefinir o valor aqui, porque se não ele pega a largura apenas de 1 li. - remova isso para entener o erro!
				widthUl = wul =ul.clientWidth;

				posicao 		= $(ul).css('left'); // posicao atual em Pixels
				posicaoAtual 	= parseInt(posicao); // converte posição atual em número inteiro

				if (posicaoAtual <= (widthUl-widthLi)*-1) {
					$(ul).animate({left: '0px'}, tempoVolta, 'swing');
				} else {
					$(ul).animate({left: posicaoAtual+widthLi*-1+'px'}, tempoIda, 'swing');
				};
			}; //fecha roda
	}; //fecha autoSlider

	function sliders(){

	//Slider Principal- Home
	setaEsqHome		= document.getElementById('navSliderEsq');
	setaDirHome		= document.getElementById('navSliderDir');
	ulHome			= document.getElementById('sliderItens');
	itensHome		= document.getElementsByClassName('sliderItem');

	z = pegaSlider(setaEsqHome, setaDirHome, ulHome, itensHome);

	//Slider Estrutura
	setaEsqEst		= document.getElementById('sliderEstruturaEsq');
	setaDirEst		= document.getElementById('sliderEstruturaDir');
	ulEst			= document.getElementById('estruturaItens');
	itensEst		= document.getElementsByClassName('estruturaItem');

	z = pegaSlider(setaEsqEst, setaDirEst, ulEst, itensEst);

		function pegaSlider(setaEsq, setaDir, ul, itens){

		totalItens		= itens.length;
		widthLi 		= itens[0].clientWidth; // pega largura da LI em número inteiro
		
		
		// define largura da UL conforme quantidade de LIs
		ul.style.width 	= widthLi*totalItens+'px';
		widthUlPx		= ul.style.width;
		widthUl 		= parseInt(widthUlPx); //Pegar largura da UL definida acima em pixels e converte em int

			$(setaDir).click(function(){
			widthLi = wli = itens[0].clientWidth;// essa merda quase me deixou louco! Precisa redefinir o valor aqui, porque se não ele pega a largura apenas de 1 li. - remova isso para entener o erro!
			widthUl = wul =ul.clientWidth;

			posicao 		= $(ul).css('left'); // posicao atual em Pixels
			posicaoAtual 	= parseInt(posicao); // converte posição atual em número inteiro

				if (posicaoAtual <= (widthUl-widthLi)*-1) {
					$(ul).animate({left: '0px'}, 'slow', 'swing');
				} else {
					$(ul).animate({left: posicaoAtual+widthLi*-1+'px'}, 'slow', 'swing');
				}
			}); // fecha setaDir


			//FUNCTION SETA ESQUERDA...
			$(setaEsq).click(function(){
			widthLi = wli = itens[0].clientWidth;// essa merda quase me deixou louco! Precisa redefinir o valor aqui, porque se não ele pega a largura apenas de 1 li. - remova isso para entener o erro!	
			widthUl = wul =ul.clientWidth;

			posicao 		= $(ul).css('left'); // posicao atual em Pixels
			posicaoAtual 	= parseInt(posicao); // converte posição atual em número inteiro

				if (posicaoAtual >= 0) {
					$(ul).animate({left: (widthUl-widthLi)*-1+'px'},'slow', 'swing');
				} else {
					$(ul).animate({left: posicaoAtual+widthLi+'px'},'slow', 'swing');
				}

			}); // fecha setaEsq

		}; //fecha pageSlider
};// fecha Sliders