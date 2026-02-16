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
	
    include_once("Class.script.php");	//include_once: carregue o arquivo se ele j� N�O tenha sido inclu�do
	$ObjScript = New Script();

	include_once("Class.tickets.php");	//include_once: carregue o arquivo se ele j� N�O tenha sido inclu�do
	$ObjTickets = New Tickets();

	include_once("Class.preferencias.php");	//include_once: carregue o arquivo se ele j� N�O tenha sido inclu�do
	$ObjPrefere = New Preferencias();

	$CamposVazios = false;	// Ctrl msg/verificação de campos vazios
				//*********************************************************************************************
			
				if(isset($_POST['BtLimpar'])){
					echo '<script type="text/javascript">';				
					echo"window.location.href = 'script.php'";
					echo '</script>';
				}				
				if(!empty($_POST['CxTipo'])){
					$CxTipoX = $_POST['CxTipo'];
				}else{					
					$CxTipoX = 'Config';					
				}				
				if(!empty($_POST['CxRouter'])){
					$CxRouterX = $_POST['CxRouter'];
				}else{					
					$CxRouterX = 'Cisco';					
				}	
				
				// Tipo de config ies no Nokia(pelo ID ou pela scVlan)
				if(!empty($_POST['CxIesNokia'])){
					$CxIesNokiaX = $_POST['CxIesNokia'];
				}else{					
					$CxIesNokiaX = 'ID';					
				}				
				if(!empty($_POST['CxModelo'])){
					$CxModeloX = $_POST['CxModelo'];
				}else{	
					if($CxRouterX == 'Cisco'){ $CxModeloX = 'ASR9K'; }
					else if($CxRouterX == 'Huawei'){ $CxModeloX = 'NE40E_X8A'; }
					else { $CxModeloX = 'Default'; }
	
				}				
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
					if(!empty($_POST['edEdd'])){
						$edEddX = $_POST['edEdd'];
					}else{					
						$edEddX = '';					
					}
					if(!empty($_POST['edSwa'])){
						$edSwaX = $_POST['edSwa'];
					}else{					
						$edSwaX = '';					
					}
					if(!empty($_POST['edSwt'])){
						$edSwtX = $_POST['edSwt'];
					}else{					
						$edSwtX = '';					
					}
					if(!empty($_POST['edSwt_ip'])){
						$edSwt_ipX = $_POST['edSwt_ip'];
					}else{					
						$edSwt_ipX = '';					
					}
					
					if(!empty($_POST['CxShelfSwaX'])){
						$CxShelfSwaX = $_POST['CxShelfSwaX'];
					}else{					
						$CxShelfSwaX = '';	
					}
					if(!empty($_POST['edPortaSwa'])){
						$CxSlotSwaX = $_POST['edPortaSwa'];
					}else{					
						$CxSlotSwaX = '';	
					}
					if(!empty($_POST['CxPorta2Swa'])){
						$CxPorta2SwaX = $_POST['CxPorta2Swa'];
					}else{					
						$CxPorta2SwaX = '';	
					}

					$CxPortaSwaX = '';	
					if(!empty($_POST['CxLimNome'])){
						$CxLimNomeX = $_POST['CxLimNome'];
					}else{
						$CxLimNomeX = 12;
					}
	
					if($CxRouterX == 'Cisco'){
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
					}else if($CxRouterX == 'Huawei'){
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
						
					}else if($CxRouterX == 'Juniper'){
							if(!empty($_POST['edUnit'])){
								$edUnitX = $_POST['edUnit'];
							}else{
								$edUnitX ='';
							}		
					}else{
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
					}
	
					if(!empty($_POST['edCtrlVidUnit'])){
						$edCtrlVidUnitX = $_POST['edCtrlVidUnit'];
					}else{					
						$edCtrlVidUnitX = '';					
					}
					if(!empty($_POST['CxInterface'])){
						$CxInterfaceX = $_POST['CxInterface'];
					}else{					
						$CxInterfaceX = '';					
					}
					if(!empty($_POST['edPort'])){
						$edPortX = $_POST['edPort'];
					}else{					
						$edPortX = '';					
					}
					if(!empty($_POST['edSpeed'])){
						$edSpeedX = $_POST['edSpeed'];
					}else{					
						$edSpeedX = '';					
					}
					if(!empty($_POST['edgVlan'])){
						$edgVlanX = $_POST['edgVlan'];
					}else{					
						$edgVlanX = '';					
					}
					if(!empty($_POST['edsVlan'])){
						$edsVlanX = $_POST['edsVlan'];
					}else{					
						$edsVlanX = '';					
					}
					if(!empty($_POST['CxSVlan2'])){
						$CxSVlan2X = $_POST['CxSVlan2'];
					}else{					
						$CxSVlan2X = '';					
					}

					if(!empty($_POST['edcVlan'])){
						$edcVlanX = $_POST['edcVlan'];
					}else{					
						$edcVlanX = '';					
					}
					if(!empty($_POST['edLAN'])){
						$edLANX = $_POST['edLAN'];
					}else{					
						$edLANX = '';					
					}
					if(!empty($_POST['edWAN'])){
						$edWANX = $_POST['edWAN'];
					}else{					
						$edWANX = '';					
					}
					if(!empty($_POST['CxWanFx'])){
						$CxWanFxX = $_POST['CxWanFx'];		
					}else{					
						$CxWanFxX = '/30';	
					}
					

					if(!empty($_POST['edLoopBack'])){
						$edLoopBackX = $_POST['edLoopBack'];
					}else{					
						$edLoopBackX = '';					
					}
					if(!empty($_POST['edLAN6'])){
						$edLAN6X = $_POST['edLAN6'];
					}else{					
						$edLAN6X = '';					
					}
					if(!empty($_POST['edWAN6'])){
						$edWAN6X = $_POST['edWAN6'];
					}else{					
						$edWAN6X = '';					
					}
					if(!empty($_POST['TaRotasIntragov'])){
						$TaRotasIntragovX = $_POST['TaRotasIntragov'];
					}else{					
						$TaRotasIntragovX = '';					
					}

					//------------ Ini-Script-Tunnel ----------------------------------------// 
					if(!empty($_POST['CxPwId'])){
						$CxPwIdX = $_POST['CxPwId'];
					}else{					
						$CxPwIdX = '';					
					}
					if(!empty($_POST['edNomeNeighbor'])){
						$edNomeNeighborX = $_POST['edNomeNeighbor'];
					}else{					
						$edNomeNeighborX = '';					
					}

					if(!empty($_POST['edIpNeighbor'])){
						$edIpNeighborX = $_POST['edIpNeighbor'];
					}else{					
						$edIpNeighborX = '';					
					}
					if(!empty($_POST['CxIntOrigem'])){
						$CxIntOrigemX = $_POST['CxIntOrigem'];
					}else{					
						$CxIntOrigemX = '';					
					}
					if(!empty($_POST['edPortOrigem'])){
						$edPortOrigemX = $_POST['edPortOrigem'];
					}else{					
						$edPortOrigemX = '';					
					}
					if(!empty($_POST['CxIntDestino'])){
						$CxIntDestinoX = $_POST['CxIntDestino'];
					}else{					
						$CxIntDestinoX = '';					
					}
					if(!empty($_POST['edPortDestino'])){
						$edPortDestinoX = $_POST['edPortDestino'];
					}else{					
						$edPortDestinoX = '';					
					}

					if(!empty($_POST['CxIntHl5g'])){
						$CxIntHl5gX = $_POST['CxIntHl5g'];
					}else{					
						$CxIntHl5gX = '';					
					}
					if(!empty($_POST['edPortHl5g'])){
						$edPortHl5gX = $_POST['edPortHl5g'];
					}else{					
						$edPortHl5gX = '';					
					}


					if(!empty($_POST['CxTunnelTipo'])){
						$CxTunnelTipoX = $_POST['CxTunnelTipo'];
					}else{					
						$CxTunnelTipoX = 'Config';					
					}				
					if(!empty($_POST['CxTunnelRouter'])){
						$CxTunnelRouterX = $_POST['CxTunnelRouter'];
					}else{					
						$CxTunnelRouterX = 'Cisco';					
					}	
					if(!empty($_POST['CxTunnelModelo'])){
						$CxTunnelModeloX = $_POST['CxTunnelModelo'];
					}else{					
						$CxTunnelModeloX = 'Cisco';					
					}	
					//------------ Fim-Script-Tunnel ----------------------------------------// 
	
					if(isset($_POST['CxTicket'])){
	
						$CxTicketX = $_POST['CxTicket'];
						$TicketEmUso = $ObjTickets->QueryTickets($CxTicketX, _TUDO, 'Script');
	
						$edIDX = $TicketEmUso[0][_ID];
						$edEmpresaX= substr($TicketEmUso[0][_Empresa], 0, $CxLimNomeX); 
						$CxTipoX= $TicketEmUso[0][_Tipo]; 
						$ProdutoX= $TicketEmUso[0][_Produto]; 
						$edIdFlowX= $TicketEmUso[0][_IdFlow];
						$edSwaX = $TicketEmUso[0][_SWA]; 
						$edEddX = $TicketEmUso[0][_EDD];	
						$CxOperadoraX= $TicketEmUso[0][_OPERADORA];					 
						$edgVlanX= $TicketEmUso[0][_VlanGer];
						$edTipoPtSwaX= $TicketEmUso[0][_TipoPortaSWA]; 
						$CxShelfSwaX= $TicketEmUso[0][_ShelfSwa]; 
						$CxSlotSwaX= $TicketEmUso[0][_SlotSwa]; 
						$CxPortaSwaX= $TicketEmUso[0][_PortSwa]; 
						$edSwtX= $TicketEmUso[0][_SWT]; 
						$edSwt_ipX= $TicketEmUso[0][_SWT_IP]; 
						$edRaX= $TicketEmUso[0][_RA]; 
						$CxRouterX= $TicketEmUso[0][_Router]; 
						$CxInterfaceX= $TicketEmUso[0][_Interface]; 
						$CxInteOrigemX = $TicketEmUso[0][_Interface]; 	 //Tunnel
						$edPortX= $TicketEmUso[0][_Porta]; 
						$edPortOrigemX= $TicketEmUso[0][_Porta];  	// Tunnel
						$edSpeedX= $TicketEmUso[0][_Speed]; 
						$edCtrlVidUnitX= $TicketEmUso[0][_VidUnit]; 
						$edPolicyINX= $TicketEmUso[0][_PolicyIN]; 
						$edPolicyOUTX= $TicketEmUso[0][_PolicyOUT]; 
						$edVrfX= $TicketEmUso[0][_Vrf]; 
						$edsVlanX= $TicketEmUso[0][_sVlan]; 
						$edcVlanX= $TicketEmUso[0][_cVlan]; 
						$edLANX= $TicketEmUso[0][_Lan]; 
						$edWANX= $TicketEmUso[0][_Wan]; 
						$CxWanFxX= $TicketEmUso[0][_WanFx]; 
						$edLoopBackX= $TicketEmUso[0][_LoopBack]; 
						$edLAN6X= $TicketEmUso[0][_Lan6]; 
						$edWAN6X= $TicketEmUso[0][_Wan6];
						$TaRotasIntragovX= $TicketEmUso[0][_RtIntragov];
						$CxStatusX = $TicketEmUso[0][_Status];
						$TaRascunhoX = $TicketEmUso[0][_Rascunho];
						
						if($CxModeloX == ''){
							if($CxRouterX == 'Cisco'){ $CxModeloX = 'ASR9K'; }
							else if($CxRouterX == 'Datacom'){ $CxModeloX = $edEddX; }
							else if($CxRouterX == 'Huawei'){ $CxModeloX = 'NE40E_X8A'; }
							else if($CxRouterX == 'Juniper'){ $CxModeloX = 'MX480'; }
							else if($CxRouterX == 'Nokia'){ $CxModeloX = 'SR7750'; }
						}

						if($CxRouterX == 'Datacom'){ $CxModeloX = $edEddX; }
	
						if(str_contains($CxTipoX, _DCFG)){
							if(str_contains($edEddX, '2104')){
								if((str_contains($CxPortaSwaX, '1'))||(str_contains($CxPortaSwaX, '5')) ){
									$objFuncao->Mensagem('Porta UpLINK?', 'Verifique se: '.$edEddX.', ethernet '.$CxShelfSwaX.'/'.$CxSlotSwaX.'/'.$CxPortaSwaX.' nao é UPLINK!', Null, Null, defAviso, defPerigo);
								}
							}
							if((str_contains($edEddX, '50'))||(str_contains($edEddX, '70')) ){
								if((str_contains($CxPortaSwaX, '1'))||(str_contains($CxPortaSwaX, '24')) ){
									$objFuncao->Mensagem('Porta UpLINK?', 'Verifique se: '.$edEddX.', giga-ethernet '.$CxShelfSwaX.'/'.$CxSlotSwaX.'/'.$CxPortaSwaX.' nao é UPLINK!', Null, Null, defAviso, defPerigo);
								}
							}
						}
						// $objFuncao->Mensagem('Atencao!', 'Nao foi possivel Alterar registro, o mesmo ja foi finalizado', Null, Null, defAviso, defAtencao);
							

					}else{					
						$CxTicketX = 'Selecionar';		
						$edRaX = '';	
						$edVrfX = '';	
						$CxOperadoraX = '';	
						$edTipoPtSwaX = '';	

					}

					// Uplink-Coriant
					if(!empty($_POST['edUpLinkSwa'])){
						$edUpLinkSwaX = $_POST['edUpLinkSwa'];
					}else{	
						if(!empty($CxShelfSwaX)){				
							$edUpLinkSwaX = ''; //$CxShelfSwaX.'/'.$CxSlotSwaX.'/0';
						}else{
							$edUpLinkSwaX = '';
						}	
					}

					// faz a leitura dos Checks executados(Config SWA, Cad.ERB, Certificacao de Ips, Config BBone)
					$CheckTaBackBoneX = $ObjTickets->LoadBackbone($CxTicketX);


					// Tunnel - formate
					$CxIntDestinoX = $CxInterfaceX;
					$CxIntOrigemX = $CxInterfaceX;	
					if(empty($edPortDestinoX)){ 
						$edPortDestinoX =  $edPortX;  
						$edPortDestinoX = str_replace("28", "24", $edPortDestinoX);  
						$edPortDestinoX = str_replace("29", "25", $edPortDestinoX);  
						$edPortDestinoX = str_replace("30", "26", $edPortDestinoX);  
					}	// Tunnel
					
					// PreFormata PwId
					if( (empty($CxPwIdX))||((int)$CxPwIdX < 10000)){ $CxPwIdX = '41'.$edsVlanX; }	// Tunnel

					// Formata Nome Neighbor
					$NomeNeighbor = str_replace("swa", "hl5g", $edSwaX);  
					$edNomeNeighborX = str_replace("m-br-", "i-br-", $NomeNeighbor); 
					

					$lstTickects = $ObjTickets->QueryTickets(0, _ANALISANDO, 'Script'); // Consulta Tickets abertos, Analisando
					$lstTktEncerrados = $ObjTickets->QueryTickets(0, _ENCERRADOS, 'Script'); // Consulta Tickets abertos, Analisando
				
					
					$Port = $CxInterfaceX.$edPortX; // Junta tipo com Numero da porta
					$IntPortOrigemX =  $CxIntOrigemX.$edPortOrigemX; 
					$IntPortDestinoX =  $CxIntDestinoX.$edPortDestinoX;
					if($CxRouterX == 'Cisco'){
						// Nao usa mais -> $ObjScript->CheckCamposBBone($CxModeloX, $edIDX, $edEmpresaX, $edRaX, $Port, $edSpeedX, $edPolicyINX, $edPolicyOUTX, $edsVlanX, $edcVlanX,  $edLANX, $edWANX, $edLoopBackX, $edLAN6X, $edWAN6X);
					
						// $CxInterfaceX = 'TenGigE'; // So visual, nao altera script
						$MyScript = $ObjScript->Cisco($CxModeloX, $edIDX, $edEmpresaX, $CxOperadoraX, $Port, $edSpeedX, $edPolicyINX, $edPolicyOUTX, $edVrfX, $edsVlanX, $edcVlanX, $edLANX, $edWANX, $CxWanFxX, $edLoopBackX, $edLAN6X, $edWAN6X, $TaRotasIntragovX, $CxTipoX);  
						
						$MyScriptTunnel = $ObjScript->TunnelCisco($CxModeloX, $edRaX, $IntPortOrigemX, $IntPortDestinoX, $edsVlanX, $CxPwIdX, $edNomeNeighborX, $edIpNeighborX, $CxTipoX);  
						
					}else if($CxRouterX == 'Huawei'){
						// Nao usa mais ->  $ObjScript->CheckCamposBBone($CxModeloX, $edIDX, $edEmpresaX, $edRaX, $Port, $edSpeedX, $edPolicyINX, $edPolicyOUTX, $edsVlanX, $edcVlanX,  $edLANX, $edWANX, $edLoopBackX, $edLAN6X, $edWAN6X);
					
						// $CxInterfaceX = 'GigabitEthernet'; // So visual, nao altera script
						$MyScript = $ObjScript->Huawei($CxModeloX, $edIDX, $edEmpresaX, $CxOperadoraX, $Port, $edSpeedX, $edCtrlVidUnitX, $edPolicyINX, $edPolicyOUTX,  $edsVlanX, $edcVlanX, $edLANX, $edWANX, $CxWanFxX, $edLoopBackX, $edLAN6X, $edWAN6X, $CxTipoX);  
					
					}else if($CxRouterX == 'Nokia'){
						/*
						if(str_contains($CxInterfaceX,'lag')){ 
							$Port = $CxInterfaceX.$edPortX;  // Nokia usa descricao da porta tipo lag-
						}else{
							$CxInterfaceX = ''; // Nokia nao usa descricao da porta
							$Port = $edPortX;
						} 
						*/
						// Nao usa mais -> $ObjScript->CheckCamposBBone($CxModeloX, $edIDX, $edEmpresaX, $edRaX, $Port, $edSpeedX, $edPolicyINX, $edPolicyOUTX, $edsVlanX, $edcVlanX,  $edLANX, $edWANX, $edLoopBackX, $edLAN6X, $edWAN6X);
					
						
						$MyScript = $ObjScript->Nokia($CxModeloX, $edIDX, $edEmpresaX, $CxOperadoraX, $Port, $edSpeedX, $edPolicyINX, $edPolicyOUTX, $edsVlanX, $edcVlanX, $edLANX, $edWANX, $CxWanFxX, $edLoopBackX, $edLAN6X, $edWAN6X, $CxTipoX, $CxIesNokiaX);  
					
					}else if($CxRouterX == 'Juniper'){	
						// Nao usa mais -> $ObjScript->CheckCamposBBone($CxModeloX, $edIDX, $edEmpresaX, $edRaX, $Port, $edSpeedX, $edPolicyINX, $edPolicyOUTX, $edsVlanX, $edcVlanX,  $edLANX, $edWANX, $edLoopBackX, $edLAN6X, $edWAN6X);
									
						$MyScript = $ObjScript->Juniper($CxModeloX, $edIDX, $edEmpresaX, $CxOperadoraX, $Port, $edSpeedX, $edCtrlVidUnitX, $edPolicyINX, $edPolicyOUTX, $edVrfX, $edsVlanX, $edcVlanX, $edLANX, $edWANX, $CxWanFxX, $edLoopBackX, $edLAN6X, $edWAN6X, $CxTipoX);  
					
					}else if($CxRouterX == 'Datacom'){
	
						// Nao usa mais -> $ObjScript->CheckCamposSwa($CxModeloX, $edIDX, $CxSlotSwaX, $CxPortaSwaX, $edSwtX, $edSwt_ipX, $edgVlanX, $edRaX, $edPortX, $edsVlanX, $edcVlanX);
						
							$MyScript = $ObjScript->Datacom($CxModeloX, $edIDX, $edEmpresaX, $edSwaX, $edUpLinkSwaX, $edTipoPtSwaX, $CxShelfSwaX, $CxSlotSwaX, $CxPortaSwaX, $CxPorta2SwaX, $edSwtX, $edSwt_ipX, $edgVlanX, $edRaX, $edPortX, $edsVlanX, $CxSVlan2X, $edcVlanX, $edSpeedX, $CxTipoX, $ProdutoX);  
							
							// Monta carimbo-script(SWA) p/ colar no Star
							$Carimbo = "";
							if(!empty($MyScript[_CtgCARIMBO])){
								for($Cb = 0; $Cb < $MyScript[_CtgCARIMBO]; $Cb++){
									$Carimbo = $Carimbo.$MyScript[_FaixaCARIMBO + $Cb];
									//printf("%s\n", $MyScript[_FaixaCARIMBO + $Cb]); echo"<br>";
								}	
							}
							$Carimbo = $Carimbo.$edIdFlowX;	// Pega banda e Num.processo Efika-Flow
							
							if(isset($_POST['BtCarimboStar'])){	

								// Verifica se TaBackBone esta vazio, ou seja, já NAO foi carimbado...
								if( (!str_contains($CheckTaBackBoneX, 'escription'))
								||  (str_contains($CxTipoX, 'esconfig')))	{
								
									if(!$ObjTickets->Carimbar($TicketEmUso[0][_REG], $Carimbo)){
										$objFuncao->Mensagem('Atencao!', 'Nao foi possivel Alterar registro, o mesmo ja foi finalizado', Null, Null, defAviso, defAtencao);
									}else{
										$ObjPrefere->SaveConfig(_BOTOES, _LstCmdOn, _TaRIpsOff, _TaBBoneOff, Null, Null, Null, Null );
									}	
								}else{
									echo 'Já contém carimbo!';
								}
								
							}
						
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
<!--------------------- ini msg alerta Toast -------------------------------------------------------------------------->
<!--
	script.php <div id="toastCheckCampos"> 
		-> alert.js: msgCheckCampos"()    		( resourses/js/alert.js e resourses/css/alert.css )
			-> Class.tickets.php
				<script>			
					setTimeout(function(){
						msgCheckCampos"();		// Chama funcao Toast  
					}, 1000);	
				</script>	
--
<div id="toastCheckCampos">
  	<div class="checkicon"> <i class="fas fa-check-square"></i> </div>
	Atenção! Existem campos vazios que necessitam de verificação.
</div>
-->
<!--------------------- fim msg alerta -------------------------------------------------------------------------->


	<table class="TAB_Geral" width="100%" align="center" valign="top">
	<form name="LocalizarTickets" method="post" action="localizar_tickets.php"><!-- Form Localizar, inserido aqui devido espa�os que cria no IE -->
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
						<?Php $ObjFuncao->espaco(5); ?>
						<!-- <a href="<?Php echo"$AttribMenuLinguaLink01";?>" class="fonte_menu_esq">-->
						<?Php if(str_contains($CheckTaBackBoneX, 'swa')){ ?>	
							<input i class="fa fa-search" type="image" src="imagens/icon/checked.ico" title="Tel" style="max-width :20px; max-height:20px;">                                                      
						<?Php }else{ ?>
							<input i class="fa fa-search" type="image" src="imagens/icon/no_checked.ico" title="Tel" style="max-width :20px; max-height:20px;">                                                      
						<?Php } ?>
							<?Php echo"$AttribMenuLingua01";?>
						<!-- </a> -->
					</td>
				</tr>
				<!-- Check Cad.ERB FIb -->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
						<!--<a href="<?Php echo"$AttribMenuLinguaLink02";?>" class="fonte_menu_esq"> -->
						<?Php 
							if(str_contains($CheckTaBackBoneX, 'Ativado')){ 
								$AttribMenuLingua02 = "NetC: Ativado";
							?>								
								<input i class="fa fa-search" type="image" src="imagens/icon/lampada.ico" title="Tel" style="max-width :20px; max-height:20px;">                                                      
							<?Php							
							}else if(str_contains($CheckTaBackBoneX, 'Planej')){ 
								$AttribMenuLingua02 = "NetC: Planejado";
							?>								
								<input i class="fa fa-search" type="image" src="imagens/icon/planejado.ico" title="Tel" style="max-width :20px; max-height:20px;">                                                      
							<?Php
							}else if(str_contains($CheckTaBackBoneX, 'Up')){ 
								$AttribMenuLingua02 = "NetC: Up";
						?>
							<input i class="fa fa-search" type="image" src="imagens/icon/checked.ico" title="Tel" style="max-width :20px; max-height:20px;">                                                      
						<?Php }else{ ?>
							<input i class="fa fa-search" type="image" src="imagens/icon/no_checked.ico" title="Tel" style="max-width :20px; max-height:20px;">                                                      
						<?Php } ?>
						<?Php echo"$AttribMenuLingua02";?>
						<!-- </a> -->
					</td>
				</tr>
				<!-- Check Certificacao de IPs -->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
						<!--<a href="<?Php echo"$AttribMenuLinguaLink03";?>" class="fonte_menu_esq">-->
						<?Php if(str_contains($CheckTaBackBoneX, 'CERTIFICADO')){ ?>	
							<input i class="fa fa-search" type="image" src="imagens/icon/checked.ico" title="Tel" style="max-width :20px; max-height:20px;">                                                      
						<?Php }else{ ?>
							<input i class="fa fa-search" type="image" src="imagens/icon/no_checked.ico" title="Tel" style="max-width :20px; max-height:20px;">                                                      
						<?Php } ?>
					
						<?Php echo"$AttribMenuLingua03";?>
						<!--</a>-->
					</td>
				</tr>
				<!-- Check Config backbone -->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
						<!--<a href="<?Php echo"$AttribMenuLinguaLink04";?>" class="fonte_menu_esq">-->
						<?Php if(str_contains($CheckTaBackBoneX, 'address')){ ?>	
							<input i class="fa fa-search" type="image" src="imagens/icon/checked.ico" title="Tel" style="max-width :20px; max-height:20px;">                                                      
						<?Php }else{ ?>
							<input i class="fa fa-search" type="image" src="imagens/icon/no_checked.ico" title="Tel" style="max-width :20px; max-height:20px;">                                                      
						<?Php } ?>
					
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
		<!-- INI Linha Menus *favoritos --
		<div id="pop_favorito" class="favorito_skin" onMouseover="clearhide_favorito();highlight_favorito(event,'on')" onMouseout="highlight_favorito(event,'off');dynamichide_fav(event)">		
			<tr align="center"  height="5" valign="top">
			<td width="100%" colspan="1"  align="right"  height="5" valign="top">
				<!-- Menu Favoritos --
				<a onMouseover="show_favorito(event,linkset_fav[0])" onMouseout="delayhide_favorito()" class="fonte_AttribTopo">
					<img border="0" src="imagens/<?Php echo"$ThemeTopoImg00"; ?>" width="12" height="15">					
				</a>
				<a class="fonte_AttribTopo">
					<img border="0" src="imagens/<?Php echo"$ThemeTopoImg01"; ?>" width="12" height="15">			
				</a>
					
				<a href="#" class="fonte_AttribTopo"><?Php echo"$usuario"; ?></a>
				<a href="<?Php echo"$AttribLinkTopo[1]"; ?>" class="fonte_AttribTopo"><?Php echo"$AttribTopo[1]"; ?></a>
				
				<!-- Menu Sistema --
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
		<!--
		<tr align="center"  height="5" valign="top">
			<td width="100%" colspan="1"  align="center"  height="5" valign="top">&nbsp;</td>
		</tr>
		<tr align="center"  height="5" valign="top">
			<td width="100%" colspan="1"  align="center"  height="5" valign="top">&nbsp;</td>
		</tr>
		<tr align="center"  height="5" valign="top">
			<td width="100%" colspan="1"  align="center"  height="5" valign="top">&nbsp;</td>
		</tr> -->
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
			<form name="Script" method="post" action="script.php">				<!-- Editar -->

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
                    <!------------------------------ Inicio Form Script ---------------------------------------->
                    <td width="20%" colspan="1"  align="center"  height="5" valign="top" ><font size='2' color='#008080'>
                        
                        <table class="TAB_ConteudoIntMargem" width="100%" align="center" valign="top"> 					
                    
                            <tr align="left"  height="5" valign="top">
                                <td width="100%" colspan="2"  align="center"  height="5" valign="top" ><font size='2' color='#008080'>
                                <!--------------------------------------------------------------------------------------------------->
                                    <!-- ID -->		
                                    <tr align="left"  height="5" valign="top">
                                        <td width="20%" colspan="1"  align="left"  height="5" valign="top">ID:</td>
                                        <td width="80%" colspan="1"  align="left"  height="5" valign="top">
											<input onclick="CopyToClipBoardX('edID')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar ID" style="max-width :20px; max-height:20px;">
											<?Php if( (int)$edIDX < 1000000){ ?>
												<input type="text" id="edID" name="edID" size="26" value="<?Php echo $edIDX; ?>" style="background: #FFB6C1; color: #000;">
											<?Php 
													$CamposVazios = true;	// Ctrl msg/verificação de campos vazios
												}else{ ?>  
												<input type="text" id="edID" name="edID" size="26" value="<?Php echo $edIDX; ?>" style="background: #90EE90; color: #000;">
											<?Php } ?>
                                        </td>
                                    
                                    </tr>
                                    <!-- Empresa -->		
                                    <tr align="left"  height="5" valign="top">
                                        <td width="20%" colspan="1"  align="left"  height="5" valign="top">Empresa:</td>
                                        <td width="80%" colspan="1"  align="left"  height="5" valign="top">
											<?Php if( empty($edEmpresaX) ){ ?>
												<input type="text" name="edEmpresa" size="23" value="<?Php echo $edEmpresaX; ?>" style="background: #FFB6C1; color: #000;">
											<?Php 
													$CamposVazios = true;	// Ctrl msg/verificação de campos vazios
												}else{ ?>  
												<input type="text" name="edEmpresa" size="23" value="<?Php echo $edEmpresaX; ?>" style="background: #90EE90; color: #000;">
											<?Php } ?>
										<select name="CxLimNome" size="1"  title="Ajustar tamanho do nome da empresa" onChange="this.form.submit();">
											<option><?Php echo $CxLimNomeX; ?></option>														
											<?Php for($L = 1; $L <= 20; $L++){ ?>
											<option><?Php echo $L; ?></option>														
											<?Php } ?>
																											
																											
										</select>
                                        </td>
                                    
                                    </tr>
									<tr align="left"  height="5" valign="top">
										<td width="20%" colspan="1"  align="left"  height="5" valign="top">SWA:</td>
										<td width="80%" colspan="1"  align="left"  height="5" valign="top">
											<input onclick="CopyToClipBoardX('edRepositorioSWA')" i class="fa fa-search" type="image" src="imagens/icon/computer.ico" title="ssh + Nome-SWA" style="max-width :20px; max-height:20px;">
											<input type="text" id="edSwa" name="edSwa" size="26" value="<?Php echo $edSwaX; ?>" >
											<!-- <input onclick="CopyToClipBoardX('edSWA')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-width :20px; max-height:20px;"> -->
										</td>                            
									</tr>	
									
									<!-- Nome-SWT -->		
									<tr align="left"  height="5" valign="top">
                                        <td width="20%" colspan="1"  align="left"  height="5" valign="top">SWT:</td>
                                        <td width="80%" colspan="1"  align="left"  height="5" valign="top">
											<?Php 
												$SwtY = substr($edSwtX, -2);	// Pega ultimos numeros do SWT pra ver se esta numerado corretamente
												
												if( (str_contains($CxRouterX, 'Datac'))&&((int)$SwtY < 1) ){ 													
											?>
												<input type="text" name="edSwt" size="30" value="<?Php echo $edSwtX; ?>" style="background: #FFB6C1; color: #000;">
											<?Php 
													$CamposVazios = true;	// Ctrl msg/verificação de campos vazios
												}else{ ?>    
												<input type="text" name="edSwt" size="30" value="<?Php echo $edSwtX; ?>" style="background: #90EE90; color: #000;">
											<?Php } ?>
										</td>                                    
                                    </tr>
									<!-- Nome-IP-SWT edSwt_ip -->		
									<tr align="left"  height="5" valign="top">
                                        <td width="20%" colspan="1"  align="left"  height="5" valign="top">IP SWT:</td>
                                        <td width="80%" colspan="1"  align="left"  height="5" valign="top">
											<?Php if( (str_contains($CxRouterX, 'Datac'))&&(!str_contains($edSwt_ipX, '.')) ){ ?>
												<input type="text" name="edSwt_ip" size="30" value="<?Php echo $edSwt_ipX; ?>" style="background: #FFB6C1; color: #000;">
											<?Php 
													$CamposVazios = true;	// Ctrl msg/verificação de campos vazios
												}else{ ?>    
												<input type="text" name="edSwt_ip" size="30" value="<?Php echo $edSwt_ipX; ?>" style="background: #90EE90; color: #000;">
											<?Php } ?>
										</td>                                    
                                    </tr>
									<!-- UpLink SWA(Coriant) -->
									<?Php if(str_contains($edEddX, 'Corian')){ ?>												
										<tr align="left"  height="5" valign="top">
											<td width="20%" colspan="1"  align="left"  height="5" valign="top">UpLink(Coriant):</td>
											<td width="80%" colspan="1"  align="left"  height="5" valign="top">
											<?Php if(empty($edUpLinkSwaX)) { ?>
												<input type="text" name="edUpLinkSwa" size="30" value="<?Php echo $edUpLinkSwaX; ?>" style="background: #FFB6C1; color: #000;" placeholder="Ex: 13/1/23">
											<?Php 
														$CamposVazios = true;	// Ctrl msg/verificação de campos vazios
													}else{ ?> 
												<input type="text" name="edUpLinkSwa" size="30" value="<?Php echo $edUpLinkSwaX; ?>" style="background: #90EE90; color: #000;"  placeholder="Ex: 13/1/23">
											<?Php } ?>
											</td>
										</tr>
										<?Php } ?>

										

									<!-- Porta SWA -->		
									<tr align="left"  height="5" valign="top">
                                        <td width="20%" colspan="1"  align="left"  height="5" valign="top">Porta:</td>
                                        <td width="80%" colspan="1"  align="left"  height="5" valign="top">
										
										<input type="text" name="edTipoPtSwa" size="3" value="<?Php echo $edTipoPtSwaX; ?>" style="background: #90EE90; color: #000;">

										<?Php if( (str_contains($CxRouterX, 'Datac'))&&(empty($CxPortaSwaX)) ){ ?>
											
												<?Php 	if( (str_contains($edEddX, '2104'))||(str_contains($edEddX, '400X'))||(str_contains($edEddX, '4100')) ){ // Se NAO for um 2104G... Imprime X/X/X ?> 
													<input type="text" name="edPtSwa" size="10" value="<?Php echo $CxSlotSwaX."/".$CxPortaSwaX; ?>" style="background: #FFB6C1; color: #000;">
												<?Php 	}else{ // Se for um 2104G... IMPRIME X/X ?> 
													<input type="text" name="edPtSwa" size="10" value="<?Php echo $CxShelfSwaX."/".$CxSlotSwaX."/".$CxPortaSwaX; ?>" style="background: #FFB6C1; color: #000;">
											<?Php 		}
													$CamposVazios = true;	// Ctrl msg/verificação de campos vazios
												}else{ ?> 
												<?Php 	if( (str_contains($edEddX, '2104'))||(str_contains($edEddX, '400X'))||(str_contains($edEddX, '4100')) ){ // Se NAO for um 2104G... Imprime X/X/X ?> 
													<input type="text" name="edPtSwa" size="10" value="<?Php echo $CxSlotSwaX."/".$CxPortaSwaX; ?>" style="background: #90EE90; color: #000;">
												<?Php 	}else{ // Se for um 2104G...Imprime X/X ?> 
													<input type="text" name="edPtSwa" size="10" value="<?Php echo $CxShelfSwaX."/".$CxSlotSwaX."/".$CxPortaSwaX; ?>" style="background: #90EE90; color: #000;">
   												<?Php 	}	
												
												} ?>

										<select name="CxPorta2Swa" size="1" title="2º Porta a Usar em lag´s">
											<option><?Php echo $CxPorta2SwaX; ?></option>										
											<?Php for($p=1; $p<49; $p++){ ?>																				
											<option><?Php  echo $p; ?></option>
											<?Php  }?>	
										</select>
                                        </td>
                                    </tr>
									<!-- gVlan -->		
									<tr align="left"  height="5" valign="top">
                                        <td width="20%" colspan="1"  align="left"  height="5" valign="top">gVlan:</td>
                                        <td width="80%" colspan="1"  align="left"  height="5" valign="top">
											<?Php if( (str_contains($CxRouterX, 'Datac'))&&((int)$edgVlanX < 3) ){ ?>
												<input type="text" name="edgVlan" size="30" value="<?Php echo $edgVlanX; ?>" style="background: #FFB6C1; color: #000;">
											<?Php 
													$CamposVazios = true;	// Ctrl msg/verificação de campos vazios
												}else{ ?>    
												<input type="text" name="edgVlan" size="30" value="<?Php echo $edgVlanX; ?>" style="background: #90EE90; color: #000;">
											<?Php } ?>
										</td>
                                    
                                    </tr>
                                    <!-- sVlan -->		
                                    <tr align="left"  height="5" valign="top">
                                        <td width="20%" colspan="1"  align="left"  height="5" valign="top">sVlan:</td>
                                        <td width="80%" colspan="1"  align="left"  height="5" valign="top">
											<?Php if( (str_contains($CxRouterX, 'Datac'))&&((int)$edsVlanX < 1000) ){ ?>
												<input type="text" name="edsVlan" size="10" value="<?Php echo $edsVlanX; ?>" style="background: #FFB6C1; color: #000;">
											<?Php 
													$CamposVazios = true;	// Ctrl msg/verificação de campos vazios
												}else{ ?>  
												<input type="text" name="edsVlan" size="10" value="<?Php echo $edsVlanX; ?>" style="background: #90EE90; color: #000;">
  											<?Php } 
												// Usado para ajustar(VPN ou IPD) no scrip: libreracao de porta em lag´s 
												$sVlanAnt = (int)$edsVlanX - 1; // sVlan VPN-1 = IPD(impar)
												$sVlanPos = (int)$edsVlanX + 1; // sVlan IPD+1 = VPN(par)
											?>
											<select name="CxSVlan2" size="1" title="2º sVlan a liberar vinculos da porta em lag´s"> 
												<option><?Php echo $CxSVlan2X; ?></option>									
												<option><?Php  echo $sVlanAnt; ?></option>
												<option><?Php  echo $sVlanPos; ?></option>												
										</select>
                                        </td>
                                    
                                    </tr>
                                    <!-- cVlan -->		
                                    <tr align="left"  height="5" valign="top">
                                        <td width="20%" colspan="1"  align="left"  height="5" valign="top">cVlan:</td>
                                        <td width="80%" colspan="1"  align="left"  height="5" valign="top">
											<?Php if( (str_contains($CxRouterX, 'Datac'))&&((int)$edcVlanX < 100) ){ ?>
												<input type="text" name="edcVlan" size="30" value="<?Php echo $edcVlanX; ?>" style="background: #FFB6C1; color: #000;">
											<?Php 
													$CamposVazios = true;	// Ctrl msg/verificação de campos vazios
												}else{ ?>  
												<input type="text" name="edcVlan" size="30" value="<?Php echo $edcVlanX; ?>" style="background: #90EE90; color: #000;">
  											<?Php } ?>
                                        </td>
                                    
                                    </tr>
                                   

                                    <!-- RA -->		
									<tr align="left"  height="5" valign="top">
										<td width="20%" colspan="1"  align="left"  height="5" valign="top">RA:</td>
										<td width="80%" colspan="1"  align="left"  height="5" valign="top">
											<input onclick="CopyToClipBoardX('edRepositorioRA')" i class="fa fa-search" type="image" src="imagens/icon/computer.ico" title="ssh + Nome-RA" style="max-width :20px; max-height:20px;">
											<input type="text" id="edRA" name="edRA" size="26" value="<?Php echo $edRaX; ?>" >
										</td>                            
									</tr>
                                    <!-- Port -->		
                                    <tr align="left"  height="5" valign="top">
                                        <td width="20%" colspan="1"  align="left"  height="5" valign="top">Port:</td>
                                        <td width="80%" colspan="1"  align="left"  height="5" valign="top">
										<?Php if( (!str_contains($CxRouterX, 'Datac'))&&(!str_contains($CxRouterX, 'Nokia'))&&(empty($CxInterfaceX)) ){ ?>
												<select name="CxInterface" size="1" style="background: #FFB6C1; color: #000;">
												<?Php 
														$CamposVazios = true;	// Ctrl msg/verificação de campos vazios
												}else{ ?>  
												<select name="CxInterface" size="1" style="background: #90EE90; color: #000;">
  											<?Php } ?>										
											<option><?Php echo $CxInterfaceX; ?></option>														
											<option>GigabitEthernet</option><!-- Huawei -->
											<option>GigaBitEth</option><!-- Cisco -->
											<option>PW-Ether</option><!-- Cisco -->
											<option>TenGigE</option><!-- Cisco -->	
											<option>Nokia</option><!-- Nokia -->																	
																											
										</select>
											<?Php if( (!str_contains($CxRouterX, 'Datac'))&&(!str_contains($edPortX, '/'))&&((int)$edPortX < 1) ){ ?>
												<input type="text" name="edPort" size="12" value="<?Php echo $edPortX; ?>" style="background: #FFB6C1; color: #000;">
											<?Php 
													$CamposVazios = true;	// Ctrl msg/verificação de campos vazios
												}else{ ?>  
												<input type="text" name="edPort" size="12" value="<?Php echo $edPortX; ?>" style="background: #90EE90; color: #000;">
  											<?Php } ?>
                                        </td>
                                    
                                    </tr>
                                    
                                    <!-- PolicyIN -->
									<?Php if($CxRouterX == 'Cisco' || $CxRouterX == 'Huawei' || $CxRouterX == 'Juniper' ){  ?>		
                                    <tr align="left"  height="5" valign="top">
                                        <td width="20%" colspan="1"  align="left"  height="5" valign="top">Policy-IN:</td>
                                        <td width="80%" colspan="1"  align="left"  height="5" valign="top">                                    	
											<?Php if( (!str_contains($CxRouterX, 'Datac'))&&(empty($edPolicyINX)) ){ ?>
												<input type="text" name="edPolicyIN" size="30" value="<?Php echo $edPolicyINX; ?>" style="background: #FFB6C1; color: #000;">
											<?Php 
													$CamposVazios = true;	// Ctrl msg/verificação de campos vazios
												}else{ ?>  
												<input type="text" name="edPolicyIN" size="30" value="<?Php echo $edPolicyINX; ?>"  style="background: #90EE90; color: #000;">
  											<?Php } ?>
                                        </td>
                                    
                                    </tr>
                                    <!-- PolicyOUT -->		
                                    <tr align="left"  height="5" valign="top">
                                        <td width="20%" colspan="1"  align="left"  height="5" valign="top">Policy-OUT:</td>
                                        <td width="80%" colspan="1"  align="left"  height="5" valign="top">                                    	
											<?Php if( (!str_contains($CxRouterX, 'Datac'))&&(empty($edPolicyOUTX)) ){ ?>
												<input type="text" name="edPolicyOUT" size="30" value="<?Php echo $edPolicyOUTX; ?>" style="background: #FFB6C1; color: #000;">
											<?Php 
													$CamposVazios = true;	// Ctrl msg/verificação de campos vazios
												}else{ ?>  
												<input type="text" name="edPolicyOUT" size="30" value="<?Php echo $edPolicyOUTX; ?>" style="background: #90EE90; color: #000;">
											<?Php } ?>
                                        </td>
                                    
                                    </tr>

                                    <!-- CtrlVid_unit -->		
                                    <?Php if($CxRouterX == 'Huawei' || $CxRouterX == 'Juniper'){  ?>
									<tr align="left"  height="5" valign="top">
                                        <td width="20%" colspan="1"  align="left"  height="5" valign="top">Ctrl-vid:</td>
                                        <td width="80%" colspan="1"  align="left"  height="5" valign="top">
											<?Php if( (!str_contains($CxRouterX, 'Datac'))&&((int)$edCtrlVidUnitX < 100) ){ ?>
												<input type="text" name="edCtrlVidUnit" size="30" value="<?Php echo $edCtrlVidUnitX; ?>" style="background: #FFB6C1; color: #000;">
											<?Php 
													$CamposVazios = true;	// Ctrl msg/verificação de campos vazios												
												}else{ ?>  
												<input type="text" name="edCtrlVidUnit" size="30" value="<?Php echo $edCtrlVidUnitX; ?>" style="background: #90EE90; color: #000;">
  											<?Php } ?>
                                        </td>                                    
                                    </tr>
									<?Php 
											} //if($CxRouterX == 'Huawei'){
										} // if($CxRouterX == 'Cisco' ||$CxRouterX == 'Huawei' )
									?>
									 <!-- Speed --	
									 <?Php if($CxRouterX == 'Juniper'){  ?>
									<tr align="left"  height="5" valign="top">
                                        <td width="20%" colspan="1"  align="left"  height="5" valign="top">Speed:</td>
                                        <td width="80%" colspan="1"  align="left"  height="5" valign="top">
                                            <input type="text" name="edSpeed" size="30" value="<?Php echo $edSpeedX; ?>" >
                                        </td>                                    
                                    </tr>
									<tr align="left"  height="5" valign="top">
                                        <td width="20%" colspan="1"  align="left"  height="5" valign="top">Unit:</td>
                                        <td width="80%" colspan="1"  align="left"  height="5" valign="top">
                                            <input type="text" name="edUnit" size="30" value="<?Php echo $edUnitX; ?>" >
                                        </td>                                    
                                    </tr>
									<?Php 
										} //if($CxRouterX == 'Juniper')										
									?>-->
                                    <!-- LAN -->		
                                    <tr align="left"  height="5" valign="top">
                                        <td width="20%" colspan="1"  align="left"  height="5" valign="top">LAN(0):</td>
                                        <td width="80%" colspan="1"  align="left"  height="5" valign="top">
											<?Php if( (!str_contains($CxRouterX, 'Datac'))&&(!str_contains($edLANX, '.')) ){ ?>
												<input type="text" name="edLAN" size="30" value="<?Php echo $edLANX; ?>" style="background: #FFB6C1; color: #000;">
												
	
											<?Php 
													$CamposVazios = true;	// Ctrl msg/verificação de campos vazios
												}else{ 
											?>  
												<input type="text" name="edLAN" size="30" value="<?Php echo $edLANX; ?>" style="background: #90EE90; color: #000;">
											<?Php } ?>
                                        </td>
                                    
                                    </tr>
                                    <!-- WAN -->		
                                    <tr align="left"  height="5" valign="top">
                                        <td width="20%" colspan="1"  align="left"  height="5" valign="top">WAN(0):</td>
                                        <td width="80%" colspan="1"  align="left"  height="5" valign="top">
											<?Php 
												if( (!str_contains($CxRouterX, 'Datac'))&&(!str_contains($edWANX, '.')) ){ ?>
												<input type="text" name="edWAN" size="30" value="<?Php echo $edWANX; ?>" style="background: #FFB6C1; color: #000;">
											<?Php 
												}else if( (str_contains($edWANX, '201.60'))||(str_contains($edWANX, '201.61')) ){ ?>
													<input type="text" name="edWAN" size="30" value="<?Php echo $edWANX; ?>" style="background: #FF6347; color: #000;">
											<?Php 
													$CamposVazios = true;	// Ctrl msg/verificação de campos vazios
												}else{ ?>  
												<input type="text" name="edWAN" size="30" value="<?Php echo $edWANX; ?>" style="background: #90EE90; color: #000;">
											<?Php } ?>
                                        </td>
                                    
                                    </tr>
                                    <!-- LoopBack -->		
                                    <tr align="left"  height="5" valign="top">
                                        <td width="20%" colspan="1"  align="left"  height="5" valign="top">LoopBack:</td>
                                        <td width="80%" colspan="1"  align="left"  height="5" valign="top">
											<?Php if( (!str_contains($CxRouterX, 'Datac'))&&(!str_contains($edLoopBackX, '.')) ){ ?>
												<input type="text" name="edLoopBack" size="30" value="<?Php echo $edLoopBackX; ?>" style="background: #FFB6C1; color: #000;">
											<?Php
													$CamposVazios = true;	// Ctrl msg/verificação de campos vazios
												}else{ ?>  
												<input type="text" name="edLoopBack" size="30" value="<?Php echo $edLoopBackX; ?>" style="background: #90EE90; color: #000;">
											<?Php } ?>
                                        </td>
                                    
                                    </tr>
                                    <!-- LAN6 -->		
                                    <tr align="left"  height="5" valign="top">
                                        <td width="20%" colspan="1"  align="left"  height="5" valign="top">LAN(ipv6):</td>
                                        <td width="80%" colspan="1"  align="left"  height="5" valign="top">
											<?Php if( (!str_contains($CxRouterX, 'Datac'))&&(!str_contains($edLAN6X, ':')) ){ ?>
												<input type="text" name="edLAN6" size="30" value="<?Php echo $edLAN6X; ?>" style="background: #FFB6C1; color: #000;">
											<?Php 
													$CamposVazios = true;	// Ctrl msg/verificação de campos vazios
												}else{ ?>  
												<input type="text" name="edLAN6" size="30" value="<?Php echo $edLAN6X; ?>" style="background: #90EE90; color: #000;">
											<?Php } ?>
                                        </td>
                                    
                                    </tr>
                                    <!-- WAN6 -->		
                                    <tr align="left"  height="5" valign="top">
                                        <td width="20%" colspan="1"  align="left"  height="5" valign="top">WAN(ipv6):</td>
                                        <td width="80%" colspan="1"  align="left"  height="5" valign="top">
											<?Php if( (!str_contains($CxRouterX, 'Datac'))&&(!str_contains($edWAN6X, ':')) ){ ?>
												<input type="text" name="edWAN6" size="30" value="<?Php echo $edWAN6X; ?>" style="background: #FFB6C1; color: #000;">
											<?Php 
													$CamposVazios = true;	// Ctrl msg/verificação de campos vazios
												}else{ ?>  
												<input type="text" name="edWAN6" size="30" value="<?Php echo $edWAN6X; ?>" style="background: #90EE90; color: #000;">
											<?Php } ?>
                                        </td>
                                    
                                    </tr>   
                                <!--------------------------------------------------------------------------------------------------->   
                                </td>
                            </tr>        
                    
                        </table>
                		
                    </td>
                    <!------------------------------ Inicio Text-area Script ---------------------------------------->
	
                    <td width="80%" colspan="1"  align="left"  height="5" valign="top" ><font size='2' color='#ff0000'>
                        
                        <table class="TAB_ConteudoIntMargem" width=90% align="center" valign="top"> 					
                    
                            <tr align="left"  height="5" valign="top">
								
                                <td width="5%" colspan="1"  align="left"  height="5" valign="middle" ><font size='2' color='#ff0000'>
                                	<input onclick="CopyToClipBoardX('TaScript')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar script" style="max-width :20px; max-height:20px;">
								</td>
								<td width="95%" colspan="1"  align="left"  height="5" valign="top" ><font size='2' color='#ff0000'>
                               		
								<TEXTAREA ID="TaScript" COLS="130" ROWS="18" style="overflow: visible; font-size: 9pt; " ONKEYDOWN="expandTextArea(this, event);"> 
                                        <?Php 
											echo"\n";												
											for($t = 0; $t < $MyScript[_CtgLinScript]; $t++){
												if(!empty($MyScript[$t])){
													echo $MyScript[$t];	echo"\n";
												}	
											}	
                                        ?>
                                    </TEXTAREA>  									
                                    <TEXTAREA ID="TaPreView" COLS="130" ROWS="7" style="overflow: visible; font-size: 9pt;" ONKEYDOWN="expandTextArea(this, event);"> 
                                        <?Php 
												echo"\n";
												for($p = 0; $p < 5; $p++){
													echo $MyScript[_FaixaPreView + $p];
													echo"\n";
												}
                                        ?>
                                    </TEXTAREA>  									
									<?Php 
										if( str_contains($CxTipoX, 'Desconfig')){ $corFundoTipo = '#CD5C5C';  }//'#FF6347'; }	
										else if( str_contains($CxTipoX, 'Migra')){	$corFundoTipo = '#00FF00'; } //'#32CD32'; 
										else{ $corFundoTipo = '#00BFFF'; }	
									?>
									<select name="CxTipo" size="1" title="CxTipo" style="font-size: 8pt; background: <?Php echo $corFundoTipo; ?>; color: #000;"><!-- onChange="this.form.submit();">-->
										<option><?Php echo $CxTipoX; ?></option>														
										<option value="Config">Config</option>
										<option value="Migracao">Migracao</option>	
										<option value="Desconfig">Desconfig</option>
									</select>
									<select name="CxRouter" size="1" onChange="this.form.submit();">
										<option><?Php echo $CxRouterX; ?></option>														
										<option>Cisco</option>
										<option>Datacom</option>							
										<option>Huawei</option>
										<option>Juniper</option>
										<option>Nokia</option>							
									</select>
									<select name="CxModelo" size="1" onChange="this.form.submit();">
										<option><?Php echo $CxModeloX; ?></option>
										<?Php if($CxRouterX == 'Cisco'){ ?>														
											<option>ASR9K</option>													
											<option>IOS_XR</option>													
											<option>INTRAGOV_ASR9K</option>													
											<option>INTRAGOV_IOS-XE</option>													
											<option>VRF_ASR9K</option>													
											<option>VRF_IOS-XE</option>													
										<?Php }else if($CxRouterX == 'Datacom'){ ?>														
											<option>2104G2</option>													
											<option>DM400X</option>							
											<option>DM4050</option>													
											<option>DM4100</option>													
										<?Php }else if($CxRouterX == 'Juniper'){ ?>
											<option>MX480</option>											
										<?Php }else if($CxRouterX == 'Huawei'){ ?>
											<option>NE40E_X8</option>
											<option>NE40E_X8A</option>
										<?Php }else if($CxRouterX == 'Nokia'){ ?>
											<option>SR7750_Plcy</option><!-- Mar2025 -->	
											<option>SR7750_PlcyApk1</option><!-- Scripts que usei -->	
											<option>SR7750_Plcy_RB</option><!-- ASbr2025 -->	
											<option>SR7750_Plcy_ESAT</option><!-- ASbr2025 -->	
											<option>SR7750_QoS</option>											
											<option>SR7750</option>											
																					
										<?Php } ?>
									</select>
									<?php if(str_contains($CxRouterX, 'Nokia')){?>
										<select name="CxIesNokia" size="1" onChange="this.form.submit();">
											<option><?Php echo $CxIesNokiaX; ?></option>														
											<option>ID</option>
											<option>scVlan</option>
										</select>	
									<?Php } ?>
                                </td>
                            </tr>        
                    
                        </table>
                		
                    </td>
                    <!------------------------------ Fim Form/TextArea Script ---------------------------------------->
                </tr> 
                
                </table> <!-- Tabela Script ----> 
               
            
                </table>
				<tr align="left"  height="5" valign="top">
					<td width="5%" colspan="1"  align="left"  height="5" valign="top">
						<input onclick="CopyToClipBoardX('edSn_Vv')" i class="fa fa-search" type="image" src="imagens/icon/Caixabase.ico" title="Vivo" style="max-width :20px; max-height:20px;">                          
					</td>
					<td width="95%" colspan="1"  align="left"  height="5" valign="top">
						<input i class="fa fa-search" type="image" src="imagens/icon/bussola.ico" title="Consulta Ticket" style="max-width :20px; max-height:20px;">									
						<select name="CxTicket" size="1" onChange="this.form.submit();">							
											<option style="background: #0000FF; color: #fff;">
												<?Php echo $CxTicketX; ?>
											</option>												
											<!-- Analisando -->										
											<?Php 
												for($i = 0; $i < $lstTickects[_CtgVETOR][_CtgVETOR]; $i++){ 
													if($lstTickects[$i][_Data] ==''){ $DataY = Date('d/m'); }
													else{ $DataY = $lstTickects[$i][_Data]; }
													if( str_contains($lstTickects[$i][_Tipo], 'Desconf') ){ // Muda cor se for Pendencia
														?><option style="background: #CD5C5C; color: #fff;"><?Php
													}else if( str_contains($lstTickects[$i][_Tipo], 'Migra') ){ // Muda cor se for Pendencia
														?><option style="background: #00FF00; color: #fff;"><?Php
													}else if( str_contains($lstTickects[$i][_Status], 'Pende') ){ // Muda cor se for Pendencia
														?><option style="background: #F08080; color: #fff;"><?Php
													}else{
															?><option style="background: #00BFFF; color: #fff;"><?Php
													}		
													/*	
													if( str_contains($lstTickects[$i][_Status], 'Pende') ){ // Muda cor se for Pendencia
														?><option style="background: #F08080; color: #fff;"><?Php
													}else{
															?><option style="background: #00BFFF; color: #fff;"><?Php
													}	*/											 
											?>		
													
													<?Php printf("[%s] %s, %s - (%s-%s)",$lstTickects[$i][_REG], 
																					$lstTickects[$i][_ID], 
																					substr($lstTickects[$i][_Empresa],0,10),
																					substr($lstTickects[$i][_Status],0,3), 
																					$DataY); ?>
												</option>
											<?Php } ?>
												<!-- Tickts Encerrados -->
												<?Php  $Tot = $lstTktEncerrados[_CtgVETOR][_CtgVETOR];
												if($Tot >= _TotENCERRADOS){ $Tot = _TotENCERRADOS; } // Limita a X registros anteriores
												for($e = 0; $e < $Tot; $e++){ ?>													
													<!-- <option style="background-image: url('imagens/icon/edit.ico');"> -->
													<option style="background: #228B22; color: #fff;">
														
														<?Php printf("[%s] %s, %s - (%s, %s-%s)",$lstTktEncerrados[$e][_REG], 
																						$lstTktEncerrados[$e][_ID], 
																						substr($lstTktEncerrados[$e][_Empresa], 0, 10), // Parte do Nome
																						substr($lstTktEncerrados[$e][_Router],0,5), 
																						substr($lstTktEncerrados[$e][_Status], 0,3), 
																						$lstTktEncerrados[$e][_Data]); ?>
													</option>
											<?Php } ?>																	
										</select>
						  								
						<button type="submit" name="BtGerar" value="Gerar" style="width :30px; height:22px; border:none; cursor: pointer;" title="Gerar Script">
							<img src="imagens/icon/maq_cafe.ico"  style="width :120%; height:120%;">
						</button>
						<button type="submit" name="BtCarimboStar" value="Send" style="width :30px; height:22px; border:none; cursor: pointer;" title="Enviar Script para Ta-Backbone">
							<img src="imagens/icon/fixar.ico"  style="width :120%; height:120%;">
						</button>		
						<button type="submit" name="BtLimpar" value="Limpar" style="width :30px; height:22px; border:none; cursor: pointer;" title="Limpar">
							<img src="imagens/icon/change.ico"  style="width :120%; height:120%;">
						</button>	
						
						<button type="button" name="BtSpace" value="Space"></button>

						<button type="button" name="BtCalc_hex" value="Calc" onclick="window.open('https://www.calculator.net/hex-calculator.html', '', 'popup');" style="width :30px; height:22px; border:none; cursor: pointer;" title="Calc.Hex">
							<img src="imagens/icon/calcIp.ico"  style="width :120%; height:120%;">
						</button>	
						<button type="button" name="BtVpnPrimeCisco" value="VpnPrimeCisco" onclick="window.open('http://localhost/rd2r3/pt/ler.php?reg=1423', '', 'popup');" style="width :30px; height:22px; border:none; cursor: pointer;" title="Ver Script Vpn Prime-Cisco">
							<img src="imagens/icon/VpnPrimeCisco.ico"  style="width :120%; height:120%;">
						</button>	
						<button type="button" name="BtVpnDoZero" value="VpnZero" onclick="window.open('http://localhost/rd2r3/pt/ler.php?reg=1409', '', 'popup');" style="width :30px; height:22px; border:none; cursor: pointer;" title="Ver Script Vpn criei do Zero">
							<img src="imagens/icon/VpnDoZero.ico"  style="width :120%; height:120%;">
						</button>	
							
						
					</td>
                    
				</tr>

                <!------------------------------ Fim Script ---------------------------------------->
								
				
				</table>
		
				</td></tr></table>
					
				<BR>
				<?Php if($CamposVazios){ ?>
				<div class="placaFx" id="aviso">	
					<input i class="fa fa-search" type="image" src="imagens/icon/lampada.ico" style="max-width :30px; max-height:30px;">									
					Atenção! Existem campos vazios que necessitam de verificação.
				</div>
				<?Php } ?> 	

		

			
	
				<!----------------------------- Ini-Tabela Script-Tunnel --------------------------------------->	
				<table class="TAB_ConteudoIntMargem" width=100% align="center" valign="top"> 					
				
                    <tr align="left"  height="5" valign="top">
                        <td width="100%" colspan="3"  align="left"  height="5" valign="top" ><font size='2' color='#008080'>
						<div class="placa" id="basica">
							<input i class="fa fa-search" type="image" src="imagens/icon/beach.ico" title="Farol" style="max-width :30px; max-height:30px;">                                                      
							Script-Tunnel:
						</div>                           
                        </td>
                    </tr>			
					<tr align="left"  height="5" valign="top">
                    <td width="20%" colspan="1"  align="left"  height="5" valign="top"> 
                    <!----------------------------- Ini-Tabela Interna Script-Tunnel --------------------------------------->	
					<table class="TAB_ConteudoIntMargem" width="100%" align="center" valign="top"> 					
                    
					<tr align="left"  height="5" valign="top">
						<td width="100%" colspan="2"  align="center"  height="5" valign="top" ><font size='2' color='#008080'>
						<!--------------------------------------------------------------------------------------------------->
							<!-- RA -->		
							<tr align="left"  height="5" valign="top">
								<td width="20%" colspan="1"  align="left"  height="5" valign="top">RA:</td>
								<td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<input onclick="CopyToClipBoardX('edRepositorioRA')" i class="fa fa-search" type="image" src="imagens/icon/computer.ico" title="ssh + Nome-RA" style="max-width :20px; max-height:20px;">
									<input type="text" id="edRA" name="edRA" size="26" value="<?Php echo $edRaX; ?>" >
								</td>                            
							</tr>
							<!-- Port(ORIGEM) -->		
							<tr align="left"  height="5" valign="top">
								<td width="20%" colspan="1"  align="left"  height="5" valign="top">DE:</td>
								<td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<select name="CxIntOrigem" size="1" style="background: #FFB6C1; color: #000;">
										<option><?Php echo $CxIntOrigemX; ?></option>														
										<option>GigabitEthernet</option><!-- Huawei -->
										<option>GigaBitEth</option><!-- Cisco -->
										<option>PW-Ether</option><!-- Cisco -->
										<option>TenGigE</option><!-- Cisco -->	
										<option>Nokia</option><!-- Nokia -->							
									</select>
									<input type="text" name="edPortOrigem" size="12" value="<?Php echo $edPortOrigemX; ?>" style="background: #FFB6C1; color: #000;">
								</td>
							
							</tr>
							<!-- PORTA DESTINO -->
							<tr align="left"  height="5" valign="top">
								<td width="20%" colspan="1"  align="left"  height="5" valign="top">PARA:</td>
								<td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<select name="CxIntDestino" size="1" style="background: #FFB6C1; color: #000;">
										<option><?Php echo $CxIntDestinoX; ?></option>														
										<option>GigabitEthernet</option><!--  -->
										<option>GigaBitEth</option><!--  -->
										<option>PW-Ether</option><!--  -->
										<option>TenGigE</option><!--  -->	
									</select>
									<input type="text" name="edPortDestino" size="12" value="<?Php echo $edPortDestinoX; ?>" style="background: #FFB6C1; color: #000;">
								</td>
							
							</tr>							

							<!-- sVlan -->		
							<tr align="left"  height="5" valign="top">
								<td width="20%" colspan="1"  align="left"  height="5" valign="top">sVlan:</td>
								<td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<?Php if( (str_contains($CxRouterX, 'Datac'))&&((int)$edsVlanX < 1000) ){ ?>
										<input type="text" name="edsVlan" size="30" value="<?Php echo $edsVlanX; ?>" style="background: #FFB6C1; color: #000;">
									<?Php 
											$CamposVazios = true;	// Ctrl msg/verificação de campos vazios
										}else{ ?>  
										<input type="text" name="edsVlan" size="30" value="<?Php echo $edsVlanX; ?>" style="background: #90EE90; color: #000;">
									  <?Php } ?>
								</td>							
							</tr>
							<!-- PW-ID(MPLS) -->
							<tr align="left"  height="5" valign="top">
								<td width="20%" colspan="1"  align="left"  height="5" valign="top">PW-ID:</td>
								<td width="80%" colspan="1"  align="left"  height="5" valign="top">
								<select name="CxPwId" size="1" style="background: #90EE90; color: #000;">									  										
									<option><?Php echo $CxPwIdX; ?></option>														
									<option>41<?Php echo $edsVlanX; ?></option>
									<option>42<?Php echo $edsVlanX; ?></option>
									<option>43<?Php echo $edsVlanX; ?></option>
								</select>
								</td>
							</tr>							

							<!-- Nome-NEIGHBOR -->		
							<tr align="left"  height="5" valign="top">
								<td width="20%" colspan="1"  align="left"  height="5" valign="top">Nome:</td>
								<td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<input type="text" name="edNomeNeighbor" size="30" value="<?Php echo $edNomeNeighborX; ?>" style="background: #FFB6C1; color: #000;">
								</td>
							
							</tr>
							<!-- ipv4-NEIGHBOR -->		
							<tr align="left"  height="5" valign="top">
								<td width="20%" colspan="1"  align="left"  height="5" valign="top">IP:</td>
								<td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<input type="text" name="edIpNeighbor" size="30" value="<?Php echo $edIpNeighborX; ?>" style="background: #FFB6C1; color: #000;">
								</td>
							
							</tr>
							
							   
						<!--------------------------------------------------------------------------------------------------->   
						</td>
					</tr>        
			
				</table>
				
			</td>
			<!------------------------------ Inicio Text-area Script-TUNNEL(Cisco) ---------------------------------------->
            
			<td width="50%" colspan="1"  align="left"  height="5" valign="top" ><font size='2' color='#ff0000'>
				
				<table class="TAB_ConteudoIntMargem" width=90% align="center" valign="top"> 					
			
					<tr align="left"  height="5" valign="top">
						
						<td width="5%" colspan="1"  align="left"  height="5" valign="middle" ><font size='2' color='#ff0000'>
							<input onclick="CopyToClipBoardX('TaScript')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar script" style="max-width :20px; max-height:20px;">
						</td>
						<td width="95%" colspan="1"  align="left"  height="5" valign="top" ><font size='2' color='#ff0000'>
							   
						<TEXTAREA ID="TaScriptTunnel" COLS="100" ROWS="18" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);"> 
								<?Php 
									echo"\n";												
									for($st = 0; $st < $MyScriptTunnel[_CtgScpTunnel]; $st++){
										if(!empty($MyScriptTunnel[$st])){
											echo $MyScriptTunnel[$st];	echo"\n";
										}	
									}	
								?>
							</TEXTAREA>  									
														
							 
							<select name="CxTunnelTipo" size="1" onChange="this.form.submit();" style="font-size: 8pt; background: #FF6347; color: #000;"><!-- onChange="this.form.submit();">-->
								<option><?Php //echo $CxTunnelTipoX; ?></option>														
								<option value="Config">Config</option>
								<option value="Migracao">Migracao</option>	
								<option value="Desconfig">Desconfig</option>	
								
							</select>
							<select name="CxTunnelRouter" size="1" onChange="this.form.submit();">
								<option><?Php //echo $CxTunnelRouterX; ?></option>														
								<option>Cisco</option>
								<option>Datacom</option>							
								<option>Huawei</option>
								<option>Juniper</option>
								<option>Nokia</option>							
							</select>
							<select name="CxTunnelModelo" size="1" onChange="this.form.submit();">
								<option><?Php //echo $CxTunnelModeloX; ?></option>																			
									<option>ASR9K</option>													
									<option>IOS_XR</option>													
									<option>INTRAGOV_ASR9K</option>													
									<option>INTRAGOV_IOS-XE</option>					
									<option>VRF_ASR9K</option>													
									<option>VRF_IOS-XE</option>					
							</select>
							
						</td>
					</tr>        
			
				</table>
			
					
					
					<!----------------------------- Fim-Tabela Interna Script-Tunnel --------------------------------------->	
    				</td>
					</tr>
				</table>
				<br><br>			

				<!----------------------------- Fim-Tabela Script-Tunnel(Cisco) --------------------------------------->				
				
				
				
				<!----------------------------- Ini-Tabela Script-Tunnel(Hl5g) --------------------------------------->				
				<table class="TAB_ConteudoIntMargem" width=100% align="center" valign="top"> 					
				
				<tr align="left"  height="5" valign="top">
					<td width="100%" colspan="3"  align="left"  height="5" valign="top" ><font size='2' color='#008080'>
					<div class="placa" id="basica">
						<input i class="fa fa-search" type="image" src="imagens/icon/beach.ico" title="Farol" style="max-width :30px; max-height:30px;">                                                      
						Script-Tunnel:
					</div>                           
					</td>
				</tr>			
				<tr align="left"  height="5" valign="top">
				<td width="20%" colspan="1"  align="left"  height="5" valign="top"> 
				<!----------------------------- Ini-Tabela Interna Script-Tunnel --------------------------------------->	
				<table class="TAB_ConteudoIntMargem" width="100%" align="center" valign="top"> 					
				
				<tr align="left"  height="5" valign="top">
					<td width="100%" colspan="2"  align="center"  height="5" valign="top" ><font size='2' color='#008080'>
					<!--------------------------------------------------------------------------------------------------->
						
						<!-- Port(HL5G) -->		
						<tr align="left"  height="5" valign="top">
							<td width="20%" colspan="1"  align="left"  height="5" valign="top">Int(Hl5g):</td>
							<td width="80%" colspan="1"  align="left"  height="5" valign="top">
								<select name="CxIntHl5g" size="1" style="background: #FFB6C1; color: #000;">
									<option><?Php echo $CxIntHl5gX; ?></option>														
									<option>GigabitEthernet</option><!-- Huawei -->
									<option>GigaBitEth</option><!-- Cisco -->
									<option>PW-Ether</option><!-- Cisco -->
									<option>TenGigE</option><!-- Cisco -->	
									<option>Nokia</option><!-- Nokia -->							
								</select>
								<input type="text" name="edPortHl5g" size="12" value="<?Php echo $edPortHl5gX; ?>" style="background: #FFB6C1; color: #000;">
							</td>
						
						</tr>
						
						</tr>
						
						   
					<!--------------------------------------------------------------------------------------------------->   
					</td>
				</tr>        
		
			</table>
			
		</td>
		<!------------------------------ Inicio Text-area Script-TUNNEL(Cisco) ---------------------------------------->
		
		<td width="50%" colspan="1"  align="left"  height="5" valign="top" ><font size='2' color='#ff0000'>
			
			<table class="TAB_ConteudoIntMargem" width=90% align="center" valign="top"> 					
		
				<tr align="left"  height="5" valign="top">
					
					<td width="5%" colspan="1"  align="left"  height="5" valign="middle" ><font size='2' color='#ff0000'>
						<input onclick="CopyToClipBoardX('TaScript')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar script" style="max-width :20px; max-height:20px;">
					</td>
					<td width="95%" colspan="1"  align="left"  height="5" valign="top" ><font size='2' color='#ff0000'>
						   
					<TEXTAREA ID="TaScriptTunnelHl5g" COLS="100" ROWS="18" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);"> 
							<?Php 
								echo"\n";												
								for($st = 0; $st < $MyScriptTunnelHl5g[_CtgScpTunnelHl5g]; $st++){
									if(!empty($MyScriptTunnelHl5g[$st])){
										echo $MyScriptTunnelHl5g[$st];	echo"\n";
									}	
								}	
							?>
						</TEXTAREA>  									
													
						 
						<select name="CxTunnelTipo" size="1" onChange="this.form.submit();" style="font-size: 8pt; background: #FF6347; color: #000;"><!-- onChange="this.form.submit();">-->
							<option><?Php //echo $CxTunnelTipoX; ?></option>														
							<option value="Config">Config</option>
							<option value="Migracao">Migracao</option>	
							<option value="Desconfig">Desconfig</option>	
							
						</select>
						<select name="CxTunnelRouter" size="1" onChange="this.form.submit();">
							<option><?Php //echo $CxTunnelRouterX; ?></option>														
							<option>Cisco</option>
							<option>Datacom</option>							
							<option>Huawei</option>
							<option>Juniper</option>
							<option>Nokia</option>							
						</select>
						<select name="CxTunnelModelo" size="1" onChange="this.form.submit();">
							<option><?Php //echo $CxTunnelModeloX; ?></option>																			
								<option>ASR9K</option>													
								<option>IOS_XR</option>													
								<option>VRF_ASR9K</option>													
								<option>VRF_IOS-XE</option>					
						</select>
						
					</td>
				</tr>        
		
			</table>
		
				
				
				<!----------------------------- Fim-Tabela Interna Script-Tunnel --------------------------------------->	
				</td>
				</tr>
			</table>
			<br><br>			

				<!----------------------------- Fim-Tabela Script-Tunnel(Hl5g) --------------------------------------->				


				<!----------------------------- Checks(INI) ------------------------------------------------>				
									
				<table class="TAB_ConteudoIntMargem" width=90% align="center" valign="top"> 					
				
                    <tr align="left"  height="5" valign="top">
                        <td width="100%" colspan="3"  align="left"  height="5" valign="top" ><font size='2' color='#008080'>
						<div class="placa" id="basica">
							<input i class="fa fa-search" type="image" src="imagens/icon/beach.ico" title="Farol" style="max-width :30px; max-height:30px;">                                                      
							Comandos:
						</div>                           
                        </td>
                    </tr>			
					<tr align="left"  height="5" valign="top">
                    <td width="20%" colspan="1"  align="left"  height="5" valign="top"> 
                        
						<?Php 
						if($MyScript[_FaixaCmdRouters] != ''){
							for($C = 0; $C < $MyScript[_CtgCmdRouters]; $C++){ 
								$objHtml = 'edCmd'.$C; 								?>
								<tr align="left"  height="5" valign="top">	
									<td width="20%" colspan="1"  align="left"  height="5" valign="top">                            
									
									</td>								
									<td width="80%" colspan="2"  align="left"  height="5" valign="top">
										<input onclick="CopyToClipBoardX('<?Php echo $objHtml; ?>')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar comando" style="max-width :20px; max-height:20px;">                          
										<input type="text" id="<?Php echo $objHtml; ?>" name="<?Php echo $objHtml; ?>" size="50" value="<?Php echo $MyScript[_FaixaCmdRouters + $C]; ?>" style="font-weight: normal;"> 
									</td>
								</tr>
						<?Php 
							}
						} 
						?>

					</td>
					</tr>
				</table>
				<br><br>

                <!----------------------------- Configs(INI) ------------------------------------------------>				
			
                		
			
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
				<input type="text" ID="edSn_Vv" name="edSn_Vv" size="1" value="<?Php echo _VV; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
				<input type="text" ID="edRepositorioSWA" name="edRepositorioSWA" size="1" value="<?Php echo "ssh ".$edSwaX; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
				<input type="text" ID="edRepositorioRA" name="edRepositorioRA" size="1" value="<?Php echo "ssh ".$edRaX; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
					
			</td>		
		</tr>
		</table>	

		<?php if($CamposVazios){ ?>
			<script>			
			setTimeout(function(){
				msgCheckCampos();	// Chama funcao Toast em: //  resourses/js/alert.js e resourses/css/alert.css
			}, 1000);	
			</script>	
		<?php } ?>

	</form>
	</div><!-- Rodap� -->


</div><!-- Pagina Geral --> 

<script src="resources/js/funcoes.js"></script><!-- Cria Menu auto filtro Cx-Select: Router->PolicyIN->PolicyOUT -->
<script src="resources/js/alert.js"></script><!-- Cria Menu auto filtro Cx-Select: Router->PolicyIN->PolicyOUT -->
  


</body>

</html>