<?Php
/*
CREATE TABLE etqtas (
  Registro int(11) NOT NULL auto_increment,
  ccto varchar(50) NULL,
  de varchar(50) NULL,
  CtrlVid_unit varchar(50) NULL,
  Port varchar(255) NULL,
  data varchar(10) NULL,  
  PRIMARY KEY  (Registro)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

*/
	
	$AttribPosAbaA = 0; //$_COOKIE['CookieAttribPosAbaA']; // Posi��o das abas "A"
	// Inicializa var
	$BotaoVoltar = 0;					
	$BotaoAvanco = 0;					

	include 'config/cabecario.inc';
	
//*****************************************
// Verificar Autentica��o
	$usuario = $ObjFuncao->VerAutenticacao();	
//*****************************************
	$AbaAtivaB = $AttribAbaIntB[1];	// Informa qual Aba deve ser selecionada	
	
 
	include_once("Class.configrouter.php");	//include_once: carregue o arquivo se ele j� N�O tenha sido inclu�do
	$ObjConfigRouter = New ConfigRouter();

				//*********************************************************************************************
			
				if(isset($_POST['BtLimpar'])){
					echo '<script type="text/javascript">';				
					echo"window.location.href = 'script.php'";
					echo '</script>';
				}
				
					
				// Inicializa vari�veis
					if(!empty($_POST['CxRouterTipo'])){
						$CxRouterTipoX = $_POST['CxRouterTipo'];
					}else{
						$CxRouterTipoX = 'Tipo';					
					}	
					if(!empty($_POST['edRouter'])){
						$edRouterX = $_POST['edRouter'];
					}else{
						$edRouterX = '';					
					}	
					
					if(!empty($_POST['TaConfigRouter'])){
						$TaConfigRouterX = $_POST['TaConfigRouter'];
					}else{					
						$TaConfigRouterX = '';					
					}
				
					if(isset($_POST['BtSalvar'])){					
						if($ObjConfigRouter->AddConfigRouter($CxRouterTipoX, $edRouterX, $TaConfigRouterX)){
							$TaConfigRouterX = '';	// Limpa
							$edRouterX = '';
						}

					}

					// Pega numero id do endereço http://
					if(isset($_REQUEST['id']) ){
						$IdURL = $_REQUEST['id'];
						
						$IdEmUso = $ObjConfigRouter->QueryConfig($IdURL);	
						
						$CxRouterTipoX = $IdEmUso[_TIPO];
						$edRouterX = $IdEmUso[_ROUTER];
						$TaConfigRouterX = $IdEmUso[_CONFIG];
					}

?>
<style>
	/* Estilos */
	.placa{
		border: 2px solid #000; /* Borda preta */
		border-radius: 5px; /* Cantos arredondados */
		display: flex;
		justify-content: center; /* Centraliza horizontalmente */
		align-items: center; /* Centraliza verticalmente */
		font-family: Arial, sans-serif; /* Fonte do texto */
		font-size: 11px; /* Tamanho do texto */
		font-weight: bold; /* Texto em negrito */
		color: #000; /* Cor do texto */
		text-align: center; /* Alinhamento do texto */
		box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3); /* Sombra */
	}	
				#basica{
					width: 120px; /* Largura da placa */
					height: 20px; /* Altura da placa */
					background-color:  #ffcc00; /* Cor de fundo (amarelo) */
				}

	.placaFx {
		position: fixed; /* Fixa a div na tela */
		border: 2px solid #000; /* Borda preta */
		border-radius: 5px; /* Cantos arredondados */
		display: flex;
		justify-content: center; /* Centraliza horizontalmente */
		align-items: center; /* Centraliza verticalmente */
		font-family: Arial, sans-serif; /* Fonte do texto */
		font-size: 11px; /* Tamanho do texto */
		font-weight: bold; /* Texto em negrito */
		color: #000; /* Cor do texto */
		text-align: center; /* Alinhamento do texto */
		box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3); /* Sombra */
	}

				#calendario{
					top: 700px; /* Distância do topo */
					left: 20px; /* Distância da esquerda */
					width: 120px; /* Largura da placa */
					height: 15px; /* Altura da placa */
					background-color:  #00BFFF; /* Cor de fundo (amarelo) */
				}
				#aviso{
					top: 50px; /* Distância do topo */
					left: 250px; /* Distância da esquerda */
					width: 300px; /* Largura da placa */
					height: 50px; /* Altura da placa */
					background-color: #ffcc00; /* Cor de fundo (amarelo) */					
				}

</style>

<body BGCOLOR="<?Php echo"$ThemeCorFundoBody"; ?>" ><!-- BACKGROUND="PParede/cristal.png" --> 	
<div id="geral"><!-- Pagina Geral -->	

	<table class="TAB_Geral" width="100%" align="center" valign="top">
	<form name="LocalizarConfig" method="post" action="localizar_config.php"><!-- Form Localizar, inserido aqui devido espa�os que cria no IE -->
	<tr align="center"  height="50" valign="top">
	
	<!-------------------------------- Inicio Geral Esquerdo -------------------------------------------------------------------->
	
	<td width="20%" colspan="1"  align="center"  height="5" valign="top">
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
			
			<td width="20%" colspan="1"  align="left"  height="5" valign="top">		
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
						<a href="<?Php echo"$AttribMenuEsqIntLink06";?>" class="fonte_menu_esq">
							<?Php echo"$AttribMenuEsqInt06";?>
						</a></td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
							<?Php $ObjFuncao->espaco(5); ?>
						<a href="<?Php echo"$AttribMenuEsqIntLink07";?>" class="fonte_menu_esq">
							<?Php echo"$AttribMenuEsqInt07";?>
						</a></td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
							<?Php $ObjFuncao->espaco(5); ?>
						<a href="<?Php echo"$AttribMenuEsqIntLink08";?>" class="fonte_menu_esq">
							<?Php echo"$AttribMenuEsqInt08";?>
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
						<div class="placa" id="basica">
							<input i class="fa fa-search" type="image" src="imagens/icon/farol.ico" title="Farol" style="max-width :30px; max-height:30px;">                                                      
							<?Php echo"$AttribMenuLingua00";?>
						</div>
					</td>
				</tr>
				<!-- Check Config SWA -->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						
							<?Php echo"$AttribMenuLingua01";?>
						<!-- </a> -->
					</td>
				</tr>
				<!-- Check Cad.ERB FIb -->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
						<!--<a href="<?Php echo"$AttribMenuLinguaLink02";?>" class="fonte_menu_esq"> -->
					
						<?Php echo"$AttribMenuLingua02";?>
						<!-- </a> -->
					</td>
				</tr>
				<!-- Check Certificacao de IPs -->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
						<!--<a href="<?Php echo"$AttribMenuLinguaLink03";?>" class="fonte_menu_esq">-->
											
						<?Php echo"$AttribMenuLingua03";?>
						<!--</a>-->
					</td>
				</tr>
				<!-- Check Config backbone -->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
						<!--<a href="<?Php echo"$AttribMenuLinguaLink04";?>" class="fonte_menu_esq">-->
						
					
						<?Php echo"$AttribMenuLingua04";?>
						<!--</a>-->
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
		<div class="placaFx" id="calendario">	
			<input i class="fa fa-search" type="image" src="imagens/icon/calendar.ico" style="max-width :30px; max-height:30px;">									
			<?php echo date("l d/m"); ?>
		</div>
		<br>
		
	
	</div><!-- Geral Esquerdo -->
	</td>
	<!-------------------------------- Final Geral Esquerdo -------------------------------------------------------------------->
	
	
	<!-------------------------------- Inicio Geral Direito -------------------------------------------------------------------->
	
	<td width="80%" colspan="1"  align="center"  height="5" valign="top">
	<br>
	<div id="geral_direito"><!-- Geral Direito -->		
		
		<table class="TAB_GeralDireito" width="100%" align="center" valign="top"> <!-- cellspacing="0" cellpadding="0" height="5"  BGCOLOR="<?Php echo"$ThemeCorFundoBody"; ?>> -->
				<!------------------------------------------------------------------------------------------------------------->
		
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
			<table class="TAB_MainConteudoExtMargem" width="100%" align="center" valign="top" border="0"> <!-- Margem -->	
			<tr>
			
			<!-- Conte�do Main Esquerdo -->
			<td width="20%" colspan="3"  align="left"  height="20" valign="top">

			</form><!-- Form Localizar, inserido aqui devido linhas indesejaveis no IE -->
			<form name="Config_router" method="post" action="config_router.php">				<!-- Editar -->

			<!-- Conte�do Main Esquerdo -->
			<table class="TAB_MainConteudoExt" width="100%" align="center"  valign="top" border="0"> <!-- Sem Margem -->				
			<tr><!-- Conte�do Central(Esq, Pesq, Dir) -->
				<!-- Conte�do da Pesquisa (Resultdados)-->
				<td width="60%" colspan="1"   height="20" align="left" valign="top">
				<div id="conteudo_pesquisa"><!-- Conte�do da Pesquisa (Resultdados)-->
				<!------------------------------------ Inicio Conteudo de  ------------------------------------------------------------------>				
		<?Php     ?>				
				<table class="TAB_ConteudoIntMargem" width="100%" align="center" valign="top" border="0"> 			
                <tr align="left"  height="5" valign="top" style="background-color: LightSlateGray">
					<td width="20%" colspan="4"  align="left"  height="5" valign="top" ><font size='3' color='#ffffff'><b>Scripts!</b>
                        <!---- Espaco acima das rows ---->
                    </td>
                </tr>			
				
				<tr align="left"  height="5" valign="top">
					<td width="20%" colspan="2"  align="center"  height="5" valign="top" ><font size='2' color='#008080'>
					<!------------------------ Msg Insert Reg - Ini ---------------------------------------------------->
										
					<!------------------------ MSG...Insert - Fim ---------------------------------------------------->				
					</td>
				</tr>	
                <!------------------------------ Inicio Script ---------------------------------------->
                
                <tr align="left"  height="5" valign="top">
                  
                    <td width="80%" colspan="1"  align="left"  height="5" valign="top" ><font size='2' color='#ff0000'>
                        
                        <table class="TAB_ConteudoIntMargem" width=90% align="center" valign="top"> 					
							
                            <tr align="left"  height="5" valign="top">
								
                                <td width="5%" colspan="1"  align="left"  height="5" valign="middle" ><font size='2' color='#ff0000'>
                                	<input onclick="CopyToClipBoardX('TaConfigRouter')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar script" style="max-width :20px; max-height:20px;">
								</td>
								<td width="95%" colspan="1"  align="left"  height="5" valign="top" ><font size='2' color='#ff0000'>
                               		
									<TEXTAREA id="TaConfigRouter" name="TaConfigRouter" COLS="180" ROWS="40" style="overflow: visible; font-size: 9pt; " ONKEYDOWN="expandTextArea(this, event);"> 
                                        <?Php 											
											echo $TaConfigRouterX;	echo"\n";
										?>
                                    </TEXTAREA>  									
                                  
                                </td>
                            </tr>  
							<tr align="left"  height="5" valign="top">
                                <td width="5%" colspan="1"  align="left"  height="5" valign="top"></td>
                                <td width="95%" colspan="1"  align="left"  height="5" valign="top">
									<input type="text" id="edRouter" name="edRouter" size="26" value="<?Php echo "$edRouterX" ; ?>" >
									<select name="CxRouterTipo" size="1">
											<option><?Php echo $CxRouterTipoX; ?></option>										
											<option>gwx</option>
											<option>hl5</option>
											<option>rai</option>
											<option>rav</option>																															                   
											<option>rsd</option>																				                   
											<option>swa</option>															                   
										</select>									
									<button type="submit" name="BtSalvar" value="Salvar" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Salvar config">
											<img src="imagens/icon/disquete.ico"  style="widht:120%; height:120%;">
									</button>	
                                </td>                            
                            </tr>      
                    
                        </table>
                		
                    </td>
                    <!------------------------------ Fim Form/TextArea Script ---------------------------------------->
                </tr> 
                
                </table> <!-- Tabela Script ----> 
               
            			
			</td>
                   
			</tr>

                <!------------------------------ Fim Script ---------------------------------------->
								
				
				</table>
		
				</td></tr></table>
					
				<BR>
				
			
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
			<td width="20%" colspan="1"  align="left"  height="5" valign="top"></td>		
			<td width="50%" colspan="1"  align="left"  height="5" valign="top">		
				<a href="<?Php echo"$AttribRodapeLink00"; ?>" class="fonte_rodape"><?Php echo"$AttribRodape00"; ?></a>
				&nbsp;			
				<a href="<?Php echo"$AttribRodapeLink01"; ?>" class="fonte_rodape"><?Php echo"$AttribRodape01"; ?></a>			
			</td>
			<td width="20%" colspan="1"  align="left"  height="5" valign="top">
				<img border="0" src="imagens/<?Php echo"$AttribRodapeImg00"; ?>" width="88" height="31">
				<img border="0" src="imagens/<?Php echo"$AttribRodapeImg01"; ?>" width="88" height="31">
					
			</td>		
		</tr>
		</table>	
		

	</form>
	</div><!-- Rodap� -->


</div><!-- Pagina Geral --> 

<script src="resources/js/funcoes.js"></script><!-- Cria Menu auto filtro Cx-Select: Router->PolicyIN->PolicyOUT -->
<script src="resources/js/alert.js"></script><!-- Cria Menu auto filtro Cx-Select: Router->PolicyIN->PolicyOUT -->
  


</body>

</html>