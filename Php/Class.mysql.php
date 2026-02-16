
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
		$RegX[]="";
	
		$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
		if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection
		if($AssuntoX=='Full'){	$sql="SELECT registro FROM comandos"; }
		else{ $sql="SELECT registro FROM comandos where assunto='$AssuntoX'"; }
		$result = mysqli_query($cnxMysql, $sql);		
		while ($res = mysqli_fetch_assoc($result)) {  // fetch associative arr 
			
			$RegX[] = $res['registro'];
		}
		$cnxMysql->close();		// Fecha conexao($cnxMySql)			
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

		 
		 //var_dump($ResultaL);
		 return ($ResultaL);	            
    
    
}


function LocalizarAND($TopicoCorrente, $PesquisarX)
{	
        // Faz consulta tipo AND(A+B+C)
		$objFuncao = new Funcao();
		$objFuncao->RegistrarLog('Class.MySql.LocalizarAND('.$TopicoCorrente.', '.$PesquisarX.');');
	
    	$ResultaL[][]="";	// Inicializa
		$L = 0;
	                
       
		$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
		if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection

    
                   
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
    
		$result = mysqli_query($cnxMysql, $sql);		
		while ($row = mysqli_fetch_assoc($result))   // fetch associative arr
		{	
			$ResultaL[$L][0] = $row['registro']; 
			$ResultaL[$L][1] = $row['topico']; 
			$ResultaL[$L][2] = $row['procedimento']; 
			$ResultaL[$L][3] = $row['descricao']; 
			$ResultaL[$L][4] = $row['comando']; 
			$ResultaL[$L][5] = $row['endereco']; 
			$L++;
		}
		$cnxMysql->close();		// Fecha conexao($cnxMySql)

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
	                
       
		$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
		if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection

    
        // Caso Nao haja combina��o de itens (+)

		             
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

		$result = mysqli_query($cnxMysql, $sql);		
		while ($row = mysqli_fetch_assoc($result))   // fetch associative arr	 
		{	
			$ResultaL[$L][0] = $row['registro']; 
			$ResultaL[$L][1] = $row['topico']; 
			$ResultaL[$L][2] = $row['procedimento']; 
			$ResultaL[$L][3] = $row['descricao']; 
			$ResultaL[$L][4] = $row['comando']; 
			$ResultaL[$L][5] = $row['endereco']; 
			$L++;
		}
		$cnxMysql->close();		// Fecha conexao($cnxMySql)

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
	                
       
		$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
		if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection
		             
            /* Consultar somente A */
            
            if($TopicoCorrente <> ""){ 
                $sql="select * from comandos where (topico='$TopicoCorrente')and(procedimento like '%$PesquisarX%' or descricao like '%$PesquisarX%' or comando like '%$PesquisarX%') ORDER BY recentes DESC"; 
            }else{              
                $sql="select * from comandos where (procedimento like '%$PesquisarX%' or descricao like '%$PesquisarX%' or comando like '%$PesquisarX%') ORDER BY recentes DESC"; 
            }     


		$result = mysqli_query($cnxMysql, $sql);		
		while ($row = mysqli_fetch_assoc($result))   // fetch associative arr 
		{	
			$ResultaL[$L][0] = $row['registro']; 
			$ResultaL[$L][1] = $row['topico']; 
			$ResultaL[$L][2] = $row['procedimento']; 
			$ResultaL[$L][3] = $row['descricao']; 
			$ResultaL[$L][4] = $row['comando']; 
			$ResultaL[$L][5] = $row['endereco']; 
			$L++;
		}
		$cnxMysql->close();		// Fecha conexao($cnxMySql)

        $ResultaL[100][100] = $L;
       //  echo 'Pesquisar por:  '.$PesquisarX.'<br>';
		return ($ResultaL);				
				
}

function CheckPesquisaExiste($TopicoCorrente, $PesquisaX){
	// Verifica se registro ja existe		
	$objFuncao = new Funcao();
	
	$cnxMySql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
	if (!$cnxMySql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection
		
	// Verifica se registro existe					
	$sql = "SELECT * FROM pesquisa where topico='$TopicoCorrente' AND lista='$PesquisaX'";
		
	$result = mysqli_query($cnxMySql, $sql);		
	if(mysqli_fetch_assoc($result)){  
		$objFuncao->RegistrarLog('Class.mysql.CheckPesquisaExiste('.$TopicoCorrente.','.$PesquisaX.'); -> True');
		$cnxMySql->close();		// Fecha conexao($cnxMySql)	
		return true; 
	}else{ 
		$objFuncao->RegistrarLog('Class.announ.CheckPesquisaExiste('.$TopicoCorrente.','.$PesquisaX.'); -> False');
		$cnxMySql->close();		// Fecha conexao($cnxMySql)	
		return false;	
	}	
		

}

function SalvarPesquisa($TopicoCorrente, $PesquisaX)
{	
    // Salvar pesquisa na lista
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.SalvarPesquisa('.$TopicoCorrente.', '.$PesquisaX.');');

	$resultado = true;
	
	$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
	if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection
	
    	// Verifica se pesquisa ja existe no BD	
		// Se Nao existe...insere
		if(!$this->CheckPesquisaExiste($TopicoCorrente, $PesquisaX)){	
    
            $sql = "INSERT INTO pesquisa(topico, lista)	VALUE('$TopicoCorrente', '$PesquisaX')";			
            if (mysqli_query($cnxMySql, $sql)) { 
				$cnxMySql->close();		// Fecha conexao($cnxMySql)
				return true; 
			}else{ 
				$cnxMySql->close();		// Fecha conexao($cnxMySql)
				return false; 
			}
		 
        }
		
}
    
function ListarPesquisa($TopicoCorrente)
{
    /* Faz uma consulta a lista de pesquisas no banco 
     * separando pelos t�picos(Dslam HW, Zte, Nec, etc)
     */
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.ListarPesquisa('.$TopicoCorrente.');');
    $ListaX[] = "";
	$RegX[]=0;

	$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
	if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection

  
    if(empty($TopicoCorrente)){ 
            $sql = "SELECT DISTINCT lista FROM pesquisa ORDER BY registro DESC";                
			$result = mysqli_query($cnxMysql, $sql);		
			while ($row = mysqli_fetch_assoc($result)) {  // fetch associative array             
                $ListaX[] = $row['lista'];     
            }
			$objFuncao->RegistrarLog('Class.MySql.ListarPesquisa('.$TopicoCorrente.')->empty;');
    }else{ 
           $sql = "SELECT DISTINCT registro, topico, lista FROM pesquisa WHERE topico='$TopicoCorrente' ORDER BY registro DESC";              
            $result = mysqli_query($cnxMysql, $sql);		
			while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr
                $RegX[] = $row['registro'];
                $ListaX[] = $row['lista'];     
            }
			$objFuncao->RegistrarLog('Class.MySql.ListarPesquisa(SELECT DISTINCT registro, topico, lista FROM pesquisa WHERE topico='.$TopicoCorrente.' ORDER BY registro DESC');
     }

	$cnxMysql->close();		// Fecha conexao($cnxMySql)	   
      

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
	
		$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
		if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection
	
		$sql = "DELETE FROM pesquisa WHERE topico='$TopicoCorrente' AND registro<'$Limite'";
		if(mysqli_query($cnxMysql, $sql)){ 
			$cnxMysql->close();	// fecha conexao com BD
			return true; 
		}else{ 
			$cnxMysql->close();	// fecha conexao com BD
			return false; 
		}					
		
    }
   
}    
    
function QueryItemAttribAtual($Item,$RegItemCur)
{
		
		$objFuncao = new Funcao();
		$objFuncao->RegistrarLog('Class.MySql.QueryItemAttribAtual('.$Item.','.$RegItemCur.');');
	
		$ItemCorrente = "";
		// Retorna Assunto / Topico em uso
	
		$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
		if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection
	
		$sql = "SELECT $Item FROM comandos where registro='$RegItemCur'";
		$result = mysqli_query($cnxMysql, $sql);		
		while ($res = mysqli_fetch_assoc($result)) {  // fetch associative arr
			if($Item == 'assunto'){ $ItemCorrente=$res['assunto']; 	}
			if($Item == 'topico'){ $ItemCorrente=$res['topico']; 	}     
		}
		$cnxMysql->close();		// Fecha conexao($cnxMySql)
		
		return ($ItemCorrente);	
		
}

// DELETE FROM `Rede`.`comandos` WHERE (`registro` LIKE '%teste3%' OR `eqpto` LIKE '%teste3%' OR `procedimento` LIKE '%teste3%' OR `tipo` LIKE '%teste3%' OR `status` LIKE '%teste3%' OR `endereco` LIKE '%teste3%' OR `comando` LIKE '%teste3%' OR `descricao` LIKE '%teste3%' OR `obs` LIKE '%teste3%')

function PegarItemTopico($Assunto)
{
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.PegarItemTopico('.$Assunto.');');
	
	$Item[][]="";
	$T=0;
	$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
	if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection

	$sql = "SELECT DISTINCT topico FROM comandos WHERE assunto='$Assunto' ORDER BY topico";
	$result = mysqli_query($cnxMysql, $sql);		
	while ($res = mysqli_fetch_assoc($result)) {  // fetch associative arr		
		$Item[$T][1]=$res['topico']; 
		$Item[$T][0]=$this->PegarRegistro($Item[$T][1]); 	// Usa funcao p/ pegar Reg a fim de possibilitar consulta mysql de topicos Distintos(Se Nao h� muita repeti��o)
		$T++;
	}
	$cnxMysql->close();		// Fecha conexao($cnxMySql)
		
	return($Item);
}

function ListarTopico($AssuntoX)
{
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.ListaTopico('.$AssuntoX.');');
	
	$Item[]="";
	$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
	if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection
	
	$sql = "SELECT DISTINCT topico FROM comandos WHERE assunto='$AssuntoX' ORDER BY topico"; 
	
	$result = mysqli_query($cnxMysql, $sql);		
	while ($row = mysqli_fetch_assoc($result)) {  // fetch associative ar			
		$Item[]=$row['topico']; 		
	}
	$cnxMysql->close();		// Fecha conexao($cnxMySql)					
			
	return($Item);
}


function ListarCampo($Campo)
{
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.ListaCampo('.$Campo.');');
	
	//$T=0;
	$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
	if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection

	$sql = "SELECT DISTINCT assunto FROM comandos ORDER BY assunto"; 	
	$result = mysqli_query($cnxMysql, $sql);		
	while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr	
		$Item[]=$row['assunto'];		
		
	}
	$cnxMysql->close();		// Fecha conexao($cnxMySql)					
	
		
	return($Item);
}
function PegarRegistro($ItemTopico)
{
	
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.PegarRegistro('.$ItemTopico.');');

	$Reg[]="";
	// Fun��o auxiliar de: PegarItemTopico()
	// Pega Registro associado a cada item, p/ transferir de p�gina
	
	$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
	if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection

	$sql = "SELECT registro FROM comandos WHERE topico='$ItemTopico'";
	$result = mysqli_query($cnxMysql, $sql);		
	while ($res = mysqli_fetch_assoc($result)) {  // fetch associative arr
		$Reg[]=$res['registro']; 
	}
	$cnxMysql->close();		// Fecha conexao($cnxMySql)

	return ($Reg[0]);	
}

 

function CltComando($Registro)
{	
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.CltComando('.$Registro.');');

	$Resulta[]="";
	
	$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
	if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection
	
		if($Registro > 1){ $sql = "SELECT * FROM comandos WHERE registro='$Registro'"; }
		else{ $sql = "SELECT * FROM comandos";	}
		$result = mysqli_query($cnxMysql, $sql);		
		while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr		
			$Resulta[0] = $row['assunto']; 
			$Resulta[1] = $row['topico']; 
			$Resulta[2] = $row['procedimento']; 
			$Resulta[3] = $row['descricao']; 
			$Resulta[4] = $row['comando']; 
			$Resulta[5] = $row['endereco'];
			$Resulta[6] = $row['data'];			
			$Resulta[10] = $row['registro'];	
			
		}
		$cnxMysql->close();		// Fecha conexao($cnxMySql)
		
		return $Resulta;
		
}

function CltAttribAtualizacao()
{
	// Retorna data da ultima AttribAtualiza��o	
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.CltAttribAtualizacao();');
	/*
		$link = mysql_connect('localhost', 'root', '');
		mysql_select_db('Rede', $link);
		$sql = "SELECT max(registro) FROM comandos"; 		
		$result = mysql_query($sql, $link);		
		while ($row = mysql_fetch_assoc($result)){ $Reg[] = $row['max(registro)']; }		
		mysql_free_result($result);
	*/
	$Reg = 1;	
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
		else{ $sql = "SELECT * FROM comandos WHERE topico LIKE '%$Eqpto%' ORDER BY procedimento"; }		
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

function AjustaProcedimento()
{	
	// Usado para corrigir/tirar espa�o antes do campo procedimento
	// DE: _Registro..., P/: Registro...
	
		$P = 0;		
		$link = mysql_connect('localhost', 'root', '');
		mysql_select_db('Rede', $link);
		$sql = "SELECT Registro, procedimento FROM comandos"; 
		
		$result = mysql_query($sql, $link);
		while ($row = mysql_fetch_assoc($result)) 
		{	
			$Reg[$P] = $row['Registro'];
			$Proc[$P] = $row['procedimento']; 
			
			
			$P++;
			
		}
				
		mysql_free_result($result);
		
		
		// Ajusta procedimento
		for($J=0; $J<$P; $J++){
			
			$PegaPrim[$J] = substr($Proc[$J], 0, 1);
			$PegaResto[$J] = substr($Proc[$J], 1, 50);
			if($PegaPrim[$J]==" "){

					$resultado = true;
					if (!$link = mysql_connect('localhost', 'root', '')) {
						$resultado = false;		
						echo 'Erro! Nao foi possivel conectar ao mysql[e101a]'.'<br>';
						exit;
					}

					if (!mysql_select_db('Rede', $link)) {
						$resultado = false;	
						echo 'Erro! Nao foi possivel selecionar o banco de dados[e101b]'.'<br>';
						exit;
					}
					
					$sql = "UPDATE comandos SET procedimento='$PegaResto[$J]' WHERE registro='$Reg[$J]'";			
					echo "<br>"."Registro: ".$Reg[$J]." AttribAtualizado[".$PegaResto[$J]."]";
					$result = mysql_query($sql, $link);

					if (!$result) {
						$resultado = false;		
						echo "Erro! Nao foi possivel salvar o registro o banco de dados[e101c1]"."<br>";
						echo 'Erro MySQL: ' . mysql_error().'<br>';
						exit;
					}
					 mysql_close($link);
			}
		}// for...
		
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

		$Resulta[][]="";
		$P = 0;		
		$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
		if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection

		$sql = "SELECT * FROM comandos WHERE topico LIKE '$TopicoX%' ORDER BY procedimento ASC";	
		$objFuncao->RegistrarLog('SELECT * FROM `comandos` WHERE topico LIKE `'.$TopicoX.'%` ORDER BY procedimento ASC');			
		$result = mysqli_query($cnxMysql, $sql);		
		while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr		
			$Resulta[$P][0] = $row['registro'];
			$Resulta[$P][1] = $row['assunto']; 
			$Resulta[$P][2] = $row['topico']; 
			$Resulta[$P][3] = $row['procedimento']; 
			$Resulta[$P][4] = $row['descricao']; 
			$Resulta[$P][5] = $row['comando']; 
			$Resulta[$P][6] = $row['endereco']; 	
			$Resulta[$P][7] = $row['recentes']; 
			$Resulta[$P][8] = $row['data']; 

			$P++;			 
		}
		
		$Resulta[100][100] = $P;
		$cnxMysql->close();		// Fecha conexao($cnxMySql)
		
		return $Resulta;
		
}




function SalveEditar($Registro, $Assunto, $Topico, $Indice, $Descricao, $Comando)
{	
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.SalveEditar('.$Registro.','.$Assunto.','.$Topico.','.$Indice.','.$Descricao.','.$Comando.');');

	$resultado = true;
	$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
	if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection

	$Data = date("d/m/Y");
	$Cmd = $Comando.", ed[".$Data."]"; 
	
	$sql = "UPDATE comandos SET assunto='$Assunto', topico='$Topico', procedimento='$Indice', descricao='$Descricao', comando='$Comando' WHERE registro='$Registro'";			
	$result = mysqli_query($cnxMysql, $sql);
	if (!$result) {
		$resultado = false;		
		echo "Erro! Nao foi possivel salvar o registro o banco de dados[e101c2]"."<br>";
		echo 'Erro MySQL: ' . mysql_error().'<br>';
		exit;
	}
	$cnxMysql->close();		// Fecha conexao($cnxMySql)
	
	return $resultado;
		
}

function SalvarEtqta($Ccto, $De, $Para, $Obs, $Impressao)
{	
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.SalvarEtqta('.$Ccto.','.$De.','.$Para.','.$Obs.');');

	$resultado = true;
	if (!$link = mysql_connect('localhost', 'root', '')) {
		$resultado = false;		
		echo 'Erro! Nao foi possivel conectar ao mysql[e101e]'.'<br>';
		exit;
	}

	if (!mysql_select_db('Rede', $link)) {
		$resultado = false;	
		echo 'Erro! Nao foi possivel selecionar o banco de dados[e101ea]'.'<br>';
		exit;
	}
	$Data = date("d/m/Y");
	
	$sql = "UPDATE etqtas SET ccto='$Ccto', de='$De', para='$Para', obs='$Obs', data='$Data', impresso='$Impressao' WHERE registro='$Registro'";			
	$sql = "INSERT INTO etqtas(ccto, de, para, obs, data, impresso)	VALUE('$Ccto', '$De', '$Para', '$Obs', '$Data', '$Impressao')";			
	$result = mysql_query($sql, $link);

	if (!$result) {
		$resultado = false;		
		echo "Erro! Nao foi possivel salvar o registro o banco de dados[e101c3]"."<br>";
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
	else{ $Tipo = "Nao"; }
			
			
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
	else{ $Tipo = "Nao"; }

	
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
		echo 'Erro! Nao foi possivel conectar ao mysql[e101e]'.'<br>';
		exit;
	}

	if (!mysql_select_db('Rede', $link)) {
		$resultado = false;	
		echo 'Erro! Nao foi possivel selecionar o banco de dados[e101ea]'.'<br>';
		exit;
	}
	$Data = date("d/m/Y");

	
	$sql = "UPDATE etqtas SET impresso='Sim' WHERE Registro>='$De' AND Registro<='$Ate'";			
	$result = mysql_query($sql, $link);

	if (!$result) {
		$resultado = false;		
		echo "Erro! Nao foi possivel salvar o registro o banco de dados[e101c4]"."<br>";
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
		echo 'Erro! Nao foi possivel conectar ao mysql[e101e]'.'<br>';
		exit;
	}

	if (!mysql_select_db('Rede', $link)) {
		$resultado = false;	
		echo 'Erro! Nao foi possivel selecionar o banco de dados[e101ea]'.'<br>';
		exit;
	}
	$Data = date("d/m/Y");

	
	$sql = "UPDATE etqtas SET ccto='$Ccto', de='$De', para='$Para', obs='$Obs', data='$Data', impresso='$Impresso' WHERE Registro='$Registro'";			
	$result = mysql_query($sql, $link);

	if (!$result) {
		$resultado = false;		
		echo "Erro! Nao foi possivel salvar o registro o banco de dados[e101c5]"."<br>";
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
		echo 'Erro! Nao foi possivel conectar ao mysql[e101e]'.'<br>';
		exit;
	}

	if (!mysql_select_db('Rede', $link)) {
		$resultado = false;	
		echo 'Erro! Nao foi possivel selecionar o banco de dados[e101ea]'.'<br>';
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
	 * Gera um codigo(double): 
	 * yy/mm/dd hh:mm <num.registro>
	 * 170320.0951321
	 * 
     */	 
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.Recentes('.$Registro.');');

	/* Registra data do acesso */
	
	$RegX = floatval($Registro);

	$Data = date('ymd');
	$Min = date('hi');	
	$FloatMin = $Min/10000;
	$FloatReg = $RegX/10000000;
	$DataReg = $Data + $FloatMin +$FloatReg;	// Soma Data, Hora com registro para filtrar (Registros recentes - filtro trata como um empilhamento, os mais recentes em cima)
	$Agora = 'Dt'.$Data.' Min'.$Min; 
	//$objFuncao->RegistrarLog('Class.MySql.Recentes('.$Registro.')-> '.$FloatMin.' -> '.$FloatReg.'->'.$DataReg.';');
	// Resulta em: 
	//				230308.0619883
	//				230308.0618884
	//				230308.0616288
	//				230308.0616051

	// echo"Soma Momento Acesso: $DataReg";


	$resultado = true;

	$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
	if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection

	
	if($Acao=="Clear"){ $sql = "UPDATE comandos SET recentes='$Registro' WHERE registro>0"; }	// Limpa recentes
	else{ $sql = "UPDATE comandos SET recentes='$DataReg' WHERE registro='$Registro'"; }	// Registra acesso
	if (!mysqli_query($cnxMysql, $sql)) {	
		$resultado = false;		// echo "3 - Erro do banco de dados, Nao foi possivel consultar o banco de dados\n";
								// echo '4 - Erro MySQL: ' . mysql_error();
		
		$objFuncao->RegistrarLog('Class.MySql.Recentes('.$Registro.')-> Falhou! '.$Agora.' -> '.$DataReg.';');
		exit;
	}else{		
		$resultado = true;
		$objFuncao->RegistrarLog('Class.MySql.Recentes('.$Registro.')-> Sucesso! '.$FloatReg.' -> '.$DataReg.';');
	}
	$cnxMysql->close();		// Fecha conexao($cnxMySql)		
	
	if($Acao=="Clear"){ $resultado = "Historico de recentes excluido com sucesso!"; }
	
	return $resultado;
		
}

function SalveAdicionar($Assunto, $Topico, $Indice, $Descricao, $Comando)
{	
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.SalveAdicionar('.$Assunto.');');

	$Res = 0;
	$Data = Date("d/m/Y");
	$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
	if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection
			
	
	$sql = "INSERT INTO comandos(assunto, topico, procedimento, descricao, comando, data)	VALUE('$Assunto', '$Topico', '$Indice', '$Descricao', '$Comando', '$Data')";			

	if (!mysqli_query($cnxMysql, $sql)) {
		$Res = 0;		// echo "3 - Erro do banco de dados, Nao foi possivel consultar o banco de dados\n";
								// echo '4 - Erro MySQL: ' . mysql_error();
		//exit;
	}else{
		$Res = $cnxMysql->insert_id;  // Num.Reg inserido
	}
	$cnxMysql->close();		// Fecha conexao($cnxMySql)
	
	return $Res;
		
}

function Excluir($Registro)
{	
	$objFuncao = new Funcao();
	$objFuncao->RegistrarLog('Class.MySql.Excluir('.$Registro.');');

	$resultado = true;
	$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
	if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection

	$sql = "DELETE FROM comandos WHERE registro='$Registro'";			
	$result = mysqli_query($cnxMysql, $sql);	
	if (!$result) {
		$resultado = false;		// echo "3 - Erro do banco de dados, Nao foi possivel consultar o banco de dados\n";
								// echo '4 - Erro MySQL: ' . mysql_error();
		exit;
	}
	$cnxMysql->close();		// Fecha conexao($cnxMySql)
	
	return $resultado;
		
}


	function GerarCSV($Dir, $Tabela, $Eqpto){
	
	
		$objFuncao = new Funcao();
		$objFuncao->RegistrarLog('Class.MySql.GerarCSV('.$Dir.', '.$Tabela.');');
		
		$CriaCelula='--------------------------------------------------------------------------------------------';
		$Titulo = array('Reg: ', 'Ass: ', 'Top: ', 'Proc: ', 'Desc: ');
	
		$RegX[] = "";
		//if($Eqpto=='Completo'){ $Eqpto = Null; }	// Mudei pra dar mais seguran�a				
		$RegX = $this->ListarCmdFull($Eqpto); 	
		
		/*
		 * Formata local e nome do arq.csv
		 * Abre ou cria o arquivo
		 * "a" representa que o arquivo e aberto para ser escrito
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
						$escreve = fwrite($fp, $CriaCelula."\n"); 	// Escreve no arq.csv	
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
	
	
	function GerarHtml1($Dir, $Tabela, $Eqpto){
	/*
	 *	Constroi pagina OffLine.html(codigos html)
	 *	Ideal p/ celular(Pasta ZiP)
	 */
		$objFuncao = new Funcao();
		$objFuncao->RegistrarLog('Class.MySql.GerarHTML('.$Dir.', '.$Tabela.');');
		
		$CriaBodyTable='<html>
					<head>
					<style type="text/css">
					body {
						background-color: #B0C4DE;
					}
					.TAB_ConteudoIntMargem
					{ 
						border: 1px solid #6A5ACD; ?>;				
						border-width: 1px; 		
						border-color: #6A5ACD; ?>;
						background-color: #ffffff; ?>; 
					} 
					.fonte_topico{
						COLOR: #4682B4;
						FONT-FAMILY: Verdana;
						FONT-SIZE: 11pt;
						TEXT-DECORATION: none;
						FONT-WEIGHT: none;
					}
					</style>
					</head>
					<body background="#B0C4DE">
					<table class="TAB_ConteudoIntMargem" width="80%" align="center" valign="top">
					';
					
		$Rodape='</td></tr></table></body>';
				
		$CriaCelula='</td></tr>
				<tr align="left"  height="5" valign="top" border="1">
				<td id="fonte_topico" width="100%" colspan="1"  align="left"  height="5" valign="top">
				';
		$Titulo = array('Reg: ', 'Ass: ', 'Top: ', 'Proc: ', 'Desc: ');
	
		$RegX[] = "";
		//if($Eqpto=='Completo'){ $Eqpto = Null; }	// Mudei pra dar mais seguran�a				
		$RegX = $this->ListarCmdFull($Eqpto); 	
		
		/*
		 * Formata local e nome do arq.csv
		 * Abre ou cria o arquivo
		 * "a" representa que o arquivo � aberto para ser escrito
		 */
		$hoje = date("dFY"); 
		//$arquivo = $Dir."BakCmd_".$hoje."_".$Eqpto.".html"; 
		$arquivo = $Eqpto.".html"; 
		
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
		$escreve = fwrite($fp, $CriaBodyTable."\n"); 	// Cria Corpo, tabela da pagina
	
		$AbreCxTexto='<TEXTAREA ID="TxComando" COLS="100" ROWS="20" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);">';
		$FechaCxTexto='</TEXTAREA>';
		
		
		// Constroi Titulo da p�gina
		$TitPag = $RegX[2][0];
		$TituloPag = '<br><br><font color="#191970"><font size="4" face="Verdana"><b>'.$TitPag.'</b><br><br><br>'; 	
		
		$escreve = fwrite($fp, $CriaCelula."\n"); 	// Escreve no arq.html...Cria linhas/celulas p�g.html
		$escreve = fwrite($fp, $TituloPag."\n"); 	// Escreve no arq.html....cria titulo	
		
		
		// Constroi Indice
		for($I = 0; $I < $RegX[100][100]; $I++){
			
			//$linha = $RegX[$L][$C]."\n";			// Formata linha
				
			// Escreve Titulo: Reg, Assunto, T�pico, Procedimento, Descricao
			$escreve = fwrite($fp, $CriaCelula."\n"); 	// Escreve no arq.csv	
			$IndiceDesc = '&nbsp;&nbsp;&nbsp;<a href="#Registro_'.$RegX[0][$I].'">'.$RegX[0][$I].'.'.$RegX[3][$I].'('.$RegX[4][$I].')</a>';
			$escreve = fwrite($fp, '<font color="#191970"><font size="2" face="Verdana">'.$IndiceDesc.'<br>'); 	// Escreve no arq.csv
		}

		// Constroi conteudo da p�gina	
		for($C = 0; $C < $RegX[100][100]; $C++){
			for($L = 0; $L <= 6; $L++){
			
				$linha = $RegX[$L][$C]."\n";			// Formata linha
				
				if($L==0){
						// Escreve Titulo: Reg, Assunto, T�pico, Procedimento, Descricao
						$escreve = fwrite($fp, $CriaCelula."\n"); 	// Escreve no arq.csv	
						$Desc = '&nbsp;&nbsp;&nbsp;<a name="Registro_'.$RegX[0][$C].'">'.$RegX[0][$C].'.'.$RegX[3][$C].'('.$RegX[4][$C].')</a>';
						$escreve = fwrite($fp, '<br><br><font color="#191970"><font size="2" face="Verdana"><b>'.$Desc.'</b><br>'); 	// Escreve no arq.csv
				}
				if($L>0){
						// Escreve conteudo de comandos em TextArea
						$TamLinha = strlen($linha)/80;   // Faz uma contagem media do num de linhas
						
						if($TamLinha>1){
							if($TamLinha<10){ $TamLinha=10;}
							$AbreCxTexto='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<TEXTAREA ID="TxComando" COLS="110" ROWS="'.$TamLinha.'" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);">';
	
						
							$escreve = fwrite($fp, "\n".$AbreCxTexto); 	// Escreve no arq.csv
							$escreve = fwrite($fp, "\n".$linha); 		// Escreve no arq.csv
							$escreve = fwrite($fp, "\n".$FechaCxTexto); // Escreve no arq.csv
						}
				}
				
				
			}
			$escreve = fwrite($fp, "\n");	//pula uma linha
		}
		$escreve = fwrite($fp, $Rodape."\n"); 	// Escreve no arq.html
		// Fecha o arquivo
		fclose($fp);
		
		return (true);	
	}
	
	
function GerarHtml5($Dir, $Tabela, $Eqpto){
/*
* Constroi p�gina OffLine.html(codigos html5)
*/	
$objFuncao = new Funcao();
$objFuncao->RegistrarLog('Class.MySql.GerarHTML('.$Dir.', '.$Tabela.');');
		
$CriaCabecario='<!DOCTYPE html>
<html>
<head>
		
	<meta http-equiv=�Content-Type� content=�text/html; charset=utf-8?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<title>Rede</title>		
	<meta name="description" content="A sidebar menu as seen on the Google Nexus 7 website" />
	<meta name="keywords" content="google nexus 7 menu, css transitions, sidebar, side menu, slide out menu" />
	<meta name="author" content="Codrops" />
	<link rel="shortcut icon" href="../favicon.ico">
	<link rel="stylesheet" type="text/css" href="css/normalize.css" />
	<link rel="stylesheet" type="text/css" href="css/config.css" />
	<link rel="stylesheet" type="text/css" href="css/component_menu.css" />
	<script src="js/modernizr.custom.js"></script>
	
	<!-- Localizador: https://pt.stackoverflow.com/questions/409940/simular-um-ctrlf-com-javascript	-->
	<style>
		mark {  background: yellow;	}			/* Marca texto encotrado */
		mark.current {  background: orange;	}	/* Marca texto encontrado+cursor */

		.header {
		  padding: 10px;
		  width: 20%;
		  height: 10px;
		  background: #fffafa;
		  position: fixed;
		  top: 0px;
		  left: 990px;
		}
		.content { margin-top: 20px; }
	</style>
	<script src="/scripts/snippet-javascript-console.min.js?v=1"></script>
	<!-- /Localizador -->

</head>
	
<body>
		<!-- Localizador -->
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/jquery.mark.min.js"></script>
		<!-- /Localizador -->
	
		<div class="container">
		
			<ul id="gn-menu" class="gn-menu-main">
				<li class="gn-trigger">
					<a class="gn-icon gn-icon-menu"><span>Menu</span></a>
					<nav class="gn-menu-wrapper">
						<div class="gn-scroller">
							<ul class="gn-menu">
								<li><a class="gn-icon gn-icon-engrenagem" href="https://10.48.103.55/afetacao/det.php?uf=PR" TARGET="_blank">Alarmes(T15)</a></li>
								<li><a class="gn-icon gn-icon-imagens" href="http://legado.brasiltelecom.com.br:8080/telao_web/?tipoPlanta=0&uf=PR" TARGET="_blank">Alarmes(FO)</a></li>
								<li><a class="gn-icon gn-icon-gaveta" href="http://10.121.241.95/portaloi/view/dslam/index.php" TARGET="_blank">Clt ADSL</a></li>
								<li><a class="gn-icon gn-icon-lupa" href="http://10.61.240.162:7005/oms/control/orderListMenu/" TARGET="_blank">Oms</a></li>
								<li><a class="gn-icon gn-icon-artigos" href="http://10.61.240.163:7007/provision/report/index.jsp" TARGET="_blank">Provision</a></li>
								<li><a class="gn-icon gn-icon-foto" href="http://ping.cn.brasiltelecom.net.br/" TARGET="_blank">Rt-ping</a></li>
								<li><a class="gn-icon gn-icon-planeta" href="https://passaporteoi.oi.net.br/" TARGET="_blank">Vpn</a></li>
								<li><a class="gn-icon gn-icon-ilustrar" href="favoritos.html">Mais...</a></li>
							</ul>
						</div><!-- /gn-scroller -->
					</nav>
				</li>
				<li><a href="index.html"><img src="imagens/Home.png" alt="Home"></a></li>
				<li><a href="#"><span><img src="imagens/AttribTopoMenu.png" alt="AttribTopo"></span></a></li>
				<!--<li><a class="codrops-icon codrops-icon-drop" href="http://tympanus.net/codrops/?p=16030"><span>Back to the Codrops Article</span></a></li>-->
				<li><!-- Localizador -->  
					<div class="header">			
					  <input type="search" placeholder="Localizar">
					  <button data-search="next">&darr;</button>
					  <button data-search="prev">&uarr;</button>
					  <button data-search="clear">x</button>
					</div>
				</li><!-- /Localizador -->
			</ul>
<header> 
<div class="content"><!-- Localizador -->';
					
$CriaRodape='<!-- Localizador -->					
<script type="text/javascript">
/** Use: seach, clear, prev, next entre aspas simples */
$(function() {
  var $input = $("input[type=search]"),
    $clearBtn = $("button[data-search=clear]"),
    $prevBtn = $("button[data-search=prev]"),
    $nextBtn = $("button[data-search=next]"),
    $content = $(".content"),
    $results,
    currentClass = "current",
    offsetTop = 50,
    currentIndex = 0;
*/
  /**
   * Saltar para o elemento correspondente ao currentIndex
   */
  function jumpTo() {
    if ($results.length) {
      var position,
        $current = $results.eq(currentIndex);
      $results.removeClass(currentClass);
      if ($current.length) {
        $current.addClass(currentClass);
        position = $current.offset().top - offsetTop;
        window.scrollTo(0, position);
      }
    }
  }

  /**
   * Procurar a palavra-chave inserida no
   * contexto especificado na entrada
   */
  $input.on("input", function() {
  	var searchVal = this.value;
    $content.unmark({
      done: function() {
        $content.mark(searchVal, {
          separateWordSearch: true,
          done: function() {
            $results = $content.find("mark");
            currentIndex = 0;
            jumpTo();
          }
        });
      }
    });
  });

  /**
   * Limpar a pesquisa
   */
  $clearBtn.on("click", function() {
    $content.unmark();
    $input.val("").focus();
  });

  /**
   * Salto para a pesquisa seguinte e anterior
   */
  $nextBtn.add($prevBtn).on("click", function() {
    if ($results.length) {
      currentIndex += $(this).is($prevBtn) ? -1 : 1;
      if (currentIndex < 0) {
        currentIndex = $results.length - 1;
      }
      if (currentIndex > $results.length - 1) {
        currentIndex = 0;
      }
      jumpTo();
    }
  });
});
<!-- /Localizador -->
    </script>

</div><!-- /contend-->
</header><!-- /header -->
</div><!-- /container -->

				<!-- Menu Lateral -->					
					<script src="js/classie.js"></script>
					<script src="js/gnmenu.js"></script>
					<script> 
						new gnMenu( document.getElementById( "gn-menu" ) );
					</script>
				<!-- /Menu Lateral -->

</body>
</html>
';
		$RegX[] = "";
		$RegX = $this->ListarCmdFull($Eqpto); 	
		/*
		 * Formata local e nome do arq.csv
		 * Abre ou cria o arquivo
		 * "a" representa que o arquivo � aberto para ser escrito
		 */
		$arquivo = "OffLine\\".$Eqpto.".html"; 
		$fp = fopen($arquivo, "a");	

		$escreve = fwrite($fp, $CriaCabecario."\n"); 	// Cria Corpo, tabela da pagina
	
		$AbreCxTexto='<h5><TEXTAREA class="content" ID="TxComando" COLS="120" ROWS="20" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);">';
		$FechaCxTexto='</TEXTAREA></h5>';
		
		// Constroi Titulo da p�gina
		$TituloPag = "<h1>".$RegX[2][0]."</h1><p>";
		
		$escreve = fwrite($fp, $TituloPag."\n"); 	// Escreve no arq.html....cria titulo	
		
		
		// Constroi Indice
		for($I = 0; $I < $RegX[100][100]; $I++){
			
			$IndiceDesc = '<h4><a href="#Registro_'.$RegX[0][$I].'">'.$RegX[3][$I].'('.$RegX[4][$I].')</a></h4>';
			$escreve = fwrite($fp, $IndiceDesc."\n"); 	// Escreve no arq.csv
		}

		// Constroi conteudo da p�gina	
		for($C = 0; $C < $RegX[100][100]; $C++){
			for($L = 0; $L <= 6; $L++){
			
				$linha = $RegX[$L][$C]."\n";			// Formata linha
				
				if($L==0){
						// Escreve Titulo: Reg, Assunto, T�pico, Procedimento, Descricao
						//$escreve = fwrite($fp, $CriaCelula."\n"); 	// Escreve no arq.csv	
						$Conteudo = '<h4><a name="Registro_'.$RegX[0][$C].'">&nbsp;</a></h4><br><br><h4>'.$RegX[3][$C].'('.$RegX[4][$C].')</h4>';
						$escreve = fwrite($fp, $Conteudo); 	// Escreve no arq.csv
				}
				if($L>0){
						// Escreve conteudo de comandos em TextArea
						$TamLinha = strlen($linha)/80;   // Faz uma contagem media do num de linhas
						
						if($TamLinha>1){
							if($TamLinha<10){ $TamLinha=10;}
							$AbreCxTexto='<h5><TEXTAREA class="content" ID="TxComando" COLS="110" ROWS="'.$TamLinha.'" style="overflow: visible" ONKEYDOWN="expandTextArea(this, event);">';
	
						
							$escreve = fwrite($fp, "\n".$AbreCxTexto); 	// Escreve no arq.csv
							$escreve = fwrite($fp, "\n".$linha); 		// Escreve no arq.csv
							$escreve = fwrite($fp, "\n".$FechaCxTexto); // Escreve no arq.csv
						}
				}
				
				
			}
			$escreve = fwrite($fp, "\n");	//pula uma linha
		}
		$escreve = fwrite($fp, $CriaRodape."\n"); 	// Escreve no arq.html
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

		// $arquivo="c:/wamp64/bin/mysql/mysql8.2.0/data/rede/BakCmd_22March2024_full.csv";
		$objFuncao = new Funcao();
		$objFuncao->RegistrarLog('Class.MySql.RestaureDados('.$tabela.', '.$arquivo.','.$tipo.');');
		
		$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
		if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection

		
		if($tipo == defSUBSTITUIR){ 
		
			if($this->LimparTabela($tabela)){
				$sql = "LOAD DATA INFILE '$arquivo' INTO TABLE $tabela FIELDS TERMINATED BY ';';"; 
				if(mysqli_query($cnxMysql, $sql)){									
					$Retorno = "Tabela: $tabela carregada com sucesso! <br>";																	
				}else{
					$Retorno = "Erro!  Falha de conexao com MySql, arquivo Nao pode ser carregado. [e401a]";
				}
			}else{
				$Retorno = "Erro!  Falha de conexao com MySql, carga cancelada. [e401b]";
				
			}
			
		}else{
			//echo "LOAD DATA INFILE '$arquivo' INTO TABLE $tabela FIELDS TERMINATED BY ';'"."<br>";
			
			$sql = "LOAD DATA INFILE '$arquivo' INTO TABLE $tabela FIELDS TERMINATED BY ';'"; 
			if(mysqli_query($cnxMysql, $sql)){							
				$Retorno = "Tabela: $tabela carregada com sucesso! <br>";																	
			}else{
				$Retorno = "Erro!  Falha de conexao com MySql, arquivo Nao pode ser carregado. [e401c]";
			}
		}

		$cnxMysql->close();		// Fecha conexao($cnxMySql)
		
		return($Retorno);
	}
	
	
	function LimparTabela($Tabela){
		
		/* Limpa dados da tabela */
		
		$objFuncao = new Funcao();
		$objFuncao->RegistrarLog('Class.MySql.LimparTabela('.$Tabela.');');
		
		$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
		if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection
	
					
		$sql = "DELETE FROM $Tabela WHERE registro>0";
		if(mysqli_query($cnxMysql, $sql)){									
			echo "Todos os dados da tabela: $Tabela foram excluidos! <br>";											
			$Retorno = true;
		}else{
			$Retorno = false;
			echo "Erro!  Falha de conexao com MySql, registros Nao excluidos. [e301a]";
		}
		
		$cnxMysql->close();	// fecha conexao com BD						
		
		return($Retorno);
		
	}
	


} /* end Class */

?>
