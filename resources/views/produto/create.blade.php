@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="rounded bg-warning font-weight-bold mb-4 p-2 h5">Cadastrar Produto</div>

@stop

@section('content')
    <form method="POST" action={{ route('produto.store') }} enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $produto->id ?? '' }}">
        <div class="container-fluid">
            <div class="alert alert-{{ $status ?? '' }} ">{{ $msg ?? '' }}</div>
            <div class="row shadow p-3 mb-5 bg-white rounded">
                <div class="font-weight-bold mb-4 p-2 h5 col-12">Dados do Produto</div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Enviar imagem do produto</label>
                        <input type="file" name="image" class="image">

                        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel">Laravel Cropper Js - Crop Image Before
                                            Upload - Tutsmake.com</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="img-container">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="preview"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary" id="crop">Crop</button>
                                    </div>
                                </div>
                            </div>
                        </div>




            </div>
        </div>
        <div class="col-md-6">
            <div class="col-12 ">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" value="{{ $produto->nome ?? old('nome') }}" class="form-control" id="nome"
                        name="nome" placeholder="Nome do Produto" required>
                </div>
            </div>
            <div class="col-12 ">
                <div class="form-group">
                    <label for="marca">Marca</label>
                    <input type="text" value="{{ $produto->marca ?? old('marca') }}" class="form-control" id="marca"
                        name="marca" placeholder="Marca do Produto" required>
                </div>
            </div>
            <div class="col-12 ">
                <div class="form-group">
                    <label for="status">Ativo</label>
                    <select class="form-control" name="status">
                        <option value="1">Ativo</option>
                        <option value="2">Desativado</option>
                    </select>
                </div>
            </div>
        </div>


        <div class="col-12 ">
            <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
        </div>
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
    <style>
        img {
            display: block;
            max-width: 100%;
        }

        .preview {
            overflow: hidden;
            width: 160px;
            height: 160px;
            margin: 10px;
            border: 1px solid red;
        }

        .modal-lg {
            max-width: 1000px !important;
        }

    </style>
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" />

@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>

    <script>
        $('#cep').mask('00000-000');
        $('#cpf').mask('000.000.000-00');
        $('#cep').blur(function() {
            $.ajax({
                    url: "https://viacep.com.br/ws/" + $('#cep').val() + "/json/",
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
        $(document).ajaxStart(function() {
            $("#wait").css("display", "block");
        });
        $(document).ajaxComplete(function() {
            $("#wait").css("display", "none");
        });


        var $modal = $('#modal');
        var image = document.getElementById('image');
        var cropper;
        $("body").on("change", ".image", function(e) {
            var files = e.target.files;
            var done = function(url) {
                image.src = url;
                $modal.modal('show');
            };
            var reader;
            var file;
            var url;
            if (files && files.length > 0) {
                file = files[0];
                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function(e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
        $modal.on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
        });
        $("#crop").click(function() {
            canvas = cropper.getCroppedCanvas({
                width: 160,
                height: 160,
            });
            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result;
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "{{ route("produto.create") }}",

                        data: {
                            '_token': $('meta[name="_token"]').attr('content'),
                            'image': base64data
                        },
                        success: function(data) {
                            console.log(data);
                            $modal.modal('hide');
                            alert("Crop image successfully uploaded");
                        }
                    });
                }
            });
        })

    </script>
@stop
