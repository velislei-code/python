<?Php
	// Atributos da p�gina
	
	$AttribPularLinha=0;						// Num Linhas a saltar no AttribTopo da p�gina

	// Tabela conte�do
	$AttribLargTabConteudo='100%';				// Largura da tabela conte�do

	$objFuncao->RegistrarLog('attrib.inc;');

	//***********************************************************************/
	// Area externa
	$AttribAbaExt00 = 'Principal'; 					$AttribLinkAbaExt00='index.php';
	$AttribAbaExt01 = 'Discussco'; 					$AttribLinkAbaExt01='#';
	
	// Login
	$AttribLinkAbaLog00 = '#';						$AbaLog00 = 'Login';				// Esta Aba � redefinida dentro da p�gina index.php		
		
	// AttribTopo
	$AttribCriaConta='Crie uma conta aqui';			$AttribCriaContaLink='#';
	$AttribTopo00='Criar conta';					$AttribTopoLink00='#';
	$AttribTopo01='Usuario';						$AttribTopoLink01='index.php';
	
	
	// Menu lateral esquerdo 
	$AttribMenuEsqExt00='Pagina principal';			$MenuEsqExtLink00='index.php';
	$AttribMenuEsqExt01='Configuracoes';			$MenuEsqExtLink01='configuracoes.php';
	$AttribMenuEsqExt02='Gerar script';				$MenuEsqExtLink02='script.php';
	$AttribMenuEsqExt03='eBR-X';					$MenuEsqExtLink03='eBR-x.php';
	$AttribMenuEsqExt04='';							$MenuEsqExtLink04='#';
	$AttribMenuEsqExt05='';							$MenuEsqExtLink05='#';

	//***********************************************************************/
	
	
	//***********************************************************************/
	// Area interna - T�picos
	
	// Aba Move
	$AttribAbaIntM[0] = '<'; 						$AttribLinkAbaIntM[0]='#';
	$AttribAbaIntM[1] = '>'; 						$AttribLinkAbaIntM[1]='#';

	// Aba Menu A
	if($AttribPosAbaA > 0){
		// setcookie ("CookieAttribPosAbaA", $AttribPosAbaA); // Mem Posi��o das abas "A" p/ uso em Menu B	
	}else{ $AttribPosAbaA = 1;	}	// Valor Default
	
	if($AttribPosAbaA ==	1){
		$AbaIntA[1] = 'Assunto'; 		$LinkAbaIntA[1]='assunto.php';
		$AbaIntA[2] = 'Topicos'; 		$LinkAbaIntA[2]='topico.php';
		$AbaIntA[3] = 'Indice'; 		$LinkAbaIntA[3]='indice.php';	
	}
	if($AttribPosAbaA ==	2){
			$AbaIntA[1] = 'Topicos'; 		$LinkAbaIntA[1]='topico.php';
			$AbaIntA[2] = 'Indice'; 		$LinkAbaIntA[2]='indice.php';	
			$AbaIntA[3] = 'Localizar'; 		$LinkAbaIntA[3]='localizar.php';
	}
	if($AttribPosAbaA ==	3){
			$AbaIntA[1] = 'Indice'; 		$LinkAbaIntA[1]='indice.php';	
			$AbaIntA[2] = 'Localizar'; 		$LinkAbaIntA[2]='localizar.php';
			$AbaIntA[3] = 'Pesquisar'; 		$LinkAbaIntA[3]='pesquisar.php';	
	}	
	
	// Aba Menu B
	$AttribAbaIntB[0] = '<'; 				$AttribLinkAbaIntB[0]='#';
	$AttribAbaIntB[1] = 'Adicionar'; 		$AttribLinkAbaIntB[1]='adicionar.php';
	$AttribAbaIntB[2] = 'Ler';	 			$AttribLinkAbaIntB[2]='ler.php';
	$AttribAbaIntB[3] = 'Editar'; 			$AttribLinkAbaIntB[3]='editar.php';
	$AttribAbaIntB[4] = 'Excluir'; 			$AttribLinkAbaIntB[4]='excluir.php';
	$AttribAbaIntB[5] = '>'; 				$AttribLinkAbaIntB[5]='#';
	

	// AttribTopo
	$AttribCriaConta='Crie uma conta aqui';		$AttribCriaContaLink='#';
	$AttribTopo00='Criar conta';				$AttribTopoLink00='#';
	$AttribTopo01='Usuario';					$AttribTopoLink01='index.php';
	$ThemeTopoImg01='<?Php echo"$ThemeTopoImg01"; ?>';
	
	$AttribLinkTopo[1]='prefere.php';			$AttribTopo[1]='Preferencias';
	$AttribLinkTopo[2]='backup_xls.php';		$AttribTopo[2]='Backup';
	$AttribLinkTopo[3]='index.php';				$AttribTopo[3]='Sair';
	
	// Menu lateral esquerdo 
	$AttribMenuEsqInt00='Topicos';					$AttribMenuEsqIntLink00='assunto.php';		
	$AttribMenuEsqInt01='     * Cyber Security';	$AttribMenuEsqIntLink01='http://localhost/rd2r3/pt/topico.php?topico=Inform&reg=1129';
	$AttribMenuEsqInt01b='     * Suporte B2B';		$AttribMenuEsqIntLink01b='http://localhost/rd2r3/pt/topico.php?topico=SuporteB2B&reg=1398';
	$AttribMenuEsqInt02='     * Telecom';			$AttribMenuEsqIntLink02='http://localhost/rd2r3/pt/topico.php?topico=Telecom&reg=1';
	
	$AttribMenuEsqInt03='Arquivos';					$AttribMenuEsqIntLink03='configuracao';
	$AttribMenuEsqInt04='Tickets ';					$AttribMenuEsqIntLink04='tickets.php';
	$AttribMenuEsqInt05='Script';					$AttribMenuEsqIntLink05='script.php';
	$AttribMenuEsqInt06='Sel-Tickets';				$AttribMenuEsqIntLink06='seltickets.php';
	$AttribMenuEsqInt07='Rav';						$AttribMenuEsqIntLink07='router_rav.php';
	$AttribMenuEsqInt08='Faixa(Ips)';				$AttribMenuEsqIntLink08='faixa_ips.php';
	
	
	
	//***********************************************************************/
	
	//****************************************************************************************************/
	// Area Comum(Ext-Int)
	// Menu Lingua
	$AttribMenuLingua00='Esteira';				$AttribMenuLinguaLink00='#';			
	$AttribMenuLingua01='Config SWA';					$AttribMenuLinguaLink01='#';			
	$AttribMenuLingua02='Netcompass';				$AttribMenuLinguaLink02='#';			
	$AttribMenuLingua03='IP Validado';			$AttribMenuLinguaLink03='#';			
	$AttribMenuLingua04='Config BBone';			$AttribMenuLinguaLink04='#';			
	
		
	// Sobre
	$AttribMenuSobre00='Vlan´s';				$AttribMenuSobreLink00='ler.php?Lista%20de%20acessos%20via%20Vlan&*reg=698';
	$AttribMenuSobre01='IPv6';					$AttribMenuSobreLink01='ipv6.php';
	$AttribMenuSobre02='GPon';					$AttribMenuSobreLink02='gpon/';
	
	// Rodap�
	$AttribAtual = $ObjMySql->CltAttribAtualizacao();
	$AttribRodape00='Politica de privacidade';				$AttribRodapeLink00='#';		$AttribRodapeImg00='wikimedia.png';
	$AttribRodape01='AttribAtualizacao: '/*.$AttribAtual[0]*/;	$AttribRodapeLink01= '#';		$AttribRodapeImg01='mediawiki.png';

	//****************************************************************************************************/	

?>
