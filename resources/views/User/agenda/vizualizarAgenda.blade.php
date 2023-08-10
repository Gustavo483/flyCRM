<html>
<head>
    <title>Agenda</title>
    <link rel="stylesheet" type="text/css" href="css/evo-calendar.css"/>
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/board.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.3/evo-calendar/css/evo-calendar.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>

<div class="posicaoDiv w-100 tamanhoDivConteudo">
    <div class="container">
        <div class="NavbarAdmimHoot">
            @include('layouts.navBarUser')
        </div>
        <div>
            @include('layouts.sucessoErrorRequest')
        </div>
        <div class="d-flex pt-3 justify-content-between align-items-center">
            <div class=" colorgray">
                Agenda
            </div>
            <button type="button" class=" BtnConfig2 m-0" data-bs-toggle="modal"
                    data-bs-target="#AdicionarDadoCalendario">
                Adicionar
            </button>
        </div>
        <div class="modal fade" id="AdicionarDadoCalendario" data-bs-backdrop="static" data-bs-keyboard="false"
             tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header ">
                        <h5 class="modal-title colorTitle" id="staticBackdropLabel">Adicionar dados na agenda</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{route('registrarAtividadeAgendaUser')}}">
                            @csrf
                            <label>Registrar em mais de um dia:</label>
                            <select class="form-control" id="periodicidade" name="periodo" onchange="testeFuncao()">
                                <option value="0">Não</option>
                                <option value="1">Sim</option>
                            </select>

                            <div id="divPeriodicidade" class="my-3 none">
                                <label>Período:</label>
                                <div class="d-flex">
                                    <input type="date" class="form-control none" placeholder="Data:" name="st_datainicio">
                                    <input type="date" class="form-control none" placeholder="Data:" name="st_dataFinal">
                                </div>
                            </div>

                            <div id="divPeriodicidadeDia" class="my-3">
                                <label>Data:</label>
                                <input type="date" class="form-control" placeholder="Data:" name="st_data">
                            </div>

                            <div class="my-3">
                                <label>Título:</label>
                                <input type='text' class="form-control"  name="st_titulo" value="{{ old('st_titulo') }}" required>
                            </div>
                            <div class="my-3">
                                <label>Descrição :</label>
                                <input type='text' class="form-control"  name="st_descricao" value="{{ old('st_descricao') }}" required>
                            </div>

                            <div class="my-3">
                                <label>Selecione a cor :</label>
                                <input type='color' class="inputColors" name="st_color" value="{{ old('st_color') }}" required>
                                <div id="email" class="colorRed">
                                    {{ $errors->has('st_color') ? $errors->first('st_color') : '' }}
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="BtnBlue my-3">Adicionar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-5" id="calendar"></div>
    </div>
</div>
<div class="my-5 d-flex justify-content-center">
    <img class="imgLogo" src="{{asset('imgs/logo_temporaria.png')}}">
</div>
<script src="{{asset('js/script.js')}}"></script>
<!-- Add jQuery library (required) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>

<!-- Add the evo-calendar.js for.. obviously, functionality! -->
<script src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/js/evo-calendar.min.js"></script>

<script>
    $("#calendar").evoCalendar({
            theme:'Midnight Blue',
            language:'pt',
            calendarEvents: {!!  $dadosAgenda !!}
        }
    );

</script>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>
