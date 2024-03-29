@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="rounded bg-warning font-weight-bold mb-4 p-2 h5">Cadastro de Usuários</div>
@stop

@section('content')
    <form method="POST" action={{ route('usuario.store') }}>
        @csrf
        <input type="hidden" name="id" value="{{ $usuario->id ?? '' }}">
        <input type="hidden" name="idendereco" value="{{ $endereco->id ?? '' }}">
        <div class="container-fluid">
            <div class="alert alert-{{ $status ?? '' }} ">{{ $msg ?? '' }}</div>
            <div class="row shadow p-3 mb-5 bg-white rounded">
                <div class="font-weight-bold mb-4 p-2 h5 col-12">Dados do Usuário</div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" value="{{ $usuario->nome ?? old('nome') }}" class="form-control" id="nome"
                            name="nome" placeholder="Rua xx, nº" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="sobrenome">Sobrenome</label>
                        <input type="text" value="{{ $usuario->sobrenome ?? old('sobrenome') }}" class="form-control"
                            id="sobrenome" name="sobrenome" placeholder="Rua xx" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" value="{{ $usuario->email ?? old('email') }}" class="form-control" id="email"
                            name="email" placeholder="usuario@email.com" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="cpf">CPF</label>
                        <input type="text" value="{{ $usuario->cpf ?? old('cpf') }}" class="form-control" id="cpf"
                            name="cpf" placeholder="" required>
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <select class="form-control" name="tipo">
                            <option value="" selected>Selecione</option>
                            <option value="1">Administrador</option>
                            <option value="2">Cliente</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row shadow p-3 mb-5 bg-white rounded">
                <div class="col-12  font-weight-bold mb-4 p-2 h5">Endereço do Usuário</div>
                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label for="cep">CEP</label>
                        <input type="text" value="{{ $endereco->cep ?? old('cep') }}" class="form-control" id="cep"
                            name="cep" placeholder="" required>
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="form-group">
                        <label for="logradouro">Logradouro</label>
                        <input type="text" value="{{ $endereco->logradouro ?? old('logradouro') }}" class="form-control"
                            id="logradouro" name="logradouro" placeholder="Rua xx, nº" required >
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label for="numero">Nº</label>
                        <input type="text" value="{{ $endereco->numero ?? old('numero') }}" class="form-control"
                            id="numero" name="numero" placeholder="Rua xx" required >
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select class="form-control"  name="estado" id="estado" required >
                            <option selected value="{{ $endereco->estado ?? old('estado') }}">{{ $endereco->estado ?? 'Selecione' }}</option>
                            <option value="AC">Acre</option>
                            <option value="AL">Alagoas</option>
                            <option value="AP">Amapá</option>
                            <option value="AM">Amazonas</option>
                            <option value="BA">Bahia</option>
                            <option value="CE">Ceará</option>
                            <option value="DF">Distrito Federal</option>
                            <option value="ES">Espírito Santo</option>
                            <option value="GO">Goiás</option>
                            <option value="MA">Maranhão</option>
                            <option value="MT">Mato Grosso</option>
                            <option value="MS">Mato Grosso do Sul</option>
                            <option value="MG">Minas Gerais</option>
                            <option value="PA">Pará</option>
                            <option value="PB">Paraíba</option>
                            <option value="PR">Paraná</option>
                            <option value="PE">Pernambuco</option>
                            <option value="PI">Piauí</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="RN">Rio Grande do Norte</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="RO">Rondônia</option>
                            <option value="RR">Roraima</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="SP">São Paulo</option>
                            <option value="SE">Sergipe</option>
                            <option value="TO">Tocantins</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="municipio">Município</label>
                        <input type="text" value="{{ $endereco->municipio ?? old('municipio') }}" class="form-control"
                            id="municipio" name="municipio" placeholder="" required >
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="bairro">Bairro</label>
                        <input type="text" value="{{ $endereco->bairro ?? old('bairro') }}" class="form-control"
                            id="bairro" name="bairro" placeholder="" required >
                    </div>
                </div>

                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label for="complemento">Complemento</label>
                        <input type="text" value="{{ $endereco->complemento ?? old('complemento') }}"
                            class="form-control" id="complemento" name="complemento" placeholder=""  >
                    </div>
                </div>
                <div class="col-12 ">
                    <div class="form-group">
                        <label for="observacoes">Observações</label>
                        <textarea class="form-control"   id="observacoes" name="observacoes" rows="3" placeholder="Digite observações se necessário.">{{ $endereco->observacoes ?? old('observacoes') }}</textarea>
                    </div>
                </div>
                <div class="col-12 ">
                    <button type="submit" class="btn btn-success btn-block"><i class="fas fa-plus"></i> Cadastrar</button>
                </div>
            </div>
        </div>
    </form>
    <div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px;"><img src='{{ asset('img/loading.gif')}}' width="64" height="64" /><br>Carregando..</div>
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
        $('#cep').mask('00000-000');
        $('#cpf').mask('000.000.000-00');
        $('#cep').blur(function(){
            $.ajax({
                url: "https://viacep.com.br/ws/"+$('#cep').val()+"/json/",
                dataType: 'json'
            })
            .done(function(data) {
                console.log(data);
                $('#logradouro').val(data.logradouro);
                $('#bairro').val(data.bairro);
                $('#estado').val(data.uf);
                $('#complemento').val(data.complemento);
                $('#municipio').val(data.localidade);


            })
            .fail(function(jqXHR, textStatus, msg) {
                alert(msg);
            });
        })
$(document).ajaxStart(function(){
    $("#wait").css("display", "block");
  });
  $(document).ajaxComplete(function(){
    $("#wait").css("display", "none");
  });
    </script>
@stop
