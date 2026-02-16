
<?Php	

/**
 * MySQL - Classe de manipula��o banco MySQL
 * NOTE: Requer PHP vers�o 5 ou superior
 * @package Biblioteca
 * @author Treuk, Velislei A.
 * @email: velislei@gmail.com
 * @copyright 2010 - 2015 
 * @licen�a: Estudantes
 */
 
include_once("Class.funcao.php");


class MySQL {
	
	

function ContarRegistros($AssuntoX)
{	
		$objFuncao = new Funcao();
		$objFuncao->RegistrarLog('Class.MySql.ContarRegistros('.$AssuntoX.');');
	
	
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

		$objFuncao = new Funcao();
		$objFuncao->RegistrarLog('Class.MySql.LocalizaMySQL('.$PesquisarX.');');
	
	
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
    
        /* 
         * Executa um pr�-filtro para o tipo de pesquisa do usu�rio:
         * Simples ou combinada(AND(A+B+C), OU(A B C) e "rocura texto complet")       
        */
		$objFuncao = new Funcao();
		$objFuncao->RegistrarLog('Class.MySql.Localizar('.$TopicoCorrente.', '.$PesquisarX.');');
	
        //echo 'Class.MySql.Localizar('.$TopicoCorrente.', '.$PesquisarX.')'.'<br>';
	
    	$ResultaL[][]="";	// Inicializa
	
         $AspasDupla = "\""; 
         $AspasSimples = "'";     
         
         // Procura por pesquisas com Aspas("texto completo")
         if( (strpos("[".$PesquisarX."]", "$AspasSimples"))||(strpos("[".$PesquisarX."]", "$AspasDupla")) )
         {
           // echo 'A pesquisa com Aspas'.'<br>';
             
            if(strpos("[".$PesquisarX."]", "$AspasSimples")){
                $PesquisarY = str_replace($AspasSimples,"",$PesquisarX); // Tira Aspas 
            }else{
                $PesquisarY = str_replace($AspasDupla,"",$PesquisarX); // Tira Aspas 
            }
            $ResultaL = $this->LocalizarSimples($TopicoCorrente, $PesquisarY);
          
         // Pesquisa combinada tipo AND(A+B+C)    
         }elseif(strpos($PesquisarX, '+')){
             //echo 'A pesquisa com +'.'<br>';
             $ResultaL = $this->LocalizarAND($TopicoCorrente, $PesquisarX);
                
         // Pesquisa combinada tipo OU(A B C)         
         }elseif(strpos($PesquisarX, ' ')){
              //echo 'A pesquisa com Espa�o'.'<br>';
              $ResultaL = $this->LocalizarOR($TopicoCorrente, $PesquisarX);
                    
         // Pesquisa simples     
         }else{ 
             //echo 'A pesquisa simples'.'<br>';
             $ResultaL = $this->LocalizarSimples($TopicoCorrente, $PesquisarX);
               
          
         }
            
         if(($ResultaL[100][100] > 0)AND(!empty($TopicoCorrente))){
            $this->SalvarPesquisa($TopicoCorrente, $PesquisarX);   // Salva pesquisa na lista
         }

    return ($ResultaL);	            
    
    
}


function LocalizarAND($TopicoCorrente, $PesquisarX)
{	
        // Faz consulta tipo AND(A+B+C)
		$objFuncao = new Funcao();
		$objFuncao->RegistrarLog('Class.MySql.LocalizarAND('.$TopicoCorrente.', '.$PesquisarX.');');
	
    	$ResultaL[][]="";	// Inicializa
		$L = 0;
	                
       
		$link = mysql_connect('localhost', 'root', '');
		mysql_select_db('Rede', $link);
    
                   
                $ItemPesquisa = explode("+", $PesquisarX);
                $NumItens = count($ItemPesquisa);

                if ($NumItens>1){ 


                    /* Consultar combina��o de: A+B */
                    if ($NumItens == 2) {   
                        if($TopicoCorrente <> ""){ 

                            $sql="
                                    select * from comandos where (topico='$TopicoCorrente')
                                    AND(procedimento like '%$ItemPesquisa[0]%' or descricao like '%$ItemPesquisa[0]%' or comando like '%$ItemPesquisa[0]%')
                                    AND(procedimento like '%$ItemPesquisa[1]%' or descricao like '%$ItemPesquisa[1]%' or comando like '%$ItemPesquisa[1]%') 
                                    ORDER BY recentes DESC
                                "; 
                        }else{

                            $sql="
                                    select * from comandos where (procedimento like '%$ItemPesquisa[0]%' or descricao like '%$ItemPesquisa[0]%' or comando like '%$ItemPesquisa[0]%')
                                    AND(procedimento like '%$ItemPesquisa[1]%' or descricao like '%$ItemPesquisa[1]%' or comando like '%$ItemPesquisa[1]%') 
                                    ORDER BY recentes DESC
                                "; 
                        }	
                    }

                    /* Consultar combina��o de: A+B+C */
                    if ($NumItens == 3) {            
                        if($TopicoCorrente <> ""){ 

                            $sql="
                                    select * from comandos where (topico='$TopicoCorrente')
                                    AND(procedimento like '%$ItemPesquisa[0]%' or descricao like '%$ItemPesquisa[0]%' or comando like '%$ItemPesquisa[0]%')
                                    AND(procedimento like '%$ItemPesquisa[1]%' or descricao like '%$ItemPesquisa[1]%' or comando like '%$ItemPesquisa[1]%')
                                    AND(procedimento like '%$ItemPesquisa[2]%' or descricao like '%$ItemPesquisa[2]%' or comando like '%$ItemPesquisa[2]%') 
                                    ORDER BY recentes DESC
                                "; 
                        }else{


                            $sql="
                                    select * from comandos where (procedimento like '%$ItemPesquisa[0]%' or descricao like '%$ItemPesquisa[0]%' or comando like '%$ItemPesquisa[0]%')
                                    AND(procedimento like '%$ItemPesquisa[1]%' or descricao like '%$ItemPesquisa[1]%' or comando like '%$ItemPesquisa[1]%')
                                    AND(procedimento like '%$ItemPesquisa[2]%' or descricao like '%$ItemPesquisa[2]%' or comando like '%$ItemPesquisa[2]%') 
                                    ORDER BY recentes DESC
                                "; 
                        }	
                    }

                }
    
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

        $ResultaL[100][100] = $L;

      //  echo 'Pesquisar por:  '.$PesquisarX.'<br>';
		return ($ResultaL);				
				
}
		

function LocalizarOR($TopicoCorrente, $PesquisarX)
{	
        // faz consulta tipo OR(A B C), separados por espa�os
		$objFuncao = new Funcao();
		$objFuncao->RegistrarLog('Class.MySql.LocalizarOR('.$TopicoCorrente.', '.$PesquisarX.');');
	
    	$ResultaL[][]="";	// Inicializa
		$L = 0;
	                
       
		$link = mysql_connect('localhost', 'root', '');
		mysql_select_db('Rede', $link);
    
        // Caso n�o haja combina��o de itens (+)

		             
                $ItemPesquisa = explode(" ", $PesquisarX);
                $NumItens = count($ItemPesquisa);

                if ($NumItens>1){ 


                    /* Consultar combina��o de: A+B */
                    if ($NumItens == 2) {   
                        if($TopicoCorrente <> ""){ 

                            $sql="
                                    select * from comandos where (topico='$TopicoCorrente')
                                    OR(procedimento like '%$ItemPesquisa[0]%' or descricao like '%$ItemPesquisa[0]%' or comando like '%$ItemPesquisa[0]%')
                                    OR(procedimento like '%$ItemPesquisa[1]%' or descricao like '%$ItemPesquisa[1]%' or comando like '%$ItemPesquisa[1]%') 
                                    ORDER BY recentes DESC
                                "; 
                        }else{

                            $sql="
                                    select * from comandos where (procedimento like '%$ItemPesquisa[0]%' or descricao like '%$ItemPesquisa[0]%' or comando like '%$ItemPesquisa[0]%')
                                    OR(procedimento like '%$ItemPesquisa[1]%' or descricao like '%$ItemPesquisa[1]%' or comando like '%$ItemPesquisa[1]%') 
                                    ORDER BY recentes DESC
                                "; 
                        }	
                    }

                    /* Consultar combina��o de: A+B+C */
                    if ($NumItens == 3) {            
                        if($TopicoCorrente <> ""){ 

                            $sql="
                                    select * from comandos where (topico='$TopicoCorrente')
                                    OR(procedimento like '%$ItemPesquisa[0]%' or descricao like '%$ItemPesquisa[0]%' or comando like '%$ItemPesquisa[0]%')
                                    OR(procedimento like '%$ItemPesquisa[1]%' or descricao like '%$ItemPesquisa[1]%' or comando like '%$ItemPesquisa[1]%')
                                    OR(procedimento like '%$ItemPesquisa[2]%' or descricao like '%$ItemPesquisa[2]%' or comando like '%$ItemPesquisa[2]%') 
                                    ORDER BY recentes DESC
                                "; 
                        }else{


                            $sql="
                                    select * from comandos where (procedimento like '%$ItemPesquisa[0]%' or descricao like '%$ItemPesquisa[0]%' or comando like '%$ItemPesquisa[0]%')
                                    OR(procedimento like '%$ItemPesquisa[1]%' or descricao like '%$ItemPesquisa[1]%' or comando like '%$ItemPesquisa[1]%')
                                    OR(procedimento like '%$ItemPesquisa[2]%' or descricao like '%$ItemPesquisa[2]%' or comando like '%$ItemPesquisa[2]%') 
                                    ORDER BY recentes DESC
                                "; 
                        }	
                    }
                }

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

        $ResultaL[100][100] = $L;
      //  echo 'Pesquisar por:  '.$PesquisarX.'<br>';
		return ($ResultaL);				
				
}


function LocalizarSimples($TopicoCorrente, $PesquisarX)
{	
		
        // Faz uma consulta simples, sem combina��es
        $objFuncao = new Funcao();
		$objFuncao->RegistrarLog('Class.MySql.LocalizarSimples('.$TopicoCorrente.', '.$PesquisarX.');');
	
      // echo'Class.MySql.LocalizarSimples('.$TopicoCorrente.', '.$PesquisarX.');'.'<br>';
	
    
    	$ResultaL[][]="";	// Inicializa
		$L = 0;
	                
       
		$link = mysql_connect('localhost', 'root', '');
		mysql_select_db('Rede', $link);
    
       
		             
            /* Consultar somente A */
            
            if($TopicoCorrente <> ""){ 
                $sql="select * from comandos where (topico='$TopicoCorrente')and(procedimento like '%$PesquisarX%' or descricao like '%$PesquisarX%' or comando like '%$PesquisarX%') ORDER BY recentes DESC"; 
            }else{
              
                $sql="select * from comandos where (procedimento like '%$PesquisarX%' or descricao like '%$PesquisarX%' or comando like '%$PesquisarX%') ORDER BY recentes DESC"; 
            }     


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

        $ResultaL[100][100] = $L;
       //  echo 'Pesquisar por:  '.$PesquisarX.'<br>';
		return ($ResultaL);				
				
}

function SalvarPesquisa($TopicoCorrente, $PesquisaX)
{	
    // Salvar pesquisa na lista
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.SalvarPesquisa('.$TopicoCorrente.', '.$PesquisaX.');');

	$resultado = true;
	if (!$link = mysql_connect('localhost', 'root', '')) {
		$resultado = false;		
		echo 'Erro! N�o foi poss�vel conectar ao mysql[e107e]'.'<br>';
		exit;
	}

	if (!mysql_select_db('Rede', $link)) {
		$resultado = false;	
		echo 'Erro! N�o foi poss�vel selecionar o banco de dados[e107ea]'.'<br>';
		exit;
	}
	
    	// Verifica se pesquisa ja existe no BD
		$consulta = mysql_query("SELECT * FROM pesquisa where topico='$TopicoCorrente' AND lista='$PesquisaX'");
		$conConsulta = mysql_num_rows($consulta);
		
		// Se N�o existe...insere
		if($conConsulta == 0){
	
    
            $sql = "INSERT INTO pesquisa(topico, lista)	VALUE('$TopicoCorrente', '$PesquisaX')";			
            $result = mysql_query($sql, $link);

            if (!$result) {
                $resultado = false;		
                echo "Erro! N�o foi poss�vel salvar o registro o banco de dados[e107c]"."<br>";
                echo 'Erro MySQL: ' . mysql_error().'<br>';
                exit;
            }
	 
        }
        mysql_close($link);
	
	//echo $sql.'<br>'; 
	return $resultado;
		
}
    
function ListarPesquisa($TopicoCorrente)
{
    /* Faz uma consulta a lista de pesquisas no banco 
     * separando pelos t�picos(Dslam HW, Zte, Nec, etc)
     */
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.ListarPesquisa('.$TopicoCorrente.');');
    
    // echo 'Class.MySql.ListarPesquisa('.$TopicoCorrente.')';
	
	$link = mysql_connect('localhost', 'root', '');
	mysql_select_db('Rede', $link);
  
  
    if(empty($TopicoCorrente)){ 
            $sql = "SELECT DISTINCT lista FROM pesquisa ORDER BY registro DESC";  
            //echo 'Topico Vazio'.'<br>';
            $result = mysql_query($sql, $link);
            while ($row = mysql_fetch_assoc($result)) {	               
                $ListaX[] = $row['lista'];     
            }
    }else{ 
           $sql = "SELECT DISTINCT registro, topico, lista FROM pesquisa WHERE topico='$TopicoCorrente' ORDER BY registro DESC";  
            //echo 'Topico presente'.'<br>';
            $result = mysql_query($sql, $link);
            while ($row = mysql_fetch_assoc($result)) {	
                $RegX[] = $row['registro'];
                $ListaX[] = $row['lista'];     
            }
     }
    
    //echo $sql.'<br>';
    //$sql = "SELECT DISTINCT registro, topico, lista FROM pesquisa ORDER BY registro DESC";
  
	   
      
	mysql_free_result($result);	
	
    /* Se Topico != geral...
     * Deleta registros excedentes(por topico) da lista total 
     * Como esta listado em ordem decrecente e por t�pico, 
     * $RegX[0] � o �ltimo registro da lista
     */
     if(!empty($TopicoCorrente)){   
         $this->DeletarExcedentes($TopicoCorrente, $RegX[0], 30);    
     }
	return($ListaX);
}

function DeletarExcedentes($TopicoCorrente, $UltimoReg, $MaxReg){
    /* Rotina mantem max 30 registros no banco, 
     * deleta registros menos recentes(<30) 
     */
    $Limite = $UltimoReg - $MaxReg;    // Com a lista esta em ordem decrescente, o ultimo reg � o reg[0]
     
    $objFuncao = new Funcao();
    $objFuncao->RegistrarLog('Class.MySql.DeletarExcedentes('.$TopicoCorrente.', '.$UltimoReg.', '.$MaxReg.');');
	
    if(!empty($TopicoCorrente)){
		$link = mysql_connect('localhost', 'root', '');
		mysql_select_db('Rede', $link);
	    $sql = "DELETE FROM pesquisa WHERE topico='$TopicoCorrente' AND registro<'$Limite'";			
		$result = mysql_query($sql, $link);
		mysql_free_result($result);	
    }
   
}    
    
function QueryItemAttribAtual($Item,$RegItemCur)
{
		
		$objFuncao = new Funcao();
		$objFuncao->RegistrarLog('Class.MySql.QueryItemAttribAtual('.$Item.');');
	
		$ItemCorrente = "";
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
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.PegarItemTopico('.$Assunto.');');
	
	
	$T=0;
	$link = mysql_connect('localhost', 'root', '');
	mysql_select_db('Rede', $link);
	$sql = "SELECT DISTINCT topico FROM comandos WHERE assunto='$Assunto' ORDER BY topico";
	$result = mysql_query($sql, $link);
	while ($row = mysql_fetch_assoc($result)) {	
		$Item[$T][1]=$row['topico']; 
		$Item[$T][0]=$this->PegarRegistro($Item[$T][1]); 	// Usa funcao p/ pegar Reg a fim de possibilitar consulta mysql de topicos Distintos(Se n�o h� muita repeti��o)
		$T++;
	}
	mysql_free_result($result);					
	
		
	return($Item);
}

function ListarCampo($Campo)
{
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.ListaCampo('.$Campo.');');
	
	//$T=0;
	$link = mysql_connect('localhost', 'root', '');
	mysql_select_db('Rede', $link);
	$sql = "SELECT DISTINCT assunto FROM comandos ORDER BY assunto";
	$result = mysql_query($sql, $link);
	while ($row = mysql_fetch_assoc($result)) {	
		$Item[]=$row['assunto']; 
		
	}
	mysql_free_result($result);					
	
		
	return($Item);
}

function PegarRegistro($ItemTopico)
{
	
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.PegarRegistro('.$ItemTopico.');');

	// Fun��o auxiliar de: PegarItemTopico()
	// Pega Registro associado a cada item, p/ transferir de p�gina
	
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
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.CltComando('.$Registro.');');

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
			$Resulta[6] = $row['data'];			
			
		}
		mysql_free_result($result);
		
		return $Resulta;
		
}

function CltAttribAtualizacao()
{
	// Retorna data da ultima AttribAtualiza��o	
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.CltAttribAtualizacao();');

	$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
	if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection

		$sql = "SELECT max(registro) FROM comandos"; 		
		$result = mysqli_query($cnxMysql, $sql);		
		while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr	
			$Reg[] = $row['max(registro)']; 
		}		
		$cnxMysql->close();		// Fecha conexao($cnxMySql)
		
		return $Reg;
		
}

function ListarCmdFull($Eqpto)
{	
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.ListarCmdFull();');
		//echo "Eqpto = ".$Eqpto."<BR>";
		
		$Resulta[][]="";
		$P = 0;
		
		$link = mysql_connect('localhost', 'root', '');
		mysql_select_db('Rede', $link);
		if($Eqpto=='Null'){ $sql = "SELECT * FROM comandos"; }
		else{ $sql = "SELECT * FROM comandos WHERE topico LIKE '%$Eqpto%'"; }		
		$result = mysql_query($sql, $link);
		while ($row = mysql_fetch_assoc($result)) 
		{	
			$Resulta[0][$P] = $row['registro'];
			$Resulta[1][$P] = $row['assunto']; 
			$Resulta[2][$P] = $row['topico']; 
			$Resulta[3][$P] = $row['procedimento']; 
			$Resulta[4][$P] = $row['descricao']; 
			$Resulta[5][$P] = $row['comando']; 
			$Resulta[6][$P] = $row['endereco']; 
			$P++;
			
		}
		mysql_free_result($result);
		
		$Resulta[100][100] = $P;
		
		return $Resulta;
		
}


function ListarCmd($Registro)
{	
	
		$objFuncao = new Funcao();
		$objFuncao->RegistrarLog('Class.MySql.ListaCmd('.$Registro.');');
	
		$Resulta[][]="";
		$P = 0;
		$link = mysql_connect('localhost', 'root', '');
		mysql_select_db('Rede', $link);
		
		if($Registro != Null){ $sql = "SELECT * FROM comandos WHERE registro='$Registro'"; }
		else{ $sql = "SELECT * FROM comandos";	}
		$result = mysql_query($sql, $link);
		while ($row = mysql_fetch_assoc($result)) 
		{	
			$Resulta[0][$P] = $row['registro'];
			$Resulta[1][$P] = $row['assunto']; 
			$Resulta[2][$P] = $row['topico']; 
			$Resulta[3][$P] = $row['procedimento']; 
			$Resulta[4][$P] = $row['descricao']; 
			$Resulta[5][$P] = $row['comando']; 
			$Resulta[6][$P] = $row['endereco']; 
			$P++;
			 
		}
		mysql_free_result($result);
		
		$Resulta[100][100] = $P;
		
		return $Resulta;
		
}

function QueryTopico($TopicoX)
{	
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.QueryTopico('.$TopicoX.');');

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
			$Resulta[$P][8] = $row['data']; 

			$P++;			 
		}
		
	$Resulta[100][100] = $P;
		mysql_free_result($result);
		
		return $Resulta;
		
}




function SalveEditar($Registro, $Assunto, $Topico, $Indice, $Descricao, $Comando)
{	
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.SalveEditar('.$Registro.');');

	$resultado = true;
	if (!$link = mysql_connect('localhost', 'root', '')) {
		$resultado = false;		
		echo 'Erro! N�o foi poss�vel conectar ao mysql[e101a]'.'<br>';
		exit;
	}

	if (!mysql_select_db('Rede', $link)) {
		$resultado = false;	
		echo 'Erro! N�o foi poss�vel selecionar o banco de dados[e101b]'.'<br>';
		exit;
	}
	$Data = date("d/m/Y");
	$Cmd = $Comando.", ed[".$Data."]"; 
	
	$sql = "UPDATE comandos SET assunto='$Assunto', topico='$Topico', procedimento='$Indice', descricao='$Descricao', comando='$Comando' WHERE registro='$Registro'";			
	$result = mysql_query($sql, $link);

	if (!$result) {
		$resultado = false;		
		echo "Erro! N�o foi poss�vel salvar o registro o banco de dados[e101c]"."<br>";
		echo 'Erro MySQL: ' . mysql_error().'<br>';
		exit;
	}
	 mysql_close($link);
	
	return $resultado;
		
}

function SalvarEtqta($Ccto, $De, $Para, $Obs, $Impressao)
{	
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.SalvarEtqta('.$Ccto.','.$De.','.$Para.','.$Obs.');');

	$resultado = true;
	if (!$link = mysql_connect('localhost', 'root', '')) {
		$resultado = false;		
		echo 'Erro! N�o foi poss�vel conectar ao mysql[e101e]'.'<br>';
		exit;
	}

	if (!mysql_select_db('Rede', $link)) {
		$resultado = false;	
		echo 'Erro! N�o foi poss�vel selecionar o banco de dados[e101ea]'.'<br>';
		exit;
	}
	$Data = date("d/m/Y");
	
	$sql = "UPDATE etqtas SET ccto='$Ccto', de='$De', para='$Para', obs='$Obs', data='$Data', impresso='$Impressao' WHERE registro='$Registro'";			
	$sql = "INSERT INTO etqtas(ccto, de, para, obs, data, impresso)	VALUE('$Ccto', '$De', '$Para', '$Obs', '$Data', '$Impressao')";			
	$result = mysql_query($sql, $link);

	if (!$result) {
		$resultado = false;		
		echo "Erro! N�o foi poss�vel salvar o registro o banco de dados[e101c]"."<br>";
		echo 'Erro MySQL: ' . mysql_error().'<br>';
		exit;
	}
	 mysql_close($link);
	
	//echo $sql.'<br>'; 
	return $resultado;
		
}

function ConsultarEtqta($Registro, $Impressao)
{	
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.ConsultarEtqta('.$Registro.');');

	if($Impressao == "Impressos"){ $Tipo = "Sim"; }
	else{ $Tipo = "N�o"; }
			
			
		$P = 0;		
		$link = mysql_connect('localhost', 'root', '');
		mysql_select_db('Rede', $link);
		if($Registro>0){ $sql = "SELECT * FROM etqtas WHERE Registro='$Registro' ORDER BY Registro ASC"; }
		else{ $sql = "SELECT * FROM etqtas WHERE impresso='$Tipo' ORDER BY Registro ASC";			}
		$result = mysql_query($sql, $link);
		while ($row = mysql_fetch_assoc($result)) 
		{	
			$Resulta[$P][0] = $row['Registro'];
			$Resulta[$P][1] = $row['ccto']; 
			$Resulta[$P][2] = $row['de']; 
			$Resulta[$P][3] = $row['para']; 
			$Resulta[$P][4] = $row['data']; 
			$Resulta[$P][5] = $row['obs'];
			$Resulta[$P][6] = $row['impresso'];			

			$P++;			 
		}
		
		$Resulta[100][100] = $P;
		mysql_free_result($result);
		
		// echo $sql.'<br>';
		
		return $Resulta;
		
}

function ListarEtqta($RegIni, $RegFim, $Impressao)
{	
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.ConsultarEtqta('.$RegIni.', '.$RegFim.');');

	if($Impressao == "Impressos"){ $Tipo = "Sim"; }
	else{ $Tipo = "N�o"; }

	
		$P = 0;		
		$link = mysql_connect('localhost', 'root', '');
		mysql_select_db('Rede', $link);
		$sql = "SELECT * FROM etqtas WHERE Registro>='$RegIni' AND Registro<='$RegFim' AND impresso='$Tipo' ORDER BY Registro ASC"; 
		
		$result = mysql_query($sql, $link);
		while ($row = mysql_fetch_assoc($result)) 
		{	
			$Resulta[$P][0] = $row['Registro'];
			$Resulta[$P][1] = $row['ccto']; 
			$Resulta[$P][2] = $row['de']; 
			$Resulta[$P][3] = $row['para']; 
			$Resulta[$P][4] = $row['data']; 
			$Resulta[$P][5] = $row['obs']; 

			$P++;			 
		}
		
		$Resulta[100][100] = $P;
		mysql_free_result($result);
		
		return $Resulta;
		
}

function InformarImpressao($De, $Ate)
{	
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.InformarImpressao('.$De.','.$Ate.');');

	$resultado = true;
	if (!$link = mysql_connect('localhost', 'root', '')) {
		$resultado = false;		
		echo 'Erro! N�o foi poss�vel conectar ao mysql[e101e]'.'<br>';
		exit;
	}

	if (!mysql_select_db('Rede', $link)) {
		$resultado = false;	
		echo 'Erro! N�o foi poss�vel selecionar o banco de dados[e101ea]'.'<br>';
		exit;
	}
	$Data = date("d/m/Y");

	
	$sql = "UPDATE etqtas SET impresso='Sim' WHERE Registro>='$De' AND Registro<='$Ate'";			
	$result = mysql_query($sql, $link);

	if (!$result) {
		$resultado = false;		
		echo "Erro! N�o foi poss�vel salvar o registro o banco de dados[e101c]"."<br>";
		echo 'Erro MySQL: ' . mysql_error().'<br>';
		exit;
	}
	 mysql_close($link);
	
	return $resultado;
		
}

function AttribAtualizarEtqta($Registro, $Ccto, $De, $Para, $Obs, $Impresso)
{	
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.AttribAtualizarEtqta('.$Registro.','.$Ccto.','.$De.','.$Para.','.$Obs.');');

	$resultado = true;
	if (!$link = mysql_connect('localhost', 'root', '')) {
		$resultado = false;		
		echo 'Erro! N�o foi poss�vel conectar ao mysql[e101e]'.'<br>';
		exit;
	}

	if (!mysql_select_db('Rede', $link)) {
		$resultado = false;	
		echo 'Erro! N�o foi poss�vel selecionar o banco de dados[e101ea]'.'<br>';
		exit;
	}
	$Data = date("d/m/Y");

	
	$sql = "UPDATE etqtas SET ccto='$Ccto', de='$De', para='$Para', obs='$Obs', data='$Data', impresso='$Impresso' WHERE Registro='$Registro'";			
	$result = mysql_query($sql, $link);

	if (!$result) {
		$resultado = false;		
		echo "Erro! N�o foi poss�vel salvar o registro o banco de dados[e101c]"."<br>";
		echo 'Erro MySQL: ' . mysql_error().'<br>';
		exit;
	}
	 mysql_close($link);
	
	return $resultado;
		
}

function DeletarEtqta($Registro)
{	
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.DeletarEtqta('.$Registro.');');

	$resultado = true;
	if (!$link = mysql_connect('localhost', 'root', '')) {
		$resultado = false;		
		echo 'Erro! N�o foi poss�vel conectar ao mysql[e101e]'.'<br>';
		exit;
	}

	if (!mysql_select_db('Rede', $link)) {
		$resultado = false;	
		echo 'Erro! N�o foi poss�vel selecionar o banco de dados[e101ea]'.'<br>';
		exit;
	}
		
	$sql = "DELETE FROM etqtas WHERE Registro='$Registro'";			
	$result = mysql_query($sql, $link);
    mysql_close($link);
	
	return $resultado;
		
}


function Recentes($Registro, $Acao)
{
	/*
	 * Guarda ultimos registros consultados, mais recentes;
	 * Gera um c�digo(double): 
	 * yy/mm/dd hh:mm <num.registro>
	 * 170320.0951321
	 * 
     */	 
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.Recentes('.$Registro.');');

	/* Registra data do acesso */
	
	$Data = date('ymd');
	$Min = date('hi');	
	$FloatMin = $Min/10000;
	$FloatReg = $Registro/10000000;
	$DataReg = $Data + $FloatMin +$FloatReg;	// Soma Data, Hora com registro para filtrar (Registros recentes - filtro trata como um empilhamento, os mais recentes em cima)
	//$objFuncao->RegistrarLog('Class.MySql.Recentes('.$Registro.')-> '.$FloatMin.' -> '.$FloatReg.'->'.$DataReg.';');
	
	
	$resultado = true;
	if (!$link = mysql_connect('localhost', 'root', '')) {
		$resultado = false;		// echo '1 - N�o foi poss�vel conectar ao mysql';
		exit;
	}

	if (!mysql_select_db('Rede', $link)) {
		$resultado = false;	// echo '2 - N�o foi poss�vel selecionar o banco de dados';
		exit;
	}
	
	if($Acao=="Clear"){ $sql = "UPDATE comandos SET recentes='$Registro' WHERE registro>0"; }	// Limpa recentes
	else{ $sql = "UPDATE comandos SET recentes='$DataReg' WHERE registro='$Registro'"; }	// Registra acesso
	$result = mysql_query($sql, $link);

	if (!$result) {
		$resultado = false;		// echo "3 - Erro do banco de dados, n�o foi poss�vel consultar o banco de dados\n";
								// echo '4 - Erro MySQL: ' . mysql_error();
		
		$objFuncao->RegistrarLog('Class.MySql.Recentes('.$Registro.')-> Falhou! '.$Agora.' -> '.$DataReg.';');
		exit;
	}else{		
		//$objFuncao->RegistrarLog('Class.MySql.Recentes('.$Registro.')-> Sucesso! '.$FloatHora.' -> '.$DataReg.';');
	}
	 mysql_close($link);
	
	if($Acao=="Clear"){ $resultado = "Historico de recentes exclu�do com sucesso!"; }
	
	return $resultado;
		
}

function SalveAdicionar($Assunto, $Topico, $Indice, $Descricao, $Comando)
{	
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.SalveAdicionar('.$Assunto.');');

	
	$resultado = true;
	if (!$link = mysql_connect('localhost', 'root', '')) {
		$resultado = false;		// echo '1 - N�o foi poss�vel conectar ao mysql';
		exit;
	}

	if (!mysql_select_db('Rede', $link)) {
		$resultado = false;	// echo '2 - N�o foi poss�vel selecionar o banco de dados';
		exit;
	}
	$Data = "Ad[".date("d/m/Y")."]";
	$sql = "INSERT INTO comandos(assunto, topico, procedimento, descricao, comando, data)	VALUE('$Assunto', '$Topico', '$Indice', '$Descricao', '$Comando', '$Data')";			

	$result = mysql_query($sql, $link);

	if (!$result) {
		$resultado = false;		// echo "3 - Erro do banco de dados, n�o foi poss�vel consultar o banco de dados\n";
								// echo '4 - Erro MySQL: ' . mysql_error();
		exit;
	}
	 mysql_close($link);
	
	return $resultado;
		
}

function Excluir($Registro)
{	
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.Excluir('.$Registro.');');

	$resultado = true;
	if (!$link = mysql_connect('localhost', 'root', '')) {
		$resultado = false;		// echo '1 - N�o foi poss�vel conectar ao mysql';
		exit;
	}

	if (!mysql_select_db('Rede', $link)) {
		$resultado = false;	// echo '2 - N�o foi poss�vel selecionar o banco de dados';
		exit;
	}

	$sql = "DELETE FROM comandos WHERE registro='$Registro'";			
	$result = mysql_query($sql, $link);

	if (!$result) {
		$resultado = false;		// echo "3 - Erro do banco de dados, n�o foi poss�vel consultar o banco de dados\n";
								// echo '4 - Erro MySQL: ' . mysql_error();
		exit;
	}
	 mysql_close($link);
	
	return $resultado;
		
}


	function GerarCSV($Dir, $Tabela, $Eqpto){
	
	
		$objFuncao = new Funcao();
		$objFuncao->RegistrarLog('Class.MySql.GerarCSV('.$Dir.', '.$Tabela.');');
		
		$Divisa='--------------------------------------------------------------------------------------------';
		$Titulo = array('Reg: ', 'Ass: ', 'T�p: ', 'Proc: ', 'Desc: ');
	
		$RegX[] = "";
		//if($Eqpto=='Completo'){ $Eqpto = Null; }	// Mudei pra dar mais seguran�a				
		$RegX = $this->ListarCmdFull($Eqpto); 	
		
		/*
		 * Formata local e nome do arq.csv
		 * Abre ou cria o arquivo
		 * "a" representa que o arquivo � aberto para ser escrito
		 */
		$hoje = date("dFY"); 
		if($Eqpto=='Null'){ $arquivo = $Dir."BakCmd_".$hoje."_full.csv"; }
		else{ $arquivo = $Dir."BakCmd_".$hoje."_".$Eqpto.".csv"; }
		
		//$objFuncao->RegistrarLog('Class.MySql.GerarCSV('.$arquivo.')');
		$fp = fopen($arquivo, "a");	
		/*
			$Resulta[0][$P] = $row['registro'];
			$Resulta[1][$P] = $row['assunto']; 
			$Resulta[2][$P] = $row['topico']; 
			$Resulta[3][$P] = $row['procedimento']; 
			$Resulta[4][$P] = $row['descricao']; 
			$Resulta[5][$P] = $row['comando']; 
			$Resulta[6][$P] = $row['endereco']; 
		*/
		
		for($C = 0; $C < $RegX[100][100]; $C++){
			for($L = 0; $L <= 6; $L++){
			
				$linha = $RegX[$L][$C].";";			// Formata linha
				
				if($Eqpto=='Null'){					// Null=Backup completo 
					$escreve = fwrite($fp, "\n".$linha); 	
				}else{								// !=Null, cria Arq.csv separado por Dslam
					if($L==0){
						$escreve = fwrite($fp, $Divisa."\n"); 	// Escreve no arq.csv	
						for($Lx = 0; $Lx < 5; $Lx++){
							$escreve = fwrite($fp, $Titulo[$Lx].$RegX[$Lx][$C]."\n"); 	// Escreve no arq.csv
						}
					}
					if($L>4){
						$escreve = fwrite($fp, "\n".$linha); 	// Escreve no arq.csv
					}
				}
				
						
				
				
			}
			$escreve = fwrite($fp, "\n");	//pula uma linha
		}
		// Fecha o arquivo
		fclose($fp);
		
		return (true);	
	}
	
	function DeletarArq($Arquivo){
	
	
		$objFuncao = new Funcao();
		$objFuncao->RegistrarLog('Class.MySql.DeletarArq('.$Arquivo.');');
		
		if(unlink($Arquivo)){ return(true); }else{ return(false);  }
	}
	
	function RestaureDados($tabela, $arquivo, $tipo){
		/*
		 * Deleta dados atuais(se substitiuir), e carrega tabela com arquivo.csv
		 */
		$objFuncao = new Funcao();
		$objFuncao->RegistrarLog('Class.livro.RestaureDados('.$tabela.', '.$arquivo.','.$tipo.');');
		
		
		if($tipo == defSUBSTITUIR){ 
		
			if($this->LimparTabela($tabela)){
				$sql = mysql_query("LOAD DATA INFILE '$arquivo' INTO TABLE $tabela FIELDS TERMINATED BY ';';"); 
					if($sql){									
						$Retorno = "Tabela: $tabela carregada com sucesso! <br>";																	
					}else{
						$Retorno = "Erro!  Falha de conex�o com MySql, arquivo n�o p�de ser carregado. [e401a]";
					}
			}else{
				$Retorno = "Erro!  Falha de conex�o com MySql, carga cancelada. [e401b]";
				
			}
			
		}else{
			//echo "LOAD DATA INFILE '$arquivo' INTO TABLE $tabela FIELDS TERMINATED BY ';'"."<br>";
			
			$sql = mysql_query("LOAD DATA INFILE '$arquivo' INTO TABLE $tabela FIELDS TERMINATED BY ';'"); 
				if($sql){									
					$Retorno = "Tabela: $tabela carregada com sucesso! <br>";																	
				}else{
					$Retorno = "Erro!  Falha de conex�o com MySql, arquivo n�o p�de ser carregado. [e401c]";
				}
		}

		
		
		return($Retorno);
	}
	
	
	function LimparTabela($Tabela){
		
		/* Limpa dados da tabela */
		
		$objFuncao = new Funcao();
		$objFuncao->RegistrarLog('Class.MySql.LimparTabela('.$Tabela.');');
		
					
					$sql = mysql_query("DELETE FROM $Tabela WHERE registro>0");
					if($sql){									
						echo "Todos os dados da tabela: $Tabela foram exclu�dos! <br>";											
						$Retorno = true;
					}else{
						$Retorno = false;
						echo "Erro!  Falha de conex�o com MySql, registros n�o exclu�dos. [e301a]";
					}
			
						
		
		return($Retorno);
		
	}
	


} /* end Class */

?>
