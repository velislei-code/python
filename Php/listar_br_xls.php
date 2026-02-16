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
		
		include_once('Class.almox.php');

        $hoje=date("d/M/Y");
       	
		$objAlmox = new Almox();
				
		$ListaBR = $objAlmox->ListarBR('null');
	
	

?>

<div align="center"><center>

<table border="0" width="100%" cellspacing="0" cellpadding="0" height="196">
<table width="200" border="1" cellspacing="0" cellpadding="2">
	<tr align="center" bgcolor="#c0c0c0">
		<td width="30" align="left" colspan="6"><font size="2" face="Times New Roman, Times, serif"><b><?Php echo"Lista de cadastro tabela Comandos: $hoje";   ?></b></font></td>
	</tr>    
	<tr align="center" bgcolor="#808080">
		<td width="30" align="center"><font size="2" face="Times New Roman, Times, serif"><b>Reg</b></font></td>
		<td width="100" align="center"><font size="2" face="Times New Roman, Times, serif"><b>PN</b></font></td>
		<td width="100" align="center"><font size="2" face="Times New Roman, Times, serif"><b>Fab</b></font></td>
		<td width="200" align="center"><font size="2" face="Times New Roman, Times, serif"><b>NS(Atv)</b></font></td>
		<td width="200" align="center"><font size="2" face="Times New Roman, Times, serif"><b>NS(Def)</b></font></td>
		<td width="750" align="center"><font size="2" face="Times New Roman, Times, serif"><b>CodBar(Atv)</b></font></td>
		<td width="750" align="center"><font size="2" face="Times New Roman, Times, serif"><b>CodBar(Def)</b></font></td>
		<td width="750" align="center"><font size="2" face="Times New Roman, Times, serif"><b>Desc(Def)</b></font></td>
		<td width="750" align="center"><font size="2" face="Times New Roman, Times, serif"><b>Data(Def)</b></font></td>
		<td width="750" align="center"><font size="2" face="Times New Roman, Times, serif"><b>BA</b></font></td>
		<td width="750" align="center"><font size="2" face="Times New Roman, Times, serif"><b>Est</b></font></td>
		<td width="750" align="center"><font size="2" face="Times New Roman, Times, serif"><b>Loc</b></font></td>
		<td width="750" align="center"><font size="2" face="Times New Roman, Times, serif"><b>Obs</b></font></td>
		<td width="750" align="center"><font size="2" face="Times New Roman, Times, serif"><b>Data(Env)</b></font></td>
	</tr>
 <?Php 
	 for($T=0; $T<$ListaBR[100][100]; $T++){
 ?>
   <tr>
       <?Php  for($C=0; $C<14; $C++){ ?>
	       <td width="30" align="center"><font size="2" face="Times New Roman, Times, serif"><?Php printf("%s.",$ListaBR[$C][$T]); ?></font></td>
       <?Php } ?>
    </tr>
	
    <?Php }  ?>


    </table>

</body>
</html>