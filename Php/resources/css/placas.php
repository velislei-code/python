
<style>	
	/* Estilos das placas */
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
				#cmdTunnel{
					width: 150px; /* Largura da placa */
					height: 20px; /* Altura da placa */
					background-color:  #ffcc00; /* Cor de fundo  */
				}
				#basica{
					width: 120px; /* Largura da placa */
					height: 20px; /* Altura da placa */
					background-color:  #ffcc00; /* Cor de fundo  */
				}
				#projecao{
					width: 120px; /* Largura da placa */
					height: 20px; /* Altura da placa */
					background-color:  #ffcc00; /* Cor de fundo  */
				}
				#esteira{
					width: 120px; /* Largura da placa */
					height: 20px; /* Altura da placa */
					background-color:  #ffcc00; /* Cor de fundo  */
				}
				

	/****************************************************/

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
					top: 5px; /* Distância do topo */
					left: 5px; /* Distância da esquerda */
					width: 160px; /* Largura da placa */
					height: 15px; /* Altura da placa */
					background-color:  #00BFFF; /* Cor de fundo  */
				}
				#avSWT{
					top: 290px; /* Distância do topo */
					left: 1350px; /* Distância da esquerda */
					width: 150px; /* Largura da placa */
					height: 20px; /* Altura da placa */
					background-color: #7FFF00; /* Cor de fundo  */	
				}				
				#avSWT_ERB{
					top: 360px; /* Distância do topo */
					left: 1350px; /* Distância da esquerda */
					width: 150px; /* Largura da placa */
					height: 20px; /* Altura da placa */
					background-color: #7FFF00; /* Cor de fundo  */	
				}				
				#avMIGRA{
					top: 700px; /* Distância do topo */
					left: 1400px; /* Distância da esquerda */
					width: 100px; /* Largura da placa */
					height: 20px; /* Altura da placa */
					background-color: #7FFF00; /* Cor de fundo  */	
				}				
				#avMaskWAN_Lo {		
					top: 635px; /* Distância do topo */
					left: 1370px; /* Distância da esquerda */
					width: 140px; /* Largura da placa */
					height: 20px; /* Altura da placa */
					background-color: #7FFF00; /* Cor de fundo  */	
				}
				#avRange{
					top: 570px; /* Distância do topo */
					left: 1330px; /* Distância da esquerda */
					width: 150px; /* Largura da placa */
					height: 20px; /* Altura da placa */
					background-color: #FFFF00; /* Cor de fundo  */	
				}
				#avDasa{
					top: 140px; /* Distância do topo */
					left: 530px; /* Distância da esquerda */
					width: 150px; /* Largura da placa */
					height: 20px; /* Altura da placa */
					background-color: #FF0000; /* Cor de fundo  */	
				}
				#avHoldi{
					top: 140px; /* Distância do topo */
					left: 1330px; /* Distância da esquerda */
					width: 150px; /* Largura da placa */
					height: 20px; /* Altura da placa */
					background-color: #7FFF00; /* Cor de fundo  */	
				}
				#avPrjEsp{
					top: 430px; /* Distância do topo */
					left: 1300px; /* Distância da esquerda */
					width: 150px; /* Largura da placa */
					height: 20px; /* Altura da placa */
					background-color: #7FFF00; /* Cor de fundo  */
				
				}
				#avFust{
					top: 50px; /* Distância do topo */
					left: 330px; /* Distância da esquerda */
					width: 220px; /* Largura da placa */
					height: 20px; /* Altura da placa */
					background-color: #7FFF00; /* Cor de fundo  */	
				}
				#avCad{
					top: 90px; /* Distância do topo */
					left: 220px; /* Distância da esquerda */
					width: 200px; /* Largura da placa */
					height: 20px; /* Altura da placa */
					background-color: #7FFF00; /* Cor de fundo  */	
				}
				#avMsgRegVazio{  /* Usado em Class.Tickets->Salvar() */
					top: 5px; /* Distância do topo */
					left: 560px; /* Distância da esquerda */
					width: 500px; /* Largura da placa */
					height: 20px; /* Altura da placa */
					background-color: #FFA500; /* Cor de fundo  */	
				}
				#avVivo2{
					top: 10px; /* Distância do topo */
					left: 1300px; /* Distância da esquerda */
					width: 200px; /* Largura da placa */
					height: 20px; /* Altura da placa */
					background-color: #00BFFF; /* Cor de fundo  */	
				}
				#avProdutizado{
					top: 150px; /* Distância do topo */
					left: 560px; /* Distância da esquerda */
					width: 200px; /* Largura da placa */
					height: 20px; /* Altura da placa */
					background-color: #FFA500; /* Cor de fundo  */	
				}
				#avREQ{
					top: 10px; /* Distância do topo */
					left: 200px; /* Distância da esquerda */
					width: 80px; /* Largura da placa */
					height: 20px; /* Altura da placa */
					background-color: #00BFFF; /* Cor de fundo  */	
				}
				#avFlow{
					top: 150px; /* Distância do topo */
					left: 720px; /* Distância da esquerda */
					width: 200px; /* Largura da placa */
					height: 20px; /* Altura da placa */
					background-color: #7FFF00; /* Cor de fundo  */	
				}
				#raPort_naouso {		
					top: 15px; /* Distância do topo */
					left: 750px; /* Distância da esquerda */
					width: 520px; /* Largura da placa */
					height: 100px; /* Altura da placa */
					background-color: #00FFFF; /* Cor de fundo  */		
				}
				
				#msgConfirma {		
					top: 20px; /* Distância do topo */
					left: 500px; /* Distância da esquerda */
					width: 450px; /* Largura da placa */
					height: 50px; /* Altura da placa */
					background-color: #FFA500; /* Cor de fundo  */
				}

				#shImagemHead {		
					display: flex;
    				justify-content: flex-end; /* Alinha os filhos à direita */
    				align-items: right; /* Centraliza verticalmente (opcional) */
					top: 180px; /* Distância do topo */
					left: 500px; /* Distância da esquerda */
					width: 600px; /* Largura da placa */
					height:20px; /* Altura da placa */
					background-color: #F5F5F5; /* Cor de fundo  */

					
				}
				#shImagem {		
					top: 200px; /* Distância do topo */
					left: 500px; /* Distância da esquerda */
					width: 600px; /* Largura da placa */
					height:400px; /* Altura da placa */
					background-color: #FFF; /* Cor de fundo  */
				}
				
				
	
	.divRd {
		position: fixed; /* Fixa a div na tela */
		border: 1px solid #ffcc00; /* Contorno preto de 2px */
		border-radius: 50%; /* Torna a div redonda */		
		font-size: 11pt; /* Tamanho da fonte */
		color: black; /* Cor da fonte */
		display: flex;
		align-items: center;
		justify-content: center;
		text-align: center;
	}
				#idFound{
					top: 125px; /* Distância do topo */
					left: 1310px; /* Distância da esquerda */					
					width: 1px; /* Diâmetro da div */
					height: 1px; /* Diâmetro da div */
					background-color: #FFFF00; /* Fundo azul */
				}
				#swaFound{
					top: 180px; /* Distância do topo */
					left: 1390px; /* Distância da esquerda */					
					width: 1x; /* Diâmetro da div */
					height: 1px; /* Diâmetro da div */
					background-color: #FFFF00; /* Fundo azul */
				}
	
	

				
	/* Estilo da div pai */
	.avRA {
		position: fixed; /* Fixa a div na tela */
		top: 50px; /* Posiciona no centro vertical */
		left: 400px;/* Posiciona no centro horizontal */
		transform: translate(-50%, -50%); /* Ajusta o centro exato */
		width: 500px; /* Largura */
		height: 100px; /* Altura */
		background-color: #00FFFF; /*cyan; /* Cor de fundo azul ciano */
		border: 2px solid black; /* Borda de 2px */
		border-radius: 5px; /* Borda de 2px */
		padding: 3px; /* Espaçamento interno */
		box-sizing: border-box; /* Inclui borda e padding na largura/altura */
		overflow-y: auto; /* Adiciona scroll vertical se o conteúdo for maior que a altura */
	}
	

	/* Estilo das divs filhas */
	.raPort {
		width: 100%; /* Largura total da div pai */
		margin-bottom: 5px; /* Espaçamento entre as linhas */
		text-align: center; /* Centraliza o texto */
		color: #FF0000; /* Cor vermelha no hover - altere para a cor desejada */
		text-decoration: none; /* Garante que não aparece sublinhado */
	}

	/* Remove a margem da última div filha */
	.raPort:last-child {
		margin-bottom: 0;
	}

	
	

	
	   
	
</style>