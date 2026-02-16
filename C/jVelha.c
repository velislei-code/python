/*
 * by: Treuk, Velislei A
 * email: velislei@gmail.com
 * 24/Jul/2024
 * Program: Jogo da Velha, só para descontrair
 */
#include <stdio.h>
#include <stdlib.h> // rand
#include <conio.h>  // getch
#include <stdbool.h>

#define N 3
#define Computer -1
#define Free 0
#define Player 1
#define inCheck 2
#define finality -2
#define maxMove 9
#define ComputerWin -3
#define PlayerWin 3

bool debbug = false;     // My rotine of debbug to build
int iL[N], iC[N], iX[N]; // My rotine of print_debbug to build

char cPlayer = 'X';
char cComputer = 'O';

// Array for show table ao player
char cJv[N][N] = {{' ', ' ', ' '},
                  {' ', ' ', ' '},
                  {' ', ' ', ' '}};

// Array of control internal
int iJv[N][N] = {{Free, Free, Free},
                 {Free, Free, Free},
                 {Free, Free, Free}};

void clrscr(void);

void sum_debbug(void)
{
    for (int i = 0; i < N; i++)
        iL[i] = iJv[i][0] + iJv[i][1] + iJv[i][2]; // Sum j in rows

    for (int j = 0; j < N; j++)
        iC[j] = iJv[0][j] + iJv[1][j] + iJv[2][j]; // Sum i in Cols

    iX[0] = iJv[0][0] + iJv[1][1] + iJv[2][2]; // Sum i/j in X
    iX[1] = iJv[0][2] + iJv[1][1] + iJv[2][0];
}

int play_available(void)
{
    int iNum = 0;
    // search number of Movements still available
    for (int i = 0; i < N; i++)
        for (int j = 0; j < N; j++)
            if (iJv[i][j] == 0)
                iNum++; // Number movements still available

    return iNum;
}

void render(void)
{
    if (debbug)
        sum_debbug();

    printf("\n   A   B   C \n");
    for (int i = 0; i < N; i++)
    {
        if (debbug) // My rotine of debbug to build)
        {
            printf("%i  %c | %c | %c            | %i | %i | %i |    ->  sum:(%i)\n", i, cJv[i][0], cJv[i][1], cJv[i][2], iJv[i][0], iJv[i][1], iJv[i][2], iL[i]);

            if (i < 2)
                printf("  -----------           -------------\n");
        }
        else
        {
            printf("%i  %c | %c | %c \n", i, cJv[i][0], cJv[i][1], cJv[i][2]);
            if (i < 2)
                printf("  -----------\n");
        }
    }

    if (debbug) // My rotine of debbug to build)
    {
        printf("\nP: Prepare         (%i)    (%i) (%i) (%i)   (%i)\n", iX[1], iC[0], iC[1], iC[2], iX[0]);
        printf("D: Defense\n");
        printf("F: Finality\n");
    }
    printf("\n");

    return;
}

bool save_move(int i, int j, char cXorO, char cOrigin)
{
    // Save address[i][j] of the move
    if (iJv[i][j] == Free) // check If positions is free...
    {
        if (debbug)              // My rotine debbug to build
            cJv[i][j] = cOrigin; // only debbug, Origin of the call function, Completed cell empty(= 0)
        else
            cJv[i][j] = cXorO; // For show in the table Who is execute moviments, Computer = 'O', Player = 'X'
        iJv[i][j] = Computer;  // Value ID of who execute moviments(Computer = -1, Free = 0, Player = 1)

        return true; // if sucess...true, else...false
    }
    return false;
}

bool game_over(void)
{
    /*
           1 | 1 | 1 <- if: 1+1+1 = 3, Player winner
          -----------
          -1 |-1 |-1 <- if: (-1)+(-1)+(-1) = -3, Computer winner
          -----------
           0 | 0 | 0 <- 0 positions free

           if all positons ocupped, iResultWin = 0 -> Do not there winner
    */

    if (debbug)
        printf("debbug->game_over()\n");

    int iResultWin = 0; // if result = -3, 3 or 9...game_over

    if (play_available() < 1) // Max move play exceed, rest 0
        iResultWin = maxMove; // result info there ocurred max move...finality

    int iReferenceWin = ComputerWin; // Start search Computer winner
    for (int opcaoWin = 0; opcaoWin < 2; opcaoWin++)
    {
        if (iJv[0][0] + iJv[1][1] + iJv[2][2] == iReferenceWin)
            iResultWin = iReferenceWin;
        if (iJv[2][0] + iJv[1][1] + iJv[0][2] == iReferenceWin)
            iResultWin = iReferenceWin;

        for (int i = 0; i < N; i++)
            if (iJv[i][0] + iJv[i][1] + iJv[i][2] == iReferenceWin)
                iResultWin = iReferenceWin;

        for (int j = 0; j < N; j++)
            if (iJv[0][j] + iJv[1][j] + iJv[2][j] == iReferenceWin)
                iResultWin = iReferenceWin;

        iReferenceWin = PlayerWin; // Change for search Player winner
    }

    if (iResultWin != 0)
    {
        printf("  Game Over!\n");
        switch (iResultWin)
        {
        case ComputerWin:
            printf("  You  lost!\n\n");
            break;
        case PlayerWin:
            printf(" You  winner!\n\n");
            break;
        case 9:
            printf("Do not there is winner!\n\n");
            break;
        default:
            printf("Do not there is winner!\n\n");
            break;
        }
        if (debbug)
            printf("debbug->game_over(%i)\n", iResultWin);

        return true; // Exit program
    }
    if (debbug)
        printf("debbug->game_over(%i)\n", iResultWin);

    return false;
}

bool prepare_move(void)
{
    /*
        if positions(z), belove, is free, computer complete(set -1)
        else if positions(y), belove, is free, complete(in the mode random betwem the 4)

           X |   | X            z |   | z               | y |
          -----------          -----------           -----------
             |   |                | z |               y |   | y
          -----------          -----------           -----------
           W |   | W            z |   | z               | y |
         Positions Key        Positions Key        Positions random
            CROSS              Priveligied
    */

    if (debbug) // My rotine of debbug to build)
        printf("prepare_move()...\n");

    int xa = 0;
    int xb = 0;
    int wa = 2;
    int wb = 2;
    // if position(cross) is free(X -> W, W -> X)
    if (iJv[xa][xb] == Player) // Computer complete positions cross(is free(X -> W, W -> X))
    {
        return save_move(wa, wb, cComputer, 'P'); // Save address[i][j] of the move
    }

    xa = 2;
    xb = 2;
    wa = 0;
    wb = 0;
    if (iJv[xa][xb] == Player) // Computer complete positions cross(is free(X -> W, W -> X))
    {
        return save_move(wa, wb, cComputer, 'P'); // Save address[i][j] of the move
    }

    xa = 0;
    xb = 2;
    wa = 2;
    wb = 0;
    if (iJv[xa][xb] == Player) // Computer complete positions cross(is free(X -> W, W -> X))
    {
        return save_move(wa, wb, cComputer, 'P'); // Save address[i][j] of the move
    }

    xa = 2;
    xb = 0;
    wa = 0;
    wb = 2;
    if (iJv[xa][xb] == Player) // Computer complete positions cross(is free(X -> W, W -> X))
    {
        return save_move(wa, wb, cComputer, 'P'); // Save address[i][j] of the move
    }

    // if position(privelegied) is free
    for (int x = 0; x < N; x++)
    {
        return save_move(x, x, cComputer, 'P'); // Save address[i][j] of the move
    }
    if (iJv[0][2] == Free) // if center is free...set Computer(move play computer)
    {
        return save_move(0, 2, cComputer, 'P'); // Save address[i][j] of the move
    }
    if (iJv[2][0] == Free) // if center is free...set Computer(move play computer)
    {
        return save_move(2, 0, cComputer, 'P'); // Save address[i][j] of the move
    }
    // Move play type: Random, if conditions, above, do not satisfied...execute move random
    if (play_available() > 0) // if there positions free(> 0)
    {
        int rdmI;
        int rdmJ;
        do
        {                      // Search positions free
            rdmI = rand() % N; // Random 0a3
            rdmJ = rand() % N;
        } while (iJv[rdmI][rdmJ] != Free);

        return save_move(rdmI, rdmJ, cComputer, 'P'); // Save address[i][j] of the move
    }
    return false;
}

bool finality_move(void)
{
    /*
        0 equal the position Free
        1 equal the position ocuped for Player
       -1 equal the position ocuped for Computer

        inCheck
           1 | 1 | 0
          -----------
          -1 |-1 | 0    <- if: -1 + -1 + 0 = -2, Player inCheck! Computer complete with: -1 | -1 | -1 -> Computer Winner!
          -----------
           0 | 0 | 0    <- Zero, positions free
    */
    if (debbug) // My rotine debbug to build
        printf("debbug->finality_move()...\n");

    if (iJv[0][0] + iJv[1][1] + iJv[2][2] == finality) //  (-1)+(-1)+0 = -2
    {
        for (int i = 0; i < N; i++) // Scan rows(lines)
        {
            if (save_move(i, i, cComputer, 'F')) // Save address[i][j] of the move
                return true;
        }
    }
    if (iJv[2][0] + iJv[1][1] + iJv[0][2] == finality) // finality = -2
    {
        // Search for position Free...save
        if (save_move(2, 0, cComputer, 'F')) // Save address[i][j] of the move A2
            return true;

        if (save_move(1, 1, cComputer, 'F')) // Save address[i][j] of the move B1(Center)
            return true;

        if (save_move(0, 2, cComputer, 'F')) // Save address[i][j] of the move C0
            return true;
    }

    for (int i = 0; i < N; i++) // Scan lines
    {
        if (iJv[i][0] + iJv[i][1] + iJv[i][2] == finality) // if sum(rows) equal 2...move of finality
        {
            for (int j = 0; j < N; j++)
            {
                if (save_move(i, j, cComputer, 'F')) // Save address[i][j] of the move
                    return true;
            }
        }
    }
    for (int j = 0; j < N; j++) // Scan lines
    {
        if (iJv[0][j] + iJv[1][j] + iJv[2][j] == finality) // if sum(cols) equal 2...move of finality
        {
            for (int i = 0; i < N; i++)
            {
                if (save_move(i, j, cComputer, 'F')) // Save address[i][j] of the move
                    return true;
            }
        }
    }
    return false;
}

bool defense_move(void)
{
    /*
        0 equal the position Free
        1 equal the position ocuped for Player
       -1 equal the position ocuped for Computer

        inCheck
           1 | 1 | 0    <- if: 1 + 1 + 0 = 2, Computer inCheck! Computer complete with: 1 | 1 | -1 -> Block move Player
          -----------
          -1 |-1 | 0    <- if: -1 + -1 + 0 = -2, Player inCheck! Computer complete with: -1 | -1 | -1 -> Computer Winner!
          -----------
           0 | 0 | 0    <- Zero, positions free
    */
    if (debbug) // My rotine debbug to build
        printf("defense_move()\n");

    if (iJv[0][0] + iJv[1][1] + iJv[2][2] == inCheck) //  (-1)+(-1)+0 = abs(-2) -> 2
    {
        for (int i = 0; i < N; i++) // Scan lines
        {
            if (save_move(i, i, cComputer, 'D')) // Save address[i][j] of the move
                return true;
        }
    }
    if (iJv[2][0] + iJv[1][1] + iJv[0][2] == inCheck)
    {
        if (save_move(2, 0, cComputer, 'D')) // Save address[i][j] of the move
            return true;

        if (save_move(1, 1, cComputer, 'D')) // Save address[i][j] of the move
            return true;

        if (save_move(0, 2, cComputer, 'D')) // Save address[i][j] of the move
            return true;
    }

    for (int i = 0; i < N; i++) // Scan lines
    {
        if (iJv[i][0] + iJv[i][1] + iJv[i][2] == inCheck) // if sum equal 2...
        {
            for (int j = 0; j < N; j++)
            {
                if (save_move(i, j, cComputer, 'D')) // Save address[i][j] of the move
                    return true;
            }
        }
    }
    for (int j = 0; j < N; j++) // Scan lines
    {
        if (iJv[0][j] + iJv[1][j] + iJv[2][j] == inCheck) // if sum equal 2...
        {
            for (int i = 0; i < N; i++)
            {
                if (save_move(i, j, cComputer, 'D')) // Save address[i][j] of the move
                    return true;
            }
        }
    }
    return false;
}

int charToInt(char cCell)
{
    switch (cCell) // convet input user char to int
    {
    case 'a':
        return 0;
        break;
    case 'b':
        return 1;
        break;
    case 'c':
        return 2;
        break;
    case 'A':
        return 0;
        break;
    case 'B':
        return 1;
        break;
    case 'C':
        return 2;
        break;
    case '0':
        return 0;
        break;
    case '1':
        return 1;
        break;
    case '2':
        return 2;
        break;
    default:
        return 0;
        break;
    }
}

int main(void)
{
    render();
    char cCell[N];
    int i, j = 0;

    do
    {
        do
        {
            // cCell = getc("Informe a Coluna(A, B ou C): ");
            printf("Informe a Celula(A, B ou C, 0a2): ");
            for (int c = 0; c < 2; c++)
            {
                cCell[c] = getch();
                printf("%c", cCell[c]);
            }
            printf("\n");
        } while (cCell[0] != 'a' &&
                 cCell[0] != 'A' &&
                 cCell[0] != 'b' &&
                 cCell[0] != 'B' &&
                 cCell[0] != 'c' &&
                 cCell[0] != 'C' &&
                 cCell[0] != 's' &&
                 cCell[0] != 'S' &&
                 cCell[1] != '0' &&
                 cCell[1] != '1' &&
                 cCell[1] != '2');

        if (cCell[0] == 's' || cCell[0] == 'S')
            break;

        i = charToInt(cCell[1]); // convert input char of user for int
        j = charToInt(cCell[0]); // convert input char of user for int

        // Verify se posição esta vaga
        if (iJv[i][j] == Free)
        {
            // if position is free...
            cJv[i][j] = cPlayer;
            iJv[i][j] = Player; // Complete with value of Player(1)
            if (debbug)         // My rotine debbug to build
                printf("[%i], [%i] = %c = %i \n", i, j, cJv[i][j], iJv[i][j]);

            render();

            if (finality_move())
            {
                render();
                if (game_over())
                    return 0; // Exit program
            }
            else
            {
                if (!defense_move()) // Play of defense of the computer
                    prepare_move();  // Case do not move play of defense...run move play_attack
            }
            render();

            if (game_over())
                return 0; // Exit program
        } //  if (iJv[i][j] == Free)
        else
        { // position is ocuped
            printf("Position[%c %i]: %i there is ocupped!\n", cCell[0], i, iJv[i][j]);
        }

    } while (cCell[0] != 's' && cCell[0] != 'S'); // Exit

    return 0; // Exit program
}
