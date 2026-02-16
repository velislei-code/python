<?php  

/**
 * MySQL - Classe de manipula��o banco MySQL
 * NOTE: Requer PHP vers�o 5 ou superior
 * @package Biblioteca
 * @author Treuk, Velislei A.
 * @email: velislei@gmail.com
 * @copyright 2010 - 2015 
 * @licen�a: Estudantes
 */
 
 




class Funcao {


	function Mensagem($TitMsg, $Msg, $btnMsgCancela, $btnMsgConfirma, $Tipo, $Grau){

		if($Tipo == defConfirma){ include_once("mensagens/confirma.inc"); }
		else if($Tipo == defAviso){ include_once("mensagens/aviso.inc"); }
	}
			
		function Backup($Tabela)
		{
				
				//**********************************************************************************************************
				// Executa Auto-Backup das Tabelas
				
				if($Tabela =='comandos'){$Pasta = "Rede"; } 
				if($Tabela == 'modulos'){$Pasta = "Spart"; } 
				$origemX="C:/Program Files/wamp/bin/mysql/mysql5.6.12/data/".$Pasta."/".$Tabela.".frm";
				//echo"OrigemX: $origemX <br>";
				$data = date("dMy");
					//".$Tabela."
					$origem[0]="C:/Program Files/wamp/bin/mysql/mysql5.6.12/data/".$Pasta."/".$Tabela.".frm";
					$destino[0]="E:/BACKUP/MySql/".$Pasta."/".$data."_".$Tabela.".frm";
					
					$origem[1]="C:/Program Files/wamp/bin/mysql/mysql5.6.12/data/".$Pasta."/".$Tabela.".MYD";
					$destino[1]="E:/BACKUP/MySql/".$Pasta."/".$data."_".$Tabela.".MYD";
					
					$origem[2]="C:/Program Files/wamp/bin/mysql/mysql5.6.12/data/".$Pasta."/".$Tabela.".MYI";
					$destino[2]="E:/BACKUP/MySql/".$Pasta."/".$data."_".$Tabela.".MYI";
								
					
					//  rename("C:/Server/fundo/fundo.jpg", "C:/Server/fundo/atl.jpg");
				
				for($B = 0;$B <= 2;$B++){ 
					if( copy($origem[$B], $destino[$B]) ){  $Copia[$B] = 1; } 
				}			
		//**********************************************************************************************************
						
					$Soma = $Copia[0] + $Copia[1] + $Copia[2];
					if($Soma == 3){ $Resulta[1] = "Backup executado em: F(MicroSD):/BACKUP/MySql/".$Pasta."/"; }
					else{ $Resulta[1] = "Ocorreu um erro ao tentar copiar as tabela(s): $Tabela !";}
					
					$Resulta[0] = "F(MicroSD):/BACKUP/MySql/".$Pasta."/";
					
				return ($Resulta);	

		}


		function NumToMask($num)
		{
			// Retorna a mascara(/24) formatada em 255.255.255.0
			$bin = "";
			$mask="";
			$ResNum = 32 - $num;
			
			
			for($add1 = $ResNum; $add1 < 32; $add1++)
			{
				$bin = $bin."1";
			}
			
			for($add0 = 0; $add0 < $ResNum; $add0++)
			{
				$bin = $bin."0";
			}
			$fx[0] = substr($bin,0,8);
			$fx[1] = substr($bin,8,8);
			$fx[2] = substr($bin,16,8);
			$fx[3] = substr($bin,24,8);
			
			for($g=0; $g<=3; $g++){
			
				$dec[$g] = bindec($fx[$g]);
				
			}
			// Imprime a forma bin�ria da mascara
			// echo"$fx[0].$fx[1].$fx[2].$fx[3] <br>";	
			
			$mask[0] = "$dec[0].$dec[1].$dec[2].$dec[3]";
			$mask[1] = $dec[3];
			
			return $mask;
		}

		function IpToGateway($ip)
		{
		// Retorna o gateway da rede
			
			$FinalIP = substr($ip,-4);	
			$PosDoPto = strpos($FinalIP, ".");
			$FinalIP = substr($FinalIP,$PosDoPto,3);
			$PosDoFinal = strpos($ip,$FinalIP);
			$ParteIp = substr($ip,0,$PosDoFinal);
			$Gateway = $ParteIp.".1";
			
			// Mostra evolu��o
			// echo"FinalIP: $FinalIP -> $ParteIp -> $Gateway <br>";
			
			return $Gateway; 
		}

		function DivRedes($ip,$mask)
		{
			// Divide as redes cfe a mascara e retorna o final da primeira rede
			// Para a mascara: 255.255.255.128
			// rede 1: 192.168.1.0 a 127
			// rede 2: 192.168.1.128 a 256

			$PCs = 256 - $mask;
			$Nets = 256 / $PCs;
			
			
			for($r=0;$r < $Nets; $r++){
				$Rd[$r] = ($PCs * $r);
				if( ($ip > $Rd[$r])and($ip < $Rd[$r]+$PCs)){ $rede[0] = $Rd[$r]; }
				// echo"L1: $r: $Rd[$r] <br>";
			}
			
			// echo"L2: RD: $Nets, PC: $PCs <br>";
			$rede[1] = $rede[0]+1;			// gateway	
			$rede[3] = ($rede[0]+$PCs) - 1; //$broadcast
			$rede[2] = $ip;					// IP
			
			if($rede[1] == $rede[2]){ $rede[2] = $ip+1;}
			// echo"L3: $rede[1], $rede[2]  <br>";
			return $rede;

		}

		function CheckHexa($Octeto)
		{
			/*
			* Faz uma checagem no octeto hexadecimal, 
			* Abrevia, tira zeros a esquerda 
			*/
			$Res = $Octeto;
			if(ctype_xdigit ( $Octeto )){	// Verifica se formato � hexa
			
				$Oct_Array = str_split($Octeto);
				for($i=0; $i<4; $i++){
					$Ini = $i +1;
					$Fim = 4 - $i;
					if($Oct_Array[$i] == "0"){ $Res = substr($Octeto, $Ini, $Fim); }
					else{ break; }
					
				}
				if(empty($Res)){ $Res = ":"; }
				
			}else{
				echo "Formato inv�lido($Octeto)."."<br>";
			}
			
			return $Res;
					
			
		}

		function AbreviaIPv6($Oct1, $Oct2, $Oct3, $Oct4, $Oct5, $Oct6, $Oct7, $Oct8, $Mask)
		{
			$Res = $Res.$this->CheckHexa($Oct1).":";
			$Res = $Res.$this->CheckHexa($Oct2).":";
			$Res = $Res.$this->CheckHexa($Oct3).":";
			$Res = $Res.$this->CheckHexa($Oct4).":";
			$Res = $Res.$this->CheckHexa($Oct5).":";
			$Res = $Res.$this->CheckHexa($Oct6).":";
			$Res = $Res.$this->CheckHexa($Oct7).":";
			$Res = $Res.$this->CheckHexa($Oct8).":";

			$Res_Array = str_split($Res);
			$Tam = count($Res_Array);
			for($i=0; $i<$Tam; $i++){
				$j = $i+1;
				$k = $i+2;
				// Exclui ':' a cada sequencia de ':::'
				if(($Res_Array[$i] == ":")&&($Res_Array[$j] == ":")&&($Res_Array[$k] == ":")){ $Res_Array[$i] = ""; }
				//if(($Res_Array[$Tam-1] == ":")&&($Res_Array[$Tam-2] != ":")&&($Res_Array[$Tam-3] != ":")){ $Res_Array[$i] = ""; }		// Tira ultimo ':', no final
			}	
			
			$Tam2 = count($Res_Array);
			for($ia=0; $ia<$Tam2; $ia++){
				
				//echo $Res_Array[$ia];
				$Res2 = $Res2.$Res_Array[$ia];
			}
			
			$Res3 = $Res2."/".$Mask;
			if((strpos($Res3, ":/"))&&(!strpos($Res3, "::/"))){ $Res4  = str_replace(':/', '/', $Res3); }
			else{ $Res4 = $Res3; }
			
			return $Res4;

		}


		function SalvarCSV($R,$Linha)
		{
			
			
			$hora = date(" - H:i:s"); 
			$hoje = date("dMy"); 
			$Dir = "C:/LIWIX/Oi/Backup/rd2/";
			$Dir2 = "C:/Program Files/wamp/www/rd2/pt/backup/";
			$Arq = $Dir2."TabCmd_".$hoje.'.csv';
			if($R < 1){ RegistrarLog('funcoes.SalvarCSV(Linha) ['.$Arq.'] '.$R.'... n'); }
			
			$file = fopen($Arq, 'a');
			fwrite($file, $Linha."\n");
			fclose($file);
			
			
		}

		function RegistrarLog($Funcao)
		{
			$EnableLog = false;
			if($EnableLog){
				
				$hora = date(" - H:i:s"); 
				$hoje = date("dM"); 
				$Agora = date("H:i:s");

				$Origem = substr($Funcao,0,6);
				if($Origem =='OnLoad'){ $Funcao = "\n".$Funcao.$hora; }	// Pular uma linha, adiciona hora
			
				$file = fopen('log/LogFuncao'.$hoje.'.txt', 'a');
				fwrite($file, $Agora.' '.$Funcao."\n");
				fclose($file);
			}
			
		}

		function MedirMenu($M)
		{
			$TamT = 0;
			// Retorna a soma dos char do menu(ajusta Tam espa�o)
			for($T=0; $T<9; $T++)
			{
				$TamM[$T] = strlen($M[$T]);
				$TamT = $TamT + $TamM[$T];		
				// echo"$T $M[$T]: $TamM[$T] <br>";
			}
			
			
			return($TamT);
		}

		function ContaSeparaFrase($Frase)
		{

			$array=explode(" ",$Frase);	// Separa/Armazena palavras
			$Qtas=count($array);

			$Resulta[0] = $Qtas;	// Armazena o n�mero total de palavras encontradas
			for($N=0; $N < $Qtas;$N++)
			{	
				$Nb =$N+1;
				$Resulta[$Nb] = $array[$N]; 	// Passa valores de array p/ resulta
			}

			return($Resulta);	
		}

		function StrToASCII($string)
		{
			// Converte Texto para ASCII
			
				$ascii = NULL;
		
				for ($i = 0; $i < strlen ($string); $i++) 
				{ 
					$ascii += ord ($string[$i]); 
				}
		
				return($ascii);
		}

		function ContarLinhas($ThemeTexto)
		{
			// Retorna Numero de linhas da String
			
			$NumLin = 0;	
			if(!empty($ThemeTexto)){
				$TamTexto = strlen($ThemeTexto);
				
				for($X=0; $X < $TamTexto; $X++){
					$Letra = $ThemeTexto[$X];	
					$ASC = $this->StrToASCII($Letra);
					if($ASC=='10'){ $NumLin++; }	// ASCII 10 = Nova Linha
					// echo"$Letra = $ASC <br>";	// Imprime
				}
			}
			return ($NumLin);
		}

		function VerAutenticacao()
		{
			// Inicializa var
			$LogCookie="";
			$usuario = "";
			
			// Autenticando usu�rio
			if(isset($_COOKIE['LoginCookie'])){
				$LogCookie=$_COOKIE['LoginCookie'];
				$AccCookie=$_COOKIE['AcessoCookie'];
			}else{
				$LogCookie="";
				$AccCookie="";
			}
			

			if($AccCookie=='Autenticado'){
				// $resultado[0] = true;
				// $resultado[1] = $LogCookie;		
				$usuario = $LogCookie;		
			}else{
				// Login/Senha incorretos - Redirenciona p�gina(Retorna p/ login.php) 	
				//echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=login.php?login+fail&*reg=1001'>";
				// $resultado[0] = false;
			}   //Fim de verificacao de acesso.
			
			// return($resultado);
			return $usuario;
		}

		function Cripto($Dd, $Sn){	
		// Critografar Dados com Senha	
			
			$TamSn = strlen($Sn);
			$TamDd = strlen($Dd);

			$JuntaChar = "";

			$NumS=0;
			for( $d=0; $d < $TamDd; $d++ ){
					
				// Pega Cod-Ascii de Sn e Dd
				$Ascii_Dd = ord($Dd[$d]);				// Pega Cod-Ascii
				$Ascii_Sn = ord($Sn[$NumS]);
				$SomaAscii = $Ascii_Dd + $Ascii_Sn;		// Soma Cod-Ascii
				$CharSoma[$d] = chr($SomaAscii);			// Pega Char da Soma(Ascii)
				//printf("[%s], ", $CharSoma[$d]);

				$JuntaChar = $JuntaChar.$CharSoma[$d];
												
				$NumS++;
				if($NumS >= $TamSn){ $NumS=0; }
				
				
			}

			$Dd_cripto = base64_encode($JuntaChar);
			$Dd_criptoX = $Dd_cripto.'[Cripto]';		// Indicador de criptografia p/ usar em Ler e editar(Mostra/esconde botoes)

			return $Dd_criptoX;

		}

		function Decripto($Dd, $Sn){
		// Descritografa dados com Senha	

				$valor_descripto = base64_decode($Dd); // Volta ao ao valor JuntaChar
				
				$TamDesC = strlen($valor_descripto);
				$TamSn = strlen($Sn);

				$JuntaSubtraiChar ="";
				$NumSd=0;
				for( $dc=0; $dc < $TamDesC; $dc++ ){
						
					$arrayDc[$dc] = $valor_descripto[$dc];

					// Pega Cod-Ascii de Sn e Dd
					$Ascii_Dd = ord($arrayDc[$dc]);				// Pega Cod-Ascii
					$Ascii_Sn = ord($Sn[$NumSd]);

					
					$SubtraiAscii = $Ascii_Dd - $Ascii_Sn;		// Subtrai Cod-Ascii de Dados-Senha
					$CharSubtrai[$dc] = chr($SubtraiAscii);		// Pega Char da Soma(Ascii)
					//printf("%s", $CharSubtrai[$dc]);

					$JuntaSubtraiChar = $JuntaSubtraiChar.$CharSubtrai[$dc];
													
					$NumSd++;
					if($NumSd >= $TamSn){ $NumSd=0; }
				
					
				}

				return $JuntaSubtraiChar;

		}


		function FlagCripto($Dados){
			// Verifica se registro possui Flag Cripto, retira Flag	
				$Res[]='';
				// Testa se Registro esta criptografado	
				$pos = strpos($Dados, defFlagCripto);	// Procura pela ocorrencia de FlagCripto
				if ($pos === false) {
					$Res[0]='Open';
					$Res[1] = $Dados; // returns dados, não possui Flag
					//echo "Flag-Cripto = Não";
				}else{
					$Res[0] = defFlagCripto;
					$Res[1] = substr($Dados, 0, $pos); // returns dados sem Flag
					//echo "Flag-Cripto = Sim";
				} 
			
				return $Res;
		}

		function LocHash($RepositorioHashX, $SnInfo){
		// Verifica se senha-digitada esta dentro do repositorio hash	
			$Res='';
			$SnInfoMd5 = md5($SnInfo);
			// Testa se Registro esta criptografado	
			$pos = strpos($RepositorioHashX, $SnInfoMd5);	// Procura se senha-digitada esta dentro do repositorio hash
			$TamHashMd5 = strlen($SnInfoMd5);	

			$Res = substr($RepositorioHashX, $pos,  $TamHashMd5);

			if ($posIni === false) {
				//echo 'Ini: '.$posIni.', Fim: '.$TamHash.'->'.$Res;
				//echo "Flag-Cripto = Não";
			}else{
				echo 'Ini: '.$pos.'->'.$Res;
				//echo "Flag-Cripto = Sim";
			} 

			return $Res;
		}

		function Autenticar()
		{
			$Login="";	// Inicializa
		//*************************************************************************************************************************************
		// Autenticando usu�rio
			if(isset($_COOKIE['LoginCookie'])){
				$LogCookie=$_COOKIE['LoginCookie'];
				$AccCookie=$_COOKIE['AcessoCookie'];
			}else{
				$LogCookie="";
				$AccCookie="";
			}
			
		//Se usu�rio n�o esta autenticado....Verifica login e senha no BD	
		if($AccCookie<>'Autenticado'){
			$usuario='Block';			// Seta usu�rio como: Bloqueado
			
			if(isset($_POST['EdLogin'])){
				$Login=$_POST['EdLogin'];	// Pega Login/Senha digitado em login.php
				$Senha=$_POST['EdSenha'];
			}else{
				$Login="";
				$Senha="";	
			}
			// Consulta BD
			$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
			if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection

			$sql    = "SELECT * FROM usuario WHERE login='$Login' and senha='$Senha'";
			$result = mysqli_query($cnxMysql, $sql);		
			while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr	
				$usuario=$row['login'];	 
			}
			$cnxMysql->close();		// Fecha conexao($cnxMySql);

		}else{
			if($AccCookie=='Autenticado'){
				$usuario=$LogCookie;
			}
		}
		//************************************************************************************
		if($usuario=='Block')
		{ 
			// Login/Senha incorretos - Redirenciona p�gina 	
			//echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=login.php?login+fail&*reg=1001'>";
			
		}else{  
			
			setcookie ("LoginCookie", $usuario,time()+21600);
			setcookie ("AcessoCookie", 'Autenticado',time()+21600);
			
		}
			return ($usuario);
			
		//Fim de verificacao de acesso.
		//*************************************************************************************************************************************

		}
					


		function itemURL()
		{
			// Numera tipo de info a retornar
			$reg=0;
			$eqpto=1;
			
			$endereco = $_SERVER ['REQUEST_URI'];		// Pega URL AttribAtual
			
			
			//*************************************************************************************
			// Separa descritivo da URL
			
			$posPhp = strpos($endereco, 'php?');	// Localiza Php?
			$posPhp_b = $posPhp + 4;
			$pos = strpos($endereco, '%20');		// Equivale a espa�o
			$posEsp_b = $pos + 3;
			$pegar = $pos - $posPhp_b;
			
			if ($pos == true) {		// Se contem '%20'
				
				$item1 = substr($endereco,$posPhp_b,$pegar);
				$item2 = substr($endereco,$posEsp_b,30);
			
				$itemX[$eqpto] = $item1.' '.$item2;
			
			}else{
				
				$posAcento = strpos($endereco, '%');		// Equivale a acentos, etc
				if ($posAcento == true) {		// Se contem '%'
					
					$pegarA = $posAcento - $posPhp_b;			
					$itemX[$eqpto] = substr($endereco,$posPhp_b,$pegarA);	

				}else{	
					$posReg = strpos($endereco, '&*');		// Equivale a acentos, etc
					$posReg_b = $posReg + 2;
					$pegarB = $posReg - $posPhp_b;
					$itemX[$eqpto] = substr($endereco,$posPhp_b,$pegarB);
					
				}

			}
			//*************************************************************************************
			
			//*************************************************
			// Separa registro da URL
			$posReg = strpos($endereco, 'reg=');	
			$posReg_b = $posReg + 4;
			$itemX[$reg] = substr($endereco,$posReg_b,10);
			//*************************************************
			
			return $itemX;
		}	

		function browser()
		{   
			$browser_cliente = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';  
			if(strpos($browser_cliente, 'Opera') !== false)  
			{  
				return('Opera');
			//echo 'codigo para o Opera';  
			}  
			elseif(strpos($browser_cliente, 'Gecko') !== false)  
			{  
				return('Firefox');
				//echo 'codigo para o Mozilla/Firefox e browsers baseados no motor Gecko';  
			}  
			elseif(strpos($browser_cliente, 'MSIE') !== false)  
			{  
			return('IE');
			//echo 'codigo para o IE';  
			}  
			else  
			{ 
				return('Outro');
				//echo 'codigo para outro browser';  
			}  
		}

		function espaco($Num)
		{ 
			
			//$this->RegistrarLog('class.funcao.espaco('.$Num.')');

			for($Es=0;$Es<$Num;$Es++){ 	echo"&nbsp";	}
		}

		function Tracejar($Num)
		{ 
			for($Es=0;$Es<$Num;$Es++){ 	echo"-";	}
		}

		function AttribPularLinha($Num)
		{ 
			for($Es=0;$Es<$Num;$Es++){ 	echo"<br>";	}
		}

}	/* End Class */
?>