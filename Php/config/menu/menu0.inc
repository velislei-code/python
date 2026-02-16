<style type="text/css">
/* ------------------------------------------------------------ MENU 1 --------------------------------------------------------------------------*/			
		.menu 
		{											/* Barra do menu */
			background: <?Php echo"$CorBarMenu"; ?>;   	/* cor da barra de menu*/
			height: 0px;								/* Largura da barra de menu */
			margin-bottom: 0px; 
			margin-left: 1px; 
			margin-right: 1px;									
			padding: 0px;								/* Espessura da margem externa da barra de menu*/
			border-bottom: 0px solid <?Php echo"$CorBordaAbaMenu";?>;
			/* border-top-color: white;  */ 
			border-top-width: 0px; 
			border-bottom-width: 0px;
			COLOR: #0000CD;								/* Cor da fonte */
			FONT-FAMILY: Verdana;						/* Tipo de fonte */
			FONT-SIZE: 9pt;								/* Tamanho da fonte */
			TEXT-DECORATION: none;						/* underline p/ sublinhar */
			FONT-WEIGHT: none;							/* ? */
		}
		
		.menu li 
		{
			 display: inline;

		}
		
		.menu li a 
		{														/* ABAS-SEM CLICK */
			background: <?Php echo"$CorAbaInativa";?>;						/* Cor da Aba inativa */
			color: <?Php echo"$CorTxtAbaInativa";?>;  						/* Cor da letra das abas Link1, 2, 3, ...*/
			border: 1px solid <?Php echo"$CorBordaAbaMenu";?>;				/* Espessura(laterais e superior) da margem das abas #4682B4 */
			border-width: 1px; 												/* Espessura da borda */
			border-bottom: 0px solid <?Php echo"$CorBordaAbaMenu";?>;		/* Largura linha inferior das abas */
			/* border-top-color: white;  */ 
			border-top-width: 1px; 
			float: left;													/* Posição das Abas (a esquerda) */	
			padding: 5px 7px;												/* Altura e Largura das Abas*/	
			margin-bottom: 0px; 
			margin-left: 1px; 
			margin-right: 1px;													/* Espaço em torno(entre) da Aba*/
			text-decoration: none;
		}
		.menu li a:hover 
		{												/* ABAS-Mouse Passe */
			background: <?Php echo"$CorAbaMousePasse";?>;					/* Cor de fundo da Aba ao passar o mouse */
			color: <?Php echo"$TxtAbaMousePasse";?>;						/* Cor da letra da aba */
			border: 1px solid <?Php echo"$CorBordaAbaMenu";?>;				/* Espessura da borda */
			border-bottom: none;
			border-width: 1px; 												/* Espessura da borda */
			/* border-top-color: white;  */ 
			border-top-width: 1px; 

			text-decoration: none;
		}
		.menu li.selecionado a
		{	
			background: <?Php echo"$CorFundoTbCont";?>;					/* Cor de fundo da Aba Ativa*/
			color: #004080;												/* Cor da letra das abas Link1, 2, 3, ...*/
		/**/border: 1px solid <?Php echo"$CorBordaAbaMenu";?>;			/* Espessura da margem das abas */
			border-bottom: 0px  #FFF solid;								/* Altura da barra inferior das abas */			
			float: left;												/* Posição das Abas (a esquerda) */	
			padding: 5px 7px;											/* Altura e Largura das Abas*/	
		/**/margin-bottom: 0px; 
			margin-left: 1px; 
			margin-right: 1px;												/* Espaço em torno(entre) da Aba*/
			text-decoration: none;						
		}		

		.menu li.selecionado a:hover 
		{	
			background: <?Php echo"$CorFundoTbCont";?>;					/* Cor de fundo da Aba Ativa*/
			color: #004080;												/* Cor da letra das abas Link1, 2, 3, ...*/
			border: 1px solid <?Php echo"$CorBordaAbaMenu";?>;		    /* Espessura da margem das abas */
			border-bottom: 0px solid <?Php echo"$CorBordaAbaMenu";?>;	/* Altura da barra inferior das abas */									
			float: left;												/* Posição das Abas (a esquerda) */	
			padding: 5px 7px;											/* Altura e Largura das Abas*/	
			margin-bottom: 0px; 
			margin-left: 1px; 
			margin-right: 1px;												/* Espaço em torno(entre) da Aba*/
			text-decoration: none;
		}

		/* ABA ANTERIOR A SELECIONADA */	
		.menu li.rastro a
		{	
			background: <?Php echo"$CorRastroAba";?>;					/* Cor de fundo da Aba Ativa*/
			color: <?Php echo"$CorTxtAbaInativa";?>;					/* Cor da letra das abas Link1, 2, 3, ...*/
		/**/border: 1px solid <?Php echo"$CorBordaAbaMenu";?>;			/* Espessura da margem das abas */
			border-bottom: 0px  #FFF solid;								/* Altura da barra inferior das abas */			
			float: left;												/* Posição das Abas (a esquerda) */	
			padding: 5px 7px;											/* Altura e Largura das Abas*/	
		/**/margin-bottom: 0px; 
			margin-left: 1px; 
			margin-right: 1px;												/* Espaço em torno(entre) da Aba*/
			text-decoration: none;						
		}		

		.menu li.rastro a:hover 
		{	
			background: <?Php echo"$CorFundoTbCont";?>;					/* Cor de fundo da Aba Ativa*/
			color: #004080;												/* Cor da letra das abas Link1, 2, 3, ...*/
			border: 1px solid <?Php echo"$CorBordaAbaMenu";?>;		    /* Espessura da margem das abas */
			border-bottom: 0px solid <?Php echo"$CorBordaAbaMenu";?>;	/* Altura da barra inferior das abas */									
			float: left;												/* Posição das Abas (a esquerda) */	
			padding: 5px 7px;											/* Altura e Largura das Abas*/	
			margin-bottom: 0px; 
			margin-left: 1px; 
			margin-right: 1px;												/* Espaço em torno(entre) da Aba*/
			text-decoration: none;

		}
		
		/* Cria espaco entre as Abas */
		.menu li.espaco a
		{										
			background: <?Php echo"$CorBarMenu"; ?>;					/* Cor de fundo da Aba Ativa */
			color: <?Php echo"$CorBarMenu"; ?>;							/* Cor da letra das abas Link1, 2, 3, ...*/
			border: 0px solid <?Php echo"$CorBarMenu"; ?>;				/* Espessura da margem das abas */
			border-bottom: 0px solid <?Php echo"$CorBarMenu";?>; /*1px solid <?Php echo"$CorFundoBody"; ?>;		/* Altura da barra inferior das abas */
			float: left;
			padding: 5px 7px;
			margin-bottom: 0px; 
			margin-left: 1px; 
			margin-right: 1px;
			text-decoration: none;
		}				
		.menu li.espaco a:hover
		{	
			background: <?Php echo"$CorBarMenu"; ?>;					/* Cor de fundo da Aba Ativa */
			color: <?Php echo"$CorBarMenu"; ?>;							/* Cor da letra das abas Link1, 2, 3, ...*/
			border: 0px solid <?Php echo"$CorBarMenu"; ?>;				/* Espessura da margem das abas */
			border-bottom: 0px solid <?Php echo"$CorBarMenu";?>; /*1px solid <?Php echo"$CorFundoBody"; ?>;		/* Altura da barra inferior das abas */
			float: left;
			padding: 5px 7px;
			margin-bottom: 0px; 
			margin-left: 1px; 
			margin-right: 1px;
			text-decoration: none;

		}				

</style>
<?Php	