@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Empresa</h1>
@stop

@section('content')
    <div class="container">
        <a href="{{ route ('endereco.create')}}" class="btn btn-primary mb-4 ">Cadastrar Endereço</a>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">nomeEmpresa</th>
                    <th scope="col">email</th>
                    <th scope="col">cnpj</th>
                    <th scope="col">Logradouro</th>

                </tr>
            </thead>
            <tbody>
                @if ($empresas)
                    @foreach ($empresas as $empresa)
                        <tr>
                            <td>{{ $empresa->id }}</td>
                            <td>{{ $empresa->nomeEmpresa }}</td>
                            <td>{{ $empresa->email}}</td>
                            <td>{{ $empresa->cnpj }}</td>
                            <td>{{ $empresa->logradouro }}</td>

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
