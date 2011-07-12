<?php

if(empty($_POST)){	
	echo '<script type="text/javascript">window.close()</script>';
	exit;
}
// Configuration
require_once('config.php');   
// Startup
require_once(DIR_APPLICATION . 'controller/payment/pgs/createLog.php');

$log = new createLog();
$log -> setLog(	'POST @ ' . date("d/m/Y H:i ") . "\n" .
				'TransacaoID : ' . $_POST['TransacaoID'] . "\n" .
				'StatusTransacao : ' . $_POST['StatusTransacao'] . "\n");

require_once(DIR_SYSTEM . 'startup.php');
/*
require_once(DIR_SYSTEM . 'helper/customer.php');
require_once(DIR_SYSTEM . 'helper/currency.php');
require_once(DIR_SYSTEM . 'helper/tax.php');
require_once(DIR_SYSTEM . 'helper/weight.php');
require_once(DIR_SYSTEM . 'helper/measurement.php');
require_once(DIR_SYSTEM . 'helper/cart.php');
// Loader
$loader = new Loader();
Registry::set('load', $loader);

// Config
$config = new Config();
Registry::set('config', $config);
*/
// Database 
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
//Registry::set('db', $db);

// Settings
$query = $db->query("SELECT value FROM " . DB_PREFIX . "setting s where s.key='pagseguro_token'");

foreach ($query->rows as $setting) {
	define('TOKEN', $setting['value']);
}

require_once(DIR_APPLICATION . 'controller/payment/pgs/tratadados.php');
require_once(DIR_APPLICATION . 'controller/payment/pgs/retorno.php');

function retorno_automatico(
							$VendedorEmail, $TransacaoID, $Referencia, $TipoFrete, $ValorFrete,
							$Anotacao, $DataTransacao, $TipoPagamento, $StatusTransacao, $CliNome,
							$CliEmail, $CliEndereco, $CliNumero, $CliComplemento, $CliBairro,
							$CliCidade, $CliEstado, $CliCEP, $CliTelefone, $produtos, $NumItens
							){
	global $db, $log;

    $order = $db->query('SELECT * FROM `' . DB_PREFIX . 'order` WHERE order_id = ' . $Referencia);
    $StatusTransacao = normaliza($StatusTransacao);

	switch($StatusTransacao){
		case 'Aguardando Pagto' :
			$order_status_id = 10200;
			break;
			
		case 'Em Analise' :
			$order_status_id = 10201;
			break;
			
		case 'Aprovado' :
			$order_status_id = 10202;
			break;
			
		case 'Cancelado' :
			$order_status_id = 10203;
			break;
			
		case 'Completo' :
			$order_status_id = 10204;
			break;
			
		case 'Devolvido' :
			$order_status_id = 10205;
			break;
			
		default:
			$order_status_id = 10206;
	}

	$log -> setLog('order_status_id : ' . $order_status_id . "\n");
	
	$db->query('UPDATE `' . DB_PREFIX . 'order` SET `order_status_id` = ' . $order_status_id . ' WHERE `order_id` = ' . $Referencia);
	$db->query("INSERT INTO `" . DB_PREFIX . "order_history` VALUES (NULL , '" . $Referencia . "', '" . $order_status_id . "', '0', '', NOW());");	
}
function createLog($confirma) {

	global $log;
	
	$log -> setLog($confirma ? 'ValidacaoPOST : VERIFICADO' . "\n" : 'ValidacaoPOST : FALSO' . "\n");
	$log -> createlog();
}
?>

