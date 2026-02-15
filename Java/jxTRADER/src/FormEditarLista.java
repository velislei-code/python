
import java.awt.Color;
import java.awt.Component;
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
import javax.swing.JSeparator;
import javax.swing.JTable;
import javax.swing.JTextField;
import javax.swing.JToolBar;
import javax.swing.SwingConstants;

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
public class FormEditarLista{

	// Numeros
	/*
	private int iSlot = 0;
	private int iPorta = 0;
	private int iHz = 1;
	private int iVt = 1;
	private int iPino = 1;
	*/
	
	// Usado para escolher tipo de painel
	static boolean defPAINEL = true;
	static boolean defCPTEXTO = false;
	
	private Date data = new Date();  
	private SimpleDateFormat Formatar = new SimpleDateFormat("dd/MM/yyyy");
	
	private Log objLog = new Log();
	private Definicoes objDef = new Definicoes();
	private Ferramentas objUtil = new Ferramentas();
	private CxDialogo objCxD = new CxDialogo();
	
    private static JPanel Painel = new JPanel();
    private static JFrame Formulario = new JFrame();
    
    private static JPanel pnCampoTexto = new JPanel();
   
    JTable jTabTransportadaMtaView = new JTable();			// Transporta Tabela(mtaView->CxOpcoes) devido metodo carregarExcel
    
 // Componentes da BferAddLinha
 	 static boolean bExibeAddLinha = false;
 	 JToolBar BfAddLinha = new JToolBar();
 	 JComboBox cbLinha  = new JComboBox();
 	 JComboBox cbPlaca = new JComboBox();
 	 JComboBox cbBloco  = new JComboBox(); 	
 	 final JTextField tfDslam = new RenderTextoGost("Nome do Dslam"); 
 	 final JTextField tfDesc = new RenderTextoGost("Descrição do defeito");  	
 	 JComboBox cbSlot  = new JComboBox();
 	 JComboBox cbPorta  = new JComboBox();
 	 JTextField tfDataDf = new JTextField();
 	 JComboBox cbProtocolo  = new JComboBox();
 	 JComboBox cbHz  = new JComboBox();
 	 JComboBox cbVt  = new JComboBox();
 	 JComboBox cbPino  = new JComboBox();
 	 JButton BtnAddLinha = new JButton();
 	 JButton BtnLimpar = new JButton();
 	
   
    
    public void Construir(JTable jTabTransportada)
    {     
    	
    	// Ajustes dos EDITS
    	int iAjLin = 5;
    	int iAjCol = 5;
        
    	jTabTransportadaMtaView = jTabTransportada;		// Repassa valores de Tabela mtaView para Tablea CxOpçoes 
        //Formulario.setDefaultCloseOperation( /* Salvar */ );        
        Formulario.setTitle("mtaView - Editar lista");                 
        Formulario.setSize(525, 220); 	// Alt-Larg            
        Formulario.setLocationRelativeTo( null );    
        
        // Icone do Form
    	 String stIcon = objDef.DirRoot + "/imagens/placa2.png";		// Dir ico    
        Image icon = Toolkit.getDefaultToolkit().getImage(stIcon);	// carrega Icon - não esta carreganfo
        this.setIconImage(icon);
    	Formulario.setIconImage(icon);
        
        Painel.setLayout(null);         //DESLIGANDO O GERENCIADOR DE LAYOUT
        Formulario.add( Painel );   
        
        
        pnCampoTexto.setBorder(BorderFactory.createLineBorder(Color.black));
        pnCampoTexto.setLayout(null); 
        this.Adiciona(pnCampoTexto, 10, 10, 485, 115, defPAINEL);  // Col, Lin, Larg, Alt
  
        
        BfAddLinha.setFloatable(false);	 
		BfAddLinha.setRollover(true);
		
		JSeparator SeparaBfAddLin = new JSeparator();
		SeparaBfAddLin.setOrientation(SwingConstants.VERTICAL);
		BfAddLinha.add(SeparaBfAddLin);
		
		// Linha 10
		this.Adiciona(cbLinha, 10 + iAjCol, 10 + iAjLin, 60, 25, defCPTEXTO);
		
		// Linha 40
		this.Adiciona(tfDslam, 10 + iAjCol, 40 + iAjLin, 120, 25, defCPTEXTO);
		this.Adiciona(cbSlot, 130 + iAjCol, 40 + iAjLin, 60, 25, defCPTEXTO);				
	    this.Adiciona(cbPorta, 190 + iAjCol, 40 + iAjLin, 60, 25, defCPTEXTO);	    
	    this.Adiciona(cbPlaca, 250 + iAjCol, 40 + iAjLin, 60, 25, defCPTEXTO);
	    this.Adiciona(tfDataDf, 310 + iAjCol, 40 + iAjLin, 70, 25, defCPTEXTO);	    
	    this.Adiciona(cbProtocolo, 380 + iAjCol, 40 + iAjLin, 80, 25, defCPTEXTO);
	    
	    // Linha 70	    
	    this.Adiciona(cbVt, 10 + iAjCol, 70 + iAjLin, 50, 25, defCPTEXTO);
	    this.Adiciona(cbHz, 60 + iAjCol, 70 + iAjLin, 50, 25, defCPTEXTO);
	    this.Adiciona(cbPino, 110 + iAjCol, 70 + iAjLin, 50, 25, defCPTEXTO);	    
	    this.Adiciona(cbBloco, 160 + iAjCol, 70 + iAjLin, 60, 25, defCPTEXTO);
	    this.Adiciona(tfDesc, 220 + iAjCol, 70 + iAjLin, 240, 25, defCPTEXTO);
		
		cbLinha.addItem("Linha");
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
		
		cbBloco.addItem("Bloco");
		cbBloco.addItem("10");
		cbBloco.addItem("120");
		cbBloco.setToolTipText("Tipo de bloco");
		
		tfDslam.setToolTipText("Nome do Dslam");
		tfDesc.setToolTipText("Descrição do defeito");
		cbSlot.addItem("Slot");
		cbSlot.setToolTipText("Slot");
		cbPorta.addItem("Porta");
		cbPorta.setToolTipText("Porta");
		tfDataDf.setText(Formatar.format(data));
		cbProtocolo.addItem("Protocolo");
		cbProtocolo.addItem("Ambos");
		cbProtocolo.addItem("PPPoA");
		cbProtocolo.addItem("PPPoE");
		cbProtocolo.setToolTipText("Tipo de protocolo");
		
		cbVt.addItem("Vt");
		cbVt.setToolTipText("Vertical");
		cbHz.addItem("Hz");	
		cbHz.setToolTipText("Horizontal");
		cbPino.addItem("Pino");
		cbPino.setToolTipText("Pino");
		
		BfAddLinha.setVisible(false);
		
		/*
		// Cria itens(numeros) de combo Vt, Hz e Pino
		for(int iL = 1; iL <= objDef.NumLinAdd; iL++){ cbLinha.addItem(iL);	}			
		for(int iS = 0; iS <= objDef.NumSlotAdd; iS++){ cbSlot.addItem(iS);	}
		for(int iP = 0; iP <= objDef.PlacaAdd; iP++){ cbPorta.addItem(iP);	}
		for(int iHVP = 1; iHVP <= objDef.NumHVPAdd; iHVP++){ 
				// 	iHVP: i-integer, H-hor, V-Vert, P-Pino
				cbHz.addItem(iHVP);
				
				cbVt.addItem(iHVP);
				cbPino.addItem(iHVP);
		}
     */
	
		// Botões
		int iColIni = 60;
		int iLin = 140;
		int iLarg = 90;		// Largura do botão
		
        JButton BtnAdd = new JButton("Adicionar");
        this.Adiciona(BtnAdd, iColIni, iLin, iLarg, 25, defPAINEL);

        JButton BtnLimpar = new JButton("Limpar");
        this.Adiciona(BtnLimpar, iLarg + iColIni, iLin, iLarg, 25, defPAINEL);
 
        JButton BtnOK = new JButton("OK");
        this.Adiciona(BtnOK, (2*iLarg)+iColIni, iLin, iLarg, 25, defPAINEL);
        
        JButton BtnCancel = new JButton("Cancelar");
        this.Adiciona(BtnCancel, (3*iLarg)+iColIni, iLin, iLarg, 25, defPAINEL);
         
        
        Formulario.setVisible( true );
        
        
     // Ouvir enventos - Combos
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

    	 
    }
    private void setIconImage(Image icon) {
		// TODO Auto-generated method stub
		
	}
	// Pegar Eventos - Combos
    private void cbLinhaActionPerformed(java.awt.event.ActionEvent evt) {  
	     int indiceDoCombo = cbLinha.getSelectedIndex();  
	    // objDef.sCBoxLinha = cbLinha.getSelectedItem().toString();  
	} 
    private void cbPlacaActionPerformed(java.awt.event.ActionEvent evt) {  
	     int indiceDoCombo = cbPlaca.getSelectedIndex();  
	     //objDef.sCBoxPlaca = cbPlaca.getSelectedItem().toString();  
	} 
    private void cbBlocoActionPerformed(java.awt.event.ActionEvent evt) {  
	     int indiceDoCombo = cbBloco.getSelectedIndex();  
	     //objDef.sCBoxBloco = cbBloco.getSelectedItem().toString();  
	} 
	private void cbSlotActionPerformed(java.awt.event.ActionEvent evt) {  
	     int indiceDoCombo = cbSlot.getSelectedIndex();  
	     //objDef.sCBoxSlot = cbSlot.getSelectedItem().toString();  
	}  
	private void cbPortaActionPerformed(java.awt.event.ActionEvent evt) {  
	     int indiceDoCombo = cbPorta.getSelectedIndex();  
	     //objDef.sCBoxPorta = cbPorta.getSelectedItem().toString();  
	}  	
	private void cbProtocoloActionPerformed(java.awt.event.ActionEvent evt) {  
	     int indiceDoCombo = cbProtocolo.getSelectedIndex();  
	     //objDef.sCBoxProtocolo = cbProtocolo.getSelectedItem().toString();  
	} 		
	private void cbHzActionPerformed(java.awt.event.ActionEvent evt) {  
	     int indiceDoCombo = cbHz.getSelectedIndex();  
	     //objDef.sCBoxHz = cbHz.getSelectedItem().toString();  
	} 	

		
	private void cbVtActionPerformed(java.awt.event.ActionEvent evt) {  
	     int indiceDoCombo = cbVt.getSelectedIndex();  
	     //objDef.sCBoxVt = cbVt.getSelectedItem().toString();  
	} 		

	private void cbPinoActionPerformed(java.awt.event.ActionEvent ePino) {  
	     int indiceDoCombo = cbPino.getSelectedIndex();  
	     //objDef.sCBoxPino = cbPino.getSelectedItem().toString();  
	} 	
    
    // Pegar Eventos - Botoes
    private void BtnAddActionPerformed(java.awt.event.ActionEvent evt) {
    	/*
    	if( (!objDef.sCBoxLinha.contains("h"))
    	&&  (!objDef.sCBoxPlaca.contains("t"))
    	&&	(!objDef.sCBoxBloco.contains("c")) ){
    		
    		if( (!objDef.sCBoxSlot.contains("o"))
    		&&	(!objDef.sCBoxPorta.contains("a")) ){
    			
    			if( (tfDslam.getText().contains("6"))    			
    			&&  (!objDef.sCBoxProtocolo.contains("to")) ){
    				
    				if( (!objDef.sCBoxVt.contains("t"))
    				&&	(!objDef.sCBoxHz.contains("z"))
    				&&	(!objDef.sCBoxPino.contains("o")) ){
    		
    					this.AddLinha(jTabTransportadaMtaView);
    					Formulario.setVisible(true);		// mantém Form-Editar visivel em cima do mtaView
    				
    				}else{ objCxD.Aviso("Você deve informar: Vt, Hz e Pino.", true); }    					
    			}else{ objCxD.Aviso("Você deve informar: Dslam, Prot. e Descrição.", true); }    			    					
    		}else{ objCxD.Aviso("Você deve informar: Slot e Porta.", true); }		
    	}else{ objCxD.Aviso("Você deve informar: Linha, N.Portas e Bloco.", true); }
    		
    	  */  	
    	
    }
    private void BtnLimparActionPerformed(java.awt.event.ActionEvent evt) {
    	
    	int iTReg = new Ferramentas().ContarReg(jTabTransportadaMtaView);	// Conta numero de registros na tabela
		if( iTReg > 1){							// Verifica NumReg
 	
			if(objCxD.Confirme("Apagar todos os dados da tabela?", objDef.bMsgExcluir) )
			{
				this.LimparTabela(jTabTransportadaMtaView);			
			}
		}else{ objCxD.Aviso("Não há registros a serem excluidos.", true); }
		
    }
    private void BtnOKActionPerformed(java.awt.event.ActionEvent evt) {     	
    	Formulario.dispose();		// Fecha formulario
    	// Este metodo esta travando a re-exibição: this.Liberar();
    }
    private void BtnCancelActionPerformed(java.awt.event.ActionEvent evt) {
    	Formulario.dispose();		// Fecha formulario
    	// Este metodo esta travando a re-exibição: this.Liberar();
    }
    
    //--[ FUNCAO PARA ADICIONAR COMPONENTES NO PAINEL DO FORMULARIO ]--\\
    private static void Adiciona(Component Componente, int iColIni, int iLinIni, int iLargura, int iAltura, boolean bUsarPaneil)  
    {
    	if(bUsarPaneil){ Painel.add(Componente); }
    	else{	pnCampoTexto.add(Componente);	}	                      
    		
    	Componente.setBounds(iColIni, iLinIni, iLargura, iAltura);
    	
    }

    public void AddLinha(JTable Tabela){
    	
    	objLog.Metodo("FormEditarLista().AddLinha()");
    	
    		int iPortaStart = 0;	 	
    //		int iPortaFim = objUtil.ConvertePlaca(objDef.sCBoxPlaca);
    	 	
    	 	// Se placa 31 ou 63...inicia em zero..senão...inicia em 1..24, 1a32..
    	// 	if(Integer.parseInt(objDef.sCBoxPorta) == 0){	// Só entra se porta = zero, primeira passagem
    	 //}
    	 	
    	// Adiciona dados as celulas da tabela
    /*
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
        
      	 objLog.Metodo("FormEditarLista().AddLinha()->iPortaStart: "+iPortaStart);
    	 objLog.Metodo("FormEditarLista().AddLinha()->:objDef.pegueCBoxPorta(): "+objDef.pegueCBoxPorta());
    	 objLog.Metodo("FormEditarLista().AddLinha()->iPortaFim: "+iPortaFim);

    	 
        cbSlot.setSelectedIndex(objDef.pegueCBoxSlot() + 1);
        cbPorta.setSelectedIndex(objDef.pegueCBoxPorta() + 1);
        
        
        
        int iBloco =   Integer.parseInt(objDef.sCBoxBloco);
        
        if(objDef.pegueCBoxPino() + 1 > iBloco ){
        	objDef.incCBoxHz();
        	objDef.fixeCBoxPino(1); //iPino = 1;
        	objLog.Metodo("FormEditarLista().AddLinha()->iPino: "+objDef.pegueCBoxPino()+" > iBloco: "+iBloco);
        }else{
        	objDef.incCBoxPino();
    	    objLog.Metodo("FormEditarLista().AddLinha()->iHz: "+objDef.pegueCBoxHz());
    	    //iHz = Integer.parseInt(objDef.sCBoxVt);
    	    objLog.Metodo("FormEditarLista().AddLinha()->iHz: "+objDef.pegueCBoxHz());
    	    objLog.Metodo("FormEditarLista().AddLinha()->iPino: "+objDef.pegueCBoxPino()+" < iBloco: "+iBloco);
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
         
    	
      */ 
        
    }  
 

    public void LimparTabela(JTable Tabela){
		
		objLog.Metodo("FormEditarLista().LimparTabela()");
		
		int iNumLinTab = Tabela.getRowCount();	
		int iNumColTab = Tabela.getColumnCount();	
		
		for(int iL=0; iL < iNumLinTab; iL++){
			for(int iC=0; iC < iNumColTab; iC++){
				 Tabela.setValueAt("", iL, iC);
			}
		}
		
		int iLin = 0;
		
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


    private void Liberar(){
    	/*
    	 * Liberar var´s da memoria 
    	 */
    	objLog.Metodo("FormEditarLista().Liberar()");
    	
    	cbLinha= null;		
		cbSlot= null;
		cbPlaca= null;
		cbPorta= null;
		tfDataDf = null;
		cbProtocolo= null;
		cbBloco= null;
		cbVt= null;
		cbHz= null;
		cbPino= null;
		pnCampoTexto = null;
       	objLog = null;
   		objDef = null;
   		objCxD = null;
   		objUtil = null;
	    Painel = null;
	    Formulario = null;	    
	    pnCampoTexto = null;	   
	    jTabTransportadaMtaView = null;
	      	
		
    }
    
    
 /*
    public static void main(String[] args)
    {
    	new FormEditarLista().Construir(null);
    }
 */
    
}