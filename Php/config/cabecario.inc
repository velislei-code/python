
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml2/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">


<head>

<meta http-equiv="Content-Language" content="pt-br">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">	<!-- charset=UTF-8" /> -->
<meta name="GENERATOR" content="Notepad++">
<meta name="ProgId" content="NotePad++">
<meta name="author" content="Velislei A Treuk" />
<link href="style.css" rel="stylesheet" type="text/css">


<?Php
	// Pega IP da maquina
	$url = '';
	$get_ip = gethostbyname($url);
	
	
	/********** DNS ***************************************************************************/
	$MyDns = "";
	$Localizar = "DNS.";
	exec ("ipconfig.exe /all", $output_array, $return_val);
	//echo "Retornou: $return_val <br> <pre>";
	foreach ($output_array as $InfoCmd)
	{
		$pos = strpos($InfoCmd, $Localizar);
		if($pos === false){ /* Imprime todo lista de ipconfig /all: echo "$X <br>"; */	}
		else{ $MyDns = $InfoCmd; /* echo "$InfoCmd <br>"; */ }	// Imprime somente linha DNS.
	}
	//echo "</pre>";
	
	                                        //Pegou: DNS......................: 8.8.8.8 */
	$posFiltra = strpos($MyDns, ":");		// Pega Posi��o de ":"
	$Dns = substr($MyDns, $posFiltra, 16);	// Filtra somente 8.8.8.8
	
	
	/********** DNS ***************************************************************************/

	
?>
<!-- <title><?Php echo "rdPedia[IP: ".$get_ip."/Dns".$Dns."]"; ?></title> -->
<title>
	<?Php 
		if(!empty($_POST['edID'])){	
			echo $_POST['edID']; 
		}else{ 
			if(!empty($_POST['CxTicket'])){	
				echo $_POST['CxTicket']; 
			}else{ 
				echo $get_ip."/Dns".$Dns; 
			}
		}
	?>
</title>
<link rel="icon" href="imagens/icon/farol.ico" />
<link href="resources/css/custon.css" rel="stylesheet">
<link href="resources/css/alert.css" rel="stylesheet">


	<?Php

	include_once("config/config.php");
	include_once("Class.funcao.php");	//include_once: carregue o arquivo se ele j� N�O tenha sido inclu�do
	include_once("Class.mysql.php");	//include_once: carregue o arquivo se ele j� N�O tenha sido inclu�do
	$ObjMySql = New MySql();
	$ObjFuncao = New Funcao();
	
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('cabecario.inc;');

	
	include_once 'config/favoritos.inc';  
	include_once 'config/menu_sistema.inc'; 
	include_once 'config/funcaoErro.inc';
	include_once 'config/fonte.inc';
	include_once 'config/attrib.inc';   
	include_once 'config/theme.inc';	
	include_once 'config/tabelas.inc';	
	

	
	// Default
	include_once 'config/menu/menu15.inc';   $AjusteTamMenu = 0;	
	
	// carrega tipo de Menu / TipoMenu: ajusta tamanho de menu
	if(isset($_COOKIE['TemaMenuCookie'])){
		if($_COOKIE['TemaMenuCookie'] == 'Padrao'){ include_once 'config/menu/menu5.inc';   $AjusteTamMenu = 30; }
		if($_COOKIE['TemaMenuCookie'] == 'Simples(tab)'){ include_once 'config/menu/menu0.inc';   $AjusteTamMenu = 30; }
		if($_COOKIE['TemaMenuCookie'] == 'Simples(img)'){ include_once 'config/menu/menu7.inc';   $AjusteTamMenu = 30; }	
		if($_COOKIE['TemaMenuCookie'] == 'Barra(grafite)'){ include_once 'config/menu/menuButton.inc';   $AjusteTamMenu = 30; }
		if($_COOKIE['TemaMenuCookie'] == 'Barra(verde)'){ include_once 'config/menu/menu3.inc';   $AjusteTamMenu = 30; }
		if($_COOKIE['TemaMenuCookie'] == 'Botao(branco)'){ include_once 'config/menu/menu6.inc';   $AjusteTamMenu = 30; }	
		if($_COOKIE['TemaMenuCookie'] == 'Botao(Grafite)'){include_once 'config/menu/menu11.inc';   $AjusteTamMenu = 30; }
		if($_COOKIE['TemaMenuCookie'] == 'Estilo(verde)'){ include_once 'config/menu/menu10.inc';   $AjusteTamMenu = 30; }
		if($_COOKIE['TemaMenuCookie'] == 'Estilo(Win)'){ include_once 'config/menu/menu15.inc';   $AjusteTamMenu = 0; }
	}else{ 
		include_once 'menu/menu15.inc';   
		$AjusteTamMenu = 20; 
	}
	?>


<?Php
	
	
	$ObjFuncao->AttribPularLinha($AttribPularLinha);	// Pula linhas
	
	$AttribLinkAbaIntM[0] = $LinkAbaIntA[1];	// Igual ao anterior, isto faz retornar	
	$AbaAtivaA = $AbaIntA[2];			// Informa qual Aba deve ser selecionada
	$AbaAtivaB = $AttribAbaIntB[0];			// Informa qual Aba deve ser selecionada
	// setcookie ("CookieAbaAtivaA", $AbaIntA[2]); 
	$AttribLinkAbaIntM[1] = $LinkAbaIntA[3];	// Igual ao pr�ximo, isto faz avan�ar
	
	// Padr�o Menu ABA
	if($BotaoVoltar >= 0){ $MostrarVoltar = true; }else{ $MostrarVoltar = false; } 				// Mostrar bot�o Voltar
	if($BotaoAvanco >= 0){ $MostrarAvanco = true; }else{ $MostrarAvanco = false; }				// Mostrar bot�o avan�ar 

	
	// Valores p/ medi��o tamanho do menu automatico	
	$Mn[0] = $AttribAbaIntM[0];
	$Mn[1] = $AttribAbaIntM[1];
	$Mn[2] = $AbaIntA[1];
	$Mn[3] = $AbaIntA[2];
	$Mn[4] = $AbaIntA[3];
	$Mn[5] = $AttribAbaIntB[1];
	$Mn[6] = $AttribAbaIntB[2];
	$Mn[7] = $AttribAbaIntB[3];
	$Mn[8] = $AttribAbaIntB[4];	
	
	$TamMenu = $ObjFuncao->MedirMenu($Mn);
	
	if(($MostrarVoltar)and($MostrarAvanco)){ $Total = 55 + $AjusteTamMenu;	 }	// Indica que os 2 menus < e > estao ativos
	else{ $Total = 65 + $AjusteTamMenu;  }					// Somente 1 esta ativo
	
	$NumEspPesquisa = $Total - $TamMenu;
	
	// echo"$NumEspPesquisa = $$ObjFuncao->espacoTotal - $TamMenu 	 <br>";

	// echo 'Topico: '.$_COOKIE['TopicoXCookie'];

?>



</head>


