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
        <table class="table table-hover table-striped" id="myTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th scope="col">Nome do Produto</th>
                    <th scope="col">Valor da Empresa</th>
                    <th scope="col">Valor de Venda</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Ações</th>

                </tr>
            </thead>
            <tbody>
                @if ($produtoEmpresas)
                    @foreach ($produtoEmpresas as $produtoEmpresa)
                        <tr>
                            <td>{{$produtoEmpresa->idpe}}</td>
                            <td>{{$produtoEmpresa->nome}}</td>
                            <td>R$ {{$produtoEmpresa->valor1}}</td>
                            <td>R$ {{$produtoEmpresa->valor2}}</td>
                            <td>{{$produtoEmpresa->quantidade}}</td>
                            <td><a href="{{ route('produtoEmpresa.editar', $produtoEmpresa->idpe) }}"><i class="fas fa-user-edit"></i></a>
                                <a href="{{ route('produtoEmpresa.destroy', $produtoEmpresa->idpe) }}"><i
                                        class="fas fa-user-times"></i></a>
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
