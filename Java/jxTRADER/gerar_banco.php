<?Php

 LOAD DATA INFILE 'LISTA_ATIVOS.csv' INTO TABLE ativos FIELDS TERMINATED BY ';'

DELETE FROM ativos WHERE registro>0
ALTER TABLE ativos AUTO_INCREMENT = 1						
				      
     
CREATE TABLE GGBR4(
  registro int(11) NOT NULL auto_increment, 
  data varchar(10) NULL, 10/10/2018
  timex varchar(10) NULL,
  open float(8) NULL,
  high float(8) NULL,
  low float(8) NULL,
  close float(8) NULL,
  tickvol int(10) NULL,
  vol int(10) NULL, 
  spread int(3) NULL,     
  PRIMARY KEY  (registro)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


CREATE TABLE OperacaoTemp(
  registro int(11) NOT NULL auto_increment,
  tendencia varchar(10) NULL,
  status varchar(10) NULL, 
  oferta_cp float(8) NULL,
  stop_cp float(8) NULL,
  preco_cp float(8) NULL,
  data_cp varchar(10) NULL,
  hora_cp varchar(10) NULL,   
  oferta_vd float(8) NULL,
  stop_vd float(8) NULL,
  preco_vd float(8) NULL,
  data_vd varchar(10) NULL, 
  hora_vd varchar(10) NULL,    
  resultado float(10) NULL, 
  operacao varchar(10) NULL,  
  chave int(11) NULL,    
  data varchar(10) NULL,
  timex varchar(10) NULL,
  open float(8) NULL,
  high float(8) NULL,
  low float(8) NULL,
  close float(8) NULL,
  tickvol int(10) NULL,
  vol int(10) NULL, 
  spread int(3) NULL,       
  var_close float(8) NULL,    
  var_max float() NULL,   
   PRIMARY KEY  (registro)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


CREATE TABLE Ativos(
  registro int(11) NOT NULL auto_increment,
  codigo varchar(10) NULL,  
  nome varchar(80) NULL,  
  razao varchar(80) NULL,  
   PRIMARY KEY  (registro)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;



  var_close varchar(10) NULL,    /* perc.variacao entre open e close */
  var_max varchar(10) NULL,    /* perc.var.entre high e low */
  
  start_cp varchar(10) NULL,    /* num.reg ao liberar op cp*/
 
  start_vd varchar(10) NULL,    /* num.reg ao liberar op vd*/

  tendencia varchar(10) NULL, /*neutra, baixa, media, alta*/
  resultado varchar(10) NULL,    /* percentual de lucro ou perda*/




?>