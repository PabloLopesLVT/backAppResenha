@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Cadastrar Conta Bancária</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="alert alert-{{ $status ?? '' }} ">{{ $msg ?? '' }}</div>

        <a href="{{ route ('bank-account.create')}}" class="btn btn-primary btn-block mb-4 "><i class="fas fa-user-plus"></i> Cadastrar Nova Conta Bancária</a>
        <table class="table table-hover table-striped" id="myTable">
            <thead>
            <tr>
                <th scope="col">Número do Banco</th>
                <th scope="col">Agência</th>
                <th scope="col">Nº de Conta</th>
                <th scope="col">Número Complementar</th>
                <th scope="col">Tipo</th>
                <th scope="col">Nome do Responsável</th>
                <th scope="col">Documento</th>
                <th scope="col">Ações</th>
            </tr>
            </thead>
            <tbody>
            @if ($bankAccounts)
                @foreach ($bankAccounts as $bankAccount)
                    <tr>
                        <td>{{ $bankAccount->bankNumber }}</td>
                        <td>{{ $bankAccount->agencyNumber }}</td>
                        <td>{{ $bankAccount->accountNumber}}</td>
                        <td>{{ $bankAccount->accountComplementNumber }}</td>
                        <td>{{ $bankAccount->accountType }}</td>
                        <td>{{ $bankAccount->accountHolderName }}</td>
                        <td>{{ $bankAccount->accountHolderCPF }}</td>
                       <td><a href="{{ route('bank-account.update', $bankAccount->id) }}"><i class="fas fa-user-edit"></i></a>  <a
                                href="{{ route('bank-account.destroy', $bankAccount->id) }}"><i class="fas fa-user-times"></i></a></td>
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
