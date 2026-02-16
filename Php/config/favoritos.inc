<style type="text/css">

.favorito_skin{
position: fixed;				/* absolute: posi��o varia cfe mouse (Apagar Top/Left) */
width: 230px; left: 990px;		/* Largura/posi��o do Menu - deixar na sequencia */
height: fixed; top: 40px;		/* Altura/ posi��o - deixar na sequencia */
background-color: #BFCDDB;		/* Cor de fundo do menu */
border:1px solid  #95A6B9;		/* Espessura e cor da borda */
font: normal 10px Verdana;
color: #235E94;					/* Cor do t�tulo */
line-height: 18px;				/* Largura da linha */
z-index: 100;
visibility: hidden;         	/* escondido */
text-align: left;

}

.favorito_skin a{
text-decoration:none;
color:#235E94;			/* Cor da letra */
padding-left:10px;
padding-right:10px;
}

#mouseoverstyle_fav{
background-color:#3E6E9B;	/* Cor da sele��o */
 
}

#mouseoverstyle_fav a{
color:white;				/* Cor da letra selecionada */


</style>
<!--------------------------------- INICIO SCRIPT MENU FLUTUANTE ----------------------------------------->
<script language="JavaScript1.2">


var linkset_fav=new Array()

linkset_fav[0]='<b><img border="0" src="imagens/tema/favB0C4DE.png" width="12" height="15"> Favoritos</b>'
linkset_fav[0]+='<hr>'
linkset_fav[0]+='<div class="fav_items"></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://10.48.103.227/afetacao_dslams/detalhamento2.php?UF=PR" TARGET="_blank">T15(Ant)</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="https://appcgr.oi.intranet/afetacao/det.php?uf=PR" TARGET="_blank">Alarmes(T15-A)</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="https://10.48.103.55/afetacao/det.php?uf=PR" TARGET="_blank">Alarmes(T15-B)</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://legado.brasiltelecom.com.br:8080/telao_web/?tipoPlanta=0&uf=PR" TARGET="_blank">Alarmes (FO)</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://200.222.75.227/rota/plugins/weathermap/weathermap-cacti-plugin.php?group_id=75" TARGET="_blank">Weathermap</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://10.121.241.95/portaloi/view/dslam/index.php" TARGET="_blank">Consulta ADSL</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://10.61.240.163:7007/provision/report/index.jsp" TARGET="_blank">Provision</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="https://passaporteoi.oi.net.br/" TARGET="_blank">VPN</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://10.61.240.162:7005/oms/control/orderListMenu/" TARGET="_blank">OMS</a></div>'

linkset_fav[0]+='<div class="fav_items"><a href="#">------------------------------</a></div>'

linkset_fav[0]+='<div class="fav_items"><a href="http://opsist01.oi.corp.net:1522/monitor/sacsge/monitora_filas.phtml" TARGET="_blank">Monitor SGEY</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="https://10.121.240.95/doffline/pem/" TARGET="_blank">BA�s PEM</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://10.48.113.141/" TARGET="_blank">Alarmes (T15-141)</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://10.48.113.191/" TARGET="_blank">Alarmes (T15-191)</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="https://10.48.103.5/cahl/login/" TARGET="_blank">CAHL(Migra��es)</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://10.51.252.6:7777/monitor/sacsge/monitora_filas.phtml" TARGET="_blank">Filas BD/OS</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://geosc01.cn.brasiltelecom.net.br/geosc/view/consultas/premissa_dslam.php" TARGET="_blank">Premissa Dslam�s</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://10.48.60.233/redebasica/view/cd_congestionamento/" TARGET="_blank">Congestionamento Dslam�s</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://api.cn.brasiltelecom.net.br/portaloi/view/cadastro/" TARGET="_blank">Cadastro ADSL(tr109065(v***4*)</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://legado.brasiltelecom.com.br/consultas/BA_WEB_.html" TARGET="_blank">Consulta BA</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://consultassn2.cn.brasiltelecom.net.br/geraScript.php" TARGET="_blank"> Script DSLAM</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://10.48.144.6/aceitacoes/" TARGET="_blank">Aceita��es</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://ping.cn.brasiltelecom.net.br/" TARGET="_blank">RT-Ping</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="https://oms.brasiltelecom.com.br/ICSLogin/auth-up" TARGET="_blank">OMS(b)</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="https://oms.intranet/oms/control/queryBasica" TARGET="_blank">OMS(c)</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://portaldo/portal/index.php" TARGET="_blank">JM</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://10.41.8.143/" TARGET="_blank">SALCOM</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://10.22.180.17/param/movel/desempenho/telao_movel.php" TARGET="_blank">Tel�o da m�vel</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="https://workforce.brasiltelecom.com.br/zapweb/" TARGET="_blank">SGE</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="https://loginprdsig.intranet/nidp/idff/sso?id=Loginoi&sid=1&option=credential&sid=1" TARGET="_blank">Janela manut.</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://metaframe.brasiltelecom.com.br/Citrix/XenApp/site/default.aspx" TARGET="_blank">Citrix</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="https://identidadeoi.com.br/senha/index.seam" TARGET="_blank">Gest�o de senhas</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="https://app.intranet/ga" TARGET="_blank">Gest�o de acessos(GA)</a></div>'

linkset_fav[0]+='<hr>'
linkset_fav[0]+='<div class="fav_items">LG:implantacao, SN:implantacao14brt</div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://cacti.cn.brasiltelecom.net.br/" TARGET="_blank">Tr�fego(Core-BSA)</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://200.222.75.90/cacti/plugins/weathermap/weathermap-cacti-plugin.php" TARGET="_blank">Tr�fego(Core-BRAS)</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://200.222.75.89/cacti/plugins/weathermap/weathermap-cacti-plugin.php" TARGET="_blank">Tr�fego(Core-Fixa)</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://200.222.75.209/cacti/plugins/weathermap/weathermap-cacti-plugin.php?group_id=23" TARGET="_blank">Tr�fego(Metro)</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://200.222.75.202/cacti/plugins/weathermap/weathermap-cacti-plugin.php" TARGET="_blank">Tr�fego(NGN-Nordeste)</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://200.222.75.142/cacti/plugins/weathermap/weathermap-cacti-plugin.php?group_id=2" TARGET="_blank">Tr�fego(NGN-Sudoeste)</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://200.222.75.1/cacti/graph_view.php?action=tree&tree_id=6&leaf_id=735" TARGET="_blank">Tr�fego(Rota)</a></div>'

linkset_fav[0]+='<hr>'
linkset_fav[0]+='<div class="fav_items"></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://geosc01.cn.brasiltelecom.net.br/portaloi/view/nds/" TARGET="_blank">NDS Oi</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://10.121.241.95/portaloi/view/portal/" TARGET="_blank">Portal SN2(links)</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://sn2pedia.cn.brasiltelecom.net.br/index.php/Comandos_em_DSLAM" TARGET="_blank">Portal Oi(links)</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://10.48.113.191/TSP_Dados_Menu/TSP_Dados_Menu.exe" TARGET="_blank">Ger�ncia de redes(links)</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://10.48.22.89/portal/" TARGET="_blank">CNBrT - SN2(links)</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://10.121.241.95/" TARGET="_blank">CNGS(links)</a></div>'
linkset_fav[0]+='<div class="fav_items"><a href="http://10.51.162.6/" TARGET="_blank">Link�s OI(HE)</a></div>'

/***********************************************************************************************************************************************************************/

var ie4_fav=document.all&&navigator.userAgent.indexOf("Opera")==-1
var ns6_fav=document.getElementById&&!document.all
var ns4_fav=document.layers

function show_favorito(e,which){

if (!document.all&&!document.getElementById&&!document.layers)
return

clearhide_favorito()

favorito_obj=ie4_fav? document.all.pop_favorito : ns6_fav? document.getElementById("pop_favorito") : ns4_fav? document.pop_favorito : ""
favorito_obj.thestyle=(ie4_fav||ns6_fav)? favorito_obj.style : favorito_obj

if (ie4_fav||ns6_fav)
favorito_obj.innerHTML=which
else{
favorito_obj.document.write('<layer name=gui bgColor=#E6E6E6 width=165 onmouseover="clearhide_favorito()" onmouseout="hide_favorito()">'+which+'</layer>')
favorito_obj.document.close()
}

favorito_obj.contentwidth=(ie4_fav||ns6_fav)? favorito_obj.offsetWidth : favorito_obj.document.gui.document.width
favorito_obj.contentheight=(ie4_fav||ns6_fav)? favorito_obj.offsetHeight : favorito_obj.document.gui.document.height
eventX=ie4_fav? event.clientX : ns6_fav? e.clientX : e.x 
eventY=ie4_fav? event.clientY : ns6_fav? e.clientY : e.y 

var rightedge_fav=ie4_fav? document.body.clientWidth-eventX : window.innerWidth-eventX 
var bottomedge_fav=ie4_fav? document.body.clientHeight-eventY : window.innerHeight-eventY

if (rightedge_fav<favorito_obj.contentwidth)

favorito_obj.thestyle.left=ie4_fav? document.body.scrollLeft+eventX-favorito_obj.contentwidth : ns6_fav? window.pageXOffset+eventX-favorito_obj.contentwidth : eventX-favorito_obj.contentwidth
else
favorito_obj.thestyle.left=ie4_fav? document.body.scrollLeft+eventX : ns6_fav? window.pageXOffset+eventX : eventX

if (bottomedge_fav<favorito_obj.contentheight)
favorito_obj.thestyle.top=ie4_fav? document.body.scrollTop+eventY-favorito_obj.contentheight : ns6_fav? window.pageYOffset+eventY-favorito_obj.contentheight : eventY-favorito_obj.contentheight
else
favorito_obj.thestyle.top=ie4_fav? document.body.scrollTop+event.clientY : ns6_fav? window.pageYOffset+eventY : eventY
favorito_obj.thestyle.visibility="visible"
return false
}

function contains_ns6_fav(a, b) {
while (b.parentNode)
if ((b = b.parentNode) == a)
return true;
return false;
}

function hide_favorito(){
if (window.favorito_obj)
favorito_obj.thestyle.visibility=(ie4_fav||ns6_fav)? "hidden" : "hide"
}

function dynamichide_fav(e){
if (ie4_fav&&!favorito_obj.contains(e.toElement))
hide_favorito()
else if (ns6_fav&&e.currentTarget!= e.relatedTarget&& !contains_ns6_fav(e.currentTarget, e.relatedTarget))
hide_favorito()
}

function delayhide_favorito(){
if (ie4_fav||ns6_fav||ns4_fav)
delayhide_favorito=setTimeout("hide_favorito()",500)
}

function clearhide_favorito(){
if (window.delayhide_favorito)
clearTimeout(delayhide_favorito)
}

function highlight_favorito(e,state){
if (document.all)
source_el=event.srcElement
else if (document.getElementById)
source_el=e.target
if (source_el.className=="fav_items"){
source_el.id=(state=="on")? "mouseoverstyle_fav" : ""
}
else{
while(source_el.id!="pop_favorito"){
source_el=document.getElementById? source_el.parentNode : source_el.parentElement
if (source_el.className=="fav_items"){
source_el.id=(state=="on")? "mouseoverstyle_fav" : ""
}
}
}
}

if (ie4_fav||ns6_fav)
document.onclick=hide_favorito

</script>

<?php //$objFuncao->RegistrarLog('favoritos.inc(js);'); ?>