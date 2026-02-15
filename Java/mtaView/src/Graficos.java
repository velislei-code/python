import java.awt.Color;
import java.awt.Font;
import java.awt.Graphics;



import java.awt.Graphics2D;

import javax.swing.JPanel;

public class Graficos extends JPanel{
	
	Definicoes objDef = new Definicoes();
	Log objLog = new Log();
	Ferramentas objUtil = new Ferramentas();
	
	private boolean bZoom = false;
	// Sinais
	private int iLinSrUP[] = {0, 0, 0, 0};	// Linha-Tempo-Sincronismo
	private int iLinSrDN[] = {0, 0, 0, 0};	// Linha-Tempo-Sincronismo
	private int iLinAtUP[] = {0, 0, 0, 0};	// Linha-Tempo-Sincronismo
	private int iLinAtDN[] = {0, 0, 0, 0};	// Linha-Tempo-Sincronismo
	private int iLinCrcUP[] = {0, 0, 0, 0};	// Linha-Tempo-Sincronismo
	private int iLinCrcDN[] = {0, 0, 0, 0};	// Linha-Tempo-Sincronismo

	// Tempos
	private int iLinTSin[] = {0, 0, 0, 0};	// Linha-Tempo-Sincronismo
	private int iLinTAut[] = {0, 0, 0, 0};	// Linha-Tempo-Auth
	private int iLinTNav[] = {0, 0, 0, 0};	// Linha-Tempo-Nav
	
	// Cor dos leds de sincronismo
	private boolean bLedSincMd[] = {false, false, false, false};
	
	private String sClock = "00:00:00";
	
	/*
	 * valores de coordenadas de ajuste ao gráfico
	 */
	private int iLinSrUPAj[] = {0, 0, 0, 0};	// Linha-Tempo-Sincronismo
	private int iLinSrDNAj[] = {0, 0, 0, 0};	// Linha-Tempo-Sincronismo
	private int iLinAtUPAj[] = {0, 0, 0, 0};	// Linha-Tempo-Sincronismo
	private int iLinAtDNAj[] = {0, 0, 0, 0};	// Linha-Tempo-Sincronismo
	private int iLinCrcUPAj[] = {0, 0, 0, 0};	// Linha-Tempo-Sincronismo
	private int iLinCrcDNAj[] = {0, 0, 0, 0};	// Linha-Tempo-Sincronismo

	private int iLinTSinAj[] = {0, 0, 0, 0};	// Linha-Tempo-Sincronismo
	private int iLinTAutAj[] = {0, 0, 0, 0};	// Linha-Tempo-Auth
	private int iLinTNavAj[] = {0, 0, 0, 0};	// Linha-Tempo-Nav
	private int iDesenhe = 0;	// Tipo 0: vazio(entrada), 1: Sin/Aut/Nav, SR/At/Crc, 2: Clock   
	
	
    public void paintComponent(Graphics g){
    
    	super.paintComponent(g);
        
    	objLog.Metodo("Graficos().paintComponent()");
        
    	
    	/************************************************************************/
    	// Grade    
    	
    		g.setFont(new java.awt.Font("Courier New", 0, 11));	
    		g.setColor(Color.gray);

    		// Linhas H
    		for(int iL = 1; iL < objDef.iTotLinGraf; iL++){
    			int iLin = objDef.iLinUpGraf * iL;
    			g.drawLine(objDef.iColIniGraf, iLin, objDef.iColFimGraf - 6, iLin);	// Linha H 
    		}
    		// Linhas V
    		for(int iC = 2; iC <= objDef.iTotColGraf; iC++){
    			int iCol = (objDef.iColIniGraf * iC)/2;
    			g.drawLine(iCol, objDef.iLinUpGraf, iCol, objDef.iLinDnGraf);		// Linha V esquerda
    	
    		}
    	
    	if(iDesenhe == objDef.Grade){
    		// Zera valores
    		for(int i=0; i<4; i++){
        		iLinSrUP[i] = 0;
        		iLinSrDN[i] = 0;
        		iLinAtUP[i] = 0;
        		iLinAtDN[i] = 0;
        		iLinCrcUP[i] = 0;
        		iLinCrcDN[i] = 0;
        		
        		iLinTSin[i] = 0; 
            	iLinTAut[i] = 0;
            	iLinTNav[i] = 0;
            
        	}
    	} //if - Grade
    		/************************************************************************/
        	// Titulo do grafico
        	int iMovVt = 15;
        	int iMovHzE = 15;	// Move-Hz Esquerdo(Sinais)
        	int iMovHzD = 2;	// Move-Hz Direito(Tempo)
        	int iCentra = 8;
            g.setColor(Color.GRAY);
            g.setFont(new Font(Font.SANS_SERIF, Font.PLAIN, 10));
            
            /*
        	 * Ajusta valores 
        	 * Inverte, pois px inicia de cima para baixo(0 -> -n), e;
        	 * Grafico é de baixo para cima (0 -> +n)
        	 */
            
            // Escala padrão(0 a 100) 
           	double dTs = 1.5;		// Multiplica valores(ajusta trajeto da linha cfe valor/tamanho)
           	double dTt = 0.5;		// Multiplica valores(aumenta trajeto da linha)
           	double dZoom = 1;
           
           	
            // Escala 0 a 50
           	if(bZoom){	
            	dTs = 3.0;		// Multiplica valores(ajusta trajeto da linha cfe valor/tamanho)
            	dTt = 1.0;		// Multiplica valores(aumenta trajeto da linha)
            	dZoom = 2;
            }
         

            int iAjLin = 0;
            int iAjCol = 0;
            // Valores de Y(Sinais)
            for(int iTit=0; iTit<6; iTit++){
            	
            	double dSeg = iTit / dZoom;
            	String sVTit = String.valueOf( (int)(iTit * 20 / dZoom) );
            	
            	String sT = objUtil.DoubleToHora(dSeg);
            	
            	
            	// Ajusta coluna cfe tamanho da string
            	if(sVTit.length() == 3){ iAjCol = 5;}
            	if(sVTit.length() == 2){ iAjCol = 0;}
            	if(sVTit.length() == 1){ iAjCol = -5;}
            	
            	g.drawString(sVTit, objDef.iColIniGraf - iMovHzE - iAjCol, objDef.iLinUpGraf + 170 - iAjLin );
            	if(dSeg > 0){ g.drawString(sT, objDef.iColFimGraf + iMovHzD, objDef.iLinUpGraf + 170 - iAjLin); }
             	iAjLin = iAjLin + 30;
             	
            }

            
            // Legenda de sinais(Horizontal)
            g.drawString("SrUP", objDef.iColGSrUp - iCentra, objDef.iLinDnGraf + iMovVt);
            g.drawString("SrDn", objDef.iColGSrDn - iCentra, objDef.iLinDnGraf + iMovVt);
            g.drawString("AtUP", objDef.iColGAtUp - iCentra, objDef.iLinDnGraf + iMovVt);
            g.drawString("AtDn", objDef.iColGAtDn - iCentra, objDef.iLinDnGraf + iMovVt);
            g.drawString("CrcUP", objDef.iColGCrcUp - iCentra, objDef.iLinDnGraf + iMovVt);
            g.drawString("CrcDn", objDef.iColGCrcDn - iCentra, objDef.iLinDnGraf + iMovVt);
            g.drawString("S(t)", objDef.iColGSinc - iCentra, objDef.iLinDnGraf + iMovVt);
            g.drawString("A(t)", objDef.iColGAuth - iCentra, objDef.iLinDnGraf + iMovVt);
            g.drawString("N(t)", objDef.iColGNav - iCentra, objDef.iLinDnGraf + iMovVt);
            
            
        	// Titulo do grafico
            g.setColor(Color.blue);
            g.setFont(new Font(Font.SANS_SERIF, Font.BOLD, 14));
            g.drawString("mtaGS", 25, 30);
            
            // Legendas
            int iPosV = 80;
            int iPosH = 25;
            
            // Led de Sinc.
            int iPosLedV = 72;
            int iPosLedH = 65;
            
            g.setFont(new Font(Font.SANS_SERIF, Font.PLAIN, 12));
            g.setColor(Color.BLUE);        
            g.drawString("Md0", iPosH, iPosV);
            
            g.setColor(Color.ORANGE);        
            g.drawString("Md1", iPosH, iPosV + 20);

           
            g.setColor(Color.GREEN);        
            g.drawString("Md2", iPosH, iPosV + 40);
            
            
            g.setColor(Color.decode(objDef.BROW));  // Marrom      
            g.drawString("Md3", iPosH, iPosV + 60);

            // Led de sincronismo - Md0
            if(bLedSincMd[0] ){ g.setColor(Color.GREEN); }else{g.setColor(Color.RED);}
            g.fillOval(iPosLedH - objDef.iCentro, iPosLedV - objDef.iCentro, objDef.iTamLedSinc, objDef.iTamLedSinc);		// Bolinha
            // Led de sincronismo - Md1
            if(bLedSincMd[1] ){ g.setColor(Color.GREEN); }else{g.setColor(Color.RED);}
            g.fillOval(iPosLedH - objDef.iCentro, (iPosLedV + 20) - objDef.iCentro, objDef.iTamLedSinc, objDef.iTamLedSinc);		// Bolinha
            // Led de sincronismo - Md2
            if(bLedSincMd[2] ){ g.setColor(Color.GREEN); }else{g.setColor(Color.RED);}
            g.fillOval(iPosLedH - objDef.iCentro, (iPosLedV + 40) - objDef.iCentro, objDef.iTamLedSinc, objDef.iTamLedSinc);		// Bolinha
            // Led de sincronismo - Md3
            if(bLedSincMd[3] ){ g.setColor(Color.GREEN); }else{g.setColor(Color.RED);}
            g.fillOval(iPosLedH - objDef.iCentro, (iPosLedV + 60) - objDef.iCentro, objDef.iTamLedSinc, objDef.iTamLedSinc);		// Bolinha
            
        	
        
          //  if(iDesenhe == objDef.Clock){
            	// Clock
            	objLog.Metodo("Graficos().if(iD == Ck){ " + sClock + "}");
            	g.setFont(new Font(Font.SANS_SERIF, Font.PLAIN, 12));
            	g.setColor(Color.GREEN);        
            	g.drawString(sClock, 20, 200);
           // }
    	/************************************************************************/
        // Desenha linhas    	
            	
    		   
        	
        	for(int i=0; i<4; i++){
        		objLog.Metodo("Graficos().Desenhe linhas, iLinSrUPAj[i] :" + iLinSrUPAj[i] );
        		
        		iLinSrUPAj[i] = (int)(objDef.iLinDnGraf - (iLinSrUP[i] * dTs));
        		iLinSrDNAj[i] = (int)(objDef.iLinDnGraf - (iLinSrDN[i] * dTs));
        		iLinAtUPAj[i] = (int)(objDef.iLinDnGraf - (iLinAtUP[i] * dTs));
        		iLinAtDNAj[i] = (int)(objDef.iLinDnGraf - (iLinAtDN[i] * dTs));
        		iLinCrcUPAj[i] = (int)(objDef.iLinDnGraf - (iLinCrcUP[i] * dTs));
        		iLinCrcDNAj[i] = (int)(objDef.iLinDnGraf - (iLinCrcDN[i] * dTs));
        		
        		iLinTSinAj[i] = (int)(objDef.iLinDnGraf - (iLinTSin[i] * dTt)); 
            	iLinTAutAj[i] = (int)(objDef.iLinDnGraf - (iLinTAut[i] * dTt));
            	iLinTNavAj[i] = (int)(objDef.iLinDnGraf - (iLinTNav[i] * dTt));
            
            	// Limites
            	if(iLinTSinAj[i] < objDef.iLinUpGraf){ iLinTSinAj[i] = objDef.iLinUpGraf; }
            	if(iLinTAutAj[i] < objDef.iLinUpGraf){ iLinTAutAj[i] = objDef.iLinUpGraf; }
            	if(iLinTNavAj[i] < objDef.iLinUpGraf){ iLinTNavAj[i] = objDef.iLinUpGraf; }
        	}
        
    		
    		for(int iM=0; iM<4; iM++){
    			objLog.Metodo("Graficos().Desenhe linhas - 10)");
    				// Modem 1
    				switch(iM){
    					case 0: g.setColor(Color.BLUE); break;
    					case 1: g.setColor(Color.ORANGE); break;
    					case 2: g.setColor(Color.GREEN); break;
    					case 3: g.setColor(Color.decode(objDef.BROW)); break; // Marrom
    				}
    				objLog.Metodo("Graficos().Desenhe linhas - 11)");
    				// SrUP
    				g.drawLine(objDef.iColIniGraf, objDef.iLinDnGraf, objDef.iColGSrUp, iLinSrUPAj[iM]);		// Linha H 
    				g.fillOval(objDef.iColGSrUp - objDef.iCentro, iLinSrUPAj[iM] - objDef.iCentro, objDef.iTamPingo, objDef.iTamPingo);		// Bolinha
    				
    				objLog.Metodo("Graficos().Desenhe linhas - 12)");
    				// SrDN
    				g.drawLine(objDef.iColGSrUp, iLinSrUPAj[iM], objDef.iColGSrDn, iLinSrDNAj[iM]);		// Linha H 
    				g.fillOval(objDef.iColGSrDn - objDef.iCentro, iLinSrDNAj[iM] - objDef.iCentro, objDef.iTamPingo, objDef.iTamPingo);		// Bolinha

    				// AtUP
    				g.drawLine(objDef.iColGSrDn,iLinSrDNAj[iM], objDef.iColGAtUp, iLinAtUPAj[iM]);		// Linha H 
    				g.fillOval(objDef.iColGAtUp - objDef.iCentro, iLinAtUPAj[iM] - objDef.iCentro, objDef.iTamPingo, objDef.iTamPingo);		// Bolinha

    				// AtDN
    				g.drawLine(objDef.iColGAtUp, iLinAtUPAj[iM], objDef.iColGAtDn, iLinAtDNAj[iM]);		// Linha H 
    				g.fillOval(objDef.iColGAtDn - objDef.iCentro, iLinAtDNAj[iM] - objDef.iCentro, objDef.iTamPingo, objDef.iTamPingo);		// Bolinha

    				// CrcUP
    				g.drawLine(objDef.iColGAtDn, iLinAtDNAj[iM], objDef.iColGCrcUp, iLinCrcUPAj[iM]);		// Linha H 
    				g.fillOval(objDef.iColGCrcUp - objDef.iCentro, iLinCrcUPAj[iM] - objDef.iCentro, objDef.iTamPingo, objDef.iTamPingo);		// Bolinha

    				// CrcDN
    				g.drawLine(objDef.iColGCrcUp, iLinCrcUPAj[iM], objDef.iColGCrcDn, iLinCrcDNAj[iM]);		// Linha H 
    				g.fillOval(objDef.iColGCrcDn - objDef.iCentro, iLinCrcDNAj[iM] - objDef.iCentro, objDef.iTamPingo, objDef.iTamPingo);		// Bolinha
    			
    				// Sinc       			
    				g.drawLine(objDef.iColGCrcDn, iLinCrcDNAj[iM], objDef.iColGSinc, iLinTSinAj[iM]);		// Linha H 
    				g.fillOval(objDef.iColGSinc - objDef.iCentro, iLinTSinAj[iM] - objDef.iCentro, objDef.iTamPingo, objDef.iTamPingo);		// Bolinha

    				// Auth
    				g.drawLine(objDef.iColGSinc, iLinTSinAj[iM], objDef.iColGAuth, iLinTAutAj[iM]);		// Linha H 
    				g.fillOval(objDef.iColGAuth - objDef.iCentro, iLinTAutAj[iM] - objDef.iCentro, objDef.iTamPingo, objDef.iTamPingo);		// Bolinha

    				// Navega
    				g.drawLine(objDef.iColGAuth, iLinTAutAj[iM], objDef.iColGNav, iLinTNavAj[iM]);		// Linha H 
    				g.fillOval(objDef.iColGNav - objDef.iCentro, iLinTNavAj[iM] - objDef.iCentro, objDef.iTamPingo, objDef.iTamPingo);		// Bolinha
		
    				objLog.Metodo("Graficos().Desenhe linhas - 13)");
    			}	// For...
    			if(sClock == "00:00:00"){
    				objLog.Metodo("Graficos().Desenhe linhas - 14)");
    				// 	Esconde linhas - no start
    				g.setColor(Color.gray);
    				g.drawLine(objDef.iColIniGraf, objDef.iLinDnGraf, objDef.iColFimGraf, objDef.iLinDnGraf);		// Linha V esquerda
    				objLog.Metodo("Graficos().Desenhe linhas - 15)");
    			}
    	//	}	// Desenhe-linhas
    	
    	    
       
        
        /* Não esta funcionando - verificar
    	// titulo vertical
    	Graphics2D g2d = (Graphics2D) g; // faz conversão de g para Graphics2D
    	 
        g2d.setColor(Color.BLUE);
        // rotaciona o sistema de coordenadas (gira -90 graus)
        g2d.rotate(Math.PI / -2.0); // PI equivale a 180 graus
        g2d.setFont(new Font(Font.SANS_SERIF, Font.BOLD, 12));
        g2d.drawString("SCAN", 30, 70);
        */
        
    	/************************************************************************/
    			objLog.Metodo("Graficos().Desenhe linhas - 16)");
    } // metodo
    
    public void setSinais(int iModem, int iSrUP, int iSrDN, int iAtUP, int iAtDN, int iCrcUP, int iCrcDN) {       
        
    	objLog.Metodo("Graficos().setSinais()");
    	
    	iLinSrUP[iModem] = iSrUP;
        iLinSrDN[iModem] = iSrDN;
        iLinAtUP[iModem] = iAtUP;
        iLinAtDN[iModem] = iAtDN;
        iLinCrcUP[iModem] = iCrcUP;
        iLinCrcDN[iModem] = iCrcDN;
        
    }
    
    public void setTempos(int iModem, int iS, int iA, int iN) {       
        iLinTSin[iModem] = iS;
        iLinTAut[iModem] = iA;
        iLinTNav[iModem] = iN;
     
    }
    
    public void setLeds(boolean bLed0, boolean bLed1, boolean bLed2, boolean bLed3) {       
        bLedSincMd[0] = bLed0;
        bLedSincMd[1] = bLed1;
        bLedSincMd[2] = bLed2;
        bLedSincMd[3] = bLed3;
    }
    
    public void setClock(String sC){
    	objLog.Metodo("Graficos().setClock( " + sC + ")");
    	sClock = sC;
    }
    public void repinte(int iTipo, boolean bZ) {  
    	objLog.Metodo("Graficos().repinte()");
    	iDesenhe = iTipo;
    	bZoom = bZ;		// Ajuste de Zoom
        repaint();
    } // fim do metodo setTipoGrafico

}