


	import java.awt.Color;
	import java.awt.Component;
	import java.awt.Image;
	import java.awt.Toolkit;
	import java.io.File;
	import java.io.IOException;
	import java.net.URL;
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

	import javax.swing.*;

	import java.awt.*;

	/*
	 * Constroi um formulário de opções - Novo projeto
	 * 
	 */
	
	public class FormPropriedadesTab {

		
		
		// Usado para escolher tipo de painel
		static boolean defPAINEL = true;
		static boolean defCPTEXTO = false;
		
		private Date data = new Date();  
		private SimpleDateFormat Formatar = new SimpleDateFormat("dd/MM/yyyy");
		
		private Log objLog = new Log();
		private Definicoes objDef = new Definicoes();
		private CxDialogo objCxD = new CxDialogo();
		
	    private static JPanel Painel = new JPanel();
	    private static JFrame Formulario = new JFrame();
	    
	    private static JPanel pnCampoTexto = new JPanel();
	   
	    JButton BtnOK = new JButton();
	 	
	   
	    
	    public void Construir()
	    {     
	    	
	    	// Ajustes dos EDITS
	    //	int iAjLin = 5;
	    //	int iAjCol = 5;
	        
	        Formulario.setTitle("mtaView - Propriedades");                 
	        Formulario.setSize(200, 250); 	// Larg-Alt            
	        Formulario.setLocationRelativeTo( null ); 
	        Formulario.setUndecorated(true);
	        
	                
	        // Icone do Form
	    	String stIcon = objDef.DirRoot + "/imagens/Icon_btn/BtnPropriedades16.png";		// Dir ico    
	        Image icon = Toolkit.getDefaultToolkit().getImage(stIcon);	// carrega Icon - não esta carreganfo
	        this.setIconImage(icon);
	    	Formulario.setIconImage(icon);
	         
	        Painel.setLayout(null);         //DESLIGANDO O GERENCIADOR DE LAYOUT
	        Formulario.add( Painel );   
	        
	        
	        pnCampoTexto.setBorder(BorderFactory.createLineBorder(Color.black));
	        pnCampoTexto.setLayout(null); 
	       Adiciona(pnCampoTexto, 10, 10, 180, 230, defPAINEL);  // Col, Lin, Larg, Alt
	  
	        //carrega a imagem passando o nome da mesma
	        JLabel image = new JLabel();  
	        String stImage = objDef.DirRoot + "/imagens/Icon_btn/BtnPropriedades16.png";   // Dir-Imagem de amostra
	        image.setIcon(new ImageIcon(stImage));					  // carrega imagem	
	        /*
	        status.setBorder(BorderFactory.createLineBorder(Color.BLACK));  
	        status.setBounds(10, 80, 100, 100); 
	        status.setIcon(new javax.swing.ImageIcon("c:/quimica.png"));        
	        Painel.add(status);
	        */ 
	        
	      
	        Adiciona(image, 30, 10, 30, 30, defCPTEXTO);
	     
	        // Labels
	        JLabel lblNome = new JLabel("Nome: PrjTeste1");
	        JLabel lblTipo = new JLabel("Tipo: Arquivo MTA(*.mta)");
	        JLabel lblLocal = new JLabel("Local: C:\\Users\\Voyager\\Documents\\mtaView_docs\\");
	        
	        JLabel lblTam = new JLabel("Tamanho: 80kb");
	      
	        
	      // Adiciona(status, 300, 10, largura, altura, defPAINEL);
	     
	        Adiciona(lblNome, 30, 25, 100, 25, defCPTEXTO);
	        Adiciona(lblTipo, 30, 45, 100, 25, defCPTEXTO);
	        Adiciona(lblLocal, 30, 65, 100, 25, defCPTEXTO);
	        Adiciona(lblTam, 30, 95, 100, 25, defCPTEXTO);
	       
	     	
			// Botões
			int iColIni = 0;
			int iLin = 150;
			int iLarg = 60;		// Largura do botão
			
	        JButton BtnOK = new JButton("OK");
	        Adiciona(BtnOK, (2*iLarg)+iColIni, iLin, iLarg, 25, defPAINEL);
	        
	         
	        
	        Formulario.setVisible( true );
	        
	   	
	   	 	// Ouvir Eventos - Botões
	        BtnOK.addActionListener(new java.awt.event.ActionListener() {
	            public void actionPerformed(java.awt.event.ActionEvent evt) {
	            	BtnOKActionPerformed(evt);
	            }
	        });

	    	 
	    }
	    
	    private void setIconImage(Image icon) {
			// TODO Auto-generated method stub
			
		}

		private void BtnOKActionPerformed(java.awt.event.ActionEvent evt) { 
	    	
	    	Formulario.dispose();		// Fecha formulario
	    	
	    }
	    
	    //--[ FUNCAO PARA ADICIONAR COMPONENTES NO PAINEL DO FORMULARIO ]--\\
	    private static void Adiciona(Component Componente, int iColIni, int iLinIni, int iLargura, int iAltura, boolean bUsarPaneil)  
	    {
	    	if(bUsarPaneil){ Painel.add(Componente); }
	    	else{	pnCampoTexto.add(Componente);	}	                      
	    		
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
	    
	    /*
	    public static void main(String[] args)
	    {
	    	new FormSobre().Construir(null);
	    	
	    	
	    }
	    */
	    
	}
