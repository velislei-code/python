import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

import javax.swing.JTextArea;
import javax.swing.Timer;


public class CmdModem {
	
		

		
		/*****************************************************************************/
		/** DSL2500e **/
		public static String sDsl2500eStatus[] =	{
				"$sh",
				"DSL_2500E#show adsl",		    
				"Adsl Line Status         SHOWTIME.",
				"Adsl Mode                   G992.1",
				"Up Stream                 320 kbps",
				"Down Stream              1024 kbps",
				"Attenuation Down Stream          7",
				"Attenuation Up Stream            3",
				"SNR Margin Down Stream        40.8",
				"SNR Margin Up Stream          31.0",
				"Firmware Version          3923c131",
				"15 min ES Counter                0",
				"CRC upstream                     10",
				"CRC downstream                   7",
				"1 day ES Counter                 0",
				"ES                               0",
				"SES                              0"
				};
		
			public static String sDsl2500eAuth[] =	{
				"$show status",
				"System",
				"Alias Name              : RTL867x ADSL Modem",
				"Uptime                  : 1 21:1:48",
				"Date/Time               : Fri Jan  2 21:1:48 1970",
				"Firmware Version        : OI_V1.11 Build.131106 Rel.0668919",
				"",
				"DSL",
				"Operational Status      : G992.5",
				"Upstream Speed          : 1118 kbps",
				"Downstream Speed        : 19956 kbps",
				"",
				"LAN Configuration",
				"IP Address              : 10.42.0.254",
				"Subnet Mask             : 255.255.252.0",
				"DHCP Server             : Disable",
				"MAC Address             : C4:A8:1D:DA:CD:99",
				"",
				"WAN Configuration",
				"Interface VPI/VCI Encap Droute Protocol IP Address Gateway Status",
				"----------------------------------------------------------",
				"pppoe1  0/35    LLC   On     PPPoE  200.193.175.68  201.10.216.240  up"
				
			};
		
			public static String sDsl2500ePing[] =	{
				"$sh",
				"DSL_2500E#ping www.uol.com.br",
				"Sending 5, ICMP Echos to 200.147.67.142, timeout is 2 seconds",
				"!!!!!",
				"Success rate is 100 percent (5/5), round-trip min/avg/max = 100/100/100 ms"    			
				};

			// informa tamanho dos vetores
			public int iDsl2500eStatus = sDsl2500eStatus.length;
			public int iDsl2500eAuth = sDsl2500eAuth.length;
			public int iDsl2500ePing = sDsl2500ePing.length;
			
			public static String sDsl2500eStatusDN[] =	{
				"$sh",
				"DSL_2500E#show adsl",		    
				"Adsl Line Status         ACTIVATING.",
				"Adsl Mode                   	  --",
				"Up Stream                 		  --",
				"Down Stream              		  --",
				"Attenuation Down Stream          --",
				"Attenuation Up Stream            --",
				"SNR Margin Down Stream           --",
				"SNR Margin Up Stream             --",
				"Firmware Version           3923c131",
				"15 min ES Counter                --",
				"CRC upstream                     --",
				"CRC downstream                   --",
				"1 day ES Counter                  0",
				"ES                               --",
				"SES                              --"
				};
		
			public static String sDsl2500eAuthDN[] =	{
				"$show status",
				"System",
				"Alias Name              : RTL867x ADSL Modem",
				"Uptime                  : 1 21:1:48",
				"Date/Time               : Fri Jan  2 21:1:48 1970",
				"Firmware Version        : OI_V1.11 Build.131106 Rel.0668919",
				"",
				"DSL",
				"Operational Status      : --",
				"Upstream Speed          : --",
				"Downstream Speed        : --",
				"",
				"LAN Configuration",
				"IP Address              : 10.42.0.254",
				"Subnet Mask             : 255.255.252.0",
				"DHCP Server             : Disable",
				"MAC Address             : C4:A8:1D:DA:CD:99",
				"",
				"WAN Configuration",
				"Interface VPI/VCI Encap Droute Protocol IP Address Gateway Status",
				"----------------------------------------------------------",
				"pppoe1  0/35    LLC   On     PPPoE  	0.0.0.0  0.0.0.0   down"
				
			};
		
			public static String sDsl2500ePingDN[] =	{
				"$sh",
				"DSL_2500E#ping www.uol.com.br",
				"Sending 5, ICMP Echos to 200.147.67.142, timeout is 2 seconds",
				".....",
				"Success rate is 0 percent (0/5)"    			
				};

			// informa tamanho dos vetores
			public int iDsl2500eStatusDN = sDsl2500eStatusDN.length;
			public int iDsl2500eAuthDN = sDsl2500eAuthDN.length;
			public int iDsl2500ePingDN = sDsl2500ePingDN.length;
			/*****************************************************************************/
			/*****************************************************************************/
        	
			/*****************************************************************************/
			/** HubDLink(Opticom, Dsl485, Dsl279, Dsl2730b) **/
			public static String sHubDLinkStatus[] =	{
				/*
				"StatusX: Idle",
				"StatusX: G.994 Training",
				"StatusX: G.992 Started",
				"StatusX: G.922 Channel Analysis",
				"RetrainX ReasonX: 1",
				"",
				*/
				" > adsl info --stats",
				"adsl: ADSL driver and PHY status",
				"Status: Showtime",
				"Retrain Reason: 8000",
				"Max:    Upstream rate = 564 Kbps, Downstream rate = 8256 Kbps",
				"Channel:        FAST, Upstream rate = 320 Kbps, Downstream rate = 1024 Kbps",
				"",
				"Link Power State:       L0",
				"Mode:                   G.DMT",
				"TPS-TC:                 ATM Mode",
				"Trellis:                ON",
				"Line Status:            No Defect",
				"Training Status:        Showtime",
				"                Down            Up",
				"SNR (dB):        35.8            18.0",
				"Attn(dB):        2.0             4.5",
				"Pwr(dBm):        6.4             12.0",
				"                        G.dmt framing",
				"K:              33(0)           11",
				"R:              0               0",
				"S:              1               1",
				"D:              1               1",
				"                        Counters",
				"SF:             16873           16813",
				"SFErr:          0               0",
				"RS:             0               0",
				"RSCorr:         0               0",
				"RSUnCorr:       0               0",
				"",
				"HEC:            0               0",
				"OCD:            0               0",
				"LCD:            0               0",
				"Total Cells:    692780          0",
				"Data Cells:     301             0",
				"Drop Cells:     0",
				"Bit Errors:     0               0",
				"",
				"ES:             0               0",
				"SES:            0               0",
				"UAS:            33              33",
				"AS:             279",
				"",
				"INP:            0.00            0.00",
				"PER:            1.75            1.75",
				"delay:          0.25            0.25",
				"OR:             32.00           32.00",
				"",
				"Bitswap:        0               0",
				"",
				"Total time = 5 min 45 sec",
				"FEC:            0               0",
				"CRC:            20              11",
				"ES:             0               0",
				"SES:            0               0",
				"UAS:            33              33",
				"LOS:            0               0",
				"LOF:            0               0",
				"Latest 15 minutes time = 5 min 45 sec",
				"FEC:            0               0",
				"CRC:            20              7",
				"ES:             0               0",
				"SES:            0               0",
				"UAS:            33              33",
				"LOS:            0               0",
				"LOF:            0               0",
				"Previous 15 minutes time = 0 sec",
				"FEC:            0               0",
				"CRC:            0               0",
				"ES:             0               0",
				"SES:            0               0",
				"UAS:            0               0",
				"LOS:            0               0",
				"LOF:            0               0",
				"Latest 1 day time = 5 min 45 sec",
				"FEC:            0               0",
				"CRC:            0               0",
				"ES:             0               0",
				"SES:            0               0",
				"UAS:            33              33",
				"LOS:            0               0",
				"LOF:            0               0",
				"Previous 1 day time = 0 sec",
				"FEC:            0               0",
				"CRC:            0               0",
				"ES:             0               0",
				"SES:            0               0",
				"UAS:            0               0",
				"LOS:            0               0",
				"LOF:            0               0",
				"Since Link time = 4 min 45 sec",
				"FEC:            0               0",
				"CRC:            0               0",
				"ES:             0               0",
				"SES:            0               0",
				"UAS:            0               0",
				"LOS:            0               0",
				"LOF:            0               0",
				" >"
				};
			
				public static String sHubDLinkAuth[] =	{
					"> wan show 0.0.35",
					"VCC     Con.    Service         Interface       Proto.  IGMP    MLD     Status          IP",
					"        ID      Name            Name                                                    address",
					"0.0.35  0       pppoe_0_0_35    ppp0            PPPoE   Disable Disable Connected       189.11.110.57"
				
				};
			
				public static String sHubDLinkPing[] =	{
					" > ping www.uol.com.br",
					"PING homeuol.ipv6uol.com.br (200.147.67.142): 56 data bytes",
					"56 bytes from 200.147.67.142: icmp_seq=0 ttl=247 time=34.0 ms",
					"56 bytes from 200.147.67.142: icmp_seq=1 ttl=246 time=33.0 ms",
					"56 bytes from 200.147.67.142: icmp_seq=2 ttl=246 time=35.2 ms",
					"56 bytes from 200.147.67.142: icmp_seq=3 ttl=246 time=34.1 ms",
					"",
					"--- homeuol.ipv6uol.com.br ping statistics ---",
					"4 packets transmitted, 4 packets received, 0% packet loss",
					"round-trip min/avg/max = 33.0/34.0/35.2 ms"
				};

				// informa tamanho dos vetores
				public int iHubDLinkStatus = sHubDLinkStatus.length;
				public int iHubDLinkAuth = sHubDLinkAuth.length;
				public int iHubDLinkPing = sHubDLinkPing.length;
				
				public static String sHubDLinkStatusDN[] =	{
					" > adsl info --stats",
					"adsl: ADSL driver and PHY status",
					"Status: Idle",
					"Retrain Reason: 0",
					"",
					"Link Power State:       LO",
					"Total time = 11 min 45 sec",
					"FEC:            0               0",
					"CRC:            0               0",
					"ES:             0               0",
					"SES:            0               0",
					"UAS:          328             328",
					"LOS:            0               0",
					"LOF:            0               0",
					"Latest 15 minutes time = 5 min 45 sec",
					"FEC:            0               0",
					"CRC:            0               0",
					"ES:             0               0",
					"SES:            0               0",
					"UAS:          328             328",
					"LOS:            0               0",
					"LOF:            0               0",
					"Previous 15 minutes time = 0 sec",
					"FEC:            0               0",
					"CRC:            0               0",
					"ES:             0               0",
					"SES:            0               0",
					"UAS:          328             328",
					"LOS:            0               0",
					"LOF:            0               0",
					"Latest 1 day time = 5 min 45 sec",
					"FEC:            0               0",
					"CRC:            0               0",
					"ES:             0               0",
					"SES:            0               0",
					"UAS:          328             328",
					"LOS:            0               0",
					"LOF:            0               0",
					"Previous 1 day time = 0 sec",
					"FEC:            0               0",
					"CRC:            0               0",
					"ES:             0               0",
					"SES:            0               0",
					"UAS:          328               0",
					"LOS:            0               0",
					"LOF:            0               0",
					"Since Link time = 4 min 45 sec",
					"FEC:            0               0",
					"CRC:            0               0",
					"ES:             0               0",
					"SES:            0               0",
					"UAS:          328               0",
					"LOS:            0               0",
					"LOF:            0               0",
					" >"
					};
				
					public static String sHubDLinkAuthDN[] =	{
						"> wan show 0.0.35",
						"VCC     Con.    Service         Interface       Proto.  IGMP    MLD     Status          IP",
						"        ID      Name            Name                                                    address",
						"0.0.35  0       pppoe_0_0_35    ppp0            PPPoE   Disable Disable Unconfigured    200.181.230.54"
					
					};
				
					public static String sHubDLinkPingDN[] =	{
						" > ping www.uol.com.br",
						"PING homeuol.ipv6uol.com.br (200.147.67.142): 56 data bytes",					
						"",
						"--- homeuol.ipv6uol.com.br ping statistics ---",
						"4 packets transmitted, 0 packets received, 100% packet loss"						
					};

					// informa tamanho dos vetores
					public int iHubDLinkStatusDN = sHubDLinkStatusDN.length;
					public int iHubDLinkAuthDN = sHubDLinkAuthDN.length;
					public int iHubDLinkPingDN = sHubDLinkPingDN.length;
		
				/*****************************************************************************/
	        	

    
    

}
