"""
by: Treuk, Velislei A
email: velislei@gmail.com
Copyright(c) Fev/2026
All Rights Reserveds    
Uso exclusivo para estudantes de código
"""
import time
import pyautogui
import pyperclip
import pygetwindow as gw    # Ativar janela(Moba)

from ClassBot import Bots  # Importando a classe
from ClassTools import Tools  # Importando a classe
from ClassIndices import myIdx 

# Instancia a classe
objBots = Bots()
objTools = Tools()

class Terminal:
    """Classe responsável por gravar linhas em arquivos de transferência de dados."""

    def __init__(self):
        self.dados = []
    
    def carregar(self):
        print("Carregando...")

    def inicializar(self):
        print("Inicializando...")
        self.ativarMobaXterm()       # ← método "privado"


    @staticmethod 
    def ativarMobaXterm(self):
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
            print(f"Exception ativarMobaTerm()->lin1955")
            print(f"❌ Erro ao ativar MobaXterm: {e}")
            return False
        

    def ativaMoba(self, icoMobaX, icoMobaY, janMobaX, janMobaY, tFast):
        objTools.debbug(myIdx.noJumpLin, 'ativaMoba()')

        # Se ativar_MobaTerminal falhar(3x), exec.manual(click no icone)
        # Isso evita, entre outreas coisas, que navegador seja mexido no lugar do MobaTerm, e bagunça td
        if self.ativarMobaXterm() == False:    
            if self.ativarMobaXterm() == False: 
                if self.ativarMobaXterm() == False: 
                    #print("ativaMoba()")

                    objTools.debbug(myIdx.noJumpLin, 'ativaMoba('+str(icoMobaX)+', '+str(icoMobaY)+', '+str(janMobaX)+', '+str(janMobaY)+', '+str(tFast)+')')
                
                    #Ativar janela Moba 
                    objBots.mover_e_clicar('Unknown', icoMobaX, icoMobaY)
                    time.sleep(tFast)

                    # Mover para a janela e clicar (x1 x y500)
                    objBots.mover_e_clicar('Unknown', janMobaX, janMobaY)
                    time.sleep(tFast)


    def ativaMoba_old_semXterm(self, icoMobaX, icoMobaY, janMobaX, janMobaY, tFast):
        objTools.debbug(myIdx.noJumpLin, 'ativaMoba()')

        #print("ativaMoba()")
        #Ativar janela Moba 
        objBots.mover_e_clicar('Unknown', icoMobaX, icoMobaY)
        time.sleep(tFast)

        # Mover para a janela e clicar (x1 x y500)
        objBots.mover_e_clicar('Unknown', janMobaX, janMobaY)
        time.sleep(tFast)

    
    def prepararMoba(self, origem, abaMoba3X, abaMoba3Y, nEnter, tFast):
        
        objTools.debbug(myIdx.noJumpLin, 'prepararMoba('+ origem + ' call, ' + str(abaMoba3X) + ', ' + str(abaMoba3Y) + ', ' + str(nEnter) + ', ' + str(tFast)+')')

        #print("preparar()")
        pyperclip.copy('')
        # Executar comandos na aba 1
        objBots.mover_e_clicar('prepararMoba()', abaMoba3X, abaMoba3Y)
        pyautogui.hotkey('space')
        time.sleep(tFast)
        for _ in range(nEnter): # Num.Enter(Limpar lixos) no Moba antes de iniciar cmd
            pyautogui.hotkey('enter')
            time.sleep(tFast)  

