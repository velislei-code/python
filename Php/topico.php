<?Php
	
	$AttribPosAbaA = 1; // Posi��o das abas "A" (Declara Antes di Include)
	$BotaoVoltar = 0;					// Desabilita bot�o Voltar
	$BotaoAvanco = 0;					// Inicializa var

//*****************************************
// Verificar Autentica��o
	//$usuario = $ObjFuncao->VerAutenticacao();	
//*****************************************

	// Limpa Cookie T�pico
	////setcookie ("TopicoXCookie", "",time()+21600);
	if( isset($_REQUEST['reg']) ){
		$RegURL = $_REQUEST['reg'];
		//setcookie ("CookieRegURL", $RegURL);	
				 
	}else{
		$RegURL = $_COOKIE['CookieRegURL'];
	}
	
	if( isset($_REQUEST['topico']) ){			
		$TopicoURL = $_REQUEST['topico'];
		//setcookie ("CookieTopicoURL", $TopicoURL);
	}else{
		if( isset($_COOKIE['topico']) ){		
			$TopicoURL = $_COOKIE['CookieTopicoURL'];
		}ELSE{
			$TopicoURL = "";
		}
	}

	include 'config/favoritos.inc'; 
	include 'config/theme.inc';	
	include 'config/cabecario.inc';
	
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('topico.php');

	// Pega IP da maquina
	$url = '';
	$get_ip = gethostbyname($url);

	
	/********** DNS ***************************************************************************/
	$MyDns = "";
	$Localizar = "DNS.";
	exec ("ipconfig.exe /all", $output_array, $return_val);
	//echo "Retornou: $return_val <br> <pre>";
	foreach ($output_array as $InfoCmd)
	{
		$pos = strpos($InfoCmd, $Localizar);
		if($pos === false){ /* Imprime todo lista de ipconfig /all: echo "$X <br>"; */	}
		else{ $MyDns = $InfoCmd; /* echo "$InfoCmd <br>"; */ }	// Imprime somente linha DNS.
	}
	//echo "</pre>";
	
	                                        //Pegou: DNS......................: 8.8.8.8 */
	$posFiltra = strpos($MyDns, ":");		// Pega Posi��o de ":"
	$Dns = substr($MyDns, $posFiltra, 16);	// Filtra somente 8.8.8.8
	
	
	/********** DNS ***************************************************************************/
	


	 

	
?>



<?php
/*
$indicesServer = array('PHP_SELF',
'argv',
'argc',
'GATEWAY_INTERFACE',
'SERVER_ADDR',
'SERVER_NAME',
'SERVER_SOFTWARE',
'SERVER_PROTOCOL',
'REQUEST_METHOD',
'REQUEST_TIME',
'REQUEST_TIME_FLOAT',
'QUERY_STRING',
'DOCUMENT_ROOT',
'HTTP_ACCEPT',
'HTTP_ACCEPT_CHARSET',
'HTTP_ACCEPT_ENCODING',
'HTTP_ACCEPT_LANGUAGE',
'HTTP_CONNECTION',
'HTTP_HOST',
'HTTP_REFERER',
'HTTP_USER_AGENT',
'HTTPS',
'REMOTE_ADDR',
'REMOTE_HOST',
'REMOTE_PORT',
'REMOTE_USER',
'REDIRECT_REMOTE_USER',
'SCRIPT_FILENAME',
'SERVER_ADMIN',
'SERVER_PORT',
'SERVER_SIGNATURE',
'PATH_TRANSLATED',
'SCRIPT_NAME',
'REQUEST_URI',
'PHP_AUTH_DIGEST',
'PHP_AUTH_USER',
'PHP_AUTH_PW',
'AUTH_TYPE',
'PATH_INFO',
'ORIG_PATH_INFO') ;

echo '<table cellpadding="10">' ;
foreach ($indicesServer as $arg) {
    if (isset($_SERVER[$arg])) {
        echo '<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>' ;
    }
    else {
        echo '<tr><td>'.$arg.'</td><td>-</td></tr>' ;
    }
}
echo '</table>' ;

*/

	//$info = system('ipconfig /all');
	//echo "<br>";

	//print_r(explode('...', system('ipconfig /all'), -1));
	/*
	$infoHost = explode(": ", $info);
	for($e=0; $e<10; $e++){
		
		printf("%s\n", $infoHost[$e]);
		echo "<br>";	
		
		
	}
	
	
	exec("ipconfig /all", $out, $res);

	foreach (preg_grep('/^\s*Physical Address[^:]*:\s*([0-9a-f-]+)/i', $out) as $line) {
		echo substr(strrchr($line, ' '), 1), PHP_EOL;
	}
	*/
	
	
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
				
				<!-- Meu IP -->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>	
						<a href="<?Php echo"$AttribMenuSobreLink01"; ?>" class="fonte_menu_esq">						
							<?Php echo "IP: $get_ip";  ?>
						</a>
											
			
					</td>
				</tr>
				<!-- Meu IDNS				-->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>	
						<a href="<?Php echo"$AttribMenuSobreLink01"; ?>" class="fonte_menu_esq">						
							<?Php echo "DNS: $Dns";  ?>
						</a>
											
			
					</td>
				</tr>
				<!------------------------ FullCalendar - Fim ---------------------------------------------------->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
							<?Php $ObjFuncao->espaco(5); ?>
							<!-- Imprime lista de cookies ativos no Navegador -->
							<img src = "imagens/calendario.jpg" width="100" height="100" title="Agenda" style="cursor: pointer;" width="25" height="150" onclick="window.open('fullcalendar/index.php', '_blank');" alt="Pop-Up" title="Pop-Up">				
					</td>
				</tr>
				
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
					
				<a href="#" class="fonte_AttribTopo"><?Php //echo"$usuario"; ?></a>
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
			<td width="20%" colspan="1"  align="left" height="20" valign="top">

			<!-- Conte�do Main Esquerdo -->
			<table class="TAB_MainConteudoExt" width=100% align="center"  valign="top"> <!-- Sem Margem -->				
			<tr><!-- Conte�do Central(Esq, Pesq, Dir) -->
				<!-- Conte�do da Pesquisa (Resultdados)-->
				<td width="60%" colspan="1" height="20" align="left" valign="top">
				<div id="conteudo_pesquisa"><!-- Conte�do da Pesquisa (Resultdados)-->
				<!------------------------------------ Inicio Conteudo de  ------------------------------------------------------------------>				
<?Php
				//*********************************************************************************************
				//Consulta LISTA o assunto ao qual pertence
				
				$RegURLx = $ObjFuncao->itemURL();			// Separa, registro(0), topico(1) clickado da URL
				
				// Memoriza Registro p/ retornos
				if($RegURLx[0]>0){ 
					////setcookie ("AssuntoXCookie", $RegURL[0],time()+21600);
				}else{
					$RegURLx[0]=$_COOKIE['AssuntoXCookie'];
				}
				
				if($RegURLx[0]>0){
					// Consulta Assunto
					$Assunto = $ObjMySql->QueryItemAttribAtual('assunto',$RegURLx[0]);

				}else{ 
					$Assunto='Lista completa';
				}

				if(empty($Assunto)){ $Assunto='Telecom'; }	// SE assunto esta vazio...pega default
				
				//*********************************************************************************************
				// Pega lista Itens distintos de topico
					$ItemTopico = $ObjMySql->PegarItemTopico($Assunto);
					$Total=count($ItemTopico);
							
				//*********************************************************************************************
					
?>
				<br>
				<table class="TAB_ConteudoTitulo" width=100% align="center" valign="top"> 					
				<!------------------------ Linha - Ini ---------------------------------------------------->
				<tr align="left"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php $ObjFuncao->espaco(2); ?>
						<i><?Php echo"$Assunto($Total)"; ?></i><BR>
						<img border="0" src="imagens/<?Php echo"$ThemeCorLinhaMenu"; ?>" width="500" height="5">
					</td>
				</tr>
				<!------------------------ Linha - Fim ---------------------------------------------------->
				</table>


				
				<table class="TAB_ConteudoIntMargem" width=90% align="center" valign="top"> 					
				<tr><td>
					<table class="TAB_ConteudoInt" width=100% align="center" valign="top"> 	
<?Php				
					$Tm = $Total-1;
					for($E=0; $E < $Total; $E+=2)
					{	
						$ColEsq = $E;
						$ColDir = $E+1;		
						if($ColDir > $Tm){$ColDir = $Tm;}	
						
						//	if($Total % 2 == 0){ }	// Testa se Num � Par
	
?>						
						<tr>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="35%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">
								<a href="indice.php?<?Php printf("topico=%s&reg=%d",$ItemTopico[$ColEsq][1],$ItemTopico[$ColEsq][0]); ?>" class="fonte_topico">
									<?Php printf("%s",$ItemTopico[$ColEsq][1]); ?>
								</a>
							</td>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="35%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">								
								<a href="indice.php?<?Php printf("topico=%s&reg=%d",$ItemTopico[$ColDir][1],$ItemTopico[$ColDir][0]); ?>" class="fonte_topico">
									<?Php if($ColDir > $ColEsq){ printf("%s",$ItemTopico[$ColDir][1]); } /* Se ColEsq for Diferente ColDir...Imprima ! */ ?>
									
								</a>	
							</td>
							<td width="10%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
						</tr>
<?Php 				
						// Localiza num na matriz correspondente a Pend�ncias
						$ColPen = 0;	// Inicializa
						if($ItemTopico[$ColDir][1] == 'Pendências'){ $ColPen = $ColDir;  }	
					
					}
					
					// Contagem das pend�ncias
					$ListaPen = ""; 	// Inicializa
					$Pendencias = $ObjMySql->QueryTopico('Pendências');
					 /*
					 ta dando erro de offset - tem que verificar
					for($P=0; $P<$Pendencias[100]; $P++){
						$ListaPen = $ListaPen.$Pendencias[$P][3].": ".$Pendencias[$P][4]."\n";
					}
					*/
?>
					</table>
				</td></tr>
				
				
				</table>	
				
				
			
					
				<!------------------------------------ Final Conteudo central  ------------------------------------------------------------------->				
				</div><!-- Conte�do da Pesquisa (Resultdados)-->
			</td><!-- Conte�do da Pesquisa (Resultdados)-->
			
			
			
			<!-------------------------------------- Conte�do Direito( Agenda) -------------------------------------------------------->
			<td width="20%" colspan="1"  align="right" height="20" valign="top">
				<div id="conteudo_direito"><!-- Conte�do Direito(Publicidades) -->
					  <!-- Resevado Publicidade -->
						
					  <?Php include 'config/lembretes.inc';	 ?>
					 
					<img border="0" src="imagens/macd3.png" width="500" height="240">
					
				</div><!-- Conte�do Direito(Publicidades)-->			
			</td><!--------------------------------- Conte�do Direito(Agenda) -------------------------------------------------------->
			<!--
				4984 4255 0424 3693 
10/20
cvv 888

CVmadmad
	-->		
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
	<?Php 	
		$It = $ItemTopico[$ColPen][1];
		$RegIt = $ItemTopico[$ColPen][0];
		$AttribRodapeLink01 = "indice.php?$It&*reg=$RegIt";
		$AttribRodape01 = "H� ".$Pendencias[100][100]." pend�ncias !";  
		
	?>
	
						
	<div id="rodape"><!-- Rodap� -->
		<table class"TAB_Rodape" width=100% align="center" valign="top">	
		<tr align="center"  height="5" valign="top">
			<td width="15%" colspan="1"  align="left"  height="5" valign="top"></td>		
			<td width="70%" colspan="1"  align="left"  height="5" valign="top">		
				<a href="<?Php echo"$AttribRodapeLink00"; ?>" class="fonte_rodape"><?Php echo "Total de registro: ".$ObjMySql->ContarRegistros($Assunto); ?></a><?Php // echo"$AttribRodape00"; ?>
				&nbsp;			
				<a href="<?Php printf("indice.php?topico=%s&reg=%d",$ItemTopico[$ColPen][1],$ItemTopico[$ColPen][0]); ?>" class="fonte_atencao" title="<?Php echo"$ListaPen"; ?>"><?Php echo"$AttribRodape01"; ?></a>			
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