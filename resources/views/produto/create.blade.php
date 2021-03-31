@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Cadastrar Produto</h1>
@stop

@section('content')
    <form method="POST" action={{ route('produto.store') }} enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $produto->id ?? '' }}">
        <div class="container-fluid">
            <div class="alert alert-{{ $status ?? '' }} ">{{ $msg ?? '' }}</div>
            <div class="row">

                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" value="{{ $produto->nome ?? old('nome') }}" class="form-control" id="nome"
                            name="nome" placeholder="Nome do Produto" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="marca">Marca</label>
                        <input type="text" value="{{ $produto->marca ?? old('marca') }}" class="form-control"
                            id="marca" name="marca" placeholder="Marca do Produto" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="status">Ativo</label>
                        <select class="form-control" name="status">
                            <option value="1">Ativo</option>
                            <option value="2">Desativado</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Enviar imagem do produto</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-default btn-file">
                                    Browse… <input type="file" id="imagem" name="imagem" >
                                </span>
                            </span>
                            <input type="text" class="form-control" readonly>
                        </div>
                        <img id='img-upload'/>
                    </div>
                </div>
                <div class="col-12 ">
                    <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
                </div>
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
<style>
    .btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}

#img-upload{
    width: 100%;
}
    </style>
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
                $('#logradouro').val(data.logradouro).prop('disabled', false);
                $('#bairro').val(data.bairro).prop('disabled', false);
                $('#estado').val(data.uf).prop('disabled', false);
                $('#complemento').val(data.complemento).prop('disabled', false);
                $('#municipio').val(data.localidade).prop('disabled', false);
                $('#numero').prop('disabled', false);


            })
            .fail(function(jqXHR, textStatus, msg) {
                alert(msg);
            });
        })

//Loading do AJAX
$(document).ajaxStart(function(){
    $("#wait").css("display", "block");
  });
  $(document).ajaxComplete(function(){
    $("#wait").css("display", "none");
  });
  //---------------------------
  $(document).on('change', '.btn-file :file', function() {
		var input = $(this),
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [label]);
		});

		$('.btn-file :file').on('fileselect', function(event, label) {

		    var input = $(this).parents('.input-group').find(':text'),
		        log = label;

		    if( input.length ) {
		        input.val(log);
		    } else {
		        if( log ) alert(log);
		    }

		});
		function readURL(input) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();

		        reader.onload = function (e) {
		            $('#img-upload').attr('src', e.target.result);
		        }

		        reader.readAsDataURL(input.files[0]);
		    }
		}

		$("#imagem").change(function(){
		    readURL(this);
		});
    </script>
@stop
