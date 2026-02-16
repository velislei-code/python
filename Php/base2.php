
<?Php
	
	$AttribPosAbaA = $_COOKIE['CookieAttribPosAbaA']; // Posição das abas "A"
	// Inicializa var
	$BotaoVoltar = 0;			
	$BotaoAvanco = 0;					

	include 'config/cabecario.inc';
	
//*****************************************
// Verificar Autenticação
	$usuario = $ObjFuncao->VerAutenticacao();	
//*****************************************
	$AbaAtivaB = $AttribAbaIntB[2];	// Informa qual Aba deve ser selecionada
	
	
	//*********************************************************************************************
				//Consulta LISTA DE TÓPICOS
				
				if( isset($_REQUEST['topico']) ){
					$RegURL = $_REQUEST['reg'];	// -1(ajuste)
					$TopicoURL = $_REQUEST['topico'];
				}
				
				// Memoriza topico p/ retornos
				if(!empty($TopicoURL)){ 
					setcookie ("TopicoXCookie", $TopicoURL,time()+21600);
				}else{
					if(isset($_COOKIE['TopicoXCookie'])){
						$TopicoURL = $_COOKIE['TopicoXCookie'];
					}else{
						$TopicoURL = "";
					}
				}
			
?>
<script language="javascript">
<!--
function PopWindow(URL,windowName,features)
{ 
	window.open(URL,windowName,features);
}
//-->
</SCRIPT>

<body BGCOLOR="<?Php echo"$ThemeCorFundoBody"; ?>" ><!-- BACKGROUND="PParede/cristal.png" --> 	
<div id="geral"><!-- Pagina Geral -->	


	<table class="TAB_Geral" width="100%" align="center" valign="top">
	<form name="Localizar" method="post" action="localizar.php?<?Php echo "topico=".$TopicoURL;?>"><!-- Form Localizar, inserido aqui devido espaços que cria no IE -->
	<tr align="center"  height="50" valign="top">
	
	<!-------------------------------- Inicio Geral Esquerdo -------------------------------------------------------------------->
	
	<td width="15%" colspan="1"  align="center"  height="5" valign="top">
	<br>
	<div id="geral_esquerdo"><!-- Geral Esquerdo -->
		
		<table class="TAB_GeralEsq" width="100%" align="center" valign="top">
		<!------------------------------------- Inicio LOGO --------------------------------------------------------------->
		<tr align="center"  height="5" valign="top">
			<td width="100%" colspan="1"  align="center"  height="5" valign="top">
				<span class = "circle-image">
					<img src = "imagens/<?Php echo "$ThemeGlobo"; ?>" />
				</span>		
			</td>  
		</tr>
		<!------------------------------------- Final LOGO --------------------------------------------------------------->
		
		<!------------------------------------- Inicio Menu esquerdo --------------------------------------------------------------->
		
		   <tr align="center"  height="5" valign="top">
			<td width="100%" colspan="1"  align="center"  height="5" valign="top">
			
			
			<table class="TAB_MenuEsq" width="100%" align="center" valign="top">
			<tr align="center"  height="5" valign="top">
			
			<td width="20" colspan="1"  align="left"  height="5" valign="top">		
			<!---------------------------------------------------------------------------------------------------->
				<!------------------------ Linha - Ini ---------------------------------------------------->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php $ObjFuncao->espaco(2); ?>
						<img border="0" src="imagens/<?Php echo"$ThemeCorLinhaMenu"; ?>" width="155" height="15">
					</td>
				</tr>
				<!------------------------ Linha - Fim ---------------------------------------------------->
				
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
					<?Php $ObjFuncao->espaco(5); ?>
					<a href="<?Php echo"$AttribMenuEsqIntLink00";?>" class="fonte_menu_esq">
						<?Php echo"$AttribMenuEsqInt00";?>
					</a>					
					</td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
					<?Php $ObjFuncao->espaco(5); ?>
					<a href="<?Php echo"$AttribMenuEsqIntLink01";?>" class="fonte_menu_esq">
						<?Php echo"$AttribMenuEsqInt01";?>
					</a></td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
						<a href="<?Php echo"$AttribMenuEsqIntLink02";?>" class="fonte_menu_esq">
							<?Php echo"$AttribMenuEsqInt02";?>
						</a></td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
					<?Php $ObjFuncao->espaco(5); ?>
					<a href="<?Php echo"$AttribMenuEsqIntLink03";?>" class="fonte_menu_esq">
						<?Php echo"$AttribMenuEsqInt03";?>
					</a></td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
						<a href="<?Php echo"$AttribMenuEsqIntLink04";?>" class="fonte_menu_esq">
							<?Php echo"$AttribMenuEsqInt04";?>
						</a></td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
							<?Php $ObjFuncao->espaco(5); ?>
						<a href="<?Php echo"$AttribMenuEsqIntLink05";?>" class="fonte_menu_esq">
							<?Php echo"$AttribMenuEsqInt05";?>
						</a></td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
					</td>
				</tr>
				<!------------------------ Linha - Ini ---------------------------------------------------->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php $ObjFuncao->espaco(2); ?>
						<img border="0" src="imagens/<?Php echo"$ThemeCorLinhaMenu"; ?>" width="155" height="15">
					</td>
				</tr>
				<!------------------------ Linha - Fim ---------------------------------------------------->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php $ObjFuncao->espaco(3); ?>
						<a href="<?Php echo"$AttribMenuLinguaLink00";?>" class="fonte_item_menu">
						<img border="0" src="imagens/<?PHp echo"$ThemeMenuLinguaSel00"; ?>" width="15" height="15">
							<?Php echo"$AttribMenuLingua00";?>
						</a>
					</td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
						<a href="<?Php echo"$AttribMenuLinguaLink01";?>" class="fonte_menu_esq">
						<img border="0" src="imagens/<?PHp echo"$ThemeMenuLinguaSel02"; ?>" width="10" height="10">
							<?Php echo"$AttribMenuLingua01";?>
						</a>
					</td>
				</tr>
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
						<a href="<?Php echo"$AttribMenuLinguaLink02";?>" class="fonte_menu_esq">
						<img border="0" src="imagens/<?PHp echo"$ThemeMenuLinguaSel02"; ?>" width="10" height="10">
							<?Php echo"$AttribMenuLingua02";?>
						</a>
					</td>
				</tr>
				
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
						<a href="<?Php echo"$AttribMenuLinguaLink03";?>" class="fonte_menu_esq">
						<img border="0" src="imagens/<?PHp echo"$ThemeMenuLinguaSel03"; ?>" width="10" height="10">
							<?Php echo"$AttribMenuLingua03";?>
						</a>
					</td>
				</tr>
				<!------------------------ Linha - Ini ---------------------------------------------------->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php $ObjFuncao->espaco(2); ?>
						<img border="0" src="imagens/<?Php echo"$ThemeCorLinhaMenu"; ?>" width="155" height="15">
					</td>
				</tr>
				<!------------------------ Linha - Fim ---------------------------------------------------->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top">
						<?Php $ObjFuncao->espaco(5); ?>
						<a href="<?Php echo"$AttribMenuSobreLink00"; ?>" class="fonte_menu_esq">
							<?Php echo"$AttribMenuSobre00";?><!-- Vlans -->
						</a>, 
						<a href="<?Php echo"$AttribMenuSobreLink01"; ?>" class="fonte_menu_esq">
							<?Php echo"$AttribMenuSobre01";?><!-- IPv6 -->
						</a>
					</td>
				</tr>
				<!------------------------ Linha - Ini ---------------------------------------------------->
				<tr align="center"  height="5" valign="top">
					<td width="100%" colspan="1"  align="left"  height="5" valign="top"><?Php $ObjFuncao->espaco(2); ?>
						<img border="0" src="imagens/<?Php echo"$ThemeCorLinhaMenu"; ?>" width="155" height="15">
					</td>
				</tr>
				<!------------------------ Linha - Fim ---------------------------------------------------->
		
				
			<!---------------------------------------------------------------------------------------------------->
			</td></tr>
			</table>
			
			
			
			</td>  
			</tr>
		<!------------------------------------- Final Menu esquerdo --------------------------------------------------------------->
		
		</table>

	
	</div><!-- Geral Esquerdo -->
	</td>
	<!-------------------------------- Final Geral Esquerdo -------------------------------------------------------------------->
	
	
	<!-------------------------------- Inicio Geral Direito -------------------------------------------------------------------->
	
	<td width="95%" colspan="1"  align="center"  height="5" valign="top">
	<br>
	<div id="geral_direito"><!-- Geral Direito -->		
		
		<table class="TAB_GeralDireito" width="100%" align="center" valign="top"> <!-- cellspacing="0" cellpadding="0" height="5"  BGCOLOR="<?Php echo"$ThemeCorFundoBody"; ?>> -->
		<!------------------------------------------------------------------------------------------------------------->
		<!-- INI Linha Menus *favoritos -->	
		<div id="pop_favorito" class="favorito_skin" onMouseover="clearhide_favorito();highlight_favorito(event,'on')" onMouseout="highlight_favorito(event,'off');dynamichide_fav(event)">		
			<tr align="center"  height="5" valign="top">
			<td width="100%" colspan="1"  align="right"  height="5" valign="top">
				<!-- Menu Favoritos -->
				<a onMouseover="show_favorito(event,linkset_fav[0])" onMouseout="delayhide_favorito()" class="fonte_AttribTopo">
					<img border="0" src="imagens/<?Php echo"$ThemeTopoImg00"; ?>" width="12" height="15">					
				</a>
				<a class="fonte_AttribTopo">
					<img border="0" src="imagens/<?Php echo"$ThemeTopoImg01"; ?>" width="12" height="15">			
				</a>
					
				<a href="#" class="fonte_AttribTopo"><?Php echo"$usuario"; ?></a>
				<a href="<?Php echo"$AttribLinkTopo[1]"; ?>" class="fonte_AttribTopo"><?Php echo"$AttribTopo[1]"; ?></a>
				
				<!-- Menu Sistema -->
				<a onMouseover="show_sistema(event,linkset_sys[0])" onMouseout="delayhide_sistema()" class="fonte_AttribTopo">
					<?Php echo"$AttribTopo[2]"; ?>
				</a>
				<a href="<?Php echo"$AttribLinkTopo[3]"; ?>" class="fonte_AttribTopo"><?Php echo"$AttribTopo[3]"; ?></a>	
				</td>
			</tr>	
		</div>	
		<!-- Fim Linha favoritos -->	
		<!-- Referencia menu Sistema -->	
		<div id="pop_sistema" class="sistema_skin" onMouseover="clearhide_sistema();highlight_sistema(event,'on')" onMouseout="highlight_sistema(event,'off');dynamichide_sys(event)"><div>						
		<!------------------------------------------------------------------------------------------------------------->

		<tr align="center"  height="5" valign="top">
			<td width="100%" colspan="1"  align="center"  height="5" valign="top">&nbsp;</td>
		</tr>
		<tr align="center"  height="5" valign="top">
			<td width="100%" colspan="1"  align="center"  height="5" valign="top">&nbsp;</td>
		</tr>
		<tr align="center"  height="5" valign="top">
			<td width="100%" colspan="1"  align="center"  height="5" valign="top">&nbsp;</td>
		</tr>
		<tr align="center"  height="5" valign="top">
			<td width="100%" colspan="1"  align="center"  height="5" valign="top">
			<!-- MENU COM ABAS -------------- <div id="menu" --------------------------->	
				<?Php include 'config/menu_abas.inc'; ?>
			<!-- Menu-Abas -------------------</DIV> ----------------------------------->

			<!------------------------- Inicio Conteúdo central -------------------------------------------------------------------->
			
			<div id="conteudo_Central"><!-- Conteúdo Central(Esq, Pesq, Dir)-->

			<!-- Conteúdo Main - Margem -->
			<table class="TAB_MainConteudoExtMargem" width=100% align="center" valign="top"> <!-- Margem -->	
			<tr>
			
			<!-- Conteúdo Main Esquerdo -->
			<td width="20%" colspan="1"  align="left"  height="20" valign="top">

			<!-- Conteúdo Main Esquerdo -->
			<table class="TAB_MainConteudoExt" width=100% align="center"  valign="top"> <!-- Sem Margem -->				
			<tr><!-- Conteúdo Central(Esq, Pesq, Dir) -->
				<!-- Conteúdo da Pesquisa (Resultdados)-->
				<td width="60%" colspan="1"   height="20" align="left" valign="top">
				<div id="conteudo_pesquisa"><!-- Conteúdo da Pesquisa (Resultdados)-->
				<!------------------------------------ Inicio Conteudo de  ------------------------------------------------------------------>		
                    
                    <table border="0" width="691" cellspacing="0" cellpadding="0" height="87">
<!--  <tr>
    <td width="689" colspan="3" height="1" valign="top">
      <table border="0" cellspacing="0" width="100%" cellpadding="0">
        <tr>
          <td width="32%" bgcolor="#FFFFFF"><img border="0" src="imagens/menu_01.gif" width="400" height="85"></td>
          <td width="36%" bgcolor="#FFFFFF">
            <p align="center"><font color="#2FB11E" size="5">&nbsp;<font face="Times New Roman"><b></b></font></font></td>
          <td width="33%" bgcolor="#FFFFFF"></td>
        </tr>
      </table>
    </td>
  </tr>
-->
  <tr>
    <td width="93" colspan="2" height="18" valign="top" bgcolor="#808080">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td width="594" bgcolor="#Afb2ff" height="4">
      <p align="right"><font color="#FFFFFF"><font size="2" face="Arial"></font></font></p>
    </td></tr>

<form name="Cadastrar módulo" method="post" action="index.php">
  <tr>
    <td width="74" bgcolor="#FFFFFF" height="58">&nbsp;</td>
    <td width="613" colspan="2" align="center" rowspan="4" height="234" valign="top">
      <div align="left">
      <table border="0" width="101%" cellspacing="20" cellpadding="0" height="10">
       <tr>
          <td width="53%" height="1" align="right" valign="top">
            <p align="center"><font face="Arial" color="#FF8000" size="2">
            <b>

<?Php
//************************************************************************************
//CARREGA modulos

		$Px = 0;
   		$link = mysql_connect('localhost', 'root', '');
		mysql_select_db('Spart', $link);
		$sql="select * from modulos where fabricante='$CxFabricante'";    //Filtrar
		$result = mysql_query($sql, $link);
		while ($row = mysql_fetch_assoc($result)) 
		{				
			$RegX[$Px]=$row['registro'];
			$PlacaX[$Px]=$row['placa'];
			$FabricanteX[$Px]=$row['fabricante'];
			//echo"$RegX[$Px], $PlacaX[$Px], $FabricanteX[$Px] <br>";  
			$Px++;
		}
		mysql_free_result($result);
		
		$QtosRegX=count($RegX);



//******************************************************************************************************
// Inserção de registros - técnicos
if($EdBa<>''){// Rotina de entrada
if($EdBa<>''){
if($CxEstacao<>'Selecionar'){
if(($CxFabricante<>'Selecionar')or($EdFabricante<>'')){
if(($CxPlaca<>'Selecionar')or($EdPlaca<>'')){
if($EdCodeDf<>''){
if($EdCodeAt<>''){
if($EdEqpto<>''){
if($EdDescricao<>''){
    
            if($CxPlaca=='Selecionar'){$PlacaY=$EdPlaca;}else{$PlacaY="$CxPlaca";}
            if($CxFabricante=='Selecionar'){$FabricanteY=$EdFabricante;}else{$FabricanteY="$CxFabricante";}
			
				if (!$link = mysql_connect('localhost', 'root', '')) {
						?><font face="Arial" color="#FF0000" size="2"><?Php
						echo("Erro na conexão com o Banco de Dados ".mysql_error()."\n");
						exit;
				}
				if (!mysql_select_db('Spart', $link)) {					
					 ?><font face="Arial" color="#FF0000" size="2"><?Php
                    echo("Ocorreu um erro ao tentar abrir a tabela modulos ".mysql_error()."\n");
					exit;
				}
					$sql="	INSERT INTO modulos(login,area,ba,estacao,placa,fabricante,codeDf,codeAt,eqpto,operacao,descricao,data,obs)
							VALUE('$Login[0]','$Area[0]','$EdBa','$CxEstacao-$EdEstacao','$PlacaY','$FabricanteY','$EdCodeDf','$EdCodeAt','$EdEqpto','$CxOperacao','$EdDescricao','$EdData','$EdObs')";
             
					$result = mysql_query($sql, $link);

				if (!$result) {
					?><font face="Arial" color="#FF0000" size="2"><?Php
                    echo("Ocorreu um erro ao tentar incluir registro ".mysql_error()."\n");
					exit;
					
                }else{
                    ?><font face="Arial" color="#00B100" size="2"><?Php
                    printf("Modulo cadastrado com sucesso! Registro[ %d ]\n", mysql_insert_id() );
                //Limpar campos
                    $EdBa='';
                    $CxEstacao='';
                    $CxPlaca='';
                    $EdPlaca='';
                    $CxFabricante='';
                    $EdDescricao='';
                    $EdData='';
                    $EdCodeDf='';
                    $EdCodeAt='';
                    $EdEqpto='';
                    $EdObs='';

                } 				
				mysql_close($link);
        

        }else{ ?><font face="Arial" color="#FF0000" size="2"><?Php printf("[ERRO!] Você deve informar a descrição do defeito !");}
        }else{ ?><font face="Arial" color="#FF0000" size="2"><?Php printf("[ERRO!] Você deve informar o eqpto aplicado!");}
        }else{ ?><font face="Arial" color="#FF0000" size="2"><?Php printf("[ERRO!] Você deve informar o cód. da placa ativa!");}
        }else{ ?><font face="Arial" color="#FF0000" size="2"><?Php printf("[ERRO!] Você deve informar o código da placa com defeito !");}
        }else{ ?><font face="Arial" color="#FF0000" size="2"><?Php printf("[ERRO!] Você deve informar a placa !");}
        }else{ ?><font face="Arial" color="#FF0000" size="2"><?Php printf("[ERRO!] Você deve informar o fabricante !");}
        }else{ ?><font face="Arial" color="#FF0000" size="2"><?Php printf("[ERRO!] Você deve informar a estação !");}
        }else{ ?><font face="Arial" color="#FF0000" size="2"><?Php printf("[ERRO!] Você deve informar o BA !");}
        }//Fim de verificação de rotina-entrada
//******************************************************************************************************


//************************************************************************************
//CARREGA Part Number
/*
    $res1=mysql_connect("localhost","root");
    $sql="select * from placas where area='$Area[0]' and fabricante='$CxFabricante'";
    $res2=mysql_db_query("Spart","$sql",$res1);
    while($row=mysql_fetch_array($res2)){
        $PnP[]=$row["pn"];
        $DesP[]=$row["descricao"];
        }
    mysql_close($res1);

    $QtasP=count($PnP);

*/
//************************************************************************************

?>

        </b></font>
          </td>
        </tr>


        <tr>
          <td width="53%" height="2" align="right" valign="top">
            <table border="1" cellpadding="0" cellspacing="0" width="100%">
              <tr>
                <td width="100%" bgcolor="#C0C0C0"><font color="#FFFFFF" face="Arial" size="3">&nbsp;<b>Cadastro (Spart-X)</b></font></td>
              </tr>
              <tr>
                <td width="100%">
                  <table border="0" background="imagens/fundo_capsulas.gif" cellpadding="0" cellspacing="0" width="100%" bgcolor="#afb2ff">
                  <tr>
                      <td width="5%">&nbsp;</td>
                      <td width="19%"><font face="Arial" size="2">&nbsp;</font></td>
                      <td width="73%" align="right"><font face="Arial" size="2"><?Php // echo"[$Login[0]-$Area[0]]";?>&nbsp;</td>
                    </tr>
                     <tr>
                      <td width="5%">&nbsp;</td>
                      <td width="19%"><font face="Arial" size="2">BA</font></td>
                      <td width="73%"><input type="text" name="EdBa" size="20" value="<?Php echo"$EdBa";?>">
                      </tr>


                     <tr>
                      <td width="5%">&nbsp;</td>
                      <td width="19%"><font face="Arial" size="2">Estação</font></td>
                      <td width="73%"><select name="CxEstacao" size="1" >
                      <?Php if ($CxEstacao==''){ $CxEstacao='Selecionar';} /* Vazio qdo vem na abertura da pagina */   ?>
                      <option><?Php echo"$CxEstacao"; ?></option>
                      <option>PGO</option>
                      <option>CAT</option>
                      <option>CACA</option>
                      <option>CBQ</option>
                      <option>COWI</option>
                      <option>LAGY</option>
                      <option>HARM</option>
                      <option>IZU</option>
                      <option>ORG</option>
                      <option>PEI</option>
                      <option>PIS</option>
                      <option>RRV</option>
                      <option>TBG</option>
                      <option>TEB</option>
                      <option>---</option>
                      <option>D202</option>
                      <option>D203</option>
                      <option>D204</option>
                      <option>D205</option>
                      <option>D206</option>
                      <option>D207</option>
                      <option>D208</option>
                      <option>D209</option>
                      <option>D210</option>
                      <option>D211</option>
                      <option>D212</option>
                      <option>D215</option>
                      <option>---</option>
                      <option>AAPA</option>
                  <option>AAT</option>
                  <option>ALPR</option>
                  <option>AMP</option>
                  <option>AND</option>
                  <option>AOL</option>
                  <option>APO</option>
                  <option>APS</option>
                  <option>APU</option>
                  <option>ARIN</option>
                  <option>ASS</option>
                  <option>AVL</option>
                  <option>BAEO</option>
                  <option>BDJ</option>
                  <option>BNT</option>
                  <option>BOVE</option>
                  <option>BSU</option>
                  <option>BUU</option>
                  <option>BVP</option>
                  <option>BZI</option>
                  <option>CAB</option>
                  <option>CACA</option>
                  <option>CASM</option>
                  <option>CAT</option>
                  <option>CBQ</option>
                  <option>CBR</option>
                  <option>CBY</option>
                  <option>CDQ</option>
                  <option>CDSL</option>
                  <option>CFE</option>
                  <option>CFN</option>
                  <option>CGH</option>
                  <option>CLL</option>
                  <option>CMB</option>
                  <option>CMIO</option>
                  <option>CMK</option>
                  <option>COWI</option>
                  <option>CPP</option>
                  <option>CTMD</option>
                  <option>CUL</option>
                  <option>CUMI</option>
                  <option>CYV</option>
                  <option>CZC</option>
                  <option>D203</option>
                  <option>D204</option>
                  <option>D205</option>
                  <option>D206</option>
                  <option>D207</option>
                  <option>D208</option>
                  <option>D209</option>
                  <option>D210</option>
                  <option>D211</option>
                  <option>ENRO</option>
                  <option>FEPI</option>
                  <option>FGA</option>
                  <option>FOS</option>
                  <option>FXL</option>
                  <option>FZJR</option>
                  <option>GDE</option>
                  <option>GDM</option>
                  <option>GNC</option>
                  <option>GOIO</option>
                  <option>GPM</option>
                  <option>GRP</option>
                  <option>GUAM</option>
                  <option>GUAR</option>
                  <option>GUC</option>
                  <option>HARM</option>
                  <option>IBEM</option>
                  <option>IBT</option>
                  <option>IMB</option>
                  <option>INM</option>
                  <option>IOR</option>
                  <option>IRI</option>
                  <option>IUV</option>
                  <option>IVP</option>
                  <option>IVY</option>
                  <option>IYA</option>
                  <option>IZU</option>
                  <option>JAR</option>
                  <option>JDG</option>
                  <option>JDNS</option>
                  <option>JDS</option>
                  <option>JGP</option>
                  <option>JIV</option>
                  <option>JOI</option>
                  <option>JOZN</option>
                  <option>JQA</option>
                  <option>JUL</option>
                  <option>JZN</option>
                  <option>JZO</option>
                  <option>KGL</option>
                  <option>KLE</option>
                  <option>LARL</option>
                  <option>LDA</option>
                  <option>LDN</option>
                  <option>LJS</option>
                  <option>LLS</option>
                  <option>LPP</option>
                  <option>LUAR</option>
                  <option>LUD</option>
                  <option>MARQ</option>
                  <option>MIV</option>
                  <option>MLA</option>
                  <option>MLL</option>
                  <option>MNR</option>
                  <option>MQRS</option>
                  <option>MQS</option>
                  <option>MRB</option>
                  <option>MRZA</option>
                  <option>NFA</option>
                  <option>NIT</option>
                  <option>NLJ</option>
                  <option>NMD</option>
                  <option>NOSE</option>
                  <option>NSB</option>
                  <option>NTS</option>
                  <option>ORG</option>
                  <option>PAIQ</option>
                  <option>PBRO</option>
                  <option>PDT</option>
                  <option>PEI</option>
                  <option>PFI</option>
                  <option>PGO</option>
                  <option>PHL</option>
                  <option>PHO</option>
                  <option>PIG</option>
                  <option>PIS</option>
                  <option>PITN</option>
                  <option>PLF</option>
                  <option>PML</option>
                  <option>PNMA</option>
                  <option>POM</option>
                  <option>PRPO</option>
                  <option>PRU</option>
                  <option>PUF</option>
                  <option>PUN</option>
                  <option>PZS</option>
                  <option>QTG</option>
                  <option>QZOP</option>
                  <option>RBC</option>
                  <option>RBI</option>
                  <option>RBM</option>
                  <option>RBN</option>
                  <option>REB</option>
                  <option>RESE</option>
                  <option>RHG</option>
                  <option>RHL</option>
                  <option>RLA</option>
                  <option>RRV</option>
                  <option>RSO</option>
                  <option>RZL</option>
                  <option>SADP</option>
                  <option>SAY</option>
                  <option>SCE</option>
                  <option>SEN</option>
                  <option>SFF</option>
                  <option>SGX</option>
                  <option>SIF</option>
                  <option>SJI</option>
                  <option>SJSE</option>
                  <option>SLAA</option>
                  <option>SLT</option>
                  <option>SMDA</option>
                  <option>SNI</option>
                  <option>SNM</option>
                  <option>SNP</option>
                  <option>SOJO</option>
                  <option>SOS</option>
                  <option>SOX</option>
                  <option>SPE</option>
                  <option>SQC</option>
                  <option>SRJ</option>
                  <option>SSL</option>
                  <option>STMT</option>
                  <option>SVI</option>
                  <option>SVY</option>
                  <option>TAMR</option>
                  <option>TBG</option>
                  <option>TEB</option>
                  <option>TMZ</option>
                  <option>TUO</option>
                  <option>TXR</option>
                  <option>UBSU</option>
                  <option>URI</option>
                  <option>UVA</option>
                  <option>VADZ</option>
                  <option>VIEH</option>
                  <option>VIGU</option>
                  <option>VIPR</option>
                  <option>VIRE</option>
                  <option>VRN</option>
                  <option>VTN</option>
                  <option>WBZ</option>
                       </select><input type="text" name="EdEstacao" size="2" value="<?Php echo"$EdEstacao";?>"></td>
                      </tr>
                      <tr>
                      <td width="5%">&nbsp;</td>
                      <td width="19%"><font face="Arial" size="2">Fabricante</font></td>
                      <td width="73%"><select name="CxFabricante" size="1" onchange="this.form.submit();">
                      <?Php if ($CxFabricante==''){ $CxFabricante='Selecionar';} /* Vazio qdo vem na abertura da pagina */   ?>
                      <option><?Php echo"$CxFabricante"; ?></option>                     
                      <option>  ALCATEL  </option>
                      <option>  ASGA  </option>
                      <option>  AT&T TELECOMUNICAÇÕES  </option>
                      <option>  CISCO SYSTEMS  </option>
                      <option>  CORNING  </option>
                      <option>  DATACOM  </option>
                      <option>  DIGITEL </option>
                      <option>  ERICSSON  </option>
                      <option>  HUAWEI TECHNOLOGIES </option>
                      <option>  LUCENT TEC.NETWORK SYSTEMS </option>
                      <option>  MARCONI C T LTDA.  </option>
                      <option>  RAD  </option>
                      <option>  SIECOR  </option>
                      <option>  SIEMENS </option>
                      <option>  TELEMATICS INTERNATIONAL INC</option>
                      <option>  UTSTARCOM  </option>
					  <option>  ZTE  </option>
					  
                      
                       </select><input type="text" name="EdFabricante" size="10" value="<?Php echo"$EdFabricante";?>"></td>
           
                     <tr>
                      <td width="5%">&nbsp;</td>
                      <td width="19%"><font face="Arial" size="2">Placa</font></td>
                      <td width="73%"><select name="CxPlaca" size="1" >
                      <?Php if ($CxPlaca==''){ $CxPlaca='Selecionar';} /* Vazio qdo vem na abertura da pagina */   ?>
                      <option><?Php echo"$CxPlaca"; ?></option>
                      <?Php 
							for ($P=0; $P<$QtosRegX; $P++){ ?>
								<option> <?Php echo"$PlacaX[$P]"; ?></option>
					<?Php  	
							} 
					?>                     
                      <?Php 
					  if($CxFabricante=='TELEMATICS INTERNATIONAL INC'){ 
					  ?>
                      <option>  PLACA HAD  (  F-0013-0  )</option>
                      <option>  PLACA DE MODEM  (  F-0151-0  )</option>
                      <option>  PLACA HCM   REDE PACPAR  (  F-0152-0  )</option>
                      <option>  FONTE DE ALIMENTACAO  (  F-0150-0  )</option>
                      <option>  DISK DRIVE  (  F-0196-0  )</option>
                      <option>  H/W LPM 2 CH V.35  (  F-0055-0  )</option>
                      <option>  H/W LPE - V24  (  F-0082-0  )</option>
                      <option>  X.25 COMM PRCSR - XCP  (  F-0139-0  )</option>
                      <option>  H/W LPE - V24  (  F-0082-0  )</option>
                      <option>  PLACA NCP  (  F-0247-0  )</option>
                      <option>  BANDEJA VENTILAÇÃO C/ 04 FAN  (  M106-0084-01  )</option>

                      <?Php
					  } 
					  if($CxFabricante=='ALCATEL'){
					  ?>
                      <option>  PLACA DE MOD MEM 2 GEN D118  (  90-7664-01  )</option>
                      <option>  PLACA PIM RS-422 CARD  (  90-1549-01  )</option>
                      <option>  PAINEL DISTRIBUICAO UNIVERSAL  (  90-1615-01  )</option>
                      <option>  ADAPTADOR UDP V.35 (DCE)  (  90-1642-06  )</option>
                      <option>  SWITCHING CARD (CARTÃO COMUT)  (  90-0640-03  )</option>
                      <option>  PLACA CARTÃO SWITCHING INTERF CARD V.00-E  (  90-0639-03  )</option>
                      <option>  CABO PARA PAINEL DISTRIBUICAO V35 V.00-A  (  90-0555-01  )</option>
                      <option>  SUB BASTIDOR SHELF 3600 SIMP / DP  (  90-0010-10  )</option>
                      <option>  PLACA CARTÃO SWITCHING INTERF CARD V.00-E  (  90-0639-03  )</option>
                      <option>  PLACA PIM CABLE 8UCS V.00-C  (  90-0090-05  )</option>
                      <option>  PLACA PIM RS-422 CARD  (  90-1549-01  )</option>
                      <option>  BAND VENT (DUAL V.00-G)  (  90-0890-01  )</option>
                      <option>  SUB BASTIDOR SHELF 3600 SIMP / DP  (  90-0010-10  )</option>
                      <option>  ADAPTADOR UDP V.35 (DCE)  (  90-1642-06  )</option>
                      <option>  CABO PARA PAINEL DISTRIBUICAO V35 V.00-A  (  90-0555-01  )</option>
                      <option>  REDUNDANT SWITCHING  (  90-0697-01  )</option>

                      <?Php
					  } 
					  if($CxFabricante=='AT&T TELECOMUNICAÇÕES') {
					  ?>
                      <option>  POWER UNIT  (  DCX1836  )</option>
                      <option>  ECPU - I/O BOARD  (  AWJ15  )</option>
                      <option>  SCSI/DKI - I/O BOARD  (  ASP4B  )</option>
                      <option>  I/O BOARD  (  AWJ24  )</option>
                      <option>  INTERLIGADOR DE FUXO DE 2 MEGA  (  AWJ33  )</option>
                      <option>  SWT - RS232 - I/O BOARD  (  AWJ11  )</option>
                      <option>  DISK  (  TN2098  )</option>
                      <option>  TAPE - I/O BOARD  (  ASP8  )</option>
                      <option>  TY12  (  TN1011C  )</option>
                      <option>  SWT - RS232 - I/O BOARD  (  AWJ11  )</option>
                      <option>  MRCM - I/O BOARD  (  AWJ16B  )</option>
                      <option>  TY12 - I/O BOARD  (  AWJ4  )</option>
                      <option>  MRCM - INTERFACE  (  TN2109C  )</option>
                      <option>  SWT  (  TN2092  )</option>
                      <option>  FRM PLACA FRAME RELAY -PACPAR  (  MC1D 143A1  )</option>
                      <option>  SWT  (  TN2092  )</option>
                      <option>  SWT - V.35 - I/O BOARD  (  AWJ9  )</option>
                      <option>  INTERLIGADOR DE FUXO DE 2 MEGA  (  AWJ33  )</option>

                      <?Php
						}
						if($CxFabricante=='CISCO SYSTEMS'){
					?>
                      <option>  PLACA UFM-U V35  (  UFM-U  )</option>
                      <option>  PORT ADAPTER FRONT-PAINEL VIEW  (  PA-MC-8E1  )</option>
                      <option>  PLACA DE ROTEADOR  (  VIP4-80  )</option>
                      <option>  VERSATILE INTERFACE PROCESSOR  MODEL 80  (  VIP6-80  )</option>
                      <option>  PLACA UFM-U V35  (  UFM-U  )</option>
                      <option>  MEM - VIP-4 - 256M-SD  (  MEM - VIP-4 - 256M-SD  )</option>
                      <option>  PLACA UFM-C  (  UFM-C  )</option>
                      <option>  CISCO 7505/7507/7513/7576 ROUTE SWITCH PROCESSADOR  (  RSP8  )</option>
                      <option>  PLACA UFI  (  UFI-8E1  )</option>
                      <option>  PLACA UFM-U V35  (  UFM-U  )</option>
                      <option>  PLACA IGX UFI 12 V35  (  BC UFI-12 V.35=  )</option>
                      <option>  PLACA UFM-U V35  (  UFM-U  )</option>
                      <option>  PLACA IGX UFI 12 V35  (  BC UFI-12 V.35=  )</option>
                      <option>  PLACA UFM-C  (  UFM-C  )</option>
                      <option>  AS5300  (  AS5300  )</option>
                      <option>  MEMÓRIA PARA PLACA VIP6-80  (  MEM - VIP6 - 256M-SD-2  )</option>

                      <?Php
					  } 
					  if($CxFabricante=='DATACOM'){
					  ?>
                      <option>  CONVERSOR E2/E3 OPTICAL MUX  (  DM4E1  )</option>
                      <option>  PLACA DM705 DUAL V.35-V.36/V.11-V.28 INTERFACE HW3  (  800.0043.06  )</option>
                      <option>  DM705 SUB FAL  (  800.0156.03  )</option>
                      <option>  DM705-E1Q  -  quad e1  (  800.0169.03  )</option>
                      <option>  PLACA DM705 - SUB CPU - 64  (  800.0144.03  )</option>
                      <option>  DM705-SUB  (  800.0198.05  )</option>
                      <option>  DM705-CPU64 HW2  (  800.0261.00  )</option>
                      <option>  DM Switch 324F2  Layer 2 24 Port FE + 4 Port Combo GBE  (  800.0247.06  )</option>
                      <option>  DM705-E&M  -  2/4 WIRE  (  800.0089.02  )</option>

                      <?Php
					  } 
					  if($CxFabricante=='ERICSSON'){
					  ?>
                      <option>  PLACA EDN312p IP DSLAM POTS HW (12-line)  (  BFB 401 03/A11 R1C  )</option>
                      <option>  PLACA EDN312XP IP DSLAM POTS HW (12 LINE)  (  BFB 401 05/A11 R1A  )</option>

                       <?Php
					   } 
					   if($CxFabricante=='CORNING'){
					   ?>
                      <option>  SPLITER - COSPSA10224-201</option>


                      <?Php
					  } 
					  if($CxFabricante=='HUAWEI TECHNOLOGIES'){
					  ?>
                      <option>  32 PORT ADSL2 BOARD, WITH SPLITTER  (  ADGE  )</option>
                      <option>  CSM/12 SIGNAL PROCESSING BOARD ( 96 CHANNEL), Onboard as31vsua0  (  AS31CSMB  )</option>
                      <option>  2 PORT GE OPTICAL INTERFACE PRINCH BOARD (SINGLE MODE 10KM LC)  (  O2GS  )</option>
                      <option>  4 PORT GE/FE ELECTRICAL INTERFACE BOARD  (  E4GFA  )</option>
                      <option>  32 PORT ADSL2 BOARD, WITH SPLITTER  (  ADGE  )</option>
                      <option>  AS-VSU - EXPERT Voice Signaling Process Module 16E1  (  AS31VSUA0  )</option>
                      <option>  PLACA E1 E MODENS P/ ATEND. USUÁRIOS  (  VSPA  )</option>
                      <option>  PLACA ADLE H512 ADSL 32 CANAIS (COM SPLITTER)  (  ADLE  )</option>
                      <option>  SUPER CONTROL UNIT BOARD  (  SCUK  )</option>
                      <option>  PLACA ADCE1 H513  (  ADCE 1  )</option>
                      <option>  TRUNK CABLE  DB26 p/ placa vsu/frba 75 ohms, 20m - 8e1 interface  (  04040767  )</option>
                      <option>  32 PORT ADSL2 BOARD, WITH SPLITTER  (  ADGE  )</option>
                      <option>  PLACA E1 E MODENS P/ ATEND. USUÁRIOS  (  VSPA  )</option>
                      <option>  PLACA ADLE H512 ADSL 32 CANAIS (COM SPLITTER)  (  ADLE  )</option>
                      <option>  PLACA ADCE1 H513  (  ADCE 1  )</option>

                      <?Php
					  } 
					  if($CxFabricante=='LUCENT TEC.NETWORK SYSTEMS'){
					  ?>
                      <option>  PLACA 24 PORTAS  (  STGR-LPM-24-RP  )</option>
                      <option>  PLACA LIM 24C PORTAS  (  STGR-LIM-AD-24  )</option>
                      <option>  PLACA LIM AD 72  (  STGR-LIM-AD-72  )</option>
                      <option>  FLASH CARD PARA PLACA STGR-CM-A E STGRSP-CM  (  FLASH CARD  )</option>
                      <option>  STGR-LIM-AD-48  (  STGR-LIM-AD-48  )</option>
                      <option>  STGR-LIM-AD-48  (  STGR-LIM-AD-48  )</option>
                      <option>  VENTILADOR DSLAM - STINGER  (  STGRFS-SP-FAN  )</option>
                      <option>  STGR-LIM-AD-48  (  STGR-LIM-AD-48  )</option>
                      <option>  PLACA LIM AP 72  (  STGR-LIM-AP-72  )</option>
                      <option>  PLACA 48 PORTAS  (  STGR-LPM-48  )</option>

                      <?Php
					  } 
					  if($CxFabricante=='MARCONI C T LTDA'){
					  ?>
                      <option>  UNIDADE DE FLOPPY E DISCO       (PDIFLO)  (  131-6455/01  )</option>

                      <?Php
					  } 
					  if($CxFabricante=='RAD'){
					  ?>
                      <option>  CONVERSOR 100BASE T - 4X E1  --  RICI - 4E1  (  4560060000  )</option>

                      <?Php
					  } 
					  if($CxFabricante=='SIECOR'){
					  ?>
                      <option>  PLACA CANAIS  (  07-002727-001  )</option>

                      <?Php} if($CxFabricante=='SIEMENS'){?>
                      <option>  IU ADSL72 </option>

                      <?Php
					  } 
					  if($CxFabricante=='UTSTARCOM'){
					  ?>
					   <option>  PLACA ICM3 (  CONTROL )</option>
                      <option>  PLACA IPADSL3A - 24 PORTAS  (  AD-IPADSL  )</option>
                      <option>  48 PORT  26 MBPS  ANNEX  A 2FE OR 1 GE UPLINK  (  IPADSL6A  )</option>
                      <option>  48 PORT SPLITTER MODULE B1000  (  AD48G-RB  )</option>
                      <option>  ETHERNET/LINE ADAPTER IP ADSL  (  AD-ELAU  )</option>
                      <option>  PLACA AD-ICM4 PORT ETHERNET ADAPTER  (  AD-ICM4  )</option>
                      <option>  AD-ASSBY - PLACA CANAIS SPLITTER  (  TYPE-NA  )</option>
 					  
					  <?Php
					  } 
					  if($CxFabricante=='ZTE'){
					  ?>
                      <option>GIS</option>
					  <option>GISB</option>
					  <option>GAGL</option>
					  <option>IEBB</option>
					  <option>PAUN</option>
					  <option>POWER K</option>
					  <option>PEB</option>                      
                      <?Php 
					  } 
					  ?>
                       </select></td>
                      </tr>

                      <tr>
                      <td width="5%">&nbsp;</td>
                      <td width="19%"><font face="Arial" size="2">Placa(Complemento)</font></td>
                      <td width="73%"><input type="text" name="EdPlaca" size="89" value="<?Php echo"$EdPlaca";?>"></td>
                    </tr>

                     <tr>
                      <td width="5%">&nbsp;</td>
                      <td width="19%"><font face="Arial" size="2">Código<font face="Arial" size="1">&nbsp;(Defeito)</font></td>
                      <td width="73%"><input type="text" name="EdCodeDf" size="20" value="(90)22<?Php echo"$EdCodeDf";?>"></td>
                    </tr>
                    <tr>
                      <td width="5%">&nbsp;</td>
                      <td width="19%"><font face="Arial" size="2">Código<font face="Arial" size="1">&nbsp;(Ativa)</font></td>
                      <td width="73%"><input type="text" name="EdCodeAt" size="20" value="(90)22<?Php echo"$EdCodeAt";?>"></td>
                    </tr>
                    <tr>
                      <td width="5%">&nbsp;</td>
                      <td width="19%"><font face="Arial" size="2">Eqpto<font face="Arial" size="1">&nbsp;(aplicação)</font></td>
                      <td width="73%"><input type="text" name="EdEqpto" size="20" value="<?Php echo"$EdEqpto";?>"></td>
                    </tr>

                    <tr>
                      <td width="5%">&nbsp;</td>
                      <td width="19%"><font face="Arial" size="2">Operação</font></td>
                      <td width="73%"><select name="CxOperacao" size="1" >
                      <?Php if ($CxOperacao==''){ $CxOperacao='Reparo';} /* Vazio qdo vem na abertura da pagina */   ?>
                      <option><?Php echo"$CxOperacao"; ?></option>
                      <option>  Aquisição </option>
                      <option>  Devolução ao Lab. </option>
                      <option>  Reparo </option>
                      <option>  Repasse de téc. </option>
                      </select></td>
                      </tr>
                    <tr>
                      <td width="5%">&nbsp;</td>
                      <td width="19%"><font face="Arial" size="2">Descrição(defeito)</font></td>
                      <td width="73%"><input type="text" name="EdDescricao" size="90" value="<?Php echo"$EdDescricao";?>"></td>
                    </tr>
                    <tr>
                      <td width="5%">&nbsp;</td>
                      <td width="19%"><font face="Arial" size="2">Data</font></td>
                      <td width="73%"><input type="text" name="EdData" size="10" value="<?Php echo"$EdData";?>"></td>
                    </tr>

                    <tr>
                      <td width="5%">&nbsp;</td>
                      <td width="19%"><font face="Arial" size="2">Obs</font></td>
                      <td width="73%"><input type="text" name="EdObs" size="90" value="<?Php echo"$EdObs";?>"></td>
                    </tr>

            <tr>
                      <td width="5%">&nbsp;</td>
                      <td width="19%">&nbsp;</td>
                      <td width="73%">&nbsp;</td>
                    </tr>

            <tr>
                      <td width="5%">&nbsp;</td>
                      <td width="19%" colspan="1"><input type="submit" value="Salvar" name="BtCad" title="Salvar" style="background-image: url('imagens/filtrar.bmp'); font-family: Verdana; font-size: 10pt; cursor: hand"><input type="button" value="Limpar" name="BtLimpar" OnClick="window.location='index.php'" title="Limpar" style="background-image: url('imagens/filtrar.bmp'); font-family: Verdana; font-size: 10pt; cursor: hand"></td>
                      <td width="73%"></td>
                    </tr>
                   </form>

                    <tr>
                      <td width="5%">&nbsp;</td>
                      <td width="19%">&nbsp;</td>
                      <td width="73%">&nbsp;</td>
                    </tr>



            <!-- Final da Barra de botoes -->         

          <form name="Consultar modulo" method="post" action="consultar.php">
          <tr align="middle">
            <td width="100%" height="20" align="left" valign="top" colspan="3"><!--mstheme--><strong><font face="Verdana"><font color="#808080"><font size="2">Consultar
                  Módulo<!--mstheme--></font></font></font></strong></td>
          </tr> 
          <tr align="middle">
          <td width="100%" height="1" align="left" valign="top" colspan="3"><!--mstheme--><font face="Arial, Helvetica"><img height="2" src="imagens/Barra.gif" width="866" border="0"><!--mstheme--></font></td>
          </tr>

          <!-- Inicio Linha de consultar débitos -->



           <tr align="middle" height="1">
           <td width="5%">&nbsp;</td>
          <td width="95%" height="25" align="left" colspan="6"><!--mstheme--><font face="Arial, Helvetica">
          <select name="CxQtos" size="1">
          <?Php if ($CxQtos==''){ $CxQtos=10;} ?>
          <option><?Phpecho"$CxQtos"; ?></option>
            <option>10</option>
            <option>20</option>
            <option>30</option>
            <option>40</option>
            <option>50</option>
            <option>100</option>             </select>
          <select name="CxCltRegistro" size="1" >
            <?Php if ($CxCltRegistro==''){ $CxCltRegistro='Selecionar';} /* Vazio qdo vem na abertura da pagina */   ?>
            <option><?Php echo"$CxCltRegistro"; ?></option>
            <?Php for($T=$QtosRegX-$CxQtos; $T<$QtosRegX; $T++){
            if($RegX[$T]<>''){   ?>
                                    <option><?Php echo"$RegX[$T] - $PlacaX[$T] - $DataX[$T]"; ?></option>
            <?Php } }  ?>
            </select><!--mstheme--></font><input type="submit" value="Consultar" name="BtConsultar" object="" title="Consultar" style="background-image: url('imagens/lupa_.bmp'); font-family: Verdana; font-size: 10pt; cursor: hand"></td>

<!-- Fim Linha de consultar débitos --><!-- Inicio listagem de debitos -->

            </tr>
            </form>

            </table>

                </td>

              </tr>
            </table>

        <p align="left"><input type="button" value="Sair" name="BtLogoff" OnClick="window.location='/rede/consultar.php'" title="Sair" style="background-image: url('imagens/filtrar.bmp'); font-family: Verdana; font-size: 10pt; cursor: hand"><input type="button" value="Consultas" name="BtVoltar" OnClick="window.location='consultar.php'" title="Voltar" style="background-image: url('imagens/filtrar.bmp'); font-family: Verdana; font-size: 10pt; cursor: hand">
<!--        <input type="button" value="Carregar" name="BtCarga" OnClick="window.location='import_placas.php'" title="Carregar" style="background-image: url('imagens/filtrar.bmp'); font-family: Verdana; font-size: 10pt; cursor: hand"> <input type="button" value="Filtrar" name="BtFiltra" OnClick="window.location='Filtra_PN.php'" title="Filtra" style="background-image: url('imagens/filtrar.bmp'); font-family: Verdana; font-size: 10pt; cursor: hand"> -->

             </td>
        </tr>

      </table>
      </div>
    </td>
  </tr>
  <tr>
    <td width="74" bgcolor="#FFFFFF" height="117" valign="top"><!-- B591FC -->
    </td>
  </tr>
  <tr>
    <td width="74" bgcolor="#FFFFFF" height="1" valign="top"><!-- B591FC FF9944 -->
    </td>
  </tr>
  <tr>
    <td width="74" bgcolor="#FFFFFF" height="1" valign="bottom" align="center">
      &nbsp;
    </td>

  </tr>
  <tr>
    <td width="74" bgcolor="#808080" height="1" valign="middle" align="center">&nbsp;</td>

    <td width="613" colspan="2" align="center" height="18" valign="middle" bgcolor="#afb2ff">
    <a href="mailto:velislei@gmail.com?subject=Suporte ao Spart-X"><font size="1" color="#FFFFFF" face="verdana">Contactar suporte</font>
    </td>

  </tr>
  <tr>
    <td width="74" bgcolor="#FFFFFF" height="1" valign="middle" align="center">
     &nbsp;
    </td>

    <td width="100%" colspan="4" align="right" height="18" valign="middle" bgcolor="#FFFFFF">
    <p align="right"><font size="1" face="Times New Roman" color="#999999">
    <a href="mailto:contato@gmail.com"><font size="1" color="#FF8000" face="verdana"><?Php printf("%s",$versao); ?></a></font>
    </p>
    </td>
<!--                   href="mailto:recipient@domain.com?subject=SUBJECT-TEXT&body=BODY-TEXT&cc=OTH > ER-RECIPIENT&bcc=BLIND-RECIPIENT"> -->
  </tr>

</table>

						
		
				<!------------------------------------ Final Conteudo de  ------------------------------------------------------------------->				
				</div><!-- Conteúdo da Pesquisa (Resultdados)-->
			</td><!-- Conteúdo da Pesquisa (Resultdados)-->
			
			<!-- Conteúdo Direito(Publicidades) -->
			<td width="20%" colspan="1"   height="20" valign="top">
				<div id="conteudo_direito"><!-- Conteúdo Direito(Publicidades) -->
					  &nbsp;<!-- Resevado Publicidade -->
				</div><!-- Conteúdo Direito(Publicidades)-->			
			</td><!-- Conteúdo Direito(Publicidades) -->
			
			
			</tr><!-- Conteúdo Central(Esq, Pesq, Dir) -->
			</table><!-- Conteúdo Central(Esq, Pesq, Dir) -->   
			</td></tr></table><!-- Conteúdo Central - Margem -->
			</div><!-- Conteúdo Central(Esq, Pesq, Dir) -->	
			
		<!------------------------- Final Conteúdo central -------------------------------------------------------------------->
	</td></tr></table> 		
	</div><!-- Geral Direito -->
	
	</td>
	</tr>
	</form><!-- Localizar -->
	</table>
	
	<!-------------------------------- Final Geral Direito -------------------------------------------------------------------->
	
	<div id="rodape"><!-- Rodapé -->
		<table class"TAB_Rodape" width=100% align="center" valign="top">	
		<tr align="center"  height="5" valign="top">
			<td width="15%" colspan="1"  align="left"  height="5" valign="top"></td>		
			<td width="70%" colspan="1"  align="left"  height="5" valign="top">		
				<a href="<?Php echo"$AttribRodapeLink00"; ?>" class="fonte_rodape"><?Php echo"$AttribRodape00"; ?></a>
				&nbsp;			
				<a href="<?Php echo"$AttribRodapeLink01"; ?>" class="fonte_rodape"><?Php echo"$AttribRodape01"; ?></a>			
			</td>
			<td width="15%" colspan="1"  align="left"  height="5" valign="top">
				<img border="0" src="imagens/<?Php echo"$AttribRodapeImg00"; ?>" width="88" height="31">
				<img border="0" src="imagens/<?Php echo"$AttribRodapeImg01"; ?>" width="88" height="31">
			</td>		
		</tr>
		</table>	
	
	</div><!-- Rodapé -->


</div><!-- Pagina Geral --> 


	
</body>

</html>