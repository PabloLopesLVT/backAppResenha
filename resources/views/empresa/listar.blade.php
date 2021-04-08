@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Lista de Empresas</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="alert alert-{{ $status ?? '' }} ">{{ $msg ?? '' }}</div>
        <a href="{{ route('empresa.create') }}" class="btn btn-block btn-primary mb-4 "><i class="far fa-building"></i>
            Cadastrar Nova Empresa</a>
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
                            <td>{{ $empresa->email }}</td>
                            <td>{{ $empresa->estado }}</td>
                            <td>{{ $empresa->municipio }}</td>
                            <td><a href="{{ route('empresa.editar', $empresa->idempresa) }}"><i
                                        class="fas fa-user-edit"></i></a> <a class="deletar"
                                    data-id="{{ $empresa->idempresa }}"
                                    data-nomeempresa="{{ $empresa->nomeEmpresa }}"><i class="fas fa-user-times"></i></a>
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
    <style>
        .remove{
            color:red;
        }
        </style>
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

        $('.deletar').click(function() {
            id = $(this).attr('data-id')
            nomeEmpresa = $(this).attr('data-nomeempresa')
            Swal.fire({
                title: '<strong class="remove"> REMOVER EMPRESA </strong>',
                html:
                    `<div class="h5"> Você realmente deseja remover a empresa
                     <strong class=" font-weight-bolder">
                     ${nomeEmpresa} </strong> </div>`,
                showCancelButton: true,
                confirmButtonText: `Deletar`,
                input: 'text',
                inputLabel: 'Password',
                inputAttributes: {
                    autocapitalize: 'off',
                    autocorrect: 'off'
                },
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "",
                        type: "get",
                        success: function(response) {
                            console.log(response)
                            Swal.fire('Saved!', '', 'success')
                        },
                        error: function(response) {
                            console.error(response)
                            Swal.fire('Error!', '', 'danger')
                        }
                    })
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })




        })

    </script>
@stop
