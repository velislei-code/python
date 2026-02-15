
import java.awt.Color;
import java.awt.Component;
import java.awt.Cursor;
import java.awt.Image;
import java.awt.Toolkit;
import java.io.File;
import java.io.IOException;

import javax.swing.BorderFactory;
import javax.swing.JButton;
import javax.swing.JCheckBox;
import javax.swing.JComboBox;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JTable;
import javax.swing.JTextField;
import javax.swing.SwingConstants;

import com.nikhaldimann.inieditor.IniEditor;

import jxl.Cell;
import jxl.Sheet;
import jxl.Workbook;
import jxl.read.biff.BiffException;

/*
 * Constroi um formulário de opções - Novo projeto
 * 
 * ATENÇÃO! ESTA CLASS ESTA PARCIALMENTE BLOQUEADA !
 * 
 */
public class FormOpcProjeto{	
				
	private Log objLog = new Log();
	private Definicoes objDef = new Definicoes();
	private CxDialogo objCxD = new CxDialogo();
	private Ferramentas objUtil = new Ferramentas();
	
    private static JPanel Painel     = new JPanel();
    private static JFrame FrmOpcao = new JFrame();
    private static JPanel pnOpcoes = new JPanel();
    private static JPanel pnOpcGerarLista = new JPanel();
    private static JPanel pnModem = new JPanel();
    private static JPanel pnProjeto = new JPanel();
    
    /*
     * Informa se Plan *.xls foi carregada
     */
    static boolean bPlanXls = false;
    public void FixePlanXls(boolean bP){ bPlanXls = bP; }
    public boolean PeguePlanXls(){ return bPlanXls; }
 
    private String sMemPlanAtual = "";		// usado para memorizar Planilha corrente(Comparar em casos de mudança)
    // Opções do projeto
    public final JTextField tfPrjNome = new JTextField("PrjTeste1"); // new RenderTextoGost("Nome do projeto        [PrjTst_Pgosm1.mta]");
    public JTextField tfImportarLista = new JTextField();    
    private JTable jTabTransportadaMtaView = new JTable();			// Transporta Tabela(mtaView->CxOpcoes) devido metodo this.CarregarExcel
    
    private JCheckBox cbEditarLista = new JCheckBox("Editar lista"); 
    private JCheckBox cbGerarLista = new JCheckBox("Gerar lista");
    private JCheckBox cbImportarLista = new JCheckBox("Importar lista");
    
    // Definições de sistema
    private JCheckBox cbSimular = new JCheckBox("Simular mtaBox");
    final JTextField tfIpPadrao = new JTextField(objDef.sIP[0]);
    final JTextField tfMaskPadrao = new JTextField(objDef.sMask);
    final JTextField tfLoginPadrao = new JTextField(objDef.sLogin);
    final JTextField tfSenhaPadrao = new JTextField(objDef.sSenha);    
    final JTextField tfPortaPadrao = new JTextField(objDef.iPorta);
    JComboBox cbNumModens  = new JComboBox(); 
    
    // Testes
    private JLabel lblTempo = new JLabel();
    private JComboBox cbTempo  = new JComboBox();
    private int iTempoTst = 3;					// Armazena valor da combo   
    private JLabel lblIntervalo = new JLabel();
    private JComboBox cbIntervalo  = new JComboBox();
    private JLabel lblURL = new JLabel();
    final JTextField tfURL = new JTextField(objDef.sURLteste);     
    
  
    // Inicializa classe
    FormOpcProjeto(){
	  
    }
    
    public void Construir(JTable jTabTransportada)
    {        

    	jTabTransportadaMtaView = jTabTransportada;		// Repassa valores de Tabela mtaView para Tablea CxOpçoes 
        //FrmOpcao.setDefaultCloseOperation( /* Salvar */ );        
        FrmOpcao.setTitle( "mtaView - Novo projeto" );                 
        FrmOpcao.setSize(750, 400);             
        FrmOpcao.setLocationRelativeTo(null);    
             
        
        // Icone do Form
    	 String stIcon = objDef.DirRoot + "/imagens/placa2.png";		// Dir ico    
        Image icon = Toolkit.getDefaultToolkit().getImage(stIcon);	// carrega Icon - não esta carreganfo
        this.setIconImage(icon);
    	FrmOpcao.setIconImage(icon);
        
        Painel.setLayout(null);         //--[ DESLIGANDO O GERENCIADOR DE LAYOUT ]--\\
        FrmOpcao.add( Painel );   
        
        JLabel lblNome = new JLabel("Nome");
               
        this.Adiciona(lblNome, 10, 10, 50, 25);
        this.Adiciona(tfPrjNome, 60, 10, 300, 25);
        
        this.ConstruirPnOpcoes();
        this.ConstruirPnProjeto();
   //     this.ConstruirPnModem(); ATENÇÃO! ESTA CLASS ESTA PARCIALMENTE BLOQUEADA !
        
       
        FrmOpcao.setVisible( true );
        
        
        // Memoriza path, Planilha Atual(P/ comparar alterações - nova carga de arquivo)
		sMemPlanAtual = tfImportarLista.getText();	
		
	 	JButton BtnOK = new JButton("OK");
	        this.Adiciona(BtnOK, 250, 320, 100, 25);			// Col, Lin, Larg, Alt
	        BtnOK.setCursor(new Cursor(Cursor.HAND_CURSOR));
	        BtnOK.setToolTipText("OK");
	        
        JButton BtnCancel = new JButton("Cancelar");
	        this.Adiciona(BtnCancel, 350, 320, 100, 25);		// Col, Lin, Larg, Alt
	        BtnCancel.setCursor(new Cursor(Cursor.HAND_CURSOR));
	        BtnCancel.setToolTipText("Cancelar");

		BtnOK.addActionListener(new java.awt.event.ActionListener() {
	            public void actionPerformed(java.awt.event.ActionEvent evt) {
	            	BtnOKActionPerformed(evt);
	            }
	    });
        BtnCancel.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
            	BtnCancelActionPerformed(evt);
            }
        });
    	
        /*
         * Lerconfig esta travando botoes...????
         *
     	try{
  		   	this.LerConfig();		// Carrega config de usuário
  	    } catch (IOException ex) {  
  	   	 	objCxD.Aviso("Erro ao carregar arquivo de configuração, " + ex, objDef.bMsgErro);  
  	    } finally{
  	   	
  	    }
     	*/
    }

    private void setIconImage(Image icon) {
		// TODO Auto-generated method stub
		
	}
 
	private void BtnOKActionPerformed(java.awt.event.ActionEvent evt) {	

		boolean bCarregarTab = false;	
		objLog.Metodo("BtnOK()");
		//-------------------------------------------------------------------------
		// Apagar registros anteriores
		int iTReg = objUtil.ContarReg(jTabTransportadaMtaView);	// Conta numero de registros na tabela

		// Verifica NumReg, se registros > 1
		if( iTReg > 1){			
			
				// Pede confirmação (confirme = Sim)
				if( objCxD.Confirme("Substituir dados da tabela? ", objDef.bMsgSalvar) )
				{
					objLog.Metodo("BtnOK().001b");
					
					objUtil.LimparTabela(jTabTransportadaMtaView);								
					bCarregarTab = true;	
					FixePlanXls(true);		// Informa que *.xls foi carregada
							
				}else{
					objLog.Metodo("BtnOK().002a");
					bCarregarTab = false; 	
				}
				
			}
			

    	if(bCarregarTab){
		
    		
    		if(cbImportarLista.isSelected()){
    			objLog.Metodo("BtnOK().004c");
    			DispararCargaExcel(jTabTransportadaMtaView, tfImportarLista.getText());    			
    		}
    	
    		if(cbEditarLista.isSelected()){  		
    		}
    	
    		try {
    			this.SalvarConfigCrip();
    		}  catch (IOException ex2) {  
    			objLog.Metodo("mtaView().BtnImportar().Erro ao Salvar config.ini(IOException).");
    			objCxD.Aviso("Erro ao salvar config.ini(IOException)", objDef.bMsgErro);
    		}
    	}
    	
    	FrmOpcao.dispose();		// Fecha FrmOpcao
    	// Este metodo esta travando a re-exibição: this.Liberar();
    	
    }

    private void BtnCancelActionPerformed(java.awt.event.ActionEvent evt) {
    	FrmOpcao.dispose();		// Fecha formulario
    	//this.Liberar();
    	
    }
    //--[ FUNCAO PARA ADICIONAR COMPONENTES NO PAINEL DO FrmOpcao ]--\\
    private static void Adiciona(Component Componente, int iColIni, int iLinIni, int iLargura, int iAltura)  
    {
        Painel.add(Componente);                      
        Componente.setBounds(iColIni, iLinIni, iLargura, iAltura);
    }
    private static void AddPnOpc(Component Componente, int iColIni, int iLinIni, int iLargura, int iAltura)  
    {
    	pnOpcoes.add(Componente);                      
        Componente.setBounds(iColIni, iLinIni, iLargura, iAltura);
    } 
    private static void AddPnProjeto(Component Componente, int iColIni, int iLinIni, int iLargura, int iAltura)  
    {
    	pnProjeto.add(Componente);                      
        Componente.setBounds(iColIni, iLinIni, iLargura, iAltura);
    } 
    private static void AddPnModem(Component Componente, int iColIni, int iLinIni, int iLargura, int iAltura)  
    {
    	pnModem.add(Componente);                      
        Componente.setBounds(iColIni, iLinIni, iLargura, iAltura);
    }    

    public void ConstruirPnProjeto(){
        //---------------------------------------------------------------------
        // Desenhar painel de opções
        pnProjeto.setBorder(BorderFactory.createLineBorder(Color.black));
        pnProjeto.setLayout(null); 
        this.Adiciona(pnProjeto, 10, 40, 350, 130);  // Col, Lin, Larg, Alt
           
        this.AddPnProjeto(cbEditarLista, 10, 20, 250, 25);
        this.AddPnProjeto(cbGerarLista, 10, 40, 250, 25);
        this.AddPnProjeto(cbImportarLista, 10, 60, 250, 25);
        this.AddPnProjeto(tfImportarLista, 10, 90, 320, 25);
        

        cbEditarLista.setCursor(new Cursor(Cursor.HAND_CURSOR));
        cbGerarLista.setCursor(new Cursor(Cursor.HAND_CURSOR));
        cbImportarLista.setCursor(new Cursor(Cursor.HAND_CURSOR));
        
        
        cbEditarLista.setToolTipText("Editar lista de portas");
        cbGerarLista.setToolTipText("Gerar lista de portas");
        cbImportarLista.setToolTipText("Importar lista de portas(*.xls)");
        tfImportarLista.setToolTipText("Nome do arquivo(*.xls)");
        
        
        
        cbEditarLista.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
            	cbEditarListaActionPerformed(evt);
            }
        });
        cbGerarLista.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
            	cbGerarListaActionPerformed(evt);
            }
        });
        cbImportarLista.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
            	cbImportarListaActionPerformed(evt);
            }
        });
        
      

        //---------------------------------------------------------------------
    }
    private void cbEditarListaActionPerformed(java.awt.event.ActionEvent evt) { 
    	cbEditarLista.setSelected(true);		// Marca Checkbox
		cbGerarLista.setSelected(false);		// Desmarca Checkbox
		cbImportarLista.setSelected(false);		// Desmarca Checkbox
		tfImportarLista.setEnabled(false);		// Desabilita Text-field
		FrmOpcao.dispose();
		new FormEditarLista().Construir(jTabTransportadaMtaView);  // Chama form Editar-Lista
		//Este metodo esta travando a re-exibição: this.Liberar();
		
    }
    private void cbGerarListaActionPerformed(java.awt.event.ActionEvent evt) { 
    	cbGerarLista.setSelected(true);		// Desmarca Checkbox
    	cbEditarLista.setSelected(false);		// Desmarca Checkbox
		cbImportarLista.setSelected(false);		// Desmarca Checkbox		
		tfImportarLista.setEnabled(false);		// Desabilita Text-field 
		FrmOpcao.dispose();
		new FormGerarLista().Construir(jTabTransportadaMtaView);  // Chama Form Gerar-Lista
		// Este metodo esta travando a re-exibição: this.Liberar();
		
    }
    private void cbImportarListaActionPerformed(java.awt.event.ActionEvent evt) {    	
    	
    	Arquivos objArquivo = new Arquivos();
    	
    	cbEditarLista.setSelected(false);		// Desmarca checkbox
		cbGerarLista.setSelected(false);		// Desmarca checkbox
		cbImportarLista.setSelected(true);		// Desmarca Checkbox		
		
		tfImportarLista.setEnabled(true);		// Habilita text-filed Importar-lista
		
		tfImportarLista.setText( objArquivo.DialogAbrir("xls") );	// Abre Cx-Dialogo, pega valor: Caminho-de-dir informado pelo usuário
		
		// Se retorno for nulo(Ação cancelada) - Desabilita
		if(tfImportarLista.getText().contains("Null")){
			cbImportarLista.setSelected(false);		// Desmarca Checkbox		
			tfImportarLista.setEnabled(false);		// Desabilita Text-field 
				
		}
		
		/*
		 * dispatch Event: expedição de evento
		 *  Zera/limpa(???) eventos da combo   
		 *  evitar disparos multiplos
		 *  Tava abrindo várias vezes o OpenDialog - com este cmd parou
		 */
		cbImportarLista.dispatchEvent(null);
    }
   

    
    public void ConstruirPnOpcoes(){
    /*
     * ATENÇÃO! ESTA CLASS ESTA PARCIALMENTE BLOQUEADA !
     *
        //---------------------------------------------------------------------
        // Desenhar painel de opções
        pnOpcoes.setBorder(BorderFactory.createLineBorder(Color.black));
        pnOpcoes.setLayout(null); 
        this.Adiciona(pnOpcoes, 10, 200, 350, 100);  // Col, Lin, Larg, Alt
        
        JLabel lblTempo = new JLabel("Tempo p/ sequência de teste(min)");
        JComboBox cbTempo  = new JComboBox();
        cbTempo.addItem(3);			// Padrão
        for(int iT=1; iT<=10; iT++){
        	cbTempo.addItem(iT);	
        }       
        cbTempo.setCursor(new Cursor(Cursor.HAND_CURSOR));       
        cbTempo.setToolTipText("Tempo da sequência de teste(min)");

        this.AddPnOpc(lblTempo, 10, 20, 200, 25);
        this.AddPnOpc(cbTempo, 280, 20, 50, 20);
        
        
        // Intervalo de consulta - padrão único 15 seg.
        JLabel lblIntervalo = new JLabel("Intervalo de consulta(seg)");
        JComboBox cbIntervalo  = new JComboBox();
        
        cbIntervalo.addItem(15);
        cbIntervalo.setCursor(new Cursor(Cursor.HAND_CURSOR));       
        cbIntervalo.setToolTipText("Intervalo de consulta(seg)");

        this.AddPnOpc(lblIntervalo, 10, 40, 150, 25);
        this.AddPnOpc(cbIntervalo, 280, 40, 50, 20);
        
        JLabel lblURL = new JLabel("URL de teste(ping)");
        
       
        this.AddPnOpc(lblURL, 10, 60, 120, 25);
        this.AddPnOpc(tfURL, 140, 65, 190, 20);  // Col, Lin, Larg, Alt
        
        // JButton BtnTestarURL = new JButton("Testar");
        // this.AddPnOpc(BtnTestarURL, 300, 65, 80, 20);  
        
        //---------------------------------------------------------------------
    }
    
   
    public void ConstruirPnModem(){
    	
    	int iAjusteLin = 10;
    	int iAjusteCol = 0;
    	
    	
    	
        //---------------------------------------------------------------------
        // Desenhar painel de opções
        pnModem.setBorder(BorderFactory.createLineBorder(Color.black));
        pnModem.setLayout(null); 
        this.Adiciona(pnModem, 400, 40, 300, 260);  // Col, Lin, Larg, Alt
     
        JLabel lblNumModens = new JLabel("Num de Modens");
        JLabel lblMaskPadrao = new JLabel("Mascara");
        JLabel lblIpPadrao = new JLabel("IP");
        JLabel lblSenhaPadrao = new JLabel("Senha");
        JLabel lblLoginPadrao = new JLabel("Login");
        JLabel lblPortaPadrao = new JLabel("Porta");
     
        
        cbNumModens.addItem( "4" );        
        cbNumModens.addItem( "8" ); 
        cbNumModens.addItem( "16" );
        cbNumModens.addItem( "32" );
        cbNumModens.addItem( "64" );
        cbNumModens.setCursor(new Cursor(Cursor.HAND_CURSOR));       
        cbNumModens.setToolTipText("Modens por mtaBox");

        
        tfIpPadrao.setText(objDef.sIP[0]);
        this.AddPnModem(lblIpPadrao, 10 + iAjusteCol, 20 + iAjusteLin, 100, 25);
        this.AddPnModem(tfIpPadrao, 120 + iAjusteCol, 20 + iAjusteLin, 150, 25);
        
        tfMaskPadrao.setText("255.255.255.0");
        this.AddPnModem(lblMaskPadrao, 10 + iAjusteCol, 50 + iAjusteLin, 100, 25);
        this.AddPnModem(tfMaskPadrao, 120 + iAjusteCol, 50 + iAjusteLin, 150, 25);
        
        tfLoginPadrao.setText(objDef.sLogin);
        this.AddPnModem(lblLoginPadrao, 10 + iAjusteCol, 80 + iAjusteLin, 100, 25);
        this.AddPnModem(tfLoginPadrao, 120 + iAjusteCol, 80 + iAjusteLin, 150, 25);
        
        tfSenhaPadrao.setText(objDef.sSenha);
        this.AddPnModem(lblSenhaPadrao, 10 + iAjusteCol, 110 + iAjusteLin, 100, 25);
        this.AddPnModem(tfSenhaPadrao, 120 + iAjusteCol, 110 + iAjusteLin, 150, 25);        
      
        tfPortaPadrao.setText(String.valueOf(objDef.iPorta));
        this.AddPnModem(lblPortaPadrao, 10 + iAjusteCol, 140 + iAjusteLin, 100, 25);
        this.AddPnModem(tfPortaPadrao, 120 + iAjusteCol, 140 + iAjusteLin, 150, 25);        
      
        
        this.AddPnModem(lblNumModens, 10, 170 + iAjusteLin, 100, 25);        
        this.AddPnModem(cbNumModens, 120, 170 + iAjusteLin, 50, 25);     
     
      //cbSimular.setEnabled(true);
      //  objDef.FixarSimulacao(true);
        objLog.Metodo("FormOpcProjeto().ConstruirPnModem(Simulação: " +  objDef.PegueSimulacao() + ")");
    	if( objDef.PegueSimulacao() ){ cbSimular.setSelected(true); }    	
        this.AddPnModem(cbSimular, 120, 200 + iAjusteLin, 150, 25); 
        cbSimular.setCursor(new Cursor(Cursor.HAND_CURSOR));       
        cbSimular.setToolTipText("Simular mtaBox");

        
          //---------------------------------------------------------------------
     */   
        
    }
 
     
    
    public void CarregarExcel(JTable Tabela, String sDir) throws BiffException, IOException
    {
    	
    	/* A rotina abaixo não funcionou em classe separada,
    	 * ocorreu alguma falha ao transferir valores p/ sCelulas[][].
    	 * então...ficou como método local
    	 * - throws BiffException, IOException: é exigido pela classe WorkBook, 
    	 * 		que também exige um tratamento de exceção(try, catch) ao chamar o método;  
    	 * PGO - 15jul2014  	 
    	 */
    	
    	Arquivos objArq = new Arquivos();     	
    	//String sDir = objArq.DialogAbrir("xls");			// Chama OpenDialog
    	
    	objLog.Metodo("FormOpcProjeto().this.CarregarExcel("+ sDir +")");
    	
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
            // 	NumerarLinhas 	// Numera linhas da Tabela
            //  Tabela.setValueAt( objDef.AcaoTestar, iL, objDef.colACAO);		// Numera linhas da Tabela
            
            
            // Cores: Listras(Linha-sim, linha não)
			for(int iC=1; iC < Tabela.getColumnCount(); iC++){
				Tabela.getColumnModel().getColumn(iC).setCellRenderer(new RenderListras());
			}
			
			
			int iTRegX = new Ferramentas().ContarReg(Tabela);	// Conta numero de registros na tabela			
			// Fixa Coluna Testes como: objDef.AcaoTestar
		 		
			/*
				for(int L=0; L <= iTRegX; L++){
		 			Tabela.setValueAt(objDef.AcaoTestar, L, objDef.colACAO);
		 		}
			*/
			// ModeloTab.addRow(objDef.sTabLinhas);			// Adiciona Linha a tabela
		  
        }  
       
      
        
    }  // this.CarregarExcel()
    
    
    
    private void cbTempoActionPerformed(java.awt.event.ActionEvent ePino) {  
	     int indiceDoCombo = cbTempo.getSelectedIndex();  
	     iTempoTst = Integer.parseInt( cbTempo.getSelectedItem().toString() );	     
	     objLog.Metodo("FormOpcProjeto().cbTempoActionPerformed("+ iTempoTst +")");
	} 	
    
    public void SalvarConfigCrip() throws IOException{
    	// Salva dados da Tabela em arquivo *.ini
    		
    	cbTempo.addActionListener(new java.awt.event.ActionListener() {  
     		public void actionPerformed(java.awt.event.ActionEvent evt) {  
     			cbTempoActionPerformed(evt);  
     		}  
     	});  
    	
    		objLog.Metodo("FormOpcProjeto().this.SalvarConfig()");
    		 objLog.Metodo("FormOpcProjeto().Tempo("+ iTempoTst +")");
    		
    		try { 
    			
    				String sDirArq = objDef.DirRoot + "config.ini";		// Chama SaveDialog, pega diretório				
    				String chCfgN= "Config";
    				String chCFG = objUtil.Criptografia(objDef.bEncrypt, chCfgN, objDef.sKeyCript);   // Criptografa
    				
    				String chPrjN = "Projeto";
    				String chPRJ = objUtil.Criptografia(objDef.bEncrypt, chPrjN, objDef.sKeyCript);   // Criptografa
    				
    				File fArquivo = new File(sDirArq);	        
    				if (!fArquivo.exists()) {	// Se o arquivo não existe...				
    					fArquivo.createNewFile();	//cria um arquivo(vazio)
    				}
    	        
    				IniEditor ArqIni = new IniEditor(true);
    				ArqIni.load(fArquivo);
    				
    				ArqIni.addSection(chCFG);
    					
    				
    				ArqIni.set(chCFG, objUtil.Criptografia(objDef.bEncrypt,"Gt", objDef.sKeyCript), String.valueOf( objUtil.Criptografia(objDef.bEncrypt, tfIpPadrao.getText(), objDef.sKeyCript) ) );
    				ArqIni.set(chCFG, objUtil.Criptografia(objDef.bEncrypt,"Mask",objDef.sKeyCript), String.valueOf( objUtil.Criptografia(objDef.bEncrypt, tfMaskPadrao.getText(), objDef.sKeyCript) ) );
    				ArqIni.set(chCFG, objUtil.Criptografia(objDef.bEncrypt,"Lg",objDef.sKeyCript), String.valueOf( objUtil.Criptografia(objDef.bEncrypt, tfLoginPadrao.getText(), objDef.sKeyCript) ) );
    				ArqIni.set(chCFG, objUtil.Criptografia(objDef.bEncrypt,"Sn",objDef.sKeyCript), String.valueOf( objUtil.Criptografia(objDef.bEncrypt, tfSenhaPadrao.getText(), objDef.sKeyCript) ) );	
    				ArqIni.set(chCFG, objUtil.Criptografia(objDef.bEncrypt,"Porta",objDef.sKeyCript), String.valueOf( objUtil.Criptografia(objDef.bEncrypt, tfPortaPadrao.getText(), objDef.sKeyCript) ) );
    	    		ArqIni.set(chCFG, objUtil.Criptografia(objDef.bEncrypt,"TempoTst",objDef.sKeyCript), Integer.toString(iTempoTst) );    	    		
    				ArqIni.set(chCFG, objUtil.Criptografia(objDef.bEncrypt,"URLteste",objDef.sKeyCript), String.valueOf( objUtil.Criptografia(objDef.bEncrypt, tfURL.getText(), objDef.sKeyCript) ) );
    				ArqIni.set(chCFG, objUtil.Criptografia(objDef.bEncrypt,"Simulacao",objDef.sKeyCript), String.valueOf( cbSimular.isSelected() )  );
    			
    				
    				ArqIni.addSection(chPRJ);
    				// Não encript
    				objLog.Metodo("FormOpcPrj().this.SalvarConfigCript()->Prjpath: " + tfImportarLista.getText());
    				ArqIni.set(chPrjN, "PrjPath", String.valueOf( tfImportarLista.getText() ) );
    				ArqIni.set(chCfgN, "Simulacao", String.valueOf(cbSimular.isSelected()) );
    				
    				ArqIni.set(chPRJ, objUtil.Criptografia(objDef.bEncrypt, "PrjNome", objDef.sKeyCript),  String.valueOf( objUtil.Criptografia(objDef.bEncrypt, tfPrjNome.getText(), objDef.sKeyCript) ) );    				
    				ArqIni.set(chPRJ, objUtil.Criptografia(objDef.bEncrypt, "Editar", objDef.sKeyCript),  String.valueOf(  cbEditarLista.isSelected()) );
    				ArqIni.set(chPRJ, objUtil.Criptografia(objDef.bEncrypt, "Gerar", objDef.sKeyCript),  String.valueOf(cbGerarLista.isSelected()) );
    				ArqIni.set(chPRJ, objUtil.Criptografia(objDef.bEncrypt, "Importar", objDef.sKeyCript),  String.valueOf(cbImportarLista.isSelected()) );    				
    				ArqIni.set(chPRJ, objUtil.Criptografia(objDef.bEncrypt, "PrjPath", objDef.sKeyCript),  String.valueOf( objUtil.Criptografia(objDef.bEncrypt, tfImportarLista.getText(), objDef.sKeyCript) ) );
    				
    				
    				ArqIni.save(fArquivo);	    	
    				//objCxD.Aviso("Arquivo salvo em: " + sDirArq, objDef.bMsgSalvar);
    				objLog.Metodo("mtaView().this.SalvarConfig(), T: " + objDef.iTempoTeste+", Txt: " + objDef.iTamTexto +", Z: " + objDef.bZoom +", Sml: " + objDef.bSimulacao);
    				
    	     } catch (IOException ex) {  
    	    	 objCxD.Aviso("Erro ao criar arquivo, " + ex, objDef.bMsgErro);  
    	     } finally{
    	    	
    	     }
    	}
    	
    
    public void LerConfig() throws IOException{
		
		objLog.Metodo("Arquivos().this.LerConfig()");

		String sChave ="Config";
		String sChavePrj ="Projeto";
		
		String sDirArq = objDef.DirRoot + "config.ini";		// Chama SaveDialog, pega diretório
		
			String ValorRetorno = null;
			File fArquivo = new File(sDirArq);
			IniEditor ArqIni = new IniEditor(true);
			ArqIni.load(fArquivo);

		
			// Lê total de linhas no arquivo(iL = XX)
			objDef.FixeTempoTeste( Integer.parseInt( ArqIni.get(sChave,"TempoTst") ));
			objDef.FixeSimulacao( Boolean.parseBoolean( ArqIni.get(sChave,"Simulacao") ) );
			objDef.FixeIP( String.valueOf( ArqIni.get(sChave,"Gt")) );	
			objDef.FixeMask( String.valueOf(ArqIni.get(sChave,"Mask") ) );
			objDef.FixeLogin( String.valueOf(ArqIni.get(sChave,"Lg") ) );
			objDef.FixeSenha( String.valueOf(ArqIni.get(sChave,"Sn") ) );
			objDef.FixePorta( Integer.parseInt(ArqIni.get(sChave,"Porta") ) );
			objDef.FixeURLteste( String.valueOf(ArqIni.get(sChave,"URLteste") ) );
			
			
			tfIpPadrao.setText(objDef.PegueIP(0));
			tfMaskPadrao.setText(objDef.PegueMask());
			tfLoginPadrao.setText(objDef.PegueLogin());
			tfSenhaPadrao.setText(objDef.PegueSenha());	
			tfPortaPadrao.setText(String.valueOf( objDef.PeguePorta() ));
    		iTempoTst = objDef.PegueTempoTeste();
			tfURL.setText(objDef.PegueURLteste());
			cbSimular.setSelected(objDef.PegueSimulacao());
			
			
			tfPrjNome.setText( String.valueOf(ArqIni.get(sChavePrj,"PrjNome") ) );
			cbEditarLista.setSelected( Boolean.parseBoolean( ArqIni.get(sChavePrj,"Editar") ) );
			cbGerarLista.setSelected( Boolean.parseBoolean( ArqIni.get(sChavePrj,"Gerar") ) );
			cbImportarLista.setSelected( Boolean.parseBoolean( ArqIni.get(sChavePrj,"Importar") ) ); 
			
			tfImportarLista.setText( String.valueOf(ArqIni.get(sChavePrj,"PrjPath") ) );
			

		
	}
 
    public void DispararCargaExcel(JTable Tabela, String sArquivo){
	
		try {		
			this.CarregarExcel(Tabela, sArquivo);  
	   			
		} catch (BiffException ex) {
			objLog.Metodo("mtaView().BtnImportar().Erro, arquivo inválido(BiffException).");
			objCxD.Aviso("Erro! Arquivo: " + sArquivo + " inválido.", objDef.bMsgErro); 
		} catch (IOException ex) {  
			objLog.Metodo("mtaView().BtnImportar().Erro ao carregar arquivo(IOException).");
			objCxD.Aviso("Erro! Não foi possível localizar o arquivo: " + sArquivo, objDef.bMsgErro);
		}
	}
    

    private void Liberar(){
    	/*
    	 * Liberar var´s da memoria
    	 * Mas...esta bloqueando re-exibição 
    	 */
    	objLog.Metodo("FormOpcProjeto().Liberar()");
    	
    	Painel = null;
        FrmOpcao = null;
        pnOpcoes = null;
        pnOpcGerarLista = null;
        pnModem = null;
        pnProjeto = null;
        jTabTransportadaMtaView = null;	      	
       	objLog = null;
   		objDef = null;
   		objCxD = null;
   		objUtil = null;
   		cbEditarLista = null; 
   		cbGerarLista = null;
   		cbImportarLista = null;
   		cbSimular = null;
   		cbNumModens  = null;
   		cbTempo  = null;
   		cbIntervalo  = null;
   		
   		
   	
		
    }
    
    
    /*
    public static void main(String[] args)
    {
    	new FormOpcProjeto().Construir(null);
    }
   */
    
}