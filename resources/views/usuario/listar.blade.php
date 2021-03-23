@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Cadastrar Usuário</h1>
@stop

@section('content')
    <div class="container">
        <a href="{{ route ('usuario.create')}}" class="btn btn-primary mb-4 ">Cadastrar Usuário</a>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Sobrenome</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Tipo</th>
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
        console.log('Hi!');

    </script>
@stop
