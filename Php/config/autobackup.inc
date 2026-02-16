<?Php
//**********************************************************************************************************
// Executa Auto-Backup das Tabelas Rede
	$data = date("dMy");
			//Comandos
			$origem[0]="C:/Program Files/wamp/bin/mysql/mysql5.6.12/data/Rede/comandos.frm";
			$destino[0]="F:/BACKUP/MySql/Rede/".$data."_comandos.frm";
			
			$origem[1]="C:/Program Files/wamp/bin/mysql/mysql5.6.12/data/Rede/comandos.MYD";
			$destino[1]="F:/BACKUP/MySql/Rede/".$data."_comandos.MYD";
			
			$origem[2]="C:/Program Files/wamp/bin/mysql/mysql5.6.12/data/Rede/comandos.MYI";
			$destino[2]="F:/BACKUP/MySql/Rede/".$data."_comandos.MYI";
						
			
			//  rename("C:/Server/fundo/fundo.jpg", "C:/Server/fundo/atl.jpg");
		
		for($B = 0;$B <= 2;$B++){ 
			if copy($origem[$B], $destino[$B]){$Copia[0] = 1;} 
		}			
//**********************************************************************************************************
		echo"backup executado em: F:/BACKUP/MySql/Rede/";
?>