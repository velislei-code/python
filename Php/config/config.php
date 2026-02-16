<?Php

//https://www.tiktok.com/@bubows/video/7337425593945902341?is_from_webapp=1&sender_device=pc

/*
// Inibe a exibi��o de erros nas p�ginas
error_reporting(0);
ini_set('display_errors', 0 );
ini_set('log_errors', 0);
*/

ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);

	$versao = "Vers�o 14.03.17";

	date_default_timezone_set("Brazil/East");	// Ajustar hora

			
	// Inibe limite de tempos de conexao MySql
	set_time_limit(0);   
	ini_set('mysql.connect_timeout','0');   
	ini_set('max_execution_time', '0');   


/*
	Para login do cliente, visite: http://cpanel.hostinger.com.br
	Login: Conta Gmail	
	Email: velislei@gmail.com
	Senha: Logar com Gmail
	www.livrosrca.esy.es
	
	livrosrca.esy.es 
	IP ADDRESS:	31.170.166.202
	USERNAME:	u323847820
	PASSWORD:	���������� 
	INODES:		0/20000
	DISK USAGE:	0.02 / 2000 MB
	BANDWIDTH:	0.00 / 100000 MB
	
	
	Create a New MySQL Database And Database User
	MySQL database name:	u323847820_livro   
	MySQL username:			u323847820_root 
	Password:				root***		(Matr�cula rca)
	
	
	FTP:		Filezilla
	Host: 		ftp.livrosrca.esy.es
	Username:	u323847820
	Password:	V**1**a*
	Port: 		[]

*/

	date_default_timezone_set("Brazil/East");	// Ajustar hora

	// Conex�o		Remota//Local
	$host = "localhost";
	$UserBco = "root"; 		//"u323847820_root";
	$PassBco = "";			//"root357";			
	$banco = "Rede";	//"u323847820_livro"; 		
	define('defFlagCripto','[Cripto]');				// Falg p/ indicar que registro esta criptografado

		// Conexao		Remota//Local
		define('defHost','localhost');
		define('defUserBD','root');
		define('defPassBD','');
		define('defBD','Rede');
		define('defPortBD','3306');
		define('open','0');
		define('close','1');


		// Mesnagens
		define('defConfirma','1');	// tipo
		define('defAviso','2');
		
		define('defInfo','1');		// Cores 
		define('defSucesso','2');
		define('defAtencao','3');
		define('defPerigo','4');

	/*
	 * @ ignora erro do Php e imprime mensagem em die("...");	 
	 *

	if(@!mysql_connect($host, $UserBco, $PassBco)){
		die("Erro! N�o foi poss�vel se conectar ao MySQL(User/Password fail).");
	}
	if(@!mysql_select_db($banco)){
		die("Erro base de dados");
	}

	// Tamanho: Fontes, Div�s, etc
	// $Zoom = 0.7;	// em (%) 70%
	
	
	// class
	// TEMPO PARA REFRESH DO IFRAME - Chat
	// $Tempo = 30;				// Tempo em segundos
	// $Refresh = $Tempo * 1000;   // Milisegundos
	
	
	//setcookie('biblioteca', 'Centro de Conf.Aurora');
	//setcookie('biblioteca', 'T.Aurora');	
	//setcookie('login', 'v2@bol.com');
	
	/*
	 *	http://php.net/manual/pt_BR/language.constants.predefined.php
	 * 
	 * echo '<pre> ';
	 * print_r($_SERVER);						Imprime uma lista de configura��es
	 * print_r($_SERVER['DOCUMENT_ROOT'] );		Imprime C:/wamp/www
	 * echo '</pre>';
	 */	
	 
	// Diret�rios	
	$De = '/';	$Para = '\\';
	$Root  = str_replace($De, $Para, $_SERVER['DOCUMENT_ROOT']);   //Substitui barras

	define('defDirLinux', 'D:\\Linux\\');				// C:/Linux
	define('defDirRoot', $Root.'\\');				// C:/wamp/www
	define('defDirApp',getcwd().'\\');				// C:\wamp\www\rca2\
	define('defDirBak', defDirApp.'Backup\\');		// C:\wamp\www\rca2\Backup\
	
	$Tam = strlen(defDirRoot) - 4;	
	$Wamp =  substr(defDirRoot, 0, $Tam);	
	define('defDirWamp', $Wamp);					// C:/wamp/
	
	
	$Dta = $Wamp."bin\\mysql\\mysql5.6.12\\data\\";
	define('defDirData', $Dta);						// C:/wamp/bin/mysql/mysql5.6.12/data/
	
	
	$Bco = $Wamp."bin\\mysql\\mysql5.6.12\\data\\Rede\\";
	define('defDirBanco', $Bco);					// C:/wamp/bin/mysql/mysql5.6.12/data/Biblioteca/
	
	
	// On/Off
	define('defOFF', 0);
	define('defON', 1);
	
	
	// Defini��es 
	define('defNumPag',10);		// Numero de p�ginas extras no caderno de registro
	define('defNumLin',30);		// Numero de linhas por p�ginas no caderno de registro
	define('defNumLin_x2',10);	// Numero de linhas por p�ginas no caderno de registro (2 regs por p�gina)
	
	define('defREG',0);			// Ordem de listagem Registro
	define('defTITULO',1);		// Ordem de listagem t�tulo	
	define('defAUDITAR',2);		// Ordem de listagem t�tulo
	define('defUNICO',3);		// Um �nico registro
	
	define('defSUBSTITUIR',0);	// SUBSTITUIR DADOS
	define('defCOPIAR',1);		// COPIAR DADOS
	define('defADD',2);	// ADD DADOS
	
	define('defVersaoX',"Vers�o 3.0");
	define('defMsgNaoAutoriza', "Erro!  Voc� n�o tem autoriza��o para executar esta a��o.");
	define('defMsgRegProtegido', "Erro!  Este registro � somente para leitura.");				
		
	define('defTamanhoHash',10);			// Tamanho da Hash das senhas como 10 caracteres
	define('defSenhaReset', "SenhaRst");	// Acesso Senha-resetada
	define('defAccLiberado', "Liberado");	// Acesso Liberado
	define('defAccBloqueado', "Bloqueado");	// Acesso Bloqueado
	
	
	// Cores
	define('defCorBarraCima', 0);
	define('defCorFundoMenu', 1);
	define('defCorSelecao', 2);		
	define('defCorLetra', 3);
	define('defCorLetraMenu', 4);
	
	

	/*
	define('defCod',0);
	define('defCon',1);
	define('defUsu',2);
	define('defDes',3);
	define('defHor',4);
	define('defTot',10);	
	define('defFotoPadrao', 'photo/padrao.png');
	*/
	
	/*
	 *	Defini��es de fonte dos indices	
	 */
	 /*
	// Fte Pequena
	define('defFteTitulo',4);
	define('defFteExplica',2);
	define('defFteIndice',2);
	*/
		
	// Fte M�dia
	define('defFteTitulo',6);
	define('defFteExplica',3);
	define('defFteIndice',4);
	
		
	/*	
	// Fte Grande
	define('defFteTitulo',8);
	define('defFteExplica',5);
	define('defFteIndice',6);
	*/
	
	define('defExListaIndice',"Ex: 1;10;100;200;300");
	
	
	
	class Config {

		
	

		function __construct(){}
			function BoasVindas(){
	
				$this->RegistrarLog('config.Class.config.__construct().BoasVindas(); // Construtor Class config->Boas vindas ');
	
			echo "Ol� <b>$_COOKIE[cookie_usuario]</b> Seu ultimo acesso foi em: $_COOKIE[dt_ult_acesso]<br></b>";	
		}


		function CarregueLingua($lingua){

			$this->RegistrarLog('funcao.php.CarregueLingua('.$lingua.')');
		
			if (empty($lingua)) 	{	include 'lang/phpchat_lang_en.inc'; 	}  	// Se Cookie n�o existe, carregue padr�o 
			elseif ($lingua=="EN") 	{	include 'lang/phpchat_lang_en.inc'; 	}	// Ingl�s	
			elseif ($lingua=="PT") 	{	include 'lang/phpchat_lang_pt.inc'; 	}	// Portugu�s
			elseif ($lingua=="ES") 	{	include 'lang/phpchat_lang_es.inc'; 	}	// Espanhol
	
		}
	function RegistrarLog($Funcao)
	{
		$hora = date(" - H:i:s"); 
		$hoje = date("dM"); 

		$Origem = substr($Funcao,0,6);
		if($Origem =='OnLoad'){ $Funcao = "\n".$Funcao.$hora; }	// Pular uma linha, adiciona hora
		else{$Funcao = "   ".$Funcao.$hora; }					// Adiciona Tabula��o
		$file = fopen('temp/LogFuncao'.$hoje.'.txt', 'a');
		fwrite($file, $Funcao."\n");
		fclose($file);
	}		

	// M�scaras de entrada	
	function MaskUser(){ 	return("AAAA999"); 			}
	function MaskDdi(){ 	return("999");				}
	function MaskCell(){ 	return("(99)99999-9999");	}
	function MaskCep(){ 	return("99.999-999");		}
	function MaskToken(){ 	return("999.999");			}
	function MaskEtqta(){ 	return("A 999");			}
		
	function Tema($Tm){ 
		$Res[] = "";
	
	
		if($Tm == "Dourado"){
			$Res[defCorBarraCima] = "#CD950C";
			$Res[defCorFundoMenu] = "#FFFFFF"; 
			$Res[defCorSelecao] = "#FFD700";				
			$Res[defCorLetra] = "#8B6914";	
			$Res[defCorLetraMenu] = "#FFFFFF";			
		
		}else if($Tm == "Amarelo"){
			$Res[defCorBarraCima] = "#FFD700";
			$Res[defCorFundoMenu] = "#FFFFFF"; 
			$Res[defCorSelecao] = "#FFFF00";				
			$Res[defCorLetra] = "#8B6914";
			$Res[defCorLetraMenu] = "#000000";
			
			
		}else if($Tm == "Cinza"){
			$Res[defCorBarraCima] = "#CFCFCF";
			$Res[defCorFundoMenu] = "#FFFFFF"; 
			$Res[defCorSelecao] = "#9C9C9C";				
			$Res[defCorLetra] = "#363636";
			$Res[defCorLetraMenu] = "#000000";
			
			
		}else if($Tm == "Azul ciano"){			
			$Res[defCorBarraCima] = "#AFB2FF";
			$Res[defCorFundoMenu] = "#FFFFFF"; 
			$Res[defCorSelecao] = "#B0C4DE";				
			$Res[defCorLetra] = "#191970";	
			$Res[defCorLetraMenu] = "#000000";			
		
		}else if($Tm == "Azul marinho"){			
			$Res[defCorBarraCima] = "#6A5ACD";
			$Res[defCorFundoMenu] = "#BFCDDB"; 
			$Res[defCorSelecao] = "#4682B4";				
			$Res[defCorLetra] = "#191970";
			$Res[defCorLetraMenu] = "#ffffff";
			
		}else if($Tm == "Azul light"){			
			$Res[defCorBarraCima] = "#6E7B8B";
			$Res[defCorFundoMenu] = "#BFCDDB"; 
			$Res[defCorSelecao] = "#6E7B8B";				
			$Res[defCorLetra] = "#191970";
			$Res[defCorLetraMenu] = "#FFFFFF";
			
		}else if($Tm == "Vermelho"){
			$Res[defCorBarraCima] = "#FF0000";
			$Res[defCorFundoMenu] = "#FFFFFF"; 
			$Res[defCorSelecao] = "#EE0000";				
			$Res[defCorLetra] = "#8B0000";
			$Res[defCorLetraMenu] = "#000000";
			
		}else if($Tm == "Bord�"){
			$Res[defCorBarraCima] = "#CD2626";
			$Res[defCorFundoMenu] = "#FFFFFF"; 
			$Res[defCorSelecao] = "#CD0000";				
			$Res[defCorLetra] = "#8B0000";
			$Res[defCorLetraMenu] = "#FFFFFF";
			
		}else if($Tm == "Chocolate"){
			$Res[defCorBarraCima] = "#CD6600";
			$Res[defCorFundoMenu] = "#FFFFFF"; 
			$Res[defCorSelecao] = "#D2691E";				
			$Res[defCorLetra] = "#8B0000";
			$Res[defCorLetraMenu] = "#FFFFFF";
			
		}else if($Tm == "Verde"){
			$Res[defCorBarraCima] = "#008B45";
			$Res[defCorFundoMenu] = "#FFFFFF"; 
			$Res[defCorSelecao] = "#00CD66";				
			$Res[defCorLetra] = "#006400";
			$Res[defCorLetraMenu] = "#FFFFFF";
			
		}else if($Tm == "Oliva"){
			$Res[defCorBarraCima] = "#698B22";
			$Res[defCorFundoMenu] = "#FFFFFF"; 
			$Res[defCorSelecao] = "#A2CD5A";				
			$Res[defCorLetra] = "#006400";
			$Res[defCorLetraMenu] = "#FFFFFF";
			
		}else if($Tm == "Roxo"){
			$Res[defCorBarraCima] = "#8B6969";
			$Res[defCorFundoMenu] = "#FFFFFF"; 
			$Res[defCorSelecao] = "#CD9B9B";				
			$Res[defCorLetra] = "#8B0000";
			$Res[defCorLetraMenu] = "#FFFFFF";
			
		}else if($Tm == "Lim�o"){
			$Res[defCorBarraCima] = "#CDCD00";
			$Res[defCorFundoMenu] = "#FFFFFF"; 
			$Res[defCorSelecao] = "#8B8B00";				
			$Res[defCorLetra] = "#8B8B00";	
			$Res[defCorLetraMenu] = "#000000";			
			
		}else if($Tm == "Madeira"){
			$Res[defCorBarraCima] = "#8B6914";
			$Res[defCorFundoMenu] = "#FFFFFF"; 
			$Res[defCorSelecao] = "#CDBE70";				
			$Res[defCorLetra] = "#8B5A00";
			$Res[defCorLetraMenu] = "#FFFFFF";
			
		}else if($Tm == "Madeira light"){
			$Res[defCorBarraCima] = "#8B814C";
			$Res[defCorFundoMenu] = "#FFFFFF"; 
			$Res[defCorSelecao] = "#CDBE70";				
			$Res[defCorLetra] = "#8B5A00";
			$Res[defCorLetraMenu] = "#FFFFFF";
			
		}else{
			// Padr�o(Dourado)	
			$Res[defCorBarraCima] = "#CD950C";
			$Res[defCorFundoMenu] = "#FFFFFF"; 
			$Res[defCorSelecao] = "#FFD700";				
			$Res[defCorLetra] = "#8B6914";
			$Res[defCorLetraMenu] = "#FFFFFF";			
		}				
		
		return($Res);
		
		
	}
			
	
}



?>