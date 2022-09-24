<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TravelInformationController extends Controller
{

    public function index(){
        //cities: Tokyo, Yokohama, Kyoto, Osaka, Sapporo, Nagoya
        $city_list = ['Tokyo', 'Yokohama', 'Kyoto', 'Osaka', 'Sapporo', 'Nagoya'];

        return view("home", ["city_list" => $city_list]);
    }

    public function getTravelInformation(Request $request){
        $city_name = $request->input()['city'];
        $travel_info = [];
        $travel_info['weather'] = $this->getWeatherForecast($city_name)->json();
        $travel_info['place'] = $this->getPlaceInformation($city_name)->json();

        return $travel_info;
    }

    public function getWeatherForecast($city_name){
        $response = Http::get('api.openweathermap.org/data/2.5/weather', [
            'q' => $city_name,
            'units' => 'metric',
            'APPID' => env('OPENWEATHERMAP_APP_ID'),
        ]);

        return $response;
    }

    public function getPlaceInformation($city_name){
        $response = Http::withHeaders([
            'Authorization' => env('FOURSQUARE_APP_ID'),
        ])->get('https://api.foursquare.com/v3/places/search', [
            'near' => $city_name,
            'limit'=> 5,
            'categories' => 19028, //Category: Tourist Information and Service
        ]);

        return $response;
    }
}
