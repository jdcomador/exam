<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TravelInformationController extends Controller
{

    public function index(){
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
        //cities: Tokyo, Yokohama, Kyoto, Osaka, Sapporo, Nagoya
        //api key: 40be2cbc0bf5e2579c44d3ca114d4f4e
        $response = Http::get('api.openweathermap.org/data/2.5/weather', [
            'q' => $city_name,
            'units' => 'metric',
            'APPID' => '40be2cbc0bf5e2579c44d3ca114d4f4e',
        ]);

        return $response;
    }

    public function getPlaceInformation($city_name){
        //cities: Tokyo, Yokohama, Kyoto, Osaka, Sapporo, Nagoya
        //api key: fsq3kxj5EveT1BkEQLoch2fUyjYOIxUpBex5Gi0rTOdlizA=

        $response = Http::withHeaders([
            'Authorization' => 'fsq3kxj5EveT1BkEQLoch2fUyjYOIxUpBex5Gi0rTOdlizA=',
        ])->get('https://api.foursquare.com/v3/places/search', [
            'near' => $city_name,
            'limit'=> 5,
            'categories' => 19028, //Category: Tourist Information and Service
        ]);

        return $response;
    }
}
