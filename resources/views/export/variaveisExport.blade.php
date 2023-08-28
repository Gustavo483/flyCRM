<table class="table table-striped">
    <thead>
    <tr>
        <th>Tipo informação</th>
        <th>Nome</th>
        <th>Id de referência</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($dados as $dado)
        <tr>
            <td>{{ $dado[0] }}</td>
            <td>{{ $dado[1] }}</td>
            <td>{{ $dado[2] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
