@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Listar Meus Produtos</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="alert alert-{{ $status ?? '' }} ">{{ $msg ?? '' }}</div>
        <a href="{{ route('produtoEmpresa.create') }}" class="btn btn-block btn-primary mb-4 "><i
                class="fas fa-user-plus"></i>Cadastrar Novo Produto</a>

    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>

    </script>
@stop
