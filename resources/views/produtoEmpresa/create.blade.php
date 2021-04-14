@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="rounded bg-warning font-weight-bold mb-4 p-2 h5">Cadastrar Meus Produtos</div>

@stop

@section('content')

    <div class="container-fluid ">
        <div class="alert alert-{{ $status ?? '' }} ">{{ $msg ?? '' }}</div>

        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome do Produto</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @if ($produtos)
                    @foreach ($produtos as $produto)
                        <tr>
                            <th scope="row">{{ $produto->id }}</th>
                            <td><a href="#"><span data-nome="{{ $produto->nome }}" data-id="{{ $produto->id }}"
                                        class="produto">
                                        {{ $produto->nome }}</span></a></td>

                            <td>

                                <input class="checkbox" id="check{{ $produto->id }}" data-id="{{ $produto->id }}"
                                    type="hidden">



                                <div id="status{{ $produto->id }}"></div>
                            </td>
                        </tr>

                    @endforeach
            </tbody>
        </table>

        @endif
    </div>

    <div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px;"><img
            src='{{ asset('img/loading.gif') }}' width="64" height="64" /><br>Carregando..</div>
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
    <style>
        .card-title {
            font-size: 2.1rem !important;
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
            for (var i = 1; i < {{ $produto->id }} + 1; i++) {
                produto_id = $('#check' + i).attr('data-id')
                console.log(produto_id)
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "/statusprodutoEmpresa/" + produto_id,
                    success: function(response) {
                        console.log(response)
                        if (response.message == 1) {
                            console.log(response.id)
                            $('.checkbox').prop('checked')
                            $('#status'+response.id).html('Ativo')
                        }else{
                            $('#status'+response.id).html('Desativado')
                        }

                    },
                    error: function(response) {
                        console.error(response)
                    }
                })
            }
        });





        $('.produto').click(function() {
            nomeProduto = $(this).attr('data-nome')
            idproduto = $(this).attr('data-id')
            console.log(nomeProduto)
            Swal.fire({
                title: nomeProduto,
                html: `   <div class="form-group">
                                                <label for="valor1">Valor</label>
                                                    <input type="text" class="money form-control" id="valor1" name="valor1" placeholder="R$ 00,00">
                                                    <small id="" class="form-text text-muted">Preço de Venda da Empresa</small>
                                                    </div>
                                                    <div class="form-group">
                                                    <label for="valor2">Valor do Aplicativo </label>
                                                    <input type="text" class="money form-control" id="valor2" name="valor2"
                                                    placeholder="R$ 00,00" readonly>
                                                    <small id="" class="form-text text-muted">Preço de Venda no Aplicativo</small>
                                                    </div>
                                                    <div class="form-group">
                                                    <label for="quantidade">Quantidade</label>
                                                    <input type="number" class=" form-control" id="quantidade" name="quantidade" placeholder="">
                                                    <small id="valor" class="form-text text-muted">Quantidade em Estoque</small>
                                                    </div>`,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Salvar',

                onOpen: (value) => {
                    $('.money').maskMoney();
                    $('#valor1').keyup(function() {
                        val = $(this).val() * 1.5
                        val = val.toFixed(2);
                        $('#valor2').val(val)
                    })

                },
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        var valor1 = $("#valor1").val();
                        var valor2 = $("#valor2").val();
                        var quantidade = $("#quantidade").val();

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            }
                        });
                        console.log("idproduto" + idproduto, "valor1" + valor1, "valor2" +
                            valor2, "quantidade" + quantidade)
                        $.ajax({
                            url: "{{ route('produtoEmpresa.store') }}",
                            type: "post",

                            data: {
                                produto_id: idproduto,
                                valor1: valor1,
                                valor2: valor2,
                                quantidade: quantidade,
                                empresa_id: "{{ $empresa->id }}"
                            },
                            success: function(response) {
                                console.log(response.message)
                            //    console.log(response.message.errorInfo[0])
                                if (response.message ===
                                    'Registro salvo com sucesso!') {
                                    Swal.fire(
                                        'Meus Produtos!',
                                        'Produto vinculado com sucesso!',
                                        'success'
                                    ).then( res =>{
                                        location.reload()
                                    })

                                } else if (response.message.errorInfo[0] ===
                                    "23000") {
                                    Swal.fire(
                                        'Meus Produtos!',
                                        'Esse produto já está vinculado!',
                                        'error'
                                    )
                                }
                            },
                            error: function(response) {

                                Swal.fire(
                                    'Meus Produtos!',
                                    'Produto não foi vinculado!',
                                    'error'
                                )
                            }
                        })

                    })
                }


            })
        })

    </script>
@stop
