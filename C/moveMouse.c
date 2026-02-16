/* CC50-O
 * Curso de Ciência da Computação de Harvard no Brasil
 * by: Treuk, Velislei A
 * 2/Ago/2024
 * Modulo 4
 * Program: MoveMouse-TrayIcon
 *          Este programa move o mouse a cada 3m, para evitar entrada de proteção de tela
 *          Cria menus trayicon com itens que enviam textos ao ClipBoard
 */

#include <windows.h>
#include <shellapi.h>
#include <string.h>
#include <time.h>  // time
#include <stdio.h> // _time

#define WM_SYSICON (WM_USER + 1)
#define ID_TRAY_EXIT 1001
#define ID_COPY_TEXT1 1002
#define ID_COPY_TEXT2 1003
#define ID_COPY_TEXT3 1004
#define ID_COPY_TEXT4 1005
#define ID_COPY_TEXT5 1006
#define ID_COPY_TEXT6 1007

NOTIFYICONDATA nid;
HINSTANCE hInstance;
HWND hWnd;

void CopyTextToClipboard(const char *text)
{
    // Abre o clipboard
    if (OpenClipboard(NULL))
    {
        // Limpa o clipboard
        EmptyClipboard();

        // Cria um buffer de memória global para o texto
        HGLOBAL hMem = GlobalAlloc(GMEM_MOVEABLE, strlen(text) + 1);
        if (hMem)
        {
            // Copia o texto para o buffer de memória
            memcpy(GlobalLock(hMem), text, strlen(text) + 1);
            GlobalUnlock(hMem);

            // Define o buffer de memória como o conteúdo do clipboard
            SetClipboardData(CF_TEXT, hMem);
        }

        // Fecha o clipboard
        CloseClipboard();
    }
}

LRESULT CALLBACK WindowProc(HWND hWnd, UINT uMsg, WPARAM wParam, LPARAM lParam)
{
    switch (uMsg)
    {
    case WM_CREATE:
        // Cria o ícone da bandeja do sistema
        nid.cbSize = sizeof(NOTIFYICONDATA);
        nid.hWnd = hWnd;
        nid.uID = 1;
        nid.uFlags = NIF_ICON | NIF_MESSAGE | NIF_TIP;
        nid.uCallbackMessage = WM_SYSICON;
        nid.hIcon = LoadIcon(NULL, IDI_APPLICATION);
        strcpy(nid.szTip, "mouse3m@Treuk,VA");
        Shell_NotifyIcon(NIM_ADD, &nid);
        return 0;

    case WM_SYSICON:
        if (lParam == WM_RBUTTONUP)
        {
            // Cria um menu de contexto quando o botão direito do mouse é pressionado
            POINT pt;
            GetCursorPos(&pt);
            HMENU hMenu = CreatePopupMenu();
            InsertMenu(hMenu, 0, MF_BYCOMMAND | MF_STRING, ID_COPY_TEXT1, "Email");
            InsertMenu(hMenu, 0, MF_BYCOMMAND | MF_STRING, ID_COPY_TEXT2, "ID");
            InsertMenu(hMenu, 0, MF_BYCOMMAND | MF_STRING, ID_COPY_TEXT3, "Mat");
            InsertMenu(hMenu, 0, MF_BYCOMMAND | MF_STRING, ID_COPY_TEXT4, "Pass");
            InsertMenu(hMenu, 0, MF_BYCOMMAND | MF_STRING, ID_COPY_TEXT5, "idVant");
            InsertMenu(hMenu, 0, MF_BYCOMMAND | MF_STRING, ID_COPY_TEXT6, "passVant");
            InsertMenu(hMenu, 0, MF_BYCOMMAND | MF_STRING, ID_TRAY_EXIT, "Exit");
            SetForegroundWindow(hWnd);
            TrackPopupMenu(hMenu, TPM_BOTTOMALIGN | TPM_LEFTALIGN, pt.x, pt.y, 0, hWnd, NULL);
            DestroyMenu(hMenu);
        }
        return 0;

    case WM_COMMAND:
        switch (LOWORD(wParam))
        {
        case ID_COPY_TEXT1:
            CopyTextToClipboard("velislei.treuk@teltelecom.com.br");
            break;
        case ID_COPY_TEXT2:
            CopyTextToClipboard("0102061118");
            break;
        case ID_COPY_TEXT3:
            CopyTextToClipboard("80969577");
            break;
        case ID_COPY_TEXT4:
            CopyTextToClipboard("SenhaRede");
            break;
        case ID_COPY_TEXT5:
            CopyTextToClipboard("E795999_17");
            break;
        case ID_COPY_TEXT6:
            CopyTextToClipboard("SenhaTemp");
            break;
        case ID_TRAY_EXIT:
            Shell_NotifyIcon(NIM_DELETE, &nid);
            PostQuitMessage(0);
            break;
        }
        return 0;

    case WM_DESTROY:
        Shell_NotifyIcon(NIM_DELETE, &nid);
        PostQuitMessage(0);
        return 0;

    default:
        return DefWindowProc(hWnd, uMsg, wParam, lParam);
    }
}

int APIENTRY WinMain(HINSTANCE hInstance, HINSTANCE hPrevInstance, LPSTR lpCmdLine, int nCmdShow)
{
    const char CLASS_NAME[] = "TrayIconClass";

    POINT p;
    int memX = 0;
    int memY = 0;

    WNDCLASS wc = {0};
    wc.lpfnWndProc = WindowProc;
    wc.hInstance = hInstance;
    wc.lpszClassName = CLASS_NAME;
    wc.hIcon = LoadIcon(NULL, IDI_APPLICATION);

    RegisterClass(&wc);

    // Cria a janela oculta
    hWnd = CreateWindowEx(
        WS_EX_TOOLWINDOW, // Estilos de janela para garantir que a janela não aparece na barra de tarefas
        CLASS_NAME,
        "mouse3m@Treuk,VA",
        WS_POPUP,
        CW_USEDEFAULT, CW_USEDEFAULT, 10, 10, // Tamanho e posição da janela (10,10)
        NULL,
        NULL,
        hInstance,
        NULL);

    if (hWnd == NULL)
    {
        return 0;
    }

    // Define a janela como invisível
    ShowWindow(hWnd, SW_HIDE);
    UpdateWindow(hWnd);

    MSG msg = {0};
    while (GetMessage(&msg, NULL, 0, 0))
    {
        TranslateMessage(&msg);
        DispatchMessage(&msg);
        time_t rawtime;
        struct tm *timeinfo;

        time(&rawtime);
        timeinfo = localtime(&rawtime);

        int current_hour = timeinfo->tm_hour;
        int current_min = timeinfo->tm_min;

        // Obtém a posição do cursor
        if (GetCursorPos(&p))
        {
            // Imprime a posição do cursor
            // printf("Posição atual do mouse: X = %d, Y = %d\n", p.x, p.y);
            // Memory Position(x,y) current of the mouse
            memX = p.x;
            memY = p.y;

            for (int t = 0; t < 60; t += 3) // 0, 3, 6, 9.....51, 54, 57
            {
                if (current_min == t) // se minuto atual for multiplo de 3...move-mouse
                {
                    SetCursorPos(memX + 10, memY + 10); // Move mouse X and Y + 10px
                    // usleep(1000000); // Aguardar 100 milissegundos
                    Sleep(100);               // stay 100 miliSeg in the new position...and return
                    SetCursorPos(memX, memY); // Return position initial
                    // Sleep(180000);            // Wait 3min miliSeg
                }
            }
        }

        // Aguarda 100 milissegundos
        // Sleep(1000);
        //---------------------------------------------------------------------------------------//
    }

    return 0;
}