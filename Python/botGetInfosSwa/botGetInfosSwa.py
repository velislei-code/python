"""
by: Treuk, Velislei A
email: velislei@gmail.com
Copyright(c) 2025-2026
All Rights Reserveds    
Uso exclusivo para estudantes de código
"""
import time
import configparser
import pyperclip

import sys
from typing import Final
import keyboard # usar tecla <esc> para interromper processo

# Carregar Classes
from ClassIndices import myIdx  # Importando a classe
from ClassArquivos import Arquivos  # Importando a classe
from ClassAnaliseSsh import AnaliseSsh  # Importando a classe
from ClassWindow import Windows  # Importando a classe
from ClassTools import Tools  # Importando a classe
from ClassBot import Bots  # Importando a classe
from ClassMobaTerm import Terminal  # Importando a classe

# Instancia a classe
objArquivos = Arquivos()
objAnaliseSsh = AnaliseSsh()
objTools = Tools()
objBots = Bots()
objTerminal = Terminal()
objWindows = Windows()

# Chama método de instância
# objArquivos.carregar()          # Saída: Carregando...

# Acessa atributo de instância
# print(objArquivos.dados)        # Saída: []

# ------------------------------------------------------------------- #
# Inicializa var
IdOrdem = None
Produto = None
nomeSwa = None
modeloEDD = None



varGblID =  ""
varGblIpdVpn =  ""
varGblModEDD =  ""                 
varGblUF = ""
varGbl_NomeSWA = ""
varGblNomeSwa = ""
varGblIpSwa = ""
varGblNomeRa = ""
varGblNumPtRa = ""
varGblNumGVlan = ""
varGblNumSVlan = ""
varGblNomeHL5g = ""
varGblIpHL5g = ""
foundTunnelGlobal = ""
    


def clear():
    # ZERA TODAS AS VARS/arquivos 
    # objArquivos.gravarVarsIni(myIdx.RST, myIdx.arqVarsINI, siglaUF='', nomeSWA='', ipSWA='', nomeRA='',  numPtRA='', numGVLAN='', numSVLAN='', nomeHL5G='')    
    objArquivos.gravarVars1a1Ini(myIdx.arqVarsINI, myIdx.CLEAR, myIdx.iniRST, '')     # rESETAR
    objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.CLEAR, '')   
    varGbl_NomeIpSWA = ""
    varGblNomeSwa = ""
    varGblIpSwa = ""
    varGblNomeRa = ""
    varGblNumPtRa = ""
    varGblNumGVlan = ""
    varGblNumSVlan = ""
    varGblNomeHL5g = ""
    varGblIpHL5g = ""
    foundTunnelGlobal = ""  


   

#---------------------------------------------------------------------------------------------------------------#
def main():


    objTools.debbug(myIdx.addJumpLin, 'main()')
    
    # Posiciona a janela/define tamanho
    objWindows.posicionar_janela(3300, 30, 55, 15)

    # Ajusta tamJanela(Larg/Alt)
    objWindows.janela(65, 20)
    objWindows.cores()
    objWindows.limpar(20)
    objWindows.logo()


 
    config = configparser.ConfigParser()
    #config.read('config.ini')
    if myIdx.pcTEL:  # noteBook TEL
        config.read(r'C:\wamp64\www\rd2r3\Robos\configs\getInfosSwa.ini')
    else:  # PC Iury
        config.read(r'F:\Projetos\Python\botGetInfosSwa\getInfosSwa.ini')
 
    # Tempos
    # tCopyPag = float(config['TEMPOS']['tCopyPag']) # tempo para copiar dados da página(clicks)
    tFast = float(config['TEMPOS']['tFast'])
    tCmd = float(config['TEMPOS']['tCmd'])
    tLogar = float(config['TEMPOS']['tLogar'])
   
    # msg = float(config['CONFIG']['msg'])
    desviaBugsLogar = int(config['CONFIG']['desviaBugsLogar'])        # Aqui tive de criar 2 tipos de Desvia Bugs, pois ocorrem diferentes
    desviaBugsCmd = int(config['CONFIG']['desviaBugsCmd'])
    icoAppGetInfosSwaX = int(config['CONFIG']['icoAppGetInfosSwaX'])  # habilita copiar instancia do processo(da Flow->Pagina)
    icoAppGetInfosSwaY = int(config['CONFIG']['icoAppGetInfosSwaY'])  # habilita copiar instancia do processo(da Flow->Pagina)
    pwLog = str(config['CONFIG']['pwLog']) 

    icoMobaX = int(config['MOBA']['icoMobaX'])
    icoMobaY = int(config['MOBA']['icoMobaY'])
    janMobaX = int(config['MOBA']['janMobaX'])
    janMobaY = int(config['MOBA']['janMobaY'])
    abaMoba2X = int(config['MOBA']['abaMoba2X'])
    abaMoba2Y = int(config['MOBA']['abaMoba2Y'])
    abaMoba3X = int(config['MOBA']['abaMoba3X'])
    abaMoba3Y = int(config['MOBA']['abaMoba3Y'])
    folhaMobaX = int(config['MOBA']['folhaMobaX'])    # campo de digitação
    folhaMobaY = int(config['MOBA']['folhaMobaY'])
    nEnter = int(config['MOBA']['nEnter'])

    # Posições X,Y quadro Copiar texto-teste-IP-Moba(Copy&arraste)
    posIniArrasteCopyX = int(config['MOBA']['posIniArrasteCopyX'])
    posIniArrasteCopyY = int(config['MOBA']['posIniArrasteCopyY'])
   
    # Pagina-Php
    PhpTaRascunhoX = int(config['PHP']['PhpTaRascunhoX'])
    PhpTaRascunhoY = int(config['PHP']['PhpTaRascunhoY'])
    PhpBtnSalvarX = int(config['PHP']['PhpBtnSalvarX'])
    PhpBtnSalvarY = int(config['PHP']['PhpBtnSalvarY'])
  
    varGbl_NomeIpSWA = ""
    varGblID =  ""
    varGblIpdVpn =  ""
    varGblModEDD =  ""                 
    varGblUF = ""
    varGbl_NomeSWA = ""
    varGblNomeSwa = ""
    varGblIpSwa = ""
    varGblNomeRa = ""
    varGblNumPtRa = ""
    varGblNumGVlan = ""
    varGblNumSVlan = ""
    varGblNomeHL5g = ""
    varGblIpHL5g = ""
    foundTunnelGlobal = ""

    # clear()     # SO ZERAR PELO PHH - Zera todas as vars e arquivos
    
    modo = myIdx.MANUAL
    rtCorrente = myIdx.rtMENU 
    
    # dados[myIdx.csvID] = linDadosTicket[myIdx.csvID]
    # dados[myIdx.csvPDT] = linDadosTicket[myIdx.csvPDT]

    # cellTkt = getDadosTkt()      
    # Testes -> cellTkt = [{'"','"','"','"','"','"','"','"','"','"','"','"','"','"','"'}]      
    # objArquivos.gravarVarsIni(myIdx.START, myIdx.arqVarsINI, siglaUF = varGblUF, nomeSWA=varGblNomeSwa, ipSWA=varGblIpSwa, nomeRA=varGblNomeRa,  numPtRA=varGblNumPtRa, numGVLAN=varGblNumGVlan, numSVLAN=varGblNumSVlan, nomeHL5G=varGblNomeHL5g)
   
    
    varIni = objArquivos.lerVarsIni() 
    
    varGblID =  varIni[myIdx.iniID]
    varGblIpdVpn =  varIni[myIdx.iniPDT]
    varGblModEDD =  varIni[myIdx.iniEDD]                  
    varGblUF = varIni[myIdx.iniUF] #str(varGblUF)
    varGblNomeSwa = varIni[myIdx.iniNmSWA] #str(csvNmSwa)
    
    varLocalUF = str(varIni[myIdx.iniUF].upper())
    print('UF(php): |'+varLocalUF+'|')
    
    # Validação nome-SWA, gravar Var iniciais tranfer do Php
    print(f'Lendo nomeSwa de tranfer.csv(Php->To->Py) {varGblUF} -> {varGblNomeSwa}')     
    # Block -> objArquivos.gravarVarsIni(myIdx.START, myIdx.arqVarsINI, siglaUF = varGblUF, nomeSWA=varGblNomeSwa, ipSWA=varGblIpSwa, nomeRA=varGblNomeRa,  numPtRA=varGblNumPtRa, numGVLAN=varGblNumGVlan, numSVLAN=varGblNumSVlan, nomeHL5G=varGblNomeHL5g)
    # -> esta dando unknow no swa -> objArquivos.gravarVars1a1Ini(myIdx.arqVarsINI, myIdx.CLEAR, myIdx.iniRST, varGblUF)     # rESETAR
            
        
    while True: 
        
        pyperclip.copy('')  # Limpa ClipBoard

        try: 
            if modo != myIdx.ANALISE:    # em analise desvia, pois não usa(evita erros)
            # ----------------------------------------------------------------------------------------------------------------- #
                # -------------------- Ini-Carga/Check de dados ../transfer.csv, ../transfer.txt ----------------------------- #
                
                varIni = objArquivos.lerVarsIni()   

                if not objTools.validar(varGblNomeSwa, myIdx.SWA):                                        # Valida...Se var global NAO e valida...
                    varGblNomeSwa = varIni[myIdx.iniNmSWA]
         
                # Validação nome-SWA
                if not objTools.validar(varGblNomeSwa, myIdx.SWA):                                        # Valida...Se var global NAO e valida...
                    varGblNomeSwa = varIni[myIdx.iniNmSWA]
                
                # Validação ip-SWA
                if not objTools.validar(varGblIpSwa, myIdx.IP):                                           # Valida...Se var global NAO e valida...
                    varGblIpSwa = varIni[myIdx.iniIpSWA]
         
                # Validação nome-RA
                if not objTools.validar(varGblNomeRa, myIdx.RA):                                          # Valida...Se var global NAO e valida...
                    varGblNomeRa = varIni[myIdx.iniNmRA]
                
                # Validação pt-RA
                if not objTools.validar(varGblNumPtRa, myIdx.PTRA):                                       # Valida...Se var global NAO e valida...
                    varGblNumPtRa = varIni[myIdx.iniPtRA]
         
                # Validação GVLAN
                if not objTools.validar(varGblNumGVlan, myIdx.GVLAN):                                       # Valida...Se var global NAO e valida...
                    varGblNumGVlan = varIni[myIdx.iniGVLAN]
                
                # Validação SVLAN
                if not objTools.validar(varGblNumSVlan, myIdx.SVLAN):                                       # Valida...Se var global NAO e valida...
                    varGblNumSVlan = varIni[myIdx.iniSVLAN]
         
                # Validação HL5G
                if not objTools.validar(varGblNomeHL5g, myIdx.HL5G):                                       # Valida...Se var global NAO e valida...
                    varGblNomeHL5g  = varIni[myIdx.iniHL5G]
                
                """
                # Essa linha da bugs - Se necessario...Use outra forma
                foundTunnelGlobal = objAnaliseSsh.ler_infosArqTransferPhp('caminho_arquivo', 'Id:')  # melhor usar o nome, pega melhores infos do Rsd
                if str(foundTunnelGlobal) in "":
                    foundTunnelGlobal = "None"
                """    
                      
                # -------------------- Fim-Carga/Check de dados ../transfer.csv, ../transfer.txt ----------------------------- #

        #except Exception:
        except Exception as e:
            print(f"Exception main().while->lin262:  {e}")
            stp = input("Erro! Causa: dadosTicket_temp.csv sem dados. <E> | <S>air" )
            if stp == 'S' or stp == 's':
                sys.exit()



        objBots.mover_e_clicar('Unknown', icoAppGetInfosSwaX, icoAppGetInfosSwaY) # Chama app-tras para tela app

        # Menu de opções 
        # limpar(20)
        # logo()
        objBots.mover_e_clicar('Unknown', icoAppGetInfosSwaX, icoAppGetInfosSwaY)   # auto-Click no proprio Ico-app-cad.flow
        time.sleep(tFast) 
            
        print(" ")
        print("     I: Infos, tds as clt")        
        print("     D: Clt Device")        
        print("     LS: Logar no Swa")        
        print("     CS: Consultar Dados SWA")   
        print("     LR: Logar no RSD")        
        print("     CR: Consultar Tunnel RSD")      
        print("     CL: Consultar Dados(em Lote)")        
        print("     LC: Logar, Consultar")        
        print("     LCL: Logar, Consultar(Lote)")        
        print("     CP: Copiar tela")        
        print("     Z+, Z-: Zoom")        
        print("     CLR: zera transfers.txt")        
        print("     DB0, DB1: set Desviar Bugs(0 ou 1)")        
        print("     S: Sair ") 


        #try:
        # --------------------------------------------------------------------------------------------------- #    
        varIni = objArquivos.lerVarsIni()   
        varGblNomeSwa = varIni[myIdx.iniNmSWA]
        varGblIpSwa = varIni[myIdx.iniIpSWA]
        varGblNomeRa = varIni[myIdx.iniNmRA]
        varGblNumPtRa = varIni[myIdx.iniPtRA]
        varGblNumGVlan = varIni[myIdx.iniGVLAN]
        varGblNumSVlan = varIni[myIdx.iniSVLAN]
        varGblNomeHL5g = varIni[myIdx.iniHL5G]
        # varGblIpHL5g = varIni[myIdx.iniIpHL5G]
      
        print("")
        print("../tranfer/dadosTicket_temp.csv (Php->Py)")
        print("../tranfer/infosSwa_temp.txt    (Py->Php)")
        print("")
        print("ERB: " + str(varGblUF)+', '+str(varGblNomeSwa))
        print("SWA: " + str(varGblNomeSwa))
        print("RA: " + str(varGblNomeRa))
        print("PtRA: " + str(varGblNumPtRa))
        print("gVLAN: " + str(varGblNumGVlan))
        print("sVLAN: " + str(varGblNumSVlan))
        print("HL5G: " + str(varGblNomeHL5g))
        print("IpHL5G: " + str(varGblIpHL5g))
        print("Tunnel: " + str(foundTunnelGlobal))

        # se rota Corrente = MENU...para p/ opção...se for outra passa direto e executa rotas
        if rtCorrente == myIdx.rtMENU:
            mnOpcao = input("Informe a opcao> ")                       
            if mnOpcao == 'ANL' or mnOpcao == 'anl':  modo = myIdx.ANALISE        # cat deviceList...          
            if mnOpcao == 'D' or mnOpcao == 'd':  modo = myIdx.MANUAL        # cat deviceList...          
            if mnOpcao == 'LS' or mnOpcao == 'ls':  modo = myIdx.MANUAL      # Logar swa            
            if mnOpcao == 'CS' or mnOpcao == 'cs':  modo = myIdx.MANUAL      # Consultar swa           
            if mnOpcao == 'LR' or mnOpcao == 'lr':  modo = myIdx.MANUAL      # Logar RA           
            if mnOpcao == 'CR' or mnOpcao == 'cr':  modo = myIdx.MANUAL      # Consultar RA
            if mnOpcao == 'CRM' or mnOpcao == 'crm':  modo = myIdx.MANUAL      # Copiar Consulta manual de  RA
            if mnOpcao == 'A' or mnOpcao == 'a':    # aciona rotas automaticas, sequencia de acessos/consultas
                rtCorrente = myIdx.rtCatDEV              # mantem mesma rota   
                modo = myIdx.AUTO                        # P´RECISA INFORMAR POIS APÓS ENTRA EM 'D' ELE ENTRA EM MODO AUTO  
            
        # ------------------------ INI DA SEQUENCIA PADRÃO ---------------------------------------------------------------------------- #
        # OS IF´s DEVEM FICAR EM ORDEM DECRESCENTE P/ FUNCIONAR CORRETAMENT(Passar pelo Topo-Clt tranfre.txt) antes de retornar as rotas 
        # IF...
        # 5 - Consultar RA 
        # 4 - Logar RA 
        # 3 - Consultar SWA 
        # 2 - Logar SWA 
        # 1 - Consultar cat deviceList...
        
        if mnOpcao == 'CR' or mnOpcao == 'cr'  or rtCorrente == myIdx.rtCltRA:   # Consulta RSD 
            # ----------------------- Recuperar Vars ----------------------------------------------------------- #
            varIni = objArquivos.lerVarsIni()                
            # Validação nome-SWA
            if not objTools.validar(varGblNomeSwa, myIdx.SWA):                                        # Valida...Se var global NAO e valida...
                varGblNomeSwa = varIni[myIdx.iniNmSWA]
            # Validação ip-SWA
            if not objTools.validar(varGblIpSwa, myIdx.IP):                                           # Valida...Se var global NAO e valida...
                varGblIpSwa = varIni[myIdx.iniIpSWA]
            # Validação nome-RA
            if not objTools.validar(varGblNomeRa, myIdx.RA):                                          # Valida...Se var global NAO e valida...
                varGblNomeRa = varIni[myIdx.iniNmRA]            
            # Validação pt-RA
            if not objTools.validar(varGblNumPtRa, myIdx.PTRA):                                       # Valida...Se var global NAO e valida...
                varGblNumPtRa = varIni[myIdx.iniPtRA]    
            # Validação GVLAN
            if not objTools.validar(varGblNumGVlan, myIdx.GVLAN):                                       # Valida...Se var global NAO e valida...
                varGblNumGVlan = varIni[myIdx.iniGVLAN]            
            # Validação SVLAN
            if not objTools.validar(varGblNumSVlan, myIdx.SVLAN):                                       # Valida...Se var global NAO e valida...
                varGblNumSVlan =  varIni[myIdx.iniSVLAN]
            # Validação HL5G
            if not objTools.validar(varGblNomeHL5g, myIdx.HL5G):                                       # Valida...Se var global NAO e valida...
                varGblNomeHL5g =  varIni[myIdx.iniHL5G]
            
            varIni = objArquivos.lerVarsIni()   
            varGblNomeRa = varIni[myIdx.iniNmRA]
            varGblNumPtRa = varIni[myIdx.iniPtRA]
            varGblNumGVlan = varIni[myIdx.iniGVLAN]
            varGblNumSVlan = varIni[myIdx.iniSVLAN]
            varGblNomeHL5g = varIni[myIdx.iniHL5G]
            
            # ----------------------- Recuperar ----------------------------------------------------------- #
            
            if(objTools.validar(varGblNomeRa, myIdx.RA)): 
                objBots.mover_e_clicar('main().while.mnOpcao == CR', 1, 500)            
                objBots.mover_e_clicar('main().while.mnOpcao == CR', janMobaX, janMobaY)            
                objTerminal.prepararMoba('main().while.mnOpcao == CR', abaMoba2X, abaMoba2Y, nEnter, tFast)
                objAnaliseSsh.readInfosRSD(myIdx.USER, myIdx.PWID, varGblNomeRa, varGblNumPtRa, 'Null', varGblNumSVlan,  varGblIpdVpn, posIniArrasteCopyX, posIniArrasteCopyY, desviaBugsCmd, tCmd)
                if modo == myIdx.AUTO: rtCorrente = myIdx.rtMENU   # finalizado...roteia p/ Menu
                else: rtCorrente = myIdx.rtMENU   # myIdx.MANUAL finalizado...roteia p/ Menu    
                #sys.exit()
            else:
                print("RA não validou! Tentando novamente...")
                objBots.mover_e_clicar('main().while.mnOpcao == CR', 1, 500)            
                objBots.mover_e_clicar('main().while.mnOpcao == CR', janMobaX, janMobaY)            
                objTerminal.prepararMoba('main().while.mnOpcao == CR', abaMoba2X, abaMoba2Y, nEnter, tFast)
                objAnaliseSsh.readInfosRSD(myIdx.USER, myIdx.PWID, varGblNomeRa, varGblNumPtRa, 'Null', varGblNumSVlan,  varGblIpdVpn, posIniArrasteCopyX, posIniArrasteCopyY, desviaBugsCmd, tCmd)
                if modo == myIdx.AUTO: rtCorrente = myIdx.rtMENU   # finalizado...roteia p/ Menu
                else: rtCorrente = myIdx.rtMENU   # myIdx.MANUAL finalizado...roteia p/ Menu    
                #sys.exit()
            """
            else:
                print("RA não validou!Tentando novamente...")
                if modo == myIdx.AUTO: rtCorrente = myIdx.rtCltRA   # mantem mesma rota
                else: rtCorrente = myIdx.rtMENU   # myIdx.MANUAL finalizado...roteia p/ Menu    
            """
            objArquivos.formatarInfosSwaRa() # Finaliza, formantando infos, para ser lida no Php

            # <Esc> Interrompe processo(5* 0.2 = 1.0)
            for i in range(5):
                time.sleep(tFast)  # 0.2 * 35 = 7seg(Máx)       
                if keyboard.is_pressed('esc'):
                    stop = input("Break for user. Continue?<E>")

        # Em caso de falha na Consulta Automatica ao SWA/RSD, da pra fazer manual e copiar p/ relatorio por aqui 
        if mnOpcao == 'CP' or mnOpcao == 'cp'  or rtCorrente == myIdx.rtCltRA:   # Copy-Consulta SWA/RSD            
            objBots.mover_e_clicar('main().while.mnOpcao == CP', 1, 500)            
            objBots.mover_e_clicar('main().while.mnOpcao == CP', janMobaX, janMobaY)            
            objTerminal.prepararMoba('main().while.mnOpcao == CP', abaMoba2X, abaMoba2Y, nEnter, tFast)
            objAnaliseSsh.printScreen(posIniArrasteCopyX, posIniArrasteCopyY, tCmd)
        

        if mnOpcao == 'LR' or mnOpcao == 'lr'  or rtCorrente == myIdx.rtLgRA:    # So logar no RSD 
            # ----------------------- Recuperar ----------------------------------------------------------- #
            varIni = objArquivos.lerVarsIni()                
            # Validação nome-SWA
            if not objTools.validar(varGblNomeSwa, myIdx.SWA):                                        # Valida...Se var global NAO e valida...
                varGblNomeSwa = varIni[myIdx.iniNmSWA]
            # Validação ip-SWA
            if not objTools.validar(varGblIpSwa, myIdx.IP):                                           # Valida...Se var global NAO e valida...
                varGblIpSwa = varIni[myIdx.iniIpSWA]
            # Validação nome-RA
            if not objTools.validar(varGblNomeRa, myIdx.RA):                                          # Valida...Se var global NAO e valida...
                varGblNomeRa = varIni[myIdx.iniNmRA]            
            # Validação pt-RA
            if not objTools.validar(varGblNumPtRa, myIdx.PTRA):                                       # Valida...Se var global NAO e valida...
                varGblNumPtRa = varIni[myIdx.iniPtRA]    
            # Validação GVLAN
            if not objTools.validar(varGblNumGVlan, myIdx.GVLAN):                                       # Valida...Se var global NAO e valida...
                varGblNumGVlan = varIni[myIdx.iniGVLAN]            
            # Validação SVLAN
            if not objTools.validar(varGblNumSVlan, myIdx.SVLAN):                                       # Valida...Se var global NAO e valida...
                varGblNumSVlan =  varIni[myIdx.iniSVLAN]
            # Validação HL5G
            if not objTools.validar(varGblNomeHL5g, myIdx.HL5G):                                       # Valida...Se var global NAO e valida...
                varGblNomeHL5g =  varIni[myIdx.iniHL5G]
            
            varIni = objArquivos.lerVarsIni()   
            varGblNomeRa = str(varIni[myIdx.iniNmRA])           
            # ----------------------- Recuperar ----------------------------------------------------------- #
                       
            if(objTools.validar(varGblNomeRa, myIdx.RA)):   
                objBots.mover_e_clicar('main().while.mnOpcao == LR', 1, 500)            
                objBots.mover_e_clicar('main().while.mnOpcao == LR', janMobaX, janMobaY)            
                objTerminal.prepararMoba('main().while.mnOpcao == LR', abaMoba2X, abaMoba2Y, nEnter, tFast)
                objBots.logar(varGblNomeRa, pwLog, folhaMobaX, folhaMobaY, posIniArrasteCopyX, posIniArrasteCopyY,  tFast, tLogar, desviaBugsLogar, icoAppGetInfosSwaX, icoAppGetInfosSwaY)
                if modo == myIdx.AUTO: rtCorrente = myIdx.rtCltRA   # roteia p/ proximo
                else: rtCorrente = myIdx.rtMENU   # myIdx.MANUAL finalizado...roteia p/ Menu 
            else:
                print("RA não validou! Continuando...")           
                objBots.mover_e_clicar('main().while.mnOpcao == LR', 1, 500)            
                objBots.mover_e_clicar('main().while.mnOpcao == LR', janMobaX, janMobaY)            
                objTerminal.prepararMoba('main().while.mnOpcao == LR', abaMoba2X, abaMoba2Y, nEnter, tFast)
                objBots.logar(varGblNomeRa, pwLog, folhaMobaX, folhaMobaY, posIniArrasteCopyX, posIniArrasteCopyY,  tFast, tLogar, desviaBugsLogar, icoAppGetInfosSwaX, icoAppGetInfosSwaY)
                if modo == myIdx.AUTO: rtCorrente = myIdx.rtCltRA   # roteia p/ proximo
                else: rtCorrente = myIdx.rtMENU   # myIdx.MANUAL finalizado...roteia p/ Menu 
            
            
            """
            else:
                stop = input("RA não localizado! Continue?<E>")           
                if modo == myIdx.AUTO: rtCorrente = myIdx.rtLgRA   # mantem mesma rota
                else: rtCorrente = myIdx.rtMENU   # myIdx.MANUAL finalizado...roteia p/ Menu 
            """
            # <Esc> Interrompe processo(5* 0.2 = 1.0)
            for i in range(15):
                time.sleep(tFast)  # 0.2 * 35 = 7seg(Máx)       
                if keyboard.is_pressed('alt'): break    # acelera, sai do loop                   
                if keyboard.is_pressed('esc'):
                    stop = input("Break for user. Continue?<E>")           
        


        if mnOpcao == 'CS' or mnOpcao == 'cs' or rtCorrente == myIdx.rtCltSWA:    # Consulta SWA
            # ----------------------- Recuperar ----------------------------------------------------------- #
            varIni = objArquivos.lerVarsIni()                
            # Validação nome-SWA
            if not objTools.validar(varGblNomeSwa, myIdx.SWA):                                        # Valida...Se var global NAO e valida...
                varGblNomeSwa = varIni[myIdx.iniNmSWA]
            # Validação ip-SWA
            if not objTools.validar(varGblIpSwa, myIdx.IP):                                           # Valida...Se var global NAO e valida...
                varGblIpSwa = varIni[myIdx.iniIpSWA]
            # Validação nome-RA
            if not objTools.validar(varGblNomeRa, myIdx.RA):                                          # Valida...Se var global NAO e valida...
                varGblNomeRa = varIni[myIdx.iniNmRA]            
            # Validação pt-RA
            if not objTools.validar(varGblNumPtRa, myIdx.PTRA):                                       # Valida...Se var global NAO e valida...
                varGblNumPtRa = varIni[myIdx.iniPtRA]    
            # Validação GVLAN
            if not objTools.validar(varGblNumGVlan, myIdx.GVLAN):                                       # Valida...Se var global NAO e valida...
                varGblNumGVlan = varIni[myIdx.iniGVLAN]            
            # Validação SVLAN
            if not objTools.validar(varGblNumSVlan, myIdx.SVLAN):                                       # Valida...Se var global NAO e valida...
                varGblNumSVlan =  varIni[myIdx.iniSVLAN]
            # Validação HL5G
            if not objTools.validar(varGblNomeHL5g, myIdx.HL5G):                                       # Valida...Se var global NAO e valida...
                varGblNomeHL5g =  varIni[myIdx.iniHL5G]
            
       # ----------------------- Recuperar ----------------------------------------------------------- #
            
            if(objTools.validar(varGblNomeSwa, myIdx.SWA)):  
                objBots.mover_e_clicar('main().while.mnOpcao == CS', 1, 500)            
                objBots.mover_e_clicar('main().while.mnOpcao == CS', janMobaX, janMobaY)            
                objTerminal.prepararMoba('main().while.mnOpcao == CS', abaMoba3X, abaMoba3Y, nEnter, tFast)
                
                objTools.debbug(myIdx.noJumpLin, 'CS-> ('+str(varGbl_NomeSWA)+', '+ str(varGblNomeSwa)+', '+ str(varGblID)+', '+ str(varGblIpdVpn)+', '+ str(posIniArrasteCopyX)+', '+  str(posIniArrasteCopyY)+', '+ str(myIdx.UND)+', '+ str(desviaBugsCmd)+', '+   str(tCmd)+')')
                objTools.debbug(myIdx.noJumpLin, varGbl_NomeSWA) 
                objTools.debbug(myIdx.noJumpLin, varGblNomeSwa) 
                objTools.debbug(myIdx.noJumpLin, varGblID) 
                objTools.debbug(myIdx.noJumpLin, varGblIpdVpn) 
                objTools.debbug(myIdx.noJumpLin, str(posIniArrasteCopyX)) 
                objTools.debbug(myIdx.noJumpLin,  str(posIniArrasteCopyY)) 
                objTools.debbug(myIdx.noJumpLin, str(myIdx.UND)) 
                objTools.debbug(myIdx.noJumpLin, str(desviaBugsCmd)) 
                objTools.debbug(myIdx.noJumpLin, str(tCmd))

                objAnaliseSsh.readInfosSWA(myIdx.USER, varGbl_NomeSWA, varGblNomeSwa, varGblID, varGblIpdVpn, posIniArrasteCopyX, posIniArrasteCopyY, myIdx.UND, desviaBugsCmd, tCmd)  
                if modo == myIdx.AUTO: rtCorrente = myIdx.rtLgRA   # roteia p/ proximo
                else: rtCorrente = myIdx.rtMENU   # myIdx.MANUAL finalizado...roteia p/ Menu 

            else:
                print("Você não esta conectado ao SWA!")
                if modo == myIdx.AUTO: rtCorrente = myIdx.rtCltSWA   # mantem mesma rota
                else: rtCorrente = myIdx.rtMENU   # myIdx.MANUAL finalizado...roteia p/ Menu 


            objArquivos.formatarInfosSwaRa() # Finaliza, formantando infos, para ser lida no Php

            # <Esc> Interrompe processo(5* 0.2 = 1.0)
            for i in range(15):
                time.sleep(tFast)  # 0.2 * 35 = 7seg(Máx)  
                if keyboard.is_pressed('alt'): break    # acelera, sai do loop      
                if keyboard.is_pressed('esc'):
                    stop = input("Break for user. Continue?<E>")    

           

        if mnOpcao == 'LS' or mnOpcao == 'ls' or rtCorrente == myIdx.rtLgSWA:    # Logar no SWA 
            # ---------------------- Recuprar Vars------------------------------------------------------ #
            varIni = objArquivos.lerVarsIni()                
            # Validação nome-SWA
            if not objTools.validar(varGblNomeSwa, myIdx.SWA):                                        # Valida...Se var global NAO e valida...
                varGblNomeSwa = varIni[myIdx.iniNmSWA]
            # Validação ip-SWA
            if not objTools.validar(varGblIpSwa, myIdx.IP):                                           # Valida...Se var global NAO e valida...
                varGblIpSwa = varIni[myIdx.iniIpSWA]

            # ------------------------------------------------------------------------------------------ #
            if(objTools.validar(varGblIpSwa, myIdx.IP)):    
                objBots.mover_e_clicar('main().while.mnOpcao == LS', 1, 500)            
                objBots.mover_e_clicar('main().while.mnOpcao == LS', janMobaX, janMobaY)            
                objTerminal.prepararMoba('main().while.mnOpcao == LS', abaMoba3X, abaMoba3Y, nEnter, tFast)
                objBots.logar(varGblIpSwa, pwLog, folhaMobaX, folhaMobaY, posIniArrasteCopyX, posIniArrasteCopyY, tFast, tLogar, desviaBugsLogar, icoAppGetInfosSwaX, icoAppGetInfosSwaY)
                if modo == myIdx.AUTO: rtCorrente = myIdx.rtCltSWA   # roteia p/ proximo
                else: rtCorrente = myIdx.rtMENU   # finalizado...roteia p/ Menu
            else:
                print("SWA não localizado!")
                if modo == myIdx.AUTO: rtCorrente = myIdx.rtLgSWA   # mantem mesma rota
                else: rtCorrente = myIdx.rtMENU   # myIdx.MANUAL finalizado...roteia p/ Menu 

            # <Esc> Interrompe processo(15* 0.2 = 3.0)
            for i in range(15):
                time.sleep(tFast)  # 0.2 * 35 = 7seg(Máx)   
                if keyboard.is_pressed('alt'): break    # acelera, sai do loop     
                if keyboard.is_pressed('esc'):
                    stop = input("Break for user. Continue?<E>")


        if mnOpcao == 'D' or mnOpcao == 'd' or rtCorrente == myIdx.rtCatDEV:    # cat deviceList.... 
            # Recuperar Validação nome-SWA
            varIni = objArquivos.lerVarsIni()                
            # Validação nome-SWA
            if not objTools.validar(varGblNomeSwa, myIdx.SWA):                                        # Valida...Se var global NAO e valida...
                varGblNomeSwa = varIni[myIdx.iniNmSWA]
                      
            objBots.mover_e_clicar('main().while.mnOpcao == D', 1, 500)    
            time.sleep(tFast)         
            objBots.mover_e_clicar('main().while.mnOpcao == D', janMobaX, janMobaY)  
            time.sleep(tFast)           
            objTerminal.prepararMoba('main().while.mnOpcao == D', 1096, 151, nEnter, tFast)  # aba3
            # csvNmSwa: vem de Php->tranfer.csv XXX-swa-01
            ipSwaX = objAnaliseSsh.catDeviceList(myIdx.USER, varGblUF, varGblNomeSwa, folhaMobaX, folhaMobaY, posIniArrasteCopyX, posIniArrasteCopyY, tFast)
            print("SWA: " + str(varGblNomeSwa))
            #NomeSwaLocal = objAnaliseSsh.ler_infosArqTransferPhp('caminho_arquivo', 'nomeSWA') 
            if not objTools.validar(varGblNomeSwa, myIdx.SWA):              
                print("Erro! SWA:"+varGblNomeSwa+" inválido ou não localizado.")
                #stop = input("STOP!!! SWA:"+varGblNomeSwa+" inválido ou não localizado.")
                # iGNORA FALHA E MANDA PRA FRENTE -> if modo == myIdx.AUTO: rtCorrente = myIdx.rtCatDEV    # mantem mesma rota
                if modo == myIdx.AUTO: rtCorrente = myIdx.rtLgSWA   # roteia p/ proximo
                else: rtCorrente = myIdx.rtMENU                  # myIdx.MANUAL finalizado...roteia p/ Menu 
            else:
                if modo == myIdx.AUTO: rtCorrente = myIdx.rtLgSWA   # roteia p/ proximo
                else: rtCorrente = myIdx.rtMENU              # myIdx.MANUAL finalizado...roteia p/ Menu 

            objWindows.myToast('self', 'Tecle!', '<Alt> Acelerar\n<Esc> Stop', 'botGetInfosRouter', 5)
            # <Esc> Interrompe processo(5* 0.2 = 1.0)
            for i in range(15):
                time.sleep(tFast)  # 0.2 * 35 = 7seg(Máx)    
                if keyboard.is_pressed('alt'): break    # acelera, sai do loop    
                if keyboard.is_pressed('esc'):
                    stop = input("Break for user. Continue?<E>")


        # ------------------------ FINAL DA SEQUENCIA PADRÃO ---------------------------------------------------- #
        if mnOpcao == 'ORG' or mnOpcao == 'org':    # Limpa arq.tranferencia.txt
            objArquivos.formatarInfosSwaRa()


        if mnOpcao == 'TG' or mnOpcao == 'tg':    # Limpa arq.tranferencia.txt
            # limpar arquivo(CRIAR CABEÇARIO) txt de Transfers dados  To Php 
            print(myIdx.infosSwaPyToPhp)
            print(myIdx.CLEAR)
            print(myIdx.ADD)
            stp=input("Continue<E>")
            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.CLEAR, '\n===========================================================================================\n')  
            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'Bot getCatDevice()\n')   
            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, '{\n') 

        if mnOpcao == 'fmt' or mnOpcao == 'FMT':    # Limpa arq.tranferencia.txt
            # procura por 0-6-0-28, 0/6/0/28 ou pwe1306
            objTools.formatePorta('0-6-0-28 S')
            print(' ')
            
            objTools.formatePorta('0/6/0/28 SPACE')
            print(' ')
            
            objTools.formatePorta('pwe1306 SP')
            print(' ')
            
        if mnOpcao == 'ANL' or mnOpcao == 'anl':    # Ler arquivo
             # analisePendencias('caminho_arquivo', folhaMobaX, folhaMobaY, posIniArrasteCopyX, posIniArrasteCopyY, tFast)
             objAnaliseSsh.analisePendencias(myIdx.analiseSaePyToPhp, pwLog,  icoAppGetInfosSwaX, icoAppGetInfosSwaY, folhaMobaX, folhaMobaY, posIniArrasteCopyX, posIniArrasteCopyY, janMobaX, janMobaY, abaMoba2X, abaMoba2Y, abaMoba3X, abaMoba3Y, nEnter, tFast, tCmd, tLogar, desviaBugsLogar, desviaBugsCmd)
   
        if mnOpcao == 'TIP' or mnOpcao == 'tip':    # Ler arquivo
            ip = '0.210.171.116'
            if objTools.validar(ip, myIdx.IP):  print(ip + ' é válido')
            else:  print(ip + ' inválido')

        if mnOpcao == 'TSW' or mnOpcao == 'tsw':    # Ler arquivo
            swa = 'm-br-go-lza-lqi-swa-01'
            if objTools.validar(swa, myIdx.SWA):  print(swa + ' é válido')
            else:  print(swa + ' inválido')            

        if mnOpcao == 'TRA' or mnOpcao == 'tra':    # Ler arquivo
            ra = 'i-br-df-bsa-tco-rsd-01'
            if objTools.validar(ra, myIdx.RA):  print(ra + ' é válido')
            else:  print(ra + ' inválido')  
        
        if mnOpcao == 'TPT' or mnOpcao == 'tpt':    # Ler arquivo
            pt = 'abfhf2/1/c13/4'
            if objTools.validar(objTools.formatePorta(pt), myIdx.PTRA):
                print(pt+" valida-> "+objTools.formatePorta(pt))
            else:
                print(pt+" valida-> "+objTools.formatePorta(pt))
                
            pt = 'abc0/6/0/28'
            if objTools.validar(objTools.formatePorta(pt), myIdx.PTRA):
                print(pt+" valida-> "+objTools.formatePorta(pt))
            else:
                print(pt+" valida-> "+objTools.formatePorta(pt))

            pt = 'abpwe1034'
            if objTools.validar(objTools.formatePorta(pt), myIdx.PTRA):
                print(pt+" valida-> "+objTools.formatePorta(pt))
            else:
                print(pt+" valida-> "+objTools.formatePorta(pt))


        
        if mnOpcao == 'GCI' or mnOpcao == 'gci':    # Deviar bugs = 0
            #objArquivos.gravarVarsIni(myIdx.JOB, myIdx.arqVarsINI, siglaUF=varGblUF, nomeSWA=varGblNomeSwa, ipSWA=varGblIpSwa, nomeRA=varGblNomeRa,  numPtRA=varGblNumPtRa, numGVLAN=varGblNumGVlan, numSVLAN=varGblNumSVlan, nomeHL5G=varGblNomeHL5g)
            objArquivos.criarVarsIni(siglaUF=varGblUF, nomeSWA=varGblNomeSwa, ipSWA=varGblIpSwa, nomeRA=varGblNomeRa,  numPtRA=varGblNumPtRa, numGVLAN=varGblNumGVlan, numSVLAN=varGblNumSVlan, nomeHL5G=varGblNomeHL5g)
    
    
        if mnOpcao == 'LCI' or mnOpcao == 'lci':    # Deviar bugs = 0
            
            print("=========================================")

            print("Iniciando leitura do arquivo...")
            varIni = objArquivos.lerVarsIni()

            varGblUF = varIni[myIdx.iniUF]
            varGblNomeSwa = varIni[myIdx.iniNmSWA]
            varGblIpSwa = varIni[myIdx.iniIpSWA]
            varGblNomeRa = varIni[myIdx.iniNmRA]
            varGblNumPtRa = varIni[myIdx.iniPtRA]
            varGblNumGVlan = varIni[myIdx.iniGVLAN]
            varGblNumSVlan = varIni[myIdx.iniSVLAN]
            varGblNomeHL5g = varIni[myIdx.iniHL5G]

            print(f"\nMeu teste >->>>>>> {varGblNomeSwa}: {varGblIpSwa}")

     
            print("=========================================")

      

        if mnOpcao == 'DB0' or mnOpcao == 'db0':    # Deviar bugs = 0
            desviaBugsLogar = 0        # Aqui tive de criar 2 tipos de Desvia Bugs, pois ocorrem diferentes
            desviaBugsCmd = 0
 
        if mnOpcao == 'DB1' or mnOpcao == 'db1':    # Desviar bugs=1
            desviaBugsLogar = 1        # Aqui tive de criar 2 tipos de Desvia Bugs, pois ocorrem diferentes
            desviaBugsCmd = 1
        
        
        if mnOpcao == 'CLR' or mnOpcao == 'clr':    # Limpa arq.tranferencia.txt
            clear()
                      
        
        # Outras consultas...não possuem rotas automatizadas - so maual
        if mnOpcao == 'CL' or mnOpcao == 'cl':  # Cls em Lote de cmds(+ rapido)
            objBots.mover_e_clicar('Unknown', 1, 500)            
            objBots.mover_e_clicar('Unknown', janMobaX, janMobaY)            
            objTerminal.prepararMoba('Null', abaMoba3X, abaMoba3Y, nEnter, tFast)
            objAnaliseSsh.readInfosSWA(myIdx.USER, varGbl_NomeSWA, varGblNumSVlan, varGblID, varGblIpdVpn, posIniArrasteCopyX, posIniArrasteCopyY, myIdx.LOTE, desviaBugsCmd, tCmd)
            time.sleep(tCmd)
            sys.exit()

        if mnOpcao == 'LC' or mnOpcao == 'lc':  # Logar+Clt+Sair
            objBots.mover_e_clicar('Unknown', 1, 500)            
            objBots.mover_e_clicar('Unknown', janMobaX, janMobaY)            
            objTerminal.prepararMoba('Null', abaMoba3X, abaMoba3Y, nEnter, tFast)
            objBots.logar(nomeSwa, pwLog, folhaMobaX, folhaMobaY, posIniArrasteCopyX, posIniArrasteCopyY, tFast, tLogar, desviaBugsLogar, icoAppGetInfosSwaX, icoAppGetInfosSwaY)
            time.sleep(tCmd*3)
            objBots.mover_e_clicar('Unknown', 1, 500)            
            objBots.mover_e_clicar('Unknown', janMobaX, janMobaY)            
            objTerminal.prepararMoba('Null', abaMoba3X, abaMoba3Y, nEnter, tFast)
            objAnaliseSsh.readInfosSWA(myIdx.USER, varGbl_NomeSWA, varGblNumSVlan, varGblID, varGblIpdVpn, posIniArrasteCopyX, posIniArrasteCopyY, myIdx.UND, desviaBugsCmd, tCmd)
            time.sleep(tCmd)
            sys.exit()

        if mnOpcao == 'LCL' or mnOpcao == 'lcl':   # Logar+Clt em Lote de cmds(+ rapido)+Sair
            objBots.mover_e_clicar('Unknown', 1, 500)            
            objBots.mover_e_clicar('Unknown', janMobaX, janMobaY)            
            objTerminal.prepararMoba('Null', abaMoba3X, abaMoba3Y, nEnter, tFast)
            objBots.logar(nomeSwa, pwLog, folhaMobaX, folhaMobaY, posIniArrasteCopyX, posIniArrasteCopyY, tFast, tLogar, desviaBugsLogar, icoAppGetInfosSwaX, icoAppGetInfosSwaY)
            time.sleep(tCmd*3)
            objBots.mover_e_clicar('Unknown', 1, 500)            
            objBots.mover_e_clicar('Unknown', janMobaX, janMobaY)            
            objTerminal.prepararMoba('Null', abaMoba3X, abaMoba3Y, nEnter, tFast)
            objAnaliseSsh.readInfosSWA(myIdx.USER, varGbl_NomeSWA, varGblNumSVlan, varGblID, varGblIpdVpn, posIniArrasteCopyX, posIniArrasteCopyY, myIdx.LOTE, desviaBugsCmd, tCmd)
            time.sleep(tCmd)
            sys.exit()
        
        if mnOpcao == 'Z+' or mnOpcao == 'z+':    # So logar 
            objBots.mover_e_clicar('Unknown', 1, 500)    
            time.sleep(tFast)         
            objBots.mover_e_clicar('Unknown', janMobaX, janMobaY)  
            time.sleep(tFast)           
            objBots.mover_e_clicar('Unknown', folhaMobaX, folhaMobaY)  
            time.sleep(tFast)  
            objWindows.zoomMais(myIdx.ZOOM, intervalo=0.1)

        if mnOpcao == 'Z-' or mnOpcao == 'Z-':    # So logar 
            objBots.mover_e_clicar('Unknown', 1, 500)    
            time.sleep(tFast)         
            objBots.mover_e_clicar('Unknown', janMobaX, janMobaY)  
            time.sleep(tFast)           
            objBots.mover_e_clicar('Unknown', folhaMobaX, folhaMobaY)  
            time.sleep(tFast)              
            objWindows.zoomMenos(myIdx.ZOOM, intervalo=0.1)



        if mnOpcao == 'S' or mnOpcao == 's':
            sys.exit()
        """
        # caso de algum erro dentro do while...só avisa e continua rodando...        
        # except Exception:
        except Exception as e:
            print(f"Exception main().while->lin2478:  {e}")
            #print("Exception main().while->lin2478")
            stp = input("       Erro! Swa/Ra inválidos. Continue<E> | <S>air")
            if stp == 'S' or stp == 's': 
                sys.exit()
            else:
                # TEnta recarregar
                varGblNomeSwa = objAnaliseSsh.ler_infosArqTransferPhp('caminho_arquivo', 'nomeSWA') 
                varGblNomeRa = objAnaliseSsh.ler_infosArqTransferPhp('caminho_arquivo', 'nomeRA')
        """


    #End While

    time.sleep(1)
    print("Execução encerrada.")
    sys.exit()

if __name__ == "__main__":
    main()

