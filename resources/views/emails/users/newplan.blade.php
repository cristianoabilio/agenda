<html>
    <body>
        <p>Olá {{ $name }}!</p>
        <p></p>
        <p>Você adquiriu um novo plano em {{ $company }}.</p>
        <p>Seu saldo atual agora é {{ $available }}</p>
        <p></p>
        <p>Dados do plano</p>
        <p>Créditos: {{ $total }}</p>
        <p>Vencimento: {{ $validate }}</p>
        <p>Valor: {{ $price }}</p>
        <p></p>
        <p>Att, <br>
        <a href="http://www.gymmate.com.br" title="www.gymmate.com.br">Gym Mate!</a></p>
    </body>
</html>