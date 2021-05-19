@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Lista de Sócios</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="alert alert-{{ $status ?? '' }} ">{{ $msg ?? '' }}</div>
        <a href="{{ route('company-member.create') }}" class="btn btn-block btn-primary mb-4 "><i class="far fa-building"></i>
            Cadastrar Novo Sócio</a>
        <table class="table table-responsive-lg table-hover table-striped" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Documento</th>
                    <th scope="col">Data de Nascimento</th>
                    <th scope="col">Ações</th>

                </tr>
            </thead>
            <tbody>
                @if ($companyMembers)
                    @foreach ($companyMembers as $companyMember)
                        <tr>
                            <td>{{ $companyMember->name }}</td>
                            <td>{{ $companyMember->document }}</td>
                            <td>{{ $companyMember->birthDate }}</td>
                            <td><a href="{{ route('company-member.update', $companyMember->id) }}"><i
                                        class="fas fa-user-edit"></i></a> <a class="deletar"
                                    data-id="{{ $companyMember->id }}"
                                    data-name="{{ $companyMember->name }}"><i class="fas fa-user-times"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        .remove {
            color: red;
        }

    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                }
            });
        });

        $('.deletar').click(function() {
            id = $(this).attr('data-id')
            nameCompanyMember = $(this).attr('data-name')
            Swal.fire({
                title: '<strong class="remove"> REMOVER SÓCIO </strong>',
                html: `<div class="h5"> Você realmente deseja remover o Sócio
                                                         <strong class=" text-dark h4 font-weight-bolder">
                                                         ${nameCompanyMember}? </strong>

                                                         <div class="mt-5">Digite o nome do Sócio</div>
                                                         </div>`,
                showCancelButton: true,
                confirmButtonText: 'REMOVER SÓCIO',
                confirmButtonColor: '#d33',

                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off',
                    autocorrect: 'off'
                },
            }).then((result) => {
                console.log(result);
                /* Read more about isConfirmed, isDenied below */
                console.log(result.value === nameCompanyMember)
                if (result.value === nameCompanyMember) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '/deletarCompanyMember/' + id,
                        type: "get",
                        success: function(response) {
                            console.log(response)
                            Swal.fire({
                                icon: 'success',
                                title: 'Sócio Apagado',
                                confirmButtonText: 'Ok',
                            }).then((result) => {
                                location.reload();
                            })
                        },
                        error: function(response) {
                            console.error(response)
                            Swal.fire('Error!', '', 'danger')
                        }
                    })
                } else if(result.dismiss === "cancel") {
                    console.log(result.value === "undefined")

                }else if(result.value != nameCompanyMember){
                    Swal.fire('Nome do Sócio incorreto', '', 'error')
                }
            })




        })

    </script>
@stop
