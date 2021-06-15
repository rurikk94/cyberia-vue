<h1>Buenos días <i>{{ $demo->receiver }}</i>,</h1>

<p>Se le agendó una visita con el electricista <strong>{{ $demo->sender }}<strong>.</p>
<p>La visita será el {{ $demo->inicio }} y durará hasta el {{ $demo->fin }}.</p>
<p>El trabajo se realizará en <a href="https://www.google.com/maps/place/{{ $demo->ubicacion }}" target="_blank"> {{ $demo->ubicacion }} </a>.</p>
<p>Usted puede revisar el estado de su trabajo en la siguiente página</p>
<h2> <a href="{{ $demo->url }}" target="_blank"> Consulta haciendo click aquí </a> </h2>
<p>Ingresando el codigo</p>
<h2><strong>{{ $demo->codigo_trabajo }}</strong></h2>

<p>Qué esté bien,</p>
<i>{{ $demo->sender }}</i>
<br/>
<small>Agendamiento realizado el {{ $demo->ahora }}</small>