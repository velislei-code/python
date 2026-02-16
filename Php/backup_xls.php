<?php

	header("Content-Type: application/vnd.ms-excel");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

?>
<html>

<head>
<title>Relatorio</title>
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="Microsoft Theme" content="radius 011">
</head>

<body background="imagens/radbkgnd.jpg" bgcolor="#FFFFFF" text="#000000" link="#996633" vlink="#666600" alink="#CC9900">
<!--mstheme--><font face="Verdana, Arial, Helvetica">

<?Php
		
		include_once('Class.mysql.php');

        $hoje=date("d/M/Y");
       	
		$objFuncao = new MySQL();
				
		$ListaCmd = $objFuncao->ListarCmd(Null);
	
	

?>

<div align="center"><center>

<table border="0" width="100%" cellspacing="0" cellpadding="0" height="196">
<table width="200" border="1" cellspacing="0" cellpadding="2">
	<tr align="center" bgcolor="#c0c0c0">
		<td width="30" align="left" colspan="6"><font size="2" face="Times New Roman, Times, serif"><b><?Php echo"Lista de cadastro tabela Comandos: $hoje";   ?></b></font></td>
	</tr>    
	<tr align="center" bgcolor="#808080">
		<td width="30" align="center"><font size="2" face="Times New Roman, Times, serif"><b>Reg</b></font></td>
		<td width="100" align="center"><font size="2" face="Times New Roman, Times, serif"><b>Tópico</b></font></td>
		<td width="100" align="center"><font size="2" face="Times New Roman, Times, serif"><b>Eqpto</b></font></td>
		<td width="200" align="center"><font size="2" face="Times New Roman, Times, serif"><b>Procedimento</b></font></td>
		<td width="750" align="center"><font size="2" face="Times New Roman, Times, serif"><b>Descrição</b></font></td>
		<td width="750" align="center"><font size="2" face="Times New Roman, Times, serif"><b>Comando</b></font></td>
	</tr>
 <?Php 
	 for($T=0; $T<$ListaCmd[100][100]; $T++){
 ?>
   <tr>
	    <td width="30" align="center"><font size="2" face="Times New Roman, Times, serif"><?Php printf("%s",$ListaCmd[0][$T]); ?></font></td>
		<td width="100" align="center"><font size="2" face="Times New Roman, Times, serif"><?Php printf("%s",$ListaCmd[1][$T]); ?></font></td>
		<td width="100" align="center"><font size="2" face="Times New Roman, Times, serif"><?Php printf("%s",$ListaCmd[2][$T]); ?></font></td>
		<td width="200" align="center"><font size="2" face="Times New Roman, Times, serif"><?Php printf("%s",$ListaCmd[3][$T]); ?></font></td>
		<td width="750" align="center"><font size="2" face="Times New Roman, Times, serif"><?Php printf("%s",$ListaCmd[4][$T]); ?></font></td>
		<td width="750" align="center"><font size="2" face="Times New Roman, Times, serif"><?Php printf("%s",$ListaCmd[5][$T]); ?></font></td>
    </tr>
	
    <?Php }  ?>


    </table>

</body>
</html>