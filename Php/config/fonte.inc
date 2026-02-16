<style type="text/css">
/* ------------------------------------------------------------ FONTE --------------------------------------------------------------------------*/	
	.circle-image {
		  display: built-in block; /*display: bloco embutido;*/		  
		  border-radius: 50%;
		  overflow: hidden; /*estouro: oculto;*/
		  width: 120px;
		  height: 120px;
		 
}
	.circle-image img {
		  border-radius: 50%;
		  object setting : cape; /* ajuste do objeto : capa; */
		   width: 120px;
		  height: 120px;
		  
	}

	
	a.fonte_AttribTopo{
			COLOR: <?Php echo"$ThemeCorTxtTopo"; ?>;
			FONT-FAMILY: Verdana;
			FONT-SIZE: 8pt;
			TEXT-DECORATION: none;
			FONT-WEIGHT: none;
		}
		a.fonte_AttribTopo:hover{
			COLOR: <?Php echo"$ThemeCorTxtTopo"; ?>;
			FONT-FAMILY: Verdana;
			FONT-SIZE: 8pt;
			TEXT-DECORATION: underline;
			FONT-WEIGHT: none;
		}
		a.fonte_topico{
			COLOR: <?Php echo"$ThemeCorTxtTopico"; ?>;
			FONT-FAMILY: Verdana;
			FONT-SIZE: 11pt;
			TEXT-DECORATION: none;
			FONT-WEIGHT: none;
		}
		a.fonte_topico:hover{
			COLOR: <?Php echo"$ThemeCorTxtTopico"; ?>;
			FONT-FAMILY: Verdana;
			FONT-SIZE: 11pt;
			TEXT-DECORATION: underline;
			FONT-WEIGHT: none;
		}
		a.fonte_titulo{
			COLOR: #0000CD;
			FONT-FAMILY: Verdana;
			FONT-SIZE: 10pt;
			TEXT-DECORATION: none;
			FONT-WEIGHT: none;
		}
		a.fonte_titulo:hover{
			COLOR: #0000CD;
			FONT-FAMILY: Verdana;
			FONT-SIZE: 10pt;
			TEXT-DECORATION: underline;
			FONT-WEIGHT: none;
		}
		a.fonte_lista{
			COLOR: <?Php echo"$CorTxtLista"; ?>;
			FONT-FAMILY: Verdana;
			FONT-SIZE: 9pt;
			TEXT-DECORATION: none;
			FONT-WEIGHT: none;
		}
		a.fonte_lista:hover{
			COLOR: <?Php echo"$CorTxtLista"; ?>;
			FONT-FAMILY: Verdana;
			FONT-SIZE: 9pt;
			TEXT-DECORATION: underline;
			FONT-WEIGHT: none;
		}

		a.fonte_item_menu{
			COLOR: <?Php echo"$ThemeCorTxtItemMenu"; ?>;
			FONT-FAMILY: Verdana;
			FONT-SIZE: 9pt;
			TEXT-DECORATION: none;
			FONT-WEIGHT: none;
		}
		a.fonte_item_menu:hover{
			COLOR: <?Php echo"$ThemeCorTxtItemMenu"; ?>;
			FONT-FAMILY: Verdana;
			FONT-SIZE: 9pt;
			TEXT-DECORATION: none;
			FONT-WEIGHT: none;
		}
		
	a.fonte_menu_esq{
			COLOR: <?Php echo"$ThemeCorTxtMenuEsq"; ?>;
			FONT-FAMILY: Verdana;
			FONT-SIZE: 9pt;
			TEXT-DECORATION: none;
			FONT-WEIGHT: none;
		}
		a.fonte_menu_esq:hover{
			COLOR: <?Php echo"$ThemeCorTxtMenuEsq"; ?>;
			FONT-FAMILY: Verdana;
			FONT-SIZE: 9pt;
			TEXT-DECORATION: underline;
			FONT-WEIGHT: none;
		}
		

		a.fonte_info{
			COLOR: #008B00;
			FONT-FAMILY: Verdana;
			FONT-SIZE: 12pt;
			TEXT-DECORATION: none;
			FONT-WEIGHT: none;
		}
		a.fonte_atencao{
			COLOR: #FF0000;
			FONT-FAMILY: Verdana;
			FONT-SIZE: 12pt;
			TEXT-DECORATION: none;
			FONT-WEIGHT: none;
		}
		a.fonte_atencao:hover{
			COLOR: #FF0000;
			FONT-FAMILY: Verdana;
			FONT-SIZE: 12pt;
			TEXT-DECORATION: underline;
			FONT-WEIGHT: none;
			cursor: pointer;
		}

		a.fonte_descricao{
			COLOR: #000000;
			FONT-FAMILY: Verdana;
			FONT-SIZE: 10pt;
			TEXT-DECORATION: none;
			FONT-WEIGHT: none;
		}
		a.fonte_descricao:hover{
			COLOR: #000000;
			FONT-FAMILY: Verdana;
			FONT-SIZE: 10pt;
			TEXT-DECORATION: none;
			FONT-WEIGHT: none;
		}
				
		a.fonte_rodape{
			COLOR: <?Php echo"$ThemeCorTxtRodape";?>;
			FONT-FAMILY: Verdana;
			FONT-SIZE: 8pt;
			TEXT-DECORATION: none;
			FONT-WEIGHT: none;
		}
		a.fonte_rodape:hover{
			COLOR: <?Php echo"$ThemeCorTxtRodape";?>;
			FONT-FAMILY: Verdana;
			FONT-SIZE: 8pt;
			TEXT-DECORATION: underline;
			FONT-WEIGHT: none;
		}
	
	
		#rodape {
			clear: both;
			background: <?Php echo"$ThemeCorFundoTbGeral";?>;
			color: #000;
			padding: 5px;
			text-align: center;
		}

	


/* --------------------------------------------------------------------------------------------------------------------------------------*/			
</style>
<?php $objFuncao->RegistrarLog('fonte.inc(css);'); ?>