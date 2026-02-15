// package mtaview;
/*
 * Bugs encontrados em 16dez2014:
 * 1 - Inicio Teste, testes em simulação, ao alterar para testes normal, 
 * a tabela é recarregada, mas ja havia feito algumas alterações na descção da tabela
 * 
 * 2 - campos setados como Saltar, voltam a Testar qdo peço repetir testes;
 */

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Component;
import java.awt.Cursor;
import java.awt.EventQueue;
import java.awt.Font;
import java.awt.Graphics;
import java.awt.Label;
import java.awt.MenuItem;
import java.awt.PopupMenu;
import java.awt.Toolkit;
import java.awt.Dimension;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.ItemEvent;
import java.awt.event.ItemListener;
import java.awt.event.KeyEvent;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;  
import java.util.GregorianCalendar;
import java.util.StringTokenizer;
import java.util.logging.Level;
import java.text.DecimalFormat;
import java.text.NumberFormat;
import java.text.SimpleDateFormat; 
import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;

import javax.swing.BorderFactory;
import javax.swing.DefaultCellEditor;
import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JComboBox;
import javax.swing.JComponent;
import javax.swing.JFileChooser;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JPopupMenu;
import javax.swing.JSeparator;
import javax.swing.JTextField;
import javax.swing.JToggleButton;
import javax.swing.ScrollPaneConstants;
import javax.swing.SwingConstants;
import javax.swing.JMenuBar;
import javax.swing.JMenu;
import javax.swing.JMenuItem;
import javax.swing.Timer;
import javax.swing.JPopupMenu.Separator;
import javax.swing.JToolBar;
import javax.swing.JTextArea;
import javax.swing.JTable;
import javax.swing.table.DefaultTableModel;
import javax.swing.table.TableCellEditor;
import javax.swing.table.TableCellRenderer;
import javax.swing.table.TableColumn;
import javax.swing.table.TableModel;
import javax.swing.table.TableRowSorter;
import javax.swing.JScrollPane;
import javax.swing.JScrollBar;

import java.awt.*;
import java.awt.event.*;

import javax.swing.*;
import javax.swing.border.*;
import javax.swing.event.*;
import javax.swing.table.*;

import com.nikhaldimann.inieditor.IniEditor;
//import com.sun.istack.internal.logging.Logger;

import jxl.Cell;
import jxl.Sheet;
import jxl.Workbook;
import jxl.read.biff.BiffException;

//package mtaview;












import java.awt.BorderLayout;


//import Arquivos.OpenL;

/*
*  jxTRADER: j(Java), x(formulas), Trader(bm&f)
*  by: Treuk, Velislei A
*  23/nov/2018
*  Reaproveitamento de software 
*  		mtaView
*  		mta-n7
*  		mta-nv6
*  		mta.app.pc@gmail.com (V**1**a*)
*  		https://mtaapppc.wixsite.com/suporte
*  		http://adilsonvt100.wixsite.com/mtaweb
*  
*  Font do Eclipse: 
*  	->Window->Preferences->General ->Appearance->Colors and Fonts->Basic->Text Font
*  
*  Pastas: jxTrader_docs é auto-criado dentro de Arquivo.criarDiretorio()
*/

public class mtaView extends JFrame{
	
	private Date data = new Date();  
	private SimpleDateFormat Formatar = new SimpleDateFormat("dd/MM/yyyy");
	private String sHora;
	private String sMin;
	private String sSeg;
	private String sMiliSeg;
	

    
	// Teste de var
	private static String sTeste;
	private static void FixeTeste(String sT){  sTeste = sT; }
	private static String PegueTeste(){  return sTeste; }
	
	
	// Controla sequencia corrente em teste(Md 1 a 4, 5a8, 9a12, etc)
    static int iSeqEmTeste = 0;		 
    public void FixeSeqEmTeste(int iS){  iSeqEmTeste = iS; }
    public int PegueSeqEmTeste(){  return iSeqEmTeste; }
    
    // Controla os processos(Testes: sinc, aut, nav - dentro de uma sequencia)
	static int iTimeProcesso;				   
    public void FixeTimeProcesso(int iT){  iTimeProcesso = iT; }
    public int PegueTimeProcesso(){  return iTimeProcesso; }
    
    // Controla Linha da Planilha atual em teste   
    static int iLinAtual = 0;
    public void FixeLinAtual(int iL){  iLinAtual = iL; }    	
    public int PegueLinAtual(){ return iLinAtual;    }
    
	private Ping objPing = new Ping();
	private int iSegTimer;			// Controla tempo dos pings
	//private boolean bSincMd[] = {false, false, false, false};			// Memoriza status de sincronismo dos modens 
	private Label statusLabel;
  
	
	private Licenca objLicenca = new Licenca();	// trata da licença do software   
	private Definicoes objDef = new Definicoes();   
	private Ferramentas objUtil = new Ferramentas();
	private Log objLog = new Log();   
	
	//private StorangeTabRascunho objArmazenaTabRascunho = new StorangeTabRascunho();  	// Armazena dados(temp) de consulta Tabela Mysql
	//private StorangeTabBovespa objArmazenaTabBovespa = new StorangeTabBovespa();  	// Armazena dados(temp) de consulta Tabela Mysql
	private Calcular objCalcular = new Calcular();  
	private Operacao objOperacao = new Operacao();
	private MySQL objMySQL = new MySQL();
	private CxDialogo objCxD = new CxDialogo(); 
	private FormOpcProjeto objFrmOpcao = new FormOpcProjeto();	
	private FormSobre objFrmSobre = new FormSobre();
	private FormInfo objFrmInfo = new FormInfo();
	private FormPropriedadesTab objFrmPropriedadesTab = new FormPropriedadesTab();
	private String vsLinha[] = new String[1000];
	/*
	 * Modens que não estão em uso no prototipo
		private DLinkOpticom objDsl485 = new DLinkOpticom();		// Objeto Modem	 
		private DLinkOpticom objDsl279 = new DLinkOpticom();		// Objeto Modem 
		private Intelbras objIntelbras = new Intelbras();	// Objeto Modem
		private Cisco1841 objCisco1841 = new Cisco1841();	// Objeto Cisco
	*/
	private int iNumProcesso = 0;						// Numera/controla processo de teste
	private Graficos gGrafico = new Graficos();		// Contruir Grade do gráfico
	
	
	private RenderCorOpcao CellRenderer = new RenderCorOpcao();
	private Arquivos objArquivo = new Arquivos();
 
	private static JFrame FrmPrincipal = new JFrame();
	private static JPanel Painel = new JPanel();
	private JScrollPane BRolagemPainel = new JScrollPane(Painel); 
 
	// Componentes da Planilha - criado Global devido bugs de inserção qdo declarado no metodo
	private JToolBar BfPlanilha = new JToolBar(); 
	private JTable Planilha = new JTable(); 	
	private JScrollPane BRolagemPlanilha = new JScrollPane(Planilha, JScrollPane.VERTICAL_SCROLLBAR_ALWAYS, JScrollPane.HORIZONTAL_SCROLLBAR_ALWAYS);
	 

	
	private DefaultTableModel ModeloTab = new DefaultTableModel(objDef.sTabDados, objDef.sTabColunas){
		// Bloqueia edição das colunas menor que 1
		public boolean isCellEditable(int row, int col) {   	      
	        if (col < 1) {  
	            return false;  
	        } else {  
	            return true;  
	        }  
	    } 
	};
	
		
		
	// Cria Cx-seleção dentro das celulas "Ação: Testar, Saltar, Testado, Simulado"
	
	/*
	private String sSelTeste[][] = { 	{ objDef.AcaoTestar, objDef.AcaoSaltar, objDef.AcaoFimTst, objDef.AcaoFimSim}, 
										{ objDef.AcaoTestar, objDef.AcaoSaltar, objDef.AcaoFimTst, objDef.AcaoFimSim},
										{ objDef.AcaoTestar, objDef.AcaoSaltar, objDef.AcaoFimTst, objDef.AcaoFimSim},
										{ objDef.AcaoTestar, objDef.AcaoSaltar, objDef.AcaoFimTst, objDef.AcaoFimSim} };
	
	
	private JComboBox cbTabTeste = new JComboBox(sSelTeste[0]);
	
	    
	private TableCellEditor CxSelTeste = new DefaultCellEditor(cbTabTeste);
 
	 */
	
	// Matriz de opcoes Cx-Seleção dentro da Planilha 
	private String sSelStatus[][] = { {"Comprado", "Vendido"}, 
										{"Comprado", "Vendido"} };
	private JComboBox cbTabProtocol = new JComboBox(sSelStatus[0]);
	private TableCellEditor CxSelProtocol = new DefaultCellEditor(cbTabProtocol);

	 // Criar botões
	 JButton BtnPrjNovo = new JButton();
	 JButton BtnPrjAbrir = new JButton();
	 JButton BtnPrjSalvar = new JButton();	
	 JButton BtnPrjSalvarAs = new JButton();	
	 JButton BtnPausar = new JButton();			// Pausar Testes
	 JButton BtnParar = new JButton();			// Parar testes
	 JButton BtnSaltar = new JButton();		// LimparTst testes(apaga dados dos testes)	
	 JButton BtnSair = new JButton();
	 JButton BtnExportar = new JButton();
	 JButton BtnImportar = new JButton();
	 JButton BtnImportarMTrader = new JButton();		// importa **.MTrader)		
	 JButton BtnRestaurar = new JButton();
	 JButton BtnCoordenada = new JButton();
	 JButton BtnLapis = new JButton();
	 JButton BtnShowFiltrar = new JButton();
	 JButton BtnNavegador = new JButton();
	 JButton BtnMedias = new JButton();
	 JButton BtnInfoAjd = new JButton();
	 JButton BtnLog = new JButton();
	


	// Componentes Bf-Testes
	private JToolBar BfTeste = new JToolBar(); 	
	private JButton BtnTstSinc = new JButton();
	private JButton BtnTstAuth = new JButton();
	private JButton BtnTstPing = new JButton();
	private JButton BtnTstVoz = new JButton();

	// Componentes Bf-Filtro(Antigo, NAÕ USA)
	private JToolBar BfFiltro = new JToolBar();
	private JButton BtnFiltrarAntigo = new JButton();
	private final JTextField tfFiltrarAntigo = new JTextField(20);
	private JLabel lblStatus;   
	

 // Telnet
	private JToolBar BarFerTelnet = new JToolBar();
	private JTextArea taTelnet = new JTextArea();
	private JScrollPane BRolagemTArea = new JScrollPane(taTelnet, JScrollPane.VERTICAL_SCROLLBAR_ALWAYS, JScrollPane.HORIZONTAL_SCROLLBAR_ALWAYS);

	
	// Grafico
	private JToolBar BarFerGrafico = new JToolBar();
	private JPanel objPnGrafico = new JPanel();
	private JScrollPane BRolagemGrafico = new JScrollPane(objPnGrafico, JScrollPane.VERTICAL_SCROLLBAR_ALWAYS, JScrollPane.HORIZONTAL_SCROLLBAR_ALWAYS);
	
	
	// Status line
	private JTextArea taSLine = new JTextArea();
	private JToolBar BfSLine = new JToolBar();
	private JScrollPane BRolaSLine = new JScrollPane(taSLine, JScrollPane.VERTICAL_SCROLLBAR_ALWAYS, JScrollPane.HORIZONTAL_SCROLLBAR_ALWAYS);
	 
	 // Log
	 private JTextArea taLog = new JTextArea();
	 private JToolBar BfLog = new JToolBar();
	 private JScrollPane BRolaLog = new JScrollPane(taLog, JScrollPane.VERTICAL_SCROLLBAR_ALWAYS, JScrollPane.HORIZONTAL_SCROLLBAR_ALWAYS);

	// Componentes Bf-Coordenadas(ANTIGO, NÃO USA)
	 private JComboBox cbFiltro  = new JComboBox();
	 private JToolBar BfCoordenadas_antigo = new JToolBar();
	 private JToolBar BfCoordFiltro = new JToolBar();
	 private JToolBar BfCoordPos = new JToolBar();
	 private JToolBar BfCoordTitulo = new JToolBar();
	 private JToolBar BfCoordCampo = new JToolBar();	 
	 private JTextField tfCoord_antigo = new JTextField();	
	 private JTextField tfCelula = new JTextField();	
	 private JTextField tfTitulo = new JTextField();	
	 private JTextField tfConteudo = new JTextField();
	 
		
	// Componentes da BferAddCotacao
	 static boolean bExibeAddCotacao = false;	// Ver se usa
	 JToolBar BfAddCotacao = new JToolBar();
	 private JComboBox cbCodEmpresa  = new JComboBox();
	 private JTextField tfDataCota = new JTextField();	 
	 private JComboBox cbTimeM15 = new JComboBox();	 
	 
	 final JTextField tfOpen = new RenderTextoGost("Abert.");	 
	 final JTextField tfHigh = new RenderTextoGost("Máx."); //JTextField();
	 final JTextField tfLow = new RenderTextoGost("Min.");	 
	 final JTextField tfClose = new RenderTextoGost("Fech.");	 
	 final JTextField tfTVol = new RenderTextoGost("T.Vol.");	 
	 final JTextField tfVol = new RenderTextoGost("Vol.");	 
	 final JTextField tfSpread = new RenderTextoGost("Spread");	 

	 /*
	  * Componentes da BFerParametros
	 
	  * N.Reg:		Amostragem(Tend)		
	  * LTB(%)		LTA(%)		
	  * Stop-CP(%)		Stop-VD(%)		
	  * Oft-CP(%)		Oft-VD(%)	
	  */
	 static boolean bExibeParametros = false;		// Ver se usa
	 JToolBar brParametros = new JToolBar();
	 private JButton BtnCalcular = new JButton();	// Cria Botão - ajusta combos para valor default
		
	 private JComboBox cbNRegistro  = new JComboBox();	// Num.registros a analisar operaçoes passadas
	 private JComboBox cbAmostraMED = new JComboBox();	// Num.de fechamentos(anterior) para gerar média de tendencia(%) 	 
		
	 private JComboBox cbAmostraTEND = new JComboBox();	// Num.de fechamentos(anterior) para gerar média de tendencia(%) 	 
	 private JComboBox cbLtb = new JComboBox();		// LTB - Linha Tendencia de baixa	 
	 private JComboBox cbLta = new JComboBox();	 	// LTA - Linha de tendencia de Alta
	 private JComboBox cbStopCP = new JComboBox();	// Stop de Compra(%) 	
	 private JComboBox cbStopVD = new JComboBox();	// Stop de venda(%) 
	 private JComboBox cbOfertaCP = new JComboBox();// Oferta de compra(%)	 
	 private JComboBox cbOfertaVD = new JComboBox();// Oferta de venda(%)	 
	 private JComboBox cbTravarOfertaCP = new JComboBox();// Travar Oferta de compra(%) - o preço de compra sempre deve ser <= ao ult.Preço de venda	 
	 private JComboBox cbTravarOfertaVD = new JComboBox();// Travar Oferta de venda(%) - o preço de venda sempre deve ser > que o preço de compra	 
	 private JComboBox cbReferencia = new JComboBox();// referencia(Max/Min ou fechamento)	 
	
	 // BF. Resultado dos parametros
	 static boolean bExibeResultaParametros = false;		// Ver se usa
	 JToolBar BfResultaParametros = new JToolBar();
	 
	 private JTextField tfProjLucro = new JTextField();
	 private JTextField tfNumOperaCP = new JTextField();
	 private JTextField tfNumStopCP = new JTextField();
	 private JTextField tfNumOperaVD = new JTextField();
	 private JTextField tfNumStopVD = new JTextField();
	 private JTextField tfPeriodo = new JTextField();
	 private JTextField tfDayTrade = new JTextField();
	 private JTextField tfSwingTrade = new JTextField();
	 /*
	 final JTextField tfProjLucro = new RenderTextoGost("Projeção de lucro");	 
	 final JTextField tfNumOperaCP = new RenderTextoGost("N.Operações-CP");	 
	 final JTextField tfNumStopCP = new RenderTextoGost("N.Stop-CP");	 
	 final JTextField tfNumOperaVD = new RenderTextoGost("N.Operações-VD");	 
	 final JTextField tfNumStopVD = new RenderTextoGost("N.Stop-VD");	 
		
	 /*********************************************************************************/
	 // Trio - [Coord - Acao - Filtro]
	
	 // Componentes BF-Coordenadas
	 private JToolBar BfCoordenada = new JToolBar();
	 private JTextField tfCoord = new JTextField();	
	
	 // Componentes da BfAcao
	 JToolBar BfAcao = new JToolBar();
	 
	 private JTextField tfPrcMin = new JTextField();	// Preço minimo p/ periodo analisado
	 private JTextField tfMedMin = new JTextField();	// Media(10 res) dos preços minimos/max
	 private JTextField tfPrcMed = new JTextField();	// Preço médio p/ periodo analisado
	 private JTextField tfMedMax = new JTextField();	// Média de preço máximo para amostragem(10, 20, 30, n)	 
	 private JTextField tfPrcMax = new JTextField();	// Preço max p/ periodo analisado 
	 private JTextField tfAcaoStatus = new JTextField();
	 private JTextField tfOrdem = new JTextField();
	 private JTextField tfUltTendencia = new JTextField();
	 private JTextField tfOferta = new JTextField();
	 private JTextField tfStop = new JTextField();
	 
	/* 
	 final JTextField tfOrdem = new RenderTextoGost("Aguardando ponto de reversão");
	 final JTextField tfUltTendencia = new RenderTextoGost("Ult.Tendencia"); //JTextField();
	 final JTextField tfOferta = new RenderTextoGost("Oferta"); //JTextField();
	 final JTextField tfStop = new RenderTextoGost("Stop");	 
	 */

	// Componentes Bf-Filtro(Novo)
	private JToolBar BfFiltrar = new JToolBar();
	private JButton BtnFiltrar = new JButton();
	private final JTextField tfFiltrar = new JTextField(20);
	
		
	// Componentes Barra de Status
	 private JToolBar BStatus = new JToolBar();
	 private JTextField tfBarraStatus = new JTextField();
		
	 private JToolBar BStatusTeste = new JToolBar();
	 private JTextField tfLedBarraStatus = new JTextField();
		
	
	 // Construtor
	 public mtaView() {
		 initComponents();
	 }
 

	 
 private void initComponents() {
 
 	
	 
 	objLog.Metodo("");    
 	objLog.Metodo("*** START mtaVIEW - "+data+" *** ");
	objLog.Metodo("jxTMain().initComponents()");
	
	// Consulta total de regs na tabela 	
//	objDef.fixeTotalLinTab( objMySQL.ContaRegistros(objDef.sTabOperacaoTemp) );

	
	objLog.Metodo("jxTMain().Init().LerConfig(objDef.bCriptoConfig), Time: " + objDef.iTempoTeste+", Txt: " + objDef.iTamTexto +", Zoom: " + objDef.bZoom +", Sml: " + objDef.bSimulacao);
	objLog.Metodo("jxTMain().LerConfig( Config.ini[Simulacao: " + objDef.bSimulacao + "] )");
 	ConstruirForm(); 	
 	ConstruirPainel();   	
 	ConstruirMenu(); 		// Constroe menus: Projeto, Sistema, Ferramentas, Opçoes, Info
 	
 	// Constroe barra de ferramentas
 	ConstruirBfSistema();
 	ConstruirBfExcel();
 	ConstruirBfRede();
 	ConstruirBfEdicao();
 	ConstruirBfProjeto();    	
 	ConstruirBfAddCotacao(true);    	
 	// ConstruirBfTeste();		// Botoes para testes de programação
 	ConstruirbrParametros(true);
 	ConstruirBfResultaParametros(true);	// Resultado dos cálculos baseado nos parametros
 	
 	// Trio - [Coord - Acao - Filtro]
 	MontarBfCoordAcaoFiltro(true);
 	
 	ConstruirPlanilha(false);		// Constroe Planilha(Planílha de testes)
 	//ConstruirBfTelnet();		// TextArea Telnet(Comunicação com modens)
 	ConstruirBfGrade(); 		// Grade de linhas(Gráfico de sinais)
 	//ConstruirBfGrafico2D(); 		// Grafico 
 	// ConstruirBfSLine();			// TArea Status Line
 	// ConstruirBfLog();			// TArea LOg
 	
 	//ExibirOcultar(objDef.INICIALIZAR);	// Ajustar altura das BFerramentas
 	
// 	ConstruirBfCoordenadas();
 	
	//objMySQL.CarregaPlanilha(Planilha, "rascunho");	// Carrega dados da mysql na planilha
	
	InicializarCombos();	// Carrega valores nas combos
 	ConstruirBStatus2();		// Barra de Status(no rodapé)
 	
 	
	/***********************************************************************************************/
	// Carrega ultimo arquivo em uso  
	 
	try{
		LerConfig(objDef.bCriptoConfig);		// Carrega config de usuário 
    } catch (IOException ex) {  
   	 	objCxD.Aviso("Erro ao carregar arquivo de configuração, " + ex, objDef.bMsgErro);  
    } finally{
    	
    
		   
		 	// Carrega ultima planilha em uso 
		 	if( !objArquivo.PegueAbreDirArq().contains(".jxt")){
		 		// Aki - caso ocorra falha ao ler arquivo recente, abre default
		 		String sArqDefault = objDef.DirBak + "default.jxt";
		 		objArquivo.FixeAbreDirArq("sArqDefault");
		 		objLog.Metodo("Loc2000a - Abrir arquivo: " + sArqDefault);
		 		
		 	}else{
		 	
		 		// Se arquivo for *.jxt	
		 		String vtParamRelAcao[] = new String[50];
		 		
		 		objLog.Metodo("Loc2001a - Lendo Planilha corrente: " +  objArquivo.PegueAbreDirArq());
		 		
		 		// testa se tem algum endereço para abrir o arquivo
		 		if( objArquivo.PegueAbreDirArq().contains(".jxt")){
			 		
			 		try{
			 			
			 				//objArquivo.LerMtaIni(Planilha, null);			 
					 		objLog.Metodo("Planilha em uso: " +  objArquivo.PegueAbreDirArq());
					 
					 			vtParamRelAcao = objArquivo.LerJxtIni(Planilha,  objArquivo.PegueAbreDirArq(),objLicenca.pegueLicenca());
			
					 			FmtVetorToCampos(vtParamRelAcao);	// Pega valores de vetor e preenche campos nas BF-Param, Rel e Acao
					 		
			 				
			 			
			 		 	}catch(IOException e){ 			
			 		 		objCxD.Aviso("Erro! Impossível abrir arquivo: " +  objArquivo.PegueAbreDirArq(), objDef.bMsgAbrir);
			 		 		
			 		 	}finally{ 			
			 		 		// Se dir não existe...cria dir mtaview_docs/backup
			 		 		objLog.Metodo("jxTrader(Loc2001b).objArquivo.criarDiretorio()");
			 		 		objArquivo.criarDiretorio(); 		 		
			 		 	}
		 		}
		 		
		 	}
		 		
    }
 	
 	/*
 	 * Seta titula da janela, caso não haja o path do projeto, set nome default-temp
 	 */
 	if( objArquivo.PegueAbreDirArq().contains(".")){
 		FrmPrincipal.setTitle("jxTrader - " +  objArquivo.PegueAbreDirArq());
 	}else{
 		FrmPrincipal.setTitle("jxTrader - ...\\temp\\PrjAnaliseDados.jxt");
 	}
 	
 	
 	 try{ 			
		 	objArquivo.SalvarLicenca();		// Registra dados sobre ctrl de licença
	 	}catch(IOException e){ 			
	 		objLog.Metodo("Erro! Impossível abrir arquivo: " + objDef.Lcc1);	 		
	 	}finally{ 			
	 		
	 		 		
	 	}
	
 	
 	try{
		objArquivo.LerLicenca();
	}catch(IOException e){
		objLog.Metodo("jxTMain().objArquivo.LerLicenca(Erro ao ler Arquivo)");
	}finally{
		
	}
 	
 	if(objUtil.ContarReg(Planilha) > 99){	// Se houver registros na planilha...
 		this.carregarCombosCV(objDef.bManterCombos);	// carrega preços de Compra e venda na combo
 	}	
 	
 	
 	
 	
}	// Final de init...
    
 
 
 
 
 
 
 
 /********************************************************************************************************************/
 public void ConstruirForm(){
		
	 objLog.Metodo("jxTMain().ConstruirForm()");
	
	 // Formulário principal
 	//EX: this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
 	FrmPrincipal.setDefaultCloseOperation(FrmPrincipal.EXIT_ON_CLOSE); 	// TERMINAR A EXECUCAO SE O FrmPrincipal FOR FECHADO
 	FrmPrincipal.setTitle("jxTrader");// SETA O TITULO  DO FrmPrincipal    
 	FrmPrincipal.setSize(objDef.iTelaLarg, objDef.iTelaAlt);	//	SETA O TAMANHO DO FORUMLARIO             
 	FrmPrincipal.setLocationRelativeTo(null);  // CENTRALIZA O FrmPrincipal    
 	FrmPrincipal.setExtendedState(FrmPrincipal.getExtendedState()|JFrame.MAXIMIZED_BOTH); 
 	// Icone do Form
 	 String stIcon = objDef.DirRoot + "/imagens/placa2.png";		// Dir ico    
     Image icon = Toolkit.getDefaultToolkit().getImage(stIcon);	// carrega Icon - não esta carreganfo
     this.setIconImage(icon);
 	 FrmPrincipal.setIconImage(icon);
     
 }

 public void ConstruirPainel(){
		objLog.Metodo("jxTMain().ConstruirPainel()");

 	  
     Painel.setLayout(null); 	//DESLIGANDO O GERENCIADOR DE LAYOUT  
    // Ex: BRolagemPainel.setHorizontalScrollBarPolicy(JScrollPane.HORIZONTAL_SCROLLBAR_AS_NEEDED);
    // Ex: BRolagemPainel.setVerticalScrollBarPolicy(JScrollPane.VERTICAL_SCROLLBAR_NEVER);
    // Ex: BRolagemPainel.setBounds(50, 30, 300, 50);

     FrmPrincipal.add(BRolagemPainel); 	// Adiciona ao formulário
    
    
 }
 
 private static void AddPainel(Component Componente , int nColuna , int nLinha , int nLargura , int nAltura)  
 {
     Painel.add(Componente) ;  // Adiciona componente ao painel                    
        Componente.setBounds( nColuna , nLinha , nLargura , nAltura ); // Fixa posição do componente
 }
 

 /********************************************************************************************************************/

		
 public void ConstruirMenu(){
		
	objLog.Metodo("jxTMain().ConstruirMenu()");
 	ConstruirSubMenuPrj();
 	ConstruirSubMenuSys();
 	ConstruirSubMenuFer();
 	ConstruirSubMenuOpc();
 	ConstruirSubMenuInfo();
 }

public void ConstruirSubMenuPrj(){

	// Constroe Menu Projeto [Novo, abrir, ...]
	objLog.Metodo("jxTMain().ConstruirSubMenuPrj()");
 	
 	// Menu
 	JMenuBar BarraMenuArq = new JMenuBar();		
		AddPainel(BarraMenuArq, objDef.bfMenuPrjCol, objDef.bfMenuLin, objDef.iMenuPrjLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
		
		JMenu jMenuArq = new JMenu();
		
		BarraMenuArq.add(jMenuArq);
		
		jMenuArq.setText("Projeto");
		jMenuArq.setCursor(new Cursor(Cursor.HAND_CURSOR));
		
		
		//-------------------------------------------------------------
		// Item de Menu: Projeto		
		JMenuItem jMenuPrjNovo = new JMenuItem();
		JMenuItem jMenuArqAbrir = new JMenuItem();
		JMenuItem jMenuArqSalvar = new JMenuItem();
		JMenuItem jMenuArqSalvarAs = new JMenuItem();
		Separator jMenuArqSepara1 = new Separator();
		JMenuItem jMenuArqExportar = new JMenuItem();
		JMenuItem jMenuArqImportar = new JMenuItem();
		JMenuItem jMenuArqImportarMTrader = new JMenuItem();
		JMenuItem jMenuArqRestaurar = new JMenuItem();
		Separator jMenuArqSepara2 = new Separator();
		JMenuItem jMenuArqSair = new JMenuItem();
		
		jMenuArq.add(jMenuPrjNovo);
		jMenuArq.add(jMenuArqAbrir);
		jMenuArq.add(jMenuArqSalvar);
		jMenuArq.add(jMenuArqSalvarAs);
		jMenuArq.add(jMenuArqSepara1);
		jMenuArq.add(jMenuArqExportar);
		jMenuArq.add(jMenuArqImportar);
		jMenuArq.add(jMenuArqImportarMTrader);
		jMenuArq.add(jMenuArqRestaurar);
		jMenuArq.add(jMenuArqSepara2);
		jMenuArq.add(jMenuArqSair);
				
				
		jMenuPrjNovo.setText("Novo");
		jMenuArqAbrir.setText("Abrir");
		jMenuArqSalvar.setText("Salvar");
		jMenuArqSalvarAs.setText("Salvar como");
		jMenuArqExportar.setText("Exportar(*.csv)");
		jMenuArqImportar.setText("Importar(*.csv)");
		jMenuArqImportarMTrader.setText("Importar(MTrader)");
		jMenuArqRestaurar.setText("Restaurar(*.bak)");
		jMenuArqSair.setText("Sair");
		
		// Icones
		jMenuPrjNovo.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnTabela16.png"));		
		jMenuArqAbrir.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnAbrirDoc16.png"));
		jMenuArqSalvar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnSalvar16.png"));
		jMenuArqSalvarAs.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnSalvarAs16.png"));
		jMenuArqExportar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnExpExcel16.png"));
		jMenuArqImportar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnAbrirExcel16.png"));
		jMenuArqImportarMTrader.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnMTrader16.png"));
		jMenuArqRestaurar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnRestaurar16.png"));
		jMenuArqSair.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnSair16.png"));
		
		// Selecionado...
		jMenuPrjNovo.setSelected(false);
		jMenuArqAbrir.setSelected(false);
		jMenuArqSalvar.setSelected(false);
		jMenuArqSalvarAs.setSelected(false);
		
		// Botoes(este salvar esta com formato *.jxt(arq.ini)
		jMenuArqSalvar.setEnabled(true);
		jMenuArqSalvarAs.setEnabled(true);
		
		jMenuArqExportar.setSelected(false);
		jMenuArqImportar.setSelected(false);
		jMenuArqImportarMTrader.setSelected(false);
		jMenuArqRestaurar.setSelected(false);
		jMenuArqSair.setSelected(false);
	
		// Cursor hand...
		jMenuPrjNovo.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuArqAbrir.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuArqSalvar.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuArqSalvarAs.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuArqExportar.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuArqRestaurar.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuArqImportarMTrader.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuArqSair.setCursor(new Cursor(Cursor.HAND_CURSOR));
			
		//-------------------------------------------------------------
		// Ouvir eventos
		jMenuPrjNovo.addActionListener(new java.awt.event.ActionListener() {
         public void actionPerformed(java.awt.event.ActionEvent evt) {
        	 									// Acionamento de botão tipo: Click(menu local)
             jMenuPrjNovoActionPerformed(evt);	// Acionamento de botão tipo: Click
         }
		});
		jMenuArqAbrir.addActionListener(new java.awt.event.ActionListener() {
         public void actionPerformed(java.awt.event.ActionEvent evt) {             
        	 										// Acionamento de botão tipo: Click(menu local)
             BtnPrjAbrirActionPerformed(evt); 		// Acionamento de botão tipo: Click 
         }
         
		});
		jMenuArqSalvar.addActionListener(new java.awt.event.ActionListener() {
         public void actionPerformed(java.awt.event.ActionEvent evt) {
        	 										// Acionamento de botão tipo: Click(menu local)
        	 jMenuArqSalvarActionPerformed(evt);	// Acionamento de botão tipo: Click
         }
		});
		jMenuArqSalvarAs.addActionListener(new java.awt.event.ActionListener() {
         public void actionPerformed(java.awt.event.ActionEvent evt) {
        	 										// Acionamento de botão tipo: Click(menu local)
        	 jMenuArqSalvarAsActionPerformed(evt);	// Acionamento de botão tipo: Click
         }
		});
		
		jMenuArqExportar.addActionListener(new java.awt.event.ActionListener() {
         public void actionPerformed(java.awt.event.ActionEvent evt) {
             //jMenuArqExportarActionPerformed(evt);	// Acionamento de botão tipo: Click(menu local)
             BtnExportarActionPerformed(evt); 			// Acionamento de botão tipo: Click
         }
		});
		jMenuArqImportar.addActionListener(new java.awt.event.ActionListener() {
         public void actionPerformed(java.awt.event.ActionEvent evt) {
             //jMenuArqImportarActionPerformed(evt);	// Acionamento de botão tipo: Click(menu local)
             BtnImportarActionPerformed(evt);			// Acionamento de botão tipo: Click
         }
		});
		jMenuArqImportarMTrader.addActionListener(new java.awt.event.ActionListener() {
	         public void actionPerformed(java.awt.event.ActionEvent evt) {
	        	 jMenuArqImportarMTraderActionPerformed(evt);	// Acionamento de botão tipo: Click(menu local)
	         }
			});
		jMenuArqRestaurar.addActionListener(new java.awt.event.ActionListener() {
         public void actionPerformed(java.awt.event.ActionEvent evt) {
             // jMenuArqRestaurarActionPerformed(evt);	// Acionamento de botão tipo: Click(menu local)
        	 BtnRestaurarActionPerformed(evt);			// Acionamento de botão tipo: Click(botao menu)
         }
		});
		jMenuArqSair.addActionListener(new java.awt.event.ActionListener() {
	            public void actionPerformed(java.awt.event.ActionEvent evt) {
	                jMenuArqSairActionPerformed(evt);		// Acionamento de botão tipo: Click(menu local)
	            }
	    });
}
/******************************************************************************/
// Executa eventos do Menu->Projeto
private void jMenuPrjNovoActionPerformed(java.awt.event.ActionEvent evt) {
	
	// ptreuk - Pmt101ac
	this.CriarNovoProjeto();
	
}

// Evento dos Menus
 private void jMenuArqAbrirActionPerformed(java.awt.event.ActionEvent evt) {

	 // Menu Projeto->Abrir
	 objLog.Metodo("jxTMain().jMenuArqAbrirActionPerformed()");
	 
	 
					
		 //objArquivo.LerJxtIni(Planilha, objDef.PeguePlanCorrente(), objLicenca.pegueLicenca());
		 String vtParamRelAcao[] = new String[50];
	 		
	 	try{
	 		//objArquivo.LerMtaIni(Planilha, null);			 
			 objLog.Metodo("Planilha em uso: "+ objArquivo.PegueAbreDirArq());
			 
			 vtParamRelAcao = objArquivo.LerJxtIni(Planilha, null,objLicenca.pegueLicenca());

			 FmtVetorToCampos(vtParamRelAcao);	// Pega valores de vetor e preenche campos nas BF-Param, Rel e Acao
						
			
		 			
	 	}catch(IOException e){
			objLog.Metodo("jxTMain().LerJXT().IniFiles(Erro ao gravar Arquivo)");
	 	}finally{
			// objCxD.Aviso("Arquivo *.jxt carregado !", objDef.bMsgAbrir);
	 	}
		
 }

 
 private void jMenuArqSalvarActionPerformed(java.awt.event.ActionEvent evt) {
	// Menu Projeto->Salvar
	 objLog.Metodo("jxTMain().jMenuArqSalvarActionPerformed(1)");

	
	//public void Salvar(){
	new Thread() {
			     
	   @Override
	    public void run() {
			 	
		   	tfBarraStatus.setText("Preparando dados para salvar...");
		   
			 int iTReg = objUtil.ContarReg(Planilha);	// Conta numero de registros na tabela
				int iComboNumRegAnalisados = Integer.parseInt(cbNRegistro.getSelectedItem().toString());
				objDef.fixeComboNumRegistro(iComboNumRegAnalisados);	
	
				
				
				if( iTReg > 0){							// Verifica NumReg
					try{	 
						objArquivo.SalvarJxtIni(Planilha,  objArquivo.PegueAbreDirArq(), iComboNumRegAnalisados, iTReg, FmtCamposToVetor(), objLicenca.pegueLicenca());	// Salva dados
						FrmPrincipal.setTitle("jxtTrader - " + objArquivo.PegueAbreDirArq());
					}catch(IOException e){
						objLog.Metodo("jxTMain().salvarJXT().IniFiles(Erro ao gravar Arquivo)");
					}finally{
						//new CxDialogo().Aviso("Arquivo *.jxt Salvo !");
					}
				}else{
					objCxD.Aviso("Não há registros a serem salvos.", objDef.bMsgErro);
				}
				
				tfBarraStatus.setText("Dados Salvos...");
	
				
			}	// Run...
 	  }.start();	// start thread
			 
	
 }
 
 private void jMenuArqSalvarAsActionPerformed(java.awt.event.ActionEvent evt) {
	// Menu Projeto->Salvar como	 
	 
	 objLog.Metodo("jxTMain().jMenuArqSalvarActionPerformed(2)");
	 
	 // Usei uma Thread pois o salvar ta demorando
	 
	//public void Salvar(){
		new Thread() {
				     
		   @Override
		    public void run() {
				 	
			   	tfBarraStatus.setText("Preparando dados para salvar...");
			   
 
				 int iTReg = objUtil.ContarReg(Planilha);	// Conta numero de registros na tabela
					int iComboNumRegAnalisados = Integer.parseInt(cbNRegistro.getSelectedItem().toString());
						
					if( iTReg > 0){							// Verifica NumReg
						try{	 
							// Manda null no lugar do DirArq, assim um Dialog ser abaerto para definr Dir
							objArquivo.SalvarJxtIni(Planilha, objDef.sSalvarAs, iComboNumRegAnalisados, iTReg, FmtCamposToVetor(), objLicenca.pegueLicenca());	// Salva dados
							
							FrmPrincipal.setTitle("jxtTrader - " + objArquivo.PegueAbreDirArq());
						}catch(IOException e){
							objLog.Metodo("jxTMain().salvarJXT().IniFiles(Erro ao gravar Arquivo)");
						}finally{
							tfBarraStatus.setText("Dados Salvos...");
							//new CxDialogo().Aviso("Arquivo *.jxt Salvo !");
						}
					}else{
						objCxD.Aviso("Não há registros a serem salvos.", objDef.bMsgErro);
					}
       
		   }
		}.start();
	  
		
 }

 private void jMenuArqExportarActionPerformed(java.awt.event.ActionEvent evt) {
	// Menu Projeto->Exportar para Excel(csv)    
	 
	 
	 
 }

 private void jMenuArqImportarActionPerformed(java.awt.event.ActionEvent evt) {
		// Menu Projeto->Importar do Excel
		 objLog.Metodo("jxTMain().jMenuArqImportarActionPerformed()");

			
			try {					
				// Carrega arquivo(*.csv)
				objArquivo.CarregarCSV(Planilha,  objArquivo.PegueAbreDirArq(), objLicenca.pegueLicenca());	// Tipo *.csv
				//objCxD.Aviso("Arquivo importado !", objDef.bMsgAbrir);		
				
			} catch (IOException ex) {  
				objLog.Metodo("jxTMain().BtnImportar().Erro ao carregar arquivo(IOException).");
				objCxD.Aviso("Erro! Arquivo inválido(IOException e1001a)", objDef.bMsgErro);
			}finally{
				objDef.fixeNumRegMetaTrader( objUtil.ContarReg(Planilha) );
				objLog.Metodo("objDef.pegueNumRegMetaTrader("+ String.valueOf(objDef.pegueNumRegMetaTrader()) +")");
			
			}
			 
		 
	 }
 private void jMenuArqImportarMTraderActionPerformed(java.awt.event.ActionEvent evt) {
	// Menu Projeto->Importar do M.trader
	 objLog.Metodo("jxTMain(Loc1004a).jMenuArqImportarActionPerformed()");

		try {		
			// Carrega arquivo(download cotação) metaTrader.txt
			objArquivo.FixeAbreDirArq( objArquivo.CarregarMetaT5(Planilha, null, objLicenca.pegueLicenca()) );
					
		} catch (IOException ex) {  
			objLog.Metodo("jxTMain().BtnImportar().Erro ao carregar arquivo(IOException).");
			objCxD.Aviso("Erro! Arquivo inválido(IOException e1001b)", objDef.bMsgErro);
		}finally{
			objDef.fixeNumRegMetaTrader( objUtil.ContarReg(Planilha) );
			objLog.Metodo("objDef.pegueNumRegMetaTrader("+ String.valueOf(objDef.pegueNumRegMetaTrader()) +")");
			
			FrmPrincipal.setTitle("jxtTrader - " + objArquivo.PegueAbreDirArq());
			//objCxD.Aviso("Arquivo importado !", objDef.bMsgAbrir);		
			objLog.Metodo("jxTMain(Loc1004a).jMenuArqImportarMTraderActionPerformed(): " + objArquivo.PegueAbreDirArq() );
	
		}
		 
	 
 }

 private void jMenuArqRestaurarActionPerformed(java.awt.event.ActionEvent evt) {
	// Menu Projeto->Restaurar backup(*.jxt) 
 }

 private void jMenuArqSairActionPerformed(java.awt.event.ActionEvent evt) {
	// Menu Projeto->Sair
	/*	
	 try{			
			objArquivo.SalvarConfig();			
		}catch(IOException e){
			objLog.Metodo("jxTMain().salvarMTA().IniFiles(Erro ao gravar Arquivo)");
		}finally{
			// objCxD.Aviso("Arquivo *.jxt carregado !", objDef.bMsgAbrir);
		}
	*/	
	  System.exit(0);       
 }

 
 /********************************************************************************************************************/
 public void ConstruirSubMenuSys(){
		// Constroe Menu->Sistema[Iniciar, Pausar,...]
		
		objLog.Metodo("jxTMain().ConstruirSubMenuSys()");
		
		// Menu
		JMenuBar BarraMenuSys = new JMenuBar();		
			AddPainel(BarraMenuSys, objDef.bfMenuSysCol, objDef.bfMenuLin, objDef.iMenuSysLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
			
			JMenu jMenuSys = new JMenu();		
			jMenuSys.setText("Sistema");
			jMenuSys.setCursor(new Cursor(Cursor.HAND_CURSOR));
			BarraMenuSys.add(jMenuSys);			
		
			//-------------------------------------------------------------
			// Item de Menu: Sys	
			JMenuItem jMenuSysIniciar = new JMenuItem();
			Separator jMenuSysSepara1 = new Separator();
			JMenuItem jMenuSysLimparTst = new JMenuItem();
			JMenuItem jMenuSysPausar = new JMenuItem();	
			JMenuItem jMenuSysParar = new JMenuItem();	
			
			jMenuSysIniciar.setText("Iniciar");
			jMenuSysPausar.setText("Pausar");
			jMenuSysLimparTst.setText("Reiniciar");
			jMenuSysParar.setText("Parar");
			
			jMenuSys.add(jMenuSysIniciar);		// Iniciar
			jMenuSys.add(jMenuSysSepara1);		// Separador			
			jMenuSys.add(jMenuSysPausar);		// pausar
			jMenuSys.add(jMenuSysLimparTst);	// LimparTst
			jMenuSys.add(jMenuSysParar);		// parar
			
			// Icones			
			jMenuSysIniciar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnEngrenagem16.png"));
			jMenuSysPausar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnPausa16.png"));
			jMenuSysLimparTst.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnDesfazer16.png"));
			jMenuSysParar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnParar16.png"));
			
			// Selecionado...
			jMenuSysIniciar.setSelected(false);
			jMenuSysPausar.setSelected(false);
			jMenuSysLimparTst.setSelected(true);
			jMenuSysParar.setSelected(false);
			
			// Cursor hand
			jMenuSysIniciar.setCursor(new Cursor(Cursor.HAND_CURSOR));
			jMenuSysPausar.setCursor(new Cursor(Cursor.HAND_CURSOR));
			jMenuSysLimparTst.setCursor(new Cursor(Cursor.HAND_CURSOR));
			jMenuSysParar.setCursor(new Cursor(Cursor.HAND_CURSOR));

			//-------------------------------------------------------------
					// Ouvir eventos
			jMenuSysIniciar.addActionListener(new java.awt.event.ActionListener() {
			       public void actionPerformed(java.awt.event.ActionEvent evt) {
			        	 jMenuSysIniciarActionPerformed(evt);
			        }
			});
			jMenuSysPausar.addActionListener(new java.awt.event.ActionListener() {
			       public void actionPerformed(java.awt.event.ActionEvent evt) {
			        	 jMenuSysPausarActionPerformed(evt);
			        }
			});
			jMenuSysLimparTst.addActionListener(new java.awt.event.ActionListener() {
			       public void actionPerformed(java.awt.event.ActionEvent evt) {
			        	 jMenuSysLimparTstActionPerformed(evt);
			        }
			});
			jMenuSysParar.addActionListener(new java.awt.event.ActionListener() {
			       public void actionPerformed(java.awt.event.ActionEvent evt) {
			        	 jMenuSysPararActionPerformed(evt);
			        }
			});
			
	}
	/********************************************************************************************************************/
	// Executar eventos ouvidos no menu Sys
	private void jMenuSysIniciarActionPerformed(java.awt.event.ActionEvent evt) {
		//AtivarTestes();
	}

	private void jMenuSysPausarActionPerformed(java.awt.event.ActionEvent evt) {
		if(objDef.PegueTstStatus() == objDef.tstATIVO){
			
			//Pausar();
			
		}
	}
	
	/* Menu Sistema -> Sub-Menu: LimparTst */
	private void jMenuSysLimparTstActionPerformed(java.awt.event.ActionEvent evt) {
	
			
			if(objCxD.Confirme("Todos os registros de teste serão excluídos. Deseja continuar?", objDef.bMsgExcluir) )
			{
				/*
				 * Podia-se usar a rotina: LimparPlanilha(PegueLinAtual())
				 * Mas...PegueLinAtual() ainda não foi calculado neste ponto do programa...
				 * então é mais fácil limpar toda a Plan(1000)
				 */
				LimparPlanilha(1000);
				FixeSeqEmTeste(0);	
				FixeTimeProcesso(0);
				FixeSeg(0);
				FixeMin(0);
				FixeHora(0);
				FixeLinAtual(0);
				
			}						
		
	}
	
	private void jMenuSysPararActionPerformed(java.awt.event.ActionEvent evt) {
		Parar();
	}

/********************************************************************************************************************/
public void ConstruirSubMenuFer(){
 	// Constroe Menu->Ferramentas[Navegador, SLine, Log, ...]
	
	objLog.Metodo("jxTMain().ConstruirSubMenuFer()");
 	
 	JMenuBar BarraMenuFer = new JMenuBar();		
		AddPainel(BarraMenuFer, objDef.bfMenuFerCol, objDef.bfMenuLin, objDef.iMenuFerLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
		
		JMenu jMenuFer = new JMenu();
		
		BarraMenuFer.add(jMenuFer);
		
		jMenuFer.setText("Ferramentas");
		jMenuFer.setCursor(new Cursor(Cursor.HAND_CURSOR));
		
	
		//-------------------------------------------------------------
		// Item de Menu: Feruivo		
		JMenuItem jMenuFerNavegador = new JMenuItem();
		JMenuItem jMenuFerSLine = new JMenuItem();
		JMenuItem jMenuFerLog = new JMenuItem();
		JMenuItem jMenuFerTelnet = new JMenuItem();
		Separator jMenuFerSepara1 = new Separator();
		JMenuItem jMenuFerCoord = new JMenuItem();
		JMenuItem jMenuFerFiltro = new JMenuItem();
		JMenuItem jMenuFerLapis = new JMenuItem();
		
		jMenuFer.add(jMenuFerNavegador);
		jMenuFer.add(jMenuFerSLine);
		jMenuFer.add(jMenuFerLog);
		jMenuFer.add(jMenuFerTelnet);
		jMenuFer.add(jMenuFerSepara1);
		jMenuFer.add(jMenuFerCoord);
		jMenuFer.add(jMenuFerFiltro);
		jMenuFer.add(jMenuFerLapis);
				
				
		jMenuFerNavegador.setText("Navegador");
		jMenuFerSLine.setText("SLine");
		jMenuFerLog.setText("Log");
		jMenuFerTelnet.setText("Modem");
		jMenuFerCoord.setText("Coord");
		jMenuFerFiltro.setText("Filtro");
		jMenuFerLapis.setText("Lapis");
		
		
		// Icones
		jMenuFerNavegador.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnWebDn16.png"));
		jMenuFerSLine.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnLedSinc16.png"));
		jMenuFerLog.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnLog16.png"));
		jMenuFerTelnet.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnLog16.png"));
		jMenuFerCoord.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnMapaChar16.png"));
		jMenuFerFiltro.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnFiltro16.png"));
		jMenuFerLapis.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/Btnlapis16.png"));

		
		// Selecionado...
		jMenuFerNavegador.setSelected(false);
		jMenuFerSLine.setSelected(false);
		jMenuFerLog.setSelected(false);
		jMenuFerTelnet.setSelected(false);
		jMenuFerCoord.setSelected(false);
		jMenuFerFiltro.setSelected(false);
		jMenuFerLapis.setSelected(false);

		// Enable/disable
		jMenuFerNavegador.setEnabled(false);
		jMenuFerSLine.setEnabled(false);
		jMenuFerLog.setEnabled(false);
		jMenuFerCoord.setEnabled(false);

		// Cursor hand
		jMenuFerNavegador.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuFerSLine.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuFerLog.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuFerTelnet.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuFerCoord.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuFerFiltro.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuFerLapis.setCursor(new Cursor(Cursor.HAND_CURSOR));
		
		//-------------------------------------------------------------
		// Ouvir eventos
		jMenuFerNavegador.addActionListener(new java.awt.event.ActionListener() {
         public void actionPerformed(java.awt.event.ActionEvent evt) {
             jMenuFerNavegadorActionPerformed(evt);
         }
		});
		jMenuFerSLine.addActionListener(new java.awt.event.ActionListener() {
         public void actionPerformed(java.awt.event.ActionEvent evt) {
             jMenuFerSLineActionPerformed(evt);
         }
		});
		jMenuFerLog.addActionListener(new java.awt.event.ActionListener() {
         public void actionPerformed(java.awt.event.ActionEvent evt) {
             jMenuFerLogActionPerformed(evt);
         }
		});
		jMenuFerTelnet.addActionListener(new java.awt.event.ActionListener() {
         public void actionPerformed(java.awt.event.ActionEvent evt) {
             jMenuFerTelnetActionPerformed(evt);
         }
		});
		
		jMenuFerCoord.addActionListener(new java.awt.event.ActionListener() {
         public void actionPerformed(java.awt.event.ActionEvent evt) {
             jMenuFerCoordActionPerformed(evt);
         }
		});
		jMenuFerFiltro.addActionListener(new java.awt.event.ActionListener() {
         public void actionPerformed(java.awt.event.ActionEvent evt) {
             jMenuFerFiltroActionPerformed(evt);
         }
		});
		jMenuFerLapis.addActionListener(new java.awt.event.ActionListener() {
         public void actionPerformed(java.awt.event.ActionEvent evt) {
             jMenuFerLapisActionPerformed(evt);
         }
		});
		
}

/*******************************************************************************/
//Executa Evento do Menu->Ferramentas
private void jMenuFerSLineActionPerformed(java.awt.event.ActionEvent evt) {
 
}
private void jMenuFerNavegadorActionPerformed(java.awt.event.ActionEvent evt) {
        
}
private void jMenuFerLogActionPerformed(java.awt.event.ActionEvent evt) {
      
}
private void jMenuFerTelnetActionPerformed(java.awt.event.ActionEvent evt) {
	// SubMenu -> Modem
     VerSincronismo();	// Faz um teste no modem   
}
private void jMenuFerCoordActionPerformed(java.awt.event.ActionEvent evt) {
	//ExibirOcultar(objDef.PARAMETRO);
}
private void jMenuFerLapisActionPerformed(java.awt.event.ActionEvent evt) {
	//ExibirOcultar(objDef.LAPIS);
}
private void jMenuFerFiltroActionPerformed(java.awt.event.ActionEvent evt) {
	//ExibirOcultar(objDef.FILTRO);  
}


/********************************************************************************************************************/

public void ConstruirSubMenuOpc(){
	// Constroe Menu->Opções[Barra fer., Grupo...]
	
	objLog.Metodo("jxTMain().ConstruirSubMenuOpc()");
	
	// Menu
	JMenuBar BarraMenuOpc = new JMenuBar();		
		AddPainel(BarraMenuOpc, objDef.bfMenuOpcCol, objDef.bfMenuLin, objDef.iMenuOpcLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
		
		JMenu jMenuOpc = new JMenu();		
		jMenuOpc.setText("Opções");
		jMenuOpc.setCursor(new Cursor(Cursor.HAND_CURSOR));
		BarraMenuOpc.add(jMenuOpc);			
	
		//-------------------------------------------------------------
		// Item de Menu: Opção	
		JMenu jMenuOpcBarFer = new JMenu();
		JMenu jMenuOpcGrpBtn = new JMenu();		
		Separator jMenuOpcSepara1 = new Separator();
		JMenuItem jMenuOpcOpcao = new JMenuItem();
		
		jMenuOpcBarFer.setText("Barra de ferramentas");
		jMenuOpcGrpBtn.setText("Grupo de botões");
		jMenuOpcOpcao.setText("Opções");
		
		jMenuOpcBarFer.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuOpcGrpBtn.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuOpcOpcao.setCursor(new Cursor(Cursor.HAND_CURSOR));
		
		jMenuOpc.add(jMenuOpcBarFer);
		jMenuOpc.add(jMenuOpcGrpBtn);
		jMenuOpc.add(jMenuOpcSepara1);
		jMenuOpc.add(jMenuOpcOpcao);

		// Enable/disable
		jMenuOpcBarFer.setEnabled(false);
		jMenuOpcGrpBtn.setEnabled(false);
		jMenuOpcOpcao.setEnabled(false);

		//-------------------------------------------------------------
		// Barra ferramentas >
		JMenuItem jMenuOpcBarFerBtn = new JMenuItem();
		JMenuItem jMenuOpcBarFerCoord = new JMenuItem();
		JMenuItem jMenuOpcBarFerFiltro = new JMenuItem();
		JMenuItem jMenuOpcBarFerLapis = new JMenuItem();
		
		jMenuOpcBarFerBtn.setText("Botões");
		jMenuOpcBarFerCoord.setText("Coordenadas");
		jMenuOpcBarFerFiltro.setText("Filtros");
		jMenuOpcBarFerLapis.setText("Lápis");
		
		jMenuOpcBarFer.add(jMenuOpcBarFerBtn);
		jMenuOpcBarFer.add(jMenuOpcBarFerCoord);
		jMenuOpcBarFer.add(jMenuOpcBarFerFiltro);
		jMenuOpcBarFer.add(jMenuOpcBarFerLapis);
		
		// Cursor hand
		jMenuOpcBarFerBtn.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuOpcBarFerCoord.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuOpcBarFerFiltro.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuOpcBarFerLapis.setCursor(new Cursor(Cursor.HAND_CURSOR));
		

}


public void ConstruirSubMenuInfo(){
	// Constroe Menu->Info[Ajuda, Sobre]
	
	objLog.Metodo("jxTMain().ConstruirSubMenuInfo()");
	
	// Menu
	JMenuBar BarraMenuInfo = new JMenuBar();		
		AddPainel(BarraMenuInfo, objDef.bfMenuInfoCol, objDef.bfMenuLin, objDef.iMenuInfoLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
		
		JMenu jMenuInfo = new JMenu();		
		jMenuInfo.setText("Info");
		jMenuInfo.setCursor(new Cursor(Cursor.HAND_CURSOR));
		BarraMenuInfo.add(jMenuInfo);			
	
		//-------------------------------------------------------------
		// Item de Menu: Info	
		JMenuItem jMenuInfoAjd = new JMenuItem();
		Separator jMenuInfoSepara1 = new Separator();
		JMenuItem jMenuInfoSbr = new JMenuItem();	
		
		
		jMenuInfoAjd.setText("Info");
		jMenuInfoSbr.setText("Sobre");
		
		
		jMenuInfo.add(jMenuInfoAjd);		// Ajuda
		jMenuInfo.add(jMenuInfoSepara1);	// Separador
		jMenuInfo.add(jMenuInfoSbr);		// Sobre
		
		// Icones
		jMenuInfoAjd.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnNavegador16.png"));
		jMenuInfoSbr.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnSLine16.png"));
		
		
		// Selecionado...
		jMenuInfoAjd.setSelected(false);
		jMenuInfoSbr.setSelected(false);
		
		// Cursor hand
		jMenuInfoAjd.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuInfoSbr.setCursor(new Cursor(Cursor.HAND_CURSOR));
		
		// Enable/disable
		jMenuInfoAjd.setEnabled(true);
		jMenuInfoSbr.setEnabled(true);
				
		//-------------------------------------------------------------
				// Ouvir eventos
		jMenuInfoAjd.addActionListener(new java.awt.event.ActionListener() {
		       public void actionPerformed(java.awt.event.ActionEvent evt) {
		        	 jMenuInfoAjdActionPerformed(evt);
		        }
		});
		jMenuInfoSbr.addActionListener(new java.awt.event.ActionListener() {
		       public void actionPerformed(java.awt.event.ActionEvent evt) {
		        	 jMenuInfoSbrActionPerformed(evt);
		        }
		});
		
}
/********************************************************************************************************************/
// Executar eventos ouvidos no menu Info
private void jMenuInfoAjdActionPerformed(java.awt.event.ActionEvent evt) {
	objFrmInfo.Construir(); 	// Construir Form.Sobre 
}

private void jMenuInfoSbrActionPerformed(java.awt.event.ActionEvent evt) {
	objFrmSobre.Construir(); 	// Construir Form.Sobre 
}

/********************************************************************************************************************/
/*
 *  Construir Barra de ferramentas...
 */
public void ConstruirBfProjeto(){
// Constroe barra de Fer. Projeto[Novo, Abrir...]	 
	 objLog.Metodo("jxTMain().ConstruirBfProjeto()");
	 // Criar a barra 
	 JToolBar BarFerProjeto = new JToolBar();
	 
	 AddPainel(BarFerProjeto,objDef.bfBtnPrjPosCol, objDef.bfBtnPosLin, objDef.bfBtnPrjLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
	 BarFerProjeto.setFloatable(false);	 
	 BarFerProjeto.setRollover(true);
	 
	 JSeparator SeparaBarFerProjeto = new JSeparator();
	 SeparaBarFerProjeto.setOrientation(SwingConstants.VERTICAL);
	 BarFerProjeto.add(SeparaBarFerProjeto);
	
	 
	 // Adicionar botões a barra
	 BarFerProjeto.add(BtnPrjNovo);
	 BarFerProjeto.add(BtnPrjAbrir);
	 BarFerProjeto.add(BtnPrjSalvar);
	 BarFerProjeto.add(BtnPrjSalvarAs);
	 
	 // Inserir icones nos botões
	 BtnPrjNovo.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnTabela16.png"));
	 BtnPrjNovo.setToolTipText("Novo projeto");		// Insere Title no botão
	 BtnPrjNovo.setHideActionText(true);
	 BtnPrjNovo.setCursor(new Cursor(Cursor.HAND_CURSOR));
	
	 BtnPrjAbrir.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnAbrirDoc16.png"));
	 BtnPrjAbrir.setToolTipText("Abrir projeto(*.jxt)");
	 BtnPrjAbrir.setHideActionText(true);
	 BtnPrjAbrir.setCursor(new Cursor(Cursor.HAND_CURSOR));
	 
	 BtnPrjSalvar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnSalvar16.png"));
	 BtnPrjSalvar.setToolTipText("Salvar projeto(*.jxt)");
	 BtnPrjSalvar.setHideActionText(true);
	 BtnPrjSalvar.setCursor(new Cursor(Cursor.HAND_CURSOR));
	 
	 BtnPrjSalvarAs.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnSalvarAs16.png"));
	 BtnPrjSalvarAs.setToolTipText("Salvar(As) projeto(*.jxt)");
	 BtnPrjSalvarAs.setHideActionText(true);
	 BtnPrjSalvarAs.setCursor(new Cursor(Cursor.HAND_CURSOR));
	 
	 BtnPrjSalvar.setEnabled(true);	// Bloqueia botão - formato salvar esta como *.jxt(arq.ini) - trava
	 
	 // Ouvir enventos
	 BtnPrjNovo.addActionListener(new java.awt.event.ActionListener() {
		 public void actionPerformed(java.awt.event.ActionEvent evt) {
			 BtnPrjNovoActionPerformed(evt);
		 }
	 });
	 BtnPrjAbrir.addActionListener(new java.awt.event.ActionListener() {
		 public void actionPerformed(java.awt.event.ActionEvent evt) {
			 BtnPrjAbrirActionPerformed(evt);
		 }
	 });
	 BtnPrjSalvar.addActionListener(new java.awt.event.ActionListener() {
		 public void actionPerformed(java.awt.event.ActionEvent evt) {
			 BtnPrjSalvarActionPerformed(evt);
		 }
	 });
	 BtnPrjSalvarAs.addActionListener(new java.awt.event.ActionListener() {
		 public void actionPerformed(java.awt.event.ActionEvent evt) {
			 BtnPrjSalvarAsActionPerformed(evt);
		 }
	 });
	 
}

private void BtnPrjNovoActionPerformed(java.awt.event.ActionEvent evt) {
    
	this.CriarNovoProjeto();
		 
}

private void BtnPrjAbrirActionPerformed(java.awt.event.ActionEvent evt) {
	
	objLog.Metodo("jxTMain().BtnPrjAbrirActionPerformed(Loc-Btn101)");
	String vtParamRelAcao[] = new String[50];
	
	try{		
		//objArquivo.LerMtaIni(Planilha, null);			 
		 objLog.Metodo("Planilha em uso: "+ objArquivo.PegueAbreDirArq());
		 
		 vtParamRelAcao = objArquivo.LerJxtIni(Planilha, null, objLicenca.pegueLicenca());

		 FmtVetorToCampos(vtParamRelAcao);	// Pega valores de vetor e preenche campos nas BF-Param, Rel e Acao
		 

			
	}catch(IOException e){
		objLog.Metodo("jxTMain().LerJxtIni().IniFiles(Erro ao gravar Arquivo)");
	}finally{
		// objCxD.Aviso("Arquivo *.jxt carregado !", objDef.bMsgAbrir);
		FrmPrincipal.setTitle("jxTrader - " + objArquivo.PegueAbreDirArq());
		 objLog.Metodo("Nova Planilha aberta: "+ objArquivo.PegueAbreDirArq());
	}
	
	
}

private void BtnPrjSalvarActionPerformed(java.awt.event.ActionEvent evt) {	
	
	objLog.Metodo("jxTMain().BtnPrjSalvarActionPerformed(Btn3a)");
	
	//public void Salvar(){
	new Thread() {
			     
	   @Override
	    public void run() {
			 	
		   	tfBarraStatus.setText("Preparando dados para salvar...");
		   
			 int iTReg = objUtil.ContarReg(Planilha);	// Conta numero de registros na tabela
				int iComboNumRegAnalisados = Integer.parseInt(cbNRegistro.getSelectedItem().toString());
					
				if( iTReg > 0){							// Verifica NumReg
					try{	 
						objArquivo.SalvarJxtIni(Planilha,  objArquivo.PegueAbreDirArq(), iComboNumRegAnalisados, iTReg, FmtCamposToVetor(), objLicenca.pegueLicenca());	// Salva dados
						FrmPrincipal.setTitle("jxtTrader - " + objArquivo.PegueAbreDirArq());
					}catch(IOException e){
						objLog.Metodo("jxTMain().salvarJXT().IniFiles(Erro ao gravar Arquivo)");
					}finally{
						//new CxDialogo().Aviso("Arquivo *.jxt Salvo !");
					}
				}else{
					objCxD.Aviso("Não há registros a serem salvos.", objDef.bMsgErro);
				}
				
				tfBarraStatus.setText("Dados Salvos...");
			       
			}	// Run...
 	  }.start();	// start thread
	
}

private void BtnPrjSalvarAsActionPerformed(java.awt.event.ActionEvent evt) {	
	
	objLog.Metodo("jxTMain().BtnPrjSalvarActionPerformed(Btn3b)");
	//public void Salvar(){
	new Thread() {
			     
	   @Override
	    public void run() {
			 	
		   	tfBarraStatus.setText("Preparando dados para salvar...");
		   
			 int iTReg = objUtil.ContarReg(Planilha);	// Conta numero de registros na tabela
				int iComboNumRegAnalisados = Integer.parseInt(cbNRegistro.getSelectedItem().toString());
					
				if( iTReg > 0){							// Verifica NumReg
					try{	 
						objArquivo.SalvarJxtIni(Planilha, objDef.sSalvarAs, iComboNumRegAnalisados, iTReg, FmtCamposToVetor(), objLicenca.pegueLicenca());	// Salva dados
						FrmPrincipal.setTitle("jxtTrader - " + objArquivo.PegueAbreDirArq());
					}catch(IOException e){
						objLog.Metodo("jxTMain().salvarJXT().IniFiles(Erro ao gravar Arquivo)");
					}finally{
						//new CxDialogo().Aviso("Arquivo *.jxt Salvo !");
					}
				}else{
					objCxD.Aviso("Não há registros a serem salvos.", objDef.bMsgErro);
				}
				
				tfBarraStatus.setText("Dados Salvos...");
			       
			}	// Run...
 	  }.start();	// start thread
	

	
}

/********************************************************************************************************************/
public void ConstruirBfExcel(){
	 
	 objLog.Metodo("jxTMain().ConstruirBfExcel()");
	 // Criar a barra 
	 JToolBar BarFerExcel = new JToolBar();	
	 
	 AddPainel(BarFerExcel,objDef.bfBtnExcelPosCol, objDef.bfBtnPosLin, objDef.bfBtnExcelLarg,objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
	 BarFerExcel.setFloatable(false);
	 BarFerExcel.setRollover(true);
	 
	 JSeparator SeparaBarFerExcel = new JSeparator();
	 SeparaBarFerExcel.setOrientation(SwingConstants.VERTICAL);
	 BarFerExcel.add(SeparaBarFerExcel);
	 

	 
	 // Adicionar botões a barra
	 BarFerExcel.add(BtnExportar);
	 BarFerExcel.add(BtnImportar);
	 BarFerExcel.add(BtnImportarMTrader);
	 BarFerExcel.add(BtnRestaurar);
	 
		 
	 // Inserir icones nos botões
	 BtnExportar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnExpExcel16.png"));
	 BtnExportar.setToolTipText("Exportar para Excel(*.csv)");
	 BtnExportar.setHideActionText(true);
	 BtnExportar.setCursor(new Cursor(Cursor.HAND_CURSOR));

	 BtnImportar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnAbrirExcel16.png"));
	 BtnImportar.setToolTipText("Importar do Excel(*.csv)");
	 BtnImportar.setHideActionText(true);
	 BtnImportar.setCursor(new Cursor(Cursor.HAND_CURSOR));

	 BtnImportarMTrader.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnMtrader16.png"));
	 BtnImportarMTrader.setToolTipText("Importar cotação(MTrader)");
	 BtnImportarMTrader.setHideActionText(true);
	 BtnImportarMTrader.setCursor(new Cursor(Cursor.HAND_CURSOR));

	 BtnRestaurar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnRestaurar16.png"));
	 BtnRestaurar.setToolTipText("Restaurar backup(*.jxt)");
	 BtnRestaurar.setHideActionText(true);
	 BtnRestaurar.setCursor(new Cursor(Cursor.HAND_CURSOR));
	 BtnRestaurar.setEnabled(false);// Bloaqueado temporariamente
	 
	 
	 // Ouvir enventos
	 BtnExportar.addActionListener(new java.awt.event.ActionListener() {
		 public void actionPerformed(java.awt.event.ActionEvent evt) {
			 BtnExportarActionPerformed(evt);	// Acionamento de botão tipo: Click
		 }
	 });
	 BtnImportar.addActionListener(new java.awt.event.ActionListener() {
	        public void actionPerformed(java.awt.event.ActionEvent evt) {
	        	BtnImportarActionPerformed(evt);	// Acionamento de botão tipo: Click
	        }
	 });
	 BtnImportarMTrader.addActionListener(new java.awt.event.ActionListener() {
	        public void actionPerformed(java.awt.event.ActionEvent evt) {
	        	BtnImportarMTraderActionPerformed(evt);	// Acionamento de botão tipo: Click
	        }
	 });
	 BtnRestaurar.addActionListener(new java.awt.event.ActionListener() {
	        public void actionPerformed(java.awt.event.ActionEvent evt) {
	        	BtnRestaurarActionPerformed(evt);	// Acionamento de botão tipo: Click
	        }
	  });
}

//Executar Eventos dos Botões - Excel(Exportar, importar, restaurar)
private void BtnExportarActionPerformed(java.awt.event.ActionEvent evt) {
	//CriarCSV();
//	objCxD.Aviso("Planilha exportada !",true);
	objArquivo.SalvarCsv(Planilha, objLicenca.pegueLicenca());		// Formata, e Salva
	
}

private void BtnImportarActionPerformed(java.awt.event.ActionEvent evt) {
	
	/*
	 *  Devido ao: throws BiffException, IOException da Classe, exigido pela classe WokBook
	 *  Foi necessário usar tratamento de exceção: try, catch
	 */
	 
	objLog.Metodo("jxTMain().BtnImportarActionPerformed("+ String.valueOf(objDef.pegueNumRegMetaTrader()) +")");

	//objArquivo.PegueAbreDirArq()
	
	try {		
		// Carrega arquivo(*.csv)
		objArquivo.CarregarCSV(Planilha,  objArquivo.PegueAbreDirArq(), objLicenca.pegueLicenca());
		//objCxD.Aviso("Arquivo importado !", objDef.bMsgAbrir);		
		
	} catch (IOException ex) {  
		objLog.Metodo("jxTMain().BtnImportar().Erro ao carregar arquivo(IOException).");
		objCxD.Aviso("Erro! Arquivo inválido(IOException e1001c)", objDef.bMsgErro);
	}finally{
		objDef.fixeNumRegMetaTrader( objUtil.ContarReg(Planilha) );
		objLog.Metodo("objDef.pegueNumRegMetaTrader("+ String.valueOf(objDef.pegueNumRegMetaTrader()) +")");
	
	}
	

	
}

private void BtnImportarMTraderActionPerformed(java.awt.event.ActionEvent evt) {
	
	/*
	 *  Devido ao: throws BiffException, IOException da Classe, exigido pela classe WokBook
	 *  Foi necessário usar tratamento de exceção: try, catch
	 */
	 
	objLog.Metodo("jxTMain(Loc1003a).BtnImportarMTraderActionPerformed("+ String.valueOf(objDef.pegueNumRegMetaTrader()) +")");

	
	try {		
		// Carrega arquivo(*.meta-trader)	
		objArquivo.FixeAbreDirArq( objArquivo.CarregarMetaT5(Planilha, null, objLicenca.pegueLicenca()) );
		
	} catch (IOException ex) {  
		objLog.Metodo("jxTMain().BtnImportar().Erro ao carregar arquivo(IOException).");
		objCxD.Aviso("Erro! Arquivo inválido(IOException e1001d)", objDef.bMsgErro);
	}finally{
		objDef.fixeNumRegMetaTrader( objUtil.ContarReg(Planilha) );
		objLog.Metodo("objDef.pegueNumRegMetaTrader("+ String.valueOf(objDef.pegueNumRegMetaTrader()) +")");
		this.carregarCombosCV(objDef.bLimparCombos);
		
		
		FrmPrincipal.setTitle("jxtTrader - " + objArquivo.PegueAbreDirArq());
		objLog.Metodo("jxTMain(Loc1003a).BtnImportarMTraderActionPerformed(): " + objArquivo.PegueAbreDirArq() );

	}
	

	
}
private void BtnRestaurarActionPerformed(java.awt.event.ActionEvent evt) {
	
	String vtParamRelAcao[] = new String[50];
	
	try{
		
		//objArquivo.LerMtaIni(Planilha, null);			 
		 objLog.Metodo("Planilha em uso: "+ objArquivo.PegueAbreDirArq());
		 
		 vtParamRelAcao = objArquivo.LerJxtIni(Planilha, null,objLicenca.pegueLicenca());

		 FmtVetorToCampos(vtParamRelAcao);	// Pega valores de vetor e preenche campos nas BF-Param, Rel e Acao
				
				

	}catch(IOException e){
		objLog.Metodo("jxTMain().salvarMTA().IniFiles(Erro ao gravar Arquivo)");
	}finally{
		// objCxD.Aviso("Arquivo *.jxt carregado !", objDef.bMsgAbrir);
	}
}

/**********************************************************************************/
public void ConstruirBfSistema(){

	// Constroe Barra.Fer.Sistema[Iniciar, Pausar, parar,...]
	objLog.Metodo("jxTMain().ConstruirBfSistema()");
	 
	 // Criar a barra 
	 JToolBar BarFerSis = new JToolBar();
	 
	 AddPainel(BarFerSis,objDef.bfBtnSisPosCol,objDef.bfBtnPosLin,objDef.bfBtnSisLarg,objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
	 BarFerSis.setFloatable(false);	 
	 BarFerSis.setRollover(true);
	 
	 JSeparator SeparaBarFerSis = new JSeparator();
	 SeparaBarFerSis.setOrientation(SwingConstants.VERTICAL);
	 BarFerSis.add(SeparaBarFerSis);
	
	 
	 
	 // Criar botões
	 
	 BarFerSis.add(BtnPausar);
	 BarFerSis.add(BtnSaltar);
	 BarFerSis.add(BtnParar);
	 BarFerSis.add(BtnSair);
	 
	 BtnPausar.setEnabled(false); // Bloqueia Botões
	 BtnSaltar.setEnabled(true); // Bloqueia Botões
	 BtnParar.setEnabled(false); // Bloqueia Botões
	
	 BtnPausar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnPausa16.png"));
	 BtnPausar.setToolTipText("Pausar testes");
	 BtnPausar.setHideActionText(true);
	 BtnPausar.setCursor(new Cursor(Cursor.HAND_CURSOR));

	 BtnSaltar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnSaltar16.png"));
	 BtnSaltar.setToolTipText("Saltar");
	 BtnSaltar.setHideActionText(true);
	 BtnSaltar.setCursor(new Cursor(Cursor.HAND_CURSOR));

	 BtnParar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnParar16.png"));
	 BtnParar.setToolTipText("Parar testes");
	 BtnParar.setHideActionText(true);
	 BtnParar.setCursor(new Cursor(Cursor.HAND_CURSOR));

	 BtnParar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnParar16.png"));
	 BtnParar.setToolTipText("Parar testes");
	 BtnParar.setHideActionText(true);
	 BtnParar.setCursor(new Cursor(Cursor.HAND_CURSOR));

	 BtnSair.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnSair16.png"));
	 BtnSair.setToolTipText("Encerrar aplicação");
	 BtnSair.setHideActionText(true);
	 BtnSair.setCursor(new Cursor(Cursor.HAND_CURSOR));
	 
	 
	 // Ouvir enventos	
	 
	  
	 BtnPausar.addActionListener(new java.awt.event.ActionListener() {
      public void actionPerformed(java.awt.event.ActionEvent evt) {
          BtnPausarActionPerformed(evt);
      }
	 });
	 BtnSaltar.addActionListener(new java.awt.event.ActionListener() {
	      public void actionPerformed(java.awt.event.ActionEvent evt) {
	    	  BtnSaltarActionPerformed(evt);
	      }
		 });
	 BtnParar.addActionListener(new java.awt.event.ActionListener() {
      public void actionPerformed(java.awt.event.ActionEvent evt) {
          BtnPararActionPerformed(evt);
      }
	 });
	 BtnSair.addActionListener(new java.awt.event.ActionListener() {
      public void actionPerformed(java.awt.event.ActionEvent evt) {
          BtnSairActionPerformed(evt);
      }
	 });
}

// Executar eventos dos botoes(BF-Sistema)

private void BtnPausarActionPerformed(java.awt.event.ActionEvent evt) {
	
	if(objDef.PegueTstStatus() == objDef.tstATIVO){
		
		//Pausar();
		
	}
}


private void BtnSaltarActionPerformed(java.awt.event.ActionEvent evt) {
		
	this.Saltar();
	  			
}

private void BtnVoltarActionPerformed(java.awt.event.ActionEvent evt) {	
	// DesfazerExcluir();	// Retorna linha excluida
	
	
	if(Planilha.getValueAt(0, 0).toString().contains("6")){
 		objCxD.Aviso("Contém 6, Reg: " + Planilha.getValueAt(0, 0).toString(), true);
	}else{
		objCxD.Aviso("Não contém 6, Reg: " + Planilha.getValueAt(0, 0).toString(), true);
	}
 	
}

private void BtnAvancarActionPerformed(java.awt.event.ActionEvent evt) {
	InserirLin(10);
}
private void BtnPararActionPerformed(java.awt.event.ActionEvent evt) {

	Parar();
}
private void BtnSairActionPerformed(java.awt.event.ActionEvent evt) {
	
	objLog.Metodo("jxTMain().BtnSairActionPerformed()");
	try{
		SalvarConfig();		// Salva config(preferencias) de usuário
		
    } catch (IOException ex) {  
   	 	objCxD.Aviso("Erro ao carregar arquivo de configuração, " + ex, objDef.bMsgErro);  
    } finally{
   	
    }
	
	System.exit(0);       
}

/******************************************************************************************************/
public void ConstruirBfRede(){
	 
	 objLog.Metodo("jxTMain().ConstruirBfRede()");
	 // Criar a barra 
	 JToolBar BarFerRede = new JToolBar();
	 
	 AddPainel(BarFerRede,objDef.bfBtnRedPosCol, objDef.bfBtnPosLin, objDef.bfBtnRedLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
	 BarFerRede.setFloatable(false);	 
	 BarFerRede.setRollover(true);
	 
	 JSeparator SeparaBarFerRede = new JSeparator();
	 SeparaBarFerRede.setOrientation(SwingConstants.VERTICAL); 
	 BarFerRede.add(SeparaBarFerRede);
	
	 // Adicionar botões a barra
	 BarFerRede.add(BtnNavegador);
	 BarFerRede.add(BtnMedias);
	 BarFerRede.add(BtnInfoAjd);
	 BarFerRede.add(BtnLog);

	 
	 // Inserir icones nos botões
	 BtnNavegador.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnWebDn16.png"));
	 BtnNavegador.setToolTipText("Exibir Bar.Fer.Navegador");
	 BtnNavegador.setCursor(new Cursor(Cursor.HAND_CURSOR));
	 BtnNavegador.setEnabled(false);
	 
	 BtnMedias.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnEuro16.png"));
	 if(objDef.bSimulacao){ BtnMedias.setToolTipText("Atualizar preços médios(máx/min)"); }
	 else{ BtnMedias.setToolTipText("Médias(máx/min)"); }
	 BtnMedias.setCursor(new Cursor(Cursor.HAND_CURSOR));
	 BtnMedias.setEnabled(true);	 
	 
	 BtnInfoAjd.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnPessoas16.png"));
	 BtnInfoAjd.setToolTipText("Exibir info-ajuda");
	 BtnInfoAjd.setCursor(new Cursor(Cursor.HAND_CURSOR));
	 BtnInfoAjd.setEnabled(true);
	 
	 BtnLog.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnLog16.png"));
	 BtnLog.setToolTipText("Exibir Log de Bugs");
	 BtnLog.setCursor(new Cursor(Cursor.HAND_CURSOR));
	 BtnLog.setEnabled(true);
	 
	 // Ouvir enventos
	 BtnNavegador.addActionListener(new java.awt.event.ActionListener() {
		 public void actionPerformed(java.awt.event.ActionEvent evt) {
			 BtnNavegadorActionPerformed(evt);
		 }
	 });
	 BtnMedias.addActionListener(new java.awt.event.ActionListener() {
		 public void actionPerformed(java.awt.event.ActionEvent evt) {
			 BtnMediasActionPerformed(evt);
		 }
	 });
	 BtnInfoAjd.addActionListener(new java.awt.event.ActionListener() {
		 public void actionPerformed(java.awt.event.ActionEvent evt) {
			 BtnInfoAjdActionPerformed(evt);
		 }
	 });
	 BtnLog.addActionListener(new java.awt.event.ActionListener() {
		 public void actionPerformed(java.awt.event.ActionEvent evt) {
			 BtnLogActionPerformed(evt);
		 }
	 });
	 
}

private void BtnNavegadorActionPerformed(java.awt.event.ActionEvent evt) {  

	/* Testar acesso a tags
	LerTags objLerTag = new LerTags();
	String sTags = "";
	String sRes = "";
	
	try{
		sTags = objLerTag.CarregueTagToMemoria("http://www.mtaview.xpg.uol.com.br/");
		//objLerTag.CarregueTagToArqTXT("http://www.mtaview.xpg.uol.com.br/","TagDaURL.txt");
		
		sRes = objLerTag.FiltrarTag(sTags, "oicta01", "/>");
	}catch(IOException e){
		objLog.Metodo("jxTMain().LerTag_antigo(Erro ao gravar Arquivo)");
	}finally{
		objCxD.Aviso(sRes, objDef.bMsgSalvar);
		
	}
	
	*/
	
}

private void BtnMediasActionPerformed(java.awt.event.ActionEvent evt) { 
	// Botão barra-ferramentas 
	//VerSincronismo();	// Testar modem
	//objCxD.Aviso("Click!", true);
	
	
	
	/******************************************************************************/
	
	this.carregarCombosCV(objDef.bLimparCombos);	// carrega preços de Compra e venda na combo
	
}

private void BtnInfoAjdActionPerformed(java.awt.event.ActionEvent evt) { 
		objFrmInfo.Construir();
}


private void BtnLogActionPerformed(java.awt.event.ActionEvent evt) {
	
	new DlgNegocios().Construir();
	  	
	
}

/******************************************************************************************************/
public void ConstruirBfEdicao(){
	 
	 objLog.Metodo("jxTMain().ConstruirBfEdicao()");
	 // Criar a barra 
	 JToolBar BarFerEdicao = new JToolBar();	 
	 
	 AddPainel(BarFerEdicao, objDef.bfBtnEdicaoPosCol, objDef.bfBtnPosLin, objDef.bfBtnEdicaoLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
	 BarFerEdicao.setFloatable(false);	 
	 BarFerEdicao.setRollover(true);
	 
	 JSeparator SeparaBarFerEdicao = new JSeparator();
	 SeparaBarFerEdicao.setOrientation(SwingConstants.VERTICAL);	 
	 BarFerEdicao.add(SeparaBarFerEdicao);
	 
	 
			 
	 // Adicionar botões a barra
	 BarFerEdicao.add(BtnCoordenada);
	 BarFerEdicao.add(BtnLapis);
	 BarFerEdicao.add(BtnShowFiltrar);
	 
	 // Inserir icones nos botões
	 BtnCoordenada.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnmapaChar16.png"));
	 BtnCoordenada.setToolTipText("Exibir/ocultar barra de coordenadas");
	 BtnCoordenada.setHideActionText(true);
	 BtnCoordenada.setCursor(new Cursor(Cursor.HAND_CURSOR));
	 BtnCoordenada.setEnabled(true);
	 
	 BtnLapis.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnLapis16.png"));
	 BtnLapis.setToolTipText("Exibir/ocultar barra de edição");
	 BtnLapis.setHideActionText(true);
	 BtnLapis.setCursor(new Cursor(Cursor.HAND_CURSOR));
	 BtnLapis.setEnabled(true);
	 
	 BtnShowFiltrar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnFiltro16.png"));
	 BtnShowFiltrar.setToolTipText("Exibir/ocultar barra de filtro");
	 BtnShowFiltrar.setHideActionText(true);
	 BtnShowFiltrar.setCursor(new Cursor(Cursor.HAND_CURSOR));
	 BtnShowFiltrar.setEnabled(true);
	 
	 // Ouvir enventos
	 BtnCoordenada.addActionListener(new java.awt.event.ActionListener() {
		 public void actionPerformed(java.awt.event.ActionEvent evt) {
			 BtnCoordenadaActionPerformed(evt);
		 }
	 });
	 BtnLapis.addActionListener(new java.awt.event.ActionListener() {
		 public void actionPerformed(java.awt.event.ActionEvent evt) {
			 BtnLapisActionPerformed(evt);
		 }
	 });
	 BtnShowFiltrar.addActionListener(new java.awt.event.ActionListener() {
		 public void actionPerformed(java.awt.event.ActionEvent evt) {
			 BtnShowFiltrarActionPerformed(evt);
		 }
	 });

	 
}
//Eventos
private void BtnCoordenadaActionPerformed(java.awt.event.ActionEvent evt) { 
	//ExibirOcultar(objDef.PARAMETRO);
}
private void BtnLapisActionPerformed(java.awt.event.ActionEvent evt) {
	//ExibirOcultar(objDef.LAPIS);
}

private void BtnShowFiltrarActionPerformed(java.awt.event.ActionEvent evt) {   
	//ExibirOcultar(objDef.FILTRO);
	
}


/******************************************************************************************************/
/*
	public void ConstruirBfCoordenadas(){
	/*
	 *  Chama metodos de construção Bar.Fer separadas
	 *  NÃO esta em uso, as Bar.Fer esta juntas(Coord + Filtro)
	 *
		objLog.Metodo("jxTMain().ConstruirBfCoordenadas()");
		ConstruirBfFiltro();
		ConstruirBfCoordPos();
		ConstruirBfCoordTitulo();
		ConstruirBfCoordCampo();
	
	}
	*/

	/******************************************************************************************************/
/*	
public void ConstruirBfFiltro(){
	/*
	 *  Barra Fer. Filtro (Separado, NÃO esta em uso - ta usando: Coord + Filtro)
	 *
		objLog.Metodo("jxTMain().ConstruirBfFiltro()");
		
		BfCoordFiltro.setFloatable(false);	 
		BfCoordFiltro.setRollover(true);		
		
		AddPainel(BfCoordFiltro,objDef.bfCoordFilCol, objDef.bfCoordLin, objDef.bfCoordFilLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
	
		JSeparator SeparaBfCoordFiltro = new JSeparator();
		SeparaBfCoordFiltro.setOrientation(SwingConstants.VERTICAL);
		BfCoordFiltro.add(SeparaBfCoordFiltro);

		//BfCoordFiltro.add(cbFiltro);
		//cbFiltro.addItem("Filtar"); //PRPGOD286630-03/31	Filtrar          ...
		BfCoordFiltro.add(tfFiltrar);
		BfCoordFiltro.add(BtnFiltrar);
		BtnFiltrar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnShowFiltrar16.png"));
    	BtnFiltrar.setToolTipText("Aplicar filtro [vago]");
		BtnFiltrar.setHideActionText(true);
		BtnFiltrar.setCursor(new Cursor(Cursor.HAND_CURSOR));
	}	
	
	public void ConstruirBfCoordPos(){
	
		objLog.Metodo("jxTMain().ConstruirBfCoordPos()");
		
		BfCoordPos.setFloatable(false);	 
		BfCoordPos.setRollover(true);		
		
		AddPainel(BfCoordPos,objDef.bfCoordPosCol, objDef.bfCoordLin, objDef.bfCoordPosLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
		

		JSeparator SeparaBfCoordPos = new JSeparator();
		SeparaBfCoordPos.setOrientation(SwingConstants.VERTICAL);
		
		BfCoordPos.add(SeparaBfCoordPos); 
		BfCoordPos.add(tfCoord);			
		BfCoordPos.add(tfCelula);
		
		tfCoord.setColumns(5);
		tfCelula.setColumns(2);
		
		tfCoord.setText("SEQ0, MD0");
		tfCelula.setText("Porta [1], desativado");
		
		// Bloquear edição
		tfCoord.setEditable(false);		
		tfCelula.setEditable(false);
}		
	
	public void ConstruirBfCoordTitulo(){
	
		objLog.Metodo("jxTMain().ConstruirBfCoordTitulo()");
		
		BfCoordTitulo.setFloatable(false);	 
		BfCoordTitulo.setRollover(true);		
		
		AddPainel(BfCoordTitulo,objDef.bfCoordTitCol, objDef.bfCoordLin, objDef.bfCoordTitLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
		
		JSeparator SeparaBfCoordTitulo = new JSeparator();
		SeparaBfCoordTitulo.setOrientation(SwingConstants.VERTICAL);
		BfCoordTitulo.add(SeparaBfCoordTitulo);

		BfCoordTitulo.add(tfTitulo);
		tfTitulo.setColumns(10);
		tfTitulo.setText("Porta[1]");
		tfTitulo.setEditable(false);	// Bloquear edição
		
	}
	public void ConstruirBfCoordCampo(){
	
		objLog.Metodo("jxTMain().ConstruirBfCoordCampo()");
		
		BfCoordCampo.setFloatable(false);	 
		BfCoordCampo.setRollover(true);		
		
		AddPainel(BfCoordCampo,objDef.bfCoordCampoCol, objDef.bfCoordLin, objDef.bfCoordCampoLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
		
		JSeparator SeparaBfCoordCampo = new JSeparator();
		SeparaBfCoordCampo.setOrientation(SwingConstants.VERTICAL);
		BfCoordCampo.add(SeparaBfCoordCampo);


		BfCoordCampo.add(tfConteudo);
		tfConteudo.setColumns(50);
		tfConteudo.setText("");
		tfConteudo.setEditable(false);	// Bloquear edição
		
	}	
*/
	public void FixeExibirBfAddCotacao(boolean bExibe){ BfAddCotacao.setVisible(bExibe);  }
	
	/******************************************************************************************************/

	public void ConstruirbrParametros(boolean bMostrar){
		
		/* Parametros de analise de operações passadas */	
			objLog.Metodo("jxTMain().ConstruirbrParametros()");				
			
			JToolBar BfSeparador = new JToolBar(); 

			BfSeparador.setFloatable(false);	 
			BfSeparador.setRollover(false);		
			
			JLabel lblNRegistro = new JLabel("   N.Reg: ");
			JLabel lblAmostraMed = new JLabel("   Méd: ");	// Num Amostragem para médias Preços Máx/Min
			JLabel lblAmostra = new JLabel("   Tend: ");
			JLabel lblLtx = new JLabel("   Faixa(Ltx): ");
			JLabel lblStop = new JLabel("  Stop(%): ");
			JLabel lblOferta = new JLabel("   Oft(%): ");
			JLabel lblTravarOferta = new JLabel("   Travar OFT: ");
			JLabel lblReferencia = new JLabel("   Ref: ");
			JLabel lblEspaco1 = new JLabel("          ");
			
			BfAcao.setFloatable(false);	 
			BfAcao.setRollover(false);		
			
		
			brParametros.setFloatable(false);	 
			brParametros.setRollover(true);
			
			JSeparator SeparabrParametros = new JSeparator();
			SeparabrParametros.setOrientation(SwingConstants.VERTICAL);
			brParametros.add(SeparabrParametros);
			
			AddPainel(brParametros, objDef.bfParamCol, objDef.bfParamLin, objDef.bfParamLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)					
			brParametros.add(lblNRegistro);	
			brParametros.add(cbNRegistro);	// N.Registros passados a analisar	
			
			brParametros.add(lblAmostraMed);	// Label Amostragem p/ méd.de preços max/min
			brParametros.add(cbAmostraMED);	// Combo Amostragem p/ méd.de preços max/min
			
			brParametros.add(lblAmostra);	// Label Amostragem p/ méd.de tendencia	
			brParametros.add(cbAmostraTEND);	// Combo Amostragem p/ méd.de tendencia	
			
			brParametros.add(lblLtx);		// LTB
			brParametros.add(cbLtb);		// LTB	faixa (-) de LTB
			brParametros.add(cbLta);		// LTA	faixa (+) de LTA
			brParametros.add(lblStop);			
			brParametros.add(cbStopCP);			
			brParametros.add(cbStopVD);		
			brParametros.add(lblOferta);	
			brParametros.add(cbOfertaCP);	
			brParametros.add(cbOfertaVD);
			brParametros.add(lblTravarOferta);	
			brParametros.add(cbTravarOfertaCP);	// Preço compra sempre < que Ult.preço de VD
			brParametros.add(cbTravarOfertaVD);	// Preço de venda sempre > preço da ult. compra
			brParametros.add(lblReferencia);	
			brParametros.add(cbReferencia);	
			
			// Criar rotina para adicionar - Empresa via arq.ini, txt, ou ler de mysql
			cbNRegistro.addItem("Selec");	// Adicona Combo na BFerramentas
			cbNRegistro.addItem("100");	// Adicona Combo na BFerramentas
			cbNRegistro.addItem("300");	// Adicona Combo na BFerramentas
			cbNRegistro.addItem("700");	// Adicona Combo na BFerramentas
			cbNRegistro.addItem("1000");	// Adicona Combo na BFerramentas
			cbNRegistro.addItem("3000");	// Adicona Combo na BFerramentas
			cbNRegistro.addItem("7000");	// Adicona Combo na BFerramentas
			cbNRegistro.addItem("10000");	// Adicona Combo na BFerramentas
			cbNRegistro.addItem("30000");	// Adicona Combo na BFerramentas		
			cbNRegistro.setToolTipText("Número de registros a analisar");	// Dica flutuante
			cbNRegistro.setCursor(new Cursor(Cursor.HAND_CURSOR));
			
			cbAmostraMED.addItem("Selec");	// Adicona Combo na BFerramentas
			cbAmostraMED.addItem("3");	// Adicona Combo na BFerramentas
			cbAmostraMED.addItem("5");	// Adicona Combo na BFerramentas
			cbAmostraMED.addItem("7");	// Adicona Combo na BFerramentas
			cbAmostraMED.addItem("9");	// Adicona Combo na BFerramentas
			cbAmostraMED.addItem("13");	// Adicona Combo na BFerramentas
			cbAmostraMED.addItem("17");	// Adicona Combo na BFerramentas
			cbAmostraMED.addItem("25");	// Adicona Combo na BFerramentas
			cbAmostraMED.addItem("30");	// Adicona Combo na BFerramentas
			cbAmostraMED.addItem("50");	// Adicona Combo na BFerramentas
			cbAmostraMED.addItem("70");	// Adicona Combo na BFerramentas
			cbAmostraMED.addItem("100");	// Adicona Combo na BFerramentas
			cbAmostraMED.setToolTipText("Amostragem(Méd.Pç.Máx/Min)");	// Dica flutuante
			cbAmostraMED.setCursor(new Cursor(Cursor.HAND_CURSOR));
			
			cbAmostraTEND.addItem("Selec");	// Adicona Combo na BFerramentas
			cbAmostraTEND.addItem("3");	// Adicona Combo na BFerramentas
			cbAmostraTEND.addItem("5");	// Adicona Combo na BFerramentas
			cbAmostraTEND.addItem("7");	// Adicona Combo na BFerramentas
			cbAmostraTEND.addItem("9");	// Adicona Combo na BFerramentas
			cbAmostraTEND.addItem("13");	// Adicona Combo na BFerramentas
			cbAmostraTEND.addItem("17");	// Adicona Combo na BFerramentas
			cbAmostraTEND.addItem("25");	// Adicona Combo na BFerramentas
			cbAmostraTEND.addItem("30");	// Adicona Combo na BFerramentas
			cbAmostraTEND.addItem("50");	// Adicona Combo na BFerramentas
			cbAmostraTEND.addItem("70");	// Adicona Combo na BFerramentas
			cbAmostraTEND.addItem("100");	// Adicona Combo na BFerramentas
			cbAmostraTEND.setToolTipText("Amostragem(Cálculo de Tendência)");	// Dica flutuante
			cbAmostraTEND.setCursor(new Cursor(Cursor.HAND_CURSOR));
			
			
			cbLtb.addItem("LTB");	// Adicona Combo na BFerramentas
			cbLtb.addItem("-0.3");	// Adicona Combo na BFerramentas
			cbLtb.addItem("-0.5");	// Adicona Combo na BFerramentas
			cbLtb.addItem("-0.7");	// Adicona Combo na BFerramentas
			cbLtb.addItem("-1.0");	// Adicona Combo na BFerramentas
			cbLtb.addItem("-1.3");	// Adicona Combo na BFerramentas
			cbLtb.addItem("-1.5");	// Adicona Combo na BFerramentas
			cbLtb.addItem("-1.7");	// Adicona Combo na BFerramentas
			cbLtb.addItem("-2.0");	// Adicona Combo na BFerramentas
			cbLtb.addItem("-2.0");	// Adicona Combo na BFerramentas
			cbLtb.addItem("-2.3");	// Adicona Combo na BFerramentas
			cbLtb.addItem("-2.5");	// Adicona Combo na BFerramentas
			cbLtb.addItem("-2.7");	// Adicona Combo na BFerramentas
			cbLtb.addItem("-3.0");	// Adicona Combo na BFerramentas
			cbLtb.addItem("-4.0");	// Adicona Combo na BFerramentas
			cbLtb.addItem("-5.0");	// Adicona Combo na BFerramentas
			cbLtb.addItem("-7.0");	// Adicona Combo na BFerramentas		
			cbLtb.setToolTipText("Faixa(%) que define LTB(-%)");	// Dica flutuante
			cbLtb.setCursor(new Cursor(Cursor.HAND_CURSOR));
			
			cbLta.addItem("LTA");	// Adicona Combo na BFerramentas
			cbLta.addItem("0.3");	// Adicona Combo na BFerramentas
			cbLta.addItem("0.5");	// Adicona Combo na BFerramentas
			cbLta.addItem("0.7");	// Adicona Combo na BFerramentas
			cbLta.addItem("1.0");	// Adicona Combo na BFerramentas
			cbLta.addItem("1.3");	// Adicona Combo na BFerramentas
			cbLta.addItem("1.5");	// Adicona Combo na BFerramentas
			cbLta.addItem("1.7");	// Adicona Combo na BFerramentas
			cbLta.addItem("2.0");	// Adicona Combo na BFerramentas
			cbLta.addItem("2.0");	// Adicona Combo na BFerramentas
			cbLta.addItem("2.3");	// Adicona Combo na BFerramentas
			cbLta.addItem("2.5");	// Adicona Combo na BFerramentas
			cbLta.addItem("2.7");	// Adicona Combo na BFerramentas
			cbLta.addItem("3.0");	// Adicona Combo na BFerramentas
			cbLta.addItem("4.0");	// Adicona Combo na BFerramentas
			cbLta.addItem("5.0");	// Adicona Combo na BFerramentas
			cbLta.addItem("7.0");	// Adicona Combo na BFerramentas		
			cbLta.setToolTipText("Faixa(%) que define LTA(+%)");	// Dica flutuante
			cbLta.setCursor(new Cursor(Cursor.HAND_CURSOR));
			
			cbStopCP.addItem("CP");	// Adicona Combo na BFerramentas
			cbStopCP.addItem("0.0");	// Adicona Combo na BFerramentas
			cbStopCP.addItem("1.0");	// Adicona Combo na BFerramentas
			cbStopCP.addItem("1.5");	// Adicona Combo na BFerramentas
			cbStopCP.addItem("2.0");	// Adicona Combo na BFerramentas
			cbStopCP.addItem("2.5");	// Adicona Combo na BFerramentas
			cbStopCP.addItem("3.0");	// Adicona Combo na BFerramentas
			cbStopCP.addItem("3.5");	// Adicona Combo na BFerramentas
			cbStopCP.addItem("5.0");	// Adicona Combo na BFerramentas
			cbStopCP.addItem("7.0");	// Adicona Combo na BFerramentas
			cbStopCP.addItem("10.0");	// Adicona Combo na BFerramentas	
			cbStopCP.setToolTipText("Stop de compra(+%)");	// Dica flutuante
			cbStopCP.setCursor(new Cursor(Cursor.HAND_CURSOR));
			
			
			cbStopVD.addItem("VD");	// Adicona Combo na BFerramentas
			cbStopVD.addItem("0.0");	// Adicona Combo na BFerramentas
			cbStopVD.addItem("-1.0");	// Adicona Combo na BFerramentas
			cbStopVD.addItem("-1.5");	// Adicona Combo na BFerramentas
			cbStopVD.addItem("-2.0");	// Adicona Combo na BFerramentas
			cbStopVD.addItem("-2.5");	// Adicona Combo na BFerramentas
			cbStopVD.addItem("-3.0");	// Adicona Combo na BFerramentas
			cbStopVD.addItem("-3.5");	// Adicona Combo na BFerramentas
			cbStopVD.addItem("-5.0");	// Adicona Combo na BFerramentas
			cbStopVD.addItem("-7.0");	// Adicona Combo na BFerramentas
			cbStopVD.addItem("-10.0");	// Adicona Combo na BFerramentas	
			cbStopVD.setToolTipText("Stop de venda(-%)");	// Dica flutuante
			cbStopVD.setCursor(new Cursor(Cursor.HAND_CURSOR));
			
			
			cbOfertaCP.addItem("CP");	// Adicona Combo na BFerramentas
			cbOfertaCP.addItem("0.0%");	// Adicona Combo na BFerramentas
			cbOfertaCP.addItem("-0.3%");	// Adicona Combo na BFerramentas
			cbOfertaCP.addItem("-0.5%");	// Adicona Combo na BFerramentas
			cbOfertaCP.addItem("-0.7%");	// Adicona Combo na BFerramentas
			cbOfertaCP.addItem("-1.0%");	// Adicona Combo na BFerramentas
			cbOfertaCP.addItem("-2.0%");	// Adicona Combo na BFerramentas
			cbOfertaCP.addItem("-3.0%");	// Adicona Combo na BFerramentas	
			cbOfertaCP.addItem("-5.0%");	// Adicona Combo na BFerramentas	
			cbOfertaCP.addItem("-7.0%");	// Adicona Combo na BFerramentas	
			cbOfertaCP.addItem("-10.0%");	// Adicona Combo na BFerramentas	
			cbOfertaCP.setToolTipText("Oferta de compra(-%)");	// Dica flutuante
			cbOfertaCP.setCursor(new Cursor(Cursor.HAND_CURSOR));
			cbOfertaCP.setEditable(false);
			

			cbOfertaVD.addItem("VD");	// Adicona Combo na BFerramentas
			cbOfertaVD.addItem("0.0%");	// Adicona Combo na BFerramentas
			cbOfertaVD.addItem("0.3%");	// Adicona Combo na BFerramentas
			cbOfertaVD.addItem("0.5%");	// Adicona Combo na BFerramentas
			cbOfertaVD.addItem("0.7%");	// Adicona Combo na BFerramentas
			cbOfertaVD.addItem("1.0%");	// Adicona Combo na BFerramentas
			cbOfertaVD.addItem("2.0%");	// Adicona Combo na BFerramentas
			cbOfertaVD.addItem("3.0%");	// Adicona Combo na BFerramentas	
			cbOfertaVD.addItem("5.0%");	// Adicona Combo na BFerramentas	
			cbOfertaVD.addItem("7.0%");	// Adicona Combo na BFerramentas	
			cbOfertaVD.addItem("10.0%");	// Adicona Combo na BFerramentas	
			cbOfertaVD.setToolTipText("Oferta de venda(+%)");	// Dica flutuante		
			cbOfertaVD.setCursor(new Cursor(Cursor.HAND_CURSOR));
			cbOfertaVD.setEditable(false);
			
			cbTravarOfertaCP.addItem("Selec");	// Adicona Combo na BFerramentas
			cbTravarOfertaCP.addItem("CP < VD");	// Adicona Combo na BFerramentas
			cbTravarOfertaCP.addItem("Livre");	// Adicona Combo na BFerramentas
			cbTravarOfertaCP.setToolTipText("Oferta de compra menor que val.ult.venda");	// Dica flutuante		
			cbTravarOfertaCP.setCursor(new Cursor(Cursor.HAND_CURSOR));
		
			cbTravarOfertaVD.addItem("Selec");	// Adicona Combo na BFerramentas
			cbTravarOfertaVD.addItem("VD > CP");	// Adicona Combo na BFerramentas
			cbTravarOfertaVD.addItem("Livre");	// Adicona Combo na BFerramentas
			cbTravarOfertaVD.setToolTipText("Oferta de venda maior que val.ult.compra");	// Dica flutuante		
			cbTravarOfertaVD.setCursor(new Cursor(Cursor.HAND_CURSOR));
			
			
			cbReferencia.addItem("Selec");	// Adicona Combo na BFerramentas
			cbReferencia.addItem("Candle");		// Adicona Combo na BFerramentas
			cbReferencia.addItem("Fechamento");	// Adicona Combo na BFerramentas
			cbReferencia.addItem("Máx/Min");	// Adicona Combo na BFerramentas			
			cbReferencia.setToolTipText("Preço a usar como referência nos cálculos");	// Dica flutuante		
			cbReferencia.setCursor(new Cursor(Cursor.HAND_CURSOR));
			
			
			brParametros.setVisible(bMostrar);	// Esconde B.Ferramentas			
					 
			ButtonModel m = new DefaultButtonModel();
			
			//brParametros.add(lblEspaco1);	// Adiciona Botão ao Painel
			brParametros.add(BtnCalcular);	// Adiciona Botão ao Painel
			BtnCalcular.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnGrafico16.png"));
			BtnCalcular.setText("Analisar");
			BtnCalcular.setCursor(new Cursor(Cursor.HAND_CURSOR));
			BtnCalcular.setToolTipText("Executar análise de dados");
			BtnCalcular.setHideActionText(true);
			BtnCalcular.setModel(m);
			
			AddPainel(BfSeparador, objDef.bfParamCol + objDef.bfParamLarg, objDef.bfParamLin,objDef.bfParamEspaco, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)					
			
			  
			// Ouvir eventos - Combos
	        cbNRegistro.addActionListener(new java.awt.event.ActionListener() {  
	            public void actionPerformed(java.awt.event.ActionEvent evt) {  
	                cbNRegistroActionPerformed(evt);  
	            }  
	        }); 
	        cbAmostraMED.addActionListener(new java.awt.event.ActionListener() {  
	            public void actionPerformed(java.awt.event.ActionEvent evt) {  
	                cbAmostraMEDActionPerformed(evt);  
	            }  
	        }); 	
			cbAmostraTEND.addActionListener(new java.awt.event.ActionListener() {  
	            public void actionPerformed(java.awt.event.ActionEvent evt) {  
	                cbAmostraTENDActionPerformed(evt);  
	            }  
	        }); 		
			cbLtb.addActionListener(new java.awt.event.ActionListener() {  
	            public void actionPerformed(java.awt.event.ActionEvent evt) {  
	                cbLtbActionPerformed(evt);  
	            }  
	        });  
			cbLta.addActionListener(new java.awt.event.ActionListener() {  
	            public void actionPerformed(java.awt.event.ActionEvent evt) {  
	                cbLtaActionPerformed(evt);  
	            }  
	        });
	        cbStopCP.addActionListener(new java.awt.event.ActionListener() {  
	            public void actionPerformed(java.awt.event.ActionEvent evt) {  
	                cbStopCPActionPerformed(evt);  
	            }  
	        }); 
			cbStopVD.addActionListener(new java.awt.event.ActionListener() {  
	            public void actionPerformed(java.awt.event.ActionEvent evt) {  
	                cbStopVDActionPerformed(evt);  
	            }  
	        });
	        cbOfertaCP.addActionListener(new java.awt.event.ActionListener() {  
	            public void actionPerformed(java.awt.event.ActionEvent evt) {  
	                cbOfertaCPActionPerformed(evt);  
	            }  
	        });
			cbOfertaVD.addActionListener(new java.awt.event.ActionListener() {  
	            public void actionPerformed(java.awt.event.ActionEvent evt) {  
	                cbOfertaVDActionPerformed(evt);  
	            }  
	        });
			cbReferencia.addActionListener(new java.awt.event.ActionListener() {  
	            public void actionPerformed(java.awt.event.ActionEvent evt) {  
	            	cbReferenciaActionPerformed(evt);  
	            }  
	        }); 
	        
			// Ouvir Eventos - Botões
			// Ouvir enventos
			
			// Botao para setar Parametros como valor padrao
			BtnCalcular.addActionListener(new java.awt.event.ActionListener() {
		        public void actionPerformed(java.awt.event.ActionEvent evt) {
		            BtnCalcularActionPerformed(evt);
		        }
		    });
	        
			
			
		} // final do metodo brParametros

		// Pegar Eventos - Combos
	    private void cbNRegistroActionPerformed(java.awt.event.ActionEvent evt) {  
		     int indiceDoCombo = cbNRegistro.getSelectedIndex();  
		     //objDef.fixeComboNumRegistro(Integer.parseInt(cbNRegistro.getSelectedItem().toString()) );  // Repassa valor da combo
		     objDef.fixeIdxComboNumRegistro(cbNRegistro.getSelectedIndex() );  	// repassa Index da combo
		
	    } 
	    private void cbAmostraMEDActionPerformed(java.awt.event.ActionEvent evt) {  
		     int indiceDoCombo = cbAmostraMED.getSelectedIndex();  
		     //objDef.fixeComboAmostraTEND(Integer.parseInt(cbAmostraTEND.getSelectedItem().toString()) );  
		     objDef.fixeIdxComboAmostraMED(cbAmostraMED.getSelectedIndex() );  	// repassa Index da combo
		 	
		} 
		private void cbAmostraTENDActionPerformed(java.awt.event.ActionEvent evt) {  
		     int indiceDoCombo = cbAmostraTEND.getSelectedIndex();  
		     //objDef.fixeComboAmostraTEND(Integer.parseInt(cbAmostraTEND.getSelectedItem().toString()) );  
		     objDef.fixeIdxComboAmostraTEND(cbAmostraTEND.getSelectedIndex() );  	// repassa Index da combo
		 	
		}   
	    private void cbLtbActionPerformed(java.awt.event.ActionEvent evt) {  
		    // int indiceDoCombo = cbLtb.getSelectedIndex();  
		     //objDef.fixeComboPercLtb( Float.parseFloat(cbLtb.getSelectedItem().toString()) );  
		     objDef.fixeIdxComboPercLtb(cbLtb.getSelectedIndex());  	// repassa Index da combo
		 		
	    } 
	   private void cbLtaActionPerformed(java.awt.event.ActionEvent evt) {  
		   //  int indiceDoCombo = cbLta.getSelectedIndex();  
		     //objDef.fixeComboPercLta(Float.parseFloat(cbLta.getSelectedItem().toString()) );  
		     objDef.fixeIdxComboPercLta(cbLta.getSelectedIndex() );  	// repassa Index da combo
				
	   } 
		
		
		private void cbStopCPActionPerformed(java.awt.event.ActionEvent evt) {  
		  //   int indiceDoCombo = cbStopCP.getSelectedIndex();  
		     //objDef.fixeComboPercStopCP(Float.parseFloat(cbStopCP.getSelectedItem().toString()) );  
		     objDef.fixeIdxComboPercStopCP(cbStopCP.getSelectedIndex() );  	// repassa Index da combo
				
		} 
	   private void cbStopVDActionPerformed(java.awt.event.ActionEvent evt) {  
		   //  int indiceDoCombo = cbStopVD.getSelectedIndex();  
		     //objDef.fixeComboPercStopVD(Float.parseFloat(cbStopVD.getSelectedItem().toString()) );  
		     objDef.fixeIdxComboPercStopVD(cbStopVD.getSelectedIndex() );  	// repassa Index da combo
		 	
	   }   
		
		private void cbOfertaCPActionPerformed(java.awt.event.ActionEvent evt) {  
		  //   int indiceDoCombo = cbOfertaCP.getSelectedIndex();  
		     //objDef.fixeComboPercOfertaCP(Float.parseFloat(cbOfertaCP.getSelectedItem().toString()) );  
		     objDef.fixeIdxComboPercOfertaCP(cbOfertaCP.getSelectedIndex() );  	// repassa Index da combo
		 	
		} 
	   private void cbOfertaVDActionPerformed(java.awt.event.ActionEvent evt) {  
		//     int indiceDoCombo = cbOfertaVD.getSelectedIndex();  
		     //objDef.fixeComboPercOfertaVD(Float.parseFloat(cbOfertaVD.getSelectedItem().toString()) );  
		     objDef.fixeIdxComboPercOfertaVD(cbOfertaVD.getSelectedIndex() );  	// repassa Index da combo
		 	
	   }   
	   private void cbReferenciaActionPerformed(java.awt.event.ActionEvent evt) {  
		  //   int indiceDoCombo = cbReferencia.getSelectedIndex();  
		     //objDef.fixeComboReferencia(cbReferencia.getSelectedItem().toString() );  
		     objDef.fixeIdxComboReferencia(cbReferencia.getSelectedIndex() );  	// repassa Index da combo
		 	
	   }   
	   
		// Eventos
		private void BtnCalcularActionPerformed(java.awt.event.ActionEvent evt) { 
			
	 		AtivarAnalise();	// Ativa analise dentro de uma Thread(processamento em paralelo)
			
		}
		
		/* Sem uso
		public void infoUsuario(){
			  new Thread() {
			     
			    @Override
			    public void run() {
			    	tfBarraStatus.setText("Analisando dados, isso pode demorar alguns minutos, por favor aguarde...");
			       
			    }
			  }.start();
			 
			}
		/***********************************************************************************************/   

		public void ConstruirBfResultaParametros(boolean bMostrar){
			
			/* Resultado dos calculos de analise de operações passadas */	
				objLog.Metodo("jxTMain().ConstruirBfResultaParametros()");				
				
				JToolBar BfSeparador = new JToolBar(); 
				
				BfSeparador.setFloatable(false);	 
				BfSeparador.setRollover(false);		
		
				BfResultaParametros.setFloatable(false);	 
				BfResultaParametros.setRollover(true);
				
				JLabel lblLucro = new JLabel("   Projeção lucro: ");
				JLabel lblOpCP = new JLabel("   N° oper.CP: ");
				JLabel lblStopCP = new JLabel("  N° stop-CP: ");
				JLabel lblOpVD = new JLabel("   N° oper.VD: ");
				JLabel lblStopVD = new JLabel("   N° stop-VD: ");
				JLabel lblDayTrade = new JLabel("   Day-T: ");
				JLabel lblSwingTrade = new JLabel("   Swing-T: ");
				JLabel lblPeriodo = new JLabel("   Período: ");
			
				JLabel lblEspaco1 = new JLabel("          ");
		
				
				JSeparator SeparaBfResultaParametros = new JSeparator();
				SeparaBfResultaParametros.setOrientation(SwingConstants.VERTICAL);
				BfResultaParametros.add(SeparaBfResultaParametros);
				
				// EX: Lucro: 30%, Op.Compra: 90%, Stop-CP: 10%, Op.Venda: 90%, Stop-VD: 10%  
				
				
				AddPainel(BfResultaParametros, objDef.bfParamCol, objDef.bfParamLin + objDef.iAltPadraoBF, objDef.iTelaLarg - 10, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)					
				BfResultaParametros.add(lblLucro);		// Lucro projetado para os parametros setados	
				BfResultaParametros.add(tfProjLucro);	// Lucro projetado para os parametros setados	
				BfResultaParametros.add(lblOpCP);		// Num. de operações de compra para os parametros passados
				BfResultaParametros.add(tfNumOperaCP);	// Num. de operações de compra para os parametros passados
				BfResultaParametros.add(lblStopCP);		// Num. de stops de compra(stopadas) para os parametros passados
				BfResultaParametros.add(tfNumStopCP);	// Num. de stops de compra(stopadas) para os parametros passados
				BfResultaParametros.add(lblOpVD);		// Num. de operações de venda para os parametros passados
				BfResultaParametros.add(tfNumOperaVD);	// Num. de operações de venda para os parametros passados
				BfResultaParametros.add(lblStopVD);		// Num. de stops de venda(stopadas) para os parametros passados
				BfResultaParametros.add(tfNumStopVD);	// Num. de stops de venda(stopadas) para os parametros passados
				
				BfResultaParametros.add(lblDayTrade);	// Num. de stops de venda(stopadas) para os parametros passados
				BfResultaParametros.add(tfDayTrade);		// Periodo(data) da analise
				
				BfResultaParametros.add(lblSwingTrade);	// Num. de stops de venda(stopadas) para os parametros passados
				BfResultaParametros.add(tfSwingTrade);		// Periodo(data) da analise
				
				BfResultaParametros.add(lblPeriodo);	// Num. de stops de venda(stopadas) para os parametros passados
				BfResultaParametros.add(tfPeriodo);		// Periodo(data) da analise
			
			
				tfProjLucro.setColumns(1);
				tfProjLucro.setEditable(false);	// Bloquear edição
				tfProjLucro.setHorizontalAlignment(JTextField.CENTER);	// centraliza texto
				tfProjLucro.setBackground(Color.orange);
				
				tfNumOperaCP.setColumns(1);
				tfNumOperaCP.setEditable(false);	// Bloquear edição
				tfNumOperaCP.setHorizontalAlignment(JTextField.CENTER);	// centraliza texto
				tfNumOperaCP.setBackground(Color.orange);
				
				tfNumOperaVD.setColumns(1);
				tfNumOperaVD.setEditable(false);	// Bloquear edição
				tfNumOperaVD.setHorizontalAlignment(JTextField.CENTER);	// centraliza texto
				tfNumOperaVD.setBackground(Color.orange);
				
				tfNumStopCP.setColumns(1);
				tfNumStopCP.setEditable(false);	// Bloquear edição
				tfNumStopCP.setHorizontalAlignment(JTextField.CENTER);	// centraliza texto
				tfNumStopCP.setBackground(Color.orange);
				
				tfNumStopVD.setColumns(1);
				tfNumStopVD.setEditable(false);	// Bloquear edição
				tfNumStopVD.setHorizontalAlignment(JTextField.CENTER);	// centraliza texto
				tfNumStopVD.setBackground(Color.orange);
				
				tfDayTrade.setColumns(1);
				tfDayTrade.setEditable(false);	// Bloquear edição
				tfDayTrade.setHorizontalAlignment(JTextField.CENTER);	// centraliza texto
				tfDayTrade.setBackground(Color.orange);
			
				tfSwingTrade.setColumns(1);
				tfSwingTrade.setEditable(false);	// Bloquear edição
				tfSwingTrade.setHorizontalAlignment(JTextField.CENTER);	// centraliza texto
				tfSwingTrade.setBackground(Color.orange);
				
				tfPeriodo.setColumns(1);
				tfPeriodo.setEditable(false);	// Bloquear edição
				tfPeriodo.setHorizontalAlignment(JTextField.CENTER);	// centraliza texto
				tfPeriodo.setBackground(Color.orange);
					
				BfResultaParametros.setVisible(bMostrar);	// Esconde B.Ferramentas			
				
				//AddPainel(BfSeparador, objDef.bfParamCol + objDef.bfParamLarg, objDef.bfParamLin,objDef.bfParamEspaco, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)					
				
				
			} // final do metodo BfResultaParametros

		/*
			// Eventos
			private void BtnCalcularActionPerformed(java.awt.event.ActionEvent evt) { 

			}
		  */  
   
	/***********************************************************************************************/   
	public void ConstruirBfAddCotacao(boolean bMostrar){
		
		objLog.Metodo("jxTMain().ConstruirBfAddCotacao()");				
		
		JToolBar BfSeparador = new JToolBar(); 

		BfSeparador.setFloatable(false);	 
		BfSeparador.setRollover(false);		
	
		BfAddCotacao.setFloatable(false);	 
		BfAddCotacao.setRollover(true);
		
		JSeparator SeparaBfAddLin = new JSeparator();
		SeparaBfAddLin.setOrientation(SwingConstants.VERTICAL);
		BfAddCotacao.add(SeparaBfAddLin);

		AddPainel(BfAddCotacao, objDef.bfAddCol, objDef.bfAddLin, objDef.bfAddLinLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)					
		BfAddCotacao.add(cbCodEmpresa);	// GGBR4, PETR4, BRF4		
		BfAddCotacao.add(tfDataCota);	
		BfAddCotacao.add(cbTimeM15);	// 10:00:00, 10:15:00
		BfAddCotacao.add(tfOpen);		// Preço de abertura	
		BfAddCotacao.add(tfHigh);		// Pr.Max	
		BfAddCotacao.add(tfLow);		// Pr.Min
		BfAddCotacao.add(tfClose);		// Pr.de fechamento
		BfAddCotacao.add(tfTVol);		// Tick-Volume
		BfAddCotacao.add(tfVol);		// Volume
		BfAddCotacao.add(tfSpread);		// Spread
		
		// Criar rotina para adicionar - Empresa via arq.ini, txt, ou ler de mysql
		cbCodEmpresa.addItem("Código");	// Adicona Combo na BFerramentas
		cbCodEmpresa.addItem("GGBR4");	// Adicona Combo na BFerramentas
		cbCodEmpresa.addItem("PETR4");	// Adicona Combo na BFerramentas
		cbCodEmpresa.addItem("BBS3");	// Adicona Combo na BFerramentas
		cbCodEmpresa.addItem("UNIP6");	// Adicona Combo na BFerramentas
		cbCodEmpresa.addItem("OIBR4");	// Adicona Combo na BFerramentas
		cbCodEmpresa.addItem("ROMI");	// Adicona Combo na BFerramentas
		cbCodEmpresa.addItem("VALE3");	// Adicona Combo na BFerramentas
		
		cbCodEmpresa.setToolTipText("Código do ativo");	// Dica flutuante

		tfDataCota.setText(Formatar.format(data));
		
		// Rotina para criar lista de Minutos de 15em15
		cbTimeM15.addItem("Hora");	// Titulo - 1° item		
		String sHr, sHr1, sHr2, sHr3, sHr4 ="";
		for(int iH = 10; iH <= 18; iH++){ 
			sHr = String.valueOf(iH);
			sHr1 = sHr + ":00:00";
			sHr2 = sHr + ":15:00";
			sHr3 = sHr + ":30:00";
			sHr4 = sHr + ":45:00";
			
			// Adiciona Time´s na combo
			cbTimeM15.addItem(sHr1);
			cbTimeM15.addItem(sHr2);
			cbTimeM15.addItem(sHr3);
			cbTimeM15.addItem(sHr4);
			
		}	
			
		cbTimeM15.setToolTipText("Hora de fechamento");
		cbTimeM15.setCursor(new Cursor(Cursor.HAND_CURSOR));
		
		BfAddCotacao.setVisible(bMostrar);	// Esconde B.Ferramentas			
				
		/******************************************/
		tfDataCota.setColumns(10);			
		tfDataCota.setSize(10, 20);
		tfDataCota.setToolTipText("Data");	
		/******************************************/
		tfOpen.setColumns(10);			
		tfOpen.setSize(10, 20);
		tfOpen.setToolTipText("Abert.");	// Pr.abertura
		/******************************************/
		tfHigh.setColumns(10);			
		tfHigh.setSize(10, 20);
		tfHigh.setToolTipText("Máx.");	// Pr.max
		/******************************************/
		tfLow.setColumns(10);			
		tfLow.setSize(10, 20);
		tfLow.setToolTipText("Min.");	// Preço
		/******************************************/
		tfClose.setColumns(10);			
		tfClose.setSize(10, 20);
		tfClose.setToolTipText("Fech.");	// Preço
		/******************************************/
		tfTVol.setColumns(10);			
		tfTVol.setSize(10, 20);
		tfTVol.setToolTipText("T.Vol.");	// Tick-volume
		/******************************************/
		tfVol.setColumns(10);			
		tfVol.setSize(10, 20);
		tfVol.setToolTipText("Fech.");	// Volume
		/******************************************/
		tfSpread.setColumns(10);			
		tfSpread.setSize(10, 20);
		tfSpread.setToolTipText("Spread");	// Spread
		/******************************************/
		
		
		 
		
		// Botões: Add, Limpar 
		JButton BtnAddCotacao = new JButton();	// Cria Botão
		BfAddCotacao.add(BtnAddCotacao);			// Adiciona Botão ao Painel	
		BtnAddCotacao.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnAddLinha16.png"));
		BtnAddCotacao.setText("Adicionar");
		BtnAddCotacao.setCursor(new Cursor(Cursor.HAND_CURSOR));
		BtnAddCotacao.setToolTipText("Inserir cotação");
		BtnAddCotacao.setHideActionText(true);
		 
		JButton BtnLimpar = new JButton();	// Cria Botão
		BfAddCotacao.add(BtnLimpar);	// Adiciona Botão ao Painel
		BtnLimpar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnLimpar16.png"));
		BtnLimpar.setCursor(new Cursor(Cursor.HAND_CURSOR));
		BtnLimpar.setToolTipText("Limpar planilha");
		BtnLimpar.setHideActionText(true);
 
		AddPainel(BfSeparador, objDef.bfAddCol + objDef.bfAddLinLarg, objDef.bfAddLin, objDef.bfAddLinLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)					
		
		BfAddCotacao.setVisible(bMostrar);
		
		// Ouvir eventos - Combos
        cbCodEmpresa.addActionListener(new java.awt.event.ActionListener() {  
            public void actionPerformed(java.awt.event.ActionEvent evt) {  
                cbCodEmpresaActionPerformed(evt);  
            }  
        });  
        cbTimeM15.addActionListener(new java.awt.event.ActionListener() {  
            public void actionPerformed(java.awt.event.ActionEvent evt) {  
                cbTimeM15ActionPerformed(evt);  
            }  
        });  
        
        
		// Ouvir Eventos - Botões
        BtnAddCotacao.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
            	BtnAddCotacaoActionPerformed(evt);
            }
        });
        BtnLimpar.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
            	BtnLimparActionPerformed(evt);
            }
        });
        
		
		
	} // final do metodo BfAddCotacao
    
	// Pegar eventos
    private void cbCodEmpresaActionPerformed(java.awt.event.ActionEvent evt) {  
	     int indiceDoCombo = cbCodEmpresa.getSelectedIndex();  
	     objDef.fixeComboCodEmpresa(cbCodEmpresa.getSelectedItem().toString() );  
	} 
    private void cbTimeM15ActionPerformed(java.awt.event.ActionEvent evt) {  
	     int indiceDoCombo = cbTimeM15.getSelectedIndex();  
	     objDef.fixeComboTimeM15(cbTimeM15.getSelectedItem().toString() );  
	} 
	
		
	private void BtnAddCotacaoActionPerformed(java.awt.event.ActionEvent evt) {
	 	
		this.AddRegistro();
	}
	
	private void BtnLimparActionPerformed(java.awt.event.ActionEvent evt) {
		
		int iTReg = objUtil.ContarReg(Planilha);	// Conta numero de registros na tabela
		objDef.fixeNumRegMetaTrader(iTReg);
		
		if( iTReg > 1){							// Verifica NumReg	            				    
    		  if(objCxD.Confirme("Apagar todos os registros da tabela?", objDef.bMsgExcluir)){
				 // objUtil.LimparPlanilha(Planilha);
				  //LimparItensFiltro("Filtrar campos...");
				  LimparPlanilha(objDef.pegueNumRegMetaTrader());
				  objDef.fixeNumRegMetaTrader(0);	// Limpou....zera info
			  }
     	}else{ objCxD.Aviso("Não há registros a serem excluidos.", true); }

	
		/*
		int iTReg = objUtil.ContarReg(Planilha);	// Conta numero de registros na tabela
				
		if( iTReg > 1){							// Verifica NumReg
	
			if(objCxD.Confirme("Apagar todos os dados da tabela?", objDef.bMsgExcluir) )
			{
				
			//	objUtil.LimparPlanilha(Planilha);			
				LimparItensFiltro("Filtrar campos...");
				objDef.fixeNumRegMetaTrader(0);	// Limpou...zera info
				
			}
		}else{ objCxD.Aviso("Não há registros a serem excluidos.", true); }
		*/
		
		
	}
	/******************************************************************************************************/
	// Bar.Fer de testes 
	public void ConstruirBfTeste(){
	
		objLog.Metodo("jxTMain().ConstruirBfTeste()");				
		
		BfTeste.setFloatable(false);	 
		BfTeste.setRollover(true);		
		
		AddPainel(BfTeste,objDef.bfTesteCol, objDef.bfTesteLin, objDef.bfTesteLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)

		BfTeste.add(BtnTstSinc);
		BtnTstSinc.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnEngrenagem16.png"));
		BfTeste.add(BtnTstAuth);
		BtnTstAuth.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnEngrenagem16.png"));
		BfTeste.add(BtnTstPing);
		BtnTstPing.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnEngrenagem16.png"));
		BfTeste.add(BtnTstVoz);
		BtnTstVoz.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnEngrenagem16.png"));
		
		// Ouvir enventos
		BtnTstSinc.addActionListener(new java.awt.event.ActionListener() {
	        public void actionPerformed(java.awt.event.ActionEvent evt) {
	            BtnTstSincActionPerformed(evt);
	        }
	    });
		BtnTstAuth.addActionListener(new java.awt.event.ActionListener() {
		        public void actionPerformed(java.awt.event.ActionEvent evt) {
		            BtnTstAuthActionPerformed(evt);
		        }
		});
		BtnTstPing.addActionListener(new java.awt.event.ActionListener() {
		        public void actionPerformed(java.awt.event.ActionEvent evt) {
		            BtnTstPingActionPerformed(evt);
		        }
		});
		BtnTstVoz.addActionListener(new java.awt.event.ActionListener() {
		        public void actionPerformed(java.awt.event.ActionEvent evt) {
		            BtnTstVozActionPerformed(evt);
		        }
		});
	
	}

	
	// Eventos
	private void BtnTstSincActionPerformed(java.awt.event.ActionEvent evt) { 
		
		
		/*
		objCxD.Aviso("Exec.ping...",  true);
		
		
		String sCaptura = objDLinkOpticom.connect(objDef.ShMODEM, "192.168.1.101", objDef.sLogin, objDef.sSenha, objDef.iPorta, "192.168.1.104"); 		    		    		
		String sCapturaAnt = taTelnet.getText();
	    taTelnet.setText(sCapturaAnt + sCaptura);
		*/
		objLog.Metodo("jxTMain().BtnTstSincActionPerformed()");
		Iniciar(objDef.tstMODEM);
		
		
		
	}

	private void BtnTstAuthActionPerformed(java.awt.event.ActionEvent evt) { 
		
	

		try{
			LerConfig(objDef.bCriptoConfig);
		}catch(IOException e){
			objLog.Metodo("jxTMain().SalvarConfig(Erro ao gravar Arquivo)");
		}finally{
			objCxD.Aviso("Arquivo mta Salvo !", objDef.bMsgSalvar);
		}
	
	}
	
	private void BtnTstPingActionPerformed(java.awt.event.ActionEvent evt) { 

		
		

	}// Eventos
	
	/******************************************************************************************************/
	/*
	public void ConstruirBfCoordFiltro(){
		// Barra Fer.Coord + Filtro (Em uso)  
		objLog.Metodo("jxTMain().ConstruirBfCoordFiltro()");				
		
		BfFiltro.setFloatable(false);	 
		BfFiltro.setRollover(true);		
		
		AddPainel(BfFiltro,objDef.bfFiltroCol, objDef.bfFiltroLin, objDef.iTelaLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)

		JSeparator SeparaBfCoordFiltro = new JSeparator();
		SeparaBfCoordFiltro.setOrientation(SwingConstants.VERTICAL);
		BfFiltro.add(SeparaBfCoordFiltro);

		JSeparator SeparaBfFiltro = new JSeparator();
		SeparaBfFiltro.setOrientation(SwingConstants.VERTICAL);
		
		BfFiltro.add(SeparaBfFiltro);
		BfFiltro.add(tfCoord);
		BfFiltro.add(tfCelula);
			
		tfCelula.setColumns(2);
		tfCelula.setText("Porta [1]");
		tfCelula.setEditable(false);	// Bloquear edição
		
		BfFiltro.add(BtnFiltrar);
		BtnFiltrar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnShowFiltrar16.png"));
		BtnFiltrar.setToolTipText("Aplicar filtro");
		BtnFiltrar.setHideActionText(true);
		BtnFiltrar.setCursor(new Cursor(Cursor.HAND_CURSOR));
		BfFiltro.add(tfFiltrar);
		
				
		// Posição [A1]
		
		tfCoord.setColumns(5);
		tfCoord.setText("SEQ0, MD0");
		tfCoord.setEditable(false);	// Bloquear edição	
	
	}
*/
	// Final das Barra de ferramentas
/*******************************************************************************/
/*
	public void ConstruirBfCoordLtxFiltro(){
		
		// Barra Fer.Coord + LTX(Linha de Tendencia X: orientacao de operaçao + Filtro (Em uso)  
		objLog.Metodo("jxTMain().ConstruirBfCoordFiltro()");				
		
		final JTextField tfEspacoVazio1 = new JTextField(20);
		final JTextField tfEspacoVazio2 = new JTextField(20);
		final JTextField tfEspacoVazio3 = new JTextField(20);
		final JTextField tfEspacoVazio4 = new JTextField(20);
		final JTextField tfEspacoVazio5 = new JTextField(20);
		
		JLabel lblOrdem = new JLabel("   Ação: ");
		JLabel lblTende = new JLabel("   Tendência: ");
		JLabel lblOferta = new JLabel("  ferta: ");
		JLabel lblStop = new JLabel("   Stop: ");
		JLabel lblEspaco1 = new JLabel("          ");
		
		BfFiltro.setFloatable(false);	 
		BfFiltro.setRollover(false);		
		
		AddPainel(BfFiltro,objDef.bfFiltroCol, objDef.bfFiltroLin, objDef.iTelaLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)

		JSeparator SeparaBfCoordLtxFiltro = new JSeparator();
		SeparaBfCoordLtxFiltro.setOrientation(SwingConstants.VERTICAL);
		BfFiltro.add(SeparaBfCoordLtxFiltro);

		JSeparator SeparaBfFiltro = new JSeparator();
		SeparaBfFiltro.setOrientation(SwingConstants.HORIZONTAL);
		
		BfFiltro.add(SeparaBfFiltro);
		BfFiltro.add(tfCelula);
		BfFiltro.add(lblEspaco1);

		
		BfFiltro.add(SeparaBfFiltro);		
		BfFiltro.add(lblOrdem);
		BfFiltro.add(tfOrdem);
		
		BfFiltro.add(lblTende);
		BfFiltro.add(tfUltTendencia);
		
		BfFiltro.add(lblOferta);
		BfFiltro.add(tfOferta);
		
		BfFiltro.add(lblStop);
		BfFiltro.add(tfStop);
		BfFiltro.add(tfEspacoVazio2);
		
				
		// trava edicao Coordenada Lin x Col
		tfCelula.setColumns(1);
		tfCelula.setText("Reg [1]");
		tfCelula.setEditable(false);	// Bloquear edição
		
		tfOrdem.setColumns(1);
		tfOrdem.setEditable(false);	// Bloquear edição
		
		tfUltTendencia.setColumns(1);
		tfUltTendencia.setEditable(false);	// Bloquear edição
		
		tfOferta.setColumns(1);
		tfOferta.setEditable(false);	// Bloquear edição
		
		tfStop.setColumns(1);
		tfStop.setEditable(false);	// Bloquear edição
		
		tfEspacoVazio1.setColumns(1);
		tfEspacoVazio1.setEditable(false);	// Bloquear edição
		

		tfEspacoVazio2.setColumns(1);
		tfEspacoVazio2.setEditable(false);	// Bloquear edição
		
		tfEspacoVazio3.setColumns(1);
		tfEspacoVazio3.setEditable(false);	// Bloquear edição
		
		tfEspacoVazio4.setColumns(1);
		tfEspacoVazio5.setEditable(false);	// Bloquear edição
		
		tfEspacoVazio5.setColumns(1);
		tfEspacoVazio5.setEditable(false);	// Bloquear edição
		
		
		BfFiltro.add(BtnFiltrar);
		BtnFiltrar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnShowFiltrar16.png"));
		BtnFiltrar.setToolTipText("Aplicar filtro");
		BtnFiltrar.setHideActionText(true);
		BtnFiltrar.setCursor(new Cursor(Cursor.HAND_CURSOR));
		BfFiltro.add(tfFiltrar);
		
				
		/*		
		tfCoord.setColumns(5);
		tfCoord.setText("SEQ0, MD0");
		tfCoord.setEditable(false);	// Bloquear edição	
		*/
	//}

	// Final das Barra de ferramentas
	
/***********************************************************************************************/
// Triu - [Coord - Acao - Filtro]
	
		
public void MontarBfCoordAcaoFiltro(boolean bMostrar)
{
 	ConstruirBfCoordenada(bMostrar);	
 	ConstruirBfAcao(bMostrar);	
 	ConstruirBfFiltrar(bMostrar);	
}    

public void ConstruirBfCoordenada(boolean bMostrar){
		
		// Barra Fer.Coord + LTX(Linha de Tendencia X: orientacao de operaçao + Filtro (Em uso)  
		objLog.Metodo("jxTMain().ConstruirBfCoordenada()");				
		
		BfCoordenada.setFloatable(false);	 
		BfCoordenada.setRollover(false);		
		
		AddPainel(BfCoordenada,objDef.bfCoordenadaCol, objDef.bfCoordenadaLin, objDef.bfCoordenadaLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)

		JSeparator SeparaBfCoordenada = new JSeparator();
		SeparaBfCoordenada.setOrientation(SwingConstants.VERTICAL);
		BfCoordenada.add(SeparaBfCoordenada);

		//JSeparator SeparaBfCoordenada = new JSeparator();
		//SeparaBfCoordenada.setOrientation(SwingConstants.HORIZONTAL);
		
		BfCoordenada.add(SeparaBfCoordenada);
		BfCoordenada.add(tfCelula);
				
		// trava edicao Coordenada Lin x Col
		tfCelula.setColumns(1);
		tfCelula.setText("Reg [1]");
		tfCelula.setEditable(false);	// Bloquear edição
		tfCelula.setHorizontalAlignment(JTextField.CENTER);	// centraliza texto
		
		BfCoordenada.setVisible(bMostrar);
	}

public void InicializarCombos(){
	/*
	objDef.fixeComboNumRegistro(3000);	
	objDef.fixeComboAmostraTEND(9);
	objDef.fixeComboPercLta(0.7f);
	objDef.fixeComboPercLtb(-0.7f);
	objDef.fixeComboPercStopCP(3.0f);
	objDef.fixeComboPercStopVD(-3.0f);
	objDef.fixeComboPercOfertaCP(-0.5f);
	objDef.fixeComboPercOfertaVD(2.0f);
	objDef.fixeComboReferencia("Fechamento");
*/	
	
	
}
public void ConstruirBfAcao(boolean bMostrar){
		
		// Barra Fer.Coord + LTX(Linha de Tendencia X: orientacao de operaçao + Filtro (Em uso)  
		objLog.Metodo("jxTMain().ConstruirBfAcao()");				

		JToolBar BfSeparador = new JToolBar(); 

		BfSeparador.setFloatable(false);	 
		BfSeparador.setRollover(false);		
		
		JLabel lblPrecos = new JLabel("     Var.Preços: ");
		
		JLabel lblStatus = new JLabel("     Status: ");
		JLabel lblOrdem = new JLabel("     Ação: ");
		JLabel lblTende = new JLabel("     Tendência: ");
		JLabel lblOferta = new JLabel("    Oferta: ");
		JLabel lblStop = new JLabel("     Stop: ");
		JLabel lblEspaco1 = new JLabel("          ");
		
		BfAcao.setFloatable(false);	 
		BfAcao.setRollover(false);		
		
		
	//	AddPainel(BfSeparador,objDef.bfAcaoCol, objDef.bfAcaoLin, 30, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
		AddPainel(BfAcao,objDef.bfAcaoCol, objDef.bfAcaoLin, objDef.bfAcaoLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)

		JSeparator SeparaBfAcao = new JSeparator();
		SeparaBfAcao.setOrientation(SwingConstants.VERTICAL);
		BfAcao.add(SeparaBfAcao);

		
		//JSeparator SeparaBfAcao = new JSeparator();
		//SeparaBfAcao.setOrientation(SwingConstants.HORIZONTAL);
		
		BfAcao.add(SeparaBfAcao);		
		BfAcao.add(lblEspaco1);
		
		
		BfAcao.add(lblPrecos);
		BfAcao.add(tfPrcMin);
		BfAcao.add(tfMedMin);
		BfAcao.add(tfPrcMed);
		BfAcao.add(tfMedMax);
		BfAcao.add(tfPrcMax);
		
		BfAcao.add(SeparaBfAcao);		
		BfAcao.add(lblEspaco1);
		
		
		BfAcao.add(lblStatus);
		BfAcao.add(tfAcaoStatus);
		
		BfAcao.add(lblOrdem);
		BfAcao.add(tfOrdem);
		
		
		BfAcao.add(lblTende);
		BfAcao.add(tfUltTendencia);
		
		BfAcao.add(lblOferta);
		BfAcao.add(tfOferta);
		
		BfAcao.add(lblStop);
		BfAcao.add(tfStop);
		
		tfPrcMin.setColumns(1);
		tfPrcMin.setEditable(false);	// Bloquear edição
		tfPrcMin.setBackground(Color.CYAN);
		tfPrcMin.setHorizontalAlignment(JTextField.CENTER);	// centraliza texto
		tfPrcMin.setToolTipText("Preço mínimo p/ período analisado");
		
		tfMedMin.setColumns(1);
		tfMedMin.setEditable(false);	// Bloquear edição
		tfMedMin.setBackground(Color.GREEN);
		tfMedMin.setHorizontalAlignment(JTextField.CENTER);	// centraliza texto
		tfMedMin.setToolTipText("Média de preço mín.p/ período analisado");
		
		tfPrcMed.setColumns(1);
		tfPrcMed.setEditable(false);	// Bloquear edição
		tfPrcMed.setBackground(Color.yellow);
		tfPrcMed.setHorizontalAlignment(JTextField.CENTER);	// centraliza texto
		tfPrcMed.setToolTipText("Preço médio p/ período analisado");
		
		tfMedMax.setColumns(1);
		tfMedMax.setEditable(false);	// Bloquear edição
		tfMedMax.setBackground(Color.orange);
		tfMedMax.setHorizontalAlignment(JTextField.CENTER);	// centraliza texto
		tfMedMax.setToolTipText("Média de preço máx.p/ período analisado");
		
		tfPrcMax.setColumns(1);
		tfPrcMax.setEditable(false);	// Bloquear edição
		tfPrcMax.setBackground(Color.red);
		tfPrcMax.setHorizontalAlignment(JTextField.CENTER);	// centraliza texto
		tfPrcMax.setToolTipText("Preço máximo p/ período analisado");
		
		tfAcaoStatus.setColumns(1);
		tfAcaoStatus.setEditable(false);	// Bloquear edição
		tfAcaoStatus.setBackground(Color.cyan);
		tfAcaoStatus.setHorizontalAlignment(JTextField.CENTER);	// centraliza texto
		tfAcaoStatus.setToolTipText("Status atual (Comprado/vendido)");
		
		tfOrdem.setColumns(1);
		tfOrdem.setEditable(false);	// Bloquear edição
		tfOrdem.setBackground(Color.cyan);
		tfOrdem.setHorizontalAlignment(JTextField.CENTER);	// centraliza texto
		tfOrdem.setToolTipText("Ação a tomar(C/V/Aguardar)");
		
		tfUltTendencia.setColumns(1);
		tfUltTendencia.setEditable(false);	// Bloquear edição
		tfUltTendencia.setBackground(Color.cyan);
		tfUltTendencia.setHorizontalAlignment(JTextField.CENTER);	// centraliza texto
		tfUltTendencia.setToolTipText("Última tendência");
		
		
		tfOferta.setColumns(1);
		tfOferta.setEditable(false);	// Bloquear edição
		tfOferta.setBackground(Color.cyan);
		tfOferta.setHorizontalAlignment(JTextField.CENTER);	// centraliza texto
		tfOferta.setToolTipText("Valor da oft a enviar");		
		
		tfStop.setColumns(1);
		tfStop.setEditable(false);	// Bloquear edição
		tfStop.setBackground(Color.cyan);
		tfStop.setHorizontalAlignment(JTextField.CENTER);	// centraliza texto
		tfStop.setToolTipText("Valor do Stop a enviar");
		
		
		BfAcao.setVisible(bMostrar);
	}

	public void ConstruirBfFiltrar(boolean bMostrar){
		
		// Barra Fer.Filtrar (Em uso) - mesma linha [Coord - Acao - Filtro]  
		objLog.Metodo("jxTMain().ConstruirBfFiltrar()");				
	
		JToolBar BfSeparador = new JToolBar(); 
		JToolBar BfSeparadorFim = new JToolBar(); 

		BfSeparador.setFloatable(false);	 
		BfSeparador.setRollover(false);		
		
		BfSeparadorFim.setFloatable(false);	 
		BfSeparadorFim.setRollover(false);		
	
		JLabel lblEspaco1 = new JLabel("          ");
		
		BfFiltrar.setFloatable(false);	 
		BfFiltrar.setRollover(false);		
		
//		AddPainel(BfSeparador,objDef.bfFiltrarCol, objDef.bfFiltrarLin, 80, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
		AddPainel(BfFiltrar,objDef.bfFiltrarCol, objDef.bfFiltrarLin, objDef.bfFiltrarLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)

		JSeparator SeparaBfCoordLtxFiltrar = new JSeparator();
		SeparaBfCoordLtxFiltrar.setOrientation(SwingConstants.VERTICAL);
		BfFiltro.add(SeparaBfCoordLtxFiltrar);

		JSeparator SeparaBfFiltrar = new JSeparator();
		SeparaBfFiltrar.setOrientation(SwingConstants.HORIZONTAL);
					
		BfFiltrar.add(lblEspaco1);
		BfFiltrar.add(BtnFiltrar);
		BtnFiltrar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnFiltro16.png"));
		BtnFiltrar.setToolTipText("Aplicar filtro");
		BtnFiltrar.setHideActionText(true);
		BtnFiltrar.setCursor(new Cursor(Cursor.HAND_CURSOR));
		BfFiltrar.add(tfFiltrar);
		
		
		BfFiltrar.setVisible(bMostrar);
		
	}

/*******************************************************************************/

	
	//------------------------------------------------------
	// Botao de Vox
	
	//------------------------------------------------------
	
	public void paintComponent3(Graphics g) {  
		   //Tire uma cópia do objeto graphics. Você não deve alterar o estado de g.  
		   Graphics g2d = g.create();  
		   //Aqui vc desenha, por exemplo  
		   g2d.drawLine(0,0,getWidth(), getHeight()); //Desenha uma linha diagonal no painel.  
		   //Após desenhar, limpamos o objeto graphics  
		   g2d.dispose();  
		}  
	
	public void paintComponent(Graphics g){
		 //   super.paintComponent(g);
		        
		    g.setFont(new java.awt.Font("Courier New", 0, 11));	
		    g.setColor(Color.gray);


		    g.setColor(Color.RED);     
		    g.drawLine(0, 0, 500, 50);	//  ColIni, LinIni, ColFim, LinFim()
		    
	
	 }

	
	/******************************************************************************************************/
	//public boolean isCellEditable(int linha, int coluna) {  
	  //  return false;  
	//} 
	
	public void ConstruirPlanilha(boolean bAjustar){
		 
		objLog.Metodo("jxTMain().ConstruirPlanilha(" + bAjustar + ")");				
			
		 BfPlanilha.setFloatable(false);	 
		 BfPlanilha.setRollover(true);
		 // (Componente, Col, LInha, Larg, Altura)
		 if(bAjustar){
			 AddPainel(BfPlanilha,1, objDef.bfTabLinIni + 25, objDef.iTelaLarg, objDef.AltTabela - 25);
		 }else{
			 AddPainel(BfPlanilha,1, objDef.bfTabLinIni, objDef.iTelaLarg, objDef.AltTabela);
		 }
		 
		 Planilha.setModel(ModeloTab); 				// Modelotab - variavel Global 
		 Planilha.setAutoResizeMode(JTable.AUTO_RESIZE_OFF);
		 
		 Planilha.addRowSelectionInterval(0, 0);	//Seleciona a linha
		 Planilha.setFont( new Font("arial", Font.PLAIN, 12) );
		 

		// Alinha Texto da coluna à esquerda
		DefaultTableCellRenderer cellRender = new DefaultTableCellRenderer(); 
		
		cellRender.setHorizontalAlignment(SwingConstants.LEFT);			
		Planilha.getColumnModel().getColumn(objDef.colTEND).setCellRenderer(cellRender);	// Alinha a esquerda
		Planilha.getColumnModel().getColumn(objDef.colRESULTADO).setCellRenderer(cellRender);	// Alinha a esquerda
		
					

		 // CORES		 
		 Planilha.setSelectionForeground(Color.BLACK); 	// Texto da linha selecionada
		 Planilha.setForeground(Color.BLACK);  			// texto
		 Planilha.setBackground(Color.WHITE); 			// Fundo		  
		 Planilha.setShowGrid(true);						// Linhas de Grade
		 
		// Planilha.setOpaque(true);
			
			
		 //---------------------------------------------------------------------
		 // Cores: Sim, Não, Analisado
			Planilha.getColumnModel().getColumn(objDef.colRESULTADO).setCellRenderer(new RenderCorOpcao());		
		
		// Rederizar Listras - não esta renderizando após tirar 4x4(modens)
			for(int iC=1; iC < Planilha.getColumnCount(); iC++){
				Planilha.getColumnModel().getColumn(iC).setCellRenderer(new RenderListras());
			}
			
			// Cor da linha selecionada(seleção)
			// Planilha.setSelectionBackground(Color.cyan); 
		 //--------------------------------------------------------------------------------------
		 // Alinhamento do texto
		 Planilha.setDefaultRenderer(Object.class, new RenderAlinhaTexto()); // Centraliza o texto(completo)
		
		//---------------------------------------------------------------------
		
		 
		 /***************************************************************************/
		 //--------------------------------------------------------------------------
		 // Inclui Cx de Seleção nas células[Ambos, PPPoA, PPPoE] - [Sim, Não, OK, Sml] 
		 // +1: Ajuste necessario após congelar coluna "N"(passou ter 2 colunas endereçadas como Zero
	    // Planilha.getColumnModel().getColumn(objDef.colRESULTADO + 1).setCellEditor(CxSelTeste);
	     Planilha.getColumnModel().getColumn(objDef.colSTATUS + 1).setCellEditor(CxSelProtocol);
	     //--------------------------------------------------------------------------
		 // Filtro de Classificação das Celulas - A-Z, Z-A		 
	     final TableRowSorter<TableModel> sorter =  new TableRowSorter<TableModel>(ModeloTab);
		 Planilha.setRowSorter(sorter);
		 
		
      //--------------------------------------------------------------------------
      // Cria Filtro de conteudos da Planilha
      Planilha.setSelectionMode(ListSelectionModel.SINGLE_SELECTION);
      
      // Attach a list selection listener to the jtPlanilha's selection tmModelo, to
      // be notified whenever the user selects a row. Use this opportunity to
      // output the view and tmModelo indices on the status label.
      ListSelectionListener lslCapturaSelecao;
      lslCapturaSelecao = new ListSelectionListener(){
                public void valueChanged(ListSelectionEvent lse){
                   int index = Planilha.getSelectedRow();
                   if (index != -1){
                       String status;
                       status = "Ver índice = " + index + ", Modelo do índice = ";
                       status += Planilha.convertRowIndexToModel(index);
                       lblStatus.setText(status);
                   }
                }
            };
      Planilha.getSelectionModel().addListSelectionListener(lslCapturaSelecao);

      // Cria e instala rotinas de filtragem
      final TableRowSorter trsClassificar;
      trsClassificar = new TableRowSorter(ModeloTab);
      Planilha.setRowSorter(trsClassificar);
      
      // Fill northern region of GUI with scrollpane.
      getContentPane().add(BRolagemPlanilha, BorderLayout.NORTH);

      ActionListener alCapturarAcao;
      alCapturarAcao = new ActionListener(){
               public void actionPerformed(ActionEvent e){
            	  
            	//   ModeloTab.removeRow(objDef.iTotalLinTab);	// Remove Linha selecionada
            	   
            	    
            	   /*
            	    * Devido a falhas que ocorrem com: 
            	    * 4 modens, mas 2 linhas = travamento
            	    * As linhas abaixo inserem linhas adicionais a tabela 
            	    * no momento da filtragem
            	    *  
            	    */
            	   
            	  // objCxD.Aviso("Total de Lin(antes): " + objDef.iTotalLinTab, true);
            	   
            	   //---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            	   /*
            	    *  Usado na aplicação do Filtro
            	    *  - A idéia aqui era inserir 2 linhas com mesmos dados do filtro("Filtrar: " + tfFiltrar.getText())
            	    *  		para entrar na filtragem, assim 2 linhas a mais seriam adicionadas, e aparecem no filtro 
            	    *  		o problema é que estas linhas adicionadas, não saem após tirar o filtro 
            	    *  		e a tabela vai incrementado linhas adicionais, a cada uso do filtro 
            	    * BUG:
            	    *  - Aplica-se filtro e fica somente 3 linhas 
            	    *  - Ao Exec. o testes qdo chega na 4 Linha o sistema trava 
            	    *  
            	    *  - Qdo usa a rotina alterar uma linha, ao invez de inserir linhas com: 
            	    *  		- Planilha.setValueAt("Filtro: 02/", 100, objDef.colRESULTADO);
            	    *  		funciona, mas na volta do filtro, trava
            	    */
            	   
            	   /*
            	   if(tfFiltrar.getText() != ""){
            		//  String[] sLinhas = new String[]{ "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "Filtrar: " + tfFiltrar.getText() };
            		//  ModeloTab.addRow(sLinhas); 		// Adiciona linha pre-formatada acima(com texto de filtro), a matriz
            		  Planilha.setValueAt("Filtro: " + tfFiltrar.getText(), 100, objDef.colRESULTADO);
            	   }
            	   */
            	   
            	   // ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            	  /*
            	   * Esta rotina trava filtro ao retornar a Plan-Full
            	   if(tfFiltrar.getText() != ""){
            		   Planilha.setValueAt(tfFiltrar.getText().toString(), 10, objDef.colREG);
            	   }
                   */
            	  
            	   /*
            	   if(tfFiltrar.getText()!=""){  objDef.bFiltroAplicado = true; }
            	   else{  objDef.bFiltroAplicado = false; } 
            	  */
            	   objLog.Metodo("jxTMain().BtnFiltrar().click()"); 
                  // Install a new row filter.
                  String FiltrarExpressao = tfFiltrar.getText();
                  
                  trsClassificar.setRowFilter(RowFilter.regexFilter(FiltrarExpressao));
				
                  // Unsort the view.
                  trsClassificar.setSortKeys(null);
                  
                  /*
                   *  Atualiza núm.registros visíveis na tabela, após filtro
                   *  Usado pelo sistema para calculos de varredura de linhas na tabela
                   */
                  objDef.fixeTotalLinTab(trsClassificar.getViewRowCount()); 
                  
                  
                 // objCxD.Aviso("Total de Lin: " + objDef.iTotalLinTab, true);
               }
           };
      BtnFiltrar.addActionListener(alCapturarAcao);		// Filtro de pesquisa
     
      // Create a status label for presenting the view and tmModelo indices for
      // the selected row.
      lblStatus = new JLabel(" ", JLabel.CENTER);

      // Fill southern region of GUI with status label.
      getContentPane().add(lblStatus, BorderLayout.SOUTH);

      // Wrap an empty bdBorda around the GUI for aesthetic purposes.
    //  Border bdBorda = BorderFactory.createEmptyBorder(10, 10, 10, 10);
     // getRootPane().setBorder(bdBorda);

      // Resize the GUI to its preferred size.
      pack();	// Não vi diferença !!!!

      /***************************************************************************/
      
		 int iNumLinTab = Planilha.getRowCount();			// Pega o número de linhas
		
		  //Ajusta largura de todas as colunas - padrão
		//  TableColumn colTAB = Planilha.getColumnModel().getColumn(1);
		 // int width = 100;
		 // colTAB.setPreferredWidth(width);
		 
		 // ---------------------------------------------------------------------------------------
		 // Ajusta largura PADRÃO da coluna(N)   
		 Planilha.getColumnModel().getColumn(objDef.colN).setPreferredWidth(50);	// Preferencial
		
		// Ajusta altura de todas as linha
		 Planilha.setRowHeight(objDef.iAlturaLinTab); 		 

		 // Congela coluna "N"
		 RenderCongelarColuna objCongelar = new RenderCongelarColuna(1, BRolagemPlanilha);  
		 Planilha.setAutoResizeMode(Planilha.AUTO_RESIZE_OFF); 
		 /********************************************************************************/
		 // Objeto Centralização de conteudo
		 DefaultTableCellRenderer centerRenderer = new DefaultTableCellRenderer();
		 centerRenderer.setHorizontalAlignment( JLabel.CENTER );
		 
		 // Seta todas as colunas para centralizar conteudo
		 for(int iCt=0; iCt <= objDef.iTotColunaTab; iCt++){ 			 		
			 
			 Planilha.getColumnModel().getColumn(iCt).setCellRenderer( centerRenderer );	// Centraliza conteudo em todas as colunas
			 Planilha.getColumnModel().getColumn(iCt).setPreferredWidth(65); // Seta-largura padrao para todas as colunas
				
		 }
		 // Ajusta coluna data um pouco mais larga
		 Planilha.getColumnModel().getColumn(objDef.colSEPARADOR).setPreferredWidth(3);	// Preferencial
		 Planilha.getColumnModel().getColumn(objDef.colSTATUS).setPreferredWidth(80);	// Preferencial
		 Planilha.getColumnModel().getColumn(objDef.colDATA).setPreferredWidth(80);	// Preferencial

		 // ---------------------------------------------------------------------------------------
		// Carregar(Add) linhas na Planilha
		objLog.Metodo("jxTMain().Add-Lin-Tab: " + objDef.pegueTotalLinTab());
		for(int iL=0; iL <= objDef.pegueTotalLinTab(); iL++){ 
			int iLx = iL + 1;
			ModeloTab.addRow(objDef.sTabLinhas); 		// Adiciona linha pre-formatada de matriz
			//Planilha.setValueAt(iLx, iL, objDef.colN);		// Numera Linhas
		}
		
		// Adiciona barra de rolagem a Bar.Ferramentas	 
		BfPlanilha.add(BRolagemPlanilha);	
		
				
		 // Pega click do mouse na PlanilhaComum
		 Planilha.addMouseListener(new MouseAdapter() {  
	            @Override  
	             public void mouseClicked(MouseEvent e) {
	            	// Botão Direito(1) do mouse
	            	if(e.getButton()==1){
	            		int iLin = Planilha.getSelectedRow() + 1;
	            		int iCol = Planilha.getSelectedColumn() + 1;
	            		//String sC = objUtil.NumToChar(iCol-1);
	            		//tfCoord.setText( sC + iLin );
	            		
	            		tfCoord.setText( objUtil.LinToSeqMd(Planilha.getSelectedRow()) );				// Atualiza coordenadas
	            		        	
	            		//tfCelula.setText( sC + iLin );	//[A1]
	            		tfCelula.setText( Planilha.getColumnName(iCol-1) + " [" +iLin + "]");	// Porta[1]	               
	            		tfTitulo.setText( Planilha.getColumnName(iCol-1) + " " +iLin + "]");	               	
	            		tfConteudo.setText( Planilha.getValueAt(Planilha.getSelectedRow(), Planilha.getSelectedColumn() ).toString() ); 
					
	            		objLog.Metodo("jxTMain().Planilha.addMouseListener(new MouseAdapter()");				
	            	}
	            	// Botão esquerdo(3) do mouse
	            	if(e.getButton()==3){
	            			/*
	            			 * ModeloTab.removeRow(iLinSelecionada);	// Remove Linha selecionada
	            			 * ModeloTab.addRow(objDef.sTabLinhas); 	// Adiciona linha pre-formatada de matriz
	            			*/
	            		
	            		            		
	            		/******************************************************************************/
	            		
	            		// Menu PopUp
	            		final JPopupMenu Pmenu;
	            		JMenuItem menuItem;
	            		  
	            			  Pmenu = new JPopupMenu();
	            			  
	            			  menuItem = new JMenuItem("Desfazer excluir", new ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnDesfazer16.png"));
	            			  Pmenu.add(menuItem);
	            			  menuItem.addActionListener(new ActionListener(){
	            				  public void actionPerformed(ActionEvent e){
	            					  
	            					  int iTReg = objUtil.ContarReg(Planilha);	// Conta numero de registros na tabela
	            				    	if( iTReg > 1){							// Verifica NumReg
	            				    		
	            				    		if(objUtil.bDesfazer){
	            				    			DesfazerExcluir();	            				    		
	            				    		}else{
	            				    			objCxD.Aviso("Não há registros a serem recuperados.", true);
	            				    		}
	            				    		
	            				     	}else{ objCxD.Aviso("Não há registros a serem recuperados.", true); }

	            					  
	            				  }	            				
	            			  });  
	            			  
	            			  menuItem = new JMenuItem("Excluir linha", new ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnExcluirLinha16.png"));
	            			  Pmenu.add(menuItem);
	            			  
	            			  menuItem.addActionListener(new ActionListener(){
	            				  public void actionPerformed(ActionEvent e){
	            						int iTReg = objUtil.ContarReg(Planilha);	// Conta numero de registros na tabela
	            				    	if( iTReg > 1){							// Verifica NumReg	            				    
	            				    		  int iLinSelecionada = Planilha.getSelectedRow();
	    	            					  int iLinNum = iLinSelecionada + 1; 	// Devido diferença entre linhas: 0(Sistema), 1(usuário)
	    	            					  if(objCxD.Confirme("Excluir a linha " + iLinNum + "("+ Planilha.getValueAt( iLinSelecionada, 0) +"...) da tabela ?", objDef.bMsgExcluir)){
	    	            						  	DeletarLinha(iLinSelecionada);	    	            						  	
	    	            					  }
	    	            				}else{ objCxD.Aviso("Não há registros a serem excluidos.", true); }
			  }	            				
	            			  });
	            			  
	            			 // Pmenu.addSeparator();
	            			  
	            			  menuItem = new JMenuItem("Inserir cotação", new ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnAddLinha16.png"));
	            			  Pmenu.add(menuItem);
	            			  menuItem.addActionListener(new ActionListener(){	            				  
	            				  public void actionPerformed(ActionEvent e){
	            					  
	            					  int iTReg = objUtil.ContarReg(Planilha);	// Conta numero de registros na tabela
	            				    	if( iTReg > 1){							// Verifica NumReg	            				    
	            				    		 int iLinSel = Planilha.getSelectedRow();	  	            					  
		            						 InserirLin(iLinSel);
	            				    	}else{ objCxD.Aviso("Não há registros a serem movidos.", true); }
      				  }	            				
	            			  });
	            			  
	            			  Pmenu.addSeparator();
	            			  
	            			  menuItem = new JMenuItem("Limpar planilha", new ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnLimpar16.png"));
	            			  Pmenu.add(menuItem);
	            			  menuItem.addActionListener(new ActionListener(){
	            				  public void actionPerformed(ActionEvent e){	
	            						int iTReg = objUtil.ContarReg(Planilha);	// Conta numero de registros na tabela
	            						objDef.fixeNumRegMetaTrader(iTReg);
	            						
	            						if( iTReg > 1){							// Verifica NumReg	            				    
	            				    		  if(objCxD.Confirme("Apagar todos os registros da tabela?", objDef.bMsgExcluir)){
	    	            						 // objUtil.LimparPlanilha(Planilha);
	    	            						  //LimparItensFiltro("Filtrar campos...");
	    	            						  LimparPlanilha(objDef.pegueNumRegMetaTrader());
	    	            						  objDef.fixeNumRegMetaTrader(0);	// Limpou....zera info
	    	            					  }
	            				     	}else{ objCxD.Aviso("Não há registros a serem excluidos.", true); }

	            					
	            				  }	            				
	            			  });  
	            			  
	            			  Pmenu.addSeparator();
	            			  
	            			  menuItem = new JMenuItem( "Salvar", new ImageIcon(objDef.DirRoot + "imagens/Icon_btn/Btnsalvar16.png") );
	            			  Pmenu.add(menuItem);
	            			  menuItem.addActionListener(new ActionListener(){
	            				  public void actionPerformed(ActionEvent e){	
	            					  int iTReg = objUtil.ContarReg(Planilha);	// Conta numero de registros na tabela
	            				    	if( iTReg > 1){							// Verifica NumReg	            				    
	            				     	
	            				    	}else{ objCxD.Aviso("Não há registros a serem salvos.", true); }
	            				  }	            				
	            			  });  
	            			  
	            			  Pmenu.addSeparator();
	            			  
	            			  if(objDef.pegueSaltarFinalTab()){
	            				  menuItem = new JMenuItem("Saltar", new ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnVoltar16.png"));
	            			  }else{
	            				  menuItem = new JMenuItem("Saltar", new ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnSaltar16.png"));
	            			  }
	            			  Pmenu.add(menuItem);
	            			  menuItem.addActionListener(new ActionListener(){
	            				  public void actionPerformed(ActionEvent e){	
	            					
	            					  Saltar();
	            					
	            				  }	            				
	            			  });  
	            			  
	            			  
	            			  menuItem = new JMenuItem("Propriedades", new ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnPropriedades16.png"));
	            			  Pmenu.add(menuItem);
	            			  menuItem.addActionListener(new ActionListener(){
	            				  public void actionPerformed(ActionEvent e){	
	            					  objFrmPropriedadesTab.Construir();
	            				  }	            				
	            			  });  
	            			  
	            			  Planilha.addMouseListener(new MouseAdapter(){
	            				  public void mouseReleased(MouseEvent Me){
	            					  if(Me.isPopupTrigger()){
	            						  Pmenu.show(Me.getComponent(), Me.getX(), Me.getY());
	            					  }
	            				  }
	            			  });
	            		              	     
	            		/******************************************************************************/
	            	}
	            	
	             }              
	        }); 
		 Planilha.addKeyListener(new java.awt.event.KeyAdapter() {             
	            public void keyReleased(java.awt.event.KeyEvent evt) {  
	                if(evt.getKeyCode()==evt.VK_RIGHT   
	                || evt.getKeyCode()==evt.VK_LEFT  
	                || evt.getKeyCode()==evt.VK_UP
	                || evt.getKeyCode()==evt.VK_DOWN
	                || evt.getKeyCode()==evt.VK_END
	                || evt.getKeyCode()==evt.VK_HOME
	                || evt.getKeyCode()==evt.VK_PAGE_UP
	                || evt.getKeyCode()==evt.VK_PAGE_DOWN
	                || evt.getKeyCode()==evt.VK_TAB){  
	                    
	                	int iLin = Planilha.getSelectedRow() + 1;
		            	int iCol = Planilha.getSelectedColumn() + 1;
		            	//String sC = objUtil.NumToChar(iCol-1);		            	
		               	//tfCoord.setText( sC + iLin );        	
		               	// tfCelula.setText( sC + iLin );
		            	
		    			
		    			tfCoord.setText( objUtil.LinToSeqMd(Planilha.getSelectedRow()) );				// Atualiza coordenadas

		               	tfCelula.setText( Planilha.getColumnName(iCol-1) + " [" +iLin + "]");	// Porta[1]
		               	tfTitulo.setText( Planilha.getColumnName(iCol-1) + " [Lin: " +iLin + "]");		               
		              	tfConteudo.setText( Planilha.getValueAt(Planilha.getSelectedRow(), Planilha.getSelectedColumn() ).toString() ); 
						objLog.Metodo("jxTMain().Planilha.addKeyListener(new java.awt.event.KeyAdapter()");
	                }  
	            }             
	        });  
		
	}
	

	/******************************************************************************************************/
	public void ConstruirBfTelnet(){	 
		
		objLog.Metodo("jxTMain().ConstruirBfTelnet()");
		 // Criar a barra 
		 BarFerTelnet.setFloatable(true);	 
		 BarFerTelnet.setRollover(true);
		// 						, ColIni, LinIni, Largura, Altura
		 AddPainel(BarFerTelnet, objDef.taTelnetCol, objDef.TAreaLin, objDef.TAreaLarg, objDef.TAreaAlt);	
		 
		// JTextArea taTelnet = new JTextArea();
		 taTelnet.setBackground(new java.awt.Color(0, 0, 0));			// Cor de fundo
	     taTelnet.setColumns(60);										// Numero de colunas
	     taTelnet.setFont(new java.awt.Font("Courier New", 0, objDef.iTamTexto)); 	// Fonte: tipo, tamanho
	     taTelnet.setForeground(new java.awt.Color(0, 255, 0));
	     taTelnet.setRows(15);											// Num.de linhas
	     taTelnet.setMinimumSize(new java.awt.Dimension(40, 20));		//    
		 BarFerTelnet.add(BRolagemTArea);
		 
		// Pega click do mouse na taTelnet
		 taTelnet.addMouseListener(new MouseAdapter() {  
	            @Override
	             public void mouseClicked(MouseEvent e) {
	               	// Botão esquerdo(3) do mouse
	            	if(e.getButton()==3){
	            			/*
	            			 * ModeloTab.removeRow(iLinSelecionada);	// Remove Linha selecionada
	            			 * ModeloTab.addRow(objDef.sTabLinhas); 	// Adiciona linha pre-formatada de matriz
	            			*/
	            		
	            		            		
	            		/******************************************************************************/
	            		
	            		// Menu PopUp
	            		final JPopupMenu Pmenu;
	            		JMenuItem menuItem;
	            		
	            		
	            			  Pmenu = new JPopupMenu();
	  
	            			  menuItem = new JMenuItem("ZoomOn", new ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnZoomOn16.png"));
	            			  Pmenu.add(menuItem);
	            			  menuItem.addActionListener(new ActionListener(){	            				  
	            				  public void actionPerformed(ActionEvent e){
	            					  objDef.IncTamTexto(true, 1);
	            					  taTelnet.setFont(new java.awt.Font("Courier New", 0, objDef.iTamTexto)); 	// Fonte: tipo, tamanho
	            					  tfBarraStatus.setText("Texto: " + objDef.iTamTexto);
	            			      }	            				
	            			  });
	            			  menuItem = new JMenuItem("ZoomOff", new ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnZoomOff16.png"));
	            			  Pmenu.add(menuItem);
	            			  menuItem.addActionListener(new ActionListener(){	            				  
	            				  public void actionPerformed(ActionEvent e){
	            					  objDef.IncTamTexto(false, 1);
	            					  taTelnet.setFont(new java.awt.Font("Courier New", 0, objDef.iTamTexto)); 	// Fonte: tipo, tamanho
	            					  tfBarraStatus.setText("Texto: " + objDef.iTamTexto);
	            			      }	            				
	            			  });
	            			 
	            			  taTelnet.addMouseListener(new MouseAdapter(){
	            				  public void mouseReleased(MouseEvent Me){
	            					  if(Me.isPopupTrigger()){
	            						  Pmenu.show(Me.getComponent(), Me.getX(), Me.getY());
	            					  }
	            				  }
	            			  });
	            		              	     
	            		/******************************************************************************/
	            	}
	            	
	             }              
	        });        
	        
	}

	/******************************************************************************************************/
	// Grafico
	
	public void ConstruirBfGrade(){	 
		
     objLog.Metodo("jxTMain().ConstruirBfGrade()");
     
      gGrafico.setBackground(Color.black);

		 AddPainel(gGrafico, objDef.bfGraficoCol, objDef.bfGraficoLin, objDef.bfGraficoLarg, objDef.TAreaAlt);	
	        
		// Pega click do mouse na gGraficoComum
				 gGrafico.addMouseListener(new MouseAdapter() {  
			            @Override
			             public void mouseClicked(MouseEvent e) {
			               	// Botão esquerdo(3) do mouse
			            	if(e.getButton()==3){
			            			/*
			            			 * ModeloTab.removeRow(iLinSelecionada);	// Remove Linha selecionada
			            			 * ModeloTab.addRow(objDef.sTabLinhas); 	// Adiciona linha pre-formatada de matriz
			            			*/
			            		
			            		            		
			            		/******************************************************************************/
			            		
			            		// Menu PopUp
			            		final JPopupMenu Pmenu;
			            		final JMenuItem menuItem;
			            				            		
			            			  Pmenu = new JPopupMenu();
			  
			            			  menuItem = new JMenuItem("ZoomOn", new ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnZoomOn16.png"));
			            			  Pmenu.add(menuItem);
			            			  menuItem.addActionListener(new ActionListener(){	            				  
			            				  public void actionPerformed(ActionEvent e){
			            					  if(objDef.bZoom){
			            						  objDef.bZoom = false;
			            						  menuItem.setIcon(new ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnZoomOn16.png"));
			            						  menuItem.setText("ZoomOn");
			            						
			            					  }else{
			            						  objDef.bZoom = true;
			            						  menuItem.setIcon(new ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnZoomOff16.png"));
			            						  menuItem.setText("ZoomOff");
			            					  }
			            					  gGrafico.repinte(objDef.Linhas, objDef.bZoom);
			            			      }	            				
			            			  });
			            			 
			            			  gGrafico.addMouseListener(new MouseAdapter(){
			            				  public void mouseReleased(MouseEvent Me){
			            					  if(Me.isPopupTrigger()){
			            						  Pmenu.show(Me.getComponent(), Me.getX(), Me.getY());
			            					  }
			            				  }
			            			  });
			            		              	     
			            		/******************************************************************************/
			            	}
			            	
			             }              
			        }); 
		 
	}
	
	public void ConstruirBfGrafico2D(){
		/*
		// cria painel para desenhar grafico
		final Grafico2D_semUso gGrafico = new Grafico2D_semUso();
		
		//Exemplo
		 
		gGrafico.setTitulos("Amostras por Periodo", "Mes","Quantidade de Amostras");
		gGrafico.setParametros(30, "Jan.");
		gGrafico.setParametros(60, "Fev.");
		gGrafico.setParametros(25, "Mar.");
		gGrafico.setParametros(45, "Abr.");
		gGrafico.setParametros(115, "Mai.");
		gGrafico.setParametros(73, "Jun.");
		gGrafico.setParametros(87, "Jul.");
		gGrafico.setParametros(55, "Ago.");
		gGrafico.setParametros(19, "Set.");
		gGrafico.setParametros(90, "Out.");
		gGrafico.setParametros(45, "Nov.");
		gGrafico.setParametros(102, "Dez.");

		gGrafico.setTipoGrafico(1);	// 0: Col, 1: Linhas
		AddPainel(gGrafico, objDef.bfGraficoCol, objDef.bfGraficoLin, objDef.bfGraficoLarg, objDef.TAreaAlt);
		*/
	}
	/***********************************************************************/
	private void BtnTstVozActionPerformed(java.awt.event.ActionEvent evt) { 
		
			
		
	}
	
	public int SegToPos_sem_uso(int iS){
		// Retorna posição para os segundos informados
		int iPos = 0;
		 iPos = iS/10;
		
		return iPos;
		
	}



	/******************************************************************************************************/
	public void ConstruirBfSLine(){	 
		
     objLog.Metodo("jxTMain().ConstruirBfSLine()");
		 // Criar
		 BfSLine.setFloatable(true);	 
		 BfSLine.setRollover(true);
		 AddPainel(BfSLine, objDef.taSLineCol, objDef.TAreaLin, objDef.TAreaLarg, objDef.TAreaAlt);	// ColIni, LinIni, Largura, Altura
		 
		 taSLine.setBackground(new java.awt.Color(0, 0, 0));
	     taSLine.setColumns(60);
	     taSLine.setFont(new java.awt.Font("Courier New", 0, 10)); 
	     taSLine.setForeground(new java.awt.Color(0, 255, 0));
	     taSLine.setRows(15);
	     taSLine.setMinimumSize(new java.awt.Dimension(40, 20));
		  
		 BfSLine.add(BRolaSLine);
		 
	            
	        
	}
	
	/******************************************************************************************************/
	public void ConstruirBfLog(){	 
		
     objLog.Metodo("jxTMain().ConstruirBfLog()");
		 // Criar
		 BfLog.setFloatable(true);	 
		 BfLog.setRollover(true);
		 AddPainel(BfLog, objDef.taLogCol, objDef.TAreaLin, objDef.TAreaLarg, objDef.TAreaAlt);	// ColIni, LinIni, Largura, Altura
				
		 taLog.setBackground(new java.awt.Color(0, 0, 0));
	     taLog.setColumns(60);
	     taLog.setFont(new java.awt.Font("Courier New", 0, 10)); 
	     taLog.setForeground(new java.awt.Color(0, 255, 0));
	     taLog.setRows(15);
	     taLog.setMinimumSize(new java.awt.Dimension(40, 20));		   
		 BfLog.add(BRolaLog);
		 
	            
	        
}
	
/********************************************************************************************************************/
public void ConstruirBStatus(){
		
		objLog.Metodo("jxTMain().ConstruirBStatus()");
		
		BStatus.setFloatable(false);	 
		BStatus.setRollover(true);		
		
		AddPainel(BStatus, 1, objDef.iBStLinIni, objDef.iTelaLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
		
		JSeparator SeparaBStatus = new JSeparator();
		SeparaBStatus.setOrientation(SwingConstants.VERTICAL);
		BStatus.add(SeparaBStatus);


		BStatus.add(tfBarraStatus);
		tfBarraStatus.setColumns(50);
		tfBarraStatus.setText("jxTrader...L: " + objLicenca.pegueLicenca());
		tfBarraStatus.setEditable(false);	// Bloquear edição
		
}

public void ConstruirBStatus2(){
	
	objLog.Metodo("jxTMain().ConstruirBStatus2()");
	
	BStatus.setFloatable(false);	 
	BStatus.setRollover(true);		
	
	AddPainel(BStatusTeste, 1, objDef.iBStLinIni, 100, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
	AddPainel(BStatus, 100, objDef.iBStLinIni, objDef.iTelaLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
	
	JSeparator SeparaBStatusDesc = new JSeparator();
	SeparaBStatusDesc.setOrientation(SwingConstants.VERTICAL);
	BStatus.add(SeparaBStatusDesc);


	BStatusTeste.add(tfLedBarraStatus);
	tfLedBarraStatus.setForeground(Color.white);
	tfLedBarraStatus.setBackground(Color.decode("#008B00"));
	tfLedBarraStatus.setColumns(10);
	tfLedBarraStatus.setHorizontalAlignment(JTextField.CENTER);  
	tfLedBarraStatus.setText(objDef.sLedBarraStatusParar);	
	tfLedBarraStatus.setEditable(false);	// Bloquear edição
	
	
	BStatus.add(tfBarraStatus);
	//tfBarraStatus.setBackground(Color.LIGHT_GRAY);
	tfBarraStatus.setColumns(50);
	tfBarraStatus.setText("jxTrader...L: " + objLicenca.pegueLicenca());
	tfBarraStatus.setEditable(false);	// Bloquear edição
	
}


/********************************************************************************************************************/

	public void CarregarCbFiltro(){
	
		objLog.Metodo("jxTMain().CarregarCbFiltro()");
	
		int iNumLinTab = Planilha.getRowCount();			// Pega o número de linhas
		for(int iF=0; iF < iNumLinTab; iF++){
			//cbFiltro.addItem( PlanilhaComum.getValueAt(iF, PlanilhaComum.getSelectedColumn() ).toString() ); 
			if(Planilha.getValueAt(iF, 0) != ""){
				cbFiltro.addItem(Planilha.getValueAt(iF, 0));
			}
		}
	}

	
	public void LimparSequencia(int iSequencia){
	
		/*
		 *  Apaga registros de testes da sequencia atual
		 *  Preserva campos de importação e observação 
		 */
		
		objLog.Metodo("jxTMain().LimparSequencia(" + iSequencia +")");
		
		int iNumLinTab = Planilha.getRowCount();	
		int iNumColTab = Planilha.getColumnCount() - 1;		// (-1)Preserva campo obs
		
		
		
		for(int iM=0; iM < 4; iM++){
			int iLinDaSeq = objUtil.SeqToLin(iSequencia, iM);
			
			/*
			 *  Verifica se Col-Porta possui registro
			 *  Caso Sim: seta col-Ação = Testar
			 *  Caso Não: Pula
			 *  
			 *  Evita habilitar testes("Testar") na sequência de ações:
			 *  Repetir testes no final dos registros de uma seu~enci incompleta
			 *   
			 */
			if(Planilha.getValueAt(iLinDaSeq, objDef.colDATA).toString().contains("20")){
				Planilha.setValueAt("objDef.AcaoTestar", iLinDaSeq, objDef.colRESULTADO);		// Seta coluna Testar = Sim
			}
			for(int iC=8; iC < iNumColTab; iC++){
				 Planilha.setValueAt("", iLinDaSeq, iC);	// Limpa colunas do testes anterior
			}
		}
		
	}
	
	private void LimparAnalise(){
		
		/*
		 *  Apaga registros de testes da sequencia atual
		 *  Preserva campos de importação e observação 
		 */
		
		objLog.Metodo("jxTMain().LimparAnalise()");
		
	
		int iLinIni = objDef.pegueNumRegMetaTrader() - objDef.pegueComboNumRegistro();
		 
		
		
		for(int iLinDaSeq = iLinIni; iLinDaSeq < objDef.pegueNumRegMetaTrader(); iLinDaSeq++){
			for(int iC=objDef.colTEND; iC < objDef.colVAR_M; iC++){
				 Planilha.setValueAt("", iLinDaSeq, iC);	// Limpa colunas do testes anterior
			}
		}
		
	}

	private void LimparPlanilha(int iTotLin){
		
		/*
		 *  Apaga registros de testes da sequencia atual
		 *  Preserva campos de importação e observação 
		 */
		
		objLog.Metodo("jxTMain().LimparPlanilha("+iTotLin+")");
		
		int iNumLinTab = Planilha.getRowCount();	
		int iNumColTab = Planilha.getColumnCount() - 1;		// (-1)Preserva campo obs
		
		
		
		for(int iLinDaSeq=0; iLinDaSeq < iTotLin; iLinDaSeq++){
			for(int iC=objDef.colTEND; iC < objDef.colVAR_M; iC++){
				 Planilha.setValueAt("", iLinDaSeq, iC);	// Limpa colunas do testes anterior
			}
		}
		
	}
	
	public void LimparItensFiltro(String sTexto){
		
		objLog.Metodo("jxTMain().LimparFiltro()");
		
		cbFiltro.removeAllItems();	// Deleta itens da combo filtrar
		cbFiltro.addItem(sTexto);		
		
		cbCodEmpresa.setSelectedIndex(0);
		tfOpen.setText("");
		//cbSlot.setSelectedIndex(0);
		cbTimeM15.setSelectedIndex(0);
		//cbPorta.setSelectedIndex(0);
		tfDataCota.setText(Formatar.format(data));
		//cbProtocolo.setSelectedIndex(0);
		//cbBloco.setSelectedIndex(0);
		//cbVt.setSelectedIndex(0);
		//cbHz.setSelectedIndex(0);
		//cbPino.setSelectedIndex(0);
		tfHigh.setText("");
		
	}

	public void CriarCSV(){
		
	// Pega dados da tabela e formata linha a linha em CSV(separados por virgula)	
		objLog.Metodo("jxTMain().CriarCSV()");
		
		int iNumCol = Planilha.getColumnCount();
		int iNumLin = Planilha.getRowCount();
		String sLinhaCSV = objDef.sTabTitulo;
		objUtil.SalvarCSV(sLinhaCSV);	// Salva linha em arquivo
		sLinhaCSV = "";					// Limpa linha(Titulos da Tab)
				
		for(int iL=0; iL<iNumLin; iL++){
			for(int iC=0; iC<iNumCol; iC++){
				sLinhaCSV = sLinhaCSV + Planilha.getValueAt(iL, iC) + ";";
			}
			objUtil.SalvarCSV(sLinhaCSV);	// Salva linha em arquivo
			sLinhaCSV = "";					// Limpa linha
		}
		
		/*
		180x42
		52x11
		1/2/10 autenticacao, porta dedicada
		*/
	}

	
 public void CarregarExcel() throws BiffException, IOException
 {
 	/* A rotina abaixo não funcionou em classe separada,
 	 * ocorreu alguma falha ao transferir valores p/ sCelulas[][].
 	 * então...ficou como método local
 	 * - throws BiffException, IOException: é exigido pela classe WorkBook, 
 	 * 		que também exige um tratamento de exceção(try, catch) ao chamar o método;  
 	 * PGO - 15jul2014  	 
 	 */
 	     	
 	String sDir = objArquivo.DialogAbrir("xls");			// Chama OpenDialog
 	
 	objLog.Metodo("mtaView(aki).CarregarExcel("+ sDir +")");
 	
 	//objDef.FixePlanCorrente(sDir);	// Atualiza var
 	objArquivo.FixeAbreDirArq(sDir);
 	
 	/* Carrega a planilha */
 	 Workbook objLivroDeTrabalho = Workbook.getWorkbook(new File(sDir));

     Sheet sheet = objLivroDeTrabalho.getSheet(0);
     
     /* Pega Numero de linhas com dados do xls */
     // Fica memorizado para salvar arquivo INI, etc 
     objDef.iMemNumLin = sheet.getRows(); 
     objDef.iMemNumCol = sheet.getColumns();
     
             
    // Carrega Planilha
     for(int iL = 0; iL < objDef.iMemNumLin; iL++){
         for(int iC = 0; iC < objDef.iMemNumCol; iC++){	// Inicia em 1, pois a 0 já esta numerada
         	int iColTab = iC + 1;
             Cell celula = sheet.getCell(iC, iL);
            	Planilha.setValueAt( celula.getContents(), iL, iC);
         }
         int iLx = iL + 1;
         // NumerarLinhas 	// Numera linhas da Planilha
         Planilha.setValueAt( "objDef.AcaoTestar", iL, objDef.colRESULTADO);		// Numera linhas da Planilha
         
         
         // Cores: Listras(Linha-sim, linha não)
			for(int iC=1; iC < Planilha.getColumnCount(); iC++){
				Planilha.getColumnModel().getColumn(iC).setCellRenderer(new RenderListras());
			}
			
			
			// ModeloTab.addRow(objDef.sTabLinhas);			// Adiciona Linha a tabela
		  
     }  
    
   
     
 }  // CarregarExcel()
 

 public void backupMTA(String sDirNome){
 	
 	objLog.Metodo("jxTMain().backupMTA("+ sDirNome +")");
 	
 	try{
 		
 		IniFiles objArqIni = new IniFiles();
 		for(int iL=0; iL < objDef.iMemNumLin; iL++){
				for(int iC=0; iC < objDef.iTotColunaTab; iC++){
					
					String sChave = objUtil.NumToChar(iC) + String.valueOf(iL);
					objArqIni.EscreverIni(sDirNome, "Mta", sChave, Planilha.getValueAt(iL, iC).toString());
				
				}			
			}
 		
 	
 		
 	
 	}catch(IOException e){
 		objLog.Metodo("jxTMain().salvarMTA().IniFiles(Erro ao gravar Arquivo)");
 	}finally{
 		objCxD.Aviso("Arquivo mta Salvo !", objDef.bMsgSalvar);
 	}
 	
 }
 
 public void LerTArea(int iVersao, int iModem, int iTipo, int iLinMd){
 
 	objLog.Metodo("jxTMain().LerTArea(V: "+iVersao+" Md: "+iModem+", Teste: "+iTipo+", LinMD: "+iLinMd+")");
		
		
 	String sLinTxt[] = taTelnet.getText().split("\n"); 
 	int iTam = sLinTxt.length;
 	objLog.Metodo("LerTArea(Num.Lin: " + iTam + " )");
 	objLog.Metodo("------------------------------------------------------");
 	
 	/*
 	for(int iL=0; iL<iTam; iL++){    		
 	//	if(iVersao == objDef.HubDLink){ objDLinkOpticom.Decode(iTipo, Planilha, iLinMd, sLinTxt[iL]); }
 	//	if(iVersao == objDef.Dsl2500e){ objDsl2500e.Decode(iTipo, Planilha, iLinMd, sLinTxt[iL]); } 
 		
 	} 
 	*/
 	
 	VerificarDecode(iModem, iLinMd);
 	
 }
 
 public void VerificarDecode(int iModem, int iLinMD){
 	/*
	 // Verifica resultado do decode...
 	objLog.Metodo("------------------------------------------------------");
 	objLog.Metodo("VerificarDecode(LinMD: "+iLinMD+")");
 	
 	String sMinAj = "00";
 	String sSegAj = "00";
 	
 	// VER.SINCRONISMO
 	String sSin = Planilha.getValueAt(iLinMD, objDef.colSINC).toString();
 	if( sSin.toLowerCase().contains("up") ){ 
 		 
 		
 		if(!objUtil.bSinc[iModem]){
 				
 				*
 				 * Ajusta diferença de tempos
 				 * As Leiturasde cada modem inicia com 15 segundos de diferença
 				 * então, ajusta tempos
 				 *
 				// Carrega Tempo decorrente para sincronizar
 				String sTempoAjustado = objUtil.AjusteTempo(iModem, 15, PegueSeg(), PegueMin());
 				Planilha.setValueAt(sTempoAjustado, iLinMD, objDef.colSincT);
 			
 				AtualizarGrafico(iModem, iLinMD, objDef.STATUS);
 				
     		}
     		
 			objUtil.bSinc[iModem] = true;		// Informa ctrl que esta sincronizado
 			objLog.Metodo("LerTArea(bSinc["+iModem+"] = true," + sSin + ")"); 
 			
 	}else{
 		
 		objUtil.bSinc[iModem] = false;
 		objLog.Metodo("LerTArea(bSinc["+iModem+"] = false," + sSin + ")");
 		
 	}
 	
 	// VER.AUTENTICAÇÃO
 	String sAut = Planilha.getValueAt(iLinMD, objDef.colAUTH).toString();
 	if( sAut.toLowerCase().contains("up") ){ 
 		 
 		if(!objUtil.bAuth[iModem]) {
 			
 			// Carrega Tempo decorrente
 			String sTempoAjustado = objUtil.AjusteTempo(iModem, 15, PegueSeg(), PegueMin()); 			
 			Planilha.setValueAt(sTempoAjustado, iLinMD, objDef.colAutT);
 			
 			AtualizarGrafico(iModem, iLinMD, objDef.AUTH); 			
		}
 		objUtil.bAuth[iModem] = true;	// Informa CTRL que esta autenticado
 		objLog.Metodo("LerTArea(bAut["+iModem+"] = true," + sAut +")" );
 		
 	}else{
 		
 		objUtil.bAuth[iModem] = false;
 		objLog.Metodo("LerTArea(bAut["+iModem+"] = false," + sAut +")" );
 		
 	}
 	
 	// Ver.NAVEGAÇÃO(ping)
 	String sNav = Planilha.getValueAt(iLinMD, objDef.colNAV).toString();
 	if( sNav.toLowerCase().contains("up") ){ 
 		
 		if(!objUtil.bPing[iModem]){

 			// Carrega Tempo decorrente
 			String sTempoAjustado = objUtil.AjusteTempo(iModem, 15, PegueSeg(), PegueMin());
 			Planilha.setValueAt(sTempoAjustado, iLinMD, objDef.colNavT);
 			
 			AtualizarGrafico(iModem, iLinMD, objDef.PING);
 		}
 		objUtil.bPing[iModem] = true;  //  CTRL que esta navegando
 		objLog.Metodo("LerTArea(bPing["+iModem+"] = true," + sNav +")" );
 		
 		
 	}else{
 		
 		objUtil.bPing[iModem] = false;
 		objLog.Metodo("LerTArea(bPing["+iModem+"] = false," + sNav +")" );
 		
 	}
 	
 	*/
	
 }
 
 public void AtualizarGrafico(int iModem, int iLinMD, int iQuem){
	 
	 objLog.Metodo("jxTMain().AtualizarGrafico("+iModem+", "+iLinMD+")");
	 
	// Atualiza gráfico
	 	int iSrUP = 0;
	 	int iSrDN = 0;
	 	int iAtUP = 0;
	 	int iAtDN = 0;
	 	int iCrcUP = 0;
	 	int iCrcDN = 0;
	 	int iTSinc = 0;
	 	int iTAut = 0;
	 	int iTNav = 0;
	 	
	 	if(iQuem == objDef.STATUS){
	 		/*
	 		iSrUP = (int)Double.parseDouble(Planilha.getValueAt(iLinMD, objDef.colSrUP).toString());
	 		iSrDN = (int)Double.parseDouble(Planilha.getValueAt(iLinMD, objDef.colSrDN).toString());

	 		iAtUP = (int)Double.parseDouble(Planilha.getValueAt(iLinMD, objDef.colAtUP).toString());
	 		iAtDN = (int)Double.parseDouble(Planilha.getValueAt(iLinMD, objDef.colAtDN).toString());
		
	 		iCrcUP = (int)Double.parseDouble(Planilha.getValueAt(iLinMD, objDef.colCrcUP).toString());
	 		iCrcDN = (int)Double.parseDouble(Planilha.getValueAt(iLinMD, objDef.colCrcDN).toString());
	 		
	 		gGrafico.setSinais(iModem, iSrUP, iSrDN, iAtUP, iAtDN, iCrcUP, iCrcDN);
	 		// Pega os Tempos		
			iTSinc = objUtil.HoraToSeg( Planilha.getValueAt(iLinMD, objDef.colSincT).toString() );
			gGrafico.setTempos(iModem, iTSinc, iTAut, iTNav);
	 		 */
		}
	 	
		if(iQuem == objDef.AUTH){
			/*
			iTSinc = objUtil.HoraToSeg( Planilha.getValueAt(iLinMD, objDef.colSincT).toString() );
			iTAut = objUtil.HoraToSeg( Planilha.getValueAt(iLinMD, objDef.colAutT).toString() );			
			gGrafico.setTempos(iModem, iTSinc, iTAut, iTNav);
		*/
		}
		
		if(iQuem == objDef.PING){
			/*
			iTSinc = objUtil.HoraToSeg( Planilha.getValueAt(iLinMD, objDef.colSincT).toString() );
			iTAut = objUtil.HoraToSeg( Planilha.getValueAt(iLinMD, objDef.colAutT).toString() );
			iTNav = objUtil.HoraToSeg( Planilha.getValueAt(iLinMD, objDef.colNavT).toString() );			
			gGrafico.setTempos(iModem, iTSinc, iTAut, iTNav);
		*/
		}
		
		if(iQuem == objDef.LEDSINC){
			// gGrafico.setLeds(objUtil.bSinc[0], objUtil.bSinc[1], objUtil.bSinc[2], objUtil.bSinc[3]);
		}
		
		gGrafico.repinte(objDef.Linhas, objDef.bZoom);
		
		objLog.Metodo("VerificarDecode().iModem[0] - SRUP: " + iSrUP +", SRDN: " + iSrDN +", AtUP: "+iAtUP+", AtDN: "+ iAtDN + ", CrcUP: "+ iCrcUP + ", CrcDN: "+ iCrcDN);
	 
 }
 
 public void LerTxt_sem_uso(int iTipo, String sNomeArq, int iModem, int iLinMD){
		
		objLog.Metodo("jxTMain().LerTxt(" + sNomeArq + ")");

		int iL = 0;		
	 	try { 
			FileReader arq = new FileReader(sNomeArq); 
			BufferedReader lerArq = new BufferedReader(arq); 
			String sLinTxt = lerArq.readLine(); // lê a primeira linha // a variável "linha" recebe o valor "null" quando o processo // de repetição atingir o final do arquivo texto
			while (sLinTxt != null) { 
				sLinTxt = lerArq.readLine(); // lê da segunda até a última linha
				// Dsl2730b, Dsl485, Dsl279
				//if(iModem == objDef.HubDLink){ objDLinkOpticom.Decode(Planilha, iLinAtualx, sLinTxt); }				
			//	if(iModem == objDef.Dsl2500e){ objDsl2500e.Decode(iTipo, Planilha, iLinMD, sLinTxt); }
				//if(iModem == objDef.Intelbras){ objIntelbras.Decode(Planilha, iLinAtualx, sLinTxt); }
				//if(iModem == objDef.Cisco1841){ objCisco1841.Decode(Planilha, iLinAtualx, sLinTxt); }
			} 
			arq.close();			
			
		} catch (IOException e) { 
			System.err.printf("Erro na abertura do arquivo: %s.\n", e.getMessage());
			
		} 
	 	
	}
 public void FixeParametros(){
	 
	 objLog.Metodo("jxTMain().FixeParametros()");
	
	 /*
	  *  Teste de repasse de valores entre objetos: falhou !
	  *  Objetos diferentes, originados da mesma classe, mas não há interligação entre
	  *  2 objetos, e valores não são repassados
	  */
	
	 objLog.Metodo("jxTMain().FixeParametros().Tempo=" + objDef.PegueTempoTeste());
	 objLog.Metodo("jxTMain().FixeParametros().Simula="+ objDef.PegueSimulacao());
	 objLog.Metodo("jxTMain().FixeParametros().IP="+ objDef.PegueIP(0));
	 objLog.Metodo("jxTMain().FixeParametros().Mask="+ objDef.PegueMask());
	 objLog.Metodo("jxTMain().FixeParametros().Login="+ objDef.PegueLogin());
	 objLog.Metodo("jxTMain().FixeParametros().Senha="+ objDef.PegueSenha());
	 objLog.Metodo("jxTMain().FixeParametros().Porta="+ objDef.PeguePorta());
	 objLog.Metodo("jxTMain().FixeParametros().URLteste="+ objDef.PegueURLteste());
	 
	
 }
 
 /*
 public void AtivarTestes(){
	 
	 int iOpcao = 0;  // Default para Iniciar testes..
	 
	 objLog.Metodo("jxTMain().AtivarTestes(e0)");
	 
	 objLog.Metodo("jxTMain().AtivarTestes(e1).PeguePlanXls(" + objFrmOpcao.PeguePlanXls() + ")");
	 
	 try{
			LerConfig(objDef.bCriptoConfig);		// Carrega config 
	    } catch (IOException ex) {  
	   	 	objCxD.Aviso("Erro ao carregar arquivo de configuração, " + ex, objDef.bMsgErro);  
	    } finally{
	   	
	    } 
	
	// objCxD.Aviso( PegueTeste(), true);		 
	 
	 
	 if(objFrmOpcao.PeguePlanXls()){
		 objLog.Metodo("jxTMain().AtivarTestes(e2)->PeguePlanXls("+objFrmOpcao.PeguePlanXls()+")");		 	
		 
		 FrmPrincipal.setTitle("mtaView - " + objDef.PeguePlanCorrente());
		 objDef.FixePlanCorrente(objFrmOpcao.tfImportarLista.getText());
		 objFrmOpcao.FixePlanXls(false);	// Reinicia		
		
	 }else{
		 objLog.Metodo("jxTMain().AtivarTestes(e3)->PeguePlanXls("+objFrmOpcao.PeguePlanXls()+")");
		 objDef.FixePlanCorrente(objArquivo.PegueAbreDirArq());
		// FrmPrincipal.setTitle("mtaView - " + objArquivo.PegueAbreDirArq());	
		 objFrmOpcao.FixePlanXls(true);	// Seta como: "Indica que há endereço de arquivo na planilha"
		 
		 if(!FrmPrincipal.getTitle().contains("6")){
			 	FrmPrincipal.setTitle("mtaView - ...\\temp\\PrjTeste1.mta");
		 }	
	 }
     
	
	 
	 objArquivo.FixeAbreDirArq(null); 		// Reinicia para informar que titulo do FrmPrincipal deve ser pego(abaixo) do NovoPrf	 
	 			
 	*
 	 * 1 - Verificar se exite dados na Planilha 	  
 	 *
 	
	 *
	  *  Re-carrega Config para atualizar valores setados pelo usuário em FormOpcProjetos 
	  *
	// Atualiza titulo do Form com nome do projeto
	 //FrmPrincipal.setTitle("mtaView - " + objFrmOpcao.tfPrjNome.getText());	 
	 
	 int iNumLin = Planilha.getRowCount();	// Conta total de celulas na tabela(1001)
	 objLog.Metodo("jxTMain().AtivarTestes(e4).iNumLin: "+ iNumLin);
	 
	 int iTReg = objUtil.ContarReg(Planilha);			// Conta numero de registros na tabela
	 objLog.Metodo("Total de registros: " + iTReg);
	// objDef.iTotalLinTab = iTReg;					// tava dadndo bug em: Modem excedeu numero... Informa total de linhas(con registros na tabela)

	 
	 
	 //-----------------------------------------------------------------------------------------//
	 // Verifica linhas já testadas para definir Linha inical do teste
	 for(int iC=0; iC<iTReg; iC++){		 
		 *
		  *  Executa varredura na coluna Ação e procura pelo indicador diferente de "Testar"
		  *
		 if( (Planilha.getValueAt(iC, objDef.colRESULTADO).toString().contains(objDef.AcaoEmSim) )
		 ||(Planilha.getValueAt(iC, objDef.colRESULTADO).toString().contains(objDef.AcaoEmTst) )
		 ||(Planilha.getValueAt(iC, objDef.colRESULTADO).toString().contains(objDef.AcaoSaltar) ) 
		 ||(Planilha.getValueAt(iC, objDef.colRESULTADO).toString().contains(objDef.AcaoFimTst) )
		 ||(Planilha.getValueAt(iC, objDef.colRESULTADO).toString().contains(objDef.AcaoFimSim) ) )
		 *
		 if( (Planilha.getValueAt(iC, objDef.colRESULTADO).toString().contains(objDef.AcaoTestar)) 
		 ||	 (Planilha.getValueAt(iC, objDef.colRESULTADO).toString() == "") )
		 *				
		 {
			 FixeLinAtual( PegueLinAtual() + 1 );
			 
		 }
		 
	 }
	 FixeSeqEmTeste( (int)PegueLinAtual()/4 );
	 // objCxD.Aviso("Linha: " + PegueLinAtual(), true);
	 if(PegueSeqEmTeste() > 0){	 	 
		 
		 // Se Opção-User =  Reiniciar testes
		 iOpcao = objCxD.showOptionDlg("Deseja continuar os testes ?", "Continuar", "Reiniciar", "Cancelar", true);
		 
		 objLog.Metodo("mtaView.Opcao(): " + iOpcao);
		 
		 //if(iOpcao == 0){ ReInicia....abaixo(); } 
		 if(iOpcao == 1){ ReAtivar(); objLog.Metodo("mtaView.Opcao() -> 1 - ReAtivar() "); }
		 if(iOpcao == 2){ Parar(); objLog.Metodo("mtaView.Opcao() -> 2 - Parar(); " ); }
	 }
	 //-----------------------------------------------------------------------------------------//		
		 
	// objCxD.Aviso("Num.Linhas: " + iNumLin, true);
	 
	 
		 
		 	String sCapturaCom = "";
		 	int iModem = objDef.Intelbras;
		 	
		  	
		 	
		 	
		  	*
		  	 * Ver.se há registros na Planilha, 
		  	 * Se não há...
		  	 * 		caso não haja filtro aplicado, abre Cx-Dialog para importar registros
		  	 * 		case haja filtro aplicado, start-testes
		  	 * Se há... start-testes
		  	 * 
		  	 * A verificação da aplicação de filtro foi necessaria, 
		  	 * pois sistema considerou tabela sem registros qdo o 
		  	 * filtro selecionou somente 1 linha, com teste em curso 
		  	 *
		 	
		 	
		 	*
		 	 * Se tabela contem registros..
		 	 * Ou... contem 6(PGOSM661) na celula(0,0), (1,0), (2,0)
		 	 * 
		 	 *
		 	if( (iTReg > 1)
		 	||	(Planilha.getValueAt(0, 0).toString().contains("6"))
		 	||	(Planilha.getValueAt(1, 0).toString().contains("6"))
		 	||	(Planilha.getValueAt(2, 0).toString().contains("6"))
		 	){	
		 		
		 		*
		 		 *  Se Teste estiver parado, ou seja, se for a primeira ativação exibe aviso,
		 		 *  Se não, ou seja, é um retorno de uma Pausa, não exibe aviso 
		 		 *
		 		if(iOpcao != 2){	// Se Diferente de cancelar....
		 			
				 		if(objDef.PegueTstStatus() == objDef.tstPARAR){
				 		
				 			if(objDef.PegueSimulacao()){ 
				 				objCxD.Aviso("Atenção! Sistema em modo simulação(Seq: " + objDef.PegueTempoTeste() + "min)", true);
				 			}else{
				 				objLog.Metodo("Tempo da sequência: " + objDef.PegueTempoTeste() + "min");
				 			}
				 			
				 		}
				 		
				 		
				 		// Mexer no filtro(A-Z) durante a execução esta travando o filtro
				 		//	Planilha.setRowSorter(null);	// Bloqueia Filtro A-Z na coluna, durante testes	
						 
				 		BtnPausar.setEnabled(true); // Libera Botões
				 		BtnParar.setEnabled(true); // Libera Botões
				 		
				 		BtnPrjNovo.setEnabled(false); // Bloqueia Botões
				 		BtnPrjAbrir.setEnabled(false); // Bloqueia Botões
				 		BtnPrjSalvar.setEnabled(false); // Bloqueia Botões
				 		BtnImportarMTrader.setEnabled(false); // Bloqueia Botões
				 		
				 		//BtnSair.setEnabled(false); // Bloqueia Botões
				 		BtnExportar.setEnabled(false); // Bloqueia Botões
				 		BtnImportar.setEnabled(false); // Bloqueia Botões
				 		BtnRestaurar.setEnabled(false); // Bloqueia Botões
				 		BtnCoordenada.setEnabled(false); // Bloqueia Botões
				 		BtnLapis.setEnabled(false); // Bloqueia Botões
				 		BtnShowFiltrar.setEnabled(false); // Bloqueia Botões
				 		BtnNavegador.setEnabled(false); // Bloqueia Botões
				 		BtnMedias.setEnabled(false); // Bloqueia Botões
				 		BtnInfoAjd.setEnabled(false); // Bloqueia Botões
				 		BtnLog.setEnabled(false); // Bloqueia Botões
				 		
				 		BtnFiltrar.setEnabled(false); 
				 		tfFiltrar.setEnabled(false);	// Bloqueia tf-Filtro
						tfLedBarraStatus.setForeground(Color.white);
						tfLedBarraStatus.setBackground(Color.red);		
						tfLedBarraStatus.setText(objDef.StatusTstAtivo);
						
						
						
						objDef.FixeTstStatus(objDef.tstATIVO);			// Informa status do teste
						Iniciar(objDef.tstADSL); 	// Inicia Clock
		 		} // end if(Opcao != 2)...
 		
 	}else{ 	

 		// Verifica se há dados na tabela
 		objLog.Metodo(iNumProcesso + ": Carrega dados");
 		objFrmOpcao.Construir(Planilha);
 		Planilha.setValueAt("Nome: " + objFrmOpcao.tfPrjNome.getText(), 0, 0);
 		
 	}
 	

 }
*/
     
/**********************************************************************************************************/

 // Controla tempo
  int iHora=0;
  public void FixeHora(int i){  iHora = i; }
  public int PegueHora(){  return iHora; }
  public void IncHora(){  iHora++; }
   
  int iMin=0;
  public void FixeMin(int i){  iMin = i; }
  public void IncMin(int i){  iMin++; }
  public int PegueMin(){  return iMin; }

  int iSeg=0;					   
  int iSegAnterior=0;	// Memoriza pra comparar					   
  public void FixeSeg(int i){  iSeg = i; }
  public void IncSeg(int i){  iSeg++; }
  public int PegueSeg(){  return iSeg; }
  
  int iMiliSeg=0;					   
  public void FixeMiliSeg(int i){  iMiliSeg = i; }
  public void IncMiliSeg(int i){  iMiliSeg++; }
  public int PegueMiliSeg(){  return iMiliSeg; }

 
 // Clock-Analisar(Temporizador de varredura)   

 	//-----------------------------------------------------------	
 	private static final int N = 60;
 	private final ClockListener clClock = new ClockListener();
 	private final Timer tTemporizador = new Timer(100, clClock);

 	public class ClockListener implements ActionListener {
  	
 	    public void actionPerformed(ActionEvent e) {
 	    	
 	    	// Ctrl relogio na barra de status
 	    	String sRelogio = ""; 
        
 	    	 iMiliSeg++;
 			  
 	    	 if(iMiliSeg > 9){
 	    		 iMiliSeg = 0;
 	    		 iSeg++;	    		
 	    	 }
 		    	if(iSeg > 59){
 		    		iSeg = 0;
 		    		iMin++;	    		
 		    	}
 		    	if(iMin > 59){
 		    		iMin = 0;
 		    		iHora++;	    		
 		    	}
 		    	
 		    	sMiliSeg = String.valueOf(iMiliSeg);
 		    	sSeg = String.valueOf(iSeg);
		    	sMin = String.valueOf(iMin); 		    	
		    	sHora = String.valueOf(iHora);
		    	
		    	if(iSeg<10){ sSeg = "0" + sSeg;}
 		    	if(iMin<10){ sMin = "0" + sMin;}
 		    	if(iHora<10){ sHora = "0" + sHora;}
 		    	if(iHora>0){ sRelogio = sHora+":"+sMin+":"+sSeg+":"+sMiliSeg; }
 		    	else{sRelogio = sMin+":"+sSeg+":"+sMiliSeg;   	}
 		    	tfLedBarraStatus.setText(sRelogio);
 		    	
 		    	
 	    	
 	    } // Listerenner
 } // Classe Temporizador

 	public void Iniciar(int iTipo) {
 		
 		objLog.Metodo("jxTMain().Iniciar("+ iTipo +")");
 		
 		objDef.fixeNumRegMetaTrader(objUtil.ContarReg(Planilha));		// Fixa Num-Reg na tabela
 		
 		objLog.Metodo("jxTMain().Iniciar(NumRegTab: " + objDef.pegueNumRegMetaTrader() +")");
 		objLog.Metodo("jxTMain().Iniciar(Seq: " + PegueSeqEmTeste() +")");
 		objLog.Metodo("jxTMain().Iniciar(Lin: " + PegueLinAtual() +")");
 		objLog.Metodo("jxTMain().Iniciar(Seg: " + PegueSeg()+")");
 		objLog.Metodo("jxTMain().Iniciar(Min: " + PegueMin()+")");
 		objLog.Metodo("jxTMain().Iniciar(Hr: " + PegueHora()+")");
 		objLog.Metodo("jxTMain().Iniciar(Processo:" + PegueTimeProcesso()+")");
 		objLog.Metodo("jxTMain().Iniciar(LinTab: " + objDef.pegueTotalLinTab()+")");
 		
 		   
 	}
 	
 	public void AutoExcluirTitulo(){
 		
 		objLog.Metodo("jxTMain().AutoExcluirTitulo()");
 		
 			/* Auto-Excluir linha de título [Porta, ...]
 			 * Se porta não contém "6", (66x, 64x, 68x, 63x, etc) é porque há títulos nos dados
 			 * [Porta - Data - Prot - etc]
 			 */
 	 		if( (!Planilha.getValueAt(0, 0).toString().toLowerCase().contains("6"))
 	 		||(!Planilha.getValueAt(1, 0).toString().toLowerCase().contains("6")) 	 		
 	 		){
 				 DeletarLinha(0);	
 				objLog.Metodo("jxTMain().AutoExcluirTitulo()->Deletar(0)");
 			}
 	 		
 	}
 	
 	/*
 	 * Ativa os calculos da analise, uso uma Thread(processamento em paralelo), 
 	 * para programa não travar durante a analise, assim posso incluir uma barra de progresso
 	 */
 	public void AtivarAnalise(){
 		  new Thread() {
 		     
 		    @Override
 		    public void run() {
 				
 	
 		    	
 		    		
 		    	objLog.Metodo("jxTMain().AtivarAnalise()");
 		    	
 		    
 		    	BarraStatus(objDef.bStart);
 		    	LimparAnalise(); // Limpa dados de analise anterior	
 		    
 				
				String sLucroProjetado = "";
				
				// Pega valor do Index-Combo
				int iValComboNumRegistro = Integer.parseInt( cbNRegistro.getItemAt( objDef.pegueIdxComboNumRegistro() ).toString() );						
				int iValComboAmostraTEND = Integer.parseInt( cbAmostraTEND.getItemAt( objDef.pegueIdxComboAmostraTEND() ).toString() ); 
				int iValComboAmostraMED = Integer.parseInt( cbAmostraMED.getItemAt( objDef.pegueIdxComboAmostraMED() ).toString() ); 
				float fValComboLtb = Float.parseFloat( cbLtb.getItemAt( cbLtb.getSelectedIndex() ).toString() );  
				float fValComboLta = Float.parseFloat( cbLta.getItemAt( cbLta.getSelectedIndex() ).toString() );						
				float fValComboStopCP = Float.parseFloat( cbStopCP.getItemAt( cbStopCP.getSelectedIndex() ).toString() ); 
				float fValComboStopVD = Float.parseFloat( cbStopVD.getItemAt( cbStopVD.getSelectedIndex() ).toString() ); 						
				
				/*
				//----------------------------------------------------------------------------------------------------------
				// Calcular periodo da analise
				int iTotalRegTab = objUtil.ContarReg(Planilha);
				int iFirstLin = (iTotalRegTab - iValComboNumRegistro) + iValComboAmostraTEND;
				int iLastLin = iTotalRegTab - 1;	// Tirei a ultima linha pois tava dando erro("empty String")	
				
				// Pegar/calcular período de análise
				String sDtPeriodoIni = Planilha.getValueAt(iFirstLin, objDef.colDATA).toString();
				String sDtPeriodoFim = Planilha.getValueAt(iLastLin, objDef.colDATA).toString();
				
				tfPeriodo.setText(PegarPeriodo(sDtPeriodoIni, sDtPeriodoFim));
				*/
				
				tfPeriodo.setText(PegarPeriodo());
				
				//------------------------------------------------------------------------------------
				// Verifica/formata oferta de compra e venda(percentual ou valor fixado)
				boolean bTipoOftCV = objDef.bOftPercentual;	// Percentual ou fixada
				
				float fValComboOfertaCP = 0;
				float fValComboOfertaVD = 0;
					
				String sCbOftCP_fmt = "";
				String sCbOftVD_fmt = "";
				
				String sCbOftCP = cbOfertaCP.getItemAt( cbOfertaCP.getSelectedIndex() ).toString();
				objLog.Metodo("sCbOftCP: " + sCbOftCP);
				
				if(sCbOftCP.contains("%")){
					sCbOftCP_fmt = sCbOftCP.substring(0, 4);
					objLog.Metodo("sCbOftCP_fmt: "+sCbOftCP_fmt);
					fValComboOfertaCP = Float.parseFloat( sCbOftCP_fmt ); 
					bTipoOftCV = objDef.bOftPercentual;
				}else{
					bTipoOftCV = objDef.bOftFixada;
					sCbOftCP_fmt = sCbOftCP.substring(0, 5);
					fValComboOfertaCP = Float.parseFloat( sCbOftCP_fmt ); 
					//fValComboOfertaCP = Float.parseFloat( cbOfertaCP.getItemAt( cbOfertaCP.getSelectedIndex() ).toString() ); 
				}
			
				String sCbOftVD = cbOfertaVD.getItemAt( cbOfertaVD.getSelectedIndex() ).toString();
				objLog.Metodo("sCbOftVD: " + sCbOftVD);
				
				if(sCbOftVD.contains("%")){
					bTipoOftCV = objDef.bOftPercentual;
					sCbOftVD_fmt = sCbOftVD.substring(0, 3);
					objLog.Metodo("sCbOftVD_fmt: "+sCbOftVD_fmt);
					
					fValComboOfertaVD = Float.parseFloat( sCbOftVD_fmt ); 
					
				}else{
					bTipoOftCV = objDef.bOftFixada;
					sCbOftVD_fmt = sCbOftVD.substring(0, 5);
					fValComboOfertaVD = Float.parseFloat( sCbOftVD_fmt ); 						
					//fValComboOfertaVD = Float.parseFloat( cbOfertaVD.getItemAt( cbOfertaVD.getSelectedIndex() ).toString() ); 						
				}
				
				objLog.Metodo("fValComboOfertaCP: " + String.valueOf(fValComboOfertaCP));
				objLog.Metodo("fValComboOfertaVD: " + String.valueOf(fValComboOfertaVD));
				
				//-----------------------------------------------------------------------------------------------------------------
				String sValComboTravaCP = cbTravarOfertaCP.getItemAt( cbTravarOfertaCP.getSelectedIndex() ).toString();
				String sValComboTravaVD = cbTravarOfertaVD.getItemAt( cbTravarOfertaVD.getSelectedIndex() ).toString();
				String sValComboReferencia = cbReferencia.getItemAt( cbReferencia.getSelectedIndex() ).toString();
				
				objDef.fixeNumRegMetaTrader(objUtil.ContarReg(Planilha));
				
				objLog.Metodo("objCalcular.AnalisarOperacoes(Planilha,"+
						String.valueOf(objDef.pegueNumRegMetaTrader())+","+
						String.valueOf(iValComboNumRegistro)+","+ 
						String.valueOf(iValComboAmostraTEND)+","+ 
						String.valueOf(fValComboLtb)+","+ 
						String.valueOf(fValComboLta)+","+ 
						String.valueOf(fValComboStopCP)+","+ 
						String.valueOf(fValComboStopVD)+","+ 
						String.valueOf(fValComboOfertaCP)+","+ 
						String.valueOf(fValComboOfertaVD)+","+ 
						String.valueOf(sValComboTravaCP)+","+
						String.valueOf(sValComboTravaVD)+","+
						String.valueOf(sValComboReferencia)+","+
						String.valueOf(bTipoOftCV)
						+")");
				
				float fResultadoAnalisar[] = objCalcular.AnalisarOperacoes(  
														Planilha,
														objDef.pegueNumRegMetaTrader(),
														iValComboNumRegistro, 
														iValComboAmostraTEND, 
														fValComboLtb, 
														fValComboLta, 
														fValComboStopCP, 
														fValComboStopVD, 
														fValComboOfertaCP, 
														fValComboOfertaVD, 
														sValComboTravaCP,
														sValComboTravaVD,
														sValComboReferencia, 
														bTipoOftCV
											
											);
				
				
				// Prenche Text-field do cabeçario com relatório da analise
				objLog.Metodo("Lucro projetado: " + String.valueOf(fResultadoAnalisar[objOperacao.iPosLucro]));
				
				tfProjLucro.setText(String.format("%.2f", fResultadoAnalisar[objOperacao.iPosLucro]) + "%"); 
				tfNumOperaCP.setText( String.valueOf(fResultadoAnalisar[objOperacao.iPosContagemOpCompra]) );
				tfNumOperaVD.setText( String.valueOf(fResultadoAnalisar[objOperacao.iPosContagemOpVenda]) );
				tfNumStopCP.setText( String.valueOf(fResultadoAnalisar[objOperacao.iPosContagemStopCP]) );
				tfNumStopVD.setText( String.valueOf(fResultadoAnalisar[objOperacao.iPosContagemStopVD]) );
				tfDayTrade.setText(String.format("%.0f", fResultadoAnalisar[objOperacao.iPosContagemDayTrade]) );
				tfSwingTrade.setText(String.format("%.0f", fResultadoAnalisar[objOperacao.iPosContagemSwingTrade]) );
			
				/*
				// Formata e insere periodo da analise
				float fNumMeses = objDef.pegueComboNumRegistro() / 588;	//588 > (28*21) > 28 resultados/dia, média de 21dias mes
				String sPeriodo = "~" + String.format("%.1f",fNumMeses) + " meses"; 
				tfPeriodo.setText(sPeriodo);
				objLog.Metodo("fNumMeses: " + String.valueOf(fNumMeses)+", Periodo: "+sPeriodo);
				
				*/
				
				
				tfOferta.setText(Planilha.getValueAt(objDef.pegueNumRegMetaTrader()-1, objDef.colOFT_CP).toString());
				tfStop.setText(Planilha.getValueAt(objDef.pegueNumRegMetaTrader()-1, objDef.colSTOP_CP).toString());
		
				tfUltTendencia.setText(Planilha.getValueAt(objDef.pegueNumRegMetaTrader()-1, objDef.colTEND).toString());
				tfAcaoStatus.setText(Planilha.getValueAt(objDef.pegueNumRegMetaTrader()-1, objDef.colSTATUS).toString());
				tfOrdem.setText("Aguardar...");
		
				
				/*
				if(sLTX.contains("rvLTA")){ 
					tfOrdem.setText("Comprar");
					
				}
				if(sLTX.contains("rvLTB")){ 
					tfOrdem.setText("Vender"); 
				}
				if(sLTX.contains("rv")){ 
					tfStop.setBackground(Color.yellow);
					tfOferta.setBackground(Color.yellow);
					tfUltTendencia.setBackground(Color.yellow);
					tfOrdem.setBackground(Color.yellow);
				}else{
		
						tfStop.setBackground(Color.cyan);
						tfOferta.setBackground(Color.cyan);
						tfUltTendencia.setBackground(Color.cyan);
						tfOrdem.setBackground(Color.cyan);
					
					
				}
				*/
				
		
				/******************************************************************************/
				// Analise dos preços médios(Máx/Min) no período
				float fMediasAnalisar[] = objCalcular.AnalisarMedias(  
												Planilha,
												objDef.pegueNumRegMetaTrader(),
												iValComboNumRegistro, 
												iValComboAmostraMED								
											);
				
				
				tfPrcMin.setText(String.format("%.2f", fMediasAnalisar[objOperacao.iPosPrcMin])); 
				tfMedMin.setText(String.format("%.2f", fMediasAnalisar[objOperacao.iPosMedMin])); 
				tfPrcMed.setText(String.format("%.2f", fMediasAnalisar[objOperacao.iPosPrcMed])); 
				tfMedMax.setText(String.format("%.2f", fMediasAnalisar[objOperacao.iPosMedMax])); 
				tfPrcMax.setText(String.format("%.2f", fMediasAnalisar[objOperacao.iPosPrcMax])); 
		
				/******************************************************************************/
				
				Saltar();		
				BarraStatus(objDef.bStop);
				SalvarResultados();	// Grava Parametros usados e resultados pbtidos em csv
				
 		    }
 		  }.start();
 		 
 	}	// Final do ativarAnalise
 	
 	
 	
 	public void PausarAnalise(){
 		
 		objLog.Metodo("jxTMain().Pausar()");
 		
		objDef.FixeTstStatus(objDef.tstPAUSA);
		tTemporizador.stop();		
		tfLedBarraStatus.setForeground(Color.black);
		tfLedBarraStatus.setBackground(Color.yellow);		
		tfLedBarraStatus.setText(objDef.sLedBarraStatusPausa);
		BtnImportarMTrader.setEnabled(true); // Bloqueia Botões
		BtnPausar.setEnabled(false); // Bloqueia Botões

 		
 	}
 	
 	public void Parar() {
 		
 		objLog.Metodo("jxTMain().Parar()");
 		
 		// Exec.rotina de interrupção dos testes
 		if(objDef.bSimulacao){ tfBarraStatus.setText(tfBarraStatus.getText() + ", Simulação interrompida !"); }
 		else{ tfBarraStatus.setText(tfBarraStatus.getText() + ", Teste interrompido !"); }
 		tTemporizador.stop();
 		
 		BtnParar.setEnabled(false); // Bloqueia Botões
 		BtnPausar.setEnabled(false); // Bloqueia Botões

 		
 		BtnPrjNovo.setEnabled(false); // Bloqueia Botões - não usa no Trader
 		BtnPrjAbrir.setEnabled(true); // Bloqueia Botões
 		BtnPrjSalvar.setEnabled(true); // Bloqueia Botões - formato *.jxt(arq.ini) trava o trader
 		BtnPrjSalvarAs.setEnabled(true); // Bloqueia Botões - formato *.jxt(arq.ini) trava o trader
 		
 		//BtnSair.setEnabled(false); // Bloqueia Botões
 		BtnExportar.setEnabled(true); // Bloqueia Botões
 		BtnImportar.setEnabled(true); // Bloqueia Botões
 		BtnRestaurar.setEnabled(true); // Bloqueia Botões 
 		BtnCoordenada.setEnabled(true); // Bloqueia Botões
 		BtnLapis.setEnabled(true); // Bloqueia Botões
 		BtnShowFiltrar.setEnabled(true); // Bloqueia Botões
 		BtnNavegador.setEnabled(true); // Bloqueia Botões
 		BtnMedias.setEnabled(true); // Bloqueia Botões
 		BtnInfoAjd.setEnabled(true); // Bloqueia Botões
 		BtnLog.setEnabled(true); // Bloqueia Botões
 		
 		BtnFiltrar.setEnabled(true); 
 	
 		tfFiltrar.setEnabled(true);	// Liberar tf-Filtro
		tfLedBarraStatus.setForeground(Color.white);
		tfLedBarraStatus.setBackground(Color.decode("#008B00"));		
		tfLedBarraStatus.setText(objDef.sLedBarraStatusParar);

 		objDef.FixeTstStatus(objDef.tstPARAR);
 		
 		
 		/*
 		 * Mexer no filtro(A-Z) durante a execução esta travando o filtro
 		 */
 		// Libera filtro A-Z na coluna
 		//final TableRowSorter<TableModel> sorter =  new TableRowSorter<TableModel>(ModeloTab);
 		//Planilha.setRowSorter(sorter);
 		
 		/*
 		 * A Rotina abaixo define que: o teste apos parado,
 		 * se re-iniciado vai iniciar do Zero
 		 * (Ignora portas já testadas)
 		 */ 
 		
 		FixeSeqEmTeste(0);	
 		FixeTimeProcesso(0);
 		FixeSeg(0);
 		FixeMin(0);
 		FixeHora(0);
 		FixeLinAtual(0);
 		
 		
 	}
 	
 	public void ReAtivar() {
 		
 		objLog.Metodo("jxTMain().ReAtivar()");
 		
 		/*
 		 * Zerar variáveis, re-inicia variáveis de testes, botões, etc 		 
 		 */
 		
 		/*
 		 * A Rotina abaixo define que: o teste apos parado,
 		 * se re-iniciado vai iniciar do Zero
 		 * (Ignora portas já testadas)
 		 */ 
		LimparPlanilha(PegueLinAtual());
 		FixeSeqEmTeste(0);	
 		FixeTimeProcesso(0);
 		FixeSeg(0);
 		FixeMin(0);
 		FixeHora(0);
 		FixeLinAtual(0);
 		
 		/*
 		// Exec.rotina de interrupção dos testes
 		if(objDef.bSimulacao){ tfBarraStatus.setText(tfBarraStatus.getText() + ", Simulação interrompida !"); }
 		else{ tfBarraStatus.setText(tfBarraStatus.getText() + ", Teste interrompido !"); }
 	
 		//tTemporizador.stop();
 		
 		BtnParar.setEnabled(false); // Bloqueia Botões
 		BtnPausar.setEnabled(false); // Bloqueia Botões

 		BtnImportarMTrader.setEnabled(true); 
 		
 		BtnPrjNovo.setEnabled(true); // Bloqueia Botões
 		BtnPrjAbrir.setEnabled(true); // Bloqueia Botões
 		BtnPrjSalvar.setEnabled(true); // Bloqueia Botões
 		BtnImportarMTrader.setEnabled(true); // Bloqueia Botões
 		
 		//BtnSair.setEnabled(false); // Bloqueia Botões
 		BtnExportar.setEnabled(true); // Bloqueia Botões
 		BtnImportar.setEnabled(true); // Bloqueia Botões
 		BtnRestaurar.setEnabled(true); // Bloqueia Botões
 		BtnCoordenada.setEnabled(true); // Bloqueia Botões
 		BtnLapis.setEnabled(true); // Bloqueia Botões
 		BtnShowFiltrar.setEnabled(true); // Bloqueia Botões
 		BtnNavegador.setEnabled(true); // Bloqueia Botões
 		BtnMedias.setEnabled(true); // Bloqueia Botões
 		BtnInfoAjd.setEnabled(true); // Bloqueia Botões
 		BtnLog.setEnabled(true); // Bloqueia Botões
 		
 		BtnFiltrar.setEnabled(true); 
 	
 		tfFiltrar.setEnabled(true);	// Liberar tf-Filtro
		tfLedBarraStatus.setForeground(Color.white);
		tfLedBarraStatus.setBackground(Color.decode("#008B00"));		
		tfLedBarraStatus.setText(objDef.StatusTstParar);

 		objDef.FixeTstStatus(objDef.tstPARAR);
 		/*
 		 * Mexer no filtro(A-Z) durante a execução esta travando o filtro
 		 */
 		// Libera filtro A-Z na coluna
 		//final TableRowSorter<TableModel> sorter =  new TableRowSorter<TableModel>(ModeloTab);
 		//Planilha.setRowSorter(sorter);
 		
 		
 		
 	}

 	 
/**********************************************************************************************************/
public void DispararTesteV2(int iVersao, int iModem, int iTipo, int iLinMD){
/* Versao do modem, Numero do Modem, Tipo de Teste, Linha da Planilha */
 		
 		objLog.Metodo("jxTMain().DispararTesteV2(V: "+iVersao+", M:"+ iModem+", T: "+iTipo+", L: "+iLinMD+")");
 		
 	
} // fim DispararTesteV2() 
 	
 	/*
 	public void VerFimTeste(){
 		*
 		 *  Verifica resultado do fim dos testes
 		 *  Verifica limite de tempo por sequencia(padrão 3min - 3 tentativas por modem)
 		 *
 		
 		objLog.Metodo("jxTMain().VerFimTeste()");
 		
 		//-------------------------------------------------------------------------------------------------------------------------------------------
 		// Verifica finalização por temporização da sequencia 		
 	    if(PegueMin() == objDef.PegueTempoTeste()){
	        	
 	    		AnalisarTeste(); // Faz uma análise dos resultados
 	    		objLog.Metodo("jxTMain().VerFimTeste()-001");
 	    		
 	    		if(objDef.bSimulacao){ tfBarraStatus.setText(String.valueOf("Seqüência " + PegueSeqEmTeste() +" de simulação finalizada! " + sHora + ":" + sMin + ":" + sSeg)); }
 	    		else{ tfBarraStatus.setText(String.valueOf("Seqüência " + PegueSeqEmTeste() +" de testes finalizada! " + sHora + ":" + sMin + ":" + sSeg)); }
 	    		
 	    		tTemporizador.stop();	// Pausa Clock, aguarda decisão do usuário
	        	AutoBackup();			// faz um auto-backup dos testes
	        	*
	        	// Verifica se chegou ao fim dos registros
	        	if(VerFinalReg(objDef.iLinAtualx)){	        	
	        		objLog.Metodo("jxTMain().VerFimTeste()-002");
	        		objCxD.Aviso("Teste finalizado!", true);
	        		
	        	}else{     // Se Não...pergunta se deseja continuar....
	        	*
	        		objLog.Metodo("jxTMain().VerFimTeste()-002");	        		
	        		
	        		int iMsg = objCxD.showOptionDlg(objDef.sMsgTestes, "Continuar", "Repetir", "Parar", true);
	        	
	        	
	        		// OptionPane.yesButtonText retorna 0
	        		if(iMsg == objDef.msgCONTINUAR){
	        		
	        			if( VerFinalReg(PegueLinAtual() )){
	        				objCxD.Aviso("Não há novas portas a testar! ", true);
	        				Parar();
	        			}else{
	        				// Se Sim, reinicia	        			
	        				// Anterior: objUtil.iSeqEmTeste++;
	        				FixeSeqEmTeste( PegueSeqEmTeste() + 1);
	        				FixeTimeProcesso(0);
	        				FixeSeg(0);
	        				FixeMin(0);
	        				FixeHora(0);
	        				tTemporizador.restart();
	        				gGrafico.repinte(objDef.Grade, objDef.bZoom);	// Limpa gráfico
	        				objLog.Metodo("------------ AVANÇA SEQUENCIA(T) --------------");
	        			}
	        		
	        		}
	        		
	        		// OptionPane.cancelButtonText retorna 2
	        		if(iMsg == objDef.msgPARAR){
	        			Parar();	        		
	        		}
	        		
	        		// OptionPane.okButtonText retorna 1
	        		if(iMsg == objDef.msgREPETIR){
	        		
	        			int iOpcMsg = objCxD.OpcaoAviso("[001]Os registros desta sequência de testes serão excluídos, Repetir testes ?", 2);
	        		
	        			if(iOpcMsg == 0)  // 0 = Sim
	        			{
	        				// Se Sim, reInicia
	        				//objDef.FixeLinAtualx(0);	        				
	        				FixeTimeProcesso(0);
	        				FixeSeg(0);
	        				FixeMin(0);
	        				FixeHora(0);
	        				//objUtil.LimparPlanilha(Planilha);
	        				LimparSequencia(PegueSeqEmTeste());     // Limpa testes recem executados - para repetir
	        				
	        				tTemporizador.restart();
	        				gGrafico.repinte(objDef.Grade, objDef.bZoom);	// Limpa gráfico
	        				objLog.Metodo("------------ REPETE SEQUENCIA(T) --------------");
		        	
	    				
	        			}else{
	        				// Se não, ativa temporizador para voltar a opção: repetir, continuar ou parar 
	        				tTemporizador.restart();
	        				gGrafico.repinte(objDef.Grade, objDef.bZoom);	// Limpa gráfico
	        				objLog.Metodo("------------ REPETE SEQUENCIA(T) --------------");
		        	
	        			}
	        		
	        		}
	        	
	        	//} // if(VerFinalReg(objDef.iLinAtualx)){
 	    	} // if(iMinx == objDef.PegueTempoTeste()){
 	    
 	    	//-------------------------------------------------------------------------------------------------------------------------------------------
	    	// Verifica finalização por Sucesso os testes: SincUP + AutUP + NavUP = 3 OK
 	    	int iVerifica = 0;
	        for(int iV=0; iV<4; iV++){
	        	if( objUtil.bSinc[iV]
	        	&&  objUtil.bAuth[iV]
	        	&&  objUtil.bPing[iV] ){ iVerifica++; }
	        }
	        if(iVerifica == 4){
	        	objLog.Metodo("jxTMain().VerFimTeste()-004");
	        	AnalisarTeste();   // faz uma análise dos resultados do teste
	        	
	        	// Edita barra de Status
	        	if(objDef.bSimulacao){ tfBarraStatus.setText(String.valueOf("Seqüência " + PegueSeqEmTeste() +" de simulação finalizada! " + sHora + ":" + sMin + ":" + sSeg)); }
 	    		else{ tfBarraStatus.setText(String.valueOf("Seqüência " + PegueSeqEmTeste() +" de testes finalizada! " + sHora + ":" + sMin + ":" + sSeg)); }
 	    	
	        	
	        	tTemporizador.stop();	// pausa-clock, aguarda decisão de usuário
	        	AutoBackup();			// faz um auto-backup dos testes
	        	
	        	*
	        	// Ve se chegou ao final dos registros
	        	if(VerFinalReg(objDef.iLinAtualx)){	        	
	        		objLog.Metodo("jxTMain().VerFimTeste()-005");
	        		objCxD.Aviso("Teste finalizado!", true);
	        		
	        	}else{ // caso não...pergunta se deseja continuar...
	        	*	
	        		objLog.Metodo("jxTMain().VerFimTeste()-006");
	        		int iMsg = objCxD.showOptionDlg(objDef.sMsgTestes, "Continuar", "Repetir", "Parar",true);
	        		
	        		if(iMsg == objDef.msgCONTINUAR){
		        		
	        			if( VerFinalReg(PegueLinAtual() )){
	        				objCxD.Aviso("Não há novas portas a testar! ", true);
	        				Parar();
	        			}else{
	        				// Se Sim, reinicia	        			
	        				// Anterior: objUtil.iSeqEmTeste++;
	        				FixeSeqEmTeste(PegueSeqEmTeste() + 1);
	        				FixeTimeProcesso(0);
	        				FixeSeg(0);
	        				FixeMin(0);
	        				FixeHora(0);
	        				tTemporizador.restart();
	        				// Zera infos
		        		    for(int iV=0; iV<4; iV++){
		        	        	objUtil.bSinc[iV] = false;
		        	        	objUtil.bAuth[iV] = false;
		        	        	objUtil.bPing[iV] = false;	        	        	
		    	        	
		        	        }
	        				gGrafico.repinte(objDef.Grade, objDef.bZoom);	// Limpa gráfico
	        				objLog.Metodo("------------ AVANÇA SEQUENCIA(T) --------------");
	        			}
	        		
	        		}
	        		
	        		if(iMsg == objDef.msgPARAR){
	        			Parar();
		        	}
	           		if(iMsg == objDef.msgREPETIR){
		        		if(objCxD.Confirme("[002]Os registros desta sequência de testes serão excluídos, Repetir testes ?", objDef.bMsgExcluir) )
		    			{
		    				LimparSequencia(PegueSeqEmTeste());     // Limpa testes recem executados - para repetir
		    				*
		    				 * Volta a sequencia
		    				 *
		    				// Anterior: objUtil.iSeqEmTeste--; 
		    				FixeSeqEmTeste(PegueSeqEmTeste() - 1);
		    				if(PegueSeqEmTeste() < 0){ FixeSeqEmTeste(0); }   // Bloquiea valores menor que Zero
		    			}
		        		
		        	}
	           		
	        //	} // if(VerFinalReg(objDef.iLinAtualx)){
	        } //if(iVerifica == 4){
			
	       
	        
	        //-------------------------------------------------------------------------------------------------------------------------------------------
	        //tfBarraStatus.setText(tfBarraStatus.getText() + "[LinMd3: " + objUtil.iLinMd[objDef.iModem3] + "]");
			//Planilha.setRowSelectionInterval(1, iLinMD);	// Seleciona linha 30 (0..29)
	        FixeTimeProcesso(PegueTimeProcesso() + 1);
			FixeSeg(PegueSeg() + 1);
	        
 	}
 	 */
 	 
 	public boolean VerFinalReg(int iLinAtual){		
 		
 	
 	
 		objLog.Metodo("jxTMain().VerFinalReg("+iLinAtual+")");
 		
 		//-------------------------------------------------------------------------------------------------------------------------------------------
 		/*
 		 *  Verifica final dos registros/linhas NA TABELA
 		 *  APÓS APLICAÇÃO DE FILTRO, onde as linhas não filtradas estão ocultas
 		 *   e No final dos registros, onde as linhas estão visíveis porém não possuem dados
 		 *   
 		 *   Este método foi criado para resolver problemas de travamentos 
 		 *   qdo na aplicação de filtros, onde o sistema fazia referencia a linhas ocultas(inexistentes) e travava
 		 */
 		
        int iNumLinTab = Planilha.getRowCount();  
        int iNumRegTab = objUtil.ContarReg(Planilha);
        
        		
        objLog.Metodo("jxTMain().VerFinalReg([iLinAtual == iNumLinTab]: "+iLinAtual +"=="+ iNumLinTab+")");
    	objLog.Metodo("jxTMain().VerFinalReg([iLinAtual== iNumRegTab]: "+iLinAtual +"=="+ iNumRegTab+")");
        
        // Se Linha atual do teste >= Total de linhas na tabela, finaliza o teste
        if( (iLinAtual == iNumLinTab)
        ||	(iLinAtual == iNumRegTab) ){
        //||  (!Planilha.getValueAt(iLinAtual, objDef.colRESULTADO).toString().contains("Testar"))){
        
        	
        	//objLog.Metodo("jxTMain().VerFinalReg(): true");
        	//objCxD.Aviso("Final de Regs ! Lin: " + iLinAtual, true);
        	objLog.Metodo("jxTMain().VerFinalReg( iNumLinTab: "+iNumLinTab+", iNumRegTab: "+ iNumRegTab+" ) = true");
        	return true;	// Final dos registros

        }else{
        //	objLog.Metodo("jxTMain().VerFinalReg(): false");
        	objLog.Metodo("jxTMain().VerFinalReg( iNumLinTab: "+iNumLinTab+", iNumRegTab: "+ iNumRegTab+" ) = false");
        	return false;	// Não-final dos registros
        }

        
 	}
 	
 	 	
/*
 	public void AnalisarTeste(){
 		
 		// faz uma análise dos resultados dos testes, informa na celula: Ação
 		objLog.Metodo("jxTMain().AnalisarTeste()");
 		
 		
 		
 		
        for(int iV=0; iV<4; iV++){
        	
        	int iLinMdX = objUtil.SeqToLin(PegueSeqEmTeste(), iV);        	
        	//String sResAcao = Planilha.getValueAt(iLinMdX, objDef.colRESULTADO).toString();
        	
        	objLog.Metodo("jxTMain().AnalisarTeste().iLinMdX: " + iLinMdX + ", sResAcao: []");
        	
        	
        	*
        	 *  Se Não for final da linha, faz analise, 
        	 *  Caso contrário: Salta, para evitar travamentos 
        	 *  ao consultar Linha inexistente na tabela(Oculta pelo filtro)
        	 *
        	if(!VerFinalReg(iLinMdX)){
        		
        	
        		// Formata informações de teste para campo obs
        		String sSin = "Sinc: " + Planilha.getValueAt(iLinMdX, objDef.colSINC).toString();
        		String sAut = ", Aut: " + Planilha.getValueAt(iLinMdX, objDef.colAUTH).toString();
        		String sNav = ", Nav: " + Planilha.getValueAt(iLinMdX, objDef.colNAV).toString();
        		if( Planilha.getValueAt(iLinMdX, objDef.colAUTH).toString() == "" ){ sAut = ""; }
        		if( Planilha.getValueAt(iLinMdX, objDef.colNAV).toString() == "" ){ sNav = ""; }
        	
        		String sResOK = sSin + sAut + sNav + ", " + objDef.AcaoFimTstOK;
        		String sResNOK = sSin + sAut + sNav + ", " + objDef.AcaoFimTstNOK;
        	
        		if( (Planilha.getValueAt(iLinMdX, objDef.colRESULTADO).toString().contains("Testado"))
        		|| 	(Planilha.getValueAt(iLinMdX, objDef.colRESULTADO).toString().contains("Simulado")) ) {
        			Planilha.setValueAt(sResOK, iLinMdX, objDef.colRESULTADO);        		
        		}
        		if( (Planilha.getValueAt(iLinMdX, objDef.colRESULTADO).toString().contains("Testando"))
        		|| 	(Planilha.getValueAt(iLinMdX, objDef.colRESULTADO).toString().contains("Simulando")) ) {                	
        			Planilha.setValueAt(sResNOK, iLinMdX, objDef.colRESULTADO);        		
        		}
        	
        	}
        	
        }
 
       
 	}
 	
  */      
    public void DeletarLinha(int iLinDel){
 		
 		objLog.Metodo("jxTMain().DeletarLinha("+iLinDel+")");
  		/*
  		 *  Re-Aloca valores das celulas da tabela, 
  		 *  puxa valores das linhas abaixo da linha-del para cima,
  		 *  assim a linha selecionada some
  		 */
 		
 		objUtil.bDesfazer = true;			// Informa que há registros a recuperar
 		objUtil.iLinExcluida = iLinDel;		// memoriza linha excluida
 		
 		/*
 		 *  Armazena linha a deletar para poder desfazer ação 		 
 		 */ 
 		// Memoriza
 		for(int iCx=0; iCx < objDef.iTotColunaTab; iCx++){
 			//objLog.Metodo("jxTMain().DeletarLinha()->Mem: " + iCx);
 			objUtil.sDesfazerExcluir[iCx] = Planilha.getValueAt(iLinDel, iCx).toString(); 
 		}    
 		
 		
 		// Deleta(Desloca linhas para cima - preenche linha excluida)
 		int iTotLinPlan =  objUtil.ContarReg(Planilha);	//Planilha.getRowCount();
 		objLog.Metodo("jxTMain().DeletarLinha()->iTotLinPlan: " + iTotLinPlan);
 		
 		for(int iL=iLinDel; iL <= iTotLinPlan; iL++){
 			int iLx = iL+1;
 			//objLog.Metodo("jxTMain().DeletarLinha()->Del-iL: " + iL);
 			for(int iC=0; iC < objDef.iTotColunaTab; iC++){ 			
 				//objLog.Metodo("jxTMain().DeletarLinha()->Del-iC: " + iC);
 				Planilha.setValueAt(Planilha.getValueAt(iLx, iC), iL, iC);    				
 			}
 		}
 		
 		
 		
 		
 	}
 	
 	public void DesfazerExcluir(){
 		objLog.Metodo("jxTMain().DesfazerExcluir()");
 		
 		
 		InserirLin(objUtil.iLinExcluida);
 		
 		for(int iC=0; iC <= 27;iC++){    			 
 			Planilha.setValueAt(objUtil.sDesfazerExcluir[iC], objUtil.iLinExcluida, iC);
 		}
 		objUtil.bDesfazer = false;			// Informa que NÃO há mais registros a recuperar
 		
 	}
 	
 	public void InserirLin(int iLinSelecionada){
 		
 		/*
 		 *  27Ago14 
 		 *  Re-aloca registros de X para Y, abrindo uma linha vazia no meio 
 		 */
 		objLog.Metodo("InserirLin("+iLinSelecionada+")");
 		int iTotal = objUtil.ContarReg(Planilha) +1;	// Conta numero de registros na tabela
 		
 		// Insere uma linha vazia
 		for(int iL=0; iL<=iTotal;iL++){
 			
 			int iInverte = iTotal - iL;
 			int iLx = iInverte + 1;
 			
 			objLog.Metodo("iL: "+ iL+", Inverte: " + iInverte + ", iLx: "+ iLx);
 			
 			/*
 			 *  Se iInverte > LinhaSel(não chegou na linha selecionada) 
 			 *  Continua re-alocando registros de X(1)->Y(2)
 			 *  Caso contrario: para re-alocação
 			 *  
 			 */
 			if(iInverte >= iLinSelecionada){
 				for(int iC=0; iC <= 27;iC++){  				
 					// Copia linha X(1) para linha Y(2)
 					Planilha.setValueAt(Planilha.getValueAt(iInverte, iC), iLx, iC);
 				
 					// Apaga Linha X(1)
 					Planilha.setValueAt("", iInverte, iC);
 				}
 			}
 			
 		}
 		
 		
    	}
 		

 	
 	/****************************************************************************************************/
	/*
	 * Estes métodos foram criados dentro da mtaView devido a diferença de objetos(Definições) 
	 * os valore abaixo não são os mesmos, do objeto criado na classe mtaView e Arquivos
	 * então, qdo uma var.é atualizada no objeto da classe mtaView(objDef.xxx), este não carrega 
	 * o valor para o objeto(objDef.xxx) criado dentro da classe Arquivos
	 *  
	 */

	public void SalvarConfig() throws IOException{
	// Salva dados da Planilha em arquivo *.ini
		
		objLog.Metodo("jxTMain().SalvarConfig("+ objArquivo.PegueAbreDirArq()+")");
		
		try { 
			
				String sDirArq = objDef.DirRoot + "config.ini";		// Chama SaveDialog, pega diretório				
				String sChaveCnf = "Config";
				String sChavePrf = "Preferencias";
				String sChavePrj = "Projeto";
				
				File fArquivo = new File(sDirArq);	        
				if (!fArquivo.exists()) {	// Se o arquivo não existe...				
					fArquivo.createNewFile();	//cria um arquivo(vazio)
				}
	        
				IniEditor ArqIni = new IniEditor(true);
				ArqIni.load(fArquivo);
		

				ArqIni.addSection(sChaveCnf);	// Preferencias
				ArqIni.set(sChaveCnf, "Gt", String.valueOf(objFrmOpcao.tfIpPadrao.getText()) );
				ArqIni.set(sChaveCnf, "Mask", String.valueOf(objFrmOpcao.tfMaskPadrao.getText()) );
				ArqIni.set(sChaveCnf, "Lg", String.valueOf(objFrmOpcao.tfLoginPadrao.getText()) );
				ArqIni.set(sChaveCnf, "Sn", String.valueOf(objFrmOpcao.tfSenhaPadrao.getText()) );
				ArqIni.set(sChaveCnf, "Porta", String.valueOf(objFrmOpcao.tfPortaPadrao.getText()) );
				ArqIni.set(sChaveCnf, "TempoTst", String.valueOf(objDef.iTempoTeste) );				
				ArqIni.set(sChaveCnf, "URLteste", String.valueOf(objFrmOpcao.tfURL.getText()) );
				
				/*
				 * Simulacao: Salvo em FrmOpcPrj
				 *  ArqIni.set(sChaveCnf, "Simulacao", String.valueOf(objDef.bSimulacao) );
				 *
				 *	PlanXls Salvo em FrmOpcPrj e em Arquivos
				 *	ArqIni.set(sChaveCnf, "PlanXls", String.valueOf(objFrmOpcao.PeguePlanXls()) );
				 */
				
				ArqIni.addSection(sChavePrf);	// Preferencias				
				ArqIni.set(sChavePrf, "TamTxtTelnet", String.valueOf(objDef.iTamTexto) );
				ArqIni.set(sChavePrf, "bZoomGf", String.valueOf(objDef.bZoom) );
				

				ArqIni.addSection(sChavePrj);	// Preferencias
				ArqIni.set(sChavePrj, "PrjNome", "PrjAnaliseDados" );
				ArqIni.set(sChavePrj, "PrjPath",  objArquivo.PegueAbreDirArq() );
				//ArqIni.set(sChavePrj, "Editar", String.valueOf() );
				//ArqIni.set(sChavePrj, "Gerar", String.valueOf() );
				//ArqIni.set(sChavePrj, "Importar", String.valueOf() );
				//ArqIni.set(sChavePrj, "PrjPath", String.valueOf(objFrmOpcao.tfImportarLista.getText()) );
				//ArqIni.set(sChavePrj, "PrjPath", String.valueOf(objDef.PeguePlanCorrente()));
				
				ArqIni.save(fArquivo);	    	
				// objCxD.Aviso("Arquivo salvo em: " + sDirArq, objDef.bMsgSalvar);
				// objLog.Metodo("jxTMain().SalvarConfig(), T: " + objDef.iTempoTeste+", Txt: " + objDef.iTamTexto +", Z: " + objDef.bZoom +", Sml: " + objDef.bSimulacao);
				
	     } catch (IOException ex) {  
	    	 objCxD.Aviso("Erro ao criar arquivo[" + ex + " - E017m],", objDef.bMsgErro);  
	     } finally{
	    	
	     }
	}
	
	public void SalvarConfigCrip() throws IOException{
		// Salva dados da Planilha em arquivo *.ini
			
			objLog.Metodo("jxTMain().SalvarConfigCript()");
			
			try { 
				
					String sDirArq = objDef.DirRoot + "config.ini";		// Chama SaveDialog, pega diretório				
					String sChavePrf = "Preferencias";	
					sChavePrf = objUtil.Criptografia(objDef.bEncrypt, sChavePrf, objDef.sKeyCript);	// Criptografa Chave-ini
					File fArquivo = new File(sDirArq);	        
					if (!fArquivo.exists()) {	// Se o arquivo não existe...				
						fArquivo.createNewFile();	//cria um arquivo(vazio)
					}
		        
					IniEditor ArqIni = new IniEditor(true);
					ArqIni.load(fArquivo);
					ArqIni.addSection(sChavePrf);

					ArqIni.set(sChavePrf, objUtil.Criptografia(objDef.bEncrypt, "TamTxtTelnet", objDef.sKeyCript), String.valueOf(objDef.iTamTexto) );
					ArqIni.set(sChavePrf, objUtil.Criptografia(objDef.bEncrypt, "ZoomGf", objDef.sKeyCript), String.valueOf(objDef.bZoom) );
					
				
					ArqIni.save(fArquivo);	    	
					//objCxD.Aviso("Arquivo salvo em: " + sDirArq, objDef.bMsgSalvar);
					// objLog.Metodo("jxTMain().SalvarConfig(), T: " + objDef.iTempoTeste+", Txt: " + objDef.iTamTexto +", Z: " + objDef.bZoom +", Sml: " + objDef.bSimulacao);
					
		     } catch (IOException ex) {  
		    	 objCxD.Aviso("Erro ao criar arquivo[" + ex + " - E018m],", objDef.bMsgErro);  
		     } finally{
		    	
		     }
		}
	
	  public void LerConfig(boolean bCripto) throws IOException{
			
			objLog.Metodo("jxTMain().LerConfig("+objDef.bCriptoConfig+")");

			String sChave ="Config";
			String sChavePrj ="Projeto";
			String sChavePfr ="Preferencias";
			
			String sDirArq = objDef.DirRoot + "config.ini";		// Chama SaveDialog, pega diretório
			
				String ValorRetorno = null;
				File fArquivo = new File(sDirArq);
				IniEditor ArqIni = new IniEditor(true);
				ArqIni.load(fArquivo);

			
				// Lê arquivo config.ini e fixa valores pré-definidos

				if(bCripto){
					
				}else{
					// Config
					objDef.FixeTempoTeste( Integer.parseInt( ArqIni.get(sChave,"TempoTst") ));
					objDef.FixeSimulacao( Boolean.parseBoolean( ArqIni.get(sChave,"Simulacao") ) );
					objDef.FixeIP( String.valueOf( ArqIni.get(sChave,"Gt")) );	
					objDef.FixeMask( String.valueOf(ArqIni.get(sChave,"Mask") ) );
					objDef.FixeLogin( String.valueOf(ArqIni.get(sChave,"Lg") ) );
					objDef.FixeSenha( String.valueOf(ArqIni.get(sChave,"Sn") ) );
				
					String sPt = String.valueOf(ArqIni.get(sChave,"Porta") );
					// Check se valor é numerico
					if(objUtil.VerSeNumerico(sPt)){
						objDef.FixePorta( Integer.parseInt(sPt) ); }
					else{ objDef.FixePorta(23);	}
				
					objDef.FixeURLteste( String.valueOf(ArqIni.get(sChave,"URLteste") ) );
				
					// Projeto
					//objDef.FixePlanCorrente( String.valueOf(ArqIni.get(sChavePrj,"PrjPath")) );
					objArquivo.FixeAbreDirArq( String.valueOf(ArqIni.get(sChavePrj,"PrjPath")) );
				
				
					// Preferencias
					objDef.FixeTamTexto( Integer.parseInt( ArqIni.get(sChavePfr,"TamTxtTelnet")) );
					objDef.FixeGfZoom( Boolean.parseBoolean( ArqIni.get(sChavePfr,"ZoomGf") ) );
				}

			
		}
	  
	  public void LerConfig_old() throws IOException{
			
			objLog.Metodo("Arquivos().LerConfig_old()");

			String sChave ="Preferencias";
			String sDirArq = objDef.DirRoot + "config.ini";		// Chama SaveDialog, pega diretório
			
				String ValorRetorno = null;
				File fArquivo = new File(sDirArq);
				IniEditor ArqIni = new IniEditor(true);
				ArqIni.load(fArquivo);

			
				// Lê total de linhas no arquivo(iL = XX)
				int iTamTxtTelnet = Integer.parseInt( ArqIni.get(sChave,"TamTxtTelnet") );
				boolean bZoom =  Boolean.parseBoolean( ArqIni.get(sChave,"ZoomGf") );						
				
				// new CxDialogo().Aviso("Arq.ini carregado: " + iTempoTst +", " + bSimula, true);

				// Fixa valores lidos
				objDef.FixeTamTexto(iTamTxtTelnet);
				objDef.FixeGfZoom(bZoom);
				
			
		}
		
	  public void AutoBackup(){

		  new Thread() {
			     
			   @Override
			    public void run() {
					 	
				   	tfBarraStatus.setText("Preparando dados para executar backup...");
				   	
				  // Pega data do sistema
				    Date dData = new Date();  
				    SimpleDateFormat DiaMes = new SimpleDateFormat("ddMMMhh");  // Formato: 05Jun
					String sAgora = DiaMes.format(dData);
					
					int iTReg = objUtil.ContarReg(Planilha);	// Conta numero de registros na tabela
					if( iTReg > 0){							// Verifica NumReg
						try{
							String sDirArq = objDef.DirBak + objFrmOpcao.tfPrjNome.getText() + "_" + sAgora + "h.mta";
							objArquivo.BackupJxtIni(Planilha, sDirArq, iTReg, objLicenca.pegueLicenca());	// Salva dados
							
						}catch(IOException e){
							objLog.Metodo("jxTMain().AutoBackup(Erro ao gravar Arquivo)");
						}finally{
							//new CxDialogo().Aviso("Arquivo *.jxt Salvo !");
						}
					}else{
						objLog.Metodo("jxTMain().AutoBackup(Não há registros a serem salvos)");
					}
			
					tfBarraStatus.setText("Auto-backup comcluído!");
				       
				}	// Run...
	 	  }.start();	// start thread
					
	}
	 
	/****************************************************************************************************/
		
	  public void VerSincronismo(){
		  
		  // Consulta sincronismo dos modens - atualiza Led´s(Verde/Verm) no gráfico
		  
		    objLog.Metodo("VerSincronismo()");
				   	
	  }
	  
	  private void ExibirOcultar(int iQuem){	
		 // Exibe/oculta Barra de ferramentas - realoca Planilha
		  if(iQuem == objDef.INICIALIZAR){

					// 	Botão Lapis: Exibir/Ocultar barra fer. lapis(BfAddCotacao) 
					if(BfAddCotacao.isVisible()){
						BfPlanilha.setBounds(1, objDef.bfTabLinIni, objDef.iTelaLarg, objDef.AltTabela);
						brParametros.setBounds(1, objDef.bfParamLin, objDef.bfParamLarg, objDef.iAltPadraoBF);
						BfResultaParametros.setBounds(1, objDef.bfParamLin+objDef.iAltPadraoBF, objDef.bfParamLarg, objDef.iAltPadraoBF);
						
						// Trio - Mesma linha [Coord-Acao-Filtrar]
						BfCoordenada.setBounds(1, objDef.bfCoordenadaLin, objDef.bfCoordenadaLarg, objDef.iAltPadraoBF);
						BfAcao.setBounds(1, objDef.bfAcaoLin, objDef.bfAcaoLarg, objDef.iAltPadraoBF);
						BfFiltrar.setBounds(1, objDef.bfFiltrarLin, objDef.bfFiltrarLarg, objDef.iAltPadraoBF);
						
						BfAddCotacao.setVisible(false);
						BfAddCotacao.setAlignmentX(1);
						BfAddCotacao.setAlignmentY(100);
						repaint();
					}else{

						BfPlanilha.setBounds(1, objDef.bfTabLinIni + objDef.iAltPadraoBF, objDef.iTelaLarg, objDef.AltTabela - 25);
						brParametros.setBounds(1, objDef.bfParamLin + objDef.iAltPadraoBF, objDef.bfParamLarg, objDef.iAltPadraoBF);
						BfResultaParametros.setBounds(1, objDef.bfParamLin + (2*objDef.iAltPadraoBF), objDef.bfParamLarg, objDef.iAltPadraoBF);
				
						// Trio - Mesma linha [Coord-Acao-Filtrar]
						BfCoordenada.setBounds(1, objDef.bfCoordenadaLin + objDef.iAltPadraoBF, objDef.bfCoordenadaLarg, objDef.iAltPadraoBF);
						BfAcao.setBounds(1, objDef.bfAcaoLin + objDef.iAltPadraoBF, objDef.bfAcaoLarg, objDef.iAltPadraoBF);
						BfFiltrar.setBounds(1, objDef.bfFiltrarLin + objDef.iAltPadraoBF, objDef.bfFiltrarLarg, objDef.iAltPadraoBF);
						
						BfAddCotacao.setVisible(true);
						BfAddCotacao.setAlignmentX(1);
						BfAddCotacao.setAlignmentY(100);
						repaint();
					}

					// 	Botão Lapis: Exibir/Ocultar barra fer. lapis(BfAddCotacao) 
					if(brParametros.isVisible()){
						BfPlanilha.setBounds(1, objDef.bfTabLinIni, objDef.iTelaLarg, objDef.AltTabela);
						// Trio - Mesma linha [Coord-Acao-Filtrar]
						BfCoordenada.setBounds(1, objDef.bfCoordenadaLin, objDef.bfCoordenadaLarg, objDef.iAltPadraoBF);
						BfAcao.setBounds(1, objDef.bfAcaoLin, objDef.bfAcaoLarg, objDef.iAltPadraoBF);
						BfFiltrar.setBounds(1, objDef.bfFiltrarLin, objDef.bfFiltrarLarg, objDef.iAltPadraoBF);
										
						brParametros.setVisible(false);	// Parametros de calculo
						brParametros.setAlignmentX(1);
						brParametros.setAlignmentY(100);
				
						BfResultaParametros.setVisible(false);	// Resultados dos calculos
						BfResultaParametros.setAlignmentX(1);
						BfResultaParametros.setAlignmentY(100);
					
						
						repaint();
					}else{

						BfPlanilha.setBounds(1, objDef.bfTabLinIni + (2*objDef.iAltPadraoBF), objDef.iTelaLarg, objDef.AltTabela - 25);
						// Trio - Mesma linha [Coord-Acao-Filtrar]
						BfCoordenada.setBounds(1, objDef.bfCoordenadaLin + (2*objDef.iAltPadraoBF), objDef.bfCoordenadaLarg, objDef.iAltPadraoBF);
						BfAcao.setBounds(1, objDef.bfAcaoLin + (2*objDef.iAltPadraoBF), objDef.bfAcaoLarg, objDef.iAltPadraoBF);
						BfFiltrar.setBounds(1, objDef.bfFiltrarLin + (2*objDef.iAltPadraoBF), objDef.bfFiltrarLarg, objDef.iAltPadraoBF);
						
						brParametros.setVisible(true);
						brParametros.setAlignmentX(1);
						brParametros.setAlignmentY(100);

						BfResultaParametros.setVisible(true);
						BfResultaParametros.setAlignmentX(1);
						BfResultaParametros.setAlignmentY(100);
					
						repaint();
					}
			
					// Botão Filtro: Mostra/Esconde barra fer. Coord/Filtro(BfFiltro)
					if(BfFiltrar.isVisible()){
						BfPlanilha.setBounds(1, objDef.bfTabLinIni, objDef.iTelaLarg, objDef.AltTabela + 25);
						
						BfCoordenada.setVisible(false);
						brParametros.setAlignmentX(1);
						brParametros.setAlignmentY(100);

						BfAcao.setVisible(false);
						BfAcao.setAlignmentX(1);
						BfAcao.setAlignmentY(100);

						BfFiltrar.setVisible(false);
						BfFiltrar.setAlignmentX(1);
						BfFiltrar.setAlignmentY(100);
						
						repaint();
					}else{
						BfPlanilha.setBounds(1, objDef.bfTabLinIni + objDef.iAltPadraoBF, objDef.iTelaLarg, objDef.AltTabela);
		
						BfCoordenada.setVisible(true);
						brParametros.setAlignmentX(1);
						brParametros.setAlignmentY(100);

						BfAcao.setVisible(true);
						BfAcao.setAlignmentX(1);
						BfAcao.setAlignmentY(100);

						BfFiltrar.setVisible(true);
						BfFiltrar.setAlignmentX(1);
						BfFiltrar.setAlignmentY(100);
						
						repaint();
					}
				
  
			  
			  
		  }	// iNICIALIZAR
		  
		  if(iQuem == objDef.LAPIS){
				// 	Botão Lapis: Exibir/Ocultar barra fer. lapis(BfAddCotacao) 
				if(BfAddCotacao.isVisible()){
					BfPlanilha.setBounds(1, objDef.bfTabLinIni, objDef.iTelaLarg, objDef.AltTabela);
					brParametros.setBounds(1, objDef.bfParamLin, objDef.bfParamLarg, objDef.iAltPadraoBF);
					BfResultaParametros.setBounds(1, objDef.bfParamLin+objDef.iAltPadraoBF, objDef.bfParamLarg, objDef.iAltPadraoBF);
					
					// Trio - Mesma linha [Coord-Acao-Filtrar]
					BfCoordenada.setBounds(1, objDef.bfCoordenadaLin, objDef.bfCoordenadaLarg, objDef.iAltPadraoBF);
					BfAcao.setBounds(1, objDef.bfAcaoLin, objDef.bfAcaoLarg, objDef.iAltPadraoBF);
					BfFiltrar.setBounds(1, objDef.bfFiltrarLin, objDef.bfFiltrarLarg, objDef.iAltPadraoBF);
					
					BfAddCotacao.setVisible(false);
					BfAddCotacao.setAlignmentX(1);
					BfAddCotacao.setAlignmentY(100);
					repaint();
				}else{

					BfPlanilha.setBounds(1, objDef.bfTabLinIni + objDef.iAltPadraoBF, objDef.iTelaLarg, objDef.AltTabela - 25);
					brParametros.setBounds(1, objDef.bfParamLin + objDef.iAltPadraoBF, objDef.bfParamLarg, objDef.iAltPadraoBF);
					BfResultaParametros.setBounds(1, objDef.bfParamLin + (2*objDef.iAltPadraoBF), objDef.bfParamLarg, objDef.iAltPadraoBF);
			
					// Trio - Mesma linha [Coord-Acao-Filtrar]
					BfCoordenada.setBounds(1, objDef.bfCoordenadaLin + objDef.iAltPadraoBF, objDef.bfCoordenadaLarg, objDef.iAltPadraoBF);
					BfAcao.setBounds(1, objDef.bfAcaoLin + objDef.iAltPadraoBF, objDef.bfAcaoLarg, objDef.iAltPadraoBF);
					BfFiltrar.setBounds(1, objDef.bfFiltrarLin + objDef.iAltPadraoBF, objDef.bfFiltrarLarg, objDef.iAltPadraoBF);
					
					BfAddCotacao.setVisible(true);
					BfAddCotacao.setAlignmentX(1);
					BfAddCotacao.setAlignmentY(100);
					repaint();
				}
			}

			if(iQuem == objDef.PARAMETRO){
				// 	Botão Lapis: Exibir/Ocultar barra fer. lapis(BfAddCotacao) 
				if(brParametros.isVisible()){
					BfPlanilha.setBounds(1, objDef.bfTabLinIni, objDef.iTelaLarg, objDef.AltTabela);
					// Trio - Mesma linha [Coord-Acao-Filtrar]
					BfCoordenada.setBounds(1, objDef.bfCoordenadaLin, objDef.bfCoordenadaLarg, objDef.iAltPadraoBF);
					BfAcao.setBounds(1, objDef.bfAcaoLin, objDef.bfAcaoLarg, objDef.iAltPadraoBF);
					BfFiltrar.setBounds(1, objDef.bfFiltrarLin, objDef.bfFiltrarLarg, objDef.iAltPadraoBF);
									
					brParametros.setVisible(false);	// Parametros de calculo
					brParametros.setAlignmentX(1);
					brParametros.setAlignmentY(100);
			
					BfResultaParametros.setVisible(false);	// Resultados dos calculos
					BfResultaParametros.setAlignmentX(1);
					BfResultaParametros.setAlignmentY(100);
				
					
					repaint();
				}else{

					BfPlanilha.setBounds(1, objDef.bfTabLinIni + (2*objDef.iAltPadraoBF), objDef.iTelaLarg, objDef.AltTabela - 25);
					// Trio - Mesma linha [Coord-Acao-Filtrar]
					BfCoordenada.setBounds(1, objDef.bfCoordenadaLin + (2*objDef.iAltPadraoBF), objDef.bfCoordenadaLarg, objDef.iAltPadraoBF);
					BfAcao.setBounds(1, objDef.bfAcaoLin + (2*objDef.iAltPadraoBF), objDef.bfAcaoLarg, objDef.iAltPadraoBF);
					BfFiltrar.setBounds(1, objDef.bfFiltrarLin + (2*objDef.iAltPadraoBF), objDef.bfFiltrarLarg, objDef.iAltPadraoBF);
					
					brParametros.setVisible(true);
					brParametros.setAlignmentX(1);
					brParametros.setAlignmentY(100);

					BfResultaParametros.setVisible(true);
					BfResultaParametros.setAlignmentX(1);
					BfResultaParametros.setAlignmentY(100);
				
					repaint();
				}
			}
		  			
			if(iQuem == objDef.FILTRO){
				// Botão Filtro: Mostra/Esconde barra fer. Coord/Filtro(BfFiltro)
				if(BfFiltrar.isVisible()){
					BfPlanilha.setBounds(1, objDef.bfTabLinIni, objDef.iTelaLarg, objDef.AltTabela + 25);
					
					BfCoordenada.setVisible(false);
					brParametros.setAlignmentX(1);
					brParametros.setAlignmentY(100);

					BfAcao.setVisible(false);
					BfAcao.setAlignmentX(1);
					BfAcao.setAlignmentY(100);

					BfFiltrar.setVisible(false);
					BfFiltrar.setAlignmentX(1);
					BfFiltrar.setAlignmentY(100);
					
					repaint();
				}else{
					BfPlanilha.setBounds(1, objDef.bfTabLinIni + objDef.iAltPadraoBF, objDef.iTelaLarg, objDef.AltTabela);
	
					BfCoordenada.setVisible(true);
					brParametros.setAlignmentX(1);
					brParametros.setAlignmentY(100);

					BfAcao.setVisible(true);
					BfAcao.setAlignmentX(1);
					BfAcao.setAlignmentY(100);

					BfFiltrar.setVisible(true);
					BfFiltrar.setAlignmentX(1);
					BfFiltrar.setAlignmentY(100);
					
					repaint();
				}
			}			

	  
} // End ExibirOcultar()
    
	  
	

/*
public void AddLinha(JTable Planilha){
	
	objLog.Metodo("jxTMain().AddLinha()");
	
		int iPortaStart = 0;	 	
		int iPortaFim = objUtil.ConvertePlaca(objDef.sCBoxPlaca);
	 	
	 	// Se placa 31 ou 63...inicia em zero..senão...inicia em 1..24, 1a32..
	 	if(Integer.parseInt(objDef.sCBoxPorta) == 0){	// Só entra se porta = zero, primeira passagem
	 		if((iPortaFim == 15)||(iPortaFim == 31)||(iPortaFim == 63)){
	    		iPortaStart = 0; 
	    		cbPorta.setSelectedIndex(1); 
	    		objDef.fixeCBoxPorta(0);

	 		}else{
	    		iPortaStart = 1; 
	    		cbPorta.setSelectedIndex(2); 
	    		objDef.fixeCBoxPorta(1);
	    		objLog.Metodo("jxTMain().AddLinha()->iPortaFim == 24: "+iPortaFim );
	    	}
	    }
	 	
	// Adiciona dados as celulas da tabela
	objDef.fixeLinTab( Integer.parseInt(objDef.sCBoxLinha) - 1);
			 
	Planilha.setValueAt(tfOpen.getText() + "-" + objDef.sCBoxSlot + "/" + objDef.sCBoxPorta, objDef.pegueLinTab(), objDef.colREG);    // Valor, Lin, Col
    Planilha.setValueAt(tfDataCota.getText(), objDef.pegueLinTab(), objDef.colDATAD);    // Valor, Lin, Col
    Planilha.setValueAt(objDef.sCBoxProtocolo, objDef.pegueLinTab(), objDef.colPROTOCOL);
    
    Planilha.setValueAt(objDef.sCBoxHz, objDef.pegueLinTab(), objDef.colHZ);
    Planilha.setValueAt(objDef.sCBoxVt, objDef.pegueLinTab(), objDef.colVT);
    Planilha.setValueAt(objDef.sCBoxPino, objDef.pegueLinTab(), objDef.colPINO);
    
    Planilha.setValueAt(tfHigh.getText(), objDef.pegueLinTab(), objDef.colDESC);    // Valor, Lin, Col
    
    String sLin = String.valueOf(objDef.pegueLinTab()+1);
	//NumerarLinhas();					// Numera linhas
	Planilha.setValueAt(objDef.AcaoTestar, objDef.pegueLinTab(), objDef.colRESULTADO);		// Fixa célula Analisar/testar = objDef.AcaoTestar 
	
	Planilha.setValueAt(tfDataCota.getText(), objDef.pegueLinTab(), objDef.colDATA);    // Valor, Lin, Col
	
    // Avança Itens Combo-Box
	objDef.incLinTab();
    cbCodEmpresa.setSelectedIndex(objDef.pegueLinTab()+1);
    
    // Controla Slot/Porta
    objDef.fixeCBoxSlot( Integer.parseInt(objDef.sCBoxSlot) );
    int iNPorta = objUtil.ConvertePlaca(objDef.sCBoxPlaca) - 1;	 
    
    // Ctrl 0 a 31, 0 a 63 ou 1 a 32, 1 a 64
    String sSlotPorta = objDef.pegueCBoxSlot() + "/0";
   
   
    // Ver.final sequencia de portas
    if(objDef.pegueCBoxPorta() >= iPortaFim ){
    	 objDef.incCBoxSlot();				// Incrementa
    	 objDef.fixeCBoxPorta(iPortaStart);	// Fixa
     }else{	
    	objDef.incCBoxPorta(); 
    }
    
  	 objLog.Metodo("jxTMain().AddLinha()->iPortaStart: "+iPortaStart);
	 objLog.Metodo("jxTMain().AddLinha()->:objDef.pegueCBoxPorta(): "+objDef.pegueCBoxPorta());
	 objLog.Metodo("jxTMain().AddLinha()->iPortaFim: "+iPortaFim);

	 
    cbSlot.setSelectedIndex(objDef.pegueCBoxSlot() + 1);
    cbPorta.setSelectedIndex(objDef.pegueCBoxPorta() + 1);
    
    
    
    int iBloco =   Integer.parseInt(objDef.sCBoxBloco);
    
    if(objDef.pegueCBoxPino() + 1 > iBloco ){
    	objDef.incCBoxHz();
    	objDef.fixeCBoxPino(1); //iPino = 1;
    	objLog.Metodo("jxTMain().AddLinha()->iPino: "+objDef.pegueCBoxPino()+" > iBloco: "+iBloco);
    }else{
    	objDef.incCBoxPino();
	    objLog.Metodo("jxTMain().AddLinha()->iHz: "+objDef.pegueCBoxHz());
	    //iHz = Integer.parseInt(objDef.sCBoxVt);
	    objLog.Metodo("jxTMain().AddLinha()->iHz: "+objDef.pegueCBoxHz());
	    objLog.Metodo("jxTMain().AddLinha()->iPino: "+objDef.pegueCBoxPino()+" < iBloco: "+iBloco);
    }

    
    cbVt.setSelectedIndex(objDef.pegueCBoxVt());
    cbHz.setSelectedIndex(objDef.pegueCBoxHz());	    
    cbPino.setSelectedIndex(objDef.pegueCBoxPino());
    
    // Rederizar cores Teste/Analise: Sim(Branco), Não(Vermelho), Analisado(Verde)
    // Planilha.getColumnModel().getColumn(objDef.colREG).setCellRenderer(new RenderCorOpcao());
   
    // Cores: Listras(Linha-sim, linha não)
	for(int iC=1; iC < Planilha.getColumnCount(); iC++){
		Planilha.getColumnModel().getColumn(iC).setCellRenderer(new RenderListras());
	}
	
	
	//ModeloTab.addRow(objDef.sTabLinhas);			// Adiciona Linha a tabela
	Planilha.setRowSelectionInterval(0,objDef.pegueLinTab());	// Seleciona a linha adicionada
	Planilha.requestFocus();							// Requsita Focus
	Planilha.changeSelection(objDef.pegueLinTab(),0,false, false);	// Pula para linha adicionada
     
	
   
    
}  
*/
private void Saltar(){
	
	  objDef.fixeNumRegMetaTrader(objUtil.ContarReg(Planilha));	// Conta numero de registros na tabela
	  
	  int iLinIni = 0;
			  
	  /*
	   *  Verifica se tem registros na tabela, se sim navega de Total ao num.regs analisados
	   *  Se nao, navega de 0 ao total
	   */
	  
	  if(objDef.pegueNumRegMetaTrader()>10){
		  if(cbNRegistro.getSelectedItem().toString().contains("e")){
			  iLinIni = 0;
		  }else{
			  int iComboNumRegistro = Integer.parseInt(cbNRegistro.getSelectedItem().toString());
		  	  iLinIni = objDef.pegueNumRegMetaTrader() - iComboNumRegistro;
		  }
	  }else{
		  iLinIni = 0;
	  }
	  // Se estiver saltado...volta ao inicio, ou ao meio(inicio registro analisado)
	  if(objDef.pegueSaltarFinalTab()){
			Planilha.setRowSelectionInterval(0, iLinIni);	// Seleciona a linha adicionada
			Planilha.requestFocus();							// Requsita Focus
			Planilha.changeSelection(iLinIni,0,false, false);	// Pula para linha adicionada
			objDef.fixeSaltarFinalTab(false); 			// Informa que NÃO esta saltado(tá na linha 1) 
			
			// Ajusta icone no botao
			BtnSaltar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnSaltar16.png"));
			BtnSaltar.setToolTipText("Saltar");
				
	  }else{	// Se não estiver saltado...vai para o final dos registros
			Planilha.setRowSelectionInterval(0, objDef.pegueNumRegMetaTrader());	// Seleciona a linha adicionada
			Planilha.requestFocus();							// Requsita Focus
			Planilha.changeSelection(objDef.pegueNumRegMetaTrader(),0,false, false);	// Pula para linha adicionada
			objDef.fixeSaltarFinalTab(true); 			// Informa que ESTA saltado(tá na ULTIMA linha/registro) 

			// Ajusta icone no botao
			BtnSaltar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnVoltar16.png"));
			BtnSaltar.setToolTipText("Voltar");
	  }
}

private void BarraStatus(boolean bStart){
	
	if(bStart){
		
		// Zera clock
		iMiliSeg = 0;
		iSeg = 0;
		iMin = 0;
		iHora = 0;
			
		tfBarraStatus.setText("Analisando dados, isso pode levar alguns segundos, por favor aguarde...");
	    tTemporizador.start();	
		tfLedBarraStatus.setForeground(Color.black);
		tfLedBarraStatus.setBackground(Color.green);	// acende o verde	
		tfLedBarraStatus.setText(objDef.sLedBarraStatusAtivo);
		
		
		
	}else{
		tfLedBarraStatus.setForeground(Color.black);
		//tfLedBarraStatus.setBackground(Color.GREEN);
		tfLedBarraStatus.setBackground(Color.decode("#008B00"));
		tfBarraStatus.setText("Análise de dados concluída!");
		tTemporizador.stop();	
	}
}		

private void CriarNovoProjeto(){
	// Prepara sistema para criação de uma novo projeto de analise de dados
	
	//-------------------------------------------------------------------------
		// Apagar registros anteriores
		int iTReg = objUtil.ContarReg(Planilha);	// Conta numero de registros na tabela

		//String sParteArqAntigo = sMemPlanAtual.substring(sMemPlanAtual.length() - 13, sMemPlanAtual.length());
		
		/*
		 *  Testa se Planilha foi alterada... 
		 *  verifica se novo arquivo NÃO CONTEM parte do nome(ultimos 10 char) do antigo arquivo
		 */
		//if( !sDirArq.contains(sParteArqAntigo) ){			

			// Verifica NumReg, se registros > 1
			if( iTReg > 1){							

				//objLog.Metodo("Arquivos().LerJxtIni(Entrei 3 - Encontro regs na tabela)");
				
				// Se confirme = Sim
				if(objCxD.Confirme("Apagar dados da planilha atual?", objDef.bMsgExcluir) )
				{
					objUtil.LimparTabela(Planilha);
				//	FixeTabAlterada(true);			// Info para o FrmPrincipal ajustar Linha inicial do teste
					LimparResultados();					
					objDef.fixeNumRegMetaTrader(1);
				}
			}
					
			 
}

private void SalvarResultados(){
	/*
	 * Formata e salvar relatorio de resultados de analise em csv,
	 * para comparação do melhores parametros, os que dão mais lucros
	 * 
	 */
	String sHoje = Formatar.format(data);
	
	String sTitulo = "Data;Num.Reg;Amostra;Ltb(%);Lta(%);StopCP(%);StopVD(%);OFC(%);OFV(%);TravaCP;TravaVD;Ref;P.Lucro;N.Op.CP;N.Stop.CP;N.Op.VD;N.Stop.VD;Day T.;Swing T.;Periodo";
	String sLinRes = "";
	String vtLinha[] = new String[20];		//Transporta dados dos parametros num vetor
	
	// Transfere index-combo BF-Parametros para vetor
		vtLinha[0] = sHoje;	// data de hoje
		vtLinha[1] = String.valueOf( cbNRegistro.getSelectedItem() ); 
		vtLinha[2] = String.valueOf( cbAmostraTEND.getSelectedItem() ); 
		vtLinha[3] = String.valueOf( cbLtb.getSelectedItem() ); 
		vtLinha[4] = String.valueOf( cbLta.getSelectedItem() ); 
		vtLinha[5] = String.valueOf( cbStopCP.getSelectedItem() ); 
		vtLinha[6] = String.valueOf( cbStopVD.getSelectedItem() ); 
		vtLinha[7] = String.valueOf( cbOfertaCP.getSelectedItem() ); 
		vtLinha[8] = String.valueOf( cbOfertaVD.getSelectedItem() ); 
		vtLinha[9] = String.valueOf( cbTravarOfertaCP.getSelectedItem() ); 
		vtLinha[10] = String.valueOf( cbTravarOfertaVD.getSelectedItem() ); 
		vtLinha[11] = String.valueOf( cbReferencia.getSelectedItem() );
	
		
	//vtLinha[] = Integer.parseInt(cbNRegistro.getSelectedItem().toString()); 
		vtLinha[12] = tfProjLucro.getText();
		vtLinha[13] = tfNumOperaCP.getText();
		vtLinha[14] = tfNumStopCP.getText();
		vtLinha[15] = tfNumOperaVD.getText();	
		vtLinha[16] = tfNumStopVD.getText();
		vtLinha[17] = tfDayTrade.getText();
		vtLinha[18] = tfSwingTrade.getText();
		vtLinha[19] = tfPeriodo.getText();
		
		vtLinha[20] = String.valueOf( cbAmostraMED.getSelectedItem() ); 
		
	for(int iL=0; iL<=20; iL++){
		if(!sLinRes.isEmpty()){
			sLinRes = sLinRes +";"+vtLinha[iL];	// Monta linha para csv(;) 
		}
	}
	if(objLog.pegueInserirTitulo()){
		objLog.GravarRelatorio(sTitulo);	// Escreve linha no arq.csv
		objLog.fixeInserirTitulo(false);	// Informa q titulo já foi inserido
	}
	objLog.GravarRelatorio(sLinRes);	// Escreve linha no arq.csv
	cbAmostraMED.getSelectedItem();
	
}

private String[] FmtCamposToVetor(){
	/*
	 * Pega campos de BF-Parametros, relatorio e Acao 
	 * e joga dentro de um unico vetor para ser gravado *.jxt
	 */
	
	String vtParamRelAcao[] = new String[50];
	
	// Transfere index-combo BF-Parametros para vetor
	vtParamRelAcao[0] = String.valueOf( cbNRegistro.getSelectedIndex() ); 
	vtParamRelAcao[1] = String.valueOf( cbAmostraTEND.getSelectedIndex() ); 
	vtParamRelAcao[2] = String.valueOf( cbLtb.getSelectedIndex() ); 
	vtParamRelAcao[3] = String.valueOf( cbLta.getSelectedIndex() ); 
	vtParamRelAcao[4] = String.valueOf( cbStopCP.getSelectedIndex() ); 
	vtParamRelAcao[5] = String.valueOf( cbStopVD.getSelectedIndex() ); 
	vtParamRelAcao[6] = String.valueOf( cbOfertaCP.getSelectedIndex() ); 
	vtParamRelAcao[7] = String.valueOf( cbOfertaVD.getSelectedIndex() ); 
	
	vtParamRelAcao[8] = String.valueOf( cbTravarOfertaCP.getSelectedIndex() );
	vtParamRelAcao[9] = String.valueOf( cbTravarOfertaVD.getSelectedIndex() );
	vtParamRelAcao[10] = String.valueOf( cbReferencia.getSelectedIndex() );
	vtParamRelAcao[11] = String.valueOf( cbAmostraMED.getSelectedIndex() );
	vtParamRelAcao[12] = "";	// vago
	vtParamRelAcao[13] = "";	// vago
	vtParamRelAcao[14] = "";	// vago
	vtParamRelAcao[15] = "";	// vago
	vtParamRelAcao[16] = "";	// vago
	vtParamRelAcao[17] = "";	// vago
	vtParamRelAcao[18] = "";	// vago
	vtParamRelAcao[19] = "";	// vago
			
	// Transfere valores BF-Relatorio para vetor
	vtParamRelAcao[20] = tfProjLucro.getText();
	vtParamRelAcao[21] = tfNumOperaCP.getText();
	vtParamRelAcao[22] = tfNumStopCP.getText();
	vtParamRelAcao[23] = tfNumOperaVD.getText();	
	vtParamRelAcao[24] = tfNumStopVD.getText();
	vtParamRelAcao[25] = tfDayTrade.getText();
	vtParamRelAcao[26] = tfSwingTrade.getText();
	vtParamRelAcao[27] = tfPeriodo.getText();
	vtParamRelAcao[28] = "";	// vago
	vtParamRelAcao[29] = "";	// vago
	
	
	// Transfere valores BF-Acao para vetor
	vtParamRelAcao[30] = tfAcaoStatus.getText();
	vtParamRelAcao[31] = tfOrdem.getText();
	vtParamRelAcao[32] = tfUltTendencia.getText();
	vtParamRelAcao[33] = tfOferta.getText();	
	vtParamRelAcao[34] = tfStop.getText();
	
	// Var.Preços no período analisado 
	vtParamRelAcao[35] = tfPrcMin.getText();	// Min
	vtParamRelAcao[36] = tfMedMin.getText();	// Med.Min
	vtParamRelAcao[37] = tfPrcMed.getText();	// Preço médio geral
	vtParamRelAcao[38] = tfMedMax.getText();	// Med.Max
	vtParamRelAcao[39] = tfPrcMax.getText();	// Max
		

	return vtParamRelAcao;
	
}

private void FmtVetorToCampos(String[] vtParamRelAcao){	
		/*
		 *  Pega valores de vetor e preenche campos nas BF-Param, Rel e Acao
		 */
		
		for(int x=0; x<50; x++){
			objLog.Metodo("FmtVetorToCampos( vtParamRelAcao["+x+"]: "+vtParamRelAcao[x] + ")");
		}
		/*
		// Transfere index-combo BF-Parametros para vetor
		vtParamRelAcao[0] = String.valueOf( cbNRegistro.getSelectedIndex() ); 
		vtParamRelAcao[1] = String.valueOf( cbAmostraTEND.getSelectedIndex() ); 
		vtParamRelAcao[2] = String.valueOf( cbLtb.getSelectedIndex() ); 
		vtParamRelAcao[3] = String.valueOf( cbLta.getSelectedIndex() ); 
		vtParamRelAcao[4] = String.valueOf( cbStopCP.getSelectedIndex() ); 
		vtParamRelAcao[5] = String.valueOf( cbStopVD.getSelectedIndex() ); 
		vtParamRelAcao[6] = String.valueOf( cbOfertaCP.getSelectedIndex() ); 
		vtParamRelAcao[7] = String.valueOf( cbOfertaVD.getSelectedIndex() ); 
		
		
		vtParamRelAcao[8] = String.valueOf( cbTravarOfertaCP.getSelectedIndex() );
		vtParamRelAcao[9] = String.valueOf( cbTravarOfertaCP.getSelectedIndex() );
		
		vtParamRelAcao[10] = String.valueOf( cbReferencia.getSelectedIndex() );
*/
		
		// Pega valores de Index-combo(arq.jxt) e seta combos
		cbNRegistro.setSelectedIndex(Integer.parseInt(vtParamRelAcao[0]));
		cbAmostraTEND.setSelectedIndex(Integer.parseInt(vtParamRelAcao[1]));
		cbLtb.setSelectedIndex(Integer.parseInt(vtParamRelAcao[2]));
		cbLta.setSelectedIndex(Integer.parseInt(vtParamRelAcao[3]));
		cbStopCP.setSelectedIndex(Integer.parseInt(vtParamRelAcao[4]));
		cbStopVD.setSelectedIndex(Integer.parseInt(vtParamRelAcao[5]));
	
		// Check aki, rever pois esta dando muito bug
		// cbOfertaCP.setSelectedIndex(Integer.parseInt(vtParamRelAcao[6]));
		// cbOfertaCP.setSelectedIndex(Integer.parseInt(vtParamRelAcao[7]));
		
		
		
		cbTravarOfertaCP.setSelectedIndex( Integer.parseInt( vtParamRelAcao[8] ) );
		cbTravarOfertaVD.setSelectedIndex( Integer.parseInt( vtParamRelAcao[9] ) );		
		cbReferencia.setSelectedIndex( Integer.parseInt( vtParamRelAcao[10] ) );
		
		cbAmostraMED.setSelectedIndex(Integer.parseInt(vtParamRelAcao[11]));
		
		// Transfere valores vtParamRel para BF-Relatorio para vetor			
		tfProjLucro.setText(vtParamRelAcao[20]);
		tfNumOperaCP.setText(vtParamRelAcao[21]);
		tfNumStopCP.setText(vtParamRelAcao[22]);
		tfNumOperaVD.setText(vtParamRelAcao[23]);	
		tfNumStopVD.setText(vtParamRelAcao[24]);
		tfDayTrade.setText(vtParamRelAcao[25]);
		tfSwingTrade.setText(vtParamRelAcao[26]);
		tfPeriodo.setText(vtParamRelAcao[27]);
		
		// Transfere valores vtParamRelAcao para BF-Acao para vetor			
		tfAcaoStatus.setText(vtParamRelAcao[30]);
		tfOrdem.setText(vtParamRelAcao[31]);
		tfUltTendencia.setText(vtParamRelAcao[32]);
		tfOferta.setText(vtParamRelAcao[33]);	
		tfStop.setText(vtParamRelAcao[34]);
		tfPrcMin.setText(vtParamRelAcao[35]);
		tfMedMin.setText(vtParamRelAcao[36]);
		tfPrcMed.setText(vtParamRelAcao[37]);
		tfMedMax.setText(vtParamRelAcao[38]);
		tfPrcMax.setText(vtParamRelAcao[39]);
		
}

private void LimparResultados(){
	
	// Transfere valores vtParamRel para BF-Relatorio para vetor			
	tfProjLucro.setText("");
	tfNumOperaCP.setText("");
	tfNumStopCP.setText("");
	tfNumOperaVD.setText("");	
	tfNumStopVD.setText("");
	tfDayTrade.setText("");
	tfSwingTrade.setText("");
	tfPeriodo.setText("");
	
	// Transfere valores vtParamRelAcao para BF-Acao para vetor			
	tfMedMin.setText("");
	tfMedMax.setText("");
	tfAcaoStatus.setText("");
	tfOrdem.setText("");
	tfUltTendencia.setText("");
	tfOferta.setText("");	
	tfStop.setText("");
	tfPrcMin.setText("");
	tfMedMin.setText("");
	tfPrcMed.setText("");
	tfMedMax.setText("");
	tfPrcMax.setText("");
	
	objDef.fixeSaltarFinalTab(true);
	objDef.fixeNumRegAnalisados(0);
	objDef.fixeNumRegAnalisados(0);
	//objDef.FixePlanCorrente(objDef.sSalvarAs);
	objArquivo.FixeAbreDirArq(objDef.sSalvarAs);
}


private void AddRegistro(){
// Adiciona registro ao final da Planilha
	
	
	
	objLog.Metodo("AddRegistro(" + objDef.pegueNumRegMetaTrader()+")" );
	//cbCodEmpresa
	Planilha.setValueAt(tfDataCota.getText().toString(), objDef.pegueNumRegMetaTrader(), objDef.colDATA);
	Planilha.setValueAt(cbTimeM15.getSelectedItem().toString(), objDef.pegueNumRegMetaTrader(), objDef.colHORA);
	Planilha.setValueAt(tfOpen.getText().toString(), objDef.pegueNumRegMetaTrader(), objDef.colABERT);
	Planilha.setValueAt(tfHigh.getText().toString(), objDef.pegueNumRegMetaTrader(), objDef.colMAX);
	Planilha.setValueAt(tfLow.getText().toString(), objDef.pegueNumRegMetaTrader(), objDef.colMIN);
	Planilha.setValueAt(tfClose.getText().toString(), objDef.pegueNumRegMetaTrader(), objDef.colFECH);
	Planilha.setValueAt(tfTVol.getText().toString(), objDef.pegueNumRegMetaTrader(), objDef.colTVOL);
	Planilha.setValueAt(tfVol.getText().toString(), objDef.pegueNumRegMetaTrader(), objDef.colVOL);
	Planilha.setValueAt(tfSpread.getText().toString(), objDef.pegueNumRegMetaTrader(), objDef.colSPREAD);

	
	Planilha.setRowSelectionInterval(0,  objDef.pegueNumRegMetaTrader());	// Seleciona a linha adicionada
	Planilha.requestFocus();							// Requsita Focus
	Planilha.changeSelection( objDef.pegueNumRegMetaTrader(),0,false, false);	// Pula para linha adicionada
	objDef.fixeSaltarFinalTab(true); 			// Informa que NÃO esta saltado(tá na linha 1) 

	objDef.IncNumRegMetaTrader();

	
	
	
}

private void carregarCombosCV(boolean bLimparCombo){
	
	if(bLimparCombo){
		
		  // Limpa itens da combo(para reconstruir depois - evita add-continuo de valores R$)
		   cbOfertaCP.removeAllItems();
		   cbOfertaVD.removeAllItems();
		
		/******************************************************************************/
		// Re-carrega(Reconstroe) itens (%)
		cbOfertaCP.addItem("CP");	// Adicona Combo na BFerramentas
		cbOfertaCP.addItem("0.0%");	// Adicona Combo na BFerramentas
		cbOfertaCP.addItem("-0.3%");	// Adicona Combo na BFerramentas
		cbOfertaCP.addItem("-0.5%");	// Adicona Combo na BFerramentas
		cbOfertaCP.addItem("-0.7%");	// Adicona Combo na BFerramentas
		cbOfertaCP.addItem("-1.0%");	// Adicona Combo na BFerramentas
		cbOfertaCP.addItem("-2.0%");	// Adicona Combo na BFerramentas
		cbOfertaCP.addItem("-3.0%");	// Adicona Combo na BFerramentas	
		cbOfertaCP.addItem("-5.0%");	// Adicona Combo na BFerramentas	
		cbOfertaCP.addItem("-7.0%");	// Adicona Combo na BFerramentas	
		cbOfertaCP.addItem("-10.0%");	// Adicona Combo na BFerramentas	
	
		cbOfertaVD.addItem("VD");	// Adicona Combo na BFerramentas
		cbOfertaVD.addItem("0.0%");	// Adicona Combo na BFerramentas
		cbOfertaVD.addItem("0.3%");	// Adicona Combo na BFerramentas
		cbOfertaVD.addItem("0.5%");	// Adicona Combo na BFerramentas
		cbOfertaVD.addItem("0.7%");	// Adicona Combo na BFerramentas
		cbOfertaVD.addItem("1.0%");	// Adicona Combo na BFerramentas
		cbOfertaVD.addItem("2.0%");	// Adicona Combo na BFerramentas
		cbOfertaVD.addItem("3.0%");	// Adicona Combo na BFerramentas	
		cbOfertaVD.addItem("5.0%");	// Adicona Combo na BFerramentas	
		cbOfertaVD.addItem("7.0%");	// Adicona Combo na BFerramentas	
		cbOfertaVD.addItem("10.0%");	// Adicona Combo na BFerramentas	
	}

	
	/*
	 * Calcular preços medios de min e máx, carregar combos
	 * Usamos THread para liberar CPU continuar abrir programa
	 */
	new Thread() {
			     
	   @Override
	    public void run() {
		   
		    
		   // Pega valor do Index-Combo
			int iValComboNumRegistro = Integer.parseInt( cbNRegistro.getItemAt( objDef.pegueIdxComboNumRegistro() ).toString() );						
			int iValComboAmostraMed = Integer.parseInt( cbAmostraMED.getItemAt( objDef.pegueIdxComboAmostraMED() ).toString() ); 
			
			objDef.fixeNumRegMetaTrader(objUtil.ContarReg(Planilha));
			
			// Analise dos preços médios(Máx/Min) no período
			float fMediasAnalisar[] = objCalcular.AnalisarMedias(  
											Planilha,
											objDef.pegueNumRegMetaTrader(),
											iValComboNumRegistro, 
											iValComboAmostraMed									
										);
		
		
			tfPrcMin.setText(String.format("%.2f", fMediasAnalisar[objOperacao.iPosPrcMin])); 
			tfMedMin.setText(String.format("%.2f", fMediasAnalisar[objOperacao.iPosMedMin])); 
			tfPrcMed.setText(String.format("%.2f", fMediasAnalisar[objOperacao.iPosPrcMed])); 	
			tfMedMax.setText(String.format("%.2f", fMediasAnalisar[objOperacao.iPosMedMax])); 
			tfPrcMax.setText(String.format("%.2f", fMediasAnalisar[objOperacao.iPosPrcMax])); 
		
			// objCxD.Aviso("Var.Preços:  Min["+sPrcMin+"], MedMin["+sMedMin+"], Méd["+sPrcMed+"], MedMax["+sMedMax+"], PrcMax["+sPrcMax+"]", true);
		
			
			
			// Carrega lista de preços min/max nas combos
			int iLinIni = objOperacao.iPosLstMinIni;
			int iLinFim = iLinIni + (int)fMediasAnalisar[objOperacao.iPosNumAmostra];
			
			for(int iMin = iLinIni; iMin < iLinFim; iMin++){
				if(!String.format("%.2f", fMediasAnalisar[iMin]).contains("0,")){	// Pegar somente valores diferente de 0,00
					cbOfertaCP.addItem(String.format("%.2f", fMediasAnalisar[iMin]).replaceAll(",", ".") + "f");	// 'f' Float, java exige
				}
			}
			
			
			
			int iLinIni2 = objOperacao.iPosLstMaxIni;
			int iLinFim2 = iLinIni2 + (int)fMediasAnalisar[objOperacao.iPosNumAmostra];
			
			for(int iMax = iLinIni2; iMax < iLinFim2; iMax++){ 
				if(!String.format("%.2f", fMediasAnalisar[iMax]).contains("0,")){	// Pegar somente valores diferente de 0,00
					cbOfertaVD.addItem(String.format("%.2f", fMediasAnalisar[iMax]).replaceAll(",", ".") + "f");	// 'f' Float, java exige
				}
			}
			

	   }	// Run...
	}.start();	// start thread

	tfPeriodo.setText(PegarPeriodo());
	
}	

private String PegarPeriodo(){
//private String PegarPeriodo(String sDtPeriodoIni, String sDtPeriodoFim){
	
	//objLog.Metodo("main.PegarPeriodo(" + sDtPeriodoIni + ", " + sDtPeriodoFim+")");
	
	// Pega valor do Index-Combo
	int iValComboNumRegistro = Integer.parseInt( cbNRegistro.getItemAt( objDef.pegueIdxComboNumRegistro() ).toString() );						
	int iValComboAmostraTEND = Integer.parseInt( cbAmostraTEND.getItemAt( objDef.pegueIdxComboAmostraTEND() ).toString() ); 
	
	
	//----------------------------------------------------------------------------------------------------------
	// Calcular periodo da analise
	int iTotalRegTab = objUtil.ContarReg(Planilha);
	int iFirstLin = (iTotalRegTab - iValComboNumRegistro) + iValComboAmostraTEND;
	int iLastLin = iTotalRegTab - 1;	// Tirei a ultima linha pois tava dando erro("empty String")	
	
	// Pegar/calcular período de análise
	String sDtPeriodoIni = Planilha.getValueAt(iFirstLin, objDef.colDATA).toString();
	String sDtPeriodoFim = Planilha.getValueAt(iLastLin, objDef.colDATA).toString();

	
	// 2019.04.05, 2019.04.10
	String sAnoIni = sDtPeriodoIni.substring(0,4);
	String sMesIni = sDtPeriodoIni.substring(5,7);
	String sDiaIni = sDtPeriodoIni.substring(8,10);
	

	String sAnoFim = sDtPeriodoFim.substring(0,4);
	String sMesFim = sDtPeriodoFim.substring(5,7);
	String sDiaFim = sDtPeriodoFim.substring(8,10);
	/*
	int iResAno = Integer.parseInt(sAnoFim) - Integer.parseInt(sAnoIni);
	int iResMes = Integer.parseInt(sMesFim) - Integer.parseInt(sMesIni);
	int iResDia = Integer.parseInt(sDiaFim) - Integer.parseInt(sDiaIni);
	*/
	
	String sPeriodo = sDiaIni+"/"+sMesIni+" a "+sDiaFim+"/"+sMesFim;
	
	return sPeriodo;
	
}


public static void main( String[] args )
{        
    
	new mtaView();
	FrmPrincipal.setVisible(true);			// Mostra FrmPrincipal - Executar aqui pois dentro da função construir, da uns bugs
}
	/*
	//UIUtils.setPreferedLookAndFreel();
	//NativeInterface.open();
	
	final JWebBrowser bro = new JWebBrowser();
	bro.Navigate("http://www.google.com/");
	panel.add(bro, BorderLayout.CENTER);

	
	EventQueue.invokeLater(new Runnable(){
		public void run(){
			try{
				MyWeb frame = new MyWeb();
				frame.setVisible(true);
				
			}catch (Exception e){
				e.printStackTrace();
			}
		}
	});


public MyWeb(){

		setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		setBounds(100, 100, 450, 300);
		contentPane = new JPanel();
		contentPane.setBorder(new EmptyBorder(5,5,5,5));
		contentPane.setlayout(new Borderlayout(0,0));
		setContentPane(contentPane);
		
		final JWebBrowser bro = new JWebBrowser();
		bro.Navigate("http://www.google.com/");
		panel.add(bro, BorderLayout.CENTER);



}	// MyWeb

*/

} // Final da Classe mtaView