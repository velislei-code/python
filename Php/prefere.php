
<?Php
	
	$AttribPosAbaA = 1; // Posi��o das abas "A" (Declara Antes di Include)
	// Inicializa var
	$BotaoVoltar = 0;			
	$BotaoAvanco = 0;	
	include 'config/cabecario.inc';
	
//*****************************************
// Verificar Autentica��o
	$usuario =  $ObjFuncao->Autenticar();	
//*****************************************
	
	$AbaAtiva = $AbaIntA[1];	// Informa qual Aba deve ser selecionada
	$AttribLinkAbaIntM[1] = $LinkAbaIntA[2];	// Igual ao pr�ximo, isto faz avan�ar

	
?>
<script language="javascript">
<!--
function PopWindow(URL,windowName,features)
{ 
	window.open(URL,windowName,features);
}
//-->
</SCRIPT>

<body BGCOLOR="<?Php echo"$ThemeCorFundoBody"; ?>" ><!-- BACKGROUND="PParede/cristal.png" --> 	
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
					<img src = "imagens/<?Php echo "$ThemeGlobo"; ?>" />
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
		
		<table class="TAB_GeralDireito" width="100%" align="center" valign="top"> <!-- cellspacing="0" cellpadding="0" height="5"  BGCOLOR="<?Php echo"$FundoFundoBody"; ?>> -->
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
			<td width="20%" colspan="1"  align="left" height="20" valign="top">

			</form><!-- Form Localizar, inserido aqui devido linhas indesejaveis no IE -->
			<form name="Preferencias" method="post" action="prefere.php">				<!-- Editar -->

			<!-- Conte�do Main Esquerdo -->
			<table class="TAB_MainConteudoExt" width=100% align="center"  valign="top"> <!-- Sem Margem -->				
			<tr><!-- Conte�do Central(Esq, Pesq, Dir) -->
				<!-- Conte�do da Pesquisa (Resultdados)-->
				<td width="60%" colspan="1" height="20" align="left" valign="top">
				<div id="conteudo_pesquisa"><!-- Conte�do da Pesquisa (Resultdados)-->
				<!------------------------------------ Inicio Conteudo de t�pico ------------------------------------------------------------------>				
						

	
				<br>
				<table class="TAB_ConteudoTitulo" width=100% align="center" valign="top"> 					
				<!------------------------ Linha - Ini ---------------------------------------------------->
				<tr align="left"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php $ObjFuncao->espaco(2); ?>
						<i>Preferencias</i><BR>
						<img border="0" src="imagens/<?Php echo"$ThemeCorLinhaLonga"; ?>" width="500" height="5">
					</td>
				</tr>
				<!------------------------ Linha - Fim ---------------------------------------------------->
				</table>


				<BR><BR>
				<table class="TAB_ConteudoIntMargem" width=90% align="center" valign="top" > 					
				<tr><td>
							<?Php  					
	
								if($_POST){
									
									/*
									 * Se a��o = Limpar historico...executa
									 */	
									if($_POST['CxHistorico'] =="Sim"){
										/* Registra data do acesso ao registro e/ou limpa hist�rico - Recentes(Registro, Acao);	 */
										$CxHistorico =  $ObjMySql->Recentes(Null, "Clear"); 
									}else{
										setcookie ("TemaFundoCookie", $_POST['CxFundo']); 
										setcookie ("TemaMenuCookie", $_POST['CxMenu']); 
										setcookie ("TemaTextoCookie", $_POST['CxTexto']); 
										setcookie ("TemaBordaExtCookie", $_POST['CxBordaExt']); 
										setcookie ("TemaTabExtCookie", $_POST['CxTabelaExt']); 
										setcookie ("TemaBordaIntCookie", $_POST['CxBordaInt']); 
										setcookie ("TemaTabIntCookie", $_POST['CxTabelaInt']); 
										setcookie ("TemaBordaPsqCookie", $_POST['CxBordaPsq']); 
										setcookie ("TemaTabPsqCookie", $_POST['CxTabelaPsq']); 								
									
										echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=prefere.php?cor=?'>";
									}
								}else{
									$CxHistorico = "Nao";
								}
								
								$Fundo = $_COOKIE['TemaFundoCookie'];									
								$Menu = $_COOKIE['TemaMenuCookie'];									
								$ThemeTexto = $_COOKIE['TemaTextoCookie'];									
								$ThemeBordaExt = $_COOKIE['TemaBordaExtCookie'];									
								$TabelaExt = $_COOKIE['TemaTabExtCookie'];									
								$ThemeBordaInt = $_COOKIE['TemaBordaIntCookie'];									
								$TabelaInt = $_COOKIE['TemaTabIntCookie'];	
								$ThemeBordaPsq = $_COOKIE['TemaBordaPsqCookie'];									
								$TabelaPsq = $_COOKIE['TemaTabPsqCookie'];	
								
								
								if($Fundo == ''){ $Fundo = 'Selecionar';} 
								if($Menu == ''){ $Menu = 'Selecionar';} 
								if($ThemeTexto == ''){ $ThemeTexto = 'Selecionar';} 								
								if($ThemeBordaExt == ''){ $ThemeBordaExt = 'Selecionar';} 
								if($TabelaExt == ''){ $TabelaExt = 'Selecionar';} 
								if($ThemeBordaInt == ''){ $ThemeBordaInt = 'Selecionar';} 
								if($TabelaInt == ''){ $TabelaInt = 'Selecionar';} 
								if($ThemeBordaPsq == ''){ $ThemeBordaPsq = 'Selecionar';} 
								if($TabelaPsq == ''){ $TabelaPsq = 'Selecionar';} 
								
							?>     			
					<table class="TAB_ConteudoInt" width=100% align="center" valign="top" > 
					<br>	
					<tr>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">Tema:</td>
							<td width="35%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">
							<select size="1" name="CxFundo" title="Selecione a Cor." onchange="this.form.submit();" style="background-Color: #FFFFFF; border: border: 1px solid gray; font-size:8pt">									
								<option><?Php echo"$Fundo"; ?></option>
								<option>Padr�o</option>
								<option>Branco</option>
								<option>Ciano</option>
								<option>Marinho</option>
								<option>Grafite</option>
								<option>Cinza</option>								
								<option>Verde</option>			
								<option>Musgo</option>			
								<option>Marrom</option>								
								<option>Laranja</option>							
								<option>Amarelo</option>							
								<option>Vermelho</option>							
							</select>																
							</td>
							<td width="35%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>																	
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
						</tr>
						<tr>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">Menu:</td>
							<td width="35%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">
							<select size="1" name="CxMenu" title="Selecione o Menu." onchange="this.form.submit();" style="background-Color: #FFFFFF; border: border: 1px solid gray; font-size:8pt">									
								<option><?Php echo"$Menu"; ?></option>								
								<option>Padr�o</option>
								<option>Simples(tab)</option>
								<option>Simples(img)</option>
								<option>Barra(grafite)</option>
								<option>Barra(verde)</option>								
								<option>Bot�o(branco)</option>			
								<option>Bot�o(Grafite)</option>								
								<option>Estilo(verde)</option>							
								<option>Estilo(Win)</option>							
							</select>								
							</td>
							<td width="35%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
						</tr>
						<tr>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">Texto:</td>
							<td width="35%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">
							<select size="1" name="CxTexto" title="Selecione o Borda externa" onchange="this.form.submit();" style="background-Color: #FFFFFF; border: border: 1px solid gray; font-size:8pt">									
								<option><?Php echo"$ThemeTexto"; ?></option>								
								<option>Padr�o</option>
								<option>Ciano</option>
								<option>Marinho</option>
								<option>Grafite</option>
								<option>Cinza</option>								
								<option>Verde</option>	
								<option>Musgo</option>		
								<option>Marrom</option>								
								<option>Laranja</option>							
								<option>Amarelo</option>							
								<option>Vermelho</option>							
							</select>								
							</td>
							<td width="35%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
						</tr>

						<tr>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">Borda(ext):</td>
							<td width="35%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">
							<select size="1" name="CxBordaExt" title="Selecione o Borda externa" onchange="this.form.submit();" style="background-Color: #FFFFFF; border: border: 1px solid gray; font-size:8pt">									
								<option><?Php echo"$ThemeBordaExt"; ?></option>								
								<option>Padr�o</option>
								<option>Ciano</option>
								<option>Marinho</option>
								<option>Grafite</option>
								<option>Cinza</option>								
								<option>Verde</option>	
								<option>Musgo</option>		
								<option>Marrom</option>								
								<option>Laranja</option>							
								<option>Amarelo</option>							
								<option>Vermelho</option>							
							</select>								
							</td>
							<td width="35%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
						</tr>
						<tr>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">Tabela(ext):</td>
							<td width="35%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">
							<select size="1" name="CxTabelaExt" title="Selecione o Borda externa" onchange="this.form.submit();" style="background-Color: #FFFFFF; border: border: 1px solid gray; font-size:8pt">									
								<option><?Php echo"$TabelaExt"; ?></option>								
								<option>Padr�o</option>
								<option>Branco</option>
								<option>Ciano</option>
								<option>Marinho</option>
								<option>Grafite</option>
								<option>Cinza</option>								
								<option>Verde</option>	
								<option>Musgo</option>		
								<option>Marrom</option>								
								<option>Laranja</option>							
								<option>Amarelo</option>							
								<option>Vermelho</option>							
							</select>								
							</td>
							<td width="35%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
						</tr>
						<tr>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">Borda(int):</td>
							<td width="35%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">
							<select size="1" name="CxBordaInt" title="Selecione o Borda externa" onchange="this.form.submit();" style="background-Color: #FFFFFF; border: border: 1px solid gray; font-size:8pt">									
								<option><?Php echo"$ThemeBordaInt"; ?></option>								
								<option>Padr�o</option>
								<option>Ciano</option>
								<option>Marinho</option>
								<option>Grafite</option>
								<option>Cinza</option>								
								<option>Verde</option>		
								<option>Musgo</option>	
								<option>Marrom</option>								
								<option>Laranja</option>							
								<option>Amarelo</option>							
								<option>Vermelho</option>							
							</select>								
							</td>
							<td width="35%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
						</tr>
						<tr>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">Tabela(int):</td>
							<td width="35%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">
							<select size="1" name="CxTabelaInt" title="Selecione o Borda externa" onchange="this.form.submit();" style="background-Color: #FFFFFF; border: border: 1px solid gray; font-size:8pt">									
								<option><?Php echo"$TabelaInt"; ?></option>								
								<option>Padr�o</option>
								<option>Branco</option>
								<option>Ciano</option>
								<option>Marinho</option>
								<option>Grafite</option>
								<option>Cinza</option>								
								<option>Verde</option>	
								<option>Musgo</option>		
								<option>Marrom</option>								
								<option>Laranja</option>							
								<option>Amarelo</option>							
								<option>Vermelho</option>							
							</select>								
							</td>
							<td width="35%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
						</tr>				
						
						
						<!-------------------------------------------- Inicio Tabela-Amostra Pesquisa --------------------------------------------->
						<table class="TAB_ConteudoPsq" width=80% align="center" valign="top"> 	
						<tr><td>										
						
						<tr>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">Borda(Psq):</td>
							<td width="35%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">
							<select size="1" name="CxBordaPsq" title="Selecione o Borda externa" onchange="this.form.submit();" style="background-Color: #FFFFFF; border: border: 1px solid gray; font-size:8pt">									
								<option><?Php echo"$ThemeBordaPsq"; ?></option>								
								<option>Padr�o</option>
								<option>Ciano</option>
								<option>Marinho</option>
								<option>Grafite</option>
								<option>Cinza</option>								
								<option>Verde</option>			
								<option>Musgo</option>
								<option>Marrom</option>								
								<option>Laranja</option>							
								<option>Amarelo</option>							
								<option>Vermelho</option>							
							</select>								
							</td>
							<td width="35%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
						</tr>					
						<tr>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">Tabela(Psq):</td>
							<td width="35%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">
							<select size="1" name="CxTabelaPsq" title="Selecione o Borda externa" onchange="this.form.submit();" style="background-Color: #FFFFFF; border: border: 1px solid gray; font-size:8pt">									
								<option><?Php echo"$TabelaPsq"; ?></option>								
								<option>Padr�o</option>
								<option>Branco</option>
								<option>Ciano</option>
								<option>Marinho</option>
								<option>Grafite</option>
								<option>Cinza</option>								
								<option>Verde</option>	
								<option>Musgo</option>		
								<option>Marrom</option>								
								<option>Laranja</option>							
								<option>Amarelo</option>							
								<option>Vermelho</option>							
							</select>								
							</td>
							<td width="35%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
						</tr>
						
						</td></tr></table>
						<!-------------------------------------------- Final Tabela-Amostra Pesquisa ---------------------------------------------> 
						<br>
						
						<!-------------------------------------------- Tabela - Limpar Hist�rico ---------------------------------------------> 
						<table class="TAB_ConteudoPsq" width=80% align="center" valign="top"> 	
						<tr><td>										
						
						<tr>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="45%" colspan="2" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">Limpar historico:</td>
							<td width="35%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">
							<select size="1" name="CxHistorico" title="Limpar historico de navegacao" onchange="this.form.submit();" style="background-Color: #FFFFFF; border: border: 1px solid gray; font-size:8pt">																								
								<option><?Php   echo $CxHistorico; ?></option>
								<option>Nao</option>
								<option>Sim</option>
															
							</select>								
							</td>							
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
						</tr>
						<br>
						</td></tr></table>
						<!-------------------------------------------- Final Tabela-Limpar hist�rico ---------------------------------------------> 
						<br>						
				
				
						</table>
						
						
						
						
				</td></tr></table>	
				<BR><BR>	
			<!------------------- Final Conteudo de t�pico ------------------------------------------------------------------->				
				</div><!-- Conte�do da Pesquisa (Resultdados)-->
			</td><!-- Conte�do da Pesquisa (Resultdados)-->
			
			<!-- Conte�do Direito(Publicidades) -->
			<td width="20%" colspan="1" height="20" valign="top">
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