<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Italo</title>
</head>

<body>
    {{-- navbar start --}}
    <nav class="navbar navbar-expand-md navbar-dark bg-dark" aria-label="Fourth navbar example">
        <div class="container-fluid">
            {{-- logo icon --}}
            <a class="navbar-brand" href="{{route('welcome')}}">ITALO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample04"
                aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample04">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        {{-- welcome link --}}
                        <a class="nav-link active" aria-current="page" href="{{route('welcome')}}">Home</a>
                    </li>
                    <li class="nav-item">
                        {{-- on-the-road link --}}
                        <a class="nav-link" href="{{route('on-the-road')}}">Trains on the road</a>
                    </li>
                    <li class="nav-item">
                        {{-- trains-saved link --}}
                        <a class="nav-link" href="{{route('trains-saved')}}">Saved Trains</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>
    {{-- navbar end --}}
    {{ $slot }}
</body>

</html>
