import configparser
#--from typing import Final

# ------------------------------------------------------------ #
# import sys
#--import importlib.util    # Para carregar classes em outro arquivo.py

# Carregar Classes
from ClassIndices import myIdx  # Importando a classe
from ClassTools import Tools  # Importando a classe

# Instancia a classe
objTools = Tools()

# Chama método de instância
# objArquivos.carregar()          # Saída: Carregando...

# Acessa atributo de instância
# print(objArquivos.dados)        # Saída: []

# ------------------------------------------------------------------- #

class Arquivos:

    def __init__(self):
        self.dados = []
        self.inicializar()       # ← método "privado"
    
    def carregar(self):
        print("Carregando...")

    def inicializar(self):
        print("Inicializando...")
        self.lerVarsIni()       # ← método "privado"
        #self.lerConfigIni()

    @staticmethod  
    def lerConfigIni():

        try:
            config = configparser.ConfigParser()
            config.read(r'C:/wamp64/www/rd2r3/Robos/configs/getInfosSwa.ini')
            """
            config = configparser.ConfigParser()
            #config.read('config.ini')
            if myIdx.pcTEL:  # noteBook TEL
                config.read(r'C:\wamp64\www\rd2r3\Robos\configs\getInfosSwa.ini')
            else:  # PC-Home
                config.read(r'F:\Projetos\Python\botGetInfosSwa\getInfosSwa.ini')
            """
            retVars = {}
            
            # Tempos
            retVars[myIdx.cfgTFast] = str(config['TEMPOS']['tFast'])
            retVars[myIdx.cfgtCmd] = str(config['TEMPOS']['tCmd'])
            retVars[myIdx.cfgtLog] = str(config['TEMPOS']['tLogar'])
        
            # msg = str(config['CONFIG']['msg'])
            retVars[myIdx.cfgDsvBugLog] = str(config['CONFIG']['desviaBugsLogar'])        # Aqui tive de criar 2 tipos de Desvia Bugs, pois ocorrem diferentes
            retVars[myIdx.cfgDsvBugCmd] = str(config['CONFIG']['desviaBugsCmd'])
            retVars[myIdx.cfgIcoAppX] = str(config['CONFIG']['icoAppGetInfosSwaX'])  # habilita copiar instancia do processo(da Flow->Pagina)
            retVars[myIdx.cfgIcoAppY] = str(config['CONFIG']['icoAppGetInfosSwaY'])  # habilita copiar instancia do processo(da Flow->Pagina)
            retVars[myIdx.cfgPwLog] = str(config['CONFIG']['pwLog']) 

            retVars[myIdx.cfgIcoMobaX] = str(config['MOBA']['icoMobaX'])
            retVars[myIdx.cfgIcoMobaY] = str(config['MOBA']['icoMobaY'])
            retVars[myIdx.cfgJanMobaX] = str(config['MOBA']['janMobaX'])
            retVars[myIdx.cfgJanMobaY] = str(config['MOBA']['janMobaY'])
            retVars[myIdx.cfgAbaMoba2X] = str(config['MOBA']['abaMoba2X'])
            retVars[myIdx.cfgAbaMoba2Y] = str(config['MOBA']['abaMoba2Y'])
            retVars[myIdx.cfgAbaMoba3X] = str(config['MOBA']['abaMoba3X'])
            retVars[myIdx.cfgAbaMoba3Y] = str(config['MOBA']['abaMoba3Y'])
            retVars[myIdx.cfgPagMobaX] = str(config['MOBA']['folhaMobaX'])    # campo de digitação
            retVars[myIdx.cfgPagMobaY] = str(config['MOBA']['folhaMobaY'])
            retVars[myIdx.cfgnEnter] = str(config['MOBA']['nEnter'])

            # Posições X,Y quadro Copiar texto-teste-IP-Moba(Copy&arraste)
            retVars[myIdx.cfgPosIniArtCpX] = str(config['MOBA']['posIniArrasteCopyX'])
            retVars[myIdx.cfgPosIniArtCpY] = str(config['MOBA']['posIniArrasteCopyY'])
        
            # Pagina-Php
            retVars[myIdx.cfgPhpTaRscX] = str(config['PHP']['PhpTaRascunhoX'])
            retVars[myIdx.cfgPhpTaRscY] = str(config['PHP']['PhpTaRascunhoY'])
            retVars[myIdx.cfgPhpBtnSvX] = str(config['PHP']['PhpBtnSalvarX'])
            retVars[myIdx.cfgPhpBtnSvY] = str(config['PHP']['PhpBtnSalvarY'])
         
         
            return retVars
        
        except Exception as e:
            print(f"Exception lerConfigIni() {e}")
            objTools.debbug(myIdx.noJumpLin, f"Exception objArquivos.lerConfigIni() -  {e}")
            return None
    
    # end def lerConfigINI()

    def gravar_infosArqTransferPhp(self, arqToPhp, tipo, linha):
        # GRAVA LINHAS LIDAS NO SWA(INFOS)
        # arqToPhp = myIdx.infosSwaPyToPhp  # Transferencia de dados entre Php e Robos
            
        try:
            if objTools.filtrarLin(linha): 
                # linha = linha.replace('nomeIpSwa=', '')     # Tira TAG pq Php pega sem esta Tag           
                with open(arqToPhp, tipo) as arquivo:  # Usa o modo: 'w' limpa e 'a' para adicionar conteúdo ao arquivo.
                    arquivo.write(linha)  # Sem Add Lin a mensagem com uma quebra de linha.            
                            
        except Exception as e:
            print("Exception gravar_infosArqTransferPhp() - Erro ao escrever no log: {e}")
            objTools.debbug(myIdx.noJumpLin, f"Exception objArquivos.gravar_infosArqTransferPhp() -  {e}")

    # end  def gravar_infosArqTransferPhp

    def gravarVars1a1Ini(self, dirArq, tipo, key, valor):
        """ Atualiza uma variável específica(enviada em key). Se o arquivo não existir, cria com valores padrão.  """
        # para gravar 1a1, seleciona item(chave) a ser re-gravada - grava(abaixo)
        if key == myIdx.iniRST: chave = 'siglauf'
        if key == myIdx.iniID: chave = 'id'
        if key == myIdx.iniPDT: chave = 'produto'
        if key == myIdx.iniEDD: chave = 'modelo'
        if key == myIdx.iniUF: chave = 'siglaUF'
        if key == myIdx.iniNmSWA: chave = 'nomeSWA'
        if key == myIdx.iniIpSWA: chave = 'ipSWA'
        if key == myIdx.iniNmRA: chave = 'nomeRA'
        if key == myIdx.iniPtRA: chave = 'numPtRA'
        if key == myIdx.iniGVLAN: chave = 'numGVLAN'
        if key == myIdx.iniSVLAN: chave = 'numSVLAN'
        if key == myIdx.iniHL5G: chave = 'nomeHL5G'
        if key == myIdx.iniIpHL5G: chave = 'ipHL5G'

        config = configparser.ConfigParser()
        
        # Valores padrão para quando o arquivo for criado do zero
        valores_padrao = {
            'id': '0000000',
            'produto': 'IPD',
            'modelo': '2104G',
            'siglauf': valor,
            'nomeswa': 'Unknow',
            'ipswa': '0.0.0.0',
            'nomera': 'Unknow',
            'numptra': '0',
            'numgvlan': '0',
            'numsvlan': '0',
            'nomehl5g': 'Unknow',
            'iphl5g': '1.1.1.2'
        }
        
        # Tenta ler o arquivo existente
        config.read(dirArq)
        
        # Se a seção não existe, cria com valores padrão
        if 'VARIAVEIS' not in config:
            config['VARIAVEIS'] = valores_padrao
        
        if tipo == myIdx.CLEAR not in config:
            config['VARIAVEIS'] = valores_padrao
        
        # Atualiza a chave específica
        config['VARIAVEIS'][chave] = str(valor)
        
        # Salva o arquivo
        with open(dirArq, 'w') as arquivo:
            config.write(arquivo)
        
        print(f"✓ '{chave}' = '{valor}'")

    # end def gravarVars1a1Ini


    def lerVarsIni(self):

        try:
            config = configparser.ConfigParser()
            config.read(r'C:/wamp64/www/rd2r3/Robos/configs/varsGetInfos.ini')

            retVars = {}
            retVars[myIdx.iniID] = str(config['VARIAVEIS']['id']) 
            retVars[myIdx.iniPDT] = str(config['VARIAVEIS']['produto']) 
            retVars[myIdx.iniEDD] = str(config['VARIAVEIS']['modelo']) 
            retVars[myIdx.iniUF] = str(config['VARIAVEIS']['siglauf']) 
            retVars[myIdx.iniNmSWA] = str(config['VARIAVEIS']['nomeswa']) 
            retVars[myIdx.iniIpSWA] = str(config['VARIAVEIS']['ipswa']) 
            retVars[myIdx.iniNmRA] = str(config['VARIAVEIS']['nomera']) 
            retVars[myIdx.iniPtRA] = str(config['VARIAVEIS']['numptra']) 
            retVars[myIdx.iniGVLAN] = str(config['VARIAVEIS']['numgvlan']) 
            retVars[myIdx.iniSVLAN] = str(config['VARIAVEIS']['numsvlan']) 
            retVars[myIdx.iniHL5G] = str(config['VARIAVEIS']['nomehl5g']) 
            retVars[myIdx.iniIpHL5G] = str(config['VARIAVEIS']['iphl5g']) 

            return retVars
        
        except Exception as e:
            print(f"Exception objArquivos.lerVarsIni() {e}")
            objTools.debbug(myIdx.noJumpLin, f"Exception objArquivos.lerVarsIni() - {e}")

            

    # end def lerVarsIni(self)


    # Le arquivo, e retorna valor da linha solicitada
    def ler_infosArqTransferPhp(self, dirArq, string_busca):
        """  Retorna a linha inteira que contém a string_busca """
        dirArq = 'C:/wamp64/www/rd2r3/Robos/transfers/infosSwaRascunho_temp.txt';  # Transferencia de dados entre Php e Robos
        resLin = ""
        try:
            with open(dirArq, 'r', encoding='utf-8') as arquivo:
                for linha in arquivo:
                    if string_busca in linha:
                            resLin = linha.rstrip('\n')
                            resLinX = resLin.replace(string_busca+'=', '')  # tira <tag> de busca
                            return resLinX
                    
            return None
        except Exception as e:            
            print(f"Exception objArquivos.ler_infosArqTransferPhp() {e}")
            objTools.debbug(myIdx.noJumpLin, f"Exception objArquivos.ler_infosArqTranferPhp() - {e}")

            return None
        
    # end def ler_infosArqTransferPhp

    def formatarInfosSwaRa(self):
        """ Faz uma organização/formata da InfosSwa/RSD pegas pelo Bot - tira lixo, deixa só infos relevantes, sem repetições """

        linNomeIpSwa = ""

        # Le linhas desajadas
        linModelo = self.ler_infosArqTransferPhp('dirArq', 'Modelo=')
        linNomeIpSwa = self.ler_infosArqTransferPhp('dirArq', 'nomeIpSwa=')
        linNomeSwa = self.ler_infosArqTransferPhp('dirArq', 'nomeSWA=')
        linIpSwa = self.ler_infosArqTransferPhp('dirArq', 'ipSWA=')
        linGER = self.ler_infosArqTransferPhp('dirArq', 'GER')
        linIPD = self.ler_infosArqTransferPhp('dirArq', 'IPD')
        linVPN = self.ler_infosArqTransferPhp('dirArq', 'VPN')
        linNumGVLAN = self.ler_infosArqTransferPhp('dirArq', 'numGVLAN=')
        linNumSVLAN = self.ler_infosArqTransferPhp('dirArq', 'numSVLAN=')
        linNomeHL5G = self.ler_infosArqTransferPhp('dirArq', 'nomeHL5G=')
        linIpHL5G = self.ler_infosArqTransferPhp('dirArq', 'ipHL5G=')
        linNomeRA = self.ler_infosArqTransferPhp('dirArq', 'nomeRA=')
        linNumPtRA = self.ler_infosArqTransferPhp('dirArq', 'numPtRA=')
        
        # Linhas do Tunnel
        # Cisco
        # Id: l2vpn xconnect group PW-ACESSO-IPD p2p 2615_i-br-go-pwl-tpg-hl5d-01 interface PW-Ether2196
        # Id: l2vpn xconnect group PW-ACESSO-IPD p2p 2615_i-br-go-pwl-tpg-hl5d-01 neighbor ipv4 186.246.179.113 pw-id 412615
        # Nokia: 
        # Id: 2/1/c13/4:2997.105 2997105 11111 none 11111 none Up Up
        linTunnel1 = self.ler_infosArqTransferPhp('dirArq', 'PW-Ether')
        if not linTunnel1:  # se esta vazia, procura por interface
            linTunnel1 = self.ler_infosArqTransferPhp('dirArq', 'interface')  
            if not linTunnel1:  # se esta vazia, procura por interface
                linTunnel1 = self.ler_infosArqTransferPhp('dirArq', 'Up')   
                if not linTunnel1:  # se esta vazia, procura por interface
                    linTunnel1 = self.ler_infosArqTransferPhp('dirArq', 'Id:')   
       
        linTunnel2 = self.ler_infosArqTransferPhp('dirArq', 'pw-id')
        if not linTunnel2:  # se esta vazia, procura por interface    
            linTunnel2 = self.ler_infosArqTransferPhp('dirArq', 'none')
            if not linTunnel2:  # se esta vazia, procura por interface    
                linTunnel2 = self.ler_infosArqTransferPhp('dirArq', 'Id:')
              
                  
        # Regrava arquivo: infosSwa_temp.txt (transfer infos: py->To-Php)
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.CLEAR, '\n=================================================================================\n')
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, 'Bot getInfosSwa()\n')
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, '{\n')
        
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, str(linModelo)+'\n')
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, str(linNomeIpSwa)+'\n')

        if linNomeIpSwa:  # Se nao estiver vazia...
            linNomeIpSwaFmt = linNomeIpSwa.replace('nomeIpSwa=', '')    # Tira Tag pq Php pega esta linha, sem a Tag
            self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, str(linNomeIpSwaFmt)+'\n')

        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, str(linNomeSwa)+'\n')
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, str(linIpSwa)+'\n')
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, '\n')
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, str(linGER)+'\n')
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, str(linIPD)+'\n')
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, str(linVPN)+'\n')
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, '\n')
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, str(linNumGVLAN)+'\n')
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, str(linNumSVLAN)+'\n')
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, '\n')
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, str(linNomeHL5G)+'\n')
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, str(linIpHL5G)+'\n')
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, '\n')
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, str(linNomeRA)+'\n')
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, str(linNumPtRA)+'\n')
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, '\n')
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, str(linTunnel1)+'\n')
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, str(linTunnel2)+'\n')
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, '\n')
      
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, '}\n')
        self.gravar_infosArqTransferPhp(myIdx.infosSwaPyToPhpFmt, myIdx.ADD, '\n=================================================================================\n')

    # end def formatarInfosSwaRa


    def gravarVarsIni_block(self, acao, dirArq, siglaUF, nomeSWA, ipSWA, nomeRA, numPtRA, numGVLAN, numSVLAN, nomeHL5G):
        """  Grava variáveis usando ConfigParser (formato INI padrão)  """
        print(f"gravarVarsIni({acao}, {siglaUF}, {nomeSWA}, {ipSWA}, {nomeRA}, {numPtRA}, {numGVLAN}, {numSVLAN}, {nomeHL5G}")
        
        try:
                
            if acao == myIdx.RST:   # caso de re-iniciar testes, ou cmd:clr...limpa arq.ini
                siglaUF = ""         
                nomeSWA = "" 
                ipSWA = ""     
                nomeRA = ""       
                numPtRA = ""          
                numGVLAN = ""   
                numSVLAN = ""    
                nomeHL5G = ""  
            if acao == myIdx.START:
                lerVars = self.lerVarsIni()
                if not objTools.validar(siglaUF, myIdx.UF): siglaUF = lerVars[myIdx.iniUF]             # Se valor enviado p/ gravar for invalido, regrava(mantem) o valor já existente
                nomeSWA = nomeSWA                       # NA ENTRADA NOME SWA(E SO DE PROCURA NO CAT DEVICElIST XXX-SWA-0) NAO PASSA EM objTools.validar 
                if not objTools.validar(ipSWA, myIdx.IP):  ipSWA = lerVars[myIdx.iniIpSWA]             # Se valor enviado p/ gravar for invalido, regrava(mantem) o valor já existente
                if not objTools.validar(nomeRA, myIdx.SWA):  nomeRA = lerVars[myIdx.iniNmRA]           # Se valor enviado p/ gravar for invalido, regrava(mantem) o valor já existente
                if not objTools.validar(numPtRA, myIdx.SWA):  numPtRA = lerVars[myIdx.iniPtRA]         # Se valor enviado p/ gravar for invalido, regrava(mantem) o valor já existente
                if not objTools.validar(numGVLAN, myIdx.GVLAN):  numGVLAN = lerVars[myIdx.iniGVLAN]    # Se valor enviado p/ gravar for invalido, regrava(mantem) o valor já existente
                if not objTools.validar(numSVLAN, myIdx.SVLAN):  numSVLAN = lerVars[myIdx.iniSVLAN]    # Se valor enviado p/ gravar for invalido, regrava(mantem) o valor já existente
                if not objTools.validar(nomeHL5G, myIdx.SWA):  nomeHL5G = lerVars[myIdx.iniHL5G]       # Se valor enviado p/ gravar for invalido, regrava(mantem) o valor já existente
            else:  
                lerVars = self.lerVarsIni()
                if not objTools.validar(siglaUF, myIdx.UF): siglaUF = lerVars[myIdx.iniUF]             # Se valor enviado p/ gravar for invalido, regrava(mantem) o valor já existente
                if not objTools.validar(nomeSWA, myIdx.SWA):  nomeSWA = lerVars[myIdx.iniNmSWA]        # Se valor enviado p/ gravar for invalido, regrava(mantem) o valor já existente
                if not objTools.validar(ipSWA, myIdx.IP):  ipSWA = lerVars[myIdx.iniIpSWA]             # Se valor enviado p/ gravar for invalido, regrava(mantem) o valor já existente
                if not objTools.validar(nomeRA, myIdx.SWA):  nomeRA = lerVars[myIdx.iniNmRA]           # Se valor enviado p/ gravar for invalido, regrava(mantem) o valor já existente
                if not objTools.validar(numPtRA, myIdx.SWA):  numPtRA = lerVars[myIdx.iniPtRA]         # Se valor enviado p/ gravar for invalido, regrava(mantem) o valor já existente
                if not objTools.validar(numGVLAN, myIdx.GVLAN):  numGVLAN = lerVars[myIdx.iniGVLAN]    # Se valor enviado p/ gravar for invalido, regrava(mantem) o valor já existente
                if not objTools.validar(numSVLAN, myIdx.SVLAN):  numSVLAN = lerVars[myIdx.iniSVLAN]    # Se valor enviado p/ gravar for invalido, regrava(mantem) o valor já existente
                if not objTools.validar(nomeHL5G, myIdx.SWA):  nomeHL5G = lerVars[myIdx.iniHL5G]       # Se valor enviado p/ gravar for invalido, regrava(mantem) o valor já existente

            print(f"Gravando: {nomeSWA}")

            config = configparser.ConfigParser()
            
            config['VARIAVEIS'] = {
                'siglaUF': siglaUF,
                'nomeSWA': nomeSWA,
                'ipSWA': ipSWA,
                'nomeRA': nomeRA,
                'numPtRA': numPtRA,
                'numGVLAN': numGVLAN,
                'numSVLAN': numSVLAN,
                'nomeHL5G': nomeHL5G
            }

            # with open('C:/wamp64/www/rd2r3/Robos/configs/varsGetInfos.ini', 'w') as arquivo:
            with open(dirArq, 'w') as arquivo:
                config.write(arquivo)
            
            print("Variáveis gravadas com sucesso usando ConfigParser")
        except Exception as e:
            print(f"Exception  objArquivos.gravarVarsIni() {e}")
            objTools.debbug(myIdx.noJumpLin, f"Exception objArquivos.gravarVarsIni_block() - {e}")

    # end def gravarVarsIni_block

    #------------ Ler arq-transfer com dados da Pagina -----------#
    def lerArqDadosTicket(self, arquivo):
        """ Ler arq.csv com infos do ticket em uso gerado pelo Php """
        objTools.debbug(myIdx.noJumpLin, 'objArquivos().lerArqDadosTicket()')   

        # Inicializa uma lista para armazenar as linhas
        linhas = []
        # C:\wamp64\www\rd2r3\Robos\transfers/dadosTicket_temp.csv
        arquivo = myIdx.dadosTktPhpToPy  # Transferencia de dados entre Php e Robos

        # INICIALMENTE ESTA ASSIM:
        # 0         1   2                       3           4
        # 2119670	IPD	ENERGISA SOLUCOES SA	osb-swa-01	ERB

        n = 0
        try:
            # Abre o arquivo em modo de leitura    
            # with open(arquivomyIdx.csv, 'r') as arquivo:    # Aqui funciona so no VSCode(.exe NAO funciona)
            with open(arquivo, 'r', encoding='ISO-8859-1') as arquivo:
                # Lê todas as linhas e adiciona na lista
                linhas = arquivo.readlines()
                print(str(n)+': '+linhas+'\n')
                n+=1
        except FileNotFoundError:
            objTools.debbug(myIdx.noJumpLin,'objArquivos().ler_dadosTicket(O arquivo:' +  arquivo + ' não foi encontrado.)')
            print("O arquivo dadosTicket.csv não foi encontrado.")
        except Exception as e:
            print(f"Exception lerArqdadosTicket() - {e}")
            objTools.debbug(myIdx.noJumpLin,f"objArquivos().lerArqDadosTicket() - Ocorreu um erro: {e} => " +  arquivo)
            print(f"Ocorreu um erro: {e}")
        
        return linhas

    # end  def lerArqDadosTicket

    #-------------------------------------------------------------------------------#
    # Lê dados do Ticket
    def getDadosTkt(self): 

        try:

            dadosTicket = self.lerArqDadosTicket()   # carrega dados do Ticket: C:\wamp64\www\rd2r3\Robos\transfers\dadosTicket_temp.csv
            objTools.debbug(myIdx.noJumpLin,'objArquivos().getDadosTkt()')
            
            linDadosTicket = objTools.separaCelulas(dadosTicket[0])  
            
            dados = {}
            dados[myIdx.ID] = linDadosTicket[myIdx.ID]
            dados[myIdx.PDT] = linDadosTicket[myIdx.PDT]
            dados[myIdx.CLIENTE] = linDadosTicket[myIdx.CLIENTE]
            dados[myIdx.SWA] = linDadosTicket[myIdx.SWA]
            dados[myIdx.OPER] = linDadosTicket[myIdx.OPER]
            dados[myIdx.SWT] = linDadosTicket[myIdx.SWT]
            dados[myIdx.IPSWT] = linDadosTicket[myIdx.IPSWT]
            dados[myIdx.SPEED] = linDadosTicket[myIdx.SPEED]+'.0'
            dados[myIdx.SVLAN] = linDadosTicket[myIdx.SVLAN] 
            dados[myIdx.CVLAN] = linDadosTicket[myIdx.CVLAN] 
            dados[myIdx.EDD] = linDadosTicket[myIdx.EDD] 
            dados[myIdx.PtRA] = linDadosTicket[myIdx.PtRA] 
            dados[myIdx.ATP] = linDadosTicket[myIdx.ATP] 
            dados[myIdx.UF] = linDadosTicket[myIdx.UF] 
            dados[myIdx.NmRA] = linDadosTicket[myIdx.NmRA] 
            dados[myIdx.NmHL5G] = linDadosTicket[myIdx.NmHL5G] 
            
            return dados  

        # caso de algum erro ...retorna null e continua rodando...
        #except Exception:
        except Exception as e:
            #print(f"Exception main().while->lin2182:  {e}")
            print(f"Exception getdadosTkt() - {e}")
            dados = [{'Null', 'Null','Null','Null','Null','Null','Null','Null','Null','Null','Null','Null','Null','Null','Null','Null'}]
            return dados
        
    # end  def getDadosTkt

    