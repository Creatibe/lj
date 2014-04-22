<?php error_reporting(E_ALL & E_NOTICE & E_STRICT & E_DEPRECATED);
//session_start();
$userid = $session -> getVars('userid');
$userlogin = $session -> getVars('userlogin');
?>
<div id="sidebar">
	<ul id="accordion">
		<div id="header-logo"><img src="images/creatibe/logo-beweb.png"></div>
			<li>
				<a href="painel.php">Início</a>
			</li>

			<li><a href="painel.php?p=loja">Loja</a></li>	
			
			<?php
			if ($msgs_lido_total <= 0 and $msgs_resp_total <= 0) :
				$mensagens = "Mensagens";
			else :
				$mensagens = "<strong>Mensagens (" . $msgs_lido_total . "/" . $msgs_resp_total . ")</strong>";
			endif;
			?>
			
			<li><a class="item" href="painel.php"><?php echo $mensagens?></a>
				<ul>
					<?php
					if ($msgs_lido_contatos <= 0 and $msgs_resp_contatos <= 0) :
						$contatos = "Contatos";
					else :
						$contatos = "<strong>Contatos (" . $msgs_lido_contatos . "/" . $msgs_resp_contatos . ")</strong>";
					endif;
					?>
					<li><a href="painel.php?m=contatos&s=listar"><?php echo $contatos?></a></li>
				</ul>
			</li>
	
			<li><a class="item" href="painel.php">Usuarios</a>
				<ul>
					<li><a href="painel.php?m=users&s=incluir">Cadastar</a></li>
					<li><a href="painel.php?m=users&s=listar">Exibir</a></li>
				</ul>
			</li>
	
			<li><a class="item" href="painel.php?raiz=0">Main Menu</a>
				<ul>
					<li><a href="painel.php?m=mainmenu&s=incluir">Cadastar</a></li>
					<li><a href="painel.php?m=mainmenu&s=listar">Exibir</a></li>
				</ul>
			</li>
			
		
	
			<li><a class="item" href="#">Itens Sub Cat</a>
				<ul>
					<li><a href="painel.php?m=item_sub_cat&s=incluir">Cadastar</a></li>
					<li><a href="painel.php?m=item_sub_cat&s=listar">Exibir</a></li>
				</ul>
				<ul>
					<li><a href="painel.php?m=sub_categorias&s=incluir">Cadastar</a></li>
					<li><a href="painel.php?m=sub_categorias&s=listar">Exibir</a></li>
				</ul>
				
			</li>
	
			<li><a class="item" href="#">Páginas</a>
				<ul>
					<li><a href="painel.php?m=paginas&s=incluir">Cadastar</a></li>
					<li><a href="painel.php?m=paginas&s=listar">Exibir</a></li>
				</ul>
			</li>
	
			<li><a class="item" href="#">Banners</a>
				<ul>
					<li><a href="painel.php?m=banners&s=incluir">Cadastar</a></li>
					<li><a href="painel.php?m=banners&s=listar">Exibir</a></li>
				</ul>
			</li>
	
			<li><a class="item" href="#">Mídias</a>
				<ul>
					<li><a href="painel.php?m=galerias&s=incluir">Cadastrar Galerias</a></li>
					<li><a href="painel.php?m=galerias&s=listar">Listar Galerias</a></li>
					<li><a href="painel.php?m=imagens&s=incluir">Cadastrar Imagens</a></li>
					<li><a href="painel.php?m=imagens&s=listar">Listar Imagens</a></li>
				</ul>
			</li>
	
			<li><a class="item" href="#">Chat - ADM</a>
				<ul>
					<!--<li><a href="painel.php?m=chat_adm&s=chat">Acessar</a></li>-->
					<li><a href="modules/chat_adm_ext/index.php" target="_blank">Acessar o Chat</a></li>
					<li><a href="painel.php?m=visitantes&s=listar">Visitantes</a></li>
				</ul>
			</li>
	
			<li><a  href="painel.php?m=logs&s=listar">Logs</a>
				<ul>
					<li><a href="painel.php?m=logs&s=incluir">Cadastar</a></li>
					<li><a href="painel.php?m=logs&s=listar">Exibir</a></li>
				</ul>
			</li>
	
			<li><a href="index.php?error=cb-902&msgtype=sucesso">Sair</a></li>
	</ul>
</div>
<!--</div> Final DIV id=sidebar -->