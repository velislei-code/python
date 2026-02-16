/* CC50-O
 * Curso de Ciência da Computação de Harvard no Brasil
 * by: Treuk, Velislei A
 * email: velislei@gmail.com
 * 31/Jul/2024
 * Modulo 4
 * Program: Detect tipo arq
 *          Este programa faz uma verificacao do tipo de arquivo, consultando os valores,
 *          nos bytes do cabecario do mesmo.
 */

#include <stdint.h> // uint8_t
#include <stdio.h>
#include <stdlib.h>

typedef uint8_t BYTE; // Cria um tipo definido como BYTE de uint8_t - so uma renomeacao
                      // uint8_t é um tipo inteiro, 1 byte, sem sinal(+ou-)
                      // uint16_t é um tipo inteiro, 2 byte, COM sinal(+ e -)

int main(int argc, char *argv[])
{
    // Check command-line arguments
    if (argc != 2)
    {
        // Escreve : Use: copy SOURCE DESTINATION no arquivo stderr
        fprintf(stderr, "Use: copy SOURCE DESTINATION\n");
        return 1; // Termina com retorno de 1 erro
    }

    // Open files and determine scaling factor
    FILE *arquivo = fopen(argv[1], "r");
    if (arquivo == NULL)
    {
        printf("Could not open file.\n");
        return 1;
    }
    // Read first three bytes
    BYTE bytes[3];

    fread(bytes, sizeof(BYTE), 3, arquivo);

    // chech first three bytes
    if (bytes[0] == 0xff && bytes[1] == 0xd8 && bytes[2] == 0xff)
    {
        printf("Maybe\n");
    }
    else
    {
        printf("No\n");
    }
}
