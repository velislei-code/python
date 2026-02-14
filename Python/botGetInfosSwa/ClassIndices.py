"""
by: Treuk, Velislei A
email: velislei@gmail.com
Copyright(c) Fev/2026
All Rights Reserveds    
Uso exclusivo para estudantes de código
"""
from typing import Final

class myIdx:
    # Lista de Indices de endereçamento de posições(Fixas)

    noJumpLin: Final = 0           # Add 1 Linha(extra-pra separa logs) antes
    addJumpLin: Final = 1          # Se Add Lin 
    DEBBUG: Final = 1
    ZOOM: Final = 7                # Tamanho do Zoom no Texto do Moba
    ItvalZoom: Final = 0.1           # Velocidade ao app Zoom
    SpeedARRASTE: Final = 0.05     # Velocidade de clickArreste do Mouse entre Pto inicial e final 
    numCOLS: Final = 100           # Num de colunas a pegar no arrasteCopy

    numCOLS: Final = 100           # Num de colunas a pegar no arrasteCopy
    totRegAna: Final = 20  # Total de registros a analisar(IPD/VPN, Pendentes) p/ sequencia


    """
    # Paths qdo uso PC-Home
    ajtPASTE: Final = 339   # Teste PC Iury() no notepad++ -> ajusta em: Paste

    pcTEL: Final = False  # Comuta Dir config.ini entre notebook Tel e PC do Iury
    penImportSAE: Final = 'F:/Projetos/Python/botGetInfosSwa/PENDENCIAS.csv'
    infosSwaPyToPhp: Final = 'F:/Projetos/Python/botGetInfosSwa/infosSwatemp.txt'
    dadosTktPhpToPy: Final = 'F:/Projetos/Python/botGetInfosSwa/dadosTickettemp.csv'
    analiseSaePyToPhp: Final = 'F:/Projetos/Python/botGetInfosSwa/pendenanalise.txt'
    """

    # Path´s p/ noteBook Tel
    ajtPASTE: Final = 496   # Producao no NOTEBook(-496) no notepad++ -> ajusta em: Paste
    #ajtPASTE: Final = 559   # Teste nOTE(-559) no notepad++ -> ajusta em: Paste

    pcTEL: Final = True  # Comuta Dir config.ini entre notebook Tel e PC do Iury
    penImportSAE: Final = 'C:/wamp64/www/rd2r3/Robos/transfers/PENDENCIAS.csv'
    infosSwaPyToPhp: Final = 'C:/wamp64/www/rd2r3/Robos/transfers/infosSwaRascunho_temp.txt'
    infosSwaPyToPhpFmt: Final = 'C:/wamp64/www/rd2r3/Robos/transfers/infosSwa_temp.txt'
    dadosTktPhpToPy: Final = 'C:/wamp64/www/rd2r3/Robos/transfers/dadosTicket_temp.csv'
    analiseSaePyToPhp: Final = 'C:/wamp64/www/rd2r3/Robos/transfers/penden_analise.txt'
    arqVarsINI: Final = 'C:/wamp64/www/rd2r3/Robos/configs/varsGetInfos.ini'


    # Arquivo.ini
    iniRST: Final = 0
    iniID: Final = 1
    iniPDT: Final = 2
    iniEDD: Final = 3
    iniUF: Final = 4
    iniNmSWA: Final = 5
    iniIpSWA: Final = 6
    iniNmRA: Final = 7
    iniPtRA: Final = 8
    iniGVLAN: Final = 9
    iniSVLAN: Final = 10
    iniHL5G: Final = 11
    iniIpHL5G: Final = 12


    # Endereço Celula DadosTicket.csv -> C:\wamp64\www\rd2r3\Robos\transfers\dadosTickettemp.CSV
    # 00-2073683	
    # 01-IPD	
    # 02-ENERGISA 
    # 03-m-br-to-pmj-pmq-swa-01
    # 04-ERB	
    # 05-m-br-to-pmj-pmq-swt-014	
    # 06-172.28.193.144	
    # 07-10M	
    # 08-2723	
    # 09-105	
    # 10-DM4050	
    # 11-0/6/0/28	
    # 12-9567/25
    # 13-to	
    # 14-i-br-to-pmj-pmj-rai-01
    # 15-

    # 0	        1	2	     3	        4	5	6	7	8	9	10	11	12	13
    # 2073885	IPD	SHOPPING fly-swa-01	ERB			1G					0	go


    csvID: Final = 0           # USA EM RoboCadFlow
    csvPDT: Final = int(1)           # USA EM RoboCadFlow
    csvCLIENTE: Final = 2      # USA EM RoboCadFlow
    csvSWA: Final = 3          # USA EM RoboCadFlow
    csvOPER: Final = 4            # USA EM RoboAlocPorta -> ERB/VTAL/IGN
    csvSWT: Final = 5          # USA EM RoboCadFlow
    csvIPSWT: Final = 6        # USA EM RoboCadFlow
    csvSPEED: Final = 7        # USA EM RoboCadFlow/AlocPorta
    csvSVLAN: Final = 8           # USA EM RoboAlocPorta
    csvCVLAN: Final = 9        # USA EM RoboCadFlow/AlocPorta
    csvEDD: Final = 10        # So uso aqui
    csvPtRA: Final = 11        # NAO USA aqui
    csvATP: Final = 12        # NAO USA aqui
    csvUF: Final = 13        # So uso aqui - Checkar se SWA esta correto
    csvNmRA: Final = 14         # So usa aqui
    csvNmHL5G: Final = 15       # So usa aqui


    NULL: Final = "Null"   # Retorno nulo(caso nao ache dados)

    TACACS: Final = 0
    CISCO: Final = 1
    HUAWEI: Final = 2
    JUNIPER: Final = 3
    NOKIA: Final = 4

    UND: Final = 0         # TIPO DE CHECK CONFIGS-UNIDADE, CMD A CMD
    LOTE: Final = 1        # LOTE DE CMDS


    NAME: Final = 2        # Tipo de dados analisados
    UF: Final = 3          # Tipo de dados analisados
    ESTACAO: Final = 4     # Tipo de dados analisados
    SWA: Final = 5  
    IP: Final = 6          # Tipo de dados analisados
    RA: Final = 7          # Tipo de dados analisados
    PTRA: Final = 8        # Tipo de dados analisados
    GVLAN: Final = 9       # Tipo de dados analisados
    SVLAN: Final = 10      # Tipo de dados analisados
    CVLAN: Final = 11      # Tipo de dados analisados
    HL5G: Final = 12       # Tipo de dados analisados
    IPHL5G: Final = 13       # Tipo de dados analisados
    PWID: Final = 14       # Tipo de dados analisados - pw-id(41+sVlan, 43+sVlan)

    RST: Final = 0          # zERAR, lIMPAR
    START: Final = 1        # oPCAO DE ENTRADA, INICIALIZAÇÃO
    JOB: Final = 2          # Em trabalho
    
    CLEAR: Final = 'w'    # Tipo de manipulação de arquivo txt, limpar td, ou adicionar linhas
    ADD: Final = 'a'
    
    largCharPx: Final = 15   # largura do caracter em pixels
    altLinPx: Final = 25   # num pixels por linha

    # Rotas dentro de while - usado p/ autmomatizar sequencia de acessos
    MANUAL: Final = 0  # nECESSARIO INFORMAR POIS APÓS INICIAR ELE ENTRA EM MODO AUTO MM SENDO MAUAL
    AUTO: Final = 1
    USER: Final = 2        # QUEM CHAMOU A FUNCAO(uSUARIO, VIA MENU(AUTO/MANUAL) ou Alanise de lista ImportSAE        
    ANALISE: Final = 3     # * DEVE SEGUIR A SEQUENCIA MANUAL, aUTO, POIS ESTAO ATRELADOS

    rtMENU: Final = 0
    rtCatDEV: Final = 1
    rtLgSWA: Final = 2
    rtCltSWA: Final = 3
    rtLgRA: Final = 4
    rtCltRA: Final = 5

