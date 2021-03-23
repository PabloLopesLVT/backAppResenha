@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Cadastrar Usuários</h1>
@stop

@section('content')
<form method="POST" action={{ route('usuario.store') }}>
        @csrf
        <div class="container">
            <div class="alert alert-{{$status ?? ''}} ">{{$msg ?? ''}}</div>
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Rua xx, nº" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="sobrenome">Sobrenome</label>
                        <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Rua xx" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="usuario@email.com" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="cpf">CPF</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" placeholder="" required>
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <select class="form-control" name="tipo">
                            <option value="" selected>Selecione</option>
                            <option value="1" selected>Administrador</option>
                            <option value="2" selected>Cliente</option>
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
