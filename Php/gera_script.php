
<?Php
	
	$AttribPosAbaA = $_COOKIE['CookieAttribPosAbaA']; // Posição das abas "A"
	include 'config/cabecario.inc';
	
//*****************************************
// Verificar Autenticação
	$usuario = VerAutenticacao();	
//*****************************************
	$AbaAtivaB = $AttribAbaIntB[1];	// Informa qual Aba deve ser selecionada	
	
	$MostrarMsg = false;

	if($_POST){	// Testa os edit´s
		$CxTipo=$_POST['CxTipo'];	
		$CxModelo=$_POST['CxModelo'];	
		$CxSlot=$_POST['CxSlot'];
		$CxPorta=$_POST['CxPorta'];
		$CxRede=$_POST['CxRede'];
		$CxVlan=$_POST['CxVlan'];
		$EdAntigoIP=$_POST['EdAntigoIP'];
		$EdNovoIP=$_POST['EdNovoIP'];
		$CxMask=$_POST['CxMask'];
		$EdGateway=$_POST['EdGateway'];
		
		$CxPlaca=$_POST['CxPlaca'];
		$CxPortaIni=$_POST['CxPortaIni'];
		$CxNPortas=$_POST['CxNPortas'];
		$EdVlanAnt=$_POST['EdVlanAnt'];
		$EdVlan=$_POST['EdVlan'];
		$CxGrupo=$_POST['CxGrupo'];
		$CxPtAtm=$_POST['CxPtAtm'];
		$EdVPI=$_POST['EdVPI'];
		$EdVCI=$_POST['EdVCI'];
		
		$CxUndo=$_POST['CxUndo'];
		
		
	}else{
		$CxTipo="";
		$CxModelo="";
		$CxSlot="";
		$CxPorta="";
		$CxRede="";
		$CxVlan="";
		$EdAntigoIP="";
		$EdNovoIP="";		
		$CxMask="";
		$EdGateway="";
		
		$CxPlaca="";
		$CxPortaIni="";
		$CxNPortas="";
		$EdVlanAnt="";
		$EdVlan="";
		$CxGrupo="";
		$CxPtAtm="";
		$EdVPI="";
		$EdVCI="";
		
		$CxUndo = "";
	}
	
?>


<body BGCOLOR="<?Php echo"$ThemeCorFundoBody"; ?>" ><!-- BACKGROUND="PParede/cristal.png" --> 	


<div id="geral"><!-- Pagina Geral -->	


	<table class="TAB_Geral" width="100%" align="center" valign="top">
	<form name="Localizar" method="post" action="localizar.php"><!-- Form Localizar, inserido aqui devido espaços que cria no IE -->
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
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php espaco(2); ?>
						<img border="0" src="imagens/<?Php echo"$ThemeCorLinhaMenu"; ?>" width="155" height="15">
					</td>
				</tr>
				<!------------------------ Linha - Fim ---------------------------------------------------->
				
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
					<?Php espaco(5); ?>
					<a href="<?Php echo"$AttribMenuEsqIntLink00";?>" class="fonte_menu_esq">
						<?Php echo"$AttribMenuEsqInt00";?>
					</a></td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
					<?Php espaco(5); ?>
					<a href="<?Php echo"$AttribMenuEsqIntLink01";?>" class="fonte_menu_esq">
						<?Php echo"$AttribMenuEsqInt01";?>
					</a></td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php espaco(5); ?>
						<a href="<?Php echo"$AttribMenuEsqIntLink02";?>" class="fonte_menu_esq">
							<?Php echo"$AttribMenuEsqInt02";?>
						</a></td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
					<?Php espaco(5); ?>
					<a href="<?Php echo"$AttribMenuEsqIntLink03";?>" class="fonte_menu_esq">
						<?Php echo"$AttribMenuEsqInt03";?>
					</a></td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php espaco(5); ?>
						<a href="<?Php echo"$AttribMenuEsqIntLink04";?>" class="fonte_menu_esq">
							<?Php echo"$AttribMenuEsqInt04";?>
						</a></td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
							<?Php espaco(5); ?>
						<a href="<?Php echo"$AttribMenuEsqIntLink05";?>" class="fonte_menu_esq">
							<?Php echo"$AttribMenuEsqInt05";?>
						</a></td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php espaco(5); ?>
					</td>
				</tr>
				<!------------------------ Linha - Ini ---------------------------------------------------->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php espaco(2); ?>
						<img border="0" src="imagens/<?Php echo"$ThemeCorLinhaMenu"; ?>" width="155" height="15">
					</td>
				</tr>
				<!------------------------ Linha - Fim ---------------------------------------------------->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php espaco(3); ?>
						<a href="<?Php echo"$AttribMenuLinguaLink00";?>" class="fonte_item_menu">
						<img border="0" src="imagens/<?PHp echo"$ThemeMenuLinguaSel00"; ?>" width="15" height="15">
							<?Php echo"$AttribMenuLingua00";?>
						</a>
					</td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php espaco(5); ?>
						<a href="<?Php echo"$AttribMenuLinguaLink01";?>" class="fonte_menu_esq">
						<img border="0" src="imagens/<?PHp echo"$ThemeMenuLinguaSel02"; ?>" width="10" height="10">
							<?Php echo"$AttribMenuLingua01";?>
						</a>
					</td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php espaco(5); ?>
						<a href="<?Php echo"$AttribMenuLinguaLink02";?>" class="fonte_menu_esq">
						<img border="0" src="imagens/<?PHp echo"$ThemeMenuLinguaSel02"; ?>" width="10" height="10">
							<?Php echo"$AttribMenuLingua02";?>
						</a>
					</td>
				</tr>
				
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php espaco(5); ?>
						<a href="<?Php echo"$AttribMenuLinguaLink03";?>" class="fonte_menu_esq">
						<img border="0" src="imagens/<?PHp echo"$ThemeMenuLinguaSel03"; ?>" width="10" height="10">
							<?Php echo"$AttribMenuLingua03";?>
						</a>
					</td>
				</tr>
				<!------------------------ Linha - Ini ---------------------------------------------------->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php espaco(2); ?>
						<img border="0" src="imagens/<?Php echo"$ThemeCorLinhaMenu"; ?>" width="155" height="15">
					</td>
				</tr>
				<!------------------------ Linha - Fim ---------------------------------------------------->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php espaco(5); ?>
						<a href="<?Php echo"$AttribMenuSobreLink00"; ?>" class="fonte_menu_esq">
							<?Php echo"$AttribMenuSobre00";?>
						</a></td>
				</tr>
				<!------------------------ Linha - Ini ---------------------------------------------------->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php espaco(2); ?>
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

			</form><!-- Form Localizar, inserido aqui devido linhas indesejaveis no IE -->
			<form name="Gera_script" method="post" action="gera_script.php">				<!-- Editar -->

			<!-- Conteúdo Main Esquerdo -->
			<table class="TAB_MainConteudoExt" width=100% align="center"  valign="top"> <!-- Sem Margem -->				
			<tr><!-- Conteúdo Central(Esq, Pesq, Dir) -->
				<!-- Conteúdo da Pesquisa (Resultdados)-->
				<td width="60%" colspan="1"   height="20" align="left" valign="top">
				<div id="conteudo_pesquisa"><!-- Conteúdo da Pesquisa (Resultdados)-->
				<!------------------------------------ Inicio Conteudo de  ------------------------------------------------------------------>				
<?Php			
				//*********************************************************************************************
				
				if($CxTipo=='IP'){
					$Tabela = false;		// indica que deve carregar analise					
					if($CxModelo=='HW_MA56XX'){	include 'GeraScript/HW_MA56XX.inc';  }
					if($CxModelo=='HW_MA5100'){	include 'GeraScript/HW_MA5100.inc';  }
					if($CxModelo=='SIEMENS_HIX56XX'){	include 'GeraScript/SIEMENS_HIX56XX.inc'; }		
					if($CxModelo=='NEC_Bxxxx'){	include 'GeraScript/NEC_Bxxxx.inc';  }
					if($CxModelo=='ZTE_MSAG5200_GIS'){	include 'GeraScript/ZTE_MSAG5200_GIS.inc';  }
					if($CxModelo=='ZTE_MSAG5200_GIS_B'){	include 'GeraScript/ZTE_MSAG5200_GIS_B.inc';  }		
					if($CxModelo=='DM705'){	include 'GeraScript/DM705.inc';  }													
												
				}
				if($CxTipo=='Vlan'){							
					$Tabela = false;		// indica que deve carregar tabela
					if( ($CxModelo=='5100new')or($CxModelo=='5100any')or($CxModelo=='5600')or($CxModelo=='vdsl_siemens') ){	include 'GeraScript/PvcLan.inc'; }
					if( ($CxModelo=='5100ima_placa')or($CxModelo=='5100ima_aiu_0a15') ){	include 'GeraScript/PvcIma.inc'; }
					if( ($CxModelo=='5100atm')or($CxModelo=='5103atm') ){	include 'GeraScript/PvcAtm.inc'; }				

				} // if tipo=vlan	
				if($CxTipo=='Porta'){							
					$Tabela = false;		// indica que deve carregar tabela
					if($CxModelo=='Lucent'){	include 'GeraScript/PortaLucent.inc'; }
					//if( ($CxModelo=='5100ima_placa')or($CxModelo=='5100ima_aiu_0a15') ){	include 'GeraScript/PvcIma.inc'; }
					//if( ($CxModelo=='5100atm')or($CxModelo=='5103atm') ){	include 'GeraScript/PvcAtm.inc'; }				

				} // if tipo=vlan	
			
?>							
				<br>
				<table class="TAB_ConteudoIntMargem" width=100% align="center" valign="top"> 									
				<!------------------------ Linha - Ini ---------------------------------------------------->
				<tr align="left"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
					<b>Gerar script de configuração:</b>
					</td>
						</tr>					
						<tr align="left"  height="5" valign="top">
						<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php AttribPularLinha(1); ?>							
						<i><select name="CxTipo" onchange="this.form.submit();">
							<?Php if($CxTipo==''){ $CxTipo = "Selecionar"; } ?>
							<option><?Php echo"$CxTipo"; ?></option>
							<option>IP</option>
							<option>Porta</option>							
							<option>Vlan</option>							
						</select>	
						</i>
						<?Php if($CxTipo=='IP'){ 	?>
						<i><select name="CxModelo" onchange="this.form.submit();">
							<?Php if($CxModelo==''){ $CxModelo = "Selecionar"; } ?>
							
							<option><?Php echo"$CxModelo"; ?></option>
							<option>HW_MA56XX</option>
							<option>HW_MA5100</option>	
							<option>SIEMENS_HIX56XX</option>	
							<option>NEC_Bxxxx</option>	
							<option>ZTE_MSAG5200_GIS</option>	
							<option>ZTE_MSAG5200_GIS_B</option>	
							<option>DM705</option>
							
						</select>	
						</i>
						<?Php } if($CxTipo=='Vlan'){ 	?>
						<i><select name="CxModelo" onchange="this.form.submit();">
							<?Php if($CxModelo==''){ $CxModelo = "Selecionar"; } ?>
							
							<option><?Php echo"$CxModelo"; ?></option>
							<option>5100new</option>
							<option>5100any</option>	
							<option>5100ima_placa</option>	
							<option>5100ima_aiu_0a15</option>	
							<option>5100atm</option>
							<option>5103atm</option>
							<option>5600</option>	
							<option>vdsl_siemens</option>
						
						</select>	
						</i>	
						<?Php } if($CxTipo=='Porta'){ 	?>
						<i><select name="CxModelo" onchange="this.form.submit();">
							<?Php if($CxModelo==''){ $CxModelo = "Selecionar"; } ?>
							
							<option><?Php echo"$CxModelo"; ?></option>
							<option>Lucent</option>
						
						</select>	
						</i>	
						<?Php } ?>
						</td>
						</tr>
						<tr align="left"  height="5" valign="top">
						<td width="100%" colspan="1"  align="left"  height="5" valign="top">
				
						<!------------------------------------------------------------------------------------------------------------------------->
						<!-- SELEÇÃO DE TIPOS -->
						<?Php 
							if($CxTipo=='IP'){							
								$Tabela = true;		// indica que deve carregar tabela
								if($CxModelo=='HW_MA56XX'){	include 'GeraScript/HW_MA56XX.inc'; }		
								if($CxModelo=='HW_MA5100'){	include 'GeraScript/HW_MA5100.inc'; }		
								if($CxModelo=='SIEMENS_HIX56XX'){	include 'GeraScript/SIEMENS_HIX56XX.inc'; }	
								if($CxModelo=='NEC_Bxxxx'){	include 'GeraScript/NEC_Bxxxx.inc';  }	
								if($CxModelo=='ZTE_MSAG5200_GIS'){	include 'GeraScript/ZTE_MSAG5200_GIS.inc';  }								
								if($CxModelo=='ZTE_MSAG5200_GIS_B'){	include 'GeraScript/ZTE_MSAG5200_GIS_B.inc';  }								
								if($CxModelo=='DM705'){	include 'GeraScript/DM705.inc';  }	
							} // if tipo = IP 
							if($CxTipo=='Vlan'){							
								$Tabela = true;		// indica que deve carregar tabela
								if( ($CxModelo=='5100new')or($CxModelo=='5100any')or($CxModelo=='5600')or($CxModelo=='vdsl_siemens') ){	include 'GeraScript/PvcLan.inc'; }
								if( ($CxModelo=='5100ima_placa')or($CxModelo=='5100ima_aiu_0a15') ){	include 'GeraScript/PvcIma.inc'; }
								if( ($CxModelo=='5100atm')or($CxModelo=='5103atm') ){	include 'GeraScript/PvcAtm.inc'; }

							} // if tipo=vlan		
							if($CxTipo=='Porta'){							
								$Tabela = true;		// indica que deve carregar tabela
								if($CxModelo=='Lucent') {	include 'GeraScript/PortaLucent.inc'; }

							} // if tipo=porta		
						?>		
						<a href="GeraScript/index.php">Arquivos GeraScript(xls)</a>
						<!------------------------------------------------------------------------------------------------------------------------->
						<!-- Causa problamas no IE: <img border="0" src="imagens/<?Php echo"$ThemeCorLinhaMenu"; ?>" width="500" height="5"> -->
					</td>
				</tr>
				<!------------------------ Linha - Fim ---------------------------------------------------->
				</table>
				
				<br>	
				<table class="TAB_ConteudoIntMargem" width=90% align="center" valign="top"> 					
<?Php
				// Mensagens do resultado Salvar Edição
				if($MostrarMsg){
?>					<tr><td width="100%" colspan="1" height="20" align="center" valign="top">
<?Php 					
						echo"$MSG";
?>	
					</td></tr>
<?Php 			}			?>				
				<tr><td>
					<table class="TAB_ConteudoInt" width=100% align="center" valign="top"> 						
												
<?Php				// Controla Num de linhas do TexteArea
					$NumLinha = 15;

?>
					
					
					<?Php espaco(3); ?>					
						<tr>
							<td width="100%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">								
								<TEXTAREA ID="TxaComandoID" COLS="100" ROWS="<?Php echo"$NumLinha"; ?>" style="overflow: visible" onClick="this.select();">
									<?Php 
										$Qtos = count($Script);
										printf("\n");
											
											if($CxModelo=='vdsl_siemens'){ 											
												
												for($LS=$PortaIni;$LS <  $Qtos;$LS++){ 
														for($L=0;$L < 7;$L++){ printf("%s\n",$Script[$LS][$L]);		}
														printf("!\n");
												}
											
											}else{ 
												if($CxModelo=='Lucent'){ 											
											
													for($L=$PortaIni;$L < $Qtos;$L++){											
														for($LS=0;$LS <  3;$LS++){ printf("%s\n",$Script[$L][$LS]);		}													
													
													}
											
												}else{											
											
													for($LS=0;$LS < $Qtos;$LS++){ printf("%s\n",$Script[$LS]);	}
												}
											
											} 

											
									?>
								</TEXTAREA>
										
							</td>
						</tr>
					
					</table>
					
				</td></tr></table>
				</form> <!-- Editar -->	
				<BR><BR>	
						
						
				<!------------------------------------ Final Conteudo de  ------------------------------------------------------------------->				
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
	</form><!-- Localizar -->
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