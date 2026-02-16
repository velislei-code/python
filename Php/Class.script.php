<?php  

/**
 * MySQL - Classe de manipula��o banco MySQL
 * NOTE: Requer PHP vers�o 5 ou superior
 * @package Biblioteca
 * @author Treuk, Velislei A.
 * @email: velislei@gmail.com
 * @copyright 2010 - 2015 
 * @licen�a: Estudantes
 */

 

define("_CtgLinScript", 600);   // Contagem num.elem.vetor
define("_CtgScpTunnel", 800); // Contagem num.elem.vetor script Tunnel   
define("_CtgScpTunnelHl5g", 900); // Contagem num.elem.vetor script Tunnel   

define("_CFG", "Config");              // Configuracao
define("_MIGRA", "Migracao");              // Migracao
define("_DCFG", "Desconfig");              // Desconfiguracao

// Script Routers
define("_FaixaCmdRouters", 100); // NAO DEVE SER ALTERADO, depende da construcao abaixo: 100, 101, 102, 1xx, num.elem.vetor
define("_FaixaPreView", 200); // NAO DEVE SER ALTERADO, depende da construcao abaixo: 100, 101, 102, 1xx, num.elem.vetor
define("_CtgCmdRouters", 400); // Contagem num.elem.vetor

// Script Datacom
define("_FaixaCARIMBO", 300); // NAO DEVE SER ALTERADO: depende da contrucao abaixo: 200, 201, 202, 2xx, Numera Vetor de elem.matriz 
define("_CtgCARIMBO", 500); // Contagem num.elem.vetor     

define("_IPv4", 1);   
define("_IPv6", 2); 
define("_TamIP", 15);  // Formatacao tam.String IP, qdo completo

define("_TEL", 'T31@$po*17');  
define("_VV", 'Conc!&ncia888'); //<---19/06/25  P@z2025paz <- 5/5/25: Suc&550101 <- 20mar25 Aten@a1*07, 6fev25 Aten@a0*17 <- 8Nov24, 'Fun@a0*101'; //'Con@$f!g27';  
define("_SwaAdm", 'd4t4c0m#$%'); 
define("_SwaSuporte", 'sup0rt3_m3tr0'); 
define("_SwaOperB2b", '7q1iK3F0R'); 


class Script {


			
    function Cisco($Modelo, $ID, $Empresa, $OPER, $Port, $Speed, $PolicyIN, $PolicyOUT, $Vrf, $sVlan, $cVlan, $Lan, $Wan, $WanFx, $Loopback, $LanIpv6, $WanIpv6, $RotasIntragov, $Tipo)
    {
        $Lin[] = "";
                
        $Empresa = str_replace(' ', '_', $Empresa);
        $Bandwidth = $this->SpeedToBandwidth($Speed);
        $PolicyIN = str_replace(" ", "", $PolicyIN);  // tira espaços de speed
        $PolicyOUT = str_replace(" ", "", $PolicyOUT);  // tira espaços de speed
        
        if(!empty($Wan)){   
            if(str_contains($WanFx, '1')){  // /31       
                $WanLocal = $Wan;
            }else{                          // /30
                $WanLocal = $this->IpToRota($Wan);
            }
            $WanRota = $this->IpToRota($WanLocal);
            $WanIpv6Rota = $this->IpToRota($WanIpv6);
        }else{
            $WanLocal = '0.0.0.0';
            $WanRota = '0.0.0.0';
            $WanIpv6Rota = '0000';
        }   
        
        if(empty($Tipo)){ $Tipo = _CFG; } 

        // Script de config
        if($Modelo == 'ASR9K'){
            if(($Tipo == _CFG)||($Tipo == _MIGRA)){
                $Lin[0] = "config exclusive";
                $Lin[1] = "interface ".$Port.".".$sVlan.$cVlan." no shutdown";
                $Lin[2] = "interface ".$Port.".".$sVlan.$cVlan." bandwidth ".$Bandwidth;
                $Lin[3] = "interface ".$Port.".".$sVlan.$cVlan." description ".$Port.".".$sVlan.$cVlan." dot1q vlan id=".$sVlan.". By VPNSC: Job Id# = xxxxxx (".$Empresa."_".$ID."_".$OPER.")";
                $Lin[4] = "interface ".$Port.".".$sVlan.$cVlan." service-policy input ".$PolicyIN;
                $Lin[5] = "interface ".$Port.".".$sVlan.$cVlan." service-policy output ".$PolicyOUT;
                if(str_contains($WanFx, '1')){
                    $Lin[6] = "interface ".$Port.".".$sVlan.$cVlan." ipv4 address ".$WanLocal." 255.255.255.254";
                }else{
                    $Lin[6] = "interface ".$Port.".".$sVlan.$cVlan." ipv4 address ".$WanLocal." 255.255.255.252";
                }    
                $Lin[7] = "interface ".$Port.".".$sVlan.$cVlan." encapsulation dot1q ".$sVlan." second-dot1q ".$cVlan;
                if(str_contains($WanIpv6, ':')){        // Se Circuito possui IP-LAN-Ipv6 
                    $Lin[8] = "interface ".$Port.".".$sVlan.$cVlan." ipv6 address ".$WanIpv6."/127";
                    $Lin[9] = "interface ".$Port.".".$sVlan.$cVlan." ipv6 unreachables disable";
                }else{ 
                    $Lin[8] = ""; 
                    $Lin[9] = ""; 
                }    
                
                if(str_contains($Loopback, '.')){ // Se Circuito possui IP-LoopBack
                    $Lin[10] = "router static address-family ipv4 unicast ".$Loopback."/32 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                }else{ $Lin[10] = ""; }

                if(str_contains($Lan, '.')){    // Se Circuito possui IP-LAN                
                    $Lin[11] = "router static address-family ipv4 unicast ".$Lan."/29 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                }else{ $Lin[11] = ""; }

                if(str_contains($LanIpv6, ':')){        // Se Circuito possui IP-LAN-Ipv6 
                    $Lin[12] = "router static address-family ipv6 unicast ".$LanIpv6."/56 ".$Port.".".$sVlan.$cVlan." ".$WanIpv6Rota;
                }else{ $Lin[12] = ""; }

                $Lin[13] = "!";
                $Lin[14] = "commit";
                $Lin[15] = "!";
                $Lin[16] = "exit";
                $Lin[17] = "!";

                // Total lin no script
                $Lin[_CtgLinScript] = 18;   

            }else if($Tipo == _DCFG){         
            
                // Desconfiguracao(script)
                $Lin[0] = "config exclusive";                
                $Lin[1] = "no router static address-family ipv4 unicast ".$Loopback."/32 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                $Lin[2] = "no router static address-family ipv4 unicast ".$Lan."/29 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                $Lin[3] = "no router static address-family ipv6 unicast ".$LanIpv6."/56 ".$Port.".".$sVlan.$cVlan." ".$WanIpv6Rota;
                $Lin[4] = "no interface ".$Port.".".$sVlan.$cVlan;
                $Lin[5] = "!";
                $Lin[6] = "commit";
                $Lin[7] = "!";
                $Lin[8] = "exit";
                $Lin[9] = "!";

                // Total lin no script
                $Lin[_CtgLinScript] = 10;   
            }              
         
        }else if($Modelo == 'IOS_XR'){


            // Cisco IOS XR
            if(($Tipo == _CFG)||($Tipo == _MIGRA)){ 
                $Lin[0] = "config exclusive";
                $Lin[1] = "interface  ".$Port.".".$sVlan.$cVlan; 
                $Lin[2] = "interface  ".$Port.".".$sVlan.$cVlan." no shutdown"; 
                $Lin[3] = "interface  ".$Port.".".$sVlan.$cVlan." bandwidth ".$Bandwidth; 
                $Lin[4] = "interface  ".$Port.".".$sVlan.$cVlan." description ".$Port.".".$sVlan.$cVlan." dot1q vlan id=".$sVlan.". (".$Empresa."_".$ID."_".$OPER.")";
                $Lin[5] = "interface  ".$Port.".".$sVlan.$cVlan." service-policy input ".$PolicyIN;
                $Lin[6] = "interface  ".$Port.".".$sVlan.$cVlan." service-policy output ".$PolicyOUT;
                if(str_contains($WanFx, '1')){
                    $Lin[7] = "interface  ".$Port.".".$sVlan.$cVlan." ipv4 address ".$WanLocal." 255.255.255.254";
                }else{
                    $Lin[7] = "interface  ".$Port.".".$sVlan.$cVlan." ipv4 address ".$WanLocal." 255.255.255.252";
                }   
                $Lin[8] = "interface  ".$Port.".".$sVlan.$cVlan." ipv4 verify unicast source reachable-via any";

                if(str_contains($WanIpv6, ':')){        // Se Circuito possui IP-LAN-Ipv6 
                    $Lin[9] = "interface  ".$Port.".".$sVlan.$cVlan." ipv6 verify unicast source reachable-via any";
                    $Lin[10] = "interface  ".$Port.".".$sVlan.$cVlan." ipv6 address ".$WanIpv6."/127";
                    $Lin[11] = "interface  ".$Port.".".$sVlan.$cVlan." flow ipv4 monitor MONITOR-V4 sampler SAMPLER-1-OUT-1000 ingress";
                    $Lin[12] = "interface  ".$Port.".".$sVlan.$cVlan." flow ipv6 monitor MONITOR-V6 sampler SAMPLER-1-OUT-1000 ingress";
                    $Lin[13] = "interface  ".$Port.".".$sVlan.$cVlan." encapsulation dot1q ".$sVlan." second-dot1q ".$cVlan; 
                    $Lin[14] = "interface  ".$Port.".".$sVlan.$cVlan." ipv4 access-group iACL-SECURITY-IN-IPv4 ingress";
                    $Lin[15] = "interface  ".$Port.".".$sVlan.$cVlan." ipv6 access-group iACL-SECURITY-IN-IPv6 ingress";
                }else{ 
                    $Lin[9] = ""; 
                    $Lin[10] = ""; 
                    $Lin[11] = "interface  ".$Port.".".$sVlan.$cVlan." flow ipv4 monitor MONITOR-V4 sampler SAMPLER-1-OUT-1000 ingress";
                    $Lin[12] = ""; 
                    $Lin[13] = "interface  ".$Port.".".$sVlan.$cVlan." encapsulation dot1q ".$sVlan." second-dot1q ".$cVlan; 
                    $Lin[14] = "interface  ".$Port.".".$sVlan.$cVlan." ipv4 access-group iACL-SECURITY-IN-IPv4 ingress";
                    $Lin[15] = "";
                } 
                
                if(str_contains($Loopback, '.')){ // Se Circuito possui IP-LoopBack
                    $Lin[16] = "router static address-family ipv4 unicast ".$Loopback."/32 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                }else{ $Lin[16] = ""; }

                if(str_contains($Lan, '.')){    // Se Circuito possui IP-LAN                
                    $Lin[17] = "router static address-family ipv4 unicast ".$Lan."/29 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                }else{ $Lin[17] = ""; }

                if(str_contains($LanIpv6, ':')){        // Se Circuito possui IP-LAN-Ipv6 
                    $Lin[18] = "router static address-family ipv6 unicast ".$LanIpv6."/56 ".$Port.".".$sVlan.$cVlan." ".$WanIpv6Rota;
                }else{ $Lin[18] = ""; }

                $Lin[19] = "!";
                $Lin[20] = "commit";
                $Lin[21] = "!";
                $Lin[22] = "exit";
                $Lin[23] = "!";
               
                // Total lin no script
                $Lin[_CtgLinScript] = 24;

            }else if($Tipo == _DCFG){

                // Desconfiguracao(script)
                $Lin[0] = "config exclusive";
                $Lin[1] = "no interface  ".$Port.".".$sVlan.$cVlan; 
                $Lin[2] = "no router static address-family ipv4 unicast ".$Loopback."/32 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                $Lin[3] = "no router static address-family ipv4 unicast ".$Lan."/29 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                $Lin[4] = "no router static address-family ipv6 unicast ".$LanIpv6."/56 ".$Port.".".$sVlan.$cVlan." ".$WanIpv6Rota;
                $Lin[5] = "!";
                $Lin[6] = "commit";
                $Lin[7] = "!";
                $Lin[8] = "exit";
                $Lin[9] = "!";

                // Total lin no script
                $Lin[_CtgLinScript] = 10;  
            }   
        }
        
        
        if($Modelo == 'VRF_ASR9K'){
            
            if($Vrf == ''){ $Vrf = '<Vrf_Name>'; }

            if(($Tipo == _CFG)||($Tipo == _MIGRA)){
                //----------------------- INI-CRIAR VRF ----------------------------------------------------------------------//
                $Lin[0] = "----------------------- CRIAR VRF ----------------------------------------";  
                $Lin[1] = "conf e";  
                $Lin[2] = "route-policy grey_mgmt_vpn_Telefonica_Empresas_".$Vrf;  // Aqui a $Vrf muda o nome(tira 1ou2 letras no final)
                $Lin[3] = "   if (destination in pfx_".$Vrf."_VPNSC_GREY_MGMT) then";
                $Lin[4] = "      set extcommunity rt (10429:103) additive";
                $Lin[5] = "   endif";
                $Lin[6] = "end-policy";
                $Lin[7] = "! << Check nome: Vrf-1Letra, num: 103 >>";
                $Lin[8] = "prefix-set pfx_".$Vrf."_VPNSC_GREY_MGMT"; 
                $Lin[9] = "end-set";
                $Lin[10] = "!";
                $Lin[11] = "vrf ".$Vrf; 
                $Lin[12] = "address-family ipv4 unicast";
                $Lin[13] = " import route-target";
                $Lin[14] = "  10429:102";
                $Lin[15] = "  10429:19230";
                $Lin[16] = " ! << Check num: 102, 19230   >>";
                $Lin[17] = " export route-policy grey_mgmt_vpn_Telefonica_Empresas_".$Vrf; 
                $Lin[18] = " export route-target";
                $Lin[19] = "  10429:19230";
                $Lin[20] = " ! << Check nome: Vrf-1Letra, num: 19230 >>";
                $Lin[21] = "<< Aqui já da pra ver a Vrf criada >> sh run vrf".$Vrf;
                $Lin[22] = "!";
                $Lin[23] = "<< Esta rotina costuma já existir: >>";
                $Lin[24] = "route-policy static_to_mpBGP";    
                $Lin[25] = "if ((tag eq 200)) then";
                $Lin[26] = "  set local-preference 200";
                $Lin[27] = "elseif ((tag eq 250)) then";
                $Lin[28] = "  set weight 0";
                $Lin[29] = "else";
                $Lin[30] = "  pass";
                $Lin[31] = "endif";
                $Lin[32] = "end-policy";
                $Lin[33] = "!";
                $Lin[34] = "<< Inicializar-bgp >>";
                $Lin[35] = "<< Na falta...da erro => !!% `BGP` detected the `warning` condition `The address family has not been initialized` >>";
                $Lin[36] = "router bgp 10429";
                $Lin[37] = "vrf ".$Vrf;
                $Lin[38] = " rd 10429:11778 <<Check num: 11778>>";
                $Lin[39] = " address-family ipv4 unicast";
                $Lin[40] = "  redistribute connected";
                $Lin[41] = "  redistribute static route-policy static_to_mpBGP  << Check nome: _mpBGP >>";
                $Lin[42] = "!";
                $Lin[43] = "commit";
                $Lin[44] = "!";
                $Lin[45] = "!";
                $Lin[46] = "+++++++++++++++ INI.CONFIG(Caso já exista Vrf na Caixa) ++++++++++++++++++++++++++++++++++++";
                $Lin[47] = " ";

                
                //----------------------- FIM CRIAR VRF ----------------------------------------------------------------------//

                $Lin[48] = "edit prefix-set pfx_".$Vrf."_VPNSC_GREY_MGMT inline add ".$Loopback."/32";
                $Lin[49] = "edit prefix-set pfx_".$Vrf."_VPNSC_GREY_MGMT inline add ".$Wan.$WanFx; //  (WAN0-rede)	";
                $Lin[50] = "!";
                $Lin[51] = "config e";            
                $Lin[52] = "interface ".$Port.".".$sVlan.$cVlan." description ".$Port.".".$sVlan.$cVlan." dot1q vlan id=".$sVlan.". By VPNSC: Job Id# = XXXXXX (".$Empresa."_".$ID."_".$OPER.")";
                $Lin[53] = "interface ".$Port.".".$sVlan.$cVlan." bandwidth ".$Bandwidth;
                $Lin[54] = "interface ".$Port.".".$sVlan.$cVlan." service-policy output ".$PolicyOUT;
                $Lin[55] = "interface ".$Port.".".$sVlan.$cVlan." vrf ".$Vrf;

                if(str_contains($WanFx, '1')){
                    $Lin[56] = "interface ".$Port.".".$sVlan.$cVlan." ipv4 address ".$WanLocal." 255.255.255.254";
                }else{
                    $Lin[56] = "interface ".$Port.".".$sVlan.$cVlan." ipv4 address ".$WanLocal." 255.255.255.252";
                }

                if(str_contains($WanIpv6, ':')){        // Se Circuito possui IP-Ipv6                
                    $Lin[57] = "interface ".$Port.".".$sVlan.$cVlan." ipv6 address ".$WanIpv6."/127";
                }else{ $Lin[57] = ""; }

                $Lin[58] = "interface ".$Port.".".$sVlan.$cVlan." encapsulation dot1q ".$sVlan." second-dot1q ".$cVlan;
                $Lin[59] = "";               
                if(str_contains($Loopback, '.')){ // Se Circuito possui IP-LoopBack
                    $Lin[60] = "router static vrf ".$Vrf." address-family ipv4 unicast ".$Loopback."/32 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                }else{ $Lin[60] = ""; }

                if(str_contains($Lan, '.')){    // Se Circuito possui IP-LAN                
                    $Lin[61] = "router static vrf ".$Vrf." address-family ipv4 unicast ".$Lan."/29 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                }else{ $Lin[61] = ""; }
                $Lin[62] = "!";         

                $Lin[63] = "router bgp 10429";
                $Lin[64] = " vrf ".$Vrf;
                $Lin[65] = "  neighbor ".$WanRota;
                $Lin[66] = "   remote-as 65001";
                $Lin[67] = "   address-family ipv4 unicast";
                $Lin[68] = "    route-policy IscDefaultPassAll in";
                $Lin[69] = "    route-policy IscDefaultPassAll out";
                $Lin[70] = "    as-override";
                $Lin[71] = "   !";
                $Lin[72] = "   exit";
                $Lin[73] = "   !";
                $Lin[74] = "  exit";
                $Lin[75] = "  !";
                $Lin[76] = " exit";
                $Lin[77] = " !";
                $Lin[78] = "exit";
                $Lin[79] = "!";

                // Total lin no script
                $Lin[_CtgLinScript] = 80;

            }else if($Tipo == _DCFG){

                // Desconfiguracao(script)
                $Lin[0] = "edit prefix-set pfx_".$Vrf."_VPNSC_GREY_MGMT inline remove ".$Loopback."/32";
                $Lin[1] = "edit prefix-set pfx_".$Vrf."_VPNSC_GREY_MGMT inline remove ".$Wan."/30"; //  (WAN0-rede)	";
                $Lin[2] = "!";
                $Lin[3] = "config e";            
                $Lin[4] = "no interface ".$Port.".".$sVlan.$cVlan;
                $Lin[5] = "no router static vrf ".$Vrf." address-family ipv4 unicast ".$Lan."/29 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                $Lin[6] = "no router static vrf ".$Vrf." address-family ipv4 unicast ".$Loopback."/32 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                $Lin[7] = "!";          
                $Lin[8] = "router bgp 10429";
                $Lin[9] = " vrf ".$Vrf;
                $Lin[10] = "  no neighbor ".$WanRota;
                $Lin[11] = "   !";
                $Lin[12] = "   exit";
                $Lin[13] = "   !";
                $Lin[14] = "  exit";
                $Lin[15] = "  !";
                $Lin[16] = "  commit";
                $Lin[17] = "  exit";
                $Lin[18] = "  !";
          
            
                // Total lin no script
                $Lin[_CtgLinScript] = 19;

            }      

            // Checks de VRF
            $Lin[200] = "sh run vrf ".$Vrf;
            $Lin[201] = "sh run grey_mgmt_vpn_Telefonica_Empresas_".$Vrf;
            $Lin[202] = "sh run prefix-set pfx_".$Vrf."_VPNSC_GREY_MGMT";
            $Lin[203] = "sh run router bgp 10429 vrf ".$Vrf;
            $Lin[204] = "     remote-as 65001  <<- Dentro do BGP, ver se esta livre (Greici)VPN segue normal, tira o unreachables disable ";


        }else if($Modelo == 'VRF_IOS-XE'){
            
            if($Vrf == ''){ $Vrf = '<Vrf_Name>'; }

            if(($Tipo == _CFG)||($Tipo == _MIGRA)){


                $Lin[0] = "-------------------- CRIAR VRF -----------------------------------------";
                $Lin[1] = "conf ter";
                $Lin[2] = "!";
                $Lin[3] = "ip vrf ".$Vrf;
                $Lin[4] = " rd 10429:101180";
                $Lin[5] = "export map grey_mgmt_vpn_Telefonica_Empresas_".$Vrf;
                $Lin[6] = "route-target export 10429:32173";
                $Lin[7] = "route-target import 10429:32173";
                $Lin[8] = "route-target import 10429:102";
                $Lin[9] = "!";
                $Lin[10] = "exit";
                $Lin[11] = "router bgp 10429";
                $Lin[12] = " !";
                $Lin[13] = " address-family ipv4 vrf ".$Vrf;
                $Lin[14] = "  redistribute connected";
                $Lin[15] = "  redistribute static";
                $Lin[16] = " exit-address-family";
                $Lin[17] = " !";
                $Lin[18] = "exit";
                $Lin[19] = "ip access-list extended ".$Vrf."_VPNSC_GREY_MGMT_ACL";
                $Lin[20] = "exit";
                $Lin[21] = "route-map grey_mgmt_vpn_Telefonica_Empresas_".$Vrf." permit 10";
                $Lin[22] = " match ip address ".$Vrf."_VPNSC_GREY_MGMT_ACL";
                $Lin[23] = " set extcommunity rt 10429:103 additive";
                $Lin[24] = "!";
                $Lin[25] = "exit";
                $Lin[26] = "exit";
                $Lin[27] = "wr";
                $Lin[28] = " ";
                $Lin[29] = "------------------ Ini-Config(Caso ja exista a vrf na caixa) ------------------------------";
                $Lin[30] = " ";
                $Lin[31] = "conf ter";
                $Lin[32] = "ip access-list extended ".$Vrf."_VPNSC_GREY_MGMT_ACL";
                $Lin[33] = "   permit ip ".$Wan." 0.0.0.3 any";
                $Lin[34] = "	permit ip ".$Loopback." 0.0.0.3 any";
                $Lin[35] = "	exit";
                $Lin[36] = "	!";
                $Lin[37] = "!";
                $Lin[38] = "interface ".$Port.".".$sVlan.$cVlan;
                $Lin[39] = " bandwidth ".$Bandwidth;
                $Lin[40] = " no shutdown";
                $Lin[41] = " description ".$Port.".".$sVlan.$cVlan." dot1q vlan id=".$sVlan.". By VPNSC: Job Id# = XXXXXX (".$Empresa."_".$ID."_".$OPER.")";
                $Lin[42] = " service-policy input ".$PolicyIN;
                $Lin[43] = " service-policy output ".$PolicyOUT;
                $Lin[44] = " encapsulation dot1Q ".$sVlan." second-dot1q ".$cVlan;
                $Lin[45] = " ip vrf forwarding ".$Vrf;

                if(str_contains($WanFx, '1')){
                    $Lin[46] = " ip address ".$WanLocal." 255.255.255.254";
                }else{    
                    $Lin[46] = " ip address ".$WanLocal." 255.255.255.252";
                }
                    
                    $Lin[47] = "exit";
                $Lin[48] = "!";
                if(str_contains($Lan, '.')){ // Se Circuito possui IP-Lan
                    $Lin[49] = "ip route vrf ".$Vrf." ".$Lan." 255.255.255.248 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                }else{ $Lin[49] = ""; }
    
                if(str_contains($Loopback, '.')){ // Se Circuito possui IP-LoopBack
                    $Lin[50] = "ip route vrf ".$Vrf." ".$Loopback." 255.255.255.255 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                }else{ $Lin[50] = ""; }
    
                $Lin[51] = "!";

                $Lin[52] = "router bgp 10429	";
                $Lin[53] = " address-family ipv4 vrf ".$Vrf;
                $Lin[54] = "	neighbor ".$WanRota." remote-as 65001	";
                $Lin[55] = "	neighbor ".$WanRota." activate	";
                $Lin[56] = "	neighbor ".$WanRota." as-override	";
                $Lin[57] = "	exit-address-family	";
                $Lin[58] = "!";
                $Lin[59] = "exit";
                $Lin[60] = "!";
                $Lin[61] = "exit";
                $Lin[62] = "!";
                $Lin[63] = "wr";
        
                // Total lin no script
                $Lin[_CtgLinScript] = 64;

            }else if($Tipo == _DCFG){    

                // Desconfiguracao(script)
                $Lin[0] = "conf ter";
                $Lin[1] = "ip access-list extended ".$Vrf."_VPNSC_GREY_MGMT_ACL";
                $Lin[2] = "   no permit ip ".$Wan." 0.0.0.3 any";       
                $Lin[3] = "	no permit ip ".$Loopback." 0.0.0.3 any";    
                $Lin[4] = "	exit";
                $Lin[5] = "	!";
                $Lin[6] = "!";
                $Lin[7] = "no interface ".$Port.".".$sVlan.$cVlan;
                $Lin[8] = "!";
                $Lin[9] = "no ip route vrf ".$Vrf." ".$Loopback." 255.255.255.255 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                $Lin[10] = "!";
                $Lin[11] = "router bgp 10429	";
                $Lin[12] = " address-family ipv4 vrf ".$Vrf;
                $Lin[13] = "	no neighbor ".$WanRota." remote-as 65001	";
                $Lin[14] = "	no neighbor ".$WanRota." activate	";
                $Lin[15] = "	no neighbor ".$WanRota." as-override	";
                $Lin[16] = "	!";
                $Lin[17] = "	exit";
                $Lin[18] = "	!";
                $Lin[19] = "	exit";
                $Lin[20] = "	!";
                $Lin[21] = "	wr";
                $Lin[22] = "	!";

                $Lin[_CtgLinScript] = 23;  
            } // end if tipo....

            // Checks de VRF
            $Lin[200] = "sh run vrf ".$Vrf;
            $Lin[201] = "sh run grey_mgmt_vpn_Telefonica_Empresas_".$Vrf;
            $Lin[202] = "sh run prefix-set pfx_".$Vrf."_VPNSC_GREY_MGMT";
            $Lin[203] = "sh run router bgp 10429 vrf ".$Vrf;
            $Lin[204] = "     remote-as 65001  <<- Dentro do BGP, ver se esta livre (Greici)VPN segue normal, tira o unreachables disable ";


        }else if($Modelo == 'INTRAGOV_ASR9K'){

           

                
            
                if($Vrf == ''){ $Vrf = '<Vrf_Name>'; }
    
                if(($Tipo == _CFG)||($Tipo == _MIGRA)){
    
                    $Lin[0] = "edit prefix-set pfx_".$Vrf."_VPNSC_GREY_MGMT inline add ".$Loopback."/32";
                    $Lin[1] = "edit prefix-set pfx_".$Vrf."_VPNSC_GREY_MGMT inline add ".$Wan.$WanFx; //  (WAN0-rede)	";
                    $Lin[2] = "!";
                    $Lin[3] = "config e";            
                    $Lin[4] = "interface ".$Port.".".$sVlan.$cVlan." description ".$Port.".".$sVlan.$cVlan." dot1q vlan id=".$sVlan.". By VPNSC: Job Id# = XXXXXX (".$Empresa."_".$ID."_".$OPER.")";
                    $Lin[5] = "interface ".$Port.".".$sVlan.$cVlan." bandwidth ".$Bandwidth;
                    $Lin[6] = "interface ".$Port.".".$sVlan.$cVlan." service-policy output ".$PolicyOUT;
                    $Lin[7] = "interface ".$Port.".".$sVlan.$cVlan." vrf ".$Vrf;
    
                    if(str_contains($WanFx, '1')){
                        $Lin[8] = "interface ".$Port.".".$sVlan.$cVlan." ipv4 address ".$WanLocal." 255.255.255.254";
                    }else{
                        $Lin[8] = "interface ".$Port.".".$sVlan.$cVlan." ipv4 address ".$WanLocal." 255.255.255.252";
                    }
    
                    if(str_contains($WanIpv6, ':')){        // Se Circuito possui IP-Ipv6                
                        $Lin[9] = "interface ".$Port.".".$sVlan.$cVlan." ipv6 address ".$WanIpv6."/127";
                    }else{ $Lin[9] = ""; }
    
                    $Lin[10] = "interface ".$Port.".".$sVlan.$cVlan." encapsulation dot1q ".$sVlan." second-dot1q ".$cVlan;
                    $Lin[11] = "";               
                    if(str_contains($Loopback, '.')){ // Se Circuito possui IP-LoopBack
                        $Lin[12] = "router static vrf ".$Vrf." address-family ipv4 unicast ".$Loopback."/32 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                    }else{ $Lin[12] = ""; }
    
                    if(str_contains($Lan, '.')){    // Se Circuito possui IP-LAN                
                        $Lin[13] = "router static vrf ".$Vrf." address-family ipv4 unicast ".$Lan."/29 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                    }else{ $Lin[13] = ""; }

                    //-------------- Separa/Inclui linhas de rotas-extras INTRAGOV ---------------------//
                    $N = 1;
                    $ExpRtIntragov = explode("\n", $RotasIntragov);            
                    foreach($ExpRtIntragov as $LinRtIntragov){
                        //$LinRtIntragov = str_replace("\n", "", $LinRtIntragov); // Substituir 1000M -> 1G
                        $LinRtIntragov = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($LinRtIntragov));

                        if(str_contains($LinRtIntragov, '.')){

                            $Lin[13+$N] = "router static vrf ".$Vrf." address-family ipv4 unicast ".$LinRtIntragov." ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                            $N++;
                        }
                    }
                    //----------------------------------------------------------------------------------//
                    $Lin[14+$N] = "!";         
    
                    $Lin[15+$N] = "router bgp 10429";
                    $Lin[16+$N] = " vrf ".$Vrf;
                    $Lin[17+$N] = "  neighbor ".$WanRota;
                    $Lin[18+$N] = "   remote-as 65001";
                    $Lin[19+$N] = "   address-family ipv4 unicast";
                    $Lin[20+$N] = "    route-policy IscDefaultPassAll in";
                    $Lin[21+$N] = "    route-policy IscDefaultPassAll out";
                    $Lin[22+$N] = "    as-override";
                    $Lin[23+$N] = "   !";
                    $Lin[24+$N] = "   exit";
                    $Lin[25+$N] = "   !";
                    $Lin[26+$N] = "  exit";
                    $Lin[27+$N] = "  !";
                    $Lin[28+$N] = " exit";
                    $Lin[29+$N] = " !";
                    $Lin[30+$N] = "exit";
                    $Lin[31+$N] = "!";
    
                    // Total lin no script
                    $Lin[_CtgLinScript] = 32+$N;
    
                }else if($Tipo == _DCFG){
    
                    // Desconfiguracao(script)
                    $Lin[0] = "edit prefix-set pfx_".$Vrf."_VPNSC_GREY_MGMT inline remove ".$Loopback."/32";
                    $Lin[1] = "edit prefix-set pfx_".$Vrf."_VPNSC_GREY_MGMT inline remove ".$Wan."/30"; //  (WAN0-rede)	";
                    $Lin[2] = "!";
                    $Lin[3] = "config e";            
                    $Lin[4] = "no interface ".$Port.".".$sVlan.$cVlan;
                    $Lin[5] = "no router static vrf ".$Vrf." address-family ipv4 unicast ".$Lan."/29 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                    $Lin[6] = "no router static vrf ".$Vrf." address-family ipv4 unicast ".$Loopback."/32 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                    $Lin[7] = "!";          
                    $Lin[8] = "router bgp 10429";
                    $Lin[9] = " vrf ".$Vrf;
                    $Lin[10] = "  no neighbor ".$WanRota;
                    $Lin[11] = "   !";
                    $Lin[12] = "   exit";
                    $Lin[13] = "   !";
                    $Lin[14] = "  exit";
                    $Lin[15] = "  !";
                    $Lin[16] = "  commit";
                    $Lin[17] = "  exit";
                    $Lin[18] = "  !";
              
                
                    // Total lin no script
                    $Lin[_CtgLinScript] = 19;
    
                }      
    
                // Checks de VRF
                $Lin[200] = "sh run vrf ".$Vrf;
                $Lin[201] = "sh run grey_mgmt_vpn_Telefonica_Empresas_".$Vrf;
                $Lin[202] = "sh run prefix-set pfx_".$Vrf."_VPNSC_GREY_MGMT";
                $Lin[203] = "sh run router bgp 10429 vrf ".$Vrf;
                $Lin[204] = "     remote-as 65001  <<- Dentro do BGP, ver se esta livre (Greici)VPN segue normal, tira o unreachables disable ";
    

        }else{ // SE nao é VRF....faz check do IPD

            // Script Preview        
            // Ajusta tamanho da LAN e Lo, para padrao
            while(strlen($Lan) != _TamIP){ $Lan = $Lan.' ';  }       
            while(strlen($Loopback) != _TamIP){ $Loopback = $Loopback.' ';  }       
                
            $Lin[200] = " WAN: ................... -> ".$WanLocal." ".$WanFx;            
            $Lin[201] = " LAN: ".$Lan." /29 -> ".$WanRota;            
            $Lin[202] = "  Lo: ".$Loopback." /32 -> ".$WanRota;            
            $Lin[203] = "WAN6: ......................... -> ".$WanIpv6." /127"; 
            if( $this->checkIP($WanIpv6) == 'F'){ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota." <<- Confirme Calc(F+1) rota IPv6";  } 
            else if( $this->checkIP($WanIpv6) == '9'){ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota." <<- Confirme Calc(9+1) rota IPv6"; }  
            else{ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota;  }

        }
                    
        // Verifica antes da config
        //$Lin[100] = "sh conf | inc ".$Speed."M"; // Profile
        $Lin[100] = "Checkar:";        
        $Lin[101] = "sh run interface ".$Port; // Profile
        $Lin[102] = "sh conf run formal | inc .".$sVlan; // Profile 
        $Lin[103] = "sh conf run formal | inc ".$ID; // Profile       
        $Lin[104] = "sh int ".$Port.".".$sVlan.$cVlan;
        $Lin[105] = "sh conf run formal | inc ".$Port; // Profile 
        $Lin[106] = "sh run int ".$Port.".".$sVlan.$cVlan;        
        
        $Lin[107] = "Conferir:";
        $Lin[108] = "sh conf run formal | inc ".$Port.".".$sVlan.$cVlan;
        if( (str_contains($Vrf, 'V')) ){
            $Lin[109] = "sh run prefix-set  pfx_".$Vrf."_VPNSC_GREY_MGMT";
            $Lin[110] = "sh run router bgp 10429 vrf ".$Vrf;
        }ELSE{
            $Lin[109] = "";
            $Lin[110] = "";
        }
        $Lin[111] = "sh int ".$Port.".".$sVlan.$cVlan;
        
        $Lin[112] = "Extras:";
        $Lin[113] = "show commit changes diff"; // Profile
        $Lin[114] = "show config fail"; // Se porta esta livre

        $Lin[115] = "VPN(ASR9K):";
        $Lin[116] = "sh run vrf ".$Vrf;
        $Lin[117] = "sh run route-policy grey_mgmt_vpn_Telefonica_Empresas_".$Vrf;
        $Lin[118] = "sh run prefix-set  pfx_".$Vrf."_VPNSC_GREY_MGMT";
        $Lin[119] = "sh run route static vrf ".$Vrf;
        $Lin[120] = "sh run router bgp 10429 vrf ".$Vrf;
        
        $Lin[121] = "VPN(IOS-XE):";
        $Lin[122] = "sh conf | inc ".$Vrf;
        $Lin[123] = "sh run int ".$Port.".".$sVlan.$cVlan;
        $Lin[124] = "sh conf | inc ".$WanRota;
        $Lin[125] = "sh conf | inc ".$Loopback;
        $Lin[126] = "sh vrf ".$Vrf;
        $Lin[127] = "sh int ".$Port.".".$sVlan.$cVlan;
        
        $Lin[128] = "Tunnel(MPLS):";
        $Lin[129] = "sh int description";
        $Lin[130] = "";
        $Lin[131] = "display current-configuration | include .".$sVlan;
        $Lin[132] = "display current-configuration ";
        $Lin[133] = "";
        $Lin[134] = "sh conf run formal | include .".$sVlan;
        $Lin[135] = "sh run interface ".$Port;
        $Lin[136] = "";
        $Lin[137] = "admin display-config | match context all ".$sVlan;
        $Lin[138] = "admin display-config | match context all ";       
        $Lin[139] = "Extras";
        $Lin[140] = "sh conf run formal | inc l2vpn";
        $Lin[141] = "sh l2vpn xconnect group PW-ACESSO-L3VPN";
        $Lin[142] = "sh l2vpn xconnect interface ".$Port.".".$sVlan;
      
        $Lin[_CtgCmdRouters] = 43; // Contagem dos Cmds      
    
        return ($Lin);	

    }


    function Huawei($Modelo, $ID, $Empresa, $OPER, $Port, $Speed, $ctrlVid, $PolicyIN, $PolicyOUT, $sVlan, $cVlan, $Lan, $Wan, $WanFx, $Loopback, $LanIpv6, $WanIpv6, $Tipo)
    {
        $Lin[] = "";
                
        $Empresa = str_replace(' ', '_', $Empresa);
        $Bandwidth = $this->SpeedToBandwidth($Speed);

        $PolicyIN = str_replace(" ", "", $PolicyIN);  // tira espaços de speed
        $PolicyOUT = str_replace(" ", "", $PolicyOUT);  // tira espaços de speed

        if(!empty($Wan)){
          
            if(str_contains($WanFx, '1')){  // /31       
                $WanLocal = $Wan;
            }else{                          // /30
                $WanLocal = $this->IpToRota($Wan);
            }        
            
            $WanRota = $this->IpToRota($WanLocal);
            $WanIpv6Rota = $this->IpToRota($WanIpv6);
        }else{
            $WanLocal = '0.0.0.0';
            $WanRota = '0.0.0.0';
            $WanIpv6Rota = '0000';
        }    

        if($Modelo == 'NE40E_X8A'){

            if(($Tipo == _CFG)||($Tipo == _MIGRA)){

                $Lin[0] = "sys";
                $Lin[1] = "interface ".$Port.".".$sVlan.$cVlan;
                $Lin[2] = "bandwidth ".$Bandwidth;
                $Lin[3] = "description ".$Port.".".$sVlan.$cVlan." dot1q vlan id=".$sVlan.". By VPNSC: Job Id# = xxxxxx (".$Empresa."_".$ID."_".$OPER.")";
                $Lin[4] = "control-vid ".$ctrlVid." qinq-termination";
                $Lin[5] = "qinq termination pe-vid ".$sVlan." ce-vid ".$cVlan;
                if(str_contains($WanFx, '1')){  // /31
                    $Lin[6] = "ip address ".$WanLocal." 255.255.255.254";
                }else{                          // /30
                    $Lin[6] = "ip address ".$WanLocal." 255.255.255.252";
                }   
               
                if(str_contains($WanIpv6, ':')){ // Se Circuito possui IP-Wan-IPv6
                    $Lin[7] = "ipv6 enable";
                    $Lin[8] = "ipv6 address ".$WanIpv6."/127";      
                }else{ 
                    $Lin[7] = "";
                    $Lin[8] = "";
                }                  
                $Lin[9] = "traffic-policy ".$PolicyIN." inbound";
                $Lin[10] = "traffic-policy ".$PolicyOUT." outbound";
                $Lin[11] = "";

                if(str_contains($Loopback, '.')){ // Se Circuito possui IP-Lo
                    $Lin[12] = "ip route-static ".$Loopback." 255.255.255.255 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                }else{ $Lin[12] = ""; }  
                
                if(str_contains($Lan, '.')){ // Se Circuito possui IP-Lan
                    $Lin[13] = "ip route-static ".$Lan." 255.255.255.248 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                }else{ $Lin[13] = ""; }

                if(str_contains($LanIpv6, ':')){ // Se Circuito possui IP-Lan-IPv6
                    $Lin[14] = "ipv6 route-static ".$LanIpv6." 56 ".$Port.".".$sVlan.$cVlan." ".$WanIpv6Rota;
                }else{ $Lin[14] = ""; }

                $Lin[15] = "!";  
                $Lin[16] = "quit";  
                $Lin[17] = "!";  
                $Lin[18] = "save";  
                $Lin[19] = "!";  
                $Lin[20] = "Y";  

                $Lin[_CtgLinScript] = 21;
            
            }else if($Tipo == _DCFG){

                $Lin[0] = "sys";                
                $Lin[1] = "!"; 
                $Lin[2] = "undo ip route-static ".$Loopback." 255.255.255.255 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                $Lin[3] = "undo ip route-static ".$Lan." 255.255.255.248 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
                $Lin[4] = "undo ipv6 route-static ".$LanIpv6." 56 ".$Port.".".$sVlan.$cVlan." ".$WanIpv6Rota;
                $Lin[5] = "!";  
                $Lin[6] = "undo interface ".$Port.".".$sVlan.$cVlan;
                $Lin[7] = "quit";  
                $Lin[8] = "!"; 
                $Lin[9] = "bgp 10429"; 
                $Lin[10] = "undo peer ".$WanRota; 
                $Lin[11] = "quit";  
                $Lin[12] = "!"; 
                $Lin[13] = "save";  
                $Lin[14] = "!";  
                $Lin[15] = "Y";                  

                $Lin[_CtgLinScript] = 16;
            }

        }else if($Modelo == 'NE40E_X8'){

            if(($Tipo == _CFG)||($Tipo == _MIGRA)){
                $Lin[0] = "sys";
                $Lin[1] = "interface ".$Port.".".$sVlan.$cVlan;
                $Lin[2] = "description ".$Port.".".$sVlan.$cVlan." dot1q vlan id=".$sVlan.". By VPNSC: Job Id# = XXXXXX (".$Empresa."_".$ID."_".$OPER.")";
                if(str_contains($WanIpv6, ':')){ // Se Circuito possui IP-Lan-IPv6
                    $Lin[3] = "ipv6 enable";
                    if(str_contains($WanFx, '1')){  // /31
                        $Lin[4] = "ip address ".$WanLocal." 255.255.255.254";
                    }else{                          // /30
                        $Lin[4] = "ip address ".$WanLocal." 255.255.255.252";
                    } 
                    $Lin[5] = "ipv6 address ".$WanIpv6."/127";
                }else{ 
                    $Lin[3] = "";
                    if(str_contains($WanFx, '1')){  // /31
                        $Lin[4] = "ip address ".$WanLocal." 255.255.255.254";
                    }else{                          // /30
                        $Lin[4] = "ip address ".$WanLocal." 255.255.255.252";
                    } 
                    $Lin[5] = "";
                }

                $Lin[6] = "statistic enable";
                $Lin[7] = "encapsulation qinq-termination";
                $Lin[8] = "traffic-policy ".$PolicyIN." inbound";
                $Lin[9] = "traffic-policy ".$PolicyOUT." outbound";
                $Lin[10] = "qinq termination pe-vid ".$sVlan." ce-vid ".$cVlan;
                $Lin[11] = "arp broadcast enable";
                $Lin[12] = "!";

                if(str_contains($Loopback, '.')){ // Se Circuito possui IP-Lo
                    $Lin[13] = "ip route-static ".$Loopback." 255.255.255.255 ".$Port.".".$sVlan.$cVlan." ".$WanRota." tag ".$ctrlVid." description ".$Empresa."_".$ID;
                }else{ $Lin[13] = ""; } 
                
                if(str_contains($Lan, '.')){ // Se Circuito possui IP-Lan
                    $Lin[14] = "ip route-static ".$Lan." 255.255.255.248 ".$Port.".".$sVlan.$cVlan." ".$WanRota." tag ".$ctrlVid." description ".$Empresa."_".$ID;
                }else{ $Lin[14] = ""; } 

                if(str_contains($LanIpv6, ':')){ // Se Circuito possui IP-Lan-IPv6
                    $Lin[15] = "ipv6 route-static ".$LanIpv6." 56 ".$Port.".".$sVlan.$cVlan." ".$WanIpv6Rota." tag ".$ctrlVid." description ".$Empresa."_".$ID;
                }else{ $Lin[15] = ""; } 

                $Lin[16] = "!";
                $Lin[17] = "commit";
                $Lin[18] = "!";
                $Lin[19] = "quit";
                $Lin[20] = "!";

                $Lin[_CtgLinScript] = 21;

            }else if($Tipo == _DCFG){

                $Lin[0] = "sys";
                $Lin[1] = "undo interface ".$Port.".".$sVlan.$cVlan;
                $Lin[2] = "!";
                $Lin[3] = "undo ip route-static ".$Loopback." 255.255.255.255 ".$Port.".".$sVlan.$cVlan." ".$WanRota." tag ".$ctrlVid." description ".$Empresa."_".$ID;
                $Lin[4] = "undo ip route-static ".$Lan." 255.255.255.248 ".$Port.".".$sVlan.$cVlan." ".$WanRota." tag ".$ctrlVid." description ".$Empresa."_".$ID;
                $Lin[5] = "undo ipv6 route-static ".$LanIpv6." 56 ".$Port.".".$sVlan.$cVlan." ".$WanIpv6Rota." tag ".$ctrlVid." description ".$Empresa."_".$ID;
                $Lin[6] = "!";
                $Lin[7] = "commit";
                $Lin[8] = "!";

                $Lin[_CtgLinScript] = 9;
            }
        }

         // Script Preview        
         // Ajusta tamanho da LAN e Lo, para padrao
         while(strlen($Lan) != _TamIP){ $Lan = $Lan.' ';  }       
         while(strlen($Loopback) != _TamIP){ $Loopback = $Loopback.' ';  }       
               
         $Lin[200] = " WAN: ................... -> ".$WanLocal." ".$WanFx;            
         $Lin[201] = " LAN: ".$Lan." /29 -> ".$WanRota;            
         $Lin[202] = "  Lo: ".$Loopback." /32 -> ".$WanRota;            
         $Lin[203] = "WAN6: ......................... -> ".$WanIpv6." /127"; 
         if( $this->checkIP($WanIpv6) == 'F'){ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota." <<- Confirme Calc(F+1) rota IPv6";  } 
         else if( $this->checkIP($WanIpv6) == '9'){ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota." <<- Confirme Calc(9+1) rota IPv6"; }  
         else{ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota;  }
     

         // Verifica antes da config
         $FinalLanIpv6 = strtoupper(substr($LanIpv6, -6));
         $VidUnit = '7'.substr($cVlan, -2);
         $Lin[100] = "Checkar:";
         $Lin[101] = "disp cur | inc .".$sVlan; // Profile
         $Lin[102] = "disp cur | inc control-vid ".$ctrlVid; // Profile
         $Lin[103] = "disp cur | inc ".$Port.".".$sVlan.$cVlan; // Se porta esta livre   
         $Lin[104] = "disp cur | inc ".$ID; // Profile
         $Lin[105] = "Conferir:";   
         $Lin[106] = "disp cur interface ".$Port.".".$sVlan.$cVlan;
         $Lin[107] = "disp cur | inc ".$WanRota;
         $Lin[108] = "disp cur | inc ".$FinalLanIpv6;         
         $Lin[109] = "display interface ".$Port.".".$sVlan.$cVlan;
         // $Lin[111] = "Extras:";
         $Lin[110] = "Tunnel(MPLS):";
         $Lin[111] = "sh int description";
         $Lin[112] = "";
         $Lin[113] = "display current-configuration | include .".$sVlan;
         $Lin[114] = "display current-configuration interface ";
         $Lin[115] = "";
         $Lin[116] = "sh conf run formal | include .".$sVlan;
         $Lin[117] = "sh run interface ".$Port;
         $Lin[118] = "";
         $Lin[119] = "admin display-config | match context all ".$sVlan;
         $Lin[120] = "admin display-config | match context all "; 
         $Lin[121] = "Extras";
         $Lin[122] = "sh conf run formal | inc l2vpn";
         $Lin[123] = "sh l2vpn xconnect group PW-ACESSO-L3VPN";
         $Lin[124] = "sh l2vpn xconnect interface ".$Port.".".$sVlan;
         $Lin[125] = "disp cur interface ".$Port.".".$sVlan;
         $Lin[126] = "disp mpls l2vc";
         $Lin[127] = "disp mpls l2vc interface ".$Port.".".$sVlan;
        
         $Lin[_CtgCmdRouters] = 28;
    
        return ($Lin);	

    }
    
    function Juniper($Modelo, $ID, $Empresa, $OPER, $Port, $Speed, $Unit, $PolicyIN, $PolicyOUT, $Vrf, $sVlan, $cVlan, $Lan, $Wan, $WanFx, $Loopback, $LanIpv6, $WanIpv6, $Tipo)
    {
        $Lin[] = "";
                
        $Empresa = str_replace(' ', '_', $Empresa);
        $PolicyIN = str_replace(" ", "", $PolicyIN);  // tira espaços de speed
        $PolicyOUT = str_replace(" ", "", $PolicyOUT);  // tira espaços de speed

        if(!empty($Wan)){
            
            if(str_contains($WanFx, '1')){  // /31       
                $WanLocal = $Wan;
            }else{                          // /30
                $WanLocal = $this->IpToRota($Wan);
            }
           
            $WanRota = $this->IpToRota($WanLocal);
            $WanIpv6Rota = $this->IpToRota($WanIpv6);
        }else{
            $WanLocal = '0.0.0.0';
            $WanRota = '0.0.0.0';
            $WanIpv6Rota = '0000';
        }    

        $Speed = (int)$Speed * 1024000;

        if(($Tipo == _CFG)||($Tipo == _MIGRA)){

            $Lin[0] = 'edit private';
            $Lin[1] = 'set interfaces '.$Port.' unit '.$Unit.' description "'.$Port.'.'.$Unit.' dot1q vlan id='.$sVlan.'. By VENSC: Job Id# = XXXX ('.$Empresa.'_ID_'.$ID.'_'.$OPER.')"';
            if($Tipo == _MIGRA){
                $Lin[2] = 'set interfaces '.$Port.' unit '.$Unit.' disable';
            }else{
                $Lin[2] = '';
                // $Lin[2] = 'set interfaces '.$Port.' unit '.$Unit.' bandwidth '.$Speed; << Verificar se esta certo
            }
            $Lin[3] = 'set interfaces '.$Port.' unit '.$Unit.' vlan-tags outer '.$sVlan;
            $Lin[4] = 'set interfaces '.$Port.' unit '.$Unit.' vlan-tags inner '.$cVlan;
            $Lin[5] = 'set interfaces '.$Port.' unit '.$Unit.' family inet rpf-check';
            $Lin[6] = 'set interfaces '.$Port.' unit '.$Unit.' family inet address '.$WanLocal.$WanFx;
            if(str_contains($WanIpv6, ':')){ // Se Circuito possui IP-Lan-IPv6
                $Lin[7] = 'set interfaces '.$Port.' unit '.$Unit.' family inet6 address '.$WanIpv6.'/127';
            }else{ $Lin[7] = ""; } 

            $Lin[8] = 'set interfaces '.$Port.' unit '.$Unit.' family inet policer input '.$PolicyIN;
            $Lin[9] = 'set interfaces '.$Port.' unit '.$Unit.' family inet policer output '.$PolicyOUT;

            if(str_contains($Loopback, '.')){ // Se Circuito possui IP-Lo
                $Lin[10] = 'set routing-options static route '.$Loopback.'/32 qualified-next-hop '.$WanRota;
            }else{ $Lin[10] = ""; } 
   
            if(str_contains($Lan, '.')){ // Se Circuito possui IP-Lan
                $Lin[11] = 'set routing-options static route '.$Lan.'/29 qualified-next-hop '.$WanRota;
            }else{ $Lin[11] = ""; } 

            if(str_contains($LanIpv6, ':')){ // Se Circuito possui IP-Lan-IPv6
                $Lin[12] = 'set routing-options rib inet6.0 static route '.$LanIpv6.'/56 next-hop '.$WanIpv6Rota;
            }else{ $Lin[12] = ""; } 

            $Lin[13] = 'commit';
            $Lin[14] = 'exit';

            $Lin[_CtgLinScript] = 15;  // Total de linhas

        }else if($Tipo == _DCFG){

            $Lin[0] = 'edit private';
            $Lin[1] = 'delete interfaces '.$Port.' unit '.$Unit;
            $Lin[2] = 'delete routing-options static route '.$Loopback.'/32 qualified-next-hop '.$WanRota;
            $Lin[3] = 'delete routing-options static route '.$Lan.'/29 qualified-next-hop '.$WanRota;
            $Lin[4] = 'delete routing-options rib inet6.0 static route '.$LanIpv6.'/56 next-hop '.$WanIpv6Rota;
            $Lin[5] = 'commit';
            $Lin[6] = 'exit';
          
            $Lin[_CtgLinScript] = 7;  // Total de linhas
        }    
        // Script Preview        
         // Ajusta tamanho da LAN e Lo, para padrao
         while(strlen($Lan) != _TamIP){ $Lan = $Lan.' ';  }       
         while(strlen($Loopback) != _TamIP){ $Loopback = $Loopback.' ';  }       
               
         $Lin[200] = " WAN: ................... -> ".$WanLocal." ".$WanFx;            
         $Lin[201] = " LAN: ".$Lan." /29 -> ".$WanRota;            
         $Lin[202] = "  Lo: ".$Loopback." /32 -> ".$WanRota;            
         $Lin[203] = "WAN6: ......................... -> ".$WanIpv6." /127"; 
         if( $this->checkIP($WanIpv6) == 'F'){ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota." <<- Confirme Calc(F+1) rota IPv6";  } 
         else if( $this->checkIP($WanIpv6) == '9'){ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota." <<- Confirme Calc(9+1) rota IPv6"; }  
         else{ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota;  }
     

         // Verifica antes da config
         $FimWanIpv6Rota = substr($WanIpv6Rota, -5);
         $Lin[100] = "Checkar:";
         $Lin[101] = 'show configuration | match outer | display set | match '.$sVlan;
         $Lin[102] = 'show configuration interfaces '.$Port.'.<unit>  | display set'; 
         $Lin[103] = 'show configuration interfaces '.$Port.' unit '.$Unit; // Profile           
         $Lin[104] = 'show configuration | match '.$ID.' | display set';
         $Lin[105] = "Conferir:";
         $Lin[106] = 'show configuration interfaces '.$Port.'.'.$Unit.' | display set';           
         $Lin[107] = 'show configuration | match '.$WanRota.' | display set'; 
         $Lin[108] = 'show configuration | match '.$FimWanIpv6Rota.' | display set'; 
         $Lin[109] = 'show interfaces terse '.$Port.'.'.$Unit; 
         $Lin[110] = "Extras:";
         $Lin[111] = 'show configuration | match '.$sVlan.' | display set';
         $Lin[112] = 'show configuration | match '.$Port.' | display set';
         $Lin[113] = 'show interfaces terse '.$Port; 
         

         $Lin[114] = "VPN(MX480):";
         $Lin[115] = "show configuration | match ".$Vrf." | display set";
         $Lin[116] = "ping routing-instance ".$Vrf." ".$WanRota;
        

         $Lin[_CtgCmdRouters] = 17;
    
        return ($Lin);	

    }

    function Nokia($Modelo, $ID, $Empresa, $OPER, $Port, $Speed, $PolicyIN, $PolicyOUT, $sVlan, $cVlan, $Lan, $Wan, $WanFx, $Loopback, $LanIpv6, $WanIpv6, $Tipo, $Ies)
    {
        $Lin[] = "";
                
        $Empresa = str_replace(' ', '_', $Empresa);
        $Port = strtolower($Port); // converte: 2/1/C8/2 -> 2/1/c8/2 
        $Port = str_replace('sap1', 'sap 1', $Port); 
        $Port = str_replace('sap2', 'sap 2', $Port); 

        $PolicyIN = str_replace(" ", "", $PolicyIN);  // tira espaços de speed
        $PolicyOUT = str_replace(" ", "", $PolicyOUT);  // tira espaços de speed

        if(!empty($Wan)){
             
            if(str_contains($WanFx, '1')){  // /31       
                $WanLocal = $Wan;
            }else{                          // /30
                $WanLocal = $this->IpToRota($Wan);
            }
           
            $WanRota = $this->IpToRota($WanLocal);
            $WanIpv6Rota = $this->IpToRota($WanIpv6);
        }else{
            $WanLocal = '0.0.0.0';
            $WanRota = '0.0.0.0';
            $WanIpv6Rota = '0000:0000:0000:0000:0000:0000';
        }    



       
        if($Modelo == 'SR7750_Plcy'){ // Mar2025

                if(($Tipo == _CFG)||($Tipo == _MIGRA)){
                    if(str_contains($Ies, 'ID')){   // Tipo config do Ies: pelo ID ou pela scVlan 
                        $Lin[0] = 'configure service ies '.$ID.' name "'.$ID.'" customer 1 create'; 
                    }else{ 
                        $Lin[0] = 'configure service ies '.$sVlan.$cVlan.' name "'.$sVlan.$cVlan.'" customer 1 create'; 
                    }
                    
                    $Lin[1] = 'interface "'.$Empresa.'_'.$ID.'_'.$OPER.'" create';
                    $Lin[2] = '     address '.$WanLocal.$WanFx;
                    if(str_contains($WanIpv6, ':')){ // Se Circuito possui IP-Lan-IPv6
                        $Lin[3] = '     ipv6';
                        $Lin[4] = '          address '.$WanIpv6.'/127';
                        $Lin[5] = '     exit';
                       
                    }else{ 
                        $Lin[3] = '';
                        $Lin[4] = '';
                        $Lin[5] = '';                        
                    } 
                    //echo 'Fnc_plcy:'. $Port.', '.$Modelo.', ';
                    if(str_contains($Port, 'pw')){
                        $Lin[6] = '     '.$Port.':'.$cVlan.' create';
                    }else{
                        $Lin[6] = '     '.$Port.':'.$sVlan.'.'.$cVlan.' create';
                    }
                    $Lin[7] = '     ingress';
                    $Lin[8] = '          policer-control-policy "'.$PolicyIN.'"';
                    //$Lin[8] = '          policer-control-policy "IPD_SECURITY_IN_'.$Speed.'M"';
                    $Lin[9] = '          exit';
                    $Lin[10] = '     egress';
                    $Lin[11] = '          scheduler-policy "'.$PolicyOUT.'"';
                    //$Lin[11] = '          scheduler-policy "IPD_OUT_'.$Speed.'M_SHAPE"';
                    $Lin[12] = '          exit';
                    $Lin[13] = '     exit';
                    $Lin[14] = '     exit';
                    $Lin[15] = '   no shutdown';
                    $Lin[16] = 'exit all';
    
                    /// ate New ok, ,
                    if(str_contains($Lan, '.')){ // Se Circuito possui IP-Lan
                        $Lin[17] = 'configure router static-route-entry '.$Lan.'/29';
                        $Lin[18] = '       next-hop '.$WanRota;
                        $Lin[19] = '           description "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                        $Lin[20] = '           no shutdown';
                        $Lin[21] = 'exit all';
                    }else{ 
                        $Lin[17] = '';
                        $Lin[18] = '';
                        $Lin[19] = '';
                        $Lin[20] = '';
                        $Lin[21] = '';
                    } 
    
                    if(str_contains($Loopback, '.')){ // Se Circuito possui IP-Lo
                        $Lin[22] = 'configure router static-route-entry '.$Loopback.'/32';
                        $Lin[23] = '       next-hop '.$WanRota;
                        $Lin[24] = '           description "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                        $Lin[25] = '           no shutdown';
                        $Lin[26] = 'exit all';
                    }else{ 
                        $Lin[22] = '';
                        $Lin[23] = '';
                        $Lin[24] = '';
                        $Lin[25] = '';
                        $Lin[26] = '';
                    }
                    if(str_contains($LanIpv6, ':')){ // Se Circuito possui IP-Lan-IPv6
                        $Lin[27] = 'configure router static-route-entry '.$LanIpv6.'/56';
                        $Lin[28] = '       next-hop '.$WanIpv6Rota;
                        $Lin[29] = '           description "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                        $Lin[30] = '           no shutdown';
                        $Lin[31] = 'exit all';   
                    }else{ 
                        $Lin[27] = '';
                        $Lin[28] = '';
                        $Lin[29] = '';
                        $Lin[30] = '';
                        $Lin[31] = '';
                    }                
    
                    $Lin[_CtgLinScript] = 32;  // Total de linhas
                
                }else if($Tipo == _DCFG){
    
                    $Lin[0] = 'configure service'; 
                    
                    if(str_contains($Ies, 'ID')){   // Tipo config do Ies: pelo ID ou pela scVlan 
                        $Lin[1] = 'ies '.$ID.' name "'.$ID.'"'; 
                    }else{ 
                        $Lin[1] = 'ies '.$sVlan.$cVlan.' name "'.$sVlan.$cVlan.'"'; 
                    }
                    
                    //$Lin[1] = 'ies '.$sVlan.$cVlan.' name "'.$sVlan.$cVlan.'"';                    
                    $Lin[2] = 'interface "'.$Empresa.'_'.$ID.'_'.$OPER.'"';           
                    $Lin[3] = $Port.':'.$sVlan.'.'.$cVlan;
                    $Lin[4] = 'shut';
                    $Lin[5] = 'exit';
                    $Lin[6] = 'no '.$Port.':'.$sVlan.'.'.$cVlan;
                    $Lin[7] = 'shut';
                    $Lin[8] = 'exit';
                    $Lin[9] = 'no interface "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                    $Lin[10] = 'shut';
                    $Lin[11] = 'exit'; 
                    if(str_contains($Ies, 'ID')){   // Tipo config do Ies: pelo ID ou pela scVlan 
                        $Lin[12] = 'no ies '.$ID; 
                    }else{ 
                        $Lin[12] = 'no ies '.$sVlan.$cVlan; 
                    }
                    //$Lin[12] = 'no ies '.$sVlan.$cVlan;         
                    $Lin[13] = 'exit all';
                    $Lin[14] = '!';
        
                    $Lin[15] = 'configure router';
                    $Lin[16] = 'static-route-entry '.$Lan.'/29';
                    $Lin[17] = 'no next-hop '.$WanRota;           
                    $Lin[18] = 'exit';
                    $Lin[19] = 'static-route-entry '.$Loopback.'/32';
                    $Lin[20] = 'no next-hop '.$WanRota;           
                    $Lin[21] = 'exit';
                    $Lin[22] = 'static-route-entry '.$LanIpv6.'/56';
                    $Lin[23] = 'no next-hop '.$WanIpv6Rota;            
                    $Lin[24] = 'exit all';  	       
                   
                    $Lin[_CtgLinScript] = 25;  // Total de linhas
        
                }

        }else if($Modelo == 'SR7750_PlcyApk1'){ // Mar2025

                if(($Tipo == _CFG)||($Tipo == _MIGRA)){
                    $Lin[0] = 'configure service'; 
                    if(str_contains($Ies, 'ID')){   // Tipo config do Ies: pelo ID ou pela scVlan 
                        $Lin[1] = '    ies '.$ID.' name "'.$ID.'" customer 1 create'; 
                    }else{ 
                        $Lin[1] = '    ies '.$sVlan.$cVlan.' name "'.$sVlan.$cVlan.'" customer 1 create'; 
                    }
                    
                    $Lin[2] = '        interface "'.$Empresa.'_'.$ID.'_'.$OPER.'" create';
                    $Lin[3] = '        exit';
                    $Lin[4] = '    exit';
                  
                    if(str_contains($Ies, 'ID')){   // Tipo config do Ies: pelo ID ou pela scVlan 
                        $Lin[5] = '    ies '.$ID.' name "'.$ID.'" customer 1 create'; 
                    }else{ 
                        $Lin[5] = '    ies '.$sVlan.$cVlan.' name "'.$sVlan.$cVlan.'" customer 1 create'; 
                    }
                    
                    $Lin[6] = '     interface "'.$Empresa.'_'.$ID.'_'.$OPER.'" create';
                    $Lin[7] = '        address '.$WanLocal.$WanFx;
                    if(str_contains($WanIpv6, ':')){ // Se Circuito possui IP-Lan-IPv6
                        $Lin[8] = '        ipv6';
                        $Lin[9] = '             address '.$WanIpv6.'/127';
                        $Lin[10] = '         exit';
                       
                    }else{ 
                        $Lin[8] = '';
                        $Lin[9] = '';
                        $Lin[10] = '';                        
                    } 
                    //echo 'Fnc_plcy:'. $Port.', '.$Modelo.', ';
                    if(str_contains($Port, 'pw')){
                        $Lin[11] = '         '.$Port.':'.$cVlan.' create'; // sap pw-1028:100
                    }else{
                        $Lin[11] = '         '.$Port.':'.$sVlan.'.'.$cVlan.' create'; // sap 2/1/c9/1:2555.100
                    }
                    // ate aki ok
                    $Lin[12] = '            ingress';
                    $Lin[13] = '                policer-control-policy "'.$PolicyIN.'"';
                    $Lin[14] = '                qos 11111';
                    $Lin[15] = '            exit';
                    $Lin[16] = '            egress';
                    $Lin[17] = '                scheduler-policy "'.$PolicyOUT.'"';
                    $Lin[18] = '                qos 11111';
                    $Lin[19] = '            exit';

                    $Lin[20] = '         exit';
                    $Lin[21] = '       exit';
                    $Lin[22] = '   no shutdown';
                    $Lin[23] = 'exit all';

                    /// ate New ok, ,
                    if(str_contains($Lan, '.')){ // Se Circuito possui IP-Lan
                        $Lin[24] = 'configure router static-route-entry '.$Lan.'/29';
                        $Lin[25] = '       next-hop '.$WanRota;
                        $Lin[26] = '           description "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                        $Lin[27] = '           no shutdown';
                        $Lin[28] = 'exit all';
                    }else{ 
                        $Lin[24] = '';
                        $Lin[25] = '';
                        $Lin[26] = '';
                        $Lin[27] = '';
                        $Lin[28] = '';
                    } 
    
                    if(str_contains($Loopback, '.')){ // Se Circuito possui IP-Lo
                        $Lin[29] = 'configure router static-route-entry '.$Loopback.'/32';
                        $Lin[30] = '       next-hop '.$WanRota;
                        $Lin[31] = '           description "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                        $Lin[32] = '           no shutdown';
                        $Lin[33] = 'exit all';
                    }else{ 
                        $Lin[29] = '';
                        $Lin[30] = '';
                        $Lin[31] = '';
                        $Lin[32] = '';
                        $Lin[33] = '';
                    }
                    if(str_contains($LanIpv6, ':')){ // Se Circuito possui IP-Lan-IPv6
                        $Lin[34] = 'configure router static-route-entry '.$LanIpv6.'/56';
                        $Lin[35] = '       next-hop '.$WanIpv6Rota;
                        $Lin[36] = '           description "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                        $Lin[37] = '           no shutdown';
                        $Lin[38] = 'exit all';   
                    }else{ 
                        $Lin[34] = '';
                        $Lin[35] = '';
                        $Lin[36] = '';
                        $Lin[37] = '';
                        $Lin[38] = '';
                    }                
    
                    $Lin[_CtgLinScript] = 39;  // Total de linhas
                
                }else if($Tipo == _DCFG){
    
                    $Lin[0] = 'configure service'; 
                    
                    if(str_contains($Ies, 'ID')){   // Tipo config do Ies: pelo ID ou pela scVlan 
                        $Lin[1] = 'ies '.$ID.' name "'.$ID.'"'; 
                    }else{ 
                        $Lin[1] = 'ies '.$sVlan.$cVlan.' name "'.$ID.'"'; 
                    }
                    
                    //$Lin[1] = 'ies '.$sVlan.$cVlan.' name "'.$sVlan.$cVlan.'"';                    
                    $Lin[2] = 'interface "'.$Empresa.'_'.$ID.'_'.$OPER.'"';  
                    if(str_contains($Port, 'pw')){         
                        $Lin[3] = $Port.':'.$cVlan;
                    }else{
                        $Lin[3] = $Port.':'.$sVlan.'.'.$cVlan;
                    }
                    $Lin[4] = 'shut';
                    $Lin[5] = 'exit';
                    $Lin[6] = 'no '.$Port.':'.$sVlan.'.'.$cVlan;
                    $Lin[7] = 'shut';
                    $Lin[8] = 'exit';
                    $Lin[9] = 'no interface "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                    $Lin[10] = 'shut';
                    $Lin[11] = 'exit'; 
                    if(str_contains($Ies, 'ID')){   // Tipo config do Ies: pelo ID ou pela scVlan 
                        $Lin[12] = 'no ies '.$ID; 
                    }else{ 
                        $Lin[12] = 'no ies '.$sVlan.$cVlan; 
                    }
                    //$Lin[12] = 'no ies '.$sVlan.$cVlan;         
                    $Lin[13] = 'exit all';
                    $Lin[14] = '!';
        
                    $Lin[15] = 'configure router';
                    $Lin[16] = 'static-route-entry '.$Lan.'/29';
                    $Lin[17] = 'no next-hop '.$WanRota;           
                    $Lin[18] = 'exit';
                    $Lin[19] = 'static-route-entry '.$Loopback.'/32';
                    $Lin[20] = 'no next-hop '.$WanRota;           
                    $Lin[21] = 'exit';
                    $Lin[22] = 'static-route-entry '.$LanIpv6.'/56';
                    $Lin[23] = 'no next-hop '.$WanIpv6Rota;            
                    $Lin[24] = 'exit all';  	       
                   
                    $Lin[_CtgLinScript] = 25;  // Total de linhas
        
                }
    
    
        }else if($Modelo == 'SR7750_Plcy_RB'){ // Mar2025

                    if(($Tipo == _CFG)||($Tipo == _MIGRA)){
                        $Lin[0] = 'configure service'; 
                        if(str_contains($Ies, 'ID')){   // Tipo config do Ies: pelo ID ou pela scVlan 
                            $Lin[1] = '    ies '.$ID.' name "'.$ID.'" customer 1 create'; 
                        }else{ 
                            $Lin[1] = '    ies '.$sVlan.$cVlan.' name "'.$sVlan.$cVlan.'" customer 1 create'; 
                        }
                        
                        $Lin[2] = '        interface "'.$Empresa.'_'.$ID.'_'.$OPER.'" create';
                        $Lin[3] = '        exit';
                      
                        if(str_contains($Ies, 'ID')){   // Tipo config do Ies: pelo ID ou pela scVlan 
                            $Lin[4] = '    ies '.$ID.' name "'.$ID.'" customer 1 create'; 
                        }else{ 
                            $Lin[4] = '    ies '.$sVlan.$cVlan.' name "'.$sVlan.$cVlan.'" customer 1 create'; 
                        }
                        
                        $Lin[5] = '     interface "'.$Empresa.'_'.$ID.'_'.$OPER.'" create';
                        $Lin[6] = '        address '.$WanLocal.$WanFx;
                        $Lin[7] = '        cflowd-parameters';
                        $Lin[8] = '           sampling unicast type interface';
                        $Lin[9] = '        exit';


                        if(str_contains($WanIpv6, ':')){ // Se Circuito possui IP-Lan-IPv6
                            $Lin[10] = '        ipv6';
                            $Lin[11] = '             address '.$WanIpv6.'/127';
                            $Lin[12] = '             urpf-check';
                            $Lin[13] = '                 mode loose';
                            $Lin[14] = '             exit';
                            $Lin[15] = '         exit';
                           
                        }else{ 
                            $Lin[10] = '';
                            $Lin[11] = '';
                            $Lin[12] = '';                        
                            $Lin[13] = '';                        
                            $Lin[14] = '';                        
                            $Lin[15] = '';                        
                        } 
                        //echo 'Fnc_plcy:'. $Port.', '.$Modelo.', ';
                        if(str_contains($Port, 'pw')){
                            $Lin[16] = '         '.$Port.':'.$cVlan.' create'; // sap 2/1/c9/1:2555.100
                        }else{
                            $Lin[16] = '         '.$Port.':'.$sVlan.'.'.$cVlan.' create'; // sap 2/1/c9/1:2555.100
                        }
                        $Lin[17] = '          ingress';
                        $Lin[18] = '              policer-control-policy "'.$PolicyIN.'"';
                        $Lin[19] = '              qos 11111';
                        //$Lin[8] = '          policer-control-policy "IPD_SECURITY_IN_'.$Speed.'M"';
                        $Lin[20] = '          exit';
                        $Lin[21] = '          egress';
                        $Lin[22] = '              scheduler-policy "'.$PolicyOUT.'"';
                        $Lin[23] = '              qos 11111';
                        //$Lin[11] = '          scheduler-policy "IPD_OUT_'.$Speed.'M_SHAPE"';
                        $Lin[24] = '          exit';
                        $Lin[25] = '       exit';
                        $Lin[26] = '     exit';
                        $Lin[27] = '   no shutdown';
        
                        /// ate New ok, ,
                        if(str_contains($Lan, '.')){ // Se Circuito possui IP-Lan
                            $Lin[28] = 'configure router static-route-entry '.$Lan.'/29';
                            $Lin[29] = '       next-hop '.$WanRota;
                            $Lin[30] = '           description "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                            $Lin[31] = '           no shutdown';
                            $Lin[32] = 'exit all';
                        }else{ 
                            $Lin[28] = '';
                            $Lin[29] = '';
                            $Lin[30] = '';
                            $Lin[31] = '';
                            $Lin[32] = '';
                        } 
        
                        if(str_contains($Loopback, '.')){ // Se Circuito possui IP-Lo
                            $Lin[33] = 'configure router static-route-entry '.$Loopback.'/32';
                            $Lin[34] = '       next-hop '.$WanRota;
                            $Lin[35] = '           description "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                            $Lin[36] = '           no shutdown';
                            $Lin[37] = 'exit all';
                        }else{ 
                            $Lin[33] = '';
                            $Lin[34] = '';
                            $Lin[35] = '';
                            $Lin[36] = '';
                            $Lin[37] = '';
                        }
                        if(str_contains($LanIpv6, ':')){ // Se Circuito possui IP-Lan-IPv6
                            $Lin[38] = 'configure router static-route-entry '.$LanIpv6.'/56';
                            $Lin[39] = '       next-hop '.$WanIpv6Rota;
                            $Lin[40] = '           description "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                            $Lin[41] = '           no shutdown';
                            $Lin[42] = 'exit all';   
                        }else{ 
                            $Lin[38] = '';
                            $Lin[39] = '';
                            $Lin[40] = '';
                            $Lin[41] = '';
                            $Lin[42] = '';
                        }                
        
                        $Lin[_CtgLinScript] = 43;  // Total de linhas
                    
                    }else if($Tipo == _DCFG){
        
                        $Lin[0] = 'configure service'; 
                        
                        if(str_contains($Ies, 'ID')){   // Tipo config do Ies: pelo ID ou pela scVlan 
                            $Lin[1] = 'ies '.$ID.' name "'.$ID.'"'; 
                        }else{ 
                            $Lin[1] = 'ies '.$sVlan.$cVlan.' name "'.$sVlan.$cVlan.'"'; 
                        }
                        
                        //$Lin[1] = 'ies '.$sVlan.$cVlan.' name "'.$sVlan.$cVlan.'"';                    
                        $Lin[2] = 'interface "'.$Empresa.'_'.$ID.'_'.$OPER.'"';           
                        $Lin[3] = $Port.':'.$sVlan.'.'.$cVlan;
                        $Lin[4] = 'shut';
                        $Lin[5] = 'exit';
                        $Lin[6] = 'no '.$Port.':'.$sVlan.'.'.$cVlan;
                        $Lin[7] = 'shut';
                        $Lin[8] = 'exit';
                        $Lin[9] = 'no interface "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                        $Lin[10] = 'shut';
                        $Lin[11] = 'exit'; 
                        if(str_contains($Ies, 'ID')){   // Tipo config do Ies: pelo ID ou pela scVlan 
                            $Lin[12] = 'no ies '.$ID; 
                        }else{ 
                            $Lin[12] = 'no ies '.$sVlan.$cVlan; 
                        }
                        //$Lin[12] = 'no ies '.$sVlan.$cVlan;         
                        $Lin[13] = 'exit all';
                        $Lin[14] = '!';
            
                        $Lin[15] = 'configure router';
                        $Lin[16] = 'static-route-entry '.$Lan.'/29';
                        $Lin[17] = 'no next-hop '.$WanRota;           
                        $Lin[18] = 'exit';
                        $Lin[19] = 'static-route-entry '.$Loopback.'/32';
                        $Lin[20] = 'no next-hop '.$WanRota;           
                        $Lin[21] = 'exit';
                        $Lin[22] = 'static-route-entry '.$LanIpv6.'/56';
                        $Lin[23] = 'no next-hop '.$WanIpv6Rota;            
                        $Lin[24] = 'exit all';  	       
                       
                        $Lin[_CtgLinScript] = 25;  // Total de linhas
            
                    }
        
                }else if($Modelo == 'SR7750_Plcy_ESAT'){ // Mar2025

                    if(($Tipo == _CFG)||($Tipo == _MIGRA)){
                        $Lin[0] = 'configure service'; 
                        if(str_contains($Ies, 'ID')){   // Tipo config do Ies: pelo ID ou pela scVlan 
                            $Lin[1] = '  ies '.$ID.' name "'.$ID.'" customer 1 create'; 
                        }else{ 
                            $Lin[1] = '  ies '.$sVlan.$cVlan.' name "'.$sVlan.$cVlan.'" customer 1 create'; 
                        }
                        
                        $Lin[2] = '        interface "'.$Empresa.'_'.$ID.'_'.$OPER.'" create';
                        $Lin[3] = '        exit';
                      
                        if(str_contains($Ies, 'ID')){   // Tipo config do Ies: pelo ID ou pela scVlan 
                            $Lin[4] = '  ies '.$ID.' name "'.$ID.'" customer 1 create'; 
                        }else{ 
                            $Lin[4] = '  ies '.$sVlan.$cVlan.' name "'.$sVlan.$cVlan.'" customer 1 create'; 
                        }
                        
                        $Lin[5] = '     description "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                        $Lin[6] = '     interface "'.$Empresa.'_'.$ID.'_'.$OPER.'" create';
                        $Lin[7] = '        description "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                        $Lin[8] = '        enable-ingress-stats';
                        $Lin[9] = '        address '.$WanLocal.$WanFx;
                        $Lin[10] = '        cflowd-parameters';
                        $Lin[11] = '           sampling unicast type interface';
                        $Lin[12] = '        exit';


                        if(str_contains($WanIpv6, ':')){ // Se Circuito possui IP-Lan-IPv6
                            $Lin[13] = '        ipv6';
                            $Lin[14] = '             address '.$WanIpv6.'/127';
                            $Lin[15] = '             urpf-check';
                            $Lin[16] = '                 mode loose';
                            $Lin[17] = '             exit';
                            $Lin[18] = '         exit';
                           
                        }else{ 
                            $Lin[13] = '';
                            $Lin[14] = '';
                            $Lin[15] = '';                        
                            $Lin[16] = '';                        
                            $Lin[17] = '';                        
                            $Lin[18] = '';                        
                        } 
                        //echo 'Fnc_plcy:'. $Port.', '.$Modelo.', ';
                        if(str_contains($Port, 'pw')){
                            $Lin[19] = '         '.$Port.':'.$cVlan.' create'; // sap 2/1/c9/1:2555.100
                        }else{
                            $Lin[19] = '         '.$Port.':'.$sVlan.'.'.$cVlan.' create'; // sap 2/1/c9/1:2555.100
                        }
                        $Lin[20] = '          ingress';
                        $Lin[21] = '              policer-control-policy "'.$PolicyIN.'"';
                        $Lin[22] = '              qos 11111';
                        //$Lin[8] = '          policer-control-policy "IPD_SECURITY_IN_'.$Speed.'M"';
                        $Lin[23] = '          exit';
                        $Lin[24] = '          egress';
                        $Lin[25] = '              scheduler-policy "'.$PolicyOUT.'"';
                        $Lin[26] = '              qos 11111';
                        //$Lin[11] = '          scheduler-policy "IPD_OUT_'.$Speed.'M_SHAPE"';
                        $Lin[27] = '          exit';
                        $Lin[28] = '       exit';
                        $Lin[29] = '       urpf-check';
                        $Lin[30] = '       exit';
                        $Lin[31] = '   exit';
                        $Lin[32] = '   no shutdown';
                        $Lin[33] = 'exit';

                        /// ate New ok, ,
                        if(str_contains($Lan, '.')){ // Se Circuito possui IP-Lan
                            $Lin[34] = 'configure router static-route-entry '.$Lan.'/29';
                            $Lin[35] = '       next-hop '.$WanRota;
                            $Lin[36] = '           description "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                            $Lin[37] = '           no shutdown';
                            $Lin[38] = 'exit all';
                        }else{ 
                            $Lin[34] = '';
                            $Lin[35] = '';
                            $Lin[36] = '';
                            $Lin[37] = '';
                            $Lin[38] = '';
                        } 
        
                        if(str_contains($Loopback, '.')){ // Se Circuito possui IP-Lo
                            $Lin[39] = 'configure router static-route-entry '.$Loopback.'/32';
                            $Lin[40] = '       next-hop '.$WanRota;
                            $Lin[41] = '           description "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                            $Lin[42] = '           no shutdown';
                            $Lin[43] = 'exit all';
                        }else{ 
                            $Lin[39] = '';
                            $Lin[40] = '';
                            $Lin[41] = '';
                            $Lin[42] = '';
                            $Lin[43] = '';
                        }
                        if(str_contains($LanIpv6, ':')){ // Se Circuito possui IP-Lan-IPv6
                            $Lin[44] = 'configure router static-route-entry '.$LanIpv6.'/56';
                            $Lin[45] = '       next-hop '.$WanIpv6Rota;
                            $Lin[46] = '           description "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                            $Lin[47] = '           no shutdown';
                            $Lin[48] = 'exit all';   
                        }else{ 
                            $Lin[44] = '';
                            $Lin[45] = '';
                            $Lin[46] = '';
                            $Lin[47] = '';
                            $Lin[48] = '';
                        } 
                        $Lin[49] = '!';               
                        $Lin[50] = 'Aplicado no ID 2003859 - OK !!!';               
        
                        $Lin[_CtgLinScript] = 51;  // Total de linhas
                    
                    }else if($Tipo == _DCFG){
        
                        $Lin[0] = 'configure service'; 
                        
                        if(str_contains($Ies, 'ID')){   // Tipo config do Ies: pelo ID ou pela scVlan 
                            $Lin[1] = 'ies '.$ID.' name "'.$ID.'"'; 
                        }else{ 
                            $Lin[1] = 'ies '.$sVlan.$cVlan.' name "'.$sVlan.$cVlan.'"'; 
                        }
                        
                        //$Lin[1] = 'ies '.$sVlan.$cVlan.' name "'.$sVlan.$cVlan.'"';                    
                        $Lin[2] = 'interface "'.$Empresa.'_'.$ID.'_'.$OPER.'"';           
                        $Lin[3] = $Port.':'.$sVlan.'.'.$cVlan;
                        $Lin[4] = 'shut';
                        $Lin[5] = 'exit';
                        $Lin[6] = 'no '.$Port.':'.$sVlan.'.'.$cVlan;
                        $Lin[7] = 'shut';
                        $Lin[8] = 'exit';
                        $Lin[9] = 'no interface "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                        $Lin[10] = 'shut';
                        $Lin[11] = 'exit'; 
                        if(str_contains($Ies, 'ID')){   // Tipo config do Ies: pelo ID ou pela scVlan 
                            $Lin[12] = 'no ies '.$ID; 
                        }else{ 
                            $Lin[12] = 'no ies '.$sVlan.$cVlan; 
                        }
                        //$Lin[12] = 'no ies '.$sVlan.$cVlan;         
                        $Lin[13] = 'exit all';
                        $Lin[14] = '!';
            
                        $Lin[15] = 'configure router';
                        $Lin[16] = 'static-route-entry '.$Lan.'/29';
                        $Lin[17] = 'no next-hop '.$WanRota;           
                        $Lin[18] = 'exit';
                        $Lin[19] = 'static-route-entry '.$Loopback.'/32';
                        $Lin[20] = 'no next-hop '.$WanRota;           
                        $Lin[21] = 'exit';
                        $Lin[22] = 'static-route-entry '.$LanIpv6.'/56';
                        $Lin[23] = 'no next-hop '.$WanIpv6Rota;            
                        $Lin[24] = 'exit all';  	       
                       
                        $Lin[_CtgLinScript] = 25;  // Total de linhas
            
                    }
        
       
    
        }else if($Modelo == 'SR7750'){

            if(($Tipo == _CFG)||($Tipo == _MIGRA)){
                if(str_contains($Ies, 'ID')){   // Tipo config do Ies: pelo ID ou pela scVlan 
                    $Lin[0] = 'configure service ies '.$ID.' name "'.$ID.'" customer 1 create'; 
                }else{ 
                    $Lin[0] = 'configure service ies '.$sVlan.$cVlan.' name "'.$sVlan.$cVlan.'" customer 1 create'; 
                }
                
                $Lin[1] = 'interface "'.$Empresa.'_'.$ID.'_'.$OPER.'" create';
                $Lin[2] = '     address '.$WanLocal.$WanFx;
                if(str_contains($Port, 'pw')){
                    $Lin[3] = '     '.$Port.':'.$cVlan.' create';
                }else{
                    $Lin[3] = '     '.$Port.':'.$cVlan.'.'.$cVlan.' create';
                }
                $Lin[4] = '     exit';

                if(str_contains($WanIpv6, ':')){ // Se Circuito possui IP-Lan-IPv6
                    $Lin[5] = 'ipv6';
                    $Lin[6] = '          address '.$WanIpv6.'/127';
                    $Lin[7] = '          urpf-check';
                    $Lin[8] = '              mode loose';
                    $Lin[9] = ' exit';
                }else{ 
                    $Lin[5] = '';
                    $Lin[6] = '';
                    $Lin[7] = '';
                    $Lin[8] = '';
                    $Lin[9] = '';
                } 

                $Lin[10] = '         urpf-check';
                $Lin[11] = '              mode loose';
                $Lin[12] = '         exit';
                $Lin[13] = '  exit';
                $Lin[14] = '  no shutdown';
                $Lin[15] = 'exit';
                $Lin[16] = 'no shutdown';
                $Lin[17] = 'exit all';
                $Lin[18] = '';
                
                if(str_contains($Lan, '.')){ // Se Circuito possui IP-Lan
                    $Lin[19] = 'configure router static-route-entry '.$Lan.'/29';
                    $Lin[20] = '       next-hop '.$WanRota;
                    $Lin[21] = '           description "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                    $Lin[22] = '           no shutdown';
                    $Lin[23] = 'exit all';
                }else{ 
                    $Lin[19] = '';
                    $Lin[20] = '';
                    $Lin[21] = '';
                    $Lin[22] = '';
                    $Lin[23] = '';
                } 

                if(str_contains($Loopback, '.')){ // Se Circuito possui IP-Lo
                    $Lin[24] = 'configure router static-route-entry '.$Loopback.'/32';
                    $Lin[25] = '       next-hop '.$WanRota;
                    $Lin[26] = '           description "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                    $Lin[27] = '           no shutdown';
                    $Lin[28] = 'exit all';
                }else{ 
                    $Lin[24] = '';
                    $Lin[25] = '';
                    $Lin[26] = '';
                    $Lin[27] = '';
                    $Lin[28] = '';
                }
                if(str_contains($LanIpv6, ':')){ // Se Circuito possui IP-Lan-IPv6
                    $Lin[29] = 'configure router static-route-entry '.$LanIpv6.'/56';
                    $Lin[30] = '       next-hop '.$WanIpv6Rota;
                    $Lin[31] = '           description "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                    $Lin[32] = '           no shutdown';
                    $Lin[33] = 'exit all';   
                }else{ 
                    $Lin[29] = '';
                    $Lin[30] = '';
                    $Lin[31] = '';
                    $Lin[32] = '';
                    $Lin[33] = '';
                }                

                $Lin[_CtgLinScript] = 34;  // Total de linhas
            
            }else if($Tipo == _DCFG){

                $Lin[0] = 'configure service'; 
                if(str_contains($Ies, 'ID')){   // Tipo config do Ies: pelo ID ou pela scVlan 
                    $Lin[1] = 'ies '.$ID.' name "'.$ID.'"'; 
                }else{ 
                    $Lin[1] = 'ies '.$sVlan.$cVlan.' name "'.$sVlan.$cVlan.'"'; 
                }
                //$Lin[1] = 'ies '.$sVlan.$cVlan.' name "'.$sVlan.$cVlan.'"';
                $Lin[2] = 'interface "'.$Empresa.'_'.$ID.'_'.$OPER.'"';           
                $Lin[3] = $Port.':'.$sVlan.'.'.$cVlan;
                $Lin[4] = 'shut';
                $Lin[5] = 'exit';
                $Lin[6] = 'no '.$Port.':'.$sVlan.'.'.$cVlan;
                $Lin[7] = 'shut';
                $Lin[8] = 'exit';
                $Lin[9] = 'no interface "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                $Lin[10] = 'shut';
                $Lin[11] = 'exit'; 
                if(str_contains($Ies, 'ID')){   // Tipo config do Ies: pelo ID ou pela scVlan 
                    $Lin[12] = 'no ies '.$ID; 
                }else{ 
                    $Lin[12] = 'no ies '.$sVlan.$cVlan; 
                }
                //$Lin[12] = 'no ies '.$sVlan.$cVlan;         
                $Lin[13] = 'exit all';
                $Lin[14] = '!';
    
                $Lin[15] = 'configure router';
                $Lin[16] = 'static-route-entry '.$Lan.'/29';
                $Lin[17] = 'no next-hop '.$WanRota;           
                $Lin[18] = 'exit';
                $Lin[19] = 'static-route-entry '.$Loopback.'/32';
                $Lin[20] = 'no next-hop '.$WanRota;           
                $Lin[21] = 'exit';
                $Lin[22] = 'static-route-entry '.$LanIpv6.'/56';
                $Lin[23] = 'no next-hop '.$WanIpv6Rota;            
                $Lin[24] = 'exit all';  	       
               
                $Lin[_CtgLinScript] = 25;  // Total de linhas
    
            }


        }else if($Modelo == 'SR7750_QoS'){ 
            
            if(($Tipo == _CFG)||($Tipo == _MIGRA)){

                $QoS_IN = 10000 + (int)$Speed; 
                $QoS_OUT = 10000 + (int)$Speed; 

                if(str_contains($Ies, 'ID')){   // Tipo config do Ies: pelo ID ou pela scVlan                
                    $Lin[0] = 'configure service ies '.$ID.' name "'.$ID.'" customer 1 create';                    
                }else{ 
                    $Lin[0] = 'configure service ies '.$sVlan.$cVlan.' name "'.$sVlan.$cVlan.'" customer 1 create';                    
                }              
                $Lin[1] = 'interface "'.$Empresa.'_'.$ID.'_'.$OPER.'" create';
                $Lin[2] = '     address '.$WanLocal.$WanFx;
                if(str_contains($Port, 'pw')){
                    $Lin[3] = '     '.$Port.':'.$cVlan.' create';
                }else{
                    $Lin[3] = '     '.$Port.':'.$sVlan.'.'.$cVlan.' create';
                }
                $Lin[4] = '         ingress';
                $Lin[5] = '             qos '.$QoS_IN;
                $Lin[6] = '         exit';
                $Lin[7] = '         egress';
                $Lin[8] = '             qos '.$QoS_OUT;	       
                $Lin[9] = '         exit';
                $Lin[10] = '      exit';
                if(str_contains($WanIpv6, ':')){ // Se Circuito possui IP-Wan-IPv6
                    $Lin[11] = 'ipv6';
                    $Lin[12] = '          address '.$WanIpv6.'/127';
                    $Lin[13] = '          urpf-check';
                    $Lin[14] = '              mode loose';
                    $Lin[15] = ' exit';
                }else{                     
                    $Lin[11] = '';
                    $Lin[12] = '';
                    $Lin[13] = '';
                    $Lin[14] = '';
                    $Lin[15] = '';
                }   
                
                $Lin[16] = '         urpf-check';
                $Lin[17] = '              mode loose';
                $Lin[18] = '         exit';
                $Lin[19] = '  exit';
                $Lin[20] = '  no shutdown';
                $Lin[21] = 'exit';
                $Lin[22] = 'no shutdown';
                $Lin[23] = 'exit all';
                $Lin[24] = '';

                if(str_contains($Lan, '.')){ // Se Circuito possui IP-Lan-IPv6
                    $Lin[25] = 'configure router static-route-entry '.$Lan.'/29';
                    $Lin[26] = '       next-hop '.$WanRota;
                    $Lin[27] = '           description "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                    $Lin[28] = '           no shutdown';
                    $Lin[29] = 'exit all';
                }else{                     
                    $Lin[25] = '';
                    $Lin[26] = '';
                    $Lin[27] = '';
                    $Lin[28] = '';
                    $Lin[29] = '';
                }    

                if(str_contains($Loopback, '.')){ // Se Circuito possui IP-Lo
                    $Lin[30] = 'configure router static-route-entry '.$Loopback.'/32';
                    $Lin[31] = '       next-hop '.$WanRota;
                    $Lin[32] = '           description "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                    $Lin[33] = '           no shutdown';
                    $Lin[34] = 'exit all';
                }else{ 
                    $Lin[30] = '';
                    $Lin[31] = '';
                    $Lin[32] = '';
                    $Lin[33] = '';
                    $Lin[34] = '';
                }

                if(str_contains($LanIpv6, ':')){ // Se Circuito possui IP-Lan-IPv6
                    $Lin[35] = 'configure router static-route-entry '.$LanIpv6.'/56';
                    $Lin[36] = '       next-hop '.$WanIpv6Rota;
                    $Lin[37] = '           description "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                    $Lin[38] = '           no shutdown';
                    $Lin[39] = 'exit all';  
                }else{ 
                    $Lin[35] = '';
                    $Lin[36] = '';
                    $Lin[37] = '';
                    $Lin[38] = '';
                    $Lin[39] = '';
                }   

                $Lin[_CtgLinScript] = 40;  // Total de linhas

            }else if($Tipo == _DCFG){
                
                $Lin[0] = 'configure service'; 
                if(str_contains($Ies, 'ID')){   // Tipo config do Ies: pelo ID ou pela scVlan 
                    $Lin[1] = 'ies '.$ID.' name "'.$ID.'"'; 
                }else{ 
                    $Lin[1] = 'ies '.$sVlan.$cVlan.' name "'.$sVlan.$cVlan.'"'; 
                }
                //$Lin[1] = 'ies '.$sVlan.$cVlan.' name "'.$sVlan.$cVlan.'"';
                $Lin[2] = 'interface "'.$Empresa.'_'.$ID.'_'.$OPER.'"';           
                $Lin[3] = $Port.':'.$sVlan.'.'.$cVlan;
                $Lin[4] = 'shut';
                $Lin[5] = 'exit';
                $Lin[6] = 'no '.$Port.':'.$sVlan.'.'.$cVlan;
                $Lin[7] = 'shut';
                $Lin[8] = 'exit';
                $Lin[9] = 'no interface "'.$Empresa.'_'.$ID.'_'.$OPER.'"';
                $Lin[10] = 'shut';
                $Lin[11] = 'exit'; 
                if(str_contains($Ies, 'ID')){   // Tipo config do Ies: pelo ID ou pela scVlan 
                    $Lin[12] = 'no ies '.$ID; 
                }else{ 
                    $Lin[12] = 'no ies '.$sVlan.$cVlan; 
                }
                //$Lin[12] = '"no ies '.$sVlan.$cVlan;         
                $Lin[13] = 'exit all';
                $Lin[14] = '!';
    
                $Lin[15] = 'configure router';
                $Lin[16] = 'static-route-entry '.$Lan.'/29';
                $Lin[17] = 'no next-hop '.$WanRota;           
                $Lin[18] = 'exit';
                $Lin[19] = 'static-route-entry '.$Loopback.'/32';
                $Lin[20] = 'no next-hop '.$WanRota;           
                $Lin[21] = 'exit';
                $Lin[22] = 'static-route-entry '.$LanIpv6.'/56';
                $Lin[23] = 'no next-hop '.$WanIpv6Rota;            
                $Lin[24] = 'exit all';  	       
               
                $Lin[_CtgLinScript] = 25;  // Total de linhas
    
            }
           
        } // final SR7750_QoS
       
         // Script Preview        
         // Ajusta tamanho da LAN e Lo, para padrao
         while(strlen($Lan) != _TamIP){ $Lan = $Lan.' ';  }       
         while(strlen($Loopback) != _TamIP){ $Loopback = $Loopback.' ';  }       
               
         $Lin[200] = " WAN: ................... -> ".$WanLocal." ".$WanFx;            
         $Lin[201] = " LAN: ".$Lan." /29 -> ".$WanRota;            
         $Lin[202] = "  Lo: ".$Loopback." /32 -> ".$WanRota;            
         $Lin[203] = "WAN6: ......................... -> ".$WanIpv6." /127"; 
         if( $this->checkIP($WanIpv6) == 'F'){ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota." <<- Confirme Calc(F+1) rota IPv6";  } 
         else if( $this->checkIP($WanIpv6) == '9'){ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota." <<- Confirme Calc(9+1) rota IPv6"; }  
         else{ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota;  }
     

         // Verifica antes da config
         $PortY = str_replace('sap', '', $Port); // na consulta nao usamos: sap

         $FinalWanIpv6 = substr($WanIpv6Rota, -4);       
         $Lin[100] = "Checkar:";
         if(str_contains($PortY, 'pw')){
            $Lin[101] = 'show service sap-using | match '.$PortY; // Profile 
         }else{ 
            $Lin[101] = 'show service sap-using | match '.$PortY.':'.$sVlan; // Profile
         }  
         $Lin[102] = 'admin display-config | match '.$ID.' context all'; // Profile
         $Lin[103] = 'admin display-config | match '.$sVlan.' context all'; // Profile
         $Lin[104] = 'admin display-config | match '.$sVlan.'.'.$cVlan.' context all'; // Profile
         if(str_contains($PortY, 'pw')){   
            $Lin[105] = 'show service sap-using '.$PortY.':'.$cVlan; // Se porta esta livre
         }else{
            $Lin[105] = 'show service sap-using '.$PortY.':'.$sVlan; // Se porta esta livre
         }
         $Lin[106] = 'admin display-config | match context all '.$Speed.'M';  // Ver policy
         $Lin[107] = 'Conferir:'; 
         $Lin[108] = 'admin display-config | match '.$ID.' context all'; // Profile
         if(str_contains($PortY, 'pw')){         
            $Lin[109] = 'show service sap-using | match '.$PortY; // Profile
         }else{
            $Lin[109] = 'show service sap-using | match '.$PortY.':'.$sVlan; // Profile
         }
         $Lin[110] = 'Extras';
         $Lin[111] = 'admin display-config'; 
         $Lin[112] = 'show service id '.$ID.' base'; // Profile
         $Lin[113] = 'show port description | match '.$PortY; // Profile        
         $Lin[114] = 'admin display-config | match '.$sVlan.$cVlan.' context all'; // Profile    
         $Lin[115] = 'admin display-config | match context all '.$WanRota;
         $Lin[116] = 'admin display-config | match context all '.$FinalWanIpv6;
         $Lin[117] = 'show service sap-using | match '.$PortY.':'.$sVlan; // Profile
       
        // $Lin[111] = "Extras:";

         $Lin[_CtgCmdRouters] = 18;

        return ($Lin);	

    }


    function Datacom($Modelo, $ID, $EmpresaX, $Swa, $UpLnkCoriant, $TipoPtSwa, $ShelfSwa, $SlotSwa, $PortaSwa, $Porta2Swa, $NomeSwt, $IpSwt, $gVlan, $RA, $PortaRA, $sVlan, $sVlan2, $cVlan, $Speed, $Tipo, $Produto)
    {
       
        $Lin[] = "";
        
        $raX = substr($RA, -17); // Tira I-BR, pega so: sp-rpo-no-rai-01
        $raX = strtolower($raX); // passa para Minuscula

        //$TipoPtChannel = str_replace("pch-", "port-channel ", $TipoPtSwa); // ajusta tipo
        $TipoPtChannel = str_replace("lag-", "port-channel ", $TipoPtSwa); // ajusta lag->port-channel(p/ modelo 2104G)

        if($Modelo == '2104G2'){                

            if(($Tipo == _CFG)||($Tipo == _MIGRA)){

                $Lin[0] = "config";
                $Lin[1] = "!";
                if(str_contains($TipoPtChannel, 'ch')){ // Se == port-channel...
                    $Lin[2] = "interface ".$TipoPtChannel;
                    $Lin[3] = "   description IP_DLK#FIBRA#".$NomeSwt."#".$IpSwt."#1/1#1G#".$ID."#";
                    $Lin[4] = "   set-member interface ethernet ".$SlotSwa."/".$PortaSwa;
                    $Lin[5] = "   set-member interface ethernet ".$SlotSwa."/".$Porta2Swa;
                    $Lin[6] = "   no negotiation";
                    $Lin[7] = "   spanning-tree restricted-tcn";
                    $Lin[8] = "   no spanning-tree 1";
                    $Lin[9] = "   speed-duplex 1000full";
                    $Lin[10] = "   switchport native vlan 2";
                    $Lin[11] = "   switchport qinq external";
                    $Lin[12] = "   no switchport storm-control broadcast";
                    $Lin[13] = "   no switchport storm-control multicast";
                    $Lin[14] = "   no switchport storm-control unicast";
                    $Lin[15] = "   no switchport storm-control dlf";
                    $Lin[16] = "   switchport mtu 9198";
                    $Lin[17] = "   switchport vlan-translate ingress";
                    $Lin[18] = "   no queue sched-mode";
                    $Lin[19] = "   no oam";
                    $Lin[20] = "   no loopback-detection";
                    $Lin[21] = "   no shut";
                    $Lin[22] = "   exit";
                    $Lin[23] = "!";

                    $Lin[24] = "interface vlan 2";    
                    $Lin[25] = "   set-member untagged ".$TipoPtChannel;                
                    $Lin[26] = "   exit";
                    $Lin[27] = "!";
                }else{ for($v=2; $v<28; $v++){  $Lin[$v] = ""; } } // Se == Eth...imprime linhas vazias
                
                $Lin[28] = "interface vlan ".$gVlan;
                if(str_contains($TipoPtSwa, 'Eth')){
                    $Lin[29] = "   set-member tagged ethernet ".$SlotSwa."/".$PortaSwa;
                }else{
                    $Lin[29] = "   set-member tagged ".$TipoPtChannel;
                }
                $Lin[30] = "   exit";
                $Lin[31] = "!";
                $Lin[32] = "interface vlan ".$sVlan;
                if(str_contains($TipoPtSwa, 'Eth')){
                    $Lin[33] = "   set-member untagged ethernet ".$SlotSwa."/".$PortaSwa;
                }else{
                    $Lin[33] = "   set-member untagged ".$TipoPtChannel;
                }               
                $Lin[34] = "   exit";
                $Lin[35] = "!";  
                
                if(str_contains($TipoPtSwa, 'Eth')){
                    $Lin[36] = "interface ethernet ".$SlotSwa."/".$PortaSwa;
                    $Lin[37] = "   description IP_DLK#FIBRA#".$NomeSwt."#".$IpSwt."#1/1#1G#".$ID."#";
                    $Lin[38] = "   no negotiation";
                    $Lin[39] = "   speed-duplex 1000full";
                    $Lin[40] = "   spanning-tree restricted-tcn";
                    $Lin[41] = "   no spanning-tree 1";
                    $Lin[42] = "   switchport native vlan 2";
                    $Lin[43] = "   switchport qinq external";
                    $Lin[44] = "   no switchport storm-control broadcast";
                    $Lin[45] = "   no switchport storm-control multicast";
                    $Lin[46] = "   no switchport storm-control unicast";
                    $Lin[47] = "   no switchport storm-control dlf";
                    $Lin[48] = "   switchport mtu 9198";
                    $Lin[49] = "   switchport vlan-translate ingress";
                    $Lin[50] = "   no queue sched-mode";
                    $Lin[51] = "   no oam";
                    $Lin[52] = "   no shut";
                    $Lin[53] = "   exit";
                    $Lin[54] = "!";
                   
                }else{

                    $Lin[36] = "interface ethernet ".$SlotSwa."/".$PortaSwa;
                    $Lin[37] = "   description IP_DLK#FIBRA#".$NomeSwt."a#".$IpSwt."#1/1#1G#".$ID."#";
                    $Lin[38] = "   exit";
                    $Lin[39] = "!";
                    $Lin[40] = "interface ethernet ".$SlotSwa."/".$Porta2Swa;
                    $Lin[41] = "   description IP_DLK#FIBRA#".$NomeSwt."b#".$IpSwt."#1/1#1G#".$ID."#";
                    $Lin[42] = "   exit";
                    $Lin[43] = "!";   
                    for($v=44; $v<55; $v++){ $Lin[$v] = "";  } // Imprime linhas nao usadas como vazias
                
                }

                if(str_contains($TipoPtSwa, 'Eth')){
                    $Lin[55] = "vlan-translate ingress-table replace ethernet ".$SlotSwa."/".$PortaSwa." source-vlan ".$gVlan." new-vlan ".$gVlan;
                    $Lin[56] = "vlan-translate ingress-table add ethernet ".$SlotSwa."/".$PortaSwa." source-vlan ".$cVlan." new-vlan ".$sVlan;
                }else{
                    $Lin[55] = "vlan-translate ingress-table replace ".$TipoPtChannel." source-vlan ".$gVlan." new-vlan ".$gVlan;
                    $Lin[56] = "vlan-translate ingress-table add ".$TipoPtChannel." source-vlan ".$cVlan." new-vlan ".$sVlan;             
                }
                $Lin[57] = "exit";
                $Lin[58] = "!";
                $Lin[59] = "copy run st 1";
                $Lin[60] = "copy run st 2";
                
                $Lin[_CtgLinScript] = 61;
                            
                // Carimbo gerado para colar no taBackbone -> Star  
                if($Tipo == _MIGRA){             
                    $Lin[300] = "\n\n***  MIGRACAO VIVO2, VIVO1, MANTIDO OS IPs ***"; 
                    $Lin[301] = "\n";
                    $Lin[302] = "\n";
                    $Lin[303] = "\n";
                }else{ 
                    $Lin[300] = "\n\n***  VALIDACAO DE IPs ***";
                    $Lin[301] = "\nID CERTIFICADO";
                    $Lin[302] = "\nAtividade concluída com sucesso.\n";
                    $Lin[303] = "ID Execução:  \n\n"; 
                }                         
                $Lin[304] = "***  BBIP ***\n\n\n";   
                $Lin[305] = "..\n";       
                $Lin[306] = "***  ".$Swa." ***\n"; 
                $Lin[307] = "\n"; 
                $Lin[308] = "interface ethernet 1/".$PortaSwa."\n";
                $Lin[309] = "description IP_DLK#FIBRA#".$NomeSwt."#".$IpSwt."#1/1#1G#".$ID."#\n";            
                $Lin[310] = "no shutdown\n";
                $Lin[311] = "!\n";
                $Lin[312] = "interface vlan ".$gVlan."\n";
                $Lin[313] = "set-member tagged ethernet ".$SlotSwa."/".$PortaSwa."\n";          
                $Lin[314] = "!\n";
                $Lin[315] = "interface vlan ".$sVlan."\n";
                $Lin[316] = "name IPD#".$raX."#".$PortaRA."\n";
                $Lin[317] = "set-member untagged ethernet ".$SlotSwa."/".$PortaSwa."\n";           
                $Lin[318] = "!\n";         
                $Lin[319] = "vlan-translate ingress-table replace ethernet ".$SlotSwa."/".$PortaSwa." source-vlan ".$gVlan." new-vlan ".$gVlan."\n";
                $Lin[320] = "vlan-translate ingress-table add ethernet ".$SlotSwa."/".$PortaSwa." source-vlan ".$cVlan." new-vlan ".$sVlan."\n";
                $Lin[321] = "!\n";
                $Lin[322] = "E.Flow:\n";

                $Lin[_CtgCARIMBO] = 23;

            }else if($Tipo == _DCFG){  
                
                // Desconfiguracao
                $Lin[0] = "config";
                $Lin[1] = "!";
                $Lin[2] = "interface vlan ".$gVlan;
                $Lin[3] = "no set-member ethernet ".$SlotSwa."/".$PortaSwa;
                $Lin[4] = "exit";
                $Lin[5] = "!";
                $Lin[6] = "interface vlan ".$sVlan;
                $Lin[7] = "no set-member ethernet ".$SlotSwa."/".$PortaSwa;
                $Lin[8] = "exit";
                $Lin[9] = "!";
                $Lin[10] = "interface ethernet ".$SlotSwa."/".$PortaSwa;
                $Lin[11] = "no description";
                $Lin[12] = "shutdown";           
                $Lin[13] = "exit";
                $Lin[14] = "!";
                $Lin[15] = "no vlan-translate ingress-table ethernet ".$SlotSwa."/".$PortaSwa." source-vlan ".$gVlan;
                $Lin[16] = "no vlan-translate ingress-table ethernet ".$SlotSwa."/".$PortaSwa." source-vlan ".$cVlan;
                $Lin[17] = "exit";
                $Lin[18] = "!";
                $Lin[19] = "copy run st 1";
                $Lin[20] = "copy run st 2";
            
                $Lin[_CtgLinScript] = 21;    // Conta Linhas desconfiguracao
                

                // Carimbo gerado para colar no taBackbone -> Star               
                $Lin[300] = "\n\n***  DESCONFIGURACAO ***\n\n";  
                $Lin[301] = "***  BBIP ***\n\n\n";   
                $Lin[302] = "..\n";       
                $Lin[303] = "***  ".$Swa." ***\n"; 
                $Lin[304] = "\n"; 
                $Lin[305] = "interface ethernet 1/".$PortaSwa."\n";
                $Lin[306] = "no description IP_DLK#FIBRA#".$NomeSwt."#".$IpSwt."#1/1#1G#".$ID."#\n";            
                $Lin[307] = "!\n";
                $Lin[308] = "interface vlan ".$gVlan."\n";
                $Lin[309] = "no set-member ethernet ".$SlotSwa."/".$PortaSwa."\n";          
                $Lin[310] = "!\n";
                $Lin[311] = "interface vlan ".$sVlan."\n";
                $Lin[312] = "name IPD#".$raX."#".$PortaRA."\n";
                $Lin[313] = "no set-member ethernet ".$SlotSwa."/".$PortaSwa."\n";           
                $Lin[314] = "!\n";         
                $Lin[315] = "no vlan-translate ingress-table ethernet ".$SlotSwa."/".$PortaSwa." source-vlan ".$gVlan."\n";
                $Lin[316] = "no vlan-translate ingress-table ethernet ".$SlotSwa."/".$PortaSwa." source-vlan ".$cVlan."\n";
                $Lin[317] = "!\n";
                $Lin[318] = "E.Flow - Desconexao SWT: \n";

                $Lin[_CtgCARIMBO] = 19;

            } // if Tipo: _CFG, Dcfg
            //-----------------------------------

            // Checagens antes da config
            $Lin[100] = 'Datacom:'; 
            $Lin[101] = 'show version';                 
            $Lin[102] = 'show int status eth '.$SlotSwa.'/'.$PortaSwa;
            $Lin[103] = 'sh run | inc '.$ID;    
            $Lin[104] = 'sh vlan';         
            $Lin[105] = 'sh run | inc '.$cVlan;             
            $Lin[106] = 'sh vlan id '.$gVlan;             
            $Lin[107] = 'sh vlan id '.$sVlan;             
            $Lin[108] = 'sh mac-address-table ';             
            $Lin[109] = 'sh mac-address-table interface ethernet '.$SlotSwa.'/'.$PortaSwa;             
            $Lin[110] = 'no vlan-translate ingress-table ethernet '.$SlotSwa.'/'.$PortaSwa.' source-vlan '.$cVlan; // Profile             
        
            $Lin[_CtgCmdRouters] = 11;

        }else if($Modelo == 'V380R220'){

            if(($Tipo == _CFG)||($Tipo == _MIGRA)){

                $Lin[0] = "conf";
                $Lin[1] = "interface gigaethernet ".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;
                $Lin[2] = "alias IP_DLK#FIBRA#".$NomeSwt."#".$IpSwt."#1G#1/1/1#".$ID."#";
                $Lin[3] = "negotiation auto disable";
                $Lin[4] = "speed 1000";
                $Lin[5] = "no shutdown";
                $Lin[6] = "port link-type hybrid";
                $Lin[7] = "no port hybrid vlan 1";
                $Lin[8] = "port hybrid vlan ".$gVlan.",".$cVlan." tagged";
                $Lin[9] = "port hybrid vlan 2,".$sVlan." untagged";
                $Lin[10] = "port hybrid pvid 2";                
                $Lin[11] = "vlan-stacking enable";
                $Lin[12] = "vlan-stacking vlan ".$cVlan." stack-vlan ".$sVlan;
                $Lin[13] = "vlan-mapping enable";
                $Lin[14] = "vlan-mapping vlan ".$gVlan." map-vlan ".$gVlan;
                $Lin[15] = "lldp admin-status rx-tx";
                $Lin[16] = "!";                
                $Lin[17] = "!";
                $Lin[18] = "exit";
                $Lin[19] = "!";
                $Lin[20] = "exit";
                $Lin[21] = "!";
                $Lin[22] = "write file both";
                $Lin[23] = "!";
                $Lin[24] = "y";
                $Lin[25] = "!";
                
                $Lin[_CtgLinScript] = 26;

                if($Tipo == _MIGRA){             
                    $Lin[300] = "\n\n***  MIGRACAO VIVO2, VIVO1, MANTIDO OS IPs ***"; 
                    $Lin[301] = "\n";
                    $Lin[302] = "\n";
                    $Lin[303] = "\n";
                }else{        
                    // Carimbo gerado para colar no taBackbone -> Star               
                    $Lin[300] = "\n\n***  VALIDACAO DE IPs ***";  
                    $Lin[301] = "\nID CERTIFICADO";
                    $Lin[302] = "\nAtividade concluída com sucesso.\n";
                    $Lin[303] = "ID Execução:  \n\n";  
                }       
                $Lin[304] = "***  BBIP ***\n\n\n";   
                $Lin[305] = "..\n";       
                $Lin[306] = "***  ".$Swa." ***\n"; 
                $Lin[307] = "\n"; 
                $Lin[308] = "interface gigaethernet ".$ShelfSwa."/".$SlotSwa."/".$PortaSwa."\n";
                $Lin[309] = "alias IP_DLK#FIB#".$NomeSwt."#".$IpSwt."#1G#1/1/1#".$ID."#\n";
                $Lin[310] = "negotiation auto disable\n";
                $Lin[311] = "no shutdown\n";
                $Lin[312] = "no port hybrid vlan 1\n";
                $Lin[313] = "port hybrid vlan ".$gVlan.",".$cVlan." tagged\n";
                $Lin[314] = "port hybrid vlan 2,".$sVlan." untagged\n";
                $Lin[315] = "port hybrid pvid 2\n";
                $Lin[316] = "vlan-stacking enable\n";
                $Lin[317] = "vlan-stacking vlan ".$cVlan." stack-vlan ".$sVlan."\n";
                $Lin[318] = "vlan-mapping enable\n";
                $Lin[319] = "vlan-mapping vlan ".$gVlan." map-vlan ".$gVlan."\n";
                $Lin[320] = "lldp admin-status rx-tx\n";            
                $Lin[321] = "!\n";
                $Lin[322] = "E.Flow:\n";

                $Lin[_CtgCARIMBO] = 23;


                  // Checagens antes da config
                  $Lin[100] = 'Datacom:'; 
                  $Lin[101] = 'show version';  
                  $Lin[102] = 'show interface';
                  $Lin[103] = 'show interface gigaethernet '.$ShelfSwa.'/'.$SlotSwa.'/'.$PortaSwa;
                  $Lin[104] = 'show interface vlan config';  
                  $Lin[105] = 'show vlan '.$gVlan.' verbose';  
                  $Lin[106] = 'show vlan '.$sVlan.' verbose';
                  $Lin[107] = 'sh mac-address';  
                  $Lin[108] = 'sh mac-address gigaethernet 1/'.$SlotSwa.'/'.$PortaSwa;             
                                                 
                  $Lin[_CtgCmdRouters] = 9;

            }else if($Tipo == _DCFG){  
                // Script de desconfiguracao
                $Lin[0] = "config ter";
                $Lin[1] = "!";          
                $Lin[2] = "interface gigaethernet ".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;          
                $Lin[3] = "no alias";
                $Lin[4] = "shutdown";           
                $Lin[5] = "no port hybrid vlan 2,".$sVlan;
                $Lin[6] = "no port hybrid vlan ".$gVlan.", ".$cVlan;
                $Lin[7] = "no vlan-stacking vlan ".$gVlan;
                $Lin[8] = "!";
                $Lin[9] = "exit";
                $Lin[10] = "write file both";
                    
                $Lin[_CtgLinScript] = 11;    // Conta Linhas desconfiguracao
                
                // Carimbo gerado para colar no taBackbone -> Star               
                $Lin[300] = "\n\n***  DESCONFIGURACAO ***\n\n"; 
                $Lin[301] = "***  BBIP ***\n\n\n";   
                $Lin[302] = "..\n";       
                $Lin[303] = "***  ".$Swa." ***\n"; 
                $Lin[304] = "\n"; 
                $Lin[305] = "interface gigaethernet ".$ShelfSwa."/".$SlotSwa."/".$PortaSwa."\n";
                $Lin[306] = "no alias IP_DLK#FIB#".$NomeSwt."#".$IpSwt."#1G#1/1/1#".$ID."#\n";
                $Lin[307] = "shutdown\n";
                $Lin[308] = "no port hybrid vlan 2,".$sVlan."\n";               
                $Lin[309] = "no port hybrid vlan ".$gVlan.", ".$cVlan."\n";
                $Lin[310] = "no vlan-stacking vlan ".$gVlan."\n";
                $Lin[311] = "!\n";
                $Lin[312] = "E.Flow - Desconexao SWT: \n";

                $Lin[_CtgCARIMBO] = 13;
                //-----------------------------------
            } // if($Tipo = ...
            
        //---- SCRIPT COM GERENCIA CORIANT -------------------------------
        }else if($Modelo == 'Coriant'){

                if(($Tipo == _CFG)||($Tipo == _MIGRA)){
                    
                    $Lin[0] = "conf ter";
                    $Lin[1] = "!";
                    $Lin[2] = "pwe3 circuit IPD_".$sVlan."_".$cVlan." ".$sVlan."".$cVlan." mpls manual";
                    $Lin[3] = "!";
                    $Lin[4] = "interface ge".$UpLnkCoriant.".".$sVlan.".".$cVlan;
                    $Lin[5] = "    description ".$Produto."_".$EmpresaX."_".$Speed."M_".$ID;
                    $Lin[6] = "    ip mtu 9200";
                    $Lin[7] = "    pwe3 circuit ".$Produto."_".$sVlan."_".$cVlan." encapsulation ethernet-vlan untagged";
                    $Lin[8] = "    no shutdown";
                    $Lin[9] = "    qos vlan egress vlan-pri 1";
                    $Lin[10] = "    vlan statistics non-qos in-qos";
                    $Lin[11] = "!";

                    //----------------------------------------------------------------------------
                    $Lin[12] = "interface ge".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;
                    $Lin[13] = " description IP_DLK#FIBRA#".$NomeSwt."#".$IpSwt."#".$ShelfSwa."/".$SlotSwa."/".$PortaSwa."#1G#".$ID."#";
                    $Lin[14] = "ip mtu 9200";
                    $Lin[15] = "no shutdown";
                    $Lin[16] = "qos mapping enable";
                    $Lin[17] = "qos mapping use ingress traffic layer2-frame";
                    $Lin[18] = "qos mapping use egress traffic layer2-frame";
                    $Lin[19] = "mode speed 1000 duplex full";
                    $Lin[20] = "eth lldp admin-state rx-tx";
                    $Lin[21] = "!";
                    $Lin[22] = "interface ge".$ShelfSwa."/".$SlotSwa."/".$PortaSwa.".".$cVlan;
                    $Lin[23] = "    description ".$Produto."_".$EmpresaX."_".$Speed."M_".$ID;
                    $Lin[24] = "    ip mtu 9200";
                    $Lin[25] = "    pwe3 circuit ".$Produto."_".$sVlan."_".$cVlan;
                    $Lin[26] = "    no shutdown";
                    $Lin[27] = "    qos vlan ingress qos af1";
                    $Lin[28] = "    qos vlan egress vlan-pri 1";
                    $Lin[29] = "    vlan statistics non-qos in-qos";
                    $Lin[30] = "    vlan statistics non-qos in-qos vlan-single-tagged";
                    $Lin[31] = "!";

                    $Lin[32] = "interface ge".$ShelfSwa."/".$SlotSwa."/".$PortaSwa.".".$gVlan;    // interface ge13/1/7.3649
                    $Lin[33] = "bridging bridging-instance ".$gVlan." mode vlan-access";
                    $Lin[34] = "no shutdown";
                    $Lin[35] = "qos vlan ingress qos af1";
                    $Lin[36] = "qos vlan egress vlan-pri 1";
                    $Lin[37] = "vlan statistics non-qos in-qos";
                    $Lin[38] = "vlan statistics non-qos in-qos vlan-single-tagged";
                    $Lin[39] = "!";

                    $Lin[40] = "mpls static-ftn bridge ".$Produto."_".$sVlan."_".$cVlan." ge".$UpLnkCoriant.".".$sVlan.".".$cVlan." ge".$ShelfSwa."/".$SlotSwa."/".$PortaSwa.".".$cVlan;
                    $Lin[41] = "mpls static-ftn bridge ".$Produto."_".$sVlan."_".$cVlan." ge".$ShelfSwa."/".$SlotSwa."/".$PortaSwa.".".$cVlan." ge".$UpLnkCoriant.".".$sVlan.".".$cVlan;
                    $Lin[42] = "!";               
                    $Lin[43] = "exit";
                    $Lin[44] = "!";
                    $Lin[45] = "show flash";
                    $Lin[46] = "!";
                    $Lin[47] = "copy running-config flash: X";
                 
                    $Lin[_CtgLinScript] = 48;
    
                    if($Tipo == _MIGRA){             
                        $Lin[300] = "\n\n***  MIGRACAO VIVO2, VIVO1, MANTIDO OS IPs ***"; 
                        $Lin[301] = "\n";
                        $Lin[302] = "\n";
                        $Lin[303] = "\n";
                    }else{        
                        // Carimbo gerado para colar no taBackbone -> Star               
                        $Lin[300] = "\n\n***  VALIDACAO DE IPs ***";  
                        $Lin[301] = "\nID CERTIFICADO";
                        $Lin[302] = "\nAtividade concluída com sucesso.\n";
                        $Lin[303] = "ID Execução:  \n\n";  
                    }       
                    $Lin[304] = "***  BBIP ***\n\n\n";   
                    $Lin[305] = "..\n";       
                    $Lin[306] = "***  ".$Swa." ***\n"; 
                    $Lin[307] = "\n"; 
                    $Lin[308] = "pwe3 circuit IPD_".$sVlan."_".$cVlan." ".$sVlan."".$cVlan." mpls manual\n";
                    $Lin[309] = "!\n";
                    $Lin[310] = "interface ge".$UpLnkCoriant.".".$sVlan.".".$cVlan."\n";
                    $Lin[311] = "    description ".$Produto."_".$EmpresaX."_".$Speed."M_".$ID."\n";				
                    $Lin[312] = "    pwe3 circuit ".$Produto."_".$sVlan."_".$cVlan." encapsulation ethernet-vlan untagged\n";
                    $Lin[313] = "    no shutdown\n";			
                    $Lin[314] = "!\n";
                    $Lin[315] = "interface ge".$ShelfSwa."/".$SlotSwa."/".$PortaSwa.".".$cVlan."\n";
                    $Lin[316] = "    description ".$Produto."_".$EmpresaX."_".$Speed."M_".$ID."\n";				
                    $Lin[317] = "    pwe3 circuit ".$Produto."_".$sVlan."_".$cVlan."\n";	
                    $Lin[318] = "    no shutdown\n";		
                    $Lin[319] = "!\n";
                    $Lin[320] = "mpls static-ftn bridge ".$Produto."_".$sVlan."_".$cVlan." ge".$UpLnkCoriant.".".$sVlan.".".$cVlan." ge".$ShelfSwa."/".$SlotSwa."/".$PortaSwa.".".$cVlan."\n";
                    $Lin[321] = "mpls static-ftn bridge ".$Produto."_".$sVlan."_".$cVlan." ge".$ShelfSwa."/".$SlotSwa."/".$PortaSwa.".".$cVlan." ge".$UpLnkCoriant.".".$sVlan.".".$cVlan."\n";
                    $Lin[322] = "!\n"; 
                    $Lin[323] = "E.Flow:\n";
    
                    $Lin[_CtgCARIMBO] = 24;
    
           
    
                }else if($Tipo == _DCFG){  
                    // Script de desconfiguracao
                    $Lin[0] = "conf ter";
                    $Lin[1] = "!";
                    $Lin[2] = "no pwe3 circuit ".$Produto."_".$sVlan."_".$cVlan." ".$sVlan."".$cVlan." mpls manual";
                    $Lin[3] = "!";
                    $Lin[4] = "interface ge".$UpLnkCoriant.".".$sVlan.".".$cVlan;
                    $Lin[5] = "    no description ".$Produto."_".$EmpresaX."_".$Speed."Mbps_ID-".$ID;				
                    $Lin[6] = "    no pwe3 circuit ".$Produto."_".$sVlan."_".$cVlan." encapsulation ethernet-vlan untagged";
                    $Lin[7] = "    shutdown";				
                    $Lin[8] = "!";
                    $Lin[9] = "interface ge".$ShelfSwa."/".$SlotSwa."/".$PortaSwa.".".$cVlan;
                    $Lin[10] = "    no description ".$Produto."_".$EmpresaX."_".$Speed."Mbps_ID-".$ID;				
                    $Lin[11] = "    no pwe3 circuit ".$Produto."_".$sVlan."_".$cVlan;
                    $Lin[12] = "    shutdown";				
                    $Lin[13] = "!";
                    $Lin[14] = "no interface ge".$UpLnkCoriant.".".$sVlan.".".$cVlan;
                    $Lin[15] = "no interface ge".$ShelfSwa."/".$SlotSwa."/".$PortaSwa.".".$cVlan;
                    $Lin[16] = "!";
                    $Lin[17] = "no mpls static-ftn bridge ".$Produto."_".$sVlan."_".$cVlan." ge".$UpLnkCoriant.".".$sVlan.".".$cVlan." ge".$ShelfSwa."/".$SlotSwa."/".$PortaSwa.".".$cVlan;
                    $Lin[18] = "no mpls static-ftn bridge ".$Produto."_".$sVlan."_".$cVlan." ge".$ShelfSwa."/".$SlotSwa."/".$PortaSwa.".".$cVlan." ge".$UpLnkCoriant.".".$sVlan.".".$cVlan;
                    $Lin[19] = "!";
                    $Lin[20] = "exit";
                    $Lin[21] = "!";
                    $Lin[22] = "show flash";
                    $Lin[23] = "!";
                    $Lin[24] = "copy running-config flash: X";
                 
                    $Lin[_CtgLinScript] = 25;
                    
    
                    // Carimbo gerado para colar no taBackbone -> Star               
                    $Lin[300] = "\n\n***  DESCONFIGURACAO ***\n\n"; 
                    $Lin[301] = "***  BBIP ***\n\n\n";   
                    $Lin[302] = "..\n";       
                    $Lin[303] = "***  ".$Swa." ***\n"; 
                    $Lin[304] = "\n";                 
                    $Lin[305] = "no pwe3 circuit IPD_".$sVlan."_".$cVlan." ".$sVlan."".$cVlan." mpls manual\n";
                    $Lin[306] = "!\n";
                    $Lin[307] = "interface ge".$UpLnkCoriant.".".$sVlan.".".$cVlan."\n";
                    $Lin[308] = "    no description\n";				
                    $Lin[309] = "    no pwe3 circuit ".$Produto."_".$sVlan."_".$cVlan." encapsulation ethernet-vlan untagged\n";
                    $Lin[310] = "    shutdown\n";			
                    $Lin[311] = "!\n";
                    $Lin[312] = "interface ge".$ShelfSwa."/".$SlotSwa."/".$PortaSwa.".".$cVlan."\n";
                    $Lin[313] = "    no description\n";				
                    $Lin[314] = "    no pwe3 circuit ".$Produto."_".$sVlan."_".$cVlan."\n";	
                    $Lin[315] = "    shutdown\n";		
                    $Lin[316] = "!\n";
                    $Lin[317] = "no mpls static-ftn bridge ".$Produto."_".$sVlan."_".$cVlan." ge".$UpLnkCoriant.".".$sVlan.".".$cVlan." ge".$ShelfSwa."/".$SlotSwa."/".$PortaSwa.".".$cVlan."\n";
                    $Lin[318] = "no mpls static-ftn bridge ".$Produto."_".$sVlan."_".$cVlan." ge".$ShelfSwa."/".$SlotSwa."/".$PortaSwa.".".$cVlan." ge".$UpLnkCoriant.".".$sVlan.".".$cVlan."\n";
                    $Lin[319] = "!\n"; 
                    $Lin[320] = "E.Flow - Desconexao SWT: \n";
    
                    $Lin[_CtgCARIMBO] = 21;
                    
                    //-----------------------------------
            } // if($Tipo = ...  
           
            
            // Verifica antes da config
            $Lin[100] = 'Datacom:';             
            $Lin[101] = 'show hw-inventory';     
            $Lin[102] = 'show sw-version'; 
            $Lin[103] = 'show run | inc '.$ID; 
            $Lin[104] = 'show run | inc '.$cVlan; 
            $Lin[105] = 'show interface ge'.$ShelfSwa.'/'.$SlotSwa.'/'.$PortaSwa;
            $Lin[106] = 'show system-mac-addresses';             
          
            $Lin[_CtgCmdRouters] = 7;
  

        }else if($Modelo == 'DM4050'){
            
            if($PortaSwa > 4){ 
                $EthDcpt = "  interface gigabit-ethernet ".$ShelfSwa."/"; 
                $Eth = "  interface gigabit-ethernet-".$ShelfSwa."/"; 
            }else{ 
                $EthDcpt = "  interface ten-gigabit-ethernet ".$ShelfSwa."/"; 
                $Eth = "  interface ten-gigabit-ethernet-".$ShelfSwa."/"; 
            }

           

                if(($Tipo == _CFG)||($Tipo == _MIGRA)){

                    if(str_contains($TipoPtSwa, 'lag')){  // Liberar vinculos das portas que serão usadas na Lag
                      
                        $Lin[0] = "================= Liberar vínculos das portas ====================";
                        $Lin[1] = "config e";
                        $Lin[2] = "dot1q";
                        $Lin[3] = "   vlan ".$sVlan;
                        $Lin[4] = "      no interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;
                        $Lin[5] = "      no interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$Porta2Swa; // Porta2 de ajuste segunda porta lag p/ liberar vinculos da porta
                        $Lin[6] = "      exit";
                        $Lin[7] = "   vlan ".$sVlan2;   // sVlan2 de ajuste(IPD e/ou VPN) p/ liberar vinculos da porta
                        $Lin[8] = "      no interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;
                        $Lin[9] = "      no interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$Porta2Swa; 
                        $Lin[10] = "      exit";
                        $Lin[11] = "   vlan ".$gVlan;
                        $Lin[12] = "      no interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;
                        $Lin[13] = "      no interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$Porta2Swa;                      
                        $Lin[14] = "      exit";
                        $Lin[15] = "   vlan 2";
                        $Lin[16] = "      no interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;
                        $Lin[17] = "      no interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$Porta2Swa;                      
                        $Lin[18] = "      exit";
                        $Lin[19] = "exit";
                        $Lin[20] = "switchport";
                        $Lin[21] = "      no interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;
                        $Lin[22] = "      no interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$Porta2Swa;     
                        $Lin[23] = "exit";
                        $Lin[24] = "commit";
                        $Lin[25] = "exit";	
                        $Lin[26] = "!";	

                        $Lin[27] = "========== Criar a LAG(Link AGregation ====================================";
                        $LagX = str_replace("-", " ", $TipoPtSwa); // Altera de lag-1 p/ lag 1
                        $Lin[28] = "config e";
                        $Lin[29] = "link-aggregation";
                        $Lin[30] = "   interface ".$LagX;
                        $Lin[31] = "     description IP_DLK@FIBRA@".$NomeSwt."@".$IpSwt."@1/1@1G@".$ID."@";
                        $Lin[32] = "      interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;
                        $Lin[33] = "      !";
                        $Lin[34] = "      interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$Porta2Swa;
                        $Lin[35] = "      !";                        
                        $Lin[36] = "commit";
                        $Lin[37] = "exit";
                        $Lin[38] = "!";
                        $Lin[39] = "!";
                        $Lin[40] = "* Atenção! Router não aceita tenGiEth com GiEth na mesma Lag.";
                        $Lin[41] = "============== Inicia a config ====================================";

                    }else{ // caso serja uma Eth, só carrega linhas vazias no script
                        for($i=0; $i<41; $i++){ $Lin[$i] = ""; }
                        $Lin[41] = "";
                    }

                    
                    $Lin[42] = "config e";
                    $Lin[43] = "!";
                    $Lin[44] = "dot1q";
                    $Lin[45] = " vlan 2";
                    if(str_contains($TipoPtSwa, 'Eth')){
                        $Lin[46] = "  interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;
                    }else{
                        $Lin[46] = "  interface ".$TipoPtSwa; // Lag
                    }
                    $Lin[47] = "  untagged";
                    $Lin[48] = "exit";
                    $Lin[49] = "exit";
                    $Lin[50] = "exit";
                    $Lin[51] = "!";
                    $Lin[52] = "dot1q";
                    $Lin[53] = " vlan ".$sVlan;
                    if(str_contains($TipoPtSwa, 'Eth')){
                        $Lin[54] = "  interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;
                    }else{
                        $Lin[54] = "  interface ".$TipoPtSwa; // Lag
                    }
                    $Lin[55] = "  untagged";
                    $Lin[56] = "exit";
                    $Lin[57] = "exit";
                    $Lin[58] = "exit";
                    $Lin[59] = "!";
                    $Lin[60] = "dot1q";
                    $Lin[61] = " vlan ".$gVlan;
                    if(str_contains($TipoPtSwa, 'Eth')){
                        $Lin[62] = "  interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;
                    }else{
                        $Lin[62] = "  interface ".$TipoPtSwa; // Lag
                    }
                    $Lin[63] = "exit";
                    $Lin[64] = "exit";
                    $Lin[65] = "exit";
                    $Lin[66] = "!";
                    $Lin[67] = "switchport";
                    if(str_contains($TipoPtSwa, 'Eth')){
                        $Lin[68] = "  interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;
                    }else{
                        $Lin[68] = "  interface ".$TipoPtSwa; // Lag
                    }                    
                    $Lin[69] = "  native-vlan";
                    $Lin[70] = "   vlan-id 2";
                    $Lin[71] = "  !";
                    $Lin[72] = "exit";
                    $Lin[73] = "  !";
                    $Lin[74] = "  qinq";
                    $Lin[75] = " !";
                    $Lin[76] = "exit";
                    $Lin[77] = "exit";
                    $Lin[78] = "!";
                    $Lin[79] = "vlan-mapping";
                    if(str_contains($TipoPtSwa, 'Eth')){
                        $Lin[80] = "  interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;
                    }else{
                        $Lin[80] = "  interface ".$TipoPtSwa; // Lag
                    }                       
                    $Lin[81] = "  ingress";
                    $Lin[82] = "     rule 1-1-".$PortaSwa."-".$gVlan;
                    $Lin[83] = "        match vlan vlan-id ".$gVlan;
                    $Lin[84] = "        action replace vlan vlan-id ".$gVlan." pcp 0";
                    $Lin[85] = "        !";
                    $Lin[86] = "     rule ".$sVlan.$cVlan;
                    $Lin[87] = "        match vlan vlan-id ".$cVlan;
                    $Lin[88] = "        action add vlan vlan-id ".$sVlan." pcp 0";
                    $Lin[89] = "        !";
                    $Lin[90] = "        exit";
                    $Lin[91] = "     exit";
                    $Lin[92] = "  exit";
                    $Lin[93] = "exit";
                    $Lin[94] = "!";            
                    $Lin[95] = "!";

                    if(str_contains($TipoPtSwa, 'Eth')){
                        $Lin[96] = "interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;
                        $Lin[97] = "   no shut";
                        $Lin[98] = "   description IP_DLK@FIBRA@".$NomeSwt."@".$IpSwt."@1/1@1G@".$ID."@";
                        $Lin[99] = "   no negotiation";
                        $Lin[100] = "  duplex full";
                        $Lin[101] = "  speed 1G";
                        $Lin[102] = "  exit";
                        $Lin[103] = "!";
                        
                        $Lin[104] = "";                       
                        $Lin[105] = "";
                        $Lin[106] = "";
                        $Lin[107] = "";
                        $Lin[108] = "";
                        $Lin[109] = "";
                        $Lin[110] = "";
                        $Lin[111] = "";

                        $Lin[112] = "lldp";
                        $Lin[113] = "   interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;
                        $Lin[114] = "      admin-status tx-and-rx	";
                        $Lin[115] = "      no notification";
                        $Lin[116] = "      !";
                        $Lin[117] = "      exit";
                        $Lin[118] = "   !";
                        $Lin[119] = "";
                        $Lin[120] = "";
                        $Lin[121] = "";
                        $Lin[122] = "";
                        $Lin[123] = "";
                        $Lin[124] = "";
                        $Lin[125] = "exit";
                        $Lin[126] = "!";
                        

                    }else{ // = Lag

                         $Lin[96] = "interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;
                         $Lin[97] = "   no shut";
                         $Lin[98] = "   description IP_DLK@FIBRA@".$NomeSwt."a@".$IpSwt."@1/1@1G@".$ID."@";
                         $Lin[99] = "   no negotiation";
                        $Lin[100] = "   duplex full";
                        $Lin[101] = "   speed 1G";
                        $Lin[102] = "   exit";
                        $Lin[103] = "!";
                        
                        $Lin[104] = "interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$Porta2Swa;
                        $Lin[105] = "   no shut";
                        $Lin[106] = "   description IP_DLK@FIBRA@".$NomeSwt."b@".$IpSwt."@1/1@1G@".$ID."@";
                        $Lin[107] = "   no negotiation";
                        $Lin[108] = "   duplex full";
                        $Lin[109] = "   speed 1G";
                        $Lin[110] = "   exit";
                        $Lin[111] = "!";

                        $Lin[112] = "lldp";
                        $Lin[113] = "   interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;
                        $Lin[114] = "      admin-status tx-and-rx	";
                        $Lin[115] = "      no notification";
                        $Lin[116] = "      !";
                        $Lin[117] = "      exit";
                        $Lin[118] = "   !";
                        $Lin[119] = "   interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$Porta2Swa;
                        $Lin[120] = "      admin-status tx-and-rx	";
                        $Lin[121] = "      no notification";
                        $Lin[122] = "      !";
                        $Lin[123] = "      exit";
                        $Lin[124] = "   !";
                        $Lin[125] = "exit";
                        $Lin[126] = "!";
                    }

                    
                   
                    $Lin[127] = "commit";
                    $Lin[128] = "!";
                    $Lin[129] = "exit";
                    $Lin[130] = "!";
                   
                    $Lin[_CtgLinScript] = 131;

                    // carimbo Script-SWA p/ colar no Star  
                    $Lin[300] = "\n\n***  VALIDACAO DE IPs ***";  
                    $Lin[301] = "\nID CERTIFICADO";
                    $Lin[302] = "\nAtividade concluída com sucesso.\n";
                    $Lin[303] = "ID Execução:  \n\n"; 
                    if(str_contains($Produto, 'VPN')){        
                        $Lin[304] = "***  BBVPN ***\n\n\n"; 
                    }else{  
                        $Lin[304] = "***  BBIP ***\n\n\n"; 
                    }  
                    $Lin[305] = "..\n";   
                    $Lin[306] = "***  ".$Swa." ***\n";  
                    $Lin[307] = "\n";  
                    if(str_contains($TipoPtSwa, 'Eth')){
                        $Lin[308] = "interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa."\n";
                        $Lin[309] = "   description IP_DLK@FIBRA@".$NomeSwt."@".$IpSwt."@1/1@1G@".$ID."@\n"; 
                        $Lin[310] = "   no shutdown\n";
                        $Lin[311] = "!\n";

                        $Lin[312] = "";
                        $Lin[313] = ""; 
                        $Lin[314] = "";
                        $Lin[315] = "";
                    }else{
                        $Lin[308] = "interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa."\n";
                        $Lin[309] = "   description IP_DLK@FIBRA@".$NomeSwt."a@".$IpSwt."@1/1@1G@".$ID."@\n"; 
                        $Lin[310] = "   no shutdown\n";
                        $Lin[311] = "!\n";

                        $Lin[312] = "interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$Porta2Swa."\n";
                        $Lin[313] = "   description IP_DLK@FIBRA@".$NomeSwt."b@".$IpSwt."@1/1@1G@".$ID."@\n"; 
                        $Lin[314] = "   no shutdown\n";
                        $Lin[315] = "!\n"; 
                    }
                    $Lin[316] = "vlan ".$gVlan."\n";
                    if(str_contains($TipoPtSwa, 'Eth')){
                        $Lin[317] = "  interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa."\n";
                    }else{
                        $Lin[317] = "  interface ".$TipoPtSwa."\n"; // Lag
                    }  
                    $Lin[318] = "!\n";
                    $Lin[319] = "vlan ".$sVlan."\n";
                    $Lin[320] = "  name IPD#".$raX."#".$PortaRA."\n";
                    if(str_contains($TipoPtSwa, 'Eth')){
                        $Lin[321] = "  interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa."\n";
                    }else{
                        $Lin[321] = "  interface ".$TipoPtSwa."\n"; // Lag
                    } 
                    $Lin[322] = "  untagged\n";
                    $Lin[323] = "!\n";
                    $Lin[324] = "vlan-mapping\n";
                    if(str_contains($TipoPtSwa, 'Eth')){
                        $Lin[325] = "  interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa."\n";
                    }else{
                        $Lin[325] = "  interface ".$TipoPtSwa."\n"; // Lag
                    } 
                    $Lin[326] = "  ingress\n";
                    $Lin[327] = "   rule 1-1-".$PortaSwa."-".$gVlan."\n";
                    $Lin[328] = "    match vlan vlan-id ".$gVlan."\n";
                    $Lin[329] = "    action replace vlan vlan-id ".$gVlan." pcp 0\n";
                    $Lin[330] = "   !\n";
                    $Lin[331] = "   rule ".$sVlan.$cVlan."\n";
                    $Lin[332] = "    match vlan vlan-id ".$cVlan."\n";
                    $Lin[333] = "    action add vlan vlan-id ".$sVlan." pcp 0\n";
                    $Lin[334] = "   !\n";
                    $Lin[335] = "E.Flow:\n";
                    
                    $Lin[_CtgCARIMBO] = 36;
               

            }else if($Tipo == _DCFG){    
                //--------------------------------------------------------------------------//
                // Script de desconfiguracao
                $Lin[0] = "config e";
                $Lin[1] = "!";
                $Lin[2] = "dot1q";
                $Lin[3] = " vlan ".$sVlan;
                $Lin[4] = "  no interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;
                $Lin[5] = "exit";
                $Lin[6] = "exit";
                $Lin[7] = "!";
                $Lin[8] = "!";			
                $Lin[9] = "vlan-mapping";
                $Lin[10] = "  no interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;
                $Lin[11] = "exit";
                $Lin[12] = "!";
                $Lin[13] = "!";            
                $Lin[14] = "!";
                $Lin[15] = "interface gigabit-ethernet ".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;
                $Lin[16] = "shutdown";
                $Lin[17] = "no description";
                $Lin[18] = "exit";
                $Lin[19] = "!";
                $Lin[20] = "commit";
                $Lin[21] = "!";
                $Lin[22] = "exit";
                $Lin[23] = "!";
                    
                $Lin[_CtgLinScript] = 24;    // Conta Linhas desconfiguracao

                // CARIMBO Script-SWA p/ colar no Star   
                     
                $Lin[300] = "\n\n***  DESCONFIGURACAO ***\n\n";  
                $Lin[301] = "***  BBIP ***\n\n\n";   
                $Lin[302] = "\n";       
                $Lin[303] = "***  ".$Swa." ***\n";  
                $Lin[304] = "\n";                     
                $Lin[305] = $EthDcpt.$SlotSwa."/".$PortaSwa."\n";
                $Lin[306] = "no description IP_DLK@FIBRA@".$NomeSwt."@".$IpSwt."@1/1@1G@".$ID."@\n"; 
                $Lin[307] = "shutdown\n";
                $Lin[308] = "!\n";
                $Lin[309] = " vlan ".$gVlan."\n";
                $Lin[310] = "no ".$Eth.$SlotSwa."/".$PortaSwa."\n";
                $Lin[311] = "!\n";
                $Lin[312] = " vlan ".$sVlan."\n";
                $Lin[313] = "  name IPD#".$raX."#".$PortaRA."\n";
                $Lin[314] = "no ".$Eth.$SlotSwa."/".$PortaSwa."\n";                
                $Lin[315] = "!\n";
                $Lin[316] = "vlan-mapping\n";
                $Lin[317] = "no ".$Eth.$SlotSwa."/".$PortaSwa."\n";               
                $Lin[318] = "!\n";
                $Lin[319] = "E.Flow - Desconexao SWT: \n";
                
                $Lin[_CtgCARIMBO] = 20;  
            } // if tipo...

            // Verifica antes da config
            $Lin[200] = 'Datacom:';             
            $Lin[201] = 'show inventory'; // Se porta esta livre        
            $Lin[202] = 'show interface gigabit-ethernet 1/'.$SlotSwa.'/'.$PortaSwa;     
            $Lin[203] = 'show interface utilization gigabit-ethernet-1/'.$SlotSwa.'/'.$PortaSwa;     
            $Lin[204] = 'show vlan membership '.$gVlan;     
            $Lin[205] = 'show vlan membership '.$sVlan;     
            $Lin[206] = 'show run | inc '.$cVlan;     
            $Lin[207] = 'show run | inc '.$ID;     
            $Lin[208] = 'show mac-address-table';             
            $Lin[209] = 'show mac-address-table interface gigabit-ethernet-1/'.$SlotSwa.'/'.$PortaSwa;             
          
            $Lin[_CtgCmdRouters] = 10;

        }else if(($Modelo == 'DM4250')||($Modelo == 'DM4270')||($Modelo == 'DM4370')){

            if($PortaSwa > 4){ 
                $EthDcpt = "interface gigabit-ethernet 1/"; 
                $Eth = "interface gigabit-ethernet-1/"; 
            }else{ 
                $EthDcpt = "interface ten-gigabit-ethernet 1/"; 
                $Eth = "interface ten-gigabit-ethernet-1/"; 
            }


            if(($Tipo == _CFG)||($Tipo == _MIGRA)){
             
                $Lin[0] = "config e";
                $Lin[1] = "!";
                $Lin[2] = "dot1q";
                $Lin[3] = " vlan 2";            
                $Lin[4] = $Eth.$SlotSwa."/".$PortaSwa;
                $Lin[5] = "   untagged";
                $Lin[6] = "exit";
                $Lin[7] = "exit";
                $Lin[8] = "exit";
                $Lin[9] = "!";
                $Lin[10] = "dot1q";
                $Lin[11] = " vlan ".$sVlan;
                $Lin[12] = $Eth.$SlotSwa."/".$PortaSwa;
                $Lin[13] = "   untagged";
                $Lin[14] = "exit";
                $Lin[15] = "exit";
                $Lin[16] = "exit";
                $Lin[17] = "!";
                $Lin[18] = "dot1q";
                $Lin[19] = " vlan ".$gVlan;
                $Lin[20] = $Eth.$SlotSwa."/".$PortaSwa;
                $Lin[21] = "exit";
                $Lin[22] = "exit";
                $Lin[23] = "exit";
                $Lin[24] = "!";
                $Lin[25] = "switchport";
                $Lin[26] = $Eth.$SlotSwa."/".$PortaSwa;
                $Lin[27] = "  native-vlan";
                $Lin[28] = "   vlan-id 2";
                $Lin[29] = "  !";
                $Lin[30] = "exit";
                $Lin[31] = "  !";
                $Lin[32] = "  qinq";
                $Lin[33] = " !";
                $Lin[34] = "exit";
                $Lin[35] = "exit";
                $Lin[36] = "!";
                $Lin[37] = "vlan-mapping";
                $Lin[38] = $Eth.$SlotSwa."/".$PortaSwa;
                $Lin[39] = "  ingress";
                $Lin[40] = "   rule 1-1-".$PortaSwa."-".$gVlan;
                $Lin[41] = "    match vlan vlan-id ".$gVlan;
                $Lin[42] = "    action replace vlan vlan-id ".$gVlan." pcp 0";
                $Lin[43] = "   !";
                $Lin[44] = "   rule ".$sVlan.$cVlan;
                $Lin[45] = "    match vlan vlan-id ".$cVlan;
                $Lin[46] = "    action add vlan vlan-id ".$sVlan." pcp 0";
                $Lin[47] = "   !";
                $Lin[48] = "exit";
                $Lin[49] = "exit";
                $Lin[50] = "exit";
                $Lin[51] = "exit";
                $Lin[52] = "!";            
                $Lin[53] = "!";
                $Lin[54] = $EthDcpt.$SlotSwa."/".$PortaSwa;
                $Lin[55] = "description IP_DLK@FIBRA@".$NomeSwt."@".$IpSwt."@1/1@1G@".$ID."@";               
                $Lin[56] = "no negotiation";
                $Lin[57] = "duplex full";
                $Lin[58] = "speed 1G";
                $Lin[59] = "no shutdown";
                $Lin[60] = "exit";
                $Lin[61] = "!";
                $Lin[62] = "lldp";
                $Lin[63] = $Eth.$SlotSwa."/".$PortaSwa;
                $Lin[64] = "admin-status tx-and-rx	";
                $Lin[65] = "no notification";
                $Lin[66] = "!";
                $Lin[67] = "exit";
                $Lin[68] = "!";
                $Lin[69] = "exit";
                $Lin[70] = "!";
                $Lin[71] = "commit";
                $Lin[72] = "!";
                $Lin[73] = "exit";
                $Lin[74] = "!";
                /*
                $Lin[72] = "PORT-CHANNEL USAR ESTA CONFIG";
                $Lin[74] = "!";
                $Lin[75] = "link-aggregation";
                $Lin[76] = "interface gigabit-ethernet 1/1/".$PortaSwa;           
                $Lin[77] = "description IP_DLK@FIBRA@".$NomeSwt."@".$IpSwt."@1/1@1G@".$ID."@";
                $Lin[78] = "exit";
                $Lin[79] = "exit";
                $Lin[80] = "!";
                $Lin[81] = "commit";
                $Lin[82] = "!";
                */
                $Lin[_CtgLinScript] = 75;

                // CARIMBO Script-SWA p/ colar no Star   
                if($Tipo == _MIGRA){         
                    $Lin[300] = "\n\n***  MIGRACAO VIVO2, VIVO1, MANTIDO OS IPs ***";  
                    $Lin[301] = "\n";
                    $Lin[302] = "\n";
                    $Lin[303] = "\n";  
                }else{
                    $Lin[300] = "\n\n***  VALIDACAO DE IPs ***";  
                    $Lin[301] = "\nID CERTIFICADO";
                    $Lin[302] = "\nAtividade concluída com sucesso.\n";
                    $Lin[303] = "ID Execução:  \n\n"; 
                }             
                $Lin[304] = "***  BBIP ***\n\n\n";   
                $Lin[305] = "\n";       
                $Lin[306] = "***  ".$Swa." ***\n";  
                $Lin[307] = "\n";                     
                $Lin[308] = $EthDcpt.$SlotSwa."/".$PortaSwa."\n";
                $Lin[309] = "description IP_DLK@FIBRA@".$NomeSwt."@".$IpSwt."@1/1@1G@".$ID."@\n"; 
                $Lin[310] = "no shutdown\n";
                $Lin[311] = "!\n";
                $Lin[312] = " vlan ".$gVlan."\n";
                $Lin[313] = $Eth.$SlotSwa."/".$PortaSwa."\n";
                $Lin[314] = "!\n";
                $Lin[315] = " vlan ".$sVlan."\n";
                $Lin[316] = "  name IPD#".$raX."#".$PortaRA."\n";
                $Lin[317] = $Eth.$SlotSwa."/".$PortaSwa."\n";
                $Lin[318] = "   untagged\n";
                $Lin[319] = "!\n";
                $Lin[320] = "vlan-mapping\n";
                $Lin[321] = $Eth.$SlotSwa."/".$PortaSwa."\n";
                $Lin[322] = "  ingress\n";
                $Lin[323] = "   rule ".$ShelfSwa."-".$SlotSwa."-".$PortaSwa."-".$gVlan."\n";
                $Lin[324] = "    match vlan vlan-id ".$gVlan."\n";
                $Lin[325] = "    action replace vlan vlan-id ".$gVlan." pcp 0\n";
                $Lin[326] = "   !\n";
                $Lin[327] = "   rule ".$sVlan.$cVlan."\n";
                $Lin[328] = "    match vlan vlan-id ".$cVlan."\n";
                $Lin[329] = "    action add vlan vlan-id ".$sVlan." pcp 0\n";
                $Lin[330] = "   !\n";
                $Lin[331] = "E.Flow:\n";
                
                $Lin[_CtgCARIMBO] = 32;  

                // Verifica antes da config
                $Lin[100] = 'Datacom:';             
                $Lin[101] = 'show inventory'; // Se porta esta livre        
                $Lin[102] = 'show interface gigabit-ethernet 1/'.$SlotSwa.'/'.$PortaSwa;     
                $Lin[103] = 'show interface ten-gigabit-ethernet 1/'.$SlotSwa.'/'.$PortaSwa;    
                $Lin[104] = 'show interface utilization gigabit-ethernet-1/'.$SlotSwa.'/'.$PortaSwa;
                $Lin[105] = 'show interface utilization ten-gigabit-ethernet-1/'.$SlotSwa.'/'.$PortaSwa;                      
                $Lin[106] = 'show vlan membership '.$gVlan;     
                $Lin[107] = 'show vlan membership '.$sVlan; 
                $Lin[108] = 'show run | inc '.$cVlan;    
                $Lin[109] = 'show mac-address-table';             
                $Lin[110] = 'show mac-address-table interface gigabit-ethernet-1/'.$SlotSwa.'/'.$PortaSwa;             
                $Lin[111] = 'show mac-address-table interface ten-gigabit-ethernet-1/'.$SlotSwa.'/'.$PortaSwa;             
            
                $Lin[_CtgCmdRouters] = 12;

            
            }else if($Tipo == _DCFG){    
                //--------------------------------------------------------------------------//
                // Script de desconfiguracao
                $Lin[0] = "config e";
                $Lin[1] = "!";
                $Lin[2] = "dot1q";
                $Lin[3] = " vlan ".$sVlan;
                $Lin[4] = "  no interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;
                $Lin[5] = "exit";
                $Lin[6] = "exit";
                $Lin[7] = "!";
                $Lin[8] = "!";			
                $Lin[9] = "vlan-mapping";
                $Lin[10] = "  no interface gigabit-ethernet-".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;
                $Lin[11] = "exit";
                $Lin[12] = "!";
                $Lin[13] = "!";            
                $Lin[14] = "!";
                $Lin[15] = "interface gigabit-ethernet ".$ShelfSwa."/".$SlotSwa."/".$PortaSwa;
                $Lin[16] = "shutdown";
                $Lin[17] = "no description";
                $Lin[18] = "exit";
                $Lin[19] = "!";
                $Lin[20] = "commit";
                $Lin[21] = "!";
                $Lin[22] = "exit";
                $Lin[23] = "!";
                    
                $Lin[_CtgLinScript] = 24;    // Conta Linhas desconfiguracao

                // CARIMBO Script-SWA p/ colar no Star   
                     
                $Lin[300] = "\n\n***  DESCONFIGURACAO ***\n\n";  
                $Lin[301] = "***  BBIP ***\n\n\n";   
                $Lin[302] = "\n";       
                $Lin[303] = "***  ".$Swa." ***\n";  
                $Lin[304] = "\n";                     
                $Lin[305] = $EthDcpt.$SlotSwa."/".$PortaSwa."\n";
                $Lin[306] = "no description IP_DLK@FIBRA@".$NomeSwt."@".$IpSwt."@1/1@1G@".$ID."@\n"; 
                $Lin[307] = "shutdown\n";
                $Lin[308] = "!\n";
                $Lin[309] = " vlan ".$gVlan."\n";
                $Lin[310] = "no ".$Eth.$SlotSwa."/".$PortaSwa."\n";
                $Lin[311] = "!\n";
                $Lin[312] = " vlan ".$sVlan."\n";
                $Lin[313] = "  name IPD#".$raX."#".$PortaRA."\n";
                $Lin[314] = "no ".$Eth.$SlotSwa."/".$PortaSwa."\n";                
                $Lin[315] = "!\n";
                $Lin[316] = "vlan-mapping\n";
                $Lin[317] = "no ".$Eth.$SlotSwa."/".$PortaSwa."\n";               
                $Lin[318] = "!\n";
                $Lin[319] = "E.Flow - Desconexao SWT: \n";
                
                $Lin[_CtgCARIMBO] = 20;  
            
           
            } // if tipo...

        }else if($Modelo == 'DM400X' || $Modelo == 'DM4100'){           

            if(($Tipo == _CFG)||($Tipo == _MIGRA)){

                // SCRIPT SWA SERVICO DATACOM IPD-VPN-SIP(CONECTADO COM CPE)
                $Lin[0] = "config";
                $Lin[1] = "!";
                $Lin[2] = "interface vlan ".$gVlan;
                $Lin[3] = "set-member tagged ethernet ".$SlotSwa."/".$PortaSwa;
                $Lin[4] = "exit";
                $Lin[5] = "!";
                $Lin[6] = "interface vlan ".$sVlan;
                $Lin[7] = "set-member untagged ethernet ".$SlotSwa."/".$PortaSwa;
                $Lin[8] = "exit";
                $Lin[9] = "!";
                $Lin[10] = "interface ethernet ".$SlotSwa."/".$PortaSwa;
                //$Lin[11] = "description SRV_IPD#FIBRA#".$NomeSwt."#".$IpSwt."_".$Speed."M_#1/1#1G#".$ID."#";                       
                $Lin[11] = "description SRV_IPD#FIBRA#".$NomeSwt."#".$IpSwt."#1/1#1G#".$ID."#";                       
                $Lin[12] = "no negotiation";
                $Lin[13] = "speed-duplex 1000full";
                $Lin[14] = "spanning-tree restricted-tcn";
                $Lin[15] = "no spanning-tree 1";
                $Lin[16] = "switchport native vlan 2";
                $Lin[17] = "switchport qinq external";
                $Lin[18] = "no switchport storm-control broadcast";
                $Lin[19] = "no switchport storm-control multicast";
                $Lin[20] = "no switchport storm-control unicast";
                $Lin[21] = "no switchport storm-control dlf";
                $Lin[22] = "switchport mtu 9198";
                $Lin[23] = "switchport vlan-translate ingress";
                $Lin[24] = "no queue sched-mode";
                $Lin[25] = "no oam";
                $Lin[26] = "no shut";
                $Lin[27] = "exit";
                $Lin[28] = "!";
                /*interface ethernet 3/13
                description SRV_IPD#FIBRA#M-BR-DF-BSA-TCO-SWT-150#172.21.39.50_100M_#1/1#1G#1854693#
                oam
                oam pdu-loss-limit 3
                no loopback-detection
                no negotiation
                no spanning-tree 1
                switchport qinq external
                no switchport storm-control broadcast
                no switchport storm-control multicast
                no switchport storm-control unicast
                switchport vlan-translate ingress
                ! */
                $Lin[29] = "vlan-translate ingress-table replace ethernet ".$SlotSwa."/".$PortaSwa." source-vlan ".$gVlan." new-vlan ".$gVlan;
                $Lin[30] = "vlan-translate ingress-table add ethernet ".$SlotSwa."/".$PortaSwa." source-vlan ".$cVlan." new-vlan ".$sVlan;
                $Lin[31] = "!";
                $Lin[32] = "exit";
                $Lin[33] = "!";
                $Lin[34] = "sh flash";
                $Lin[35] = "copy run st X";
                
                $Lin[_CtgLinScript] = 36; 

                // carimbo Script-SWA p/ colar no Star
                $Lin[300] = "\n\n***  VALIDACAO DE IPs ***";  
                $Lin[301] = "\nID CERTIFICADO";
                $Lin[302] = "\nAtividade concluída com sucesso.\n";
                $Lin[303] = "ID Execução:  \n\n";         
                $Lin[304] = "***  BBIP ***\n\n\n";     
                $Lin[305] = "\n";     
                $Lin[306] = "***  ".$Swa." ***\n"; 
                $Lin[307] = "\n";        
                $Lin[308] = "interface ethernet ".$SlotSwa."/".$PortaSwa."\n";
                //$Lin[309] = "description SRV_IPD#FIBRA#".$NomeSwt."#_Speed_#0000/00#".$ID."#".$NomeSwt."#".$IpSwt."#\n";
                $Lin[309] = "description SRV_IPD#FIBRA#".$NomeSwt."#".$IpSwt."#1/1#1G#".$ID."#\n";
                $Lin[310] = "!\n";
                $Lin[311] = "interface vlan ".$gVlan."\n";
                $Lin[312] = "set-member tagged ethernet ".$SlotSwa."/".$PortaSwa."\n";            
                $Lin[313] = "!\n";
                $Lin[314] = "interface vlan ".$sVlan."\n";
                $Lin[315] = "set-member untagged ethernet ".$SlotSwa."/".$PortaSwa."\n";           
                $Lin[316] = "!\n";            
                $Lin[317] = "vlan-translate ingress-table replace ethernet ".$SlotSwa."/".$PortaSwa." source-vlan ".$gVlan." new-vlan ".$gVlan."\n";
                $Lin[318] = "vlan-translate ingress-table add ethernet ".$SlotSwa."/".$PortaSwa." source-vlan ".$cVlan." new-vlan ".$sVlan."\n";
                $Lin[319] = "!\n";
                $Lin[320] = "E.Flow:\n";
            
                $Lin[_CtgCARIMBO] = 21; 

                 // Checagens antes da config
                 $Lin[100] = 'Datacom:'; 
                 $Lin[101] = 'show system';                 
                 $Lin[102] = 'show int status eth '.$SlotSwa.'/'.$PortaSwa;     
                 $Lin[103] = 'sh vlan';  
                 $Lin[104] = 'show run | inc '.$ID;           
                 $Lin[105] = 'show run | inc '.$cVlan;           
                 $Lin[106] = 'sh vlan id '.$gVlan;             
                 $Lin[107] = 'sh vlan id '.$sVlan;             
                 $Lin[108] = 'sh mac-address-table ';             
                 $Lin[109] = 'sh mac-address-table interface ethernet '.$SlotSwa.'/'.$PortaSwa;             
                 $Lin[110] = 'no vlan-translate ingress-table ethernet '.$SlotSwa.'/'.$PortaSwa.' source-vlan '.$cVlan; // Profile             
             
                 $Lin[_CtgCmdRouters] = 11;
 

            }else if($Tipo == _DCFG){    
                // Script de desconfiguracao
                $Lin[0] = "config";
                $Lin[1] = "!";
                $Lin[2] = "interface vlan ".$gVlan;
                $Lin[3] = "no set-member ethernet ".$SlotSwa."/".$PortaSwa;
                $Lin[4] = "exit";
                $Lin[5] = "!";
                $Lin[6] = "interface vlan ".$sVlan;
                $Lin[7] = "no set-member ethernet ".$SlotSwa."/".$PortaSwa;
                $Lin[8] = "exit";
                $Lin[9] = "!";
                $Lin[10] = "interface ethernet ".$SlotSwa."/".$PortaSwa;
                $Lin[11] = "no description";                       
                $Lin[12] = "shutdown";               
                $Lin[13] = "exit";
                $Lin[14] = "!";               
                $Lin[15] = "no vlan-translate ingress-table ethernet ".$SlotSwa."/".$PortaSwa." source-vlan ".$gVlan;
                $Lin[16] = "no vlan-translate ingress-table ethernet ".$SlotSwa."/".$PortaSwa." source-vlan ".$cVlan;
                $Lin[17] = "!";
                $Lin[18] = "exit";
                $Lin[19] = "!";
                $Lin[20] = "sh flash";
                $Lin[21] = "copy run st X";
                
                $Lin[_CtgLinScript] = 22; 

                // carimbo Script-SWA p/ colar no Star
                $Lin[300] = "\n\n***  DESCONFIGURACAO ***\n\n"; 
                $Lin[301] = "***  BBIP ***\n\n\n";     
                $Lin[302] = "\n";     
                $Lin[303] = "***  ".$Swa." ***\n"; 
                $Lin[304] = "\n";        
                $Lin[305] = "interface ethernet ".$SlotSwa."/".$PortaSwa."\n";
                $Lin[306] = "no description SRV_IPD#FIBRA#".$NomeSwt."#_Speed_#0000/00#".$ID."#".$NomeSwt."#".$IpSwt."#\n";
                $Lin[307] = "!\n";
                $Lin[308] = "interface vlan ".$gVlan."\n";
                $Lin[309] = "no set-member ethernet ".$SlotSwa."/".$PortaSwa."\n";            
                $Lin[310] = "!\n";
                $Lin[311] = "interface vlan ".$sVlan."\n";
                $Lin[312] = "no set-member ethernet ".$SlotSwa."/".$PortaSwa."\n";           
                $Lin[313] = "!\n";            
                $Lin[314] = "no vlan-translate ingress-table ethernet ".$SlotSwa."/".$PortaSwa." source-vlan ".$gVlan."\n";
                $Lin[315] = "no vlan-translate ingress-table ethernet ".$SlotSwa."/".$PortaSwa." source-vlan ".$cVlan."\n";
                $Lin[316] = "!\n";
                $Lin[317] = "E.Flow - Desconexao SWT: \n";
            
                $Lin[_CtgCARIMBO] = 18; 
               
                
               
            } // if tipo...    
        }else{
            // Checagens antes da config
            $Lin[100] = 'Dtc(2104G2):'; 
            $Lin[101] = 'show version ';                 
            $Lin[102] = 'show int status eth 1/1';     
            $Lin[103] = 'sh mac-address-table ';             
            $Lin[104] = 'no vlan-translate ingress-table ethernet 1/1 source-vlan 100'; // Profile             
        
            $Lin[_CtgCmdRouters] = 5;  
        }

         // Script Preview 
         $Lin[200] = " ID   : ".$ID;            
         $Lin[201] = " Eth  : ".$SlotSwa.'/'.$PortaSwa;            
         $Lin[202] = " gVlan: ".$gVlan;            
         $Lin[203] = " sVlan: ".$sVlan;            
         $Lin[204] = " cVlan: ".$cVlan;  

         /*
         // Verifica antes da config
         $Lin[100] = 'Datacom:'; 
         $Lin[101] = 'show version'; 
         $Lin[102] = 'show system'; 
         $Lin[103] = 'show chassi'; 
         $Lin[104] = 'show flash'; 
         $Lin[105] = 'show inventory'; // Se porta esta livre        
         $Lin[106] = 'show int status eth '.$SlotSwa.'/'.$PortaSwa;     
         $Lin[107] = 'sh mac-address-table interface ethernet '.$SlotSwa.'/'.$PortaSwa;             
         $Lin[108] = 'no vlan-translate ingress-table ethernet '.$SlotSwa.'/'.$PortaSwa.' source-vlan '.$cVlan; // Profile             
    
         $Lin[_CtgCmdRouters] = 9;
        */
        return $Lin;
        
    }
    

    function TunnelCisco($Modelo, $Ra, $IntePortOrigem, $IntPortDestino, $sVlan, $PwId, $NomeNeighbor, $IpNeighbor, $Tipo){
    // Gera Script de config Tunnel Cisco
        //if(($Tipo == _CFG)||($Tipo == _MIGRA)){
            $Lin[] = "";

            $Lin[0] = "config e";
            $Lin[1] = "!";
            $Lin[2] = "interface ".$IntPortDestino.".".$sVlan." l2transport";
            $Lin[3] = "interface ".$IntPortDestino.".".$sVlan." l2transport description IP_SRV#".$NomeNeighbor."_".$IntePortOrigem."#PW-L3".$Tipo;
            $Lin[4] = "interface ".$IntPortDestino.".".$sVlan." l2transport encapsulation dot1q ".$sVlan;
            $Lin[5] = "interface ".$IntPortDestino.".".$sVlan." l2transport mtu 9102";
            $Lin[6] = "!";
            $Lin[7] = "l2vpn xconnect group PW-ACESSO-L3IPD p2p ".$PwId." interface ".$IntPortDestino.".".$sVlan;
            $Lin[8] = "l2vpn xconnect group PW-ACESSO-L3IPD p2p ".$PwId;
            $Lin[9] = "l2vpn xconnect group PW-ACESSO-L3IPD p2p ".$PwId." interface ".$IntPortDestino.".".$sVlan;
            $Lin[10] = "l2vpn xconnect group PW-ACESSO-L3IPD p2p ".$PwId." neighbor ipv4 ".$IpNeighbor." pw-id ".$PwId;
            $Lin[11] = "l2vpn xconnect group PW-ACESSO-L3IPD p2p ".$PwId." neighbor ipv4 ".$IpNeighbor." pw-id ".$PwId." pw-class PW-CLASS-VLAN-PASSTHROUGH";
            $Lin[12] = "l2vpn xconnect group PW-ACESSO-L3IPD p2p ".$PwId." description IP_SRV#".$NomeNeighbor."_".$Ra."#PW-L3".$Tipo;
            $Lin[13] = "!";
            $Lin[14] = "commit";
        
            $Lin[_CtgScpTunnel] = 15; 
        //}
            return $Lin;

    }
    function TunnelHl5g($RA, $Swa, $IntePortHl5g, $sVlan, $PwId, $IpNeighbor, $Tipo){
    // Gera Script de config Tunnel Cisco
        //if(($Tipo == _CFG)||($Tipo == _MIGRA)){
            $Lin[] = "";

            $Lin[0]="sys";
            $Lin[1]="interface ".$IntePortHl5g.$sVlan;
            $Lin[2]=" vlan-type dot1q ".$sVlan;
            $Lin[3]=" mtu 9088";
            $Lin[4]=" description IP_SRV#".$Swa."_".$RA."#PW-".$Tipo;
            $Lin[5]=" statistic enable";
            $Lin[6]=" trust upstream default";
            $Lin[7]=" mpls l2vc ".$IpNeighbor." ".$PwId;
            $Lin[8]=" trust 8021p";
            $Lin[9]="#";


            
            $Lin[_CtgScpTunnelHl5g] = 10; 
        //}
            return $Lin;

    }


    function EddToFab_nao_usa($M){
        // Esta funcao foi so pra nao ter que cadastrar Fab: datacom no MySQL
        if($M == '2104G2'){ return 'Datacom'; };
        if($M == 'DM4004'){ return 'Datacom'; };
        if($M == 'DM4008'){ return 'Datacom'; };
        if($M == 'DM4050'){ return 'Datacom'; };
    }
    
    function SpeedToBandwidth($Speed){
        $Res = 0;
        /* Bug
        if((int)$Speed > 1){
            $Res = (int)$Speed * 1024;
          
        }else{
            if(!empty($Speed)){
                $Res = (float)$Speed *1000; // 0.128 * 1000 = 128                
            }
        }
        */
        if( (str_contains($Speed, '.'))
        ||  (str_contains($Speed, ','))){
            $Speed = str_replace(",", ".", $Speed);  // tira espaços vazios
            if(!empty($Speed)){
                $Res = (float)$Speed *1000; // 0.128 * 1000 = 128                
            }
        }else if((int)$Speed > 1){
            $Res = (int)$Speed * 1024;          
        } 
        return $Res;
    }

    function cmdReverTunnel($RdLan, $RdWan, $RdLo, $Port, $sVlan){

        $Lan[1] = $this->IpToRota($RdLan);
        $Lan[2] = $this->IpToRota($Lan[1]);
        $Lan[3] = $this->IpToRota($Lan[2]);
        $Wan[1] = $this->IpToRota($RdWan);
        $Wan[2] = $this->IpToRota($Wan[1]);

        // Verifica antes da config
        $Lin[0] = "Tunnel(MPLS):";
        $Lin[1] = "sh int description";
        $Lin[2] = "";
        $Lin[3] = "display current-configuration | include .".$sVlan;
        $Lin[4] = "display current-configuration interface ";
        $Lin[5] = "";
        $Lin[6] = "sh conf run formal | include .".$sVlan;
        $Lin[7] = "sh run interface ".$Port;
        $Lin[8] = "";
        $Lin[9] = "admin display-config | match context all ".$sVlan;
        $Lin[10] = "admin display-config | match context all ";   
        $Lin[11] = "Extras";
        $Lin[12] = "sh conf run formal | inc l2vpn";
        $Lin[13] = "sh l2vpn xconnect group PW-ACESSO-L3VPN";
        $Lin[14] = "sh l2vpn xconnect interface ".$Port.".".$sVlan;
        $Lin[15] = "Rever IP´s";
        $Lin[16] = "cat /deviceList | grep -swa-0";
        $Lin[17] = "sed -i '66d' /home/80969577/.ssh/known_hosts";
        $Lin[18] = "ssh i-br-sp-spo-cbl-rsd-01"; 
        $Lin[19] = "ssh c-br-sp-spo-ctp-rav-01";
        $Lin[20] = "ssh c-br-sp-spo-ctp-rac-02"; 
        
        $Lin[_CtgVETOR] = 21;
    
        return ($Lin);	
    }

   function servicePolicy($Router, $Speed, $Tipo){
        
        $Res[] = "";

       
      

        if($Router == 'Cisco'){

            if($Tipo == 'IPD'){
                $Res[100] ='IPD-SECURITY-IN-'.$Speed.'M'; 
                $Res[200] ='IPD-SECURITY-OUT-'.$Speed.'M'; 
                $Res[101] ='IPD-SECURITY-IN-'.$Speed.'Mbps'; 
                $Res[201] ='IPD-SECURITY-OUT-'.$Speed.'Mbps'; 
                $Res[102] = 'IPD_SECURITY_IN_'.$Speed.'M';  
                $Res[202] = 'IPD_OUT_'.$Speed.'M_SHAPE'; 
                $Res[103] = 'IPD-SECURITY-IN-'.$Speed.'M';  
                $Res[203] = 'IPD-OUT-'.$Speed.'M-SHAPE'; 
               
                $Res[104] = 'IPD_SECURITY_IN_'.$Speed.'M'; 
                $Res[204] = 'IPD_OUT-SHAPE'; 
                $Res[105] = 'LIMIT-'.$Speed.'M-QOS-ETH'; 
                $Res[205] = 'LIMIT-'.$Speed.'M-QOS-ETH';
                
                $Res[106] = 'IPD_SECURITY_IN'; 
                $Res[206] = 'IPD_OUT-SHAPE'; 
                
                $Res[1000] = 7;
            
            }else if($Tipo == 'VPN'){

                 // Formata 0.128 p/ 128K
                if((str_contains($Speed, '0.'))
                || (str_contains($Speed, '0,')) ){
                    $Speed = str_replace("0.", "", $Speed);  
                    $Speed = str_replace("0,", "", $Speed);  
                    $Speed = $Speed.'K';
                }else{
                    $Speed = $Speed.'M';  
                }

                $Res[100] = 'IPD_SECURITY_IN_'.$Speed; 
                $Res[200] = 'BANCO_ITAU_'.$Speed.'_VPN-IP_MPLS_ETH'; 
                $Res[101] = 'IPD_SECURITY_IN_'.$Speed; 
                $Res[201] = 'BANCO_ITAU_'.$Speed.'_VPN-IP_MPLS_ETH_SHAPE';                
               
                $Res[102] = 'CAIXA_ECON_'.$Speed.'_VPN-IP_MPLS_ETH_SHAPE';
                $Res[202] = 'CAIXA_ECON_'.$Speed.'_VPN-IP_MPLS_ETH_SHAPE'; 

                $Res[103] = 'CREA_'.$Speed.'_VPN-IP_ETH';
                $Res[203] = 'CREA_'.$Speed.'_VPN-IP_ETH';                             
                
                $Res[104] = 'IPD_SECURITY_IN_'.$Speed; 
                $Res[204] = 'TELEFONICA_'.$Speed.'_VPN-IP_MPLS_A_ETH_SHAPE';                
                
                $Res[105] = 'TECBAN_'.$Speed.'bps_VPN-MPLS_ETH';
                $Res[205] = 'TECBAN_'.$Speed.'bps_VPN-MPLS_ETH';

                $Res[106] = 'TECBAN_'.$Speed.'bps_VPN-MPLS_ETH';
                $Res[206] = 'TECBAN_'.$Speed.'bps_VPN-MPLS_ETH_SHAPE';

                $Res[107] = 'LIMIT-'.$Speed.'-TECBAN-QOS-ETH'; 
                $Res[207] = 'LIMIT-'.$Speed.'-TECBAN-QOS-ETH'; 

                $Res[108] = 'LIGHT_'.$Speed.'_VPN-IP_ETH_SHAPE';
                $Res[208] = 'LIGHT_'.$Speed.'_VPN-IP_ETH_SHAPE';

                $Res[109] = 'LIMIT-'.$Speed.'-QOS-ETH'; 
                $Res[209] = 'LIMIT-'.$Speed.'-QOS-ETH'; 

                $Res[110] = 'IPD_SECURITY_IN_'.$Speed;  
                $Res[210] = 'IPD_OUT_'.$Speed.'_SHAPE'; 

                $Res[1000] = 11;
            }
            

        }else  if($Router == 'Huawei'){ 
            $Res[100] = 'IPD-SECURITY-IN-'.$Speed.'Mbps'; 
            $Res[200] = 'IPD-SECURITY-OUT-'.$Speed.'Mbps'; 
            $Res[101] = 'IPD-SECURITY-IN-'.$Speed.'M'; 
            $Res[201] = 'IPD-SECURITY-OUT-'.$Speed.'M'; 
            
            $Res[1000] = 2;

        }else  if($Router == 'Juniper'){ 
            $Res[100] = 'BORDER-POLICER-'.$Speed.'M'; 
            $Res[200] = 'BORDER-POLICER-'.$Speed.'M'; 
            
            $Res[101] = 'BORDER-POLICER-'.$Speed.'Mbps'; 
            $Res[201] = 'BORDER-POLICER-'.$Speed.'Mbps'; 	
            
            $Res[1000] = 2;

        }else  if($Router == 'Nokia'){ 							                                 	
            $Res[100] = "IPD_SECURITY_IN_".$Speed."M"; 	
            $Res[200] = "IPD_OUT_".$Speed."M_SHAPE"; 	
            
            $Res[101] = "IPD_SECURITY_IN_0".$Speed."M"; 	
            $Res[201] = "IPD_OUT_0".$Speed."M_SHAPE"; 	
            $Res[102] = "IPD-SECURITY-IN-0".$Speed."M"; 	
            $Res[202] = "IPD-OUT-0".$Speed."M-SHAPE"; 	
            
            $Res[103] = "IPD-SECURITY-IN-".$Speed."M"; 	
            $Res[203] = "IPD-OUT-".$Speed."M-SHAPE"; 	

            $Res[104] = 10000 + (int)$Speed; 	
            $Res[204] = 10000 + (int)$Speed; 	
            
            $Res[1000] = 5;

        }else{            
            $Res[100] ='IPD-SECURITY-IN-'.$Speed.'M'; 
            $Res[200] ='IPD-SECURITY-OUT-'.$Speed.'M'; 
            $Res[1000] = 1;
        } 	

        return $Res;
    }
    
   
    function calcRotaIPv4($Hx){
          
        
        $Ha = substr($Hx, 0, 1);
        $Hb = (int)substr($Hx, 1, 2);    
        if($Ha != '.'){
            if($Hb == 9){
                $Ha = (int)$Ha + 1;
                $Hb = 0;                
            }else{ $Hb = $Hb + 1; }
            return $Ha.$Hb;
            
        }else{
            $Hb = $Hb + 1;
            return $Ha.$Hb; 
        }    
    }

    function IpToRota($Wan){
       
        $WanToRota = "";
        if( str_contains($Wan,':') ){ // IPv6

            $WanInicio = substr($Wan, 0, -4); // pega do inicio, -4 ultimos

            $Hx4 = substr($Wan, -4); // Pega os 4 ultimos
            if(str_contains($Hx4, ':') ){       // p/ enderecos: 2804:7f2:1004:8::5
                $Hx4 = substr($Wan, -1);        // pega: 5
                $WanInicio = substr($Wan, 0, -1);       // pega: 8::
            }             
            $decHx = hexdec($Hx4);
            $decHx = $decHx + 1;
            $WanUltS4 = dechex($decHx);
           
            $WanToRota = $WanInicio.$WanUltS4;

        }else{ // IPv4             
            $WanInicio = substr($Wan, 0, -2); 
            $WanUltS1 = $this->calcRotaIPv4(substr($Wan, -2), _IPv4);
            $WanToRota = $WanInicio.$WanUltS1;
        }   

        return $WanToRota;
    }   
    
    function checkIP($Ip){
        $Res = "Null";
        $FinalWan6 = substr($Ip,-1);
        if( $FinalWan6 == 'F' || $FinalWan6 == 'f' ){ $Res = 'F'; }      
        if( $FinalWan6 == '9' ){ $Res = '9';  }
        return $Res;       
    }
   
    function CheckCamposSwa($ModeloX, $IDX, $SlotSwaX, $PortaSwaX, $SwtX, $Swt_ipX, $gVlanX, $RaX, $PortX, $sVlanX, $cVlanX){

        $objFuncao = new Funcao();
        //$objFuncao->RegistrarLog('Class.MySql.SalveAdicionar('.$Assunto.');');

        $Res = true;
        $msg[] = "";
        $somaMsg = "";
        $Tot = 11;
        for($m = 0; $m < $Tot; $m++){  $msg[$m] = "Null"; }

        // Verifica se campos foram preenchidos
        if($ModeloX==''){ $msg[0]="Modelo"; $Res = false; } 
        if($IDX==''){ $msg[1]="ID"; $Res = false; } 
        if($SlotSwaX==''){ $msg[2]="Slot Swa"; $Res = false; } 
        if($PortaSwaX==''){ $msg[3]="Porta Swa"; $Res = false; } 
        if($SwtX==''){ $msg[4]="Nome SWT"; $Res = false; } 
        if($Swt_ipX==''){ $msg[5]="IP SWT"; $Res = false; } 
        if($gVlanX==''){ $msg[6]="gVlan"; $Res = false; } 
        if($RaX==''){ $msg[7]="Id RA"; $Res = false; } 
        if($PortX==''){ $msg[8]="Porta RA"; $Res = false; }         
        if($sVlanX==''){ $msg[9]="sVlan"; $Res = false; } 
        if($cVlanX==''){ $msg[10]="cVlan"; $Res = false; }

        if(!$Res){
            for($M = 0; $M < $Tot; $M++){
                if( $msg[$M] != 'Null'){ $somaMsg = $somaMsg.', "'.$msg[$M].'"'; }
            }
            $objFuncao->Mensagem('Erro!','Formato do(s) campo(s): '.$somaMsg.' e(sao) invalido(s).', Null, Null, defAviso, defPerigo);
        }

        return $Res;

    }

    function CheckCamposBBone($ModeloX, $IDX, $EmpresaX, $RaX, $PortX, $SpeedX, $PolicyIN, $PolicyOUT, $sVlanX, $cVlanX, $IpLanX, $IpWanX, $IpLoX, $IpLan6, $IpWan6){

        $objFuncao = new Funcao();
        //$objFuncao->RegistrarLog('Class.MySql.SalveAdicionar('.$Assunto.');');

        $Res = true;
        $msg[] = "";
        $somaMsg = "";
        $Tot = 15;
        for($m = 0; $m < $Tot; $m++){  $msg[$m] = "Null"; }

        // Verifica se campos foram preenchidos
        if($ModeloX==''){ $msg[0]="Modelo"; $Res = false; } 
        if($IDX==''){ $msg[1]="ID"; $Res = false; } 
        if($EmpresaX==''){ $msg[2]="Empresa"; $Res = false; }        
        if($RaX==''){ $msg[3]="Id RA"; $Res = false; } 
        if($PortX==''){ $msg[4]="Porta RA"; $Res = false; } 
        if($SpeedX==''){ $msg[5]="Speed"; $Res = false; } 
        if($PolicyIN==''){ $msg[6]="Policy-IN"; $Res = false; } 
        if($PolicyOUT==''){ $msg[7]="Policy-OUT"; $Res = false; }         
        if($sVlanX==''){ $msg[8]="sVlan"; $Res = false; }
        if($cVlanX==''){ $msg[9]="cVlan"; $Res = false; }
        if($IpLanX==''){ $msg[10]="IP-Lan"; $Res = false; }
        if($IpWanX==''){ $msg[11]="IP-Wan"; $Res = false; }
        if($IpLoX==''){ $msg[12]="IP-Lo"; $Res = false; }
        if($IpLan6==''){ $msg[13]="IP-Lan6"; $Res = false; }
        if($IpWan6==''){ $msg[14]="IP-Wan6"; $Res = false; }

        if(!$Res){
            for($M = 0; $M < $Tot; $M++){
                if( $msg[$M] != 'Null'){ $somaMsg = $somaMsg.', "'.$msg[$M].'"'; }
            }
            $objFuncao->Mensagem('Erro!','Formato do(s) campo(s): '.$somaMsg.' e(sao) invalido(s).', Null, Null, defAviso, defPerigo);
        }

        return $Res;

    }

    function lstRav(){
        // Lista Router RAV(Rede Acesso VPN)
        $Rav[0] = "ssh c-br-ac-rbo-rbo-rav-01"; 
        $Rav[1] = "ssh c-br-am-mns-afp-rav-01"; 
        $Rav[2] = "ssh c-br-ap-mpa-lag-rav-01"; 
        $Rav[3] = "ssh c-br-ba-sdr-cb-rav-02"; 
        $Rav[4] = "ssh c-br-ba-sdr-vla-rav-01"; 
        $Rav[5] = "ssh c-br-ce-fla-ad-rav-01"; 
        $Rav[6] = "ssh c-br-ce-fla-ad-rav-02"; 
        $Rav[7] = "ssh c-br-df-bsa-tce-rav-01"; 
        $Rav[8] = "ssh c-br-df-bsa-tco-rav-01"; 
        $Rav[9] = "ssh c-br-es-vta-as-rav-01"; 
        $Rav[10] = "ssh c-br-go-gna-srh-rav-01"; 
        $Rav[11] = "ssh c-br-go-gna-un-rav-01"; 
        $Rav[12] = "ssh c-br-go-gna-un-rav-02"; 
        $Rav[13] = "ssh c-br-go-gna-un-rav-03"; 
        $Rav[14] = "ssh c-br-mg-bhe-fu-rav-01"; 
        $Rav[15] = "ssh c-br-mg-bhe-fu-rav-02"; 
        $Rav[16] = "ssh c-br-mg-bhe-fu-rav-03"; 
        $Rav[17] = "ssh c-br-mg-bhe-hm-rav-01"; 
        $Rav[18] = "ssh c-br-mg-bhe-lue-rav-01"; 
        $Rav[19] = "ssh c-br-mg-bhe-sag-rav-01"; 
        $Rav[20] = "ssh c-br-mg-dvl-crj-rav-01"; 
        $Rav[21] = "ssh c-br-mg-gvs-jkb-rav-01"; 
        $Rav[22] = "ssh c-br-mg-jfa-sde-rav-01"; 
        $Rav[23] = "ssh c-br-mg-jfa-sde-rav-02"; 
        $Rav[24] = "ssh c-br-mg-jfa-sde-rav-03"; 
        $Rav[25] = "ssh c-br-mg-mcl-dve-rav-01"; 
        $Rav[26] = "ssh c-br-mg-ula-ubr-rav-01"; 
        $Rav[27] = "ssh c-br-mg-vga-bbp-rav-01"; 
        $Rav[28] = "ssh c-br-pa-atm-atm-rav-01"; 
        $Rav[29] = "ssh c-br-pa-blm-pie-rav-01"; 
        $Rav[30] = "ssh c-br-pb-jpa-ep-rav-01"; 
        $Rav[31] = "ssh c-br-pr-cta-cbr-rav-01"; 
        $Rav[32] = "ssh c-br-pr-cta-cta-rav-01"; 
        $Rav[33] = "ssh c-br-pr-cta-rb-rav-01"; 
        $Rav[34] = "ssh c-br-pr-cta-vm-rav-01"; 
        $Rav[35] = "ssh c-br-pr-lda-hg-rav-01"; 
        $Rav[36] = "ssh c-br-rj-cps-cps-rav-01"; 
        $Rav[37] = "ssh c-br-rj-rjo-ed-rav-01"; 
        $Rav[38] = "ssh c-br-rj-rjo-tp-rav-02"; 
        $Rav[39] = "ssh c-br-rn-ntl-ntl-rav-01"; 
        $Rav[40] = "ssh c-br-rs-cox-cox-rav-01"; 
        $Rav[41] = "ssh c-br-rs-csl-vs-rav-01"; 
        $Rav[42] = "ssh c-br-rs-pae-bv-rav-01"; 
        $Rav[43] = "ssh c-br-rs-sma-sam-rav-01"; 
        $Rav[44] = "ssh c-br-sc-fns-cq-rav-01"; 
        $Rav[45] = "ssh c-br-sc-fns-cq-rav-02"; 
        $Rav[46] = "ssh c-br-sc-jve-sa-rav-03"; 
        $Rav[47] = "ssh c-br-se-aju-ebt-rav-01"; 
        $Rav[48] = "ssh c-br-sp-arc-xn-rav-01"; 
        $Rav[49] = "ssh c-br-sp-arc-xn-rav-02"; 
        $Rav[50] = "ssh c-br-sp-arq-ad-rav-01"; 
        $Rav[51] = "ssh c-br-sp-arq-fi-rav-01"; 
        $Rav[52] = "ssh c-br-sp-arq-fi-rav-02"; 
        $Rav[53] = "ssh c-br-sp-arq-fi-rav-03"; 
        $Rav[54] = "ssh c-br-sp-arq-fi-rav-04"; 
        $Rav[55] = "ssh c-br-sp-arq-fi-rav-05"; 
        $Rav[56] = "ssh c-br-sp-bre-al-rav-01"; 
        $Rav[57] = "ssh c-br-sp-bre-al-rav-02"; 
        $Rav[58] = "ssh c-br-sp-bre-cis-rav-01"; 
        $Rav[59] = "ssh c-br-sp-bre-cis-rav-02"; 
        $Rav[60] = "ssh c-br-sp-bru-ac-rav-01"; 
        $Rav[61] = "ssh c-br-sp-bru-ac-rav-02"; 
        $Rav[62] = "ssh c-br-sp-bru-ac-rav-03"; 
        $Rav[63] = "ssh c-br-sp-bru-ac-rav-04"; 
        $Rav[64] = "ssh c-br-sp-cas-cb-rav-01"; 
        $Rav[65] = "ssh c-br-sp-cas-ce-rav-01"; 
        $Rav[66] = "ssh c-br-sp-cas-ce-rav-02"; 
        $Rav[67] = "ssh c-br-sp-cas-ce-rav-03"; 
        $Rav[68] = "ssh c-br-sp-cas-ce-rav-04"; 
        $Rav[69] = "ssh c-br-sp-cas-ce-rav-05"; 
        $Rav[70] = "ssh c-br-sp-cas-ce-rav-06"; 
        $Rav[71] = "ssh c-br-sp-cas-ce-rav-07"; 
        $Rav[72] = "ssh c-br-sp-cas-ce-rav-08"; 
        $Rav[73] = "ssh c-br-sp-cas-ct-rav-01"; 
        $Rav[74] = "ssh c-br-sp-cas-ct-rav-02"; 
        $Rav[75] = "ssh c-br-sp-cas-ct-rav-03"; 
        $Rav[76] = "ssh c-br-sp-cas-ct-rav-04"; 
        $Rav[77] = "ssh c-br-sp-fac-pm-rav-01"; 
        $Rav[78] = "ssh c-br-sp-fac-pm-rav-02"; 
        $Rav[79] = "ssh c-br-sp-grs-gr-rav-01"; 
        $Rav[80] = "ssh c-br-sp-grs-gr-rav-02"; 
        $Rav[81] = "ssh c-br-sp-mia-ja-rav-01"; 
        $Rav[82] = "ssh c-br-sp-mia-ja-rav-02"; 
        $Rav[83] = "ssh c-br-sp-oco-os-rav-02"; 
        $Rav[84] = "ssh c-br-sp-orn-mp-rav-01"; 
        $Rav[85] = "ssh c-br-sp-paa-pi-rav-01"; 
        $Rav[86] = "ssh c-br-sp-pge-vc-rav-01"; 
        $Rav[87] = "ssh c-br-sp-ppe-rb-rav-01"; 
        $Rav[88] = "ssh c-br-sp-ppe-rb-rav-02"; 
        $Rav[89] = "ssh c-br-sp-rpo-no-rav-01"; 
        $Rav[90] = "ssh c-br-sp-rpo-no-rav-02"; 
        $Rav[91] = "ssh c-br-sp-rpo-no-rav-03"; 
        $Rav[92] = "ssh c-br-sp-sbo-pl-rav-01"; 
        $Rav[93] = "ssh c-br-sp-sjc-rh-rav-01"; 
        $Rav[94] = "ssh c-br-sp-sjc-rh-rav-02"; 
        $Rav[95] = "ssh c-br-sp-sjc-rh-rav-03"; 
        $Rav[96] = "ssh c-br-sp-sjc-rh-rav-04"; 
        $Rav[97] = "ssh c-br-sp-sne-sa-rav-01"; 
        $Rav[98] = "ssh c-br-sp-sne-sa-rav-02"; 
        $Rav[99] = "ssh c-br-sp-sne-sa-rav-03"; 
        $Rav[100] = "ssh c-br-sp-sne-sa-rav-04"; 
        $Rav[101] = "ssh c-br-sp-soc-as-rav-01"; 
        $Rav[102] = "ssh c-br-sp-soc-as-rav-02"; 
        $Rav[103] = "ssh c-br-sp-soc-cr-rav-01"; 
        $Rav[104] = "ssh c-br-sp-spb-viv-rav-01"; 
        $Rav[105] = "ssh c-br-sp-spb-viv-rav-02"; 
        $Rav[106] = "ssh c-br-sp-spo-af-rav-01"; 
        $Rav[107] = "ssh c-br-sp-spo-bb-rav-01"; 
        $Rav[108] = "ssh c-br-sp-spo-be-rav-01"; 
        $Rav[109] = "ssh c-br-sp-spo-be-rav-02"; 
        $Rav[110] = "ssh c-br-sp-spo-be-rav-03"; 
        $Rav[111] = "ssh c-br-sp-spo-cb-rav-01"; 
        $Rav[112] = "ssh c-br-sp-spo-cb-rav-02"; 
        $Rav[113] = "ssh c-br-sp-spo-cb-rav-03"; 
        $Rav[114] = "ssh c-br-sp-spo-co-rav-01"; 
        $Rav[115] = "ssh c-br-sp-spo-co-rav-02"; 
        $Rav[116] = "ssh c-br-sp-spo-co-rav-03"; 
        $Rav[117] = "ssh c-br-sp-spo-co-rav-04"; 
        $Rav[118] = "ssh c-br-sp-spo-co-rav-05"; 
        $Rav[119] = "ssh c-br-sp-spo-co-rav-06"; 
        $Rav[120] = "ssh c-br-sp-spo-co-rav-07"; 
        $Rav[121] = "ssh c-br-sp-spo-co-rav-08"; 
        $Rav[122] = "ssh c-br-sp-spo-co-rav-09"; 
        $Rav[123] = "ssh c-br-sp-spo-ctp-rav-01"; 
        $Rav[124] = "ssh c-br-sp-spo-fd-rav-01"; 
        $Rav[125] = "ssh c-br-sp-spo-gu-rav-01"; 
        $Rav[126] = "ssh c-br-sp-spo-ib-rav-01"; 
        $Rav[127] = "ssh c-br-sp-spo-ib-rav-02"; 
        $Rav[128] = "ssh c-br-sp-spo-ib-rav-03"; 
        $Rav[129] = "ssh c-br-sp-spo-ib-rav-04"; 
        $Rav[130] = "ssh c-br-sp-spo-ib-rav-05"; 
        $Rav[131] = "ssh c-br-sp-spo-ib-rav-06"; 
        $Rav[132] = "ssh c-br-sp-spo-ib-rav-07"; 
        $Rav[133] = "ssh c-br-sp-spo-ib-rav-08"; 
        $Rav[134] = "ssh c-br-sp-spo-ib-rav-09"; 
        $Rav[135] = "ssh c-br-sp-spo-jd-rav-01"; 
        $Rav[136] = "ssh c-br-sp-spo-jg-rav-01"; 
        $Rav[137] = "ssh c-br-sp-spo-jg-rav-02"; 
        $Rav[138] = "ssh c-br-sp-spo-jg-rav-03"; 
        $Rav[139] = "ssh c-br-sp-spo-jg-rav-04"; 
        $Rav[140] = "ssh c-br-sp-spo-li-rav-01"; 
        $Rav[141] = "ssh c-br-sp-spo-li-rav-02"; 
        $Rav[142] = "ssh c-br-sp-spo-mb-rav-01"; 
        $Rav[143] = "ssh c-br-sp-spo-mb-rav-02"; 
        $Rav[144] = "ssh c-br-sp-spo-mb-rav-03"; 
        $Rav[145] = "ssh c-br-sp-spo-mb-rav-04"; 
        $Rav[146] = "ssh c-br-sp-spo-mb-rav-05"; 
        $Rav[147] = "ssh c-br-sp-spo-nu-rav-01"; 
        $Rav[148] = "ssh c-br-sp-spo-pa-rav-01"; 
        $Rav[149] = "ssh c-br-sp-spo-pa-rav-02"; 
        $Rav[150] = "ssh c-br-sp-spo-pd-rav-01"; 
        $Rav[151] = "ssh c-br-sp-spo-pd-rav-02"; 
        $Rav[152] = "ssh c-br-sp-spo-pd-rav-03"; 
        $Rav[153] = "ssh c-br-sp-spo-pd-rav-04"; 
        $Rav[154] = "ssh c-br-sp-spo-pd-rav-05"; 
        $Rav[155] = "ssh c-br-sp-spo-pd-rav-06"; 
        $Rav[156] = "ssh c-br-sp-spo-pe-rav-01"; 
        $Rav[157] = "ssh c-br-sp-spo-pe-rav-02"; 
        $Rav[158] = "ssh c-br-sp-spo-pe-rav-03"; 
        $Rav[159] = "ssh c-br-sp-spo-pe-rav-04"; 
        $Rav[160] = "ssh c-br-sp-spo-pz-rav-01"; 
        $Rav[161] = "ssh c-br-sp-spo-sfr-rav-01"; 
        $Rav[162] = "ssh c-br-sp-spo-sfr-rav-02"; 
        $Rav[163] = "ssh c-br-sp-spo-si-rav-01"; 
        $Rav[164] = "ssh c-br-sp-spo-si-rav-02"; 
        $Rav[165] = "ssh c-br-sp-spo-si-rav-03"; 
        $Rav[166] = "ssh c-br-sp-spo-si-rav-04"; 
        $Rav[167] = "ssh c-br-sp-spo-vm-rav-01"; 
        $Rav[168] = "ssh c-br-sp-spo-vm-rav-02"; 
        $Rav[169] = "ssh c-br-sp-spo-vm-rav-03"; 
        $Rav[170] = "ssh c-br-sp-spo-vm-rav-04"; 
        $Rav[171] = "ssh c-br-sp-spo-vm-rav-05"; 
        $Rav[172] = "ssh c-br-sp-spo-vm-rav-06"; 
        $Rav[173] = "ssh c-br-sp-spo-vu-rav-01"; 
        $Rav[174] = "ssh c-br-sp-spo-vu-rav-02"; 
        $Rav[175] = "ssh c-br-sp-spo-vu-rav-03"; 
        $Rav[176] = "ssh c-br-sp-srr-vs-rav-01"; 
        $Rav[177] = "ssh c-br-sp-srr-vs-rav-02"; 
        $Rav[178] = "ssh c-br-sp-sts-wl-rav-01"; 
        $Rav[179] = "ssh c-br-sp-sts-wl-rav-02"; 
        $Rav[180] = "ssh c-br-sp-sts-wl-rav-03"; 
        $Rav[181] = "ssh c-br-sp-sts-wl-rav-04"; 
        $Rav[182] = "ssh c-br-sp-tbs-pro-rav-01"; 
        $Rav[183] = "ssh c-br-sp-tbs-pro-rav-02"; 
        $Rav[184] = "ssh c-br-sp-tte-am-rav-01"; 
        $Rav[185] = "ssh c-br-sp-tte-am-rav-02"; 
        $Rav[186] = "ssh i-br-al-mco-mco-rav-01"; 
        $Rav[187] = "ssh i-br-am-mns-afp-rav-02"; 
        $Rav[188] = "ssh i-br-ba-sdr-cb-rav-04"; 
        $Rav[189] = "ssh i-br-ba-sdr-vg-rav-01"; 
        $Rav[190] = "ssh i-br-ba-vca-rq-rav-01"; 
        $Rav[191] = "ssh i-br-ce-fla-ad-rav-03"; 
        $Rav[192] = "ssh i-br-es-vta-bf-rav-01"; 
        $Rav[193] = "ssh i-br-ma-sls-sfr-rav-02"; 
        $Rav[194] = "ssh i-br-mg-ula-li-rav-01"; 
        $Rav[195] = "ssh i-br-ms-cpe-pl-rav-03"; 
        $Rav[196] = "ssh i-br-pa-blm-ccp-rav-01"; 
        $Rav[197] = "ssh i-br-pe-rce-ir-rav-02"; 
        $Rav[198] = "ssh i-br-pe-rce-ir-rav-03"; 
        $Rav[199] = "ssh i-br-pe-rce-ln-rav-01"; 
        $Rav[200] = "ssh i-br-pi-tsa-tsa-rav-02"; 
        $Rav[201] = "ssh i-br-rj-nri-nit-rav-01"; 
        $Rav[202] = "ssh i-br-rj-nri-nit-rav-02"; 
        $Rav[203] = "ssh i-br-rj-rjo-bar-rav-01"; 
        $Rav[204] = "ssh i-br-ro-pvo-get-rav-01"; 
        $Rav[205] = "ssh i-br-rs-pae-ip-rav-01"; 
        $Rav[206] = "ssh i-br-sc-bnu-bnu-rav-01"; 
        $Rav[207] = "ssh i-br-sc-lgs-lgs-rav-01"; 
        $Rav[208] = "ssh i-br-sc-soo-fns-rav-01"; 
        $Rav[209] = "ssh i-br-sc-soo-fns-rav-02"; 
        $Rav[210] = "ssh i-br-sp-bru-ac-rav-07"; 
        $Rav[211] = "ssh i-br-sp-cas-ce-rav-09"; 
        $Rav[212] = "ssh i-br-sp-cas-ct-rav-05"; 
        $Rav[213] = "ssh i-br-sp-sbo-pl-rav-02"; 
        $Rav[214] = "ssh i-br-sp-sjc-rh-rav-05"; 
        $Rav[215] = "ssh i-br-sp-sne-sa-rav-05"; 
        $Rav[216] = "ssh i-br-sp-spo-am-rav-01"; 
        $Rav[217] = "ssh i-br-sp-spo-mrb-rav-06"; 
        $Rav[218] = "ssh i-br-sp-spo-pe-rav-05"; 
        $Rav[219] = "ssh i-br-sp-spo-vu-rav-04"; 
        $Rav[220] = "ssh i-br-sp-sts-wl-rav-05"; 
        $Rav[221] = "ssh i-br-to-pmj-pmj-rav-01"; 
        $Rav[222] = "ssh i-br-to-pmj-pmj-rav-02"; 
        
        $Rav[999] = 'Con@$f!g27';
        $Rav[1000] = 223;

        return $Rav;

    }

    


} // Class