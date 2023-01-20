<x-layout>

    {{-- session message start --}}
    @if (session()->has('message'))
        <div class="flex flex-row justify-center my-2 alert alert-success text-center">
            {{ session('message') }}
        </div>
    @endif
    {{-- session message end --}}

    {{-- title container start --}}
    <div class="container mt-3">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="fs-1">Trains Saved</h2>
            </div>
        </div>
    </div>
    {{-- title container end --}}

    {{-- filter form start --}}
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="{{route('filter-train')}}" method="GET">
                    @csrf
                    <label for="filterDate">Filter the trains saved in a specific date</label>
                    <input value="{{isset($dateFiltered) ? $dateFiltered : 'gg/mm/aaaa'}}" type="date" name="filterDate" id="filterDate">
                    <label for="filterNumber">Or for a specific train number</label>
                    <input value="{{isset($numberFiltered) ? $numberFiltered : ''}}" type="search" name="filterNumber" id="filterNumber" placeholder="Search">
                    <br>
                    <button type="submit" class="btn btn-success">Go</button>
                </form>
                <a href="{{route('trains-saved')}}">Reset Filter</a>
            </div>
        </div>
    </div>
    {{-- filter form end --}}

    {{-- table's container start --}}
    <div class="container">
        <div class="row">
            <div class="col-12">

                {{-- table start --}}
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Train Number</th>
                            <th scope="col" class="text-center">From/To</th>
                            <th scope="col">Departure Date</th>
                            <th scope="col">Details</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($savedTrains as $train)
                            <tr>
                                {{-- train number column --}}
                                <td class="text-danger">
                                    <i class="bi bi-train-lightrail-front"></i>
                                    {{ $train['number'] }}
                                </td>

                                {{-- departure/arrival column --}}
                                <td class="text-center">
                                    {{ $train['departure_place'] }} {{ (new DateTime($train['departure_time']))->format('H:i') }}
                                    <i class="bi bi-arrow-right"></i>
                                    {{ $train['arrival_place'] }} {{ (new DateTime($train['arrival_time']))->format('H:i') }}
                                </td>

                                {{-- date time column --}}
                                <td>
                                    {{ \Carbon\Carbon::parse($train['departure_date'])->format('d-m-Y') }}
                                </td>

                                {{-- delay column --}}
                                <td>
                                    @if ($train['delay'] < 0)
                                    <i class="bi bi-circle-fill text-warning"></i>
                                        Early
                                    @elseif ($train['delay'] > 10)
                                    <i class="bi bi-circle-fill text-danger"></i>
                                        Delay:{{ $train['delay'] }} min
                                    @else
                                    <i class="bi bi-circle-fill text-success"></i>
                                        In time
                                    @endif
                                </td>

                                {{-- details column --}}
                                <td>
                                    <form action="{{route('show-details')}}" method="GET">
                                        @csrf
                                        <input type="hidden" value="{{$train["number"]}}" name="train_number">
                                        <button type="submit" class="btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </td>

                                {{-- delete button column --}}
                                <td>
                                    <form action="{{route('delete-train')}}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <input type="hidden" value="{{$train["number"]}}" name="train_number">
                                        <button class="btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="red" class="bi bi-file-x-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM6.854 6.146 8 7.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 8l1.147 1.146a.5.5 0 0 1-.708.708L8 8.707 6.854 9.854a.5.5 0 0 1-.708-.708L7.293 8 6.146 6.854a.5.5 0 1 1 .708-.708z" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        {{-- if there is no record shown --}}
                        @empty
                            <div class="col-12">
                                <div class="alert alert-black py-3">
                                    <p class="lead">No Trains saved</p>
                                </div>
                            </div>
                        @endforelse
                    </tbody>
                </table>
                {{-- table end --}}
            </div>
            <div class="d-flex justify-content-center">
                {{$savedTrains->links()}}
            </div>
        </div>
    </div>
    {{-- table's container end --}}

</x-layout>
