
<?Php
	
	$AttribPosAbaA = 3; // Posição das abas "A" (Declara Antes di Include)
	// Inicializa var
	$BotaoVoltar = 0;					
	$BotaoAvanco = 0;					

	include 'config/cabecario.inc';
	
//*****************************************
// Verificar Autenticação
	$usuario = $ObjFuncao->VerAutenticacao();	
//*****************************************
	
	// inicia var
	$AttribLinkAbaIntB[]="";
	$ResPesquisa[][]="";
	$ResPesquisa[][]="";
?>
<body BGCOLOR="<?Php echo"$ThemeCorFundoBody"; ?>" ><!-- BACKGROUND="PParede/cristal.png" --> 	
<div id="geral"><!-- Pagina Geral -->	

	<form name="Pesquisar" method="post" action="icx.php"><!-- Form Localizar, inserido aqui devido espaços que cria no IE -->
		
	<table class="TAB_Geral" width="100%" align="center" valign="top">
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
		
		<table class="TAB_GeralDireito" width="100%" align="center" valign="top"> <!-- cellspacing="0" cellpadding="0" height="5"  BGCOLOR="<?Php echo"$ThemeCorFundoBody"; ?>> -->
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
		
			<!------------------------- Inicio Conteúdo central -------------------------------------------------------------------->
			
			<div id="conteudo_Central"><!-- Conteúdo Central(Esq, Pesq, Dir)-->

			<!-- Conteúdo Main - Margem -->
			<table class="TAB_MainConteudoExtMargem" width=100% align="center" valign="top"> <!-- Margem -->	
			<tr>
			
			<!-- Conteúdo Main Esquerdo -->
			<td width="20%" colspan="1"  align="left"  height="20" valign="top">

						
			<!-- Conteúdo Main Esquerdo -->
			<table class="TAB_MainConteudoExt" width=100% align="center"  valign="top"> <!-- Sem Margem -->				
			<tr><!-- Conteúdo Central(Esq, Pesq, Dir) -->
				<!-- Conteúdo da Pesquisa (Resultdados)-->
				<td width="60%" colspan="1"   height="20" align="left" valign="top">
				<div id="conteudo_pesquisa"><!-- Conteúdo da Pesquisa (Resultdados)-->
				<!------------------------------------ Inicio Conteudo de tópico ------------------------------------------------------------------>				
						
<?Php
				//*********************************************************************************************
				//Consulta LISTA DE TÓPICOS	
				if(isset($_COOKIE['TopicoXCookie'])){
					$RegTopicoCur = $_COOKIE['TopicoXCookie'];
				}else{
					$RegTopicoCur = "";
				}
				
				// Rotina para memorizar Opção corrente(Cookie)
				if(isset($_POST['EdLocalizar'])){
					$PesquisarX = $_POST['EdLocalizar'];
					setcookie ("PesquisaXCookie", $PesquisarX,time()+21600);
				}else{
					if(isset($_COOKIE['PesquisaXCookie'])){
						$PesquisarX = $_COOKIE['PesquisaXCookie'];
					}else{
						$PesquisarX = "";
					}
				}

				
				// Consulta topico
				/*
					$link = mysql_connect('localhost', 'root', '');
					mysql_select_db('Rede', $link);
					$sql = "SELECT assunto,topico FROM comandos where registro='$RegTopicoCur'";
					$result = mysql_query($sql, $link);
					while ($row = mysql_fetch_assoc($result)) {	$TopicoAttribAtual=$row['topico']; 	}
					mysql_free_result($result);					
				*/
				$TopicoAttribAtual = $ObjMySql->QueryItemAttribAtual('topico',$RegTopicoCur);
				
				//*********************************************************************************************
				// Pesquisa item...
				$ResPesquisa = $ObjMySql->Localizar($TopicoAttribAtual, $PesquisarX);
				$TotalP = count($ResPesquisa);
				
				if($TopicoAttribAtual == ""){ $MostrarTopico = "Geral";}
				else{ $MostrarTopico = $TopicoAttribAtual;}
					
				//*********************************************************************************************
				
				
				
?>
				
				<br>
				<table class="TAB_ConteudoTitulo" width=100% align="center" valign="top"> 					
				<!------------------------ Linha - Ini ---------------------------------------------------->
				<tr align="left"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php $ObjFuncao->espaco(2); ?>
						<i><?Php echo"Pesquisa privada(Tóp: $MostrarTopico)"; ?></i><BR>
						<img border="0" src="imagens/<?Php echo"$ThemeCorLinhaMenu"; ?>" width="500" height="5">
					</td>
				</tr>
				<!------------------------ Linha - Fim ---------------------------------------------------->
				</table>
				</form><!-- Pesquisar -->
				<br><br>				
	
	<?Php
	
		
	if(isset($_POST['BtCalcICX'])||isset($_POST['CxPorta'])){	
		
			
		// Calc OLT -> ICX
			$xPlaca = $_POST['CxPlaca'];
			$xPorta = $_POST['CxPorta'];
							
			$PosCorrida = (($xPlaca-1) * 16) + $xPorta;   // Posição corrida das portas
			$CalcICX = $PosCorrida/24;
			$CalcICX = intval($CalcICX);
			$CalcPinoICX = $PosCorrida - ($CalcICX*24);
			$CalcICX = $CalcICX + 1;
			
			$xICX = $CalcICX;
			$xPinoICX = $CalcPinoICX;
	
				
	}
	
	if(isset($_POST['BtCalcOLT'])||isset($_POST['CxPinoICX'])){	
	
			// Calc OLT -> ICX
			
			
			$xICX = $_POST['CxICX'];
			$xPinoICX = $_POST['CxPinoICX'];
			
			
			// Calc ICX -> OLT	
			$PosCorrida = (($xICX-1) * 24) + $xPinoICX;   // Posição corrida das portas
			
			$CalcOLT = $PosCorrida/16;
			$CalcPlaca = intval($CalcOLT);
			$CalcPorta = $PosCorrida - ($CalcPlaca*16);
			$CalcPlaca = $CalcPlaca + 1;
			
			// Ajuste(Qdo resto é zero...ajusta cálculo)
			if($CalcPorta == 0){
				$xPlaca = $CalcPlaca-1;
				$xPorta = 16;
			}else{
				$xPlaca = $CalcPlaca;
				$xPorta = $CalcPorta;
            }	

			if($xPlaca>16){
				$xPlaca = "Exedeu!";
				
			}	
	
				
	}
	
		
		
	
	?>
				<table class="TAB_ConteudoIntMargem" width=90% align="center" valign="top"> 	
				<tr><td>
					<table class="TAB_ConteudoInt" width=100% align="center" valign="top"> 
						<tr></tr>
						<form name="ICX" method="post" action="icx.php"><!-- Form Localizar, inserido aqui devido espaços que cria no IE -->
					
						<tr>
							<td width="10%" colspan="1" height="20" align="left" valign="top">ICX:</td>
							<td width="10%" colspan="1" height="20" align="left" valign="top">
							<i><select name="CxICX" onchange="this.form.submit();">
							<option><?Php echo"$xICX"; ?></option>
							<?Php for($Pl=1; $Pl<=12; $Pl++){ ?>
							<option><?Php echo"$Pl"; ?></option>
							<?Php } ?>							
							</select>	
							</td>
							<td width="10%" colspan="1" height="20" align="left" valign="top">Pino:</td>
							<td width="10%" colspan="1" height="20" align="left" valign="top">
							<i><select name="CxPinoICX" onchange="this.form.submit();">
							<option><?Php echo"$xPinoICX"; ?></option>
							<?Php for($Pt=1; $Pt<=24; $Pt++){ ?>
							<option><?Php echo"$Pt"; ?></option>
							<?Php } ?>							
							</select>	
							</td>	
								
							<td width="10%" colspan="1" height="20" align="left" valign="top"></td>
							<td width="10%" colspan="1" height="20" align="left" valign="top">							
								<!-- <input type="submit" name="BtCalcOLT" value="Calc"> -->
							</td>
							<td width="60%" colspan="1" height="20" align="left" valign="top">
							<?Php
								//	echo "ICX: $xICX/$xPinoICX -> OLT: $CalcPlaca / $CalcPorta";
							?>
														
							</td>
						</tr>
						</form>
						
						<form name="OLT" method="post" action="icx.php"><!-- Form Localizar, inserido aqui devido espaços que cria no IE -->

						<!----------------  OLT  --------------------------------------------------> 
						<tr>
							<td width="10%" colspan="1" height="20" align="left" valign="top">Placa:</td>
							<td width="10%" colspan="1" height="20" align="left" valign="top">
							<i><select name="CxPlaca" onchange="this.form.submit();">
							<option><?Php echo"$xPlaca"; ?></option>
							<?Php for($Pl=1; $Pl<=16; $Pl++){ ?>
							<option><?Php echo"$Pl"; ?></option>
							<?Php } ?>							
							</select>	
							</td>
							<td width="10%" colspan="1" height="20" align="left" valign="top">Porta:</td>
							<td width="10%" colspan="1" height="20" align="left" valign="top">
							<i><select name="CxPorta" onchange="this.form.submit();">
							<option><?Php echo"$xPorta"; ?></option>
							<?Php for($Pt=1; $Pt<=16; $Pt++){ ?>
							<option><?Php echo"$Pt"; ?></option>
							<?Php } ?>							
							</select>	
							</td>	
								
							<td width="10%" colspan="1" height="20" align="left" valign="top"></td>
							<td width="10%" colspan="1" height="20" align="left" valign="top">							
								<!--<input type="submit" name="BtCalcICX" value="Calc"> -->
							</td>
							<td width="60%" colspan="1" height="20" align="left" valign="top">
							<?Php
								//	echo "OLT: $xPlaca/$xPorta -> ICX: $CalcICX / $CalcPinoICX";
							?>
							
							</td>
						</tr>
						</form>						
						<tr>
							<td width="10%" colspan="1" height="20" align="left" valign="top"></td>
							<td width="90%" colspan="4" height="20" align="left" valign="top">
								<!--<input type="text" name="EdOct1" size="1" value="" >: -->
								
							</td>
							<td width="5%" colspan="1" height="20" align="left" valign="top"></td>
						</tr>
						
					
					</table>
				</td></tr></table>	
				<BR><BR>	
						
				<!------------------------------------ Final Conteudo de tópico ------------------------------------------------------------------->				
				</div><!-- Conteúdo da Pesquisa (Resultdados)-->
			</td><!-- Conteúdo da Pesquisa (Resultdados)-->
			
			<!-- Conteúdo Direito(Publicidades) -->
			<td width="20%" colspan="1"   height="20" valign="top">
				<div id="conteudo_direito"><!-- Conteúdo Direito(Publicidades) -->
					  &nbsp;<!-- Resevado Publicidade -->
				</div><!-- Conteúdo Direito(Publicidades)-->			
			</td><!-- Conteúdo Direito(Publicidades) -->
			
			
			</tr><!-- Conteúdo Central(Esq, Pesq, Dir) -->
			</table><!-- Conteúdo Central(Esq, Pesq, Dir) -->   
			</td></tr></table><!-- Conteúdo Central - Margem -->
			</div><!-- Conteúdo Central(Esq, Pesq, Dir) -->	
			
		<!------------------------- Final Conteúdo central -------------------------------------------------------------------->
	</td></tr></table> 		
	</div><!-- Geral Direito -->
	
	</td>
	</tr>
	
	</table>
	
	<!-------------------------------- Final Geral Direito -------------------------------------------------------------------->
	
	<div id="rodape"><!-- Rodapé -->
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
	
	</div><!-- Rodapé -->


</div><!-- Pagina Geral --> 


	
</body>

</html>