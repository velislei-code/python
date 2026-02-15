import java.awt.Dimension;
import java.awt.Toolkit;

import javax.swing.JComboBox;


public class Definicoes {
	
	String sVersao = "2018.11.25";
	
	
	
	String DirRoot = System.getProperty("user.dir") + "//src//"; 
	
	/* Dir Home(MyDoc) */
	String DirHome = System.getProperty("user.home");
	String DirDocJxt = "jxTrader_docs";		// diretorio padrão mtaView
	String DirDocuments = System.getProperty("user.home") + "\\documents\\";		// diretorio padrão mtaView
	String DirJxtDoc = System.getProperty("user.home") + "\\documents\\jxTrader_docs\\";		// diretorio padrão mtaView
	String DirBak = System.getProperty("user.home") + "\\documents\\jxTrader_docs\\backup\\";		// diretorio padrão mtaView
	String DirCotacao = System.getProperty("user.home") + "\\documents\\jxTrader_docs\\cotacao\\";		// diretorio padrão mtaView
	// String DirBak = DirRoot + "backup//"; 
	
	/*
	 *  Dir dos Arquivos de ctrl de licenca
	 *  Lcc sera gravada em tres arquivos, setup_mta, temp e downloads
	 */
	String Lcc1 = "C:/tmp/setup.ini"; 
	String Lcc2 = DirHome + "//Downloads//winupdate.ini";
	
	static String sSalvarAs = "SalvarAs";
    static int MAXIMINIZADO = 1;
    static int NORMAL = 0;
    
    static int msgCONTINUAR = 0;
    static int msgREPETIR = 1;
    static int msgPARAR = 2;
    static String sMsgTestes = "Sequência finalizada ! Continuar, Repetir ou Parar testes ?";
    static String sLedBarraStatusParar = "00:00:00";
    static String sLedBarraStatusPausa = "Pausa";
    static String sLedBarraStatusAtivo = "00:00:00";
    static boolean bStop = false;
    static boolean bStart = true;
    
    // Configuração
    static boolean bCriptoConfig = false;		// Ler/Salvar config.ini em criptografia
    
    // Controle do Status do teste
    static int tstSTATUS = 0;
    public void FixeTstStatus(int iS){  tstSTATUS = iS; }
    public int PegueTstStatus(){  return tstSTATUS; }
    static int tstPARAR = 0;
    static int tstPAUSA = 1;
    static int tstATIVO = 2;
    
    int iPintar = 0;	// Pintar grupo de linhas
    
    boolean  bFiltroAplicado = false;
	// Pega dimensões da tela
    Toolkit tkTela = Toolkit.getDefaultToolkit();  
    Dimension dDimTela = tkTela.getScreenSize(); 
    
    public int iTelaLarg = dDimTela.width; 
    public int iTelaAlt = dDimTela.height;
    
    double dDiv3LargTela = iTelaLarg / 3;
    double dDiv6AltTela = iTelaLarg / 12;
   
    /***************************************************************************************************************************************/
    // Barras Ferramentas - Altura padrão
    static int iAltPadraoBF = 25;		// Altura padrão da barra de menu
    
    /***************************************************************************************************************************************/
    // Posição dos Menus 
    static int bfMenuLin = 1;		// Posição padrão da linha do menu
    
    // Menu Projeto
    static int bfMenuPrjCol = 1;	// Coluna inicial
    static int iMenuPrjLarg = 55;	// Largura do menu

    // Menu Sistema
    static int bfMenuSysCol = 56;	// Coluna inicial
    static int iMenuSysLarg = 60;	// Largura do menu
    
    // Menu Ferramentas
    static int bfMenuFerCol = 116;	// Posição inicial(linha) do menu
    static int iMenuFerLarg = 90;	// Largura do menu - Ferramentas(8px/char)
    
    // Menu Opção
    static int bfMenuOpcCol = 206;	// Posição inicial(linha) do menu
    static int iMenuOpcLarg = 70;	// Largura do menu - opcao(8px/char)
    
    // Menu Info
    static int bfMenuInfoCol = 276;	// Posição inicial(linha) do menu
    int iMenuInfoLarg = iTelaLarg - 276;	// Largura do menu - opcao(8px/char)
    
    
    /***************************************************************************************************************************************/
    // Posições da Barra de ferramentas dos botões  
    int bfBtnPosLin = (iAltPadraoBF * 1) + 1; 		// Posição padrão inicial da linha da bar.fer.botões

    // BF-Novo Projeto
    static int bfBtnPrjPosCol = 1; 					// Pos.inicial Coluna BFProjeto
    static int bfBtnPrjLarg = 110;					// largura da B.Fer.Projeto    

    // BF-Excel(Export, import, restaure)    
    static int bfBtnExcelPosCol = bfBtnPrjLarg + 1;	// Pos.inicial Coluna BFSistema(Testes)
    static int bfBtnExcelLarg = 90;					// largura da B.Fer.Sistema
    
    // BF-Sistema[Iniciar, Pausar, Parar]
    static int bfBtnSisPosCol = bfBtnExcelPosCol + bfBtnExcelLarg + 1 ; 	// Posicao inicial da coluna
    static int bfBtnSisLarg = 120;	// largura da Bar.Fer.
    
    
    static int bfBtnRedPosCol = bfBtnSisPosCol + bfBtnSisLarg + 1;	// Posicao inicial da coluna(Rede)
    static int bfBtnRedLarg = 120;		// largura da Bar.Fer.		(Rede)
    
    static int bfBtnEdicaoPosCol = bfBtnRedPosCol + bfBtnRedLarg + 1; // Posicao inicial da coluna(Edicao)
    static int bfBtnEdicaoLarg = 90;	// largura da Bar.Fer.		(Edicao)
    
    
	
    // Tipo: Exibir/ocultar
    static int INICIALIZAR = 0;
    static int PARAMETRO = 1;
    static int LAPIS = 2;
    static int FILTRO = 3;
    
    /***************************************************************************************************************************************/ 
     
    /*
     * Variaveis que armazenam textos(valores) das Combo-box
     * Devido a forma de funcionamento das combos, para pegar valores das combos 
     * é necessario passar valores para uma String e depois pegar o valor
     */
    
	
    // Ctrl pegue/fixe das Strings(valor das combos) BFParametros
	private String sCodEmpresa = "";
	public void fixeComboCodEmpresa(String sVar){ sCodEmpresa = sVar; }
	public String pegueComboCodEmpresa(){ return sCodEmpresa; }
	
	private String sTimeM15 = "";
	public void fixeComboTimeM15(String sVar){ sTimeM15 = sVar; }
	public String pegueComboTimeM15(){ return sTimeM15; }
	
	private int iNumRegistro = 0;
	public void fixeComboNumRegistro(int iVar){ iNumRegistro = iVar; }
	public int pegueComboNumRegistro(){ return iNumRegistro; }
	
	private int iAmostraTEND = 0;
	public void fixeComboAmostraTEND(int iVar){ iAmostraTEND =iVar; }
	public int pegueComboAmostraTEND(){ return iAmostraTEND; }
	
	
	private float fLtb = 0;
	public void fixeComboPercLtb(float fVar){ fLtb = fVar; }
	public float pegueComboPercLtb(){ return fLtb; }
	
	private float fLta = 0;
	public void fixeComboPercLta(float fVar){ fLta = fVar; }
	public float pegueComboPercLta(){ return fLta; }
	
	private float fPercStopCP = 0;
	public void fixeComboPercStopCP(float fVar){ fPercStopCP = fVar; }
	public float pegueComboPercStopCP(){ return fPercStopCP; }
	
	private float fPercStopVD = 0;
	public void fixeComboPercStopVD(float fVar){ fPercStopVD = fVar; }
	public float pegueComboPercStopVD(){ return fPercStopVD; }
	
	private float fPercOfertaCP = 0;
	public void fixeComboPercOfertaCP(float fVar){ fPercOfertaCP = fVar; }
	public float pegueComboPercOfertaCP(){ return fPercOfertaCP; }
	
	private float fPercOfertaVD = 0;
	public void fixeComboPercOfertaVD(float fVar){ fPercOfertaVD = fVar; }
	public float pegueComboPercOfertaVD(){ return fPercOfertaVD; }
	
	private String sReferencia = "";
	public void fixeComboReferencia(String sVar){ sReferencia = sVar; }
	public String pegueComboReferencia(){ return sReferencia; }

	// Ctrl o num.Index das combos
	private int iIdxNumRegistro = 0;
	public void fixeIdxComboNumRegistro(int iIdxVar){ iIdxNumRegistro = iIdxVar; }
	public int pegueIdxComboNumRegistro(){ return iIdxNumRegistro; }
	
	private int iIdxAmostraTEND = 0;
	public void fixeIdxComboAmostraTEND(int iIdxVar){ iIdxAmostraTEND =iIdxVar; }
	public int pegueIdxComboAmostraTEND(){ return iIdxAmostraTEND; }
	
	private int iIdxAmostraMED = 0;
	public void fixeIdxComboAmostraMED(int iIdxVar){ iIdxAmostraMED =iIdxVar; }
	public int pegueIdxComboAmostraMED(){ return iIdxAmostraMED; }
	
	private int iIdxLtb = 0;
	public void fixeIdxComboPercLtb(int iIdxVar){ fLtb = iIdxVar; }
	public int pegueIdxComboPercLtb(){ return iIdxLtb; }
	
	private int iIdxLta = 0;
	public void fixeIdxComboPercLta(int iIdxVar){ fLta = iIdxVar; }
	public int pegueIdxComboPercLta(){ return iIdxLta; }
	
	private int iIdxPercStopCP = 0;
	public void fixeIdxComboPercStopCP(int iIdxVar){ fPercStopCP = iIdxVar; }
	public int pegueIdxComboPercStopCP(){ return iIdxPercStopCP; }
	
	private int iIdxPercStopVD = 0;
	public void fixeIdxComboPercStopVD(int iIdxVar){ fPercStopVD = iIdxVar; }
	public int pegueIdxComboPercStopVD(){ return iIdxPercStopVD; }
	
	private int iIdxPercOfertaCP = 0;
	public void fixeIdxComboPercOfertaCP(int iIdxVar){ fPercOfertaCP = iIdxVar; }
	public int pegueIdxComboPercOfertaCP(){ return iIdxPercOfertaCP; }
	
	private int iIdxPercOfertaVD = 0;
	public void fixeIdxComboPercOfertaVD(int iIdxVar){ fPercOfertaVD = iIdxVar; }
	public int pegueIdxComboPercOfertaVD(){ return iIdxPercOfertaVD; }
	
	private int iIdxReferencia = 0;
	public void fixeIdxComboReferencia(int iIdxVar){ iIdxReferencia = iIdxVar; }
	public int pegueIdxComboReferencia(){ return iIdxReferencia; }
	
	// Ctrl numero de Slt/Porta, Hz/Vt/Pino em editar lista
	private int iLinTab = 0;
	public void fixeLinTab(int iL){ iLinTab = iL; }
	public void incLinTab(){ iLinTab++; }
	public void decLinTab(){ iLinTab--; }	
	public int pegueLinTab(){ return iLinTab; }
	
	// Ctrl numero de registros(baixados do Meta-trader) na Tabela
	private int iNumRegMetaTrader = 0;
	public void IncNumRegMetaTrader(){ iNumRegMetaTrader++; }
	public void fixeNumRegMetaTrader(int iL){ iNumRegMetaTrader = iL; }
	public int pegueNumRegMetaTrader(){ return iNumRegMetaTrader; }

	// Ctrl Num.registros analisados
	private int iNumRegAnalisados = 0;
	public void fixeNumRegAnalisados(int iL){ iNumRegAnalisados = iL; }
	public int pegueNumRegAnalisados(){ return iNumRegAnalisados; }
	
	// Ctrl o salto para ultimo registro(se esta no fim ou no inicio)
	private boolean bSaltarFinalTab = false;
	public void fixeSaltarFinalTab(boolean bS){ bSaltarFinalTab = bS; }
	public boolean pegueSaltarFinalTab(){ return bSaltarFinalTab; }
	
	public boolean bOftFixada = true;
	public boolean bOftPercentual = false;
	
	
	/* EX
	private int iCBoxSlot = 0;
	public void fixeCBoxSlot(int iS){ iCBoxSlot = iS; }
	public void incCBoxSlot(){ iCBoxSlot++; }
	public void decCBoxSlot(){ iCBoxSlot--; }
	public int pegueCBoxSlot(){ return iCBoxSlot; }
	*/
	
	/***************************************************************************************************************************************/
	// TABELA
	// Dados iniciais da Tabela
//	String[] sTabColunas = new String[]{ "","Tend.", "Status", "Oft(CP)", "Stop(CP)", "Pç(CP)", "Oft(VD)", "Stop(VD)", "Pç(VD)", "Res(%)", "Oper.", "Data", "Hora", "Abert.", "Máx.", "Min.", "Fech.", "T.Vol", "Vol.", "Spread","Var(F)","Var(M)","","","","","","","","",""};
	String[] sTabColunas = new String[]{ "", "Data", "Hora", "Abert.", "Máx.", "Min.", "Fech.", "T.Vol", "Vol.", "Spread", "", "Tend.", "Candle", "Status", "Oft(CP)", "Stop(CP)", "Pç(CP)", "Oft(VD)", "Stop(VD)", "Pç(VD)", "Res(%)", "Oper.", "Var(F)", "Var(M)", "","","","","","",""};
	String[][] sTabDados = new String[][]{{"", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",  "", "", "", "", "", "", "", "", "", "","","","",""}};
	String[] sTabLinhas = new String[]{"", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "","","","",""};
	
	// usado para formatar arquivo.csv
	String sTabTitulo = "Reg;Tend.;Status;Oft(CP);Stop(CP);Pç(CP);Dt(CP);Hr(CP);Oft(VD);Stop(VD);Pç(VD);Dt(VD);Hr(VD);Res(%);Oper.;Chave;Data;Hora;Abert.;Máx.;Min.;Fech.;T.Vol;Vol.;Spread;Var(F);Var(M)";
 	
	// tabela do MySQL
	static String sBanco = "jdbc:mysql://localhost/ativos";
	static String sLg = "root";
	static String sPass = "";	
	static String sTabOperacaoTemp = "operacaotemp";	// teste
	static String sTabGGBR4 = "ggbr4";	// teste
		
	 // Endereços das colunas da tabela
	// Numeração de N é feita em: RederCongelarColuna.NumerarModens()
	static int colN = 0;	// Congelado, uso em separado - sua formatação e numeração e feito na Class.RenderCongelarColuna
    
	static int colDATA = 0;
    static int colHORA = 1;
    static int colABERT = 2;
    static int colMAX = 3;
    static int colMIN = 4;
    static int colFECH = 5;
    static int colTVOL = 6;
    static int colVOL = 7;
    static int colSPREAD = 8;
    
    static int colSEPARADOR = 9;

    static int colTEND = 10;
    static int colCANDLE = 11;
    static int colSTATUS = 12;
    
    static int colOFT_CP = 13;
    static int colSTOP_CP = 14;        
    static int colPRECO_CP = 15;
    
    static int colOFT_VD = 16;
    static int colSTOP_VD = 17;        
    static int colPRECO_VD = 18;    
    
    static int colRESULTADO = 19;
    static int colOPERACAO = 20;   
   
    static int colVAR_F = 21;
    static int colVAR_M = 22;

    // Endereços das TField de Parametros(usado nos vetores)
    static int iPosCbNumRegistros = 0;
    static int iPosCbAmostragem = 1;
    static int iPosCbPercLtb = 2;
    static int iPosCbPercLta = 3;
    static int iPosCbStopCP = 4;
    static int iPosCbStopVD = 5;
    static int iPosCbOftCP = 6;
    static int iPosCbOftVD = 7;
    static int iPosCbReferencia = 8;

    // Endereços da BF-Relatorios
    static int iPosTfProjLucro = 0;
    static int iPosTfNimOpCP = 1;
    static int iPosTfNumStopCP = 2;
    static int iPosTfNumOpVD = 3;
    static int iPosTfNumStopVD = 4;
    static int iPosTfDayT = 5;
    static int iPosTfSwingT = 6;
    static int iPosTfPeriodo = 7;
   
	
    int iMemNumLin = 0;				// memoriza numero de linhas carregada na tabela
    int iMemNumCol = 0;				// memoriza numero de Colunas carregada na tabela
    int iTotColunaTab = colVAR_M;		// Total de títulos na Tabela

    /***************************************************************************************************************************************/
    // BF-AddCotacao, Acima da tabela
    int bfAddLin = (iAltPadraoBF * 2) + 1; 		// Posição padrão inicial da linha da bar.fer.botões
   	int bfAddCol = 1;
   	int bfAddLinLarg = (int)(iTelaLarg*0.5);						// O que sobrar da barra de Botoes
    	
    // BF-Parametros
	int bfParamCol = 1;  
	int bfParamLin = (iAltPadraoBF * 3); 
	int bfParamLarg = (int)(iTelaLarg * 0.99);	// Largura BF-50%
  	int bfParamEspaco = (int)(iTelaLarg*0.01);	// BF-Espaçador a direita - 20%


    
	/********************************************/
	// Trio - [Coord - Acao - Filtrar]
    
	// Posições BF-Coordenada    
	int bfCoordenadaLarg = (int)(iTelaLarg * 0.1);	// Largura BF-10%
	static int bfCoordenadaCol = 1;					// Coluna inicial
	int bfCoordenadaLin = (iAltPadraoBF * 5);				// Linha padrão
	
	// Posições BF-Acao    
	int bfAcaoLarg = (int)(iTelaLarg * 0.65);	// Largura BF-80%	  
	int bfAcaoCol = bfCoordenadaLarg + 1;				// Coluna inicial da Bf-Acao
	int bfAcaoLin = bfCoordenadaLin;				// Linha padrão
	  
    // Posições Filtro    
	int bfFiltrarLarg = (int)(iTelaLarg * 0.24);	// Largura BF-20%    
	int bfFiltrarCol = bfAcaoCol + bfAcaoLarg + 1;							// Coluna inicial do Filtro
	int bfFiltrarLin = bfCoordenadaLin;				// Linha padrão
	
    	
	/***************************************************************************************************************************************/

	// Valores atribuidos a celula operação
	static String sOpScalp = "Scalping";
	static String sOpDay = "Day-trader";
	static String sOpSwing = "Swing-trader";

	
	boolean bInverteCor = false;		// Sinaliza inversão de cor
	 
    /*
	 *  TOTAL DE LINHAS A INSERIR NA TABELA
	 *  Há um padrão e uma consulta no total de registros(MySQL) antes para ajustar total de linhas
	 */
	//int iTotalLinTab = 999;								// TOTAL DE LINHAS A INSERIR NA TABELA
    static private int iTotalLinTab = 100000;							// Default									
    public void fixeTotalLinTab(int iTot){ iTotalLinTab = iTot; }	// Alterar valor
    public int pegueTotalLinTab(){ return iTotalLinTab; }			// Retorna valor
    
    // Posição da PLANILHA/tabela
    static int iAlturaLinTab = 20;					// Altura padrão da linha na tabela
    int bfTabLinIni = (iAltPadraoBF * 6); 	 // Posição inicial da linha da bar.fer.Tabela - logo abaixo de: [Coord-Acao-Filtrar]
    
    double dRestoDaAlt = ( iTelaAlt-(iAltPadraoBF*3) ) / 7;		// Divide o resto da Altura da tela por 7    
    int AltTabela = (int)dRestoDaAlt*3;							// Pega 4 partes do restante da Alt-da-Tela 
      
   
    /***************************************************************************************************************************************/

    /***************************************************************************************************************************************/
    // Posições das Sub-Bar.fer coordenadas - Em desuso, uniu-se a Filtro    
    int bfCoordLin = (iAltPadraoBF * 3) + 1;				// Linha padrão
    
    static int bfCoordFilCol = 1;							// Coluna inicial do Filtro    
    static int bfCoordFilLarg = 190;						// Largura do Filtro
    
    static int bfCoordPosCol = 191;							// Coluna inicial do Posição (1, 1)    
	static int bfCoordPosLarg = 150;						// Largura do Posição		(A1)
	
    static int bfCoordTitCol = 342;							// Coluna inicial do Tiulo    
	static int bfCoordTitLarg = 200;						// Largura do Titulo
	
	static int bfCoordCampoCol = 543;						// Coluna inicial do Campo  
	static int bfCoordCampoLarg = 730;						// Largura do Campo
		
    
    
    /*
     *  Abaixo da tabela
     
    int bfAddLin = AltTabela + bfTabLinIni + 3;
    int bfAddCol = 1;
    int bfAddLinLarg = iTelaLarg;						// O que sobrar da barra de Botoes
   	*/ 	

   


    // Text-Areas: Telnet, SLine, Log
    int TAreaAlt = ( (int)dRestoDaAlt*3) - (int)(iAltPadraoBF*3.6);	// Calcula a sobra de tela para a altura das B.Fer	
   
    
   // int TAreaLarg = (int)dDiv3LargTela;			// Largura padrão do T.Area
    int TAreaLarg = (int)iTelaLarg/2;				// Largura padrão do T.Area
    int TAreaLin = AltTabela + bfTabLinIni + 3;		// Num da linha(px - do topo esquerdo) na Tela do T.Area        
    
    static int taTelnetCol = 1;						// Posição inicial da coluna da B.Ferramentas
    int taSLineCol = (int)dDiv3LargTela;			// Posição inicial da coluna da B.Ferramentas
    int taLogCol = (int)dDiv3LargTela * 2;			// Posição inicial da coluna da B.Ferramentas
    
    static int iTamTexto = 9;								// tamanho do texto(padrão)
    public void FixeTamTexto(int iT){  iTamTexto = iT; }    	
    public void IncTamTexto(boolean bInc, int iT){ 
    	if(bInc) iTamTexto = iTamTexto + iT;				// Tamanho do Texto taTelnet
    	else iTamTexto = iTamTexto - iT;
    }
    public int PegueTamTexto(){ return iTamTexto; }
    
    /***************************************************************************************************************************************/
    // barra de Status
    int iBStLinIni = TAreaLin + TAreaAlt +1;

    // Bar.Fer Testes
    static int bfTesteLarg = 140;
 	static int bfTesteCol = 450;	
 	int bfTesteLin = TAreaLin + TAreaAlt -25;		
 	
 	 /***************************************************************************************************************************************/
 	// Grafico
 	int bfGraficoLin = TAreaLin;				// Linha inicial
 	int bfGraficoCol = 1;		// Coluna inicial
 	int bfGraficoLarg = iTelaLarg;		// Largura 
 	
 	static int Grade = 0;						// Não desenha linhas
    static int Linhas = 1;						// Desenha linhas de tempos
    static int Clock = 2;						// Desenha Clock
    
	int iColIniGraf = 110;				// Coluna inicial da grade
	int iColFimGraf = 1325;				// Coluna final da grade
	int iLinUpGraf = 15;				// Linha Sup.inicial da grade
	int iLinDnGraf = 180;				// Linha inferior da grade
	int iTotLinGraf = 13;				// Total de linhas na grade
	int iTotColGraf = 24;				// Total de colunas na grade

	int iEspaco = 55;
	int iColGSrUp = iColIniGraf + iEspaco;				// Pos-Grafico Sincronismo
	int iColGSrDn = iColGSrUp + iEspaco;			// Pos-Grafico Autentica
	int iColGAtUp = iColGSrDn + iEspaco;			// Pos-Grafico navega
	int iColGAtDn = iColGAtUp + iEspaco;			// Pos-Grafico navega
	int iColGCrcUp = iColGAtDn + iEspaco;			// Pos-Grafico navega
	int iColGCrcDn = iColGCrcUp + iEspaco;			// Pos-Grafico navega
	   
    int iColGSinc =  iColGCrcDn + iEspaco;			// Pos-Grafico Sincronismo
    int iColGAuth =  iColGSinc + iEspaco;			// Pos-Grafico Autentica
    int iColGNav =  iColGAuth + iEspaco;			// Pos-Grafico navega
    
	static int iCentro = 2;		// Centro do ponto no grafico
	static int iTamPingo = 4;	// Tamanho do Ponto
	static int iTamLedSinc = 10; // Tamanho do led de sincronismo
	
	boolean bZoom = false;
	public void FixeGfZoom(boolean bZ){ bZoom = bZ;   }		// Zoom do gráfico 50 ou 100pt
	public boolean PegueZoom(){ return bZoom; } 

	static int VERMELHO = 1;
	static int VERDE = 2;
	
	// Indica a necessidade de limpar ou manter combos
	static boolean bManterCombos = false; 
	static boolean bLimparCombos = true; 
       
    /***************************************************************************/
    // Mesnagens
    boolean bMsgAbrir = true;		// Arquivo importado..
    boolean bMsgSalvar = true;		// Arquivo salvo em...
    boolean bMsgCancel = true;		// Ação cancelada
    boolean bMsgErro = true;		// Falha ao abrir arquivo, etc    
    boolean bMsgExcluir = true;		// Excluir tabela...
    
    /***************************************************************************/
    // Nome ArqComunicação.txt
    static String sArqComDsl2730b = "ArqCom_Dsl2730.txt";	// Em desuso: nome do Arq.txt para repositório TArea-telnet
    
    
    /***************************************************************************/
    // Versão
    
    static int HubDLink = 1;		// Hub-opticom(Dsl2730b, Dsl485, Dsl279)    
    static int Dsl2500e = 2;		// DLink-mini    
    static int Intelbras = 4;		
    static int Cisco1841 = 5;		

    // Modens
    static int iModem1 = 0;
    static int iModem2 = 1;
    static int iModem3 = 2;
    static int iModem4 = 3;
    
    // Ips dos modens
    static String sIP[] = { "192.168.1.1",
    						"192.168.1.101",
    						"192.168.1.102",
    						"192.168.1.103",
    						"192.168.1.104" };
    
    public void FixeIP(String sIPx){
    	// Fixa valor IP, e seus subsequentes
    	/*
    	int iTam = sIPx.length();
    	String sParteIP = sIPx.substring(0, iTam - 1);					
    	int iFinalIP = Integer.parseInt( sIPx.substring(iTam - 1, 1) );    		
		//sH = sH.replaceAll("\\s+"," ");				// Suprime espaço-em-branco
		*/
    	
    	
    	sIP[0] = sIPx;
    	/*
    	sIP[1] = sParteIP + (iFinalIP + 1);
    	sIP[2] = sParteIP + (iFinalIP + 2);
    	sIP[3] = sParteIP + (iFinalIP + 3);
    	*/
    	new Log().Metodo("Define(): " + sIP[0]);
    	new Log().Metodo("Define(): " + sIP[1]);
    	new Log().Metodo("Define(): " + sIP[2]);
    	new Log().Metodo("Define(): " + sIP[3]);
    }
    public String PegueIP(int iQual){ return sIP[iQual]; }
    
    static String sMask = "255.255.255.0";
    public void FixeMask(String sM){ sMask = sM; }
    public String PegueMask(){ return sMask; }
    
    static String sLogin = "admin";
    public void FixeLogin(String sL){ sLogin = sL; }
    public String PegueLogin(){ return sLogin; }
    
    static String sSenha = "admin";
    public void FixeSenha(String sS){ sSenha = sS; }
    public String PegueSenha(){ return sSenha; }

    static int iPorta = 23;
    public void FixePorta(int iP){ iPorta = iP; }
    public int PeguePorta(){ return iPorta; }

    static String sURLteste = "www.uol.com.br";
    public void FixeURLteste(String sS){ sURLteste = sS; }
    public String PegueURLteste(){ return sURLteste; }
    
    // Tipo de teste
    static boolean bSimulacao = false;		// Simular comunicação com modem    
    public void FixeSimulacao(boolean bSimul){   	bSimulacao = bSimul;    }
    public boolean PegueSimulacao(){  	return bSimulacao;   }
        
    boolean bFmtPing = false;		// Traduz saida de ping ou não
    int iTipoTESTE = 0;
    static int tstMODEM = 0;		// Define que o tipo de teste sera dos modens
    static int tstADSL = 1;			// teste das porta ADSL
    
	// Tipo de teste
	static int STATUS = 1;			// ID teste de Status			
    static int AUTH = 2;			// ID teste de autenticação
    static int PING = 3;			// ID teste de ping
    static int LEDSINC = 4;			// ID teste de sinc.(led verm ou verde de sincronismo)
    static int ShMODEM = 5;			// ID Teste de conexao com modens(testa a mini-rede)
    static String BROW = "#CD853F";
    
    // Tempo de teste por sequencia
    static int iTempoTeste = 1;			// em minutos    
    public void FixeTempoTeste(int iF){ iTempoTeste = iF;   }	// Tempo de teste por sequencia, padrão 3 min
    public int PegueTempoTeste(){ return iTempoTeste; }
    
    /*
    // Projetos
    static String sPlanCorrente = "";								// Posição inicial da coluna da B.Ferramentas
    public void FixePlanCorrente(String sP){ sPlanCorrente = sP;   }	// Tempo de teste por sequencia, padrão 3 min
    public String PeguePlanCorrente(){ return sPlanCorrente; }
    */
    /***************************************************************************************************************************************/
    // Uteis
    static int A = 1;
    static int B = 2;
    static int C = 3;
    static int D = 4;
    static int E = 5;
    static int F = 6;
    static int G = 7;
    static int H = 8;
    static int I = 9;
    static int J = 10;
    static int K = 11;
    static int L = 12;
    static int M = 13;
    static int N = 14;
    static int O = 15;
    static int P = 16;
    static int Q = 17;
    static int R = 18;
    static int S = 19;
    static int T = 20;
    static int U = 21;
    static int V = 22;
    static int W = 23;
    static int X = 24;
    static int Y = 25;
    static int Z = 26;

    // barra de ferramentas Add-Linha	    
   	/*
   	 * Original: no topo ao lado dos botões   	 
    int bfAddLin = (iAltPadraoBF * 1) + 1; 		// Posição padrão inicial da linha da bar.fer.botões
   	int bfAddCol = bfBtnEdicaoPosCol + bfBtnEdicaoLarg + 1;
   	int bfAddLinLarg = iTelaLarg - (bfBtnEdicaoPosCol + bfBtnEdicaoLarg);						// O que sobrar da barra de Botoes
   	*/
    
     	
   	static int NumLinAdd = 1000;					// Num de Itens a adicionar no BFComboLinha
    static int NumSlotAdd = 16;					// Num de Itens a adicionar no BFComboSlot
    static int PlacaAdd = 72;				// Num de Itens a adicionar no BFComboPorta
    static int NumHVPAdd = 120;					// Num de Itens a adicionar no BFCombo-Hz, Vt, Pino    

    // Criptografia
    static String sKeyCript = "22_07_1970"; //"mt@Vi&w";
    static boolean bEncrypt = true;
    static boolean bDecrypt = false;

}
