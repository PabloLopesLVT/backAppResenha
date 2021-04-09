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
                            <td><a href="#"><span data-id="{{ $produto->id }}" class="produto"> {{ $produto->nome }}</span></a></td>
                            <td>Otto</td>
                        </tr>

                    @endforeach
            </tbody>
        </table>

        @endif
    </div>

    <!--
     <div class="card" style="width: 18rem;">
                            <div class="card-header bg-success">
                                <div class="row">
                                    <div class="col-8">
                                    <h5 class="card-title font-weight-bold">{{ $produto->nome }}</h5>
                                </div>

                                </div>
                            </div>
                            <div class="card-body ">
                                <div class="card-text text-center ">
                                    <div class="form-group">
                                        <label for="valor">Valor</label>
                                        <input type="text" class="money form-control" id="valor" name="valor"
                                            placeholder="R$ 00,00">
                                        <small id="valor" class="form-text text-muted">Preço de Venda da Empresa</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="valor">Valor do Aplicativo </label>
                                        <input type="text" class="money form-control" id="valor2" name="valor2"
                                            placeholder="R$ 00,00" disabled>
                                        <small id="valor" class="form-text text-muted">Preço de Venda no Aplicativo</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="valor">Quantidade</label>
                                        <input type="text" class=" form-control" id="valor" name="valor" placeholder="">
                                        <small id="valor" class="form-text text-muted">Quantidade em Estoque</small>
                                    </div>
                                    <a href="#" class="btn btn-block btn-primary">Salvar</a>
                                </div>
                            </div>
                        </div>
    -->

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"
        integrity="sha512-Rdk63VC+1UYzGSgd3u2iadi0joUrcwX0IWp2rTh6KXFoAmgOjRS99Vynz1lJPT8dLjvo6JZOqpAHJyfCEZ5KoA=="
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                }
            });
        });
        $('.produto').click(function() {
                    Swal.fire(
                        'Good job!',
                        'You clicked the button!',
                        'success'
                    )
                    console.log($(this).attr('data-id'));
                })
                $('.money').maskMoney(); $('#valor').keyup(function() {
                    val = $(this).val() * 1.5
                    val.toFixed(2);
                    $('#valor2').val(val)
                })

    </script>
@stop
