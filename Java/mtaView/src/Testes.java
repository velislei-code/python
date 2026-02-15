
public class Testes {
/*
	public void TesteDsl2500e(){
    	
	    
    	ActionListener alTarefaScan = new ActionListener(){
    		public void actionPerformed(ActionEvent evt) { 
    			String sCapturaCom = "";
    			
    			if(iSeg == 60){ iSeg = 0; iMin++; }
    			if(iMin == 60){ iMin = 0; iHora++; }
    			tfStatus.setText("mtaView - Em teste:  " + iHora + ":" + iMin + ":" + iSeg);
    			
    			if( (iSeg == 10) ){
    		    		sCapturaCom = objDsl2500e.connect(objDef.STATUS, "192.168.1.103","admin","admin",23,null);    		    		    		
    		    		String sCapturaComAnterior = taTelnet.getText();
    		    		taTelnet.setText(sCapturaComAnterior + sCapturaCom);
    		    		objArquivo.GravarTxt("Status1.txt", sCapturaCom); 		// Grava captura de linhas em arquivo texto
    			}
    			if( (iSeg == 20) ){
		    		sCapturaCom = objDsl2500e.connect(objDef.PING, "192.168.1.103","admin","admin",23,null);    		    		    		
		    		String sCapturaComAnterior = taTelnet.getText();
		    		taTelnet.setText(sCapturaComAnterior + sCapturaCom);
		    		objArquivo.GravarTxt("Status1.txt", sCapturaCom); 		// Grava captura de linhas em arquivo texto
    			}
    			if( (iSeg == 30) ){		
    		    		LerTxt(objDef.STATUS, "Status1.txt", objDef.Intelbras, 0);	// Teste
    			}
    		    				
    			    			
    			
    			iSeg++;            	
        	}
    	};
    	Timer tScanModem = new Timer(1000, alTarefaScan);
    	tScanModem.start();
    }

    public void SimulaDsl2500e(){
    	
        
    	ActionListener alTarefaScan = new ActionListener(){
    		public void actionPerformed(ActionEvent evt) { 
    			String sCapturaCom = "";
    			String sArqCom = "Com_Dsl2500e.txt";
    			
    			if(iSeg == 60){ iSeg = 0; iMin++; }
    			if(iMin == 60){ iMin = 0; iHora++; }
    			tfStatus.setText("mtaView - Em teste:  " + iHora + ":" + iMin + ":" + iSeg);
    			
    			if( (iSeg == 1) ){
    				objDsl2500e.Simula(objDef.STATUS, taTelnet);
		    		objArquivo.GravarTxt(sArqCom, taTelnet.getText()); 		// Grava captura de linhas em arquivo texto
		    		taLog.setText("Copia texto de: " + taTelnet.getText());
    			}
    			if( (iSeg == 3) ){		
    		    		LerTxt(objDef.STATUS, sArqCom, objDef.Dsl2500e, 0);	// Teste
    			}
    		    				
    			    			
    			
    			iSeg++;            	
        	}
    	};
    	Timer tScanModem = new Timer(1000, alTarefaScan);
    	tScanModem.start();
    }
*/
    
}
