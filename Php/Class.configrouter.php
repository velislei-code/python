<?Php 
/**
 * MySQL - Classe de manipula��o banco MySQL
 * NOTE: Requer PHP vers�o 5 ou superior
 * @package Biblioteca
 * @author Treuk, Velislei A.
 * @email: velislei@gmail.com
 * @copyright 2025 - 2030 
 * @licen�a: Estudantes
 */

define("_REG", 0);
define("_TIPO", 1);
define("_ROUTER", 2); 
define("_CONFIG", 3); 
define("_Data", 4); 


define("_CtgVETOR", 100); 

include_once("Class.funcao.php");


class ConfigRouter {

    				
    function AddConfigRouter($Tipo, $Router, $Config)  
    {	

        $objFuncao = new Funcao();
        $objFuncao->RegistrarLog('Class.MySql.AddTicket()');  
    
        $Hoje = date("d/m/Y");
        
        $Config = str_replace("'", "´", $Config);  

     
        $Res = 0;
        //$Data = Date("d/m/Y");
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection
                
        
        $sql = "INSERT INTO rav(tipo, router, config, data) VALUE('$Tipo', '$Router', '$Config', '$Hoje')";			

        if (!mysqli_query($cnxMysql, $sql)) {
            $Res = 0;		// echo "3 - Erro do banco de dados, Nao foi possivel consultar o banco de dados\n";
                                    // echo '4 - Erro MySQL: '.mysql_error();
            //exit;
        }else{
            $Res = $cnxMysql->insert_id;  // Num.Reg inserido
        }
        $cnxMysql->close();		// Fecha conexao($cnxMySql)
       

        return $Res;
           
    }


    function QueryConfig($IdX)
    {	
		
        // Faz uma consulta simples, sem combina��es
        $objFuncao = new Funcao();
		$objFuncao->RegistrarLog('Class.MySql.qUERYcONFIG('.$IdX.');');
		echo 'Class.MySql.LocalizarSimples('.$IdX.');';
	
       
	    
    	$Resulta[]="";	// Inicializa
		
	                
       
		$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
		if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection
		             
            /* Consultar somente A */
            
                       
        $sql="SELECT * FROM rav WHERE id='$IdX'"; 
        //echo "select * from tickets where (rascunho like '%.$PesquisarX.%' or rever_tunnel like '%.$PesquisarX.%' or backbone like '%.$PesquisarX.%') ORDER BY registro DESC"; 
        
		$result = mysqli_query($cnxMysql, $sql);		
		while ($row = mysqli_fetch_assoc($result))   // fetch associative arr 
		{	
            $Resulta[_REG] = $row['id'];
            $Resulta[_TIPO] = $row['tipo']; 
            $Resulta[_ROUTER] = $row['router']; 
            $Resulta[_CONFIG] = $row['config']; 
            $Resulta[_Data] = $row['data'];      

          
        }
		$cnxMysql->close();		// Fecha conexao($cnxMySql)
        //echo "Valor de P = ".$P."<br>";
        
       //  echo 'Pesquisar por:  '.$PesquisarX.'<br>';
		return ($Resulta);				
				
    }

    function LocalizarSimples($PesquisarX)
    {	
		
        // Faz uma consulta simples, sem combina��es
        $objFuncao = new Funcao();
		$objFuncao->RegistrarLog('Class.MySql.LocalizarSimples('.$PesquisarX.');');
	
       echo'Class.MySql.LocalizarSimples('.$PesquisarX.');'.'<br>';
	
    
    	$Resulta[][]="";	// Inicializa
		$P = 0;
	                
       
		$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
		if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection
		             
            /* Consultar somente A */
            
                       
        $sql="SELECT * FROM rav WHERE config LIKE '%$PesquisarX%' ORDER BY id DESC"; 
        //echo "select * from tickets where (rascunho like '%.$PesquisarX.%' or rever_tunnel like '%.$PesquisarX.%' or backbone like '%.$PesquisarX.%') ORDER BY registro DESC"; 
        
		$result = mysqli_query($cnxMysql, $sql);		
		while ($row = mysqli_fetch_assoc($result))   // fetch associative arr 
		{	
            $Resulta[$P][_REG] = $row['id'];
            $Resulta[$P][_TIPO] = $row['tipo']; 
            $Resulta[$P][_ROUTER] = $row['router']; 
            $Resulta[$P][_CONFIG] = $row['config']; 
            $Resulta[$P][_Data] = $row['data'];      

            $P++;
        }
		$cnxMysql->close();		// Fecha conexao($cnxMySql)
        //echo "Valor de P = ".$P."<br>";
        $Resulta[_CtgVETOR][_CtgVETOR] = $P;
       //  echo 'Pesquisar por:  '.$PesquisarX.'<br>';
		return ($Resulta);				
				
    }

        
} // end Class

?>