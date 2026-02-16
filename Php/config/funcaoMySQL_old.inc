<?Php	
	

function ContarRegistros($AssuntoX)
{	
		$link = mysql_connect('localhost', 'root', '');
		mysql_select_db('Rede', $link);
		if($AssuntoX=='Full'){	$sql="SELECT registro FROM comandos"; }
		else{ $sql="SELECT registro FROM comandos where assunto='$AssuntoX'"; }
		$result = mysql_query($sql, $link);
		while ($row = mysql_fetch_assoc($result)) 
		{	
			$RegX[] = $row['registro'];
		}
		mysql_free_result($result);				
		$Total = count($RegX);		
		return ($Total);		
}

		
function LocalizaMySQL($PesquisarX)
{	
		$link = mysql_connect('localhost', 'root', '');
		mysql_select_db('Rede', $link);
		$sql="select * from comandos where topico like '%$PesquisarX%' or procedimento like '%$PesquisarX%' or descricao like '%$PesquisarX%' or comando like '%$PesquisarX%'"; 
		$result = mysql_query($sql, $link);
		while ($row = mysql_fetch_assoc($result)) 
		{	
			$RegX[] = $row['registro']; 
			$TopicoX[] = $row['topico']; 
			$IndiceX[] = $row['procedimento']; 
			$DescricaoX[] = $row['descricao']; 
			$ComandoX[] = $row['comando']; 
			$EnderecoX[] = $row['endereco']; 
		}
		mysql_free_result($result);		
		$Total = count($RegX);
	
		return ($ResultaN);
		
}

function Localizar($TopicoCorrente, $PesquisarX)
{	
		$L = 0;
		$link = mysql_connect('localhost', 'root', '');
		mysql_select_db('Rede', $link);
		if($TopicoCorrente <> ""){ $sql="select * from comandos where (topico='$TopicoCorrente')and(procedimento like '%$PesquisarX%' or descricao like '%$PesquisarX%' or comando like '%$PesquisarX%') ORDER BY recentes DESC"; }
		else{$sql="select * from comandos where (procedimento like '%$PesquisarX%' or descricao like '%$PesquisarX%' or comando like '%$PesquisarX%') ORDER BY recentes DESC"; }	
		$result = mysql_query($sql, $link);
		while ($row = mysql_fetch_assoc($result)) 
		{	
			$ResultaL[$L][0] = $row['registro']; 
			$ResultaL[$L][1] = $row['topico']; 
			$ResultaL[$L][2] = $row['procedimento']; 
			$ResultaL[$L][3] = $row['descricao']; 
			$ResultaL[$L][4] = $row['comando']; 
			$ResultaL[$L][5] = $row['endereco']; 
			$L++;
		}
		mysql_free_result($result);	


		return ($ResultaL);				
				
}

function QueryItemAttribAtual($Item,$RegItemCur)
{
	// Retorna Assunto / Topico em uso
	
		$link = mysql_connect('localhost', 'root', '');
		mysql_select_db('Rede', $link);
		$sql = "SELECT $Item FROM comandos where registro='$RegItemCur'";
		$result = mysql_query($sql, $link);
		while ($row = mysql_fetch_assoc($result)) {	
			if($Item == 'assunto'){ $ItemCorrente=$row['assunto']; 	}
			if($Item == 'topico'){ $ItemCorrente=$row['topico']; 	}
		}
		mysql_free_result($result);	
		
		return ($ItemCorrente);	
		
}
// DELETE FROM `Rede`.`comandos` WHERE (`registro` LIKE '%teste3%' OR `eqpto` LIKE '%teste3%' OR `procedimento` LIKE '%teste3%' OR `tipo` LIKE '%teste3%' OR `status` LIKE '%teste3%' OR `endereco` LIKE '%teste3%' OR `comando` LIKE '%teste3%' OR `descricao` LIKE '%teste3%' OR `obs` LIKE '%teste3%')

function PegarItemTopico($Assunto)
{
	$T=0;
	$link = mysql_connect('localhost', 'root', '');
	mysql_select_db('Rede', $link);
	$sql = "SELECT DISTINCT topico FROM comandos WHERE assunto='$Assunto' ORDER BY topico";
	$result = mysql_query($sql, $link);
	while ($row = mysql_fetch_assoc($result)) {	
		$Item[$T][1]=$row['topico']; 
		$Item[$T][0]=PegarRegistro($Item[$T][1]); 	// Usa funcao p/ pegar Reg a fim de possibilitar consulta mysql de topicos Distintos(Se não há muita repetição)
		$T++;
	}
	mysql_free_result($result);					
	
		
	return($Item);
}

function ListarCampo($Campo)
{
	//$T=0;
	$link = mysql_connect('localhost', 'root', '');
	mysql_select_db('Rede', $link);
	$sql = "SELECT DISTINCT $Campo FROM comandos ORDER BY $Campo";
	$result = mysql_query($sql, $link);
	while ($row = mysql_fetch_assoc($result)) {	
		$Item[]=$row[$Campo]; 
		
	}
	mysql_free_result($result);					
	
		
	return($Item);
}

function PegarRegistro($ItemTopico)
{
	// Função auxiliar de: PegarItemTopico()
	// Pega Registro associado a cada item, p/ transferir de página
	
	$link = mysql_connect('localhost', 'root', '');
	mysql_select_db('Rede', $link);
	$sql = "SELECT registro FROM comandos WHERE topico='$ItemTopico'";
	$result = mysql_query($sql, $link);
	while (	$row = mysql_fetch_assoc($result)) { $Reg[]=$row['registro']; }
	mysql_free_result($result);

	return ($Reg[0]);	
}

 

function CltComando($Registro)
{	
		$link = mysql_connect('localhost', 'root', '');
		mysql_select_db('Rede', $link);
		if($Registro > 1){ $sql = "SELECT * FROM comandos WHERE registro='$Registro'"; }
		else{ $sql = "SELECT * FROM comandos";	}
		$result = mysql_query($sql, $link);
		while ($row = mysql_fetch_assoc($result)) 
		{	
			$Resulta[0] = $row['assunto']; 
			$Resulta[1] = $row['topico']; 
			$Resulta[2] = $row['procedimento']; 
			$Resulta[3] = $row['descricao']; 
			$Resulta[4] = $row['comando']; 
			$Resulta[5] = $row['endereco']; 
			
		}
		mysql_free_result($result);
		
		return $Resulta;
		
}

function ListarCmd($Registro)
{	
		$P = 0;
		$link = mysql_connect('localhost', 'root', '');
		mysql_select_db('Rede', $link);
		if($Registro > 1){ $sql = "SELECT * FROM comandos WHERE registro='$Registro'"; }
		else{ $sql = "SELECT * FROM comandos";	}
		$result = mysql_query($sql, $link);
		while ($row = mysql_fetch_assoc($result)) 
		{	
			$Resulta[$P][0] = $row['registro'];
			$Resulta[$P][1] = $row['assunto']; 
			$Resulta[$P][2] = $row['topico']; 
			$Resulta[$P][3] = $row['procedimento']; 
			$Resulta[$P][4] = $row['descricao']; 
			$Resulta[$P][5] = $row['comando']; 
			$Resulta[$P][6] = $row['endereco']; 
			$P++;
			 
		}
		mysql_free_result($result);
		
		return $Resulta;
		
}

function QueryTopico($TopicoX)
{	
		$P = 0;		
		$link = mysql_connect('localhost', 'root', '');
		mysql_select_db('Rede', $link);
		$sql = "SELECT * FROM comandos WHERE topico='$TopicoX' ORDER BY procedimento ASC";				
		$result = mysql_query($sql, $link);
		while ($row = mysql_fetch_assoc($result)) 
		{	
			$Resulta[$P][0] = $row['registro'];
			$Resulta[$P][1] = $row['assunto']; 
			$Resulta[$P][2] = $row['topico']; 
			$Resulta[$P][3] = $row['procedimento']; 
			$Resulta[$P][4] = $row['descricao']; 
			$Resulta[$P][5] = $row['comando']; 
			$Resulta[$P][6] = $row['endereco']; 	
			$Resulta[$P][7] = $row['status']; 
			$Resulta[$P][8] = $row['obs']; 

			$P++;			 
		}
		mysql_free_result($result);
		
		return $Resulta;
		
}

function SalveEditar($Registro, $Assunto, $Topico, $Indice, $Descricao, $Comando)
{	
	$resultado = true;
	if (!$link = mysql_connect('localhost', 'root', '')) {
		$resultado = false;		// echo '1 - Não foi possível conectar ao mysql';
		exit;
	}

	if (!mysql_select_db('Rede', $link)) {
		$resultado = false;	// echo '2 - Não foi possível selecionar o banco de dados';
		exit;
	}

	$sql = "UPDATE comandos SET assunto='$Assunto', topico='$Topico', procedimento='$Indice', descricao='$Descricao', comando='$Comando' WHERE registro='$Registro'";			
	$result = mysql_query($sql, $link);

	if (!$result) {
		$resultado = false;		// echo "3 - Erro do banco de dados, não foi possível consultar o banco de dados\n";
								// echo '4 - Erro MySQL: ' . mysql_error();
		exit;
	}
	 mysql_close($link);
	
	return $resultado;
		
}

function Recentes($Registro, $Acao)
{	
	/* Registra data do acesso */
	
	$Agora = date('ymdhis');
	$DataReg = $Agora + $Registro;	// Soma Data, Hora com registro para filtrar (Registros recentes - filtro trata como um empilhamento, os mais recentes em cima)
	
	$resultado = true;
	if (!$link = mysql_connect('localhost', 'root', '')) {
		$resultado = false;		// echo '1 - Não foi possível conectar ao mysql';
		exit;
	}

	if (!mysql_select_db('Rede', $link)) {
		$resultado = false;	// echo '2 - Não foi possível selecionar o banco de dados';
		exit;
	}
	
	if($Acao=="Clear"){ $sql = "UPDATE comandos SET recentes=registro WHERE registro>0"; }	// Limpa recentes
	else{ $sql = "UPDATE comandos SET recentes='$DataReg' WHERE registro='$Registro'"; }	// Registra acesso
	$result = mysql_query($sql, $link);

	if (!$result) {
		$resultado = false;		// echo "3 - Erro do banco de dados, não foi possível consultar o banco de dados\n";
								// echo '4 - Erro MySQL: ' . mysql_error();
		exit;
	}
	 mysql_close($link);
	
	if($Acao=="Clear"){ $resultado = "Historico de recentes excluído com sucesso!"; }
	
	return $resultado;
		
}

function SalveAdicionar($Assunto, $Topico, $Indice, $Descricao, $Comando)
{	
	// echo"Salvando...";
	
	$resultado = true;
	if (!$link = mysql_connect('localhost', 'root', '')) {
		$resultado = false;		// echo '1 - Não foi possível conectar ao mysql';
		exit;
	}

	if (!mysql_select_db('Rede', $link)) {
		$resultado = false;	// echo '2 - Não foi possível selecionar o banco de dados';
		exit;
	}

	$sql = "INSERT INTO comandos(assunto, topico, procedimento, descricao, comando)	VALUE('$Assunto', '$Topico', '$Indice', '$Descricao', '$Comando')";			

	$result = mysql_query($sql, $link);

	if (!$result) {
		$resultado = false;		// echo "3 - Erro do banco de dados, não foi possível consultar o banco de dados\n";
								// echo '4 - Erro MySQL: ' . mysql_error();
		exit;
	}
	 mysql_close($link);
	
	return $resultado;
		
}

function Excluir($Registro)
{	
	$resultado = true;
	if (!$link = mysql_connect('localhost', 'root', '')) {
		$resultado = false;		// echo '1 - Não foi possível conectar ao mysql';
		exit;
	}

	if (!mysql_select_db('Rede', $link)) {
		$resultado = false;	// echo '2 - Não foi possível selecionar o banco de dados';
		exit;
	}

	$sql = "DELETE FROM comandos WHERE registro='$Registro'";			
	$result = mysql_query($sql, $link);

	if (!$result) {
		$resultado = false;		// echo "3 - Erro do banco de dados, não foi possível consultar o banco de dados\n";
								// echo '4 - Erro MySQL: ' . mysql_error();
		exit;
	}
	 mysql_close($link);
	
	return $resultado;
		
}
?>
