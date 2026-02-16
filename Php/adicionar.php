
<?Php
	
	$AttribPosAbaA = 0; // $_COOKIE['CookieAttribPosAbaA']; // Posi��o das abas "A"
	// Inicializa var
	$BotaoVoltar = 0;					
	$BotaoAvanco = 0;					

	if(isset($_REQUEST['reg']) ){
		$RegURL = $_REQUEST['reg'];
		setcookie ("CookieRegURL", $RegURL, time()+21600);					 
	}else{
		if(isset($_COOKIE['CookieRegURL'])){	$RegURL = $_COOKIE['CookieRegURL']; }
		else{ $RegURL = ''; }
	}


	include 'config/cabecario.inc';
	
//*****************************************
// Verificar Autentica��o
	$usuario = $ObjFuncao->VerAutenticacao();	
//*****************************************
	$AbaAtivaB = $AttribAbaIntB[1];	// Informa qual Aba deve ser selecionada	

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
			<form name="Adicionar" method="post" action="adicionar.php">				<!-- Editar -->

			<!-- Conte�do Main Esquerdo -->
			<table class="TAB_MainConteudoExt" width=100% align="center"  valign="top"> <!-- Sem Margem -->				
			<tr><!-- Conte�do Central(Esq, Pesq, Dir) -->
				<!-- Conte�do da Pesquisa (Resultdados)-->
				<td width="60%" colspan="1"   height="20" align="left" valign="top">
				<div id="conteudo_pesquisa"><!-- Conte�do da Pesquisa (Resultdados)-->
				<!------------------------------------ Inicio Conteudo de  ------------------------------------------------------------------>				
<?Php
				//*********************************************************************************************
					
				
				// Inicializa vari�veis
				$AdAssunto = '';
				$AdTopico ='';
				$AdIndice = '';
				$AdDescricao = '';
				$AdComando = '';						
				$MostrarMsg = false;	// Desabilitar Mensagens
				
				if($_POST){	// Testa os edit�s
					$MostrarMsg = true;	// Habilitar Mensagens
					$AdAssunto = $_POST['CxAssunto'];
					$AdTopico = $_POST['CxTopico'];
					$AdIndice = $_POST['EdIndice'];
					$AdDescricao = $_POST['EdDescricao'];
					$AdComando = $_POST['TxaComando'];
					$SnInfo = $_POST['EdPass'];
					/// echo"Postando....";
				}
				if(isset($_POST['CxCripto'])){
					$AdCripto = $_POST['CxCripto'];	
				}else{
					$AdCripto = "";
				}

				if($AdAssunto<>''){
				if($AdTopico<>''){
				if($AdIndice<>''){
				if($AdDescricao<>''){
				if($AdComando<>''){

				
					if($_POST['CxCripto'] == "Criptografar"){

						if($SnInfo<>''){
							$SnInfoMd5 = md5($_POST['EdPass']);
							$AdComando_cripto = $ObjFuncao->Cripto($AdComando, $SnInfoMd5);
							$EnableSave = true;
						}else{ $EnableSave = false; 	}	
						
						
						
					}else{	
						$AdComando_cripto = $_POST['TxaComando'];	
						$EnableSave = true;
						
					}
				//==========================================================================================================//
					if($EnableSave){
						$AcaoAdicionar = $ObjMySql->SalveAdicionar($_POST['CxAssunto'], $_POST['CxTopico'], $_POST['EdIndice'], $_POST['EdDescricao'], $AdComando_cripto);					
						if($AcaoAdicionar>0){	$ObjFuncao->Mensagem("Sucesso!", "Registro[".$AcaoAdicionar."] inserido com sucesso !", Null, Null, defAviso, defSucesso); }					
						else{	$ObjFuncao->Mensagem("Erro!", "Falha de conexao com MySQL.", Null, Null, defAviso, defPerigo); }													
					}else{	$ObjFuncao->Mensagem("Atenção!", "Voce deve informar a senha de criptografia.", Null, Null, defAviso, defAtencao); 	}		
				}else{ $ObjFuncao->Mensagem("Atenção!", "Voce deve informar o Comando.", Null, Null, defAviso, defAtencao); }											
				}else{ $ObjFuncao->Mensagem("Atenção!", "Voce deve informar a Descricao.", Null, Null, defAviso, defAtencao); }											
				}else{ $ObjFuncao->Mensagem("Atenção!", "Voce deve informar o Indice.", Null, Null, defAviso, defAtencao); }										
				}else{ $ObjFuncao->Mensagem("Atenção!", "Voce deve informar o Topico.", Null, Null, defAviso, defAtencao); }										
				}else{ $ObjFuncao->Mensagem("Atenção!", "Voce deve informar o Assunto.", Null, Null, defAviso, defAtencao); }										
				
				
				$ListaAss = $ObjMySql->ListarCampo('assunto');
				$TotListaAss = count($ListaAss);

				$ListaTop = $ObjMySql->ListarTopico($AdAssunto);
				$TotListaTop = count($ListaTop);

				

?>							
				<br>
				<table class="TAB_ConteudoTitulo" width=100% align="center" valign="top"> 									
				<!------------------------ Linha - Ini ---------------------------------------------------->
				<tr align="left"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php $ObjFuncao->espaco(1); ?>Assunto:
						<i><select name="CxAssunto" onchange="this.form.submit()">
							<?Php if($AdAssunto==''){ $AdAssunto = "Selecionar"; } ?>
							<option><?Php echo"$AdAssunto"; ?></option>
							<?Php for($L = 2; $L < $TotListaAss; $L++){ ?>	
								<option><?Php if($ListaAss[$L]<>""){ echo"$ListaAss[$L]"; } ?></option>
							<?Php } ?>							
						</select>	
						</i>						
						<?Php $ObjFuncao->espaco(1); ?>Topico:
						<i><select name="CxTopico">
							<?Php if($AdTopico==''){ $AdTopico = "Selecionar"; } ?>
							<option><?Php echo"$AdTopico"; ?></option>
							<?Php for($L = 0; $L < $TotListaTop; $L++){ ?>	
								<option><?Php if($ListaTop[$L]<>""){ echo"$ListaTop[$L]"; } ?></option>
							<?Php } ?>							
						</select>	
						</i>
							
												
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
?>					<tr><td width="100%" colspan="1" height="20" align="center" valign="top">

					</td></tr>
<?Php 			}			?>				
				<tr><td>
					<table class="TAB_ConteudoInt" width=100% align="center" valign="top"> 						
												
<?Php				// Controla Num de linhas do TexteArea
					$NumLinha = 23;

?>
					<select name="EdIndice">
	                    <?Php if($AdIndice==''){ $AdIndice = "Selecionar"; } ?>
	                    <option><?Php echo "$AdIndice"; ?> </option>
	                    <option>	Selecionar	</option>
						<option>	Acesso	</option>
						<option>	Arquivo	</option>
						<option>	Autenticacao	</option>
						<option>	Backup	</option>
						<option>	Config	</option>
						<option>	Contingencia	</option>
						<option>	Description	</option>
						<option>	Duplicar	</option>
						<option>	Erros	</option>
						<option>	FTP	</option>
						<option>	Hardware	</option>
						<option>	IMA	</option>
						<option>	IP	</option>
						<option>	Land	</option>
						<option>	Linguagem	</option>
						<option>	Log	</option>
						<option>	MAC	</option>
						<option>	Migracao	</option>
						<option>	Ping	</option>
						<option>	Placa	</option>
						<option>	Porta	</option>
						<option>	Profiles	</option>
						<option>	PVC	</option>
						<option>	Reset	</option>
						<option>	Script	</option>
						<option>	SCUK	</option>
						<option>	Sistema	</option>
						<option>	Taxa de erro	</option>
						<option>	Trafego	</option>
						<option>	UpLink	</option>
						<option>	VDSL	</option>
						<option>	VLAN	</option>
                    </select>
					
					<?Php $ObjFuncao->espaco(3); ?>
					Descricao:<input type="text" name="EdDescricao" size="50" value="<?Php echo "$AdDescricao" ; /* $Descricao */ ?>" >
						<tr>
							<td width="100%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">								
								<TEXTAREA ID="TxaComandoID" name="TxaComando" COLS="100" ROWS="<?Php echo"$NumLinha"; ?>" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);">
									<?Php echo "$AdComando"; /* $Comando */; ?>
								</TEXTAREA>
											
							</td>
						</tr>				
					</table>
					<?Php $ObjFuncao->espaco(3); ?>
					<select name="CxCripto">
						<?Php if($AdCripto==''){ $AdCripto = "S/Criptog"; } ?>
						<option><?Php echo"$AdCripto"; ?></option>
						<option>Criptografar</option>													
					</select>
					<input type="password" name="EdPass" size="8" value="<?Php ?>" >	
					<input type="submit" name="BtEditar" value="Salvar">
				</td></tr></table>
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