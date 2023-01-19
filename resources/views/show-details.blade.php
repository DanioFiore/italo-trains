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
                            <td>{{$trainToShow->departure_place}} | {{$trainToShow->departure_time}}</td>
                            
                        </tr>
                        <tr>
                            <th scope="row">Arrival To</th>
                            <td>{{$trainToShow->arrival_place}} | {{$trainToShow->arrival_time}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Stations</th>
                            <td>{{$trainToShow->stations}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <a href="{{route('trains-saved')}}" class="btn btn-danger">Go Back</a>
    </div>

</x-layout>
