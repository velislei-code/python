	
	<ul class="menu">	
		<?Php if($MostrarVoltar){ ?>
			<li <?Php if($AbaAtivaA == $AttribAbaIntM[0]){ echo" class='selecionado' ";} ?> ><a href="<?Php echo"$AttribLinkAbaIntM[0]"; ?>" ><b><?Php echo"$AttribAbaIntM[0]"; ?></b></a></li> <!-- << -->
		<?Php } ?>
		<li <?Php if($AbaAtivaA == $AbaIntA[1]){ echo" class='selecionado' ";} ?> ><a href="<?Php echo"$LinkAbaIntA[1]"; ?>" ><em class="home"></em><b><?Php echo"$AbaIntA[1]"; ?></b></a></li>								
		<li <?Php if($AbaAtivaA == $AbaIntA[2]){ echo" class='selecionado' ";} ?> ><a href="<?Php echo"$LinkAbaIntA[2]"; ?>" ><em class="calendar"></em><b><?Php echo"$AbaIntA[2]"; ?></b></a></li>		
		<li <?Php if($AbaAtivaA == $AbaIntA[3]){ echo" class='selecionado' ";} ?> ><a href="<?Php echo"$LinkAbaIntA[3]"; ?>" ><em class="find"></em><b><?Php echo"$AbaIntA[3]"; ?></b></a></li>
		<?Php if($MostrarAvanco){ ?>
			<li <?Php if($AbaAtivaA == $AttribAbaIntM[1]){ echo" class='selecionado' ";} ?> ><a href="<?Php echo"$AttribLinkAbaIntM[1]"; ?>" ><b><?Php echo"$AttribAbaIntM[1]"; ?></b></a></li>
		<?Php } ?>
		<li class="$ObjFuncao->espaco"><b><?Php $ObjFuncao->espaco($NumEspPesquisa); ?></b></li>				<!-- Criando espa�o entre as Abas -->				
		<li <?Php if($AbaAtivaB == $AttribAbaIntB[1]){ echo" class='selecionado' ";} ?> ><a href="<?Php echo"$AttribLinkAbaIntB[1]"; ?>" ><em class="adicionar"></em><b><?Php echo"$AttribAbaIntB[1]"; ?></b></a></li>
		<li <?Php if($AbaAtivaB == $AttribAbaIntB[2]){ echo" class='selecionado' ";} ?> ><a href="<?Php echo"$AttribLinkAbaIntB[2]"; ?>" ><em class="ler"></em><b><?Php echo"$AttribAbaIntB[2]"; ?></b></a></li>
		<li <?Php if($AbaAtivaB == $AttribAbaIntB[3]){ echo" class='selecionado' ";} ?> ><a href="<?Php echo"$AttribLinkAbaIntB[3]"; ?>" ><em class="editar"></em><b><?Php echo"$AttribAbaIntB[3]"; ?></b></a></li>
		<li <?Php if($AbaAtivaB == $AttribAbaIntB[4]){ echo" class='selecionado' ";} ?> ><a href="<?Php echo"$AttribLinkAbaIntB[4]"; ?>" ><em class="excluir"></em><b><?Php echo"$AttribAbaIntB[4]"; ?></b></a></li>				
		<li><a><b>
		
			<?Php 
				if( isset($_REQUEST['topico']) ){ $TopicoURL = $_REQUEST['topico'];	}
				else{  $TopicoURL = ""; }
				$ListaPesquisa = $ObjMySql->ListarPesquisa($TopicoURL);
				$NumP = count($ListaPesquisa);	
				//echo '(abas)Topico: '.$TopicoURL;

			?>
				<input list="EdLocalizar" size="30" name="EdLocalizar" onchange="this.form.submit();" title="Use: 'Texto completo', A+B+C(E), A B C(Ou)" placeholder="Ex: 'Meu Texto', A+B+C(E), A B C(ou)">               
				<datalist id="EdLocalizar" name="EdLocalizar">
					<?Php for($p=0; $p<$NumP; $p++){ ?>
						<option value="<?Php echo $ListaPesquisa[$p]; ?>"></option>
                    <?Php } ?>
                </datalist>
			<!--	
				<input type="text" name="EdLocalizar" value="<?Php echo $PesquisarX; ?>" size="30" placeholder="Ex: MA5103+ger�ncia+inicial">
			-->
			<input type="submit" name="BtLocalizar" size="1" value="OK" >
			                
			
		</b></a></li>				
	</ul>
	<?Php $objFuncao = new Funcao(); $objFuncao->RegistrarLog('menu_abas.inc;'); ?>