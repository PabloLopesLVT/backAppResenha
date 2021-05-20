@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Enviar Documentos</h1>
@stop

@section('content')
    <div class="container">
        <div class="alert alert-{{ $status ?? '' }} ">{{ $msg ?? '' }}</div>

        <a href="{{ route ('endereco.create')}}" class="btn btn-primary mb-4 "><i class="fas fa-user-plus"></i></a>
        <table class="table table-hover" id="myTable">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Tipo</th>
                <th scope="col">Descrição</th>
                <th scope="col">Status</th>
                <th scope="col">Ações</th>
            </tr>
            </thead>
            <tbody>
            @if ($documentos)
                @foreach ($documentos as $documento)
                    <tr>
                        <td>{{ $documento->id }}</td>
                        <td>{{ $documento->type }}</td>
                        <td>{{ $documento->description}}</td>
                        <td>{{ $documento->approvalStatus }}</td>

                        <td></td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $('#myTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
            }
        });

    </script>
@stop
