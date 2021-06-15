Buenos días <{{ $demo->receiver }},
Se le agendó una visita del electricista {{ $demo->sender }}.
La visita será el {{ $demo->inicio }} y durará hasta el {{ $demo->fin }}.
El trabajo que realizará el electricista lo puede revisar en la siguiente página
{{ $demo->url }}
ingresando el codigo
{{ $demo->codigo_trabajo }}

Qué esté bien,

{{ $demo->sender }}

Agendamiento realizado el {{ $demo->ahora }}