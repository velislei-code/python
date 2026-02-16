  function msgFrmApagado() {
    var x = document.getElementById("toastFrmApagado");
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
  }
 
  // Usado em tickets.php - Msg de Tickets protegidos(finalizados) 
  function msgTicketBlock() { 
    var x = document.getElementById("toastTicketBlock");
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
  }

  // Usado em script.php - verificação de campos vazios
  function msgCheckCampos() {
    var x = document.getElementById("toastCheckCampos");
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
  }

  /* Falha 
  function msgRenovarGaus() {
    var x = document.getElementById("toastRenovarGaus");
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
  }

  function msgTaBBoneClose() {
    var x = document.getElementById("toastTaBBoneClose");
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
  }
    */

  //clearTimeout(myTimeout);