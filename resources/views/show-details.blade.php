<x-layout>

    <div class="container mt-3">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="fs-1">Train Details</h2>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-12 text-center">
                <table class="table">
                    <tbody>
                        <tr>
                            <th scope="row">Train Number</th>
                            <td>{{$trainToShow->number}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Departure From</th>
                            <td>{{$trainToShow->departure_place}} | {{ (new DateTime($trainToShow->departure_time))->format('H:i') }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Arrival To</th>
                            <td>{{$trainToShow->arrival_place}} | {{ (new DateTime($trainToShow->arrival_time))->format('H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Stations</th>
                            <td>
                                @foreach ($stations as $station)
                                    {{$station->name}}: Arrival: {{ (new DateTime($station->arrival_time))->format('H:i') }} - Departure:
                                    {{ (new DateTime($station->departure_time))->format('H:i') }}
                                    <br>
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <a href="{{route('trains-saved')}}" class="btn btn-danger">Go Back</a>
            </div>
        </div>
    </div>

</x-layout>
