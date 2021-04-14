@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Listar Produtos</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="alert alert-{{ $status ?? '' }} ">{{ $msg ?? '' }}</div>
        <a href="{{ route('produto.create') }}" class="btn btn-block btn-primary mb-4 "><i
                class="fas fa-user-plus"></i>Cadastrar Novo Produto</a>
        <table class="table table-hover table-striped" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Imagem</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Ativar/Desativar</th>

                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @csrf
                @if ($produtos)
                    @foreach ($produtos as $produto)
                        <tr>
                            <td><img width="50" src="{{ asset('storage/produtos/' . $produto->imagem) }}" /> </td>
                            <td>{{ $produto->nome }}</td>
                            <td>{{ $produto->marca }}</td>
                            <td><label class="switch">
                                @if ($produto->status )
                                <input class="checkbox" data-id="{{ $produto->id }}"  type="checkbox" checked>
                                <span class="slider round"></span>
                                @else
                                <input class="checkbox" data-id="{{ $produto->id }}"  type="checkbox" unchecked>
                                <span class="slider round"></span>
                                @endif

                                </label></td>

                            <td><a href="{{ route('produto.editar', $produto->id) }}"><i class="fas fa-user-edit"></i></a>
                                <a href="{{ route('produto.destroy', $produto->id) }}"><i
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

        $('.checkbox').click(function() {


                    if ($(this).is(':checked')) { //se está marcado conta mais 1
                        Swal.fire(
                            'Status Alterado!',
                            'Produto Ativado',
                            'success'
                        )
                        status = 1;
                    } else {
                        Swal.fire(
                            'Status Alterado!',
                            'Produto Desativado',
                            'warning'
                        )
                        status = 0;
                    }
                    id = $(this).attr('data-id')

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "/produto/status/" + id + "/" + status,
                        type: "post",
                        success: function(response) {
                            console.log(response)
                        },
                        error: function(response) {
                            console.error(response)
                        }
                    })
        })
    </script>
@stop
