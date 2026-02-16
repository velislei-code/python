<?Php


//$file = 'backup/BakCmd_22March2024_full.csv';

$handle = fopen("backup/BakCmd_22March2024_full.csv", "r");
$Armaz[] = "";
$L=0;

if ($handle) {
    while (($line = fgets($handle)) !== false) {

        $Armaz[$L] = $line;
        $L++;
    }
    fclose($handle);



 //   $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
	//if (!$cnxMysql) {	die("Connection failed: " . mysqli_connect_error());	}  // Check connection
			
	
	


    $c=0;
    for($i=0; $i<$L; $i++){

       if($i<$L-1){
            if( (str_contains($Armaz[$i+1],"Telecom;")) 
            ||  (str_contains($Armaz[$i+1],"tica;"))
            ||  (str_contains($Armaz[$i+1],"genda;"))
            ||  (str_contains($Armaz[$i+1],"utros;"))
            ||  (str_contains($Armaz[$i+1],"GPS;"))
            ||  (str_contains($Armaz[$i+1],"ncias;"))            
            ||  (str_contains($Armaz[$i+1],"Redes;"))
            ||  (str_contains($Armaz[$i+1],"dios;"))
            ||  (str_contains($Armaz[$i+1],"Almox;"))
            ){ 
                
                $Reg = $Armaz[$i];
                $Assunto = $Armaz[$i+1];
                $Topico = $Armaz[$i+2];
                $Procedimento = $Armaz[$i+3];
                $Descricao = $Armaz[$i+4];


                //$Comando = $Armaz[$i+5] ate...;
                $Comando = "";
                $Data = "Indefinido";
                // Procura pela linha final de comandos
                $achou = false;
                $linFim = 0;
                for($p=5; $p<1000; $p++){

                    if( (str_contains($Armaz[$i+1],"Telecom;")) 
                    ||  (str_contains($Armaz[$i+1],"tica;"))
                    ||  (str_contains($Armaz[$i+1],"genda;"))
                    ||  (str_contains($Armaz[$i+1],"utros;"))
                    ||  (str_contains($Armaz[$i+1],"GPS;"))
                    ||  (str_contains($Armaz[$i+1],"ncias;"))            
                    ||  (str_contains($Armaz[$i+1],"Redes;"))
                    ||  (str_contains($Armaz[$i+1],"dios;"))
                    ||  (str_contains($Armaz[$i+1],"Almox;"))
                    ){ 
                        $linFim = $p;
                        $achou = true;
                        break;
                        
                    }    
                }
                if($achou){
                    for($t=5; $t<=$linFim; $t++){
                        $Comando = $Comando.$Armaz[$i+$t]."<br>";
                        $achou = false;
                    }
                }    

                echo 'Lin:[5-'.$linFim.']'.'<br>'.'[Reg = '.$Reg.']'.'<br>'.' [Ass = '.$Assunto.']'.'<br>'.'[Top = '.$Topico.']'.'<br>'.'[Proc = '.$Procedimento.']'.'<br>'.'[Desc = '.$Descricao.']'.'<br>'.'[Cmd = '.$Comando.']'.'<br>'.'[Data = '.$Data.']';
                 

                /*
                $sql = "INSERT INTO comandos(assunto, topico, procedimento, descricao, comando, data)	
                VALUE('$Assunto', '$Topico', '$Indice', '$Descricao', '$Comando', '$Data')";			

	            if (mysqli_query($cnxMysql, $sql)) {
                    printf("Lin:[%s] - regX = %s -> %s", $c, $Armaz[$i], $Armaz[$i+1]); echo"<br>";
                    $c++;
	            }
                */
              
                $c++;
               
            }else{
               // printf("%s", $Armaz[$i]); echo"<br>";
            }
       }

    }

    //$cnxMysql->close();		// Fecha conexao($cnxMySql)
	

} else {
// caso dê erro
} 

?>