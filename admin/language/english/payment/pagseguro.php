<?php
/**
 * Tradução da área administrativa do módulo
 *
 * @author ldmotta - ldmotta@gmail.com
 * @link motanet.com.br
 */

// Heading
$_['heading_title']      = 'PagSeguro';

// Text
$_['text_payment']		 = 'Payment';
$_['text_success']       = 'Parabéns! Você acaba de configurar o PagSeguro em sua loja!';
$_['text_pagseguro']	 = '<a href="https://pagseguro.uol.com.br" title="PagSeguro" target="_blank"><img src="view/image/payment/pagseguro.png" alt="PagSeguro" title="PagSeguro" border="0" /></a>';
$_['text_enabled']       = 'Habilitado';
$_['text_disabled']      = 'Desabilitado';

// Butons
$_['button_cancel']      = 'Cancelar';
$_['button_save']        = 'Salvar';

$_['error_permission']   = 'Você não ter permissões suficientes para editar este método de pagamento.';

// Labels
$_['lb_mail']            = 'Seu e-mail no PagSeguro';
$_['lb_token']           = 'TOKEN (opcional)';
$_['lb_sort_order']      = 'Ordem na lista';
$_['lb_status']          = 'Status';

// Instructions
$_['instructions_title'] = 'Instruções';
$_['instructions_info']  = <<<EOF
== Calculo de Frete ==

Entre no site do [https://pagseguro.uol.com.br PagSeguro] e entre com seu usuário e senha.

Entre no menu *Meus Dados* e acesse, em *Configuração de Checkout*, a opção *Preferências Web e frete*.

Na *Definição de Cálculo do frete* deixe a opção *Fete fixo com desconto* marcada, e configure o 
*Valor do frete para itens extra* definido como *0,00* conforme a figura.

[img:pagseguro-frete.png]

O cálculo do frete será gerado pelo OpenCart conforme definido no seu shipping method.

== Retorno automático ==

Entre no site do [https://pagseguro.uol.com.br PagSeguro] e entre com seu usuário e senha cadastrados.

Acesse a página de *Retorno automático* através do menu *Meus dados* em *Configuração checkout*.

Na opção de URL de retorno, ative a url de retorno e digite a seguinte url para retorno.

<pre>http://[URL_DO_SEU_SITE]/obrigado.php</pre>

No segundo passo, ainda na tela de *Retorno automático*, peça para gerar uma chave de segurança,
ou seja, um código *TOKEN* e copie-o para a tela de configurações.
EOF;
