@extends('components.basicComponent')

@section('titulo', 'DashboarRoot')

@section('content')
    <div class="">
        <div class="posicaoDiv w-100">
            <div class="NavbarAdmimHoot">
                @include('layouts.navBarUser')
            </div>
            <div class="container">
                <div>
                    @include('layouts.sucessoErrorRequest')
                </div>
                <div>
                    <div class="d-flex justify-content-end">
                        <!-- Button trigger modal -->
                        <button type="button" class="BtnCriarLeads" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="black" viewBox="0 0 640 512">
                                <path
                                    d="M72 88a56 56 0 1 1 112 0A56 56 0 1 1 72 88zM64 245.7C54 256.9 48 271.8 48 288s6 31.1 16 42.3V245.7zm144.4-49.3C178.7 222.7 160 261.2 160 304c0 34.3 12 65.8 32 90.5V416c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V389.2C26.2 371.2 0 332.7 0 288c0-61.9 50.1-112 112-112h32c24 0 46.2 7.5 64.4 20.3zM448 416V394.5c20-24.7 32-56.2 32-90.5c0-42.8-18.7-81.3-48.4-107.7C449.8 183.5 472 176 496 176h32c61.9 0 112 50.1 112 112c0 44.7-26.2 83.2-64 101.2V416c0 17.7-14.3 32-32 32H480c-17.7 0-32-14.3-32-32zm8-328a56 56 0 1 1 112 0A56 56 0 1 1 456 88zM576 245.7v84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM320 32a64 64 0 1 1 0 128 64 64 0 1 1 0-128zM240 304c0 16.2 6 31 16 42.3V261.7c-10 11.3-16 26.1-16 42.3zm144-42.3v84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM448 304c0 44.7-26.2 83.2-64 101.2V448c0 17.7-14.3 32-32 32H288c-17.7 0-32-14.3-32-32V405.2c-37.8-18-64-56.5-64-101.2c0-61.9 50.1-112 112-112h32c61.9 0 112 50.1 112 112z"/>
                            </svg>
                        </button>
                    </div>
                    @include('components.userComponents.CadastrarLead')
                </div>
                <main>
                    <div id="projeto-id" style="display: none">{{$id_empresa}}</div>
                    @csrf
                    <section>
                        @foreach ($columns as $column)
                            <article data-column-id="{{ $column->id_columnsKhanban }}">
                                <div class="coluna-head">
                                    <label class="coluna-head3" style="background:{{$column->st_color}}">{{ $column->st_titulo }}</label>
                                </div>

                                <div class="coluna-body">
                                    @foreach ($column->leads as $leads)
                                        <div class="tarefa bg" data-position="{{ $leads->int_posicao }}" data-id="{{ $leads->id_lead }}" draggable="true">
                                            <div class="nome">{{ $leads->st_nome }}</div>
                                        </div>
                                    @endforeach

                                    <div class="coluna-footer"></div>
                                </div>
                            </article>
                        @endforeach
                    </section>
                </main>

                <div class="mt-5">
                    @include('components.userComponents.infos')
                </div>

                <div class="d-flex">
                    <div class="w-25">
                        <div class="divGhafhcs2 mt-5">
                            <canvas id="divGhafhcsStatus"></canvas>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-around align-items-center">
                    <div class="divGhafhcs mt-5">
                        <canvas id="chartLeads15Dias"></canvas>
                    </div>
                    <div class="divGhafhcs2 mt-5">
                        <canvas id="divGhafhcsFases"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('js/board.js')}}"></script>
    <script>
        const leadsUltimosQuinzeDias = {!!  $graphics['leadsUltimosQuinzeDias'] !!};
        const chartLeads15Dias = document.getElementById('chartLeads15Dias');
        new Chart(chartLeads15Dias, {
            type: 'line',
            data: {
                datasets: [
                    {
                        label: 'Leads 15 dias',
                        data: JSON.parse(leadsUltimosQuinzeDias)
                    }]
            },
            options: {
                parsing: {
                    xAxisKey: 'day',
                    yAxisKey: 'qnt'
                }
            }
        });

        const divGhafhcsFases = document.getElementById('divGhafhcsFases');
        new Chart(divGhafhcsFases, {
            type: 'doughnut',
            data: {
                labels: [{!! $labelsFases!!}],
                datasets: [
                    {
                        label: 'Quantidade',
                        data: [{!! $dataFases!!}],
                    }]
            }
        });

        const divGhafhcsStatus = document.getElementById('divGhafhcsStatus');
        new Chart(divGhafhcsStatus, {
            type: 'doughnut',
            data: {
                labels: [{!! $labelsStatus!!}],
                datasets: [
                    {
                        label: 'Quantidade',
                        data: [{!! $dataStatus!!}],
                }]
            }
        });
    </script>
@endsection


