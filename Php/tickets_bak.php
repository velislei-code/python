

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
	
    include_once("Class.tickets.php");	//include_once: carregue o arquivo se ele j� N�O tenha sido inclu�do
	$ObjTickets = New Tickets();

	include_once("Class.script.php");	//include_once: carregue o arquivo se ele j� N�O tenha sido inclu�do
	$ObjScript = New Script();


?>

<body BGCOLOR="<?Php echo"$ThemeCorFundoBody"; ?>" ><!-- BACKGROUND="PParede/cristal.png" --> 	
<div id="geral"><!-- Pagina Geral -->	


	<table class="TAB_Geral" width="100%" align="center" valign="top">
	<form name="Localizar" method="post" action="localizar.php"><!-- Form Localizar, inserido aqui devido espa�os que cria no IE -->
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
						<a href="<?Php echo"$AttribMenuEsqIntLink06";?>" class="fonte_menu_esq">
							<?Php echo"$AttribMenuEsqInt06";?>
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
	
	<td width="100%" colspan="1"  align="center"  height="5" valign="top">
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
			<table class="TAB_MainConteudoExtMargem" width="100%" align="center" valign="top" border="0"> <!-- Margem -->	
			<tr>
			
			<!-- Conte�do Main Esquerdo -->
			<td width="20%" colspan="3"  align="left"  height="20" valign="top">

			</form><!-- Form Localizar, inserido aqui devido linhas indesejaveis no IE -->
			
			
			<form name="Tickets" method="post" action="tickets.php">				<!-- Editar -->

			<!-- Conte�do Main Esquerdo -->
			<table class="TAB_MainConteudoExt" width="100%" align="center"  valign="top" border="0"> <!-- Sem Margem -->				
			<tr><!-- Conte�do Central(Esq, Pesq, Dir) -->
				<!-- Conte�do da Pesquisa (Resultdados)-->
				<td width="60%" colspan="1"   height="20" align="left" valign="top">
				<div id="conteudo_pesquisa"><!-- Conte�do da Pesquisa (Resultdados)-->
				<!------------------------------------ Inicio Conteudo de  ------------------------------------------------------------------>				
<?Php
			//*********************************************************************************************
			
			// Inicializa vari�veis
				if(!empty($_POST['edID'])){
					$edIDX = $_POST['edID'];
				}else{
					$edIDX = '';					
				}	
				if(!empty($_POST['edEmpresa'])){
					$edEmpresaX = $_POST['edEmpresa'];
				}else{
					$edEmpresaX ='';
				}
				if(!empty($_POST['CxProduto'])){
					$CxProdutoX = $_POST['CxProduto'];
				}else{					
					$CxProdutoX = 'IPD';					
				}	
				//-----------  swa, vlan_ger, swt, swt_ip -----------------//
				if(!empty($_POST['edVlanGer'])){
					$edVlanGerX = $_POST['edVlanGer'];
				}else{
					$edVlanGerX ='';
				}
				if(!empty($_POST['edSWT'])){
					$edSwtX = $_POST['edSWT'];
				}else{
					$edSwtX ='';
				}
				if(!empty($_POST['edSWT_IP'])){
					$edSwt_ipX = $_POST['edSWT_IP'];
				}else{
					$edSwt_ipX ='';
				}
				if(!empty($_POST['edSWA'])){
					$edSwaIniX = $_POST['edSWA'];
					$edSwaX = substr($edSwaIniX, 0, 22);  // Ajusta para tamanho Padrao
					
					// Pre-Preenche SWT baseado no SWA
					if($edVlanGerX == ''){		
						$edVlanGerX = substr($edSwaIniX, 39, 5);
						//$edVlanGerX = str_replace(' ', '', $edVlanGerX);  // tira espacos vazios
						$edVlanGerX = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($edVlanGerX));
					}
					if($edSwtX == ''){						
						$posFim = strpos($edSwaIniX, '-0') - 1;
						$edSwtX = substr($edSwaIniX, 0, $posFim).'T-00';
					}
					if($edSwt_ipX == ''){						
						$posIniT = 24;
						$posFimT = $posIniT + 15;
						$edSwt_ipX = substr($edSwaIniX, $posIniT, $posFimT);
						$edSwt_ipX = substr($edSwt_ipX, 0, 15);  // Ajusta para tamanho Padrao
						$edSwt_ipX = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($edSwt_ipX));
					}
				}else{
					$edSwaX ='';
				}	
				//------------RA, Port, Svlan -----------------------------//

				if(!empty($_POST['CxInterface'])){
					$CxInterfaceX = $_POST['CxInterface'];
				}else{					
					$CxInterfaceX = '';					
				}
				if(!empty($_POST['edPort'])){
					$edPortX = $_POST['edPort'];
					$edPortX = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($edPortX));
				}else{					
					$edPortX = '';					
				}
				if(!empty($_POST['edVrf'])){
					$edVrfX = $_POST['edVrf'];					
				}else{					
					$edVrfX = '';					
				}
				if(!empty($_POST['edsVlan'])){
					$edsVlanX = $_POST['edsVlan'];
					$edsVlanX = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($edsVlanX));
				}else{					
					$edsVlanX = '';					
				}
				if(!empty($_POST['edcVlan'])){
					$edcVlanX = $_POST['edcVlan'];
					$edcVlanX = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($edcVlanX));
				}else{					
					$edcVlanX = '';					
				}
				if(!empty($_POST['edRA'])){
					$edRaIniX = $_POST['edRA'];
					$edRaX = substr($edRaIniX, 0, 22);  // Ajusta para tamanho Padrao
					// Auto preenche Porta, baseadao em Rede Acesso
					if($edPortX == ''){						
						$posIniP = 24;
						$posFimP = $posIniP + 3;
						$edPortX = substr($edRaIniX, $posIniP, $posFimP);
						$edPortX = str_replace(' ', '', $edPortX);  // tira espacos vazios
					}

					// Auto preenche sVlan, baseadao em Rede Acesso
					if($edsVlanX == ''){						
						$posIniV = $posFimP + 8;
						$posFimV = $posIniV + 7;
						$edsVlanX = substr($edRaIniX, $posIniV, $posFimV);
						$edsVlanX = str_replace(' ', '', $edsVlanX);  // tira espacos vazios
					}
				}else{
					$edRaX ='';
				}
				//-----------------------------------------------------//

                
				if(!empty($_POST['edPolicyIN'])){
					$edPolicyINX = $_POST['edPolicyIN'];
				}else{
					$edPolicyINX ='';
				}				
				if(!empty($_POST['edPolicyOUT'])){
					$edPolicyOUTX = $_POST['edPolicyOUT'];
				}else{
					$edPolicyOUTX ='';
				}					
				if(!empty($_POST['edUnit'])){
					$edUnitX = $_POST['edUnit'];
				}else{
					$edUnitX ='';
				}					

				if(!empty($_POST['edCtrlVidUnit'])){
					$edCtrlVidUnitX = $_POST['edCtrlVidUnit'];
				}else{					
					$edCtrlVidUnitX = '';					
				}
				
				if(!empty($_POST['edSpeed'])){
					$edSpeedX = $_POST['edSpeed'];
				}else{					
					$edSpeedX = '';					
				}
				
				if(!empty($_POST['edLAN'])){
					$edLANX = $_POST['edLAN'];
					$edLANX = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($edLANX));
				}else{					
					$edLANX = '';					
				}
				if(!empty($_POST['edWAN'])){
					$edWANX = $_POST['edWAN'];
					$edWANX = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($edWANX));
				}else{					
					$edWANX = '';	
									
				}
				if(!empty($_POST['edLoopBack'])){
					$edLoopBackX = $_POST['edLoopBack'];
					$edLoopBackX = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($edLoopBackX));
				}else{					
					$edLoopBackX = '';					
				}
				if(!empty($_POST['edLAN6'])){
					$edLAN6X = $_POST['edLAN6'];
					$edLAN6X = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($edLAN6X));
				}else{					
					$edLAN6X = '';					
				}
				if(!empty($_POST['edWAN6'])){
					$edWAN6X = $_POST['edWAN6'];
					$edWAN6X = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($edWAN6X));
					
				}else{					
					$edWAN6X = '';					
				}
				
				if(!empty($_POST['CxStatus'])){
					$CxStatusX = $_POST['CxStatus'];
				}else{					
					$CxStatusX = 'Selecionar';					
				}
				if(!empty($_POST['TaRascunho'])){
					$TaRascunhoX = $_POST['TaRascunho'];
				}else{					
					$TaRascunhoX = '';					
				}				
				if(!empty($_POST['CxTicket'])){

					$CxTicketX = $_POST['CxTicket'];
					
				}else{					
					$CxTicketX = 'Selecionar';		
					
				}		
				
				if(!empty($_POST['CxRouter'])){
					$CxRouterX = $_POST['CxRouter'];
					//$InterfacePort = $CxInterfaceX.$edPortX; // Junta tipo com Numero da porta
				}else{					
					$CxRouterX = 'Cisco';					
				}	

				if(isset($_POST['BtSalvar'])){
					// Cria um Ticket vazio
					$Res = $ObjTickets->SalvarTicket($CxTicketX, $edIDX, $edEmpresaX, $CxProdutoX, $edSwaX, $edVlanGerX, $edSwtX, $edSwt_ipX, $edRaX, $CxRouterX, $CxInterfaceX, $edPortX, $edSpeedX, $edCtrlVidUnitX, $edPolicyINX, $edPolicyOUTX, $edVrfX, $edsVlanX, $edcVlanX, $edLANX, $edWANX, $edLoopBackX, $edLAN6X, $edWAN6X,$CxStatusX, $TaRascunhoX);
					
				}

				$CopySn[0] = 'T31@$po*17';
				$CopySn[1] = 'Con@$f!g27';

				if(!empty($_POST['CxTicket'])){

					$CxTicketX = $_POST['CxTicket'];
					$TicketEmUso = $ObjTickets->QueryTickets($CxTicketX, NUll);
					
					$edIDX = $TicketEmUso[0][_ID];
					$edEmpresaX= $TicketEmUso[0][_Empresa]; 
					$CxProdutoX= $TicketEmUso[0][_Produto]; 
					$edSwaX= $TicketEmUso[0][_SWA]; 
					$edVlanGerX= $TicketEmUso[0][_VlanGer]; 
					$edSwtX= $TicketEmUso[0][_SWT]; 
					$edSwt_ipX= $TicketEmUso[0][_SWT_IP]; 
					$edRaX= $TicketEmUso[0][_RA]; 
					$CxRouterX= $TicketEmUso[0][_Router]; 
					$CxInterfaceX= $TicketEmUso[0][_Interface]; 
					$edPortX= $TicketEmUso[0][_Porta]; 
					$edSpeedX= $TicketEmUso[0][_Speed]; 
					$edCtrlVidUnitX= $TicketEmUso[0][_VidUnit]; 
					$edPolicyINX= $TicketEmUso[0][_PolicyIN]; 
					$edPolicyOUTX= $TicketEmUso[0][_PolicyOUT]; 
					$edVrfX= $TicketEmUso[0][_Vrf]; 
					$edsVlanX= $TicketEmUso[0][_sVlan]; 
					$edcVlanX= $TicketEmUso[0][_cVlan]; 
					$edLANX= $TicketEmUso[0][_Lan]; 
					$edWANX= $TicketEmUso[0][_Wan]; 
					$edLoopBackX= $TicketEmUso[0][_LoopBack]; 
					$edLAN6X= $TicketEmUso[0][_Lan6]; 
					$edWAN6X= $TicketEmUso[0][_Wan6];
					$CxStatusX = $TicketEmUso[0][_Status];
					$TaRascunhoX = $TicketEmUso[0][_Rascunho];

					//printf("%s -> ", $TicketEmUso[0][_Interface]);
					//echo "Entrei aki-1"."<br>";
				}else{					
					$CxTicketX = 'Selecionar';							
				}
					
				$lstTickects = $ObjTickets->QueryTickets(0, _ASSUMIDAS); // Consulta Tickets abertos, tratando
				$lstTktNovos = $ObjTickets->QueryTickets(0, _NOVOS); // Consulta Tickets abertos, novos
				$lstTktEncerrados = $ObjTickets->QueryTickets(0, _ENCERRADOS); // Consulta Tickets abertos, tratando
				
				if(isset($_POST['BtAdicionar'])){
					// Cria um Ticket vazio-novo
					$MyTickects = $ObjTickets->AddTicket('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Novo', '');
				}
				

				if(isset($_POST['BtLimpar'])){
					echo '<script type="text/javascript">';				
					echo"window.location.href = 'tickets.php'";
					echo '</script>';
				}

				$InterfacePort = $CxInterfaceX.$edPortX; // Junta tipo com Numero da porta
							
				if($CxRouterX == 'Cisco'){
					// $CxInterfaceX = 'TenGigE'; // So visual, nao altera script
					$MyScript = $ObjScript->Cisco($edIDX, $edEmpresaX, $InterfacePort, $edPolicyINX, $edPolicyOUTX,  $edsVlanX, $edcVlanX, $edLANX, $edWANX, $edLoopBackX, $edLAN6X, $edWAN6X);  
				}else if($CxRouterX == 'Huawei'){
					// $CxInterfaceX = 'GigabitEthernet'; // So visual, nao altera script
					$MyScript = $ObjScript->Huawei($edIDX, $edEmpresaX, $InterfacePort, $edCtrlVidUnitX, $edPolicyINX, $edPolicyOUTX,  $edsVlanX, $edcVlanX, $edLANX, $edWANX, $edLoopBackX, $edLAN6X, $edWAN6X);  
				
				}else if($CxRouterX == 'Nokia'){
					$InterfacePort = $edPortX; // Nokia nao usa descricao da porta
					$CxInterfaceX = ''; // So visual, nao altera script
					$MyScript = $ObjScript->Nokia($edIDX, $edEmpresaX, $InterfacePort, $edsVlanX, $edcVlanX, $edLANX, $edWANX, $edLoopBackX, $edLAN6X, $edWAN6X);  
				
				}else if($CxRouterX == 'Juniper'){
									
					$MyScript = $ObjScript->Juniper($edIDX, $edEmpresaX, $InterfacePort, $edSpeedX, $edCtrlVidUnitX, $edPolicyINX, $edPolicyOUTX, $edsVlanX, $edcVlanX, $edLANX, $edWANX, $edLoopBackX, $edLAN6X, $edWAN6X);  
				}
				$ReverIPs = $ObjScript->cmdReverIPs(); 
			
?>				
			
				<br>
				<table class="TAB_ConteudoIntMargem" width="100%" align="center" valign="top" border="0"> 			
                <tr align="left"  height="5" valign="top" style="background-color: LightSlateGray">
					<td width="20%" colspan="4"  align="left"  height="5" valign="top" ><font size='3' color='#ffffff'><b>Tickets!</b>
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
                    <!------------------------------ Inicio Form Script ---------------------------------------->
                    <td width="50%" colspan="1"  align="center"  height="5" valign="top" ><font size='2' color='#008080'>
                    <!------------------------------ Inicio Text-area Script ---------------------------------------->
                    <!-- Table anhinha TextArea/Barra de Select/Botoes -->     
                    <table class="TAB_ConteudoIntMargem" width=100% align="center" valign="top" border="0"> 					
                    
                            <tr align="left"  height="5" valign="top">
                                <td width="100%" colspan="2"  align="left"  height="5" valign="top" ><font size='2' color='#008080'>
                                    <TEXTAREA ID="TaRascunho" name="TaRascunho" COLS="120" ROWS="27" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);"> 
                                        <?Php echo $TaRascunhoX;  ?>
                                    </TEXTAREA>
                                </td>
                            </tr>  
							<tr align="left"  height="5" valign="top">
                                <td width="100%" colspan="2"  align="left"  height="5" valign="top" ><font size='2' color='#008080'>
                          
								<!---------------------- Ini Barra de Select/botoes abaixo do TextArea---------------------------------------------->
									<script>				
									function copyEdSnToClipBoardTel() {
										var content = document.getElementById('edSn_Tel'); 
										content.select();                  
										document.execCommand('copy');						
									}
									function copyEdSnToClipBoardVv() {
										var content = document.getElementById('edSn_Vv'); 
										content.select();                  
										document.execCommand('copy');						
									}
									function copyToClipBoard() {
										var content = document.getElementById('TaRascunho'); 
										content.select();                  
										document.execCommand('copy')
										//alert("Copied!");
									}
								</script>	

								<!-- Table aninha Select/Botoes Novo/salvar/Limpar -->
								<table class="TAB_ConteudoIntMargem" width=100% align="center" valign="top" border="0">				
								<tr align="left"  height="5" valign="top">
									<td width="10%" colspan="1"  align="left"  height="5" valign="top">
										<input onclick="copyEdSnToClipBoardTel()" i class="fa fa-search" type="image" src="imagens/icon/Tel.ico" title="Tel" style="max-widht:20px; max-height:20px;">                                                      
										<input onclick="copyEdSnToClipBoardVv()" i class="fa fa-search" type="image" src="imagens/icon/Vivo.ico" title="Vivo" style="max-widht:20px; max-height:20px;">                          
										<input onclick="copyToClipBoard()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
								
									</td>
									<td width="70%" colspan="1"  align="left"  height="5" valign="top">		
															
										<select name="CxTicket" size="1" onChange="this.form.submit();">							
											<option><?Php echo $CxTicketX; ?></option>	
											<!-- Tickts abertos -->
											<!-- <option disabled selected>-- Abertos --</option>-->							
											<?Php for($i = 0; $i < $lstTickects[_CONTA][_CONTA]; $i++){ ?>													
												<option><?Php printf("[%s] %s - %s(%s)", $lstTickects[$i][_REG], $lstTickects[$i][_ID], $lstTickects[$i][_Status], $lstTickects[$i][_Data]); ?></option>
											<?Php } ?>
											<!-- Tickts Novos -->
											<!-- <option disabled selected>-- Encerrados --</option>	-->												
											<option>-- Livres --</option>													
											<?Php 
												for($n = 0; $n < $lstTktNovos[_CONTA][_CONTA]; $n++){ ?>													
												<option><?Php printf("[%s] %s", $lstTktNovos[$n][_REG], $lstTktNovos[$n][_Status]); ?></option>
											<?Php } ?>	
											<!-- Tickts encerrados -->
											<!-- <option disabled selected>-- Encerrados --</option>	-->												
											<option>-- Encerrados --</option>													
											<?Php 
												$Tot = $lstTktEncerrados[_CONTA][_CONTA];
												if($Tot >= 50){ $Tot = 50; } // Limita a X registros anteriores
												for($e = 0; $e < $Tot; $e++){ ?>													
												<option><?Php printf("[%s] %s - %s(%s)", $lstTktEncerrados[$e][_REG], $lstTktEncerrados[$e][_ID], $lstTktEncerrados[$e][_Status], $lstTktEncerrados[$e][_Data]); ?></option>
											<?Php } ?>						
										</select>  	
										<select name="CxRouter" size="1" onChange="this.form.submit();">
											<option><?Php echo $CxRouterX; ?></option>														
											<option>Cisco</option>
											<option>Huawei</option>
											<option>Juniper</option>
											<option>Nokia</option>							
										</select>  
										<select name="CxStatus" size="1">
											<option><?Php echo $CxStatusX; ?></option>																					
											<option>Devolvido</option>
											<option>Novo</option>
											<option>Pendente</option>			
											<option>Resolvido</option>
											<option>Revisar</option>
											<option>Tratando</option>									
										</select>  
										
										<!--
										<button type="submit" name="BtAdicionar" value="Novo">
											<img src="imagens/icon/novo.ico"  style="widht:150px; max-height:10px;">
										</button>
										<button type="submit" name="BtSalvar" value="Salvar" aria-label="Gerar relatório pdf">
											<img src="imagens/icon/salvar.ico"  style="max-widht:150px; max-height:10px;">
										</button>
										<button type="submit" name="BtLimpar" value="Salvar" aria-label="Gerar relatório pdf">
											<img src="imagens/icon/Car.ico"  style="max-widht:150px; max-height:10px;">
										</button>
												
										<input type="image" src="imagens/icon/chave.ico" name="BtLimpar" border="1" widht="150px" height="15px" alt="Submit"/>
												-->
									</td>
									<td width="20%" colspan="1"  align="right"  height="5" valign="top">
										<input type="submit" name="BtAdicionar" src="imagens/icon/novo.ico" value="Novo">												
										<input type="submit" name="BtSalvar" src="imagens/icon/salvar.ico" value="Salvar">												
										<input type="submit" name="BtLimpar" src="imagens/icon/car.ico" value="Limpar">			
									
									</td>									
								</tr>						
								</table><!-- table final Barra Select/Botoes -->
								<!---------------------- Fim Barra de Select/botoes abaixo do TextArea ---------------------------------------------->
								</td>
                            </tr>  
						</table><!-- table final TextaArea -->   
						
						<!---------------------- Ini CMD: Checks/Revisar IPs abaixo de Select/botoes(abaixo do TextArea) ---------------------------------------------->
						
						<script>
							// Check configs atuais
							function copyEdCmdToClipBoardA() {
								var content = document.getElementById('edCmd_A'); 
								content.select();                  
								document.execCommand('copy');						
							}
							function copyEdCmdToClipBoardB() {
								var content = document.getElementById('edCmd_B'); 
								content.select();                  
								document.execCommand('copy');						
							}
							function copyEdCmdToClipBoardC() {
								var content = document.getElementById('edCmd_C'); 
								content.select();                  
								document.execCommand('copy');						
							}
							function copyEdCmdToClipBoard_ckA() {
								var content = document.getElementById('edCmd_ckA'); 
								content.select();                  
								document.execCommand('copy');						
							}
							function copyEdCmdToClipBoard_ckB() {
								var content = document.getElementById('edCmd_ckB'); 
								content.select();                  
								document.execCommand('copy');						
							}
							function copyEdCmdToClipBoard_ckC() {
								var content = document.getElementById('edCmd_ckC'); 
								content.select();                  
								document.execCommand('copy');						
							}
							function copyEdCmdToClipBoardReverIpA() {
								var content = document.getElementById('edCmdReverIPs_A'); 
								content.select();                  
								document.execCommand('copy');						
							}

							// Rever IPs
							function copyEdCmdToClipBoardReverIpB() {
								var content = document.getElementById('edCmdReverIPs_B'); 
								content.select();                  
								document.execCommand('copy');						
							}
							function copyEdCmdToClipBoardReverIpC() {
								var content = document.getElementById('edCmdReverIPs_C'); 
								content.select();                  
								document.execCommand('copy');						
							}
							function copyEdCmdToClipBoardReverIp_ckA() {
								var content = document.getElementById('edCmdReverIPs_ckA'); 
								content.select();                  
								document.execCommand('copy');						
							}
							function copyEdCmdToClipBoardReverIp_ckB() {
								var content = document.getElementById('edCmdReverIPs_ckB'); 
								content.select();                  
								document.execCommand('copy');						
							}
							function copyEdCmdToClipBoardReverIp_ckC() {
								var content = document.getElementById('edCmdReverIPs_ckC'); 
								content.select();                  
								document.execCommand('copy');						
							}
						</script>
						
						<!-- <table class="TAB_ConteudoIntMargem" width=100% align="center" valign="top" border="0"> -->			
						
						<!--  aninha Cmd-Checks/RevisaIPS -->
						<table class="TAB_ConteudoIntMargem" width=100% align="center" valign="top"> 	
						<tr align="left"  height="5" valign="top">							
							<td width="50%" colspan="3"  align="left"  height="5" valign="top" ><font size='2' color='#008080'>
							<!-------------------------------- Ini tabela Esquerda - Configs Locais ------------------------>
							
								<table class="TAB_ConteudoIntMargem" width=100% align="center" valign="top"> 					
													
									<?Php if($CxRouterX != ''){ ?>	<!-- Se ja houver um roteador definido, mostre comandos -->
									
									<tr align="left"  height="5" valign="top">										
										<td width="100%" colspan="2"  align="left"  height="5" valign="top">
											<input onclick="copyEdCmdToClipBoardA()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">                          
											<input type="text" ID="edCmd_A" name="edCmd_A" size="50" value="<?Php echo $MyScript[101]; ?>" > 
										</td>
									</tr>
									<tr align="left"  height="5" valign="top">										
										<td width="100%" colspan="2"  align="left"  height="5" valign="top">
											<input onclick="copyEdCmdToClipBoardB()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
											<input type="text" ID="edCmd_B" name="edCmd_B" size="50" value="<?Php echo $MyScript[102]; ?>" > 
										</td>
									</tr>
									<tr align="left"  height="5" valign="top">										
										<td width="100%" colspan="2"  align="left"  height="5" valign="top">
											<input onclick="copyEdCmdToClipBoardC()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
											<input type="text" ID="edCmd_C" name="edCmd_C" size="50" value="<?Php echo $MyScript[103]; ?>" > 
										</td>
									</tr>        
								<tr align="left"  height="5" valign="top">									
									<td width="100%" colspan="2"  align="left"  height="5" valign="top">
										<input onclick="copyEdCmdToClipBoard_ckA()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
										<input type="text" ID="edCmd_ckA" name="edCmd_ckA" size="50" value="<?Php echo $MyScript[201]; ?>" > 
									</td>
								</tr>
								<tr align="left"  height="5" valign="top">									
									<td width="100%" colspan="2"  align="left"  height="5" valign="top">
										<input onclick="copyEdCmdToClipBoard_ckB()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
										<input type="text" ID="edCmd_ckB" name="edCmd_ckB" size="50" value="<?Php echo $MyScript[202]; ?>" > 
									</td>
								</tr>
								<tr align="left"  height="5" valign="top">									
									<td width="100%" colspan="2"  align="left"  height="5" valign="top">
										<input onclick="copyEdCmdToClipBoard_ckC()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
										<input type="text" ID="edCmd_ckC" name="edCmd_ckC" size="50" value="<?Php echo $MyScript[203]; ?>" > 
									</td>
								</tr>
								<?Php }else{ ?>	
								<tr align="left"  height="5" valign="top">									
									<td width="100%" colspan="2"  align="left"  height="5" valign="top">
									<font size='2' color='#FF0000'>
										Nenhum roteador informado.                  
									</td>
								</tr>
								<?Php } ?>	
								</table><!--  aninha RevisaIPS -->						
							
							<!-------------------------------- Fim tabela Esquerda - Configs Locais ------------------------>
							</td>
							
							<td width="50%" colspan="3"  align="left"  height="5" valign="top" ><font size='2' color='#008080'>
							<!-------------------------------- Ini tabela Direita - Revisar Ips ------------------------>
								
							<!--  aninha RevisaIPS -->
							<table class="TAB_ConteudoIntMargem" width=100% align="center" valign="top"> 
								<tr align="left"  height="5" valign="top">									
									<td width="100%" colspan="2"  align="left"  height="5" valign="top">
										<input onclick="copyEdCmdToClipBoardReverIpA()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">                          
										<input type="text" ID="edCmdReverIPs_A" name="edCmdReverIPs_A" size="50" value="<?Php echo $ReverIPs[101]; ?>" style="font-weight: bold;"> 
									</td>
								</tr>
								<tr align="left"  height="5" valign="top">									
									<td width="100%" colspan="2"  align="left"  height="5" valign="top">
										<input onclick="copyEdCmdToClipBoardReverIpB()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
										<input type="text" ID="edCmdReverIPs_B" name="edCmdReverIPs_B" size="50" value="<?Php echo $ReverIPs[102]; ?>" > 
									</td>
								</tr>
								<tr align="left"  height="5" valign="top">									
									<td width="100%" colspan="2"  align="left"  height="5" valign="top">
										<input onclick="copyEdCmdToClipBoardReverIpC()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
										<input type="text" ID="edCmdReverIPs_C" name="edCmdReverIPs_C" size="50" value="<?Php echo $ReverIPs[103]; ?>" > 
									</td>
								</tr>   								
								<tr align="left"  height="5" valign="top">									
									<td width="100%" colspan="2"  align="left"  height="5" valign="top">
									</td>
								</tr>
								<tr align="left"  height="5" valign="top">									
									<td width="100%" colspan="2"  align="left"  height="5" valign="top">
										<input onclick="copyEdCmdToClipBoardReverIp_ckA()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
										<input type="text" ID="edCmdReverIPs_ckA" name="edCmdReverIPs_ckA" size="50" value="<?Php echo $ReverIPs[201]; ?>" style="font-weight: bold;" > 
									</td>
								</tr>
								<tr align="left"  height="5" valign="top">									
									<td width="100%" colspan="2"  align="left"  height="5" valign="top">
										<input onclick="copyEdCmdToClipBoardReverIp_ckB()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
										<input type="text" ID="edCmdReverIPs_ckB" name="edCmdReverIPs_ckB" size="50" value="<?Php echo $ReverIPs[202]; ?>" > 
									</td>
								</tr>
								<tr align="left"  height="5" valign="top">									
									<td width="100%" colspan="2"  align="left"  height="5" valign="top">
										<input onclick="copyEdCmdToClipBoardReverIp_ckC()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
										<input type="text" ID="edCmdReverIPs_ckC" name="edCmdReverIPs_ckC" size="50" value="<?Php echo $ReverIPs[203]; ?>" > 
									</td>
								</tr>								
								<tr align="left"  height="5" valign="top">									
									<td width="100%" colspan="2"  align="left"  height="5" valign="top">
									<font size='2' color='#FF0000'>													
									</td>
								</tr>							
							</table><!-- table Cmd Revisa IPS -->
						
						
						<!---------------------- Fim Barra de Select/botoes abaixo do TextArea ---------------------------------------------->
							</td>
						</tr>  
					</table>  <!-- table aninha Cmd-Checks/RevisaIPS --> 
					
					<!---------------------- Fim CMD: Checks/Revisar IPs abaixo de Select/botoes(abaixo do TextArea) ---------------------------------------------->
					
					</td> <!-- Final Conteudo Esquerdo, inicio Conteudo Direito(campos: ID, Empresa...) --> 
                    <td width="50%" colspan="1"  align="left"  height="5" valign="top" ><font size='2' color='#008080'>
                    
					<table class="TAB_ConteudoIntMargem" width="100%" align="center" valign="top"> 					
                    
                    <tr align="left"  height="5" valign="top">
                        <td width="100%" colspan="2"  align="center"  height="5" valign="top" ><font size='2' color='#008080'>
                        <!------------------------------- Ini Campos Direito -------------------------------------------------------------------->
                           	
							<script>
								function copyToClipBoardID() {
									var content = document.getElementById('edID'); 
									content.select();                  
									document.execCommand('copy')
									//alert("Copied!");
								}
								function copyToClipBoardEmp() {
									var content = document.getElementById('edEmpresa'); 
									content.select();                  
									document.execCommand('copy')
									//alert("Copied!");
								}
								function copyToClipBoardProd() {
									var content = document.getElementById('edProduto'); 
									content.select();                  
									document.execCommand('copy')
									//alert("Copied!");
								}
								function copyToClipBoardSWA() {
									var content = document.getElementById('edSWA'); 
									content.select();                  
									document.execCommand('copy')
									//alert("Copied!");
								}
								function copyToClipBoardVlanGer() {
									var content = document.getElementById('edVlanGer'); 
									content.select();                  
									document.execCommand('copy')
									//alert("Copied!");
								}
								function copyToClipBoardSWT() {
									var content = document.getElementById('edSWT'); 
									content.select();                  
									document.execCommand('copy')
									//alert("Copied!");
								}
								function copyToClipBoardSWT_IP() {
									var content = document.getElementById('edSWT_IP'); 
									content.select();                  
									document.execCommand('copy')
									//alert("Copied!");
								}
								function copyToClipBoardRA() {
									var content = document.getElementById('edRA'); 
									content.select();                  
									document.execCommand('copy')
									//alert("Copied!");
								}
								function copyToClipBoardsVrf() {
									var content = document.getElementById('edVrf'); 
									content.select();                  
									document.execCommand('copy')
									//alert("Copied!");
								}
								function copyToClipBoardsVlan() {
									var content = document.getElementById('edsVlan'); 
									content.select();                  
									document.execCommand('copy')
									//alert("Copied!");
								}
								function copyToClipBoardcVlan() {
									var content = document.getElementById('edcVlan'); 
									content.select();                  
									document.execCommand('copy')
									//alert("Copied!");
								}								
								function roboCopiarIps(){
									//document.location.href = "C:/wamp64/www/rd2r3/Robos/roboIps/roboIps.exe";
									document.location.href = "C:/WINDOWS/WRITE.EXE";
									//var shell = new ActiveXObject( "WScript.shell" );
 									//shell.run( '"C:/Windows/write.exe"', 1, true );
									alert("ATentando abrir robo Copia-IPs...");
								}
							</script>
							 <!-- ID/Produto -->	
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">
									ID/Produto:
								</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<input onclick="copyToClipBoardID()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
                       				<input type="text" id="edID" name="edID" size="10" value="<?Php echo "$edIDX" ; ?>" >
									   &nbsp;&nbsp;&nbsp;
									   <input onclick="copyToClipBoardProd()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
										<select name="CxProduto" size="1">
											<option><?Php echo $CxProdutoX; ?></option>										
											<option>IPD</option>
											<option>VLAN</option>																				                   
										</select>
						        </td>                            
                            </tr>
                            <!-- Empresa -->		
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">Empresa:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<input onclick="copyToClipBoardEmp()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
									<input type="text" id="edEmpresa" name="edEmpresa" size="26" value="<?Php echo "$edEmpresaX" ; ?>" >
                                </td>                            
                            </tr>
                            <!-- Produto --		
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top"Produto:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									
                                </td>                            
                            </tr>-->
							 <!-- SWA -->		
							 <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">SWA:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<input onclick="copyToClipBoardSWA()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
									<input type="text" id="edSWA" name="edSWA" size="26" value="<?Php echo "$edSwaX" ; ?>" >
                                </td>                            
                            </tr>
							<!-- Vlan Ger -->
							 <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">Vlan Ger:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<input onclick="copyToClipBoardVlanGer()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
									<input type="text" id="edVlanGer" name="edVlanGer" size="26" value="<?Php echo "$edVlanGerX" ; ?>" >
                                </td>                            
                            </tr>
							 <!-- SWT -->		
							 <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">SWT:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<input onclick="copyToClipBoardSWT()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
									<input type="text" id="edSWT" name="edSWT" size="26" value="<?Php echo "$edSwtX" ; ?>" >
                                </td>                            
                            </tr>
							 <!-- SWA -->		
							 <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">SWT-IP:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<input onclick="copyToClipBoardSWT_IP()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
									<input type="text" id="edSWT_IP" name="edSWT_IP" size="26" value="<?Php echo "$edSwt_ipX" ; ?>" >
                                </td>                            
                            </tr>
							 <!-- RA -->		
							 <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">RA:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<input onclick="copyToClipBoardRA()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
									<input type="text" id="edRA" name="edRA" size="26" value="<?Php echo "$edRaX" ; ?>" >
                                </td>                            
                            </tr>
                            <!-- Port -->		
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">Port:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
                                <select name="CxInterface" size="1">
                                    <option><?Php echo $CxInterfaceX; ?></option>
                                    <!-- <option disabled selected>-- Cisco --</option><!-- Ta pegando sempre ESSE  -->
                                    <option>GigaBitEth</option><!-- Cisco -->
                                    <option>PW-Ether</option><!-- Cisco -->
                                    <option>TenGigE</option><!-- Cisco -->
									<!-- <option disabled selected>-- Huawei --</option><!-- Huawei -->
									<option>GigabitEthernet</option><!-- Huawei -->	
                                    <!-- <option disabled selected>-- Juniper --</option><!-- Cisco -->	
                                    <option>ge-</option><!-- Cisco -->	
                                    <option>xe-</option><!-- Cisco -->	
                                    <!--<option disabled selected>-- Nokia --</option><!-- Nokia -->																	
                                    <option>Nokia</option><!-- Nokia -->                            
                                </select>
                                    <input type="text" name="edPort" size="11" value="<?Php echo "$edPortX" ; ?>" >
                                </td>                            
                            </tr>                            
                            <!-- PolicyIN -->                            		
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">Policy-IN:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">                                    	
                                    <input type="text" name="edPolicyIN" size="30" value="<?Php echo "$edPolicyINX" ; ?>" >
                                </td>                            
                            </tr>
                            <!-- PolicyOUT -->		
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">Policy-OUT:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">                                    	
                                    <input type="text" name="edPolicyOUT" size="30" value="<?Php echo "$edPolicyOUTX" ; ?>" >
                                </td>                            
                            </tr>
                            <!-- CtrlVid_unit/Speed -->                            
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">Vid/Unit:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
                                    <input type="text" placeholder="Ctrl-vid/Unit" name="edCtrlVidUnit" size="7" value="<?Php echo "$edCtrlVidUnitX" ; ?>" >
									<input type="text" placeholder="Speed" name="edSpeed" size="7" value="<?Php echo "$edSpeedX" ; ?>" >
                                </td>                                    
                            </tr>                           
                            <!-- Speed --
                            <!-- nao estou usando, ficou no Policy --
								<tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">Speed:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
                                    <input type="text" name="edSpeed" size="30" value="<?Php echo "$edSpeedX" ; ?>" >
                                </td>                                    
                            </tr>   -->                         
                            <!-- Vrf -->		
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">Vrf:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<input onclick="copyToClipBoardsVrf()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
									<input type="text" id="edVrf" name="edVrf" size="26" value="<?Php echo "$edVrfX" ; ?>" >
                                </td>
                            
                            </tr>
							<!-- sVlan/cVlan -->	
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">sVlan/cVlan:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<input onclick="copyToClipBoardsVlan()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
									<input type="text" placeholder="sVlan" id="edsVlan" name="edsVlan" size="7" value="<?Php echo "$edsVlanX" ; ?>" >
									&nbsp;&nbsp;&nbsp;
									<input onclick="copyToClipBoardcVlan()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
									<input type="text" placeholder="cVlan" id="edcVlan" name="edcVlan" size="7" value="<?Php echo "$edcVlanX" ; ?>" >                         
                                </td>
                            
                            </tr>
                            <!-- cVlan --	
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">cVlan:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<input onclick="copyToClipBoardcVlan()" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
									<input type="text" id="edcVlan" name="edcVlan" size="26" value="<?Php echo "$edcVlanX" ; ?>" >
                                </td>
                            
                            </tr>-->
                            <!-- LAN -->		
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">LAN(0):</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
                                    <input type="text" name="edLAN" size="30" value="<?Php echo "$edLANX" ; ?>" >
                                </td>
                            
                            </tr>
                            <!-- WAN -->		
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">WAN(0):</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
                                    <input type="text" name="edWAN" size="30" value="<?Php echo "$edWANX" ; ?>" >
                                </td>
                            
                            </tr>
                            <!-- LoopBack -->		
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">LoopBack:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
                                    <input type="text" name="edLoopBack" size="30" value="<?Php echo "$edLoopBackX" ; ?>" >
                                </td>
                            
                            </tr>
                            <!-- LAN6 -->		
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">LAN(ipv6):</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
                                    <input type="text" name="edLAN6" size="30" value="<?Php echo "$edLAN6X" ; ?>" >
									<input onclick="roboCopiarIps()" i class="fa fa-search" type="image" src="imagens/icon/roboIps.ico" title="Puxar IPs" style="max-widht:20px; max-height:20px;">									
                                </td>                            
                            </tr>
                            <!-- WAN6 -->		
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">WAN(ipv6):</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
                                    <input type="text" name="edWAN6" size="40" value="<?Php echo "$edWAN6X" ; ?>" >
                                </td>                            
                            </tr>							
							
                        <!-------------------- Fim campos Direito ----------------------------------------------------------------------->   
                        </td>
						</tr>
						
					</table><!-- Final Conteudo Direito(campos: ID, Empresa....) -->              
                        
					<!-- Repositorios(Copy) Tel/Vv --> 
					<input type="text" ID="edSn_Tel" name="edSn_Tel" size="1" value="<?Php echo $CopySn[0]; ?>" style="color:#DCDCDC; border: 0 none;">
					<input type="text" ID="edSn_Vv" name="edSn_Vv" size="1" value="<?Php echo $CopySn[1]; ?>" style="color:#DCDCDC; border: 0 none;">
				
                    </td>
                    <!------------------------------ Fim Form/TextArea Script ---------------------------------------->
                </tr>                 
                </table> <!-- Tabela Conteudo: Esquerdo(TExtArea, Barra Botoes/Select) e Direito(Campos) ---->               
            
                </table>
				
				<!------------------------------------ Final Conteudo de  ------------------------------------------------------------------->				
				</div><!-- Conte�do da Pesquisa (Resultdados)-->
			</td><!-- Conte�do da Pesquisa (Resultdados)-->
			
			<!-- Conte�do Direito(Publicidades) -->
			<td width="20%" colspan="1"   height="20" valign="top">
				<div id="conteudo_direito"><!-- Conte�do Direito(Publicidades) -->

				<script>	
				function MultiCopyToClipBoard(doc) {
						var content = document.getElementById(doc);
					 	content.select();					
						document.execCommand('copy');
						alert("Copied!");
					}
				</script>	
				<?Php for($q=0; $q<5; $q++){ $Doc = 'edTst'.$q; ?>
				    <input type="text" id="<?Php echo $Doc; ?>" name="<?Php echo $Doc; ?>" size="10" value="<?Php echo $Doc; ?>" >
					<input onclick="MultiCopyToClipBoard('<?Php echo $Doc; ?>')" i class="fa fa-search" type="image" src="imagens/icon/doc.ico" title="Puxar IPs" style="max-widht:20px; max-height:20px;">									
				<?Php } ?>	
				   


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


	
</body>

</html>