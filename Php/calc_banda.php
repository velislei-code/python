<?Php
	
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
	
	include_once("Class.preferencias.php");	//include_once: carregue o arquivo se ele j� N�O tenha sido inclu�do
	$ObjPrefere = New Preferencias();
	$loadConfig = $ObjPrefere->LoadConfig();
	 

	

	if(isset($_POST['BtOpenTaBackbone'])){								
		$ObjPrefere->SaveConfig(_LstCmdOff, _TaRIpsOff, _TaBBoneOn); 
		$loadConfig[_TaBBone] = _TaBBoneOn; 					 
	}
	if(isset($_POST['BtOpenReverIps'])){								
		$ObjPrefere->SaveConfig(_LstCmdOff, _TaRIpsOn, _TaBBoneOff); 
		$loadConfig[_TaRIps] = _TaRIpsOn; 					 
	}
	if(isset($_POST['BtCloseTa'])){								
		$ObjPrefere->SaveConfig(_LstCmdOn, _TaRIpsOff, _TaBBoneOff); 
		$loadConfig[_TaRIps] = _TaRIpsOff; 
		$loadConfig[_TaBBone] = _TaBBoneOff; 
	}

				

				// Inicializa vari�veis
				/*if(!empty($_POST['edIdFlow'])){
					$edIdFlowIni = $_POST['edIdFlow'];				
					if(str_contains($edIdFlowIni, '-')){ // Evitar ficar comendo a string, apos ja ter formatado
						$posIniIdFlow = strpos($edIdFlowIni, '-') - 11;
						$edIdFlowX = substr($edIdFlowIni, $posIniIdFlow, 27);
					//$capVel = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($capVel));
					//$capVel = str_replace(' ', '', $capVel);  // tira espacos vazios
					}else{
						$edIdFlowX = $_POST['edIdFlow'];
					}		
				}else{
					$edIdFlowX = '';					
				}	
				*/
				if(!empty($_POST['edIdFlow'])){
					$edIdFlowX = $_POST['edIdFlow'];
				}else{
					$edIdFlowX = '';					
				}	
			
				if($edIdFlowX == ''){ $edIdFlowX = ' Banda: /1G, ';	}	// Auto-Formata inicial

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
				//if($edEmpresaX == ''){ $edEmpresaX ='FUST'; }
				
				if(!empty($_POST['edSpeed'])){
					$edSpeedX = $_POST['edSpeed'];
				}else{					
					$edSpeedX = '';					
				}
				if(!empty($_POST['edRa'])){
					$edRaX = $_POST['edRa'];
				}else{					
					$edRaX = '';					
				}
				if(!empty($_POST['edsVlan'])){
					$edsVlanX = $_POST['edsVlan'];
				}else{					
					$edsVlanX = '';					
				}
				if(!empty($_POST['edPort'])){
					$edPortX = $_POST['edPort'];
				}else{					
					$edPortX = '';					
				}

				
				if(!empty($_POST['TaRascunho'])){
					$TaRascunhoX = $_POST['TaRascunho'];
					
					// Rotina para pegar ID e Nome Cliente do TaRascunho
					$ExplodeTaRas = explode("\n", $TaRascunhoX);	
					$posID = 0;
					$capCliFT = ''; 
					$capCli = ''; 
					foreach($ExplodeTaRas as $LinTaRas){

						if(str_contains($LinTaRas, '.0;')){
                            echo $LinTaRas.'<br>';
                            //$TaBackBoneX = $TaBackBoneX.
							
							
							
							
						}	

						
						// Cliente
						if(str_contains($LinTaRas, 'liente') ){								
							$posCli = strpos($LinTaRas, 'Cliente') + 9;  
							$capCli = substr($LinTaRas, $posCli, 30);
							
						}else if(str_contains($LinTaRas, 'LIENTE') ){	
							$posCli = strpos($LinTaRas, 'CLIENTE') + 9;	
							$capCli = substr($LinTaRas, $posCli, 30);
							
						}						
						if(str_contains($LinTaRas, 'COLA:') ){								
							$capCliFT = 'FUST '.substr($LinTaRas, 9, 30);							
						}
						if($edEmpresaX == ''){
							if($capCliFT != ''){							
								if(str_contains($capCliFT, 'FUST')){ $edEmpresaX = $capCliFT; }
								else{ $edEmpresaX = $capCli;	}	
								echo 'capCli->'.$capCli.'<br>';
								echo 'capCliFT->'.$capCliFT.'<br>';
							}

						} 


						if(str_contains($LinTaRas, 'VELOC') || str_contains($LinTaRas, 'elocid')){

							for($x = 1; $x < 10; $x++){
								if(str_contains($LinTaRas, $x) ){ $posVel = strpos($LinTaRas, $x); }  
							}	
								
							$capVel = substr($LinTaRas, $posVel, 3);
							$capVel = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($capVel));
							$capVel = str_replace(' ', '', $capVel);  // tira espacos vazios
							$capVel = str_replace('M', ' ', $capVel);  // tira espacos vazios
							
							if($edSpeedX ==''){ $edSpeedX = $capVel; }
							 
						}
						// Pegar Vlan de gerencia do recorte
						if(str_contains($LinTaRas, 'interface') && str_contains($LinTaRas, 'vlan') && str_contains($LinTaRas, '3') && !str_contains($LinTaRas, '2')){
							
								$posGVlan = strpos($LinTaRas, '3');  
								$capGVlan = substr($LinTaRas, $posGVlan, 4);
								
								// Transfere para outra var pois $edgVlanX e alterado abaixo...e zpaga valor do recorte
								$edgVlanPegaRecorteX = $capGVlan; }else{$edgVlanPegaRecorteX = ''; 								
								
								
						}
						// Pegar sVlan, RA do recorte
						if(str_contains($LinTaRas, 'name') && str_contains($LinTaRas, 'IPD')){								
							$posRA = strpos($LinTaRas, 'name') + 9;  
							$capRA = 'i-br-'.substr($LinTaRas, $posRA, 17);
							
							$capPort = substr($LinTaRas, $posRA+18, 10);
							if($edRaX == ''){
								$edRaX = $capRA;
								$edPortX = $capPort;									
							}	
						}
						if(str_contains($LinTaRas, 'vlan') && str_contains($LinTaRas, '2')){
						
							$posSVlan = strpos($LinTaRas, 'vlan') + 5;  
							$capSVlan = substr($LinTaRas, $posSVlan, 4);
							if($edsVlanX == ''){
								$edsVlanX = $capSVlan;
							}
						}
						/*
						if(str_contains($LinTaRas, 'name')){
							if(str_contains($LinTaRas, 'IPD')||str_contains($LinTaRas, 'VPN')){
								$posRA = strpos($LinTaRas, 'name') + 9;  
								$capRA = 'i-br-'.substr($LinTaRas, $posRA, 17);
								
								$capPort = substr($LinTaRas, $posRA+18, 10);
								if($edRaX == ''){
									$edRaX = $capRA;
									$edPortX = $capPort;									
								}
							}
						}*/
						
									
					
					}

				
					$TaRascunhoX = str_replace("'", "`", $TaRascunhoX);  // tira ' por causa do MySql Injection

				}else{					
					$TaRascunhoX = '';					
				}	


				if(!empty($_POST['CxProduto'])){
					$CxProdutoX = $_POST['CxProduto'];
				}else{					
					$CxProdutoX = 'IPD';					
				}	
				if(!empty($_POST['CxEDD'])){
					$CxEddX = $_POST['CxEDD'];
				}else{
					$CxEddX ='EDD';
				}
				if(!empty($_POST['CxOperadora'])){
					$CxOperadoraX = $_POST['CxOperadora'];
				}else{
					$CxOperadoraX ='ERB';
				}
				//-----------  swa, vlan_ger, swt, swt_ip -----------------//
				if(!empty($_POST['edgVlan'])){
					$edgVlanXa = $_POST['edgVlan'];
					if($edgVlanXa > 3  && $edgVlanXa < 2999){
						$edgVlanX = $edgVlanXa + 3000;
					}else{
						$edgVlanX = $edgVlanXa;
					}

				}else{
					$edgVlanX ='';
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
					if($edgVlanX == ''){		
						$edgVlanX = substr($edSwaIniX, 39, 5);
						//$edgVlanX = str_replace(' ', '', $edgVlanX);  // tira espacos vazios
						$edgVlanX = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($edgVlanX));
					}
					if($edSwtX == ''){						
						$posFim = strpos($edSwaIniX, '-0') - 1;
						$edSwtX = substr($edSwaIniX, 0, $posFim).'t-00';						
					}
					if($edSwt_ipX == ''){						
						$posIniT = 23;
						$posFimT = $posIniT + 15;
						$edSwt_ipX = substr($edSwaIniX, $posIniT, $posFimT);
						$edSwt_ipX = substr($edSwt_ipX, 0, 15);  // Ajusta para tamanho Padrao
						$edSwt_ipX = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($edSwt_ipX));
					}
				}else{
					$edSwaX ='';
				}	

				
		
				if(!empty($_POST['CxPlacaSwa'])){
					$CxPlacaSwaX = $_POST['CxPlacaSwa'];
				}else{
					$CxPlacaSwaX ='1';
				}
				if(!empty($_POST['CxPortSwa'])){
					$CxPortSwaX = $_POST['CxPortSwa'];
				}else{
					$CxPortSwaX ='Porta';
				}
				//------------RA, Port, Svlan -----------------------------//

				if(!empty($_POST['CxInterface'])){
					$CxInterfaceX = $_POST['CxInterface'];
				}else{					
					$CxInterfaceX = '';					
				}
				if(!empty($_POST['edPort'])){
					$edPortXa = $_POST['edPort'];

					if (str_contains($edPortXa, '-')) {
						$posFim = strpos($edPortXa, '-');
						$edPortXb = substr($edPortXa, 0, $posFim);
					}else{ $edPortXb = $edPortXa; }
					$edPortX = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($edPortXb));
					
				}
				// Vrf
				if(!empty($_POST['edVrf'])){
					$edVrfX = $_POST['edVrf'];					
				}else{					
					$edVrfX = '';					
				}
				if(!empty($_POST['CxVrf'])){
					$CxVrfX = $_POST['CxVrf'];					
				}else{					
					$CxVrfX = '';					
				}
				if(!empty($_POST['CxVrfEmpresa'])){
					$CxVrfEmpresaX = $_POST['CxVrfEmpresa'];					
				}else{					
					$CxVrfEmpresaX = '';					
				}

				if(!empty($_POST['edsVlan'])){
					$edsVlanX = $_POST['edsVlan'];
					$edsVlanX = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($edsVlanX));
					$edsVlanX = str_replace('-', '', $edsVlanX);				
					
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
					$edRaX = str_replace('.', ' ', $edRaX);  // tira espacos vazios	
					// Auto preenche Porta, baseadao em Rede Acesso
					if($edPortX == ''){		
						$posIniP = strpos($edRaIniX, 'svlan') - 9;						
						$edPortX = substr($edRaIniX, $posIniP, 9);
						$edPortX = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($edPortX));
						$edPortX = str_replace('.', ' ', $edPortX);  // tira espacos vazios	
									
					}

					// Auto preenche sVlan, baseadao em Rede Acesso
					if($edsVlanX == ''){						
						$posIniV = strpos($edRaIniX, 'svlan') + 6;
						$posFimV = $posIniV + 3;
						$edsVlanX = substr($edRaIniX, $posIniV, $posFimV);
						$edsVlanX = str_replace(' ', '', $edsVlanX);  // tira espacos vazios
						$edsVlanX = str_replace('.', ' ', $edsVlanX);  // tira espacos vazios
						//$edsVlanX = str_replace('m', '', $edsVlanX);  // tira espacos vazios
					}
				}
				//-----------------------------------------------------//

                
				if(!empty($_POST['CxPolicyIN'])){
					$CxPolicyINX = $_POST['CxPolicyIN'];
					$CxPolicyINX = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($CxPolicyINX));
				}else{
					$CxPolicyINX ='';
				}				
				if(!empty($_POST['CxPolicyOUT'])){
					$CxPolicyOUTX = $_POST['CxPolicyOUT'];
					$CxPolicyOUTX = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($CxPolicyOUTX));
				}else{
					$CxPolicyOUTX ='';
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
							
				if(!empty($_POST['TaReverIps'])){
					$TaReverIpsX = $_POST['TaReverIps'];
					$TaReverIpsX = str_replace("'", "`", $TaReverIpsX);  // tira ' por causa do MySql Injection

				}else{					
					$TaReverIpsX = '';					
				}				
				if(!empty($_POST['TaBackBone'])){
					$TaBackBoneX = $_POST['TaBackBone'];
					$TaBackBoneX = str_replace("'", "`", $TaBackBoneX);  // tira ' por causa do MySql Injection

				}else{					
					$TaBackBoneX = '';					
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
					$CxRouterX = 'Datacom';					
				}	


				if(isset($_POST['BtSalvar'])){					
					// Cria um Ticket vazio
					$Res = $ObjTickets->SalvarTicket($CxTicketX, $edIDX, $edEmpresaX, $CxProdutoX, $edIdFlowX, $edSwaX, $CxEddX, $CxOperadoraX, $edgVlanX, $CxPlacaSwaX, $CxPortSwaX, $edSwtX, $edSwt_ipX, $edRaX, $CxRouterX, $CxInterfaceX, $edPortX, $edSpeedX, $edCtrlVidUnitX, $CxPolicyINX, $CxPolicyOUTX, $edVrfX, $edsVlanX, $edcVlanX, $edLANX, $edWANX, $edLoopBackX, $edLAN6X, $edWAN6X,$CxStatusX, $TaRascunhoX, $TaReverIpsX, $TaBackBoneX, $loadConfig[_TaBBone]);
					
				}
				

				$ResolvidosHoje = $ObjTickets->ContaResolvidos();

				if(isset($_POST['CxTicket']) || isset($_REQUEST['reg'])){

					if(isset($_REQUEST['reg']) ){
						$RegURL = $_REQUEST['reg'];	
						$CxTicketX = '['.$RegURL.']';
						$TicketEmUso = $ObjTickets->QueryTickets($CxTicketX, NUll);									 
					}else if(isset($_POST['CxTicket'])){
						$CxTicketX = $_POST['CxTicket'];
						$TicketEmUso = $ObjTickets->QueryTickets($CxTicketX, NUll);
					}

					$edIDX = $TicketEmUso[0][_ID];
					$edEmpresaX= $TicketEmUso[0][_Empresa]; 
					$CxProdutoX= $TicketEmUso[0][_Produto]; 
					$edIdFlowX= $TicketEmUso[0][_IdFlow]; 
					$edSwaX= $TicketEmUso[0][_SWA]; 
					$edgVlanX= $TicketEmUso[0][_VlanGer]; 
					$CxPlacaSwaX= $TicketEmUso[0][_PlacaSwa]; 
					$CxPortSwaX= $TicketEmUso[0][_PortSwa]; 
					$CxEddX= $TicketEmUso[0][_EDD]; 
					$CxOperadoraX= $TicketEmUso[0][_OPERADORA]; 
					$edSwtX= $TicketEmUso[0][_SWT]; 
					$edSwt_ipX= $TicketEmUso[0][_SWT_IP]; 
					$edRaX= $TicketEmUso[0][_RA]; 
					$CxRouterX= $TicketEmUso[0][_Router]; 
					$CxInterfaceX= $TicketEmUso[0][_Interface]; 
					$edPortX= $TicketEmUso[0][_Porta]; 
					$edSpeedX= $TicketEmUso[0][_Speed]; 
					$edCtrlVidUnitX= $TicketEmUso[0][_VidUnit]; 
					$CxPolicyINX= $TicketEmUso[0][_PolicyIN]; 
					$CxPolicyOUTX= $TicketEmUso[0][_PolicyOUT]; 					 
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
					$TaReverIpsX = $TicketEmUso[0][_ReverIps];
					$TaBackBoneX = $TicketEmUso[0][_Backbone];

					//printf("%s -> ", $TicketEmUso[0][_Interface]);
					//echo "Entrei aki-1"."<br>";
					
				}else{					
					$CxTicketX = 'Selecionar';	
										
				}
					
				// Auto complete Ctrl-vid, Unit
				if($edCtrlVidUnitX == '' && $edcVlanX != ''){
					$edCtrlVidUnitX = '7'.substr($edcVlanX, -2);
				}
				
				$lstTickects = $ObjTickets->QueryTickets(0, _ANALISANDO); // Consulta Tickets abertos, Analisando
				$lstTktNovos = $ObjTickets->QueryTickets(0, _NOVOS); // Consulta Tickets abertos, novos
				$lstTktRevisar = $ObjTickets->QueryTickets(0, _REVISAR); // Consulta Tickets abertos, Analisando
				$lstTktEncerrados = $ObjTickets->QueryTickets(0, _ENCERRADOS); // Consulta Tickets abertos, Analisando
				
				// Auto-Preenche gVlan do Recorte(pego em rotina acima)
				if($edgVlanX == ''){ $edgVlanX = $edgVlanPegaRecorteX; 	}

				if(isset($_POST['BtAdicionar'])){
					// Cria um Ticket vazio-novo
					$MyTickects = $ObjTickets->AddTicket('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
				}

				if(isset($_POST['BtDuplicar'])){
					// Duplicar um registro
					$MyTickects = $ObjTickets->AddTicket('', $edIDX, $edEmpresaX, $CxProdutoX, $edIdFlowX, $edSwaX, $edgVlanX, $CxPlacaSwaX, $CxPortSwaX, $CxEddX, 
					 										$CxOperadoraX, $edSwtX, $edSwt_ipX, $edRaX, $CxRouterX, $CxInterfaceX, $edPortX, $edSpeedX, 
					 										$edCtrlVidUnitX, $CxPolicyINX, $CxPolicyOUTX, $edVrfX, $edsVlanX, $edcVlanX, $edLANX, $edWANX,
					 										$edLoopBackX, $edLAN6X, $edWAN6X, 'Analisando', $TaRascunhoX, $TaReverIpsX, $TaBackBoneX);
				}
				
				if(isset($_POST['BtDuvida'])){
					?>
						<script>
							alert('Recuperar acessos: \n\n 1-NetCompass:\n E.Flow->Artefatos->Reset Netcompass\n Vem Email de Reset.\n *Confirme se o GAUS esta em dia.\n\n 2-E.Flow:\n No proprio E.Flow->Artefatos->Perfil.');
						</script>
					<?Php

				}

				if(isset($_POST['BtLimpar'])){
					echo '<script type="text/javascript">';				
					echo"window.location.href = 'calc_banda.php'";
					echo '</script>';
				}
				if(isset($_POST['BtLiberarID'])){
					
					//$ObjFuncao->Mensagem('Atencao!', 'O formulario foi limpo mas os dados NAO foram salvos.', Null, Null, defAviso, defAtencao);
					
					?>
						<script>
							setTimeout(function(){
								msgFrmApagado();
					  		}, 1000);
						</script>
					<?Php

					$edIDX = "";
					$edEmpresaX= ""; 
					$CxProdutoX= ""; 					
					$edSwaX= ""; 
					$edgVlanX= ""; 
					$CxPlacaSwaX= ""; 
					$CxPortSwaX= ""; 
					$edSwtX= ""; 
					$edSwt_ipX= ""; 
					$edRaX= ""; 
					$CxRouterX= ""; 
					$CxInterfaceX= ""; 
					$edPortX= ""; 
					$edSpeedX= ""; 
					$edCtrlVidUnitX= ""; 
					$CxPolicyINX= ""; 
					$CxPolicyOUTX= ""; 
					$edVrfX= ""; 
					$edsVlanX= ""; 
					$edcVlanX= ""; 
					$edLANX= ""; 
					$edWANX= ""; 
					$edLoopBackX= ""; 
					$edLAN6X= ""; 
					$edWAN6X= "";	
				}

				$InterfacePort = $CxInterfaceX.$edPortX; // Junta tipo com Numero da porta
							
				if($CxRouterX == 'Cisco'){
					// $CxInterfaceX = 'TenGigE'; // So visual, nao altera script
					$MyScript = $ObjScript->Cisco('ASR9K', $edIDX, $edEmpresaX, $CxOperadoraX, $InterfacePort, $edSpeedX, $CxPolicyINX, $CxPolicyOUTX,  $edVrfX, $edsVlanX, $edcVlanX, $edLANX, $edWANX, $edLoopBackX, $edLAN6X, $edWAN6X);  
				}else if($CxRouterX == 'Huawei'){
					// $CxInterfaceX = 'GigabitEthernet'; // So visual, nao altera script
					$MyScript = $ObjScript->Huawei('NE40E_X8A',$edIDX, $edEmpresaX, $CxOperadoraX, $InterfacePort, $edSpeedX, $edCtrlVidUnitX, $CxPolicyINX, $CxPolicyOUTX,  $edsVlanX, $edcVlanX, $edLANX, $edWANX, $edLoopBackX, $edLAN6X, $edWAN6X);  
				
				}else if($CxRouterX == 'Nokia'){
					
					if(str_contains($CxInterfaceX,'lag')){ 
						$InterfacePort = $CxInterfaceX.$edPortX;  // Nokia usa descricao da porta tipo lag-
					}else{
						$CxInterfaceX = ''; // Nokia nao usa descricao da porta
						$InterfacePort = $edPortX;
					} 
					//echo  '>>>>'.$InterfacePort;
					$MyScript = $ObjScript->Nokia('SR7750_QoS', $edIDX, $edEmpresaX, $CxOperadoraX, $InterfacePort, $edSpeedX, $edsVlanX, $edcVlanX, $edLANX, $edWANX, $edLoopBackX, $edLAN6X, $edWAN6X);  
				
				}else if($CxRouterX == 'Juniper'){
									
					$MyScript = $ObjScript->Juniper('MX480', $edIDX, $edEmpresaX, $CxOperadoraX, $InterfacePort, $edSpeedX, $edCtrlVidUnitX, $CxPolicyINX, $CxPolicyOUTX, $edsVlanX, $edcVlanX, $edLANX, $edWANX, $edLoopBackX, $edLAN6X, $edWAN6X);  
				}
				
				$ReverIPs = $ObjScript->cmdReverIPs($edLANX, $edWANX, $edLoopBackX); 
				
				// faz a leitura dos Checks executados(Config SWA, Cad.ERB, Certificacao de Ips, Config BBone)
				$CheckTaBackBoneX = $ObjTickets->LoadBackbone($CxTicketX);

				// Mensagem de aviso Renovacao de Senhas
				
				if(Date("d") == '30'){ ?>
					<script>						
						setTimeout(function(){
							msgRenovarGaus();
						}, 1000);
						alert("Atencao! Renovar acessos no GAUS.\n\n\n https://gaus.vivo.com.br/login\n (lg: 80969577, sn: rede)");
					</script>
				<?Php
					//$ObjFuncao->Mensagem('Atencao!', 'Renovar acessos do GAUS.', Null, Null, defAviso, defAtencao);
				}			

?>

<body BGCOLOR="<?Php echo"$ThemeCorFundoBody"; ?>"><!-- BACKGROUND="PParede/cristal.png" --> 	
<div id="geral"><!-- Pagina Geral -->	

	<table class="TAB_Geral" width="100%" align="center" valign="top">
	<form name="LocalizarTickets" method="post" action="localizar_calc_banda.php"><!-- Form Localizar, inserido aqui devido espa�os que cria no IE -->
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
						<!--<a href="<?Php echo"$AttribMenuLinguaLink00";?>" class="fonte_item_menu">-->
						<input i class="fa fa-search" type="image" src="imagens/icon/farol.ico" title="Tel" style="max-widht:20px; max-height:20px;">                                                      
						<?Php echo"$AttribMenuLingua00";?>
						<!--</a>-->
					</td>
				</tr>
				<!-- Check Config SWA -->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
						<!-- <a href="<?Php echo"$AttribMenuLinguaLink01";?>" class="fonte_menu_esq">-->
						<?Php if(str_contains($CheckTaBackBoneX, 'swa')){ ?>	
							<input i class="fa fa-search" type="image" src="imagens/icon/checked.ico" title="Tel" style="max-widht:20px; max-height:20px;">                                                      
						<?Php }else{ ?>
							<input i class="fa fa-search" type="image" src="imagens/icon/no_checked.ico" title="Tel" style="max-widht:20px; max-height:20px;">                                                      
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
							if(str_contains($CheckTaBackBoneX, '2024')){ 
								$AttribMenuLingua02 = "NetC: Ativado";
							?>								
								<input i class="fa fa-search" type="image" src="imagens/icon/lampada.ico" title="Tel" style="max-widht:20px; max-height:20px;">                                                      
							<?Php							
							}else if(str_contains($CheckTaBackBoneX, 'Planej')){ 
								$AttribMenuLingua02 = "NetC: Planejado";
							?>								
								<input i class="fa fa-search" type="image" src="imagens/icon/planejado.ico" title="Tel" style="max-widht:20px; max-height:20px;">                                                      
							<?Php
							}else if(str_contains($CheckTaBackBoneX, 'Processo')){ 
								$AttribMenuLingua02 = "NetC: Up";
						?>
							<input i class="fa fa-search" type="image" src="imagens/icon/checked.ico" title="Tel" style="max-widht:20px; max-height:20px;">                                                      
						<?Php }else{ ?>
							<input i class="fa fa-search" type="image" src="imagens/icon/no_checked.ico" title="Tel" style="max-widht:20px; max-height:20px;">                                                      
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
						<?Php if(str_contains($CheckTaBackBoneX, '95')){ ?>	
							<input i class="fa fa-search" type="image" src="imagens/icon/checked.ico" title="Tel" style="max-widht:20px; max-height:20px;">                                                      
						<?Php }else{ ?>
							<input i class="fa fa-search" type="image" src="imagens/icon/no_checked.ico" title="Tel" style="max-widht:20px; max-height:20px;">                                                      
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
							<input i class="fa fa-search" type="image" src="imagens/icon/checked.ico" title="Tel" style="max-widht:20px; max-height:20px;">                                                      
						<?Php }else{ ?>
							<input i class="fa fa-search" type="image" src="imagens/icon/no_checked.ico" title="Tel" style="max-widht:20px; max-height:20px;">                                                      
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

	
	</div><!-- Geral Esquerdo -->
	</td>
	<!-------------------------------- Final Geral Esquerdo -------------------------------------------------------------------->
	
	
	<!-------------------------------- Inicio Geral Direito -------------------------------------------------------------------->
	
	<td width="100%" colspan="1"  align="center"  height="5" valign="top">
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
		<!-- Referencia menu Sistema --	
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


		</form><!-- Form Localizar, inserido aqui devido linhas indesejaveis no IE -->
					
		<form name="Tickets" method="post" action="calc_banda.php">				<!-- Editar -->


			<!------------------------- Inicio Conte�do central -------------------------------------------------------------------->
			
			<div id="conteudo_Central"><!-- Conte�do Central(Esq, Pesq, Dir)-->

			<!-- Conte�do Main - Margem -->
			<table class="TAB_MainConteudoExtMargem" width="100%" align="center" valign="top" border="0"> <!-- Margem -->	
			<tr>
			
			<!-- Conte�do Main Esquerdo -->
			<td width="20%" colspan="3"  align="left"  height="20" valign="top">

			
			<!-- Conte�do Main Esquerdo -->
			<table class="TAB_MainConteudoExt" width="100%" align="center"  valign="top" border="0"> <!-- Sem Margem -->				
			<tr><!-- Conte�do Central(Esq, Pesq, Dir) -->
				<!-- Conte�do da Pesquisa (Resultdados)-->
				<td width="60%" colspan="1"   height="20" align="center" valign="top">
				<div id="conteudo_pesquisa"><!-- Conte�do da Pesquisa (Resultdados)-->
				<!------------------------------------ Inicio Conteudo de  ------------------------------------------------------------------>				
<?Php
			//*********************************************************************************************
			

				
?>				
			
				<br>
				<table class="TAB_ConteudoIntMargem" width="100%" align="center" valign="top" border="0"> 	
				Ajuste Edge!			
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
                <td width="45%" colspan="1"  align="center"  height="5" valign="top" ><font size='2' color='#008080'>
                    <!------------------------------ Inicio Text-area Script ---------------------------------------->
                    <!-- Table anhinha TextArea/Barra de Select/Botoes -->     
                    <table class="TAB_ConteudoIntMargem" width=100% align="center" valign="top" border="0"> 					
						<?Php 
							// Tive de usar esta rotina pois so com echo estava adicionando linhas a cada salvar
							//$lstTaRascunho = explode('\n', $TaRascunhoX);
							$lstTaRascunho = preg_split('/\r\n|\r|\n/', $TaRascunhoX);										
						?>
                            <tr align="left"  height="5" valign="top">
                                <td width="100%" colspan="2"  align="left"  height="5" valign="top" ><font size='2' color='#008080'>
                                    <TEXTAREA ID="TaRascunho" name="TaRascunho" COLS="120" ROWS="20" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);"> 
                                   <?Php 
								 		//echo $TaRascunhoX;  <- Erro! Adiciona linhas no topo em todo Salvar 
										for($t = 1; $t < count($lstTaRascunho); $t++){ // <- t=1, elimina primeira linha
											printf("%s\n",$lstTaRascunho[$t]);											
										}  
									?>
                                    </TEXTAREA>
                                </td>
                            </tr> 
							<!-- Input Num.Processo Epika-Flow -->
							<tr align="left"  height="5" valign="top">
                               	<td width="10%" colspan="1"  align="left"  height="5" valign="top">N° Proc:</td>	
								   <td width="20%" colspan="2"  align="left"  height="5" valign="top" ><font size='2' color='#008080'>
									<input type="text" id="edIdFlow" name="edIdFlow" size="40" value="<?Php echo "$edIdFlowX" ; ?>"> <!-- required pattern="[0-9]{7}"> -->
				           			<input onclick="CopyToClipBoardX('edIdFlow')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar num.processo Epika-Flow" style="max-widht:20px; max-height:20px;">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									   Vrf:
									<select id="CxVrfEmpresa" name="CxVrfEmpresa" size="1"  onchange="interTravarPolicyOUT()" style=" font-size: 10pt;">
                                    	<option><?Php echo $CxVrfEmpresaX; ?></option>  
                                    	<?Php for($p = 0; $p < 10; $p++){ ?>  
											<option><?Php printf("s"); ?></option>  
                                    	<?Php } ?> 
									</select>
									
                            		<select id="CxVrf" name="CxVrf" size="1" onchange="interTravarPolicyIN()" style=" font-size: 10pt;">
                                    	<option><?Php echo $CxVrfX; ?></option> 
										<?Php for($p = 0; $p < 10; $p++){ ?>  
											<option><?Php printf("s"); ?></option>  
                                    	<?Php } ?> 								
									</select>
									<button type="submit" name="BtDuplicar" value="Novo" style="widht:20px; height:20px; border:none; cursor: hand;" title="Duplicar registro atual">
										<img src="imagens/icon/duplicar.ico"  style="widht:130%; height:130%;">
									</button>									
									<button type="submit" name="BtDuvida" value="Novo" style="widht:20px; height:20px; border:none; cursor: hand;" title="Recuperar acessos">
										<img src="imagens/icon/planejado.ico"  style="widht:130%; height:130%;">
									</button>
                                </td>                            
                            
                            </tr>  
							<tr align="left"  height="5" valign="top">
                                <td width="100%" colspan="2"  align="left"  height="5" valign="top" ><font size='2' color='#008080'>
                          
								<!---------------------- Ini Barra de Select/botoes abaixo do TextArea---------------------------------------------->
								<!-- Table aninha Select/Botoes Novo/salvar/Limpar -->
								<table class="TAB_ConteudoIntMargem" width=100% align="center" valign="top" border="0">				
								<tr align="left"  height="5" valign="top">
									<td width="12%" colspan="1"  align="left"  height="5" valign="top">
										<input onclick="CopyToClipBoardX('edSn_Tel')" i class="fa fa-search" type="image" src="imagens/icon/Tel.ico" title="Tel" style="max-widht:20px; max-height:20px;">                                                      
										<input onclick="CopyToClipBoardX('edSn_Vv')" i class="fa fa-search" type="image" src="imagens/icon/monitor.ico" title="Vivo" style="max-widht:20px; max-height:20px;">                          
										<input onclick="CopyToClipBoardX('TaRascunho')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar rascunho" style="max-widht:20px; max-height:20px;">
										<input onclick="CopyToClipBoardX('TaBackBone')" i class="fa fa-search" type="image" src="imagens/icon/baixar.ico" title="Copiar Validacao/Backbone" style="max-widht:20px; max-height:20px;">
								
									</td>
									<td width="60%" colspan="1"  align="left"  height="5" valign="top">		
									
										<input i class="fa fa-search" type="image" src="imagens/icon/bussola.ico" title="Consulta Ticket" style="max-widht:20px; max-height:20px;">									
										<?Php echo '['.$ResolvidosHoje.']'; ?>
										<select name="CxTicket" size="1" onChange="this.form.submit();" style=" font-size: 9pt;">							
											<option style="background: #0000FF; color: #fff;">
												<?Php echo $CxTicketX; ?>
											</option>	
											<!-- Tickts Novos -->							
											<?Php 
												$TotNovos = $lstTktNovos[_CtgVETOR][_CtgVETOR];
												if($TotNovos > 1){ $TotNovos = 0; } // Limita 3(0a2) Novos em amostra
												for($n = $TotNovos; $n >= 0; $n--){ ?>													
												<option style="background: #1E90FF; color: #fff;">
													<?Php printf("[%s] %s", $lstTktNovos[$n][_REG], $lstTktNovos[$n][_Status]); ?>
												</option>
											<?Php } ?>	
											<!-- Analisando -->										
											<?Php 
												for($i = 0; $i < $lstTickects[_CtgVETOR][_CtgVETOR]; $i++){ 
													if($lstTickects[$i][_Data] ==''){ $DataY = Date('d/m'); }
													else{ $DataY = $lstTickects[$i][_Data]; }	
													if( str_contains($lstTickects[$i][_Status], 'Pende') ){ // Muda cor se for Pendencia
														?><option style="background: #F08080; color: #fff;"><?Php
													}else{
															?><option style="background: #00BFFF; color: #fff;"><?Php
													}												 
											?>		
													
													<?Php $parteStatus = substr($lstTickects[$i][_Status],0,3).', '.substr($lstTickects[$i][_Status],8, 6);
														printf("[%s] %s, %s - %sM (%s-%s)",$lstTickects[$i][_REG], 
																					$lstTickects[$i][_ID], 
																					substr($lstTickects[$i][_Empresa],0,10), 
																					$lstTickects[$i][_Speed], 
																					$parteStatus, 
																					$DataY); ?>
												</option>
											<?Php } ?>
											<!-- Tickts Revisar -->	
											<?Php 
												$TotRv = $lstTktRevisar[_CtgVETOR][_CtgVETOR];
												if($TotRv > 0){
													if($TotRv >= 5){ $TotRv = 5; } // Limita a X registros anteriores
													for($rv = 0; $rv < $TotRv; $rv++){ ?>													
														<option style="background: #3CB371; color: #fff;">
															<?Php printf("[%s] %s - %s(%s)", $lstTktRevisar[$rv][_REG], $lstTktRevisar[$rv][_ID], $lstTktRevisar[$rv][_Status], $lstTktRevisar[$rv][_Data]); ?>
														</option>
													<?Php }	}	
												
												//<!-- Tickts Encerrados -->
												$Tot = $lstTktEncerrados[_CtgVETOR][_CtgVETOR];
												if($Tot >= _TotENCERRADOS){ $Tot = _TotENCERRADOS; } // Limita a X registros anteriores
												for($e = 0; $e < $Tot; $e++){ ?>													
													<!-- <option style="background-image: url('imagens/icon/edit.ico');"> -->
													<option style="background: #228B22; color: #fff;">
														
														<?Php printf("[%s] %s, %s - %s M(%s-%s)",$lstTktEncerrados[$e][_REG], 
																						$lstTktEncerrados[$e][_ID], 
																						substr($lstTktEncerrados[$e][_Empresa], 0, 10), // Parte do Nome
																						$lstTktEncerrados[$e][_Speed],
																						substr($lstTktEncerrados[$e][_Status], 0,3), 
																						$lstTktEncerrados[$e][_Data]); ?>
													</option>
											<?Php } ?>																	
										</select>  											 
										<select name="CxStatus" size="1" style=" font-size: 8pt;">
											<option style="background: #0000FF; color: #fff;"><?Php echo $CxStatusX; ?></option>																						
											<option style="background: #1E90FF; color: #fff;">Novo</option>
											<option style="background: #00BFFF; color: #fff;">Analisando</option>	
											<option style="background: #F08080; color: #fff;">Pendente(acesso)</option>
											<option style="background: #F08080; color: #fff;">Pendente(config)</option>	
											<option style="background: #F08080; color: #fff;">Pendente(email)</option>
											<option style="background: #F08080; color: #fff;">Pendente(outros)</option>	
											<option style="background: #3CB371; color: #fff;">Revisar</option>
											<option style="background: #3CB371; color: #fff;">Rastrear</option>
											<option style="background: #228B22; color: #fff;">Devolvido</option>
											<option style="background: #228B22; color: #fff;">Resolvido</option>	
											<option style="background: #228B22; color: #fff;">BdResolvido(BD-OK)</option>	
											<option style="background: #228B22; color: #fff;">UnLock</option>	
										</select>
									</td>
									<td width="28%" colspan="1"  align="right"  height="5" valign="top">

										<button type="submit" name="BtCloseTa" value="Close" style="widht:20px; height:20px; border:none; cursor: hand;" title="Ver comandos">
											<img src="imagens/icon/telnet.ico"  style="widht:120%; height:120%;">
										</button>										
										<button type="submit" name="BtOpenReverIps" value="Open" style="widht:20px; height:20px; border:none; cursor: hand;" title="Abrir Validar IPs/config backbone">
											<img src="imagens/icon/wrule.ico"  style="widht:120%; height:120%;">
										</button>										
										<button type="submit" name="BtOpenTaBackbone" value="Open" style="widht:20px; height:20px; border:none; cursor: hand;" title="Abrir Validar IPs/config backbone">
											<img src="imagens/icon/pasta.ico"  style="widht:120%; height:120%;">
										</button>										
										
										<button type="submit" name="BtAdicionar" value="Novo" style="widht:20px; height:20px; border:none; cursor: hand;" title="Add registro vazio">
											<img src="imagens/icon/novo.ico"  style="widht:130%; height:130%;">
										</button>
										
										<button type="submit" name="BtSalvar" value="Salvar" style="widht:20px; height:20px; border:none; cursor: hand;" title="Salvar registro">
											<img src="imagens/icon/save.ico"  style="widht:150%; height:150%;">
										</button>
										<button type="submit" name="BtLimpar" value="Novo" style="widht:20px; height:20px; border:none; cursor: hand;" title="Limpar">
											<img src="imagens/icon/clock.ico"  style="widht:150%; height:150%;">
										</button>
									
									</td>									
								</tr>						
								</table><!-- table final Barra Select/Botoes -->
								<!---------------------- Fim Barra de Select/botoes abaixo do TextArea ---------------------------------------------->
								</td>
                            </tr>  
						</table><!-- table final TextaArea -->   
						<?php
								// VErifica se ID e SWA ja existem no cadastro
							$ObjTickets->ContaID($edIDX);  // Check se ja existe este ID			
							$ObjTickets->ContaSWA($edSwaX);  // Check se ja existe este SWA
						?>
						<!---------------------- INi TextArea Valida-Backbone ---------------------------------------------->
						<table class="TAB_ConteudoIntMargem" width=100% align="center" valign="top"> 
						<?Php 						
						if($loadConfig[_TaBBone] == _TaBBoneOn){	
							
							if($TaBackBoneX <> ''){
								$lstTaBackbone = preg_split('/\r\n|\r|\n/', $TaBackBoneX);	// Quebra linha-a-linha num Vetor[]
							}									
						?>
						<tr align="left"  height="5" valign="top">							
							<td width="100%" colspan="3"  align="left"  height="5" valign="top" ><font size='2' color='#008080'>
							<TEXTAREA ID="TaBackBone" name="TaBackBone" COLS="120" ROWS="25" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);"> 
                            <?Php 
								if($TaBackBoneX <> ''){
									/*
									// echo $TaBackBoneX; <- Erro! Adiciona linhas no topo em todo Salvar  
									for($b = 1; $b < count($lstTaBackbone); $b++){ // <- b=1, elimina primeira linha
										printf("%s\n", $lstTaBackbone[$b]);											
									}
									*/
									$nLin = 1;
									$ExplodeTaBB = explode("\n", $TaBackBoneX);	
									$LinAntTaBB =  "";
									foreach($ExplodeTaBB as $LinTaBB){
										//if($nLin > 2 && $nLin < 10 ){ printf("%s\n", $LinTaBB); }
										if( str_contains($LinTaBB, 'a')
										|| str_contains($LinTaBB, 'e')
										|| str_contains($LinTaBB, 'i')
										|| str_contains($LinTaBB, 'o')
										|| str_contains($LinTaBB, 'u')
										|| str_contains($LinTaBB, 'A')
										|| str_contains($LinTaBB, '.')
										|| str_contains($LinTaBB, '!')
										|| str_contains($LinTaBB, '*')
										|| $nLin < 3){
										
											printf("%s\n", $LinTaBB);
											$LinAntTaBB = $LinTaBB;
										}
										
										// Insere linha vazia para separar Validacao de backbone
										if (str_contains($LinAntTaBB, 'VALID') && !str_contains($TaBackBoneX, 'CERTIFICADO')){ 
											printf("   \n");
											printf("   \n");
											$LinAntTaBB = "";
										}										
										if (str_contains($LinAntTaBB, 'Execu')){ // Insere linha abaixo da palavra: ID Execucao
											printf("   \n");											
											$LinAntTaBB = "";
										}
										if (str_contains($LinAntTaBB, 'BONE')){ 
											printf("   \n");											
											$LinAntTaBB = "";
										}		
																				
										$nLin++;
									}

								}
							?>
                            </TEXTAREA>						
							</td>
                        </tr>  
						<?Php }else if($loadConfig[_TaRIps] == _TaRIpsOn){	
							
							if($TaReverIpsX <> ''){
								$lstTaReverIps = preg_split('/\r\n|\r|\n/', $TaReverIpsX);	// Quebra linha-a-linha num Vetor[]
							}									
						?>
						<tr align="left"  height="5" valign="top">							
							<td width="100%" colspan="3"  align="left"  height="5" valign="top" ><font size='2' color='#008080'>
							<TEXTAREA ID="TaReverIps" name="TaReverIps" COLS="120" ROWS="40" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);"> 
                                <?Php 
								if($TaReverIpsX <> ''){
									// echo $TaBackBoneX; <- Erro! Adiciona linhas no topo em todo Salvar  
									for($b = 1; $b < count($lstTaReverIps); $b++){ // <- b=1, elimina primeira linha
										printf("%s\n", $lstTaReverIps[$b]);											
									}
								}
								?>
                            </TEXTAREA>						
							</td>
                        </tr>  
						<?Php 
							} 
						?>
						</table><!-- table final TextaArea -->   
						
						<!---------------------- INi TextArea Valida-Backbone ---------------------------------------------->
											
						
						<!---------------------- Ini CMD: Checks/Revisar IPs abaixo de Select/botoes(abaixo do TextArea) ---------------------------------------------->
											
						<!-- <table class="TAB_ConteudoIntMargem" width=100% align="center" valign="top" border="0"> -->			
						

								
						<!--  aninha Cmd-Checks/RevisaIPS -->
						<table class="TAB_ConteudoIntMargem" width=100% align="center" valign="top"> 	
						<tr align="left"  height="5" valign="top">							
							<td width="50%" colspan="3"  align="left"  height="5" valign="top" ><font size='2' color='#008080'>
							<!-------------------------------- Ini tabela Esquerda - Teste de Ips ------------------------>
							
							<!--  aninha Clt-VPN -->
							<table class="TAB_ConteudoIntMargem" width="100%" align="center" valign="top"> 
							

								<!-- Revisar IPs-->							
								<tr align="left"  height="5" valign="top">									
                                    <td width="100%" colspan="2"  align="left"  height="5" valign="top">
										<b>Revisar IP's:</b>
                                    </td>
                                </tr>
                                <?Php for($Ra = 0; $Ra < 3; $Ra++){ $objHtmlReverIP = 'edCmdRvIP'.$Ra; ?>
								<tr align="left"  height="5" valign="top">									
									<td width="100%" colspan="2"  align="left"  height="5" valign="top">
										<!--  Comandos de RevisaIPS -->			
										<input onclick="CopyToClipBoardX('<?Php echo $objHtmlReverIP; ?>')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">                          
										<input type="text" id="<?Php echo $objHtmlReverIP; ?>" name="<?Php echo $objHtmlReverIP; ?>" size="40" value="<?Php echo $ReverIPs[$Ra]; ?>" style="font-weight: normal;"> 
									</td>
								</tr>
								<?Php } ?>
								<tr align="left"  height="5" valign="top">									
									<td width="100%" colspan="2"  align="left"  height="5" valign="top">
										<!-- sed -i '66d' /home/80969577/.ssh/known_hosts -->									
										<input onclick="CopyToClipBoardX('<?Php echo $objHtmlReverIP; ?>')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar cmd: desbloqueio de maquina" style="max-widht:20px; max-height:20px;">                          
										<input type="text" id="<?Php echo $objHtmlReverIP; ?>" name="<?Php echo $objHtmlReverIP; ?>" size="40" value="<?Php echo $ReverIPs[ $ReverIPs[_CtgVETOR]-1]; ?>" style="font-weight: normal;" title="Liberar bloqueio da maquina, substituir 66d pelo codigo enviado"> 
									</td>
								</tr>
								<tr align="left"  height="5" valign="top">									
									<td width="100%" colspan="2"  align="left"  height="5" valign="top">
										<!--  Comandos de RevisaIPS - Lista de Icones para Robo Copiar Cmd  -->		
										<?Php for($R = 3; $R < $ReverIPs[_CtgVETOR] -1; $R++){ $objHtmlReverIP = 'edCmdRvIP'.$R; ?>
											<?Php if($R == 3 || $R == 10 || $R == 17){ // Muda o Icone - separa(Exit) ?> 
												<br>
												<input onclick="CopyToClipBoardX('<?Php echo $objHtmlReverIP; ?>')" i class="fa fa-search" type="image" src="imagens/icon/separa.ico" title="Copiar cmd(Robo)" style="max-widht:20px; max-height:20px;">                          									
										
											<?Php }else{ // Icone padrao ?>
												<input onclick="CopyToClipBoardX('<?Php echo $objHtmlReverIP; ?>')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar cmd(Robo)" style="max-widht:20px; max-height:20px;">                          
										<?Php } }?>	
									</td>
								</tr>
								
                                <p>
								<?Php for($Ra = 0; $Ra < 27; $Ra++){ ?>
								<tr align="left"  height="5" valign="top">									
									<td width="100%" colspan="2"  align="left"  height="5" valign="top">
									</td>
								</tr>
								<?Php } ?>
								<tr align="left"  height="5" valign="top">									
									<td width="100%" colspan="2"  align="left"  height="5" valign="top">
									<!-- Repositorios Cmds testar-Ips para robo copiar -->
									<?Php for($R = 3; $R < $ReverIPs[_CtgVETOR]; $R++){ $objHtmlReverIP = 'edCmdRvIP'.$R; ?>																			
										<input type="text" id="<?Php echo $objHtmlReverIP; ?>" name="<?Php echo $objHtmlReverIP; ?>" size="1" value="<?Php echo $ReverIPs[$R]; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
									<?Php } ?>	
									</td>
								</tr>
														
							</table><!-- table Cmd Revisa IPS -->
						
							
							<!-------------------------------- Fim tabela Esquerda - Teste de Ips ------------------------>
							</td>
							
							<td width="50%" colspan="3"  align="left"  height="5" valign="top" ><font size='2' color='#008080'>
							<!-------------------------------- Ini tabela Direita - Comandos Routers ------------------------>
								
							<table class="TAB_ConteudoIntMargem" width="100%" align="center" valign="top"> 					
									<tr align="left"  height="5" valign="top">									
                                        <td width="100%" colspan="2"  align="left"  height="5" valign="top">
											<b>Comandos:</b>
                                        </td>
                                    </tr>				
									<?Php if($CxRouterX != '' && $CxRouterX != 'Datacom'){ ?>	<!-- Se ja houver um roteador definido, mostre comandos -->
									
                                    <?Php for($C = 0; $C < $MyScript[_CtgCmdRouters]; $C++){ $objHtmlCmd = 'edCmd'.$C; ?>
                                    <tr align="left"  height="5" valign="top">									
                                        <td width="100%" colspan="2"  align="left"  height="5" valign="top">
											<!-- Usa em Comandos-Checagens, abaixo do TabackBone -->
                                            <?Php if($MyScript[_FaixaCmdRouters + $C] !=''){ ?>
												<?Php if(str_contains($MyScript[_FaixaCmdRouters + $C], 'VPN:') || str_contains($MyScript[_FaixaCmdRouters + $C], 'Tunnel')){ ?>
													<input type="text" id="<?Php echo $objHtmlCmd; ?>" name="<?Php echo $objHtmlCmd; ?>" size="10" value="<?Php echo $MyScript[_FaixaCmdRouters + $C]; ?>" style="font-weight: normal; background: #B0C4DE;"> 
												<?Php }else{ ?> 
													<input onclick="CopyToClipBoardX('<?Php echo $objHtmlCmd; ?>')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">                          
													<input type="text" id="<?Php echo $objHtmlCmd; ?>" name="<?Php echo $objHtmlCmd; ?>" size="50" value="<?Php echo $MyScript[_FaixaCmdRouters + $C]; ?>" style="font-weight: normal;"> 
											<?Php } }?>	
										</td>
                                    </tr>
                                    <?Php } ?>

									
								<?Php }else{ ?>	
								<tr align="left"  height="5" valign="top">									
									<td width="100%" colspan="2"  align="left"  height="5" valign="top">
									<font size='2' color='#FF0000'>
										Nenhum roteador informado.                  
									</td>
								</tr>
								<?Php } ?>	
								</table><!--  aninha Cmds -->						
							<!-------------------------------- Fim tabela Direita - Comandos Routers ------------------------>
						
						
						<!---------------------- Fim Barra de Select/botoes abaixo do TextArea ---------------------------------------------->
							</td>
						</tr>  
					</table>  <!-- table aninha Cmd-Checks/RevisaIPS --> 
					
					<!---------------------- Fim CMD: Checks/Revisar IPs abaixo de Select/botoes(abaixo do TextArea) ---------------------------------------------->
					
			</td> <!-- Final Conteudo Esquerdo, inicio Conteudo Direito(campos: ID, Empresa...) --> 
            <td width="55%" colspan="1"  align="left"  height="5" valign="top" ><font size='2' color='#008080'>
                    
					<table class="TAB_ConteudoIntMargem" width="100%" align="center" valign="top"> 					
                    
                    <tr align="left"  height="5" valign="top">
                        <td width="100%" colspan="2"  align="center"  height="5" valign="top" ><font size='2' color='#008080'>
                        <!------------------------------- Ini Campos Direito -------------------------------------------------------------------->
                         <!-- ID/Produto -->	
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">
									ID/Produto:
								</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<input onclick="CopyToClipBoardX('edID')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar ID" style="max-widht:20px; max-height:20px;">
                       				<input type="text" id="edID" name="edID" size="10" value="<?Php echo "$edIDX" ; ?>"> <!-- required pattern="[0-9]{7}"> -->
									   &nbsp;&nbsp;&nbsp;
									   <input onclick="CopyToClipBoardX('edRepositorioProduto')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar Produto" style="max-widht:20px; max-height:20px;">
										<select name="CxProduto" size="1">
											<option><?Php echo $CxProdutoX; ?></option>										
											<option>IPD</option>
											<option>VPN</option>																				                   
										</select>
										
										<button type="submit" name="BtLiberarID" value="Liberar ID"   style="widht:10px; height:20px; border:none;" title="Limpar campos">
											<img src="imagens/icon/tirar.ico"  style="widht:150%; height:150%;">
										</button>
										<!--
										<input type="hidden" value="Limpar-campos" name="BtLiberarID">										
										<input type="image" name="BtLiberarID" value="Limpar-campos" src="imagens/icon/tirar.ico" alt="Submit" width="32" height="32">
										-->
						        </td>                            
                            </tr>
                            <!-- Empresa -->		
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">Empresa:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<input onclick="CopyToClipBoardX('edEmpresa')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
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
									<input onclick="CopyToClipBoardX('edRepositorioSWA')" i class="fa fa-search" type="image" src="imagens/icon/computer.ico" title="ssh + Nome-SWA" style="max-widht:20px; max-height:20px;">
									<input type="text" id="edSWA" name="edSWA" size="22" value="<?Php echo "$edSwaX" ; ?>" >
									<input onclick="CopyToClipBoardX('edSWA')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
								</td>                            
                            </tr>	
							<!-- Vlan Ger/ PortSwa -->
							<tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">Vlan Ger:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<input onclick="CopyToClipBoardX('edgVlan')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar Vlan de gerencia" style="max-widht:20px; max-height:20px;">
									<input type="text" placeholder="Vlan Ger." id="edgVlan" name="edgVlan" size="7" value="<?Php echo "$edgVlanX" ; ?>"> <!-- required pattern="[0-9]{1,}"> -->
                       				<!-- Copiar email abertura TA do repositorio -->
									<input onclick="CopyToClipBoardX('TaRepositorioEmailTA')" i class="fa fa-search" type="image" src="imagens/icon/email.ico" title="Copiar email abertura TA" style="max-widht:20px; max-height:20px;">
									
									<input onclick="CopyToClipBoardX('edRepositorioAdmSWA')" i class="fa fa-search" type="image" src="imagens/icon/suporte.ico" title="Acesso SWA via 'admin'" style="max-widht:20px; max-height:20px;">
									<input onclick="CopyToClipBoardX('edRepositorioSuporteSWA')" i class="fa fa-search" type="image" src="imagens/icon/suporte.ico" title="Acesso SWA via 'suporte'" style="max-widht:20px; max-height:20px;">
									<input onclick="CopyToClipBoardX('edRepositorioOper_b2bSWA')" i class="fa fa-search" type="image" src="imagens/icon/chave.ico" title="Acesso SWA via 'oper_b2b'" style="max-widht:20px; max-height:20px;">
								</td>                            
                            </tr>
							<!--EDD -->
							 <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">EDD:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">								
									<select name="CxEDD" size="1">																															
										<option><?Php echo $CxEddX; ?></option>																							
										<option>2104G2</option>													
										<option>DM4004</option>
										<option>DM4008</option>
										<option>DM4050</option>
										<option>DM4370</option>
										<option>DM4100</option>
									</select>	
								 	<select name="CxPlacaSwa" size="1">
										<option><?Php echo $CxPlacaSwaX; ?></option>										
										<?Php for($p=0; $p<16; $p++){ ?>																				
										<option><?Php  echo $p; ?></option>
										<?Php  }?>	
									</select>
								 	<select name="CxPortSwa" size="1">
										<option><?Php echo $CxPortSwaX; ?></option>										
										<?Php for($p=1; $p<49; $p++){ ?>																				
										<option><?Php  echo $p; ?></option>
										<?Php  }?>	
									</select>
									<input onclick="CopyToClipBoardX('edRepositorioSoPortSwa')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar Porta-SWA" style="max-widht:20px; max-height:20px;">
							
									<select name="CxOperadora" size="1">																															
										<option><?Php echo $CxOperadoraX; ?></option>																							
										<option>AGG</option>
										<option>ERB</option>													
										<option>IGN</option>
										<option>INF</option>			
										<option>VTAL</option>										
									</select>	
									<input onclick="CopyToClipBoardX('edRepositorioOper')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar Operadora" style="max-widht:20px; max-height:20px;">
							
								</td>                            
                            </tr>								
							 <!-- SWT -->		
							 <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">SWT:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<input onclick="CopyToClipBoardX('edSWT')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
									<input type="text" id="edSWT" name="edSWT" size="26" value="<?Php echo "$edSwtX" ; ?>" >
                                </td>                            
                            </tr>
							 <!-- SWT-IP -->		
							 <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">SWT-IP:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<input onclick="CopyToClipBoardX('edSWT_IP')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
									<input type="text" id="edSWT_IP" name="edSWT_IP" size="26" value="<?Php echo "$edSwt_ipX" ; ?>" >
						        </td>                            
                            </tr>
							 <!-- RA -->		
							 <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">RA:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<input onclick="CopyToClipBoardX('edRepositorioRA')" i class="fa fa-search" type="image" src="imagens/icon/computer.ico" title="ssh + Nome-RA" style="max-widht:20px; max-height:20px;">
									<input type="text" id="edRA" name="edRA" size="26" value="<?Php echo "$edRaX" ; ?>" >
                                </td>                            
                            </tr>
							<!-- Router -->
							<tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">Router:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
                            
								<select name="CxRouter" size="1"><!-- onChange="this.form.submit();">-->
									<option><?Php echo $CxRouterX; ?></option>														
									<option>Cisco</option>
									<option>Datacom</option>
									<option>Huawei</option>
									<option>Juniper</option>
									<option>Nokia</option>							
								</select>
								<input onclick="CopyToClipBoardX('TaRepositorioEmailPtStar')" i class="fa fa-search" type="image" src="imagens/icon/email.ico" title="Copiar email Cad.Porta Star" style="max-widht:20px; max-height:20px;">
								<input onclick="CopyToClipBoardX('TaRepositorioEmailCadERB')" i class="fa fa-search" type="image" src="imagens/icon/email.ico" title="Copiar email Corrigir Cad.ERB_FIB" style="max-widht:20px; max-height:20px;">
						        </td>                            
                            </tr>
							<!-- Port -->		
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">Port:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
                                <select name="CxInterface" size="1">
                                    <option><?Php echo $CxInterfaceX; ?></option>
                                    <!-- <option disabled selected>-- Cisco --</option><!-- Ta pegando sempre ESSE  -->
                                    <option>Bundle-Ether</option><!-- Cisco -->
                                    <option>GigaBitEth</option><!-- Cisco -->
                                    <option>PW-Ether</option><!-- Cisco -->
                                    <option>TenGigE</option><!-- Cisco -->
                                    <option>TenGigabitEthernet</option><!-- Cisco -->
									<!-- <option disabled selected>-- Huawei --</option><!-- Huawei -->
									<option>Eth-Trunk</option><!-- Huawei -->	
									<option>eth-trunk </option><!-- Huawei -->	
									<option>GigabitEthernet</option><!-- Huawei -->	
                                    <!-- <option disabled selected>-- Juniper --</option><!-- Cisco -->	
                                    <option>ae</option><!-- Cisco -->	
                                    <option>ge-</option><!-- Cisco -->	
                                    <option>xe-</option><!-- Cisco -->	
                                    <!--<option disabled selected>-- Nokia --</option><!-- Nokia -->																	
                                    <option>lag-</option><!-- Nokia -->                            
                                </select>
                                    <input type="text" name="edPort" size="11" value="<?Php echo "$edPortX" ; ?>" >
							    </td>                            
                            </tr>            
							<!------- INI SELECT SERVICE-POLICY --------------------------------------------------------------------------------------------->
							<?Php  $lstServicePolicy = $ObjScript->servicePolicy($CxRouterX, $edSpeedX, $CxProdutoX);  ?>
                            <!-- PolicyIN -->
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">Policy-IN:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">                                    	
                                   <!-- <input type="text" name="CxPolicyIN" size="30" value="<?Php echo "$CxPolicyINX" ; ?>" >-->
									<select id="CxPolicyIN" name="CxPolicyIN" size="1"  onchange="interTravarPolicyOUT()" style=" font-size: 10pt;">
                                    	<option><?Php echo $CxPolicyINX; ?></option>  
                                    	<?Php for($p = 0; $p < $lstServicePolicy[1000]; $p++){ ?>  
											<option><?Php printf("%s", $lstServicePolicy[100+$p]); ?></option>  
                                    	<?Php } ?> 
									</select>
                                </td>                            
                            </tr>
                            <!-- PolicyOUT -->		
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">Policy-OUT:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">  
									<select id="CxPolicyOUT" name="CxPolicyOUT" size="1" onchange="interTravarPolicyIN()" style=" font-size: 6pt;">
                                    	<option><?Php echo $CxPolicyOUTX; ?></option> 
										<?Php for($p = 0; $p < $lstServicePolicy[1000]; $p++){ ?>  
											<option><?Php printf("%s", $lstServicePolicy[200+$p]); ?></option>  
                                    	<?Php } ?> 								
									</select>
                                </td>                            
                            </tr>
							<!------- FIM SELECT SERVICE-POLICY --------------------------------------------------------------------------------------------->
						
                            <!-- CtrlVid_unit/Speed -->                            
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">Vid/Unit:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
                                    <input type="text" placeholder="Ctrl-vid/Unit" name="edCtrlVidUnit" size="7" value="<?Php echo "$edCtrlVidUnitX" ; ?>" >
									<input type="text" placeholder="Speed" id="edSpeed" name="edSpeed" size="7" value="<?Php echo "$edSpeedX" ; ?>" onChange="alertProjEspecial('edSpeed');" >
									<input onclick="CopyToClipBoardX('edSpeed')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
								</td>                                    																					  
                            </tr>                   																					
                            <!-- Vrf -->		
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">Vrf:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<input onclick="CopyToClipBoardX('edVrf')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
									<input type="text" id="edVrf" name="edVrf" size="26" value="<?Php echo "$edVrfX" ; ?>" >
                                </td>
                            
                            </tr>
							<!-- sVlan/cVlan -->	
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">sVlan/cVlan:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<input onclick="CopyToClipBoardX('edSCVlan')" i class="fa fa-search" type="image" src="imagens/icon/soma.ico" title="sVlan+cVlan" style="max-widht:20px; max-height:20px;">
									<input onclick="CopyToClipBoardX('edsVlan')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="sVlan" style="max-widht:20px; max-height:20px;">
									<input type="text" placeholder="sVlan" id="edsVlan" name="edsVlan" size="5" value="<?Php echo "$edsVlanX" ; ?>"> <!-- required pattern="[0-9]{3,}"> -->
									&nbsp;&nbsp;&nbsp;
									<input onclick="CopyToClipBoardX('edcVlan')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="cVlan" style="max-widht:20px; max-height:20px;">
									<input type="text" placeholder="cVlan" id="edcVlan" name="edcVlan" size="5" value="<?Php echo "$edcVlanX" ; ?>"> <!-- required pattern="[0-9]{3,}">                         
                                </td>
                            
                            </tr>                         
                            <!-- LAN -->		
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">LAN(0):</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<?Php $objHtmlIPs = "edLAN"; ?>
									<input onclick="CopyToClipBoardX('<?Php echo $objHtmlIPs; ?>')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">                          
									<input type="text" id="<?Php echo $objHtmlIPs; ?>" name="<?Php echo $objHtmlIPs; ?>" size="21" value="<?Php echo $edLANX; ?>" style="font-weight: normal;"> 								
                                </td>
                            
                            </tr>
                            <!-- WAN -->		
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">WAN(0):</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<?Php $objHtmlIPs = "edWAN"; ?>
									<input onclick="CopyToClipBoardX('<?Php echo $objHtmlIPs; ?>')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">                          
									<input type="text" id="<?Php echo $objHtmlIPs; ?>" name="<?Php echo $objHtmlIPs; ?>" size="21" value="<?Php echo $edWANX; ?>" style="font-weight: normal;"> 								                      
                                </td>
                            
                            </tr>
                            <!-- LoopBack -->		
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">LoopBack:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<?Php $objHtmlIPs = "edLoopBack"; ?>
									<input onclick="CopyToClipBoardX('<?Php echo $objHtmlIPs; ?>')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">                          
									<input type="text" id="<?Php echo $objHtmlIPs; ?>" name="<?Php echo $objHtmlIPs; ?>" size="21" value="<?Php echo $edLoopBackX; ?>" style="font-weight: normal;"> 								
                                </td>
                            
                            </tr>
                            <!-- LAN6 -->		
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">LAN(ipv6):</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<?Php $objHtmlIPs = "edLAN6"; ?>
									<input onclick="CopyToClipBoardX('<?Php echo $objHtmlIPs; ?>')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">                          
									<input type="text" id="<?Php echo $objHtmlIPs; ?>" name="<?Php echo $objHtmlIPs; ?>" size="21" value="<?Php echo $edLAN6X; ?>" style="font-weight: normal;"> 								
				                </td>                            
                            </tr>
                            <!-- WAN6 -->		
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">WAN(ipv6):</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<?Php $objHtmlIPs = "edWAN6"; ?>
									<input onclick="CopyToClipBoardX('<?Php echo $objHtmlIPs; ?>')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">                          
									<input type="text" id="<?Php echo $objHtmlIPs; ?>" name="<?Php echo $objHtmlIPs; ?>" size="34" value="<?Php echo $edWAN6X; ?>" style="font-weight: normal; font-size: 12px"> 								
                                </td>                            
                            </tr>							
</html>
							<tr align="center"  width="200px" height="5" valign="top">
								<td width="200px" colspan="2"  align="left"  height="5" valign="top">
									<input type="text" id="empurrarColuna" name="empurrarColuna" value="Este Input so serve para calcar a largura da coluna" size="50" height="1" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
								</td>							                          
                            </tr>		
                        <!-------------------- Fim campos Direito ----------------------------------------------------------------------->   
                        </td>
						</tr>
						
					</table><!-- Final Conteudo Direito(campos: ID, Empresa....) -->              
					<!-- Repositorio TextaArea Emails -->	
					<?Php 
						$EmailPortStar = $ObjTickets->EmailPortStar($edRaX, $CxInterfaceX, $edPortX); 
						$EmailCadERB = $ObjTickets->EmailCadERB($edSwaX, $edRaX, $CxInterfaceX, $edPortX); 
						$EmailTA = $ObjTickets->EmailTA($edSwaX, $edSwt_ipX); 	
					?>			
					<TEXTAREA ID="TaRepositorioEmailPtStar" name="TaRepositorioEmailPtStar" COLS="22" ROWS="5" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);"> 
						<?Php for($t = 0; $t < $EmailPortStar[_CtgVETOR]; $t++){ printf("%s\n", $EmailPortStar[$t]); } ?>	
					</TEXTAREA>	
					<TEXTAREA id="TaRepositorioEmailTA" name="TaRepositorioEmailTA" COLS="22" ROWS="5" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);"> 
						<?Php for($t = 0; $t < $EmailTA[_CtgVETOR]; $t++){ printf("%s\n", $EmailTA[$t]); } ?>				
					</TEXTAREA>					
					<TEXTAREA id="TaRepositorioEmailCadERB" name="TaRepositorioEmailCadERB" COLS="22" ROWS="5" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);"> 
						<?Php for($t = 0; $t < $EmailCadERB[_CtgVETOR]; $t++){ printf("%s\n", $EmailCadERB[$t]); } ?>				
					</TEXTAREA>					
					<br>
					<!-- Repositorios(Copy) Tel/Vv --> 
					<input type="text" ID="edSn_Tel" name="edSn_Tel" size="1" value="<?Php echo _TEL; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
					<input type="text" ID="edSn_Vv" name="edSn_Vv" size="1" value="<?Php echo _VV; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
					
					<!-- Junta sVlan+cVlan p/ CopyClipBoard -->
					<input type="text" ID="edSCVlan" name="edSCVlan" size="1" value="<?Php echo $edsVlanX.$edcVlanX; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
					<!-- Inclui 'ssh ' antes de SWA e RA p/ CopyClipBoard -->
					<input type="text" ID="edRepositorioProduto" name="edRepositorioProduto" size="1" value="<?Php echo $CxProdutoX; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
					<input type="text" ID="edRepositorioOper" name="edRepositorioOper" size="1" value="<?Php echo $CxOperadoraX; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
					<input type="text" ID="edRepositorioSWA" name="edRepositorioSWA" size="1" value="<?Php echo "ssh ".$edSwaX; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
					<input type="text" ID="edRepositorioAdmSWA" name="edRepositorioAdmSWA" size="1" value="<?Php echo _SwaAdm; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
					<input type="text" ID="edRepositorioSuporteSWA" name="edRepositorioSuporteSWA" size="1" value="<?Php echo _SwaSuporte; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
					<input type="text" ID="edRepositorioOper_b2bSWA" name="edRepositorioOper_b2bSWA" size="1" value="<?Php echo _SwaOperB2b; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
					<input type="text" ID="edRepositorioRA" name="edRepositorioRA" size="1" value="<?Php echo "ssh ".$edRaX; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
					
					<!-- Port-SWA para robo copiar DTC -->
					<input type="text" ID="edRepositorioPlacaSwa" name="edRepositorioPlacaSwa" size="1" value="<?Php echo "1/1/".$CxPlacaSwaX; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
					<input type="text" ID="edRepositorioPortSwa" name="edRepositorioPortSwa" size="1" value="<?Php echo "1/1/".$CxPortSwaX; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
					<input type="text" ID="edRepositorioRulePortSwa" name="edRepositorioRulePortSwa" size="1" value="<?Php echo "1-1-".$CxPortSwaX; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
					<input type="text" ID="edRepositorioSoPortSwa" name="edRepositorioSoPortSwa" size="1" value="<?Php echo 'giga-1/'.$CxPlacaSwaX.'/'.$CxPortSwaX; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
					
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

	
<!--------------------- ini msg alerta Toast -------------------------------------------------------------------------->
<div id="toastFrmApagado">
  <div class="checkicon"> <i class="fas fa-check-square"></i> </div>
	Atencao! O formulario foi limpo mas os dados NAO foram salvos.
</div>
<div id="toastRenovarGaus">
  <div class="checkicon"> <i class="fas fa-check-square"></i> </div>
	Atencao! Renovar acessos no GAUS!!!
</div>
<div id="toastTicketBlock">
  <div class="checkicon"> <i class="fas fa-check-square"></i> </div>
	Erro! Nao e possivel alterar um Ticket finalizado.
</div>
<div id="toastTaBBoneClose">
  <div class="checkicon"> <i class="fas fa-check-square"></i> </div>
    Atencao! Nao foi possivel salvar TaBackbone, pois o mesmo esta bloqueado!
</div>
<!--
<div id="toastLembrete">
  <div class="checkicon"> <i class="fas fa-check-square"></i> </div>
	Huawei!
  	[X] trafic policy 
  	[ ] qos profile
</div> -->
<!--------------------- fim msg alerta -------------------------------------------------------------------------->



</div><!-- Pagina Geral --> 

  <!-- Template JS File -->  
  <script src="resources/js/funcoes.js"></script><!-- Cria Menu auto filtro Cx-Select: Router->PolicyIN->PolicyOUT -->
  <script src="resources/js/alert.js"></script><!-- Cria Menu auto filtro Cx-Select: Router->PolicyIN->PolicyOUT -->
  
	
</body>

</html>