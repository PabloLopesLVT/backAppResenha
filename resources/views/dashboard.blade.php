@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-3 ">
                <div class="font-weight-bold h5 text-center p-3 border rounded caixa-superior">
                    Estabelecimentos Fechados
                    <div class="font-weight-bold h1 text-center">60</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="font-weight-bold h5 text-center p-3 border rounded caixa-superior">
                    Estabelecimentos Abertos
                    <div class="font-weight-bold h1 text-center">60</div>
                </div>
            </div>

            <div class="col-md-3 ">
                <div class="font-weight-bold h5 text-center p-3 border rounded caixa-superior">
                    Quantidade de pedido no mês
                    <div class="font-weight-bold h1 text-center">60</div>
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="font-weight-bold h5 text-center p-3 border rounded caixa-superior">
                    Quantidade de pedido HOJE
                    <div class="font-weight-bold h1 text-center">60</div>
                </div>
            </div>
        </div>
        <div class="row border rounded m-0">
            <div class="col-md-8">
                <div class="p-2">
                    <div class="h4">Detalhemento de pedidos</div>
                    <legend>as of 25 May 2019, 09:41 PM</legend>
                    <canvas id="myChart" width="400" height="220"></canvas>
                </div>
            </div>
            <div class="col-md-4 border-left">
                <div class="border-bottom p-3">
                    <div class="text-center h5">Abertos</div>
                    <div class="text-center font-weight-bold">16</div>
                </div>
                <div class="border-bottom p-3">
                    <div class="text-center h5">Entregues</div>
                    <div class="text-center font-weight-bold">42</div>
                </div>
                <div class="border-bottom p-3">
                    <div class="text-center h5">Tempo médio de entrega</div>
                    <div class="text-center font-weight-bold">42</div>
                </div>
                <div class="border-bottom p-3">
                    <div class="text-center h5">Média de pedidos por hora</div>
                    <div class="text-center font-weight-bold">42</div>
                </div>
                <div class="border-bottom p-3">
                    <div class="text-center h5">Satisfação do cliente</div>
                    <div class="text-center font-weight-bold">94%</div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="p-3 mt-4 border rounded">
                    <div class="row">
                        <div class="col-9 font-weight-bold">
                            Últimos pedidos
                        </div>
                        <div class="col-3">
                            <a href="#">Ver Todos</a>
                        </div>
                    </div>
                    <div class="row pt-3 pl-3 pr-3">
                        <table class="table table-hover  " style="width:100%">
                            <tr>
                                <td class="td-ult-pedidos">Anisio Pablo Lopes de Oliveira</td>
                                <td class="coluna-hora-valor td-ult-pedidos">187,50</td>
                                <td class="coluna-hora-valor td-ult-pedidos">19:30</td>
                            </tr>
                            <tr>
                                <td class="td-ult-pedidos">Hudson Amaral</td>
                                <td class="coluna-hora-valor td-ult-pedidos">55,70</td>
                                <td class="coluna-hora-valor td-ult-pedidos">18:10</td>
                            </tr>
                            <tr>
                                <td class="td-ult-pedidos">Julio Cesar Gomes</td>
                                <td class="coluna-hora-valor td-ult-pedidos">98,00</td>
                                <td class="coluna-hora-valor td-ult-pedidos">17:47</td>
                            </tr>
                            <tr>
                                <td class="td-ult-pedidos">Carla Souza Santos</td>
                                <td class="coluna-hora-valor td-ult-pedidos">32,00</td>
                                <td class="coluna-hora-valor td-ult-pedidos">17:30</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="pt-3 pl-3 pr-3 mt-4 border rounded">
                    <div class="row">
                        <div class="col-9 font-weight-bold">
                            Reclamações / Suporte
                        </div>
                        <div class="col-3">
                            <a href="#">Ver Todos</a>
                        </div>
                    </div>
                    <div class="pt-3 pl-1 pr-1">
                        <table class="table table-hover  ">
                            <tr>
                                <td class="td-reclamacao">
                                    <div class="">Meu pedido está demorando</div>
                                    <legend>24/03/2021 (hoje)</legend>
                                </td>

                                <td class="text-right"><span class="bg-warning p-1 rounded">CLIENTE</span></td>
                            </tr>
                            <tr>
                                <td class="td-reclamacao">
                                    <div class="">Não consigo cadastrar meu cartão.</div>
                                    <legend>24/03/2021 (Ontem)</legend>
                                </td>

                                <td class="text-right"><span class="bg-success p-1 rounded">COMERCIANTE</span></td>
                            </tr>
                            <tr>
                                <td class="td-reclamacao">
                                    <div class="">Dificuldade para fazer o saque.</div>
                                    <legend>24/03/2021 (Há 3 Dias)</legend>
                                </td>

                                <td class="text-right"><span class="bg-warning p-1 rounded">CLIENTE</span></td>
                            </tr>
                            <tr>
                                <td class="td-reclamacao">
                                    <div class="">Cliente cancelou pedido na porta da casa.</div>
                                    <legend>24/03/2021 (Há 4 Dias)</legend>
                                </td>

                                <td class="text-right"><span class="bg-success p-1 rounded">COMERCIANTE</span></td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-3"></div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

    </script>
@stop
