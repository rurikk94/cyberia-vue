<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detalle de trabajo - Cyberia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-12">
                    <h3>Trabajo</h3>
                    </div>
                    <div class="col-3">
                        <h6>Título </h6>
                    </div>
                    <div class="col-9">
                        <h6>{{ $nombre_trabajo }} </h6>
                    </div>
                    <div class="col-12">
                        <h6>Descripción </h6>
                    </div>
                    <div class="col-12">
                        <h6>{{ $descripcion }} </h6>
                    </div>
                    <div class="col-3">
                        <h6>Código de acceso </h6>
                    </div>
                    <div class="col-9">
                        <h6>{{ $codigo_trabajo }} </h6>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-12">
                        <h3>Electricista</h3>
                    </div>
                    <div class="col-3">
                        <h6>Nombre </h6>
                    </div>
                    <div class="col-9">
                        <h6>{{ $electricista["name"] }} </h6>
                    </div>
                    @foreach($electricista["metadato"] ?? '' as $data)
                        @if( $data["key"] == 'telefono' )                        
                        <div class="col-3">
                            <h6>Teléfono </h6>
                        </div>
                        <div class="col-9">
                            <h6>{{ $data["value"] }}</h6>
                        </div>
                        @endif
                    @endforeach
                    @foreach($electricista["metadato"] ?? '' as $data)
                        @if( $data["key"] == 'email' )                      
                        <div class="col-3">
                            <h6>Email </h6>
                        </div>
                        <div class="col-9">
                            <h6>{{ $data["value"] }}</h6>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-12">
                    <h3>Cliente</h3>
                    </div>
                    <div class="col-3">
                        <h6>Nombre </h6>
                    </div>
                    <div class="col-9">
                        <h6>{{ $cliente["nombres"] }} {{ $cliente["apellidos"] }} </h6>
                    </div>
                    <div class="col-3">
                        <h6>Dirección </h6>
                    </div>
                    <div class="col-9">
                        <h6>{{ $ubicacion }}</h6>
                    </div>
                    @foreach($cliente["metadatos"] ?? '' as $data)
                        @if( $data["key"] == 'telefono' )                        
                        <div class="col-3">
                            <h6>Teléfono </h6>
                        </div>
                        <div class="col-9">
                            <h6>{{ $data["value"] }}</h6>
                        </div>
                        @endif
                    @endforeach
                    @foreach($cliente["metadatos"] ?? '' as $data)
                        @if( $data["key"] == 'email' )                      
                        <div class="col-3">
                            <h6>Email </h6>
                        </div>
                        <div class="col-9">
                            <h6>{{ $data["value"] }}</h6>
                        </div>
                        @endif
                    @endforeach
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-end">Lista de materiales creada el {{ $ahora }} </h6>
                        </div>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="col-2"></th>
                            <th scope="col">Producto</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($materiales ?? '' as $data)
                        <tr>
                            <th>
                                <img class="img-fluid" src='{{ str_replace("public/","storage/",asset($data["material"]["imagen"]))  }}' alt="" srcset="">
                            </th>
                            <th scope="row">{{ $data["material"]["nombre"] }} {{ $data["material"]["marca"] }} {{ $data["material"]["modelo"] }}</th>
                            <td>{{ $data["cantidad"] }}</td>
                            <td>${{ $data["precio"] }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <th></th>
                            <th scope="row"></th>
                            <td>Total</td>
                            <td>${{ $total }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12 text-center mb-2">
            <a href="{{ asset('') }}" target="_blank" rel="noopener noreferrer">{{ asset('') }}</a>
        </div>
    </div>
</body>
<script>
 window.print()
</script>

</html>