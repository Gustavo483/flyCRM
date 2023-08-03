<html>
<head>
    <title>My Evo Calendar</title>
    <link rel="stylesheet" type="text/css" href="css/evo-calendar.css"/>
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/board.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.3/evo-calendar/css/evo-calendar.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>

<div class="posicaoDiv w-100">
    <div class="container">
        <div class="NavbarAdmimHoot">
            @include('layouts.navBarAdminUser')
        </div>
        <div>
            @include('layouts.sucessoErrorRequest')
        </div>
        <div class=" colorgray">
            Agenda
        </div>
        <div class="my-5" id="calendar"></div>
    </div>
</div>

<!-- Add jQuery library (required) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>

<!-- Add the evo-calendar.js for.. obviously, functionality! -->
<script src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/js/evo-calendar.min.js"></script>

<script>
    $("#calendar").evoCalendar({
        theme:'Midnight Blue',
        language:'pt',
        calendarEvents: {!!  $teste !!}
        }
    );

</script>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>
