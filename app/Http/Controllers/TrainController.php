<?php

namespace App\Http\Controllers;

use App\Models\Train;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;


class TrainController extends Controller
{
    // call the api and pass the data to the view on-the-road
    public function onTheRoad() {  

        $response = Http::get('https://italoinviaggio.italotreno.it/api/TreniInCircolazioneService');

        // last update
        $last_update = $response->json(["LastUpdate"]);

        // trains schedules
        $data = $response->json(["TrainSchedules"]);

        // call to paginate method
        $trains_schedules = $this->paginate($data);
        return view("on-the-road", [
            'last_update' => $last_update, 
            'trains_schedules' => $trains_schedules,
        ]);
    }

    // paginator
    public function paginate($items, $perPage = 10, $page = null, $options = []) {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options = [
            'path' => Paginator::resolveCurrentPath()
        ]);
    }
}
