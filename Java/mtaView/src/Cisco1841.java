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


public class Cisco1841 {

	 private TelnetClient telnet = new TelnetClient();
	    private BufferedReader brLeitor;
	    private InputStream isFluxoDeEntrada;
	    private PrintStream psImprimirSaida;
	    public static String sPromptCompletado;
	    private String sRxLinha;

	    Definicoes objDef = new Definicoes();
	    Log objLog = new Log();
	   
	    public Cisco1841() {
	    	/*
	    	 * Construtor
	    	 */
	    }

	    public String connect(int iComunicacao, String sHost, String sUsuario, String sSenha, int iPorta, String sPing) {
	        
	    	objLog.Metodo("Cisco1841.Connect()");
	    	
	        try {

	            // Prompt de resposta padrão
	            sPromptCompletado = "CTO_OI_0784968>";
	       

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
	       
	            
	            mtd_LerResposta("Username: ");              // Aguarda prompt
	            Mtd_Enviar(sUsuario);                       // Envia login
	       
	            mtd_LerResposta("Password: ");              // Aguarda prompt
	            Mtd_Enviar(sSenha);                         // Envia senha
	       
	            mtd_LerResposta(sPromptCompletado);         // Aguarda prompt
	            
	            
	            if(iComunicacao == objDef.STATUS){
	                Mtd_Enviar("sh int fa0/0");            		// Envia comando - estatísticas
	                mtd_LerResposta("--More--");
	                Mtd_Enviar("q");							// Continuar...
	                mtd_LerResposta(sPromptCompletado);      	// Aguarda prompt
	       
	            }
	            
	            if(iComunicacao == objDef.PING){
	            	Mtd_Enviar("ping 10.42.0.1");            	// Envia comando - diagnóticos
	            	mtd_LerResposta(sPromptCompletado);  		// Aguarda prompt
	       

	            }
	       
	            Mtd_Enviar("exit");		//Sair
	                     
	       
	        } catch (Exception e) {
	            e.printStackTrace();
	            objLog.Metodo("Erro na conexao !");
	        } finally {
	            try {
	                //Liberamos recursos
	                psImprimirSaida.close();
	                brLeitor.close();
	                isFluxoDeEntrada.close();
	                telnet.disconnect();

	            } catch (IOException ex) {
	                Logger.getLogger(DLinkOpticom.class.getName()).log(Level.SEVERE, null, ex);
	                objLog.Metodo("falha na conexao !");
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
	    	
	    	objLog.Metodo("Cisco1841().DecodeTxt(Decodifica texto, grava em celula da plan)");
	    	
	    	//FastEthernet0/0 is up, line protocol is up
	    	if(	sLinTxt.contains("line")
	    	&&  sLinTxt.contains("protocol") ){ 
	    		Tabela.setValueAt("Fa-UP", iLin, objDef.colSINC); 
	    	}
	    	// 107 output errors, 254 collisions, 110 interface resets
			if(	sLinTxt.contains("collisions")){ 
				
				String sOutErro = sLinTxt.substring(0, sLinTxt.indexOf("errors"));					
				Tabela.setValueAt(sOutErro + "err", iLin, objDef.colSrUP); 
				
				String sColide = sLinTxt.substring( sLinTxt.indexOf("errors") + 2, sLinTxt.indexOf("collisions"));
				Tabela.setValueAt(sColide + "Colisões", iLin, objDef.colSrDN);
			}
				
	    }

}
