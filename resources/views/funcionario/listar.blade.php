@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Funcionário</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="alert alert-{{ $status ?? '' }} ">{{ $msg ?? '' }}</div>
        <a href="{{ route ('funcionario.create')}}" class="btn btn-block btn-primary mb-4 "><i class="fas fa-user-plus"></i> Cadastrar Novo Funcionário</a>
        <table class="table table-hover table-striped" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Sobrenome</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Função</th>
                    <th scope="col">Ações</th>

                </tr>
            </thead>
            <tbody>
                @if ($funcionarios)
                    @foreach ($funcionarios as $funcionario)
                        <tr>
                            <td>{{ $funcionario->nome }}</td>
                            <td>{{ $funcionario->sobrenome}}</td>
                            <td>{{ $funcionario->email }}</td>
                            <td>{{ $funcionario->cpf }}</td>
                            <td>{{ $funcionario->funcao }}</td>
                            <td><a href="{{ route('funcionario.editar', $funcionario->id) }}"><i class="fas fa-user-edit"></i></a>  <a
                                href="{{ route('funcionario.destroy', $funcionario->id) }}"><i class="fas fa-user-times"></i></a></td>
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
