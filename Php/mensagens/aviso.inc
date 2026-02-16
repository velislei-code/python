<!-- ======= Testimonials Section ======= -->
<section id="testimonials" class="testimonials">

  <div class="container">

    <div class="row">
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="testimonial-item mt-4">
            <p>
    <!-- <div class="alert-box success"><!-- Box de Mensagens temporaria -->  
    <table border="1" bordercolor="#c0c0c0" class="TAB_Login" width="500px" align="center" valign="top"> 							
          <tr>         
            <td width="100%" colspan="1" BGCOLOR="#87CEEB" height="20" align="left" valign="top"> 
                
               
        <table border="0" bordercolor="#c0c0c0" class="TAB_Login" width="500px" align="center" valign="top"> 							
          <tr><!-- Titulo -->
          <?Php if($Grau == defInfo){  ?>
            <td width="100%" colspan="1" BGCOLOR="#87CEEB" height="20" align="left" valign="top"> 
          <?Php }else if($Grau == defSucesso){    ?>
            <td width="100%" colspan="1" BGCOLOR="#9ACD32" height="20" align="left" valign="top">            
          <?Php }else if($Grau == defAtencao){  ?>
            <td width="100%" colspan="1" BGCOLOR="#F4A460" height="20" align="left" valign="top">            
          <?Php }else if($Grau == defPerigo){  ?>
            <td width="100%" colspan="1" BGCOLOR="#FF4500" height="20" align="left" valign="top">
          <?Php }else{  ?>
            <td width="100%" colspan="1" BGCOLOR="#87CEEB" height="20" align="left" valign="top">
          <?Php } ?>
             <b><?Php echo $TitMsg; ?></b>             
            </td>
          <tr>			
          
          <tr>
          <td width="100px" colspan="1"   height="20" align="left" valign="top">				
            <table border="0" bordercolor="#000000" width="100%" cellspacing="0" cellpadding="0" height="15" align="center" valign="top" color="#ffffC0">
              <tr><!-- Mensagem -->						
                <td width="100%" colspan="1"  align="center" valign="top"><font color="#000000"><font size="2" face="Verdana">   <?Php echo $Msg; ?>  </td>												
              </tr>
              <tr>						
                <td width="100%" colspan="1"  align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td>												
              </tr>
              <tr><td width="100%" colspan="4" align="left" valign="top"><font color="#000000"><font size="2" face="Verdana"></td></tr>
            </table>
            </td>
          </tr>
         
				  <tr><td width="60%" colspan="1"   height="1" align="left" valign="top"></td><tr>
				</table>
        </div>
        
    </td></tr>
	</table>
			
      </div>
      </div>
  <!-- </div> -->
</div>


</section><!-- End Testimonials Section -->