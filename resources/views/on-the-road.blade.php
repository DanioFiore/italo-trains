<x-layout>

    {{-- session message start --}}
    @if(session()->has('message'))
        <div class="flex flex-row justify-center my-2 alert alert-success text-center">
            {{session('message')}}
        </div>
    @endif
    {{-- session message end --}}

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- table's container start --}}
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                {{-- intestation + last update --}}
                <div class="d-flex justify-content-between">
                    <h5>Trains on the road</h5>

                    {{-- Show the last update from the api --}}
                    <h6>Last Update {{ $last_update }}</h6>
                </div>

                {{-- table start --}}
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Train Number</th>
                            <th scope="col" class="text-center">From/To</th>
                            <th scope="col">Time/Delay</th>
                            <th scope="col">Save</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trains_schedules as $train)
                            <tr>
                                {{-- train number column --}}
                                <td class="text-danger">
                                    <i class="bi bi-train-lightrail-front"></i>
                                    {{ $train['TrainNumber'] }}
                                </td>

                                {{-- departure/arrival column --}}
                                <td class="text-center">
                                    {{ $train['DepartureStationDescription'] }} {{ $train['DepartureDate'] }}
                                    <i class="bi bi-arrow-right"></i>
                                    {{ $train['ArrivalStationDescription'] }} {{ $train['ArrivalDate'] }}
                                </td>

                                {{-- delay column --}}
                                <td>
                                    @if ($train['Distruption']['DelayAmount'] < 0)
                                    <i class="bi bi-circle-fill text-warning"></i>
                                        Early
                                    @elseif ($train['Distruption']['DelayAmount'] > 10)
                                    <i class="bi bi-circle-fill text-danger"></i>
                                        Delay:{{ $train['Distruption']['DelayAmount'] }} min
                                    @else
                                    <i class="bi bi-circle-fill text-success"></i>
                                        In time
                                    @endif
                                </td>

                                {{-- save button column --}}
                                <td>
                                    <form action="{{route('save-train')}}" method="POST">
                                        @csrf
                                        <input type="hidden" value="{{json_encode($train)}}" name="train_data">
                                        <button class="btn" type="submit">
                                            <i class="bi bi-bookmark-plus-fill text-success"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- table end --}}
            </div>
        </div>
    </div>
    {{-- table's container end --}}
    <div class="d-flex justify-content-center">
        {{$trains_schedules->links()}}
    </div>


    <script>
        
        // refresh the page every minute
        window.setTimeout(function() {
            window.location.reload();
        }, 60000);
    </script>

</x-layout>
