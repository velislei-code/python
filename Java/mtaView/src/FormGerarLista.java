
import java.awt.Color;
import java.awt.Component;
import java.awt.Cursor;
import java.awt.Image;
import java.awt.Toolkit;
import java.io.File;
import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.Date;

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

import jxl.Cell;
import jxl.Sheet;
import jxl.Workbook;
import jxl.read.biff.BiffException;

/*
 * Constroi um formulário de opções - Novo projeto
 * 
 */
public class FormGerarLista{
	
	private Log objLog = new Log();
	private Definicoes objDef = new Definicoes();
	private CxDialogo objCxD = new CxDialogo();
	
    private static JPanel Painel     = new JPanel();
    private static JFrame Formulario = new JFrame();
    
    private Date data = new Date();  
	private SimpleDateFormat Formatar = new SimpleDateFormat("dd/MM/yyyy");
	
	private int iLinha = 0;
	private int iPino = 1;
	private int iHz = 1;

    
    // Opções do projeto
    final JTextField tfDslam = new RenderTextoGost("Nome do dslam");        
    JTable jTabTransportadaMtaView = new JTable();			// Transporta Tabela(mtaView->CxOpcoes) devido metodo carregarExcel
    
    //Slots
    private static JPanel pnSlot = new JPanel();
    JLabel lblSlot = new JLabel();
    JLabel lblTitPlaca = new JLabel("Placas");
    JCheckBox cbSlot0 = new JCheckBox("0"); 
    JCheckBox cbSlot1 = new JCheckBox("1");
    JCheckBox cbSlot2 = new JCheckBox("2");
    JCheckBox cbSlot3 = new JCheckBox("3");
    JCheckBox cbSlot4 = new JCheckBox("4");
    JCheckBox cbSlot5 = new JCheckBox("5");
    JCheckBox cbSlot6 = new JCheckBox("6");
    JCheckBox cbSlot7 = new JCheckBox("7");
    JCheckBox cbSlot8 = new JCheckBox("8");
    JCheckBox cbSlot9 = new JCheckBox("9");
    JCheckBox cbSlot10 = new JCheckBox("10");
    JCheckBox cbSlot11 = new JCheckBox("11");
    JCheckBox cbSlot12 = new JCheckBox("12");
    JCheckBox cbSlot13 = new JCheckBox("13");
    JCheckBox cbSlot14 = new JCheckBox("14");
    JCheckBox cbSlot15 = new JCheckBox("15");
    JCheckBox cbSlot16 = new JCheckBox("16");
    
    
    // Pinagens
    JLabel lblPlaca = new JLabel("Placa");
    JLabel lblBloco = new JLabel("Bloco");
    JLabel lblVt = new JLabel("Vt");
    JLabel lblHz = new JLabel("Hz");
    JLabel lblPino = new JLabel("Pino");
    
    JComboBox cbPlaca  = new JComboBox();
    JComboBox cbBloco  = new JComboBox();
    JComboBox cbVt  = new JComboBox();
    JComboBox cbHz  = new JComboBox();
    JComboBox cbPino  = new JComboBox();
    
   
    
    public void Construir(JTable jTabTransportada)
    {
    
    	jTabTransportadaMtaView = jTabTransportada;		// Repassa valores de Tabela mtaView para Tablea CxOpçoes                
     
        //Formulario.setDefaultCloseOperation( /* Salvar */ );        
        Formulario.setTitle("mtaView - Gerar lista");                 
        Formulario.setSize(450, 290);             
        Formulario.setLocationRelativeTo( null );    
        
        // Icone do Form
    	String stIcon = objDef.DirRoot + "/imagens/placa2.png";		// Dir ico    
        Image icon = Toolkit.getDefaultToolkit().getImage(stIcon);	// carrega Icon - não esta carreganfo
        this.setIconImage(icon);
    	Formulario.setIconImage(icon);
        
        Painel.setLayout(null);         //DESLIGANDO O GERENCIADOR DE LAYOUT
        Formulario.add( Painel );   
        
        JLabel lblNome = new JLabel("Dslam");
        this.Adiciona(lblNome, 10, 10, 70, 25);
        this.Adiciona(tfDslam, 80, 10, 230, 25);
        
        // Combo-portas
        //this.Adiciona(lblPlaca, 10, 190, 60, 25);
        this.Adiciona(cbPlaca, 10, 190, 60, 20);
        cbPlaca.setCursor(new Cursor(Cursor.HAND_CURSOR));
        cbPlaca.setToolTipText("Tipo de placa");
        cbPlaca.addItem("Placa");
        cbPlaca.addItem("1-12");
        cbPlaca.addItem("0-15");
        cbPlaca.addItem("1-16");
        cbPlaca.addItem("1-24");
        cbPlaca.addItem("0-31");
        cbPlaca.addItem("1-32");
        cbPlaca.addItem("1-48");
        cbPlaca.addItem("0-63");
        cbPlaca.addItem("1-64");
        cbPlaca.addItem("1-72");

        // Combo-bloco
        //this.Adiciona(lblBloco, 75, 190, 60, 25);
        this.Adiciona(cbBloco, 75, 190, 60, 20);
        cbBloco.setCursor(new Cursor(Cursor.HAND_CURSOR));
        cbBloco.setToolTipText("Tipo de bloco");
        cbBloco.addItem("Bloco");
        cbBloco.addItem("10");
        cbBloco.addItem("120");
        
        // Combo-Vertical
        //this.Adiciona(lblVt, 150, 190, 50, 25);
        this.Adiciona(cbVt, 150, 190, 50, 20);
        cbVt.addItem("Vt");
        cbVt.setCursor(new Cursor(Cursor.HAND_CURSOR));
        cbVt.setToolTipText("Vertical");
        
        // Combo-Hz
        //this.Adiciona(lblHz, 205, 190, 50, 25);
        this.Adiciona(cbHz, 205, 190, 50, 20);
        cbHz.addItem("Hz");
        cbHz.setCursor(new Cursor(Cursor.HAND_CURSOR));
        cbHz.setToolTipText("Horizontal");
        
        // Combo-Pino
        //this.Adiciona(lblPino, 260, 190, 50, 25);
        this.Adiciona(cbPino, 260, 190, 50, 20);
        cbPino.addItem("Pino");
        cbPino.setCursor(new Cursor(Cursor.HAND_CURSOR));
        cbPino.setToolTipText("Pino");
        
        for(int iA=1; iA<=120; iA++){
        	cbVt.addItem(iA);
            cbHz.addItem(iA);
            cbPino.addItem(iA);	
        }
        
        
        ConstruirPnProjeto();
       
        
        JButton BtnOK = new JButton("OK");
        this.Adiciona(BtnOK, 320, 10, 90, 25);
        BtnOK.setCursor(new Cursor(Cursor.HAND_CURSOR));
        BtnOK.setToolTipText("Gerar lista");
        
        JButton BtnLimpar = new JButton("Limpar");
        this.Adiciona(BtnLimpar, 320, 40, 90, 25);
        BtnLimpar.setCursor(new Cursor(Cursor.HAND_CURSOR));
        BtnLimpar.setToolTipText("Limpar tabela");
        
        JButton BtnCancel = new JButton("Cancelar");
        this.Adiciona(BtnCancel, 320, 70, 90, 25);
        BtnCancel.setCursor(new Cursor(Cursor.HAND_CURSOR));
        BtnCancel.setToolTipText("Cancelar");
        
        Formulario.setVisible( true );
    
        // Ouvie eventos dos botoes
        BtnOK.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
            	BtnOKActionPerformed(evt);
            }
        });
        BtnLimpar.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
            	BtnLimparActionPerformed(evt);
            }
        });
        BtnCancel.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
            	BtnCancelActionPerformed(evt);
            }
        });

        // Ouvi eventos das combos
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
        cbVt.addActionListener(new java.awt.event.ActionListener() {  
            public void actionPerformed(java.awt.event.ActionEvent evt) {  
                cbVtActionPerformed(evt);  
            }  
        });  
        cbHz.addActionListener(new java.awt.event.ActionListener() {  
            public void actionPerformed(java.awt.event.ActionEvent evt) {  
                cbHzActionPerformed(evt);  
            }  
        });  
        cbPino.addActionListener(new java.awt.event.ActionListener() {  
            public void actionPerformed(java.awt.event.ActionEvent evt) {  
                cbPinoActionPerformed(evt);  
            }  
        });  
    	 
    }

    private void setIconImage(Image icon) {
		// TODO Auto-generated method stub
		
	}

    // Click dos botoes
	private void BtnOKActionPerformed(java.awt.event.ActionEvent evt) { 
    	
		// Apagar registros anteriores
		int iTReg = new Ferramentas().ContarReg(jTabTransportadaMtaView);	// Conta numero de registros na tabela

		
		
		if(tfDslam.getText() != ""){
		if(this.CheckSlot()){
		if(!objDef.sCBoxPlaca.contains("c")){
		if(!objDef.sCBoxBloco.contains("c")){
		if(!objDef.sCBoxVt.contains("t")){			
		if(!objDef.sCBoxHz.contains("z")){
		if(!objDef.sCBoxPino.contains("n")){
				
		// Verifica NumReg, se registros > 1
		if( iTReg > 1){	

			// Pede confirmação (confirme = Sim)
			if( objCxD.Confirme("Substituir dados da tabela? ", objDef.bMsgSalvar) )
			{
				//objLog.Metodo("BtnOK.if.confirme.sParteArqAntigo[001e] ->"+sParteArqAntigo);
				this.LimparTabela(jTabTransportadaMtaView);
				this.GerarSeleciona(jTabTransportadaMtaView);
				this.ZerarCombos();
				Formulario.dispose();		// Fecha formulario

						
			}			
		}else{
			this.LimparTabela(jTabTransportadaMtaView);
			this.GerarSeleciona(jTabTransportadaMtaView);
			this.ZerarCombos();
			Formulario.dispose();		// Fecha formulario

		}
		
		}else{ objCxD.Aviso("Você deve informar o Pino.", true);}
		}else{ objCxD.Aviso("Você deve informar a Horizontal.", true);}
		}else{ objCxD.Aviso("Você deve informar a Vertical.", true);}
		}else{ objCxD.Aviso("Você deve informar o tipo de Bloco.", true);}
		}else{ objCxD.Aviso("Você deve informar o tipo de Placa.", true);}
		}else{ objCxD.Aviso("Você deve informar o Slot.", true);}
		}else{ objCxD.Aviso("Você deve informar o nome do Dslam.", true);}
		
		
		// Este metodo esta travando a re-exibição: this.Liberar();
    	
    }
	private void BtnLimparActionPerformed(java.awt.event.ActionEvent evt) {
    	
    	int iTReg = new Ferramentas().ContarReg(jTabTransportadaMtaView);	// Conta numero de registros na tabela
		if( iTReg > 1){							// Verifica NumReg
 	
			if(objCxD.Confirme("Apagar todos os dados da tabela?", objDef.bMsgExcluir) )
			{
				this.LimparTabela(jTabTransportadaMtaView);			
				//LimparItensFiltro("Filtrar campos...");
			}
		}else{ objCxD.Aviso("Não há registros a serem excluidos.", true); }
		
    }
    private void BtnCancelActionPerformed(java.awt.event.ActionEvent evt) {
    	
    	Formulario.dispose();		// Fecha formulario
    	// Este metodo esta travando a re-exibição: this.Liberar();
    }
    
    // Click das combos
    private void cbPlacaActionPerformed(java.awt.event.ActionEvent evt) {  
	     int indiceDoCombo = cbPlaca.getSelectedIndex();  
	     objDef.sCBoxPlaca = cbPlaca.getSelectedItem().toString();  
	} 
   private void cbBlocoActionPerformed(java.awt.event.ActionEvent evt) {  
	     int indiceDoCombo = cbBloco.getSelectedIndex();  
	     objDef.sCBoxBloco = cbBloco.getSelectedItem().toString();  
	} 
	private void cbVtActionPerformed(java.awt.event.ActionEvent evt) {  
	     int indiceDoCombo = cbVt.getSelectedIndex();  
	     objDef.sCBoxVt = cbVt.getSelectedItem().toString();  
	}  
	private void cbHzActionPerformed(java.awt.event.ActionEvent evt) {  
	     int indiceDoCombo = cbHz.getSelectedIndex();  
	     objDef.sCBoxHz = cbHz.getSelectedItem().toString();  
	}  
	private void cbPinoActionPerformed(java.awt.event.ActionEvent evt) {  
	     int indiceDoCombo = cbPino.getSelectedIndex();  
	     objDef.sCBoxPino = cbPino.getSelectedItem().toString();  
	}  
	

    public void ConstruirPnProjeto(){
        //---------------------------------------------------------------------
        // Desenhar painel de opções
        pnSlot.setBorder(BorderFactory.createLineBorder(Color.black));
        pnSlot.setLayout(null); 
        this.Adiciona(pnSlot, 10, 40, 300, 130);  // Col, Lin, Larg, Alt
           
        
        this.AddPnProjeto(lblTitPlaca, 10, 5, 40, 25);	// Col, Lin, Larg, Alt
        this.AddPnProjeto(cbSlot0, 10, 30, 50, 25);
        this.AddPnProjeto(cbSlot1, 10, 50, 50, 25);
        this.AddPnProjeto(cbSlot2, 10, 70, 50, 25);
        this.AddPnProjeto(cbSlot3, 10, 90, 50, 25);
        this.AddPnProjeto(cbSlot4, 70, 30, 50, 25);
        this.AddPnProjeto(cbSlot5, 70, 50, 50, 25);
        this.AddPnProjeto(cbSlot6, 70, 70, 50, 25);
        this.AddPnProjeto(cbSlot7, 70, 90, 50, 25);
        this.AddPnProjeto(cbSlot8, 120, 30, 50, 25);
        this.AddPnProjeto(cbSlot9, 120, 50, 50, 25);
        this.AddPnProjeto(cbSlot10, 120, 70, 50, 25);
        this.AddPnProjeto(cbSlot11, 120, 90, 50, 25);
        this.AddPnProjeto(cbSlot12, 170, 30, 50, 25);
        this.AddPnProjeto(cbSlot13, 170, 50, 50, 25);
        this.AddPnProjeto(cbSlot14, 170, 70, 50, 25);
        this.AddPnProjeto(cbSlot15, 170, 90, 50, 25);
        this.AddPnProjeto(cbSlot16, 220, 30, 50, 25);

        // Cursor...
        cbSlot0.setCursor(new Cursor(Cursor.HAND_CURSOR));
        cbSlot1.setCursor(new Cursor(Cursor.HAND_CURSOR));
        cbSlot2.setCursor(new Cursor(Cursor.HAND_CURSOR));
        cbSlot3.setCursor(new Cursor(Cursor.HAND_CURSOR));
        cbSlot4.setCursor(new Cursor(Cursor.HAND_CURSOR));
        cbSlot5.setCursor(new Cursor(Cursor.HAND_CURSOR));
        cbSlot6.setCursor(new Cursor(Cursor.HAND_CURSOR));
        cbSlot7.setCursor(new Cursor(Cursor.HAND_CURSOR));
        cbSlot8.setCursor(new Cursor(Cursor.HAND_CURSOR));
        cbSlot9.setCursor(new Cursor(Cursor.HAND_CURSOR));
        cbSlot10.setCursor(new Cursor(Cursor.HAND_CURSOR));
        cbSlot11.setCursor(new Cursor(Cursor.HAND_CURSOR));
        cbSlot12.setCursor(new Cursor(Cursor.HAND_CURSOR));
        cbSlot13.setCursor(new Cursor(Cursor.HAND_CURSOR));
        cbSlot14.setCursor(new Cursor(Cursor.HAND_CURSOR));
        cbSlot15.setCursor(new Cursor(Cursor.HAND_CURSOR));
        cbSlot16.setCursor(new Cursor(Cursor.HAND_CURSOR));
        
        
    }
  

    
    public void GerarSeleciona(JTable Tabela){
        /*
         * Executa uma seleção das placas a imprimir	
         */
    	objLog.Metodo("FormGerarLista().Gerar()");   	

    	// Pega dados das combos
   		iHz = Integer.parseInt(objDef.sCBoxHz);			
   		iPino = Integer.parseInt(objDef.sCBoxPino);

       	if(cbSlot0.isSelected()){  this.ImprimirDados(Tabela, "00");  	}
       	if(cbSlot1.isSelected()){  this.ImprimirDados(Tabela, "01");  	}
       	if(cbSlot2.isSelected()){  this.ImprimirDados(Tabela, "02");  	}
       	if(cbSlot3.isSelected()){  this.ImprimirDados(Tabela, "03");  	}
       	if(cbSlot4.isSelected()){  this.ImprimirDados(Tabela, "04");  	}
       	if(cbSlot5.isSelected()){  this.ImprimirDados(Tabela, "05");  	}
       	if(cbSlot6.isSelected()){  this.ImprimirDados(Tabela, "06");  	}
       	if(cbSlot7.isSelected()){  this.ImprimirDados(Tabela, "07");  	}
       	if(cbSlot8.isSelected()){  this.ImprimirDados(Tabela, "08");  	}
       	if(cbSlot9.isSelected()){  this.ImprimirDados(Tabela, "09");  	}
       	if(cbSlot10.isSelected()){  this.ImprimirDados(Tabela, "10");  	}
       	if(cbSlot11.isSelected()){  this.ImprimirDados(Tabela, "11");  	}
       	if(cbSlot12.isSelected()){  this.ImprimirDados(Tabela, "12");  	}
       	if(cbSlot13.isSelected()){  this.ImprimirDados(Tabela, "13");  	}
       	if(cbSlot14.isSelected()){  this.ImprimirDados(Tabela, "14");  	}
       	if(cbSlot15.isSelected()){  this.ImprimirDados(Tabela, "15");  	}
       	if(cbSlot16.isSelected()){  this.ImprimirDados(Tabela, "16");  	}
       	
    }  // Gerar
    
    private void ImprimirDados(JTable Tabela, String sSlot){
    	/*
    	 * Imprime dados, selecionados em Gerar, na Tabela
    	 */
    	Ferramentas objUtil = new Ferramentas();
    	
    	
    	int iPortaStart = 0;
    	
    	// Pega dados das combos
   		int iPortaFim = objUtil.ConvertePlaca(objDef.sCBoxPlaca);
   		int iBloco = Integer.parseInt(objDef.sCBoxBloco);
   		int iVt = Integer.parseInt(objDef.sCBoxVt);
   		
   		// Ctrl tipo de placas(0-15, 1-16, 0-31, 1-32, etc)
    	if((iPortaFim == 15)||(iPortaFim == 31)||(iPortaFim == 63)){
    		iPortaStart = 0;
    		objDef.fixeCBoxPorta(0);
 		}else{
    		iPortaStart = 1;   		 
    		objDef.fixeCBoxPorta(1);    		
    	}
    
    	for(int iPt = iPortaStart; iPt <= iPortaFim; iPt++){
		
    		if(iPino > iBloco){	iPino = 1;	iHz++;	}	// Ctrl Hz->Pino
		
    		Tabela.setValueAt(tfDslam.getText() + "-" + sSlot + "/" + iPt, iLinha, objDef.colDSLAM);    // Valor, Lin, Col
    		Tabela.setValueAt(Formatar.format(data), iLinha, objDef.colDATAD);    
    		Tabela.setValueAt("Ambos", iLinha, objDef.colPROTOCOL);    
    		Tabela.setValueAt(iVt, iLinha, objDef.colVT);   
    		Tabela.setValueAt(iHz, iLinha, objDef.colHZ);   
    		Tabela.setValueAt(iPino, iLinha, objDef.colPINO); 
    		Tabela.setValueAt("Testar", iLinha, objDef.colACAO); 
	
    		iLinha++;
    		iPino++;
		
    	}
    }

    
    public void LimparTabela(JTable Tabela){
		
		objLog.Metodo("FormGerarLista().LimparTabela()");
		
		int iNumLinTab = Tabela.getRowCount();	
		int iNumColTab = Tabela.getColumnCount();	
		
		for(int iL=0; iL < iNumLinTab; iL++){
			for(int iC=0; iC < iNumColTab; iC++){
				 Tabela.setValueAt("", iL, iC);
			}
		}	
		 
		
    }
    
    public void ZerarCombos(){
    	// Zera linhas de ctrl gerar-lista
    	iLinha = 0;
    	iPino = 1;
    	iHz = 1;
    			
    	tfDslam.setText("");
    	cbPlaca.setSelectedIndex(0);
    	cbBloco.setSelectedIndex(0);
    	cbVt.setSelectedIndex(0);
    	cbHz.setSelectedIndex(0);
    	cbPino.setSelectedIndex(0);
    	
    	cbSlot0.setSelected(false);
    	cbSlot1.setSelected(false);
    	cbSlot2.setSelected(false);
    	cbSlot3.setSelected(false);
    	cbSlot4.setSelected(false);
    	cbSlot5.setSelected(false);
    	cbSlot6.setSelected(false);
    	cbSlot7.setSelected(false);
    	cbSlot8.setSelected(false);
    	cbSlot9.setSelected(false);
    	cbSlot10.setSelected(false);
    	cbSlot11.setSelected(false);
    	cbSlot12.setSelected(false);
    	cbSlot13.setSelected(false);
    	cbSlot14.setSelected(false);
    	cbSlot15.setSelected(false);
    	cbSlot16.setSelected(false);
    			
    }

    //--[ FUNCAO PARA ADICIONAR COMPONENTES NO PAINEL DO FORMULARIO ]--\\
    private static void Adiciona(Component Componente, int iColIni, int iLinIni, int iLargura, int iAltura)  
    {
        Painel.add(Componente);                      
        Componente.setBounds(iColIni, iLinIni, iLargura, iAltura);
    }
    private static void AddPnOpc(Component Componente, int iColIni, int iLinIni, int iLargura, int iAltura)  
    {
    } 
    private static void AddPnProjeto(Component Componente, int iColIni, int iLinIni, int iLargura, int iAltura)  
    {
    	pnSlot.add(Componente);                      
        Componente.setBounds(iColIni, iLinIni, iLargura, iAltura);
    } 
    private static void AddPnModem(Component Componente, int iColIni, int iLinIni, int iLargura, int iAltura)  
    {
    }
 
    public boolean CheckSlot(){
        /*
         * Executa uma verificação se algum slot foi selecionado
         */
    	objLog.Metodo("FormGerarLista().CheckSlot()");
		boolean bSelecao = false;

       	if(cbSlot0.isSelected()){  bSelecao = true;  	}
       	if(cbSlot1.isSelected()){  bSelecao = true;  	}
       	if(cbSlot2.isSelected()){  bSelecao = true;  	}
       	if(cbSlot3.isSelected()){  bSelecao = true;  	}
       	if(cbSlot4.isSelected()){  bSelecao = true;  	}
       	if(cbSlot5.isSelected()){  bSelecao = true;  	}
       	if(cbSlot6.isSelected()){  bSelecao = true;  	}
       	if(cbSlot7.isSelected()){  bSelecao = true;  	}
       	if(cbSlot8.isSelected()){  bSelecao = true;  	}
       	if(cbSlot9.isSelected()){  bSelecao = true;  	}
       	if(cbSlot10.isSelected()){  bSelecao = true;  	}
       	if(cbSlot11.isSelected()){  bSelecao = true;  	}
       	if(cbSlot12.isSelected()){  bSelecao = true;  	}
       	if(cbSlot13.isSelected()){  bSelecao = true;  	}
       	if(cbSlot14.isSelected()){  bSelecao = true;  	}
       	if(cbSlot15.isSelected()){  bSelecao = true;  	}
       	if(cbSlot16.isSelected()){  bSelecao = true;  	}
		
		return bSelecao;
       	
    }  // Gerar
    
    private void Liberar(){
    	/*
    	 * Liberar var´s da memoria 
    	 */
    	objLog.Metodo("FormGerarLista().Liberar()");
    	
    	cbPlaca= null;
		cbBloco= null;
		cbVt= null;
		cbHz= null;
		cbPino= null;
		cbSlot0 = null; 
		cbSlot1 = null;
		cbSlot2 = null;
		cbSlot3 = null;
		cbSlot4 = null;
		cbSlot5 = null;
		cbSlot6 = null;
		cbSlot7 = null;
		cbSlot8 = null;
		cbSlot9 = null;
		cbSlot10 = null;
		cbSlot11 = null;
		cbSlot12 = null;
		cbSlot13 = null;
		cbSlot14 = null;
		cbSlot15 = null;
		cbSlot16 = null;
       	objLog = null;
   		objDef = null;
   		objCxD = null;
   		
		pnSlot = null;
	    Painel = null;
	    Formulario = null;	    
	    jTabTransportadaMtaView = null;
	      	
		
    }

   /*
    public static void main(String[] args)
    {
    	new FormGerarLista().Construir(null);
    }
    */
   
}