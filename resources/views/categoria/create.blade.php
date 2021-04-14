@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="rounded bg-warning font-weight-bold mb-4 p-2 h5">Cadastro de Categoria</div>
@stop

@section('content')
    <form method="POST" action={{ route('categoria.store') }}>
        @csrf
        <input type="hidden" name="id" value="{{ $categoria->id ?? '' }}">

        <div class="container-fluid">
            <div class="alert alert-{{ $status ?? '' }} ">{{ $msg ?? '' }}</div>
            <div class="row shadow p-3 mb-5 bg-white rounded">
                <div class="font-weight-bold mb-4 p-2 h5 col-12">Dados da Categoria</div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" value="{{ $categoria->nome ?? old('nome') }}" class="form-control" id="nome"
                            name="nome" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="icone">Ícone</label>
                        <input type="text" value="{{ $categoria->icone ?? old('icone') }}" class="form-control"
                            id="icone" name="icone" required>
                    </div>
                </div>

                <div class="col-12 ">
                    <button type="submit" class="btn btn-success btn-block"><i class="fas fa-plus"></i>CADASTRAR</button>
                </div>
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

    </script>
@stop
