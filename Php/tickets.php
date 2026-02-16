<?Php
	
	$AttribPosAbaA = 0; //$_COOKIE['CookieAttribPosAbaA']; // Posi��o das abas "A"
	// Inicializa var
	$BotaoVoltar = 0;					
	$BotaoAvanco = 0;		

	include 'config/cabecario.inc';
	
//*****************************************
// Verificar Autenticaçao
	$usuario = $ObjFuncao->VerAutenticacao();	
//*****************************************
	$AbaAtivaB = $AttribAbaIntB[1];	// Informa qual Aba deve ser selecionada	
	
    include_once("Class.tickets.php");	//include_once: carregue o arquivo se ele j� N�O tenha sido inclu�do
	$ObjTickets = New Tickets();

	include_once("Class.script.php");	//include_once: carregue o arquivo se ele j� N�O tenha sido inclu�do
	$ObjScript = New Script();
	
	include_once("Class.preferencias.php");	//include_once: carregue o arquivo se ele j� N�O tenha sido inclu�do
	$ObjPreferencias = New Preferencias();
	$loadConfig = $ObjPreferencias->LoadConfig();

	// Start-var
	$tipoConfig = _NaoDefinido; // Roteador Vivo, Cliente ou não definido
	$edRepositorioAvisoFlowX = '';

	if(isset($_POST['BtOpenTaBackbone'])){								
		$ObjPreferencias->SaveConfig(_BOTOES, _LstCmdOff, _TaRIpsOff, _TaBBoneOn, Null, Null, Null, Null);
		$loadConfig[_TaBBone] = _TaBBoneOn; 					 
	}else if(isset($_POST['BtOpenReverTunnel'])){								
		$ObjPreferencias->SaveConfig(_BOTOES, _LstCmdOff, _TaRIpsOn, _TaBBoneOff, Null, Null, Null, Null);
		$loadConfig[_TaRIps] = _TaRIpsOn; 					 
	}else if(isset($_POST['BtCloseTa'])){								
		$ObjPreferencias->SaveConfig(_BOTOES, _LstCmdOn, _TaRIpsOff, _TaBBoneOff, Null, Null, Null, Null ); 
		$loadConfig[_TaRIps] = _TaRIpsOff; 
		$loadConfig[_TaBBone] = _TaBBoneOff; 
	}
	
	if(!empty($_POST['edID'])){
		$edIDX = $_POST['edID'];
		$edIDX = str_replace(" ", "", $edIDX);  // tira espaços vazios
		
	}else{
		$edIDX = '';					
	}	
	if(!empty($_POST['edEmpresa'])){
		$edEmpresaX = $_POST['edEmpresa'];
		$edEmpresaX = str_replace("MAGAZINE LUIZA", "MAGALU", $edEmpresaX);  // tira ' por causa do MySql Injection
		$edEmpresaX = str_replace("SAQUE E PAGUE", "SAQ&PAGUE", $edEmpresaX);  // tira ' por causa do MySql Injection
		$edEmpresaX = str_replace("BANCO", "BCO", $edEmpresaX);  // tira ' por causa do MySql Injection
		$edEmpresaX = str_replace("FUNDO DE UNIVERSALIZACAO DOS SERVICOS DE TELECOMUN", "FUST", $edEmpresaX);  // tira ' por causa do MySql Injection
		$edEmpresaX = str_replace("S.A", "SA", $edEmpresaX);  // tira ' por causa do MySql Injection
	}else{
		$edEmpresaX ='';
	}
	if(!empty($_POST['CxEdd'])){
		$CxEddX = $_POST['CxEdd'];
	}else{
		$CxEddX = 'EDD';					
	}
	if(!empty($_POST['edSwa'])){
		$edSwaX = $_POST['edSwa'];
	}else{
		$edSwaX = '';					
	}
	if(!empty($_POST['edSWT_IP'])){
		$edSwt_ipX = $_POST['edSWT_IP'];
	}else{
		$edSwt_ipX ='';
	}	

	if(!empty($_POST['TaRotasIntragov'])){
		$TaRotasIntragovX = $_POST['TaRotasIntragov'];
	}else{
		$TaRotasIntragovX ='';
	}	

	
	
	// TextArea com listas de informações
	$TaExecHj = '';	
	$TaLstFalha = '';
	$TaLstRA = '';		
	$BlockPOST_CxNumTicket = false; // Bloqueia Consulta pelo CxNumTicket, qdo BtAvancar for precionado

	$edgVlanPegaRecorteX = '';

	
	if(!empty($_POST['edIdFlow'])){
		$edIdFlowX = $_POST['edIdFlow'];
	}else{
		$edIdFlowX = '';					
	}	

	if($edIdFlowX == ''){ $edIdFlowX = 'Banda: ';	} // Auto-Formata inicial
	else{
		
		if( (!str_contains($edIdFlowX, 'M,')) 
		&&  (!str_contains($edIdFlowX, 'G,')) ){
			
				$edIdFlowXsub = substr( $edIdFlowX, 6, 5);		
				if($edIdFlowXsub > 1000){ $edIdFlowX = $edIdFlowX.'/10G,'; }
				else if( ($edIdFlowXsub > 190)&&($edIdFlowXsub < 1000)){ $edIdFlowX = $edIdFlowX.'/1G,'; }
				else{ 
					if($edIdFlowXsub > 1){ 	$edIdFlowX = $edIdFlowX.'/200M,'; }
				}
		}
		

		$edIdFlowX = str_replace('000', 'G, ', $edIdFlowX); // Substituir 1000M -> 1G
		$edIdFlowX = str_replace('1G, /1G,', '1G/1G, ', $edIdFlowX); // Substituir 1000M -> 1G
		$edIdFlowX = str_replace('1G, / ', '1G/', $edIdFlowX); // Substituir 1000M -> 1G
		$edIdFlowX = str_replace(' / 1G,', '/1G, ', $edIdFlowX); // Substituir 1000M -> 1G
		$edIdFlowX = str_replace('1G/1G,    /200M,', '1G/1G, ', $edIdFlowX); // Substituir 1000M -> 1G

		$edIdFlowX = str_replace('1G, 0/1G,  0', '10G/10G, ', $edIdFlowX); // Substituir 1000M -> 1G
		$edIdFlowX = str_replace(' / 200', '/200M, ', $edIdFlowX); // Substituir 1000M -> 1G
		$edIdFlowX = str_replace(' / 400', '/400M, ', $edIdFlowX); // Substituir 1000M -> 1G
		$edIdFlowX = str_replace(' / 500', '/500M, ', $edIdFlowX); // Substituir 1000M -> 1G
		$edIdFlowX = str_replace(' / 600', '/500M, ', $edIdFlowX); // Substituir 1000M -> 1G
		
	}

	if(!empty($_POST['CxTipo'])){
		$CxTipoX = $_POST['CxTipo'];
	}else{					
		$CxTipoX = 'Config';					
	}	

	
	$edSwaScanBotX='';

	if(!empty($_POST['edgVlan'])){
		$edgVlanX = $_POST['edgVlan'];
	}else{
		$edgVlanX ='';
	}	

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
	if(!empty($_POST['CxPropRouter'])){
		$CxPropRouterX = $_POST['CxPropRouter'];				
	}else{					
		$CxPropRouterX = 'Roteador nao def.';					
	}
	
	// Vrf
	if(!empty($_POST['CxVrf'])){
		$CxVrfX = $_POST['CxVrf'];					
	}else{					
		$CxVrfX = '';					
	}



	
			//----------------- INI SCANNEAR RASCUNHO(FORECTH), PEGAR VLANS, -------------------------------------------------// 

			// Pega numero registro do endereço http://
			if(isset($_REQUEST['reg']) ){
				$RegURL = $_REQUEST['reg'];	
				$CxNumTicketX = '['.$RegURL.']';
				$TicketEmUso = $ObjTickets->QueryTickets($CxNumTicketX, Null, 'REQUEST[reg]');	
				
				$CxProdutoX= $TicketEmUso[0][_Produto];
			}else if(isset($_POST['CxNumTicket'])){
				$CxNumTicketX = $_POST['CxNumTicket'];
				$TicketEmUso = $ObjTickets->QueryTickets($CxNumTicketX, Null, 'POST[CxNumTicket]');

				$CxProdutoX= $TicketEmUso[0][_Produto];
			}
	
			 
			
			if(!empty($_POST['TaRascunho'])){
				$TaRascunhoX = $_POST['TaRascunho'];
				
				// Rotina para pegar ID e Nome Cliente do TaRascunho
				$ExplodeTaRas = explode("\n", $TaRascunhoX);	
				$posID = 0;
				$capCliFT = ''; 
				$capCli = ''; 
				$numLinTaRas = 0; // Conta linhas do Rascunho
				$memNumLinTaRas = 0; // Memoriza linha do rascunho que ocorreu uma palavra
		
				foreach($ExplodeTaRas as $LinTaRas){
		
					if((empty($CxEddX))||(str_contains($CxEddX, 'EDD')) ){						
						if(str_contains($LinTaRas, '2104')){ $CxEddX = '2104G2'; }
						else if(str_contains($LinTaRas, 'Coriant')){ $CxEddX = 'Coriant'; }
						else if(str_contains($LinTaRas, '8615')){ $CxEddX = 'Coriant'; }						
						else if(str_contains($LinTaRas, 'DM400')){ $CxEddX = 'DM400X'; }
						else if(str_contains($LinTaRas, 'DM410')){ $CxEddX = 'DM4100'; }
						else if(str_contains($LinTaRas, 'DM405')){ $CxEddX = 'DM4050'; }
						else if(str_contains($LinTaRas, 'DM425')){ $CxEddX = 'DM4250'; }
						else if(str_contains($LinTaRas, 'DM427')){ $CxEddX = 'DM4270'; }
						else if(str_contains($LinTaRas, 'DM437')){ $CxEddX = 'DM4370'; }
						else if(str_contains($LinTaRas, 'V380R220')){ $CxEddX = 'V380R220'; }
						else if(str_contains($LinTaRas, 'S4820')){ $CxEddX = 'V380R220'; }
					}


					if(str_contains($LinTaRas, 'ID') || str_contains($LinTaRas, 'Pedido') ){
		
						if(str_contains($LinTaRas, '15') ){	$posID = strpos($LinTaRas, '15'); } 
						if(str_contains($LinTaRas, '16') ){	$posID = strpos($LinTaRas, '16'); } 
						if(str_contains($LinTaRas, '17') ){	$posID = strpos($LinTaRas, '17'); } 
						if(str_contains($LinTaRas, '18') ){	$posID = strpos($LinTaRas, '18'); } 
						if(str_contains($LinTaRas, '19') ){	$posID = strpos($LinTaRas, '19'); } 
						if(str_contains($LinTaRas, '20') ){	$posID = strpos($LinTaRas, '20'); } 
		
							$capID = substr($LinTaRas, $posID, 8);
							$capID = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($capID));
							$capID = str_replace(' ', '', $capID);  // tira espacos vazios
							
							if($edIDX ==''){ $edIDX = $capID; }
					
					}	
		
					
					// Cliente
					/*
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
					*/
					// pEGA nOME cLIENTE
					if($edEmpresaX == ''){
						if( (str_contains($LinTaRas, 'liente') )	
						||  (str_contains($LinTaRas, 'CLIENTE') ) ){
							$edEmpresaX = $LinTaRas;	
						}

					}
					// Limpa(Cliente)
					$edEmpresaX = str_replace('cliente', '', $edEmpresaX);  // tira espacos vazios
					$edEmpresaX = str_replace('Cliente', '', $edEmpresaX);  // tira espacos vazios
					$edEmpresaX = str_replace('CLIENTE', '', $edEmpresaX);  // tira espacos vazios
					$edEmpresaX = str_replace(' - ', '', $edEmpresaX);  // tira espacos vazios
					$edEmpresaX = str_replace(':', '', $edEmpresaX);  // tira espacos vazios


					//---------------- Ini Pegar nome-SWA, vindo da BotScan--------------------------//
					// Captura linha>> ERB : MG.RPS 	
					if( (str_contains($LinTaRas, 'ERB:')) 
						|| (str_contains($LinTaRas, 'ERB :')) 
						|| (str_contains($LinTaRas, 'erb:')) 
						|| (str_contains($LinTaRas, 'ERB -')) 
						|| (str_contains($LinTaRas, 'Site:'))){
						$capSwa = substr($LinTaRas, -5);
						$capSwa = str_replace(' ', '', $capSwa);  // tira espacos vazios
						$capSwa = '-'.strtolower($capSwa).'-s';	 // Passa pra minusculo
						
						if(empty($edSwaX)){
							$edSwaScanBotX	= $capSwa;	// Formata um pre-swa: m-br-mg-yyy- -> -rps-swa-0
							//echo $edSwaScanBotX;
						}
					}
		
					//---------------- Ini Pegar nome-SWA da copia do Netcompass----------------------------------------//
					if( (str_contains($LinTaRas, '-swa-0'))
					||  (str_contains($LinTaRas, '-swo-0'))
					||  (str_contains($LinTaRas, '-she-0')) ){
						if(empty($edSwaX)){ 
							$edSwaX = $LinTaRas; 
							$edSwaX = str_replace(' ', '', $edSwaX);  // tira espacos vazios
						}	
		
					}
					//---------------- Ini Pegar IP-SWA ------------------------------------------//
					
					// Pega IP 2 linhas abaixo da ocorrencia: mgmtIpAddress:
					if(str_contains($LinTaRas, 'mgmtIpAddress')){  
						$memNumLinTaRas = $numLinTaRas; 
						//echo $LinTaRas.'->'.$memNumLinTaRas.'='.$numLinTaRas.'<br>';	// Conta qtas linhas passou
					} // Memoriza linha
					/*
					$nL = $numLinTaRas - $memNumLinTaRas;	// Conta qtas linhas passou
					//echo $nL.'='.$numLinTaRas.'-'.$memNumLinTaRas.'<br>';	// Conta qtas linhas passou
					if($nL == 2){ 
						//echo '<br>'.$LinTaRas.'->'.$memNumLinTaRas.'='.$numLinTaRas.'<br>';	// Conta qtas linhas passou
						if(!str_contains($edSwt_ipX, '.')){ 
							$numeroPtos = mb_substr_count($LinTaRas, '.', 'UTF-8');
							echo 'nPt >>>>'.$numeroPtos;
							if($numeroPtos > 2){
								if( (str_contains($LinTaRas,'0'))||(str_contains($LinTaRas,'1'))||(str_contains($LinTaRas,'2') )){	// Da uma filtrada e formato IP(cntem pto)
									$edSwt_ipX = $LinTaRas; 
									$edSwt_ipX = str_replace(' ', '', $edSwt_ipX);  // tira espacos vazios
								}
							}
							//echo 'Achou! '.$LinTaRas.'<br>';	// Conta qtas linhas passou
						}	
					}
					*/
					if(!str_contains($edSwt_ipX, '.')){ 
						$numeroPtos = mb_substr_count($LinTaRas, '.', 'UTF-8');
						
						if($numeroPtos > 2){
							
							if( (str_contains($LinTaRas,'0'))||(str_contains($LinTaRas,'1'))||(str_contains($LinTaRas,'2') )){	// Da uma filtrada e formato IP(cntem pto)
								//echo 'nPt >>>>'.$numeroPtos.' -> '.$LinTaRas;
								$edSwt_ipX = $LinTaRas; 
								$edSwt_ipX = str_replace(' ', '', $edSwt_ipX);  // tira espacos vazios
							}
						}
						//echo 'Achou! '.$LinTaRas.'<br>';	// Conta qtas linhas passou
					}	

					//$edSwt_ipX = str_replace(' ', '', $edSwt_ipX);  // tira espacos vazios
					//---------------- Fim Pegar nome-SWA, IPs------------------------------------//
		
					$posVel = 0;
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
					//---------------- Pegar g, sVlan -----------------------------------------------//
					if(str_contains($LinTaRas, 'interface vlan')){
						$nVlan = str_replace('interface vlan', '', $LinTaRas);  // tira palavras deixa so numero 
						$nVlan = str_replace(' ', '', $nVlan);  // tira espacos vazios
						if( ((int)$nVlan > 1000)&&((int)$nVlan < 3000) ){
							if ((int)$nVlan % 2 == 0) {						
								if(str_contains($CxProdutoX, 'VPN')){
									if(empty($edsVlanX)){ $edsVlanX = $nVlan; }		// sVlan
								}
							}else{
								if(str_contains($CxProdutoX, 'IPD')){
									if(empty($edsVlanX)){ $edsVlanX = $nVlan; }		// sVlan
								} 
							}
		
						}else if( ((int)$nVlan > 2999)|| ((int)$nVlan == 3) ){
							// GERENCIA
							if(empty($edgVlanX)){ $edgVlanX = $nVlan; }		// gVlan
						}
		
					}else if(str_contains($LinTaRas, 'vlan')){
						$nVlan = str_replace('vlan', '', $LinTaRas);  // tira palavras deixa so numero 
						$nVlan = str_replace(' ', '', $nVlan);  // tira espacos vazios
						if( ((int)$nVlan > 1000)&&((int)$nVlan < 3000) ){
							if ((int)$nVlan % 2 == 0) {
								// VPN
							} else {
								// IPD
								if(empty($edsVlanX)){ $edsVlanX = $nVlan; }		// sVlan
							}
		
						}else if( ((int)$nVlan > 2999)|| ((int)$nVlan == 3) ){
							// GERENCIA
							if(empty($edgVlanX)){ $edgVlanX = $nVlan; }		// gVlan
						}
		
					}
					//---------------- Fim Pegar Vlans -----------------------------------------------//
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
					//---------------- Fim Pegar Vrf -----------------------------------------------//
					// Pegar sVlan, RA do recorte
					if(empty($CxVrfX)){
						if(str_contains($LinTaRas, 'vrf')){
							$CxVrfX = $LinTaRas;
						}
						$CxVrfX = str_replace('vrf ', '', $CxVrfX);  // tira espacos vazios
						$CxVrfX = str_replace(' vrf ', '', $CxVrfX);  // tira espacos vazios
						$CxVrfX = str_replace(' vrf', '', $CxVrfX);  // tira espacos vazios
						$CxVrfX = str_replace('vrf', '', $CxVrfX);  // tira espacos vazios
					}
					

					//---------------- Fim Pegar Vrf -----------------------------------------------//
							
					// Pegar Propriedade do Roteador
					if(str_contains($LinTaRas, 'ROTEADOR')){
						$capROTEADOR = $LinTaRas;
						 
						// Formata/condiciona Mascara de Wan, 
						if( (empty($CxPropRouterX))||(str_contains($CxPropRouterX, 'nao'))) {
							 
							if(str_contains(strToLower($capROTEADOR), 'cliente')){ 
								if(str_contains(strToLower($capROTEADOR), 'cliente=n')){ 
									$CxMaskWanX = '/31'; 
									$tipoConfig = _rtVIVO;
									$CxPropRouterX = 'Roteador Vivo';
								}else{
									$CxMaskWanX = '/30'; 
									$tipoConfig = _rtCLIENTE;
									$CxPropRouterX = 'Roteador Cliente';
								}
																		
							}else if( (str_contains(strToLower($capROTEADOR), 'branca')) 
								|| (str_contains(strToLower($capROTEADOR), 'dataco')) 
								|| (str_contains(strToLower($capROTEADOR), 'huawei')) 
								|| (str_contains(strToLower($capROTEADOR), 'cisco')) 
								|| (str_contains(strToLower($capROTEADOR), 'alcatel')) 
								|| (str_contains(strToLower($capROTEADOR), 'fortinet')) 
								|| (str_contains(strToLower($capROTEADOR), 'branca'))){ 
								$CxMaskWanX = '/31'; 
								$tipoConfig = _rtVIVO;
								$CxPropRouterX = 'Roteador Vivo';
								 
							}else{
								$CxMaskWanX = '/31'; 
								$tipoConfig = _NaoDefinido;
								$CxPropRouterX = 'Roteador nao def.';
								
							}
							
						}	
					}
					
					$TaRascunhoX = str_replace("!!!!!", "<<< Ping OK, 5/5 >>>", $TaRascunhoX);	
					
					$numLinTaRas++;	// incrementa numero da linha 			
				
				} // forecth
		
		
		
				$TaRascunhoX = str_replace("'", "`", $TaRascunhoX);  // tira ' por causa do MySql Injection
				
				// SE ja pegou dados do SWA(na cola NetCompass para o Rascunho), limpa lixo do rascunho
				if(str_contains($edSwaX, '-swa-')){
					$TaRascunhoX = str_replace("hostName:", "", $TaRascunhoX);  
					//$TaRascunhoX = str_replace($edSwaX, "", $TaRascunhoX);  
					$TaRascunhoX = str_replace("ipGatewaySwa:", "", $TaRascunhoX);  			  
					$TaRascunhoX = str_replace("localidade:", "", $TaRascunhoX);  
					$TaRascunhoX = str_replace("mgmtIpAddress:", "", $TaRascunhoX);
					//$TaRascunhoX = str_replace($edSwt_ipX, 'telnet '.$edSwt_ipX, $TaRascunhoX);
					$TaRascunhoX = str_replace("untagged", "", $TaRascunhoX);
					$TaRascunhoX = str_replace("!", "", $TaRascunhoX);
					$TaRascunhoX = str_replace("ethernet 1/5", "ethernet 1-5\n#\n", $TaRascunhoX);
				}
				// Limpa....	
				for($r = 1; $r < 24; $r++){
					$TaRascunhoX = str_replace('interface gigabit-ethernet-1/1/'.$r, "", $TaRascunhoX);
					$TaRascunhoX = str_replace('interface ten-gigabit-ethernet-1/1/'.$r, "", $TaRascunhoX);
				}
			
				//$TaRascunhoX = str_replace(' telnet', 'telnet ', $TaRascunhoX);
				//$TaRascunhoX = str_replace('telnet telnet', 'telnet ', $TaRascunhoX);
				
		 
		
			}else{					
				$TaRascunhoX = '';					
			}	
			//----------------- FIM SCANNEAR RASCUNHO(FORECTH), PEGAR VLANS, -------------------------------------------------// 
	

	

	if(!empty($_POST['CxProduto'])){
		$CxProdutoX = $_POST['CxProduto'];
	}else{					
		$CxProdutoX = 'IPD';					
	}	
	
	if(!empty($_POST['CxOperadora'])){
		$CxOperadoraX = $_POST['CxOperadora'];
	}else{
		$CxOperadoraX ='ERB';
	}
	//-----------  swa, vlan_ger, swt, swt_ip -----------------//

	if(!empty($_POST['edSWT'])){
		$edSwtX = $_POST['edSWT'];
	}else{
		$edSwtX ='';
	}
	
	if(!empty($_POST['edSWA'])){
		$edSwaIniX = $_POST['edSWA'];
		$edSwaX = substr($edSwaIniX, 0, 23);  // Ajusta para tamanho Padrao
		
		// Pre-Preenche SWT baseado no SWA
		
		if($edSwtX == ''){						
			$posFim = strpos($edSwaIniX, '-0') - 1;
			$edSwtX = substr($edSwaIniX, 0, $posFim).'t-00';						
		}
		/*
		if($edSwt_ipX == ''){						
			$posIniT = 23;
			$posFimT = $posIniT + 15;
			$edSwt_ipX = substr($edSwaIniX, $posIniT, $posFimT);
			$edSwt_ipX = substr($edSwt_ipX, 0, 15);  // Ajusta para tamanho Padrao
			$edSwt_ipX = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($edSwt_ipX));
		} */
	}	

	

	if(!empty($_POST['CxPortaTipo'])){
		$CxPortaTipoX = $_POST['CxPortaTipo'];
	}else{
		$CxPortaTipoX ='Eth';
	}
	if(!empty($_POST['CxShelfSwa'])){
		$CxShelfSwaX = $_POST['CxShelfSwa'];
	}else{
		$CxShelfSwaX ='1';
	}
	if(!empty($_POST['CxSlotSwa'])){
		$CxSlotSwaX = $_POST['CxSlotSwa'];
	}else{
		$CxSlotSwaX ='1';
	}
	if(!empty($_POST['CxPortSwa'])){
		$CxPortSwaX = $_POST['CxPortSwa'];
	}else{
		$CxPortSwaX ='Pt';
	}
	//------------RA, Port, Svlan -----------------------------//

	
	if(!empty($_POST['edPort'])){
		$edPortXa = $_POST['edPort'];

		if (str_contains($edPortXa, '-')) {
			$posFim = strpos($edPortXa, '-');
			$edPortXb = substr($edPortXa, 0, $posFim);
		}else{ $edPortXb = $edPortXa; }
		$edPortX = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($edPortXb));
		
	}
	/*
	if(!empty($_POST['CxVrf'])){
		$CxVrfX = $_POST['CxVrf'];					
	}else{					
		$CxVrfX = '';					
	}*/
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
	if(!empty($_POST['CxMaskLAN'])){
		$CxMaskLANX = $_POST['CxMaskLAN'];
	}else{	
		$CxMaskLANX = '/29'; 					
	}		

	if(!empty($_POST['edWAN'])){
		$edWANX = $_POST['edWAN'];
		$edWANX = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($edWANX));
	}else{					
		$edWANX = '';	
	}
	if(!empty($_POST['CxMaskWan'])){
		$CxMaskWanX = $_POST['CxMaskWan'];
	}else{	
		if(str_contains($CxPropRouterX, 'def')){ $CxMaskWanX = '/31'; }					
		else if(str_contains($CxPropRouterX, 'liente')){ $CxMaskWanX = '/30'; }					
		else if(str_contains($CxPropRouterX, 'ivo')){ $CxMaskWanX = '/31'; }					
		else { $CxMaskWanX = '/30'; }					
	}		
	if(!empty($_POST['edLoopBack'])){
		$edLoopBackX = $_POST['edLoopBack'];
		$edLoopBackX = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($edLoopBackX));
	}else{					
		$edLoopBackX = '';					
	}
	if(!empty($_POST['CxMaskLoBk'])){
		$CxMaskLoBkX = $_POST['CxMaskLoBk'];
	}else{	
		$CxMaskLoBkX = '/32'; 					
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
				
	
	if(!empty($_POST['TaReverTunnel'])){
		$TaReverTunnelX = $_POST['TaReverTunnel'];
		$TaReverTunnelX = str_replace("'", "`", $TaReverTunnelX);  // tira ' por causa do MySql Injection

	}else{					
		$TaReverTunnelX = '';					
	}				
	if(!empty($_POST['TaBackBone'])){
		$TaBackBoneX = $_POST['TaBackBone'];
		$TaBackBoneX = str_replace("'", "`", $TaBackBoneX);  // tira ' por causa do MySql Injection

	}else{					
		$TaBackBoneX = '';					
	}				
	if(!empty($_POST['CxNumTicket'])){
		$CxNumTicketX = $_POST['CxNumTicket'];		
	}else{					
		$CxNumTicketX = 'Selecionar';
	}		
	
	if(!empty($_POST['CxRouter'])){
		$CxRouterX = $_POST['CxRouter'];
		//$InterfacePort = $CxInterfaceX.$edPortX; // Junta tipo com Numero da porta
	}else{					
		$CxRouterX = 'Datacom';					
	}	

	if(!empty($_POST['CxInterface'])){
		$CxInterfaceX = $_POST['CxInterface'];
	}else{
		if(str_contains($CxRouterX, 'Nokia')){	$CxInterfaceX = 'sap';	}				
		else{	$CxInterfaceX = '';	}				
	}

	if(isset($_POST['BtSalvar'])){					
	//TAVA APAGAMNDO RESGITSRO NO RE-LOAD(CRIEI PROTECAO NA CLASS.SALVAR))->if( (isset($_POST['BtSalvar']))||(isset($_POST['CxRouter'])) ){ 
	// Esta rotina permite que todos os botoes, Copiar, salvem registro(Maior protecao contra perda de dados)					
	//if( (isset($_POST['BtSalvar']))||(isset($_POST['CxRouter'])) ){ 					
		// Salva registro atual(Atualiza registro) - 1234: senha aleatoria que nao contem autorização de apagar regsitro erroneadmente
		$Res = $ObjTickets->SalvarTicket($CxNumTicketX, $edIDX, $edEmpresaX, $CxProdutoX, $CxTipoX, $edIdFlowX, $edSwaX, $CxEddX, $CxOperadoraX, $edgVlanX, $CxPortaTipoX, $CxShelfSwaX, $CxSlotSwaX, $CxPortSwaX, $edSwtX, $edSwt_ipX, $edRaX, $CxRouterX, $CxInterfaceX, $edPortX, $edSpeedX, $edCtrlVidUnitX, $CxPolicyINX, $CxPolicyOUTX, $CxVrfX, $edsVlanX, $edcVlanX, $edLANX, $edWANX, $CxMaskWanX, $edLoopBackX, $edLAN6X, $edWAN6X, $TaRotasIntragovX, $CxStatusX, $TaRascunhoX, $TaReverTunnelX, $TaBackBoneX, $loadConfig[_TaBBone]);
	}

	$ResolvidosHoje = $ObjTickets->ContaResolvidos();

	if(!$BlockPOST_CxNumTicket){ // caso POST[CxNumTicket] NAO esteja bloqueado pelo Botao AvancarReg...

		if(isset($_POST['CxNumTicket']) || isset($_REQUEST['reg'])){

			if(isset($_REQUEST['reg']) ){
				$RegURL = $_REQUEST['reg'];	
				$CxNumTicketX = '['.$RegURL.']';
				$TicketEmUso = $ObjTickets->QueryTickets($CxNumTicketX, Null, 'REQUEST[reg]');									 
			}else if(isset($_POST['CxNumTicket'])){
				$CxNumTicketX = $_POST['CxNumTicket'];
				$TicketEmUso = $ObjTickets->QueryTickets($CxNumTicketX, Null, 'POST[CxNumTicket]');
			}

			$edIDX = $TicketEmUso[0][_ID];
			$edEmpresaX= $TicketEmUso[0][_Empresa]; 
			$CxProdutoX= $TicketEmUso[0][_Produto]; 
			$CxTipoX= $TicketEmUso[0][_Tipo]; 
			$DataEncX = $TicketEmUso[0][_Data];
			if(str_Contains($DataEncX, '/')){	$edIdFlowX = $DataEncX.', '.$TicketEmUso[0][_IdFlow]; }// Inclui data, dos ja encerrados
			else{ $edIdFlowX = $TicketEmUso[0][_IdFlow];  }
			$edSwaX= strtolower($TicketEmUso[0][_SWA]); 
			$edgVlanX= $TicketEmUso[0][_VlanGer]; 
			$CxShelfSwaX= $TicketEmUso[0][_ShelfSwa]; 
			$CxSlotSwaX= $TicketEmUso[0][_SlotSwa]; 
			$CxPortSwaX= $TicketEmUso[0][_PortSwa]; 
			$CxEddX= $TicketEmUso[0][_EDD]; 
			$CxOperadoraX= $TicketEmUso[0][_OPERADORA]; 
			$edSwtX= strtolower($TicketEmUso[0][_SWT]); 
			$edSwt_ipX= $TicketEmUso[0][_SWT_IP]; 
			$edRaX= $TicketEmUso[0][_RA]; 
			$CxRouterX= $TicketEmUso[0][_Router]; 
			$CxInterfaceX= $TicketEmUso[0][_Interface]; 
			$edPortX= $TicketEmUso[0][_Porta]; 
			$edSpeedX= $TicketEmUso[0][_Speed]; 
			$edCtrlVidUnitX= $TicketEmUso[0][_VidUnit]; 
			$CxPolicyINX= $TicketEmUso[0][_PolicyIN]; 
			$CxPolicyOUTX= $TicketEmUso[0][_PolicyOUT]; 					 
			$CxVrfX= $TicketEmUso[0][_Vrf]; 
			$edsVlanX= $TicketEmUso[0][_sVlan]; 
			$edcVlanX= $TicketEmUso[0][_cVlan]; 
			$edLANX= $TicketEmUso[0][_Lan]; 
			$edWANX= $TicketEmUso[0][_Wan]; 
			$CxMaskWanX= $TicketEmUso[0][_WanFx]; 
			$edLoopBackX= $TicketEmUso[0][_LoopBack]; 
			$edLAN6X= $TicketEmUso[0][_Lan6]; 
			$edWAN6X= $TicketEmUso[0][_Wan6];
			$CxStatusX = $TicketEmUso[0][_Status];			
			$TaRascunhoX = $TicketEmUso[0][_Rascunho]; 
			$TaReverTunnelX = $TicketEmUso[0][_ReverTunnel];
			$TaBackBoneX = $TicketEmUso[0][_Backbone];
			
			
			
		}else{					
			$CxNumTicketX = 'Selecionar';	
								
		}
	} // END IF(bLOCK_post....
	
	

	// Formata/condiciona Mascara de Wan
	if(str_contains(strToLower($CxPropRouterX), 'cliente')){ 
		$tipoConfig = _rtCLIENTE;			
	}else if(str_contains(strToLower($CxPropRouterX), 'vivo')){ 
		$tipoConfig = _rtVIVO;
	}else{
		$tipoConfig = _NaoDefinido;
		$CxPropRouterX = 'Roteador nao def.';
	}

	if(isset($_POST['BtCarimbarValidacao'])){	
		if(str_contains($CxProdutoX, 'VPN')){				
			$TaBackBoneX = $TaBackBoneX."\n\n*** VALIDACAO DE IPs ***\nID CERTIFICADO\nAtividade concluída com sucesso\nID Execução: \n\n*** BBVPN ***\n\n\n*** ".$edSwaX." ***\n\n\nFlow:\n".$edIdFlowX;
		}else{	
			$TaBackBoneX = $TaBackBoneX."\n\n*** VALIDACAO DE IPs ***\nID CERTIFICADO\nAtividade concluída com sucesso\nID Execução: \n\n*** BBIP ***\n\n\n*** ".$edSwaX." ***\n\n\nFlow:\n".$edIdFlowX;
		}
	}
	

	if(isset($_POST['BtCarimboTUNNEL'])){					
		$TaReverTunnelX = $TaReverTunnelX."\n\n=== [SWA] ===\n\n=== [HL5] ===\n\n=== [HL3] ===\n\n=== [RSD] ===\n\n=== [PING] ===\n\n=== [FIM] ===\n";
	}



	// Formata Interface/Port:
	$edPortX = strtolower($edPortX);
	if( (str_contains($edPortX, 'pwe'))
	||  (str_contains($edPortX, 'pw'))
    ||  (str_contains($edPortX, 'pe')) ){
		
		$CxInterfaceX = 'PW-Ether';
	}else if(str_contains($edPortX, 'te')||str_contains($edPortX, '0/6/0')){
		$edPortX = str_replace('te', '', $edPortX); 
		if(empty($CxInterfaceX)){ $CxInterfaceX = 'TenGigE'; }
	}else if((str_contains($edPortX, 'gi')||str_contains($edPortX, 'ge'))){
		$edPortX = str_replace('gi', '', $edPortX); 
		$edPortX = str_replace('ge', '', $edPortX); 
		if(empty($CxInterfaceX)){ $CxInterfaceX = 'GigabitEthernet'; }
	}
	$edPortX = str_replace('pw', '', $edPortX); 
	$edPortX = str_replace('pe', '', $edPortX); 
	$edPortX = str_replace('pwe', '', $edPortX); 
	$edPortX = str_replace('e', '', $edPortX); 


	// Pre-Formata Service-Policy 
	if(empty($CxPolicyINX)){
		if(str_contains($CxRouterX, 'Cisco')){
			$CxPolicyINX = 'IPD_SECURITY_IN_'.$edSpeedX.'M';		
			$CxPolicyOUTX = 'IPD_OUT_'.$edSpeedX.'M_SHAPE';
		}else if(str_contains($CxRouterX, 'Huawei')){
			$CxPolicyINX = 'IPD-SECURITY-IN-'.$edSpeedX.'Mbps'; 
			$CxPolicyOUTX = 'IPD-SECURITY-OUT-'.$edSpeedX.'Mbps'; 
		}else if(str_contains($CxRouterX, 'Juniper')){
			$CxPolicyINX = 'BORDER-POLICER-'.$edSpeedX.'M'; 
			$CxPolicyOUTX = 'BORDER-POLICER-'.$edSpeedX.'M'; 
		}else if(str_contains($CxRouterX, 'Nokia')){
			$CxPolicyINX = 10000 + (int)$edSpeedX; 
			$CxPolicyOUTX = 10000 + (int)$edSpeedX; 
		} 
	}
		
	// Auto complete Ctrl-vid, Unit
	if($edCtrlVidUnitX == '' && $edcVlanX != ''){
		$edCtrlVidUnitX = rand(700, 2000);

		//$edCtrlVidUnitX = '7'.substr($edcVlanX, -2);
	}
	
	$lstTickects = $ObjTickets->QueryTickets(0, _ANALISANDO, 'lstTickects'); // Consulta Tickets abertos, Analisando
	$lstTktNovos = $ObjTickets->QueryTickets(0, _NOVOS, 'lstTktNovos'); // Consulta Tickets abertos, novos
	$lstTktRevisar = $ObjTickets->QueryTickets(0, _REVISAR, 'lstTktRevisar'); // Consulta Tickets abertos, Analisando
	$lstTktEncHoje = $ObjTickets->QueryTickets(0, _HOJE, 'lstTktEncerrados'); // Consulta Tickets abertos, Analisando
	$lstTktEncerrados = $ObjTickets->QueryTickets(0, _ENCERRADOS, 'lstTktEncerrados'); // Consulta Tickets abertos, Analisando
	
	// Auto-Preenche gVlan do Recorte(pego em rotina acima)
	if($edgVlanX == ''){ $edgVlanX = $edgVlanPegaRecorteX; 	}

	
	if(isset($_POST['BtAdicionar'])){
		// Cria 10 Ticket vazio-novo
		for($N=0; $N<10; $N++){
			$MyTickects = $ObjTickets->AddTicket('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
		}
	
	}

	
	if(isset($_POST['BtDuplicar'])){

		// Incrementar 1 a Porta SWA
		$CxPortSwaX_inc1 = (int)$CxPortSwaX+1;

		// Inc 1 ao nome SWT
		$edSwtX_Tam = strlen($edSwtX);	
		$edSwtX_Esq = substr($edSwtX, 0, $edSwtX_Tam-1); 
		$edSwtX_Dir = substr($edSwtX, -1);
		$edSwtX_Dir_Inc1 = $edSwtX_Dir+1;
		$edSwtX_inc1 = $edSwtX_Esq.$edSwtX_Dir_Inc1; 

		// Inc 1 ao IP do SWT
		$edSwt_ipX_Tam = strlen($edSwt_ipX);	
		$edSwt_ipX_Esq = substr($edSwt_ipX, 0, $edSwt_ipX_Tam-1); 
		$edSwt_ipX_Dir = substr($edSwt_ipX, -1);
		$edSwt_ipX_Dir_Inc1 = (int)$edSwt_ipX_Dir+1;
		$edSwt_ipX_inc1 = $edSwt_ipX_Esq.$edSwt_ipX_Dir_Inc1; 
		
		// Inc 1 a Vid/Unit
		$edCtrlVidUnitX_inc1 = (int)$edCtrlVidUnitX+1;

		// Inc 1 a cVlan
		$edcVlanX_inc1 = (int)$edcVlanX+1;

		// Formata rascunho com dados anteriores
		$RascunhoFmt = '\n\n\n*** REGISTRO AUTO-DUPLICADO ***\nOrigem:\nPorta(Swa): '.$CxPortSwaX.'\nNome SWT: '.$edSwtX.'\nIP(Swt):'.$edSwt_ipX.'\ncVlan:'.$edcVlanX.'\n'.$TaRascunhoX;
       
		// Duplicar um registro
		$MyTickects = $ObjTickets->AddTicket('', '', '', $CxProdutoX, $CxTipoX, $edIdFlowX, $edSwaX, $CxEddX, 'ERB', $edgVlanX, $CxShelfSwaX, $CxSlotSwaX, $CxPortSwaX_inc1, 
												$edSwtX_inc1, $edSwt_ipX_inc1, $edRaX, $CxRouterX, $CxInterfaceX, $edPortX, $edSpeedX, 
												$edCtrlVidUnitX_inc1, '', '', $CxVrfX, $edsVlanX, $edcVlanX_inc1, '', '', '',
												'', '', '', '', 'Analisando', $RascunhoFmt, $TaReverTunnelX, '');
	}


	if(isset($_POST['BtDuvida'])){
		?>
			<script>
				alert('Recuperar acessos: \n\n 1-NetCompass:\n Flow: Inicio->BuscaFormulario->Reset Senha Netcompass\n Vem Email de Reset.\n *Confirme se o GAUS esta em dia.\n\n 2-E.Flow:\n No proprio E.Flow->Artefatos->Perfil.');
			</script>
		<?Php

	}

	if(isset($_POST['BtLimpar'])){
		echo '<script type="text/javascript">';				
		echo"window.location.href = 'tickets.php'";
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
		$CxShelfSwaX= ""; 
		$CxSlotSwaX= ""; 
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
		$CxVrfX= ""; 
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
		$MyScript = $ObjScript->Cisco('ASR9K', $edIDX, $edEmpresaX, $CxOperadoraX, $InterfacePort, $edSpeedX, $CxPolicyINX, $CxPolicyOUTX, $CxVrfX, $edsVlanX, $edcVlanX, $edLANX, $edWANX, $CxMaskWanX, $edLoopBackX, $edLAN6X, $edWAN6X, Null, _CFG);  
	}else if($CxRouterX == 'Huawei'){
		// $CxInterfaceX = 'GigabitEthernet'; // So visual, nao altera script
		$MyScript = $ObjScript->Huawei('NE40E_X8A',$edIDX, $edEmpresaX, $CxOperadoraX, $InterfacePort, $edSpeedX, $edCtrlVidUnitX, $CxPolicyINX, $CxPolicyOUTX,  $edsVlanX, $edcVlanX, $edLANX, $edWANX, $CxMaskWanX, $edLoopBackX, $edLAN6X, $edWAN6X, _CFG);  
	
	}else if($CxRouterX == 'Nokia'){
		/*
		if(str_contains($CxInterfaceX,'lag')){ 
			$InterfacePort = $CxInterfaceX.$edPortX;  // Nokia usa descricao da porta tipo lag-
		}else{
			$CxInterfaceX = ''; // Nokia nao usa descricao da porta
			$InterfacePort = $edPortX;
		} */
		//$InterfacePort = $InterfacePort.'-xyz';
		//echo  'Tkt:'.$InterfacePort.', ';
		$MyScript = $ObjScript->Nokia('SR7750_QoS', $edIDX, $edEmpresaX, $CxOperadoraX, $InterfacePort, $edSpeedX, $CxPolicyINX, $CxPolicyOUTX, $edsVlanX, $edcVlanX, $edLANX, $edWANX, $CxMaskWanX, $edLoopBackX, $edLAN6X, $edWAN6X, _CFG, 'ID');  // Este 'ID' e tipo de ies config no Nokia, mas nao usa aqui
	
	}else if($CxRouterX == 'Juniper'){						
		$MyScript = $ObjScript->Juniper('MX480', $edIDX, $edEmpresaX, $CxOperadoraX, $InterfacePort, $edSpeedX, $edCtrlVidUnitX, $CxPolicyINX, $CxPolicyOUTX, $CxVrfX, $edsVlanX, $edcVlanX, $edLANX, $edWANX, $CxMaskWanX, $edLoopBackX, $edLAN6X, $edWAN6X, _CFG);  
	}else if($CxRouterX == 'Datacom'){	
		// Null, aqui seria UpLink do Coriant, nao usa aqui					
		$MyScript = $ObjScript->Datacom($CxEddX, $edIDX, $edEmpresaX, $edSwaX, Null, $CxPortaTipoX, $CxShelfSwaX, $CxSlotSwaX, $CxPortSwaX, Null, $edSwtX, $edSwt_ipX, $edgVlanX, $edRaX, $edPortX, $edsVlanX, Null, $edcVlanX, $edSpeedX, _CFG, $CxProdutoX);  
	}
	$IntPortaY =   $CxInterfaceX.$edPortX;
	$ReverTunnel = $ObjScript->cmdReverTunnel($edLANX, $edWANX, $edLoopBackX, $IntPortaY, $edsVlanX); 
	
	// faz a leitura dos Checks executados(Config SWA, Cad.ERB, Certificacao de Ips, Config BBone)
	$CheckTaBackBoneX = $ObjTickets->LoadBackbone($CxNumTicketX);

	// Mensagem de aviso Renovacao de Senhas
	
	if(Date("d") == '30'){ ?>
		<script>						
			setTimeout(function(){
				msgRenovarGaus();
			}, 1000);
			//alert("Atencao! Renovar acessos no GAUS.\n\n\n https://gaus.vivo.com.br/login\n (lg: 80969577, sn: rede)");
		</script>
	<?Php
		//$ObjFuncao->Mensagem('Atencao!', 'Renovar acessos do GAUS.', Null, Null, defAviso, defAtencao);
	}			

	// Ajuste de posicoes do layout-Tunnel na tela
	$ajtTop = 80;
	$ajtLeft = 20;
	

	include_once("resources/css/layoutTunnel.php");
	include_once("resources/css/placas.php");
?>

<body BGCOLOR="<?Php echo"$ThemeCorFundoBody"; ?>"><!-- BACKGROUND="PParede/cristal.png" --> 	
<div id="geral"><!-- Pagina Geral -->
	<br><!-- Ajuste para robo -->
	<table class="TAB_Geral" width="100%" align="center" valign="top">
	
	
	<?Php 
		// Avisos/Lembretes
		include_once("resources/avisos.php"); 
	?>

		
	<?Php
		//----------------------------INI  DESENHO DO lAYOUT DE tUNNEL ------------------------------------------------//
		
		$Rsd = '';
		$Hl3_gwC = '';
		$HeadHl3_gwC = '';
		$Hl5_gwD = '';
		$IntUpLinkSwa = '';
		$CnxUpLink = 'Fibra';
		$IdMplsHL5 = 'Mpls`s';
		$IdMplsRsd = 'Mpls`s';
		$IpsHlx0ToRsd = '[P/ Rsd ]->';		
		$IpsRsdToHlx0 = '<-[P/ hlx0 ]';

		$vlanCnxUpLink = $edsVlanX.'.'.$edcVlanX;

		// Ctrl(abre/fecha), capturas de linhas dentro dos blocos
		$enableCapSwa = false;
		$enableCapHl3 = false;
		$enableCapHl4 = false;
		$enableCapHl5 = false;
		$enableCapRsd = false;
		$enableCapPing = false;
		$enableCapFim = false;
		/*
		$capTxtSwa[$v] = '';
		$capTxtHl3[$v] = '';
		$capTxtHl5[$v] = '';
		$capTxtRsd[$v] = '';
		$capTxtPing[$v] = ''; */

		$capTxtSwa = '';
		$capTxtHl3 = '';
		$capTxtHl4 = '';
		$capTxtHl5 = '';
		$capTxtRsd = '';
		$capTxtPing = '';

		$tituloHl3 = 'Hl3g';
		$tituloHl5 = 'Hl5g';
		$tituloRsd = 'Hl5g';
		$rodapeHl3 = '';
		$rodapeHl5 = '';
		$rodapeRsd = '';
		$rodapeSwa = '';

		$fxIpSwa = '';
		$fxIpHl5 = '';
		$fxIpHl4 = '';
		$fxIpHl3 = '';
		$fxIpRsd = '';

		$v = 0;
		$ExplodeTaTunnel = explode("\n", $TaReverTunnelX);	
		
		foreach($ExplodeTaTunnel as $LinTaTunnel){

			//---------- iNI Converte antigos------------------------------------------------//
			if(str_contains( $LinTaTunnel, '=== SWA')){ 
				$LinTaTunnel = str_replace('=== SWA', "=== [SWA]", $LinTaTunnel);
			}
			if(str_contains( $LinTaTunnel, '=== GWx')){ 
				$LinTaTunnel = str_replace('=== GWx/HLXx', "=== [HL5]", $LinTaTunnel);
			}
			if(str_contains( $LinTaTunnel, '=== RSD ')){ 
				$LinTaTunnel = str_replace('=== RSD ', "=== [RSD]", $LinTaTunnel);
			}
			if(str_contains( $LinTaTunnel, '=== PING')){ 
				$LinTaTunnel = str_replace('=== PINGs', "=== [PING]", $LinTaTunnel);
			}
			if(str_contains( $LinTaTunnel, '= Para')){ 
				$LinTaTunnel = str_replace('= Para', "=== [FIM] === <br> = Para", $LinTaTunnel);
			}

			if(str_contains( $LinTaTunnel, '### SWA')){ 
				$LinTaTunnel = str_replace('### SWA', "=== [SWA]", $LinTaTunnel);
			}
			if(str_contains( $LinTaTunnel, '### GWC')){ 
				$LinTaTunnel = str_replace('### GWC', "=== [HL3]", $LinTaTunnel);
			}
			if(str_contains( $LinTaTunnel, '### HL5G')){ 
				$LinTaTunnel = str_replace('### HL5G', "=== [HL5]", $LinTaTunnel);
			}
			if(str_contains( $LinTaTunnel, '### RSD ')){ 
				$LinTaTunnel = str_replace('### RSD ', "=== [RSD]", $LinTaTunnel);
			}
			if(str_contains( $LinTaTunnel, '### PING')){ 
				$LinTaTunnel = str_replace('### PINGs', "=== [PING]", $LinTaTunnel);
			}
			if(str_contains( $LinTaTunnel, '= Para')){ 
				$LinTaTunnel = str_replace('= Para', "=== [FIM] === <br> = Para", $LinTaTunnel);
			}
			//---------- Fim Converte antigos------------------------------------------------//


			// Ctrl(abre/fecha), capturas de linhas dentro dos blocos
			if(str_contains( $LinTaTunnel, '[SWA')){ 
				$enableCapSwa = true;
				$enableCapHl3 = false;
				$enableCapHl4 = false;
				$enableCapHl5 = false;
				$enableCapRsd = false;
				$enableCapPing = false;
				$enableCapFim = false;

				// Pega IPs, desenha fluxo	
				$posIniFxSwa = strpos($LinTaTunnel, '[SWA');
				$posFimFxSwa = strpos($LinTaTunnel, '===') - 4;
				$fxIpSwa = substr($LinTaTunnel, $posIniFxSwa, $posFimFxSwa).$edSwt_ipX.']';
			}
			if(str_contains( $LinTaTunnel, '[HL3')){ 
				$enableCapSwa = false;
				$enableCapHl3 = true;
				$enableCapHl4 = false;
				$enableCapHl5 = false;
				$enableCapRsd = false;
				$enableCapPing = false;
				$enableCapFim = false;
				
				// Pega IPs, desenha fluxo	
				$posIniFxHl3 = strpos($LinTaTunnel, '[HL3');
				$posFimFxHl3 = strpos($LinTaTunnel, '===')-4;
				$fxIpHl3 = substr($LinTaTunnel, $posIniFxHl3, $posFimFxHl3);
			 
			}
			if(str_contains( $LinTaTunnel, '[HL4')){ 
				$enableCapSwa = false;
				$enableCapHl3 = false;
				$enableCapHl4 = true;
				$enableCapHl5 = false;
				$enableCapRsd = false;
				$enableCapPing = false;
				$enableCapFim = false;
				
				// Pega IPs, desenha fluxo	
				$posIniFxHl4 = strpos($LinTaTunnel, '[HL4');
				$posFimFxHl4 = strpos($LinTaTunnel, '===')-4;
				$fxIpHl4 = substr($LinTaTunnel, $posIniFxHl4, $posFimFxHl4);
			}
			if(str_contains( $LinTaTunnel, '[HL5')){ 
				$enableCapSwa = false;
				$enableCapHl3 = false;
				$enableCapHl4 = false;
				$enableCapHl5 = true;
				$enableCapRsd = false;
				$enableCapPing = false;
				$enableCapFim = false;

				// Pega IPs, desenha fluxo	
				$posIniFxHl5 = strpos($LinTaTunnel, '[HL5');
				$posFimFxHl5 = strpos($LinTaTunnel, ' ===')-4;
				$fxIpHl5 = substr($LinTaTunnel, $posIniFxHl5, $posFimFxHl5);
			 }
			if(str_contains( $LinTaTunnel, '[RSD')){ 
				$enableCapSwa = false;
				$enableCapHl3 = false;
				$enableCapHl4 = false;
				$enableCapHl5 = false;
				$enableCapRsd = true;
				$enableCapPing = false;
				$enableCapFim = false;

				// Pega IPs, desenha fluxo	
				$posIniFxRsd = strpos($LinTaTunnel, '[RSD');
				$posFimFxRsd = strpos($LinTaTunnel, '===')-4;
				$fxIpRsd = substr($LinTaTunnel, $posIniFxRsd, $posFimFxRsd);
			 }
			if(str_contains( $LinTaTunnel, '[PIN')){ 
				$enableCapSwa = false;
				$enableCapHl3 = false;
				$enableCapHl4 = false;
				$enableCapHl5 = false;
				$enableCapRsd = false;
				$enableCapPing = true;
				$enableCapFim = false;
			 }
			if(str_contains( $LinTaTunnel, '[FIM')){ 
				$enableCapSwa = false;
				$enableCapHl3 = false;
				$enableCapHl4 = false;
				$enableCapHl5 = false;
				$enableCapRsd = false;
				$enableCapPing = false;
				$enableCapFim = false;
			 }

			 // Captura linhas/incrementa contagem da Linha, Separa cada bloco em vetores distintos
			 if($enableCapSwa){ $capTxtSwa = $capTxtSwa.$LinTaTunnel; }
			 if($enableCapHl3){ $capTxtHl3 =  $capTxtHl3.$LinTaTunnel; }
			 if($enableCapHl4){ $capTxtHl4 =  $capTxtHl4.$LinTaTunnel; }
			 if($enableCapHl5){ $capTxtHl5 = $capTxtHl5.$LinTaTunnel; }
			 if($enableCapRsd){ $capTxtRsd = $capTxtRsd.$LinTaTunnel; }
			 if($enableCapPing){ $capTxtPing = $capTxtPing.$LinTaTunnel; }

			$v++;
		} // foreach

		//------------------ Formata CapturaSWA ------------------------------------------------------------//
			// SE Pegou no INT DESC swa: eth 1/1/1 IP_ULK@FIBRA@i-br-pr-sjp-ymg-hl5g-01@186.246.137.205@0/2/8@1G@
			$capTxtSwa = str_replace('=== [SWA] ===', "", $capTxtSwa);
			$capTxtSwa = str_replace('#', "<br>", $capTxtSwa);
			$capTxtSwa = str_replace('@', "<br>", $capTxtSwa);

			// Pega Rodapé Swa(Swa ->(IP)->Hl3/5 )
			if(str_contains($capTxtSwa, '.')){ // XXX.XXX.XXX.XXX
				$posInirodapeSwa = strpos($capTxtSwa, '.')-3;	
				$rodapeSwa = substr($capTxtSwa, $posInirodapeSwa, 18);
			}

		//------------------ Formata CapturaHl5 ------------------------------------------------------------//
		
			//$Hl3_gwC = str_replace('l2', "<br> l2", $Hl3_gwC);
			$capTxtHl5 = str_replace('=== [HL5/GWD] ===', "", $capTxtHl5); // Tira
			$capTxtHl5 = str_replace('=== [HL5] ===', "", $capTxtHl5); // Tira
			$capTxtHl5 = str_replace('>>>', "", $capTxtHl5); // Tira

			// Pula linhas após....
			$capTxtHl5 = str_replace('vlan', "<br> vlan", $capTxtHl5);
			$capTxtHl5 = str_replace('mpls l2v', "<br> mpls l2v", $capTxtHl5);
			$capTxtHl5 = str_replace('l2vpn', "<br> l2vpn", $capTxtHl5);
			$capTxtHl5 = str_replace('l2transport', "<br> l2transport", $capTxtHl5);
			$capTxtHl5 = str_replace('ipv4', "ipv4(RSD)", $capTxtHl5);
			$capTxtHl5 = str_replace('neighbor', "<br> neighbor", $capTxtHl5);			
			$capTxtHl5 = str_replace('interface', "<br> interface", $capTxtHl5);
			$capTxtHl5 = str_replace('i-br-', "<br> i-br-", $capTxtHl5);
			$capTxtHl5 = str_replace('service', "<br> sertvice", $capTxtHl5);
			$capTxtHl5 = str_replace('spoke', "<br> spoke", $capTxtHl5);
			$capTxtHl5 = str_replace('peer', "<br> peer", $capTxtHl5);
			$capTxtHl5 = str_replace('#', "<br>", $capTxtHl5);
			$capTxtHl5 = str_replace('@', "<br>", $capTxtHl5);

			// Pega titulo(nome) da CX da linha HL5
			if(str_contains($capTxtHl5, 'hl')){
				$posNomeFimHl5 = strpos($capTxtHl5, 'hl')-5;	// i-br-pa-blm-mcg-hl5g-01
				$posNomeIniHl5 = $posNomeFimHl5 -11; 	
				$tituloHl5 = substr($capTxtHl5, $posNomeIniHl5, $posNomeFimHl5);				
			}
			if(str_contains($capTxtHl5, 'mpls l2v')){
				$posInirodapeHl5 = strpos($capTxtHl5, 'mpls l2v');	
				$rodapeHl5 = substr($capTxtHl5, $posInirodapeHl5, 35);
			}else if(str_contains($capTxtHl5, 'neighbor')){	
				$posInirodapeHl5 = strpos($capTxtHl5, 'neighbor');	
				$rodapeHl5 = substr($capTxtHl5, $posInirodapeHl5, 43);
			}	
			
			// Pega-Lê ID-MPLS do HL5G/Hl3_gwC
			if(str_contains($capTxtHl5, '41'.$edsVlanX)){ $IdMplsHL5 = '41'.$edsVlanX; }
			if(str_contains($capTxtHl5, '42'.$edsVlanX)){ $IdMplsHL5 = '42'.$edsVlanX; }
			if(str_contains($capTxtHl5, '43'.$edsVlanX)){ $IdMplsHL5 = '43'.$edsVlanX; }

		
		//------------------ Formata CapturaHl3 ------------------------------------------------------------//

			//$Hl3_gwC = str_replace('l2', "<br> l2", $Hl3_gwC);
			$capTxtHl3 = str_replace('=== [HL3/GWD] ===', "", $capTxtHl3); // Tira
			$capTxtHl3 = str_replace('=== [HL3] ===', "", $capTxtHl3); // Tira
			$capTxtHl3 = str_replace('>>>', "", $capTxtHl3); // Tira

			// Pular linhas apos...
			$capTxtHl3 = str_replace('vlan', "<br> vlan", $capTxtHl3);
			$capTxtHl3 = str_replace('mpls l2v', "<br> mpls l2v", $capTxtHl3);
			$capTxtHl3 = str_replace('l2vpn', "<br> l2vpn", $capTxtHl3);
			$capTxtHl3 = str_replace('l2transport', "<br> l2transport", $capTxtHl3);
			$capTxtHl3 = str_replace('ipv4', "ipv4(RSD)", $capTxtHl3);
			$capTxtHl3 = str_replace('neighbor', "<br> neighbor", $capTxtHl3);
			$capTxtHl3 = str_replace('interface', "<br> interface", $capTxtHl3);
			$capTxtHl3 = str_replace('i-br-', "<br> i-br-", $capTxtHl3);
			$capTxtHl3 = str_replace('service', "<br> sertvice", $capTxtHl3);
			$capTxtHl3 = str_replace('spoke', "<br> spoke", $capTxtHl3);
			$capTxtHl3 = str_replace('peer', "<br> peer", $capTxtHl3);
			$capTxtHl3 = str_replace('#', "<br>", $capTxtHl3);
			$capTxtHl3 = str_replace('@', "<br>", $capTxtHl3);

			// Pega titulo(nome) da CX da linha Hl3
			if(str_contains($capTxtHl3, 'hl')){
				$posNomeFimHl3 = strpos($capTxtHl3, 'hl')-5;	// i-br-pa-blm-mcg-Hl3g-01
				$posNomeIniHl3 = $posNomeFimHl3 -11; 	
				$tituloHl3 = substr($capTxtHl3, $posNomeIniHl3, $posNomeFimHl3);				
			}
			if(str_contains($capTxtHl3, 'mpls l2v')){
				$posInirodapeHl3 = strpos($capTxtHl3, 'mpls l2v');	
				$rodapeHl3 = substr($capTxtHl3, $posInirodapeHl3, 35);
			}else if(str_contains($capTxtHl3, 'neighbor')){	
				$posInirodapeHl3 = strpos($capTxtHl3, 'neighbor');	
				$rodapeHl3 = substr($capTxtHl3, $posInirodapeHl3, 43);
			}
			
			// Pega-Lê ID-MPLS do HL5G/Hl3_gwC
			if(str_contains($capTxtHl3, '41'.$edsVlanX)){ $IdMplsHL3 = '41'.$edsVlanX; }
			if(str_contains($capTxtHl3, '42'.$edsVlanX)){ $IdMplsHL3 = '42'.$edsVlanX; }
			if(str_contains($capTxtHl3, '43'.$edsVlanX)){ $IdMplsHL3 = '43'.$edsVlanX; }

		//------------------ Ini Formata CapturaRsd ------------------------------------------------------------//
		//$Rsd_gwC = str_replace('l2', "<br> l2", $Rsd_gwC);
		$capTxtRsd = str_replace('=== [RSD] ===', "", $capTxtRsd); // Tira
		$capTxtRsd = str_replace('>>>', "", $capTxtRsd); // Tira
		
		// Pular linhas apos...
		$capTxtRsd = str_replace('vlan', "<br> vlan", $capTxtRsd);
		$capTxtRsd = str_replace('mpls l2v', "<br> mpls l2v", $capTxtRsd);
		$capTxtRsd = str_replace('l2vpn', "<br> l2vpn", $capTxtRsd);
		$capTxtRsd = str_replace('l2transport', "<br> l2transport", $capTxtRsd);
		$capTxtRsd = str_replace('ipv4', "ipv4(hl5x)", $capTxtRsd);
		$capTxtRsd = str_replace('neighbor', "<br> neighbor", $capTxtRsd);
		$capTxtRsd = str_replace('interface', "<br> interface", $capTxtRsd);
		$capTxtRsd = str_replace('i-br-', "<br> i-br-", $capTxtRsd);
		$capTxtRsd = str_replace('service', "<br> sertvice", $capTxtRsd);
		$capTxtRsd = str_replace('spoke', "<br> spoke", $capTxtRsd);
		$capTxtRsd = str_replace('peer', "<br> peer", $capTxtRsd);
		$capTxtRsd = str_replace('#', "<br>", $capTxtRsd);
		$capTxtRsd = str_replace('@', "<br>", $capTxtRsd);
		$capTxtRsd = str_replace('Type', "<br> Type", $capTxtRsd);
		$capTxtRsd = str_replace('Sending', "<br> Sending", $capTxtRsd);
		$capTxtRsd = str_replace('!!!!!', "<br> !!!!!", $capTxtRsd);
		$capTxtRsd = str_replace('Success', "<br> Success", $capTxtRsd);
		$capTxtRsd = str_replace('interface', "<br>", $capTxtRsd);

		// Pega Rodapé Rsd(Rsd ->(ip)->Hl3/5 )
		if(str_contains($capTxtRsd, 'mpls l2v')){
			$posInirodapeRsd = strpos($capTxtRsd, 'mpls l2v');	
			$rodapeRsd = substr($capTxtRsd, $posInirodapeRsd, 35);
		}else if(str_contains($capTxtRsd, 'neighbor')){	
			$posInirodapeRsd = strpos($capTxtRsd, 'neighbor');	
			$rodapeRsd = substr($capTxtRsd, $posInirodapeRsd, 43);
		}	
	
		// Pega-Lê ID-MPLS do RSD
		if(str_contains($capTxtRsd, '41'.$edsVlanX)){ $IdMplsRsd = '41'.$edsVlanX; }
		if(str_contains($capTxtRsd, '42'.$edsVlanX)){ $IdMplsRsd = '42'.$edsVlanX; }
		if(str_contains($capTxtRsd, '43'.$edsVlanX)){ $IdMplsRsd = '43'.$edsVlanX; }

		
		//------------------ Ini Formata CapturaPing ------------------------------------------------------------//

		// Pega teste Ping
		$LinPing[] = '';
		$ResLinPing = '';
		$capTxtRsd = str_replace('vlan', "<br> vlan", $capTxtRsd);
		/*
		if(str_contains($capTxtPing, 'ping')){		// RP/0/RSP0/CPU0:i-br-pa-blm-ccp-rsd-01#ping 
			$posIniPing = strpos($capTxtPing, 'ping');
			if(str_contains($capTxtPing, '252')){	
				$posFimPing = strpos($capTxtPing, '252');	//round-trip min/avg/max = 1/1/1 ms	
			}else if(str_contains($capTxtPing, '254')){	
				$posFimPing = strpos($capTxtPing, '254');	//round-trip min/avg/max = 1/1/1 ms	
			
			}else if(str_contains($capTxtPing, 'trip')){	
				$posFimPing = strpos($capTxtPing, 'avg');	//round-trip min/avg/max = 1/1/1 ms	
			}
			$ResLinPing = substr($capTxtPing, $posIniPing, $posFimPing);
		*/	
			// Pular linha
			$capTxtPing = str_replace('Type', "<br> Type", $capTxtPing);
			$capTxtPing = str_replace('Sending', "<br> Sending", $capTxtPing);
			$capTxtPing = str_replace('!!!!!', "<br> !!!!!", $capTxtPing);
			$capTxtPing = str_replace('Success', "<br> Success", $capTxtPing);
			$capTxtPing = str_replace('interface', "<br>", $capTxtPing);
			$capTxtPing = str_replace('Reply', "<br> Reply", $capTxtPing);

		//}	
		
		
		//------------------ Fim Formata CapturaPing ------------------------------------------------------------//
			
		if(isset($_POST['BtShowTUNNEL'])){	
		?>
				<!-------------------- Folha em Branco, Fundo --------------------------------------->
				<div class="bloco" id="folha" title="<?Php printf("Layout Tunnel(MPLS)"); ?>">				
					<?php printf("Layout de vlans/Mpls/Tunnel"); echo "<br>"; ?>	
				</div>
				<!-------------------- Ping --------------------------------------------------------->
				<div class="bloco" id="corpo-ping" title="<?Php printf("%s", $capTxtPing); ?>">				
					<?php printf("%s", $capTxtPing); echo "<br>"; ?>	
				</div>
				<!-------------------- RSD/RAI/RAV --------------------------------------------------->
				<div class="bloco" id="fibra-rsd" title="<?Php printf("%s",  $CnxUpLink); ?>">	
					<?php printf("%s",  $CnxUpLink); echo "<br>"; ?>	
				</div>
				<div class="bloco" id="mpls-rsd" title="<?Php printf("%s",  $IdMplsRsd); ?>">	
					<?php printf("%s",  $IdMplsRsd); echo "<br>"; ?>	
				</div>
				<div class="bloco" id="vlan-rsd" title="<?Php printf("%s",  $vlanCnxUpLink); ?>">	
					<?php printf("%s",  $vlanCnxUpLink); echo "<br>"; ?>	
				</div>
			
				<div class="bloco" id="titulo-rsd" title="<?Php printf("B.Bone: %s",  $edRaX); ?>">					
					<?php 
						printf("B.Bone: %s %s%s",  $edRaX, $CxInterfaceX, $edPortX); 
						echo "<br>";
					?>						
				</div>
				<div class="bloco" id="corpo-rsd" title="<?Php printf("B.Bone: %s",  $capTxtRsd); ?>">						
					<?php printf("%s",  $capTxtRsd); echo "<br>";	?>	
				</div>
				<div class="bloco" id="rodape-rsd" title="<?Php printf("P/.HlX0: %s",  $rodapeRsd); ?>">						
					<?php printf("%s", $rodapeRsd); echo "<br>";	?>	
				</div>

				<!--------------------- HL3/GWC -------------------------------------------------------------->
				<div class="bloco" id="fibra-hl3Gwc" title="<?Php printf("%s",  $CnxUpLink); ?>">	
					<?php printf("%s",  $CnxUpLink); echo "<br>"; ?>	
				</div>
				<div class="bloco" id="mpls-hl3Gwc" title="<?Php printf("%s",  $IdMplsHL5); ?>">	
					<?php printf("%s",  $IdMplsHL5); echo "<br>"; ?>	
				</div>				
				<div class="bloco" id="vlan-hl3Gwc" title="<?Php printf("%s",  $vlanCnxUpLink); ?>">	
					<?php printf("%s",  $vlanCnxUpLink); echo "<br>"; ?>	
				</div>
				<div class="bloco" id="titulo-hl3Gwc" title="<?Php printf("Hl3_gwC: %s",  $tituloHl3); ?>">					
					<?php printf("HLXx/GWC: %s",  $tituloHl3); echo "<br>"; ?>	
				</div>
				<div class="bloco" id="corpo-hl3Gwc" title="<?Php printf("Hl3_gwC: %s",  $capTxtHl3); ?>">					
					<?php printf("%s",  $capTxtHl3); echo "<br>"; ?>	
				</div>
				<div class="bloco" id="rodape-hl3Gwc" title="<?Php printf("P/.HlX0: %s", $rodapeHl3); ?>">						
					<?php printf("%s", $rodapeHl3); echo "<br>";	?>	
				</div>

				<!----------------------- HL5/GWD ------------------------------------------------------------->
				<div class="bloco" id="fibra-hl5Gwd" title="<?Php printf("%s",  $CnxUpLink); ?>">	
					<?php printf("%s",  $CnxUpLink); echo "<br>"; ?>	
				</div>
				<div class="bloco" id="vlan-hl5Gwd" title="<?Php printf("%s",  $vlanCnxUpLink); ?>">	
					<?php printf("%s",  $vlanCnxUpLink); echo "<br>"; ?>	
				</div>				
				<div class="bloco" id="titulo-hl5Gwd" title="<?Php printf("Hl5_gwD: %s",  $tituloHl5); ?>">					
					<?php printf("HL5x/GWD: %s",  $tituloHl5); echo "<br>"; ?>	
				</div>
				<div class="bloco" id="corpo-hl5Gwd" title="<?Php printf("Hl5_gwD: %s",  $capTxtHl5); ?>">					
					<?php printf("%s",  $capTxtHl5); echo "<br>"; ?>	
				</div>
				<div class="bloco" id="rodape-hl5Gwd" title="<?Php printf("P/.HlX0: %s",  $rodapeHl5); ?>">						
					<?php printf("%s", $rodapeHl5); echo "<br>";	?>	
				</div>

				<!------------------------ SWA ----------------------------------------------------------------->
				<div class="bloco" id="titulo-swa" title="<?Php printf("SWA: %s", $edSwaX); ?>">	
					<?php printf("%s",  $edSwaX); echo "<br>"; ?>	
				</div>				
				<div class="bloco" id="corpo-swa" title="<?Php printf("UpLink: %s", $capTxtSwa); ?>">
                		<?php printf("%s",  $capTxtSwa); echo "<br>"; ?>
				</div>
				<div class="bloco" id="rodape-swa" title="<?Php printf("UpLink: %s", $rodapeSwa); ?>">
					<?php printf("%s",  $rodapeSwa); echo "<br>"; ?>	
				</div>
				<div class="bloco" id="svlan-swa" title="<?Php printf("sVlan: %s", $edsVlanX); ?>">	
					<?php printf("%s",  $edsVlanX); echo "<br>"; ?>	
				</div>
				<div class="bloco" id="cvlan-swa" title="<?Php printf("cVlan: %s", $edcVlanX); ?>">	
					<?php printf("%s",  $edcVlanX); echo "<br>"; ?>	
				</div>
				
				<div class="bloco" id="pathTunnel" title="<?Php //printf("%s", $TunnelPath); ?>">	
					<?php
						printf("%s <=> %s <=> %s <=> %s <=> %s", $fxIpSwa, $fxIpHl5, $fxIpHl4, $fxIpHl3, $fxIpRsd);
						echo "<br>";
					?>	
				</div> 
		<?Php 
			} // BtShowTUNNEL
		//----------------------------fim  DESENHO DO LAYOUT DE TUNNEL ------------------------------------------------//
	 
		?>	

	<!-- <form name="LocalizarTickets" method="post" action="localizar_tickets.php">--><!-- Form Localizar, inserido aqui devido espa�os que cria no IE -->
	<tr align="center"  height="50" valign="top">
	
	<!-------------------------------- Inicio Geral Esquerdo -------------------------------------------------------------------->
	
	<td width="20%" colspan="1"  align="center"  height="5" valign="top">
	
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
			<!------------------------ Ini Placar de Projecao ----------------------------------------------->
			<div class="placa" id="projecao">        
				<input i class="fa fa-search" type="image" src="imagens/icon/calcule.ico" title="Calculo: Resolvidos/Tempo em min/Projeção" style="max-widht:30px; max-height:30px;">									 									
				&nbsp;&nbsp;&nbsp;
				<?Php printf(" r%s..%.0f'..p%s ", (int)$ResolvidosHoje[_nRESOLVIDOS], (int)$ResolvidosHoje[_MEDIA], (int)$ResolvidosHoje[_PROJECAO]); /*ceil: TIRA NUM APOS VIRGULA*/?>
			</div>
			<!-------------------------- Final Placar de Projecao -------------------------------------------->

			<tr align="center"  height="5" valign="top">			
			<td width="20" colspan="1"  align="left"  height="5" valign="top">		
			<!---------------------------------------------------------------------------------------------------->
				<!------------------------ Linha - Ini Menu Esquerdo ----------------------------------------------
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php $ObjFuncao->espaco(2); ?>
						<img border="0" src="imagens/<?Php echo"$ThemeCorLinhaMenu"; ?>" width="155" height="15">
					</td>
				</tr>
				------------------------ Linha - Fim ---------------------------------------------------->
				
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
				<!------------------------ Linha - Ini Esteira Esquerda ---------------------------------
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php $ObjFuncao->espaco(2); ?>
						<img border="0" src="imagens/<?Php echo"$ThemeCorLinhaMenu"; ?>" width="155" height="15">
					</td>
				</tr>
				----------------------- Linha - Fim ---------------------------------------------------->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php $ObjFuncao->espaco(3); ?>
						<!--<a href="<?Php echo"$AttribMenuLinguaLink00";?>" class="fonte_item_menu">-->
						<div class="placa" id="esteira">
							<input i class="fa fa-search" type="image" src="imagens/icon/farol.ico" title="Farol" style="max-widht:30px; max-height:30px;">                                                      
							<?Php echo"$AttribMenuLingua00";?>
						</div>
						<!--</a>-->
					</td>
				</tr>
				<!-- Check Config SWA -->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
						<!-- <a href="<?Php echo"$AttribMenuLinguaLink01";?>" class="fonte_menu_esq">-->
						<?Php if(str_contains($CheckTaBackBoneX, 'swa')){ ?>	
							<input i class="fa fa-search" type="image" src="imagens/icon/checked.ico" title="Checked" style="max-widht:20px; max-height:20px;">                                                      
						<?Php }else{ ?>
							<input i class="fa fa-search" type="image" src="imagens/icon/no_checked.ico" title="No_checked" style="max-widht:20px; max-height:20px;">                                                      
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
								<input i class="fa fa-search" type="image" src="imagens/icon/lampada.ico" title="Lampada" style="max-widht:20px; max-height:20px;">                                                      
							<?Php							
							}else if(str_contains($CheckTaBackBoneX, 'Planej')){ 
								$AttribMenuLingua02 = "NetC: Planejado";
							?>								
								<input i class="fa fa-search" type="image" src="imagens/icon/planejado.ico" title="Planejado" style="max-widht:20px; max-height:20px;">                                                      
							<?Php
							}else if((str_contains($CheckTaBackBoneX, 'Processo'))||(str_contains($CheckTaBackBoneX, 'ordemId'))){ 
								$AttribMenuLingua02 = "NetC: Up";
						?>
							<input i class="fa fa-search" type="image" src="imagens/icon/checked.ico" title="Checked" style="max-widht:20px; max-height:20px;">                                                      
						<?Php }else{ ?>
							<input i class="fa fa-search" type="image" src="imagens/icon/no_checked.ico" title="No-checked" style="max-widht:20px; max-height:20px;">                                                      
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
						<?Php 	if( (str_contains($CheckTaBackBoneX, '97')) 
								|| 	(str_contains($CheckTaBackBoneX, '98')) 
								|| 	(str_contains($CheckTaBackBoneX, '99')) 	
								|| 	(str_contains($CheckTaBackBoneX, '100')) 
								|| 	(str_contains($CheckTaBackBoneX, '101')) 
								|| 	(str_contains($CheckTaBackBoneX, '102')) 
								|| 	(str_contains($CheckTaBackBoneX, '103')) 
								|| 	(str_contains($CheckTaBackBoneX, '104')) 
								|| 	(str_contains($CheckTaBackBoneX, '105'))
								){ ?>	
							<input i class="fa fa-search" type="image" src="imagens/icon/checked.ico" title="Checked" style="max-widht:20px; max-height:20px;">                                                      
						<?Php }else{ ?>
							<input i class="fa fa-search" type="image" src="imagens/icon/no_checked.ico" title="No_checked" style="max-widht:20px; max-height:20px;">                                                      
						<?Php } ?>
					
						<?Php echo"$AttribMenuLingua03";?><!-- IP Validado --> 
						<!--</a>-->
					</td>
				</tr>
				<!-- Check Config backbone -->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
						<!--<a href="<?Php echo"$AttribMenuLinguaLink04";?>" class="fonte_menu_esq">-->
						<?Php if(str_contains($CheckTaBackBoneX, 'address')){ ?>	
							<input i class="fa fa-search" type="image" src="imagens/icon/checked.ico" title="CheckTaBackBoneX: Checked" style="max-widht:20px; max-height:20px;">                                                      
						<?Php }else{ ?>
							<input i class="fa fa-search" type="image" src="imagens/icon/no_checked.ico" title="CheckTaBackBoneX: No-checked" style="max-widht:20px; max-height:20px;">                                                      
						<?Php } ?>
					
						<?Php echo"$AttribMenuLingua04";?>
						<!--</a>-->
					</td>
				</tr>
				<!------------------------ Linha - Ini Seguir Tunnel(Esquerda) ----------------------------
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php $ObjFuncao->espaco(2); ?>
						<img border="0" src="imagens/<?Php echo"$ThemeCorLinhaMenu"; ?>" width="155" height="15">
					</td>
				</tr>
				----------------------- Linha - Fim ---------------------------------------------------->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
						<!-- <a href="<?Php // echo"$AttribMenuSobreLink00"; ?>" class="fonte_menu_esq"> -->
							<?Php // echo"$AttribMenuSobre00";?><!-- Vlans-aki -->
						<!-------------------------- Ini Seguir Tunnel Letral(esquerda)------------------------>
						
						<!-------------- Tunnel/Rever IP´s --------------------------------------------------->
						<?Php 
									for($Rx = 0; $Rx < $ReverTunnel[_CtgVETOR]; $Rx++){ ?>
										<tr align="left"  height="5" valign="top">									
											<td width="100%" colspan="2"  align="left"  height="5" valign="top">
										<?Php 		
												$objHtmlReverIP = 'edCmdRvIP'.$Rx; 
												if($ReverTunnel[$Rx] !=''){ 
													if( (str_contains($ReverTunnel[$Rx], 'Tunnel')) 
													||  (str_contains($ReverTunnel[$Rx], 'Extras'))															
													||  (str_contains($ReverTunnel[$Rx], 'Rever')) ){															
														
														//-------------------------------------------------------------------//
														if(str_contains($ReverTunnel[$Rx], 'Tunnel')){ ?>
															<div class="placa" id="cmdTunnel">
																
																<input i class="fa fa-search" onclick="window.open('http://localhost/rd2r3/pt/ler.php?reg=1425', '', 'popup');" type="image" src="imagens/icon/frasco.ico" title="Seguir tunnel no Cisco(Menu Esq)" style="max-widht:30px; max-height:30px;">
																<input i class="fa fa-search" onclick="window.open('http://localhost/rd2r3/pt/ler.php?reg=1427', '', 'popup');" type="image" src="imagens/icon/microscopio.ico" title="Seguir Tunnel no Huawei(Menu Esq)" style="max-widht:30px; max-height:30px;">
																<?Php 	echo $ReverTunnel[$Rx]; ?><!-- Tunnel(MPLS) - Esquerda -->
																 
															</div><?Php 
														}else{  
															$Icon = 'imagens/icon/bolo.ico';	
															if (str_contains($ReverTunnel[$Rx], 'Extra')){ $Icon = 'imagens/icon/nozes.ico';	} 
															if (str_contains($ReverTunnel[$Rx], 'Rever')){ $Icon = 'imagens/icon/bolo.ico';	} 
														?>
															<div class="placa" id="cmdTunnel">
																<input i class="fa fa-search" type="image" src="<?Php echo $Icon; ?>" title="Extras Tunnel/Rever IPs(Esq)" style="max-widht:30px; max-height:30px;">
																<?Php 	echo $ReverTunnel[$Rx]; ?>
															</div>

														<?Php	
														} //if(str_contains('Tunnel')){
														//-------------------------------------------------------------------//

													}else{ // if( (str_contains('Tunnel' || 'Rever')) 
														if(str_contains($ReverTunnel[$Rx], 'desc')){ $IcoEmpresa = 'datacom.png'; $CmdDesc = "Copiar cmds Datacom"; }
														else if(str_contains($ReverTunnel[$Rx], 'current')){ $IcoEmpresa = 'huawei.png'; $CmdDesc = "Copiar cmds Huawei"; }
														else if(str_contains($ReverTunnel[$Rx], 'run')){ $IcoEmpresa = 'cisco.png'; $CmdDesc = "Copiar cmds Cisco"; }
														else if(str_contains($ReverTunnel[$Rx], 'match')){ $IcoEmpresa = 'alcatel_lucent.png'; }
														else if(str_contains($ReverTunnel[$Rx], 'cat')){ $IcoEmpresa = 'server_lj.ico'; $CmdDesc = "Copiar cmds Tacacs";  }
														else if(str_contains($ReverTunnel[$Rx], 'ssh')){ $IcoEmpresa = 'server_vd.ico'; $CmdDesc = "Copiar cmds Tacacs"; }
													?>
														<!--  Comandos de RevisaIPS -->			
														<input type="image" onclick="CopyToClipBoardX('<?Php echo $objHtmlReverIP; ?>')" i class="fa fa-search"  src="imagens/icon/<?Php echo $IcoEmpresa; ?>" title="Copiar cmds(Menu Esq)" style="max-width:15px; max-height:15px; border: solid 1px #808080;  border-radius: 3px; box-shadow: 2px 2px 4px rgba(0,0,0,0.5);"><!-- style="max-widht:15px; max-height:15px; border: solid 2px #000">                          -->
														<input type="text" id="<?Php echo $objHtmlReverIP; ?>" name="<?Php echo $objHtmlReverIP; ?>" size="15" value="<?Php echo $ReverTunnel[$Rx]; ?>" style="font-size: 9pt; font-weight: normal;"> 
														<!-- <input i class="fa fa-search" type="image" src="imagens/icon/<?Php echo $IcoEmpresa; ?>" title="<?Php echo $CmdDesc ; ?>" style="max-widht:20px; max-height:20px;"> -->                         
														
														<?Php
													}														
												} // ($ReverTunnel[$Ra] !=''){		
																							
											?>	
										</td>
									</tr>
								<?Php } // for... ?>
										
						<!-------------------------- Fim Seguir Tunnel Letral(esquerda)------------------------>	
						<!-- </a> -->
					</td>
				</tr>

				<!-- Form Localizar, inserido aqui devido espa�os que cria no IE && Estava dando SUBMIT nas iIMGs de Copiar Cmds(Menu Esq)  -->
				<form name="LocalizarTickets" method="post" action="localizar_tickets.php">
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
				<div class="placaFx" id="calendario">	
					<input i class="fa fa-search" type="image" src="imagens/icon/calendar.ico" style="max-widht:30px; max-height:30px;">									
					<?php echo date("l d/m"); ?>
				</div>
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
					
		<form name="Tickets" method="post" action="tickets.php">				<!-- Editar -->
		<?Php

			if(isset($_POST['btnExcluirConfirma'])){					
				// Limpar registro atual(Atualiza registro)
				//                  SalvarTicket($Reg, $ID, $Empresa, $Produto, $Tipo, $IdFlowX, $SWA, $EDD, $OPER, $VlanGer,  $ShelfSwa, $SlotSwa, $PortSwa, $SWT, $SWT_IP, $RA, $Router, $Interface, $Porta, $Speed, $VidUnit, $PolicyIN, $PolicyOUT, $Vrf, $sVlan, $cVlan, $Lan, $Wan, $LoopBack, $Lan6, $Wan6, $Status, $Rascunho, $ReverTunnel, $Backbone, $cfgBackbone)
				// _AutorizaDEL: senha de autorização para apagar
				
				$Res = $ObjTickets->LimparTicket(_AutorizaDEL, $CxNumTicketX, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Novo', '', '', '', $loadConfig[_TaBBone]);
				if($Res){ echo "Registro excluido com sucesso!";}
			}
	
			if(isset($_POST['BtExcluirDados'])){					
			// Limpar registro atual(Atualiza registro)
			//$ObjFuncao->Mensagem('Atencao!', 'Tem certeza que deseja excluir esses dados?', 'Sim', 'Não', defConfirma, defAtencao);
			/*	
			echo "<div class='msg_confirma'>Tem certeza que deseja apagar esses Dados?"."<br>";
				echo "<p><br>";
				echo '<button type="submit" name="btnExcluirConfirma" id="BtnExcluirConfirma" class="form-submit-button-lg">Sim</button>'; 
				echo '<button type="submit" name="btnExcluirCancela" id="BtnExcluirCancela" class="form-submit-button-lg">Não</button>';
				echo "</div>"; */
			?>
				<div class="placaFx" id="msgConfirma">
					Tem certeza que deseja apagar esses Dados?
					<p><br>
					<button type="submit" name="btnExcluirConfirma" id="BtnExcluirConfirma" class="form-submit-button-lg">Sim</button>
					<button type="submit" name="btnExcluirCancela" id="BtnExcluirCancela" class="form-submit-button-lg">Não</button>
				</div>
			<?Php
						
				//$Res = $ObjTickets->SalvarTicket($CxNumTicketX, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','Novo', '', '', '', $loadConfig[_TaBBone]);
			
			}
		?>
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
			
				<!-- <br> 5198x472 -> x 442-->
				<table class="TAB_ConteudoIntMargem" width="100%" align="center" valign="top" border="0"> 	
				<!-- 5198x472 -> x 442 -> x412
				<input i class="fa fa-search" type="image" src="imagens/icon/duplicar.ico" title="Linha de ajuste Edge, para copyBots" style="max-widht:10px; max-height:10px;">
				-->				
                <tr align="left"  height="5" valign="top" style="background-color: LightSlateGray">
					
					<td width="20%" colspan="4"  align="left"  height="5" valign="top" ><font size='3' color='#ffffff'><b>
						Tickets!
					</b>
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
								<input onclick="CopyToClipBoardX('TaRascunho')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar rascunho" style="max-widht:20px; max-height:20px;">
							
								<TEXTAREA ID="TaRascunho" name="TaRascunho" COLS="120" ROWS="20" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);"> 
                                   <?Php 
								 		//echo $TaRascunhoX;  <- Erro! Adiciona linhas no topo em todo Salvar 
										for($t = 1; $t < count($lstTaRascunho); $t++){ // <- t=1, elimina primeira linha
											if(!empty($lstTaRascunho[$t])){ // Elimina linhas vazias
												printf("%s\n",$lstTaRascunho[$t]);	
											}										
										}  
									?>
                                    </TEXTAREA>
                                </td>
                            </tr> 
							
							<!-- Input Num.Processo Epika-Flow -->
							<tr align="left"  height="5" valign="top">
								
								<td width="30%" colspan="1"  align="left"  height="5" valign="top">
									<input onclick="CopyToClipBoardX('edSn_Tel')" i class="fa fa-search" type="image" src="imagens/icon/cafe.ico" title="Tel" style="max-widht:20px; max-height:20px;">                                                      
									<button type="button" name="BtSpace" value="Space"></button>
									<input onclick="CopyToClipBoardX('edRepositorioAdmSWA')" i class="fa fa-search" type="image" src="imagens/icon/suporte.ico" title="Acesso SWA via 'admin'" style="max-widht:20px; max-height:20px;">
									<input onclick="CopyToClipBoardX('edRepositorioSuporteSWA')" i class="fa fa-search" type="image" src="imagens/icon/suporte.ico" title="Acesso SWA via 'suporte'" style="max-widht:20px; max-height:20px;">
									<input onclick="CopyToClipBoardX('edRepositorioOper_b2bSWA')" i class="fa fa-search" type="image" src="imagens/icon/chave.ico" title="Acesso SWA via 'oper_b2b'" style="max-widht:20px; max-height:20px;">
			
									<input type="text" id="edIdFlow" name="edIdFlow" size="60" value="<?Php echo "$edIdFlowX" ; ?>" title="Para bugs do Flow/Netcompass procurar os focais Rodrigo Barbosa / Willian Mengatto / Hamilton Pospissil Neto com o print do problema e o numero da instância para abertura da incidência junto ao time de devops.
 
Não esqueçam de relatar o problema para que o mesmo seja inserido no chamado."> <!-- required pattern="[0-9]{7}"> -->
				           			<input onclick="CopyToClipBoardX('edIdFlow')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar num.processo Epika-Flow" style="max-widht:20px; max-height:20px;">
				           			<input onclick="CopyToClipBoardX('TaRepositorioEmailFlow')" i class="fa fa-search" type="image" src="imagens/icon/ajtCadStar.ico" title="Enviar email(Time Arquitetura) corrigir cadastro Epika-Flow" style="max-widht:20px; max-height:20px;">
							
									<input onclick="CopyToClipBoardX('TaCarimboFLOW')" i class="fa fa-search" type="image" src="imagens/icon/nozes.ico" title="Copiar Carimbo para correção cad.Flow" style="max-widht:20px; max-height:20px;">
							
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																									
									<!--   
									Vrf:
									<select id="CxVrfEmpresa" name="CxVrfEmpresa" size="1"  onchange="interTravarPolicyOUT()" style=" font-size: 10pt;">
                                    	<option><?Php echo $CxVrfEmpresaX_naousa; ?></option>  
                                    	<?Php for($p = 0; $p < 10; $p++){ ?>  
											<option><?Php printf("s"); ?></option>  
                                    	<?Php } ?> 
									</select>
									
                            		<select id="CxVrf" name="CxVrf" size="1" onchange="interTravarPolicyIN()" style=" font-size: 10pt;">
                                    	<option><?Php echo $CxVrfX_naousa; ?></option> 
										<?Php for($p = 0; $p < 10; $p++){ ?>  
											<option><?Php printf("s"); ?></option>  
                                    	<?Php } ?> 								
									</select> -->
								</td>
								<script>
									function abrirImagem() {
										alert('Abrindo imagem....');
										// Caminho completo da imagem (ajuste conforme necessário)
										var caminhoImagem = 'file:///C:/wamp64/bin/mysql/mysql8.2.0/data/rede_imagens/ipd_she_rsd_2g.jpeg';
										
										// Tenta abrir em uma nova janela/aba
										window.open(caminhoImagem, '_blank');
									}
								</script>
								<td width="10%" colspan="1"  align="right"  height="5" valign="top" ><font size='2' color='#008080'>
								
									<button type="submit" name="BtDuplicar" value="Novo" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Duplicar registro atual">
										<img src="imagens/icon/duplicar.ico"  style="widht:130%; height:130%;">
									</button>									
									<button type="submit" name="BtDuvida" value="Novo" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Recuperar acessos">
										<img src="imagens/icon/planejado.ico"  style="widht:130%; height:130%;">
									</button>									
										
									<button type="button" name="BtWindows" value="Windows" onclick="window.open('http://localhost/rd2r3/pt/ler.php?reg=425', '', 'popup');" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Teclas de atalho do Windows">
										<img src="imagens/icon/windows.ico"  style="widht:120%; height:120%;">
									</button>
									<button type="button" name="BtShowImg" value="ShowImagens" onclick="window.open('http://C:/wamp64/bin/mysql/mysql8.2.0/data/rede_imagens/ipd_she_rsd_2g.jpeg', '', 'popup');" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Ver imagem cadastrada">
										<img src="imagens/icon/foto.ico"  style="widht:120%; height:120%;">
									</button>

																		
                                </td>                            
                            
                            </tr>  
							<tr align="left"  height="5" valign="top">
                                <td width="100%" colspan="2"  align="left"  height="5" valign="top" ><font size='2' color='#008080'>
                          
								<!---------------------- Ini Barra de Select/botoes abaixo do TextArea---------------------------------------------->
								<!-- Table aninha Select/Botoes Novo/salvar/Limpar -->
								<table class="TAB_ConteudoIntMargem" width=100% align="center" valign="top" border="0">				
								<tr align="left"  height="5" valign="top">
									<td width="69%" colspan="1"  align="left"  height="5" valign="top">		
										<input onclick="CopyToClipBoardX('edSn_Vv')" i class="fa fa-search" type="image" src="imagens/icon/Caixabase.ico" title="Vivo" style="max-widht:20px; max-height:20px;">                          
										<!-- <input i class="fa fa-search" type="image" src="imagens/icon/bussola.ico" title="Consulta Ticket" style="max-widht:20px; max-height:20px;"> -->									 
										<button type="button" name="BtSpace" value="Space"></button>
										<select name="CxNumTicket" size="1" onChange="this.form.submit();" title="CxNumTicket" style=" font-size: 9pt;">							
										
											<option style="background: #0000FF; color: #fff;">
												<?Php echo $CxNumTicketX; ?>
											</option>	
											<!-- Tickts Novos -->							
											<?Php 
												$TotNovos = $lstTktNovos[_CtgVETOR][_CtgVETOR];
												if($TotNovos > 1){
													if($TotNovos > 1){ $TotNovos = 0; } // Limita 3(0a2) Novos em amostra
													for($n = $TotNovos; $n >= 0; $n--){ ?>													
														<option style="background: #1E90FF; color: #fff;">
															<?Php printf("[%s] %s", $lstTktNovos[$n][_REG], $lstTktNovos[$n][_Status]); ?>
														</option>
											<?Php 	}
											// caso Não haja Novos registros na lista, Aviso! Necessario inserir
												}else{  ?>
													<option style="background: #FF0000; color: #fff;">
														Não há Novos registros!
													</option>
											<?Php } ?>	
											<option style="background: #0000FF; color: #fff;">[1001] Agenda</option>
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
													if($TotRv >= 50){ $TotRv = 50; } // Limita a X registros anteriores
													for($rv = 0; $rv < $TotRv; $rv++){ ?>													
														<option style="background: #3CB371; color: #fff;">
															<?Php printf("[%s] %s - %s(%s)", $lstTktRevisar[$rv][_REG], $lstTktRevisar[$rv][_ID], $lstTktRevisar[$rv][_Status], $lstTktRevisar[$rv][_Data]); ?>
														</option>
										<?Php 		}	
												}
													
												//<!-- Tickts Encerrados-Hoje -->
												$TotHj = $lstTktEncHoje[_CtgVETOR][_CtgVETOR];
												//echo 'Total-HJ: '.$TotHj;
												if($TotHj > 1){
												?><option style="background: #C0C0C0; color: #000;">Encerrados hoje:</option><?Php 
												for($e = 0; $e < $TotHj; $e++){ 													
													
													if( (str_contains($lstTktEncHoje[$e][_Status], 'Desis')) 
													||  (str_contains($lstTktEncHoje[$e][_Status], 'Improc')) ){ // Muda cor se for Pendencia
														?><option style="background: #F4A460; color: #fff;"><?Php
													}else{
															?><option style="background: #228B22; color: #fff;"><?Php
													}	
													printf("[%s] %s, %s - %s M(%s-%s)",$lstTktEncHoje[$e][_REG], 
																						$lstTktEncHoje[$e][_ID], 
																						substr($lstTktEncHoje[$e][_Empresa], 0, 10), // Parte do Nome
																						$lstTktEncHoje[$e][_Speed],
																						substr($lstTktEncHoje[$e][_Status], 0,3), 
																						$lstTktEncHoje[$e][_Data]); ?>
													</option>
													
										<?Php 	} }  ?>
												<option style="background: #C0C0C0; color: #000;">Total encerrados:</option><?Php 	

												//<!-- Tickts Encerrados -->
												$Tot = $lstTktEncerrados[_CtgVETOR][_CtgVETOR];
												if($Tot >= _TotENCERRADOS){ $Tot = _TotENCERRADOS; } // Limita a X registros anteriores
												for($e = 0; $e < $Tot; $e++){ 													
													
													if( (str_contains($lstTktEncerrados[$e][_Status], 'Desis')) 
													||  (str_contains($lstTktEncerrados[$e][_Status], 'Improc')) ){ // Muda cor se for Pendencia
														?><option style="background: #F4A460; color: #fff;"><?Php
													}else{
															?><option style="background: #228B22; color: #fff;"><?Php
													}	
													printf("[%s] %s, %s - %s M(%s-%s)",$lstTktEncerrados[$e][_REG], 
																						$lstTktEncerrados[$e][_ID], 
																						substr($lstTktEncerrados[$e][_Empresa], 0, 10), // Parte do Nome
																						$lstTktEncerrados[$e][_Speed],
																						substr($lstTktEncerrados[$e][_Status], 0,3), 
																						$lstTktEncerrados[$e][_Data]); ?>
													</option>
											<?Php } ?>																	
										</select> 
										
										
										<?Php 
											// Cor-fundo: select name="CxStatus"
											if(str_contains($CxStatusX, 'ovo')){ $corFundoCx = '#1E90FF'; }
											else if(str_contains($CxStatusX, 'nalisa')){ $corFundoCx = '#00BFFF'; }
											else if(str_contains($CxStatusX, 'Penden')){ $corFundoCx = '#F08080'; }
											else if(str_contains($CxStatusX, 'ancela')){ $corFundoCx = '#F08080'; }
											else if(str_contains($CxStatusX, 'Revis')){ $corFundoCx = '#3CB371'; }
											else if(str_contains($CxStatusX, 'Rast')){ $corFundoCx = '#3CB371'; }
											else if(str_contains($CxStatusX, 'Desis')){ $corFundoCx = '#F4A460'; }
											else if(str_contains($CxStatusX, 'Improc')){ $corFundoCx = '#F4A460'; }
											else if(str_contains($CxStatusX, 'Resol')){ $corFundoCx = '#228B22'; }
											else if(str_contains($CxStatusX, 'impeza')){ $corFundoCx = '#228B22'; }
											else{ $corFundoCx = '#FFFFFF'; }
										?>
										<select name="CxStatus" size="1" style=" font-size: 8pt; background: <?Php echo $corFundoCx; ?>" title="CxStatus">
											<option style="background: #0000FF; color: #fff;"><?Php echo $CxStatusX; ?></option>																						
											<option style="background: #1E90FF; color: #fff;">Novo</option>
											<option style="background: #00BFFF; color: #fff;">Analisando</option>	
											<option style="background: #F08080; color: #fff;">Pendente(acesso)</option>
											<option style="background: #F08080; color: #fff;">Pendente(config)</option>	
											<option style="background: #F08080; color: #fff;">Pendente(email)</option>
											<option style="background: #F08080; color: #fff;">Pendente(outros)</option>	
											<option style="background: #3CB371; color: #fff;">Revisar</option>
											<option style="background: #3CB371; color: #fff;">Rastrear</option>
											<option style="background: #228B22; color: #fff;">Resolvido</option>
											<option style="background: #228B22; color: #fff;">Cancelado(Parcial)</option>
											<option style="background: #228B22; color: #fff;">Cancelado(Total)</option>
											<option style="background: #228B22; color: #fff;">Resolvido(Falha-Flow)</option>
											<option style="background: #228B22; color: #fff;">Resolvido(Cgd-Star-LN)</option>
											<option style="background: #228B22; color: #fff;">Resolvido(Cgd-Hybrid)</option>
											<option style="background: #228B22; color: #fff;">Resolvido(TUNNEL-OK)</option>
											<option style="background: #228B22; color: #fff;">Resolvido(Cgd-BBone)</option>
											<option style="background: #228B22; color: #fff;">Resolvido(Cgd-BBone-outros)</option>
											<option style="background: #228B22; color: #fff;">Resolvido(Cgd-Range)</option>
											<option style="background: #228B22; color: #fff;">Resolvido(Cgd-Range-outros)</option>
											<option style="background: #228B22; color: #fff;">Limpeza</option>
											<option style="background: #228B22; color: #fff;">UnLock</option>
											
											<option style="background: #DEB887; color: #fff;">Desistido[S/Banda]</option>	
											<option style="background: #DEB887; color: #fff;">Desistido[S/Porta]</option>	
											<option style="background: #DEB887; color: #fff;">Desistido[SWA S/Acesso]</option>	
											<option style="background: #DEB887; color: #fff;">Desistido[SWA inexist]</option>	
											<option style="background: #DEB887; color: #fff;">Desistido[SWA Implan.Incor]</option>	
											<option style="background: #DEB887; color: #fff;">Desistido[SWA S/Cadastro]</option>	
											<option style="background: #DEB887; color: #fff;">Desistido[BBone Bloq]</option>	
											<option style="background: #DEB887; color: #fff;">Desistido[Tarefa UM]</option>	
											<option style="background: #DEB887; color: #fff;">Desistido[INST/Canc(LADO)]</option>	
											
											<option style="background: #F4A460; color: #fff;">Improcedente[S/Banda]</option>	
											<option style="background: #F4A460; color: #fff;">Improcedente[S/Porta]</option>	
											<option style="background: #F4A460; color: #fff;">Improcedente[SWA S/Acesso]</option>	
											<option style="background: #F4A460; color: #fff;">Improcedente[SWA inexist]</option>	
											<option style="background: #F4A460; color: #fff;">Improcedente[SWA Implan.Incor]</option>	
											<option style="background: #F4A460; color: #fff;">Improcedente[SWA S/Cadastro]</option>	
											<option style="background: #F4A460; color: #fff;">Improcedente[BBone Bloq]</option>
											<option style="background: #F4A460; color: #fff;">Improcedente[Tarefa UM]</option>
											<option style="background: #F4A460; color: #fff;">Improcedente[INST/Canc(LADO)]</option>
											
												
										</select>
									</td>
									<td width="31%" colspan="1"  align="right"  height="5" valign="top">
										
																				
										<button type="submit" name="BtCloseTa" value="Close" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Ver comandos">
											<img src="imagens/icon/quadro.ico"  style="widht:120%; height:120%;">
										</button>										
										<button type="submit" name="BtOpenReverTunnel" value="Open" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Testes de Tunnel(Mpls)">
											<img src="imagens/icon/conecta.ico"  style="widht:120%; height:120%;">
										</button>
																					
										<button type="submit" name="BtOpenTaBackbone" value="Open" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Abrir Validar IPs/config backbone">
											<img src="imagens/icon/caderno.ico"  style="widht:120%; height:120%;">
										</button>										
										
										<button type="submit" name="BtAdicionar" value="Novo" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Add registro vazio">
											<img src="imagens/icon/add_novo.ico"  style="widht:120%; height:120%;">
										</button>
										<!--
										<button type="submit" name="BtAvancarReg" value="Close" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Avancar registro(Salva, Adiciona, abre reggistro add)">
											<img src="imagens/icon/Avancar.ico"  style="widht:120%; height:120%;">
										</button>-->
										<button type="submit" name="BtExcluirDados" value="Excluir" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Limpar dados do registro atual">
											<img src="imagens/icon/excluir.ico"  style="widht:120%; height:120%;">
										</button>
									
										<button type="submit" name="BtSalvar" value="Salvar" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Salvar registro">
											<img src="imagens/icon/disquete.ico"  style="widht:120%; height:120%;">
										</button>
										<button type="submit" name="BtLimpar" value="Novo" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Limpar">
											<img src="imagens/icon/change.ico"  style="widht:120%; height:120%;">
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
							if($ObjTickets->ContaID($edIDX)){  // Check se ja existe este ID
							?><div class="divRd" id="idFound">									
									<input i class="fa fa-search" type="image" src="imagens/icon/duplicar.ico" style="max-widht:30px; max-height:30px;" title="Este ID já existe no BD.">																		
								</div><?Php
							}
							if($ObjTickets->ContaSWA($edSwaX)){  // Check se ja existe este SWA
								?><div class="divRd" id="swaFound">									
									<input i class="fa fa-search" type="image" src="imagens/icon/duplicar.ico" style="max-widht:30px; max-height:30px;" title="Este SWA já existe no BD.">																		
								</div><?Php
							}	
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
								<input onclick="CopyToClipBoardX('TaBackBone')" i class="fa fa-search" type="image" src="imagens/icon/baixar.ico" title="Copiar Validacao/Backbone" style="max-widht:20px; max-height:20px;">
								<input onclick="CopyToClipBoardX('TaCarimboSAE')" i class="fa fa-search" type="image" src="imagens/icon/nozes.ico" title="Copiar Carimbo para encerrar SAE" style="max-widht:20px; max-height:20px;">
								<button type="submit" name="BtCarimbarValidacao" value="Send" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Carimbar Validacao">
									<img src="imagens/icon/folha.ico"  style="widht:120%; height:120%;">
								</button>
							</td>									
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
										|| str_contains($LinTaBB, 'B')
										|| str_contains($LinTaBB, '.')
										|| str_contains($LinTaBB, '!')
										|| str_contains($LinTaBB, '*')
										|| str_contains($LinTaBB, '-')
										|| str_contains($LinTaBB, '#')
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
							
							if($TaReverTunnelX <> ''){
								$lstTaReverTunnel = preg_split('/\r\n|\r|\n/', $TaReverTunnelX);	// Quebra linha-a-linha num Vetor[]
							}									
						?>
						<tr align="left"  height="5" valign="top">	
							<td width="100%" colspan="1"  align="left"  height="5" valign="top" ><font size='2' color='#008080'>
								<!-- <input onclick="CopyToClipBoardX('TaReverTunnel')" i class="fa fa-search" type="image" src="imagens/icon/conecta.ico" title="Copiar Testes de Tunnel(Mpls)" style="max-widht:20px; max-height:20px;"> -->
								<button type="submit" name="BtShowTUNNEL" value="Send" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Carimbar TUNNEL TaRascunho">
									<img src="imagens/icon/conecta.ico"  style="widht:120%; height:120%;">
								</button>
								<button type="submit" name="BtCarimboTUNNEL" value="Send" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Carimbar TUNNEL TaRascunho">
									<img src="imagens/icon/folha.ico"  style="widht:120%; height:120%;">
								</button>
							</td>							
							<td width="100%" colspan="2"  align="left"  height="5" valign="top" ><font size='2' color='#008080'>
							<TEXTAREA ID="TaReverTunnel" name="TaReverTunnel" COLS="120" ROWS="40" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);"> 
                                <?Php 
								if($TaReverTunnelX <> ''){
									// echo $TaBackBoneX; <- Erro! Adiciona linhas no topo em todo Salvar  
									for($b = 1; $b < count($lstTaReverTunnel); $b++){ // <- b=1, elimina primeira linha
										printf("%s\n", $lstTaReverTunnel[$b]);											
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
							
							<!-- Show imagens de layout-cctos-->
							<?Php if(isset($_POST['BtShIPD'])){ ?>
									<div class="placaFx" id="shImagemHead" title="Ccto IPD">
									<button type="submit" name="BtImgHide" value="Hide" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Hide Image">
											<img src="imagens/icon/no_checked.ico"  style="widht:100%; height:100%;">
										</button>	
									</div>
									<div class="placaFx" id="shImagem" title="Ccto IPD">									
										<img src="imagens/topologias/ipd.png" class="imagem-responsive" alt="Layout ccto IPD" style="width: 600px; height:400px;">																				
									</div>
							<?Php } ?>
							<?Php if(isset($_POST['BtShVPN'])){ ?>
								<div class="placaFx" id="shImagemHead" title="Ccto IPD">
									<button type="submit" name="BtImgHide" value="Hide" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Hide Image">
											<img src="imagens/icon/no_checked.ico"  style="widht:100%; height:100%;">
										</button>	
									</div>
									<div class="placaFx" id="shImagem" title="Ccto IPD">									
										<img src="imagens/topologias/ipd.png" class="imagem-responsive" alt="Layout ccto IPD" style="width: 600px; height:400px;">																				
									</div>
							<?Php } ?>
							<?Php if(isset($_POST['BtShSIP'])){ ?>
								<div class="placaFx" id="shImagemHead" title="Ccto IPD">
									<button type="submit" name="BtImgHide" value="Hide" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Hide Image">
											<img src="imagens/icon/no_checked.ico"  style="widht:100%; height:100%;">
										</button>	
									</div>
									<div class="placaFx" id="shImagem" title="Ccto IPD">									
										<img src="imagens/topologias/ipd.png" class="imagem-responsive" alt="Layout ccto IPD" style="width: 600px; height:400px;">																				
									</div>	
							<?Php } ?>
							<?Php if(isset($_POST['BtShCChannel'])){ ?>
								<div class="placaFx" id="shImagemHead" title="Ccto IPD">
									<button type="submit" name="BtImgHide" value="Hide" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Hide Image">
											<img src="imagens/icon/no_checked.ico"  style="widht:100%; height:100%;">
										</button>	
									</div>
									<div class="placaFx" id="shImagem" title="Ccto IPD">									
										<img src="imagens/topologias/ipd.png" class="imagem-responsive" alt="Layout ccto IPD" style="width: 600px; height:400px;">																				
									</div>
							<?Php } ?>


							<!--  aninha Clt-VPN -->
							<table class="TAB_ConteudoIntMargem" width="100%" align="left" valign="top"> 
								<!-- Revisar IPs-->							
								<tr align="left"  height="5" valign="top">									
                                    <td width="100%" colspan="2"  align="left"  height="5" valign="top">
									<button type="submit" name="BtShIPD" value="Salvar" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Ccto IPD">
										<img src="imagens/icon/ipd.ico"  style="widht:100%; height:100%;">
									</button>
									<button type="submit" name="BtShVPN" value="Salvar" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Ccto VPN">
										<img src="imagens/icon/vpn.ico"  style="widht:100%; height:100%;">
									</button>
									<button type="submit" name="BtShCChannel" value="Salvar" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Ccto CChannel">
										<img src="imagens/icon/cchannel.ico"  style="widht:100%; height:100%;">
									</button>
									<button type="submit" name="BtShSIP" value="Salvar" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Ccto SIP">
										<img src="imagens/icon/sip.ico"  style="widht:100%; height:100%;">
									</button>
										<!-------------- Tunnel/Rever IP´s --------------------------------------------------->
										<?Php 
											for($Rx = 0; $Rx < $ReverTunnel[_CtgVETOR]; $Rx++){ ?>
												<tr align="left"  height="5" valign="top">									
                                    				<td width="100%" colspan="2"  align="left"  height="5" valign="top">
											<?Php 		
												$objHtmlReverIP = 'edCmdRvIP'.$Rx; 
												if($ReverTunnel[$Rx] !=''){ 
													if( (str_contains($ReverTunnel[$Rx], 'Tunnel')) 
													||  (str_contains($ReverTunnel[$Rx], 'Extras'))															
													||  (str_contains($ReverTunnel[$Rx], 'Rever')) ){															
														
														//-------------------------------------------------------------------//
														if(str_contains($ReverTunnel[$Rx], 'Tunnel')){ ?>
															<div class="placa" id="cmdTunnel">
																
																<input i class="fa fa-search" onclick="window.open('http://localhost/rd2r3/pt/ler.php?reg=1425', '', 'popup');" type="image" src="imagens/icon/frasco.ico" title="Seguir tunnel no Cisco" style="max-widht:30px; max-height:30px;">
																<input i class="fa fa-search" onclick="window.open('http://localhost/rd2r3/pt/ler.php?reg=1427', '', 'popup');" type="image" src="imagens/icon/microscopio.ico" title="Seguir Tunnel no Huawei" style="max-widht:30px; max-height:30px;">
																<?Php 	echo $ReverTunnel[$Rx]; ?>
																 
															</div><?Php 
														}else{  
															$Icon = 'imagens/icon/bolo.ico';	
															if (str_contains($ReverTunnel[$Rx], 'Extra')){ $Icon = 'imagens/icon/nozes.ico';	} 
															if (str_contains($ReverTunnel[$Rx], 'Rever')){ $Icon = 'imagens/icon/bolo.ico';	} 
														?>
															<div class="placa" id="cmdTunnel">
																<input i class="fa fa-search" type="image" src="<?Php echo $Icon; ?>" title="Extras Tunnel/Rever IPs(Esq)" style="max-widht:30px; max-height:30px;">
																<?Php 	echo $ReverTunnel[$Rx]; ?>
															</div>

														<?Php	
														} //if(str_contains('Tunnel')){
														//-------------------------------------------------------------------//

													}else{ // if( (str_contains('Tunnel' || 'Rever')) 
														if(str_contains($ReverTunnel[$Rx], 'desc')){ $IcoEmpresa = 'datacom.png'; $CmdDesc = "Copiar cmds Datacom"; }
														else if(str_contains($ReverTunnel[$Rx], 'current')){ $IcoEmpresa = 'huawei.png'; $CmdDesc = "Copiar cmds Huawei"; }
														else if(str_contains($ReverTunnel[$Rx], 'run')){ $IcoEmpresa = 'cisco.png'; $CmdDesc = "Copiar cmds Cisco"; }
														else if(str_contains($ReverTunnel[$Rx], 'match')){ $IcoEmpresa = 'alcatel_lucent.png'; }
														else if(str_contains($ReverTunnel[$Rx], 'cat')){ $IcoEmpresa = 'server_vm.ico'; $CmdDesc = "Copiar cmds Tacacs";  }
														else if(str_contains($ReverTunnel[$Rx], 'ssh')){ $IcoEmpresa = 'server_az.ico'; $CmdDesc = "Copiar cmds Tacacs"; }
													?>
														<!--  Comandos de RevisaIPS -->			
														<input onclick="CopyToClipBoardX('<?Php echo $objHtmlReverIP; ?>')" i class="fa fa-search" type="image" src="imagens/icon/<?Php echo $IcoEmpresa; ?>" title="Copiar cmds(Menu Central)" style="max-width:15px; max-height:15px; border: solid 1px #808080;  border-radius: 3px; box-shadow: 2px 2px 4px rgba(0,0,0,0.5);"><!-- style="max-widht:20px; max-height:20px;">                          -->
														<input type="text" id="<?Php echo $objHtmlReverIP; ?>" name="<?Php echo $objHtmlReverIP; ?>" size="40" value="<?Php echo $ReverTunnel[$Rx]; ?>" style="font-size: 9pt; font-weight: normal;"> 
														<!-- <input i class="fa fa-search" type="image" src="imagens/icon/<?Php echo $IcoEmpresa; ?>" title="<?Php echo $CmdDesc ; ?>" style="max-widht:20px; max-height:20px;"> -->                         
														
														<?Php
													}														
												} // ($ReverTunnel[$Ra] !=''){		
																							
											?>	
										</td>
										</tr>
										<?Php } // for... ?>
										
									</td>
									</tr>															
                                <p>
								<tr align="left"  height="5" valign="top">
									<td width="100%" colspan="1"  align="left"  height="5" valign="top">									
									<?Php	
										// Lista ID com Falha de cadastro Efika									
										$lstFalha = $ObjTickets->lstFalha();	
										
										if(!empty($lstFalha[0][_ID])){
											for($f = 0; $f < $lstFalha[_CtgVETOR][_CtgVETOR]; $f++){
												if($f == 0){ // Evita inserção de linha vazia							
													$TaLstFalha = ''."\t".''."\t".''."\t".''."\t\n";
												}
												//printf("%s - %s", $lstID_RA[$r][_ID], $lstID_RA[$r][_Empresa]); echo '<br>';
												$TaLstFalha = $TaLstFalha.$lstFalha[$f][_REG]."\t".$lstFalha[$f][_ID]."\t".$lstFalha[$f][_Empresa]."\t".$lstFalha[$f][_SWA]."\t Eth ".$lstFalha[$f][_ShelfSwa]."/".$lstFalha[$f][_SlotSwa]."/".$lstFalha[$f][_PortSwa]."\t".$lstFalha[$f][_sVlan]."\t".$lstFalha[$f][_cVlan]."\t".$lstFalha[$f][_IdFlow]."\t\n";
												
											}
											 $TaLstFalha =  $TaLstFalha."\n";
										}								
						
									?>
									<p><input onclick="CopyToClipBoardX('TaLstFalha')" i class="fa fa-search" type="image" src="imagens/icon/beach.ico" title="Copiar lista de ID com falha de Cadastro Efika" style="max-widht:20px; max-height:20px;">
									Lista de ID´s com Falha de cadastro Efika-Flow
									<TEXTAREA id="TaLstFalha" name="TaLstFalha" COLS="60" ROWS="30" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);"> 
										<?Php 
											echo $TaLstFalha;											
											echo 'Total:'.$lstFalha[_CtgVETOR][_CtgVETOR]; 
										?>				
									</TEXTAREA>	
									</td>
								</tr>

								<?Php for($Ra = 0; $Ra < 27; $Ra++){ ?>
								<tr align="left"  height="5" valign="top">									
									<td width="100%" colspan="2"  align="left"  height="5" valign="top">
										
									</td>
								</tr>
								<?Php } ?>
								<tr align="left"  height="5" valign="top">									
									<td width="100%" colspan="2"  align="left"  height="5" valign="top">
									<!-- Repositorios Cmds testar-Ips para robo copiar -->
									<?Php for($R = 3; $R < $ReverTunnel[_CtgVETOR]; $R++){ $objHtmlReverIP = 'edCmdRvIP'.$R; ?>																			
										<input type="text" id="<?Php echo $objHtmlReverIP; ?>" name="<?Php echo $objHtmlReverIP; ?>" size="1" value="<?Php echo $ReverTunnel[$R]; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
									<?Php } ?>	
									</td>
								</tr>
														
							</table><!-- table Cmd Revisa IPS -->
						
							
							<!-------------------------------- Fim tabela Esquerda - Teste de Ips ------------------------>
							</td>
							
							<td width="50%" colspan="3"  align="left"  height="5" valign="top" ><font size='2' color='#008080'>
							<!-------------------------------- Ini tabela Direita - Comandos Routers ------------------------>
								
							<table class="TAB_ConteudoIntMargem" width="100%" align="center" valign="top"> 					
									<?Php //if($CxRouterX != '' && $CxRouterX != 'Datacom'){ ?>	<!-- Se ja houver um roteador definido, mostre comandos -->
									<?Php if($CxRouterX != ''){ ?>	<!-- Se ja houver um roteador definido, mostre comandos -->
									
                                    <?Php
										for($C = 0; $C < $MyScript[_CtgCmdRouters]; $C++){ $objHtmlCmd = 'edCmd'.$C; 
									?>
                                    <tr align="left"  height="5" valign="top">									
                                        <td width="100%" colspan="2"  align="left"  height="5" valign="top">
											<!-- Usa em Comandos-Checagens, abaixo do TabackBone -->
                                            <?Php if($MyScript[_FaixaCmdRouters + $C] !=''){ ?>
												<?Php if( (str_contains($MyScript[_FaixaCmdRouters + $C], 'VPN(')) 
													  ||  (str_contains($MyScript[_FaixaCmdRouters + $C], 'Checkar'))
													  ||  (str_contains($MyScript[_FaixaCmdRouters + $C], 'Conferir'))
													  ||  (str_contains($MyScript[_FaixaCmdRouters + $C], 'Extras'))
												      ||  (str_contains($MyScript[_FaixaCmdRouters + $C], 'Tunnel')) 
												      ||  (str_contains($MyScript[_FaixaCmdRouters + $C], 'Datacom')) ){ 
															
															if(str_contains($MyScript[_FaixaCmdRouters + $C], 'Tunnel')){ ?>
															<div class="placa" id="cmdTunnel">
																<input i class="fa fa-search" onclick="window.open('http://localhost/rd2r3/pt/ler.php?reg=1425', '', 'popup');" type="image" src="imagens/icon/frasco.ico" title="Seguir tunnel no Cisco" style="max-widht:30px; max-height:30px;">
																<input i class="fa fa-search" onclick="window.open('http://localhost/rd2r3/pt/ler.php?reg=1427', '', 'popup');" type="image" src="imagens/icon/microscopio.ico" title="Seguir Tunnel no Huawei" style="max-widht:30px; max-height:30px;">
																<?Php 	echo $MyScript[_FaixaCmdRouters + $C]; ?>
															</div>	
															<?Php }else{ ?>

																	<?Php if(str_contains($MyScript[_FaixaCmdRouters + $C], 'Tunnel')){ ?>
																	<div class="placa" id="cmdTunnel">
																		<input i class="fa fa-search" onclick="window.open('http://localhost/rd2r3/pt/ler.php?reg=1425', '', 'popup');" type="image" src="imagens/icon/frasco.ico" title="Seguir tunnel no Cisco" style="max-widht:30px; max-height:30px;">
																		<input i class="fa fa-search" onclick="window.open('http://localhost/rd2r3/pt/ler.php?reg=1427', '', 'popup');" type="image" src="imagens/icon/microscopio.ico" title="Seguir Tunnel no Huawei" style="max-widht:30px; max-height:30px;">
																		<?Php 	echo $MyScript[_FaixaCmdRouters + $C]; ?>
																	</div>	
																	<?Php 
																		}else{ 
																			$Icon = 'imagens/icon/beach.ico';
																			if(str_contains($MyScript[_FaixaCmdRouters + $C], 'Checkar')){ $Icon = 'imagens/icon/beach.ico'; }
																			if(str_contains($MyScript[_FaixaCmdRouters + $C], 'Conferir')){ $Icon = 'imagens/icon/checked.ico'; }
																			if(str_contains($MyScript[_FaixaCmdRouters + $C], 'Extra')){ $Icon = 'imagens/icon/nozes.ico'; }
																			if(str_contains($MyScript[_FaixaCmdRouters + $C], 'Datacom')){ $Icon = 'imagens/icon/nozes.ico'; }
																			if(str_contains($MyScript[_FaixaCmdRouters + $C], 'VPN')){ $Icon = 'imagens/icon/luminaria.ico'; }
																	?>	
																		<div class="placa" id="basica">
																			<input i class="fa fa-search" type="image" src="<?Php echo $Icon; ?>" title="Cm`s: checkar/conferir/extras/Vpn´s" style="max-widht:35px; max-height:35px;">																	
																			<?Php 	echo $MyScript[_FaixaCmdRouters + $C]; ?>
																		</div>
																	<?Php } ?>

															<?Php } ?>
															
												<?Php }else{ ?> 
													<input onclick="CopyToClipBoardX('<?Php echo $objHtmlCmd; ?>')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:15px; max-height:15px;">                          
													<input type="text" id="<?Php echo $objHtmlCmd; ?>" name="<?Php echo $objHtmlCmd; ?>" size="50" value="<?Php echo $MyScript[_FaixaCmdRouters + $C]; ?>" style="font-size: 9pt; font-weight: normal;"> 
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
								<?Php
								// Lista REG, ID que usam o mesmo SWA
								$lstID_SWA = $ObjTickets->lstID_SWA($edSwaX);	// Listar ID que usam o RA atual
								
								if($lstID_SWA[0][_REG] > 1000){
									for($s = 0; $s < $lstID_SWA[_CtgVETOR][_CtgVETOR]; $s++){
										if($s == 0){ // Evita inserção de linha vazia							
											$TaLstSwa = ''."\t".''."\t\n";
										}
										$TaLstSwa = $TaLstSwa.$lstID_SWA[$s][_REG]."\t".$lstID_SWA[$s][_ID]."\t".$lstID_SWA[$s][_SWA]."\t\n";
										
									}
									$TaLstSwa = $TaLstSwa."\n";
								}	
								?>
								<p><input onclick="CopyToClipBoardX('TaLstSwa')" i class="fa fa-search" type="image" src="imagens/icon/separa.ico" title="Copiar lista de ID neste SWA" style="max-widht:20px; max-height:20px;">
								Lista de Reg neste mesmo SWA
								<TEXTAREA id="TaLstSwa" name="TaLstSwa" COLS="60" ROWS="10" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);"> 
									<?Php 
										echo $TaLstSwa; 
										echo 'Total: '.$lstID_SWA[_CtgVETOR][_CtgVETOR];
									
									?>				
								</TEXTAREA>
								<?Php
								// Lista ID que usam o mesmo RA
								$lstID_RA = $ObjTickets->lstID_RA($edRaX);	// Listar ID que usam o RA atual
								if(!empty($lstID_RA[0][_ID])){
									for($r = 0; $r < $lstID_RA[_CtgVETOR][_CtgVETOR]; $r++){
										if($r == 0){ // Evita inserção de linha vazia							
											$TaLstRA = ''."\t".''."\t\n";
										}
										$TaLstRA = $TaLstRA.$lstID_RA[$r][_ID]."\t".$lstID_RA[$r][_Empresa]."\t\n";
										
									}
									$TaLstRA = $TaLstRA."\n";
								}	
								?>
								<p><input onclick="CopyToClipBoardX('TaLstRA')" i class="fa fa-search" type="image" src="imagens/icon/separa.ico" title="Copiar lista de ID neste RA" style="max-widht:20px; max-height:20px;">
								Lista de ID´s config neste mesmo RA
								<TEXTAREA id="TaLstRA" name="TaLstRA" COLS="60" ROWS="15" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);"> 
									<?Php 
										echo $TaLstRA; 
										echo 'Total: '.$lstID_RA[_CtgVETOR][_CtgVETOR];
									
									?>				
								</TEXTAREA>
						
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
									   <!-- <input type="text" id="CxProduto" name="CxProduto" size="3" value="<?Php echo "$CxProdutoX" ; ?>"> <!-- required pattern="[0-9]{7}"> -->
									
									   <select name="CxProduto" size="1">
											<option><?Php echo $CxProdutoX; ?></option>										
											<option>IPD</option>
											<option>VPN</option>																				                   
											<option>SIP</option>																				                   
											<option>IGOV</option>																				                   
											<option>CCH</option>																				                   
										</select>
										
										<!--
										<button type="submit" name="BtLiberarID" value="Liberar ID"   style="widht:10px; height:20px; border:none;" title="Limpar campos">
											<img src="imagens/icon/tirar.ico"  style="widht:150%; height:150%;">
										</button>
										
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
									<input type="text" id="edSWA" name="edSWA" size="22" value="<?Php echo "$edSwaX" ; ?>" style=" background: <?Php if(str_contains($edSwaX, '2') ){ echo '#FFFF00'; }else{ echo '#FFF'; } ?>">
									<input onclick="CopyToClipBoardX('edSWA')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar Swa(nome)" style="max-widht:20px; max-height:20px;">
									<input onclick="CopyToClipBoardX('edSwaScanBot')" i class="fa fa-search" type="image" src="imagens/icon/404.ico" title="<?Php echo $edSwaScanBotX; ?>" style="max-widht:20px; max-height:20px;">
							
									
								</td>                            
                            </tr>	
							<!-- Vlan Ger/ PortSwa -->
							<tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">Vlan Ger:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<input onclick="CopyToClipBoardX('edgVlan')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar Vlan de gerencia" style="max-widht:20px; max-height:20px;">
									<input type="text" placeholder="Vlan Ger." id="edgVlan" name="edgVlan" size="5" value="<?Php echo "$edgVlanX" ; ?>" style=" font-size: 8pt;"> <!-- required pattern="[0-9]{1,}"> -->
									
									<?Php 
										if( str_contains($CxTipoX, 'Desconfig')){ $corFundoTipo =  '#CD5C5C';  }//'#FF6347'; }	
										else if( str_contains($CxTipoX, 'Migra')){	$corFundoTipo = '#00FF00'; } //'#32CD32'; 
										else{ $corFundoTipo = '#00BFFF'; }	
									?>
									<select name="CxTipo" size="1" title="CxTipo" style="font-size: 8pt; background: <?Php echo $corFundoTipo; ?>; color: #000;"><!-- onChange="this.form.submit();">-->
										<option><?Php echo $CxTipoX; ?></option>														
										<option value="Config">Config</option>
										<option value="Migracao">Migracao</option>	
										<option value="Desconfig">Desconfig</option>
									</select>
									<select name="CxOperadora" size="1" style=" font-size: 8pt;">																															
										<option><?Php echo $CxOperadoraX; ?></option>																							
										<option>AGG</option>
										<option>AST</option>
										<option>ERB</option>													
										<option>IGN</option>
										<option>INF</option>			
										<option>K2</option>			
										<option>MDV</option>			
										<option>SITELBRA</option>			
										<option>VTAL</option>										
										<option>VV_RAD_PTP</option>										
										<option>WEB</option>										
										<option>UFI</option>										
										<option>VIVO2</option>										
									</select>	
									<input onclick="CopyToClipBoardX('edRepositorioOper')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar Operadora" style="max-widht:20px; max-height:20px;">
								</td>                            
                            </tr>
							<!--EDD -->
							<?php
								$titleCxEdd = '';
								if(!str_contains($CxEddX, 'EDD')){ 
									if(str_contains($CxEddX, 'R22')){ $titleCxEdd = 'Intelbrás - SCRIPT SWA SERVIÇO FIBERHOME-IPD-VPN-SIP'; }
								}
								if(str_contains($CxEddX, '4370')){ 
									$titleCxEdd = 'Usar Gi1/1/5 a Te1/1/4';
									$corFundoEDD = '#ff0';
								}else{
									$corFundoEDD = '#fff';
								}


								
							?>
							 <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">
									EDD:
									<input onclick="CopyToClipBoardX('edRepositorioSoPortSwa')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar Porta-SWA" style="max-widht:20px; max-height:20px;">
							
								</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">								
									<select name="CxEDD" size="1" title="<?Php echo $titleCxEdd; ?>" style="color: #000; background: <?Php echo $corFundoEDD; ?>">																															
										<option><?Php echo $CxEddX; ?></option>																							
										<option>2104G2</option>													
										<option>Coriant(!)</option>													
										<option>Coriant(Ger)</option>													
										<option>DM400X</option>										
										<option>DM4050</option>
										<option>DM4100</option>
										<option>DM4250</option>
										<option>DM4270</option>
										<option>DM4370</option>										
										<option>V380R220</option>
									</select>	
								 	<select name="CxPortaTipo" size="1">
										<option><?Php echo $CxPortaTipoX; ?></option>										
										<option>Eth</option>										
										<option>lag-1</option><!-- DM4050(LAG), DM2104G(port-channel) -->
										<option>lag-2</option>
										<option>lag-3</option>
										<option>lag-4</option>
										<option>lag-5</option>										
									</select>
								 	<select name="CxShelfSwa" size="1">
										<option><?Php echo $CxShelfSwaX; ?></option>										
										<?Php for($p=0; $p<16; $p++){ ?>																				
										<option><?Php  echo $p; ?></option>
										<?Php  }?>	
									</select>
								 	<select name="CxSlotSwa" size="1">
										<option><?Php echo $CxSlotSwaX; ?></option>										
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
								
									
								</td>                            
                            </tr>								
							 <!-- SWT -->		
							 <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">SWT:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<input onclick="CopyToClipBoardX('edSWT')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
									<input type="text" id="edSWT" name="edSWT" size="22" value="<?Php echo "$edSwtX" ; ?>" style=" background: <?Php if(str_contains($edSwaX, '2') ){ echo '#FFFF00'; }else{ echo '#FFF'; } ?>">
									<!-- Copiar email abertura TA do repositorio -->
									<input onclick="CopyToClipBoardX('TaRepositorioEmailTA')" i class="fa fa-search" type="image" src="imagens/icon/email.ico" title="Copiar email abertura TA" style="max-widht:20px; max-height:20px;">
							
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
									<input onclick="CopyToClipBoardX('edRepositorioPingRA')" i class="fa fa-search" type="image" src="imagens/icon/separa.ico" title="ping + Nome-RA" style="max-widht:20px; max-height:20px;">
									<?Php 
										$corFundoRA = '#FFF';
										$titleRA = 'BBIP';
										if( (str_contains($edRaX, 'rce-ln'))){ $corFundoRA = "#ff0000"; $titleRA = 'Este BBIP pertence a VIVO2, atendido via TBS';}
										if( (str_contains($edRaX, 'bhe-lue-rsd-01'))){ $corFundoRA = "#FFA500"; $titleRA = 'Este BBIP esta com route-static saturado';}
									?>
					
									
									<input type="text" id="edRA" name="edRA" size="18" value="<?Php echo "$edRaX" ; ?>" style="color: #000; background: <?Php echo $corFundoRA; ?>" title="<?Php echo $titleRA; ?>">
									<button type="button" name="BtListRaBlock" value="ListaRaBlock" onclick="window.open('http://localhost/rd2r3/pt/ler.php?reg=1429', '', 'popup');" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Ver Lista RA´s bloqueados: c-br-sp-cas-ce-rav-0X Block">
										<img src="imagens/icon/cadeado.ico"  style="widht:120%; height:120%;">
									</button>
									<button type="button" name="BtAvNotConfigRa" value="BtAvNotConfigRa" onclick="window.open('http://localhost/rd2r3/pt/ler.php?reg=1433', '', 'popup');" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Não config Interfaces Ras com IP ADDRESS...">
										<img src="imagens/icon/listaVpn.ico"  style="widht:120%; height:120%;">
									</button>
                                </td>                            
                            </tr>
							<!-- Router -->
							<tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">Router:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
                            
								<select name="CxRouter" size="1" title="CxRouter">-- TA APAGANDO REGISTRO NO RE-LOAD-> onChange="this.form.submit();"><!-- Este this.form permitiu salvamento do Reg em todos os botoes Copiar -->
								<!-- <select name="CxRouter" size="1" title="CxRouter" onChange="this.form.submit();"><!-- Este this.form permitiu salvamento do Reg em todos os botoes Copiar -->
									<option><?Php echo $CxRouterX; ?></option>														
									<option>Cisco</option>
									<option>Datacom</option>
									<option>Huawei</option>
									<option>Juniper</option>
									<option>Nokia</option>							
								</select>
								<input onclick="CopyToClipBoardX('TaRepositorioEmailPtStar')" i class="fa fa-search" type="image" src="imagens/icon/ajtCadStar.ico" title="Copiar email Cad.Porta Star" style="max-widht:20px; max-height:20px;">
								<input onclick="CopyToClipBoardX('TaRepositorioEmailCadERB')" i class="fa fa-search" type="image" src="imagens/icon/email.ico" title="Copiar email Corrigir Cad.ERB_FIB" style="max-widht:20px; max-height:20px;">
						        </td>                            
                            </tr>
							<!-- Port -->		
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">Port:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
                                <select name="CxInterface" size="1" title="CxInterface">
                                    <option><?Php echo $CxInterfaceX; ?></option>
                                    <!-- <option disabled selected>-- Cisco --</option>--><!-- Ta pegando sempre ESSE  -->
									<?Php if(str_contains($CxRouterX, 'Cisco')){ ?>
										<option>Bundle-Ether</option><!-- Cisco -->
										<option>GigabitEthernet</option><!-- Cisco -->
										<option>PW-Ether</option><!-- Cisco -->
										<option>Port-channel</option><!-- Cisco -->
										<option>TenGigE</option><!-- Cisco -->
										<option>TenGigabitEthernet</option><!-- Cisco -->
									<!-- <option disabled selected>-- Huawei  -->
									<?Php }else if(str_contains($CxRouterX, 'Huawei')){ ?>
										<option>Eth-Trunk</option><!-- Huawei -->	
										<option>eth-trunk </option><!-- Huawei -->	
										<option>GigabitEthernet</option><!-- Huawei -->											
                                    <!-- <option disabled selected>-- Juniper -->
									<?Php }else if(str_contains($CxRouterX, 'Juniper')){ ?>
                                   	 	<option>ae</option><!-- Cisco -->	
                                    	<option>ge-</option><!-- Cisco -->	
                                    	<option>xe-</option><!-- Cisco -->	
                                    <!--<option disabled selected>-- Nokia --</option>--><!-- Nokia -->
									<?Php }else if(str_contains($CxRouterX, 'Nokia')){ ?>	
                                    	<option>sap</option><!-- Nokia -->  
										<option>sap esat-</option><!-- Nokia -->                              
                                    	<option>sap lag-</option><!-- lag --> 
                                    	<option>sap pw-</option><!-- pseudo wire --> 
									<?Php } ?>                          
                                </select>
                                    <input type="text" name="edPort" id="edPort" size="11" value="<?Php echo "$edPortX" ; ?>" >
									<input onclick="CopyToClipBoardX('edPort')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar port" style="max-widht:20px; max-height:20px;">
						

								<!------------------------ AREA TESTES JS --------------------------------------------------------->
								   


								<!------------------------ AREA TESTES JS --------------------------------------------------------->	
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
                                    <input type="text" placeholder="Ctrl-vid/Unit" name="edCtrlVidUnit" size="7" value="<?Php echo "$edCtrlVidUnitX" ; ?>" title="Vid/Unit = Rdn 700a2000" >
									<input type="text" placeholder="Speed" id="edSpeed" name="edSpeed" size="7" value="<?Php echo "$edSpeedX" ; ?>" style="background: #87CEFA; color: #000;"> <!-- onChange="alertProjEspecial('edSpeed');" > -->
									<input onclick="CopyToClipBoardX('edSpeed')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
								</td>                                    																					  
                            </tr>                   																					
                            <!-- Vrf -->
							 <?Php
									$ListaVrf = $ObjTickets->LoadVrf();	
									// Separa palavras do nome da empresa pra fazer comparações/filtrar VRf para empresa em questão								
									$wordEmpresa = explode(" ", $edEmpresaX);	
							 ?>
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">Vrf:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">

									<select id="CxVrf" name="CxVrf" size="1"  onchange="interTravarPolicyOUT()" style=" font-size: 7pt;">
                                    	<option><?Php echo $CxVrfX; ?></option>  
                                    	<?Php 	
											for($pv = 0; $pv < $ListaVrf[_CtgVETOR][_CtgVETOR]; $pv++){ 
												foreach($wordEmpresa as $LinWdEmpresa){												
													if(strlen($LinWdEmpresa) > 3){ // procura por palavras > 3 letras
														if(str_contains($ListaVrf[$pv][_Empresa], $LinWdEmpresa)){	// Compara se Palavra contém na empresa atual - filtra Vrf que possa ser desta empresa
															?><option><?Php printf("%s", $ListaVrf[$pv][_Vrf]); ?></option>  
                                    	<?Php 		} }
												}
											} 
										?> 
									</select>
									<!--
									<input onclick="CopyToClipBoardX('CxVrf')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">
									<input type="text" id="CxVrf" name="CxVrf" size="26" value="<?Php echo "$CxVrfX" ; ?>" > -->
									<button type="button" name="BtListVpn" value="ListaVpn" onclick="window.open('http://localhost/rd2r3/pt/ler.php?reg=1421', '', 'popup');" style="widht:20px; height:20px; border:none; cursor: pointer;" title="Ver Lista Vrf">
										<img src="imagens/icon/listaVpn.ico"  style="widht:120%; height:120%;">
									</button>
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
									<?Php 
										$corFundo = '#FFF';
										if( (str_contains($edLANX, '201.60'))||(str_contains($edLANX, '201.61')) ){ ?>
											<input type="text" id="<?Php echo $objHtmlIPs; ?>" name="<?Php echo $objHtmlIPs; ?>" size="21" value="<?Php echo $edLANX; ?>" style="font-weight: normal; background: #FF6347; color: #000;" <?Php if(str_contains($CxProdutoX, 'VPN')){?>placeholder="Não usa em VPN" <?Php }else{?> placeholder="" <?Php } ?>> 								

									<?Php 
										$CamposVazios = true;	// Ctrl msg/verificação de campos vazios
										}else{ ?>
											<input type="text" id="<?Php echo $objHtmlIPs; ?>" name="<?Php echo $objHtmlIPs; ?>" size="15" value="<?Php echo $edLANX; ?>" style="font-weight: normal;" <?Php if(str_contains($CxProdutoX, 'VPN')){?>placeholder="Não usa em VPN" <?Php }else{?> placeholder="" <?Php } ?>> 								
											
                            		<?Php } ?> 
									<select name="CxMaskLAN" size="1" style="background: <?Php echo $corFundo; ?>" title="Mask Lan">																															
										<option><?Php echo $CxMaskLANX; ?></option>			
										<option>/29</option>													
										<option>/28</option>
										<option>/24</option>
									</select>	 
									
                                </td>
                            
                            </tr>
                            <!-- WAN -->		
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">WAN(0):</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<?Php 
										$objHtmlIPs = "edWAN"; 
										$msgWanPlaceH = '';										
										if($tipoConfig == _NaoDefinido){ 
											$msgWanPlaceH = '';	
											if(empty($edWANX)){ $CxMaskWanX = '/30'; }
											$corFundo = '#FFF';										
										}else if($tipoConfig == _rtVIVO){ 
											$msgWanPlaceH = 'Wan /31';													
											if(empty($edWANX)){ $CxMaskWanX = '/31'; }
											$corFundo = '#DA70D6';									
										}else if($tipoConfig == _rtCLIENTE){ 
											$msgWanPlaceH = 'Wan /30';												
											if(empty($edWANX)){ $CxMaskWanX = '/30'; }
											$corFundo = '#FFFACD';
										}

										
									?>	
									
									<input onclick="CopyToClipBoardX('<?Php echo $objHtmlIPs; ?>')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">                          									
									<?Php 
										if( (str_contains($edWANX, '201.60'))||(str_contains($edWANX, '201.61')) ){ ?>
										<input type="text" id="<?Php echo $objHtmlIPs; ?>" name="<?Php echo $objHtmlIPs; ?>" size="21" value="<?Php echo $edWANX; ?>" style="font-weight: normal; background: #FF6347; color: #000;" title="Alocar /31 quando o router é nosso. Quando o router for cliente, alocar um /30" placeholder="<?Php echo $msgWanPlaceH; ?>"> 								                      

										<!-- <input type="text" name="edWAN" size="30" value="<?Php echo $edWANX; ?>" style="background: #FFAAD1; color: #000;"> -->
									<?Php 
										$CamposVazios = true;	// Ctrl msg/verificação de campos vazios
										}else{ ?>
											<input type="text" id="<?Php echo $objHtmlIPs; ?>" name="<?Php echo $objHtmlIPs; ?>" size="15" value="<?Php echo $edWANX; ?>" style="font-weight: normal;" title="Alocar /31 quando o router é nosso. Quando o router for cliente, alocar um /30" placeholder="<?Php echo $msgWanPlaceH; ?>"> 								                      
                            		<?Php } ?>									
									<select name="CxMaskWan" size="1" style="background: <?Php echo $corFundo; ?>" title="Alocar /31 quando o router é nosso. Quando o router for cliente, alocar um /30">																															
										<option><?Php echo $CxMaskWanX; ?></option>			
										<option>/31</option>													
										<option>/30</option>
									</select>	
							      </td>
                            
                            </tr>
                            <!-- LoopBack -->
<?php $msgLo = '
Liberou o IP LOOPBACK (ID 1800352)
Tipo: LIBERAR IP Por: RISONALDO FAUSTINO TAVARES 
Em: 22-01-2025 14:09:39
	-Ptos acesso
	---Dados fabricante
	----- Fabricante CISCO
	---Roteadores
	----- <APARECE VAZIO>
	--- Outra situação: ---
	ID ROTEADOR CLIENTE= PLACA FAST SIM
	Rotedor do clienete com placa Fast'; ?>

											
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">LoopBack:</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<?Php 
										$objHtmlIPs = "edLoopBack"; 
										if($tipoConfig == _NaoDefinido){	// SE ROTEDAOR DO CLIENTE, NAO USR LOOPBACK 											
											$msgPlHolder = '';
											$corFundo = '#FFF'; 
										}else if($tipoConfig == _rtVIVO){	// SE ROTEDAOR DO CLIENTE, NAO USR LOOPBACK 											
											$msgPlHolder = 'Usar Lo';
											$corFundo = '#DA70D6'; 
										}	
										if($tipoConfig == _rtCLIENTE){	// SE ROTEDAOR DO CLIENTE, NAO USR LOOPBACK 
											$edLoopBackX = '';
											$msgPlHolder = 'Não usar Lo';
											$corFundo = '#FFFACD'; 
										}										
									?>
									<input onclick="CopyToClipBoardX('<?Php echo $objHtmlIPs; ?>')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar Lo" style="max-widht:20px; max-height:20px;">
									<?Php 
										if( (str_contains($edLoopBackX, '201.60'))||(str_contains($edLoopBackX, '201.61')) ){ ?>
											<input type="text" id="<?Php echo $objHtmlIPs; ?>" name="<?Php echo $objHtmlIPs; ?>" size="21" value="<?Php echo $edLoopBackX; ?>" style="font-weight: normal; background: #FF6347; color: #000;" title="<?php echo $msgLo; ?>"  ?>placeholder="<?Php echo $msgPlHolder; ?>"> 								
									<?Php 
										$CamposVazios = true;	// Ctrl msg/verificação de campos vazios
										}else{ ?>
											<input type="text" id="<?Php echo $objHtmlIPs; ?>" name="<?Php echo $objHtmlIPs; ?>" size="15" value="<?Php echo $edLoopBackX; ?>" style="font-weight: normal; background: <?Php echo $corFundo; ?>" title="<?php echo $msgLo; ?>" placeholder="<?Php echo $msgPlHolder; ?>"> 								
                            		<?Php } ?>  
									<select name="CxMaskLoBk" size="1" style="background: <?Php echo $corFundo; ?>" title="Mask Lo">																															
										<option><?Php echo $CxMaskLoBkX; ?></option>			
										<option>/32</option>													
									</select>	                        
										
                                </td>
                            
                            </tr>
                            <!-- LAN6 -->		
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">LAN(ipv6):</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">
									<?Php $objHtmlIPs = "edLAN6"; ?>
									<input onclick="CopyToClipBoardX('<?Php echo $objHtmlIPs; ?>')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">                          
									<input type="text" id="<?Php echo $objHtmlIPs; ?>" name="<?Php echo $objHtmlIPs; ?>" size="21" value="<?Php echo $edLAN6X; ?>" style="font-weight: normal;" <?Php if(str_contains($CxProdutoX, 'VPN')) {?>placeholder="Não usa em VPN" <?Php } ?>> 								
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
                            <!-- Router Vivo/Cliente -->	
							<?Php 
								if($tipoConfig == _rtVIVO){ $IcoPropRouter = 'vivo.png'; }
								if($tipoConfig == _rtCLIENTE){ $IcoPropRouter = 'cliente.png'; }
								else{ $IcoPropRouter = 'doc.ico'; } 
							?>
                            <tr align="left"  height="5" valign="top">
                                <td width="20%" colspan="1"  align="left"  height="5" valign="top">
									Router:
									<input i class="fa fa-search" type="image" src="imagens/icon/<?Php echo $IcoPropRouter; ?>" title="<?Php echo $CmdDesc ; ?>" style="max-widht:20px; max-height:20px;">                          
													
								</td>
                                <td width="80%" colspan="1"  align="left"  height="5" valign="top">	
									<?Php
										if($tipoConfig == _NaoDefinido){ 
											$corFundo = '#FFF';										
										}else if($tipoConfig == _rtVIVO){ 
											$corFundo = '#DA70D6';										
										}else if($tipoConfig == _rtCLIENTE){ 
											$corFundo = '#FFFACD';
										}
									?>
									<input onclick="CopyToClipBoardX('CxPropRouter')" i class="fa fa-search" type="image" src="imagens/icon/edit.ico" title="Copiar" style="max-widht:20px; max-height:20px;">                          
									<!--<input type="text" id="CxPropRouter" name="CxPropRouter" size="34" value="<?Php echo $CxPropRouterX; ?>" style="background: <?Php ECHO $corFundo; ?>;">	-->
                                
									<select name="CxPropRouter" size="1" style="background: <?Php echo $corFundo; ?>" title="Alocar /31 quando o router é nosso. Quando o router for cliente, alocar um /30">																															
										<option><?Php echo $CxPropRouterX; ?></option>																							
										<option>Roteador Cliente</option>													
										<option>Roteador nao def</option>													
										<option>Roteador Vivo</option>
									</select>	

								</td>                            
                            </tr>
							<!-- Se Produto for INTRAGOV ...-->
							<?Php if(str_contains($CxProdutoX, 'IGOV')){ ?>							
								<tr align="left"  height="5" valign="top">
									<td width="20%" colspan="1"  align="left"  height="5" valign="top">
										Rotas(IGOV):												
									</td>
									<td width="80%" colspan="1"  align="left"  height="5" valign="top">	
									<TEXTAREA ID="TaRotasIntragov" name="TaRotasIntragov" COLS="25" ROWS="5" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);"> 
										<?Php 
											echo $TaRotasIntragovX;
										?>	
									</TEXTAREA>		

									</td>                            
								</tr>	
							<?Php } ?>						
<!-- </html> ??? -->
							<tr align="center"  width="200px" height="5" valign="top">
								<td width="200px" colspan="2"  align="left"  height="5" valign="top">
									<input type="text" id="empurrarColuna" name="empurrarColuna" value="Este Input so serve para calcar a largura da coluna" size="50" height="1" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
								</td>							                          
                            </tr>		
                        <!-------------------- Fim campos Direito ----------------------------------------------------------------------->   
                        </td>
						</tr>
						
					</table><!-- Final Conteudo Direito(campos: ID, Empresa....) -->   
					
					<?Php
					$lstID_EXEC = $ObjTickets->lstExecHj();	// Listar ID que usam o RA atual
						if(!empty($lstID_EXEC[0][_ID])){
							for($e = 0; $e < $lstID_EXEC[_CtgVETOR][_CtgVETOR]; $e++){	
								if($e == 0){ // Evita inserção de linha vazia							
									$TaExecHj = ''."\t".''."\t".''."\t".''."\t\n";
								}
								$TaExecHj = $TaExecHj.$lstID_EXEC[$e][_ID]."\t".$lstID_EXEC[$e][_Empresa]."\t".$lstID_EXEC[$e][_Status]."\t".$lstID_EXEC[$e][_Data]."\t\n";
							}
							$TaExecHj = $TaExecHj."\n"; // INSERE LINHA NO FINAL
						}	
					?>
					<p><input onclick="CopyToClipBoardX('TaExecHj')" i class="fa fa-search" type="image" src="imagens/icon/taca.ico" title="Copiar lista(csv) de executados hoje" style="max-widht:20px; max-height:20px;">
					Lista de Tickets executados hoje
					<!-- Cols = Larg, Rows=Linhas -->
					<TEXTAREA ID="TaExecHj" name="TaExecHj" COLS="50" ROWS="35" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);"> 
						<?Php 
							echo $TaExecHj;							
							echo 'Total: '.$lstID_EXEC[_CtgVETOR][_CtgVETOR];
						?>	
					</TEXTAREA>	

					<!-- INi Rotina, TextaArea Localizar Migra-Oper-Fail -->
					<?Php
						$TaMigraOperFail = '';
						$checkMigraOperFail = $ObjTickets->checkMigOperFail();	// Listar ID que usam o RA atual
						if(!empty($checkMigraOperFail[0][_ID])){
							for($m = 0; $m < $checkMigraOperFail[_CtgVETOR][_CtgVETOR]; $m++){	
								if($m == 0){ // Evita inserção de linha vazia							
									$TaMigraOperFail = ''."\t".''."\t".''."\t".''."\t\n";
								}
								$TaMigraOperFail = $TaExecHj.$checkMigraOperFail[$m][_ID]."\t".$checkMigraOperFail[$m][_Empresa]."\t".$checkMigraOperFail[$m][_Status]."\t".$checkMigraOperFail[$m][_Data]."\t\n";
							}
							$TaMigraOperFail = $TaMigraOperFail."\n"; // INSERE LINHA NO FINAL
						}	
					?>
					<p><input onclick="CopyToClipBoardX('TaMigOperFail')" i class="fa fa-search" type="image" src="imagens/icon/taca.ico" title="Copiar lista(csv) Mig-Oper-Fail" style="max-widht:20px; max-height:20px;">
					Lista de Tickets antes de 21/02/25(Mig-Oper-Fail) 
					<!-- Cols = Larg, Rows=Linhas -->
					<TEXTAREA ID="TaMigOperFail" name="TaMigOperFail" COLS="50" ROWS="10" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);"> 
					
						Nao esta listando, libere -> printf dentro de: ObjTickets->checkMigOperFail()
						<?Php 
							echo $TaMigraOperFail;							
							echo 'Total: '.$checkMigraOperFail[_CtgVETOR][_CtgVETOR];
						?>	
					</TEXTAREA>		
					<!-- Fim Rotina, TextaArea Localizar Migra-Oper-Fail -->

					<!-- Repositorio TextaArea Emails -->	
					<?Php 
						$EmailPortStar = $ObjTickets->EmailPortStar($edRaX, $CxInterfaceX, $edPortX); 
						$EmailCadERB = $ObjTickets->EmailCadERB($edSwaX, $edRaX, $CxInterfaceX, $edPortX); 
						$EmailCadFlow = $ObjTickets->EmailCadFlow($edSwaX, $edPortX); 
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
					<TEXTAREA id="TaRepositorioEmailFlow" name="TaRepositorioEmailFlow" COLS="22" ROWS="5" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);"> 
						<?Php for($t = 0; $t < $EmailCadFlow[_CtgVETOR]; $t++){ printf("%s\n", $EmailCadFlow[$t]); } ?>				
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
					<input type="text" ID="edRepositorioPingRA" name="edRepositorioPingRA" size="1" value="<?Php echo "ping ".$edRaX; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
					
					<!-- Port-SWA para robo copiar DTC -->
					<input type="text" ID="edRepositorioSlotSwa" name="edRepositorioSlotSwa" size="1" value="<?Php echo $CxShelfSwaX."/".$CxSlotSwaX; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
					<input type="text" ID="edRepositorioPortSwa" name="edRepositorioPortSwa" size="1" value="<?Php echo $CxShelfSwaX."/".$CxSlotSwaX."/".$CxPortSwaX; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
					<input type="text" ID="edRepositorioRulePortSwa" name="edRepositorioRulePortSwa" size="1" value="<?Php echo $CxShelfSwaX."-".$CxSlotSwaX."-".$CxPortSwaX; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
					<input type="text" ID="edRepositorioSoPortSwa" name="edRepositorioSoPortSwa" size="1" value="<?Php echo 'giga-'.$CxShelfSwaX."/".$CxSlotSwaX."/".$CxPortSwaX; ?>" style="background: #F5F5F5; color:#F5F5F5; border: 0 none;">
					
					<!-- Repositorio Pre-Copia-SWA-ScanBot(ERB: MG.CPO, ou SITE: MG.SGE) -->
					<input type="text" id="edSwaScanBot" name="edSwaScanBot" size="1" value="<?Php echo "$edSwaScanBotX" ; ?>" >
					
					<!-- Repositorio Avisos -->
					<input type="text" id="edRepositorioAvisoFlow" name="edRepositorioAvisoFlow" size="1" value="<?Php echo "$edRepositorioAvisoFlowX" ; ?>" >
					
					<!-- Carimbo de Correcao Interface -->
<?Php
	$TaCarimboFLOW = $edIdFlowX."\n".$edIDX." - ".$edEmpresaX." - ".$CxProdutoX."\n SWA: ".$edSwaX."\n SWT: ".$edSwtX." - ".$edSwt_ipX."\n Vlan: ".$edsVlanX.".".$edcVlanX;	



	$TaCarimboSAE = "\n";	
	// Rotina para pegar Linhas, montar carimbo p encerrar SAE
	$ExplodeTaBB = explode("\n", $TaBackBoneX);	

	foreach($ExplodeTaBB as $LinTaBB){

		if( (str_contains($LinTaBB, 'escription')) 
		||  (str_contains($LinTaBB, $edIDX)) 
		||  (str_contains($LinTaBB, 'rocesso')) ){

			if( (str_contains($LinTaBB, 'FIBRA'))&&(str_contains($LinTaBB, 'cription')) ){
				$TaCarimboSAE = $TaCarimboSAE."\n SWA: ".$LinTaBB;
			}else if( (str_contains($LinTaBB, 'Description'))|| (str_contains($LinTaBB, 'interface')) ){
				$TaCarimboSAE = $TaCarimboSAE."\n  BBIP: ".$LinTaBB;
			
			}else if( (str_contains($LinTaBB, 'rocesso'))||(str_contains($LinTaBB, 'ordemId')) ){
				if( (str_contains($LinTaBB, 'ordemId'))){
					$TaCarimboSAE = $TaCarimboSAE."\n FLOW: ".$LinTaBB;	
				}else{
					$TaCarimboSAE = $TaCarimboSAE."\n".$LinTaBB;	
				}		
			}

		}
	}

$CarimboCorrige = "*** CORRIGIDO INTERFACE ***\n.\n..Tipo: NOTA DO USUÁRIO Por: VELISLEI ADILSON TREUK Em: 02-03-2025 12:17:25\n";
?>
					<!-- Cols = Larg, Rows=Linhas -->
					<TEXTAREA ID="TaCarimboSAE" name="TaCarimboSAE" COLS="50" ROWS="10" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);"> 
						<?Php  echo $TaCarimboSAE; 	?>	
					</TEXTAREA>		
					<TEXTAREA ID="TaCarimboFLOW" name="TaCarimboFLOW" COLS="50" ROWS="10" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);"> 
						<?Php  echo $TaCarimboFLOW; 	?>	
					</TEXTAREA>		
					<!-- <input type="text" id="TaCarimboSAE" name="TaCarimboSAE" size="1" value="<?Php echo $TaCarimboSAE; ?>" > -->
					<input type="text" id="edCarimboCorrige" name="edCarimboCorrige" size="1" value="<?Php echo $CarimboCorrige; ?>" >
						
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
<!--
	tickets.php <div id="toastTicketBlock"> 
		-> alert.js: msgTicketBlock()    		( resourses/js/alert.js e resourses/css/alert.css )
			-> Class.tickets.php
				<script>			
					setTimeout(function(){
						msgFrmApagado();		// Chama funcao Toast  
					}, 1000);	
				</script>	
-->
			
<div id="toastFrmApagado">
  <div class="checkicon"> <i class="fas fa-check-square"></i> </div>
	Atencao! Circuito acima de 400M, Possivel projeto especial.
</div>
<div id="toastTicketBlock">
  <div class="checkicon"> <i class="fas fa-check-square"></i> </div>
	Erro! Este Ticket(finalizado) esta protegido, use UnLock.
</div>
<!-- Falha 
<div id="toastRenovarGaus">
  <div class="checkicon"> <i class="fas fa-check-square"></i> </div>
	Atencao! Renovar acessos no GAUS!!!
</div>
<div id="toastTaBBoneClose">
  <div class="checkicon"> <i class="fas fa-check-square"></i> </div>
    Atencao! Nao foi possivel salvar TaBackbone, pois o mesmo esta bloqueado!
</div>
-->
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