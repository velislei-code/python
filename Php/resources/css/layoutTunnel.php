<style>
 /********** divs representacao dos fluxo Vlans/MPLS/Interface *********************************/
 	.bloco {
		position: fixed; /* Fixa a div na tela */
       	border: 2px solid #000; /* Borda preta */
		border-radius: 5px; /* Cantos arredondados */
		display: flex;		
		font-family: Arial, sans-serif; /* Fonte do texto */
		font-size: 10px; /* Tamanho do texto */			
		text-align: center; /* Alinhamento do texto */
		/* box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3); /* Sombra */
	}	

			#folha {				
				top: <?php echo $ajtTop - 10; ?>px; /*75px; /* Distância do topo */
				left: <?php echo $ajtLeft + 0; ?>px; /* 30px; /* Distância da esquerda */
				width: 1460px; /* Largura da placa */
				height: 235px; /* Altura da placa */
				background-color: #C0C0C0; /*#32CD32; /* #eeede5; /* Cor de fundo  */
				font-weight: normal; /* Texto em negrito */	
				color: #000; /* Cor do texto */
			}
			/************** SWA ****************************************************************/
			#cvlan-swa {				
				top: <?php echo $ajtTop + 85; ?>px; /*75px; /* Distância do topo */
				left: <?php echo $ajtLeft + 5; ?>px; /* 30px; /* Distância da esquerda */
				width: 50px; /* Largura da placa */
				height: 20px; /* Altura da placa */
				background-color: #ebd696; /* Cor de fundo  */
				justify-content: center; /* ajuste horizontal */		
				align-items: center; /* Centraliza verticalmente */
				font-weight: normal; /* Texto em negrito */	
				color: #000; /* Cor do texto */
			}
			#svlan-swa {				
				top: <?php echo $ajtTop + 70; ?>px; /* 55px; /* Distância do topo */
				left: <?php echo $ajtLeft + 25; ?>px;/* 50px; /* Distância da esquerda */
				width: 50px; /* Largura da placa */
				height: 40px; /* Altura da placa */
				background-color: #d7ad30; /* Cor de fundo  */
				justify-content: center; /* ajuste horizontal */
				align-items: top; /* Centraliza verticalmente */
				font-weight: normal; /* Texto em negrito */	
				color: #000; /* Cor do texto */
			}
			#titulo-swa {				
				top: <?php echo $ajtTop + 15; ?>px; /* 15px; /* Distância do topo */
				left: <?php echo $ajtLeft + 70; ?>px;/* 120px; /* Distância da esquerda */
				width: 200px; /* Largura da placa */
				height: 20px; /* Altura da placa */
				background-color: #586fc3; /* Cor de fundo  */
				justify-content: center; /* ajuste horizontal */
				align-items: center; /* Centraliza verticalmente */
				font-weight: bold; /* Texto em negrito */	
				color: #d9dadf; /* Cor do texto */
			}
			#corpo-swa {				
				top: <?php echo $ajtTop + 35; ?>px; /* 35px; /* Distância do topo */
				left: <?php echo $ajtLeft + 70; ?>px;/* 80px; /* Distância da esquerda */
				width: 190px; /* Largura da placa */
				height: 110px; /* Altura da placa */			
				overflow-x: auto; /* Habilita a barra de rolagem horizontal */
            	overflow-y: auto; /* Habilita a barra de rolagem vertical */
				padding: 5px; /* Espaçamento interno */
				background-color: #96c6eb; /* Cor de fundo  */
				justify-content: center; /* ajuste horizontal */
				align-items: center; /* Centraliza verticalmente */
				font-weight: normal; /* Texto em negrito */	
				color: #000; /* Cor do texto */
			}
			#rodape-swa {				
				top: <?php echo $ajtTop + 158; ?>px; /* 15px; /* Distância do topo */
				left: <?php echo $ajtLeft + 80; ?>px;/* 120px; /* Distância da esquerda */
				width: 200px; /* Largura da placa */
				height: 20px; /* Altura da placa */
				background-color: #586fc3; /* Cor de fundo  */
				justify-content: center; /* ajuste horizontal */
				align-items: center; /* Centraliza verticalmente */
				font-weight: bold; /* Texto em negrito */	
				color: #d9dadf; /* Cor do texto */
			}
			/* Ponta da Seta-Direita */
			#rodape-swa::after { 
				content: '';
				position: absolute;
				right: 10px; /* Posiciona dentro da div */
				top: 50%;
				transform: translateY(-50%);
				width: 0;
				height: 0;			
				border-top: 8px solid transparent; /* Tamanho da seta + borda */
				border-bottom: 8px solid transparent;
				/*Para virar a seta: inverta right/left*/
				border-left: 8px solid #d9dadf; /* Contorno preto da seta */
				border-right: 8px solid transparent; /* Borda transparente para evitar sobreposição */
				z-index: -1; /* Coloca o contorno atrás da seta */
			}

			/*********************** HL5-GWD **********************************************/
			#titulo-hl5Gwd {				
				top: <?php echo $ajtTop - 5; ?>px; /* 15px; /* Distância do topo */
				left: <?php echo $ajtLeft + 320; ?>px; /* 530px; /* Distância da esquerda */
				width: 300px; /* Largura da placa */
				height: 30px; /* Altura da placa */
				background-color:  #00FA9A; /* Cor de fundo */
				justify-content: center; /* ajuste horizontal */
				align-items: center; /* Centraliza verticalmente */
				font-weight: bold; /* Texto em negrito */	
				color: #000; /* Cor do texto */
			}			
			
			#corpo-hl5Gwd {				
				top: <?php echo $ajtTop + 15; ?>px; /* 15px; /* Distância do topo */
        		left: <?php echo $ajtLeft + 320; ?>px; /* 320px; /* Distância da esquerda */
				width: 290px; /* Largura da placa */
				height: 180px; /* Altura da placa */
				overflow-x: auto; /* Habilita a barra de rolagem horizontal */
            	overflow-y: auto; /* Habilita a barra de rolagem vertical */
				padding: 5px; /* Espaçamento interno */
				background-color: #90eebc; /* Cor de fundo */
				justify-content: center; /* ajuste horizontal */
				align-items: center; /* Centraliza verticalmente */
				font-weight: normal; /* Texto em negrito */	
				color: #000; /* Cor do texto */
			}
			#rodape-hl5Gwd {				
				top: <?php echo $ajtTop + 208; ?>px; /* 15px; /* Distância do topo */
				left: <?php echo $ajtLeft + 330; ?>px; /* 530px; /* Distância da esquerda */
				width: 300px; /* Largura da placa */
				height: 20px; /* Altura da placa */
				background-color:  #00FA9A; /* Cor de fundo */
				justify-content: center; /* ajuste horizontal */
				align-items: center; /* Centraliza verticalmente */
				font-weight: bold; /* Texto em negrito */	
				color: #000; /* Cor do texto */
			}

			/* Ponta da Seta-Direita */
			#rodape-hl5Gwd::after { 
				content: '';
				position: absolute;
				right: 10px; /* Posiciona dentro da div */
				top: 50%;
				transform: translateY(-50%);
				width: 0;
				height: 0;			
				border-top: 8px solid transparent; /* Tamanho da seta + borda */
				border-bottom: 8px solid transparent;
				/*Para virar a seta: inverta right/left*/
				border-left: 8px solid #696969; /* Contorno preto da seta */
				border-right: 8px solid transparent; /* Borda transparente para evitar sobreposição */
				z-index: -1; /* Coloca o contorno atrás da seta */
			}
			#vlan-hl5Gwd {				
				top: <?php echo $ajtTop + 90; ?>px; /* 75px; /* Distância do topo */
				left: <?php echo $ajtLeft + 273; ?>px; /* 250px; /* Distância da esquerda */
				width: 45px; /* Largura da placa */
				height: 15px; /* Altura da placa */
				background-color: #d7ad30; /* Cor de fundo  */	
				justify-content: center; /* ajuste horizontal */
				align-items: center; /* Centraliza verticalmente */			
				font-weight: bold; /* Texto em negrito */	
				color: #000; /* Cor do texto */
			}
			#fibra-hl5Gwd {				
				top: <?php echo $ajtTop + 75; ?>px; /* 75px; /* Distância do topo */
				left: <?php echo $ajtLeft + 273; ?>px; /* 250px; /* Distância da esquerda */
				width: 45px; /* Largura da placa */
				height: 40px; /* Altura da placa */
				background-color: #e9f00a; /* Cor de fundo  */
				justify-content: center; /* ajuste horizontal */
				align-items: top; /* Centraliza verticalmente */				
				font-weight: bold; /* Texto em negrito */	
				color: #000; /* Cor do texto */
			}
				
			
			/*************************** HL3-GWC ****************************************************/
			#titulo-hl3Gwc {				
				top: <?php echo $ajtTop - 5; ?>px; /* 15px; /* Distância do topo */
				left: <?php echo $ajtLeft + 680; ?>px; /* 530px; /* Distância da esquerda */
				width: 350px; /* Largura da placa */
				height: 20px; /* Altura da placa */
				background-color:  #00FA9A; /* Cor de fundo */
				justify-content: center; /* ajuste horizontal */
				align-items: center; /* Centraliza verticalmente */
				font-weight: bold; /* Texto em negrito */	
				color: #000; /* Cor do texto */
			}			
			#corpo-hl3Gwc {				
				top: <?php echo $ajtTop + 15; ?>px; /* 15px; /* Distância do topo */
				left: <?php echo $ajtLeft + 680; ?>px; /* 530px; /* Distância da esquerda */
				width: 340px; /* Largura da placa */
				height: 180px; /* Altura da placa */
				overflow-x: auto; /* Habilita a barra de rolagem horizontal */
            	overflow-y: auto; /* Habilita a barra de rolagem vertical */
				padding: 5px; /* Espaçamento interno */
				background-color: #90eebc; /* Cor de fundo */
				justify-content: center; /* ajuste horizontal */
				align-items: center; /* Centraliza verticalmente */
				font-weight: normal; /* Texto em negrito */	
				color: #000; /* Cor do texto */
			}
			#rodape-hl3Gwc {				
				top: <?php echo $ajtTop + 208; ?>px; /*75px; /* Distância do topo */
        		left: <?php echo $ajtLeft + 690; ?>px; /* 30px; /* Distância da esquerda */		
				width: 350px; /* Largura da placa */
				height: 20px; /* Altura da placa */
				background-color:  #00FA9A; /* Cor de fundo */
				justify-content: center; /* ajuste horizontal */
				align-items: center; /* Centraliza verticalmente */
				font-weight: bold; /* Texto em negrito */	
				color: #000; /* Cor do texto */
			}

			/* Ponta da Seta-Direita */
			#rodape-hl3Gwc::after { 
				content: '';
				position: absolute;
				right: 10px; /* Posiciona dentro da div */
				top: 50%;
				transform: translateY(-50%);
				width: 0;
				height: 0;			
				border-top: 8px solid transparent; /* Tamanho da seta + borda */
				border-bottom: 8px solid transparent;
				/*Para virar a seta: inverta right/left*/
				border-left: 8px solid #696969; /* Contorno preto da seta */
				border-right: 8px solid transparent; /* Borda transparente para evitar sobreposição */
				z-index: -1; /* Coloca o contorno atrás da seta */
			}

			#vlan-hl3Gwc {				
				top: <?php echo $ajtTop + 80; ?>px; /* 75px; /* Distância do topo */
				left: <?php echo $ajtLeft + 623; ?>px; /* 450px; /* Distância da esquerda */
				width: 55px; /* Largura da placa */
				height: 15px; /* Altura da placa */				
				background-color: #d7ad30; /* Cor de fundo */
				justify-content: center; /* ajuste horizontal */
				align-items: center; /* Centraliza verticalmente */
				font-weight: bold; /* Texto em negrito */	
				color: #000; /* Cor do texto */
			}
			#mpls-hl3Gwc {				
				top: <?php echo $ajtTop + 65; ?>px; /* 75px; /* Distância do topo */
				left: <?php echo $ajtLeft + 623; ?>px; /* 250px; /* Distância da esquerda */
				width: 55px; /* Largura da placa */
				height: 40px; /* Altura da placa */
				background-color: #ffcc00; /* Cor de fundo */
				justify-content: center; /* ajuste horizontal */
				align-items: top; /* Centraliza verticalmente */
				font-weight: bold; /* Texto em negrito */	
				color: #000; /* Cor do texto */
			}	
			#fibra-hl3Gwc {				
				top: <?php echo $ajtTop + 50; ?>px; /* 75px; /* Distância do topo */
				left: <?php echo $ajtLeft + 623; ?>px; /* 450px; /* Distância da esquerda */
				width: 55px; /* Largura da placa */
				height: 65px; /* Altura da placa */
				background-color: #e9f00a; /* Cor de fundo  */	
				justify-content: center; /* ajuste horizontal */
				align-items: top; /* Centraliza verticalmente */	
				font-weight: bold; /* Texto em negrito */	
				color: #000; /* Cor do texto */
			}	
			
			
			/************************** RSD *********************************************************/
			#titulo-rsd {				
				top: <?php echo $ajtTop - 5; ?>px; /* 15px; /* Distância do topo */
				left: <?php echo $ajtLeft + 1100; ?>px; /*750 Distância da esquerda */    
				width: 350px; /* Largura da div */
				height: 20px; /* Altura da div */
				background-color:  #2c57f0; /* Cor de fundo */
				justify-content: center; /* ajuste horizontal */
				align-items: center; /* Centraliza verticalmente */
				font-weight: bold; /* Texto em negrito */	
				color: #d9dadf; /* Cor do texto */
			}			
			#corpo-rsd {				
				top: <?php echo $ajtTop + 15; ?>px; /* 15px; /* Distância do topo */
				left: <?php echo $ajtLeft + 1100; ?>px; /*750 Distância da esquerda */       
				width: 340px; /* Largura da div */
				height: 180px; /* Altura da div */
				overflow-x: auto; /* Habilita a barra de rolagem horizontal */
            	overflow-y: auto; /* Habilita a barra de rolagem vertical */
				padding: 5px; /* Espaçamento interno */
				background-color: #96c6eb; /* Cor de fundo */
				justify-content: center; /* ajuste horizontal */
				align-items: center; /* Centraliza verticalmente */
				font-weight: normal; /* Texto em negrito */	
				color: #000; /* Cor do texto */
			}
			#rodape-rsd {				
				top: <?php echo $ajtTop + 208; ?>px; /*75px; /* Distância do topo */
        		left: <?php echo $ajtLeft + 1090; ?>px; /* 30px; /* Distância da esquerda */
				width: 350px; /* Largura da div */
				height: 20px; /* Altura da div */
				background-color:  #2c57f0; /* Cor de fundo */
				justify-content: center; /* ajuste horizontal */
				align-items: center; /* Centraliza verticalmente */
				font-weight: bold; /* Texto em negrito */	
				color: #d9dadf; /* Cor do texto */
			}

			/* Ponta da Seta-Esq */
			#rodape-rsd::after { 
				content: '';
				position: absolute;
				right: 330px; /* Posiciona dentro da div */
				top: 50%;
				transform: translateY(-50%);
				width: 0;
				height: 0;			
				border-top: 8px solid transparent; /* Tamanho da seta + borda */
				border-bottom: 8px solid transparent;
				/*Para virar a seta: inverta right/left*/
				border-right: 8px solid #d9dadf; /* Contorno preto da seta */
				border-left: 8px solid transparent; /* Borda transparente para evitar sobreposição */
				z-index: -1; /* Coloca o contorno atrás da seta */
			}
			#vlan-rsd {				
				top: <?php echo $ajtTop + 80; ?>px; /* 75px; /* Distância do topo */
				left: <?php echo $ajtLeft + 1032; ?>px; /* 450px; /* Distância da esquerda */
				width: 65px; /* Largura da placa */
				height: 15px; /* Altura da placa */				
				background-color: #d7ad30; /* Cor de fundo */
				justify-content: center; /* ajuste horizontal */
				align-items: center; /* Centraliza verticalmente */
				font-weight: bold; /* Texto em negrito */	
				color: #000; /* Cor do texto */
			}
			#mpls-rsd {				
				top: <?php echo $ajtTop + 65; ?>px; /* 75px; /* Distância do topo */
				left: <?php echo $ajtLeft + 1032; ?>px; /* 250px; /* Distância da esquerda */
				width: 65px; /* Largura da placa */
				height: 40px; /* Altura da placa */
				background-color: #ffcc00; /* Cor de fundo  */
				justify-content: center; /* ajuste horizontal */
				align-items: top; /* Centraliza verticalmente */				
				font-weight: bold; /* Texto em negrito */	
				color: #000; /* Cor do texto */
			}	
			#fibra-rsd {				
				top: <?php echo $ajtTop + 50; ?>px; /* 75px; /* Distância do topo */
				left: <?php echo $ajtLeft + 1032; ?>px; /* 450px; /* Distância da esquerda */
				width: 65px; /* Largura da placa */
				height: 65px; /* Altura da placa */
				background-color: #e9f00a; /* Cor de fundo  */	
				justify-content: center; /* ajuste horizontal */
				align-items: top; /* Centraliza verticalmente */			
				font-weight: bold; /* Texto em negrito */	
				color: #000; /* Cor do texto */
			}	

			/************************** PING *********************************************************/
			#corpo-ping {				
				top: <?php echo $ajtTop + 210; ?>px; /* 15px; /* Distância do topo */
				left: <?php echo $ajtLeft + 1100; ?>px; /*750 Distância da esquerda */       
				width: 340px; /* Largura da div */
				height: 120px; /* Altura da div */
				overflow-x: auto; /* Habilita a barra de rolagem horizontal */
            	overflow-y: auto; /* Habilita a barra de rolagem vertical */
				padding: 5px; /* Espaçamento interno */
				background-color: #96c6eb; /* Cor de fundo */
				justify-content: left; /* ajuste horizontal */
				align-items: center; /* Centraliza verticalmente */
				font-weight: normal; /* Texto em negrito */	
				color: #000; /* Cor do texto */
			}
			/************************** TUNNEL *********************************************************/

			#pathTunnel {
					
				top: <?php echo $ajtTop - 60; ?>px; /* 15px; /* Distância do topo */
				left: <?php echo $ajtLeft + 30; ?>px; /*750 Distância da esquerda */       
				width: 1050px; /* Largura da div */
				height: 30px; /* Altura da div */
				/* overflow-x: auto; /* Habilita a barra de rolagem horizontal */
            	/* overflow-y: auto; /* Habilita a barra de rolagem vertical */
				padding: 5px; /* Espaçamento interno */
				background-color: #d7ad30; /* Cor de fundo */
				justify-content: center; /* ajuste horizontal */
				align-items: center; /* Centraliza verticalmente */
				font-weight: bold; /* Texto em negrito */	
				color: #000; /* Cor do texto */
					
			}
			
</style>
