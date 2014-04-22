window.onload=function () {

	inome 	= document.getElementById('formnome');
	ifone 	= document.getElementById('formfone');
	imail 	= document.getElementById('formmail');
	imsg 	= document.getElementById('formmsg');

	avisos 	= document.getElementById('validaform'); // div escondida para as mensagens
	str 	= "Por favor, preencha corretamente o campo: "; //mensagem padrão
	strSucesso = "Obrigado! Sua mensagem foi enviada com sucesso. Em breve retornaremos o contato."

	strFone = "Por favor, preencha o telefone com DDD, exemplo: <span class='campo'>11 3282 1092</span> | Ajustar Campo: "

	enviar = document.getElementById('enviar');
	enviar.onclick=function(){
		if (validarTxt(inome, str) == false || validarFone(ifone, str) == false || validarMail(imail, str) == false || validarTxt(imsg, str) == false)
		{
			return false; //se for falso, não executa submit
		}
		else 
		{	
			enviarSucesso(avisos, strSucesso);
		}
	} // fecha onsubmit

	function validarTxt(vcampo, str){

			if (vcampo.value == "") {
				enviarErro(avisos, str, vcampo);
				return false;
			};
		} // fecha validar

	function validarFone(vcampo, str){

	var vfTxt = new RegExp('[a-z]','gi');
	var vfNum = new RegExp('[0-9]');

			if ( vfTxt.test(vcampo.value) == true || vfNum.test(vcampo.value) == false ) {
				enviarErro(avisos, str, vcampo);
				return false;
			} else if (vcampo.value.length < 10){
				enviarErro(avisos, strFone, vcampo);
				return false;
			}
		} // fecha validar

	function validarMail(vcampo, str){

	var vm = new RegExp('@');

			if ( vm.test(vcampo.value) == false) {
				enviarErro(avisos, str, vcampo);
				return false;
			};
		} // fecha validar

	function enviarErro(elemento, msg, campo){

		elemento.style.borderColor="red";
		elemento.style.background="rgba(255, 0, 0, 0.07)";
		elemento.style.color="#D50101";

		campo.style.border="1px solid red";
		campo.style.background="rgba(255, 0, 0, 0.07)";
		campo.style.color="#D50101";

		elemento.innerHTML=msg+'<span class="campo">'+campo.name+'</b>';
		$(elemento).slideDown(500);
	} //fecha enviarErro();

	function enviarSucesso(elemento, msg){
		elemento.style.borderColor="";
		elemento.style.background="";
		elemento.style.color="";

		campo.style.border="";
		campo.style.background="";
		campo.style.color="";

		elemento.innerHTML='foi hein';
		$(elemento).slideDown(500);
	}

	campos = document.getElementsByTagName('input');
	icampos = campos.length-1;

	while(icampos>=0){
		campos[icampos].onfocus=function(){
			this.style.border="";
			this.style.background="";
			this.style.color="";
		}
		icampos--;
	} //fecha while

	camposTextarea = document.getElementById('formmsg');
	camposTextarea.onfocus=function(){
			this.style.border="";
			this.style.background="";
			this.style.color="";
		}

} //fecha onload function