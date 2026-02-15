
import java.io.*;
import java.net.*;

import javax.swing.JTextArea;

public class Ping{
	
	public static boolean Ping(String sHost){
		 
		 
	     try {
	       InetAddress iaEndereco = InetAddress.getByName(sHost);
	       System.out.println("Name: " + iaEndereco.getHostName());
	       System.out.println("Addr: " + iaEndereco.getHostAddress());      
	       System.out.println("LoopBack: " + iaEndereco.getLoopbackAddress());
	       return iaEndereco.isReachable(3000);
	     }
	     catch (UnknownHostException e) {
	       System.err.println("Não foi possível pesquisar: " + sHost);
	       return false;
	     }
	     catch (IOException e) {
	       System.err.println("Não foi possível alcançar: " + sHost);
	       return false;
	     }
	}
	
  public static boolean Pingar(JTextArea taPing, String sHost){
	
	  
	 
     try {
    	
    	 
       InetAddress iaEndereco = InetAddress.getByName(sHost);
       taPing.setText(taPing.getText() + "\n" + "Nome: " + iaEndereco.getHostName());
       taPing.setText(taPing.getText() + "\n" + "IP: " + iaEndereco.getHostAddress());  
       
       /*
        *  Se Host(IP) Não contem(Nome) 
        *  é porque pegou nome da máquina, que é diferente do IP(Soiuz-PC != 192.168.1.4
        *  então esta ativa, mas pode não estar respondendo a ping
        */
       String sParteDoHost = sHost.substring(0, 3);
       
       if(!iaEndereco.getHostName().contains(sParteDoHost)){
    	   taPing.setText(taPing.getText() + "\n" + "Nome Não contém parte do IP");
    	   
    	   if(iaEndereco.isReachable(3000)){
    		   taPing.setText(taPing.getText() + "\n" + "O modem esta ativo e respondendo");
    	   }else{
    		   taPing.setText(taPing.getText() + "\n" + "O modem esta ativo mas não responde");
    	   }
    	   
       }else{    	   
    	   taPing.setText(taPing.getText() + "\n" + "Nome contém parte do IP");
    	   if(iaEndereco.isReachable(3000)){
    		   taPing.setText(taPing.getText() + "\n" + "O modem desconhecido, porém está respondendo");
    	   }else{
    		   taPing.setText(taPing.getText() + "\n" + "O modem esta inativo");
    	   }  	   
       }
       
       taPing.setText(taPing.getText() + "\n" + "LoopBack: " + iaEndereco.getLoopbackAddress());
       return iaEndereco.isReachable(3000);
     }
     catch (UnknownHostException e) {
    	 taPing.setText(taPing.getText() + "\n" + " Não foi possível pesquisar: " + sHost);
       return false;
     }
     catch (IOException e) {
    	 taPing.setText(taPing.getText() + "\n" + " Não foi possível alcançar: " + sHost);
       return false;
     }
     
		
     
  }

 
  
 /*
  * Não esta funcionando, sempre retorna True, mesmo qdo ip não existe
  *
  public static void main(String args[]) {
		 boolean bTeste = Ping("10.42.0.200");
		 
		 System.out.println("Alcance: " + bTeste);
  }
	
 */

}