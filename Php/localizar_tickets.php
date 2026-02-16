
<?Php
	
	$AttribPosAbaA = 3; // Posi��o das abas "A" (Declara Antes di Include)
	// Inicializa var
	$BotaoVoltar = 0;					
	$BotaoAvanco = 0;					

	include 'config/cabecario.inc';
	
//*****************************************
// Verificar Autentica��o
	$usuario = $ObjFuncao->VerAutenticacao();	
//*****************************************
	
	// inicia var
	$AttribLinkAbaIntB[]="";
	$PesqTickets[][]="";
	$PesqTickets[][]="";
	
	//*********************************************************************************************
				//Consulta LISTA DE T�PICOS
				
				if( isset($_REQUEST['topico']) ){
					//$RegURL = $_REQUEST['reg'];	// -1(ajuste)
					$TopicoURL = $_REQUEST['topico'];
				}
				
				// Memoriza topico p/ retornos
				if(!empty($TopicoURL)){ 
					//setcookie ("TopicoXCookie", $TopicoURL,time()+21600);
				}else{
					if(isset($_COOKIE['TopicoXCookie'])){
						$TopicoURL = $_COOKIE['TopicoXCookie'];
					}else{
						$TopicoURL = "";
					}
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
	<style>
        .div-pesquisa {
            width: 950px; /* Largura da div */
            height: 30px; /* Altura da div */
            border: 1px solid black; /* Borda fina e preta */
            background-color: powderblue; /* Cor de fundo */
            color: #191970; /* Cor do texto */
            border-radius: 10px; /* Cantos arredondados */
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif; /* Fonte */
            font-size: 16px; /* Tamanho da fonte */
        }
    </style>
<body BGCOLOR="<?Php echo"$ThemeCorFundoBody"; ?>" ><!-- BACKGROUND="PParede/cristal.png" --> 	
<div id="geral"><!-- Pagina Geral -->	


	<table class="TAB_Geral" width="100%" align="center" valign="top">
	<form name="LocalizarTickets" method="post" action="localizar_tickets.php?<?Php echo "topico=".$TopicoURL; ?>"><!-- Form Localizar, inserido aqui devido espa�os que cria no IE -->
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
					<?Php echo"$AttribTopo[2] "; ?>
				</a>
				<a href="<?Php echo"$AttribLinkTopo[3]"; ?>" class="fonte_AttribTopo"><?Php echo"$AttribTopo[3]"; ?></a>	
				</td>
			</tr>	
		</div>	
		<!-- Fim Linha favoritos -->	
		<!-- Referencia menu Sistema -->	
		<div id="pop_sistema" class="sistema_skin" onMouseover="clearhide_sistema();highlight_sistema(event,'on')" onMouseout="highlight_sistema(event,'off');dynamichide_sys(event)"><div>						
		<!------------------------------------------------------------------------------------------------------------->
        
        <?Php 
          	
				// Rotina para memorizar Op��o corrente(Cookie)
				if(isset($_POST['EdLocalizar'])){
					$PesquisarX = $_POST['EdLocalizar'];
					//setcookie ("PesquisaXCookie", $PesquisarX,time()+21600);
				}else{
					if(isset($_COOKIE['PesquisaXCookie'])){
						$PesquisarX = $_COOKIE['PesquisaXCookie'];
					}else{
						$PesquisarX = "";
					}
				}
  
            
            
            
        ?>
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
				<!------------------------------------ Inicio Conteudo de t�pico ------------------------------------------------------------------>				
						
<?Php
				
				
				// Consulta topico
				/*
					$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
					if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection
					
					$sql = "SELECT assunto,topico FROM comandos where registro='$RegTopicoCur'";
					$result = mysqli_query($cnxMysql, $sql);		
					while ($row = mysqli_fetch_assoc($result)){  // fetch associative arr	
						$TopicoAttribAtual=$row['topico']; 	
					}
					$cnxMysql->close();		// Fecha conexao($cnxMySql)				
				
				$TopicoURL= $ObjMySql->QueryItemAttribAtual('topico',$RegTopicoCur);
				*/
			//*********************************************************************************************
			// Pesquisa item de Tickets...
			// ---- INI Pesquisa Comandos -----------------------------------------------------//				
			include_once("Class.tickets.php");	//include_once: carregue o arquivo se ele j� N�O tenha sido inclu�do
			$ObjTickets = New Tickets();

			//----------------------------------------------------------------------------//
				
			if(!empty($_POST['CxCampo'])){
				$CxCampoX = $_POST['CxCampo'];
			}else{					
				$CxCampoX = 'edd';					
			}
			if(!empty($_POST['CxCampo2'])){
				$CxCampo2Y = $_POST['CxCampo2'];
			}else{					
				$CxCampo2Y = 'status';					
			}
			if(!empty($_POST['edCpoPesquisa'])){
				$edCpoPesquisaX = $_POST['edCpoPesquisa'];
			}else{					
				$edCpoPesquisaX = 'R220';					
			}
			if(!empty($_POST['edCpoPesquisa2'])){
				$edCpoPesquisa2Y = $_POST['edCpoPesquisa2'];
			}else{					
				$edCpoPesquisa2Y = '-HYBRI';					
			}
			if(!empty($_POST['edCpoData'])){
				$edCpoDataX = $_POST['edCpoData'];
			}else{					
				$edCpoDataX = '202';					
			}


			if(isset($_POST['BtRfnPesquisa'])){	
				//echo 'PesqTickets = ObjTickets->LocalizarRefinar('.$CxCampoX.', '.$edCpoPesquisaX.')<br>';	
				$PesqTickets = $ObjTickets->LocalizarRefinar($CxCampoX, $edCpoPesquisaX, $CxCampo2Y, $edCpoPesquisa2Y, $edCpoDataX);				
			}else{
				$PesqTickets = $ObjTickets->LocalizarSimples($PesquisarX);
			}
				
           	if($PesqTickets[_CtgVETOR][_CtgVETOR] > 0){ // Confirma se consulta retornou algum registro		
				
				
                /*
				// Ajuste para n�o imprimir registro vazio
				if($PesqTickets[0][2] == ""){
					$TotalP = count($PesqTickets)-2;
					//$MsgP = "Nao foram encontradas ocorrancias para: $TopicoURL( $PesquisarX )";
					$ObjFuncao->Mensagem("Atenção!", "Nao foram encontradas ocorrencias para: $TopicoURL( $PesquisarX )", Null, Null, defAviso, defAtencao); 										
				}else{
					$TotalP = count($PesqTickets)-1;
					$ObjFuncao->Mensagem("Info!", "Foram encontradas $TotalP ocorrencias para: $TopicoURL( $MostrarTopico... '$PesquisarX' )", Null, Null, defAviso, defInfo); 										
					//$MsgP = "Foram encontradas $TotalP ocorrencias para: $TopicoURL( $MostrarTopico... '$PesquisarX' )";					
				}*/
				
					
				//*********************************************************************************************
				
				
				
?>
				
				<table class="TAB_ConteudoTitulo" width=100% align="center" valign="top"> 					
				<!------------------------ Linha - Ini ---------------------------------------------------->
				<tr align="left"  height="5" valign="top" border="1">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
					<div class="div-pesquisa" style="font-size: 9pt;">
						<!-- <h5 style="border: 1; background-color:powderblue; font-color: blue;">-->
							Pesquisar em: `tickets`&nbsp;&nbsp;&nbsp;
							
						<select name="CxCampo" size="1" style="font-size: 9pt;">																															
							<option><?Php echo $CxCampoX; ?></option>
							<option>registro</option>
							<option>id</option>
							<option>empresa</option>
							<option>produto</option>
							<option>tipo</option>
							<option>id_flow</option>
							<option>swa</option>
							<option>edd</option>
							<option>operadora</option>
							<option>vlan_ger</option>
							<option>shelf_swa</option>
							<option>slot_swa</option>
							<option>port_swa</option>
							<option>swt</option>
							<option>swt_ip</option>
							<option>rede_acesso</option>
							<option>router</option>
							<option>interface</option>
							<option>porta</option>
							<option>speed</option>
							<option>vid_unit</option>
							<option>policyIN</option>
							<option>policyOUT</option>
							<option>vrf</option>
							<option>svlan</option>
							<option>cvlan</option>
							<option>lan</option>
							<option>wan</option>
							<option>loopback</option>
							<option>lan6</option>
							<option>wan6</option>
							<option>status</option>
							<option>rascunho</option>
							<option>rever_tunnel</option>
							<option>backbone</option>
							<option>data</option>			
						</select>
						&nbsp;&nbsp;LIKE&nbsp;
						<input type="text" id="edCpoPesquisa" name="edCpoPesquisa" size="10" value="<?Php echo "$edCpoPesquisaX" ; ?>" style=" font-size: 10pt;">
						&nbsp;&nbsp;AND&nbsp;
							<select name="CxCampo2" size="1" style=" font-size: 10pt;">																															
							<option><?Php echo $CxCampo2Y; ?></option>
							<option>registro</option>
							<option>id</option>
							<option>empresa</option>
							<option>produto</option>
							<option>tipo</option>
							<option>id_flow</option>
							<option>swa</option>
							<option>edd</option>
							<option>operadora</option>
							<option>vlan_ger</option>
							<option>shelf_swa</option>
							<option>slot_swa</option>
							<option>port_swa</option>
							<option>swt</option>
							<option>swt_ip</option>
							<option>rede_acesso</option>
							<option>router</option>
							<option>interface</option>
							<option>porta</option>
							<option>speed</option>
							<option>vid_unit</option>
							<option>policyIN</option>
							<option>policyOUT</option>
							<option>vrf</option>
							<option>svlan</option>
							<option>cvlan</option>
							<option>lan</option>
							<option>wan</option>
							<option>loopback</option>
							<option>lan6</option>
							<option>wan6</option>
							<option>status</option>
							<option>rascunho</option>
							<option>rever_tunnel</option>
							<option>backbone</option>
							<option>data</option>			
						</select>
						&nbsp;&nbsp;NOT LIKE&nbsp;
						<input type="text" id="edCpoPesquisa" name="edCpoPesquisa2" size="10" value="<?Php echo "$edCpoPesquisa2Y" ; ?>" style=" font-size: 10pt;">
					
						&nbsp;&nbsp;&nbsp; AND data LIKE &nbsp; 
						<input type="text" id="edCpoData" name="edCpoData" size="10" value="<?Php echo "$edCpoDataX" ; ?>" style=" font-size: 10pt;">
						<button type="submit" name="BtRfnPesquisa" value="Rfn-Pesquisa" style="widht:20px; height:20px; border:none; cursor: pointer; background-color:powderblue;" title="Refinar Pesquisa">
							<img src="imagens/icon/lupa2.ico"  style="widht:120%; height:120%; background-color:powderblue;">
						</button>
					
						</div>	
					</td>	
				</tr>	
				<tr align="left"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
				
					<?Php //$ObjFuncao->espaco(2); ?>
						<i><?Php //echo"Pesquisa privada(T�p: $MostrarTopico)"; ?></i><BR>
						<img border="0" src="imagens/<?Php echo"$ThemeCorLinhaMenu"; ?>" width="500" height="5">
					</td>
				</tr>
				<!------------------------ Linha - Fim ---------------------------------------------------->
				</table>
				
				<table class="TAB_ConteudoIntMargem" width=90% align="center" valign="top"> 	
				<tr><td>
					<table class="TAB_ConteudoInt" width=100% align="center" valign="top"> 	
						<tr>
							<td width="3%" colspan="1" height="20" align="left" valign="top">
							<td width="94%" colspan="1" height="20" align="left" valign="top">
								<br><i><?Php //echo $MsgP; ?></i>
								
							</td>
							<td width="3%" colspan="1" height="20" align="left" valign="top"></td>
						</tr>
						<tr><td width="3%" colspan="1" height="20" align="left" valign="top"></td></tr>
						
					<?Php
						echo '<font size="2" face="Verdana" color="blue"><b>';
						echo 'Sua busca retornou: '.$PesqTickets[_CtgVETOR][_CtgVETOR].' registros.'.'<br>';
						echo '</b><font size="1" face="Verdana" color="#008000" font-weight: normal;>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						echo "     SELECT * FROM tickets WHERE ".$CxCampoX." LIKE '%".$edCpoPesquisaX."%' AND ".$CxCampo2Y." NOT LIKE '%".$edCpoPesquisa2Y."%' AND data LIKE '%".$edCpoDataX."%' ORDER BY registro DESC";
     	
						for($E = 0; $E < $PesqTickets[_CtgVETOR][_CtgVETOR]; $E++){
						$Eb = $E+1;								
					
					?>						
						<tr>
							<td width="3%" colspan="1" height="20" align="left" valign="top"></td>
							<td width="94%" colspan="1" height="20" align="left" valign="top">
								<!-- <a href="<?Php printf("%s?%s&*reg=%d",$AttribLinkAbaIntB[2],$PesqTickets[$E][_ID],$PesqTickets[$E][_REG]); ?>" class="fonte_lista">-->
								<a href="<?Php printf("tickets.php?reg=%d",$PesqTickets[$E][_REG]); ?>" class="fonte_lista">
									<?Php printf("%d - %s",$Eb,$PesqTickets[$E][_ID]); ?>
									<i><?Php printf("(%s, %s)-[ %d ], %s ",$PesqTickets[$E][_Empresa], $PesqTickets[$E][_Produto], $PesqTickets[$E][_REG], $PesqTickets[$E][_Data]); ?></i>
								</a>
							</td>
							<td width="3%" colspan="1" height="20" align="left" valign="top"><font color="#000000"></td>
						<tr>		
						<tr>
							<td width="3%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
							<td width="500" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana">							
								<table class="TAB_ConteudoPsq" width=80% align="center" valign="top"> 	
									<tr><td>										
										<?Php 
                                            $ParteRascunho = substr($PesqTickets[$E][_Rascunho],0,350); echo"$ParteRascunho..."."<br>"; printf("[%s]", $PesqTickets[$E][_ID]); 
                                            
                                        ?>										
									</td></tr>
									<tr><td>										
										<?Php 
                                            $ParteBBone = substr($PesqTickets[$E][_Backbone],0,350); echo"$ParteBBone..."."<br>"; printf("[%s]", $PesqTickets[$E][_ID]); 
                                            
                                        ?>										
									</td></tr>
								</table>													
							</td>
							<td width="3%" colspan="1" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
						</tr>
						<tr>
							<td width="100%" colspan="3" height="20" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>
						</tr>
			<?Php	}	?>
					</table>
				</td></tr></table>	
						
				<!------------------------------------ Final Conteudo de t�pico ------------------------------------------------------------------->				
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
	<?Php }else{
		$ObjFuncao->Mensagem("Atenção!", "Nao foram encontradas ocorrencias para: Tickets( $PesquisarX )", Null, Null, defAviso, defAtencao); 										
	} // if(!empty($PesqTickets)){ // Confirma se consulta retornou algum registro ?>

	</div><!-- Geral Direito -->
	
	</td>
	</tr>
	
	</table>
	
	<!-------------------------------- Final Geral Direito -------------------------------------------------------------------->
	<?Php if(!empty($PesqTickets[0][0])){ // Confirma se consulta retornou algum registro -- Bloqueia Rodapé p/ não subir na Tabela ?>

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
	<?Php } // // Confirma se consulta retornou algum registro -- Bloqueia Rodapé p/ não subir na Tabela ?>


</div><!-- Pagina Geral --> 

</form><!-- Localizar -->
	
</body>

</html>