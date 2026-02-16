
<?Php



				//*********************************************************************************************
				//Consulta LISTA DE T�PICOS
				//$RegURL = $ObjFuncao->itemURL();			// Separa, registro(0), topico(1) clickado da URL
				
			
				if( isset($_REQUEST['reg']) ){
					$RegURL = $_REQUEST['reg'];
					setcookie ("CookieRegURL", $RegURL);								 
				}else{
					$RegURL = $_COOKIE['CookieRegURL'];
				}

				// Memoriza topico p/ retornos				
				if( isset($_REQUEST['topico']) ){
					$TopicoURL = $_REQUEST['topico'];
					setcookie ("TopicoXCookie", $TopicoURL);
				}else{
					if(isset($_COOKIE['TopicoXCookie'])){
						$TopicoURL = $_COOKIE['TopicoXCookie'];
					}else{
						$TopicoURL = "";
					}
				}

		
				$AttribPosAbaA = 2; // Posi��o das abas "A" (Declara Antes di Include)
				// Inicializa var
				$BotaoVoltar = 0;					
				$BotaoAvanco = 0;

				include 'config/cabecario.inc';			

							
					
			//*****************************************
			// Verificar Autentica��o
				$usuario = $ObjFuncao->VerAutenticacao();	
			//*****************************************
				$AbaAtivaA = $AbaIntA[2];			// Informa qual Aba deve ser selecionada
				
						
	
				//if(empty($Assunto)){ $Assunto='Telecom'; }	// SE assunto esta vazio...pega default
					
				
				if($RegURL>0){
					// Consulta topico
					$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
					if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection

					$sql = "SELECT assunto, topico FROM comandos where registro='$RegURL'";
					$result = mysqli_query($cnxMysql, $sql);		
					while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr		
						$Assunto=$row['assunto']; 
						$Topico=$row['topico'];
					}
					$cnxMysql->close();		// Fecha conexao($cnxMySql)					
				}else{ 
					$Assunto='Lista completa';
					$Topico='Lista completa';
				
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
					<a href="<?Php echo"$AttribMenuEsqIntLink01";?>" class="fonte_menu_esq">
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
			<table class="TAB_MainConteudoExtMargem" width=100% align="center" valign="top" > <!-- Margem -->	
			<tr>
			
			<!-- Conte�do Main Esquerdo -->
			<td width="20%" colspan="1"  align="left"  height="20" valign="top">

			<!-- Conte�do Main Esquerdo (Comporta todo conte�do do Indice)-->
			<table class="TAB_MainConteudoExt" width=100% align="center"  valign="top" border="0"> <!-- Sem Margem -->				
			
			<tr><!-- Conte�do Central(Esq, Pesq, Dir) -->
			
				<!-- Conte�do da Pesquisa (Resultdados)-->
				<td width="60%" colspan="1"   height="20" align="left" valign="top">
				<div id="conteudo_pesquisa"><!-- Conte�do da Pesquisa (Resultdados)-->
				
				<!------------------------------------ Inicio Conteudo de  ------------------------------------------------------------------>				
<?Php

				//echo"SELECT * FROM comandos WHERE assunto='$Assunto' and topico='$Topico' ORDER BY recentes DESC"; 
					/*
					// Consulta lista de procedimentos p/ este topico
					$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
					if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection

					/*	Lista registros do �ndice em ordem decrecente ao campo Registro	
						if($RegURL>0){ $sql2 = "SELECT * FROM comandos WHERE assunto='$Assunto' and topico='$Topico' ORDER BY registro DESC"; }
						else{ $sql2 = "SELECT * FROM comandos ORDER BY registro DESC"; }
					
						Lista registros do �ndice em ordem decrecente ao campo recentes(data dos acessos mais recentes) *
						if($RegURL>0){ 
							$sql2 = "SELECT * FROM comandos WHERE assunto='$Assunto' and topico='$Topico' ORDER BY recentes DESC"; 
						}else{ $sql2 = "SELECT * FROM comandos ORDER BY recentes DESC"; }
					
					
					$Tc = 0;	
					$result2 = mysqli_query($cnxMysql, $sql2);		
					while ($row2 = mysqli_fetch_assoc($result2))   // fetch associative arr 
					{	
						$Registro[]=$row2['registro']; 
						$Procedimento[]=$row2['procedimento']; 
						$Descricao[]=$row2['descricao']; 
						$Data[]=$row2['data'];
						$Endereco[]=$row2['endereco']; 
						$Acesso[]=$row2['recentes'];	// Cria numeração de prioridade, indicando o mais recente consultado
						$Tc++;
					}
					$cnxMysql->close();		// Fecha conexao($cnxMySql)					
					*/
					
					$Registro = $ObjMySql->QueryTopico($TopicoURL);
					$Total = $Registro[100][100]; //count($Procedimento);
?>
				
				<table class="TAB_ConteudoTitulo" width=100% align="center" valign="top"> 					
				<!------------------------ Linha TITULO DO INDICE - Ini ---------------------------------------------------->
				<tr align="left"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php $ObjFuncao->espaco(2); ?>
						
						<i><?Php //echo"$Topico($Total)";?></i>
							<?Php if($Topico == 'Conting�ncias'){ echo"<a href='contingencia_xls.php'>[xls]"; } ?>
						
						<img border="0" src="imagens/<?Php echo"$ThemeCorLinhaMenu"; ?>" width="500" height="5">						
					</td>
				</tr>
				
				<!------------------------ Linha titulo - Fim ---------------------------------------------------->
				</table>
				
				<!------------------------ Inicio Conte�do Central - Indice ---------------------------------------------------->
				
				
				<table class="TAB_ConteudoIntMargem" width=90% align="center" valign="top" > 					
				
				<tr><td>
				<table class="TAB_ConteudoInt" width=100% align="center" valign="top"> 	
						<tr>
							<td width="3%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="94%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">																
								<br><a class="fonte_topico"><i><?Php echo"$Topico($Total)"; ?></i>								
							</td>
							<td width="3%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
						</tr>
						<tr><td width="3%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td></tr>
						
				<?Php				
						for($E=0; $E < $Total; $E++){
						$Eb = $E+1;								
					
				?>						
						<tr>
							<td width="3%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="94%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">								
								
							<?Php 
								if($E==0){
								$PosT = strpos($TopicoURL, "GPO");
								if($PosT === false){
									// mostraria outra img ou vazio
								}else{
									
									?>
									<a href="icx.php" class="fonte_lista">
									<?Php echo"0. Converter posi��o OLT/ICX"; /**/ ?>
									<i><?Php echo"Converte posi��es entre OLT e ICX"."<BR>"; ?></i>
									</a>	
									<?Php						
								}
								}
							?>
								
								<!-- <a href="ler.php?<?Php printf("(%s. %s",$Eb, $Registro[$E][3]);  echo"$Procedimento[$E]&*reg=$Registro[$E]"; ?>" class="fonte_lista"> -->
								<a href="ler.php?<?Php printf("reg=%s",$Registro[$E][0]); ?>" class="fonte_lista">
									<?Php  printf("%s. %s",$Eb, $Registro[$E][3]); ?>
									<i><?Php printf("(%s, %s) - [%s] %s",$Registro[$E][4], $Registro[$E][8], $Registro[$E][0], $Registro[$E][6] ); ?></i>
									
									
									
								</a>						
							</td>
							<td width="3%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
						</tr>
<?Php
					}
?>
					</table>
				
				</td></tr></table>	
					
						
				<!------------------------------------ Final Conteudo de CENTRAL  ------------------------------------------------------------------->				
		
				


				</div><!-- Conte�do da Pesquisa (Resultdados)-->
			</td><!-- Conte�do da Pesquisa (Resultdados)-->
			
			<?Php 
				$PosT = strpos($TopicoURL, "GPO");
				if($PosT === false){
					// mostraria outra img ou vazio
				}else{
			?>
				<!-- Conte�do Direito(Publicidades - Img Eqptos) -->
				<td width="20%" colspan="1" height="20" valign="top">
					<table class="TAB_ConteudoInt" width=100% align="center" valign="top" border="1"> 	
					<tr><td>
					<div id="conteudo_direito"><!-- Conte�do Direito(Publicidades) -->
								<img border="0" src="imagens/PGSM1_GALC.png" width="464" height="374">
						  &nbsp;<!-- Resevado Publicidade -->
					</div><!-- Conte�do Direito(Publicidades)-->
					</td></tr></table>	
				</td><!-- Conte�do Direito(Publicidades) -->
			<?Php	} ?>	
				
				
				
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