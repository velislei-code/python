
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
public class FormSobre{

	
	
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
        
        Formulario.setTitle("mtaView - Sobre");                 
        Formulario.setSize(525, 280); 	// Alt-Larg            
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
       Adiciona(pnCampoTexto, 10, 10, 485, 180, defPAINEL);  // Col, Lin, Larg, Alt
  
        //carrega a imagem passando o nome da mesma
        JLabel image = new JLabel();  
        String stImage = objDef.DirRoot + "/imagens/placa.png";   // Dir-Imagem de amostra
        image.setIcon(new ImageIcon(stImage));					  // carrega imagem	
        /*
        status.setBorder(BorderFactory.createLineBorder(Color.BLACK));  
        status.setBounds(10, 80, 100, 100); 
        status.setIcon(new javax.swing.ImageIcon("c:/quimica.png"));        
        Painel.add(status);
        */ 
        
      
        Adiciona(image, 10, 0, 100, 100, defCPTEXTO);
     
        // Labels
        JLabel lblTitulo = new JLabel("mtaView - Matriz de testes ADSL");
        JLabel lblVersao = new JLabel("Versão: Demo - Prototype Release 3.11.15");
        JLabel lblBuild = new JLabel("Build id: " +objDef.sVersao+ "-MD4");
        
        JLabel lblCorp = new JLabel("Copyright mta (c)2014-2015, all rights reserveds");
        JLabel lblEmail = new JLabel("mta.app.pc@gmail.com");
        JLabel lblSite = new JLabel("https://mtaapppc.wixsite.com/suporte");
        JLabel lblBy = new JLabel("By Treuk, V.A.");
        
      // Adiciona(status, 300, 10, largura, altura, defPAINEL);
     
        Adiciona(lblTitulo, 130, 25, 300, 25, defCPTEXTO);
        Adiciona(lblVersao, 130, 45, 300, 25, defCPTEXTO);
        Adiciona(lblBuild, 130, 65, 300, 25, defCPTEXTO);
        Adiciona(lblCorp, 130, 95, 300, 25, defCPTEXTO);
        Adiciona(lblSite, 130, 115, 300, 25, defCPTEXTO);
        Adiciona(lblEmail, 130, 135, 300, 25, defCPTEXTO);
        Adiciona(lblBy, 130, 155, 300, 25, defCPTEXTO);
     	
		// Botões
		int iColIni = 35;
		int iLin = 200;
		int iLarg = 90;		// Largura do botão
		
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