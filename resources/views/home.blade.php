<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tourist App</title>

        <!-- Scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/travelinfo.js') }}"></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
            .weather p {
                line-height: 0.8;
            }
            .place p {
                line-height: 1;
            }

            .overlay {
                position: fixed;
                width: 100%;
                height: 100%;
                z-index: 1000;
                top: 0;
                left: 0px;
                opacity: 0.5;
                filter: alpha(opacity=50);
                background-color: white;
            }
            .hidden {
                display: none;
            }
        </style>
    </head>
    <body>
        <div class="overlay">
            <div style="position: fixed; top: 45%; left: 45%;">  
                <div class="spinner-border align-middle" role="status" style="width: 4rem; height: 4rem; z-index: 20;">
                </div>
            </div>
        </div>
        <div class="mb-4">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="p-4">
                </div>
            </nav>
        </div>
        <div class="container">
            <div class="row mb-2">
                <div class="col-12">
                    <div class="form-floating">
                        <select class="form-select form-select-lg" id="cities">
                            @foreach($city_list as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                        <label for="cities">Select City</label>
                    </div>
                </div>
            </div>
            <div class="row travel-info">
                <div class="col-lg-6 col-sm-12 border rounded-3 weather">
                    <div class="text-center">
                        <h1>Weather Forecast</h1>
                        <div class="row mb-2">
                            <div class="col-6">
                                <p class="text-start fs-2" id="weather_name"></p>
                                <p class="text-start fs-5" id="weather_desc"></p>
                            </div>
                            <div class="col-6">
                                <p class="text-end fs-2" id="temperature"></p>
                                <p class="text-end fs-5" id="temperature_feels_like"></p>
                            </div>
                        </div>
                        </br>
                        <div class="row mb-2">
                            <div class="col-4">
                                <label class="col-form-label">Wind Speed</label>
                                <p class="fs-4" id="wind_speed"></p>
                            </div>
                            <div class="col-4">
                                <label class="col-form-label">Humidity</label>
                                <p class="fs-4" id="humidity"></p>
                            </div>
                            <div class="col-4">
                                <label class="col-form-label">Visibility</label>
                                <p class="fs-4" id="visibility"></p>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                <label class="col-form-label">Wind Degree</label>
                                <p class="fs-4" id="wind_degree"></p>
                            </div>
                            <div class="col-6">
                                <label class="col-form-label">Cloudiness</label>
                                <p class="fs-4" id="cloudiness"></p>
                            </div>
                        </div>
                        </br></br>
                        <div class="row mb-2">
                            <div class="col-6">
                                <label class="col-form-label">Sunrise</label>
                                <p class="fs-4" id="sunrise"></p>
                            </div>
                            <div class="col-6">
                                <label class="col-form-label">Sunset</label>
                                <p class="fs-4" id="sunset"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 border rounded-3 place">
                    <div class="text-center">
                        <h1>Place Information</h1>
                        <h2>Tourist Information and Service List<h2>
                        <div id="place_details">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#cities").trigger('change');
            });
            $("#cities").on('change', function() {
                let city = $("#cities option:selected").val();
                $.ajax({
                    type: "POST",
                    url: "travel_info",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'city': city,
                    },
                    beforeSend: function(){
                        $('.overlay').removeClass('hidden');
                        $('.travel-info').addClass('hidden');
                    },
                    success: function(result) {
                        printWeatherInfo(result.weather);
                        printPlaceInfo(result.place);
                    },
                    complete: function(){
                        $('.overlay').addClass('hidden');
                        $('.travel-info').removeClass('hidden');
                    }
                });
            });
        </script>
    </body>
</html>