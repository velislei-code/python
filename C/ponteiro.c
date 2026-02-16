#include <cs50.h> // for string
#include <stdio.h>
#include <string.h> // strlen
#include <ctype.h> // toupper
#include <stdlib.h> // malloc


void linha(int nCell, int nTraco)
{
    printf("\n");

    for(int c = 0; c < nCell; c++)
    {
       // printf(".");
        for(int t = 0; t < nTraco; t++)
        {
            printf("_");
        }
    }
    //printf(".");
}


int main()
{
    /*
                |Address|Value|
                |   &   | *   |
                    00  [03]
                    01  [05]
                    02  [07]
                    03  [11]
                    04  [13]
     p Aponta p/: ->05  [17]
                    06  [23]

        n = 17
        p = 5
        *p = 17 = n
        &n = 5 = p

    */
    int array[] = {1,3,5,4,7,8,9,5,0,2};
    int *pAa = array;
    int *pAb = array;

    printf("\narray[1, 3, 5, 4, 7, 8, 9, 5, 0, 2]:");

    linha(5, 17);
    printf("\n   v    |         p        ||   Address(&p)  |     Address(&v)  Conteúdo(*p)");
    for(int i = 0; i < 10; i++)
        printf("\n v = %d  | p = %p || %p | -> %p: [  %i  ]", array[i], pAa+i /*ou pAa++ */, &pAa[i], &array[i], *(pAb+i)/*ou: *pAb++  */);
    linha(5, 17);
    printf("\n\n");

    //---------------------------------------------------------------------------------------------------------------//
    int *ponteiro;
    int conteudo;
    ponteiro = &conteudo; // & = endereço -> Ponteiro aponta para endereço de n
    conteudo = 17;

    linha(5, 17);
    printf("\n|       |                    ||  Address(&p)    |    Address(&c)     Conteudo(*p) |");
    //linha(5,20);
    printf("\n|c = %d |  p = %p  || %p  | -> %p  [   %d    ]  |", conteudo, ponteiro, &ponteiro, &conteudo, *ponteiro);
    linha(5, 17);
    printf("\n\n");

    printf("\nEndereço de c(&c): %p \n",(void *)  &conteudo); // imprime endereço que p aponta(formato Hexa)
    printf("Endereço de p(&p): %p \n", (void *) &ponteiro);
    printf("Endereço p/ onde p aponta(aponta p/ endereço de c): %p \n", (void *) ponteiro);
    printf("Conteúdo de c: %d\n", conteudo);
    printf("Conteúdo de *p: %d\n", *ponteiro);
    printf("\n\n");

    //---------------------------------------------------------------------------------------------------------------//

    string s = "HI!";
    printf("%p -> [ %s ]\n", s, s);
    for(int i = 0, tam = strlen(s); i < tam+1; i++)
        printf("    %p -> [ %c ]\n", &s[i], s[i]);

    printf("\n\n");

    char *cS = "OI!";
    printf("%p -> [ %c ]\n", cS, *cS);
    printf("%p -> [ %c ]\n", cS, *(cS+1));
    printf("%p -> [ %c ]\n", cS, *(cS+2));
    printf("%p -> [ %i ]\n", cS, *(cS+3)); // aqui pedimos imprimir %i(int)

    printf("\n\n");


    /*              [0][1][2][3 ]
                    [H][I][!][\0]   -> \0 = [00000000]
                     ^         ^
                     |       Como todas as String´s terminam com: \0, se vc tiver o endereço inicial,
                     |                          vc pode saber o final dela procurando por: \0
           p = 0x617b6d14a1cc
    Ponteiro aponta para 1/ char da string

    string s = "HI!";    ->  char *s = "HI!";
    -   Em C não existe um tipo de dados String,
        na realidade cria-se uma typedef(tipo ponteiro) na library cs50.h:  typedef char *string;
        para criar o tipo string.
    */

    typedef char *my_string; // Crio minha propria typdef(tipo defindo) de dados
    my_string m_s = "OLA!";
    printf("%p -> [ %s ]\n", m_s, m_s);
    for(int im = 0, tam = strlen(m_s); im < tam + 1; im++)
        printf("    %p -> [ %c ]\n", &m_s[im], m_s[im]);

    printf("\n\n");

    for(int ix = 0, tam = strlen(s); ix < tam + 40; ix++)
        printf("    %p -> [ %c ]\n", &s[ix], s[ix]);

   //---------------------------------------------------------------------------------------------------------------//

    printf("\n\n");

    char *S = get_string("Input S: ");
    char *P = S;    // ponteiro, atraves do endereço de S, aponta p/ conteudo de S;

    P[0] = toupper(P[0]); // como P aponta para S, Qdo converte P p/ maiuscula, na realidade converte *S
                          // para maiusculo e P aponta para S, no fim os 2 aparecem como maiusculo, mas
                          // é um unico conteudo sendo apontado p/ 2 vars

    //               conteúdo: [     hi!    ]
    //                           ^       ^
    //                           |       |
    //               Ponteiros: [*S]    [*P]

    printf("S: %s <- Conteudo é o mesmo(passado p/ maiusculo) mas ambos apontam p/ mm conteudo\n", S);
    printf("P: %s <- Conteudo é o mesmo(passado p/ maiusculo) mas ambos apontam p/ mm conteudo\n", P);


    printf("\n\n");


    char *S2 = get_string("Input S2: ");
    char *P2 = malloc(4); // +1 p/ incluir \0(final de string)
    if ( P2 == NULL)
        return 1;   // Caso P2 retorne um endereço Nulo(falha de memoria), encerre o programa p/ evitar travar

    // cmd: strcpy(P2, S2) substitui a rotina abaixo
    for(int i = 0, tam = strlen(S2); i < tam; i++)
       P2[i] = S2[i]; // aGORA FAZEMOS UMA COPIA DE char-to-char, Não somente apontamos, mas criamos 2 strings(char)
       // ou
       // *(P2 + i) = *(S2 + i)
    if (strlen(P2) > 0) // evita travamentos caso endereço da memoria esteja vazio
        P2[0] = toupper(P2[0]); // como P aponta para S, Qdo converte P p/ maiuscula, na realidade converte *S, par


    printf("S: %s\n", S2);
    printf("P: %s <- só conteudo deste foi passado para Maiusculo\n", P2);

    free(P2);   // libera espaço de memoria alocado dinamicamente por malloc

    printf("\n\n");

    // Para exibir debbug de memoria Use:
    // pset3/ponteiros/ $ valgrind ./ponteiro

/*
    printf("\n\n");
    int v[] = {5, 10, 15, 3, 10, 76, 5, 13, 33, 45};
    int * pt;
    int i;

    pt = v;

    for(i = 0; i < 10; i++)
    {
    printf("V[%i] = %i\r\n", i, *pt++);
    }


    printf("\n");

    int *p;
    int n;
    p = &n; // & = endereço -> Ponteiro aponta para endereço de n
    n = 17;
    printf("Endereço de &n: %p \n",(void *)  &n); // imprime endereço que p aponta(formato Hexa)
    printf("Endereço p/ onde p aponta(aponta p/ endereço de n): %p \n", (void *) p);
    printf("Conteúdo de n: %d\n", n);
    printf("Conteúdo de *p: %d\n", *p);

    printf("\n");

    int array[] = {1,2,3,4,5};
    int *result = array; // result pega todos os endereços das celulas(aponta p/ endereços)
    printf("result[3]: %d\n", result[3]);

    printf("\n");
    int i;
    i = 1234;
    p = &i;

    printf ("*p = %d\n", *p);            // imprime conteudo que esta no endereço apontado por p
    printf (" p = %ld\n", (long int) p); // imprime endereço que p aponta(formato long)
    printf (" p = %p\n", (void *) p);    // imprime endereço que p aponta(formato Hexa)
    printf ("&p = %p\n", (void *) &p);   // imprime endereço que p aponta(formato Hexa)
    */
    return 0;
}