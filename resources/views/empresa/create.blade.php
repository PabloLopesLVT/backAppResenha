@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="rounded bg-warning font-weight-bold mb-4 p-2 h5">Cadastro de Empresa</div>
@stop

@section('content')
    <form method="POST"
          action={{!isset($empresa->id) ? route('empresa.store') : route('empresa.update', $empresa->id)   }}>

        @csrf
        @if(isset($empresa->id))
            @method('PUT')
        @endif
        <input type="hidden" name="id" value="{{ $empresa->id ?? '' }}">
        <input type="hidden" name="idendereco" value="{{ $endereco->id ?? '' }}">
        <div class="container-fluid">
            <div class="alert alert-{{ $status ?? '' }} ">{{ $msg ?? '' }}</div>
            <div class="row shadow p-3 mb-5 bg-white rounded">
                <div class="font-weight-bold mb-4 p-2 h5 col-12">Dados da Empresa</div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="cnpj">CNPJ</label>
                        <input type="text" value="{{ $empresa->cnpj ?? old('cnpj') }}" class="form-control" id="cnpj"
                               name="cnpj" placeholder="00.000.000/0001-00" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="razaoSocial">Razão Social</label>
                        <input type="text" value="{{ $empresa->razaoSocial ?? old('razaoSocial') }}"
                               class="form-control"
                               id="razaoSocial" name="razaoSocial" placeholder="Razão social da empresa" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="nomeEmpresa">Nome da Empresa</label>
                        <input type="text" value="{{ $empresa->nomeEmpresa ?? old('nomeEmpresa') }}"
                               class="form-control"
                               id="nomeEmpresa" name="nomeEmpresa" placeholder="Rua xx, nº" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="businessArea">Área de Negócios</label>
                        <select name="businessArea" class="form-control">
                            <option>Selecione</option>
                            @if ($businessAreas)
                                @foreach ($businessAreas as $businessArea)
                                    <option value="{{$businessArea->code}}">{{$businessArea->category}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="typeCompany">Tipo da Empresa</label>
                        <select name="typeCompany" class="form-control">
                            <option>Selecione</option>
                            @if ($typeCompanys)
                                @foreach ($typeCompanys as $typeCompany)
                                    <option value="{{$typeCompany}}">{{$typeCompany}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="responsavel">Responsável</label>
                        <input type="text" value="{{ $empresa->responsavel ?? old('responsavel') }}"
                               class="form-control"
                               id="responsavel" name="responsavel" placeholder="Nome completo do responsável" required>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="telefone">Telefone</label>
                        <input type="text" value="{{ $empresa->celular ?? old('celular') }}" class="form-control"
                               id="telefone" name="telefone" placeholder="(00) 9 0000-0000" required>
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label for="cnae">CNAE</label>
                        <input type="text" value="{{ $empresa->cnae ?? old('cnae') }}" class="form-control"
                               id="cnae" name="cnae"  required>
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label for="monthlyIncomeOrRevenue">Renda Mensal</label>
                        <input type="text" value="{{ $empresa->monthlyIncomeOrRevenue ?? old('monthlyIncomeOrRevenue') }}" class="form-control"
                               id="monthlyIncomeOrRevenue" name="monthlyIncomeOrRevenue"  required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" value="{{ $empresa->email ?? old('email') }}" class="form-control"
                               id="email"
                               name="email" placeholder="usuario@email.com" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="establishmentDate">Data da Criação da Empresa</label>
                        <input type="date" value="{{ $legalRepresentative->birthDate ?? old('birthDate') }}"
                               class="form-control"
                               id="establishmentDate" name="establishmentDate" placeholder="00/00/0000" required>
                    </div>
                </div>
                <div class="col-12 ">
                    <div class="form-group">
                        <label for="linesOfBusiness">Linha de negócio da empresa (Máximo de 100 Caracteres)</label>
                        <textarea maxlength="100" class="form-control" id="linesOfBusiness" name="linesOfBusiness"
                                  rows="3"
                                  placeholder="Define a linha de negócio da empresa (Máximo de 100 Caracteres).">{{ $empresa->linesOfBusiness ?? old('linesOfBusiness') }}</textarea>
                    </div>
                </div>
                <small>ATENÇÃO: Os dados de acesso a plataforma serão enviados para o e-mail informado.</small>
            </div>
            <div class="row shadow p-3 mb-5 bg-white rounded">
                <div class="font-weight-bold mb-4 p-2 h5 col-12">Representante Legal</div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="documentRepresentante">CPF</label>
                        <input type="text" value="{{ $legalRepresentative->document ?? old('document') }}"
                               class="form-control" id="cnpj"
                               name="document" placeholder="000.000.000-00" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="name">Nome do Representante Legal</label>
                        <input type="text" value="{{ $legalRepresentative->name ?? old('razaoSocial') }}"
                               class="form-control"
                               id="name" name="name" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="birthDate">Data de Nascimento</label>
                        <input type="date" value="{{ $legalRepresentative->birthDate ?? old('nomeEmpresa') }}"
                               class="form-control"
                               id="birthDate" name="birthDate" placeholder="00/00/0000" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="motherName">Nome da Mãe</label>
                        <input type="text" value="{{ $legalRepresentative->motherName ?? old('responsavel') }}"
                               class="form-control"
                               id="motherName" name="motherName" placeholder="Nome completo da Mãe" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="type">Tipo</label>
                        <select name="type" class="form-control">
                            <option value="INDIVIDUAL">Individual</option>
                            <option value="ATTORNEY">Procurador</option>
                            <option value="DESIGNEE">Mandatário</option>
                            <option value="DIRECTOR">Diretor</option>
                            <option value="PRESIDENT">Presidente</option>

                        </select>
                    </div>
                </div>


                <small>ATENÇÃO: Os dados de Representante Legal devem ser conferidos.</small>
            </div>
            <div class="row shadow p-3 mb-5 bg-white rounded">
                <div class="col-12  font-weight-bold mb-4 p-2 h5">Endereço da Empresa</div>
                <div class="col-12 ">
                    <div class="form-group">
                        <label for="address">Endereço Completo</label>
                        <input type="text" class="form-control" id="address" name="address">
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label for="cep">CEP</label>
                        <input type="text" value="{{ $endereco->cep ?? old('cep') }}" class="form-control" id="cep"
                               name="cep" placeholder="00000-000" required>
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="form-group">
                        <label for="logradouro">Logradouro</label>
                        <input type="text" value="{{ $endereco->logradouro ?? old('logradouro') }}" class="form-control"
                               id="logradouro" name="logradouro" placeholder="Informe a rua, av, alameda etc" required>
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label for="numero">Nº</label>
                        <input type="text" value="{{ $endereco->numero ?? old('numero') }}" class="form-control"
                               id="numero" name="numero" placeholder="120" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select class="form-control" name="estado" id="estado" required>
                            <option selected value="">Selecione</option>
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
                               id="municipio" name="municipio" placeholder="Selecione sua cidade" required>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="bairro">Bairro</label>
                        <input type="text" value="{{ $endereco->bairro ?? old('bairro') }}" class="form-control"
                               id="bairro" name="bairro" placeholder="Digite o bairro" required>
                    </div>
                </div>

                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label for="complemento">Complemento</label>
                        <input type="text" value="{{ $endereco->complemento ?? old('complemento') }}"
                               class="form-control" id="complemento" name="complemento" placeholder="Loja 01">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="latitude">Latitude </label>
                        <input type="text" value="{{ $endereco->latitude ?? old('latitude') }}" class="form-control"
                               id="latitude" name="latitude" placeholder="">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="longitude">Longitude</label>
                        <input type="text" value="{{ $endereco->longitude ?? old('longitude') }}" class="form-control"
                               id="longitude" name="longitude" placeholder="">
                    </div>
                </div>
                <div class="col-12 ">
                    <div class="form-group">
                        <label for="observacoes">Observações</label>
                        <textarea class="form-control" id="observacoes" name="observacoes" rows="3"
                                  placeholder="Digite observações se necessário.">{{ $endereco->observacoes ?? old('observacoes') }}</textarea>
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


        var input = document.getElementById('address');

        $(function () {
            var options = {
                componentRestrictions: {
                    country: 'br'
                }
            };
            var autocomplete = new google.maps.places.Autocomplete(input, options);


            autocomplete.addListener('place_changed', function () {

                var place = autocomplete.getPlace();
                console.log(place.address_components);
                console.log(place.geometry.location.lat())
                console.log(place.geometry.location.lng())
                $('#latitude').val(place.geometry.location.lat())
                $('#longitude').val(place.geometry.location.lng())
                console.log(place.address_components[0].types[0])
                console.log(place.address_components.length)

                if (place.address_components[0].types[0] === 'street_number') {
                    for (var i = 0; i < place.address_components.length; i++) {


                        $('#numero').val(place.address_components[0].long_name);
                        place.address_components[i].types[0] === 'route' ? $('#logradouro').val(place
                            .address_components[i].long_name) : '';

                        if (place.address_components[i].types[0] === 'sublocality_level_1') {
                            $('#bairro').val(place.address_components[i].long_name);
                        }
                        if (place.address_components[i].types[0] === 'administrative_area_level_1') {
                            $('#estado').val(place.address_components[i].short_name);
                        }
                        if (place.address_components[i].types[0] === 'administrative_area_level_2') {
                            $('#municipio').val(place.address_components[i].long_name);
                        }
                        if (place.address_components[i].types[0] === 'postal_code') {
                            $('#cep').val(place.address_components[i].long_name);
                        }
                    }
                } else {
                    Swal.fire(
                        'Busca de Endereços',
                        'Faça a busca novamente com o número!',
                        'error'
                    )
                }
                if (!place.geometry) {
                    return;
                }
            });


        });
        $('#cnpj').mask('00.000.000/0000-00');
        $('#cep').mask('00000-000');
        $('#telefone').mask('(00) 0 0000-0000');
        $('#monthlyIncomeOrRevenue').maskMoney();
        $('#cnae').mask('0000-0/00');
        $(document).ajaxStart(function () {
            $("#wait").css("display", "block");
        });
        $(document).ajaxComplete(function () {
            $("#wait").css("display", "none");
        });

    </script>
@stop
