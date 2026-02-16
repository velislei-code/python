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
 
define("_REG", 0);
define("_ID", 1);
define("_Empresa", 2); 
define("_Produto", 3); 
define("_SWA", 4); 
define("_EDD", 5); 
define("_VlanGer", 6);  
define("_TipoPortaSWA", 7);  
define("_PortSwa", 8); 
define("_SWT", 9); 
define("_SWT_IP", 10); 
define("_RA", 11); 
define("_Router", 12); 
define("_Interface", 13); 
define("_Porta", 14); 
define("_Speed", 15); 
define("_VidUnit", 16); 
define("_PolicyIN", 17); 
define("_PolicyOUT", 18); 
define("_Vrf", 19); 
define("_sVlan", 20); 
define("_cVlan", 21); 
define("_Lan", 22); 
define("_Wan", 23); 
define("_RtIntragov", 24); 
define("_LoopBack", 25); 
define("_Lan6", 26); 
define("_Wan6", 27); 
define("_Status", 28); 
define("_FiltroEmp", 29); 
define("_Rascunho", 30);  
define("_ReverTunnel", 31);  
define("_Backbone", 32);  
define("_Data", 33); 
define("_ShelfSwa", 34);
define("_SlotSwa", 35);
define("_OPERADORA", 36); 
define("_IdFlow", 37); 
define("_Tipo", 38); 
define("_WanFx", 39); 

define("_StatusCompara", 40); 

define("_TUDO", 0);  
define("_NOVOS", 1);  
define("_ANALISANDO", 2);  
define("_REVISAR", 3);
define("_ENCERRADOS", 4); 
define("_HOJE", 5); 

define("_CtgVETOR", 100); // Contagem num.elem.matriz/vetor 
define("_TotENCERRADOS", 300); // Contagem num.elem.matriz/vetor 
define("_SUBSTITUIR", 1); 

define("_ClearTAB", 7022); // Code para limpar todos os registros da Tabela
define("_AutorizaDEL", 7027); // Code para limpar registro registros da Tabela

define('_nRESOLVIDOS', 0);
define('_MEDIA', 1);
define('_PROJECAO', 2);

// Tipo de configuracao(padroes)
define('_NaoDefinido', 0);
define('_rtVIVO', 1);           // Lan/29, Wan/31, Lo/32 - router Vivo 
define('_rtCLIENTE', 2);        // Lan/29, Wan/30, sem Lo - router Cliente
define('_FUST', 3);             // sem Lan, Wan/30, sem Lo - router: verificar
define('_AnmHOLDI', 4);         // Lan/28, Wan/31, sem Lo - router: verificar

include_once("Class.funcao.php");


class Tickets {

    				
    function AddTicket($Registro, $ID, $Empresa, $Produto, $Tipo, $IdFlowX, $SWA, $EDD, $OPER, $VlanGer, $tipoPortaSwa, $ShelfSwa, $SlotSwa, $PortSwa, $SWT, $SWT_IP, $RA, $Router, $Interface, $Porta, $Speed, $VidUnit, $PolicyIN, $PolicyOUT, $Vrf, $sVlan, $cVlan, $Lan, $Wan, $WanFx, $LoopBack, $Lan6, $Wan6, $TaRotasIntragov, $Status, $Rascunho, $ReverTunnel, $Backbone)  
    {	

        $objFuncao = new Funcao();
        $objFuncao->RegistrarLog('Class.MySql.AddTicket('.$Registro.','. $ID.','. $Empresa.','. $Produto.','. $IdFlowX.','. $SWA.','. $EDD.','. $OPER.','. $VlanGer.','. $SlotSwa.','. $PortSwa.','. $SWT.','. $SWT_IP.','. $RA.','. $Router.','. $Interface.','. $Porta.','. $Speed.','. $VidUnit.','. $PolicyIN.','. $PolicyOUT.','. $Vrf.','. $sVlan.','. $cVlan.','. $Lan.','. $Wan.','. $LoopBack.','. $Lan6.','. $Wan6.','. $Status.','. $Rascunho.','. $ReverTunnel.','.$Backbone.')');  
    

       if(str_contains($Status, 'Ana')){ 
            //$Rascunho = '\n\n\n*** REGISTRO AUTO-DUPLICADO ***\n'.$Rascunho;
            $Status = 'Analisando'; 
        }
        else{ 
            $Status = 'Novo'; 
            $Rascunho = $this->preFormatar(0);
            $ReverTunnel = $this->preFormatar(1);
            //$Backbone = $this->preFormatar(2);
        }
        $Res = 0;
        //$Data = Date("d/m/Y");
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection
                
        
        $sql = "INSERT INTO tickets(id, empresa, produto, tipo, id_flow, swa, edd, operadora, vlan_ger, tipoPorta_swa, shelf_swa, slot_swa, port_swa, swt, swt_ip, rede_acesso, router, interface, porta, speed, vid_unit, policyIN, policyOUT, vrf, svlan, cvlan, lan, wan, wan_fx, loopback, lan6, wan6, rotas_intragov, status, rascunho, rever_tunnel, backbone, data)	
                VALUE('$ID', '$Empresa', '$Produto', '$Tipo', '$IdFlowX', '$SWA', '$EDD', '$OPER', '$VlanGer', '$tipoPortaSwa', '$ShelfSwa', '$SlotSwa', '$PortSwa', '$SWT', '$SWT_IP', '$RA', '$Router', '$Interface', '$Porta', '$Speed', '$VidUnit', '$PolicyIN', '$PolicyOUT', '$Vrf', '$sVlan', '$cVlan', '$Lan', '$Wan', '$WanFx', '$LoopBack', '$Lan6', '$Wan6', '$TaRotasIntragov', '$Status', '$Rascunho', '$ReverTunnel', '$Backbone', '')";			

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

                        

    function SalvarTicket($Reg, $ID, $Empresa, $Produto, $Tipo, $IdFlowX, $SWA, $EDD, $OPER, $VlanGer, $tipoPortaSwa, $ShelfSwa, $SlotSwa, $PortSwa, $SWT, $SWT_IP, $RA, $Router, $Interface, $Porta, $Speed, $VidUnit, $PolicyIN, $PolicyOUT, $Vrf, $sVlan, $cVlan, $Lan, $Wan, $WanFx, $LoopBack, $Lan6, $Wan6, $TaRotasIntragov, $Status, $Rascunho, $ReverTunnel, $Backbone, $cfgBackbone)
    {	

        $objFuncao = new Funcao();
        $objFuncao->RegistrarLog('Class.Ticket.SalveTicket('.$Reg.','. $ID.','. $Empresa.','. $Produto.','. $IdFlowX.','. $SWA.','. $EDD.','. $OPER.','. $VlanGer.','. $SlotSwa.','. $PortSwa.','. $SWT.','. $SWT_IP.','. $RA.','. $Router.','. $Interface.','. $Porta.','. $Speed.','. $VidUnit.','. $PolicyIN.','. $PolicyOUT.','. $Vrf.','. $sVlan.','. $cVlan.','. $Lan.','. $Wan.','. $LoopBack.','. $Lan6.','. $Wan6.','. $Status.', $Rascunho, $ReverTunnel, $Backbone,'. $cfgBackbone.')');
        
       //echo 'Salvar->: '.$ID.', CALL: '.$Call;

         
       // Se viver vazio, joga para REG-Agenda
       if(str_contains($Reg, 'Selecionar')){ $Reg = '[1001]';   }
       //echo 'Class.MySql.SalvarTickets('.$Reg.');';


        if($Speed > 400){
        ?>
            <script>
                    // alert("Atencao! Circuito acima de 400M, possivel projeto especial, ver com Rodrigo.");   
                    // resourses/js/alert.js
                    setTimeout(function(){
                        msgFrmApagado();
                    }, 1000);
           
            </script>
        <?Php
        } 

       if($ID != '' && $Status == 'Novo'){ $Status = 'Analisando'; }
        //echo '['.$Reg.']'.'<br>';

        if(str_contains($Reg, '[')){
            $posIni = strpos($Reg, '[')+1;
            $posFim = strpos($Reg, ']')-1;
            $Registro = substr ($Reg, $posIni, $posFim);
        }else{
            $Registro = $Reg;   
        }

        if($Reg == 'Selecionar'){ $Registro = 0;}
        //echo '['.$Registro.']'.'<br>';
        //echo "Entrei Class.salvar aki-1"."<br>";

        //echo 'SalvarTicket->'.$Reg.', '.$ID.', '.$Empresa.', '.$Porta.', '.$Speed.', '.$VidUnit.', '.$PolicyIN.', '.$PolicyOUT.', '.$sVlan.', '.$cVlan.', '.$Lan.', '.$Wan.', '.$LoopBack.', '.$Lan6.', '.$Wan6, $Status; //.', '.$Rascunho;


        $resultado = true;
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection
    
        
        // Testa se Registro ja foi Finalizado, proteger de alteracoes
        $sqlTST = "SELECT registro, status FROM tickets WHERE registro = $Registro AND (status LIKE '%solvido%' OR status LIKE '%cedente')";	// Resol-vido, Improcedente
        $resultTST = mysqli_query($cnxMysql, $sqlTST);		
        if(mysqli_fetch_assoc($resultTST) && $Status != 'UnLock') {  // fetch associative arr		
            $resultado = false;            
            //$objFuncao->Mensagem('Atencao!', 'Nao foi possivel Alterar registro, o mesmo ja foi finalizado', Null, Null, defAviso, defAtencao);

            ?>
                <script>
                    setTimeout(function(){
                        msgTicketBlock();
                    }, 1000);
                </script>
            <?Php

        }else{

            
            // Protecao contra salvar registro com TaRascunho Vazio(Apagar) 
            // - Ocorre pela rotina: if( (isset($_POST['BtSalvar']))||(isset($_POST['CxRouter'])) ){ 
            // Esta rotina permite que todos os botoes, Copiar, salvem registro(Maior protecao contra perda de dados)
            if( (!empty($Rascunho)) && (str_contains($Rascunho, 'I'))){  

                if($Status == 'UnLock'){ $Status = 'Analisando'; }
                if( (str_contains($Status, 'Resolvi'))
                ||  (str_contains($Status, 'Limp')) 
                ||  (str_contains($Status, 'Desist')) 
                ||  (str_contains($Status, 'Improc')) ){ 
                    $Data = date("d/m/Y");  
                    $Edicao = $Status.' - '.$Data;

                    $Rascunho = $Rascunho.'\n'.$Edicao;
                    $Backbone = $Edicao.'\n'.$Backbone;
                }else{
                    $Data = '';
                }
                // Devido Funcionamento TextArea ReverTunnel/Backbone - Maostra/Ocultar - qdo esta oculto nao envia Dados, entao bloqueio Update   
                // Aqui Salva tudo menos backBone  
                if($ReverTunnel != ''){
                    $sql = "UPDATE tickets SET  id='$ID', 
                                        empresa='$Empresa', 
                                        produto='$Produto', 
                                        tipo='$Tipo', 
                                        id_flow='$IdFlowX', 
                                        swa='$SWA', 
                                        edd='$EDD', 
                                        operadora='$OPER', 
                                        vlan_ger='$VlanGer', 
                                        tipoPorta_swa='$tipoPortaSwa', 
                                        shelf_swa='$ShelfSwa', 
                                        slot_swa='$SlotSwa', 
                                        port_swa='$PortSwa', 
                                        swt='$SWT', 
                                        swt_ip='$SWT_IP', 
                                        rede_acesso='$RA', 
                                        router='$Router', 
                                        interface='$Interface', 
                                        porta='$Porta', 
                                        speed='$Speed', 
                                        vid_unit='$VidUnit', 
                                        policyIN='$PolicyIN', 
                                        policyOUT='$PolicyOUT', 
                                        vrf='$Vrf', 
                                        svlan='$sVlan', 
                                        cvlan='$cVlan', 
                                        lan='$Lan', 
                                        wan='$Wan', 
                                        wan_fx='$WanFx', 
                                        loopback='$LoopBack', 
                                        lan6='$Lan6', 
                                        wan6='$Wan6', 
                                        rotas_intragov='$TaRotasIntragov',
                                        status='$Status', 
                                        rascunho='$Rascunho', 
                                        rever_tunnel='$ReverTunnel',
                                        data='$Data'
                                        WHERE registro = $Registro";
                // Devido Funcionamento TextArea ReverTunnel/Backbone - Maostra/Ocultar - qdo esta oculto nao envia Dados, entao bloqueio Update   
                // Aqui Salva tudo menos ReverTunnel  - $cfgBackbone == 1 confirma que TextArea esta abero(protecao para Colar Carimbo, nao ser alterado) 
                }else if($Backbone != '' && $cfgBackbone == 1){
                    $sql = "UPDATE tickets SET  id='$ID', 
                                        empresa='$Empresa', 
                                        produto='$Produto', 
                                        tipo='$Tipo',
                                        id_flow='$IdFlowX',
                                        swa='$SWA', 
                                        edd='$EDD',
                                        operadora='$OPER',
                                        vlan_ger='$VlanGer',
                                        tipoPorta_swa='$tipoPortaSwa', 
                                        shelf_swa='$ShelfSwa', 
                                        slot_swa='$SlotSwa',
                                        port_swa='$PortSwa', 
                                        swt='$SWT', 
                                        swt_ip='$SWT_IP', 
                                        rede_acesso='$RA', 
                                        router='$Router', 
                                        interface='$Interface', 
                                        porta='$Porta', 
                                        speed='$Speed', 
                                        vid_unit='$VidUnit', 
                                        policyIN='$PolicyIN', 
                                        policyOUT='$PolicyOUT', 
                                        vrf='$Vrf', 
                                        svlan='$sVlan', 
                                        cvlan='$cVlan', 
                                        lan='$Lan', 
                                        wan='$Wan', 
                                        wan_fx='$WanFx',
                                        loopback='$LoopBack', 
                                        lan6='$Lan6', 
                                        wan6='$Wan6', 
                                        rotas_intragov='$TaRotasIntragov',
                                        status='$Status', 
                                        rascunho='$Rascunho',                                     
                                        backbone='$Backbone', 
                                        data='$Data'
                                        WHERE registro = $Registro";
                // Devido Funcionamento TextArea ReverTunnel/Backbone - Maostra/Ocultar - qdo esta oculto nao envia Dados, entao bloqueio Update   
                // Aqui Salva tudo menos ReverTunnel/Backbone(ambos estao ocultos)  
                }else{
                    $sql = "UPDATE tickets SET  id='$ID', 
                                        empresa='$Empresa', 
                                        produto='$Produto',
                                        tipo='$Tipo', 
                                        id_flow='$IdFlowX',
                                        swa='$SWA', 
                                        edd='$EDD',
                                        operadora='$OPER',
                                        vlan_ger='$VlanGer',
                                        tipoPorta_swa='$tipoPortaSwa',
                                        shelf_swa='$ShelfSwa',  
                                        slot_swa='$SlotSwa',
                                        port_swa='$PortSwa', 
                                        swt='$SWT', 
                                        swt_ip='$SWT_IP', 
                                        rede_acesso='$RA', 
                                        router='$Router', 
                                        interface='$Interface', 
                                        porta='$Porta', 
                                        speed='$Speed', 
                                        vid_unit='$VidUnit', 
                                        policyIN='$PolicyIN', 
                                        policyOUT='$PolicyOUT', 
                                        vrf='$Vrf', 
                                        svlan='$sVlan', 
                                        cvlan='$cVlan', 
                                        lan='$Lan', 
                                        wan='$Wan',
                                        wan_fx='$WanFx', 
                                        loopback='$LoopBack', 
                                        lan6='$Lan6', 
                                        wan6='$Wan6',
                                        rotas_intragov='$TaRotasIntragov', 
                                        status='$Status', 
                                        rascunho='$Rascunho',
                                        data='$Data'
                                        WHERE registro = $Registro";
                }
                $result = mysqli_query($cnxMysql, $sql);
                if (!$result) {
                    $resultado = false;		
                    echo "Erro! Nao foi possivel salvar o registro o banco de dados[e101c2]"."<br>";
                    //echo 'Erro MySQL: '.mysql_error().'<br>';
                    exit;
                }else{     
                    // $objFuncao->Mensagem('Atencao!', 'Registro['.$Registro.'] salvo com sucesso!', Null, Null, defAviso, Null);

                }
            }else{ // Protecao contra apagar acidentalmente o registro
                 $avMsg = "ERRO! Tentativa de salvar registro enviado Vazio! A ação foi Bloqueada.";  
            //----------------------------------------------------------------------------------//
           
            ?>
                <div class="placaFx" id="avMsgRegVazio" title="<?Php printf("%s", $avMsg); ?>">	
                    <input i class="fa fa-search" type="image" src="imagens/icon/lampada.ico" style="max-widht:30px; max-height:30px;">									
                    <?Php
                        echo $avMsg;
                    ?>	
                </div>
            <?Php 

            //----------------------------------------------------------------------------------//    
            
            
            }    
        }

        $cnxMysql->close();		// Fecha conexao($cnxMySql)
        if($cfgBackbone == 0){
            ?>             
                <script>
                    setTimeout(function(){
                        msgTaBBoneClose();
                    }, 1000);
                </script>
            <?Php            
        }

        return $resultado;
            
    }

    function LimparTicket($CodeAutoriza, $RegX, $ID, $Empresa, $Produto, $Tipo, $IdFlowX, $SWA, $EDD, $OPER, $VlanGer, $tipoPortaSwa, $ShelfSwa, $SlotSwa, $PortSwa, $SWT, $SWT_IP, $RA, $Router, $Interface, $Porta, $Speed, $VidUnit, $PolicyIN, $PolicyOUT, $Vrf, $sVlan, $cVlan, $Lan, $Wan, $WanFx, $LoopBack, $Lan6, $Wan6, $TaRotasIntragov, $Status, $Rascunho, $ReverTunnel, $BackBone, $cfgBackbone)
    {	

        $objFuncao = new Funcao();
        $objFuncao->RegistrarLog('Class.Ticket.LimparTicket('.$RegX.','. $ID.','. $Empresa.','. $Produto.','. $IdFlowX.','. $SWA.','. $EDD.','. $OPER.','. $VlanGer.','. $SlotSwa.','. $PortSwa.','. $SWT.','. $SWT_IP.','. $RA.','. $Router.','. $Interface.','. $Porta.','. $Speed.','. $VidUnit.','. $PolicyIN.','. $PolicyOUT.','. $Vrf.','. $sVlan.','. $cVlan.','. $Lan.','. $Wan.','. $LoopBack.','. $Lan6.','. $Wan6.','. $Status.', $Rascunho, $ReverTunnel, $Backbone,'. $cfgBackbone.')');
        
       
        $resultado = true;
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection
    
        if(str_contains($RegX, '[')){
            $posIni = strpos($RegX, '[')+1;
            $posFim = strpos($RegX, ']')-1;
            $Reg = substr ($RegX, $posIni, $posFim);
        }else{
            $Reg = $RegX;   
        }

        if($RegX == 'Selecionar'){ $Reg = 0;}
        
        
        // Testa se Registro ja foi Finalizado, proteger de alteracoes
        $sqlTST = "SELECT registro, status FROM tickets WHERE registro = $Reg AND (status LIKE '%solvido%' OR status LIKE '%cedente')";	// Resol-vido, Improcedente
        $resultTST = mysqli_query($cnxMysql, $sqlTST);		
        if(mysqli_fetch_assoc($resultTST) && $Status != 'UnLock') {  // fetch associative arr		
            $resultado = false;            
            //$objFuncao->Mensagem('Atencao!', 'Nao foi possivel Alterar registro, o mesmo ja foi finalizado', Null, Null, defAviso, defAtencao);

            ?>
                <script>
                    setTimeout(function(){
                        msgTicketBlock();
                    }, 1000);
                </script>
            <?Php

        }else{

            if($CodeAutoriza == _AutorizaDEL){  
                    $sql = "UPDATE tickets SET  id='$ID', 
                            empresa='$Empresa', 
                            produto='$Produto',
                            tipo='$Tipo', 
                            id_flow='$IdFlowX',
                            swa='$SWA', 
                            edd='$EDD',
                            operadora='$OPER',
                            vlan_ger='$VlanGer',
                            tipoPorta_swa='$tipoPortaSwa',
                            shelf_swa='$ShelfSwa',  
                            slot_swa='$SlotSwa',
                            port_swa='$PortSwa', 
                            swt='$SWT', 
                            swt_ip='$SWT_IP', 
                            rede_acesso='$RA', 
                            router='$Router', 
                            interface='$Interface', 
                            porta='$Porta', 
                            speed='$Speed', 
                            vid_unit='$VidUnit', 
                            policyIN='$PolicyIN', 
                            policyOUT='$PolicyOUT', 
                            vrf='$Vrf', 
                            svlan='$sVlan', 
                            cvlan='$cVlan', 
                            lan='$Lan', 
                            wan='$Wan',
                            wan_fx='$WanFx', 
                            loopback='$LoopBack', 
                            lan6='$Lan6', 
                            wan6='$Wan6', 
                            rotas_intragov='$TaRotasIntragov',
                            status='$Status', 
                            rascunho='$Rascunho',
                            rever_tunnel='$ReverTunnel',
                            backbone='$BackBone'                                        
                            WHERE registro = $Reg";
                
                $result = mysqli_query($cnxMysql, $sql);
                if (!$result) {
                    $resultado = false;		
                    echo "Erro! Nao foi possivel salvar o registro o banco de dados[e101c2]"."<br>";
                    //echo 'Erro MySQL: '.mysql_error().'<br>';
                    exit;
                }else{     
                    // $objFuncao->Mensagem('Atencao!', 'Registro['.$Registro.'] salvo com sucesso!', Null, Null, defAviso, Null);

                }
            }
        }

        $cnxMysql->close();		// Fecha conexao($cnxMySql)
        if($cfgBackbone == 0){
            ?>             
                <script>
                    setTimeout(function(){
                        msgTaBBoneClose();
                    }, 1000);
                </script>
            <?Php            
        }

        return $resultado;
            
    }


    function SalvarReverTunnel($Reg, $ReverTunnel)
    {	
        // Funcao de atualizacao de Formato de ReverTunnel
        $resultado = false;
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection
      
        $sql = "UPDATE tickets SET rever_tunnel='$ReverTunnel' WHERE registro = $Reg";
        
        $result = mysqli_query($cnxMysql, $sql);
        if (!$result) {
            $resultado = false;		
            echo "Erro! Nao foi possivel salvar o registro o banco de dados[e101c2]"."<br>";
            //echo 'Erro MySQL: '.mysql_error().'<br>';
            exit;
        }else{    
            $resultado = true; 
             // $objFuncao->Mensagem('Atencao!', 'Registro['.$Registro.'] salvo com sucesso!', Null, Null, defAviso, Null);

        }

        $cnxMysql->close();		// Fecha conexao($cnxMySql)
        
        return $resultado;
            
    }
    function Carimbar($Reg, $Carimbo)
    {	
        //echo ">>> A1"."<BR>"; 
        $objFuncao = new Funcao();
        //$objFuncao->RegistrarLog('Class.Ticket.SalveTicket('.$Registro.','.$Assunto.','.$Topico.','.$Indice.','.$Descricao.','.$Comando.');');
        $objFuncao->RegistrarLog('Class.Ticket.Carimbar()');
        
        $TaBackbone = $this->LoadBackbone($Reg); // Pega conteudo atual de backbone
        $AddCarimbo = $TaBackbone.$Carimbo; // Adiciona o carimbo, e salva abaixo
        
        $resultado = true;
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection
         

        // Testa se Registro ja foi Finalizado, proteger de alteracoes
        $sqlTST = "SELECT registro, status FROM tickets WHERE registro = $Reg AND (status LIKE '%vido' OR status LIKE '%cedente')";	// Resol-vido,Improcedente
        $resultTST = mysqli_query($cnxMysql, $sqlTST);		
        if(mysqli_fetch_assoc($resultTST)) {  // fetch associative arr		
            $resultado = false;            
            //$objFuncao->Mensagem('Atencao!', 'Nao foi possivel Alterar registro, o mesmo ja foi finalizado', Null, Null, defAviso, defAtencao);
            //echo ">>> A2 - Erro"."<BR>"; 
            ?>
                <script>
                    setTimeout(function(){
                        msgTicketBlock();
                    }, 1000);
                </script>
            <?Php

        }else{
            //echo ">>> A3 - Salvou"."<BR>"; 
            $sql = "UPDATE tickets SET  backbone='$AddCarimbo'  WHERE registro = '$Reg'";
            $result = mysqli_query($cnxMysql, $sql);
            if (!$result) {
                $resultado = false;		
                echo "Erro! Nao foi possivel salvar o registro o banco de dados[e101c2]"."<br>";
                //echo 'Erro MySQL: '.mysql_error().'<br>';
                exit;
            }else{     
                    // $objFuncao->Mensagem('Atencao!', 'Registro['.$Registro.'] salvo com sucesso!', Null, Null, defAviso, Null);
            }
        }    

        $cnxMysql->close();		// Fecha conexao($cnxMySql)
       
        return $resultado;
            
    }

    function LoadBackbone($Reg){	
    // Consulta conteudo do TEXT backbone, para acrescetar carimbo-SWA acima
    // Le campo BBone, e Soma carimbo ao BBone
   
           
            if(str_contains($Reg, '[')){
                $Reg = substr($Reg, 1, 4);
            }
            $Resulta="";
           
            $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
            if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection
          
            $sql = "SELECT backbone FROM tickets WHERE registro='$Reg'";               
            		
            $result = mysqli_query($cnxMysql, $sql);		
            while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr		
                $Resulta = $row['backbone'];                            
            }                      
            $cnxMysql->close();		// Fecha conexao($cnxMySql)
            
            return $Resulta;
            
    }
    function LoadVrf(){	
    // Consulta lista de empresa e suas Vrf
        
            $Resulta[][]="";
            $P=0;
           
            $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
            if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection
          
            //$sql = "SELECT DISTINCT produto, empresa, vrf FROM tickets WHERE produto LIKE '%VPN%' AND vrf<>'' ORDER BY empresa, vrf";               
            // Pega da Tabela: tickets => $sql = "SELECT DISTINCT empresa, vrf FROM tickets WHERE produto LIKE '%VPN%' AND vrf<>'' ORDER BY vrf";               
            $sql = "SELECT DISTINCT empresa, vrf FROM vrf WHERE vrf<>'' ORDER BY vrf";               
            		
            $result = mysqli_query($cnxMysql, $sql);		
            while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr		
                $Resulta[$P][_Empresa] = $row['empresa'];                            
                $Resulta[$P][_Vrf] = $row['vrf'];  
                //printf('%d: %s', $P, $row['vrf']); echo '<br>';
                // Atenção! Carga já foi dada: $this->CarregueVrf($Resulta[$P][_Empresa], $Resulta[$P][_Vrf]);
                $P++;                          
            }                      
            $cnxMysql->close();		// Fecha conexao($cnxMySql)
            
            $Resulta[_CtgVETOR][_CtgVETOR] = $P;
            return $Resulta;
            
    }
    function CarregueVrf($Empresa, $Vrf){
        
        $Res = false;
        //$Data = Date("d/m/Y");
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection
                
        
        $sql = "INSERT INTO vrf(empresa, vrf) VALUE('$Empresa', '$Vrf')";			

        if (!mysqli_query($cnxMysql, $sql)) {
            $Res = false;		// echo "3 - Erro do banco de dados, Nao foi possivel consultar o banco de dados\n";
                                    // echo '4 - Erro MySQL: '.mysql_error();
            //exit;
        }else{
            $Res = true;  // Num.Reg inserido
        }
        $cnxMysql->close();		// Fecha conexao($cnxMySql)
       
        return $Res;

    }

    function ContaResolvidos(){	
        // Consulta conteudo do TEXT backbone, para acrescetar carimbo-SWA acima
                
        $Resulta[] = 0;
        $P = 0;
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection
        
        $Hoje = date("d/m/Y");
        $Hora = date("H");
        $Min = date("i");
        
        $sql = "SELECT COUNT(registro) AS registro FROM tickets where status LIKE '%Resolvido' AND data='$Hoje'";               
                
        $result = mysqli_query($cnxMysql, $sql);		
        while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr		
            $Resulta[_nRESOLVIDOS] = $row['registro'];                            
        }                      
        $cnxMysql->close();		// Fecha conexao($cnxMySql)
        
        // teste $Resulta[_nRESOLVIDOS] = 12; 

        // Projecao de exec.no dia
        if($Resulta[_nRESOLVIDOS] > 0){
            if($Hora < 8){
                $Resulta[_MEDIA] = ((($Hora - 6)*60)+$Min) / $Resulta[_nRESOLVIDOS]; // Media em minutos p/ config 
                //echo"pjc-01 ";
            }else if($Hora < 9){
                $Resulta[_MEDIA] = $Min / $Resulta[_nRESOLVIDOS]; // Media em minutos p/ config 
                //echo"pjc-02 ";

            }else if($Hora < 13){
                if($Resulta[_nRESOLVIDOS] >0){
                    $Resulta[_MEDIA] = ((($Hora - 8)*60)+$Min) / $Resulta[_nRESOLVIDOS]; // Media em minutos p/ config
                   // $T = ((($Hora - 8)*60)+$Min);
                    //echo"pjc-03 ".$T." - ";

                }else{ $Resulta[_MEDIA] = 60; }            
            }else  if($Hora >= 13){  
                $Resulta[_MEDIA] = ((($Hora - 9)*60)+$Min) / $Resulta[_nRESOLVIDOS]; // Num.config / hora -> * 8 horas
               // echo"pjc-04 ";

            }
            if($Resulta[_MEDIA] < 1){ $Resulta[_MEDIA] = 1; }  // Evita Erro divisao por Zero
            $Resulta[_PROJECAO] = (9*60) / $Resulta[_MEDIA]; // Num.config / hora -> * 8 horas
            //echo"pjc-05";

        }else{
            $Resulta[_nRESOLVIDOS] = 0;
            $Resulta[_MEDIA] = 45;
            $Resulta[_PROJECAO] = 0;

        }
        return $Resulta;
                
    }
    

    function ContaID($IdX){	
        // Consulta conteudo do TEXT backbone, para acrescetar carimbo-SWA acima
       
        
        $Resulta=''; 
        $Ret='';   
        //$P = 0;    
        
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection
        
        $sql = "SELECT COUNT(registro) AS registro FROM tickets where id LIKE '%$IdX%'";               
                
        $result = mysqli_query($cnxMysql, $sql);		
        while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr		
            $Resulta = $row['registro'];
            //echo 'RES= '.$Resulta;
            //$P++;
                                   
        }                      
        $cnxMysql->close();		// Fecha conexao($cnxMySql)
        
        if( $Resulta > 1 && $Resulta < 30){ // entre 1 e 30(se deixar vazio aparece uns numeros loucos acima de 100)
            ?>
                <script>
                        //alert("Atencao! Ja existe registros com este ID.");    
                </script>
            <?Php
            //$Ret = "ID  ja existe!"; 
            //echo '<span style="color:#ff0000;text-align:center;">'.$Ret.' </span>';
            return true;
        }else{ return false; }                 
    }
    
    function ContaSWA($SwaX){	
        // Consulta se SWa ja existe no BD      
        
        $Resulta='';    
        //$P = 0;    
        
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection
        
        $sql = "SELECT COUNT(registro) AS registro FROM tickets where swa LIKE '%$SwaX%'";               
                
        $result = mysqli_query($cnxMysql, $sql);		
        while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr		
            $Resulta = $row['registro'];
            //echo 'RES= '.$Resulta;
            //$P++;
                                   
        }                      
        $cnxMysql->close();		// Fecha conexao($cnxMySql)
        
        if( $Resulta > 1 && $Resulta < 30){ // entre 1 e 30(se deixar vazio aparece uns numeros loucos acima de 100)
            ?>
                <script>
                    // alert("Atencao! Ja existe registros com este SWA.");    
                </script>
            <?Php
            //$Ret = "SWA ja existe!";
            //echo '<span style="color:#ff0000;text-align:center;">'.$Ret.'</span>';

            return true;
        }else{ return false; }   
                      
    }

    function QueryTickets($RegX, $StatusX, $Origem)
    {	

        $objFuncao = new Funcao();
        $objFuncao->RegistrarLog('Class.MySql.QueryTickets('.$RegX.','.$StatusX.','.$Origem.');');
        $hoje = date('d/m/Y');

        //echo $hoje;
       // Se viver vazio, joga para REG-Agenda
        if(str_contains($RegX, 'Selecionar')){ $RegX = '[1001]';   }
        //echo 'Class.MySql.QueryTickets('.$RegX.','.$StatusX.','.$Origem.');';

        $RegistroX = $RegX;
        
        if($RegX == 'Selecionar'){ $RegistroX = 1001;}

        // Caso chamada a funcao NAO venha de BtAvancarReg...formata Num $RegX 
        // Caso Venha de BtAvancarReg...pega $RegX enviado pela funcao    
        if(str_contains($RegX, '[')){  
                    
            if($RegX != 'Null'){
                $posIni = strpos($RegX, '[')+1;
                $posFim = strpos($RegX, ']')-1;
                $RegistroX = substr ($RegX, $posIni, $posFim);
         
            }
        
        }

        //echo '>>>>>'.$RegistroX;
        // SELECT * FROM tickets WHERE registro = '[1787] 1920494.RB - Revisar()';
            $Resulta[][]="";
            $P = 0;		
            $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
            if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection

            //$sql = "SELECT * FROM tickets WHERE topico LIKE '$TopicoX%' ORDER BY procedimento ASC";	
            if($RegistroX > 0){ 
                $sql = "SELECT * FROM tickets WHERE registro = $RegistroX";
                $objFuncao->RegistrarLog("SELECT * FROM tickets WHERE registro = '".$RegistroX."';");
                
            }else{ 
                if($StatusX == _TUDO){ 
                    $sql = "SELECT * FROM tickets"; 	
                    $objFuncao->RegistrarLog("SELECT * FROM tickets;");
                }else if($StatusX == _ANALISANDO){ 
                    $sql = "SELECT * FROM tickets WHERE status LIKE 'Analisan%' OR status LIKE 'Pende%' ORDER BY registro DESC";  
                    $objFuncao->RegistrarLog("SELECT * FROM tickets WHERE status LIKE 'Analisan%' OR status LIKE 'Pende%' ORDER BY registro DESC;"); 
                }else if($StatusX == _NOVOS){ 
                     
                    $sql = "SELECT * FROM tickets WHERE status LIKE 'Nov%' ORDER BY registro ASC";  
                    $objFuncao->RegistrarLog("SELECT * FROM tickets WHERE status LIKE 'Nov%' ORDER BY registro ASC;"); 

                }else if($StatusX == _REVISAR){ 
                     
                    $sql = "SELECT * FROM tickets WHERE status LIKE 'Revi%' OR status LIKE 'Rastr%' ORDER BY registro DESC";  
                    $objFuncao->RegistrarLog("SELECT * FROM tickets WHERE status LIKE 'Revi%' OR status LIKE 'Rastr%' ORDER BY registro DESC"); 
                }else if($StatusX == _ENCERRADOS){                      
                    $sql = "SELECT * FROM tickets WHERE status LIKE 'Resol%' OR status LIKE 'Encerra%' OR status LIKE 'Impro%' OR status LIKE 'Desist%' ORDER BY registro DESC";  
                    $objFuncao->RegistrarLog("SELECT * FROM tickets WHERE status LIKE 'Resol%' OR status LIKE 'Encerra%' OR status LIKE 'Impro%' ORDER BY registro DESC");  
                
                }else if($StatusX == _HOJE){ 
                    $sql = "SELECT * FROM tickets WHERE (status LIKE 'Resol%' OR status LIKE 'Encerra%' OR status LIKE 'Impro%' OR status LIKE 'Desist%')AND(data LIKE '%$hoje%') ORDER BY registro DESC";  
                    $objFuncao->RegistrarLog("SELECT * FROM tickets WHERE status LIKE 'Resol%' OR status LIKE 'Encerra%' OR status LIKE 'Impro%' ORDER BY registro DESC");  
                }else{ 
                    $sql = "SELECT * FROM tickets WHERE status = '$StatusX' ORDER BY registro ASC";
                    $objFuncao->RegistrarLog("SELECT * FROM tickets WHERE status = '$StatusX' ORDER BY registro ASC");
                }
            }	
            $result = mysqli_query($cnxMysql, $sql);		
            while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr		
                $Resulta[$P][_REG] = $row['registro'];
                $Resulta[$P][_ID] = $row['id']; 
                $Resulta[$P][_Empresa] = $row['empresa']; 
                $Resulta[$P][_Produto] = $row['produto']; 
                $Resulta[$P][_Tipo] = $row['tipo']; 
                $Resulta[$P][_IdFlow] = $row['id_flow']; 
                $Resulta[$P][_SWA] = $row['swa']; 
                $Resulta[$P][_EDD] = $row['edd']; 
                $Resulta[$P][_OPERADORA] = $row['operadora']; 
                $Resulta[$P][_VlanGer] = $row['vlan_ger']; 
                $Resulta[$P][_TipoPortaSWA] = $row['tipoPorta_swa']; 
                $Resulta[$P][_ShelfSwa] = $row['shelf_swa']; 
                $Resulta[$P][_SlotSwa] = $row['slot_swa']; 
                $Resulta[$P][_PortSwa] = $row['port_swa']; 
                $Resulta[$P][_SWT] = $row['swt']; 
                $Resulta[$P][_SWT_IP] = $row['swt_ip']; 
                $Resulta[$P][_RA] = $row['rede_acesso']; 
                $Resulta[$P][_Router] = $row['router']; 
                $Resulta[$P][_Interface] = $row['interface'];
                $Resulta[$P][_Porta] = $row['porta'];                  
                $Resulta[$P][_Speed] = $row['speed']; 
                $Resulta[$P][_VidUnit] = $row['vid_unit']; 
                $Resulta[$P][_PolicyIN] = $row['policyIN']; 	
                $Resulta[$P][_PolicyOUT] = $row['policyOUT']; 	
                $Resulta[$P][_Vrf] = $row['vrf']; 
                $Resulta[$P][_sVlan] = $row['svlan']; 
                $Resulta[$P][_cVlan] = $row['cvlan']; 
                $Resulta[$P][_Lan] = $row['lan']; 
                $Resulta[$P][_Wan] = $row['wan']; 
                $Resulta[$P][_WanFx] = $row['wan_fx']; 
                $Resulta[$P][_LoopBack] = $row['loopback']; 
                $Resulta[$P][_Lan6] = $row['lan6']; 
                $Resulta[$P][_Wan6] = $row['wan6']; 
                $Resulta[$P][_RtIntragov] = $row['rotas_intragov'];
                $Resulta[$P][_Status] = $row['status']; 
                $Resulta[$P][_Rascunho] = $row['rascunho']; 
                $Resulta[$P][_ReverTunnel] = $row['rever_tunnel']; 
                $Resulta[$P][_Backbone] = $row['backbone']; 
                $Resulta[$P][_Data] = $row['data']; 

                $P++;	
 
            }
            
            $Resulta[_CtgVETOR][_CtgVETOR] = $P;
            $cnxMysql->close();		// Fecha conexao($cnxMySql)
            
            return $Resulta;
            
    }

    function QueryHistorico($ID)
    {	

        // echo 'QueryHistorico('.$ID.')';
        // SELECT DISTINCT SWA FROM TICKETS;
        $objFuncao = new Funcao();
        $objFuncao->RegistrarLog('Class.MySql.QueryHistorico('.$ID.');');
       
            $Resulta[][]="";
            $P = 0;		
            $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
            if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection

            $sql = "SELECT * FROM tickets WHERE id = '$ID'";           	
            		
            $result = mysqli_query($cnxMysql, $sql);		
            while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr		
                $Resulta[$P][_REG] = $row['registro'];
                $Resulta[$P][_ID] = $row['id']; 
                $Resulta[$P][_Empresa] = $row['empresa']; 
                $Resulta[$P][_Produto] = $row['produto']; 
                $Resulta[$P][_Tipo] = $row['tipo'];
                $Resulta[$P][_IdFlow] = $row['id_flow']; 
                $Resulta[$P][_SWA] = $row['swa']; 
                $Resulta[$P][_EDD] = $row['edd']; 
                $Resulta[$P][_OPERADORA] = $row['operadora']; 
                $Resulta[$P][_VlanGer] = $row['vlan_ger']; 
                $Resulta[$P][_TipoPortaSWA] = $row['tipoPorta_swa'];
                $Resulta[$P][_ShelfSwa] = $row['shelf_swa']; 
                $Resulta[$P][_SlotSwa] = $row['slot_swa']; 
                $Resulta[$P][_PortSwa] = $row['port_swa']; 
                $Resulta[$P][_sVlan] = $row['svlan']; 
                $Resulta[$P][_cVlan] = $row['cvlan']; 
                $Resulta[$P][_Status] = $row['status']; 
                $Resulta[$P][_Data] = $row['data']; 

                $P++;	
 
            }
            
            $Resulta[_CtgVETOR][_CtgVETOR] = $P;
            $cnxMysql->close();		// Fecha conexao($cnxMySql)
            
            return $Resulta;
            
    }

    function lstSWA()
    {	
        
        // LISTA swa CADASTRADOS no BD
        $Resulta[][] = "";
        $P = 0;	
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection
        
        $sql = "SELECT DISTINCT swa, swt, swt_ip, status FROM tickets";
        $result = mysqli_query($cnxMysql, $sql);		
        while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr	
            $Resulta[$P][_SWA] = $row['swa']; 
            $Resulta[$P][_SWT] = $row['swt']; 
            $Resulta[$P][_SWT_IP] = $row['swt_ip']; 
            $Resulta[$P][_Status] = $row['status']; 
            $P++;	
        }            
        $Resulta[_CtgVETOR][_CtgVETOR] = $P;
        $cnxMysql->close();		// Fecha conexao($cnxMySql)
      
        return $Resulta;
            
    }

    function lstRaPorta($SwaX)
    {	
        
        // LISTA RA/Int/Porta para estes SWA
        $Resulta[][] = "";
        $P = 0;	
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection
        
        $sql = "SELECT DISTINCT registro, id, swa, status, rede_acesso, interface, porta, svlan, cvlan, backbone FROM tickets WHERE swa like '%$SwaX%'";
        $result = mysqli_query($cnxMysql, $sql);		
        while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr	
            $Resulta[$P][_REG] = $row['registro']; 
            $Resulta[$P][_ID] = $row['id']; 
            $Resulta[$P][_SWA] = $row['swa']; 
            $Resulta[$P][_Status] = $row['status']; 
            $Resulta[$P][_RA] = $row['rede_acesso']; 
            $Resulta[$P][_Interface] = $row['interface']; 
            $Resulta[$P][_Porta] = $row['porta']; 
            $Resulta[$P][_sVlan] = $row['svlan']; 
            $Resulta[$P][_cVlan] = $row['cvlan']; 
            $Resulta[$P][_Backbone] = $row['backbone'];  // Para check de pings 
            $P++;	
        }            
        $Resulta[_CtgVETOR][_CtgVETOR] = $P;
        $cnxMysql->close();		// Fecha conexao($cnxMySql)
      
        return $Resulta;

    }

    function lstID_SWA($swa)
    {	
       
        $Resulta[][] = "";
        $P = 0;		

        if(!empty($swa)){
            $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
            if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection
            
            $sql = "SELECT registro, id, swa FROM tickets WHERE swa LIKE '%$swa%'";
            $result = mysqli_query($cnxMysql, $sql);		
            while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr	
                $Resulta[$P][_REG] = $row['registro']; 
                $Resulta[$P][_ID] = $row['id']; 
                $Resulta[$P][_SWA] = $row['swa']; 
                $P++;	
 
            }
            
            $Resulta[_CtgVETOR][_CtgVETOR] = $P;
            $cnxMysql->close();		// Fecha conexao($cnxMySql)
            
            
        }
        return $Resulta;
            
    }

    function lstID_RA($RA)
    {	
        $Resulta[][]="";
        $P = 0;		

        if(!empty($RA)){
            $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
            if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection
            
            $sql = "SELECT id, empresa FROM tickets WHERE rede_acesso LIKE '%$RA%'";
            		
            $result = mysqli_query($cnxMysql, $sql);		
            while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr	
                $Resulta[$P][_ID] = $row['id']; 
                $Resulta[$P][_Empresa] = $row['empresa'];  
                $P++;	
 
            }
            
            $Resulta[_CtgVETOR][_CtgVETOR] = $P;
            $cnxMysql->close();		// Fecha conexao($cnxMySql)
            
            
        }
        return $Resulta;
            
    }


    function lstFalha()
    {	
        $Resulta[][]="";
        $P = 0;		
     
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection
        
        $sql = "SELECT * FROM tickets WHERE id_flow LIKE '%FALHA%'";
                
        $result = mysqli_query($cnxMysql, $sql);		
        while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr	
            $Resulta[$P][_REG] = $row['registro']; 
            $Resulta[$P][_ID] = $row['id']; 
            $Resulta[$P][_Empresa] = $row['empresa']; 
            $Resulta[$P][_SWA] = $row['swa']; 
            $Resulta[$P][_EDD] = $row['edd']; 
            $Resulta[$P][_OPERADORA] = $row['operadora'];
            $Resulta[$P][_TipoPortaSWA] = $row['tipoPorta_swa'];
            $Resulta[$P][_ShelfSwa] = $row['shelf_swa']; 
            $Resulta[$P][_SlotSwa] = $row['slot_swa']; 
            $Resulta[$P][_PortSwa] = $row['port_swa']; 
            $Resulta[$P][_sVlan] = $row['svlan']; 
            $Resulta[$P][_cVlan] = $row['cvlan']; 
            $Resulta[$P][_IdFlow] = $row['id_flow'];  
            $P++;	

        }
        
        $Resulta[_CtgVETOR][_CtgVETOR] = $P;
        $cnxMysql->close();		// Fecha conexao($cnxMySql)
        
            
        
        return $Resulta;
            
    }

    function lstExecHj()
    {	
        // Lista executados hoje
        $Resulta[][]="";
        $P = 0;		
           
        $Data = Date("d/m/Y");
                
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection
        
        $sql = "SELECT registro, id, empresa, status, data FROM tickets WHERE data LIKE '%$Data%'";
                
        $result = mysqli_query($cnxMysql, $sql);		
        while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr	
            $Resulta[$P][_REG] = $row['registro']; 
            $Resulta[$P][_ID] = $row['id']; 
            $Resulta[$P][_Empresa] = $row['empresa'];  
            $Resulta[$P][_Status] = $row['status'];  
            $Resulta[$P][_Data] = $row['data'];  
            $P++;	

        }
        
        $Resulta[_CtgVETOR][_CtgVETOR] = $P;
        $cnxMysql->close();		// Fecha conexao($cnxMySql)
        
            
        
        return $Resulta;
            
    }

    function checkMigOperFail()
    {	
        // Temp - Lista de possiveis tickets(migra-Oper) executados como New, antes de 21/02/2025, corrigir.
        $Resulta[][]="";
        $P = 0;		
           
        $Data = Date("d/m/Y");
                
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection
        
        $sql = "SELECT registro, id, empresa, status, data FROM tickets WHERE data like '%2/2025%'";
                
        $result = mysqli_query($cnxMysql, $sql);		
        while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr	
            $Resulta[$P][_REG] = $row['registro']; 
            $Resulta[$P][_ID] = $row['id']; 
            $Resulta[$P][_Empresa] = $row['empresa'];  
            $Resulta[$P][_Status] = $row['status'];  
            $Resulta[$P][_Data] = $row['data']; 
            // printf("%s;%s;%s;%s;",  $Resulta[$P][_REG], $Resulta[$P][_ID],  $Resulta[$P][_Status], $Resulta[$P][_Data]); echo "<br>";
            $P++;	

        }
        
        $Resulta[_CtgVETOR][_CtgVETOR] = $P;
        $cnxMysql->close();		// Fecha conexao($cnxMySql)
        
            
        
        return $Resulta;
            
    }


    function LocalizarSimples($PesquisarX)
    {	
		
        // Faz uma consulta simples, sem combina��es
        $objFuncao = new Funcao();
		$objFuncao->RegistrarLog('Class.MySql.LocalizarSimples('.$PesquisarX.');');
	
      // echo'Class.MySql.LocalizarSimples('.$TopicoCorrente.', '.$PesquisarX.');'.'<br>';
	
    
    	$Resulta[][]="";	// Inicializa
		$P = 0;
	                
       
		$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
		if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection
		             
            /* Consultar somente A */
            
                       
        $sql="select * from tickets where (rascunho like '%$PesquisarX%' or rever_tunnel like '%$PesquisarX%' or backbone like '%$PesquisarX%') ORDER BY registro DESC"; 
        //echo "select * from tickets where (rascunho like '%.$PesquisarX.%' or rever_tunnel like '%.$PesquisarX.%' or backbone like '%.$PesquisarX.%') ORDER BY registro DESC"; 
        
		$result = mysqli_query($cnxMysql, $sql);		
		while ($row = mysqli_fetch_assoc($result))   // fetch associative arr 
		{	
            $Resulta[$P][_REG] = $row['registro'];
            $Resulta[$P][_ID] = $row['id']; 
            $Resulta[$P][_Empresa] = $row['empresa']; 
            $Resulta[$P][_Produto] = $row['produto']; 
            $Resulta[$P][_SWA] = $row['swa']; 
            $Resulta[$P][_EDD] = $row['edd']; 
            $Resulta[$P][_OPERADORA] = $row['operadora']; 
            $Resulta[$P][_VlanGer] = $row['vlan_ger'];
            $Resulta[$P][_TipoPortaSWA] = $row['tipoPorta_swa'];
            $Resulta[$P][_ShelfSwa] = $row['shelf_swa']; 
            $Resulta[$P][_SlotSwa] = $row['slot_swa']; 
            $Resulta[$P][_PortSwa] = $row['port_swa']; 
            $Resulta[$P][_SWT] = $row['swt']; 
            $Resulta[$P][_SWT_IP] = $row['swt_ip']; 
            $Resulta[$P][_RA] = $row['rede_acesso']; 
            $Resulta[$P][_Router] = $row['router']; 
            $Resulta[$P][_Interface] = $row['interface'];
            $Resulta[$P][_Porta] = $row['porta'];                  
            $Resulta[$P][_Speed] = $row['speed']; 
            $Resulta[$P][_VidUnit] = $row['vid_unit']; 
            $Resulta[$P][_PolicyIN] = $row['policyIN']; 	
            $Resulta[$P][_PolicyOUT] = $row['policyOUT']; 	
            $Resulta[$P][_Vrf] = $row['vrf']; 
            $Resulta[$P][_sVlan] = $row['svlan']; 
            $Resulta[$P][_cVlan] = $row['cvlan']; 
            $Resulta[$P][_Lan] = $row['lan']; 
            $Resulta[$P][_Wan] = $row['wan']; 
            $Resulta[$P][_WanFx] = $row['wan_fx']; 
            $Resulta[$P][_LoopBack] = $row['loopback']; 
            $Resulta[$P][_Lan6] = $row['lan6']; 
            $Resulta[$P][_Wan6] = $row['wan6']; 
            $Resulta[$P][_Status] = $row['status']; 
            $Resulta[$P][_Rascunho] = $row['rascunho']; 
            $Resulta[$P][_ReverTunnel] = $row['rever_tunnel']; 
            $Resulta[$P][_Backbone] = $row['backbone']; 
            $Resulta[$P][_Data] = $row['data'];      

            $P++;
        }
		$cnxMysql->close();		// Fecha conexao($cnxMySql)
        //echo "Valor de P = ".$P."<br>";
        $Resulta[_CtgVETOR][_CtgVETOR] = $P;
       //  echo 'Pesquisar por:  '.$PesquisarX.'<br>';
		return ($Resulta);				
				
    }

    function LocalizarRefinar($Campo, $Palavra, $Campo2, $Palavra2, $LimData)
    {	
		
        // Faz uma consulta simples, sem combina��es
        $objFuncao = new Funcao();
		$objFuncao->RegistrarLog('Class.MySql.LocalizarRefinar('.$Palavra.');');
		//echo 'Class.MySql.LocalizarRefinar('.$Campo.', '.$Palavra.')';
	
      // echo'Class.MySql.LocalizarSimples('.$TopicoCorrente.', '.$PesquisarX.');'.'<br>';
	
    
    	$Resulta[][]="";	// Inicializa
		$P = 0;
	                
       
		$cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
		if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection
		             
            /* Consultar somente A */
            
                       
        $sql="SELECT * FROM tickets WHERE $Campo LIKE '%$Palavra%' AND $Campo2 NOT LIKE '%$Palavra2%' AND data LIKE '%$LimData%' ORDER BY registro DESC"; 
         //echo "select * from tickets where (rascunho like '%.$PesquisarX.%' or rever_tunnel like '%.$PesquisarX.%' or backbone like '%.$PesquisarX.%') ORDER BY registro DESC"; 
        
		$result = mysqli_query($cnxMysql, $sql);		
		while ($row = mysqli_fetch_assoc($result))   // fetch associative arr 
		{	
            $Resulta[$P][_REG] = $row['registro'];
            $Resulta[$P][_ID] = $row['id']; 
            $Resulta[$P][_Empresa] = $row['empresa']; 
            $Resulta[$P][_Produto] = $row['produto']; 
            $Resulta[$P][_SWA] = $row['swa']; 
            $Resulta[$P][_EDD] = $row['edd']; 
            $Resulta[$P][_OPERADORA] = $row['operadora']; 
            $Resulta[$P][_VlanGer] = $row['vlan_ger']; 
            $Resulta[$P][_TipoPortaSWA] = $row['tipoPorta_swa'];
            $Resulta[$P][_ShelfSwa] = $row['shelf_swa']; 
            $Resulta[$P][_SlotSwa] = $row['slot_swa']; 
            $Resulta[$P][_PortSwa] = $row['port_swa']; 
            $Resulta[$P][_SWT] = $row['swt']; 
            $Resulta[$P][_SWT_IP] = $row['swt_ip']; 
            $Resulta[$P][_RA] = $row['rede_acesso']; 
            $Resulta[$P][_Router] = $row['router']; 
            $Resulta[$P][_Interface] = $row['interface'];
            $Resulta[$P][_Porta] = $row['porta'];                  
            $Resulta[$P][_Speed] = $row['speed']; 
            $Resulta[$P][_VidUnit] = $row['vid_unit']; 
            $Resulta[$P][_PolicyIN] = $row['policyIN']; 	
            $Resulta[$P][_PolicyOUT] = $row['policyOUT']; 	
            $Resulta[$P][_Vrf] = $row['vrf']; 
            $Resulta[$P][_sVlan] = $row['svlan']; 
            $Resulta[$P][_cVlan] = $row['cvlan']; 
            $Resulta[$P][_Lan] = $row['lan']; 
            $Resulta[$P][_Wan] = $row['wan']; 
            $Resulta[$P][_WanFx] = $row['wan_fx']; 
            $Resulta[$P][_LoopBack] = $row['loopback']; 
            $Resulta[$P][_Lan6] = $row['lan6']; 
            $Resulta[$P][_Wan6] = $row['wan6']; 
            $Resulta[$P][_RtIntragov] = $row['rotas_intragov']; 
            $Resulta[$P][_Status] = $row['status']; 
            $Resulta[$P][_Rascunho] = $row['rascunho']; 
            $Resulta[$P][_ReverTunnel] = $row['rever_tunnel']; 
            $Resulta[$P][_Backbone] = $row['backbone']; 
            $Resulta[$P][_Data] = $row['data'];      

            $P++;
        }
		$cnxMysql->close();		// Fecha conexao($cnxMySql)
        //echo "Valor de P = ".$P."<br>";
        $Resulta[_CtgVETOR][_CtgVETOR] = $P;
       //  echo 'Pesquisar por:  '.$PesquisarX.'<br>';
		return ($Resulta);				
				
    } 

function preFormatar($Q){
    
if($Q == 0){    
$Res="\n\n\n
--------------------------- SAE ----------------------------\n.\n.
------------------------- SWA/SWT --------------------------\n.\n.

------------------------ BBIP ------------------------------\n.\n.

------------------------ ANTERIOR --------------------------\n";
}else if($Q == 1){
$Res="\n\n   
=== [SWA] ===\n        
=== [HL5/GWD] ===\n
=== [HL3/GWD] ===\n
=== [RSD] ===\n 
=== [PINGs] ===\n
=== [FIM] ===\n
= Para ser pego pelos filtros:\n 1.Insira tudo na mesma linha apos o nome do RSD, GWx ou HLXx,\n 2.Use `#` p/ pular linhas";

}else if($Q == 2){
$Res="\n\n
*** VALIDACAO DE IPs ***\n\n
***     BBIP     ***\n\n\n
*** SWA ***\n\n
--- CAD.ERB FIBRADA ---\n\n";
}

return $Res;
}


function EmailPortStar($Ra, $Interface, $Port){
    /*
    [17:32] Rodrigo Barbosa
Atenção Todos
 
Para cadastro de portas no Star não está mais regionalizado. Enviem para todos abaixo:
[17:32] Rodrigo Barbosa
Anderson Lopes Monteiro <anderson.monteiro@telefonica.com>

Cesar Hoffmann Bispo <cesar.bispo@telefonica.com>

Fernando Tadeu Ferreira Guedes Junior <fernando.guedes@telefonica.com>

Ricardo Luis Vedovate <ricardo.vedovate@telefonica.com>

Rafael Tomas Valduga <Rafael.Valduga@telefonica.com>

Ilka Costa Alberti <ilka.alberti@telefonica.com>
 heart 1
    */

    $Res[0] = "Solicitado cadastro da porta No Star p:";
    $Res[1] = "Fernando Tadeu Ferreira Guedes Junior <fernando.guedes@telefonica.com>";
    $Res[2] = "Ricardo Luis Vedovate <ricardo.vedovate@telefonica.com>";
    $Res[3] = "Rafael Tomas Valduga <Rafael.Valduga@telefonica.com>";
    $Res[4] = "Ilka Costa Alberti <ilka.alberti@telefonica.com>";
    $Res[5] = "";
    $Res[6] = "CC:";
    $Res[7] = "Configuração Corporativa <configuracaocorporativa.br@telefonica.com>; Alexandre Jose Peres <alexandre.peres@telefonica.com>; Jose Pontes <jose.pontes@teltelecom.com.br>;";
    $Res[8] = "";
    $Res[9] = "Assunto do e-mail: ";
    $Res[10] = "Cadastro de portas no Star: ".$Ra." - Porta: ".$Interface." ".$Port;
    $Res[11] = "";
    $Res[12] = "Bom dia time Eng., por gentileza, favor cadastrar a porta no Star.";
    $Res[13] = "Equipamento: ".$Ra;
    $Res[14] = "Porta: ".$Interface." ".$Port;
    
    $Res[_CtgVETOR] = 15;

    return $Res;
}

function EmailTA($Swa, $IP){
   
    $Res[0] = "Para:";							
    $Res[1] = "SSD Suporte <ssd.suporte.br@telefonica.com>";
    $Res[2] = "Configuração Corporativa <configuracaocorporativa.br@telefonica.com>";
    $Res[3] = "CC:";
    $Res[4] = "Deniz Santos <deniz.santos@teltelecom.com.br>; José Pontes Sandre - Tel <jose.pontes@teltelecom.com.br>;"; 
    $Res[5] = "Julia Pontes - Tel <julia.pontes@teltelecom.com.br>; Paula Almeida <paula.almeida@teltelecom.com.br>; Tatiane Bouças - Tel <tatiane.garcia@teltelecom.com.br>; alexandre.peres@telefonica.com;";
    $Res[6] = "";
    $Res[7] = "Assunto:"; 
    $Res[8] = "Abertura de TA - ".$Swa; 																
    $Res[9] = "Mensagem corpo do e-mail:"; 
    $Res[10] = 'Bom dia time SSD, por gentileza abrir TA para o equipamento #'.$Swa.'# '.$IP.'#.';
    $Res[11] = "LOG";
    $Res[12] = "";
    $Res[13] = "Depois de quatro horas que pediu a TA mesmo não recebdndo o número, devolver improcedente com o motivo:";								
    $Res[14] = "SWA inacessível, solicitado TA, #se tiver o número informar se não tiver seguir em branco#  favor abrir novo ticket assim que o SWA estiver inacessível.";

    $Res[_CtgVETOR] = 15;

    return $Res;
}
function EmailCadERB($SWA, $Ra, $Interface, $Port){


    $Res[0] = "Solicitacao de ajuste cadastro ERB:";
    $Res[1] = "joao.vmarques@telefonica.com";   
    $Res[2] = "";
    $Res[3] = "CC:";
    $Res[4] = "Rodrigo Barbosa <barbosa.rodrigo@telefonica.com>";
    $Res[5] = "";
    $Res[6] = "Assunto do e-mail: ";
    $Res[7] = "Correcao de cadastro portal ERB-Fibrada, SWA:".$SWA;
    $Res[8] = "";
    $Res[9] = "Bom dia, por gentileza, poderia corrigir o Cadastro de backBone no Portal ERB_FIBRADA:";
    $Res[10] = "SWA: ".$SWA;
    $Res[11] = "DE: ".$Ra." - ".$Interface." - ".$Port;
    $Res[12] = "PARA: ".$Ra." - ".$Interface." - ".$Port;
    
    
    $Res[_CtgVETOR] = 13;

    return $Res;
}
function EmailCadFlow($SWA, $Port){


    $Res[0] = "Solicitacao de ajuste cadastro SWA:";
    $Res[1] = "<arquitetura.b2b.br@telefonica.com>";
    $Res[2] = "Antigo >>> <michelp.silva@telefonica.com>; <reginaldo.sa@telefonica.com>; <lucas.mendonca@telefonica.com>; <evellyn.silva@telefonica.com>";   
    $Res[3] = "";
    $Res[4] = "CC:";
    $Res[5] = "<alexandre.peres@telefonica.com>; <barbosa.rodrigo@telefonica.com>";
    $Res[6] = "";
    $Res[7] = "Assunto do e-mail: ";
    $Res[8] = "Correcao de cadastro SWA portal Efika-Flow, SWA:".$SWA;
    $Res[9] = "";
    $Res[10] = "Bom dia, por gentileza, poderia corrigir o Cadastro do SWA no Portal EFika-Flow:";
    $Res[11] = "SWA: ".$SWA." - Port: ".$Port;
        
    
    $Res[_CtgVETOR] = 12;

    return $Res;
}

function GerarCsvTickets()
{	
  
        $cnxMysql = mysqli_connect(defHost, defUserBD, defPassBD, defBD); // Create connection Mysql 8.x.x		
        if (!$cnxMysql) {	die("Connection failed: ".mysqli_connect_error());	}  // Check connection

       $sql = "SELECT * FROM tickets";
     $P=0;	
                
        $result = mysqli_query($cnxMysql, $sql);		
        while ($row = mysqli_fetch_assoc($result)) {  // fetch associative arr		
            $Resulta[$P][_REG] = $row['registro'];
            $Resulta[$P][_ID] = $row['id']; 
            $Resulta[$P][_Empresa] = $row['empresa']; 
            $Resulta[$P][_Produto] = $row['produto']; 
            $Resulta[$P][_Tipo] = $row['tipo']; 
            $Resulta[$P][_IdFlow] = $row['id_flow']; 
            $Resulta[$P][_SWA] = $row['swa']; 
            $Resulta[$P][_EDD] = $row['edd']; 
            $Resulta[$P][_OPERADORA] = $row['operadora']; 
            $Resulta[$P][_VlanGer] = $row['vlan_ger']; 
            $Resulta[$P][_TipoPortaSWA] = $row['tipoPorta_swa'];
            $Resulta[$P][_ShelfSwa] = $row['shelf_swa']; 
            $Resulta[$P][_SlotSwa] = $row['slot_swa']; 
            $Resulta[$P][_PortSwa] = $row['port_swa']; 
            $Resulta[$P][_SWT] = $row['swt']; 
            $Resulta[$P][_SWT_IP] = $row['swt_ip']; 
            $Resulta[$P][_RA] = $row['rede_acesso']; 
            $Resulta[$P][_Router] = $row['router']; 
            $Resulta[$P][_Interface] = $row['interface'];
            $Resulta[$P][_Porta] = $row['porta'];                  
            $Resulta[$P][_Speed] = $row['speed']; 
            $Resulta[$P][_VidUnit] = $row['vid_unit']; 
            $Resulta[$P][_PolicyIN] = $row['policyIN']; 	
            $Resulta[$P][_PolicyOUT] = $row['policyOUT']; 	
            $Resulta[$P][_Vrf] = $row['vrf']; 
            $Resulta[$P][_sVlan] = $row['svlan']; 
            $Resulta[$P][_cVlan] = $row['cvlan']; 
            $Resulta[$P][_Lan] = $row['lan']; 
            $Resulta[$P][_Wan] = $row['wan']; 
            $Resulta[$P][_WanFx] = $row['wan_fx']; 
            $Resulta[$P][_LoopBack] = $row['loopback']; 
            $Resulta[$P][_Lan6] = $row['lan6']; 
            $Resulta[$P][_Wan6] = $row['wan6']; 
            $Resulta[$P][_Status] = $row['status']; 
            $Resulta[$P][_Rascunho] = $row['rascunho']; 
            $Resulta[$P][_ReverTunnel] = $row['rever_tunnel']; 
            $Resulta[$P][_Backbone] = $row['backbone']; 
            $Resulta[$P][_Data] = $row['data']; 

            for($i=0; $i<35; $i++){
                printf("%s; ", $Resulta[$P][$i]);
            }
            $P++;	

        }
        

        
}



}// Class