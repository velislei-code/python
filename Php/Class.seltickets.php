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
 
define("_selREG", 0);
define("_selKeyEstgREG", 1);
define("_selID", 2);
define("_selEmpresa", 3); 
define("_selProduto", 4); 
define("_selSPEED", 5); 
define("_selTIPO", 6); 
define("_selACad", 7);  
define("_selHIST", 8); 
define("_selDATA", 9); 

define("_statusLstID", 6); 
define("_tecnicoLstID", 7); 

/*
define("_RA", 10); 
define("_Router", 11); 
define("_Interface", 12); 
define("_Porta", 13); 
define("_Speed", 14); 
define("_VidUnit", 15); 
define("_PolicyIN", 16); 
define("_PolicyOUT", 17); 
define("_Vrf", 18); 
define("_sVlan", 19); 
define("_cVlan", 20); 
define("_Lan", 21); 
define("_Wan", 22); 
define("_LoopBack", 23); 
define("_Lan6", 24); 
define("_Wan6", 25); 
define("_Status", 26); 
define("_Rascunho", 27);  
define("_ReverTunnel", 28);  
define("_Backbone", 29);  
define("_Data", 30); 
define("_PlacaSwa", 31);
define("_OPERADORA", 32); 
define("_IdFlow", 33); 

define("_TUDO", 0);  
define("_NOVOS", 1);  
define("_ANALISANDO", 2);  
define("_REVISAR", 3);
define("_ENCERRADOS", 4);    
define("_CtgVETOR", 100); // Contagem num.elem.matriz/vetor 
define("_TotENCERRADOS", 300); // Contagem num.elem.matriz/vetor 
*/


include_once("Class.funcao.php");


class selTickets {

    				
    function AddTicket($Registro, $ID, $Empresa, $Produto, $Speed, $Status, $Rascunho, $Data)  
    {	

        $objFuncao = new Funcao();
        $objFuncao->RegistrarLog('Class.selTickets.AddTicket('.$Registro.','. $ID.','. $Empresa.','. $Produto.','. $Speed.','.$Status.','.$Rascunho.')');  
    
  
        //$Data = Date("d/m/Y");
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection
                
        
        $sql = "INSERT INTO seltickets(id, empresa, produto, speed, status, rascunho, data)	
                VALUE('$ID', '$Empresa', '$Produto', '$Speed', '$Status', '$Rascunho', '$Data')";			

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

                        
                       
		
    function SalvarTicket($Reg, $ID, $Empresa, $Produto, $Speed, $Data, $Status, $RascX)
    {	

       
        $resultado = true;
        $objFuncao = new Funcao();
        $objFuncao->RegistrarLog('Class.selTicket.SalveTicket('.$Reg.','. $ID.','. $Empresa.','. $Produto.','. $Speed.','.$Status.', '.$RascX.')');
        
        if($ID != '' && $Status == 'Novo'){ $Status = 'Analisando'; }
        //echo '['.$Reg.']'.'<br>';

        if(str_contains($Reg, '[')){
            $posIni = strpos($Reg, '[')+1;
            $posFim = strpos($Reg, ']')-1;
            $Registro = substr ($Reg, $posIni, $posFim);
        }else{
            $Registro = $Reg;   
        }

        if($Registro == 'Selecionar'){ $Registro = 1;}
    

            $RascX = str_replace("'", "`", $RascX);  // Tira aspas devido falha de SQL-injection
            $Empresa = str_replace("'", "`", $Empresa);  // Tira aspas devido falha de SQL-injection
            

               
                $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
                if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection
        
                $sql = "UPDATE seltickets SET  id='$ID', empresa='$Empresa', produto='$Produto', speed='$Speed', status='$Status', rascunho='$RascX', data='$Data' WHERE registro = '$Registro'";
               // echo 'UPDATE seltickets SET  id='.$ID.', empresa='.$Empresa.', produto='.$Produto.', speed='.$Speed.', status='.$Status.', rascunho='.$RascX.', data='.$Data.' WHERE registro = '.$Registro;
                
                $result = mysqli_query($cnxMysql, $sql);
                if (!$result) {
                    $resultado = false;		
                    echo "Erro! Nao foi possivel salvar o registro o banco de dados[e101c2]"."<br>";
                    //echo 'Erro MySQL: '.mysql_error().'<br>';
                    exit;
                }else{     
                        // $objFuncao->Mensagem('Atencao!', 'Registro['.$Registro.'] salvo com sucesso!', Null, Null, defAviso, Null);
                        //echo "O registro o banco de dados[".$Registro."], foi salvo com sucesso"."<br>".$RascX;
                    }
                

                $cnxMysql->close();		// Fecha conexao($cnxMySql)
           
        return $resultado;
            
    }

    function QueryTickets($RegX, $EmpresaX, $Origem)
    {	

        $objFuncao = new Funcao();
        $objFuncao->RegistrarLog('Class.SelTickets.QueryTickets('.$RegX.','.$EmpresaX.','.$Origem.');');
        //echo 'Class.SelTickets.QueryTickets('.$RegX.','.$EmpresaX.','.$Origem.'); -> ';
       
        $RegistroX = $RegX;
        if($RegX == 'Selecionar'){ $RegistroX = 1;}
        // Caso chamada a funcao NAO venha de BtAvancarReg...formata Num $RegX 
        // Caso Venha de BtAvancarReg...pega $RegX enviado pela funcao    
        if(str_contains($RegX, '[')){  
                    
            if($RegX != 'Null'){
                $posIni = strpos($RegX, '[')+1;
                $posFim = strpos($RegX, ']')-1;
                $RegistroX = substr ($RegX, $posIni, $posFim);
        
            }
        
        }

        
        // SELECT * FROM seltickets WHERE registro = '[1787] 1920494.RB - Revisar()';
            $Resulta[][]="";
            $P = 0;		
            $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
            if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection

            //$sql = "SELECT * FROM seltickets WHERE topico LIKE '$TopicoX%' ORDER BY procedimento ASC";	
            if($RegistroX > 0){ 
                $sql = "SELECT * FROM seltickets WHERE registro = '$RegistroX'";
                $objFuncao->RegistrarLog("SELECT * FROM seltickets WHERE registro = '".$RegistroX."';");
                
            }else{ 
                if(empty($EmpresaX)){ 
                    $sql = "SELECT * FROM seltickets"; 	
                    $objFuncao->RegistrarLog("SELECT * FROM seltickets;");
                }else{    
                    $sql = "SELECT * FROM seltickets WHERE empresa LIKE '%$EmpresaX%'"; 	
                    $objFuncao->RegistrarLog("SELECT * FROM seltickets WHERE empresa LIKE '%.$EmpresaX.%';");
                    //$sql = "SELECT * FROM seltickets WHERE status LIKE 'Analisan%' OR status LIKE 'Pende%' ORDER BY registro DESC";  
                    //$objFuncao->RegistrarLog("SELECT * FROM seltickets WHERE status LIKE 'Analisan%' OR status LIKE 'Pende%' ORDER BY registro DESC;"); 
                }	
            }		
            		
            $result = mysqli_query($cnxMysql, $sql);		
            while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr		
                $Resulta[$P][_REG] = $row['registro'];
                $Resulta[$P][_ID] = $row['id']; 
                $Resulta[$P][_Empresa] = $row['empresa']; 
                $Resulta[$P][_Produto] = $row['produto'];                         
                $Resulta[$P][_Speed] = $row['speed']; 
                $Resulta[$P][_Status] = $row['status']; 
                $Resulta[$P][_Rascunho] = $row['rascunho'];                 
                $Resulta[$P][_Data] = $row['data']; 

                $P++;	
 
            }
            
            $Resulta[_CtgVETOR][_CtgVETOR] = $P;
            $cnxMysql->close();		// Fecha conexao($cnxMySql)
            
            //echo $P.'<br>';    
      

            return $Resulta;
            
    }

  

    function SalvarCxSelTicket($keyEstgReg, $nID, $Empresa, $Produto, $Speed, $Tipo, $Cad, $Hist, $Data)  
    {	

        $objFuncao = new Funcao();
        $objFuncao->RegistrarLog('Class.selTickets.SalvarCxSelTicket('.$keyEstgReg.','. $nID.','. $Empresa.','. $Produto.','. $Speed.','.$Tipo.','.$Hist.')');  
    
   
        //$Data = Date("d/m/Y");
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection
                
        
        $sql = "INSERT INTO cxseltickets(keyEstgReg, nID, empresa, produto, speed, tipo, acadastrar, historico, data)	
                VALUE('$keyEstgReg', '$nID', '$Empresa', '$Produto', '$Speed', '$Tipo', '$Cad', '$Hist', '$Data')";			

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
    
    function QueryCxSelTickets_V1($RegX, $EmpresaX, $Origem)
    {	

        $objFuncao = new Funcao();
        $objFuncao->RegistrarLog('Class.SelTickets.QueryCxSelTickets_V1('.$RegX.','.$EmpresaX.','.$Origem.');');
        // echo 'Class.SelTickets.QueryTickets('.$RegX.','.$EmpresaX.','.$Origem.'); -> ';
       
        $RegistroX = $RegX;
        if($RegX == 'Selecionar'){ $RegistroX = 1;}
        // Caso chamada a funcao NAO venha de BtAvancarReg...formata Num $RegX 
        // Caso Venha de BtAvancarReg...pega $RegX enviado pela funcao    
        if(str_contains($RegX, '[')){  
                    
            if($RegX != 'Null'){
                $posIni = strpos($RegX, '[')+1;
                $posFim = strpos($RegX, ']')-1;
                $RegistroX = substr ($RegX, $posIni, $posFim);
        
            }
        
        }

        
        // SELECT * FROM seltickets WHERE registro = '[1787] 1920494.RB - Revisar()';
            $Resulta[][]="";
            $P = 0;		
            $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
            if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection

            //$sql = "SELECT * FROM seltickets WHERE topico LIKE '$TopicoX%' ORDER BY procedimento ASC";	
            if($RegistroX > 0){ 
                $sql = "SELECT * FROM cxseltickets WHERE registro = '$RegistroX'";
                $objFuncao->RegistrarLog("SELECT * FROM cxseltickets WHERE registro = '".$RegistroX."';");
                
            }else{ 
                if(empty($EmpresaX)){  // SE empresas == Vazio, consulta Tipo

                  
                        $sql = "SELECT * FROM cxseltickets ORDER BY data"; 	
                        $objFuncao->RegistrarLog("SELECT * FROM cxseltickets;");
                    
                    

                }else{    
                    $sql = "SELECT * FROM cxseltickets WHERE empresa LIKE '%$EmpresaX%' ORDER BY data"; 	
                    $objFuncao->RegistrarLog("SELECT * FROM cxseltickets WHERE empresa LIKE '%.$EmpresaX.%';");
                    //$sql = "SELECT * FROM seltickets WHERE status LIKE 'Analisan%' OR status LIKE 'Pende%' ORDER BY registro DESC";  
                    //$objFuncao->RegistrarLog("SELECT * FROM seltickets WHERE status LIKE 'Analisan%' OR status LIKE 'Pende%' ORDER BY registro DESC;"); 
                }	
            }		
            		
            $result = mysqli_query($cnxMysql, $sql);		
            while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr		
                $Resulta[$P][_selREG] = $row['registro'];
                $Resulta[$P][_selKeyEstgREG] = $row['keyEstgReg'];
                $Resulta[$P][_selID] = $row['nID']; 
                $Resulta[$P][_selEmpresa] = $row['empresa']; 
                $Resulta[$P][_selProduto] = $row['produto'];                         
                $Resulta[$P][_selSPEED] = $row['speed']; 
                $Resulta[$P][_selTIPO] = $row['tipo']; 
                $Resulta[$P][_selACad] = $row['acadastrar']; 
                $Resulta[$P][_selHIST] = $row['historico'];                             
                $Resulta[$P][_selDATA] = $row['data']; 

                $P++;	
 
            }
            
            $Resulta[_CtgVETOR][_CtgVETOR] = $P;
            $cnxMysql->close();		// Fecha conexao($cnxMySql)
            
            // echo '['.$P.']<br>';    
      

            return $Resulta;
            
    }


    function QueryCxSelTickets_V2($RegX, $Produto, $Tipo, $Cad, $Hist, $EmpresaX, $Origem)
    {	

        $objFuncao = new Funcao();
        $objFuncao->RegistrarLog('Class.SelTickets.QueryCxSelTickets_V1('.$RegX.','.$EmpresaX.','.$Origem.');');
        // echo 'Class.SelTickets.QueryTicketsNew('.$RegX.','.$Produto.', '.$Tipo.', '.$Cad.', '.$Hist.','.$EmpresaX.','.$Origem.'); -> ';
       

        $RegistroX = $RegX;
        if($RegX == 'Selecionar'){ $RegistroX = 1;}
        // Caso chamada a funcao NAO venha de BtAvancarReg...formata Num $RegX 
        // Caso Venha de BtAvancarReg...pega $RegX enviado pela funcao    
        if(str_contains($RegX, '[')){  
                    
            if($RegX != 'Null'){
                $posIni = strpos($RegX, '[')+1;
                $posFim = strpos($RegX, ']')-1;
                $RegistroX = substr ($RegX, $posIni, $posFim);
        
            }
        
        }

        
        // SELECT * FROM seltickets WHERE registro = '[1787] 1920494.RB - Revisar()';
            $Resulta[][]="";
            $P = 0;		
            $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
            if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection

            //$sql = "SELECT * FROM seltickets WHERE topico LIKE '$TopicoX%' ORDER BY procedimento ASC";	
            if($RegistroX > 0){ 
                $sql = "SELECT * FROM cxseltickets WHERE registro = '$RegistroX'";
                $objFuncao->RegistrarLog("SELECT * FROM cxseltickets WHERE registro = '".$RegistroX."';");
                
            }else{ 
                if(empty($EmpresaX)){  // SE empresas == Vazio, consulta Tipo
                    
                    if(str_contains($Produto, 'Ambos')){$Produto = 'P'; }   // IPD, VPN
                    if(str_contains($Tipo, 'Ambos')){$Tipo = 'g'; }         // Descfg, Config
                    
                   if( (str_contains($Cad, 'Todos'))&&(str_contains($Hist, 'Ambos')) ){
                        $sql = "SELECT * FROM cxseltickets WHERE produto like '%$Produto%' and tipo like '%$Tipo%' ORDER BY data"; 	
                        //echo "SELECT * FROM cxseltickets WHERE produto like '%".$Produto."%' and tipo like '%".$Tipo."%' ORDER BY data"."<br>"; 
                        // echo '| Flt-01 |';	
                    }else if( (!str_contains($Cad, 'Todos'))&&(str_contains($Hist, 'Ambos')) ){
                        if(str_contains($Cad, 'Cad')){
                            $sql = "SELECT * FROM cxseltickets WHERE produto like '%$Produto%' and tipo like '%$Tipo%' and aCadastrar like '%$Cad%' ORDER BY data"; 	
                            // echo '| Flt-02-A |';
                        }else{
                            $sql = "SELECT * FROM cxseltickets WHERE produto like '%$Produto%' and tipo like '%$Tipo%' and aCadastrar not like '%Cad%' ORDER BY data"; 	
                            // echo '| Flt-02-B |';	
                        }
                    }else if( (str_contains($Cad, 'Todos'))&&(!str_contains($Hist, 'Ambos')) ){
                        if(str_contains($Hist, 'Hist: Não')){
                            $sql = "SELECT * FROM cxseltickets WHERE produto like '%$Produto%' and tipo like '%$Tipo%' and historico ='' ORDER BY data"; 	
                            // echo '| Flt-03-A |';
                        }else{
                            $sql = "SELECT * FROM cxseltickets WHERE produto like '%$Produto%' and tipo like '%$Tipo%' and historico <>'' ORDER BY data"; 	
                            // echo '| Flt-03-B |';	
                        }    
                    }else{   
                          $sql = "SELECT * FROM cxseltickets WHERE produto like '%$Produto%' and tipo like '%$Tipo%' and aCadastrar like '%$Cad%' and historico <>'' ORDER BY data"; 	
                          // echo '| Flt-04 |';	
                    }
                    //$objFuncao->RegistrarLog("SELECT * FROM cxseltickets;");
                  
                }else{    
                    $sql = "SELECT * FROM cxseltickets WHERE empresa LIKE '%$EmpresaX%' ORDER BY data"; 	
                    $objFuncao->RegistrarLog("SELECT * FROM cxseltickets WHERE empresa LIKE '%.$EmpresaX.%';");
                    //$sql = "SELECT * FROM seltickets WHERE status LIKE 'Analisan%' OR status LIKE 'Pende%' ORDER BY registro DESC";  
                    //$objFuncao->RegistrarLog("SELECT * FROM seltickets WHERE status LIKE 'Analisan%' OR status LIKE 'Pende%' ORDER BY registro DESC;"); 
                }	
            }		
            		
            $result = mysqli_query($cnxMysql, $sql);		
            while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr		
                $Resulta[$P][_selREG] = $row['registro'];
                $Resulta[$P][_selKeyEstgREG] = $row['keyEstgReg'];
                $Resulta[$P][_selID] = $row['nID']; 
                $Resulta[$P][_selEmpresa] = $row['empresa']; 
                $Resulta[$P][_selProduto] = $row['produto'];                         
                $Resulta[$P][_selSPEED] = $row['speed']; 
                $Resulta[$P][_selTIPO] = $row['tipo']; 
                $Resulta[$P][_selACad] = $row['acadastrar']; 
                $Resulta[$P][_selHIST] = $row['historico'];                             
                $Resulta[$P][_selDATA] = $row['data']; 

                $P++;	
 
            }
            
            $Resulta[_CtgVETOR][_CtgVETOR] = $P;
            $cnxMysql->close();		// Fecha conexao($cnxMySql)
            
            // echo '['.$P.']<br>';    
      

            return $Resulta;
            
    }


    function QueryTickets_antigo($RegX, $StatusX, $Origem)
    {	

        $objFuncao = new Funcao();
        $objFuncao->RegistrarLog('Class.SelTickets.QueryTickets('.$RegX.','.$StatusX.','.$Origem.');');
       
        $RegistroX = $RegX;
        if($RegX == 'Selecionar'){ $RegistroX = 1;}
        // Caso chamada a funcao NAO venha de BtAvancarReg...formata Num $RegX 
        // Caso Venha de BtAvancarReg...pega $RegX enviado pela funcao    
        if(str_contains($RegX, '[')){  
                    
            if($RegX != 'Null'){
                $posIni = strpos($RegX, '[')+1;
                $posFim = strpos($RegX, ']')-1;
                $RegistroX = substr ($RegX, $posIni, $posFim);
        
            }
        
        }

        
        // SELECT * FROM seltickets WHERE registro = '[1787] 1920494.RB - Revisar()';
            $Resulta[][]="";
            $P = 0;		
            $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
            if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection

            //$sql = "SELECT * FROM seltickets WHERE topico LIKE '$TopicoX%' ORDER BY procedimento ASC";	
            if($RegistroX > 0){ 
                $sql = "SELECT * FROM seltickets WHERE registro = $RegistroX";
                $objFuncao->RegistrarLog("SELECT * FROM seltickets WHERE registro = '".$RegistroX."';");
                
            }else{ 
                if($StatusX == _TUDO){ 
                    $sql = "SELECT * FROM seltickets"; 	
                    $objFuncao->RegistrarLog("SELECT * FROM seltickets;");
                }else if($StatusX == _ANALISANDO){ 
                    $sql = "SELECT * FROM seltickets WHERE status LIKE 'Analisan%' OR status LIKE 'Pende%' ORDER BY registro DESC";  
                    $objFuncao->RegistrarLog("SELECT * FROM seltickets WHERE status LIKE 'Analisan%' OR status LIKE 'Pende%' ORDER BY registro DESC;"); 
                }else if($StatusX == _NOVOS){ 
                     
                    $sql = "SELECT * FROM seltickets WHERE status LIKE 'Nov%' ORDER BY registro ASC";  
                    $objFuncao->RegistrarLog("SELECT * FROM seltickets WHERE status LIKE 'Nov%' ORDER BY registro ASC;"); 

                }else if($StatusX == _REVISAR){ 
                     
                    $sql = "SELECT * FROM seltickets WHERE status LIKE 'Revi%' OR status LIKE 'Rastr%' ORDER BY registro DESC";  
                    $objFuncao->RegistrarLog("SELECT * FROM seltickets WHERE status LIKE 'Revi%' OR status LIKE 'Rastr%' ORDER BY registro DESC"); 
                }else if($StatusX == _ENCERRADOS){                      
                    $sql = "SELECT * FROM seltickets WHERE status LIKE 'Resol%' OR status LIKE 'Encerra%' OR status LIKE 'Impro%' ORDER BY registro DESC";  
                    $objFuncao->RegistrarLog("SELECT * FROM seltickets WHERE status LIKE 'Resol%' OR status LIKE 'Encerra%' OR status LIKE 'Impro%' ORDER BY registro DESC");  
                }else{ 
                    $sql = "SELECT * FROM seltickets WHERE status = '$StatusX' ORDER BY registro ASC";
                    $objFuncao->RegistrarLog("SELECT * FROM seltickets WHERE status = '$StatusX' ORDER BY registro ASC");
                }
            }			
            		
            $result = mysqli_query($cnxMysql, $sql);		
            while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr		
                $Resulta[$P][_REG] = $row['registro'];
                $Resulta[$P][_ID] = $row['id']; 
                $Resulta[$P][_Empresa] = $row['empresa']; 
                $Resulta[$P][_Produto] = $row['produto'];                         
                $Resulta[$P][_Speed] = $row['speed'];                
                $Resulta[$P][_Status] = $row['status']; 
                $Resulta[$P][_Rascunho] = $row['rascunho'];                 
                $Resulta[$P][_Data] = $row['data']; 

                $P++;	
 
            }
            
            $Resulta[_CtgVETOR][_CtgVETOR] = $P;
            $cnxMysql->close();		// Fecha conexao($cnxMySql)
            
           // echo 'QueryTickets('.$RegX.', '.$StatusX.','.$Origem.') -> '.$P.'<br>';    
      

            return $Resulta;
            
    }


    function filtrarEmpresas()
    {	
        
        // LISTA swa CADASTRADOS no BD
        $Resulta[] = "";
        $P = 0;	
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection
        
        $sql = "SELECT DISTINCT empresa FROM seltickets";
        $result = mysqli_query($cnxMysql, $sql);		
        while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr	
            $Resulta[$P] = $row['empresa'];  
            //printf("%s, ", $Resulta[$P]);                     
            $P++;	
        }            
        $Resulta[_CtgVETOR] = $P;
        $cnxMysql->close();		// Fecha conexao($cnxMySql)
      
        return $Resulta;
            
    }

    function FmtTexto($Texto){

        // Formata Texto enviado, em uma unica Linha, separando em linhas, cfe ocorrencia de palavras 
        $ExplodeTaRas = explode("\n", $Texto);					
        foreach($ExplodeTaRas as $LinTaRas){
            $LinTaRas = str_replace('PEDIDO', "\nPEDIDO", $LinTaRas);
            $LinTaRas = str_replace('ID ', "\nID ", $LinTaRas);
            $LinTaRas = str_replace('ID:', "\nID:", $LinTaRas);
            $LinTaRas = str_replace('NOME_OPERADORA', "\nNOME_OPERADORA", $LinTaRas);
            $LinTaRas = str_replace('CLIENTE', "\nCLIENTE", $LinTaRas);
            $LinTaRas = str_replace('ESTADO', "\nESTADO", $LinTaRas);
            $LinTaRas = str_replace('Estado', "\nEstado", $LinTaRas);
            $LinTaRas = str_replace('REGIONAL', "\nREGIONAL", $LinTaRas);
            $LinTaRas = str_replace('Regional', "\nRegional", $LinTaRas);
            $LinTaRas = str_replace(' CIDADE', "\nCIDADE", $LinTaRas);
            $LinTaRas = str_replace(' Cidade', "\nCidade", $LinTaRas);
            $LinTaRas = str_replace('SERVICO', "\nSERVICO", $LinTaRas);
            $LinTaRas = str_replace('Servico', "\nServico", $LinTaRas);
            $LinTaRas = str_replace('VELOCIDADE', "\nVELOCIDADE", $LinTaRas);
            $LinTaRas = str_replace('Velocidade', "\nVelocidade", $LinTaRas);
            $LinTaRas = str_replace('NUM_ATP', "\nNUM_ATP", $LinTaRas);
            $LinTaRas = str_replace('ATP', "\nATP", $LinTaRas);
            $LinTaRas = str_replace('ETP', "\nETP", $LinTaRas);
            $LinTaRas = str_replace('SITE', "\nSITE", $LinTaRas);
            $LinTaRas = str_replace('Site', "\nSite", $LinTaRas);
            $LinTaRas = str_replace('ERB', "\nERB", $LinTaRas);
            $LinTaRas = str_replace('Erb', "\nErb", $LinTaRas);
            $LinTaRas = str_replace('VRF', "\nVRF", $LinTaRas);
            $LinTaRas = str_replace('INSTALA', "\nINSTALA", $LinTaRas);
            $LinTaRas = str_replace('Observacoes', "\nObservacoes", $LinTaRas);
            $LinTaRas = str_replace('POSICAO', "\nPOSICAO", $LinTaRas);
            $LinTaRas = str_replace('Posicao', "\nPosicao", $LinTaRas);
            $LinTaRas = str_replace('Rede', "\nRede", $LinTaRas);
            $LinTaRas = str_replace('Tarefa', "\nTarefa", $LinTaRas);
            $LinTaRas = str_replace('Dados', "\nDados", $LinTaRas);
            $LinTaRas = str_replace('Operadora', "\nOperadora", $LinTaRas);
            $LinTaRas = str_replace('Produto', "\nProduto", $LinTaRas);
            $LinTaRas = str_replace('Pedido', "\nPedido", $LinTaRas);
            $LinTaRas = str_replace('Cliente', "\nCliente", $LinTaRas);
            $LinTaRas = str_replace('Status', "\nStatus", $LinTaRas);
            $LinTaRas = str_replace('Usuario', "\nUsuario", $LinTaRas);
            $LinTaRas = str_replace('Atividade', "\nAtividade", $LinTaRas);
            $LinTaRas = str_replace('Configurar', "\nConfigurar", $LinTaRas);
            $LinTaRas = str_replace('Desconfigurar', "\nDesconfigurar", $LinTaRas);
            $LinTaRas = str_replace('m-br-', "\nm-br-", $LinTaRas);
            $LinTaRas = str_replace('M-BR-', "\nm-br-", $LinTaRas);
            $LinTaRas = str_replace('C-BR-', "\nm-br-", $LinTaRas);
            $LinTaRas = str_replace('c-br-', "\nm-br-", $LinTaRas);
            $LinTaRas = str_replace('Certo', "\nCerto", $LinTaRas);					
            $LinTaRas = str_replace('STAR - ', "\n#-------------------- STAR - Comentarios -------------------------------------------#", $LinTaRas);					
            $LinTaRas = str_replace('Cmt ###', "\n", $LinTaRas);					
            $LinTaRas = str_replace('### SAE -', "\n#-------------------- SAE - Infos --------------------------------------------------#", $LinTaRas);					
            $LinTaRas = str_replace('Obs ###', "\n", $LinTaRas);					
            $LinTaRas = str_replace('ATCNL:', "\nATCNL:", $LinTaRas);					
            $LinTaRas = str_replace('PRAPS:', "\nPRAPS:", $LinTaRas);					
            $LinTaRas = str_replace('FIBRA:', "\nFIBRA:", $LinTaRas);					
            $LinTaRas = str_replace('SWT:', "\nSWT:", $LinTaRas);					
            $LinTaRas = str_replace('xy:', "\nxy:", $LinTaRas);					
            $LinTaRas = str_replace('Tipo:', "\nTipo:", $LinTaRas);					
        }	
        return $LinTaRas;
				
    }
   
    function DeletarTicket($Tabela, $Reg){
         
        
        $objFuncao = new Funcao();
        $objFuncao->RegistrarLog('Class.selticket.DeletarTicket('.$Tabela.', '.$Reg.');');
        //echo 'Class.selticket.DeletarTicket('.$Tabela.', '.$Reg.')'.'<br>';
               
        
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection
    
        if($Reg == _ClearTAB){ $sql = "DELETE FROM $Tabela WHERE registro > 0 "; }  // Apaga Toda tabela
        else{ 
           // echo "DELETE FROM '$Tabela' WHERE registro='$Reg'";
           if(str_contains($Tabela, 'cxsel')){ 
                //echo "DELETE FROM '$Tabela' WHERE keyEstgReg = '$Reg' "."<br>"; 
                $sql = "DELETE FROM $Tabela WHERE keyEstgReg = '$Reg' "; 
           } // Nesta tabela o registro a Deletar esta em keyEstgReg(chave estrangeira da tab: seltickets)
           else{ 
               // echo "DELETE FROM '$Tabela' WHERE registro = '$Reg' "."<br>"; 
                $sql = "DELETE FROM $Tabela WHERE registro = '$Reg' "; 
           }
        
        } // Exclui registro
        if(mysqli_query($cnxMysql, $sql)){ 
            $cnxMysql->close();	// fecha conexao com BD
            return true; 
        }else{ 
            $cnxMysql->close();	// fecha conexao com BD
            return false; 
        }					
            
        
       
    }  
   
    function ZerarAutoIncrement($Tabela){
         
        
        $objFuncao = new Funcao();
        $objFuncao->RegistrarLog('Class.selticket.ZerarAutoIncrement('.$Tabela.');');
        //echo 'Class.selticket.DeletarTicket('.$Tabela.', '.$Reg.')'.'<br>';
               
        
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection
        $sql = "ALTER TABLE $Tabela AUTO_INCREMENT = 1"; 
       
        if(mysqli_query($cnxMysql, $sql)){ 
            $cnxMysql->close();	// fecha conexao com BD
            return true; 
        }else{ 
            $cnxMysql->close();	// fecha conexao com BD
            return false; 
        }	
       
    }  
   


function preFormatar($Q){
    
if($Q == 0){    
$Res="\n\n
########################### SAE ############################\n.\n.\n
######################### SWA/SWT ##########################\n.\n.\n

######################### BACKBONE #########################\n.\n.\n

######################### ANTERIOR #########################";
}else if($Q == 1){
$Res="
##################### LIBRACAO DE IPs ######################\n    
[Configs 1]==============================================================================================
Lan/Wan/Lo 
-> ID:     
-> DE:    
-> P/:\n\n\n        
[Configs 2]=============================================================================================
Lan/Wan/Lo 
-> ID:     
-> DE:    
-> P/:\n\n\n  
[Configs 3]=============================================================================================
Lan/Wan/Lo 
-> ID:     
-> DE:    
-> P/:\n\n\n  
[Configs 4]============================================================================================
Lan/Wan/Lo 
-> ID:     
-> DE:    
-> P/:\n\n\n  
[Configs 5]===========================================================================================
Lan/Wan/Lo 
-> ID:     
-> DE:    
-> P/:\n\n\n  
############################################################";

}else if($Q == 2){
$Res="\n\n
*** VALIDACAO DE IPs ***\n\n
***     BACKBONE     ***\n\n\n
*** SWA ***\n\n
--- CAD.ERB FIBRADA ---\n\n";
}

return $Res;
}


function GerarCsvTickets()
{	
  
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection

       $sql = "SELECT * FROM seltickets";
     	
                
        $result = mysqli_query($cnxMysql, $sql);		
        while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr		
            $Resulta[$P][_REG] = $row['registro'];
            $Resulta[$P][_ID] = $row['id']; 
            $Resulta[$P][_Empresa] = $row['empresa']; 
            $Resulta[$P][_Produto] = $row['produto'];                
            $Resulta[$P][_Speed] = $row['speed']; 
            $Resulta[$P][_Status] = $row['status']; 
            $Resulta[$P][_Rascunho] = $row['rascunho'];            
            $Resulta[$P][_Data] = $row['data']; 

            for($i=0; $i<35; $i++){
                printf("%s; ", $Resulta[$P][$i]);
            }
            $P++;	

        }
}

function loadListaID($tabela, $arquivo, $tipo){
    /*
     * Deleta dados atuais(se substitiuir), e carrega tabela com arquivo.csv
     */

    // $arquivo="c:/wamp64/bin/mysql/mysql8.2.0/data/rede/BakCmd_22March2024_full.csv";
    //$objFuncao = new Funcao();
    //$objFuncao->RegistrarLog('Class.MySql.RestaureDados('.$tabela.', '.$arquivo.','.$tipo.');');
    
    $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
    if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection

    
    if($tipo == _SUBSTITUIR){ 
    
        if($this->LimparTabela($tabela)){
            echo "LOAD DATA INFILE '$arquivo' INTO TABLE $tabela FIELDS TERMINATED BY ';';"; 
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


function QueryListaID($ID)
{	

    // echo 'QueryHistorico('.$ID.')';
    // SELECT DISTINCT SWA FROM TICKETS;
    $objFuncao = new Funcao();
    $objFuncao->RegistrarLog('Class.MySql.QueryListaID('.$ID.');');
   
        $Resulta[]="";
        $P = 0;		
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection

        $sql = "SELECT status, tecnico FROM listaID WHERE id like '%$ID%'";           	
        //echo "SELECT status, tecnico FROM listaID WHERE id like '%".$ID."%'";   echo "<br>";          	
                
        $result = mysqli_query($cnxMysql, $sql);		
        while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr		
          /*            
            $Resulta[$P][_statusLstID] = $row['status']; 
            $Resulta[$P][_tecnicoLstID] = $row['tecnico'];
            $P++;	
          */  
            $Resulta[_statusLstID] = $row['status']; 
            $Resulta[_tecnicoLstID] = $row['tecnico'];
            //printf("%s", $Resulta[_statusLstID]);
        }
        
        //echo "-> QueryListaID(".$ID.")"; echo "<br>";

        //$Resulta[_CtgVETOR][_CtgVETOR] = $P;
        $cnxMysql->close();		// Fecha conexao($cnxMySql)
        
        return $Resulta;
        
}

function LimparTabela($Tabela){
		
    /* Limpa dados da tabela */
    
    //$objFuncao = new Funcao();
   // $objFuncao->RegistrarLog('Class.MySql.LimparTabela('.$Tabela.');');
    
    $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
    if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection

    if(str_contains($Tabela, 'listaid')){ $sql = "DELETE FROM $Tabela";  }
    else{ $sql = "DELETE FROM $Tabela WHERE registro > 0"; }
    if(mysqli_query($cnxMysql, $sql)){									
        // echo "Todos os dados da tabela: $Tabela foram excluidos! <br>";											
        $Retorno = true;
    }else{
        $Retorno = false;
        // echo "Erro!  Falha de conexao com MySql, registros Nao excluidos. [e301a]";
    }
    
    $cnxMysql->close();	// fecha conexao com BD						
    
    return($Retorno);
    
}




}// Class