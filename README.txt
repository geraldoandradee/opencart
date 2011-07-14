=== Módulo de integração PagSeguro + Opencart ===
Contributors: 
    ldmotta(visie.com.br - Implementação do múdulo da visie),
	DGMike (virgula.uol.com.br - Desenvolvedor do módulo pgs.),
	Flavio Sena (pagseguro.uol.com.br - Ajustes retorno automático, registro em db, cosméticos.)
Donate link: http://motanet.com.br/
Tags: pagseguro, opencart
Module version: 1.0.5.2
Tested up to: Opencart v1.5.0.5
Requires at least: 1.0.5.2
Stable tag: 1.5.0.5

Módulo de integração do Opencart com o Pagseguro

== Description ==

Permite que o OpenCart utilize o meio de pagamento PagSeguro, de forma fácil e intuitiva, contém todas as
ferramentas necessárias a esta integração.


Algumas notas sobre as seções acima:

*   "Contributors" Lista de contribuidores para construção do módulo separados por vírgula
*   "Tags" É uma lista separada por vírgulas de tags que se aplicam ao plugin
*   "Requires at least" É a menor versão do plugin que irá trabalhar em
*   "Tested up to" É a versão mais alta do e-commerce utilizado com sucesso para testar o plugin *. Note-se que ele pode trabalhar em
versões superiores ... Este é apenas um mais alto que foi verificado.

== Installation ==

Passos para instalação

1. Descompacte o módulo na raiz da sua instalação do OpenCart
2. Instale o módulo na sesão Extensions -> Payment na área administrativa do OpenCart
3. Ative o módulo da página de edição do módulo em Extensions -> Payment -> Edit
4. Defina a url de retorno no site do pagseguro (https://pagseguro.uol.com.br/preferences/automaticReturn.jhtml) como:
   "http://seu_dominio.com.br/retorno.php"
5. Execute o arquivo ps_db_install.php para atualizar as tabelas de status no banco de dados
6. Dê permissão de escrita ao arquivo ps.txt

== Perguntas Frequentes ==

= Eu posso instalar o meu módulo sem ter conhecimentos de php ou qualquer linguagem de programação? =

Pode, você só precisa ter conhecimentos em transferência de dados via FTP ou SFTP, ter os dados de acesso
ao servidor onde está hospedado a sua aplicação, e ter um gerenciador de arquivos FTP como o FileZilla
(http://filezilla-project.org/). Entretanto, recomendamos enfaticamente que procure um técnico da área.

= O módulo não funcionou na minha loja, o que fazer? =

Se já verificou a versão da sua loja virtual e ela e a versão testada com o módulo, e ainda assim não funciona,
entre em contato com o desenvolvedor atravéz do endereço http://motanet.com.br.

== Screenshots ==

== Changelog ==
= 1.0.5.2 =
* Correção do erro de JSON no checkout
* Implementando o admin para selecionar o status das novas transações

= 1.0.5.1 =
* Corrigido a model para funcionar com produtos que tenham atributos ou opções

= 1.0.5 =
* Corrigido a incompatibilidade com a versão 1.5.0.5 do OpenCart
* O OpenCart utiliza agora o método title da classe document como private,
sendo acessível apenas pelo getTitle() ou setTitle()

= 1.0.4 =
* Corrigido o retorno automático e documentação de instalação, havia um erro na 
query de seleção do pedido para atualização de status.

= 1.0.3 =
* Atualizando o status e histórico do pedido com base no retorno automático
* Modificações cosméticas (botão de pagamento, retorno);
* Ajustes na gravação do pedido em banco ao iniciar a transação.

= 1.0.2 =
* Verificando a Referência da transação e atualizando o status do pedido na loja do usuário.

= 1.0.1 =
* Aplicação dos métodos de redirect() utilizados na nova versão do OpenCart.

== Arbitrary section ==

== A brief Markdown Example ==


Para maiores informações acesse http://motanet.com.br, http://visie.com.br/pagseguro
