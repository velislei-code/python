

//	package prjJxTrader;

	import java.awt.BorderLayout;
	import java.awt.Color;
	import java.awt.Component;
	import java.awt.Cursor;
	import java.awt.Font;
	import java.awt.Graphics;
	import java.awt.Image;
	import java.awt.Label;
	import java.awt.Toolkit;
	import java.awt.Dimension;
	import java.awt.event.ActionEvent;
	import java.awt.event.ActionListener;
	import java.awt.event.MouseAdapter;
	import java.awt.event.MouseEvent;
	import java.util.Date;  
	import java.text.SimpleDateFormat; 

	import javax.swing.DefaultCellEditor;
	import javax.swing.ImageIcon;
	import javax.swing.JButton;
	import javax.swing.JComboBox;
	import javax.swing.JFrame;
	import javax.swing.JLabel;
	import javax.swing.JPanel;
	import javax.swing.JPopupMenu;
	import javax.swing.JSeparator;
	import javax.swing.JTextField;
	import javax.swing.SwingConstants;
	import javax.swing.JMenuItem;
	import javax.swing.JToolBar;
	import javax.swing.JTextArea;
	import javax.swing.JTable;
	import javax.swing.table.DefaultTableModel;
	import javax.swing.table.TableCellEditor;
	import javax.swing.table.TableModel;
	import javax.swing.table.TableRowSorter;
	import javax.swing.*;
	import javax.swing.event.*;
	import javax.swing.table.*;

	import java.awt.Color;
	import java.awt.Component;
	import java.awt.Cursor;
	import java.awt.Dimension;
	import java.awt.Image;
	import java.awt.Toolkit;
	import java.io.File;
	import java.io.IOException;

	import javax.swing.BorderFactory;
	import javax.swing.JButton;
	import javax.swing.JCheckBox;
	import javax.swing.JComboBox;
	import javax.swing.JDialog;
	import javax.swing.JFrame;
	import javax.swing.JLabel;
	import javax.swing.JPanel;
	import javax.swing.JSeparator;
	import javax.swing.JTable;
	import javax.swing.JTextField;
	import javax.swing.JToolBar;
	import javax.swing.SwingConstants;

	
	public class DlgNegocios extends JDialog{
			
			private Date data = new Date();  
			private SimpleDateFormat Formatar = new SimpleDateFormat("dd/MM/yyyy");
			
			
			private Label statusLabel;

			private static JDialog FrmOpcao = new JDialog();
			
			private DefineNegocios objDef = new DefineNegocios();  
			private Posicao objPosicao = new Posicao();		// Posicao das B.Ferramentas, Tabela, 

			private Ferramentas objUtil = new Ferramentas();
			private Arquivos objArq = new Arquivos();
			private Log objLog = new Log();   
			private CxDialogo objCxMsg = new CxDialogo(); 
			private FormSobre objFrmInfo = new FormSobre();
			
			private String vsLinha[] = new String[1000];
				
			
		//	private RenderCorOpcao CellRenderer = new RenderCorOpcao();
			//private Arquivos objArquivo = new Arquivos();

			private static JDialog FrmClientes = new JDialog();
	//		DlgCadClientes objDlgCadClientes = new DlgCadClientes();
			private static JPanel Painel = new JPanel();		
			private JScrollPane BRolagemPainel = new JScrollPane(Painel);
			
			private static JPanel PainelTab = new JPanel();
			private JScrollPane BRolagemPainelTab = new JScrollPane(PainelTab);

			
			// Componentes da BferAddNegocio
			 static boolean bExibeAddNegocio = false;	// Ver se usa
			 JToolBar BfAddNegocio = new JToolBar();
			 private JComboBox cbCodEmpresa  = new JComboBox();
			 private JTextField tfDataCP = new JTextField();	 
			 private JComboBox cbTimeCpM15 = new JComboBox();	 
			 
			 final JTextField tfValorCP = new RenderTextoGost("Valor(Cp)");	 
			 final JTextField tfCotasCP = new RenderTextoGost("N.Cotas(Cp)"); //JTextField();
			 final JTextField tfCorretagem = new JTextField();	 
			 private JComboBox cbAlvo  = new JComboBox();
			 private JComboBox cbRiscoGanho  = new JComboBox();
			 private JComboBox cbStopLoss  = new JComboBox();
			/*
			 final JTextField tfClose = new RenderTextoGost("Fech.");	 
			 final JTextField tfTVol = new RenderTextoGost("T.Vol.");	 
			 final JTextField tfVol = new RenderTextoGost("Vol.");	 
			 final JTextField tfSpread = new RenderTextoGost("Spread");	 
			*/
			
					
			// Componentes da Planilha - criado Global devido bugs de inserção qdo declarado no metodo
			private JToolBar BfPlanilha = new JToolBar(); 
			private JTable Planilha = new JTable(); 	
			private JScrollPane BRolagemPlanilha = new JScrollPane(Planilha, JScrollPane.VERTICAL_SCROLLBAR_ALWAYS, JScrollPane.HORIZONTAL_SCROLLBAR_ALWAYS);
			 

			private DefaultTableModel ModeloTab = new DefaultTableModel(objDef.sTabNegDados, objDef.sTabNegColunas){
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

			// Matriz de opcoes Cx-Seleção dentro da Planilha 
			private String sSelProtocol[][] = { {"Ambos", "PPPoA", "PPPoE"}, 
												{"Ambos", "PPPoA", "PPPoE"}, 
												{"Ambos", "PPPoA", "PPPoE"} };
			private JComboBox cbTabProtocol = new JComboBox(sSelProtocol[0]);
			private TableCellEditor CxSelProtocol = new DefaultCellEditor(cbTabProtocol);

			 // Criar botões
			 JButton BtnAdicionar = new JButton();
			 JButton BtnEditar = new JButton();
			 JButton BtnSalvar = new JButton();	
			 JButton BtnImprimir = new JButton();
			 JButton BtnSair = new JButton();
			

			// Componentes Bf-Filtro
			private JToolBar BfFiltro = new JToolBar();
			private JButton BtnFiltrar = new JButton();
			private final JTextField tfFiltro = new JTextField(20);
			private JLabel lblStatus;   
			

				
			// Status line
			private JTextArea taSLine = new JTextArea();
			private JToolBar BfSLine = new JToolBar();
			private JScrollPane BRolaSLine = new JScrollPane(taSLine, JScrollPane.VERTICAL_SCROLLBAR_ALWAYS, JScrollPane.HORIZONTAL_SCROLLBAR_ALWAYS);
			 
		
			// Componentes Bf-Coordenadas
			 private JComboBox cbPreFiltro  = new JComboBox();
			 private JToolBar BfCoordenadas = new JToolBar();
			 private JToolBar BfCoordFiltro = new JToolBar();
			 private JToolBar BfCoordPos = new JToolBar();
			 private JToolBar BfCoordTitulo = new JToolBar();
			 private JToolBar BfCoordCampo = new JToolBar();	 
			 private JTextField tfCoord = new JTextField();	
			 private JTextField tfCelula = new JTextField();	
			 private JTextField tfTitulo = new JTextField();	
			 private JTextField tfConteudo = new JTextField();
			 
			
			// Componentes Barra de Status
			 private JToolBar BStatus = new JToolBar();
			 private JTextField tfStatus = new JTextField();
				
			 private JToolBar BStatusTeste = new JToolBar();
			 private JTextField tfStatusTeste = new JTextField();
				

			 // Inicializa classe
	    DlgNegocios(){
		  
	    }
	    
	    public void Construir()
	    {        

	    	 
	    	FrmOpcao.setDefaultCloseOperation(FrmClientes.HIDE_ON_CLOSE); //.EXIT_ON_CLOSE); 	// TERMINAR A EXECUCAO SE O FrmClientes FOR FECHADO
			FrmOpcao.setTitle("Clientes");// SETA O TITULO  DO FrmClientes    
			FrmOpcao.setSize(objPosicao.iLargTelaForm, objPosicao.iAltTelaForm);	//	SETA O TAMANHO DO FORUMLARIO             
			FrmOpcao.setLocationRelativeTo(null);  // CENTRALIZA O FrmClientes    
			//FrmOpcao.setExtendedState(FrmClientes.getExtendedState()|JFrame.NORMAL); 
		    /*
	    	FrmOpcao.setTitle( "Cadastrar clientes" );                 
	        FrmOpcao.setSize(750, 500);             
	        FrmOpcao.setLocationRelativeTo(null);    
	        */     
	        
	        // Icone do Form
	    	 String stIcon = objDef.DirRoot + "/imagens/placa2.png";		// Dir ico    
	        Image icon = Toolkit.getDefaultToolkit().getImage(stIcon);	// carrega Icon - não esta carreganfo
	        this.setIconImage(icon);
	    	FrmOpcao.setIconImage(icon);
	        
	        Painel.setLayout(null);         //--[ DESLIGANDO O GERENCIADOR DE LAYOUT ]--\\
	        FrmOpcao.add( Painel );   
	  
	        this.ConstruirBfBotoes();
	        this.ConstruirBfAddNegocio(true);
	        this.ConstruirBfCoordFiltro();
	        this.ConstruirPainel();
	        this.ConstruirPlanilha(false);		// Constroe Planilha(Planílha de testes)
			objDef.fixeStatusJanela(true);	// informa sistema que existe janela aberta, para ctrl(hab/des: botões-evitar bugs)		
			
			//objMySQL.CarregaPlanilha(Planilha, objDef.sTabClientes);

					
			
			this.ConstruirBStatus2();		// Barra de Status(no rodapé)

			FrmOpcao.setVisible( true ); 
			
			FrmClientes.setTitle("Clientes! - " + objArq.PegueAbreDirArq());
			
		
	    	
	   
	    }

		 
		public void initComponents() {

			
			objLog.Metodo("");    
			objLog.Metodo("*** START SMS - "+data+" *** ");
			objLog.Metodo("DlgNegocios().initComponents()");
			/*
			try{
				LerConfig();		// Carrega config de usuário 
		 } catch (IOException ex) {  
			 	objCxD.Aviso("Erro ao carregar arquivo de configuração, " + ex, objDef.bMsgErro);  
		 } finally{
			
		 }
		 
			
			// Consulta total de regs na tabela 
			MySQL objMySQL = new MySQL();
			objDef.fixeTotalLinTab( objMySQL.ContaRegistros(objDef.sTabClientes) );
			*/	
			//Construir(); 	
			ConstruirPainel();
			ConstruirBfBotoes();   
			ConstruirPlanilha(false);		// Constroe Planilha(Planílha de testes)
			objDef.fixeStatusJanela(true);	// informa sistema que existe janela aberta, para ctrl(hab/des: botões-evitar bugs)		
			ConstruirBfCoordFiltro();	
			
			//objMySQL.CarregaPlanilha(Planilha, objDef.sTabClientes);

					
			
			ConstruirBStatus2();		// Barra de Status(no rodapé)

			FrmClientes.setTitle("Clientes! - " + objArq.PegueAbreDirArq());
			
		}
		 








		/********************************************************************************************************************/

		/*
		public void ConstruirForm(){
				
			 objLog.Metodo("DlgNegocios().ConstruirForm()");
			
			// Formulário principal
			// EX: this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
			//FrmClientes.setDefaultCloseOperation(FrmClientes.HIDE_ON_CLOSE); //.EXIT_ON_CLOSE); 	// TERMINAR A EXECUCAO SE O FrmClientes FOR FECHADO
			FrmClientes.setTitle("Clientes");// SETA O TITULO  DO FrmClientes    
			//FrmClientes.setSize(objPosicao.iLargTelaForm, objPosicao.iAltTelaForm);	//	SETA O TAMANHO DO FORUMLARIO             
			//FrmClientes.setLocationRelativeTo(null);  // CENTRALIZA O FrmClientes    
			//FrmClientes.setExtendedState(FrmClientes.getExtendedState()|JFrame.NORMAL); 
			
			// Icone do Form
			 String stIcon = objDef.DirRoot + "/imagens/placa2.png";		// Dir ico    
			 Image icon = Toolkit.getDefaultToolkit().getImage(stIcon);	// carrega Icon - não esta carreganfo
			 //this.setIconImage(icon);
			 FrmClientes.setIconImage(icon);			
			 FrmClientes.setVisible(true);			// Mostra FrmClientes - Executar aqui pois dentro da função construir, da uns bugs
			
		}
	*/
		public void ConstruirPainel(){
				
			objLog.Metodo("DlgNegocios().ConstruirPainel()");

			  
			 Painel.setLayout(null); 	//DESLIGANDO O GERENCIADOR DE LAYOUT  
			 BRolagemPainel.setHorizontalScrollBarPolicy(JScrollPane.HORIZONTAL_SCROLLBAR_AS_NEEDED);
			 BRolagemPainel.setVerticalScrollBarPolicy(JScrollPane.VERTICAL_SCROLLBAR_NEVER);
			 BRolagemPainel.setBounds(50, 30, 300, 50);
			  

		  

			 FrmClientes.add(BRolagemPainel); 	// Adiciona ao formulário
		 
		 
		}

		public void ConstruirPainelTab(){
			
			objLog.Metodo("DlgNegocios().ConstruirPainelTab()");

		  
			PainelTab.setLayout(null); 	//DESLIGANDO O GERENCIADOR DE LAYOUT  
			BRolagemPainelTab.setHorizontalScrollBarPolicy(JScrollPane.HORIZONTAL_SCROLLBAR_AS_NEEDED);
			BRolagemPainelTab.setVerticalScrollBarPolicy(JScrollPane.VERTICAL_SCROLLBAR_NEVER);
			BRolagemPainelTab.setBounds(50, 30, 300, 50);
	  

	  

			FrmClientes.add(BRolagemPainelTab); 	// Adiciona ao formulário
	 
	 
	}

		private static void AddPainel(Component Componente , int nColuna , int nLinha , int nLargura , int nAltura)  
		{
		  Painel.add(Componente) ;  // Adiciona componente ao painel                    
		     Componente.setBounds( nColuna , nLinha , nLargura , nAltura ); // Fixa posição do componente
		}

		private static void AddPainelTab(Component Componente , int nColuna , int nLinha , int nLargura , int nAltura)  
		{
			PainelTab.add(Componente) ;  // Adiciona componente ao painel                    
		    Componente.setBounds( nColuna , nLinha , nLargura , nAltura ); // Fixa posição do componente
		}


		/********************************************************************************************************************/
		/*
		*  Construir Barra de ferramentas...
		*/
		public void ConstruirBfBotoes(){
		//Constroe barra de Fer. Projeto[Novo, Abrir...]	 
			 objLog.Metodo("DlgNegocios().ConstruirBfBotoes()");
			 
			 int iBtAltLarg = 50;
			 // Criar a barra 
			 JToolBar BarFerBotoes = new JToolBar();
			 BarFerBotoes.setFloatable(true);		// permite mover BFer. 
			 BarFerBotoes.setRollover(true);

			 
			 AddPainel(BarFerBotoes,objPosicao.bfPlanBtnPosCol, objPosicao.bfPlanBtnPosLin, objPosicao.bfPlanBtnLarg, objPosicao.iAltPadraoBfBtn); // (iCol , iLin, iLarg, iAlt)
			 BarFerBotoes.setFloatable(false);	 
			 BarFerBotoes.setRollover(true);
			 
			 JSeparator SeparaBarFerBotoes = new JSeparator();
			 SeparaBarFerBotoes.setOrientation(SwingConstants.VERTICAL);
			 BarFerBotoes.add(SeparaBarFerBotoes);
			    
			 
			 // Adicionar botões a barra
			 BarFerBotoes.add(BtnAdicionar);
			 BarFerBotoes.add(BtnEditar);
			 BarFerBotoes.add(BtnSalvar);
			 BarFerBotoes.add(BtnSair);
			 
			 // Inserir icones nos botões
			 BtnAdicionar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/write.png"));
			 BtnAdicionar.setToolTipText("Novo projeto");		// Insere Title no botão
			 BtnAdicionar.setHideActionText(true);
			 BtnAdicionar.setBorderPainted(true);
			 BtnAdicionar.setCursor(new Cursor(Cursor.HAND_CURSOR));		
			 BtnAdicionar.setMinimumSize(new Dimension(iBtAltLarg, iBtAltLarg));
			 BtnAdicionar.setPreferredSize(new Dimension(iBtAltLarg, iBtAltLarg));
			 BtnAdicionar.setMaximumSize(new Dimension(iBtAltLarg, iBtAltLarg));
			 
			
			 BtnEditar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/editar.png"));
			 BtnEditar.setToolTipText("Abrir projeto(*.mta)");   
			 BtnEditar.setHideActionText(true);
			 BtnEditar.setBorderPainted(true);
			 BtnEditar.setCursor(new Cursor(Cursor.HAND_CURSOR));		

			 BtnEditar.setMinimumSize(new Dimension(iBtAltLarg, iBtAltLarg));
			 BtnEditar.setPreferredSize(new Dimension(iBtAltLarg, iBtAltLarg));
			 BtnEditar.setMaximumSize(new Dimension(iBtAltLarg, iBtAltLarg));
			 
			 BtnSalvar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/Btnsalvar48.png"));
			 BtnSalvar.setToolTipText("Salvar projeto(*.mta)");
			 BtnSalvar.setHideActionText(true);
			 BtnSalvar.setBorderPainted(true);
			 BtnSalvar.setCursor(new Cursor(Cursor.HAND_CURSOR));		

			 BtnSalvar.setMinimumSize(new Dimension(iBtAltLarg, iBtAltLarg));
			 BtnSalvar.setPreferredSize(new Dimension(iBtAltLarg, iBtAltLarg));
			 BtnSalvar.setMaximumSize(new Dimension(iBtAltLarg, iBtAltLarg));
		
			 BtnSair.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/sair.png"));
			 BtnSair.setToolTipText("Sair");
			 BtnSair.setHideActionText(true);	
			 BtnSair.setBorderPainted(true);
			 BtnSair.setCursor(new Cursor(Cursor.HAND_CURSOR));		

			 BtnSair.setMinimumSize(new Dimension(iBtAltLarg, iBtAltLarg));
			 BtnSair.setPreferredSize(new Dimension(iBtAltLarg, iBtAltLarg));
			 BtnSair.setMaximumSize(new Dimension(iBtAltLarg, iBtAltLarg));
			 
			 // Ouvir enventos
			 BtnAdicionar.addActionListener(new java.awt.event.ActionListener() {
				 public void actionPerformed(java.awt.event.ActionEvent evt) {
					BtnAdicionarActionPerformed(evt);
				}
			 });
			 BtnEditar.addActionListener(new java.awt.event.ActionListener() {
				 public void actionPerformed(java.awt.event.ActionEvent evt) {
					 BtnEditarActionPerformed(evt);
				}
			 });
			 BtnSalvar.addActionListener(new java.awt.event.ActionListener() {
				 public void actionPerformed(java.awt.event.ActionEvent evt) {
					 BtnSalvarActionPerformed(evt);
				 }
			 });
			 BtnSair.addActionListener(new java.awt.event.ActionListener() {
				 public void actionPerformed(java.awt.event.ActionEvent evt) {
					 BtnSairActionPerformed(evt);
				 }
			 });
			 
		}

		private void BtnAdicionarActionPerformed(java.awt.event.ActionEvent evt) {
			
			/*
			FormCadClientes objFrmCadClientes = new FormCadClientes();
			objFrmCadClientes.initComponents();	// Chama janela cadastro
			*/
			
			
			//objDlgCadClientes.Construir();
			
			
			   
		}

		private void BtnEditarActionPerformed(java.awt.event.ActionEvent evt) {
			/*
			try{
				
				objArquivo.LerMtaIni(Planilha, null);	
				
			}catch(IOException e){
				objLog.Metodo("DlgNegocios().salvarMTA().IniFiles(Erro ao gravar Arquivo)");
			}finally{
				// objCxD.Aviso("Arquivo *.mta carregado !", objDef.bMsgAbrir);
			}
			*/
			
		}

		private void BtnSalvarActionPerformed(java.awt.event.ActionEvent evt) {	
			
			/*
			int iTReg = objUtil.ContarReg(Planilha);	// Conta numero de registros na Planilha
			if( iTReg > 0){							// Verifica NumReg
				try{	 
					objArquivo.SalvarMtaIni(Planilha, objFrmOpcao.tfPrjNome.getText(), iTReg);	// Salva dados
					
				}catch(IOException e){
					objLog.Metodo("DlgNegocios().salvarMTA().IniFiles(Erro ao gravar Arquivo)");
				}finally{
					//new CxDialogo().Aviso("Arquivo *.mta Salvo !");
				}
			}else{
				objCxD.Aviso("Não há registros a serem salvos.", objDef.bMsgErro);
			}
			*/
			
		}

		private void BtnSairActionPerformed(java.awt.event.ActionEvent evt) {
			 
			//objFrmOpcao.Construir(Planilha);
			
			//this.setVisible(false);
			
			
			this.Destroi();					// Rotina liberar objetos criados		
			FrmOpcao.dispose();			// Fecha janela atual
			//objDlgCadClientes.BtnSair.doClick();	// Fecha possivel Dlg aberto
			
			
			
			   
		}
		

			
			/******************************************************************************************************/
			

			public void ConstruirBfCoordFiltro(){
				
				//ConstruirBfCoord();
				//ConstruirBfFiltro();
				
				// Barra Fer.Coord + Filtro (Em uso)  
				objLog.Metodo("DlgNegocios().ConstruirBfCoordFiltro()");				
				
				BfFiltro.setFloatable(false);	 
				BfFiltro.setRollover(true);		
				
				AddPainel(BfFiltro,objPosicao.bfNegPlanFiltroCol, objPosicao.bfNegPlanFiltroLin, objPosicao.iLargTabForm, objPosicao.iAltBfFiltro); // (iCol , iLin, iLarg, iAlt)

				JSeparator SeparaBfCoordFiltro = new JSeparator();
				SeparaBfCoordFiltro.setOrientation(SwingConstants.VERTICAL);
				BfFiltro.add(SeparaBfCoordFiltro);

				JSeparator SeparaBfFiltro = new JSeparator();
				SeparaBfFiltro.setOrientation(SwingConstants.VERTICAL);
				
				int iCoordAlt = 25;
				int iCoordLarg = 350;

				// Coordenadas
				BfFiltro.add(SeparaBfFiltro);
				
				BfFiltro.add(tfCoord);			// Coordenada da linha			
				tfCoord.setColumns(5);
				tfCoord.setText("[Porta, 1]:");
				tfCoord.setEditable(false);	// Bloquear edição	
				
				
				
				// Botão do campo filtrar
				BfFiltro.add(SeparaBfCoordFiltro);
				BfFiltro.add(BtnFiltrar);
				BtnFiltrar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnFiltro16.png"));
				BtnFiltrar.setToolTipText("Aplicar filtro");	// Dica do botão
				BtnFiltrar.setCursor(new Cursor(Cursor.HAND_CURSOR));
				BtnFiltrar.setHideActionText(true);
				BfFiltro.add(tfFiltro);
				tfFiltro.setSize(iCoordLarg, iCoordAlt);
				tfFiltro.setMinimumSize(new Dimension(iCoordLarg, iCoordAlt));
				tfFiltro.setPreferredSize(new Dimension(iCoordLarg, iCoordAlt));
				tfFiltro.setMaximumSize(new Dimension(iCoordLarg, iCoordAlt));
				
				
				
						
						
			}

			// Final das Barra de ferramentas
		/*******************************************************************************/

		
			public void paintComponent(Graphics g){
				 //   super.paintComponent(g);
				        
				    g.setFont(new java.awt.Font("Courier New", 0, 11));	
				    g.setColor(Color.gray);


				    g.setColor(Color.RED);     
				    g.drawLine(0, 0, 500, 50);	//  ColIni, LinIni, ColFim, LinFim()
				    
			
			 }

			
		
			
			/*****************************************************************************************************/
			public void ConstruirPlanilha(boolean bAjustar){
				/*
				 * Constroi planilha no Form
				 * Exemplos de manipulação de tabelas
				 * http://pt.stackoverflow.com/questions/139385/ajustar-colunas-de-acordo-com-tamanho-dispon%C3%ADvel-da-jtable
				 */
				objLog.Metodo("DlgNegocios().ConstruirPlanilha(" + bAjustar + "): 0");
						 
				objLog.Metodo("DlgNegocios().ConstruirPlanilha(" + bAjustar + "): 1 ->["+objPosicao.iLargTabForm+", "+ objPosicao.iAltTabForm+"]");				
					
				 BfPlanilha.setFloatable(false);	 
				 BfPlanilha.setRollover(true);
				 // (Componente, Col, LInha, Larg, Altura)
				 if(bAjustar){
					 objLog.Metodo("DlgNegocios().ConstruirPlanilha(" + bAjustar + "): 2");
					 AddPainel(BfPlanilha, objPosicao.FrmNegocioBfTabColIni, objPosicao.FrmNegocioBfTabLinIni + 25, objPosicao.FrmNegocioLargTabForm, objPosicao.FrmNegocioAltTabForm);
				 }else{
					 AddPainel(BfPlanilha, objPosicao.FrmNegocioBfTabColIni, objPosicao.FrmNegocioBfTabLinIni - 25, objPosicao.FrmNegocioLargTabForm, objPosicao.FrmNegocioAltTabForm);
						
					 objLog.Metodo("DlgNegocios().ConstruirPlanilha(" + bAjustar + "): 3");
				 }
				 
				 objLog.Metodo("DlgNegocios().ConstruirPlanilha(" + bAjustar + "): 4");
				 
				 Planilha.setModel(ModeloTab); 				// Modelotab - variavel Global 
				 Planilha.setAutoResizeMode(JTable.AUTO_RESIZE_OFF);			 
				 
				 Planilha.addRowSelectionInterval(0, 0);	//Seleciona a linha
				 Planilha.setFont( new Font("arial", Font.PLAIN, 12) );
				 

				// Alinha Texto da coluna à esquerda
				DefaultTableCellRenderer cellRender = new DefaultTableCellRenderer(); 
				
				cellRender.setHorizontalAlignment(SwingConstants.LEFT);			
				Planilha.getColumnModel().getColumn(objDef.colDataCP_TabNeg).setCellRenderer(cellRender);	// Alinha a esquerda
				Planilha.getColumnModel().getColumn(objDef.colHoraCP_TabNeg).setCellRenderer(cellRender);	// Alinha a esquerda
				
				
				objLog.Metodo("DlgNegocios().ConstruirPlanilha(" + bAjustar + "): 5");

				 // CORES		 
				 Planilha.setSelectionForeground(Color.BLACK); 	// Texto da linha selecionada
				 Planilha.setForeground(Color.BLACK);  			// texto
				 Planilha.setBackground(Color.WHITE); 			// Fundo		  
				 Planilha.setShowGrid(true);						// Linhas de Grade
				 
				 //Planilha.setOpaque(true);
					
					
				 //---------------------------------------------------------------------
				 // Cores: Sim, Não, Analisado - aki1
			//		Planilha.getColumnModel().getColumn(objDef.colTEND).setCellRenderer(new RenderCorOpcao());		
				
				 objLog.Metodo("DlgNegocios().ConstruirPlanilha(" + bAjustar + "): 6");
				 
				// Rederizar Listras - uma sim, uma não
					for(int iC=1; iC < Planilha.getColumnCount(); iC++){					
						Planilha.getColumnModel().getColumn(iC).setCellRenderer(new RenderListras());
					}
					
					/*
					 *  Cor da linha selecionada(seleção)
					 *  Pinta coluna Nº de azul-ciano
					 */
					 Planilha.setSelectionBackground(Color.cyan); 
				 //--------------------------------------------------------------------------------------
				 // Alinhamento do texto
				// Planilha.setDefaultRenderer(Object.class, new RenderAlinhaTexto()); // Centraliza o texto(completo)
				
				//---------------------------------------------------------------------
				
				 
				 /***************************************************************************/
				 //--------------------------------------------------------------------------
				 // Inclui Cx de Seleção nas células[Ambos, PPPoA, PPPoE] - [Sim, Não, OK, Sml] 
				 // +1: Ajuste necessario após  coluna "Num"(passou ter 2 colunas endereçadas como Zero
			     Planilha.getColumnModel().getColumn(objDef.colOperacao_TabNeg + 1).setCellEditor(CxSelTeste);
			     // Planilha.getColumnModel().getColumn(objDef.colMAX + 1).setCellEditor(CxSelProtocol);
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
		   //Planilha.add(BRolagemPlanilha, BorderLayout.NORTH);

		   ActionListener alCapturarAcao;
		   alCapturarAcao = new ActionListener(){
		            public void actionPerformed(ActionEvent e){
		         	  
		         	//   ModeloTab.removeRow(objDef.pegueTotalLinTab());	// Remove Linha selecionada
		         	   
		         	    
		         	   /*
		         	    * Devido a falhas que ocorrem com: 
		         	    * 4 modens, mas 2 linhas = travamento
		         	    * As linhas abaixo inserem linhas adicionais a Planilha 
		         	    * no momento da filtragem
		         	    *  
		         	    */
		         	   
		         	  // objCxD.Aviso("Total de Lin(antes): " + objDef.pegueTotalLinTab(), true);
		         	   
		         	   //---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		         	   /*
		         	    *  Usado na aplicação do Filtro
		         	    *  - A idéia aqui era inserir 2 linhas com mesmos dados do filtro("Filtrar: " + tfFiltro.getText())
		         	    *  		para entrar na filtragem, assim 2 linhas a mais seriam adicionadas, e aparecem no filtro 
		         	    *  		o problema é que estas linhas adicionadas, não saem após tirar o filtro 
		         	    *  		e a Planilha vai incrementado linhas adicionais, a cada uso do filtro 
		         	    * BUG:
		         	    *  - Aplica-se filtro e fica somente 3 linhas 
		         	    *  - Ao Exec. o testes qdo chega na 4 Linha o sistema trava 
		         	    *  
		         	    *  - Qdo usa a rotina alterar uma linha, ao invez de inserir linhas com: 
		         	    *  		- Planilha.setValueAt("Filtro: 02/", 100, objDef.colCANDLE);
		         	    *  		funciona, mas na volta do filtro, trava
		         	    */
		         	   
		         	   /*
		         	   if(tfFiltro.getText() != ""){
		         		//  String[] sLinhas = new String[]{ "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "Filtrar: " + tfFiltro.getText() };
		         		//  ModeloTab.addRow(sLinhas); 		// Adiciona linha pre-formatada acima(com texto de filtro), a matriz
		         		  Planilha.setValueAt("Filtro: " + tfFiltro.getText(), 100, objDef.colCANDLE);
		         	   }
		         	   */
		         	   
		         	   // ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		         	  /*
		         	   * Esta rotina trava filtro ao retornar a Plan-Full
		         	   if(tfFiltro.getText() != ""){
		         		   Planilha.setValueAt(tfFiltro.getText().toString(), 10, objDef.colDATA);
		         	   }
		                */
		         	  
		         	   /*
		         	   if(tfFiltro.getText()!=""){  objDef.bFiltroAplicado = true; }
		         	   else{  objDef.bFiltroAplicado = false; } 
		         	  */
		         	   objLog.Metodo("DlgNegocios().BtnFiltrar().click()"); 
		               // Install a new row filter.
		               String FiltrarExpressao = tfFiltro.getText();
		               trsClassificar.setRowFilter(RowFilter.regexFilter(FiltrarExpressao));

		               // Unsort the view.
		               trsClassificar.setSortKeys(null);
		               
		               /*
		                *  Atualiza núm.registros visíveis na Planilha, após filtro
		                *  Usado pelo sistema para calculos de varredura de linhas na Planilha
		                */
		               objDef.fixeTotalLinTab( trsClassificar.getViewRowCount() ); 
		               
		               
		              // objCxD.Aviso("Total de Lin: " + objDef.pegueTotalLinTab(), true);
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
		  	//  pack();	// Não vi diferença !!!!

		   /***************************************************************************/
		   
				 int iNumLinTab = Planilha.getRowCount();			// Pega o número de linhas
				
				 // Ajusta largura de todas as colunas - padrão
				 //  TableColumn colTAB = Planilha.getColumnModel().getColumn(1);
				 // int width = 100;
				 // colTAB.setPreferredWidth(width);
				 String[] sTabNegColunas = new String[]{	};
					
				 // ---------------------------------------------------------------------------------------
				 // Ajusta largura PADRÃO da coluna(N)   
				 Planilha.getColumnModel().getColumn(objDef.colN_TabNeg).setPreferredWidth(35);	// Coluna de Numeração
				 Planilha.getColumnModel().getColumn(objDef.colN_TabNeg).setMaxWidth(200);  			// Larg.Max
				
				 // Ajusta altura de todas as linha
				 Planilha.setRowHeight(objPosicao.iAlturaLinTab); 		 

				 // Congela coluna "N"
				 RenderCongelarColuna objCongelar = new RenderCongelarColuna(1, BRolagemPlanilha);  
				 Planilha.setAutoResizeMode(Planilha.AUTO_RESIZE_OFF); 
				 
				 Planilha.getColumnModel().getColumn(objDef.colN_TabNeg).setPreferredWidth(30);		// Coluna de Numeração
				 Planilha.getColumnModel().getColumn(objDef.colEMPRESA_TabNeg).setPreferredWidth(60);		// Preferencial		 
				 Planilha.getColumnModel().getColumn(objDef.colValorCP_TabNeg).setMaxWidth(60);  			// Larg.Max		 
				 Planilha.getColumnModel().getColumn(objDef.colCotasCP_TabNeg).setPreferredWidth(60);		// Preferencial
				 Planilha.getColumnModel().getColumn(objDef.colCorretagemCP_TabNeg).setPreferredWidth(60);	// Preferencial		 
				 Planilha.getColumnModel().getColumn(objDef.colEmlCP_TabNeg).setPreferredWidth(60);			// Preferencial
				 Planilha.getColumnModel().getColumn(objDef.colIssCP_TabNeg).setPreferredWidth(60);			// Preferencial
				 Planilha.getColumnModel().getColumn(objDef.colSTotalCP_TabNeg).setPreferredWidth(60);		// Preferencial
				 Planilha.getColumnModel().getColumn(objDef.colDataCP_TabNeg).setPreferredWidth(70);		// Preferencial
				 
				 Planilha.getColumnModel().getColumn(objDef.colHoraCP_TabNeg).setPreferredWidth(60);	// Preferencial   
				 Planilha.getColumnModel().getColumn(objDef.colSeparaCP_TabNeg).setPreferredWidth(60);	// Preferencial
				 Planilha.getColumnModel().getColumn(objDef.colAlvo_TabNeg).setPreferredWidth(60);	// Preferencial
				 Planilha.getColumnModel().getColumn(objDef.colStop_TabNeg).setPreferredWidth(60);	// Preferencial
				 // ---------------------------------------------------------------------------------------
				// Carregar(Add) linhas na Planilha
				for(int iL=0; iL <= objDef.pegueTotalLinTab(); iL++){ 
					int iLx = iL + 1;
					ModeloTab.addRow(objDef.sTabLinhas); 			// Adiciona linha pre-formatada de matriz
				//	Planilha.setValueAt(iLx, iL, objDef.colN);		// Numera Linhas(Com coluna congelada, esta numeração ocorre na coluna Nome)
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
			            		
			            	//	tfCoord.setText( objUtil.LinToSeqMd(Planilha.getSelectedRow()) );				// Atualiza coordenadas
			            		        	
			            		//tfCelula.setText( sC + iLin );	//[A1]
			            		String sConteudo = Planilha.getValueAt(Planilha.getSelectedRow(), Planilha.getSelectedColumn() ).toString();
			            		tfCelula.setText( "[" + Planilha.getColumnName(iCol-1) + ", " +iLin + "]: " + sConteudo);	// [Porta, 1]: Conteudo desta celula	               
			            	//	tfTitulo.setText( Planilha.getColumnName(iCol-1) + " " +iLin + "]");	               	
			            	//	tfConteudo.setText( Planilha.getValueAt(Planilha.getSelectedRow(), Planilha.getSelectedColumn() ).toString() ); 
							
			            		objLog.Metodo("DlgNegocios().Planilha.addMouseListener(new MouseAdapter()");				
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
			            					  
			            				//	  int iTReg = objUtil.ContarReg(Planilha);	// Conta numero de registros na Planilha
			            				  //  	if( iTReg > 1){							// Verifica NumReg
			            				    		
			            				    		if(objUtil.bDesfazer){
			            				    			DesfazerExcluir();	            				    		
			            				    		}else{
			            				    			objCxMsg.Aviso("Não há registros a serem recuperados.", true);
			            				    		}
			            				    		
			            				    // 	}else{ objCxD.Aviso("Não há registros a serem recuperados.", true); }

			            					  
			            				  }	            				
			            			  });  
			            			  
			            			  menuItem = new JMenuItem("Excluir linha", new ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnSalvarLinha16.png"));
			            			  Pmenu.add(menuItem);
			            			  
			            			  menuItem.addActionListener(new ActionListener(){
			            				  public void actionPerformed(ActionEvent e){
			            						int iTReg = objUtil.ContarReg(Planilha);	// Conta numero de registros na Planilha
			            				    	if( iTReg > 1){							// Verifica NumReg	            				    
			            				    		  int iLinSelecionada = Planilha.getSelectedRow();
			    	            					  int iLinNum = iLinSelecionada + 1; 	// Devido diferença entre linhas: 0(Sistema), 1(usuário)
			    	            					  if(objCxMsg.Confirme("Excluir a linha " + iLinNum + "("+ Planilha.getValueAt( iLinSelecionada, 0) +"...) da Planilha ?", objDef.bMsgExcluir)){
			    	            						  	DeletarLinha(iLinSelecionada);	    	            						  	
			    	            					  }
			    	            				}else{ objCxMsg.Aviso("Não há registros a serem excluidos.", true); }
					  }	            				
			            			  });
			            			  
			            			 // Pmenu.addSeparator();
			            			  
			            			  menuItem = new JMenuItem("Inserir linha", new ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnAddLinha16.png"));
			            			  Pmenu.add(menuItem);
			            			  menuItem.addActionListener(new ActionListener(){	            				  
			            				  public void actionPerformed(ActionEvent e){
			            					  
			            					  int iTReg = objUtil.ContarReg(Planilha);	// Conta numero de registros na Planilha
			            				    	if( iTReg > 1){							// Verifica NumReg	            				    
			            				    		 int iLinSel = Planilha.getSelectedRow();	  	            					  
				            						 InserirLin(iLinSel);
			            				    	}else{ objCxMsg.Aviso("Não há registros a serem movidos.", true); }
		   				  }	            				
			            			  });
			            			  
			            			  Pmenu.addSeparator();
			            			  
			            			  menuItem = new JMenuItem("Limpar Planilha", new ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnLimpar16.png"));
			            			  Pmenu.add(menuItem);
			            			  menuItem.addActionListener(new ActionListener(){
			            				  public void actionPerformed(ActionEvent e){	
			            						int iTReg = objUtil.ContarReg(Planilha);	// Conta numero de registros na Planilha
			            				    	if( iTReg > 1){							// Verifica NumReg	            				    
			            				    		  if(objCxMsg.Confirme("Apagar todos os registros da Planilha?", objDef.bMsgExcluir)){
			    	            						  objUtil.LimparTabela(Planilha);
			    	            						//Ver aki  LimparItensFiltro("Filtrar campos...");
			    	            					  }
			            				     	}else{ objCxMsg.Aviso("Não há registros a serem excluidos.", true); }

			            					
			            				  }	            				
			            			  });  
			            			  
			            			  Pmenu.addSeparator();
			            			  
			            			  menuItem = new JMenuItem( "Salvar", new ImageIcon(objDef.DirRoot + "imagens/Icon_btn/16.png") );
			            			  Pmenu.add(menuItem);
			            			  menuItem.addActionListener(new ActionListener(){
			            				  public void actionPerformed(ActionEvent e){	
			            					  int iTReg = objUtil.ContarReg(Planilha);	// Conta numero de registros na Planilha
			            				    	if( iTReg > 1){							// Verifica NumReg	            				    
			            				     	
			            				    	}else{ objCxMsg.Aviso("Não há registros a serem salvos.", true); }
			            				  }	            				
			            			  });  
			            			  
			            			  Pmenu.addSeparator();
			            			  
			            			  menuItem = new JMenuItem("Propriedades", new ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnPropriedades16.png"));
			            			  Pmenu.add(menuItem);
			            			  menuItem.addActionListener(new ActionListener(){
			            				  public void actionPerformed(ActionEvent e){	
			            					  if(objCxMsg.Confirme("Propriedades da Planilha", objDef.bMsgExcluir)){

			            					  }
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
				 
				 /*
				  * Navegação das teclas na Planilha(Setas, Tab, Backspace, etc) 
				  */
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
				            	
				    			
				            	
				    			//tfCoord.setText( objUtil.LinToSeqMd(Planilha.getSelectedRow()) + ", " + sInfoCelula );				// Atualiza coordenadas
				            	String sConteudo = Planilha.getValueAt(Planilha.getSelectedRow(), Planilha.getSelectedColumn() ).toString();
			            		tfCoord.setText( "[" + Planilha.getColumnName(iCol-1) + ", " +iLin + "]: " + sConteudo);	// [Porta, 1]: Conteudo desta celula	               
			            	
				    			//tfCoord.setText( Planilha.getColumnName(iCol-1) + " [" +iLin + "]");				// Atualiza coordenadas

				               //	tfCelula.setText( Planilha.getColumnName(iCol-1) + " [" +iLin + "]");	// Porta[1]
				               //	tfTitulo.setText( Planilha.getColumnName(iCol-1) + " [Lin: " +iLin + "]");		               
				              //	tfConteudo.setText( Planilha.getValueAt(Planilha.getSelectedRow(), Planilha.getSelectedColumn() ).toString() ); 
								objLog.Metodo("DlgNegocios().Planilha.addKeyListener(new java.awt.event.KeyAdapter()");
			                }  
			            }             
			        });  
				
			}
			
		/********************************************************************************************************************/
		public void ConstruirBStatus(){
				
				objLog.Metodo("DlgNegocios().ConstruirBStatus()");
				
				BStatus.setFloatable(false);	 
				BStatus.setRollover(true);		
				
				AddPainel(BStatus, 1, objPosicao.iBStLinIni, objPosicao.iTelaLarg, objPosicao.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
				
				JSeparator SeparaBStatus = new JSeparator();
				SeparaBStatus.setOrientation(SwingConstants.VERTICAL);
				BStatus.add(SeparaBStatus);


				BStatus.add(tfStatus);
				tfStatus.setColumns(50);
				tfStatus.setText("SMS...");
				tfStatus.setEditable(false);	// Bloquear edição
				
		}

		public void ConstruirBStatus2(){
			
			objLog.Metodo("DlgNegocios().ConstruirBStatus2()");
			
			BStatus.setFloatable(false);	 
			BStatus.setRollover(true);		
			
			AddPainel(BStatusTeste, 1, objPosicao.iBStLinIni, 100, objPosicao.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
			AddPainel(BStatus, 100, objPosicao.iBStLinIni, objPosicao.iTelaLarg, objPosicao.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)
			
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
			tfStatus.setText("SMS...");
			tfStatus.setEditable(false);	// Bloquear edição
			
		}


		/********************************************************************************************************************/

			public void CarregarcbPreFiltro(){
			
				objLog.Metodo("DlgNegocios().CarregarcbPreFiltro()");
			
				int iNumLinTab = Planilha.getRowCount();			// Pega o número de linhas
				for(int iF=0; iF < iNumLinTab; iF++){
					//cbPreFiltro.addItem( PlanilhaComum.getValueAt(iF, PlanilhaComum.getSelectedColumn() ).toString() ); 
					if(Planilha.getValueAt(iF, 0) != ""){
						cbPreFiltro.addItem(Planilha.getValueAt(iF, 0));
					}
				}
			}

			public void LimparSequencia(int iSequencia){
			
				/*
				 *  Apaga registros de testes da sequencia atual
				 *  Preserva campos de importação e observação 
				 */
				
				objLog.Metodo("DlgNegocios().LimparSequencia(" + iSequencia +")");
				
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
					if(Planilha.getValueAt(iLinDaSeq, objDef.colDATA).toString().contains("6")){
						Planilha.setValueAt(objDef.AcaoTestar, iLinDaSeq, objDef.colTEND);		// Seta coluna Testar = Sim
					}
					for(int iC=8; iC < iNumColTab; iC++){
						 Planilha.setValueAt("", iLinDaSeq, iC);	// Limpa colunas do testes anterior
					}
				}
				
			}
			
			public void LimparTestes(int iTotLin){
				
				/*
				 *  Apaga registros de testes da sequencia atual
				 *  Preserva campos de importação e observação 
				 */
				
				objLog.Metodo("DlgNegocios().LimparTestes()");
				
				int iNumLinTab = Planilha.getRowCount();	
				int iNumColTab = Planilha.getColumnCount() - 1;		// (-1)Preserva campo obs
				
				
				
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
					if(Planilha.getValueAt(iLinDaSeq, objDef.colDATA).toString().contains("6")){
						Planilha.setValueAt(objDef.AcaoTestar, iLinDaSeq, objDef.colTEND);		// Seta coluna Testar = Sim
					}
					for(int iC=8; iC < iNumColTab; iC++){
						 Planilha.setValueAt("", iLinDaSeq, iC);	// Limpa colunas do testes anterior
					}
				}
				
			}
			
			





		     
		 public void DeletarLinha(int iLinDel){
				
				objLog.Metodo("DlgNegocios().DeletarLinha("+iLinDel+")");
				/*
				 *  Re-Aloca valores das celulas da Planilha, 
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
					//objLog.Metodo("DlgNegocios().DeletarLinha()->Mem: " + iCx);
					objUtil.sDesfazerExcluir[iCx] = Planilha.getValueAt(iLinDel, iCx).toString(); 
				}    
				
				
				// Deleta(Desloca linhas para cima - preenche linha excluida)
				int iTotLinPlan =  objUtil.ContarReg(Planilha);	//Planilha.getRowCount();
				objLog.Metodo("DlgNegocios().DeletarLinha()->iTotLinPlan: " + iTotLinPlan);
				
				for(int iL=iLinDel; iL <= iTotLinPlan; iL++){
					int iLx = iL+1;
					//objLog.Metodo("DlgNegocios().DeletarLinha()->Del-iL: " + iL);
					for(int iC=0; iC < objDef.iTotColunaTab; iC++){ 			
						//objLog.Metodo("DlgNegocios().DeletarLinha()->Del-iC: " + iC);
						Planilha.setValueAt(Planilha.getValueAt(iLx, iC), iL, iC);    				
					}
				}
				
				
				
				
			}
			
			public void DesfazerExcluir(){
				objLog.Metodo("DlgNegocios().DesfazerExcluir()");
				
				
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
				int iTotal = objUtil.ContarReg(Planilha) +1;	// Conta numero de registros na Planilha
				
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
			 * Estes métodos foram criados dentro da SMS devido a diferença de objetos(Definições) 
			 * os valore abaixo não são os mesmos, do objeto criado na classe SMS e Arquivos
			 * então, qdo uma var.é atualizada no objeto da classe SMS(objDef.xxx), este não carrega 
			 * o valor para o objeto(objDef.xxx) criado dentro da classe Arquivos
			 *  
			 */

		    //--[ FUNCAO PARA ADICIONAR COMPONENTES NO PAINEL DO FORMULARIO ]--\\
		    private static void Adiciona(Component Componente, int iColIni, int iLinIni, int iLargura, int iAltura, boolean bUsarPaneil)  
		    {
		    	/*
		    	if(bUsarPaneil){ Painel.add(Componente); }
		    	else{	pnCampoTexto.add(Componente);	}	                      
		    	*/	
		    	Painel.add(Componente);
		    	Componente.setBounds(iColIni, iLinIni, iLargura, iAltura);
		    	
		    }
		    
		    public ImageIcon criarImageIcon(String caminho, String descricao) {  
		        java.net.URL imgURL = getClass().getResource(caminho);  
		        if (imgURL != null) {  
		            return new ImageIcon(imgURL, descricao);  
		        } else {  
		            System.err.println("Não foi possível carregar o arquivo de imagem: " + caminho);  
		            return null;  
		        }  
		    } 
		    
		    
		    public void Destroi(){
				
				/*
				 * Libera objetos da memoria, 
				 * sem esta rotina, ao re-chamar página, botoes e Planilha não re-aparecem
				 */	    	
				BtnAdicionar = null;
				BtnEditar = null;
				BtnSalvar = null;
				BtnSair = null;
				Planilha = null;	
				objDef.fixeStatusJanela(false);	// Informa que janela fechada(liberar botões do menu principal)
				
			}
		    
		    public void CarregarRegistros(){
		    	
		    	/*
		    	 * Teste de carga da Planilha de Class.MySQL->DlgNegocios
		    	 * Os dados não retornam, Verificar....
		    	 */
		    	
		    	objLog.Metodo("DlgNegocios().CarregarRegistros()");
		    	
		    //	MySQL objMySQL = new MySQL();	   
		    	
		    	//String[][] Registros = objMySQL.ConsultaMySQL();
		    	
		    	objLog.Metodo("DlgNegocios().CarregarRegistros() -> Imprimindo registros...");
		    	
		    	
		    	for(int iLin=1; iLin <= 2; iLin++){
			    	//for(int iCol=0; iCol <= 10; iCol++){
			    		//objLog.Metodo(Integer.toString( objMySQL.Teste()[iCol][iLin]) );
			    		//objLog.Metodo("DlgNegocios().CarregarRegistros()-> Reg: " +  objMySQL.ConsultaMySQL()[iCol][iLin]);
			    		//Planilha.setValueAt("\\//" + Registros[iCol][iLin], iLin, iCol);    // Valor, Lin, Col
		    			/*
			    		JOptionPane.showMessageDialog(null, "REGs:");
			    		JOptionPane.showMessageDialog(null, "REGs:["
								+ objMySQL.ConsultaMySQL()[0][iLin] +", "
								+ objMySQL.ConsultaMySQL()[1][iLin] +", "
								+ objMySQL.ConsultaMySQL()[2][iLin] +", "
								+ objMySQL.ConsultaMySQL()[3][iLin] +", "
								+ objMySQL.ConsultaMySQL()[4][iLin] +", "
								+ objMySQL.ConsultaMySQL()[5][iLin] +", "
								+ objMySQL.ConsultaMySQL()[6][iLin] +", "
								+ objMySQL.ConsultaMySQL()[7][iLin] +", "
								+ objMySQL.ConsultaMySQL()[8][iLin] +"]"); 
			    		
			    	//}
			    	 * */
			    	 
		    	}
		    	
		    	
		    	//objLog.Metodo(Integer.toString( objMySQL.Teste()[0][1]) );
		    	
		    	
		    }
		    
		    /*
		    // CTRL informe de status janela
		    static private boolean bStatusJanela = false;
		    
		    public void fixeStatusJanela(boolean bJanela){ 	bStatusJanela = bJanela; }
		    public boolean pegueStatusJanela(){ return bStatusJanela; }
		    */
		 
		/***********************************************************************************************/   
		public void ConstruirBfAddNegocio(boolean bMostrar){
			
			objLog.Metodo("jxTMain().ConstruirBfAddNegocio()");				
			
			JToolBar BfSeparador = new JToolBar(); 
		
			BfSeparador.setFloatable(false);	 
			BfSeparador.setRollover(false);		
		
			BfAddNegocio.setFloatable(false);	 
			BfAddNegocio.setRollover(true);
			
			JSeparator SeparaBfAddLin = new JSeparator();
			SeparaBfAddLin.setOrientation(SwingConstants.VERTICAL);
			BfAddNegocio.add(SeparaBfAddLin);
		
			AddPainel(BfAddNegocio, objPosicao.FrmNegocioBfAddCol, objPosicao.FrmNegocioBfAddLin, objPosicao.FrmNegocioBfAddLarg, objPosicao.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)					
			BfAddNegocio.add(cbCodEmpresa);	// GGBR4, PETR4, BRF4		
			BfAddNegocio.add(tfDataCP);	
			BfAddNegocio.add(cbTimeCpM15);	// 10:00:00, 10:15:00
			BfAddNegocio.add(tfValorCP);		// Preço de abertura	
			BfAddNegocio.add(tfCotasCP);		// Pr.Max	
			BfAddNegocio.add(tfCorretagem);		// Pr.Min
			BfAddNegocio.add(cbAlvo);			// Pr.Min
			BfAddNegocio.add(cbRiscoGanho);		// Pr.Min
			BfAddNegocio.add(cbStopLoss);		// Pr.Min
			
			// Criar rotina para adicionar - Empresa via arq.ini, txt, ou ler de mysql
			cbCodEmpresa.addItem("Empresa");	// Adicona Combo na BFerramentas
			cbCodEmpresa.addItem("BBS3");	// Adicona Combo na BFerramentas
			cbCodEmpresa.addItem("CMIG4");	// Adicona Combo na BFerramentas
			cbCodEmpresa.addItem("CPLE3");	// Adicona Combo na BFerramentas
			cbCodEmpresa.addItem("CSNA3");	// Adicona Combo na BFerramentas		
			cbCodEmpresa.addItem("GGBR4");	// Adicona Combo na BFerramentas
			cbCodEmpresa.addItem("GOAUL4");	// Adicona Combo na BFerramentas
			cbCodEmpresa.addItem("OIBR4");	// Adicona Combo na BFerramentas
			cbCodEmpresa.addItem("PETR4");	// Adicona Combo na BFerramentas
			cbCodEmpresa.addItem("TRPL4");	// Adicona Combo na BFerramentas
			cbCodEmpresa.addItem("UNIP6");	// Adicona Combo na BFerramentas
			cbCodEmpresa.addItem("USIM5");	// Adicona Combo na BFerramentas
			cbCodEmpresa.addItem("VALE3");	// Adicona Combo na BFerramentas
			
			cbCodEmpresa.setToolTipText("Código do ativo");	// Dica flutuante
		
			tfDataCP.setText(Formatar.format(data));
			
			// Rotina para criar lista de Minutos de 15em15
			cbTimeCpM15.addItem("Hora");	// Titulo - 1° item		
			String sHr, sHr1, sHr2, sHr3, sHr4 ="";
			for(int iH = 10; iH <= 18; iH++){ 
				sHr = String.valueOf(iH);
				sHr1 = sHr + ":00:00";
				sHr2 = sHr + ":15:00";
				sHr3 = sHr + ":30:00";
				sHr4 = sHr + ":45:00";
				
				// Adiciona Time´s na combo
				cbTimeCpM15.addItem(sHr1);
				cbTimeCpM15.addItem(sHr2);
				cbTimeCpM15.addItem(sHr3);
				cbTimeCpM15.addItem(sHr4);
				
			}	
				
			cbTimeCpM15.setToolTipText("Hora da compra");
			cbTimeCpM15.setCursor(new Cursor(Cursor.HAND_CURSOR));
			
			BfAddNegocio.setVisible(bMostrar);	// Esconde B.Ferramentas			
					
			/******************************************/
			tfDataCP.setColumns(10);			
			tfDataCP.setSize(10, 20);	
			tfDataCP.setToolTipText("Data da compra");	
			/******************************************/
			tfValorCP.setColumns(10);			
			tfValorCP.setSize(10, 20);		
			tfValorCP.setToolTipText("Valor da cota na compra");	// Pr.abertura
			/******************************************/
			tfCotasCP.setColumns(10);			
			tfCotasCP.setSize(10, 20);		
			tfCotasCP.setToolTipText("N.Cotas compradas");	// Pr.max
			/******************************************/
			tfCorretagem.setColumns(10);			
			tfCorretagem.setSize(10, 20);
			tfCorretagem.setText("2.49");	// Valor de corretagem cobrado pela Modal(hj)
			tfCorretagem.setToolTipText("Valor da corretagem");	// Preço
			/******************************************/
			cbAlvo.addItem("Alvo(%)");	// Adicona Combo na BFerramentas	
			cbAlvo.addItem("1.00");	// Adicona Combo na BFerramentas	
			cbAlvo.addItem("1.50");	// Adicona Combo na BFerramentas	
			cbAlvo.addItem("2.00");	// Adicona Combo na BFerramentas	
			cbAlvo.addItem("2.50");	// Adicona Combo na BFerramentas	
			cbAlvo.addItem("3.00");	// Adicona Combo na BFerramentas	
			cbAlvo.addItem("3.50");	// Adicona Combo na BFerramentas	
			cbAlvo.addItem("4.00");	// Adicona Combo na BFerramentas	
			cbAlvo.addItem("5.00");	// Adicona Combo na BFerramentas	
			cbAlvo.addItem("7.50");	// Adicona Combo na BFerramentas	
			cbAlvo.addItem("10.00");	// Adicona Combo na BFerramentas	
			
			cbAlvo.setToolTipText("Alvo(%) a ser alcançado");	// Dica flutuante
			
			cbRiscoGanho.addItem("Risco/Gn");
			cbRiscoGanho.addItem("1:1");
			cbRiscoGanho.addItem("1:2");
			cbRiscoGanho.addItem("1:3");
			cbRiscoGanho.addItem("1:4");
			cbRiscoGanho.addItem("1:5");
			cbRiscoGanho.addItem("1:7");
			cbRiscoGanho.addItem("1:10");
			 
			cbRiscoGanho.setToolTipText("Risco x Ganho na operação");	// Dica flutuante
			
			cbStopLoss.addItem("S.Loss(%)");
			cbStopLoss.addItem("1.00");
			cbStopLoss.addItem("1.30");
			cbStopLoss.addItem("1.50");
			cbStopLoss.addItem("1.70");
			cbStopLoss.addItem("2.00");
			cbStopLoss.addItem("2.50");
			cbStopLoss.addItem("3.00");
			cbStopLoss.addItem("4.00");
			cbStopLoss.addItem("5.00");
			cbStopLoss.addItem("7.00");
			cbStopLoss.addItem("10.00");
			cbStopLoss.setToolTipText("Risco x Ganho na operação");	// Dica flutuante
			
			
			// Botões: Add, Limpar 
			JButton BtnAddNegocio = new JButton();	// Cria Botão
			BfAddNegocio.add(BtnAddNegocio);			// Adiciona Botão ao Painel	
			BtnAddNegocio.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnAddLinha16.png"));
			BtnAddNegocio.setText("Adicionar");
			BtnAddNegocio.setCursor(new Cursor(Cursor.HAND_CURSOR));
			BtnAddNegocio.setToolTipText("Inserir cotação");
			BtnAddNegocio.setHideActionText(true);
			 
			JButton BtnLimpar = new JButton();	// Cria Botão
			BfAddNegocio.add(BtnLimpar);	// Adiciona Botão ao Painel
			BtnLimpar.setIcon(new javax.swing.ImageIcon(objDef.DirRoot + "imagens/Icon_btn/BtnLimpar16.png"));
			BtnLimpar.setCursor(new Cursor(Cursor.HAND_CURSOR));
			BtnLimpar.setToolTipText("Limpar planilha");
			BtnLimpar.setHideActionText(true);
			
			AddPainel(BfSeparador, objPosicao.FrmNegocioBfAddCol + objPosicao.FrmNegocioBfAddLarg, objPosicao.FrmNegocioBfAddLin, objPosicao.FrmNegocioBfAddLarg, objPosicao.iAltPadraoBF); // (iCol , iLin, iLarg, iAlt)					
			
			BfAddNegocio.setVisible(bMostrar);
			
			// Ouvir eventos - Combos
		    cbCodEmpresa.addActionListener(new java.awt.event.ActionListener() {  
		        public void actionPerformed(java.awt.event.ActionEvent evt) {  
		            cbCodEmpresaActionPerformed(evt);  
		        }  
		    });  
		    cbTimeCpM15.addActionListener(new java.awt.event.ActionListener() {  
		        public void actionPerformed(java.awt.event.ActionEvent evt) {  
		            cbTimeCpM15ActionPerformed(evt);  
		        }  
		    });  
		    
		    
			// Ouvir Eventos - Botões
		    BtnAddNegocio.addActionListener(new java.awt.event.ActionListener() {
		        public void actionPerformed(java.awt.event.ActionEvent evt) {
		        	BtnAddNegocioActionPerformed(evt);
		        }
		    });
		    BtnLimpar.addActionListener(new java.awt.event.ActionListener() {
		        public void actionPerformed(java.awt.event.ActionEvent evt) {
		        	BtnLimparActionPerformed(evt);
		        }
		    });
		    
			
			
		} // final do metodo BfAddNegocio
		
		// Pegar eventos
		private void cbCodEmpresaActionPerformed(java.awt.event.ActionEvent evt) {  
		     int indiceDoCombo = cbCodEmpresa.getSelectedIndex();  
		     objDef.fixeComboCodEmpresa(indiceDoCombo);  
		} 
		private void cbTimeCpM15ActionPerformed(java.awt.event.ActionEvent evt) {  
		     int indiceDoCombo = cbTimeCpM15.getSelectedIndex();  
		     objDef.fixeComboTimeM15(indiceDoCombo);  
		} 
		private void cbAlvoActionPerformed(java.awt.event.ActionEvent evt) {  
		     int indiceDoCombo = cbAlvo.getSelectedIndex();  
		     objDef.fixeComboAlvo(indiceDoCombo);  
		} 
		private void cbRiscoGanhoActionPerformed(java.awt.event.ActionEvent evt) {  
		     int indiceDoCombo = cbRiscoGanho.getSelectedIndex();  
		     objDef.fixeComboRiscoGanho(indiceDoCombo);  
		} 
		private void cbStopLossActionPerformed(java.awt.event.ActionEvent evt) {  
		     int indiceDoCombo = cbStopLoss.getSelectedIndex();  
		     objDef.fixeComboStopLoss(indiceDoCombo);  
		} 	
		
		private void BtnAddNegocioActionPerformed(java.awt.event.ActionEvent evt) {
		 	
			this.AddRegistro();
		}
		
		private void BtnLimparActionPerformed(java.awt.event.ActionEvent evt) {
			/*
			int iTReg = objUtil.ContarReg(Planilha);	// Conta numero de registros na tabela
			objDef.fixeNumRegMetaTrader(iTReg);
			
			if( iTReg > 1){							// Verifica NumReg	            				    
				  if(objCxMsg.Confirme("Apagar todos os registros da tabela?", objDef.bMsgExcluir)){
					 // objUtil.LimparPlanilha(Planilha);
					  //LimparItensFiltro("Filtrar campos...");
					  LimparPlanilha(objDef.pegueNumRegNegocios());
					  objDef.fixeNumRegMetaTrader(0);	// Limpou....zera info
				  }
		 	}else{ objCxMsg.Aviso("Não há registros a serem excluidos.", true); }
		
		
			/*
			int iTReg = objUtil.ContarReg(Planilha);	// Conta numero de registros na tabela
					
			if( iTReg > 1){							// Verifica NumReg
		
				if(objCxMsg.Confirme("Apagar todos os dados da tabela?", objDef.bMsgExcluir) )
				{
					
				//	objUtil.LimparPlanilha(Planilha);			
					LimparItensFiltro("Filtrar campos...");
					objDef.fixeNumRegMetaTrader(0);	// Limpou...zera info
					
				}
			}else{ objCxMsg.Aviso("Não há registros a serem excluidos.", true); }
			*/
			
			
		}
		    

	private void AddRegistro(){
	// Adiciona registro ao final da Planilha
		
			
		objLog.Metodo("AddRegistro(" + objDef.pegueNumRegNegocios()+")" );
		/// Calcular valores
		
		float fValorCP = Float.parseFloat(tfValorCP.getText());
		float fCotasCP = Float.parseFloat(tfCotasCP.getText());
		objLog.Metodo("AddRegistro.fValorCP("+String.valueOf(fValorCP)+")");
		objLog.Metodo("AddRegistro.fCotasCP("+String.valueOf(fCotasCP)+")");
		
		float fTotParcial = fValorCP * fCotasCP;
		String sTotParcial =  String.format("%.2f",fTotParcial);
		objLog.Metodo("AddRegistro.dTotalParcial("+sTotParcial+")");
		
		float fEmlCP = (fTotParcial * objDef.fEml)/100;
		//String sEmlCP = String.valueOf(fEmlCP).toString(); 
		String sEmlCP = String.format("%.2f", fEmlCP);	
		objLog.Metodo("AddRegistro.dEmlCP("+sEmlCP+")");	
		
		float fIssCP = (fTotParcial * objDef.fISS)/100;
		String sIssCP =  String.format("%.2f",fIssCP);
		objLog.Metodo("AddRegistro.dIssCP("+sIssCP+")");

		float fSubTotal = fTotParcial + fEmlCP + fIssCP; 
		String sSubTotCP =  String.format("%.2f",fSubTotal);
		objLog.Metodo("AddRegistro.dSubTotal("+sSubTotCP+")");
		
		// Alvo que pretendo alcançar, quanto(%) pretendo ganhar na operação
		float fCbAlvo = Float.parseFloat(cbAlvo.getSelectedItem().toString());			
		float fAlvo = fValorCP + ((fValorCP * fCbAlvo)/100);
		String sAlvo =  String.format("%.2f",fAlvo);
		objLog.Metodo("AddRegistro.dAlvo.("+sAlvo+")");
		
		/*
		 *  Calcula o valor do stop de perda em relação ao Alvo 
		 *  Alvo: +3%, Risco/Ganho(1:3) = 1% : 3% 
		 *  ou seja, para ganhar 3% aceito perder 1%(stop-loss)
		 *  Aqui é pego o cbAlvo/Ganho = 4% / 3(r1:3g)
		 *  Geralmente o Stop-loss deve ser colocado abaixo do Suporte
		 */
		String sRiscoGn = cbRiscoGanho.getSelectedItem().toString();
		String sGanho = sRiscoGn.substring(2,3);	// pega valor 3 de 1:3
		float fStopRiscoGn = fValorCP - (((fCbAlvo / Float.parseFloat(sGanho))*fValorCP)/100);	
		String sStopRiscoGn =  String.format("%.2f",fStopRiscoGn);
		objLog.Metodo("AddRegistro.dAlvo.("+sStopRiscoGn+")");
		
		/*
		 * Calculo do Stop Loss 
		 * E uma redundância do Risco/Ganho, mas aqui é cálculo direto de % de perda aceitável
		 *  
		 */
		String sStopL = cbStopLoss.getSelectedItem().toString();
		
		float fStopLoss = fValorCP - ((Float.parseFloat(sStopL)*fValorCP)/100);	
		String sStopLoss =  String.format("%.2f",fStopLoss);
		objLog.Metodo("AddRegistro.dAlvo.("+sStopLoss+")");

		
		Planilha.setValueAt(cbCodEmpresa.getSelectedItem().toString(), objDef.pegueNumRegNegocios(), objDef.colEMPRESA_TabNeg);
		Planilha.setValueAt(tfValorCP.getText().toString(), objDef.pegueNumRegNegocios(), objDef.colValorCP_TabNeg);
		Planilha.setValueAt(tfCotasCP.getText().toString(), objDef.pegueNumRegNegocios(), objDef.colCotasCP_TabNeg);
		Planilha.setValueAt(tfCorretagem.getText().toString(), objDef.pegueNumRegNegocios(), objDef.colCorretagemCP_TabNeg);
		Planilha.setValueAt(sEmlCP, objDef.pegueNumRegNegocios(), objDef.colEmlCP_TabNeg);
		Planilha.setValueAt(sIssCP, objDef.pegueNumRegNegocios(), objDef.colIssCP_TabNeg);
		Planilha.setValueAt(sSubTotCP, objDef.pegueNumRegNegocios(), objDef.colSTotalCP_TabNeg);
		Planilha.setValueAt(tfDataCP.getText().toString(), objDef.pegueNumRegNegocios(), objDef.colDataCP_TabNeg);
		Planilha.setValueAt(cbTimeCpM15.getSelectedItem().toString(), objDef.pegueNumRegNegocios(), objDef.colHoraCP_TabNeg);
		
		Planilha.setValueAt(sAlvo, objDef.pegueNumRegNegocios(), objDef.colAlvo_TabNeg);
		Planilha.setValueAt(sStopRiscoGn, objDef.pegueNumRegNegocios(), objDef.colStop_TabNeg);
		Planilha.setValueAt(sStopLoss, objDef.pegueNumRegNegocios(), objDef.colSLoss_TabNeg);
				
		Planilha.setRowSelectionInterval(0,  objDef.pegueNumRegNegocios());	// Seleciona a linha adicionada
		Planilha.requestFocus();							// Requsita Focus
		Planilha.changeSelection( objDef.pegueNumRegNegocios(),0,false, false);	// Pula para linha adicionada
		objDef.fixeSaltarFinalTab(true); 			// Informa que NÃO esta saltado(tá na linha 1) 

		objDef.IncNumRegNegocios();

		
		
		
	}

		    /******************************************************************************************************/

		/*
		    public static void main( String[] args )
		    {        
		      
		    	
		    	new DlgNegocios().Construir();;
				FrmClientes.setVisible(true);			// Mostra FrmClientes - Executar aqui pois dentro da função construir, da uns bugs
			

		    } 
		*/	
		    

		} // Final da Classe

