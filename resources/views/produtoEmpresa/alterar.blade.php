@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="rounded bg-warning font-weight-bold mb-4 p-2 h5">Alterar o produto da empresa</div>

@stop

@section('content')
    <form method="POST" action={{ route('produtoEmpresa.store') }}>
        @csrf
        <input type="hidden" name="id" value="{{ $produtoEmpresa->id ?? '' }}">
        <input type="hidden" name="produto_id" value="{{ $produtoEmpresa->produto_id ?? '' }}">
        <input type="hidden" name="empresa_id" value="{{ $produtoEmpresa->empresa_id ?? '' }}">
        <input type="hidden" name="alterar" value="1">
        <div class="container-fluid ">
            <div class="alert alert-{{ $status ?? '' }} ">{{ $msg ?? '' }}</div>
            <div class="row shadow p-3 mb-5 bg-white rounded">
                <div class="col-12  font-weight-bold mb-4 p-2 h5">Alterar produto da empresa</div>
                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label for="quantidade">Quantidade</label>
                        <input type="text" value="{{ $produtoEmpresa->quantidade ?? old('quantidade') }}"
                            class="form-control" id="quantidade" name="quantidade" required disabled>
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label for="valor1">Valor da Empresa</label>
                        <input type="text" value="{{ $produtoEmpresa->valor1 ?? old('valor1') }}"
                            class="form-control money" id="valor1" name="valor1" required disabled>
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label for="valor2">Valor de Venda</label>
                        <input type="text" value="{{ $produtoEmpresa->valor2 ?? old('valor2') }}"
                            class="form-control money" id="valor2" name="valor2" required readonly>
                    </div>
                </div>

                <div class="col-12 ">
                    <button type="button" id="btnAlterar" class="btn btn-warning btn-block "><i
                            class="fas fa-edit"></i>Editar</button>
                    <button type="submit" id="btnEditar" class="btn btn-success btn-block btnEditar d-none"><i
                            class="fas fa-edit"></i>Editar</button>
                </div>
            </div>
        </div>
    </form>
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

@stop

@section('js')

    <script>
        $('.money').maskMoney();
        $('#valor1').keyup(function() {
            val = $(this).val() * {{ env('MULTIPLICADOR_LUCRO') }}
            val = val.toFixed(2);
            $('#valor2').val(val)
        })
        $('#btnAlterar').click(function() {
            $('#btnAlterar').addClass('d-none');
            $('#btnEditar').removeClass('d-none');

            $('#quantidade').attr('disabled', false);
            $('#valor1').attr('disabled', false);

        })

    </script>
@stop
