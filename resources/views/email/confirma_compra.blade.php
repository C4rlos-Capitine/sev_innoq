<h1>Confirmação de Compra</h1>
<p>Olá,</p>
<p>Obrigado por sua compra! Seu pedido foi recebido e está sendo processado.</p>
<p>Em breve, você receberá um e-mail de confirmação com os detalhes do seu pedido.</p>
<p>Se tiver alguma dúvida, não hesite em entrar em contato conosco.</p>
<p><strong>Detalhes do Pedido:</strong></p>
<ul>
    <li><strong>Nome:</strong> {{ $pedido['nome_completo_comprador'] }}</li>
    <li><strong>Email:</strong> {{ $pedido['email_comprador'] }}</li>
    <li><strong>Telefone:</strong> {{ $pedido['telefone_comprador'] }}</li>
    <li><strong>NUIT:</strong> {{ $pedido['nuit_comprador'] }}</li>
    <li><strong>Endereço:</strong> {{ $pedido['endereco_comprador'] }}</li>
    <li><strong>Número do Pedido:</strong> {{ $pedido['num_pedido'] }}</li>
    <li><strong>Código do Pedido:</strong> {{ $pedido['codigo_pedido'] }}</li>
    <li><strong>Data do Pedido:</strong> {{ $pedido['data_pedido'] }}</li>
    <li><strong>Total:</strong> {{ $pedido['total_amout'] }}</li>
    <li><strong>Referência:</strong> {{ $pedido['referencia'] }}</li>
    <li><strong>Entidade:</strong> {{ $pedido['entidade'] }}</li>
</ul>
<p>Obrigado!</p>