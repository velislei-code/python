
<?Php
	
	$AttribPosAbaA = $_COOKIE['CookieAttribPosAbaA']; // Posi��o das abas "A"
	// Inicializa var
	$BotaoVoltar = 0;			
	$BotaoAvanco = 0;		
	
	
	//*********************************************************************************************
	//Consulta LISTA DE T�PICOS
	if( isset($_REQUEST['reg']) ){
		$RegURL = $_REQUEST['reg'];
		setcookie ("CookieRegURL", $RegURL, time()+21600);
	}else{
		$RegURL = $_COOKIE['CookieRegURL'];
	}
	
		
	include 'config/cabecario.inc';
	
//*****************************************
// Verificar Autentica��o
	$usuario = $ObjFuncao->VerAutenticacao();	
//*****************************************
	$AbaAtivaB = $AttribAbaIntB[4];	// Informa qual Aba deve ser selecionada

	

	// Consulta Eqpto, Procedimento, Descricao, Comando	no MySQL			
	$ResCltMySql = $ObjMySql->CltComando($RegURL);

	// Confirma se Consulta retornou algum registro...se sim mostrra registro...
	if(!empty($ResCltMySql[10]) ){	
		$ExibirTab = true;
	}else{
		$ExibirTab = false;
	}
		

?>
<script language="javascript">
<!--
function PopWindow(URL,windowName,features)
{ 
	window.open(URL,windowName,features);
}
//-->
</SCRIPT>
<body BGCOLOR="<?Php echo"$ThemeCorFundoBody"; ?>">
<div id="geral"><!-- Pagina Geral -->	


	<table class="TAB_Geral" width="100%" align="center" valign="top">
	<form name="Localizar" method="post" action="localizar.php"><!-- Form Localizar, inserido aqui devido espa�os que cria no IE -->
	<tr align="center"  height="50" valign="top">
	
	<!-------------------------------- Inicio Geral Esquerdo -------------------------------------------------------------------->
	
	<td width="15%" colspan="1"  align="center"  height="5" valign="top">
	<br>
	<div id="geral_esquerdo"><!-- Geral Esquerdo -->
		
		<table class="TAB_GeralEsq" width="100%" align="center" valign="top">
		<!------------------------------------- Inicio LOGO --------------------------------------------------------------->
		<tr align="center"  height="5" valign="top">
			<td width="100%" colspan="1"  align="center"  height="5" valign="top">
			<span class = "circle-image">
				<img src = "imagens/<?Php echo "$ThemeGlobo"; ?>" title="Vt&a-Sistemas"/> 
			</span>		
			</td>  
		</tr>
		<!------------------------------------- Final LOGO --------------------------------------------------------------->
		
		<!------------------------------------- Inicio Menu esquerdo --------------------------------------------------------------->
		
		   <tr align="center"  height="5" valign="top">
			<td width="100%" colspan="1"  align="center"  height="5" valign="top">
			
			
			<table class="TAB_MenuEsq" width="100%" align="center" valign="top">
			<tr align="center"  height="5" valign="top">
			
			<td width="20" colspan="1"  align="left"  height="5" valign="top">		
			<!---------------------------------------------------------------------------------------------------->
				<!------------------------ Linha - Ini ---------------------------------------------------->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php $ObjFuncao->espaco(2); ?>
						<img border="0" src="imagens/<?Php echo"$ThemeCorLinhaMenu"; ?>" width="155" height="15">
					</td>
				</tr>
				<!------------------------ Linha - Fim ---------------------------------------------------->
				
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
					<?Php $ObjFuncao->espaco(5); ?>
					<a href="<?Php echo"$AttribMenuEsqIntLink00";?>" class="fonte_menu_esq">
						<?Php echo"$AttribMenuEsqInt00";?>
					</a></td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
					<?Php $ObjFuncao->espaco(5); ?>
					<a href="<?Php echo"$AttribMenuEsqIntLink01";?>" class="fonte_menu_esq">
						<?Php echo"$AttribMenuEsqInt01";?>
					</a></td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
					<?Php $ObjFuncao->espaco(5); ?>
					<a href="<?Php echo"$AttribMenuEsqIntLink01b";?>" class="fonte_menu_esq">
						<?Php echo"$AttribMenuEsqInt01b";?>
					</a></td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
						<a href="<?Php echo"$AttribMenuEsqIntLink02";?>" class="fonte_menu_esq">
							<?Php echo"$AttribMenuEsqInt02";?>
						</a></td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
					<?Php $ObjFuncao->espaco(5); ?>
					<a href="<?Php echo"$AttribMenuEsqIntLink03";?>" class="fonte_menu_esq">
						<?Php echo"$AttribMenuEsqInt03";?>
					</a></td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
						<a href="<?Php echo"$AttribMenuEsqIntLink04";?>" class="fonte_menu_esq">
							<?Php echo"$AttribMenuEsqInt04";?>
						</a></td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
							<?Php $ObjFuncao->espaco(5); ?>
						<a href="<?Php echo"$AttribMenuEsqIntLink05";?>" class="fonte_menu_esq">
							<?Php echo"$AttribMenuEsqInt05";?>
						</a></td>
				</tr>
                <tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
							<?Php $ObjFuncao->espaco(5); ?>
							<!-- Imprime lista de cookies ativos no Navegador -->
							<img src = "imagens/Cookie.png" width="30" height="30" title="<?Php print_r($_COOKIE); ?> onmouseover="" style="cursor: pointer;" width="25" height="150" onClick="PopWindow('lista_cookie.php','Lista Cookie ativos','width=760,height=500,scrollbars=yes')" alt="Pop-Up" title="Pop-Up">				
					</td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
					</td>
				</tr>
				<!------------------------ Linha - Ini ---------------------------------------------------->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php $ObjFuncao->espaco(2); ?>
						<img border="0" src="imagens/<?Php echo"$ThemeCorLinhaMenu"; ?>" width="155" height="15">
					</td>
				</tr>
				<!------------------------ Linha - Fim ---------------------------------------------------->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php $ObjFuncao->espaco(3); ?>
						<a href="<?Php echo"$AttribMenuLinguaLink00";?>" class="fonte_item_menu">
						<img border="0" src="imagens/<?PHp echo"$ThemeMenuLinguaSel00"; ?>" width="15" height="15">
							<?Php echo"$AttribMenuLingua00";?>
						</a>
					</td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
						<a href="<?Php echo"$AttribMenuLinguaLink01";?>" class="fonte_menu_esq">
						<img border="0" src="imagens/<?PHp echo"$ThemeMenuLinguaSel02"; ?>" width="10" height="10">
							<?Php echo"$AttribMenuLingua01";?>
						</a>
					</td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
						<a href="<?Php echo"$AttribMenuLinguaLink02";?>" class="fonte_menu_esq">
						<img border="0" src="imagens/<?PHp echo"$ThemeMenuLinguaSel02"; ?>" width="10" height="10">
							<?Php echo"$AttribMenuLingua02";?>
						</a>
					</td>
				</tr>
				
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
						<a href="<?Php echo"$AttribMenuLinguaLink03";?>" class="fonte_menu_esq">
						<img border="0" src="imagens/<?PHp echo"$ThemeMenuLinguaSel03"; ?>" width="10" height="10">
							<?Php echo"$AttribMenuLingua03";?>
						</a>
					</td>
				</tr>
				<!------------------------ Linha - Ini ---------------------------------------------------->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php $ObjFuncao->espaco(2); ?>
						<img border="0" src="imagens/<?Php echo"$ThemeCorLinhaMenu"; ?>" width="155" height="15">
					</td>
				</tr>
				<!------------------------ Linha - Fim ---------------------------------------------------->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
						<a href="<?Php echo"$AttribMenuSobreLink00"; ?>" class="fonte_menu_esq">
							<?Php echo"$AttribMenuSobre00";?>
						</a></td>
				</tr>
				<!------------------------ Linha - Ini ---------------------------------------------------->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php $ObjFuncao->espaco(2); ?>
						<img border="0" src="imagens/<?Php echo"$ThemeCorLinhaMenu"; ?>" width="155" height="15">
					</td>
				</tr>
				<!------------------------ Linha - Fim ---------------------------------------------------->
		
				
			<!---------------------------------------------------------------------------------------------------->
			</td></tr>
			</table>
			
			
			
			</td>  
			</tr>
		<!------------------------------------- Final Menu esquerdo --------------------------------------------------------------->
		
		</table>

	
	</div><!-- Geral Esquerdo -->
	</td>
	<!-------------------------------- Final Geral Esquerdo -------------------------------------------------------------------->
	
	
	<!-------------------------------- Inicio Geral Direito -------------------------------------------------------------------->
	
	<td width="95%" colspan="1"  align="center"  height="5" valign="top">
	<br>
	<div id="geral_direito"><!-- Geral Direito -->		
		
		<table class="TAB_GeralDireito" width="100%" align="center" valign="top"> <!-- cellspacing="0" cellpadding="0" height="5"  BGCOLOR="<?Php echo"$CorDeFundoBody"; ?>> -->
		<!------------------------------------------------------------------------------------------------------------->
		<!-- INI Linha Menus *favoritos -->	
		<div id="pop_favorito" class="favorito_skin" onMouseover="clearhide_favorito();highlight_favorito(event,'on')" onMouseout="highlight_favorito(event,'off');dynamichide_fav(event)">		
			<tr align="center"  height="5" valign="top">
			<td width="100%" colspan="1"  align="right"  height="5" valign="top">
				<!-- Menu Favoritos -->
				<a onMouseover="show_favorito(event,linkset_fav[0])" onMouseout="delayhide_favorito()" class="fonte_AttribTopo">
					<img border="0" src="imagens/<?Php echo"$ThemeTopoImg00"; ?>" width="12" height="15">					
				</a>
				<a class="fonte_AttribTopo">
					<img border="0" src="imagens/<?Php echo"$ThemeTopoImg01"; ?>" width="12" height="15">			
				</a>
					
				<a href="#" class="fonte_AttribTopo"><?Php echo"$usuario"; ?></a>
				<a href="<?Php echo"$AttribLinkTopo[1]"; ?>" class="fonte_AttribTopo"><?Php echo"$AttribTopo[1]"; ?></a>
				
				<!-- Menu Sistema -->
				<a onMouseover="show_sistema(event,linkset_sys[0])" onMouseout="delayhide_sistema()" class="fonte_AttribTopo">
					<?Php echo"$AttribTopo[2]"; ?>
				</a>
				<a href="<?Php echo"$AttribLinkTopo[3]"; ?>" class="fonte_AttribTopo"><?Php echo"$AttribTopo[3]"; ?></a>	
				</td>
			</tr>	
		</div>	
		<!-- Fim Linha favoritos -->	
		<!-- Referencia menu Sistema -->	
		<div id="pop_sistema" class="sistema_skin" onMouseover="clearhide_sistema();highlight_sistema(event,'on')" onMouseout="highlight_sistema(event,'off');dynamichide_sys(event)"><div>						
		<!------------------------------------------------------------------------------------------------------------->

		<tr align="center"  height="5" valign="top">
			<td width="100%" colspan="1"  align="center"  height="5" valign="top">&nbsp;</td>
		</tr>
		<tr align="center"  height="5" valign="top">
			<td width="100%" colspan="1"  align="center"  height="5" valign="top">&nbsp;</td>
		</tr>
		<tr align="center"  height="5" valign="top">
			<td width="100%" colspan="1"  align="center"  height="5" valign="top">&nbsp;</td>
		</tr>
		<tr align="center"  height="5" valign="top">
			<td width="100%" colspan="1"  align="center"  height="5" valign="top">
			<!-- MENU COM ABAS -------------- <div id="menu" --------------------------->	
				<?Php include 'config/menu_abas.inc'; ?>
			<!-- Menu-Abas -------------------</DIV> ----------------------------------->
	
			<!------------------------- Inicio Conte�do central -------------------------------------------------------------------->
			
			<div id="conteudo_Central"><!-- Conte�do Central(Esq, Pesq, Dir)-->

			<!-- Conte�do Main - Margem -->
			<table class="TAB_MainConteudoExtMargem" width=100% align="center" valign="top"> <!-- Margem -->	
			<tr>
			
			<!-- Conte�do Main Esquerdo -->
			<td width="20%" colspan="1"  align="left"  height="20" valign="top">

			</form><!-- Form Localizar, inserido aqui devido linhas indesejaveis no IE -->
			<form name="Excluir" method="post" action="excluir.php">				<!-- Excluir -->

	<?Php	
			
		if( isset($_REQUEST['BtExcluirCript']) ){ 
				
			$SnInfo = $_POST['EdPassCript'];
			if($SnInfo<>''){
				if( $ObjMySql->Excluir($RegURL) ){
					//echo"<a class='fonte_info'>Registro excluido com sucesso !</a>";	
					$ObjFuncao->Mensagem("Sucesso!", "Registro excluido com sucesso !", Null, Null, defAviso, defSucesso);
					$ExibirTab = false;										
				}
				
			}else{ 								
				echo"<a class='fonte_atencao'>Erro! Voce deve informar a senha de encriptacao deste registro ?</a>";	
			}
			
		}else if( isset($_REQUEST['BtExcluirOpen']) ){ 

			if( $ObjMySql->Excluir($RegURL) ){
				$ObjFuncao->Mensagem("Sucesso!", "Registro excluido com sucesso !", Null, Null, defAviso, defSucesso);
				//echo"<a class='fonte_info'>Registro excluido com sucesso !</a>";					
			}					

		}else{					
			if($ExibirTab){  
				$ObjFuncao->Mensagem("Atenção!", "Tem certeza que deseja excluir este registro ? ", Null, Null, defAviso, defAtencao);
				//echo"<a class='fonte_atencao'>Tem certeza que deseja excluir este registro ? E112</a>"; 
			}					
		}
		
		
		if($ExibirTab){  // Verifica se registro possui FlagCripto, Tira Flag						
			
			$ComandosX = $ResCltMySql[4];
			$ResCmdFlag = $ObjFuncao->FlagCripto($ComandosX);	

	?>
		
			<!-- Conte�do Main Esquerdo -->
			<table class="TAB_MainConteudoExt" width=100% align="center"  valign="top"> <!-- Sem Margem -->				
			<tr><!-- Conte�do Central(Esq, Pesq, Dir) -->
				<!-- Conte�do da Pesquisa (Resultdados)-->
				<td width="60%" colspan="1"   height="20" align="left" valign="top">
				<div id="conteudo_pesquisa"><!-- Conte�do da Pesquisa (Resultdados)-->
				<!------------------------------------ Inicio Conteudo de  ------------------------------------------------------------------>				

				<br>
				<table class="TAB_ConteudoTitulo" width=100% align="center" valign="top"> 									
				<!------------------------ Linha - Ini ---------------------------------------------------->
				<tr align="left"  height="5" valign="top">
					<td width="50%" colspan="1"  align="left"  height="5" valign="top"><?Php $ObjFuncao->espaco(2); ?>
						<i><?Php echo"$ResCltMySql[0] $ResCltMySql[1]"; /* $Topico */ ?></i>
						<img border="0" src="imagens/<?Php echo"$ThemeCorLinhaMenu"; ?>" width="500" height="5">						
					</td>
					<td width="50%" colspan="1"  align="right"  height="5" valign="top"><?Php $ObjFuncao->espaco(2); ?>
						
					<td>
				</tr>
				<!------------------------ Linha - Fim ---------------------------------------------------->
				</table>
			
				
					
				<tr align="left"  height="5" valign="top">
				<td width="100%" colspan="1"  align="center"  height="5" valign="top">
					
				</td></tr>
								
				<table class="TAB_ConteudoIntMargem" width=90% align="center" valign="top"> 					
				<tr><td>
					<table class="TAB_ConteudoInt" width=100% align="center" valign="top"> 						
												
<?Php				// Controla Num de linhas do TexteArea					
					$NumLinha = $ObjFuncao->ContarLinhas($ResCltMySql[3]);	// Conta Num Linhas da String Comando													
					if($NumLinha < 10){$NumLinha =10; }			// Ajustes visuais
					else{	$NumLinha += $NumLinha/20;}
					
					$ObjFuncao->espaco(1);					
					echo "<font size='2'>$ResCltMySql[1]</font></i>";		/* $Procedimento */ 
					echo "<i><font size='2'> ($ResCltMySql[2]) - [$ResCltMySql[10]]</font></i>"; 	/* $Descricao */
?>
						<tr>
							<td width="100%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">								
								<TEXTAREA ID="TxComando" COLS="100" ROWS="<?Php echo"$NumLinha"; ?>" readonly="readonly" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);">
									<?Php echo"$ResCltMySql[3]  $ResCltMySql[4]"; /* $Comando */; ?>
								</TEXTAREA>
											
							</td>
						</tr>				
					</table>
					<!-- <?Php $ObjFuncao->espaco(3); ?><input type="submit" name="BtEditar" value="Excluir">	-->
					<tr>
							<!-- <form name="Descripto" method="post" action="editar.php?<?Php echo "topico=".$TopicoURL;?>"><!-- Form Localizar, inserido aqui devido espa�os que cria no IE -->
								<td width="100%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">
								
							<?Php								
								if($ResCmdFlag[0] == defFlagCripto){ // Se Reg esta Cripto...?>										
									Senha:<input type="password" name="EdPassCript" size="8">					
									<input type="submit" name="BtExcluirCript" value="Excluir">									
								<?Php }else{  ?>										
									<input type="submit" name="BtExcluirOpen" value="Excluir">									
								<?Php } ?>					

											
								</td>							
						</tr>	
				</td></tr></table>
				
				<BR><BR>	
						
		
				<!------------------------------------ Final Conteudo de  ------------------------------------------------------------------->				
				</div><!-- Conte�do da Pesquisa (Resultdados)-->
			</td><!-- Conte�do da Pesquisa (Resultdados)-->
			
			<!-- Conte�do Direito(Publicidades) -->
			<td width="20%" colspan="1"   height="20" valign="top">
				<div id="conteudo_direito"><!-- Conte�do Direito(Publicidades) -->
					  &nbsp;<!-- Resevado Publicidade -->
				</div><!-- Conte�do Direito(Publicidades)-->			
			</td><!-- Conte�do Direito(Publicidades) -->
			
			
			</tr><!-- Conte�do Central(Esq, Pesq, Dir) -->
			</table><!-- Conte�do Central(Esq, Pesq, Dir) -->   
			</td></tr></table><!-- Conte�do Central - Margem -->
			</div><!-- Conte�do Central(Esq, Pesq, Dir) -->	
			
		<!------------------------- Final Conte�do central -------------------------------------------------------------------->
	</td></tr></table> 	
	<?Php 		
		}  // ExibirTabela - caso haja registros para exibir 
	?>	

	</div><!-- Geral Direito -->
	
	</td>
	</tr>
	</form><!-- Localizar -->
	</table>
	
	<!-------------------------------- Final Geral Direito -------------------------------------------------------------------->
	
	<div id="rodape"><!-- Rodap� -->
		<table class"TAB_Rodape" width=100% align="center" valign="top">	
		<tr align="center"  height="5" valign="top">
			<td width="15%" colspan="1"  align="left"  height="5" valign="top"></td>		
			<td width="70%" colspan="1"  align="left"  height="5" valign="top">		
				<a href="<?Php echo"$AttribRodapeLink00"; ?>" class="fonte_rodape"><?Php echo"$AttribRodape00"; ?></a>
				&nbsp;			
				<a href="<?Php echo"$AttribRodapeLink01"; ?>" class="fonte_rodape"><?Php echo"$AttribRodape01"; ?></a>			
			</td>
			<td width="15%" colspan="1"  align="left"  height="5" valign="top">
				<img border="0" src="imagens/<?Php echo"$AttribRodapeImg00"; ?>" width="88" height="31">
				<img border="0" src="imagens/<?Php echo"$AttribRodapeImg01"; ?>" width="88" height="31">
			</td>		
		</tr>
		</table>	
	
	</div><!-- Rodap� -->


</div><!-- Pagina Geral --> 


	
</body>

</html>