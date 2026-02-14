function Loop(){ 

                const pipePositionLeft = constPipe.offsetLeft;  /* Pega posição Left de Pipe(tubo) */
                // console.log(pipePositionLeft); /* Cmd.p/ Desenvolvimento: Mostra(Chrome->Inspecionar->Console) valores de Left do Pipe(tubo) */

                /*
                    +: converter dados(pixel string) p/ numero 
                    replace: troca 'px' p/ ''(vazio)
                */
                const marioPositionBottom = +window.getComputedStyle(constMario).bottom.replace('px','');    /* Pega posição Botton(altura do pulo) do mario */
                //console.log(marioPositionBottom);  /* Cmd.p/ Desenvolvimento: Mostra(Chrome->Inspecionar->Console) valores de Botton(pulo) do mario */

                //**********************************************************************************************************
                 //checkColisao();
                //******** Ini - Trata das Colisões **********************************************************************************
                //  GAME-OVER...Se mario encostar no Pipe(tubo) 
                //    Se Pos(Left) Tubo  <= 150px(tb é a posição do mario...encostou no tubo)
                //    Se Pos(Left) Tubo > 0px(Tela vai de 300px->0px, se é maior que Zero pq Tubo ainda 
                //        esta em-baixo do mario em caso de salto), Para Tubo por colisão por cima 
                //       - Não haveria como o Mario chocar com tubo na 
                //        condição 150px após ele já ter passado, então verificamos a pos=zero(px) 
                //    Se Pos(Botton-alt/salto) Mario < 105px(Saltou baixo, encostou/bateu pés no Pipe)
                
              
                    
                    if(pipePositionLeft <= 150 && pipePositionLeft > 0 && marioPositionBottom < 110 ){    /* 150px limite de tela, definido em class=.pipe de style.css */

                                //---------------------- Tratar de colisão a Direita de mario com o Tubo ---------------------//



                                //---------------------- Tratar de Mario em cima do Tubo -------------------------------------//





                                //--------------------------------------------------------------------------------------------//
                
                                //**** Ini - Tratamento de colisão na posição Left-horizontal, INTERROMPE MOVIMENTO DO TUBO *************************************
                                //constPipe.style.animation = 'none';           // Encerra animação do Pipe 
                                // constPipe.style.animationPlayState = 'paused';  // Pausa animação do Pipe 
                                        
                                //  Pega posiçao do mario e Fixa Pipe(tubo) nesta posição, 
                                //    ...Mario bate no Pipe(tubo). ..                                   */                           
                                constPipe.style.left = `${pipePositionLeft}px`;     // Note q esta entre `` 

                                //------ Ini - Tratamento de colisão na posição Bottom-Vertical , INTERROMPE MOVIMENTO DO MARIO ---------------------------//
                                // constMario.style.animation = 'none';         // Encerra animação do Pipe 
                                constMario.style.animationPlayState = 'paused';
                                bCimaTubo=true;

                                //  Pega posiçao do mario e Fixa MARIO nesta posição, 
                                //    ...Mario fica encima do Pipe(tubo)...                                                             
                                constMario.style.bottom = `${marioPositionBottom}px`;     // Note q esta entre `` 
                                if(marioPositionBottom>50){ 
                                        constMario.style.bottom = '100px';  
                                }     // Ajusta p/ cima do Tubo...pra não ficar no meio do caminho 


                                if(marioPositionBottom < 50){   
                            
                                    
                                        //**** carrega Img de game-Over *************************************
                                        
                                        constMario.src="./images/Mario_colide.png"; // após colisão...Carrega imagem de game-over 
                                        constMario.style.width = '150px';           // ou...`${85}px`;         // Ajusta tamanho da imagem 
                                        constMario.style.height = '150px';          // ou...`${105}px`;     
                                        constMario.style.marginLeft = '1px auto';   // ou...`${0}px auto`;      

                                        constGameOver.src="./images/Game_over.png"; // carrega game-over 
                                        constGameOver.style.opacity="1.0";
                                    
                                        
                                        //**** Encerra exec.de Loop ***********************                                
                                        // console.log('constLoop');        // Cmd.p/ Desenvolvimento: Mostra(Chrome->Inspecionar->Console->Loop em exec.) 
                                        clearInterval(constLoop);           // Encerra exec.do loop, pra não ficar executando após colisão(game-over)
                                
                            } // if(marioPositionBottom < 110){ 


                    
                    } // endif...
                    //******** Fim - Trata das Colisões **********************************************************************************
       
              

                
                /**********************************************************************************************************/
                
               
            }   // end function Loop
