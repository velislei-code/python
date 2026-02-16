<style type="text/css">

.sistema_skin{
position: fixed;				/* absolute: posi��o varia cfe mouse (Apagar Top/Left) */
width: 180px; left: 1050px;		/* Largura/posi��o do Menu - deixar na sequencia */
height: fixed; top: 50px;		/* Altura/ posi��o - deixar na sequencia */
background-color: #C0C0C0;		/* Cor de fundo do menu */
border:1px solid  #95A6B9;		/* Espessura e cor da borda */
font: normal 10px Verdana;
color: #235E94;					/* Cor do t�tulo */
line-height: 18px;				/* Largura da linha */
z-index: 100;
visibility: hidden;         	/* escondido */
text-align: left;

}

.sistema_skin a{
text-decoration:none;
color:#235E94;			/* Cor da letra */
padding-left:10px;
padding-right:10px;
}

#mouseoverstyle_sys{
background-color:#3E6E9B;	/* Cor da sele��o */
 
}

#mouseoverstyle_sys a{
color:white;				/* Cor da letra selecionada */


</style>
<!--------------------------------- INICIO SCRIPT MENU FLUTUANTE ----------------------------------------->
<script language="JavaScript1.2">


var linkset_sys=new Array()

linkset_sys[0]='<b><img border="0" src="imagens/tema/favB0C4DE.png" width="12" height="15"> sistemas</b>'
linkset_sys[0]+='<hr>'
linkset_sys[0]+='<div class="sys_items"></div>'
linkset_sys[0]+='<div class="sys_items"><a href="backup_xls.php">Exportar(xls)</a></div>'
linkset_sys[0]+='<div class="sys_items"><a href="backup_csv.php">Exportar(CSV)</a></div>'
linkset_sys[0]+='<div class="sys_items"><a href="backup.php">Copiar Tabelas</a></div>'



var ie4_sys=document.all&&navigator.userAgent.indexOf("Opera")==-1
var ns6_sys=document.getElementById&&!document.all
var ns4_sys=document.layers

function show_sistema(e,which){

if (!document.all&&!document.getElementById&&!document.layers)
return

clearhide_sistema()

sistema_obj=ie4_sys? document.all.pop_sistema : ns6_sys? document.getElementById("pop_sistema") : ns4_sys? document.pop_sistema : ""
sistema_obj.thestyle=(ie4_sys||ns6_sys)? sistema_obj.style : sistema_obj

if (ie4_sys||ns6_sys)
sistema_obj.innerHTML=which
else{
sistema_obj.document.write('<layer name=gui bgColor=#E6E6E6 width=165 onmouseover="clearhide_sistema()" onmouseout="hide_sistema()">'+which+'</layer>')
sistema_obj.document.close()
}

sistema_obj.contentwidth=(ie4_sys||ns6_sys)? sistema_obj.offsetWidth : sistema_obj.document.gui.document.width
sistema_obj.contentheight=(ie4_sys||ns6_sys)? sistema_obj.offsetHeight : sistema_obj.document.gui.document.height
eventX=ie4_sys? event.clientX : ns6_sys? e.clientX : e.x 
eventY=ie4_sys? event.clientY : ns6_sys? e.clientY : e.y 

var rightedge_sys=ie4_sys? document.body.clientWidth-eventX : window.innerWidth-eventX 
var bottomedge_sys=ie4_sys? document.body.clientHeight-eventY : window.innerHeight-eventY

if (rightedge_sys<sistema_obj.contentwidth)

sistema_obj.thestyle.left=ie4_sys? document.body.scrollLeft+eventX-sistema_obj.contentwidth : ns6_sys? window.pageXOffset+eventX-sistema_obj.contentwidth : eventX-sistema_obj.contentwidth
else
sistema_obj.thestyle.left=ie4_sys? document.body.scrollLeft+eventX : ns6_sys? window.pageXOffset+eventX : eventX

if (bottomedge_sys<sistema_obj.contentheight)
sistema_obj.thestyle.top=ie4_sys? document.body.scrollTop+eventY-sistema_obj.contentheight : ns6_sys? window.pageYOffset+eventY-sistema_obj.contentheight : eventY-sistema_obj.contentheight
else
sistema_obj.thestyle.top=ie4_sys? document.body.scrollTop+event.clientY : ns6_sys? window.pageYOffset+eventY : eventY
sistema_obj.thestyle.visibility="visible"
return false
}

function contains_ns6_sys(a, b) {
while (b.parentNode)
if ((b = b.parentNode) == a)
return true;
return false;
}

function hide_sistema(){
if (window.sistema_obj)
sistema_obj.thestyle.visibility=(ie4_sys||ns6_sys)? "hidden" : "hide"
}

function dynamichide_sys(e){
if (ie4_sys&&!sistema_obj.contains(e.toElement))
hide_sistema()
else if (ns6_sys&&e.currentTarget!= e.relatedTarget&& !contains_ns6_sys(e.currentTarget, e.relatedTarget))
hide_sistema()
}

function delayhide_sistema(){
if (ie4_sys||ns6_sys||ns4_sys)
delayhide_sistema=setTimeout("hide_sistema()",500)
}

function clearhide_sistema(){
if (window.delayhide_sistema)
clearTimeout(delayhide_sistema)
}

function highlight_sistema(e,state){
if (document.all)
source_el=event.srcElement
else if (document.getElementById)
source_el=e.target
if (source_el.className=="sys_items"){
source_el.id=(state=="on")? "mouseoverstyle_sys" : ""
}
else{
while(source_el.id!="pop_sistema"){
source_el=document.getElementById? source_el.parentNode : source_el.parentElement
if (source_el.className=="sys_items"){
source_el.id=(state=="on")? "mouseoverstyle_sys" : ""
}
}
}
}

if (ie4_sys||ns6_sys)
document.onclick=hide_sistema

</script>
<?php $objFuncao->RegistrarLog('menu_sistema.inc(js);'); ?>