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


import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.PrintStream;
import java.util.logging.Level;
import java.util.logging.Logger;

import javax.swing.JTable;

import org.apache.commons.net.telnet.*;


public class Intelbras {

	 private TelnetClient telnet = new TelnetClient();
	    private BufferedReader brLeitor;
	    private InputStream isFluxoDeEntrada;
	    private PrintStream psImprimirSaida;
	    public static String sPromptCompletado;
	    private String sRxLinha;

	    Definicoes objDef = new Definicoes();
	   
	    public Intelbras() {
	    	/*
	    	 * Construtor
	    	 */
	    }

	    public String connect(int iComunicacao, String sHost, String sUsuario, String sSenha, int iPorta, String sPing) {
	        
	        try {

	            // Prompt de resposta padrão
	            sPromptCompletado = "Enter the option(1-9):";

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

	            mtd_LerResposta("login: ");                 // Aguarda prompt
	            Mtd_Enviar(sUsuario);                       // Envia login
	            mtd_LerResposta("Password: ");              // Aguarda prompt
	            Mtd_Enviar(sSenha);                         // Envia senha
	            mtd_LerResposta(sPromptCompletado);         // Aguarda prompt
	            
	            if(iComunicacao == objDef.STATUS){
	                Mtd_Enviar("8");            						// Envia comando - estatísticas
	                mtd_LerResposta("Enter the option(1-3):");      	// Aguarda prompt
	                Mtd_Enviar("2");            						// Envia comando - status da linha
	                mtd_LerResposta("Press Enter key to continue...");  // Aguarda prompt
	                Mtd_Enviar("CR");            						// Envia comando - <Enter>
	                		// CR (Carriage Return) = "\r" = (char) 13 
	                		// LF (Line Feed) = "\n" = (char) 10 

	                mtd_LerResposta("Enter the option(1-3):");          // Aguarda prompt
	                Mtd_Enviar("3");            						// Envia comando - Quit
	                mtd_LerResposta(sPromptCompletado);         		// Aguarda prompt
	                Mtd_Enviar("9");            						// Envia comando - Logout
	            }
	            
	            if(iComunicacao == objDef.PING){
	            	Mtd_Enviar("6");            					// Envia comando - diagnóticos
	            	mtd_LerResposta("Enter the option(1-3):");  	// Aguarda prompt
	            	Mtd_Enviar("1");            					// Envia comando - Ping
	            	mtd_LerResposta("Host Address :");				// Aguarda prompt
	                Mtd_Enviar("10.43.16.1");          				// Envia comando - ping
	                mtd_LerResposta("Continue (1)Yes (2)No :"); 	// Aguarda prompt    
	                Mtd_Enviar("2");            					// Envia comando - No
	                mtd_LerResposta("Enter the option(1-3):");  	// Aguarda prompt
	                Mtd_Enviar("3");            					// Envia comando - Quit
	                mtd_LerResposta(sPromptCompletado);         	// Aguarda prompt
	                Mtd_Enviar("9");            					// Envia comando - Logout

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

	    
	    public void DecodeTxt(JTable Tabela, int iLin, String sLinTxt){
	    	
	    	//objLog.Metodo("mtaView().DecodeTxt_Intelbras(Decodifica texto, grava em celula da plan)");
	    
	    	if(sLinTxt.contains("SHOWTIME")){ Tabela.setValueAt("Up", iLin, objDef.colSINC); }
			if(sLinTxt.contains("SNR")){ 
				
				String sSrUP = sLinTxt.substring(sLinTxt.indexOf(":") + 1, sLinTxt.length()-3);					
				Tabela.setValueAt(sSrUP, iLin, objDef.colSrUP); 
				
				String sSrDN = sLinTxt.substring(sLinTxt.indexOf(":") + 5, sLinTxt.length());
				Tabela.setValueAt(sSrDN, iLin, objDef.colSrDN);
			}
				
	    }

}
