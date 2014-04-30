<?php error_reporting(E_ALL & E_NOTICE & E_STRICT & E_DEPRECATED);
//session_start();
$userid = $session -> getVars('userid');
$userlogin = $session -> getVars('userlogin');
?>
<div id="sidebar">
	<ul id="accordion">
		<div id="header-logo"><img src="images/creatibe/logo-beweb.png"></div>
			<li>
				<a href="painel.php?p=adm">Painel ADM</a>
			</li>
			<li>
				<a href="painel.php?p=loja">Início Loja</a>
			</li>			

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
			<li><a class="item" href="#">Campanhas</a>
				<ul>
					<li><a href="painel.php?p=loja&m=campanhas&s=incluir">Cadastar</a></li>
					<li><a href="painel.php?p=loja&m=campanhas&s=listar">Exibir</a></li>
				</ul>
			</li>				
			<li><a class="item" href="#">Produtos</a>
				<ul>
					<li><a href="painel.php?p=loja&m=produtos&s=incluir">Cadastar</a></li>
					<li><a href="painel.php?p=loja&m=produtos&s=listar">Exibir</a></li>
				</ul>
			</li>	
			<li><a class="item" href="#">Departamentos</a>
				<ul>
					<li><a href="painel.php?p=loja&m=depto&s=incluir">Cadastar</a></li>
					<li><a href="painel.php?p=loja&m=depto&s=listar">Exibir</a></li>
				</ul>
			</li>			
			<li><a class="item" href="#">Categorias</a>
				<ul>
					<li><a href="painel.php?p=loja&m=categorias&s=incluir">Cadastar</a></li>
					<li><a href="painel.php?p=loja&m=categorias&s=listar">Exibir</a></li>
				</ul>
			</li>
			<li><a class="item" href="#">Sub-Categorias</a>
				<ul>
					<li><a href="painel.php?p=loja&m=sub_cat&s=incluir">Cadastar</a></li>
					<li><a href="painel.php?p=loja&m=sub_cat&s=listar">Exibir</a></li>
				</ul>
			</li>	
			<li><a class="item" href="#">Caracteristicas</a>
				<ul>
					<li><a href="painel.php?p=loja&m=caract&s=incluir">Cadastar</a></li>
					<li><a href="painel.php?p=loja&m=caract&s=listar">Exibir</a></li>
				</ul>
			</li>
			<li><a class="item" href="#">Opções</a>
				<ul>
					<li><a href="painel.php?p=loja&m=Opcoes&s=incluir">Cadastar</a></li>
					<li><a href="painel.php?p=loja&m=Opcoes&s=listar">Exibir</a></li>
				</ul>
			</li>		

	



	
			<li><a href="index.php?error=cb-902&msgtype=sucesso">Sair</a></li>
	</ul>
</div>
<!--</div> Final DIV id=sidebar -->