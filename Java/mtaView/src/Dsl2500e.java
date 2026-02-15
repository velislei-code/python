
/**
 * @author Velislei
 * No NetBeans:
 * org.apache.commons.net.telnet.*;
 * 1 - Fazer o download deste arquivo java chamado Telnet e colocá-lo em Java  jdk1.7.0  jre  lib.
 * 2 - Click em Biblioteca(bt dir) -> Add Biblioteca -> Criar [NomeBiblioteca]
 *      -> [ok] -> Classpath -> [Add JAR/Pasta] -> OK
 * 3 - Selecione [NomeBiblioteca] adicionada e [Ok]
 */

/**
 * Apache - Commons
 *
 * @author Velislei - Ago2014
 * Baixei os pct: 
 * http://commons.apache.org/downloads/index.html
 * o .NET.* em:
 * http://commons.apache.org/proper/commons-net/download_net.cgi
 * 
 * Vá direto ao passo 3, dá mais certo:
 * 
 * 1 - No Eclipse crie a biblioteca em:
 * 		Window -> Preferences -> 
 * 			-> Java -> Build path -> User library
 *  			-> New: Nome[apache-commons]
 *  				-> Add external JARs  [OK]
 *  2 - Adicione a biblioteca em:
 *  	Projeto(MyTelnet) -> src(click com botão direito do mouse)
 *  		-> Build path -> Configure Build path
 *  			-> Java Build path -> Library(orelha) [Add library]
 *  				-> User library -> [x]apache-commons [OK]
 *  	* Deve aparecer a biblioteca Apache-commons abaixo da pasta "src"
 *  	* Como não apareceu, usei o procedimenyto 3
 *  3 - Build path -> Configure Build path
 *  			-> Java Build path -> Library(orelha) [Add JARs External]
 *  				-> Adicionei o arquivo commons-net-3.3.jar [OK]
 *  
 *  	* OK, agora apareceu a pasta Referenced Library e dentro o commons
 *  
 */	


import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.PrintStream;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Random;
import java.util.logging.Level;
import java.util.logging.Logger;

import javax.swing.JTable;
import javax.swing.JTextArea;
import javax.swing.Timer;

import org.apache.commons.net.telnet.*;



public class Dsl2500e {
	 	private TelnetClient telnet = new TelnetClient();
	    private BufferedReader brLeitor;
	    private InputStream isFluxoDeEntrada;
	    private PrintStream psImprimirSaida;
	    public static String sPromptCompletado;
	    private String sCapturaLin;
	    private int iT;
	    private String sArmazena = "";
	    private Log objLog = new Log();
	    private Ferramentas objUtil = new Ferramentas();
	    Definicoes objDef = new Definicoes();
	    
	  
	    public Dsl2500e() {
	    	
	    	/*
	    	 * Construtor
	    	 */
	    }

	    public String connect(int iComunicacao, String sHost, String sUsuario, String sSenha, int iPorta, String sPing) {
	        
	        try {

	            // Prompt de resposta padrão
	            sPromptCompletado = "$";

	            //Abre conexão telnet Host na porta
	            telnet.connect(sHost, iPorta);

	            //Lemos as respostas enviadas pelo telnet com um InputStream do objeto telnet
	            isFluxoDeEntrada = telnet.getInputStream();

	            //Enviamos os comandos telnet com um OutputStream do objeto telnet
	            psImprimirSaida = new PrintStream(telnet.getOutputStream());


	            // Enviamos um novo InputStream dentro de um BufferedReader
	            // para que a leitura das respostas do telnet sejam muito
	            // mais simples e mais bem geridas
	            brLeitor = new BufferedReader(new InputStreamReader(isFluxoDeEntrada));

	            mtd_LerResposta("Username: ");                 // Aguarda prompt
	            Mtd_Enviar(sUsuario);                       // Envia login
	            mtd_LerResposta("Password: ");              // Aguarda prompt
	            Mtd_Enviar(sSenha);                         // Envia senha
	            mtd_LerResposta(sPromptCompletado);         // Aguarda prompt
	            
	            if(iComunicacao == objDef.STATUS){
	            	  Mtd_Enviar("sh");            			// Envia comando - entra no modo show
	            	  mtd_LerResposta("DSL_2500E#");          // Aguarda prompt        
	            	  Mtd_Enviar("show adsl");            	// Envia comando - consulta status da linha
	            	  mtd_LerResposta("DSL_2500E#");          // Aguarda prompt	                        
	            }
	            if(iComunicacao == objDef.AUTH){
	                Mtd_Enviar("show status");          // Envia comando - consulta AUTENTICAÇÃO
	                mtd_LerResposta(sPromptCompletado);                   // Aguarda prompt        
	            }
	    
	            
	            if(iComunicacao == objDef.PING){
	            	  	Mtd_Enviar("sh");            			// Envia comando - entra no modo show
		                mtd_LerResposta("DSL_2500E#");          // Aguarda prompt        
		                Mtd_Enviar("ping " + sPing);       // Envia comando - consulta status da linha
		                mtd_LerResposta("DSL_2500E#");          // Aguarda prompt
		               	               
		                
	            }
	            Mtd_Enviar("exit");       // Envia comando - Encerra
	            
	                     
	            
	        } catch (Exception e) {
	            e.printStackTrace();

	        } finally {
	            try {
	                //Liberamos recursos
	                psImprimirSaida.close();
	                brLeitor.close();
	                isFluxoDeEntrada.close();
	                telnet.disconnect();

	            } catch (IOException ex) {
	                Logger.getLogger(DLinkOpticom.class.getName()).log(Level.SEVERE, null, ex);
	            }

	        }
	        
	        return sCapturaLin;    // Retorna Linhas com comunicação telnet
	    }

	    public String mtd_LerResposta(String pattern) {
	        StringBuffer sbDepositoDeString = new StringBuffer();

	        try {
	            char cUltimoCaracter = pattern.charAt(pattern.length() - 1);

	            boolean bEncontrar = false;

	            int iVerifique = isFluxoDeEntrada.read();
	            char cCaracter = (char) iVerifique;
	            while (iVerifique != -1) {
	               // System.out.print(cCaracter);       // Imprime comunicação no console Java
	                sCapturaLin = sCapturaLin + cCaracter;   // Carrega variável com comunicação telnet
	                
	                sbDepositoDeString.append(cCaracter);
	                if (cCaracter == cUltimoCaracter) {
	                    if (sbDepositoDeString.toString().endsWith(pattern)) {

	                        return sbDepositoDeString.toString();
	                    }
	                }
	                iVerifique = isFluxoDeEntrada.read();
	                cCaracter = (char) iVerifique;
	            }
	        } catch (Exception e) {
	            e.printStackTrace();
	        }



	        return sbDepositoDeString.toString();
	    }

	    public void Mtd_Enviar(String value) {
	        try {
	            psImprimirSaida.println(value);
	            psImprimirSaida.flush();
	            // System.out.println(value);   // Imprime em console java os comandos enviados
	            sCapturaLin = sCapturaLin + value;    // Carrega variável com comunicação telnet 
	        } catch (Exception e) {
	            e.printStackTrace();
	        }
	    }

	    public void Decode(int iTipo, JTable Tabela, int iLinTAB, String sLinTxt){
	    // Decodifica dados do relatório de linha do modem:
	    	objLog.Metodo("Dsl2500e().Decode( "+sLinTxt+" )");
	    	
	    	//---------------------------------------------------------------------------------------------
	    	// Se é linha de status... 
	    	if(iTipo == objDef.STATUS){
	    	//---------------------------------------------------------------------------------------
	    		//Adsl Line Status
	    		if( sLinTxt.toLowerCase().contains("status")){	    	
	    			// Se Estiver Sinc.., fixa UP, Else... mostra situação em curso
	    			if(sLinTxt.toLowerCase().contains("showtime")){
	    				Tabela.setValueAt("UP", iLinTAB, objDef.colSINC); 
	    			}else{
	    				String sStatus = sLinTxt.substring(sLinTxt.toLowerCase().indexOf("status") + 7, sLinTxt.length());
	    				sStatus = sStatus.replaceAll("\\s+"," ");		// Suprime espaço-em-branco
	    				Tabela.setValueAt(sStatus, iLinTAB, objDef.colSINC);
	    			}
	    		}
	    		//---------------------------------------------------------------------------------------------
	    		// Velocidades - Up Stream - Down Stream - kbps
	    		if(	sLinTxt.toLowerCase().contains("kbps")){
	    				if(sLinTxt.toLowerCase().contains("up")){
	    					
	    					String sVelUp = sLinTxt.substring(sLinTxt.toLowerCase().indexOf("stream") + 15, sLinTxt.length());
	    					sVelUp = sVelUp.replaceAll("\\s+"," ");		// Suprime espaço-em-branco
	    					Tabela.setValueAt(sVelUp, iLinTAB, objDef.colVelUP);
	    				}
	    				if(sLinTxt.toLowerCase().contains("down")){
	    					
	    					String sVelDn = sLinTxt.substring(sLinTxt.toLowerCase().indexOf("stream") + 15, sLinTxt.length());
	    					sVelDn = sVelDn.replaceAll("\\s+"," ");		// Suprime espaço-em-branco
	    					Tabela.setValueAt(sVelDn, iLinTAB, objDef.colVelDN);
	    				}
	    		}
	    		//---------------------------------------------------------------------------------------------
	    		// SINAL-RUÍDO: SNR Margin Down Stream
	    		if(	sLinTxt.toLowerCase().contains("margin")){    		
	    			if(sLinTxt.toLowerCase().contains("up") ){
	    				String sSrUp = sLinTxt.substring(sLinTxt.indexOf("Stream") + 10, sLinTxt.length());
	    				sSrUp = sSrUp.replaceAll("\\s+"," ");		// Suprime espaço-em-branco
	    				Tabela.setValueAt(sSrUp, iLinTAB, objDef.colSrUP);    		
	    			}
	    			if(sLinTxt.toLowerCase().contains("down") ){
	    				String sSrDn = sLinTxt.substring(sLinTxt.indexOf("Stream") + 10, sLinTxt.length());
	    				sSrDn = sSrDn.replaceAll("\\s+"," ");		// Suprime espaço-em-branco
	    				Tabela.setValueAt(sSrDn, iLinTAB, objDef.colSrDN);    		
	    			}
	    		}
	    	    	
	    		//---------------------------------------------------------------------------------------------
	    		// ATENUAÇÃO
	    		if(sLinTxt.toLowerCase().contains("attenuation")){    		
	    			if(sLinTxt.toLowerCase().contains("up") ){
	    				String sAtUp = sLinTxt.substring(sLinTxt.indexOf("Stream") + 10, sLinTxt.length());
	    				sAtUp = sAtUp.replaceAll("\\s+"," ");		// Suprime espaço-em-branco
	    				Tabela.setValueAt(sAtUp, iLinTAB, objDef.colAtUP); 
	    			}
	    			if(sLinTxt.toLowerCase().contains("down") ){
	    				String sAtDn = sLinTxt.substring(sLinTxt.indexOf("Stream") + 10, sLinTxt.length());
	    				sAtDn = sAtDn.replaceAll("\\s+"," ");		// Suprime espaço-em-branco
	    				Tabela.setValueAt(sAtDn, iLinTAB, objDef.colAtDN);   
	    			}
	    		}
	    		
	    		//---------------------------------------------------------------------------------------------
	    		// CRC
	    		if(sLinTxt.toLowerCase().contains("crc")){    		
	    			if(sLinTxt.toLowerCase().contains("upstream")){
	    				String sCrcUp = sLinTxt.substring(sLinTxt.indexOf("upstream") + 10, sLinTxt.length());
	    				sCrcUp = sCrcUp.replaceAll("\\s+"," ");		// Suprime espaço-em-branco
	    				Tabela.setValueAt(sCrcUp, iLinTAB, objDef.colCrcUP); 
	    			}
	    			if(sLinTxt.toLowerCase().contains("downstream")){
	    				String sCrcDn = sLinTxt.substring(sLinTxt.indexOf("downstream") + 10, sLinTxt.length());
	    				sCrcDn = sCrcDn.replaceAll("\\s+"," ");		// Suprime espaço-em-branco
	    				Tabela.setValueAt(sCrcDn, iLinTAB, objDef.colCrcDN);    		
	    			}
	    		}
	    		
	    		// Se data ainda não foi inserida, insere
	    		if(Tabela.getValueAt(iLinTAB, objDef.colDATA) == ""){
	    			// Pega hora atualizada
	    			Date dHoje = new Date();  
	    			SimpleDateFormat Formatar = new SimpleDateFormat("dd/MM/yyyy hh:mm:ss");
	    			Tabela.setValueAt(Formatar.format(dHoje), iLinTAB, objDef.colDATA);
	    		}
	    		
	    	} // if(Def.Status)
	    	
	    	//---------------------------------------------------------------------------------------------
	    	// AUTH - "pppoe1  0/35    LLC   On     PPPoE  200.193.175.68  201.10.216.240  up"
	    	
	    	if(iTipo == objDef.AUTH){
	    		
	    		if(sLinTxt.toLowerCase().contains("pppoe1")){	    			
	    		  	if(sLinTxt.toLowerCase().contains("up")){	    		  		    		  			    	
	    		  		
	    		  		Tabela.setValueAt("UP", iLinTAB, objDef.colAUTH);	// Autentica: UP

	    		  		// Pega IP
	    		  		String sIP = sLinTxt.substring(sLinTxt.toLowerCase().indexOf("on") + 13,  sLinTxt.length() - 18);
	    		  		sIP = sIP.replaceAll("\\s+"," ");		// Suprime espaço-em-branco
	    		  		Tabela.setValueAt(sIP, iLinTAB, objDef.colIP);
	    		  		
	    		  	}else{	    		  				  		
	    		  		Tabela.setValueAt("Down", iLinTAB, objDef.colAUTH);	// Autentica: UP
	    		  	}
	    		} 	
	    		  	
	    	} //if(Def.Auth)
	    	
	    	//---------------------------------------------------------------------------------------------
	    	// PING
	    	if(iTipo == objDef.PING){
	    		if(	sLinTxt.toLowerCase().contains("success")    		
	    		&&	sLinTxt.toLowerCase().contains("percent") ){	    		
	    			Tabela.setValueAt("UP", iLinTAB, objDef.colNAV); 
	    			
	    			//String sPing = sLinTxt.substring(0, sLinTxt.indexOf(","));

			    	String sPing = sLinTxt.substring(0, sLinTxt.length() );
			    	if(objDef.bFmtPing) { sPing = objUtil.FormatePing(sPing); }

	    			Tabela.setValueAt(sPing, iLinTAB, objDef.colPING);    		
	    		}
	
	    		if(objDef.bSimulacao){ Tabela.setValueAt(objDef.AcaoFimSim, iLinTAB, objDef.colACAO); }
	    		else{ Tabela.setValueAt(objDef.AcaoFimTst, iLinTAB, objDef.colACAO); }
	    		
	      		Tabela.setValueAt("---", iLinTAB, objDef.colVozAA);
	    		Tabela.setValueAt("---", iLinTAB, objDef.colVozAB);
	    		Tabela.setValueAt("---", iLinTAB, objDef.colVozABT);	 
	    		
	    	
	    	}//if(Def.Ping)
	    	    	
	    	
	    	//---------------------------------------------------------------------------------------------
	    	
	    	
	    	
	    }
	   
	    public String Simula(final int iTipo, final JTextArea taTelnet) {
	    	
	    	String sT="";
	    	if(iTipo == objDef.STATUS){ sT = "Status"; }
	    	if(iTipo == objDef.AUTH){ sT = "Auth"; }
	    	if(iTipo == objDef.PING){ sT = "Ping"; }
	    	
	        objLog.Metodo("Dsl2500e().Simula(Cmd: " + sT + ")");
	        iT=0;      
	        
	       
	        	ActionListener alTarefaScan = new ActionListener(){
	    			public void actionPerformed(ActionEvent evt) { 
	    				
	    				CmdModem objSimula = new CmdModem();	    			
	    				if(iTipo == objDef.STATUS){	taTelnet.setText(taTelnet.getText() + objSimula.sDsl2500eStatus[iT] + "\n"); }
	    				if(iTipo == objDef.AUTH){	taTelnet.setText(taTelnet.getText() + objSimula.sDsl2500eAuth[iT] + "\n"); }
	    				if(iTipo == objDef.PING){	taTelnet.setText(taTelnet.getText() + objSimula.sDsl2500ePing[iT] + "\n"); }
	    				iT++;
	    				
		    		}};

    			Timer tScanModem = new Timer(10, alTarefaScan);
	        	tScanModem.start();
				
	        	/*
	        	 * Prepara retorno pois, texto do TArea não pega, 
	        	 * devido diferença de objetos(taTelnet) transportados
	        	 * entre as classes - o taTelnet parece não ser o mesmo 
	        	 * taTelnet da classe principal, são objetos diferentes
	        	 */
	        	String sCaptura="";
	        	CmdModem objSimula = new CmdModem();
	        	
	        	if(iTipo == objDef.STATUS){
	        		Random rGeraRdm = new Random();
	        		if(rGeraRdm.nextBoolean()){
	        			// Se gerou verdadeiro - pega Relatório(simulado) Status-UP
	        			for(int t=0; t < objSimula.iDsl2500eStatus; t++){
	        				sCaptura =  sCaptura + objSimula.sDsl2500eStatus[t] + "\n";	// Pega o texto simulado
	        			}
	        			objLog.Metodo("Simula SINC.DSL2500e: UP");
	        		}else{
	        			// Se gerou falso - pega Relatório(simulado) Status-Down
	        			for(int t=0; t < objSimula.iDsl2500eStatusDN; t++){
	        				sCaptura =  sCaptura + objSimula.sDsl2500eStatusDN[t] + "\n";	// Pega o texto simulado
	        			}
	        			objLog.Metodo("Simula SINC.DSL2500e: DOWN");
	        		}
	        	}
	        	if(iTipo == objDef.AUTH){
	        		Random rGeraRdm = new Random();
	        		if(rGeraRdm.nextBoolean()){
	        			// Se gerou verdadeiro - pega Relatório(simulado) UP
	        			for(int t=0; t < objSimula.iDsl2500eAuth; t++){
	        				sCaptura =  sCaptura + objSimula.sDsl2500eAuth[t] + "\n";	// Pega o texto simulado
	        			}
	        		}else{
	        			// Se gerou falso - pega Relatório(simulado) Down
	        			for(int t=0; t < objSimula.iDsl2500eAuthDN; t++){
	        				sCaptura =  sCaptura + objSimula.sDsl2500eAuthDN[t] + "\n";	// Pega o texto simulado
	        			}
	        		}
	        	}
	        	if(iTipo == objDef.PING){
	        		Random rGeraRdm = new Random();
	        		if(rGeraRdm.nextBoolean()){
	        			// Se gerou verdadeiro - pega Relatório(simulado) UP
	        			for(int t=0; t < objSimula.iDsl2500ePing; t++){
	        				sCaptura =  sCaptura + objSimula.sDsl2500ePing[t] + "\n";	// Pega o texto simulado
	        			}
	        		}else{
	        			// Se gerou falso - pega Relatório(simulado) Down
	        			for(int t=0; t < objSimula.iDsl2500ePingDN; t++){
	        				sCaptura =  sCaptura + objSimula.sDsl2500ePingDN[t] + "\n";	// Pega o texto simulado
	        			}
	        			
	        		}
	        	}
	        	return sCaptura; 	// Retorna o texto simulado
	        	
	    }
	    
	    
	    	
		

}

