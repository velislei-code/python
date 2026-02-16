<?Php
// https://www.tiktok.com/@geometryptamine/video/7062793266315431173?is_from_webapp=1&sender_device=pc&web_id=7325447832130471430	
	
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

	include_once("Class.funcao.php");
	include_once("Class.mysql.php");
	include_once("config/config.php");
	
	$ObjFuncao = new Funcao();
	$ObjMySql = new MySql();

	$ResCltMySql = $ObjMySql->CltComando($RegURL);

						
	// Confirma se Consulta retornou algum registro...se sim mostrra registro...
	if(!empty($ResCltMySql[10]) ){	

			$ExibirTab = true;

			// Devido a erro por modificar Cookies fora do Head tive que por esta rotina aqui
			// Controla Num de linhas do TexteArea
			$NumLinha = $ObjFuncao->ContarLinhas($ResCltMySql[4]);	// Conta Num Linhas da String Comando													
			if($NumLinha < 40){ $NumLinha = 40; }			// Ajustes visuais
			else{	$NumLinha += $NumLinha/20;}


			$ComandosX = $ResCltMySql[4];

			$HabBtEditar = false;	// Esconde Bt-Editar até que se descriptografe registro
			
			$ResCmd = $ObjFuncao->FlagCripto($ComandosX);	// Verifica se registro possui FlagCripto, Tira Flag
			if($ResCmd[0] == defFlagCripto){
				$HabBtEditar = false;		// Se Sim(Reg-Cripto), habilitar bt-salvar direto
				$Comandos = $ResCmd[1];
				setcookie ("CriptoCookie", defFlagCripto, time()+22180);
			}else{						
				$HabBtEditar = true;		// Se Não(Reg-Open), habilitar bt-salvar direto
				$Comandos = $ComandosX;
				setcookie ("CriptoCookie", 'Open', time()+22180);
			}	
			
			if( isset($_REQUEST['BtDescripto']) ){ 
				$Sn = md5($_POST['EdPass']);	// Converte senha digitada p/ hash md5
				$Dd_descripto = $ObjFuncao->Decripto($Comandos, $Sn);
				$Comandos = $Dd_descripto;
				$HabBtEditar = true;
			}

	}else{
		$ExibirTab = false;
		$HabBtEditar = false;
		$NumLinha = 10;

	}	// if(!empty($ResCltMySql[10]) ){<<< Confirmacao de retorno de registro da consulta				
	//*********************************************************************************************
	//Consulta LISTA DE TóPICOS - Coloquei estas rotinas aqui, acima do Head, devido as alteracoes de Cookie(Da erro se por no Body)
				
	
	$MostrarMsg = false;	// Desabilitar Mensagens
	$MsgSnFail = false;	

	if( isset($_REQUEST['BtEditar']) ){ 							

			if($_COOKIE['CriptoCookie'] == defFlagCripto){

				$SnInfo = $_POST['EdPassSalvar'];
				if($SnInfo<>''){
						$SnInfoMd5 = md5($_POST['EdPassSalvar']);									
						$AdComando_cripto = $ObjFuncao->Cripto($_POST['TxaComando'], $SnInfoMd5);
						$EnableSave = true;		
						// Se Registro estava Cripto, salvar alterações enCripto								
						$AcaoEditar = $ObjMySql->SalveEditar($RegURL, $_POST['EdAssunto'], $_POST['EdTopico'], $_POST['EdProcedimento'], $_POST['EdDescricao'], $AdComando_cripto);									
						setcookie ("CriptoCookie", 'Open', time()+22180);	// Reseta Cookie
						$MsgSnFail = false;	
				}else{ $MsgSnFail = true; }

			}else{									
				$AcaoEditar = $ObjMySql->SalveEditar($RegURL, $_POST['EdAssunto'], $_POST['EdTopico'], $_POST['EdProcedimento'], $_POST['EdDescricao'], $_POST['TxaComando']);											
				setcookie ("CriptoCookie", 'Open', time()+22180);	// Reseta Cookie
	
			}
			//==========================================================================================================//
			$MostrarMsg = true;			// Habilitar Mensagens...seta aqui p/ evitar aparecer msg sem clickar no botao: Salvar						
			$HabBtEditar = false;		// Bloqueia Botao para evitar duplo-click e Salvar no duplo-Cripto
	}

	include 'config/cabecario.inc';
	
//*****************************************
// Verificar Autentica��o
	$usuario = $ObjFuncao->VerAutenticacao();	
//*****************************************
	$AbaAtivaB = $AttribAbaIntB[3];	// Informa qual Aba deve ser selecionada
	
	$hoje = date("d/m/y");


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

			<!------------------------- Inicio Conte�do central -------------------------------------------------------------------->
			
			<div id="conteudo_Central"><!-- Conte�do Central(Esq, Pesq, Dir)-->

			<!-- Conte�do Main - Margem -->
			<table class="TAB_MainConteudoExtMargem" width=100% align="center" valign="top"> <!-- Margem -->	
			<tr>
			
			<!-- Conte�do Main Esquerdo -->
			<td width="20%" colspan="1"  align="left"  height="20" valign="top">

			</form><!-- Form Localizar, inserido aqui devido linhas indesejaveis no IE -->
			<form name="Editar" method="post" action="editar.php">				<!-- Editar -->
		
		<?Php if($ExibirTab){   // ExibirTabela - caso haja registros para exibir ?>

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
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(12); ?>
						<i><input type="text" name="EdReg" size="3" value="<?Php echo"$ResCltMySql[10]";  ?>" ></i>
						
						<?Php $ObjFuncao->espaco(1); ?>Assunto:
						<i><input type="text" name="EdAssunto" size="20" value="<?Php echo"$ResCltMySql[0]"; /* $Assunto */ ?>" ></i>
						<?Php $ObjFuncao->espaco(1); ?>Topico:
						<i><input type="text" name="EdTopico" size="20" value="<?Php echo"$ResCltMySql[1]"; /* $Topico */ ?>" ></i>
						<!-- Causa problamas no IE: <img border="0" src="imagens/<?Php echo"$ThemeCorLinhaMenu"; ?>" width="500" height="5"> -->
					</td>
				</tr>
				<!------------------------ Linha - Fim ---------------------------------------------------->
				</table>
		
			
				<br><br>	
				<table class="TAB_ConteudoIntMargem" width=90% align="center" valign="top"> 					

<?Php
				// Mensagens do resultado Salvar Edi��o
				if($MostrarMsg){
?>					<tr><td width="100%" colspan="1"  height="20" align="center" valign="top">
<?Php 					if($MsgSnFail){ echo"<font size='2' color='#ff0000'> ERRO! Voce deve informar uma senha de encriptacao! </font>"."<br>";}		
						else{
							if($AcaoEditar){echo"<font size='2' color='#008B00'> Alteracoes salvas com sucesso ! </font>"; }
							else{echo"<font size='2' color='#ff0000'> ERRO! Nao foi possovel salvar alteracoes, falha de conexao com bando de dados ! </font>";}
						}				
?>					
					</td></tr>
<?Php 			}			?>				
				<tr><td>
					<table class="TAB_ConteudoInt" width=100% align="center" valign="top"> 						
												

					Indice: <input type="text" name="EdProcedimento" size="30" value="<?Php echo $ResCltMySql[2]; /* $Procedimento */ ?>" >
					Descricao: <input type="text" name="EdDescricao" size="50" value="<?Php echo $ResCltMySql[3]; /* $Descricao */ ?>" >
						<tr>
							
							<td width="100%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">								
								
								<TEXTAREA ID="TxaComandoID" name="TxaComando" COLS="100" ROWS="<?Php echo"$NumLinha"; ?>" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);">
									<?Php 
										echo $Comandos; /* $Comando Endere�o: $ResCltMySql[5]*/; 
										
										if ($ResCltMySql[1] == 'Contingencias' ){echo"$hoje: CONT[], SLOT[], CART[], CAD[], BAT[], ANATEL[]";}
									
									?>
									
								</TEXTAREA>
								
								</td>
						</tr>							
						<tr>
							<!-- <form name="Descripto" method="post" action="editar.php?<?Php echo "topico=".$TopicoURL;?>"><!-- Form Localizar, inserido aqui devido espa�os que cria no IE -->
								<td width="100%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">
								
								<?Php if($HabBtEditar){ 		
									if($_COOKIE['CriptoCookie'] == defFlagCripto){ ?>
										<input type="password" name="EdPassSalvar" size="8">
									<?Php } ?>	
									<!-- <select name="CxCripto">
										<?Php if($AdCripto==''){ $AdCripto = "S/Criptog"; } ?>
										<option><?Php echo"$AdCripto"; ?></option>
										<option>Criptografar</option>													
									</select> -->
									<input type="submit" name="BtEditar" value="Salvar">
								<?Php }else{ ?>	
										Senha:<input type="password" name="EdPass" size="8">					
										<input type="submit" name="BtDescripto" value="Descriptografar">
								<?Php } ?>	
											
								</td>							
						</tr>											
						
					</table>

					
				</td></tr></table>
	<?Php }  // ExibirTabela - caso haja registros para exibir ?>
				</form> <!-- Editar -->	
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