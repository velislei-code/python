//package mtaview;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
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

import com.nikhaldimann.inieditor.IniEditor;
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
		objLog.Metodo("Arquivos().FixeAbreDirArq("+sD+")");
		sAbreDirArq = sD; 
	}
	public String PegueAbreDirArq(){ 
		objLog.Metodo("Arquivos().PegueAbreDirArq()->"+sAbreDirArq);
		return sAbreDirArq; 
	}


  public Arquivos() {
	 // Contrutor
  }


  public String DialogAbrir(String sExtencao){
	  
	  objLog.Metodo("Arquivos().DialogAbrir("+ sExtencao +")");
	  
	  JFileChooser objFileC = new JFileChooser(new File(System.getProperty("user.home") + File.separator + "Documents" + File.separator + objDef.DirDocMta));	// Objeto SaveDialog
	  //JFileChooser objFileC = new JFileChooser();	// Objeto de OpenDialog
	
	  //objLog.Metodo("2-Arquivos().DialogAbrir(): " + objFileC.getFileView().toString());
	  
	  if(sExtencao == "mta"){		  
		  	FileNameExtensionFilter FiltrarExtencao = new FileNameExtensionFilter("Arquivos mta(*.mta)", "mta"); 
		  	objFileC.setFileFilter(FiltrarExtencao);		// Filtrar extenção
		  
	  }else{ 
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
	  
	  JFileChooser objFileC = new JFileChooser(new File(System.getProperty("user.home") + File.separator + "Documents" + File.separator + objDef.DirDocMta));	// Objeto SaveDialog 
	  
	 // objLog.Metodo("Arquivos().DialogAbrir(): " + objFileC.getFileView().toString());
	  
	  if(sExtencao == "mta"){ 
		  	FileNameExtensionFilter FiltrarExtencao = new FileNameExtensionFilter("Arquivos mta(*.mta)", "mta");
			objFileC.setToolTipText("Prj1.mta"); 
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
  
  
  
  
  public void SalvarCsv(JTable jtTabela){
	  objLog.Metodo("Arquivos().Salvar()");
	  FormatarCsv(jtTabela);	// Chama método: Formata CSV, e Grava em Arq.txt
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
		
		objLog.Metodo("Arquivos().LerTxt()");

		String vLinha[] = new String[100];  
		
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
	 	
	}
  
	public void FormatarCsv(JTable jtTabela){
		
		// Pega dados da tabela e formata em CSV(separados por virgula)
		
		objLog.Metodo("Arquivos().FormatarCsv()");
		
		CxDialogo objCxD = new CxDialogo();
			String sExtencao = "csv";
		 	String sArqExt = null;
			Definicoes objDef = new Definicoes();
			String sArquivo = DialogSalvar("csv", null);			// Chama Dialog-salvar, pega diretório 
			
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
	

	
	public void SalvarMtaIni(JTable jTabIni, String sNomeArq, int iTotLin) throws IOException{
		// Salva dados da Tabela em arquivo *.ini
			
			objLog.Metodo("Arquivos().SalvarMtaIni(" + sNomeArq + ")");
			
			try {  
				
				// sNomeArq entra como nome padrao PrjTeste, mas sDirArq pega digitação do usuário
				String sDirArq = DialogSalvar("mta", sNomeArq);		// Chama SaveDialog, pega diretório				
				
				// Ver.se nome possui extenção, caso não...insere
				if(!sDirArq.contains(".mta")){ sDirArq = sDirArq + ".mta";	}
				
				// Testa retorno de Dir(# = Sinal de cancelar)
				if( sDirArq.indexOf('#') < 0){
					
					FixeAbreDirArq(sDirArq);		// Seta valor de Dir para info ser acessada pelo FrmPrincipal
					String chave = "*.mta";			
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
						for(int iC=0; iC < new Definicoes().iTotColuna; iC++){
							// Converte iC para Letra
							String sVar = new Ferramentas().NumToChar(iC) + String.valueOf(iL);			
							ArqIni.set(chave, sVar, jTabIni.getValueAt(iL, iC).toString());
						}			
					}	    	
					//-------------------------------------------------------------------	  
					ArqIni.save(fArquivo);	    	
					objCxD.Aviso("[101] Arquivo salvo em: " + sDirArq, objDef.bMsgSalvar);
					objLog.Metodo("[101] Arquivo salvo em: " + sDirArq);
				
					SalvarConfig();	// Salva Dir Arq aberto em config.ini
				}else{
					objCxD.Aviso("Ação cancelada !", objDef.bMsgCancel);
				}

		     } catch (IOException ex) {  
		    	 objCxD.Aviso("Erro ao criar arquivo[" + ex + " - E001a],", objDef.bMsgErro);  
		     } finally{
		    	
		     }
	}

	public void LerMtaIni(JTable jtTabela, String sDirArq) throws IOException{
		
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
					for(int iC=0; iC < new Definicoes().iTotColuna; iC++){
						// Converte iC para Letra
						String sVar = new Ferramentas().NumToChar(iC) + String.valueOf(iL);			
						jtTabela.setValueAt( ArqIni.get(chave, sVar).toString(), iL, iC);    
					}			
				}
	    	}   
	    	
	    	SalvarConfig();	// Salva Dir Arq aberto em config.ini
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
					for(int iC=0; iC < new Definicoes().iTotColuna; iC++){
						// Converte iC para Letra
						String sVar = new Ferramentas().NumToChar(iC) + String.valueOf(iL);			
						jtTabela.setValueAt( ArqIni.get(chave, sVar).toString(), iL, iC);    
					}			
				}
	    	}   
	    	
	    	SalvarConfig();	// Salva Dir Arq aberto em config.ini
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
	public void SalvarConfig() throws IOException{
		// Salva dados da Tabela em arquivo *.ini
			
			objLog.Metodo("Arquivos().SalvarConfig()");
			
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
					ArqIni.set(sChavePrj, "PrjPath", String.valueOf( PegueAbreDirArq() ));
					
					ArqIni.save(fArquivo);	    	
					// objCxD.Aviso("Arquivo salvo em: " + sDirArq, objDef.bMsgSalvar);
					// objLog.Metodo("mtaView().SalvarConfig(), T: " + objDef.iTempoTeste+", Txt: " + objDef.iTamTexto +", Z: " + objDef.bZoom +", Sml: " + objDef.bSimulacao);
					
					
					
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

	public void BackupMtaIni(JTable jTabIni, String sDirArq, int iTotLin) throws IOException{
		// Salva dados da Tabela em arquivo *.ini
			
			objLog.Metodo("Arquivos().BackupMtaIni(" + sDirArq + ")");
			
			try {  
				//String sDirArq = DialogSalvar("mta", sNomeArq);		// Chama SaveDialog, pega diretório				
				
				// Testa retorno de Dir(# = Sinal de cancelar)
				if( sDirArq.indexOf('#') < 0){

					String chave = "*.mta";			
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
						for(int iC=0; iC < new Definicoes().iTotColuna; iC++){
							// Converte iC para Letra
							String sVar = new Ferramentas().NumToChar(iC) + String.valueOf(iL);			
							ArqIni.set(chave, sVar, jTabIni.getValueAt(iL, iC).toString());
						}			
					}	    	
					//-------------------------------------------------------------------	  
					ArqIni.save(fArquivo);	    	
					objLog.Metodo("mtaView().AutoBackup(Arquivo salvo em: " + sDirArq + ")");

				}else{
					objLog.Metodo("mtaView().AutoBackup(Ação cancelada !)");
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
        	
        	 File diretorio = new File(objDef.DirMtaDoc); // ajfilho é uma pasta!
        	 File dirBak = new File(objDef.DirBak); // ajfilho é uma pasta!
             if (!diretorio.exists()) {
                diretorio.mkdirs(); //mkdir() cria somente um diretório, mkdirs() cria diretórios e subdiretórios.
                dirBak.mkdirs();
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
	
	
}  // final da Class