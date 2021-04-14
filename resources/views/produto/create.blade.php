@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="rounded bg-warning font-weight-bold mb-4 p-2 h5">Cadastrar Produto</div>

@stop

@section('content')
    <form method="POST" action={{ route('produto.store') }} enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $produto->id ?? '' }}">
        <div class="container-fluid ">
            <div class="alert alert-{{ $status ?? '' }} ">{{ $msg ?? '' }}</div>
            <div class="row shadow p-3 mb-5 bg-white rounded">
                <div class="font-weight-bold mb-4 p-2 h5 col-12">Dados do Produto</div>
                <div class="col-md-3">
                    <div class="form-group mx-auto text-center">
                        <input type="file" id="cropped_image3" class="image">
                        <img id="cropped_image2" width="200" src="{{ asset('img/Produto-sem-Imagem-por-Enquanto.jpg') }}"
                            class="image  mx-auto">
                        <input type="hidden" id="cropped_image4" name="imagem" class="image">
                        <label for='cropped_image3' class=" mt-3 btn btn-success  text-center"
                            id="label_seleciona_arquivo">Adicionar
                            Imagem</label>
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
                            <input type="text" value="{{ $produto->marca ?? old('marca') }}" class="form-control"
                                id="marca" name="marca" placeholder="Marca do Produto" required>
                        </div>
                    </div>
                    <div class="col-12 ">
                        <div class="form-group">
                            <label for="status">Ativo</label>
                            <select class="form-control" name="status">
                                <option value="1">Ativo</option>
                                <option value="0">Desativado</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 ">
                        <div class="form-group">
                            <label for="categoria">Categoria</label>
                            <select class="form-control" name="categoria" required>
                                <option value="">Selecione</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-12 ">
                <button type="submit" class="btn btn-success btn-block"><i class="fas fa-plus"></i> CADASTRAR</button>
            </div>
            <div class="">&nbsp;</div>


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

        input[type='file'] {
            display: none
        }

        .label_seleciona_arquivo {
            background-color: #3498db;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            margin: 10px;
            padding: 6px 20px;

        }

    </style>
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" />

@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>

    <script>
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
            $("#cropped_image2").attr("src", canvas.toDataURL("image/png"));
            $("#cropped_image").attr("src", canvas.toDataURL("image/png"));
            $("#cropped_image4").val(canvas.toDataURL("image/png"));
            $modal.modal('hide');
            /*   canvas.toBlob(function(blob) {
                   url = URL.createObjectURL(blob);
                   var reader = new FileReader();
                   reader.readAsDataURL(blob);
                   reader.onloadend = function() {
                       var base64data = reader.result;
                       $.ajax({
                           type: "POST",
                           headers: {
                               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                           },
                           url: "crop-image-upload",
                           success: function(data) {
                               $modal.modal('hide');
                               alert("Crop image successfully uploaded");
                           }
                       });
                   }
               })*/
        });

    </script>
@stop
