

<?Php
	
	// Valores Padr�o
		$ThemeCorFundoBody = '#DCDCDC';	
		$ThemeTexto = '#006400'; //'#00688B';
		$ThemeTabExt = '#FFFFFF';
		$ThemeBordaExt = '#004080';
		$ThemeTabInt = '#F6F6F6';
		$ThemeBordaInt = '#004080';
		$ThemeTabPsq = '#ffffff';
		$ThemeBordaPsq = '#004080';
		
		// IMAGENS
		$ThemeGlobo='gaviao.jpg';//HiTech.gif'; 				// Logo da p�gina(globo1.jpg, globo2.jpg, globo3.png, globo4.jpg)
		$ThemeCorLinhaMenu='tema/linDEDEDF.png';			// Linha de separa��o Menu left - Deve acompanhar CorDeFundo	
		$ThemeMenuLinguaSel00='tema/downFFF.png';		// Triangulo de lingua
		$ThemeMenuLinguaSel01='tema/NvistoFFF.png';	// N�o Selec.
		$ThemeMenuLinguaSel02='tema/NvistoFFF.png';	// N�o selecionado
		$ThemeMenuLinguaSel03='tema/vistoFFF.png';		// Selecionado
		$ThemeTopoImg00='tema/favFFF.png';				// Pasta favoritos
		$ThemeTopoImg01='tema/userFFF.png';			// Bonequinho user
		$ThemeCorLinhaLonga='tema/linlgFFFFFF.png';	// Linha Deve acompanhar CorDeFundo CONTEUDO	
		
	
	
	if(! isset($_COOKIE['TemaFundoCookie'])){ 
	// Se n�o existe...Cria Cookies
			
		//setcookie ("TemaFundoCookie", 'Cinza'); 
		//setcookie ("TemaMenuCookie", 'Estilo(Win)'); 
		//setcookie ("TemaTextoCookie", 'Marinho'); 
		//setcookie ("TemaBordaExtCookie", 'Marinho'); 
		//setcookie ("TemaTabExtCookie", 'Branco'); 
		//setcookie ("TemaBordaIntCookie", 'Marinho'); 
		//setcookie ("TemaTabIntCookie", 'Cinza'); 
		//setcookie ("TemaBordaPsqCookie", 'Marinho'); 
		//setcookie ("TemaTabPsqCookie", 'Branco'); 
	
		
	}
	
	if(isset($_COOKIE['TemaFundoCookie'])){ 
	
		if($_COOKIE['TemaFundoCookie']=='Branco'){ 

			$ThemeCorFundoBody = '#ffffff';	
		
			// IMAGENS
			$ThemeGlobo='1_tema/Logo.png'; //'1_tema/HiTech.gif';				// Logo da p�gina(globo1.jpg, globo2.jpg, globo3.png, globo4.jpg)
			$ThemeCorLinhaMenu='tema/linDEDEDF.png';			// Linha de separa��o Menu left - Deve acompanhar CorDeFundo	
			$ThemeMenuLinguaSel00='tema/downFFF.png';		// Triangulo de lingua
			$ThemeMenuLinguaSel01='tema/NvistoFFF.png';	// N�o Selec.
			$ThemeMenuLinguaSel02='tema/NvistoFFF.png';	// N�o selecionado
			$ThemeMenuLinguaSel03='tema/vistoFFF.png';		// Selecionado
			$ThemeTopoImg00='tema/favFFF.png';				// Pasta favoritos
			$ThemeTopoImg01='tema/userFFF.png';			// Bonequinho user
			$ThemeCorLinhaLonga='tema/linlgFFFFFF.png';	// Linha Deve acompanhar CorDeFundo CONTEUDO	
		
		}
	
		if($_COOKIE['TemaFundoCookie']=='Cinza')
		{
			$ThemeCorFundoBody = '#F6F6F6';	
		
			// IMAGENS - aki
			$ThemeGlobo='tema/logo2.png';// HiTech.gif'; //F6F6F6.jpg;				// Logo da p�gina(globo1.jpg, globo2.jpg, globo3.png, globo4.jpg)
			$ThemeCorLinhaMenu='tema/linF6F6F6.png';			// Linha de separa��o Menu left - Deve acompanhar CorDeFundo	
			$ThemeMenuLinguaSel00='tema/downF6F6F6.png';		// Triangulo de lingua
			$ThemeMenuLinguaSel01='tema/NvistoF6F6F6.png';	// N�o Selec.
			$ThemeMenuLinguaSel02='tema/NvistoF6F6F6.png';	// N�o selecionado
			$ThemeMenuLinguaSel03='tema/vistoF6F6F6.png';		// Selecionado
			$ThemeTopoImg00='tema/favF6F6F6.png';				// Pasta favoritos
			$ThemeTopoImg01='tema/userF6F6F6.png';			// Bonequinho user
			$ThemeCorLinhaLonga='tema/linlgFFFFFF.png';	// Linha Deve acompanhar CorDeFundo CONTEUDO


		}	
		if($_COOKIE['TemaFundoCookie']=='Ciano')
		{
			$ThemeCorFundoBody = '#CEDFF2';	
		
			// IMAGENS	
			$ThemeGlobo='tema/globoB0C4DE.jpg';				// Logo da p�gina(globo1.jpg, globo2.jpg, globo3.png, globo4.jpg)
			$ThemeCorLinhaMenu='tema/linB0C4DE.png';			// Linha de separa��o Menu left - Deve acompanhar CorDeFundo	
			$ThemeMenuLinguaSel00='tema/downB0C4DE.png';		// Triangulo de lingua
			$ThemeMenuLinguaSel01='tema/NvistoB0C4DE.png';	// N�o Selec.
			$ThemeMenuLinguaSel02='tema/NvistoB0C4DE.png';	// N�o selecionado
			$ThemeMenuLinguaSel03='tema/vistoB0C4DE.png';		// Selecionado
			$ThemeTopoImg00='tema/favB0C4DE.png';				// Pasta favoritos
			$ThemeTopoImg01='tema/userB0C4DE.png';			// Bonequinho user		
			$ThemeCorLinhaLonga='tema/linlgFFFFFF.png';	// Linha Deve acompanhar CorDeFundo CONTEUDO	
		
		}	
		if($_COOKIE['TemaFundoCookie']=='Laranja')
		{
			$ThemeCorFundoBody = '#EE9A00';
		
			$ThemeGlobo='globoB0C4DE.jpg';				// Logo da p�gina(globo1.jpg, globo2.jpg, globo3.png, globo4.jpg)
			$ThemeCorLinhaMenu='linB0C4DE.png';			// Linha de separa��o Menu left - Deve acompanhar CorDeFundo	
			$ThemeMenuLinguaSel00='downB0C4DE.png';		// Triangulo de lingua
			$ThemeMenuLinguaSel01='NvistoB0C4DE.png';	// N�o Selec.
			$ThemeMenuLinguaSel02='NvistoB0C4DE.png';	// N�o selecionado
			$ThemeMenuLinguaSel03='vistoB0C4DE.png';		// Selecionado
			$ThemeTopoImg00='favB0C4DE.png';				// Pasta favoritos
			$ThemeTopoImg01='userB0C4DE.png';			// Bonequinho user		
			$ThemeCorLinhaLonga='linlgFFFFFF.png';	// Linha Deve acompanhar CorDeFundo CONTEUDO	
		
		}	
	
		if($_COOKIE['TemaFundoCookie']=='Verde')
		{
			$ThemeCorFundoBody = '#008B00';
				
			$ThemeGlobo='globoB0C4DE.jpg';				// Logo da p�gina(globo1.jpg, globo2.jpg, globo3.png, globo4.jpg)
			$ThemeCorLinhaMenu='linB0C4DE.png';			// Linha de separa��o Menu left - Deve acompanhar CorDeFundo	
			$ThemeMenuLinguaSel00='downB0C4DE.png';		// Triangulo de lingua
			$ThemeMenuLinguaSel01='NvistoB0C4DE.png';	// N�o Selec.
			$ThemeMenuLinguaSel02='NvistoB0C4DE.png';	// N�o selecionado
			$ThemeMenuLinguaSel03='vistoB0C4DE.png';		// Selecionado
			$ThemeTopoImg00='favB0C4DE.png';				// Pasta favoritos
			$ThemeTopoImg01='userB0C4DE.png';			// Bonequinho user		
			$ThemeCorLinhaLonga='linlgFFFFFF.png';		// Linha Deve acompanhar CorDeFundo CONTEUDO	
		}	
	}
	if(isset($_COOKIE['TemaTextoCookie'])){
		if($_COOKIE['TemaTextoCookie']=='Padrao'){ $ThemeTexto = '#004080'; }		
		if($_COOKIE['TemaTextoCookie']=='Branco'){ $ThemeTexto = '#FFFFFF'; }	
		if($_COOKIE['TemaTextoCookie']=='Ciano'){ $ThemeTexto = '#CEDFF2'; }	
		if($_COOKIE['TemaTextoCookie']=='Marinho'){ $ThemeTexto = '#00688B'; }	
		if($_COOKIE['TemaTextoCookie']=='Grafite'){ $ThemeTexto = '#808080'; }	
		if($_COOKIE['TemaTextoCookie']=='Cinza'){ $ThemeTexto = '#F6F6F6'; }	
		if($_COOKIE['TemaTextoCookie']=='Verde'){ $ThemeTexto = '#008B00'; }	
		if($_COOKIE['TemaTextoCookie']=='Musgo'){ $ThemeTexto = '#006400'; } //'#556B2F'; }	
		if($_COOKIE['TemaTextoCookie']=='Marrom'){ $ThemeTexto = '#8B864E'; }	
		if($_COOKIE['TemaTextoCookie']=='Laranja'){ $ThemeTexto = '#EE9A00'; }	
		if($_COOKIE['TemaTextoCookie']=='Amarelo'){ $ThemeTexto = '#FFF68F'; }	
		if($_COOKIE['TemaTextoCookie']=='Vermelho'){ $ThemeTexto = '#FF0000'; }	
	}
	if(isset($_COOKIE['TemaBordaExtCookie'])){
		if($_COOKIE['TemaBordaExtCookie']=='Padr�o'){	$ThemeBordaExt = '#004080'; }		
		if($_COOKIE['TemaBordaExtCookie']=='Branco'){	$ThemeBordaExt = '#FFFFFF'; }	
		if($_COOKIE['TemaBordaExtCookie']=='Ciano'){	$ThemeBordaExt = '#CEDFF2'; }	
		if($_COOKIE['TemaBordaExtCookie']=='Marinho'){	$ThemeBordaExt = '#00688B'; }	
		if($_COOKIE['TemaBordaExtCookie']=='Grafite'){	$ThemeBordaExt = '#808080'; }	
		if($_COOKIE['TemaBordaExtCookie']=='Cinza'){	$ThemeBordaExt = '#F6F6F6'; }	
		if($_COOKIE['TemaBordaExtCookie']=='Verde'){	$ThemeBordaExt = '#008B00'; }	
		if($_COOKIE['TemaBordaExtCookie']=='Musgo'){	$ThemeBordaExt = '#556B2F'; }	
		if($_COOKIE['TemaBordaExtCookie']=='Marrom'){	$ThemeBordaExt = '#8B864E'; }	
		if($_COOKIE['TemaBordaExtCookie']=='Laranja'){	$ThemeBordaExt = '#EE9A00'; }	
		if($_COOKIE['TemaBordaExtCookie']=='Amarelo'){	$ThemeBordaExt = '#FFF68F'; }	
		if($_COOKIE['TemaBordaExtCookie']=='Vermelho'){ $ThemeBordaExt = '#FF0000'; }	
	}

	if(isset($_COOKIE['TemaTabExtCookie'])){
		if($_COOKIE['TemaTabExtCookie']=='Padrao'){	$ThemeTabExt = '#004080'; }		
		if($_COOKIE['TemaTabExtCookie']=='Branco'){	$ThemeTabExt = '#FFFFFF'; }	
		if($_COOKIE['TemaTabExtCookie']=='Ciano'){	$ThemeTabExt = '#CEDFF2'; }	
		if($_COOKIE['TemaTabExtCookie']=='Marinho'){	$ThemeTabExt = '#00688B'; }	
		if($_COOKIE['TemaTabExtCookie']=='Grafite'){	$ThemeTabExt = '#808080'; }	
		if($_COOKIE['TemaTabExtCookie']=='Cinza'){	$ThemeTabExt = '#F6F6F6'; }	
		if($_COOKIE['TemaTabExtCookie']=='Verde'){	$ThemeTabExt = '#008B00'; }	
		if($_COOKIE['TemaTabExtCookie']=='Musgo'){	$ThemeTabExt = '#556B2F'; }	
		if($_COOKIE['TemaTabExtCookie']=='Marrom'){	$ThemeTabExt = '#8B864E'; }	
		if($_COOKIE['TemaTabExtCookie']=='Laranja'){	$ThemeTabExt = '#EE9A00'; }	
		if($_COOKIE['TemaTabExtCookie']=='Amarelo'){	$ThemeTabExt = '#FFF68F'; }	
		if($_COOKIE['TemaTabExtCookie']=='Vermelho'){ $ThemeTabExt = '#FF0000'; }	
	}
	
	if(isset($_COOKIE['TemaBordaIntCookie'])){
		if($_COOKIE['TemaBordaIntCookie']=='Branco'){	$ThemeBordaInt = '#004080'; }
		if($_COOKIE['TemaBordaIntCookie']=='Padrao'){	$ThemeBordaInt = '#004080'; }		
		if($_COOKIE['TemaBordaIntCookie']=='Branco'){	$ThemeBordaInt = '#FFFFFF'; }	
		if($_COOKIE['TemaBordaIntCookie']=='Ciano'){	$ThemeBordaInt = '#CEDFF2'; }	
		if($_COOKIE['TemaBordaIntCookie']=='Marinho'){	$ThemeBordaInt = '#00688B'; }	
		if($_COOKIE['TemaBordaIntCookie']=='Grafite'){	$ThemeBordaInt = '#808080'; }	
		if($_COOKIE['TemaBordaIntCookie']=='Cinza'){	$ThemeBordaInt = '#F6F6F6'; }	
		if($_COOKIE['TemaBordaIntCookie']=='Verde'){	$ThemeBordaInt = '#008B00'; }	
		if($_COOKIE['TemaBordaIntCookie']=='Musgo'){	$ThemeBordaInt = '#556B2F'; }	
		if($_COOKIE['TemaBordaIntCookie']=='Marrom'){	$ThemeBordaInt = '#8B864E'; }	
		if($_COOKIE['TemaBordaIntCookie']=='Laranja'){	$ThemeBordaInt = '#EE9A00'; }	
		if($_COOKIE['TemaBordaIntCookie']=='Amarelo'){	$ThemeBordaInt = '#FFF68F'; }	
		if($_COOKIE['TemaBordaIntCookie']=='Vermelho'){ $ThemeBordaInt = '#FF0000'; }	
	}
	
	if(isset($_COOKIE['TemaTabIntCookie'])){
		if($_COOKIE['TemaTabIntCookie']=='Branco'){	$ThemeTabInt = '#004080'; }	
		if($_COOKIE['TemaTabIntCookie']=='Padrao'){	$ThemeTabInt = '#004080'; }		
		if($_COOKIE['TemaTabIntCookie']=='Branco'){	$ThemeTabInt = '#FFFFFF'; }	
		if($_COOKIE['TemaTabIntCookie']=='Ciano'){	$ThemeTabInt = '#CEDFF2'; }	
		if($_COOKIE['TemaTabIntCookie']=='Marinho'){$ThemeTabInt = '#00688B'; }	
		if($_COOKIE['TemaTabIntCookie']=='Grafite'){$ThemeTabInt = '#808080'; }	
		if($_COOKIE['TemaTabIntCookie']=='Cinza'){	$ThemeTabInt = '#F6F6F6'; }	
		if($_COOKIE['TemaTabIntCookie']=='Verde'){	$ThemeTabInt = '#008B00'; }	
		if($_COOKIE['TemaTabIntCookie']=='Musgo'){	$ThemeTabInt = '#556B2F'; }	
		if($_COOKIE['TemaTabIntCookie']=='Marrom'){	$ThemeTabInt = '#8B864E'; }	
		if($_COOKIE['TemaTabIntCookie']=='Laranja'){$ThemeTabInt = '#EE9A00'; }	
		if($_COOKIE['TemaTabIntCookie']=='Amarelo'){$ThemeTabInt = '#FFF68F'; }	
		if($_COOKIE['TemaTabIntCookie']=='Vermelho'){$ThemeTabInt = '#FF0000'; }	
	}
	if(isset($_COOKIE['TemaBordaPsqCookie'])){
		if($_COOKIE['TemaBordaPsqCookie']=='Branco'){	$ThemeBordaPsq = '#004080'; }
		if($_COOKIE['TemaBordaPsqCookie']=='Padrao'){	$ThemeBordaPsq = '#004080'; }		
		if($_COOKIE['TemaBordaPsqCookie']=='Branco'){	$ThemeBordaPsq = '#FFFFFF'; }	
		if($_COOKIE['TemaBordaPsqCookie']=='Ciano'){	$ThemeBordaPsq = '#CEDFF2'; }	
		if($_COOKIE['TemaBordaPsqCookie']=='Marinho'){	$ThemeBordaPsq = '#00688B'; }	
		if($_COOKIE['TemaBordaPsqCookie']=='Grafite'){	$ThemeBordaPsq = '#808080'; }	
		if($_COOKIE['TemaBordaPsqCookie']=='Cinza'){	$ThemeBordaPsq = '#F6F6F6'; }	
		if($_COOKIE['TemaBordaPsqCookie']=='Verde'){	$ThemeBordaPsq = '#008B00'; }	
		if($_COOKIE['TemaBordaPsqCookie']=='Musgo'){	$ThemeBordaPsq = '#556B2F'; }	
		if($_COOKIE['TemaBordaPsqCookie']=='Marrom'){	$ThemeBordaPsq = '#8B864E'; }	
		if($_COOKIE['TemaBordaPsqCookie']=='Laranja'){	$ThemeBordaPsq = '#EE9A00'; }	
		if($_COOKIE['TemaBordaPsqCookie']=='Amarelo'){	$ThemeBordaPsq = '#FFF68F'; }	
		if($_COOKIE['TemaBordaPsqCookie']=='Vermelho'){ $ThemeBordaPsq = '#FF0000'; }	
	}
	if(isset($_COOKIE['TemaTabPsqCookie'])){	
		if($_COOKIE['TemaTabPsqCookie']=='Branco'){	$ThemeTabPsq = '#004080'; }	
		if($_COOKIE['TemaTabPsqCookie']=='Padrao'){	$ThemeTabPsq = '#004080'; }		
		if($_COOKIE['TemaTabPsqCookie']=='Branco'){	$ThemeTabPsq = '#FFFFFF'; }	
		if($_COOKIE['TemaTabPsqCookie']=='Ciano'){	$ThemeTabPsq = '#CEDFF2'; }	
		if($_COOKIE['TemaTabPsqCookie']=='Marinho'){$ThemeTabPsq = '#00688B'; }	
		if($_COOKIE['TemaTabPsqCookie']=='Grafite'){$ThemeTabPsq = '#808080'; }	
		if($_COOKIE['TemaTabPsqCookie']=='Cinza'){	$ThemeTabPsq = '#F6F6F6'; }	
		if($_COOKIE['TemaTabPsqCookie']=='Verde'){	$ThemeTabPsq = '#008B00'; }	
		if($_COOKIE['TemaTabPsqCookie']=='Musgo'){	$ThemeTabPsq = '#556B2F'; }	
		if($_COOKIE['TemaTabPsqCookie']=='Marrom'){	$ThemeTabPsq = '#8B864E'; }	
		if($_COOKIE['TemaTabPsqCookie']=='Laranja'){$ThemeTabPsq = '#EE9A00'; }	
		if($_COOKIE['TemaTabPsqCookie']=='Amarelo'){$ThemeTabPsq = '#FFF68F'; }	
		if($_COOKIE['TemaTabPsqCookie']=='Vermelho'){$ThemeTabPsq = '#FF0000'; }	
	}						
	
	
		
		// tabela Geral
		$ThemeCorFundoTbGeral = $ThemeCorFundoBody;						
		$ThemeCorTxtItemMenu=$ThemeTexto;				// Cor texto item de menu(Cont�m op��es internas)
		$ThemeCorTxtTopo=$ThemeTexto;					// Cor de texto no AttribTopo		
		$ThemeCorTxtMenuEsq=$ThemeTexto;				// Cor texto menu esquerdo
		
		$ThemeCorTxtRodape=$ThemeTexto;				// Cor texto rodape
	
		// tabela conteudo
		$ThemeCorFundoTbCont = $ThemeTabExt;
		$ThemeCorBordaTbCont = $ThemeBordaExt;
		
		// Tabela �ndice
		$ThemeCorFundoTbInd = $ThemeTabInt; 
		$ThemeCorBordaTbInd = $ThemeBordaInt; 
		$ThemeCorTxtTopico = $ThemeTexto;
		$ThemeCorTxtIndice = $ThemeTexto;

		
		// Tabela pesquisa(Tracejada)		
		$ThemeCorFundoTbContPsq = $ThemeTabPsq;		
		$ThemeCorBordaTbContPsq = $ThemeBordaPsq;

		// MENU DE ABAS
		$ThemeCorBarMenu = $ThemeCorFundoTbGeral;
		$ThemeCorBordaAbaMenu = '#CEDFF2';
		$ThemeCorAbaInativa = '#CEDFF2';
		$ThemeCorRastroAba = '#E8E8E8';				// Aba anterior		
		$ThemeCorTxtAbaInativa = '#808080';
		$ThemeCorAbaMousePasse = '#FFFFFF';
		$ThemeTxtAbaMousePasse = '#808080';
	
		
				
?>
<?php //$objFuncao->RegistrarLog('theme.inc;'); ?>