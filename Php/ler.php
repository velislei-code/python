
<?Php
	
	$AttribPosAbaA = 0; //$_COOKIE['CookieAttribPosAbaA']; // Posi��o das abas "A"
	// Inicializa var
	$BotaoVoltar = 0;			
	$BotaoAvanco = 0;					

	if( isset($_REQUEST['reg']) ){
		$RegURL = $_REQUEST['reg'];
		setcookie ("CookieRegURL", $RegURL, time()+21600);	
				 
	}else{
		if(isset($_COOKIE['CookieRegURL'])){
			$RegURL = $_COOKIE['CookieRegURL'];
		}else{
			$RegURL = '';
		}
	}
	
	if( isset($_REQUEST['topico']) ){			
		$TopicoURL = $_REQUEST['topico'];
		setcookie ("CookieTopicoURL", $TopicoURL,time()+21600);
	}else{
		if( isset($_COOKIE['topico']) ){		
			$TopicoURL = $_COOKIE['CookieTopicoURL'];
		}ELSE{
			$TopicoURL = "";
		}
	}

	include 'config/cabecario.inc';
	$objFuncao->RegistrarLog('ler.php;');
//*****************************************
// Verificar Autentica��o
	$usuario = $ObjFuncao->VerAutenticacao();	
//*****************************************
	$AbaAtivaB = $AttribAbaIntB[2];	// Informa qual Aba deve ser selecionada
	
//*********************************************************************************************
	// Registra data do acesso ao registro (Null: registra ou Clear: limpar)
	$ObjMySql->Recentes($RegURL, Null); 					
	
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
	<!-- function PopWindow(URL,windowName,features){ window.open(URL,windowName,features); -->
</script>

<body BGCOLOR="<?Php echo"$ThemeCorFundoBody"; ?>" ><!-- BACKGROUND="PParede/cristal.png" --> 	
<div id="geral"><!-- Pagina Geral -->	


	<table class="TAB_Geral" width="100%" align="center" valign="top">
	<form name="Localizar" method="post" action="localizar.php?<?Php echo "topico=".$TopicoURL;?>"><!-- Form Localizar, inserido aqui devido espa�os que cria no IE -->
	<tr align="center"  height="50" valign="top">
	
	<!-------------------------------- Inicio Geral Esquerdo -------------------------------------------------------------------->
	
	<td width="15%" colspan="1"  align="center"  height="5" valign="top">
	
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
					</a>					
					</td>
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
							<?Php echo"$AttribMenuSobre00";?><!-- Vlans -->
						</a>, 
						<a href="<?Php echo"$AttribMenuSobreLink01"; ?>" class="fonte_menu_esq">
							<?Php echo"$AttribMenuSobre01";?><!-- IPv6 -->
						</a>,
						<a href="<?Php echo"$AttribMenuSobreLink02"; ?>" class="fonte_menu_esq">
							<?Php echo"$AttribMenuSobre02";?><!-- GPon -->
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

			<!-- Conte�do Main Esquerdo -->
			<table class="TAB_MainConteudoExt" width=100% align="center"  valign="top"> <!-- Sem Margem -->				
			<tr><!-- Conte�do Central(Esq, Pesq, Dir) -->
				<!-- Conte�do da Pesquisa (Resultdados)-->
				<td width="60%" colspan="1"   height="20" align="left" valign="top">
				<div id="conteudo_pesquisa"><!-- Conte�do da Pesquisa (Resultdados)-->
				<!------------------------------------ Inicio Conteudo de  ------------------------------------------------------------------>				

				<br>
		<?Php if($ExibirTab){   // ExibirTabela - caso haja registros para exibir ?>		
				<table class="TAB_ConteudoTitulo" width=100% align="center" valign="top"> 									
				<!------------------------ Linha - Ini ---------------------------------------------------->
				<tr align="left"  height="5" valign="top">
					<td width="50%" colspan="1"  align="left"  height="5" valign="top"><?Php $ObjFuncao->espaco(2); ?>
						<i><?Php echo"$ResCltMySql[0]->"; /* $Assunto */ ?></i>
						<i><?Php echo"$ResCltMySql[1]"; /* $Topico */ ?></i>
						<img border="0" src="imagens/<?Php echo"$ThemeCorLinhaMenu"; ?>" width="500" height="5">						
					</td>
					<td width="50%" colspan="1"  align="right"  height="5" valign="top"><?Php $ObjFuncao->espaco(2); ?>
					<!-- <button type="button" onclick="window.location='editar.php'">Editar</button> -->
						<!-- <a href="editar.php" class="fonte_lista">[Editar]</a> -->
					<td>
				</tr>
				<!------------------------ Linha - Fim ---------------------------------------------------->
				</table>
		
	
							
				<table class="TAB_ConteudoIntMargem" width=90% align="center" valign="top">					
				<tr><td>
					<table class="TAB_ConteudoInt" width=100% align="center" valign="top"> 						
					<tr>
						<td width="90%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">
					
<?Php				// Controla Num de linhas do TexteArea					
					$NumLinha = $ObjFuncao->ContarLinhas($ResCltMySql[4]);	// Conta Num Linhas da String Comando													
					if($NumLinha < 40){$NumLinha = 40; }			// Ajustes visuais
					else{	$NumLinha += ($NumLinha/20) + 1; }
					
					$ObjFuncao->espaco(1);					
					echo "<font size='2'>$ResCltMySql[2]</font></i>";		/* $Procedimento */ 
					echo "<i><font size='2'> ($ResCltMySql[3]) - [$ResCltMySql[10]]</font></i>"; 	/* $Descricao */
					
					if(!empty($ResCltMySql[2])){	$iTamProc = strlen($ResCltMySql[2]); }else{$iTamProc = 0;}
					if(!empty($ResCltMySql[3])){	$iTamDesc = strlen($ResCltMySql[3]); }else{ $iTamDesc = 0;}
					
					$Espacos = 95 - ($iTamProc + $iTamDesc);
					
					if(!empty($ResCltMySql[4])){				
						$linhas = explode("\n", $ResCltMySql[4]);
						$iNumLin = count($linhas) + 250;
						if($iNumLin > 300){ $iNumLin = 700; }
						//echo $iNumLin;
						
						$ComandosX = $ResCltMySql[4];
						
						$ResCmd = $ObjFuncao->FlagCripto($ComandosX);	// Verifica se registro possui FlagCripto, Tira Flag
						if($ResCmd[0] == defFlagCripto){
							$MostrarBt = true;		// Se Sim, habilitar bt-salvar direto
							$Comandos = $ResCmd[1];
						}else{						
							$MostrarBt = false;		// Se Não, habilitar bt-salvar direto
							$Comandos = $ComandosX;
						}	
					}else{
						$MostrarBt = false;		// Se Não, habilitar bt-salvar direto
						$iNumLin = 250;
					}
					/*
					$Comandos = $ResCltMySql[4];
					$MostrarBt = true;		// Se Sim, habilitar bt-salvar direto
					*/

					if( isset($_REQUEST['BtDescripto']) ){ 
						$SnInfo = md5($_POST['EdPass']);	// converte senha digitada p/ hash md5
						//$Md5Repositorio = $ObjFuncao->LocHash($RepositorioHash, $SnInfo);
						$Dd_descripto = $ObjFuncao->Decripto($Comandos, $SnInfo);
						$Comandos = $Dd_descripto;
					}
	
					
					/* $str = '1234';
					echo 'MD5-> '.md5($str).'<br>';
					if (md5($str) === '81dc9bdb52d04dc20036dbd8313ed055') {
						echo "Acesso liberado".'<br>';
					}else{
						echo 'O hash não confere!'.'<br>';
					}	*/

?>
					</td><td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">

					<!--- Chama janela Pop-Up -->
					
					<!-- <button type="button" onClick="PopWindow('ler_popup.php','Nome da Janela','width=760,height=<?Php echo"$iNumLin"; ?>,scrollbars=yes')">Pop-up</button> -->
					<!-- <a href="#" onClick="PopWindow('ler_popup.php','Nome da Janela','width=760,height=<?Php echo"$iNumLin"; ?>,scrollbars=yes')">[Pop-up]</a> -->							
					<img src="imagens/popup.png" onmouseover="" style="cursor: pointer;" width="25" height="25" onClick="PopWindow('ler_popup.php','Nome da Janela','width=760,height=<?Php echo"$iNumLin"; ?>,scrollbars=yes')" alt="Pop-Up" title="Pop-Up">
					</td></tr>
					<tr>
							<td width="100%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">
								<!-- readonly="readonly" hidden ou visible -->							
								<TEXTAREA ID="TxComando" COLS="100" ROWS="<?Php echo"$NumLinha"; ?>" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);"> 
									<?Php 
										//echo "$ResCltMySql[2]($ResCltMySql[3])";		/* $Procedimento(Descricao)*/ 
										
										echo"$Comandos  Data: $ResCltMySql[6], Local: $ResCltMySql[5]"; /* $Comando */; 
									?>
								</TEXTAREA>
											
							</td>
						</tr>	
						</form><!-- Localizar -->
						<?Php if($MostrarBt){ ?>
						<tr>
							<form name="Descripto" method="post" action="ler.php?<?Php echo "topico=".$TopicoURL;?>"><!-- Form Localizar, inserido aqui devido espa�os que cria no IE -->
								<td width="100%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">

								Senha:<input type="password" name="EdPass" size="10" value="<?Php ?>" >					
										<input type="submit" name="BtDescripto" value="Descriptografar">
								</td>
							</form>
						</tr>	
						<?Php } ?>
					</table>
					
				</td></tr></table>
		<?Php }   // ExibirTabela - caso haja registros para exibir ?>
					
						
		
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
	</div><!-- Geral Direito -->
	
	</td>
	</tr>
	
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