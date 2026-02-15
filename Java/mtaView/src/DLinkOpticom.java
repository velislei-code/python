
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
 * @author Velislei - jul2014
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


// Esta classe é compatível com: DLink2730b, Opticom(Dsl485, Dsl279)
public class DLinkOpticom {

	 private TelnetClient telnet = new TelnetClient();
	    private BufferedReader brLeitor;
	    private InputStream isFluxoDeEntrada;
	    private PrintStream psImprimirSaida;
	    public static String sPromptCompletado;
	    private String sRxLinha;

	    private Definicoes objDef = new Definicoes();
	    private Log objLog = new Log();
	    private Ferramentas objUtil = new Ferramentas();
	    
			
	    // Simulador	
	    private int iT;
	    
	    
	
	    
	    public DLinkOpticom() {
	    	
	    	/*
	    	 * Construtor
	    	 */
	    }

	    public String connect(int iComunicacao, String sHost, String sUsuario, String sSenha, int iPorta, String sPing) {
	        
	        try {
	        	sRxLinha = ""; 		// Limpa buffer	
	            // Prompt de resposta padrão
	            sPromptCompletado = ">";

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

	            mtd_LerResposta("Login: ");                 // Aguarda prompt
	            Mtd_Enviar(sUsuario);                       // Envia login
	            mtd_LerResposta("Password: ");              // Aguarda prompt
	            Mtd_Enviar(sSenha);                         // Envia senha
	            mtd_LerResposta(sPromptCompletado);         // Aguarda prompt
	            
	            if(iComunicacao == objDef.STATUS){
	                Mtd_Enviar("adsl info --stats");        // Envia comando - consulta status da linha
	                mtd_LerResposta(">");                   // Aguarda prompt        
	            }
	            if(iComunicacao == objDef.AUTH){
	                Mtd_Enviar("wan show 0.0.35");          // Envia comando - consulta AUTENTICAÇÃO
	                mtd_LerResposta(">");                   // Aguarda prompt        
	            }
	            if(iComunicacao == objDef.PING){
	                Mtd_Enviar("ping " + sPing);          // Envia comando - ping
	                mtd_LerResposta(">");                       // Aguarda prompt        
	            }
	            
	            // Executa teste de conexao com modens internos
	            if(iComunicacao == objDef.ShMODEM){
	                
	            	
	            	objLog.Metodo("DLinkOpticom().ping " + objDef.sIP[0]);
	            	Mtd_Enviar("ping "+ objDef.sIP[0]);          // Envia comando - ping
	                mtd_LerResposta(">");                       // Aguarda prompt
	                
	                objLog.Metodo("DLinkOpticom().ping " + objDef.sIP[1]);
	                Mtd_Enviar("ping  "+ objDef.sIP[1]);          // Envia comando - ping
	                mtd_LerResposta(">");                      // Aguarda prompt
	                
	                objLog.Metodo("DLinkOpticom().ping " + objDef.sIP[2]);
	                Mtd_Enviar("ping "+ objDef.sIP[2]);          // Envia comando - ping
	                mtd_LerResposta(">");                       // Aguarda prompt
	                
	                objLog.Metodo("DLinkOpticom().ping " + objDef.sIP[3]);
	                Mtd_Enviar("ping "+ objDef.sIP[3]);          // Envia comando - ping
	                mtd_LerResposta(">");                       // Aguarda prompt        
	           
	            }
	            
	            Mtd_Enviar("exit");		//Sair
	                     
	            
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
	        
	        return sRxLinha;    // Retorna Linhas com comunicação telnet
	    }

	    public String mtd_LerResposta(String pattern) {
	        StringBuffer sb = new StringBuffer();

	        try {
	            char lastChar = pattern.charAt(pattern.length() - 1);

	            boolean found = false;

	            int check = isFluxoDeEntrada.read();
	            char ch = (char) check;
	            while (check != -1) {
	               // System.out.print(ch);       // Imprime comunicação no console Java
	                sRxLinha = sRxLinha + ch;   // Carrega variável com comunicação telnet
	                
	                sb.append(ch);
	                if (ch == lastChar) {
	                    if (sb.toString().endsWith(pattern)) {

	                        return sb.toString();
	                    }
	                }
	                check = isFluxoDeEntrada.read();
	                ch = (char) check;
	              //  if(ch == '\n'){ sRxLinha = sRxLinha + ";"; } 	// Adiciona Tag ao final da linha
	            }
	            
	        } catch (Exception e) {
	            e.printStackTrace();
	        }

	        

	        return sb.toString();
	    }

	    public void Mtd_Enviar(String value) {
	        try {
	            psImprimirSaida.println(value);
	            psImprimirSaida.flush();
	            // System.out.println(value);   // Imprime em console java os comandos enviados
	            sRxLinha = sRxLinha + value;    // Carrega variável com comunicação telnet 
	        } catch (Exception e) {
	            e.printStackTrace();
	        }
	    }


	    public void Decode(int iTipo, JTable Tabela, int iLinTAB, String sLinTxt){
		    // Decodifica dados do relatório de linha do modem:
		    	objLog.Metodo("DlinkOpticom().Decode( "+sLinTxt+" )");
		    	
		    	//---------------------------------------------------------------------------------------------
		    	// Se é linha de status... 
		    	if(iTipo == objDef.STATUS){
		    	//---------------------------------------------------------------------------------------
		    		//Adsl Line Status(Training Status:        Showtime)
		    		if( sLinTxt.toLowerCase().contains("status")){
		    			if( sLinTxt.toLowerCase().contains("training")
		    			&&  sLinTxt.toLowerCase().contains("showtime")){
		    				Tabela.setValueAt("UP", iLinTAB, objDef.colSINC); 
		    			}else{
		    				String sStatus = sLinTxt.substring(sLinTxt.toLowerCase().indexOf("status") + 1, sLinTxt.length());
		    				sStatus = sStatus.replaceAll("\\s+"," ");		// Suprime espaço-em-branco
		    				Tabela.setValueAt("ACTIVATING.", iLinTAB, objDef.colSINC);
		    			}
		    		}
		    		//---------------------------------------------------------------------------------------------
		    		// Velocidades - Dsl485, 279: "Path:       FAST, Upstream rate = 320 Kbps, Downstream rate = 1024 Kbps",
		    		// Velocidades - Dsl2730b:    "Channel:        FAST, Upstream rate = 320 Kbps, Downstream rate = 1024 Kbps",
		    		if(	sLinTxt.toLowerCase().contains("path")
		    		&& 	sLinTxt.toLowerCase().contains("kbps")){
		    				if(sLinTxt.toLowerCase().contains("upstream")){
		    					
		    					String sVelUp = sLinTxt.substring(sLinTxt.toLowerCase().indexOf("upstream") + 15, sLinTxt.length() - 29);
		    					sVelUp = sVelUp.replaceAll("\\s+"," ");		// Suprime espaço-em-branco
		    					Tabela.setValueAt(sVelUp, iLinTAB, objDef.colVelUP);
		    				}
		    				if(sLinTxt.toLowerCase().contains("downstream")){
		    					
		    					String sVelDn = sLinTxt.substring(sLinTxt.toLowerCase().indexOf("downstream") + 17, sLinTxt.length());
		    					sVelDn = sVelDn.replaceAll("\\s+"," ");		// Suprime espaço-em-branco
		    					Tabela.setValueAt(sVelDn, iLinTAB, objDef.colVelDN);
		    				}
		    		}
		    		//---------------------------------------------------------------------------------------------
		    		// SINAL-RUÍDO: "SNR (dB):        35.8            18.0",
		    		
		    		if(	sLinTxt.toLowerCase().contains("snr")){    		
		    			
		    				String sSrUp = sLinTxt.substring(sLinTxt.indexOf(":") + 7, sLinTxt.length() - 15);
		    				sSrUp = sSrUp.replaceAll("\\s+"," ");		// Suprime espaço-em-branco
		    				Tabela.setValueAt(sSrUp, iLinTAB, objDef.colSrUP);    		
		    				
		    				String sSrDn = sLinTxt.substring(sLinTxt.indexOf(":") + 22, sLinTxt.length());
		    				sSrDn = sSrDn.replaceAll("\\s+"," ");		// Suprime espaço-em-branco
		    				Tabela.setValueAt(sSrDn, iLinTAB, objDef.colSrDN);    		
		    			
		    		}
		    	    	
		    		//---------------------------------------------------------------------------------------------
		    		// ATENUAÇÃO - "Attn(dB):        2.0             4.5",
		    		if(sLinTxt.toLowerCase().contains("attn")){    		
		    			
		    				String sAtUp = sLinTxt.substring(sLinTxt.indexOf(":") + 7, sLinTxt.length() - 15);
		    				sAtUp = sAtUp.replaceAll("\\s+"," ");		// Suprime espaço-em-branco
		    				Tabela.setValueAt(sAtUp, iLinTAB, objDef.colAtUP); 
		    			
		    				String sAtDn = sLinTxt.substring(sLinTxt.indexOf(":") + 22, sLinTxt.length());
		    				sAtDn = sAtDn.replaceAll("\\s+"," ");		// Suprime espaço-em-branco
		    				Tabela.setValueAt(sAtDn, iLinTAB, objDef.colAtDN);   
		    			
		    		}
		    		
		    		//---------------------------------------------------------------------------------------------
		    		// CRC - "CRC:            0               0",
		    		if(sLinTxt.toLowerCase().contains("crc")){    		
		    			
		    				String sCrcUp = sLinTxt.substring(sLinTxt.indexOf(":") + 7, sLinTxt.length() - 15);
		    				sCrcUp = sCrcUp.replaceAll("\\s+"," ");		// Suprime espaço-em-branco
		    				Tabela.setValueAt(sCrcUp, iLinTAB, objDef.colCrcUP); 
		    			
		    				String sCrcDn = sLinTxt.substring(sLinTxt.indexOf(":") + 22, sLinTxt.length());
		    				sCrcDn = sCrcDn.replaceAll("\\s+"," ");		// Suprime espaço-em-branco
		    				Tabela.setValueAt(sCrcDn, iLinTAB, objDef.colCrcDN);    		
		    			
		    		}
		     		
		    		// Se data ainda não foi inserida, insere
		    		if(Tabela.getValueAt(iLinTAB, objDef.colDATA) == ""){
		    			// Pega hora atualizada
		    			Date dHoje = new Date();  
		    			SimpleDateFormat Formatar = new SimpleDateFormat("dd/MM/yyyy hh:mm:ss");
		    			Tabela.setValueAt(Formatar.format(dHoje), iLinTAB, objDef.colDATA);
		    		}
		    		
		    	} // if(Def.Status)
		    	
		    	//---------------------------------------------------------------------------------------------------------------
		    	// AUTH - "0.0.35  0       pppoe_0_0_35    ppp0            PPPoE   Disable Disable Connected       189.11.110.57"
		    	
		    	if(iTipo == objDef.AUTH){
		    		
		    		if(sLinTxt.toLowerCase().contains("0.0.35")){
		    			
		    		  	if(sLinTxt.toLowerCase().contains("connected")){
		    		  			    		  			    	
		    		  		Tabela.setValueAt("UP", iLinTAB, objDef.colAUTH);	// Autentica: UP

		    		  		// Pega IP
		    		  		String sIP = sLinTxt.substring(sLinTxt.toLowerCase().indexOf("connected") + 10, sLinTxt.length());
		    		  		sIP = sIP.replaceAll("\\s+"," ");		// Suprime espaço-em-branco 
		    		  		Tabela.setValueAt(sIP, iLinTAB, objDef.colIP);
		    		  		
		    		  	}else{		    		  			    		  		
		    		  		Tabela.setValueAt("Down", iLinTAB, objDef.colAUTH);	// Autentica: UP
		    		  	}
		    		} 	
		    		  	
		    	} //if(Def.Auth)
		    	
		    	//---------------------------------------------------------------------------------------------
		    	/* PING 
		    	*"56 bytes from 200.147.67.142: icmp_seq=0 ttl=247 time=34.0 ms", 
		    	*"4 packets transmitted, 4 packets received, 0% packet loss"
		    	*/
		    	if(iTipo == objDef.PING){
		    		if(	sLinTxt.toLowerCase().contains("icmp_seq") 
		    		&&  	sLinTxt.toLowerCase().contains("time") ){	    		
		    			Tabela.setValueAt("UP", iLinTAB, objDef.colNAV); 
		    		}
		    		if(	sLinTxt.toLowerCase().contains("packets")){	    		
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
	    	
	        objLog.Metodo("DLinkOpticom().Simula(Cmd: " + sT + ")");
	        iT=0;      
	        
	       
	        	ActionListener alTarefaScan = new ActionListener(){
	    			public void actionPerformed(ActionEvent evt) { 
	    				
	    				CmdModem objSimula = new CmdModem();	    			
	    				if(iTipo == objDef.STATUS){	taTelnet.setText(taTelnet.getText() + objSimula.sHubDLinkStatus[iT] + "\n"); }
	    				if(iTipo == objDef.AUTH){	taTelnet.setText(taTelnet.getText() + objSimula.sHubDLinkAuth[iT] + "\n"); }
	    				if(iTipo == objDef.PING){	taTelnet.setText(taTelnet.getText() + objSimula.sHubDLinkPing[iT] + "\n"); }
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
	        	CmdModem objSim = new CmdModem();
	        	
	        	if(iTipo == objDef.STATUS){
	        		Random rGeraRdm = new Random();
	        		if(rGeraRdm.nextBoolean()){
	        			// Se gerou verdadeiro - pega Relatório(simulado) Status-UP	        		
	        			for(int t=0; t < objSim.iHubDLinkStatus; t++){
	        				sCaptura =  sCaptura + objSim.sHubDLinkStatus[t] + "\n";	// Pega o texto simulado
	        			}
	        			objLog.Metodo("Simula SINC.HubDlink: UP");
	        		}else{
	        			// Se gerou falso - pega Relatório(simulado) Status-Down	        		
	        			for(int t=0; t < objSim.iHubDLinkStatusDN; t++){
	        				sCaptura =  sCaptura + objSim.sHubDLinkStatusDN[t] + "\n";	// Pega o texto simulado
	        			}
	        			objLog.Metodo("Simula SINC.HubDlink: DOWN");
	        		}
	        	}
	        	if(iTipo == objDef.AUTH){
	        		Random rGeraRdm = new Random();
	        		if(rGeraRdm.nextBoolean()){
	        			// Se gerou verdadeiro - pega Relatório(simulado) UP	        		
	        			for(int t=0; t < objSim.iHubDLinkAuth; t++){
	        				sCaptura =  sCaptura + objSim.sHubDLinkAuth[t] + "\n";	// Pega o texto simulado
	        			}
	        		}else{
	        			// Se gerou Falso - pega Relatório(simulado) Down	        		
	        			for(int t=0; t < objSim.iHubDLinkAuthDN; t++){
	        				sCaptura =  sCaptura + objSim.sHubDLinkAuthDN[t] + "\n";	// Pega o texto simulado
	        			}
	        			
	        		}
	        	}
	        	if(iTipo == objDef.PING){
	        		Random rGeraRdm = new Random();
	        		if(rGeraRdm.nextBoolean()){
	        			// Se gerou verdadeiro - pega Relatório(simulado) UP	        		
	        			for(int t=0; t < objSim.iHubDLinkPing; t++){
	        				sCaptura =  sCaptura + objSim.sHubDLinkPing[t] + "\n";	// Pega o texto simulado
	        			}
	        		}else{
	         			// Se gerou falso - pega Relatório(simulado) Down	        		
	        			for(int t=0; t < objSim.iHubDLinkPingDN; t++){
	        				sCaptura =  sCaptura + objSim.sHubDLinkPingDN[t] + "\n";	// Pega o texto simulado
	        			}
	        			
	        		}
	        	}
	        	return sCaptura; 	// Retorna o texto simulado
	        	
	    }
	   
	  
}
