<style type="text/css">

/* Tabela Master-inicial */

		body { 	
			background: #ffffff;
			color: #000; font-size: 11px;
			font-family: Verdana, sans-serif;
			margin: 0; padding: 0;
			text-align: center;
		}
		#geral {
			background: #FFF;
			border: #000 1px solid;
			width: auto;
			margin: auto;
			text-align: center;
			float: center;
		}
		

.TAB_Geral{ 
	border: none;				
	border-width: 1px; 		
	border-color: none;
	background-color: <?Php echo"$ThemeCorFundoTbGeral"; ?>; 
	font-family: verdana, arial; 
	font-size: 10pt; 
}
/* Tabela geral lado esquerdo */
.TAB_GeralEsq
{ 
	border: none;				
	border-width: 1px; 		
	border-color: none;
	background-color: <?Php echo"$ThemeCorFundoTbGeral"; ?>; 
	font-family: verdana, arial; 
	font-size: 10pt; 
}
		/* Tabela Menu esquerdo */
		.TAB_MenuEsq
		{ 
			border: none;				
			border-width: 1px; 		
			border-color: none;
			background-color: <?Php echo"$ThemeCorFundoTbGeral"; ?>; 
			font-family: verdana, arial; 
			font-size: 10pt; 
		}


		
/* Tabela geral lado direito */
.TAB_GeralDireito
{ 
	border: none;				
	border-width: none; 		
	border-color: none;
	background-color: <?Php echo"$ThemeCorFundoTbGeral"; ?>;
	font-family: verdana, arial; 
	font-size: 10pt; 
}

	/* Tabela de conteudo - Contorno */ 
	.TAB_MainConteudoExtMargem
	{ 
		border: 1px solid <?Php echo"$ThemeCorBordaTbCont"; ?>; 
		border-width: 1px; 		
		border-color: none;
		background-color: <?Php echo"$ThemeCorFundoTbCont"; ?>; 
		height: 400px;
	}
	/* Tabela de conteudo - sem Contorno */ 
	.TAB_MainConteudoExt
	{ 
		border: none;
		border-width: none; 		
		border-color: none;
		background-color: none; 
	}

		/* Tabela de conteudo - distanciamento das bordas */
		.TAB_MainConteudoInt
		{ 
			border: none;				
			border-width: none; 		
			border-color: none;
			background-color: NONE;
		} 

			/* Tabela de conteudo(Indice) - Somente a margem */
			.TAB_ConteudoIntMargem
			{ 
				border: 1px solid <?Php echo"$ThemeCorBordaTbInd"; ?>;				
				border-width: 1px; 		
				border-color: <?Php echo"$ThemeCorBordaTbInd"; ?>;
				background-color: <?Php echo"$ThemeCorFundoTbInd"; ?>; 
			} 

			/* Tabela de conteudo(Indice) - Sem margem */
			.TAB_ConteudoInt
			{ 
				border: none;
				border-width: none; 		
				border-color: <?Php echo"$ThemeCorBordaTbInd"; ?>;
				background-color: <?Php echo"$ThemeCorFundoTbInd"; ?>; 
				font-family: verdana, arial; 
				font-size: 12pt; 	
				font-weight: normal;	
			}

				/* Titulo(Procedimento, descri��o) */
				.TAB_ConteudoTitulo
				{ 
					border: none;				
					border-width: none; 		
					border-color: <?Php echo"$ThemeCorFundoTbCont"; ?>;
					background-color: <?Php echo"$ThemeCorFundoTbCont"; ?>; 	
				} 
				
				/* Tabela Conteudo da pesquisa(Amostragem do comando) */
				.TAB_ConteudoPsq
				{ 
					/* border-style: dotted;  				// Pontilhada */
					border: 1px dashed <?Php echo"$ThemeCorBordaTbContPsq"; ?>;				/* Tracejada */	
					border-width: 1px; 						/* Largura da borda */
					border-color: <?Php echo"$ThemeCorBordaTbContPsq"; ?>;					/* Cor da borda */
					background-color: <?Php echo"$ThemeCorFundoTbContPsq"; ?>;				/* Cor de fundo */
					font-family: verdana, arial; 			/* Tipo texto */
					font-size: 8pt; 						/* tamanho do texto */
					font-style: italic;
				} 
				
/* Tabela Rodape */
.TAB_Rodape
{ 
	border: none;				
	border-width: 1px; 		
	border-color: none;	
	font-family: verdana, arial; 
	font-size: 10pt; 
}

			/* Tabela de Login - Somente a margem */
			.TAB_MargemLogin
			{ 
				border: 1px solid #0099CC;				
				border-width: 1px; 		
				border-color: #C0C0C0;
				background-color: #F6F6F6; 
			} 

			/* Tabela de Login - Sem margem */
			.TAB_Login
			{ 
				border: none;
				border-width: none; 		
				border-color: #C0C0C0;
				background-color: #F6F6F6; 
				font-family: verdana, arial; 
				font-size: 12pt; 	
				font-weight: normal;	
			}
				
/* --------------------------------------------------------------------------------------------------------------------------------------*/	
</style>
<?php $objFuncao->RegistrarLog('tabelas.inc(css);'); ?>