@extends('components.basicComponent')

@section('titulo', 'Leads')

@section('content')
    <div class="">
        <div class="posicaoDiv w-100">
            <div class="NavbarAdmimHoot">
                @include('layouts.navBarAdminUser')
            </div>
            <div class="container">
                <div>
                    @include('layouts.sucessoErrorRequest')
                </div>
                <div class="colorgray">
                    Relatórios
                </div>
                <div>
                    @include('components.adminUserComponents.relatorioFiltro')
                </div>

                <div class="d-flex justify-content-between aling-items-center mt-5">
                    <div class="divFiltroRelatorio">
                        <form method="post" action="{{route('relatorioEmpresa')}}">
                            @csrf
                            <div class="d-flex justify-content-between">
                                <div class=" d-flex tamanhoDivSearch">
                                    <input value="{{$dadosForm['dt_inicio'] ? : '' }}" class="form-select me-2" type="date" name="dt_inicio">
                                    <input value="{{$dadosForm['dt_final'] ? : '' }}" class="form-select me-2" type="date" name="dt_final">

                                    <select class="form-select me-2" name="id_fase" aria-label="Default select example">
                                        <option value="">fases:</option>
                                        @foreach($dadosCadastroLeads['fases'] as $fases)
                                            <option {{$dadosForm['id_fase'] == $fases->id_fase ? 'selected' : '' }} value="{{$fases->id_fase}}">{{$fases->st_nomeFase}}</option>
                                        @endforeach
                                    </select>

                                    <select class="form-select " name="id_columnsKhanban" aria-label="Default select example" >
                                        <option value="">status:</option>
                                        @foreach($dadosCadastroLeads['status'] as $status)
                                            <option {{$dadosForm['id_columnsKhanban'] == $status->id_columnsKhanban ? 'selected' : '' }} value="{{$status->id_columnsKhanban}}">{{$status->st_titulo}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btnSearch border">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-2 ">
                    <button type="button" class="filtroavancancado" data-bs-toggle="modal" data-bs-target="#relatorioFiltro">
                        Filtro avançado
                    </button>
                </div>
                <div class="mt-5">
                    <table class="table table-striped table-bordered " id="example">
                        <thead>
                        <tr>
                            @if(in_array('st_nome', $colunas))<th>Nome Lead</th>@endif
                            @if(in_array('st_email', $colunas))<th>E-mail</th>@endif
                            @if(in_array('int_telefone', $colunas))<th>Telefone</th>@endif
                            @if(in_array('id_fase', $colunas))<th>Fase</th>@endif
                            @if(in_array('id_columnsKhanban', $colunas))<th>Status</th>@endif
                            @if(in_array('id_produtoServico', $colunas))<th>Prod/Serv</th>@endif
                            @if(in_array('id_campanha', $colunas))<th>Campanha</th>@endif
                            @if(in_array('id_origem', $colunas))<th>Origem</th>@endif
                            @if(in_array('id_midia', $colunas))<th>Midia</th>@endif
                            @if(in_array('id_grupo', $colunas))<th>Grupo</th>@endif
                            @if(in_array('int_temperatura', $colunas))<th>Temperatura</th>@endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($leads as $lead)
                            <tr>
                                @if(in_array('st_nome', $colunas))<td>{{$lead->st_nome}}</td>@endif
                                @if(in_array('st_email', $colunas))<td>{{$lead->st_email}}</td>@endif
                                @if(in_array('int_telefone', $colunas))<td>{{$lead->int_telefone}}</td>@endif
                                @if(in_array('id_fase', $colunas))<td>{{isset($lead->fase) ? $lead->fase->st_nomeFase : ''}}</td>@endif
                                @if(in_array('id_columnsKhanban', $colunas))<td>{{isset($lead->status) ? $lead->status->st_titulo : ''}}</td>@endif
                                @if(in_array('id_produtoServico', $colunas))<td>{{isset($lead->produto) ? $lead->produto->st_nomeProdutoServico : ''}}</td>@endif
                                @if(in_array('id_campanha', $colunas))<td>{{isset($lead->campanha) ? $lead->campanha->st_nomeCampanha : ''}}</td>@endif
                                @if(in_array('id_origem', $colunas))<td>{{isset($lead->origem) ? $lead->origem->st_nomeOrigem : ''}}</td>@endif
                                @if(in_array('id_midia', $colunas))<td>{{isset($lead->midia) ? $lead->midia->st_nomeMidia : ''}}</td>@endif
                                @if(in_array('id_grupo', $colunas))<td>{{isset($lead->grupo) ? $lead->grupo->st_nomeGrupo : ''}}</td>@endif
                                @if(in_array('int_temperatura', $colunas))<td>{{$lead->int_temperatura}}%</td>@endif
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>

    <script>

        $('#example').DataTable({
            language: {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "Nenhuma informação encontrada",
                "info": "Mostrando: _END_ de um total _TOTAL_ registros",
                "infoEmpty": "Mostrando 0  de um total de 0 registros",
                "infoFiltered": "(filtrado de um total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast":"Último",
                    "sNext":"Próximom",
                    "sPrevious": "Anterior"
                },
                "sProcessing":"Procesando...",
            },
            //para usar los botones
            responsive: "true",
            dom: 'Bfritlp',
            buttons:[
                {
                    extend:    'excelHtml5',
                    text:      '<i class="fas fa-file-excel fa-2x"></i> ',
                    filename: 'Relatorio_'+{{date("d")}}+'_'+{{date("m")}}+'_'+{{date("Y")}},
                    titleAttr: 'Exportar a Excel',
                    className: 'btn btn-success'
                },
            ]
        });
    </script>
@endsection


