import java.io.File;
import java.io.IOException;
import javax.swing.JOptionPane;
import javax.swing.JTable;
import com.nikhaldimann.inieditor.*;

/*
 * Biblioteca inieditor-r5.jar
 * http://www.java2s.com/Code/Jar/i/Downloadinieditorr5sourcesjar.htm
 */
public class IniFiles{
/*
public static void main(String[] args) throws IOException {
	new IniFiles().EscreverIni("D:/configuracao.ini", "umc", "blog", "umcastec.blogspot.com");
	System.out.println(new IniFiles().LerIni("D:/configuracao.ini", "umc", "blog"));
}
*/
public void EscreverIni(String arquivo, String chave, String variavel, String valor) throws IOException{
    try {  
        File file = new File(arquivo);
    	IniEditor iniFile = new IniEditor(true);
    	iniFile.load(file);

    	iniFile.addSection(chave);
    	iniFile.set(chave, variavel, valor);

    	iniFile.save(file);
     } catch (IOException ex) {  
            JOptionPane.showMessageDialog(null, "Erro ao criar arquivo " + arquivo + " - E010i, " + ex);  
     } 
}

public void wIniTab(String arquivo, JTable jTabIni, int iTotLin) throws IOException{
    try {  
    	String chave = "Mta";
        File file = new File(arquivo);
    	IniEditor iniFile = new IniEditor(true);
    	iniFile.load(file);
    	iniFile.addSection(chave);
    	//-------------------------------------------------------------------
    	for(int iL=0; iL < iTotLin; iL++){
			for(int iC=0; iC < new Definicoes().iTotColuna; iC++){
				// Converte iC para Letra
				String sChave = new Ferramentas().NumToChar(iC) + String.valueOf(iL);			
		    	iniFile.set(chave, sChave, jTabIni.getValueAt(iL, iC).toString());
			}			
		}
    	
    	//-------------------------------------------------------------------
    	//iniFile.addSection(chave);
    //	iniFile.set(chave, variavel, valor);

    	iniFile.save(file);
     } catch (IOException ex) {  
            JOptionPane.showMessageDialog(null, "Erro ao criar arquivo " + arquivo + ", " + ex);  
     } 
}

public String LerIni(String arquivo, String chave, String variavel) throws IOException{
	
	
	//try{
		String ValorRetorno = null;
		File file = new File(arquivo);
		IniEditor iniFile = new IniEditor(true);
		iniFile.load(file);

		ValorRetorno = iniFile.get(chave, variavel);
		
		
		
	 //} catch (IOException ex){  
      //   JOptionPane.showMessageDialog(null, "Erro ao ler arquivo " + arquivo + ", " + ex);  
	// } finally{
		 return ValorRetorno; 
	// }


}
}