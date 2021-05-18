@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="rounded bg-warning font-weight-bold mb-4 p-2 h5">Cadastro do Sócio</div>
@stop

@section('content')
    <form method="POST"
          action={{!isset($companyMember->id) ? route('company-member.store') : route('company-member.update', $companyMember->id)   }}>

        @csrf
        @if(isset($companyMember->id))
            @method('PUT')
        @endif
        <input type="hidden" name="id" value="{{ $companyMember->id ?? '' }}">
        <div class="container-fluid">
            <div class="alert alert-{{ $status ?? '' }} ">{{ $msg ?? '' }}</div>
            <div class="row shadow p-3 mb-5 bg-white rounded">
                <div class="font-weight-bold mb-4 p-2 h5 col-12">Dados do Sócio</div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="document">CPF</label>
                        <input type="text" value="{{ $companyMember->document ?? old('document') }}" class="form-control" id="document"
                               name="document" placeholder="000.000.000-00" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="name">Nome do Sócio</label>
                        <input type="text" value="{{ $companyMember->name ?? old('name') }}"
                               class="form-control"
                               id="name" name="name" placeholder="José da Silva" required>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="birthDate">Data de Nascimento</label>
                        <input type="date" value="{{ $companyMember->birthDate ?? old('birthDate') }}"
                               class="form-control"
                               id="birthDate" name="birthDate"  required>
                    </div>
                </div>

                <div class="col-12 ">
                    <button type="submit" class="btn btn-success btn-block"><i class="fas fa-plus"></i>CADASTRAR
                    </button>
                </div>
            </div>



        </div>
    </form>
    <div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px;"><img
            src='{{ asset('img/loading.gif') }}' width="64" height="64"/><br>Carregando..
    </div>

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

        $('#cpf').mask('000.000.000-00');

    </script>
@stop
