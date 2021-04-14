@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Lista de Categorias</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="alert alert-{{ $status ?? '' }} ">{{ $msg ?? '' }}</div>
        <a href="{{ route('categoria.create') }}" class="btn btn-block btn-primary mb-4 "><i class="fas fa-filter"></i>
            Cadastrar Categoria</a>
        <table class="table table-hover table-striped" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Ícone</th>
                    <th scope="col">Ações</th>

                </tr>
            </thead>
            <tbody>
                @if ($categorias)
                    @foreach ($categorias as $categoria)
                        <tr>
                            <td>{{ $categoria->nome }}</td>
                            <td>{{ $categoria->icone }}</td>

                            <td><a href="{{ route('categoria.editar', $categoria->id) }}"><i
                                        class="fas fa-user-edit"></i></a> <a href="{{ route('categoria.destroy', $categoria->id) }}" class="deletar"><i class="fas fa-user-times"></i></a>
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
    <style>
        .remove {
            color: red;
        }

    </style>
@stop

@section('js')
    <script>

$(document).ready(function() {
            $('#myTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                }
            });
        });
    </script>
@stop
