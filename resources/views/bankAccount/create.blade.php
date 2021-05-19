@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="rounded bg-warning font-weight-bold mb-4 p-2 h5">Cadastrar Conta Bancária</div>
@stop

@section('content')

    <form method="POST"
          action={{!isset($bankAccount->id) ? route('bank-account.store') : route('bank-account.update', $bankAccount->id)   }}>


        @csrf
        @if(isset($bankAccount->id))
             @method('PUT')
        @endif
        <input type="hidden" name="id" value="{{ $bankAccount->id ?? '' }}">
        <div class="containEndereçoer-fluid">
            <div class="alert alert-{{ $status ?? '' }} ">{{ $msg ?? '' }}</div>
            <div class="row shadow p-3 mb-5 bg-white rounded">
                <div class="col-12  font-weight-bold mb-4 p-2 h5">Dados Bancários</div>
                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label for="cep">Número do Banco</label>
                        <input type="text" value="{{ $bankAccount->bankNumber ?? old('bankNumber') }}"
                               class="form-control" id="bankNumber"
                               name="bankNumber" required>
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label for="logradouro">Agência</label>
                        <input type="text" value="{{ $bankAccount->agencyNumber ?? old('agencyNumber') }}"
                               class="form-control"
                               id="agencyNumber" name="agencyNumber" required>
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label for="numero">Nº da Conta</label>
                        <input type="text" value="{{ $bankAccount->accountNumber ?? old('accountNumber') }}"
                               class="form-control"
                               id="accountNumber" name="accountNumber" required>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="accountComplementNumber">Número Complementar (Caixa)</label>
                        <input type="text"
                               value="{{ $bankAccount->accountComplementNumber ?? old('accountComplementNumber') }}"
                               class="form-control"
                               id="accountComplementNumber" name="accountComplementNumber">
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="accountType">Tipo da Conta</label>
                        <select name="accountType" class="form-control">
                            <option value="CHECKING">Conta Corrente</option>
                            <option value="SAVINGS">Poupança</option>

                        </select>
                    </div>
                </div>

                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label for="accountHolderName">Nome do Titular</label>
                        <input type="text"
                               value="{{ $bankAccount->accountHolderName ?? old('accountHolderName') }}"
                               class="form-control" id="accountHolderName" name="accountHolderName">
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label for="accountHolderCPF">CPF do Titular</label>
                        <input type="text"
                               value="{{ $bankAccount->accountHolderCPF ?? old('accountHolderCPF') }}"
                               class="form-control" id="accountHolderCPF" name="accountHolderCPF">
                    </div>
                </div>
                <div class="col-12 ">
                    <button type="submit" class="btn btn-success btn-block "><i class="fas fa-edit"></i>Cadastrar
                    </button>
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
        $('#bankNumber').mask('000');
        $('#cep').mask('00000-000');
    </script>
@stop
