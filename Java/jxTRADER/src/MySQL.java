
//Classes necessárias para uso de Banco de dados //


import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;







import javax.swing.JButton;
import javax.swing.JComboBox;
import javax.swing.JFormattedTextField;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JTable;
import javax.swing.JTextField;

	//Início da classe de conexão//

	

	public class MySQL {

		private static Log objLog = new Log();	
		private static Definicoes objDef = new Definicoes();	
		//private static StorangeTabBovespa objArmazenaTabBovespa = new StorangeTabBovespa();	
	//	private static StorangeTabRascunho objArmazenaTabOperacaoTemp = new StorangeTabRascunho();	
	
		
		
		public static void CarregaPlanilha(JTable PlanLocal, String TabMySQL){
	    	/*
	    	 * Retorna registros
	    	 * Os registros são carregados do MySQL, porém...
	    	 * Valores nao retornam para outra classe
	    	 */
	    	
			objLog.Metodo("MySQL().CarregaPlanilha("+PlanLocal+", "+TabMySQL+")");
	    	
	    	boolean consulta = true;
	    	 
	    	try {
	    		// * Driver conector MySQL.
	    		Class.forName("com.mysql.jdbc.Driver");
	    	
	    	 
	    		// * Conexão BD
	    		Connection conectaMySQL = DriverManager.getConnection(objDef.sBanco, objDef.sLg, objDef.sPass);
	    	 
	    		// Cria objeto declaração
	    		java.sql.Statement conexaoMySQL = conectaMySQL.createStatement();
	    	 	
	    		// Cria objeto Resultado
	    		ResultSet ResultaMySQL = null;

	    			// Iserir registro
	    			//conexaoMySQL.executeUpdate("INSERT INTO livrosa VALUES('1550','ByJava', 'C.C.Fênix', 'login', 'autor', 'titulo', 'lote', 'edicao','tipo', 'producao', 'd/m/Y', 'obs', 'WR', 'Cadastro', 'xxx','d/m/Y') ");
	    			
	    			// Atualizar registro
	    			//conexaoMySQL.executeUpdate("UPDATE livrosa SET etiqueta='ByJar02' WHERE Registro=1550");
	    			
	    			// Consultar registro
	    			ResultaMySQL = conexaoMySQL.executeQuery("SELECT * FROM "+ TabMySQL +" WHERE registro>0 ORDER BY registro DESC");
	    			
	    			int iR = 0;
	    			
	    			while (ResultaMySQL.next()) {
	    	 
	    				// * Exibe os valore retornados na consulta.
	    	 
	    				// * Pega reg.
	    				//int Mat = ResultaMySQL.getInt("Registro");
	    	 
	    				// * Conver inteiro para String
	    				//saidaCodigo.setText(String.valueOf(Mat));
    	 
	    				// Carrega planilha com dados MySQL
	    				PlanLocal.setValueAt(ResultaMySQL.getString("registro"), iR, 0);
	    				PlanLocal.setValueAt(ResultaMySQL.getString("tendencia"), iR, 1);
	    				PlanLocal.setValueAt(ResultaMySQL.getString("status"), iR, 2);	    				
	    				PlanLocal.setValueAt(ResultaMySQL.getString("oferta_cp"), iR, 3);
	    				PlanLocal.setValueAt(ResultaMySQL.getString("stop_cp"), iR, 4);
	    				PlanLocal.setValueAt(ResultaMySQL.getString("preco_cp"), iR, 5);
	    				PlanLocal.setValueAt(ResultaMySQL.getString("data_cp"), iR, 6);
	    				PlanLocal.setValueAt(ResultaMySQL.getString("hora_cp"), iR, 7);	    				
	    				PlanLocal.setValueAt(ResultaMySQL.getString("oferta_vd"), iR, 8);
	    				PlanLocal.setValueAt(ResultaMySQL.getString("stop_vd"), iR, 9);
	    				PlanLocal.setValueAt(ResultaMySQL.getString("preco_vd"), iR, 10);
	    				PlanLocal.setValueAt(ResultaMySQL.getString("data_vd"), iR, 11);
	    				PlanLocal.setValueAt(ResultaMySQL.getString("hora_vd"), iR, 12);
	    				PlanLocal.setValueAt(ResultaMySQL.getString("resultado"), iR, 13);		    			
	    				PlanLocal.setValueAt(ResultaMySQL.getString("operacao"), iR, 14);    				
	    				PlanLocal.setValueAt(ResultaMySQL.getString("chave"), iR, 15);
	    				PlanLocal.setValueAt(ResultaMySQL.getString("data"), iR, 16);
	    				PlanLocal.setValueAt(ResultaMySQL.getString("timex"), iR, 17);
	    				PlanLocal.setValueAt(ResultaMySQL.getString("open"), iR, 18);
	    				PlanLocal.setValueAt(ResultaMySQL.getString("high"), iR, 19);
	    				PlanLocal.setValueAt(ResultaMySQL.getString("low"), iR, 20);
	    				PlanLocal.setValueAt(ResultaMySQL.getString("close"), iR, 21);
	    				PlanLocal.setValueAt(ResultaMySQL.getString("tickvol"), iR, 22);
	    				PlanLocal.setValueAt(ResultaMySQL.getString("vol"), iR, 23);
	    				PlanLocal.setValueAt(ResultaMySQL.getString("spread"), iR, 24);
	    				PlanLocal.setValueAt(ResultaMySQL.getString("var_close"), iR, 25);
	    				PlanLocal.setValueAt(ResultaMySQL.getString("var_max"), iR, 26);	    				
	    				PlanLocal.setValueAt(ResultaMySQL.getString("status"), iR, 27);
	    				
	    				consulta = false;

	    			
	    				iR++;
	    			}	// While
	    			
	    			 
	    	 
	    			if (consulta) {
	    				JOptionPane.showMessageDialog(null, "Dados não Encontrados!");	    	 
	    			}
	    			
	    		ResultaMySQL.close();	// Fecha Resulta
	    		conexaoMySQL.close();	// Fecha conexao
	    	 
	    		// * Fecha conexão com DB.
	    		conectaMySQL.close();	// Fecha banco
	    	 
	    		
	    	} catch (SQLException Erro) {
	    		JOptionPane.showMessageDialog(null,"Erro Cmdo SQL" + Erro.getMessage());
	    	 
	    	} catch (ClassNotFoundException Erro) {
	    		JOptionPane.showMessageDialog(null, "Driver não Encontrado! ["+Erro.getMessage() + "]");
	    	 
	   		}
	 
	    	
	    }	// Carrega Tabela

		
		public static void cltRegistros(String TabMySQL, int iRegIni, int iRegFim){
	    	/*
	    	 * Retorna registros(iQtos) para calculos de tendencia
	    	
	    	 */
	    	
			objLog.Metodo("MySQL().cltRegistros("+TabMySQL+","+String.valueOf(iRegIni)+","+String.valueOf(iRegFim)+")");
	    	
			int iR = 0;	
			
					
	    	boolean consulta = true;
	    	 
	    	try {
	    		// * Driver conector MySQL.
	    		Class.forName("com.mysql.jdbc.Driver");
	    	
	    		//objLog.Metodo("MySQL().cltRegistros(entrei 1)");
	    	    
	    		// * Conexão BD
	    		Connection conectaMySQL = DriverManager.getConnection(objDef.sBanco, objDef.sLg, objDef.sPass);
	    	 
	    		// Cria objeto declaração
	    		java.sql.Statement conexaoMySQL = conectaMySQL.createStatement();
	    	 	
	    		// Cria objeto Resultado
	    		ResultSet ResultaMySQL = null;

	    		//objLog.Metodo("MySQL().cltRegistros(entre 2)");
		    	 
	    			// Iserir registro
	    			//conexaoMySQL.executeUpdate("INSERT INTO livrosa VALUES('1550','ByJava', 'C.C.Fênix', 'login', 'autor', 'titulo', 'lote', 'edicao','tipo', 'producao', 'd/m/Y', 'obs', 'WR', 'Cadastro', 'xxx','d/m/Y') ");
	    			
	    			// Atualizar registro
	    			//conexaoMySQL.executeUpdate("UPDATE livrosa SET etiqueta='ByJar02' WHERE Registro=1550");
	    			
	    			// Consultar registro
	    			ResultaMySQL = conexaoMySQL.executeQuery("SELECT * FROM "+TabMySQL+" WHERE registro>="+iRegIni+" AND registro<="+iRegFim);
	    			
	    				
	    		//	objLog.Metodo("MySQL().cltRegistros(entre 3)");
	    			//objLog.Metodo("MySQL().cltRegistros(SELECT * FROM "+TabMySQL);
	   	    	 
	    			
	    			while (ResultaMySQL.next()) {
	    	 
	    			 
	    				// Consulta dados MySQL, transfere para Armazenagem
	    				if(TabMySQL == objDef.sTabOperacaoTemp){

	    					objLog.Metodo("MySQl.CltRegistro.objArmazenaTabOperacaoTemp"
	    							+ "");
	    	
	    					/*
	    					objArmazenaTabOperacaoTemp.fixeRegistro(ResultaMySQL.getInt("registro"), iR);	    				
		    				objArmazenaTabOperacaoTemp.fixeTendencia(ResultaMySQL.getString("tendencia"), iR);
		    				objArmazenaTabOperacaoTemp.fixeStatus(ResultaMySQL.getString("status"), iR);	    				
		    				objArmazenaTabOperacaoTemp.fixeOfertaCP(ResultaMySQL.getFloat("oferta_cp"), iR);
		    				objArmazenaTabOperacaoTemp.fixeStopCP(ResultaMySQL.getFloat("stop_cp"), iR);
		    				objArmazenaTabOperacaoTemp.fixePrecoCP(ResultaMySQL.getFloat("preco_cp"), iR);
		    				objArmazenaTabOperacaoTemp.fixeDataCP(ResultaMySQL.getString("data_cp"), iR);
		    				objArmazenaTabOperacaoTemp.fixeHoraCP(ResultaMySQL.getString("hora_cp"), iR);	    				
		    				objArmazenaTabOperacaoTemp.fixeOfertaVD(ResultaMySQL.getFloat("oferta_vd"), iR);
		    				objArmazenaTabOperacaoTemp.fixeStopVD(ResultaMySQL.getFloat("stop_vd"), iR);
		    				objArmazenaTabOperacaoTemp.fixePrecoVD(ResultaMySQL.getFloat("preco_vd"), iR);
		    				objArmazenaTabOperacaoTemp.fixeDataVD(ResultaMySQL.getString("data_vd"), iR);
		    				objArmazenaTabOperacaoTemp.fixeHoraVD(ResultaMySQL.getString("hora_vd"), iR);
		    				objArmazenaTabOperacaoTemp.fixeResultado(ResultaMySQL.getFloat("resultado"), iR);		    			
		    				objArmazenaTabOperacaoTemp.fixeOperacao(ResultaMySQL.getString("operacao"), iR);    				
		    				objArmazenaTabOperacaoTemp.fixeChave(ResultaMySQL.getInt("chave"), iR);
		    				objArmazenaTabOperacaoTemp.fixeData(ResultaMySQL.getString("data"), iR);
		    				objArmazenaTabOperacaoTemp.fixeTime(ResultaMySQL.getString("timex"), iR);
		    				objArmazenaTabOperacaoTemp.fixeOpen(ResultaMySQL.getFloat("open"), iR);
		    				objArmazenaTabOperacaoTemp.fixeHigh(ResultaMySQL.getFloat("high"), iR);
		    				objArmazenaTabOperacaoTemp.fixeLow(ResultaMySQL.getFloat("low"), iR);
		    				objArmazenaTabOperacaoTemp.fixeClose(ResultaMySQL.getFloat("close"), iR);
		    				objArmazenaTabOperacaoTemp.fixeTVol(ResultaMySQL.getInt("tickvol"), iR);
		    				objArmazenaTabOperacaoTemp.fixeVolume(ResultaMySQL.getInt("vol"), iR);
		    				objArmazenaTabOperacaoTemp.fixeSpread(ResultaMySQL.getInt("spread"), iR);
		    				objArmazenaTabOperacaoTemp.fixeVarClose(ResultaMySQL.getFloat("var_close"), iR);
		    				objArmazenaTabOperacaoTemp.fixeVarMax(ResultaMySQL.getFloat("var_max"), iR);	    				
    				*/
	    					
	    				}else{
	    	
	    					objLog.Metodo("MySQl.CltRegistro.objArmazenaTabBovespa");
	    					/*
	    					objArmazenaTabBovespa.fixeRegistro(ResultaMySQL.getInt("registro"), iR);
	    					objArmazenaTabBovespa.fixeData(ResultaMySQL.getString("data"), iR);
		    				objArmazenaTabBovespa.fixeTime(ResultaMySQL.getString("timex"), iR);
		    				objArmazenaTabBovespa.fixeOpen(ResultaMySQL.getFloat("open"), iR);
		    				objArmazenaTabBovespa.fixeHigh(ResultaMySQL.getFloat("high"), iR);
		    				objArmazenaTabBovespa.fixeLow(ResultaMySQL.getFloat("low"), iR);
		    				objArmazenaTabBovespa.fixeClose(ResultaMySQL.getFloat("close"), iR);
		    				objArmazenaTabBovespa.fixeTVol(ResultaMySQL.getInt("tickvol"), iR);
		    				objArmazenaTabBovespa.fixeVolume(ResultaMySQL.getInt("vol"), iR);
		    				objArmazenaTabBovespa.fixeSpread(ResultaMySQL.getInt("spread"), iR);
		    			*/
		    		//		objLog.Metodo("MySQL().Bovespa("+objArmazenaTabBovespa.pegueRegistro(iR)+": "+objArmazenaTabBovespa.pegueClose(iR)+")");
	    					
	    				}
	    	    			
			    							
	    					
	    						
			    				/*
	    				 * 
	    				 * Via trasferencia atraves de matriz[][] - não consegui
	    				sResulta[0][iR] = ResultaMySQL.getString("registro");	    				
	    				sResulta[1][iR] = ResultaMySQL.getString("tendencia");
	    				sResulta[2][iR] = ResultaMySQL.getString("status");	    				
	    				sResulta[3][iR] = ResultaMySQL.getString("oferta_cp");
	    				sResulta[4][iR] = ResultaMySQL.getString("stop_cp");
	    				sResulta[5][iR] = ResultaMySQL.getString("preco_cp");
	    				sResulta[6][iR] = ResultaMySQL.getString("data_cp");
	    				sResulta[7][iR] = ResultaMySQL.getString("hora_cp");	    				
	    				sResulta[8][iR] = ResultaMySQL.getString("oferta_vd");
	    				sResulta[9][iR] = ResultaMySQL.getString("stop_vd");
	    				sResulta[10][iR] = ResultaMySQL.getString("preco_vd");
	    				sResulta[11][iR] = ResultaMySQL.getString("data_vd");
	    				sResulta[12][iR] = ResultaMySQL.getString("hora_vd");
	    				sResulta[13][iR] = ResultaMySQL.getString("resultado");		    			
	    				sResulta[14][iR] = ResultaMySQL.getString("operacao");    				
	    				sResulta[15][iR] = ResultaMySQL.getString("chave");
	    				sResulta[16][iR] = ResultaMySQL.getString("data");
	    				sResulta[17][iR] = ResultaMySQL.getString("timex");
	    				sResulta[18][iR] = ResultaMySQL.getString("open");
	    				sResulta[19][iR] = ResultaMySQL.getString("high");
	    				sResulta[20][iR] = ResultaMySQL.getString("low");
	    				sResulta[21][iR] = ResultaMySQL.getString("close");
	    				sResulta[22][iR] = ResultaMySQL.getString("tickvol");
	    				sResulta[23][iR] = ResultaMySQL.getString("vol");
	    				sResulta[24][iR] = ResultaMySQL.getString("spread");
	    				sResulta[25][iR] = ResultaMySQL.getString("var_close");
	    				sResulta[26][iR] = ResultaMySQL.getString("var_max");	    				
	    				sResulta[27][iR] = ResultaMySQL.getString("status");
	    				*/
	    				consulta = false;

	    			
	    				iR++;
	    			}	// While
	    			
	    		//	objArmazenaTabOperacaoTemp.fixeTotalReg(iR);	// Armazena total de registros encontrados
	    		 
	    			if (consulta) {
	    				JOptionPane.showMessageDialog(null, "Dados não Encontrados! [e100a]");	    	 
	    			}
	    			
	    		ResultaMySQL.close();	// Fecha Resulta
	    		conexaoMySQL.close();	// Fecha conexao
	    	 
	    		// * Fecha conexão com DB.
	    		conectaMySQL.close();	// Fecha banco
	    		//objLog.Metodo("MySQL().cltRegistros(entre 6)");
		    	 
	    		
	    	} catch (SQLException Erro) {
	    		JOptionPane.showMessageDialog(null,"Erro Cmdo SQL: " + Erro.getMessage()+" [e101a]");
	    	//	objLog.Metodo("MySQL().cltRegistros(entre 7)");
		    	 
	    	} catch (ClassNotFoundException Erro) {
	    		JOptionPane.showMessageDialog(null, "Driver não Encontrado! ["+Erro.getMessage() + "]");
	    		//objLog.Metodo("MySQL().cltRegistros(entre 8)");
		    	 
	   		} 
	    	
	    
	    	
	    }	// Clt Reg
		
		public static int ContaRegistros(String TabMySQL){
	    	/*
	    	 * Retorna total de registros na tabela	    	
	    	 */	
			
	    	
			int iContaReg = 1;	// Inicia em 1, para ajustar numeração da planilha
	    	boolean consulta = true;
	    	 
	    	try {
	    		// * Driver conector MySQL.
	    		Class.forName("com.mysql.jdbc.Driver");
	    	
	    	 
	    		// * Conexão BD
	    		Connection conectaMySQL = DriverManager.getConnection(objDef.sBanco, objDef.sLg, objDef.sPass);
	    	 
	    		// Cria objeto declaração
	    		java.sql.Statement conexaoMySQL = conectaMySQL.createStatement();
	    	 	
	    		// Cria objeto Resultado
	    		ResultSet ResultaMySQL = null;

	    				
	    			// Consultar total de registro
	    			ResultaMySQL = conexaoMySQL.executeQuery("SELECT registro FROM " + TabMySQL);    			
	    			while (ResultaMySQL.next()) {	    				
	    				iContaReg++; 
	    				consulta = false; 
	    			} 
	    	 
	    			if (consulta) {
	    				JOptionPane.showMessageDialog(null, "Dados não Encontrados[cr001]!");	    	 
	    			}
	    			
	    		ResultaMySQL.close();	// Fecha Resulta
	    		conexaoMySQL.close();	// Fecha conexao
	    	 
	    		// * Fecha conexão com DB.
	    		conectaMySQL.close();	// Fecha banco
	    	 
	    		
	    	} catch (SQLException Erro) {
	    		JOptionPane.showMessageDialog(null,"Erro Cmdo SQL[cr002]" + Erro.getMessage());
	    	 
	    	} catch (ClassNotFoundException Erro) {
	    		JOptionPane.showMessageDialog(null, "Driver não Encontrado[cr003]! ["+Erro.getMessage() + "]");
	    	 
	   		}
	 
	    	objLog.Metodo("MySQL().ContaRegistros("+TabMySQL+")-> "+iContaReg);
			return iContaReg;
	    	
	    }	// Conta Regs
		
		  
			public static int [] TstVetor(){
				/*
				 * Teste-Vetor: funcionou
				 */
				
		        int teste[] = new int [5];
		        for (int i = 0; i < teste.length; i++){
		            teste[i] = (int) (1+(Math.random()*60));
		        }
		        return teste;
		    }
			
			public static int[][] TstMatriz(){
				/*
				 * Teste-matriz: funcionou
				 */
				  int[][] pal = new int[10][3];
				  for (int row = 0; row < pal.length; row++) {
				    for (int column = 0; column < pal[row].length; column++) {
				      pal[row][column] = row;
				    }
				  }
				  return pal;
			}
			
		    public static String[][] TstMySQL(){
		    	/*
		    	 * NÃO FUNCIONOU ! VERIFICAR MAIS TARDE....
		    	 * Retorna registros
		    	 * Os registros são carregados do MySQL, porém...
		    	 * Valores nao retornam para outra classe
		    	 */
		    	
		    	String[][] sReg = new String[10][1000];
		    	
		    	boolean consulta = true;
		    	 
		    	try {
		    		// * Driver conector MySQL.
		    		Class.forName("com.mysql.jdbc.Driver");
		    	
		    	 
		    		// * Conexão BD
		    		Connection conectaMySQL = DriverManager.getConnection(objDef.sBanco, objDef.sLg, objDef.sPass);
		    	 
		    		// Cria objeto declaração
		    		java.sql.Statement conexaoMySQL = conectaMySQL.createStatement();
		    	 	
		    		// Cria objeto Resultado
		    		ResultSet ResultaMySQL = null;

		    			// Iserir registro
		    			//conexaoMySQL.executeUpdate("INSERT INTO livrosa VALUES('1550','ByJava', 'C.C.Fênix', 'login', 'autor', 'titulo', 'lote', 'edicao','tipo', 'producao', 'd/m/Y', 'obs', 'WR', 'Cadastro', 'xxx','d/m/Y') ");
		    			
		    			// Atualizar registro
		    			//conexaoMySQL.executeUpdate("UPDATE livrosa SET etiqueta='ByJar02' WHERE Registro=1550");
		    			
		    			// Consultar registro
		    			ResultaMySQL = conexaoMySQL.executeQuery("Select * from livrosa where Registro>1000 AND Registro<1005");
		    			
		    			int iR = 0;
		    			
		    			while (ResultaMySQL.next()) {
		    	 
		    				// * Exibe os valore retornados na consulta.
		    	 
		    				// * Pega reg.
		    				//int Mat = ResultaMySQL.getInt("Registro");
		    	 
		    				// * Conver inteiro para String
		    				//saidaCodigo.setText(String.valueOf(Mat));
		    	 
		    				// Pega os demais.
		    				sReg[0][iR] = ResultaMySQL.getString("Registro");
		    				sReg[1][iR] = ResultaMySQL.getString("etiqueta");
		    				sReg[2][iR] = ResultaMySQL.getString("biblioteca");
		    				sReg[3][iR] = ResultaMySQL.getString("login");
		    				sReg[4][iR] = ResultaMySQL.getString("autor");
		    				sReg[5][iR] = ResultaMySQL.getString("titulo");
		    				sReg[6][iR] = ResultaMySQL.getString("lote");
		    				sReg[7][iR] = ResultaMySQL.getString("edicao");
		    				sReg[8][iR] = ResultaMySQL.getString("tipo");
		    	 
		    				consulta = false;

		    				/*
		    				
		    				JOptionPane.showMessageDialog(null, "REGs:["
		    																	+sReg[0][iR]+", "
		    																	+sReg[1][iR]+", "
		    																	+sReg[2][iR]+", "
		    																	+sReg[3][iR]+", "
		    																	+sReg[4][iR]+", "
		    																	+sReg[5][iR]+", "
		    																	+sReg[6][iR]+", "
		    																	+sReg[7][iR]+", "
		    																	+sReg[8][iR]+"]"); 	
		    																	
		    				*/
		    				iR++;
		    			}	// While
		    			
		    			sReg[1000][1000] = Integer.toString(iR); 
		    	 
		    			if (consulta) {
		    				JOptionPane.showMessageDialog(null, "Dados não Encontrados!");	    	 
		    			}
		    			
		    		ResultaMySQL.close();	// Fecha Resulta
		    		conexaoMySQL.close();	// Fecha conexao
		    	 
		    		// * Fecha conexão com DB.
		    		conectaMySQL.close();	// Fecha banco
		    	 
		    		
		    	} catch (SQLException Erro) {
		    		JOptionPane.showMessageDialog(null,"Erro Cmdo SQL" + Erro.getMessage());
		    	 
		    	} catch (ClassNotFoundException Erro) {
		    		JOptionPane.showMessageDialog(null, "Driver não Encontrado! ["+Erro.getMessage() + "]");
		    	 
		   		}
		 
		    	return sReg;
		    	
		    }	// BuscarDados
	  
		    
public static void InserirOperacao(String sTabMySQL, String sTendencia, String sStatus,
					float fOfertaCP, float fStopCP, float fPrecoCP,	
					String sDataCP, String sHoraCP, 
					float fOfertaVD, float fStopVD, float fPrecoVD,	
					String sDataVD, String sHoraVD, 
					float fResultado, String sOperacao,
					int iChave, String sData, String sHora,
					float fOpen, float fHigh, float fLow, float fClose, 
					int iTickVol, int iVolume,
					int iSpread, float  fVar_close, float fVar_max){
				/*
				* Insere operacao atual - linha a linha	    	
				*/
				
				objLog.Metodo("MySQL().InserirOperacao("+sTabMySQL+")");
				
				int iR = 0;	
				
				
				boolean consulta = true;
				
				try {
					// * Driver conector MySQL.
					Class.forName("com.mysql.jdbc.Driver");
					
					//objLog.Metodo("MySQL().cltRegistros(entrei 1)");
					
					// * Conexão BD
					Connection conectaMySQL = DriverManager.getConnection(objDef.sBanco, objDef.sLg, objDef.sPass);
					
					// Cria objeto declaração
					java.sql.Statement conexaoMySQL = conectaMySQL.createStatement();
					
					// Cria objeto Resultado
					ResultSet ResultaMySQL = null;
					
				//	objLog.Metodo("MySQL()->INSERT INTO "+sTabMySQL+" (registro,tendencia,status,oferta_cp,stop_cp,preco_cp,data_cp,hora_cp,oferta_vd,stop_vd,preco_vd,data_vd,hora_vd,resultado,operacao,chave,data,timex,open,high,low,close,tickvol,vol,spread,var_close,var_max) VALUES(1,'sTendencia', 'sStatus', 'fOfertaCP', 'fStopCP', 'fPrecoCP', 'sDataCP', 'sHoraCP', 'fOfertaVD', 'fStopVD', 'fPrecoVD', 'sDataVD', 'sHoraVD', 'fResultado', 'sOperacao', 'iChave', 'sData', 'sHora', 'fOpen', 'fHigh', 'fLow', 'fClose', 'iTickVol', 'iVolume', 'iSpread', 'fVar_close', 'fVar_max')");
					objLog.Metodo("sTendencia, sStatus, fOfertaCP, fStopCP, fPrecoCP, sDataCP, sHoraCP, fOfertaVD, fStopVD, fPrecoVD, sDataVD, sHoraVD, fResultado, sOperacao, iChave, sData, sHora, fOpen, fHigh, fLow, fClose, iTickVol, iVolume, iSpread, fVar_close, fVar_max");
					objLog.Metodo(sTendencia+"','"+sStatus+"','"+fOfertaCP+"','"+fStopCP+"','"+fPrecoCP+"','"+sDataCP+"','"+sHoraCP+"','"+fOfertaVD+"','"+fStopVD+"','"+fPrecoVD+"','"+sDataVD+"','"+sHoraVD+"','"+fResultado+"','"+sOperacao+"','"+iChave+"','"+sData+"','"+sHora+"','"+fOpen+"','"+fHigh+"','"+fLow+"','"+fClose+"','"+iTickVol+"','"+iVolume+"','"+iSpread+"','"+fVar_close+"','"+fVar_max);

					// Iserir registro
					conexaoMySQL.executeUpdate("INSERT INTO "+sTabMySQL+" (tendencia,status,oferta_cp,stop_cp,preco_cp,data_cp,hora_cp,oferta_vd,stop_vd,preco_vd,data_vd,hora_vd,resultado,operacao,chave,data,timex,open,high,low,close,tickvol,vol,spread,var_close,var_max) VALUES('"+sTendencia+"','"+sStatus+"','"+fOfertaCP+"','"+fStopCP+"','"+fPrecoCP+"','"+sDataCP+"','"+sHoraCP+"','"+fOfertaVD+"','"+fStopVD+"','"+fPrecoVD+"','"+sDataVD+"','"+sHoraVD+"','"+fResultado+"','"+sOperacao+"','"+iChave+"','"+sData+"','"+sHora+"','"+fOpen+"','"+fHigh+"','"+fLow+"','"+fClose+"','"+iTickVol+"','"+iVolume+"','"+iSpread+"','"+fVar_close+"','"+fVar_max+"')");

					
					//objArmazenaTabOperacaoTemp.fixeTotalReg(iR);	// Armazena total de registros encontrados
					
					if (consulta) {
						JOptionPane.showMessageDialog(null, "Dados não Encontrados! [e100a]");	    	 
					}
					
					ResultaMySQL.close();	// Fecha Resulta
					conexaoMySQL.close();	// Fecha conexao
					
					// * Fecha conexão com DB.
					conectaMySQL.close();	// Fecha banco
					//objLog.Metodo("MySQL().cltRegistros(entre 6)");
					
				
				} catch (SQLException Erro) {
					JOptionPane.showMessageDialog(null,"Erro Cmdo SQL: " + Erro.getMessage()+" [e101a]");
					//	objLog.Metodo("MySQL().cltRegistros(entre 7)");
					
				} catch (ClassNotFoundException Erro) {
					JOptionPane.showMessageDialog(null, "Driver não Encontrado! ["+Erro.getMessage() + "]");
					//objLog.Metodo("MySQL().cltRegistros(entre 8)");
				
				} 



		   }	// Inserir Operacao
		    
public static void InserirTeste(String sTabMySQL, String sTendencia, float fOpen){
	/*
	* Insere operacao atual - linha a linha	    	
	*/
	
	objLog.Metodo("MySQL().InserirTeste("+sTabMySQL+")");
	
	int iR = 0;	
	
	
	boolean consulta = true;
	
	try {
		// * Driver conector MySQL.
		Class.forName("com.mysql.jdbc.Driver");
		
		//objLog.Metodo("MySQL().cltRegistros(entrei 1)");
		
		// * Conexão BD
		Connection conectaMySQL = DriverManager.getConnection(objDef.sBanco, objDef.sLg, objDef.sPass);
		
		// Cria objeto declaração
		java.sql.Statement conexaoMySQL = conectaMySQL.createStatement();
		
		// Cria objeto Resultado
		ResultSet ResultaMySQL = null;
		
		objLog.Metodo("MySQL().Teste -> INSERT INTO "+sTabMySQL+" (registro,tendencia) VALUES(1,'sTendencia')");
		
		
		// Iserir registro
		conexaoMySQL.executeUpdate("INSERT INTO "+sTabMySQL+" (tendencia, open) VALUES('"+sTendencia+"','"+fOpen+"')");
		
		//objArmazenaTabOperacaoTemp.fixeTotalReg(iR);	// Armazena total de registros encontrados
		
		if (consulta) {
			JOptionPane.showMessageDialog(null, "Dados não Encontrados! [e100a]");	    	 
		}
		
		ResultaMySQL.close();	// Fecha Resulta
		conexaoMySQL.close();	// Fecha conexao
		
		// * Fecha conexão com DB.
		conectaMySQL.close();	// Fecha banco
		//objLog.Metodo("MySQL().cltRegistros(entre 6)");
		
	
	} catch (SQLException Erro) {
		JOptionPane.showMessageDialog(null,"Erro Cmdo SQL: " + Erro.getMessage()+" [e101a]");
		//	objLog.Metodo("MySQL().cltRegistros(entre 7)");
		
	} catch (ClassNotFoundException Erro) {
		JOptionPane.showMessageDialog(null, "Driver não Encontrado! ["+Erro.getMessage() + "]");
		//objLog.Metodo("MySQL().cltRegistros(entre 8)");
	
	} 



}	// Inserir teste 
		    /*
		    public static void main(String[] args) throws SQLException {
		  
		    	MySQL objCon = new MySQL();
		    	
		    	 objCon.TesteMySQL();
		    	
		   
		    }
		    */

	}