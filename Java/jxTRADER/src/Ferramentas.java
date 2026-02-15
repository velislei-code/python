import java.io.BufferedWriter;
import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.util.Date;  
import java.text.DecimalFormat;
import java.text.NumberFormat;
import java.text.SimpleDateFormat;

import javax.swing.JTable;

import com.nikhaldimann.inieditor.IniEditor;


public class Ferramentas {

	  // Pega data do sistema
    Date dData = new Date();  
    SimpleDateFormat DiaMes = new SimpleDateFormat("ddMMM");  // Formato: 05Jun
    CxDialogo objCxD = new CxDialogo();
    Log objLog = new Log();
    Definicoes objDef = new Definicoes();
    
    // Controla status dos 4 modens(0 a 3)
    boolean bSinc[] = {false, false, false, false};
    boolean bAuth[] = {false, false, false, false};
    boolean bPing[] = {false, false, false, false};
    
    /*
    static int iSeqEmTeste = 0;						// Controla sequencia corrente em teste(Md 1 a 4, 5a8, 9a12, etc) 
    public void FixeSeqEmTeste(int iS){  iSeqEmTeste = iS; }
    public int PegueSeqEmTeste(){  return iSeqEmTeste; }
  	*/
    
    int iLinEmTeste[] = {0, 1, 2, 3};			// Linha em teste
    int iLinMd[] = {0, 1, 2, 3};				// Linha inicial dos modens
    String sCapturaCom[] = {"","","",""};		// captura de texto do TArea-telnet
    String sCapturaComAnt[] = {"","","",""};	// captura de texto-anterior do TArea-telnet
    
    // Repositório para aramazenar linha que vai ser excluida
    String[] sDesfazerExcluir = new String[]{"", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", ""};
    int iLinExcluida = 0;						// memorizar linha excluida
	boolean bDesfazer = false;					// Informa que há registros a recuperar, ou não
    
    public boolean SalvarCSV(String sTexto){
		
		objLog.Metodo("Ferramentas().SalvarCSV()");
		// java.io.*;		
		
		String sHoje = DiaMes.format(dData);
		File arquivo = new File("ArqCSV" + sHoje + ".csv");	
		
		
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

	public int SeqToLin(int iSeq, int iModem){
		/*
		 * Retorna numero da linha, em que modem esta conectado
		 * cfe modem e a sequencia de testes informada
		 * Modens 0 a 3	 
		 */

		int iLinMd=0;
		int iLin = 0;
		iLin = iSeq *4;
		/*
		 * 4x0=0
		 * 4x1=4
		 * 4x2=8
		 * ...
		 * 4x10=40 
		 */
		
		switch(iModem){
			case 0: iLinMd = iLin; break;
			case 1: iLinMd = iLin +1; break;
			case 2: iLinMd = iLin +2; break;
			case 3: iLinMd = iLin +3; break;
		}
		
		objLog.Metodo("Ferramentas().SeqToLin(" + iSeq +", " + iModem + "): " + iLinMd);
		
		return iLinMd;   // Retorna numero da linha na tabela em modem esta conectado 
		
	}
	
	public String LinToSeqMd(int iLinAtual){
		/*
		 * Retorna numero da linha, em que modem esta conectado
		 * cfe modem e a sequencia de testes informada
		 * Modens 0 a 3	 
		 */
		objLog.Metodo("Ferramentas().LinToMd(): iLinAtual: " + iLinAtual); 
		
		int iSeq = (int)iLinAtual/4;
		objLog.Metodo("Ferramentas().LinToMd(): iSeq: " + iSeq );
		
		int iMd = (iLinAtual - (iSeq*4));		
		objLog.Metodo("Ferramentas().LinToMd(): iMd: " + iMd );

		String sRes = "SEQ" + iSeq +", MD" + iMd;
		objLog.Metodo("Ferramentas().LinToMd(" + iLinAtual + "): " + sRes);
		
		return sRes;   // Retorna numero da linha na tabela em modem esta conectado 
		
	}
	
	public String NumToChar(int iN){
		
		// if(iN < 3) { objLog.Metodo("Ferramentas().NumToChar()...n"); }
		
		String sRes = "";
		iN++;		// Inc.p/.pegar a partir de Zero
		switch(iN){
			case 1: sRes = "A"; break;
			case 2: sRes = "B"; break;
			case 3: sRes = "C"; break;
			case 4: sRes = "D"; break;
			case 5: sRes = "E"; break;
			case 6: sRes = "F"; break;
			case 7: sRes = "G"; break;
			case 8: sRes = "H"; break;
			case 9: sRes = "I"; break;
			case 10: sRes = "J"; break;
			case 11: sRes = "K"; break;
			case 12: sRes = "L"; break;
			case 13: sRes = "M"; break;
			case 14: sRes = "N"; break;
			case 15: sRes = "O"; break;
			case 16: sRes = "P"; break;
			case 17: sRes = "Q"; break;
			case 18: sRes = "R"; break;
			case 19: sRes = "S"; break;
			case 20: sRes = "T"; break;
			case 21: sRes = "U"; break;
			case 22: sRes = "V"; break;
			case 23: sRes = "W"; break;
			case 24: sRes = "X"; break;
			case 25: sRes = "Y"; break;
			case 26: sRes = "Z"; break;
			case 27: sRes = "AA"; break;
			case 28: sRes = "AB"; break;
			case 29: sRes = "AC"; break;
			case 30: sRes = "AD"; break;
			case 31: sRes = "AE"; break;
			case 32: sRes = "AF"; break;
			case 33: sRes = "AG"; break;
			case 34: sRes = "AH"; break;
			case 35: sRes = "AI"; break;
			case 36: sRes = "AJ"; break;
			case 37: sRes = "AK"; break;
			case 38: sRes = "AL"; break;
			case 39: sRes = "AM"; break;
			case 40: sRes = "AN"; break;
			case 41: sRes = "AO"; break;
			case 42: sRes = "AP"; break;
			case 43: sRes = "AQ"; break;
			case 44: sRes = "AR"; break;
			case 45: sRes = "AS"; break;
			case 46: sRes = "AT"; break;
			case 47: sRes = "AU"; break;
			case 48: sRes = "AV"; break;
			case 49: sRes = "AW"; break;
			case 50: sRes = "AX"; break;
			case 51: sRes = "AY"; break;
			case 52: sRes = "AZ"; break;
	
		}
		return (sRes);
	}
	
	public int ContarReg(JTable jtTabela){
	/*
	 * Conta numero de registros na Planilha procurando na Data: 20XX	
	 */
		
		// objLog.Metodo("Ferramentas().ContarReg()");
		
		Definicoes objDef = new Definicoes();		
		int iContaReg = 0;	
		
		int iL = 0;
		boolean bContem20 = true;
	    while (bContem20) {
	    	//if(jtTabela.getValueAt(iL, iC) != ""){	iContaReg = iL;	}
			if(jtTabela.getValueAt(iL, objDef.colDATA).toString().contains("20")){	
				bContem20 = true;
				iContaReg++;	
			}else{
				bContem20 = false;
			}
			//objLog.Metodo("Ferramentas().ContarReg().Contem: "+jtTabela.getValueAt(iL, 0).toString()+")");
			iL++;

	    }
		
		//objLog.Metodo("Ferramentas().ContarReg() = " + iContaReg );
//		objCxD.Aviso("Total de linhas na tabela: " + iContaReg, true);
		

		return iContaReg;
		
	}

	public int ContarReg_old(JTable jtTabela){
		
		objLog.Metodo("Ferramentas().ContarReg()");
		
		Definicoes objDef = new Definicoes();		
		int iContaReg = 0;
		
		for(int iL=0; iL < objDef.pegueTotalLinTab(); iL++){			
		//	for(int iC=0; iC < objDef.iTotColuna; iC++){
				
				//if(jtTabela.getValueAt(iL, iC) != ""){	iContaReg = iL;	}
				if(jtTabela.getValueAt(iL, 0).toString().contains("6")){	iContaReg++;	}
				objLog.Metodo("Ferramentas().ContarReg().Contem: "+jtTabela.getValueAt(iL, 0).toString()+")");
				
			}
		//}
		
		objLog.Metodo("Ferramentas().ContarReg() = " + iContaReg );
	//	objCxD.Aviso("Total de linhas na tabela: " + iContaReg, true);
		
	
		return iContaReg;
		
    }
	
	public String FormatePing(String sPing){
		
		String sRes = "";
		// Success rate is 100 percent (5/5)
		if(sPing.toLowerCase().contains("success")){
			
			if(sPing.contains("5/5")){ sRes = "Taxa de sucesso 100% (5/5)."; }
			if(sPing.contains("4/5")){ sRes = "Taxa de sucesso 80% (4/5)."; }
			if(sPing.contains("3/5")){ sRes = "Taxa de sucesso 60% (3/5)."; }
			if(sPing.contains("2/5")){ sRes = "Taxa de sucesso 40% (2/5)."; }
			if(sPing.contains("1/5")){ sRes = "Taxa de sucesso 20% (1/5)."; }
			if(sPing.contains("0/5")){ sRes = "Taxa de sucesso 0% (0/5)."; }
			
		}
		
		//"4 packets transmitted, 4 packets received, 0% packet loss",
		if(sPing.toLowerCase().contains("packets")){
			if(sPing.contains("0%")){ sRes = "Taxa de sucesso 100% (5/5)."; }
			if(sPing.contains("25%")){ sRes = "Taxa de sucesso 80% (4/5)."; }
			if(sPing.contains("50%")){ sRes = "Taxa de sucesso 60% (3/5)."; }
			if(sPing.contains("75%")){ sRes = "Taxa de sucesso 40% (2/5)."; }
			if(sPing.contains("100%")){ sRes = "Taxa de sucesso 100% (0/5)."; }
		}
		
		return sRes;
	}
	
	public String AjusteTempo(int iModem, int iAjuste, int iSeg, int iMin){
		
		/*
		 * Retorna tempo com iAjuste a menos no tempo
		 * Devido leitura de modens serem 1, 15, 30 e 45 segundos
		 * Converte tempo, considerando que todos sincronizaram a iAjuste atrás
		 */
		int iM = 0;
		int iS = 0;
		
		
		objLog.Metodo("Ferramentas().AjusteTempo( Md: " + iModem + ", Aj: "+iAjuste+", iS: "+iSeg+", iM: "+ iMin +" )") ;
			int iTSeg = (iMin * 60) + iSeg;		// Converte tudo em segundos
			objLog.Metodo("Ferramentas().AjusteTempo( iTSeg = (iMin * 60) + iSeg : "+iTSeg+" )");
			
			iS = iTSeg - (iAjuste * iModem);	// Diminui os segundos de cada Leitura de modem(as leituras são feitas com 15 segundos de diferença)
			objLog.Metodo("Ferramentas().AjusteTempo( iS = iTSeg - (iAjuste * iModem): "+iS+" )");
			
			if(iTSeg >= 60) { 
				
				double dM = iTSeg / 60; 
				objLog.Metodo("Ferramentas().AjusteTempo( dM = iTSeg / 60: "+dM+" )");
			
				iM = (int)(dM);					// Pega a parte interira de minutos
				objLog.Metodo("Ferramentas().AjusteTempo( iM = (int)(dM): "+iM+" )");
				
				iS = (int)((dM - iM)*60);		// Converte parte fracionada para int - Pega segundos
				objLog.Metodo("Ferramentas().AjusteTempo( iS = (int)((dM - iM)*60): "+iS+" )");
			
			}
			
				
			// Converte valores para String, formatado
			NumberFormat formatter = new DecimalFormat("00");
			String sMinAj = formatter.format(iM);
			String sSegAj = formatter.format(iS);
			
			String sTAjustado = sMinAj+":"+sSegAj;

			objLog.Metodo("Ferramentas().AjusteTempo() = " + sTAjustado);

			return sTAjustado;
	}
	
	public int HoraToSeg(String sHx){
		
		objLog.Metodo("Ferramentas().HoraToSeg(" + sHx +")");
		
		// Coverte Hora para Segundos(int)
		int iSegRes = 0;
		int iSeg = 0;
		int iMin = 0;
		int iHora = 0;
		
		String sH = "0";
		String sM = "0";
		String sS = "0";
		
		int iTam = sHx.length();		// pega tamanho
		objLog.Metodo("Ferramentas().HoraToSeg(" + sHx +").Tam: "+iTam);
		
		if(iTam == 8){ 
			objLog.Metodo("Ferramentas().HoraToSeg(" + sHx +").T=8");
			sH = sHx.substring(0, 2);
			sM = sHx.substring(0, 2);
			sS = sHx.substring(3, 2);

		}		// 00:00:00
		
		if(iTam == 5){	// 00:00 
			objLog.Metodo("Ferramentas().HoraToSeg(" + sHx +").T=5");
			sM = sHx.substring(0, 2);
			sS = sHx.substring(3, 5);	
			
			objLog.Metodo("Ferramentas().HoraToSeg(" + sHx +"), sM: "+sM+", sS: "+sS);
		}		
		if(iTam == 2){	// 00
			objLog.Metodo("Ferramentas().HoraToSeg(" + sHx +").T=2");
			sS = sHx; 
		}		
			
			
		iSeg = Integer.parseInt(sS);
		iMin = Integer.parseInt(sM);
		iHora = Integer.parseInt(sH);
	
		
		iSegRes = (iHora*60)+(iMin*60)+iSeg;
		
		objLog.Metodo("Ferramentas().HoraToSeg(" + sHx +") = " + iSegRes);
		
		return iSegRes;
	}
	
	public String TempoRegressivo(int iTempoDeTeste, int iM, int iS){
		
		int iMin = 0;
		
		int iSegTstTot = iTempoDeTeste * 60;			// Converte Minutos de teste em segundos
		int iSegTot = (iM*60)+iS;
		int iSegRes = iSegTstTot - iSegTot;
		if(iSegRes > 60){
			double dMinRes = iSegRes/60;
			iMin = (int)dMinRes;
			iSegRes = iSegRes - (iMin*60);
		}

		NumberFormat formatter = new DecimalFormat("00");
		String sMin= formatter.format(iMin);
		String sSeg = formatter.format(iSegRes);

		String sTempo = "00:" + sMin + ":" + sSeg;
		return sTempo;
	
		
	}
	
	public String DoubleToHora(double dSeg){
	
		String sT = "0:00";	
	
		//Ajusta formato double para Min:Seg
		if(dSeg == 0.5) { sT = "0:30"; }
		if(dSeg == 1.0) { sT = "1:00"; }
		if(dSeg == 1.5) { sT = "1:30"; }
		if(dSeg == 2.0) { sT = "2:00"; }
		if(dSeg == 2.5) { sT = "2:30"; }
		if(dSeg == 3.0) { sT = "3:00"; }
		if(dSeg == 4.0) { sT = "4:00"; }
		if(dSeg == 5.0) { sT = "5:00"; }
		
		return sT;
		
	}	
	
	public void LerConfig() throws IOException{
		
		objLog.Metodo("Arquivos().LerConfig()");

		String sChave ="Config";
		String sDirArq = objDef.DirRoot + "config.ini";		// Chama SaveDialog, pega diretório
		
			String ValorRetorno = null;
			File fArquivo = new File(sDirArq);
			IniEditor ArqIni = new IniEditor(true);
			ArqIni.load(fArquivo);

		
			// Lê total de linhas no arquivo(iL = XX)
			int iTempoTst = Integer.parseInt( ArqIni.get(sChave,"TempoTst") );						
			int iTamTxtTelnet = Integer.parseInt( ArqIni.get(sChave,"TamTxtTelnet") );
			boolean bZoom =  Boolean.parseBoolean( ArqIni.get(sChave,"ZoomGf") );						
			objDef.FixeSimulacao( Boolean.parseBoolean( ArqIni.get(sChave,"Simulacao") ) );
			
			// new CxDialogo().Aviso("Arq.ini carregado: " + iTempoTst +", " + bSimula, true);

			// Fixa valores lidos de config
			objDef.FixeTempoTeste(iTempoTst);
			objDef.IncTamTexto(true, iTamTxtTelnet);	// Incrementar = true
			objDef.FixeGfZoom(bZoom);
			//objDef.fixeSimula(bSimula);
		
	}

	public String Criptografia(boolean bEncrypt, String sTexto, String sChave){
		
		
		/*
		 * A ideia desta criptografia é somar o valor ASCII de cada caracter do texto 
		 * com cada caracter da chave, assim fica:
		 *   TEXTO ABERTO A CRIPTOGRAFAR
		 *   
		 *        TEXTO.................
		 * C [C + T]
		 * H [H + E]
		 * A [A + X]    
		 * V [V + T]
		 * E [E + O]
		 * 	 
		 */
			// Coverte String em matriz Char - explode
			char[] cTexto = sTexto.toCharArray();  
			char[] cChave = sChave.toCharArray();
			
			String sTextoMix = "";
			int iMix = 0;
			char cMix;
			int iC =0;
			int iModMix = 0;
			
			
			// Executa loop For com tamanho do texto
				for(int iT=0; iT < sTexto.length(); iT++){		
					
					
					if(bEncrypt){	// EnCript
						
						// Soma valor ASCII de char(texto) com char(chave)
						iMix = (int)cChave[iC] + (int)cTexto[iT];
						
					}else{ // DeCript
						
						// Diminui valor ASCII de char(texto) de char(chave)
						iMix = (int)cChave[iC] - (int)cTexto[iT]; 	
					} 
					       
					iModMix = Math.abs(iMix);					// Pega valor absoluto(evita valores negativso)
					
					cMix = (char)iModMix;								// Converte codigo(Decimal) para ASCII
					sTextoMix = sTextoMix +  Character.toString(cMix);	// Remonta matriz de char´s
					
					iC++;	// Incrementa IC				
					//Se iC Passou do Tam.Chave... volta iC para Zero
					// length()-1 pois tava passando da matriz e trava				 
					if(iC > (sChave.length()-1) ){iC = 0; }	
				}
			
			
			return sTextoMix;
			
		}
	
	public void LimparTabela(JTable jtTabela){
		
		objLog.Metodo("ferramentas().LimparTabela()");
		
		int iNumLinTab = this.ContarReg(jtTabela); //jtTabela.getRowCount();	
		int iNumColTab = jtTabela.getColumnCount();	
		
		for(int iL=0; iL < iNumLinTab; iL++){
			for(int iC=0; iC < iNumColTab; iC++){
				jtTabela.setValueAt("", iL, iC);
			}
		}
		
    }
	
	public boolean CheckOperacao(String sCelula, String sTipo){
	
			
		//if(sTipo.contains(objDef.sOpScalp)){
			// Se celula contem indicador
			if( sCelula.contains(objDef.sOpScalp) ){
				return true;
			}else{
				return false;
			}
		//}		
	}
			
	
	public static boolean VerSeNumerico (String s) {  
	    try {  
	        Long.parseLong (s);   
	        return true;  
	    } catch (NumberFormatException ex) {  
	        return false;  
	    }  
	}  
	
	public int ConvertePlaca(String sPlaca){
		
		objLog.Metodo("Ferramentas().ConvertePlaca("+sPlaca+")");
		
		// Converte info de tipo de placa para inteiro
		if(sPlaca.contains("15")){ return 15; }
		else if(sPlaca.contains("16")){ return 16; }
		else if(sPlaca.contains("24")){ return 24; }
		else if(sPlaca.contains("31")){ return 31; }
		else if(sPlaca.contains("32")){ return 32; }
		else if(sPlaca.contains("48")){ return 48; }
		else if(sPlaca.contains("63")){ return 63; }
		else if(sPlaca.contains("64")){ return 64; }
		else if(sPlaca.contains("72")){ return 72; }
		else {return 32; }	// Default					
	}
	
	
	public String IndexToValCombo(int iIndex, int iQuem){
		/* 
		 * Retorna conteudo da Combo pela Index passad
		 */
		String sConteudo = "";
		
		
		
		
		return sConteudo;
		
	}
	
	
}	// Final da classe
