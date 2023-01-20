<?php

namespace App\Http\Controllers;

use App\Models\Train;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TrainSavedController extends Controller
{
     // save a single train into the db
     public function saveTrain(Request $request) {
        
        // decode the $train data arriving from the $request from the input type hidden in the on-the-road page. It's an array so i encode it and after decode it
        $trainData = json_decode($request->train_data);

        // validation start
        // create a custom validation for validate the time
        Validator::extend('time', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $value);
        });
        
        // validation
        $validator = Validator::make((array)$trainData, [
            'TrainNumber' => 'required|max:4',
            'DepartureStationDescription' => 'required|string',
            'DepartureDate' => 'required|date',
            'ArrivalStationDescription' => 'required',
            'ArrivalDate' => 'required|time',
            'Distruption.*.DelayAmount' => 'required|numeric',
            'Stations.*.LocationDescription' => 'required|string',
            'Stations.*.ActualArrivalTime' => 'required|time',
            'Stations.*.ActualDepartureTime' => 'required|time',
        ]);
        
        // manage the errors from the validation
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // validation end

        // again captured the $train because, i don't know why, but after the validation, LocationDescription, ActualArrivalTime and ActualDepartureTime be NULL
        $trainData = json_decode($request->train_data);

        $train = new Train;

        // capture the current date for save the departure date of the train
        $current_date = date('Y-m-d');

        // save every date in the trains table
        $train->updateOrCreate([
            'number'=> $trainData->TrainNumber,
            'departure_place'=> $trainData->DepartureStationDescription,
            'departure_time'=> $trainData->DepartureDate,
            'departure_date'=> $current_date,
            'arrival_place'=> $trainData->ArrivalStationDescription,
            'arrival_time'=> $trainData->ArrivalDate,
            'delay'=> $trainData->Distruption->DelayAmount,
        ]);

        // capture the right train to save the correct id in the stations for the one to many relation
        $train_to_match = Train::where([
            ['number', $trainData->TrainNumber],
            ['departure_date', $current_date]
        ])->first();
        
        $rawStations = $trainData->Stations;
        // save every station in the stations table
        foreach ($rawStations as $station) {
            $train_to_match->stations()->updateOrCreate([
                'name' => $station->LocationDescription,
                'arrival_time' => $station->ActualArrivalTime,
                'departure_time' => $station->ActualDepartureTime,
            ]);
        }

        // $pagination is used for guarantee that the current pagination will not be lost after a request
        $pagination = request()->get('pagination');

        return redirect()->back()->with([
            'message' => 'Train saved successfully!',
            'pagination' => $pagination
        ]); 
    }


    // show all the details of a single record
    public function showDetails(Request $request) {
        $number = $request->train_number;
        $train = Train::where('number', $number)->get();
        $trainToShow = $train[0];
    
        $stations = Station::where('train_id', $trainToShow->id)->get();
        // dd($stations);
        return view('show-details',[
            'trainToShow' => $trainToShow,
            'stations' => $stations,
        ]);
    }

    // pass to the trains-saved view all the train into the db in descendent order and paginated
    public function trainsSaved() {

        return view("trains-saved", [
            'savedTrains' => Train::OrderBy('departure_time', 'desc')->paginate(10)
        ]);
    }

    // return the record filtered in a specific date
    public function filterTrain(Request $request) {
        
        // capture the specific date and number from the request
        $dateFiltered = $request->filterDate;
        $numberFiltered = $request->filterNumber;
        
        // differentiate the result that will be shown based of the user input, in the first case, we manage if date and number will both be inserted, in the second case only the date and in the third case only the number
        if($dateFiltered && $numberFiltered) {

            $savedTrains = Train::OrderBy('departure_time', 'desc')->where([
                [
                    'departure_date', 'LIKE', '%' . $dateFiltered . '%'
                ],
                [
                    'number', 'LIKE', '%' . $numberFiltered . '%'
                ]
            ])->paginate(10);
        } else if($dateFiltered) {

            $savedTrains = Train::OrderBy('departure_time', 'desc')->where('departure_date', 'LIKE', '%' . $dateFiltered . '%')->paginate(10);
        } else if($numberFiltered) {

            $savedTrains = Train::OrderBy('departure_time', 'desc')->where('number', 'LIKE', '%' . $numberFiltered . '%')->paginate(10);
        }

        return view("trains-saved", [
            'savedTrains' => $savedTrains, 
            'dateFiltered' => $dateFiltered,
            'numberFiltered' => $numberFiltered,
        ]);
    }

    // delete a single train
    public function deleteSavedTrain(Request $request) {
        $number = $request->train_number;
        Train::where('number', $number)->delete();

        // used $pagination for not loose the current pagination after a request
        $pagination = request()->get('pagination');

        return redirect()->back()->with([
            'message', 'Train deleted successfully!',
            'pagination' => $pagination
        ]);
    }
}
