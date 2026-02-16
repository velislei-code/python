#include <stdio.h>
#include <math.h> // round()
#include <stdbool.h>
#include <stdlib.h> // malloc()

#include "helpers.h"

bool debbug2 = false; // My rotine debbug to build

// Convert image to grayscale
void grayscale(int height, int width, RGBTRIPLE image[height][width])
{
    // Error, ajustar aproximacao
    // To convert the image to grayscale, calculate the average value of RGB and apply it to R, G and B

    for (int h = 0; h < height; h++) {
        for (int w = 0; w < width; w++) {
            // Calc the averange Md = R+G+B / 3
            float sum = image[h][w].rgbtBlue + image[h][w].rgbtGreen + image[h][w].rgbtRed;
            float mediaRGB = sum / 3;

            if(2)
                printf("mediaRGB = %0.3f -> %0.1f\n",  mediaRGB,  round(mediaRGB));

            image[h][w].rgbtBlue = round(mediaRGB);
            image[h][w].rgbtGreen = round(mediaRGB);
            image[h][w].rgbtRed = round(mediaRGB);
        }
    }

    return;
}

// Convert image to sepia
void sepia(int height, int width, RGBTRIPLE image[height][width])
{
    /*
        Algoritmo sugerido pelo curso cs50:
        sepiaRed = .393 * originalRed + .769 * originalGreen + .189 * originalBlue
        sepiaGreen = .349 * originalRed + .686 * originalGreen + .168 * originalBlue
        sepiaBlue = 0,272 * originalRed + 0,534 *  originalGreen + 0,131 * originalBlue
    */
   float sepiaRed = 0;
   float sepiaGreen = 0;
   float sepiaBlue = 0;

   for (int h = 0; h < height; h++) {
        for (int w = 0; w < width; w++) {

            sepiaRed = (0.393 * image[h][w].rgbtRed) + (0.769 * image[h][w].rgbtGreen) + (0.189 * image[h][w].rgbtBlue);
            sepiaGreen = (0.349 * image[h][w].rgbtRed) + (0.686 * image[h][w].rgbtGreen) + (0.168 * image[h][w].rgbtBlue);
            sepiaBlue = (0.272 * image[h][w].rgbtRed) + (0.534 * image[h][w].rgbtGreen) + (0.131 * image[h][w].rgbtBlue);

            // Limits
            if(sepiaRed < 0){ sepiaRed = 0; }
            if(sepiaGreen < 0){ sepiaGreen = 0; }
            if(sepiaBlue < 0){ sepiaBlue = 0; }

            if(sepiaRed > 255){ sepiaRed = 255; }
            if(sepiaGreen > 255){ sepiaGreen = 255; }
            if(sepiaBlue > 255){ sepiaBlue = 255; }

            if(debbug2)
                printf("R: %0.3f -> %0.1f, G: %0.3f -> %0.1f, B: %0.3f -> %0.1f\n",
                        sepiaRed, round(sepiaRed),
                        sepiaGreen, round(sepiaGreen),
                        sepiaBlue, round(sepiaBlue) );

            // Repassa valores
            image[h][w].rgbtRed = round(sepiaRed);
            image[h][w].rgbtGreen = round(sepiaGreen);
            image[h][w].rgbtBlue = round(sepiaBlue);

        }
    }

    return;
}

// Reflect image horizontally
void reflect(int height, int width, RGBTRIPLE image[height][width])
{
    height = 1;
    width = 2;

    int iImgTst1[2][3] = {{255,0,0}, {0,0,255}};
    /*
                       int iLst4[9][5] = {{1, 0, 2, 3, 4}, {0, 2, 1, 3, 4}, {1, 0, 2, 3, 4},
                       {1, 2, 0, 3, 4}, {2, 0, 1, 3, 4}, {2, 1, 0, 3, 4},
                       {2, 0, 1, 3, 4}, {3, 2, 1, 0, 4}, {4, 3, 1, 0, 2}}; */
    for (int h = 0; h < height; h++) {
        for (int w = 0; w < width; w++) {
        // first row: (255, 0, 0), (0, 0, 255)
        image[h][w].rgbtRed = iImgTst1[h][h];
        image[h][w].rgbtGreen = iImgTst1[h][h+1];
        image[h][w].rgbtBlue = iImgTst1[h][h+2];
        }
    }





    // Declared Struct(RGBTRIPLE) define inside file: bmp.h
    // Allocate memory for image
    RGBTRIPLE(*memImage)[width] = calloc(height, width * sizeof(RGBTRIPLE));

    for (int h = 0; h < height; h++) {

        int wInv = width-1;
        for (int w = 0; w < width; w++) {



                printf("w[%i]<>wInv[%i] -> ", w, wInv);
                printf("In: R%i, G%i, B%i -> ", image[h][w].rgbtRed, image[h][w].rgbtGreen, image[h][w].rgbtBlue);

                // Inverte os pixels, invertendo a imagem, criando um reflexo dela
                // Move pixels 0, 1, 2 .............. 597, 598, 599
                //             |  |  |                 ^    ^    ^
                //             |  |  '------->>--------'    |    |
                //             |  '---------->>-------------'    |
                //             '--------> Move to  >-------------'

                // Invert pixels
                /*
                if(w < width/2) // 0 a 300
                {
                */
                    // Como, apo´s o centro, todos os pixels da esquerda foram substituidos(invertidos)
                    // Precisamos memorizar os pixels 300 a 600 para ter dados a inverter
                    // Save pixels current, before of the invert pixels
                    memImage[h][wInv].rgbtRed = image[h][wInv].rgbtRed;
                    memImage[h][wInv].rgbtGreen = image[h][wInv].rgbtGreen;
                    memImage[h][wInv].rgbtBlue = image[h][wInv].rgbtBlue;

                    // Copia pixels de foma invertida, joga pixels 0 -> 599, 1 -> 598, 2 -> 597, ....
                    image[h][wInv].rgbtRed = image[h][w].rgbtRed;
                    image[h][wInv].rgbtGreen = image[h][w].rgbtGreen;
                    image[h][wInv].rgbtBlue = image[h][w].rgbtBlue;

                    printf("Out: R%i, G%i, B%i\n", image[h][wInv].rgbtRed, image[h][wInv].rgbtGreen, image[h][wInv].rgbtBlue);

                /*
                }
                else // 300 a 600
                {
                    image[h][wInv].rgbtRed = memImage[h][w].rgbtRed;
                    image[h][wInv].rgbtGreen = memImage[h][w].rgbtGreen;
                    image[h][wInv].rgbtBlue = memImage[h][w].rgbtBlue;
                }
                */
                if(debbug2)
                    printf("->wInvd(i): %i\n", wInv);

                wInv--; // Count 599 a 301(Metade superior)

        }
    }

    return;
}

// Blur image
void blur(int height, int width, RGBTRIPLE image[height][width])
{
   float sumRed = 0.0;
   float sumGreen = 0.0;
   float sumBlue = 0.0;
   float mediaRed = 0.0;
   float mediaGreen = 0.0;
   float mediaBlue = 0.0;

    for (int h = 0; h < height; h++) {
        for (int w = 0; w < width; w++) {

            // h: 0 a 399, h1: 1 a 400, h2: 2 a 401
            // w: 0 a 599, w1: 1 a 600, w2: 2 a 601
            int h1 = h + 1; int h2 = h + 2;
            int w1 = w + 1; int w2 = w + 2;

            // Limits
            if(h1 >= height){ h1 = height-1; } // 1 a 399
            if(h2 >= height){ h2 = height-1; } // 2 a 399
            if(w1 >= width){ w1 = width-1; } // 1 a 599
            if(w2 >= width){ w2 = width-1; } // 2 a 599

            if(h == height - 1)
            {
                /* In the array below...
                    | 01 02 03 04 |
                    | 05 06 07 08 | case border...15
                    | 09 10 11 12 | h (h == height-1)
                    | 13 14 15 16 | h1
                             |      get avarange of -> | 10 11 12 |  -> | h  /w h  /w+1 h  /w+2 |
                             '---------- 15 ---------> | 14 15 16 |     | h+1/w h+1/w+1 h+1/w+2 ||
                */
                sumRed =  image[h][w].rgbtRed + image[h][w1].rgbtRed + image[h][w2].rgbtRed
                            + image[h1][w].rgbtRed + image[h1][w1].rgbtRed + image[h1][w2].rgbtRed;
                mediaRed = sumRed / 6;

                sumGreen = image[h][w].rgbtGreen + image[h][w1].rgbtGreen + image[h][w2].rgbtGreen
                               + image[h1][w].rgbtGreen + image[h1][w1].rgbtGreen + image[h1][w2].rgbtGreen;
                mediaGreen = sumGreen / 6;

                sumBlue = image[h][w].rgbtBlue + image[h][w1].rgbtBlue + image[h][w2].rgbtBlue
                            + image[h1][w].rgbtBlue + image[h1][w1].rgbtBlue + image[h1][w2].rgbtBlue;
                mediaBlue = sumBlue / 6;

            }
            else
            {

               /* In the array below...
                    | 01 02 03 04 |  get avarange of -> | 01 02 03 |
                    | 05 06 07 08 |                     | 05 06 07 |      | h  /w h  /w+1 h  /w+2 |
                    | 09 10 11 12 |                     | 09 10 11 |  ->  | h+1/w h+1/w+1 h+1/w+2 |
                    | 13 14 15 16 |                                       | h+2/w h+2/w+1 h+2/w+2 |
                */
                sumRed =  image[h][w].rgbtRed + image[h][w1].rgbtRed + image[h][w2].rgbtRed
                            + image[h1][w].rgbtRed + image[h1][w1].rgbtRed + image[h1][w2].rgbtRed
                            + image[h2][w].rgbtRed + image[h2][w1].rgbtRed + image[h2][w2].rgbtRed;
                mediaRed = sumRed / 9;

                sumGreen = image[h][w].rgbtGreen + image[h][w1].rgbtGreen + image[h][w2].rgbtGreen
                             + image[h1][w].rgbtGreen + image[h1][w1].rgbtGreen + image[h1][w2].rgbtGreen
                             + image[h2][w].rgbtGreen + image[h2][w1].rgbtGreen + image[h2][w2].rgbtGreen;
                mediaGreen = sumGreen / 9;

                sumBlue = image[h][w].rgbtBlue + image[h][w1].rgbtBlue + image[h][w2].rgbtBlue
                        + image[h1][w].rgbtBlue + image[h1][w1].rgbtBlue + image[h1][w2].rgbtBlue
                        + image[h2][w].rgbtBlue + image[h2][w1].rgbtBlue + image[h2][w2].rgbtBlue;
                mediaBlue = sumBlue / 9;
            }

            if(debbug2)
                printf("R: %0.3f -> %0.1f, G: %0.3f -> %0.1f, B: %0.3f -> %0.1f\n",
                    mediaRed, round(mediaRed),
                    mediaGreen, round(mediaGreen),
                    mediaBlue, round(mediaBlue) );

            image[h][w].rgbtRed = round(mediaRed);
            image[h][w].rgbtGreen = round(mediaGreen);
            image[h][w].rgbtBlue = round(mediaBlue);
        }
     }

    return;
}

/*

void reflect_metade(int height, int width, RGBTRIPLE image[height][width])
{
   for (int h = 0; h < height; h++) {

        int wInv = width-1;
        for (int w = 0; w < width; w++) {


                // Inverte os pixels, invertendo a imagem, criando um reflexo dela
                // Move pixels 0, 1, 2 .............. 597, 598, 599
                //             |  |  |                 ^    ^    ^
                //             |  |  '------->>--------'    |    |
                //             |  '---------->>-------------'    |
                //             '--------> Move to  >-------------'

                // Invert pixels
                image[h][wInv].rgbtRed = image[h][w].rgbtRed;
                image[h][wInv].rgbtGreen = image[h][w].rgbtGreen;
                image[h][wInv].rgbtBlue = image[h][w].rgbtBlue;


                if(debbug2)
                    printf("->wInvd(i): %i\n", wInv);

                wInv--; // Count 599 a 301(Metade superior)

        }
    }

    return;
}


// Reflect(lens_distorting) image horizontally
void lens_distorting(int height, int width, RGBTRIPLE image[height][width])
{
    // Create reflect(distorting) of the image,
    // get pixels pars for the 300 pixels begins
    // get pixels inpars for the 30 pixels ending
    for (int h = 0; h < height; h++) {

        int wInc = 0;
        int wInv = width;
        for (int w = 0; w < width; w++) {
            if(w % 2){ // Pega os pixels pares
                image[h][wInc].rgbtRed = image[h][w].rgbtRed;
                image[h][wInc].rgbtGreen = image[h][w].rgbtGreen;
                image[h][wInc].rgbtBlue = image[h][w].rgbtBlue;

                if(debbug2)
                    printf("wInc(i): %i <-", wInc);

                wInc++; // Count 0 a 300(metade inferior)
            }
            else
            {   // Mantem os Pares na lado esquerdo
                // Transfere os pixels impares(Cria reflexo no centro) - para direita
                // Move pixels 0, 1, 2, 3, 4, 5 ....... | ....... 597, 598, 599
                //             |  |  |  |  |  |         |          ^    ^    ^
                //             0  |  2  |  4  '-------> | >--------'    |    |
                //                |     '-------------> | >-------------'    |
                //                '------------->  Move | to  >--------------'

                image[h][wInv].rgbtRed = image[h][w].rgbtRed;
                image[h][wInv].rgbtGreen = image[h][w].rgbtGreen;
                image[h][wInv].rgbtBlue = image[h][w].rgbtBlue;

                if(debbug2)
                    printf("->wInvd(i): %i\n", wInv);

                wInv--; // Count 599 a 301(Metade superior)
            }
        }
    }

    return;
}

 */