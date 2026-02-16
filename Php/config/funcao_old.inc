<?php  

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
	// Imprime a forma binária da mascara
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
	
	// Mostra evolução
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
	//if($EnableLog){
		
		$hora = date(" - H:i:s"); 
		$hoje = date("dM"); 

		$Origem = substr($Funcao,0,6);
		if($Origem =='OnLoad'){ $Funcao = "\n".$Funcao.$hora; }	// Pular uma linha, adiciona hora
	
		$file = fopen('log/LogFuncao'.$hoje.'.txt', 'a');
		fwrite($file, $Funcao."\n");
		fclose($file);
	//}
}

function MedirMenu($M)
{
	// Retorna a soma dos char do menu(ajusta Tam espaço)
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

	$Resulta[0] = $Qtas;	// Armazena o número total de palavras encontradas
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
	$TamTexto = strlen($ThemeTexto);
	
	for($X=0; $X < $TamTexto; $X++){
		$Letra = $ThemeTexto[$X];	
		$ASC = StrToASCII($Letra);
		if($ASC=='10'){ $NumLin++; }	// ASCII 10 = Nova Linha
		// echo"$Letra = $ASC <br>";	// Imprime
	}
	
	return ($NumLin);
}

function VerAutenticacao()
{
	// Autenticando usuário
	$LogCookie=$_COOKIE['LoginCookie'];
	$AccCookie=$_COOKIE['AcessoCookie'];

	if($AccCookie=='Autenticado'){
		// $resultado[0] = true;
		// $resultado[1] = $LogCookie;		
		$usuario = $LogCookie;		
	}else{
		// Login/Senha incorretos - Redirenciona página(Retorna p/ login.php) 	
		//echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=login.php?login+fail&*reg=1001'>";
		// $resultado[0] = false;
	}   //Fim de verificacao de acesso.
	
	// return($resultado);
	return $usuario;
}

function Autenticar()
{
//*************************************************************************************************************************************
// Autenticando usuário
	$LogCookie=$_COOKIE['LoginCookie'];
	$AccCookie=$_COOKIE['AcessoCookie'];
	
//Se usuário não esta autenticado....Verifica login e senha no BD	
if($AccCookie<>'Autenticado'){
	$usuario='Block';			// Seta usuário como: Bloqueado
	$Login=$_POST['EdLogin'];	// Pega Login/Senha digitado em login.php
	$Senha=$_POST['EdSenha'];
	
	// Consulta BD
	$link = mysql_connect('localhost', 'root', '');
	mysql_select_db('Rede', $link);
	$sql    = "SELECT * FROM usuario WHERE login='$Login' and senha='$Senha'";
	$result = mysql_query($sql, $link);
	while ($row = mysql_fetch_assoc($result)) { $usuario=$row['login'];	 }
	mysql_free_result($result);

}else{
	if($AccCookie=='Autenticado'){
		$usuario=$LogCookie;
	}
}
//************************************************************************************
if($usuario=='Block')
{ 
	// Login/Senha incorretos - Redirenciona página 	
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
	$pos$ObjFuncao->espaco = strpos($endereco, '%20');		// Equivale a espaço
	$posEsp_b = $pos$ObjFuncao->espaco + 3;
	$pegar = $pos$ObjFuncao->espaco - $posPhp_b;
	
	if ($pos$ObjFuncao->espaco == true) {		// Se contem '%20'
		
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

function $ObjFuncao->espaco($Num)
{ 
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


?>