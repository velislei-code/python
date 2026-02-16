
		<?Php 
		//SWA-02, 03 NOME SWT
			$finalEdSwaX = substr($edSwaX, -1);
			$calcNomeSwtSugerido = (int)$CxPortSwaX + 24;  // Calcula porta SWA + 24(portas anteriores do swa-01)
		
			if((!str_contains($finalEdSwaX, '1'))){ 
				$msgS[0] = 'Atenção! Já existe SWA anterior, nome SWT deve ser n+(4, 24 ou 48)';
		?>
			<div class="placaFx" id="avSWT" title="<?Php printf("%s", $msgS[0]); ?>">	
				<input i class="fa fa-search" type="image" src="imagens/icon/duplicar.ico" style="max-widht:30px; max-height:30px;">									
				<?Php
					echo 'SWT n+(24): '.$calcNomeSwtSugerido;
				?>	
			</div>
		<?Php } ?>		
		<?Php 
		//SO USAR SWT_ERB
			$msgS[10] = 'RB: Em um ERB Fibrada, CRIAR como SWT_ERB. NÃO USEM VLAN_FSP - Está gerando erro no Magictools.';
		?>
			<div class="placaFx" id="avSWT_ERB" title="<?Php printf("%s", $msgS[10]); ?>">	
				<input i class="fa fa-search" type="image" src="imagens/icon/duplicar.ico" style="max-widht:30px; max-height:30px;">									
				<?Php
					echo 'Só usar: SWT_ERB';
				?>	
			</div>
		
		<?Php 		
		//Avisar migração, pra não ficar testando IPs
		if((str_contains($CxTipoX, 'Migra'))){ 
			
			$msgS[101] = 'Migração/Alteração!';
		?>
			<div class="placaFx" id="avMIGRA" title="<?Php printf("%s", $msgS[101]); ?>">	
				<input i class="fa fa-search" type="image" src="imagens/icon/duplicar.ico" style="max-widht:30px; max-height:30px;">									
				<?Php
					echo 'Migração!';
				?>	
			</div>
		
		<?Php }
		
			// MULTIVRF
			if(str_contains(strtolower($TaRascunhoX), 'multi')){
				$msgTp[17] = 'RB: ID Referência conforme falamos para serviços VPN MULTIVRF utilizem o ID 1850357 - já solucionado.'; 
					
		?>
			<div class="placaFx" id="avCad" title="<?Php printf("%s", $msgTp[17]); ?>">	
				<input i class="fa fa-search" type="image" src="imagens/icon/lampada.ico" style="max-widht:30px; max-height:30px;">									
				<?Php
					echo 'MultiVRF!!';
				?>	
			</div>
				
		<?Php }
		/*
		// IPs WAN/30, 31 LoopBack
			if($tipoConfig == _rtVIVO){ $msgTp[0] = 'Usar Lo, Wan/31'; }
			else if($tipoConfig == _rtCLIENTE){ $msgTp[0] = 'Usar Lo, Wan/31'; }
			else{ $msgTp[0] = 'Não definido'; }			
		?>
			<div class="placaFx" id="avMaskWAN_Lo" title="<?Php printf("%s", $msgTp[0]); ?>">	
				<input i class="fa fa-search" type="image" src="imagens/icon/lampada.ico" style="max-widht:30px; max-height:30px;">									
				<?Php
					echo $msgTp[0];
				?>	
			</div>
				
		<?Php */
		//Range 201.60.X.X/201.61.X.X
			if( (str_contains($edWANX, '201.60'))  
			||  (str_contains($edWANX, '201.61')) ){ 
				$msgX[0] = 'W.Mengatto: Não utilizem a Range 201.60a61.X.X Felipetto(grupo do Nova ERA), Range esta livre, porém não funciona em campo. Era da Móvel - Confirmar se só pra LAN(??)';
		?>
			<div class="placaFx" id="avRange" title="<?Php printf("%s", $msgX[0]); ?>">	
				<input i class="fa fa-search" type="image" src="imagens/icon/lampada.ico" style="max-widht:30px; max-height:30px;">									
				<?Php
					echo 'Range 201.60a61';
				?>	
			</div>
		<?Php } ?>		
		<?Php 
		//Anima HOLDING
			if(str_contains(strtolower($edEmpresaX), 'holdin')){ 
				$msg[0] = 'Para Anima Holding, NÃO é necessário alocar LAN /29. Consultem o STAR/NIC pois deverá haver um bloco /28 ja alocado pela engenharia. Caso ainda não tenha, configurem apenas os blocos IPv6 e a Wan IPv4. E caso ja exista, configurem o bloco /28';
		?>
			<div class="placaFx" id="avHoldi" title="<?Php printf("%s", $msg[0]); ?>">	
				<input i class="fa fa-search" type="image" src="imagens/icon/lampada.ico" style="max-widht:30px; max-height:30px;">									
				<?Php
					echo 'Anima Holding LAN/28 WAN/30';
				?>	
			</div>
		<?Php } ?>		
		<?Php 
		//DASA Todos boa tarde, Não configurem nenhum ticket da DASA - Diagnostico da America SA,
		// se tiver ticket aberto deixem aberto. Assim que finalizarmos como será o processo multiplicarei para todos.
			if( (str_contains(strtolower($edEmpresaX), 'dasa')) 
			||  (str_contains(strtolower($edEmpresaX), 'diagn'))
			||  (str_contains(strtolower($edEmpresaX), 'americ')) ){ 
				$msgD[0] = 'Prj DASA, é melhoria da rede do cliente. Haverá migração de GPON para ERB e outros aumento de SLA na ERB(99.7), onde hoje temos atendimento em uma porta do SWA será inserida a segunda porta e criado o PortChannel. Antes de fazer me procurem por favor. A.Peres, 11/03/25';
		?>
			<div class="placaFx" id="avDasa" title="<?Php printf("%s", $msgD[0]); ?>">	
				<input i class="fa fa-search" type="image" src="imagens/icon/lampada.ico" style="max-widht:30px; max-height:30px;">									
				<?Php
					echo 'Prj DASA';
				?>	
			</div>
		<?Php } ?>		
		<?Php 
		//Cadastro
			if(str_contains(strtolower($TaRascunhoX), 'cadastr')){ 
				$msg[1] = '25/02/25: RB, Quando algum equipamento não estiver cadastrado no Netcompass mas estiver ativo, será configurado por nós(SWA/SWO/SHE), solicitar ao time de arquitetura o cadastramento, Equipe do Michel Porto, Reginaldo Jose de Sá, Lucas Esperatti, Evellyn Oliveira, João Gabril Barbosa e Aline(estagiária em processo de efetivação aguardar e-mail). Copie nosso grupo chave da configuração corporativa e o Peres. ....apenas do equipamento SWO. O cadastro na PORTA de agregação é realizado pela equipe de Configuração no momento que entrar o primeiro cliente.';
		?>
			<div class="placaFx" id="avCad" title="<?Php printf("%s", $msg[1]); ?>">	
				<input i class="fa fa-search" type="image" src="imagens/icon/lampada.ico" style="max-widht:30px; max-height:30px;">									
				<?Php
					echo 'Lembre-se! Cadastro';
				?>	
			</div>
		<?Php } ?>	
		
		<?Php 
		//Vivo2
			$msg[2] = 'RB: Todos, não esqueçam de alocar IP de loopback no Star para Links Vivo2 e o log da config,';
		?>
			<div class="placaFx" id="avVivo2" title="<?Php printf("%s", $msg[2]); ?>">	
				<input i class="fa fa-search" type="image" src="imagens/icon/lampada.ico" style="max-widht:30px; max-height:30px;">									
				<?Php
					echo 'Lembre-se! Lo e Log Vivo2';
				?>	
			</div>

		<?Php 
		//Produtizado
		if(str_contains(strtolower($TaRascunhoX), 'produtizado')){ 
			$msg[21] = 'W.Mengatto: Produtizado quem faz é a equipe de SP do Peres. Nós aqui em Curitiba não fazemos';
		?>
			<div class="placaFx" id="avProdutizado" title="<?Php printf("%s", $msg[21]); ?>">	
				<input i class="fa fa-search" type="image" src="imagens/icon/lampada.ico" style="max-widht:30px; max-height:30px;">									
				<?Php
					echo 'Lembre-se! Produtizado';
				?>	
			</div>
		<?Php } ?>	
		
		
		<?Php 
		
		//REQ
			$msg[3] = 'RB: Quando abrirem ticket e o ID estiver INSTALADO, 
			verificar se já houve configuração ou não, caso tenha histórico de config e 
			validação do link devolver improcedente, caso nõa tenha nenhum histórico de 
			config analisar e seguir com a configuração, na hora de alocar a porta vai dar 
			erro devido o status estar instalado, para isso deve-se abrir um REQ no Vivonow 
			para alocação manual da porta, para os IPs, deve forçar a alocação pelo processo 
			de ampliação dos tipos dos IPs via star. Assim com os IPs, validem pelo VAN normalmente 
			sendo necessário inserir alguns dados para prosseguir com a análise.
			Quem pegar algum ID Instalado e tiver dúvida pode me chamar.';
		?>
			<div class="placaFx" id="avREQ" title="<?Php printf("%s", $msg[3]); ?>">	
				<input i class="fa fa-search" type="image" src="imagens/icon/lampada.ico" style="max-widht:30px; max-height:30px;">									
				<?Php
					echo 'REQ';
				?>	
			</div>
			
		
		
		<?Php 
		//Flow/Netcompass
		
			if( (str_contains(strtolower($TaRascunhoX), 'cadastr'))
			||  (str_contains(strtolower($TaRascunhoX), 'falha'))			
			||  (str_contains(strtolower($TaRascunhoX), 'flow'))){ 
				$msgF[0] = 'Para bugs do Flow/Netcompass procurar os focais Rodrigo Barbosa / Willian Mengatto / Hamilton Pospissil Neto com o print do problema e o numero da instância para abertura da incidência junto ao time de devops. Não esqueçam de relatar o problema para que o mesmo seja inserido no chamado.';
				$edRepositorioAvisoFlowX = 'Email: michelp.silva@telefonica.com; reginaldo.sa@telefonica.com; lucas.mendonca@telefonica.com; evellyn.silva@telefonica.com \n Ass: Cadastro de portas: m-br-mg-bhe-lue-swo-001 AGG_VTAL_DM4370_F1B_B2_SUB2 \n Msg: Bom dia, por gentileza, poderia cadastrar, no Flow,  m-br-mg-bhe-lue-swo-001 ten-giga 1/1/4_AGG_VTAL_DM4370_F1B_B2_SUB2 IPD_650_699.';


		?>
			<div class="placaFx" id="avFlow" title="<?Php printf("%s", $msgF[0]); ?>">	
				<input onclick="CopyToClipBoardX('edRepositorioAvisoFlow')" i class="fa fa-search" type="image" src="imagens/icon/lampada.ico" style="max-widht:30px; max-height:30px;">									
				<?Php
					echo 'Lembre-se! Flow/Netcompass';
				?>	
			</div>
		<?Php } ?>	
		<?Php 
		// Rotedor cliente
			if( (str_contains(strtolower($edEmpresaX), 'zamp')) 
			||  (str_contains(strtolower($edEmpresaX), 'bahia')) 
			||  (str_contains(strtolower($edEmpresaX), 'arcos')) 
			||  (str_contains(strtolower($edEmpresaX), 'M&M')) 
			||  (str_contains(strtolower($edEmpresaX), 'fashion')) 
			||  (str_contains(strtolower($edEmpresaX), 'sendas')) ){ 
				$msgR[0] = 'Verifique! Geralmente estas empresas nao usam Lo - Roteador do Cliente';
		?>
			<div class="placaFx" id="avFust" title="<?Php printf("%s", $msgR[0]); ?>">	
				<input i class="fa fa-search" type="image" src="imagens/icon/lampada.ico" style="max-widht:30px; max-height:30px;">									
				<?Php
					echo 'Lembre-se! Roteador do Cliente';
				?>	
			</div>
		<?Php } ?>		
		<?Php 
		//FUST
			if(str_contains(strtolower($edEmpresaX), 'fust')){ 
				$msg[2] = 'RB: Para Fust usar somente IP de WAN e WAN-Ipv6';
		?>
			<div class="placaFx" id="avFust" title="<?Php printf("%s", $msg[2]); ?>">	
				<input i class="fa fa-search" type="image" src="imagens/icon/lampada.ico" style="max-widht:30px; max-height:30px;">									
				<?Php
					echo 'Lembre-se! FUST';
				?>	
			</div>
		<?Php } ?>	

		
		
		<?Php 
		//PROPRIEDADE ROUTER
			if( (str_contains(strtolower($CxPropRouterX), 'cliente')) 
			||  (str_contains(strtolower($CxPropRouterX), 'fast')) ){ 
				$msgRt[0] = 'W.Mengatto: Aloca sempre /31 quando o router é VIVO. Router cliente, alocar um /30';
		?>
			<div class="placaFx" id="avFust" title="<?Php printf("%s", $msgRt[0]); ?>">	
				<input i class="fa fa-search" type="image" src="imagens/icon/lampada.ico" style="max-widht:30px; max-height:30px;">									
				<?Php
					echo 'Lembre-se! Prop.Router.';
				?>	
			</div>
		<?Php } ?>		
		<?Php 
		//RAI MIGROU PARA RSD
			if( (str_contains(strtolower($edRaX), 'go-gna-srh-rai')) 
			||  (str_contains(strtolower($edRaX), 'go-gna-srh-rai')) ){ 
				$msgRa[0] = 'Deniz: i-br-go-gna-srh-rai-01 migrou para: i-br-go-gna-srh-rsd-01';
		?>
			<div class="placaFx" id="avFust" title="<?Php printf("%s", $msgRa[0]); ?>">	
				<input i class="fa fa-search" type="image" src="imagens/icon/lampada.ico" style="max-widht:30px; max-height:30px;">									
				<?Php
					echo 'Lembre-se! Rai migrou para RSD';
				?>	
			</div>
		<?Php } ?>		

		<?Php 
		//Proj.Especial
			if((int)$edSpeedX > 400){ 
				$msg[3] = 'Possivel projeto especial, ver com Rodrigo B.';
		?>
			<div class="placaFx" id="avPrjEsp" title="<?Php printf("%s", $msg[3]); ?>">	
				<input i class="fa fa-search" type="image" src="imagens/icon/lampada.ico" style="max-widht:30px; max-height:30px;">									
				<?Php
					echo 'Proj.Especial';
				?>	
			</div>
		<?Php }   ?>
				
		<?Php 
		// Lista de RA/Int/Porta.sVlan neste SWA, ja config
		if(!empty($edSwaX)){	
			$lstRaPorta = $ObjTickets->lstRaPorta($edSwaX);

			if( ($lstRaPorta[_CtgVETOR][_CtgVETOR] > 1) ) { 	// O proprio ID não conta, deve ter no minimo 2
						
					$msg[4] = 'Lista de RA/Int/Porta para este SWA';
		?>
				<div class="avRA"><!-- div Pai -->	

					Atenção! RA: Int/Porta.sVlan já config neste BD.
					<br><br>
					<?php 
						for($p=0; $p < $lstRaPorta[_CtgVETOR][_CtgVETOR]; $p++){
							
							// Check se Ping/mac foi confirmed
							if( (str_contains($lstRaPorta[$p][_Backbone], '!!!!!')) // Cisco
							||  (str_contains($lstRaPorta[$p][_Backbone], 'ttl'))){ // Huawei
								$ping = 'ping OK!!'; 
							} else{ $ping = ''; } 
							if( (str_contains(strtolower($lstRaPorta[$p][_Backbone]), 'mac'))){
								$mac = 'Mac OK!!'; 
							} else{ $mac = ''; } 
							if( (str_contains(strtolower($lstRaPorta[$p][_Backbone]), 'mpls'))){
								$tunnel = 'Tunnel OK!!'; 
							} else{ $tunnel = ''; } 
							if( (str_contains(strtolower($lstRaPorta[$p][_Status]), 'mpro'))
							||  (str_contains(strtolower($lstRaPorta[$p][_Status]), 'esist'))){
								$Status = $lstRaPorta[$p][_Status]; 
							} else{ $Status = ''; } 

								$fimID = substr( $lstRaPorta[$p][_ID], -4);
								if(!str_contains($edIDX, $fimID) ){								
									?><div class="raPort"><!--Div Filha --><?Php						
										$LinkAviso = '<br><a href="tickets.php?reg='.$lstRaPorta[$p][_REG].'" target="_blank">'; //.$lstRaPorta[$p][_ID];
										echo $LinkAviso;
										printf("%s %s %s %s.%s.%s {%s %s %s %s}", $lstRaPorta[$p][_ID],  $lstRaPorta[$p][_RA],  $lstRaPorta[$p][_Interface],  $lstRaPorta[$p][_Porta], $lstRaPorta[$p][_sVlan], $lstRaPorta[$p][_cVlan], $ping, $mac, $tunnel, $Status);							
									?>	</a>
									</div><?Php
								}
							//}
						}
					?>	
				</div>
		<?Php 
			}
		}
		
        ?>
		