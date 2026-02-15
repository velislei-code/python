import java.math.BigDecimal;
import java.math.RoundingMode;
import java.sql.SQLException;
import java.text.DecimalFormat;
import java.util.Arrays;

import javax.swing.JOptionPane;
import javax.swing.JTable;

import com.sun.org.apache.xerces.internal.impl.xpath.regex.Match;
//import com.sun.prism.paint.Color;



public class Calcular {
	
	//StorangeTabBovespa objArmazenaTabBovespa = new StorangeTabBovespa();
	Operacao objOperacao = new Operacao();
	Definicoes objDef = new Definicoes();
	Log objLog = new Log();
	MySQL objMySql = new MySQL();

	
	public float FormateDec(float dNumero){
				
		float dNumero2d = 0;
		
		try{
			// formata com 2 casas decimais
			DecimalFormat objFormateDec = new DecimalFormat("#.##");      
//			dNumero2d = Float.valueOf(objFormateDec.format(dNumero));
			dNumero2d = Float.parseFloat(objFormateDec.format(dNumero));
			
		} catch (Exception Erro) {
	    	objLog.Metodo("Erro na execução de FormateDec: " + Erro.getMessage()+" [e109a]");
	    	//	objLog.Metodo("MySQL().cltRegistros(entre 7)");
		}finally{  
			objLog.Metodo("FormateDec("+String.valueOf(dNumero)+") = "+String.valueOf(dNumero2d)+")");
			return (float)dNumero2d;
		}
	}


	public float FmtDecimal(float dNumero, int iCasas){
	// Ta dando erro não identificado em alguns tipos de numeros
		
		float dNumero2d = 0;
		try{
			// arredonda com 2 casas decimais
			BigDecimal objBigDec = new BigDecimal(dNumero).setScale(iCasas, RoundingMode.HALF_EVEN);
			dNumero2d = objBigDec.floatValue();
		} catch (Exception Erro) {
	    	objLog.Metodo("Erro na execução de Arredonda2d: " + Erro.getMessage()+" [e108a]");
	    	//	objLog.Metodo("MySQL().cltRegistros(entre 7)");
		}finally{  
			objLog.Metodo("Arredonda2d("+String.valueOf(dNumero)+", "+String.valueOf(iCasas)+") = "+String.valueOf(dNumero2d)+")");
		    
				return (float)dNumero2d;
		}
	}
	
	
	
	public float PrecoToPorcento(float fPrecoAnt, float fPrecoAtual){
		// Converte preço(Anterior/Atual) para variação %
		//objLog.Metodo("calcular().PrecoToPorcento("+String.valueOf(fPrecoAnt)+", "+String.valueOf(fPrecoAtual)+")");
		float fPerc = 0;
		
		try{
			if((fPrecoAnt > 0)&&(fPrecoAtual > 0)){
				fPerc = ( (fPrecoAtual - fPrecoAnt)/fPrecoAtual )*100;
			}
						
			objLog.Metodo("calcular().PrecoToPorcento("+String.valueOf(fPrecoAnt)+", "+String.valueOf(fPrecoAtual)+") ="+String.valueOf(fPerc));
		} catch (Exception Erro) {
	    	objLog.Metodo("Erro na execução de PrecoToPorcento: " + Erro.getMessage()+" [e107a]");
	    	//	objLog.Metodo("MySQL().cltRegistros(entre 7)");
		}finally{
	    
			return fPerc;
		}
	}
	
	public String CheckTendencia(JTable jtPlanilha, int iNumRegEmAnalise, int iComboNumAmostra, float fComboLtb, float fComboLta){
		
		objLog.Metodo("calcular().CheckTendencia(RegEmAnalisar: "+String.valueOf(iNumRegEmAnalise)+", Ltb: "+String.valueOf(fComboLtb)+", Lta: "+String.valueOf(fComboLta)+")");
		
		// Calcula tendencia LTB, Neutra ou LTA
		/*
		 *  Faixa LTB e LTA
		 *  [LTB | NEUTRA | LTA ]
		 *  LTB <= -1.0% < NEUTRA < 1.0% <= LTA
		 */
		
		String sTendencia = "";
		
		try{
			
			
			float[] fVarPerc = new float[100000];	// Cria matriz e inicializa
			float fSoma = 0;
			float fVarPerc2 = 0;
			
			/*
			 * iNumRegEmAnalisar: é o registro que esta sendo verificado em AnalisarOperacaoes
			 * Então a tendencia sera verificada do registro  iNumRegEmAnalisar ate 0, 
			 * e o 10 será o primeiro a ser analisado como operacao
			 * pois preciso primeiro determinar uma tendencia(0a9) 	
			 */
			
			int iRegFinal =  iNumRegEmAnalise-1;
			int iRegIniDaAmostra = (iRegFinal - iComboNumAmostra); 
				
			  
			objLog.Metodo("Amostra: "+ String.valueOf(iComboNumAmostra));
			objLog.Metodo("iRegIniDaAmostra: "+ String.valueOf(iRegIniDaAmostra));
			objLog.Metodo("iRegFinal: "+ String.valueOf(iRegFinal));
			
			// Converte todos os elementos(Amostragem de fechamento anterior(ultimo candle)), para variação %
			for(int iA = iRegIniDaAmostra; iA < iRegFinal; iA++){
				
				int iAtual = iA;
				int iAnterior = iA-1;
				
				if(iAnterior >= iRegFinal){ iAnterior = iAtual; }	// evita estouro de matriz
				
				// Pega preços de fechamento da planilha em curso
			    float fCloseAnterior = Float.parseFloat( jtPlanilha.getValueAt(iAnterior, objDef.colFECH).toString() );
				float fCloseAtual = Float.parseFloat( jtPlanilha.getValueAt(iAtual, objDef.colFECH).toString() );
				fVarPerc[iAtual] = this.PrecoToPorcento( fCloseAnterior, fCloseAtual );			
				
				String sData = jtPlanilha.getValueAt(iAnterior, objDef.colDATA).toString();
				String sHr = jtPlanilha.getValueAt(iAnterior, objDef.colHORA).toString();
				objLog.Metodo("Data: "+ sData+" - "+sHr);		
				
				//fVarPerc[iA] = ((fCloseAtual - fCloseAnterior)/fCloseAtual)*100;
			
				//objLog.Metodo("("+ String.valueOf(fCloseAtual)+"-"+ String.valueOf(fCloseAnterior)+ ")/"+String.valueOf(fCloseAtual) +" * 100 ->" + String.valueOf(fVarPerc[iA]));
				
				fSoma = fSoma + fVarPerc[iAtual];
				objLog.Metodo("fSoma: "+ String.valueOf(fSoma));
				objLog.Metodo("----------------------------------------");
				
				
			}
			
					
			if((fSoma>fComboLtb)&&(fSoma<fComboLta)){sTendencia = objOperacao.sNeutra;}		
			if(fSoma <= fComboLtb){ sTendencia = objOperacao.sLTB; }	// <= -1.0% LTB
			if(fSoma >= fComboLta){ sTendencia = objOperacao.sLTA; }	// >+ 1.0% LTA, entre -1,0 e + 1,0 Neutra
			
			objLog.Metodo("Somatorio(%); "+String.valueOf(fSoma));
			objLog.Metodo("LTB(%); "+String.valueOf(fComboLtb));
			objLog.Metodo("LTA(%); "+String.valueOf(fComboLta));
			objLog.Metodo("TendenCia: "+sTendencia);
			objLog.Metodo("===============================================================");
			
		
		} catch (Exception Erro) {
	    	objLog.Metodo("Erro na execução de CheckTendencia: " + Erro.getMessage()+" [e101a]");
	    	//	objLog.Metodo("MySQL().cltRegistros(entre 7)");
		}finally{
	    	
			//objLog.Metodo("calcular().Tendencia("+String.valueOf(iComboNumAmostra)+") = " + sTendencia);
			return sTendencia;
		}
	}
	
	public float[] Candle(float fOpenAnterior, float fMaxAnterior, float fMinAnterior, float fCloseAnterior, float fPrecoUltCompra, float fPrecoUltVenda, float fComboPercOftCP, float fComboPercOftVD, float fComboPercStopCP, float fComboPercStopVD, String sTendenciaAnalisada){
	/*
	 * Idenfica tipo de candlesticks formado, define OFC, OFV e stops 
	 * Na relação de 3x1(3xGain X 1xLoss) 
	 * 	
	 */
		float fResCandle = 0;
		float fReturnCandle[] = new float[10];
		/*
		 * Usamos como base os valores Anteriores, pois o atual, 
		 * teoricamente é o presente, não sabemos o desfecho
		 */
		float fCorpo = Math.abs(fOpenAnterior - fCloseAnterior);	// Math.abs, pega o módulo(sem sinal)
		float fDoisMeioCorpo = (float)(fCorpo * 2.5);
		float fPavilSup = Math.abs(fMaxAnterior - fOpenAnterior);
		float fPavilInf = Math.abs(fMinAnterior - fCloseAnterior);
		
		float fStopCP = 0; 
		float fOfertaCP = 0; 
		float fAlvo = 0;	// objetivo de preço a atingir na oepração(3Gain_x_1Loss) 
		float fStopVD = 0; 
		float fOfertaVD = 0;
		float fTipoOperacao = 0;	// Comprar ou vender 
		
		int iGanhoXperda = 3;	// iGanhoXperda / 1 -> 3x1 -> ganha 3x, perde 1x
		
		/*****************************************************************************************
		 * Candle Martelo
		 * Aparece após uma LTB e reverte
		 * O Pavil Inf. tem 2.5xCorpo
		 * O Pavil Sup. é menor q pavil(sombra) sup 
		 * Indica uma reversão de LTB -> LTA e entramos para compra
		 * OFC = fMaxAnterior(Máx do martelo)
		 * Stop = -3%(ajusta Combo) da OFC(máx do martelo)
		 * Alvo(OFV) = 9% da OFC - 3x1
		 */
		
		if(fPavilSup < fPavilInf){						// Se pavilSup é menor Pavil Inf
			if(fPavilInf >= fDoisMeioCorpo){			// Se Pavil Inf 2,5x>Corpo
				if(sTendenciaAnalisada.contains(objOperacao.sLTB)){	// Se tendencia é LTB
					fResCandle = objOperacao.fCandleMartelo;
					
					/* Calculos abaixo são o recomendavel, mas não da lucro
					fOfertaCP = fMaxAnterior;	// OFC = Máx do martelo
					fStopCP = fOfertaCP - ((fComboPercStopCP * fOfertaCP)/100);	// Stop de Compra 3% abaixo da OFC(Max do martelo)
					fAlvo = fOfertaCP + (((fComboPercStopCP * iGanhoXperda)*fOfertaCP)/100); // O Alvo 3x a perda(Perda: -3%, Alvo: +9%)
					fOfertaVD = fAlvo;
					*/
					fOfertaCP = fMaxAnterior - ((fMaxAnterior*fComboPercOftCP)/100);	// OFC = Máx do martelo -X% da Combo
					fStopCP = fOfertaCP - ((fComboPercStopCP * fOfertaCP)/100);	// Stop de Compra 3% abaixo da OFC(Max do martelo)
					fAlvo = fOfertaCP + (((fComboPercStopCP * iGanhoXperda)*fOfertaCP)/100); // O Alvo 3x a perda(Perda: -3%, Alvo: +9%)
					fOfertaVD = fPrecoUltCompra + ((fPrecoUltCompra*fComboPercOftVD)/100);
					
					fTipoOperacao = objOperacao.fCandleTpOperacaoCP;
					
					
					
					
				}else{
					// vazio
				}
			}
		}
		/*********************************
		 * Candle Martelo-Invertido
		 * Aparece após uma LTB e reverte
		 * O Pavil Sup. tem 2.5xCorpo
		 * O Pavil Inf. é menor q pavil(sombra) sup 
		 * Indica uma reversão de LTB -> LTA e entramos para compra
		 * OFC = fMaxAnterior(Máx do martelo)
		 * Stop = -3%(ajusta Combo) da OFC(máx do martelo)
		 * Alvo(OFV) = 9% da OFC - 3x1
		 */
   		 if(fPavilInf < fPavilSup){						// Se pavilInf é menor que PavilSup
			if(fPavilSup >= fDoisMeioCorpo){			// Se Pavil Supeiror 2,5x>Corpo
				if(sTendenciaAnalisada.contains(objOperacao.sLTB)){		// Se tendencia é LTA
					fResCandle = objOperacao.fCandleMarteloInv;
					
					/* calculos abaixo são o reconmendavel por Andre Moraes, mas não deu resultado positivo
					fOfertaCP = fMaxAnterior;	// OFC = Máx do martelo
					fStopCP = fOfertaCP - ((fComboPercStopCP * fOfertaCP)/100);	// Stop de Compra 3% abaixo da OFC(Max do martelo)
					fAlvo = fOfertaCP + (((fComboPercStopCP * iGanhoXperda)*fOfertaCP)/100); // O Alvo 3x a perda(Perda: -3%, Alvo: +9%)
					fOfertaVD = fAlvo;
					*/
					fOfertaCP = fMaxAnterior - ((fMaxAnterior*fComboPercOftCP)/100);	// OFC = Máx do martelo -X% da combo(ajuste usuario)
					fStopCP = fOfertaCP - ((fComboPercStopCP * fOfertaCP)/100);	// Stop de Compra 3% abaixo da OFC(Max do martelo)
					fAlvo = fOfertaCP + (((fComboPercStopCP * iGanhoXperda)*fOfertaCP)/100); // O Alvo 3x a perda(Perda: -3%, Alvo: +9%)
					fOfertaVD = fPrecoUltCompra + ((fPrecoUltCompra*fComboPercOftVD)/100);
					
					fTipoOperacao = objOperacao.fCandleTpOperacaoCP;
				}else{
					// Vazio
				}
			}
		 }
   		 
   		 /****************************************************************************************
   		 * Candle Estrela cadente
		 * Aparece após uma LTA e reverte
		 * O Pavil Sup. tem 2.5xCorpo
		 * O Pavil Inf. é menor q pavil(sombra) sup 
		 * Indica uma reversão de LTA -> LTB e entramos para VENDA
		 * OFV = fMinAnterior(Min do martelo)
		 * StopVD = +3%(ajusta Combo) da OFV(min do martelo)
		 * Alvo(OFC) = -9% da OFV - 3x1
		 */
   		 if(fPavilInf < fPavilSup){						// Se pavilInf é menor que PavilSup
				if(fPavilSup >= fDoisMeioCorpo){			// Se Pavil Superior 2,5x > Corpo
					if(sTendenciaAnalisada.contains(objOperacao.sLTA)){		// Se tendencia é LTA
						fResCandle = objOperacao.fCandleStarCadente;	// Est.cadente-reversão de LTA->LTB...vender
						/* Estes calculos abaixo são exatamente o que é recomendado
						 * mas, vou atrelar ao ajuste percentual, que da +/- a mesma proporção
						 * mas com possibilidade de testes
						 *
						fStopVD = fMaxAnterior;		// StopVD = Máx do martelo
						fOfertaVD = fMinAnterior;	// Min do martelo
						fAlvo =  fOfertaVD -((fMaxAnterior - fMinAnterior)*iGanhoXperda); // O Alvo da próx. compra: proporção 3x abaixo do preço de venda 
						fOfertaCP = fAlvo;
						*/
						/* 
						 * Calculos com percentual ajustavel nas combos - possibilta testes
						 * Não deu resultado positivo
						fOfertaVD = fMinAnterior;	// Min do martelo
						fStopVD = fOfertaVD + ((fOfertaVD * fComboPercStopVD)/100); //3% acima OFV
						fAlvo =  fOfertaVD - ((fOfertaVD * (fComboPercStopVD*iGanhoXperda))/100); // O Alvo da próx. compra: proporção 3x abaixo do preço de venda 
						fOfertaCP = fAlvo;
						*/
						// Pega o maior valor de venda(CP + 2% ou a min.do martelo)
						float fOfertaVDMais2P = fPrecoUltCompra + ((fPrecoUltCompra * fComboPercOftVD)/100);
						if(fOfertaVDMais2P > fMinAnterior){ fOfertaVD = fOfertaVDMais2P; }
						else{ fOfertaVD = fMinAnterior;	}// Min do martelo
						
						fStopVD = fOfertaVD + ((fOfertaVD * fComboPercStopVD)/100); //3% acima OFV
						fAlvo =  fOfertaVD - ((fOfertaVD * (fComboPercStopVD*iGanhoXperda))/100); // O Alvo da próx. compra: proporção 3x abaixo do preço de venda 
						fOfertaCP = fAlvo;
						
						fTipoOperacao = objOperacao.fCandleTpOperacaoVD;
					}else{
						// Vazio
					}
				}
			}
		

   		 /********************************************************
   		 * Candle o Enforcado
		 * Aparece após uma LTA e reverte
		 * O Pavil Inf. tem 2.5xCorpo
		 * O Pavil Sup. é menor q pavil(sombra) inf 
		 * Indica uma reversão de LTA -> LTB e entramos para VENDA		  
		 * OFV = fMinAnterior(Min do martelo)
		 * StopVD = +3%(ajusta Combo) da OFV(min do martelo)
		 * Alvo(OFC) = -9% da OFV - 3x1
		 */
   		 if(fPavilSup < fPavilInf){						// Se pavilInf é menor que PavilSup
				if(fPavilInf >= fDoisMeioCorpo){			// Se Pavil Superior 2,5x > Corpo
					if(sTendenciaAnalisada.contains(objOperacao.sLTA)){		// Se tendencia é LTA
						fResCandle = objOperacao.fCandleEnforcado;	// Est.cadente-reversão de LTA->LTB...vender
						/* Estes calculos abaixo são exatamente o que é recomendado
						 * mas, vou atrelar ao ajuste percentual, que da +/- a mesma proporção
						 * mas com possibilidade de testes
						 *
						fStopVD = fMaxAnterior;		// StopVD = Máx do martelo
						fOfertaVD = fMinAnterior;	// Min do martelo
						fAlvo =  fOfertaVD -((fMaxAnterior - fMinAnterior)*iGanhoXperda); // O Alvo da próx. compra: proporção 3x abaixo do preço de venda 
						fOfertaCP = fAlvo;
						*/
						/* 
						 * Calculos com percentual ajustavel nas combos - possibilta testes
						 * Nao deu resultado positvo
						 */
						// Pega o maior valor de venda(CP + 2% ou a min.do martelo)
						float fOfertaVDMais2P = fPrecoUltCompra + ((fPrecoUltCompra * fComboPercOftVD)/100);
						if(fOfertaVDMais2P > fMinAnterior){ fOfertaVD = fOfertaVDMais2P; }
						else{ fOfertaVD = fMinAnterior;	}// Min do martelo
					
						fStopVD = fOfertaVD + ((fOfertaVD * fComboPercStopVD)/100); //3% acima OFV
						fAlvo =  fOfertaVD - ((fOfertaVD * (fComboPercStopVD*iGanhoXperda))/100); // O Alvo da próx. compra: proporção 3x abaixo do preço de venda 
						fOfertaCP = fAlvo;
						fTipoOperacao = objOperacao.fCandleTpOperacaoVD;
					}else{
						// vazio
					}
				}
			}
		
   		// Monta vetor de retorno 
   		fReturnCandle[objOperacao.iPosCandleTipo] = fResCandle; 
		fReturnCandle[objOperacao.iPosCandleTpOperacao] = fTipoOperacao;
   		fReturnCandle[objOperacao.iPosCandleStopCP] = fStopCP; 
		fReturnCandle[objOperacao.iPosCandleOfertaCP] = fOfertaCP; 
		fReturnCandle[objOperacao.iPosCandleAlvo] = fAlvo;	// Este é somente referencia interna ao metodo, provavel que não vou usar fora, mas...	
		fReturnCandle[objOperacao.iPosCandleStopVD] = fStopVD; 
		fReturnCandle[objOperacao.iPosCandleOfertaVD] = fOfertaVD;
				
		return fReturnCandle;
		
	}
	
	
	
	public String CheckReversao(String sTendeAnterior, String sTendeAtual){
		
		// Verifica se houve reversão de tendência
		objLog.Metodo("CheckReversao(T.Ant: "+sTendeAnterior+", T.Atual: "+sTendeAtual+")");
		
		String sReversao = "";
		
		try{	
			
			/*
			 * Se tendencia(Ant e Atual) for diferente, check reversao
			 * LTA->LTB = REVERSÃO
			 * LTB->LTA = Reversão
			 * NEUTRA-LTX ou LTX->NEUTRA ou LTX->LTX = sem reversão
			 */
			
			// Se houve mudaça de tendencia
			if(sTendeAnterior != sTendeAtual){					
				
				// e, SE não era ou é neutra
				if( (sTendeAnterior != objOperacao.sNeutra)&&(sTendeAtual != objOperacao.sNeutra) ){		
					
					// Verifica reversão
					if(sTendeAnterior == objOperacao.sLTA){		// Inverte tendencia(LTA->LTB, ou LTB->LTA)
						sReversao = objOperacao.sReversaoLTB;
					}else{
						sReversao = objOperacao.sReversaoLTA;					
					}
					
				}
			}
			if( (sTendeAtual == objOperacao.sLTA)||(sTendeAtual == objOperacao.sLTB) ){
				// Memoriza estado atual(LTA ou LTB) para proxima verificação de inversao de tendência
				objOperacao.fixeTendenciaAnterior(sTendeAtual);

			}
			
			
		} catch (Exception Erro) {
			objLog.Metodo("Erro na execução de CheckReversao: " + Erro.getMessage()+" [e101a]");
    	//	objLog.Metodo("MySQL().cltRegistros(entre 7)");
		}finally{
    	
			return sReversao;
		}	
	}
		
	public float CalcularStopCP(float fStopCPAtual, float fCloseAnterior, float fResistenciaAnterior, float fComboPercStopCP, String sComboReferencia){
		/*
		 *  Faz comparacoes e ajusta stop-de-venda se necessario
		 *  é uma catraca para cima, se o preço sobe, subimos(3%) o stop-vd 
		 *	
		 *  Considerar que o valor atual é um valor corrente, não esta definido(não sei o que vai ocorrer), [
		 *  por isso tem-se de usar sempre o anterior como referencia - no caso usaremos cotação de 15min
		 *  
		 * 	Referencia fechamento(Anterior - 15Min):
		 * 		Stop-CP: é calculado 3% acima do fechamento do dia Anterior
		 *
		 * 	Referencia Máx/Min(Anterior - 15Min):
		 * 		Stop-CP: é calculado 3% acima da Máx do dia Anterior(Acima da resistência)
		 */
		objLog.Metodo(" AjustarStopCP(StopCP(Atual): "+String.valueOf(fStopCPAtual)
						+", Fech(Ant): "+String.valueOf(fCloseAnterior)
						+", Resist(Ant): "+String.valueOf(fResistenciaAnterior)
						+", StopVD(%): "+String.valueOf(fComboPercStopCP)
						+", Referencia: "+sComboReferencia+")");
	
	
		 /* 
         * A fim de evitar violinadas, o Stop_cp é ajustado 3% acima do 
           fechamento de Ontem, então, se preço cai, devemos baixar nossa linha de Stop
           para:
              Stop_Atual = 10,90 
              Fecha-Ontem = 10,50
           fica:
              StopMed = Fecha-ontem + 3% = 10,50 * 1,03 = 10,81
           então:                        
              SE(StopeMed <= StopAtual)
              SE(10,81 <= 10,90){ 
                Ajusta Stop_cp, desce o Stop_cp para 10,81(3% acima do Fechamento do dia anterior) 
             }
        */
		float fMedeStopCP = 0;
	
		try{
			
			// Se uso referencia de preço o fechamento anterior....
			if(sComboReferencia.contains(objOperacao.sRefClose)){				
				// Stop-CP 3% acima do fechamento anterior
				fMedeStopCP = fCloseAnterior + ((fCloseAnterior * fComboPercStopCP)/100);
			}else{ // Se uso referencia de preço de suporte(Fundo, Min) anterior....
				// Stop-CP 3% acima do Suporte anterior
				fMedeStopCP = fResistenciaAnterior + ((fResistenciaAnterior * fComboPercStopCP)/100);		
			}
			
			// Mede stop-cp atual, para ver se ha necessidade de ajusta-lo para baixo
			//MedeStopCP = ((PrecoTopo * PercStopCP)/100)+PrecoTopo;
			
			if(fStopCPAtual < 1){
				// Se é o 1º operacao, não tem stop definido, pega medida(3% acima do preço atual)
				fStopCPAtual = fMedeStopCP;
			}else{
				/*
				 *  SE já existe valor de stop, NÃO é primeira operacao, 
				 *  ver se é necessario ajustar stop para baixo
				 *  Se valor medido <= StopAtual (preço baixou) entao ajusta stop para baixo, 
				 *  em direcao ao piso(catraca de compra)
				 */
				if(fMedeStopCP <= fStopCPAtual){
					fStopCPAtual = fMedeStopCP;
				}			
			}
			
			
		} catch (Exception Erro) {
			objLog.Metodo("Erro na execução de  AjustarStopCP: " + Erro.getMessage()+" [e201a]");
		//	objLog.Metodo("MySQL().cltRegistros(entre 7)");
		}finally{	
		 	return fStopCPAtual;
		}	
		
	}
	
	public float CalcularOfertaCP(float fPrecoCloseAnterior, float fSuporteAnterior, float fPrecoUltimaVenda, float fComboPercOfertaCP, String sComboTravaCP, String sComboReferencia){
		/*
		 *  Considerar que o valor atual é um valor corrente, não esta definido(não sei o que vai ocorrer), [
		 *  por isso tem-se de usar sempre o Anterior como referencia - no caso usaremos cotação de 15min
		 *  
		 * 	Referencia fechamento(Anterior - 15Min):
		 *  	Oferta-CP: é calculado -0,5% abaixo do fechamento do dia Anterior(preço anterior)
		 *  	
		 * 	Referencia Máx/Min(Anterior - 15Min):
		 *  	Oferta-CP: é calculado 0,5% acima da Min do dia Anterior(preço anterior 15min)
		 */
		
		objLog.Metodo("CalcularOfertaCP( Fech(Anterior): "+String.valueOf(fPrecoCloseAnterior)
				+", Suporte(Anterior): "+String.valueOf(fSuporteAnterior)		
				+", OFC(%): "+String.valueOf(fComboPercOfertaCP)
				+", Referencia: "+sComboReferencia+")");
				
		float fOfertaCP = 0; // usar float pois no calculo percentual(/100) da grande
		
		try{
			
			// Se uso referencia de preço o fechamento anterior....
			if( sComboReferencia.contains(objOperacao.sRefClose) ){	
				/*
				 *  Calcula o preço da oferta de compra, cfe melhor percentual passado(% negativo)
				 *  OFC vai ser x% abaixo do fechamento Anterior
				 */
				fOfertaCP = ((fPrecoCloseAnterior * fComboPercOfertaCP)/100) + fPrecoCloseAnterior;	
				
				/*
				 * Compra pelo menor preço,
				 * Se PrecoFechaAnterior for < OfertaCP(-0,5%) do preço atual
				 * Tenta o menor preço
				 */
				//if(fOfertaCP > fPrecoCloseAnterior){ fOfertaCP = fPrecoCloseAnterior; }
			}else{	// Se refencia é Máx/Min
				/*
				 *  Calcula o preço da oferta de compra, cfe melhor percentual passado(% negativo)
				 *  OFC vai ser x% acima do Suporte
				 */
				float fPercPositivoOfertaCP = Math.abs(fComboPercOfertaCP); // Pega modulo do x%(tira sinal negativo)
				fOfertaCP = fSuporteAnterior + ((fSuporteAnterior * fPercPositivoOfertaCP)/100);	
			
			}
			
			/*
			 *  Limita oferta de compra ao preço = ou abaixo do ultimo preço de venda
			 *  ou seja, so recompramos = ou abaixo da última venda
			 *  Nao faz sentido vender por 10,00 e recomprar por 11,00
			 *  temos de recomprar por 9,00
			 */
			if(!sComboTravaCP.contains("Livre")){	// Se TravarCP != Livre, (Check CP < VD)
				
				if(fPrecoUltimaVenda > 0){
					
					objLog.Metodo("fOfertaCP: " + String.valueOf(fOfertaCP) + ", fPrecoUltimaVenda: "+ String.valueOf(fPrecoUltimaVenda) +")");
					if(fOfertaCP > fPrecoUltimaVenda){ 
						fOfertaCP = fPrecoUltimaVenda; 
						objLog.Metodo("fOfertaCP: " + String.valueOf(fOfertaCP) + " -> foi Limitado ao preço da última venda)");
									
					}
					
					
				}
			}	
			
		} catch (Exception Erro) {
	    	objLog.Metodo("Erro na execução de CalcOfertaCP: " + Erro.getMessage()+" [e301a]");
	    	//	objLog.Metodo("MySQL().cltRegistros(entre 7)");
		}finally{
			objLog.Metodo("CalcularOfertaCP() = "+String.valueOf(fOfertaCP) );
			return fOfertaCP;
		}	
		
	}
	
	public float CalcularStopVD(float fStopVDAtual, float fCloseAnterior, float fSuporteAnterior, float fComboPercStopVD, String sComboReferencia){
		/*
		 *  Faz comparacoes e ajusta stop-de-venda se necessario
		 *  é uma catraca para cima, se o preço sobe, subimos(3%) o stop-vd 
	 	 *
		 *  Considerar que o valor atual é um valor corrente, não esta definido(não sei o que vai ocorrer), [
		 *  por isso tem-se de usar sempre o anterior como referencia - no caso usaremos cotação de 15min
		 *  
		 * 	Referencia fechamento(Anterior - 15Min):
		 *  	Stop-VD: é calculado -3% abaixo do fechamento do dia Anterior
		 *  
		 * 	Referencia Máx/Min(Anterior - 15Min):
		 *  	Stop-VD: é calculado -3% abaixo da Min do dia Anterior(Suporte)
		 */
	
		objLog.Metodo(" CalcularStopVD(StopVD(Atual): "+String.valueOf(fStopVDAtual)
						+", Fech(Ant): "+String.valueOf(fCloseAnterior)
						+", Resist(Ant): "+String.valueOf(fSuporteAnterior)
						+", StopVD(%): "+String.valueOf(fComboPercStopVD)
						+", Referencia: "+sComboReferencia+")");

		
		float fMedeStopVD = 0;
		
		try{
			
			// Se uso referencia de preço o fechamento anterior....
			if(sComboReferencia.contains(objOperacao.sRefClose)){				
				// Stop-VD (-)3% abaixo do fechamento anterior
				fMedeStopVD = ((fCloseAnterior * fComboPercStopVD)/100) + fCloseAnterior;
			}else{ // Se uso referencia de preço a resistencia(Topo, Máx) anterior....
				// Stop-VD (-)3% abaixo do Suporte anterior
				fMedeStopVD = ((fSuporteAnterior * fComboPercStopVD)/100) + fSuporteAnterior;		
			}
			
			if(fStopVDAtual < 1){	// Se stop não foi definido - inicial, seta stop_vd
				fStopVDAtual = fMedeStopVD;// Preço inical do stop_vd será o valor medido(3% abaixo do preço atual)			
			}else{
			/*
             * Segundo estrategia 1 stop é = ao suporte do dia anterior;
               Para evitar violinadas mantemos nosso stop 3% acima(na compra) do fechamento do dia anterior, 
               então:
                   Suporte = 9,00
                   StopVd_Atual = suporte = 9,00
                   Fechamento-dia-anterior = 10,00
               então
                   StopMedeVd = 10,00 * 0.97 = 9,70
                   SE(StopMedeVd >= StopVd_atual)
                   SE(9,70 >= 9,00){
                       Ajustamos nosso Stop para cima, acompanhando a tendencia de Alta
                   }
                       
	             */
				 if(fMedeStopVD >= fStopVDAtual){
					 fStopVDAtual = fMedeStopVD;// Preço de stop_vd será o valor medido(3% abaixo do preço atual)			
					
				 }
			}
		
		} catch (Exception Erro) {
			objLog.Metodo("Erro na execução de AjustarStopVD: " + Erro.getMessage()+" [e401a]");
    	//	objLog.Metodo("MySQL().cltRegistros(entre 7)");
		}finally{						
	
			return fStopVDAtual;
		}	
		
		
		
	}
	
	
	public float CalcularOfertaVD(float fPrecoCompraAtual, float fResistenciaAnterior, float fComboPercOfertaVD, String sComboTravaVD, String sComboReferencia){
		/* 
		 * Calcula o preço da oferta de venda, cfe melhor percentual passado
		 * default 2% acima preço de compra
			 * 	
		 *  Considerar que o valor atual é um valor corrente, não esta definido(não sei o que vai ocorrer), [
		 *  por isso tem-se de usar sempre o anterior como referencia - no caso usaremos cotação de 15min
		 *  
		 * 	Referencia fechamento(Anterior - 15Min):
		 *  	Oferta-VD: é calculado 2% acima do preço de compra 
		 *  
		 * 	Referencia Máx/Min(Anterior - 15Min):
		 *  	Oferta-VD: é calculado 1% abaixo da Máx do dia Anterior(desde que seja 2% acima preço de compra)
		 */
		
		objLog.Metodo("CalcularOfertaVD( Pr.Compra(Atual): "+String.valueOf(fPrecoCompraAtual)
						+", comboVD(%): "+String.valueOf(fComboPercOfertaVD)+")");
		
		
		float fOfertaVD = 0;
			
		try{
			
			// Se uso referencia de preço o fechamento anterior....
			if(sComboReferencia.contains(objOperacao.sRefClose)){				
			
				/*
				 *  Oferta-VD sera o Percentual passado(+2%), 
				 *  um minimo de 2% acima do preço de compra 
				 */
				fOfertaVD = ((fPrecoCompraAtual * fComboPercOfertaVD)/100) + fPrecoCompraAtual;
				
				/*
				 *  Venda pelo melhor preço, 
				 *  Se PrFechaAnterior for > 2% acima da compra, 
				 *  vende pelo melhor preço
				 */
				//if(fOfertaVD < fPrecoFechaAnterior){ fOfertaVD = fPrecoFechaAnterior; }
			}else{	// Usa Máx como referencia
				
				float fOfertaVD_PrCompra = ((fPrecoCompraAtual * fComboPercOfertaVD)/100) + fPrecoCompraAtual;
				
				// Calcula OFV usando a Máx - x% abaixo da Resistencia
				fOfertaVD =  fResistenciaAnterior - ((fResistenciaAnterior * fComboPercOfertaVD)/100);
				
				// Compara Máx com 2% acima da compra e pega o maior preço de venda 
				if(fOfertaVD < fOfertaVD_PrCompra){ fOfertaVD = fOfertaVD_PrCompra; }
			}
			
			/*
			 *  Limita oferta de compra ao preço = ou abaixo do ultimo preço de venda
			 *  ou seja, so recompramos = ou abaixo da última venda
			 *  Nao faz sentido vender por 10,00 e recomprar por 11,00
			 *  temos de recomprar por 9,00
			 */
			if(!sComboTravaVD.contains("Livre")){	// Se TravarVD != Livre, (Check OFVD > OFCP)
				
				if(fPrecoCompraAtual > 0){
					
					objLog.Metodo("fOfertaVD: " + String.valueOf(fOfertaVD) + ", fPrecoCompra: "+ String.valueOf(fPrecoCompraAtual) +")");
					if(fOfertaVD < fPrecoCompraAtual){ 
						fOfertaVD = fPrecoCompraAtual; 
						objLog.Metodo("fOfertaCP: " + String.valueOf(fOfertaVD) + " -> foi Limitado ao preço da última compra)");
									
					}
					
					
				}
			}	
			
				
		} catch (Exception Erro) {
			objLog.Metodo("Erro na execução de CalcOfertaVD: " + Erro.getMessage()+" [e501a]");
		//	objLog.Metodo("MySQL().cltRegistros(entre 7)");
		}finally{	
			return fOfertaVD;
		}
		
	}


	public float[] AnalisarOperacoes(JTable jtPlanilha, int iTotalRegTab, int iComboNumReg, int iComboNumAmostra, float fComboLtb, float fComboLta, float fComboPercStopCP, float fComboPercStopVD, float fComboPercOfertaCP, float fComboPercOfertaVD, String sComboTravaCP, String sComboTravaVD, String sComboReferencia, boolean bTipoOftCV){
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
		/* teste
		bTipoOftCV = objDef.bOftFixada;
		fComboPercOfertaCP = 26.65f;
		fComboPercOfertaVD = 27.78f;
		*/
		
		// Limita num de registros a analisar menor que total de registros na planilha
		if(iTotalRegTab < iComboNumReg){ iComboNumReg = iTotalRegTab-1; }
		
		objLog.Metodo("Calcular.AnalisarOperacoes("+iComboNumReg+")");
		
		objLog.Metodo("AnalisarOperacoes(JTable jtPlanilha), (iTotalRegTab), (iComboNumReg), (iComboNumAmostra), (fComboLtb), (fComboLta), (fComboPercStopCP), (fComboPercStopVD), (fComboPercOfertaCP), (fComboPercOfertaVD), sComboReferencia )");
		 
		objLog.Metodo("AnalisarOperacoes(JTable jtPlanilha), "+String.valueOf(iTotalRegTab)+", "+String.valueOf(iComboNumReg)+", "+String.valueOf(iComboNumAmostra)+", "+String.valueOf(fComboLtb)+", "+String.valueOf(fComboLta)+", "+String.valueOf(fComboPercStopCP)+", "+String.valueOf(fComboPercStopVD)+", "+String.valueOf(fComboPercOfertaCP)+", "+String.valueOf(fComboPercOfertaVD)+", "+ sComboReferencia+")");
	
		
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
	
	
	objLog.Metodo("Calcular.AnalisarOperacoes(S de: "+String.valueOf(iComboNumAmostra)+", ate: "+String.valueOf(iComboNumReg)+")");
	
	try{
		
	for(int iS = iLinIni; iS<= iLinFinal; iS++){
		
		objLog.Metodo("Calcular.AnalisarOperacoes(S = "+String.valueOf(iS)+")");
		
				 
			 
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
					
					// Verifica se Oft de C/V é percentual ou fixada
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
						
						// Verifica se Oft de C/V é percentual ou fixada
						if(bTipoOftCV == objDef.bOftFixada){
							fOfertaCPAtual = fComboPercOfertaCP;
						}else{
							fOfertaCPAtual = this.CalcularOfertaCP(fCloseAnterior, fSuporteAnterior, fValorUltimaVenda, fComboPercOfertaCP, sComboTravaCP, sComboReferencia);
						}
					
						
									
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
						if(bTipoOftCV == objDef.bOftFixada){
							fOfertaVDAtual = fComboPercOfertaVD;
						}else{	
							fOfertaVDAtual = this.CalcularOfertaVD(fPrecoCPAtual, fResistenciaAnterior, fComboPercOfertaVD, sComboTravaVD, sComboReferencia);	// 2% acima preço de compra
						}
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

		objLog.Metodo(" Célula(var S) = "+String.valueOf(iS));	
		objLog.Metodo("-------------------------------------------------------------------");
	
		
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
		
		
		
				
		return fRetorno;
	}	

} // Final metodo AnalisarOperacoes


	
public float[] AnalisarMedias(JTable jtPlanilha, int iTotalRegTab, int iComboNumReg, int iNumAmostra){
	
		// Limita num de registros a analisar menor que total de registros na planilha
		if(iTotalRegTab < iComboNumReg){ iComboNumReg = iTotalRegTab-1; }
			
			
		if(iNumAmostra < 1){ iNumAmostra = 10;		}	// assume valor default caso venha vazia
		objLog.Metodo("AnalisarMedias(JTable jtPlanilha), "+String.valueOf(iTotalRegTab)+", "+String.valueOf(iComboNumReg)+", "+String.valueOf(iNumAmostra)+")");
		
		
		// Memoriza Lista Preços máx e min
		float fListaPrecoMin[] = new float[10000];
		float fListaPrecoMax[] = new float[10000];
		
	
		// Resultado Preço médio Min/Max
		float fMedMin = 0;	
		float fMedMax = 0;
	
		
		float fRetorno[] = new float[1000];
		//float fCandle[] = new float[1000];	// pega vetor de retorno  da analise dos Candle
				

		
		/*
		 *  Executa verradura nos ultimos X(3000) da planilha que 
		 *  pode conter 50.000 registros, baixados do metaTrader
		 *  Então a varredura vai ser de 47.000 a 50.000 e NÃO de 0 a 3000
		 * 
		 *  iComboNumReg = num.reg.a sacanear
		 *  iComboNumAmostra = num.registros Anteriores a analisar para determinar tendencia
		 *  iLinIni  = (50.000 - 3.000) + iComboNumAmostra
		 */
		int iLinIni = (iTotalRegTab - iComboNumReg) + iNumAmostra;
		int iLinFinal = iTotalRegTab - 1;	// Tirei a ultima linha pois tava dando erro("empty String")	
		
		int iContaLin = 0;	// Contagem corrida de linhas pois for() pega faixa de linha da tabela

		
		objLog.Metodo("Calcular.AnalisarMedias(S de: "+String.valueOf(iLinIni) +", ate: "+String.valueOf(iLinFinal)+")");
		
		try{
				
			for(int iS = iLinIni; iS< iLinFinal; iS++){
				
				objLog.Metodo("Calcular.AnalisarOperacoes(S = "+String.valueOf(iS)+")");
				
				// Pega preços médios(máx/min) para calcular médias
				/* Substituindo virgula por pto com REPLACE
				String sPrecoMin = jtPlanilha.getValueAt(iS, objDef.colMIN).toString();
				objLog.Metodo("sPrecoMin: " + sPrecoMin);
				sPrecoMin = sPrecoMin.replaceAll(",", ".");
				objLog.Metodo("sPrecoMin(replace): " + sPrecoMin);
				*/
				
				fListaPrecoMin[iContaLin] = Float.parseFloat( jtPlanilha.getValueAt(iS, objDef.colMIN).toString() );
				fListaPrecoMax[iContaLin] = Float.parseFloat( jtPlanilha.getValueAt(iS, objDef.colMAX).toString() );
						 
					 
		
				objLog.Metodo(" Min = " + String.valueOf(fListaPrecoMin[iContaLin]));	
				objLog.Metodo(" Max = " + String.valueOf(fListaPrecoMax[iContaLin]));	
				objLog.Metodo(" Célula(var S) = " + String.valueOf(iS));	
				objLog.Metodo("-------------------------------------------------------------------");
			
				iContaLin++;	// Contagem corrida de linha, pois for() usa faixa de linhas da tabela
				
			} // for S
			

				
		/***********************************************************************************/
		
		
		} catch (Exception Erro) {
			
			objLog.Metodo("Erro na execução de AnalisarMedias: " + Erro.getMessage() + " [e202b]");
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
			
			// Ordena vetores preço max em ordem crescente
			  for (int x = 0; x < iContaLin; x++) {
			   for (int y = x+1; y < iContaLin; y++) {
				   
				   // Preços mínimos
				   if(fListaPrecoMin[x] < fListaPrecoMin[y] ){
				    	fMemMedMin = fListaPrecoMin[x];
				    	fListaPrecoMin[x] = fListaPrecoMin[y];
				    	fListaPrecoMin[y] = fMemMedMin;
				    }
				   
				   // Preços máximos
				    if(fListaPrecoMax[x] < fListaPrecoMax[y] ){
				    	fMemMedMax = fListaPrecoMax[x];
				    	fListaPrecoMax[x] = fListaPrecoMax[y];
				    	fListaPrecoMax[y] = fMemMedMax;
				    }
					//objLog.Metodo("x: " + String.valueOf(x));	
					
			   }
			  }
			float fSomaMedMin = 0;
			float fSomaMedMax = 0;
			
			
			int iLinI = iContaLin - 1;
			int iLinF = iContaLin - iNumAmostra;
			
			int iContaRetLstMin = objOperacao.iPosLstMinIni;	// Posição inicial da lista Pr-Min
			float fMemorizaPrMin = 0;		
			for(int iMn = iLinI; iMn >= iLinF; iMn--){ 	
				fSomaMedMin = fSomaMedMin + fListaPrecoMin[iMn];
				objLog.Metodo("calcular().Lista.fMedMin("+ String.valueOf(iMn) +"): " + String.valueOf(fListaPrecoMin[iMn]));

				// Passa a lista de preços minimos para Retorno do método
				if(fListaPrecoMin[iMn] != fMemorizaPrMin){	// Compara Preço anterior com atual para evitar repetiçoes
					fRetorno[iContaRetLstMin] = fListaPrecoMin[iMn];
					fMemorizaPrMin = fListaPrecoMin[iMn];	// Memoriza preço adicionado em FRetorno para entiar repetições
					iContaRetLstMin++;
				}	
			}
			
			int iContaRetLstMax = objOperacao.iPosLstMaxIni;	// Posição Inicial da lista Pr-Máx
			float fMemorizaPrMax = 0;
			for(int iMx = 0; iMx < iNumAmostra; iMx++){ 
				fSomaMedMax = fSomaMedMax + fListaPrecoMax[iMx];
				objLog.Metodo("calcular().Lista.fMedMax("+ String.valueOf(iMx) +"): " + String.valueOf(fListaPrecoMax[iMx]));
				
				// Passa a lista de preços máximos para Retorno do método
				if(fListaPrecoMax[iMx] != fMemorizaPrMax){	// Compara Preço anterior com atual para evitar repetiçoes
					fRetorno[iContaRetLstMax] = fListaPrecoMax[iMx];
					fMemorizaPrMax = fListaPrecoMax[iMx];	// Memoriza preço adicionado em FRetorno para entiar repetições
					iContaRetLstMax++;
				}	
			}
			
			
			// Médias
			if(fSomaMedMin > 0){ fMedMin = fSomaMedMin/iNumAmostra; 	}
			if(fSomaMedMax > 0){ fMedMax = fSomaMedMax/iNumAmostra;		}
			
			fRetorno[objOperacao.iPosPrcMin] = fListaPrecoMin[iLinI];
			fRetorno[objOperacao.iPosMedMin] = fMedMin;
			fRetorno[objOperacao.iPosPrcMed] = (fMedMin + fMedMax)/2;
			fRetorno[objOperacao.iPosMedMax] = fMedMax;
			fRetorno[objOperacao.iPosPrcMax] = fListaPrecoMax[0];
			fRetorno[objOperacao.iPosNumAmostra] = iNumAmostra;
			
			
			
			
			objLog.Metodo("calcular().fMedMin(" + String.valueOf(fMedMin) + ")");
			objLog.Metodo("calcular().fMedMax(" + String.valueOf(fMedMax) + ")");
			
			
			// Carrega lista de preços min/max nas combos
			int iLinIni2 = objOperacao.iPosLstMinIni;
			int iLinFim2 = iLinIni2 + iNumAmostra;
			
			for(int iMin = iLinIni2; iMin < iLinFim2; iMin++){ 
				objLog.Metodo("calcular().iMin: "+String.valueOf(iMin)+" = "+String.format("%.2f", fRetorno[iMin]));
			}
			
			int iLinIni3 = objOperacao.iPosLstMinIni;
			int iLinFim3 = iLinIni3 + iNumAmostra;
			
			for(int iMax = iLinIni3; iMax < iLinFim3; iMax++){ 
				objLog.Metodo("calcular().iMax: "+String.valueOf(iMax)+" = "+String.format("%.2f", fRetorno[iMax]));
			}
		
						
						
			return fRetorno;
		}
		
		
	
	} // Final metodo AnalisarMedias

	
	
	
	
}	// Final da Class
