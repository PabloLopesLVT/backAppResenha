@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Lista de Documentos</h1>
@stop

@section('content')
    <div class="container">
        <div class="alert alert-{{ $status ?? '' }} ">{{ $msg ?? '' }}</div>
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

                        <td>
                            <a href="/documento-enviar/{{ $documento->id }}/{{ $documento->type }}/{{ $documento->description}}" class=" uploadArquivo btn btn-primary"><i class="fas fa-upload"></i>
                            </a>
                        </td>
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
