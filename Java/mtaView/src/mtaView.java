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
import java.awt.Font;
import java.awt.Graphics;
import java.awt.Image;
import java.awt.Label;
import java.awt.Toolkit;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.text.DecimalFormat;
import java.text.NumberFormat;
import java.text.SimpleDateFormat;
import java.util.Date;

import javax.swing.DefaultCellEditor;
import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JComboBox;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JMenu;
import javax.swing.JMenuBar;
import javax.swing.JMenuItem;
import javax.swing.JPanel;
import javax.swing.JPopupMenu;
import javax.swing.JPopupMenu.Separator;
import javax.swing.JScrollPane;
import javax.swing.JSeparator;
import javax.swing.JTable;
import javax.swing.JTextArea;
import javax.swing.JTextField;
import javax.swing.JToolBar;
import javax.swing.ListSelectionModel;
import javax.swing.RowFilter;
import javax.swing.SwingConstants;
import javax.swing.Timer;
import javax.swing.event.ListSelectionEvent;
import javax.swing.event.ListSelectionListener;
import javax.swing.table.DefaultTableCellRenderer;
import javax.swing.table.DefaultTableModel;
import javax.swing.table.TableCellEditor;
import javax.swing.table.TableModel;
import javax.swing.table.TableRowSorter;

import com.nikhaldimann.inieditor.IniEditor;
//import com.sun.istack.internal.logging.Logger;

import jxl.Cell;
import jxl.Sheet;
import jxl.Workbook;
import jxl.read.biff.BiffException;


//import Arquivos.OpenL;

/*
*  mtaView
*  mta-n7
*  mta-nv6
*  mta.app.pc@gmail.com (V**1**a*)
*  https://mtaapppc.wixsite.com/suporte
*  http://adilsonvt100.wixsite.com/mtaweb
*  
*  Font do Eclipse: 
*  	->Window->Preferences->General ->Appearance->Colors and Fonts->Basic->Text Font
*/

public class mtaView extends JFrame{
	
	private Date data = new Date();  
	private SimpleDateFormat Formatar = new SimpleDateFormat("dd/MM/yyyy");
	private String sHora;
	private String sMin;
	private String sSeg;
	
	// Teste de var
	private static String sTeste;
	private static void FixeTeste(String sT){  sTeste = sT; }
	private static String PegueTeste(){  return sTeste; }
	
	// Teste-> public String sAlteravel = "Var Alteravel Inicial!";
	// Controla tempo
	static int iHora;
	public void FixeHora(int i){  iHora = i; }
	public int PegueHora(){  return iHora; }
	 
	static int iMin;
	public void FixeMin(int i){  iMin = i; }
	public int PegueMin(){  return iMin; }
	
	static int iSeg;					   
	public void FixeSeg(int i){  iSeg = i; }
	public int PegueSeg(){  return iSeg; }
	
	// Controla sequencia corrente em teste(Md 1 a 4, 5a8, 9a12, etc)
    static int iSeqEmTeste = 0;		 
    public void FixeSeqEmTeste(int iS){  iSeqEmTeste = iS; }
    public int PegueSeqEmTeste(){  return iSeqEmTeste; }
    
    // Controla os processos(Testes: sinc, aut, nav - dentro de uma sequencia)
	static int iTimeProcesso;				   
    public void FixeTimeProcesso(int iT){  iTimeProcesso = iT; }
    public int PegueTimeProcesso(){  return iTimeProcesso; }
    
    // Controla Linha da Tabela atual em teste   
    static int iLinAtual = 0;
    public void FixeLinAtual(int iL){  iLinAtual = iL; }    	
    public int PegueLinAtual(){ return iLinAtual;    }
    
	private Ping objPing = new Ping();
	private int iSegTimer;			// Controla tempo dos pings
	//private boolean bSincMd[] = {false, false, false, false};			// Memoriza status de sincronismo dos modens 
	private Label statusLabel;
  
	
	private Definicoes objDef = new Definicoes();   
	private Ferramentas objUtil = new Ferramentas();
	private Log objLog = new Log();   
	private CxDialogo objCxD = new CxDialogo(); 
	private FormOpcProjeto objFrmOpcao = new FormOpcProjeto();	
	private FormSobre objFrmInfo = new FormSobre();
	private FormPropriedadesTab objFrmPropriedadesTab = new FormPropriedadesTab();
	private String vsLinha[] = new String[1000];
	private DLinkOpticom objDLinkOpticom = new DLinkOpticom();	// Objeto Modem
	private Dsl2500e objDsl2500e = new Dsl2500e();		// Objeto Modem
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
 
	// Componentes da Tabela - criado Global devido bugs de inserção qdo declarado no metodo
	private JToolBar BfTabela = new JToolBar(); 
	private JTable Tabela = new JTable(); 	
	private JScrollPane BRolagemTabela = new JScrollPane(Tabela, JScrollPane.VERTICAL_SCROLLBAR_ALWAYS, JScrollPane.HORIZONTAL_SCROLLBAR_ALWAYS);
	 

	
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
	private String sSelTeste[][] = { 	{ objDef.AcaoTestar, objDef.AcaoSaltar, objDef.AcaoFimTst, objDef.AcaoFimSim}, 
										{ objDef.AcaoTestar, objDef.AcaoSaltar, objDef.AcaoFimTst, objDef.AcaoFimSim},
										{ objDef.AcaoTestar, objDef.AcaoSaltar, objDef.AcaoFimTst, objDef.AcaoFimSim},
										{ objDef.AcaoTestar, objDef.AcaoSaltar, objDef.AcaoFimTst, objDef.AcaoFimSim} };
	private JComboBox cbTabTeste = new JComboBox(sSelTeste[0]);
	
	    
	private TableCellEditor CxSelTeste = new DefaultCellEditor(cbTabTeste);
 
	// Matriz de opcoes Cx-Seleção dentro da Tabela 
	private String sSelProtocol[][] = { {"Ambos", "PPPoA", "PPPoE"}, 
										{"Ambos", "PPPoA", "PPPoE"}, 
										{"Ambos", "PPPoA", "PPPoE"} };
	private JComboBox cbTabProtocol = new JComboBox(sSelProtocol[0]);
	private TableCellEditor CxSelProtocol = new DefaultCellEditor(cbTabProtocol);

	 // Criar botões
	 JButton BtnPrjNovo = new JButton();
	 JButton BtnPrjAbrir = new JButton();
	 JButton BtnPrjSalvar = new JButton();	
	 JButton BtnIniciar = new JButton();		// Inicia testes
	 JButton BtnPausar = new JButton();			// Pausar Testes
	 JButton BtnParar = new JButton();			// Parar testes
	 JButton BtnLimparTst = new JButton();		// LimparTst testes(apaga dados dos testes)	
	 JButton BtnSair = new JButton();
	 JButton BtnExportar = new JButton();
	 JButton BtnImportar = new JButton();
	 JButton BtnRestaurar = new JButton();
	 JButton BtnCoordenada = new JButton();
	 JButton BtnLapis = new JButton();
	 JButton BtnFiltro = new JButton();
	 JButton BtnNavegador = new JButton();
	 JButton BtnTelnet = new JButton();
	 JButton BtnStatusLine = new JButton();
	 JButton BtnLog = new JButton();
	


	// Componentes Bf-Testes
	private JToolBar BfTeste = new JToolBar(); 	
	private JButton BtnTstSinc = new JButton();
	private JButton BtnTstAuth = new JButton();
	private JButton BtnTstPing = new JButton();
	private JButton BtnTstVoz = new JButton();

	// Componentes Bf-Filtro
	private JToolBar BfFiltro = new JToolBar();
	private JButton BtnFiltrar = new JButton();
	private final JTextField tfFiltro = new JTextField(20);
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

	// Componentes Bf-Coordenadas
	 private JComboBox cbFiltro  = new JComboBox();
	 private JToolBar BfCoordenadas = new JToolBar();
	 private JToolBar BfCoordFiltro = new JToolBar();
	 private JToolBar BfCoordPos = new JToolBar();
	 private JToolBar BfCoordTitulo = new JToolBar();
	 private JToolBar BfCoordCampo = new JToolBar();	 
	 private JTextField tfCoord = new JTextField();	
	 private JTextField tfCelula = new JTextField();	
	 private JTextField tfTitulo = new JTextField();	
	 private JTextField tfConteudo = new JTextField();
	 
		
	// Componentes da BferAddLinha
	 static boolean bExibeAddLinha = false;
	 JToolBar BfAddLinha = new JToolBar();
	 private JComboBox cbLinha  = new JComboBox();
	 private JComboBox cbPlaca = new JComboBox();
	 private JComboBox cbBloco  = new JComboBox();
	 final JTextField tfDslam = new RenderTextoGost("Nome do Dslam"); 
	 final JTextField tfDesc = new RenderTextoGost("Descrição do defeito"); //JTextField();	 
	 private JComboBox cbSlot  = new JComboBox();
	 private JComboBox cbPorta  = new JComboBox();
	 private JTextField tfDataDf = new JTextField();
	 private JComboBox cbProtocolo  = new JComboBox();
	 private JComboBox cbHz  = new JComboBox();
	 private JComboBox cbVt  = new JComboBox();
	 private JComboBox cbPino  = new JComboBox();
	 
	
		
	// Componentes Barra de Status
	 private JToolBar BStatus = new JToolBar();
	 private JTextField tfStatus = new JTextField();
		
	 private JToolBar BStatusTeste = new JToolBar();
	 private JTextField tfStatusTeste = new JTextField();
		
	
	 // Construtor
	 public mtaView() {
		 initComponents();
	 }
 

	 
 private void initComponents() {
 
 	
	 
 	objLog.Metodo("");    
 	objLog.Metodo("*** START mtaVIEW - "+data+" *** ");
	objLog.Metodo("mtaView().initComponents()");
	
	try{
		LerConfig(objDef.bCriptoConfig);		// Carrega config de usuário 
    } catch (IOException ex) {  
   	 	objCxD.Aviso("Erro ao carregar arquivo de configuração, " + ex, objDef.bMsgErro);  
    } finally{
   	
    }
		
	objLog.Metodo("mtaView().Init().LerConfig(objDef.bCriptoConfig), Time: " + objDef.iTempoTeste+", Txt: " + objDef.iTamTexto +", Zoom: " + objDef.bZoom +", Sml: " + objDef.bSimulacao);
	objLog.Metodo("mtaView().LerConfig( Config.ini[Simulacao: " + objDef.bSimulacao + "] )");
 	ConstruirForm(); 	
 	ConstruirPainel();   	
 	ConstruirMenu(); 		// Constroe menus: Projeto, Sistema, Ferramentas, Opçoes, Info
 	
 	// Constroe barra de ferramentas
 	ConstruirBfSistema();
 	ConstruirBfExcel();
 	ConstruirBfRede();
 	ConstruirBfEdicao();
 	ConstruirBfProjeto();    	
 	ConstruirBfAddLinha();    	
 	// ConstruirBfTeste();		// Botoes para testes de programação
 	// ConstruirBfCoordenadas();
 	ConstruirBfCoordFiltro();	
    ConstruirTabela(false);		// Constroe Tabela(Planílha de testes)
 	ConstruirBfTelnet();		// TextArea Telnet(Comunicação com modens)
 	ConstruirBfGrade(); 		// Grade de linhas(Gráfico de sinais)
 	//ConstruirBfGrafico2D(); 		// Grafico 
 	// ConstruirBfSLine();			// TArea Status Line
 	// ConstruirBfLog();			// TArea LOg
 	
 	ConstruirBStatus2();		// Barra de Status(no rodapé)
 	
 	
   
 	// Carrega ultima planilha em uso 
 	if(objDef.PeguePlanCorrente().contains(".mta")){
 		// Se arquivo for *.mta	
 		 try{ 			
 			 	objArquivo.LerMtaIni(Tabela, objDef.PeguePlanCorrente() ); 	
 			 	
 		 	}catch(IOException e){ 			
 		 		objCxD.Aviso("Erro! Impossível abrir arquivo: " + objDef.PeguePlanCorrente(), objDef.bMsgAbrir);
 		 		
 		 	}finally{ 			
 		 		// Se dir não existe...cria dir mtaview_docs/backup
 		 		objArquivo.criarDiretorio(); 		 		
 		 	}
 		
 	}else{
 		// Se arquivo for *.xls
 		objFrmOpcao.DispararCargaExcel(Tabela, objDef.PeguePlanCorrente());
 	}
 	
 	/*
 	 * Seta titula da janela, caso não haja o path do projeto, set nome default-temp
 	 */
 	if(objDef.PeguePlanCorrente().contains(".")){
 		FrmPrincipal.setTitle("mtaView - " + objDef.PeguePlanCorrente());
 	}else{
 		FrmPrincipal.setTitle("mtaView - ...\\temp\\PrjTeste1.mta");
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
		objLog.Metodo("mtaView().objArquivo.LerLicenca(Erro ao ler Arquivo)");
	}finally{
		
	}
 	
}	// Final de init...
    
 
 
 
 
 
 
 
 /********************************************************************************************************************/
 public void ConstruirForm(){
		
	 objLog.Metodo("mtaView().ConstruirForm()");
	
	 // Formulário principal
 	//EX: this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
 	FrmPrincipal.setDefaultCloseOperation(FrmPrincipal.EXIT_ON_CLOSE); 	// TERMINAR A EXECUCAO SE O FrmPrincipal FOR FECHADO
 	FrmPrincipal.setTitle("mtaView");// SETA O TITULO  DO FrmPrincipal    
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
		objLog.Metodo("mtaView().ConstruirPainel()");

 	  
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
		
	objLog.Metodo("mtaView().ConstruirMenu()");
 	ConstruirSubMenuPrj();
 	ConstruirSubMenuSys();
 	ConstruirSubMenuFer();
 	ConstruirSubMenuOpc();
 	ConstruirSubMenuInfo();
 }

public void ConstruirSubMenuPrj(){

	// Constroe Menu Projeto [Novo, abrir, ...]
	objLog.Metodo("mtaView().ConstruirSubMenuPrj()");
 	
 	// Menu
 	JMenuBar BarraMenuArq = new JMenuBar();		
		AddPainel(BarraMenuArq, objDef.bfMenuPrjCol, objDef.bfMenuLin, objDef.iMenuPrjLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
		
		JMenu jMenuArq = new JMenu();
		
		BarraMenuArq.add(jMenuArq);
		
		jMenuArq.setText("Projeto");
		jMenuArq.setCursor(new Cursor(Cursor.HAND_CURSOR));
		
		
		//-------------------------------------------------------------
		// Item de Menu: Projeto		
		JMenuItem jMenuArqNovo = new JMenuItem();
		JMenuItem jMenuArqAbrir = new JMenuItem();
		JMenuItem jMenuArqSalvar = new JMenuItem();
		JMenuItem jMenuArqSalvarAs = new JMenuItem();
		Separator jMenuArqSepara1 = new Separator();
		JMenuItem jMenuArqExportar = new JMenuItem();
		JMenuItem jMenuArqImportar = new JMenuItem();
		JMenuItem jMenuArqRestaurar = new JMenuItem();
		Separator jMenuArqSepara2 = new Separator();
		JMenuItem jMenuArqSair = new JMenuItem();
		
		jMenuArq.add(jMenuArqNovo);
		jMenuArq.add(jMenuArqAbrir);
		jMenuArq.add(jMenuArqSalvar);
		jMenuArq.add(jMenuArqSalvarAs);
		jMenuArq.add(jMenuArqSepara1);
		jMenuArq.add(jMenuArqExportar);
		jMenuArq.add(jMenuArqImportar);
		jMenuArq.add(jMenuArqRestaurar);
		jMenuArq.add(jMenuArqSepara2);
		jMenuArq.add(jMenuArqSair);
				
				
		jMenuArqNovo.setText("Novo");
		jMenuArqAbrir.setText("Abrir");
		jMenuArqSalvar.setText("Salvar");
		jMenuArqSalvarAs.setText("Salvar como");
		jMenuArqExportar.setText("Exportar");
		jMenuArqImportar.setText("ImportarXLS");
		jMenuArqRestaurar.setText("Restaurar");
		jMenuArqSair.setText("Sair");
		
		// Icones
		jMenuArqNovo.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnNovoProj16.png"));		
		jMenuArqAbrir.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnAbrirDoc16.png"));
		jMenuArqSalvar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnSalvar16.png"));
		jMenuArqSalvarAs.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnSalvarAs16.png"));
		jMenuArqExportar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnExpExcel16.png"));
		jMenuArqImportar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnAbrirExcel16.png"));
		jMenuArqRestaurar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnRestaurar16.png"));
		jMenuArqSair.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnSair16.png"));
		
		// Selecionado...
		jMenuArqNovo.setSelected(false);
		jMenuArqAbrir.setSelected(false);
		jMenuArqSalvar.setSelected(false);
		jMenuArqSalvarAs.setSelected(false);
		jMenuArqExportar.setSelected(false);
		jMenuArqImportar.setSelected(false);
		jMenuArqRestaurar.setSelected(false);
		jMenuArqSair.setSelected(false);
	
		// Cursor hand...
		jMenuArqNovo.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuArqAbrir.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuArqSalvar.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuArqSalvarAs.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuArqExportar.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuArqImportar.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuArqRestaurar.setCursor(new Cursor(Cursor.HAND_CURSOR));
		jMenuArqSair.setCursor(new Cursor(Cursor.HAND_CURSOR));
			
		//-------------------------------------------------------------
		// Ouvir eventos
		jMenuArqNovo.addActionListener(new java.awt.event.ActionListener() {
         public void actionPerformed(java.awt.event.ActionEvent evt) {
        	 									// Acionamento de botão tipo: Click(menu local)
             jMenuArqNovoActionPerformed(evt);	// Acionamento de botão tipo: Click
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
private void jMenuArqNovoActionPerformed(java.awt.event.ActionEvent evt) {
	// Menu Projeto->Novo 
	objFrmOpcao.Construir(Tabela);
	// Tabela.setValueAt("Nome: " + objFrmOpcao.tfPrjNome.getText(), 0, 0);
}

// Evento dos Menus
 private void jMenuArqAbrirActionPerformed(java.awt.event.ActionEvent evt) {

	 // Menu Projeto->Abrir
	 objLog.Metodo("mtaView().jMenuArqAbrirActionPerformed()");
	 try{
			// Aki
			objArquivo.LerMtaIni(Tabela, objDef.PeguePlanCorrente());	
			
		}catch(IOException e){
			objLog.Metodo("mtaView().salvarMTA().IniFiles(Erro ao gravar Arquivo)");
		}finally{
			// objCxD.Aviso("Arquivo *.mta carregado !", objDef.bMsgAbrir);
		}
		
 }

 
 private void jMenuArqSalvarActionPerformed(java.awt.event.ActionEvent evt) {
	// Menu Projeto->Salvar
	 objLog.Metodo("mtaView().jMenuArqSalvarActionPerformed(1)");
	 
	 int iTReg = objUtil.ContarReg(Tabela);	// Conta numero de registros na tabela
		if( iTReg > 0){							// Verifica NumReg
			try{	 
				objArquivo.SalvarMtaIni(Tabela, objFrmOpcao.tfPrjNome.getText(), iTReg);	// Salva dados
				
			}catch(IOException e){
				objLog.Metodo("mtaView().salvarMTA().IniFiles(Erro ao gravar Arquivo)");
			}finally{
				//new CxDialogo().Aviso("Arquivo *.mta Salvo !");
			}
		}else{
			objCxD.Aviso("Não há registros a serem salvos.", objDef.bMsgErro);
		}   
		
 }
 
 private void jMenuArqSalvarAsActionPerformed(java.awt.event.ActionEvent evt) {
	// Menu Projeto->Salvar como	
	 
	 objLog.Metodo("mtaView().jMenuArqSalvarActionPerformed(2)");
	 int iTReg = objUtil.ContarReg(Tabela);	// Conta numero de registros na tabela
		if( iTReg > 0){							// Verifica NumReg
			try{	 
				objArquivo.SalvarMtaIni(Tabela, objFrmOpcao.tfPrjNome.getText(), iTReg);	// Salva dados
				
			}catch(IOException e){
				objLog.Metodo("mtaView().salvarMTA().IniFiles(Erro ao gravar Arquivo)");
			}finally{
				//new CxDialogo().Aviso("Arquivo *.mta Salvo !");
			}
		}else{
			objCxD.Aviso("Não há registros a serem salvos.", objDef.bMsgErro);
		}   
		
 }

 private void jMenuArqExportarActionPerformed(java.awt.event.ActionEvent evt) {
	// Menu Projeto->Exportar para Excel(csv)        
 }

 private void jMenuArqImportarActionPerformed(java.awt.event.ActionEvent evt) {
	// Menu Projeto->Importar do Excel
 }

 private void jMenuArqRestaurarActionPerformed(java.awt.event.ActionEvent evt) {
	// Menu Projeto->Restaurar backup(*.mta) 
 }

 private void jMenuArqSairActionPerformed(java.awt.event.ActionEvent evt) {
	// Menu Projeto->Sair
	/*	
	 try{			
			objArquivo.SalvarConfig();			
		}catch(IOException e){
			objLog.Metodo("mtaView().salvarMTA().IniFiles(Erro ao gravar Arquivo)");
		}finally{
			// objCxD.Aviso("Arquivo *.mta carregado !", objDef.bMsgAbrir);
		}
	*/	
	  System.exit(0);       
 }

 
 /********************************************************************************************************************/
 public void ConstruirSubMenuSys(){
		// Constroe Menu->Sistema[Iniciar, Pausar,...]
		
		objLog.Metodo("mtaView().ConstruirSubMenuSys()");
		
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
		AtivarTestes();
	}

	private void jMenuSysPausarActionPerformed(java.awt.event.ActionEvent evt) {
		if(objDef.PegueTstStatus() == objDef.tstATIVO){
			
			Pausar();
			
		}
	}
	
	/* Menu Sistema -> Sub-Menu: LimparTst */
	private void jMenuSysLimparTstActionPerformed(java.awt.event.ActionEvent evt) {
	
			
			if(objCxD.Confirme("Todos os registros de teste serão excluídos. Deseja continuar?", objDef.bMsgExcluir) )
			{
				/*
				 * Podia-se usar a rotina: LimparTestes(PegueLinAtual())
				 * Mas...PegueLinAtual() ainda não foi calculado neste ponto do programa...
				 * então é mais fácil limpar toda a Plan(1000)
				 */
				LimparTestes(1000);
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
	
	objLog.Metodo("mtaView().ConstruirSubMenuFer()");
 	
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
		jMenuFerTelnet.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnTelnet16.png"));
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
         
}
private void jMenuFerLapisActionPerformed(java.awt.event.ActionEvent evt) {
	ExibirOcultar(objDef.LAPIS);
}
private void jMenuFerFiltroActionPerformed(java.awt.event.ActionEvent evt) {
	ExibirOcultar(objDef.FILTRO);  
}


/********************************************************************************************************************/

public void ConstruirSubMenuOpc(){
	// Constroe Menu->Opções[Barra fer., Grupo...]
	
	objLog.Metodo("mtaView().ConstruirSubMenuOpc()");
	
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
	
	objLog.Metodo("mtaView().ConstruirSubMenuInfo()");
	
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
		
		
		jMenuInfoAjd.setText("Ajuda");
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
		jMenuInfoAjd.setEnabled(false);
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
	 
}

private void jMenuInfoSbrActionPerformed(java.awt.event.ActionEvent evt) {
	objFrmInfo.Construir(); 	// Construir Form.Sobre 
}

/********************************************************************************************************************/
/*
 *  Construir Barra de ferramentas...
 */
public void ConstruirBfProjeto(){
// Constroe barra de Fer. Projeto[Novo, Abrir...]	 
	 objLog.Metodo("mtaView().ConstruirBfProjeto()");
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
	 
	 // Inserir icones nos botões
	 BtnPrjNovo.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnNovoProj16.png"));
	 BtnPrjNovo.setToolTipText("Novo projeto");		// Insere Title no botão
	 BtnPrjNovo.setHideActionText(true);
	 BtnPrjNovo.setCursor(new Cursor(Cursor.HAND_CURSOR));
	
	 BtnPrjAbrir.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnAbrirDoc16.png"));
	 BtnPrjAbrir.setToolTipText("Abrir projeto(*.mta)");
	 BtnPrjAbrir.setHideActionText(true);
	 BtnPrjAbrir.setCursor(new Cursor(Cursor.HAND_CURSOR));
	 
	 BtnPrjSalvar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnSalvar16.png"));
	 BtnPrjSalvar.setToolTipText("Salvar projeto(*.mta)");
	 BtnPrjSalvar.setHideActionText(true);
	 BtnPrjSalvar.setCursor(new Cursor(Cursor.HAND_CURSOR));
	 
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

	 
}

private void BtnPrjNovoActionPerformed(java.awt.event.ActionEvent evt) {
    
	objFrmOpcao.Construir(Tabela);
	
	   
}

private void BtnPrjAbrirActionPerformed(java.awt.event.ActionEvent evt) {
	
	objLog.Metodo("mtaView().BtnPrjAbrirActionPerformed()");
	try{		
		objArquivo.LerMtaIni(Tabela, null);	
		
	}catch(IOException e){
		objLog.Metodo("mtaView().salvarMTA().IniFiles(Erro ao gravar Arquivo)");
	}finally{
		// objCxD.Aviso("Arquivo *.mta carregado !", objDef.bMsgAbrir);
	}
	
	
}

private void BtnPrjSalvarActionPerformed(java.awt.event.ActionEvent evt) {	
	
	objLog.Metodo("mtaView().BtnPrjSalvarActionPerformed(3)");
	int iTReg = objUtil.ContarReg(Tabela);	// Conta numero de registros na tabela
	if( iTReg > 0){							// Verifica NumReg
		try{	 
			objArquivo.SalvarMtaIni(Tabela, objFrmOpcao.tfPrjNome.getText(), iTReg);	// Salva dados
			 FrmPrincipal.setTitle("mtaView - " + objArquivo.PegueAbreDirArq());
		}catch(IOException e){
			objLog.Metodo("mtaView().salvarMTA().IniFiles(Erro ao gravar Arquivo)");
		}finally{
			//new CxDialogo().Aviso("Arquivo *.mta Salvo !");
		}
	}else{
		objCxD.Aviso("Não há registros a serem salvos.", objDef.bMsgErro);
	}
	
}

/********************************************************************************************************************/
public void ConstruirBfExcel(){
	 
	 objLog.Metodo("mtaView().ConstruirBfExcel()");
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
	 BarFerExcel.add(BtnRestaurar);
	 
	
	 
	 // Inserir icones nos botões
	 BtnExportar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnExpExcel16.png"));
	 BtnExportar.setToolTipText("Exportar para Excel(*.csv)");
	 BtnExportar.setHideActionText(true);
	 BtnExportar.setCursor(new Cursor(Cursor.HAND_CURSOR));

	 BtnImportar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnAbrirExcel16.png"));
	 BtnImportar.setToolTipText("Importar do Excel(*.xls)");
	 BtnImportar.setHideActionText(true);
	 BtnImportar.setCursor(new Cursor(Cursor.HAND_CURSOR));

	 BtnRestaurar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnRestaurar16.png"));
	 BtnRestaurar.setToolTipText("Restaurar backup(*.mta)");
	 BtnRestaurar.setHideActionText(true);
	 BtnRestaurar.setCursor(new Cursor(Cursor.HAND_CURSOR));

	 
	 
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
	 BtnRestaurar.addActionListener(new java.awt.event.ActionListener() {
	        public void actionPerformed(java.awt.event.ActionEvent evt) {
	        	BtnRestaurarActionPerformed(evt);	// Acionamento de botão tipo: Click
	        }
	  });
}

//Executar Eventos dos Botões - Excel(Exportar, importar, restaurar)
private void BtnExportarActionPerformed(java.awt.event.ActionEvent evt) {
	//CriarCSV();
	//objDialogo.Aviso("Tabela exportada !");
	objArquivo.SalvarCsv(Tabela);		// Formata, e Salva
	
}

private void BtnImportarActionPerformed(java.awt.event.ActionEvent evt) {
	
	/*
	 *  Devido ao: throws BiffException, IOException da Classe, exigido pela classe WokBook
	 *  Foi necessário usar tratamento de exceção: try, catch
	 */
	 
	
	try {		
		CarregarExcel();
		//objCxD.Aviso("Arquivo importado !", objDef.bMsgAbrir);		
	} catch (BiffException ex) {
		objLog.Metodo("mtaView().BtnImportar().Erro, arquivo inválido(BiffException).");
		objCxD.Aviso("Erro! Arquivo inválido(BiffException)", objDef.bMsgErro); 
	} catch (IOException ex) {  
		objLog.Metodo("mtaView().BtnImportar().Erro ao carregar arquivo(IOException).");
		objCxD.Aviso("Erro! Arquivo inválido(IOException)", objDef.bMsgErro);
	}
	
	
}

private void BtnRestaurarActionPerformed(java.awt.event.ActionEvent evt) {
	try{
		
		objArquivo.LerMtaIni(Tabela, null);	
		
	}catch(IOException e){
		objLog.Metodo("mtaView().salvarMTA().IniFiles(Erro ao gravar Arquivo)");
	}finally{
		// objCxD.Aviso("Arquivo *.mta carregado !", objDef.bMsgAbrir);
	}
}

/**********************************************************************************/
public void ConstruirBfSistema(){

	// Constroe Barra.Fer.Sistema[Iniciar, Pausar, parar,...]
	objLog.Metodo("mtaView().ConstruirBfSistema()");
	 
	 // Criar a barra 
	 JToolBar BarFerSis = new JToolBar();
	 
	 AddPainel(BarFerSis,objDef.bfBtnSisPosCol,objDef.bfBtnPosLin,objDef.bfBtnSisLarg,objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
	 BarFerSis.setFloatable(false);	 
	 BarFerSis.setRollover(true);
	 
	 JSeparator SeparaBarFerSis = new JSeparator();
	 SeparaBarFerSis.setOrientation(SwingConstants.VERTICAL);
	 BarFerSis.add(SeparaBarFerSis);
	
	 
	 
	 // Criar botões
	 BarFerSis.add(BtnIniciar);
	 BarFerSis.add(BtnPausar);
	 BarFerSis.add(BtnLimparTst);
	 BarFerSis.add(BtnParar);
	 BarFerSis.add(BtnSair);
	 
	 BtnPausar.setEnabled(false); // Bloqueia Botões
	 BtnLimparTst.setEnabled(true); // Bloqueia Botões
	 BtnParar.setEnabled(false); // Bloqueia Botões
	 
	 
	 // Inserir icones nos botões	
	 BtnIniciar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnEngrenagem16.png"));
	 BtnIniciar.setToolTipText("Iniciar testes");
	 BtnIniciar.setHideActionText(true);
	 BtnIniciar.setCursor(new Cursor(Cursor.HAND_CURSOR));

	 BtnPausar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnPausa16.png"));
	 BtnPausar.setToolTipText("Pausar testes");
	 BtnPausar.setHideActionText(true);
	 BtnPausar.setCursor(new Cursor(Cursor.HAND_CURSOR));

	 BtnLimparTst.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnDesfazer16.png"));
	 BtnLimparTst.setToolTipText("Reiniciar testes");
	 BtnLimparTst.setHideActionText(true);
	 BtnLimparTst.setCursor(new Cursor(Cursor.HAND_CURSOR));

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
	 
	 BtnIniciar.addActionListener(new java.awt.event.ActionListener() {
      public void actionPerformed(java.awt.event.ActionEvent evt) {
          BtnIniciarActionPerformed(evt);
      }
	 });
  
	 BtnPausar.addActionListener(new java.awt.event.ActionListener() {
      public void actionPerformed(java.awt.event.ActionEvent evt) {
          BtnPausarActionPerformed(evt);
      }
	 });
	 BtnLimparTst.addActionListener(new java.awt.event.ActionListener() {
	      public void actionPerformed(java.awt.event.ActionEvent evt) {
	    	  BtnLimparTstActionPerformed(evt);
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
private void BtnIniciarActionPerformed(java.awt.event.ActionEvent evt) {
	objLog.Metodo("mtaView.BtnIniciarActionPerformed()");
	AtivarTestes();  
}
private void BtnPausarActionPerformed(java.awt.event.ActionEvent evt) {
	
	if(objDef.PegueTstStatus() == objDef.tstATIVO){
		
		Pausar();
		
	}
}

/* Botão Bf-Sistema-> LimparTst */
private void BtnLimparTstActionPerformed(java.awt.event.ActionEvent evt) {
	
	if(objCxD.Confirme("Todos os registros de teste serão excluídos. Deseja continuar?", objDef.bMsgExcluir) )
	{
		/*
		 * Podia-se usar a rotina: LimparTestes(PegueLinAtual())
		 * Mas...PegueLinAtual() ainda não foi calculado neste ponto do programa...
		 * então é mais fácil limpar toda a Plan(1000)
		 */
		LimparTestes(1000);
		FixeSeqEmTeste(0);	
		FixeTimeProcesso(0);
		FixeSeg(0);
		FixeMin(0);
		FixeHora(0);
		FixeLinAtual(0);
		

			
	}
	
			
}

private void BtnVoltarActionPerformed(java.awt.event.ActionEvent evt) {	
	// DesfazerExcluir();	// Retorna linha excluida
	
	
	if(Tabela.getValueAt(0, 0).toString().contains("6")){
 		objCxD.Aviso("Contém 6, Reg: " + Tabela.getValueAt(0, 0).toString(), true);
	}else{
		objCxD.Aviso("Não contém 6, Reg: " + Tabela.getValueAt(0, 0).toString(), true);
	}
 	
}

private void BtnAvancarActionPerformed(java.awt.event.ActionEvent evt) {
	InserirLin(10);
}
private void BtnPararActionPerformed(java.awt.event.ActionEvent evt) {

	Parar();
}
private void BtnSairActionPerformed(java.awt.event.ActionEvent evt) {
	
	objLog.Metodo("mtaView().BtnSairActionPerformed()");
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
	 
	 objLog.Metodo("mtaView().ConstruirBfRede()");
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
	 BarFerRede.add(BtnTelnet);
	 BarFerRede.add(BtnStatusLine);
	 BarFerRede.add(BtnLog);

	 
	 // Inserir icones nos botões
	 BtnNavegador.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnWebDn16.png"));
	 BtnNavegador.setToolTipText("Exibir Bar.Fer.Navegador");
	 BtnNavegador.setCursor(new Cursor(Cursor.HAND_CURSOR));
	 BtnNavegador.setEnabled(false);
	 
	 BtnTelnet.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnTelnet16.png"));
	 if(objDef.bSimulacao){ BtnTelnet.setToolTipText("Testar modem(simular)"); }
	 else{ BtnTelnet.setToolTipText("Testar modem"); }
	 BtnTelnet.setCursor(new Cursor(Cursor.HAND_CURSOR));
	 BtnTelnet.setEnabled(true);	 
	 
	 BtnStatusLine.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnLedSinc16.png"));
	 BtnStatusLine.setToolTipText("Exibir status da linha");
	 BtnStatusLine.setCursor(new Cursor(Cursor.HAND_CURSOR));
	 BtnStatusLine.setEnabled(false);
	 
	 BtnLog.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnLog16.png"));
	 BtnLog.setToolTipText("Exibir Log de Bugs");
	 BtnLog.setCursor(new Cursor(Cursor.HAND_CURSOR));
	 BtnLog.setEnabled(false);
	 
	 // Ouvir enventos
	 BtnNavegador.addActionListener(new java.awt.event.ActionListener() {
		 public void actionPerformed(java.awt.event.ActionEvent evt) {
			 BtnNavegadorActionPerformed(evt);
		 }
	 });
	 BtnTelnet.addActionListener(new java.awt.event.ActionListener() {
		 public void actionPerformed(java.awt.event.ActionEvent evt) {
			 BtnTelnetActionPerformed(evt);
		 }
	 });
	 BtnStatusLine.addActionListener(new java.awt.event.ActionListener() {
		 public void actionPerformed(java.awt.event.ActionEvent evt) {
			 BtnStatusLineActionPerformed(evt);
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
		objLog.Metodo("mtaView().LerTag_antigo(Erro ao gravar Arquivo)");
	}finally{
		objCxD.Aviso(sRes, objDef.bMsgSalvar);
		
	}
	
	*/
	
}

private void BtnTelnetActionPerformed(java.awt.event.ActionEvent evt) { 
	// Botão barra-ferramentas 
	VerSincronismo();	// Testar modem
}

private void BtnStatusLineActionPerformed(java.awt.event.ActionEvent evt) {  
}


private void BtnLogActionPerformed(java.awt.event.ActionEvent evt) {
	
	//objCxD.ShowBugs();		// Mostra Log de bugs(anotações)
	/*
	 * Teste de encrypt e Decrypt
	 *
	String sTeste1 = objUtil.Criptografia(objDef.bEncrypt, "MEU texto é bem grande, para testar A EFICIÊNCIA do método !!!", objDef.sKeyCript);
	String sDec1 = objUtil.Criptografia(objDef.bDecrypt, sTeste1, objDef.sKeyCript);
	objCxD.Aviso(sTeste1 + " = " + sDec1, true);
	*/
	  	
	
}

/******************************************************************************************************/
public void ConstruirBfEdicao(){
	 
	 objLog.Metodo("mtaView().ConstruirBfEdicao()");
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
	 BarFerEdicao.add(BtnFiltro);
	 
	 // Inserir icones nos botões
	 BtnCoordenada.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnmapaChar16.png"));
	 BtnCoordenada.setToolTipText("Exibir/ocultar barra de coordenadas");
	 BtnCoordenada.setHideActionText(true);
	 BtnCoordenada.setCursor(new Cursor(Cursor.HAND_CURSOR));
	 BtnCoordenada.setEnabled(false);
	 
	 BtnLapis.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnLapis16.png"));
	 BtnLapis.setToolTipText("Exibir/ocultar barra de edição");
	 BtnLapis.setHideActionText(true);
	 BtnLapis.setCursor(new Cursor(Cursor.HAND_CURSOR));
	 BtnLapis.setEnabled(true);
	 
	 BtnFiltro.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnFiltro16.png"));
	 BtnFiltro.setToolTipText("Exibir/ocultar barra de filtro");
	 BtnFiltro.setHideActionText(true);
	 BtnFiltro.setCursor(new Cursor(Cursor.HAND_CURSOR));
	 BtnFiltro.setEnabled(true);
	 
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
	 BtnFiltro.addActionListener(new java.awt.event.ActionListener() {
		 public void actionPerformed(java.awt.event.ActionEvent evt) {
			 BtnFiltroActionPerformed(evt);
		 }
	 });

	 
}
//Eventos
private void BtnCoordenadaActionPerformed(java.awt.event.ActionEvent evt) { 
	//Tabela.setSelectionMode(ListSelectionModel.SINGLE_INTERVAL_SELECTION);  
	//Tabela.setSelectionMode(3);
	//Tabela.setRowSelectionInterval(0,29);	// Seleciona linha 30 (0..29)
	//String sPar = PegueHora() + ":" + PegueMin() + ":" + PegueSeg() + ", TP:" + PegueTimeProcesso() + ", Sq: " + PegueSeqEmTeste(); 
	//objCxD.Aviso(sPar, true);
}
private void BtnLapisActionPerformed(java.awt.event.ActionEvent evt) {

	ExibirOcultar(objDef.LAPIS);
}

private void BtnFiltroActionPerformed(java.awt.event.ActionEvent evt) {   
	
	ExibirOcultar(objDef.FILTRO);
	
}


/******************************************************************************************************/

	public void ConstruirBfCoordenadas(){
	/*
	 *  Chama metodos de construção Bar.Fer separadas
	 *  NÃO esta em uso, as Bar.Fer esta juntas(Coord + Filtro)
	 */
		objLog.Metodo("mtaView().ConstruirBfCoordenadas()");
		ConstruirBfFiltro();
		ConstruirBfCoordPos();
		ConstruirBfCoordTitulo();
		ConstruirBfCoordCampo();
	
	}
	

	/******************************************************************************************************/
	
public void ConstruirBfFiltro(){
	/*
	 *  Barra Fer. Filtro (Separado, NÃO esta em uso - ta usando: Coord + Filtro)
	 */
		objLog.Metodo("mtaView().ConstruirBfFiltro()");
		
		BfCoordFiltro.setFloatable(false);	 
		BfCoordFiltro.setRollover(true);		
		
		AddPainel(BfCoordFiltro,objDef.bfCoordFilCol, objDef.bfCoordLin, objDef.bfCoordFilLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)

		JSeparator SeparaBfCoordFiltro = new JSeparator();
		SeparaBfCoordFiltro.setOrientation(SwingConstants.VERTICAL);
		BfCoordFiltro.add(SeparaBfCoordFiltro);

		//BfCoordFiltro.add(cbFiltro);
		//cbFiltro.addItem("Filtar"); //PRPGOD286630-03/31	Filtrar          ...
		BfCoordFiltro.add(tfFiltro);
		BfCoordFiltro.add(BtnFiltrar);
		BtnFiltrar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnFiltro16.png"));
    	BtnFiltrar.setToolTipText("Aplicar filtro [vago]");
		BtnFiltrar.setHideActionText(true);
		BtnFiltrar.setCursor(new Cursor(Cursor.HAND_CURSOR));
	}	
	
	public void ConstruirBfCoordPos(){
	
		objLog.Metodo("mtaView().ConstruirBfCoordPos()");
		
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
	
		objLog.Metodo("mtaView().ConstruirBfCoordTitulo()");
		
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
	
		objLog.Metodo("mtaView().ConstruirBfCoordCampo()");
		
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
	/******************************************************************************************************/
	public void FixeExibirBfAddLinha(boolean bExibe){ BfAddLinha.setVisible(bExibe);  }
	
	public void ConstruirBfAddLinha(){
		
		objLog.Metodo("mtaView().ConstruirBfAddLinha()");				
		
		BfAddLinha.setFloatable(false);	 
		BfAddLinha.setRollover(true);
		
		JSeparator SeparaBfAddLin = new JSeparator();
		SeparaBfAddLin.setOrientation(SwingConstants.VERTICAL);
		BfAddLinha.add(SeparaBfAddLin);
		
		AddPainel(BfAddLinha, objDef.bfAddCol, objDef.bfAddLin, objDef.bfAddLinLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)					
		BfAddLinha.add(cbLinha);		
		BfAddLinha.add(tfDslam);			
		BfAddLinha.add(cbSlot);		
		BfAddLinha.add(cbPorta);
		BfAddLinha.add(cbPlaca);
		BfAddLinha.add(tfDataDf);
		BfAddLinha.add(cbProtocolo);		
		BfAddLinha.add(cbVt);
		BfAddLinha.add(cbHz);		
		BfAddLinha.add(cbPino);
		BfAddLinha.add(cbBloco);
		BfAddLinha.add(tfDesc);			// Descrição do defeito na porta
		
		cbLinha.addItem("N");
		cbLinha.setToolTipText("Linha da tabela");
		
		cbPlaca.addItem("Placa");
		cbPlaca.addItem("0-15");
		cbPlaca.addItem("1-16");
		cbPlaca.addItem("1-24");
		cbPlaca.addItem("0-31");
		cbPlaca.addItem("1-32");
		cbPlaca.addItem("1-48");
		cbPlaca.addItem("0-63");
		cbPlaca.addItem("1-64");
		cbPlaca.addItem("1-72");
		
		cbPlaca.setToolTipText("Num.portas na placa");
		cbPlaca.setCursor(new Cursor(Cursor.HAND_CURSOR));
		
		cbBloco.addItem("Bloco");
		cbBloco.addItem("10");
		cbBloco.addItem("120");
		cbBloco.setToolTipText("Tipo de bloco");				
		cbBloco.setCursor(new Cursor(Cursor.HAND_CURSOR));
		
		tfDesc.setToolTipText("Descrição do defeito");
		cbSlot.addItem("Slot");
		cbSlot.setToolTipText("Slot");
		cbSlot.setCursor(new Cursor(Cursor.HAND_CURSOR));
		cbPorta.addItem("Porta");
		cbPorta.setToolTipText("Porta");
		cbPorta.setCursor(new Cursor(Cursor.HAND_CURSOR));
		tfDataDf.setText(Formatar.format(data));
		cbProtocolo.addItem("Protocolo");		// Cria itens de protocolo
			cbProtocolo.addItem("Ambos");
			cbProtocolo.addItem("PPPoA");
			cbProtocolo.addItem("PPPoE");
			cbProtocolo.setToolTipText("Tipo de protocolo");
			cbProtocolo.setCursor(new Cursor(Cursor.HAND_CURSOR));
			
		cbVt.addItem("Vt");
		cbVt.setToolTipText("Vertical");
		cbVt.setCursor(new Cursor(Cursor.HAND_CURSOR));
		cbHz.addItem("Hz");	
		cbHz.setToolTipText("Horizontal");
		cbHz.setCursor(new Cursor(Cursor.HAND_CURSOR));
		cbPino.addItem("Pino");
		cbPino.setToolTipText("Pino");
		cbPino.setCursor(new Cursor(Cursor.HAND_CURSOR));

		BfAddLinha.setVisible(false);			
				
		/******************************************/
		tfDslam.setColumns(10);			
		tfDslam.setSize(10, 20);
		tfDslam.setToolTipText("Nome do Dslam");
		/******************************************/
		
		
		// Cria itens(numeros) de combo Vt, Hz e Pino
		for(int iL = 1; iL <= objDef.NumLinAdd; iL++){ cbLinha.addItem(iL);	}			
		for(int iS = 0; iS <= objDef.NumSlotAdd; iS++){ cbSlot.addItem(iS);	}
		for(int iP = 0; iP <= objDef.PlacaAdd; iP++){ cbPorta.addItem(iP);	}
		for(int iHVP = 1; iHVP <= objDef.NumHVPAdd; iHVP++){ 
			// iHVP: i-integer, H-hor, V-Vert, P-Pino	
			cbHz.addItem(iHVP);		
			cbVt.addItem(iHVP);
			cbPino.addItem(iHVP);
		}
    
		 
		
		// Botões: Add, Limpar 
		JButton BtnAdd = new JButton();	// Cria Botão
		BfAddLinha.add(BtnAdd);			// Adiciona Botão ao Painel	
		BtnAdd.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnAddLinha16.png"));
		BtnAdd.setCursor(new Cursor(Cursor.HAND_CURSOR));
		BtnAdd.setToolTipText("Inserir linha");
		BtnAdd.setHideActionText(true);
		 
		JButton BtnLimpar = new JButton();	// Cria Botão
		BfAddLinha.add(BtnLimpar);	// Adiciona Botão ao Painel
		BtnLimpar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnLimpar16.png"));
		BtnLimpar.setCursor(new Cursor(Cursor.HAND_CURSOR));
		BtnLimpar.setToolTipText("Limpar tabela");
		BtnLimpar.setHideActionText(true);
 
		  
		// Ouvir eventos - Combos
        cbLinha.addActionListener(new java.awt.event.ActionListener() {  
            public void actionPerformed(java.awt.event.ActionEvent evt) {  
                cbLinhaActionPerformed(evt);  
            }  
        });  
        cbPlaca.addActionListener(new java.awt.event.ActionListener() {  
            public void actionPerformed(java.awt.event.ActionEvent evt) {  
                cbPlacaActionPerformed(evt);  
            }  
        });  
        cbBloco.addActionListener(new java.awt.event.ActionListener() {  
            public void actionPerformed(java.awt.event.ActionEvent evt) {  
                cbBlocoActionPerformed(evt);  
            }  
        });  
        cbSlot.addActionListener(new java.awt.event.ActionListener() {  
            public void actionPerformed(java.awt.event.ActionEvent evt) {  
                cbSlotActionPerformed(evt);  
            }  
        });  
        cbPorta.addActionListener(new java.awt.event.ActionListener() {  
            public void actionPerformed(java.awt.event.ActionEvent evt) {  
                cbPortaActionPerformed(evt);  
            }  
        });  
        
        cbProtocolo.addActionListener(new java.awt.event.ActionListener() {  
            public void actionPerformed(java.awt.event.ActionEvent evt) {  
                cbProtocoloActionPerformed(evt);  
            }  
        });  
        cbHz.addActionListener(new java.awt.event.ActionListener() {  
            public void actionPerformed(java.awt.event.ActionEvent evt) {  
                cbHzActionPerformed(evt);  
            }  
        });  
   	 	cbVt.addActionListener(new java.awt.event.ActionListener() {  
   	 		public void actionPerformed(java.awt.event.ActionEvent evt) {  
             cbVtActionPerformed(evt);  
   	 		}  
   	 	});  
   	 	cbPino.addActionListener(new java.awt.event.ActionListener() {  
   	 		public void actionPerformed(java.awt.event.ActionEvent evt) {  
   	 			cbPinoActionPerformed(evt);  
   	 		}  
   	 	}); 
		
	
		// Ouvir Eventos - Botões
        BtnAdd.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
            	BtnAddActionPerformed(evt);
            }
        });
        BtnLimpar.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
            	BtnLimparActionPerformed(evt);
            }
        });
        
		
		
	} // final do metodo BfAddLinha

	// // Pegar Eventos - Combos
    private void cbLinhaActionPerformed(java.awt.event.ActionEvent evt) {  
	     int indiceDoCombo = cbLinha.getSelectedIndex();  
	     objDef.sCBoxLinha = cbLinha.getSelectedItem().toString();  
	} 
   private void cbPlacaActionPerformed(java.awt.event.ActionEvent evt) {  
	     int indiceDoCombo = cbPlaca.getSelectedIndex();  
	     objDef.sCBoxPlaca = cbPlaca.getSelectedItem().toString();  
	} 
   private void cbBlocoActionPerformed(java.awt.event.ActionEvent evt) {  
	     int indiceDoCombo = cbBloco.getSelectedIndex();  
	     objDef.sCBoxBloco = cbBloco.getSelectedItem().toString();  
	} 
	private void cbSlotActionPerformed(java.awt.event.ActionEvent evt) {  
	     int indiceDoCombo = cbSlot.getSelectedIndex();  
	     objDef.sCBoxSlot = cbSlot.getSelectedItem().toString();  
	}  
	private void cbPortaActionPerformed(java.awt.event.ActionEvent evt) {  
	     int indiceDoCombo = cbPorta.getSelectedIndex();  
	     objDef.sCBoxPorta = cbPorta.getSelectedItem().toString();  
	}  	
	private void cbProtocoloActionPerformed(java.awt.event.ActionEvent evt) {  
	     int indiceDoCombo = cbProtocolo.getSelectedIndex();  
	     objDef.sCBoxProtocolo = cbProtocolo.getSelectedItem().toString();  
	} 		
	private void cbHzActionPerformed(java.awt.event.ActionEvent evt) {  
	     int indiceDoCombo = cbHz.getSelectedIndex();  
	     objDef.sCBoxHz = cbHz.getSelectedItem().toString();  
	} 	

		
	private void cbVtActionPerformed(java.awt.event.ActionEvent evt) {  
	     int indiceDoCombo = cbVt.getSelectedIndex();  
	     objDef.sCBoxVt = cbVt.getSelectedItem().toString();  
	} 		

	private void cbPinoActionPerformed(java.awt.event.ActionEvent ePino) {  
	     int indiceDoCombo = cbPino.getSelectedIndex();  
	     objDef.sCBoxPino = cbPino.getSelectedItem().toString();  
	} 	

	private void BtnAddActionPerformed(java.awt.event.ActionEvent evt) {
	 	
		//AddLinha(Tabela);	// Adiciona a Tabela
		
		
		// objLog.Metodo("Entrei set16: objDef.sCBoxLinha: " + objDef.sCBoxLinha);
		
		if( (!objDef.sCBoxLinha.contains("N"))	// N
	 	&&  (!objDef.sCBoxPlaca.contains("t"))	// Porta: numeros de portas na placa: 24, 32, 48...
	 	&&	(!objDef.sCBoxBloco.contains("c")) ){	// Bloco
	 	    	
	 	     		
	 	    		if( (!objDef.sCBoxSlot.contains("o"))
	 	    		&&	(!objDef.sCBoxPorta.contains("a")) ){
	 	    			
	 	    			if( (tfDslam.getText().contains("6"))    			
	 	    			&&  (!objDef.sCBoxProtocolo.contains("to")) ){
	 	    				
	 	    				if( (!objDef.sCBoxVt.contains("t"))
	 	    				&&	(!objDef.sCBoxHz.contains("z"))
	 	    				&&	(!objDef.sCBoxPino.contains("o")) ){	 	    		
	 	    					
	 	    					AddLinha(Tabela);	// Adiciona a Tabela
	 	    				
	 	    				}else{ objCxD.Aviso("Você deve informar: Vt, Hz e Pino.", true); }    					
	 	    			}else{ objCxD.Aviso("Você deve informar: Dslam, Prot. e Descrição.", true); }    			    					
	 	    		}else{ objCxD.Aviso("Você deve informar: Slot e Porta.", true); }		
	 	    	}else{ objCxD.Aviso("Você deve informar: Linha, N.Portas e Bloco.", true); }	
		
		
	}
	
	private void BtnLimparActionPerformed(java.awt.event.ActionEvent evt) {
		
		int iTReg = objUtil.ContarReg(Tabela);	// Conta numero de registros na tabela
		if( iTReg > 1){							// Verifica NumReg
	
			if(objCxD.Confirme("Apagar todos os dados da tabela?", objDef.bMsgExcluir) )
			{
				objUtil.LimparTabela(Tabela);			
				LimparItensFiltro("Filtrar campos...");
			}
		}else{ objCxD.Aviso("Não há registros a serem excluidos.", true); }
		
		
		
	}
	/******************************************************************************************************/
	// Bar.Fer de testes 
	public void ConstruirBfTeste(){
	
		objLog.Metodo("mtaView().ConstruirBfTeste()");				
		
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
		objLog.Metodo("mtaView().BtnTstSincActionPerformed()");
		Iniciar(objDef.tstMODEM);
		
		
		
	}

	private void BtnTstAuthActionPerformed(java.awt.event.ActionEvent evt) { 
		
	

		try{
			LerConfig(objDef.bCriptoConfig);
		}catch(IOException e){
			objLog.Metodo("mtaView().SalvarConfig(Erro ao gravar Arquivo)");
		}finally{
			objCxD.Aviso("Arquivo mta Salvo !", objDef.bMsgSalvar);
		}
	
	}
	
	private void BtnTstPingActionPerformed(java.awt.event.ActionEvent evt) { 

		
		

	}// Eventos
	
	/******************************************************************************************************/
	
	public void ConstruirBfCoordFiltro(){
		// Barra Fer.Coord + Filtro (Em uso)  
		objLog.Metodo("mtaView().ConstruirBfCoordFiltro()");				
		
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
		BtnFiltrar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnFiltro16.png"));
		BtnFiltrar.setToolTipText("Aplicar filtro");
		BtnFiltrar.setHideActionText(true);
		BtnFiltrar.setCursor(new Cursor(Cursor.HAND_CURSOR));
		BfFiltro.add(tfFiltro);
		
				
		// Posição [A1]
		
		tfCoord.setColumns(5);
		tfCoord.setText("SEQ0, MD0");
		tfCoord.setEditable(false);	// Bloquear edição	
	
	}

	// Final das Barra de ferramentas
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
	
	public void ConstruirTabela(boolean bAjustar){
		 
		objLog.Metodo("mtaView().ConstruirTabela(" + bAjustar + ")");				
			
		 BfTabela.setFloatable(false);	 
		 BfTabela.setRollover(true);
		 // (Componente, Col, LInha, Larg, Altura)
		 if(bAjustar){
			 AddPainel(BfTabela,1, objDef.bfTabLinIni + 25, objDef.iTelaLarg, objDef.AltTabela - 25);
		 }else{
			 AddPainel(BfTabela,1, objDef.bfTabLinIni, objDef.iTelaLarg, objDef.AltTabela);
		 }
		 
		 Tabela.setModel(ModeloTab); 				// Modelotab - variavel Global 
		 Tabela.setAutoResizeMode(JTable.AUTO_RESIZE_OFF);
		 
		 Tabela.addRowSelectionInterval(0, 0);	//Seleciona a linha
		 Tabela.setFont( new Font("arial", Font.PLAIN, 12) );
		 

		// Alinha Texto da coluna à esquerda
		DefaultTableCellRenderer cellRender = new DefaultTableCellRenderer(); 
		
		cellRender.setHorizontalAlignment(SwingConstants.LEFT);			
		Tabela.getColumnModel().getColumn(objDef.colDSLAM).setCellRenderer(cellRender);	// Alinha a esquerda
		Tabela.getColumnModel().getColumn(objDef.colOBS).setCellRenderer(cellRender);	// Alinha a esquerda
		
					

		 // CORES		 
		 Tabela.setSelectionForeground(Color.BLACK); 	// Texto da linha selecionada
		 Tabela.setForeground(Color.BLACK);  			// texto
		 Tabela.setBackground(Color.WHITE); 			// Fundo		  
		 Tabela.setShowGrid(true);						// Linhas de Grade
		 
		// Tabela.setOpaque(true);
			
			
		 //---------------------------------------------------------------------
		 // Cores: Sim, Não, Analisado
			Tabela.getColumnModel().getColumn(objDef.colACAO).setCellRenderer(new RenderCorOpcao());		
		
		// Rederizar Listras
			for(int iC=1; iC < Tabela.getColumnCount(); iC++){
				Tabela.getColumnModel().getColumn(iC).setCellRenderer(new RenderListras());
			}
			
			// Cor da linha selecionada(seleção)
			// Tabela.setSelectionBackground(Color.cyan); 
		 //--------------------------------------------------------------------------------------
		 // Alinhamento do texto
		 Tabela.setDefaultRenderer(Object.class, new RenderAlinhaTexto()); // Centraliza o texto(completo)
		
		//---------------------------------------------------------------------
		
		 
		 /***************************************************************************/
		 //--------------------------------------------------------------------------
		 // Inclui Cx de Seleção nas células[Ambos, PPPoA, PPPoE] - [Sim, Não, OK, Sml] 
		 // +1: Ajuste necessario após congelar coluna "N"(passou ter 2 colunas endereçadas como Zero
	     Tabela.getColumnModel().getColumn(objDef.colACAO + 1).setCellEditor(CxSelTeste);
	     Tabela.getColumnModel().getColumn(objDef.colPROTOCOL + 1).setCellEditor(CxSelProtocol);
	     //--------------------------------------------------------------------------
		 // Filtro de Classificação das Celulas - A-Z, Z-A		 
		 final TableRowSorter<TableModel> sorter =  new TableRowSorter<TableModel>(ModeloTab);
		 Tabela.setRowSorter(sorter);
		 
		
      //--------------------------------------------------------------------------
      // Cria Filtro de conteudos da Tabela
      Tabela.setSelectionMode(ListSelectionModel.SINGLE_SELECTION);
      
      // Attach a list selection listener to the jtTabela's selection tmModelo, to
      // be notified whenever the user selects a row. Use this opportunity to
      // output the view and tmModelo indices on the status label.
      ListSelectionListener lslCapturaSelecao;
      lslCapturaSelecao = new ListSelectionListener(){
                public void valueChanged(ListSelectionEvent lse){
                   int index = Tabela.getSelectedRow();
                   if (index != -1){
                       String status;
                       status = "Ver índice = " + index + ", Modelo do índice = ";
                       status += Tabela.convertRowIndexToModel(index);
                       lblStatus.setText(status);
                   }
                }
            };
      Tabela.getSelectionModel().addListSelectionListener(lslCapturaSelecao);

      // Cria e instala rotinas de filtragem
      final TableRowSorter trsClassificar;
      trsClassificar = new TableRowSorter(ModeloTab);
      Tabela.setRowSorter(trsClassificar);
      
      // Fill northern region of GUI with scrollpane.
      getContentPane().add(BRolagemTabela, BorderLayout.NORTH);

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
            	    *  - A idéia aqui era inserir 2 linhas com mesmos dados do filtro("Filtrar: " + tfFiltro.getText())
            	    *  		para entrar na filtragem, assim 2 linhas a mais seriam adicionadas, e aparecem no filtro 
            	    *  		o problema é que estas linhas adicionadas, não saem após tirar o filtro 
            	    *  		e a tabela vai incrementado linhas adicionais, a cada uso do filtro 
            	    * BUG:
            	    *  - Aplica-se filtro e fica somente 3 linhas 
            	    *  - Ao Exec. o testes qdo chega na 4 Linha o sistema trava 
            	    *  
            	    *  - Qdo usa a rotina alterar uma linha, ao invez de inserir linhas com: 
            	    *  		- Tabela.setValueAt("Filtro: 02/", 100, objDef.colOBS);
            	    *  		funciona, mas na volta do filtro, trava
            	    */
            	   
            	   /*
            	   if(tfFiltro.getText() != ""){
            		//  String[] sLinhas = new String[]{ "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "Filtrar: " + tfFiltro.getText() };
            		//  ModeloTab.addRow(sLinhas); 		// Adiciona linha pre-formatada acima(com texto de filtro), a matriz
            		  Tabela.setValueAt("Filtro: " + tfFiltro.getText(), 100, objDef.colOBS);
            	   }
            	   */
            	   
            	   // ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            	  /*
            	   * Esta rotina trava filtro ao retornar a Plan-Full
            	   if(tfFiltro.getText() != ""){
            		   Tabela.setValueAt(tfFiltro.getText().toString(), 10, objDef.colDSLAM);
            	   }
                   */
            	  
            	   /*
            	   if(tfFiltro.getText()!=""){  objDef.bFiltroAplicado = true; }
            	   else{  objDef.bFiltroAplicado = false; } 
            	  */
            	   objLog.Metodo("mtaView().BtnFiltrar().click()"); 
                  // Install a new row filter.
                  String FiltrarExpressao = tfFiltro.getText();
                  trsClassificar.setRowFilter(RowFilter.regexFilter(FiltrarExpressao));

                  // Unsort the view.
                  trsClassificar.setSortKeys(null);
                  
                  /*
                   *  Atualiza núm.registros visíveis na tabela, após filtro
                   *  Usado pelo sistema para calculos de varredura de linhas na tabela
                   */
                  objDef.iTotalLinTab = trsClassificar.getViewRowCount(); 
                  
                  
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
      
		 int iNumLinTab = Tabela.getRowCount();			// Pega o número de linhas
		
		  //Ajusta largura de todas as colunas - padrão
		//  TableColumn colTAB = Tabela.getColumnModel().getColumn(1);
		 // int width = 100;
		 // colTAB.setPreferredWidth(width);
		 
		 // ---------------------------------------------------------------------------------------
		 // Ajusta largura PADRÃO da coluna(N)   
		 Tabela.getColumnModel().getColumn(objDef.colN).setPreferredWidth(35);	// Preferencial
		
		// Ajusta altura de todas as linha
		 Tabela.setRowHeight(objDef.iAlturaLinTab); 		 

		 // Congela coluna "N"
		 RenderCongelarColuna objCongelar = new RenderCongelarColuna(1, BRolagemTabela);  
		 Tabela.setAutoResizeMode(Tabela.AUTO_RESIZE_OFF); 
		 
				 
		 Tabela.getColumnModel().getColumn(objDef.colDSLAM).setPreferredWidth(170);	// Preferencial		 
		 Tabela.getColumnModel().getColumn(objDef.colDSLAM).setMaxWidth(200);  		// Larg.Max		 
		 Tabela.getColumnModel().getColumn(objDef.colDATAD).setPreferredWidth(60);	// Preferencial
		 Tabela.getColumnModel().getColumn(objDef.colPROTOCOL).setPreferredWidth(60);	// Preferencial		 
		 Tabela.getColumnModel().getColumn(objDef.colHZ).setPreferredWidth(30);	// Preferencial
		 Tabela.getColumnModel().getColumn(objDef.colVT).setPreferredWidth(30);	// Preferencial
		 Tabela.getColumnModel().getColumn(objDef.colPINO).setPreferredWidth(40);	// Preferencial
		 Tabela.getColumnModel().getColumn(objDef.colDESC).setPreferredWidth(250);	// Preferencial
		 
		 Tabela.getColumnModel().getColumn(objDef.colIP).setPreferredWidth(100);	// Preferencial   
		 Tabela.getColumnModel().getColumn(objDef.colPING).setPreferredWidth(200);	// Preferencial
		 Tabela.getColumnModel().getColumn(objDef.colDATA).setPreferredWidth(130);	// Preferencial
		 Tabela.getColumnModel().getColumn(objDef.colOBS).setPreferredWidth(250);	// Preferencial
		 // ---------------------------------------------------------------------------------------
		// Carregar(Add) linhas na Tabela
		objLog.Metodo("mtaView().Add-Lin-Tab: " + objDef.iTotalLinTab);
		for(int iL=0; iL <= objDef.iTotalLinTab; iL++){ 
			int iLx = iL + 1;
			ModeloTab.addRow(objDef.sTabLinhas); 		// Adiciona linha pre-formatada de matriz
			//Tabela.setValueAt(iLx, iL, objDef.colN);		// Numera Linhas
		}
		
		// Adiciona barra de rolagem a Bar.Ferramentas	 
		BfTabela.add(BRolagemTabela);	
		
				
		 // Pega click do mouse na TabelaComum
		 Tabela.addMouseListener(new MouseAdapter() {  
	            @Override  
	             public void mouseClicked(MouseEvent e) {
	            	// Botão Direito(1) do mouse
	            	if(e.getButton()==1){
	            		int iLin = Tabela.getSelectedRow() + 1;
	            		int iCol = Tabela.getSelectedColumn() + 1;
	            		//String sC = objUtil.NumToChar(iCol-1);
	            		//tfCoord.setText( sC + iLin );
	            		
	            		tfCoord.setText( objUtil.LinToSeqMd(Tabela.getSelectedRow()) );				// Atualiza coordenadas
	            		        	
	            		//tfCelula.setText( sC + iLin );	//[A1]
	            		tfCelula.setText( Tabela.getColumnName(iCol-1) + " [" +iLin + "]");	// Porta[1]	               
	            		tfTitulo.setText( Tabela.getColumnName(iCol-1) + " " +iLin + "]");	               	
	            		tfConteudo.setText( Tabela.getValueAt(Tabela.getSelectedRow(), Tabela.getSelectedColumn() ).toString() ); 
					
	            		objLog.Metodo("mtaView().Tabela.addMouseListener(new MouseAdapter()");				
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
	            					  
	            					  int iTReg = objUtil.ContarReg(Tabela);	// Conta numero de registros na tabela
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
	            						int iTReg = objUtil.ContarReg(Tabela);	// Conta numero de registros na tabela
	            				    	if( iTReg > 1){							// Verifica NumReg	            				    
	            				    		  int iLinSelecionada = Tabela.getSelectedRow();
	    	            					  int iLinNum = iLinSelecionada + 1; 	// Devido diferença entre linhas: 0(Sistema), 1(usuário)
	    	            					  if(objCxD.Confirme("Excluir a linha " + iLinNum + "("+ Tabela.getValueAt( iLinSelecionada, 0) +"...) da tabela ?", objDef.bMsgExcluir)){
	    	            						  	DeletarLinha(iLinSelecionada);	    	            						  	
	    	            					  }
	    	            				}else{ objCxD.Aviso("Não há registros a serem excluidos.", true); }
			  }	            				
	            			  });
	            			  
	            			 // Pmenu.addSeparator();
	            			  
	            			  menuItem = new JMenuItem("Inserir linha", new ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnAddLinha16.png"));
	            			  Pmenu.add(menuItem);
	            			  menuItem.addActionListener(new ActionListener(){	            				  
	            				  public void actionPerformed(ActionEvent e){
	            					  
	            					  int iTReg = objUtil.ContarReg(Tabela);	// Conta numero de registros na tabela
	            				    	if( iTReg > 1){							// Verifica NumReg	            				    
	            				    		 int iLinSel = Tabela.getSelectedRow();	  	            					  
		            						 InserirLin(iLinSel);
	            				    	}else{ objCxD.Aviso("Não há registros a serem movidos.", true); }
      				  }	            				
	            			  });
	            			  
	            			  Pmenu.addSeparator();
	            			  
	            			  menuItem = new JMenuItem("Limpar tabela", new ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnLimpar16.png"));
	            			  Pmenu.add(menuItem);
	            			  menuItem.addActionListener(new ActionListener(){
	            				  public void actionPerformed(ActionEvent e){	
	            						int iTReg = objUtil.ContarReg(Tabela);	// Conta numero de registros na tabela
	            				    	if( iTReg > 1){							// Verifica NumReg	            				    
	            				    		  if(objCxD.Confirme("Apagar todos os registros da tabela?", objDef.bMsgExcluir)){
	    	            						  objUtil.LimparTabela(Tabela);
	    	            						  LimparItensFiltro("Filtrar campos...");
	    	            					  }
	            				     	}else{ objCxD.Aviso("Não há registros a serem excluidos.", true); }

	            					
	            				  }	            				
	            			  });  
	            			  
	            			  Pmenu.addSeparator();
	            			  
	            			  menuItem = new JMenuItem( "Salvar", new ImageIcon(objDef.DirRoot + "imagens/Icon_btn/Btnsalvar16.png") );
	            			  Pmenu.add(menuItem);
	            			  menuItem.addActionListener(new ActionListener(){
	            				  public void actionPerformed(ActionEvent e){	
	            					  int iTReg = objUtil.ContarReg(Tabela);	// Conta numero de registros na tabela
	            				    	if( iTReg > 1){							// Verifica NumReg	            				    
	            				     	
	            				    	}else{ objCxD.Aviso("Não há registros a serem salvos.", true); }
	            				  }	            				
	            			  });  
	            			  
	            			  Pmenu.addSeparator();
	            			  
	            			  menuItem = new JMenuItem("Propriedades", new ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnPropriedades16.png"));
	            			  Pmenu.add(menuItem);
	            			  menuItem.addActionListener(new ActionListener(){
	            				  public void actionPerformed(ActionEvent e){	
	            					  objFrmPropriedadesTab.Construir();
	            				  }	            				
	            			  });  
	            			  
	            			  Tabela.addMouseListener(new MouseAdapter(){
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
		 Tabela.addKeyListener(new java.awt.event.KeyAdapter() {             
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
	                    
	                	int iLin = Tabela.getSelectedRow() + 1;
		            	int iCol = Tabela.getSelectedColumn() + 1;
		            	//String sC = objUtil.NumToChar(iCol-1);		            	
		               	//tfCoord.setText( sC + iLin );        	
		               	// tfCelula.setText( sC + iLin );
		            	
		    			
		    			tfCoord.setText( objUtil.LinToSeqMd(Tabela.getSelectedRow()) );				// Atualiza coordenadas

		               	tfCelula.setText( Tabela.getColumnName(iCol-1) + " [" +iLin + "]");	// Porta[1]
		               	tfTitulo.setText( Tabela.getColumnName(iCol-1) + " [Lin: " +iLin + "]");		               
		              	tfConteudo.setText( Tabela.getValueAt(Tabela.getSelectedRow(), Tabela.getSelectedColumn() ).toString() ); 
						objLog.Metodo("mtaView().Tabela.addKeyListener(new java.awt.event.KeyAdapter()");
	                }  
	            }             
	        });  
		
	}
	

	/******************************************************************************************************/
	public void ConstruirBfTelnet(){	 
		
		objLog.Metodo("mtaView().ConstruirBfTelnet()");
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
	            					  tfStatus.setText("Texto: " + objDef.iTamTexto);
	            			      }	            				
	            			  });
	            			  menuItem = new JMenuItem("ZoomOff", new ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnZoomOff16.png"));
	            			  Pmenu.add(menuItem);
	            			  menuItem.addActionListener(new ActionListener(){	            				  
	            				  public void actionPerformed(ActionEvent e){
	            					  objDef.IncTamTexto(false, 1);
	            					  taTelnet.setFont(new java.awt.Font("Courier New", 0, objDef.iTamTexto)); 	// Fonte: tipo, tamanho
	            					  tfStatus.setText("Texto: " + objDef.iTamTexto);
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
		
     objLog.Metodo("mtaView().ConstruirBfGrade()");
     
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
		
     objLog.Metodo("mtaView().ConstruirBfSLine()");
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
		
     objLog.Metodo("mtaView().ConstruirBfLog()");
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
		
		objLog.Metodo("mtaView().ConstruirBStatus()");
		
		BStatus.setFloatable(false);	 
		BStatus.setRollover(true);		
		
		AddPainel(BStatus, 1, objDef.iBStLinIni, objDef.iTelaLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
		
		JSeparator SeparaBStatus = new JSeparator();
		SeparaBStatus.setOrientation(SwingConstants.VERTICAL);
		BStatus.add(SeparaBStatus);


		BStatus.add(tfStatus);
		tfStatus.setColumns(50);
		tfStatus.setText("mtaView...");
		tfStatus.setEditable(false);	// Bloquear edição
		
}

public void ConstruirBStatus2(){
	
	objLog.Metodo("mtaView().ConstruirBStatus2()");
	
	BStatus.setFloatable(false);	 
	BStatus.setRollover(true);		
	
	AddPainel(BStatusTeste, 1, objDef.iBStLinIni, 100, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
	AddPainel(BStatus, 100, objDef.iBStLinIni, objDef.iTelaLarg, objDef.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
	
	JSeparator SeparaBStatusDesc = new JSeparator();
	SeparaBStatusDesc.setOrientation(SwingConstants.VERTICAL);
	BStatus.add(SeparaBStatusDesc);


	BStatusTeste.add(tfStatusTeste);
	tfStatusTeste.setForeground(Color.white);
	tfStatusTeste.setBackground(Color.decode("#008B00"));
	tfStatusTeste.setColumns(10);
	tfStatusTeste.setHorizontalAlignment(JTextField.CENTER);  
	tfStatusTeste.setText(objDef.StatusTstParar);
	tfStatusTeste.setEditable(false);	// Bloquear edição
	
	
	BStatus.add(tfStatus);
	//tfStatus.setBackground(Color.LIGHT_GRAY);
	tfStatus.setColumns(50);
	tfStatus.setText("mtaView...");
	tfStatus.setEditable(false);	// Bloquear edição
	
}


/********************************************************************************************************************/

	public void CarregarCbFiltro(){
	
		objLog.Metodo("mtaView().CarregarCbFiltro()");
	
		int iNumLinTab = Tabela.getRowCount();			// Pega o número de linhas
		for(int iF=0; iF < iNumLinTab; iF++){
			//cbFiltro.addItem( TabelaComum.getValueAt(iF, TabelaComum.getSelectedColumn() ).toString() ); 
			if(Tabela.getValueAt(iF, 0) != ""){
				cbFiltro.addItem(Tabela.getValueAt(iF, 0));
			}
		}
	}

	public void LimparSequencia(int iSequencia){
	
		/*
		 *  Apaga registros de testes da sequencia atual
		 *  Preserva campos de importação e observação 
		 */
		
		objLog.Metodo("mtaView().LimparSequencia(" + iSequencia +")");
		
		int iNumLinTab = Tabela.getRowCount();	
		int iNumColTab = Tabela.getColumnCount() - 1;		// (-1)Preserva campo obs
		
		
		
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
			if(Tabela.getValueAt(iLinDaSeq, objDef.colDSLAM).toString().contains("6")){
				Tabela.setValueAt(objDef.AcaoTestar, iLinDaSeq, objDef.colACAO);		// Seta coluna Testar = Sim
			}
			for(int iC=8; iC < iNumColTab; iC++){
				 Tabela.setValueAt("", iLinDaSeq, iC);	// Limpa colunas do testes anterior
			}
		}
		
	}
	
	public void LimparTestes(int iTotLin){
		
		/*
		 *  Apaga registros de testes da sequencia atual
		 *  Preserva campos de importação e observação 
		 */
		
		objLog.Metodo("mtaView().LimparTestes("+iTotLin+")");
		
		int iNumLinTab = Tabela.getRowCount();	
		int iNumColTab = Tabela.getColumnCount() - 1;		// (-1)Preserva campo obs
		
		
		
		for(int iLinDaSeq=0; iLinDaSeq < iTotLin; iLinDaSeq++){
			//int iLinDaSeq = objUtil.SeqToLin(iSequencia, iM);
			
			/*
			 *  Verifica se Col-Porta possui registro
			 *  Caso Sim: seta col-Ação = Testar
			 *  Caso Não: Pula
			 *  
			 *  Evita habilitar testes("Testar") na sequência de ações:
			 *  Repetir testes no final dos registros de uma seu~enci incompleta
			 *   
			 */
			if(Tabela.getValueAt(iLinDaSeq, objDef.colDSLAM).toString().contains("6")){
				Tabela.setValueAt(objDef.AcaoTestar, iLinDaSeq, objDef.colACAO);		// Seta coluna Testar = Sim
			}
			for(int iC=8; iC < iNumColTab; iC++){
				 Tabela.setValueAt("", iLinDaSeq, iC);	// Limpa colunas do testes anterior
			}
		}
		
	}
	
	public void LimparItensFiltro(String sTexto){
		
		objLog.Metodo("mtaView().LimparFiltro()");
		
		cbFiltro.removeAllItems();	// Deleta itens da combo filtrar
		cbFiltro.addItem(sTexto);		
		
		cbLinha.setSelectedIndex(0);
		tfDslam.setText("");
		cbSlot.setSelectedIndex(0);
		cbPlaca.setSelectedIndex(0);
		cbPorta.setSelectedIndex(0);
		tfDataDf.setText(Formatar.format(data));
		cbProtocolo.setSelectedIndex(0);
		cbBloco.setSelectedIndex(0);
		cbVt.setSelectedIndex(0);
		cbHz.setSelectedIndex(0);
		cbPino.setSelectedIndex(0);
		tfDesc.setText("");
		
	}

	public void CriarCSV(){
		
	// Pega dados da tabela e formata linha a linha em CSV(separados por virgula)	
		objLog.Metodo("mtaView().CriarCSV()");
		
		int iNumCol = Tabela.getColumnCount();
		int iNumLin = Tabela.getRowCount();
		String sLinhaCSV = objDef.sTabTitulo;
		objUtil.SalvarCSV(sLinhaCSV);	// Salva linha em arquivo
		sLinhaCSV = "";					// Limpa linha(Titulos da Tab)
				
		for(int iL=0; iL<iNumLin; iL++){
			for(int iC=0; iC<iNumCol; iC++){
				sLinhaCSV = sLinhaCSV + Tabela.getValueAt(iL, iC) + ";";
			}
			objUtil.SalvarCSV(sLinhaCSV);	// Salva linha em arquivo
			sLinhaCSV = "";					// Limpa linha
		}
		
		
		
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
 	
 	objDef.FixePlanCorrente(sDir);	// Atualiza var
 	
 	/* Carrega a planilha */
 	 Workbook objLivroDeTrabalho = Workbook.getWorkbook(new File(sDir));

     Sheet sheet = objLivroDeTrabalho.getSheet(0);
     
     /* Pega Numero de linhas com dados do xls */
     // Fica memorizado para salvar arquivo INI, etc 
     objDef.iMemNumLin = sheet.getRows(); 
     objDef.iMemNumCol = sheet.getColumns();
     
             
    // Carrega Tabela
     for(int iL = 0; iL < objDef.iMemNumLin; iL++){
         for(int iC = 0; iC < objDef.iMemNumCol; iC++){	// Inicia em 1, pois a 0 já esta numerada
         	int iColTab = iC + 1;
             Cell celula = sheet.getCell(iC, iL);
            	Tabela.setValueAt( celula.getContents(), iL, iC);
         }
         int iLx = iL + 1;
         // NumerarLinhas 	// Numera linhas da Tabela
         Tabela.setValueAt( objDef.AcaoTestar, iL, objDef.colACAO);		// Numera linhas da Tabela
         
         
         // Cores: Listras(Linha-sim, linha não)
			for(int iC=1; iC < Tabela.getColumnCount(); iC++){
				Tabela.getColumnModel().getColumn(iC).setCellRenderer(new RenderListras());
			}
			
			
			// ModeloTab.addRow(objDef.sTabLinhas);			// Adiciona Linha a tabela
		  
     }  
    
   
     
 }  // CarregarExcel()
 

 public void backupMTA(String sDirNome){
 	
 	objLog.Metodo("mtaView().backupMTA("+ sDirNome +")");
 	
 	try{
 		
 		IniFiles objArqIni = new IniFiles();
 		for(int iL=0; iL < objDef.iMemNumLin; iL++){
				for(int iC=0; iC < objDef.iTotColuna; iC++){
					
					String sChave = objUtil.NumToChar(iC) + String.valueOf(iL);
					objArqIni.EscreverIni(sDirNome, "Mta", sChave, Tabela.getValueAt(iL, iC).toString());
				
				}			
			}
 		
 	
 		
 	
 	}catch(IOException e){
 		objLog.Metodo("mtaView().salvarMTA().IniFiles(Erro ao gravar Arquivo)");
 	}finally{
 		objCxD.Aviso("Arquivo mta Salvo !", objDef.bMsgSalvar);
 	}
 	
 }
 
 public void LerTArea(int iVersao, int iModem, int iTipo, int iLinMd){
 
 	objLog.Metodo("mtaView().LerTArea(V: "+iVersao+" Md: "+iModem+", Teste: "+iTipo+", LinMD: "+iLinMd+")");
		
		
 	String sLinTxt[] = taTelnet.getText().split("\n"); 
 	int iTam = sLinTxt.length;
 	objLog.Metodo("LerTArea(Num.Lin: " + iTam + " )");
 	objLog.Metodo("------------------------------------------------------");
 	
 	for(int iL=0; iL<iTam; iL++){    		
 		if(iVersao == objDef.HubDLink){ objDLinkOpticom.Decode(iTipo, Tabela, iLinMd, sLinTxt[iL]); }
 		if(iVersao == objDef.Dsl2500e){ objDsl2500e.Decode(iTipo, Tabela, iLinMd, sLinTxt[iL]); } 
 		
 	} 
 	
 	VerificarDecode(iModem, iLinMd);
 	
 }
 
 public void VerificarDecode(int iModem, int iLinMD){
 	// Verifica resultado do decode...
 	objLog.Metodo("------------------------------------------------------");
 	objLog.Metodo("VerificarDecode(LinMD: "+iLinMD+")");
 	
 	String sMinAj = "00";
 	String sSegAj = "00";
 	
 	// VER.SINCRONISMO
 	String sSin = Tabela.getValueAt(iLinMD, objDef.colSINC).toString();
 	if( sSin.toLowerCase().contains("up") ){ 
 		 
 		
 		if(!objUtil.bSinc[iModem]){
 				
 				/*
 				 * Ajusta diferença de tempos
 				 * As Leiturasde cada modem inicia com 15 segundos de diferença
 				 * então, ajusta tempos
 				 */
 				// Carrega Tempo decorrente para sincronizar
 				String sTempoAjustado = objUtil.AjusteTempo(iModem, 15, PegueSeg(), PegueMin());
 				Tabela.setValueAt(sTempoAjustado, iLinMD, objDef.colSincT);
 			
 				AtualizarGrafico(iModem, iLinMD, objDef.STATUS);
 				
     		}
     		
 			objUtil.bSinc[iModem] = true;		// Informa ctrl que esta sincronizado
 			objLog.Metodo("LerTArea(bSinc["+iModem+"] = true," + sSin + ")"); 
 			
 	}else{
 		
 		objUtil.bSinc[iModem] = false;
 		objLog.Metodo("LerTArea(bSinc["+iModem+"] = false," + sSin + ")");
 		
 	}
 	
 	// VER.AUTENTICAÇÃO
 	String sAut = Tabela.getValueAt(iLinMD, objDef.colAUTH).toString();
 	if( sAut.toLowerCase().contains("up") ){ 
 		 
 		if(!objUtil.bAuth[iModem]) {
 			
 			// Carrega Tempo decorrente
 			String sTempoAjustado = objUtil.AjusteTempo(iModem, 15, PegueSeg(), PegueMin()); 			
 			Tabela.setValueAt(sTempoAjustado, iLinMD, objDef.colAutT);
 			
 			AtualizarGrafico(iModem, iLinMD, objDef.AUTH); 			
		}
 		objUtil.bAuth[iModem] = true;	// Informa CTRL que esta autenticado
 		objLog.Metodo("LerTArea(bAut["+iModem+"] = true," + sAut +")" );
 		
 	}else{
 		
 		objUtil.bAuth[iModem] = false;
 		objLog.Metodo("LerTArea(bAut["+iModem+"] = false," + sAut +")" );
 		
 	}
 	
 	// Ver.NAVEGAÇÃO(ping)
 	String sNav = Tabela.getValueAt(iLinMD, objDef.colNAV).toString();
 	if( sNav.toLowerCase().contains("up") ){ 
 		
 		if(!objUtil.bPing[iModem]){

 			// Carrega Tempo decorrente
 			String sTempoAjustado = objUtil.AjusteTempo(iModem, 15, PegueSeg(), PegueMin());
 			Tabela.setValueAt(sTempoAjustado, iLinMD, objDef.colNavT);
 			
 			AtualizarGrafico(iModem, iLinMD, objDef.PING);
 		}
 		objUtil.bPing[iModem] = true;  //  CTRL que esta navegando
 		objLog.Metodo("LerTArea(bPing["+iModem+"] = true," + sNav +")" );
 		
 		
 	}else{
 		
 		objUtil.bPing[iModem] = false;
 		objLog.Metodo("LerTArea(bPing["+iModem+"] = false," + sNav +")" );
 		
 	}
 	
	
 }
 
 public void AtualizarGrafico(int iModem, int iLinMD, int iQuem){
	 
	 objLog.Metodo("mtaView().AtualizarGrafico("+iModem+", "+iLinMD+")");
	 
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
	 		iSrUP = (int)Double.parseDouble(Tabela.getValueAt(iLinMD, objDef.colSrUP).toString());
	 		iSrDN = (int)Double.parseDouble(Tabela.getValueAt(iLinMD, objDef.colSrDN).toString());

	 		iAtUP = (int)Double.parseDouble(Tabela.getValueAt(iLinMD, objDef.colAtUP).toString());
	 		iAtDN = (int)Double.parseDouble(Tabela.getValueAt(iLinMD, objDef.colAtDN).toString());
		
	 		iCrcUP = (int)Double.parseDouble(Tabela.getValueAt(iLinMD, objDef.colCrcUP).toString());
	 		iCrcDN = (int)Double.parseDouble(Tabela.getValueAt(iLinMD, objDef.colCrcDN).toString());
	 		
	 		gGrafico.setSinais(iModem, iSrUP, iSrDN, iAtUP, iAtDN, iCrcUP, iCrcDN);
	 		// Pega os Tempos		
			iTSinc = objUtil.HoraToSeg( Tabela.getValueAt(iLinMD, objDef.colSincT).toString() );
			gGrafico.setTempos(iModem, iTSinc, iTAut, iTNav);
		}
	 	
		if(iQuem == objDef.AUTH){
			iTSinc = objUtil.HoraToSeg( Tabela.getValueAt(iLinMD, objDef.colSincT).toString() );
			iTAut = objUtil.HoraToSeg( Tabela.getValueAt(iLinMD, objDef.colAutT).toString() );			
			gGrafico.setTempos(iModem, iTSinc, iTAut, iTNav);
		}
		
		if(iQuem == objDef.PING){
			iTSinc = objUtil.HoraToSeg( Tabela.getValueAt(iLinMD, objDef.colSincT).toString() );
			iTAut = objUtil.HoraToSeg( Tabela.getValueAt(iLinMD, objDef.colAutT).toString() );
			iTNav = objUtil.HoraToSeg( Tabela.getValueAt(iLinMD, objDef.colNavT).toString() );			
			gGrafico.setTempos(iModem, iTSinc, iTAut, iTNav);
		}
		
		if(iQuem == objDef.LEDSINC){
			gGrafico.setLeds(objUtil.bSinc[0], objUtil.bSinc[1], objUtil.bSinc[2], objUtil.bSinc[3]);
		}
		
		gGrafico.repinte(objDef.Linhas, objDef.bZoom);
		
		objLog.Metodo("VerificarDecode().iModem[0] - SRUP: " + iSrUP +", SRDN: " + iSrDN +", AtUP: "+iAtUP+", AtDN: "+ iAtDN + ", CrcUP: "+ iCrcUP + ", CrcDN: "+ iCrcDN);
	 
 }
 
 public void LerTxt_sem_uso(int iTipo, String sNomeArq, int iModem, int iLinMD){
		
		objLog.Metodo("mtaView().LerTxt(" + sNomeArq + ")");

		int iL = 0;		
	 	try { 
			FileReader arq = new FileReader(sNomeArq); 
			BufferedReader lerArq = new BufferedReader(arq); 
			String sLinTxt = lerArq.readLine(); // lê a primeira linha // a variável "linha" recebe o valor "null" quando o processo // de repetição atingir o final do arquivo texto
			while (sLinTxt != null) { 
				sLinTxt = lerArq.readLine(); // lê da segunda até a última linha
				// Dsl2730b, Dsl485, Dsl279
				//if(iModem == objDef.HubDLink){ objDLinkOpticom.Decode(Tabela, iLinAtualx, sLinTxt); }				
				if(iModem == objDef.Dsl2500e){ objDsl2500e.Decode(iTipo, Tabela, iLinMD, sLinTxt); }
				//if(iModem == objDef.Intelbras){ objIntelbras.Decode(Tabela, iLinAtualx, sLinTxt); }
				//if(iModem == objDef.Cisco1841){ objCisco1841.Decode(Tabela, iLinAtualx, sLinTxt); }
			} 
			arq.close();			
			
		} catch (IOException e) { 
			System.err.printf("Erro na abertura do arquivo: %s.\n", e.getMessage());
			
		} 
	 	
	}
 public void FixeParametros(){
	 
	 objLog.Metodo("mtaView().FixeParametros()");
	
	 /*
	  *  Teste de repasse de valores entre objetos: falhou !
	  *  Objetos diferentes, originados da mesma classe, mas não há interligação entre
	  *  2 objetos, e valores não são repassados
	  */
	
	 objLog.Metodo("mtaView().FixeParametros().Tempo=" + objDef.PegueTempoTeste());
	 objLog.Metodo("mtaView().FixeParametros().Simula="+ objDef.PegueSimulacao());
	 objLog.Metodo("mtaView().FixeParametros().IP="+ objDef.PegueIP(0));
	 objLog.Metodo("mtaView().FixeParametros().Mask="+ objDef.PegueMask());
	 objLog.Metodo("mtaView().FixeParametros().Login="+ objDef.PegueLogin());
	 objLog.Metodo("mtaView().FixeParametros().Senha="+ objDef.PegueSenha());
	 objLog.Metodo("mtaView().FixeParametros().Porta="+ objDef.PeguePorta());
	 objLog.Metodo("mtaView().FixeParametros().URLteste="+ objDef.PegueURLteste());
	 
	
 }
 
 
 public void AtivarTestes(){
	 
	 int iOpcao = 0;  // Default para Iniciar testes..
	 
	 objLog.Metodo("mtaView().AtivarTestes(e0)");
	 
	 objLog.Metodo("mtaView().AtivarTestes(e1).PeguePlanXls(" + objFrmOpcao.PeguePlanXls() + ")");
	 
	 try{
			LerConfig(objDef.bCriptoConfig);		// Carrega config 
	    } catch (IOException ex) {  
	   	 	objCxD.Aviso("Erro ao carregar arquivo de configuração, " + ex, objDef.bMsgErro);  
	    } finally{
	   	
	    } 
	
	// objCxD.Aviso( PegueTeste(), true);		 
	 
	 
	 if(objFrmOpcao.PeguePlanXls()){
		 objLog.Metodo("mtaView().AtivarTestes(e2)->PeguePlanXls("+objFrmOpcao.PeguePlanXls()+")");		 	
		 
		 FrmPrincipal.setTitle("mtaView - " + objDef.PeguePlanCorrente());
		 objDef.FixePlanCorrente(objFrmOpcao.tfImportarLista.getText());
		 objFrmOpcao.FixePlanXls(false);	// Reinicia		
		
	 }else{
		 objLog.Metodo("mtaView().AtivarTestes(e3)->PeguePlanXls("+objFrmOpcao.PeguePlanXls()+")");
		 objDef.FixePlanCorrente(objArquivo.PegueAbreDirArq());
		// FrmPrincipal.setTitle("mtaView - " + objArquivo.PegueAbreDirArq());	
		 objFrmOpcao.FixePlanXls(true);	// Seta como: "Indica que há endereço de arquivo na planilha"
		 
		 if(!FrmPrincipal.getTitle().contains("6")){
			 	FrmPrincipal.setTitle("mtaView - ...\\temp\\PrjTeste1.mta");
		 }	
	 }
     
	
	 
	 objArquivo.FixeAbreDirArq(null); 		// Reinicia para informar que titulo do FrmPrincipal deve ser pego(abaixo) do NovoPrf	 
	 			
 	/*
 	 * 1 - Verificar se exite dados na Tabela 	  
 	 */
 	
	 /*
	  *  Re-carrega Config para atualizar valores setados pelo usuário em FormOpcProjetos 
	  */
	// Atualiza titulo do Form com nome do projeto
	 //FrmPrincipal.setTitle("mtaView - " + objFrmOpcao.tfPrjNome.getText());	 
	 
	 int iNumLin = Tabela.getRowCount();	// Conta total de celulas na tabela(1001)
	 objLog.Metodo("mtaView().AtivarTestes(e4).iNumLin: "+ iNumLin);
	 
	 int iTReg = objUtil.ContarReg(Tabela);			// Conta numero de registros na tabela
	 objLog.Metodo("Total de registros: " + iTReg);
	// objDef.iTotalLinTab = iTReg;					// tava dadndo bug em: Modem excedeu numero... Informa total de linhas(con registros na tabela)

	 
	 
	 //-----------------------------------------------------------------------------------------//
	 // Verifica linhas já testadas para definir Linha inical do teste
	 for(int iC=0; iC<iTReg; iC++){		 
		 /*
		  *  Executa varredura na coluna Ação e procura pelo indicador diferente de "Testar"
		  */
		 if( (Tabela.getValueAt(iC, objDef.colACAO).toString().contains(objDef.AcaoEmSim) )
		 ||(Tabela.getValueAt(iC, objDef.colACAO).toString().contains(objDef.AcaoEmTst) )
		 ||(Tabela.getValueAt(iC, objDef.colACAO).toString().contains(objDef.AcaoSaltar) ) 
		 ||(Tabela.getValueAt(iC, objDef.colACAO).toString().contains(objDef.AcaoFimTst) )
		 ||(Tabela.getValueAt(iC, objDef.colACAO).toString().contains(objDef.AcaoFimSim) ) )
		 /*
		 if( (Tabela.getValueAt(iC, objDef.colACAO).toString().contains(objDef.AcaoTestar)) 
		 ||	 (Tabela.getValueAt(iC, objDef.colACAO).toString() == "") )
		 */				
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
		 	
		  	
		 	
		 	
		  	/*
		  	 * Ver.se há registros na Tabela, 
		  	 * Se não há...
		  	 * 		caso não haja filtro aplicado, abre Cx-Dialog para importar registros
		  	 * 		case haja filtro aplicado, start-testes
		  	 * Se há... start-testes
		  	 * 
		  	 * A verificação da aplicação de filtro foi necessaria, 
		  	 * pois sistema considerou tabela sem registros qdo o 
		  	 * filtro selecionou somente 1 linha, com teste em curso 
		  	 */
		 	
		 	
		 	/*
		 	 * Se tabela contem registros..
		 	 * Ou... contem 6(PGOSM661) na celula(0,0), (1,0), (2,0)
		 	 * 
		 	 */
		 	if( (iTReg > 1)
		 	||	(Tabela.getValueAt(0, 0).toString().contains("6"))
		 	||	(Tabela.getValueAt(1, 0).toString().contains("6"))
		 	||	(Tabela.getValueAt(2, 0).toString().contains("6"))
		 	){	
		 		
		 		/*
		 		 *  Se Teste estiver parado, ou seja, se for a primeira ativação exibe aviso,
		 		 *  Se não, ou seja, é um retorno de uma Pausa, não exibe aviso 
		 		 */
		 		if(iOpcao != 2){	// Se Diferente de cancelar....
		 			
				 		if(objDef.PegueTstStatus() == objDef.tstPARAR){
				 		
				 			if(objDef.PegueSimulacao()){ 
				 				objCxD.Aviso("Atenção! Sistema em modo simulação(Seq: " + objDef.PegueTempoTeste() + "min)", true);
				 			}else{
				 				objLog.Metodo("Tempo da sequência: " + objDef.PegueTempoTeste() + "min");
				 			}
				 			
				 		}
				 		
				 		
				 		// Mexer no filtro(A-Z) durante a execução esta travando o filtro
				 		//	Tabela.setRowSorter(null);	// Bloqueia Filtro A-Z na coluna, durante testes	
						 
				 		BtnPausar.setEnabled(true); // Libera Botões
				 		BtnParar.setEnabled(true); // Libera Botões
				 		
				 		BtnPrjNovo.setEnabled(false); // Bloqueia Botões
				 		BtnPrjAbrir.setEnabled(false); // Bloqueia Botões
				 		BtnPrjSalvar.setEnabled(false); // Bloqueia Botões
				 		BtnIniciar.setEnabled(false); // Bloqueia Botões
				 		
				 		//BtnSair.setEnabled(false); // Bloqueia Botões
				 		BtnExportar.setEnabled(false); // Bloqueia Botões
				 		BtnImportar.setEnabled(false); // Bloqueia Botões
				 		BtnRestaurar.setEnabled(false); // Bloqueia Botões
				 		BtnCoordenada.setEnabled(false); // Bloqueia Botões
				 		BtnLapis.setEnabled(false); // Bloqueia Botões
				 		BtnFiltro.setEnabled(false); // Bloqueia Botões
				 		BtnNavegador.setEnabled(true); // Bloqueia Botões
				 		BtnTelnet.setEnabled(false); // Bloqueia Botões
				 		BtnStatusLine.setEnabled(false); // Bloqueia Botões
				 		BtnLog.setEnabled(false); // Bloqueia Botões
				 		
				 		BtnFiltrar.setEnabled(false); 
				 		tfFiltro.setEnabled(false);	// Bloqueia tf-Filtro
						tfStatusTeste.setForeground(Color.white);
						tfStatusTeste.setBackground(Color.red);		
						tfStatusTeste.setText(objDef.StatusTstAtivo);
						
						
						
						objDef.FixeTstStatus(objDef.tstATIVO);			// Informa status do teste
						Iniciar(objDef.tstADSL); 	// Inicia Clock
		 		} // end if(Opcao != 2)...
 		
 	}else{ 	

 		// Verifica se há dados na tabela
 		objLog.Metodo(iNumProcesso + ": Carrega dados");
 		objFrmOpcao.Construir(Tabela);
 		Tabela.setValueAt("Nome: " + objFrmOpcao.tfPrjNome.getText(), 0, 0);
 		
 	}
 	

 }

     
/**********************************************************************************************************/
// Clock-SCAN(Temporizador de varredura)   

 	//-----------------------------------------------------------	
 	private static final int N = 60;
 	private final ClockListener clClock = new ClockListener();
 	private final Timer tTemporizador = new Timer(1000, clClock);

 	public void Iniciar(int iTipo) {
 		
 		objLog.Metodo("mtaView().Iniciar("+ iTipo +")");
 		
 		objDef.fixeNumRegTab(objUtil.ContarReg(Tabela));		// Fixa Num-Reg na tabela
 		objDef.iTipoTESTE = iTipo;
 		AutoExcluirTitulo();
 		
 		objLog.Metodo("mtaView().Iniciar(NumRegTab: " + objDef.pegueNumRegTab() +")");
 		objLog.Metodo("mtaView().Iniciar(Seq: " + PegueSeqEmTeste() +")");
 		objLog.Metodo("mtaView().Iniciar(Lin: " + PegueLinAtual() +")");
 		objLog.Metodo("mtaView().Iniciar(Seg: " + PegueSeg()+")");
 		objLog.Metodo("mtaView().Iniciar(Min: " + PegueMin()+")");
 		objLog.Metodo("mtaView().Iniciar(Hr: " + PegueHora()+")");
 		objLog.Metodo("mtaView().Iniciar(Processo:" + PegueTimeProcesso()+")");
 		objLog.Metodo("mtaView().Iniciar(LinTab: " + objDef.iTotalLinTab+")");
 		
 		//objLog.Metodo("mtaView().Iniciar(" + +")");
 	  
 		
 		
 		tTemporizador.start();
 	   
 	}
 	
 	public void AutoExcluirTitulo(){
 		
 		objLog.Metodo("mtaView().AutoExcluirTitulo()");
 		
 			/* Auto-Excluir linha de título [Porta, ...]
 			 * Se porta não contém "6", (66x, 64x, 68x, 63x, etc) é porque há títulos nos dados
 			 * [Porta - Data - Prot - etc]
 			 */
 	 		if( (!Tabela.getValueAt(0, 0).toString().toLowerCase().contains("6"))
 	 		||(!Tabela.getValueAt(1, 0).toString().toLowerCase().contains("6")) 	 		
 	 		){
 				 DeletarLinha(0);	
 				objLog.Metodo("mtaView().AutoExcluirTitulo()->Deletar(0)");
 			}
 	 		
 	}
 	
 	
 	public void Pausar(){
 		
 		objLog.Metodo("mtaView().Pausar()");
 		
		objDef.FixeTstStatus(objDef.tstPAUSA);
		tTemporizador.stop();		
		tfStatusTeste.setForeground(Color.black);
		tfStatusTeste.setBackground(Color.yellow);		
		tfStatusTeste.setText(objDef.StatusTstPausa);
		BtnIniciar.setEnabled(true); // Bloqueia Botões
		BtnPausar.setEnabled(false); // Bloqueia Botões

 		
 	}
 	
 	public void Parar() {
 		
 		objLog.Metodo("mtaView().Parar()");
 		
 		// Exec.rotina de interrupção dos testes
 		if(objDef.bSimulacao){ tfStatus.setText(tfStatus.getText() + ", Simulação interrompida !"); }
 		else{ tfStatus.setText(tfStatus.getText() + ", Teste interrompido !"); }
 		tTemporizador.stop();
 		
 		BtnParar.setEnabled(false); // Bloqueia Botões
 		BtnPausar.setEnabled(false); // Bloqueia Botões

 		BtnIniciar.setEnabled(true); 
 		
 		BtnPrjNovo.setEnabled(true); // Bloqueia Botões
 		BtnPrjAbrir.setEnabled(true); // Bloqueia Botões
 		BtnPrjSalvar.setEnabled(true); // Bloqueia Botões
 		BtnIniciar.setEnabled(true); // Bloqueia Botões
 		
 		//BtnSair.setEnabled(false); // Bloqueia Botões
 		BtnExportar.setEnabled(true); // Bloqueia Botões
 		BtnImportar.setEnabled(true); // Bloqueia Botões
 		BtnRestaurar.setEnabled(true); // Bloqueia Botões
 		BtnCoordenada.setEnabled(true); // Bloqueia Botões
 		BtnLapis.setEnabled(true); // Bloqueia Botões
 		BtnFiltro.setEnabled(true); // Bloqueia Botões
 		BtnNavegador.setEnabled(true); // Bloqueia Botões
 		BtnTelnet.setEnabled(true); // Bloqueia Botões
 		BtnStatusLine.setEnabled(true); // Bloqueia Botões
 		BtnLog.setEnabled(true); // Bloqueia Botões
 		
 		BtnFiltrar.setEnabled(true); 
 	
 		tfFiltro.setEnabled(true);	// Liberar tf-Filtro
		tfStatusTeste.setForeground(Color.white);
		tfStatusTeste.setBackground(Color.decode("#008B00"));		
		tfStatusTeste.setText(objDef.StatusTstParar);

 		objDef.FixeTstStatus(objDef.tstPARAR);
 		
 		
 		/*
 		 * Mexer no filtro(A-Z) durante a execução esta travando o filtro
 		 */
 		// Libera filtro A-Z na coluna
 		//final TableRowSorter<TableModel> sorter =  new TableRowSorter<TableModel>(ModeloTab);
 		//Tabela.setRowSorter(sorter);
 		
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
 		
 		objLog.Metodo("mtaView().ReAtivar()");
 		
 		/*
 		 * Zerar variáveis, re-inicia variáveis de testes, botões, etc 		 
 		 */
 		
 		/*
 		 * A Rotina abaixo define que: o teste apos parado,
 		 * se re-iniciado vai iniciar do Zero
 		 * (Ignora portas já testadas)
 		 */ 
		LimparTestes(PegueLinAtual());
 		FixeSeqEmTeste(0);	
 		FixeTimeProcesso(0);
 		FixeSeg(0);
 		FixeMin(0);
 		FixeHora(0);
 		FixeLinAtual(0);
 		
 		/*
 		// Exec.rotina de interrupção dos testes
 		if(objDef.bSimulacao){ tfStatus.setText(tfStatus.getText() + ", Simulação interrompida !"); }
 		else{ tfStatus.setText(tfStatus.getText() + ", Teste interrompido !"); }
 	
 		//tTemporizador.stop();
 		
 		BtnParar.setEnabled(false); // Bloqueia Botões
 		BtnPausar.setEnabled(false); // Bloqueia Botões

 		BtnIniciar.setEnabled(true); 
 		
 		BtnPrjNovo.setEnabled(true); // Bloqueia Botões
 		BtnPrjAbrir.setEnabled(true); // Bloqueia Botões
 		BtnPrjSalvar.setEnabled(true); // Bloqueia Botões
 		BtnIniciar.setEnabled(true); // Bloqueia Botões
 		
 		//BtnSair.setEnabled(false); // Bloqueia Botões
 		BtnExportar.setEnabled(true); // Bloqueia Botões
 		BtnImportar.setEnabled(true); // Bloqueia Botões
 		BtnRestaurar.setEnabled(true); // Bloqueia Botões
 		BtnCoordenada.setEnabled(true); // Bloqueia Botões
 		BtnLapis.setEnabled(true); // Bloqueia Botões
 		BtnFiltro.setEnabled(true); // Bloqueia Botões
 		BtnNavegador.setEnabled(true); // Bloqueia Botões
 		BtnTelnet.setEnabled(true); // Bloqueia Botões
 		BtnStatusLine.setEnabled(true); // Bloqueia Botões
 		BtnLog.setEnabled(true); // Bloqueia Botões
 		
 		BtnFiltrar.setEnabled(true); 
 	
 		tfFiltro.setEnabled(true);	// Liberar tf-Filtro
		tfStatusTeste.setForeground(Color.white);
		tfStatusTeste.setBackground(Color.decode("#008B00"));		
		tfStatusTeste.setText(objDef.StatusTstParar);

 		objDef.FixeTstStatus(objDef.tstPARAR);
 		/*
 		 * Mexer no filtro(A-Z) durante a execução esta travando o filtro
 		 */
 		// Libera filtro A-Z na coluna
 		//final TableRowSorter<TableModel> sorter =  new TableRowSorter<TableModel>(ModeloTab);
 		//Tabela.setRowSorter(sorter);
 		
 		
 		
 	}

 	 
/**********************************************************************************************************/
public void DispararTesteV2(int iVersao, int iModem, int iTipo, int iLinMD){
/* Versao do modem, Numero do Modem, Tipo de Teste, Linha da Tabela */
 		
 		objLog.Metodo("mtaView().DispararTesteV2(V: "+iVersao+", M:"+ iModem+", T: "+iTipo+", L: "+iLinMD+")");
 		
 		FixeLinAtual(iLinMD);	// Atualiza crtl da linha atual em teste
 		
 		
// Verifica final dos registros, caso sim, salta processo
if(!VerFinalReg(iLinMD)){
//-----------------------------------------------------------------------------------------------------	
		
		/*
		 * Caso haja + de 1 linha na Tabela(>1), Seleciona Celula MD em teste
		 * Qdo filtrado e só há 1 linha, não exec.seleção pois trava.
		 * 
		 */
		if(Tabela.getRowCount() > 1){
			Tabela.setRowSelectionInterval(1, iLinMD);	// Seleciona linha 30 (0..29)
			tfCoord.setText( objUtil.LinToSeqMd(Tabela.getSelectedRow()) );				// Atualiza coordenadas
			
			int iLc = iLinMD + 1;
			tfCelula.setText("Porta [" + iLc +"]");
		}
 		
 		objLog.Metodo("mtaView().DispararTesteV2() - 002b");
 		
 		/*
 		 *  Verifica coluna "Ação" se esta setado como: Testar
 		 *  caso Não, pula para o próximo
 		 */
 		String sTeste = Tabela.getValueAt(iLinMD, objDef.colACAO).toString();
 		
 		objLog.Metodo("mtaView().DispararTesteV2() - 002c");
 		/*
 		 * Verifica se chegou ao final dos registros, caso Sim, Saltar
 		 */
 		 
 		
 		
 		
 		/*
 		 *  Verifica se Linha corrente esta setado para testar = Sim
 		 *  e, se a linha Atual, em testes, não excedeu ao numero de linhas na Tabela
 		 *  ou seja, no caso de aplicação de filtros, o núm. de linhas pode ser menor que 
 		 *  o núm.de modens(3 linhas e 4 modens)
 		 */
 	 	objLog.Metodo("mtaView().DispararTesteV2( iLinMD:" + iLinMD +", iTotalLinTab: " + objDef.iTotalLinTab);
 		if(iLinMD >= objDef.iTotalLinTab){ objCxD.Aviso("Erro[E002d]! Modem excedeu Número de linhas["+ iLinMD +"] !",true); }
 		
 		
 		// Se Celula igual: Testar, Testando... ou simulando... Prossegue
 		if( (sTeste.contains(objDef.AcaoTestar)) 		
 		||  (sTeste.contains(objDef.AcaoEmTst))	
 		||  (sTeste.contains(objDef.AcaoEmSim)) ){
 			
 			/*
 			static String AcaoTestar = "Testar";
 			static String AcaoSaltar = "Saltar";
 			static String AcaoEmTst = "Testando...";
 			static String AcaoEmSim = "Simulando...";
 			static String AcaoFimSim = "Simulado";
 			static String AcaoFimTst = "Testado";
 			static String AcaoFimTstOK = "Teste OK"; 
 			static String AcaoFimTstNOK = "Teste Falhou";

 		/*
 		if( (sTeste == objDef.AcaoTestar)
 		||  (sTeste == objDef.AcaoEmTst)	
 		||  (sTeste == objDef.AcaoEmSim) ){
 		*/	
 			// Alterar celula Ação para Testando..., ou Simulando...
 			if(objDef.PegueSimulacao()){
 				Tabela.setValueAt(objDef.AcaoEmSim, iLinMD, objDef.colACAO);
 			}else{
 				Tabela.setValueAt(objDef.AcaoEmTst, iLinMD, objDef.colACAO);
 			}
	    
 			objLog.Metodo("mtaView().DispararTesteV2() - 003");
 	     	objLog.Metodo("mtaView().DispararTesteV2(V: "+iVersao+", M:"+ iModem+", T: "+iTipo+", L: "+iLinMD+"): Testar = Sim ");
 	    
			// Sincronismo
 	        if(iTipo == objDef.STATUS){
 	        	objLog.Metodo("MD["+iModem+"], IP: "+objDef.sIP[iModem]+", Cmd: Status");
 	        	if(objDef.PegueSimulacao()){    
 	        		if(iVersao == objDef.Dsl2500e){ taTelnet.setText( objDsl2500e.Simula(objDef.STATUS, taTelnet) ); }
 	        		if(iVersao == objDef.HubDLink){ taTelnet.setText( objDLinkOpticom.Simula(objDef.STATUS, taTelnet) ); }
 	        		objUtil.sCapturaCom[iModem] = taTelnet.getText(); 
 	        	}else{
 	        		if(iVersao == objDef.HubDLink){ objUtil.sCapturaCom[iModem] = objDLinkOpticom.connect(objDef.STATUS, objDef.sIP[iModem],objDef.sLogin,objDef.sSenha,objDef.iPorta, objDef.sURLteste); }
 	        		if(iVersao == objDef.Dsl2500e){ objUtil.sCapturaCom[iModem] = objDsl2500e.connect(objDef.STATUS, objDef.sIP[iModem],objDef.sLogin,objDef.sSenha,objDef.iPorta, objDef.sURLteste); }
 	    	    }    		    		    		
 	    	    objUtil.sCapturaComAnt[iModem] = taTelnet.getText();
 	    	    taTelnet.setText(objUtil.sCapturaComAnt[iModem] + objUtil.sCapturaCom[iModem]);
 	    	    
 	    	    // LerTArea(Tipo-de-md, Tipo-de-teste, Lin-da-Tabela)
 	    	   	LerTArea(iVersao, iModem, objDef.STATUS, iLinMD);
					
 	        }
 	        
 	        
 	     // Se estiver sincronizado... verifica autenticação
 	        objLog.Metodo("Entrando -> SincUP["+iModem+"]");
 	        if(objUtil.bSinc[iModem]){	
 	        	
 	        	 	        	
 	        	if(iTipo == objDef.AUTH){
 	        		objLog.Metodo("MD["+iModem+"], IP: "+objDef.sIP[iModem]+", Cmd: AUTH");
 	        		if(objDef.PegueSimulacao()){
 	        			
 	        			if(iVersao == objDef.HubDLink){ taTelnet.setText( objDLinkOpticom.Simula(objDef.AUTH, taTelnet) );}
 	        			if(iVersao == objDef.Dsl2500e){ taTelnet.setText( objDsl2500e.Simula(objDef.AUTH, taTelnet) );}
 	        			objUtil.sCapturaCom[iModem] = taTelnet.getText(); 
     	           	}else{
     	           		if(iVersao == objDef.Dsl2500e){ objUtil.sCapturaCom[iModem] = objDsl2500e.connect(objDef.AUTH, objDef.sIP[iModem],objDef.sLogin,objDef.sSenha,objDef.iPorta, objDef.sURLteste); }
     	        		if(iVersao == objDef.HubDLink){ objUtil.sCapturaCom[iModem] = objDLinkOpticom.connect(objDef.AUTH, objDef.sIP[iModem],objDef.sLogin,objDef.sSenha,objDef.iPorta, objDef.sURLteste); }
     	        	
					}
 	        		objUtil.sCapturaComAnt[iModem] = taTelnet.getText();
 	        		taTelnet.setText(objUtil.sCapturaComAnt[iModem] + objUtil.sCapturaCom[iModem]);
 	        		
	        			// LerTArea(Tipo-de-md, Tipo-de-teste, Lin-da-Tabela)
 	        		LerTArea(iVersao, iModem, objDef.AUTH, iLinMD);  
						
 	        	}
 	        
 	        	// Se estiver autenticado... executa ping
 	        	if(objUtil.bAuth[iModem]){	
 	        	
 	        		if(iTipo == objDef.PING){
 	        			objLog.Metodo("MD["+iModem+"], IP: "+objDef.sIP[iModem]+", Cmd: Ping");
 	    	        	
 	        			if(objDef.PegueSimulacao()){
 	        				if(iVersao == objDef.HubDLink){ taTelnet.setText( objDLinkOpticom.Simula(objDef.PING, taTelnet) ); }
 	        				if(iVersao == objDef.Dsl2500e){ taTelnet.setText( objDsl2500e.Simula(objDef.PING, taTelnet) ); }
 	        				objUtil.sCapturaCom[iModem] = taTelnet.getText(); 
 	    	           	}else{
 	    	           		if(iVersao == objDef.Dsl2500e){ objUtil.sCapturaCom[iModem] = objDsl2500e.connect(objDef.PING, objDef.sIP[iModem],objDef.sLogin,objDef.sSenha,objDef.iPorta, objDef.sURLteste); }
							if(iVersao == objDef.HubDLink){ objUtil.sCapturaCom[iModem] = objDLinkOpticom.connect(objDef.PING, objDef.sIP[iModem],objDef.sLogin,objDef.sSenha,objDef.iPorta, objDef.sURLteste); }										
         	        	}
 	        			    		    		    		
 	        			objUtil.sCapturaComAnt[iModem] = taTelnet.getText();
 	        			taTelnet.setText(objUtil.sCapturaComAnt[iModem] + objUtil.sCapturaCom[iModem]);

 	        			// LerTArea(Tipo-de-md, Tipo-de-teste, Lin-da-Tabela)
 	        			LerTArea(iVersao, iModem, objDef.PING, iLinMD);  
							
 	        		}
 	        		
 	        	}else{ tfStatus.setText(tfStatus.getText() + ", Autenticando..."); }
 	        }else{ tfStatus.setText(tfStatus.getText() + ", Activading..."); }
 	        
 		}else{
 			
 			objLog.Metodo("Teste da linha "+iLinMD + " foi saltado.");
 			Tabela.setValueAt("Falhou!", iLinMD, objDef.colACAO);
 			
 			// Se houve saltos, Fixa S, A e N como UP para entrar na verificação de Teste finalizado
 			objUtil.bSinc[iModem] = true;
 			objUtil.bAuth[iModem] = true;
 			objUtil.bPing[iModem] = true;
 			FixeTimeProcesso(PegueTimeProcesso() + 5);	// Salta Tempo do processo
 			
 		}	// Se Teste = Sim
 	
 //----------------------------------------------------------------------------------------------------- 		
 }else{ // if(!VerFinalReg(iLinMD)){
	 
	Parar();   // 12jun2016
	objCxD.Aviso("Não há novas portas a serem testadas, teste finalizado[s103]!", true );
	 
 }
 		
} // fim DispararTesteV2() 
 	
 	
 	public void VerFimTeste(){
 		/*
 		 *  Verifica resultado do fim dos testes
 		 *  Verifica limite de tempo por sequencia(padrão 3min - 3 tentativas por modem)
 		 */
 		
 		objLog.Metodo("mtaView().VerFimTeste()");
 		
 		//-------------------------------------------------------------------------------------------------------------------------------------------
 		// Verifica finalização por temporização da sequencia 		
 	    if(PegueMin() == objDef.PegueTempoTeste()){
	        	
 	    		AnalisarTeste(); // Faz uma análise dos resultados
 	    		objLog.Metodo("mtaView().VerFimTeste()-001");
 	    		
 	    		if(objDef.bSimulacao){ tfStatus.setText(String.valueOf("Seqüência " + PegueSeqEmTeste() +" de simulação finalizada! " + sHora + ":" + sMin + ":" + sSeg)); }
 	    		else{ tfStatus.setText(String.valueOf("Seqüência " + PegueSeqEmTeste() +" de testes finalizada! " + sHora + ":" + sMin + ":" + sSeg)); }
 	    		
 	    		tTemporizador.stop();	// Pausa Clock, aguarda decisão do usuário
	        	AutoBackup();			// faz um auto-backup dos testes
	        	/*
	        	// Verifica se chegou ao fim dos registros
	        	if(VerFinalReg(objDef.iLinAtualx)){	        	
	        		objLog.Metodo("mtaView().VerFimTeste()-002");
	        		objCxD.Aviso("Teste finalizado!", true);
	        		
	        	}else{     // Se Não...pergunta se deseja continuar....
	        	*/
	        		objLog.Metodo("mtaView().VerFimTeste()-002");	        		
	        		
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
	        				//objUtil.LimparTabela(Tabela);
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
	        	objLog.Metodo("mtaView().VerFimTeste()-004");
	        	AnalisarTeste();   // faz uma análise dos resultados do teste
	        	
	        	// Edita barra de Status
	        	if(objDef.bSimulacao){ tfStatus.setText(String.valueOf("Seqüência " + PegueSeqEmTeste() +" de simulação finalizada! " + sHora + ":" + sMin + ":" + sSeg)); }
 	    		else{ tfStatus.setText(String.valueOf("Seqüência " + PegueSeqEmTeste() +" de testes finalizada! " + sHora + ":" + sMin + ":" + sSeg)); }
 	    	
	        	
	        	tTemporizador.stop();	// pausa-clock, aguarda decisão de usuário
	        	AutoBackup();			// faz um auto-backup dos testes
	        	
	        	/*
	        	// Ve se chegou ao final dos registros
	        	if(VerFinalReg(objDef.iLinAtualx)){	        	
	        		objLog.Metodo("mtaView().VerFimTeste()-005");
	        		objCxD.Aviso("Teste finalizado!", true);
	        		
	        	}else{ // caso não...pergunta se deseja continuar...
	        	*/	
	        		objLog.Metodo("mtaView().VerFimTeste()-006");
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
		    				/*
		    				 * Volta a sequencia
		    				 */
		    				// Anterior: objUtil.iSeqEmTeste--; 
		    				FixeSeqEmTeste(PegueSeqEmTeste() - 1);
		    				if(PegueSeqEmTeste() < 0){ FixeSeqEmTeste(0); }   // Bloquiea valores menor que Zero
		    			}
		        		
		        	}
	           		
	        //	} // if(VerFinalReg(objDef.iLinAtualx)){
	        } //if(iVerifica == 4){
			
	       
	        
	        //-------------------------------------------------------------------------------------------------------------------------------------------
	        //tfStatus.setText(tfStatus.getText() + "[LinMd3: " + objUtil.iLinMd[objDef.iModem3] + "]");
			//Tabela.setRowSelectionInterval(1, iLinMD);	// Seleciona linha 30 (0..29)
	        FixeTimeProcesso(PegueTimeProcesso() + 1);
			FixeSeg(PegueSeg() + 1);
	        
 	}
 	 
 	public boolean VerFinalReg(int iLinAtual){		
 		
 	
 	
 		objLog.Metodo("mtaView().VerFinalReg("+iLinAtual+")");
 		
 		//-------------------------------------------------------------------------------------------------------------------------------------------
 		/*
 		 *  Verifica final dos registros/linhas NA TABELA
 		 *  APÓS APLICAÇÃO DE FILTRO, onde as linhas não filtradas estão ocultas
 		 *   e No final dos registros, onde as linhas estão visíveis porém não possuem dados
 		 *   
 		 *   Este método foi criado para resolver problemas de travamentos 
 		 *   qdo na aplicação de filtros, onde o sistema fazia referencia a linhas ocultas(inexistentes) e travava
 		 */
 		
        int iNumLinTab = Tabela.getRowCount();  
        int iNumRegTab = objUtil.ContarReg(Tabela);
        
        		
        objLog.Metodo("mtaView().VerFinalReg([iLinAtual == iNumLinTab]: "+iLinAtual +"=="+ iNumLinTab+")");
    	objLog.Metodo("mtaView().VerFinalReg([iLinAtual== iNumRegTab]: "+iLinAtual +"=="+ iNumRegTab+")");
        
        // Se Linha atual do teste >= Total de linhas na tabela, finaliza o teste
        if( (iLinAtual == iNumLinTab)
        ||	(iLinAtual == iNumRegTab) ){
        //||  (!Tabela.getValueAt(iLinAtual, objDef.colACAO).toString().contains("Testar"))){
        
        	
        	//objLog.Metodo("mtaView().VerFinalReg(): true");
        	//objCxD.Aviso("Final de Regs ! Lin: " + iLinAtual, true);
        	objLog.Metodo("mtaView().VerFinalReg( iNumLinTab: "+iNumLinTab+", iNumRegTab: "+ iNumRegTab+" ) = true");
        	return true;	// Final dos registros

        }else{
        //	objLog.Metodo("mtaView().VerFinalReg(): false");
        	objLog.Metodo("mtaView().VerFinalReg( iNumLinTab: "+iNumLinTab+", iNumRegTab: "+ iNumRegTab+" ) = false");
        	return false;	// Não-final dos registros
        }

        
 	}
 	
 	 	

 	public void AnalisarTeste(){
 		
 		// faz uma análise dos resultados dos testes, informa na celula: Ação
 		objLog.Metodo("mtaView().AnalisarTeste()");
 		
 		
 		
 		
        for(int iV=0; iV<4; iV++){
        	
        	int iLinMdX = objUtil.SeqToLin(PegueSeqEmTeste(), iV);        	
        	//String sResAcao = Tabela.getValueAt(iLinMdX, objDef.colOBS).toString();
        	
        	objLog.Metodo("mtaView().AnalisarTeste().iLinMdX: " + iLinMdX + ", sResAcao: []");
        	
        	
        	/*
        	 *  Se Não for final da linha, faz analise, 
        	 *  Caso contrário: Salta, para evitar travamentos 
        	 *  ao consultar Linha inexistente na tabela(Oculta pelo filtro)
        	 */
        	if(!VerFinalReg(iLinMdX)){
        		
        	
        		// Formata informações de teste para campo obs
        		String sSin = "Sinc: " + Tabela.getValueAt(iLinMdX, objDef.colSINC).toString();
        		String sAut = ", Aut: " + Tabela.getValueAt(iLinMdX, objDef.colAUTH).toString();
        		String sNav = ", Nav: " + Tabela.getValueAt(iLinMdX, objDef.colNAV).toString();
        		if( Tabela.getValueAt(iLinMdX, objDef.colAUTH).toString() == "" ){ sAut = ""; }
        		if( Tabela.getValueAt(iLinMdX, objDef.colNAV).toString() == "" ){ sNav = ""; }
        	
        		String sResOK = sSin + sAut + sNav + ", " + objDef.AcaoFimTstOK;
        		String sResNOK = sSin + sAut + sNav + ", " + objDef.AcaoFimTstNOK;
        	
        		if( (Tabela.getValueAt(iLinMdX, objDef.colACAO).toString().contains("Testado"))
        		|| 	(Tabela.getValueAt(iLinMdX, objDef.colACAO).toString().contains("Simulado")) ) {
        			Tabela.setValueAt(sResOK, iLinMdX, objDef.colOBS);        		
        		}
        		if( (Tabela.getValueAt(iLinMdX, objDef.colACAO).toString().contains("Testando"))
        		|| 	(Tabela.getValueAt(iLinMdX, objDef.colACAO).toString().contains("Simulando")) ) {                	
        			Tabela.setValueAt(sResNOK, iLinMdX, objDef.colOBS);        		
        		}
        	
        	}
        	
        }
 
       
 	}
 	
        
    public void DeletarLinha(int iLinDel){
 		
 		objLog.Metodo("mtaView().DeletarLinha("+iLinDel+")");
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
 		for(int iCx=0; iCx < objDef.iTotColuna; iCx++){
 			//objLog.Metodo("mtaView().DeletarLinha()->Mem: " + iCx);
 			objUtil.sDesfazerExcluir[iCx] = Tabela.getValueAt(iLinDel, iCx).toString(); 
 		}    
 		
 		
 		// Deleta(Desloca linhas para cima - preenche linha excluida)
 		int iTotLinPlan =  objUtil.ContarReg(Tabela);	//Tabela.getRowCount();
 		objLog.Metodo("mtaView().DeletarLinha()->iTotLinPlan: " + iTotLinPlan);
 		
 		for(int iL=iLinDel; iL <= iTotLinPlan; iL++){
 			int iLx = iL+1;
 			//objLog.Metodo("mtaView().DeletarLinha()->Del-iL: " + iL);
 			for(int iC=0; iC < objDef.iTotColuna; iC++){ 			
 				//objLog.Metodo("mtaView().DeletarLinha()->Del-iC: " + iC);
 				Tabela.setValueAt(Tabela.getValueAt(iLx, iC), iL, iC);    				
 			}
 		}
 		
 		
 		
 		
 	}
 	
 	public void DesfazerExcluir(){
 		objLog.Metodo("mtaView().DesfazerExcluir()");
 		
 		
 		InserirLin(objUtil.iLinExcluida);
 		
 		for(int iC=0; iC <= 27;iC++){    			 
 			Tabela.setValueAt(objUtil.sDesfazerExcluir[iC], objUtil.iLinExcluida, iC);
 		}
 		objUtil.bDesfazer = false;			// Informa que NÃO há mais registros a recuperar
 		
 	}
 	
 	public void InserirLin(int iLinSelecionada){
 		
 		/*
 		 *  27Ago14 
 		 *  Re-aloca registros de X para Y, abrindo uma linha vazia no meio 
 		 */
 		objLog.Metodo("InserirLin("+iLinSelecionada+")");
 		int iTotal = objUtil.ContarReg(Tabela) +1;	// Conta numero de registros na tabela
 		
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
 					Tabela.setValueAt(Tabela.getValueAt(iInverte, iC), iLx, iC);
 				
 					// Apaga Linha X(1)
 					Tabela.setValueAt("", iInverte, iC);
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
	// Salva dados da Tabela em arquivo *.ini
		
		objLog.Metodo("mtaView().SalvarConfig("+objDef.PeguePlanCorrente()+")");
		
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
				ArqIni.set(sChavePrj, "PrjNome", String.valueOf(objFrmOpcao.tfPrjNome.getText()) );
				//ArqIni.set(sChavePrj, "Editar", String.valueOf() );
				//ArqIni.set(sChavePrj, "Gerar", String.valueOf() );
				//ArqIni.set(sChavePrj, "Importar", String.valueOf() );
				//ArqIni.set(sChavePrj, "PrjPath", String.valueOf(objFrmOpcao.tfImportarLista.getText()) );
				//ArqIni.set(sChavePrj, "PrjPath", String.valueOf(objDef.PeguePlanCorrente()));
				
				ArqIni.save(fArquivo);	    	
				// objCxD.Aviso("Arquivo salvo em: " + sDirArq, objDef.bMsgSalvar);
				// objLog.Metodo("mtaView().SalvarConfig(), T: " + objDef.iTempoTeste+", Txt: " + objDef.iTamTexto +", Z: " + objDef.bZoom +", Sml: " + objDef.bSimulacao);
				
	     } catch (IOException ex) {  
	    	 objCxD.Aviso("Erro ao criar arquivo[" + ex + " - E017m],", objDef.bMsgErro);  
	     } finally{
	    	
	     }
	}
	
	public void SalvarConfigCrip() throws IOException{
		// Salva dados da Tabela em arquivo *.ini
			
			objLog.Metodo("mtaView().SalvarConfigCript()");
			
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
					// objLog.Metodo("mtaView().SalvarConfig(), T: " + objDef.iTempoTeste+", Txt: " + objDef.iTamTexto +", Z: " + objDef.bZoom +", Sml: " + objDef.bSimulacao);
					
		     } catch (IOException ex) {  
		    	 objCxD.Aviso("Erro ao criar arquivo[" + ex + " - E018m],", objDef.bMsgErro);  
		     } finally{
		    	
		     }
		}
	
	  public void LerConfig(boolean bCripto) throws IOException{
			
			objLog.Metodo("mtaView().LerConfig("+objDef.bCriptoConfig+")");

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
					objDef.FixePlanCorrente( String.valueOf(ArqIni.get(sChavePrj,"PrjPath")) );
				
				
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

		  // Pega data do sistema
		    Date dData = new Date();  
		    SimpleDateFormat DiaMes = new SimpleDateFormat("ddMMMhh");  // Formato: 05Jun
			String sAgora = DiaMes.format(dData);
			
			int iTReg = objUtil.ContarReg(Tabela);	// Conta numero de registros na tabela
			if( iTReg > 0){							// Verifica NumReg
				try{
					String sDirArq = objDef.DirBak + objFrmOpcao.tfPrjNome.getText() + "_" + sAgora + "h.mta";
					objArquivo.BackupMtaIni(Tabela, sDirArq, iTReg);	// Salva dados
					
				}catch(IOException e){
					objLog.Metodo("mtaView().AutoBackup(Erro ao gravar Arquivo)");
				}finally{
					//new CxDialogo().Aviso("Arquivo *.mta Salvo !");
				}
			}else{
				objLog.Metodo("mtaView().AutoBackup(Não há registros a serem salvos)");
			}
			
			
		}
	 
	/****************************************************************************************************/
		
	  public void VerSincronismo(){
		  
		  // Consulta sincronismo dos modens - atualiza Led´s(Verde/Verm) no gráfico
		  
		    objLog.Metodo("VerSincronismo()");
			String sCapturaCom = "";
			int iVersao = 0;
			boolean bLedSinc[] = {false,false,false,false};
			
		  	// Consulta sincronismo dos 4 modens
		  	for(int iModemX = 0; iModemX < 4; iModemX++){
		  		
		  		if(iModemX == 0 ) {  iVersao = objDef.HubDLink; }
		  		else{ iVersao = objDef.Dsl2500e; }
		  		
		  		/**************************************************************************************/
		  				// Sincronismo
			      
			         	if(objDef.PegueSimulacao()){    
			        		if(iVersao == objDef.Dsl2500e){ taTelnet.setText( objDsl2500e.Simula(objDef.STATUS, taTelnet) ); }
			        		if(iVersao == objDef.HubDLink){ taTelnet.setText( objDLinkOpticom.Simula(objDef.STATUS, taTelnet) ); }	        		 
			        	}else{
			        		if(iVersao == objDef.HubDLink){ objUtil.sCapturaCom[iModemX] = objDLinkOpticom.connect(objDef.STATUS, objDef.sIP[iModemX],objDef.sLogin,objDef.sSenha,objDef.iPorta, objDef.sURLteste); }
			        		if(iVersao == objDef.Dsl2500e){ objUtil.sCapturaCom[iModemX] = objDsl2500e.connect(objDef.STATUS, objDef.sIP[iModemX],objDef.sLogin,objDef.sSenha,objDef.iPorta, objDef.sURLteste); }
			    	    }    		    		    		
			    	    sCapturaCom = taTelnet.getText();
			    			
			        
		  		
		  		/**************************************************************************************/
			    /*
			     // A rotina abaixo Também funciona, porém é mais completa e atualiza Tabela(indesejado)
		  		if(iModemX == 0){
		  			DispararTesteV2(	objDef.HubDLink,
		  								iModemX,
		  								objDef.STATUS,
		  								objUtil.SeqToLin(PegueSeqEmTeste(), iModemX) 
		  							);
		  		}
		  		*/
		  		sCapturaCom = taTelnet.getText();	
		  		if(sCapturaCom.toLowerCase().contains("showtime")){  bLedSinc[iModemX] = true;	}
		  		else{ bLedSinc[iModemX] = false; }
		  		
			} // end for..
		  	
		  	// Atualiza Led´s de sincronismo - Info do telnet status
		  	gGrafico.setLeds(bLedSinc[0], bLedSinc[1], bLedSinc[2], bLedSinc[3]);  	
		   	gGrafico.repinte(objDef.Clock, objDef.bZoom);

		   	
	  }
	  
	  private void ExibirOcultar(int iQuem){	
		 // Exibe/oculta Barra de ferramentas - realoca Tabela
		  
			if(iQuem == objDef.LAPIS){
				// 	Botão Lapis: Exibir/Ocultar barra fer. lapis(BfAddLinha) 
				if(BfAddLinha.isVisible()){
					BfTabela.setBounds(1, objDef.bfTabLinIni, objDef.iTelaLarg, objDef.AltTabela);
					BfAddLinha.setVisible(false);
					repaint();
				}else{

					BfTabela.setBounds(1, objDef.bfTabLinIni + 25, objDef.iTelaLarg, objDef.AltTabela - 25);
				
					BfAddLinha.setVisible(true);
					BfAddLinha.setAlignmentX(1);
					BfAddLinha.setAlignmentY(100);
					repaint();
				}
			}
			
			if(iQuem == objDef.FILTRO){
				// Botão Filtro: Mostra/Esconde barra fer. Coord/Filtro(BfFiltro)
				if(BfFiltro.isVisible()){
					if(BfAddLinha.isVisible()){
						//BfTabela.setBounds(1, objDef.bfTabLinIni - 25, objDef.iTelaLarg, objDef.AltTabela + 25);
					}else{
						BfTabela.setBounds(1, objDef.bfTabLinIni - 25, objDef.iTelaLarg, objDef.AltTabela + 25);
					}
					BfFiltro.setVisible(false);
					repaint();
				}else{
					if(BfAddLinha.isVisible()){
						//BfTabela.setBounds(1, objDef.bfTabLinIni, objDef.iTelaLarg, objDef.AltTabela);
					}else{
						BfTabela.setBounds(1, objDef.bfTabLinIni, objDef.iTelaLarg, objDef.AltTabela);
					}
					BfFiltro.setVisible(true);
					BfFiltro.setAlignmentX(1);
					BfFiltro.setAlignmentY(100);
					repaint();
				}
			}			
		} // End ExibirOcultar()
    
	  
	  
	  




private class ClockListener implements ActionListener {
		
	
 	
	    public void actionPerformed(ActionEvent e) {
	    	
	    	objLog.Metodo("mtaView().ClockListener().start()");
	    	
	    	/*
	    	 * fazer verificação do numero de linha na tabela
	    	 * com numero a testar - para evitar travamentos
	    	 * Se Num da linha >= Num da Planilha -> Finaliza
	    	 */	    	
	        // if(PegueLinAtual() >=  objDef.iTotalLinTab){ 
	    	// ou...
	    	/*
	    	 * Aqui foi usado metodo VerFinalReg(x,y)-2, para contornar bug:
	    	 * VerFinalReg(x) não tava chamando ContarReg(), e processo parava
	    	 */
	    	
	    	
	        if(VerFinalReg(PegueLinAtual())){
	        	objLog.Metodo("mtaView().ClockListener().stop(Fim-Da-Plan)");
	        	objLog.Metodo("mtaView().ClockListener().PegueLinAtual() = "+PegueLinAtual());
	        	//tfStatus.setText("mtaView - Testes finalizados.");
	        	objCxD.Aviso("Não há novas portas a serem testadas, teste finalizado[101]!", true );
	        	Parar();
	        }else{
	    	
	        	NumberFormat formatter = new DecimalFormat("00"); 	         
	        	if (PegueSeg() == N) {
	        		FixeTimeProcesso(0);
	        		FixeSeg(0);
	        		FixeMin(PegueMin() + 1);
	        	}

	        	if (PegueMin() == N) {
	        		FixeMin(0);
	        		FixeHora(PegueHora() + 1);
	        	}
	        	sHora = formatter.format(PegueHora());
	        	sMin = formatter.format(PegueMin());
	        	sSeg = formatter.format(PegueSeg());
	        
	        	// Monitora parametros - programação...
	        	//String sPar = PegueHora() + ":" + PegueMin() + ":" + PegueSeg() + ", TimePc:" + PegueTimeProcesso() + ", Seq: " + PegueSeqEmTeste() + ", Lin: " + PegueLinAtual();
	        	//Tabela.setValueAt(sPar, PegueLinAtual(), objDef.colDESC);
	        	//tfFiltro.setText(objDef.PeguePlanCorrente());
	       
	        	/**************************************************************************************/
	        	// Exec.Tarefa dentro do clock  
	        	
	        	// Se teste é de Modens...
	        	if(objDef.iTipoTESTE ==  objDef.tstMODEM){
	        		
	        		if(PegueTimeProcesso() == 0){
	        			tfStatus.setText(tfStatus.getText() + ", consultado modens, aguarde...");
	        			taTelnet.setText("Consultando modem, aguarde..."); 
	        		}
	 	        	if(PegueTimeProcesso() == 2){ objPing.Pingar(taTelnet, "192.168.1.1"); }
	 	        	FixeTimeProcesso(PegueTimeProcesso() + 1);
	 	        	FixeSeg(PegueSeg() + 1);
	 	        	
	 	        	if(PegueTimeProcesso() == 5){ 
	 	        		taTelnet.setText(taTelnet.getText() + "\n" + "Finalizado!");
	 	        		tfStatus.setText(tfStatus.getText() + ", finalizado.");
	 	        		Parar();
	 	        		FixeTimeProcesso(0);
	 	 	        	FixeSeg(0);
	 	        	}
	 	        	
	        	}
	        	
	        	// Se teste é de portas ADSL
	        	if(objDef.iTipoTESTE == objDef.tstADSL){
	        		
	        	     	String sTempo =  sHora + ":" + sMin + ":" + sSeg;
	        	     	//String sTempo = objUtil.TempoRegressivo(objDef.TimeSeq, iMinx, iSegx);
	        	     	// Anterior: tfStatus.setText(String.valueOf("Seqüência " + PegueSeqEmTeste() +" em teste, aguarde..."));
	        	     	if(objDef.bSimulacao) { tfStatus.setText(String.valueOf("Seqüência " + PegueSeqEmTeste() +" em simulação, aguarde...")); }
	        	     	else{ tfStatus.setText(String.valueOf("Seqüência " + PegueSeqEmTeste() +" em teste, aguarde...")); }
	     	        	
	        	     	// Atualiza Led´s de sincronismo - Info do telnet status
	     	        	gGrafico.setLeds(objUtil.bSinc[0], objUtil.bSinc[1], objUtil.bSinc[2], objUtil.bSinc[3]);
	     	       
	        	     	
	     	        	objLog.Metodo("Atualiza clock(gf): " + sTempo);
	     	        	gGrafico.setClock(sTempo);
	     	        	
	     	        	
	     	         	gGrafico.repinte(objDef.Clock, objDef.bZoom);
	     	        	
	     	        	//objLog.Metodo("mtaView().SalvarConfig(), T: " + objDef.iTempoTeste+", Txt: " + objDef.iTamTexto +", Z: " + objDef.bZoom +", Sml: " + objDef.bSimulacao);
	     	   
	     	        	
	     	        	//----------------------------------MODEM 1--------------------------------------------------
	     	        	// Apagar		
	     	        	if( (PegueTimeProcesso() == 0)||(PegueTimeProcesso() == 4)||(PegueTimeProcesso() == 9) ){ taTelnet.setText(""); }
    	        
    	        
	     	        	if(PegueTimeProcesso() == 1){
	     	        			DispararTesteV2(	objDef.HubDLink,
    	        							objDef.iModem1,
    	        							objDef.STATUS,
    	        							objUtil.SeqToLin(PegueSeqEmTeste(), objDef.iModem1) 
	     	        					);
	     	        				//VerFimTeste(objUtil.SeqToLin(PegueSeqEmTeste(), objDef.iModem1));  
	     	        	}
	     	        	if(PegueTimeProcesso() == 5){
	     	        			DispararTesteV2(	objDef.HubDLink,
    	        						objDef.iModem1,
    	        						objDef.AUTH,
    	        						objUtil.SeqToLin(PegueSeqEmTeste(), objDef.iModem1) 
    	        					);
	     	        			//VerFimTeste(objUtil.SeqToLin(PegueSeqEmTeste(), objDef.iModem1));
	     	        	}
	     	        	if(PegueTimeProcesso() == 10){
	     	        			DispararTesteV2(	objDef.HubDLink,
    	        						objDef.iModem1,
    	        						objDef.PING,
    	        						objUtil.SeqToLin(PegueSeqEmTeste(), objDef.iModem1) 
    	        					);
	     	        			//VerFimTeste(objUtil.SeqToLin(PegueSeqEmTeste(), objDef.iModem1));
	     	        	}
	     	        	//----------------------------------MODEM 2--------------------------------------------------
	     	        	// Apagar		
	     	        	if( (PegueTimeProcesso() == 15)||(PegueTimeProcesso() == 19)||(PegueTimeProcesso() == 24) ){ taTelnet.setText(""); }
	     	        	if(PegueTimeProcesso() == 16){
	     	        			DispararTesteV2(	objDef.Dsl2500e,
    	        						objDef.iModem2,
    	        						objDef.STATUS,
    	        						objUtil.SeqToLin(PegueSeqEmTeste(), objDef.iModem2) 
    	        					);
	     	        	}
	     	        	if(PegueTimeProcesso() == 20){
	     	        			DispararTesteV2(	objDef.Dsl2500e,
    	        						objDef.iModem2,
    	        						objDef.AUTH,
    	        						objUtil.SeqToLin(PegueSeqEmTeste(), objDef.iModem2) 
    	        					);
	     	        	}
	     	        	if(PegueTimeProcesso() == 25){
	     	        			DispararTesteV2(	objDef.Dsl2500e,
    	        						objDef.iModem2,
    	        						objDef.PING,
    	        						objUtil.SeqToLin(PegueSeqEmTeste(), objDef.iModem2) 
    	        					);
	     	        			
	     	        	}
	     	        	//----------------------------------MODEM 3--------------------------------------------------
	     	        	// Apagar		
	     	        	if( (PegueTimeProcesso() == 30)||(PegueTimeProcesso() == 34)||(PegueTimeProcesso() == 39) ){ taTelnet.setText(""); }
	     	        	if(PegueTimeProcesso() == 31){
	     	        			DispararTesteV2(	objDef.Dsl2500e,
    	        						objDef.iModem3,
    	        						objDef.STATUS,
    	        						objUtil.SeqToLin(PegueSeqEmTeste(), objDef.iModem3) 
    	        					);
	     	        	}
	     	        	if(PegueTimeProcesso() == 35){
	     	        			DispararTesteV2(	objDef.Dsl2500e,
    	        						objDef.iModem3,
    	        						objDef.AUTH,
    	        						objUtil.SeqToLin(PegueSeqEmTeste(), objDef.iModem3) 
    	        					);
	     	        	}
	     	        	if(PegueTimeProcesso() == 40){
	     	        			DispararTesteV2(	objDef.Dsl2500e,
    	        						objDef.iModem3,
    	        						objDef.PING,
    	        						objUtil.SeqToLin(PegueSeqEmTeste(), objDef.iModem3) 
    	        					);
    	        	
	     	        	}
	     	        	//----------------------------------MODEM 4--------------------------------------------------
	     	        	// Apagar		
	     	        	if( (PegueTimeProcesso() == 45)||(PegueTimeProcesso() == 49)||(PegueTimeProcesso() == 54) ){ taTelnet.setText(""); }
	     	        	if(PegueTimeProcesso() == 46){
	     	        			DispararTesteV2(	objDef.Dsl2500e,
    	        						objDef.iModem4,
    	        						objDef.STATUS,
    	        						objUtil.SeqToLin(PegueSeqEmTeste(), objDef.iModem4) 
    	        					);
	     	        	}
	     	        	if(PegueTimeProcesso() == 50){
	     	        			DispararTesteV2(	objDef.Dsl2500e,
    	        						objDef.iModem4,
    	        						objDef.AUTH,
    	        						objUtil.SeqToLin(PegueSeqEmTeste(), objDef.iModem4) 
    	        					);
	     	        	}
	     	        	if(PegueTimeProcesso() == 55){
	     	        			DispararTesteV2(	objDef.Dsl2500e,
    	        						objDef.iModem4,
    	        						objDef.PING,
    	        						objUtil.SeqToLin(PegueSeqEmTeste(), objDef.iModem4) 
    	        					);
    	        	
	     	        	}
	     	        	
     	        	
	     	        	VerFimTeste();	// Verifica resultado do fim dos testes
	     	        	// ------------------------------------------------------------------------------------
	        	
	        		} //if(Tipo de teste)
	        	
	        }	// if(PegueLinAtual() >=  objDef.iTotalLinTab) => Final da Verificação LinAtual x NumLinPlanilha
	        /**************************************************************************************/
	       
	    } // Listerenner
	} // Classe Temporizador



public void AddLinha(JTable Tabela){
	
	objLog.Metodo("mtaView().AddLinha()");
	
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
	    		objLog.Metodo("mtaView().AddLinha()->iPortaFim == 24: "+iPortaFim );
	    	}
	    }
	 	
	// Adiciona dados as celulas da tabela
	objDef.fixeLinTab( Integer.parseInt(objDef.sCBoxLinha) - 1);
			 
	Tabela.setValueAt(tfDslam.getText() + "-" + objDef.sCBoxSlot + "/" + objDef.sCBoxPorta, objDef.pegueLinTab(), objDef.colDSLAM);    // Valor, Lin, Col
    Tabela.setValueAt(tfDataDf.getText(), objDef.pegueLinTab(), objDef.colDATAD);    // Valor, Lin, Col
    Tabela.setValueAt(objDef.sCBoxProtocolo, objDef.pegueLinTab(), objDef.colPROTOCOL);
    
    Tabela.setValueAt(objDef.sCBoxHz, objDef.pegueLinTab(), objDef.colHZ);
    Tabela.setValueAt(objDef.sCBoxVt, objDef.pegueLinTab(), objDef.colVT);
    Tabela.setValueAt(objDef.sCBoxPino, objDef.pegueLinTab(), objDef.colPINO);
    
    Tabela.setValueAt(tfDesc.getText(), objDef.pegueLinTab(), objDef.colDESC);    // Valor, Lin, Col
    
    String sLin = String.valueOf(objDef.pegueLinTab()+1);
	//NumerarLinhas();					// Numera linhas
	Tabela.setValueAt(objDef.AcaoTestar, objDef.pegueLinTab(), objDef.colACAO);		// Fixa célula Analisar/testar = objDef.AcaoTestar 
	
	Tabela.setValueAt(tfDataDf.getText(), objDef.pegueLinTab(), objDef.colDATA);    // Valor, Lin, Col
	
    // Avança Itens Combo-Box
	objDef.incLinTab();
    cbLinha.setSelectedIndex(objDef.pegueLinTab()+1);
    
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
    
  	 objLog.Metodo("mtaView().AddLinha()->iPortaStart: "+iPortaStart);
	 objLog.Metodo("mtaView().AddLinha()->:objDef.pegueCBoxPorta(): "+objDef.pegueCBoxPorta());
	 objLog.Metodo("mtaView().AddLinha()->iPortaFim: "+iPortaFim);

	 
    cbSlot.setSelectedIndex(objDef.pegueCBoxSlot() + 1);
    cbPorta.setSelectedIndex(objDef.pegueCBoxPorta() + 1);
    
    
    
    int iBloco =   Integer.parseInt(objDef.sCBoxBloco);
    
    if(objDef.pegueCBoxPino() + 1 > iBloco ){
    	objDef.incCBoxHz();
    	objDef.fixeCBoxPino(1); //iPino = 1;
    	objLog.Metodo("mtaView().AddLinha()->iPino: "+objDef.pegueCBoxPino()+" > iBloco: "+iBloco);
    }else{
    	objDef.incCBoxPino();
	    objLog.Metodo("mtaView().AddLinha()->iHz: "+objDef.pegueCBoxHz());
	    //iHz = Integer.parseInt(objDef.sCBoxVt);
	    objLog.Metodo("mtaView().AddLinha()->iHz: "+objDef.pegueCBoxHz());
	    objLog.Metodo("mtaView().AddLinha()->iPino: "+objDef.pegueCBoxPino()+" < iBloco: "+iBloco);
    }

    
    cbVt.setSelectedIndex(objDef.pegueCBoxVt());
    cbHz.setSelectedIndex(objDef.pegueCBoxHz());	    
    cbPino.setSelectedIndex(objDef.pegueCBoxPino());
    
    // Rederizar cores Teste/Analise: Sim(Branco), Não(Vermelho), Analisado(Verde)
    // Tabela.getColumnModel().getColumn(objDef.colDSLAM).setCellRenderer(new RenderCorOpcao());
   
    // Cores: Listras(Linha-sim, linha não)
	for(int iC=1; iC < Tabela.getColumnCount(); iC++){
		Tabela.getColumnModel().getColumn(iC).setCellRenderer(new RenderListras());
	}
	
	
	//ModeloTab.addRow(objDef.sTabLinhas);			// Adiciona Linha a tabela
	Tabela.setRowSelectionInterval(0,objDef.pegueLinTab());			// Seleciona a linha adicionada
	Tabela.requestFocus();							// Requsita Focus
	Tabela.changeSelection(objDef.pegueLinTab(),0,false, false);	// Pula para linha adicionada
     
	
   
    
}  



public static void main( String[] args )
{        
    
	new mtaView();
	FrmPrincipal.setVisible(true);			// Mostra FrmPrincipal - Executar aqui pois dentro da função construir, da uns bugs
} 



} // Final da Classe mtaView