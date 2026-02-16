<?Php
/*
// Inibe a exibi��o de erros nas p�ginas
	error_reporting(0);
	ini_set('display_errors', 0 );
	ini_set('log_errors', 0);
	
*/	
	ini_set('display_errors', 1);
	ini_set('log_errors', 1);
	ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
	error_reporting(E_ALL);

?>

<?php $objFuncao->RegistrarLog('funcaoErro.inc;'); ?>


