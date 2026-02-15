import java.awt.Component;
import java.awt.Image;
import java.awt.Toolkit;
import java.awt.event.ActionEvent;

import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JTextField;
import javax.swing.UIManager;

public class CxDialogo {

	// usado em showOptionDialog
	private static JPanel Painel = new JPanel();
	private static JFrame Formulario = new JFrame();
	
	int iResOpt = 0;

	static int defSIM = 0;
	static int defNAO = 1;
	
	public static void Combo() {
	
		Object[] opcoes = { "sim", "não" };	
		Object resposta;
	
		do {
	
			resposta = JOptionPane.showInputDialog(null,
	
					"Estaação vai apagar todos os item da tabela, deseja continuar?",
	
					"Finalização",
	
					JOptionPane.PLAIN_MESSAGE,
	
					null,

					opcoes,
	
					"não");
	
		} while (resposta == null || resposta.equals("não"));
	
	}
	
	public void Aviso(String sTexto, boolean bAtivo) {
		// Ativo: habilit/desabilita exibição de msg
		if(bAtivo){ JOptionPane.showMessageDialog(null, sTexto); }
	}
	
	public boolean Confirme(String sTexto, boolean bAtivo) {
		UIManager.put("OptionPane.yesButtonText", "Sim");		// Retorna 0
		UIManager.put("OptionPane.noButtonText", "Não");		// Retorna 1
	
		// Ativo: habilit/desabilita exibição de msg
		if(bAtivo){
			// int iRes = JOptionPane.showConfirmDialog(null, sTexto);
			int iRes = JOptionPane.showConfirmDialog(new JFrame(), 
 					sTexto, "Atenção!",     			        
 					JOptionPane.YES_NO_OPTION);
			
			if(iRes == defSIM){ return true; }
			else{ return false; }
		}else{
			return false;
		}
	}
	
	public int showOptionDlg(String sTexto, String sBtn0, String sBtn1, String sBtn2, boolean bAtivo) {
		
		UIManager.put("OptionPane.yesButtonText", sBtn0);		// Retorna 0
		UIManager.put("OptionPane.noButtonText", sBtn1);		// Retorna 1
		UIManager.put("OptionPane.cancelButtonText", sBtn2);	// Retorna 2			 	
	       
        
        int iRes = 0;
        
        // Ativo: habilita/desabilita exibição de msg
     		if(bAtivo){
     			//iRes = JOptionPane.showConfirmDialog(null, sTexto);
     			
     			iRes = JOptionPane.showConfirmDialog(new JFrame(), 
     					sTexto, "Atenção!",     			        
     					JOptionPane.YES_NO_CANCEL_OPTION);
     			
     			
     		}
        return iRes;
	}
	
	public void Perguntar(String sTexto, boolean bAtivo) {
		
		JTextField input = new JTextField();  
        Object[] message = { "Digite algo:" , input };  
        String[] options = { "Sim", "Não" };  
        int result = JOptionPane.showOptionDialog(null, message, "Titulo",   
                JOptionPane.YES_NO_OPTION, JOptionPane.QUESTION_MESSAGE, null, options, options[0]);  
        switch (result) {  
            case 0: // SIM  
                String texto = input.getText();  
                // ...  
                break;  
            case 1: // NAO  
                break;  
        }  
	}
	
public void ShowBugs(){
	
	String[] sInfo = new String[]{
			
			"objDef.bSimula dentro Classe Dlink, Dsl2500 pode não estar sinc.com config.ini[simulacao]",
			"AnalisarTestes possui bugs, não esta funcionando direito",
	};
	
	String sMsg = "";
	
	int iTamanho = sInfo.length;
	
	for(int iFa=0; iFa<iTamanho;iFa++){
		int iFb = iFa + 1;
		sMsg =  iFb + ": " + sMsg + sInfo[iFa]  + "\n" ;  			
	 
	}
	int iAvs = OpcaoAviso(sMsg, 1);
	
}
	
public int OpcaoAviso(String sTexto, int iBtn) {
		
  		int iRes = 0;
  		
  		if(iBtn == 1){
  			UIManager.put("OptionPane.yesButtonText", "OK");		
  			iRes = JOptionPane.showConfirmDialog(null, sTexto, null, JOptionPane.CLOSED_OPTION);// 2 Botões
  		}
  		
  		if(iBtn == 2){
  			UIManager.put("OptionPane.yesButtonText", "Sim");		
  			UIManager.put("OptionPane.noButtonText", "Não");
  			iRes = JOptionPane.showConfirmDialog(null, sTexto, null, JOptionPane.YES_NO_OPTION);// 2 Botões
  		}
  		
  		if(iBtn == 3){
  			UIManager.put("OptionPane.yesButtonText", "OK");		
  			UIManager.put("OptionPane.noButtonText", "Desbloquear");
  			UIManager.put("OptionPane.cancelButtonText", "Sair");
  			iRes = JOptionPane.showConfirmDialog(null, sTexto);		// 3 botões
  		}
  			
   		
   		return iRes;
   	
      
	}



  
public int showOptionDialog(String sTexto){     
	
	// Dialog com 4 botoes - FALHA: Não consegui retornar valor(após pressionar botão)
        
	//protected static final int YES_NO_CANCEL_HELP_OPTION = 4;
	//iResOpt = JOptionPane.showConfirmDialog(null, sTexto, null, JOptionPane.YES_NO_CANCEL_HELP_OPTION);// 2 Botões
	 
    Formulario.setTitle("Selecionar");                 
    Formulario.setSize(500, 130); 	// Alt-Larg            
    Formulario.setLocationRelativeTo( null );    
    
    Definicoes objDef = new Definicoes();
            
    // Icone do Form
	String stIcon = objDef.DirRoot + "/imagens/placa2.png";		// Dir ico    
    Image icon = Toolkit.getDefaultToolkit().getImage(stIcon);	// carrega Icon - não esta carreganfo
    //this.setIconImage(icon);
	Formulario.setIconImage(icon);
     
    Painel.setLayout(null);         //DESLIGANDO O GERENCIADOR DE LAYOUT
    Formulario.add( Painel );   

    //carrega a imagem passando o nome da mesma
    JLabel image = new JLabel();  
    String stImage = objDef.DirRoot + "/imagens/interrogacao.png";   // Dir-Imagem de amostra
    image.setIcon(new ImageIcon(stImage));					  // carrega imagem	
    
    Painel.add(image);
    image.setBounds(10, 0, 50, 50);
    
    // Labels
    JLabel lblMsg = new JLabel(sTexto);          
    Painel.add(lblMsg);
    lblMsg.setBounds(60, 15, 400, 25);
    
    JButton BtnContinua = new JButton("Continuar");
    JButton BtnRepete = new JButton("Repetir");
    JButton BtnReinicia = new JButton("Reiniciar");
    JButton BtnParar = new JButton("Parar");
 	
	// Botões
	int iColIni = 60;
	int iLin = 50;
	int iLarg = 90;		// Largura do botão		
    
	Painel.add(BtnContinua);
	Painel.add(BtnRepete);
	Painel.add(BtnReinicia);
	Painel.add(BtnParar);
	
	BtnContinua.setBounds(iColIni, iLin, iLarg, 25);
	BtnRepete.setBounds(iColIni + 95, iLin, iLarg, 25);
	BtnReinicia.setBounds(iColIni + 195, iLin, iLarg, 25);
	BtnParar.setBounds(iColIni + 285, iLin, iLarg, 25);
	
    
    Formulario.setVisible( true );
    
	
	 	// Ouvir Eventos - Botões
    BtnContinua.addActionListener(new java.awt.event.ActionListener() {
       
    	public void actionPerformed(java.awt.event.ActionEvent evt) {        	
        	//BtnContinuaActionPerformed(evt);
        	
        	iResOpt = 10;				// Valor não dá tempo de retornar(apos click de botão - retorna imediato)
        	Formulario.dispose();		// Fecha formulario
        	
        }
    });

	return iResOpt;	
	
}

/*
public void createdButtonFired(int buttonIndex) {
	Object optionPane;
	if(optionPane != null) {
		Object[] options = optionPane.getOptions();

if(options == null) {
int messageType = optionPane.getOptionType();

if(inputComponent != null &&
(messageType == JOptionPane.YES_NO_OPTION ||
messageType == JOptionPane.YES_NO_CANCEL_OPTION ||
messageType == JOptionPane.OK_CANCEL_OPTION ||
messageType == JOptionPane.DEFAULT_HELP_OPTION ||
messageType == JOptionPane.YES_NO_HELP_OPTION ||
messageType == JOptionPane.YES_NO_CANCEL_HELP_OPTION ||
messageType == JOptionPane.OK_CANCEL_HELP_OPTION) &&
buttonIndex == 0)
resetInputValue();
if(messageType == JOptionPane.OK_CANCEL_OPTION &&
buttonIndex == 1)
optionPane.setValue(new Integer(2));
else if(messageType == JOptionPane.DEFAULT_HELP_OPTION &&
buttonIndex == 1)
optionPane.setValue(new Integer(3));
else if(messageType == JOptionPane.YES_NO_HELP_OPTION &&
buttonIndex == 2)
optionPane.setValue(new Integer(3));
else if(messageType == JOptionPane.OK_CANCEL_HELP_OPTION &&
buttonIndex == 2)
optionPane.setValue(new Integer(3));
else
optionPane.setValue(new Integer(buttonIndex));
}
else
//New code here
if(inputComponent != null)
resetInputValue();
//End new code
optionPane.setValue(options[buttonIndex]);
}
 }
*/
	
}
