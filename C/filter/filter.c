

#include <getopt.h> // optind, getopt(...)
#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>

#include "helpers.h"
/* Struct declared inside of the file bmp.h:
                    - BITMAPFILEHEADER;
                    - BITMAPINFOHEADER;
                    - RGBTRIPLE.
*/
bool debbug = false; // My rotine debbug to build

int main(int argc, char *argv[])
{
    // Define allowable filters
    char *filters = "bgrs";

    // Get filter flag and check validity
    char filter = getopt(argc, argv, filters);

    if(debbug) // My rotine debbug to build
    {
        printf("\n<getopt.h> -> getopt(...)\n");
        printf("filter = getopt(argc, argv[], filters) return %i\n", filter);
        printf("........ getopt(%i, [%s %s %s %s], %s)\n", argc, argv[0], argv[1], argv[2], argv[2], filters);
        printf("........ optind = %i\n", optind);
        printf("........ Use: ./filter -g<b, g, r, s> images/in_name.bmp images/out_name.bmp\n");
    }

    if (filter == '?')
    {
        printf("Invalid filter.\n");
        return 1;
    }

    // Ensure only one filter
    if (getopt(argc, argv, filters) != -1)
    {
        printf("Only one filter allowed.\n");
        return 2;
    }

    // Ensure proper usage
    if (argc != optind + 2)
    {
        printf("Usage: ./filter [flag] infile outfile\n");
        return 3;
    }

    // Remember filenames
    char *infile = argv[optind];      // get name file input_file.bmp of argv[2]
    char *outfile = argv[optind + 1]; // get name file output_file.bmp of argv[3]
                                      // argv[0] = ./filter
                                      // argv[1] = -g<flag: b, g, r, s>
                                      // argv[2] = name_input.bmp
                                      // argv[3] = name_output.bmp

    // Open input file
    FILE *inptr = fopen(infile, "r");
    if (inptr == NULL) // Error trying to open the file
    {
        printf("Could not open %s.\n", infile);
        return 4;
    }

    // Open output file
    FILE *outptr = fopen(outfile, "w");
    if (outptr == NULL) // Error trying to create the file
    {
        fclose(inptr);
        printf("Could not create %s.\n", outfile);
        return 5;
    }

    // Read infile's BITMAPFILEHEADER(Struct define inside file: bmp.h)
    BITMAPFILEHEADER bf;
    fread(&bf, sizeof(BITMAPFILEHEADER), 1, inptr);

    // Read infile's BITMAPINFOHEADER(Struct define inside file: bmp.h)
    BITMAPINFOHEADER bi;
    fread(&bi, sizeof(BITMAPINFOHEADER), 1, inptr);

    // Ensure infile is (likely) a 24-bit uncompressed BMP 4.0
    // Garantir que o arquivo infile é (provavelmente) um BMP 4.0 descompactado de 24 bits
    if (bf.bfType != 0x4d42 || bf.bfOffBits != 54 || bi.biSize != 40 ||
        bi.biBitCount != 24 || bi.biCompression != 0)
    {
        fclose(outptr);
        fclose(inptr);
        printf("Unsupported file format.\n");
        return 6;
    }

    // Get image's dimensions
    int height = abs(bi.biHeight);
    int width = bi.biWidth;

    // Declared Struct(RGBTRIPLE) define inside file: bmp.h
    // Allocate memory for image
    RGBTRIPLE(*image)[width] = calloc(height, width * sizeof(RGBTRIPLE));
    if (image == NULL)
    {
        printf("Not enough memory to store image.\n");
        fclose(outptr);
        fclose(inptr);
        return 7;
    }

    // Determine padding(preenchimento) for scanlines
    int padding = (4 - (width * sizeof(RGBTRIPLE)) % 4) % 4;

    // Iterate over infile's scanlines
    for (int i = 0; i < height; i++)
    {
        // Read row into pixel array
        fread(image[i], sizeof(RGBTRIPLE), width, inptr);

        // Skip over padding(pular (sobre) preenchimento)
        fseek(inptr, padding, SEEK_CUR);
    }

    // Filter image - aplication of filter in the image
    switch (filter)
    {
        // Blur
        case 'b':
            blur(height, width, image); // <- function define inside helpers.c
            break;

        // Grayscale
        case 'g':
            grayscale(height, width, image); // <- function define inside helpers.c
            break;

        // Reflection
        case 'r':
            reflect(height, width, image); // <- function define inside helpers.c
            break;

        // Sepia
        case 's':
            sepia(height, width, image); // <- function define inside helpers.c
            break;
    }

    // Write outfile's BITMAPFILEHEADER(struct defina inside of: bmp.h)
    fwrite(&bf, sizeof(BITMAPFILEHEADER), 1, outptr);

    // Write outfile's BITMAPINFOHEADER(struct defina inside of: bmp.h)
    fwrite(&bi, sizeof(BITMAPINFOHEADER), 1, outptr);

    // Write new pixels to outfile
    for (int i = 0; i < height; i++)
    {
        // Write row to outfile
        fwrite(image[i], sizeof(RGBTRIPLE), width, outptr);

        // Hex(0x 7 3 1 c e 5 3 e 8 8 5 0)

        // Write padding at end of row
        for (int k = 0; k < padding; k++)
        {
            fputc(0x00, outptr);
        }

    }

        if(debbug) // My rotine debbug to build
        {
           // Printting value of each pixel
            for (int h = 0; h < height; h++) {
                for (int w = 0; w < width; w++) {
                    printf("Pixel[%d][%d]: R%d, G%d, B%d\n",
                            h, w,
                            image[h][w].rgbtRed,
                            image[h][w].rgbtGreen,
                            image[h][w].rgbtBlue );
                }
                //printf("image[%i]: %p\n", h, image[h]);
            }
            printf("height: %i,  width: %i\n", height, width);
        }

    // Free memory for image
    free(image);

    // Close files
    fclose(inptr);
    fclose(outptr);
    return 0;
}