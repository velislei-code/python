import os
#--- Posicionar janela --- #
import ctypes
from ctypes import wintypes

import pyautogui
import time
import pygetwindow as gw    # Ativar janela(Moba)


# --------------------------------------------------------#
# Notificao tipo Toast
# pip install plyer
from plyer import notification # notification.notify
#--------------------------------------------------------#


from ClassTools import Tools  # Importando a classe
from ClassIndices import myIdx  # Importando a classe

# Instancia a classe
objTools = Tools()

class Windows:
    """Classe responsável por gravar linhas em arquivos de transferência de dados."""

    def __init__(self):
        self.dados = []
    
    def carregar(self):
        print("Carregando...")


    @staticmethod 
    def myToast(self, titulo, msg, appName, time):
        notification.notify(
                title=titulo,
                message=msg,
                app_name=appName,
                timeout=time  # segundos (padrão é 10)
            )


    def posicionar_janela(self, pos_x, pos_y, largura_janela, altura_janela):
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
                #largura_janela = 55
                #altura_janela = 15
                                    
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
            print("Exception posJanela()->lin217")
            print(f"Erro ao posicionar janela: {e}")




    def janela(self, largura, altura):
        objTools.debbug(myIdx.noJumpLin, 'janela()')
        # Comando para alterar o tamanho da janela no Windows
        os.system(f'mode con: cols={largura} lines={altura}')

    def cores(self):
        objTools.debbug(myIdx.noJumpLin, 'cores()')
        # Cor de fundo azul e texto cinza
        # \033[44m altera o fundo para azul, \033[38;5;8m altera o texto para cinza
        print("\033[44m\033[97m", end="")  # Define o fundo azul e o texto branco
        # print("\033[44m\033[38;5;8m", end="")  # Define o fundo azul e o texto cinza    
        #print("\033[0m", end="")  # Reseta as cores para o padrão após o texto


    def limpar(self, N):
        for _ in range(N):
            print()  # Imprime uma linha vazia 

    def logo(self):
        print("     _______")       
        print("    (_)^_^(_)")
        print("     / (_) \  Get Infos")       
        print("     \__^__/  by: Treuk VA-2025 rv-07.09.25")  
        print("                               ")     
        print("            ") 


    def key(self):
        print("   ____ ")       
        print("  / () \_______   ")
        print("  \____/^^^^^^^'   ")     
        print("  Digite sua Senha:") 
        print("            ") 


    def zoomMais(self, quantidade, intervalo):
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


    def zoomMenos(self, quantidade, intervalo):
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

