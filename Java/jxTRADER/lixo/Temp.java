public float[] AnalisarVd10h(JTable jtPlanilha, int iTotalRegTab, int iComboPeriodo, int iNumAmostra){
	
	// Analisa método de venda na abertura - recompra 14h30/16h30
	
		// Limita num de registros a analisar menor que total de registros na planilha
		if(iTotalRegTab < iComboPeriodo){ iComboPeriodo = iTotalRegTab-1; }
			
			
		if(iNumAmostra < 1){ iNumAmostra = 10;		}	// assume valor default caso venha vazia
		objLog.Metodo("Calcular.AnalisarVd10h(JTable jtPlanilha), "+String.valueOf(iTotalRegTab)+", "+String.valueOf(iComboPeriodo)+", "+String.valueOf(iNumAmostra)+")");
		
		
		// Memoriza Lista Preços máx e min
		float fListaPrecoMin[] = new float[10000];
		float fListaPrecoMax[] = new float[10000];
		
	
		// Resultado Preço médio Min/Max
		float fMedMin = 0;	
		float fMedMax = 0;
	
		
		float fRetorno[] = new float[1000];
		//float fCandle[] = new float[1000];	// pega vetor de retorno  da analise dos Candle
				
		//----------------------------------------------------------------------------------------
		// Pega Num.Linha inicial pela data(periodo 30,60,90 dias)
		String sDataFim = jtPlanilha.getValueAt(iTotalRegTab, objDef.colDATA).toString();		
		String sDataRet = this.pegueDataRetrocede(sDataFim, iComboPeriodo);
		
		int iLinIniPeriodo = this.pegueRegLinInicial(jtPlanilha, sDataRet, iTotalRegTab);
		
		objLog.Metodo("AnalisarVd10h().Retrocede data: " + sDataRet + ", Linha: " + String.valueOf(iLinIniPeriodo)+" - " + String.valueOf( iTotalRegTab));
		
		
		//----------------------------------------------------------------------------------------
		/*
		 *  Executa verradura nos ultimos X(3000) da planilha que 
		 *  pode conter 50.000 registros, baixados do metaTrader
		 *  Então a varredura vai ser de 47.000 a 50.000 e NÃO de 0 a 3000
		 * 
		 *  iComboPeriodo = num.reg.a sacanear
		 *  iComboNumAmostra = num.registros Anteriores a analisar para determinar tendencia
		 *  iLinIni  = (50.000 - 3.000) + iComboNumAmostra
		 */
		int iLinIni = iLinIniPeriodo; //(iTotalRegTab - iComboPeriodo) + iNumAmostra;
		int iLinFinal = iTotalRegTab - 1;	// Tirei a ultima linha pois tava dando erro("empty String")	
		
		int iContaLin = 0;	// Contagem corrida de linhas pois for() pega faixa de linha da tabela

		// Valores iniciais
		int iValVenda = 0;
		int iValCompra = 0;
		
		
		objLog.Metodo("Calcular.AnalisarVd10h(Periodo: " +String.valueOf(iComboPeriodo)+ "Lin.Ini: "+String.valueOf(iLinIni) +", Lin.Fim: "+String.valueOf(iLinFinal)+")");
		
		try{
				
			for(int iS = iLinIni; iS< iLinFinal; iS++){
				

				
			/*
				fListaPrecoMin[iContaLin] = Float.parseFloat( jtPlanilha.getValueAt(iS, objDef.colMIN).toString() );
				fListaPrecoMax[iContaLin] = Float.parseFloat( jtPlanilha.getValueAt(iS, objDef.colMAX).toString() );
				
					 
				iContaLin++;	// Contagem corrida de linha, pois for() usa faixa de linhas da tabela
			*/

				
			
			} // for S
			

				
		/***********************************************************************************/
		
		
		} catch (Exception Erro) {
			
			objLog.Metodo("Erro na execução de AnalisarVd10h: " + Erro.getMessage() + " [e202b]");
			//	objLog.Metodo("MySQL().cltRegistros(entre 7)");
			//new CxDialogo().OpcaoAviso("Erro ao analisar dados! O programa será encerrado.", 1);
			JOptionPane.showMessageDialog (null,
				    "Erro ao analisar os dados! O software será encerrado.",
				    "Erro!",
				    JOptionPane.ERROR_MESSAGE);
			System.exit(0);
			
		}finally{
    	
		
						
						
			return fRetorno;
		}
		
		
	
	} // Final metodo AnalisarVd10h


