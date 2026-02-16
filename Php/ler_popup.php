
<?Php
	
	$AttribPosAbaA = $_COOKIE['CookieAttribPosAbaA']; // Posição das abas "A"
	$BotaoVoltar = 0;					// Desabilita botão Voltar
	$BotaoAvanco = 0;					// Inicializa var

	include 'config/cabecario.inc';
	
//*****************************************
// Verificar Autenticação
	$usuario = $ObjFuncao->VerAutenticacao();	
//*****************************************
	$AbaAtivaB = $AttribAbaIntB[2];	// Informa qual Aba deve ser selecionada
?>


<body BGCOLOR="<?Php echo"$ThemeCorFundoBody"; ?>" ><!-- BACKGROUND="PParede/cristal.png" --> 	
<div id="geral"><!-- Pagina Geral -->	

			<!------------------------- Inicio Conteúdo central -------------------------------------------------------------------->
			
			<div id="conteudo_Central"><!-- Conteúdo Central(Esq, Pesq, Dir)-->

			

			<!-- Conteúdo Main Esquerdo -->
			<table class="TAB_MainConteudoExt" width=100% align="center"  valign="top"> <!-- Sem Margem -->				
			<tr><!-- Conteúdo Central(Esq, Pesq, Dir) -->
				<!-- Conteúdo da Pesquisa (Resultdados)-->
				<td width="60%" colspan="1"   height="20" align="left" valign="top">
				<div id="conteudo_pesquisa"><!-- Conteúdo da Pesquisa (Resultdados)-->
				<!------------------------------------ Inicio Conteudo de  ------------------------------------------------------------------>				
<?Php
				//*********************************************************************************************
				//Consulta LISTA DE TÓPICOS
				$RegURL = $ObjFuncao->itemURL();			// Separa, registro(0), eqpto(1) clickado da URL
				
				// Memoriza Registro p/ retornos
				if($RegURL[0]>0){ 
					setcookie ("lerCookie", $RegURL[0],time()+21600);
					
				}else{
					$RegURL[0]=$_COOKIE['lerCookie'];
				}
				
				// Consulta Eqpto, Procedimento, Descricao, Comando	no MySQL			
				$ResCltMySql = $ObjMySql->CltComando($RegURL[0]);
					

?>
				
	
				
				<br><br>				
				<table class="TAB_ConteudoIntMargem" width=90% align="center" valign="top">					
				<tr><td>
					<table class="TAB_ConteudoInt" width=100% align="center" valign="top"> 						
					
<?Php				// Controla Num de linhas do TexteArea					
					$NumLinha = $ObjFuncao->ContarLinhas($ResCltMySql[4]);	// Conta Num Linhas da String Comando													
					if($NumLinha < 10){$NumLinha = 10; }			// Ajustes visuais
					else{	$NumLinha += ($NumLinha/2) + 1; }
					
					$ObjFuncao->espaco(1);					
					echo "<font size='2'>$ResCltMySql[2]</font></i>";		/* $Procedimento */ 
					echo "<i><font size='2'> ($ResCltMySql[3])</font></i>"; 	/* $Descricao */
?>
						<tr>
							<td width="100%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">
								<!-- readonly="readonly" hidden ou visible -->							
								<TEXTAREA ID="TxComando" COLS="100" ROWS="<?Php echo"$NumLinha"; ?>" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);"> 
									<?Php echo"$ResCltMySql[4]  Local: $ResCltMySql[5]"; /* $Comando */; ?>
								</TEXTAREA>
											
							</td>
						</tr>				
					</table>
					
				</td></tr></table>
				
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
	
	


</div><!-- Pagina Geral --> 


	
</body>

</html>