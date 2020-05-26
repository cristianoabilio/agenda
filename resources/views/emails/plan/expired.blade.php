<html>
    <body>
        <p>Olá {{ $company }}</p>
        <p></p>
        <p>Veja os planos expirados hoje ({{$today}}).</p>
        <p></p>
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Aluno</th>
                <th scope="col">Plano</th>
                <th scope="col">Saldo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($plans as $p)
                <tr>
                    <th scope="row">{{ $p->user->id }}</th>
                    <td>{{ $p->user->name }}</td>
                    <td>{{ $p->plan->name }}</td>
                    <td>{{ $p->available }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p>Att, <br>
        <a href="http://www.gymmate.com.br" title="www.gymmate.com.br">Gym Mate!</a></p>
    </body>
</html>