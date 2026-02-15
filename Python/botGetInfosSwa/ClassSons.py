import winsound
import time


class Sons:

    def __init__(self):
        self.dados = []
    
    def carregar(self):
        print("Carregando...")


    @staticmethod  
    def beep_windows3():
        """Emitir 3 beeps no Windows"""
        for i in range(3):
            winsound.Beep(1000, 500)  # Frequência 1000Hz, duração 500ms
            time.sleep(0.3)  # Intervalo de 300ms entre beeps
        #print("3 beeps emitidos!")

    def beepShort():
        winsound.Beep(1000, 100)  # Frequência 1000Hz, duração 500ms
        time.sleep(0.3)  # Intervalo de 300ms entre beeps
        #print("3 beeps emitidos!")

    def beep_windows():
    # Configurações de som
        frequency = 1000  # Hz
        short_beep = 150  # ms
        medium_beep = 300 # ms
        long_beep = 600   # ms
        pause_short = 100 # ms
        pause_medium = 200 # ms
        
        # Sequência mais elaborada
        sequences = [
            [short_beep, pause_short],
            [short_beep, pause_short],
            [short_beep, pause_medium],
            [medium_beep, pause_medium],
            [long_beep, 0]
        ]
        
        for duration, pause_duration in sequences:
            winsound.Beep(frequency, duration)
            if pause_duration > 0:
                time.sleep(pause_duration/1000)


    def beep_windows2():

    # Frequência e duração dos bipes
        frequency = 1000  # Hz
        short_beep = 200  # ms
        long_beep = 500   # ms
        pause = 200       # ms
        
        # Padrão de anúncio de aeroporto (três bipes curtos seguidos de um longo)
        for _ in range(3):
            winsound.Beep(frequency, short_beep)
            time.sleep(pause/1000)
        
        time.sleep(pause/1000 * 2)  # Pausa um pouco mais antes do bip longo
        winsound.Beep(frequency, long_beep)
