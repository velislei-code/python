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

 

define("_CtgLinScript", 600); // Contagem num.elem.vetor
define("_LinDcfScript", 1000); // Contagem num.elem.vetor - Linhas da Desconfigurcao
define("_CtgLinDcfScript", 1100); // Contagem num.elem.vetor - Total de linhas de desconfig

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
define("_VV", 'Aten@a1*07'); //<- 6fev25, Aten@a0*17 <- 8Nov24, 'Fun@a0*101'; //'Con@$f!g27';  
define("_SwaAdm", 'd4t4c0m#$%'); 
define("_SwaSuporte", 'sup0rt3_m3tr0'); 
define("_SwaOperB2b", '7q1iK3F0R'); 


class Script {


			
    function Cisco($Modelo, $ID, $Empresa, $OPER, $Port, $Speed, $PolicyIN, $PolicyOUT, $Vrf, $sVlan, $cVlan, $Lan, $Wan, $Loopback, $LanIpv6, $WanIpv6)
    {
        $Lin[] = "";
                
        $Empresa = str_replace(' ', '_', $Empresa);
        $Bandwidth = $this->SpeedToBandwidth($Speed);

        if(!empty($Wan)){            
            $WanLocal = $this->IpToRota($Wan);
            $WanRota = $this->IpToRota($WanLocal);
            $WanIpv6Rota = $this->IpToRota($WanIpv6);
        }else{
            $WanLocal = '0.0.0.0';
            $WanRota = '0.0.0.0';
            $WanIpv6Rota = '0000:0000:0000:0000:0000:0000';
        }    
        // Script de config
        if($Modelo == 'ASR9K'){
            $Lin[0] = "config exclusive";
            $Lin[1] = "interface ".$Port.".".$sVlan.$cVlan;
            $Lin[2] = "interface ".$Port.".".$sVlan.$cVlan." description ".$Port.".".$sVlan.$cVlan." dot1q vlan id=".$sVlan.". By VPNSC: Job Id# = xxxxxx (".$Empresa."_".$ID."_".$OPER.")";
            $Lin[3] = "interface ".$Port.".".$sVlan.$cVlan." service-policy input ".$PolicyIN;
            $Lin[4] = "interface ".$Port.".".$sVlan.$cVlan." service-policy output ".$PolicyOUT;
            $Lin[5] = "interface ".$Port.".".$sVlan.$cVlan." ipv4 address ".$WanLocal." 255.255.255.252";
            $Lin[6] = "interface ".$Port.".".$sVlan.$cVlan." encapsulation dot1q ".$sVlan." second-dot1q ".$cVlan;
            $Lin[7] = "interface ".$Port.".".$sVlan.$cVlan." ipv6 address ".$WanIpv6."/127";
            $Lin[8] = "interface ".$Port.".".$sVlan.$cVlan." ipv6 unreachables disable";
            $Lin[9] = "router static address-family ipv4 unicast ".$Loopback."/32 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
            $Lin[10] = "router static address-family ipv4 unicast ".$Lan."/29 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
            $Lin[11] = "router static address-family ipv6 unicast ".$LanIpv6."/56 ".$Port.".".$sVlan.$cVlan." ".$WanIpv6Rota;
            $Lin[12] = "!";
            $Lin[13] = "commit";
            $Lin[14] = "!";
            $Lin[15] = "exit";
            $Lin[16] = "!";

            // Total lin no script
            $Lin[_CtgLinScript] = 17;  
            
            
            // Desconfiguracao(script)
            $Lin[1000] = "config exclusive";
            $Lin[1001] = "no interface ".$Port.".".$sVlan.$cVlan;
            $Lin[1002] = "no router static address-family ipv4 unicast ".$Loopback."/32 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
            $Lin[1003] = "no router static address-family ipv4 unicast ".$Lan."/29 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
            $Lin[1004] = "no router static address-family ipv6 unicast ".$LanIpv6."/56 ".$Port.".".$sVlan.$cVlan." ".$WanIpv6Rota;
            $Lin[1005] = "!";
            $Lin[1006] = "commit";
            $Lin[1007] = "!";
            $Lin[1008] = "exit";
            $Lin[1009] = "!";

            $Lin[_CtgLinDcfScript] = 10;                   
         
        }else if($Modelo == 'IOS_XR'){
            // Cisco IOS XR 
            $Lin[0] = "config exclusive";
            $Lin[1] = "interface  ".$Port.".".$sVlan.$cVlan; 
            $Lin[1] = "interface  ".$Port.".".$sVlan.$cVlan." bandwidth ".$Bandwidth; 
            $Lin[2] = "interface  ".$Port.".".$sVlan.$cVlan." description ".$Port.".".$sVlan.$cVlan." dot1q vlan id=".$sVlan.". (".$Empresa."_".$ID."_".$OPER.")";
            $Lin[3] = "interface  ".$Port.".".$sVlan.$cVlan." service-policy input ".$PolicyIN;
            $Lin[4] = "interface  ".$Port.".".$sVlan.$cVlan." service-policy output ".$PolicyOUT;
            $Lin[5] = "interface  ".$Port.".".$sVlan.$cVlan." ipv4 address ".$WanLocal." 255.255.255.252";
            $Lin[6] = "interface  ".$Port.".".$sVlan.$cVlan." ipv4 verify unicast source reachable-via any";
            $Lin[7] = "interface  ".$Port.".".$sVlan.$cVlan." ipv6 verify unicast source reachable-via any";
            $Lin[8] = "interface  ".$Port.".".$sVlan.$cVlan." ipv6 address ".$WanIpv6."/127";
            $Lin[9] = "interface  ".$Port.".".$sVlan.$cVlan." flow ipv4 monitor MONITOR-V4 sampler SAMPLER-1-OUT-1000 ingress";
            $Lin[10] = "interface  ".$Port.".".$sVlan.$cVlan." flow ipv6 monitor MONITOR-V6 sampler SAMPLER-1-OUT-1000 ingress";
            $Lin[11] = "interface  ".$Port.".".$sVlan.$cVlan." encapsulation dot1q ".$sVlan." second-dot1q ".$cVlan; 
            $Lin[12] = "interface  ".$Port.".".$sVlan.$cVlan." ipv4 access-group iACL-SECURITY-IN-IPv4 ingress";
            $Lin[13] = "interface  ".$Port.".".$sVlan.$cVlan." ipv6 access-group iACL-SECURITY-IN-IPv6 ingress";
            $Lin[14] = "router static address-family ipv4 unicast ".$Loopback."/32 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
            $Lin[15] = "router static address-family ipv4 unicast ".$Lan."/29 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
            $Lin[16] = "router static address-family ipv6 unicast ".$LanIpv6."/56 ".$Port.".".$sVlan.$cVlan." ".$WanIpv6Rota;
            $Lin[17] = "!";
            $Lin[18] = "commit";
            $Lin[19] = "!";
            $Lin[20] = "exit";
            $Lin[21] = "!";

            // Total lin no script
            $Lin[_CtgLinScript] = 22;

            // Desconfiguracao(script)
            $Lin[1000] = "config exclusive";
            $Lin[1001] = "no interface  ".$Port.".".$sVlan.$cVlan; 
            $Lin[1002] = "no router static address-family ipv4 unicast ".$Loopback."/32 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
            $Lin[1003] = "no router static address-family ipv4 unicast ".$Lan."/29 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
            $Lin[1004] = "no router static address-family ipv6 unicast ".$LanIpv6."/56 ".$Port.".".$sVlan.$cVlan." ".$WanIpv6Rota;
            $Lin[1005] = "!";
            $Lin[1006] = "commit";
            $Lin[1007] = "!";
            $Lin[1008] = "exit";
            $Lin[1009] = "!";

            $Lin[_CtgLinDcfScript] = 10;      
        }
        
        
        if($Modelo == 'VRF_ASR9K'){
            if($Vrf == ''){ $Vrf = '<Vrf_Name>'; }

            $Lin[0] = "edit prefix-set pfx_".$Vrf."_VPNSC_GREY_MGMT inline add ".$Loopback."/32";
            $Lin[1] = "edit prefix-set pfx_".$Vrf."_VPNSC_GREY_MGMT inline add ".$Wan."/30"; //  (WAN0-rede)	";
            $Lin[2] = "!";
            $Lin[3] = "config e";            
            $Lin[4] = "interface ".$Port.".".$sVlan.$cVlan." description ".$Port.".".$sVlan.$cVlan." dot1q vlan id=".$sVlan.". By VPNSC: Job Id# = XXXXXX (".$Empresa."_".$ID."_".$OPER.")";
            $Lin[5] = "interface ".$Port.".".$sVlan.$cVlan." bandwidth ".$Bandwidth;
            $Lin[6] = "interface ".$Port.".".$sVlan.$cVlan." service-policy output ".$PolicyOUT;
            $Lin[7] = "interface ".$Port.".".$sVlan.$cVlan." vrf ".$Vrf;
            $Lin[8] = "interface ".$Port.".".$sVlan.$cVlan." ipv4 address ".$WanLocal." 255.255.255.252";
            $Lin[9] = "interface ".$Port.".".$sVlan.$cVlan." ipv6 address ".$WanIpv6."/127";
            $Lin[10] = "interface ".$Port.".".$sVlan.$cVlan." encapsulation dot1q ".$sVlan." second-dot1q ".$cVlan;
            $Lin[11] = "!";
            $Lin[12] = "!";
            //$Lin[12] = "router static vrf ".$Vrf." address-family ipv4 unicast ".$Lan."/29 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
            $Lin[13] = "router static vrf ".$Vrf." address-family ipv4 unicast ".$Loopback."/32 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
            $Lin[14] = "!";
            //$Lin[15] = "!";
            $Lin[15] = "router bgp 10429";
            $Lin[16] = " vrf ".$Vrf;
            $Lin[17] = "  neighbor ".$WanRota;
            $Lin[18] = "   remote-as 65001";
            $Lin[19] = "   address-family ipv4 unicast";
            $Lin[20] = "    route-policy IscDefaultPassAll in";
            $Lin[21] = "    route-policy IscDefaultPassAll out";
            $Lin[22] = "    as-override";
            $Lin[23] = "   !";
            $Lin[24] = "   exit";
            $Lin[25] = "   !";
            $Lin[26] = "  exit";
            $Lin[27] = "  !";
            $Lin[28] = " exit";
            $Lin[29] = " !";
            $Lin[30] = "exit";
            $Lin[31] = "!";

            // Total lin no script
            $Lin[_CtgLinScript] = 32;


            // Desconfiguracao(script)
            $Lin[1000] = "no edit prefix-set pfx_".$Vrf."_VPNSC_GREY_MGMT inline add ".$Loopback."/32";
            $Lin[1001] = "no edit prefix-set pfx_".$Vrf."_VPNSC_GREY_MGMT inline add ".$Wan."/30"; //  (WAN0-rede)	";
            $Lin[1002] = "!";
            $Lin[1003] = "config e";            
            $Lin[1004] = "no interface ".$Port.".".$sVlan.$cVlan;
            $Lin[1005] = "no router static vrf ".$Vrf." address-family ipv4 unicast ".$Lan."/29 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
            $Lin[1006] = "no router static vrf ".$Vrf." address-family ipv4 unicast ".$Loopback."/32 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
            $Lin[1007] = "!";          
            $Lin[1008] = "router bgp 10429";
            $Lin[1009] = " vrf ".$Vrf;
            $Lin[1010] = "  no neighbor ".$WanRota;
            $Lin[1011] = "   !";
            $Lin[1012] = "   exit";
            $Lin[1013] = "   !";
            $Lin[1014] = "  exit";
            $Lin[1015] = "  !";
            $Lin[1016] = "  commit";
            $Lin[1017] = "  exit";
            $Lin[1018] = "  !";
          
            
            $Lin[_CtgLinDcfScript] = 19;      

            // Checks de VRF
            $Lin[200] = "sh run vrf ".$Vrf;
            $Lin[201] = "sh run grey_mgmt_vpn_Telefonica_Empresas_".$Vrf;
            $Lin[202] = "sh run prefix-set pfx_".$Vrf."_VPNSC_GREY_MGMT";
            $Lin[203] = "sh run router bgp 10429 vrf ".$Vrf;
            $Lin[204] = "     remote-as 65001  <<- Dentro do BGP, ver se esta livre (Greici)VPN segue normal, tira o unreachables disable ";


        }else if($Modelo == 'VRF_IOS-XE'){
            
            if($Vrf == ''){ $Vrf = '<Vrf_Name>'; }

            $Lin[0] = "conf ter";
            $Lin[1] = "ip access-list extended ".$Vrf."_VPNSC_GREY_MGMT_ACL";
            $Lin[2] = "   permit ip ".$Wan." 0.0.0.3 any";
            $Lin[3] = "	permit ip ".$Loopback." 0.0.0.3 any";
            $Lin[4] = "	exit";
            $Lin[5] = "	!";
            $Lin[6] = "!";
            $Lin[7] = "interface ".$Port.".".$sVlan.$cVlan;
            $Lin[8] = " bandwidth ".$Bandwidth;
            $Lin[9] = " no shutdown";
            $Lin[10] = " description ".$Port.".".$sVlan.$cVlan." dot1q vlan id=".$sVlan.". By VPNSC: Job Id# = XXXXXX (".$Empresa."_".$ID."_".$OPER.")";
            $Lin[11] = " service-policy output ".$PolicyOUT;
            $Lin[12] = " encapsulation dot1Q ".$sVlan." second-dot1q ".$cVlan;
            $Lin[13] = " ip vrf forwarding ".$Vrf;
            $Lin[14] = " ip address ".$WanLocal." 255.255.255.252";
            $Lin[15] = "exit";
            $Lin[16] = "!";
            $Lin[17] = "ip route vrf ".$Vrf." ".$Loopback." 255.255.255.255 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
            $Lin[18] = "!";
            $Lin[19] = "router bgp 10429	";
            $Lin[20] = " address-family ipv4 vrf ".$Vrf;
            $Lin[21] = "	neighbor ".$WanRota." remote-as 65001	";
            $Lin[22] = "	neighbor ".$WanRota." activate	";
            $Lin[23] = "	neighbor ".$WanRota." as-override	";
            $Lin[24] = "	exit-address-family	";
            $Lin[25] = "!";
            $Lin[26] = "exit";
            $Lin[27] = "!";
            $Lin[28] = "exit";
            $Lin[29] = "!";
            $Lin[30] = "wr";
    
            // Total lin no script
            $Lin[_CtgLinScript] = 31;

            // Desconfiguracao(script)
            $Lin[1000] = "conf ter";
            $Lin[1001] = "ip access-list extended ".$Vrf."_VPNSC_GREY_MGMT_ACL";
            $Lin[1002] = "   no permit ip ".$Wan." 0.0.0.3 any";
            $Lin[1003] = "	no permit ip ".$Loopback." 0.0.0.3 any";
            $Lin[1004] = "	exit";
            $Lin[1005] = "	!";
            $Lin[1006] = "!";
            $Lin[1007] = "no interface ".$Port.".".$sVlan.$cVlan;
            $Lin[1008] = "!";
            $Lin[1009] = "no ip route vrf ".$Vrf." ".$Loopback." 255.255.255.255 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
            $Lin[1010] = "!";
            $Lin[1011] = "router bgp 10429	";
            $Lin[1012] = " address-family ipv4 vrf ".$Vrf;
            $Lin[1013] = "	no neighbor ".$WanRota." remote-as 65001	";
            $Lin[1014] = "	no neighbor ".$WanRota." activate	";
            $Lin[1015] = "	no neighbor ".$WanRota." as-override	";
            $Lin[1016] = "	!";
            $Lin[1017] = "	exit";
            $Lin[1018] = "	!";
            $Lin[1019] = "	exit";
            $Lin[1020] = "	!";
            $Lin[1021] = "	wr";
            $Lin[1022] = "	!";

            $Lin[_CtgLinDcfScript] = 23;  

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
                
            $Lin[200] = " WAN: ................... -> ".$WanLocal." /30";            
            $Lin[201] = " LAN: ".$Lan." /29 -> ".$WanRota;            
            $Lin[202] = "  Lo: ".$Loopback." /32 -> ".$WanRota;            
            $Lin[203] = "WAN6: ......................... -> ".$WanIpv6." /127"; 
            if( $this->checkIP($WanIpv6) == 'F'){ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota." <<- Confirme Calc(F+1) rota IPv6";  } 
            else if( $this->checkIP($WanIpv6) == '9'){ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota." <<- Confirme Calc(9+1) rota IPv6"; }  
            else{ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota;  }

        }
                    
        // Verifica antes da config
        $Lin[100] = "sh conf | inc ".$Speed."M"; // Profile
        $Lin[101] = "sh conf run formal | inc ".$Speed."M"; // Profile
        $Lin[102] = "sh conf run formal | inc ".$ID; // Profile
        $Lin[103] = "show commit changes diff"; // Profile
        //$Lin[103] = "show config fail"; // Se porta esta livre
        $Lin[104] = "sh run int ".$Port.".".$sVlan.$cVlan;        
        $Lin[105] = "sh conf run int ".$Port.".".$sVlan.$cVlan;        
        $Lin[106] = "sh conf run formal | inc ".$Port.".".$sVlan.$cVlan;
        $Lin[107] = "sh int ".$Port.".".$sVlan.$cVlan;
        
        $Lin[108] = "VPN(ASR9K):";
        $Lin[109] = "sh run vrf ".$Vrf;
        $Lin[110] = "sh run route-policy grey_mgmt_vpn_Telefonica_Empresas_".$Vrf;
        $Lin[111] = "sh run prefix-set  pfx_".$Vrf."_VPNSC_GREY_MGMT";
        $Lin[112] = "sh run route static vrf ".$Vrf;
        $Lin[113] = "sh run router bgp 10429 vrf ".$Vrf;
        
        $Lin[114] = "VPN(IOS-XE):";
        $Lin[115] = "sh conf | inc ".$Vrf;
        $Lin[116] = "sh run int ".$Port.".".$sVlan.$cVlan;
        $Lin[117] = "sh conf | inc ".$WanRota;
        $Lin[118] = "sh conf | inc ".$Loopback;
        $Lin[119] = "sh vrf ".$Vrf;
        $Lin[120] = "sh int ".$Port.".".$sVlan.$cVlan;
        
        $Lin[121] = "Tunnel(MPLS):";
        $Lin[122] = "sh conf run formal | inc ".$sVlan;
        $Lin[123] = "sh l2vpn xconnect group PW-ACESSO-L3VPN";
        $Lin[124] = "sh l2vpn xconnect interface ".$Port.".".$sVlan;
      
        $Lin[_CtgCmdRouters] = 25; // Contagem dos Cmds      
    
        return ($Lin);	

    }


    function Huawei($Modelo, $ID, $Empresa, $OPER, $Port, $Speed, $ctrlVid, $PolicyIN, $PolicyOUT, $sVlan, $cVlan, $Lan, $Wan, $Loopback, $LanIpv6, $WanIpv6)
    {
        $Lin[] = "";
                
        $Empresa = str_replace(' ', '_', $Empresa);
        $Bandwidth = $this->SpeedToBandwidth($Speed);

        if(!empty($Wan)){
            
            $WanLocal = $this->IpToRota($Wan);
            $WanRota = $this->IpToRota($WanLocal);
            $WanIpv6Rota = $this->IpToRota($WanIpv6);
        }else{
            $WanLocal = '0.0.0.0';
            $WanRota = '0.0.0.0';
            $WanIpv6Rota = '0000:0000:0000:0000:0000:0000';
        }    

        if($Modelo == 'NE40E_X8A'){
            $Lin[0] = "sys";
            $Lin[1] = "interface ".$Port.".".$sVlan.$cVlan;
            $Lin[2] = "bandwidth ".$Bandwidth;
            $Lin[3] = "description ".$Port.".".$sVlan.$cVlan." dot1q vlan id=".$sVlan.". By VPNSC: Job Id# = xxxxxx (".$Empresa."_".$ID."_".$OPER.")";
            $Lin[4] = "control-vid ".$ctrlVid." qinq-termination";
            $Lin[5] = "qinq termination pe-vid ".$sVlan." ce-vid ".$cVlan;
            $Lin[6] = "ip address ".$WanLocal." 255.255.255.252";
            $Lin[7] = "ipv6 enable";
            $Lin[8] = "ipv6 address ".$WanIpv6."/127";      
            $Lin[9] = "traffic-policy ".$PolicyIN." inbound";
            $Lin[10] = "traffic-policy ".$PolicyOUT." outbound";
            $Lin[11] = "!";
            $Lin[12] = "ip route-static ".$Loopback." 255.255.255.255 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
            $Lin[13] = "ip route-static ".$Lan." 255.255.255.248 ".$Port.".".$sVlan.$cVlan." ".$WanRota;
            $Lin[14] = "ipv6 route-static ".$LanIpv6." 56 ".$Port.".".$sVlan.$cVlan." ".$WanIpv6Rota;       
            $Lin[15] = "!";  
            $Lin[16] = "quit";  
            $Lin[17] = "!";  
            $Lin[18] = "save";  
            $Lin[19] = "!";  
            $Lin[20] = "Y";  

            $Lin[_CtgLinScript] = 21;

        }else if($Modelo == 'NE40E_X8'){
            $Lin[0] = "sys";
            $Lin[1] = "interface ".$Port.".".$sVlan.$cVlan;
            $Lin[2] = "description ".$Port.".".$sVlan.$cVlan." dot1q vlan id=".$sVlan.". By VPNSC: Job Id# = XXXXXX (".$Empresa."_".$ID."_".$OPER.")";
            $Lin[3] = "ipv6 enable";
            $Lin[4] = "ip address ".$WanLocal." 255.255.255.252";
            $Lin[5] = "ipv6 address ".$WanIpv6."/127";
            $Lin[6] = "statistic enable";
            $Lin[7] = "encapsulation qinq-termination";
            $Lin[8] = "traffic-policy ".$PolicyIN." inbound";
            $Lin[9] = "traffic-policy ".$PolicyOUT." outbound";
            $Lin[10] = "qinq termination pe-vid ".$sVlan." ce-vid ".$cVlan;
            $Lin[11] = "arp broadcast enable";
            $Lin[12] = "!";
            $Lin[13] = "ip route-static ".$Loopback." 255.255.255.255 ".$Port.".".$sVlan.$cVlan." ".$WanRota." tag ".$ctrlVid." description ".$Empresa."_".$ID;
            $Lin[14] = "ip route-static ".$Lan." 255.255.255.248 ".$Port.".".$sVlan.$cVlan." ".$WanRota." tag ".$ctrlVid." description ".$Empresa."_".$ID;
            $Lin[15] = "ipv6 route-static ".$LanIpv6." 56 ".$Port.".".$sVlan.$cVlan." ".$WanIpv6Rota." tag ".$ctrlVid." description ".$Empresa."_".$ID;
            $Lin[16] = "!";
            $Lin[17] = "commit";
            $Lin[18] = "!";

            $Lin[_CtgLinScript] = 19;
        }

         // Script Preview        
         // Ajusta tamanho da LAN e Lo, para padrao
         while(strlen($Lan) != _TamIP){ $Lan = $Lan.' ';  }       
         while(strlen($Loopback) != _TamIP){ $Loopback = $Loopback.' ';  }       
               
         $Lin[200] = " WAN: ................... -> ".$WanLocal." /30";            
         $Lin[201] = " LAN: ".$Lan." /29 -> ".$WanRota;            
         $Lin[202] = "  Lo: ".$Loopback." /32 -> ".$WanRota;            
         $Lin[203] = "WAN6: ......................... -> ".$WanIpv6." /127"; 
         if( $this->checkIP($WanIpv6) == 'F'){ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota." <<- Confirme Calc(F+1) rota IPv6";  } 
         else if( $this->checkIP($WanIpv6) == '9'){ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota." <<- Confirme Calc(9+1) rota IPv6"; }  
         else{ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota;  }
     

         // Verifica antes da config
         $FinalLanIpv6 = substr($LanIpv6, -5);
         $VidUnit = '7'.substr($cVlan, -2);
         $Lin[100] = "disp cur | inc control-vid ".$VidUnit; // Profile
         $Lin[101] = "disp cur | inc ".$Speed."M"; // Profile
         $Lin[102] = "disp cur | inc ".$Port.".".$sVlan.$cVlan; // Se porta esta livre      
         $Lin[103] = "disp cur interface ".$Port.".".$sVlan.$cVlan;
         $Lin[104] = "disp cur | inc ".$WanRota;
         $Lin[105] = "disp cur | inc ".$FinalLanIpv6;         
         $Lin[106] = "display interface ".$Port.".".$sVlan.$cVlan;
         $Lin[107] = "Tunnel(MPLS):";
         $Lin[108] = "disp cur interface ".$Port.".".$sVlan;
         $Lin[109] = "disp mpls l2vc";
         $Lin[110] = "disp mpls l2vc interface ".$Port.".".$sVlan;
       
        
         $Lin[_CtgCmdRouters] = 11;
    
        return ($Lin);	

    }
    
    function Juniper($Modelo, $ID, $Empresa, $OPER, $Port, $Speed, $Unit, $PolicyIN, $PolicyOUT, $sVlan, $cVlan, $Lan, $Wan, $Loopback, $LanIpv6, $WanIpv6)
    {
        $Lin[] = "";
                
        $Empresa = str_replace(' ', '_', $Empresa);

        if(!empty($Wan)){
            
            $WanLocal = $this->IpToRota($Wan);
            $WanRota = $this->IpToRota($WanLocal);
            $WanIpv6Rota = $this->IpToRota($WanIpv6);
        }else{
            $WanLocal = '0.0.0.0';
            $WanRota = '0.0.0.0';
            $WanIpv6Rota = '0000:0000:0000:0000:0000:0000';
        }    

        $Lin[0] = 'edit private';
        $Lin[1] = 'set interfaces '.$Port.' unit '.$Unit.' description "'.$Port.'.'.$Unit.' dot1q vlan id='.$sVlan.'. By VENSC: Job Id# = XXXX ('.$Empresa.'_ID_'.$ID.'_ERB)"';
        $Lin[2] = 'set interfaces '.$Port.' unit '.$Unit.' vlan-tags outer '.$sVlan;
        $Lin[3] = 'set interfaces '.$Port.' unit '.$Unit.' vlan-tags inner '.$cVlan;
        $Lin[4] = 'set interfaces '.$Port.' unit '.$Unit.' family inet rpf-check';
        $Lin[5] = 'set interfaces '.$Port.' unit '.$Unit.' family inet address '.$WanLocal.'/30';
        $Lin[6] = 'set interfaces '.$Port.' unit '.$Unit.' family inet6 address '.$WanIpv6.'/127';
        $Lin[7] = 'set interfaces '.$Port.' unit '.$Unit.' family inet policer input '.$PolicyIN;
        $Lin[8] = 'set interfaces '.$Port.' unit '.$Unit.' family inet policer output '.$PolicyOUT;
        $Lin[9] = 'set routing-options static route '.$Loopback.'/32 qualified-next-hop '.$WanRota;
        $Lin[10] = 'set routing-options static route '.$Lan.'/29 qualified-next-hop '.$WanRota;
        $Lin[11] = 'set routing-options rib inet6.0 static route '.$LanIpv6.'/56 next-hop '.$WanIpv6Rota;
        $Lin[12] = 'commit';
        $Lin[13] = 'exit';

        $Lin[_CtgLinScript] = 14;  // Total de linhas


        // Script Preview        
         // Ajusta tamanho da LAN e Lo, para padrao
         while(strlen($Lan) != _TamIP){ $Lan = $Lan.' ';  }       
         while(strlen($Loopback) != _TamIP){ $Loopback = $Loopback.' ';  }       
               
         $Lin[200] = " WAN: ................... -> ".$WanLocal." /30";            
         $Lin[201] = " LAN: ".$Lan." /29 -> ".$WanRota;            
         $Lin[202] = "  Lo: ".$Loopback." /32 -> ".$WanRota;            
         $Lin[203] = "WAN6: ......................... -> ".$WanIpv6." /127"; 
         if( $this->checkIP($WanIpv6) == 'F'){ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota." <<- Confirme Calc(F+1) rota IPv6";  } 
         else if( $this->checkIP($WanIpv6) == '9'){ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota." <<- Confirme Calc(9+1) rota IPv6"; }  
         else{ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota;  }
     

         // Verifica antes da config
         $FimWanIpv6Rota = substr($WanIpv6Rota, -5);
         $Lin[100] = 'show configuration | match '.$Port.' | display set';
         $Lin[101] = 'show configuration interfaces '.$Port.' unit '.$Unit; // Profile 
         $Lin[102] = ''; 
         $Lin[103] = 'show configuration interfaces '.$Port.'.'.$Unit.' | display set';           
         $Lin[104] = 'show configuration | match '.$WanRota.' | display set'; 
         $Lin[105] = 'show configuration | match '.$FimWanIpv6Rota.' | display set'; 
         $Lin[106] = 'show interfaces terse '.$Port.'.'.$Unit; 
              
         
         $Lin[_CtgCmdRouters] = 7;
    
        return ($Lin);	

    }

    function Nokia($Modelo, $ID, $Empresa, $OPER, $Port, $Speed, $sVlan, $cVlan, $Lan, $Wan, $Loopback, $LanIpv6, $WanIpv6)
    {
        $Lin[] = "";
                
        $Empresa = str_replace(' ', '_', $Empresa);
        $Port = strtolower($Port); // converte: 2/1/C8/2 -> 2/1/c8/2 

        if(!empty($Wan)){
            
            $WanLocal = $this->IpToRota($Wan);
            $WanRota = $this->IpToRota($WanLocal);
            $WanIpv6Rota = $this->IpToRota($WanIpv6);
        }else{
            $WanLocal = '0.0.0.0';
            $WanRota = '0.0.0.0';
            $WanIpv6Rota = '0000:0000:0000:0000:0000:0000';
        }    

        if($Modelo == 'SR7750'){
            $Lin[0] = 'configure service ies '.$sVlan.$cVlan.' name "'.$sVlan.$cVlan.'" customer 1 create';
            $Lin[1] = 'interface "'.$Empresa.'_'.$ID.'_ERB" create';
            $Lin[2] = '     address '.$WanLocal.'/30';
            $Lin[3] = '     sap '.$Port.':'.$sVlan.'.'.$cVlan.' create';
            $Lin[4] = '     exit';
            $Lin[5] = 'ipv6';
            $Lin[6] = '          address '.$WanIpv6.'/127';
            $Lin[7] = '          urpf-check';
            $Lin[8] = '              mode loose';
            $Lin[9] = ' exit';
            $Lin[10] = '         urpf-check';
            $Lin[11] = '              mode loose';
            $Lin[12] = '         exit';
            $Lin[13] = '  exit';
            $Lin[14] = '  no shutdown';
            $Lin[15] = 'exit';
            $Lin[16] = 'no shutdown';
            $Lin[17] = 'exit all';
            $Lin[18] = '';
            $Lin[19] = 'configure router static-route-entry '.$Lan.'/29';
            $Lin[20] = '       next-hop '.$WanRota;
            $Lin[21] = '           description "'.$Empresa.'_'.$ID.'_ERB"';
            $Lin[22] = '           no shutdown';
            $Lin[23] = 'exit all';
            $Lin[24] = 'configure router static-route-entry '.$Loopback.'/32';
            $Lin[25] = '       next-hop '.$WanRota;
            $Lin[26] = '           description "'.$Empresa.'_'.$ID.'_ERB"';
            $Lin[27] = '           no shutdown';
            $Lin[28] = 'exit all';
            $Lin[29] = 'configure router static-route-entry '.$LanIpv6.'/56';
            $Lin[30] = '       next-hop '.$WanIpv6Rota;
            $Lin[31] = '           description "'.$Empresa.'_'.$ID.'_ERB"';
            $Lin[32] = '           no shutdown';
            $Lin[33] = 'exit all';   
            
            $Lin[_CtgLinScript] = 34;  // Total de linhas

        }else if($Modelo == 'SR7750_QoS'){ 
            
            $QoS = 10000 + (int)$Speed; 
            $Lin[0] = 'configure service ies '.$sVlan.$cVlan.' name "'.$sVlan.$cVlan.'" customer 1 create';
            $Lin[1] = 'interface "'.$Empresa.'_'.$ID.'_ERB" create';
            $Lin[2] = '     address '.$WanLocal.'/30';
            $Lin[3] = '     sap '.$Port.':'.$sVlan.'.'.$cVlan.' create';
            $Lin[4] = '         ingress';
		    $Lin[5] = '             qos '.$QoS;
	        $Lin[6] = '         exit';
	        $Lin[7] = '         egress';
		    $Lin[8] = '             qos '.$QoS;	       
            $Lin[9] = '         exit';
            $Lin[10] = '      exit';
            $Lin[11] = 'ipv6';
            $Lin[12] = '          address '.$WanIpv6.'/127';
            $Lin[13] = '          urpf-check';
            $Lin[14] = '              mode loose';
            $Lin[15] = ' exit';
            $Lin[16] = '         urpf-check';
            $Lin[17] = '              mode loose';
            $Lin[18] = '         exit';
            $Lin[19] = '  exit';
            $Lin[20] = '  no shutdown';
            $Lin[21] = 'exit';
            $Lin[22] = 'no shutdown';
            $Lin[23] = 'exit all';
            $Lin[24] = '';
            $Lin[25] = 'configure router static-route-entry '.$Lan.'/29';
            $Lin[26] = '       next-hop '.$WanRota;
            $Lin[27] = '           description "'.$Empresa.'_'.$ID.'_ERB"';
            $Lin[28] = '           no shutdown';
            $Lin[29] = 'exit all';
            $Lin[30] = 'configure router static-route-entry '.$Loopback.'/32';
            $Lin[31] = '       next-hop '.$WanRota;
            $Lin[32] = '           description "'.$Empresa.'_'.$ID.'_ERB"';
            $Lin[33] = '           no shutdown';
            $Lin[34] = 'exit all';
            $Lin[35] = 'configure router static-route-entry '.$LanIpv6.'/56';
            $Lin[36] = '       next-hop '.$WanIpv6Rota;
            $Lin[37] = '           description "'.$Empresa.'_'.$ID.'_ERB"';
            $Lin[38] = '           no shutdown';
            $Lin[39] = 'exit all';  
            
            $Lin[_CtgLinScript] = 40;  // Total de linhas

            // Scxript de Desconfiguracao
            $Lin[1000] = 'configure service'; 
            $Lin[1001] = 'ies '.$sVlan.$cVlan.' name "'.$sVlan.$cVlan.'"';
            $Lin[1002] = 'interface "'.$Empresa.'_'.$ID.'_ERB"';           
            $Lin[1003] = 'sap '.$Port.':'.$sVlan.'.'.$cVlan;
            $Lin[1004] = 'shut';
		    $Lin[1005] = 'exit';
            $Lin[1006] = 'no sap '.$Port.':'.$sVlan.'.'.$cVlan;
            $Lin[1007] = 'shut';
		    $Lin[1008] = 'exit';
            $Lin[1009] = 'no interface "'.$Empresa.'_'.$ID.'_ERB"';
            $Lin[1010] = 'shut';
		    $Lin[1011] = 'exit'; 
            $Lin[1012] = 'no ies '.$sVlan.$cVlan;         
		    $Lin[1013] = 'exit all';
		    $Lin[1014] = '!';

            $Lin[1015] = 'configure router';
            $Lin[1016] = 'static-route-entry '.$Lan.'/29';
            $Lin[1017] = 'no next-hop '.$WanRota;           
            $Lin[1018] = 'exit';
            $Lin[1019] = 'static-route-entry '.$Loopback.'/32';
            $Lin[1020] = 'no next-hop '.$WanRota;           
            $Lin[1021] = 'exit';
            $Lin[1022] = 'static-route-entry '.$LanIpv6.'/56';
            $Lin[1023] = 'no next-hop '.$WanIpv6Rota;            
            $Lin[1024] = 'exit all';  	       
	       
            $Lin[_CtgLinDcfScript] = 25;  // Total de linhas

        }
       
         // Script Preview        
         // Ajusta tamanho da LAN e Lo, para padrao
         while(strlen($Lan) != _TamIP){ $Lan = $Lan.' ';  }       
         while(strlen($Loopback) != _TamIP){ $Loopback = $Loopback.' ';  }       
               
         $Lin[200] = " WAN: ................... -> ".$WanLocal." /30";            
         $Lin[201] = " LAN: ".$Lan." /29 -> ".$WanRota;            
         $Lin[202] = "  Lo: ".$Loopback." /32 -> ".$WanRota;            
         $Lin[203] = "WAN6: ......................... -> ".$WanIpv6." /127"; 
         if( $this->checkIP($WanIpv6) == 'F'){ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota." <<- Confirme Calc(F+1) rota IPv6";  } 
         else if( $this->checkIP($WanIpv6) == '9'){ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota." <<- Confirme Calc(9+1) rota IPv6"; }  
         else{ $Lin[204] = "LAN6: ".$LanIpv6." /56 -> ".$WanIpv6Rota;  }
     

         // Verifica antes da config
         $FinalWanIpv6 = substr($WanIpv6Rota, -4);       
         
         $Lin[100] = 'show service sap-using sap '.$Port.':'.$sVlan.'.'.$cVlan; // Se porta esta livre
         $Lin[101] = 'admin display-config | match '.$sVlan.'.'.$cVlan.' context all'; // Profile
         $Lin[102] = 'show service sap-using | match '.$Port.':'.$sVlan; // Profile  
         $Lin[103] = ''; // Profile    
         $Lin[104] = 'admin display-config | match '.$sVlan.$cVlan.' context all'; // Profile    
         $Lin[105] = 'admin display-config | match context all '.$WanRota;
         $Lin[106] = 'admin display-config | match context all '.$FinalWanIpv6;
         $Lin[107] = 'show service sap-using | match '.$Port.':'.$sVlan; // Profile
    
         $Lin[_CtgCmdRouters] = 8;

        return ($Lin);	

    }


    function Datacom($Modelo, $ID, $Swa, $PlacaSwa, $PortaSwa, $NomeSwt, $IpSwt, $gVlan, $RA, $PortaRA, $sVlan, $cVlan, $Speed)
    {
        
        $Lin[] = "";
        
        $raX = substr($RA, -17); // Tira I-BR, pega so: sp-rpo-no-rai-01
        $raX = strtolower($raX); // passa para Minuscula

        if($Modelo == '2104G2'){                

            $Lin[0] = "config";
            $Lin[1] = "!";
            $Lin[2] = "interface vlan ".$gVlan;
            $Lin[3] = "set-member tagged ethernet ".$PlacaSwa."/".$PortaSwa;
            $Lin[4] = "exit";
            $Lin[5] = "!";
            $Lin[6] = "interface vlan ".$sVlan;
            $Lin[7] = "set-member untagged ethernet ".$PlacaSwa."/".$PortaSwa;
            $Lin[8] = "exit";
            $Lin[9] = "!";
            $Lin[10] = "interface ethernet ".$PlacaSwa."/".$PortaSwa;
            $Lin[11] = "description IP_DLK#FIBRA#".$NomeSwt."#".$IpSwt."#1/1#1G#".$ID."#";
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
            $Lin[29] = "vlan-translate ingress-table replace ethernet ".$PlacaSwa."/".$PortaSwa." source-vlan ".$gVlan." new-vlan ".$gVlan;
            $Lin[30] = "vlan-translate ingress-table add ethernet ".$PlacaSwa."/".$PortaSwa." source-vlan ".$cVlan." new-vlan ".$sVlan;
            $Lin[31] = "exit";
            $Lin[32] = "!";
            $Lin[33] = "copy run st 1";
            $Lin[34] = "copy run st 2";
            
            $Lin[_CtgLinScript] = 35;
                        
            // Carimbo gerado para colar no taBackbone -> Star               
            $Lin[300] = "\n\n***  VALIDACAO DE IPs ***";  
            $Lin[301] = "\nID CERTIFICADO";
            $Lin[302] = "\nAtividade concluída com sucesso.\n";
            $Lin[303] = "ID Execução:  \n\n";         
            $Lin[304] = "***  BACKBONE ***\n\n\n";   
            $Lin[305] = "...\n";       
            $Lin[306] = "***  ".$Swa." ***\n"; 
            $Lin[307] = "\n"; 
            $Lin[308] = "interface ethernet 1/".$PortaSwa."\n";
            $Lin[309] = "description IP_DLK#FIBRA#".$NomeSwt."#".$IpSwt."#1/1#1G#".$ID."#\n";            
            $Lin[310] = "!\n";
            $Lin[311] = "interface vlan ".$gVlan."\n";
            $Lin[312] = "set-member tagged ethernet ".$PlacaSwa."/".$PortaSwa."\n";          
            $Lin[313] = "!\n";
            $Lin[314] = "interface vlan ".$sVlan."\n";
            $Lin[315] = "name IPD#".$raX."#".$PortaRA."\n";
            $Lin[316] = "set-member untagged ethernet ".$PlacaSwa."/".$PortaSwa."\n";           
            $Lin[317] = "!\n";         
            $Lin[318] = "vlan-translate ingress-table replace ethernet ".$PlacaSwa."/".$PortaSwa." source-vlan ".$gVlan." new-vlan ".$gVlan."\n";
            $Lin[319] = "vlan-translate ingress-table add ethernet ".$PlacaSwa."/".$PortaSwa." source-vlan ".$cVlan." new-vlan ".$sVlan."\n";
            $Lin[320] = "!\n";
            $Lin[321] = "E.Flow:\n";

            $Lin[_CtgCARIMBO] = 22;
        
            // Desconfiguracao
            $Lin[1000] = "config";
            $Lin[1001] = "!";
            $Lin[1002] = "interface vlan ".$gVlan;
            $Lin[1003] = "no set-member ethernet ".$PlacaSwa."/".$PortaSwa;
            $Lin[1004] = "exit";
            $Lin[1005] = "!";
            $Lin[1006] = "interface vlan ".$sVlan;
            $Lin[1007] = "no set-member ethernet ".$PlacaSwa."/".$PortaSwa;
            $Lin[1008] = "exit";
            $Lin[1009] = "!";
            $Lin[1010] = "interface ethernet ".$PlacaSwa."/".$PortaSwa;
            $Lin[1011] = "no description";
            $Lin[1012] = "shutdown";           
            $Lin[1013] = "exit";
            $Lin[1014] = "!";
            $Lin[1015] = "no vlan-translate ingress-table ethernet ".$PlacaSwa."/".$PortaSwa." source-vlan ".$gVlan;
            $Lin[1016] = "no vlan-translate ingress-table ethernet ".$PlacaSwa."/".$PortaSwa." source-vlan ".$cVlan;
            $Lin[1017] = "exit";
            $Lin[1018] = "!";
            $Lin[1019] = "copy run st 1";
            $Lin[1020] = "copy run st 2";
           
            $Lin[_CtgLinDcfScript] = 21;    // Conta Linhas desconfiguracao
        //-----------------------------------

        }else if($Modelo == 'V380R220'){

            $Lin[0] = "conf";
            $Lin[1] = "interface gigaethernet 1/".$PlacaSwa."/".$PortaSwa;
            $Lin[2] = "no shut";
            $Lin[3] = "alias IP_DLK#FIB#".$NomeSwt."#".$IpSwt."#1G#1/1/1#".$ID."#";
            $Lin[4] = "negotiation auto disable";
            $Lin[5] = "no port hybrid vlan 1";
            $Lin[6] = "port hybrid vlan ".$gVlan.",".$cVlan." tagged";
            $Lin[7] = "port hybrid vlan 2,".$sVlan." untagged";
            $Lin[8] = "port hybrid pvid 2";
            $Lin[9] = "vlan-stacking enable";
            $Lin[10] = "vlan-stacking vlan ".$cVlan." stack-vlan ".$sVlan;
            $Lin[11] = "vlan-mapping enable";
            $Lin[12] = "vlan-mapping vlan ".$gVlan." map-vlan ".$gVlan;
            $Lin[13] = "lldp admin-status rx-tx";
            $Lin[14] = "!";
            $Lin[15] = "exit";
            $Lin[16] = "!";
            $Lin[17] = "write file both";
            $Lin[18] = "!";
            $Lin[19] = "exit";
            $Lin[20] = "!";
            
            $Lin[_CtgLinScript] = 21;

            // Carimbo gerado para colar no taBackbone -> Star               
            $Lin[300] = "\n\n***  VALIDACAO DE IPs ***";  
            $Lin[301] = "\nID CERTIFICADO";
            $Lin[302] = "\nAtividade concluída com sucesso.\n";
            $Lin[303] = "ID Execução:  \n\n";         
            $Lin[304] = "***  BACKBONE ***\n\n\n";   
            $Lin[305] = "...\n";       
            $Lin[306] = "***  ".$Swa." ***\n"; 
            $Lin[307] = "\n"; 
            $Lin[308] = "interface gigaethernet 1/".$PlacaSwa."/".$PortaSwa."\n";
            $Lin[309] = "alias IP_DLK#FIB#".$NomeSwt."#".$IpSwt."#1G#1/1/1#".$ID."#\n";
            $Lin[310] = "negotiation auto disable\n";
            $Lin[311] = "no port hybrid vlan 1\n";
            $Lin[312] = "port hybrid vlan ".$gVlan.",".$cVlan." tagged\n";
            $Lin[313] = "port hybrid vlan 2,".$sVlan." untagged\n";
            $Lin[314] = "port hybrid pvid 2\n";
            $Lin[315] = "vlan-stacking enable\n";
            $Lin[316] = "vlan-stacking vlan ".$cVlan." stack-vlan ".$sVlan."\n";
            $Lin[317] = "vlan-mapping enable\n";
            $Lin[318] = "vlan-mapping vlan ".$gVlan." map-vlan ".$gVlan."\n";
            $Lin[319] = "lldp admin-status rx-tx\n";            
            $Lin[320] = "!\n";
            $Lin[321] = "E.Flow:\n";

            $Lin[_CtgCARIMBO] = 22;

            // Script de desconfiguracao
            $Lin[1000] = "config ter";
            $Lin[1001] = "!";          
            $Lin[1002] = "interface gigaethernet 1/".$PlacaSwa."/".$PortaSwa;          
            $Lin[1003] = "no alias";
            $Lin[1004] = "shutdown";           
            $Lin[1005] = "no port hybrid vlan 2,".$sVlan;
            $Lin[1006] = "no port hybrid vlan ".$gVlan.", ".$cVlan;
            $Lin[1007] = "no vlan-stacking vlan ".$gVlan;
            $Lin[1008] = "!";
            $Lin[1009] = "exit";
            $Lin[1010] = "write file both";
                
            $Lin[_CtgLinDcfScript] = 11;    // Conta Linhas desconfiguracao
       
        //-----------------------------------

        }else if($Modelo == 'DM4050'){

            $Lin[0] = "config e";
            $Lin[1] = "!";
            $Lin[2] = "dot1q";
            $Lin[3] = " vlan 2";
            $Lin[4] = "  interface gigabit-ethernet-1/".$PlacaSwa."/".$PortaSwa;
            $Lin[5] = "   untagged";
            $Lin[6] = "exit";
            $Lin[7] = "exit";
            $Lin[8] = "exit";
            $Lin[9] = "!";
            $Lin[10] = "dot1q";
            $Lin[11] = " vlan ".$sVlan;
            $Lin[12] = "  interface gigabit-ethernet-1/".$PlacaSwa."/".$PortaSwa;
            $Lin[13] = "   untagged";
            $Lin[14] = "exit";
            $Lin[15] = "exit";
            $Lin[16] = "exit";
            $Lin[17] = "!";
            $Lin[18] = "dot1q";
            $Lin[19] = " vlan ".$gVlan;
            $Lin[20] = "  interface gigabit-ethernet-1/".$PlacaSwa."/".$PortaSwa;
            $Lin[21] = "exit";
            $Lin[22] = "exit";
            $Lin[23] = "exit";
            $Lin[24] = "!";
            $Lin[25] = "switchport";
            $Lin[26] = "  interface gigabit-ethernet-1/".$PlacaSwa."/".$PortaSwa;
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
            $Lin[38] = "  interface gigabit-ethernet-1/".$PlacaSwa."/".$PortaSwa;
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
            $Lin[54] = "interface gigabit-ethernet 1/".$PlacaSwa."/".$PortaSwa;
            $Lin[55] = "no shut";
            $Lin[56] = "description IP_DLK@FIBRA@".$NomeSwt."@".$IpSwt."@1/1@1G@".$ID."@";
            $Lin[57] = "no negotiation";
            $Lin[58] = "duplex full";
            $Lin[59] = "speed 1G";
            $Lin[60] = "exit";
            $Lin[61] = "!";
            $Lin[62] = "lldp";
            $Lin[63] = "interface gigabit-ethernet-1/".$PlacaSwa."/".$PortaSwa;
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

            // carimbo Script-SWA p/ colar no Star  
            $Lin[300] = "\n\n***  VALIDACAO DE IPs ***";  
            $Lin[301] = "\nID CERTIFICADO";
            $Lin[302] = "\nAtividade concluída com sucesso.\n";
            $Lin[303] = "ID Execução:  \n\n";         
            $Lin[304] = "***  BACKBONE ***\n\n\n";   
            $Lin[305] = "...\n";   
            $Lin[306] = "***  ".$Swa." ***\n";  
            $Lin[307] = "\n";                     
            $Lin[308] = "interface gigabit-ethernet 1/".$PlacaSwa."/".$PortaSwa."\n";
            $Lin[309] = "description IP_DLK@FIBRA@".$NomeSwt."@".$IpSwt."@1/1@1G@".$ID."@\n"; 
            $Lin[310] = "no shutdown\n";
            $Lin[311] = "!\n";
            $Lin[312] = " vlan ".$gVlan."\n";
            $Lin[313] = "  interface gigabit-ethernet-1/".$PlacaSwa."/".$PortaSwa."\n";
            $Lin[314] = "!\n";
            $Lin[315] = " vlan ".$sVlan."\n";
            $Lin[316] = "  name IPD#".$raX."#".$PortaRA."\n";
            $Lin[317] = "  interface gigabit-ethernet-1/".$PlacaSwa."/".$PortaSwa."\n";
            $Lin[318] = "   untagged\n";
            $Lin[319] = "!\n";
            $Lin[320] = "vlan-mapping\n";
            $Lin[321] = "  interface gigabit-ethernet-1/".$PlacaSwa."/".$PortaSwa."\n";
            $Lin[322] = "  ingress\n";
            $Lin[323] = "   rule 1-1-".$PortaSwa."-".$gVlan."\n";
            $Lin[324] = "    match vlan vlan-id ".$gVlan."\n";
            $Lin[325] = "    action replace vlan vlan-id ".$gVlan." pcp 0\n";
            $Lin[326] = "   !\n";
            $Lin[327] = "   rule ".$sVlan.$cVlan."\n";
            $Lin[328] = "    match vlan vlan-id ".$cVlan."\n";
            $Lin[329] = "    action add vlan vlan-id ".$sVlan." pcp 0\n";
            $Lin[330] = "   !\n";
            $Lin[331] = "E.Flow:\n";
            
            $Lin[_CtgCARIMBO] = 32;

             // Script de desconfiguracao
             $Lin[1000] = "config e";
             $Lin[1001] = "!";
             $Lin[1002] = "dot1q";
             $Lin[1003] = " vlan ".$sVlan;
             $Lin[1004] = "  no interface gigabit-ethernet-1/".$PlacaSwa."/".$PortaSwa;
             $Lin[1005] = "exit";
             $Lin[1006] = "exit";
             $Lin[1007] = "!";
             $Lin[1008] = "!";			
             $Lin[1009] = "vlan-mapping";
             $Lin[1010] = "  no interface gigabit-ethernet-1/".$PlacaSwa."/".$PortaSwa;
             $Lin[1011] = "exit";
             $Lin[1012] = "!";
             $Lin[1013] = "!";            
             $Lin[1014] = "!";
             $Lin[1015] = "interface gigabit-ethernet 1/".$PlacaSwa."/".$PortaSwa;
             $Lin[1016] = "shutdown";
             $Lin[1017] = "no description";
             $Lin[1018] = "exit";
             $Lin[1019] = "!";
             $Lin[1020] = "commit";
             $Lin[1021] = "!";
             $Lin[1022] = "exit";
             $Lin[1023] = "!";
                 
             $Lin[_CtgLinDcfScript] = 24;    // Conta Linhas desconfiguracao
        

        }else if($Modelo == 'DM4370'){

            if($PortaSwa > 4){ 
                $EthDcpt = "  interface gigabit-ethernet 1/"; 
                $Eth = "  interface gigabit-ethernet-1/"; 
            }else{ 
                $EthDcpt = "  interface ten-gigabit-ethernet 1/"; 
                $Eth = "  interface ten-gigabit-ethernet-1/"; 
            }
            
                
            $Lin[0] = "config e";
            $Lin[1] = "!";
            $Lin[2] = "dot1q";
            $Lin[3] = " vlan 2";            
            $Lin[4] = $Eth.$PlacaSwa."/".$PortaSwa;
            $Lin[5] = "   untagged";
            $Lin[6] = "exit";
            $Lin[7] = "exit";
            $Lin[8] = "exit";
            $Lin[9] = "!";
            $Lin[10] = "dot1q";
            $Lin[11] = " vlan ".$sVlan;
            $Lin[12] = $Eth.$PlacaSwa."/".$PortaSwa;
            $Lin[13] = "   untagged";
            $Lin[14] = "exit";
            $Lin[15] = "exit";
            $Lin[16] = "exit";
            $Lin[17] = "!";
            $Lin[18] = "dot1q";
            $Lin[19] = " vlan ".$gVlan;
            $Lin[20] = $Eth.$PlacaSwa."/".$PortaSwa;
            $Lin[21] = "exit";
            $Lin[22] = "exit";
            $Lin[23] = "exit";
            $Lin[24] = "!";
            $Lin[25] = "switchport";
            $Lin[26] = $Eth.$PlacaSwa."/".$PortaSwa;
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
            $Lin[38] = $Eth.$PlacaSwa."/".$PortaSwa;
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
            $Lin[54] = $EthDcpt.$PlacaSwa."/".$PortaSwa;
            $Lin[55] = "description IP_DLK@FIBRA@".$NomeSwt."@".$IpSwt."@1/1@1G@".$ID."@";
            $Lin[56] = "no negotiation";
            $Lin[57] = "duplex full";
            $Lin[58] = "speed 1G";
            $Lin[59] = "exit";
            $Lin[60] = "!";
            $Lin[61] = "lldp";
            $Lin[62] = $Eth.$PlacaSwa."/".$PortaSwa;
            $Lin[63] = "admin-status tx-and-rx	";
            $Lin[64] = "no notification";
            $Lin[65] = "!";
            $Lin[66] = "exit";
            $Lin[67] = "!";
            $Lin[68] = "exit";
            $Lin[69] = "!";
            $Lin[70] = "commit";
            $Lin[71] = "!";
            $Lin[72] = "exit";
            $Lin[73] = "!";
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
            $Lin[_CtgLinScript] = 74;

            // carimbo Script-SWA p/ colar no Star            
            $Lin[300] = "\n\n***  VALIDACAO DE IPs ***";  
            $Lin[301] = "\nID CERTIFICADO";
            $Lin[302] = "\nAtividade concluída com sucesso.\n";
            $Lin[303] = "ID Execução:  \n\n";          
            $Lin[304] = "***  BACKBONE ***\n\n\n";   
            $Lin[305] = "\n";       
            $Lin[306] = "***  ".$Swa." ***\n";  
            $Lin[307] = "\n";                     
            $Lin[308] = $EthDcpt.$PlacaSwa."/".$PortaSwa."\n";
            $Lin[309] = "description IP_DLK@FIBRA@".$NomeSwt."@".$IpSwt."@1/1@1G@".$ID."@\n"; 
            $Lin[310] = "no shutdown\n";
            $Lin[311] = "!\n";
            $Lin[312] = " vlan ".$gVlan."\n";
            $Lin[313] = $Eth.$PlacaSwa."/".$PortaSwa."\n";
            $Lin[314] = "!\n";
            $Lin[315] = " vlan ".$sVlan."\n";
            $Lin[316] = "  name IPD#".$raX."#".$PortaRA."\n";
            $Lin[317] = $Eth.$PlacaSwa."/".$PortaSwa."\n";
            $Lin[318] = "   untagged\n";
            $Lin[319] = "!\n";
            $Lin[320] = "vlan-mapping\n";
            $Lin[321] = $Eth.$PlacaSwa."/".$PortaSwa."\n";
            $Lin[322] = "  ingress\n";
            $Lin[323] = "   rule 1-1-".$PortaSwa."-".$gVlan."\n";
            $Lin[324] = "    match vlan vlan-id ".$gVlan."\n";
            $Lin[325] = "    action replace vlan vlan-id ".$gVlan." pcp 0\n";
            $Lin[326] = "   !\n";
            $Lin[327] = "   rule ".$sVlan.$cVlan."\n";
            $Lin[328] = "    match vlan vlan-id ".$cVlan."\n";
            $Lin[329] = "    action add vlan vlan-id ".$sVlan." pcp 0\n";
            $Lin[330] = "   !\n";
            $Lin[331] = "E.Flow:\n";
            
            $Lin[_CtgCARIMBO] = 32;  
            
            
            // Script de desconfiguracao
                 
            $Lin[_CtgLinDcfScript] = 11;    // Conta Linhas desconfiguracao
        

        }else if($Modelo == 'DM4004' || $Modelo == 'DM4008' || $Modelo == 'DM4100'){           

            // SCRIPT SWA SERVICO DATACOM IPD-VPN-SIP(CONECTADO COM CPE)
            $Lin[0] = "config";
            $Lin[1] = "!";
            $Lin[2] = "interface vlan ".$gVlan;
            $Lin[3] = "set-member tagged ethernet ".$PlacaSwa."/".$PortaSwa;
            $Lin[4] = "exit";
            $Lin[5] = "!";
            $Lin[6] = "interface vlan ".$sVlan;
            $Lin[7] = "set-member untagged ethernet ".$PlacaSwa."/".$PortaSwa;
            $Lin[8] = "exit";
            $Lin[9] = "!";
            $Lin[10] = "interface ethernet ".$PlacaSwa."/".$PortaSwa;
            $Lin[11] = "description SRV_IPD#FIBRA#".$NomeSwt."#".$IpSwt."_".$Speed."M_#1/1#1G#".$ID."#";                       
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
            $Lin[29] = "vlan-translate ingress-table replace ethernet ".$PlacaSwa."/".$PortaSwa." source-vlan ".$gVlan." new-vlan ".$gVlan;
            $Lin[30] = "vlan-translate ingress-table add ethernet ".$PlacaSwa."/".$PortaSwa." source-vlan ".$cVlan." new-vlan ".$sVlan;
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
            $Lin[304] = "***  BACKBONE ***\n\n\n";     
            $Lin[305] = "\n";     
            $Lin[306] = "***  ".$Swa." ***\n"; 
            $Lin[307] = "\n";        
            $Lin[308] = "interface ethernet ".$PlacaSwa."/".$PortaSwa."\n";
            $Lin[309] = "description SRV_IPD#FIBRA#".$NomeSwt."#_Speed_#0000/00#".$ID."#".$NomeSwt."#".$IpSwt."#\n";
            $Lin[310] = "!\n";
            $Lin[311] = "interface vlan ".$gVlan."\n";
            $Lin[312] = "set-member tagged ethernet ".$PlacaSwa."/".$PortaSwa."\n";            
            $Lin[313] = "!\n";
            $Lin[314] = "interface vlan ".$sVlan."\n";
            $Lin[315] = "set-member untagged ethernet ".$PlacaSwa."/".$PortaSwa."\n";           
            $Lin[316] = "!\n";            
            $Lin[317] = "vlan-translate ingress-table replace ethernet ".$PlacaSwa."/".$PortaSwa." source-vlan ".$gVlan." new-vlan ".$gVlan."\n";
            $Lin[318] = "vlan-translate ingress-table add ethernet ".$PlacaSwa."/".$PortaSwa." source-vlan ".$cVlan." new-vlan ".$sVlan."\n";
            $Lin[319] = "!\n";
            $Lin[320] = "E.Flow:\n";
         
            $Lin[_CtgCARIMBO] = 21; 

            // Script de desconfiguracao
                 
            $Lin[_CtgLinDcfScript] = 11;    // Conta Linhas desconfiguracao
       
        }

         // Script Preview 
         $Lin[200] = " ID   : ".$ID;            
         $Lin[201] = " Eth  : ".$PlacaSwa.'/'.$PortaSwa;            
         $Lin[202] = " gVlan: ".$gVlan;            
         $Lin[203] = " sVlan: ".$sVlan;            
         $Lin[204] = " cVlan: ".$cVlan;  

         // Verifica antes da config
         $Lin[100] = 'show version'; 
         $Lin[101] = 'show system'; 
         $Lin[102] = 'show chassi'; 
         $Lin[103] = 'show flash'; 
         $Lin[104] = 'show inventory'; // Se porta esta livre        
         $Lin[105] = 'show int status eth '.$PlacaSwa.'/'.$PortaSwa;     
         $Lin[106] = 'sh mac-address-table interface ethernet '.$PlacaSwa.'/'.$PortaSwa;             
         $Lin[107] = 'no vlan-translate ingress-table ethernet '.$PlacaSwa.'/'.$PortaSwa.' source-vlan '.$cVlan; // Profile             
    
         $Lin[_CtgCmdRouters] = 8;

        return $Lin;
        
    }
    

    function EddToFab($M){
        // Esta funcao foi so pra nao ter que cadastrar Fab: datacom no MySQL
        if($M == '2104G2'){ return 'Datacom'; };
        if($M == 'DM4004'){ return 'Datacom'; };
        if($M == 'DM4008'){ return 'Datacom'; };
        if($M == 'DM4050'){ return 'Datacom'; };
    }
    
    function SpeedToBandwidth($Speed){
        $Res = (int)$Speed * 1024;
        return $Res;
    }

    function cmdReverIPs($RdLan, $RdWan, $RdLo){

        $Lan[1] = $this->IpToRota($RdLan);
        $Lan[2] = $this->IpToRota($Lan[1]);
        $Lan[3] = $this->IpToRota($Lan[2]);
        $Wan[1] = $this->IpToRota($RdWan);
        $Wan[2] = $this->IpToRota($Wan[1]);

        // Verifica antes da config
        $Lin[0] = "cat /deviceList | grep -swa-0";
        $Lin[1] = "ssh i-br-sp-spo-cbl-rsd-01"; 
        $Lin[2] = "ssh c-br-sp-spo-ctp-rav-01";
        $Lin[3] = "exit"; 

        $Lin[4] = "sh ip route ".$Lan[1]; 
        $Lin[5] = "sh ip route ".$Lan[2]; 
        $Lin[6] = "sh ip route ".$Lan[3]; 
        $Lin[7] = "sh ip route ".$Wan[1]; 
        $Lin[8] = "sh ip route ".$Wan[2]; 
        $Lin[9] = "sh ip route ".$RdLo;        
        $Lin[10] = "exit";        

        $Lin[11] = "sh ip route vrf GERENCIA ".$Lan[1]; 
        $Lin[12] = "sh ip route vrf GERENCIA ".$Lan[2]; 
        $Lin[13] = "sh ip route vrf GERENCIA ".$Lan[3]; 
        $Lin[14] = "sh ip route vrf GERENCIA ".$Wan[1]; 
        $Lin[15] = "sh ip route vrf GERENCIA ".$Wan[2]; 
        $Lin[16] = "sh ip route vrf GERENCIA ".$RdLo;
        $Lin[17] = "exit"; 

        $Lin[18] = "sh ip route ".$Lan[1]; 
        $Lin[19] = "sh ip route ".$Lan[2]; 
        $Lin[20] = "sh ip route ".$Lan[3]; 
        $Lin[21] = "sh ip route ".$Wan[1]; 
        $Lin[22] = "sh ip route ".$Wan[2]; 
        $Lin[23] = "sh ip route ".$RdLo;        
        $Lin[24] = "sed -i '66d' /home/80969577/.ssh/known_hosts";        
           

        $Lin[_CtgVETOR] = 25;
    
        return ($Lin);	
    }

   function servicePolicy($Router, $Speed, $Tipo){
        
        $Res[] = "";

        if($Router == 'Cisco'){
            $Res[100] ='IPD-SECURITY-IN-'.$Speed.'M'; 
            $Res[200] ='IPD-SECURITY-OUT-'.$Speed.'M'; 
            $Res[101] ='IPD-SECURITY-IN-'.$Speed.'Mbps'; 
            $Res[201] ='IPD-SECURITY-OUT-'.$Speed.'Mbps'; 
            $Res[102] = 'IPD_SECURITY_IN_'.$Speed.'M';  
            $Res[202] = 'IPD_OUT_'.$Speed.'M_SHAPE'; 
            $Res[103] = 'IPD_SECURITY_IN'; 
            $Res[203] = 'IPD_OUT-SHAPE'; 
            $Res[104] = 'IPD_SECURITY_IN_'.$Speed.'M'; 
            $Res[204] = 'IPD_OUT-SHAPE'; 
            $Res[105] = 'LIMIT-'.$Speed.'M-QOS-ETH'; 
            $Res[205] = 'LIMIT-'.$Speed.'M-QOS-ETH'; 
           
            if($Tipo == 'VPN'){
                $Res[105] = 'IPD_SECURITY_IN_'.$Speed.'M'; 
                $Res[205] = 'BANCO_ITAU_'.$Speed.'M_VPN-IP_MPLS_ETH'; 
                $Res[106] = 'IPD_SECURITY_IN_'.$Speed.'M'; 
                $Res[206] = 'BANCO_ITAU_'.$Speed.'M_VPN-IP_MPLS_ETH_SHAPE'; 
                $Res[1000] = 7;
                $Res[106] = 'IPD_SECURITY_IN_'.$Speed.'M'; 
                $Res[206] = 'TELEFONICA_102400K_VPN-IP_MPLS_A_ETH_SHAPE'; 
                $Res[1000] = 7;
            }else{                        
                $Res[1000] = 6;
            }

        }else  if($Router == 'Huawei'){ 
            $Res[100] = 'IPD-SECURITY-IN-'.$Speed.'Mbps'; 
            $Res[200] = 'IPD-SECURITY-OUT-'.$Speed.'Mbps'; 
            $Res[101] = 'IPD-SECURITY-IN-'.$Speed.'M'; 
            $Res[201] = 'IPD-SECURITY-OUT-'.$Speed.'M'; 
            
            $Res[1000] = 2;

        }else  if($Router == 'Juniper'){ 							                                 	
            $Res[100] = 'BORDER-POLICER-'.$Speed.'M'; 	
            $Res[101] = 'BORDER-POLICER-'.$Speed.'Mbps'; 
            	
            $Res[200] = 'BORDER-POLICER-'.$Speed.'M'; 	
            $Res[201] = 'BORDER-POLICER-'.$Speed.'Mbps'; 	
            
            $Res[1000] = 2;

        }else  if($Router == 'Nokia'){ 							                                 	
            $Res[100] = 10000 + (int)$Speed; 	
            $Res[200] = 10000 + (int)$Speed; 	
            
            $Res[1000] = 1;

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
   
    function CheckCamposSwa($ModeloX, $IDX, $PlacaSwaX, $PortaSwaX, $SwtX, $Swt_ipX, $gVlanX, $RaX, $PortX, $sVlanX, $cVlanX){

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
        if($PlacaSwaX==''){ $msg[2]="Placa Swa"; $Res = false; } 
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