/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//package testelertag;

/**
 *
 * @author Soiuz
 */

import java.io.*;
import java.net.URL;


public class LerTags {  
	
	String sArmazenaTagDoArq = "";		// Armazena Texto lido do arquivo
	String sArmazenaCodFte = "";		// Armazena Cod.Fte da Pág.lida
	

    public String CarregueTagToMemoria(String sURL) throws IOException {
        
        /*
         * Lê codigo fonte da pagina(URL) e memoriza em variável(String)
         */
               
          URL url = new URL(sURL);
          
          // Carrega Tag da URL 
          BufferedReader LeTag = new BufferedReader(new InputStreamReader(url.openStream()));
                 
          String inputLine;
          while ((inputLine = LeTag.readLine()) != null)
          {
              // Armazena em uma String(fica interno ao ctrl do programa)
              sArmazenaCodFte = sArmazenaCodFte + "\n";		// Pula linha
              sArmazenaCodFte = sArmazenaCodFte + inputLine;	// Aramzena Linha
              
          }
          LeTag.close();
          
          return sArmazenaCodFte;
          
      }   // final do método 
    
     
    
    public void CarregueTagToConsole(String sURL) throws IOException {
        
        /*
         * Lê codigo fonte da pagina e salva no console
         */
         
          URL url = new URL(sURL);
          
          // Carrega Tag da URL 
          BufferedReader LeTag = new BufferedReader(new InputStreamReader(url.openStream()));
         
          // Salva Tags no console
          BufferedWriter EscreveTag = new BufferedWriter(new OutputStreamWriter(System.out));
  		        
          String inputLine;
          while ((inputLine = LeTag.readLine()) != null)
          {
              
              // Grava pagina console
              EscreveTag.write(inputLine);
              EscreveTag.newLine();           
              
          }
          LeTag.close();
        
          EscreveTag.flush();
          EscreveTag.close();
          
    }   // final do método 
    
    
    public void CarregueTagToArqTXT(String sURL, String sNomeArq) throws IOException {
        
        /*
         * Lê codigo fonte da pagina(URL) e salva em sNomeArq.txt
         */
          
          File fCodFte = new File(sNomeArq);       
          URL url = new URL(sURL);
          
          // Carrega Tag da URL 
          BufferedReader LeTag = new BufferedReader(new InputStreamReader(url.openStream()));
          
  		// Salva Tags em arquivo texto passado em: sNomeArq
          BufferedWriter EscreveTag = new BufferedWriter(new FileWriter(fCodFte));
          
          String inputLine;
          while ((inputLine = LeTag.readLine()) != null)
          {
              // Imprime página no console
          	// System.out.println(inputLine);
          
  			// Grava pagina no arquivo e/ou console
        	  EscreveTag.write(inputLine);
        	  EscreveTag.newLine();
              
          }
          LeTag.close();
          EscreveTag.flush();
          EscreveTag.close();
          
      }   // final do método 
    
    public String PegueTagDoArquivo(String sNomeArq) throws IOException {
        
        /*
         * Lê codigo Tags do arquivo.txt(sNomeArq)
         */
   
          File fLerTag = new File(sNomeArq);  
          FileReader reader = new FileReader(fLerTag);  
          BufferedReader leitor = new BufferedReader(reader);  
    
          while ((sArmazenaTagDoArq = leitor.readLine()) != null) {  
              if (sArmazenaTagDoArq.contains("<div") && sArmazenaTagDoArq.contains("</div>")) {  
            	  sArmazenaTagDoArq = sArmazenaTagDoArq.replaceAll("<div", "");  
            	  sArmazenaTagDoArq = sArmazenaTagDoArq.replaceAll("</div>", "");  
                  System.out.println(sArmazenaTagDoArq);  
    
              } // if
              
          }	// While
          
          return sArmazenaTagDoArq;
          
      }   // final do método 
    
    
    public String FiltrarTag(String sListaTags, String sTagIni, String sTagFim){
	
        /*
         * Decode Tag
         * Retorna linha da Tag localizada, passada como parâmetro: sTagIni, stagFim
         */
   
    	String sLinRes ="";
    	String sLinTag[] = sListaTags.split("\n"); 
     	int iTam = sLinTag.length;
     	
     	for(int iL=0; iL<iTam; iL++){
     		if ( sLinTag[iL].toLowerCase().contains(sTagIni.toLowerCase()) ) {
     			sLinRes = sLinTag[iL];
     		}
     			
     	}

     	String sLinDecode = DecodeTag(sLinRes, sTagIni, sTagFim);
     	
     	return sLinDecode;
     	
      }   // final do método 
    
    public String DecodeTag(String sLinTag, String sTagIni, String sTagFim){
    	
    	int iTamFiltro = sTagIni.length();
    	String sRes = sLinTag.substring(sLinTag.indexOf(sTagIni) + iTamFiltro, sLinTag.indexOf(sTagFim) - 1);
    	return sRes;
    	
    }

}  