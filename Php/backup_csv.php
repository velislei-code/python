
<?Php
	$AttribPosAbaA = 2; // Posi��o das abas "A" (Declara Antes di Include)
	include 'config/cabecario.inc';
	
//*****************************************
// Verificar Autentica��o
	$usuario = $ObjFuncao->VerAutenticacao();	
//*****************************************
	$AbaAtivaA = $AbaIntA[2];			// Informa qual Aba deve ser selecionada
	
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
		
		<table class="TAB_GeralDireito" width="100%" align="center" valign="top"> <!-- cellspacing="0" cellpadding="0" height="5"  BGCOLOR="<?Php echo"$ThemeCorFundoBody"; ?>> -->
	<!------------------------------------------------------------------------------------------------------------->
		<!-- INI Linha Menus *Favoritos -->	
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
</form>	<!-- Final Form pesquisar -->

<!-- Inicio Form Gerar/Rest/Deletar -->
<form name="Gerar CSV" method="post" action="backup_csv.php">
			<!-- Conte�do Main Esquerdo -->
			<table class="TAB_MainConteudoExt" width=100% align="center"  valign="top"> <!-- Sem Margem -->				
			<tr><!-- Conte�do Central(Esq, Pesq, Dir) -->
				<!-- Conte�do da Pesquisa (Resultdados)-->
				<td width="60%" colspan="1"   height="20" align="center" valign="top">
				<div id="conteudo_pesquisa"><!-- Conte�do da Pesquisa (Resultdados)-->
				
				
			<!------------------------------------ Inicio Conteudo "Gerar/Rest/Deletar" ------------------------------------------------------------------>				
				
				
			<?Php
				
				$hoje = date("dMy");					
				$Msg = "Arquivo CSV gerado em: C:/LIWIX/Oi/Backup/rd2/TabCmd_".$hoje.".csv";
				
					
				if( isset($_POST['CxDir']) ){ $CxDirX = $_POST['CxDir'];	}
				else{	$CxDirX = defDirBak; }	
				$DirPath = $CxDirX; 						
						
				if( isset($_POST['CxArquivo']) ){ $CxArquivoX = $_POST['CxArquivo']; }
				else{	$CxArquivoX = "Arquivo(*.csv)"; }	
						
				if( isset($_POST['CxTipo']) ){	$CxTipoX = $_POST['CxTipo']; }
				else{	$CxTipoX = "Substituir";	}	
			
				if( isset($_POST['CxTipoArq']) ){	$CxTipoArq = $_POST['CxTipoArq']; }
				else{	$CxTipoArq = "csv";	}	
			
					
				//-----------------------------------------------------------------------------------------//
				// Gerar CSV
						
				if(isset($_POST['BtGerar'])){	
	
					if( ($_POST['CxDir'] == "")||($_POST['CxDir'] == "Pasta") ){
								echo	"<font color='#FF0000'>";
								echo "[Erro] Voc� deve informar a pasta"; 															
					}else{
				
						$TabA = "comandos";
						$RegX[] = "";
							
						if($_POST['CxTipoArq']=='csv'){	
						
							if($ObjMySql->GerarCSV($CxDirX, "comandos", $_POST['CxEqpto'])){
								echo	"<font color='#006400'>";
								echo "Backup da tabela comandos gerado em: ".$CxDirX."<br>";
							}
						}else if($_POST['CxTipoArq']=='html1'){
							if($ObjMySql->GerarHtml1($CxDirX, "comandos", $_POST['CxEqpto'])){
								echo	"<font color='#006400'>";
								echo "Pagina.html gerada em: ".$CxDirX."<br>";
							}
						}else if($_POST['CxTipoArq']=='html5'){
							if($ObjMySql->GerarHtml5($CxDirX, "comandos", $_POST['CxEqpto'])){
								echo	"<font color='#006400'>";
								echo "Pagina.html gerada em: ".$CxDirX."<br>";
							}
						}else{
							if($ObjMySql->GerarCSV($CxDirX, "comandos", $_POST['CxEqpto'])){
								echo	"<font color='#006400'>";
								echo "Backup da tabela comandos gerado em: ".$CxDirX."<br>";
							}
						}
					}
				}
				//-----------------------------------------------------------------------------------------//
				// Restaure Arquivos
					
				if( isset($_REQUEST['BtRestaure']) ){
				
					if( ($_POST['CxDir'] == "")||($_POST['CxDir'] == "Pasta") ){
						echo	"<font color='#FF0000'>";
						echo "[Erro] Voc� deve informar a pasta"; 	
					}else if( ($_POST['CxArquivo'] == "")||($_POST['CxArquivo'] == "Arquivo(*.csv)") ){
						echo	"<font color='#FF0000'>";
						echo "[Erro] Voc� deve informar o arquivo"; 				
					}else if( ($_POST['CxTipo'] == "")||($_POST['CxTipo'] == "Opera��o") ){
						echo	"<font color='#FF0000'>";
						echo "[Erro] Voc� deve informar o tipo de carga"; 
					}else{
				
							$Tam = strlen($_POST['CxArquivo']);
							$Ext = substr($_POST['CxArquivo'], -3, $Tam);	
							if($Ext != "csv"){ 
								echo	"<font color='#FF0000'>";
								echo "Erro! Tipo de Arquivo(".$_POST['CxArquivo'].") inv�lido!";
								echo "<br>";
							}else{
								
								echo	"<font color='#006400'>";
									
								// Inicia var�s
								$PathArqRest = $_POST['CxArquivo'];	
								$Detete_ArqTemp = false;	
									
								/* 
								 * Se Pasta AttribAtual n�o � a do Bco Biblioteca...
								 * Copia arquivo DE:.. Para: ..\dados\Biblioteca\ 
								 * antes de restaura-lo
								 */
								if( !strstr($_POST['CxDir'], "Biblioteca" )){
									// Altera nome para Temp...									
									$PathArqRest = 'Temp_'.$_POST['CxArquivo'];	
									if(copy($DirPath.$_POST['CxArquivo'], defDirBanco.$PathArqRest)){
										$Detete_ArqTemp = true;		
									}
								}
											
								// Restaura ..\dados\Biblioteca\Arquivo.csv							
								$Res = $ObjMySql->RestaureDados("comandos", $PathArqRest, $CxTipoX);
								if(substr($Res, 0, 3) == "Err"){ echo "<font color='#FF0000'>"; }else{echo "<font color='#006400'>"; }
								echo $Res."<br>";
								
								// Deleta Arquivo Temp...
								if($Detete_ArqTemp){
									$DirArqDel = defDirBanco.$PathArqRest;										
									$objMySql->DeletarArq($DirArqDel);									
										
								}
								
							}
						}
						
				}
						
				//-----------------------------------------------------------------------------------------//
				// Deletar arquivo CSV
				
				if(isset($_POST['BtDeletar'])){	
						
					if( ($_POST['CxDir'] == "")||($_POST['CxDir'] == "Pasta") ){
						echo	"<font color='#FF0000'>";
						echo "[Erro] Voc� deve informar a pasta"; 	
					}else if( ($_POST['CxArquivo'] == "")||($_POST['CxArquivo'] == "Arquivo(*.csv)") ){
						echo	"<font color='#FF0000'>";
						echo "[Erro] Voc� deve informar o arquivo a deletar."; 								
					}else{
							
						$DirArqDel = $_POST['CxDir'].$_POST['CxArquivo'];		
						if($ObjMySql->DeletarArq($DirArqDel)){
							echo	"<font color='#006400'>";
							echo "Arquivo: ".$_POST['CxArquivo']." deletado com sucesso! <br>";
						}else{
							echo	"<font color='#FF0000'>";
							echo "Erro! N�o foi poss�vel deletar o arquivo: ".$_POST['CxArquivo']."<br>";
						}
					}
				}
				//-----------------------------------------------------------------------------------------//
						
				
					
			?>
		

	<!------------------------------------ Final Conteudo "Gerar/Rest/Deletar" ------------------------------------------------------------------>				


				
				<br>	
				<table class="TAB_ConteudoTitulo" width=100% align="center" valign="top"> 					
				<!------------------------ Linha - Ini ---------------------------------------------------->
				<tr align="left"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php $ObjFuncao->espaco(2); ?>
					<font color="#191970">	
						<i><?Php echo"Backup"; ?></i><BR>
						<img border="0" src="imagens/<?Php echo"$ThemeCorLinhaMenu"; ?>" width="500" height="5">
					</td>
				</tr>
				<!------------------------ Linha - Fim ---------------------------------------------------->
				</table>
				
				<?Php
				//*********************************************************************************************
				// Pega lista Itens distintos de topico
					$ItemTopico = $ObjMySql->PegarItemTopico("Telecom");
					$TotalItemTop=count($ItemTopico);
							
				//*********************************************************************************************
				?>
				
				
				
				<br><br>
				<table class="TAB_ConteudoIntMargem" width=90% align="center" valign="top"> 					
				<tr><td>
				<table class="TAB_ConteudoInt" width=100% align="center" valign="top"> 	
						<tr>
							<td width="3%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="94%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">																
								<br><a class="fonte_topico"><i>
			<!------------------------------------ Inicio Conteudo "Gerar/Rest/Deletar" ------------------------------------------------------------------>				
					<tr>
						<td width="100%" align="left" colspan="3">&nbsp;
						<img border="0" src="imagens/pasta.png" title="<?Php echo $CxDir; ?>" width="20" height="20">
						<select name="CxDir" size="1" title="Selecione o diret�rio do arquivo a carregar." onChange="this.form.submit();">
							<option><?Php echo $CxDirX; ?></option>
                            <option><?Php echo defDirLinux; ?></option>
							<option><?Php echo defDirWamp; ?></option>
							<option><?Php echo defDirRoot; ?></option>			
							<option><?Php echo defDirApp; ?></option>			
							<option><?Php echo defDirBak; ?></option>
							<option><?Php //echo defDirBakHtml; ?></option>
							<option><?Php echo defDirData; ?></option>
							<option><?Php echo defDirBanco; ?></option>			
						</select>
						<select name="CxEqpto" size="1" title="Selecione: completo ou por eqpto a gerar">
							<option value=Null>Completo</option>
							<?Php for($E=0; $E < $TotalItemTop; $E++){ ?>
							<option><?Php printf("%s",$ItemTopico[$E][1]); ?></option>
							<?Php } ?>
						</select>
						<!-- Controi arq.csv ou pag.html-->
						<select name="CxTipoArq" size="1" title="Selecione: csv ou html">
							<option value="csv"><?Php echo $CxTipoArq; ?></option>
							<option value="csv">csv</option>
							<option value="html">html</option>
						</select>
					
						<input type="submit" value="Gerar" name="BtGerar" title="Gerar backup(csv)" style="font-family: Verdana; font-size: 10pt; cursor: hand">
						</td>				
						
                    </tr>
					<tr>
                      <td width="10%">&nbsp;</td>
                      <td width="60%">&nbsp;</td>
                      <td width="30%">&nbsp;</td>
                    </tr>
					<tr>
                      <td width="10%" align="left" colspan="1"></td>
						<td width="60%" align="left" colspan="1">				
					   <img border="0" src="imagens/pasta.png" title="<?Php echo $CxDir; ?>" width="20" height="20">
					<?php
		
						/*
						 * Lista arquivos dentro da pasta
						 * Abre um diretorio conhecido, e faz a leitura de seu conteudo
						 */
						echo "Lista de arquivos(*.csv) em: $DirPath"."<br>";
						if (is_dir($DirPath)) {	
							if ($dh = opendir($DirPath)) {
								while (($file = readdir($dh)) !== false) {
									$Tam = strlen($file) - 3;	
									$Extensao = substr($file, $Tam, 3);						
									if($Extensao == "csv"){		// Ver.Se Arq � CSV
										//if(strstr($file, $_COOKIE['bibCookie'])){	// Ver.Se(Cont�m) Arq.csv � da mesma biblioteca
                                            $ObjFuncao->espaco(5);
											echo "<img border='0' src='imagens/excel_csv.png' title='".$file."' width='20' height='20'>&nbsp;";
											echo $file.'<br>';
										//}            
									}
								}
								closedir($dh);
							}
						}
					?>
					  
					  </td>
                      <td width="30%">&nbsp;</td>
                    </tr>
					<tr>
                      <td width="10%">&nbsp;</td>
                      <td width="60%">&nbsp;</td>
                      <td width="30%">&nbsp;</td>
                    </tr>
					<tr align="middle">
						<td width="100%" height="1" align="left" valign="top" colspan="3"><!--mstheme--><font face="Arial, Helvetica"><img height="2" src="imagens/Barra.gif" width="805" border="0"><!--mstheme--></font></td>
					</tr>					
				
					<tr>
					<td width="10%" align="left" colspan="1"></td>
					<td width="90%" align="left" colspan="2">				
					<img border='0' src='imagens/excel_csv.png' title='".$file."' width='20' height='20'>&nbsp;
					<select name="CxArquivo" size="1" title="Selecione a obra a consultar.">
					<option><?Php echo $CxArquivoX; ?></option>
					<?php
		
						// Abre um diretorio conhecido, e faz a leitura de seu conteudo
						if (is_dir($DirPath)) {	
							if ($dh = opendir($DirPath)) {
								while (($file = readdir($dh)) !== false) {
									$Tam = strlen($file) - 3;	
									$Extensao = substr($file, $Tam, 3);						
									if($Extensao == "csv"){		// Ver.Se Arq � CSV
										//if(strstr($file, $_COOKIE['bibCookie'])){	// Ver.Se(Cont�m) Arq.csv � da mesma biblioteca
											?><option><?Php echo $file; ?></option><?Php
										//}            
									}
								}
								closedir($dh);
							}
						}
					?>
					</select>					 				
					<select name="CxTipo" size="1" title="Selecione o tipo de carga." >
						<option><?Php echo $CxTipoX; ?></option>
						<option value = "<?Php echo defCOPIAR; ?>">Adicionar</option>
						<option value = "<?Php echo defSUBSTITUIR; ?>">Substituir</option>
					</select>
					<input type="submit" value="Restaurar" name="BtRestaure" title="Restaurar backup(csv)" style="font-family: Verdana; font-size: 10pt; cursor: hand">						
					<input type="submit" value="Deletar" name="BtDeletar" title="Deletar arquivo(csv)" style="font-family: Verdana; font-size: 10pt; cursor: hand">
					<input type="button" value="Limpar" name="BtLimpar" OnClick="window.location='backup_csv.php'" title="Limpar" style="font-family: Verdana; font-size: 10pt; cursor: hand">

					</td>
					</tr>
					<tr>
                      <td width="10%">&nbsp;</td>
                      <td width="60%">&nbsp;</td>
                      <td width="30%">&nbsp;</td>
                    </tr>
									
				
					<tr>
					<td width="10%" align="left" colspan="1"></td>
					<td width="60%" align="left" colspan="1">
						<!--	
						<input type="submit" value="Gerar" name="BtGerar" title="Gerar backup(csv)" style="font-family: Verdana; font-size: 10pt; cursor: hand">
						<input type="submit" value="Restaurar" name="BtRestaure" title="Restaurar backup(csv)" style="font-family: Verdana; font-size: 10pt; cursor: hand">						
						<input type="submit" value="Deletar" name="BtDeletar" title="Deletar arquivo(csv)" style="font-family: Verdana; font-size: 10pt; cursor: hand">
						<input type="button" value="Limpar" name="BtLimpar" OnClick="window.location='backup_csv.php'" title="Limpar" style="font-family: Verdana; font-size: 10pt; cursor: hand">
						-->
					</td>					   
					<td width="30%" align="left" colspan="1"></td>				
					</tr>
					<!--------------------------  FIM - DELETAR ------------------------------>
					
                   </form>

				   <tr>
                      <td width="10%">&nbsp;</td>
                      <td width="60%">&nbsp;</td>
                      <td width="30%">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="10%">&nbsp;</td>
                      <td width="60%">&nbsp;</td>
                      <td width="30%">&nbsp;</td>
                    </tr>

			
							
								
								
			<!------------------------------------ Final Conteudo "Gerar/Rest/Deletar" ------------------------------------------------------------------>				
								</i>
							</td>
							<td width="3%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
						</tr>
						<tr><td width="3%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td></tr>
						

					</table>
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