"""
by: Treuk, Velislei A
email: velislei@gmail.com
Copyright(c) Set2025-2026
All Rights Reserveds    
Uso exclusivo para estudantes de código
"""
import ipaddress
import time
import subprocess
import configparser
import pyautogui
import pyperclip
import os
import ctypes
import sys
from typing import Final
from datetime import datetime


#--- Posicionar janela ---
import os
import sys
import ctypes
from ctypes import wintypes
#--- Posicionar janela ---
import pygetwindow as gw    # Ativar janela(Moba)


_noJumpLin: Final = 0     # Add 1 Linha(extra-pra separa logs) antes
_addJumpLin: Final = 1   # Se Add Lin 
DEBBUG: Final = 1

# Path´s
#_infosSWA: Final = 'C:/wamp64/www/rd2r3/Robos/transfers/infosSwa_temp.txt'
#_dadosTKT: Final = 'C:/wamp64/www/rd2r3/Robos/transfers/dadosTicket_temp.csv'

_pcTEL: Final = False  # Comuta Dir config.ini entre notebook Tel e PC do Iury
_infosSWA: Final = 'F:/Projetos/Python/botGetInfosSwa/infosSwa_temp.txt'
_dadosTKT: Final = 'F:/Projetos/Python/botGetInfosSwa/dadosTicket_temp.csv'

# Endereço Celula DadosTicket.csv
_ID: Final = 0           # USA EM RoboCadFlow
_PDT: Final = 1           # USA EM RoboCadFlow
_CLIENTE: Final = 2      # USA EM RoboCadFlow
_SWA: Final = 3          # USA EM RoboCadFlow
_OPER: Final = 4            # USA EM RoboAlocPorta
_SWT: Final = 5          # USA EM RoboCadFlow
_IPSWT: Final = 6        # USA EM RoboCadFlow
_SPEED: Final = 7        # USA EM RoboCadFlow/AlocPorta
_SVLAN: Final = 8           # USA EM RoboAlocPorta
_CVLAN: Final = 9        # USA EM RoboCadFlow/AlocPorta
_EDD: Final = 10        # So uso aqui
_DATA: Final = 11        # NAO USA aqui
_ATP: Final = 12        # NAO USA aqui
_UF: Final = 13        # So uso aqui - Checkar se SWA esta correto


_NULL: Final = "Null"   # Retorno nulo(caso nao ache dados)

_UND: Final = 0         # TIPO DE CHECK CONFIGS-UNIDADE, CMD A CMD
_LOTE: Final = 1        # LOTE DE CMDS  
_PORTA: Final = 1        # Tipo de dados analisados
_NAME: Final = 2        # Tipo de dados analisados
_RA: Final = 3        # Tipo de dados analisados
_CVLAN: Final = 4        # Tipo de dados analisados


_CLEAR: Final = 'w'    # Tipo de manipulação de arquivo txt, limpar td, ou adicionar linhas
_ADD: Final = 'a'

_altLinPx: Final = 25   # num pixels por linha

# Inicializa var
IdOrdem = None
Produto = None
nomeSwa = None
modeloEDD = None

NomeSWAGlobal = ""
NomeRaGlobal = ""
NomeHL5gGlobal = ""
    

def debbug(jumpLIN, linha):
    if DEBBUG: 
        # Obtém a data e hora atual
        #data_hora_atual = datetime.now()

        # Formata a data e hora como string
        fmtData = datetime.now().strftime("%d/%m/%Y")             
        fmtHora = datetime.now().strftime("%H:%M:%S")             
        try:            
            with open("debbug.txt", "a") as arquivo:  # Usa o modo 'a' para adicionar conteúdo ao arquivo.
                if jumpLIN == _addJumpLin: 
                    arquivo.write("\n")  # Adiciona a mensagem com uma quebra de linha.
                    arquivo.write("Debbug[" + fmtData + "] " + linha +"\n")
                if jumpLIN == _noJumpLin: 
                    arquivo.write("Debbug[" + fmtHora + "] " + linha +"\n")  # Sem Add Lin a mensagem com uma quebra de linha.            
                           
        except Exception as e:
            print(f"Erro ao escrever no log: {e}")





def posicionar_janela(pos_x, pos_y):
    """Posiciona a janela do console no canto superior direito da tela (Windows)"""
    try:
        # Obtém o handle da janela do console
        hwnd = ctypes.windll.kernel32.GetConsoleWindow()
        
        if hwnd:
            # Obtém a resolução da tela
            user32 = ctypes.windll.user32
            largura_tela = user32.GetSystemMetrics(0)
            altura_tela = user32.GetSystemMetrics(1)
            
            # Define o tamanho desejado da janela
            largura_janela = 55
            altura_janela = 15
                                 
            # Reposiciona e redimensiona a janela
            ctypes.windll.user32.SetWindowPos(
                hwnd, 
                0,  # HWND_TOP
                pos_x, 
                pos_y, 
                largura_janela, 
                altura_janela, 
                0x0001 | 0x0004  # SWP_NOSIZE | SWP_NOZORDER
            )
            
            # Força o redimensionamento se necessário
            ctypes.windll.user32.SetWindowPos(
                hwnd,
                0,
                pos_x,
                pos_y,
                largura_janela,
                altura_janela,
                0x0002 | 0x0004  # SWP_NOMOVE | SWP_NOZORDER
            )
            
    except Exception as e:
        print(f"Erro ao posicionar janela: {e}")



def colar_pw_enter(conteudo, desviaBugs):
    debbug(_noJumpLin, 'colar_pw_enter('+conteudo+')')
    
    pyautogui.write(conteudo)
    pyautogui.hotkey('shift', 'insert')
    time.sleep(0.2)
    pyperclip.copy('')
    
    #Devido Bugs da conexao...contorna problemas(lixo criado no Moba)
    for _ in range(desviaBugs):
        pyautogui.hotkey('backspace')
        time.sleep(0.1)           
    pyautogui.hotkey('space')
    time.sleep(0.2)

    pyautogui.hotkey('enter')
    pyperclip.copy('')


def logar(host, pwLog, cmdMobaX, cmdMobaY, tFast, tLogar, desviaBugsLgX, shAppX, shAppY):
    debbug(_noJumpLin, 'logar('+str(host)+', '+str(pwLog)+',,,,,,,,)')
    
    pyperclip.copy('')
    time.sleep(tFast)
    limpar(20)
    key()   # Lembra de password    
    mover_e_clicar(cmdMobaX, cmdMobaY)
    time.sleep(tFast)
    time.sleep(tFast)
    colar_pw_enter('ssh '+host, desviaBugsLgX) 
    time.sleep(tLogar)                 # Aguarda User digitar senha para prosseguir        
   
    debbug(_noJumpLin, 'desviaBugs = 1 - [BackSpace] - L208 - block')
    limpar(20)
    key()        
    #mover_e_clicar(shAppX, shAppY)  # Trasfere jan-app para tela
    #time.sleep(tFast)  
    #mover_e_clicar(cmdMobaX, cmdMobaY) # Click no campo janela Moba
  
    # -------------------------------------------------------------------------------------- #
    # Precisa usar o Mouse-Dir->Paste pois auto-colar(shift+insert ou ctrl+v) Buga
    # Usando Paste com Mouse
    pyperclip.copy(pwLog)              # Envia Senha para area-ClipBoard 
    time.sleep(tFast)
    mover_e_clicar(cmdMobaX, cmdMobaY) # Click no campo janela Moba
    time.sleep(tFast)
    pyautogui.rightClick()                      # btn Dir do Mouse
    time.sleep(tFast)
    mover_e_clicar(cmdMobaX + 50, cmdMobaY - 496)   # ajusta Pos em selecionar: Paste
    time.sleep(tFast)
    pyautogui.hotkey('enter')
    time.sleep(tFast)
    # -------------------------------------------------------------------------------------- #
    pyperclip.copy('')  # Limpar Clipboard antes de iniciar testes IP - necessario pois esta ficando lixo                 
        




def mover_e_clicar(x, y):
    debbug(_noJumpLin, 'mover_e_clicar('+str(x)+', '+str(y)+')')
    pyautogui.moveTo(x, y)
    pyautogui.click()

def mover_e_copiar(x, y):
    debbug(_noJumpLin, 'mover_e_copiar()')
    pyautogui.moveTo(x, y)
    for _ in range(3):
        pyautogui.click()
        time.sleep(0.2)
    pyautogui.hotkey('ctrl', 'c')
    time.sleep(0.5)

def mover_e_colar(x, y):
    debbug(_noJumpLin, 'mover_e_colar()')
    pyautogui.moveTo(x, y)    
    pyautogui.click()
    time.sleep(0.5)
    pyautogui.hotkey('ctrl', 'v')
    time.sleep(0.5)

def moveClickColaEnter(conteudo, x, y):
    debbug(_noJumpLin, 'moveClickColaEnter()')
    pyautogui.moveTo(x, y)    
    pyautogui.click()
    pyautogui.write(conteudo)
    time.sleep(0.5)
    pyautogui.hotkey('ctrl', 'v')    
    time.sleep(0.5)
    pyautogui.hotkey('enter')
    pyautogui.hotkey('enter')
    time.sleep(0.5)

def formatar(codigo, num):
    debbug(_noJumpLin, 'formatar()')
    # Verifica se o código segue o formato esperado e tem comprimento adequado
    if len(codigo) >= 18 and codigo[8] == '-' and codigo[9:].isalnum():
        # Extrai os últimos 7 caracteres após o hífen
        return codigo[-num:]
    else:
        return codigo
        #raise ValueError("Código não está no formato esperado")


def zoomMais(quantidade=1, intervalo=0.1):
    """
    Segura Ctrl e rola para frente (zoom in/para cima).
    
    Parâmetros:
    quantidade (int): Número de vezes a rolar
    intervalo (float): Intervalo entre os scrolls
    """
    # Pressiona e segura Ctrl
    pyautogui.keyDown('ctrl')
    
    # Rola para frente (positivo = para cima)
    for _ in range(quantidade):
        pyautogui.scroll(120)  # Valor positivo rola para frente/zoom in
        time.sleep(intervalo)
    
    # Libera Ctrl
    pyautogui.keyUp('ctrl')


def zoomMenos(quantidade=1, intervalo=0.1):
    """
    Segura Ctrl e rola para trás (zoom out/para baixo).
    
    Parâmetros:
    quantidade (int): Número de vezes a rolar
    intervalo (float): Intervalo entre os scrolls
    """
    # Pressiona e segura Ctrl
    pyautogui.keyDown('ctrl')
    
    # Rola para trás (negativo = para baixo)
    for _ in range(quantidade):
        pyautogui.scroll(-120)  # Valor negativo rola para trás/zoom out
        time.sleep(intervalo)
    
    # Libera Ctrl
    pyautogui.keyUp('ctrl')


def colar_e_enter(conteudo, tCurto): 
    debbug(_noJumpLin, 'colar_e_enter()')   
    pyautogui.write(conteudo)
    pyautogui.hotkey('shift', 'insert')
    time.sleep(tCurto)    
    pyautogui.hotkey('enter')
    pyperclip.copy('')

def colar_space_enter(conteudo, tCurto): 
    debbug(_noJumpLin, 'colar_space_enter()')   
    pyautogui.write(conteudo)
    pyautogui.hotkey('shift', 'insert')
    time.sleep(tCurto)    
    pyautogui.hotkey('enter')
    pyperclip.copy('')


#------------ Ler arq-transfer com dados da Pagina -----------#
def separaCelulas(linha):
    debbug(_noJumpLin, 'separaCelulas()')   
    # Separa a linha usando o delimitador ';' e retorna uma lista com os dados
    return linha.split(";")

def lerArqDadosTicket():

    debbug(_noJumpLin, 'lerArqDadosTicket()')   

    # Inicializa uma lista para armazenar as linhas
    linhas = []
    #              C:\wamp64\www\rd2r3\Robos\transfers/dadosTicket_temp.csv
    arquivo_csv = _dadosTKT # Transferencia de dados entre Php e Robos

    # INICIALMENTE ESTA ASSIM:
    # 0         1   2                       3           4
    # 2119670	IPD	ENERGISA SOLUCOES SA	osb-swa-01	ERB


    try:
        # Abre o arquivo em modo de leitura    
        # with open(arquivo_csv, 'r') as arquivo:    # Aqui funciona so no VSCode(.exe NAO funciona)
        with open(arquivo_csv, 'r', encoding='ISO-8859-1') as arquivo:
            # Lê todas as linhas e adiciona na lista
            linhas = arquivo.readlines()
    except FileNotFoundError:
        debbug(_noJumpLin,'ler_dadosTicket(O arquivo:' +  arquivo_csv + ' não foi encontrado.)')
        # print("O arquivo dadosTicket.csv não foi encontrado.")
    except Exception as e:
        debbug(_noJumpLin,f"Ocorreu um erro: {e} -> " +  arquivo_csv)
        # print(f"Ocorreu um erro: {e}")
    
    return linhas


#-------------------------------------------------------------------------------#
# Lê dados do Ticket
def getDadosTkt(): 
    dadosTicket = lerArqDadosTicket()   # carrega dados do Ticket
    debbug(_noJumpLin,'getDadosTkt()')

    linDadosTicket = separaCelulas(dadosTicket[0])  
    
    dados = {}
    dados[_ID] = linDadosTicket[_ID]
    dados[_PDT] = linDadosTicket[_PDT]
    dados[_CLIENTE] = linDadosTicket[_CLIENTE]
    dados[_SWA] = linDadosTicket[_SWA]
    dados[_OPER] = linDadosTicket[_OPER]
    dados[_SWT] = linDadosTicket[_SWT]
    dados[_IPSWT] = linDadosTicket[_IPSWT]
    dados[_SPEED] = linDadosTicket[_SPEED]+'.0'
    dados[_SVLAN] = linDadosTicket[_SVLAN] 
    dados[_CVLAN] = linDadosTicket[_CVLAN] 
    dados[_EDD] = linDadosTicket[_EDD] 
    dados[_UF] = linDadosTicket[_UF] 
  
    return dados  

  

def prepararMoba(abaMoba3X, abaMoba3Y, nEnter, tFast):
    debbug(_noJumpLin, 'prepararMoba()')

    #print("preparar()")
    pyperclip.copy('')
    # Executar comandos na aba 1
    mover_e_clicar(abaMoba3X, abaMoba3Y)
    pyautogui.hotkey('space')
    time.sleep(tFast)
    for _ in range(nEnter): # Num.Enter(Limpar lixos) no Moba antes de iniciar cmd
        pyautogui.hotkey('enter')
        time.sleep(tFast)  


def clickArrasteCopy(start_x, start_y, end_x, end_y, tFast):
    """
    Move the mouse to the starting position, click and drag to the ending position,
    and copy the selection to the clipboard.

    Parameters:
        start_x (int): Starting X coordinate.
        start_y (int): Starting Y coordinate.
        end_x (int): Ending X coordinate.
        end_y (int): Ending Y coordinate.
    """
    debbug(_noJumpLin, 'clickArrasteCopy('+str(start_x)+', '+str(start_y)+', '+str(end_x)+', '+str(end_y)+', '+str(tFast)+')')
    
    try:
        # Move to the start position
        pyautogui.moveTo(start_x, start_y, duration=0.2)
        
        # Click and hold
        pyautogui.mouseDown()

        # Drag to the end position
        pyautogui.moveTo(end_x, end_y, duration=0.5)

        # Release the mouse
        pyautogui.mouseUp()

        # Wait for the selection to be made
        time.sleep(tFast)

        # Copy the selection to clipboard (Ctrl+C)
        pyautogui.hotkey('ctrl', 'c')

        # Wait a moment to ensure clipboard is updated
        time.sleep(tFast)

        # Retrieve the copied content
        copied_content = pyperclip.paste()
        pyperclip.copy('')
        return copied_content

    except Exception as e:
        print(f"An error occurred: {e}")
        return None


def gravar_infosArqTransferPhp(tipo, linha):
    # GRAVA LINHAS LIDAS NO SWA(INFOS)
    arqToPhp = _infosSWA  # Transferencia de dados entre Php e Robos
          
    try:            
        with open(arqToPhp, tipo) as arquivo:  # Usa o modo: 'w' limpa e 'a' para adicionar conteúdo ao arquivo.
            arquivo.write(linha)  # Sem Add Lin a mensagem com uma quebra de linha.            
                        
    except Exception as e:
        print(f"Erro ao escrever no log: {e}")



# Le arquivo, e retorna valor da linha solicitada
def ler_infosArqTransferPhp(caminho_arquivo, string_busca):
    """
    Versão simples: retorna a linha inteira que contém a string
    Retorna None se não encontrar
    """
    caminho_arquivo = _infosSWA;  # Transferencia de dados entre Php e Robos
    resLin = ""
    try:
        with open(caminho_arquivo, 'r', encoding='utf-8') as arquivo:
            for linha in arquivo:
                if string_busca in linha:
                        resLin = linha.rstrip('\n')
                        resLinX = resLin.replace(string_busca+'=', '')  # tira <tag> de busca
                        return resLinX
                
        return None
    except:
        return None
    


def analiseDados(modeloEDD, procurar, Dados, IpdOrVpn):
    debbug(_noJumpLin, 'analiseDados('+str(procurar)+', '+Dados+')')

    linDados = [linha for linha in Dados.split('\n') if linha.strip()]  # Remove linhas vazias
    memLinAnterior = ""

    # _PORTA -> prucura por linha q contem Porta: th 1/1 :  IP_ULK#FIBRA#i-br-pe-rce
    # _RA -> prucura por linha q contem RA: ame IPD#pe-rce-rce-rsd-01#0/6/0/28
    # _CVLAN -> prucura por linha q contem cVlan: vlan-translate ingress-table replace
    
    
    # 1/1/24   IP_ULK@FIBRA@[23]i-br-se-aju-cma-hl5g-01[46]@201.26.249.122@0/2/2@1G@
    # posiçoes iniciais-possiveis
    posIninmHL5 = 23
    posFimnmHL5 = 46
    for linAlin in linDados:  # Agora usando linAlin em vez de Dados
        # print("Linha >>> " + linAlin)
        #if "2104G" in modeloEDD or "4370" in modeloEDD or "4270" in modeloEDD or "4050" in modeloEDD or "4250" in modeloEDD:
        if procurar == _PORTA:
            for i in range(1, 5):
                busca = "FIBRA"
                if busca in linAlin:  # Corrigido: usar linAlin em vez de Dados 
                    if memLinAnterior != linAlin:        # Evita dados repetidos                  
                        gravar_infosArqTransferPhp(_ADD, linAlin)  # Imprime no arq.txt de transferencia ToPhp 
                        memLinAnterior = linAlin

                    # PROCURA POR iP DO hL5G ->(Eth 1/1 :  IP_ULK#FIBRA#i-br-pe-rce-osb-hl5g-01#200.161.33.189#0/2/26#1G#)
                    if 'hl5' in  linAlin:
                        # Pega NOme-HL5G - Melhor usar nome, tem mais infos no RSD
                        # Testa se encontrou posição
                        if  linAlin.find('i-br') > 0:  posIninmHL5 = linAlin.find('i-br')    # |i-br|-pe-rce-osb-hl5g-01  
                        else: posIninmHL5 = 23              # valor, possivel-padrão(4050, ver p/ outros Dms)

                        posFimnmHL5 = posIninmHL5 + 23          # i-br-pe-rce-osb-hl5g-01<-
                        nmHL5Gtemp = linAlin[posIninmHL5: posFimnmHL5]
                        gravar_infosArqTransferPhp(_ADD, 'nomeHL5G=' + nmHL5Gtemp + '\n')    #Grava em arq.ini -> IP DO HL5 consultado via Swa filtrado so nome   
                        
                        # Testa se achou posição...Pega IP-HL5G
                        if  linAlin.find('hl5') > 0:  posIniHL5 = linAlin.find('hl5') + 8   # hl5g-01#200.161.33.189
                        else: posIniHL5 = 39        # tenta posição posivel...padrao(4050 ver p/ outros)                       
                        posFimHL5 = posIniHL5 + 15          # XXX.XXX.XXX.XXX <- pOSSIBILIDADE TOTAL, DEPOIS TEM QUE FILTRAR
                        ipHL5GtempA = linAlin[posIniHL5: posFimHL5]
                        ipHL5GtempB = ipHL5GtempA.replace('#', '')
                        gravar_infosArqTransferPhp(_ADD, 'ipHDL5G=' + ipHL5GtempB + '\n')    #Grava em arq.ini -> IP DO HL5 consultado via Swa filtrado so nome          


        if "2104G" in modeloEDD:      
            if procurar == _RA:
                if "interface vlan" in linAlin or "name" in linAlin:  # Corrigido: usar linAlin em vez de Dados                    
                    if memLinAnterior != linAlin:        # Evita dados repetidos                  
                        gravar_infosArqTransferPhp(_ADD, linAlin)  # Imprime no arq.txt de transferencia ToPhp 
                        memLinAnterior = linAlin

                # Filtra por linha q contem: 
                # name IPD#pe-rce-rce-rsd-01#0/6/0/28
                # ou...
                # name VPN#pe-rce-rce-rsd-01#0/6/0/3               
                IpdOrVpnX = IpdOrVpn.lower()  # Garante busca case-insensitive                         
                if "name" in linAlin:                        # PEGA LINHA COM RSD ->  name IPD#pe-rce-rce-rsd-01#0/6/0/28                   
                    if "rsd-" in linAlin or "rai-" in linAlin or "rav-" in linAlin:  # PEGA LINHA COM RSD ->  name IPD#pe-rce-rce-rsd-01#0/6/0/28                   
                        gravar_infosArqTransferPhp(_ADD, linAlin)                  # Imprime no arq.txt de transferencia ToPhp                         
                        #-------------------------------------------------------------#
                        # filtrar(nome RA) de:  name IPD#pe-rce-rce-rsd-01#0/6/0/28 
                        # Filtra por linha q contem: 
                            # name IPD#pe-rce-rce-rsd-01#0/6/0/28
                        # ou...
                            # name VPN#pe-rce-rce-rsd-01#0/6/0/3
                        
                        linRA = linAlin.lower()  # Garante busca case-insensitive                   
                        if  IpdOrVpnX in linRA:
                            gravar_infosArqTransferPhp(_ADD, 'RA: ' + linAlin)                  # Imprime no arq.txt de transferencia ToPhp                         
                   
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
                            
                            gravar_infosArqTransferPhp(_ADD, 'nomeRA=' + nomeRAgetQuery + '\n') # Grava em arq.ini nomeRA atual 9NAO CONSEGUI GRAVAR EM UMA VAR GLOBAL)

    
                    #-------------------------------------------------------------#


            if procurar == _CVLAN:
                if "new-vlan" in linAlin:  # Corrigido: usar linAlin em vez de Dados                   
                    if memLinAnterior != linAlin:        # Evita dados repetidos                  
                        gravar_infosArqTransferPhp(_ADD, linAlin)  # Imprime no arq.txt de transferencia ToPhp 
                        memLinAnterior = linAlin 
     
        # --------------- 4050/4370 --------------------------------------------------------------------------------- #
        # Posicoes Incial/Final padrao para linha(4050): Bot->vlan-id=2515  IPD@se-aju-ebt-rai-01@4/2/6   static  8
        posIniRsd = 23
        posFimRsd = 41

        if "4370" in modeloEDD or "4050" in modeloEDD:      
            if procurar == _RA:
                if "name" in linAlin:  # Corrigido: usar linAlin em vez de Dados                    
                    if memLinAnterior != linAlin:        # Evita dados repetidos                  
                        gravar_infosArqTransferPhp(_ADD, linAlin)  # Imprime no arq.txt de transferencia ToPhp 
                        memLinAnterior = linAlin  

                if "static" in linAlin:  # Corrigido: usar linAlin em vez de Dados                    
                    if memLinAnterior != linAlin:        # Evita dados repetidos                  
                        gravar_infosArqTransferPhp(_ADD, 'Bot->vlan-id='+linAlin)  # Bot->vlan-id=...para Php reconhecer linha c/ sVlans
                        memLinAnterior = linAlin  

                        IpdOrVpnX = IpdOrVpn.lower()  # Garante busca case-insensitive   
                        linRA = linAlin.lower()                      
                        if IpdOrVpnX in linRA:                        # PEGA LINHA COM RSD ->  name IPD#pe-rce-rce-rsd-01#0/6/0/28                   
                            gravar_infosArqTransferPhp(_ADD, 'RA: ' + linRA)                  # Imprime no arq.txt de transferencia ToPhp                         

                            # Teste se achou posicao, caso nao pega valor padrao
                            if linRA.find('@') > 0: posIniRsd = linRA.find('@') + 1 # rsd-01 
                            else: posIniRsd = 23

                            # Teste se achou posicao, caso nao pega valor padrao
                            if linRA.find('rsd-') > 0 or linRA.find('rai-') > 0 or linRA.find('rav-'):                           
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
                            
                            gravar_infosArqTransferPhp(_ADD, 'nomeRA=' + nomeRAgetQuery + '\n') # Grava em arq.ini nomeRA atual 9NAO CONSEGUI GRAVAR EM UMA VAR GLOBAL)


            if procurar == _CVLAN:
                if " vlan-id" in linAlin:  # Corrigido: usar linAlin em vez de Dados                   
                    if memLinAnterior != linAlin:        # Evita dados repetidos                  
                        gravar_infosArqTransferPhp(_ADD, linAlin)  # Imprime no arq.txt de transferencia ToPhp 
                        memLinAnterior = linAlin  
     


# ------------ INFOS RSD ------------------------------------------------------------------------------------------------------------------- #

def readInfosRSD(nomeRAgetQuery, nomeHL5GQuery, cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, desviaBugs, tCmd):

    debbug(_noJumpLin, 'readInfosRSD()')

    # limpar arquivo(CRIAR CABEÇARIO) txt de Transfers dados  To Php 
    gravar_infosArqTransferPhp(_ADD, '\n\n')   
    gravar_infosArqTransferPhp(_ADD, '===========================================================================================\n')   
    gravar_infosArqTransferPhp(_ADD, 'getInfosRSD(Tunnel)\n')   
    gravar_infosArqTransferPhp(_ADD, '{\n')   
    gravar_infosArqTransferPhp(_ADD, 'RSD:  ' + str(nomeRAgetQuery) + '\n')   
    gravar_infosArqTransferPhp(_ADD, 'HL5G: ' + str(nomeHL5GQuery) + '\n')   

    
    colar_pw_enter('display current-configuration | include ' + str(nomeHL5GQuery), desviaBugs)  # Tenta Huawei
    colar_pw_enter('sh conf run formal | include ' + str(nomeHL5GQuery), desviaBugs)             # Tenta Cisco
    time.sleep(tCmd * 5) 
    numLinUP = cpPosIniTxtTesteY - (_altLinPx * 18)   # Pega 6 linhas(baixo p/ Cima) (980 - (25*6)) = 830  
    getAnswer = clickArrasteCopy(cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, numLinUP, tCmd) 
    
    gravar_infosArqTransferPhp(_ADD, getAnswer + '\n')   # fechar infos arquivo txt de Transfers dados  To Php
    gravar_infosArqTransferPhp(_ADD, '\n}')   # fechar infos arquivo txt de Transfers dados  To Php
    gravar_infosArqTransferPhp(_ADD, '\n===========================================================================================\n')   

    # finaliza istando portas
    #colar_pw_enter('sh int desc', desviaBugs)  
    #time.sleep(tCmd)     


# ------------ INFOS SWA-------------------------------------------------------------------------------------------------------------------- #
def readInfosSWA(IpNomeSwaGetCatDevice, nomeSwaGetQuery, IdOrdem, Produto, cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, tipoCheck, desviaBugs, tCmd):

    debbug(_noJumpLin, 'readInfosSWA('+IpNomeSwaGetCatDevice+','+nomeSwaGetQuery+', '+IdOrdem+', '+Produto+')')

    # limpar arquivo(CRIAR CABEÇARIO) txt de Transfers dados  To Php 
    gravar_infosArqTransferPhp(_CLEAR, '\n===========================================================================================\n')  
    gravar_infosArqTransferPhp(_ADD, 'Bot getInfosSwa()\n')   
    gravar_infosArqTransferPhp(_ADD, '{\n')   
    gravar_infosArqTransferPhp(_ADD, IpNomeSwaGetCatDevice + '\n')   
    gravar_infosArqTransferPhp(_ADD, nomeSwaGetQuery + '\n')   

    modeloEDD = ""
    
    # Testar se Versao = DM4050/4370
    colar_pw_enter('show vlan brief', desviaBugs)
    time.sleep(tCmd * 3) 
    numLinUP = cpPosIniTxtTesteY - (_altLinPx * 12)   # Pega 6 linhas(baixo p/ Cima) (980 - (25*6)) = 830  
    getAnswer = clickArrasteCopy(cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, numLinUP, tCmd) 
    
    if 'Invalid' in getAnswer:  modeloEDD = '2104G'   # Cmd(do dm4050) Invalido...entao...é 2104
    elif 'unknown' in getAnswer:                      # Cmddesconhecido...possivel erro de digitação...retornar espaços de bug´s auto-inseridos   
        modeloEDD = '4050'
        desviaBugs = 3                                # 4050 precisa de X espaços de retorno após cmd
        zoomMenos(7, intervalo=0.1)                   # Devido num de linhas do 4050, Reduz tamanho do texto da abaMoba3
    else: 
        modeloEDD = '4050'
        zoomMenos(7, intervalo=0.1)                   # Devido num de linhas do 4050, Reduz tamanho do texto da abaMoba3
    
    gravar_infosArqTransferPhp(_ADD, '\nModelo: '+ modeloEDD + '\n')   # Gravar modelo em arquivo txt de Transfers dados  To Php

    # --------------------------------------------------------------------------------------------------------- #
    if "2104G" in modeloEDD:  
        if tipoCheck == _LOTE:   # Lote de Cmds     
            colar_pw_enter('sh int desc', desviaBugs)
            time.sleep(tCmd * 3)
            colar_pw_enter('sh run | inc vlan \| name', desviaBugs)
            time.sleep(tCmd * 3)  
            prepararMoba(500, 500, 3, 0.2)  # Separa  
            time.sleep(tCmd)
            numLinUP = cpPosIniTxtTesteY - (_altLinPx * 35)   # Pega 6 linhas(baixo p/ Cima)
            Configs = clickArrasteCopy(cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, numLinUP, tCmd) 
            analiseDados(modeloEDD, _RA, Configs, Produto)   # arqToPhp = _infosSWA;  # Transferencia de dados entre Php e Robos 
            time.sleep(tCmd)
            analiseDados(modeloEDD, _CVLAN, Configs, Produto)
            time.sleep(tCmd)
        
        else:  # Cmds separados
            colar_pw_enter('sh int desc', desviaBugs)
            time.sleep(tCmd * 3)     
            numLinUP = cpPosIniTxtTesteY - (_altLinPx * 12)   # Pega 6 linhas(baixo p/ Cima) (980 - (25*6)) = 830
            ptConfigs = clickArrasteCopy(cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, numLinUP, tCmd) 
            analiseDados(modeloEDD, _PORTA, ptConfigs, Produto)  # arqToPhp = _infosSWA;  # Transferencia de dados entre Php e Robos 
            time.sleep(tCmd)

            colar_pw_enter('sh run | inc vlan \| name', desviaBugs)
            time.sleep(tCmd * 3)      
            numLinUP = cpPosIniTxtTesteY - (_altLinPx * 28)   # Pega 6 linhas(baixo p/ Cima)
            cVlansConfigs = clickArrasteCopy(cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, numLinUP, tCmd) 
            analiseDados(modeloEDD, _RA, cVlansConfigs, Produto) # arqToPhp = _infosSWA;  # Transferencia de dados entre Php e Robos
            time.sleep(tCmd)
            analiseDados(modeloEDD, _CVLAN, cVlansConfigs, Produto)
            time.sleep(tCmd)


    if "4370" in modeloEDD or "4050" in modeloEDD or "4250" in modeloEDD or "4270" in modeloEDD: 
        if tipoCheck == _LOTE:    # Cmds em Lote
            colar_pw_enter('sh int desc', desviaBugs)
            time.sleep(tCmd * 3)  
            colar_pw_enter('show run | inc name | match-all | inc '+Produto, desviaBugs)
            time.sleep(tCmd * 3)
            colar_pw_enter('show vlan brief', desviaBugs)
            time.sleep(tCmd * 3)   
            colar_pw_enter('show run | inc match | match-all | inc vlan-id', desviaBugs)
            time.sleep(tCmd * 3)   
            prepararMoba(500, 500, 3, 0.2)  # Separa do chao
            time.sleep(tCmd) 
            numLinUP = cpPosIniTxtTesteY - (_altLinPx * 50)   # Pega 6 linhas(baixo p/ Cima) (980 - (25*6)) = 830
            Configs = clickArrasteCopy(cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, numLinUP, tCmd) 
            analiseDados(modeloEDD, _PORTA, Configs, Produto)    # arqToPhp = _infosSWA;  # Transferencia de dados entre Php e Robos
            time.sleep(tCmd)
            analiseDados(modeloEDD, _RA, Configs, Produto)   # arqToPhp = _infosSWA;  # Transferencia de dados entre Php e Robos
            time.sleep(tCmd)       
            analiseDados(modeloEDD, _CVLAN, Configs, Produto)    # arqToPhp = _infosSWA;  # Transferencia de dados entre Php e Robos
            time.sleep(tCmd)            
    
        
        else:  # Cmds separados
            colar_pw_enter('sh int desc', desviaBugs)
            time.sleep(tCmd * 3)     
            numLinUP = cpPosIniTxtTesteY - (_altLinPx * 28)   # Pega 6 linhas(baixo p/ Cima) (980 - (25*6)) = 830
            ptConfigs = clickArrasteCopy(cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, numLinUP, tCmd) 
            analiseDados(modeloEDD, _PORTA, ptConfigs, Produto)
            time.sleep(tCmd)

            prepararMoba(500, 500, 3, 0.2)  # Separa 
            time.sleep(0.5)
            colar_pw_enter('show run | inc name | match-all | inc '+Produto, desviaBugs)
            time.sleep(tCmd)
            colar_pw_enter('show vlan brief', desviaBugs)
            time.sleep(tCmd)
            prepararMoba(500, 500, 3, 0.2)  # Separa
            time.sleep(tCmd * 3)  
            numLinUP = cpPosIniTxtTesteY - (_altLinPx * 20)   # Pega 12 linhas(baixo p/ Cima) (980 - (25*6)) = 830
            raConfigs = clickArrasteCopy(cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, numLinUP, tCmd) 
            analiseDados(modeloEDD, _RA, raConfigs, Produto) # arqToPhp = _infosSWA;  # Transferencia de dados entre Php e Robos
            time.sleep(tCmd)       

            prepararMoba(500, 500, 3, 0.2)  # Separa 
            time.sleep(0.5)     
            colar_pw_enter('show run | inc match | match-all | inc vlan-id', desviaBugs)
            time.sleep(tCmd * 3)      
            numLinUP = cpPosIniTxtTesteY - (_altLinPx * 50)   # Pega 6 linhas(baixo p/ Cima)
            cVlansConfigs = clickArrasteCopy(cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, numLinUP, tCmd)         
            analiseDados(modeloEDD, _CVLAN, cVlansConfigs, Produto)  # arqToPhp = _infosSWA;  # Transferencia de dados entre Php e Robos
            time.sleep(tCmd)
    
    gravar_infosArqTransferPhp(_ADD, '\n}')   # limpar arquivo txt de Transfers dados  To Php
    gravar_infosArqTransferPhp(_ADD, '\n===========================================================================================\n')   

    if '4050' in modeloEDD:
        mover_e_clicar(800, 600)  
        time.sleep(0.2)  
        zoomMais(7, intervalo=0.1)                   # NORMALIZA TAMANHO DO TEXT, Devido num de linhas do 4050, Reduziu tamanho do texto da abaMoba3-acima
    
    # finaliza istando portas
    #colar_pw_enter('sh int desc', desviaBugs)  
    #time.sleep(tCmd)     
   

# -------------------------------------------------------------------------------------------------------------------------------- #
def readInfosVsOld(modeloEDD, IdOrdem, Produto, cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, tipoCheck, desviaBugs, tCmd):

    debbug(_noJumpLin, 'readInfosSWA('+modeloEDD+', '+IdOrdem+', '+Produto+')')

    # limpar arquivo(criar cabeçario) txt de Transfers dados  To Php 
    gravar_infosArqTransferPhp(_CLEAR, 'Bot getInfosSwa()\n')   
    gravar_infosArqTransferPhp(_ADD, '{\n')   

    if "2104G" in modeloEDD:  
        if tipoCheck == _LOTE:   # Lote de Cmds     
            colar_pw_enter('sh int desc', desviaBugs)
            time.sleep(tCmd * 3)
            colar_pw_enter('sh run | inc vlan \| name', desviaBugs)
            time.sleep(tCmd * 3)  
            prepararMoba(500, 500, 3, 0.2)  # Separa  
            time.sleep(tCmd)
            numLinUP = cpPosIniTxtTesteY - (_altLinPx * 35)   # Pega 6 linhas(baixo p/ Cima)
            Configs = clickArrasteCopy(cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, numLinUP, tCmd) 
            analiseDados(modeloEDD, _RA, Configs, Produto)
            time.sleep(tCmd)
            analiseDados(modeloEDD, _CVLAN, Configs, Produto)
            time.sleep(tCmd)
        
        else:  # Cmds separados
            colar_pw_enter('sh int desc', desviaBugs)
            time.sleep(tCmd * 3)     
            numLinUP = cpPosIniTxtTesteY - (_altLinPx * 12)   # Pega 6 linhas(baixo p/ Cima) (980 - (25*6)) = 830
            ptConfigs = clickArrasteCopy(cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, numLinUP, tCmd) 
            analiseDados(modeloEDD, _PORTA, ptConfigs, Produto)
            time.sleep(tCmd)

            colar_pw_enter('sh run | inc vlan \| name', desviaBugs)
            time.sleep(tCmd * 3)      
            numLinUP = cpPosIniTxtTesteY - (_altLinPx * 28)   # Pega 6 linhas(baixo p/ Cima)
            cVlansConfigs = clickArrasteCopy(cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, numLinUP, tCmd) 
            analiseDados(modeloEDD, _RA, cVlansConfigs, Produto)
            time.sleep(tCmd)
            analiseDados(modeloEDD, _CVLAN, cVlansConfigs, Produto)
            time.sleep(tCmd)


    if "4370" in modeloEDD or "4050" in modeloEDD or "4250" in modeloEDD or "4270" in modeloEDD: 
        if tipoCheck == _LOTE:    # Cmds em Lote
            colar_pw_enter('sh int desc', desviaBugs)
            time.sleep(tCmd * 3)  
            colar_pw_enter('show run | inc name | match-all | inc '+Produto, desviaBugs)
            time.sleep(tCmd * 3)
            colar_pw_enter('show vlan brief', desviaBugs)
            time.sleep(tCmd * 3)   
            colar_pw_enter('show run | inc match | match-all | inc vlan-id', desviaBugs)
            time.sleep(tCmd * 3)   
            prepararMoba(500, 500, 3, 0.2)  # Separa do chao
            time.sleep(tCmd) 
            numLinUP = cpPosIniTxtTesteY - (_altLinPx * 50)   # Pega 6 linhas(baixo p/ Cima) (980 - (25*6)) = 830
            Configs = clickArrasteCopy(cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, numLinUP, tCmd) 
            analiseDados(modeloEDD, _PORTA, Configs, Produto)
            time.sleep(tCmd)
            analiseDados(modeloEDD, _RA, Configs, Produto)
            time.sleep(tCmd)       
            analiseDados(modeloEDD, _CVLAN, Configs, Produto)
            time.sleep(tCmd)            
    
        
        else:  # Cmds separados
            colar_pw_enter('sh int desc', desviaBugs)
            time.sleep(tCmd * 3)     
            numLinUP = cpPosIniTxtTesteY - (_altLinPx * 28)   # Pega 6 linhas(baixo p/ Cima) (980 - (25*6)) = 830
            ptConfigs = clickArrasteCopy(cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, numLinUP, tCmd) 
            analiseDados(modeloEDD, _PORTA, ptConfigs, Produto)
            time.sleep(tCmd)

            prepararMoba(500, 500, 3, 0.2)  # Separa 
            time.sleep(0.5)
            colar_pw_enter('show run | inc name | match-all | inc '+Produto, desviaBugs)
            time.sleep(tCmd)
            colar_pw_enter('show vlan brief', desviaBugs)
            time.sleep(tCmd)
            prepararMoba(500, 500, 3, 0.2)  # Separa
            time.sleep(tCmd * 3)  
            numLinUP = cpPosIniTxtTesteY - (_altLinPx * 20)   # Pega 12 linhas(baixo p/ Cima) (980 - (25*6)) = 830
            raConfigs = clickArrasteCopy(cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, numLinUP, tCmd) 
            analiseDados(modeloEDD, _RA, raConfigs, Produto)
            time.sleep(tCmd)       

            prepararMoba(500, 500, 3, 0.2)  # Separa 
            time.sleep(0.5)     
            colar_pw_enter('show run | inc match | match-all | inc vlan-id', desviaBugs)
            time.sleep(tCmd * 3)      
            numLinUP = cpPosIniTxtTesteY - (_altLinPx * 50)   # Pega 6 linhas(baixo p/ Cima)
            cVlansConfigs = clickArrasteCopy(cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, numLinUP, tCmd)         
            analiseDados(modeloEDD, _CVLAN, cVlansConfigs, Produto)
            time.sleep(tCmd)
    
    gravar_infosArqTransferPhp(_ADD, '\n}')   # limpar arquivo txt de Transfers dados  To Php

    colar_pw_enter('sh int desc', desviaBugs)   # finaliza com listas de portas
    time.sleep(tCmd)     



def soLetras(texto):
    """
    Retorna apenas os caracteres alfabéticos de uma string.
    
    Parâmetros:
    texto (str): String de entrada contendo vários caracteres
    
    Retorna:
    str: String contendo apenas letras (maiúsculas e minúsculas)
    """
    return ''.join(caractere for caractere in texto if caractere.isalpha())


def catDeviceList(ufSwa, nomeSwa, folhaMobaX, folhaMobaY, cpPosIniTxtTesteX, cpPosIniTxtTesteY, tFast):
    #---------------- ESTES CODES(#pyautogui.write('cat /deviceList'))
    #  BUGGAM O MOBA(FECHA A ABA) (Achei que era->SCROLL-LOCK ESTAVA ACIONADA mas não é
    #  - TIVE DE USAR S[O MOUSE -----------------#

    # Usando Paste com Mouse
    cmdX = 'cat /deviceList | grep ' + str(nomeSwa)
    pyperclip.copy(cmdX)    # envia p/ clipboard           
    time.sleep(tFast)   

    mover_e_clicar(folhaMobaX, folhaMobaY)      # janela php
    pyautogui.rightClick()                      # btn Dir do Mouse
    time.sleep(tFast)
    mover_e_clicar(folhaMobaX + 50, folhaMobaY - 496)   # ajusta em: Paste
    time.sleep(tFast)
    pyautogui.hotkey('enter')
    time.sleep(tFast)
    pyperclip.copy('')
    #--------------------------------------------------------------------------------#
    time.sleep(tFast*2)
    copyDevice = clickArrasteCopy(cpPosIniTxtTesteX, cpPosIniTxtTesteY, 145, cpPosIniTxtTesteY-300, tFast)
    time.sleep(tFast)
    # Antes de colar no php...filtre    
    # 2. Filtrar linhas com 'osb-swa'           
    # Separa em linhas
    ufSwa = soLetras(ufSwa)
    print("UF: "+ufSwa)
    foundSwa = False
    linDevice = copyDevice.splitlines()
    # Imprime linha por linha
    for linha in  linDevice:
        # Nao usar nomeSwa, pois esta em todas as linhas - use: 'm-br' + 'uf'(para checkar se estado é o correto)
        if 'm-br' in linha: 
            # gravar_infosArqTransferPhp(_ADD, 'm-br-> '+ linha + '\n')   # Gravar nomeSWA+IP(m-br-pe-rce-osb-swa-01 10.227.174.226) em arquivo txt de Transfers dados  To Php
            nomeSwaGetQuery = linha            # DE: m-br-pe-rce-osb-swa-01 10.227.174.226     ->      Pega(23 chars): m-br-pe-rce-osb-swa-01 

            if ufSwa in linha: 
                gravar_infosArqTransferPhp(_ADD, linha + '\n')   # Gravar nomeSWA+IP(m-br-pe-rce-osb-swa-01 10.227.174.226) em arquivo txt de Transfers dados  To Php
                nomeSwaGetQuery = linha            # DE: m-br-pe-rce-osb-swa-01 10.227.174.226     ->      Pega(23 chars): m-br-pe-rce-osb-swa-01 
                foundSwa = True
            else:
                gravar_infosArqTransferPhp(_ADD, 'UF=|'+ ufSwa + '|\n')   # Gravar nomeSWA+IP(m-br-pe-rce-osb-swa-01 10.227.174.226) em arquivo txt de Transfers dados  To Php
          
    # gravar_infosArqTransferPhp(_ADD, '\n catDevice->(gb)swa: '+ nomeSwaGetQuery + '\n')   # Gravar nomeSWA+IP(m-br-pe-rce-osb-swa-01 10.227.174.226) em arquivo txt de Transfers dados  To Php

    if(foundSwa):
        gravar_infosArqTransferPhp(_ADD, 'nomeSWA=' + nomeSwaGetQuery + '\n')    # Usado p/ comunicar entre phpe python, Grava em arq.ini -> consultado via Swa filtrado so nome                   
        return nomeSwaGetQuery
    else:
        return _NULL


def ativarMobaXterm():
    try:
        # Procurar por janelas que contenham "Moba" no título
        janelas_moba = gw.getWindowsWithTitle("Moba")
        
        if janelas_moba:
            for janela in janelas_moba:
                print(f"Ativando janela: {janela.title}")
                janela.activate()
                return True
        
        # Tentar variações comuns do nome
        variacoes = ["MobaXterm", "MobaXterm Personal", "MobaXterm Professional"]
        
        for variacao in variacoes:
            janelas = gw.getWindowsWithTitle(variacao)
            if janelas:
                janelas[0].activate()
                print(f"✅ MobaXterm ativado: {janelas[0].title}")
                return True
        
        print("❌ Nenhuma janela do MobaXterm encontrada")
        return False
        
    except Exception as e:
        print(f"❌ Erro ao ativar MobaXterm: {e}")
        return False
    

def ativaMoba(icoMobaX, icoMobaY, janMobaX, janMobaY, tFast):
    debbug(_noJumpLin, 'ativaMoba()')

    # Se ativar_MobaTerminal falhar(3x), exec.manual(click no icone)
    # Isso evita, entre outreas coisas, que navegador seja mexido no lugar do MobaTerm, e bagunça td
    if ativarMobaXterm() == False:    
        if ativarMobaXterm() == False: 
            if ativarMobaXterm() == False: 
                #print("ativaMoba()")

                debbug(_noJumpLin, 'ativaMoba('+str(icoMobaX)+', '+str(icoMobaY)+', '+str(janMobaX)+', '+str(janMobaY)+', '+str(tFast)+')')
            
                #Ativar janela Moba 
                mover_e_clicar(icoMobaX, icoMobaY)
                time.sleep(tFast)

                # Mover para a janela e clicar (x1 x y500)
                mover_e_clicar(janMobaX, janMobaY)
                time.sleep(tFast)


def ativaMoba_old_semXterm(icoMobaX, icoMobaY, janMobaX, janMobaY, tFast):
    debbug(_noJumpLin, 'ativaMoba()')

    #print("ativaMoba()")
    #Ativar janela Moba 
    mover_e_clicar(icoMobaX, icoMobaY)
    time.sleep(tFast)

    # Mover para a janela e clicar (x1 x y500)
    mover_e_clicar(janMobaX, janMobaY)
    time.sleep(tFast)


def janela(largura, altura):
    debbug(_noJumpLin, 'janela()')
    # Comando para alterar o tamanho da janela no Windows
    os.system(f'mode con: cols={largura} lines={altura}')

def cores():
    debbug(_noJumpLin, 'cores()')
    # Cor de fundo azul e texto cinza
    # \033[44m altera o fundo para azul, \033[38;5;8m altera o texto para cinza
    print("\033[44m\033[97m", end="")  # Define o fundo azul e o texto branco
    # print("\033[44m\033[38;5;8m", end="")  # Define o fundo azul e o texto cinza    
    #print("\033[0m", end="")  # Reseta as cores para o padrão após o texto


def limpar(N):
    for _ in range(N):
        print()  # Imprime uma linha vazia 

def logo():
    print("     _______")       
    print("    (_)^_^(_)")
    print("     / (_) \  Get Infos")       
    print("     \__^__/  by: Treuk VA-2025 rv-07.09.25")  
    print("                               ")     
    print("            ") 


def key():
    print("   ____ ")       
    print("  / () \_______   ")
    print("  \____/^^^^^^^'   ")     
    print("  Digite sua Senha:") 
    print("            ") 




#---------------------------------------------------------------------------------------------------------------#
def main():


    NomeIpGlobalSwa = ""  # Nome+IP consultado via cat/deviceList  
    NomeSWALocal = ""        # NomeSWA consultado via cat/deviceList, filtrado so nome          
    gbNomeRAgetQuery = ""        # Nome RSD consultado via Swa filtrado so nome          
    gbIpHL5GQuery = ""           # IP DO HL5 consultado via Swa filtrado so nome          


    debbug(_addJumpLin, 'main()')
    
    # Posiciona a janela/define tamanho
    posicionar_janela(3300, 30)

    # Ajusta tamJanela
    janela(65, 15)
    cores()
    limpar(20)
    logo()

 
    config = configparser.ConfigParser()
    #config.read('config.ini')
    if _pcTEL: config.read(r'C:\wamp64\www\rd2r3\Robos\configs\getInfosSwa.ini')
    else: config.read(r'F:/Projetos/Python/botGetInfosSwa/getInfosSwa.ini')
 

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
    cpPosIniTxtTesteX = int(config['MOBA']['cpPosIniTxtTesteX'])
    cpPosIniTxtTesteY = int(config['MOBA']['cpPosIniTxtTesteY'])
    cpPosFimTxtTesteX = int(config['MOBA']['cpPosFimTxtTesteX'])
    cpPosFimTxtTesteY = int(config['MOBA']['cpPosFimTxtTesteY'])

    # Pagina-Php
    PhpTaRascunhoX = int(config['PHP']['PhpTaRascunhoX'])
    PhpTaRascunhoY = int(config['PHP']['PhpTaRascunhoY'])
    PhpBtnSalvarX = int(config['PHP']['PhpBtnSalvarX'])
    PhpBtnSalvarY = int(config['PHP']['PhpBtnSalvarY'])


  
    
    loop = 1
    while loop == 1: 
        
        # le VAR DE ARQ.txt de transferencia - Tive dificuldades em gravar var global
        NomeSWALocal = ler_infosArqTransferPhp('caminho_arquivo', 'nomeSWA') 
        NomeRaLocal = ler_infosArqTransferPhp('caminho_arquivo', 'nomeRA') 
        NomeHL5gLocal = ler_infosArqTransferPhp('caminho_arquivo', 'nomeHL5G')  # melhor usar o nome, pega melhores infos do Rsd
        # IpHL5gLocal = ler_infosArqTransferPhp('caminho_arquivo', 'ipHDL5G') 
        
        pyperclip.copy('')  # Limpa ClipBoard

        cellTkt = getDadosTkt()      
      
        IdOrdem = cellTkt[_ID]
        IdOrdem = IdOrdem.replace('"', '')  # Tirar Aspas que esta aparecendo...        
      
        Produto = cellTkt[_PDT]
        Produto = Produto.replace('"', '')  # Tirar Aspas que esta aparecendo...        
      
        modeloEDD = cellTkt[_EDD]
        modeloEDD = modeloEDD.replace('"', '')  # Tirar Aspas que esta aparecendo...  

        ufSwa = cellTkt[_UF]
        ufSwa = ufSwa.replace('"', '')  # Tirar Aspas que esta aparecendo...
           
        nomeSwa = cellTkt[_SWA]
        nomeSwa = nomeSwa.replace('"', '')  # Tirar Aspas que esta aparecendo...
           
        mover_e_clicar(icoAppGetInfosSwaX, icoAppGetInfosSwaY) # Chama app-tras para tela app
  
        # Menu de opções 
        limpar(20)
        logo()
        mover_e_clicar(icoAppGetInfosSwaX, icoAppGetInfosSwaY)   # auto-Click no proprio Ico-app-cad.flow
        time.sleep(tFast) 
            
        print("     "+Produto+", "+nomeSwa+", "+modeloEDD)      
        print("     I: Infos, tds as clt")        
        print("     D: Clt Device")        
        print("     LS: Logar no Swa")        
        print("     CS: Consultar Dados SWA")   
        print("     LR: Logar no RSD")        
        print("     CR: Consultar Tunnel RSD")      
        print("     CL: Consultar Dados(em Lote)")        
        print("     LC: Logar, Consultar")        
        print("     LCL: Logar, Consultar(Lote)")        
        print("     S: Sair ")        
        print("")
        mnOpcao = input("Informe a opcao> ")   
              
        if mnOpcao == 'I' or mnOpcao == 'i':    # So logar   


            # ----------- 'D' Consulta cat device do SWA ---------------------------------------------------------------------------------- # 
            # acertando... ativaMoba(icoMobaX, icoMobaY, janMobaX, janMobaY, tFast)

            print("\n1 - Pesquisar SWA: cat /deviceList...")                            
            mover_e_clicar(1, 500)    
            time.sleep(tFast)         
            mover_e_clicar(janMobaX, janMobaY)  
            time.sleep(tFast)           
            prepararMoba(1096, 151, nEnter, tFast)  # aba3
            retNomeSwa = catDeviceList(ufSwa, nomeSwa, folhaMobaX, folhaMobaY, cpPosIniTxtTesteX, cpPosIniTxtTesteY, tFast)
            NomeSWALocal = ler_infosArqTransferPhp('caminho_arquivo', 'nomeSWA') 

            while NomeSWALocal == None:
                NomeSWALocal = ler_infosArqTransferPhp('caminho_arquivo', 'nomeSWA')     #ler->../transfer/infosSwa_temp.txt            
                stop = input("   Erro! SWA não encontrado. Continuar? <E> | <S>air\n   * Informe SWA via ../tickets.php")
                if stop == 'S' or stop == 's':
                    sys.exit()

            NomeSWAGlobal = NomeSWALocal  # passa valor pra global pq perde valor local 
            #print("SWA = "+NomeSWAGlobal)  
            #NomeSWALocal = NomeSwaLocalX[:23]            # Ja veio formatado...DE: m-br-pe-rce-osb-swa-01 10.227.174.226     ->      Pega(23 chars): m-br-pe-rce-osb-swa-01 

            mover_e_clicar(icoAppGetInfosSwaX, icoAppGetInfosSwaY)   # auto-Click no proprio Ico-app-cad.flow
            time.sleep(tFast)     
            stop = input("\n2 - Acessar SWA: "+ NomeSWAGlobal + "? <E> | <S>air")
            if stop == 'S' or stop == 's':
                sys.exit()
              
   
            # ----------- 'LS' Logar no swa ---------------------------------------------------------------------------------- #
            #print("ssh swa... ")                             
            mover_e_clicar(1, 500)            
            mover_e_clicar(janMobaX, janMobaY)            
            prepararMoba(abaMoba3X, abaMoba3Y, nEnter, tFast)
            # logar(nomeSwa, pwLog, folhaMobaX, folhaMobaY, tFast, tLogar, desviaBugsLogar, icoAppGetInfosSwaX, icoAppGetInfosSwaY)
            logar(NomeSWAGlobal, pwLog, folhaMobaX, folhaMobaY, tFast, tLogar, desviaBugsLogar, icoAppGetInfosSwaX, icoAppGetInfosSwaY)
            time.sleep(1.0)   
            

            mover_e_clicar(icoAppGetInfosSwaX, icoAppGetInfosSwaY)   # auto-Click no proprio Ico-app-cad.flow
            time.sleep(tFast)     
            stop = input("\n3 - Consultar SWA: " + NomeSWAGlobal + "? <E> | <S>air")
            if stop == 'S' or stop == 's':
                sys.exit()        
            # ----------- 'CS' Consulta no swa ---------------------------------------------------------------------------------- # 
            #print("sh int brief.... ")                            
            mover_e_clicar(1, 500)            
            mover_e_clicar(janMobaX, janMobaY)            
            prepararMoba(abaMoba3X, abaMoba3Y, nEnter, tFast)
            readInfosSWA(NomeIpGlobalSwa, NomeSWAGlobal, IdOrdem, Produto, cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, _UND, desviaBugsCmd, tCmd)          
            time.sleep(tCmd*3)

            # Ler/Atualizar(alterado acima em 'CS') VAR DE ARQ.txt(Recem gravada) de transferencia - Tive dificuldades em gravar var global
            NomeRaLocal = ler_infosArqTransferPhp('caminho_arquivo', 'nomeRA') 
            while NomeRaLocal == None:
                NomeRaLocal = ler_infosArqTransferPhp('caminho_arquivo', 'nomeRA')     #ler->../transfer/infosSwa_temp.txt            
                stop = input("   Erro! RA não encontrado! Continuar? <E> | <S>air\n   * Informe RA via ../tickets.php ")
                if stop == 'S' or stop == 's':
                    sys.exit()

            NomeRaGlobal = NomeRaLocal  # passa valor pra global pq perde valor local 
            mover_e_clicar(icoAppGetInfosSwaX, icoAppGetInfosSwaY)   # auto-Click no proprio Ico-app-cad.flow
            time.sleep(tFast)     
            stop = input("\n4 - Acessar RA: "+ NomeRaGlobal + "? <E> | <S>air")
            if stop == 'S' or stop == 's':
                sys.exit()
            # ----------- 'LR' Logar no RSD ---------------------------------------------------------------------------------- # 
            mover_e_clicar(1, 500)            
            mover_e_clicar(janMobaX, janMobaY)            
            prepararMoba(abaMoba2X, abaMoba2Y, nEnter, tFast)
            logar(NomeRaGlobal, pwLog, folhaMobaX, folhaMobaY, tFast, tLogar, desviaBugsLogar, icoAppGetInfosSwaX, icoAppGetInfosSwaY)
            time.sleep(tFast)
            time.sleep(1.0)

            
       
            NomeHL5gLocal = ler_infosArqTransferPhp('caminho_arquivo', 'nomeHL5G') 
            while NomeHL5gLocal == None:
                NomeHL5gLocal = ler_infosArqTransferPhp('caminho_arquivo', 'nomeRA')     #ler->../transfer/infosSwa_temp.txt            
                stop = input("   Erro! HL5g não encontrado! Continuar? <E> | <S>air\n   * Insira HL5G via ../tickets.php")
                if stop == 'S' or stop == 's':
                    sys.exit()

            NomeHL5gGlobal = NomeHL5gLocal  # passa valor pra global pq perde valor local 
            mover_e_clicar(icoAppGetInfosSwaX, icoAppGetInfosSwaY)   # auto-Click no proprio Ico-app-cad.flow
            time.sleep(tFast)             
            stop = input("\n5 - Show HL5G em RA: "+ NomeRaGlobal + "? <E> | <S>air")
            if stop == 'S' or stop == 's':
                sys.exit()
            # ----------- 'CR' Consulta no Tunnel  RSD ---------------------------------------------------------------------------------- # 
            mover_e_clicar(1, 500)            
            mover_e_clicar(janMobaX, janMobaY)            
            prepararMoba(abaMoba2X, abaMoba2Y, nEnter, tFast)
            readInfosRSD(NomeRaGlobal, NomeHL5gGlobal, cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, desviaBugsCmd, tCmd)
            print("Processo finalizado.")
            time.sleep(tCmd*3)   
                               
            # ----------- fim do I ---------------------------------------------------------------------------------- #                          

            
        if mnOpcao == 'F' or mnOpcao == 'f':    # So logar 
            mover_e_clicar(1, 500)    
            time.sleep(tFast)         
            mover_e_clicar(janMobaX, janMobaY)  
            time.sleep(tFast)           
            mover_e_clicar(folhaMobaX, folhaMobaY)  
            time.sleep(tFast)           
           
            zoomMais(7, intervalo=0.1)

        if mnOpcao == 'T' or mnOpcao == 't':    # So logar 
            mover_e_clicar(1, 500)    
            time.sleep(tFast)         
            mover_e_clicar(janMobaX, janMobaY)  
            time.sleep(tFast)           
            mover_e_clicar(folhaMobaX, folhaMobaY)  
            time.sleep(tFast)              
            zoomMenos(7, intervalo=0.1)

        if mnOpcao == 'D' or mnOpcao == 'd':    # So logar 
                              
            mover_e_clicar(1, 500)    
            time.sleep(tFast)         
            mover_e_clicar(janMobaX, janMobaY)  
            time.sleep(tFast)           
            prepararMoba(1096, 151, nEnter, tFast)  # aba3
            catDeviceList(ufSwa, nomeSwa, folhaMobaX, folhaMobaY, cpPosIniTxtTesteX, cpPosIniTxtTesteY, tFast)
            NomeSwaLocal = ler_infosArqTransferPhp('caminho_arquivo', 'nomeSWA') 

            if _NULL in NomeSwaLocal:
                stop = input("STOP!!! SWA não localizado.")
            else:
                NomeSWALocal = NomeSwaLocal[:23]            # DE: m-br-pe-rce-osb-swa-01 10.227.174.226     ->      Pega(23 chars): m-br-pe-rce-osb-swa-01 
           
           
        if mnOpcao == 'LS' or mnOpcao == 'ls':    # So logar no SWA
            mover_e_clicar(1, 500)            
            mover_e_clicar(janMobaX, janMobaY)            
            prepararMoba(abaMoba3X, abaMoba3Y, nEnter, tFast)
            # logar(nomeSwa, pwLog, folhaMobaX, folhaMobaY, tFast, tLogar, desviaBugsLogar, icoAppGetInfosSwaX, icoAppGetInfosSwaY)
            logar(NomeSWALocal, pwLog, folhaMobaX, folhaMobaY, tFast, tLogar, desviaBugsLogar, icoAppGetInfosSwaX, icoAppGetInfosSwaY)
            time.sleep(tFast)
           
        if mnOpcao == 'LR' or mnOpcao == 'lr':    # So logar no RSD            
            
            mover_e_clicar(1, 500)            
            mover_e_clicar(janMobaX, janMobaY)            
            prepararMoba(abaMoba2X, abaMoba2Y, nEnter, tFast)
            logar(NomeRaLocal, pwLog, folhaMobaX, folhaMobaY, tFast, tLogar, desviaBugsLogar, icoAppGetInfosSwaX, icoAppGetInfosSwaY)
            time.sleep(tFast)
           
           
           
        if mnOpcao == 'CR' or mnOpcao == 'cr':    # Consulta RSD 
            mover_e_clicar(1, 500)            
            mover_e_clicar(janMobaX, janMobaY)            
            prepararMoba(abaMoba2X, abaMoba2Y, nEnter, tFast)
            readInfosRSD(NomeRaLocal, NomeHL5gLocal, cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, desviaBugsCmd, tCmd)
            time.sleep(tCmd*3)
            #sys.exit()

        if mnOpcao == 'CS' or mnOpcao == 'cs':    # Consulta SWA
            mover_e_clicar(1, 500)            
            mover_e_clicar(janMobaX, janMobaY)            
            prepararMoba(abaMoba3X, abaMoba3Y, nEnter, tFast)
            readInfosSWA(NomeIpGlobalSwa, NomeSWALocal, IdOrdem, Produto, cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, _UND, desviaBugsCmd, tCmd)          
            time.sleep(tCmd*3)
            #sys.exit()

        if mnOpcao == 'CL' or mnOpcao == 'cl':  # Cls em Lote de cmds(+ rapido)
            mover_e_clicar(1, 500)            
            mover_e_clicar(janMobaX, janMobaY)            
            prepararMoba(abaMoba3X, abaMoba3Y, nEnter, tFast)
            readInfosSWA(NomeIpGlobalSwa, NomeSWALocal, IdOrdem, Produto, cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, _LOTE, desviaBugsCmd, tCmd)
            time.sleep(tCmd*3)
            sys.exit()

        if mnOpcao == 'LC' or mnOpcao == 'lc':  # Logar+Clt+Sair
            mover_e_clicar(1, 500)            
            mover_e_clicar(janMobaX, janMobaY)            
            prepararMoba(abaMoba3X, abaMoba3Y, nEnter, tFast)
            logar(nomeSwa, pwLog, folhaMobaX, folhaMobaY, tFast, tLogar, desviaBugsLogar, icoAppGetInfosSwaX, icoAppGetInfosSwaY)
            time.sleep(tCmd*3)
            mover_e_clicar(1, 500)            
            mover_e_clicar(janMobaX, janMobaY)            
            prepararMoba(abaMoba3X, abaMoba3Y, nEnter, tFast)
            readInfosSWA(NomeIpGlobalSwa, NomeSWALocal, IdOrdem, Produto, cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, _UND, desviaBugsCmd, tCmd)
            time.sleep(tCmd*3)
            sys.exit()

        if mnOpcao == 'LCL' or mnOpcao == 'lcl':   # Logar+Clt em Lote de cmds(+ rapido)+Sair
            mover_e_clicar(1, 500)            
            mover_e_clicar(janMobaX, janMobaY)            
            prepararMoba(abaMoba3X, abaMoba3Y, nEnter, tFast)
            logar(nomeSwa, pwLog, folhaMobaX, folhaMobaY, tFast, tLogar, desviaBugsLogar, icoAppGetInfosSwaX, icoAppGetInfosSwaY)
            time.sleep(tCmd*3)
            mover_e_clicar(1, 500)            
            mover_e_clicar(janMobaX, janMobaY)            
            prepararMoba(abaMoba3X, abaMoba3Y, nEnter, tFast)
            readInfosSWA(NomeIpGlobalSwa, NomeSWALocal, IdOrdem, Produto, cpPosIniTxtTesteX, cpPosIniTxtTesteY, cpPosFimTxtTesteX, _LOTE, desviaBugsCmd, tCmd)
            time.sleep(tCmd*3)
            sys.exit()
        


        if mnOpcao == 'S' or mnOpcao == 's':
            sys.exit()

    #End While

    time.sleep(1)
    print("Execução encerrada.")
    sys.exit()

if __name__ == "__main__":
    main()
