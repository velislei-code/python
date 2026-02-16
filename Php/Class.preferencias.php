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

define("_LstCmd", 1);  
define("_TaRIps", 2);  
define("_TaBBone", 3);  
define("_FltPROD", 4);  
define("_FltTIPO", 5);  
define("_FltCAD", 6);  
define("_FltHIST", 7);  

define("_LstCmdOn", 1);  
define("_LstCmdOff", 0); 

define("_TaRIpsOn", 1);  
define("_TaRIpsOff", 0); 

define("_TaBBoneOn", 1); 
define("_TaBBoneOff", 0); 

define("_BOTOES", 0); 
define("_FILTROS", 1); 

class Preferencias {

    function SaveConfigV1($lstCmds, $taReverIps, $taBackbone)
    {	
        $objFuncao = new Funcao();
        //$objFuncao->RegistrarLog('Class.Ticket.SalveTicket('.$Registro.','.$Assunto.','.$Topico.','.$Indice.','.$Descricao.','.$Comando.');');
 
        //echo"SaveConfig(".$lstCmds.", ".$taReverIps.", ".$taBackbone.")";

        $resultado = true;
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection
         
        $sql = "UPDATE config SET  lst_cmds='$lstCmds', ta_rever_ips='$taReverIps', ta_backbone='$taBackbone'  WHERE reg = 1";
        $result = mysqli_query($cnxMysql, $sql);
        if (!$result) {
            $resultado = false;		
            echo "Erro! Nao foi possivel salvar o registro o banco de dados[e101c2]"."<br>";
            echo 'Erro MySQL: ' . mysql_error().'<br>';
            exit;
        }else{     
                // $objFuncao->Mensagem('Atencao!', 'Registro['.$Registro.'] salvo com sucesso!', Null, Null, defAviso, Null);
        }

        $cnxMysql->close();		// Fecha conexao($cnxMySql)
       
        return $resultado;
            
    }

    function SaveConfig($Orig, $lstCmds, $taReverIps, $taBackbone, $FltProduto,  $FltTipo,  $FltACad,  $FltHist)
    {	
        $objFuncao = new Funcao();
        //$objFuncao->RegistrarLog('Class.Ticket.SalveTicket('.$Registro.','.$Assunto.','.$Topico.','.$Indice.','.$Descricao.','.$Comando.');');
 
        //echo"SaveConfig(".$lstCmds.", ".$taReverIps.", ".$taBackbone.")";

        $resultado = true;
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection
        
        if($Orig == _BOTOES){
            $sql = "UPDATE config SET lst_cmds='$lstCmds', ta_rever_ips='$taReverIps', ta_backbone='$taBackbone'  WHERE reg = 1";
        }else if($Orig == _FILTROS){
            $sql = "UPDATE config SET flt_produto='$FltProduto', flt_tipo='$FltTipo', flt_aCadastrar='$FltACad',  flt_historico='$FltHist' WHERE reg = 1";
        }
        
            $result = mysqli_query($cnxMysql, $sql);
        if (!$result) {
            $resultado = false;		
            echo "Erro! Nao foi possivel salvar o registro o banco de dados[e101c2]"."<br>";
            echo 'Erro MySQL: ' . mysql_error().'<br>';
            exit;
        }else{     
                // $objFuncao->Mensagem('Atencao!', 'Registro['.$Registro.'] salvo com sucesso!', Null, Null, defAviso, Null);
        }

        $cnxMysql->close();		// Fecha conexao($cnxMySql)
       
        return $resultado;
            
    }

    function LoadConfig()
    {	
    // Consulta posicao dos campos: lst_cmds, ta_backbone, ta_rever_ips, se estao visiveis ou ocultos
   
            $Resulta[]="";
           
            $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
            if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection
          
            $sql = "SELECT * FROM config";               
            		
            $result = mysqli_query($cnxMysql, $sql);		
            while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr		
                $Resulta[_REG] = $row['reg'];
                $Resulta[_LstCmd] = $row['lst_cmds'];                
                $Resulta[_TaRIps] = $row['ta_rever_ips'];
                $Resulta[_TaBBone] = $row['ta_backbone'];                
                $Resulta[_FltPROD] = $row['flt_produto'];                
                $Resulta[_FltTIPO] = $row['flt_tipo'];                
                $Resulta[_FltCAD] = $row['flt_aCadastrar'];                
                $Resulta[_FltHIST] = $row['flt_historico'];                
                     
            }
                      
            $cnxMysql->close();		// Fecha conexao($cnxMySql)
            
            return $Resulta;
            
    }

}// end Class