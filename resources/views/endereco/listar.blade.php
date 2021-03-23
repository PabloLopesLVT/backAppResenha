@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Cadastrar Endereço</h1>
@stop

@section('content')
    <div class="container">
        <a href="{{ route ('endereco.create')}}" class="btn btn-primary mb-4 ">Cadastrar Endereço</a>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Logradouro</th>
                    <th scope="col">Nº</th>
                    <th scope="col">Bairro</th>
                    <th scope="col">Município</th>
                    <th scope="col">Estado</th>
                    <th scope="col">CEP</th>
                    <th scope="col">Complemento</th>
                </tr>
            </thead>
            <tbody>
                @if ($enderecos)
                    @foreach ($enderecos as $endereco)
                        <tr>
                            <td>{{ $endereco->id }}</td>
                            <td>{{ $endereco->logradouro }}</td>
                            <td>{{ $endereco->numero}}</td>
                            <td>{{ $endereco->bairro }}</td>
                            <td>{{ $endereco->municipio }}</td>
                            <td>{{ $endereco->estado }}</td>
                            <td>{{ $endereco->cep }}</td>
                            <td>{{ $endereco->complemento }}</td>
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
