
		public float[] AnalisarOperacoes(JTable jtPlanilha, int iTotalRegTab, int iComboNumReg, int iComboNumAmostra, float fComboLtb, float fComboLta, float fComboPercStopCP, float fComboPercStopVD, float fComboPercOfertaCP, float fComboPercOfertaVD, String sComboTravaCP, String sComboTravaVD, String sComboReferencia){
			/*
			 *  Faz um Analisar em todos os registros passados e calcula operaçoes
			 *  Os dados com a cotação(Max, Min, Open, Close) serão transferidos(ao metodo) pela jtPlanilha
			 * 	
			 *  Considerar que o valor atual é um valor corrente, não esta definido(não sei o que vai ocorrer), [
			 *  por isso tem-se de usar sempre o anterior como referencia - no caso usaremos cotação de 15min
			 *  
			 * 	Referencia fechamento(Anterior - 15Min):
			 * 		Stop-CP: é calculado 3% acima do fechamento do dia Anterior
			 *  	Oferta-CP: é calculado -0,5% abaixo do fechamento do dia Anterior(preço anterior)
			 *  	
			 *  	Stop-VD: é calculado -3% abaixo do fechamento do dia Anterior
			 *  	Oferta-VD: é calculado 2% acima do preço de compra 
			 *  
			 * 	Referencia Máx/Min(Anterior - 15Min):
			 * 		Stop-CP: é calculado 3% acima da Máx do dia Anterior(Acima da resistência)
			 *  	Oferta-CP: é calculado 0,5% acima da Min do dia Anterior(preço anterior 15min)
			 *  	
			 *  	Stop-VD: é calculado -3% abaixo da Min do dia Anterior(Suporte)
			 *  	Oferta-VD: é calculado 1% abaixo da Máx do dia Anterior(desde que seja 2% acima preço de compra)
			 */
			
			objLog.Metodo("Calcular.AnalisarOperacoes("+iComboNumReg+")");
			
			objLog.Metodo("AnalisarOperacoes(JTable jtPlanilha), (iTotalRegTab), (iComboNumReg), (iComboNumAmostra), (fComboLtb), (fComboLta), (fComboPercStopCP), (fComboPercStopVD), (fComboPercOfertaCP), (fComboPercOfertaVD), sComboReferencia )");
			 
			objLog.Metodo("AnalisarOperacoes(JTable jtPlanilha), "+String.valueOf(iTotalRegTab)+", "+String.valueOf(iComboNumReg)+", "+String.valueOf(iComboNumAmostra)+", "+String.valueOf(fComboLtb)+", "+String.valueOf(fComboLta)+", "+String.valueOf(fComboPercStopCP)+", "+String.valueOf(fComboPercStopVD)+", "+String.valueOf(fComboPercOfertaCP)+", "+String.valueOf(fComboPercOfertaVD)+", "+ sComboReferencia+")");
		
		
		// Memoriza Lista Preços máx e min
		float fListaPcMin[] = new float[10000];
		float fListaPcMax[] = new float[10000];
		
	
		// Resultado Preço médio Min/Max
		float fMedMin = 0;	
		float fMedMax = 0;
	
		
		float fRetorno[] = new float[10];
		float fCandle[] = new float[10];	// pega vetor de retorno  da analise dos Candle
				
		String sTendenciaAnterior = "";
		
		String sOperacao = "";
				
	
		
		float fStopCPAtual = 0;
		float fOfertaCPAtual = 0;
		float fPrecoCPAtual = 0;
	
		
		float fStopVDAtual = 0;
		float fOfertaVDAtual = 0;
		float fPrecoVDAtual = 0;
		float fValorUltimaVenda = 0;
	
		
		float fLucroDaOperacao = 0;
		float fLucroTotal = 0;
		

		// Memoriza(dentro de compra/venda) p/ comparar dt-cp X dt-cp e identificar Day-trade ou Swing-Trade
		String sDataCP = "";	
		String sDataAtual = "";
		/*
		 * iAtual(S): é o registro que esta sendo verificado em AnalisarOperacaoes
		 * Então a tendencia sera verificada do registro 0 a 9(iComboNumAmostra), 
		 * e o 10 será o primeiro a ser analisado como operacao e iComBoNumReg(3000) será o ultimo
		 * pois preciso primeiro determinar uma tendencia(0a9), para iniciar a analise
		 * então S inicia em: (1+Num.de amostragem) = 10 	
		 */
		int iAtual = 0;	
		
		/*
		 *  Executa verradura nos ultimos X(3000) da planilha que 
		 *  pode conter 50.000 registros, baixados do metaTrader
		 *  Então a varredura vai ser de 47.000 a 50.000 e NÃO de 0 a 3000
		 * 
		 *  iComboNumReg = num.reg.a sacanear
		 *  iComboNumAmostra = num.registros Anteriores a analisar para determinar tendencia
		 *  iLinIni  = (50.000 - 3.000) + iComboNumAmostra
		 */
		int iLinIni = (iTotalRegTab - iComboNumReg) + iComboNumAmostra;
		int iLinFinal = iTotalRegTab - 1;	// Tirei a ultima linha pois tava dando erro("empty String")	
		
		int iContaLin = 0;	// Contagem corrida de linhas pois for() pega faixa de linha da tabela

		
		objLog.Metodo("Calcular.AnalisarOperacoes(S de: "+String.valueOf(iComboNumAmostra)+", ate: "+String.valueOf(iComboNumReg)+")");
		
		try{
			
		for(int iS = iLinIni; iS<= iLinFinal; iS++){
			
			objLog.Metodo("Calcular.AnalisarOperacoes(S = "+String.valueOf(iS)+")");
			
			// Pega preços médios(máx/min) para calcular médias
			fListaPcMin[iContaLin] = Float.parseFloat( jtPlanilha.getValueAt(iS, objDef.colMIN).toString() );
			fListaPcMax[iContaLin] = Float.parseFloat( jtPlanilha.getValueAt(iS, objDef.colMAX).toString() );
					 
				 
			iAtual = iS;
			int iAnterior = iS-1;
			
			// Trava limites para evitar erros de matriz
			if(iAnterior<0){ iAnterior = 0;}
			if(iAnterior>iLinFinal){ iAnterior = iLinFinal;}
			
			/* ERRO - Trava
			// Formatando Data(De: 2018.12.01 -> 01/12/2018)			
			String sDt = jtPlanilha.getValueAt(iAtual, objDef.colDATA).toString();	
			String sAno = sDt.substring(0, 4);
			String sMes = sDt.substring(5, 2);
			String sDia = sDt.substring(8, 2);			
			String sData = sDia+"/"+sMes+"/"+sAno;	// Data formatada
			
			objLog.Metodo("Data(fmt): "+sData);
			// Pegando valores de Armazena - tabela consultada anteriormente
			
			//String sHora = jtPlanilha.getValueAt(iAtual, objDef.colHORA).toString();
			*/
			
			float fOpenAnterior = Float.parseFloat( jtPlanilha.getValueAt(iAnterior, objDef.colABERT).toString() );
			float fOpenAtual = Float.parseFloat( jtPlanilha.getValueAt(iAtual, objDef.colABERT).toString() );
			float fResistenciaAnterior = Float.parseFloat( jtPlanilha.getValueAt(iAnterior, objDef.colMAX).toString() );
			float fHighAtual = Float.parseFloat( jtPlanilha.getValueAt(iAtual, objDef.colMAX).toString() );
			float fLowAtual = Float.parseFloat( jtPlanilha.getValueAt(iAtual, objDef.colMIN).toString() );
			float fSuporteAnterior = Float.parseFloat( jtPlanilha.getValueAt(iAnterior, objDef.colMIN).toString() );
			float fCloseAnterior = Float.parseFloat( jtPlanilha.getValueAt(iAnterior, objDef.colFECH).toString() );
			float fCloseAtual = Float.parseFloat( jtPlanilha.getValueAt(iAtual, objDef.colFECH).toString() );
			int iTickVol = Integer.parseInt( jtPlanilha.getValueAt(iAtual, objDef.colTVOL).toString() );
			int iVolume = Integer.parseInt( jtPlanilha.getValueAt(iAtual, objDef.colVOL).toString() );
			int iSpread = Integer.parseInt( jtPlanilha.getValueAt(iAtual, objDef.colSPREAD).toString() );
			float fVar_close = this.PrecoToPorcento(fOpenAtual, fCloseAtual);
			float fVar_max = this.PrecoToPorcento(fHighAtual, fLowAtual);
			
			sDataAtual = jtPlanilha.getValueAt(iAtual, objDef.colDATA).toString();
			
			
			// Combo, são parâmetros passados pelo usuario, nas comboBox		
			String sTendenciaAnalisada = this.CheckTendencia(jtPlanilha, iAtual, iComboNumAmostra, fComboLtb, fComboLta);
			String sRevercao = this.CheckReversao(objOperacao.pegueTendenciaAnterior(), sTendenciaAnalisada);
			
			//fCandle = this.Candle(fOpenAnterior, fResistenciaAnterior, fSuporteAnterior, fCloseAnterior, fComboPercStopCP, fComboPercStopVD, sTendenciaAnalisada);
	
			String sTendenciaInformada = sTendenciaAnalisada;
	
					
			objLog.Metodo("Calcular.AnalisarOperacoes(Entrei 2)");
			
				
	
			/******************************************************************************************/
			// Se NÃO estou comprado(false), (estou vendido)...executar operacao de compra			
			if(objOperacao.pegueStatus() == objOperacao.bEstouVendido){ 
				
				String sEstouVendido="";
				if(objOperacao.bEstouVendido){ sEstouVendido = "True";}
				else{ sEstouVendido = "false"; }
				
				objLog.Metodo("Calcular.AnalisarOperacoes(Estou Vendido)");
				objLog.Metodo("Calcular.AnalisarOperacoes(objOperacao.pegueStatus(): )"+objOperacao.pegueStatus()+")");
				objLog.Metodo("Calcular.AnalisarOperacoes(objOperacao.bEstouVendido: )"+sEstouVendido+")");
				
	
				/********************************************************************/
				// Faz comutação com tipo de analise usada(Candle ou tendencia)
				
				if(sComboReferencia.contains("dle")){
					// Se analise vai usar Candle...analise compra
					objLog.Metodo("AnalisarOpercao(Analise por Candle)");
					
					fCandle = this.Candle(fOpenAnterior, fResistenciaAnterior, fSuporteAnterior, fCloseAnterior, fPrecoCPAtual, fValorUltimaVenda, fComboPercOfertaCP, fComboPercOfertaVD, fComboPercStopCP, fComboPercStopVD, sTendenciaAnalisada);
						
					// Se candle analisado é adequado para compra...
					if(fCandle[objOperacao.iPosCandleTpOperacao] == objOperacao.fCandleTpOperacaoCP ){
						fOfertaCPAtual = fCandle[objOperacao.iPosCandleOfertaCP];
						fStopCPAtual = fCandle[objOperacao.iPosCandleStopCP];
						
						objLog.Metodo("AnalisarOpercao(Analise por Candle).Comprar");
						objLog.Metodo("AnalisarOpercao(Analise por Candle).OFC: "+fOfertaCPAtual);
						objLog.Metodo("AnalisarOpercao(Analise por Candle).StopCP: "+fStopCPAtual);
						
					}else{
						fOfertaCPAtual = 0;
						fStopCPAtual = 0;

					}
				}else{	
					//Se analise for por tendencia...
				
						/*  Se Estou vendido, 
						 *  e, Se Reversao foi para LTA(começou subir), inicio ofertas de compra
		                 *	Ajusto Stop
		                 *	Determino Oferta de compra
		                 */
						if(sRevercao == objOperacao.sReversaoLTA){
							// Ajusta Stop
									
							fStopCPAtual = this.CalcularStopCP(fStopCPAtual, fCloseAnterior, fResistenciaAnterior,  fComboPercStopCP, sComboReferencia);
							fOfertaCPAtual = this.CalcularOfertaCP(fCloseAnterior, fSuporteAnterior, fValorUltimaVenda, fComboPercOfertaCP, sComboTravaCP, sComboReferencia);
										
							objLog.Metodo("Calcular.AnalisarOperacoes(fComboPercStopCP: "+String.valueOf(fComboPercStopCP)+")");
							objLog.Metodo("Calcular.AnalisarOperacoes(fComboPercOfertaCP: "+String.valueOf(fComboPercOfertaCP)+")");
							objLog.Metodo("Calcular.AnalisarOperacoes(Entrei em ReversaoLTA, calc.stop e oferta)");
							
							sTendenciaInformada = objOperacao.sReversaoLTA;
						}
						
						/*
						 * Se estou vendido, e reversao esta para LTB
						 * inapropriado para compra, então cancela operacao de compra
						 */
						if(sRevercao == objOperacao.sReversaoLTB){
		
							objLog.Metodo("Calcular.AnalisarOperacoes(Entrei em reversão de LTB, cacelar compra)");
							
							// Se houver um Stop-CP setado(existe ordem em curso), cancele Ordem de compra
							if(fStopCPAtual>0){
								fStopCPAtual = objOperacao.iFlagCancel;	// Cancelar = seta um numero negativo(-1.0)	
								fOfertaCPAtual = objOperacao.iFlagCancel;	
								sOperacao = objOperacao.sOpCancelCP;
							}	
							sTendenciaInformada = objOperacao.sReversaoLTB;
							
						}
						
				} //if(iComboTipoDeAnalise == objOperacao.iAnaliseCandle){
			
				// Final do tipo de analise de compra(Candle ou tendencia)
				
				
				/******************************************************************************/
				/*
			     * Verificar se preços Minimo PEGOU nossa oferta de compra ou nosso stop-cp
			     */
             	if( (fOfertaCPAtual > 0)&&(fLowAtual <= fOfertaCPAtual) ){

    				objLog.Metodo("Calcular.AnalisarOperacoes(Entrei Low <= oferta-CP)");
    				
    				// Compara SE Maior Alta de hoje pegou nossa oferta de CP
             		objOperacao.fixeStatus(objOperacao.bEstouComprado);	// informa que estou comprado
             		fPrecoCPAtual = fOfertaCPAtual;	// seta preço de compra = a minha oferta de compra
             		sOperacao = objOperacao.sOpCompra;
             		sDataCP = sDataAtual; 	// Memoriza p/ comparar com dt-vd e identificar Day/Swing-Trade
             	
             		objLog.Metodo("Calcular.AnalisarOperacoes(DataCP(Cp) = "+ sDataCP +")");
             	}else{
             		
             		// Se não pegou nossa oferta, verifica se pegou nosso stop de compra
					if( (fStopCPAtual > 0)&&(fHighAtual >= fStopCPAtual) ){
						objOperacao.fixeStatus(objOperacao.bEstouComprado);;	// informa que estou comprado
	             		fPrecoCPAtual = fStopCPAtual;	// seta preço de compra = a minha oferta de compra
	             		sOperacao = objOperacao.sOpStopCP;
	             		sDataCP = sDataAtual; 	// Memoriza p/ comparar com dt-vd e identificar Day/Swing-Trade
	             		
	             		objLog.Metodo("Calcular.AnalisarOperacoes(DataCP(St) = "+ sDataCP +")");	
	    				
					}
				}
				
             	
             	
			}	// if se estou vendido
			
			/******************************************************************************************/
			// Se estou comprado(true)...executar rotina de vender
			
			if(objOperacao.pegueStatus() == objOperacao.bEstouComprado){
				
				String sEstouComprado="";
				if(objOperacao.bEstouComprado){ sEstouComprado = "True";}
				else{ sEstouComprado = "false"; }
				
				objLog.Metodo("Calcular.AnalisarOperacoes(Estou Vendido)");
				objLog.Metodo("Calcular.AnalisarOperacoes(objOperacao.pegueStatus(): )"+objOperacao.pegueStatus()+")");
				objLog.Metodo("Calcular.AnalisarOperacoes(objOperacao.bEstouComprado: )"+sEstouComprado+")");
		
				objLog.Metodo("Calcular.AnalisarOperacoes(Entrei 3)");
				
				/********************************************************************/
				// Faz comutação com tipo de analise usada(Candle ou tendencia)
				
				if(sComboReferencia.contains("dle")){
					// Se analise vai usar Candle...analise VENDA	
					//fCandle = this.Candle(fOpenAnterior, fResistenciaAnterior, fSuporteAnterior, fCloseAnterior, fComboPercStopCP, fComboPercStopVD, sTendenciaAnalisada);
					fCandle = this.Candle(fOpenAnterior, fResistenciaAnterior, fSuporteAnterior, fCloseAnterior, fPrecoCPAtual, fValorUltimaVenda, fComboPercOfertaCP, fComboPercOfertaVD, fComboPercStopCP, fComboPercStopVD, sTendenciaAnalisada);
						
					// Se Candle analisado é ideal para venda...
					if(fCandle[objOperacao.iPosCandleTpOperacao] == objOperacao.fCandleTpOperacaoVD ){
						
						fOfertaVDAtual = fCandle[objOperacao.iPosCandleOfertaVD];
						fStopVDAtual = fCandle[objOperacao.iPosCandleStopVD];

						objLog.Metodo("AnalisarOpercao(Analise por Candle).Vender");
						objLog.Metodo("AnalisarOpercao(Analise por Candle).OFV: "+fOfertaVDAtual);
						objLog.Metodo("AnalisarOpercao(Analise por Candle).StopVD: "+fStopVDAtual);
						
					}else{
						fOfertaVDAtual = 0;
						fStopVDAtual = 0;

					}
					
				}else{	
					//Se analise for por tendencia...
				
						
						/*  Se Estou comprado, 
						 *  e, Se Reversao foi para LTB(começou cair), inicio ofertas de venda
		                 *	Ajusto Stop
		                 *	Determino Oferta de venda(default 2% acima valor de compra)
		                 */
						
						if(sRevercao == objOperacao.sReversaoLTB){
													
							// Ajusta Stop-VD
							fStopVDAtual = this.CalcularStopVD(fStopVDAtual, fCloseAnterior, fSuporteAnterior, fComboPercStopVD, sComboReferencia);
							fOfertaVDAtual = this.CalcularOfertaVD(fPrecoCPAtual, fResistenciaAnterior, fComboPercOfertaVD, sComboTravaVD, sComboReferencia);	// 2% acima preço de compra
							
							sTendenciaInformada = objOperacao.sReversaoLTB;
							
						
						}
						
						/*
						 * Se estou comprado, e reversao esta para LTA
						 * inapropriado para venda, então cancela operacao de venda
						 */
						if(sRevercao == objOperacao.sReversaoLTA){
							// Se houver stop-vd setado(existe ordem), cancela ordens 
							if(fStopVDAtual>0){
								fStopVDAtual = objOperacao.iFlagCancel;	// Cancelar = seta um numero negativo(-1.0)	
								fOfertaVDAtual = objOperacao.iFlagCancel;	
								sOperacao = objOperacao.sOpCancelVD;
							}	
							sTendenciaInformada = objOperacao.sReversaoLTA;
							
						}	
				}	// if Candle ou tendencia
				// final da comutação de vanda(Candle ou tendencia)
				
				/******************************************************************************/
				 /*
			     * Verificar se preços pegou nossa oferta de venda ou nosso stop-vd
			     */
             	if( (fOfertaVDAtual > 0)&&(fHighAtual >= fOfertaVDAtual) ){
             	// Compara SE Maior Alta de hoje pegou nossa oferta de CP
             		objOperacao.fixeStatus(objOperacao.bEstouVendido);	// informa que estou vendido
             		fPrecoVDAtual = fOfertaVDAtual;	// seta preço de compra = a minha oferta de compra
             		fValorUltimaVenda = fOfertaVDAtual;
             		
             		// compara com dt-cp e identifica Day/Swing-Trade
             		if(sDataCP.contains(sDataAtual)){ sOperacao = objOperacao.sOpVendaDayT; }
             		else{ sOperacao = objOperacao.sOpVendaSwingT; }
            		
            		fLucroDaOperacao = PrecoToPorcento(fPrecoCPAtual, fPrecoVDAtual); 
                    
             		
            		objLog.Metodo("Calcular.AnalisarOperacoes(DataCP(Vd): "+sDataCP+" = DataVD: "+sDataAtual+") = "+sOperacao);
            		sDataCP = "";	// Depois da comparação... zera
             		
             				
             	}else{
				// Se não pegou nossa oferta, verifica se pegou nosso stop de compra
					if( (fStopVDAtual > 0)&&(fHighAtual <= fStopVDAtual) ){
						objOperacao.fixeStatus(objOperacao.bEstouVendido);	// informa que estou vendido
				 		fPrecoVDAtual = fStopVDAtual;	// seta preço de compra = a minha oferta de compra
	             		fValorUltimaVenda = fStopVDAtual;
	             		
	             		// compara com dt-cp e identifica Day/Swing-Trade
	             		if(sDataCP.contains(sDataAtual)){ sOperacao = objOperacao.sOpStopVdDayT; }
	             		else{ sOperacao = objOperacao.sOpStopVdSwingT; }
	                 	 		
	             		fLucroDaOperacao = PrecoToPorcento(fPrecoCPAtual, fPrecoVDAtual); 
	            
	             		objLog.Metodo("Calcular.AnalisarOperacoes(DataCP(St): "+sDataCP+" = DataVD: "+sDataAtual+") = "+sOperacao);
	            		sDataCP = "";	// Depois da comparação... zera
	   	                    
	            	}
				}
				
             		
			}	// if Se estou comprado
	
			
			// Zera var´s
			if(objOperacao.pegueStatus() == objOperacao.bEstouComprado){	// Se estou Comprado, zera var-vendas
				fOfertaVDAtual = 0;
				fStopVDAtual = 0;
				fPrecoVDAtual = 0;				
			}else{								// Se estou vendido, zera var-compra
				fOfertaCPAtual = 0;
				fStopCPAtual = 0;
				fPrecoCPAtual = 0;
			}
			
			/***********************************************************************************/
			// Inserir linha com dados de calculos na tabela rascunho
			
			String sStatus = "";
			if(objOperacao.pegueStatus() == objOperacao.bEstouComprado){ sStatus = "Comprado"; }
			else{ sStatus = "Vendido"; }
			
			// Formata para 2 casas decimais
			String sOfertaCPAtual = "";
			String sStopCPAtual = "";
			String sPrecoCPAtual = "";
			String sOfertaVDAtual = "";
			String sStopVDAtual = "";
			String sPrecoVDAtual = "";
			String sLucroDaOperacao = "";
			
			if(fOfertaCPAtual>0){ sOfertaCPAtual = "R$ " + String.format("%.2f", fOfertaCPAtual); }
			if(fStopCPAtual>0){ sStopCPAtual = "R$ " + String.format("%.2f", fStopCPAtual);}
			if(fPrecoCPAtual>0){ sPrecoCPAtual = "R$ " + String.format("%.2f", fPrecoCPAtual);}
			
			if(fOfertaVDAtual>0){ sOfertaVDAtual = "R$ " + String.format("%.2f", fOfertaVDAtual);}
			if(fStopVDAtual>0){ sStopVDAtual = "R$ " + String.format("%.2f", fStopVDAtual);}
			if(fPrecoVDAtual>0){ sPrecoVDAtual = "R$ " + String.format("%.2f", fPrecoVDAtual);}

			String sVarClose = String.format("%.2f", fVar_close) + " %";
			String sVarMax = String.format("%.2f", fVar_max) + " %";

			if(fLucroDaOperacao != 0){sLucroDaOperacao = String.format("%.2f", fLucroDaOperacao) + "%"; }
		
		
			// Troca indicador Cancel (-1.0) por string "Cancel"
			if(fOfertaCPAtual == objOperacao.iFlagCancel){ sOfertaCPAtual = objOperacao.sOpCancelCP;	}
			if(fStopCPAtual == objOperacao.iFlagCancel){	sStopCPAtual = objOperacao.sOpCancelCP;	}
			if(fPrecoCPAtual == objOperacao.iFlagCancel){	sPrecoCPAtual = objOperacao.sOpCancelCP;	}
			
			if(fOfertaVDAtual == objOperacao.iFlagCancel){ sOfertaVDAtual = objOperacao.sOpCancelVD;	}
			if(fStopVDAtual == objOperacao.iFlagCancel){	sStopVDAtual = objOperacao.sOpCancelVD;	}
			if(fPrecoVDAtual == objOperacao.iFlagCancel){	sPrecoVDAtual = objOperacao.sOpCancelVD;	}
			
		
			/*
			T  , Status,
			LTB,Vendido,oft 0.0,stp 0.0, pr0.0,dt,hr,oft0.0, stp0.0, pr0.0, dt , hr,lc 0.0,
			op,ch0,dt null, time null, op0.0, h0.0, l0.0, cl0.0, tv0, v0, sp0, var0.0, var0.0
			
			objLog.Metodo(sTendenciaInformada+','+ sStatus+','+ 
					sOfertaCPAtual+','+ sStopCPAtual+','+ sPrecoCPAtual+','+ 	
					sDataCP+','+ sHoraCP+','+ 
					sOfertaVDAtual+','+ sStopVDAtual+','+ sPrecoVDAtual+','+ 	
					sDataVD+','+ sHoraVD+','+ 
					String.valueOf(fLucroDaOperacao)+','+ sOperacao+','+ 
					sData+','+ sHora+','+ 
					fOpenAtual+','+ fHighAtual+','+ fLowAtual+','+ fCloseAtual+','+ 
					iTickVol+','+ iVolume+','+ 
					iSpread+','+ fVar_close+','+ fVar_max);

			*/
			
			// Cores da Planilha - total
			//jtPlanilha.setGridColor(java.awt.Color.white);  // toda a grade
			//jtPlanilha.setBackground(java.awt.Color.blue);  // todo o fundo
			//jtPlanilha.setForeground(java.awt.Color.blue);  // todas as letras
		
			// Traduzir Candle
			String sCandle = "";
			if(fCandle[objOperacao.iPosCandleTipo] == objOperacao.fCandleMartelo){ sCandle = "Martelo"; }
			if(fCandle[objOperacao.iPosCandleTipo] == objOperacao.fCandleMarteloInv){ sCandle = "Martelo-Inv"; }			
			if(fCandle[objOperacao.iPosCandleTipo] == objOperacao.fCandleEnforcado){ sCandle = "Enforcado"; }
			if(fCandle[objOperacao.iPosCandleTipo] == objOperacao.fCandleStarCadente){ sCandle = "Est.Cadte"; }

			String sTipoOp = "";
			if(fCandle[objOperacao.iPosCandleTpOperacao] == objOperacao.fCandleTpOperacaoCP){ sTipoOp = "[CP]"; }
			if(fCandle[objOperacao.iPosCandleTpOperacao] == objOperacao.fCandleTpOperacaoVD){ sTipoOp = "[VD]"; }

			
			// Insere valores na Planilha
			jtPlanilha.setValueAt( sTendenciaAnalisada/* + "[S:"+String.valueOf(iS)+",   Ant:"+String.valueOf(iAnterior)+"]"*/, iAnterior, objDef.colTEND );
			jtPlanilha.setValueAt( sCandle+sTipoOp, iAnterior, objDef.colCANDLE );	// Anterior pois anaisou linha Ant.
			jtPlanilha.setValueAt( sStatus, iAtual, objDef.colSTATUS );
			
			jtPlanilha.setValueAt( sOfertaCPAtual, iAtual, objDef.colOFT_CP );
			jtPlanilha.setValueAt( sStopCPAtual, iAtual, objDef.colSTOP_CP );
			jtPlanilha.setValueAt( sPrecoCPAtual, iAtual, objDef.colPRECO_CP );
			
			jtPlanilha.setValueAt( sOfertaVDAtual, iAtual, objDef.colOFT_VD );
			jtPlanilha.setValueAt( sStopVDAtual, iAtual, objDef.colSTOP_VD );
			jtPlanilha.setValueAt( sPrecoVDAtual, iAtual, objDef.colPRECO_VD );
			
			jtPlanilha.setValueAt( sLucroDaOperacao, iAtual, objDef.colRESULTADO );
			jtPlanilha.setValueAt( sOperacao, iAtual, objDef.colOPERACAO );
			jtPlanilha.setValueAt( sVarClose, iAtual, objDef.colVAR_F );
			jtPlanilha.setValueAt( sVarMax, iAtual, objDef.colVAR_M );
		
			
			// Soma a projeção de lucro da analise executada
			fLucroTotal = fLucroTotal + fLucroDaOperacao;
			
			// Apo´s transgerir valores para planilha - zera dados
			fLucroDaOperacao = 0;
			
			if(sOperacao == objOperacao.sOpCompra){ objOperacao.IncContagemOpCompra();}
			if(sOperacao.contains(objOperacao.sOpVenda)){ objOperacao.IncContagemOpVenda();}
			if(sOperacao == objOperacao.sOpStopCP){ objOperacao.IncContagemStopCP();}
			if(sOperacao.contains(objOperacao.sOpStopVD)){ objOperacao.IncContagemStopVD();}
			if(sOperacao == objOperacao.sOpStopVdDayT){ objOperacao.IncContagemDayTrade();}
			if(sOperacao == objOperacao.sOpStopVdSwingT){ objOperacao.IncContagemSwingTrade();}
			if(sOperacao == objOperacao.sOpVendaDayT){ objOperacao.IncContagemDayTrade();}
			if(sOperacao == objOperacao.sOpVendaSwingT){ objOperacao.IncContagemSwingTrade();}
			
			objLog.Metodo("sOperacao: " + sOperacao);
			objLog.Metodo("objOperacao.Compra: "+String.valueOf(objOperacao.pegueContagemOpCompra()));
			objLog.Metodo("objOperacao.Venda: "+String.valueOf(objOperacao.pegueContagemOpVenda()));
			
			sOperacao = "";
			
			// Zera var´s
			if(objOperacao.pegueStatus() == objOperacao.bEstouComprado){	// Se estou Comprado, zera oferta e stop de compra
				fOfertaCPAtual = 0;
				fStopCPAtual = 0;
							
			}else{								// Se estou vendido, zera oferta e stop de venda
				fOfertaVDAtual = 0;
				fStopVDAtual = 0;
				
			}
	
			objLog.Metodo(" S = "+String.valueOf(iS));	
			objLog.Metodo("-------------------------------------------------------------------");
		
			iContaLin++;	// Contagem corrida de linha, pois for() usa faixa de linhas da tabela
			
		} // for S
		

				
		/***********************************************************************************/
		
		
		} catch (Exception Erro) {
			
			objLog.Metodo("Erro na execução de AnalisarOperacoes: " + Erro.getMessage() + " [e201b]");
			//	objLog.Metodo("MySQL().cltRegistros(entre 7)");
			//new CxDialogo().OpcaoAviso("Erro ao analisar dados! O programa será encerrado.", 1);
			JOptionPane.showMessageDialog (null,
				    "Erro ao analisar os dados! O software será encerrado.",
				    "Erro!",
				    JOptionPane.ERROR_MESSAGE);
			System.exit(0);
			
		}finally{
    	
			objLog.Metodo("calcular().AnalisarOperacoes(Finalizando) - iAtual("+String.valueOf(iAtual)+")");
			
			
			fRetorno[objOperacao.iPosLucro] = fLucroTotal;
			fRetorno[objOperacao.iPosContagemOpCompra] = objOperacao.pegueContagemOpCompra();
			fRetorno[objOperacao.iPosContagemOpVenda] = objOperacao.pegueContagemOpVenda();
			fRetorno[objOperacao.iPosContagemStopCP] = objOperacao.pegueContagemStopCP();
			fRetorno[objOperacao.iPosContagemStopVD] = objOperacao.pegueContagemStopVD();
			fRetorno[objOperacao.iPosContagemDayTrade] = objOperacao.pegueContagemDayTrade();
			fRetorno[objOperacao.iPosContagemSwingTrade] = objOperacao.pegueContagemSwingTrade();
			
			
			
			/***********************************************************************************/
			// Cálculo da média de preços Máx/Min
			
			float fMemMedMin = 0;
			float fMemMedMax = 0;
			/*
			// Ordena vetores preço min em ordem crescente
			for (int x = 0; x < fListaPcMin.length; x++) {
			   for (int y = x+1; y < fListaPcMin.length; y++) {
			    if(fListaPcMin[x] < fListaPcMin[y] ){
			    	fMemMedMin = fListaPcMin[x];
			    	fListaPcMin[x] = fListaPcMin[y];
			    	fListaPcMin[y] = fMemMedMin;
			    }
			   }
			  }
			*/
			// Ordena vetores preço max em ordem crescente
			  for (int x = 0; x < fListaPcMax.length; x++) {
			   for (int y = x+1; y < fListaPcMax.length; y++) {
				   
				   if(fListaPcMin[x] < fListaPcMin[y] ){
				    	fMemMedMin = fListaPcMin[x];
				    	fListaPcMin[x] = fListaPcMin[y];
				    	fListaPcMin[y] = fMemMedMin;
				    }
				   
				    if(fListaPcMax[x] < fListaPcMax[y] ){
				    	fMemMedMax = fListaPcMax[x];
				    	fListaPcMax[x] = fListaPcMax[y];
				    	fListaPcMax[y] = fMemMedMax;
				    }
			   }
			  }
			float fSomaMedMin = 0;
			float fSomaMedMax = 0;
			
			int iNumAmostra = 10;
			
			for(int iMn = fListaPcMax.length; iMn > iNumAmostra; iMn--){ 
				fSomaMedMin = fSomaMedMin + fListaPcMin[iMn];
				objLog.Metodo("calcular().Lista.fMedMin(): " + String.valueOf(fListaPcMin[iMn]));
			}
			
			for(int iMx = 0; iMx < iNumAmostra; iMx++){ 
				fSomaMedMax = fSomaMedMax + fListaPcMax[iMx];
				objLog.Metodo("calcular().Lista.fMedMax(): " + String.valueOf(fListaPcMax[iMx]));
					
			}
			
			// Médias
			if(fSomaMedMin > 0){ fMedMin = fSomaMedMin/iNumAmostra; 	}
			if(fSomaMedMax > 0){ fMedMax = fSomaMedMax/iNumAmostra;		}
			
			fRetorno[objOperacao.iPosMedMin] = fMedMin;
			fRetorno[objOperacao.iPosMedMax] = fMedMax;
			
			objLog.Metodo("calcular().fMedMin(" + String.valueOf(fMedMin) + ")");
			objLog.Metodo("calcular().fMedMax(" + String.valueOf(fMedMax) + ")");
					
			return fRetorno;
		}
		
		
	
	} // Final metodo AnalisarOperacoes

	
	public float[] AnalisarMedias(JTable jtPlanilha, int iTotalRegTab, int iComboNumReg, int iComboNumAmostra){
	
			objLog.Metodo("AnalisarMedias(JTable jtPlanilha), "+String.valueOf(iTotalRegTab)+", "+String.valueOf(iComboNumReg)+", "+String.valueOf(iComboNumAmostra)+")");
		
		
		// Memoriza Lista Preços máx e min
		float fListaPcMin[] = new float[10000];
		float fListaPcMax[] = new float[10000];
		
	
		// Resultado Preço médio Min/Max
		float fMedMin = 0;	
		float fMedMax = 0;
	
		
		float fRetorno[] = new float[10];
		float fCandle[] = new float[10];	// pega vetor de retorno  da analise dos Candle
				

		
		/*
		 *  Executa verradura nos ultimos X(3000) da planilha que 
		 *  pode conter 50.000 registros, baixados do metaTrader
		 *  Então a varredura vai ser de 47.000 a 50.000 e NÃO de 0 a 3000
		 * 
		 *  iComboNumReg = num.reg.a sacanear
		 *  iComboNumAmostra = num.registros Anteriores a analisar para determinar tendencia
		 *  iLinIni  = (50.000 - 3.000) + iComboNumAmostra
		 */
		int iLinIni = (iTotalRegTab - iComboNumReg) + iComboNumAmostra;
		int iLinFinal = iTotalRegTab - 1;	// Tirei a ultima linha pois tava dando erro("empty String")	
		
		int iContaLin = 0;	// Contagem corrida de linhas pois for() pega faixa de linha da tabela

		
		objLog.Metodo("Calcular.AnalisarMedias(S de: "+String.valueOf(iComboNumAmostra)+", ate: "+String.valueOf(iComboNumReg)+")");
		
		try{
			
		for(int iS = iLinIni; iS<= iLinFinal; iS++){
			
			objLog.Metodo("Calcular.AnalisarOperacoes(S = "+String.valueOf(iS)+")");
			
			// Pega preços médios(máx/min) para calcular médias
			fListaPcMin[iContaLin] = Float.parseFloat( jtPlanilha.getValueAt(iS, objDef.colMIN).toString() );
			fListaPcMax[iContaLin] = Float.parseFloat( jtPlanilha.getValueAt(iS, objDef.colMAX).toString() );
					 
				 
	
			objLog.Metodo(" Célula(var S) = "+String.valueOf(iS));	
			objLog.Metodo("-------------------------------------------------------------------");
		
			iContaLin++;	// Contagem corrida de linha, pois for() usa faixa de linhas da tabela
			
		} // for S
		

				
		/***********************************************************************************/
		
		
		} catch (Exception Erro) {
			
			objLog.Metodo("Erro na execução de AnalisarMedias: " + Erro.getMessage() + " [e201b]");
			//	objLog.Metodo("MySQL().cltRegistros(entre 7)");
			//new CxDialogo().OpcaoAviso("Erro ao analisar dados! O programa será encerrado.", 1);
			JOptionPane.showMessageDialog (null,
				    "Erro ao analisar os dados! O software será encerrado.",
				    "Erro!",
				    JOptionPane.ERROR_MESSAGE);
			System.exit(0);
			
		}finally{
    	
		
			
			/***********************************************************************************/
			// Cálculo da média de preços Máx/Min
			
			float fMemMedMin = 0;
			float fMemMedMax = 0;
			/*
			// Ordena vetores preço min em ordem crescente
			for (int x = 0; x < fListaPcMin.length; x++) {
			   for (int y = x+1; y < fListaPcMin.length; y++) {
			    if(fListaPcMin[x] < fListaPcMin[y] ){
			    	fMemMedMin = fListaPcMin[x];
			    	fListaPcMin[x] = fListaPcMin[y];
			    	fListaPcMin[y] = fMemMedMin;
			    }
			   }
			  }
			*/
			// Ordena vetores preço max em ordem crescente
			  for (int x = 0; x < fListaPcMax.length; x++) {
			   for (int y = x+1; y < fListaPcMax.length; y++) {
				   
				   if(fListaPcMin[x] < fListaPcMin[y] ){
				    	fMemMedMin = fListaPcMin[x];
				    	fListaPcMin[x] = fListaPcMin[y];
				    	fListaPcMin[y] = fMemMedMin;
				    }
				   
				    if(fListaPcMax[x] < fListaPcMax[y] ){
				    	fMemMedMax = fListaPcMax[x];
				    	fListaPcMax[x] = fListaPcMax[y];
				    	fListaPcMax[y] = fMemMedMax;
				    }
			   }
			  }
			float fSomaMedMin = 0;
			float fSomaMedMax = 0;
			
			int iNumAmostra = 10;
			
			for(int iMn = fListaPcMax.length; iMn > iNumAmostra; iMn--){ 
				fSomaMedMin = fSomaMedMin + fListaPcMin[iMn];
				objLog.Metodo("calcular().Lista.fMedMin(): " + String.valueOf(fListaPcMin[iMn]));
			}
			
			for(int iMx = 0; iMx < iNumAmostra; iMx++){ 
				fSomaMedMax = fSomaMedMax + fListaPcMax[iMx];
				objLog.Metodo("calcular().Lista.fMedMax(): " + String.valueOf(fListaPcMax[iMx]));
					
			}
			
			// Médias
			if(fSomaMedMin > 0){ fMedMin = fSomaMedMin/iNumAmostra; 	}
			if(fSomaMedMax > 0){ fMedMax = fSomaMedMax/iNumAmostra;		}
			
			fRetorno[objOperacao.iPosMedMin] = fMedMin;
			fRetorno[objOperacao.iPosMedMax] = fMedMax;
			
			objLog.Metodo("calcular().fMedMin(" + String.valueOf(fMedMin) + ")");
			objLog.Metodo("calcular().fMedMax(" + String.valueOf(fMedMax) + ")");
					
			return fRetorno;
		}
		
		
	
	} // Final metodo AnalisarMedias

	
	/******************************************************************************/
				// Analise dos preços médios(Máx/Min) no período
				float fMediasAnalisar[] = objCalcular.AnalisarMedias(  
												Planilha,
												objDef.pegueNumRegMetaTrader(),
												iValComboNumRegistro, 
												iValComboAmostraMed									
											);
				
				
				tfMedMin.setText(String.format("%.2f", fMediasAnalisar[objOperacao.iPosMedMin])); 
				tfMedMax.setText(String.format("%.2f", fMediasAnalisar[objOperacao.iPosMedMax])); 
		
				/******************************************************************************/
		
	
