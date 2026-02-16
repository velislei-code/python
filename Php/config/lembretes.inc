<style type="text/css">

	.FSB {scrollbar-base-color: #9AA7D4;}
		TEXTAREA {
				background-color: #FFFFB0;
				border: #9AA7D4 2px solid;
				color: black;
				font-family: arial, verdana, ms sans serif;
				font-size: 10pt;
				font-weight: normal
		}

		a{ text-decoration:none}
		A:hover {color:#000080;}
</style>

<?Php $ObjFuncao->AttribPularLinha(2); ?>
<!------------------------------------ Inicio Conteudo de LEMBRETES ------------------------------------------------------------------>					
	
	<?Php $ObjFuncao->espaco(1); ?>
		<table border="0" class="TAB_ConteudoIntMargem" width=100% align="center" valign="top"> 	
	
			<?Php
				//*********************************************************************************************
				$ObjMySQL = New MySQL();
				// Consulta registro número 749(Agenda -> Lembretes)
				$ResCltMySql = $ObjMySQL->CltComando(749);	
				
				// Controla Num de linhas do TexteArea					
					$NumLinha = $ObjFuncao->ContarLinhas($ResCltMySql[4]);	// Conta Num Linhas da String Comando													
					
					if($NumLinha < 10){$NumLinha =10; }			// Ajustes visuais
					else{	$NumLinha += ($NumLinha/20) + 1; }
					
					if($NumLinha > 20){$NumLinha = 18;}		// Limita a 20 linhas
			?>	
					<tr align="left"  height="5" valign="top" colspan="1">
						
						<td width="90%" colspan="1"  align="left"  height="5" valign="top">
							<font color="#36648B">
							<i><b><?Php echo"$ResCltMySql[0]:"; /* $Assunto */ ?></b></i>
							<i><b><?Php echo"$ResCltMySql[1]"; /* $Topico */ ?></b></i>
							</font>
						</td>
					
						<td width="10%" colspan="1"  align="right"  height="5" valign="top">
							<a href="editar.php?Lembretes&*reg=749" class="fonte_lista">[Editar]</a>
						</td>	
											
					</tr>
					
					<tr align="left"  height="50" valign="top" colspan="2">
					<td width="100%" colspan="2"  align="left"  height="50" valign="top">
					
					<TEXTAREA ID="TxComando" COLS="72" ROWS="<?Php echo"$NumLinha"; ?>" background-color: #ebebeb; style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);">
							<?Php echo"$ResCltMySql[4]  Local: $ResCltMySql[5]"; /* $Comando */; ?>
						</TEXTAREA>	
					</td>
				
					</tr>

				
				
			</table>
		
<!--------------------------------------------------  FINAL DE LEMBRETES --------------------------------------------------------------------------------->	