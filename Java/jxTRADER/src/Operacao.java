
public class Operacao {

	// Define - ID-LTa,b
		static String sLTB = "LTB";
		static String sLTA = "LTA";
		static String sNeutra = "www";	// Não set inicial como neutra, pois não entra dentro da analise
		
		static String sReversaoLTA = "Rv.LTA";
		static String sReversaoLTB = "Rv.LTB";
		static String sRefClose = "Fechamento";	// Referencia usada para os calculos
		static String sRefMaxMin = "Max/Min";

		// Aqui foi usado float para padronizar return vetor-float no metodo Candle
		static float fCandleMartelo = 1;
		static float fCandleMarteloInv = 2;
		static float fCandleStarCadente = 3;
		static float fCandleEnforcado = 4;

		// Tipo de operacao(Usada em cjto tipo de candle, cada um tem uma adequação)
		static float fCandleTpOperacaoCP = 1;
		static float fCandleTpOperacaoVD = 2;
		

		// Tipo de analise(identifica tipo de analise usada pelo usuario) 
		static int iAnaliseTendencia = 0;	// Analise por tendencia
		static int iAnaliseCandle = 1;		// Analise pelo tipo de candle
		
		
		//Posição(endereçamento) dos calculos das candles
		static int iPosCandleTipo = 0;
		static int iPosCandleTpOperacao = 1;
		static int iPosCandleStopCP = 2;
		static int iPosCandleOfertaCP = 3;
		static int iPosCandleAlvo = 4;
		static int iPosCandleStopVD = 5;
		static int iPosCandleOfertaVD = 6;
				
		static int iFlagCancel = -1;	// Indicador de cancelar operação(Stop e Oferta, Compra e venda)
		static String sOpCancelCP = "CancelCP";	
		static String sOpCancelVD = "CancelVD";	
		static String sOpCompra = "Compra";	
		static String sOpStopCP = "StopCP";	
		
		static String sOpVenda = "Venda";			// ID de Localização
		static String sOpVendaDayT = "Venda-DT";	// Venda-DayTrade	
		static String sOpVendaSwingT = "Venda-ST";	// Venda-SwingTrade
		static String sOpStopVdDayT = "StopVD-DT";	// StopVD-DayTrade
		static String sOpStopVdSwingT = "StopVD-ST";// StopVD-SwingTrade	
		static String sOpStopVD = "StopVD";			// ID de localização
	
		//Posição dos conteudo das celulas
		static int iPosLucro = 0;
		static int iPosContagemOpCompra = 1;
		static int iPosContagemOpVenda = 2;
		static int iPosContagemStopCP = 3;
		static int iPosContagemStopVD = 4;
		static int iPosContagemDayTrade = 5;
		static int iPosContagemSwingTrade = 6;
		static int iPosPeriodo = 7;

		// Posição de analise de preços(min/medmin/med/medmax/max)
		static int iPosPrcMin = 0;		
		static int iPosMedMin = 1;		
		static int iPosPrcMed = 2;		
		static int iPosMedMax = 3;		
		static int iPosPrcMax = 4;	
		static int iPosNumAmostra = 5;	// Num.amostragens Lista de Preços Min/Max
		static int iPosLstMinIni = 100;	// Pos.inicial lista de preços min
		static int iPosLstMaxIni = 200;	// Pos.inicial lista de preços máx
		

		
		// Ctrl Contagemtorio de ocorrencia de operação de compra
		private int iContagemOpCompra = 0;
		public void IncContagemOpCompra(){ iContagemOpCompra++; }
		public int pegueContagemOpCompra(){ return iContagemOpCompra; }
		
		// Ctrl Contagemtorio de ocorrencia de operação de compra
		private int iContagemOpVenda = 0;
		public void IncContagemOpVenda(){ iContagemOpVenda++; }
		public int pegueContagemOpVenda(){ return iContagemOpVenda; }
		
		// Ctrl Contagemtorio de ocorrencia de stop-cp
		private int iContagemStopCP = 0;
		public void IncContagemStopCP(){ iContagemStopCP++; }
		public int pegueContagemStopCP(){ return iContagemStopCP; }
		
		// Ctrl Contagemtorio de ocorrencia de stop-vd
		private int iContagemStopVD = 0;
		public void IncContagemStopVD(){ iContagemStopVD++; }
		public int pegueContagemStopVD(){ return iContagemStopVD; }
		
		// Ctrl Contagemtorio de ocorrencia de Day-trade
		private int iContagemDayTrade = 0;
		public void IncContagemDayTrade(){ iContagemDayTrade++; }
		public int pegueContagemDayTrade(){ return iContagemDayTrade; }
		
		// Ctrl Contagemtorio de ocorrencia de Swing-Trade
		private int iContagemSwingTrade = 0;
		public void IncContagemSwingTrade(){ iContagemSwingTrade++; }
		public int pegueContagemSwingTrade(){ return iContagemSwingTrade; }
		
		private String sTendenciaAtual = sNeutra;
		public void fixeTendenciaAtual(String sVar){ sTendenciaAtual = sVar; }
		public String pegueTendenciaAtual(){ return sTendenciaAtual; }
		
		
		private String sTendenciaAnterior = sNeutra;
		public void fixeTendenciaAnterior(String sVar){ sTendenciaAnterior = sVar; }
		public String pegueTendenciaAnterior(){ return sTendenciaAnterior; }
		
		
		/****************************************************************/
		// Comprado x Vendido
		static boolean bEstouComprado = true;	// Comprado = true
		static boolean bEstouVendido = false;	// Comprado = false
		
		private boolean bStatus = false;
		public void fixeStatus(boolean bVar){	bStatus = bVar; }
		public boolean pegueStatus(){ return bStatus; }
		
		/*
		private boolean bComprado = false;
		public void fixeComprado(boolean bVar){	bComprado = bVar; }
		public boolean pegueComprado(){ return bComprado; }
		*/
		
		/****************************************************************/
		
		private float fStopCP = 0;
		public void fixeStopCP(float fVar){ fStopCP = fVar; }
		public float pegueStopCP(){ return fStopCP; }
		
		private float fStopVD = 0;
		public void fixeStopVD(float fVar){ fStopVD = fVar; }
		public float pegueStopVD(){ return fStopVD; }
		
		private float fOfertaCP = 0;
		public void fixeOfertaCP(float fVar){ fOfertaCP = fVar; }
		public float pegueOfertaCP(){ return fOfertaCP; }
		
		private float fOfertaVD = 0;
		public void fixeOfertaVD(float fVar){ fOfertaVD = fVar; }
		public float pegueOfertaVD(){ return fOfertaVD; }

		/***************************************************************/
		
}
