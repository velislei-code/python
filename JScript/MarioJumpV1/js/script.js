
/*
    by: Treuk, Velislei A
    email: velislei@gmail.com
    Copyright(c) April/2023
    All Rights Reserveds    
    Permitido uso para estudantes de código
*/

let bEnableAutoRestart = false;         // Bloqueia, evita que vários exec-restart ocorram após ativar setTimeOut....


const cHeroWait = 0;
const cHeroStart = 1;
const cHeroRun = 2;
const cHeroUpStone = 3;
const cHeroCollided = 4;

var iStatus = cHeroWait;

//------------  Placar -----------------------------------//
let iPhase = 1;
let iLifes = 5;
let iPoints = 0;

var cJumpRock = 1;     // saltar pela Pedra 1 Pto
var cBrokeRock = 3;    // Quebrar a pedra 3 ptos   



let bEnableAccountLifes = false;    // Bloqueia, evita que varios decrementos de Life ocorram no mesma colisão(a booleam é mais rápida que usar direto uma var int)
let bEnableAccountPoints = false;   // Bloqueia, evita que varios decrementos de Life ocorram no mesma colisão(a booleam é mais rápida que usar direto uma var int)

// Conexao com página HTML
document.querySelector("#showPhase").innerHTML = iPhase;
document.querySelector("#showLifes").innerHTML = iLifes;
document.querySelector("#showPoints").innerHTML = iPoints;



//------------  Ctrl Audio -----------------------------------//

const constPremio = document.querySelector('.premio');                      // Importa a class=.Hero do style.css 


//------------  Ctrl Audio -----------------------------------//

let bEnableAudio = false;                                    // Ctrl On/Off de Audio   
document.querySelector("#sInfoAudio").innerHTML = 'Off';
const constAudio = new Audio('./audio/MarioBros.mp3');
constAudio.play();


// carregar Classes do CSS
const constPlateRestart = document.querySelector('.placa-restart');     // Importa a class=.Plate-restart do letras.css 
const constPlater = document.querySelector('.placar');                  // Importa a class=.Plater do letras.css 
const constPlateGameOver = document.querySelector('.placa-GameOver');   // Importa a class=.Plate-game-over do letras.css 
const constPlateStart = document.querySelector('.placa-start');         // Importa a class=.Plate-start do letras.css 
const constExplosion = document.querySelector('.explosion');            // Importa a class=.game-over do style.css 
const constHero = document.querySelector('.hero');                      // Importa a class=.Hero do style.css 
const constStone = document.querySelector('.stone');                    // Importa a class=.Stone do style.css 

// Chamada de funcoes
/*  2 formas de excrever(Normal e a AeroFunction):
        const constMyEx = function nome() {   rotinas/calculos aqui }  
        ou...
        const constMyEx = () => {   rotinas/calculos aqui  }   aqui a funcao é anonima, sem nome

        Tb:
        const constMulti = (num1, num2) => {
            const calc = num1 * num2
            retunr calc
        }
        ou...
        const constMulti = (num1, num2) => num1 * num2 >>> Vai retornar a multiplicação de num1 x Num2
*/
const constTeclaPress = () => { execJump(); }         // Chama Function ExecJump  
document.addEventListener('keydown', constTeclaPress);  // Pega evento(pressionamento de tecla)

/*
        function Clock() { Cod aqui! }
        var intervalo = setInterval( Clock, 1000 );     // Variável com o intervalo do setInterval()
        clearInterval( intervalo );                     // Parando o intervalo
*/

setInterval(() => { Loop() }, 10);
// ou... const constLoop=setInterval( () => { Loop() }, 10);
// ...setInterval(funcao, tempo)...()=>: funcao anonima 
// ou...setInterval( function(){ Loop() }, 10); 


function Loop() {


    const StonePositionLeft = constStone.offsetLeft;  /* Pega posição Left de Stone(Pedra) */
    // console.log(StonePositionLeft); /* Cmd.p/ Desenvolvimento: Mostra(Chrome->Inspecionar->Console) valores de Left do Stone(Pedra) */

    /*
        +: converter dados(pixel string) p/ numero 
        replace: troca/tira 'px' p/ ''(vazio)
        150px -> 150
    */
    const HeroPositionBottom = +window.getComputedStyle(constHero).bottom.replace('px', '');    /* Pega posição Botton(altura do pulo) do Hero */
    const HeroPositionLeft = +window.getComputedStyle(constHero).left.replace('px', '');    /* Pega posição Botton(altura do pulo) do Hero */
    //console.log(HeroPositionBottom);  /* Cmd.p/ Desenvolvimento: Mostra(Chrome->Inspecionar->Console) valores de Botton(pulo) do Hero */


    //---------------- Verificar Estado do Hero --------------------------------------------------------------------------//
    if (StonePositionLeft <= 150 && StonePositionLeft > 0) {    // 150px limite de tela, definido em class=.Stone de style.css                               

        if (StonePositionLeft <= 150 && StonePositionLeft > 120 && HeroPositionBottom < 90) { iStatus = cHeroCollided; }
        else if (StonePositionLeft <= 120 && StonePositionLeft > 10 && HeroPositionBottom > 90 && HeroPositionBottom < 130) { iStatus = cHeroUpStone; }
        else if (bSaltoExec) {

            // Se Não Collided, Não Esta encima do Pedra e Esta num Salto, quer dizer que Saltou com sucesso...então Pontua
            if (bEnableAccountPoints) {       // Essa rotina usa var-Boolean mais rápida para evitar que varios decrementos ocorram(limita a 1 decremento p/ colisão)
                // Saltar a pedra = 1 ptos
                Premiar(cJumpRock);
            }

            bSaltoExec = false;         // salto terminado
        }
    }

    // console.log("iLifes: "+iLifes+", iStatus: "+iStatus); 

    //---------------- Tratar Estado do Hero --------------------------------------------------------------------------//
    if (iStatus == cHeroWait) {       // Game em espera, não startado

        constPlateGameOver.style.left = '-350px';          // Esconde Plate GOver, para tras da Tela
        constPlateStart.style.left = '50%';             // Coloca Plate-start no centro da Tela
        constStone.style.animationPlayState = 'paused';  // Pausa Pedra


    } else if (iStatus == cHeroRun) {         // Hero correndo, em execução

        constPlateStart.style.left = '-350px';   // Esconde Plate Start, para tras da Tela
        constPlateGameOver.style.left = '-350px';   // Esconde Plate Game-Over, para tras da Tela

    } else if (iStatus == cHeroUpStone) {  // Hero encima do Pedra


        //  Pega posiçao atual do Stone e Fixa Stone(Pedra) nesta posição, 
        constStone.style.left = `${StonePositionLeft}px`;     // Note q esta entre `` 
        constStone.style.bottom = '-40px';                   // Efeito-afunda(30px) Stone 

        //  Pega posiçao do Hero e Fixa Hero nesta posição, 
        //    ...Hero fica encima do Stone(Pedra)...                                                             
        constHero.style.bottom = `${HeroPositionBottom}px`;     // Note q esta entre `` 
        if (HeroPositionBottom > 70) { constHero.style.bottom = '60px'; }     // Ajusta p/ cima do Pedra...pra não ficar no meio do caminho 

        //------ Ini - Tratamento de colisão na posição Bottom-Vertical , INTERROMPE MOVIMENTO DO Hero ---------------------------//
        // constHero.style.animation = 'none';         // Encerra animação do Stone 
        constHero.style.animationPlayState = 'paused';

        // constStone.src="./images/Stone_explode.png"; // após pular encima do Pedra...Carrega imagem de Pedra_explode 

        // Altera posição da img_Explosion para cima do Hero

        constExplosion.style.width = '120px';
        constExplosion.style.bottom = `${HeroPositionBottom - 50}px`;
        constExplosion.style.left = `${HeroPositionLeft + 50}px`;

        if (bEnableAccountPoints) {       // Essa rotina usa var-Boolean mais rápida para evitar que varios decrementos ocorram(limita a 1 decremento p/ colisão)
            // Quebrar pedra = 3 ptos
            Premiar(cBrokeRock);
        }



    } else if (iStatus == cHeroCollided) { // Hero bateu no Pedra



        //  Pega posiçao do Hero e Fixa Stone(Pedra) nesta posição, 
        //    ...Hero bate no Stone(Pedra). ..                                   */                           
        constStone.style.left = `${StonePositionLeft}px`;     // Note q esta entre `` 

        //  Pega posiçao do Hero e Fixa Hero nesta posição, 
        //    ...Hero fica encima do Stone(Pedra)...                                                             
        constHero.style.bottom = `${HeroPositionBottom}px`;     // Note q esta entre `` 
        if (HeroPositionBottom > 90) { constHero.style.bottom = '100px'; }     // Ajusta p/ cima do Pedra...pra não ficar no meio do caminho 

        //------ Ini - Tratamento de colisão na posição Bottom-Vertical , INTERROMPE MOVIMENTO DO Hero ---------------------------//
        // constHero.style.animation = 'none';         // Encerra animação do Stone 
        constHero.style.animationPlayState = 'paused';

        //**** carrega Img de game-Over *************************************

        // Altera posição da img_Explosion para cima do Hero
        constExplosion.style.bottom = `${HeroPositionBottom + 10}px`;
        constExplosion.style.left = `${HeroPositionLeft + 90}px`;


        if (bEnableAccountLifes) {       // Essa rotina usa var-Boolean mais rápida para evitar que varios decrementos ocorram(limita a 1 decremento p/ colisão)
            iLifes--;                // Decrementa var Life
            if (iLifes < 0) { iLifes = 0; }
            bEnableAccountLifes = false;  // Bloqueia novos decremntos de Life
            document.querySelector("#showLifes").innerHTML = iLifes;
        }

        if (iLifes < 1) {

            //constGameOver.src="./images/Game_over.png"; // carrega game-over...ja carregado em index.html 
            //constGameOver.style.opacity="1.0";

            //**** Encerra exec.de Loop ***********************                                
            // console.log('constLoop');            // Cmd.p/ Desenvolvimento: Mostra(Chrome->Inspecionar->Console->Loop em exec.) 
            clearInterval(Loop);                    // Encerra exec.do loop, pra não ficar executando após colisão(game-over)
            constPlateGameOver.style.left = '50%';  // Mostra...tira detras da Tela...tras Letreiro Plate Game-Over na Tela


        } else if (iLifes > 0) {

            if (bEnableAutoRestart) {
                var temporizador = setTimeout(AutoRestart, 3000);
                // var nome_variável = setTimout(Restart(), 3000);
                //setInterval( () => { Restart() }, 3000);
                //document.querySelector("#showLifes").innerHTML = "Time..."; 
                //clearInterval(Restart);
                bEnableAutoRestart = false; // Bloqueia, evita que vários exec-restart ocorram após ativar setTimeOut....
                // constPlateRestart.style.left = '50%';  // Mostra...tira detras da Tela...tras Letreiro Plate Game-Over na Tela
            }
        }


        // console.log("iLife: "+iLife+", iStatus: "+iStatus); 

        iStatus = cHeroWait;



    }





}   // end function Loop

function execInput_Hero() {

    // Aciona input_Hero do Hero, Queda do Ceu
    constHero.classList.add('input-Hero');       // carrega Clas=.hero-input de animacao.css  

    // setTimeout(Funcao, tempo(ms-mm que usei no style.css)); ....()=> funcao anônima
    setTimeout(() => {
        constHero.classList.remove('input-Hero');    // descarrega Clas=.hero-input de animacao.css  
    }, 500);    /* Mesmo tempo da passagem de Tela definido em css */

    constExplosion.style.width = '70px';   // Altera largura explosão para larg-padrao
    constExplosion.style.left = '-100px';  // Esconde img_Explosion para tras da Tela

    //constPlateRestart.style.right = '-250px';        // Esconde Plate-Go pra tras da Tela
    constPlateStart.style.left = '-350px';          // Esconde Plate-Start pra tras da Tela
    constStone.style.left = 'auto';                  // Libera movimento do Stone       
    constStone.style.bottom = '0px';                 // Ajusta Altura Pedra para Normal  
    constStone.style.animationPlayState = 'running';  // Aciona Pedra  
    constHero.style.animationPlayState = 'running'; // Aciona Hero
    iStatus = cHeroRun;
    bEnableAccountLifes = true;    // Habilita Accountgem de Lifes na colisão
    bEnableAccountPoints = true;  // Habilita Accountgem de Points  
    bEnableAutoRestart = true;  // Habilita rotina Restart, (evita que vários exec-restart ocorram após ativar setTimeOut....)
}

function execGameOver() {

    // Aciona input_Hero do Hero, Queda do Ceu
    constHero.classList.add('hero-input');          // carrega Clas=.hero-input de animacao.css  

    // setTimeout(Funcao, tempo(ms-mm que usei no style.css)); ....()=> funcao anônima
    setTimeout(() => {
        constHero.classList.remove('hero-input');    // descarrega Clas=.hero-input de animacao.css  
    }, 500);    /* Mesmo tempo da passagem de Tela definido em css */

    constPlateStart.style.left = '-350px';            // Esconde Plate pra tras da Tela
    constPlateRestart.style.left = '50%';        // Esconde Plate-Go pra tras da Tela
    constStone.style.animationPlayState = 'running';  // Aciona Pedra  
    constHero.style.animationPlayState = 'running';   // Aciona Hero
    iStatus = cHeroRun;

}

function execJump() {

    /* 
        Adiciono a class=.jump do style.css dentro de   
        constHero(q já carregou(acima) class=.Hero(do css)
    */

    if (iStatus == cHeroUpStone) {

        constExplosion.style.width = '70px';   // Altera largura explosão para larg-padrao
        constExplosion.style.left = '-100px';  // Esconde img_Explosion para tras da Tela

        constStone.style.left = 'auto';
        constStone.style.bottom = '0px';                 // Ajusta Altura Pedra para Normal      
        constHero.style.bottom = '0px ';
        iStatus = cHeroRun;
        bEnableAccountPoints = true;  // Habilita Accountgem de Points
    }

    // constStone.style.animation = 'Stone-animation 1.5s infinite linear';
    constStone.style.animationPlayState = 'running';

    //constHero.style.animation = 'normal';

    constHero.classList.add('jump-Hero');  // Carrega Clas=.jump-Hero de style.css  

    /* 
        setTimeout(Funcao, tempo(ms-mm que usei no style.css)); ....()=> funcao anônima
    */
    setTimeout(() => {
        constHero.classList.remove('jump-Hero'); // desCarrega Clas=.jump-Hero de style.css
    }, 500);    /* Mesmo tempo da passagem de Tela definido em css */


    constHero.style.animationPlayState = 'running';



    // constStone.style.animation = 'Stone-animation 1.5s infinite linear';
    constStone.style.animationPlayState = 'running';

    //constHero.style.animation = 'normal';

    constHero.classList.add('jump-Hero');  // Carrega Clas=.jump-Hero de style.css  

    /* 
        setTimeout(Funcao, tempo(ms-mm que usei no style.css)); ....()=> funcao anônima
    */
    setTimeout(() => {
        constHero.classList.remove('jump-Hero');   // DesCarrega Clas=.jump-Hero de style.css
    }, 500);    /* Mesmo tempo da passagem de Tela definido em css */


    constHero.style.animationPlayState = 'running';
    bSaltoExec = true;         // info salto executado para analisar pontuação
    bEnableAccountPoints = true;       // Libera nova soma de pontos no mesmo loop



}   // end execSalto()

function Premiar(iTypePoint) {

    if (iTypePoint == cBrokeRock) {
        iPoints += 2;               // incrementa var Point  
        // Simbolos:diamante, 128142 https://www.w3schools.com/charsets/ref_emoji.asp
        document.querySelector("#showPremio").innerHTML = "&#128142; &#128142; &#128142;";   // Envia Simbolo Diamante p/ imprimir no HTML                     
    } else if (iTypePoint == cJumpRock) {
        iPoints++;                // incrementa var Point  
        document.querySelector("#showPremio").innerHTML = "&#128142;";   // Envia Simbolo Diamante p/ imprimir no HTML
    }



    document.querySelector("#showPoints").innerHTML = iPoints;

    //bEnableAccountPoints = false;       // Bloqueia nova soma de pontos no mesmo loop

    constPremio.style.bottom = '100px';//`${HeroPositionBottom-50}px`;
    constPremio.style.left = '250px';//`${HeroPositionLeft+50}px`;

    constPremio.classList.add('premio-Hero');  // Carrega Clas=.jump-Hero de style.css  


    setTimeout(() => {
        constPremio.classList.remove('premio-Hero'); // desCarrega Clas=.jump-Hero de style.css
        constPremio.style.left = '-250px';//`${HeroPositionLeft+50}px`; // esconde p/ tras da tela

    }, 1500);    /* Mesmo tempo da passagem de Tela definido em css */


}

function Start() {

    // manter essas funções abaixo dos códigos para funcionar 

    iPhase = 1;
    iLifes = 5;
    iPoints = 0;

    document.querySelector("#showPhase").innerHTML = iPhase;
    document.querySelector("#showLifes").innerHTML = iLifes;
    document.querySelector("#showPoints").innerHTML = iPoints;

    bEnableAccountLifes = false;    // Bloqueia, evita que varios decrementos de Life ocorram no mesma colisão(a booleam é mais rápida que usar direto uma var int)
    bEnableAccountPoints = false;   // Bloqueia, evita que varios incrementos de pontos ocorram no mm loop      
    execInput_Hero();
    CtrlAudio();

}

function AutoRestart() { execInput_Hero(); }

function CtrlAudio() {
    // manter essas funções abaixo dos códigos para funcionar 
    if (bEnableAudio) {
        constAudio.play();
        document.querySelector("#sInfoAudio").innerHTML = 'On';
        bEnableAudio = false;
    } else {
        constAudio.pause();
        document.querySelector("#sInfoAudio").innerHTML = 'Off';
        bEnableAudio = true;
    }

}


/*

    // Relogio Digital OnLine
    const constClock = () => {
        const clock = document.getElementsByClassName('showClock')[0]
        const date = new Date()
        const hours = date.getHours()
        const minutes = date.getMinutes()
        const seconds = date.getSeconds()
        const hour = hours < 10 ? `0${hours}` : hours
        const minute = minutes < 10 ? `0${minutes}` : minutes
        const second = seconds < 10 ? `0${seconds}` : seconds
        clock.innerHTML = `${hour}:${minute}:${second}`
    }
    
    setInterval(() => {
        constClock()
    }, 1000)

     <!-- Linha na Pág HTML: <span style="color: yellow"> <div  class="showClock"></div> </span> -->
*/