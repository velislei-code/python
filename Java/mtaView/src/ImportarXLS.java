
import java.io.File;
import java.io.IOException;

//import com.sun.istack.internal.logging.Logger;

import jxl.Cell;
import jxl.Sheet;
import jxl.Workbook;
import jxl.read.biff.BiffException;

/*
 * JRE System Library <botão dir.mouse>
 * Build-path -> Config build path 
 * Add external JARs
 * Java_excel_aoi -> jxl.jar
 * 
 */

public class ImportarXLS {
   
	/*
	 * Abre arquivo Excel, Lê celulas, memoriza em matriz, retorna matriz 
	 */
	
	Log objLog = new Log();
	public String[][] sCel;

	
	
    public String[][] lerExcel() throws BiffException, IOException
    {
    	Arquivos objArq = new Arquivos();	
    	
     	
    	String sDir = objArq.DialogAbrir("xls");
    	
    	objLog.Metodo("ImportarXLS().lerExcel("+ sDir +")");
    	
    	/* Carrega a planilha */
    	 Workbook objLivroDeTrabalho = Workbook.getWorkbook(new File(sDir));
        
    	 

        /*  Aqui é feito o controle de qual aba do xls 
        *   será¡ realiza a leitura dos dados
        */

        Sheet sheet = objLivroDeTrabalho.getSheet(0);
        
        /* Numero de linhas com dados do xls */
        int iLin = sheet.getRows(); 
        int iCol = sheet.getColumns();
        
        //sCelulas[10][0] = String.valueOf(iLin);
        //sCelulas[10][1] = String.valueOf(iLin);
        
        for(int iL = 0; iL < iLin; iL++){
            for(int iC = 0; iC < iCol; iC++){
                Cell celula = sheet.getCell(iC, iL);
                sCel[iC][iL] = celula.getContents().toString();
                objLog.Metodo("ImportarXLS.Cel["+iC+"]["+iL+"]: " + sCel[iC][iL]);
                
            }            
        }  
       
        return sCel;
        
    }

    
   
 
}   