//package mtaview;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileReader;
//import java.io.FileFilter;
import java.io.FileWriter;
import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.Date;

import javax.swing.JFileChooser;
import javax.swing.JFrame;
import javax.swing.JOptionPane;
import javax.swing.JTable;
import javax.swing.JTextField;
import javax.swing.filechooser.FileNameExtensionFilter;
import javax.swing.table.DefaultTableModel;

import com.nikhaldimann.inieditor.IniEditor;

import java.io.FileInputStream;
import java.io.InputStreamReader;
import java.io.LineNumberReader;
/* MANIPULAÇÃO DE ARQUIVOS INI 
*
* import java.io.File;
* import java.io.IOException;
* import javax.swing.JOptionPane;
* import javax.swing.JTable;
* 
* import com.nikhaldimann.inieditor.*;
* 	
* Biblioteca inieditor-r5.jar
* http://www.java2s.com/Code/Jar/i/Downloadinieditorr5sourcesjar.htm
*/

public class Arquivos extends JFrame {
	
  private mtaView FrmPrincipal;
	
  private JTextField NomeArq = new JTextField(), Diretorio = new JTextField();  
  private Log objLog = new Log();
  private Definicoes objDef = new Definicoes();
  private Ferramentas objUtil = new Ferramentas();
  private CxDialogo objCxD = new CxDialogo();
  
//Pega data do sistema
  private Date dData = new Date();  
  private SimpleDateFormat Ano = new SimpleDateFormat("YYYY");  			// Formato: 05Jun	

  
	/*
	 *  Cria uma var do FormPrincipal, instancia, torna herdeiro	
	 * O Cmd abaixo deveria mas não funcionou....
	 * 		private mtaView mtaFrmPrincipal;
	 *  	mtaFrmPrincipal.FixeLinAtual(0);
	 *  
	 * bTabAlterada criada para acessar info, a partir do FrmPrincipal e lá alterar, 
	 * pois Não consegui alterar valor da LinAtual a partir do FrmOpc(daqui para lá)
	 */	
	static boolean bTabAlterada = false;	
	public void FixeTabAlterada(boolean bT){ bTabAlterada = bT; }
	public boolean PegueInfoTabAlterada(){ return bTabAlterada; }
	 
	static String sAbreDirArq = null;
	public void FixeAbreDirArq(String sD){ 
		objLog.Metodo("Arquivos(Loc1010a).FixeAbreDirArq("+sD+")");
		sAbreDirArq = sD; 
	}
	public String PegueAbreDirArq(){
		objLog.Metodo("Arquivos(Loc1010b).PegueAbreDirArq()->"+sAbreDirArq);
		return sAbreDirArq;		
	}


  public Arquivos() {
	 // Contrutor
  }


  public String DialogAbrir(String sExtencao){
	  
	  objLog.Metodo("Arquivos(Loc1011a).DialogAbrir("+ sExtencao +")");
	  
	  JFileChooser objFileC = new JFileChooser(new File(System.getProperty("user.home") + File.separator + "Documents" + File.separator + objDef.DirDocJxt));	// Objeto SaveDialog
	  //JFileChooser objFileC = new JFileChooser();	// Objeto de OpenDialog
	
	  //objLog.Metodo("2-Arquivos().DialogAbrir(): " + objFileC.getFileView().toString());
	  
	  if(sExtencao == "jxt"){		  
		  	FileNameExtensionFilter FiltrarExtencao = new FileNameExtensionFilter("Arquivos jxt(*.jxt)", "jxt"); 
		  	objFileC.setFileFilter(FiltrarExtencao);		// Filtrar extenção
		  
	  }
	  if(sExtencao == "txt"){		  
		  	FileNameExtensionFilter FiltrarExtencao = new FileNameExtensionFilter("Arquivos txt(*.txt)", "txt"); 
		  	objFileC.setFileFilter(FiltrarExtencao);		// Filtrar extenção
		  
	  }
	  if(sExtencao == "csv"){		  
		  	FileNameExtensionFilter FiltrarExtencao = new FileNameExtensionFilter("Arquivos csv(*.csv)", "csv"); 
		  	objFileC.setFileFilter(FiltrarExtencao);		// Filtrar extenção
		  
	  } 
	  if( (sExtencao != "csv")&&(sExtencao != "txt")&&(sExtencao != "jxt") ){	 
		  FileNameExtensionFilter FiltrarExtencao = new FileNameExtensionFilter("Arquivos excel(*.xls)", "xls");
		  objFileC.setFileFilter(FiltrarExtencao);		// Filtrar extenção
		 
	  }
	  
     
      // Mostrar "Abrir" dialogo:
    	int  iValorRet = objFileC.showOpenDialog(Arquivos.this);
   
    if (iValorRet == JFileChooser.APPROVE_OPTION) {    	  
        NomeArq.setText(objFileC.getSelectedFile().getName());
        Diretorio.setText(objFileC.getCurrentDirectory().toString());
       
      }
      
      if (iValorRet == JFileChooser.CANCEL_OPTION) {
        NomeArq.setText("#Null");
        Diretorio.setText("");
       
      }
      
      String sArquivo = Diretorio.getText() + "\\" + NomeArq.getText();   
     
      return sArquivo;
    }
 
    
  public String DialogSalvar(String sExtencao, String sNomeArq){
	  
	  objLog.Metodo("Arquivos().DialogSalvar(" + sExtencao + ", "+ sNomeArq + ")");
	  
	  boolean bArquivoDuplicado = false;
	  String sArquivo = null;
	  //  JFileChooser chooser = new JFileChooser("/caelum/cursos/16");
	  // SetarDir padrão: 
	  //JFileChooser(new File(System.getProperty("user.home")+File.separator+"Downloads"));	// Objeto SaveDialog
	  
	  JFileChooser objFileC = new JFileChooser(new File(System.getProperty("user.home") + File.separator + "Documents" + File.separator + objDef.DirDocJxt));	// Objeto SaveDialog 
	  
	 // objLog.Metodo("Arquivos().DialogAbrir(): " + objFileC.getFileView().toString());
	  
	  if(sExtencao == "jxt"){ 
		  	FileNameExtensionFilter FiltrarExtencao = new FileNameExtensionFilter("Arquivos jxt(*.jxt)", "jxt");
			objFileC.setToolTipText("PrjAnaliseDados.jxt"); 
		  	objFileC.setFileFilter(FiltrarExtencao);		// Filtrar extenção  
		  	//objFileC.setName("");
		  	//objFileC.setInitialFileName("open.txt");
		  //	objFileC.setName("Proj.mta");
		  //	((Object) objFileC).setInitialFileName(".torrent");
		  
		  	
	  }else{ 
		  FileNameExtensionFilter FiltrarExtencao = new FileNameExtensionFilter("Arquivos excel(*.csv)", "csv");
		  objFileC.setFileFilter(FiltrarExtencao);		// Filtrar extenção
		//  objFileC.setName("Proj.mta");
	  }
	  
	  
      
  
		  // Mostrar "Save" dialog:
		  int iValorRet = objFileC.showSaveDialog(Arquivos.this);
		  if (iValorRet == JFileChooser.APPROVE_OPTION) {
			  NomeArq.setText(objFileC.getSelectedFile().getName());
			  Diretorio.setText(objFileC.getCurrentDirectory().toString());
		  }
		  if (iValorRet == JFileChooser.CANCEL_OPTION) {
			  NomeArq.setText("#Null");	// Se Cancelou, fixa valor de NomeArq como: "cancelado", o # é usado para testar cancelamento
			  Diretorio.setText("");
		  }
		  
		  // Formata diretório, sArquivo de retorno
		  sArquivo = Diretorio.getText() + "\\" + NomeArq.getText();       
		  
		  return sArquivo;
	  
    }
  
  
  
  
  public void SalvarCsv(JTable jtTabela, boolean bLicenca){
	  objLog.Metodo("Arquivos().Salvar()");
	  
	  // Se Licença do software OK, continua...
	  if(bLicenca){
		  FormatarCsv(jtTabela, bLicenca);	// Chama método: Formata CSV, e Grava em Arq.txt
	  }else{
	    	 objCxD.Aviso("Erro ao criar arquivo: "+objDef.DirDocuments+" - [eL102a],", objDef.bMsgErro);  
	    		
	    	 //end Licença
		}	  
  }
 
  
  
  public boolean GravarTxt(String sArquivo, String sTexto){
		
	  // Salva texto em fArquivo, no diretório passado como caminho
		// java.io.*;		
	  objLog.Metodo("Arquivos().GravarTxt()");
	
		File fArquivo = new File(sArquivo);		
		try {	 
			if (!fArquivo.exists()) {			
				fArquivo.createNewFile();		//cria um fArquivo (vazio)
			}	
			
				//Escreve no fArquivo
				FileWriter fwEscrever = new FileWriter(fArquivo, true); 
				BufferedWriter bwArmazenar = new BufferedWriter(fwEscrever);				
				bwArmazenar.write(sTexto); 
				bwArmazenar.newLine();
				bwArmazenar.close();
				fwEscrever.close();
				
				return true;
			
		} catch (IOException ex) {
			ex.printStackTrace();
			return false;
		}
	}
  
  public boolean GravarTxtSimples(String sNomeArq, String sTexto){
		
	  objLog.Metodo("Ferramentas().GravarTXTSimples("+ sNomeArq +", sTexto... )");
		 
		// java.io.*;		
		
		File arquivo = new File(sNomeArq);	
		
		
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

  	public String[] LerTxt(String sNomeArq){
		
		objLog.Metodo("Arquivos().LerTxt("+sNomeArq+")");

		String vLinha[] = new String[100000];  
		
		int iL = 0;
	 	try { 
			FileReader arq = new FileReader(sNomeArq); 
			BufferedReader lerArq = new BufferedReader(arq); 
			String sLin = lerArq.readLine(); // lê a primeira linha // a variável "linha" recebe o valor "null" quando o processo // de repetição atingir o final do arquivo texto
			while (sLin != null) { 
				vLinha[iL] = lerArq.readLine(); // lê da segunda até a última linha
				objLog.Metodo("LerTxt: " + vLinha[iL]);
				iL++;
			} 
			arq.close();
			
			return vLinha;
		} catch (IOException e) { 
			System.err.printf("Erro na abertura do arquivo: %s.\n", e.getMessage()); 
			return vLinha;
		} 
	 	//ba 199.376.408 migra catmb630/31
	}
  	

	public void CarregarCSV(JTable jtTabela, String sDirArq, boolean bLicenca) throws IOException{
		
		objLog.Metodo("Arquivos().CarregarCSV(" + sDirArq + ")");
		
					
		String vLinha[] = new String[100000]; 
		String vCellNaLin[] = new String[50];
		
		int iLinTab = 0;		// Ctrl linhas da tabela
		int iLinTxt = 0;	// Linhas do arquivo iniciam no parametro passado
		
		// Se licença OK, abre dialog para carregar arquivo.jxt
		if(bLicenca){

			if((sDirArq == null)||(sDirArq == "")){
				sDirArq = DialogAbrir("csv");		// Chama DialogAbrir, pega diretório	
			}
		
		}else{ // Se licença NOK, manda para um arquivo vazio(Documents)
			sDirArq = objDef.DirDocuments;
		}
		
		// Testa retorno de Dir(# = Sinal de cancelar)
		if( sDirArq.indexOf('#') < 0){
			
			FixeAbreDirArq(sDirArq);		// Seta valor de Dir para info ser acessada pelo FrmPrincipal
			String ValorRetorno = null;
			FileReader ArqCSV = new FileReader(sDirArq); 
			BufferedReader lerArq = new BufferedReader(ArqCSV); 
			String sLin = lerArq.readLine(); // lê a primeira linha // a variável "linha" recebe o valor "null" quando o processo // de repetição atingir o final do arquivo texto
			
			/************************************************************************************/
			
			//-------------------------------------------------------------------------
			// Apagar registros anteriores
			boolean bCarregarTab = false;
			int iTReg = objUtil.ContarReg(jtTabela);	// Conta numero de registros na tabela

			//String sParteArqAntigo = sMemPlanAtual.substring(sMemPlanAtual.length() - 13, sMemPlanAtual.length());
			
			/*
			 *  Testa se Planilha foi alterada... 
			 *  verifica se novo arquivo NÃO CONTEM parte do nome(ultimos 10 char) do antigo arquivo
			 */
			//if( !sDirArq.contains(sParteArqAntigo) ){			
	
				// Verifica NumReg, se registros > 1
				if( iTReg > 1){							
		
					// Se confirme = Sim
					if(objCxD.Confirme("Apagar dados da tabela atual?", objDef.bMsgExcluir) )
					{
						objUtil.LimparTabela(jtTabela);
						FixeTabAlterada(true);			// Info para o FrmPrincipal ajustar Linha inicial do teste
						bCarregarTab = true;
				
					}else{ bCarregarTab = false; }
				}else{ bCarregarTab = true; }
			//}
	    	if(bCarregarTab){

	    		// Lê total de linhas no arquivo(iL = XX)					
	    		int iTotalLin = this.ContarLinhasTXT(sDirArq);
	    	
	    		/*
	    		 * Seta para linha final, pois vai decrementar e carregar a Planilha de baixo para cima
	    		 * Colocando o último registro(mais atual) na primeira linha da planilha
	    		 */
	    		iLinTab = 0; //iTotalLin-2;	
	    		int iAvanco = 0;	// Avança qdo arquivo é Cru(download do metatrader)
	    		int iQtosCol = 0;	// numero de colunas na Planilha
	    		boolean bCheckCampo = true;
				//-------------------------------------------------------------------
				// Escreve dados das celulas
				while (sLin != null) { 	    		
									
					vLinha[iLinTxt] = lerArq.readLine(); // lê da segunda até a última linha
					
					vCellNaLin = vLinha[iLinTxt].split(";");  
					
					/*
					 *  Testa se celula 1 contem data(20xx) se sim é porque arquivo inicial.csv(download cotação metatrader)
					 *  se não, é porque é arquivo já trabalhado(exportado/salvo pelo jxTrader)
					 */
					if(bCheckCampo){
						if(vCellNaLin[0].contains("20")){ iAvanco = objDef.colDATA; }else{iAvanco = 0;}
						iQtosCol = vCellNaLin.length;
						bCheckCampo = false;	// só uma verificação, bloqueia nova verificação
						
					}
					for(int iC=0; iC < iQtosCol; iC++){	// iC tem o conteudo das celulas separadas por split(";")
						int iColTab = iC+iAvanco;
						jtTabela.setValueAt( vCellNaLin[iC].toString(), iLinTab, iColTab );    
					
					}
						
					objDef.fixeNumRegMetaTrader(iLinTab);  // informa numero de registros na tabela
										
					iLinTab++;	// Ctrl linhas de inserção da Planilha(de baixo para cima)
					iLinTxt++;	// Ctrl Linhas do arquivo.txt
				} 
				ArqCSV.close();
			
				
				
	    	}   
	    	
	    	SalvarConfig(sDirArq);	// Salva Dir Arq aberto em config.ini
			//-------------------------------------------------------------------	  
	    	
		}else{	objCxD.Aviso("Ação cancelada !", objDef.bMsgCancel);
			//	return null;
		}
			
		

	}
  
	
public String CarregarMetaT5(JTable jtTabela, String sDirArq, boolean bLicenca) throws IOException{
		
	/*
	 * Carrega Planilha com arquivo baixado(download cotação) do metaTrader.txt
	 */
		objLog.Metodo("Arquivos(Loc101a).CarregarMetaT5(" + sDirArq + ")");
					   
					
		String vLinha[] = new String[100000]; 
		String vCellNaLin[] = new String[50];
		
		int iLinTab = 0;		// Ctrl linhas da tabela
		int iLinTxt = 0;	// Linhas do arquivo iniciam no parametro passado
		
		// Se licença OK, abre dialog para carregar arquivo.jxt
		if(bLicenca){

			if((sDirArq == null)||(sDirArq == "")){
				sDirArq = DialogAbrir("csv");		// Chama DialogAbrir, pega diretório	
			}
		}else{ // Se licença NOK, manda para um arquivo vazio(Documents)
			sDirArq = objDef.DirDocuments;
		}
		
		
		// Testa retorno de Dir(# = Sinal de cancelar)
		if( sDirArq.indexOf('#') < 0){
			
			FixeAbreDirArq(sDirArq);		// Seta valor de Dir para info ser acessada pelo FrmPrincipal
			String ValorRetorno = null;
			FileReader ArqCsv = new FileReader(sDirArq); 
			BufferedReader lerArq = new BufferedReader(ArqCsv); 
			String sLin = lerArq.readLine(); // lê a primeira linha // a variável "linha" recebe o valor "null" quando o processo // de repetição atingir o final do arquivo texto
			
			/************************************************************************************/
			
			//-------------------------------------------------------------------------
			// Apagar registros anteriores
			boolean bCarregarTab = false;
			int iTReg = objUtil.ContarReg(jtTabela);	// Conta numero de registros na tabela

			//String sParteArqAntigo = sMemPlanAtual.substring(sMemPlanAtual.length() - 13, sMemPlanAtual.length());
			
			/*
			 *  Testa se Planilha foi alterada... 
			 *  verifica se novo arquivo NÃO CONTEM parte do nome(ultimos 10 char) do antigo arquivo
			 */
			//if( !sDirArq.contains(sParteArqAntigo) ){			
	
				// Verifica NumReg, se registros > 1
				if( iTReg > 1){							
		
					// Se confirme = Sim
					if(objCxD.Confirme("Apagar dados da tabela atual?", objDef.bMsgExcluir) )
					{
						objUtil.LimparTabela(jtTabela);
						FixeTabAlterada(true);			// Info para o FrmPrincipal ajustar Linha inicial do teste
						bCarregarTab = true;
				
					}else{ bCarregarTab = false; }
				}else{ bCarregarTab = true; }
			//}
	    	if(bCarregarTab){

	    	
	    		
	    		int iQtosCol = 0;	// numero de colunas na Planilha
	    		boolean bCheckCampo = true;
				//-------------------------------------------------------------------
				// Escreve dados das celulas
				while (sLin != null) { 	    		
									
					vLinha[iLinTxt] = lerArq.readLine(); // lê da segunda até a última linha
					
					// explode linha arq.metatrader em array
					vCellNaLin = vLinha[iLinTxt].split("\t"); 	// Arq.metaTrader5 é Separado por tabulação 
					
					if(bCheckCampo){
						iQtosCol = vCellNaLin.length;	// pega numero de colunas
						bCheckCampo = false; 			// consulta somente 1 vez e bloqueia
					}
			
					for(int iC=0; iC < iQtosCol; iC++){	// iC tem o conteudo das celulas separadas por split(";")
						
						int iColTab = iC+objDef.colDATA;	// Inicia na coluna data
						
						/* Erro, não carrega
						// Foramata data
						if(iColTab == objDef.colDATA){
							vCellNaLin[objDef.colDATA] = "SubStr()";// vCellNaLin[objDef.colDATA] + "]";//.replaceAll(".", "/") ;
						}*/
						
						jtTabela.setValueAt( vCellNaLin[iC].toString(), iLinTab, iColTab );    
						
					}
						
					objDef.fixeNumRegMetaTrader(iLinTab);  // informa numero de registros na tabela
					 								
					iLinTab++;	// Ctrl linhas de inserção da Planilha(de baixo para cima)
					iLinTxt++;	// Ctrl Linhas do arquivo.txt
					
					
				} 
				ArqCsv.close();
			
				
	    	}   
	    	
	    	
	    	SalvarConfig(sDirArq);	// Salva Dir Arq aberto em config.ini
			//-------------------------------------------------------------------	  
	    	
		}else{	objCxD.Aviso("Ação cancelada !", objDef.bMsgCancel);
			//	return null;
		}
		
		return sDirArq;
		

	}
  

	public void FormatarCsv(JTable jtTabela, boolean bLicenca){
		
		// Pega dados da tabela e formata em CSV(separados por virgula)
		
		objLog.Metodo("Arquivos().FormatarCsv()");
		
		String sArquivo = "";
				
		CxDialogo objCxD = new CxDialogo();
		String sExtencao = "csv";
	 	String sArqExt = null;
		Definicoes objDef = new Definicoes();
		
		// Se licença OK, abre Dialog para carregar dir/arquivo
		if(bLicenca){	
			sArquivo = DialogSalvar("csv", null);			// Chama Dialog-salvar, pega diretório 
		}else{ // Se licença NOK, manda para um arquivo vazio(Documents)
			sArquivo = objDef.DirDocuments;
			objCxD.Aviso("Erro! Erro! Arquivo inválido(IOException): " + sArqExt, objDef.bMsgSalvar);
		}
			// Testa retorno de diretório: (# = Sinal de cancelar)
		if( sArquivo.indexOf('#') < 0){			
			// Testa a existência de extenção	  
			if(sArquivo.indexOf('.') > 0)	sArqExt = sArquivo;		// Sem inserção de extenção
			else	sArqExt = sArquivo + "." + sExtencao;			// Acrescenta extenção do fArquivo
		 
			int iNumCol = jtTabela.getColumnCount();	// Pega num colunas Tab
			int iNumLin = jtTabela.getRowCount();		// Pega num Linhas Tab
			String sLinhaCSV = objDef.sTabTitulo;		// Pega títulos da tabela 
			GravarTxt(sArqExt, sLinhaCSV);				// Salva linha(Títulos) no fArquivo	
			sLinhaCSV = "";								// Limpa linha(Titulos da Tab)
			
			objLog.Metodo("Arquivos().FormatarCsv().iNumCol: " + iNumCol +", iNumLin: " + iNumLin);
			
			for(int iL=0; iL<iNumLin; iL++){
				for(int iC=0; iC<iNumCol; iC++){
					sLinhaCSV = sLinhaCSV + jtTabela.getValueAt(iL, iC) + ";";	// Gera linha CSV
				}
				GravarTxt(sArqExt, sLinhaCSV);				// Salva linha(CSV) em fArquivo
				sLinhaCSV = "";							// Limpa linha
				
			}
			objCxD.Aviso("Arquivo exportado para: " + sArqExt, objDef.bMsgSalvar);

		}else{
			objCxD.Aviso("Ação cancelada !", objDef.bMsgCancel);
		}
	}

	
	/********************************************************************************/
	/* MANIPULAÇÃO DE ARQUIVOS INI 
	 *
	 * import java.io.File;
	 * import java.io.IOException;
	 * import javax.swing.JOptionPane;
	 * import javax.swing.JTable;
	 * 
	 * import com.nikhaldimann.inieditor.*;
	 * 	
	 * Biblioteca inieditor-r5.jar
	 * http://www.java2s.com/Code/Jar/i/Downloadinieditorr5sourcesjar.htm
	 */
	

	
	public void SalvarJxtIni(JTable jTabIni, String sDirArq, int iNumReg, int iTotLin, String[] vtParamRelAcao, boolean bLicenca) throws IOException{
		// Salva dados da Tabela em arquivo *.ini
			
		
			objLog.Metodo("Arquivos(21).SalvarJxtIni(" + sDirArq + ", N.Reg: "+String.valueOf(iNumReg)+", T.Lin: "+String.valueOf(iTotLin)+")");
			//String sDirArq = "";
			
			
			try {  
				// Se licença OK< abre dialog para carregar dir/aquivo.jxt
				if(bLicenca){
					
					/*
					 *  DirArq estiver vazio...abre dialog para definir nome e arquivo
					 *  caso contrário Salva arquivo com Dir corrente
					 */
					if(sDirArq.contains(objDef.sSalvarAs) ){
						
						
						objLog.Metodo("Arquivos().SalvarJxtIni(Salvar como...)");
						//Salvar Como...
						// sNomeArq entra como nome padrao PrjTeste, mas sDirArq pega digitação do usuário
						sDirArq = DialogSalvar("jxt", "");		// Chama SaveDialog, pega diretório				
					
					}				
					
						
						// Ver.se nome possui extenção, caso não...insere
						if(!sDirArq.contains(".jxt")){ sDirArq = sDirArq + ".jxt";	}
						
						// Testa retorno de Dir(# = Sinal de cancelar)
						if( sDirArq.indexOf('#') < 0){
							
							FixeAbreDirArq(sDirArq);		// Seta valor de Dir para info ser acessada pelo FrmPrincipal
							String chave = "*.jxt";			
							File fArquivo = new File(sDirArq);	        
							if (!fArquivo.exists()) {	// Se o arquivo não existe...				
								fArquivo.createNewFile();	//cria um arquivo(vazio)
							}
				        
							int iIniciar = iTotLin - iNumReg; // Salva somente num.registros calculados(determinados pelo usuario)
							
							
							IniEditor ArqIni = new IniEditor(true);
							ArqIni.load(fArquivo);
							ArqIni.addSection(chave);
							ArqIni.set(chave, "iLinIni", String.valueOf(iIniciar) );
							ArqIni.set(chave, "iLinFim", String.valueOf(iTotLin) );
							
							//-------------------------------------------------------------------
							// Escreve dados das combos-Parametros de analise
							for(int iCp=0; iCp < 20; iCp++){
								// Converte iC para Letra
								String sVarP = "PmtIdx" + new Ferramentas().NumToChar(iCp);			
								ArqIni.set(chave, sVarP, vtParamRelAcao[iCp]);
							}			
							//-------------------------------------------------------------------
							// Escreve dados das TField da BF-relatorio da analise
							for(int iCr=20; iCr < 30; iCr++){
								// Converte iCr para Letra
								String sVarP = "Rel" + new Ferramentas().NumToChar(iCr);			
								ArqIni.set(chave, sVarP, vtParamRelAcao[iCr]);
							}	
							//-------------------------------------------------------------------
							// Escreve dados das TField da BF-Acao
							for(int iCa=30; iCa < 40; iCa++){
								// Converte iCa para Letra
								String sVarA = "Aco" + new Ferramentas().NumToChar(iCa);			
								ArqIni.set(chave, sVarA, vtParamRelAcao[iCa]);
							}	
							//-------------------------------------------------------------------
							// Escreve dados das celulas
							for(int iL=iIniciar; iL < iTotLin; iL++){
								for(int iC=0; iC < new Definicoes().iTotColunaTab; iC++){
									// Converte iC para Letra
									String sVar = new Ferramentas().NumToChar(iC) + String.valueOf(iL);			
									ArqIni.set(chave, sVar, jTabIni.getValueAt(iL, iC).toString());
								}			
							}	    	
							//-------------------------------------------------------------------	  
							ArqIni.save(fArquivo);	    	
							objCxD.Aviso("Arquivo salvo em: " + sDirArq + " - [s101a]", objDef.bMsgSalvar);
							objLog.Metodo("Arquivo salvo em: " + sDirArq+"[s101a]");
						
							SalvarConfig(sDirArq);	// Salva Dir Arq aberto em config.ini
						
						}else{
							// objCxD.Aviso("Ação cancelada !", objDef.bMsgCancel);

						}
					
					//}	// if(sDirArq)...
						
				}else{	// Msg Erro da Licença
			    	 objCxD.Aviso("Erro ao criar arquivo: "+objDef.DirDocuments+" - [eL101a],", objDef.bMsgErro);  
				}//end Licença
				
		     } catch (IOException ex) {  
		    	 objCxD.Aviso("Erro ao criar arquivo[" + ex + " - E001a],", objDef.bMsgErro);  
		     } finally{
		    	
		     }
	}

	public String[] LerJxtIni(JTable jtTabela, String sDirArq, boolean bLicenca) throws IOException{
		
		objLog.Metodo("Arquivos().LerJxtIni(" + sDirArq + ")");
		
		//JTable jtResTab = new JTable();
//		try{
				
		 // Memoriza Planilha Atual(P/ comparar alterações - nova carga de arquivo)
		//String sMemPlanAtual = sDirArq;	
		String chave ="*.jxt";
		
		int iPR = 0;	// Contagem dos elementos do vtParamRel
		String vtParamRelAcao[] = new String[50];	// Carrega vtParametros + vtRelatorio + vtAcao para return
	
		
		// Se licença OK, abre dialog para carregar arquivo.jxt
		if(bLicenca){
			if((sDirArq == null)||(sDirArq == "")){
				sDirArq = DialogAbrir("jxt");		// Chama DialogAbrir, pega diretório	
			}
		}else{ // Se licença NOK, manda para um arquivo vazio(Documents)
			sDirArq = objDef.DirDocuments;
		}
		
		//objLog.Metodo("Arquivos().LerMtaIni(sDirArq(openD): " + sDirArq + ")");
		
		//objLog.Metodo("Arquivos().LerJxtIni(Entrei 1 - Leu diretorio)");
		
		// Testa retorno de Dir(# = Sinal de cancelar)
		if( sDirArq.indexOf('#') < 0){
			
			FixeAbreDirArq(sDirArq);		// Seta valor de Dir para info ser acessada pelo FrmPrincipal
			String ValorRetorno = null;
			File fArquivo = new File(sDirArq);
			IniEditor ArqIni = new IniEditor(true);
			ArqIni.load(fArquivo);

			//objLog.Metodo("Arquivos().LerJxtIni(Entrei 2 - Validou diretório)");
			
			//-------------------------------------------------------------------------
			// Apagar registros anteriores
			boolean bCarregarTab = false;
			int iTReg = objUtil.ContarReg(jtTabela);	// Conta numero de registros na tabela

			//String sParteArqAntigo = sMemPlanAtual.substring(sMemPlanAtual.length() - 13, sMemPlanAtual.length());
			
			/*
			 *  Testa se Planilha foi alterada... 
			 *  verifica se novo arquivo NÃO CONTEM parte do nome(ultimos 10 char) do antigo arquivo
			 */
			//if( !sDirArq.contains(sParteArqAntigo) ){			
	
				// Verifica NumReg, se registros > 1
				if( iTReg > 1){							
		
					//objLog.Metodo("Arquivos().LerJxtIni(Entrei 3 - Encontro regs na tabela)");
					
					// Se confirme = Sim
					if(objCxD.Confirme("Apagar dados da planilha atual?", objDef.bMsgExcluir) )
					{
						this.LimparTabela(jtTabela);
						FixeTabAlterada(true);			// Info para o FrmPrincipal ajustar Linha inicial do teste
						bCarregarTab = true;
				
					}else{ bCarregarTab = false; }
				}else{ bCarregarTab = true; }
			//}
	    	if(bCarregarTab){

	    		//objLog.Metodo("Arquivos().LerJxtIni(Entrei 4 - Iniciou a Carga...)");
	    		
	    		/*
	    		 * Lê linha inicial e linha final do arquivo
	    		 * Para arquivo com 3000 reg´s analisados ficaria: (iLinIni=7.000, iLinFim = 10.000)
	    		 */
	    		int iLinIni = Integer.parseInt( ArqIni.get("*.jxt","iLinIni") );						
				int iLinFim = Integer.parseInt( ArqIni.get("*.jxt","iLinFim") );
				
				// Check integridade do arquivo, ver se numero de linhas é real				
				if(iLinFim > 1){
					
				
						// Informa numero de registros
						int iTotalLin = iLinFim - iLinIni;
						objDef.fixeNumRegMetaTrader(iTotalLin);
						
						int iLinTab = 0;	// Ctrl linhas da tabela
						
						//objLog.Metodo("Arquivos().LerJxtIni(Entrei 5 Lê N.Linhas - iLinIni: "+String.valueOf(iLinIni)+", iLinFim: "+String.valueOf(iLinFim)+")");
			
						//-------------------------------------------------------------------
						// Lê dados das chaves.ini e transfere para vetor(return p/ combos-Parametros de analise)
						for(int iCp=0; iCp < 20; iCp++){
							// Converte iC para Letra
							String sVarP = "PmtIdx" + new Ferramentas().NumToChar(iCp);	
							
							/*
							 * Devido ao movimento da combo(oftCV), que pode ser % ou preço(médias Min/Max)
							 * é necessario testar antes de passar valor para evitar erro - 
							 * ocorre erro ao referenciar o item que não existe no endereço: PmtIdxG(OftCP) e PmtIdxH(OftVD),
							 */
							if((sVarP.contains("PmtIdxG"))||(sVarP.contains("PmtIdxH"))){
								if(Integer.parseInt(ArqIni.get(chave, sVarP)) > 9){
									vtParamRelAcao[iPR] = "4";	// Assume item fixo(%)
								}
								
							}else{
								vtParamRelAcao[iPR] = ArqIni.get(chave, sVarP);	// Pega valor salvo
							}
							iPR++;
						}			
						//-------------------------------------------------------------------
						// Lê dados das chaves.ini e transfere para vetor(return p/ TField da BF-relatorio da analise)
						for(int iCr=20; iCr < 30; iCr++){
							// Converte iCr para Letra
							String sVarR = "Rel" + new Ferramentas().NumToChar(iCr);			
							vtParamRelAcao[iPR] = ArqIni.get(chave, sVarR);
							iPR++;
						}									
						//-------------------------------------------------------------------
						// Lê dados das chaves.ini e transfere para vetor(return p/ TField da BF-Acao)
						for(int iCa=30; iCa < 40; iCa++){
							// Converte iCa para Letra
							String sVarA = "Aco" + new Ferramentas().NumToChar(iCa);			
							vtParamRelAcao[iPR] = ArqIni.get(chave, sVarA);
							iPR++;
						}	
						//-------------------------------------------------------------------
						// Lê dados das chaves.ini e carrega nas celulas da planilha
						for(int iL=iLinIni; iL < iLinFim; iL++){
							for(int iC=0; iC < new Definicoes().iTotColunaTab; iC++){
								// Converte iC para Letra
								String sVar = new Ferramentas().NumToChar(iC) + String.valueOf(iL);	// Formata chave arq.ini			
								jtTabela.setValueAt( ArqIni.get(chave, sVar).toString(), iLinTab, iC);
							//	objLog.Metodo("sVar: " + sVar);
							}	
							iLinTab++;
						}
						
						SalvarConfig(sDirArq);	// Salva Dir Arq aberto em config.ini
						
				}else{ // if(iLinFim > 1)
					objLog.Metodo("Arquivos(Loc4001a).LerJxtIni(ERRO! Não foi possivel ler o arquivo: " + sDirArq + ")");
					
				}	// if(iLinFim > 1)
	    	}  // if(BCarregarTab) 
	    	
	    	
			//-------------------------------------------------------------------	  
	    	
	    	// Deveria atualizar titulo do Form mtaView mas não funciona
	    //	FrmPrincipal.setTitle(sDirArq);
	    	
	    	//mtaView.getFrames().getClass().getSuperclass().getTypeParameters().sTeste = sDirArq;
	    	
		}else{	//if( sDirArq.indexOf('#')	
				//objCxD.Aviso("Ação cancelada !", objDef.bMsgCancel);
				//	return null;
		}	// if( sDirArq.indexOf('#')
		
		
		for(int x=0; x<30; x++){
			objLog.Metodo("Arquivo.LerJxtIni( vtParamRel["+x+"]: "+vtParamRelAcao[x] + ")");
		}
		return vtParamRelAcao;
		
/*		
	} catch (IOException ex){  
			objCxD.Aviso("Erro ao ler arquivo, " + ex, objDef.bMsgErro);
			objLog.Metodo("Erro ao ler arquivo, " + objDef.bMsgErro);
	} finally{
			 //return ValorRetorno;
		// return vtParamRelAcao;
	}
*/
		
			
		
}
	
public void LerMtaIni_bak19nov(JTable jtTabela, String sDirArq) throws IOException{
		
		objLog.Metodo("Arquivos().LerMtaIni(" + sDirArq + ")");
		
		//JTable jtResTab = new JTable();
		//try{
				
		 // Memoriza Planilha Atual(P/ comparar alterações - nova carga de arquivo)
		//String sMemPlanAtual = sDirArq;	
		String chave ="*.mta";
		
		if(sDirArq == null){
			sDirArq = DialogAbrir("mta");		// Chama DialogAbrir, pega diretório	
		}
		
		//objLog.Metodo("Arquivos().LerMtaIni(sDirArq(openD): " + sDirArq + ")");
		
		// Testa retorno de Dir(# = Sinal de cancelar)
		if( sDirArq.indexOf('#') < 0){
			
			FixeAbreDirArq(sDirArq);		// Seta valor de Dir para info ser acessada pelo FrmPrincipal
			String ValorRetorno = null;
			File fArquivo = new File(sDirArq);
			IniEditor ArqIni = new IniEditor(true);
			ArqIni.load(fArquivo);

			//-------------------------------------------------------------------------
			// Apagar registros anteriores
			boolean bCarregarTab = false;
			int iTReg = objUtil.ContarReg(jtTabela);	// Conta numero de registros na tabela

			//String sParteArqAntigo = sMemPlanAtual.substring(sMemPlanAtual.length() - 13, sMemPlanAtual.length());
			
			/*
			 *  Testa se Planilha foi alterada... 
			 *  verifica se novo arquivo NÃO CONTEM parte do nome(ultimos 10 char) do antigo arquivo
			 */
			//if( !sDirArq.contains(sParteArqAntigo) ){			
	
				// Verifica NumReg, se registros > 1
				if( iTReg > 1){							
		
					// Se confirme = Sim
					if(objCxD.Confirme("Apagar dados da tabela atual?", objDef.bMsgExcluir) )
					{
						objUtil.LimparTabela(jtTabela);
						FixeTabAlterada(true);			// Info para o FrmPrincipal ajustar Linha inicial do teste
						bCarregarTab = true;
				
					}else{ bCarregarTab = false; }
				}else{ bCarregarTab = true; }
			//}
	    	if(bCarregarTab){

	    		// Lê total de linhas no arquivo(iL = XX)
				int iNumLin = Integer.parseInt( ArqIni.get("*.mta","iL") );						
				//-------------------------------------------------------------------
				// Escreve dados das celulas
				for(int iL=0; iL < iNumLin; iL++){
					for(int iC=0; iC < new Definicoes().iTotColunaTab; iC++){
						// Converte iC para Letra
						String sVar = new Ferramentas().NumToChar(iC) + String.valueOf(iL);			
						jtTabela.setValueAt( ArqIni.get(chave, sVar).toString(), iL, iC);    
					}			
				}
	    	}   
	    	
	    	SalvarConfig(sDirArq);	// Salva Dir Arq aberto em config.ini
			//-------------------------------------------------------------------	  
	    	
	    	// Deveria atualizar titulo do Form mtaView mas não funciona
	    //	FrmPrincipal.setTitle(sDirArq);
	    	
	    	//mtaView.getFrames().getClass().getSuperclass().getTypeParameters().sTeste = sDirArq;
	    	
		}else{	objCxD.Aviso("Ação cancelada !", objDef.bMsgCancel);
		//	return null;
		}
			
		// } catch (IOException ex){  
		//	objCxD.Aviso("Erro ao ler arquivo, " + ex, objDef.bMsgErro);  
		//} finally{
			 //return ValorRetorno; 
	//	}


	}
	public void SalvarConfig(String sDirPlan) throws IOException{
		// Salva dados da Tabela em arquivo *.ini
			
			objLog.Metodo("Arquivos(Loc102a).SalvarConfig()");
			
			try { 
				
					String sDirArq = objDef.DirRoot + "config.ini";		// Chama SaveDialog, pega diretório				
					//String sChaveCnf = "Config";
					//String sChavePrf = "Preferencias";
					String sChavePrj = "Projeto";
					
					File fArquivo = new File(sDirArq);	        
					if (!fArquivo.exists()) {	// Se o arquivo não existe...				
						fArquivo.createNewFile();	//cria um arquivo(vazio)
					}
		        
					IniEditor ArqIni = new IniEditor(true);
					ArqIni.load(fArquivo);
			
					/*
					ArqIni.addSection(sChaveCnf);	// Preferencias
					ArqIni.set(sChaveCnf, "Gt", String.valueOf(objFrmOpcao.tfIpPadrao.getText()) );
					ArqIni.set(sChaveCnf, "Mask", String.valueOf(objFrmOpcao.tfMaskPadrao.getText()) );
					ArqIni.set(sChaveCnf, "Lg", String.valueOf(objFrmOpcao.tfLoginPadrao.getText()) );
					ArqIni.set(sChaveCnf, "Sn", String.valueOf(objFrmOpcao.tfSenhaPadrao.getText()) );
					ArqIni.set(sChaveCnf, "Porta", String.valueOf(objFrmOpcao.tfPortaPadrao.getText()) );
					ArqIni.set(sChaveCnf, "TempoTst", String.valueOf(objDef.iTempoTeste) );				
					ArqIni.set(sChaveCnf, "URLteste", String.valueOf(objFrmOpcao.tfURL.getText()) );
					ArqIni.set(sChaveCnf, "Simulacao", String.valueOf(objDef.bSimulacao) );
				//	ArqIni.set(sChaveCnf, "PlanXls", String.valueOf(objFrmOpcao.PeguePlanXls()) );
					
					
					ArqIni.addSection(sChavePrf);	// Preferencias				
					ArqIni.set(sChavePrf, "TamTxtTelnet", String.valueOf(objDef.iTamTexto) );
					ArqIni.set(sChavePrf, "bZoomGf", String.valueOf(objDef.bZoom) );
					*/
					
					ArqIni.addSection(sChavePrj);	// Preferencias
					//ArqIni.set(sChavePrj, "PrjNome", String.valueOf(objFrmOpcao.tfPrjNome.getText()) );
					//ArqIni.set(sChavePrj, "Editar", String.valueOf() );
					//ArqIni.set(sChavePrj, "Gerar", String.valueOf() );
					//ArqIni.set(sChavePrj, "Importar", String.valueOf() );
					//ArqIni.set(sChavePrj, "PrjPath", String.valueOf(objFrmOpcao.tfImportarLista.getText()) );
					ArqIni.set(sChavePrj, "PrjPath", String.valueOf( sDirPlan ));
					
					ArqIni.save(fArquivo);	    	
					// objCxD.Aviso("Arquivo salvo em: " + sDirArq, objDef.bMsgSalvar);
					objLog.Metodo("Arquivos(Loc102a).SalvarConfig().PegueAbreDirArq(): " + sDirPlan);				
					
					
		     } catch (IOException ex) {  
		    	 objCxD.Aviso("Erro ao criar arquivo[" + ex + " - e002a],", objDef.bMsgErro);  
		     } finally{
		    	
		     }
		}


	public void ArqSalvarConfig(int TimeSeq, int iTamTexto, boolean bZoom, boolean bSimula) throws IOException{
	// Salva dados da Tabela em arquivo *.ini
		
		/*
		 * Devido a diferença de objetos(Definições) 
		 * os valore abaixo não são os mesmos, do objeto criado no mtaView
		 * então, qdo uma var.é atualizada no objeto do mtaView(objDef.xxx), este não carrega 
		 * o valor para o objeto(objDef.xxx) criado dentro da classe Arquivos
		 *  
		 */
		objLog.Metodo("Arquivos().SalvarConfig()");
		
		try { 
			
				String sDirArq = objDef.DirRoot + "config.ini";		// Chama SaveDialog, pega diretório				
				String chave = "Config";			
				File fArquivo = new File(sDirArq);	        
				if (!fArquivo.exists()) {	// Se o arquivo não existe...				
					fArquivo.createNewFile();	//cria um arquivo(vazio)
				}
	        
				IniEditor ArqIni = new IniEditor(true);
				ArqIni.load(fArquivo);
				ArqIni.addSection(chave);

				
				ArqIni.set(chave, "TempoTst", String.valueOf(TimeSeq) );
				ArqIni.set(chave, "TamTxtTelnet", String.valueOf(iTamTexto) );
				ArqIni.set(chave, "bZoomGf", String.valueOf(bZoom) );
				ArqIni.set(chave, "Simulacao", String.valueOf(bSimula) );
			
				ArqIni.save(fArquivo);	    	
				//objCxD.Aviso("Arquivo salvo em: " + sDirArq, objDef.bMsgSalvar);
				objLog.Metodo("Arquivos().SalvarConfig(), T: " + objDef.iTempoTeste+", Txt: " + objDef.iTamTexto +", Z: " + objDef.bZoom +", Sml: " + objDef.bSimulacao);
				
	     } catch (IOException ex) {  
	    	 objCxD.Aviso("Erro ao criar arquivo[" + ex + " - E003a],", objDef.bMsgErro);  
	     } finally{
	    	
	     }
	}
	
	public void ArqLerConfig() throws IOException{
		
		/*
		 * Devido a diferença de objetos(Definições) 
		 * os valore abaixo não são os mesmos, do objeto criado no mtaView
		 * então, qdo uma var.é atualizada no objeto do mtaView(objDef.xxx), este não carrega 
		 * o valor para o objeto(objDef.xxx) criado dentro da classe Arquivos
		 *  
		 */
		
		objLog.Metodo("Arquivos().ArqLerConfig()");

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
			boolean bSimula =  Boolean.parseBoolean( ArqIni.get(sChave,"Simulacao") );
			
			// new CxDialogo().Aviso("Arq.ini carregado: " + iTempoTst +", " + bSimula, true);

			// Fixa valores lidos de config
			objDef.FixeTempoTeste(iTempoTst);
			objDef.FixeTamTexto(iTamTxtTelnet);
			objDef.FixeGfZoom(bZoom);
			objDef.FixeSimulacao(bSimula);
		
	}

	public void BackupJxtIni(JTable jTabIni, String sDirArq, int iTotLin, boolean bLicenca) throws IOException{
		// Salva dados da Tabela em arquivo *.ini
			
			objLog.Metodo("Arquivos().BackupMtaIni(" + sDirArq + ")");
			
			// Se licenca NOK, manda endereço vazio de sDirArq
			if(!bLicenca){
				sDirArq = objDef.DirDocuments;
			}
			
			try {  
				//String sDirArq = DialogSalvar("mta", sNomeArq);		// Chama SaveDialog, pega diretório				
				
				// Testa retorno de Dir(# = Sinal de cancelar)
				if( sDirArq.indexOf('#') < 0){

					String chave = "*.jxt";			
					File fArquivo = new File(sDirArq);	        
					if (!fArquivo.exists()) {	// Se o arquivo não existe...				
						fArquivo.createNewFile();	//cria um arquivo(vazio)
					}
		        
					IniEditor ArqIni = new IniEditor(true);
					ArqIni.load(fArquivo);
					ArqIni.addSection(chave);
					ArqIni.set(chave, "iL", String.valueOf(iTotLin) );
					//-------------------------------------------------------------------
					// Escreve dados das celulas
					for(int iL=0; iL < iTotLin; iL++){
						for(int iC=0; iC < new Definicoes().iTotColunaTab; iC++){
							// Converte iC para Letra
							String sVar = new Ferramentas().NumToChar(iC) + String.valueOf(iL);			
							ArqIni.set(chave, sVar, jTabIni.getValueAt(iL, iC).toString());
						}			
					}	    	
					//-------------------------------------------------------------------	  
					ArqIni.save(fArquivo);	    	
					objLog.Metodo("Arquivo(Loc301a).AutoBackup(Arquivo salvo em: " + sDirArq + ")");

				}else{
					objLog.Metodo("Arquivo(Loc301b).AutoBackup(Ação cancelada !)");
				}

		     } catch (IOException ex) {  
		    	 objCxD.Aviso(sDirArq + " - Erro ao criar arquivo[ " + ex + " - e004a], ", objDef.bMsgErro);  
		     } finally{
		    	
		     }
		}

	/*************************************************************************************/
	
	public void criarDiretorio() {
		/*
		 * Testa se diretorios de mta não existem...
		 * Cria:
		 * \documents\mtaView_docs\
		 * \documents\mtaView_docs\backup\
		 */
		
        try {
        	
        	 File diretorio = new File(objDef.DirJxtDoc); // ajfilho é uma pasta!
        	 File dirBak = new File(objDef.DirBak); // ajfilho é uma pasta!
        	 File dirCotacao = new File(objDef.DirCotacao); // ajfilho é uma pasta!
             if (!diretorio.exists()) {
                diretorio.mkdirs(); //mkdir() cria somente um diretório, mkdirs() cria diretórios e subdiretórios.
                dirBak.mkdirs();
                dirCotacao.mkdirs();
             }
             objLog.Metodo("Ferramentas().criarDiretorio(Diretórios criados: "+ dirBak + ")");
        } catch (Exception ex) {
            //JOptionPane.showMessageDialog(null, "Erro ao criar o diretorio");            
        	objLog.Metodo("Ferramentas().criarDiretorio(Diretório já existente, "+ ex + ")");
        }
        
        
    }
	
	
	public void LerLicenca() throws IOException{
		/*
		 * O Ctrl da Licença Demo sera feito em 3 arquivos .ini
		 * C:/tmp/setup.ini
		 * /Downloads/winupdate.ini		 
		 * /matView/config.ini
		 * [Default]: Chave
		 * 		...:		Cria um corpo para dar credibilidade ao arquivo - dados inuteis		 	
		 * 		"Uservdt": 	Dta do PC, ctrl retorno de datas do PC 
		 * 		"Uservld": 	Data de validade da licença (2018)					
		 */
			
			objLog.Metodo("Arquivos().LerLicenca()");
			
			String sChaveLcc = "Default";						// Registro de Licenca Demo
			String sVarIniAnoMax = "Uservdt";					// Var-ini data ano corrente do PC
			String sVarIniAnoPC = "Uservld";					// Var-ini data ano limite para licença

			/*
			 * Dados de controle
			 * Os anos são os utilizados, mas adicionei mais alguns caracteres
			 * para dar corpo a var-ini 
			 * Na descriptografia pego 4 ultimos apos a <tab>
			 */
		/*********************************************************************************/
		// Primeira consulta: mtaView/config.ini 
		
			String sDirArq = objDef.DirRoot + "config.ini";		// Chama SaveDialog, pega diretório
		
			File fArquivo = new File(sDirArq);
			IniEditor ArqIni = new IniEditor(true);
			ArqIni.load(fArquivo);

		
			// Lê arquivo.ini -> Anos(encryptografados)
			String sAnoPcCript = ArqIni.get(sChaveLcc, sVarIniAnoPC);						
			String sAnoMaxCript = ArqIni.get(sChaveLcc, sVarIniAnoMax);

			
			// Descriptografa
			String sDecAnoMax = objUtil.Criptografia(objDef.bDecrypt, sAnoMaxCript, objDef.sKeyCript);
			String sDecAnoPC = objUtil.Criptografia(objDef.bDecrypt, sAnoPcCript, objDef.sKeyCript);
			
			objLog.Metodo("Arquivos().LerLicenca().sAnoMax: " + sAnoMaxCript +" -> "+ sDecAnoPC);
			objLog.Metodo("Arquivos().LerLicenca().sAnoPC: " + sAnoMaxCript +" -> "+ sDecAnoMax);
			
			
			// Separa somente anos			
			String sAnoPC = sDecAnoPC.substring(sDecAnoPC.length()-4, sDecAnoPC.length());
			String sAnoMax = sDecAnoMax.substring(sDecAnoMax.length()-4, sDecAnoMax.length());
			
			
			objLog.Metodo("Arquivos().LerLicenca().sAnoMax: " + sAnoMax);
			objLog.Metodo("Arquivos().LerLicenca().sAnoPC: " + sAnoPC);
			
		
	}


	public void SalvarLicenca() throws IOException{
		
		
		/*
		 * O Ctrl da Licença Demo sera feito em 3 arquivos .ini
		 * C:/tmp/setup.ini
		 * /Downloads/winupdate.ini		 
		 * /matView/config.ini
		 * [Default]: Chave
		 * 		...:		Cria um corpo para dar credibilidade ao arquivo - dados inuteis		 	
		 * 		"Uservdt": 	Dta do PC, ctrl retorno de datas do PC 
		 * 		"Uservld": 	Data de validade da licença (2018)					
		 */
			
			objLog.Metodo("Arquivos().SalvarLicenca()");
			
			
	
			
			String sChaveLcc = "Default";						// Registro de Licenca Demo
			String sVarIniAnoMax = "Uservdt";					// Var-ini data ano corrente do PC
			String sVarIniAnoPC = "Uservld";					// Var-ini data ano limite para licença

			/*
			 * Dados de controle
			 * Os anos são os utilizados, mas adicionei mais alguns caracteres
			 * para dar corpo a var-ini 
			 * Na descriptografia pego 4 ultimos apos a <tab>
			 */
			String sAnoMax = "31-12-2017";			// Ano limite do Demo
			String sAnoPC = "00-00-" + Ano.format(dData);	// Ano do PC			
								
			// Criptografa dados, para salvar
			String sAnoMaxCript = objUtil.Criptografia(objDef.bEncrypt, sAnoMax, objDef.sKeyCript);
			String sAnoPcCript = objUtil.Criptografia(objDef.bEncrypt, sAnoPC, objDef.sKeyCript);
			
			
			/****************************************************************************/
			/*
			 * Registra em mtaView/config.ini (Cript)
			 */
			try { 
				
				String sDirArq = objDef.DirRoot + "config.ini";		// Chama SaveDialog, pega diretório

				File fArquivo = new File(sDirArq);	        
				if (!fArquivo.exists()) {	// Se o arquivo não existe...				
					fArquivo.createNewFile();	//cria um arquivo(vazio)
				}
	        
				IniEditor ArqIni = new IniEditor(true);
				ArqIni.load(fArquivo);
				
				/*
				 * Ctrl da licenca DEmo
				 */
				ArqIni.addSection(sChaveLcc);					
				ArqIni.set(sChaveLcc, sVarIniAnoPC, sAnoPcCript );		// Ultimo ano válido(efeito catraca, registra para evitar retornos de data pelo user)
				ArqIni.set(sChaveLcc, sVarIniAnoMax, sAnoMaxCript);			// Ano de validade da Licenca

				ArqIni.save(fArquivo);	    	
				
	     } catch (IOException ex) {  
	    	 objLog.Metodo("Arquivos().SalvarLicenca() -> Erro ao criar arquivo[" + ex + " - e002a]");  
	     } finally{
	    	
	     }

			/*************************************************************************/
			/* Registra Lcc-1	
			 * "C:/tmp/setup.ini";
			 */				
	
			try { 
				
					
					String sChaveSta = "Startup";		// Registro de Licenca Demo
					String sChaveMif = "Mif";		// Registro de Licenca Demo
				
					
					File fArquivo = new File(objDef.Lcc1);	        
					if (!fArquivo.exists()) {	// Se o arquivo não existe...				
						fArquivo.createNewFile();	//cria um arquivo(vazio)
					}
		        
					IniEditor ArqIni = new IniEditor(true);
					ArqIni.load(fArquivo);

					/*
					 * Cria uma listagens de valores sem uso, 
					 * só pra dar uma forma mais consistente	
					 */
					ArqIni.addSection(sChaveSta);							
					ArqIni.set(sChaveSta, "AppName", "Attachmate" );		
					ArqIni.set(sChaveSta, "FreeDiskSpace", "1722");			
					
					ArqIni.addSection(sChaveMif);							
					ArqIni.set(sChaveMif, "Type", "SMS");
					ArqIni.set(sChaveMif, "FileName", "Attm_sms" );
					ArqIni.set(sChaveMif, "Locale", "ENU");			
					
					/*
					 * Ctrl da licenca DEmo
					 */
					ArqIni.addSection(sChaveLcc);					
					ArqIni.set(sChaveLcc, sVarIniAnoPC, sAnoPcCript );		// Ultimo ano válido(efeito catraca, registra para evitar retornos de data pelo user)
					ArqIni.set(sChaveLcc, sVarIniAnoMax, sAnoMaxCript);			// Ano de validade da Licenca

					ArqIni.save(fArquivo);	    	
					
		     } catch (IOException ex) {  
		    	 objLog.Metodo("Arquivos().SalvarLicenca() -> Erro ao criar arquivo[" + ex + " - e002a]");  
		     } finally{
		    	
		     }
			
			
			/*************************************************************************/
			/* 
			 * Registra em Lcc-2 
			 * DirHome + "//Downloads//winupdate.ini";
			 */
			try { 
						
				
					
				File fArquivo = new File(objDef.Lcc2);	        
				if (!fArquivo.exists()) {	// Se o arquivo não existe...				
					fArquivo.createNewFile();	//cria um arquivo(vazio)
				}
	        
				IniEditor ArqIni = new IniEditor(true);
				ArqIni.load(fArquivo);

				/*
				 * Cria uma listagens de valores sem uso, 
				 * só pra dar uma forma mais consistente	
				 */
				ArqIni.addSection(sChaveLcc);							
				ArqIni.set(sChaveLcc, "PartnerId", "9194" );		
				ArqIni.set(sChaveLcc, "Flight", "fast");
				ArqIni.set(sChaveLcc, "DownloadESDFolder", "\\WindowsUpgrade\\");
				ArqIni.set(sChaveLcc, "UserUpgrade", "true");
				ArqIni.set(sChaveLcc, "UpgradeClientId", "{9CFC7426-BB0A-4712-B0B4-ED60B2BDDEED}");
				ArqIni.set(sChaveLcc, "UpgradeCV", "qep0DuiHT0Or7V7L.999");
				ArqIni.set(sChaveLcc, "UserSignature", "1871707380");
				
				/*
				 * Ctrl da licenca DEmo
				 */
				ArqIni.set(sChaveLcc, sVarIniAnoPC, sAnoPcCript );		// Ultimo ano válido(efeito catraca, registra para evitar retornos de data pelo user)
				ArqIni.set(sChaveLcc, sVarIniAnoMax, sAnoMaxCript);			// Ano de validade da Licenca
			
				ArqIni.save(fArquivo);	    	
				
	     } catch (IOException ex) {  
	    	 objLog.Metodo("Arquivos().SalvarLicenca() -> Erro ao criar arquivo[" + ex + " - e002a]");  
	     } finally{
	    	
	     }

		}
	
	public int ContarLinhasTXT(String sDirArq) throws IOException{
		
		int iNumLin = 0;
		
		LineNumberReader lineCounter = new LineNumberReader(new InputStreamReader(new FileInputStream(sDirArq)));
		String nextLine = null;
		try {
			while ((nextLine = lineCounter.readLine()) != null) {
				if (nextLine == null)
					break;
				System.out.println(nextLine);
			}
			iNumLin = lineCounter.getLineNumber();
		} catch (Exception done) {
			done.printStackTrace();
		}
		
		return iNumLin;
	}
	
	private void LimparTabela(JTable jtTabela){
		
		objLog.Metodo("ferramentas().LimparTabela()");
		
		int iNumLinTab = objUtil.ContarReg(jtTabela); //jtTabela.getRowCount();	
		int iNumColTab = jtTabela.getColumnCount();	
		
		for(int iL=0; iL < iNumLinTab; iL++){
			for(int iC=0; iC < iNumColTab; iC++){
				jtTabela.setValueAt("", iL, iC);
			}
		}
		
    }


}  // final da Class