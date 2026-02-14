#--import os
#--- Posicionar janela --- #
#--import ctypes
#--from ctypes import wintypes
import pyautogui
import pyperclip
import time
from datetime import datetime
#--import pygetwindow as gw    # Ativar janela(Moba)
import keyboard # usar tecla <esc> para interromper processo

# --------------------------------------------------------#
# Notificao tipo Toast
# pip install plyer
#--from plyer import notification # notification.notify
#--------------------------------------------------------#
from ClassArquivos import Arquivos  # Importando a classe
from ClassBot import Bots  # Importando a classe
from ClassTools import Tools  # Importando a classe
from ClassWindow import Windows  # Importando a classe
from ClassMobaTerm import Terminal  # Importando a classe
from ClassIndices import myIdx  # Importando a classe

# Instancia a classe
objArquivos = Arquivos()
objBots = Bots()
objTools = Tools()
objWindows = Windows()
objTerminal = Terminal()

class AnaliseSsh:
    """Classe responsável por gravar linhas em arquivos de transferência de dados."""

    def __init__(self):
        self.dados = []
    
    def carregar(self):
        print("Carregando...")

    def inicializar(self):
        print("Inicializando...")
        self.analisePendencias()       # ← método "privado"


    @staticmethod 
    def analisePendencias(self, caminho_arquivo, pwLog, icoAppGetInfosSwaX, icoAppGetInfosSwaY, pagMobaX, pagMobaY, posIniArrasteCopyX, posIniArrasteCopyY, janMobaX, janMobaY, abaMoba2X, abaMoba2Y, abaMoba3X, abaMoba3Y, nEnter, tFast, tCmd, tLogar, desviaBugsLogar, desviaBugsCmd):
        """
        - Le linAlin, 
        - Analisa tags<uf, swa, erb, ips, vpn, assumida,
        - Acessa tacacs, faz consultas(swa, svlan, pt, RA, tunnel) 
        - Grava em arq.txt para ser lido no PHP
        """
        caminho_arquivo = myIdx.penImportSAE
        # 'C:/wamp64/www/rd2r3/Robos/transfers/PENDENCIAStxt.txt'  # Transferencia de dados entre Php e Robos
    
        # Removendo a linha que sobrescreve o parâmetro
        try:
            # Formata a data e hora como string
            fmtData = datetime.now().strftime("%d/%m/%Y")             
            fmtHora = datetime.now().strftime("%H:%M:%S")  

            resLin = {}
            with open(caminho_arquivo, 'r', encoding='ISO-8859-1') as arquivo:

                objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.CLEAR, "=================================================================" + '\n')    #Grava em arq.ini -> IP DO HL5 consultado via Swa filtrado so nome   
                objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, "ImportSAE analisados pelo Python - " +fmtData+" "+fmtHora+ '\n')    #Grava em arq.ini -> IP DO HL5 consultado via Swa filtrado so nome   
                objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, "=================================================================" + '\n')    #Grava em arq.ini -> IP DO HL5 consultado via Swa filtrado so nome   
                                    
                numReg = 0
                numLinAna = 0
                LinAnalisada = {}           
                emAnalise = False
                pdtIPD = False
                pdtVPN = False
                IpdVpn = ""
                site = ''
                estacao = ''
                uf = ''

                for num_linha, linha in enumerate(arquivo, 1):
                    LinTicket = linha.rstrip('\n')
                    # print(f"Linha {num_linha}: { LinTicket}")
                    # resLin[num_linha] = LinTicket
                    #------------------------------------------------------------------------------------------------------------------ #
                                    
                    if str(LinTicket) != '':               
                        print(str(LinTicket))

                        # Seleciona, separa infos - Busca por Tags                   
                        if 'assumid' in str(LinTicket).lower(): 
                            emAnalise = True   # Alguem já esta analisando...saltar
                            print("Assumida >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> True" + str(LinTicket))
                            
                        if 'edica' in str(LinTicket).lower(): 
                            pdtIPD = True  
                            IpdVpn = "IPD"
                            print("IPD >> True " + str(LinTicket)) 

                        if 'vpn' in str(LinTicket).lower() or 'mpls' in str(LinTicket).lower(): 
                            pdtVPN = True  
                            IpdVpn = "VPN"
                            print("VPN/MPLS >> True" + str(LinTicket))

                        if 'ibra' in str(LinTicket).lower() or 'pacit' in str(LinTicket).lower(): 
                            print("ERB[FIB/CAP] >> " + str(LinTicket))
                            LinTicket = str(LinTicket).replace('_ERB_FIBRADA_CAPACITADA','')
                            LinTicket = str(LinTicket).replace('ERB_FIBRADA_CAPACITADA','')     # _ERB_FIBRADA_CAPACITADA
                            print("ERB[] >> " + str(LinTicket))

                        if 'erb' in str(LinTicket.lower()) and '}}' in str(LinTicket):                         
                            site = str(LinTicket).replace('";}}','')
                            site = site.replace(':','')
                            site = site.replace('.', '')
                            site = site.replace('-','')
                            site = site.replace('ERB','')
                            site = site.replace('SITE','')                        
                            site = site.rstrip(' ')
                            estacao = site[-3:]
                            uf = site[-6:]  # UFXXX
                            uf = uf.replace(' ', '')
                            uf = uf[0:2]    # UF
                            print("ERB/SITE >> " + str(LinTicket))
                            print("UF() >> " + str(uf))
                            print("Estacao() >> " + str(estacao))

                        elif 'site' in str(LinTicket.lower()) and '}}' in str(LinTicket):                         
                            site = str(LinTicket).replace('";}}','')
                            site = site.replace(':','')
                            site = site.replace('.', '')
                            site = site.replace('-','')
                            site = site.replace('ERB','')
                            site = site.replace('SITE','')
                            site = site.rstrip(' ')
                            estacao = site[-3:]
                            uf = site[-6:]  # UFXXX
                            uf = uf.replace(' ', '')
                            uf = uf[0:2]    # UF  
                            print("ERB/SITE >> " + str(LinTicket))
                            print("UF() >> " + str(uf))
                            print("Estacao() >> " + str(estacao))
                        else:                 
                            if 'erb ' in str(LinTicket).lower() or 'erb:' in str(LinTicket).lower() or 'erb -' in str(LinTicket).lower() or 'site ' in str(LinTicket).lower() or 'site:' in str(LinTicket).lower() or 'site -' in str(LinTicket).lower(): 
                                print("ERB/SITE >> " + str(LinTicket))
                                site = str(LinTicket).replace(':','')
                                site = site.replace('.', '')
                                site = site.replace('-','')
                                site = site.replace('ERB','')
                                site = site.replace('SITE','')
                                site = site.rstrip(' ')
                                estacao = site[-3:]
                                uf = site[-6:]  # UFXXX
                                uf = uf.replace(' ', '')
                                uf = uf[0:2]    # UF  
                                LinAnalisada[1000] = "UF="+str(uf) 
                                LinAnalisada[1001] = "Estacao="+str(estacao)                   

                                print("UF >> " + str(uf))
                                print("Estacao >> " + str(estacao))

                        #Registro[R] = str(LinTicket)  # vai armazenando linhas pra depois gravar no arq.txt
                        LinAnalisada[numLinAna] = str(LinTicket)  # vai armazenando linhas pra depois gravar no arq.txt
                                            
                        numLinAna += 1
                        #print("REGX>>>"+str(RegistroX))
                    
                        # ------ Final de registro ----------------------------------------------- #    
                        # tag '}}' final de ticket
                        if '}}' in str(LinTicket): 
                            print("{===================="+str(num_linha)+"====================}")
                            # Analisar ao final do ticket
                            # Ta ficando sempre True, ver depois...if emAnalise == False:
                            print("**************************** Assumida = False")
                            if pdtIPD == True or pdtVPN == True:
                                print("**************************** IPD ou VPN = True")
                                
                                #for z in range(0, R):
                                #    print(Registro[z]) 
                                #print(str(RegistroX)) 
                                
                                print("**************************")
                                print("Site: "+site)
                                print("UF: "+uf)
                                print("Estacao: "+estacao)                               
                                print("**************************") 


                                # ------------------ Gravar linha, Logar e Consultar Swa atras sVlan, gVlan, Hl5g, RA, ptRA ----------------------------------------------------------- #
                                # if validarUfEstacao(uf, estacao) and estacao.isalpha():
                                if objTools.validar(uf, myIdx.UF) and objTools.validar(estacao, myIdx.ESTACAO):
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, '--------------------------------------------------' + '\n')    #Grava em arq.ini -> IP DO HL5 consultado via Swa filtrado so nome   
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, 'gX{{[' + '\n')    #Grava em arq.ini -> IP DO HL5 consultado via Swa filtrado so nome   
                                    for L in range(0, numLinAna): 
                                        # Grava linha analizada - copia do ImportSae, p/ remontar ticket para o PHP
                                        objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, LinAnalisada[L] + '\n')    #Grava em arq.ini -> IP DO HL5 consultado via Swa filtrado so nome   
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, LinAnalisada[1000] + '\n')    #Grava em arq.ini -> IP DO HL5 consultado via Swa filtrado so nome   
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, LinAnalisada[1001] + '\n')    #Grava em arq.ini -> IP DO HL5 consultado via Swa filtrado so nome   
                                    
                                    # ------------------ Consulta tacacs atras da lista de SWA ----------------------------------------------------------- #                                
                                    objBots.mover_e_clicar('analisePendencias().validar.IP', 1, 500)            
                                    objBots.mover_e_clicar('analisePendencias().validar.IP', janMobaX, janMobaY)            
                                    objTerminal.prepararMoba('analisePendencias().validar.IP', abaMoba3X, abaMoba3Y, nEnter, tFast)                               
                                    # cat deviceList grep | xxx-swa-01
                                    ipSwaAnaPen = self.catDeviceList(myIdx.ANALISE, uf.lower(), estacao.lower()+'-swa-01', pagMobaX, pagMobaY, posIniArrasteCopyX, posIniArrasteCopyY, tFast)
                                
                                    # teste
                                    # ipSwaLocal = '192.168.0.1'
                                    # ------------------ Logar e Consultar Swa atras sVlan, gVlan, Hl5g, RA, ptRA ----------------------------------------------------------- #
                                    # Logar em SWA
                                    if objTools.validar(ipSwaAnaPen, myIdx.IP): 
                                        varIni = objArquivos.lerVarsIni()                

                                        NomeIpSwaAnaPen = varIni[myIdx.iniIpSWA]
                                        NomeSwaAnaPen = varIni[myIdx.iniNmSWA]
                                    
                                        objBots.mover_e_clicar('analisePendencias().validar.IP', 1, 500)            
                                        objBots.mover_e_clicar('analisePendencias().validar.IP', janMobaX, janMobaY)            
                                        objTerminal.prepararMoba('analisePendencias().validar.IP', abaMoba3X, abaMoba3Y, nEnter, tFast)
                                        objBots.logar(ipSwaAnaPen, pwLog, pagMobaX, pagMobaY, posIniArrasteCopyX, posIniArrasteCopyY, tFast, tLogar, desviaBugsLogar, icoAppGetInfosSwaX, icoAppGetInfosSwaY)
                                        time.sleep(tCmd)                                      
                                        # Fazer consultas no SWA                    
                                        # objBots.mover_e_clicar('CS', 1, 500)            
                                        # objBots.mover_e_clicar('CS', janMobaX, janMobaY)            
                                        # objTerminal.prepararMoba('CS', abaMoba3X, abaMoba3Y, nEnter, tFast)
                                        
                                        self.readInfosSWA(myIdx.ANALISE, NomeIpSwaAnaPen, NomeSwaAnaPen, 'IDNull', IpdVpn, posIniArrasteCopyX, posIniArrasteCopyY, myIdx.UND, desviaBugsCmd, tCmd)  
                                        # Esta dentro de readInfosSwa-> objBots.colar_pw_enter(self, 'exit', desviaBugsCmd) -> time.sleep(tCmd)          

                                        # -------------------------------------------------------------------------------------------------- #
                                        NomeRaAnaPen = varIni[myIdx.iniNmRA] 
                                        NumPtRaAnaPen = varIni[myIdx.iniPtRA] 
                                        NumSVlanAnaPen = varIni[myIdx.iniSVLAN]
                                        NomeHL5gAnaPen = varIni[myIdx.iniHL5G]
                    
                                        if objTools.validar(NomeRaAnaPen, myIdx.RA): 
                                            objBots.mover_e_clicar('analisePendencias().validar.RA', 1, 500)            
                                            objBots.mover_e_clicar('analisePendencias().validar.RA', janMobaX, janMobaY)            
                                            objTerminal.prepararMoba('analisePendencias().validar.RA', abaMoba2X, abaMoba2Y, nEnter, tFast)
                                            objBots.logar(NomeRaAnaPen, pwLog, pagMobaX, pagMobaY, posIniArrasteCopyX, posIniArrasteCopyY, tFast, tLogar, desviaBugsLogar, icoAppGetInfosSwaX, icoAppGetInfosSwaY)
                                            print("Conectado ao RA: "+NomeRaAnaPen)
                                            self.readInfosRSD(myIdx.ANALISE, myIdx.PWID, NomeRaAnaPen, NumPtRaAnaPen, NomeHL5gAnaPen, NumSVlanAnaPen, IpdVpn, posIniArrasteCopyX, posIniArrasteCopyY, desviaBugsCmd, tCmd)
                                            """
                                                # <Esc> Interrompe processo(5* 0.2 = 1.0)
                                                for i in range(5):
                                                    time.sleep(tFast)  # 0.2 * 35 = 7seg(Máx)       
                                                    if keyboard.is_pressed('esc'):
                                                        stop = input("Break for user. Continue?<E>")
                                            """
                                        else:
                                            objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, 'Formato RA: '+NomeRaAnaPen+' inválido!' + '\n')    #Grava em arq.ini -> IP DO HL5 consultado via Swa filtrado so nome   
                            
                                        # -------------------------------------------------------------------------------------------------- #

                                    else:
                                        print("IP-SWA: "+ str(ipSwaAnaPen)+ " não localizado!")

                                    """
                                    # <Esc> Interrompe processo(5* 0.2 = 1.0)
                                    for i in range(5):
                                        time.sleep(tFast)  # 0.2 * 35 = 7seg(Máx)       
                                        if keyboard.is_pressed('esc'):
                                            stop = input("Break for user. Continue?<E>")    

                                    """
                                    # ------------------ Logar e Consultar RA atras do tunnel ----------------------------------------------------------- #
                                    
                                                            

                                    # ----- Se atingiu num.registros a analizar...finaliza ---------- # 
                                    if numReg > myIdx.totRegAna: break
                                    numReg += 1

                                # Zera para proximo registro        
                                pdtIPD = False
                                pdtVPN = False
                                site = ''
                                estacao = ''
                                uf = ''                       
                                emAnalise = False
                                LinAnalisada = {}   
                                numLinAna = 0  
                                
                                # Fecha analise do ticket    
                                objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, ']}}' + '\n')    #Grava em arq.ini -> IP DO HL5 consultado via Swa filtrado so nome   
                                    
                #------------------------------------------------------------------------------------------------------------------ #
                    
            # return resLin  # Retorna dicionário com as linhas
        except Exception as e:
            print(f"Exception analisePendencias()->lin1072")
            print(f"Erro ao ler arquivo: {e}")
            # return None


    def analiseDados(self, call, origem, modeloEDD, procurar, Dados, IpdOrVpn):
        objTools.debbug(myIdx.noJumpLin, 'analiseDados('+origem+', ' +str(procurar)+', '+Dados+')')

        linDados = [linha for linha in Dados.split('\n') if linha.strip()]  # Remove linhas vazias
        memLinAnterior = ""
        sVlanX = "" 

        # myIdx.PTRA -> prucura por linha q contem Porta: th 1/1 :  IP_ULK#FIBRA#i-br-pe-rce
        # myIdx.RA -> prucura por linha q contem RA: ame IPD#pe-rce-rce-rsd-01#0/6/0/28
        # myIdx.CVLAN -> prucura por linha q contem cVlan: vlan-translate ingress-table replace
        
        
        # 1/1/24   IP_ULK@FIBRA@[23]i-br-se-aju-cma-hl5g-01[46]@201.26.249.122@0/2/2@1G@
        # posiçoes iniciais-possiveis
        posIninmHL5 = 23
        posFimnmHL5 = 46
        for linAlin in linDados:  # Agora usando linAlin em vez de Dados
            # print("Linha >>> " + linAlin)
            #if "2104G" in modeloEDD or "4370" in modeloEDD or "4270" in modeloEDD or "4050" in modeloEDD or "4250" in modeloEDD:
            if procurar == myIdx.PTRA:
                #for i in range(1, 5):
                busca = "FIBRA"
                if busca in linAlin:  # Corrigido: usar linAlin em vez de Dados 
                    if memLinAnterior != linAlin:        # Evita dados repetidos  
                        if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual)                
                            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, linAlin)  # Imprime no arq.txt de transferencia ToPhp 
                        memLinAnterior = linAlin

                    # PROCURA POR iP DO hL5G ->(Eth 1/1 :  IP_ULK#FIBRA#i-br-pe-rce-osb-hl5g-01#200.161.33.189#0/2/26#1G#)
                    if 'hl5' in  linAlin:
                        # Pega NOme-HL5G - Melhor usar nome, tem mais infos no RSD
                        # Testa se encontrou posição
                        if  linAlin.find('i-br') > 0:  posIninmHL5 = linAlin.find('i-br')    # |i-br|-pe-rce-osb-hl5g-01  
                        else: posIninmHL5 = 23              # valor, possivel-padrão(4050, ver p/ outros Dms)

                        posFimnmHL5 = posIninmHL5 + 23          # i-br-pe-rce-osb-hl5g-01<-
                        nmHL5Gtemp = linAlin[posIninmHL5: posFimnmHL5]
                        varGblNomeHL5g = nmHL5Gtemp
                        objArquivos.gravarVars1a1Ini(myIdx.arqVarsINI, myIdx.JOB, myIdx.iniHL5G, str(varGblNomeHL5g))
                        if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual) 
                            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'nomeHL5G=' + varGblNomeHL5g + '\n')    #Grava em arq.ini -> IP DO HL5 consultado via Swa filtrado so nome   
                        elif call == myIdx.ANALISE:     # FUNCAO CHAMADA VIA analisePendencias 
                            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'nomeHL5G=' + varGblNomeHL5g + '\n')    #Grava em arq.ini -> IP DO HL5 consultado via Swa filtrado so nome   
                            objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, 'nomeHL5G=' + varGblNomeHL5g + '\n')    #Grava em arq.ini -> IP DO HL5 consultado via Swa filtrado so nome   

                        # Testa se achou posição...Pega IP-HL5G
                        if  linAlin.find('hl5') > 0:  posIniHL5 = linAlin.find('hl5') + 8   # hl5g-01#200.161.33.189
                        else: posIniHL5 = 39        # tenta posição posivel...padrao(4050 ver p/ outros)                       
                        posFimHL5 = posIniHL5 + 15          # XXX.XXX.XXX.XXX <- pOSSIBILIDADE TOTAL, DEPOIS TEM QUE FILTRAR
                        ipHL5GtempA = linAlin[posIniHL5: posFimHL5]
                        ipHL5GtempB = ipHL5GtempA.replace('#', '')
                        ipHL5GtempC = ipHL5GtempB.replace('@', '')
                        varGblIpHL5g = ipHL5GtempC
                        objArquivos.gravarVars1a1Ini(myIdx.arqVarsINI, myIdx.JOB, myIdx.iniIpHL5G, str(varGblIpHL5g))
                        if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual) 
                            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'ipHL5G=' + varGblIpHL5g + '\n')    #Grava em arq.ini -> IP DO HL5 consultado via Swa filtrado so nome          
                        elif call == myIdx.ANALISE:     # FUNCAO CHAMADA VIA analisePendencias 
                            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'ipHL5G=' + varGblIpHL5g + '\n')    #Grava em arq.ini -> IP DO HL5 consultado via Swa filtrado so nome          
                            objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, 'ipHL5G=' + varGblIpHL5g + '\n')    #Grava em arq.ini -> IP DO HL5 consultado via Swa filtrado so nome          
            
            # -------------------------- 2104G ---------------------------------------------------------------------------------------------- #
            if "2104G" in modeloEDD:      
                if procurar == myIdx.RA:
                    if "interface vlan" in linAlin or "name" in linAlin:  # Corrigido: usar linAlin em vez de Dados                    
                        if memLinAnterior != linAlin:        # Evita dados repetidos   
                            if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual)                
                                objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, linAlin)  # Imprime no arq.txt de transferencia ToPhp 
                            memLinAnterior = linAlin

                    # Filtra por linha q contem: 
                    # name IPD#pe-rce-rce-rsd-01#0/6/0/28
                    # ou...
                    # name VPN#pe-rce-rce-rsd-01#0/6/0/3               
                    IpdOrVpnX = IpdOrVpn.lower()  # Garante busca case-insensitive                         
                    if "name" in linAlin:                        # PEGA LINHA COM RSD ->  name IPD#pe-rce-rce-rsd-01#0/6/0/28                   
                        if "rsd-" in linAlin or "rai-" in linAlin or "rav-" in linAlin:  # PEGA LINHA COM RSD ->  name IPD#pe-rce-rce-rsd-01#0/6/0/28  
                            if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual)                  
                                objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, linAlin)                  # Imprime no arq.txt de transferencia ToPhp                         
                            #-------------------------------------------------------------#
                            # filtrar(nome RA) de:  name IPD#pe-rce-rce-rsd-01#0/6/0/28 
                            # Filtra por linha q contem: 
                                # name IPD#pe-rce-rce-rsd-01#0/6/0/28
                            # ou...
                                # name VPN#pe-rce-rce-rsd-01#0/6/0/3
                            
                            linRA = linAlin.lower()  # Garante busca case-insensitive                   
                            if  IpdOrVpnX in linRA:
                                #objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'RA: ' + linAlin)                  # Imprime no arq.txt de transferencia ToPhp     
                                if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual)                     
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, linAlin)                  # Imprime no arq.txt de transferencia ToPhp                         
                
                                #----------  iNI PROCURA POR NOME DE RA -----------------------------------------#
                                # 2995  IPD_i-br-sp-mia-ja-rai-01_6-0-0  static  4          Model:               DM4050 - MPU384
                                #  name IPD_i-br-ce-fla-ad-rai-01_5/0/20                    Model:               DM4004 - MPU384
                                # posIniRsd = linRA.find('#') + 1 # rsd-01 
                                if '#' in linRA:                            
                                    posIniRsd = linRA.find('#') + 1 # rsd-01                            
                                elif '#' in linRA:                            
                                    posIniRsd = linRA.find('_') + 1 # rsd-01
                                    if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual) 
                                        objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, linAlin)                  # Imprime no arq.txt de transferencia ToPhp                         
                
                                else:
                                    if "rsd-" in linRA: 
                                        posIniRsd = linRA.find('rsd-') - 14 # rsd-01  
                                    if "-ra" in linRA: 
                                        posIniRsd = linRA.find('-ra') - 14 # rai/rav-01  
                                        if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual) 
                                            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, linAlin)                  # Imprime no arq.txt de transferencia ToPhp                         
                
                            
                                if "rsd-" in linRA: posFimRsd = linRA.find('rsd-') + 6 # rsd-01  
                                elif "rai-" in linRA: posFimRsd = linRA.find('rai-') + 6 # rsd-01  
                                elif "rav-" in linRA: posFimRsd = linRA.find('rav-') + 6 # rsd-01  
                                else: posFimRsd = linRA.find('rsd-') + 6 # rsd-01  

                                nomeRAtemp = linRA[posIniRsd: posFimRsd]
                                
                                if 'i-br' in nomeRAtemp or 'c-br' in nomeRAtemp:
                                    nomeRAgetQuery = nomeRAtemp
                                else:
                                    nomeRAgetQuery = 'i-br-' + nomeRAtemp
                                
                                varGblNomeRa = nomeRAgetQuery 
                                objArquivos.gravarVars1a1Ini(myIdx.arqVarsINI, myIdx.JOB, myIdx.iniNmRA, str(varGblNomeRa))                            
                                if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual) 
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'nomeRA=' + varGblNomeRa + '\n') # Grava em arq.ini nomeRA atual 9NAO CONSEGUI GRAVAR EM UMA VAR GLOBAL)
                                elif call == myIdx.ANALISE:     # FUNCAO CHAMADA VIA analisePendencias 
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'nomeRA=' + varGblNomeRa + '\n') # Grava em arq.ini nomeRA atual 9NAO CONSEGUI GRAVAR EM UMA VAR GLOBAL)
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, 'nomeRA=' + varGblNomeRa + '\n') # Grava em arq.ini nomeRA atual 9NAO CONSEGUI GRAVAR EM UMA VAR GLOBAL)
                                # Pega porta RA:  name IPD#ma-sls-sfr-rsd-01#pwe1036, usado para Consultar Nokia e no Php
                                posIniPtRA = posFimRsd + 1
                                posFimPtRA =  posIniPtRA + 8                            
                                nPtRaX = linRA[posIniPtRA:posFimPtRA] 
                                varGblNumPtRa = objTools.formatePorta(nPtRaX)
                                objArquivos.gravarVars1a1Ini(myIdx.arqVarsINI, myIdx.JOB, myIdx.iniPtRA, str(varGblNumPtRa))
                                if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual) 
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'numPtRA=' + varGblNumPtRa+'\n')  # Imprime no arq.txt de transferencia ToPhp
                                elif call == myIdx.ANALISE:     # FUNCAO CHAMADA VIA analisePendencias 
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'numPtRA=' + varGblNumPtRa+'\n')  # Imprime no arq.txt de transferencia ToPhp
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, 'numPtRA=' + varGblNumPtRa+'\n')  # Imprime no arq.txt de transferencia ToPhp

                    #----------  PROCURA POR SVLAN -----------------------------------------#
                    # O RELATORIO VEM ASSIM:
                    # interface vlan 3
                    #    name GER#ba-rbp-rvg-hl5g-01#gi0/2/26
                    # interface vlan 2468
                    #    name VPN#ba-sdr-gvt-rsd-01#pwe1454
                    # interface vlan 2469                           <<=< memorizar(linha anterior)
                    #    name IPD#ba-sdr-gvt-rsd-01#Te0/6/0/30      <<=< Qdo ocorrer IPD, pegar SVlan da memoria(linnha anterior)
                
                    if "interface vlan" in linAlin:                     
                        memLinIntSVlan = linAlin
                        memLinIntGVlan = linAlin
                        #objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'Memoriza: ' + str(linAlin)+'\n') 

                    # sVlan
                    if IpdOrVpnX.lower() in linAlin.lower():              # <<=< SE linha atual, possui IPD ou VPN
                        #sVlanX =  memLinIntSVlan[-5:]   # Achou Svlan    
                        sVlanX = ''.join(filter(str.isdigit, memLinIntSVlan))           # pega so os numeros da linha               
                        #objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'ACHOU-> '+IpdOrVpnX + ' em: ' + str(linAlin) + 'pega linha memorizada\n')    
                        varGblNumSVlan = sVlanX
                        objArquivos.gravarVars1a1Ini(myIdx.arqVarsINI, myIdx.JOB, myIdx.iniSVLAN, str(varGblNumSVlan)) 
                        if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual)           
                            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'numSVLAN=' + varGblNumSVlan +'\n')  # Imprime no arq.txt de transferencia ToPhp   
                        elif call == myIdx.ANALISE:     # FUNCAO CHAMADA VIA analisePendencias 
                            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'numSVLAN=' + varGblNumSVlan +'\n')  # Imprime no arq.txt de transferencia ToPhp                  
                            objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, 'numSVLAN=' + varGblNumSVlan +'\n')  # Imprime no arq.txt de transferencia ToPhp   
                        memLinIntSVlan = "" 

                    if 'ger' in linAlin.lower():              # <<=< SE GERENCIA- gVLAN
                        # objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'achou GER: ' + linAlin+'\n')  # Imprime no arq.txt de transferencia ToPhp    
                        gVlanX = ''.join(filter(str.isdigit, memLinIntGVlan))           # pega SO os numeros da linha
                        varGblNumGVlan = gVlanX
                        objArquivos.gravarVars1a1Ini(myIdx.arqVarsINI, myIdx.JOB, myIdx.iniGVLAN, str(varGblNumGVlan))                
                        if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual) 
                            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'numGVLAN=' + varGblNumGVlan +'\n')  # Imprime no arq.txt de transferencia ToPhp  
                        elif call == myIdx.ANALISE:     # FUNCAO CHAMADA VIA analisePendencias 
                            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'numGVLAN=' + varGblNumGVlan +'\n')  # Imprime no arq.txt de transferencia ToPhp                  
                            objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, 'numGVLAN=' + varGblNumGVlan +'\n')  # Imprime no arq.txt de transferencia ToPhp     
                        memLinIntGVlan = ""


            # ------------------------------------ V380R220 --------------------------------------------------------------------------- #   
            """
                3     forward static  GER#ro-cdey-cdy-hl5d-01#1/1/6
                100   forward static  N/A
                101   forward static  N/A
                2422  forward static  VPN#ro-pvo-get-rsd-01#pwe1809
                2423  forward static  IPD#ro-pvo-get-rsd-01#pwe1808
            """ 
            if "V380R220" in modeloEDD:      
                if procurar == myIdx.RA:
                    if "forward" in linAlin.lower():  # Corrigido: usar linAlin em vez de Dados                    
                        # Filtra por linha q contem: 
                        # 3     forward static  GER#ro-cdey-cdy-hl5d-01#1/1/6
                        # 2422  forward static  VPN#ro-pvo-get-rsd-01#pwe1809
                        # 2423  forward static  IPD#ro-pvo-get-rsd-01#pwe1808 
                        
                        if 'ger' in linAlin.lower():   # procura GERENCIA
                            gVlanX = linAlin[0:7]       # 3     forward static  GER#ro-cdey-cdy-hl5d-01#1/1/6
                            gVlanN = ''.join(filter(str.isdigit, gVlanX))           # pega so os numeros da linha 
                            varGblNumGVlan = gVlanN
                            objArquivos.gravarVars1a1Ini(myIdx.arqVarsINI, myIdx.JOB, myIdx.iniGVLAN, str(varGblNumGVlan))
                            if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual)                                
                                objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'numGVLAN=' + varGblNumGVlan + '\n') # Grava em arq.ini nomeRA atual 9NAO CONSEGUI GRAVAR EM UMA VAR GLOBAL)
                            elif call == myIdx.ANALISE:     # FUNCAO CHAMADA VIA analisePendencias 
                                objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'numGVLAN=' + varGblNumGVlan + '\n') # Grava em arq.ini nomeRA atual 9NAO CONSEGUI GRAVAR EM UMA VAR GLOBAL)
                                objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, 'numGVLAN=' + varGblNumGVlan + '\n') # Grava em arq.ini nomeRA atual 9NAO CONSEGUI GRAVAR EM UMA VAR GLOBAL)

                        # PROCURA ipd OU vpn - Garante busca case-insensitive 
                        if IpdOrVpn.lower() in linAlin.lower():    # IPD ou VPN
                            sVlanX = linAlin[0:7]       # 2423  forward static  IPD#ro-pvo-get-rsd-01#pwe1808
                            sVlanN = ''.join(filter(str.isdigit, sVlanX))           # pega so os numeros da linha
                            varGblNumSVlan = sVlanN
                            objArquivos.gravarVars1a1Ini(myIdx.arqVarsINI, myIdx.JOB, myIdx.iniSVLAN, str(varGblNumSVlan))
                            if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual)        
                                objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'numSVLAN=' + varGblNumSVlan + '\n') # Grava em arq.ini nomeRA atual 9NAO CONSEGUI GRAVAR EM UMA VAR GLOBAL)  
                            elif call == myIdx.ANALISE:     # FUNCAO CHAMADA VIA analisePendencias 
                                objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'numSVLAN=' + varGblNumSVlan + '\n') # Grava em arq.ini nomeRA atual 9NAO CONSEGUI GRAVAR EM UMA VAR GLOBAL)  
                                objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, 'numSVLAN=' + varGblNumSVlan + '\n') # Grava em arq.ini nomeRA atual 9NAO CONSEGUI GRAVAR EM UMA VAR GLOBAL)  

                            # PEGA LINHA COM RSD ->  name IPD#pe-rce-rce-rsd-01#0/6/0/28 
                            linRA = linAlin.lower()                  
                            if "rsd-" in linRA or "rai-" in linRA or "rav-" in linRA:  # PEGA LINHA COM RSD ->  name IPD#pe-rce-rce-rsd-01#0/6/0/28   
                                if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual)                 
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, linRA)                  # Imprime no arq.txt de transferencia ToPhp                         
                                #-------------------------------------------------------------#
                                # Filtra por linha q contem: 
                                    # 2422  forward static  VPN#ro-pvo-get-rsd-01#pwe1809
                                    # OU...
                                    # 2423  forward static  IPD#ro-pvo-get-rsd-01#pwe1808 
                                                        
                                #----------  iNI PROCURA POR NOME DE RA -----------------------------------------#
                                posIniRsd = linRA.find('#') + 1 # rsd-01                            
                                if "rsd-" in linRA: posFimRsd = linRA.find('rsd-') + 6 # rsd-01  
                                elif "rai-" in linRA: posFimRsd = linRA.find('rai-') + 6 # rsd-01  
                                elif "rav-" in linRA: posFimRsd = linRA.find('rav-') + 6 # rsd-01  
                                else: posFimRsd = linRA.find('rsd-') + 6 # rsd-01  

                                nomeRAtemp = linRA[posIniRsd: posFimRsd]
                                
                                if 'i-br' in nomeRAtemp or 'c-br' in nomeRAtemp:
                                    nomeRAgetQuery = nomeRAtemp
                                else:
                                    nomeRAgetQuery = 'i-br-' + nomeRAtemp
                                
                                varGblNomeRa = nomeRAgetQuery
                                objArquivos.gravarVars1a1Ini(myIdx.arqVarsINI, myIdx.JOB, myIdx.iniNmRA, str(varGblNomeRa))
                                if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual) 
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'nomeRA=' + varGblNomeRa + '\n') # Grava em arq.ini nomeRA atual 9NAO CONSEGUI GRAVAR EM UMA VAR GLOBAL)
                                elif call == myIdx.ANALISE:     # FUNCAO CHAMADA VIA analisePendencias 
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'nomeRA=' + varGblNomeRa + '\n') # Grava em arq.ini nomeRA atual 9NAO CONSEGUI GRAVAR EM UMA VAR GLOBAL)
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, 'nomeRA=' + varGblNomeRa + '\n') # Grava em arq.ini nomeRA atual 9NAO CONSEGUI GRAVAR EM UMA VAR GLOBAL)

                                # Pega porta RA:  name IPD#ma-sls-sfr-rsd-01#pwe1036, usado para Consultar Nokia e no Php
                                posIniPtRA = posFimRsd + 1
                                posFimPtRA =  posIniPtRA + 8                            
                                nPtRaX = linRA[posIniPtRA:posFimPtRA]  
                                varGblNumPtRa = objTools.formatePorta(nPtRaX)
                                objArquivos.gravarVars1a1Ini(myIdx.arqVarsINI, myIdx.JOB, myIdx.iniPtRA, str(varGblNumPtRa))
                                if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual) 
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'numPtRA=' +  varGblNumPtRa+'\n')  # Imprime no arq.txt de transferencia ToPhp
                                elif call == myIdx.ANALISE:     # FUNCAO CHAMADA VIA analisePendencias 
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'numPtRA=' +  varGblNumPtRa+'\n')  # Imprime no arq.txt de transferencia ToPhp
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, 'numPtRA=' +  varGblNumPtRa+'\n')  # Imprime no arq.txt de transferencia ToPhp
            
            # --------------- 4050/4370 --------------------------------------------------------------------------------- #
            # Posicoes Incial/Final padrao para linha(4050): Bot->vlan-id=2515  IPD@se-aju-ebt-rai-01@4/2/6   static  8
            posIniRsd = 23
            posFimRsd = 41

            if "4370" in modeloEDD or "4050" in modeloEDD:      
                
                # Depurando-> objTools.debbug(myIdx.noJumpLin, 'analiseDados(Lin837)')

                if procurar == myIdx.RA:
                    # Depurando-> objTools.debbug(myIdx.noJumpLin, 'analiseDados(Lin840)')
                    if "name" in linAlin:  # Corrigido: usar linAlin em vez de Dados   
                        # Depurando-> objTools.debbug(myIdx.noJumpLin, 'analiseDados(Lin842)')                 
                        if memLinAnterior != linAlin:        # Evita dados repetidos
                            # Depurando-> objTools.debbug(myIdx.noJumpLin, 'analiseDados(Lin844)')  
                            if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual)                                  
                                objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, linAlin)  # Imprime no arq.txt de transferencia ToPhp 
                            memLinAnterior = linAlin  

                    if "static" in linAlin:  # Corrigido: usar linAlin em vez de Dados    
                        # Depurando-> objTools.debbug(myIdx.noJumpLin, 'analiseDados(Lin849)')                                 
                        if memLinAnterior != linAlin:        # Evita dados repetidos 
                            # Depurando-> objTools.debbug(myIdx.noJumpLin, 'analiseDados(Lin851)') 
                            if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual)                                  
                                objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, linAlin)  # Bot->vlan-id=...para Php reconhecer linha c/ sVlans
                            memLinAnterior = linAlin  

                            IpdOrVpnX = IpdOrVpn.lower()  # Garante busca case-insensitive   
                            linRA = linAlin.lower()                      
                            if IpdOrVpnX in linRA:                        # PEGA LINHA COM IPD/VPN ->  name IPD#pe-rce-rce-rsd-01#0/6/0/28                   
                                # objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'RA: ' + linRA)                  # Imprime no arq.txt de transferencia ToPhp                         
                                # Depurando-> objTools.debbug(myIdx.noJumpLin, 'analiseDados(Lin859)')                 
                                # --------------- INI PROCURA RA --------------------------------------------------#
                                # Teste se achou posicao, caso nao pega valor padrao
                                if linRA.find('@') > 0: 
                                    posIniRsd = linRA.find('@') + 1 # rsd-01 
                                    # Depurando-> objTools.debbug(myIdx.noJumpLin, 'analiseDados(Lin864)')                 
                                else:                            
                                    if '#' in linRA:      
                                        # Depurando-> objTools.debbug(myIdx.noJumpLin, 'analiseDados(Lin867)')                                       
                                        posIniRsd = linRA.find('#') + 1 # rsd-01                            
                                    elif '#' in linRA:   
                                        # Depurando-> objTools.debbug(myIdx.noJumpLin, 'analiseDados(Lin870)')                                          
                                        posIniRsd = linRA.find('_') + 1 # rsd-01
                                        if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual) 
                                            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, linAlin)                  # Imprime no arq.txt de transferencia ToPhp                         
                    
                                    else:
                                        # Depurando-> objTools.debbug(myIdx.noJumpLin, 'analiseDados(Lin875)')                 
                                        if "rsd-" in linRA: 
                                            # Depurando-> objTools.debbug(myIdx.noJumpLin, 'analiseDados(Lin877)')                 
                                            posIniRsd = linRA.find('rsd-') - 14 # rsd-01  
                                        if "-ra" in linRA:
                                            # Depurando-> objTools.debbug(myIdx.noJumpLin, 'analiseDados(Lin880)')                  
                                            posIniRsd = linRA.find('-ra') - 14 # rai/rav-01  
                                            if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual) 
                                                objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, linAlin)                  # Imprime no arq.txt de transferencia ToPhp                         
                    

                                # Teste se achou posicao, caso nao pega valor padrao
                                if linRA.find('rsd-') > 0 or linRA.find('rai-') > 0 or linRA.find('rav-'):    
                                    # Depurando-> objTools.debbug(myIdx.noJumpLin, 'analiseDados(Lin887)')                                        
                                    if "rsd-" in linRA: posFimRsd = linRA.find('rsd-') + 6 # rsd-01  
                                    elif "rai-" in linRA: posFimRsd = linRA.find('rai-') + 6 # rsd-01  
                                    elif "rav-" in linRA: posFimRsd = linRA.find('rav-') + 6 # rsd-01  
                                    else: posFimRsd = linRA.find('rsd-') + 6 # rsd-01 
                                else: posFimRsd = 41 

                                nomeRAtemp = linRA[posIniRsd: posFimRsd]
                                
                                if 'i-br' in nomeRAtemp or 'c-br' in nomeRAtemp:
                                    nomeRAgetQuery = nomeRAtemp
                                else:
                                    nomeRAgetQuery = 'i-br-' + nomeRAtemp
                                
                                # Depurando-> objTools.debbug(myIdx.noJumpLin, 'analiseDados(Lin901)')  
                                varGblNomeRa = nomeRAgetQuery 
                                objArquivos.gravarVars1a1Ini(myIdx.arqVarsINI, myIdx.JOB, myIdx.iniNmRA, str(varGblNomeRa))
                                if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual)                
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'nomeRA=' + varGblNomeRa + '\n') # Grava em arq.ini nomeRA atual 9NAO CONSEGUI GRAVAR EM UMA VAR GLOBAL)
                                elif call == myIdx.ANALISE:     # FUNCAO CHAMADA VIA analisePendencias 
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'nomeRA=' + varGblNomeRa + '\n') # Grava em arq.ini nomeRA atual 9NAO CONSEGUI GRAVAR EM UMA VAR GLOBAL)
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, 'nomeRA=' + varGblNomeRa + '\n') # Grava em arq.ini nomeRA atual 9NAO CONSEGUI GRAVAR EM UMA VAR GLOBAL)

                                # Pega porta RA:  name IPD#ma-sls-sfr-rsd-01#pwe1036, usado para Consultar Nokia e no Php
                                posIniPtRA = posFimRsd + 1
                                posFimPtRA =  posIniPtRA + 8                            
                                nPtRaX = linRA[posIniPtRA:posFimPtRA]  
                                varGblNumPtRa = objTools.formatePorta(nPtRaX)
                                objArquivos.gravarVars1a1Ini(myIdx.arqVarsINI, myIdx.JOB, myIdx.iniPtRA, str(varGblNumPtRa))
                                if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual) 
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'numPtRA=' + varGblNumPtRa +'\n')  # Imprime no arq.txt de transferencia ToPhp
                                elif call == myIdx.ANALISE:     # FUNCAO CHAMADA VIA analisePendencias 
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'numPtRA=' + varGblNumPtRa +'\n')  # Imprime no arq.txt de transferencia ToPhp
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, 'numPtRA=' + varGblNumPtRa +'\n')  # Imprime no arq.txt de transferencia ToPhp
                                # Depurando-> objTools.debbug(myIdx.noJumpLin, 'analiseDados(Lin912)')                 
                                # --------------- PROCURA sVLAN --------------------------------------------------#
                                # 1869  IPD@rj-nri-nit-rsd-01@pwe2203  static  13
                                # 1870  VPN@rj-nri-nit-rsd-01@pwe2204  static  7
                                nomeSVLAN = linRA[:5]  # Pega os 5 primeiros da Linha que contem: 'static' e o Produto('IPD' ou 'VPN') 
                                varGblNumSVlan = nomeSVLAN
                                objArquivos.gravarVars1a1Ini(myIdx.arqVarsINI, myIdx.JOB, myIdx.iniSVLAN, str(varGblNumSVlan))
                                if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual) 
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'numSVLAN=' + varGblNumSVlan + '\n') # Grava em arq.ini nomeRA atual 9NAO CONSEGUI GRAVAR EM UMA VAR GLOBAL)
                                elif call == myIdx.ANALISE:     # FUNCAO CHAMADA VIA analisePendencias 
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'numSVLAN=' + varGblNumSVlan + '\n') # Grava em arq.ini nomeRA atual 9NAO CONSEGUI GRAVAR EM UMA VAR GLOBAL)
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, 'numSVLAN=' + varGblNumSVlan + '\n') # Grava em arq.ini nomeRA atual 9NAO CONSEGUI GRAVAR EM UMA VAR GLOBAL)
                                    
                            if 'ger' in linRA:                        # PEGA LINHA COM GER:     3     GER@ap-mpa-gzt-hl5g-01@0/0/0/13  static  12                   
                                nomeGVLAN = linRA[:5]  # Pega os 5 primeiros da Linha que contem: 'static' e o Produto('IPD' ou 'VPN') 
                                varGblNumGVlan = nomeGVLAN
                                objArquivos.gravarVars1a1Ini(myIdx.arqVarsINI, myIdx.JOB, myIdx.iniGVLAN, str(varGblNumGVlan))
                                if call == myIdx.USER:     # FUNCAO CHAMADA VIA USER(Auto/Manual) 
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'numGVLAN=' + varGblNumGVlan + '\n') # Grava em arq.ini nomeRA atual 9NAO CONSEGUI GRAVAR EM UMA VAR GLOBAL)
                                elif call == myIdx.ANALISE:     # FUNCAO CHAMADA VIA analisePendencias 
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'numGVLAN=' + varGblNumGVlan + '\n') # Grava em arq.ini nomeRA atual 9NAO CONSEGUI GRAVAR EM UMA VAR GLOBAL)
                                    objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, 'numGVLAN=' + varGblNumGVlan + '\n') # Grava em arq.ini nomeRA atual 9NAO CONSEGUI GRAVAR EM UMA VAR GLOBAL)
                                # Depurando-> objTools.debbug(myIdx.noJumpLin, 'analiseDados(Lin922)')  
        #try:
            # Salva vars em arq.ini(pra nao perder infos)
            # objArquivos.gravarVarsIni(myIdx.JOB, siglaUF=varGblUF, nomeSWA=varGblNomeSwa, ipSWA=varGblIpSwa, nomeRA=varGblNomeRa,  numPtRA=varGblNumPtRa, numGVLAN=varGblNumGVlan, numSVLAN=varGblNumSVlan, nomeHL5G=varGblNomeHL5g)
        #except Exception as e:
        #  print(f"Exception analisedados().objArquivos.gravarVarsIni():  {e}") 

    # ------------ Final analiseDados-------------------------------------------------------------------------------------------------------------------- #


    # ------------ INFOS SWA-------------------------------------------------------------------------------------------------------------------- #
    def readInfosSWA(self, call, IpNomeSwaGetCatDevice, nomeSwaGetQuery, csvIdOrdem, Produto, posIniArrasteCopyX,  posIniArrasteCopyY, tipoCheck, desviaBugs, tCmd):
    #   readInfosSWA(myIdx.USER, varGbl_NomeSWA,       varGblNomeSwa,   csvIdOrdem, csvProduto, posIniArrasteCopyX, posIniArrasteCopyY, myIdx.UND,      desviaBugsCmd, tCmd)  

        objTools.debbug(myIdx.noJumpLin, 'readInfosSWA(myIdx.USER, '+IpNomeSwaGetCatDevice+', '+ nomeSwaGetQuery+', '+ csvIdOrdem+', '+ Produto+', '+ str(posIniArrasteCopyX)+', '+  str(posIniArrasteCopyY)+', '+ str(tipoCheck)+', '+ str(desviaBugs)+', '+   str(tCmd)+')')

        if tCmd < 0.2: tCmd = 1.0

        if call == myIdx.USER:     # FUNCAO CHAMADA VIA MENU(Auto/manual)
            # (CRIAR CABEÇARIO) txt de Transfers dados  To Php 
            #objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, '\n===========================================================================================\n')  
            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, '\n\nBot getInfosSwa()\n')   
            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, '{\n')   
            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, IpNomeSwaGetCatDevice + '\n')   
            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, nomeSwaGetQuery + '\n')   

        modeloEDD = ""
        
        # ----------------- Testar se Versao> show vlan brief ----------------------------------------------------------- #
        # DM2104 return     -> % 25: Invalid input detected at '^' marker.
        # V380R220 RETURN   -> %Unknown command.
        # dm4050/4370       -> lista vlans
        # desviaBugs = 1
        objBots.colar_pw_enter(self, 'show vlan brief', desviaBugs)
        time.sleep(tCmd * 3) 
        getAnswer = objBots.clickArrasteCopy(posIniArrasteCopyX, posIniArrasteCopyY, myIdx.numCOLS,  12, myIdx.SpeedARRASTE, tCmd) 

        if 'Invalid' in getAnswer:                        # Cmd(do dm4050) Invalido...entao...é 2104
            modeloEDD = '2104G'                           # ou DM4001, cmds saõ quase iguais
        elif '%Unknown' in getAnswer:                     # Cmd(do dm4050) Invalido...entao...é 2104
            modeloEDD = 'V380R220'
            desviaBugs = 3                                # Ver se precisa de X espaços de retorno após cmd
            objWindows.zoomMenos(myIdx.ZOOM, float(myIdx.ItvalZoom))                  # Devido num de linhas do 4050, Reduz tamanho do texto da abaMoba3
        elif 'unknown' in getAnswer:                      # Cmddesconhecido...possivel erro de digitação...retornar espaços de bug´s auto-inseridos   
            modeloEDD = '4050'
            desviaBugs = 3                                # 4050 precisa de X espaços de retorno após cmd
            objWindows.zoomMenos(myIdx.ZOOM, float(myIdx.ItvalZoom))                  # Devido num de linhas do 4050, Reduz tamanho do texto da abaMoba3
        else: 
            modeloEDD = '4050'
            objWindows.zoomMenos(myIdx.ZOOM, float(myIdx.ItvalZoom))                  # Devido num de linhas do 4050, Reduz tamanho do texto da abaMoba3
    
        if call == myIdx.USER:     # FUNCAO CHAMADA VIA MENU(Auto/manual)
            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, '\nModelo='+ modeloEDD + '\n')   # Gravar modelo em arquivo txt de Transfers dados  To Php    
        elif call == myIdx.ANALISE:     # FUNCAO CHAMADA VIA analisependencias
            objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, '\nModelo='+ modeloEDD + '\n')   # Gravar modelo em arquivo txt de Transfers dados  To Php

        # ------------- DM2104G ------------------------------------------------------------------------------------------ #
        if "2104G" in modeloEDD:   # ou DM4001 cmds saõ quase iguais
            if tipoCheck == myIdx.LOTE:   # Lote de Cmds     
                objBots.colar_pw_enter(self, 'sh int desc', desviaBugs)
                time.sleep(tCmd * 3)
                objBots.colar_pw_enter(self, 'sh run | inc vlan \| name', desviaBugs)   # dm2104g
                time.sleep(tCmd * 3)  
                # objBots.colar_pw_enter(self, 'sh run | inc vlan | name', desviaBugs)    # dm4001  de Bug, verificar
                # time.sleep(tCmd * 3)  
                objTerminal.prepararMoba('Null', 500, 500, 3, 0.2)  # Separa  
                time.sleep(tCmd)
                Configs = objBots.clickArrasteCopy(posIniArrasteCopyX, posIniArrasteCopyY, myIdx.numCOLS, 35, myIdx.SpeedARRASTE, tCmd) 
                self.analiseDados(call,'readInfosSWA->2104G->Lin956',modeloEDD, myIdx.RA, Configs, Produto)   # arqToPhp = 'C:/wamp64/www/rd2r3/Robos/transfers/infosSwa_temp.txt';  # Transferencia de dados entre Php e Robos 
                time.sleep(tCmd)
                self.analiseDados(call,'readInfosSWA->2104G->Lin958',modeloEDD, myIdx.CVLAN, Configs, Produto)
                time.sleep(tCmd)
            
            else:  # Cmds separados
                # desviaBugs = 1
                objBots.colar_pw_enter(self, 'sh int desc', desviaBugs)
                time.sleep(tCmd * 3)     
                ptConfigs = objBots.clickArrasteCopy(posIniArrasteCopyX, posIniArrasteCopyY, myIdx.numCOLS, 12, myIdx.SpeedARRASTE, tCmd) 
                self.analiseDados(call,'readInfosSWA->2104G->Lin965',modeloEDD, myIdx.PTRA, ptConfigs, Produto)  # arqToPhp = 'C:/wamp64/www/rd2r3/Robos/transfers/infosSwa_temp.txt';  # Transferencia de dados entre Php e Robos 
                time.sleep(tCmd)

                objBots.colar_pw_enter(self, 'sh run | inc vlan \| name', desviaBugs)
                time.sleep(tCmd * 3)      
                cVlansConfigs = objBots.clickArrasteCopy(posIniArrasteCopyX, posIniArrasteCopyY, myIdx.numCOLS,  28, myIdx.SpeedARRASTE, tCmd) 
                self.analiseDados(call,'readInfosSWA->2104G->Lin971',modeloEDD, myIdx.RA, cVlansConfigs, Produto) # arqToPhp = 'C:/wamp64/www/rd2r3/Robos/transfers/infosSwa_temp.txt';  # Transferencia de dados entre Php e Robos
                time.sleep(tCmd)
                self.analiseDados(call,'readInfosSWA->2104G->Lin973',modeloEDD, myIdx.CVLAN, cVlansConfigs, Produto)
                time.sleep(tCmd)


        # ------------- V380R220 ------------------------------------------------------------------------------------------ #
        """
                m-br-ro-cdey-cdy-swa-01# show vlan property
            
                VID   UMcast  Type    Alias
                1     forward static  N/A
                2     forward static  N/A
                3     forward static  GER#ro-cdey-cdy-hl5d-01#1/1/6
                100   forward static  N/A
                101   forward static  N/A
                2422  forward static  VPN#ro-pvo-get-rsd-01#pwe1809
                2423  forward static  IPD#ro-pvo-get-rsd-01#pwe1808
                m-br-ro-cdey-cdy-swa-01#show interface

                Interface         State(a/o)  Mode      Descr
                ge1/0/1           up/up       bridge    IP_ULK#FIBRA#i-br-ro-cdey-cdy-hl5d-01#201.26.247.16#1/1/6#1G#

                ge1/1/1           up/down     bridge    IP_DLK#FIBRA#m-br-ro-cdey-cdy-swt-001#10.52.188.123#1/1/1#1G#2070149#
                ge1/1/2           up/down     bridge    IP_DLK#FIBRA#m-br-ro-cdey-cdy-swt-002#10.52.188.124#1/1/2#1G#2128828#
                ge1/2/1           up/down     bridge    -
                ge1/2/2           up/down     bridge    -
                vlan3             up/up       router    GER#ro-cdey-cdy-hl5d-01#1/1/6
                loopback0         up/up       router    -

        """
        if "V380R220" in modeloEDD:  
                objBots.colar_pw_enter(self, 'show interface', desviaBugs)
                time.sleep(tCmd * 3)     
                objBots.colar_pw_enter(self, ' ', desviaBugs) # Um <enter> só pra paginar
                time.sleep(tCmd)     
                ptConfigs = objBots.clickArrasteCopy(posIniArrasteCopyX, posIniArrasteCopyY, myIdx.numCOLS,  28, myIdx.SpeedARRASTE,  tCmd) 
                self.analiseDados(call,'readInfosSWA->V380R220->Lin1008',modeloEDD, myIdx.PTRA, ptConfigs, Produto)  # arqToPhp = 'C:/wamp64/www/rd2r3/Robos/transfers/infosSwa_temp.txt';  # Transferencia de dados entre Php e Robos 
                time.sleep(tCmd)

                objBots.colar_pw_enter(self, 'show vlan property', desviaBugs)
                time.sleep(tCmd * 3)      
                cVlansConfigs = objBots.clickArrasteCopy(posIniArrasteCopyX, posIniArrasteCopyY, myIdx.numCOLS,  12, myIdx.SpeedARRASTE,  tCmd) 
                self.analiseDados(call,'readInfosSWA->V380R220->Lin1014',modeloEDD, myIdx.RA, cVlansConfigs, Produto) # arqToPhp = 'C:/wamp64/www/rd2r3/Robos/transfers/infosSwa_temp.txt';  # Transferencia de dados entre Php e Robos
                time.sleep(tCmd)
                self.analiseDados(call,'readInfosSWA->V380R220->Lin1016',modeloEDD, myIdx.CVLAN, cVlansConfigs, Produto)
                time.sleep(tCmd)


        if "4370" in modeloEDD or "4050" in modeloEDD or "4250" in modeloEDD or "4270" in modeloEDD: 
            if tipoCheck == myIdx.LOTE:    # Cmds em Lote
                objBots.colar_pw_enter(self, 'sh int desc', desviaBugs)
                time.sleep(tCmd * 3)  
                objBots.colar_pw_enter(self, 'show run | inc name | match-all | inc '+Produto, desviaBugs)
                time.sleep(tCmd * 3)
                objBots.colar_pw_enter(self, 'show vlan brief', desviaBugs)
                time.sleep(tCmd * 3)   
                objBots.colar_pw_enter(self, 'show run | inc match | match-all | inc vlan-id', desviaBugs)
                time.sleep(tCmd * 3)   
                objTerminal.prepararMoba('Null', 500, 500, 3, 0.2)  # Separa do chao
                time.sleep(tCmd) 
                Configs = objBots.clickArrasteCopy(posIniArrasteCopyX, posIniArrasteCopyY, myIdx.numCOLS,  50, myIdx.SpeedARRASTE,  tCmd) 
                self.analiseDados(call,'readInfosSWA->4050->Lin1033', modeloEDD, myIdx.PTRA, Configs, Produto)    # arqToPhp = 'C:/wamp64/www/rd2r3/Robos/transfers/infosSwa_temp.txt';  # Transferencia de dados entre Php e Robos
                time.sleep(tCmd)
                self.analiseDados(call,'readInfosSWA->4050->Lin1035', modeloEDD, myIdx.RA, Configs, Produto)   # arqToPhp = 'C:/wamp64/www/rd2r3/Robos/transfers/infosSwa_temp.txt';  # Transferencia de dados entre Php e Robos
                time.sleep(tCmd)       
                # myIdx.CVLAN: So tem lixo, nao ajuda muito -> analiseDados('Null',modeloEDD, myIdx.CVLAN, Configs, csvProduto)    # arqToPhp = 'C:/wamp64/www/rd2r3/Robos/transfers/infosSwa_temp.txt';  # Transferencia de dados entre Php e Robos
                # time.sleep(tCmd)            
        
            
            else:  # Cmds separados
                objBots.colar_pw_enter(self, 'sh int desc', desviaBugs)
                time.sleep(tCmd * 3)     
                ptConfigs = objBots.clickArrasteCopy(posIniArrasteCopyX, posIniArrasteCopyY, myIdx.numCOLS,  28, myIdx.SpeedARRASTE,  tCmd) 
                self.analiseDados(call,'readInfosSWA->4050->Lin1045',modeloEDD, myIdx.PTRA, ptConfigs, Produto)
                time.sleep(tCmd)

                objTerminal.prepararMoba('readInfosSWA->4050->Lin1048', 500, 500, 3, 0.2)  # Separa 
                time.sleep(0.5)
                # Essa info ja tem no Cmd abaixo -> objBots.colar_pw_enter(self, 'show run | inc name | match-all | inc '+csvProduto, desviaBugs)
                #time.sleep(tCmd)
                objBots.colar_pw_enter(self, 'show vlan brief', desviaBugs)
                time.sleep(tCmd)
                objTerminal.prepararMoba('readInfosSWA->4050->Lin1054', 500, 500, 3, 0.2)  
                time.sleep(tCmd * 3)  
                raConfigs = objBots.clickArrasteCopy(posIniArrasteCopyX, posIniArrasteCopyY, myIdx.numCOLS,  20, myIdx.SpeedARRASTE,  tCmd) 
                self.analiseDados(call,'readInfosSWA->4050->Lin1057', modeloEDD, myIdx.RA, raConfigs, Produto) # arqToPhp = 'C:/wamp64/www/rd2r3/Robos/transfers/infosSwa_temp.txt';  # Transferencia de dados entre Php e Robos
                time.sleep(tCmd)       

                """
                # myIdx.CVLAN: So tem lixo, nao ajuda muito :
                objTerminal.prepararMoba('Null', 500, 500, 3, 0.2)  # Separa 
                time.sleep(0.5)     
                objBots.colar_pw_enter(self, 'show run | inc match | match-all | inc vlan-id', desviaBugs)
                time.sleep(tCmd * 3)      
                numLinUP = posIniArrasteCopyY - (myIdx.altLinPx * 50)   # Pega 6 linhas(baixo p/ Cima)
                cVlansConfigs = objBots.clickArrasteCopy(posIniArrasteCopyX, posIniArrasteCopyY,  numLinUP, myIdx.SpeedARRASTE,  tCmd)         
                # myIdx.CVLAN: So tem lixo, nao ajuda muito -> analiseDados('Null',modeloEDD, myIdx.CVLAN, cVlansConfigs, csvProduto)  # arqToPhp = 'C:/wamp64/www/rd2r3/Robos/transfers/infosSwa_temp.txt';  # Transferencia de dados entre Php e Robos
                # time.sleep(tCmd)
                """
        
        if call == myIdx.USER:     # FUNCAO CHAMADA VIA MENU(Auto/manual)
            objTools.debbug(myIdx.noJumpLin, 'readInfosSWA(myIdx.USER, Fechando ´}` com gravar: } )')
            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, '\n}\n')   # limpar arquivo txt de Transfers dados  To Php
            #objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, '\n===========================================================================================\n')   
            objTools.debbug(myIdx.noJumpLin, 'readInfosSWA(myIdx.USER, Fechou ´}` )')
            
        if '4050' in modeloEDD:
            objBots.mover_e_clicar('readInfosSWA->4050->Lin1076', 800, 600)  
            time.sleep(0.2)  
            objWindows.zoomMais(myIdx.ZOOM, float(myIdx.ItvalZoom))                  # NORMALIZA TAMANHO DO TEXT, Devido num de linhas do 4050, Reduziu tamanho do texto da abaMoba3-acima
        
        if call == myIdx.ANALISE:     # FUNCAO CHAMADA VIA analisePendencias
            pyautogui.hotkey('enter')   # Desviar de liuxo q tenha ficado na linha
            time.sleep(0.2)
            pyautogui.hotkey('enter')   # Desviar de liuxo q tenha ficado na linha
            time.sleep(0.2)
            objBots.colar_pw_enter(self, 'exit', desviaBugs) 
            time.sleep(tCmd)     

        # finaliza istando portas
        objBots.colar_pw_enter(self, 'sh int desc', desviaBugs)  
        time.sleep(tCmd)     




    # ------------ INFOS RSD ------------------------------------------------------------------------------------------------------------------- #
    def printScreen(self, posIniArrasteCopyX, posIniArrasteCopyY, tCmd):
        # caso ocorra uma falha, da pra fazer manual e copiar por aqui  
        objTools.debbug(myIdx.noJumpLin, 'printScreen()')

        # limpar arquivo(CRIAR CABEÇARIO) txt de Transfers dados  To Php 
        objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, '\n\n')   
        objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'copyInfosRSD(Tunnel)\n')   
        objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, '{\n')   

        # Procura por resposta do router
        # Cisco deve ser: l2vpn xconnect group PW-ACESSO-L3IPD p2p 2899-i-br-ma-sls-nte-hl5g-01 neighbor ipv4 186.246.163.75 pw-id 412899
        # Nokia: sap2/1/c13/3.2061.929      2071156    11111   ip4+ip6   11111 none   Up   Up
        # Faz em 3 partes pra não ter que esperar 10 seg em uma unica parte
        getAnswer = objBots.clickArrasteCopy(posIniArrasteCopyX, posIniArrasteCopyY, myIdx.numCOLS, 25, myIdx.SpeedARRASTE,  tCmd)    # Pega resposta, se já existe...
        if 'l2vpn' not in getAnswer and 'sap' not in getAnswer and 'pw' not in getAnswer and 'dot1q' not in getAnswer:                        # SE ainda nao tem resposta... 
            time.sleep(tCmd * 3)        # aguarda + um pouco e tenta ler resposta novamente 
            getAnswer = objBots.clickArrasteCopy(posIniArrasteCopyX, posIniArrasteCopyY, myIdx.numCOLS, 25, myIdx.SpeedARRASTE,  tCmd) 
            if 'l2vpn' not in getAnswer and 'sap' not in getAnswer and 'pw' not in getAnswer and 'dot1q' not in getAnswer: 
                time.sleep(tCmd * 4)        # aguarda + um pouco e tenta ler re
                getAnswer = objBots.clickArrasteCopy(posIniArrasteCopyX, posIniArrasteCopyY, myIdx.numCOLS, 25, myIdx.SpeedARRASTE,  tCmd) 

        linGetAnswer = [linha for linha in getAnswer.split('\n') if linha.strip()]  # Remove linhas vazias

        for linAlin in  linGetAnswer:  # Agora usando linAlin em vez de Dados
            # LInha-> l2vpn xconnect group PW-ACESSO-L3IPD p2p 411869
            if 'l2vpn' in  linAlin or 'sap' in linAlin  or 'pw' in linAlin or 'dot1q' in  linAlin:     # Se linha possuir l2vpn
                objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'Id: ' + linAlin + '\n')   # fechar infos arquivo txt de Transfers dados  To Php
        
        objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, '\n}')   # fechar infos arquivo txt de Transfers dados  To Php
        

    def readInfosRSD(self, call, localizar, nomeRAgetQuery, numPtRAgetQuery, nomeHL5GQuery, nomeSVlanQuery, IPDorVPN, posIniArrasteCopyX, posIniArrasteCopyY, desviaBugs, tCmd):

        try:
            objTools.debbug(myIdx.noJumpLin, 'readInfosRSD('+str(desviaBugs)+')')

            if not objTools.validar(nomeHL5GQuery, myIdx.HL5G):
                varIni = objArquivos.lerVarsIni()
                nomeHL5GQuery = varIni[myIdx.iniHL5G]

            if desviaBugs < 1: desviaBugs = 1  

            # limpar arquivo(CRIAR CABEÇARIO) txt de Transfers dados  To Php 
            if call == myIdx.USER:    # Se funcao foi chamada pelo Usuario via Menu(Auto/Manual)
                objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, '\n\n')   
                #objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, '===========================================================================================\n')   
                objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'getInfosRSD(Tunnel)\n')   
                objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, '{\n')   
                objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'RSD:  ' + str(nomeRAgetQuery) + '\n')   
                objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'PT:  ' + str(numPtRAgetQuery) + '\n')   
                objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'HL5G: ' + str(nomeHL5GQuery) + '\n')   
                objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'SVLAN: ' + str(nomeSVlanQuery) + '\n')   

            # --------------- ID Modelo do RA -------------------------------------------------------- #
            # Alguns enter´s pra nao pegar prompt de outro
            pyautogui.hotkey('enter')
            time.sleep(0.2)
            pyautogui.hotkey('enter')
            time.sleep(0.2)
            pyautogui.hotkey('enter')
            time.sleep(0.2)
            getModel = objBots.clickArrasteCopy(posIniArrasteCopyX, posIniArrasteCopyY, myIdx.numCOLS, 5, myIdx.SpeedARRASTE,  tCmd)    # Pega resposta, se já existe...
            if '77@' in getModel: 
                modeloRA = myIdx.TACACS
                print("Modelo RA: Tacacs")
            elif 'CPU0:' in getModel: 
                modeloRA = myIdx.CISCO
                print("Modelo RA: Cisco")
            elif '*A:' in getModel or '*B:' in getModel: 
                modeloRA = myIdx.NOKIA   
                print("Modelo RA: Nokia") 
            elif '<' in getModel: 
                modeloRA = myIdx.HUAWEI
                print("Modelo RA: Huawei")
            else:
                modeloRA = myIdx.CISCO
                print("Modelo RA: None, assumido Cisco")
            
        
            # ---------------------------------------------------------------------------------------- #
            if modeloRA == myIdx.CISCO: 
                # Cria pw-id do tunnel(Cisco) (41+sVlan, 43+sVlan)
                if 'IPD' in IPDorVPN: PwIdQuery = '41'+ str(nomeSVlanQuery)
                elif 'VPN' in IPDorVPN: PwIdQuery = '43'+ str(nomeSVlanQuery)
                else: PwIdQuery = '41'+ str(nomeSVlanQuery)

            elif modeloRA == myIdx.NOKIA:      
                if '/' in numPtRAgetQuery:
                    ptPwIDNokia = numPtRAgetQuery+':'+str(nomeSVlanQuery)
                else:     
                    ptNokia  = numPtRAgetQuery.replace('p','')
                    ptNokia  = ptNokia.replace('w','')
                    ptNokia  = ptNokia.replace('e','')
                    ptPwIDNokia = ptNokia+':'

            # print('|'+str(ptPwIDNokia)+'|') # tem um'2' que esta aparecendo depois desta porta...nap sei de onde...ainda

            if localizar == myIdx.HL5G:       
                objBots.colar_pw_enter(self, 'sh conf run formal | include ' + str(nomeHL5GQuery), desviaBugs)                                        # Tenta Cisco
                objBots.colar_pw_enter(self, 'show service sap-using | match ' + str(ptPwIDNokia), desviaBugs)                                        # Tenta Nokia
                objBots.colar_pw_enter(self, 'display current-configuration | include ' + str(nomeHL5GQuery), desviaBugs)                             # Tenta Huawei
            if localizar == myIdx.PWID:
                if modeloRA == myIdx.CISCO: 
                    # objBots.colar_pw_enter(self, 'sh conf run formal | include ' + str(PwIdQuery), desviaBugs)                                        # Tenta Cisco
                    objBots.colar_pw_enter(self, 'sh conf run formal | include ' + str(nomeHL5GQuery), desviaBugs)
                elif modeloRA == myIdx.NOKIA: 
                    objBots.colar_pw_enter(self, 'show service sap-using | match ' + str(ptPwIDNokia), desviaBugs)                                    # Tenta Nokia
                elif modeloRA == myIdx.HUAWEI:         
                    objBots.colar_pw_enter(self, 'display current-configuration | include ' + str(nomeSVlanQuery), desviaBugs)                        # Tenta Huawei
                else: 
                    objBots.colar_pw_enter(self, 'sh conf run formal | include ' + str(PwIdQuery), desviaBugs)                                        # Tenta Cisco
                    
            else:
                if modeloRA == myIdx.CISCO: 
                    objBots.colar_pw_enter(self, 'sh conf run formal | include ' + str(PwIdQuery), desviaBugs)                                        # Tenta Cisco
                elif modeloRA == myIdx.NOKIA: 
                    objBots.colar_pw_enter(self, 'show service sap-using | match ' + str(ptPwIDNokia), desviaBugs)                                    # Tenta Nokia
                elif modeloRA == myIdx.HUAWEI:         
                    objBots.colar_pw_enter(self, 'display current-configuration | include ' + str(nomeSVlanQuery), desviaBugs)                        # Tenta Huawei
                else: 
                    objBots.colar_pw_enter(self, 'sh conf run formal | include ' + str(PwIdQuery), desviaBugs)                                        # Tenta Cisco
            
            
            # Procura por resposta do router
            # Cisco deve ser: l2vpn xconnect group PW-ACESSO-L3IPD p2p 2899-i-br-ma-sls-nte-hl5g-01 neighbor ipv4 186.246.163.75 pw-id 412899
            # Nokia: sap2/1/c13/3.2061.929      2071156    11111   ip4+ip6   11111 none   Up   Up
            # Faz em 3 partes pra não ter que esperar 10 seg em uma unica parte
            objWindows.myToast(self, 'Tecle!', '<Alt> Acelerar\n<Esc> Stop', 'botGetInfosRouter', 5)

            # <Esc> Interrompe processo(5* 0.2 = 1.0)
            for i in range(15):
                time.sleep(0.2)  # 0.2 * 35 = 7seg(Máx)    
                if keyboard.is_pressed('alt'): break    # acelera, sai do loop    
                if keyboard.is_pressed('esc'):
                    stop = input("Break for user. Continue?<E>")

            getAnswer = objBots.clickArrasteCopy(posIniArrasteCopyX, posIniArrasteCopyY, myIdx.numCOLS, 18, myIdx.SpeedARRASTE,  tCmd)    # Pega resposta, se já existe...
            """
            TEntei fazer em 3 partes pra ser mais rapido mas, ao dar Printda tela, router cancela
            if 'l2vpn' not in getAnswer and 'sap' not in getAnswer and 'pw' not in getAnswer and 'dot1q' not in getAnswer:                        # SE ainda nao tem resposta... 
                time.sleep(tCmd * 3)        # aguarda + um pouco e tenta ler resposta novamente 
                getAnswer = objBots.clickArrasteCopy(posIniArrasteCopyX, posIniArrasteCopyY, myIdx.numCOLS, 18, myIdx.SpeedARRASTE,  tCmd) 
                if 'l2vpn' not in getAnswer and 'sap' not in getAnswer and 'pw' not in getAnswer and 'dot1q' not in getAnswer: 
                    time.sleep(tCmd * 4)        # aguarda + um pouco e tenta ler re
                    getAnswer = objBots.clickArrasteCopy(posIniArrasteCopyX, posIniArrasteCopyY, myIdx.numCOLS, 18, myIdx.SpeedARRASTE,  tCmd) 
            """
            linGetAnswer = [linha for linha in getAnswer.split('\n') if linha.strip()]  # Remove linhas vazias
        
            for linAlin in  linGetAnswer:  # Agora usando linAlin em vez de Dados
                # LInha-> l2vpn xconnect group PW-ACESSO-L3IPD p2p 411869
                if 'l2vpn' in  linAlin or 'sap' in linAlin  or 'pw' in linAlin or 'dot1q' in  linAlin:     # Se linha possuir l2vpn
                    if call == myIdx.USER:    # Se funcao foi chamada pelo Usuario via Menu(Auto/Manual)
                        objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'Id: ' + linAlin + '\n')   # fechar infos arquivo txt de Transfers dados  To Php    
                    elif call == myIdx.ANALISE:    # Se funcao foi chamada por analisePendencias()
                        objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, 'Id: ' + linAlin + '\n')   # fechar infos arquivo txt de Transfers dados  To Php
            
            if call == myIdx.USER:    # Se funcao foi chamada pelo Usuario via Menu(Auto/Manual)
                objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, '\n}')   # fechar infos arquivo txt de Transfers dados  To Php
                objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, '\n===========================================================================================\n')   

            
            if call == myIdx.ANALISE:    # Se funcao foi chamada por analisePendencias()
                getModel = objBots.clickArrasteCopy(posIniArrasteCopyX, posIniArrasteCopyY, myIdx.numCOLS, 5, myIdx.SpeedARRASTE,  tCmd)    # Pega resposta, se já existe...
                if '80969577' in getModel: 
                    modeloRA = myIdx.TACACS
                else:        
                    if modeloRA == myIdx.CISCO: objBots.colar_pw_enter(self, 'exit')  
                    elif modeloRA == myIdx.NOKIA: objBots.colar_pw_enter(self, 'logout')         
                    elif modeloRA == myIdx.HUAWEI: objBots.colar_pw_enter(self, 'quit')
                    else: objBots.colar_pw_enter(self, 'exit')  
                time.sleep(tCmd)
                
            # finaliza istando portas
            #objBots.colar_pw_enter(self, 'sh int desc', desviaBugs)  
            #time.sleep(tCmd)    
        except Exception as e:
            print(f"Exception readInfos()->lin1846:  {e}")
        
        #except Exception:
        #        print(f"Exception readInfos()->lin1846")
            

    # -------------------------------------------------------------------------------------------------------------------------------- #
    def catDeviceList(self, call, ufSwaX, nomeSwaX, folhaMobaX, folhaMobaY, posIniArrasteCopyX, posIniArrasteCopyY, tFast):
    
        #---------------- ESTES CODES(#pyautogui.write('cat /deviceList'))
        #  BUGGAM O MOBA(FECHA A ABA) (Achei que era->SCROLL-LOCK ESTAVA ACIONADA mas não é
        #  - TIVE DE USAR S[O MOUSE -----------------#
        ufSwa = str(ufSwaX).lower()
        nomeSwa = str(nomeSwaX).lower()

        if call == myIdx.USER:
            # limpar arquivo(CRIAR CABEÇARIO) txt de Transfers dados  To Php 
            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.CLEAR, '\n===========================================================================================\n')  
            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'Bot getCatDevice()\n')   
            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, '{\n')              
        if call == myIdx.ANALISE:
            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.CLEAR, '\n')  # Se chamada a funcao veio de analisePendencias()...zera arquivo_temp transfer de variaveis
        
        objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'Source To: '+ufSwa+' and '+nomeSwa+'\n')

        # Usando Paste com Mouse
        cmdX = 'cat /deviceList | grep ' + str(nomeSwa)
        pyperclip.copy(cmdX)    # envia p/ clipboard           
        time.sleep(tFast)   

        objBots.mover_e_clicar('catDeviceLista()', folhaMobaX, folhaMobaY)      # janela php
        pyautogui.rightClick()                      # btn Dir do Mouse
        time.sleep(tFast)
        # objBots.mover_e_clicar('Unknown', folhaMobaX + 50, folhaMobaY - 496)   # ajusta em: Paste
        # objBots.mover_e_clicar('Unknown', folhaMobaX + 50, folhaMobaY - myIdx.ajtPASTE)   # ajusta em: Paste
        objBots.mover_e_clicar('catDeviceLista()', folhaMobaX + 50, folhaMobaY - myIdx.ajtPASTE)   # Teste nOTE(-559) no notepad++ -> ajusta em: Paste
        time.sleep(tFast)
        pyautogui.hotkey('enter')
        time.sleep(tFast)
        pyperclip.copy('')
        #--------------------------------------------------------------------------------#
        time.sleep(tFast*2)
        copyDevice = objBots.clickArrasteCopy(posIniArrasteCopyX, posIniArrasteCopyY, myIdx.numCOLS, 12, myIdx.SpeedARRASTE, tFast)
        time.sleep(tFast)
        # Antes de colar no php...filtre    
        # 2. Filtrar linhas com 'osb-swa'           
        # Separa em linhas
        # Ja foi validado antes -> ufSwa = objTools.getLetras(ufSwa)
        print("UF: "+ufSwa)
        foundSwa = False
        linDevice = copyDevice.splitlines()  # Separa em linhas
        # Imprime linha por linha
        for linha in linDevice:
            # Nao usar nomeSwa, pois esta em todas as linhas - use: 'm-br' + 'uf'(para checkar se estado é o correto)
            objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, linha+'\n')   # Gravar nomeSWA+IP(m-br-pe-rce-osb-swa-01 10.227.174.226) em arquivo txt de Transfers dados  To Php

            if 'm-br-'+str(ufSwa) in linha: 
                # objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'm-br + '+ufSwa+' -> '+ linha + '\n')   # Gravar nomeSWA+IP(m-br-pe-rce-osb-swa-01 10.227.174.226) em arquivo txt de Transfers dados  To Php
                nomeSwaGetQuery = linha            # DE: m-br-pe-rce-osb-swa-01 10.227.174.226     ->      Pega(23 chars): m-br-pe-rce-osb-swa-01 
                if ufSwa in linha: 
                    objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, linha + '\n')   # Gravar nomeSWA+IP(m-br-pe-rce-osb-swa-01 10.227.174.226) em arquivo txt de Transfers dados  To Php
                    nomeSwaGetQuery = linha            # DE: m-br-pe-rce-osb-swa-01 10.227.174.226     ->      Pega(23 chars): m-br-pe-rce-osb-swa-01 
                    foundSwa = True
                else:
                    objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'UF=|'+ ufSwa + '|\n')   # Gravar nomeSWA+IP(m-br-pe-rce-osb-swa-01 10.227.174.226) em arquivo txt de Transfers dados  To Php
            
            # objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, '\n catDevice->(gb)swa: '+ nomeSwaGetQuery + '\n')   # Gravar nomeSWA+IP(m-br-pe-rce-osb-swa-01 10.227.174.226) em arquivo txt de Transfers dados  To Php

        if(foundSwa):
            # E gravado aqui mas apaga em: readInfosSWA
            nomeSwaGetQueryFmt = nomeSwaGetQuery[0:23]       # PegaNome sem IP DE: (m-br-pe-rce-osb-swa-01 10.227.174.226
            ipSwaGetQueryFmt = nomeSwaGetQuery[23:40]       # PegaIP DE: (m-br-pe-rce-osb-swa-01 10.227.174.226
            varGbl_NomeSWA = nomeSwaGetQuery             # Nome + IP: Swa
            varGblNomeSwa = nomeSwaGetQueryFmt              # Nome: Swa
            varGblIpSwa = ipSwaGetQueryFmt                  # Ip: Swa
            # Salva vars em arq.ini(pra nao perder infos)
            print('catDeviceList(gravando... '+varGblNomeSwa+', '+varGblIpSwa+')')
            # block->objArquivos.gravarVarsIni(myIdx.JOB, myIdx.arqVarsINI, siglaUF=ufSwaX, nomeSWA=nomeSwaX, ipSWA='', nomeRA='',  numPtRA='', numGVLAN='', numSVLAN='', nomeHL5G='')   # Aqui ='' não possui essas infos, so mais a frrente
            objArquivos.gravarVars1a1Ini(myIdx.arqVarsINI, myIdx.JOB, myIdx.iniNmSWA, str(varGblNomeSwa)) 
            objArquivos.gravarVars1a1Ini(myIdx.arqVarsINI, myIdx.JOB, myIdx.iniIpSWA, str(varGblIpSwa))
            if call == myIdx.USER:           
                objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'nomeIpSwa='+varGbl_NomeSWA + '\n')    # Usado p/ comunicar entre phpe python, Grava em arq.ini -> consultado via Swa filtrado so nome                           
                objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'nomeSWA=' + varGblNomeSwa + '\n')    # Usado p/ comunicar entre phpe python, Grava em arq.ini -> consultado via Swa filtrado so nome                   
                objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, 'ipSWA=' + varGblIpSwa + '\n')    # Usado p/ comunicar entre phpe python, Grava em arq.ini -> consultado via Swa filtrado so nome                   
                objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, '\n}\n')
                

                #objArquivos.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhp, myIdx.ADD, '\n}\n-------------------------------------------------------------------------------------------\n')
            elif call == myIdx.ANALISE:  # analisePendendencias(lista de tickets importSAE)
                objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, 'nomeIpSwa='+varGbl_NomeSWA + '\n') 
                objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, 'nomeSWA='+ varGblNomeSwa + '\n')   
                objArquivos.gravar_infosArqTransferPhp(myIdx.analiseSaePyToPhp, myIdx.ADD, 'ipSWA='+ varGblIpSwa + '\n')               

        
            return varGblIpSwa   # Retorna IP do SWA
        else:
            return myIdx.NULL


   