@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Cadastrar Usuário</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="alert alert-{{ $status ?? '' }} ">{{ $msg ?? '' }}</div>

        <a href="{{ route ('usuario.create')}}" class="btn btn-primary mb-4 "><i class="fas fa-user-plus"></i></a>
        <table class="table table-hover" id="myTable">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Sobrenome</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Ações</th>

                </tr>
            </thead>
            <tbody>
                @if ($usuarios)
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->nome }}</td>
                            <td>{{ $usuario->sobrenome}}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->cpf }}</td>
                            <td>{{ $usuario->tipo }}</td>
                            <td><a href="{{ route('usuario.editar', $usuario->id) }}"><i class="fas fa-user-edit"></i></a>  <a
                                href="{{ route('usuario.destroy', $usuario->id) }}"><i class="fas fa-user-times"></i></a></td>
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
        $(document).ready( function () {
            $('#myTable').DataTable({ "language": { "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json" } });
        } );

    </script>
@stop
