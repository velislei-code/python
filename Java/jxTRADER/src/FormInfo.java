
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
public class FormInfo{

	
	
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
        
        Formulario.setTitle("jxTrader - Info");                 
        Formulario.setSize(540, 600); 	// Larg, Alt            
        Formulario.setLocationRelativeTo( null );    
        
                
        // Icone do Form
    	 String stIcon = objDef.DirRoot + "/imagens/grafico.jpg";		// Dir ico    
        Image icon = Toolkit.getDefaultToolkit().getImage(stIcon);	// carrega Icon - não esta carreganfo
        this.setIconImage(icon);
    	Formulario.setIconImage(icon);
         
        Painel.setLayout(null);         //DESLIGANDO O GERENCIADOR DE LAYOUT
        Formulario.add( Painel );   
        
        
        pnCampoTexto.setBorder(BorderFactory.createLineBorder(Color.black));
        pnCampoTexto.setLayout(null); 
       Adiciona(pnCampoTexto, 10, 10, 500, 530, defPAINEL);  // Col, Lin, Larg, Alt
  
        //carrega a imagem passando o nome da mesma
        JLabel image = new JLabel();  
        String stImage = objDef.DirRoot + "/imagens/MovePrecoDia.png";   // Dir-Imagem de amostra
        image.setIcon(new ImageIcon(stImage));					  // carrega imagem	
        /*
        status.setBorder(BorderFactory.createLineBorder(Color.BLACK));  
        status.setBounds(10, 80, 100, 100); 
        status.setIcon(new javax.swing.ImageIcon("c:/quimica.png"));        
        Painel.add(status);
        */ 
        
      
        Adiciona(image, 5, 5, 488, 297, defCPTEXTO);	// Col, Lin, Larg, Alt
     
        // Labels
        JLabel lblTitulo = new JLabel("10:15 - 10:30: Vender no Gap, costuma haver empolgação de preços");
        JLabel lblVersao = new JLabel("11:00 - 11:15: Vender, costuma alcançar pico acima do gap");
        JLabel lblBuild = new JLabel("13:45 - 14:30: Comprar, costuma ter a 2° maior baixa do dia");
        
        JLabel lblCorp = new JLabel("16:30 - 16:45: Comprar, melhor horário da compra, preço esta definido,");
        JLabel lblEmail = new JLabel("                           Maior baixa do dia com possibilidade de Gap na abertura");
        JLabel lblSite = new JLabel("16:45 - 16:55: Sobe um pouco");
        JLabel lblBy = new JLabel("");
        
      // Adiciona(texto, col, lin, largura, altura, defPAINEL);
        
        int iLinIni = 350;
        int iAltLin = 20;
        int iCol = 20;
        int iLargLin = 500;
        
        Adiciona(lblTitulo, iCol, iLinIni + (iAltLin*0), iLargLin, 25, defCPTEXTO);
        Adiciona(lblVersao, iCol, iLinIni + (iAltLin*1), iLargLin, 25, defCPTEXTO);
        Adiciona(lblBuild, iCol, iLinIni + (iAltLin*2), iLargLin, 25, defCPTEXTO);
        Adiciona(lblCorp, iCol, iLinIni + (iAltLin*3), iLargLin, 25, defCPTEXTO);
        
        Adiciona(lblEmail, iCol, iLinIni + (iAltLin*4), iLargLin, 25, defCPTEXTO);
        Adiciona(lblSite, iCol, iLinIni + (iAltLin*5), iLargLin, 25, defCPTEXTO);
        Adiciona(lblBy, iCol, iLinIni + (iAltLin*6), iLargLin, 25, defCPTEXTO);
     	
		// Botões
		int iColIni = 45;
		int iLin = 500;
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
    	new FormInfo().Construir();
    	
    	
    }
    */
    
}
