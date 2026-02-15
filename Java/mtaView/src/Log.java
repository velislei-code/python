
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.util.Date;  
import java.text.SimpleDateFormat;
import java.lang.String;

public class Log {

  // Pega data do sistema
    private Date dData = new Date();  
    private SimpleDateFormat DiaMes = new SimpleDateFormat("ddMMM");  			// Formato: 05Jun	
    private SimpleDateFormat FormataData = new SimpleDateFormat("HH:mm:ss");	// Formata hora em: 16:10:06
	    
    static int iTotalLin = 1000;	
	boolean bAtivarLogMet = true;
	boolean bAtivarLogVar = true;
	int iNumRastro = 0;
	int iNumLogVar = 0;
	String sRastroMtd = new String();
	String sMemLog = "";

	
	
	
	public void Metodo(String sRastro){
		
			// Graficos().Desenhe linhas - 16)
			String sParteDoLog =sRastro.substring(0);	//	 sRastro.substring(0, sRastro.length() - 10);
			// String sParteDoLog = "";// sRastro.substring(-1);	
			// sRastro = sRastro.substring(1, 3);
			String sAgora = FormataData.format(dData);
			
			
			if(iNumRastro == 0){
				Mtd_GravarTXT("----------------------------------------------------------------");			// Separador	
			}
	    	if(bAtivarLogMet){     		
	    		
	    		// Ver se linha não é repetida
	    		if(!sMemLog.contains(sParteDoLog) ){
	    			sMemLog = sRastro;
	    			
	    			if(sRastro == ""){
	    				Mtd_GravarTXT(sRastro);			// Grava
	    			}else{
	    				Mtd_GravarTXT(sAgora + "   " + sRastro);			// Grava		    			
	    				iNumRastro++;
	    			}
	    		}
	    		
	    	}
	    	
	    	
	}


	public boolean Mtd_GravarTXT(String sTexto){
		
		// java.io.*;		
		
		String sHoje = DiaMes.format(dData);
		File arquivo = new File("Log_" + sHoje + ".txt");	
		
		
		try {
	 
			if (!arquivo.exists()) {
				//cria um arquivo (vazio)
				arquivo.createNewFile();
			}	
			
				//Escreve no arquivo
				FileWriter fw = new FileWriter(arquivo, true); 
				BufferedWriter bw = new BufferedWriter(fw);				
				
				
					bw.write(sTexto); 
					bw.newLine();
				
				
				bw.close();
				fw.close();
				
				return true;
			
		} catch (IOException ex) {
			ex.printStackTrace();
			return false;
		}
		

		//caso seja um diretório, é possível listar seus arquivos e diretórios
		//File[] arquivos = arquivo.listFiles(); 

	}

	public void Var(String sVar){
		 
    	if(bAtivarLogVar){	    			
    			Mtd_GravarLogVarTXT(iNumLogVar + "[" + iNumRastro + "]: " + sVar);			 			
    			iNumLogVar++;    		
    	}
    }


public boolean Mtd_GravarLogVarTXT(String sTexto){
	
	// java.io.*;		
	
	String sHoje = DiaMes.format(dData);
	File arquivo = new File("Log/LogVar_" + sHoje + ".txt");	
	
	
	try {
 
		if (!arquivo.exists()) {
			//cria um arquivo (vazio)
			arquivo.createNewFile();
		}	
		
			//Escreve no arquivo
			FileWriter fw = new FileWriter(arquivo, true); 
			BufferedWriter bw = new BufferedWriter(fw);		
			bw.write(sTexto); 
			bw.newLine();			
			bw.close();
			fw.close();
			
			return true;
		
	} catch (IOException ex) {
		ex.printStackTrace();
		return false;
	}
	

	//caso seja um diretório, é possível listar seus arquivos e diretórios
	//File[] arquivos = arquivo.listFiles(); 

}

}
