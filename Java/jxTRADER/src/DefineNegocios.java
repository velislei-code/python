
import java.awt.Dimension;
import java.awt.Toolkit;
import java.io.*;	//Dir root File...
import java.util.regex.Matcher;

import javax.swing.JComboBox;


public class DefineNegocios {
	
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
    
    
    
    static String StatusTstParar = "Inativo";
    static String StatusTstPausa = "Pausa";
    static String StatusTstAtivo = "Ativo";
    
    // Controle do Status do teste
    static int tstSTATUS = 0;
    public void FixeTstStatus(int iS){  tstSTATUS = iS; }
    public int PegueTstStatus(){  return tstSTATUS; }
    static int tstPARAR = 0;
    static int tstPAUSA = 1;
    static int tstATIVO = 2;
    
    int iPintar = 0;	// Pintar grupo de linhas
    
    boolean  bFiltroAplicado = false;

    
    /***************************************************************************************************************************************/
     
      /*
       *  CTRL informe de status janelas abertas
       *  Evitar RE-abertura de janelas que já se encontram abertas - isto estava dando bugs
       */
	    static private boolean bStatusJanela = false;
	    
	    public void fixeStatusJanela(boolean bJanela){ 	bStatusJanela = bJanela; }
	    public boolean pegueStatusJanela(){ return bStatusJanela; }
	    	
	 
	 /***************************************************************************************************************************************
    /*
     * Variaveis que armazenam textos(valores) das Combo-box
     * Devido a forma de funcionamento das combos, para pegar valores das combos 
     * é necessario passar valores para uma String e depois pegar o valor
     */
	String sCBoxLinha;
	String sCBoxNumPorta;
	String sCBoxBloco;
	String sCBoxSlot;
	String sCBoxPorta;
	String sCBoxProtocolo;
	String sCBoxHz;
	String sCBoxVt;
	String sCBoxPino;
	String sCBoxFiltro;  

    
      /***************************************************************************************************************************************/ 
    
    /*
     * Variaveis que armazenam textos(valores) das Combo-box
     * Devido a forma de funcionamento das combos, para pegar valores das combos 
     * é necessario passar valores para uma String e depois pegar o valor
     */
    
	
    // Ctrl pegue/fixe das Strings(valor das combos) BFParametros		
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

	/***************************************************************************************************************************************/
	// TABELA
	// Dados iniciais da Tabela
    /*
	String[] sTabColunas = new String[]{"Reg", "Nome", "Ap./Fant.", "Dt.nasc.", "Endedereço", "Bairro", "Cidade", "UF", "CEP", "Fone1", "Fone2", "Celular", "Whats", "Email", "Contato", "Face", "Skype", "CNPJ","CPF", "RG", "Emissor", "IE", "IM", "Grupo", "Data", "Obs","Status","Login"};
	String[][] sTabDados = new String[][]{{"", "", "", "", "", "", "", "", "", "", "", "", "",  "", "", "", "", "", "", "", "", "", "", "", "", "", "", ""}};
	String[] sTabLinhas = new String[]{"", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", ""};
	*/
/*
 	String[] sTabColunas = new String[]{ "", "Reg", "Nome", "Ap./Fant.", "Dt.nasc.", "End.", "Bairro", "Cidade", "UF", "CEP", "Fone-1", "Fone-2", "Celular", "Whats", "Email", "Contato", "Face", "Skype", "CNPJ", "CPF", "RG", "Emissor", "IE", "IM", "Grupo", "Data","Obs","Status", "Login","XXX", "XXX"};
 	String[][] sTabDados = new String[][]{{"", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",  "", "", "", "", "", "", "", "", "", "", "", "", "", ""}};
 	String[] sTabLinhas = new String[]{"", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", ""};
 */
	/*****************************************************************************************************************************************************************************************************************************************************************************************/
	// Planilha do Form-Principal(analise)
    String[] sTabColunas = new String[]{ "", "Data", "Hora", "Abert.", "Máx.", "Min.", "Fech.", "T.Vol", "Vol.", "Spread", "", "Tend.", "Candle", "Status", "Oft(CP)", "Stop(CP)", "Pç(CP)", "Oft(VD)", "Stop(VD)", "Pç(VD)", "Res(%)", "Oper.", "Var(F)", "Var(M)", "","","","","","",""};
	String[][] sTabDados = new String[][]{{"", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",  "", "", "", "", "", "", "", "", "", "","","","",""}};
	String[] sTabLinhas = new String[]{"", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "","","","",""};

	/*
	 *  TOTAL DE LINHAS A INSERIR NA TABELA
	 *  Há um padrão e uma consulta no total de registros(MySQL) antes para ajustar total de linhas
	 */
    static private int iTotalLinTab = 10000;							// Default									
    public void fixeTotalLinTab(int iTot){ iTotalLinTab = iTot; }	// Alterar valor
    public int pegueTotalLinTab(){ return iTotalLinTab; }			// Retorna valor
 
    
      
 // Numeração de N é feita em: RederCongelarColuna.NumerarModens()
 	static int colN = 0;	// Congelado, uso em separado - sua formatação e numeração e feito na Class.RenderCongelarColuna
    
    // Endereços das colunas na tabela
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
    
    int iMemNumLin = 0;				// memoriza numero de linhas carregada na tabela
    int iMemNumCol = 0;				// memoriza numero de Colunas carregada na tabela
    int iTotColunaTab = colVAR_M;		// Total de títulos na Tabela

  

	/*****************************************************************************************************************************************************************************************************************************************************************************************/
	// Planilha do Form-Negocios(compra e venda de ações)
    String[] sTabNegColunas = new String[]{ "", "Empresa", "Valor(CP)", "Cotas(Cp)", "Crtg(CP)", "Eml", "ISS", "Sub.T(CP)", "Data", "Hora","", "Alvo", "Stop", "S.Loss", "", "Valor(VD)", "Cotas(VD)", "Crtg(VD)", "Eml(VD)", "ISS(VD)", "Sub.T(VD)", "Data(VD)", "Hora(Vd)", "Operacao", "","IR(%)","IR","Bruto","Líquido","%",""};
	String[][] sTabNegDados = new String[][]{{"", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",  "", "", "", "", "", "", "", "", "", "","","","",""}};
	String[] sTabNegLinhas = new String[]{"", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "","","","",""};

	/*
	 *  TOTAL DE LINHAS A INSERIR NA TABELA
	 *  Há um padrão e uma consulta no total de registros(MySQL) antes para ajustar total de linhas
	 */
    static private int iTotalLinTabNeg = 1000;							// Default									
    public void fixeTotalLinTabNeg(int iTot){ iTotalLinTabNeg = iTot; }	// Alterar valor
    public int pegueTotalLinTabNeg(){ return iTotalLinTabNeg; }			// Retorna valor
     
 // Numeração de N é feita em: RederCongelarColuna.NumerarModens()
 	static int colN_TabNeg = 0;	// Congelado, uso em separado - sua formatação e numeração e feito na Class.RenderCongelarColuna
   
    // Endereços das colunas na tabela
 	static int colEMPRESA_TabNeg = 0;
 	static int colValorCP_TabNeg = 1;
    static int colCotasCP_TabNeg = 2;
    static int colCorretagemCP_TabNeg = 3;
    static int colEmlCP_TabNeg = 4;
    static int colIssCP_TabNeg = 5;
    static int colSTotalCP_TabNeg = 6; 	
	static int colDataCP_TabNeg = 7;
    static int colHoraCP_TabNeg = 8;
    
    static int colSeparaCP_TabNeg = 9;
    static int colAlvo_TabNeg = 10;
    static int colStop_TabNeg = 11;
    static int colSLoss_TabNeg = 12;
    static int colSeparaAlvo_TabNeg = 13;
	static int colValorVD_TabNeg = 14;
    static int colCotasVD_TabNeg = 15;
    static int colCorretagemVD_TabNeg = 16;
    static int colEmlVD_TabNeg = 17;
    static int colIssVD_TabNeg = 18;
    static int colSTotalVD_TabNeg = 19; 	
	static int colDataVD_TabNeg = 20;
    static int colHoraVD_TabNeg = 21;
    
    static int colOperacao_TabNeg = 22;
    static int colSeparaVD_TabNeg = 23;
    static int colPercIR_TabNeg = 24;
    static int colIRValor_TabNeg = 25;
    static int colBruto_TabNeg = 26;
    static int colLiquido_TabNeg = 27;
    static int colPercLucro_TabNeg = 28;
    
    int iTotColunaTabNeg = colPercLucro_TabNeg;		// Total de títulos na Tabela
 
    double dEml = 0.03239; 		// % em emolumentos por operação
	double dISS = 0.0007883; 	// % de ISS por operação

	float fEml = 0.03239f; 		// % em emolumentos por operação
	float fISS = 0.0007883f; 	// % de ISS por operação

	// Ctrl numero de registros(baixados do Meta-trader) na Tabela
	private int iNumRegNegocios = 0;
	public void IncNumRegNegocios(){ iNumRegNegocios++; }
	public void fixeNumRegNegocios(int iL){ iNumRegNegocios = iL; }
	public int pegueNumRegNegocios(){ return iNumRegNegocios; }

	private int iCodEmpresa = 0;
	public void fixeComboCodEmpresa(int iVar){ iCodEmpresa = iVar; }
	public int pegueComboCodEmpresa(){ return iCodEmpresa; }
	
	private int iTimeM15 = 0;
	public void fixeComboTimeM15(int iVar){ iTimeM15 = iVar; }
	public int pegueComboTimeM15(){ return iTimeM15; }

	private int iAlvo = 0;
	public void fixeComboAlvo(int iVar){ iAlvo = iVar; }
	public int pegueComboAlvo(){ return iAlvo; }
	
	private int iRiscoGanho = 0;
	public void fixeComboRiscoGanho(int iVar){ iRiscoGanho = iVar; }
	public int pegueComboRiscoGanho(){ return iRiscoGanho; }

	private int iStopLoss = 0;
	public void fixeComboStopLoss(int iVar){ iStopLoss = iVar; }
	public int pegueComboStopLoss(){ return iStopLoss; }

  /***************************************************************************************************************************************/
    
    static int iTamTexto = 9;								// tamanho do texto(padrão)
    public void FixeTamTexto(int iT){  iTamTexto = iT; }    	
    public void IncTamTexto(boolean bInc, int iT){ 
    	if(bInc) iTamTexto = iTamTexto + iT;				// Tamanho do Texto taTelnet
    	else iTamTexto = iTamTexto - iT;
    }
    public int PegueTamTexto(){ return iTamTexto; }
    
    /***************************************************************************************************************************************/
    // Indica a necessidade de limpar ou manter combos
 	static boolean bManterCombos = false; 
 	static boolean bLimparCombos = true; 
  
 	  /***************************************************************************************************************************************/
 	 
	// VERIFICAR, SE ESTA EM USO
 		// usado para formatar arquivo.csv
 		String sTabTitulo = "Porta;Data(def);Prot.;Hz;Vt;Pino;Teste;Sinc.;Sinc(T);Vel.Up;Vel.Dn;SR.Up;SR.Dn;At.Up;At.Dn;Crc Up;Crc Dn;Aut.;Aut(T);IP;Nav.;Nav(T);Ping;Voz(AxA);Voz(BxB);Voz(ABxT);Data;Obs";

 		// Valores atribuidos a celula Ação
 		static String AcaoTestar = "Testar";
 		static String AcaoSaltar = "Saltar";
 		static String AcaoEmTst = "Testando...";
 		static String AcaoEmSim = "Simulando...";
 		static String AcaoFimSim = "Simulado";
 		static String AcaoFimTst = "Testado";
 		static String AcaoFimTstOK = "Teste OK"; 
 		static String AcaoFimTstNOK = "Teste Falhou";

 		
 		boolean bInverteCor = false;		// Sinaliza inversão de cor

 	 /***************************************************************************************************************************************
 	// Grafico
 	int bfGraficoLin = TAreaLin;				// Linha inicial
 	int bfGraficoCol = (int)iTelaLarg/2;		// Coluna inicial
 	int bfGraficoLarg = (int)iTelaLarg/2;		// Largura 
 	
 	static int Grade = 0;						// Não desenha linhas
    static int Linhas = 1;						// Desenha linhas de tempos
    static int Clock = 2;						// Desenha Clock
    
	int iColIniGraf = 110;				// Coluna inicial da grade
	int iColFimGraf = 610;				// Coluna final da grade
	int iLinUpGraf = 15;				// Linha Sup.inicial da grade
	int iLinDnGraf = 180;				// Linha inferior da grade
	int iTotLinGraf = 13;				// Total de linhas na grade
	int iTotColGraf = 12;				// Total de colunas na grade

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
    
    
    /***************************************************************************
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
    static String sIP[] = {"192.168.1.101",
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
    	
    	/*
    	sIP[0] = sIPx;
    	/*
    	sIP[1] = sParteIP + (iFinalIP + 1);
    	sIP[2] = sParteIP + (iFinalIP + 2);
    	sIP[3] = sParteIP + (iFinalIP + 3);
    	*
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
    
 
    /*
     *  Abaixo da tabela
     
    int bfAddLin = AltTabela + bfTabLinIni + 3;
    int bfAddCol = 1;
    int bfAddLinLarg = iTelaLarg;						// O que sobrar da barra de Botoes
   	*/ 	
   	
   	static int NumLinAdd = 100;					// Num de Itens a adicionar no BFComboLinha
    static int NumSlotAdd = 16;					// Num de Itens a adicionar no BFComboSlot
    static int NumPortaAdd = 72;				// Num de Itens a adicionar no BFComboPorta
    static int NumHVPAdd = 120;					// Num de Itens a adicionar no BFCombo-Hz, Vt, Pino    

    // Criptografia
    static String sKeyCript = "mt@Vi&w";
    static boolean bEncrypt = true;
    static boolean bDecrypt = false;

}

