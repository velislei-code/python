from datetime import datetime
#import importlib.util    # Para carregar classes em outro arquivo.py

# Carregar Classes
from ClassIndices import myIdx  # Importando a classe


class Tools:
    """Classe responsável por gravar linhas em arquivos de transferência de dados."""

    def __init__(self):
        self.dados = []
    
    def carregar(self):
        print("Carregando...")

    def inicializar(self):
        print("Inicializando...")
        self.debbug()       # ← método "privado"


    @staticmethod  
    def debbug(jumpLIN, linha):
        if myIdx.DEBBUG: 
            # Obtém a data e hora atual
            #data_hora_atual = datetime.now()

            # Formata a data e hora como string
            fmtData = datetime.now().strftime("%d/%m/%Y")             
            fmtHora = datetime.now().strftime("%H:%M:%S")             
            try:            
                with open("debbug.txt", "a") as arquivo:  # Usa o modo 'a' para adicionar conteúdo ao arquivo.
                    if jumpLIN == myIdx.addJumpLin: 
                        arquivo.write("\n")  # Adiciona a mensagem com uma quebra de linha.
                        arquivo.write("Debbug[" + fmtData + "] " + linha +"\n")
                    if jumpLIN == myIdx.noJumpLin: 
                        arquivo.write("Debbug[" + fmtHora + "] " + linha +"\n")  # Sem Add Lin a mensagem com uma quebra de linha.            
                            
            except Exception as e:
                print("Exception debbug()->lin171")
                print(f"Erro ao escrever no log: {e}")

    def separaCelulas(self, linha):
        self.debbug(myIdx.noJumpLin, 'separaCelulas()')   
        # Separa a linha usando o delimitador ';' e retorna uma lista com os dados
        return linha.split(";")

    def formatar(self, codigo, num):
        self.debbug(myIdx.noJumpLin, 'formatar()')
        # Verifica se o código segue o formato esperado e tem comprimento adequado
        if len(codigo) >= 18 and codigo[8] == '-' and codigo[9:].isalnum():
            # Extrai os últimos 7 caracteres após o hífen
            return codigo[-num:]
        else:
            return codigo
            #raise ValueError("Código não está no formato esperado")


    def filtrarLin(self, linha):
        if 'name' in linha: return True
        elif 'nomeIpSwa' in linha: return True
        #    varIni = lerVarsIni()
        #    if str(varIni(myIdx.iniUF)) in linha: return True    # m-br-am-mns-agi-swa-01, pega UF pra evitar imprimir swa de outro UF
        elif 'get' in linha: return True                    # Bot getInfosSWA, getInfosRSD
        elif '{' in linha: return True
        elif '}' in linha: return True
        elif 'vlan' in linha: return True
        elif '=' in linha: return True
        elif 'rsd' in linha: return True
        elif 'rai' in linha: return True
        elif 'rav' in linha: return True
        elif 'hl5g' in linha: return True
        elif 'gws' in linha: return True
        elif 'IPD' in linha: return True
        elif 'VPN' in linha: return True
        elif 'FIBRA' in linha: return True
        else: return False

    def validar(self, elto, tipo):
        # Validar formato do swa e/ou RA
        # m-br-ma-sls-lsv-swa-01 10.51.228.26
        # SWA:   m-br-ma-sls-lsv-swa-01(22), m-br-ma-sls-lsvx-swa-01(23) 
        # RA:    i-br-ma-sls-sfr-rsd-01, c-br-ma-sls-sfr-rav-01
        # HL5G:  i-br-go-gna-fly-hl5g-01
        #       Padrao(Ra): Tam = 22, 6 tracos, 2 numeros, 14 letras
        # IP:  X.X.X.X(7) a 000.000.000.000(15)
        elemento = str(elto)
        print("Validado: " + elemento)
        try:
            # Cálculos
            # tam = len(elemento)  
            numLet = sum(1 for c in elemento if c.isalpha())  
            numNum = sum(1 for c in elemento if c.isdigit())
            numTracos = elemento.count('-')
            numBarra = elemento.count('/')
            numPtos = elemento.count('.')   
            
            if tipo == myIdx.IP:
                Total = numPtos + numLet + numNum
                if Total > 6 and Total < 16: 
                    if numPtos == 3: 
                        if numLet < 1:  ## N'ao deve haver letras em ipv4(=0)
                            if numNum > 3 and numNum < 13: return True      # Se passou em todas as condiçoes...retorna  True
                            else: return False    
                        else: return False    
                    else: return False  
                else: return False  
            
            elif tipo == myIdx.PTRA:
                # Pt PW- PWE 1234   
                if numBarra == 0 and numTracos == 0 and numPtos == 0:
                    if numNum == 4: 
                        if numLet == 0: return True
                        else: return False
                    else: return False        

                else:

                    # Pt Nokia 2/1/c/13/4
                    if numBarra == 4 or numTracos == 4 or numPtos == 4:
                        if 'c' in elemento.lower():
                            if numNum > 3: return True   
                            else: return False
                        else: return False

                    # Pt Cisco 0/6/0/28
                    if numBarra == 3 or numTracos == 3 or numPtos == 3:   
                        if numNum > 3: return True   
                        else: return False             
            
            elif tipo ==  myIdx.GVLAN:
                if numNum == 1 or numNum == 2 or numNum == 4: 
                        if numLet == 0: return True
                        else: return True
                else: return True

            elif tipo ==  myIdx.CVLAN:
                if  numNum == 3 or numNum == 4: 
                        if numLet == 0: return True
                        else: return True
                else: return True
                
            elif tipo ==  myIdx.SVLAN:
                if numNum == 4 and numLet == 0: return True
                else: return True

            elif tipo == myIdx.ESTACAO:     
                Total = numTracos + numLet + numNum
                if Total == 3: 
                    if numLet == 3: return True  # Se passou em todas as condiçoes...retorna  True
                    else: return False    
                else: return False    

            elif tipo ==  myIdx.UF:
                # check se UF esta na lista          
                if "AL" in elemento or "al" in elemento: return True
                elif "AP" in elemento or "ap" in elemento: return True
                elif "AM" in elemento or "am" in elemento: return True
                elif "BA" in elemento or "ba" in elemento: return True
                elif "CE" in elemento or "ce" in elemento: return True
                elif "DF" in elemento or "df" in elemento: return True
                elif "ES" in elemento or "es" in elemento: return True
                elif "GO" in elemento or "go" in elemento: return True
                elif "MA" in elemento or "ma" in elemento: return True
                elif "MT" in elemento or "mt" in elemento: return True
                elif "MS" in elemento or "ms" in elemento: return True
                elif "MG" in elemento or "mg" in elemento: return True
                elif "PA" in elemento or "pa" in elemento: return True
                elif "PB" in elemento or "pb" in elemento: return True
                elif "PR" in elemento or "pr" in elemento: return True
                elif "PE" in elemento or "pe" in elemento: return True
                elif "PI" in elemento or "pi" in elemento: return True
                elif "RJ" in elemento or "rj" in elemento: return True
                elif "RN" in elemento or "rn" in elemento: return True
                elif "RS" in elemento or "rs" in elemento: return True
                elif "RO" in elemento or "ro" in elemento: return True
                elif "RR" in elemento or "rr" in elemento: return True
                elif "SC" in elemento or "sc" in elemento: return True
                elif "SP" in elemento or "sp" in elemento: return True
                elif "SE" in elemento or "se" in elemento: return True
                elif "TO" in elemento or "to" in elemento: return True       
                else: return False 

            else: # SWA, RA, HL5G  
                Total = numTracos + numLet + numNum
                if Total == 22 or Total == 23: 
                    if numTracos == 6: return True  # Se passou em todas as condiçoes...retorna  True
                    else: return False    
                else: return False    


        except Exception as e:
            print(f"Exception validar("+elemento+")->lin812 {e}")
            return False

    def formatePorta(self, nPtRa): 
        # procura/retorna: por 0-6-0-28, 0/6/0/28 ou pwe1306
    
        # abc0/6/0/28 valida-> 0/6/0/28
        # pwe1034 valida-> pwe1034
        Res = ""
        nPtRaX = nPtRa.lower()
        for i in range(len(nPtRaX)): 

            for d in range(10):                         # procura por numeros de 0 a 9 
                if str(d) in nPtRaX[i]:  
                    Res = Res + nPtRaX[i] 

            # aceita '/' ou '.', '-'(troca por '/') 
            if '/' in nPtRaX[i] or '-' in nPtRaX[i] or '.' in nPtRaX[i]:    
                Res = Res + '/' 
            
            # p/ Nokia: 2/1/c13/3... pega o 'c'
            if 'c' in nPtRaX[i]:
                    Res = Res + nPtRaX[i]    # abdfe2/1/c13/4 valida-> 2/1/13/4

            if i < 3:   # aceita pwe desde que esteja no inicio
                if 'p' in nPtRaX[i]:
                    Res = Res + nPtRaX[i] 
                if 'w' in nPtRaX[i]:
                    Res = Res + nPtRaX[i] 
                if 'e' in nPtRaX[i]:
                    Res = Res + nPtRaX[i] 

        return Res


    def getLetras(self, texto):
        """
        Retorna apenas os caracteres alfabéticos de uma string.
        
        Parâmetros:
        texto (str): String de entrada contendo vários caracteres
        
        Retorna:
        str: String contendo apenas letras (maiúsculas e minúsculas)
        """
        return ''.join(caractere for caractere in texto if caractere.isalpha())
