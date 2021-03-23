@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Empresas</h1>
@stop

@section('content')
    <form method="POST" action={{ route('empresa.store') }}>
        @csrf
        <div class="container">
            <div class="alert alert-{{ $status ?? '' }} ">{{ $msg ?? '' }}</div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="nomeEmpresa">Nome da Empresa</label>
                        <input type="text" class="form-control" id="nomeEmpresa" name="nomeEmpresa" placeholder="Rua xx, nº"
                            required>
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="usuario@email.com"
                            required>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="cnpj">CNPJ</label>
                        <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="" required>
                    </div>
                </div>
                <div class="col-12 col-md-12">
                    <div class="form-group">
                        <label for="endereco">Endereço</label>
                        <select class="form-control" name="endereco">
                            <option value="" selected>Selecione</option>
                            @if ($enderecos)
                                @foreach ($enderecos as $endereco)
                                    <option value="{{ $endereco->id }}">{{ $endereco->logradouro }},
                                        {{ $endereco->numero }} - {{ $endereco->estado }} - {{ $endereco->municipio }} -
                                        {{ $endereco->bairro }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-12 ">
                    <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
                </div>
            </div>
        </div>
    </form>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');

    </script>
@stop
