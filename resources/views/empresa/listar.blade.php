@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Empresa</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="alert alert-{{ $status ?? '' }} ">{{ $msg ?? '' }}</div>
        <a href="{{ route ('empresa.create')}}" class="btn btn-primary mb-4 "><i class="fas fa-user-plus"></i></a>
        <table class="table table-hover table-striped" id="myTable">
            <thead>
                <tr>
                    <th scope="col">nomeEmpresa</th>
                    <th scope="col">cnpj</th>
                    <th scope="col">email</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Cidade</th>
                    <th scope="col">Ações</th>

                </tr>
            </thead>
            <tbody>
                @if ($empresas)
                    @foreach ($empresas as $empresa)
                        <tr>
                            <td>{{ $empresa->nomeEmpresa }}</td>
                            <td>{{ $empresa->cnpj }}</td>
                            <td>{{ $empresa->email}}</td>
                            <td>{{ $empresa->estado }}</td>
                            <td>{{ $empresa->municipio}}</td>
                            <td><a href="{{ route('empresa.editar', $empresa->idempresa) }}"><i class="fas fa-user-edit"></i></a>  <a
                                href="{{ route('empresa.destroy', $empresa->idempresa) }}"><i class="fas fa-user-times"></i></a></td>
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
