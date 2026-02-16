<?Php

-- Apache/2.4.4 (Win32) PHP/5.4.16
-- Versão do cliente de base de dados: libmysql - mysqlnd 5.0.10 - 20111026 - $Id:                            e707c415db32080b3752b232487a435ee0372157 $
-- Extensão de PHP: mysqli 
-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tempo de Geração: Set 20, 2018 as 11:00 AM
-- Versão do Servidor: 5.0.51
-- Versão do PHP: 5.4.16

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Banco de Dados: eBR
-- 

-- --------------------------------------------------------

-- 
-- Estrutura da tabela 
-- 


CREATE TABLE comandos (
  registro int(11) NOT NULL auto_increment,
  assunto varchar(30) NULL, 
  topico varchar(30) NULL, 
  procedimento varchar(50) NULL,
  descricao varchar(80) NULL,
  comando text(5000) NULL,   
  data varchar(15) NULL,  
  endereco varchar(50) NULL,  
  recentes varchar(20) NULL,  
  PRIMARY KEY  (registro)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE config (
  reg int(3) NOT NULL auto_increment,
  lst_cmds INT(1) NULL, 
  ta_rever_ips INT(1) NULL, 
  ta_backbone INT(1) NULL,  
  flt_produto varchar(10) NULL,
  flt_tipo varchar(10) NULL,
  flt_aCadastrar varchar(10) NULL,
  flt_historico varchar(10) NULL,
  PRIMARY KEY  (reg)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


CREATE TABLE cxseltickets (
  registro int(11) NOT NULL auto_increment,
  keyEstgReg varchar(10) NULL, 
  bID varchar(10) NULL, 
  empresa varchar(50) NULL, 
  produto varchar(20) NULL,    
  speed varchar(5) NULL,
  tipo varchar(10) NULL,
  acadastrar varchar(20) NULL, 
  historico varchar(50) NULL, 
  data varchar(15) NULL, 
  PRIMARY KEY  (registro)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE events (
  id int(11) NOT NULL auto_increment,
  title varchar(220) NULL,
  color varchar(45) NULL,
  start datetime NULL,
  end datetime NULL,  
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


CREATE TABLE listaID (
  reg int(11) NOT NULL auto_increment,
  idPend varchar(10) NULL, 
  id varchar(10) NULL,   
  seg varchar(10) NULL, 
  empresa varchar(30) NULL, 
  ativ varchar(20) NULL, 
  resp varchar(20) NULL, 
  status varchar(20) NULL, 
  tecnico varchar(30) NULL, 
  data varchar(15) NULL,  
  PRIMARY KEY  (reg)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE pesquisa (
  registro int(11) NOT NULL auto_increment,
  topico varchar(20) NULL, 
  lista varchar(80) NULL, 
  PRIMARY KEY  (registro)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE seltickets (
  registro int(11) NOT NULL auto_increment,
  id varchar(10) NULL, 
  produto varchar(20) NULL,
  empresa varchar(50) NULL,   
  speed varchar(5) NULL,
  status varchar(20) NULL,
  rascunho text(5000) NULL, 
  data varchar(15) NULL, 
  PRIMARY KEY  (registro)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


CREATE TABLE tickets (
  registro int(11) NOT NULL auto_increment,
  id varchar(10) NULL, 
  empresa varchar(80) NULL, 
  produto varchar(15) NULL, 
  tipo varchar(20) NULL,
  id_flow varchar(70) NULL,
  swa varchar(30) NULL,
  edd varchar(15) NULL,
  operadora varchar(15) NULL,
  vlan_ger varchar(5) NULL,
  shelf_swa varchar(2) NULL,
  slot_swa varchar(2) NULL,
  port_swa varchar(2) NULL,
  swt varchar(30) NULL,
  swt_ip varchar(30) NULL,
  rede_acesso varchar(30) NULL,
  router varchar(30) NULL,
  interface varchar(15) NULL,
  porta varchar(20) NULL,
  speed varchar(5) NULL,
  vid_unit varchar(5) NULL,   
  policyIN varchar(30) NULL,  
  policyOUT varchar(30) NULL,  
  vrf varchar(50) NULL,  
  svlan varchar(5) NULL,  
  cvlan varchar(5) NULL,  
  lan varchar(15) NULL,  
  wan varchar(15) NULL,  
  loopback varchar(15) NULL,  
  lan6 varchar(50) NULL,  
  wan6 varchar(50) NULL,
  rotas_intragov text(300) NULL, 
  status varchar(50) NULL, 
  rascunho text(5000) NULL, 
  rever_tunnel text(5000) NULL, 
  backbone text(5000) NULL, 
  data varchar(15) NULL,
  link_imagens varchar(50) NULL, 
  PRIMARY KEY  (registro)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


CREATE TABLE usuario (
  registro int(3) NOT NULL auto_increment,
  nome varchar(50) NULL,
  celular varchar(15) NULL,
  email varchar(50) NULL,
  login varchar(10) NULL, 
  senha varchar(10) NULL,
  data varchar(15) NULL,  
  PRIMARY KEY  (registro)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE vrf (
  id int(11) NOT NULL auto_increment,
  empresa varchar(50) NULL,
  vrf varchar(80) NULL, 
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE rav (
  id int(11) NOT NULL auto_increment,
  rav varchar(50) NULL,
  config text(500000) NULL, 
  data varchar(15) NULL, 
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

//----------- ?? -------------------------------------------------//
CREATE TABLE lstSelTickets (
  reg int(11) NOT NULL auto_increment,
  cxSelect varchar(10) NULL,
  PRIMARY KEY  (reg)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;




?>

