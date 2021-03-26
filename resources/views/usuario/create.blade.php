@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Cadastrar Usuários</h1>
@stop

@section('content')
<form method="POST" action={{ route('usuario.store') }}>
        @csrf
        <input type="hidden" name="id" value="{{ $usuario->id ?? '' }}">
        <div class="container">
            <div class="alert alert-{{$status ?? ''}} ">{{$msg ?? ''}}</div>
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" value="{{ $usuario->nome ?? old('nome') }}" class="form-control" id="nome" name="nome" placeholder="Rua xx, nº" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="sobrenome">Sobrenome</label>
                        <input type="text" value="{{ $usuario->sobrenome ?? old('sobrenome') }}" class="form-control" id="sobrenome" name="sobrenome" placeholder="Rua xx" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" value="{{ $usuario->email ?? old('email') }}" class="form-control" id="email" name="email" placeholder="usuario@email.com" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="cpf">CPF</label>
                        <input type="text" value="{{ $usuario->cpf ?? old('cpf') }}" class="form-control" id="cpf" name="cpf" placeholder="" required>
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <select class="form-control" name="tipo">
                            <option value="" selected>Selecione</option>
                            <option value="1" >Administrador</option>
                            <option value="2" >Cliente</option>
                          </select>
                    </div>
                </div>
                <div class="col-12 col-md-12">
                    <div class="form-group">
                        <label for="endereco">Endereço</label>
                        <select class="form-control" value="{{ $usuario->endereco  ?? old('endereco') }}" name="endereco">
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
       $('#cpf').mask('000.000.000-00');

    </script>
@stop
