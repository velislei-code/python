import time
import pyautogui
import pyperclip

from ClassWindow import Windows  # Importando a classe
from ClassTools import Tools  # Importando a classe
from ClassIndices import myIdx 

# Instancia a classe
objWindows = Windows()
objTools = Tools()

class Bots:

    def __init__(self):
        self.dados = []
    
    def carregar(self):
        print("Carregando...")

    def inicializar(self):
        print("Inicializando...")
        self.colar_pw_enter()       # ← método "privado"


    @staticmethod 
    def colar_pw_enter(self, conteudo, desviaBugs):
        objTools.debbug(myIdx.noJumpLin, 'objBots().colar_pw_enter('+conteudo+')')
        
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

    """
    def _logarV1(host, pwLog, cmdMobaX, cmdMobaY, tFast, tLogar, desviaBugsLgX, shAppX, shAppY):
        objTools.debbug(myIdx.noJumpLin, 'logar('+str(host)+', '+str(pwLog)+',,,,,,,,)')
        
        pyperclip.copy('')
        time.sleep(tFast)
        limpar(20)
        key()   # Lembra de password    
        mover_e_clicar('Unknown', cmdMobaX, cmdMobaY)
        time.sleep(tFast)
        time.sleep(tFast)
        colar_pw_enter('ssh '+host, desviaBugsLgX) 
        time.sleep(tLogar)                 # Aguarda User digitar senha para prosseguir        
    
        objTools.debbug(myIdx.noJumpLin, 'desviaBugs = 1 - [BackSpace] - L208 - block')
        limpar(20)
        key()        
        #mover_e_clicar('Unknown', shAppX, shAppY)  # Trasfere jan-app para tela
        #time.sleep(tFast)  
        #mover_e_clicar('Unknown', cmdMobaX, cmdMobaY) # Click no campo janela Moba
    
        # <Esc> Interrompe processo(15* 0.2 = 3.0)
        for i in range(10):
            time.sleep(tFast)  # 0.2 * 35 = 7seg(Máx)       
            if keyboard.is_pressed('esc'):
                stop = input("Break for user[def _logar()]. Continue?<E>")

        # --------------- CHECK QUESTION YES/NO AO LOGAR ------------------------------------------------------------------ #
        ""
        numLinUP = posIniArrasteCopyY - (myIdx.altLinPx * 12)   # Pega 6 linhas(baixo p/ Cima) (980 - (25*6)) = 830  
        getAnswer = clickArrasteCopy(posIniArrasteCopyX, posIniArrasteCopyY,  numLinUP, myIdx.SpeedARRASTE,  tCmd) 

        if 'Invalid' in getAnswer:                        # Cmd(do dm4050) Invalido...entao...é 2104
            modeloEDD = '2104G'
        elif '%Unknown' in getAnswer:                     # Cmd(do dm4050) Invalido...entao...é 2104
            modeloEDD = 'V380R220'
            desviaBugs = 3                                # Ver se precisa de X espaços de retorno após cmd
            objWindows.zoomMenos(myIdx.ZOOM, intervalo=0.1)  
        ""
        # -------------------------------------------------------------------------------------- #
        # Precisa usar o Mouse-Dir->Paste pois auto-colar(shift+insert ou ctrl+v) Buga
        # Usando Paste com Mouse
        pyperclip.copy(pwLog)              # Envia Senha para area-ClipBoard 
        time.sleep(tFast)
        mover_e_clicar('Unknown', cmdMobaX, cmdMobaY) # Click no campo janela Moba
        time.sleep(tFast)
        pyautogui.rightClick()                      # btn Dir do Mouse
        time.sleep(tFast)
        mover_e_clicar('Unknown', cmdMobaX + 50, cmdMobaY - 496)   # ajusta Pos em selecionar: Paste
        time.sleep(tFast)
        pyautogui.hotkey('enter')
        time.sleep(tFast)
        # -------------------------------------------------------------------------------------- #
        pyperclip.copy('')  # Limpar Clipboard antes de iniciar testes IP - necessario pois esta ficando lixo                 
    """        

    def logar(self, host, pwLog, cmdMobaX, cmdMobaY, posIniArtCopyX, posIniArtCopyY, tFast, tLogar, desviaBugsLgX, shAppX, shAppY):
        objTools.debbug(myIdx.noJumpLin, 'objBots().logar('+str(host)+', '+str(pwLog)+',,,,,,,,)')
        
        pyperclip.copy('')
        time.sleep(tFast)
        objWindows.limpar(20)
        objWindows.key()   # Lembra de password    
        self.mover_e_clicar('logar()', cmdMobaX, cmdMobaY)
        time.sleep(tFast)
        time.sleep(tFast)
        self.colar_pw_enter(self, 'ssh '+host, desviaBugsLgX) 
        time.sleep(tLogar)                 # Aguarda User digitar senha para prosseguir        
    
        objTools.debbug(myIdx.noJumpLin, 'desviaBugs = '+str(desviaBugsLgX)+' - [BackSpace] - L208 - block')
        objWindows.limpar(20)
        objWindows.key()        
        #mover_e_clicar('Unknown', shAppX, shAppY)  # Trasfere jan-app para tela
        #time.sleep(tFast)  
        #mover_e_clicar('Unknown', cmdMobaX, cmdMobaY) # Click no campo janela Moba
    
        """
        # <Esc> Interrompe processo(15* 0.2 = 3.0)
        for i in range(10):
            time.sleep(tFast)  # 0.2 * 35 = 7seg(Máx)       
            if keyboard.is_pressed('esc'):
                stop = input("Break for user[def logar()]. Continue?<E>")
        """
        # --------------- CHECK QUESTION YES/NO AO LOGAR ---------------------------------------- #
        # Are you sure you want to continue connecting (yes/no/[fingerprint])? yes^[[2~      
        # So para swa, a grande maioria dos RSD´s não pede, mas futuramente...
        # if 'swa' in host or 'swo' in host or 'she' in host:
        
        # Precisa usar o Mouse-Dir->Paste pois auto-colar(shift+insert ou ctrl+v) Buga
        # Usando Paste com Mouse
        pyperclip.copy('yes')                           # Envia Senha para area-ClipBoard a   -- Ja esta aparecendo no tacacs, em alguns casos - acho que é aquela bugada do tacacs que mudam
        objTools.debbug(myIdx.noJumpLin, 'logar() -> yes <enter>')
        time.sleep(tFast)
        if desviaBugsLgX > 0:           # SE > 0 Aplica Pasta com mouse...se não so no enter ja vai...depende daquelas mudanças de comportamento do tacacs
            self.mover_e_clicar('logar()', cmdMobaX, cmdMobaY)              # Click no campo janela Moba
            time.sleep(tFast)
            pyautogui.rightClick()                          # btn Dir do Mouse
            time.sleep(tFast)
            self.mover_e_clicar('logar()', cmdMobaX + 50, cmdMobaY - myIdx.ajtPASTE)   # ajusta Pos em selecionar: Paste
            time.sleep(tFast)

        pyautogui.hotkey('enter')  # < Esse enter tá enviando 'yes' tb
        time.sleep(tFast)
            
        """
        TB Bugou...tem que ser via Paste(acima)
        # So inseri 'yes' encima da password e depois enviei a password...passou
        colar_pw_enter('yes', 4)        # 4 backspace -> yes^[[2~ 
        time.sleep(tFast)
        """
        """
        Nao funcionou, o log caiu...
        getAnswer = clickArrasteCopy(posIniArtCopyX, posIniArtCopyY, myIdx.numCOLS, 12, myIdx.SpeedARRASTE, tFast) 
        if 'yes' in getAnswer.lower():          # Se resposta contem yes/no...envia yes
            pyperclip.copy('yes')               # Envia 'yes' para area-ClipBoard 
            time.sleep(tFast)
            mover_e_clicar('Unknown', cmdMobaX, cmdMobaY)  # Click no campo janela Moba
            time.sleep(tFast)            
            colar_pw_enter('yes', desviaBugsLgX) 
            time.sleep(tFast)
        """
        
        
        
        # -------------------------------------------------------------------------------------- #
        # Precisa usar o Mouse-Dir->Paste pois auto-colar(shift+insert ou ctrl+v) Buga
        # Usando Paste com Mouse
        pyperclip.copy(pwLog)                           # Envia Senha para area-ClipBoard 
        time.sleep(tFast)
        self.mover_e_clicar('logar()', cmdMobaX, cmdMobaY)              # Click no campo janela Moba
        time.sleep(tFast)
        pyautogui.rightClick()                          # btn Dir do Mouse
        time.sleep(tFast)
        self.mover_e_clicar('logar()', cmdMobaX + 50, cmdMobaY - myIdx.ajtPASTE)   # ajusta Pos em selecionar: Paste
        time.sleep(tFast)
        pyautogui.hotkey('enter')
        time.sleep(tFast)
        # -------------------------------------------------------------------------------------- #
        pyperclip.copy('')  # Limpar Clipboard antes de iniciar testes IP - necessario pois esta ficando lixo                 

    # end logar()   

    def mover_e_clicar(self, origem, x, y):
        objTools.debbug(myIdx.noJumpLin, 'objBots().mover_e_clicar('+ origem +' call, '+str(x)+', '+str(y)+ ')')
        pyautogui.moveTo(x, y)
        pyautogui.click()

    def mover_e_copiar(self, x, y):
        objTools.debbug(myIdx.noJumpLin, 'objBots().mover_e_copiar()')
        pyautogui.moveTo(x, y)
        for _ in range(3):
            pyautogui.click()
            time.sleep(0.2)
        pyautogui.hotkey('ctrl', 'c')
        time.sleep(0.5)

    def mover_e_colar(self, x, y):
        objTools.debbug(myIdx.noJumpLin, 'objBots().mover_e_colar()')
        pyautogui.moveTo(x, y)    
        pyautogui.click()
        time.sleep(0.5)
        pyautogui.hotkey('ctrl', 'v')
        time.sleep(0.5)

    def moveClickColaEnter(self, conteudo, x, y):
        objTools.debbug(myIdx.noJumpLin, 'objBots().moveClickColaEnter()')
        pyautogui.moveTo(x, y)    
        pyautogui.click()
        pyautogui.write(conteudo)
        time.sleep(0.5)
        pyautogui.hotkey('ctrl', 'v')    
        time.sleep(0.5)
        pyautogui.hotkey('enter')
        pyautogui.hotkey('enter')
        time.sleep(0.5)


    def colar_e_enter(self, conteudo, tCurto): 
        objTools.debbug(myIdx.noJumpLin, 'objBots().colar_e_enter()')   
        pyautogui.write(conteudo)
        pyautogui.hotkey('shift', 'insert')
        time.sleep(tCurto)    
        pyautogui.hotkey('enter')
        pyperclip.copy('')

    def colar_space_enter(self, conteudo, tCurto): 
        objTools.debbug(myIdx.noJumpLin, 'objBots().colar_space_enter()')   
        pyautogui.write(conteudo)
        pyautogui.hotkey('shift', 'insert')
        time.sleep(tCurto)    
        pyautogui.hotkey('enter')
        pyperclip.copy('')
   

    def clickArrasteCopy(self, start_x, start_y, numCharToRightX, numLinToUpY, duration, tFast):
        """ Seleciona parte(x,y) da tela e copias texto """
        objTools.debbug(myIdx.noJumpLin, 'objBots().clickArrasteCopy('+str(start_x)+', '+str(start_y)+', '+str( numCharToRightX)+', '+str(numLinToUpY)+', '+str(tFast)+')')

        # calc. num Char e Linhas de retorno
        nCharToRightX = start_x + (myIdx.largCharPx * numCharToRightX)    # Pega X linhas(esquerda p/ direita) (980 - (25*6)) = 830  
        nLinToUpY = start_y - (myIdx.altLinPx * numLinToUpY)         # Pega Y linhas(baixo p/ Cima) (980 - (25*6)) = 830  


        # try:
        # Move to the start position
        pyautogui.moveTo(start_x, start_y, duration)
        
        # Click and hold
        pyautogui.mouseDown()

        # Drag to the end position
        pyautogui.moveTo(nCharToRightX, nLinToUpY, duration)

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
        
        """
        except Exception as e:
            print("Exception clickArrasteCopy()->lin620")
            print(f"An error occurred: {e}")
            return None

        """

    # end def clickArrasteCopy

 