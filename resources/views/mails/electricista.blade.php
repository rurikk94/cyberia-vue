Buenos días <i>{{ $demo->receiver }}</i>,
<p>Le recordamos que usted agendó una visita al cliente {{ $demo->receiver }}.</p>
<p>La visita será el {{ $demo->inicio }} y durará hasta el {{ $demo->fin }}.</p>
<p>El trabajo se realizará en <a href="https://www.google.com/maps/place/{{ $demo->ubicacion }}" target="_blank"> {{ $demo->ubicacion }} </a>.</p>
<p>El trabajo que realizará el electricista lo puede revisar en la siguiente página</p>
<p> <a href="{{ $demo->url }}" target="_blank"> {{ $demo->url }} </a> </p>
<p>ingresando el codigo</p>
<p>{{ $demo->codigo_trabajo }}</p>
<br/>
<p>Qué esté bien,</p>
<br/>
<i>{{ $demo->sender }}</i>
<br/>
<small>Agendamiento realizado el {{ $demo->ahora }}</small>