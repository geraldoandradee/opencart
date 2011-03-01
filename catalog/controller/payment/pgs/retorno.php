<?php
if (!defined('TOKEN')) define ('TOKEN', '');

class RetornoPagSeguro {

	function _preparaDados($post, $confirmacao = true) {
	
		if ('array' !== gettype($post)) $post = array();
		
		if ($confirmacao){
			$post['token'] = TOKEN;
			$post['Comando'] = 'validar';
		}
		
		$retorno = array();
		
		foreach ($post as $key => $value){
		
			if('string' !== gettype($value)) $post[$key] = '';
			$value = urlencode(stripslashes($value));
			$retorno[] = "{$key}={$value}";
		}
		
		return implode('&', $retorno);
	}
	
	function _tipoEnvio() {
	
		global $_retPagSeguroErrNo, $_retPagSeguroErrStr;
		
		if (function_exists('curl_exec'))
			return array('curl', 'https://pagseguro.uol.com.br/Security/NPI/Default.aspx');
			
		elseif ((PHP_VERSION >= 4.3) && ($fp = @fsockopen('ssl://pagseguro.uol.com.br', 443, $_retPagSeguroErrNo, $_retPagSeguroErrStr, 30)))
			return array('fsocket', '/Security/NPI/Default.aspx', $fp);
			
		elseif ($fp = @fsockopen('pagseguro.uol.com.br', 80, $_retPagSeguroErrNo, $_retPagSeguroErrStr, 30))
			return array('fsocket', '/Security/NPI/Default.aspx', $fp);
			
		return array ('', '');
	}
	
	function not_null($value) {
	
		if (is_array($value)) {
		
			if (sizeof($value) > 0) {			
				return true;
				
			} else {
				return false;				
			}
			
		} else {
			if (($value != '') && (strtolower($value) != 'null') && (strlen(trim($value)) > 0)) {
				return true;
			} else {
				return false;
			}
		}
	}
	
	function verifica($post, $tipoEnvio = false) {
	
	    global $_retPagSeguroErrNo, $_retPagSeguroErrStr;
		
		if ('array' !== gettype($tipoEnvio))
			$tipoEnvio = RetornoPagSeguro::_tipoEnvio();
			
		$spost = RetornoPagSeguro::_preparaDados($post);
		
		if (!in_array($tipoEnvio[0], array('curl', 'fsocket')))
			return false;
			
		$confirma = false;
		
		if ($tipoEnvio[0] === 'curl') {
		
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $tipoEnvio[1]);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $spost);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$resp = curl_exec($ch);
			
			if (!RetornoPagSeguro::not_null($resp)) {
				curl_setopt($ch, CURLOPT_URL, $tipoEnvio[1]);
				$resp = curl_exec($ch);
			}
			
			curl_close($ch);
			
			$confirma = (strcmp ($resp, 'VERIFICADO') == 0);
			
		} elseif ($tipoEnvio[0] === 'fsocket') {
		
			if (!$tipoEnvio[2]) {
				die ("{$_retPagSeguroErrStr} ($_retPagSeguroErrNo)");
				
			} else {
				$cabecalho = "POST {$tipoEnvio[1]} HTTP/1.0\r\n";
				$cabecalho .= "Content-Type: application/x-www-form-urlencoded\r\n";
				$cabecalho .= "Content-Length: " . strlen($spost) . "\r\n\r\n";
				
				$resp = '';
				
				fwrite ($tipoEnvio[2], "{$cabecalho}{$spost}");
				
				while (!feof($tipoEnvio[2])) {
				
					$resp = fgets ($tipoEnvio[2], 1024);
					
					if (strcmp ($resp, 'VERIFICADO') == 0) {
						$confirma = (strcmp ($resp, 'VERIFICADO') == 0);
						$confirma = true;
						break;
					}
				}
				
				fclose ($tipoEnvio[2]);
			}
		}
		if ($confirma && function_exists('retorno_automatico')) {
		
			$itens = array (
							'VendedorEmail', 'TransacaoID', 'Referencia', 'TipoFrete',
							'ValorFrete', 'Anotacao', 'DataTransacao', 'TipoPagamento',
							'StatusTransacao', 'CliNome', 'CliEmail', 'CliEndereco',
							'CliNumero', 'CliComplemento', 'CliBairro', 'CliCidade',
							'CliEstado', 'CliCEP', 'CliTelefone', 'NumItens',
							);
							
			foreach ($itens as $item) {
				if (!isset($post[$item])) $post[$item] = '';
				
				if ($item=='ValorFrete') $post[$item] = str_replace(',', '.', $post[$item]);
			}
			
			$produtos = array ();			
			
			for ($i=1;isset($post["ProdID_{$i}"]);$i++) {
			
				$produtos[] = array (
									'ProdID'          => $post["ProdID_{$i}"],
									'ProdDescricao'   => $post["ProdDescricao_{$i}"],
									'ProdValor'       => (double) (str_replace(',', '.', $post["ProdValor_{$i}"])),
									'ProdQuantidade'  => $post["ProdQuantidade_{$i}"],
									'ProdFrete'       => (double) (str_replace(',', '.', $post["ProdFrete_{$i}"])),
									'ProdExtras'      => (double) (str_replace(',', '.', $post["ProdExtras_{$i}"])),
								);
			}
			
			retorno_automatico (
								$post['VendedorEmail'], $post['TransacaoID'], $post['Referencia'],
								$post['TipoFrete'], $post['ValorFrete'], $post['Anotacao'], $post['DataTransacao'],
								$post['TipoPagamento'], $post['StatusTransacao'], $post['CliNome'], $post['CliEmail'],
								$post['CliEndereco'], $post['CliNumero'], $post['CliComplemento'], $post['CliBairro'],
								$post['CliCidade'], $post['CliEstado'], $post['CliCEP'], $post['CliTelefone'],
								$produtos, $post['NumItens']
								);
		}
		
		if (function_exists('createLog')) {
			createLog($confirma);
		}
		
		return $confirma;
	}
}

if ($_POST) {
  RetornoPagSeguro::verifica($_POST);
  
  die();
}


?>
