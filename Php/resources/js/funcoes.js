//-----------------------------------------------------------------------
// Inter-Trava 2 Selects PolicyIN::PolicyOUT de acordo com opcao PolicyIN
function interTravarPolicyIN() {
    var s1 = document.getElementById("CxPolicyIN");
    var s2 = document.getElementById("CxPolicyOUT");
    s1.selectedIndex = s2.selectedIndex; // index 2 = index 1
}	
function interTravarPolicyOUT() {
    var s1 = document.getElementById("CxPolicyIN");
    var s2 = document.getElementById("CxPolicyOUT");
    s2.selectedIndex = s1.selectedIndex; // index 2 = index 1
}	
//-------------------------------------------------------------------------

// function abreModal(){    $('#ModalConfigItens').modal('show');}

// CopiaToClipBoard de objetos(html) enviados como argmento
function CopyToClipBoardX(objHtml) {
    var content = document.getElementById(objHtml);
    content.select();					
    document.execCommand('copy');
    //alert("Copied!");
}
/*
function copyToClipBoardEmailPtStar_old() {
    var content = document.getElementById('TaRepositorioEmailPtStar'); 
    content.select();                  
    document.execCommand('copy')
    //alert("Copied!");
}
function copyToClipBoardEmailTA_old() {
    var content = document.getElementById('TaRepositorioEmailTA'); 
    content.select();                  
    document.execCommand('copy')
    //alert("Copied!");
}

*/

