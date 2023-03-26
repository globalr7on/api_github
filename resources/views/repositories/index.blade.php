<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App para obter os repositorios no github</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        .form-group {
            display: inline-block;
            margin-right: 20px;
            vertical-align: top;
        }

        label {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
        }

        select,
        input[type="text"] {
            padding: 5px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        select,
        input[type="date"] {
            padding: 5px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .btn-filter {
            padding: 5px 10px;
            font-size: 16px;
            border-radius: 3px;
            background-color: #0663B5;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn-reset {
            padding: 5px 10px;
            font-size: 16px;
            border-radius: 3px;
            background-color: #BB0404;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn-filter:hover {
            background-color: #268CE7;
        }
        .btn-reset:hover {
            background-color: #F11C1C;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #0663B5;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            padding: 2px 16px;
        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }

        .card {
            color: red;
            
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            width: 40%;
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            flex: 1 1 200px;
            max-width: 200px;
        }
    </style>
</head>
<body>
    <h1>Meus repositórios no GitHub</h1>
    <p>Programado por: Victor Hugo Ramirez Henriquez</p>
    <p>CPF:709.413.992-65</p>
    <h6>Version 1.0</h6>

    
    
    <form action="{{ route('repositories.index') }}" method="get">
        <div class="form-group">
            <label for="private">Privado ou Público:</label>
            <select name="private" id="private" class="form-control">
                <option value="">Nenhum</option>
                <option value="private" @if(request('private') === 'private') selected @endif>Privado</option>
                <option value="public" @if(request('private') === 'public') selected @endif>Público</option>
            </select>
        </div>    
        <div class="form-group">
            <label for="filter">Filtrar por:</label>
            <select name="filter" id="filter" class="form-control">
                <option value="">Nenhum</option>
                <option value="archived" @if(request('filter') === 'archived') selected @endif>Arquivados</option>
                <option value="not_archived" @if(request('filter') === 'not_archived') selected @endif>Não arquivados</option>
            </select>
        </div>

        <div class="form-group">
        <label for="sort">Ordenar por:</label>
        <select name="sort" id="sort" class="form-control">
            <option value="">Nenhum</option>
            <option value="name_asc" @if(request('sort') === 'name_asc') selected @endif>Nome (A-Z)</option>
            <option value="name_desc" @if(request('sort') === 'name_desc') selected @endif>Nome (Z-A)</option>
            <option value="last_commit_asc" @if(request('sort') === 'last_commit_asc') selected @endif>Último commit (antigos primeiro)</option>
            <option value="last_commit_desc" @if(request('sort') === 'last_commit_desc') selected @endif>Último commit (novos primeiro)</option>
        </select>
    </div>
    
    
    <div class="form-group">
        <label for="search">Pesquisar por nome ou linguagem :</label>
        <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}">
    </div>

    <div class="form-group">
        <label for="since">Mostrar repositorios Desde:</label>
        <input type="date" name="since" id="since" value="{{ request('since') }}" class="form-control">
    </div>

    <div class="form-group">
        <label for="until">Mostrar repositorios Hasta:</label>
        <input type="date" name="until" id="until" value="{{ request('until') }}" class="form-control">
    </div>

    <button type="submit" class="btn btn-filter">Filtrar</button>
    <button type="reset" class="btn btn-reset">Reiniciar</button>

</form>
<div class="card-container">
    <div class="card">
        <p>Total de Repositorios: {{ $counts['total'] }}</p>
    </div>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Linguagem</th>
            <th>Tipo</th>
            <th>Arquivado</th>
            <th>Data do último commit</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1 @endphp
        @foreach ($repositories as $repository)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $repository['name'] }}</td>
                <td>{{ $repository['description'] }}</td>
                <td>{{ $repository['language'] }}</td>
                @if ($repository['private'] == 1)
                <td>Privado</td>
                @else
                <td>Público</td>
                @endif
                @if ($repository['archived'] == 1)
                <td>Sim</td>
                @else
                <td>Não</td>
                @endif
                <td>{{ \Carbon\Carbon::parse($repository['pushed_at'])->format('d/m/Y H:i:s') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
