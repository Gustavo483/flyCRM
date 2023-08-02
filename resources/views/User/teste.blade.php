<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

{{--    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">--}}
    {{-- <link rel="icon" href="{{ asset('favicon.svg') }}" sizes="any" type="image/svg+xml"> --}}
{{--    <link rel="stylesheet" href="{{ asset('css/project-all.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('css/board.css') }}">

    <title>Khanban</title>
</head>

<body>
<div>
    <main>
        <div id="projeto-id" style="display: none">12</div>
        @csrf
        <section>
            @foreach ($columns as $column)
                <article data-column-id="{{ $column->id_columnsKhanban }}">
                    <div class="coluna-head">
                        <label class="faixa-roxo">{{ $column->st_titulo }}</label>
                        <div class="add-tarefa" data-column="{{ $column->id_columnsKhanban }}">
                            <svg width="25" height="25" fill="currentColor" viewBox="0 0 16 16"><path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z"/></svg>
                            <div>Adicionar tarefa</div>
                        </div>
                    </div>

                    <div class="coluna-body">
                        @foreach ($column->leads as $leads)
                            <div class="tarefa bg red" data-position="{{ $leads->int_posicao }}" data-id="{{ $leads->id_lead }}" draggable="true">
                                <div class="nome">{{ $leads->st_nome }}</div>
                                <div class="prioridade"><svg fill="#DB3E34" width="16" height="16" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/></svg></div>
                                <div class="verificar"><svg width="16" height="16" viewBox="0 0 16 16"><path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/></svg>07/02</div>
                                <div class="termino"><svg width="16" height="16" viewBox="0 0 16 16"><path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z"/><path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg>15/02</div>
                                <div class="etiqueta">
                                </div>
                                <div class="designado"><img class="perfil" src="https://images.unsplash.com/photo-1511367461989-f85a21fda167?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MXx8c2lsaG91ZXR0ZXxlbnwwfHwwfHw%3D&w=300" alt="\o/"></div>
                            </div>
                        @endforeach

                        <div class="coluna-footer"></div>
                    </div>
                </article>
            @endforeach
        </section>


    </main>
</div>

<script src="{{ asset('js/board.js') }}"></script>
</body>
</html>
