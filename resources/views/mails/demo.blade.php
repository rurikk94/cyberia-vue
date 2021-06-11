Buenos días <i>{{ $demo->receiver }}</i>,
<p>Se le agendó una visita del electricista {{ $demo->sender }}.</p>
<p>La visita será el {{ $demo->inicio }} y durará hasta el {{ $demo->fin }}.</p>
<p>El trabajo que realizará el electricista lo puede revisar en la siguiente página</p>
<p> <a href="{{ $demo->url }}" target="_blank"> {{ $demo->url }} </a> </p>
<p>ingresando el codigo</p>
<p>{{ $demo->codigo_trabajo }}</p>

Qué esté bien,
<br/>
<i>{{ $demo->sender }}</i>