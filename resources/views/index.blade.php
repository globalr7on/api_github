<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>API Repositorios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css"/>
  </head>
  <body>

    <h1>Meus Repositorios!</h1>
    <input type="text">Nome do usuario </input>
    <table id="myForm">
    <thead>
    <tr>
        <th scope="col">Name</th>
        <th scope="col">Url</th>
        <th scope="col">Commit</th>
        <th scope="col">Archived</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($repositories as $values)
    <tr>
        <td>  {{ $values['name']}}</td>
        <td>  {{ $values['url'] }}</td>
        <td> {{ $values['commit'] }}</td>
        <td> 
            @if  ($values['archived'] === true ) 
                Arquivado
            @else
                Ativo 
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
        $('#myForm').DataTable( {
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Brazil.json"
            }
        } );
    } );
    </script>
</body>
</html>